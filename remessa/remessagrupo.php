<div id="entrada">
<div id="cabecalho"><h2><i class="icon-external-link-sign  iconmd"></i> Gerar remessa para grupo</h2></div>
<div id="forms">
<?php 
$res = mysql_query("SELECT * FROM bancos WHERE situacao='1'");
$list = mysql_fetch_array($res);
if($list['id_banco'] != '4' && $list['id_banco'] != '1'){
	
echo '<h3>Este sistema gera remessa somente para os bancos ITAU ou BB. Por favor ative o banco para gerar o arquivo de remessa.</h3>';
exit;
}
?>

<h3>Selecione um grupo para gerar remessa:</h3><br/>
<form action="remessa/GeraRemessaGrupo.php" method="post" enctype="multipart/form-data">
	<select name="grupo">
	  <option value="A">- SELECIONE -</option>
      <?php 
	  $sqlGrupo = mysql_query("SELECT * FROM grupo") or die(mysql_error());
	  while($v = mysql_fetch_array($sqlGrupo)){
		  $idG = $v['id_grupo'];
		  $sql = mysql_query("SELECT grupoCliente FROM faturas WHERE grupoCliente = '$idG' AND remessa = '0'");
	  ?>
      <option value="<?php echo $v['id_grupo'] ?>"><?php echo mysql_num_rows($sql).' -> '.$v['nomegrupo'];?></option>
      <?php } ?>
      
	</select><br/>
	<input name="gerar" type="submit" value="Gerar remessa para o grupo" class="btn btn-success ewButton">
</form><br/>
<hr><br/>
</div>
</div>