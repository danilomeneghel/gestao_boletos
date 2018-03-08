<?php
include "../classes/conexao.php";
require_once("RetornoBanco.php");
require_once("RetornoFactory.php");

$LIMPA = mysqli_query($conexao,"TRUNCATE financeiro");

function linhaProcessada1($self, $numLn, $vlinha) {
  if(!empty($vlinha)){
    foreach($vlinha as $nome_indice => $valor)
	//echo "$nome_indice: $valor<br/>";
	  $b = $vlinha["banco"];
	  $ag_receb = $vlinha["ag_receb"];
	  $dv_receb = $vlinha["dv_receb"];
	  $nm = $vlinha['nosso_numero'];
	  $venc = $vlinha['vencimento'];
	  $valor = $vlinha['valor'];
	   
	 $sql = mysqli_query($conexao,"INSERT INTO financeiro (banco,ag_receb,dv_receb,nosso_numero,vencimento,valor) 
	 VALUES('$b','$ag_receb','$dv_receb','$nm','$venc','$valor')")or die(mysqli_error()) ;  
  echo "<br/>\n";
		
  }

}

 echo "<script language='javascript'>
window.open('relatorio.php', '_blank');
</script>"; 

print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=fatbaixada'>";


//--------------------------------------INÍCIO DA EXECUÇÃO DO CÓDIGO-----------------------------------------------------
$fileName = $_FILES['arquivo']['tmp_name'];

//$cnab240 = RetornoFactory::getRetorno($fileName, "linhaProcessada");
$cnab240 = RetornoFactory::getRetorno($fileName, "linhaProcessada1");

$retorno = new RetornoBanco($cnab240);
$retorno->processar();

 $sql = mysqli_query($conexao,"SELECT * FROM financeiro");
while($ver = mysqli_fetch_array($sql)){
	  $dbaixa		= date("Y-m-d");
	  $banco 		= $ver["banco"];
	  $ag_receb 	= $ver["ag_receb"];
	  $dv_receb 	= $ver["dv_receb"];
	  $nm 			= $ver['nosso_numero'];
	  $valor 		= $ver['valor'];	
	$baixa = mysqli_query($conexao,"UPDATE faturas SET dbaixa = '$dbaixa', codbanco = '$banco', banco_receb ='$ag_receb',dv_receb='$dv_receb',valor_recebido='$valor', situacao ='B' WHERE id_venda='$nm' OR nosso_numero='$nm' AND situacao != 'B'") or die(mysqli_error());

}



?>
