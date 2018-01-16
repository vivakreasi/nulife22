<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Plan_c;
use App\Plan_c_pin;
use App\Transaction;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $PlanC;
    public $user;
    public $PinC;
    public $isAdmin = false;
    public $isLoggedIn = false;

    public function __construct()
    {
        $this->isLoggedIn = Auth::check();
        $this->user = Auth::user();
        $this->isAdmin = ($this->isLoggedIn) ? Auth::user()->isAdmin() : false;
        View::share('isAdmin', $this->isAdmin);
        View::share('isLoggedIn', $this->isLoggedIn);
    }
    
    //public function initC($showProgress = true, $showStatistic = true)
    public function initC($showStatistic = true)
    {
        if ($this->isLoggedIn) {
            $this->PlanC = new Plan_c();
            $this->PinC = new Plan_c_pin();
            $this->Transaction = new Transaction();
            //if ($showProgress === true) $this->setGlobalProgressPlanC();
            if ($showStatistic === true) $this->setGlobalStatisticC();
        }
    }

    /*
    **  setPesanFlash => set alert
    **  @type : string type pesa (danger, info, success, warning)
    **  @pesan : string isi pesan
    **  return array
    */
    public function setPesanFlash($type, $pesan)
    {
        return ['pesan-flash' => ['type' => strtolower($type), 'pesan' => $pesan]];
    }

    /*
    **  setPageHeader => share page header
    **  @title = string default empty
    **  @description = string default empty 
    **  @balanceLeft = integer default 0
    **  @balanceRight = integer default 0
    **  @saldo = integer default 0
    **  @showBelance = boolean default false
    **  @showSaldo = boolean default false
    **  return void
    */
    public function setPageHeader($title = '', $description = '', $gnetworkgrowth = false, $gbonusearn = false)
    {
        $result = [];
        if ($title != '') $result['title'] = $title;
        if ($description != '') $result['description'] = $description;
        if ($gnetworkgrowth === true) $result['gnetworkgrowth'] = '1,2,3,1,5,2,1,6,3,1,2,1';
        if ($gbonusearn === true) $result['gbonusearn'] = '1,2,3,1,5,2,1,6,3,1,2,1';
        View::share('page_header', (object) $result);
        return;
    }

    /*public function setGlobalProgressPlanC()
    {
        if (Auth::guest() || is_null($this->PlanC)) return;
        View::share('globalProgressC', $this->PlanC->getProgress(Auth::user(), true));
    }*/

    public function setGlobalStatisticC()
    {
        if (Auth::guest() || is_null($this->PlanC)) return;
        View::share('globalStatisticC', $this->PlanC->getStatisticC());
    }

    private $companyBank;
    public function getCompanyBank() {
        if (!$this->isLoggedIn) return null;
        if (!empty($this->companyBank)) return $this->companyBank;
        $clsBank = new \App\BankCompany;
        $this->companyBank = $clsBank->getOneBank();
        return $this->companyBank;
    }

}
