<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BankMember extends Model 
{
    /*  define tablename */
    protected $table = 'tb_bank_member';

    protected $fillable = array('user_id', 'bank_name', 'account_no', 'account_name', 'is_used');
    
    public function getMemberBank($user_id) {
        return $this->where('user_id', '=', $user_id)
                            ->where('is_used', '=', 1)
                            ->orderBy('id', 'DESC')
                            ->first();
    }
    
    public function getMyAllBank($user_id) {
        return $this->where('user_id', '=', $user_id)
                            ->where('is_used', '=', 1)
                            ->orderBy('id', 'DESC')
                            ->get();
    }
    
    public function getAllBank(){
        $bank = [
                            [ "name" => "BANK BRI", "code" => "002"],
                            [ "name" => "BANK MANDIRI", "code" => "008"]
                        ];
        return $bank;
    }
    
    public function getIdBank($id) {
        return $this->where('id', '=', $id)->where('is_used', '=', 1)->first();
    }
    
    public function getIdUserBank($data) {
        return $this
                    //->where('user_id', '=', $data->user_id)
                    ->where('bank_name', '=', $data->bank_name)
                    ->where('account_no', '=', $data->account_no)
                    ->where('is_used', '=', 1)
                    ->first();
    }
    
    public function getTotalBankUsed($data, $total){
        $dataIsi = $this->where('bank_name', '=', $data->bank_name)
                        ->where('account_no', '=', $data->account_no)
                        ->where('is_used', '=', 1)
                        ->get();
        $return = true;
        if(count($dataIsi) > $total){
            $return = false;
        }
        return $return;
    }
    
    public function getMaxBank(){
        $sql = DB::table('tb_statik_settings')->orderBy('id', 'DESC')->first();
        $data = (object) array('max_bank' => 15, 'date' => null);
        if($sql){
            $data = (object) array('max_bank' => $sql->max_bank, 'date' => $sql->created_at);
        }
        return $data;
    }
            
            
            
}