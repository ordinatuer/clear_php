<?php
namespace app\src;

use app\src\Request;

class Main
{
	public $request;

	public function __construct($config)
	{
		self::$instance = $this;

		$this->config = $config;
		$this->run();
	}

	public static function app()
	{
		return self::$instance;
	}

	private static $instance = false;

	private $config;

	public function config(string $key1 = '', string $key2 = '')
	{
		$keys = explode('.', $key1);
		$n = count($keys);

		if (1 < $n) {
			$k = array_shift($keys);
			$val = $this->config[$k];

			foreach($keys as $key) {
				$val = $val[$key];
			}

			return $val;
		} else {
			if ($key1 && $key2) {
				return $this->config[$key1][$key2];
			} else if ($key1) {
				return $this->config[$key1];
			} else {
				return $this->config;
			}
		}
	}

	public function run()
	{
		session_start();
		$request = new Request();

		$controller = (isset($request->prettyGet[0])) ? $request->prettyGet[0] : $this->config('url', 'controller');
		$action = (isset($request->prettyGet[1])) ? $request->prettyGet[1] : $this->config('url', 'action');

		$class = "app\\controller\\" . $controller.'Controller';

		if (!class_exists($class) OR !method_exists($class, $action)) {
			$this->error404();
		}

		$this->request = $request;
		
		echo (new $class($this->config))->$action();
	}

	public function error404()
	{
		http_response_code(404);

		require $this->config('path', 'root') . DIRECTORY_SEPARATOR . '404.php';
		die();
	}
}