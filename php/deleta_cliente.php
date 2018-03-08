<?php
ob_start();
include '../classes/conexao.php';
$id = $_GET['id'];

// Localiza os dados do cliente no banco
$cli = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$id'") or die(mysqli_error());
$row_cli = mysqli_fetch_array($cli);
$id_usuario = $row_cli['id_usuario'];

// Deleta os dados do cliente
mysqli_query($conexao,"DELETE FROM cliente WHERE id_cliente='$id'")or die (mysqli_error());
mysqli_query($conexao,"DELETE FROM usuario WHERE id_usuario='$id_usuario'")or die (mysqli_error());

header("Location:../inicio.php?pg=listaclientes");
?>
