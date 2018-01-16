<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan_c_pin extends Model 
{
    /*
    --  run query ini untuk menambahkan kolom yg akan digunakan oleh sistem plan-C
    ALTER TABLE tb_order_plan_c
        ADD `unik_kirim` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '000',
        ADD `transfer_kirim` int(11) NOT NULL DEFAULT '0',
        ADD `harga_pin` int(11) NOT NULL DEFAULT '0',
        ADD `unik_pin` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '000',
        ADD `transfer_pin` int(11) NOT NULL DEFAULT '0',
        ADD `input_flag` smallint(6) NOT NULL DEFAULT '0',
        ADD `created_at` timestamp NULL DEFAULT NULL,
        ADD `updated_at` timestamp NULL DEFAULT NULL;
    */

    /*  define tablename */
    protected $table = 'tb_order_plan_c';

    protected $fillable = array('userid', 'nama_penerima', 'alamat_lengkap',
                                'x_kota_biaya', 'nohp', 'x_norek', 'x_an',
                                'x_jmlpin', 'harus_transfer', 'tgl_order',
                                'tgl_konfirmasi', 'ip', 'dari_bank',
                                'dari_norek', 'dari_an', 'status', 'tgl_approve',
                                'unik_kirim', ' transfer_kirim', 
                                'harga_pin', 'unik_pin', 'transfer_pin', 'input_flag');

    //private $maxLimit = 1000;
    //private $hargaPin = 500000;
//    private $hargaPin = 10000; //  testing

    private $noRekeningBankC = '14-000-2307-0007';
    private $anRekeningBankC = 'RAMADHAN SUROHADI';
    private $nmRekeningBankC = 'BANK MANDIRI';

    public function getAllOrders($status = 0) {
        /*
        (case when status = 5 then 'Sukses' when status = 3 then 'Belum Approve' else 'Belum Transfer' end) as status_transfer,
        */
        //$query = DB::table($this->table)->selectRaw("tgl_order, nama_penerima, x_jmlpin, (case when harus_transfer > 0 then harus_transfer else transfer_pin end) as nilai_transfer, status, (case when status = 5 then coalesce(tgl_approve, coalesce(tgl_konfirmasi, tgl_order)) when status = 3 then coalesce(tgl_konfirmasi, tgl_order) else tgl_order end) as tgl_status, id");
        $query = $this->selectRaw("tgl_order, 
                    userid,
                    nama_penerima, 
                    x_jmlpin, 
                    (case when harus_transfer > 0 then harus_transfer else transfer_pin end) as nilai_transfer, 
                    status, 
                    (case when status = 3 then coalesce(tgl_approve, coalesce(tgl_konfirmasi, tgl_order)) when status = 5 then coalesce(tgl_konfirmasi, tgl_order) else tgl_order end) as tgl_status, 
                    id, bukti_transfer");
        //if ($status == 0) return $query->where('status', 5)->get();
        if ($status == 0) return $query->where('status', 3)->get();
        //return $query->whereIn('status', [3,4])->get();
        return $query->whereIn('status', [4, 5])->get();
    }

    public function getAllOrdersWithAddress() {
        //return $this->selectRaw('tgl_order, x_jmlpin, (case when harus_transfer > 0 then harus_transfer else transfer_pin end) as nilai_transfer, nama_penerima, alamat_lengkap')->whereNotNull('alamat_lengkap')->where('status', 5)->orderBy('id')->get();
        return $this->selectRaw('tgl_order, x_jmlpin, (case when harus_transfer > 0 then harus_transfer else transfer_pin end) as nilai_transfer, nama_penerima, alamat_lengkap')->whereNotNull('alamat_lengkap')->where('status', 3)->orderBy('id')->get();
    }

    public function getUserOrders($user) {
        if (empty($user)) return [];
        return $this->where('userid', '=', $user->userid)->orderBy('id')->get();
    }

    public function getById($id) {
        return $this->where('id', '=', $id)->first();
    }

    public function getCountPinUserC($user, $clsPlanC, $forOrder = false) {
        $result = (object) array('pin_id' => [], 'total_pin' => 0, 
                                'sisa' => 0, 'usable_id' => 0, 
                                'available_order' => 0);
        if (empty($user)) return $result;
        $pin = $this->where('userid', '=', $user->userid)
                    ->orderBy('id')
                    ->get();
        if (empty($pin)) return $result;
        foreach ($pin as $row) {
            if ($forOrder) {
                $result->pin_id[$row->id] = $row->x_jmlpin;
                $result->total_pin += $row->x_jmlpin;
            } else {
                if ($row->status == 3) {
                    $result->pin_id[$row->id] = $row->x_jmlpin;
                    $result->total_pin += $row->x_jmlpin;
                }
            }
        }
        $totalUsed = $clsPlanC->getPlanC($user)->count();
        $result->sisa = $result->total_pin - $totalUsed;
        $current = 0;
        foreach ($result->pin_id as $key => $value) {
            $current += $value;
            if ($current > $totalUsed) {
                $result->usable_id = $key;
                break;
            }
        }

        $clsPlanC = new Plan_c();

        $planCsetting = $this->getPlanCSetting();
        $maxLimit = $planCsetting->cls->maxAccount($planCsetting->setting);
        $runningPlanC = $clsPlanC->getCountRunningPlanC($user);
        $nyangkut = $clsPlanC->getCountFlyNoWD($user);
        if($nyangkut > 0) {
            if(($maxLimit - ($result->sisa + $runningPlanC)) < 1){
                $result->available_order = $nyangkut;
            }else{
                $result->available_order = $maxLimit - ($result->sisa + $runningPlanC) + $nyangkut;
            }
        }else{
            $result->available_order = $maxLimit - ($result->sisa + $runningPlanC);
        }

        if ($result->available_order < 0) $result->available_order = 0;
        return $result;
    }

    private $startDigit = 1;
    private $endDigit = 999;

    private $planCSetting;

    private function getPlanCSetting() {
        $clsSetting = new \App\Plan_c_setting;
        if (empty($this->planCSetting)) $this->planCSetting = $clsSetting->getSetting();
        return (object) array(
            'cls'       => $clsSetting,
            'setting'   => $this->planCSetting
        );
    }

    private function isUnikDigitExist($digit) {
        $test = intval($digit);
        if ($test > $this->endDigit) return true;
        if ($test < $this->startDigit) return true;
        $check = $this->where('unik_pin', '=', $digit)
                    ->where('status', '=', 4)
                    ->whereRaw("(date_format(tgl_order, '%Y-%m-%d') = " . date('Y-m-d') . ")")
                    ->first();
        return !empty($check);
    }

    public function setUniqueDigit($unik) {
        $len = strlen(strval($this->endDigit));
        return str_pad($unik, $len, '0', STR_PAD_LEFT);
    }

    private function getUniqueDigit() {
        function getUnique() {
            return rand(1, 999);
        }
        $loop = 0;
        while ($this->isUnikDigitExist($unik = $this->setUniqueDigit(rand($this->startDigit, $this->endDigit)))) {
            $loop += 1;
            if ($loop >= 1000) {
                $unik = '000';
                break;
            }
        }
        return $unik;
    }

    public function saveOrder($user, $amount, &$order) {
        if (empty($user) || $amount <= 0) return false;
        $unik_pin = $this->getUniqueDigit();
        if ($unik_pin == '000') return false;
        $planCsetting = $this->getPlanCSetting();
        $hargaPin = $planCsetting->cls->costPkg($planCsetting->setting);
        $data = array(
                'userid'        => $user->userid,
                'nama_penerima' => $user->name,
                'x_jmlpin'      => $amount,
                'status'        => 4,
                'unik_pin'      => $unik_pin,
                'harga_pin'     => $amount * $hargaPin,
                'transfer_pin'  => ($amount * $hargaPin) + intval($unik_pin),
                'harus_transfer'=> ($amount * $hargaPin) + intval($unik_pin),
                'input_flag'    => 11,
                'tgl_order'     => date('Y-m-d H:i:s')
            );
        try {
            $order = $this->create($data);
            return true;
        } catch (\Exception $e) {
        }
        return false;
    }

    public function getInstruction($newOrderData) {
        if (empty($newOrderData)) return null;
        $planCsetting = $this->getPlanCSetting();
        $hargaPin = $planCsetting->cls->costPkg($planCsetting->setting);
        return (object) array(
                'bank_nama'     => $this->nmRekeningBankC,
                'bank_rekening' => $this->noRekeningBankC,
                'bank_pemilik'  => $this->anRekeningBankC,
                'jml_pin'       => $newOrderData->x_jmlpin,
                'harga_satuan'  => $hargaPin,
                'nilai_transfer'=> $newOrderData->transfer_pin,
                'expire'        => date('Y-m-d H:i:s', strtotime($newOrderData->tgl_order) + 60*60)
            );
    }

    public function getNewByOrderDate($date, $lastHour = true) {
        $data = $this->where(DB::raw("date_format(tgl_order, '%Y-%m-%d')"), '=', $date)
                    ->where('status', '=', 4);
        if ($lastHour) {
            $data = $data->where('tgl_order', '>=', DB::raw("DATE_SUB(NOW(), INTERVAL 1 HOUR)"));
        }
        return $data->orderBy('id')->get();
    }

    public function setApprove($id, $idMutasi) {
        if (empty($idMutasi)) return false;
        try {
            $this->where('id', '=', $id)->update(['status' => 3, 'tgl_approve' => date('Y-m-d H:i:s'), 'id_mutasi' => $idMutasi]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function isMutasiUsed($idMutasi) {
        $data = $this->where('id_mutasi', '=', $idMutasi)->first();
        return !empty($data);
    }

    private $dirUpload = 'files/pin_planc';

    public function uploadPinPlanc($id, $objFile, $fileName) {
        if (!$id || empty($id) || empty($fileName)) return false;
        $values = array(
            'status'            => 5,
            'bukti_transfer'    => $fileName,
            'tgl_konfirmasi'    => date('Y-m-d H:i:s')
        );

        $dir = base_path($this->dirUpload);

        DB::beginTransaction();
        if (\App\Berkas::doUpload($objFile, $dir, $fileName)) {
            try {
                $this->where('id', '=', $id)->update($values);
                DB::commit();
                return true;
            } catch (\Exception $e) {}
        }
        DB::rollback();
        return false;
    }

}

