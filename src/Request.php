<?php
namespace app\src;

/**
 * @property string $script - точка входа (index.php как правило)
 * @property array $prettyGet - "ЧПУ" параметры
 * @property array $getPars - GET параметры
*/
class Request
{
	public $script;
	public $prettyGet = false;
	public $getPars = false;

	public function __construct()
	{
		$request = $_SERVER['REQUEST_URI'];
		$this->script = $_SERVER['SCRIPT_NAME'];

		$this->parseRequest($request);
	}

	public function post(string $name)
	{
		return (isset($_POST[$name])) ? $_POST[$name] : false;
	}
	private function parseRequest(string $request)
	{
		$req = str_replace($this->script, '', $request);
		$req = trim($req, '/');		

		// @TODO comment it
		if ($req) { // есть, чего парсить в url (кроме адреса и скрипта)
			$req = explode('?', $req);

			$prettyGet = trim($req[0], '/');
			$this->prettyGet = explode('/', $prettyGet);

			// есть GET параметры (?foo=val1&bar=val2)
			if (1 < count($req)) {
				//list($prettyGet, $getPars) = $req;
				$getPars = $req[1];

				$getPars = explode('&', $getPars);
				$this->getPars = [];

				foreach($getPars as $teil) {
					$str = explode('=', $teil);

					if (1 === count($str)) {
						$str[] = false;
					}

					$this->getPars[$str[0]] = $str[1];
				}
			}
		}
	}
}