<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<?php
$data_h = date("Y-m-d");

if($_SESSION['id_usuario_session'] == 1) {
	$muda = mysqli_query($conexao,"SELECT * FROM faturas") or die(mysqli_error());
	while($conf = mysqli_fetch_array($muda)){
		$data_v =  $conf['data_venci'];

		if(strtotime($data_v) > strtotime($data_h)){
			$baixa = mysqli_query($conexao,"UPDATE faturas SET situacao = 'P' WHERE situacao != 'B' AND data_venci > DATE(NOW())");
		}
	}
} else {
	$muda = mysqli_query($conexao,"SELECT * FROM faturas WHERE id_cliente='$id_cliente'") or die(mysqli_error());
	while($conf = mysqli_fetch_array($muda)){
		$data_v =  $conf['data_venci'];

		if(strtotime($data_v) > strtotime($data_h)){
			$baixa = mysqli_query($conexao,"UPDATE faturas SET situacao = 'P' WHERE id_cliente='$id_cliente' AND situacao != 'B' AND data_venci > DATE(NOW())");
		}
	}
}
?>
<script type="text/javascript">
function marcardesmarcar(){
   if ($("#todos").attr("checked")){
      $('.marcar').each(
         function(){
            $(this).attr("checked", true);
         }
      );
   }else{
      $('.marcar').each(
         function(){
            $(this).attr("checked", false);
         }
      );
   }
}
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(pagina,nome,settings);
}
window.name = "main";

function validaCheckbox(v){
  todos = document.getElementsByTagName('input');
  for(x = 0; x < todos.length; x++) {
      if (todos[x].checked){
          return true;
      }
  }
  alert("Selecione pelo menos uma fatura!");
  return false;
}

function excluir(query){
	if (confirm ("Tem certeza que deseja excluir estes registros?")){
	window.location="php/delfat.php";
	return true;
	}
	else
	window.location="inicio.php?pg=fatvencida";
	return false;
	}

	function datas() {
	var datai = formu.datai.value;
	var dataf = formu.dataf.value;

	if (datai == "") {
	alert('Escolha uma data inicial.');
	formu.datai.focus();
	return false;
	}
	if (dataf == "") {
	alert('Escolha uma data final.');
	formu.dataf.focus();
	return false;
	}
}

