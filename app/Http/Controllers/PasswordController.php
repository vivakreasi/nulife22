<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Referal;
use App\Statik;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller{
    
    public function getLostPassword(){
        return view('member.lost-password');
    }
    
    public function postLostPassword(Request $request){
        $statik = New Statik;
        $referal = New Referal;
        $email = $request->email;
        $dataValidation = (object) array('email' => $email);
        $cekData = $statik->getValidationLostPassword($dataValidation);
        if($cekData->fails()){
            $pesannya = $cekData->errors()->first();
            //$pesan = $this->setPesanFlash('danger', $pesannya);
            //return redirect()->route('lost.password')->with($pesan)->withInput();
            return redirect()->route('home')->with('message', $pesannya);
        }
        $cekEmail = $referal->getValidationEmailUsed('email', $email);
        if($cekEmail == null){
            //$pesan = $this->setPesanFlash('danger', 'Email not found');
            //return redirect()->route('lost.password')->with($pesan)->withInput();
            return redirect()->route('home')->with('message', 'We can\'t find a user with that e-mail address.');
        }
        if($cekEmail->is_active == 0){
            //$pesan = $this->setPesanFlash('danger', 'Email not active ');
            //return redirect()->route('lost.password')->with($pesan)->withInput();
            return redirect()->route('home')->with('message', 'This Email reset token is invalid.');
        }
        //Send Email
        $getID = $cekEmail->id;
        $dataAll = array(
            'name' => $cekEmail->name, 
            'email' => $cekEmail->email, 
            'hp' => $cekEmail->hp, 
            'userid' => $cekEmail->userid,
            'id_referal' => $cekEmail->id_referal
        );
        $randomNo = $statik->generateKey();
        $new_time = strtotime(date("Y-m-d H:i:s", strtotime('+48 hours')));
        $idCode = $randomNo.'-'.$getID.'-'.$new_time;
        $encodeNewInsertID = $statik->getEncode($idCode);
        $dateDaftar = date('l, d F Y H:i:s');
        try{
            $content = array(
                'url' => $encodeNewInsertID, 
                'dataNewMember' => $dataAll, 
                'tglDaftar' => $dateDaftar, 
                'view' => 'forgot-password',
                'subject' => 'Your Nulife Reset Password'
            );
            \Mail::to($email)->send(new OrderShipped($content));
            $status = (object) array('status' => true, 'pesan' => null);
        } catch (Exception $ex) {
            $status = (object) array('status' => true, 'pesan' => $ex->message);
        }
        if($status->status == false){
            //$pesan = $this->setPesanFlash('danger', $status->pesan);
            //return redirect()->route('lost.password')->with($pesan)->withInput();
            return redirect()->route('home')->with('message', $status->pesan);
        }
        //$pesan = $this->setPesanFlash('success', 'Check your email');
        //return redirect()->route('lost.password')->with($pesan);
        return redirect()->route('home')->with('message', 'We have e-mailed your password reset link!');
    }
    
    public function getActivationPassword($code){
        $statik = New Statik;
        $referal = New Referal;
        $decode = $statik->getDecode($code);
        $arrayExplode = explode('-', $decode);
        if(count($arrayExplode) != 3){
            $pesan = 'Your link has not found data';
            return redirect()->route('home')->with('message', $pesan);
        }
        $randomNo = $arrayExplode[0];
        $getId = $arrayExplode[1];
        $activationTime =$arrayExplode[2];
        $time = time();
        if($time > $activationTime){
            $pesan = 'You have been late to activate the password';
            return redirect()->route('home')->with('message', $pesan);
        }
        $cekData = $referal->getValidationEmailUsed('id', $getId);
        if($cekData == null){
            $pesan = 'Your email has not found';
            return redirect()->route('home')->with('message', $pesan);
        }
        return view('member.reset-password')
                        ->with('kode', $code)
                        ->with('data', $cekData);
    }
    
    public function postActivationPassword(Request $request){
        $statik = New Statik;
        $referal = New Referal;
        $email = $request->email;
        $code = $request->kode;
        $pass = $request->password;
        $pass_confirm = $request->password_confirm;
        if($pass != $pass_confirm){
            $pesan = $this->setPesanFlash('danger', 'Your password must be identic');
            return redirect()->route('get.activation.password', ['code' => $code])->with($pesan)->withInput();
        }
        $dataValidation = (object) array('password' => $pass);
        $cekData = $statik->getValidationPassword($dataValidation);
        if($cekData->fails()){
            $pesannya = $cekData->errors()->first();
            $pesan = $this->setPesanFlash('danger', $pesannya);
            return redirect()->route('get.activation.password', ['code' => $code])->with($pesan)->withInput();
        }
        $decode = $statik->getDecode($code);
        $arrayExplode = explode('-', $decode);
        if(count($arrayExplode) != 3){
            $pesan = 'Your link has not found data';
            return redirect()->route('home')->with('message', $pesan);
        }
        $getId = $arrayExplode[1];
        $cekData = $referal->getValidationEmailUsed('id', $getId);
        if($cekData == null){
            $pesan = 'data has not found';
            return redirect()->route('home')->with('message', $pesan);
        }
        $cekAllData = $referal->getValidationAllEmailUsed('email', $cekData->email);
        foreach($cekAllData as $row){
            $dataUpdate = array('password' => Hash::make($pass));
            try {
                DB::table('users')->where('id', '=', $row->id)->update($dataUpdate);
            } catch (Exception $ex) {
                $message = $ex->getMessage();
            }
        }
        $pesan = 'Password have successfully change, you can Sign In with new password';
        return redirect()->route('home')->with('message', $pesan);
    }
    
    public function postResendActivation(Request $request){
        $statik = New Statik;
        $referal = New Referal;
        $email = $request->email;
        $dataValidation = (object) array('email' => $email);
        $cekData = $statik->getValidationLostPassword($dataValidation);
        if($cekData->fails()){
            $pesannya = $cekData->errors()->first();
            return redirect()->route('home')->with('message', $pesannya);
        }
        
        $cekEmail = $referal->getValidationEmailResendActivation($email);
        if($cekEmail == null){
            return redirect()->route('home')->with('message', 'Your email not found');
        }
        
        $getID = $cekEmail->id;
        $dataAll = array(
            'name' => $cekEmail->name, 
            'email' => $cekEmail->email, 
            'hp' => $cekEmail->hp, 
            'userid' => $cekEmail->userid,
            'id_referal' => $cekEmail->id_referal
        );
        
        $randomNo = $statik->generateKey();
        $new_time = strtotime(date("Y-m-d H:i:s", strtotime('+48 hours')));
        $isRef = $cekEmail->is_referal_link;
        $getIdReferal = $cekEmail->id_referal;
        $idCode = $randomNo.'-'.$getID.'-'.$new_time.'-'.$getIdReferal.'-'.$isRef;
        $encodeNewInsertID = $statik->getEncode($idCode);
        $dateDaftar = date('l, d F Y H:i:s');
        try{
            $content = array(
                'url' => $encodeNewInsertID, 
                'dataNewMember' => $dataAll, 
                'tglDaftar' => $dateDaftar, 
                'view' => 'resend-activation', 
                'subject' => 'Your Nulife Resend Activation Registration'
            );
            \Mail::to($email)->send(new OrderShipped($content));
            $status = (object) array('status' => true, 'pesan' => null);
        } catch (Exception $ex) {
            $status = (object) array('status' => true, 'pesan' => $ex->message);
        }
        if($status->status == false){
            return redirect()->route('home')->with('message', $status->pesan);
        }
        return redirect()->route('home')->with('message', 'We have e-mailed your resend activation link!');
    }
    
    
}