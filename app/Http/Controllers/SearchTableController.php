<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CashApp;
use App\Models\CashAppForm;
use App\Models\Form;
use App\Models\FormBalance;
use App\Models\FormGame;
use App\Models\FormRedeem;
use App\Models\FormRefer;
use App\Models\LanguageText;
use App\Models\FormTip;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Response;

class SearchTableController extends Controller
{
    public function table(Request $request)
    {
        try{
            $forms = Form::orderBy('full_name', 'asc')->get()->toArray();
            $games = Account::where('status', 'active')->get()->toArray();
            $activeGame = isset($_GET['game']) ? $_GET['game'] : '';
            $activeCashApp = isset($_GET['cash_app']) ? $_GET['cash_app'] : '';

            if (empty($activeGame))
            {
                if ($request->ajax()) {
                    $activeGameDefault = Account::where('id',$request->activeGameId)->first()->toArray();
                    $activeGame = $activeGameDefault['title'];
                }
                else{
                    $activeGameDefault = Account::first()->toArray();
                    $activeGame = $activeGameDefault['title'];
                }
            }
            if (empty($activeCashApp))
            {
                $cash_app_default = CashApp::first()->toArray();
                $activeCashApp = $cash_app_default['title'];
            }

            $activeGame = Account::where([['title', $activeGame], ['status', 'active']])->with('formGames')
            ->first()
            ->toArray();
            // dd($activeGame);
            $formGames = FormGame::where('account_id', $activeGame['id'])->whereHas('form')->with('form')->orderBy('game_id','asc');

            $cashApp = CashApp::where([['status', 'active']])->get()
            ->toArray();

            $activeCashApp = CashApp::where([['title', $activeCashApp], ['status', 'active']])->first()
            ->toArray();

            $final = [];
            if (!empty($activeGame['form_games']))
            {
                foreach ($activeGame['form_games'] as $a => $b)
                {
                    $tip = FormTip::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $refer = FormRefer::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $cash = CashAppForm::where('form_id', $b['form']['id'])->where('cash_app_id', $activeCashApp['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $balance = FormBalance::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $redeem = FormRedeem::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $b['cash_app'] = $cash;
                    $b['tip'] = $tip;
                    $b['refer'] = $refer;
                    $b['balance'] = $balance;
                    $b['redeem'] = $redeem;
                    array_push($final, $b);
                }
                $activeGame['form_games'] = $final;
            }
            // dd(Auth::user()->id);
            // $history = History::where('account_id', $activeGame['id'])->where('created_by', Auth::user()->id)->with('form')
            // ->with('account')->with(['formGames' => function ($query) use ($activeGame)
            // {
            //     $query->where('account_id', $activeGame['id']);
            // }
            // ])
            // ->orderBy('id', 'desc')
            // ->get()
            // ->toArray();
            $history = History::where('account_id', $activeGame['id'])->with('form')
            ->with('account')->with(['formGames' => function ($query) use ($activeGame)
            {
                $query->where('account_id', $activeGame['id']);
            }
            ])
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
            // dd($activeCashApp);
            $form_games = FormGame::orderBy('id', 'desc')->with('form')->whereHas('form')->get()->toArray();

            if ($request->ajax()) {
                $indicator = null;
                $formGames = FormGame::where('account_id', $request->activeGameId)->whereHas('form')->with('form')->orderBy('game_id','asc');
                if(strlen($request->value) > 3){
                    $formGames = $formGames->keywordSearch($request->value)->paginate(10)->setPath('');
                    $pagination = $formGames->appends(array(

                    ));
                    if($formGames->isEmpty()){
                        $indicator = 'Data Not Found';
                    }
                }else{
                    $formGames = $formGames->paginate(10)->setPath('');
                    $pagination = $formGames->appends(array(
                        'game' => request()->get('game')
                    ));
                }
                return view('newLayout.components.listTable', ['activeGame' => $activeGame, 'activeCashApp' => $activeCashApp,'form_games' => $form_games,'formGames' => $formGames, 'indicator' => $indicator]);
            }else{
                $formGames = $formGames->paginate(10)->setPath('');
                $pagination = $formGames->appends(array(
                    'game' => request()->get('game')
                ));

                //languages
                $role = 'cashier';
                // if(Auth::user()->role == $role){
                    $texts = LanguageText::get()->toArray();
                    $arranged_texts = [];
                    foreach($texts as $def => $fgh){
                        $arranged_texts[$fgh['input']] = $fgh['output'];
                    }
                    $language_texts = $arranged_texts;
                // }else{
                //     $language_texts = [
                //         'total-players' => 'TOTAL PLAYERS',
                //         'games' => 'Games',
                //         'authors-table' => 'Just Search The Player Name',
                //         'selected-date' => 'Selected Date',
                //         'add-user' => 'ADD USER',
                //         'sn' => 'SN',
                //         'game-id' => 'GAME ID',
                //         'fb-name' => 'FB NAME',
                //         'balance' => 'BALANCE',
                //         'bonus' => 'BONUS',
                //         'redeem' => 'REDEEM',
                //         'tips' => 'TIPS',
                //         'action' => 'ACTION',
                //         'amount' => 'Amount'
                //     ];

                // }
            return view('newLayout.table', compact('forms','language_texts', 'games', 'activeGame', 'history', 'activeCashApp', 'cashApp', 'formGames','form_games'));

                // return response()->json(['forms'=>$forms,'language_texts'=>$language_texts,'games'=>$games, 'activeGame'=>$activeGame, 'history'=>$history, 'activeCashApp'=>$activeCashApp, 'cashApp'=>$cashApp, 'formGames'=>$formGames, 'form_games' => $form_games]);
            }
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
             dd($bug);
            return Response::json(['error' => $bug], 404);
        }
    }
     public function tables(){
        $url = route('api.table');
        $response = Http::get($url);
        $data = json_decode($response->body(), true);
        // dd($data);
        // echo "<pre>";
        // print_r($response->body());
        // echo "</pre>";
        // die;
        $forms = $data['forms'];
        $language_texts = $data['language_texts'];
        $games = $data['games'];
        $activeGame = $data['activeGame'];
        $history = $data['history'];
        $activeCashApp = $data['activeCashApp'];
        $cashApp = $data['cashApp'];
        $formGames = $data['formGames'];
        $form_games = $data['form_games'];
        // dd($forms);
        return view('newLayout.table', compact('forms','language_texts', 'games', 'activeGame', 'history', 'activeCashApp', 'cashApp', 'formGames','form_games'));
        // return view('string')
        // dd($response);
        if ($response->successful()) {
            // Parse and process the response data
            $data = $response->json(); // Assuming the API returns JSON data

            // Process $data as needed

            return response()->json($data); // Return the API response to the client
        } else {
            // Handle the API request failure
            return response()->json(['error' => 'Failed to fetch data from Project A API'], $response->status());
        }
     }
    public function tableSearch(Request $request)
    {
        //return 'asdf';
        try
        {
            $activeGame = isset($_GET['game']) ? $_GET['game'] : '';
            $activeCashApp = isset($_GET['cash_app']) ? $_GET['cash_app'] : '';

            if (empty($activeGame))
            {
                // if ($request->ajax()) {
                    $activeGame = Account::where(['id' => $request->activeGameId, 'status' => 'active'])
                                        ->with('formGames')
                                        ->first()
                                        ->toArray();
                    // $activeGame = $activeGameDefault['title'];
                // }
                // else{
                //     $forms = Form::orderBy('full_name', 'asc')->get()->toArray();
                //     $games = Account::where('status', 'active')->get()->toArray();

                //     $activeGameDefault = Account::first()->toArray();
                //     $activeGame = $activeGameDefault['title'];
                // }
            }
            if (empty($activeCashApp))
            {
                $cash_app_default = CashApp::first()->toArray();
                $activeCashApp = $cash_app_default['title'];
            }

            // $activeGame = Account::where([['title', $activeGame], ['status', 'active']])
            //                         ->with('formGames')
            //                         ->first()
            //                         ->toArray();
            // dd($activeGame);
            $formGames = FormGame::where('account_id', $activeGame['id'])->whereHas('form')->with('form')->orderBy('game_id','asc');

            $cashApp = CashApp::where([['status', 'active']])->get()
            ->toArray();

            $activeCashApp = CashApp::where([['title', $activeCashApp], ['status', 'active']])->first()
            ->toArray();

            $final = [];
            // if (!empty($activeGame['form_games']))
            // {
            //     foreach ($activeGame['form_games'] as $a => $b)
            //     {
            //         $tip = FormTip::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
            //         $refer = FormRefer::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
            //         $cash = CashAppForm::where('form_id', $b['form']['id'])->where('cash_app_id', $activeCashApp['id'])->where('account_id', $activeGame['id'])->sum('amount');
            //         $balance = FormBalance::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
            //         $redeem = FormRedeem::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
            //         $b['cash_app'] = $cash;
            //         $b['tip'] = $tip;
            //         $b['refer'] = $refer;
            //         $b['balance'] = $balance;
            //         $b['redeem'] = $redeem;
            //         array_push($final, $b);
            //     }
            //     $activeGame['form_games'] = $final;
            // }


            $indicator = null;
            $formGames = FormGame::where('account_id', $request->activeGameId)->whereHas('form')->with('form')->orderBy('game_id','asc');
            if(strlen($request->value) > 3){
                $formGames = $formGames->keywordSearch($request->value)->paginate(10)->setPath('');
                $pagination = $formGames->appends(array(

                ));
                if($formGames->isEmpty()){
                    $indicator = 'Data Not Found';
                }
            }else{
                $formGames = $formGames->paginate(10)->setPath('');
                $pagination = $formGames->appends(array(
                    'game' => request()->get('game')
                ));
            }

            //languages
            $role = 'cashier';
            if(Auth::user()->role == $role){
                $texts = LanguageText::get()->toArray();
                $arranged_texts = [];
                foreach($texts as $def => $fgh){
                    $arranged_texts[$fgh['input']] = $fgh['output'];
                }
                $language_texts = $arranged_texts;
            }else{
                $language_texts = [
                    'total-players' => 'TOTAL PLAYERS',
                    'games' => 'Games',
                    'authors-table' => 'Just Search The Player Name',
                    'selected-date' => 'Selected Date',
                    'add-user' => 'ADD USER',
                    'sn' => 'SN',
                    'game-id' => 'GAME ID',
                    'fb-name' => 'FB NAME',
                    'balance' => 'BALANCE',
                    'bonus' => 'BONUS',
                    'redeem' => 'REDEEM',
                    'tips' => 'TIPS',
                    'action' => 'ACTION',
                    'amount' => 'Amount'
                ];

            }
            return view('newLayout.components.listTable', [
                'activeGame' => $activeGame,
                'activeCashApp' => $activeCashApp,
                'formGames' => $formGames,
                'indicator' => $indicator,
                'language_texts' => $language_texts
            ]);

        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            // dd($bug);
            return Response::json(['error' => $bug], 404);
        }
    }
}
