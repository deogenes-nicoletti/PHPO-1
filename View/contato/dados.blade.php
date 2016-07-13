@template('layout/padrao');

@section('title')
	Contato - dados
@stop

@section('meio')
<h4 class="alert alert-success">Dados enviados com sucesso, abaixo seguem os dados que você enviou</h4>

<?php

foreach ($arrDadosRecebidos as $key => $objPost)
	{ 
		if($key == 'txtEnviar') continue;
?>
	<p><strong><?php echo $key; ?>: </strong><?php echo $objPost; ?></p>
<?php
	}
?>
@stop