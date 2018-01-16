<?php

namespace App\Http\Controllers;

use App\Plan_a_setting;
use App\Plan_b_setting;
use App\Plan_c;
use App\Plan_c_setting;
use App\ProductClaim;
use App\UpgradePlanB;
use App\UserProfile;
use Bregananta\Inventory\Models\Inventory;
use Illuminate\Http\Request;
use App\TransferReferal;
use App\PinMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Facades\Datatables;

class PlanController extends Controller
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
            if ($this->isLoggedIn && !$this->isAdmin && $this->user->isMember()) {
                $this->initC(true);
                return $next($request);
            } elseif ($this->isAdmin) {
                return redirect()->route('admin');
            }
            // logout user, karena jika melalui hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        }, ['except' => 'welcome']);
    }

    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageHeader('Dashboard', 'Summary of Your Account', false, false);
        $clsJaringan = new \App\StrukturJaringan;
        $summary = $clsJaringan->summaryStructure($this->user);
        $Myuser = $this->user;
        $ref = New TransferReferal;
        if ($Myuser->id_join_type == null) {
            if ($Myuser->is_referal_link == 1) {
                $cekTransfer = $ref->getTransferReferal($Myuser->id);
                if ($cekTransfer == null) {
                    $pesanArray =
                        array(
                            'pesan' => '<div class=\"text-center\" style=\"font-size:20px;margin-top: 0px; \">Please Choose Package</div><div class=\"text-center\" style=\"margin-top: 5px; \"><a href=\"/hakusaha\" class=\'btn btn-danger\'>CLICK</a></div>',
                            'style' => 'width:300px;height: 80px !important'
                        );
                    session()->put('memberBaru', $pesanArray);
                }
            } else {
                $pesanArray =
                    array(
                        'pesan' => '<div class=\"text-center\" style=\"font-size:20px;margin-top: 0px; \">Please Choose Package</div><div class=\"text-center\" style=\"margin-top: 5px; \"><a href=\"/hakusaha\" class=\'btn btn-danger\'>CLICK</a></div>',
                        'style' => 'width:300px;height: 80px !important'
                    );
                session()->put('memberBaru', $pesanArray);
            }
        }
        $cekTransferDownline = $ref->getTransferFromDownline($Myuser->id);
        if ($cekTransferDownline != null) {
            $pesanArray =
                array(
                    'pesan' => '<div class=\"text-center\" style=\"font-size:40px;margin-top: 20px; \">Registrasi baru referal link</div><div class=\"text-center\" style=\"margin-top: 20px; \"><a href=\"/list/transfer\" class=\'btn btn-danger\'>link</a></div>',
                    'style' => 'width:600px;height: 120px !important'
                );
            session()->put('memberBaru', $pesanArray);
        }
        $cekNews = $ref->getFisrtNewsNotView($Myuser->id);
        //dd($cekNews);
        return view('plan.index')->with('summary', $summary)->with('news', $cekNews);
    }

    /**
     * Show the network binary.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNetworkBinaryStructure(Request $request, $from = '', $top = 0)
    {
        $this->setPageHeader('Binary Structure', 'Your structure on binary mode');
        $clsJaringan = new \App\StrukturJaringan;
        if (empty($from) || $from == $this->user->userid) {
            $dataFrom = $this->user;
        } else {
            $dataFrom = \App\User::where('userid', '=', $from)->first();
            if (empty($dataFrom)) $dataFrom = $this->user;  //  update 2017-10-19 by tatang
        }

        //  update 2017-10-19 by tatang
        if ($this->user->id != $dataFrom->id) {
            $myStructure = $clsJaringan->getStructureByUserId($this->user->userid);
            $targetStructure = $clsJaringan->getStructureByUserId($dataFrom->userid);
            if (!empty($targetStructure)) {
                $myCode = $myStructure->kode;
                $targetCode = $targetStructure->kode;
                if (strlen($targetCode) < strlen($myCode)) {
                    $dataFrom = $this->user;
                    $top = 0;
                } else {
                    if (substr($targetCode, 0, strlen($myCode)) != $myCode) {
                        $dataFrom = $this->user;
                        $top = 0;
                    }
                }
            }
        }
        //  end update

        $struktur = $clsJaringan->getStructure($this->user, $dataFrom, $top);

        //dd($struktur);

        return view('plan.network-binary')
            ->with('struktur', $struktur);
    }

    /**
     * Show the network level.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNetworkLevelStructure(Request $request, $from = '')
    {
        $this->setPageHeader('Level Structure', 'Your structure on level mode');

        $pesan = $this->setPesanFlash('warning', 'Data not found.');
        $key = array_keys($pesan)[0];
        $isi = $pesan[$key];

        $request->session()->forget($key);

        $clsJaringan = new \App\StrukturJaringan;
        $ada = true;
        if (empty($from) || $from == '' || $from == $this->user->userid) {
            $dataFrom = $this->user;
        } else {
            $dataFrom = \App\User::where('userid', '=', $from)
                ->orWhere('name', 'like', '%' . $from . '%')
                ->orderBy('id')
                ->first();
            $ada = !empty($dataFrom);
            if (!$ada) $dataFrom = $this->user;
        }

        //  update 2017-10-19 by tatang
        if ($this->user->id != $dataFrom->id) {
            $myStructure = $clsJaringan->getStructureByUserId($this->user->userid);
            $targetStructure = $clsJaringan->getStructureByUserId($dataFrom->userid);
            if (!empty($targetStructure)) {
                $myCode = $myStructure->kode;
                $targetCode = $targetStructure->kode;
                if (strlen($targetCode) < strlen($myCode)) {
                    $dataFrom = $this->user;
                } else {
                    if (substr($targetCode, 0, strlen($myCode)) != $myCode) {
                        $dataFrom = $this->user;
                    }
                }
            }
        }
        //  end update

        $struktur = $clsJaringan->getActualStructure($this->user, $dataFrom);

        if (!$ada) {
            $request->session()->flash($key, $isi);
        }

        return view('plan.network-level')->with('struktur', $struktur);
    }

    public function directSponsored(Request $request)
    {
        $this->setPageHeader('Direct Sponsor', 'Your sponsored members');
        return view('plan.direct-sponsored');
    }

    public function ajaxDirectSponsored(Request $request)
    {
        $clsJaringan = new \App\StrukturJaringan;
        $sponsored = $clsJaringan->getListDirectSponsored($this->user);
        $data = Datatables::collection($sponsored);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->status = ($row->is_active == 0) ? 'Pending Activation' : (($row->status == 0) ? 'Require Placement' : 'OK');
            }
        }
        return $data->make();
    }

    public function memberPlacement(Request $request, $from = '', $top = 0)
    {

        $clsJaringan = new \App\StrukturJaringan;

        $this->setPageHeader('Placement', 'Place your sponsored member to your binary structure');
        if (empty($from) || $from == $this->user->userid) {
            $dataFrom = $this->user;
        } else {
            $dataFrom = \App\User::where('userid', '=', $from)->first();
            if (empty($dataFrom)) $dataFrom = $this->user;  //  update 2017-10-19 by tatang
        }

        //  update 2017-10-19 by tatang
        if ($this->user->id != $dataFrom->id) {
            $myStructure = $clsJaringan->getStructureByUserId($this->user->userid);
            $targetStructure = $clsJaringan->getStructureByUserId($dataFrom->userid);
            if (!empty($targetStructure)) {
                $myCode = $myStructure->kode;
                $targetCode = $targetStructure->kode;
                if (strlen($targetCode) < strlen($myCode)) {
                    $dataFrom = $this->user;
                    $top = 0;
                } else {
                    if (substr($targetCode, 0, strlen($myCode)) != $myCode) {
                        $dataFrom = $this->user;
                        $top = 0;
                    }
                }
            }
        }
        //  end update
        
        $pin = New PinMember;

        $members = [];
        $totalFreePin = $pin->getCountFreePIN($this->user->id);
        
        $havePin = ($totalFreePin > 0);

        $return = false;
        if ($havePin) {
            $members = $clsJaringan->getRequirePlacement($this->user);
            $return = !$members->isEmpty();
        }

        $actions = (object)array(
            'continue' => $return,
            'message' => ''
        );
        if (!$actions->continue) {
            if (!$havePin) {
                $actions->message = "You don't have a PIN to place in your structure";
            } else {
                if (empty($members) || $members->isEmpty()) {
                    $actions->message = 'No member to place in your structure.';
                } else {
                    $actions->message = 'Unknown Error';
                    
                }
            }
        }
        
        if(!$clsJaringan->isAllowPlacement()) {
            $message = 'Daily New Member Placement Limit has been reached. You can not place new member anymore today. Please try again tomorrow.';
            $pesan = $this->setPesanFlash('error', $message);
            return redirect()->route('dashboard')->with($pesan);
        }

        $struktur = $actions->continue ? $clsJaringan->getStructure($this->user, $dataFrom, $top, true) : null;
        $actions->continue = isset($struktur->data) && !empty($struktur->data);

        return view('plan.placement')
            ->with('actions', $actions)
            ->with('members', $members)
            ->with('struktur', $struktur)
            ->with('totalFreePin', $totalFreePin);
    }

    public function doMemberPlacement(Request $request)
    {
        //  tidak diperkenan method get
        if ($request->isMethod('post')) {
            $clsJaringan = new \App\StrukturJaringan;
            
            if(!$clsJaringan->isAllowPlacement()) {
                $message = 'Daily New Member Placement Limit has been reached. You can not place new member anymore today. Please try again tomorrow.';
                $pesan = $this->setPesanFlash('error', $message);
                return redirect()->route('dashboard')->with($pesan);
            }

            $dataLogin = $this->user;
            $pin = New PinMember;

            $totalFreePin = $pin->getCountFreePIN($this->user->id);
            if ($totalFreePin <= 0) {
                $message = "You don't have a PIN to place in your structure";
                $pesan = $this->setPesanFlash('error', $message);
                return redirect()->route('plan.placement')->with($pesan);
            }

            $cekPin = $pin->getMemberHavePIN($this->user->id);
            $email = $request->get('email');
            $parentCode = $request->get('parent');
            $userid = $request->get('userid');
            $foot = $request->get('foot');


            if ($clsJaringan->isUserExist($userid)) {
                $pesan = $this->setPesanFlash('error', 'Member with code ' . $userid . ' already exist in your structure.');
                return redirect()->back()->with($pesan);
            }
            $akun = \App\User::where('userid', '=', $userid)->first();
            if (empty($akun)) {
                $pesan = $this->setPesanFlash('error', 'Data not found.');
                return redirect()->back()->with($pesan);
            }
            if (!$clsJaringan->placeMember($this->user, $akun, $parentCode, $foot, $cekPin)) {
                $pesan = $this->setPesanFlash('error', 'Failed to place the member with code ' . $userid . '.');
                return redirect()->back()->with($pesan);
            }
            
            $pesan = $this->setPesanFlash('success', 'The member with code ' . $userid . ' successfuly placed.');
            return redirect()->route('plan.placement')->with($pesan);
        }
        return 'Ngehe';
    }

    public function upgradeToB(Request $request)
    {
        if ($this->user->isPlanB()) {
            $pesan = $this->setPesanFlash('error', 'You already Plan-B.');
            return redirect()->route('dashboard')->with($pesan);
        }
        $this->setPageHeader('Upgrade', 'Upgrade from Plan-A to Plan-B');
        if ($request->isMethod('post')) {
            if ($this->user->plan_status == 0) {
                $this->validate($request, [
                    'sel_position' => [
                        'required',
                        Rule::in([1,3,7])
                    ],
                    'address' => 'required',
                    'provinsi' => 'required|exists:tb_provinces,id',
                    'kota' => 'required|exists:tb_kota,id',
                    'kelurahan' => 'required|exists:tb_kirim_tarif,id',
                    'zip_code' => 'required|digits:5'
                ]);

                if (intval($request->input('agree', '0')) == 0) {
                    $pesan = $this->setPesanFlash('error', 'You MUST AGREE with our Terms &amp; Conditions, to proceed with the upgrade process.');
                    return redirect()->back()->with($pesan);
                }
                $dataUpgrade = null;
                if (!$this->user->startUpgradeToB($request->all())) {
                    $pesan = $this->setPesanFlash('error', 'Failed to start upgrade to plan-B, please try again.');
                    return redirect()->back()->with($pesan);
                }
                $pesan = $this->setPesanFlash('success', 'Start upgrade to plan-B successfuly. Please transfer to Nulife to finish upgrade.');
                return redirect()->route('plan.upgrade.b')->with($pesan);
            } elseif ($this->user->plan_status == 1 && !empty($dataUpgrade = $this->user->getDataUpgrade())) {
                if ($dataUpgrade->status != 0) {
                    $pesan = $this->setPesanFlash('error', 'We can not process your request.');
                    return redirect()->route('dashboard')->with($pesan);
                }
                //  do upload
                if (!$request->hasFile('file')) {
                    $pesan = $this->setPesanFlash('error', 'No image file uploaded.');
                    return redirect()->back()->with($pesan)->withInput();
                }
                $objFile = $request->file('file');
                $tmpFile = '';
                if (!\App\Berkas::FileUploaded($objFile, $tmpFile)) {
                    $pesan = $this->setPesanFlash('error', 'No image file uploaded.');
                    return redirect()->back()->with($pesan)->withInput();
                }
                $cekFile = \App\Berkas::isAllowedImage('file', $objFile, 'jpg,png,jpeg', 2040);
                if (!$cekFile->Success) {
                    $this->throwValidationException($request, $cekFile->Validator);
                }
                $filename = $dataUpgrade->upgrade_kode . '.' . \App\Berkas::getExtentionFile($objFile);
                if (!$this->user->uploadUpgradeToB($objFile, $filename)) {
                    $pesan = $this->setPesanFlash('error', 'Failed processing upload. Please try again.');
                    return redirect()->back()->with($pesan)->withInput();
                }
                $pesan = $this->setPesanFlash('success', 'Upload transfer file upgrade plan-B successfuly. Please be patient for waiting confirmation from our Admin.');
                return redirect()->route('plan.upgrade.b')->with($pesan);
            }
        }

        $profile = New UserProfile;
        $userProfile = $profile->getDetailMemberProfile(Auth::id());

        $provinsi = $profile->getProvince();
        $kota = $profile->getKota();
        $kecamatan = $profile->getKecamatan();


        return view('plan.upgrade-b')
            ->with('provinsi', $provinsi)
            ->with('kota', $kota)
            ->with('kecamatan', $kecamatan)
            ->with('profile', $userProfile);
    }

    public function claimProduct()
    {
        $this->setPageHeader('Product Claim', 'Claim products of your plans');

        $planb = new UpgradePlanB();
        $datab = $planb->getAvailableClaim($this->user);

        $planc = new Plan_c();
        $datac = $planc->getAvailableClaim($this->user);
//        dd($datac);

        return view('plan.productclaim')
            ->with('datab', $datab)
            ->with('datac', $datac);
    }

    public function getClaimProductB($code)
    {
        $this->setPageHeader('Product Claim', 'Form claim products : plan-B');

        $planb = new UpgradePlanB();
        $validmine = $planb->isUpgradeMine($code, $this->user);
        if ($validmine) {
            $user = $this->user;
            $profile = new UserProfile();
            $userProfile = $profile->getDetailMemberProfile($user->id);

            $planBSetting = new Plan_b_setting();
            $productid = $planBSetting->getSetting()->product_id;

            $inventory = new Inventory();
            $product = $inventory::find($productid);

            $ref = New UserProfile();
            $province = $ref->getProvince();

            return view('plan.formproductclaim')
                ->with('type', 'B')
                ->with('user', $user)
                ->with('userProfile', $userProfile)
                ->with('product', $product)
                ->with('provincelist', $province)
                ->with('code', $code);
        } else {
            $pesan = $this->setPesanFlash('error', 'Sorry, we detect that you try to claim product that not belong to you!');
            return redirect()->back()->with($pesan);
        }
    }

    public function postClaimProductB(Request $request)
    {
        $planb = new UpgradePlanB();
        $validmine = $planb->isUpgradeMine($request['code'], $this->user);

        if ($validmine) {
            $claim = new ProductClaim();
            $claim->user_id = $this->user->id;
            $claim->userid = $this->user->userid;
            $claim->type = 'B';
            $claim->code = $request['code'];
            $claim->status = 1;
            $claim->quantity = 1;
            $claim->delivery_name = $request['delivery_name'];
            $claim->delivery_address = $request['address'];
            $claim->delivery_province = $request['selprovince'];
            $claim->delivery_city = $request['selcity'];
            $claim->delivery_zip_code = $request['postcode'];
            $claim->delivery_phone = $request['contactphone'];
            $claim->save();

            $pesan = $this->setPesanFlash('success', 'Product Claim success.');
            return redirect('plan/product/claim')->with($pesan);
        } else {
            $pesan = $this->setPesanFlash('error', 'Sorry, we detect that you try to claim product that not belong to you!');
            return redirect('plan/product/claim')->with($pesan);
        }
    }

    public function getClaimProductC($code)
    {
        $this->setPageHeader('Product Claim', 'Form claim products : plan-C');

        $planc = new Plan_c();
        $validmine = $planc->isUpgradeMine($code, $this->user);
        if ($validmine) {
            $user = $this->user;
            $profile = new UserProfile();
            $userProfile = $profile->getDetailMemberProfile($user->id);

            $planCSetting = new Plan_c_setting();
            $productid = $planCSetting->getSetting()->product_id;

            $inventory = new Inventory();
            $product = $inventory::find($productid);

            $ref = New UserProfile();
            $province = $ref->getProvince();

            return view('plan.formproductclaim')
                ->with('type', 'C')
                ->with('user', $user)
                ->with('userProfile', $userProfile)
                ->with('product', $product)
                ->with('provincelist', $province)
                ->with('code', $code);
        } else {
            $pesan = $this->setPesanFlash('error', 'Sorry, we detect that you try to claim product that not belong to you!');
            return redirect()->back()->with($pesan);
        }
    }

    public function postClaimProductC(Request $request)
    {
        $planc = new Plan_c();
        $validmine = $planc->isUpgradeMine($request['code'], $this->user);

        if ($validmine) {
            $claim = new ProductClaim();
            $claim->user_id = $this->user->id;
            $claim->userid = $this->user->userid;
            $claim->type = 'C';
            $claim->code = $request['code'];
            $claim->status = 1;
            $claim->quantity = 1;
            $claim->delivery_name = $request['delivery_name'];
            $claim->delivery_address = $request['address'];
            $claim->delivery_province = $request['selprovince'];
            $claim->delivery_city = $request['selcity'];
            $claim->delivery_zip_code = $request['postcode'];
            $claim->delivery_phone = $request['contactphone'];
            $claim->save();

            $pesan = $this->setPesanFlash('success', 'Product Claim success.');
            return redirect('plan/product/claim')->with($pesan);
        } else {
            $pesan = $this->setPesanFlash('error', 'Sorry, we detect that you try to claim product that not belong to you!');
            return redirect('plan/product/claim')->with($pesan);
        }

    }

}