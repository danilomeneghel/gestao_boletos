<?php
session_start();

//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['id_usuario_session']) and !isset($_SESSION['usuario_session'])){
	header("Location:index.php");
	exit;
}
?>
