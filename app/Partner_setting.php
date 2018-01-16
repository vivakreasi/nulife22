<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner_setting extends Model
{
    protected $table = 'tb_partner_setting';

    protected $fillable = array('min_stockist_order', 'min_masterstockist_order', 'show_stockist_address', 'show_stockist_phone');

    public function getSetting()
    {
        return $this->first();
    }

    public function updateSetting($id, $values) {
        try {
            if (empty($id)) {
                $this->create($values);
            } else {
                $this->where('id', '=', $id)->update($values);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}

/*



*/