<?php
namespace app\src\auth;

trait hashy
{
	public function getHash(string $str, string $salt = '')
	{
		return md5($str);
	}

	public function isHash(array $srcHash, string $hash)
	{
		return $this->getHash($srcHash['string'], $srcHash['salt']) === $hash;
	}
}