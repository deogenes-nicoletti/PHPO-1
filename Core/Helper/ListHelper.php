<?php
	namespace Core\Helper;

	use Core\System\GenericClassSystem;

	class ListHelper extends GenericClassSystem
	{
		private $arrList;

		public function __construct($arrList = null)
		{
			$this->arrList = $arrList;
		}

		public function all()
		{
			return $this->arrList;
		}

		public function indexOf($intIndex)
		{
			if($this->checkIndex($intIndex) == true)
				return $this->arrList[$intIndex];

			return null;
		}

		public function procurarByAtributo($strMetodo, $absObjCompare = null, $arrParametrosFinais = [])
		{
			if($this->length() == 0)
				return;

			foreach ($this->arrList as $key => $objLst)
				if(method_exists($objLst, $strMetodo))
				{
					$objResult = $this->executarMetodo($objLst, $strMetodo, $arrParametrosFinais);
					if($objResult === $absObjCompare)
						return $objLst;
				}
		}

		public function pop()
		{
			$intLastIndex = $this->getLastIndex();

			if($this->checkIndex($intLastIndex) == true)
			{
				$arrTmp = array_splice($this->arrList, 0, -1);
				$this->arrList = $arrTmp;
			}
		}

		public function set($absObj)
		{
			$this->arrList = $absObj;
		}

		public function adicionar($absObj)
		{
			$this->arrList[] = $absObj;
		}

		private function checkIndex($intIndex)
		{
			return isset($this->arrList[$intIndex]);
		}

		private function getLastIndex()
		{
			return $this->length() == 0 ? 0 : $this->length() - 1;
		}

		public function length()
		{
			return sizeof($this->arrList);
		}

		public function last()
		{
			$intLastIndex = $this->getLastIndex();

			if($this->checkIndex($intLastIndex) == true)
				return $this->arrList[$intLastIndex];
			else
				return null;
		}
	}