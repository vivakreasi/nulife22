<?php

namespace App;

use Illuminate\Support\Facades\DB;

use App\Bonus_sponsor;
use App\Bonus_pairing;
use App\Bonus_upgrade_b;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

trait NuCash {
    
    private $SummaryNuCash;
    public function getSummaryNuCash() {
        if (!$this->id) return null;
        if (!empty($this->SummaryNuCash)) return $this->SummaryNuCash;
        /*
        $lama       = DB::table('tb_bonus_summary_old')
                        ->whereRaw("tb_bonus_summary_old.user_id = " . $this->id)
                        ->whereRaw("tb_bonus_summary_old.total_bonus > 0")
                        ->selectRaw("'' AS tanggal, 'Summary From Old Data' AS jns_bonus, 
                            tb_bonus_summary_old.total_bonus AS bonus_amount, 
                            tb_bonus_summary_old.total_bonus AS nucash_amount, 
                            0 AS nupoint_amount, tb_bonus_summary_old.user_id, tb_bonus_summary_old.userid");
        */

        $mulai  = $this->tglStart;

        $sponsor    = Bonus_sponsor::whereRaw("tb_bonus_sponsor.user_id = " . $this->id)
                        //  versi 4 juli 2017
                        /*->join("users", "users.id", "=", "tb_bonus_sponsor.from_user_id")
                        ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                        })*/
                        //  end versi 4 juli 2017
                        ->selectRaw("DATE_FORMAT(tb_bonus_sponsor.created_at, '%Y-%m-%d %H:%i:%s') AS tanggal, 
                            'Sponsor Bonus' AS jns_bonus, 
                            tb_bonus_sponsor.bonus_amount, 
                            tb_bonus_sponsor.nucash_amount, 
                            tb_bonus_sponsor.nupoint_amount, 
                            tb_bonus_sponsor.user_id, 
                            tb_bonus_sponsor.userid")
                        ->whereRaw("tb_bonus_sponsor.created_at >= '" . $mulai . "'"); //;
                        //->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"));
        $pairing    = Bonus_pairing::whereRaw("tb_bonus_pairing.user_id = " . $this->id)
                        //  versi 4 juli 2017
                        /*->join("users", function($join) {
                            $join->on("users.id", "=", 
                                DB::raw("(CASE WHEN tb_bonus_pairing.left_user_id = 0 THEN tb_bonus_pairing.right_user_id ELSE tb_bonus_pairing.left_user_id END)"));
                        })
                        ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                        })*/
                        //  end versi 4 juli 2017
                        ->selectRaw("DATE_FORMAT(tb_bonus_pairing.created_at, '%Y-%m-%d %H:%i:%s') AS tanggal, 
                            'Pairing Bonus' AS jns_bonus, 
                            tb_bonus_pairing.bonus_amount, 
                            tb_bonus_pairing.nucash_amount, 
                            tb_bonus_pairing.nupoint_amount, 
                            tb_bonus_pairing.user_id, 
                            tb_bonus_pairing.userid")
                        ->whereRaw("tb_bonus_pairing.created_at >= '" . $mulai . "'"); //
                        //->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"));
        $upgradeB   = Bonus_upgrade_b::whereRaw("user_id = " . $this->id)
                        ->whereRaw("tb_bonus_upgrade_b.created_at >= '" . $mulai . "'") //  versi 4 juli 2017
                        ->selectRaw("DATE_FORMAT(tb_bonus_upgrade_b.created_at, '%Y-%m-%d %H:%i:%s') AS tanggal, 
                            'Upgrade Bonus' AS jns_bonus, 
                            tb_bonus_upgrade_b.bonus_amount, 
                            tb_bonus_upgrade_b.bonus_amount AS nucash_amount, 
                            0 AS nupoint_amount, 
                            tb_bonus_upgrade_b.user_id, 
                            tb_bonus_upgrade_b.userid");
                        //->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"));
        //$this->SummaryNuCash    = $lama->unionAll($sponsor)->unionAll($pairing)->unionAll($upgradeB)->get();
        $this->SummaryNuCash    = $sponsor->unionAll($pairing)->unionAll($upgradeB)->get();
        return $this->SummaryNuCash;
    }

    private $sumOldBonus = false;
    public function getTotalOldBonus() {
        return 0;
        /*
        if ($this->sumOldBonus !== false) return $this->sumOldBonus;
        $this->sumOldBonus = DB::table('tb_bonus_summary_old')
                        ->where("tb_bonus_summary_old.user_id", '=', $this->id)
                        ->sum("tb_bonus_summary_old.total_bonus");
        return $this->sumOldBonus;
        */
    }
    
    public function getTotalWDNucash(){
        $id = $this->id;
        $totalWdNucash = DB::table('tb_nucash_wd')
                            ->where('id_user', '=', $id)
                            ->where('tb_nucash_wd.is_versi_2', '=', 1)  //  versi 4 juli 2017
                            ->sum('jml_wd');
        return $totalWdNucash;
    }
    
    public function getAllWDNucash(){
        $id = $this->id;
        $sql = DB::table('tb_nucash_wd')
                        ->selectRaw('1 as no, tgl_wd, jml_wd, is_transfer, is_confirm, is_transfer as adm_transfer, id, adm_fee, total_wd')
                        ->where('id_user', '=', $id)
                        //->where('tb_nucash_wd.is_versi_2', '=', 1)  //  versi 4 juli 2017
                        ->get();
        return $sql;
    }
    
    public function getAlMemberlWDNucash(){
        $sql = DB::table('tb_nucash_wd')
                        ->join('users', 'users.id', '=', 'tb_nucash_wd.id_user')
                        ->join('tb_bank_member', 'tb_bank_member.id', '=', 'tb_nucash_wd.user_bank')
                        ->selectRaw('users.name, users.userid, 1 as structure,  tb_bank_member.bank_name, tb_bank_member.account_no, tb_nucash_wd.tgl_wd, tb_nucash_wd.jml_wd, '
                                . 'tb_nucash_wd.adm_fee, tb_nucash_wd.total_wd, tb_nucash_wd.is_transfer, tb_nucash_wd.is_confirm, tb_nucash_wd.is_transfer as transfer, '
                                . 'tb_nucash_wd.id, tb_nucash_wd.kd_wd, tb_nucash_wd.id_user')
                        //->where('tb_nucash_wd.is_confirm', '=', 0)
                        ->where('users.id', '>=', 18)
                        ->where('users.is_active', '=', 1)
                        ->where('users.id_type', '<', 100)
                        //->where('tb_nucash_wd.is_versi_2', '=', 1)  //  versi 4 juli 2017
                        ->orderBy('tb_nucash_wd.tgl_wd', 'DESC')
                        ->get();
        return $sql;
    }
    
    public function getAlMemberlWDNucashPayroll(){
        $sql = DB::table('tb_nucash_wd')
                        ->join('users', 'users.id', '=', 'tb_nucash_wd.id_user')
                        ->join('tb_bank_member', 'tb_bank_member.id', '=', 'tb_nucash_wd.user_bank')
                        ->selectRaw('users.name, users.userid, tb_bank_member.bank_name, tb_bank_member.account_no, tb_nucash_wd.tgl_wd, tb_nucash_wd.jml_wd, '
                                . 'tb_nucash_wd.adm_fee, tb_nucash_wd.total_wd, tb_nucash_wd.is_transfer, tb_nucash_wd.is_confirm, tb_nucash_wd.is_transfer as transfer, '
                                . 'tb_nucash_wd.id, tb_nucash_wd.kd_wd')
                        ->where('tb_nucash_wd.is_transfer', '=', 0)
                        ->where('users.id', '>=', 18)
                        ->where('users.is_active', '=', 1)
                        ->where('users.id_type', '<', 100)
                        //->where('tb_nucash_wd.is_versi_2', '=', 1)  //  versi 4 juli 2017
                        ->get();
        return $sql;
    }
    
    public function getNotTransferId($id) {
        return DB::table('tb_nucash_wd')->where('is_transfer', 0)
                    //->where('is_versi_2', '=', 1)   //  versi 4 juli 2017
                    ->where('id', '=', $id)->first();
    }
    
    public function getStatusTransferId($id) {
        return DB::table('tb_nucash_wd')->where('is_transfer', 1)
                    //->where('is_versi_2', '=', 1)   //  versi 4 juli 2017
                    ->where('id', '=', $id)->first();
    }

    public function setTransferSuccess($id) {
        $data = DB::table('tb_nucash_wd')
                    ->join('users', 'users.id', '=', 'tb_nucash_wd.id_user')
                    ->selectRaw("tb_nucash_wd.*, users.hp")
                    ->where('tb_nucash_wd.id', '=', $id)
                    //->where('tb_nucash_wd.is_versi_2', '=', 1)  //  versi 4 juli 2017
                    ->first();
        if (empty($data)) return false;
        $AmountTransfer = $data->total_wd;
        $no_hp = $data->hp;
        $values = array('is_transfer' => 1, 'transfer_at' => date('Y-m-d H:i:s'));
        try {
            DB::table('tb_nucash_wd')->where('id', '=', $id)->update($values);
            $this->sendSmsNotifTransfer($AmountTransfer, $no_hp);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function setConfirmSuccess($id) {
        $values = array('is_confirm' => 1, 'confirm_at' => date('Y-m-d H:i:s'));
        try {
            DB::table('tb_nucash_wd')->where('id', '=', $id)
                    //->where('is_versi_2', '=', 1)   //  versi 4 juli 2017
                    ->update($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    //  kirim sms ketika wd sudah ditransfer, supaya member segera approve
    private function sendSmsNotifTransfer($Amount, $no_tujuan)
    {
        if (empty($no_tujuan)) return false;
        if(env('APP_SMS', false)){
            $srv_username   = env('APP_SMS_USERNAME', 'guspri');
            $srv_password   = env('APP_SMS_PASSWORD', 'gCrl47');
            $srv_apikey     = env('APP_SMS_KEY', '');
            $tglbonus       = date('d-m-Y H:i:s');

            $message    = "Your Withdrawn Bonus has been transferred Rp ". number_format($Amount,0,',','.') .", please confirm it at your member area. Regards - Nulife";
            
            try{
                $http = new Client([
                    'timeout'           => 120,
                    'debug'             => false,
                ]);

                $url = env('APP_SMS_URL', 'http://128.199.232.241/sms/smsreguler.php');
                $url .= '?username='. $srv_username."&password=".$srv_password."&key=".$srv_apikey."&number=".$no_tujuan."&message=".urlencode($message);

                $response = $http->request('GET', $url);
                $result = ($response->getStatusCode() == '200');
            } catch(\Exception $e) {
                return $e;
            }

            return $result;
        } else {
            return true;
        }
    }

    private $previousNucash;
    public function getPreviousNucash() {
        if (!$this->id) return null;
        if (!empty($this->previousNucash)) return $this->previousNucash;
        
        $lama       = DB::table('tb_bonus_summary_old')
                        ->whereRaw("tb_bonus_summary_old.user_id = " . $this->id)
                        ->whereRaw("tb_bonus_summary_old.total_bonus > 0")
                        ->selectRaw("'' AS tanggal, 'Summary From Old Data' AS jns_bonus, 
                            tb_bonus_summary_old.total_bonus AS bonus_amount, 
                            tb_bonus_summary_old.total_bonus AS nucash_amount, 
                            0 AS nupoint_amount, tb_bonus_summary_old.user_id, tb_bonus_summary_old.userid");
        
        $mulai  = $this->tglStart;

        $sponsor    = Bonus_sponsor::whereRaw("tb_bonus_sponsor.user_id = " . $this->id)
                        //  versi 4 juli 2017
                        /*->join("users", "users.id", "=", "tb_bonus_sponsor.from_user_id")
                        ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                        })*/
                        //  end versi 4 juli 2017
                        ->selectRaw("DATE_FORMAT(tb_bonus_sponsor.created_at, '%Y-%m-%d %H:%i:%s') AS tanggal, 
                            'Sponsor Bonus' AS jns_bonus, 
                            tb_bonus_sponsor.bonus_amount, 
                            tb_bonus_sponsor.nucash_amount, 
                            tb_bonus_sponsor.nupoint_amount, 
                            tb_bonus_sponsor.user_id, 
                            tb_bonus_sponsor.userid")
                        ->whereRaw("tb_bonus_sponsor.created_at < '" . $mulai . "'"); //;
                        //->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"));
        $pairing    = Bonus_pairing::whereRaw("tb_bonus_pairing.user_id = " . $this->id)
                        //  versi 4 juli 2017
                        /*->join("users", function($join) {
                            $join->on("users.id", "=", 
                                DB::raw("(CASE WHEN tb_bonus_pairing.left_user_id = 0 THEN tb_bonus_pairing.right_user_id ELSE tb_bonus_pairing.left_user_id END)"));
                        })
                        ->join("tb_pin_member", "tb_pin_member.pin_code", "=", "users.pin_code")
                        ->join("tb_transaction", function($join) use ($mulai) {
                            $join->on("tb_transaction.transaction_code", "=", "tb_pin_member.transaction_code")
                                ->on("tb_transaction.created_at", ">=", DB::raw("'" . $mulai . "'"));
                        })*/
                        //  end versi 4 juli 2017
                        ->selectRaw("DATE_FORMAT(tb_bonus_pairing.created_at, '%Y-%m-%d %H:%i:%s') AS tanggal, 
                            'Pairing Bonus' AS jns_bonus, 
                            tb_bonus_pairing.bonus_amount, 
                            tb_bonus_pairing.nucash_amount, 
                            tb_bonus_pairing.nupoint_amount, 
                            tb_bonus_pairing.user_id, 
                            tb_bonus_pairing.userid")
                        ->whereRaw("tb_bonus_pairing.created_at < '" . $mulai . "'"); //
                        //->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"));
        $upgradeB   = Bonus_upgrade_b::whereRaw("user_id = " . $this->id)
                        ->whereRaw("tb_bonus_upgrade_b.created_at < '" . $mulai . "'") //  versi 4 juli 2017
                        ->selectRaw("DATE_FORMAT(tb_bonus_upgrade_b.created_at, '%Y-%m-%d %H:%i:%s') AS tanggal, 
                            'Upgrade Bonus' AS jns_bonus, 
                            tb_bonus_upgrade_b.bonus_amount, 
                            tb_bonus_upgrade_b.bonus_amount AS nucash_amount, 
                            0 AS nupoint_amount, 
                            tb_bonus_upgrade_b.user_id, 
                            tb_bonus_upgrade_b.userid");
                        //->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"));
        $this->previousNucash    = $lama->unionAll($sponsor)->unionAll($pairing)->unionAll($upgradeB)->get();
        //$this->listPrevious    = $sponsor->unionAll($pairing)->unionAll($upgradeB)->get();
        return $this->previousNucash;
    }
    
}
