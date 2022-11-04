<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// 0 = waiting, 1 = confirm, 2 = cancel, 3 = transport, 4 = success
class Order extends Model {
    protected $table = 'order';
    protected $fillable = ['name', 'telephone', 'total_price', 'address', 'address_detail', 'state', 'date_ship', 'message', 'note', 'deleted', 'id_user'];
    public $timestamps = false;

    protected function getAll(){
        return $this::all();
    }

    protected function getConfirm(){
        return $this::where("state" , "=", 1)
        ->orderBy('id', 'desc')
        ->get();
    }

    protected function getConfirmByIdUser($id){
        return $this::where("id_user", '=', $id)
        ->where("state" , "=", 1)
        ->orderBy('id', 'desc')
        ->get();
    }

    protected function getWaiting(){
        return $this::where("state", "=", 0)
        ->orderBy('id', 'desc')
        ->get();
    }
    protected function getWaitingByIdUser($id){
        return $this::where("id_user", "=", $id)
        ->where("state", "=", 0)
        ->orderBy('id', 'desc')
        ->get();
    }

    protected function getTransport(){
        return $this::where("state", "=", 3)
        ->orderBy('id', 'desc')
        ->get();
    }

    protected function getTransportByIdUser($id){
        return $this::where("id_user", "=", $id)
        ->where("state", "=", 3)
        ->orderBy('id', 'desc')
        ->get();
    }

    protected function getSuccess(){
        return $this::where("state", "=", 4)
        ->orderBy('id', 'desc')
        ->get();
    }

    protected function getRatingByIdUser($id){
        return $this::where("id_user", '=', $id)
        ->where("state" , "=", 4)
        ->orderBy('id', 'desc')
        ->get();
    }

    protected function getCancel(){
        return $this::where("state", "=", 2)->get();
    }

    protected function confirmOrder($id){
        return $this::find($id)->update(["state" => 3]);
    }

    protected function cancelOrder($id){
        return $this::find($id)->update(["state" => 2]);
    }

    // $sql = "SELECT `total_price` FROM `order` WHERE MONTH(`date_create`)=$month and YEAR(`date_create`)=$year";

    protected function getTotalOfMonth($year, $month){
        $result = $this::whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', $month)
        ->get();
        $total = 0;
        foreach($result as $item){
            $total += $item->total_price;
        }
        return $total;
    }

    protected function getNumberOrderOfMonth($year, $month){
        return $this::whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', $month)
        ->count();
    }

    protected function getNumberOrderSell($year, $month){
        return $this::where('state', '=', 3)
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', $month)
        ->get();
    }

    protected function createOrder($order){
        return $this::create($order);
    }

    protected function getOrderOfUser($id){
        return $this::where("id_user", '=', $id)->orderBy('id', 'DESC')->get();
    }

    protected function getIdUser($id){
        return $this::where("id", '=', $id)->get()->first()->id_user;
    }
}