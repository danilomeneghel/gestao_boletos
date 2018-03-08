<?php
// desttroi a sessao
session_start();
unset($_SESSION['id_usuario_session']);
unset($_SESSION['usuario_session']);
header("location:../index.php");
?>
