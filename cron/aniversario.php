<?php 
include "../classes/conexao.php";
require '../classes/class.phpmailer.php';
$mail = new PHPMailer();


function data($date){
	$dt = explode("-",$date);
		$d = $dt[2];
		$m = $dt[1];
		$a = $dt[0];
		
		$dat = $d.'/'.$m.'/'.$a;	
	return $dat;
}

// SELECIONA DADOS
$sql = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());
$linha = mysqli_fetch_array($sql);
$email = $linha['email'];
$html = $linha['text4'];


$sql = mysqli_query($conexao,"SELECT * FROM config");
$config = mysqli_fetch_array($sql);
	$nomeconf = $config['nome'];
	$emailconf = $config['email'];

	
// SELECIONA OS CLIENTES E GERA AS FATURAS
$sql_cliente = mysqli_query($conexao,"SELECT * FROM cliente WHERE DAY(nascimento) = DAY(CURDATE()) AND MONTH(nascimento) = MONTH(CURDATE())") or die(mysqli_error());
while($select_cliente = mysqli_fetch_array($sql_cliente)){
		$id_cliente = $select_cliente['id_cliente'];	
		$nomecliente 	= $select_cliente['nome'];
		$emailcliente  = $select_cliente['email'];	
		$nascimento = $select_cliente['nascimento'];
		
    $data = data($nascimento);
    
    // Separa em dia, mês e ano
    list($dia, $mes, $ano) = explode('/', $data);
    
    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d')+1, date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
    
    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);	
									
/* ********* ENVIA OS EMAILS **********************************************************************************/

$mail->IsSMTP();
$mail->isHTML( true );
$mail->Charset = 'UTF-8';
$mail->SMTPAuth = true;
//$mail->SMTPDebug = true;
$mail->SMTPSecure = 'SSL';
$mail->Host = $linha['url'];
$mail->Port = $linha['porta'];
$mail->Username = $linha['email'];
$mail->Password = $linha['senha'];
$mail->From = $linha['email'];
$mail->FromName = $linha['empresa'];
$mail->Subject = utf8_decode($linha['avisoaniversario']);

///// conta o tempo 
$t = $linha['limitemail'] / 60;
// zera o limite de tempo de execução do script
set_time_limit(0);
// eviar emails
$cont = 0;

$dado = $html;
$search = array('[NomedoCliente]','[idade]'); // pega oa variaveis do html vindo do banco;
$replace = array($nomecliente,$idade); //  variavis que substiruem os valores
$subject = $dado;

$texto = str_replace($search, $replace, $subject);

$mail->Body = $texto;
$mail->AddAddress($emailcliente);

$enviado = $mail->Send();


$mail->ClearAllRecipients();
$mail->ClearAttachments();

if ($enviado) {
  echo "E-mail enviado com sucesso!";
} else {
  echo "Não foi possível enviar o e-mail.";
  echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}						
}// fin do envio de emails

					



?>