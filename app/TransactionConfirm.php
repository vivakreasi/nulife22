<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionConfirm extends Model 
{
    /*  define tablename */
    protected $table = 'tb_transaction_confirm';

    protected $fillable = array('transaction_code', 'filename', 'bank_name', 'account_no', 'account_name');
}