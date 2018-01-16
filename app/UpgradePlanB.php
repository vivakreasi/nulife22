<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UpgradePlanB extends Model
{
    /*  define tablename */
    protected $table = 'tb_upgrade_b';

    protected $fillable = array('upgrade_kode', 'user_id', 'userid', 'planb_type', 'foot_left', 'foot_right',
        'upgrade_price', 'unique_digit', 'total_price', 'bank_id', 'province_id', 'kota_id', 'kelurahan_id',
        'Alamat', 'kode_pos', 'kirim_tarif', 'kirim_tarif_subsidi', 'upload_file', 'upload_at', 'status', 'note', 'approove_by');

    public function tarif()
    {
        return $this->belongsTo('App\Tarif');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function getAllUploadedTransfer() {
        return $this->join('users', 'users.id', '=', 'tb_upgrade_b.user_id')
                    ->leftJoin('tb_bank_company', 'tb_bank_company.id', '=', 'tb_upgrade_b.bank_id')
                    ->where('tb_upgrade_b.status', '=', 1)
                    ->selectRaw("'' AS tanggal, 
                        tb_upgrade_b.upgrade_kode, 
                        '' AS member, 
                        users.email,
                        tb_upgrade_b.total_price, 
                        '' AS bank, 
                        tb_upgrade_b.id, 
                        tb_upgrade_b.upload_file, 
                        tb_upgrade_b.userid, 
                        users.name, 
                        tb_upgrade_b.foot_left, 
                        tb_upgrade_b.foot_right, 
                        tb_bank_company.bank_name, 
                        tb_bank_company.bank_account, 
                        tb_bank_company.bank_account_name,
                        tb_upgrade_b.created_at")
                    ->get();
    }

    public function getUserUpgradeData($id)
    {
        return $this->where('user_id', '=', $id)->first();
    }

    public function getUserUpgradeDataCount($id)
    {
        return $this->select(['planb_type'])->where('user_id', '=', $id)->first();
    }

    public function getDataWithUser($id) {
        $result = (object) array(
            'data'  => $this->where('id', '=', $id)->first(),
            'user'  => null
        );
        if (!empty($result->data)) {
            $result->user = $result->data->hasOne('\App\User', 'id', 'user_id')->first();
        }
        return $result;
    }
    
    private $startDigit = 1;
    private $endDigit = 999;

    private function isUnikDigitExist($digit) {
        $test = intval($digit);
        if ($test > $this->endDigit) return true;
        if ($test < $this->startDigit) return true;
        $check = $this->where('unique_digit', '=', $digit)
                    ->where('status', '=', 0)
                    ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '=', date('Y-m-d'))
                    ->first();
        return !empty($check);
    }

    private function setUniqueDigit($unik) {
        $len = strlen(strval($this->endDigit));
        return str_pad($unik, $len, '0', STR_PAD_LEFT);
    }

    private function getUniqueDigit() {
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

    public function startUpgrade($user, $dataDelivery, &$result) {
        if (empty($user)) return false;
        if ($user->priceUpgradeToB() <= 0) return false;
        $unikDigit = $this->getUniqueDigit();
        if ($unikDigit == '000') return false;
        $clsBank = new \App\BankCompany;
        $companyBank = $clsBank->getOneBank();
        if (empty($companyBank)) return false;

        $clsSettingB = new Plan_b_setting();
        $settingB = $clsSettingB->getSetting();

        $clsTarif = new Tarif();
        $tarif = $clsTarif->find($dataDelivery['kelurahan']);

        $values = array(
            'upgrade_kode'  => uniqid(),
            'user_id'       => $user->id,
            'userid'        => $user->userid,
            'planb_type'    => intval($dataDelivery['sel_position']),
            'foot_left'     => $user->getCountLeftStructure(),
            'foot_right'    => $user->getCountRightStructure(),
            'upgrade_price' => $user->priceUpgradeToB() * intval($dataDelivery['sel_position']),
            'unique_digit'  => intval($unikDigit),
            'total_price'   => ($user->priceUpgradeToB() * intval($dataDelivery['sel_position'])) + intval($unikDigit) + intval($tarif->tarif) - intval($settingB->subsidi_tarif_kirim),
            'bank_id'       => $companyBank->id,
            'province_id'   => $dataDelivery['provinsi'],
            'kota_id'       => $dataDelivery['kota'],
            'kelurahan_id'  => $dataDelivery['kelurahan'],
            'Alamat'        => $dataDelivery['address'],
            'kode_pos'      => $dataDelivery['zip_code'],
            'kirim_tarif'   => $tarif->tarif,
            'kirim_tarif_subsidi'   => $settingB->subsidi_tarif_kirim,
            'status'        => 0
        );
        try {
            $result = $this->create($values);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAvailableClaim($user)
    {
        return $this
            ->selectRaw('tb_upgrade_b.*, tb_product_claims.id AS claim_id, tb_product_claims.inv_trans_id, tb_product_claims.type, 
                tb_product_claims.status AS claim_status, tb_product_claims.delivery_address, tb_product_claims.delivery_city, 
                tb_product_claims.delivery_province, tb_product_claims.delivery_zip_code, tb_product_claims.delivery_phone,
	            tb_product_claims.created_at AS claim_created_at, tb_product_claims.updated_at AS claim_updated_at')
            ->leftjoin('tb_product_claims', function ($join) {
                $join->on('tb_upgrade_b.user_id', '=', 'tb_product_claims.user_id')
                    ->where('tb_product_claims.type', '=', 'B');
            })
            ->where('tb_upgrade_b.user_id','=',$user->id)
            ->first();
    }

    public function isUpgradeMine($code, $user)
    {
        $upgrade = $this
            ->where('upgrade_kode','=',$code)
            ->where('user_id','=',$user->id)
            ->first();
        return (is_null($upgrade)) ? false : true;
    }

    public function getUpgradeData($code)
    {
        return $this->where('upgrade_kode', '=', $code)->first();
    }
}
