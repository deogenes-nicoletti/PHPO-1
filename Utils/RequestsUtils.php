<?php
	namespace Utils;

	use Utils\NotificationUtils;

	class RequestsUtils
	{
		private $objNotificationUtils;

		public function __construct()
		{
			$this->objNotificationUtils = new NotificationUtils();
		}

		public function isEmptyResponse($strKey = '', $strMethod = 'POST')
		{
			if($strMethod === 'POST')
				return empty($_POST[$strKey]);
			else
				return empty($_GET[$strKey]);
		}

		public function get($strKey = '', $strProtocol = 'POST')
		{
			switch ($strProtocol)
			{
				case 'POST':
					return isset($_POST[$strKey]) ? $_POST[$strKey] : null;
					break;
				
				case 'GET':
					return isset($_GET[$strKey]) ? $_GET[$strKey] : null;
					break;

				default:
					$this->objNotificationUtils->notificateToBrowser('', 'Protocolo: ' . $strProtocol .' não encontrado', true);
					break;
			}
			//if(empty($))
		}
	}