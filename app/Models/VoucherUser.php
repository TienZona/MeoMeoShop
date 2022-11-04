<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherUser extends Model {
    protected $table = 'voucher_user';
    protected $fillable = ['voucher_id', 'user_id'];
    public $timestamps = false;

    protected function getAll(){
        return Voucher::all();
    }

    protected function getDetail($id){
        return VoucherUser::where('voucher_id', '=', $id)->get();
    }

    protected function getIdUser($id){
        return VoucherUser::where('voucher_id', '=', $id)->get('user_id');
    }

    protected function deleteUser($id){
        return VoucherUser::where('voucher_id', '=', $id)->delete();
    }

    protected function updateUser($id, $data){
        return VoucherUser::where('voucher_id', '=', $id)->update($data);
    }
}