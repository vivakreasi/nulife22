<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionBList extends Model 
{
    /*  define tablename */
    protected $table = 'tb_transactionb_list';

    protected $fillable = array('transaction_code', 'pin_type_id', 'amount');

    public function ref_pin_type () {

    	return $this->belongsTo ( 'App\PinBType', 'pin_type_id' );
    }

    public function craetedTransactionList($code, $type, $amount) {
        $dataTr = array(
            'transaction_code'  => $code, 
            'pin_type_id'       => $type, 
            'amount'            => $amount
        );
        try {
            $this->create($dataTr);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}