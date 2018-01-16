<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionDetail extends Model 
{
    /*  define tablename */
    protected $table = 'tb_transaction_detail';

    protected $fillable = array('transaction_list_id', 'pin_code');
}