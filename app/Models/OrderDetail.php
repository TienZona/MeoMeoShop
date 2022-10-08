<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {
    protected $table = 'order_detail';
    protected $fillable = ['total', 'quantity', 'color', 'size', 'id_product', 'id_order'];
    public $timestamps = false;

    protected function getAll(){
        return $this::all();
    }


    protected function getOrderByIdProduct($id){
        return $this::where('id_product', '=', $id);
    }

    protected function getOrderByIdOrder($id){
        return $this::where('id_order', '=', $id)->get();
    }

    protected function getNumberProductOfOrder($id){
        $details = $this::where('id_order', '=', $id)->get();
        $number = 0;
        foreach($details as $detail){
            $number += $detail->quantity;
        }
        return $number;
    }

    protected function createOrderDetail($data){
        return $this->create($data);
    }

    protected function getOrderDetail($id){
        return $this->where('id_order', '=', $id)->get();
    }
}