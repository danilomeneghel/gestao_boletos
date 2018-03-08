<div id="conteudoform">
<script type="text/javascript">
function confirmar_cliente(query){
if (confirm ("Tem certeza que deseja excluir este usuário?")){
 window.location="php/deleta_cliente.php" + query;
 return true;
 }
 else
 window.location="inicio.php?pg=listaclientes";
 return false;
 }
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(pagina,nome,settings);
	}
window.name = "main";
</script>

<div id="entrada">
	<div id="cabecalho"><h2><i class="icon-user iconmd"></i> Listar Clientes</h2></div>
	<div id="forms">
	<div id="form10">
		<form action="inicio.php?pg=listaclientes" method="post" enctype="multipart/form-data">
			<span class="avisos">&nbsp;*Pesquise pelo nome do cliente</span><br/>
			<input name="pesquizar" type="text">
			<button type="submit" class="btn ewButton" name="pesq" id="btnsubmit" style="margin-top:-10px;"/>
			<i class="icon-search  icon-white"></i></button>
		</form>
	</div>
	<?php
	if(isset($_POST['pesquizar']) && $_POST['pesquizar'] != ""){
		$pesquisar = $_POST['pesquizar'];
		$sql_1 = "SELECT * FROM cliente WHERE nome LIKE '%$pesquisar%' ORDER BY nome ASC";
	}else{
		$sql_1 = "SELECT * FROM cliente ORDER BY nome ASC";
	}

	// Total de clientes
	$sql_rows = mysqli_query($conexao,$sql_1);
	$totalgeral = mysqli_num_rows($sql_rows);

	// Pegar a página atual por GET
	@$p = $_GET["p"];
	// Verifica se a variável tá declarada, senão deixa na primeira página como padrão
	if(isset($p)) {
		$p = $p;
	} else {
		$p = 1;
	}
	// Defina aqui a quantidade máxima de registros por página.
	$qnt = 20;
	// O sistema calcula o início da seleção calculando:
	// (página atual * quantidade por página) - quantidade por página
	$inicio = ($p*$qnt) - $qnt;
	?>
	<div id="tabela1" style="width:98%;">
		<table width="100%" border="0" cellspacing="1" cellpadding="5" data-rowindex="1" data-rowtype="1">
		  <tr>
		    <th width="5%"><span class="fontebranca">COD</span></td>
		    <th width="30%"><span class="fontebranca">NOME</span></td>
		    <th width="10%"><span class="fontebranca">TELEFONE</span></td>
		    <th width="35%" align="center"><span class="fontebranca">EMAIL</span></td>
		    <th width="8%" align="center"><span class="fontebranca">GRUPO</span></td>
				<th width="6%"><span class="fontebranca">SITUAÇÃO</span></td>
		    <th width="6%" align="center"><span class="fontebranca">AÇÃO</span></td>
	    </tr>
			<?php
			// Seleciona no banco de dados com o LIMIT indicado pelos números acima
			$sql_select = $sql_1." LIMIT $inicio, $qnt";
			// Executa o Query
			$sql_query = mysqli_query($conexao,$sql_select);

			// Cria um while para pegar as informações do BD
			while($array = mysqli_fetch_array($sql_query)) {
			// Variável para capturar o campo "nome" no banco de dados
			$idgrupo = $array['id_grupo'];
			?>
		  <tr>
		    <td align="center"><?php echo $array['id_cliente'] ?></td>
		    <td align="left"><?php echo $array['nome']; ?></td>
		    <td align="left"><?php echo $array['telefone']; ?></td>
		    <td align="left"><?php echo $array['email']; ?></td>
		    <?php
					if($array['bloqueado'] == "N"){
						$sit = "ATIVO";
					}else{
						$sit = "BLOQUEADO";
					}
				?>
		    <?php
				$dad = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo = '$idgrupo'");
				$dado = mysqli_fetch_array($dad);
				if($dado['nomegrupo'] == ""){
					$grupo = "AVULSO";
				}else{
					$grupo = $dado['nomegrupo'];
				}
			?>
		    <td align="left"><?php echo $grupo; ?></td>
				<td align="center"><?php echo $sit ?></td>
		    <td align="right">
		      <div class="btn-group">
		        <a href="pg/editacliente.php?id=<?php echo $array['id_cliente'] ?>&p=<?php echo $p ?>" style="text-decoration:none;"
		        class="btn btn-default" onclick="NovaJanela(this.href,'nomeJanela','740','500','yes');return false" title="Editar">
		        <i class="icon-edit"></i></a>
		        <a class="btn btn-default"
		        href="javascript:confirmar_cliente('?pg=listaclientes&deleta=cliente&id=<?php echo $array['id_cliente'] ?>&p=<?php echo $p ?>')"
		         style="text-decoration:none;" title="Excluir cadastro">
		       <i class="icon-trash"></i></a>
		      </div>
		    </td>
		    </tr>
		<?php } ?>
			<tr>
		  	<td colspan="7">
		      <div id="total-faturas"><strong>Total geral: <?php echo number_format($totalgeral) ?></strong></div>
		    </td>
		  </tr>
		</table>
	</div>
</div>
</div>

<?php
// Depois que selecionou todos os nome, pula uma linha para exibir os links(próxima, última...)
echo "<br />";

// Faz uma nova seleção no banco de dados, desta vez sem LIMIT,
// para pegarmos o número total de registros
$sql_select_all = "SELECT * FROM cliente";
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
echo "<a class=\"pag\" href=\"inicio.php?pg=listaclientes&p=1\" target=\"_self\">&laquo;&laquo; Primeira</a> ";
// Cria um for() para exibir os 3 links antes da página atual
for($i = $p-$max_links; $i <= $p-1; $i++) {
// Se o número da página for menor ou igual a zero, não faz nada
// (afinal, não existe página 0, -1, -2..)
if($i <=0) {
//faz nada
// Se estiver tudo OK, cria o link para outra página
} else {
echo "<a class=\"pag\" href=\"inicio.php?pg=listaclientes&p=".$i."\" target=\"_self\">".$i."</a> ";
}
}
// Exibe a página atual, sem link, apenas o número
echo "<span class=\"pags\">".$p."&nbsp;</span> ";
// Cria outro for(), desta vez para exibir 3 links após a página atual
for($i = $p+1; $i <= $p+$max_links; $i++) {
// Verifica se a página atual é maior do que a última página. Se for, não faz nada.
if($i > $pags)
{
//faz nada
}
// Se tiver tudo Ok gera os links.
else
{
echo "<a class=\"pag\" href=\"inicio.php?pg=listaclientes&p=".$i."\" target=\"_self\">".$i."</a> ";
}
}
// Exibe o link "última página"
echo "<a class=\"pag\" href=\"inicio.php?pg=listaclientes&p=".$pags."\" target=\"_self\">Ultima &raquo;&raquo;</a> ";
?>
