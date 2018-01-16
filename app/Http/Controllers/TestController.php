<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listNotifs()
    {
        $data['notifs'] = DB::table('notifs')->get();
        return json_encode($data);
    }

    public function convertPin()
    {
        $pin_type_list = \App\PinType::all();
        foreach ($pin_type_list as $key) {
            $data_update = DB::table('pin_converted')->get();
            foreach ($data_update as $keys) {
                $data = DB::table('users')->where('userid', $keys->user_id)->first();
                if(!$data){
                    continue;
                }
                $amount = $keys->pin;
                $trans_code = strtoupper(uniqid());
                $transaction_id = DB::table('tb_transaction')->insertGetId([
                    'transaction_code' => $trans_code,
                    'transaction_type' => 2,
                    'from' => 0,
                    'to' => $data->id,
                    'total_price' => $amount*350000,
                    'unique_digit' => '000',
                    'status' => 2
                ]); 
                $transaction_list_id = DB::table('tb_transaction_list')->insertGetId([
                    'transaction_code' => $trans_code,
                    'pin_type_id' => $key->id,
                    'amount' => $amount
                ]);
                for ($x=0; $x < $amount; $x++) { 
                    $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
                    $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                    if($cek){
                        $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
                        $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                        if($cek){
                            $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
                            $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                            if($cek){
                                $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
                                $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                                if($cek){
                                    echo "old_pin => id = ".$keys->id;exit;
                                }
                            }
                        }
                    }
                    $x++;
                    
                    $new_pin = new \App\Pin;
                    $new_pin->pin_code = $new_pin_code;
                    $new_pin->pin_type_id = $key->id;
                    $new_pin->is_sold = 0;
                    $new_pin->save();

                    $new_pin_member = new \App\PinMember;
                    $new_pin_member->pin_code = $new_pin_code;
                    $new_pin_member->pin_type_id = $key->id;
                    $new_pin_member->user_id = $data->id;
                    $new_pin_member->transaction_code = $trans_code;
                    $new_pin_member->is_used = 0;
                    $new_pin_member->save();

                    // Tambah di transaction_detail
                    $transaction_detail[$x] = new \App\TransactionDetail;
                    $transaction_detail[$x]->transaction_list_id = $transaction_list_id;
                    $transaction_detail[$x]->pin_code = $new_pin_code;
                    $transaction_detail[$x]->save();
                }
            }
        }
    }

   public function getCityByProvince(Request $request, $id){

        $dataProv = \App\Provinces::where('id', '=', $id)->first();
        $result = [];
        if (!empty($dataProv)){
            $result = $dataProv->getCity()->toArray();
        }
        return json_encode($result);
   }

    public function getCityByProvince2($nama){

        $dataProv = \App\Provinces::where('nama', '=', $nama)->first();
        $result = [];
        if (!empty($dataProv)){
            $result = $dataProv->getCity2()->toArray();
        }
        return json_encode($result);
    }

}
