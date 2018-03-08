<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea",
  height: 400,
  plugins: [
       "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
       "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
       "save table contextmenu directionality emoticons template paste textcolor"
  ],
  paste_data_images: true,
  language : 'pt_BR',
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l  link image | print preview media fullpage | forecolor backcolor emoticons",
});
</script>

<ol id="toc">
    <li><a href="#page-1"><span><i class="icon-cog"></i> Dados do Servidor</span></a></li>
    <li><a href="#page-2"><span><i class="icon-envelope "></i> Aviso de Fatura</span></a></li>
    <li><a href="#page-3"><span> <i class="icon-envelope"></i> Reaviso de Cobrança</span></a></li>
    <li><a href="#page-4"><span> <i class="icon-envelope"></i> Mensagem de Aniversário</span></a></li>
</ol>

<div class="content" id="page-1">
	<div id="cabecalho"><h2><i class="icon-share "></i> Dados do Servidor</h2></div>

	<div id="forms">
		<form action="" method="post" enctype="multipart/form-data">
			<?php
			$g_mail = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());
			$linhamail = mysqli_fetch_array($g_mail);
			?>
			<p><strong>Razão Social:</strong><br/>
		  <input name="empresa" type="text" size="50" value="<?php echo $linhamail['empresa'] ?>"><br/>

		  <strong>Seu SMTP:</strong><br/>
		  <input name="url" type="text" size="50" value="<?php echo $linhamail['url'] ?>">
		  <span class="avisos">*Caso utilize cpanel deixe como "localhost".</span><br/>

		  <strong>Conta que enviará os emails:</strong><br/>
		  <input name="email" type="text" size="50" value="<?php echo $linhamail['email'] ?>"><br/>

		  <strong>Limite de emails por hora:</strong><br/>
		  <input name="limitemail" type="number" value="<?php echo $linhamail['limitemail'] ?>" style="width:80px;">
		  <span class="avisos">* Verifique no seu servidor o limite de emails que podem ser enviados por hora</span><br/>


		  <strong>Senha da conta:</strong><br/>
		  <input name="senha" type="password" size="20" value="<?php echo $linhamail['senha'] ?>"><br/>

		  <strong>Porta utilizada para enviar:</strong><br/>
		  <input name="porta" type="text" size="6" value="<?php echo $linhamail['porta'] ?>" style="width:40px;">
		  (Portas padrão: 25 e 587. Se não funcionar com uma tente a outra. <strong>Obs:</strong> O Gmail está bloqueando o acesso por sistemas externos não homologados.)<br/>

		  <strong>URL do sistema:</strong><br/>
		  <input name="endereco" type="text" size="60"
			<?php
			$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';

			$pasta = $_SERVER['SCRIPT_NAME'];
			$d = explode("/",$pasta);
			$p = $d[1];

			$banco = mysqli_query($conexao,"SELECT * FROM bancos WHERE situacao = '1'");
			$ver = mysqli_fetch_array($banco);
			$url = $ver['link'];
			?>
			value="<?php echo $linhamail['endereco']?>"
			style="width:300px;"><br/>

			<br/>
			</p>
			<div class="control-groupa">
			<div class="controlsa">
			<button type="submit" class="btn btn-success ewButton" name="emailgr" id="btnsubmit" >
			<i class="icon-thumbs-up icon-white"></i> Gravar alterações</button>
			</div>
			</div>
		</form>
	</div>
</div>

<div class="content" id="page-2">
	<div id="cabecalho"><h2><i class="icon-share "></i> Aviso de Fatura</h2></div>
	<span class="avisos"><strong>Obs: </strong>Este email avisa ao seu cliente que ele tem uma nova fatura.</span><br/><br/>
	<form action="" method="post" enctype="multipart/form-data">
	<strong>Assunto do email:</strong><br/>
	<input name="aviso" type="text" value="<?php echo $linhamail['aviso']?>" style="width:300px;"><br/>
	<strong>Texto do email ao gerar fatura:</strong><br/>
	<textarea cols="80" name="editor1" rows="20"><?php echo $linhamail['text1'] ?></textarea><br/>
	<div class="control-groupa">
	<div class="controlsa">
	<button type="submit" class="btn btn-success ewButton" name="assunto1" id="btnsubmit" >
	<i class="icon-thumbs-up icon-white"></i> Gravar alterações</button>
	</div>
	</form>
	</div>
</div>

<div class="content" id="page-3">
	<div id="cabecalho"><h2><i class="icon-share "></i> Reaviso de Cobrança</h2></div>
	<span class="avisos"><strong>Obs: </strong>Este email avisa ao seu cliente ele tem fatura vencida (Reaviso de cobrança).</span><br/><br/>
	<form action="" method="post" enctype="multipart/form-data" name="formulario">
	<strong>Assunto do email:</strong><br/>
	<input name="tata" type="text" value="<?php echo $linhamail['avisofataberto']?>" style="width:300px;"><br/>
	<strong>Texto do email de cobrança:</strong><br/>
	<textarea  cols="80"  name="editor1" rows="20"><?php echo $linhamail['text2'] ?></textarea><br/>
	<div class="control-groupa">
	<div class="controlsa">
	<button type="submit" class="btn btn-success ewButton" name="avisofataberto" id="btnsubmit" >
	<i class="icon-thumbs-up icon-white"></i> Gravar alterações</button>
	</div>
	</form>
	</div>
</div>

<div class="content" id="page-4">
	<div id="cabecalho"><h2><i class="icon-share "></i> Mensagem de Aniversário</h2></div>
	<span class="avisos"><strong>Obs: </strong>Este email avisa ao seu cliente que ele tem uma nova fatura.</span><br/><br/>
	<form action="" method="post" enctype="multipart/form-data">
	<strong>Assunto do email:</strong><br/>
	<input name="avisoaniversario" type="text" value="<?php echo $linhamail['avisoaniversario']?>" style="width:300px;"><br/>
	<strong>Texto do email:</strong><br/>
	<textarea cols="80" name="text4" rows="20"><?php echo $linhamail['text4'] ?></textarea><br/>
	<div class="control-groupa">
	<div class="controlsa">
	<button type="submit" class="btn btn-success ewButton" name="aniversario" id="btnsubmit" >
	<i class="icon-thumbs-up icon-white"></i> Gravar alterações</button>
	</div>
	</form>
	</div>
</div>

<script src="js/activatables.js" type="text/javascript"></script>
<script type="text/javascript">
	activatables('page', ['page-1', 'page-2', 'page-3', 'page-4']);
</script>
