<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus_reward extends Model
{
    /*  define tablename */
    protected $table = 'tb_bonus_reward';

    protected $fillable = array('user_id', 'userid', 'reward_id', 'reward_value', 'reward_name', 'foot_left', 'foot_right', 'claim_as', 'status', 'note', 'confirm_at');

    public function claimBonus($values) {
        if (empty($values)) return false;
        try {
            $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function confirmReward() {
        if (!$this->id) return false;
        if ($this->status == 1) return false;
        try {
            $this->update([
                'status'    => 1,
                'confirm_at'=> date('Y-m-d H:i:s')
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getReward($id) {
        return $this->where('id', '=', $id)->first();
    }

    public function getUnConfirmedRewards() {
        return $this->join('tb_reward_setting', 'tb_reward_setting.id', '=', 'tb_bonus_reward.reward_id')
                    ->join('users', 'users.id', '=', 'tb_bonus_reward.user_id')
                    ->selectRaw("DATE_FORMAT(tb_bonus_reward.created_at, '%Y-%m-%d %H:%i') AS tanggal,
                        CONCAT(users.name, ' (', (CASE WHEN users.plan_status = 3 THEN 'B' ELSE 'A' END), ')') AS user_name, 
                        users.userid, 
                        users.hp,
                        tb_reward_setting.plan, 
                        (CASE tb_bonus_reward.claim_as WHEN 1 THEN tb_bonus_reward.reward_value 
                        WHEN 2 THEN tb_bonus_reward.reward_name
                        ELSE 'NOTHING'
                        END) AS reward_chosen,
                        tb_bonus_reward.id,
                        tb_bonus_reward.claim_as,
                        tb_bonus_reward.reward_value,
                        tb_bonus_reward.reward_name")
                    ->where('tb_bonus_reward.status', '=', 0)
                    ->get();
    }
}
