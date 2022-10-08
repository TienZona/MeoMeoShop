<?php

namespace App\Controllers\Auth;

use App\Models\Account;
use App\Controllers\Controller;
use App\SessionGuard as Guard;

class LoginController extends Controller
{
	public function showLoginForm()
	{
		if (Guard::isUserLoggedIn()) {
			redirect('/home');
		}

		$data = [
			'messages' => session_get_once('messages'),
			'old' => $this->getSavedFormValues(),
			'errors' => session_get_once('errors')
		];

		$this->sendPage('auth/login', $data);
	}

	public function login()
	{
		$user_credentials = $this->filterUserCredentials($_POST);
		$errors = [];
		$account = Account::findUsername($user_credentials['username']);

		if (!$account) {
			// Người dùng không tồn tại...
			$messages = ['error' => 'Tên đăng nhập không tồn tại !!'];
			redirect('/login', ['messages' => $messages]);
		} else if (Guard::login($account, $user_credentials)) {
			// Đăng nhập thành công...
			$messages = ['success' => 'Đăng nhập thành công !!'];
			redirect('/home', ['massage' => $massage]);
		} else {
			// Sai mật khẩu...
			$messages = ['error' => 'Tên đăng nhập hoặc mật khẩu không đúng.'];
		}

		$this->saveFormValues($_POST, ['password']);
		redirect('/login', ['messages' => $messages]);
	}

	public function logout()
	{
		Guard::logout();
		redirect('/login');
	}

	protected function filterUserCredentials(array $data)
	{
		return [
			'username' => $data['username'] ?? null,
			'password' => $data['password'] ?? null
		];
	}
}
