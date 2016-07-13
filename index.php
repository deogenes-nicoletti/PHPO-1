<?php
	//Arquivo de arranque de sistema
	require_once('Core/Core.php');

	use Core\Route;

	Route::get('ajax-cliente-info', 'ClienteController@show');
	Route::get('home', 'ClienteController@index');