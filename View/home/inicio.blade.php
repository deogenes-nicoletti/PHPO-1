@template('layout/padrao');

@section('title')
	Home
@stop

@section('meio')

<style>
	#load{
		position: absolute;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: rgba(0, 0, 0, 0.7);
	}
</style>

<table class="table table-hover">
	<thead>
		<tr>
	    	<th>Nome</th>
	    	<th>Idade</th>
	    	<th>Rua</th>
	    	<th>Ação</th>
	    </tr>
	</thead>
	<tbody>
	    <?php foreach ($lstClientes as $key => $objCliente) : ?>
			<tr>
				<td><?php echo $objCliente->getNome(); ?></td>
				<td><?php echo $objCliente->getIdade(); ?></td>
				<td><?php echo $objCliente->getEndereco(); ?></td>
				<td><a data-toggle="modal" onclick="fnCarregaUsuario('<?php echo $objCliente->getId(); ?>');" data-target="#myModal">Ver informações</a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<br>
<label class="checkbox-inline"><input onclick="fnAlterarOrdem(<?php echo $boolOrdenarInverso ? '0' : '1'; ?>);" type="checkbox" <?php echo $boolOrdenarInverso == false ? 'checked' : ''; ?> value="<?php echo $boolOrdenarInverso; ?>">Ordem <?php echo $boolOrdenarInverso ? 'Crescente' : 'Decrescente'; ?></label>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="nome">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p id="nome">Nome: <span>N/A</span></p>
        <p id="cpf">CPF: <span>N/A</span></p>
        <p id="idade">Idade: <span>N/A</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
	function Pessoa()
	{
		this.getInfoByUserId = function(strId)
		{
			var objCarregando = new Carregando();
			var objModal = new Modal();

			$.ajax({
				url : "{{url('/ajax-cliente-info')}}/" + strId,
				method : 'post',
				dataType: 'json',
				beforeSend: function(){
					objCarregando.toogle();
				},
				success: function(response){
					objCarregando.toogle();
					objModal.setarInformacoesByResponseUsuario(response);
				}
			});
		}
	}

	function fnAlterarOrdem(intOrdem)
	{
		window.location.href = "{{url('/home/')}}" + intOrdem;
	}

	function Modal()
	{
		this.setarInformacoesByResponseUsuario = function(responseUsuario)
		{
			$("#myModal p#nome span, #myModal h4#nome").text(responseUsuario.strNome);
			$("#myModal p#cpf span").text(responseUsuario.strCpf);
			$("#myModal p#idade span").text(responseUsuario.intIdade);
		}
	}

	function Carregando()
	{
		this.toogle = function(){

			if($("html div#load").length == 0)
				$("html").prepend('<div id="load"></div>');
			else
				$("html div#load").fadeOut(500, function(){$(this).remove();});
		}
	}

	function fnCarregaUsuario(strId)
	{
		var objPessoa = new Pessoa();

		objPessoa.getInfoByUserId(strId);
	}
</script>
@stop