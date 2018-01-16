<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan_c_bonus_leadership extends Model
{
    /*  define tablename */
    protected $table = 'tb_plan_c_bonus_ld';

    protected $fillable = array('user_id', 'userid', 'from_c_id', 'from_user_id', 'from_userid', 
        'from_structure_id', 'from_structure_level', 'bonus_amount');

    public function createBonus($user, $fromUser, $fromC, $fromStructure, $bonusAmount) {
        if (empty($user) || empty($fromUser) || empty($fromStructure) || $bonusAmount <= 0) return false;
        $values = array(
            'user_id'               => $user->id, 
            'userid'                => $user->userid,
            'from_c_id'             => $fromC->id, 
            'from_user_id'          => $fromUser->id, 
            'from_userid'           => $fromUser->userid, 
            'from_structure_id'     => $fromStructure->id, 
            'from_structure_level'  => $fromStructure->level, 
            'bonus_amount'          => $bonusAmount
        );
        try {

            $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private $minWD      = 100000;

    public function processBonus($fromUser, $fromC, $fromStructure, $rowLeaderShip, &$autoWdListLD, $bonusAmount = 10000) {
        if (empty($fromUser) || empty($fromC) || empty($fromStructure) || empty($rowLeaderShip) || $bonusAmount <= 0) return false;
        $sukses     = true;
        $currentType= 0;
        $arrType    = [1, 2, 3, 4, 5, 6, 7, 8];
        $maxBreak   = 1;
        $break      = 0;
        $budget     = count($arrType) * $bonusAmount;
        $autoWdListLD   = [];
        foreach ($rowLeaderShip as $row) {
            //  auto wd
            if ($row->sisa_bonus_ld + $bonusAmount >= $this->minWD) {
                $autoWdListLD[] = (object) array(
                    'user_id'   => $row->id,
                    'wd_amount' => $this->minWD
                );
            }

            if ($budget <= 0) break;
            //  karena di data user_type id ruby adalah 1 dan black diamond adalah 8, maka urutannya 1 s/d 8
            if ($row->id_type <= $currentType || !in_array($row->id_type, $arrType) || $row->jml_plan_c <= 0) {
                continue;
            }
            if (!$this->createBonus($row, $fromUser, $fromC, $fromStructure, $bonusAmount)) {
                $sukses = false;
                break;
            }
            $budget     -= $bonusAmount;
            if ($currentType < $row->id_type) $currentType = $row->id_type;
            $break      = 0;
        }
        return $sukses;
    }
}
