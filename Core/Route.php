<?php
	namespace Core;
	use Controller\GenericController;
	use Core\Helper\ResourceHelper;
	use Core\System\GenericClassSystem;

	use Model\GenericModel;

	Class Route
	{
			private static $objResourceHelper;
			private static $objGenericClass;

			public static function init()
			{
				self::$objResourceHelper = new ResourceHelper();
				self::$objGenericClass = new GenericClassSystem();

				if(self::$objResourceHelper->getController() === null){
					//self::$objResourceHelper->redirect($strUrl);
					fatalError('Informe uma rota');
				}
			}

			public static function get($strRota, $strClass, $boolStaticRoute = false)
			{
				self::init();

				if(self::verificaControlador($strRota) == $strRota)
					self::getMetodosEParameByStringClass($strClass);
				//else
					//fatalError('Rota não existe');
			}

			private static function verificaControlador($strRota)
			{
				return self::$objResourceHelper->getController() === $strRota ? true : false;
			}

			private static function getMetodosEParameByStringClass($strClass)
			{
				$arrClass = explode("@", $strClass);
				$strClass = "\Controller\\".$arrClass[0];
				$strMetodo = null;

				if(sizeof($arrClass) > 1)
				{
					$strMetodo = $arrClass[1];
					$arrParametrosFinais = [];

					foreach (self::getParametrosDoMetodo($strClass, $strMetodo) as $objParametro)
					{
						if(isset($objParametro['strTipo']))
						{
							if($objParametro['scalar'] == false)
								$arrParametrosFinais[] = new $objParametro['strTipo'];
							else
								$arrParametrosFinais[] = $objParametro['strDefault'];
						}
						//elseif(isset($objParametro['strDefault']))
						else
							$arrParametrosFinais[] = $objParametro['strDefault'];
					}
					$objDaClasse = self::$objGenericClass->instanciarClasse($strClass, false);
					//call_user_func_array([$objDaClasse, $strMetodo], $arrParametrosFinais);
					self::$objGenericClass->executarMetodo($objDaClasse, $strMetodo, $arrParametrosFinais);
				}
			}

			private static function getParametrosDoMetodo($strClasse, $strMetodo)
			{
				$objReflectionMethod = new \ReflectionMethod($strClasse, $strMetodo);

				$arr = $objReflectionMethod->getParameters();
				
				//strNome, [strTipo => x, strDefault]
				$arrParametros = [];
				$intIndiceParametrosUrl = 0;

				foreach ($arr as $key => $value)
				{
					$arrTmp = [];
					$strTipoPuro = explode(" ", $value->__toString())[4];

					if(strpos($strTipoPuro, "$") === false && class_exists($strTipoPuro) == false)
					{
						$arrTmp['strTipo'] = "\\".$strTipoPuro;
						$arrTmp['strDefault'] = null;
						$arrTmp['scalar'] = true;
						$arrParametros[] = $arrTmp;
						continue;
					}
					
					$strTipo = $value->getClass() === null ? null : "\\".$value->getClass()->getName();
					$arrTmp['strTipo'] = $strTipo;
					$arrTmp['scalar'] = $strTipo === null ? true : false;

					/*if($value->isDefaultValueAvailable())
						$arrTmp['strDefault'] = $value->getDefaultValue();
					elseif($arrTmp['scalar'] === true)
					{
						$arrTmp['strDefault'] = self::getValorUrlByIndex($intIndiceParametrosUrl++);
					}
					else
						$arrTmp['strDefault'] = null;*/

					$strValorUrl = self::getValorUrlByIndex($intIndiceParametrosUrl);

					if($strValorUrl === null)
						$arrTmp['strDefault'] = $value->isDefaultValueAvailable() ? $value->getDefaultValue() : null;
					else
						$arrTmp['strDefault'] = self::getValorUrlByIndex($intIndiceParametrosUrl++);

					$arrParametros[] = $arrTmp;
				}

				return $arrParametros;
			}

			private static function getValorUrlByIndex($intIndex = 0)
			{
				//++ para pular o controlador
				return self::$objResourceHelper->getUrl(++$intIndex);
			}
	}