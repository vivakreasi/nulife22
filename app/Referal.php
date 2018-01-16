<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Referal extends Model {
    
    protected $table = 'users'; //sementara anggota ntar pakai users
    
    public  function getUserId($field, $isi) {
        //return DB::table('anggota')->selectRaw('id, nama, userid, email, no_handphone')->where($field, '=', $isi)->first();
        return DB::table('users')->selectRaw('id, name as nama, userid, email, hp as no_handphone, is_active, is_referal_link, password, is_stockis, id_join_type')->where($field, '=', $isi)->first();
    }
    
    public function geLastUserID(){
        $sql = DB::table('users')
                        ->selectRaw('userid')
                        ->where('userid', 'LIKE', 'NU-%')
                        ->orderBy('userid', 'DESC')
                        ->first();
        return $sql;
    }
    
    public function getNewCodeUserID(){
        //$referal = New Referal;
        $lastCount = $this->geLastUserID();
        $lastUserId = substr($lastCount->userid, 0, 11);
        $value = preg_replace("/[^0-9\.]/", '', $lastUserId);
        $getAlphabet = preg_replace('/[^A-Z_-]/', '', $lastUserId);
        $lastAlphabet = substr($getAlphabet, -1);
        $kode = 'NU-';
        $GabCode = $kode.$lastAlphabet;
        if($value == 9999999){
            $addOne = 0000001;
            $lastAlphabet++;
            $GabCode = $kode.$lastAlphabet;
            //$newCode = sprintf("%07s", $GabCode.$addOne);
        } else {
            $addOne = $value + 1;
        }
        $addOne = str_pad($addOne, 7, '0', STR_PAD_LEFT);
        $newCode = sprintf("%07s", $GabCode.$addOne);
        return $newCode;
    }
    
    public function getNewCodeUserIDIfExist($no){
        $lastCount = $this->geLastUserID();
        $lastUserId = substr($lastCount->userid, 0, 11);
        $value = preg_replace("/[^0-9\.]/", '', $lastUserId);
        $getAlphabet = preg_replace('/[^A-Z_-]/', '', $lastUserId);
        $lastAlphabet = substr($getAlphabet, -1);
        $kode = 'NU-';
        $GabCode = $kode.$lastAlphabet;
        if($value == 9999999){
            $addOne = 0000001;
            $lastAlphabet++;
            $GabCode = $kode.$lastAlphabet;
        } else {
            $addOne = $value + $no;
        }
        $addOne = str_pad($addOne, 7, '0', STR_PAD_LEFT);
        $newCode = sprintf("%07s", $GabCode.$addOne);
        return $newCode;
    }
    
    public function getCountEmailUsed($email, $hp){
        $sql = DB::table('users')->where('email', '=', $email)->count('id');
        return $sql;
    }
    
    public function getValidationEmailUsed($field, $isi){
        $sql = DB::table('users')->selectRaw('id, name, email, hp, userid, id_referal, is_active')->where($field, '=', $isi)->first();
        return $sql;
    }
    
    public function getValidationAllEmailUsed($field, $isi){
        $sql = DB::table('users')->selectRaw('id, name, email, hp, userid, id_referal')->where($field, '=', $isi)->get();
        return $sql;
    }
    
    public function getValidationEmailName($data){
        $sql = DB::table('users')
                ->selectRaw('id, name, email, id_join_type')
                ->where('email', '=', $data->email)
                ->where('name', '=', $data->nama)
                ->where('hp', '=', $data->no_handphone)
                ->where('id_join_type', '=', $data->id_join_type)
                ->get();
        return $sql;
    }
    
    public function getValidationEmailResendActivation($isi){
        $sql = DB::table('users')
                ->selectRaw('id, name, email, hp, userid, id_referal, is_active, is_referal_link')
                ->where('email', '=', $isi)
                ->where('is_active', '=', 0)
                ->whereNull('id_join_type')
                ->whereNull('active_at')
                ->first();
        return $sql;
    }
    
    public  function getAllUserIdSearch($field, $isi) {
        return DB::table('users')->selectRaw('id, name as nama, userid, email, hp as no_handphone, is_active, is_referal_link, password, is_stockis, id_join_type')->where($field, '=', $isi)->get();
    }
    
    
    
}