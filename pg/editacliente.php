<?php
include "../checalogin.php";
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Editar Cliente</title>
<style type="text/css">
body {
	background:#ebebeb;
	font-family:Verdana, Geneva, sans-serif; font-size:12px;
}
fieldset{
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
background:#FFFFFF;
overflow:hidden;
}
</style>
</head>
<script language="javascript">
function fechajanela() {
window.open("../inicio.php?pg=listaclientes","main");
}
</script>

<script type="text/javascript" src="../js/funcoes.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
<script type="text/javascript">
	jQuery(function ($) {
	    $("#telefone").mask("(99) 9999-9999");
	    $("#cep").mask("99999-999");
			$("#nascimento").mask("99/99/9999");
	});

	function up(lstr){ // converte minusculas em maiusculas
		var str=lstr.value; //obtem o valor
		lstr.value=str.toUpperCase(); //converte as strings e retorna ao campo
	}
</script>
<body onunload="fechajanela()">
	<div id="conteudoform">
	<?php
	function datas($dado){
		$data = explode("/", $dado);
		$dia = $data[0];
		$mes = $data[1];
		$ano = $data[2];

		$resultado = $ano."-".$mes."-".$dia;
		return $resultado;
	}

	include "../classes/conexao.php";

	if(isset($_POST['update'])){
		$id 				= $_GET['id'];
		$id_grupo		= $_POST['id_grupo'];
		$nome 			= $_POST['nome'];
		$cpfcnpj 		= $_POST['cpfcnpj'];
		$nascimento	= datas($_POST['nascimento']);
		$rg					= $_POST['rg'];
		$inscricao	= $_POST['inscricao'];
		$endereco		= $_POST['endereco'];
		$nome 			= $_POST['nome'];
		$numero 		= $_POST['numero'];
		$complemento= $_POST['complemento'];
		$bairro 		= $_POST['bairro'];
		$cidade 		= $_POST['cidade'];
		$pais 			= $_POST['pais'];
		$uf					= $_POST['uf'];
		$telefone 	= $_POST['telefone'];
		$cep				= $_POST['cep'];
		$uf					= $_POST['uf'];
		$pais				= $_POST['pais'];
		$email			= $_POST['email'];
		$bloqueado	= $_POST['bloqueado'];
		$usuario		= $_POST['usuario'];
		$senha			= $_POST['senha'];

		//Altera os dados do cliente
		$sql = mysqli_query($conexao,"UPDATE cliente SET id_grupo='$id_grupo', nome='$nome', cpfcnpj='$cpfcnpj', nascimento = '$nascimento', inscricao='$inscricao',
			rg='$rg', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade',
	 		uf='$uf', pais = '$pais', telefone='$telefone', cep='$cep', email='$email', bloqueado='$bloqueado' WHERE id_cliente='$id'")or die (mysqli_error());

		//Altera os dados do acesso
		if(!empty($senha)) {
			$senha = sha1($_POST['senha']);
			$sql2 = mysqli_query($conexao,"UPDATE usuario SET senha='$senha' WHERE usuario='$usuario'");
		}

		if($sql == 1){
			print "<script type=\"text/javascript\">javascript:window.close()</script>";
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
		$id = $_GET['id'];
		$sql = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$id'")or die (mysqli_error());
		$row_cliente = mysqli_fetch_array($sql);

		$id_usuario = $row_cliente['id_usuario'];
		$sql2 = mysqli_query($conexao,"SELECT * FROM usuario WHERE id_usuario='$id_usuario'")or die (mysqli_error());
		$row_usuario = mysqli_fetch_array($sql2);
	?>
	<fieldset style="border:1px solid #666;"><legend><strong>Editar Cliente</strong></legend>

	<form action="" method="post" enctype="multipart/form-data" id="clientes">

	<table width="600" border="0" cellspacing="1" cellpadding="5">
	  <tr>
	    <td width="33%" align="left" valign="top">Nome:<br/>
	    	<input name="nome" onkeyup="up(this)" type="text" size="35" value="<?php echo $row_cliente['nome'] ?>">
			</td>
	    <td width="33%" align="left" valign="top">CPF/CNPJ:<br/>
	    	<input name="cpfcnpj" onkeydown="javascript:return aplica_mascara_cpfcnpj(this,18,event)" onkeyup="javascript:return aplica_mascara_cpfcnpj(this,18,event)" size="18" maxlength="18" style="width:120px;" value="<?php echo $row_cliente['cpfcnpj'] ?>"><br/>
			</td>
	    <td width="33%" align="left" valign="top">Data de Nascimento:<br/>
	      <input name="nascimento"  type="text" id="nascimento" style="width:70px;"  value="<?php echo date('d/m/Y', strtotime($row_cliente['nascimento'])); ?>">
	  	</td>
	  </tr>
	  <tr>
	    <td align="left" valign="top">RG:<br/>
				<input name="rg" type="text" value="<?php echo $row_cliente['rg'] ?>">
			</td>
	    <td align="left" valign="top">IE / IM:<br/>
	    	<input name="inscricao" type="text" value="<?php echo $row_cliente['inscricao']?>">
	    </td>
	    <td align="left" valign="top">Grupo:<br/>
	      <select name="id_grupo">
					<option value="1">AVULSO</option>
	        <?php
						$confi = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$id'")or die (mysqli_error());
						$confere = mysqli_fetch_array($confi);
						$idss = $confere['id_grupo'];

						$sql1 = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo != '1' ORDER BY id_grupo ASC")or die (mysqli_error());
						while($ver = mysqli_fetch_array($sql1)){
							$id_g= $ver['id_grupo'];
							$nomegrupo = $ver['nomegrupo'];
					?>
	      	<option value="<?php echo $ver['id_grupo'] ?>" <?php if(!(strcmp($id_g, $idss))) {echo "selected=\"selected\"";} ?>>
					<?php echo $nomegrupo; echo " - ".$ver['meses']." mês(es)";?></option>
	      	<?php } ?>
	      </select>
			</td>
	  </tr>
	  <tr>
	    <td colspan="4" align="left" valign="top" style="line-height:20px; height:20px"></td>
	  </tr>
	  <tr>
	    <td align="left" valign="top">Endereço:<br/>
	    	<input name="endereco" type="text" size="35" onkeyup="up(this)" value="<?php echo $row_cliente['endereco'] ?>">
			</td>
	    <td align="left" valign="top">Numero:<br/>
	    	<input name="numero" type="text" size="10" onkeyup="up(this)" maxlength="10" value="<?php echo $row_cliente['numero'] ?>">
			</td>
	    <td align="left" valign="top">Complemento:<br/>
	      <input name="complemento" type="text" onkeyup="up(this)" value="<?php echo $row_cliente['complemento'] ?>">
			</td>
	  </tr>
	  <tr>
	    <td align="left" valign="top">Bairro:<br/>
	    	<input name="bairro" type="text" onkeyup="up(this)" size="35" value="<?php echo $row_cliente['bairro'] ?>">
			</td>
	    <td align="left" valign="top">Cidade:<br/>
	    	<input name="cidade" type="text" onkeyup="up(this)" value="<?php echo $row_cliente['cidade'] ?>">
			</td>
	    <td align="left" valign="top">UF:<br/>
	      <input name="uf" type="text" size="2" onkeyup="up(this)" maxlength="2" value="<?php echo $row_cliente['uf'] ?>">
			</td>
	  </tr>
	  <tr>
	    <td align="left" valign="top">País:<br/>
	    	<input name="pais" type="text" size="14" id="pais" value="<?php echo $row_cliente['pais'] ?>">
			</td>
	    <td align="left" valign="top">Telefone:<br/>
	    	<input name="telefone" type="text" size="14" id="telefone" value="<?php echo $row_cliente['telefone'] ?>">
			</td>
	    <td align="left" valign="top">CEP:<br/>
	    	<input name="cep" type="text" size="9" id="cep" value="<?php echo $row_cliente['cep'] ?>">
			</td>
	  </tr>
	  <tr>
	    <td colspan="3" align="left" valign="top">E-mail:<br/>
				<input name="email" type="email" size="35" value="<?php echo $row_cliente['email'] ?>">
			</td>
		</tr>
		<tr>
			<td colspan="4" align="left" valign="top" style="line-height:20px; height:20px"></td>
		</tr>
		<tr>
	    <td align="left" valign="top">Usuário:<br/>
	    	<input name="usuario" type="text" size="14" id="usuario" readonly value="<?php echo $row_usuario['usuario'] ?>" style="background-color:#F4F4F4">
			</td>
	    <td align="left" valign="top">Senha:<br/>
	    	<input name="senha" type="text" size="14" id="senha">
			</td>
	  	<td align="left" valign="top" style="padding-left:5px;">
		    <fieldset style="width:90%;border:1px solid #666; color:green;">
		    <legend style="margin-left:5px;">Bloquear cliente</legend>
		      <input name="bloqueado" type="radio" value="S" <?php if($row_cliente['bloqueado'] == "S"){echo "checked=\"checked\"";} ?>>Sim
		      <input name="bloqueado" type="radio" value="N" <?php if($row_cliente['bloqueado'] == "N"){echo "checked=\"checked\"";} ?>>Não
		    </fieldset>
	    </td>
	  </tr>
	  <tr>
	    <td colspan="4" align="left" valign="top">
				<input name="update" type="submit" value="Atualizar" class="button">
			</td>
	  </tr>
	</table>
	</form>
	</fieldset>
	</div>
</body>
</html>
