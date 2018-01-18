<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\NulifeJuli2017;

class TransactionB extends Model 
{

    use NulifeJuli2017;

    /*  define tablename */
    protected $table = 'tb_transactionb';

    protected $fillable = array('transaction_code', 'transaction_type', 'from', 'to', 'total_price', 'unique_digit', 'status');

    private $startDigit = 1;
    private $endDigit = 999;

    private function isUnikDigitExist($digit) {
        $test = intval($digit);
        if ($test > $this->endDigit) return true;
        if ($test < $this->startDigit) return true;
        $check = $this->where('unique_digit', '=', $digit)
                    ->where('status', '=', 0)
                    ->whereRaw("(date_format(created_at, '%Y-%m-%d') = " . date('Y-m-d') . ")")
                    ->first();
        return !empty($check);
    }

    public function setUniqueDigit($unik) {
        $len = strlen(strval($this->endDigit));
        return str_pad($unik, $len, '0', STR_PAD_LEFT);
    }

    public function getUniqueDigit() {
        function getUnique() {
            return rand(1, 999);
        }
        $loop = 0;
        while ($this->isUnikDigitExist($unik = $this->setUniqueDigit(rand($this->startDigit, $this->endDigit)))) {
            $loop += 1;
            if ($loop >= 1000) {
                $unik = '000';
                break;
            }
        }
        return $unik;
    }

    public function getAllOrders($status = null, $user_id, $stockis = FALSE, $admin = FALSE) {
        $query = $this->selectRaw("
        			tb_transactionb.status, 
                    date_format(tb_transactionb.created_at, '%Y-%m-%d %H:%i') AS created_date,
                    tb_transactionb.transaction_code as code,
                    c.amount,
                    (IFNULL(CONVERT(SUBSTRING_INDEX(unique_digit,'-',-1),UNSIGNED INTEGER),0) + total_price) as total_price,
                    tb_transactionb.id,
                    tb_transactionb.from,
                    tb_transactionb.to,
                    transaction_type,
                    IF(`from` = 0,'Admin',a.userid) as from_name,
                    b.userid as to_name");
        $query->join('tb_transactionb_list as c', 'c.transaction_code', '=', 'tb_transactionb.transaction_code');
        $query->leftJoin('users as a', 'a.id', '=', 'tb_transactionb.from');
        $query->leftJoin('users as b', 'b.id', '=', 'tb_transactionb.to');
        $query->where('tb_transactionb.transaction_type', '<>', 4);   // auto generate from request to be stockist
        $query->where('tb_transactionb.created_at', '>=', $this->tglStart);  //  versi 4 juli 2017
        if ($admin){
            $query->where('tb_transactionb.from', 0);
        } 
        else{ 
            $query->where(function ($querys) use ($user_id) {
                $querys->where('tb_transactionb.from', $user_id)
                        ->orWhere('tb_transactionb.to', $user_id);
            });
        }
        if ($status == null) $status = 0;
        return $query->where('status', '=', intval($status))->get();
    }

    public function getReportPin(){
        return DB::table('users')
                    ->selectRaw('1 as no, users.userid, users.name, '
                            . 'sum(case when tb_pin_member.is_used = 0 then 1 else 0 end) as active_pin,'
                            . ' sum(case when tb_pin_member.is_used = 1 then 1 else 0 end) as used_pin,'
                            . 'tb.transfered_pin')
                    ->join('tb_pinb_member', 'users.id', '=', 'tb_pinb_member.user_id')
                    ->join('tb_transactionb', 'tb_transactionb.transaction_code', '=', 'tb_pinb_member.transaction_code')
                    ->leftJoin(DB::raw('(SELECT count(tb_transactionb.id) as transfered_pin, tb_transactionb.from '
                            . 'FROM tb_transactionb '
                            . 'WHERE tb_transactionb.transaction_type = 2 GROUP BY tb_transactionb.from) as tb'), 'tb.from', '=', 'users.id')
                    ->where('users.id_type', '<', 100)
                    ->where('users.is_active', '=', 1)
                    ->where('users.id', '>', 18)
                    ->where('tb_transactionb.created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->groupBy('users.id')
                    ->get();
    }
    
    public function getReportPinUsedActive($id){
        /*
        return DB::table('users')
                    ->selectRaw('1 as no, users.userid, users.name, '
                            . 'sum(case when tb_pin_member.is_used = 0 then 1 else 0 end) as active_pin,'
                            . ' sum(case when tb_pin_member.is_used = 1 then 1 else 0 end) as used_pin,'
                            . '(SELECT count(tb_transaction.id) FROM tb_transaction WHERE tb_transaction.from = users.id AND tb_transaction.transaction_type = 2) AS transfered_pin')
                    ->leftJoin('tb_pin_member', 'users.id', '=', 'tb_pin_member.user_id')
                    ->where('users.id_type', '<', 100)
                    ->where('users.is_active', '=', 1)
                    ->where('users.id', '>', 18)
                    ->where('users.id', '=', $id)
                    ->groupBy('users.id')
                    ->first();
        */

        $totalTransfered = DB::table("tb_transactionb")
                                ->join("tb_transactionb_list", "tb_transactionb_list.transaction_code", "=", "tb_transactionb.transaction_code")
                                ->where("tb_transactionb.created_at", ">=", $this->tglStart) //  versi 4 juli 2017
                                ->where("tb_transactionb.from", "=", $id)
                                ->where("tb_transactionb.transaction_type", "=", 2)
                                ->sum("tb_transactionb_list.amount");

        return DB::table('users')
                    ->selectRaw("1 as no, users.userid, users.name, 
                            sum(case when tb_pinb_member.is_used = 0 then 1 else 0 end) as active_pin,
                            sum(case when tb_pinb_member.is_used = 1 then 1 else 0 end) as used_pin, " . $totalTransfered . " AS transfered_pin")
                    ->join("tb_pinb_member", "users.id", "=", "tb_pinb_member.user_id")
                    ->join("tb_transactionb", "tb_transactionb.transaction_code", "=", "tb_pinb_member.transaction_code")
                    ->where("users.id_type", "<", 100)
                    ->where("users.is_active", "=", 1)
                    ->where("users.id", ">", 18)
                    ->where("users.id", "=", $id)
                    ->where("tb_transactionb.created_at", ">=", $this->tglStart) //  versi 4 juli 2017
                    ->groupBy("users.id")
                    ->first();
    }

    public function ref_to()
    {
         return $this->belongsTo('App\User', 'to');
    }

    public function ref_from()
    {
         return $this->belongsTo('App\User', 'from');
    }

    //  4 juli 2017
    public function createTransaction($trans_code, $type, $from, $to, $total_price, $unique_digit) {
        $dataTr = array(
            'transaction_code'  => $trans_code, 
            'transaction_type'  => $type, 
            'from'              => $from, 
            'to'                => $to, 
            'total_price'       => $total_price, 
            'unique_digit'      => $unique_digit, 
            'status'            => 0,
            'created_at'        => date('Y-m-d H:i:s')
        );

        try {
            $this->create($dataTr);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}