<?php

namespace App;

trait UserRoles
{
    public function isMember() {
        return ($this->id_type < 100);
    }

    public function isAdmin() {
        return ($this->id_type && $this->id_type >= 100 && $this->id_type < 200);
    }

    public function isStockis() {
        return ($this->is_stockis == 1 || $this->is_stockis == 2);
    }
    
    public function isMasterStockis() {
        return ($this->is_stockis == 2);
    }

    public function isDeveloper() {
        return ($this->id_type && $this->id_type == 200);
    }

    public function isAdminAll() {
        if (!$this->id) return false;
        return ($this->id_type == 100);
    }

    public function isAdminInventory() {
        if (!$this->id) return false;
        return ($this->isAdminAll() || $this->id_type == 101);
    }

    public function isAdminPIN() {
        if (!$this->id) return false;
        return ($this->isAdminAll() || $this->id_type == 102);
    }

    public function isAdminWithdrawal() {
        if (!$this->id) return false;
        return ($this->isAdminAll() || $this->id_type == 103);
    }

    public function isAdminDelivery() {
        if (!$this->id) return false;
        return ($this->isAdminAll() || $this->id_type == 104);
    }

    public function isAdminCS() {
        if (!$this->id) return false;
        return ($this->isAdminAll() || $this->id_type == 105);
    }

    private $kodeAdmin = array(
        100 => 'isAdminAll',
        101 => 'isAdminInventory',
        102 => 'isAdminPIN',
        103 => 'isAdminWithdrawal',
        104 => 'isAdminDelivery',
        105 => 'isAdminCS',
    );

    private function getAdminFunctionByType() {
        if (!$this->id) return '';
        $type = intval($this->id_type);
        return array_key_exists($type, $this->kodeAdmin) ? $this->kodeAdmin[$type] : '';
    }

    //  role by routname
    private $roleGroup = array(
        //  inventory
        101 => array(
            'admin.inventory.product',
            'admin.inventory.claima',
            'admin.inventory.claimb',
            'admin.inventory.claimc',
        ),
        //  pin
        102 => array(
            'pin.list',
            'admin.pin.list',
            'admin.pin.report'
        ),
        //  wd
        103 => array(
            'admin.member.not.wd.list',
            'admin.planc.wd',
            'admin.planc.wd.leadership',
            'admin.nucash.wd.list',
            'admin.plan.reward',
            'admin.ajax.structure'
        ),
        //  CS
        105 => array(
            'admin.plan.upgrade',
            'admin.pinc.order',
            'admin.pinc.order.address',
            'pin.list',
            'admin.partner.become'
        ),
    );

    private function RouteExistInRole($routname) {
        $idType = intval($this->id_type);
        if (!array_key_exists($idType, $this->roleGroup)) return false;
        $role = $this->roleGroup[$idType];
        return in_array($routname, $role);
    }

    public function hasAccessRoute($routname) {
        if (!$this->id) return false;
        $fn = $this->getAdminFunctionByType();
        if ($fn == '') return false;
        return ($fn == 'isAdminAll') || ($this->$fn() && $this->RouteExistInRole($routname));
    }
}
