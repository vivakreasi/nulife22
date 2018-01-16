<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pin_setting extends Model
{
    protected $table = 'tb_pin_type';

    protected $fillable = array('pin_type_name', 'business_rights_amount', 'pin_type_price', 'pin_type_stockis_price', 'pin_type_masterstockis_price');

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