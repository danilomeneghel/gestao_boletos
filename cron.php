<?php

date_default_timezone_set('America/Sao_Paulo');
require("./classes/conexao.php");
require("./classes/class.phpmailer.php");
$mail = new PHPMailer();

$data = date('Y-m-d');
$vencimento = date('Y-m-d', strtotime('+7 days'));
$vencimentoenvio = date('d/m/Y', strtotime($vencimento));

// NUMERO MÁXIMO DE ENVIO
$quant = 15;
// TEMPO ENTRE UM PROCESSO DE ENVIO E OUTRO
$seg = 59;

//////////////// SELECIONA AS CONFIGURACOES DE ENVIO DE EMAIL ///////////////
$sql = mysqli_query($conexao,"SELECT * FROM maile")or die (mysqli_error($conexao));
$linha = mysqli_fetch_array($sql);
$empresa = $linha['empresa'];
$endereco = $linha['endereco'];
$email = $linha['email'];
$html = $linha['text1'];

/////////////// define os dados no phpmailer //////////////
// define que será usado SMTP

$mail->IsSMTP();
$mail->isHTML(true);
$mail->Charset = 'UTF-8';
$mail->SMTPAuth = true;
//$mail->SMTPDebug = true;
$mail->SMTPSecure = 'SSL';
$mail->Host = $linha['url'];
$mail->Port = $linha['porta'];
$mail->Username = $linha['email'];
$mail->Password = $linha['senha'];
$mail->Subject = 'Fatura mes '.date('m/Y');
$mail->From = $linha['email'];
$mail->FromName = utf8_decode($linha['empresa']);

////////////////////// SELECIONA O CLIENTE /////////////////////////////
$sql = mysqli_query($conexao, "SELECT * FROM cliente WHERE enviado = '0' AND bloqueado='N' LIMIT {$quant}") or die(mysqli_error($conexao));
$contar =  mysqli_num_rows($sql);
$i = 0;
while ($cli = mysqli_fetch_array($sql)):
    $i++;
    $id_cliente = $cli['id_cliente'];
    $grupoCliente = $cli['id_grupo'];
    $nome = $cli['nome'];
    $ref = 'Fatura automática';
    $valor = $cli['valor'];
    $situacao = 'P';
    $tipofatura = 'AVULSO';
    $emailCliente = $cli['email'];
    $ins = mysqli_query($conexao, "INSERT INTO faturas (id_cliente, grupoCliente, nome, ref, data, data_venci, valor,situacao,emailcli, tipofatura)VALUE('$id_cliente', '$grupoCliente', '$nome','$ref','$data','$vencimento','$valor','$situacao','$emailCliente','$tipofatura')")or die(mysqli_error($conexao));
    $idfatura = mysqli_insert_id($conexao);
    if ($ins) {
       $up = mysqli_query($conexao, "UPDATE cliente SET enviado='1' WHERE id_cliente= {$id_cliente}")or die(mysqli_error($conexao));
        /*
         * CASO A FATURA TENHA SIDO GERADA, ENVIAR O EMAIL PARA O CLIENTE
         */ 
            $dado = 'id_venda='.$idfatura;
            $pagina = base64_encode($dado);
            $link = $endereco.'/boleto/boleto.php?'.$pagina;

            $dado = $html;
            $search = array('[NomedoCliente]', '[valor]','[vencimento]','[numeroFatura]','[Descricaodafatura]','[link]'); // pega oa variaveis do html vindo do banco;
            $replace = array($nome, number_format($valor,2,',','.'), $vencimentoenvio, $idfatura,$ref,$link); //  variavis que substiruem os valores
            $subject = $dado;

            $texto = str_replace($search, $replace, $subject);
            $mail->Body = utf8_decode($texto);
            $mail->AddAddress($emailCliente, $nome);
            
            $mail->Send();
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();

        
    }
    
    $quantidade = mysqli_query($conexao, "SELECT * FROM cliente WHERE enviado = '0'") or die(mysqli_error($conexao));
    $aenviar =  mysqli_num_rows($quantidade);
    
    
    if($i == $contar && $aenviar > 0):
        echo '<meta http-equiv="refresh" content="'. $seg.'",URL=cron.php>';
    endif;  
endwhile;


$up = mysqli_query($conexao, "UPDATE cliente SET enviado='0'")or die(mysqli_error($conexao));

?>