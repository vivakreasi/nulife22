<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PinBType extends Model 
{
    /*  define tablename */
    protected $table = 'tb_pinb_type';

    protected $fillable = array('pin_type_name', 'business_rights_amount', 'pin_type_price');
}