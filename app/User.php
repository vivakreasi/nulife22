<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;

use App\NuCash;
use App\UserReward;
use App\UserRoles;
use App\UserBonus;

use App\NulifeJuli2017;

class User extends Authenticatable
{
    use Notifiable;

    use NulifeJuli2017;
    
    use NuCash, UserReward, UserRoles, UserBonus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name', 'email', 'password',
        'name', 'email', 'password', 'hp', 'userid', 'id_type', 'is_active_type',
        'active_type_at', 'is_stockis', 'id_referal', 'id_referal_b', 'id_referal_c', 'is_active', 'active_at', 'plan_status', 'plan_status_at', 'is_referal_link', 'id_join_type',
        'pin_code'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';
    
    /*
    public function isMember() {
        return ($this->id_type < 100);
    }

    public function isAdmin() {
        return ($this->id_type && $this->id_type >= 100 && $this->id_type < 200);
    }

    public function isDeveloper() {
        return ($this->id_type && $this->id_type == 200);
    }
    */

    public function isStockis() {
        return in_array(intval($this->is_stockis), [1, 2]);
    }
    
    public function isMasterStockis() {
        return ($this->is_stockis == 2);
    }

    public function isPlanB() {
        if (!$this->id) return false;
        return ($this->plan_status >= 3);
    }

    private $countC = false;
    public function isPlanC() {
        if ($this->countC !== false) return ($this->countC > 0);
        $this->countC =  $this->getRelationPlanC()->count('id');
        return ($this->countC > 0);
    }

    public function canUpgradeToB() {
        if (!$this->id) return false;
        return ($this->plan_status == 0);
    }

    public function showUpgradeToB() {
        if (!$this->id) return false;
        return in_array($this->plan_status, [0, 1, 2]);
    }

    private $mySponsor;
    private function initSponsor() {
        if (empty($this->mySponsor)) {
            $this->mySponsor = $this->belongsTo('\App\User', 'id_referal', 'id')->first();
        }
    }

    public function getSponsor($name = '') {
        if (!$this->id) return null;
        $this->initSponsor();
        if ($name == '') return $this->mySponsor;
        return empty($this->mySponsor) ? '' : $this->mySponsor->$name;
    }

    //  relationship
    /*private function getRelationBonusSponsor() {
        return $this->hasMany('\App\Bonus_sponsor', 'user_id', 'id');
    }

    private function getRelationBonusPairing() {
        return $this->hasMany('\App\Bonus_pairing', 'user_id', 'id');
    }

    private function getRelationBonusUpgradeB() {
        return $this->hasMany('\App\Bonus_upgrade_b', 'user_id', 'id');
    }*/

    private function getRelationStructure() {
        return $this->hasOne('\App\StrukturJaringan', 'user_id', 'id');
    }

    private function getRelationPlanC() {
        return $this->hasMany('\App\Plan_c', 'user_id', 'id');
    }
    
