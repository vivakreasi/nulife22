<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class RewardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        });
    }
}
