<?php
namespace app\src\db;

use app\src\Main;

class Connect
{
	private $link;
	private static $instance = false;

	private function __construct()
	{
		$config = Main::app()->config('db');
		$dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'];
		$this->link = new \PDO($dsn, $config['username'], $config['password']);
	}

	static public function getInstance()
	{
		if (false === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function insert(string $table, array $data, bool $lastInsertId = false)
	{
		$sql = "INSERT INTO `$table` SET ";

		$add = [];
		$values = [];

		foreach ($data as $field => $value) {
			$add[] =  $field . '=:' . $field;
			$values[':'.$field] = $value;
		}

		$str = implode(', ', $add);
		$sql .= $str;

		$query = $this->link->prepare($sql);

		foreach($values as $key => &$value) {
			$query->bindParam($key, $value);
		}

		$addFlag = $query->execute();

		if ($lastInsertId AND $addFlag) {
			return $this->link->lastInsertId();
		} else {
			return $addFlag;	
		}
	}

	public function select($sql, $data = [])
	{
		$query = $this->link->prepare($sql);

		foreach($data as $key => &$value) {
			$query->bindParam($key, $value);
		}

		$query->execute();
		$query->setFetchMode(\PDO::FETCH_ASSOC);

		return $query->fetchAll();
	}

	public function update()
	{
		return false;
	}
	public function delete()
	{
		return false;
	}
}