<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\User;
use App\AppTools;

class StrukturJaringanPlanB extends Model
{
    protected $table = 'tb_structure_b';

    protected $fillable = array('kode', 'user_id', 'userid', 'upline_id', 'upline', 'posisi', 'level', 'foot', 'jml_kiri', 'jml_kanan');

    private $maxShowLevel = 4;

    public function getStructureByUserId($userId) {
        return $this->leftJoin('users', 'tb_structure_b.user_id', '=', 'users.id')
            ->leftJoin('users_type', 'users_type.id', '=', 'users.id_type')
            ->selectRaw("tb_structure_b.*, users.name, users.id_type, users.plan_status, users_type.code, users_type.desc, users_type.short_desc")
            ->where('tb_structure_b.userid', '=', $userId)->first();
    }

    public function getStructure($owner, $user, $toTop = 0, $placement = false) {
        function setStructure($owner, $row, $maxLevel, $struktur, $strukturs, &$cStruktur, $countLeft, $countRight, $placement = false) {
            if (!array_key_exists($struktur->id, $cStruktur)) {
                $tmp = [];
                $kosong = empty($row);
                $fId = strtoupper($kosong ? '' : $row->userid);
                $dataId = strtoupper($kosong ? $struktur->id : $row->userid);
                $format = '';
                if (!$kosong) {
                    if ($struktur->level > 1) {
                        if (!empty($row->name)) {
                            if ($placement) {
                                $goUrl = route('plan.placement.b', $dataId);
                            } else {
                                $goUrl = route('plan.network.binary.b', $dataId);
                            }
                            $format .= '<button class="btn btn-success btn-tree btn-open-tree" data-url="' . $goUrl . '" data-id="' . $dataId . '" onclick="goTree($(this));">Open</button>';
                        }
                    } elseif ($struktur->level == 1) {
                        if (strtoupper($owner->userid) != $dataId) {
                            $format .= '<select class="form-control form-control-tree select-top-tree" data-id="' . $dataId . '" onchange="goTop($(this));">';
                            $format .= '<option value="0">-Select-</option>';
                            for ($s = 1; $s <= $maxLevel - 1; $s++) {
                                if ($placement) {
                                    $goUrl = route('plan.placement.b', [$dataId, $s]);
                                } else {
                                    $goUrl = route('plan.network.binary.b', [$dataId, $s]);
                                }
                                $format .= '<option value="' . $s . '" data-url="' . $goUrl . '">Top ' . $s . '</option>';
                            }
                            $format .= '</select>';
                        }
                    }
                } else {
                    if ($placement && !empty($struktur) && array_key_exists($struktur->parent_id, $strukturs)) {
                        $parent = $strukturs[$struktur->parent_id];
                        if (!empty($parent->data)) {
                            $format .= '<button class="btn btn-primary btn-tree btn-placement" data-parent="' . $parent->data->kode . '" data-foot="' . $struktur->kaki . '" onclick="goPlacement($(this));">Here</button>';
                        }
                    }
                }
                $format .= '<div class="plan-tree">';
                $format .= '<img src="' . asset("assets/img/logoicon-hijau" . ($kosong ? "-disabled" : '') . ".png") . '">';
                $planStatus = '';
                $nama   = '';
                if (!$kosong) {
                    $planStatus = ($row->plan_status == 3) ? 'B' : 'A';
                    $nama       = empty($row->name) ? '.....' : $row->name;
                    if (strlen($nama) > 9) {
                        $nama = substr($nama, 0, 6) . '...';
                    }
                }
                if ($placement) {
                    $format .= '<div>' . ($fId == '' ? '&nbsp;' : $fId) . '</div>';
                } else {
                    if ($fId) $format .= '<div>' . $fId . '</div>';
                }
                if (!empty($nama)) {
                    $format .= '<div>' . $nama . '</div>';
                }
                $format .= '</div>';
                if (!$kosong) {
                    if (empty($row->short_desc)) {
                        $format .= '<div class="occupation">Reguler (A)</div>';
                    } else {
                        $format .= '<div class="occupation">' . $row->short_desc . ' (' . $planStatus . ')</div>';
                    }
                }
                if ($fId) {
                    $format .= '<div style="display:block;">';
                    $format .= '<div class="left-binary">' . $countLeft . '</div>';
                    $format .= '<div class="right-binary">' . $countRight . '</div>';
                    $format .= '</div>';
                }
                $tmp[] = "{v:'" . $struktur->id . "', f:'" . $format . "'}";
                $current = $struktur;
                for ($i = 1; $i <= $maxLevel; $i++) {
                    if ($i > 1) {
                        if (!empty($current)) {
                            if (array_key_exists($current->parent_id, $strukturs)) {
                                $current = $strukturs[$current->parent_id];
                                $tmp[] = "'$current->id'";
                            } else {
                                $tmp[] = "''";
                                $current = [];
                            }
                        } else {
                            $tmp[] = "''";
                        }
                    }
                }
                $cStruktur[$struktur->id] = "[" . implode(',', $tmp) . "]";
            }
        }

        $maxLevel = $this->maxShowLevel;

        $result = (object) array('maxLevel' => $maxLevel, 'data' => []);
        if (empty($owner) || empty($user)) return $result;

        $toTop = intval($toTop);

        $strukturs = \App\AppTools::getRangeStructure($maxLevel);

        if (!empty($strukturs)) {
            $dataTop = $this->getStructureByUserId($user->userid);
            //dd($dataTop);
            if ($toTop > $this->maxShowLevel - 1) $toTop = $this->maxShowLevel - 1;
            if ($toTop > 0 && !empty($dataTop)) {
                for ($i = 0; $i < $toTop; $i++) {
                    $dataTop = $this->getStructureByUserId($dataTop->upline);
                    if (empty($dataTop)) break;
                    if ($dataTop->user_id == $owner->id) break;
                }
            }
            if (!empty($dataTop)) {
                $left   = $this->getCountLeft($dataTop->kode, $dataTop->level);
                $right  = $this->getCountRight($dataTop->kode, $dataTop->level);
                setStructure($owner, $dataTop, $maxLevel, $strukturs['1_1'], $strukturs, $result->data, $left, $right, $placement);
                $strukturs['1_1']->data = $dataTop;
                foreach ($strukturs as $key => $value) {
                    $level = $value->level;
                    $parentData = array_key_exists($value->parent_id, $strukturs) ? $strukturs[$value->parent_id]->data : null;
                    if ($level > 1) {
                        $kaki = $value->kaki;
                        if (!empty($parentData)) {
                            $childData  = $this->leftJoin('users', 'tb_structure_b.user_id', '=', 'users.id')
                                ->leftJoin('users_type', 'users_type.id', '=', 'users.id_type')
                                ->selectRaw("tb_structure_b.*, users.name, users.id_type, users.plan_status, users_type.code, users_type.desc, users_type.short_desc")
                                ->where('tb_structure_b.upline', '=', $parentData->userid)
                                ->where('tb_structure_b.foot', '=', $kaki)
                                ->first();
                        } else {
                            $childData = null;
                        }
                        $left   = empty($childData) ? 0 : $this->getCountLeft($childData->kode, $childData->level);
                        $right  = empty($childData) ? 0 : $this->getCountRight($childData->kode, $childData->level);
                        setStructure($owner, $childData, $maxLevel, $value, $strukturs, $result->data, $left, $right, $placement);
                        $strukturs[$key]->data = $childData;
                    }
                }
            }
        }

        return $result;
    }

