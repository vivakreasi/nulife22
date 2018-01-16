<?php

namespace App;

use Bregananta\Inventory\Models\InventoryStock;
use Illuminate\Database\Eloquent\Model;

class ProductClaim extends Model
{
    protected $table = 'tb_product_claims';
    protected $fillable = array('user_id', 'inv_trans_id', 'userid', 'type', 'code', 'sequence', 'status', 'delivered_quantity',
        'delivery_awb', 'delivery_name', 'delivery_address', 'delivery_city', 'delivery_province', 'delivery_zip_code',
        'delivery_phone');

    public function getProductClaimListB($type = 'B', $status = 1)
    {
        return $this
            ->selectRaw('tb_product_claims.created_at, tb_product_claims.code, tb_product_claims.userid, tb_product_claims.delivery_name, tb_product_claims.delivery_address, tb_kota.nama_kota')       
            ->leftJoin('tb_kota','tb_kota.id','=','tb_product_claims.delivery_city')
            ->leftJoin('tb_provinces','tb_provinces.id','=','tb_product_claims.delivery_province')
            ->where('type','=',$type)
            ->where('status','=',$status)
            ->get();
    }

    public function getProductClaimListC($type = 'C', $status = 1)
    {
        return $this
            ->selectRaw('tb_product_claims.created_at, tb_product_claims.code, tb_product_claims.userid, tb_product_claims.delivery_name, tb_product_claims.delivery_address, tb_kota.nama_kota')       
            ->leftJoin('tb_kota','tb_kota.id','=','tb_product_claims.delivery_city')
            ->leftJoin('tb_provinces','tb_provinces.id','=','tb_product_claims.delivery_province')
            ->where('type','=',$type)
            ->where('status','=',$status)
            ->get();
    }

}