$(document).ready(function () {
  $(".data").datepicker({
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
</script>

<?php
$sql2 = mysqli_query($conexao,"SELECT * FROM bancos WHERE situacao='1'")or die(mysqli_error());
$banco = mysqli_fetch_array($sql2);
$situacao = $banco['situacao'];
?>

<div id="entrada">
	<div id="cabecalho"><h2><i class="icon-external-link-sign  iconmd"></i> Faturas vencidas</h2></div>
	<div id="forms">
			<?php if($_SESSION['id_usuario_session'] == 1) { ?>
			<div id="form10">
				<form action="inicio.php?pg=fatbaixada" method="post" enctype="multipart/form-data">
					<div id="pesquizar">
						<span class="avisos">&nbsp;*Pesquize por cliente ou numero do documento</span><br/>
						<input name="pesquizar" type="text">
						<button type="submit" class="btn ewButton" name="pesq" id="btnsubmit" style="margin-top:-10px;"/>
						<i class="icon-search  icon-white"></i></button>
					</div>
				</form>
			</div>

			<div id="form11">
				<form action="inicio.php?pg=fatbaixada" method="post" enctype="multipart/form-data" name="formu" id="formu" onSubmit="return datas(this);">
					<span class="avisos">* Ou entre datas de vencimento</span><br/>
					<input name="datai" type="text" style="width:100px;" class="data"> e <input name="dataf" type="text" style="width:100px;" class="data">
					<button type="submit" class="btn ewButton" name="pesq" id="btnsubmit" style="margin-top:-10px;"/>
					<i class="icon-search  icon-white"></i></button>
				</form>
			</div>
			<?php } ?>

			<?php
			if($_SESSION['id_usuario_session'] == 1) {
				if(isset($_POST['pesquizar']) && $_POST['pesquizar'] != ""){
					$pesquisar = $_POST['pesquizar'];
					$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE situacao ='V' AND (nome LIKE '%$pesquisar%' OR num_doc LIKE '%$pesquisar%' OR nosso_numero LIKE '%$pesquisar%')";
				}elseif(isset($_POST['datai']) && $_POST['datai'] and $_POST['dataf'] != ""){
					$datai = implode("-",array_reverse(explode("/",$_POST['datai'])));
					$dataf = implode("-",array_reverse(explode("/",$_POST['dataf'])));
					$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE situacao ='V' AND data_venci BETWEEN ('$datai') AND ('$dataf')";
				}else{
					$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE situacao ='V' ORDER BY data_venci ASC";
				}
			} else {
				if(isset($_POST['pesquizar']) && $_POST['pesquizar'] != ""){
					$pesquisar = $_POST['pesquizar'];
					$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_cliente='$id_cliente' AND situacao ='V' AND (nome LIKE '%$pesquisar%' OR num_doc LIKE '%$pesquisar%' OR nosso_numero LIKE '%$pesquisar%')";
				}elseif(isset($_POST['datai']) && $_POST['datai'] and $_POST['dataf'] != ""){
					$datai = implode("-",array_reverse(explode("/",$_POST['datai'])));
					$dataf = implode("-",array_reverse(explode("/",$_POST['dataf'])));
					$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_cliente='$id_cliente' AND situacao ='V' AND data_venci BETWEEN ('$datai') AND ('$dataf')";
				}else{
					$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_cliente='$id_cliente' AND situacao ='V' ORDER BY data_venci ASC";
				}
			}
			// Pegar a página atual por GET
			@$p = $_GET["p"];
			// Verifica se a variável tá declarada, senão deixa na primeira página como padrão
			if(isset($p)) {
			$p = $p;
			} else {
			$p = 1;
			}
			// Defina aqui a quantidade máxima de registros por página.
			$qnt = 15;
			// O sistema calcula o início da seleção calculando:
			// (página atual * quantidade por página) - quantidade por página
			$inicio = ($p*$qnt) - $qnt;
			?>

			<div id="tabela1" style="width:98%;">
				<form name="form" action="php/delfat.php" method="post" enctype="multipart/form-data" onsubmit="return excluir(this);">
					<input name="pg" type="hidden" value="<?php echo $_GET['pg'] ?>">

					<table width="100%" border="0" cellspacing="1" cellpadding="5" data-rowindex="1" data-rowtype="1">
					<tbody>
					  <tr>
					    <th width="20"><input type="checkbox" name="todos" id="todos" value="todos" onclick="marcardesmarcar();" /></th>
							<th width="75"><span class="fontebranca">ID</span></th>
					    <th width="220"><span class="fontebranca">Nome</span></th>
					    <th width="222"><span class="fontebranca">Descrição</span></th>
					    <th width="75" align="center"><span class="fontebranca">Vencimento</span></th>
					    <th width="48" align="center"><span class="fontebranca">Valor</span></th>
					    <th width="62" align="center"><span class="fontebranca">Impresso</span></th>
					    <th width="211" align="center"><span class="fontebranca">Nosso Numero</span></th>
							<?php if($_SESSION['id_usuario_session'] == 1) { ?>
					    <th width="53" align="center"><span class="fontebranca">Reenviar</span></th>
					    <th colspan="3" align="center"><span class="fontebranca">Ações</span></th>
							<?php } else { ?>
							<th align="center"><span class="fontebranca">Ação</span></th>
							<?php } ?>
					    </tr>
					</tbody>
					<?php
					// Seleciona no banco de dados com o LIMIT indicado pelos números acima
					$sql_select = $sql_1." LIMIT $inicio, $qnt";
					// Executa o Query
					$sql_query = mysqli_query($conexao,$sql_select);
					// Cria um while para pegar as informações do BD
					while($array = mysqli_fetch_array($sql_query)) {
					// Variável para capturar o campo "nome" no banco de dados
					$nome = $array["nome"];
					$nm = $array['nosso_numero'];
					// Exibe o nome que está no BD e pula uma linha
					?>
				  <tr>
				    <td><input type="checkbox" name="id_venda[]" class="marcar" value="<?php echo $array['id_venda'] ?>" id="marcar"></td>
						<td align="left"><?php echo $array['id_venda']; ?></td>
				    <td align="left"><?php echo $array['nome']; ?></td>
				    <td align="left"><?php echo $array['ref']; ?></td>
				    <td align="center"><?php echo $array['data']; ?></td>
				    <td align="right"><?php echo number_format($array['valor'], 2, ',', '.'); ?></td>
				    <td align="center"><?php
						if($nm != "0"){
							echo "SIM";
						}else{
							echo "NÃO";
						}
						if($array['nosso_numero'] == 0){
							$var = "";
						}else{
							$var = $array['nosso_numero'];
						}
						?>
						</td>
				    <td align="left">
        		<?php
						if($array['nosso_numero'] == 0){
							echo $array['modulo'];
						}else{
							echo $array['nosso_numero'];
						}

						if(isset($_GET['p'])){
							$pagina = $_GET['p'];
							$vari = "&p=".$pagina;
						}
					 	?>
				    </td>
						<?php if($_SESSION['id_usuario_session'] == 1) { ?>
				    <td align="center" valign="middle">
				    	<a href="php/reenviarmailatraso.php?id_venda=<?php echo $array['id_venda'] ?>&idcliente=<?php echo $array['id_cliente'] ?><?php //echo $vari ?>">
				    	<img src="img/btmail.png" width="23" height="22" border="0" title="Reenviar email"></a>
						</td>
				    <td width="36" align="center">
							<div id="editar">
								<a href="pg/editafatura.php?id_venda=<?php echo $array['id_venda'] ?>&pg=fatvencida" class="editar" title="Editar dados"
								onclick="NovaJanela(this.href,'nomeJanela','650','450','yes');return false">Editar</a></span>
							</div>
						</td>
					  <td width="51" align="center">
							<div id="imprimir">
						  <?php if($banco['id_banco'] != '5'){?>
								<a href="<?php echo "boleto/".$link."?id_venda=".$array['id_venda']; ?>" target="_blank" class="editar">Imprimir</a>
							<?php }elseif($banco['id_banco'] == '5' && empty($array['linkGerencia'])){?>
								<a href="<?php echo "boleto/".$link."?id_venda=".$array['id_venda']; ?>" target="_blank" class="editar">Imprimir</a>
							<?php }else{ ?>
								<a href="<?php echo $array['linkGerencia']; ?>" target="_blank" class="editar">Imprimir</a>
							<?php } ?>
							</div>
						</td>
				    <td width="50" align="center">
							<div id="baixar">
				      	<?php if(isset($_GET['p'])){
								$pg = $_GET['p']; ?>
					      <a href="pg/baixamanual.php?id_venda=<?php echo $array['id_venda']; ?>" class="editar" title="Receber título" onclick="NovaJanela(this.href,'nomeJanela','650','450','yes');return false">Baixar</a>
					      <?php }else{ ?>
					      <a href="pg/baixamanual.php?id_venda=<?php echo $array['id_venda']; ?>&pagina=fatvencida" class="editar" title="Receber título" onclick="NovaJanela(this.href,'nomeJanela','650','450','yes');return false">Baixar</a> </span>
					      <?php } ?>
					    </div>
						</td>
						<?php } else { ?>
						<td width="51" align="center">
							<div id="imprimir">
						  <?php if($banco['id_banco'] != '5'){?>
								<a href="<?php echo "boleto/".$link."?id_venda=".$array['id_venda']; ?>" target="_blank" class="editar">Imprimir</a>
							<?php }elseif($banco['id_banco'] == '5' && empty($array['linkGerencia'])){?>
								<a href="<?php echo "boleto/".$link."?id_venda=".$array['id_venda']; ?>" target="_blank" class="editar">Imprimir</a>
							<?php }else{ ?>
								<a href="<?php echo $array['linkGerencia']; ?>" target="_blank" class="editar">Imprimir</a>
							<?php } ?>
							</div>
						</td>
						<?php } ?>
				  </tr>
					<?php } ?>
					<tr>
						<td colspan="12">
						<?php if($_SESSION['id_usuario_session'] == 1) { ?>
							<button type="submit" class="btn deleteboton ewButton" id="btnsubmit" onClick="return validaCheckbox(this);"/ >
							<i class="icon-trash icon-white"></i> Deletar Selecionados</button>
						<?php } ?>
						<?php
						if($_SESSION['id_usuario_session'] == 1) {
							$sqlsoma = mysqli_query($conexao,"SELECT sum(valor) AS val FROM faturas WHERE situacao ='V'");
						} else {
							$sqlsoma = mysqli_query($conexao,"SELECT sum(valor) AS val FROM faturas WHERE id_cliente='$id_cliente' AND situacao ='V'");
						}
						$c = mysqli_fetch_array($sqlsoma);
						$total = $c['val'];
						?>
						<div id="total-faturas"><strong>Valor total: <?php echo number_format($total, 2, ',', '.') ?></strong> </div>
					</table>
				</form>
			</div>
	</div>
</div>

<?php
// Depois que selecionou todos os nome, pula uma linha para exibir os links(próxima, última...)
echo "<br />";

// Faz uma nova seleção no banco de dados, desta vez sem LIMIT,
// para pegarmos o número total de registros
$sql_select_all = "SELECT * FROM faturas WHERE situacao ='V'";
// Executa o query da seleção acimas
$sql_query_all = mysqli_query($conexao,$sql_select_all);
// Gera uma variável com o número total de registros no banco de dados
$total_registros = mysqli_num_rows($sql_query_all);
// Gera outra variável, desta vez com o número de páginas que será precisa.
// O comando ceil() arredonda "para cima" o valor
$pags = ceil($total_registros/$qnt);
// Número máximos de botões de paginação
$max_links = 3;
// Exibe o primeiro link "primeira página", que não entra na contagem acima(3)
echo "<a class=\"pag\" href=\"inicio.php?pg=fatbaixada&p=1\" target=\"_self\">&laquo;&laquo; Primeira</a> ";
// Cria um for() para exibir os 3 links antes da página atual
for($i = $p-$max_links; $i <= $p-1; $i++) {
	// Se o número da página for menor ou igual a zero, não faz nada
	// (afinal, não existe página 0, -1, -2..)
	if($i>0) {
		// Se estiver tudo OK, cria o link para outra página
		echo "<a class=\"pag\" href=\"inicio.php?pg=fatbaixada&p=".$i."\" target=\"_self\">".$i."</a> ";
	}
}
// Exibe a página atual, sem link, apenas o número
echo "<span class=\"pags\">".$p."&nbsp;</span> ";
// Cria outro for(), desta vez para exibir 3 links após a página atual
for($i = $p+1; $i <= $p+$max_links; $i++) {
	// Verifica se a página atual é maior do que a última página. Se for, não faz nada.
	if($i < $pags) {
	  echo "<a class=\"pag\" href=\"inicio.php?pg=fatbaixada&p=".$i."\" target=\"_self\">".$i."</a> ";
	}
}
// Exibe o link "última página"
echo "<a class=\"pag\" href=\"inicio.php?pg=fatbaixada&p=".$pags."\" target=\"_self\">Ultima &raquo;&raquo;</a> ";
?>
