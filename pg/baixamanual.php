<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edita fatura</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-uicss.css" rel="stylesheet" type="text/css">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../css/icons.css" />
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
<link href="../css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background: #f2f2f2;
	padding:10px;
}
</style>
</head>
	<?php $pg = $_GET['pagina'];?>
<script type="text/javascript">
function fechajanela() {
window.open("../inicio.php?pg=<?php echo $pg ?>","main");
}
</script>

<script src="../js/jquery-1.10.2.js"></script>
<script src="../js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="../js/jquery.mask-money.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        $("#valor").maskMoney({decimal:",",thousands:""});
      });

function SomenteNumero(e){

  var tecla=(window.event)?event.keyCode:e.which;
  if((tecla>47 && tecla<58)){
      return true;
  }else{
      if(tecla==8 || tecla==0){
         return true;
      }else{
         return false;
      }
  }
}
</script>
<body onunload="fechajanela()">
<?php
include "../classes/conexao.php";
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$id = $_GET['id_venda'];

if(isset($_POST['baixar'])){

	$data = date("Y-m-d");
	$valor_recebido = number_format($_POST['valor_recebido'],2,'.','');
	$banco_receb = "BAIXA MANUAL";

	$SQL = mysqli_query($conexao,"UPDATE faturas SET dbaixa = '$data', valor_recebido = '$valor_recebido', situacao ='B' WHERE id_venda = '$id'") or die(mysqli_error($conexao));

	echo "<script type='text/javascript'>
			window.close();
		</script>
	";
}
	$ver = mysqli_query($conexao,"SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_venda = '$id'");
	$linha = mysqli_fetch_array($ver);

?>
<div id="entrada">
<div id="cabecalho">
  <h2><i class="icon-cloud-download iconmd"></i> Baixar fatura</h2></div>
<div id="forms">
	<form action="" method="post" name="form" id="form" enctype="multipart/form-data">
    <ul>
    	<li><strong>Cliente:</strong> <?php echo $linha['nome']; ?></li>
    	<li><strong>Valor da fatura:</strong> <?php echo $linha['valor']; ?></li>
    	<li><strong>Vencimento:</strong> <?php echo $linha['data']; ?></li>
        <li><strong>Documento:</strong> <?php echo $linha['id_venda']; ?></li>

   </ul>
    <hr>
    Valor recebido:<br/>
    <div class="input-prepend">
    <span class="add-on"><i class="icon-money"></i></span>
    <input name="valor_recebido" type="text" id="valor" style="text-align:right; width:60px;">
    <br/>
    </div><br/>
<br/>
    <div class="control-groupa">
    <div class="controlsa">

    <input name="baixar" type="hidden" value="baixar">

    <button type="submit" class="btn btn-success ewButton" name="editar">
    <i class="icon-thumbs-up icon-white"></i> Baixar</button>
    </div></div>
    </form>
</div>
</div>


</body>
</html>
