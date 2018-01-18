<?php

namespace App\Http\Controllers;

use App\Berkas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class PlanB1Controller extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            parent::__construct();
            //  hanya user member
            if($this->isLoggedIn && !$this->isAdmin && $this->user->isMember()) {
//                return redirect()->route('dashboard');
                $this->initC(true);
                return $next($request);
            } elseif ($this->isAdmin) {
                return redirect()->route('admin');
            }
            // logout user, karena jika melalui hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageHeader('Plan-B Board');
        $activeC    = $this->PlanC->getActivePlan();
        $myListRunning  = $this->user->getListPlanC($this->PlanC);

        return view('planc.board')
                    ->with('activeC', $activeC)
                    ->with('myListQueue', $myListRunning);
    }

    public function ajaxQueue(Request $request) {
        $myListRunning  = $this->user->getListPlanC($this->PlanC);
        $queuePlanC     = $this->PlanC->getQueuePlan();
        if (!empty($queuePlanC)) {
            foreach ($queuePlanC as $row) {
                if (!empty($myListRunning)) {
                    if (!empty($row->kode1)) $row->kode1 = in_array($row->kode1, $myListRunning) ? $row->kode1 : '#############';
                    if (!empty($row->kode2)) $row->kode2 = in_array($row->kode2, $myListRunning) ? $row->kode2 : '#############';
                    if (!empty($row->kode3)) $row->kode3 = in_array($row->kode3, $myListRunning) ? $row->kode3 : '#############';
                    if (!empty($row->kode4)) $row->kode4 = in_array($row->kode4, $myListRunning) ? $row->kode4 : '#############';
                    if (!empty($row->kode5)) $row->kode5 = in_array($row->kode5, $myListRunning) ? $row->kode5 : '#############';
                } else {
                    if (!empty($row->kode1)) $row->kode1 = '#############';
                    if (!empty($row->kode2)) $row->kode2 = '#############';
                    if (!empty($row->kode3)) $row->kode3 = '#############';
                    if (!empty($row->kode4)) $row->kode4 = '#############';
                    if (!empty($row->kode5)) $row->kode5 = '#############';
                }
                if (!empty($row->kode1)) $row->kode1 = $row->nomor1 . ' - ' . $row->kode1; 
                if (!empty($row->kode2)) $row->kode2 = $row->nomor2 . ' - ' . $row->kode2; 
                if (!empty($row->kode3)) $row->kode3 = $row->nomor3 . ' - ' . $row->kode3; 
                if (!empty($row->kode4)) $row->kode4 = $row->nomor4 . ' - ' . $row->kode4; 
                if (!empty($row->kode5)) $row->kode5 = $row->nomor5 . ' - ' . $row->kode5; 
            }
        }
        $data = Datatables::collection($queuePlanC);
        return $data->make();
    }

    /**
     * Menampilkan halaman untuk join Plan-B
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request)
    {
        //$currentPlanC = $this->PlanC->getPlanC($this->user);
        /*if (!$clsPlanC->isFlayed($currentPlanC)) {
            $pesan = $this->setPesanFlash('error', 'Anda sudah bergabung di Plan-B.<br/>Anda tidak dapat bergabung kembali sebelum status Anda di Plan-B sudah Fly');
            return redirect()->route('planc')->with($pesan);
        }*/
        $this->setPageHeader('Join Plan-B', 'Join to NuLife Plan-B program');
        $mySummaryPin = $this->PinC->getCountPinUserC($this->user, $this->PlanC);
        if ($mySummaryPin->sisa <= 0) return redirect()->route('planc.trfinstruction');
        if ($request->isMethod('post')) {
            //  cegah post robot
            //  jika tidak punya pin, balik ke dashboard dengan pesan
            if ($mySummaryPin->total_pin <= 0) {
                $pesan = $this->setPesanFlash('error', 'You have no PIN to join NuLife Plan-B program');
                return redirect()->route('planc')->with($pesan);
            }
            if (intval($request->input('agree', '0')) == 0) {
                $pesan = $this->setPesanFlash('error', 'You MUST AGREE with our Terms &amp; Conditions, to proceed with the join process.');
                return redirect()->back()->with($pesan);
            }
            if (!$this->PlanC->canRegisterByCount($this->user)) {
                $pesan = $this->setPesanFlash('error', 'Your account in this plan-B has been maxed out.');
                return redirect()->back()->with($pesan);
            }
            $myPlanC = null;
            if ($this->PlanC->registerPlanC($this->user, $mySummaryPin->usable_id, $myPlanC)) {
                $myCodeC = (empty($myPlanC)) ? 'ERROR' : $myPlanC->plan_c_code;
                $pesan = $this->setPesanFlash('success', 'You have successfully join NuLife Plan-B program, Your Plan-B ID is <strong>' . $myCodeC . '</strong>');
                return redirect()->route('planc')->with($pesan);
            } else {
                $pesan = $this->setPesanFlash('error', 'Join NuLife Plan-B program process failed.');
                return redirect()->route('planc.join')->with($pesan);
            }
        }
        return view('planc.join')->with('summaryPin', $mySummaryPin);
    }

    /**
     * Menampilkan halaman untuk order pin Plan-B
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function transferInstruction(Request $request) {
        $step = $request->session()->get('step');
        if (is_null($step)) $step = $request->get('step', 0);
        $mySummaryPin = $this->PinC->getCountPinUserC($this->user, $this->PlanC, true);
        $Instruction = $request->session()->get('Instruction');
        $this->setPageHeader('Order Pin Plan-B', 'PIN Order for NuLife Plan-B program');
        if ($request->isMethod('post') && $step == 1) {
            $amount = ceil($request->get('amount', 0));
            if ($mySummaryPin->available_order > 0 && $amount > 0) {
                if ($amount > $mySummaryPin->available_order) {
                    $pesan = $this->setPesanFlash('error', 'You can not make a PIN order more than maximum allowed order.');
                    return redirect()->back()->with($pesan)->withInput();
                }
                $order = null;
                if ($this->PinC->saveOrder($this->user, $amount, $order)) {
                    $Instruction = $this->PinC->getInstruction($order);
                    return redirect()->back()
                                ->with('step', $step + 1)
                                ->with('order_id', $order->id)
                                ->with('Instruction', $Instruction);
                } else {
                    $pesan = $this->setPesanFlash('error', '<b>Error!!!</b> Something went wrong on order process. Please try again in a moment.');
                    return redirect()->back()->with($pesan)->withInput();
                }
            } else {
                if ($amount <= 0) {
                    $pesan = $this->setPesanFlash('error', 'Can not make an empty order.');
                    return redirect()->back()->with($pesan)->withInput();
                }
                if ($mySummaryPin->available_order <= 0) {
                    $pesan = $this->setPesanFlash('error', 'Can not make an empty order.');
                    return redirect()->route('planc')->with($pesan);
                }
            }
        }
        if ($step == 0) $step = 1;
        $order_id = $request->session()->get('order_id');
        if (empty($order_id)) $order_id = 0;
        return view('planc.trfinstruction')
                    ->with('step', $step)
                    ->with('order_id', $order_id)
                    ->with('summaryPin', $mySummaryPin)
                    ->with('Instruction', $Instruction);
    }

    /**
     * Menampilkan halaman status order pin Plan-B
     *
     * @return \Illuminate\Http\Response
     */
    public function statusOrder(Request $request)
    {
        $this->setPageHeader('NuLife Plan-B PIN Order Status');
        $orders = $this->PinC->getUserOrders($this->user);
        return view('planc.status_order')->with('orders', $orders);
    }

    public function bonusList(Request $request) {
        $bonus = $this->PlanC->getHistoryBonus($this->user);
        //$sisaBonus = $this->PlanC->getSummaryBonusFromList($bonus);
        //$this->setPageHeader('Bonus Plan-B', 'List of NuLife Plan-B Bonus You have earned.', false, true, 0, 0, $sisaBonus);
        $this->setPageHeader('Bonus Plan-B', 'List of NuLife Plan-B Bonus You have earned.');
        return view('planc.bonus')->with('bonus', $bonus);
    }

    public function bonusSuccessList() {
        $bonus = $this->PlanC->getHistoryBonus($this->user);
        //$sisaBonus = $this->PlanC->getSummaryBonusFromList($bonus);
        //$this->setPageHeader('Withdrawed Bonus Plan-B', 'List of NuLife Plan-B Bonus You have earned and withdrawed.', false, true, 0, 0, $sisaBonus);
        $this->setPageHeader('Withdrawed Bonus Plan-B', 'List of NuLife Plan-B Bonus You have earned and withdrawed.');
        $successWD = $this->PlanC->getBonusSuccessWD($this->user);
        return view('planc.bonus_success')->with('bonus', $successWD);
    }

    public function userBank(Request $request) {
        $clsBank = new \App\Plan_c_bank;
        $this->setPageHeader('NuLife Plan-B Account Bank', 'This facility is provided to facilitate the process of withdrawal of the bonus Plan-B');
        $dataBank = $clsBank->getOneByUser($this->user);
        return view('planc.bank')->with('bank', $dataBank);
    }

    public function addUserBank(Request $request) {
        $clsBank = new \App\Plan_c_bank;
        $this->setPageHeader('NuLife Plan-B Account Bank', 'This facility is provided to facilitate the process of withdrawal of the bonus Plan-B');
        $dataBank = $clsBank->getOneByUser($this->user);
        if (!empty($dataBank)) {
            $pesan = $this->setPesanFlash('error', 'You already have a bank account, you can not add bank account again.');
            return redirect()->route('planc.bank')->with($pesan);
        }
        if ($request->isMethod('post')) {
            $values = array(
                'user_id'   => $this->user->id,
                'bank_name' => 'Bank Mandiri',
                'bank_account' => $request->get('bank_account', ''),
                'bank_account_name' => $this->user->name
            );
            if (!$clsBank->saveData($values)) {
                $pesan = $this->setPesanFlash('error', 'Failed to save account bank, please check your input.');
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan = $this->setPesanFlash('success', 'Your bank account has been successfully saved.');
            return redirect()->route('planc.bank')->with($pesan)->withInput();
        }
        return view('planc.bank_add');
    }

    public function editUserBank(Request $request, $id) {
        $clsBank = new \App\Plan_c_bank;
        $this->setPageHeader('NuLife Plan-B Account Bank', 'This facility is provided to facilitate the process of withdrawal of the bonus Plan-B');
        $dataBank = $clsBank->getByIdUser($id, $this->user);
        if (empty($dataBank)) {
            $pesan = $this->setPesanFlash('error', 'Account bank not found.');
            return redirect()->route('planc.bank')->with($pesan);
        }
        if ($request->isMethod('post')) {
            if ($request->get('bank_id') != $id) {
                $pesan = $this->setPesanFlash('error', 'Bad operation.');
                return redirect()->route('planc')->with($pesan);
            }
            $values = array('bank_account' => $request->get('bank_account', ''));
            if (!$clsBank->updateData($dataBank->id, $values)) {
                $pesan = $this->setPesanFlash('error', 'Failed to update account bank, please check your input.');
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan = $this->setPesanFlash('success', 'Your bank account has been successfully updated.');
            return redirect()->route('planc.bank')->with($pesan)->withInput();
        }
        return view('planc.bank_edit')->with('bank', $dataBank);
    }

    public function bonusListLeadership(Request $request) {
        $bonus = $this->user->bonusListLeadership();
        $this->setPageHeader('Ranking Bonus');
        return view('planc.bonus_leadership')->with('bonus', $bonus);
    }

    public function uploadBuktiTransfer(Request $request)
    {
        $id = $request->input('order_id');
        if (!$request->hasFile('file')) {
            $pesan = $this->setPesanFlash('error', 'No image file uploaded.');
            return redirect()->back()->with($pesan)->withInput();
        }
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
        $filename   = uniqid('bt_',true) . '.' . \App\Berkas::getExtentionFile($objFile);

        if (!$this->PinC->uploadPinPlanc($id, $objFile, $filename)) {
            $pesan = $this->setPesanFlash('error', 'Failed processing upload. Please try again.');
            return redirect()->back()->with($pesan)->withInput();
        }
        $pesan = $this->setPesanFlash('success', 'Upload proof of transfer, for your Plan-B PIN order, Success.');
        return redirect()->route('planc.status.order')->with($pesan);
    }

    public function historyPlan(Request $request) {
        $this->setPageHeader('Plan-B History', 'History of joined account to Plan-B');
        $myPlanC  = $this->PlanC->getPlanC($this->user); 
        return view('planc.history')->with('myPlanC', $myPlanC);
    }
}


/*
4 = baru daftar
5 = konfirmasi
3 = approove
*/
