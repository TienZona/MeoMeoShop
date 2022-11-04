<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['id_user', 'fullname', 'email', 'gender', 'birthdate', 'address', 'telephone', 'avatar', 'created_at'];

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function users()
    {
        return $this->hasMany('App\Models\CommentReply');
    }

    public static function validate(array $data) {
        $errors = [];

        if(! $data['username']) {
            $errors['username'] = 'Vui lòng điền tên đăng nhập.';
        } elseif (Account::where('username', $data['username'])->count() > 0) {
            $errors['username'] = 'Tên tài khoảng đã được sử dụng.';
        }    
        

        if (! $data['email']) {
            $errors['email'] = 'Vui lòng điền Email.';
        } elseif (static::where('email', $data['email'])->count() > 0) {
            $errors['email'] = 'Email đã được sử dụng.';
        }    

        if (strlen($data['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải lơn hơn hoặc bằng 6 ký tự.';
        } elseif ($data['password'] != $data['confirm']) {
            $errors['password'] = 'Mật khẩu không khớp.';
        }

        if($data['gender'] == ''){
            $errors['gender'] = 'Vui lòng chọn giới tính';
        }
        return $errors;
    }   

    public static function getUser($id){
        return User::find($id);
    }

    // lay tat ca thong tin nguoi dung
    public static function getAll(){
        return User::all();
    }

    // cap nhat thong tin nguoi dung
    public static function updateUser($id, $data){
        return User::where('id', '=', $id)
        ->update($data);
    }

    public static function deleteUser($id){
        return User::find($id)->delete();
    }

    public static function updateAvatar($id, $avatar){
        return User::where('id', '=', $id)
        ->update(["avatar" => $avatar]);
    }

}
