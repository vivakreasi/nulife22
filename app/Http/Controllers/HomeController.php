<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth', ['except' => 'welcome']);
        $this->middleware(function (Request $request, $next) {
            parent::__construct();
            //  hanya user member
            if($this->isLoggedIn && !$this->isAdmin && $this->user->isMember()) {
                $this->initC(true);
                return $next($request);
            } elseif ($this->isAdmin) {
                return redirect()->route('admin');
            }
            // logout user, karena jika melalui hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        }, ['except' => ['welcome','showCoc']]);
    }

    public function welcome()
    {
//        dd(Hash::make('a'));

        return view('welcome');
    }

    public function showCoc()
    {
        return view('coc');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clsJaringan = new \App\StrukturJaringan;
        return view('dashboard');
    }
}