    /*
    private $summaryBonus;
    public function getSummaryBonus() {
        if (!$this->id) return null;
        if (!empty($this->summaryBonus) && !$this->summaryBonus->isEmpty()) return $this->summaryBonus;
        $sumSponsor = \App\Bonus_sponsor::whereRaw("user_id = " . $this->id)
                            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS tanggal, bonus_amount AS bonus_sponsor, 
                                0 AS bonus_pairing, 0 AS bonus_up_b, nucash_amount, nupoint_amount")
                            ->toSql();
        $sumPairing = \App\Bonus_pairing::whereRaw("user_id = " . $this->id)
                            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS tanggal, 0 AS bonus_sponsor, bonus_amount AS bonus_pairing,
                                0 AS bonus_up_b, nucash_amount, nupoint_amount")
                            //->groupBy('tanggal')
                            ->toSql();
        $sumUpgradeB= \App\Bonus_upgrade_b::whereRaw("user_id = " . $this->id)
                            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') AS tanggal, 0 AS bonus_sponsor, 0 AS bonus_pairing, 
                                bonus_amount AS bonus_up_b, bonus_amount AS nucash_amount, 0 AS nupoint_amount")
                            //->groupBy('tanggal')
                            ->toSql();
        $this->summaryBonus = DB::table(DB::raw("(" . $sumSponsor . " UNION ALL " . $sumPairing . " UNION ALL " . $sumUpgradeB . ") AS rekap"))
                    ->selectRaw("tanggal, SUM(bonus_sponsor) AS bonus_sponsor, 
                        SUM(bonus_pairing) AS bonus_pairing, SUM(bonus_up_b) AS bonus_up_b, 0 AS grand_total, 
                        SUM(nucash_amount) AS nucash_amount, SUM(nupoint_amount) AS nupoint_amount")
                    ->groupBy('tanggal')
                    ->get();
        return $this->summaryBonus;
    }

    private $bonusSponsor;
    public function getBonusSponsor() {
        if (!empty($this->bonusSponsor) && !$this->bonusSponsor->isEmpty()) return $this->bonusSponsor;
        $this->bonusSponsor = $this->getRelationBonusSponsor()
                        ->leftJoin(DB::raw('users AS from_user'), 'from_user.id', '=', 'tb_bonus_sponsor.from_user_id')
                        ->selectRaw("DATE_FORMAT(tb_bonus_sponsor.created_at, '%Y-%m-%d') AS tanggal, tb_bonus_sponsor.from_userid,
                            from_user.name, tb_bonus_sponsor.bonus_amount, tb_bonus_sponsor.nucash_amount, tb_bonus_sponsor.nupoint_amount, tb_bonus_sponsor.id")
                        ->get();
        return $this->bonusSponsor;
    }

    private $bonusPairing;
    public function getBonusPairing() {
        if (!empty($this->bonusPairing) && !$this->bonusPairing->isEmpty()) return $this->bonusPairing;
        $this->bonusPairing = $this->getRelationBonusPairing()
                        ->selectRaw("DATE_FORMAT(tb_bonus_pairing.created_at, '%Y-%m-%d') AS tanggal, 
                            COUNT(tb_bonus_pairing.id) AS jml_pasangan,
                            SUM(tb_bonus_pairing.bonus_amount) AS bonus_amount, 
                            SUM(tb_bonus_pairing.nucash_amount) AS nucash_amount, 
                            SUM(tb_bonus_pairing.nupoint_amount) AS nupoint_amount")
                        ->groupBy('tanggal')
                        ->get();
        return $this->bonusPairing;
    }

    private $bonusUpgradeB;
    public function getBonusUpgradeB() {
        if (!empty($this->bonusUpgradeB) && !$this->bonusUpgradeB->isEmpty()) return $this->bonusUpgradeB;
        $this->bonusUpgradeB =  $this->getRelationBonusUpgradeB()
                        ->leftJoin(DB::raw('users AS from_user'), 'from_user.id', '=', 'tb_bonus_upgrade_b.from_user_id')
                        ->selectRaw("DATE_FORMAT(tb_bonus_upgrade_b.created_at, '%Y-%m-%d') AS tanggal, tb_bonus_upgrade_b.from_userid,
                            from_user.name, tb_bonus_upgrade_b.bonus_amount, tb_bonus_upgrade_b.id")
                        ->get();
        return $this->bonusUpgradeB;
    }

    public function getTotalBonus() {
        if (!$this->id) return 0;
        return $this->getSummaryBonus()->sum(function($data) {
            return $data->bonus_sponsor + $data->bonus_pairing + $data->bonus_up_b;
        });
    }

    public function getTotalNewCash() {
        if (!$this->id) return 0;
        return $this->getSummaryBonus()->sum('nucash_amount');
    }

    public function getTotalNewPoint() {
        if (!$this->id) return 0;
        return $this->getSummaryBonus()->sum('nupoint_amount');
    }
    */

    private $myStructure;
    public function getUserStructure() {
        if (!empty($this->myStructure)) return $this->myStructure;
        return $this->myStructure = $this->getRelationStructure()->first();
    }

    public function getCodeStructure() {
        if (!$this->id) return '';
        if (!empty($this->myStructure)) return $this->myStructure->kode;
        $this->myStructure = $this->getRelationStructure()->first();
        return empty($this->myStructure) ? '' : $this->myStructure->kode;
    }

    public function getLevelStructure() {
        if (!$this->id) return 0;
        if (!empty($this->myStructure)) return $this->myStructure->level;
        $this->myStructure = $this->getRelationStructure()->first();
        return empty($this->myStructure) ? 0 : $this->myStructure->level;
    }

