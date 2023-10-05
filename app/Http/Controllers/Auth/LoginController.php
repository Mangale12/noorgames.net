<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Rules\EmailExists;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
       return response()->json(['message'=>Auth::user()]);
        session()->put('log_in_time', Carbon::now());
        // if(Auth::user()->role != 'admin'){
            $save_log = LoginLog::create([
                'user_id' => Auth::user()->id,
                'login_time' => Carbon::now()
            ]);
            session()->put('log_id',$save_log->id);
            // 'login_time' => Carbon::now()
        // }
        switch (Auth::user()->role) {
            case 'admin':
                // return response();
                $this->redirectTo = '/dashboard';
                return $this->redirectTo;
                break;
            case 'cashier':
                $this->redirectTo = '/dashboard';
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;
                break;
        }
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>['required','email',new EmailExists],
            'password'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        try{
            $credentials = $request->only('email', 'password');
            if (auth()->attempt($credentials)) {
                // Authentication passed, redirect to a protected route
                $user = Auth::user();
                $token = $user->createToken('login')->accessToken;
                return response()->json(['user'=>$user, 'token'=>$token, 'type'=>'Bearrer']);
                //
            }else{
                return response()->json(['errors'=>'Credential doesnot mancch with our database']);
            }
            // return $this->responseToken($token);
        }
        catch(Exception $e){
            return response()->json($e);
        }

    }

    protected function responseToken($token){
        return response()->json([
            'success'=>true,
            'accesss_token'=>$token,
            'token_type'=>'Bearer',
            'expires_in'=>auth()->factory()->getTTL()*60,
        ]);
    }

    // protected function logout()
    // {
    //     $id = session()->get('log_id');
    //     Session::flush();
    //     // dd($id);

    //     if(!empty($id)){
    //         $save_log = LoginLog::where('id',$id)->update(['logout_time' => Carbon::now()]);
    //     }
    //     Auth::logout();
    //     return redirect('login');
    // }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('auth:api');
    }
}
