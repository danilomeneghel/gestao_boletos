<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
function validar() {
	var id_grupo = form.id_grupo.value;
	var ref = form.ref.value;
	var data_venci = form.data_venci.value;

	if (id_grupo == "0") {
	alert('Selecione um grupo de clientes.');
	form.id_grupo.focus();
	return false;
	}

	if (data_venci == "") {
	alert('Selecione a data de vencimento.');
	form.data_venci.focus();
	return false;
	}
} ////////////// FIM DA FUNCTION /////////////////////
</script>
<script>
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
</script>
<script type="text/javascript" src="js/jquery.mask-money.js"></script>

<div id="menufatura">
	<ul>
    	<li>
        <div class="control-group">
	        <div class="controls">
		        <div class="btn ewButton" name="user" id="btnsubmit"/ >
		        	<a href="inicio.php?pg=lancafatura" style=" text-decoration:none; color:#000;">
		        	<i class="icon-refresh"></i> Fatura unica</a>
						</div>
					</div>
				</div>
      </li>
      <li>
       	<div class="control-group">
	        <div class="controls">
		        <div class="btn ewButton" name="user" id="btnsubmit"/ >
		        	<a href="inicio.php?pg=periodica" style=" text-decoration:none; color:#000;">
		        	<i class="icon-refresh"></i> Fatura para grupo de clientes</a>
						</div>
					</div>
				</div>
      </li>
  </ul>
</div>
<div style="clear:both;"></div>
<br/>

<div id="entrada">
<?php
$fat = mysqli_query($conexao,"SELECT * FROM faturas") or die(mysqli_error());
$cont = mysqli_num_rows($fat);
?>
<div id="cabecalho">
  <h2><i class="icon-money iconmd"></i> Fatura para grupo</h2>
</div>
<div id="forms">
	<form action="" method="post" name="form" id="form" enctype="multipart/form-data" onSubmit="return validar(this);">
    Grupo de Clientes:<br/>
    <select name="id_grupo">
  		<option value="0">Selecione um grupo...</option>
			<?php
			$sql = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo != '1' ORDER BY id_grupo ASC")or die (mysqli_error());
			while($linha = mysqli_fetch_array($sql)){
			?>
    	<option value="<?php echo $linha['id_grupo'] ?> ">
			<?php echo $linha['nomegrupo']; ?></option>
    	<?php } ?>
  	</select><br/>

		Vencimento:<br/>
    <div class="input-prepend">
    <span class="add-on"><i class="icon-calendar"></i></span>
    <input type="text" name="data_venci" class="data_venci" style="width:100px;" />
    </div><br/>

		Descrição das faturas:<br/>
		<input name="ref" type="text" style="width:400px;"><br/>

    <div class="control-groupa">
	    <div class="controlsa">
		    <input name="lancafatperiodica" type="hidden" value="lancafatperiodica">
		    <button type="submit" class="btn btn-success ewButton" name="lancafatperiodica">
		    <i class="icon-thumbs-up icon-white"></i> Lançar Fatura</button>
	    </div>
		</div>
  </form>
</div>
