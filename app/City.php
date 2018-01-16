<?php

namespace App;

use Illuminate\Support\Facades\DB;

trait City 
{
    private $cityList;
    public function getCity(){
    	if (!$this->id) return null;
    	if (!empty($this->cityList)) return $this->cityList;
    	$this->cityList = DB::table('tb_kota')
    						->selectRaw("id, nama_kota")
    						->where('id_province', '=', $this->id)->orderBy('nama_kota')->get();
    	return $this->cityList;
    }

    public function getCity2(){
        if (!$this->id) return null;
        if (!empty($this->cityList)) return $this->cityList;
        $this->cityList = DB::table('tb_kota')
            ->selectRaw("nama_kota")
            ->where('id_province', '=', $this->id)->orderBy('nama_kota')->get();
        return $this->cityList;
    }
}
