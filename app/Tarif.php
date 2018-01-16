<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tarif extends Model
{
    protected $table = 'tb_kirim_tarif';

    protected $fillable = array('dari', 'tujuan', 'tarif');

}