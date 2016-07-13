<?php
	if(session_status() == PHP_SESSION_NONE)
		session_start();
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	define('PAGES_SRC', 'View/');
	define('LAYOUT_SRC', PAGES_SRC . 'layout/');
	define('CORE_STORAGE', 'Core/Storage/');
	define('CORE_STORAGE_VIEW', CORE_STORAGE . 'View/');
	define('CORE_STORAGE_DATABASE', CORE_STORAGE . 'Database/');

	define('PDO_NOT_DATABASE_EXISTS', 1049);

	use Core\Route;
	use Core\Helper\ResourceHelper;

	/*
	*@date 21/03/2016
	*@return
	*@description AUTOLOAD CLASSES
	*/
	spl_autoload_register(function ($strClass){
		$strClass = preg_replace(["/\\\/"], "/", $strClass);
		;
		if(file_exists($strClass . '.php'))
			require_once($strClass . '.php');
		else
			echo $strClass.".php";
	});

	function loadConfig($strKey)
	{
		$arr = require("Config.php");
		return $arr[$strKey];
	}

	function url($strParam = null)
	{
		$objResource = new ResourceHelper();
		$strHost = $objResource->getHost();
		$strApelidoRota = loadConfig('ROTA_APELIDO');

		if($strApelidoRota != '')
			$strHost .= "/".$strApelidoRota;

		return $strHost.$strParam;
	}

	/*
	*@date 21/05/2016
	*@return
	*@description MATA O SISTEMA INFORMANDO A MENSAGEM
	*/
	function fatalError($strMessage = ''){
		die($strMessage);
	}