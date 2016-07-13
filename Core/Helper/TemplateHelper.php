<?php
	namespace Core\Helper;
	use Core\System\GenericClassSystem;

	class TemplateHelper extends GenericClassSystem
	{
		private $DEF_SINTAX_TEMPLATE = "template";
		private $strTemplateFile;

		public function __construct()
		{
		}

		public static function section($key, $valor){
			$arr[$key] = $valor;
		}

		private function getArrayFinal($arr)
		{
			//REGEX: $1 ocorrencias, $2 comandos, $3 parametros
			$arrOcorrencias = $arr[0];
			$arrComando = $arr[1];
			$arrParametros = $arr[2];
			$arrFinal = [];

			foreach ($arrComando as $key => $value)
				$arrFinal[] = [
					'strComando' => $arrComando[$key],
					'strParametro' => $arrParametros[$key]
				];

			return $arrFinal;
		}

		/*
		*@description APLICA REGEX INTERNO PARA O CONTEUDO
		*@return array
		*/
		private function aplicarRegexInterno($strKeyRegex, $strConteudo)
		{
			$arrRegex = [
				//"url" => [ "regex" => "/(?:{{url\('*(\W*\w*\D*?)'*\)}})/", "function" => function($str){
				"url" => [ "regex" => "/(?:{{url\('*(.*?)'*\)}})/", "function" => function($str){
					return empty($str) ? url() : url($str);
				}]
			];

			$arrResult = '';
			preg_match_all($arrRegex[$strKeyRegex]['regex'], $strConteudo, $arrResult);

			$arrReplace = isset($arrResult[0]) ? $arrResult[0] : null;
			$arrValor = isset($arrResult[1]) ? $arrResult[1] : null;

			foreach ($arrReplace as $key => $value)
			{
				$strReplace = $arrRegex[$strKeyRegex]["function"]($arrValor[$key]);
				$strConteudo = str_replace($value, $strReplace, $strConteudo);
			}

			return $strConteudo;
		}

		/*
		*@return array
		*/
		private function getTemplateByArrFinal($arrFinal)
		{
			foreach ($arrFinal as $key => $value)
				if($value['strComando'] == $this->DEF_SINTAX_TEMPLATE)
					return $value;
		}

		public function loadView($strFile, $arrParametros = [])
		{
			$strFile .= ".blade";
			$strCaminhoView = PAGES_SRC . $strFile . '.php';

			//Procurando o template chamado na view
			$regex = "/@($this->DEF_SINTAX_TEMPLATE)\('([a-z|0-9|\/]+)'\);/";
			$arquivo = file_get_contents($strCaminhoView);
			$arrOcorrencias = '';
			preg_match_all($regex, $arquivo, $arrOcorrencias);
			$arrTemplate = $this->getTemplateByArrFinal($this->getArrayFinal($arrOcorrencias));
			//Fim

			extract($arrParametros);

			if(sizeof($arrTemplate) == 0)
				require($this->armazenaView($strCaminhoView, $arquivo));
			else
				require($this->preparaView($arrTemplate, $arquivo));
		}

		/*
		*@description Junta concat na merge obedecendo ordem de indices maiores ex: 
		*[10 => 'f', 15 => 'b'], [11 => 'g', 16 => 'a'] final: [11 => 'gf', 16 => 'ab']
		*/
		private function juntarContLivreComProxSecao($arrConcat, $arrMerge)
		{
			//print_r($arrConcat);
			//print_r($arrMerge);
			//die();

			//Procura por ponteiros
			end($arrMerge);
			$strFinalMerge = key($arrMerge); 
			reset($arrMerge);
			reset($arrConcat);

			while(key($arrMerge) !== $strFinalMerge)
			{
				$intKeyMerge = key($arrMerge);
				$intKeyConcat = key($arrConcat);

				if($intKeyConcat == null)
					break;

				if($intKeyConcat < $intKeyMerge){
					$arrMerge[$intKeyMerge] = $arrConcat[$intKeyConcat] . $arrMerge[$intKeyMerge];
					next($arrConcat);
				}
				else
				{
					next($arrMerge);
					$intKeyNextMerge = key($arrMerge);
					prev($arrMerge);

					if($intKeyConcat < $intKeyNextMerge)
					{
						$arrMerge[$intKeyMerge] .= $arrConcat[$intKeyConcat];
						next($arrConcat);
					}else{
						next($arrMerge);
						$arrMerge[$intKeyNextMerge] .= $arrConcat[$intKeyConcat];
					}
				}
			}

			return $arrMerge;
		}

		private function preparaView($arrTemplate, $arquivoView)
		{
			$strNomeArquivoTemplate = $arrTemplate['strParametro'] . ".blade.php";
			$strSintaxeTemplate = sprintf("@$this->DEF_SINTAX_TEMPLATE('%s');", $arrTemplate['strParametro']);

			//$strRegex = "/(?:@template\('\S+'\);)*(?:@section\('(\S+)'\)([\s\S]*)@stop)*(\S*)/";
			$strRegex = "/(?:@template\('\S+'\);)*(?:@section\('(\S+)'\)*([\w\s\S]*?)@stop)*([\S ]*)/";
			$arrOcorrencias = '';
			preg_match_all($strRegex, $arquivoView, $arrOcorrencias);

			//Regex para $1, $2, $3, $4
			//$arrOcorrencias = $arrOcorrencias[0];
			$arrComando = array_diff($arrOcorrencias[1], [null]);
			$arrParametros = array_diff($arrOcorrencias[2], [null]);
			$arrConteudoForaSecoes = array_diff($arrOcorrencias[3], [null]);

			//Juntando termos fora secao com termos da secao mais proxima
			$arrParametros = $this->juntarContLivreComProxSecao($arrConteudoForaSecoes, $arrParametros);
			//Normalizando array
			$arrayNormalizada = [$arrOcorrencias, $arrComando, $arrParametros];
			$arrViewSecoes = $this->getArrayFinal($arrayNormalizada);

			//Carregando o template
			if(file_exists(PAGES_SRC . $strNomeArquivoTemplate) == false){
				die('Erro template não existe');
			}

			$arquivoTemplate = file_get_contents(PAGES_SRC . $strNomeArquivoTemplate);

			//Realizando overwrite no template (suas seções)
			foreach ($arrViewSecoes as $key => $objSecao)
			{
				$strReplace = sprintf("\@parte\('%s'\);", $objSecao['strComando']);
				$arquivoTemplate = preg_replace(["/$strReplace/"], $objSecao['strParametro'], $arquivoTemplate);
			}

			//Armazenando
			return $this->armazenaView($strNomeArquivoTemplate, $arquivoTemplate);
		}

		private function armazenaView($strNomeView, $strConteudo)
		{
			$strConteudo = $this->aplicarRegexInterno("url", $strConteudo);

			$strNomeView = md5($strNomeView);
			$strCaminhoView = CORE_STORAGE_VIEW.$strNomeView;
			
			file_put_contents($strCaminhoView, $strConteudo);
			return $strCaminhoView;
		}
	}