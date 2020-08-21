<?php
namespace app\controller;

use app\src\Controller;
use app\src\auth\User;

final class userController extends Controller
{
	public function register()
	{	
		$reg = new \app\forms\RegisterForm();

		$message = '';
		$form = '';
		$add = false;

		if ($reg->send) {
			if (!$reg->isValid()) {
				$message = $this->renderPart('parts/errors', ['errors' => $reg->getErrors()]);
			} else {
				$user = User::getInstance();
				$add = $user->add($reg);

				if ($add) {
					$message = $this->renderPart('parts/accept', ['user' => $user]);
				}
			}
		}

		if (!$add) {
			$form = $this->renderPart('parts/register-form', ['form' => $reg]);	
		}

		return $this->render('register', [
			'form' => $form,
			'message' => $message,
		]);
	}

	public function login()
	{
		$auth = new \app\forms\LoginForm;
		$message = '';

		if ($auth->send) {
			$user = User::getInstance();
			$login = $user->login($auth);

			if ($login) {
				$this->uid = $user->user_id;
			} else {
				$message = $this->renderPart('parts/errors', ['errors' => $user->getErrors()]);
			}
		}

		return $this->render('login', [
			'message' => $message,
		]);
	}

	public function logout()
	{
		$message = '';
		$user = User::getInstance();
		$user->logout();
		$this->uid = false;

		return $this->render('login', [
			'message' => $message,
		]);
	}
}