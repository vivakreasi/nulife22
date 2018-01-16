<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan_c_setting extends Model 
{
    protected $table = 'tb_plan_c_setting';

    protected $fillable = array('max_c_account', 'bonus_fly', 'cost_pkg', 'pin_ruby', 
                                'pin_saphire', 'pin_emerald', 'pin_diamond',
                                'pin_red_diamond', 'pin_blue_diamond',
                                'pin_white_diamond', 'pin_black_diamond', 
                                'multiple_queue', 'current_queue','product_id');

    //  default value
    private $_maxAccount        = 15;
    private $_bonusFly          = 1600000;
    private $_costPkg           = 600000;
    //private $_pinRuby           = 90000;
    //private $_pinSaphire        = 80000;
    //private $_pinEmerald        = 70000;
    //private $_pinDiamond        = 60000;
    //private $_pinRedDiamond     = 50000;
    //private $_pinBlueDiamond    = 40000;
    //private $_pinWhiteDiamond   = 30000;
    //private $_pinBlackDiamond   = 20000;
    private $_multipleQueue     = 6;

    public function getSetting() {
        return $this->first();
    }

    public function maxAccount($setting) {
        return empty($setting) ? $this->_maxAccount : $setting->max_c_account;
    }

    public function bonusFly($setting) {
        return empty($setting) ? $this->_bonusFly : $setting->bonus_fly;
    }

    public function costPkg($setting) {
        return empty($setting) ? $this->_costPkg : $setting->cost_pkg;
    }

    /*
    public function pinRuby($setting) {
        return empty($setting) ? $this->_pinRuby : $setting->pin_ruby;
    }

    public function pinSaphire($setting) {
        return empty($setting) ? $this->_pinSaphire : $setting->pin_saphire;
    }

    public function pinEmerald($setting) {
        return empty($setting) ? $this->_pinEmerald : $setting->pin_emerald;
    }

    public function pinDiamond($setting) {
        return empty($setting) ? $this->_pinDiamond : $setting->pin_diamond;
    }

    public function pinRedDiamond($setting) {
        return empty($setting) ? $this->_pinRedDiamond : $setting->pin_red_diamond;
    }

    public function pinBlueDiamond($setting) {
        return empty($setting) ? $this->_pinBlueDiamond : $setting->pin_blue_diamond;
    }

    public function pinWhiteDiamond($setting) {
        return empty($setting) ? $this->_pinWhiteDiamond : $setting->pin_white_diamond;
    }

    public function pinBlackDiamond($setting) {
        return empty($setting) ? $this->_pinBlackDiamond : $setting->pin_black_diamond;
    }
    */

    public function multipleQueue($setting) {
        return empty($setting) ? $this->_multipleQueue : $setting->multiple_queue;
    }

    private function getCurrentQueue($setting) {
        return empty($setting) ? 0 : $setting->current_queue;
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

    public function updateQueue($setting, $fly = false) {
        if (empty($setting)) return false;
        $current    = $this->getCurrentQueue($setting);
        $maxQueue   = $this->multipleQueue($setting);
        if ($fly) {
            $queue  = 0;
        } else {
            $queue      = $current + 1;
        }
        $values     = ['current_queue' => $queue];
        return $this->updateSetting($setting->id, $values);
    }

    public function needFly($setting, $plus = true) {
        $maxQueue   = $this->multipleQueue($setting);
        $current    = $this->getCurrentQueue($setting);
        if ($plus) return (($current + 1) >= $maxQueue);
        return ($current >= $maxQueuel);
    }
}

/*



*/