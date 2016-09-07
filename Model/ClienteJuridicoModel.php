<?php

	namespace Model;

	use Interface_\IClienteJuridico;
	use Abstract_\AbsClienteModel;

	class ClienteJuridicoModel extends AbsClienteModel implements IClienteJuridico
	{
		protected $strCnpj;

		public function getCnpj()
		{
			return $this->$strCnpj;
		}

		public function setCnpj($strCnpj)
		{
			$this->strCnpj = $strCnpj;
			return $this;
		}
	}