    private $jmlLeftStructure = false;
    public function getCountLeftStructure() {
        if (!$this->id) return 0;
        if ($this->jmlLeftStructure !== false) return $this->jmlLeftStructure;
        $kode   = $this->getCodeStructure();
        $level  = $this->getLevelStructure();
        $cls    = new \App\StrukturJaringan;
        $this->jmlLeftStructure = $cls->getCountLeft($kode, $level);
        return $this->jmlLeftStructure;
    }

    private $jmlRightStructure = false;
    public function getCountRightStructure() {
        if (!$this->id) return 0;
        if ($this->jmlRightStructure !== false) return $this->jmlRightStructure;
        $kode   = $this->getCodeStructure();
        $level  = $this->getLevelStructure();
        $cls    = new \App\StrukturJaringan;
        $this->jmlRightStructure = $cls->getCountRight($kode, $level);
        return $this->jmlRightStructure;
    }

    private $jmlLeftStructureB = false;
    public function getCountLeftStructureB() {
        if (!$this->id) return 0;
        if ($this->jmlLeftStructureB !== false) return $this->jmlLeftStructureB;
        $this->jmlLeftStructureB = $this->getRelationStructure()
                                        ->leftJoin(
                                            DB::raw("tb_structure AS kiri"), 'kiri.kode', 
                                            'LIKE', 
                                            DB::raw("CONCAT(tb_structure.kode, '-', tb_structure.level + 1, '.1%')"))
                                        ->leftJoin(DB::raw('users AS usr_kiri'), function($join) {
                                            $join->on('usr_kiri.id', '=', 'kiri.user_id')
                                                ->on('usr_kiri.plan_status', '=', DB::raw(3));
                                        })
                                        ->whereNotNull('usr_kiri.id')
                                        ->count('kiri.id');
        return $this->jmlLeftStructureB;
    }

    private $jmlRightStructureB = false;
    public function getCountRightStructureB() {
        if (!$this->id) return 0;
        if ($this->jmlRightStructureB !== false) return $this->jmlRightStructureB;
        $this->jmlRightStructureB = $this->getRelationStructure()
                                        ->leftJoin(
                                            DB::raw("tb_structure AS kanan"), 'kanan.kode', 
                                            'LIKE', 
                                            DB::raw("CONCAT(tb_structure.kode, '-', tb_structure.level + 1, '.2%')"))
                                        ->leftJoin(DB::raw('users AS usr_kanan'), function($join) {
                                            $join->on('usr_kanan.id', '=', 'kanan.user_id')
                                                ->on('usr_kanan.plan_status', '=', DB::raw(3));
                                        })
                                        ->whereNotNull('usr_kanan.id')
                                        ->count('kanan.id');
        return $this->jmlRightStructureB;
    }

