<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserProfile extends Model{
    
    protected $table = 'users_profile';
    protected $fillable = array('id_user', 'avatar', 'alamat', 'provinsi', 'kota', 'kode_post', 'gender', 'ktp', '');
    
    public function getMemberProfile($id_user) {
        return $this->where('id_user', '=', $id_user)->first();
    }
    
    public function getProvince() {
        return DB::table('tb_provinces')->selectRaw('id, nama')->orderBy('nama')->get();
    }

    public function getKecamatan() {
        return DB::table('tb_kirim_tarif')->selectRaw('id, tujuan')->orderBy('tujuan')->get();
    }

    public function getKota() {
        return DB::table('tb_kota')
                ->join('tb_provinces', 'tb_provinces.id', '=', 'tb_kota.id_province')
                ->selectRaw('tb_kota.id, tb_kota.nama_kota, tb_provinces.nama')
                ->get();
    }
    
    public function getDetailMemberProfile($id_user) {
        return $this->selectRaw('users_profile.*, tb_provinces.nama, tb_kota.nama_kota')
                            ->leftJoin('tb_provinces', 'tb_provinces.id', '=', 'users_profile.provinsi')
                            ->leftJoin('tb_kota', 'tb_kota.id', '=', 'users_profile.kota')
                            ->where('id_user', '=', $id_user)
                            ->first();
    }
    
    
    
}