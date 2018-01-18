<?php

namespace App\Http\Controllers;

use Bregananta\Inventory\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Yajra\Datatables\Facades\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PHPExcel_Shared_Date;
use App\Referal;
use App\Statik;
use App\BankMember;
use App\ProductClaim;
use App\Plan_a_setting;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //  contruct parent
            parent::__construct();
            //  only admin
            if($this->isLoggedIn && $this->isAdmin) {
                $this->initC(true);
                return $next($request);
            } elseif ($this->isLoggedIn && $this->user->isMember()) {
                return redirect()->route('dashboard');
            }
            // logout user, karena jika melalui hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        });
    }

    public function index() {
        $this->setPageHeader('Dashboard', 'Contains information and shortcut');
        $admRequestAB   = (object) array(
            'upgrade_b'     => array(
                                'count' => \App\UpgradePlanB::where('status', '=', 1)->count('id'),
                                'name'  => 'Upgrade Plan-B',
                                'route' => 'admin.plan.upgrade'
            ),
            'claim_reward'  => array(
                                'count' => \App\Bonus_reward::where('status', '=', 0)->count('id'),
                                'name'  => 'Claim Reward',
                                'route' => 'admin.plan.reward'
            ),
            'nucash_wd'     => array(
                                'count' => DB::table('tb_nucash_wd')
                                                ->where('is_transfer', '=', 0)
                                                //->where('is_versi_2', '=', 1)  //  versi 4 juli 2017
                                                ->count('id'),
                                'name'  => 'Nu-Cash Withdrawal',
                                'route' => 'admin.nucash.wd.list'
            ),
            'pin'           => array(
                                'count' => \App\Transaction::whereIn('status', [0, 1])
                                                ->where('from', '=', 0)
                                                ->where('created_at', '>=', $this->user->tglStart) //  versi 4 juli 2017
                                                ->count('id'),
                                'name'  => 'Order Pin',
                                'route' => 'pin.list'
            ),
            'placement'     => array(
                                'count' => \App\StrukturJaringan::whereRaw('DATE(created_at) = CURDATE()')->count('id'),
                                'name'  => 'Placement Today',
                                'route' => 'admin.pin.list'
            )
        );
        $admRequestC    = (object) array(
            'order'         => array(
                                'count' => \App\Plan_c_pin::whereIn('status', [4, 5])->count('id'),
                                'name'  => 'Order Plan-C',
                                'route' => 'admin.pinc.order'
            ),
            'wd'            => array(
                                'count' => \App\Plan_c_wd::where('status', '=', 0)->whereIn('bonus_c_type', [1, 2])->count('id'),
                                'name'  => 'WD Plan-C',
                                'route' => 'admin.planc.wd'
            ),
            'wd_ld'         => array(
                                'count' => \App\Plan_c_wd::where('status', '=', 0)->where('bonus_c_type', '=', 3)->count('id'),
                                'name'  => 'WD Ranking',
                                'route' => 'admin.planc.wd.leadership'
            ),
            'join_today'    => array(
                                'count' => \App\Plan_c::whereNull('fly_at')->where(DB::raw("DATE(created_at)"), '=', DB::raw("CURDATE()"))->count('id'),
                                'name'  => 'Join Today',
                                'route' => 'admin.planc.join.report'
            ),
            'fly_today'     => array(
                                'count' => \App\Plan_c::whereNotNull('fly_at')->where(DB::raw("DATE(fly_at)"), '=', DB::raw("CURDATE()"))->count('id'),
                                'name'  => 'Fly Today',
                                'route' => 'admin.planc.join.report'
            )
        );
        $totalRequestAB = $admRequestAB->upgrade_b['count'] + $admRequestAB->claim_reward['count'] + $admRequestAB->nucash_wd['count'] + $admRequestAB->pin['count'] + $admRequestAB->placement['count'];
        return view('admin.dashboard')->with(compact('totalRequestAB', 'admRequestAB', 'admRequestC'));
    }

    /**
     * Menampilkan halaman untuk melihat semua order plan-C yang belum confirm/unconfirm (ADMIN)
     * CONFIRM = 5
     * CANCEL = 11
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function listOrderC(Request $request)
    {
        $this->setPageHeader('List Order Pin Plan-C');
        if (!$this->user->hasAccessRoute('admin.pinc.order')) return view('404');
        return view('admin.planc.list_order')
                ->with('status', 1);
    }

    public function ajaxListOrderC(Request $request) {
        if (!$this->user->hasAccessRoute('admin.pinc.order')) return view('404');
        $orders = $this->PinC->getAllOrders($request->get('status', 0));
        $data = Datatables::collection($orders);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                //$row->tgl_order = date('d-m-Y H:i', strtotime($row->tgl_order));
                $row->tgl_order = date('Y-m-d H:i', strtotime($row->tgl_order));
                $row->x_jmlpin = number_format($row->x_jmlpin, 0, ',', '.');
                $row->nilai_transfer = 'Rp ' . number_format($row->nilai_transfer, 0, ',', '.') .',-';
                $row->tgl_status = date('Y-m-d H:i', strtotime($row->tgl_status));
            }
        }
        return $data->make();
    }

    public function ajaxListPaymentC(Request $request) {
        if (!$this->user->hasAccessRoute('admin.pinc.order')) return view('404');
        $clsMandiri = new \App\MutasiMandiri;
        $mutasi = $clsMandiri->getUnUsedPaymentCredit(true);
        $data = Datatables::collection($mutasi);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                //$row->tgl_transaksi = date('d-m-Y', strtotime($row->tgl_transaksi));
                $row->tgl_transaksi = date('Y-m-d', strtotime($row->tgl_transaksi));
                $row->credit = 'Rp ' . number_format($row->credit, 0, ',', '.');
            }
        }
        return $data->make();
    }

    public function updateOrderC(Request $request)
    {
        if (!$this->user->hasAccessRoute('admin.pinc.order')) return view('404');
        $data = \App\Plan_c_pin::find($request->id);
        $data->status = $request->status;
        if(isset($request->amountpay)){
            $data->harus_transfer = $request->amountpay;
        }
        $data->save();
        return 1;
    }

    public function manualConfirmOrderC(Request $request) {
        if (!$this->user->hasAccessRoute('admin.pinc.order')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the order!');
        $id = $request->get('id', 0);
        $payid = $request->get('mutid', 0);
        if (is_array($id)) $id = $id[0];
        if (is_array($payid)) $payid = $payid[0];
        if ($request->isMethod('post') && $id > 0 && $payid > 0) {
            $clsMandiri  = new \App\MutasiMandiri;
            $dataOrder = $this->PinC->getById($id);
            if (!empty($dataOrder)) {
                $dataMandiri = $clsMandiri->getById($payid);
                if (!empty($dataMandiri) && !$this->PinC->isMutasiUsed($payid)) {
                    if ($this->PinC->setApprove($id, $payid)) {
                        $result->status = 0;
                        $result->msg = 'Success to confirm the order!';
                    }
                } else {
                    $result->msg = 'Data not found or used';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }

    /**
     * Menampilkan halaman untuk melihat semua order yang sudah ada alamat kirimnya (ADMIN)
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function listOrderCWithAddress(Request $request)
    {
        $this->setPageHeader('List Order Pin Plan-C (With Address)');
        if (!$this->user->hasAccessRoute('admin.pinc.order.address')) return view('404');
        $orders = $this->PinC->getAllOrdersWithAddress();
        return view('admin.planc.list_order_address')->with('orders', $orders);
    }

    public function ajaxListOrderCWithAddress(Request $request) {
        if (!$this->user->hasAccessRoute('admin.pinc.order.address')) return view('404');
        $orders = $this->PinC->getAllOrdersWithAddress();
        $data = Datatables::collection($orders);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                //$row->tgl_order = date('d-m-Y', strtotime($row->tgl_order));
                $row->tgl_order = date('Y-m-d', strtotime($row->tgl_order));
                $row->x_jmlpin = number_format($row->x_jmlpin, 0, ',', '.');
                $row->nilai_transfer = 'Rp ' . number_format($row->nilai_transfer, 0, ',', '.') .',-';
                $row->nama_penerima = ucwords($row->nama_penerima);
                $row->alamat_lengkap = htmlentities($row->alamat_lengkap);
            }
        }

        return $data->make();
    }

    /**
     * Menampilkan halaman untuk melihat semua order yang sudah ada alamat kirimnya (ADMIN)
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function listPlancWD(Request $request)
    {
        $this->setPageHeader('List Withdrawal Bonus Plan-C');
        if (!$this->user->hasAccessRoute('admin.planc.wd')) return view('404');
        return view('admin.planc.list_wd')->with('status', 1);
    }

    public function ajaxListPlancWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        $status = $request->get('status', 0);
        if ($status == 1) {
            $status = 0; 
        } elseif ($status == 0) {
            $status = 1;
        }
        $wd = $clsWD->getAllListWD($status);
        $data = Datatables::collection($wd);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                //$row->tgl_wd = date('d-m-Y H:i', strtotime($row->tgl_wd));
                $row->tgl_wd = date('Y-m-d H:i', strtotime($row->tgl_wd));
                $row->jml_bonus = 'Rp ' . number_format($row->jml_bonus, 0, ',', '.') .',-';
                $row->jml_pot_admin = 'Rp ' . number_format($row->jml_pot_admin, 0, ',', '.') .',-';
                $row->jml_wd = 'Rp ' . number_format($row->jml_wd, 0, ',', '.') .',-';
                $row->bank_account = (empty($row->bank_account)) ? '-' : $row->bank_account;
            }
        }

        return $data->make();
    }

    //  confirm plan-c wd
    public function confirmWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the withdrawal!');
        $id = intval($request->get('id', 0));
        if ($request->isMethod('post') && $id > 0) {
            $clsWD  = new \App\Plan_c_wd;
            $dataWd = $clsWD->getUnconfirmedById($id);
            if (!empty($dataWd)) {
                if ($clsWD->setConfirm($id)) {
                    $result->status = 0;
                    $result->msg = 'Success to confirm the withdrawal!';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }

    //  confirm plan-c wd
    public function confirmCheckedWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the selected withdrawal!');
        $ids = $request->get('id');
        if ($request->isMethod('post') && count($ids) > 0) {
            $clsWD  = new \App\Plan_c_wd;
            if ($clsWD->setMultiConfirm($ids)) {
                $result->status = 0;
                $result->msg = 'Success to confirm the withdrawal!';
            }
        }
        return json_encode($result);
    }

    //  reject plan-c wd
    public function rejectWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to reject the withdrawal!');
        $id = intval($request->get('id', 0));
        $note = $request->get('note', '');
        if ($request->isMethod('post') && $id > 0 && !empty($note)) {
            $clsWD  = new \App\Plan_c_wd;
            $dataWd = $clsWD->getUnconfirmedById($id, [0]);
            if (!empty($dataWd)) {
                if ($clsWD->setReject($id, $note)) {
                    $result->status = 0;
                    $result->msg = 'Success to reject the withdrawal!';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }

    public function downloadListWdExcel($status)
    {
        if (!$this->user->hasAccessRoute('admin.planc.wd')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        if ($status == 1) {
            $status = 0;
        } elseif ($status == 0) {
            $status = 1;
        }
        $dbresult = $clsWD->getAllListWD($status)->toArray();
        $data = array();
        $data[] = ['Tanggal','No. Rek Mandiri','NuLife ID','Nama','Plan-C Code','Jumlah WD','Bonus','Jumlah Bonus','Potongan Admin'];
        foreach ($dbresult as $result) {
            $data[] = array_slice((array)$result,0,-2);
        }
        return Excel::create('nulife_wd_list', function($excel) use ($data) {
            $excel->sheet('WD', function($sheet) use ($data)
            {
                $sheet->setColumnFormat(array(
                    'A' => 'dd-mm-yyyy hh:mm:ss',
                    'F' => '#,##0',
                    'H' => '#,##0',
                    'I' => '#,##0',
                ));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->freezeFirstRow();
                $sheet->setAutoFilter();

                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }

    /**
     * Mengenerate file Excel untuk Payroll di list WD Admin
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     *
     * Agung.
     */
    
    public function downloadListWdPayrollExcel()
    {
        if (!$this->user->hasAccessRoute('admin.planc.wd')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        $dbresult = $clsWD->getListWDPayroll()->toArray();
        $data = array();
        $data[] = ['REKENING','PLUS','NOMINAL','CD','NO','NAMA','KETERANGAN','REKENING PERUSAHAAN'];
        $i = 1;
        foreach ($dbresult as $result) {
            $data[] = [$result->bank_account,$result->plus,$result->jml_wd,$result->cd,$i,$result->nama,$result->keterangan,$result->rekening_perusahaan];
            $i++;
        }

        return Excel::create('Payroll', function($excel) use ($data) {
            $excel->sheet('GAJI', function($sheet) use ($data)
            {
                $sheet->setColumnFormat(array(
                    'C' => '#,##0',
                ));
                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }

    public function downloadListClaimB($type = 'B', $status = 1)
    {
        if (!$this->user->hasAccessRoute('admin.inventory.claimb')) return view('404');
        $clsWD = new \App\ProductClaim;
        if ($status == 1) {
            $type = 'B';
        } elseif ($type == 'B') {
            $status = 1;
        }
        $dbresult = $clsWD->getProductClaimListB($type,$status)->toArray();
        $data = array();
        $data[] = ['Date','Upgrade Code','User ID','Name','Address','City'];
        foreach ($dbresult as $result) {
            $data[] = array_slice((array)$result,0);
        }
        return Excel::create('nulife_inventory_claimb', function($excel) use ($data) {
            $excel->sheet('CLAIMB', function($sheet) use ($data)
            {
                $sheet->setColumnFormat(array(
                    'A' => 'dd-mm-yyyy hh:mm:ss',
                ));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->freezeFirstRow();
                $sheet->setAutoFilter();

                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }

    public function downloadListClaimC($type = 'C', $status = 1)
    {
        if (!$this->user->hasAccessRoute('admin.planc.claimc')) return view('404');
        $clsWD = new \App\ProductClaim;
        if ($status == 1) {
            $type = 'C';
        } elseif ($type == 'C') {
            $status = 1;
        }
        $dbresult = $clsWD->getProductClaimListC($type,$status)->toArray();
        $data = array();
        $data[] = ['Date','Upgrade Code','User ID','Name','Address','City'];
        foreach ($dbresult as $result) {
            $data[] = array_slice((array)$result,0);
        }
        return Excel::create('nulife_planc_claimc', function($excel) use ($data) {
            $excel->sheet('CLAIMC', function($sheet) use ($data)
            {
                $sheet->setColumnFormat(array(
                    'A' => 'dd-mm-yyyy hh:mm:ss',
                ));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->freezeFirstRow();
                $sheet->setAutoFilter();

                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }

    public function reportPlancWD() {
        $this->setPageHeader('Report Bonus and Withdrawal Bonus Plan-C');
        if (!$this->user->hasAccessRoute('admin.planc.wd.report')) return view('404');
        return view('admin.planc.report_bonus');
    }

    public function ajaxReportPlancWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd.report')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        $wd = $clsWD->getSummaryBonusByMember();
        $data = Datatables::collection($wd);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->jml_pending = 'Rp ' . number_format($row->jml_pending, 0, ',', '.') .',-';
                $row->jml_transfer = 'Rp ' . number_format($row->jml_transfer, 0, ',', '.') .',-';
                $row->total_bonus = 'Rp ' . number_format($row->total_bonus, 0, ',', '.') .',-';
            }
        }

        return $data->make();
    }

    public function reportPlancJoin() {
        $this->setPageHeader('Report Join Plan-C');
        if (!$this->user->hasAccessRoute('admin.planc.join.report')) return view('404');
        $join = new \App\Plan_c;
        $jsonData = $join->getDailyPlanC(30);
        $tableData = json_decode($jsonData);

//        dd($jsonData);

        $dt = Carbon::today();
        $ds = Carbon::create(2017,04,01);
        $diff = $dt->diffInDays($ds);

        return view('admin.planc.report_join')
            ->with('jsonData', $jsonData)
            ->with('tableData', $tableData)
            ->with('maxrange', $diff);
    }

    public function ajaxReportPlancJoin($days) {
        if (!$this->user->hasAccessRoute('admin.planc.join.report')) return view('404');
        $join = new \App\Plan_c;
        if(empty($days) || $days < 3) {
            $days = 30;
        }
        return $join->getDailyPlanC($days);
    }

    /**
     * Settingan Plan A
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function settingPlanA(Request $request)
    {
        $planA = new \App\Plan_a_setting;
        $this->setPageHeader('Setting Plan-A');
        if (!$this->user->isAdminAll()) return view('404');
        $setting = $planA->getSetting();
        if ($request->isMethod('post')) {
            $id = $request->get('id');
            $values = array('max_account'           => $request->get('max_account', 0),
                            'min_upgrade_b'         => $request->get('min_upgrade_b', 0),
                            'bonus_sponsor'         => $request->get('bonus_sponsor', 0),
                            'cost_reach_upgrade_b'  => $request->get('cost_reach_upgrade_b', 0),
                            'cost_unreach_upgrade_b'=> $request->get('cost_unreach_upgrade_b', 0),
                            'bonus_pairing'         => $request->get('bonus_pairing', 0),
                            'max_pairing_day'       => $request->get('max_pairing_day', 0),
                            'flush_out_pairing'     => $request->get('flush_out_pairing', 0),
                            'bonus_split_nupoint'   => $request->get('bonus_split_nupoint', 0),
                            'daily_placement_limit' => $request->get('daily_placement_limit', 0));
            if ($planA->updateSetting($id, $values)) {
                $pesan = $this->setPesanFlash('success', 'Plan-A Setting has been successfully saved.');
                return redirect()->route('admin.plana.setting')->with($pesan);
            } else {
                $pesan = $this->setPesanFlash('error', 'Failed to save Plan-A Setting.');
                return redirect()->route('admin.plana.setting')->with($pesan)->withInput();
            }
        }
        return view('admin.plana.setting')->with('data', $setting);
    }

    /**
     * Settingan Plan B
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function settingPlanB(Request $request)
    {
        $planB = new \App\Plan_b_setting;
        $this->setPageHeader('Setting Plan-B');
        if (!$this->user->isAdminAll()) return view('404');
        $setting = $planB->getSetting();
        if ($request->isMethod('post')) {
            $id = $request->get('id');
            $values = array('bonus_sponsor'     => $request->get('bonus_sponsor', 0),
							'bonus_up_member_b'     => $request->get('bonus_sponsor', 0),
                            'require_planb'         => intval($request->get('require_planb', '0')),
                            'bonus_split_nupoint'   => $request->get('bonus_split_nupoint', 0),
                            'product_id'            => $request->get('sel_product', 0),
							 'bonus_pairing'            => $request->get('bonus_pairing', 0),
                            'subsidi_tarif_kirim'   => $request->get('subsidi_tarif_kirim', 0));
            if ($planB->updateSetting($id, $values)) {
                $pesan = $this->setPesanFlash('success', 'Plan-B Setting has been successfully saved.');
                return redirect()->route('admin.planb.setting')->with($pesan);
            } else {
                $pesan = $this->setPesanFlash('error', 'Failed to save Plan-B Setting.');
                return redirect()->route('admin.planb.setting')->with($pesan)->withInput();
            }
        }
        $products = Inventory::all();

        return view('admin.planb.newsetting')
            ->with('products', $products)
            ->with('data', $setting);
    }

    /**
     * Settingan Plan C
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function settingPlanC(Request $request)
    {
        $planC = new \App\Plan_c_setting;
        $this->setPageHeader('Setting Plan-C');
        if (!$this->user->isAdminAll()) return view('404');
        $setting = $planC->getSetting();
        if ($request->isMethod('post')) {
            $id = $request->get('id');
            $values = array('bonus_fly'         => $request->get('bonus_fly', 0),
                            'max_c_account'     => $request->get('max_c_account', 0),
                            'cost_pkg'          => $request->get('cost_pkg', 0),
                            //'pin_ruby'          => $request->get('pin_ruby', 0),
                            //'pin_saphire'       => $request->get('pin_saphire', 0),
                            //'pin_emerald'       => $request->get('pin_emerald', 0),
                            //'pin_diamond'       => $request->get('pin_diamond', 0),
                            //'pin_red_diamond'   => $request->get('pin_red_diamond', 0),
                            //'pin_blue_diamond'  => $request->get('pin_blue_diamond', 0),
                            //'pin_white_diamond' => $request->get('pin_white_diamond', 0),
                            //'pin_black_diamond' => $request->get('pin_black_diamond', 0),
                            'multiple_queue'    => $request->get('multiple_queue', 0),
                            'product_id'        => $request->get('sel_product', 0)
                        );

            if ($planC->updateSetting($id, $values)) {
                $pesan = $this->setPesanFlash('success', 'Plan-C Setting has been successfully saved.');
                return redirect()->route('admin.planc.setting')->with($pesan);
            } else {
                $pesan = $this->setPesanFlash('error', 'Failed to save Plan-C Setting.');
                return redirect()->route('admin.planc.setting')->with($pesan)->withInput();
            }
        }
        $products = Inventory::all();

        return view('admin.planc.setting')
            ->with('products', $products)
            ->with('data', $setting);
    }

    /**
     * Settingan Partner
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function settingPartner(Request $request)
    {
        $Partner = new \App\Partner_setting;
        $this->setPageHeader('Setting Partner');
        if (!$this->user->isAdminAll()) return view('404');
        $setting = $Partner->getSetting();
        if ($request->isMethod('post')) {
            $id = $request->get('id');
            $values = array(
                'min_stockist_order'        => $request->get('min_stockist_order', 0),
                'min_masterstockist_order'  => $request->get('min_masterstockist_order', 0),
                'show_stockist_address'         => intval($request->get('show_stockist_address', '0')),
                'show_stockist_phone'         => intval($request->get('show_stockist_phone', '0'))
            );

            if ($Partner->updateSetting($id, $values)) {
                $pesan = $this->setPesanFlash('success', 'Partner Setting has been successfully saved.');
                return redirect()->route('admin.partner.setting')->with($pesan);
            } else {
                $pesan = $this->setPesanFlash('error', 'Failed to save Partner Setting.');
                return redirect()->route('admin.partner.setting')->with($pesan)->withInput();
            }
        }

        return view('admin.partner.setting')
            ->with('data', $setting);
    }

    /**
     * Settingan PIN
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function settingPin(Request $request)
    {
        $PIN = new \App\Pin_setting;
        $this->setPageHeader('Setting PIN-A');
        if (!$this->user->isAdminAll()) return view('404');
        $setting = $PIN->getSetting();
        if ($request->isMethod('post')) {
            $id = $request->get('id');
            $values = array(
                'pin_type_name'                 => $request->get('pin_type_name', 0),
                'business_rights_amount'        => $request->get('business_rights_amount', 0),
                'pin_type_price'                => intval($request->get('pin_type_price', '0')),
                'pin_type_stockis_price'        => intval($request->get('pin_type_stockis_price', '0')),
                'pin_type_masterstockis_price'  => intval($request->get('pin_type_masterstockis_price', '0'))
            );

            if ($PIN->updateSetting($id, $values)) {
                $pesan = $this->setPesanFlash('success', 'PIN Setting has been successfully saved.');
                return redirect()->route('admin.pin.setting')->with($pesan);
            } else {
                $pesan = $this->setPesanFlash('error', 'Failed to save Partner Setting.');
                return redirect()->route('admin.pin.setting')->with($pesan)->withInput();
            }
        }

        return view('admin.pin.setting')
            ->with('data', $setting);
    }
    public function settingPinb(Request $request)
    {
        $PIN = new \App\Pin_settingb;
        $this->setPageHeader('Setting PIN - B');
        if (!$this->user->isAdminAll()) return view('404');
        $setting = $PIN->getSetting();
        if ($request->isMethod('post')) {
            $id = $request->get('id');
            $values = array(
                'pin_type_name'                 => $request->get('pin_type_name', 0),
                'business_rights_amount'        => $request->get('business_rights_amount', 0),
                'pin_type_price'                => intval($request->get('pin_type_price', '0')),
                'pin_type_stockis_price'        => intval($request->get('pin_type_stockis_price', '0')),
                'pin_type_masterstockis_price'  => intval($request->get('pin_type_masterstockis_price', '0'))
            );

            if ($PIN->updateSetting($id, $values)) {
                $pesan = $this->setPesanFlash('success', 'PIN Setting has been successfully saved.');
                return redirect()->route('admin.pinb.setting')->with($pesan);
            } else {
                $pesan = $this->setPesanFlash('error', 'Failed to save Partner Setting.');
                return redirect()->route('admin.pinb.setting')->with($pesan)->withInput();
            }
        }

        return view('admin.pinb.setting')
            ->with('data', $setting);
    }

    /**
     * Menampilkan halaman untuk melihat semua data upgrade plan-B yang sudah transfer (ADMIN)
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function listPlanUpgradeB(Request $request)
    {
        $this->setPageHeader('Upgrade Plan-B', 'List Request Upgrade to Plan-B');
        if (!$this->user->hasAccessRoute('admin.plan.upgrade')) return view('404');
        return view('admin.plana.list-request-upgrade-b');
    }

    public function ajaxListPlanUpgradeB(Request $request) {
        if (!$this->user->hasAccessRoute('admin.plan.upgrade')) return view('404');
        $clsUpgradeB = new \App\UpgradePlanB;
        $upB = $clsUpgradeB->getAllUploadedTransfer();
        if (!empty($upB)) {
            foreach ($upB as $row) {
                $row->tanggal = date('Y-m-d H:i', strtotime($row->created_at));
                $row->total_price = 'Rp ' . number_format($row->total_price, 0, ',', '.') .',-';
                $row->member = $row->userid . '{br}' . $row->name;
                $row->bank = $row->bank_name . '{br}' . $row->bank_account . '{br}' . $row->bank_account_name;
                //$row->foot = $row->foot_left . ' : ' . $row->foot_right;
            }
        }
        $data = Datatables::collection($upB);

        return $data->make();
    }

    public function confirmPlanUpgradeB(Request $request) {
        if (!$this->user->hasAccessRoute('admin.plan.upgrade')) return view('404');
        $act = intval($request->get('action', 0));
        $txtMsg = ($act == 1) ? 'confirm' : 'reject';
        $result = (object) array('status' => -1, 'msg' => 'Failed to ' . $txtMsg . ' the transfer!');
        $id = intval($request->get('id', 0));
        //$note = $request->get('note', '');
        //if ($request->isMethod('post') && $id > 0 && !empty($note)) {
        if ($request->isMethod('post') && $id > 0) {
            $clsUpgradeB  = new \App\UpgradePlanB;
            $dataUP = $clsUpgradeB->getDataWithUser($id);
            if (!empty($dataUP->data) && !empty($dataUP->user)) {
                if ($dataUP->user->confirmUpgrade($this->user, $dataUP->data, $act)) {
                    $result->status = 0;
                    $result->msg = 'Success to ' . $txtMsg . ' the transfer!';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }

    /**
     * Menampilkan halaman untuk melihat semua data bank perusahaan (ADMIN)
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function listCompanyBank(Request $request){
        $this->setPageHeader("List of Companie's Banks");
        if (!$this->user->hasAccessRoute('admin.company.bank')) return view('404');
        return view('admin.company.list_bank');
    }

    public function ajaxListCompanyBank(Request $request) {
        if (!$this->user->hasAccessRoute('admin.company.bank')) return view('404');
        $clsBank = new \App\BankCompany;
        $rows = $clsBank->getBanks();
        $data = Datatables::collection($rows);
        return $data->make();
    }

    public function addCompanyBank(Request $request) {
        function getBankNameFromList($list, $code) {
            if (empty($code)) return '';
            $name = '';
            foreach ($list as $row) {
                if ($row['code'] == $code) {
                    $name = $row['name'];
                    break;
                }
            }
            return $name;
        }
        if (!$this->user->hasAccessRoute('admin.company.bank')) return view('404');
        $listBank = \App\AppTools::getBanks();
        if ($request->isMethod('post')) {
            $values = array(
                'bank_code'         => $request->get('bank_id', ''),
                'bank_name'         => getBankNameFromList($listBank, $request->get('bank_id', '')),
                'bank_account'      => $request->get('bank_account', ''),
                'bank_account_name' => $request->get('bank_account_name', ''),
            );
            $clsBank = new \App\BankCompany;
            if(!$clsBank->createBank($values)) {
                $pesan = $this->setPesanFlash('error', 'Failed to create new bank account.');
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan = $this->setPesanFlash('success', 'Create new bank account was successfully.');
            return redirect()->route('admin.company.bank')->with($pesan)->withInput();
        }
        return view('admin.company.add_bank')->with('listBank', $listBank);
    }
    
    public function updateCompanyBank(Request $request){
        if (!$this->user->hasAccessRoute('admin.company.bank.update')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to change!');
        $id = intval($request->get('id'));
        $is_active = intval($request->get('is_active'));
        $update_is_active = ($is_active == 1) ? 0 : 1;
        if ($request->isMethod('post') && $id > 0) {
            $clsBank = new \App\BankCompany;
            $datanya = $clsBank->getActiveBanksID($id);
            if (!empty($datanya)) {
                $dataSet = array('is_active' => $update_is_active, 'updated_at' => date('Y-m-d H:i:s'));
                DB::table('tb_bank_company')->where('id', '=', $id)->update($dataSet);
                $result->status = 0;
                $result->msg = 'Success change status company bank!';
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }
    
    public function getEditCompanyBank($id){
        if (!$this->user->hasAccessRoute('admin.company.bank.edit')) return view('404');
        $clsBank = new \App\BankCompany;
        $getBank = $clsBank->getActiveBanksID($id);
        $listBank = \App\AppTools::getBanks();
        return view('admin.company.edit-bank')
                    ->with('data', $getBank)
                    ->with('listBank', $listBank);
    }
    
    public function postEditCompanyBank(Request $request){
        if (!$this->user->hasAccessRoute('admin.company.bank.edit.post')) return view('404');
        function getBankNameFromList1($list, $code) {
            if (empty($code)) return '';
            $name = '';
            foreach ($list as $row) {
                if ($row['code'] == $code) {
                    $name = $row['name'];
                    break;
                }
            }
            return $name;
        }
        $id = $request->get('id');
        $listBank = \App\AppTools::getBanks();
        $values = array(
            'bank_code'         => $request->get('bank_id', ''),
            'bank_name'         => getBankNameFromList1($listBank, $request->get('bank_id', '')),
            'bank_account'      => $request->get('bank_account', ''),
            'bank_account_name' => $request->get('bank_account_name', ''),
        );
        DB::table('tb_bank_company')->where('id', '=', $id)->update($values);
        $pesan = $this->setPesanFlash('success', 'Edit company bank account was successfully.');
        return redirect()->route('admin.company.bank')->with($pesan)->withInput();
    }

    public function rewardSetting() {
        $this->setPageHeader('Setting Reward');
        if (!$this->user->isAdminAll()) return view('404');
        return view('admin.reward.list');
    }

    public function ajaxRewardSetting(Request $request) {
        if (!$this->user->isAdminAll()) return view('404');
        $clsReward = new \App\RewardSetting;
        $reward = $clsReward->getListReward();
        $data = Datatables::collection($reward);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->target = number_format($row->target, 0, ',', '.');
                $row->target_2 = number_format($row->target_2, 0, ',', '.');
                $row->reward_by_value = 'Rp ' . number_format($row->reward_by_value, 0, ',', '.') .',-';
            }
        }
        return $data->make();
    }

    public function addRewardSetting(Request $request) {
        if (!$this->user->isAdminAll()) return view('404');
        $this->setPageHeader('Setting Reward : Add');
        if ($request->isMethod('post')) {
            $clsReward = new \App\RewardSetting;
            $values = array(
                'plan'              => $request->get('plan', 'A'),
                'target'            => intval($request->get('target', 0)),
                'target_2'            => intval($request->get('target_2', 0)),
                'reward_by_value'   => intval($request->get('reward_by_value', 0)),
                'reward_by_name'    => $request->get('reward_by_name', ''),
                'reward_by'         => $request->get('reward_by', 1),
            );
            if(!$clsReward->createReward($values)) {
                $pesan = $this->setPesanFlash('error', 'Failed to create new Reward Setting.');
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan = $this->setPesanFlash('success', 'Create new Reward Setting was successfully.');
            return redirect()->route('admin.reward.setting')->with($pesan);
        }
        return view('admin.reward.add');
    }

    public function editRewardSetting(Request $request, $id) {
        if (!$this->user->isAdminAll()) return view('404');
        $clsReward = new \App\RewardSetting;
        $this->setPageHeader('Setting Reward : Edit');
        if (empty($data = $clsReward->getReward($id))) {
            $pesan = $this->setPesanFlash('error', 'Data not found.');
            return redirect()->route('admin.reward.setting')->with($pesan);
        }
        if ($request->isMethod('post')) {
            $values = array(
                'plan'              => $request->get('plan', 'A'),
                'target'            => intval($request->get('target', 0)),
                'target_2'            => intval($request->get('target_2', 0)),
                'reward_by_value'   => intval($request->get('reward_by_value', 0)),
                'reward_by_name'    => $request->get('reward_by_name', ''),
                'reward_by'         => $request->get('reward_by', 1),
            );
            if(!$data->updateReward($values)) {
                $pesan = $this->setPesanFlash('error', 'Failed to update Reward Setting.');
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan = $this->setPesanFlash('success', 'Update Reward Setting was successfully.');
            return redirect()->route('admin.reward.setting')->with($pesan);
        }
        return view('admin.reward.edit')->with('data_id', $id)->with('data', $data);
    }

    public function listClaimReward() {
        $this->setPageHeader('Claim Bonus Reward');
        if (!$this->user->hasAccessRoute('admin.plan.reward')) return view('404');
        return view('admin.reward.claim');
    }

    public function ajaxListClaimReward(Request $request) {
        if (!$this->user->hasAccessRoute('admin.plan.reward')) return view('404');
        $clsReward = new \App\Bonus_reward;
        $rewards = $clsReward->getUnConfirmedRewards();
        if (!$rewards->isEmpty()) {
            foreach ($rewards as $row) {
                if ($row->claim_as == 1 && $row->reward_value > 0) {
                    $row->reward_chosen = 'Rp ' . number_format($row->reward_value, 0, ',', '.') .',-';
                }
            }
        }
        $data = Datatables::collection($rewards);

        return $data->make();
    }

    public function confirmClaimReward(Request $request) {
        if (!$this->user->hasAccessRoute('admin.plan.reward')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the claim reward!');
        $id = intval($request->get('id', 0));
        if ($request->isMethod('post') && $id > 0) {
            $clsReward  = new \App\Bonus_reward;
            $dataReward = $clsReward->getReward($id);
            if (!empty($dataReward)) {
                if ($dataReward->confirmReward()) {
                    $result->status = 0;
                    $result->msg = 'Success to confirm the claim reward.';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }
    
    public function getListNucashWD(){
        $this->setPageHeader('List Withdrawal Plan A/B');
        if (!$this->user->hasAccessRoute('admin.nucash.wd.list')) return view('404');
        return view('admin.nucash.list');
    }
    
    public function getAjaxListNucashWD(){
        if (!$this->user->hasAccessRoute('admin.nucash.wd.list')) return view('404');
        $wdAll  = $this->user->getAlMemberlWDNucash();
        $data = Datatables::collection($wdAll);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->tgl_wd = date('Y-m-d', strtotime($row->tgl_wd));
                $row->jml_wd = number_format($row->jml_wd, 0, ',', '.') .',-';
                $row->adm_fee = number_format($row->adm_fee, 0, ',', '.') .',-';
                $row->total_wd = number_format($row->total_wd, 0, ',', '.') .',-';
            }
        }
        return $data->make();
    }
    
    public function confirmNucashWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.nucash.wd.list')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the withdrawal!');
        $id = intval($request->get('id'));
        if ($request->isMethod('post') && $id > 0) {
            $dataWd  = $this->user->getNotTransferId($id);
            if (!empty($dataWd)) {
                if ($this->user->setTransferSuccess($id)) {
                    $result->status = 0;
                    $result->msg = 'Success to transfer the withdrawal!';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }
    
    public function getListActivationPIN(){
        $this->setPageHeader('Summary Activation PIN');
        if (!$this->user->hasAccessRoute('admin.pin.list')) return view('404');
        return view('admin.pin.list');
    }
    
    public function getAjaxActivationPIN(){
        if (!$this->user->hasAccessRoute('admin.pin.list')) return view('404');
        $pin_member = new \App\PinMember;
        $pinAll = $pin_member->getAllUsedPIN();
        $data = Datatables::collection($pinAll);
        if (!empty($data->collection)) {
            $no = 0;
            foreach ($data->collection as $row) {
                $no++;
                $row->no = $no;
                $row->amount = number_format($row->amount, 0, ',', '.') .',-';
            }
        }
        return $data->make();
    }
    
	
	
	
    public function getListActivationBPIN(){
        $this->setPageHeader('Summary Activation B-PIN');
        if (!$this->user->hasAccessRoute('admin.pinb.list')) return view('404');
        return view('admin.pinb.list');
    }
    
    public function getAjaxActivationBPIN(){
        if (!$this->user->hasAccessRoute('admin.pinb.list')) return view('404');
        $pin_member = new \App\PinMemberB;
        $pinAll = $pin_member->getAllUsedPIN();
        $data = Datatables::collection($pinAll);
        if (!empty($data->collection)) {
            $no = 0;
            foreach ($data->collection as $row) {
                $no++;
                $row->no = $no;
                $row->amount = number_format($row->amount, 0, ',', '.') .',-';
            }
        }
        return $data->make();
    }
    
	
    public function getListAllMembers(){
        $this->setPageHeader('All Member ');
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        return view('admin.member.list');
    }
    
    public function getAjaxAllMembers(){
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        ini_set('memory_limit', '1536M');
        $allMember  = $this->user->getAllMember();
        $data = Datatables::collection($allMember);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->id_join_type = $row->id_join_type;
            }
        }
        return $data->make();
    }

    public function getListPlanBMembers(){
        $this->setPageHeader('Plan B Member ');
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        return view('admin.member.list');
    }

    public function getAjaxPlanBMembers(){
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        ini_set('memory_limit', '1536M');
        $planBMember  = $this->user->getPlanBMember();
        $data = Datatables::collection($planBMember);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->id_join_type = $row->id_join_type;
            }
        }
        return $data->make();
    }

    public function getViewMember($id){
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        $user = New Referal;
        $cekUsers = $user->getUserId('id', $id);
        $nama = '';
        if($cekUsers != null){
            $nama = $cekUsers->nama;
        }
        $haveData = ($cekUsers == null) ? false : true;
        $this->setPageHeader('View data member '.$nama);
        return view('admin.member.view')
                    ->with('haveData', $haveData)
                    ->with('dataLogin', $cekUsers);
    }

    /**
     * TO DO : view genealogy view @ admin area
     * menu -> link pilih 'view mode' di list all member
     */
    public function viewGenealogy()
    {
    }

    public function getChangeIsActiveMembers($id){
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        $user = New Referal;
        $cekUsers = $user->getUserId('id', $id);
        if($cekUsers == null){
            $pesan = $this->setPesanFlash('error', 'We can not find a user data');
            return redirect()->route('admin.member.list')->with($pesan);
        }
        $set = 1;
        if($cekUsers->is_active == 1){
            $set = 0;
        }
        $dataSet = array('is_active' => $set, 'updated_at' => date('Y-m-d H:i:s'));
        DB::table('users')->where('id', '=', $cekUsers->id)->update($dataSet);
        $pesan = $this->setPesanFlash('success', $cekUsers->userid.' '.$cekUsers->nama.' had inactived (can\'t login)');
        if($set == 1){
            $pesan = $this->setPesanFlash('success', $cekUsers->userid.' '.$cekUsers->nama.' had actived');
        }
        return redirect()->route('admin.view.member', ['id' => $cekUsers->id])->with($pesan);
    }
    
    public function getExcelNucashWD(){
        if (!$this->user->hasAccessRoute('admin.nucash.wd.list')) return view('404');
        $wdAll  = $this->user->getAlMemberlWDNucash();
        $dbresult = $wdAll->toArray();
        $data = array();
        $data[] = ['No', 'Name','User ID','Bank','Account','Date','Amount','Fee','To Be Transfer', 'Transfer', 'Confirm'];
        $i = 0;
        foreach ($dbresult as $result) {
            $i++;
            $tglWD = date('d M Y H:i', strtotime($result->tgl_wd));
            $amount = number_format($result->jml_wd, 0, ',', '.') .',-';
            $fee = number_format($result->adm_fee, 0, ',', '.') .',-';
            $toTransfer = number_format($result->total_wd, 0, ',', '.') .',-';
            $is_transfer = 'no';
            if($result->is_transfer == 1){
                $is_transfer = 'yes';
            }
            $is_confirm = 'no';
            if($result->is_confirm == 1){
                $is_confirm = 'yes';
            }
            $data[] = [
                $i, $result->name, $result->userid,  $result->bank_name, $result->account_no,  $tglWD, $amount, $fee, $toTransfer, $is_transfer, $is_confirm,
            ];
        }
        return Excel::create('Nucash_WD', function($excel) use ($data) {
            $excel->sheet('NuCash_WD', function($sheet) use ($data){
                $sheet->setColumnFormat(array('C' => '#,##0'));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
    
    public function getExcelNucashPayrollWD(){
        if (!$this->user->hasAccessRoute('admin.nucash.wd.list')) return view('404');
        $wdAll  = $this->user->getAlMemberlWDNucashPayroll();
        $dbresult = $wdAll->toArray();
        $data = array();
        $data[] = ['REKENING','PLUS','NOMINAL','CD','NO','NAMA','KETERANGAN','REKENING PERUSAHAAN'];
        $i = 0;
        $plus = '+';
        $C = 'A/B';
        $rekPerusahaan = '1400000237009';
        foreach ($dbresult as $result) {
            $i++;
            $tglWD = date('d M Y H:i', strtotime($result->tgl_wd));
            $amount = number_format($result->jml_wd, 0, ',', '.') .',-';
            $fee = number_format($result->adm_fee, 0, ',', '.') .',-';
            $toTransfer = number_format($result->total_wd, 0, ',', '.') .',-';
            $is_transfer = 'no';
            if($result->is_transfer == 1){
                $is_transfer = 'yes';
            }
            $is_confirm = 'no';
            if($result->is_confirm == 1){
                $is_confirm = 'yes';
            }
            $data[] = [
                $result->account_no, $plus, $toTransfer, $C, $i, $result->name, 'NUC'.$result->kd_wd , $rekPerusahaan
            ];
        }
        return Excel::create('PAYROLL', function($excel) use ($data) {
            $excel->sheet('GAJI', function($sheet) use ($data){
                $sheet->setColumnFormat(array('C' => '#,##0'));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
    
    public function getEditMemberByType($type, $id){
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        if($type != 'name' && $type != 'email'){
            $pesan = $this->setPesanFlash('error', 'Data not found');
            return redirect()->route('admin.view.member', ['id' => $id])->with($pesan);
        }
        $user = New Referal;
        $cekUsers = $user->getUserId('id', $id);
        if($cekUsers != null){
            $nama = $cekUsers->nama;
        }
        $haveData = ($cekUsers == null) ? false : true;
        $this->setPageHeader('View data member '.$nama);
        return view('admin.member.edit')
                    ->with('haveData', $haveData)
                    ->with('type', $type)
                    ->with('dataUser', $cekUsers);
    }
    
    public function postEditMemberByType(Request $request){
        if (!$this->user->hasAccessRoute('admin.member.list')) return view('404');
        $type = $request->type;
        $id = $request->id;
        if($type != 'name' && $type != 'email'){
            $pesan = $this->setPesanFlash('error', 'Data type not found');
            return redirect()->route('admin.view.member', ['id' => $id])->with($pesan);
        }
        $user = New Referal;
        $cekUsers = $user->getUserId('id', $id);
        if($cekUsers == null){
            $pesan = $this->setPesanFlash('error', 'Data not found');
            return redirect()->route('dashboard')->with($pesan);
        }
        $statik = New Statik;
        if($type == 'name'){
            $name = $request->name;
            if($name == null){
                $pesan = $this->setPesanFlash('error', 'Email con not be empty');
                return redirect()->route('admin.edit.member', ['type' => $type, 'id' => $id])->with($pesan);
            }
            $dataValidation = (object) array('fullname' => $name);
            $cekData = $statik->getValidationFullname($dataValidation);
            if($cekData->fails()){
                $pesannya = $cekData->errors()->first();
                $pesan = $this->setPesanFlash('error', $pesannya);
                return redirect()->back()->with($pesan)->withInput();
            }
            $dataUpdate = array('name' => $name, 'updated_at' => date('Y-m-d H:i:s'));
            DB::table('users')->where('id', '=', $cekUsers->id)->update($dataUpdate);
            $pesan = $this->setPesanFlash('success', 'Update Name success');
            return redirect()->route('admin.view.member', ['id' => $id])->with($pesan);
        }
        
        if($type == 'email'){
            $email = $request->email;
            if($email == null){
                $pesan = $this->setPesanFlash('error', 'Email con not be empty');
                return redirect()->route('admin.edit.member', ['type' => $type, 'id' => $id])->with($pesan);
            }
            $dataValidation = (object) array('email' => $email);
            $cekData = $statik->getValidationEmail($dataValidation);
            if($cekData->fails()){
                $pesannya = $cekData->errors()->first();
                $pesan = $this->setPesanFlash('error', $pesannya);
                return redirect()->back()->with($pesan)->withInput();
            }
            $cekEmail = $user->getAllUserIdSearch('email', $email);
            if($cekEmail != null){
                $setting = New Plan_a_setting;
                $empty = '';
                $maxAccount = $setting->maxAccount($empty);
                $cekTotalEmail = count($cekEmail);
                if($cekTotalEmail == $maxAccount){
                    $pesan = $this->setPesanFlash('error', 'Email can\'t used, it Maximum Account used');
                    return redirect()->route('admin.edit.member', ['type' => $type, 'id' => $id])->with($pesan);
                }
                $dataUpdate = array('email' => $email, 'updated_at' => date('Y-m-d H:i:s'));
                DB::table('users')->where('id', '=', $cekUsers->id)->update($dataUpdate);
                $pesan = $this->setPesanFlash('success', 'Update Email success');
                return redirect()->route('admin.view.member', ['id' => $id])->with($pesan);
            }
            $dataUpdate = array('email' => $email, 'updated_at' => date('Y-m-d H:i:s'));
            DB::table('users')->where('id', '=', $cekUsers->id)->update($dataUpdate);
            $pesan = $this->setPesanFlash('success', 'Update Email success');
            return redirect()->route('admin.view.member', ['id' => $id])->with($pesan);
        }
    }

    //  wd bonus leadership
    public function listPlancBonusLeadershipWD(Request $request)
    {
        $this->setPageHeader('List Withdrawal Ranking Bonus Plan-C');
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership')) return view('404');
        return view('admin.planc.list_wd_leadership')->with('status', 1);
    }

    public function ajaxListPlancBonusLeadershipWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        $status = $request->get('status', 0);
        if ($status == 1) {
            $status = 0; 
        } elseif ($status == 0) {
            $status = 1;
        }
        $wd = $clsWD->getAllListWdLeadership($status);
        $data = Datatables::collection($wd);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                //$row->tgl_wd = date('d-m-Y H:i', strtotime($row->tgl_wd));
                $row->tgl_wd = date('Y-m-d H:i', strtotime($row->tgl_wd));
                $row->jml_bonus = 'Rp ' . number_format($row->jml_bonus, 0, ',', '.') .',-';
                $row->jml_pot_admin = 'Rp ' . number_format($row->jml_pot_admin, 0, ',', '.') .',-';
                $row->jml_wd = 'Rp ' . number_format($row->jml_wd, 0, ',', '.') .',-';
                $row->bank_account = (empty($row->bank_account)) ? '-' : $row->bank_account;
            }
        }

        return $data->make();
    }

    public function confirmBonusLeadershipWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the withdrawal!');
        $id = intval($request->get('id', 0));
        if ($request->isMethod('post') && $id > 0) {
            $clsWD  = new \App\Plan_c_wd;
            $dataWd = $clsWD->getUnconfirmedById($id);
            if (!empty($dataWd)) {
                if ($clsWD->setConfirm($id)) {
                    $result->status = 0;
                    $result->msg = 'Success to confirm the withdrawal!';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }

    public function confirmCheckedBonusLeadershipWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm the selected withdrawal!');
        $ids = $request->get('id');
        if ($request->isMethod('post') && count($ids) > 0) {
            $clsWD  = new \App\Plan_c_wd;
            if ($clsWD->setMultiConfirm($ids)) {
                $result->status = 0;
                $result->msg = 'Success to confirm the withdrawal!';
            }
        }
        return json_encode($result);
    }

    public function rejectBonusLeadershipWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to reject the withdrawal!');
        $id = intval($request->get('id', 0));
        $note = $request->get('note', '');
        if ($request->isMethod('post') && $id > 0 && !empty($note)) {
            $clsWD  = new \App\Plan_c_wd;
            $dataWd = $clsWD->getUnconfirmedById($id, [0]);
            if (!empty($dataWd)) {
                if ($clsWD->setReject($id, $note)) {
                    $result->status = 0;
                    $result->msg = 'Success to reject the withdrawal!';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }

    public function downloadListBonusLeadershipWdExcel($status)
    {
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        if ($status == 1) {
            $status = 0;
        } elseif ($status == 0) {
            $status = 1;
        }
        $dbresult = $clsWD->getAllListWdLeadership($status)->toArray();
        $data = array();
        $data[] = ['Tanggal','No. Rek Mandiri','NuLife ID','Nama','Plan-C Code','Jumlah WD','Bonus','Jumlah Bonus','Potongan Admin'];
        foreach ($dbresult as $result) {
            $data[] = array_slice((array)$result,0,-2);
        }
        return Excel::create('nulife_wd_list', function($excel) use ($data) {
            $excel->sheet('WD', function($sheet) use ($data)
            {
                $sheet->setColumnFormat(array(
                    'A' => 'dd-mm-yyyy hh:mm:ss',
                    'F' => '#,##0',
                    'H' => '#,##0',
                    'I' => '#,##0',
                ));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->freezeFirstRow();
                $sheet->setAutoFilter();

                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }

    public function downloadListBonusLeadershipWdPayrollExcel()
    {
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        $dbresult = $clsWD->getListWdLeadershipPayroll();
        //dd($dbresult);
        $data = array();
        $data[] = ['REKENING','PLUS','NOMINAL','CD','NO','NAMA','KETERANGAN','REKENING PERUSAHAAN'];
        $i = 1;
        foreach ($dbresult as $result) {
            $data[] = [$result->bank_account,$result->plus,$result->jml_wd,$result->cd,$i,$result->nama,$result->keterangan,$result->rekening_perusahaan];
            $i++;
        }

        return Excel::create('Payroll', function($excel) use ($data) {
            $excel->sheet('GAJI', function($sheet) use ($data)
            {
                $sheet->setColumnFormat(array(
                    'C' => '#,##0',
                ));
                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }

    public function reportPlancBonusLeadershipWD() {
        $this->setPageHeader('Report Bonus and Withdrawal Ranking Bonus');
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership.report')) return view('404');
        return view('admin.planc.report_bonus_leadership');
    }

    public function ajaxReportPlancBonusLeadershipWD(Request $request) {
        if (!$this->user->hasAccessRoute('admin.planc.wd.leadership.report')) return view('404');
        $clsWD = new \App\Plan_c_wd;
        $wd = $clsWD->getSummaryLeadershipBonusByMember();
        $data = Datatables::collection($wd);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->jml_pending = 'Rp ' . number_format($row->jml_pending, 0, ',', '.') .',-';
                $row->jml_transfer = 'Rp ' . number_format($row->jml_transfer, 0, ',', '.') .',-';
                $row->total_bonus = 'Rp ' . number_format($row->total_bonus, 0, ',', '.') .',-';
            }
        }

        return $data->make();
    }
    
    public function getAjaxStructure($id){
        if (!$this->user->hasAccessRoute('admin.ajax.structure')) return view('404');
        $getData  = $this->user->getSpesificMemberByID($id);
        $getStructure      = \App\AppTools::getAllParentCodeFromCode($getData->kode, '.', '-', false);
        $data = array();
        foreach($getStructure as $row){
            $data[] = array('kode' => $row['kode']);
        }
        $listStructure      = $this->user->getStructureMemberByKode($data);
        return view('admin.member.struktur')
                    ->with('dataUser', $getData)
                    ->with('dataStruktur', $listStructure);
    }

    public function getListPartner() {
        $this->setPageHeader('Partner');
        if (!$this->user->hasAccessRoute('admin.partner.list')) return view('404');
        return view('admin.partner.list')->with('status', 0);
    }

    public function getAjaxListPartner(Request $request) {
        if (!$this->user->hasAccessRoute('admin.partner.list')) return view('404');
        $clsPartner = new \App\User;
        $type = $request->get('status', 0);
        $partner = $clsPartner->getPartners($type);
        $token = csrf_token();
        if (!$partner->isEmpty()) {
            foreach ($partner as $row) {
                $row->token = $token;
            }
        }
        $data = Datatables::collection($partner);
        
        return $data->make();
    }

    public function downgradePartner(Request $request) {
        if (!$this->user->hasAccessRoute('admin.partner.list')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to downgrade partner');
        if ($request->isMethod('post')) {
            $partner = \App\User::where('id', '=', $request->get('id'))->first();
            if (!empty($partner)) {
                if ($partner->isStockis()) {
                    $clsDowngrade = new \App\LogDowngradePartner;
                    if ($clsDowngrade->DowngradePartner($partner, $request->get('to'), $request->get('reason'))) {
                        $result->status = 0;
                        $result->msg = 'Downgrade Partner successfully';
                    }
                } else {
                    $result->msg = 'The selected data is not partner.';
                }
            }
        }
        return json_encode($result);
    }
    
    public function getListBecomePartner() {
        $this->setPageHeader('Request To Be Partner');
        if (!$this->user->hasAccessRoute('admin.partner.become')) return view('404');
        return view('admin.partner.request');
    }

    public function getAjaxListBecomePartner(Request $request) {
        if (!$this->user->hasAccessRoute('admin.partner.become')) return view('404');
        $clsPartner = new \App\StockistRequest;
        $partner = $clsPartner->getTransferedRequest();
        $data = Datatables::collection($partner);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->total_transfer = 'Rp ' . number_format($row->total_transfer, 0, ',', '.') .',-';
            }
        }

        return $data->make();
    }

    public function confirmBecomePartner(Request $request) {
        function createTransactionPin($dataStockist, $user) {
            $clsTr      = new \App\Transaction;
            $clsList    = new \App\TransactionList;
            $clsPin     = new \App\Pin;
            $clsPinMember   = new \App\PinMember;
            $clsDetail  = new \App\TransactionDetail;

            $trCode = strtoupper(uniqid());
            $trPin = array(
                'transaction_code'  => $trCode, 
                'transaction_type'  => 4, 
                'from'              => 0, 
                'to'                => $user->id, 
                'total_price'       => $dataStockist->total_harga, 
                'unique_digit'      => $dataStockist->angka_unik, 
                'status'            => 2
            );
            $trList = array(
                'transaction_code'  => $trCode,
                'pin_type_id'       => 1,
                'amount'            => $dataStockist->jml_pin
            );
            $trDetail = [];
            $pins = [];
            $pinsMember = [];
            $listCodes = [];
            for ($i = 1; $i <= $dataStockist->jml_pin; $i++) {
                $pinCode = $clsPin->getNewPinCode($listCodes);
                if ($pinCode != '') {
                    $pins[] = array('pin_code' => $pinCode, 'pin_type_id' => 1, 'is_sold' => 1);
                    $pinsMember[] = array(
                        'pin_code'          => $pinCode, 
                        'pin_type_id'       => 1, 
                        'user_id'           => $user->id, 
                        'transaction_code'  => $trCode, 
                        'is_used'           => 0
                    );
                    $trDetail[] = array('transaction_list_id' => 0, 'pin_code' => $pinCode);
                } else {
                    $i -= 1;
                }
            }
            if (count($pins) < $dataStockist->jml_pin) return false;
            try {
                $newTr      = $clsTr->create($trPin);
                $newList    = $clsList->create($trList);
                $newpin     = $clsPin->insert($pins);
                for ($i = 0; $i < $dataStockist->jml_pin; $i++) {
                    $trDetail[$i]['transaction_list_id'] = $newList->id;
                }
                $newPinMember   = $clsPinMember->insert($pinsMember);
                $newDetail  = $clsDetail->insert($trDetail);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        if (!$this->user->hasAccessRoute('admin.partner.become')) return view('404');
        $result = (object) array('status' => -1, 'msg' => 'Failed to confirm partner request!');
        $id = intval($request->get('id', 0));
        if ($request->isMethod('post') && $id > 0) {
            $clsStockist    = new \App\StockistRequest;
            $dataStockist   = $clsStockist->getUnconfirmedById($id);
            if (!empty($dataStockist)) {
                $reqUser = \App\User::find($dataStockist->user_id);
                if (!empty($reqUser)) {
                    DB::beginTransaction();
                    if (createTransactionPin($dataStockist, $reqUser) && $clsStockist->setConfirm($id)) {
                        if ($reqUser->setStockist($dataStockist->type_stockist_id)) {
                            $result->status = 0;
                            $result->msg = 'Success to confirm the partner request!';
                            DB::commit();
                        } else {
                            DB::rollback();
                        }
                    } else {
                        DB::rollback();
                    }
                } else {
                    $result->msg = 'Data not found';
                }
            } else {
                $result->msg = 'Data not found';
            }
        }
        return json_encode($result);
    }

    public function generatePin($userid,$type,$pin)
    {
        if (!$this->user->hasAccessRoute('admin.pin.generate')) return view('404');
        if($type == 0){
            $this->addpin($userid,$pin);
        }
        elseif($type == 1){
            $this->removepin($userid,$pin);
        }
    }

    public function addpin($userid,$pin)
    {
        if (!$this->user->hasAccessRoute('admin.pin.generate')) return view('404');
        $data = DB::table('users')->where('userid', $userid)->first();
        if(!$data){
            return 'USERID not found';
            exit;
        }
        $amount = $pin;
        $trans_code = strtoupper(uniqid());
        $transaction_id = DB::table('tb_transaction')->insertGetId([
            'transaction_code' => $trans_code,
            'transaction_type' => 2,
            'from' => 0,
            'to' => $data->id,
            'total_price' => $amount*350000,
            'unique_digit' => '000',
            'status' => 2,
            'created_at' => date("Y-m-d H:i:s")
        ]); 
        $transaction_list_id = DB::table('tb_transaction_list')->insertGetId([
            'transaction_code' => $trans_code,
            'pin_type_id' => 1,
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
                            echo "old_pin => userid = ".$userid.", loop = ".$x;exit;
                        }
                    }
                }
            }
            
            $new_pin = new \App\Pin;
            $new_pin->pin_code = $new_pin_code;
            $new_pin->pin_type_id = 1;
            $new_pin->is_sold = 0;
            $new_pin->save();

            $new_pin_member = new \App\PinMember;
            $new_pin_member->pin_code = $new_pin_code;
            $new_pin_member->pin_type_id = 1;
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
        return "Sukses";
    }
    
    public function removepin($userid,$pin)
    {
        if (!$this->user->hasAccessRoute('admin.pin.generate')) return view('404');
        $data = DB::table('users')->where('userid', $userid)->first();
        if(!$data){
            return 'USERID not found';
            exit;
        }
        $amount = $pin;
        for ($x=0; $x < $amount; $x++) { 
            $activepin = DB::table('tb_pin_member')->where('user_id', $data->id)->orderBy('created_at', 'ASC')->where('is_used', 0)->first();
            if(!$activepin){
                $this->error('Sorry, not enought pin to remove [removed pin : '.$x.']');
                exit;
            }
            $trans_code = $activepin->transaction_code;
            
            DB::table('tb_pin')->where('pin_code', $activepin->pin_code)->delete();
            DB::table('tb_pin_member')->where('pin_code', $activepin->pin_code)->delete();
            DB::table('tb_transaction')->where('transaction_code', $trans_code)->delete();
            DB::table('tb_transaction_confirm')->where('transaction_code', $trans_code)->delete();

            $trans_list_id = DB::table('tb_transaction_list')->where('transaction_code', $trans_code)->first();
            if(!$trans_list_id){
                continue;
            }
            else{
                $trans_list_id = $trans_list_id->id;
                DB::table('tb_transaction_list')->where('transaction_code', $trans_code)->delete();
                DB::table('tb_transaction_detail')->where('transaction_list_id', $trans_list_id)->delete();
            }
        }
        return "Sukses";
    }

    public function reportPin(){
        $this->setPageHeader('Report Pin');
        if (!$this->user->hasAccessRoute('admin.pin.report')) return view('404');
        return view('admin.pin.report');
    }

    public function ajaxReportPin(Request $request) {
        ini_set('memory_limit', '1536M');
        if (!$this->user->hasAccessRoute('admin.pin.report')) return view('404');
        $transaction = new \App\Transaction;
        $orders = $transaction->getReportPin();
        $data = Datatables::collection($orders);
        if (!empty($data->collection)) {
            $no = 0;
            foreach ($data->collection as $row) {
                $no++;
                $row->no = $no;
                $row->userid = $row->userid;
                $row->name = $row->name;
                $row->active_pin = number_format($row->active_pin);
                $row->used_pin = number_format($row->used_pin);
                $row->transfered_pin = number_format($row->transfered_pin);
            }
        }
        return $data->make();
    }
    
    public function ajaxReportPinUsedActive($id){
        $transaction = new \App\Transaction;
        $orders = $transaction->getReportPinUsedActive($id);
        return view('admin.pin.detail')->with('data', $orders);
    }
    
    public function getExcelReportPin(){
        if (!$this->user->hasAccessRoute('admin.pin.report')) return view('404');
        ini_set('memory_limit', '1536M');
        $transaction = new \App\Transaction;
        $orders = $transaction->getReportPin();
        
        $dbresult = $orders->toArray();
        $data = array();
        $data[] = ['No', 'User ID', 'Name', 'Transfered PIN', 'Active PIN', 'Used PIN'];
        $i = 0;
        foreach ($dbresult as $result) {
            $i++;
            $active_pin = number_format($result->active_pin);
            $used_pin = number_format($result->used_pin);
            $transfered_pin = number_format($result->transfered_pin);
            $data[] = [
                $i, $result->userid, $result->name,  $transfered_pin, $active_pin,  $used_pin
            ];
        }
        return Excel::create('Report_Pin_Member', function($excel) use ($data) {
            $excel->sheet('Report_Pin_Member', function($sheet) use ($data){
                $sheet->setColumnFormat(array('C' => '#,##0'));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
        
        
    }
    
    private $number  = 10000;
    public function getListMemberNotWD(){
        $this->setPageHeader('List Member Not Create WD');
        if (!$this->user->hasAccessRoute('admin.member.not.wd.list')) return view('404');
        $count = $this->user->getCountMemberPrepareNotWD();
        $number = $this->number;
        $pembagian = $count / $number;
        $bulatAtas = ceil($pembagian);
        return view('admin.member.not-wd')
                    ->with('number', $bulatAtas);
    }
    
    public function getAjaxListMemberNotWD(){
        if (!$this->user->hasAccessRoute('admin.member.not.wd.list')) return view('404');
        ini_set('memory_limit', '1536M');
        $allMember  = $this->user->getAllMemberPrepareNotWD();
        $data = Datatables::collection($allMember);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->id = $row->id;
            }
        }
        return $data->make();
    }
    
    public function getExcelMemberNotWD($no){
        if (!$this->user->hasAccessRoute('admin.member.not.wd.list')) return view('404');
        $number = $this->number;
        $awalan = $no - 1;
        if($awalan < 0){
            $awalan = 0;
        }
        $skip = $number * $awalan;
        $take = $number;
        ini_set('memory_limit', '1536M');
        $allMember  = $this->user->getAllMemberSisaNotWD($skip, $take);
        $dbresult = $allMember->toArray();
        $data = array();
        $data[] = ['No', 'Name', 'User ID', 'Total Bonus Sponsor', 'Total Bonus Pairing', 'Total Bonus Upgrade', 'Summary Old Bonus', 'Withdrawal', 'Outstanding WD', 'Balance', 'Total Bonus'];
        $i = 0;
        foreach ($dbresult as $result) {
            $i++;
            $bonus_sponsor = number_format($result->bonus_sponsor, 0, ',', '.') .',-';
            $bonus_pairing = number_format($result->bonus_pairing, 0, ',', '.') .',-';
            $bonus_upgrade_b = number_format($result->bonus_upgrade_b, 0, ',', '.') .',-';
            $old_bonus = number_format($result->old_bonus, 0, ',', '.') .',-';
            $withdrawal = number_format($result->withdrawal, 0, ',', '.') .',-';
            $outstanding_wd = number_format($result->outstanding_wd, 0, ',', '.') .',-';
            $total_bonus = $result->bonus_sponsor + $result->bonus_pairing + $result->bonus_upgrade_b + $result->old_bonus;
            $total_bonusReal = number_format($total_bonus, 0, ',', '.') .',-';
            $balance = $total_bonus - ($result->withdrawal + $result->outstanding_wd);
            $balanceReal = number_format($balance, 0, ',', '.') .',-';
            $data[] = [
                $i, $result->name, $result->userid,  $bonus_sponsor, $bonus_pairing,  $bonus_upgrade_b, $old_bonus, $withdrawal, $outstanding_wd, $balanceReal, $total_bonusReal
            ];
        }
        return Excel::create('Bonus_All_Member_PART_'.$no, function($excel) use ($data) {
            $excel->sheet('Bonus_All_Member', function($sheet) use ($data){
                $sheet->setColumnFormat(array('C' => '#,##0'));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
    
    public function getAjaxListMemberNotUserWD($id){
        if (!$this->user->hasAccessRoute('admin.member.not.wd.list')) return view('404');
        $getData = \App\User::where('id', '=', $id)->first();
        $getBonus = $getData->getSummaryBonus();
        $oldNucash = $this->user->getAllMemberSisaNotWDNucash($id);
        $bonusSponsor = 0;
        $bonusPairing = 0;
        $bonusUpgradeB = 0;
        $old_bonus = ($oldNucash->old_bonus == null) ? 0 : (int) $oldNucash->old_bonus;
        $outstanding_wd = ($oldNucash->outstanding_wd == null) ? 0 : (int) $oldNucash->outstanding_wd;
        $withdrawal = ($oldNucash->withdrawal == null) ? 0 : (int) $oldNucash->withdrawal;
        foreach($getBonus as $row){
            $bonusSponsor += $row->bonus_sponsor;
            $bonusPairing += $row->bonus_pairing;
            $bonusUpgradeB += $row->bonus_up_b;
        }
        $total_bonus = $bonusSponsor + $bonusPairing + $bonusUpgradeB + $old_bonus;
        $balance = $total_bonus - ($outstanding_wd + $withdrawal);
        if($balance < 0){
            $balance = 0;
        }
        $dataBonus = (object) array(
            'bonus_sponsor' => number_format($bonusSponsor, 0, ',', '.'),
            'bonus_pairing' => number_format($bonusPairing, 0, ',', '.'),
            'bonus_upgrade_b' => number_format($bonusUpgradeB, 0, ',', '.'),
            'old_bonus' => number_format($old_bonus, 0, ',', '.'),
            'withdrawal' => number_format($withdrawal, 0, ',', '.'),
            'outstanding_wd' => number_format($outstanding_wd, 0, ',', '.'),
            'balance' => number_format($balance, 0, ',', '.'),
            'total_bonus' => number_format($total_bonus, 0, ',', '.')
        );
        return view('admin.member.detail-bonus')
                    ->with('dataUser', $getData)
                    ->with('dataBonus', $dataBonus);//nul0008018
    }
    
    public function getAllRewardGlobal(){
        ini_set('memory_limit', '2048M');
        $allMemberA  = $this->user->getAllStructureMemberA();
        $dataArrayA = array();
        foreach($allMemberA as $rowA){
            $dataArrayA[] = (object) array('plan' => $rowA->plan, 'type_target' => $rowA->type_target, 'total_member' => $rowA->total_member);
        }
        $allMemberB  = $this->user->getAllStructureMemberB();
        $dataArray = array();
        foreach($allMemberB as $row){
            if($row->jml_kiri < 10 || $row->jml_kanan < 10){
                $type = 10;
            }
            if(($row->jml_kiri >= 10 && $row->jml_kiri < 199) && ($row->jml_kanan >= 10 && $row->jml_kanan < 199)){
                $type = 200;
            }
            if(($row->jml_kiri >= 200 && $row->jml_kiri < 399) && ($row->jml_kanan >= 200 && $row->jml_kanan < 399)){
                $type = 400;
            }
            if(($row->jml_kiri >= 400 && $row->jml_kiri < 599) && ($row->jml_kanan >= 400 && $row->jml_kanan < 599)){
                $type = 600;
            }
             if(($row->jml_kiri >= 600 && $row->jml_kiri < 799) && ($row->jml_kanan >= 600 && $row->jml_kanan < 799)){
                $type = 800;
            }
             if(($row->jml_kiri >= 800 && $row->jml_kiri < 999) && ($row->jml_kanan >= 800 && $row->jml_kanan < 999)){
                $type = 1000;
            }
            if(($row->jml_kiri >= 1000 && $row->jml_kiri < 1199) && ($row->jml_kanan >= 1000 && $row->jml_kanan < 1199)){
                $type = 1200;
            }
            if(($row->jml_kiri >= 1200 && $row->jml_kiri < 1399) && ($row->jml_kanan >= 1200 && $row->jml_kanan < 1399)){
                $type = 1400;
            }
            if(($row->jml_kiri >= 1400 && $row->jml_kiri < 1599) && ($row->jml_kanan >= 1400 && $row->jml_kanan < 1599)){
                $type = 1600;
            }
            if(($row->jml_kiri >= 1600 && $row->jml_kiri < 1799) && ($row->jml_kanan >= 1600 && $row->jml_kanan < 1799)){
                $type = 1800;
            }
            if($row->jml_kiri >= 1800 && $row->jml_kanan >= 1800){
                $type = 2000;
            }
            $dataArray[] = $type; 
        }
        $arrayTotal = array_count_values($dataArray);
        $dataValue = array();
        foreach ($arrayTotal as $rowTotal => $sum){
            $dataValue[] = (object) array('plan' => 'B', 'type_target' => $rowTotal, 'total_member' => $sum);
        }
        $return = (object) array('planA' => $dataArrayA, 'planB' => $dataValue);
        return $return;
    }
    
    public function getRewardGlobal(){
        $this->setPageHeader('Report Reward Global');
        if (!$this->user->hasAccessRoute('admin.report.reward.global')) return view('404');
        $getData = $this->getAllRewardGlobal();
        $result = array_merge( (array) $getData->planA, (array) $getData->planB );
        $dbresult = (object) array_map("unserialize", array_unique(array_map("serialize", $result)));
        return view('admin.member.reward-global')
                    ->with('data', $dbresult);
    }
    
    public function getRewardGlobalXLS(){
        if (!$this->user->hasAccessRoute('admin.report.reward.global')) return view('404');
        $getData = $this->getAllRewardGlobal();
        $result = array_merge( (array) $getData->planA, (array) $getData->planB );
        $dbresult = (object) array_map("unserialize", array_unique(array_map("serialize", $result)));
        
        $data = array();
        $data[] = ['No', 'Plan', 'Group Target', 'Jumlah Member'];
        $i = 0;
        foreach ($dbresult as $result) {
            $i++;
            $data[] = [
                $i, $result->plan, $result->type_target,  $result->total_member
            ];
        }
        return Excel::create('Report_Reward_Global', function($excel) use ($data) {
            $excel->sheet('Report_Reward_Global', function($sheet) use ($data){
                $sheet->setColumnFormat(array('C' => '#,##0'));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
    
    public function getBonusGlobal(){
        if (!$this->user->hasAccessRoute('admin.report.reward.global')) return view('404');
        $this->setPageHeader('Report Bonus Global');
        ini_set('memory_limit', '2048M');
        //$allBonus  = $this->user->getAllBonusGlobal();
        $date = date('d');
        $month = date('m');
        $year = date('Y');
        $dataArray = array();
        for ($x = 1; $x <= $date; $x++) {
            $dataDate = $year.'-'.$month.'-'.$x;
            $getPIN = $this->user->getPlacementPINReportBonus($dataDate);
            $getSponsor = $this->user->getSponsorReportBonus($dataDate);
            $getPairing = $this->user->getPairingReportBonus($dataDate);
            $getUpgradePlanB = $this->user->getUpgradePlanBReportBonus($dataDate);
            $getFlyPlanC = $this->user->getFlyPlanCReportBonus($dataDate);
            $getRangking = $this->user->getRangkingReportBonus($dataDate);
            $dataDateReal = date('d F Y', strtotime($dataDate));
            $dataArray[] = (object) array(
                'date' => $dataDate,
                'placement_pin' => $getPIN,
                'sponsor' => $getSponsor,
                'pairing' => $getPairing,
                'upgrade_plan_b' => $getUpgradePlanB,
                'fly_plan_c' => $getFlyPlanC,
                'ranking' => $getRangking,
            );
        }
        return view('admin.member.bonus_global')
                    ->with('data', $dataArray);
    }
    
    public function getBonusGlobalXLS(){
        if (!$this->user->hasAccessRoute('admin.report.bonus.global.xls')) return view('404');
        $date = date('d');
        $month = date('m');
        $year = date('Y');
        $dataArray = array();
        for ($x = 1; $x <= $date; $x++) {
            $dataDate = $year.'-'.$month.'-'.$x;
            
            $getPIN = $this->user->getPlacementPINReportBonus($dataDate);
            $getSponsor = $this->user->getSponsorReportBonus($dataDate);
            $getPairing = $this->user->getPairingReportBonus($dataDate);
            $getUpgradePlanB = $this->user->getUpgradePlanBReportBonus($dataDate);
            $getFlyPlanC = $this->user->getFlyPlanCReportBonus($dataDate);
            $getRangking = $this->user->getRangkingReportBonus($dataDate);
            $dataDateReal = date('d F Y', strtotime($dataDate));
            $dataArray[] = (object) array(
                'date' => $dataDate,
                'placement_pin' => $getPIN,
                'sponsor' => $getSponsor,
                'pairing' => $getPairing,
                'upgrade_plan_b' => $getUpgradePlanB,
                'fly_plan_c' => $getFlyPlanC,
                'ranking' => $getRangking,
            );
        }
        $data = array();
        $data[] = ['No', 'Date' , 'Placement PIN', 'Sponsor', 'Pairing', 'Upgrade Plan B', 'Fly Plan C', 'Ranking'];
        $i = 0;
        foreach ($dataArray as $result) {
            $i++;
            $data[] = [
                $i, $result->date, $result->placement_pin,  $result->sponsor, $result->pairing, $result->upgrade_plan_b, $result->fly_plan_c, $result->ranking
            ];
        }
        return Excel::create('Report_Bonus_Global', function($excel) use ($data) {
            $excel->sheet('Report_Bonus_Global', function($sheet) use ($data){
                $sheet->setColumnFormat(array('C' => '#,##0'));
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
    
    public function getAdminNews(){
        if (!$this->user->hasAccessRoute('admin.news')) return view('404');
        $this->setPageHeader('Create News');
        return view('admin.news.news');
    }
    
    public function postAdminNews(Request $request){
        if (!$this->user->hasAccessRoute('admin.news.post')) return view('404');
        $dataLogin = $this->user;
        $by = $dataLogin->id;
        $title = $request->title;
        $image = $request->image_url;
        $desc = $request->desc;
        $sort = $request->sort_desc;
        if($title == null){
            $pesan = $this->setPesanFlash('error', 'Title can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        if($image == null){
            $pesan = $this->setPesanFlash('error', 'Image URL can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        if($desc == null){
            $pesan = $this->setPesanFlash('error', 'Description can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        if($sort == null){
            $pesan = $this->setPesanFlash('error', 'Sort Description can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        $dataAll = array('created_by' => $by, 'title' => $title, 'desc' => $desc, 'sort_desc' => $sort, 'image_url' => $image);
        $getID = DB::table('tb_contents')->insert($dataAll);
        $pesan = $this->setPesanFlash('success', 'News has created');
        return redirect()->route('admin.list.news')->with($pesan);
    }
    
    public function getAdminListNews(){
        if (!$this->user->hasAccessRoute('admin.list.news')) return view('404');
        $getData = $this->user->getAllPublishNews();
        $this->setPageHeader('List News');
        return view('admin.news.list')
                    ->with('data', $getData);
    }
    
    public function getAdminEditNews($id){
        if (!$this->user->hasAccessRoute('admin.edit.news')) return view('404');
        $getData = $this->user->getPublishNews($id);
        if(empty($getData)){
            $pesan = $this->setPesanFlash('error', 'News not found');
            return redirect()->route('admin.list.news')->with($pesan);
        }
        $this->setPageHeader('Edit News');
        return view('admin.news.news-edit')
                    ->with('data', $getData);
    }
    
    public function postAdminEditNews(Request $request){
        if (!$this->user->hasAccessRoute('admin.edit.news.post')) return view('404');
        $id = $request->id;
        $title = $request->title;
        $image = $request->image_url;
        $desc = $request->desc;
        $sort = $request->sort_desc;
        $updated_at = date('Y-m-d H:i:s');
        if($title == null){
            $pesan = $this->setPesanFlash('error', 'Title can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        if($image == null){
            $pesan = $this->setPesanFlash('error', 'Image URL can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        if($desc == null){
            $pesan = $this->setPesanFlash('error', 'Description can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        if($sort == null){
            $pesan = $this->setPesanFlash('error', 'Sort Description can not be empty');
            return redirect()->route('admin.news')->withInput()->with($pesan);
        }
        $dataAll = array('title' => $title, 'desc' => $desc, 'sort_desc' => $sort, 'image_url' => $image, 'updated_at' => $updated_at);
        DB::table('tb_contents')->where('id', '=', $id)->update($dataAll);
        $pesan = $this->setPesanFlash('success', 'News has updated');
        return redirect()->route('admin.list.news')->with($pesan);
    }
    
    public function getAdminDeleteNews($id, $type){
        if (!$this->user->hasAccessRoute('admin.delete.news')) return view('404');
        $getData = $this->user->getPublishNews($id);
        if(empty($getData)){
            $pesan = $this->setPesanFlash('error', 'News not found');
            return redirect()->route('admin.list.news')->with($pesan);
        }
        if($type == 'view'){
            return view('admin.news.news-delete')->with('data', $getData);
        } else {
            $dataAll = array('publish' => 0);
            DB::table('tb_contents')->where('id', '=', $id)->update($dataAll);
            $pesan = $this->setPesanFlash('success', 'News has deleted');
            return redirect()->route('admin.list.news')->with($pesan);
        }
    }
    
    public function getAdminMaxBank(){
        if (!$this->user->hasAccessRoute('admin.max.bank')) return view('404');
        $bank = New BankMember;
        $cekMaxBank = $bank->getMaxBank();
        $this->setPageHeader('Change Max Bank');
        return view('admin.max-bank')
                    ->with('data', $cekMaxBank);
    }
    
    public function postAdminMaxBank(Request $request){
        if (!$this->user->hasAccessRoute('admin.max.bank.post')) return view('404');
        $bank = New BankMember;
        $max_bank = $request->max_bank;
        if($max_bank == null){
            $pesan = $this->setPesanFlash('error', 'Max Bank can not be empty');
            return redirect()->route('admin.max.bank')->withInput()->with($pesan);
        }

        $dataAll = array('max_bank' => $max_bank);
        $insert = DB::table('tb_statik_settings')->insert($dataAll);
        $pesan = $this->setPesanFlash('success', 'Member Max Bank has created');
        return redirect()->route('admin.max.bank')->with($pesan);
    }

    //  member + left right
    public function getListMemberLeftRight(){
        $this->setPageHeader('All Member', 'All Member with left and right');
        if (!$this->user->hasAccessRoute('admin.member.leftright')) return view('404');
        return view('admin.member.leftright');
    }
    
    public function getAjaxListMemberLeftRight(Request $request){
        if (!$this->user->hasAccessRoute('admin.member.leftright')) return view('404');
        ini_set('memory_limit', '1536M');
        set_time_limit(0);

        $query = DB::table('users')
                        ->select(["userid", "name", DB::raw("0 AS kiri"), DB::raw("0 AS kanan")])
                        ->whereBetween('id_type', [0, 99])
                        ->whereNotNull('userid')
                        ->where('userid', '<>', '');

        $result = Datatables::queryBuilder($query)->make();
        $data = $result->original['data'];
        if (!empty($data)) {
            $clsStruktur    = new \App\StrukturJaringan; 
            $jml = count($data);
            for ($i=0; $i < $jml; $i++) { 
                $data[$i][2] = number_format($clsStruktur->getCountLeftByUserKode($data[$i][0]), 0, ',', '.');
                $data[$i][3] = number_format($clsStruktur->getCountRightByUserKode($data[$i][0]), 0, ',', '.');
            }
        }

        $result->original['data'] = $data;

        return json_encode((object) $result->original);
    }

    public function productClaimC()
    {
        $this->setPageHeader('List Product Claim (Plan-C)');
        return view('admin.planc.productclaimlist')->with('type', 'C')->with('status', 1);
    }

    public function ajaxListProductClaimC(Request $request) {
        $clsClaim = new ProductClaim();
        $status = $request->get('status', 1);
        $claimData = $clsClaim->getProductClaimListC('C',$status);
        $data = Datatables::collection($claimData);
        return $data->make();
    }

}
