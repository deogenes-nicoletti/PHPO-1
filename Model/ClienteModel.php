<?php
	namespace Model;

	use Core\System\Model\GenericModel;

	class ClienteModel extends GenericModel
	{
		protected $intId;
		protected $strNome;
		protected $strCpf;
		protected $strEndereco;
		protected $intIdade;

		public function getId(){
			return $this->intId;
		}

		public function setId($intId){
			$this->intId = $intId;
		}

		public function getNome(){
			return $this->strNome;
		}

		public function getCpf(){
			return $this->strCpf;
		}

		public function getEndereco(){
			return $this->strEndereco;
		}

		public function getIdade(){
			return $this->intIdade;
		}

		public function setNome($strNome){
			$this->strNome = $strNome;
		}

		public function setCpf($strCpf){
			$this->strCpf = $strCpf;
		}

		public function setEndereco($strEndereco){
			$this->strEndereco = $strEndereco;
		}

		public function setIdade($intIdade){
			$this->intIdade = $intIdade;
		}
	}