    /*
     *  TO DO : view genealogy view @ admin area
     */
    public function getGenealogy() {

    }

    private $showActualMaxLevel = 5;

    public function getActualStructure($userOwner, $userTarget) {
        if (empty($userOwner)) return null;
        if (empty($userTarget)) $userTarget = $userOwner;
        $owner = $this->where('userid', '=', $userOwner->userid)->first();
        $start = $this->where('userid', '=', $userTarget->userid)->first();
        if (empty($start)) return null;
        $data = $this->leftJoin('users', 'tb_structure_b.userid', '=', 'users.userid')
            ->selectRaw("tb_structure_b.id, tb_structure_b.kode, tb_structure_b.userid, tb_structure_b.level - " . $start->level . " AS level, tb_structure_b.foot, 
                        users.name, users.created_at, users.plan_status, 
                        '0' as parent_kode, 0 as kiri, 0 as kanan")
            ->where('tb_structure_b.kode', 'LIKE', $owner->kode . '%')
            ->where('tb_structure_b.kode', 'LIKE', $start->kode . '%')
            ->whereBetween('tb_structure_b.level', [$start->level, $start->level + $this->showActualMaxLevel - 1])
            ->orderBy('tb_structure_b.kode')
            ->get();
        if (!empty($data)) {
            foreach ($data as $row) {
                /*$rowKode    = $row->kode . '-%';
                $kiriKode   = $row->kode . '-' . ($row->level + 1) . '.1%';
                $kananKode  = $row->kode . '-' . ($row->level + 1) . '.2%';
                $summary    = $this->selectRaw("SUM((CASE WHEN kode LIKE '" . $kiriKode . "' THEN 1 ELSE 0 END)) AS kiri,
                                        SUM((CASE WHEN kode LIKE '" . $kananKode . "' THEN 1 ELSE 0 END)) AS kanan")
                                    ->where('kode', 'LIKE', $rowKode)
                                    ->first();
                $row->kiri  = (!empty($summary)) ? $summary->kiri : 0;
                $row->kanan = (!empty($summary)) ? $summary->kanan : 0;
                */
                $row->parent_kode = AppTools::getParentCodeFromCode($row->kode, '-');
            }
        }
        return $data;
    }

    public function getRequirePlacement($user) {
        if (empty($user)) return null;
        return User::where('users.id_referal_b', '=', $user->id)
            ->leftJoin('tb_structure_b', 'tb_structure_b.user_id', '=', 'users.id')
            ->selectRaw('users.id, users.userid, users.name, users.email, users.active_at, users.created_at')
            ->where('users.is_active', '=', 1)
            ->where('users.plan_status', '=', 3)
            ->whereNotNull('users.id_join_type')
            ->whereNull('tb_structure_b.id')
            ->orderBy('users.userid')
//            ->toSql();
            ->get();
    }

    public function getRequirePlacementOwn($user, $upgradeCount) {
        if (empty($user)) return null;

        $return = collect();

        for ($x=2; $x <= $upgradeCount; $x++) {
            ${'result'. $x} = User::where('users.id', '=', $user->id)
                ->leftJoin('tb_structure_b', 'tb_structure_b.userid', '=', DB::raw('CONCAT(users.userid, "-'. $x .'")'))
                ->selectRaw('users.id, CONCAT(users.userid, "-'. $x .'") AS userid, users.name, users.email, users.active_at, users.created_at')
                ->where('users.is_active', '=', 1)
                ->where('users.plan_status', '=', 3)
                ->whereNotNull('users.id_join_type')
                ->whereNull('tb_structure_b.id')
                ->get();
        }

        for ($x=2; $x <= $upgradeCount; $x++) {
            $return = $return->merge(${'result'. $x});
        }

        return $return;
    }

    public function isUserExist($userId) {
        if (empty($user)) return null;
        $data   = User::where('users.userid', '=', $userId)
            ->join('tb_structure_b', 'tb_structure_b.user_id', '=', 'users.id')
            ->selectRaw('users.id, users.userid, users.name, users.email, users.active_at, users.created_at')
            ->where('users.is_active', '=', 1)
            ->first();
        return !empty($data);
    }

    public function getListDirectSponsored($user) {
        if (empty($user)) return null;
        $data   = User::where('users.id_referal', '=', $user->id)
            ->leftJoin('tb_structure_b', 'tb_structure_b.user_id', '=', 'users.id')
            ->selectRaw('users.userid, users.name, 
                            (CASE WHEN tb_structure_b.id IS NULL THEN 0 ELSE 1 END) AS status,
                            tb_structure_b.kode, COALESCE(tb_structure_b.level, 0) AS level, users.id, users.is_active')
            ->where('users.is_active', '=', 1)
            ->get();
        return $data;
    }

    public function getCountLeft($kode, $level) {
        return empty($kode) ? 0 : $this->where('kode', 'LIKE', $kode . '-' . ($level + 1) . '.1%')->count('id');
    }

    public function getCountLeftByUserKode($UserKode) {
        $data = $this->where('userid', '=', $UserKode)->first();
        return empty($data) ? 0 : $this->getCountLeft($data->kode, $data->level);
    }

    public function getCountRight($kode, $level) {
        return empty($kode) ? 0 : $this->where('kode', 'LIKE', $kode . '-' . ($level + 1) . '.2%')->count('id');
    }

    public function getCountRightByUserKode($UserKode) {
        $data = $this->where('userid', '=', $UserKode)->first();
        return empty($data) ? 0 : $this->getCountRight($data->kode, $data->level);
    }

    public function summaryStructure($user) {
        function generateSqlLevel($fromLevel, $maxLevel = 10) {
            $sql = "";
            for ($i = 1; $i <= $maxLevel; $i++) {
                $level = $fromLevel + $i;
                $show_level = $i;
                if ($sql == '') {
                    $sql .= "SELECT " . $level . " AS level, " . $show_level . " AS show_level ";
                } else {
                    $sql .= " UNION ALL SELECT " . $level . " AS level, " . $show_level . " AS show_level ";
                }
            }
            return str_replace('  ', ' ', $sql);
        }
        $result = (object) array(
            'summary10Level'    => array(
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0,
                '7' => 0,
                '8' => 0,
                '9' => 0,
                '10' => 0
            ),
            'sponsored'     => (object) array('Activated' => 0, 'UnActivated' => 0),
            //'globalSummary' => (object) array('Yesterday' => 0, 'Today' => 0, 'ThisWeek' => 0, 'ThisMonth' => 0)
        );
        if (empty($user)) return $result;
        $mine   = $this->where('tb_structure_b.user_id', '=', $user->id)->first();
        if (empty($mine)) return $result;
        $PerLevel = $this->where('tb_structure_b.kode', 'LIKE', $mine->kode . '-%')
            ->join(DB::raw("(" . generateSqlLevel($mine->level, 10) . ") AS levelan"), 'levelan.level', '=', 'tb_structure_b.level')
            ->selectRaw("tb_structure_b.level, levelan.show_level, COUNT(tb_structure_b.id) AS jml_per_level")
            ->groupBy('tb_structure_b.level')
            ->groupBy('levelan.show_level')
            ->orderBy('levelan.show_level')
            ->get();
        if (!$PerLevel->isEmpty()) {
            foreach ($PerLevel as $row) {
                $result->summary10Level[$row->show_level] = $row->jml_per_level;
            }
        }
        $sponsored1 = User::where('users.id_referal', '=', $user->id)
            ->leftJoin('tb_structure_b', 'tb_structure_b.user_id', '=', 'users.id')
            ->where('users.is_active', '=', 1);
        $sponsored2 = clone $sponsored1;
        $result->sponsored->Activated       = $sponsored1->whereNotNull('tb_structure_b.id')->count('users.id');
        $result->sponsored->UnActivated     = $sponsored2->whereNull('tb_structure_b.id')->count('users.id');
        /*
        $result->globalSummary->Yesterday   = $this->where('tb_structure_b.kode', 'LIKE', $mine->kode . '-%')
                                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '=', DB::raw("DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 DAY), '%Y-%m-%d')"))
                                                ->count('tb_structure_b.id');
        $result->globalSummary->Today       = $this->where('tb_structure_b.kode', 'LIKE', $mine->kode . '-%')
                                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '=', DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
                                                ->count('tb_structure_b.id');
        $result->globalSummary->ThisWeek    = $this->where('tb_structure_b.kode', 'LIKE', $mine->kode . '-%')
                                                ->where("created_at", '>', DB::raw("DATE_SUB(NOW(), INTERVAL 1 WEEK)"))
                                                ->count('tb_structure_b.id');
        $result->globalSummary->ThisMonth   = $this->where('tb_structure_b.kode', 'LIKE', $mine->kode . '-%')
                                                ->where("created_at", '>', DB::raw("DATE_SUB(NOW(), INTERVAL 1 MONTH)"))
                                                ->count('tb_structure_b.id');
        */
        return $result;
    }

    private function addStructure($parentStructure, $kode, $upline, $user, $foot, $userid_x, &$newData) {
        $values = array(
            'kode'      => $kode,
            'user_id'   => $user->id,
            'userid'    => $userid_x,
            'upline_id' => $upline->id,
            'upline'    => $upline->userid,
            'posisi'    => AppTools::getPositionFromCodeFoot($kode, '.', '-'),
            'level'     => $parentStructure->level + 1,
            'foot'      => $foot
        );
        try {
            $newData = $this->create($values);
            return true;
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }

    private function getBonusSetting() {

        $clsSettingA  = new \App\Plan_a_setting;
        $settingA     = $clsSettingA->getSetting();

        $clsSettingB  = new \App\Plan_b_setting;
        $settingB     = $clsSettingB->getSetting();

        return (object) array(
            'clsSettingA'   => $clsSettingA,
            'settingA'      => $settingA,
            'clsSettingB'   => $clsSettingB,
            'settingB'      => $settingB
        );
    }

    //private function getPairQueryToday($parent, $level, $fromChildFoot) {
    private function getPairQuery($parent, $level, $fromChildFoot) {
        $kode = $parent->kode . '-' . ($parent->level + 1) . '.' . $fromChildFoot . '%';
        $fromLeft = ($fromChildFoot == 1);
        return $this->leftJoin('tb_bonus_pairing', function($join) use($parent, $fromLeft) {
            if ($fromLeft) {
                $join->on('tb_bonus_pairing.left_id', '=', 'tb_structure_b.id');
            } else {
                $join->on('tb_bonus_pairing.right_id', '=', 'tb_structure_b.id');
            }
            $join->on('tb_bonus_pairing.pair_level', '=', 'tb_structure_b.level');
            $join->on('tb_bonus_pairing.user_id', '=', DB::raw($parent->user_id));
        })
            ->selectRaw("tb_structure_b.*")
            ->whereRaw("tb_structure_b.kode LIKE '" . $kode . "'")
            //->whereRaw("tb_structure_b.level = " . $level)
            //->where(DB::raw("DATE_FORMAT(tb_structure_b.created_at, '%Y-%m-%d')"), '=', DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
            ->whereNull('tb_bonus_pairing.id');
    }

    private $rowsRanking;

    //private function getPairs($settings, $clsPairing, $kode, $level, &$needRankUp, $owner) {
    private function getPairs($settings, $clsPairing, $kode, $level, &$needRankUp) {
        function getUser($id) {
            return User::where('id', '=', $id)->first();
        }
        if (empty($this->rowsRanking)) {
            $this->rowsRanking = \App\UserType::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8])->orderBy('id')->get();
        }

        $parentCodes = AppTools::getAllParentCodeFromCode($kode, '.', '-');
        $result = [];
        $needRankUp = [];
        if (empty($parentCodes)) return $result;
        foreach ($parentCodes as $value) {
            $parent     = $this->where('kode', '=', $value->kode)->first();
            if (empty($parent)) continue;

            $parentUser = getUser($parent->user_id);
            if (empty($parentUser)) continue;

            //  rankup
            $parentKiri = $this->getCountLeft($parent->kode, $parent->level);
            $parentKanan = $this->getCountRight($parent->kode, $parent->level);

            //  $value->pair_foot artinya mencari pair dari arah mana 1 = kiri, 2 = kanan
            $isFromLeft = ($value->pair_foot == 2);

            if ($isFromLeft) {
                $parentKiri += 1;
            } else {
                $parentKanan += 1;
            }
            if ($parentUser->needUpgradeRanking($parentKiri, $parentKanan, $this->rowsRanking)) {
                $needRankUp[] = $parentUser;
            }
            //  end rankup

            //$query      = $this->getPairQueryToday($parent, $level, $value->pair_foot)->orderBy('tb_structure_b.kode')->first();
            /*$query      = $this->getPairQuery($parent, $level, $value->pair_foot)
                                ->orderBy('tb_structure_b.level')
                                ->orderBy('tb_structure_b.kode')
                                ->first();
            if (empty($query)) continue;
            */

            if ($isFromLeft) {
                if ($parentKanan < $parentKiri) continue;
            } else {
                if ($parentKiri < $parentKanan) continue;
            }

            $bonus      = $clsPairing->getBonus($parentUser, $settings);
            if ($bonus->get) {
                $result[] = (object) array(
                    'user'          => $parent,
                    'child_data'    => $parent,
                    'is_right'      => ($value->pair_foot == 2),
                    'pair_level'    => $level,
                    'bonusSplited'  => $bonus->bonusSplited
                );
            }
        }
        return $result;
    }

    public function placeMember($owner, $user, $parentCode, $foot, $userid_x) {
        if (empty($owner) || empty($user) || $parentCode == '' || !in_array($foot, [1, 2])) return false;
        //  check parentCode is in owner structure ?
        $stOwner  = $this->where('user_id', '=', $owner->id)->first();
        if (empty($stOwner)) return false;
        $parent = $this->where('kode', 'LIKE', $stOwner->kode . '%')->where('kode', '=', $parentCode)->first();
        if (empty($parent)) return false;
        $upline = User::where('id', '=', $parent->user_id)->first();
        if (empty($upline)) return false;

        $sponsor = ($owner->id == $user->id_referal_b) ? $owner : User::where('id', '=', $user->id_referal_b)->first();
        if (empty($sponsor)) return false;

        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        $level  = $parent->level + 1;
        $kode   = AppTools::getStructureCodeByFoot($parent->kode, $level, $foot, '.', '-');

        DB::beginTransaction();
        $newData = null;

        if ($this->addStructure($parent, $kode, $upline, $user, $foot, $userid_x, $newData)) {

            $clsBonus = new \App\Bonus_upgrade_b;
            if (!$clsBonus->createBonus($owner, $user, true, $userid_x)) {
                DB::rollback();
                return false;
            }
            DB::commit();
            return true;
        } else {
            DB::rollback();
            return false;
        }
    }

    public function isAllowPlacement()
    {
        $settings       = $this->getBonusSetting();
        $clsSetting     = $settings->clsSettingA;
        $setting        = $settings->settingA;
        $maxPlacement   = $clsSetting->maxPlacement($setting);
        if($maxPlacement<=0){
            return false;
        } else {
            $today = $this::whereRaw('DATE(created_at) = CURDATE()')->count();
            return ($today < $maxPlacement) ? true : false;
        }
    }
}
