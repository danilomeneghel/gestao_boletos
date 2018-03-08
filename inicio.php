<?php
include "checalogin.php";
include "classes/conexao.php";
include "classes/funcoes.class.php";
include "php/config.php";

$conecta = new recordset();

include "php/recordsets.php";

$baixa = mysqli_query($conexao,"UPDATE faturas SET situacao = 'V' WHERE situacao != 'B' AND data_venci < DATE(NOW())");
?>

<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
	require ("classes/conexao.php");
	$sqld = mysqli_query($conexao,"SELECT * FROM config") or die(mysqli_error($conexao));
	$d = mysqli_fetch_array($sqld);
	?>
	<title><?php echo $d['nome'] ?> - Gestão de Boletos</title>
	<link href="css/jquery-uicss.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/icons.css" />
	<link href="css/principal.css" rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<?php
	if(isset($_GET['pg']) && $_GET['pg'] == "inicio"){
	?>
	<script type="text/javascript" src="js/jquery.charts.js"></script>
	<script type="text/javascript">
		$(function (){
			$("#estatistica").charts();
		})
	</script>
	<?php } ?>
	<script type="text/javascript" src="js/jquery.mask-money.js"></script>
</head>

<body>
	<div id="top">
		<div id="logo"><img src="<?php echo $config['logo']?>" width="110" height="66" class="LOGOIMG"></div>
			<div class="fontebranca">
				<div id="text-top"><?php echo $config['nome_sistema'] ?></div>
			</div>
		</div>
	</div>

	<div id="cssmenu"><?php require ("menu.php");?></div>

	<div style="clear:both"></div>

	<div id="contents">
		<div id="conteudo">
		  <div class="bar-success" id="includes">
		    	<?php
					if(isset($_GET['pg']) && $_GET['pg'] == "inicio"){
					include "pg/main.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "configuracoes"){
					include "pg/configura.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "banco"){
					include "pg/banco.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "numero"){
					include "pg/nossonumero.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "confboleto"){
					include "pg/configuraboleto.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "confmail"){
					include "pg/configmail.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "cadclientes"){
					include "pg/cadclientes.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "listaclientes"){
					include "pg/listaclientes.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "grupo"){
					include "pg/grupo.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "lancafatura"){
					include "pg/fatunica.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "fatpendente"){
					include "pg/fatpendente.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "fatvencida"){
					include "pg/fatvencidas.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "fatbaixada"){
					include "pg/fatbaixada.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "baixa"){
					include "retorno/index.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "periodica"){
					include "pg/fatperiodica.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "carne"){
					include "pg/fatPeriodo.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "recarne"){
					include "pg/recarne.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "modulos"){
					include "pg/modulosonline.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "modulos"){
					include "pg/modulosonline.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "fluxo"){
					include "pg/fluxogeral.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "listararquivos"){
					include "pg/listaarquivos.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "remessa"){
					include "remessa/remessa.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "listaremessa"){
					include "remessa/listaremessa.php";
					}
					elseif(isset($_GET['pg']) && $_GET['pg'] == "produtos"){
					include "pg/produtos.php";
					}
					else{
					echo "<h2> Esta página não existe.</h2>";
					}
					?>
		    </div>
		</div>

		<div id="rodape">Gestão de Boletos V. 3.0</div>
	</div>
	<?php mysqli_close($conexao);?>

</body>
</html>
