<?php
	namespace Core\System;

	/*
	*@description Carrega todas as classes. Usado em Rotas
	*/
	class GenericClassSystem
	{
		private static $arrClasses = [];

		public function __construct()
		{
			$this->autoLoadClassesConfig();
		}

		private function autoLoadClassesConfig()
		{
			$arrAutoLoadClasses = loadConfig('AUTOLOAD_CLASSES');

			if(is_array($arrAutoLoadClasses) == false)
				return;

			foreach ($arrAutoLoadClasses as $key => $strClass)
			{
				$objRefletor = new \ReflectionClass($strClass);
				$strNomeClass = $objRefletor->getShortName();
				//$this->{$strNomeClass} = $objRefletor->newInstance();

				self::$arrClasses[$strNomeClass] = $objRefletor->newInstance();
			}
		}

		public function __call($strNome, $arrArgumentos)
		{
			self::__construct();

			if(isset(self::$arrClasses[$strNome]))
				return self::$arrClasses[$strNome];
			else
				fatalError('Nao existe este metodo: ' . $strNome);
		}

		/*
		*@return retorna o objeto já guardado
		*/
		public function guardarObjeto($obj)
		{
			$objRefletor = new \ReflectionClass(get_class($obj));
			//print_r(get_class_methods($objRefletor));
			$strNomeClasse = $objRefletor->getShortName();
			$this->strNomeClasse = $obj;

			return $this->strNomeClasse;
		}

		public function instanciarClasse($strNamespaceClasse, $boolGuardarClasse = false){
			$objRefletor = new \ReflectionClass($strNamespaceClasse);

			if($boolGuardarClasse == false)
				return $objRefletor->newInstance();
			else
				return $this->guardarObjeto($objRefletor->newInstance());
		}

		public function executarMetodo($obj, $strMetodo, $arrParametrosFinais = [])
		{
			return call_user_func_array([$obj, $strMetodo], $arrParametrosFinais);
		}
	}