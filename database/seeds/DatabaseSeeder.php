<?php

use Illuminate\Database\Seeder;

use App\User;
use App\UserType;

use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        /*
        DB::table('users_type')->truncate();
        $user = array(
            array('id' => 0, 'code' => 'free', 'desc' => 'Free', 'short_desc' => 'Free', 'left_target' => 0, 'right_target' => 0),
            array('id' => 1, 'code' => 'rb', 'desc' => 'Ruby', 'short_desc' => 'Ruby', 'left_target' => 5, 'right_target' => 5),
            array('id' => 2, 'code' => 'sp', 'desc' => 'Saphire', 'short_desc' => 'Shapire', 'left_target' => 25, 'right_target' => 25),
            array('id' => 3, 'code' => 'em', 'desc' => 'Emerald', 'short_desc' => 'Emerald', 'left_target' => 175, 'right_target' => 175),
            array('id' => 4, 'code' => 'dm', 'desc' => 'Diamond', 'short_desc' => 'Diamond', 'left_target' => 800, 'right_target' => 800),
            array('id' => 5, 'code' => 'redd', 'desc' => 'Red Diamond', 'short_desc' => 'Red D', 'left_target' => 3000, 'right_target' => 3000),
            array('id' => 6, 'code' => 'blued', 'desc' => 'Blue Diamond', 'short_desc' => 'Blue D', 'left_target' => 9000, 'right_target' => 9000),
            array('id' => 7, 'code' => 'whited', 'desc' => 'White Diamond', 'short_desc' => 'White D', 'left_target' => 20000, 'right_target' => 20000),
            array('id' => 8, 'code' => 'blackd', 'desc' => 'Black Diamond', 'short_desc' => 'Black D', 'left_target' => 50000, 'right_target' => 50000),
            
            array('id' => 100, 'code' => 'adm', 'desc' => 'All Factory', 'short_desc' => null, 'left_target' => 0, 'right_target' => 0),
            array('id' => 101, 'code' => 'adminv', 'desc' => 'Admin Inventory', 'short_desc' => null, 'left_target' => 0, 'right_target' => 0),
            array('id' => 102, 'code' => 'admpin', 'desc' => 'Admin Pin', 'short_desc' => null, 'left_target' => 0, 'right_target' => 0),
            array('id' => 103, 'code' => 'admwd', 'desc' => 'Admin Widrawal', 'short_desc' => null, 'left_target' => 0, 'right_target' => 0),
            array('id' => 104, 'code' => 'admdelivery', 'desc' => 'Admin Delivey', 'short_desc' => null, 'left_target' => 0, 'right_target' => 0),
            array('id' => 200, 'code' => 'dev', 'desc' => 'IT Admin', 'short_desc' => null, 'left_target' => 0, 'right_target' => 0)
        );
        DB::table('users_type')->insert($user);

        
        $provinsi = base_path().'/database/csv/provinces.csv';
        $provinsiOpen = fopen($provinsi, "r");
        DB::table('tb_provinces')->truncate();
        while (($rowProvinsi = fgetcsv($provinsiOpen, 0, ",")) !== FALSE) {
            $dataProv = array('id' => $rowProvinsi[0], 'nama' => $rowProvinsi[1]);
            DB::table('tb_provinces')->insert($dataProv);
        }
        $kota = base_path().'/database/csv/cities.csv';
        $kotaOpen = fopen($kota, "r");
        DB::table('tb_kota')->truncate();
        while (($rowKota = fgetcsv($kotaOpen, 0, ",")) !== FALSE) {
            $cekProv = DB::table('tb_provinces')->selectRaw('id, nama')->where('id', '=', $rowKota[1])->first();
            if($cekProv != null){
                $dataKota = array('id' => $rowKota[0], 'id_province' => $rowKota[1], 'nama_kota' => $rowKota[2]);
                DB::table('tb_kota')->insert($dataKota);
            }
        }

        DB::table('tb_pin_type')->truncate();
        DB::table('tb_pin_type')->insert([
            'pin_type_name' => 'Activation PIN',
            'business_rights_amount' => 1,
            'pin_type_price' => 360000,
            'pin_type_stockis_price' => 350000,
            'pin_type_masterstockis_price' => 330000
        ]);
        DB::table('tb_min_order_setting')->truncate();
        DB::table('tb_min_order_setting')->insert([
            'name' => 'User',
            'amount' => 0
        ]);
        DB::table('tb_min_order_setting')->truncate();
        DB::table('tb_min_order_setting')->insert([
            'name' => 'Stockis',
            'amount' => 25
        ]);
        DB::table('tb_min_order_setting')->truncate();
        DB::table('tb_min_order_setting')->insert([
            'name' => 'Master Stockis',
            'amount' => 100
        ]);
        DB::table('tb_bank_company')->truncate();
        DB::table('tb_bank_company')->insert([
            'bank_name' => 'BCA',
            'bank_account' => 100181811,
            'bank_account_name' => 'Admin',
            'is_active' => 1
        ]);
        */

        //  create user type untuk admin bonus (karena belum ada)
        $uType = array(
            array('id' => 105, 'code' => 'admcs', 'desc' => 'Admin Customer Service', 'short_desc' => null, 'left_target' => 0, 'right_target' => 0),
        );
        UserType::insert($uType);

        //  create user Admin by role
        $sekarang = date('Y-m-d H:i:s');
        $uAdmin = array(
            //  admin inventory
            ['name' => 'Administrator Inventory', 'email' => 'adm_inv@nulife.co.id', 'password' => Hash::make('invABC'), 
            'hp' => '0809', 'userid' => 'admin-inv', 'id_type' => 101, 'is_active_type' => 1,
            'active_type_at' => $sekarang, 'is_stockis' => 0, 'id_referal' => 0, 'is_active' => 1, 'active_at' => $sekarang, 
            'plan_status' => 0, 'is_referal_link' => 0, 'id_join_type' => 'SILVER', 'created_at' => $sekarang],
            //  admin PIN
            ['name' => 'Administrator PIN', 'email' => 'adm_pin@nulife.co.id', 'password' => Hash::make('pinABC'), 
            'hp' => '0809', 'userid' => 'admin-pin', 'id_type' => 102, 'is_active_type' => 1,
            'active_type_at' => $sekarang, 'is_stockis' => 0, 'id_referal' => 0, 'is_active' => 1, 'active_at' => $sekarang, 
            'plan_status' => 0, 'is_referal_link' => 0, 'id_join_type' => 'SILVER', 'created_at' => $sekarang],
            //  admin Withdrawal
            ['name' => 'Administrator WD', 'email' => 'adm_wd@nulife.co.id', 'password' => Hash::make('wdABC'), 
            'hp' => '0809', 'userid' => 'admin-wd', 'id_type' => 103, 'is_active_type' => 1,
            'active_type_at' => $sekarang, 'is_stockis' => 0, 'id_referal' => 0, 'is_active' => 1, 'active_at' => $sekarang, 
            'plan_status' => 0, 'is_referal_link' => 0, 'id_join_type' => 'SILVER', 'created_at' => $sekarang],
            //  admin Delivery
            ['name' => 'Administrator Delivery', 'email' => 'adm_delivery@nulife.co.id', 'password' => Hash::make('deliverABC'), 
            'hp' => '0809', 'userid' => 'admin-deliver', 'id_type' => 104, 'is_active_type' => 1,
            'active_type_at' => $sekarang, 'is_stockis' => 0, 'id_referal' => 0, 'is_active' => 1, 'active_at' => $sekarang, 
            'plan_status' => 0, 'is_referal_link' => 0, 'id_join_type' => 'SILVER', 'created_at' => $sekarang],
            //  admin Customer Service
            ['name' => 'Administrator CS', 'email' => 'adm_cs@nulife.co.id', 'password' => Hash::make('cssABC'), 
            'hp' => '0809', 'userid' => 'admin-cs', 'id_type' => 105, 'is_active_type' => 1,
            'active_type_at' => $sekarang, 'is_stockis' => 0, 'id_referal' => 0, 'is_active' => 1, 'active_at' => $sekarang, 
            'plan_status' => 0, 'is_referal_link' => 0, 'id_join_type' => 'SILVER', 'created_at' => $sekarang],
        );
        User::insert($uAdmin);
    }
}
