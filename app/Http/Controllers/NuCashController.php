<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Facades\Datatables;
use App\BankMember;
use Illuminate\Support\Facades\DB;

class NuCashController extends Controller
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
        }, ['except' => 'welcome']);
    }

    public function listNuCash(Request $request) {
        $this->setPageHeader('Nu-Cash Summary', 'Summary of your Nu-Cash point');
        return view('nucash.list');
    }

    public function ajaxListNuCash(Request $request) {
        $nucash  = $this->user->getSummaryNuCash();
        $data = Datatables::collection($nucash);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
                $row->nucash_amount = 'Rp ' . number_format($row->nucash_amount, 0, ',', '.'). ',-';
                $row->nupoint_amount = 'Rp ' . number_format($row->nupoint_amount, 0, ',', '.'). ',-';
            }
        }
        return $data->make();
    }
    
    public function withdrawal(Request $request){
        $this->setPageHeader('Withdraw Nucash');
        $cek = $this->user->canWithdrawal();
        if (!$cek->can) {
            $pesan = $this->setPesanFlash('error', $cek->message);
            return redirect()->route('nucash.wd.list')->with($pesan);
        }

        //$getSummary  = $this->user->getSummaryNuCash();
        //$sumSummary = 0;
        //foreach($getSummary as $row){
        //    $sumSummary += $row->bonus_amount;
        //}
        $sumSummary = $this->user->getSummaryNuCash()->sum('nucash_amount');
        $min = 100000;
        
        $totalWD = $this->user->getTotalWDNucash();
        $maxWD = $sumSummary - $totalWD;
        if ($maxWD < 0) $maxWD = 0;
        if($maxWD < $min){
            $pesan = $this->setPesanFlash('error', 'You can not withdraw your bonus because your available bonus to withdraw is Rp ' . number_format($maxWD, 0, ',', '.') . ',- and the minimun withdraw is Rp ' . number_format($min, 0, ',', '.') . ',-');
            return redirect()->route('nucash.wd.list')->with($pesan);
        }
        
        $bank = New BankMember;
        $myAllBank = $bank->getMyAllBank($this->user->id);

        if ($myAllBank->isEmpty()) {
            $pesan = $this->setPesanFlash('error', 'Please create your bank account before you create withdraw.');
            return redirect()->route('nucash.wd.list')->with($pesan);
        }

        $listBankIds = [];
        foreach ($myAllBank as $rowBank) {
            $listBankIds[] = $rowBank->id;
        }
        
        //Post Method
        if ($request->isMethod('post')) {
            $bank = $request->choose_bank;
            if (!in_array($bank, $listBankIds)) {
                $pesan = $this->setPesanFlash('error', 'Bank account is not available.');
                return redirect()->back()->with($pesan)->withInput();
            }

            $nominal = $request->nominal;
            if($nominal <= 0){
                $pesan = $this->setPesanFlash('error', 'Nominal withdraw must greater than zero');
                return redirect()->back()->with($pesan)->withInput();
            }
            if($min > $nominal){
                $rpMin = 'Rp ' . number_format($min, 0, ',', '.') . ',-';
                $pesan = $this->setPesanFlash('error', 'Minimum withdraw must '. $rpMin);
                return redirect()->back()->with($pesan)->withInput();
            }
            if($nominal > $maxWD){
                $rp = 'Rp ' . number_format($maxWD, 0, ',', '.') . ',-';
                $pesan = $this->setPesanFlash('error', 'Your Max withdraw is '. $rp);
                return redirect()->back()->with($pesan)->withInput();
            }

            $kelipanan = 10000;
            if ($nominal % $kelipanan > 0) {
                $pesan = $this->setPesanFlash('error', 'The multiple withdraw amount is Rp '. number_format($kelipanan, 0, ',', '.'));
                return redirect()->back()->with($pesan)->withInput();
            }

            $kd_wd = uniqid() . $this->user->id;
            $fee = 10000;
            $totalWD = $nominal - $fee;
            $dataAll = array(
                'id_user' => $this->user->id,
                'jml_wd' => $nominal, 
                'kd_wd' => $kd_wd, 
                'adm_fee' => $fee, 
                'total_wd' => $totalWD,
                'user_bank' => $bank,
                'is_versi_2' => 1       //  versi 4 juli 2017
            );
            try {
                DB::table('tb_nucash_wd')->insert($dataAll);
                $result = (object) array('status' => true, 'message' => null);
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                $result = (object) array('status' => false, 'message' => 'Failed to create withdraw.');
            }
            if($result->status == false){
                $pesan = $this->setPesanFlash('error', $result->message);
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan = $this->setPesanFlash('success', 'Create Withdraw successfuly.');
            return redirect()->route('nucash.wd.list')->with($pesan);
        }
        //End post method
        
        return view('nucash.add-wd-nucash')
                    ->with('myBank', $myAllBank)
                    ->with('maxWD', $maxWD);
    }
    
    public function getListWithdrawal(Request $request){
        $this->setPageHeader('List Withdraw', 'My Withdrawal');
        return view('nucash.list-wd-nucash');
    }
    
    public function getAjaxWithdrawal(Request $request) {
        $allWD = $this->user->getAllWDNucash();
        $data = Datatables::collection($allWD);
        if (!empty($data->collection)) {
            $no = 0;
            foreach ($data->collection as $row) {
                $no++;
                $row->no = $no;
                $row->jml_wd = 'Rp ' . number_format($row->jml_wd, 0, ',', '.') . ',-';
                $row->adm_fee = 'Rp ' . number_format($row->adm_fee, 0, ',', '.') . ',-';
                $row->total_wd = 'Rp ' . number_format($row->total_wd, 0, ',', '.') . ',-';
            }
        }
        return $data->make();
    }
    
    public function confirmNucashWD(Request $request){
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the withdrawal!');
        $id = intval($request->get('id'));
        if ($request->isMethod('post') && $id > 0) {
            $dataWd  = $this->user->getStatusTransferId($id);
            if (!empty($dataWd)) {
                if ($this->user->setConfirmSuccess($id)) {
                    $result->status = 0;
                    $result->msg = 'Success to transfer the withdrawal!';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }
    

    public function getListPrevious(Request $request) {
        $this->setPageHeader('Nu-Cash Previous', 'Previous of your Nu-Cash point');
        return view('nucash.previous-list');
    }

    public function getAjaxPrevious(Request $request) {
        $nucash  = $this->user->getPreviousNucash();
        $data = Datatables::collection($nucash);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
                $row->nucash_amount = 'Rp ' . number_format($row->nucash_amount, 0, ',', '.'). ',-';
                $row->nupoint_amount = 'Rp ' . number_format($row->nupoint_amount, 0, ',', '.'). ',-';
            }
        }
        return $data->make();
    }
    
}
