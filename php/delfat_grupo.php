<?php 	
include "../classes/conexao.php";
$pedido = $_POST['pedido'];
foreach($_POST['pedido'] as $key => $id_pedido){	
	$id_pedido = isset($_POST['pedido'][$key])? $_POST['pedido'][$key] :null;
	
	$del = mysqli_query($conexao,"DELETE FROM faturas WHERE pedido='$id_pedido'") or die(mysqli_error());

	
	if($del == 1){
		
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=recarne'>
			";

	}
}
?>