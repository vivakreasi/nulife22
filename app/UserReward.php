<?php

namespace App;

use Illuminate\Support\Facades\DB;

use App\RewardSetting;
use App\Bonus_reward;

trait UserReward
{

    private function getQueryReward($plan) {
        $myId = $this->id;
        return RewardSetting::where('tb_reward_setting.plan', '=', $plan)
                    ->leftJoin('tb_bonus_reward', function($join) use($myId) {
                        $join->on('tb_bonus_reward.reward_id', '=', 'tb_reward_setting.id')
                            ->on('tb_bonus_reward.user_id', '=', DB::raw($myId));
                    });
    }

    private $myRewardListA;
    private function getRewardListA($left, $right) {
        if (!$this->id) return null;
        if (!empty($this->myRewardListA)) return $this->myRewardListA;
        $this->myRewardListA = $this->getQueryReward('A')
                                    ->selectRaw("tb_reward_setting.target AS target_kiri, 
                                            tb_reward_setting.target_2 AS target_kanan,
                                            '' AS reward_description, 
                                            '' AS status_text, 
                                            tb_reward_setting.id, 
                                            COALESCE(tb_bonus_reward.status, -1) AS status,
                                            tb_reward_setting.reward_by_value, 
                                            tb_reward_setting.reward_by_name, 
                                            tb_reward_setting.reward_by, 
                                            COALESCE(tb_bonus_reward.claim_as, tb_reward_setting.reward_by) AS claim_as,
                                            tb_bonus_reward.reward_value, 
                                            tb_bonus_reward.reward_name,
                                            (CASE WHEN tb_reward_setting.target <= " . $left . " AND tb_reward_setting.target_2 <= " . $right . " THEN 1 ELSE 0 END) AS status_target,
                                            tb_bonus_reward.created_at AS create_reward,
                                            tb_bonus_reward.confirm_at AS confirm_reward,
                                            '' AS tgl_status"
                                        )
                                    ->orderBy('tb_reward_setting.id')
                                    ->get();
        return $this->myRewardListA;
    }

    private $myRewardListB;
    private function getRewardListB($left, $right) {
        if (!$this->id) return null;
        if (!empty($this->myRewardListB)) return $this->myRewardListB;
        $this->myRewardListB = $this->getQueryReward('B')
                                    ->selectRaw("tb_reward_setting.target AS target_kiri, 
                                            tb_reward_setting.target_2 AS target_kanan,
                                            '' AS reward_description, 
                                            '' AS status_text, 
                                            tb_reward_setting.id, 
                                            COALESCE(tb_bonus_reward.status, -1) AS status,
                                            tb_reward_setting.reward_by_value, 
                                            tb_reward_setting.reward_by_name, 
                                            tb_reward_setting.reward_by, 
                                            COALESCE(tb_bonus_reward.claim_as, tb_reward_setting.reward_by) AS claim_as,
                                            tb_bonus_reward.reward_value, 
                                            tb_bonus_reward.reward_name,
                                            (CASE WHEN tb_reward_setting.target <= " . $left . " AND tb_reward_setting.target_2 <= " . $right . " THEN 1 ELSE 0 END) AS status_target,
                                            tb_bonus_reward.created_at AS create_reward,
                                            tb_bonus_reward.confirm_at AS confirm_reward,
                                            '' AS tgl_status"
                                        )
                                    ->orderBy('tb_reward_setting.id')
                                    ->get();
        return $this->myRewardListB;
    }

    public function getRewardList($plan) {
        $plan = strtoupper($plan);
        $left = ($plan == 'B') ? $this->getCountLeftStructureB() : $this->getCountLeftStructure();
        $right = ($plan == 'B') ? $this->getCountRightStructureB() : $this->getCountRightStructure();
        if ($plan == 'A') return $this->getRewardListA($left, $right);
        if ($plan == 'B') return $this->getRewardListB($left, $right);
        return null;
    }

    private $selectReward;
    public function getSelectedReward($id, $plan) {
        if (!$this->id) return null;
        if (!empty($this->selectReward)) return $selectReward;
        $this->selectReward = $this->getQueryReward($plan)
                                    ->where('tb_reward_setting.id', '=', $id)
                                    ->whereNull('tb_bonus_reward.id')
                                    ->selectRaw("tb_reward_setting.*")
                                    ->first();
        return $this->selectReward;
    }

    public function claimReward($reward, $claimAs = 1) {
        if (empty($reward)) return false;
        if (!in_array($claimAs, [1, 2, 3])) return false;
        if (!$this->isPlanB() && $reward->plan == 'B') return false;
        if ($reward->reward_by != 3 && $claimAs != $reward->reward_by) return false;
        if ($this->getCountLeftStructure() < $reward->target || $this->getCountRightStructure() < $reward->target) return false;
        $values = array(
            'user_id'       => $this->id, 
            'userid'        => $this->userid, 
            'reward_id'     => $reward->id, 
            'reward_value'  => $reward->reward_by_value, 
            'reward_name'   => $reward->reward_by_name, 
            'foot_left'     => $this->getCountLeftStructure(), 
            'foot_right'    => $this->getCountRightStructure(), 
            'claim_as'      => $claimAs, 
            'status'        => 0
        );
        return (new Bonus_reward)->claimBonus($values);
    }
}

