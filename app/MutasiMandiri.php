<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MutasiMandiri extends Model 
{
    protected $table = 'tb_mutasi_mandiri';

    protected $fillable = array('no_urut', 'tgl_check', 'tgl_transaksi', 'uraian_transaksi', 'debit', 'credit');

    public function saveData($values, &$result) {
//        try {
            $result = $this->create($values);
            return true;
//        } catch (\Exception $e) {
//            return false;
//        }
    }

    public function getDataByDate($date, $useKeyUrut = false) {
        $data = $this->where(DB::raw("DATE_FORMAT(tgl_check, '%Y-%m-%d')"), '=', $date)->orderBy("no_urut")->get();
        if ($data->isEmpty()) return [];
        if (!$useKeyUrut) return $data;
        $result = [];
        foreach ($data as $row) {
            $result[$row->no_urut] = $row;
        }
        return $result;
    }

    public function getById($id) {
        return $this->where('id', '=', $id)->first();
    }

    public function getUnUsedPaymentCredit($getRows = false) {
        $result = DB::table('tb_mutasi_mandiri')
                    ->leftJoin('tb_order_plan_c', 'tb_order_plan_c.id_mutasi', '=', 'tb_mutasi_mandiri.id')
                    ->selectRaw("tb_mutasi_mandiri.tgl_transaksi, tb_mutasi_mandiri.uraian_transaksi,
                            tb_mutasi_mandiri.credit, tb_mutasi_mandiri.id")
                    ->where('tb_order_plan_c.id')
                    ->where('tb_mutasi_mandiri.credit', '>', 0);
        if ($getRows) return $result->get();
        return $result->whereRaw(" 1 = 0 ")->get();
    }
}