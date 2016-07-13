<?php
	namespace Controller;
	use Core\Helper\ResourceHelper;
	use Core\System\GenericClassSystem;
	use Model\ClienteModel;
	use Core\Helper\ListHelper;

	class ClienteController extends GenericClassSystem
	{
		public function __construct()
		{
		}

		public function index($boolOrdenarInverso = false)
		{
			if($this->SessionHelper()->exists('lstClientes') == false)
				$this->criarClientesDemo();

			$lstClientes = $this->SessionHelper()->get('lstClientes');

			if($boolOrdenarInverso == true)
				$lstClientes = array_reverse($lstClientes);

			$this->TemplateHelper()->loadView('home/inicio', ['lstClientes' => $lstClientes, 'boolOrdenarInverso' => $boolOrdenarInverso]);
		}

		private function criarClientesDemo($inQtdClientesDemo = 10)
		{
			$objLstDemoEndereco = new ListHelper(['Norberto Seara Heusi', 'Niterói', 'Rio negrinho']);
			$intSizeOfObjLstDemoEndereco = $objLstDemoEndereco->length();

			$objListClientesDemo = new ListHelper();

			//Criando lista de clientes com dados ficticios
			for($i = 1; $i <= $inQtdClientesDemo; ++$i)
			{
				$objClienteModel = new ClienteModel();

				$objClienteModel->setId($i);
				$objClienteModel->setNome("Cliente $i");
				$objClienteModel->setCpf(sprintf("410.735.107-%s", $i >= 10 ? "0$i" : $i));
				$objClienteModel->setIdade(rand(10, 90));

				$objClienteModel->setEndereco($objLstDemoEndereco->indexOf(rand(0, $intSizeOfObjLstDemoEndereco -1)));

				$objListClientesDemo->adicionar($objClienteModel);
			}

			//Armazenando clientes em sessao
			$this->SessionHelper()->set('lstClientes', $objListClientesDemo->all(), true);
		}

		public function show($strId = null)
		{
			if($strId === null)
				return;

			//Pegando informacoes do cliente
			$objListaCliente = new ListHelper();
			$objListaCliente->set($this->SessionHelper()->get('lstClientes'));

			echo json_encode($objListaCliente->procurarByAtributo('getId', (int) $strId)->toArray());
		}
	}