<?php
	namespace Abstract_;

	use Core\System\Model\GenericModel;
	use Interface_\ICliente;

	abstract class AbsClienteModel extends GenericModel implements ICliente
	{
		protected $intId = null;
		protected $strNome = null;
		protected $strEndereco = null;
		protected $intIdade = null;
		protected $strEnderecoCobranca = null;
		protected $intGrauImportancia = null;

		public function getGrauImportancia()
		{
			return $this->intGrauImportancia;
		}

    public function setGrauImportancia($intGrauImportancia)
		{
			$this->intGrauImportancia = $intGrauImportancia;
			return $this;
		}

		public function getEnderecoCobranca()
		{
			return $this->strEnderecoCobranca;
		}

		public function setEnderecoCobranca($strEnderecoCobranca)
		{
			$this->strEnderecoCobranca = $strEnderecoCobranca;
			return $this;
		}

		public function getId(){
			return $this->intId;
		}

		public function setId($intId){
			$this->intId = $intId;
		}

		public function getNome(){
			return $this->strNome;
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
