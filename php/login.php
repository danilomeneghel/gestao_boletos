<?php
/// abre a sessao
session_start();
include "../classes/conexao.php";

/// pega o valor vindo do campo usuario
$usuario = preg_replace('/[^[:alpha:]_]/', '',$_POST['usuario']);
/// pega o valor vindo do campo senha
$senha = sha1(preg_replace('/[^[:alnum:]_]/', '',$_POST['senha']));

//seleciona a tabela usuario
$sql = mysqli_query($conexao,"SELECT * FROM usuario WHERE BINARY usuario='$usuario' AND senha='$senha'");
$row = mysqli_fetch_array($sql);

// confere se exixte o usuario no banco
if(mysqli_num_rows($sql) == 1){
	// confere se é o admin, ou caso seja cliente, se ele não está bloqueado
	$id_usuario = $row['id_usuario'];
	$sql2 = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_usuario='$id_usuario' AND bloqueado='N'");
	if($id_usuario == 1 || mysqli_num_rows($sql2) == 1){
		// se existir registra a session com o usuario e senha e vai para a pagina_principal
		$_SESSION['id_usuario_session'] = $id_usuario;
		$_SESSION['usuario_session'] = $usuario;
		header("Location:../inicio.php?pg=inicio");
	}else{
		unset($_SESSION['id_usuario_session']);
		unset($_SESSION['usuario_session']);
		header("location:../index.php?login_bloqueado=erro");
	}
	// se nao existir destroi a sessao existente e manda a mensagen de erro para a pagina do form
}else{
	unset($_SESSION['id_usuario_session']);
	unset($_SESSION['usuario_session']);
	header("location:../index.php?login_errado=erro");
}
?>
