<?php 
include "../classes/conexao.php";
require '../classes/class.phpmailer.php';
$mail = new PHPMailer();

// SELECIONA DADOS DO EMAIL QUE ENVIA COBRANÇA
$sql = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error());
$linha = mysqli_fetch_array($sql);
$host = $linha['url'];
$empresa = $linha['empresa'];
$endereco = $linha['endereco'];
$email = $linha['email'];
$html = $linha['text1'];

//////////////////////// encodifica url //////////////////////////////////////
function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
			}

// RETIRA PONTOS DOS VALORES
	function tiraMoeda($valor){
	$pontos = '.';
	$virgula = ',';
	$result = str_replace($pontos, "", $valor);
	$result2 = str_replace($virgula, ".", $result);
	return $result2;
	}
// SELECIONA AS CONFIGURAÇÕES
$sql = mysqli_query($conexao,"SELECT * FROM config");
$config = mysqli_fetch_array($sql);
	$nomeconf = $config['nome'];
	$emailconf = $config['email'];
	$dias_antes = $config['dias'];
	
// SELECIONA OS CLIENTES E GERA AS FATURAS
$sql_cliente = mysqli_query($conexao,"SELECT * FROM cliente WHERE bloqueado = 'N' AND id_grupo !='1'");
while($select_cliente = mysqli_fetch_array($sql_cliente)){
		$id_cliente = $select_cliente['id_cliente'];	
		$id_grupo		= $select_cliente['id_grupo'];
		$nome_cliente 	= $select_cliente['nome'];
		$cpf_cliente 	= $select_cliente['cpfcnpj']; 
		$email_cliente  = $select_cliente['email'];
		$valor_cliente 	= $select_cliente['valor'];
			
			// pega o numero do documento
		$verdoc = mysqli_query($conexao,"SELECT id_venda FROM faturas ORDER BY id_venda DESC LIMIT 1");
		$DOC = mysqli_fetch_array($verdoc);
		$id_res = $DOC['id_venda'];
		$num_doc = $DOC['id_venda'] + 1;
				
				// seleciona o grupo para pegar a data de vencimento
				$sql_data = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo = '$id_grupo'");
					$data = mysqli_fetch_array($sql_data);
					$id_grupo_cliente 	= $data['id_grupo'];
					$meses 				= $data['meses'];
					$dia_vencimento		= $data['dia'];
					$valorGrupo			= $data['valor'];
					
		// seleciona as faturas e verifica se ja foi lancada
		$verdat = mysqli_query($conexao,"SELECT * FROM faturas WHERE id_cliente ='$id_cliente' AND tipofatura !='AVULSO' AND situacao ='P' ORDER BY id_venda DESC");
		$contar = mysqli_num_rows($verdat);
		$tultimafatura = mysqli_fetch_array($verdat);
		
		$ref = $tultimafatura['ref']; 
			if($ref == ""){
				$ref = 	$select_cliente['obs'];
			}
		
			if($contar == 0){
				$ultimoboleto = date("Y-m-d");
			}else{
			$ultimoboleto = $tultimafatura['data_venci'];
			}
			$s = explode("-",$ultimoboleto);
				$a = $s[0];
				$m = $s[1];
				$d = $s[2];	
				
			$ultima = $a.'-'.$m.'-'.$dia_vencimento;
			$fatura = date("Y-m-d", strtotime("+$meses month", strtotime($ultima)));

			$diferenca = strtotime($fatura) - strtotime($ultima);	
			$dias = floor($diferenca / (60 * 60 * 24));
		
			
		if($contar == 0){
			$dat = date('Y-m-'.$dia_vencimento);
				$hoje = date("Y-m-d");
				if(strtotime($hoje) > strtotime ($dat)){
					$dat = date("Y-m-d", strtotime("+1 month"));	
				}
		}	
		else{	
		$dat = $fatura;
		}
		// Define os valores a serem usados
		$datahoje = date("Y-m-d");
		$data_final = $dat;
		
			$data_lancamento = strtotime($data_final) - strtotime($datahoje);
			$lanca = floor($data_lancamento / (60 * 60 * 24));
				
			if($lanca <= $dias_antes && $contar == 0){
			$sql_periodica = mysqli_query($conexao,"INSERT INTO faturas ( id_cliente, nome, ref, data, data_venci, valor,situacao, num_doc, condmail, emailcli) VALUES
			('$id_cliente','$nome_cliente','$ref','$datahoje', '$dat','$valor_cliente','P','$num_doc','1','$email_cliente')") or die(mysqli_error());
			
								
/* ********* ENVIA OS EMAILS CASO A FATURA SEJA LANCADA **********************************************************************************/

if($sql_periodica == 1){
$mail->IsSMTP();
$mail->isHTML( true );
$mail->Charset = 'UTF-8';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'SSL';
$mail->Host = $linha['url'];
$mail->Port = $linha['porta'];
$mail->Username = $linha['email'];
$mail->Password = $linha['senha'];
$mail->From = $linha['email'];
$mail->FromName = $linha['empresa'];
$mail->Subject = utf8_decode($linha['aviso']);

///// conta o tempo 
$t = $linha['limitemail'] / 60;
// zera o limite de tempo de execução do script
set_time_limit(0);
// eviar emails
$cont = 0;
$sqlss = mysqli_query($conexao,"SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE condmail = '1' AND id_cliente='$id_cliente' AND situacao='P'") or die(mysqli_error());
$row = mysqli_fetch_array($sqlss);
	$idfatura = $row['id_venda'];
	$idcliente = $row['id_cliente'];
	$emailcliente = $row['emailcli'];
	$nomecliente = $row['nome'];
	$valorfatura = $row['valor'];
	$datavenc = $row['data'];
	$num_doc = $row['num_doc'];
	$referente = $row['ref'];
	if($referente == ""){
		$referente = $select_cliente['obs'];	
	}

$dado = 'id_venda='.$idfatura;
$pagina = base64url_encode($dado);
$link = $endereco.'boleto/boleto.php?'.$pagina;

$dado = $html;
$search = array('[NomedoCliente]', '[valor]','[vencimento]','[numeroFatura]','[Descricaodafatura]','[link]'); // pega oa variaveis do html vindo do banco;
$replace = array($nomecliente, $valorfatura,$datavenc,$idfatura,$referente,$link); //  variavis que substiruem os valores
$subject = $dado;

$texto = str_replace($search, $replace, $subject);

$mail->Body = $texto;
$mail->AddAddress($emailcliente);

$mail->Send();

$mail->ClearAllRecipients();
$mail->ClearAttachments();

						
}// fin do envio de emails
} 
					
}// fecha while


?>