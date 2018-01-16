<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Plan_c_board;
use App\User;

class Plan_c_bank extends Model 
{

    /*  define tablename */
    protected $table = 'tb_plan_c_bank';

    protected $fillable = array('user_id', 'bank_name', 'bank_account', 'bank_account_name', 'status');

    public function getByIdUser($id, $user) {
        if (empty($user)) return null;
        return $this->where('user_id', '=', $user->id)
                    ->where('id', '=', $id)
                    ->orderBy('id')
                    ->first();
    }

    public function getOneByUser($user) {
        if (empty($user)) return null;
        return $this->where('user_id', '=', $user->id)
                    ->orderBy('id')
                    ->first();
    }

    public function saveData($values) {
        if (empty($values)) return false;
        try {
            $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateData($id, $values) {
        if (empty($values)) return false;
        try {
            $this->where('id', '=', $id)->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setSetatus($id, $status) {
        if (empty($values)) return false;
        try {
            $this->where('id', '=', $id)->update(['status' => $status]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}