<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Referal;
use App\Statik;
use App\Mail\OrderShipped;
use App\Plan_a_setting;
use App\PinMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ReferalController extends Controller{
    
    public function getReferalLink($code){
        $referal = New Referal;
        $statik = New Statik;
        $cekUser = $referal->getUserId('userid', $code);
        if($cekUser == null){
            return redirect()->route('home');
        }
        $randomNo = $statik->generateKey();
        $idCode = $randomNo.$cekUser->id;
        $encode = $statik->getEncode($idCode);
        return view('referal')
                    ->with('dataUser', $cekUser)
                    ->with('idCode', $encode);
    }
    
    public function postReferalLink(Request $request){
        $statik = New Statik;
        $referal = New Referal;
        $setting = New Plan_a_setting;
        
        //$newUserId = $referal->getNewCodeUserID();
        $name = $request->name;
        $email = $request->email;
        $hp = $request->hp;
        $passwd = $request->password;
        $passwdConfirm = $request->password_confirm;
        $idCode = $request->userid;
        $decode = $statik->getDecode($idCode);
        $getIdReferal = substr($decode, 5);
        $cekUser = $referal->getUserId('id', $getIdReferal);
        if($cekUser == null){
            $pesan = $this->setPesanFlash('danger', 'Don\'t change any code');
            return redirect()->route('home')->with($pesan)->withInput();
        }
        $userID = $request->code;
        if($userID != $cekUser->userid){
            $pesan = $this->setPesanFlash('danger', 'Don\'t change any code');
            return redirect()->route('home')->with($pesan)->withInput();
        }
        if($passwd != $passwdConfirm){
            $pesan = $this->setPesanFlash('danger', 'Password not identically.');
            return redirect()->route('get.referal', ['code' => $cekUser->userid])->with($pesan)->withInput();
        }
        $dataValidation = (object) array('fullname' => $name, 'email' => $email, 'hp' => $hp, 'password' => $passwd);
        $cekData = $statik->getValidationCreateUser($dataValidation);
        if($cekData->fails()){
            $pesannya = $cekData->errors()->first();
            $pesan = $this->setPesanFlash('danger', $pesannya);
            return redirect()->route('get.referal', ['code' => $cekUser->userid])->with($pesan)->withInput();
        }
        $cekTotalEmail = $referal->getCountEmailUsed($email, $hp);
        $empty = '';
        $maxAccount = $setting->maxAccount($empty);
        if($cekTotalEmail == $maxAccount){
            $pesan = $this->setPesanFlash('danger', 'Email or Phone number have used');
            return redirect()->route('get.referal', ['code' => $cekUser->userid])->with($pesan)->withInput();
        }
        
        $newUserId = $referal->getNewCodeUserID();
        $HashpassWord = Hash::make($passwd);
        $dataAll = array(
            'name' => $name, 
            'email' => $email, 
            'hp' => $hp, 
            'password' => $HashpassWord,
            'userid' => $newUserId,
            'id_referal' => $cekUser->id,
            'is_referal_link' => 1
        );
        try {
            $getID = DB::table('users')->insertGetId($dataAll);
            $result = (object) array('status' => true, 'message' => null);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message);
        }
        if($result->status == false){
            $pesan = $this->setPesanFlash('danger', $result->message);
            return redirect()->route('get.referal', ['code' => $cekUser->userid])->with($pesan)->withInput();
        }
        //Send Email
        $randomNo = $statik->generateKey();
        $new_time = strtotime(date("Y-m-d H:i:s", strtotime('+48 hours')));
        $isRef = 1;
        $idCode = $randomNo.'-'.$getID.'-'.$new_time.'-'.$getIdReferal.'-'.$isRef;
        $encodeNewInsertID = $statik->getEncode($idCode);
        $dateDaftar = date('l, d F Y H:i:s');
        $content = array('url' => $encodeNewInsertID, 'dataNewMember' => $dataAll, 'tglDaftar' => $dateDaftar, 'view' => 'regsitrasi', 'subject' => 'Your Nulife Registration');
        \Mail::to($email)->send(new OrderShipped($content));
        
        $contentToSponsor = array(
            'dataNewMember' => $dataAll, 
            'tglDaftar' => $dateDaftar, 
            'dataSponsor' => $cekUser, 
            'view' => 'info-registration',
            'subject' => 'Information Nulife Registration'
        );
        \Mail::to($cekUser->email)->send(new OrderShipped($contentToSponsor));
        
        $pesan = $this->setPesanFlash('success', 'Success register, check your new register email');
        return redirect()->route('get.referal', ['code' => $cekUser->userid])->with($pesan);
    }
    
    public function getActivation($code){
        $cekLogin = Auth::check();
        if($cekLogin == true){
            $pesan = $this->setPesanFlash('error', 'Activation failed, you still login');
            return redirect()->route('dashboard')->with($pesan);
        }
        $statik = New Statik;
        $referal = New Referal;
        $decode = $statik->getDecode($code);
        $arrayExplode = explode('-', $decode);
        $getId = $arrayExplode[1];
        $activationTime =$arrayExplode[2];
        $referalID =$arrayExplode[3];
        $isRef =$arrayExplode[4];
        $time = time();
        if($time > $activationTime){
            return redirect()->route('home')->with('message', 'Activation had too late over 48 hours')->with('messageclass', 'danger');
        }
        $cekID = $referal->getUserId('id', $getId);
        if($cekID == null){
            return redirect()->route('home')->with('message', 'No Data from system')->with('messageclass', 'danger');
        }
        if($cekID->is_active == 1){
            return redirect()->route('home')->with('message', 'Your have been actived')->with('messageclass', 'danger');
        }
        $dataAktif = array('is_active' => 1, 'active_at' => date('Y-m-d H:i:s'));
        try {
            DB::table('users')->where('id', '=', $cekID->id)->update($dataAktif);
            $result = (object) array('status' => true, 'message' => null);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message);
        }
        if($result->status == false){
            return redirect()->route('home')->with('message', $result->message)->with('messageclass', 'danger');
        }
        return redirect()->route('home')->with('message', 'Success activation, please login')->with('messageclass', 'success');

    }
    
    public function getSync(){
        ini_set('memory_limit', '1024M');
        $users = DB::table('users')->selectRaw('id')->where('id', '>', 118242)->orderBy('id', 'ASC')->get();
        foreach($users as $row){
            $anggota = DB::table('anggota_2')
                    ->selectRaw('ktp_member, kelamin, alamat, propinsi, kabupaten, kodepos')
                    ->where('id', '=', $row->id)
                    ->first();
            $cek = array('id_user' => $row->id, 'ktp' => null, 'gender' => null, 'alamat' => null, 'kode_pos' => null);
            if($anggota != null){
                $cek['ktp'] = ($anggota->ktp_member != '') ? $anggota->ktp_member  : null;
                $cek['gender'] = ($anggota->kelamin != '') ? (($anggota->kelamin == 'Pria') ? '1' : '2') : null;
                $cek['alamat'] = ($anggota->alamat != '') ? $anggota->alamat  : null;
                $cek['kode_pos'] = ($anggota->kodepos != '') ? $anggota->kodepos  : null;
            }
            DB::table('users_profile')->insert($cek);
        }
        dd('done');
    }
    
    public function updatePinCode(){
       $pinAll = DB::table('tb_pin_member')
                        ->selectRaw('pin_code, user_id, updated_at')
                        ->where('is_used', '=', 1)
                        ->get();
       $data = array();
       foreach($pinAll as $row){
           $getUserID = DB::table('tb_structure')
                        ->join('users', 'users.id', '=', 'tb_structure.user_id')
                        ->selectRaw(' tb_structure.user_id, tb_structure.userid, tb_structure.created_at')
                        ->where('tb_structure.created_at', '=', $row->updated_at)
                        ->whereNull('users.pin_code')
                        ->first();
           
           if(!empty($getUserID)){
               $data[] = (object) array('user_id' => $getUserID->user_id, 'created_at' => $getUserID->created_at, 'updated_at' => $row->updated_at);
               $user_id = $getUserID->user_id;
               $pin_code = $row->pin_code;
               $dataUpdate = array('pin_code' => $pin_code);
               DB::table('users')->where('id', '=', $user_id)->update($dataUpdate);
           }
       }
       //dd($data);
       dd('Done update pin code on users');
   }
    
    
    
    
    
    
}
