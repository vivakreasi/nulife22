<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardSetting extends Model
{
    protected $table = 'tb_reward_setting';

    protected $fillable = array('plan', 'target', 'target_2', 'reward_by_value', 'reward_by_name', 'reward_by');

    public function getListReward() {
        return $this->selectRaw("plan, target, target_2, reward_by_value, reward_by_name, id")
                    ->orderBy('plan')->orderBy('target')->get();
    }

    public function getReward($id) {
        return $this->where('id', '=', $id)->first();
    }

    public function createReward($values) {
        try {
            $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateReward($values) {
        if (!$this->id) return false;
        try {
            $this->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
