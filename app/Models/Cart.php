<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    protected $table = 'cart';
    protected $fillable = ['id_user', 'id_product', 'quantity', 'color', 'size'];

    public $timestamps = false;

    public static function getAll(){
        return $this::all();
    }

    public static function createCart($data){
        return Cart::create([
            'id_user' => $data['id_user'],
            'id_product' => $data['id_product'],
            'quantity' => $data['quantity'],
            'color' => $data['color'],
            'size' => $data['size']
        ]);
    }

    public static function getCartByIdUser($id){
        return Cart::where('id_user', '=', $id)->get();
    }

    public static function getCartByIdUserCount($id){
        return Cart::where('id_user', '=', $id)->count();
    }

    public static function deleteCart($data){
        return Cart::where($data)->delete();
    }

    public static function updateCart($data){
        return Cart::where(
            [
                "id_product" => $data['id_product'],
                "id_user" => $data['id_user'],
                "color" => $data['color'],
                "size" => $data['size']
            ]
        )->update($data);
    }

}