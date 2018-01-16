<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan_c_mandiri extends Model 
{
    protected $table = 'tb_plan_c_mandiri';

    protected $fillable = array('no_urut', 'tgl_check', 'tgl_transaksi', 'uraian_transaksi', 'credit', 'angka_pokok', 'angka_unik', 'angka_desimal', 'processed', 'id_mutasi');

    public function getByDate($date, $useKeyUrut = false) {
        $data = $this->where(DB::raw("date_format(tgl_transaksi, '%Y-%m-%d')"), '=', $date)
                    ->orderBy('id')
                    ->get();
        if ($data->isEmpty()) return [];
        if (!$useKeyUrut) return $data;
        $result = [];
        foreach ($data as $row) {
            $result[$row->no_urut] = $row;
        }
        return $result;
    }

    public function saveData($values, &$result) {
//        try {
            $result = $this->create($values);
            return true;
//        } catch (\Exception $e) {
//            return false;
//        }
    }

    public function deleteUnProcessedByDate($date, $noUrut = []) {
        try {
            if (empty($noUrut)) {
                $this->where(DB::raw("date_format(tgl_transaksi, '%Y-%m-%d')"), '=', $date)
                    ->where('processed', '=', 0)
                    ->delete();
            } else {
                $this->where(DB::raw("date_format(tgl_transaksi, '%Y-%m-%d')"), '=', $date)
                    ->where('processed', '=', 0)
                    ->whereIn('no_urut', $noUrut)
                    ->delete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setProcessed($id) {
        try {
            $this->where('id', '=', $id)->update(['processed' => 1]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setMultiProcessed(array $ids) {
        try {
            $this->whereIn('id', $ids)->update(['processed' => 1]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function fixCreditValue($angkaCredit) {
        $result = array('angka_pokok' => 0, 'angka_desimal' => 0, 'angka_unik' => 0);
        if ($angkaCredit <= 0) return $result;
        $result['angka_pokok'] = floor($angkaCredit);
        $result['angka_unik'] = $result['angka_pokok'] % 1000;
        $result['angka_desimal'] = $angkaCredit - $result['angka_pokok'];
        $result['angka_pokok'] = $result['angka_pokok'] - $result['angka_unik'];
        return $result;
    }
}