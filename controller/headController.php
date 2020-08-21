<?php
namespace app\controller;

use app\src\Controller;
use app\src\db\Connect;
use app\src\auth\User;

final class headController extends Controller
{
	public function index($config = null)
	{
		$db = Connect::getInstance();

		$sql = 'SELECT `user_id`, `email` FROM `users` WHERE `user_id`=:user_id';
		
		$query = $db->select($sql, [
			':user_id' => (int) $this->uid,
		]);

		return $this->render('index', [
			'query' => $query,
		]);
	}

	public function page()
	{
		return $this->render('page');
	}
}