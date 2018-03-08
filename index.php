<?php
if(file_exists('classes/conexao.php')){
	require ("classes/conexao.php");
	$sqld = mysqli_query($conexao,"SELECT * FROM config") or die(mysqli_error());
	$d = mysqli_fetch_array($sqld);
} else {
	echo "Erro! Verifique sua conexão com o banco de dados.";
}

if(isset($_GET['acao']) == "senha"){
	print "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=recoverpass.php'>";
}
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $d['nome']; ?> - Gestão de Boletos</title>
	<meta name="keywords" content="SISTEMA DE BOLETO">
	<link href="css/log.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="entrada">
	<div id="top">Central Administrativo</div>
	<div id="form">
		<form action="php/login.php" method="post" enctype="multipart/form-data">
			<span class="texto">Usuário:</span><BR/>
		  	<input name="usuario" type="text" class="imput"><br/>
		  	<span class="texto">Senha:</span><BR/>
		    <input name="senha" type="password" class="imput"><br/>
		    <input name="logar" type="submit" value="Entrar" id="logar" class="botao">
		</form>
		<?php
		if(isset($_GET['login_errado']) == "erro"){
			echo "<div id='erross'>*Dados não conferem. Tente novamente!</div>";
		}
		if(isset($_GET['login_bloqueado']) == "erro"){
			echo "<div id='erross'>*Usuário bloqueado!</div>";
		}
		?>
	</div>
	<div id="logo"><img src="img/logo.png" width="200" height="130"></div>
	<div id="rec"><a href="?acao=senha" class="rec">Esqueci minha senha</a></div>
	</div>
</body>
</html>
