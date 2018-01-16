<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan_c_wd extends Model 
{
    protected $table = 'tb_plan_c_wd';

    protected $fillable = array('userid', 'plan_c_id', 
                            'jml_bonus', 'jml_pot_admin', 'jml_pot_pph', 'jml_wd', 
                            'bonus_c_id', 'bonus_c_type', 'ref_order_id',
                            'status', 'tgl_status', 'reject_note');

    private $potAdmin   = 10000;
    private $jmlPPH     = 0;

    public function createWD($userId, $planId, $bonusId, $jmlBonus, $bonusType = 1, $refOrderId = 0) {
        if (!in_array($bonusType, [1, 2]) || $jmlBonus <= 0) return false;
        if ($refOrderId < 0) $refOrderId = 0;
        if ($bonusType == 2 && $refOrderId <= 0) return false;

        $values = array('userid'        => $userId,
                        'plan_c_id'     => $planId,
                        'bonus_c_id'    => $bonusId,
                        'bonus_c_type'  => $bonusType,
                        'jml_bonus'     => $jmlBonus,
                        'jml_pot_admin' => $this->potAdmin,
                        'jml_pot_pph'   => $this->jmlPPH,
                        'jml_wd'        => $jmlBonus - $this->potAdmin - $this->jmlPPH,
                        'ref_order_id'  => ($bonusType == 2) ? $refOrderId : 0,
                        'status'        => 0);
        try {
            $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function createMultiWdBonusLD($listWdLD) {
        if (empty($listWdLD)) return false;
        $values = [];
        foreach ($listWdLD as $value) {
            $values[] = array(
                'userid'        => $value->user_id,
                'plan_c_id'     => 0,
                'bonus_c_id'    => 0,
                'bonus_c_type'  => 3,
                'jml_bonus'     => $value->wd_amount,
                'jml_pot_admin' => $this->potAdmin,
                'jml_pot_pph'   => $this->jmlPPH,
                'jml_wd'        => $value->wd_amount - $this->potAdmin - $this->jmlPPH,
                'ref_order_id'  => 0,
                'status'        => 0
            );
        }
        try {
            $this->insert($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    //  wd non leadership
    public function getAllListWD($status = 0) {
        return DB::table('tb_plan_c_wd')
                    ->join('users', 'users.id', '=', 'tb_plan_c_wd.userid')
                    ->join('tb_plan_c', 'tb_plan_c.id', '=', 'tb_plan_c_wd.plan_c_id')
                    ->leftJoin('tb_plan_c_bank', 'tb_plan_c_bank.user_id', '=', 'users.id')
                    ->selectRaw("tb_plan_c_wd.tgl_wd, 
                            tb_plan_c_bank.bank_account, 
                            users.userid, 
                            tb_plan_c_wd.id,
                            users.name as nama, 
                            tb_plan_c.plan_c_code,
                            tb_plan_c_wd.jml_wd, 
                            (CASE WHEN tb_plan_c_wd.bonus_c_type = 2 THEN 'Bonus Fly Plan-C' ELSE 'Bonus Plan-C' END) AS bonus_type,
                            tb_plan_c_wd.jml_bonus, 
                            tb_plan_c_wd.jml_pot_admin,  
                            tb_plan_c_wd.status")
                    ->where('tb_plan_c_wd.status', '=', $status)
                    ->whereIn('tb_plan_c_wd.bonus_c_type', [1, 2])
                    ->get();
    }

    //  wd non leadership
    public function getListWDPayroll() {
        $return = DB::table('tb_plan_c_wd')
                    ->join('users', 'users.id', '=', 'tb_plan_c_wd.userid')
                    ->join('tb_plan_c', 'tb_plan_c.id', '=', 'tb_plan_c_wd.plan_c_id')
                    ->leftJoin('tb_plan_c_bank', 'tb_plan_c_bank.user_id', '=', 'users.id')
                    ->selectRaw("tb_plan_c_bank.bank_account,
                            '+' AS plus,
                            tb_plan_c_wd.jml_wd,
                            'C' AS cd,
                            users.name as nama,
                            tb_plan_c.plan_c_code AS keterangan,
                            '1400000237009' AS rekening_perusahaan")
                    ->where('tb_plan_c_wd.status', '=', 0)
                    ->whereIn('tb_plan_c_wd.bonus_c_type', [1, 2])
                    ->get();
        return $return;
    }

    //  wd non leadership
    public function getSummaryBonusByMember() {
        return DB::table('tb_plan_c')
                    ->join('users', 'users.id', '=', 'tb_plan_c.user_id')
                    ->join('tb_plan_c_bonus', 'tb_plan_c_bonus.plan_c_id', '=', 'tb_plan_c.id')
                    ->leftJoin('tb_plan_c_wd', 'tb_plan_c_wd.bonus_c_id', '=', 'tb_plan_c_bonus.id')
                    ->selectRaw("users.userid, users.name as nama, 
                        SUM((CASE WHEN tb_plan_c_wd.status in(0, 2) THEN tb_plan_c_wd.jml_wd 
                        ELSE 0 END)) AS jml_pending,
                        SUM((CASE WHEN tb_plan_c_wd.status = 1 THEN tb_plan_c_wd.jml_wd 
                        ELSE 0 END)) AS jml_transfer,
                        SUM(tb_plan_c_bonus.bonus_amount) AS total_bonus")
                    ->groupBy('users.userid')
                    ->groupBy('users.name')
                    ->get();
    }

    //  wd leadership
    public function getAllListWdLeadership($status = 0) {
        return $this->join('users', 'users.id', '=', 'tb_plan_c_wd.userid')
                    ->leftJoin('tb_plan_c_bank', 'tb_plan_c_bank.user_id', '=', 'users.id')
                    ->selectRaw("DATE_FORMAT(tb_plan_c_wd.tgl_wd, '%Y-%m-%d %H:%i') AS tgl_wd, 
                            tb_plan_c_bank.bank_account, 
                            users.userid, 
                            tb_plan_c_wd.id,
                            users.name as nama, 
                            tb_plan_c_wd.jml_wd, 
                            tb_plan_c_wd.jml_bonus, 
                            tb_plan_c_wd.jml_pot_admin,  
                            tb_plan_c_wd.status")
                    ->where('tb_plan_c_wd.bonus_c_type', '=', 3)
                    ->where('tb_plan_c_wd.status', '=', $status)
                    ->get();
    }

    //  wd leadership
    public function getListWdLeadershipPayroll() {
        return $this->join('users', 'users.id', '=', 'tb_plan_c_wd.userid')
                    ->leftJoin('tb_plan_c_bank', 'tb_plan_c_bank.user_id', '=', 'users.id')
                    ->selectRaw("tb_plan_c_bank.bank_account,
                            '+' AS plus,
                            tb_plan_c_wd.jml_wd,
                            'C' AS cd,
                            users.name as nama,
                            users.userid AS keterangan,
                            '1400000237009' AS rekening_perusahaan")
                    ->where('tb_plan_c_wd.bonus_c_type', '=', 3)
                    ->where('tb_plan_c_wd.status', '=', 0)
                    ->get();
    }

    //  wd leadership
    public function getSummaryLeadershipBonusByMember() {
        return DB::table('tb_plan_c_wd')->join('users', 'users.id', '=', 'tb_plan_c_wd.userid')
                    ->selectRaw("users.userid, users.name as nama, 
                        SUM((CASE WHEN tb_plan_c_wd.status in(0, 2) THEN tb_plan_c_wd.jml_wd 
                        ELSE 0 END)) AS jml_pending,
                        SUM((CASE WHEN tb_plan_c_wd.status = 1 THEN tb_plan_c_wd.jml_wd 
                        ELSE 0 END)) AS jml_transfer,
                        SUM(tb_plan_c_wd.jml_bonus) AS total_bonus")
                    ->where('tb_plan_c_wd.bonus_c_type', '=', 3)
                    ->groupBy('users.userid')
                    ->groupBy('users.name')
                    ->get();
    }

    public function getUnconfirmedById($id, $status = []) {
        if (empty($status)) $status = [0, 2];
        return $this->whereIn('status', $status)->where('id', '=', $id)->first();
    }

    public function setConfirm($id) {
        $values = array('status' => 1, 'tgl_status' => date('Y-m-d H:i:s'), 'reject_note' => '');
        try {
            $this->where('id', '=', $id)->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setMultiConfirm($ids) {
        if (count($ids) < 1) return false;
        $values = array('status' => 1, 'tgl_status' => date('Y-m-d H:i:s'), 'reject_note' => '');
        try {
            $this->whereIn('id', $ids)->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setReject($id, $note) {
        $values = array('status' => 2, 'tgl_status' => date('Y-m-d H:i:s'), 'reject_note' => $note);
        try {
            $this->where('id', '=', $id)->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}