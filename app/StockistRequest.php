<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockistRequest extends Model
{
    /*  define tablename */
    protected $table = 'tb_request_stockist';

    protected $fillable = array('request_code', 'user_id', 'userid', 'type_stockist_id', 'bank_company_id', 
        'jml_pin', 'harga_pin', 'total_harga', 
        'angka_unik', 'total_transfer', 'status', 'bukti_transfer', 'transfer_at', 'confirm_at', 'reject_at'
    );

    private $stockistType = array(
        1   => array('name' => 'Stockist', 'min_order' => 25),
        2   => array('name' => 'Master Stockist', 'min_order' => 100)
    );

    public function getListType() {
        $result = [];
        foreach ($this->stockistType as $key => $value) {
            $result[$key] = (object) array('id' => $key, 'name' => $value['name'], 'min_order' => $value['min_order']);
        }
        return $result;
    }

    public function getUnconfirmedById($id) {
        return $this->where('id', '=', $id)->where('status', '=', 1)->first();
    }

    public function getTransferedRequest() {
        return $this->join('tb_bank_company', 'tb_bank_company.id', '=', 'tb_request_stockist.bank_company_id')
                ->join('users', 'users.id', '=', 'tb_request_stockist.user_id')
                ->selectRaw("DATE_FORMAT(tb_request_stockist.created_at, '%Y-%m-%d %H:%i') AS tanggal,
                    tb_request_stockist.request_code, 
                    CONCAT_WS('{br}', users.userid, users.name) AS member,
                    (CASE WHEN users.is_stockis = 1 THEN 'Upgrade' ELSE 'Join' END) AS type_join,
                    (CASE WHEN tb_request_stockist.type_stockist_id = 2 THEN 'Master Stockist' ELSE 'Stockist' END) AS as_partner,
                    tb_request_stockist.jml_pin,
                    tb_request_stockist.total_transfer,
                    CONCAT_WS('{br}', tb_bank_company.bank_name, tb_bank_company.bank_account, tb_bank_company.bank_account_name) AS my_bank,
                    '' AS aksi,
                    tb_request_stockist.bukti_transfer,
                    tb_request_stockist.id
                    "
                )
                ->where('tb_request_stockist.status', '=', 1)
                ->whereNotNull('tb_request_stockist.bukti_transfer')
                ->get();
    }

    private $startDigit = 1;
    private $endDigit = 999;

    private function isUnikDigitExist($digit) {
        $test = intval($digit);
        if ($test > $this->endDigit) return true;
        if ($test < $this->startDigit) return true;
        $check = $this->where('angka_unik', '=', $digit)
                    ->whereIn('status', [0, 1])
                    ->whereRaw("(date(created_at) = CURDATE())")
                    ->first();
        return !empty($check);
    }

    private function getUniqueDigit() {
        $loop = 0;
        while ($this->isUnikDigitExist($unik = rand($this->startDigit, $this->endDigit))) {
            $loop += 1;
            if ($loop >= 1000) {
                $unik = 0;
                break;
            }
        }
        return $unik;
    }

    public function createRequest($values) {
        $values['request_code']     = strtoupper(uniqid('P_'));
        $values['angka_unik']       = $this->getUniqueDigit();
        if ($values['angka_unik'] <= 0) return false;
        $values['total_transfer']   = $values['total_harga'] + $values['angka_unik'];
        try {
            $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setUploaded($id, $filename) {
        if (empty($filename)) return false;
        try {
            $this->where('id', '=', $id)->update(['status' => 1, 'bukti_transfer' => $filename, 'transfer_at' => date('Y-m-d H:i:s')]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setConfirm($id, $isConfirm = true) {
        if ($isConfirm) {
            $values = ['status' => 2, 'confirm_at' => date('Y-m-d H:i:s')];
        } else {
            $values = ['status' => 3, 'confirm_at' => null, 'reject_at' => date('Y-m-d H:i:s')];
        }
        try {
            $this->where('id', '=', $id)->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
