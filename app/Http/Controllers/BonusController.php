<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class BonusController extends Controller
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
            if($this->isLoggedIn && !$this->isAdmin && $this->user->isMember()) {
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
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->setPageHeader('Summary Bonus');

        return view('bonus.index');
    }

    public function ajaxIndexBonus(Request $request) {
        $bonus = $this->user->getSummaryBonus();
        $data = Datatables::collection($bonus);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->grand_total   = 'Rp ' . number_format($row->bonus_sponsor + $row->bonus_pairing + $row->bonus_up_b, 0, ',', '.') . ',-';
                $row->bonus_sponsor = 'Rp ' . number_format($row->bonus_sponsor, 0, ',', '.') . ',-';
                $row->bonus_pairing = 'Rp ' . number_format($row->bonus_pairing, 0, ',', '.') . ',-';
                $row->bonus_up_b    = 'Rp ' . number_format($row->bonus_up_b, 0, ',', '.') . ',-';
            }
        }
        return $data->make();
    }

    public function bonusSponsor(Request $request) {
        $this->setPageHeader('Sponsor Bonus');
        return view('bonus.sponsor');
    }

    public function ajaxBonusSponsor(Request $request) {
        $bonus = $this->user->getBonusSponsor();
        $data = Datatables::collection($bonus);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
            }
        }
        return $data->make();
    }

    public function bonusUpgradeB(Request $request) {
        $this->setPageHeader('Upgrade Plan-B Bonus');
        return view('bonus.upgrade-b');
    }

    public function ajaxBonusUpgradeB(Request $request) {
        $bonus = $this->user->getBonusUpgradeB();
        if (!empty($bonus)) {
            foreach ($bonus as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
            }
        }
        $data = Datatables::collection($bonus);
        return $data->make();
    }

    public function bonusPairing(Request $request) {
        $this->setPageHeader('Pairing Bonus');
        return view('bonus.pairing');
    }

    public function ajaxBonusPairing(Request $request) {
        $bonus = $this->user->getBonusPairing();
        $data = Datatables::collection($bonus);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
            }
        }
        return $data->make();
    }

    public function bonusReward(Request $request) {
        $this->setPageHeader('Reward Bonus');
        return view('reward.list');
    }

    public function ajaxBonusReward(Request $request, $plan) {
        $bonus = $this->user->getRewardList($plan);
        if (!empty($bonus)) {
            foreach ($bonus as $row) {
                if ($row->status == -1) {
                    if ($row->reward_by == 1) {
                        $row->reward_description = 'Rp ' . number_format($row->reward_by_value, 0, ',', '.') . ',-';
                    } elseif ($row->reward_by == 2) {
                        $row->reward_description = $row->reward_by_name;
                    } else {
                        $row->reward_description = 'Rp ' . number_format($row->reward_by_value, 0, ',', '.') . ',-';
                        $row->reward_description .= '{br}or{br}';
                        $row->reward_description .= $row->reward_by_name;
                    }
                } else {
                    if ($row->claim_as == 1) {
                        $row->reward_description = 'Rp ' . number_format($row->reward_value, 0, ',', '.') . ',-';
                    } else {
                        $row->reward_description = $row->reward_name;
                    }
                    if (date('Y', strtotime($row->confirm_reward)) <= '1970') $row->confirm_reward = $row->create_reward;
                    $row->tgl_status = ($row->status == 1) ? date('Y-m-d H:i', strtotime($row->confirm_reward)) : date('Y-m-d H:i', strtotime($row->create_reward));
                }
            }
        }
        $data = Datatables::collection($bonus);
        return $data->make();
    }

    public function claimBonusReward(Request $request, $id, $plan) {
        $this->setPageHeader('Bonus Reward : Claim');
        $reward = $this->user->getSelectedReward($id, $plan);
        if (empty($reward)) {
            $pesan = $this->setPesanFlash('error', 'The reward you want to claim is already claimed, can not reclaim anymore.');
            return redirect()->route('bonus.reward')->with($pesan);
        }
        if ($request->isMethod('post')) {
            if (intval($request->input('agree', '0')) == 0) {
                $pesan = $this->setPesanFlash('error', 'You MUST AGREE with our Terms &amp; Conditions, to proceed with the claim reward process.');
                return redirect()->back()->with($pesan);
            }
            $claimAs = $request->get('choose1', 0);
            if (!$this->user->claimReward($reward, $claimAs)) {
                $pesan = $this->setPesanFlash('error', 'Failed to process your claim reward.');
                return redirect()->back()->with($pesan);
            }
            $pesan = $this->setPesanFlash('success', 'Reward claimed successfuly.');
            return redirect()->route('bonus.reward')->with($pesan);
        }
        return view('reward.claim')
                    ->with('data', $reward)
                    ->with('data_id', $id)
                    ->with('plan', $plan);
    }

    //  previous bonus, 4 juli 2017
    public function previousIndex(Request $request)
    {
        $this->setPageHeader('Previous Summary Bonus');

        return view('bonus.index-previous');
    }

    public function ajaxPreviousIndexBonus(Request $request) {
        $bonus = $this->user->getPreviousSummaryBonus();
        $data = Datatables::collection($bonus);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->grand_total   = 'Rp ' . number_format($row->bonus_sponsor + $row->bonus_pairing + $row->bonus_up_b, 0, ',', '.') . ',-';
                $row->bonus_sponsor = 'Rp ' . number_format($row->bonus_sponsor, 0, ',', '.') . ',-';
                $row->bonus_pairing = 'Rp ' . number_format($row->bonus_pairing, 0, ',', '.') . ',-';
                $row->bonus_up_b    = 'Rp ' . number_format($row->bonus_up_b, 0, ',', '.') . ',-';
            }
        }
        return $data->make();
    }

    public function previousBonusSponsor(Request $request) {
        $this->setPageHeader('Previous Sponsor Bonus');
        return view('bonus.sponsor-previous');
    }

    public function ajaxPreviousBonusSponsor(Request $request) {
        $bonus = $this->user->getPreviousBonusSponsor();
        $data = Datatables::collection($bonus);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
            }
        }
        return $data->make();
    }

    public function previousBonusUpgradeB(Request $request) {
        $this->setPageHeader('Previous Upgrade Plan-B Bonus');
        return view('bonus.upgrade-b-previous');
    }

    public function ajaxPreviousBonusUpgradeB(Request $request) {
        $bonus = $this->user->getPreviousBonusUpgradeB();
        if (!empty($bonus)) {
            foreach ($bonus as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
            }
        }
        $data = Datatables::collection($bonus);
        return $data->make();
    }

    public function previousBonusPairing(Request $request) {
        $this->setPageHeader('Previous Pairing Bonus');
        return view('bonus.pairing-previous');
    }

    public function ajaxPreviousBonusPairing(Request $request) {
        $bonus = $this->user->getPreviousBonusPairing();
        $data = Datatables::collection($bonus);
        if (!empty($data->collection)) {
            foreach ($data->collection as $row) {
                $row->bonus_amount = 'Rp ' . number_format($row->bonus_amount, 0, ',', '.') . ',-';
            }
        }
        return $data->make();
    }
}
