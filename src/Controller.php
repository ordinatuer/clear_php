<?php
namespace app\src;

use app\src\Main;

class Controller
{
	const DIR_VIEW = 'views';
	public $uid = false;
	private $root;
	private $layout;

	public function __construct()
	{
		$app = Main::app();

		$this->root = $app->config('path', 'root');
		$this->layout = $app->config('layout');

		$this->uid = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : false;
	}
	/**
	 * @param string $view - файл отображения
	 * @param array $data - данные для отображения
	*/
	public function render(string $view, array $data = [])
	{
		$content = $this->renderPart($view, $data);
		
		return $this->renderPart($this->layout, [
			'content' => $content, 
		]);
	}

	public function renderPart(string $view, array $data = [])
	{
		$file = $this->getViewFile($view);

		foreach ($data as $key => $value)
		{
			$$key = $value;
		}
		
		ob_start();
		require $file;
		$string = ob_get_contents();
		ob_end_clean();

		return $string;
	}


	private function getViewFile(string $view)
	{
		// $class = get_class($this);
		// $class = explode('\\', $class);

		$file = implode(DIRECTORY_SEPARATOR, [
			$this->root,
			//$class[count($class)-1],
			static::DIR_VIEW,
			$view
		]);

		return $file . '.php';
	}
}