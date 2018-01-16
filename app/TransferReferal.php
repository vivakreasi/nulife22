<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransferReferal extends Model{
    /*  define tablename */
    protected $table = 'tb_transfer_referal';

    protected $fillable = array('from', 'to', 'price', 'bank', 'bank_account', 'file_upload', 'hak_usaha', 'is_approve');
    
    public function getTransferReferal($user_id) {
        return $this->where('from', '=', $user_id)->first();
    }
    
    public function getTransferFromDownline($user_id) {
        return $this->where('to', '=', $user_id)->where('is_approve', '=', 0)->first();
    }
    
     public function getAllTransferFromDownline($user_id) {
        $data = DB::table('tb_transfer_referal')
                        ->selectRaw('tb_transfer_referal.id, users.name, tb_transfer_referal.price, tb_transfer_referal.bank, tb_transfer_referal.hak_usaha ')
                        ->join('users', 'users.id', '=', 'tb_transfer_referal.from')
                        ->where('tb_transfer_referal.to', '=', $user_id)
                        ->where('tb_transfer_referal.is_approve', '=', 0)
                        ->get();
        return $data;
    }
    
    public function getDetailTransferDownline($user_id, $id) {
        $data = DB::table('tb_transfer_referal')
                        ->selectRaw('tb_transfer_referal.id, users.name, tb_transfer_referal.price, tb_transfer_referal.bank, tb_transfer_referal.hak_usaha,'
                                . 'tb_transfer_referal.bank_account, tb_transfer_referal.account_name, tb_transfer_referal.from, tb_transfer_referal.to,'
                                . 'tb_transfer_referal.file_upload ')
                        ->join('users', 'users.id', '=', 'tb_transfer_referal.from')
                        ->where('tb_transfer_referal.id', '=', $id)
                        ->where('tb_transfer_referal.to', '=', $user_id)
                        ->where('tb_transfer_referal.is_approve', '=', 0)
                        ->first();
        return $data;
    }
    
    public function getFisrtNewsNotView($user_id) {
        $dataContent = DB::table('tb_contents')
                        ->selectRaw('tb_contents.id, tb_contents.title, tb_contents.desc, tb_contents.sort_desc, tb_contents.image_url, tvc.totalID ')
                        ->leftJoin(DB::raw('(select tb_view_contents.id as totalID,  tb_view_contents.content_id from tb_view_contents where user_id = '.$user_id.') as  tvc'), 'tb_contents.id', '=', 'tvc.content_id' )
                        ->where('tb_contents.publish', '=', 1)
                        ->whereNull('tvc.totalID')
                        //->where('tb_contents.id', '>', 2)
                        ->orderBy('tb_contents.id', 'ASC')
                        ->first();
        $View = false;
        if(!empty($dataContent)){
            $View = true;
            if($dataContent->totalID != null){
                $View = false;
            }
        }
        $data = (object) array('view' => $View, 'content' => $dataContent);
        return $data;
    }
    
    
}

