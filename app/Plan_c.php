<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Plan_c_board;
use App\User;

class Plan_c extends Model 
{

    /*  define tablename */
    protected $table = 'tb_plan_c';

    protected $fillable = array('user_id', 'pin_id', 'plan_c_code', 'fly_at');

    private $maxActive = 13;

    public function getDailyPlanC($days)
    {
        $order              = 'ASC';
        $endDate            = Carbon::today();
        $startDate          = Carbon::today()->subDays($days-1);

        $dateInc            = ($order == 'DESC') ? -1 : 1;
        $dateCycleHolder    = clone ($dateInc > 0 ? $startDate : $endDate);
        $dateCycleEnd       = clone ($dateInc > 0 ? $endDate : $startDate);

        $joins = $this->select(array(
            DB::raw('DATE(`created_at`) as `date`'),
            DB::raw('COUNT(id) as `count`')
        ))
            ->where('created_at', '>', $startDate)
            ->groupBy('date')
            ->orderBy('date', $order)
            ->pluck('count', 'date');

        $flys = $this->select(array(
            DB::raw('DATE(`fly_at`) as `flydate`'),
            DB::raw('COUNT(id) as `flycount`')
        ))
            ->where('fly_at', '>', $startDate)
            ->groupBy('flydate')
            ->orderBy('flydate', $order)
            ->pluck('flycount', 'flydate');

        $pins = DB::table('tb_order_plan_c')->select(array(
            DB::raw('DATE(`tgl_approve`) as `pindate`'),
            DB::raw('SUM(x_jmlpin) as `pincount`')
        ))
            ->where('tgl_approve', '>', $startDate)
            ->where('status', '=', 3)
            ->groupBy('pindate')
            ->orderBy('pindate', $order)
            ->pluck('pincount', 'pindate');

        $dataChart = array();
        while ($dateCycleHolder->ne($dateCycleEnd)) {
            $dateCurr = $dateCycleHolder->format('Y-m-d');
            array_push(
                $dataChart,
                array(
                    'x'     => $dateCurr,
                    'join'  => $joins->get($dateCurr, 0),
                    'fly'   => $flys->get($dateCurr, 0),
                    'pin'   => $pins->get($dateCurr, 0)
                )
            );
            $dateCycleHolder->addDay($dateInc);
        }
        $dateCurr = $dateCycleHolder->format('Y-m-d');
        array_push(
            $dataChart,
            array(
                'x'     => $dateCurr,
                'join'  => $joins->get($dateCurr, 0),
                'fly'   => $flys->get($dateCurr, 0),
                'pin'   => $pins->get($dateCurr, 0)
            )
        );

        return json_encode($dataChart);
    }

    /*
    **  getPlanC => info user di plan C
    **  @user = hasil query dari user, eg: Auth::user()
    **  return object row or null
    */
    public function getPlanC($user) {
        if (empty($user)) return null;
        return $this->where('user_id', '=', $user->id)->orderBy('id')->get();
    }

