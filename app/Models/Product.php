<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProductDetail;


class Product extends Model {
    protected $table = 'product';
    protected $fillable = ['name', 'description', 'price', 'image', 'id_category', 'deleted'];

    public function details()
    {
        return $this->hasMany('App\Models\ProductDetail', 'id_product');
    }

    public static function getNewProduct($number) {
        return Product::take($number)->where('deleted', '=', 0)->get();
    }

    public static function numberProduct(){
        return Product::all()->where('deleted', '=', 0)->count();
    }

    // 
    public static function getAll(){
        return Product::where('deleted', '=', 0)->get();
    }
    // loc tat ca san pham

    public static function getAllProduct($page, $number, $domain){
        $start = $page * $number;
        return Product::where('deleted', '=', 0)
        ->whereBetween('price', $domain)
        ->skip($start)
        ->take($number)
        ->get();
    }

    // lay tat ca san pham co idsp
    public static function getProductByCategory($page, $number, $domain, $category){
        $start = $page * $number;
        return Product::where('deleted', '=', 0)
        ->whereBetween('price', $domain)
        ->where('id_category', '=', $category)
        ->skip($start)
        ->take($number)
        ->get();
    }

    // lay san pham sap xep tang dan

    public static function getProductIncrementByCate($page, $number, $domain, $category){
        $start = $page * $number;
        return Product::orderBy('price', 'DESC')
        ->where('deleted', '=', 0)
        ->whereBetween('price', $domain)
        ->where('id_category', '=', $category)
        ->skip($start)
        ->take($number)
        ->get();
    }
    public static function getProductIncrement($page, $number, $domain){
        $start = $page * $number;
        return Product::orderBy('price', 'DESC')
        ->where('deleted', '=', 0)
        ->whereBetween('price', $domain)
        ->skip($start)
        ->take($number)
        ->get();
    }

     // lay san pham sap xep giam dan
    public static function getProductDecrementByCate($page, $number, $domain, $category){
        $start = $page * $number;
        return Product::orderBy('price', 'ASC')
        ->where('deleted', '=', 0)
        ->whereBetween('price', $domain)
        ->where('id_category', '=', $category)
        ->skip($start)
        ->take($number)
        ->get();
    }

    public static function getProductDecrement($page, $number, $domain){
        $start = $page * $number;
        return Product::orderBy('price', 'ASC')
        ->where('deleted', '=', 0)
        ->whereBetween('price', $domain)
        ->skip($start)
        ->take($number)
        ->get();
    }

    // lay san pham phan trang tat ca sp
    public static function getPaginationAll($page, $number){
        $start = $page * $number;
        return Product::skip($start)
        ->take($number)
        ->where('deleted', '=', 0)
        ->get();
    }

    // lay san pham phan trang theo idsp
    public static function getPaginationCate($page, $number, $category){
        $start = $page * $number;
        return Product::skip($start)
        ->take($number)
        ->where('deleted', '=', 0)
        ->where('id_category', '=', $category)
        ->get();
    }

    // diem so luong san pham theo idsp
    public static function getNumberProduct($category, $domain){
        if($category)
            return Product::all()
            ->where('deleted', '=', 0)
            ->where('id_category', '=', $category)
            ->whereBetween('price', $domain)
            ->count();
        else    
            return Product::all()
            ->where('deleted', '=', 0)
            ->whereBetween('price', $domain)
            ->count();
    }

    // lay san pham theo loai sp
    public static function getProductOfCategory($id){
        return Product::where('id_category', '=', $id)
        ->where('deleted', '=', 0)
        ->get();
    }

    // lay san pham theo idsp
    public static function getProductById($id){
        return Product::find($id);
    }

    // lay san pham gia giam dan
    public static function getProductReduce(){
        return Product::where('deleted', '=', 0)->get();
    }


    // lay san pham cung loai

    public static function getProductSameType($id_category, $id_product){
        return Product::where('deleted', '=', 0)
        ->where('id_category', '=', $id_category)
        ->where('id_category', '<>', $id_product)
        ->get();
    }

    // tim kiem san pham theo ten
    public static function searchProduct($page, $number, $name){
        $start = $page * $number;
        return Product::where('deleted', '=', 0)
        ->where('name', 'like', '%'.$name.'%')
        ->skip($start)
        ->take($number)
        ->get();
    }

    public static function numberProductSearch($name){
        return Product::where('deleted', '=', 0)
        ->where('name', 'like', '%'.$name.'%')
        ->count();
    }

    // them moi san pham

    // xóa san pham
    public static function deleteProduct($id){
        return Product::find($id)
        ->update(['deleted' => 1]);
    }
    // cap nhat san pham

    public static function updateProduct($id, $data){
        return Product::find($id)
        ->update($data);
    }


    public static function getImage($id){
        return Product::where("id", "=", $id)->first()->image;
    }
    public static function getName($id){
        return Product::where("id", "=", $id)->first()->name;
    }

    public static function countProductOfCategory($id){
        return Product::where("id_category", '=', $id)->count();
    }

}
