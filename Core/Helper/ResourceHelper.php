<?php
namespace Core\Helper;

use Core\Helper\ListHelper;

class ResourceHelper
{
	public function redirect($strRota)
	{
		header("Location: $strRota");
	}

	public function getAll()
	{
		return $_GET;
	}

	public function postAll()
	{
		return $_POST;
	}

	public function getHost()
	{
		$strScheme = empty($_SERVER['REQUEST_SCHEME']) ? 'http' : $_SERVER['REQUEST_SCHEME'];
		
		return $strScheme ."://". $_SERVER['HTTP_HOST'];
	}

	public function getUrl($index = null)
	{
		$str = $_SERVER['REQUEST_URI'];
		$strReplace = "\/".loadConfig('ROTA_APELIDO')."\/";
		$str = preg_replace(["/$strReplace/"], "", $str);

		if($str === '')
			return null;

		if($str[0] === "/")
			$str = preg_replace(["/\//"], '', $str, 1);

		$arrUrl = explode("/", $str);

		$listUrl = new ListHelper($arrUrl);

		if($listUrl->last() === '')
			$listUrl->pop();

		$arrUrl = $listUrl->all();

		if($index === null)
			return $arrUrl;
		else
			return sizeof($arrUrl) > $index ? $arrUrl[$index] : null;
	}

	public function getController()
	{
		$arr = $this->getUrl();

		if(sizeof($arr) > 0)
			return $arr[0];
		else
			return null;
	}
}