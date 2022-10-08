<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Product;
use App\Models\Account;


class AccountController extends Controller
{
	public function __construct()
	{
		if (!Guard::isAdminLoggedIn()) {
			redirect('/login');
		}

		parent::__construct();
	}

    public function index(){
        $accounts = Account::getAll();
        $this->sendPage('admin/account', [
            "accounts" => $accounts
		]); 
    }

    public function updateAccount(){
        $data = $this->filterDataAccount($_POST);
        $id = $_GET['id'] ?? null;

        $messages = [];
        if(Account::updateAccount($id, $data)){
            $messages = ['success' => 'Cập nhật mật khẩu thành công!'];
        }else{
            $messages = ['error' => 'Cập nhật mật khẩu thất bại!'];
        }
        redirect('/admin/account', ['messages' => $messages]);
    }

    public function deleteAccount(){
        $id = $_GET['id'] ?? null;
        $messages = [];
        if($id == 1){
            $messages = ['error' => 'Không thể xóa tài khoảng admin!'];
        }else{
            if(Account::deleteAccount($id) && $id != 1){
                $messages = ['success' => 'Xóa tài khoảng thành công!'];
            }else{
                $messages = ['error' => 'Không thể xóa tài khoảng này!'];
            }
        }
        
        redirect('/admin/account', ['messages' => $messages]);
    }

    protected function filterDataAccount(array $data)
	{
		return [
			'username' => $data['username'] ?? null,
			'password' =>  $data['password'] ?? null,
			'confirm_pw' => $data['confirm'] ?? null,
		];
	}
}
