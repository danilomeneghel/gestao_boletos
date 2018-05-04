<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "gestao_boletos";
$conexao = new mysqli($host, $usuario, $senha, $banco);
$conexao->set_charset('utf8');
mysqli_set_charset($conexao, 'utf8');
?>
