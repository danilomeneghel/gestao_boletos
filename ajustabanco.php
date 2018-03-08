<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 

include "classes/conexao.php";

$sql = mysqli_query($conexao,"ALTER TABLE config ADD qnt VARCHAR(3) NOT NULL AFTER demo4") or die(mysqli_error());

if($sql == 1){
	echo "Banco de dados atualizados com sucesso!";	
}
$sq = mysqli_query($conexao,"UPDATE config SET qnt = '30' WHERE id = 1")or die(mysqli_error());

if($sq == 1){
	echo "<br/>Tabela atualizada com sucesso!";	
}

?>

</body>
</html>