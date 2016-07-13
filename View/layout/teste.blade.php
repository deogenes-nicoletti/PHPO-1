<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" >
	@parte('title');
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-responsive.css">
	<link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>
<body>

<header class="navbar navbar-inverse navbar-fixed-top">
	<article class="navbar-inner">
		<section class="container">
			<nav class="nav-collapse collapse">
				<a class="brand">Projeto1</a>
				<ul class="nav">
					<li class="active"><a href="?pag=home">Home</a></li>
					<li><a href="?pag=empresa">Empresa</a></li>
					<li><a href="?pag=produto">Produtos</a></li>
					<li><a href="?pag=servico">Serviços</a></li>
					<li><a href="?pag=contato">Contato</a></li>
					<li><a href="?pag=busca">Busca</a></li>
					<li><a href="?pag=fixtures">Fixtures</a></li>
				</ul>
			</nav>
		</section>
	</article>
</header>

<article class="container margin-top-5 conteudo-main">
	@parte('meio');
</article>

<footer class="navbar navbar-inverse navbar-fixed-bottom">
	<article class="navbar-inner">
		<section class="container">
			<nav class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="">Todos os direitos reservados - <?php echo date('Y'); ?></a></li>
				</ul>
			</nav>
		</section>
	</article>
</footer>

</body>
</html>