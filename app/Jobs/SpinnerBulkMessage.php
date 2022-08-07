<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Mail;
use App\Mail\spinnerBulkMail;
use App\Mail\crossedPlayers;
use App\Models\Form;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\History;
use App\Models\FormGame;
use Illuminate\Support\Str;

class SpinnerBulkMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function build()
    {
        return $this->markdown('mails.spinnerBulkMessage');
    }
    public function handle()
    {
        // spinnerBulkMessage

        $type = $this->details['type'];
        $message = $this->details['message'];
        $limit_amount = $this->details['limit_amount'];
        

        $year = date('Y');
        $month = date('m');
        if($month != 1){
            $month = $month - 1;
        }else{
            $month = 12;

        }
        // if($month >10){
        //     $month = '0'.$month;
        // }
        $filter_start = $year.'-'.$month.'-01';
        // $filter_end = Carbon::now();
        $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-01'));
        // Log::info('filter_start: '.json_encode($filter_start));
        // Log::info('filter_end: '.json_encode($filter_end));

        // $month = date('m');
        // if($month >10){
        //     $month = '0'.$month;
        // }
        // $filter_start = '2022-'.$month.'-01';
        // $filter_end = Carbon::now();

        $history = History::with('account')->with('form')
                            ->whereHas('form')
                            ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                            ->with('created_by')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();

        $final = [];
        $forms = [];
        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
                // $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                // if (!empty($form_game))
                // {
                    // $form = Form::where('id', $b['form_id'])->first();
                    // if (!empty($form))
                    // {
                        // $form_game->toArray();
                        // $form->toArray();
                        if (!(isset($final[$b['form_id']])))
                        {
                            $final[$b['form_id']] = [];
                        }
                        $final[$b['form_id']]['form_id'] = $b['form_id'];
                        $final[$b['form_id']]['spinner_key'] = $b['form']['token'];
                        $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
                        $final[$b['form_id']]['number'] = $b['form']['number'];
                        $final[$b['form_id']]['email'] = $b['form']['email'];
                        $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];
                    // }

                    if (isset($final[$b['form_id']]['totals']))
                    {
                        $totals['load'] = $final[$b['form_id']]['totals']['load'];
                        // $totals['tip'] = $final[$b['form_id']]['totals']['tip'];
                        // $totals['redeem'] = $final[$b['form_id']]['totals']['redeem'];
                        // $totals['refer'] = $final[$b['form_id']]['totals']['refer'];
                        // $totals['cashAppLoad'] = $final[$b['form_id']]['totals']['cashAppLoad'];
                    }
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);

                    // ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    // ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    // ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    // ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);
                    $final[$b['form_id']]['totals'] = $totals;                    
                // }
            }
        }
        // $key = key($final);
        // $second = array_slice($final, 1, 1, true);
        // $second_key = key($second);
        foreach ($final as $a => $b){
            // if($a == $key || $a == $second_key){
                $input['email'] = $b['email'];
                $input['name'] = $b['full_name'];
                $input['load'] = $b['totals']['load'];

                $token_id = $b['spinner_key'];
                $form = [
                    'name' => $input['name'],
                    'message' => $message,
                    'message-end' => '',
                    'limit_amount' => $limit_amount,
                    'load' => $input['load'],
                    'type' => $type,
                    'subject' => '',
                    'token_id' => $token_id,
                    'load-remaining' => 0
                ];

                if($type == 'above-'.$limit_amount){
                    $form['subject'] = 'Noor Games - Eligible For Spinner';
                    try
                        {
                            // Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                            Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type above-'.$limit_amount);
                        }
                    catch(\Exception $e)
                        {
                            $bug = $e->getMessage();
                            Log::channel('spinnerBulk')->info($bug);
                        }
                
                if($b['totals']['load']  >= $limit_amount){
                        $form['subject'] = 'Noor Games - Eligible For Spinner';
                        try
                            {
                                Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email']);
                            }
                        catch(\Exception $e)
                            {
                                $bug = $e->getMessage();
                                Log::channel('spinnerBulk')->info($bug);
                            }
                    }
                }elseif($type == 'below-'.$limit_amount){
                    if($b['totals']['load']  <  $limit_amount){
                        $form['subject'] = 'Noor Games - Spinner';
                        // $form['message-end'] = 'Noor Games - Eligible For Spinner';              
                        $form['load-remaining'] = $limit_amount - $b['totals']['load'];

                        try
                        {
                            Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                            Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email']);
                        }
                        catch(\Exception $e)
                        {
                            $bug = $e->getMessage();
                            Log::channel('spinnerBulk')->info($bug);
                        }
                    }
                }else{
                    $limit_1 = $limit_amount - 200;
                    $limit_2 = $limit_amount;
                    if($b['totals']['load']  >= $limit_1){
                        if($b['totals']['load']  < $limit_2){  
                            $form['subject'] = 'Noor Games - Almost Eligible For Spinner';                    
                            $form['load-remaining'] = $limit_amount - $b['totals']['load'];
                            
                            try
                            {
                                Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email']);
                            }
                            catch(\Exception $e)
                            {
                                $bug = $e->getMessage();
                                Log::channel('spinnerBulk')->info($bug);
                            }
                        }
                    }
                }
            // }
        }
    }
}
