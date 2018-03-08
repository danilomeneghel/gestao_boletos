<style>
#resposta{color:#F00;}
</style>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funcoes.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>

<script type="text/javascript">
function validar_cliente() {
	var nome = form.nome.value;
	var cpfcnpj = form.cpfcnpj.value;
	var nascimento = form.nascimento.value;
	var rg = form.rg.value;
	var endereco = form.endereco.value;
	var numero = form.numero.value;
	var cidade = form.cidade.value;
	var uf = form.uf.value;
	var pais = form.pais.value;
	var cep = form.cep.value;
	var id_grupo = form.id_grupo.value;
	var email = form.email.value;
	var usuario = form.usuario.value;
	var senha = form.senha.value;
	var callback = null;

	if (nome == "") {
	alert('Digite o nome do cliente.');
	form.nome.focus();
	return false;
	}

	if (cpfcnpj == "") {
	alert('Digite o CPF ou CNPJ.');
	form.cpfcnpj.focus();
	return false;
	} else {
		$.ajax({
			url: "php/checacpfcnpj.php",
		  type: "POST",
		  async: false,
		  data: {cpfcnpj: cpfcnpj},
		  success: function(data){
				data = $.parseJSON(data);
				if(data.cpfcnpj != 0) {
					alert(data.cpfcnpj);
				 	callback = false;
			 	}
		  }
		});
		if(callback === false)
			return false;
	}

	if (nascimento == "") {
	alert('Digite a data de nascimento.');
	form.nascimento.focus();
	return false;
	}

	if (rg == "") {
	alert('Digite numero do RG.');
	form.rg.focus();
	return false;
	}

	if (id_grupo == "") {
	alert('Selecione um grupo para o cliente.');
	form.id_grupo.focus();
	return false;
	}

	if (endereco == "") {
	alert('Digite o endereço.');
	form.endereco.focus();
	return false;
	}

	if (numero == "") {
	alert('Digite o numero do endereço.');
	form.numero.focus();
	return false;
	}

	if (cidade == "") {
		alert('Digite o Cidade.');
		form.cidade.focus();
		return false;
	}

	if (uf == "") {
		alert('Digite o UF.');
		form.uf.focus();
		return false;
	}

	if (pais == "") {
		alert('Digite o País.');
		form.pais.focus();
		return false;
	}

	if (cep == "") {
	alert('Digite o CEP.');
	form.cep.focus();
	return false;
	}

	if (email == "") {
	alert('Digite o email do cliente.');
	form.email.focus();
	return false;
	} else {
		$.ajax({
			url: "php/checaemail.php",
		  type: "POST",
		  async: false,
		  data: {email: email},
		  success: function(data){
				data = $.parseJSON(data);
				if(data.email != 0) {
					alert(data.email);
				 	callback = false;
			 	}
		  }
		});
		if(callback === false)
			return false;
	}

	if (usuario == "") {
	alert('Digite o usuario do cliente.');
	form.usuario.focus();
	return false;
	} else {
		$.ajax({
			url: "php/checausuario.php",
		  type: "POST",
		  async: false,
		  data: {usuario: usuario},
		  success: function(data){
				data = $.parseJSON(data);
				if(data.usuario != 0) {
					alert(data.usuario);
				 	callback = false;
			 	}
		  }
		});
		if(callback === false)
			return false;
	}

	if (senha == "") {
	alert('Digite a senha do cliente.');
	form.senha.focus();
	return false;
	}

} ////////////// FIM DA FUNCTION /////////////////////

jQuery(function ($) {
    $("#telefone").mask("(99) 99999-9999");
    $("#cpf").mask("999.999.999-99");
    $("#cnpj").mask("99.999.999/9999-99");
		$("#nascimento").mask("99/99/9999");
		$("#cep").mask("99999-999");
});

function up(lstr){ // converte minusculas em maiusculas
	var str=lstr.value; //obtem o valor
	lstr.value=str.toUpperCase(); //converte as strings e retorna ao campo
}
</script>

<div id="entrada">
<div id="cabecalho"><h2><i class="icon-user iconmd"></i> Cadastrar Clientes</h2></div>
<div id="forms">

<form action="" method="post" enctype="multipart/form-data" id="gravacliente" name="form" onSubmit="return validar_cliente(this);">

