<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /*
    **  Replace default login method from laravel, biar gak edit aslina
    */

    public function username()
    {
        return 'userid';
    }

/*
    public function login(Request $request)
    {
        // ini loh yg direplace 
        //$this->validateLogin($request);

        $User = new \App\User;

//        $company    = array('NUL0000005','admin', 'Nul0000124', 'Nul0000285','Nul0000094','Nul0000111','Nul0041391','Nul0000169','Nu-A0000777','Nu-A0000786','Nu-A0073558','Nu-A0073572','Nu-A0076896','Nu-A0076725','Nul0000297');
//        $company    = array('NUL0000005','admin','Nul0000297','NU-A0000777','Nul0000285','Nul0000094','Nul0000111','NUL0000124','nul0000055','Nul0000285','Nu-A0073558','Nul0041391','Nu-A0000786','Nu-A0076725','Nu-A0073572','Nu-A0076896','nul0000030','Nul0041391');
//        $company    = array('NUL0000005','admin');
//
//        if(in_array($request->get('userid'),$company)){
            $userNUL = $User->where('userid', '=', $request->get('userid'))
                ->where('password', '=', $request->get('password'))
                ->first();
//        }else{
//            return redirect('/');
//        }

        if (!empty($userNUL)) {
            Auth::login($userNUL);
            if (Auth::user()->isAdmin()) $this->redirectTo = '/admin';
            return $this->sendLoginResponse($request);
        }

        // yg berikutnya tetap punya laravel

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        //  diremark saja, sudah diganti diatas
        //if ($this->attemptLogin($request)) {
        //    return $this->sendLoginResponse($request);
        //}

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
*/
}
