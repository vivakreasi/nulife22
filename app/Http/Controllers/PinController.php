<?php

namespace App\Http\Controllers;

use App\Partner_setting;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Yajra\Datatables\Facades\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Shared_Date;
use DB;
use Response;

//use Illuminate\Support\Facades\DB;

/*

STATUS UNTUK TRANSACTION :
0 = PENDING
1 = TRANSFERED (SUDAH ADA KONFIRMASI TRANSFER)
2 = APPROVED
3 = CANCELLED

TRANSACTION TYPE :
1 = ORDER (from = STOCKIS/MASTER STOCKIS, to = USER )
2 = TRANSFER
3 = BUY (from = PERUSAHAAN, to = STOCKIS/MASTER STOCKIS)

*/

class PinController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            parent::__construct();
            //  hanya user member
            if($this->isLoggedIn) {
                $this->initC(true);
                return $next($request);
            }
            // logout user, karena jika melalui hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        }, ['except' => 'welcome']);
    }

    /**
     * Menampilkan halaman untuk my pin
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function myPin(Request $request)
    {
        if ($this->isAdmin) {
            return redirect()->route('admin');
        }

        $this->setPageHeader('My PIN', 'Your PIN Stock for NuLife Plan-A/B program');
        $pin_member = new \App\PinMember;
        $jmlPin = $pin_member->getCountFreePIN($this->user->id);
        $status = 0;
        return view('pin.my', compact( 'jmlPin', 'status' ));
    }

    public function ajaxListMy(Request $request) {
        $pin_member = new \App\PinMember;
        $orders = $pin_member->getAllPin($request->get('status', null), $this->user->id);
        $data = Datatables::collection($orders);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                //$row->is_used = $row->is_used;
                //$row->pin_code = $row->pin_code;
                $row->updated_date = date('Y-m-d H:i', strtotime($row->updated_date));
            }
        }
        return $data->make();
    }    

    /**
     * Menampilkan halaman untuk order pin
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    /*public function orderPin(Request $request)
    {
        if ($this->isAdmin) {
            return redirect()->route('admin');
        }

        $this->setPageHeader('Order/Transfer PIN', 'PIN Order/Transfer for NuLife Plan-A/B program');
        $userid = DB::table('users')->where('id', Auth::user()->id)->value('userid');
        $pin_converted = DB::table('pin_converted')->where('user_id', $userid)->value('pin');
        $old_pin = DB::table('old_pin')->where('userid', $userid)->value('pin');
        $pin_type_list = \App\PinType::all();
        $clsUser = new User();
        $stockist_list = $clsUser->getListStockist();
//        $stockist_list = \App\User::whereIn('is_stockis', [1,2])->pluck('name', 'id');
//        dd($stockist_list);
        $pin_list = DB::select('SELECT b.pin_type_name, COUNT(*) as amount FROM tb_pin_member a JOIN tb_pin_type b ON (a.pin_type_id = b.id) WHERE a.user_id = '.Auth::user()->id.' GROUP BY a.pin_type_id');
        $pin_list_empty = [];
        if(count($pin_list) == 0){
            $pin_list_empty = DB::select('SELECT * FROM tb_pin_type');
        }
        if ($request->isMethod('post')){
            $maxOrder = 200;

            $trans_code = strtoupper(uniqid());

            $total = 0;
            foreach ($pin_type_list as $key) {
                $idpin = str_replace(' ', '-', strtolower($key->pin_type_name));
                if($request->$idpin > 0){
                    $total += $request->$idpin*$key->pin_type_price;
                }
            }
            if($total == 0){
                $pesan = $this->setPesanFlash('error', 'You must add amount at least one of the pin type');
                return redirect()->back()->with($pesan);
            }
            if ($request->$idpin > $maxOrder) {
                $pesan = $this->setPesanFlash('error', 'The maximum order is ' . $maxOrder);
                return redirect()->back()->with($pesan);
            }
            
            $transaction = new \App\Transaction;
            $transaction->transaction_code = $trans_code;
            $transaction->transaction_type = 1;
            $transaction->from = $request->stockist;
            $transaction->to = Auth::user()->id;
            $transaction->total_price = $total;
            $transaction->status = 0;
            $transaction->created_at = date('Y-m-d H:i:s');
            $transaction->save();            
            
            $i = 0;
            foreach ($pin_type_list as $key) {
                $idpin = str_replace(' ', '-', strtolower($key->pin_type_name));
                if($request->$idpin > 0){
                    $i++;
                    
                    $transaction_list[$i] = new \App\TransactionList;
                    $transaction_list[$i]->transaction_code = $trans_code;
                    $transaction_list[$i]->pin_type_id = $key->id;
                    $transaction_list[$i]->amount = $request->$idpin;
                    $transaction_list[$i]->save();
                }
            }

            $pesan = $this->setPesanFlash('success', 'Your purchase order has been received and Recorded in our database.');
            return redirect()->route('pin.invoice', ['transaction_code' => $trans_code])->with($pesan);
            
        }
        return view('pin.order', compact( 'pin_type_list', 'stockist_list', 'pin_list', 'pin_list_empty', 'pin_converted', 'old_pin' ));
    }*/

    public function orderPin(Request $request)
    {
        if ($this->isAdmin) {
            return redirect()->route('admin');
        }

        $this->setPageHeader('Order/Transfer PIN', 'PIN Order/Transfer for NuLife Plan-A program');

        $maxOrder = 200;
        if($this->user->isStockis()){
            $clsSetting = new Partner_setting();
            if($this->user->isMasterStockis()){
                $min_order = $clsSetting->getSetting()->min_masterstockist_order;
//                    $min_order = \App\MinOrderSetting::where('name', 'Master Stockis')->value('amount');
            }
            else{
                $min_order = $clsSetting->getSetting()->min_stockist_order;
//                    $min_order = \App\MinOrderSetting::where('name', 'Stockis')->value('amount');
            }
        }
        else{
            $min_order = 1;
        }

        $pin_member = new \App\PinMember;
        $jmlPin = $pin_member->getCountFreePIN($this->user->id);

        $pin_type_list = \App\PinType::first();
        
        $clsUser = new User();
        $stockist_list = $clsUser->getListStockist();
        
        if ($request->isMethod('post')){
            $maxOrder = 200;

            $idpin = str_replace(' ', '-', strtolower($pin_type_list->pin_type_name));
            
            if($request->$idpin <= 0){
                $pesan = $this->setPesanFlash('error', 'You must add amount at least one of the pin type');
                return redirect()->back()->with($pesan);
            } elseif ($request->$idpin > $maxOrder) {
                $pesan = $this->setPesanFlash('error', 'The maximum order is ' . $maxOrder);
                return redirect()->back()->with($pesan);
            }

            $total = $request->$idpin * $pin_type_list->pin_type_price;

            $trans_code = strtoupper(uniqid());
            
            $transaction = new \App\Transaction;
            
            DB::beginTransaction();
            $okTrans = $transaction->createTransaction($trans_code, 1, $request->stockist, $this->user->id, $total, 0);
            if (!$okTrans) {
                DB::rollback();
                $pesan = $this->setPesanFlash('error', 'Failed to create order.');
                return redirect()->back()->with($pesan);
            }
            
            $trList     = new \App\TransactionList;
            $keyType    = $pin_type_list->id;
            $okList     = $trList->craetedTransactionList($trans_code, $keyType, $request->$idpin);
            if (!$okList) {
                DB::rollback();
                $pesan = $this->setPesanFlash('error', 'Failed to create order.');
                return redirect()->back()->with($pesan);
            }
            DB::commit();
            $pesan = $this->setPesanFlash('success', 'Your purchase order has been received and Recorded in our database.');
            return redirect()->route('pin.invoice', ['transaction_code' => $trans_code])->with($pesan);
            
        }
        return view('pin.order')
            ->with('maxOrder', $maxOrder)
            ->with('min_order', $min_order)
            ->with(compact( 'pin_type_list', 'stockist_list', 'jmlPin'));
    }



    /**
     * Menampilkan halaman untuk buy pin dari stockis ke perusahaan
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function buyPin(Request $request)
    {
        if ($this->isAdmin) {
            return redirect()->route('admin');
        }
        $pin_type_list = \App\PinType::first();

        $maxOrder = 200;
        if($this->user->isStockis()){
            $clsSetting = new Partner_setting();
            if($this->user->isMasterStockis()){
                $min_order = $clsSetting->getSetting()->min_masterstockist_order;
//                    $min_order = \App\MinOrderSetting::where('name', 'Master Stockis')->value('amount');
            }
            else{
                $min_order = $clsSetting->getSetting()->min_stockist_order;
//                    $min_order = \App\MinOrderSetting::where('name', 'Stockis')->value('amount');
            }
        }
        else{
            $min_order = 1;
        }

        if ($request->isMethod('post')){
            $idpin = str_replace(' ', '-', strtolower($pin_type_list->pin_type_name));

            $count = $request->$idpin;
            $keyPrice = $this->user->isMasterStockis() ? $pin_type_list->pin_type_masterstockis_price : $pin_type_list->pin_type_stockis_price;
            $total = $request->$idpin * $keyPrice;

            if (intval($min_order) < 1) $min_order = 1;

            if($count < $min_order){
                $pesan = $this->setPesanFlash('error', 'Sorry, Your minimum order is ' . $min_order);
                return redirect()->back()->with($pesan);
            }

            if ($count > $maxOrder) {
                $pesan = $this->setPesanFlash('error', 'The maximum order is ' . $maxOrder);
                return redirect()->back()->with($pesan);
            }
            
            $trans_code = strtoupper(uniqid());
            
            $transaction = new \App\Transaction;

            $unique_digit = $this->Transaction->getUniqueDigit();
            DB::beginTransaction();
            $okTrans = $transaction->createTransaction($trans_code, 3, 0, $this->user->id, $total, $unique_digit);
            if (!$okTrans) {
                DB::rollback();
                $pesan = $this->setPesanFlash('error', 'Failed to create order.');
                return redirect()->back()->with($pesan);
            }

            $trList     = new \App\TransactionList;
            $keyType    = $pin_type_list->id;
            $okList     = $trList->craetedTransactionList($trans_code, $keyType, $request->$idpin);
            if (!$okList) {
                DB::rollback();
                $pesan = $this->setPesanFlash('error', 'Failed to create order.');
                return redirect()->back()->with($pesan);
            }
            DB::commit();

            $pesan = $this->setPesanFlash('success', 'Your purchase order has been received and Recorded in our database.');
            return redirect()->route('pin.invoice', ['transaction_code' => $trans_code])->with($pesan);
            
        }
        return view('pin.order')
            ->with('maxOrder', $maxOrder)
            ->with('min_order', $min_order)
            ->with(compact('pin_type_list'));
    }

    /**
     * Menampilkan halaman untuk invoice pin
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function invoicePin($transaction_code)
    {
        if(Auth::user()->isAdmin()){
            $from = 0;
        }
        else{
            $from = Auth::user()->id;
        }
        $transaction = \App\Transaction::where('transaction_code', $transaction_code)
                                        ->where(function ($query) use ($from) {
                                            $query->where('to', Auth::user()->id)
                                            ->orWhere('from', $from);
                                        })
                                        ->first();
        if(!$transaction){
            $pesan = $this->setPesanFlash('error', 'Sorry, invoice not found');
            return redirect()->back()->with($pesan);
        }
        $list = \App\TransactionList::where('transaction_code', $transaction->transaction_code)->get();

        if($transaction->from == 0){
            $from = \App\BankCompany::where('is_active', 1)->first();
        }
        else{
            if($transaction->transaction_type == 1){
                $from = \App\BankMember::where('user_id', $transaction->to)->where('is_used', 1)->first();
            }
            else{
                $from = \App\BankMember::where('user_id', $transaction->from)->where('is_used', 1)->first();
            }
        }

        $confirm_order = \App\TransactionConfirm::where('transaction_code', $transaction_code)->first();

        return view('pin.invoice', compact( 'transaction', 'list', 'from', 'confirm_order' ));
    }

    public function listOrder()
    {
        $this->setPageHeader('List Order Pin');
        return view('pin.list_order')
                ->with('status', 0);
    }

    public function ajaxListOrder(Request $request) {
        $transaction = new \App\Transaction;
        $orders = $transaction->getAllOrders($request->get('status', 0), $this->user->id, $this->user->isStockis(), $this->user->isAdmin());
        $data = Datatables::collection($orders);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                //$row->status = $row->status;
                //$row->created_at = date('Y-m-d H:i', strtotime($row->created_at));
                //$row->transaction_code = $row->transaction_code;
                $row->total_price = 'Rp ' . number_format($row->total_price, 0, ',', '.') .',-';
            }
        }
        return $data->make();
    }

    /**
     * Approval untuk order PIN
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function orderPinPost(Request $request)
    {
        $data = \App\Transaction::find($request->id);
        if($request->status == 2){
            DB::beginTransaction();
            $pin_type_list = \App\PinType::first();

            if (empty($pin_type_list)) return ($data->transaction_type == 3) ? 3 : 2;

            if($data->transaction_type == 3){
                $transaction_list = \App\TransactionList::where('transaction_code', $data->transaction_code)
                                        ->where('pin_type_id', $pin_type_list->id)
                                        ->first();
                
                if(empty($transaction_list)) return 3;
                
                if($transaction_list->amount > 0){
                    $currentCodes = [];
                    $pinPinan = new \App\Pin;

                    for ($x=0; $x < $transaction_list->amount; $x++) { 
                        /*
                        $new_pin_code = $x.date('his').rand(1,999);
                        $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                        if($cek){
                            $new_pin_code = $x.date('his').rand(1,999);
                            $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                            if($cek){
                                $new_pin_code = $x.date('his').rand(1,999);
                                $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                                if($cek){
                                    $new_pin_code = $x.date('his').rand(1,999);
                                    $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                                    if($cek){
                                        DB::rollback();
                                        return 3;
                                    }
                                }
                            }
                        }
                        */

                        $new_pin_code = $pinPinan->getNewPinCode($currentCodes);
                        if ($new_pin_code == '') {
                            DB::rollback();
                            return 3;
                        }
                        
                        $new_pin = new \App\Pin;
                        $new_pin->pin_code = $new_pin_code;
                        $new_pin->pin_type_id = $pin_type_list->id;
                        $new_pin->is_sold = 1;
                        $new_pin->save();

                        $new_pin_member = new \App\PinMember;
                        $new_pin_member->pin_code = $new_pin_code;
                        $new_pin_member->pin_type_id = $pin_type_list->id;
                        $new_pin_member->user_id = $data->to;
                        $new_pin_member->transaction_code = $data->transaction_code;
                        $new_pin_member->is_used = 0;
                        $new_pin_member->save();

                        // Tambah di transaction_detail
                        $transaction_detail[$x] = new \App\TransactionDetail;
                        $transaction_detail[$x]->transaction_list_id = $transaction_list->id;
                        $transaction_detail[$x]->pin_code = $new_pin_code;
                        $transaction_detail[$x]->save();
                    }
                }
            }
            else{
                $transaction_list = \App\TransactionList::where('transaction_code', $data->transaction_code)
                                            ->where('pin_type_id', $pin_type_list->id)
                                            ->first();
                
                if(empty($transaction_list)) return 3;

                if($transaction_list->amount > 0){
                    $getPin = \App\PinMember::where('user_id', $data->from)
                                                    ->where('is_used', 0)
                                                    ->where('pin_type_id', $pin_type_list->id)
                                                    ->get();
                    if($transaction_list->amount > count($getPin)){
                        // stock PIN tidak cukup
                        DB::rollback();
                        return 2;
                    }
                    for ($x=0; $x < $transaction_list->amount; $x++) { 
                        // Tambah di transaction_detail
                        $transaction_detail[$x] = new \App\TransactionDetail;
                        $transaction_detail[$x]->transaction_list_id = $transaction_list->id;
                        $transaction_detail[$x]->pin_code = $getPin[$x]->pin_code;
                        $transaction_detail[$x]->save();

                        // Update user_id (kepemilikan PIN) di PinMember
                        $pin_member = \App\PinMember::find($getPin[$x]->id);
                        $pin_member->user_id = $data->to;
                        $pin_member->save();
                    }
                }
            }
            DB::commit();
        }
        $data->status = $request->status;
        $data->save();
        return 1;
    }

    /**
     * Transfer PIN
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function transferPin(Request $request)
    {
        if ($this->isAdmin) {
            return redirect()->route('admin');
        }
        if ($request->isMethod('post')){
            $maxOrder = 20;

            $clsPin = new \App\PinMember;

            $freePin = $clsPin->getAllFreePIN($this->user->id);

            if ($freePin->isEmpty()) {
                $pesan = $this->setPesanFlash('error', 'You do not have any pin to transfer');
                return redirect()->back()->with($pesan);
            }

            $clonPin = clone $freePin;

            $totalFreePin = $clonPin->count();
            if ($totalFreePin < $maxOrder) $maxOrder = $totalFreePin;

            $trans_code = strtoupper(uniqid());

            $total = 0;
            $pin_type_list = \App\PinType::first();
            
            $idpin = str_replace(' ', '-', strtolower($pin_type_list->pin_type_name));
            
            if($request->$idpin > 0){
                $total = $request->$idpin * $pin_type_list->pin_type_price;
            } else {
                $pesan = $this->setPesanFlash('error', 'You must add amount at least one of the pin type');
                return redirect()->back()->with($pesan);
            }

            if ($request->$idpin > $maxOrder) {
                $pesan = $this->setPesanFlash('error', 'The maximum transfer pin is ' . $maxOrder);
                return redirect()->back()->with($pesan);
            }

            $cek = \App\User::where('userid', $request->userid)->first();
            if(!$cek){
                $pesan = $this->setPesanFlash('error', 'Sorry, User ID not found');
                return redirect()->back()->with($pesan);
            }

            if($cek->id == $this->user->id){
                $pesan = $this->setPesanFlash('error', 'Sorry, You cannot transfer pin to your own account');
                return redirect()->back()->with($pesan);
            }

            $user_id = $cek->id;

            /*$idpin = str_replace(' ', '-', strtolower($pin_type_list->pin_type_name));
            if($request->$idpin > 0){
                $getPins = \App\PinMember::where('user_id', $transaction->from)
                                                ->where('is_used', 0)
                                                ->where('pin_type_id', $pin_type_list->id)
                                                ->get();
                if($request->$idpin > count($getPins)){
                    $pesan = $this->setPesanFlash('error', 'Sorry, Your PIN is not enough to transfer that amount');
                    return redirect()->back()->with($pesan);
                }
            }*/

            $transaction = new \App\Transaction;
            
            DB::beginTransaction();

            $transaction->transaction_code = $trans_code;
            $transaction->transaction_type = 2;
            $transaction->from = $this->user->id;
            $transaction->to = $user_id;
            $transaction->total_price = $total;
            $transaction->status = 2;
            $transaction->created_at = date('Y-m-d H:i:s');
            $transaction->save();
            
            //$i = 0;
            try {
                /*
                foreach ($pin_type_list as $key) {
                    $idpin = str_replace(' ', '-', strtolower($key->pin_type_name));
                    if($request->$idpin > 0){
                        $i++;
                        
                        $transaction_list[$i] = new \App\TransactionList;
                        $transaction_list[$i]->transaction_code = $trans_code;
                        $transaction_list[$i]->pin_type_id = $key->id;
                        $transaction_list[$i]->amount = $request->$idpin;
                        $transaction_list[$i]->save();

                        for ($x=0; $x < $request->$idpin; $x++) { 
                            $getPin = \App\PinMember::where('user_id', $this->user->id)
                                                        ->where('is_used', 0)
                                                        ->where('pin_type_id', $key->id)
                                                        ->first();
                            if($getPin){
                                $transaction_detail[$i][$x] = new \App\TransactionDetail;
                                $transaction_detail[$i][$x]->transaction_list_id = $transaction_list[$i]->id;
                                $transaction_detail[$i][$x]->pin_code = $getPin->pin_code;
                                $transaction_detail[$i][$x]->save();

                                // Update user_id (kepemilikan PIN) di PinMember
                                $pin_member = \App\PinMember::find($getPin->id);
                                $pin_member->user_id = $transaction->to;
                                $pin_member->save();
                            }
                            else{
                                break;
                            }
                        }
                    }
                }
                */

                $transaction_list = new \App\TransactionList;
                $transaction_list->transaction_code = $trans_code;
                $transaction_list->pin_type_id = $pin_type_list->id;
                $transaction_list->amount = $request->$idpin;
                $transaction_list->created_at = date('Y-m-d H:i:s');
                $transaction_list->save();

                $x = 0;

                $transaction_detail = [];

                foreach ($freePin as $rowPin) {
                    $transaction_detail[$x] = new \App\TransactionDetail;
                    $transaction_detail[$x]->transaction_list_id = $transaction_list->id;
                    $transaction_detail[$x]->pin_code = $rowPin->pin_code;
                    $transaction_detail[$x]->save();

                    // Update user_id (kepemilikan PIN) di PinMember
                    //$pin_member = \App\PinMember::find($getPin->id);
                    //$pin_member->user_id = $transaction->to;
                    //$pin_member->save();

                    //$rowPin->update(['user_id' => $transaction->to, 'transaction_code' => $trans_code]);
                    $pin_member = \App\PinMember::where('id', '=', $rowPin->id)->update(['user_id' => $transaction->to, 'transaction_code' => $trans_code]);

                    $x += 1;
                    if ($x >= $request->$idpin) break;
                }

                DB::commit();
                $pesan = $this->setPesanFlash('success', 'Your transaction has been received by '.$request->userid.'.');
                return redirect()->route('pin.invoice', ['transaction_code' => $trans_code])->with($pesan);
            } catch (\Exception $e) {
                DB::rollback();
                $pesan = $this->setPesanFlash('error', 'Failed to process transfer pin');
                return redirect()->back()->with($pesan);
            }
        }
    }

    /**
     * Konfirmasi Pembayaran
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function confirmOrder(Request $request)
    {
        $data = new \App\TransactionConfirm;
        $data->transaction_code = $request->transaction_code;
        $data->bank_name = $request->bank_name;
        $data->account_no = $request->account_no;
        $data->account_name = $request->account_name;

        $objFile = $request->file('file');
        $tmpFile = '';
        if (! \App\Berkas::FileUploaded($objFile, $tmpFile)) {
            $pesan = $this->setPesanFlash('error', 'No image file uploaded.');
            return redirect()->back()->with($pesan)->withInput();
        }
        $cekFile = \App\Berkas::isAllowedImage('file', $objFile, 'jpg,png,jpeg', 2040);
        if (!$cekFile->Success) {
            $this->throwValidationException($request, $cekFile->Validator);
        }

        $dir = base_path('files/confirm_pin');
        $filename   = 'CP-'.$data->transaction_code . '.' . \App\Berkas::getExtentionFile($objFile);
        
        if (! \App\Berkas::doUpload($objFile, $dir, $filename)) {
            $pesan = $this->setPesanFlash('error', 'Failed processing upload. Please try again.');
            return redirect()->back()->with($pesan)->withInput();
        }

        $data->filename = $filename;

        $data->save();

        \App\Transaction::where('transaction_code', $request->transaction_code)->update(['status' => 1]);

        $pesan = $this->setPesanFlash('success', 'Success to confirm your order!');
        return redirect()->back()->with($pesan);
    }

    public function getdatauser($userid,$is_id)
    {
        if($is_id == 1){
            $datas = \App\User::where('id', $userid)->first();
        } elseif ($is_id == 2) {
            $datas = \App\User::where('id', 1)->first();
        } else {
            $datas = \App\User::where('userid', $userid)->first();
        }

        $data = (object) array(
            'userid' => 'Unknown',
            'nama' => 'Unknown',
            'telepon' => 'Unknown',
        );
        if (!empty($datas)) {
            $data = (object) array(
                'userid' => ($is_id == 2) ? 'NuLife' : $datas->userid,
                'nama' => ($is_id == 2) ? 'NuLife' : $datas->name,
                'telepon' => $datas->hp,
            );
        }
        
        return Response::json($data);
    }

    //  old pin, converted pin, previous version pin
    public function previousPin() {
        $pin_converted = DB::table('pin_converted')->where('user_id', $this->user->userid)->value('pin');
        if ($pin_converted == null) $pin_converted = 0;
        $old_pin = DB::table('old_pin')->where('userid', $this->user->userid)->value('pin');
        if ($old_pin == null) $old_pin = 0;
        $pin_member = new \App\PinMember;
        $jmlPrevPin = $pin_member->getCountPreviousFreePIN($this->user->id);

        return view('pin.previous')->with(compact('old_pin', 'pin_converted', 'jmlPrevPin'));
    }

    public function ajaxPreviousPin() {
        $pin_member = new \App\PinMember;
        $previous = $pin_member->getAllPreviousFreePIN($this->user->id);
        //dd($previous);
        $data = Datatables::collection($previous);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->updated_date = date('Y-m-d H:i', strtotime($row->updated_date));
            }
        }
        return $data->make();
    }
}
