<?php

namespace App\Http\Controllers;

use App\UpgradePlanB;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PlanBController extends Controller
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
            if ($this->isLoggedIn) {
                return $next($request);
            }
            // logout user, karena jika melalui hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        }, ['except' => 'welcome']);
    }

    /**
     * Show the network binary.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNetworkBinaryStructure(Request $request, $from = '', $top = 0)
    {
        $this->setPageHeader('Plan-B Binary Structure', 'Your Plan-B structure on binary mode');
        $clsJaringan = new \App\StrukturJaringanPlanB;
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

    public function memberPlacement(Request $request, $from = '', $top = 0)
    {

        $clsJaringan = new \App\StrukturJaringanPlanB;

        $this->setPageHeader('Plan-B Placement', 'Place your sponsored member to your binary structure');
        if (empty($from) || $from == $this->user->userid) {
            $dataFrom = $this->user;
        } else {
            $dataFrom = \App\User::where('userid', '=', $from)->first();
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

        $clsUpgrade = new UpgradePlanB();
        if (!$userUpgrade = $clsUpgrade->getUserUpgradeData(Auth::id())) {
            $upgradeCount = 1;
        } else {
            $upgradeCount = $userUpgrade->planb_type;
        }

        $members = $clsJaringan->getRequirePlacement($this->user);

        $own = $clsJaringan->getRequirePlacementOwn($this->user,$upgradeCount);

        //dd($own);

        $return = ($members->isEmpty() && $own->isEmpty()) ? false : true;

        $actions = (object)array(
            'continue' => $return,
            'message' => ''
        );

        if (!$actions->continue) {
            if (empty($members) || $members->isEmpty()) {
                $actions->message = 'No member to place in your structure.';
            } else {
                $actions->message = 'Unknown Error';

            }
        }

        $struktur = $actions->continue ? $clsJaringan->getStructure($this->user, $dataFrom, $top, true) : null;

        $actions->continue = isset($struktur->data) && !empty($struktur->data);

        return view('plan.placementb')
            ->with('actions', $actions)
            ->with('members', $members)
            ->with('struktur', $struktur)
            ->with('own', $own);
    }

    public function doMemberPlacement(Request $request)
    {
        //  tidak diperkenan method get
        if ($request->isMethod('post')) {
            $clsJaringan = new \App\StrukturJaringanPlanB;

            $email = $request->get('email');
            $parentCode = $request->get('parent');
            $userid = $request->get('userid');
            $foot = $request->get('foot');

            $userid_x = $userid;

            if (substr($userid, -2, 1) === '-') {
                $userid = substr($userid, 0, strlen($userid)-2);
            }

            if ($clsJaringan->isUserExist($userid)) {
                $pesan = $this->setPesanFlash('error', 'Member with code ' . $userid . ' already exist in your structure.');
                return redirect()->back()->with($pesan);
            }

            $akun = \App\User::where('userid', '=', $userid)->first();
            if (empty($akun)) {
                $pesan = $this->setPesanFlash('error', 'Data not found.');
                return redirect()->back()->with($pesan);
            }

            if (!$clsJaringan->placeMember($this->user, $akun, $parentCode, $foot, $userid_x)) {
                $pesan = $this->setPesanFlash('error', 'Failed to place the member with code ' . $userid . '.');
                return redirect()->back()->with($pesan);
            }

            $pesan = $this->setPesanFlash('success', 'The member with code ' . $userid . ' successfuly placed.');
            return redirect()->route('plan.placement.b')->with($pesan);
        }
        return 'Ngehe';
    }

}
