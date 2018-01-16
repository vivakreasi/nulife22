<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bonus_pairing extends Model 
{

    /*  define tablename */
    protected $table = 'tb_bonus_pairing';

    protected $fillable = array('user_id', 'userid', 
        'left_id', 'left_user_id', 'left_userid', 
        'right_id', 'right_user_id', 'right_userid', 
        'pair_level', 'bonus_amount', 'nucash_amount', 'nupoint_amount');

    private function getUserBasicQueryToday($user) {
        return $this->where('user_id', '=', $user->id)
                    ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '=', DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"));
    }

    public function getPairingList($user) {
        if (empty($user)) return null;
    }

    private function getCountPairingToday($user) {
        if (empty($user)) return 0;
        return $this->getUserBasicQueryToday($user)->count('id');
    }

    public function getBonus($user, $settings) {
        $result = (object) array('get' => false, 'bonusSplited' => null);
        if (empty($user)) return $result;
        $isB = ($user->plan_status == 3);
        $cslSetting = $isB ? $settings->clsSettingB : $settings->clsSettingA;
        $setting    = $isB ? $settings->settingB : $settings->settingA;
        $countToday = $this->getCountPairingToday($user);
        $bonus      = $cslSetting->bonusPairing($setting, $countToday);
        //dd($bonus);
        $result->get = ($bonus > 0);
        if ($result->get) $result->bonusSplited = $cslSetting->splitBonus($setting, $bonus);

        return $result; 
    }

    public function createBonus($newStrcuture, $listGet) {
        if (!is_array($listGet)) return false;
        if (count($listGet) == 1) {
            $get = $listGet[0];
            $values = array(
                'user_id'       => $get->user->user_id,
                'userid'        => $get->user->userid,
                'left_id'       => ($get->is_right) ? $newStrcuture->id : 0, //$get->child_data->id,
                'left_user_id'  => ($get->is_right) ? $newStrcuture->user_id : 0, //$get->child_data->user_id,
                'left_userid'   => ($get->is_right) ? $newStrcuture->userid : 0, //$get->child_data->userid,
                //'right_id'      => ($get->is_right) ? $get->child_data->id : $newStrcuture->id,
                'right_id'      => ($get->is_right) ? 0 : $newStrcuture->id,
                //'right_user_id' => ($get->is_right) ? $get->child_data->user_id : $newStrcuture->user_id,
                'right_user_id' => ($get->is_right) ? 0 : $newStrcuture->user_id,
                //'right_userid'  => ($get->is_right) ? $get->child_data->userid : $newStrcuture->userid,
                'right_userid'  => ($get->is_right) ? 0 : $newStrcuture->userid,
                'pair_level'    => $get->pair_level,
                'bonus_amount'  => $get->bonusSplited->bonusValue,
                'nucash_amount' => $get->bonusSplited->nuCashValue,
                'nupoint_amount'=> $get->bonusSplited->nuPointValue
            );
        } else {
            $values = [];
            foreach ($listGet as $value) {
                $values[] = array(
                    'user_id'       => $value->user->user_id,
                    'userid'        => $value->user->userid,
                    'left_id'       => ($value->is_right) ? $newStrcuture->id : 0, //$value->child_data->id,
                    'left_user_id'  => ($value->is_right) ? $newStrcuture->user_id : 0, //$value->child_data->user_id,
                    'left_userid'   => ($value->is_right) ? $newStrcuture->userid : 0, //$value->child_data->userid,
                    //'right_id'      => ($value->is_right) ? $value->child_data->id : $newStrcuture->id,
                    'right_id'      => ($value->is_right) ? 0 : $newStrcuture->id,
                    //'right_user_id' => ($value->is_right) ? $value->child_data->user_id : $newStrcuture->user_id,
                    'right_user_id' => ($value->is_right) ? 0 : $newStrcuture->user_id,
                    //'right_userid'  => ($value->is_right) ? $value->child_data->userid : $newStrcuture->userid,
                    'right_userid'  => ($value->is_right) ? 0 : $newStrcuture->userid,
                    'pair_level'    => $value->pair_level,
                    'bonus_amount'  => $value->bonusSplited->bonusValue,
                    'nucash_amount' => $value->bonusSplited->nuCashValue,
                    'nupoint_amount'=> $value->bonusSplited->nuPointValue
                );
            }
        }
        try {
            $this->insert($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

