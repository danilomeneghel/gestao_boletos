<?php
$sql2 = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$id_cliente'")or die (mysqli_error());

$l = mysqli_fetch_array($sql2);

$cliente = $l['nome'];

$sql = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());

$linha = mysqli_fetch_array($sql);

$host = $linha['url'];

$empresa = $linha['empresa'];

$endereco = $linha['endereco'];

$email = $linha['email'];

$html = $linha['text1'];

$mailer = $nomecli['email'];

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

$mail->FromName = utf8_decode($linha['empresa']);

// assunto da mensagem

$mail->Subject = utf8_decode($linha['aviso']);

// corpo da mensagem

$sqlss = mysqli_query($conexao,"SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_venda = '$id_res'") or die(mysqli_error());

$row = mysqli_fetch_array($sqlss);

$idfatura = $row['id_venda'];

$idcliente = $row['id_cliente'];

$emailcliente = $row['emailcli'];

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

$replace = array($nomecliente, $valorfatura,$datavenc,$num_doc,$referente,$link); //  variavis que substiruem os valores

$subject = $dado;

$texto = str_replace($search, $replace, $subject);

$mail->Body = utf8_decode($texto);

$mail->AddAddress($mailer);

// verifica se enviou corretamente

if ($mail->Send()) {

	 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=lancafatura'>

			<script type=\"text/javascript\">

			alert(\"FATURA GERADA E NOTIFICAÇÃO ENVIADA COM SUCESSO!\");

			</script>";

} else {

		 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=lancafatura'>

			<script type=\"text/javascript\">

			alert(\" ERRO: O email não foi enviado. Por favor revise os dados na configuração do email.\");

			</script>";

}
?>