    public function getAvailableClaim($user) {
        if (empty($user)) return null;
        return $this
            ->selectRaw('tb_plan_c.*, tb_product_claims.id AS claim_id, tb_product_claims.inv_trans_id, tb_product_claims.type, 
                tb_product_claims.status AS claim_status, tb_product_claims.delivery_address, tb_product_claims.delivery_city, 
                tb_product_claims.delivery_province, tb_product_claims.delivery_zip_code, tb_product_claims.delivery_phone,
	            tb_product_claims.created_at AS claim_created_at, tb_product_claims.updated_at AS claim_updated_at')
            ->leftjoin('tb_product_claims', function ($join) {
                $join->on('tb_plan_c.user_id', '=', 'tb_product_claims.user_id')
                    ->on('tb_product_claims.code', '=', 'tb_plan_c.plan_c_code')
                    ->where('tb_product_claims.type', '=', 'C');
            })
            ->where('tb_plan_c.user_id', '=', $user->id)->orderBy('tb_plan_c.id')->get();
    }

    public function getInfoUserPlanC($planC) {
        if (empty($planC)) return null;
        return User::where('id', '=', $planC->user_id)->first();
    }

    public function getInfoUserFromBoard($boardC) {
        if (empty($boardC)) return null;
        return DB::table('tb_plan_c')
                    ->join('users', 'users.id', '=', 'tb_plan_c.user_id')
                    ->selectRaw('users.*')
                    ->where('tb_plan_c.id', '=', $boardC->plan_c_id)
                    ->lockForUpdate()
                    ->first();
    }

    public function getCountRunningPlanC($user) {
        if (empty($user)) return 0;
        return $this->where('user_id', '=', $user->id)
                    ->whereNull('fly_at')
                    ->count('id');
    }

    public function getCountFlyNoWD($user) {
        if (empty($user)) return 0;
        return DB::table('tb_plan_c')
            ->leftJoin('tb_plan_c_bonus', 'tb_plan_c.id', '=', 'tb_plan_c_bonus.plan_c_id')
            ->leftJoin('tb_plan_c_wd', 'tb_plan_c_bonus.id', '=', 'tb_plan_c_wd.bonus_c_id')
            ->whereNotNull('tb_plan_c.fly_at')
            ->where('tb_plan_c.user_id', '=', $user->id)
            ->whereNull('tb_plan_c_wd.id')
            ->count();
    }

    /*  
    **  getHistory => history plan C user
    **  @user = hasil query dari user, eg: Auth::user()
    **  return array object of rows (plan C) or array empty
    */
    public function getHistory($user) {
        if (empty($user)) return [];
        return $this->where('user_id', '=', $user->id)->orderBy('id')->get();
    }

    /*
    **  isFlayed => status flay (true / false)
    **  @rowPlanC = row hasil query plan C
    **  return boolean
    */
    public function isFlayed($rowPlanC) {
        if (empty($rowPlanC)) return true;
        return !empty($rowPlanC->fly_at);
    }

    /*
    **  getHistoryBonus => history bonus yg didapat oleh user dari plan C
    **  @user = hasil query dari user, eg: Auth::user()
    **  return array object of rows (bonus) or array empty
    */
    public function getHistoryBonus($user) {
        if (empty($user)) return [];
        return DB::table('tb_plan_c')
                    ->join('tb_plan_c_bonus', 'tb_plan_c_bonus.plan_c_id', '=', 'tb_plan_c.id')
                    ->leftJoin('tb_plan_c_wd', function($join) {
                        $join->on('tb_plan_c_wd.bonus_c_id', '=', 'tb_plan_c_bonus.id')
                            ->on('tb_plan_c_wd.plan_c_id', '=', 'tb_plan_c_bonus.plan_c_id');
                    })
                    ->selectRaw("tb_plan_c_bonus.id, tb_plan_c_bonus.created_at, tb_plan_c_bonus.bonus_type, tb_plan_c_bonus.bonus_amount, tb_plan_c.plan_c_code, 
                        coalesce(tb_plan_c_wd.jml_pot_admin, 0) as jml_pot_admin, 
                        coalesce(tb_plan_c_wd.jml_wd) as jml_wd,
                        (case when tb_plan_c_wd.status is null then '' 
                        when tb_plan_c_wd.status = 0 then 'On Proccess' 
                        when tb_plan_c_wd.status = 1 then 'OK' 
                        when tb_plan_c_wd.status = 2 then 
                            (CASE WHEN tb_plan_c_wd.reject_note IS NOT NULL THEN
                                CONCAT('Reject<br/>(', CONCAT(tb_plan_c_wd.reject_note, ')'))
                            ELSE 'Reject'
                            END)
                        else '' 
                        end) as status_wd")
                    ->where('tb_plan_c.user_id', '=', $user->id)
                    ->orderBy('tb_plan_c_bonus.created_at', 'desc')
                    ->get();
    }

    public function getSummaryBonusFromList($bonusList) {
        if ($bonusList->isEmpty()) return 0;
        $result = 0;
        foreach ($bonusList as $row) {
            if ($row->status_wd !='OK') $result += $row->bonus_amount;
        }
        return $result;
    }

    public function getBonusSuccessWD($user) {
        if (empty($user)) return [];
        return DB::table('tb_plan_c')
                    ->join('tb_plan_c_bonus', 'tb_plan_c_bonus.plan_c_id', '=', 'tb_plan_c.id')
                    ->join('tb_plan_c_wd', function($join) {
                        $join->on('tb_plan_c_wd.bonus_c_id', '=', 'tb_plan_c_bonus.id')
                            ->on('tb_plan_c_wd.plan_c_id', '=', 'tb_plan_c_bonus.plan_c_id');
                    })
                    ->selectRaw("tb_plan_c_bonus.id, tb_plan_c_bonus.created_at, tb_plan_c_bonus.bonus_type, tb_plan_c_bonus.bonus_amount, tb_plan_c.plan_c_code, 
                        coalesce(tb_plan_c_wd.jml_pot_admin, 0) as jml_pot_admin, 
                        coalesce(tb_plan_c_wd.jml_wd) as jml_wd,
                        'OK' as status_wd")
                    ->where('tb_plan_c.user_id', '=', $user->id)
                    ->where('tb_plan_c_wd.status', '=', 1)
                    ->orderBy('tb_plan_c_bonus.created_at', 'desc')
                    ->get();
    }

    /*
    **  createPlanC => create / register plan C
    **  @values = array(column => value)
    **  return boolean
    */
    private function createPlanC($values, &$result) {
        if (empty($values)) return false;
        try {
            $result = $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateFly($planBoardC) {
        $value['fly_at'] = date('Y-m-d H:i:s');
        try {
            $this->where('id', '=', $planBoardC->plan_c_id)->update($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateFly2(&$planC) {
        $value['fly_at'] = date('Y-m-d H:i:s');
        try {
            $planC->update($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function isCodeExist($kode) {
        $check = $this->where('plan_c_code', '=', $kode)->first();
        return !empty($check);
    }

    /*
    **  getNewPlanCCode => mendapatkan kode plan-C yg baru
    **  return string code plan-C
    */
    private function getNewPlanCCode() {
        function getCode() {
            $rnd = rand(1, 9999999999);
            return 'NUC' . str_pad($rnd, 10, '0', STR_PAD_LEFT);
        }
        $loop = 0;
        while ($this->isCodeExist($code = getCode())) {
            $loop += 1;
            if ($loop >= 1000) {
                $code = '';
                break;
            }
        }
        return $code;
    }

    /*
    public function registerPlanC($user, $pinId, &$planC) {
        if (empty($user)) return false;
        $planCode = $this->getNewPlanCCode();
        if ($planCode == '') return false;
        $clsBoardC  = new Plan_c_board;
        $planCValue = ['user_id'        => $user->id,
                        'pin_id'        => $pinId,
                        'plan_c_code'   => $planCode];
        $planC = null;
        $newBoardC = null;

        $proses = new \App\Plan_c_process;
        $limitLoop = 0;
        while ($ada = $proses->processExist()) {
            if ($limitLoop >= 100000) {
                break;
            }
            $limitLoop += 1;
        }
        if ($ada) return false;
        if(!$proses->createProcess()) return false;

        $clsBonus = new \App\Plan_c_bonus;
        $brokenBonusFly = $clsBonus->getBrokenWdBonusFly($user);

        DB::beginTransaction();
        $proses->lockProcess();
        $sukses = false;
        $paramBoardC = $clsBoardC->getNewBoardC($this);
        try {
            if ($this->createPlanC($planCValue, $planC)) {
                $paramBoardC->plan_c_id = $planC->id;
                if ($clsBoardC->registerBoardC($this, $paramBoardC, $newBoardC)) {
                    $sukses = true;
                    if (!empty($brokenBonusFly)) {
                        $clsWd = new \App\Plan_c_wd;
                        $sukses = $clsWd->createWD($brokenBonusFly->user_id, $brokenBonusFly->plan_c_id, $brokenBonusFly->id, $brokenBonusFly->bonus_amount, 2, $planC->id);
                    }
                }
            }
        } catch (\Exception $e) {
        }
        if ($sukses) {
            DB::commit();
        } else {
            DB::rollback();
        }
        $proses->processDone();

        return $sukses;
    }
    */

    public function canRegisterByCount($user) {
        $jml = $this->getCountRunningPlanC($user);
        $clsSetting     = new \App\Plan_c_setting;
        $setting    = $clsSetting->getSetting();
        $max    = $clsSetting->maxAccount($setting);
        if($jml>=$max){
            $nyangkut = $this->getCountFlyNoWD($user);
            if($nyangkut>0) return true;
        }
        return ($max == 0 || $jml < $max);
    }

    private function getAvailablePlanQuery() {
        return $this->whereNull('tb_plan_c.fly_at');
    }

    private function getFirstActivePlan() {
        return $this->getAvailablePlanQuery()->join('users', 'users.id', 'tb_plan_c.user_id')
                    ->selectRaw("tb_plan_c.*, users.userid, users.name, users.email, users.hp")
                    ->orderBy('tb_plan_c.id')
                    ->first();
    }

    public function getActivePlan() {
        return $this->getAvailablePlanQuery()->join('users', 'users.id', 'tb_plan_c.user_id')
                    ->selectRaw("tb_plan_c.*, users.userid, users.name")
                    ->orderBy('tb_plan_c.id')
                    ->take($this->maxActive)
                    ->get();
    }

    private function getCountActivePlan() {
        $count =  $this->getAvailablePlanQuery()->count('tb_plan_c.id');
        return ($count > $this->maxActive) ? $this->maxActive : $count;
    }

    public function getCountQueuePlan() {
        $count = $this->getAvailablePlanQuery()->count('tb_plan_c.id');
        return ($count >= $this->maxActive) ? $count - $this->maxActive : $count;
    }

    //public function getQueuePlan($get = true, $asListCode = false) {
        /*$countActive    = $this->getCountActivePlan();
        $countQueue     = $this->getCountQueuePlan();
        $query          = $this->getAvailablePlanQuery()->orderBy('tb_plan_c.id')->take($countQueue)->offset($countActive);
        if ($get) {
            $query = $query->get();
            if ($asListCode) {
                $result = [];
                if (!$query->isEmpty()) {
                    foreach ($query as $row) {
                        $result[] = $row->plan_c_code;
                    }
                }
                return $result;
            }
            return $query;
        }
        return $query;
    }*/

    public function getQueuePlan() {
        $sql = "SELECT 
                    kol1.plan_c_code AS kode1,
                    kol2.plan_c_code AS kode2,
                    kol3.plan_c_code AS kode3,
                    kol4.plan_c_code AS kode4,
                    kol5.plan_c_code AS kode5,
                    page_number.nomor,
                    kol1.nomor AS nomor1,
                    kol2.nomor AS nomor2,
                    kol3.nomor AS nomor3,
                    kol4.nomor AS nomor4,
                    kol5.nomor AS nomor5
                FROM
                    (SELECT d.nomor, 
                        ((5 * (d.nomor - 1)) + 1) AS nomor_kol1,
                        ((5 * (d.nomor - 1)) + 2) AS nomor_kol2,
                        ((5 * (d.nomor - 1)) + 3) AS nomor_kol3,
                        ((5 * (d.nomor - 1)) + 4) AS nomor_kol4,
                        ((5 * (d.nomor - 1)) + 5) AS nomor_kol5
                    FROM
                        (SELECT CAST(CEILING(COALESCE((SELECT COUNT(id) FROM tb_plan_c WHERE fly_at IS NULL), 1) / 5) AS SIGNED INTEGER) AS jml_page ) AS tmp
                        JOIN 
                        (SELECT @rownum := @rownum + 1 AS nomor
                         FROM tb_plan_c, (SELECT @rownum := 0) AS n) AS d ON d.nomor <= tmp.jml_page) AS page_number
                    LEFT JOIN
                    (SELECT @nom1 := @nom1 + 1 AS nomor, tb_plan_c.plan_c_code
                     FROM tb_plan_c, (SELECT @nom1 := 0) AS urut WHERE (tb_plan_c.fly_at IS NULL) ORDER BY tb_plan_c.id) AS kol1
                    ON kol1.nomor = page_number.nomor_kol1
                    LEFT JOIN
                    (SELECT @nom2 := @nom2 + 1 AS nomor, tb_plan_c.plan_c_code
                     FROM tb_plan_c, (SELECT @nom2 := 0) AS urut WHERE (tb_plan_c.fly_at IS NULL) ORDER BY tb_plan_c.id) AS kol2
                    ON kol2.nomor = page_number.nomor_kol2
                    LEFT JOIN
                    (SELECT @nom3 := @nom3 + 1 AS nomor, tb_plan_c.plan_c_code
                     FROM tb_plan_c, (SELECT @nom3 := 0) AS urut WHERE (tb_plan_c.fly_at IS NULL) ORDER BY tb_plan_c.id) AS kol3
                    ON kol3.nomor = page_number.nomor_kol3
                    LEFT JOIN
                    (SELECT @nom4 := @nom4 + 1 AS nomor, tb_plan_c.plan_c_code
                     FROM tb_plan_c, (SELECT @nom4 := 0) AS urut WHERE (tb_plan_c.fly_at IS NULL) ORDER BY tb_plan_c.id) AS kol4
                    ON kol4.nomor = page_number.nomor_kol4
                    LEFT JOIN
                    (SELECT @nom5 := @nom5 + 1 AS nomor, tb_plan_c.plan_c_code
                     FROM tb_plan_c, (SELECT @nom5 := 0) AS urut WHERE (tb_plan_c.fly_at IS NULL) ORDER BY tb_plan_c.id) AS kol5
                    ON kol5.nomor = page_number.nomor_kol5
                ORDER BY page_number.nomor";
        return DB::select($sql);
    }

    public function getUserQueuePlan($user) {
        if (empty($user)) return null;
        return $this->getQueuePlan(false, false)->where('tb_plan_c.user_id', '=', $user->id)->get();
    }

    public function getUserActivePlan($user, $isAll = false) {
        if (empty($user)) return null;
        $query = $this->getAvailablePlanQuery()
                    ->where('tb_plan_c.user_id', '=', $user->id)
                    ->orderBy('tb_plan_c.id');
        if (!$isAll) $query = $query->take($this->maxActive);
        return $query->get();
    }

    public function getUserRunningPlan($user) {
        if (empty($user)) return null;
        return $this->getAvailablePlanQuery()
                    ->where('tb_plan_c.user_id', '=', $user->id)
                    ->orderBy('tb_plan_c.id')
                    ->get();
    }

    public function registerPlanC($user, $pinId, &$planC) {
        if (empty($user) || empty($userStructure = $user->getUserStructure()) ) return false;
        $planCode = $this->getNewPlanCCode();
        if ($planCode == '') return false;
        //$clsBoardC  = new Plan_c_board;
        $planCValue = ['user_id'        => $user->id,
            'pin_id'        => $pinId,
            'plan_c_code'   => $planCode];
        $planC = null;

        /*$proses = new \App\Plan_c_process;
        $limitLoop = 0;
        while ($ada = $proses->processExist()) {
            if ($limitLoop >= 100000) {
                break;
            }
            $limitLoop += 1;
        }
        if ($ada) return false;
        if(!$proses->createProcess()) return false;*/

        //  define class
        $clsBonus       = new \App\Plan_c_bonus;
        $clsLeaderShip  = new \App\Plan_c_bonus_leadership;
        $clsSetting     = new \App\Plan_c_setting;
        $clsWd          = new \App\Plan_c_wd;
        //  define yg dutuhkan
        $setting        = $clsSetting->getSetting();
        $countActive    = $this->getCountActivePlan();
        $countQueue     = $this->getCountQueuePlan() + 1;
        $listStructure      = \App\AppTools::getAllParentCodeFromCode($userStructure->kode, '.', '-', false);
        $listStructureLDS   = array_column($listStructure, 'kode');
        array_unshift($listStructureLDS, $userStructure->kode);
        $rowsLDS        = $user->getLeaderShip($listStructureLDS);
        //  prepare jika ada fly
        $userFly = null;
        if ($mustFly = $clsSetting->needFly($setting)) $userFly = $this->getFirstActivePlan();
        //  prepare jika ada bonus yg belum diWD
        $brokenBonusFly = $clsBonus->getBrokenWdBonusFly($user);
        $bonusan = null;

        DB::beginTransaction();
        //$proses->lockProcess();
        $sukses = false;
        if ($this->createPlanC($planCValue, $planC)) {
            $sukses = true;
            //  TODO: bonus leadership, harus fly atau tidak
            //  jika fly hitung bonus fly -> wd
            //  bonus fly
            if ($mustFly && !empty($userFly)) {
                if ($this->updateFly2($userFly)) {
                    $sukses = $clsBonus->createBonusFly($userFly, $clsSetting->bonusFly($setting), $bonusan);
                } else {
                    $sukses = false;
                }
            }
            //  bonus leadership
            $autoWdListLD = [];
            if ($sukses && !empty($listStructureLDS) && !empty($rowsLDS)) {
                $sukses = $clsLeaderShip->processBonus($user, $planC, $userStructure, $rowsLDS, $autoWdListLD, 10000);
            }
            //  auto wd bonus leadership
            if ($sukses && !empty($autoWdListLD)) {
                $sukses = $clsWd->createMultiWdBonusLD($autoWdListLD);
            }
            //  create wd untuk reentry plan-c
            if ($sukses && !empty($brokenBonusFly)) {
                $sukses = $clsWd->createWD($brokenBonusFly->user_id, $brokenBonusFly->plan_c_id, $brokenBonusFly->id, $brokenBonusFly->bonus_amount, 2, $planC->id);
            }
            if ($sukses) {
                $sukses = $clsSetting->updateQueue($setting, $mustFly);
            }
        }
        if ($sukses) {
            DB::commit();
        } else {
            DB::rollback();
        }
        //$proses->processDone();

        return $sukses;
    }

    /*
    **  getProgress => mendapatkan progress plan-C
    **  @user => object row, data user yg login
    **  @global => boolean, true => progres gloabl plan-C, false => progres user plan-C
    */
    //public function getProgress($user, $global = false)
    public function getProgress($user)
    {
        $clsBoardC  = new Plan_c_board;
        //return ($global === true) ? $clsBoardC->getGlobalProgress() : $clsBoardC->getMemberProgress($user);
        return $clsBoardC->getMemberProgress($user);
    }

    public function getStatisticC()
    {
        $totalBoard = $this->distinct('id')->count('id');
        return (object) array(
            //'totalfly'  => $this->whereRaw('DATE(fly_at) IS NOT NULL')->count('id'),
            'totalfly'  => $this->whereNotNull('fly_at')->count('id'),
            'today'     => $this->whereRaw('DATE(created_at) = CURDATE()')->count('id'),
            'yesterday' => $this
                ->whereRaw('DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)')
                ->count('id'),
            'total'     => $totalBoard
        );

    }

    public function isUpgradeMine($code, $user)
    {
        $planc = $this
            ->where('plan_c_code','=',$code)
            ->where('user_id','=',$user->id)
            ->first();
        return (is_null($planc)) ? false : true;
    }

}
