<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Bonus_sponsor;
use App\Bonus_pairing;
use App\Bonus_upgrade_b;

trait UserBonus
{
    //  edited at 4 juli 2017
    private $summaryBonus;
    public function getSummaryBonus() {
        if (!$this->id) return null;
        if (!empty($this->summaryBonus) && !$this->summaryBonus->isEmpty()) return $this->summaryBonus;

        $mulai  = $this->tglStart;

        $sumSponsor = \App\Bonus_sponsor::whereRaw("tb_bonus_sponsor.user_id = " . $this->id)
                            /*->join("users", "users.id", "=", "tb_bonus_sponsor.from_user_id")
                            ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                            ->join("tb_transaction", function($join) use ($mulai) {
                                $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                    ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                            })*/
                            ->selectRaw("DATE_FORMAT(tb_bonus_sponsor.created_at, '%Y-%m-%d') AS tanggal, 
                                tb_bonus_sponsor.bonus_amount AS bonus_sponsor, 
                                0 AS bonus_pairing, 
                                0 AS bonus_up_b, 
                                tb_bonus_sponsor.nucash_amount, 
                                tb_bonus_sponsor.nupoint_amount")
                            ->whereRaw("tb_bonus_sponsor.created_at >= '" . $mulai . "'") //
                            ->toSql();
        $sumPairing = \App\Bonus_pairing::whereRaw("tb_bonus_pairing.user_id = " . $this->id)
                            /*->join("users", function($join) {
                                $join->on("users.id", "=", 
                                    DB::raw("(CASE WHEN tb_bonus_pairing.left_user_id = 0 THEN tb_bonus_pairing.right_user_id ELSE tb_bonus_pairing.left_user_id END)"));
                            })
                            ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                            ->join("tb_transaction", function($join) use ($mulai) {
                                $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                    ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                            })*/
                            ->selectRaw("DATE_FORMAT(tb_bonus_pairing.created_at, '%Y-%m-%d') AS tanggal, 
                                0 AS bonus_sponsor, 
                                tb_bonus_pairing.bonus_amount AS bonus_pairing,
                                0 AS bonus_up_b, 
                                tb_bonus_pairing.nucash_amount, 
                                tb_bonus_pairing.nupoint_amount")
                            ->whereRaw("tb_bonus_pairing.created_at >= '" . $mulai . "'") //
                            ->toSql();
        $sumUpgradeB= \App\Bonus_upgrade_b::whereRaw("tb_bonus_upgrade_b.user_id = " . $this->id)
                            ->whereRaw("tb_bonus_upgrade_b.created_at >= '" . $mulai . "'")
                            ->selectRaw("DATE_FORMAT(tb_bonus_upgrade_b.created_at, '%Y-%m-%d') AS tanggal, 
                                0 AS bonus_sponsor, 
                                0 AS bonus_pairing, 
                                tb_bonus_upgrade_b.bonus_amount AS bonus_up_b, 
                                tb_bonus_upgrade_b.bonus_amount AS nucash_amount, 
                                0 AS nupoint_amount")
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
        $mulai  = $this->tglStart;
        $this->bonusSponsor = \App\Bonus_sponsor::where("tb_bonus_sponsor.user_id", "=", $this->id)
                        ->join(DB::raw("users AS from_user"), "from_user.id", "=", "tb_bonus_sponsor.from_user_id")
                        /*->join("tb_pin_member", "tb_pin_member.pin_code", "=", "from_user.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                        })*/
                        ->selectRaw("DATE_FORMAT(tb_bonus_sponsor.created_at, '%Y-%m-%d') AS tanggal, tb_bonus_sponsor.from_userid,
                            from_user.name, tb_bonus_sponsor.bonus_amount, tb_bonus_sponsor.nucash_amount, tb_bonus_sponsor.nupoint_amount, tb_bonus_sponsor.id")
                        ->where('tb_bonus_sponsor.created_at', '>=', $mulai) //
                        ->get();
        return $this->bonusSponsor;
    }

    private $bonusPairing;
    public function getBonusPairing() {
        if (!empty($this->bonusPairing) && !$this->bonusPairing->isEmpty()) return $this->bonusPairing;
        $mulai  = $this->tglStart;
        $this->bonusPairing = \App\Bonus_pairing::where("tb_bonus_pairing.user_id", "=", $this->id)
                        /*->join("users", function($join) {
                            $join->on("users.id", "=", 
                                DB::raw("(CASE WHEN tb_bonus_pairing.left_user_id = 0 THEN tb_bonus_pairing.right_user_id ELSE tb_bonus_pairing.left_user_id END)"));
                        })
                        ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                        })*/
                        ->selectRaw("DATE_FORMAT(tb_bonus_pairing.created_at, '%Y-%m-%d') AS tanggal, 
                            COUNT(tb_bonus_pairing.id) AS jml_pasangan,
                            SUM(tb_bonus_pairing.bonus_amount) AS bonus_amount, 
                            SUM(tb_bonus_pairing.nucash_amount) AS nucash_amount, 
                            SUM(tb_bonus_pairing.nupoint_amount) AS nupoint_amount")
                        ->where('tb_bonus_pairing.created_at', '>=', $mulai) //
                        ->groupBy('tanggal')
                        ->get();
        return $this->bonusPairing;
    }

    private $bonusUpgradeB;
    public function getBonusUpgradeB() {
        if (!empty($this->bonusUpgradeB) && !$this->bonusUpgradeB->isEmpty()) return $this->bonusUpgradeB;
        $this->bonusUpgradeB =  \App\Bonus_upgrade_b::where("tb_bonus_upgrade_b.user_id", "=", $this->id)
                        ->leftJoin(DB::raw('users AS from_user'), 'from_user.id', '=', 'tb_bonus_upgrade_b.from_user_id')
                        ->selectRaw("DATE_FORMAT(tb_bonus_upgrade_b.created_at, '%Y-%m-%d') AS tanggal, tb_bonus_upgrade_b.from_userid,
                            from_user.name, tb_bonus_upgrade_b.notes, tb_bonus_upgrade_b.bonus_amount, tb_bonus_upgrade_b.id")
                        ->where("tb_bonus_upgrade_b.created_at", ">=", $this->tglStart)
                        ->get();
        return $this->bonusUpgradeB;
    }

    public function getTotalBonus(&$sumData = null) {
        if (!$this->id) return 0;
        if ($sumData == null) $sumData = $this->getSummaryBonus();
        return $sumData->sum(function($data) {
            return $data->bonus_sponsor + $data->bonus_pairing + $data->bonus_up_b;
        });
    }

    public function getTotalNewCash(&$sumData = null) {
        if (!$this->id) return 0;
        if ($sumData == null) $sumData = $this->getSummaryBonus();
        return $sumData->sum('nucash_amount');
    }

    public function getTotalNewPoint(&$sumData = null) {
        if (!$this->id) return 0;
        if ($sumData == null) $sumData = $this->getSummaryBonus();
        return $sumData->sum('nupoint_amount');
    }

    //  previous bonus, nucash, nupoint. 4 juli 2017
    private $previousSummaryBonus;
    public function getPreviousSummaryBonus() {
        if (!$this->id) return null;
        if (!empty($this->previousBonusSponsor) && !$this->previousBonusSponsor->isEmpty()) return $this->previousBonusSponsor;

        $mulai  = $this->tglStart;

        $sumSponsor = \App\Bonus_sponsor::whereRaw("tb_bonus_sponsor.user_id = " . $this->id)
                            /*->join("users", "users.id", "=", "tb_bonus_sponsor.from_user_id")
                            ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                            ->join("tb_transaction", function($join) use ($mulai) {
                                $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                    ->on("tb_transaction.created_at", "<", DB::raw("'" . $mulai . "'"));
                            })*/
                            ->selectRaw("DATE_FORMAT(tb_bonus_sponsor.created_at, '%Y-%m-%d') AS tanggal, 
                                tb_bonus_sponsor.bonus_amount AS bonus_sponsor, 
                                0 AS bonus_pairing, 
                                0 AS bonus_up_b, 
                                tb_bonus_sponsor.nucash_amount, 
                                tb_bonus_sponsor.nupoint_amount")
                            ->whereRaw("(tb_bonus_sponsor.created_at < '" . $mulai . "')") //
                            ->toSql();
        $sumPairing = \App\Bonus_pairing::whereRaw("tb_bonus_pairing.user_id = " . $this->id)
                            /*->join("users", function($join) {
                                $join->on("users.id", "=", 
                                    DB::raw("(CASE WHEN tb_bonus_pairing.left_user_id = 0 THEN tb_bonus_pairing.right_user_id ELSE tb_bonus_pairing.left_user_id END)"));
                            })
                            ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                            ->join("tb_transaction", function($join) use ($mulai) {
                                $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                    ->on("tb_transaction.created_at", "<", DB::raw("'" . $mulai . "'"));
                            })*/
                            ->selectRaw("DATE_FORMAT(tb_bonus_pairing.created_at, '%Y-%m-%d') AS tanggal, 
                                0 AS bonus_sponsor, 
                                tb_bonus_pairing.bonus_amount AS bonus_pairing,
                                0 AS bonus_up_b, 
                                tb_bonus_pairing.nucash_amount, 
                                tb_bonus_pairing.nupoint_amount")
                            ->whereRaw("(tb_bonus_pairing.created_at < '" . $mulai . "')")  //
                            ->toSql();
        $sumUpgradeB= \App\Bonus_upgrade_b::whereRaw("tb_bonus_upgrade_b.user_id = " . $this->id)
                            ->whereRaw("tb_bonus_upgrade_b.created_at < '" . $mulai . "'")
                            ->selectRaw("DATE_FORMAT(tb_bonus_upgrade_b.created_at, '%Y-%m-%d') AS tanggal, 
                                0 AS bonus_sponsor, 
                                0 AS bonus_pairing, 
                                tb_bonus_upgrade_b.bonus_amount AS bonus_up_b, 
                                tb_bonus_upgrade_b.bonus_amount AS nucash_amount, 
                                0 AS nupoint_amount")
                            ->toSql();
        $this->previousSummaryBonus = DB::table(DB::raw("(" . $sumSponsor . " UNION ALL " . $sumPairing . " UNION ALL " . $sumUpgradeB . ") AS rekap"))
                    ->selectRaw("tanggal, SUM(bonus_sponsor) AS bonus_sponsor, 
                        SUM(bonus_pairing) AS bonus_pairing, SUM(bonus_up_b) AS bonus_up_b, 0 AS grand_total, 
                        SUM(nucash_amount) AS nucash_amount, SUM(nupoint_amount) AS nupoint_amount")
                    ->groupBy('tanggal')
                    ->get();
        return $this->previousSummaryBonus;
    }

    private $previousBonusSponsor;
    public function getPreviousBonusSponsor() {
        if (!empty($this->previousBonusSponsor) && !$this->previousBonusSponsor->isEmpty()) return $this->previousBonusSponsor;
        $mulai  = $this->tglStart;
        $this->previousBonusSponsor = \App\Bonus_sponsor::where("tb_bonus_sponsor.user_id", "=", $this->id)
                        ->join(DB::raw("users AS from_user"), "from_user.id", "=", "tb_bonus_sponsor.from_user_id")
                        /*->join("tb_pin_member", "tb_pin_member.pin_code", "=", "from_user.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", "<", DB::raw("'" . $mulai . "'"));
                        })*/
                        ->selectRaw("DATE_FORMAT(tb_bonus_sponsor.created_at, '%Y-%m-%d') AS tanggal, tb_bonus_sponsor.from_userid,
                            from_user.name, tb_bonus_sponsor.bonus_amount, tb_bonus_sponsor.nucash_amount, tb_bonus_sponsor.nupoint_amount, tb_bonus_sponsor.id")
                        ->whereRaw("(tb_bonus_sponsor.created_at < '" . $mulai . "')") //
                        ->get();
        return $this->previousBonusSponsor;
    }

    private $previousBonusPairing;
    public function getPreviousBonusPairing() {
        if (!empty($this->previousBonusPairing) && !$this->previousBonusPairing->isEmpty()) return $this->previousBonusPairing;
        $mulai  = $this->tglStart;
        $this->previousBonusPairing = \App\Bonus_pairing::where("tb_bonus_pairing.user_id", "=", $this->id)
                        ->join("users", function($join) {
                            $join->on("users.id", "=", 
                                DB::raw("(CASE WHEN tb_bonus_pairing.left_user_id = 0 THEN tb_bonus_pairing.right_user_id ELSE tb_bonus_pairing.left_user_id END)"));
                        })
                        /*->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", "<", DB::raw("'" . $mulai . "'"));
                        })*/
                        ->selectRaw("DATE_FORMAT(tb_bonus_pairing.created_at, '%Y-%m-%d') AS tanggal, 
                            COUNT(tb_bonus_pairing.id) AS jml_pasangan,
                            SUM(tb_bonus_pairing.bonus_amount) AS bonus_amount, 
                            SUM(tb_bonus_pairing.nucash_amount) AS nucash_amount, 
                            SUM(tb_bonus_pairing.nupoint_amount) AS nupoint_amount")
                        ->whereRaw("(tb_bonus_pairing.created_at < '" . $mulai . "')") //
                        ->groupBy('tanggal')
                        ->get();
        return $this->previousBonusPairing;
    }

    private $previousBonusUpgradeB;
    public function getPreviousBonusUpgradeB() {
        if (!empty($this->previousBonusUpgradeB) && !$this->previousBonusUpgradeB->isEmpty()) return $this->previousBonusUpgradeB;
        $this->previousBonusUpgradeB = \App\Bonus_upgrade_b::where("tb_bonus_upgrade_b.user_id", "=", $this->id)
                        ->leftJoin(DB::raw('users AS from_user'), 'from_user.id', '=', 'tb_bonus_upgrade_b.from_user_id')
                        ->selectRaw("DATE_FORMAT(tb_bonus_upgrade_b.created_at, '%Y-%m-%d') AS tanggal, tb_bonus_upgrade_b.from_userid,
                            from_user.name, tb_bonus_upgrade_b.bonus_amount, tb_bonus_upgrade_b.id")
                        ->where("tb_bonus_upgrade_b.created_at", "<", $this->tglStart)
                        ->get();
        return $this->previousBonusUpgradeB;
    }

    public function getPreviousTotalBonus(&$sumData = null) {
        if (!$this->id) return 0;
        if ($sumData == null) $sumData = $this->getPreviousSummaryBonus();
        return $sumData->sum(function($data) {
            return $data->bonus_sponsor + $data->bonus_pairing + $data->bonus_up_b;
        });
    }

    public function getPreviousTotalNewCash(&$sumData = null) {
        if (!$this->id) return 0;
        if ($sumData == null) $sumData = $this->getPreviousSummaryBonus();
        return $sumData->sum('nucash_amount');
    }

    public function getPreviousTotalNewPoint(&$sumData = null) {
        if (!$this->id) return 0;
        if ($sumData == null) $sumData = $this->getPreviousSummaryBonus();
        return $sumData->sum('nupoint_amount');
    }
}
