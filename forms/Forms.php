<?php
namespace app\forms;

use app\src\Model;

abstract class Forms extends Model
{
	public $send = false;
	/**
	 * Инициализация формы, а после - валидация
	 */
	public function __construct()
	{
		$this->init();
		
		if ($this->send) {
			$this->validate();
		}
	}
}