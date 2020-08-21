<?php
namespace app\src\auth;

use app\src\db\Connect;
use app\src\Model;
use app\forms\RegisterForm;
use app\forms\LoginForm;

use app\src\auth\hashy;


class User extends Model
{
	use hashy;

	public $user_id = false;
	public $user;
	public $username;
	public $email;
	public $password;

    private $db;
    private static $instance = false;

    private function __construct()
    {
        $this->init();
    }

    protected function init()
    {
    	$this->db = Connect::getInstance();
    }

    public static function getInstance()
    {
    	if (false === self::$instance) {
    		self::$instance = new self();
    	}

    	return self::$instance;
    }

    public function add(RegisterForm $form)
    {
    	$data = [
			'user' => $form->login,
			'username' => $form->name,
			'email' => $form->email,
			'password' => $this->getHash($form->password),
		];

		foreach($data as $name => $value) {
			$this->$name = $value;
		}
		
		$add = $this->db->insert('users', $data, true);
		$this->user_id = $add;

		return (bool) $add;
    }

    public function login(LoginForm $form)
    {
    	$sql = 'SELECT `user_id`, `user`, `username`, `email` FROM `users` WHERE ';
    	$sql .= '`email`=:email AND `password`=:pass';

    	$pass = $this->getHash($form->password);

    	$data = [
    		':email' => $form->email,
    		':pass' => $pass,
    	];

    	$res = $this->db->select($sql, $data);

    	if ($res) {
    		$this->setUserData($res[0]);

    		return true;
    	} else {
    		$this->addError('email', 'Incorrect authorization data');
    		return false;
    	}
    }

    public function logout()
    {
    	$this->unsetUserData();
    }
    public function unsetUserData()
    {
    	$names = $this->names();
    	foreach($names as $name) {
    		unset($this->$name, $_SESSION[$name]);
    	}	
    	$this->user_id = false;
    }

    private function setUserData($data)
    {
    	$names = $this->names();
    	foreach($names as $name) {
    		$this->$name = $data[$name];
    		$_SESSION[$name] = $this->$name;
    	}
    }

    protected function validators()
    {
    	return [

    	];
    }

    private function names()
    {
    	return [
    		'user_id',
    		'user',
    		'username',
    		'email',
    	];
    }
}