<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\City;

class Provinces extends Model
{

	use City;

    protected $table = 'tb_provinces';

}
