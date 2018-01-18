<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionBConfirm extends Model 
{
    /*  define tablename */
    protected $table = 'tb_transactionb_confirm';

    protected $fillable = array('transaction_code', 'filename', 'bank_name', 'account_no', 'account_name');
}