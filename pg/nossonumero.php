<?php
if(isset($_POST['increment'])){
	$numero = $_POST['numero'];
	$sql = mysqli_query($conexao,"ALTER TABLE faturas AUTO_INCREMENT =$numero") or die(mysqli_error());

	$sqla = mysqli_query($conexao,"UPDATE bancos SET increment = '$numero'") or die(mysqli_error());

	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=numero'>
		  <script type=\"text/javascript\">
		  alert(\"Inicio do nosso numero alterado com sucesso.\");
		  </script>";
}

$sqlbanco = $conecta->seleciona($conexao,"SELECT * FROM faturas ORDER BY id_venda DESC")or die (mysqli_error());
$linhas = mysqli_fetch_array($sqlbanco);

$banco = $conecta->seleciona($conexao,"SELECT * FROM bancos")or die (mysqli_error());
$lin = mysqli_fetch_array($banco);

?>
<div id="conteudoform">
<div id="entrada">
<div id="cabecalho">
<h2><i class="icon-file-text"></i> Configurar inicio do nosso numero</h2>
</div>
<div id="forms">
<strong>Obs: Após começar a gerar boletos não utilize mais este recurso.</strong>
<hr><br/><br/>
<form action="" method="post" enctype="multipart/form-data">
Nosso numero inicia em:<br/>
<input name="numero" type="text" value="<?php echo $lin['increment'] ?>"><br/>
<input name="increment" type="submit" value="Gravar" id="increment" class="btn btn-success">

</form>


</div></div></div>
