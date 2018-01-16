<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus_upgrade_b extends Model
{
    /*  define tablename */
    protected $table = 'tb_bonus_upgrade_b';

    protected $fillable = array('user_id', 'userid', 'from_user_id', 'from_userid', 'bonus_amount', 'notes');

    public function createBonus($sponsor, $from, $trueIfNone = true, $userid_x) {

        if ($sponsor->id != $from->id_referal) {
            if ($sponsor->id == $from->id) {
                $notes = 'Self New Plan-B bonus';
            } else {
                $notes = 'Pass-Up New Plan-B bonus';
            }
        } else {
            $notes = 'New Plan-B bonus';
        }

        if (empty($sponsor) || empty($from)) return false;
        $clsSetting = new \App\Plan_b_setting;
        $setting = $clsSetting->getSetting();
        $bonusAmount = $clsSetting->bonusMemberUpgradeB($setting, ($sponsor->plan_status == 3));
        if ($bonusAmount <= 0) return $trueIfNone;
        $values = array(
            'user_id'       => $sponsor->id,
            'userid'        => $sponsor->userid,
            'from_user_id'  => $from->id,
            'from_userid'   => $userid_x,
            'bonus_amount'  => $bonusAmount,
            'notes'         => $notes
        );
        try {
            $this->insert($values);
            return true;
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }

    /*private function getFirstPlanBSponsor($user)
    {
        $clsSponsor = new User();
        $sponsor = $clsSponsor->find($user->id_referal);
        if ($sponsor->plan_status < 3 || $sponsor->is_active == 0) {
            return $this->getFirstPlanBSponsor($sponsor);
        } else {
            return $sponsor;
        }
    }*/
}
