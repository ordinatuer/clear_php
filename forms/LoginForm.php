<?php
namespace app\forms;

use app\src\Main;
use app\forms\Forms;

final class LoginForm extends Forms
{
	public $email;
	public $password;
        
	protected function init()
	{
		$request = Main::app()->request;

		$this->email = trim($request->post('email'));
        $this->password = trim($request->post('password'));

        $this->send = $request->post('login');
	}

	protected function validators()
	{
		return [
			'email' => function($value, $name) {
				if(!$value) {
					$this->addError($name, 'Empty email');
					return ;
				}
			},
			'password' => function($value, $name) {
				
			}
		];
	}
	
}