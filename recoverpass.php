<?php
$filename = 'classes/conexao.php';
if (!file_exists($filename)) {
	header("Location:setup/instalar.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
require ("classes/conexao.php");

$sqld = mysqli_query($conexao,"SELECT * FROM config") or die(mysqli_error());
$d = mysqli_fetch_array($sqld);

if(isset($_POST['reenviar'])){
	$email = $_POST['email'];

	require "classes/class.phpmailer.php";
	$sql = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());
	$linha = mysqli_fetch_array($sql);

	$cli = mysqli_query($conexao,"SELECT * FROM cliente WHERE email='$email'") or die(mysqli_error());
	$row = mysqli_num_rows($cli);

	if($row>0){
		$row_cli = mysqli_fetch_array($cli);
		$id_usuario = $row_cli['id_usuario'];

		$usu = mysqli_query($conexao,"SELECT * FROM usuario WHERE id_usuario=$id_usuario") or die(mysqli_error());
		$row_usu = mysqli_fetch_array($usu);
		$usuario = $row_usu['usuario'];

		//nova senha
		$nova_senha = str_shuffle("zpwdy".(date("i")*115));
		$senha = sha1($nova_senha);

		//muda a senha do usuario no banco
		$sql2 = mysqli_query($conexao,"UPDATE usuario SET senha='$senha' WHERE id_usuario=$id_usuario");

		$mail = new PHPMailer();
		// define que será usado SMTP
		$mail->IsSMTP();

		// envia email HTML
		$mail->isHTML( true );

		// codificação UTF-8, a codificação mais usada recentemente
		$mail->Charset = 'UTF-8';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'SSL';
		$mail->Host = $linha['url'];
		$mail->Port = $linha['porta'];
		$mail->Username = $linha['email'];
		$mail->Password = $linha['senha'];

		// E-Mail do remetente (deve ser o mesmo de quem fez a autenticação
		// nesse caso seu_login@gmail.com)
		$mail->From = $linha['email'];

		// Nome do rementente
		$mail->FromName = $linha['empresa'];

		// assunto da mensagem
		$mail->Subject = utf8_decode($d['nome']." - Recuperação de Senha");
		// corpo da mensagem
		$texto = utf8_decode("
			Esta mensagem é referente ao seu pedido de recuperação de senha.<br/>
			<p>Seu Usuário: $usuario</p>
			<p>Sua Senha: $nova_senha</p><br/><br/>
			PS: Após se logar, pedimos para mudar sua senha.
		");

		$mail->Body = $texto;
		$mail->AddAddress($email);

		// verifica se enviou corretamente
		if ($mail->Send()) {
			 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=index.php'>
					<script type=\"text/javascript\">
					alert(\"SEUS DADOS DE ACESSO FORAM ENVIADOS PARA SEU EMAIL.!\");
					</script>";
		}else{
					 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=recoverpass.php'>
					<script type=\"text/javascript\">
					alert(\" ERRO! O email não foi enviado. Por favor revise os dados na configuração do email.\");
					</script>";
		}
	}else{
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=recoverpass.php'>
			<script type=\"text/javascript\">
			alert(\" ERRO! O email digitado não confere.\");
			</script>";
	}
}
?>

<title><?php echo $d['nome']; ?> -  Gestão de Boletos</title>
<link href="css/log.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="entrada">
	<div id="top">Recuperar Senha</div>
	<div id="form">
		<form action="" method="post" enctype="multipart/form-data">
			<span class="texto">E-mail cadastrado nas configurações</span><br/>
		  	<input name="email" type="text" class="imput"><br/>
		    <input name="reenviar" type="submit" value="Reenviar senha" id="reenviar" class="botao">
		</form>
		<?php
		if(isset($_GET['login_errado']) == "erro"){
			echo "<div id='erro'>*Dados não conferem. Tente novamente!</div>";
		}
		?>
	</div>
	<div id="logo2"><img src="img/logo.png" width="200" height="130"></div>
	<div id="voltar"><a href="index.php" class="voltar">Voltar</a></div>
</div>
</body>
</html>
