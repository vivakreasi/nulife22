<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pin extends Model 
{
    /*  define tablename */
    protected $table = 'tb_pin';

    protected $fillable = array('pin_code', 'pin_type_id', 'is_sold');

    private function isCodeExist($kode) {
        return $this->where('pin_code', '=', $kode)->exists();
    }

    private function getCode() {
        $rnd = rand(1, 9999999999);
        return str_pad($rnd, 10, '0', STR_PAD_LEFT);
    }
    
    public function getNewPinCode(&$currentList) {
        $loop = 0;
        $code = $this->getCode();
        while ($this->isCodeExist($code) || in_array($code, $currentList)) {
            $loop += 1;
            if ($loop >= 100) {
                $code = '';
                break;
            }
            $code = $this->getCode();
        }
        if ($code != '') $currentList[] = $code;
        return $code;
    }
}