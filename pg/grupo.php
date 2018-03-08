<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mask-money.js"></script>
<script type="text/javascript">
function validar_grupo() {
	var nomegrupo = form.nomegrupo.value;
	var meses = form.meses.value;
	var valor = form.valor.value;

	if (nomegrupo == "") {
	alert('Digite o nome do grupo.');
	form.nomegrupo.focus();
	return false;
	}

	if (meses == "") {
	alert('Digite o intervalo do vencimento.');
	form.meses.focus();
	return false;
	}

	if (valor == "") {
	alert('Digite o valor.');
	form.valor.focus();
	return false;
	}
}

$(document).ready(function() {
  $("#valor").maskMoney({decimal:",",thousands:""});
});

function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(pagina,nome,settings);
}
window.name = "main";
</script>

<div id="entrada">
	<div id="cabecalho"><h2><span class="iconfont grupo"> Grupo de Clientes</span></h2></div>
	<div id="forms">
	<form action="" method="post" enctype="multipart/form-data" name="form" onSubmit="return validar_grupo(this);">
		Nome do grupo:<br/>
		<input name="nomegrupo" id="nomegrupo" type="text"><br/>
		Intervalo do vencimento:<br/>
		<select name="meses" id="meses">
		  <option value="1">30 dias</option>
		  <option value="2">60 dias</option>
		  <option value="3">90 dias</option>
		  <option value="6">6 meses</option>
		  <option value="12">1 ano</option>
		  <option value="24">2 anos</option>
		  <option value="36">3 anos</option>
		</select>
		<br/>
		Valor:<br/>
		<input name="valor" id="valor" type="text"><br/>
		<div class="controlsa">
		  <button type="submit" class="btn btn-success ewButton" name="cadgrupocli" id="btnsubmit" >
			<i class="icon-thumbs-up icon-white"></i> Cadastrar grupo de cliente</button>
		</div>
	</form>
	<br/>

	<hr/>
	<div id="tabela1" style="width:98%;">
	    <table width="100%" cellspacing="1">
	        <tr>
	          <th width="360" align="left">Grupo</th>
	          <th width="112" align="left">Intervalo de Vencimento</th>
	          <th width="112" align="left">Valor</th>
	          <th width="71" align="center">Ações</th>
	        </tr>
	        <?php
					$gr = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo !='1'");
				  while($g = mysqli_fetch_array($gr)){
				  ?>
	        <tr>
	          <td><?php echo $g['nomegrupo']; ?></td>
	          <td><strong><?php echo $g['meses']; ?> mês(es)</strong></td>
	          <td><strong><?php echo $g['valor']; ?></strong></td>
	          <td align="left">
	            <div class="btn-group">
	              <a href="pg/upgrupo.php?id_grupo=<?php echo $g['id_grupo'];?>" name="modal" style="text-decoration:none;" class="btn btn-default" onclick="NovaJanela(this.href,'nomeJanela','400','350','yes');return false"><i class="icon-edit"></i></a>
	              <a class="btn btn-default" onClick="return confirm('Confirma a exclusão do grupo?')" href="inicio.php?pg=grupo&del=del&id_grupo=<?php echo $g['id_grupo'] ?>" style="text-decoration:none;"><i class="icon-trash"></i></a>
	            </div>
	          </td>
	        </tr>
	        <?php } ?>
	    </table>
		</div>
	</div>
</div>
