<?php
	namespace Core\Helper;

	class FileHelper
	{
		public function exists($strFile)
		{
			return file_exists($strFile);
		}

		public function incluir($strFile)
		{
			if($this->exists($strFile))
				require($strFile);
			else
				fatalError("O arquivo não existe: " . $strFile);
		}

		public function getContent($strFile)
		{
			if($this->exists($strFile))
				return file_get_contents($strFile);
			else
				fatalError("O arquivo não existe: " . $strFile);
		}

		public function serializa($stdObj)
		{
			return serialize($stdObj);
		}

		public function deserializa($absData)
		{
			return unserialize($absData);
		}
	}