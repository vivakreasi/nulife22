<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Yajra\Datatables\Facades\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Shared_Date;
use DB;


class StockistController extends Controller{

    public function __construct(){
        $this->middleware(function (Request $request, $next) {
            parent::__construct();
            //  hanya user member
            if($this->isLoggedIn && !$this->isAdmin && $this->user->isMember()) {
                $this->initC(true);
                return $next($request);
            } elseif ($this->isAdmin) {
                return redirect()->route('admin');
            }
            // logout user, karena jika melalui route hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        });
    }

    public function statusPartner() {
        $this->setPageHeader('Partner');
        $partnerText = "You are not join partner yet.";
        if ($this->user->isStockis()) {
            $partnerText = ($this->user->isMasterStockis() ? 'Master ' : '') . 'Stockist';
        }
        $partnerStatus = $this->user->getPartnerStatus();
        return view('partner.status')->with(compact('partnerText', 'partnerStatus'));
    }

    public function joinPartner(Request $request) {
        if ($this->user->isStockis()) {
            $pesan = $this->setPesanFlash('error', "You are " . ($this->user->isMasterStockis() ? "Master" : "") . " Stockist, can't rejoin");
            return redirect()->route('partner.status')->with($pesan);
        }
        $partnerStatus = $this->user->getPartnerStatus();
        if ($partnerStatus->hasOrder) {
            $pesan = $this->setPesanFlash('error', "You have join in processing status, can't rejoin");
            return redirect()->route('partner.status')->with($pesan);
        }
        $settingPin = \App\PinType::first();
        if (empty($settingPin)) {
            $pesan = $this->setPesanFlash('error', "Something went wrong has occurred.");
            return redirect()->route('partner.status')->with($pesan);
        }
        $bankCompany = (new \App\BankCompany)->getListActiveBanks();
        if (empty($bankCompany)) {
            $pesan = $this->setPesanFlash('error', "Something went wrong has occurred.");
            return redirect()->route('partner.status')->with($pesan);
        }
        $this->setPageHeader('Partner : Join');
        $Stockist = new \App\StockistRequest;
        $listType = $Stockist->getListType();
        if ($request->isMethod('post')) {
            $selectedType   = $request->get('type', 0);
            $bankId         = $request->get('bank', 0);
            if (!array_key_exists($selectedType, $listType)) {
                $pesan = $this->setPesanFlash('error', "Partner Type is not available");
                return redirect()->back()->with($pesan)->withInput();
            }
            if (!array_key_exists($bankId, $bankCompany)) {
                $pesan = $this->setPesanFlash('error', "Bank is not available");
                return redirect()->back()->with($pesan)->withInput();
            }
            $type   = $listType[$selectedType];
            $harga  = ($selectedType == 2) ? $settingPin->pin_type_masterstockis_price : $settingPin->pin_type_stockis_price;
            $jumlah = $type->min_order;
            $values = array(
                'user_id'           => $this->user->id,
                'userid'            => $this->user->userid,
                'type_stockist_id'  => $selectedType, 
                'bank_company_id'   => $bankId, 
                'jml_pin'           => $jumlah, 
                'harga_pin'         => $harga, 
                'total_harga'       => $jumlah * $harga
            );
            if (!$Stockist->createRequest($values)) {
                $pesan = $this->setPesanFlash('error', "Request to be partner failed");
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan  = $this->setPesanFlash('success', "Request to be partner successfully created.");
            return redirect()->route('partner.invoice')->with($pesan);
        }
        return view('partner.join')->with(compact('listType', 'settingPin', 'bankCompany'));
    }

    public function upgradePartner(Request $request) {
        if (!$this->user->isStockis() || $this->user->isMasterStockis()) {
            $pesan = $this->setPesanFlash('error', "You are unable to upgrade to be Master Stockist.");
            return redirect()->route('partner.status')->with($pesan);
        }
        $partnerStatus = $this->user->getPartnerStatus();
        if ($partnerStatus->hasOrder) {
            $pesan = $this->setPesanFlash('error', "You have join in processing status, can't rejoin");
            return redirect()->route('partner.status')->with($pesan);
        }
        $settingPin = \App\PinType::first();
        if (empty($settingPin)) {
            $pesan = $this->setPesanFlash('error', "Something went wrong has occurred.");
            return redirect()->route('partner.status')->with($pesan);
        }
        $bankCompany = (new \App\BankCompany)->getListActiveBanks();
        if (empty($bankCompany)) {
            $pesan = $this->setPesanFlash('error', "Something went wrong has occurred.");
            return redirect()->route('partner.status')->with($pesan);
        }
        $this->setPageHeader('Partner : Upgrade');
        $Stockist = new \App\StockistRequest;
        $listType = $Stockist->getListType()[2];
        if ($request->isMethod('post')) {
            $bankId         = $request->get('bank', 0);
            if (!array_key_exists($bankId, $bankCompany)) {
                $pesan = $this->setPesanFlash('error', "Bank is not available");
                return redirect()->back()->with($pesan)->withInput();
            }
            $values = array(
                'user_id'           => $this->user->id,
                'userid'            => $this->user->userid,
                'type_stockist_id'  => $listType->id, 
                'bank_company_id'   => $bankId, 
                'jml_pin'           => $listType->min_order, 
                'harga_pin'         => $settingPin->pin_type_masterstockis_price, 
                'total_harga'       => $listType->min_order * $settingPin->pin_type_masterstockis_price
            );
            if (!$Stockist->createRequest($values)) {
                $pesan = $this->setPesanFlash('error', "Request to be partner failed");
                return redirect()->back()->with($pesan)->withInput();
            }
            $pesan  = $this->setPesanFlash('success', "Request to be partner successfully created.");
            return redirect()->route('partner.invoice')->with($pesan);
        }
        return view('partner.upgrade')->with(compact('listType', 'settingPin', 'bankCompany'));
    }

    public function invoicePartner() {
        $this->setPageHeader('Partner : Invoice');
        $partnerStatus = $this->user->getPartnerStatus();
        if (!$partnerStatus->hasOrder) {
            $pesan = $this->setPesanFlash('error', "You doesn't have any request");
            return redirect()->route('partner.status')->with($pesan);
        }
        return view('partner.invoice')->with(compact('partnerStatus'));
    }

    public function uploadPartner(Request $request) {
        $this->setPageHeader('Partner : Upload');
        $partnerStatus = $this->user->getPartnerStatus();
        if (!$partnerStatus->hasOrder) {
            $pesan = $this->setPesanFlash('error', "You doesn't have any request");
            return redirect()->route('partner.status')->with($pesan);
        }
        if ($request->isMethod('post')) {
            $Stockist = new \App\StockistRequest;
            $id = $request->get('nomor', 0);
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
            $cekFile = \App\Berkas::isAllowedImage('file', $objFile, 'jpg,png,jpeg', 2048);
            if (!$cekFile->Success) {
                $this->throwValidationException($request, $cekFile->Validator);
            }
            $filename   = uniqid('bt_', true) . '.' . \App\Berkas::getExtentionFile($objFile);

            DB::beginTransaction();
            if (!$Stockist->setUploaded($partnerStatus->dataOrder->id, $filename)) {
                DB::rollback();
                $pesan = $this->setPesanFlash('error', 'Failed processing upload. Please try again.');
                return redirect()->back()->with($pesan)->withInput();
            }
            $dir = base_path('files/become_stockist');
            if (! \App\Berkas::doUpload($objFile, $dir, $filename)) {
                DB::rollback();
                $pesan = $this->setPesanFlash('error', 'Failed processing upload. Please try again.');
                return redirect()->back()->with($pesan)->withInput();
            }
            DB::commit();
            $pesan = $this->setPesanFlash('success', 'Upload proof of transfer for your Request Partner, Success.');
            return redirect()->route('partner.status')->with($pesan);
        }
        return view('partner.upload')->with(compact('partnerStatus'));
    }
}
