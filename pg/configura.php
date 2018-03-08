<?php
$sqlconf = $conecta->seleciona($conexao,"SELECT * FROM config")or die (mysqli_error());
$linha = mysqli_fetch_array($sqlconf);
?>

<div id="entrada">
	<div id="cabecalho"><h2><i class="icon-file-text iconmd"></i> Meus Dados:</h2></div>
	<table width="98%" border="0" cellspacing="0" cellpadding="0" style="margin-left:25px">
	  <tr>
	    <td width="45%">
	    <form action="" method="post">
	    <table width="79%" border="0" cellspacing="0">
	      <tr>
	        <td width="17%" align="left" valign="middle">Razão Social:<br/>
						<input name="nome" type="text" value="<?php echo $linha['nome'] ?>" maxlength="29" style="text-transform: uppercase;" >
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">Nome Fantasia:<br/>
						<input name="fantasia" type="text" size="60" value="<?php echo $linha['fantasia'] ?>" style="text-transform: uppercase;">
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">URL Sistema:<br/>
						<input name="url" type="text" size="60" value="<?php echo $linha['url'] ?>">
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">E-mail:<br/>
						<input name="email" type="email" size="60" value="<?php echo $linha['email'] ?>">
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">CNPJ:<br/>
						<input name="cpf" type="text" size="20" value="<?php echo $linha['cpf'] ?>">
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">Endereco:<br/>
						<input name="endereco" type="text" size="40"  value="<?php echo $linha['endereco']; ?>"/>
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">Numero:<br/>
						<input name="numero" type="text" value="<?php echo $linha['numero'] ?>">
					</td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">Bairro:<br/>
						<input name="bairro" type="text" value="<?php echo $linha['bairro'] ?>">
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">Cidade:<br/>
	          <input name="cidade" type="text"  value="<?php echo $linha['cidade'] ?>"/>
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">CEP:<br/>
						<input name="cep" type="text" value="<?php echo $linha['cep'] ?>">
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle">UF:<br/>
						<input name="uf" type="text" size="2" maxlength="2" value="<?php echo $linha['uf']; ?>" style="width:25px;" />
	        </td>
	      </tr>
	      <tr>
	        <td align="left" valign="middle"><div class="control-group">
	          <div class="controls">
							<input name="alterar" type="hidden" value="alterar">
	            <button type="submit" class="btn btn-success ewButton" name="alterar" id="btnsubmit2" > <i class="icon-ok icon-white"></i> Alterar</button>
	          </div>
					</td>
	      </tr>
	    </table>
	 	</form>
    </td>
    <td width="55%" align="left" valign="top">
	    <div id="upload">
		    Enviar logo:
		    <hr/>
		    <form action="php/upload.php" method="post" enctype="multipart/form-data">
			   	Selecione sua logo:<br/>
			    <input name="logo" type="file" size="40"><br/><br/>
			    <input name="submit" type="hidden" value="submit">
			    <div class="controls">
	          <button type="submit" class="btn btn-success ewButton" name="submit" id="btnsubmit" >
	          <i class="icon-ok icon-white"></i> Enviar</button>
	        </div>
		   	</form>
				<br/>
		  	<img src="boleto/imagens/<?php echo $linha['logo'] ?>" width="147" height="46">
			</div>
    </td>
  	</tr>
	</table>
</div>
<br/>

<div id="entrada">
		<div id="cabecalho"><h2><i class="icon-lock"></i> Dados de Acesso</h2></div>
		<form name="fomr2" action="" method="post" enctype="multipart/form-data" style="margin-left:25px">
			Usuário:<br/>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-lock"></i></span>
				<input name="user" type="hidden" value="user">
				<input name="usuario" type="text"  value="<?php echo $linhauser['usuario']?>"/>
			</div>
			<br/>
			Senha:<br/>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-key"></i></span>
				<input name="user" type="hidden" value="user">
				<input name="senha" type="password" size="10" maxlength="10"/>
			</div>
			<div class="control-group">
			  <div class="controls">
			  	<button type="submit" class="btn btn-success ewButton" name="user" id="btnsubmit"/ >
			  	<i class="icon-ok icon-white"></i> Alterar</button>
				</div>
			</div>
		</form>
</div>
