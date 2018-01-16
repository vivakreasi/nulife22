<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

use Illuminate\Support\Facades\DB;

class Plan_c_bonus extends Model 
{

    /*  define tablename */
    protected $table = 'tb_plan_c_bonus';

    protected $fillable = array('board_c_id', 'plan_c_id', 'bonus_type', 'bonus_amount');

    private $bonus3 = 100000;
    private $bonusFly = 1500000;

    public function getBrokenWdBonusFly($user) {
        if (empty($user)) return null;
        return DB::table('tb_plan_c_bonus')
                    ->join('tb_plan_c', 'tb_plan_c.id', '=', 'tb_plan_c_bonus.plan_c_id')
                    ->leftJoin('tb_plan_c_wd', function($join) {
                        $join->on('tb_plan_c_wd.plan_c_id', '=', 'tb_plan_c_bonus.plan_c_id')
                            ->on('tb_plan_c_wd.bonus_c_id', '=', 'tb_plan_c_bonus.id');
                    })
                    ->selectRaw("tb_plan_c_bonus.*, tb_plan_c.user_id")
                    ->where('tb_plan_c_bonus.bonus_type', '=', 2)
                    ->where('tb_plan_c.user_id', '=', $user->id)
                    ->where('tb_plan_c_wd.id')
                    ->orderBy('tb_plan_c_bonus.id')
                    ->first();
    }

    /*  1st version
    public function createBonusC3($bonusUser, $board, &$result, $type = 1) {
        if (empty($bonusUser) || empty($board)) return false;
        $values = array('board_c_id'    => $board->id,
                        'plan_c_id'     => $board->plan_c_id,
                        'bonus_type'    => $type,
                        'bonus_amount'  => ($type == 2) ? $this->bonusFly : $this->bonus3);
        try {

            $result = $this->create($values);
            $this->sendSmsNotif($type,$bonusUser->no_handphone);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    private function sendSmsNotif($bonustype = 1, $no_tujuan)
    {
        if(env('APP_SMS', false)){
            $srv_username   = 'guspri';
            $srv_password   = 'gCrl47';
            $srv_apikey     = env('APP_SMS_KEY', '');

            $tglbonus       = date('d-m-Y H:i:s');

            if($bonustype==1){
                $bonus          = 100000;
                $message    = "Selamat, Anda mendapatkan bonus Plan-C sebesar Rp ". number_format($bonus,0,',','.') .",- (". $tglbonus ." || https://planc.nulife.co.id)";
            }else{
                $bonus          = 1500000;
                $message    = "Selamat, Anda mendapatkan bonus fly Plan-C sebesar Rp ". number_format($bonus,0,',','.') .", (". $tglbonus ." || https://planc.nulife.co.id)";
            }

            try{
                $http = new Client([
                    'timeout'           => 120,
                    'debug'             => false,
                ]);

                $url    = 'http://128.199.232.241/sms/smsreguler.php?username='. $srv_username."&password=".$srv_password."&key=".$srv_apikey."&number=".$no_tujuan."&message=".urlencode($message);

                $response = $http->request('GET', $url);

                if($response->getStatusCode() == '200') {
                    $result = true;
                } else {
                    $result = false;
                }
            } catch(\Exception $e) {
                return $e;
            }

            return $result;
        } else {
            return false;
        }
    }
    */

    public function createBonusFly($userPlanC, $bonusAmount, &$result) {
        if (empty($userPlanC) || $bonusAmount <= 0) return false;
        $values = array('board_c_id'    => 0,
                        'plan_c_id'     => $userPlanC->id,
                        'bonus_type'    => 2,
                        'bonus_amount'  => $bonusAmount);
        try {

            $result = $this->create($values);
            $this->sendSmsNotif($bonusAmount, $userPlanC->hp);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    private function sendSmsNotif($bonusAmount, $no_tujuan)
    {
        if (empty($no_tujuan)) return false;
        if(env('APP_SMS', false)){
            $srv_username   = env('APP_SMS_USERNAME', 'guspri');
            $srv_password   = env('APP_SMS_PASSWORD', 'gCrl47');
            $srv_apikey     = env('APP_SMS_KEY', '');
            $tglbonus       = date('d-m-Y H:i:s');

            $message    = "Selamat, Anda mendapatkan bonus fly Plan-C sebesar Rp ". number_format($bonusAmount,0,',','.') .",- (". $tglbonus ." || https://planc.nulife.co.id)";
            
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
}