<?php
	return [
		/*
		Define o apelido da rota exemplo:
			http://localhost:8080/microFrameworkNovo/Home/321/222
			neste caso o primeiro parametro seria: microFrameworkNovo
			porém se definirmos o apelido para: microFrameworkNovo
			o código irá automaticamente entender que microFrameworkNovo é um parametro de link e não
			o primeiro parametro a ser passado para o método
		*/
		'ROTA_APELIDO' => '',

		/*
		*AUTOLOAD CLASSES
		*namespace\classe
		*/
		'AUTOLOAD_CLASSES' => [
			'Core\Helper\TemplateHelper',
			'Core\Helper\FileHelper',
			'Core\Helper\SessionHelper'
		],

		/*
		*CONFIGURAÇÃO DE BIBLIOTECAS
		*/
		'LIBRARY' => []
	];