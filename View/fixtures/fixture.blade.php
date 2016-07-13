@template('layout/padrao');

@section('title')
	Fixtures
@stop

@section('meio')
	<?php if($boolExibirLinkAcoes == true) : ?>
		Olá para criar o banco de dados por favor <a href="{{url('/fixtures/criar')}}">Clique aqui</a>
	<?php else : ?>
		Sucesso seu banco de dados foi criado!
	<?php endif; ?>
@stop