<?php
	namespace Core\Helper;

	use Core\Helper\FileHelper;
	use Core\System\Model\SessionStoreModel;
	use Core\System\GenericClassSystem;

	class SessionHelper extends GenericClassSystem
	{
		public function __construct()
		{
		}

		public function get($strKey = null)
		{
			return isset($_SESSION[$strKey]) ? $this->FileHelper()->deserializa($_SESSION[$strKey])->getData() : null;
		}

		public function set($strKey, $absData, $boolSerializar = true)
		{
			$_SESSION[$strKey] = $this->getSessionStoreModel($absData, $boolSerializar);
		}

		public function all()
		{
			return $_SESSION;
		}

		public function incluir($strKey, $absData, $boolSerializar = true)
		{
			if(isset($_SESSION[$strKey]))
				$_SESSION[$strKey][] = $this->getSessionStoreModel($absData, $boolSerializar);
			else
				$_SESSION[$strKey] = $this->getSessionStoreModel($absData, $boolSerializar);
		}

		private function getSessionStoreModel($absData, $boolSerializar = true)
		{
			return $this->FileHelper()->serializa(new SessionStoreModel($boolSerializar, $absData));
		}

		public function exists($strKey){
			return isset($_SESSION[$strKey]);
		}
	}