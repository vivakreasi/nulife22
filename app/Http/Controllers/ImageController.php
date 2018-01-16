<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function showImageUpgradePlanB(Request $request)
    {
        $image = $request->get('img', '');
        $imgFile = base_path('files/upgrade_b/') . '/' . $image;

        $img  = \App\Berkas::LoadImage($imgFile);
        if ($img->FileName != '') {
            header("Content-type: " . $img->FileType);
            return readfile($img->FileName);
        } else {
            return '';
        }
    }
    
    public function showImageTransferReferal($img){
        $imgFile = base_path('files/ref') . '/' . $img;
        $imgnya  = \App\Berkas::LoadImage($imgFile);
        if ($imgnya->FileName != '') {
            header("Content-type: " . $imgnya->FileType);
            return readfile($imgnya->FileName);
        } else {
            return '';
        }
    }

    public function showImageConfirmPin(Request $request)
    {
        $image = $request->get('img', '');
        $imgFile = base_path('files/confirm_pin/') . '/' . $image;

        $img  = \App\Berkas::LoadImage($imgFile);
        if ($img->FileName != '') {
            header("Content-type: " . $img->FileType);
            return readfile($img->FileName);
        } else {
            return '';
        }
    }

    public function showImagePinPlanC(Request $request)
    {
        $image = $request->get('img', '');
        $imgFile = base_path('files/pin_planc/') . '/' . $image;

        $img  = \App\Berkas::LoadImage($imgFile);
        if ($img->FileName != '') {
            header("Content-type: " . $img->FileType);
            return readfile($img->FileName);
        } else {
            return '';
        }
    }

    public function showImageBecomePartner(Request $request)
    {
        $image = $request->get('img', '');
        $imgFile = base_path('files/become_stockist/') . '/' . $image;

        $img  = \App\Berkas::LoadImage($imgFile);
        if ($img->FileName != '') {
            header("Content-type: " . $img->FileType);
            return readfile($img->FileName);
        } else {
            return '';
        }
    }

}
