<?php 
include "../classes/conexao.php";

$pg = $_GET['pg'];
$id = $_GET['id_venda'];
$del = mysqli_query($conexao,"UPDATE faturas SET situacao='B' WHERE id_venda='$id'") or die (mysqli_error());

if($del == 1){
	if($pg != ""){
	header("Location:../inicio.php?pg=fatpendente&p=".$pg."");
	}else{
	header("Location:../inicio.php?pg=fatpendente");	
	}

              }


?>