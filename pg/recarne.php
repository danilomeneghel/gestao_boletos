<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
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
	} else {
 	window.location="inicio.php?pg=recarne";
 	return false;
 	}
}

function baixar(query){
	if (confirm ("Tem certeza que esta fatura foi paga?")){
	window.location="php/baixa.php" + query;
	return true;
	}
	else
	window.location="inicio.php?pg=recarne";
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
	<div id="cabecalho"><h2><i class="icon-external-link-sign  iconmd"></i> Faturas em Grupo</h2></div>
	<div id="forms">
    <?php if($_SESSION['id_usuario_session'] == 1) { ?>
		<div id="form10">
			<form action="inicio.php?pg=recarne" method="post" enctype="multipart/form-data">
				<div id="pesquizar">
					<span class="avisos">&nbsp;*Pesquize por cliente</span><br/>
					<input name="pesquizar" type="text">
					<button type="submit" class="btn ewButton" name="pesq" id="btnsubmit" style="margin-top:-10px;"/>
					<i class="icon-search  icon-white"></i></button>
				</div>
			</form>
		</div>
    <?php } ?>

		<?php
    if($_SESSION['id_usuario_session'] == 1) {
  		if(isset($_POST['pesquizar']) && $_POST['pesquizar'] != ""){
  		$pesquisar = $_POST['pesquizar'];
  		$sql_1 = "SELECT * ,date_format(data, '%d/%m/%Y') AS datas, COUNT(pedido) AS pedidos FROM faturas WHERE tipofatura='GRUPO' AND situacao !='B' AND nome LIKE '%$pesquisar%' OR nosso_numero LIKE '%$pesquisar%' GROUP BY pedido";
  		}else{
  		$sql_1 = "SELECT * ,date_format(data, '%d/%m/%Y') AS datas, COUNT(pedido) AS pedidos FROM faturas WHERE tipofatura='GRUPO' AND situacao !='B' GROUP BY pedido ORDER BY id_venda DESC";
  		}
    } else {
      if(isset($_POST['pesquizar']) && $_POST['pesquizar'] != ""){
  		$pesquisar = $_POST['pesquizar'];
  		$sql_1 = "SELECT * ,date_format(data, '%d/%m/%Y') AS datas, COUNT(pedido) AS pedidos FROM faturas WHERE id_cliente='$id_cliente' AND tipofatura='GRUPO' AND situacao !='B' AND nome LIKE '%$pesquisar%' OR nosso_numero LIKE '%$pesquisar%' GROUP BY pedido";
  		}else{
  		$sql_1 = "SELECT * ,date_format(data, '%d/%m/%Y') AS datas, COUNT(pedido) AS pedidos FROM faturas WHERE id_cliente='$id_cliente' AND tipofatura='GRUPO' AND situacao !='B' GROUP BY pedido ORDER BY id_venda DESC";
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
		$qnt = 5;
		// O sistema calcula o início da seleção calculando:
		// (página atual * quantidade por página) - quantidade por página
		$inicio = ($p*$qnt) - $qnt;
		?>

		<div id="tabela1" style="width:98%;">
			<form name="form" action="php/delfat_grupo.php?pe=recarne" method="post" enctype="multipart/form-data" onsubmit="return excluir(this);">
			<input name="pg" type="hidden" value="recarne" />
				<table width="100%" border="0" cellspacing="1" cellpadding="5" data-rowindex="1" data-rowtype="1">
				  <tr>
				    <th width="3%"><input type="checkbox" name="todos" id="todos" value="todos" onclick="marcardesmarcar();" /></th>
				    <th width="23%"><span class="fontebranca">Nome</span></th>
				    <th width="14%"><span class="fontebranca">Descrição</span></th>
				    <th width="13%"><span class="fontebranca">Data de emissão</span>	</th>
				    <th width="13%"><span class="fontebranca">Parcelas</span></th>
            <th width="8%" align="center"><span class="fontebranca">Valor</span></th>
            <?php if($_SESSION['id_usuario_session'] == 1) { ?>
				    <th colspan="3" align="center"><span class="fontebranca">Ações</span></th>
            <?php } ?>
				  </tr>
				<?php
				// Seleciona no banco de dados com o LIMIT indicado pelos números acima
				$sql_select = $sql_1." LIMIT $inicio, $qnt";
				// Executa o Query
				$sql_query = mysqli_query($conexao,$sql_select);

				$contar = mysqli_num_rows($sql_query);

				$totalgeral = 0;

				// Cria um while para pegar as informações do BD
				while($array = mysqli_fetch_array($sql_query)) {
				// Variável para capturar o campo "nome" no banco de dados
				$nome = $array["nome"];
				$totalgeral += $array['valor_recebido'];
				// Exibe o nome que está no BD e pula uma linha
				$jurosb = $array['valor_recebido'] - $array['valor'];
				?>
				  <tr>
				    <td><input type="checkbox" name="pedido[]" class="marcar" value="<?php echo $array['pedido'] ?>" id="id_cliente"></td>
				    <td align="left"><?php echo $array['nome']; ?></td>
				    <td align="left"><?php echo $array['ref']; ?></td>
				    <td align="left"><?php echo $array['datas']; ?></td>
				    <td align="left"><?php echo $array['pedidos'] ?></td>
				    <td align="right"><?php echo number_format($array['valor'], 2, ',', '.'); ?></td>
            <?php if($_SESSION['id_usuario_session'] == 1) { ?>
						<td width="36" align="center">
							<div id="editar">
								<a href="pg/editafatura.php?id_venda=<?php echo $array['id_venda'] ?>" class="editar" title="Editar dados"
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
								<a href="pg/baixamanual.php?id_venda=<?php echo $array['id_venda']; ?>&pagina=recarne" class="editar" title="Receber título" onclick="NovaJanela(this.href,'nomeJanela','650','450','yes');return false">Baixar</a> </span>
								<?php } ?>
							</div>
						</td>
          <?php } ?>
				  </tr>
				<?php } ?>
					<tr>
						<td colspan="9">
              <?php if($_SESSION['id_usuario_session'] == 1) { ?>
			           <button type="submit" class="btn deleteboton ewButton" id="btnsubmit" onClick="return confirm('Confirma exclusão do registro?')"/ >
			           <i class="icon-trash icon-white"></i> Deletar Selecionados</button>
              <?php } ?>
					    <div id="total-faturas"><strong>Valor total: <?php echo number_format($totalgeral, 2, ',', '.') ?></strong></div>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>

<?php
if(!isset($_GET['p'])){
	$p=1;
}

// Depois que selecionou todos os nome, pula uma linha para exibir os links(próxima, última...)
echo "<br />";

// Faz uma nova seleção no banco de dados, desta vez sem LIMIT,
// para pegarmos o número total de registros
$sql_select_all = "SELECT * , COUNT(pedido) AS pedidos FROM faturas WHERE tipofatura='carne' AND situacao !='B'  GROUP BY pedido";
// Executa o query da seleção acimas
$sql_query_all = mysqli_query($conexao, $sql_select_all);
// Gera uma variável com o número total de registros no banco de dados
$total_registros = mysqli_num_rows($sql_query_all);
// Gera outra variável, desta vez com o número de páginas que será precisa.
// O comando ceil() arredonda "para cima" o valor
$pags = ceil($total_registros/$qnt);
// Número máximos de botões de paginação
$max_links = 3;
// Exibe o primeiro link "primeira página", que não entra na contagem acima(3)
echo "<a class=\"pag\" href=\"inicio.php?pg=recarne&p=1\" target=\"_self\">&laquo;&laquo; Primeira</a> ";
// Cria um for() para exibir os 3 links antes da página atual
for($i = $p-$max_links; $i <= $p-1; $i++) {
	// Se o número da página for menor ou igual a zero, não faz nada
	// (afinal, não existe página 0, -1, -2..)
	if($i>0) {
		echo "<a class=\"pag\" href=\"inicio.php?pg=recarne&p=".$i."\" target=\"_self\">".$i."</a> ";
	}
}
// Exibe a página atual, sem link, apenas o número
echo "<span class=\"pags\">".$p."&nbsp;</span> ";
// Cria outro for(), desta vez para exibir 3 links após a página atual
for($i = $p+1; $i <= $p+$max_links; $i++) {
	// Verifica se a página atual é maior do que a última página. Se for, não faz nada.
	if($i < $pags) {
		echo "<a class=\"pag\" href=\"inicio.php?pg=recarne&p=".$i."\" target=\"_self\">".$i."</a> ";
	}
}
// Exibe o link "última página"
echo "<a class=\"pag\" href=\"inicio.php?pg=recarne&p=".$pags."\" target=\"_self\">Ultima &raquo;&raquo;</a> ";
?>
