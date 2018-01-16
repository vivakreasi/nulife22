<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankCompany extends Model
{
    protected $table = 'tb_bank_company';

    protected $fillable = array('bank_code', 'bank_name', 'bank_account', 'bank_account_name', 'is_active');

    public function createBank($values) {
        if (empty($values)) return false;
        try {
            $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setActive(&$bank, $isActive = true) {
        if (empty($bank)) return false;
        $values = array('is_active' => $isActive ? 1 : 0);
        try {
            $bank->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getOneBank() {
        return $this->selectRaw("bank_name, bank_account, bank_account_name, is_active, id, bank_code")
                    ->where('is_active', '=', 1)
                    ->first();
    }

    public function getBanks() {
        return $this->selectRaw("bank_name, bank_account, bank_account_name, is_active, id, bank_code")->get();
    }

    public function getActiveBanks() {
        return $this->selectRaw("bank_name, bank_account, bank_account_name, is_active, id, bank_code")
                    ->where('is_active', '=', 1)
                    ->get();
    }
    
    public function getActiveBanksID($id) {
        return $this->selectRaw("bank_name, bank_account, bank_account_name, is_active, id, bank_code")
                    //->where('is_active', '=', 1)
                    ->where('id', '=', $id)
                    ->first();
    }

    public function getListActiveBanks() {
        return $this->selectRaw("id, CONCAT_WS(' | ', bank_name, bank_account, bank_account_name) AS bank_description, bank_code")
                    ->where('is_active', '=', 1)
                    ->orderBy('bank_code')
                    ->orderBy('id')
                    ->pluck('bank_description', 'id')
                    ->toArray();
    }
}
