<?php
require 'classes/class.phpmailer.php';

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
	// Caracteres de cada tipo
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	// Variáveis internas
	$retorno = '';
	$caracteres = '';
	// Agrupamos todos os caracteres que poderão ser utilizados
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
	// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
	$rand = mt_rand(1, $len);
	// Concatenamos um dos caracteres na variável $retorno
	$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}

$mail = new PHPMailer();

function tiraMoeda($valor){
	$pontos = '.';
	$virgula = ',';
	$result = str_replace($pontos, "", $valor);
	$result2 = str_replace($virgula, ".", $result);
	return $result2;
}

function datas($dado){
	if(!empty($dado)) {
		$data = explode("/", $dado);
		$dia = $data[0];
		$mes = $data[1];
		$ano = $data[2];

		$resultado = $ano."-".$mes."-".$dia;
		return $resultado;
	}
}

////////////// arredonda valores /////////////////////////////////
function ceil_dec($number,$precision,$separator) {
    $numberpart=explode($separator,$number);
	@$numberpart[1]=substr_replace($numberpart[1],$separator,$precision,0);
    if($numberpart[0]>=0)
    {$numberpart[1]=ceil($numberpart[1]);}
    else
    {$numberpart[1]=floor($numberpart[1]);}

    $ceil_number= array($numberpart[0],$numberpart[1]);
    return implode($separator,$ceil_number);
}
/////////////////////// conferir datas //////////////
function data2banco ($d2b) {
	if(!empty($d2b)){
		$d2b_ano=substr($d2b,6,4);
		$d2b_mes=substr($d2b,3,2);
		$d2b_dia=substr($d2b,0,2);
		$d2b="$d2b_ano-$d2b_mes-$d2b_dia";
	}
	return $d2b;
}

/////////// ATIVA DESATIVA BANCOS ///////////////////////////

