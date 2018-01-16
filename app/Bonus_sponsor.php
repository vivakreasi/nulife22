<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus_sponsor extends Model
{
    /*  define tablename */
    protected $table = 'tb_bonus_sponsor';

    protected $fillable = array('user_id', 'userid', 'from_user_id', 'from_userid', 'bonus_amount', 'nucash_amount', 'nupoint_amount');

    public function getBonus($user, $settings) {
        $result = (object) array('get' => false, 'bonusSplited' => null);
        if (empty($user)) return $result;
        $isB = ($user->plan_status == 3);
        $cslSetting = $isB ? $settings->clsSettingB : $settings->clsSettingA;
        $setting    = $isB ? $settings->settingB : $settings->settingA;
        $bonus      = $cslSetting->bonusSponsor($setting);
        $result->get = ($bonus > 0);
        if ($result->get) $result->bonusSplited = $cslSetting->splitBonus($setting, $bonus);

        return $result; 
    }

    public function createBonus($spUser, $fromUser, $bonusSplited) {
        if (empty($spUser) || empty($fromUser) || $bonusSplited->bonusValue <= 0) return false;
        $values = array(
            'user_id'       => $spUser->id,
            'userid'        => $spUser->userid,
            'from_user_id'  => $fromUser->id,
            'from_userid'   => $fromUser->userid,
            'bonus_amount'  => $bonusSplited->bonusValue,
            'nucash_amount' => $bonusSplited->nuCashValue,
            'nupoint_amount'=> $bonusSplited->nuPointValue,
        );
        try {
            $this->insert($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
