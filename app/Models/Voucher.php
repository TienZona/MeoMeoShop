<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model {
    protected $table = 'voucher';
    protected $fillable = ['id', 'id_voucher', 'type', 'number', 'quantity', 'scope_product', 'scope_customer', 'start_date', 'expiry', 'deleted'];
    public $timestamps = false;

    protected function getAll(){
        return Voucher::all()->where('deleted', '=', 0);
    }

    protected function checkIdIsExist($id_voucher){
        return Voucher::where('id_voucher', '=', $id_voucher)->exists();
    }

    protected function getNewId(){
        return Voucher::all()->last()->id_voucher;
    }
    protected function getLastId(){
        return Voucher::all()->last()->id;
    }
    protected function deleteVoucher($id){
        return Voucher::where('id', '=', $id)->update(['deleted' => 1]);
    }

    protected function updateVoucher($id, $data){
        return Voucher::where('id', '=', $id)->update($data);
    }

}