<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan_a_setting extends Model 
{
    protected $table = 'tb_plan_a_setting';

    protected $fillable = array('max_account', 'min_upgrade_b', 
                                'bonus_sponsor', 'cost_reach_upgrade_b', 'cost_unreach_upgrade_b',
                                'bonus_pairing', 'max_pairing_day', 'flush_out_pairing',
                                'bonus_split_nupoint', 'daily_placement_limit');

    //  default value
    private $maxID              = 15;
    private $minUpToB           = 50;
    private $costReachUpToB     = 500000;
    private $costUnReachUpToB   = 600000;
    private $bnsSponsor         = 100000;
    private $maxPairingToday    = 20;
    private $bnsPairing         = 25000;
    private $flushPairing       = 0;
    private $splitNuPoint       = 20;
    private $maxPlacement       = 0;

    //  get data setting plan A
    public function getSetting() {
        return $this->first();
    }

    //  mendapatkan maximum jumlah akun pada saat register plan-A
    public function maxAccount($setting) {
        return empty($setting) ? $this->maxID : $setting->max_account;
    }

    //  mendapatkan maximum jumlah akun pada saat register plan-A
    public function maxPlacement($setting) {
        return empty($setting) ? $this->maxPlacement : $setting->daily_placement_limit;
    }

    //  mendapatkan jumah minimal member kiri dan kanan untuk upgrade ke plan-B
    public function minUpgradeToB($setting) {
        return empty($setting) ? $this->minUpToB : $setting->min_upgrade_b;
    }

    //  mendapatkan harga upgrade plan-B berdasarkan jumlah member dibawahnya
    public function costUpgradeToB($setting, $jmlMember) {
        if (empty($setting)) {
            return ($jmlMember < $this->minUpToB) ? $this->costUnReachUpToB : $this->costReachUpToB;
        } else {
            return ($jmlMember < $setting->min_upgrade_b) ? $setting->cost_unreach_upgrade_b : $setting->cost_reach_upgrade_b;
        }
    }

    //  mendapatkan nilai bonus sponsor untuk sponsor yg masih plan-A
    public function bonusSponsor($setting) {
        return empty($setting) ? $this->bnsSponsor : $setting->bonus_sponsor;
    }

    //  mendapatkan nilai bonus pairing untuk sponsor yg masih plan-A 
    //  dgn limit berapa kali ia sudah dapat bonus pada hari ini
    public function bonusPairing($setting, $totalToday) {
        if (empty($setting)) {
            return ($totalToday < $this->maxPairingToday) ? $this->bnsPairing : $this->flushPairing;
        } else {
            return ($totalToday < $setting->max_pairing_day) ? $setting->bonus_pairing : $setting->flush_out_pairing;
        }
    }

    //  mendapatkan nilai split bonus
    public function splitBonus($setting, $bonus) {
        $result = (object) array('bonusValue' => $bonus, 'nuCashValue' => $bonus, 'nuPointValue' => 0);
        if ($bonus <= 0) return $result;
        $persenPoint = empty($setting) ? $this->splitNuPoint : $setting->bonus_split_nupoint;
        $result->nuPointValue = floor($bonus * $persenPoint / 100);
        $result->nuCashValue = $bonus - $result->nuPointValue;
        return $result;
    }

    public function updateSetting($id, $values) {
        try {
            if (empty($id)) {
                $this->create($values);
            } else {
                $this->where('id', '=', $id)->update($values);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}