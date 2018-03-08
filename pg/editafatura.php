<?php
include "../checalogin.php";
?>

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

<script src="../js/jquery-1.10.2.js"></script>
<script src="../js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="../js/jquery.mask-money.js"></script>
</head>

<?php
if(isset($_GET['pg']) && $_GET['pg'] == "fatpendente"){
	$fechapg = "window.open(\"../inicio.php?pg=fatpendente\",\"main\");";
}elseif(isset($_GET['pg']) && $_GET['pg'] == "fatvencida"){
	$fechapg = "window.open(\"../inicio.php?pg=fatvencida\",\"main\");";
}else{
	$fechapg = "window.open(\"../inicio.php?pg=recarne\",\"main\");";
}
?>

<script language="javascript">
function fechajanela() {
	<?php echo $fechapg; ?>
}

$(document).ready(function () {
  $(".data_venci").datepicker({
      dateFormat: 'dd/mm/yy',
      dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
      dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
      dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
      monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      nextText: 'Proximo',
      prevText: 'Anterior'
  });
});

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

$id_venda = $_GET['id_venda'];
$sql = mysqli_query($conexao,"SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_venda = '$id_venda'");
$linha = mysqli_fetch_array($sql);

if(isset($_POST['editar'])){


		$ref		= $_POST['ref'];

		function tiraMoeda($valor){
		$pontos = '.';
		$virgula = ',';
		$result = str_replace($pontos, ",", $valor);
		$result2 = str_replace($virgula, ".", $result);
		return $result2;
		}
		$valor = tiraMoeda($_POST['valor']);


		$data_ven = $_POST['data_venci'];
		$dv = explode ("/",$data_ven); // inverte a data para padrao sql
		$dia = $dv[0];
		$mes = $dv[1];
		$ano = $dv[2];

		$vencimento = $ano."-".$mes."-".$dia;

		$sql = mysqli_query($conexao,"UPDATE faturas SET ref='$ref', valor='$valor', data_venci='$vencimento' WHERE id_venda='$id_venda'");
		if($sql == 1){
		print "<script type=\"text/javascript\">javascript:window.close()</script>";
		}
}

?>
<div id="entrada">
<div id="cabecalho"><h2><i class="icon-edit iconmd"></i> Editar Fatura</h2></div>
<div id="forms">
	<form action="" method="post" name="form" id="form" enctype="multipart/form-data">
    <strong>Cliente: <?php echo $linha['nome']; ?></strong><br/>
  <br/>

    Descrição da fatura:<br/>
    <input name="ref" type="text" value="<?php echo $linha['ref'];?>" style="width:400px;"><br/>

    Valor:<br/>
    <div class="input-prepend">
    <span class="add-on"><i class="icon-money"></i></span>
    <input name="valor" type="text" size="10" id="valor" value="<?php echo $linha['valor'];?>" style="text-align:right; width:60px;"><br/>
    </div><br/>

    Vencimento:<br/>
    <div class="input-prepend">
    <span class="add-on"><i class="icon-calendar"></i></span>
    <input type="text" name="data_venci" value="<?php echo $linha['data'] ?>" class="data_venci" style="width:100px;"/>
    </div><br/><br/>
    <div class="control-groupa">
    <div class="controlsa">

    <input name="editar" type="hidden" value="editar">

    <button type="submit" class="btn btn-success ewButton" name="editar">
    <i class="icon-thumbs-up icon-white"></i> Concluir edição</button>
    </div></div>
    </form>
</div>
</div>


</body>
</html>
