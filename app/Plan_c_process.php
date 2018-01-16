<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan_c_process extends Model 
{
    /*  define tablename */
    protected $table = 'tb_plan_c_process';

    protected $fillable = array('proses');

    public function processExist() {
        return !$this->get()->isEmpty();
    }

    public function lockProcess() {
        $this->lockForUpdate();
    }

    public function createProcess() {
        try {
            $this->create(['proses' => 1]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function processDone() {
        $this->query()->truncate();
    }
}