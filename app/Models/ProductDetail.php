<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class ProductDetail extends Model {
    protected $table = 'product_detail';
    protected $fillable = ['id_product', 'color', 'size', 'number'];

    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo('Product');
    }

    public static function getDetail($id) {
        return ProductDetail::where('id_product', '=', $id)->get();
    }

    public static function updateDetail($id, $data){
        return ProductDetail::where("id_product", '=', $id)
        ->update($data);
    }

    public static function deleteDetail($id){
        return ProductDetail::where("id_product", "=", $id)->delete();
    }

    public static function addDetail($data){
        return ProductDetail::create($data);
    }

    public static function getAllDetail($id){
        return ProductDetail::where("id_product", "=", $id)
        ->distinct()->get();
    }

    public static function getAllColor($id){
        return ProductDetail::where("id_product", "=", $id)
        ->distinct()->get('color');
    }

    public static function getAllSize($id){
        return ProductDetail::where("id_product", "=", $id)
        ->distinct()->get('size');
    }
}