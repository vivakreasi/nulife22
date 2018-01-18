<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\NulifeJuli2017;

class PinMemberB extends Model 
{

    use NulifeJuli2017;

    /*  define tablename */
    protected $table = 'tb_pinb_member';

    protected $fillable = array('id', 'pin_code', 'pin_type_id', 'user_id', 'transaction_code', 'is_used');
    
    //  untuk versi 4 juli 2017 :
    //  menggunakan cara trace transaksi pin
    public function baseUserPinQuery($user_id = 0) {
        //  versi 4 juli 2017
        $query  = DB::table('tb_transaction')
                    ->join('tb_transaction_list', 'tb_transaction_list.transaction_code', '=', 'tb_transaction.transaction_code')
                    ->join('tb_transaction_detail', 'tb_transaction_detail.transaction_list_id', '=', 'tb_transaction_list.id')
                    ->join('tb_pinb_member', function($join) use($user_id) {
                        if (intval($user_id) > 0) {
                            $join->on('tb_pinb_member.pin_code', '=', 'tb_transaction_detail.pin_code')
                                ->on('tb_pinb_member.user_id', '=', DB::raw($user_id));
                        } else {
                            $join->on('tb_pinb_member.pin_code', '=', 'tb_transaction_detail.pin_code');
                        }
                    });
        if (intval($user_id) > 0) $query->where('tb_transaction.to', '=', $user_id);
        return $query;
    }

    //  mendapatkan data pin dari mana saja asalnya
    public function getAllTransByPin($pinCode) {
        return DB::table('tb_transaction')
                    ->join('tb_transaction_list', 'tb_transaction_list.transaction_code', '=', 'tb_transaction.transaction_code')
                    ->join('tb_transaction_detail', 'tb_transaction_detail.transaction_list_id', '=', 'tb_transaction_list.id')
                    ->join('users', 'users.id', '=', 'tb_transaction.to')
                    ->selectRaw('tb_transaction.*, tb_transaction_detail.transaction_list_id, tb_transaction_detail.id AS detail_id, tb_transaction_detail.pin_code, users.userid')
                    ->where('tb_transaction_detail.pin_code', '=', $pinCode)
                    ->orderBy('tb_transaction.id')
                    ->orderBy('tb_transaction_detail.transaction_list_id')
                    ->orderBy('tb_transaction_detail.id')
                    ->get();
    }

