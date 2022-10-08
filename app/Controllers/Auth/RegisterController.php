<?php

namespace App\Controllers\Auth;

use App\Models\Account;
use App\Models\User;
use App\Controllers\Controller;
use App\SessionGuard as Guard;

class RegisterController extends Controller
{
	public function __construct()
	{
		if (Guard::isUserLoggedIn()) {
			redirect('/home');
		}

		parent::__construct();
	}

	public function showRegisterForm()
	{
		$data = [
			'old' => $this->getSavedFormValues(),
			'errors' => session_get_once('errors')
		];

		$this->sendPage('auth/register', $data);
	}

	public function register()
	{
		$this->saveFormValues($_POST, ['password', 'password_confirmation']);

		$data = $this->filterUserData($_POST);

		$model_errors = User::validate($data);
		
		if (empty($model_errors)) {
			// Dữ liệu hợp lệ...
			$id = $this->createUser($data)->id;
			$this->createAccount($data, $id);

			$messages = ['success' => 'User has been created successfully.'];
			redirect('/login', ['messages' => $messages]);
		}
		// Dữ liệu không hợp lệ...

		redirect('/register', ['errors' => $model_errors]);
	}

	protected function filterUserData(array $data)
	{
		return [
			'username' => $data['username'] ?? null,
			'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
			'password' => $data['password'] ?? null,
			'confirm' => $data['confirm'] ?? null,
			'telephone' => $data['telephone'] ?? null,
			'gender' => $data['gender'] ?? '',
			'birthdate' => $data['birthdate'],
			'avatar' => '../../img/none-avatar.png'
		];
	}

	protected function createUser($data)
	{
		return User::create([
			'email' => $data['email'],
			'birthdate' => $data['birthdate'],
			'gender' => $data['gender'],
			'avatar' => $data['avatar']
		]);
	}


	protected function createAccount($data, $id_user){
		return Account::create([
			'username' => $data['username'],
			'password' => md5($data['password']),
			'rule' => 'user',
			'id_user' => $id_user
		]);
	}
}
