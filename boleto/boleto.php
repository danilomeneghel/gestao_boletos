<?php 
include "../classes/conexao.php";

function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
			}

$str = $_SERVER['QUERY_STRING'];
$string = base64_decode($str);

$url = mysqli_query($conexao,"SELECT * FROM bancos WHERE situacao='1'") or die(mysqli_error($conexao));
$lista = mysqli_fetch_array($url);
	$links = $lista['link'];
	$banco = $links."?".$string;	
        header("Location:{$banco}");


?>