    //  sebelum menggunakan function ini, baiknya klarifikasi dulu function getCountFreePIN,
    //  jika total pin 0, maka jgn panggin function ini
    public function getMemberHavePIN($user_id) {
        /*$query = $this->baseUserPinQuery($user_id)
                    ->selectRaw('tb_pin_member.*')
                    ->where('tb_pin_member.is_used', '=', 0)
                    ->where('tb_transaction.created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->orderBy('tb_pin_member.id')
                    ->first();

        return empty($query) ? null : $this->where('user_id', '=', $user_id)
                                            ->where('id', '=', $query->id)
                                            ->where('is_used', '=', 0)
                                            ->orderBy('id')
                                            ->first();*/

        return $this->where('user_id', '=', $user_id)
                    ->where('is_used', '=', 0)
                    ->where('created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->orderBy('id')
                    ->first();
    }
    
    public function getAllFreePIN($user_id) {
        /*return $this->baseUserPinQuery($user_id)
                    ->selectRaw('tb_pin_member.*')
                    ->where('tb_pin_member.is_used', '=', 0)
                    ->where('tb_transaction.created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->get();*/

        return $this->where('user_id', '=', $user_id)
                    ->where('is_used', '=', 0)
                    ->where('created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->orderBy('id')
                    ->get();
    }

    public function getCountFreePIN($user_id) {
        /*return $this->baseUserPinQuery($user_id)
                    ->where('tb_pin_member.is_used', '=', 0)
                    ->where('tb_transaction.created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->count('tb_pin_member.id');*/

        return $this->where('user_id', '=', $user_id)
                    ->where('is_used', '=', 0)
                    ->where('created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->count('id');
    }

    public function getAllPin($status = null, $user_id) {
        if ($status == null) $status = 0;
        /*return $this->baseUserPinQuery($user_id)
                    ->selectRaw("tb_pin_member.is_used, tb_pin_member.pin_code, COALESCE(tb_pin_member.updated_at, tb_pin_member.created_at) AS updated_date")
                    ->where('tb_pin_member.is_used', '=', $status)
                    ->where('tb_transaction.created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->get();*/

        return $this->selectRaw("is_used, pin_code, COALESCE(updated_at, created_at) AS updated_date")
                    ->where('user_id', '=', $user_id)
                    ->where('is_used', '=', $status)
                    ->where('created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->orderBy('id')
                    ->get();
    }
    
    public function getAllUsedPIN() {
        /*return $this->baseUserPinQuery()
                    ->selectRaw("1 as no, DATE_FORMAT(tb_pin_member.updated_at, '%Y-%m-%d %H:%i') as date, 
                                tb_pin_member.pin_code, tb_pin_member.transaction_code, 
                                users.userid, users.name, placeUser.name as placeName, placeUser.userid as placeUserid")
                    ->join('users', 'users.id', '=', 'tb_pin_member.user_id')
                    ->leftJoin('users as placeUser', 'placeUser.pin_code', '=', 'tb_pin_member.pin_code')
                    ->where('tb_pin_member.is_used', '=', 1)
                    ->where('tb_transaction.created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->get();*/

        return $this->selectRaw("1 as no, DATE_FORMAT(tb_pin_member.updated_at, '%Y-%m-%d %H:%i') as date, 
                                tb_pinb_member.pin_code, tb_pinb_member.transaction_code, 
                                users.userid, users.name, placeUser.name as placeName, placeUser.userid as placeUserid")
                    ->join('users', 'users.id', '=', 'tb_pin_member.user_id')
                    ->leftJoin('users as placeUser', 'placeUser.pin_code', '=', 'tb_pin_member.pin_code')
                    ->where('tb_pinb_member.is_used', '=', 1)
                    //->where('tb_pin_member.created_at', '>=', $this->tglStart) //  versi 4 juli 2017
                    ->get();
    }

    public function setUsed() {
        if (!$this->id) return false;
        try {
            $this->update(['is_used' => 1]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    //  previsous version, versi 4 juli 2017
    public function getCountPreviousFreePIN($user_id) {
        /*return $this->baseUserPinQuery($user_id)
                    ->where('tb_pin_member.is_used', '=', 0)
                    ->where('tb_transaction.created_at', '<', $this->tglStart)
                    ->count('tb_pin_member.id');*/

        return $this->where('user_id', '=', $user_id)
                    ->where('is_used', '=', 0)
                    ->where('created_at', '<', $this->tglStart) //  versi 4 juli 2017
                    ->count('id');
    }

    public function getAllPreviousFreePIN($user_id) {
        /*return $this->baseUserPinQuery($user_id)
                    ->selectRaw("tb_pin_member.pin_code, tb_transaction.transaction_code, 
                        COALESCE(tb_pin_member.updated_at, tb_pin_member.created_at) AS updated_date, 
                        tb_pin_member.is_used")
                    ->where('tb_pin_member.is_used', '=', 0)
                    ->where('tb_transaction.created_at', '<', $this->tglStart)
                    ->get();*/

        return $this->baseUserPinQuery($user_id)
                    ->selectRaw("tb_pinb_member.pin_code, tb_transaction.transaction_code, 
                        COALESCE(tb_pinb_member.updated_at, tb_pinb_member.created_at) AS updated_date, 
                        tb_pin_member.is_used")
                    ->where('tb_pinb_member.user_id', '=', $user_id)
                    ->where('tb_pinb_member.is_used', '=', 0)
                    ->where('tb_pinb_member.created_at', '<', $this->tglStart) //  versi 4 juli 2017
                    ->get();
    }
}