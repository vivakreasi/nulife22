<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    /*  define tablename */
    protected $table = 'users_type';

    protected $fillable = array('id', 'code', 'desc', 'short_desc', 'left_target', 'right_target');

    public function getDataByCode($code) {
        return $this->where('code', '=', $code)->first();
    }

    public function getTarget($row, $target) {
        if (empty($row) || !in_array($target = strtolower($target), ['left', 'right'])) return 0;
        return intval($row->{$target . '_target'});
    }

    public function getNextTarget($rowsRanking) {
        if (empty($rowsRanking)) return null;
        $target = null;
        foreach ($rowsRanking as $row) {
            if ($row->id > $this->id && $row->left_target > $this->left_target && $row->right_target > $this->right_target) {
                $target = $row;
                break;
            }
        }
        return $target;
    }
}
