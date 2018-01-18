<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionBDetail extends Model 
{
    /*  define tablename */
    protected $table = 'tb_transactionb_detail';

    protected $fillable = array('transaction_list_id', 'pin_code');
}