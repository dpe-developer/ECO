<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\LoginInfo;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Auth;

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
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /* public function username()
    {
        return 'username';
    } */

    public function login(Request $request){
		$request->validate([
			'username' => ['required'],
			'password' => ['required'],
		]);
		$client = new Agent();

		$fieldType = filter_var($request->get('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(Auth::attempt([$fieldType => $request->get('username'), 'password' => $request->get('password')])){
			// Authentication passed...
			LoginInfo::create([
				'username' => $request->get('username'),
				// 'password' => $request->password,
				'status' => 'success',
				'ip_address' => $request->ip(),
				'device' => $client->device(),
				'platform' => $client->platform(),
				'browser' => $client->browser(),
			]);
            if(Auth::user()->role->role_id == 4){
                return redirect()->route('home');
            }else{
                return redirect()->route('dashboard');
            }
        }else{
            LoginInfo::create([
				'username' => $request->get('username'),
				// 'password' => $request->password,
				'status' => 'failed',
				'ip_address' => $request->ip(),
				'device' => $client->device(),
				'platform' => $client->platform(),
				'browser' => $client->browser(),
			]);
			return redirect()->route('login')
			->withInput($request->only('username', 'remember'))
			->withErrors(['username' => 'These credentials do not match our records.']);
        }
	}
}
