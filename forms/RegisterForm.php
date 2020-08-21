<?php
namespace app\forms;

use app\src\Main;
use app\src\db\Connect;
use app\forms\Forms;

use app\src\auth\hashy;

final class RegisterForm extends Forms
{
	use hashy;

	public $table = 'users';
	public $login;
	public $name;
	public $email;
	public $password;
	public $retype;
	
	public $send;

	private $db;

	protected function init()
	{
		$req = Main::app()->request;
		$this->db = Connect::getInstance();

		$this->login = $req->post('login');
		$this->name = $req->post('name');
		$this->email = $req->post('email');
		$this->password = $req->post('password');
		$this->retype = $req->post('retype');

		$this->send = $req->post('register');
	}

	protected function validators()
	{
		return [
			'login' => function ($value, $name) {
				$err = [];
				$value = trim($value);

				if (!$value) {
					$this->addError($name, 'Empty Login');
					return ;
				}

				if (strlen($value) < 5) {
					$this->addError($name, 'Login is too short');
					return ;
				}

				if (64 < strlen($value)) {
					$this->addError($name, 'Login is too large');
					return ;
				}

				$this->uniqueLogin($value, $name);
			},
			'email' => function ($value, $name) {
				$err = [];
				$value = trim($value);

				if (!$value) {
					$this->addError($name, 'Empty Email');
					return ;
				}

				if (!filter_var($value, FILTER_VALIDATE_EMAIL) ) {
					$this->addError($name, 'Email is invalid');
					return ;
				}

				$this->uniqueEmail($value, $name);
			},
			'password' => function($value, $name) {
				$err = [];
				$value = trim($value);

				if (!$value) {
					$this->addError($name, 'Empty Password');
					return ;
				}

				if ( $this->password != $this->retype ) {
					$this->addError($name, 'Password != Retype Password');
				}
			},
		];
	}

	private function uniqueLogin($value, $name)
	{
		$sql = 'SELECT `user_id` FROM `users` WHERE `user`=:user';
		$data = [
			':user' => $value,
		];
		$res = $this->db->select($sql, $data);

		if ($res) {
			$this->addError($name, 'Any other login?');
		}
	}

	private function uniqueEmail($value, $name)
	{
		$sql = 'SELECT `user_id` FROM `users` WHERE `email`=:email';
		$data = [
			':email' => $value,
		];
		$res = $this->db->select($sql, $data); 

		if ($res) {
			$this->addError($name, 'Any other email?');
		}
	}
}