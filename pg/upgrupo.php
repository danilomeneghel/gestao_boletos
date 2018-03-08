<?php
include "../checalogin.php";
?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Editar grupo de clientes</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/icons.css" rel="stylesheet" type="text/css">
<link href="../css/font-awesome.css" rel="stylesheet" type="text/css">
<script language="javascript">
function fechajanela() {
window.open("../inicio.php?pg=grupo","main");
}
</script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.mask-money.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#valor").maskMoney({decimal:",",thousands:""});
});
</script>
</head>

<body onUnload="fechajanela()">
<?php
	include "../classes/conexao.php";

	if(isset($_POST['editargrupo'])){
		$idGrupo = $_GET['id_grupo'];
		$nomegrupo = $_POST['nomegrupo'];
		$meses = $_POST['meses'];
		$valor = $_POST['valor'];
		$update = mysqli_query($conexao,"UPDATE grupo SET nomegrupo='$nomegrupo',meses='$meses',valor='$valor' WHERE id_grupo='$idGrupo'")or die (mysqli_error());
		if($update == 1){
			print"<script type=\"text/javascript\">javascript:window.close()</script>";
		}
	}

	$idGrupo = $_GET['id_grupo'];
	$sqls = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo='$idGrupo'")or die (mysqli_error());
	$l = mysqli_fetch_array($sqls);
	$meses = $l['meses'];
?>
	<fieldset><legend><strong>Editar grupo de clientes</strong></legend>
	<form action="" method="post" enctype="multipart/form-data">
		Nome do grupo:<br/>
		<input name="id_grupo" type="hidden" value="<?php echo $l['id_grupo'] ?>">
		<input name="nomegrupo" type="text" value="<?php echo $l['nomegrupo'] ?>"><br/>
    Intervalo de vencimento:<br/>
    <select name="meses">
      <option value="0" <?php if(!(strcmp($meses, 0))) {echo "selected=\"selected\"";} ?>>Avulso</option>
      <option value="1" <?php if(!(strcmp($meses, 1))) {echo "selected=\"selected\"";} ?>>30 dias</option>
      <option value="2" <?php if(!(strcmp($meses, 2))) {echo "selected=\"selected\"";} ?>>60 dias</option>
      <option value="3" <?php if(!(strcmp($meses, 3))) {echo "selected=\"selected\"";} ?>>90 dias</option>
      <option value="6" <?php if(!(strcmp($meses, 6))) {echo "selected=\"selected\"";} ?>>6 meses</option>
      <option value="12" <?php if(!(strcmp($meses, 12))) {echo "selected=\"selected\"";} ?>>1 ano</option>
      <option value="24" <?php if(!(strcmp($meses, 24))) {echo "selected=\"selected\"";} ?>>2 anos</option>
      <option value="36" <?php if(!(strcmp($meses, 36))) {echo "selected=\"selected\"";} ?>>3 anos</option>
    </select><br/>
		Valor:<br/>
		<input type="text" name="valor" value="<?php echo $l['valor'] ?>" id="valor" style="width:80px; text-align:right;"><br/>
    <button type="submit" class="btn btn-success ewButton" name="editargrupo" id="btnsubmit" >
		<i class="icon-thumbs-up icon-white"></i> Alterar dados do grupo</button>
	</form>
</body>
</html>