<table width="750" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td width="33%" align="left" valign="top">Nome:<br/>
			<input name="nome" type="text" size="43" onkeyup="up(this)">
		</td>
    <td width="33%" align="left" valign="top">CPF/CNPJ:<br/>
    	<input name="cpfcnpj" type="text" id="cpfcnpj" onkeydown="javascript:return aplica_mascara_cpfcnpj(this,18,event)" onkeyup="javascript:return aplica_mascara_cpfcnpj(this,18,event)" size="43" maxlength="18">
			<div id='resposta'></div>
    </td>
    <td width="33%" align="left" valign="top">
    	Data de Nascimento:<br/>
      <input name="nascimento" type="text" style="width:110px" id="nascimento">
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">RG:<br/>
			<input name="rg" type="text" size="9" id="rg" onkeydown="javascript:return valida_numero(event)" onkeyup="javascript:return valida_numero(event)" maxlength="15">
		</td>
    <td align="left" valign="top">
			Inscrição estadual / Municipal:<br/>
    	<input name="inscricao" type="text" maxlength="20">
  	</td>
    <td align="left" valign="top">Grupo:<br/>
      <select name="id_grupo" id="id_grupo">
        <option value="1">AVULSO</option>
        <?php
					$sql1 = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo !='1' ORDER BY id_grupo ASC")or die (mysqli_error());
					while($ver = mysqli_fetch_array($sql1)){
						$id_grupo = $ver['id_grupo'];
				?>
      	<option value="<?php echo $id_grupo?>"><?php echo $ver['nomegrupo']." - ".$ver['meses']." mês(es)"; ?></option>
        <?php } ?>
      </select>
		</td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="top" style="line-height:20px; height:20px"></td>
  </tr>
  <tr>
    <td align="left" valign="top">Endereço:<br/>
			<input name="endereco" type="text" onkeyup="up(this)" size="43">
		</td>
    <td align="left" valign="top">Numero:<br/>
			<input name="numero" type="text" onkeydown="javascript:return valida_numero(event)" onkeyup="javascript:return valida_numero(event)" size="10" id="numero" maxlength="10">
		</td>
    <td align="left" valign="top">Complemento:<br/>
			<input name="complemento" onkeyup="up(this)" type="text">
		</td>
  </tr>
  <tr>
    <td align="left" valign="top">Bairro:<br/>
			<input name="bairro" onkeyup="up(this)" type="text" size="43">
		</td>
    <td align="left" valign="top">Cidade:<br/>
			<input name="cidade" onkeyup="up(this)" type="text" id="cidade">
		</td>
    <td align="left" valign="top">UF:<br/>
			<input name="uf" type="text" id="uf" onkeyup="up(this)" size="2" maxlength="2" style="width:30px;">
		</td>
  </tr>
  <tr>
		<td align="left" valign="top">País:<br/>
			<input name="pais" type="text" maxlength="20">
		</td>
    <td align="left" valign="top">CEP:<br/>
    	<input name="cep" type="text" size="9" id="cep">
		</td>
		<td align="left" valign="top">Telefone:<br/>
			<input name="telefone" type="text" size="14" id="telefone">
		</td>
	</tr>
  <tr>
    <td colspan="2" align="left" valign="top">E-mail:<br/>
			<input name="email" type="email" style="width:450px" id="email">
		</td>
    <td align="left" valign="top">
    <fieldset>
      <legend><strong>Observação</strong></legend>
      <span class="avisos">
      Por este email o cliente receberá as faturas.</span>
      </fieldset>
      </td>
    </tr>
  <tr>
	<tr>
    <td colspan="4" align="left" valign="top" style="line-height:20px; height:20px"></td>
  </tr>
	<tr>
    <td align="left" valign="top">Usuário:<br/>
			<input name="usuario" type="text" id="usuario" maxlength="20">
		</td>
    <td colspan="2" align="left" valign="top">Senha:<br/>
			<input name="senha" type="text" id="senha" maxlength="10">
		</td>
  </tr>
  <tr>
		<td colspan="4" align="left" valign="top">
			<div class="control-groupa">
			<div class="controlsa">
				<input name="clientegr" type="hidden" value="clientegr">
				<button type="submit" class="btn btn-success ewButton" name="clientegr" id="btnsubmit" >
					<i class="icon-thumbs-up icon-white"></i> Cadastrar cliente</button>
			</div>
	  </td>
  </tr>
</table>
</form>
</div>
</div>
