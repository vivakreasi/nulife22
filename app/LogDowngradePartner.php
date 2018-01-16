<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class LogDowngradePartner extends Model
{
    protected $table = 'tb_log_partner_downgrade';

    protected $fillable = array('user_id', 'userid', 'from_id', 'to_id', 'reason');

    public function DowngradePartner($partnerRow, $toId, $reason) {
        if (empty($partnerRow) || $reason == '') return false;
        if ($partnerRow->is_stockis <= $toId) return false;
        $data = array(
            'user_id'   => $partnerRow->id,
            'userid'    => $partnerRow->userid,
            'from_id'   => $partnerRow->is_stockis,
            'to_id'     => $toId,
            'reason'    => $reason
        );
        DB::beginTransaction();
        try {
            $this->insert($data);
            $partnerRow->update(['is_stockis' => $toId]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
