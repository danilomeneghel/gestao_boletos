<!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>.: Griff sistemas :.</title>

</head>



<body>

<?php

require ("../classes/conexao.php");

if(isset($_GET['p']) && !empty($_GET['p'])){

$p = $_GET['p'];

}else{

$p = 1;	

}





$idCli = $_GET['idcliente'];

$idvenda = $_GET['id_venda'];



$sql2 = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$idCli'")or die (mysqli_error());

$l = mysqli_fetch_array($sql2);

$cliente = $l['nome'];

$emailcliente =$l['email'];





$sql = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());

$linha = mysqli_fetch_array($sql);

$host = $linha['url'];

$empresa = $linha['empresa'];

$endereco = $linha['endereco'];

$email = $linha['email'];

$html = $linha['text1'];



function base64url_encode($data) {

			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');

			}



require "../classes/class.phpmailer.php";

$mail = new PHPMailer();

// define que será usado SMTP

$mail->IsSMTP();

 

// envia email HTML

$mail->isHTML( true );

 

// codificação UTF-8, a codificação mais usada recentemente

$mail->Charset = 'UTF-8';

// Configurações do SMTP

$mail->SMTPAuth = true;

//$mail->SMTPDebug = true;

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

$mail->Subject = utf8_decode($linha['aviso']);

// corpo da mensagem



$sqlss = mysqli_query($conexao,"SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_venda = '$idvenda'") or die(mysqli_error());

$row = mysqli_fetch_array($sqlss);

	$idfatura = $row['id_venda'];

	$idcliente = $row['id_cliente'];

	$nomecliente = $row['nome'];

	$valorfatura = $row['valor'];

	$datavenc = $row['data'];

	$num_doc = $row['id_venda'];

	$referente = $row['ref'];



$dado = 'id_venda='.$idfatura;

$pagina = base64url_encode($dado);

$link = $endereco.'/boleto/boleto.php?'.$pagina;



$dado = $html;

$search = array('[NomedoCliente]', '[valor]','[vencimento]','[numeroFatura]','[Descricaodafatura]','[link]'); // pega oa variaveis do html vindo do banco;

$replace = array($nomecliente, number_format($valorfatura,2,',','.'),$datavenc,$num_doc,$referente,$link); //  variavis que substiruem os valores

$subject = $dado;



$texto = str_replace($search, $replace, $subject);



$mail->Body = utf8_decode($texto);

$mail->AddAddress($emailcliente);





// verifica se enviou corretamente

if ( $mail->Send() )

{

	 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=fatpendente&p=".$p."'>

			<script type=\"text/javascript\">

			alert(\"FATURA REENVIADA COM SUCESSO!\");

			</script>";

}

else

{

			 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=fatpendente&p=".$p."'>

			<script type=\"text/javascript\">

			alert(\" ERRO: O email não foi enviado. Por favor revise os dados na configuração do email.\");

			</script>";

}

?>

</body>

</html>