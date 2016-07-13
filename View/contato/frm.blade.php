@template('layout/padrao');

@section('title')
    Contato
@stop

@section('meio')

<form method="post">
  <fieldset>
    <legend><?php echo $strDescricao; ?></legend>
    
    <p>
    	<label>Nome</label>
    	<input name="Nome" type="text" placeholder="Nome…" required>
    </p>
    <p>
    	<label>Email</label>
    	<input name="Email" type="email" placeholder="Email…" required>
    </p>
    <p>
    	<label>Assunto</label>
    	<input name="Assunto" type="text" placeholder="Assunto…" required>
    </p>
    <p>
    	<label>Mensagem</label>
    	<textarea name="Mensagem" required></textarea>
    </p>
    <button type="submit" name="txtEnviar" class="btn">Enviar</button>
  </fieldset>
</form>
@stop