if(isset($_GET["ativa"]) && $_GET["ativa"] == "ok"){
	$id_banco 	= $_GET['id_banco'];
	$res = mysqli_query($conexao,"SELECT * FROM bancos WHERE id_banco='$id_banco'");
	$list = mysqli_fetch_array($res);
	$link = $list['link'];
	$banco 	= $list['nome_banco'];
	$tabela = "bancos";
	$valor 	= "1";
	$string = "id_banco = $id_banco";
	$dados 	= array(
				'id_banco' => $_GET['id_banco'],
				'situacao' => $valor
				);
	$zera = mysqli_query($conexao,"UPDATE bancos SET situacao='0'");

	$conecta= mysqli_query($conexao,"UPDATE bancos SET situacao='1' WHERE id_banco='$id_banco'");

	$endereco = $_SERVER['REQUEST_URI'];
	$link = explode("&",$endereco);
	$reader = $link[0];

	unset($_GET['ativa']);
	print "
		<META HTTP-EQUIV=REFRESH CONTENT='0; URL=$reader'>
		<script type=\"text/javascript\">
		alert(\"Banco $banco ativado com sucesso.\");
		</script>";
}

///////////////////////////// CONFIGURAÇÕES ///////////////////////////

if(isset($_POST['alterar'])){
	$tabela = "config";
	$string = "id = 1";
	$dados = array(
				'nome'			=> $_POST['nome'],
				'fantasia'	=> $_POST['fantasia'],
				'url'				=> $_POST['url'],
				'email'			=> $_POST['email'],
				'cpf'				=> $_POST['cpf'],
				'endereco'  => $_POST['endereco'],
				'numero'		=> $_POST['numero'],
				'bairro'		=> $_POST['bairro'],
				'cidade'		=> $_POST['cidade'],
				'cep'				=> $_POST['cep'],
				'uf'				=> $_POST['uf']
				);

	$conecta->alterar($conexao,$tabela,$dados,$string);

	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=configuracoes'>
		  <script type=\"text/javascript\">
		  alert(\"DADOS ALTERADOS COM SUCESSO!\");
		  </script>";
}

/////////////////////////////// DADOS INICIAIS ///////////////////////////////////////

//////// dados do cliete //////////
$id_usuario = $_SESSION['id_usuario_session'];
$cliente = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_usuario='$id_usuario'") or die(mysqli_error());
$linha_cliente = mysqli_fetch_array($cliente);
$id_cliente = $linha_cliente['id_cliente'];

$mes_atual = date("m");
$pendATUAL = mysqli_query($conexao,"SELECT * FROM faturas WHERE MONTH(data_venci) = '$mes_atual'")or die (mysqli_error());

$data_hoje = date("Y-m-d");
$diar = mysqli_query($conexao,"SELECT COUNT(*) AS registros,SUM(valor) AS total FROM faturas WHERE data_venci ='$data_hoje'")or die (mysqli_error());
$valordia = mysqli_fetch_array($diar);
$totalhoje = $valordia['total'];
$reg = $valordia['registros'];

if($id_usuario == 1) {
	$sitp = mysqli_query($conexao,"SELECT * FROM faturas WHERE situacao = 'P'")or die (mysqli_error());
	$contp = mysqli_num_rows($sitp);

	$sitv = mysqli_query($conexao,"SELECT * FROM faturas WHERE situacao = 'V'")or die (mysqli_error());
	$contv = mysqli_num_rows($sitv);

	$sitb = mysqli_query($conexao,"SELECT * FROM faturas WHERE situacao = 'B'")or die (mysqli_error());
	$contb = mysqli_num_rows($sitb);

	///// total do mes ////////////
	$resmes = mysqli_query($conexao,"SELECT *,SUM(valor) AS valorm FROM faturas WHERE MONTH(dbaixa) = '$mes_atual'")or die (mysqli_error());
	$rm = mysqli_fetch_array($resmes);
	$valorm = $rm['valorm'];

	///// baixadas no mes ///////////
	$vrec = mysqli_query($conexao,"SELECT *,SUM(valor_recebido) AS valorr FROM faturas WHERE MONTH(dbaixa) = '$mes_atual' AND situacao = 'B'")or die (mysqli_error());
	$vr = mysqli_fetch_array($vrec);
	$valorr = $vr['valorr'];

	$vrec = mysqli_query($conexao,"SELECT *,SUM(valor_recebido) AS valorr FROM faturas WHERE MONTH(dbaixa) = '$mes_atual' AND situacao = 'B'")or die (mysqli_error());

	//////////// valor vencido do mes ////////////////
	$vv = mysqli_query($conexao,"SELECT *,SUM(valor) AS valorv FROM faturas WHERE situacao = 'V'")or die (mysqli_error());
	$vrv = mysqli_fetch_array($vv);
	$valorv = $vrv['valorv'];

	//////////// valor pendente do mes ////////////////
	$vp = mysqli_query($conexao,"SELECT *,SUM(valor) AS valorp FROM faturas WHERE MONTH(data_venci) = '$mes_atual' AND situacao = 'P'")or die (mysqli_error());
	$vrp = mysqli_fetch_array($vp);
	$valorp = $vrp['valorp'];

} else {
	$sitp = mysqli_query($conexao,"SELECT * FROM faturas WHERE id_cliente='$id_cliente' AND situacao = 'P'")or die (mysqli_error());
	$contp = mysqli_num_rows($sitp);

	$sitv = mysqli_query($conexao,"SELECT * FROM faturas WHERE id_cliente='$id_cliente' AND situacao = 'V'")or die (mysqli_error());
	$contv = mysqli_num_rows($sitv);

	$sitb = mysqli_query($conexao,"SELECT * FROM faturas WHERE id_cliente='$id_cliente' AND situacao = 'B'")or die (mysqli_error());
	$contb = mysqli_num_rows($sitb);

	///// total do mes ////////////
	$resmes = mysqli_query($conexao,"SELECT *,SUM(valor) AS valorm FROM faturas WHERE id_cliente='$id_cliente' AND MONTH(dbaixa) = '$mes_atual'")or die (mysqli_error());
	$rm = mysqli_fetch_array($resmes);
	$valorm = $rm['valorm'];

	///// baixadas no mes ///////////
	$vrec = mysqli_query($conexao,"SELECT *,SUM(valor_recebido) AS valorr FROM faturas WHERE id_cliente='$id_cliente' AND MONTH(dbaixa) = '$mes_atual' AND situacao = 'B'")or die (mysqli_error());
	$vr = mysqli_fetch_array($vrec);
	$valorr = $vr['valorr'];

	$vrec = mysqli_query($conexao,"SELECT *,SUM(valor_recebido) AS valorr FROM faturas WHERE id_cliente = '$id_cliente' AND MONTH(dbaixa) = '$mes_atual' AND situacao = 'B'")or die (mysqli_error());

	//////////// valor vencido do mes ////////////////
	$vv = mysqli_query($conexao,"SELECT *,SUM(valor) AS valorv FROM faturas WHERE id_cliente='$id_cliente' AND situacao = 'V'")or die (mysqli_error());
	$vrv = mysqli_fetch_array($vv);
	$valorv = $vrv['valorv'];

	//////////// valor pendente do mes ////////////////
	$vp = mysqli_query($conexao,"SELECT *,SUM(valor) AS valorp FROM faturas WHERE id_cliente='$id_cliente' AND MONTH(data_venci) = '$mes_atual' AND situacao = 'P'")or die (mysqli_error());
	$vrp = mysqli_fetch_array($vp);
	$valorp = $vrp['valorp'];
}

//////////////////////////////////// CONFIGURA BANCOS ////////////////////////////////////////////////////////

if(isset($_POST['bancosgr'])){
	$id_banco 			= $_POST['id_banco'];
	$carteira		  	= $_POST['carteira'];
	$agencia				= $_POST['agencia'];
	$conta					= $_POST['conta'];

	if(isset($_POST['digito_ag']) && !empty($_POST['digito_ag']))
		$digito_ag = (int)$_POST['digito_ag'];
	else
		$digito_ag = null;

	if(isset($_POST['digito_co']) && !empty($_POST['digito_co']))
		$digito_co = (int)$_POST['digito_co'];
	else
		$digito_co = null;

	if(isset($_POST['especie']) && !empty($_POST['especie']))
		$especie = $_POST['especie'];
	else
		$especie = null;

	if(isset($_POST['convenio']) && !empty($_POST['convenio']))
		$convenio = $_POST['convenio'];
	else
		$convenio = null;

	if(isset($_POST['contrato']) && !empty($_POST['contrato']))
		$contrato = $_POST['contrato'];
	else
		$contrato = null;

	if(isset($_POST['tipo_carteira']) && !empty($_POST['tipo_carteira']))
		$tipo_carteira = $_POST['tipo_carteira'];
	else
		$tipo_carteira = null;

	 $sql = "UPDATE bancos SET carteira='$carteira', agencia='$agencia', conta='$conta',tipo_carteira='$tipo_carteira', digito_co='$digito_co',convenio='$convenio', especie='$especie', contrato='$contrato' WHERE id_banco='$id_banco'";
	 $conectar = mysqli_query($conexao,$sql)or die(mysqli_error($conexao));

	if($conectar == 1){
	  print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=banco'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
	}else{
		print_r(mysqli_error());
	}
}

/////////////////////////// CONFIGURA BOLETOS /////////////////////////////

if(isset($_POST['confgoleto'])){
	$tabela = "config";
	$string = "id = 1";
	$dados = array(
			'dias'					=> $_POST['dias'],
			'receber'				=> $_POST['receber'],
			'multa_atraso'	=> $_POST['multa_atraso'],
			'juro'					=> $_POST['juros'],
			'protesto'			=> $_POST['protesto'],
			'demo1'					=> $_POST['demo1'],
			'demo2'					=> $_POST['demo2'],
			'demo3'					=> $_POST['demo3'],
			'demo4'					=> $_POST['demo4']
  );

	$conecta->alterar($conexao,$tabela,$dados,$string);
	if($conecta){
  	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confboleto'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
	}
}

$d_boleto = mysqli_query($conexao,"SELECT * FROM config")or die (mysqli_error());
$linhas = mysqli_fetch_array($d_boleto);

///////////////////////// CONFIGURA SERVIDOR DE EMAIL ////////////////////////

if(isset($_POST['emailgr'])){
		$tabela = "maile";
		$string = "id = 1";
		$dados = array(
				'empresa'			=> $_POST['empresa'],
				'url'					=> $_POST['url'],
				'porta'				=> $_POST['porta'],
				'endereco'		=> $_POST['endereco'],
				'limitemail'	=> $_POST['limitemail'],
				'email'				=> $_POST['email'],
				'senha'				=> $_POST['senha'],
		);

		$conecta->alterar($conexao,$tabela,$dados,$string);

		if(file_exists("php/configdados.php")){
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=php/configdados.php'>";
		}else{
		print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
		}
}

///////////////////////// CONFIGURA AVISO DE FATURA ////////////////////////

if(isset($_POST['aviso'])){
	$tabela = "maile";
	$string = "id = 1";
	$dados = array(
			'aviso'		=> $_POST['aviso'],
			'text1'		=> $_POST['editor1']
	);

	$conecta->alterar($conexao,$tabela,$dados,$string);

	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail#page=page-2'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
}

/////////////////// FATURA EM ABERTO /////////////////////////

if(isset($_POST['avisofataberto'])){
	$tabela = "maile";
	$string = "id = 1";
	$dados = array(
			'avisofataberto' => $_POST['tata'],
			'text2'			 => $_POST['editor1']
	);

	$conecta->alterar($conexao,$tabela,$dados,$string);

	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail#page=page-3'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
}

/////////////////// ANIVERSÁRIO /////////////////////////

if(isset($_POST['aniversario'])){
	$tabela = "maile";
	$string = "id = 1";
	$dados = array(
			'avisoaniversario' => $_POST['avisoaniversario'],
			'text4'			 => $_POST['text4']
	);

	$conecta->alterar($conexao,$tabela,$dados,$string);

	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail#page=page-4'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
}

/////////////////// EMAIL DADOS ACESSO CLIENTE /////////////////////////

if(isset($_POST['dadosacesso'])){
	$tabela = "maile";
	$string = "id = 1";
	$dados = array(
			'dadosacesso'	=> $_POST['enviadados'],
			'text3'			=> $_POST['editor1']
	);

	$conecta->alterar($conexao,$tabela,$dados,$string);

	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail#page=page-4'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
}

$g_mail = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());
$linhamail = mysqli_fetch_array($g_mail);

/////////////////////// ALTERA DADOS DE ACESSO ////////////////////////////

if(isset($_POST['user'])){
	$tabela = "usuario";
	$string = "id_usuario = '1'";

	if(!empty($_POST['senha'])) {
		$dados = array(
				'usuario'		=> $_POST['usuario'],
				'senha'			=> sha1($_POST['senha'])
		);
	} else {
		$dados = array(
				'usuario'		=> $_POST['usuario']
		);
	}
	$conecta->alterar($conexao,$tabela,$dados,$string);

  print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=configuracoes'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}

$g_user = mysqli_query($conexao,"SELECT * FROM usuario")or die (mysqli_error());
$linhauser = mysqli_fetch_array($g_user);

//////////////////////////// CADASTRO PLANO DE CONTAS //////////////////////////

if(isset($_POST['cadastar_plano'])){
	$descricao = $_POST['descricao'];
	$my = mysqli_query($conexao, "INSERT INTO flux_planos (descricao)VALUES('$descricao')") or die(mysqli_error());

		//$conecta->inserir($conexao,$conexao,$tabela,$dados);
 		print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=fluxo#tabs-2'>";
}

//////////////////////////// CADASTRO CONTAS //////////////////////////

if(isset($_POST['adicionar_conta'])){
	$tabela = "flux_entrada";
	$dados 	= array(
				'data'			=> datas($_POST['data']),
				'tipo'			=> $_POST['tipo'],
				'id_plano'	=> $_POST['id_plano'],
				'descricao'	=> $_POST['descricao'],
				'valor'			=> tiraMoeda($_POST['valor'])
				);

		$sql = $conecta->inserir($conexao,$tabela,$dados);
 		print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=fluxo'>";
}

//////////////////////////// EDITAR CONTAS LANÇADAS ////////////////////////
if(isset($_POST['atualizalancamento'])){
		$tabela = "flux_entrada";
		$id_entrada = $_POST['id_entrada'];
		$string = "id_entrada = '$id_entrada'";
		$teste = tiraMoeda($_POST['valor']);
		$dados = array(
			'data'				=> datas($_POST['data']),
			'tipo'				=> $_POST['tipo'],
			'id_plano'		=> $_POST['id_plano'],
			'descricao'		=> $_POST['descricao'],
			'valor'				=> tiraMoeda($_POST['valor'])
				);
		$conecta->alterar($conexao,$tabela,$dados,$string);
}

//////////////////////////// CADASTRO DESPESAS FIXAS //////////////////////////

if(isset($_POST['grava_despesa_fixa'])){
		$tabela = "flux_fixas";
		$dados 	= array(
				'dia_vencimento'		=> $_POST['dia_vencimento'],
				'descricao_fixa'		=> $_POST['descricao_fixa'],
				'valor_fixa'				=> tiraMoeda($_POST['valor_fixa'])
				);

		$sql = $conecta->inserir($conexao,$tabela,$dados);
 		print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=fluxo'>";
}

//////////////////////////// CADASTRO DE CLIENTES //////////////////////////

if(isset($_POST['clientegr']) && !empty($_POST['nome'])){
	$tabela1 = "usuario";
	$dados1 = array(
			'usuario'		=> $_POST['usuario'],
			'senha'			=> sha1($_POST['senha'])
	);

	// Inseri dados de acesso
	$conecta->inserir($conexao,$tabela1,$dados1);

	$id_usuario = mysqli_insert_id($conexao);

	$tabela2 = "cliente";
	$dados2 	= array(
				'id_grupo'		=> $_POST['id_grupo'],
				'id_usuario'	=> $id_usuario,
				'nome'				=> $_POST['nome'],
				'cpfcnpj'			=> $_POST['cpfcnpj'],
				'nascimento'	=> datas($_POST['nascimento']),
				'rg'					=> $_POST['rg'],
				'inscricao'		=> $_POST['inscricao'],
				'endereco'		=> $_POST['endereco'],
				'numero'			=> $_POST['numero'],
				'complemento'	=> $_POST['complemento'],
				'bairro'			=> $_POST['bairro'],
				'cidade'			=> $_POST['cidade'],
				'uf'					=> $_POST['uf'],
				'pais'				=> $_POST['pais'],
				'telefone'		=> $_POST['telefone'],
				'cep'					=> $_POST['cep'],
				'uf'					=> $_POST['uf'],
				'email'				=> $_POST['email'],
				'bloqueado'		=> 'N',
		);

		// Inseri dados do cliente
		$cli = $conecta->inserir($conexao,$tabela2,$dados2);

		if($cli) {
				$sqld = mysqli_query($conexao,"SELECT * FROM config") or die(mysqli_error($conexao));
				$d = mysqli_fetch_array($sqld);

				// Envia email para o cliente
				$sql = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());
				$linha = mysqli_fetch_array($sql);

				$mail = new PHPMailer();
				// define que será usado SMTP
				$mail->IsSMTP();

				// envia email HTML
				$mail->isHTML( true );

				// codificação UTF-8, a codificação mais usada recentemente
				$mail->Charset = 'UTF-8';
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'SSL';
				$mail->Host = $linha['url'];
				$mail->Port = $linha['porta'];
				$mail->Username = $linha['email'];
				$mail->Password = $linha['senha'];

				// E-Mail do remetente (deve ser o mesmo de quem fez a autenticação
				// nesse caso seu_login@gmail.com)
				$mail->From = $linha['email'];

				// Nome do rementente
				$mail->FromName = $linha['empresa'];

				// assunto da mensagem
				$mail->Subject = utf8_decode("Cadastro no Sistema ".$d['nome']);
				// corpo da mensagem
				$texto = utf8_decode("
					Olá ".$_POST['nome']."!<br/><br/>
					Esta mensagem é referente ao cadastro no site ".$d['nome'].".<br/><br/>
					Segue o link abaixo para acessar o painel: <br/>
					<a href='".$d['url']."'>".$d['url']."</a><br/><br/>
					Seu Usuário: ".$_POST['usuario']."<br/>
					Sua Senha: ".$_POST['senha']."<br/><br/><br/>
					Qualquer dúvida, entre em contato conosco.<br/><br/><br/>
					Atenciosamente<br/>
					Equipe ".$d['nome'].".
				");

				$mail->Body = $texto;
				$mail->AddAddress($_POST['email']);

				// verifica se enviou corretamente
				if ($mail->Send()) {
					print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=cadclientes'>
					<script type=\"text/javascript\">
					alert(\"CLIENTE CADASTRADO E EMAIL ENVIADO COM SUCESSO!\");
					</script>";
				}else{
					print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=cadclientes'>
					<script type=\"text/javascript\">
					alert(\" ERRO! O email não foi enviado. Por favor revise os dados na configuração do email.\");
					</script>";
				}

		} else {

			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=cadclientes'>
			<script type=\"text/javascript\">
			alert(\"ERRO AO EFETUAR O CADASTRO! POR FAVOR, TENTE NOVAMENTE.\");
			</script>";
		}
}

///////////////////////////// CADASTRO DE GRUPOS //////////////////////

if(isset($_POST['cadgrupocli'])){
	$tabela = "grupo";
	$dados = array(
	 		'nomegrupo' => $_POST['nomegrupo'],
			'meses'		=> $_POST['meses'],
			'valor'		=> tiraMoeda($_POST['valor'])
			);
	$sql = $conecta->inserir($conexao,$tabela,$dados);
	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=grupo'>
			<script type=\"text/javascript\">
			alert(\"GRUPO CADASTRADO COM SUCESSO!\");
			</script>";
}

$gr = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo !='1'");

///////////////////// DELETA GRUPOS ///////////////////////

if(isset($_GET['del']) && $_GET['del'] == "del"){
	$idGrupo = $_GET['id_grupo'];
	$del = mysqli_query($conexao,"DELETE FROM grupo WHERE id_grupo='$idGrupo'")or die(mysqli_error());
	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=grupo'>
			<script type=\"text/javascript\">
			alert(\"GRUPO DELETADO COM SUCESSO!\");
			</script>";
}

/////////////////////// EDITA CLIENTES //////////////////////////

$consulta = mysqli_query($conexao,"SELECT * FROM cliente ORDER BY nome ASC")or die (mysqli_error());

////////////////////////////////////// LANÇA FATURA UNICA  ///////////////////////

if(isset($_POST['lancafatunica']) && $_POST['id_cliente'] != "0"){
	$id_cliente = $_POST['id_cliente'];
	$cli = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente = '$id_cliente' ")or die (mysqli_error($conexao));
	$nomecli = mysqli_fetch_array($cli);

	$id = $nomecli['id_cliente'];
	$nome = $nomecli['nome'];
	$emailc = $nomecli['email'];
	$ref = $_POST['ref'];
	$grupoCliente = $nomecli['id_grupo'];

	$valor = tiraMoeda($_POST['valor']);
	$data_ven = $_POST['data_venci'];
	$dv = explode ("/",$data_ven);
	$dia = $dv[0];
	$mes = $dv[1];
	$ano = $dv[2];

	$vencimento = $ano."-".$mes."-".$dia;

	$situacao = 'P';
	$tabela = "faturas";
	$tipofatura = 'AVULSO';
	$dados = array(
				'id_cliente'   	=> $id,
				'grupoCliente' 	=> $grupoCliente,
				'nosso_numero'  => "00",
				'banco'		 			=> $banco,
				'nome'		 			=> $nome,
				'ref'					  => $ref,
				'data'			 	  => date("Y-m-d"),
				'data_venci' 		=> $vencimento,
				'valor' 	 			=> $valor,
				'situacao'		  => $situacao,
				'emailcli'	 		=> $emailc,
				'tipofatura' 		=> $tipofatura
				);
	$sql  = $conecta->inserir($conexao, $tabela, $dados);

	$id_res = mysqli_insert_id($conexao);

	if($conecta == true){
		include "mail_fat_unica.php";
	}
}

//////////////////////// encodifica url //////////////////////////////////////
function base64url_encode($data) {
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

////////////////////////// LANÇA FATURA POR GRUPOS ////////////////////////////

if(isset($_POST['lancafatperiodica']) && $_POST['id_grupo'] != "0"){
	// SELECIONA AS CONFIGURAÇÕES
	$sql = mysqli_query($conexao,"SELECT * FROM config");
	$config = mysqli_fetch_array($sql);
	$nomeconf = $config['nome'];
	$emailconf = $config['email'];

	$s = explode("/",$_POST['data_venci']);
	$d = $s[0];
	$m = $s[1];
	$a = $s[2];
	$data_venci = $a.'-'.$m.'-'.$d;

	$id_grupo = $_POST['id_grupo'];
	$ref	= $_POST['ref'];
	$pedido = $_SESSION['boleto'] = md5(geraSenha(30).date("Y-m-d H:i"));

	// SELECIONA O GRUPO
	$sql_grupo = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo = '$id_grupo'");
	$row_grupo = mysqli_fetch_array($sql_grupo);
	$valor = $row_grupo['valor'];

	// VERIFICA SE A FATURA JÁ FOI GERADA PARA DATA DE HOJE
	$data_hoje = date('Y-m-d');
	$sql_fatura = mysqli_query($conexao,"SELECT * FROM faturas WHERE grupoCliente = '$id_grupo' AND data = '$data_hoje' AND tipofatura = 'GRUPO'");
	$row_fatura = mysqli_num_rows($sql_fatura);

	if($row_fatura == 0) {
		// SELECIONA OS CLIENTES E GERA AS FATURAS
		$sql_cliente = mysqli_query($conexao,"SELECT * FROM cliente WHERE bloqueado = 'N' AND id_grupo = '$id_grupo'");

		while($select_cliente = mysqli_fetch_array($sql_cliente)){
			$id_cliente = $select_cliente['id_cliente'];
			$nome_cliente = $select_cliente['nome'];
			$cpf_cliente 	= $select_cliente['cpfcnpj'];
			$email_cliente  = $select_cliente['email'];
			$grupoCliente = $select_cliente['id_grupo'];

			$sql_periodica = mysqli_query($conexao,"INSERT INTO faturas (id_cliente, grupoCliente, nome, ref, data, data_venci, valor,situacao, condmail, emailcli,tipofatura,pedido) VALUES
			('$id_cliente','$grupoCliente','$nome_cliente','$ref','$data_hoje', '$data_venci','$valor','P','1','$email_cliente','GRUPO','$pedido')") or die(mysqli_error($conexao));

			$id_inseridos[] = mysqli_insert_id($conexao);

			include "mail_fat_periodica.php";
		}
	}

	if(isset($sql_periodica) && $sql_periodica === true){
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=periodica'>
				<script type=\"text/javascript\">
				alert(\"Faturas geradas e emails enviados!\");
				</script>";
	}else{
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=periodica'>
		<script type=\"text/javascript\">
		alert(\"Este grupo não possui faturas a serem lançadas hoje ou ja foram lancadas!\");
		</script>";
	}
}// fecha lancamento

$id_res = @implode("','", $id_inseridos);

///////////////////////// gera link fatura //////////////////
$url = mysqli_query($conexao,"SELECT * FROM bancos WHERE situacao='1'");
$lista = mysqli_fetch_array($url);
$link = $lista['link'];
?>
