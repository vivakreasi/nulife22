<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Referal;
use App\Statik;
use App\PinMember;
use App\PinMemberB;
use App\UserProfile;
use App\BankMember;
use App\TransferReferal;
//use Mail;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\News;

class MemberController2 extends Controller{
    
    public function __construct(){
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
        }, ['except' => 'newLogin']);
        //});
    }
    
    public function getNewRegister() {
        //cek punya pin ga
        $pin = New PinMemberB;
        $dataLogin = $this->user;
        $countFreePin = $pin->getCountFreePIN($dataLogin->id);
        $cekHavePin = $pin->getMemberHavePIN($dataLogin->id);
        
        $havePin = ($countFreePin > 0 && !empty($cekHavePin));
        if($havePin){
            $this->setPageHeader('Register', 'New Member');
        } else {
            //$this->setPageHeader('Register', 'You don\'t have a pin to register new member, please order pin');
            $pesan = $this->setPesanFlash('error', "You don't have a pin to register new member, please order pin");
            return redirect()->route('pinb.order')->with($pesan);
        }
        return view('member.register2')
                    ->with('dataLogin', $dataLogin)
                    ->with('havePin', $havePin);
    }
    
    public function postNewRegister(Request $request){
        $pin = New PinMemberB;
        $countFreePin = $pin->getCountFreePIN($this->user->id);
        $cekHavePin = $pin->getMemberHavePIN($this->user->id);
        $havePin = ($countFreePin > 0 && !empty($cekHavePin));
        if (!$havePin) {
            $pesan = $this->setPesanFlash('error', "You don't have any pin to register new member, please order pin");
            return redirect()->route('pinb.order')->with($pesan);
        }

        $statik = New Statik;
        $referal = New Referal;
        $name = $request->name;
        $email = $request->email;
        $hp = $request->hp;
        $passwd = $request->password;
		
        $sel = $request->sel_product;
        $passwdConfirm = $request->password_confirm;
        if($passwd != $passwdConfirm){
            $pesan = $this->setPesanFlash('error', 'Password not identically.');
            return redirect()->route('new.register2')->with($pesan)->withInput();
        }
        $cekUser = $this->user;
        $dataValidation = (object) array('fullname' => $name, 'email' => $email, 'hp' => $hp, 'password' => $passwd, 'plan_status' => $sel);
        $cekData = $statik->getValidationCreateUser($dataValidation);
        if($cekData->fails()){
            $pesannya = $cekData->errors()->first();
            $pesan = $this->setPesanFlash('error', $pesannya);
            //return redirect()->route('new.register')->with($pesan)->withInput();
            return redirect()->back()->with($pesan)->withInput();
        }
        $cekTotalEmail = $referal->getCountEmailUsed($email, $hp);
        if($cekTotalEmail == 15){
            $pesan = $this->setPesanFlash('error', 'Email or Phone number have used');
            //return redirect()->route('new.register')->with($pesan)->withInput();
            return redirect()->back()->with($pesan)->withInput();
        }
        
        //proses insert getlastUserID
        $getIdReferal = $cekUser->id;
        $newUserId = $referal->getNewCodeUserID();
        $cekNewUserID = $referal->getUserId('userid', $newUserId);
        if($cekNewUserID != null){
            $newUserId = $referal->getNewCodeUserIDIfExist(2);
            $cekNewUserID1 = $referal->getUserId('userid', $newUserId);
            if($cekNewUserID1 != null){
                $newUserId = $referal->getNewCodeUserIDIfExist(3);
            }
        }
        $HashpassWord = Hash::make($passwd);
        $dataAll = array(
            'name' => $name, 
            'email' => $email, 
            'hp' => $hp, 
            'password' => $HashpassWord,
            'userid' => $newUserId,
            'id_referal' => $getIdReferal
        );
        try {
            $getID = DB::table('users')->insertGetId($dataAll);
            $result = (object) array('status' => true, 'message' => null);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message);
        }
        if($result->status == false){
            $pesan = $this->setPesanFlash('error', $result->message);
            //return redirect()->route('new.register')->with($pesan)->withInput();
            return redirect()->back()->with($pesan)->withInput();
        }
        //Email
        $randomNo = $statik->generateKey();
        $idCode = $randomNo.$getID;
        $new_time = strtotime(date("Y-m-d H:i:s", strtotime('+48 hours')));
        $isRef = 0;
        $idCode = $randomNo.'-'.$getID.'-'.$new_time.'-'.$getIdReferal.'-'.$isRef;
        $encodeNewInsertID = $statik->getEncode($idCode);
        $dateDaftar = date('l, d F Y H:i:s');
        $content = array(
            'url' => $encodeNewInsertID, 
            'dataNewMember' => $dataAll, 
            'tglDaftar' => $dateDaftar, 
            'view' => 'regsitrasi', 
            'subject' => 'Your Nulife Registration'
        );
        \Mail::to($email)->send(new OrderShipped($content));
        
        $pesan = $this->setPesanFlash('success', 'Success register, check your new register email');
        return redirect()->route('new.register2')->with($pesan);
        
    }









    public function getNewRegister2() {
        //cek punya pin ga
        $pinb = New PinBMember;
        $dataLoginb = $this->user;
        $countFreePinb = $pinb->getCountFreePIN($dataLogin->id);
        $cekHavePin = $pinb->getMemberHavePIN($dataLogin->id);
        $havePinb = ($countFreePinb > 0 && !empty($cekHavePin));
        if($havePinb){
            $this->setPageHeader('Register', 'New Member B');
        } else {
            //$this->setPageHeader('Register', 'You don\'t have a pin to register new member, please order pin');
            $pesan = $this->setPesanFlash('error', "You don't have a pin to register new member, please order pin");
            return redirect()->route('pinb.order')->with($pesan);
        }
        return view('member.register2')
                    ->with('dataLogin', $dataLogin)
                    ->with('havePin', $havePin);
    }
    
    public function postNewRegister2(Request $request){
        $pin = New PinBMember;
        $countFreePin = $pin->getCountFreePIN($this->user->id);
        $cekHavePin = $pin->getMemberHavePIN($this->user->id);
        $havePin = ($countFreePin > 0 && !empty($cekHavePin));
        if (!$havePin) {
            $pesan = $this->setPesanFlash('error', "You don't have any pin to register new member, please order pin");
            return redirect()->route('pinb.order')->with($pesan);
        }

        $statik = New Statik;
        $referal = New Referal;
        $name = $request->name;
        $email = $request->email;
        $hp = $request->hp;
        $passwd = $request->password;
		//add by viva
        $sel = $request->sel_product;
        $passwdConfirm = $request->password_confirm;
        if($passwd != $passwdConfirm){
            $pesan = $this->setPesanFlash('error', 'Password not identically.');
            return redirect()->route('new.register2')->with($pesan)->withInput();
        }
        $cekUser = $this->user;
        $dataValidation = (object) array('fullname' => $name, 'email' => $email, 'hp' => $hp, 'password' => $passwd,'plan_status' => $sel);
        $cekData = $statik->getValidationCreateUser($dataValidation);
        if($cekData->fails()){
            $pesannya = $cekData->errors()->first();
            $pesan = $this->setPesanFlash('error', $pesannya);
            //return redirect()->route('new.register')->with($pesan)->withInput();
            return redirect()->back()->with($pesan)->withInput();
        }
        $cekTotalEmail = $referal->getCountEmailUsed($email, $hp);
        if($cekTotalEmail == 15){
            $pesan = $this->setPesanFlash('error', 'Email or Phone number have used');
            //return redirect()->route('new.register')->with($pesan)->withInput();
            return redirect()->back()->with($pesan)->withInput();
        }
        
        //proses insert getlastUserID
        $getIdReferal = $cekUser->id;
        $newUserId = $referal->getNewCodeUserID();
        $cekNewUserID = $referal->getUserId('userid', $newUserId);
        if($cekNewUserID != null){
            $newUserId = $referal->getNewCodeUserIDIfExist(2);
            $cekNewUserID1 = $referal->getUserId('userid', $newUserId);
            if($cekNewUserID1 != null){
                $newUserId = $referal->getNewCodeUserIDIfExist(3);
            }
        }
        $HashpassWord = Hash::make($passwd);
        $dataAll = array(
            'name' => $name, 
            'email' => $email, 
            'hp' => $hp, 
            'password' => $HashpassWord,
            'userid' => $newUserId,
            'id_referal' => $getIdReferal
        );
        try {
            $getID = DB::table('users')->insertGetId($dataAll);
            $result = (object) array('status' => true, 'message' => null);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message);
        }
        if($result->status == false){
            $pesan = $this->setPesanFlash('error', $result->message);
            //return redirect()->route('new.register')->with($pesan)->withInput();
            return redirect()->back()->with($pesan)->withInput();
        }
        //Email
        $randomNo = $statik->generateKey();
        $idCode = $randomNo.$getID;
        $new_time = strtotime(date("Y-m-d H:i:s", strtotime('+48 hours')));
        $isRef = 0;
        $idCode = $randomNo.'-'.$getID.'-'.$new_time.'-'.$getIdReferal.'-'.$isRef;
        $encodeNewInsertID = $statik->getEncode($idCode);
        $dateDaftar = date('l, d F Y H:i:s');
        $content = array(
            'url' => $encodeNewInsertID, 
            'dataNewMember' => $dataAll, 
            'tglDaftar' => $dateDaftar, 
            'view' => 'regsitrasi', 
            'subject' => 'Your Nulife Registration'
        );
        \Mail::to($email)->send(new OrderShipped($content));
        
        $pesan = $this->setPesanFlash('success', 'Success register, check your new register email');
        return redirect()->route('new.register2')->with($pesan);
        
    }



    
    public function getMyProfile(){
        $profile = New UserProfile;
        $dataLogin = $this->user;
        $cek = $profile->getDetailMemberProfile($dataLogin->id);
        $provinsi = $profile->getProvince();
        $kota = $profile->getKota();
        $haveProfile = ($cek == null) ? false : true;
        if($haveProfile){
            $this->setPageHeader('Register', 'My Profile Member');
        } else {
            $this->setPageHeader('Register', 'You don\'t have profile member, please fill the profile data');
        }
        return view('member.myProfile')
                    ->with('dataLogin', $dataLogin)
                    ->with('dataProfile', $cek)
                    ->with('provinsi', $provinsi)
                    ->with('kota', $kota)
                    ->with('haveProfile', $haveProfile);
    }
    
    public function getNewProfile(){
        $profile = New UserProfile;
        //$pesan = $this->setPesanFlash('error', 'Profile Under construction');
        //return redirect()->route('my.profile')->with($pesan);
        $dataLogin = $this->user;
        $cek = $profile->getMemberProfile($dataLogin->id);
        $provinsi = $profile->getProvince();
        $kota = $profile->getKota();
        if($cek != null){
            $pesan = $this->setPesanFlash('error', 'You have one profile, don\'t create more');
            return redirect()->route('my.profile')->with($pesan);
        }
        $this->setPageHeader('Profile', 'Create My Profile Member');
        return view('member.createProfile')
                    ->with('provinsi', $provinsi)
                    ->with('kota', $kota)
                    ->with('dataLogin', $dataLogin);
    }
    
    public function postNewProfile(Request $request){
        $profile = New UserProfile;
        //$pesan = $this->setPesanFlash('error', 'Profile Under construction');
        //return redirect()->route('my.profile')->with($pesan);
        $dataLogin = $this->user;
        $cek = $profile->getMemberProfile($dataLogin->id);
        if($cek != null){
            $pesan = $this->setPesanFlash('error', 'You have one profile, don\'t create more');
            return redirect()->route('my.profile')->with($pesan);
        }
        $alamat = $request->alamat;
        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $kode_pos = $request->kode_pos;
        $gender = $request->gender;
        $ktp = $request->ktp;
        $paspor = $request->paspor;
        $birth_date = $request->birth_date;
        $birth_date = date('Y-m-d', strtotime($birth_date));
        $dataAll = array(
            'id_user' => $dataLogin->id,
            'alamat' => $alamat, 
            'provinsi' => $provinsi, 
            'kota' => $kota, 
            'kode_pos' => $kode_pos,
            'gender' => $gender,
            'ktp' => $ktp,
            'paspor' => $paspor,
            'birth_date' => $birth_date
        );
        try {
            $getID = DB::table('users_profile')->insert($dataAll);
            $result = (object) array('status' => true, 'message' => null);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message);
        }
        if($result->status == false){
            $pesan = $this->setPesanFlash('error', $result->message);
            return redirect()->back()->with($pesan)->withInput();
        }
        $pesan = $this->setPesanFlash('success', 'Success create profile');
        return redirect()->route('my.profile')->with($pesan);
    }
    
    public function getHakUsaha(){
        $dataLogin = $this->user;
        if($dataLogin->id_join_type != null){
            $pesan = $this->setPesanFlash('error', 'Anda sudah memilih hak usaha');
            return redirect()->route('dashboard')->with($pesan);
        }
        session()->forget('memberBaru');
        $this->setPageHeader('Create', 'Hak Usaha ');
        $hargaDasar = 360000;
        return view('plan.hak-usaha')
                    ->with('dataLogin', $dataLogin)
                    ->with('hargaDasar', $hargaDasar);
    }
    
    public function postHakUsaha(Request $request, $type){
        if($type != 1 && $type != 2 && $type != 3 && $type != 4){
            $pesan = $this->setPesanFlash('error', 'Please, don\'t change any code');
            return redirect()->route('hakusaha')->with($pesan);
        }
        $dataLogin = $this->user;
        if($dataLogin->id_join_type != null){
            $pesan = $this->setPesanFlash('error', 'Anda sudah memilih hak usaha');
            return redirect()->route('dashboard')->with($pesan);
        }
        $hakUsaha = 1;
        $id_join_type = 'silver';
        if($type == 2){
            $hakUsaha = 3;
            $id_join_type = 'gold';
        }
        if($type == 3){
            $hakUsaha = 7;
            $id_join_type = 'platinum';
        }
        if($type == 4){
            $hakUsaha = 15;
            $id_join_type = 'titanium';
        }
        if($dataLogin->is_referal_link == 0){
            $dataJoinType = array('is_active_type' => 1, 'id_join_type' => $id_join_type);
            DB::table('users')->where('id', '=', $dataLogin->id)->update($dataJoinType);
            for ($x = 1; $x <= ($hakUsaha - 1); $x++) {
                $startID = $x + 1;
                $newUserId = $dataLogin->userid.'-'.$startID;
                $dataAll = array(
                    'name' => $dataLogin->name, 
                    'email' => $dataLogin->email, 
                    'hp' => $dataLogin->hp, 
                    'password' => $dataLogin->password,
                    'userid' => $newUserId,
                    'id_referal' => $dataLogin->id,
                    'is_active_type' => 1,
                    'is_active' => 1,
                    'active_at' => date('Y-m-d H:i:s'),
                    'is_referal_link' => $dataLogin->is_referal_link,
                    'id_join_type' => $id_join_type
                );
                DB::table('users')->insertGetId($dataAll);
            }
            $pesan = $this->setPesanFlash('success', 'You have create Hak Usaha');
            return redirect()->route('dashboard')->with($pesan);
        }
        $this->setPageHeader('Transfer', 'Transfer to sponsor ');
        $bank = New BankMember;
        $referal = New Referal;
        $statik = New Statik;
        $infoBank = $bank->getMemberBank($dataLogin->id_referal);
        $cekRef = $referal->getUserId('id', $dataLogin->id_referal);
        $hargaDasar = 360000;
        $encode = $statik->getEncode($type);
        $daftarBank = $bank->getAllBank();
        return view('member.transfer-referal')
                    ->with('dataLogin', $dataLogin)
                    ->with('type', $type)
                    ->with('hakUsaha', $hakUsaha)
                    ->with('infoRef', $cekRef)
                    ->with('infoBank', $infoBank)
                    ->with('hargaDasar', $hargaDasar)
                    ->with('hakUsaha', $hakUsaha)
                    ->with('daftarBank', $daftarBank)
                    ->with('kode', $encode);
        
    }
    
    public function postTransferToReferal(Request $request){
        $dataLogin = $this->user;
        if($dataLogin->id_join_type != null){
            $pesan = $this->setPesanFlash('error', 'Anda sudah memilih hak usaha');
            return redirect()->route('dashboard')->with($pesan);
        }
        $statik = New Statik;
        $kode = $request->kode;
        $type = $statik->getDecode($kode);
        $price = $request->price;
        $bank_account = $request->bank_account;
        $account_name = $request->account_name;
        $bankName = $request->bank;
        $hargaDasar = 360000;
        $hakUsaha = 1;
        $id_join_type = 'silver';
        if($type == 2){
            $hakUsaha = 3;
            $id_join_type = 'gold';
        }
        if($type == 3){
            $hakUsaha = 7;
            $id_join_type = 'platinum';
        }
        if($type == 4){
            $hakUsaha = 15;
            $id_join_type = 'titanium';
        }
        $nominal = $hargaDasar * $hakUsaha;
        if($price < $nominal){
            $pesan = $this->setPesanFlash('error', 'Nominal too low than Hak Usaha Price');
            return redirect()->route('hakusaha')->with($pesan);
        }
        $objFile = $request->file('file_upload');
        $tmpFile = '';
        if (! \App\Berkas::FileUploaded($objFile, $tmpFile)) {
            $pesan = $this->setPesanFlash('error', 'No image file uploaded.');
            return redirect()->back()->with($pesan)->withInput();
        }
        $cekFile = \App\Berkas::isAllowedImage('file', $objFile, 'jpg,png,jpeg', 2040);
        if (!$cekFile->Success) {
            $this->throwValidationException($request, $cekFile->Validator);
        }
        $filename   = $hakUsaha . '_'.$dataLogin->id.'.'. \App\Berkas::getExtentionFile($objFile);
        $dirPath = 'files/ref';
        $dir = base_path($dirPath);
        $fileUpload = \App\Berkas::doUpload($objFile, $dir, $filename);
        $from = $dataLogin->id;
        $to = $dataLogin->id_referal;
        $dataAll = array(
            'from' => $from,
            'to' => $to,
            'price' => $price,
            'bank' => $bankName,
            'bank_account' => $bank_account,
            'account_name' => $account_name,
            'file_upload' => $filename,
            'hak_usaha' => $hakUsaha
        );
        DB::table('tb_transfer_referal')->insertGetId($dataAll);
        $dataJoinType = array('is_active_type' => 1);
        DB::table('users')->where('id', '=', $dataLogin->id)->update($dataJoinType);
        for ($x = 1; $x <= ($hakUsaha - 1); $x++) {
            $startID = $x + 1;
            $newUserId = $dataLogin->userid.'-'.$startID;
            $dataAll = array(
                'name' => $dataLogin->name, 
                'email' => $dataLogin->email, 
                'hp' => $dataLogin->hp, 
                'password' => $dataLogin->password,
                'userid' => $newUserId,
                'id_referal' => $dataLogin->id_referal,
                'is_active_type' => 1,
                'is_active' => 1,
                'active_at' => date('Y-m-d H:i:s'),
                'is_referal_link' => $dataLogin->is_referal_link
            );
            DB::table('users')->insertGetId($dataAll);
        }
        $pesan = $this->setPesanFlash('success', 'Success transfer to referal');
        return redirect()->route('dashboard')->with($pesan);
    }
    
    public function getAddBankMember(){
        $dataLogin = $this->user;
        $this->setPageHeader('Bank', 'Create Bank Account');
        $bank = New BankMember;
        $daftarBank = $bank->getAllBank();
        $myAllBank = $bank->getMyAllBank($dataLogin->id);
        return view('member.add-bank')
                    ->with('daftarBank', $daftarBank)
                    ->with('myBank', $myAllBank)
                    ->with('dataLogin', $dataLogin);
    }
    
    public function postAddBankMember(Request $request){
        $dataLogin = $this->user;
        $bank_name = $request->bank_name;
        if($bank_name != 'BANK MANDIRI' && $bank_name != 'BANK BRI'){
            $pesan = $this->setPesanFlash('error', 'Data bank has not found');
            return redirect()->route('create.bank')->with($pesan);
        }
        $account_no = $request->account_no;
        if($account_no == null){
            $pesan = $this->setPesanFlash('error', 'Account bank can not be empty');
            return redirect()->route('create.bank')->with($pesan);
        }
        $account_name = $dataLogin->name;
        
        $bank = New BankMember;
        $dataUpdateCek = (object) array('user_id' => $dataLogin->id, 'account_no' => $account_no, 'bank_name' => $bank_name);
        //$cekBank = $bank->getIdUserBank($dataUpdateCek);
        $cekMaxBank = $bank->getMaxBank();
        $cekBank = $bank->getTotalBankUsed($dataUpdateCek, $cekMaxBank->max_bank);
        //if($cekBank != null){
        if($cekBank == false){
            $pesan = $this->setPesanFlash('error', 'This Account Number Had Maximal Used');
            return redirect()->route('create.bank')->with($pesan);
        }
        
        $isUsed = 1;
        $dataAll = array(
            'user_id' => $dataLogin->id,
            'bank_name' => $bank_name, 
            'account_no' => $account_no, 
            'account_name' => $account_name, 
            'is_used' => $isUsed,
            'created_at' => date('Y-m-d H:i:s')
        );
        try {
            DB::table('tb_bank_member')->insertGetId($dataAll);
            $result = (object) array('status' => true, 'message' => null);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message);
        }
        if($result->status == false){
            $pesan = $this->setPesanFlash('error', $result->message);
            return redirect()->route('create.bank')->with($pesan);
        }
        $pesan = $this->setPesanFlash('success', 'Success Create Bank Account');
        return redirect()->route('create.bank')->with($pesan);
    }
    
    public function getEditBankMember($id){
        $dataLogin = $this->user;
        $this->setPageHeader('Edit Bank', 'Edit My Bank Account');
        $bank = New BankMember;
        $daftarBank = $bank->getAllBank();
        $myAllBank = $bank->getMyAllBank($dataLogin->id);
        $myBankEdit = $bank->getIdBank($id);
        return view('member.edit-bank')
                    ->with('editBank', $myBankEdit)
                    ->with('myBank', $myAllBank)
                    ->with('daftarBank', $daftarBank)
                    ->with('dataLogin', $dataLogin);
    }
    
    public function postEditBankMember(Request $request){
        $id = $request->id;
        $dataLogin = $this->user;
        $bank = New BankMember;
        $myBankEdit = $bank->getIdBank($id);
        if($myBankEdit == null){
            $pesan = $this->setPesanFlash('error', 'Data bank has not found');
            return redirect()->route('create.bank')->with($pesan);
        }
        if($myBankEdit->user_id != $dataLogin->id){
            $pesan = $this->setPesanFlash('error', 'Data bank account has not found');
            return redirect()->route('create.bank')->with($pesan);
        }
        $account = $request->account_no;
        $bank_name = $request->bank_name;
        if($bank_name != 'BANK MANDIRI' && $bank_name != 'BANK BRI'){
            $pesan = $this->setPesanFlash('error', 'Data bank has not found');
            return redirect()->route('edit.bank', ['id' => $id])->with($pesan);
        }
        if($account == null){
            $pesan = $this->setPesanFlash('error', 'Account bank can not be empty');
            return redirect()->route('edit.bank', ['id' => $id])->with($pesan);
        }
        
        $dataUpdateCek = (object) array('user_id' => $dataLogin->id, 'account_no' => $account, 'bank_name' => $bank_name);
        //$cekBank = $bank->getIdUserBank($dataUpdateCek);
        $cekMaxBank = $bank->getMaxBank();
        $cekBank = $bank->getTotalBankUsed($dataUpdateCek, $cekMaxBank->max_bank);
        //if($cekBank != null){
        if($cekBank == false){    
            $pesan = $this->setPesanFlash('error', 'This Account Number Had Maximal Used');
            return redirect()->route('edit.bank', ['id' => $id])->with($pesan);
        }
        $dataUpdate = array('account_no' => $account, 'bank_name' => $bank_name);
        DB::table('tb_bank_member')->where('id', '=', $id)->update($dataUpdate);
        $pesan = $this->setPesanFlash('success', 'Succes edit bank account '.$bank_name.' '.$account.' '.$dataLogin->name);
        return redirect()->route('create.bank')->with($pesan);
    }
    
    public function getListTransferReferal(){
        session()->forget('memberBaru');
        $ref = New TransferReferal;
        $dataLogin = $this->user;
        $cekTransferDownline = $ref->getAllTransferFromDownline($dataLogin->id);
        return view('member.list-transfer')
                    ->with('dataLogin', $dataLogin)
                    ->with('data', $cekTransferDownline);
    }
    
    public function getConfirmTransferReferal($id){
        session()->forget('memberBaru');
        $ref = New TransferReferal;
        $dataLogin = $this->user;
        $cekDetail = $ref->getDetailTransferDownline($dataLogin->id, $id);
        return view('member.detail-transfer')
                    ->with('dataLogin', $dataLogin)
                    ->with('data', $cekDetail);
    }
    
    public function postConfirmTransferReferal(Request $request){
        $ref = New TransferReferal;
        $referal = New Referal;
        $dataLogin = $this->user;
        $id = $request->kode;
        $cekDetail = $ref->getDetailTransferDownline($dataLogin->id, $id);
        if($cekDetail == null){
            $pesan = $this->setPesanFlash('error', 'Data not found');
            return redirect()->route('hakusaha')->with($pesan);
        }
        $hakUsaha = $cekDetail->hak_usaha;
        $id_join_type = 'silver';
        if($hakUsaha == 3){
            $id_join_type = 'gold';
        }
        if($hakUsaha == 7){
            $id_join_type = 'platinum';
        }
        if($hakUsaha == 15){
            $id_join_type = 'titanium';
        }
        $cekDown = $referal->getUserId('id', $cekDetail->from);
        $dataJoinType = array('id_join_type' => $id_join_type);
        DB::table('users')->where('userid', 'LIKE', $cekDown->userid.'%')->update($dataJoinType);
        
        $dataApprove = array('is_approve' => 1, 'approve_at' => date('Y-m-d H:i:s'));
        DB::table('tb_transfer_referal')->where('id', '=', $id)->update($dataApprove);
        
        $pesan = $this->setPesanFlash('success', 'Transfer Referal approved');
        return redirect()->route('dashboard')->with($pesan);
    }
    
    public function getEditProfile($type){
        if($type != 'passwd' && $type != 'hp' && $type != 'alamat' && $type != 'ktp' && $type != 'birth' && $type != 'paspor' && $type != 'gender'){
            $pesan = $this->setPesanFlash('error', 'Forbiden area');
            return redirect()->route('my.profile')->with($pesan);
        }
        switch($type){
            case 'passwd':
                $subheader = 'Set New Password';
                break;
            case 'hp':
                $subheader = 'Set New Phone Number';
                break;
            case 'alamat':
                $subheader = 'Set New Address';
                break;
            case 'ktp':
                $subheader = 'Set New ID Card';
                break;
            case 'birth':
                $subheader = 'Set New Birth Date';
                break;
            case 'paspor':
                $subheader = 'Set New Passport';
                break;
            case 'gender':
                $subheader = 'Set New Gender';
                break;
            default:
                $subheader = '';
        }
        $this->setPageHeader('Update Profile',$subheader);
        $profile = New UserProfile;
        $dataLogin = $this->user;
        $cek = $profile->getDetailMemberProfile($dataLogin->id);
        $provinsi = $profile->getProvince();
        $kota = $profile->getKota();
        return view('member.edit')
                    ->with('dataProfile', $cek)
                    ->with('dataLogin', $dataLogin)
                    ->with('provinsi', $provinsi)
                    ->with('kota', $kota)
                    ->with('type', $type);
    }
    
    public function postEditProfile(Request $request){
        $dataLogin = $this->user;
        $type = $request->type;
        if($type != 'passwd' && $type != 'hp' && $type != 'alamat' && $type != 'ktp' && $type != 'birth' && $type != 'paspor' && $type != 'gender'){
            $pesan = $this->setPesanFlash('error', 'Forbiden area');
            return redirect()->route('my.profile')->with($pesan);
        }
        if($type == 'passwd'){
            $password = $request->password;
            $rePassword = $request->re_password;
            if($password != $rePassword){
                $pesan = $this->setPesanFlash('error', 'Password and re-Type don\'t Identic');
                return redirect()->route('edit.profile', ['type' => 'passwd'])->with($pesan);
            }
            $length = strlen($password);
            if($length < 6){
                $pesan = $this->setPesanFlash('error', 'Minimum password length is 6 character');
                return redirect()->route('edit.profile', ['type' => 'passwd'])->with($pesan);
            }
            $space = strrpos($password," ");
            if($space != false){
                $pesan = $this->setPesanFlash('error', 'Password must be without white space');
                return redirect()->route('edit.profile', ['type' => 'passwd'])->with($pesan);
            }
            $dataApprove = array('password' =>  Hash::make($password));
            DB::table('users')->where('id', '=', $dataLogin->id)->update($dataApprove);
            $pesan = $this->setPesanFlash('success', 'Done, update new password');
            return redirect()->route('my.profile')->with($pesan);
        }
        
        if($type == 'hp'){
            $newHp = $request->hp;
            $lengthHP = strlen($newHp);
            if($lengthHP > 14){
                $pesan = $this->setPesanFlash('error', 'Phone Number is too long');
                return redirect()->route('edit.profile', ['type' => 'hp'])->with($pesan);
            }
            $numeric = is_numeric($newHp);
            if($numeric == false){
                $pesan = $this->setPesanFlash('error', 'Phone Number must be numeric input');
                return redirect()->route('edit.profile', ['type' => 'hp'])->with($pesan);
            }
            $dataApprove1 = array('hp' =>  $newHp);
            DB::table('users')->where('id', '=', $dataLogin->id)->update($dataApprove1);
            $pesan = $this->setPesanFlash('success', 'Done, update new phone number');
            return redirect()->route('my.profile')->with($pesan);
        }
        
        if($type == 'birth'){
            $birth_date = $request->birth_date;
            $birth_date = date('Y-m-d', strtotime($birth_date));
            $dataApprove2 = array('birth_date' =>  $birth_date);
            DB::table('users_profile')->where('id_user', '=', $dataLogin->id)->update($dataApprove2);
            $pesan = $this->setPesanFlash('success', 'Done, update new Birth Date');
            return redirect()->route('my.profile')->with($pesan);
        }
        
        if($type == 'paspor'){
            $paspor = $request->paspor;
            $dataApprove3 = array('paspor' =>  $paspor);
            DB::table('users_profile')->where('id_user', '=', $dataLogin->id)->update($dataApprove3);
            $pesan = $this->setPesanFlash('success', 'Done, update new Passport');
            return redirect()->route('my.profile')->with($pesan);
        }
        
        if($type == 'ktp'){
            $ktp = $request->ktp;
            $dataApprove4 = array('ktp' =>  $ktp);
            DB::table('users_profile')->where('id_user', '=', $dataLogin->id)->update($dataApprove4);
            $pesan = $this->setPesanFlash('success', 'Done, update new Identity Card');
            return redirect()->route('my.profile')->with($pesan);
        }
        
        if($type == 'gender'){
            $gender = $request->gender;
            if($gender != 1 && $gender != 2){
                $pesan = $this->setPesanFlash('error', 'Data Gender not found');
                return redirect()->route('my.profile')->with($pesan);
            }
            $dataApprove5 = array('gender' =>  $gender);
            DB::table('users_profile')->where('id_user', '=', $dataLogin->id)->update($dataApprove5);
            $pesan = $this->setPesanFlash('success', 'Done, update new Gender');
            return redirect()->route('my.profile')->with($pesan);
        }
        
        if($type == 'alamat'){
            $alamat = $request->alamat;
            $provinsi = $request->provinsi;
            $kota = $request->kota;
            if($alamat == null && $provinsi == null && $kota == null){
                $pesan = $this->setPesanFlash('error', 'Data Address Can not be empty');
                return redirect()->route('my.profile')->with($pesan);
            }
            $dataApprove6 = array('alamat' =>  $alamat, 'provinsi' => $provinsi, 'kota' => $kota);
            DB::table('users_profile')->where('id_user', '=', $dataLogin->id)->update($dataApprove6);
            $pesan = $this->setPesanFlash('success', 'Done, update new Full Address');
            return redirect()->route('my.profile')->with($pesan);
        }
        
        
    }
    
    public function newLogin(Request $request){
        $userid = $request->userid;
        $password = $request->password;
        $userdata = array( 'userid' => $userid, 'password'  => $password);
        if (Auth::attempt(['userid' => $userid, 'password' => $password, 'is_active' => 1])) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('home')->withErrors($userdata);
        }
    }
    
    public function getMemberViewNews($id){
        $dataLogin = $this->user;
        $idMember = $dataLogin->id;
        $dataAll = array('user_id' => $idMember, 'content_id' => $id);
        $getID = DB::table('tb_view_contents')->insert($dataAll);
        return redirect()->route('dashboard');
    }
    
    public function getMemberListNews(){
        $this->setPageHeader('List News');
        $dataLogin = $this->user;
        //$idMember = $dataLogin->id;
        $news = New News;
        $getData = $news->getAllNews();
        return view('member.news-list')
                    ->with('data', $getData);
    }
    
    public function getMemberDetailNews($id){
        $dataLogin = $this->user;
        $idMember = $dataLogin->id;
        $news_id = $id;
        $news = New News;
        $this->setPageHeader('Detail News');
        $getData = $news->getNewsByID($news_id);
        return view('member.news-detail')
                    ->with('news', $getData);
    }
    
    
}