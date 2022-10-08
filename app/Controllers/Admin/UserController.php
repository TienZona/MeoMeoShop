<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\User;


class UserController extends Controller
{
	public function __construct()
	{
		if (!Guard::isAdminLoggedIn()) {
			redirect('/login');
		}

		parent::__construct();
	}

	public function index()
	{
		$users = User::getAll();
        $this->sendPage('admin/user', [
            "users" => $users
		]); 
	}


    public function updateUser(){
        $data = $this->filterDataUser($_POST);
        $id = $_GET['id'] ?? null;

        $messages = [];
        if(User::updateUser($id, $data)){
            $messages = ['success' => 'Cập nhật thông tin người dùng thành công!'];
        }else{
            $messages = ['error' => 'Cập nhật thông tin người dùng thất bại!'];
        }
        redirect('/admin/user', ['messages' => $messages]);
    }

    public function deleteUser(){
        $messages = ['error' => 'Không thể xóa người dùng!!'];

        redirect('/admin/user', ['messages' => $messages]);
    }

    protected function filterDataUser(array $data)
	{
		return [
			'avatar' => $data['avatar'] ?? null,
            'fullname' => $data['fullname'] ?? null,
            'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
            'gender' => $data['gender'] ?? null,
            'birthdate' => $data['birthdate'] ?? null,
            'address' => $data['address'] ?? null,
            'telephone' => $data['telephone'] ?? null
		];
	}
}