    private $myLeaderShip;
    public function getLeaderShip($listLeaderShip, $asc = false) {
        if (!$this->id) return null;
        if (!empty($this->myLeaderShip) && !$this->myLeaderShip->isEmpty()) return $this->myLeaderShip;
        $dtLD   = \App\Plan_c_bonus_leadership::selectRaw("user_id, SUM(bonus_amount) AS total_bonus_ld")
                            ->groupBy('user_id')
                            ->toSql();
        $dtWdC  = \App\Plan_c_wd::selectRaw('userid AS user_id, SUM(jml_bonus) AS total_wd')
                            ->whereRaw("bonus_c_type = 3")
                            ->groupBy('userid')
                            ->toSql();
        return $this->join('tb_structure', 'tb_structure.user_id', '=', 'users.id')
                    ->leftJoin('tb_plan_c', 'tb_plan_c.user_id', '=', 'users.id')
                    ->leftJoin(DB::raw("(" . $dtLD . ") AS bonus_ld"), 'bonus_ld.user_id', '=', 'users.id')
                    ->leftJoin(DB::raw("(" . $dtWdC . ") AS wd_ld"), 'wd_ld.user_id', '=', 'users.id')
                    ->selectRaw("users.id, users.name, users.email, users.hp, users.userid, users.id_type, users.plan_status,
                        tb_structure.kode, tb_structure.posisi, tb_structure.level, tb_structure.foot,
                        COUNT(tb_plan_c.id) AS jml_plan_c, 
                        CAST((COALESCE(bonus_ld.total_bonus_ld, 0) - COALESCE(wd_ld.total_wd, 0)) AS UNSIGNED INTEGER) AS sisa_bonus_ld")
                    ->whereIn('tb_structure.kode', $listLeaderShip)
                    ->groupBy('users.id')
                    ->groupBy('users.name')
                    ->orderBy('tb_structure.kode', $asc ? 'asc' : 'desc')
                    ->get();
    }

    private $listQueuePlanC = [];
    public function getListQueuePlanC($clsPlanC) {
        if (!empty($this->listQueuePlanC)) return $this->listQueuePlanC;
        $query  = $clsPlanC->getUserQueuePlan($this);
        if (!$query->isEmpty()) {
            $this->listQueuePlanC = [];
            foreach ($query as $row) {
                $this->listQueuePlanC[] = $row->plan_c_code;
            }
        }
        return $this->listQueuePlanC;
    }

    private $listActivePlanC = [];
    public function getListActivePlanC($clsPlanC) {
        if (!empty($this->listActivePlanC)) return $this->listActivePlanC;
        $query  = $clsPlanC->getUserActivePlan($this);
        if (!$query->isEmpty()) {
            $this->listActivePlanC = [];
            foreach ($query as $row) {
                $this->listActivePlanC[] = $row->plan_c_code;
            }
        }
        return $this->listActivePlanC;
    }

    private $listRunningPlanC = [];
    public function getListPlanC($clsPlanC) {
        if (!empty($this->listRunningPlanC)) return $this->listRunningPlanC;
        $query  = $clsPlanC->getUserRunningPlan($this, true);
        if (!$query->isEmpty()) {
            $this->listRunningPlanC = [];
            foreach ($query as $row) {
                $this->listRunningPlanC[] = $row->plan_c_code;
            }
        }
        return $this->listRunningPlanC;
    }

    private $clsSettingA;
    private $settingA;
    private function initSettingA() {
        if (empty($this->settingA)) {
            $this->clsSettingA  = new \App\Plan_a_setting;
            $this->settingA     = $this->clsSettingA->getSetting();
        }
    }

    private $myFoot = array('left' => 0, 'right' => 0);
    private $canWD = null;
    public function canWithdrawal() {
        if (!$this->id) return false;
        if (!empty($this->canWD)) return $this->canWD;
        $this->myFoot['left']   = $this->getCountLeftStructure();
        $this->myFoot['right']  = $this->getCountRightStructure();
        $this->canWD = (object) array('can' => false, 'message' => "Can not withdraw any bonus before you join plan-C.");
        /*if (!$this->isPlanC()) {
            if ($this->myFoot['left'] >= 25 && $this->myFoot['right'] >= 25) return $this->canWD;
        }*/
        $this->canWD->can = true;
        $this->canWD->message = '';
        if ($this->plan_status < 3) {
            $this->initSettingA();
            $minUpgrade = $this->clsSettingA->minUpgradeToB($this->settingA);
            $this->canWD->can = ($this->myFoot['left'] < $minUpgrade || $this->myFoot['right'] < $minUpgrade);
            if (!$this->canWD->can) {
                $this->canWD->message = "Can not withdraw any bonus before you upgrade to plan-B.";
            }
        }
        return $this->canWD;
    }

    public function priceUpgradeToB() {
        if (!$this->id) return 0;
        if ($this->plan_status > 0) return 0;
        $this->initSettingA();
        $minMember = min($this->getCountLeftStructure(), $this->getCountRightStructure());
        return $this->clsSettingA->costUpgradeToB($this->settingA, $minMember);
    }

    private function getRelationUpgradeB() {
        return $this->hasOne('\App\UpgradePlanB', 'user_id', 'id');
    }

    private $dataUpgrade;
    public function getDataUpgrade() {
        if (!$this->id || !empty($this->dataUpgrade)) return $this->dataUpgrade;
        $this->dataUpgrade = $this->getRelationUpgradeB()
                                ->leftJoin('tb_bank_company', 'tb_bank_company.id', '=', 'tb_upgrade_b.bank_id')
                                ->selectRaw("tb_upgrade_b.*, 
                                    tb_bank_company.bank_name, tb_bank_company.bank_account,
                                    tb_bank_company.bank_account_name")
                                ->first();
        return $this->dataUpgrade;
    }

    public function startUpgradeToB($data) {
        if (!$this->id) return false;
        $dataU = $this->getDataUpgrade();
        $dataDelivery = $data;

        if (!empty($dataUpgrade)) return false;
        $clsUpgradeB = new \App\UpgradePlanB;
        DB::beginTransaction();
        if ($clsUpgradeB->startUpgrade($this, $dataDelivery, $dataU)) {
            if ($this->updateStatusUpgrade(1)) {
                DB::commit();
                return true;
            }
        }
        DB::rollback();
        return false;
    }

    private $dirUpgradeFile = 'files/upgrade_b';

    public function uploadUpgradeToB($objFile, $fileName) {
        if (!$this->id || empty($fileName)) return false;
        $dataU = $this->getDataUpgrade();
        if (empty($dataU)) return false;
        $values = array(
            'status'        => 1,
            'upload_file'   => $fileName,
            'upload_at'     => date('Y-m-d H:i:s')
        );

        $dir = base_path($this->dirUpgradeFile);

        $clsUpgradeB = new \App\UpgradePlanB;
        DB::beginTransaction();
        if ($this->updateStatusUpgrade(2)) {
            if (\App\Berkas::doUpload($objFile, $dir, $fileName)) {
                try {
                    $dataU->update($values);
                    DB::commit();
                    return true;
                } catch (\Exception $e) {}
            }
        }
        DB::rollback();
        return false;
    }

    public function updateStatusUpgrade($nomor) {
        if ($nomor <= 0) return false;
        $values = ['plan_status' => $nomor];
        try {
            $this->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function confirmUpgrade($operator, &$dataUpB, $action = 0) {
        if (empty($operator) || empty($dataUpB)) return false;
        //$rsponsor = $this->where('id', '=', $this->id_referal)->first();
        $sponsor = $this->getFirstPlanBSponsor($this);

        DB::beginTransaction();
//        $sukses = true;
//        if (!empty($sponsor) && $action == 1) {
//            $clsBonus = new \App\Bonus_upgrade_b;
//            $sukses = $clsBonus->createBonus($sponsor, $this);
//        }
//        if ($sukses) {
            try {
                $dataUpB->update(['status' => ($action == 1) ? 2 : 0, 'approove_by' => $operator->id]);
                $this->update(['plan_status' => ($action == 1) ? 3 : 0, 'id_referal_b' => ($action == 1) ? $sponsor->id : 0]);
                DB::commit();
                return true;
            } catch (\Exception $e) {
            }
//        }
        DB::rollback();
        return false;
    }

    private function getFirstPlanBSponsor($user)
    {
        $sponsor = $this->find($user->id_referal);
        if ($sponsor->plan_status < 3 || $sponsor->is_active == 0) {
            return $this->getFirstPlanBSponsor($sponsor);
        } else {
            return $sponsor;
        }
    }

    public function seedPlanBReferal()
    {
        $users = $this->where('id','>',2)->get();
        foreach ($users as $user) {
            if ($user->plan_status == 3) {
                $sponsorb = $this->getFirstPlanBSponsor($user);
                $user->update(['id_referal_b' => $sponsorb->id]);
            }
        }
        return true;
    }

    private function isNeedRankUp($target, $left, $right) {
        if (empty($target)) return false;
        return ($left >= $target->left && $right >= $target->right && $target->left > 0 && $target->right > 0);
    }

    private $myTarget;
    private $myType;
    private $rowsRanking;
    private $nextTarget;
    private function initRanking() {
        if (empty($this->myType)) {
            $this->myType = $this->belongsTo('\App\UserType', 'id_type', 'id')->first();
        }
    }

    public function needUpgradeRanking($left, $right, $rowsRanking = null) {
        $this->rowsRanking = $rowsRanking;
        if (!$this->id || empty($this->rowsRanking)) return false;
        if (!empty($this->myTarget)) {
            return $this->isNeedRankUp($this->myTarget, $left, $right);
        }
        $this->initRanking();
        $this->nextTarget = empty($this->myType) ? null : $this->myType->getNextTarget($this->rowsRanking);
        $this->myTarget = (object) array(
            'left'          => empty($this->myType) ? 0 : $this->myType->getTarget($this->nextTarget, 'left'),
            'right'         => empty($this->myType) ? 0 : $this->myType->getTarget($this->nextTarget, 'right'),
        );
        return $this->isNeedRankUp($this->myTarget, $left, $right);
    }

    public function rankUpMe() {
        if (!$this->id || empty($this->nextTarget)) return false;
        if ($this->id_type > 8) return true;
        $values = ['id_type' => $this->nextTarget->id];
        try {
            $dataInsert = array('id_user' => $this->id, 'id_user_type' => $this->id_type);
            DB::table('history_user_type')->insert($dataInsert);
            $this->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getRanking($name = '') {
        if (!$this->id) return null;
        $this->initRanking();
        if ($name == '') return $this->myType;
        return empty($this->myType) ? '' : $this->myType->$name;
    }

    private $bonusLeaderShip;
    public function bonusListLeadership() {
        if (!$this->id) return null;
        if (!empty($this->bonusLeaderShip)) return $this->bonusLeaderShip;
        $wdQueryLD  = \App\Plan_c_wd::selectRaw("userid AS user_id, 
                                            GROUP_CONCAT(jml_bonus ORDER BY id) AS list_jml_bonus_wd, 
                                            GROUP_CONCAT(status ORDER BY id) AS list_status_wd,
                                            GROUP_CONCAT(tgl_wd ORDER BY id) AS list_date_wd,
                                            GROUP_CONCAT(reject_note ORDER BY id) AS list_reject_note")
                                ->whereRaw("bonus_c_type = 3")
                                ->whereRaw("userid = " . $this->id)
                                ->groupBy("user_id")
                                ->toSql();

        $this->bonusLeaderShip = $this->join('tb_plan_c_bonus_ld', 'tb_plan_c_bonus_ld.user_id', '=', 'users.id')
                    ->leftJoin(DB::raw('users AS from_user'), 'from_user.id', '=', 'tb_plan_c_bonus_ld.from_user_id')
                    ->leftJoin(DB::raw('(' . $wdQueryLD . ') AS wd_ld'), 'wd_ld.user_id', '=', 'users.id')
                    ->selectRaw("tb_plan_c_bonus_ld.id, tb_plan_c_bonus_ld.user_id, 
                                users.id AS userid, tb_plan_c_bonus_ld.from_c_id, tb_plan_c_bonus_ld.from_user_id, 
                                from_user.userid AS from_userid, 
                                tb_plan_c_bonus_ld.from_structure_id, tb_plan_c_bonus_ld.from_structure_level, tb_plan_c_bonus_ld.bonus_amount,
                                tb_plan_c_bonus_ld.created_at, wd_ld.list_jml_bonus_wd, wd_ld.list_status_wd, wd_ld.list_date_wd, 
                                wd_ld.list_reject_note")
                    ->where('users.id', '=', $this->id)
                    ->orderBy('tb_plan_c_bonus_ld.created_at')
                    ->get();
        return $this->bonusLeaderShip;
    }
    
    public function getAllMember() {
        return DB::table('users')->selectRaw("users.userid, users.name, users.email, users.is_active, users.id_join_type, users.id")
                    ->where('users.id', '>=', 18)
                    ->orderBy('users.id', 'DESC')
                    ->get();
    }

    public function getPlanBMember() {
        return DB::table('users')->selectRaw("users.userid, users.name, users.email, users.is_active, users.id_join_type, users.id")
            ->where('users.id', '>=', 18)
            ->where('users.plan_status', '>=', 3)
            ->orderBy('users.id', 'DESC')
            ->get();
    }

    public function getAllMemberPrepareNotWD() {
        return DB::table('users')->selectRaw("users.userid, users.name, users.email, users.id")
                    ->where('users.id', '>=', 18)
                    ->where('users.is_active', '=', 1)
                    ->where('users.id_type', '<', 100)
                    //->where('users.is_active', '=', 1)
                    ->orderBy('users.id', 'DESC')
                    ->get();
    }
    
    public function getCountMemberPrepareNotWD() {
        return DB::table('users')->selectRaw("users.userid, users.name, users.email, users.id")
                    ->where('users.id', '>=', 18)
                    ->where('users.is_active', '=', 1)
                    ->where('users.id_type', '<', 100)
                    ->count();
    }
    
    public function getAllMemberSisaNotWD($skip, $take) {
        return DB::table('users')
                    ->selectRaw('users.id, users.userid, users.name, users.id, '
                            . '(SELECT SUM(tb_bonus_sponsor.bonus_amount) FROM tb_bonus_sponsor WHERE tb_bonus_sponsor.user_id = users.id) AS bonus_sponsor, '
                            . '(SELECT SUM(tb_bonus_pairing.bonus_amount) FROM tb_bonus_pairing WHERE tb_bonus_pairing.user_id = users.id) AS bonus_pairing, '
                            . '(SELECT SUM(tb_bonus_upgrade_b.bonus_amount) FROM tb_bonus_upgrade_b WHERE tb_bonus_upgrade_b.user_id = users.id) AS bonus_upgrade_b,'
                            . '(SELECT SUM(tb_bonus_summary_old.total_bonus) FROM tb_bonus_summary_old WHERE tb_bonus_summary_old.user_id = users.id) AS old_bonus,'
                            . '(SELECT SUM(tb_nucash_wd.jml_wd) FROM tb_nucash_wd WHERE tb_nucash_wd.id_user = users.id AND tb_nucash_wd.is_transfer = 1) AS withdrawal,'
                            . '(SELECT SUM(tb_nucash_wd.jml_wd) FROM tb_nucash_wd WHERE tb_nucash_wd.id_user = users.id AND tb_nucash_wd.is_transfer = 0) AS outstanding_wd'
                    )
                    ->where('users.id', '>=', 18)
                    ->where('users.is_active', '=', 1)
                    ->where('users.id_type', '<', 100)
                    ->skip($skip)->take($take)
                    ->get();
        
    }
    
    public function getAllMemberSisaNotWDNucash($id) {
        return DB::table('users')
                    ->selectRaw('users.userid, users.name, users.id, '
                            . '(select sum(tb_bonus_summary_old.total_bonus) from tb_bonus_summary_old where tb_bonus_summary_old.user_id = users.id) as old_bonus,'
                            . '(select sum(tb_nucash_wd.jml_wd) from tb_nucash_wd where tb_nucash_wd.id_user = users.id AND tb_nucash_wd.is_transfer = 0) as outstanding_wd,'
                            . '(select sum(tb_nucash_wd.jml_wd) from tb_nucash_wd where tb_nucash_wd.id_user = users.id AND tb_nucash_wd.is_transfer = 1) as withdrawal')
                    ->where('users.id', '=', $id)
                    ->first();
    }
    
    public function getSpesificMemberByID($id) {
        return DB::table('tb_structure')
                    ->join('users', 'users.id', '=', 'tb_structure.user_id')
                    ->join('users_type', 'users.id_type', '=', 'users_type.id')
                    ->selectRaw("users.userid, users.name, tb_structure.kode, users_type.desc, users.id")
                    ->where('users.id', '=', $id)
                    ->where('users.id', '>=', 18)
                    ->where('users.id_type', '<', 100)
                    ->first();
    }
    
    public function getStructureMemberByKode($kode) {
        return DB::table('users')
                    ->join('tb_structure', 'users.id', '=', 'tb_structure.user_id')
                    ->join('users_type', 'users.id_type', '=', 'users_type.id')
                    ->selectRaw("users.userid, users.name, users_type.desc")
                    ->whereIn('tb_structure.kode', $kode)
                    ->whereIn('users.id_type', array(1, 2, 3, 4, 5, 6, 7, 8))
                    ->where('users.id', '>=', 18)
                    ->where('users.is_active', '=', 1)
                    ->where('users.id_type', '<', 100)
                    //->orderBy('users.id_type', 'DESC')
                    ->get();
    }
    
    public function getAllStructureMemberA() {
        return DB::table('users')
                    ->join('users_type', 'users.id_type', '=', 'users_type.id')
                    ->selectRaw('"A" as plan, users_type.left_target as type_target, count(users.id) as total_member')
                    ->where('users.id', '>=', 18)
                    ->where('users.is_active', '=', 1)
                    //->where('users.plan_status', '<=', 2)
                    ->where('users.id_type', '<', 100)
                    ->orderBy('users.id_type', 'ASC')
                    ->groupBy('users.id_type')
                    ->get();
    }
    
    public function getAllStructureMemberB() {
        return DB::table('users')
                    ->join('tb_structure', 'users.id', '=', 'tb_structure.user_id')
                    ->selectRaw('users.userid, "B" as plan, tb_structure.jml_kiri, tb_structure.jml_kanan')
                    ->where('users.id', '>=', 18)
                    ->where('users.is_active', '=', 1)
                    ->where('users.plan_status', '=', 3)
                    ->where('users.id_type', '<', 100)
                    ->orderBy('users.id_type', 'ASC')
                    //->groupBy('users.id_type')
                    ->get();
    }
    
    public function getPlacementPINReportBonus($date) {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        return DB::table('tb_pin_member')
                    ->whereDate('updated_at', $date)
                    ->where('is_used', '>=', 1)
                    ->groupBy(DB::raw('YEAR(updated_at), MONTH(updated_at), DAY(updated_at)'))
                    ->count('id');
    }
    
    public function getSponsorReportBonus($date) {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        return DB::table('tb_bonus_sponsor')
                    ->whereDate('created_at', $date)
                    ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at), DAY(created_at)'))
                    ->sum('bonus_amount');
    }
    
    public function getPairingReportBonus($date) {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        return DB::table('tb_bonus_pairing')
                    ->whereDate('created_at', $date)
                    ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at), DAY(created_at)'))
                    ->sum('bonus_amount');
    }
    
    public function getUpgradePlanBReportBonus($date) {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        return DB::table('tb_bonus_upgrade_b')
                    ->whereDate('created_at', $date)
                    ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at), DAY(created_at)'))
                    ->sum('bonus_amount');
    }
    
    public function getFlyPlanCReportBonus($date) {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        return DB::table('tb_plan_c')
                    ->join('tb_plan_c_bonus', 'tb_plan_c_bonus.plan_c_id', '=', 'tb_plan_c.id')
                    ->whereDate('tb_plan_c.fly_at', $date)
                    ->whereNotNull('tb_plan_c.fly_at')
                    ->groupBy(DB::raw('YEAR(tb_plan_c.fly_at), MONTH(tb_plan_c.fly_at), DAY(tb_plan_c.fly_at)'))
                    ->sum('tb_plan_c_bonus.bonus_amount');
    }
    
    public function getRangkingReportBonus($date) {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        return DB::table('tb_plan_c_wd')
                    ->whereDate('created_at', $date)
                    ->where('status', '=', 0)
                    ->where('bonus_c_type', '=', 3)
                    ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at), DAY(created_at)'))
                    ->sum('jml_bonus');
    }
    
    
    public function getListStockist()
    {
        $stockists = $this->selectRaw("users.id AS uid, users.name, CONCAT_WS(' | ',users.name,tb_kota.nama_kota) AS stockist")
                        ->leftJoin('users_profile','users.id','=','users_profile.id_user')
                        ->leftJoin('tb_kota','users_profile.kota','=','tb_kota.id')
                        ->where('users.is_stockis','>','0')
                        ->orderBy('users.name', 'asc')
                        ->pluck('stockist', 'uid');

        return $stockists;
    }

    public function getPartners($type = 0) {
        //  0 = all, 1 = stockist, 2 = master
        $pType = [1, 2];
        if ($type == 1) $pType = [1];
        if ($type == 2) $pType = [2];
        return $this->selectRaw("userid, name, email, is_stockis, id, '' AS token")
                ->whereIn('is_stockis', $pType)
                ->get();
    }
    
    private $partnerStatus;
    public function getPartnerStatus() {
        if (!$this->id) return null;
        if (!empty($this->partnerStatus)) return $this->partnerStatus;
        $this->partnerStatus = (object) array(
            'statusOrder'   => -1,
            'hasOrder'      => false,
            'dataOrder'     => $this->hasMany('\App\StockistRequest')
                                ->join('tb_bank_company', 'tb_bank_company.id', '=', 'tb_request_stockist.bank_company_id')
                                ->selectRaw("tb_request_stockist.*, 
                                    tb_bank_company.bank_code, tb_bank_company.bank_name, 
                                    tb_bank_company.bank_account, tb_bank_company.bank_account_name")
                                ->whereIn('tb_request_stockist.status', [0, 1])
                                ->orderBy('tb_request_stockist.id')
                                ->first()
        );
        $this->partnerStatus->hasOrder = (!empty($this->partnerStatus->dataOrder));
        if ($this->partnerStatus->hasOrder) $this->partnerStatus->statusOrder = $this->partnerStatus->dataOrder->status;
        return $this->partnerStatus;
    }

    public function setStockist($toBeStockistId) {
        if (!$this->id) return false;
        try {
            $this->update(['is_stockis' => $toBeStockistId]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setPin($pinCode) {
        if (!$this->id) return false;
        try {
            $this->update(['pin_code' => $pinCode]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function getAllPublishNews(){
        $dataContent = DB::table('tb_contents')->where('publish', '=', 1)->orderBy('id', 'ASC')->get();
        return $dataContent;
    }
    
    public function getPublishNews($id){
        $dataContent = DB::table('tb_contents')->where('publish', '=', 1)->where('id', '=', $id)->first();
        return $dataContent;
    }
    
    
}
