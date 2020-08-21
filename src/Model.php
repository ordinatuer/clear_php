<?php
namespace app\src;

/**
 * Список ошибок, валидность, доступ к полям
 */
abstract class Model
{
	protected $errors = [];
	protected $_isValid = true;

	public function getErrors()
	{
		return $this->errors;
	}

	public function isValid()
	{
		return $this->_isValid;
	}

	public function val(string $name)
	{
		return ( $this->$name ) ? $this->$name : '' ; 
	}

	public function addError($name, $errorText)
	{
		if ( isset($this->errors[$name])) {
			array_push($this->errors[$name], $errorText);
		} else {
			$this->errors[$name] = [$errorText];
		}

		$this->_isValid = false;
	}

	abstract protected function validators();
	abstract protected function init();

	protected function validate()
	{
		foreach($this->validators() as $name => $validator) {
			$validator($this->$name, $name);
		}
	}
}
