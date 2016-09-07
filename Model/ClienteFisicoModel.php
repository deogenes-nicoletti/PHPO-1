<?php

	namespace Model;

	use Interface_\IClienteFisico;
	use Abstract_\AbsClienteModel;

	class ClienteFisicoModel extends AbsClienteModel implements IClienteFisico
	{
		protected $strCpf;

		public function getCpf()
		{
			return $this->strCpf;
		}

		public function setCpf($strCpf)
		{
			$this->strCpf = $strCpf;
			return $this;
		}
	}
