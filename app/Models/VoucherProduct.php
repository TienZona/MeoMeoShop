<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherProduct extends Model {
    protected $table = 'voucher_product';
    protected $fillable = ['voucher_id', 'product_id'];
    public $timestamps = false;

    protected function getAll(){
        return VoucherProduct::all();
    }

    protected function getDetail($id){
        return VoucherProduct::where('voucher_id', '=', $id)->get();
    }

    protected function getIdProduct($id){
        return VoucherProduct::where('voucher_id', '=', $id)->get('product_id');
    }
}