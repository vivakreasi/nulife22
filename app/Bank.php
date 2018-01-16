<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = array('bank_name', 'bank_account', 'bank_account_name', 'ib_username', 'ib_password');
}
