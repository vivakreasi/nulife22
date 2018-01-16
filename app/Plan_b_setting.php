<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan_b_setting extends Model 
{
    protected $table = 'tb_plan_b_setting';

    protected $fillable = array('bonus_up_member_b', 'require_planb', 'bonus_sponsor', 
                                'bonus_pairing', 'max_pairing_day', 'flush_out_pairing',
                                'bonus_split_nupoint','product_id','subsidi_tarif_kirim');

    //  default value
    private $bnsUpMemberB       = 50000;
    private $requirePlanB       = true;
    private $bnsSponsor         = 100000;
    private $maxPairingToday    = 20;
    private $bnsPairing         = 25000;
    private $flushPairing       = 0;
    private $splitNuPoint       = 20;

    public function getSetting() {
        return $this->first();
    }

    public function bonusMemberUpgradeB($setting, $sponsorPlanB = false) {
        if ($sponsorPlanB) {
            return empty($setting) ? $this->bnsUpMemberB : $setting->bonus_up_member_b;
        } else {
            if (empty($setting)) {
                return $this->requirePlanB ? 0 : $this->bnsUpMemberB;
            } else {
                return ($setting->require_planb) ? 0 : $setting->bonus_up_member_b;
            }
        }
    }

    public function bonusSponsor($setting) {
        return empty($setting) ? $this->bnsSponsor : $setting->bonus_sponsor;
    }

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