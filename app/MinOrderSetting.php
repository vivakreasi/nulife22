<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MinOrderSetting extends Model 
{
    /*  define tablename */
    protected $table = 'tb_min_order_setting';

    protected $fillable = array('name', 'amount');
}