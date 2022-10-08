<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\User;
use App\Models\Account;

class ProfileController extends Controller
{
	public function __construct()
	{
		if (!Guard::isUserLoggedIn()) {
			redirect('/login');
		}

		parent::__construct();
	}

	public function index()
	{

		if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
            $user = User::getUser($id);

            $this->sendPage('profile', [
                'user' => $user
            ]); 
        }else{
            $messages = ['error' => 'Vui lòng đăng nhập để xem thông tin tài khoảng.'];
			redirect('/home', ['messages' => $messages]);
        }
	}

    public function updateUser(){
        $data = $this->filterUserData($_POST);
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if(User::updateUser($id, $data)){
                $messages = ['success' => 'Cập nhật thông tin thành công!'];
            }else{
                $messages = ['error' => 'Cập nhật thông tin thất bại!'];
            }
        }

        redirect('/profile', ['messages' => $messages]);
    }

    public function updateAvatar(){
        include 'upload.php';
        if($uploadOk && isset($_GET['id'])){
            $id = $_GET['id'];
            $avatar = '../../img/'. $_FILES["file"]["name"];
            User::updateAvatar($id, $avatar);
            echo $avatar;
            $messages = ['success' => 'Cập nhật ảnh đại diện thành công!'];
        }
        redirect('/profile', ['messages' => $messages]);
    }

    public function updatePassWord(){
        $data = $this->filterUserData($_POST);
        if(isset($_GET['id']) && Account::updateAccount($_GET['id'], $_POST)){
            $messages = ['success' => 'Cập nhật thông tin thành công!'];
        }else{
            $messages = ['error' => 'Cập nhật thông tin thất bại!'];
        }
        redirect('/profile', ['messages' => $messages]);
    }

    protected function filterUserData(array $data)
	{
		return [
			'fullname' => $data['fullname'] ?? null,
			'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
			'gender' => $data['gender'] ?? null,
			'birthdate' => $data['birthdate'] ?? null,
			'address' => $data['address'] ?? null,
			'telephone' => $data['telephone'] ?? ''
		];
	}

    protected function filterAccountData(array $data)
	{
		return [
			'password_old' => $data['password_old'] ?? null,
			'password' => $data['password_new'] ?? null,
			'confirm' => $data['confirm'] ?? null,
		];
	}

}
