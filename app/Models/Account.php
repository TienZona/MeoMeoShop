<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    protected $table = 'account';
    protected $fillable = [ 'username', 'password', 'rule', 'date_create', 'id_user'];

    public static function validate(array $data) {
        $errors = [];

        if(! $data['username']) {
            $errors['username'] = 'Vui lòng điền tên đăng nhập.';
        } elseif (static::where('username', $data['username'])->count() > 0) {
            $errors['username'] = 'Tên tài khoảng đã được sử dụng.';
        }    
        
        if (strlen($data['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải lơn hơn hoặc bằng 6 ký tự.';
        } elseif ($data['password'] != $data['password_confirmation']) {
            $errors['password'] = 'Mật khẩu không khớp.';
        }

        if($data['gender'] == ''){
            $errors['gender'] = 'Vui lòng chọn giới tính';
        }

        return $errors;
    }   

    public static function findUsername($username) {
        return Account::where('username','=', $username)->first();
    }

    public static function getAll(){
        return Account::all();
    }

    public static function updateAccount($id, $data){
        return Account::where('id', '=', $id)
        ->update(['password' => md5($data['password'])]);
    }

    public static function deleteAccount($id){
        return Account::find($id)->delete();
    }

    public static function getAccountByIdUser($id){
        return Account::where('id_user', '=', $id)->first();
    }
}