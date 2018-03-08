 <?php	
include "../classes/conexao.php";
/* error_reporting(E_ALL);
ini_set("display_errors", 1); */


////////////// arredonda valores /////////////////////////////////
function round_out ($value, $places=0) {
  if ($places < 0) { $places = 0; }
  $mult = pow(10, $places);
  return ($value >= 0 ? ceil($value * $mult):floor($value * $mult)) / $mult;
}


function tiraPontos($valor){
	$pontos = '.';
	$virgula = '-';
	$barra = '/';
	$result = str_replace($pontos, "", $valor);
	$result2 = str_replace($virgula, "", $result);
	$result3 = str_replace($barra, "", $result2);
	return $result3;
}
	function datas($dado){
		$data = explode("-", $dado);
		$dia = $data[0];
		$mes = $data[1];
		$ano = $data[2];
		
		$resultado = $ano."/".$mes."/".$dia;
		return $resultado;	
		
	}
    function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }

    function datasV($dado) {
        $data = explode("-", $dado);
        $dia = $data[0];
        $mes = $data[1];
        $ano = $data[2];

        $resultado = $ano . "/" . $mes . "/" . $dia;
        return $resultado;
    }

$id_venda = $_GET['id_venda'];

$b = mysqli_query("SELECT * FROM bancos WHERE id_banco = '5'") or die(mysqli_error());
$banco = mysqli_fetch_array($b); 


/////////////// dados do boleto ////////////
$sqlvenda = mysqli_query("SELECT * FROM faturas WHERE id_venda = '$id_venda'");
$ver_venda = mysqli_fetch_array($sqlvenda);

$vencimento = $ver_venda['data_venci'];
$atual = date("Y-m-d");

$valor = tiraPontos($ver_venda['valor']);

	if(strtotime($vencimento) < strtotime($atual)){
		$vencimento = $atual;

////////////////////////// CALCULA DIAS DE VENCIDO /////////////////////

$sql = mysqli_query("SELECT * FROM config")or die (mysqli_error());
$linha = mysqli_fetch_array($sql);

$valor_doc = $ver_venda['valor'];
$juros = $linha['juro'];
$multa = $linha['multa_atraso'];

$data_inicial = datas($ver_venda['data_venci']);
$data_final = date("d/m/Y");

function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
$diferenca = $time_final - $time_inicial; 
$dias = (int)floor( $diferenca / (60 * 60 * 24));
//------------- SE O VALOR FOR NEGATIVO COLOCA ZERO NA DIVERENCA ------------------------
if($dias <= 0){
	$dias = 0;		
}

////////////////////////////////////CALCULA JUROS //////////////////////////////////////////
$jurost = ($juros * $dias);

$valordojuro = ($valor_doc * $jurost / 100); 
$valorcomjuros = ($valor_doc + $valordojuro);
if($dias <= 0){
	$multa = 0;		
}
$valormulta = ($valorcomjuros * $multa / 100 );

$valorj = round_out($valorcomjuros + $valormulta,2);
$valor = tiraPontos($valorj);
}

	
//exit;
//////////////////////////////////////////////
	$cliente = $ver_venda['id_cliente'];
	
	$linkpronto = $ver_venda['linkGerencia'];
	
	if(!empty($linkpronto) && $ver_venda['situacao'] == 'P'){
		print "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=$linkpronto'>";
		exit;
	}
	
////////////// dados do cliente ////////////////////

$sqlcliente = mysqli_query("SELECT * FROM cliente WHERE id_cliente = '$cliente'")or die(mysqli_error());;
$ver = mysqli_fetch_array($sqlcliente);



//////////////////////////////////// INTEGRAÇÃO //////////////////////////
    $url = "https://integracao.gerencianet.com.br/xml/boleto/emite/xml";

    $token = $banco['tokem'];

    $xml = "<?xml version='1.0' encoding='utf-8'?>
    <boleto>
    	<token>$token</token>
    	<clientes>
    		<cliente>
    			<nomeRazaoSocial>" . $ver['nome'] . "</nomeRazaoSocial>
    			<cpfcnpj>" . tiraPontos($ver['cpfcnpj']) . "</cpfcnpj>
    			<cel>" .soNumero($ver['telefone']) . "</cel>
    		</cliente>
    	</clientes>
    	<itens>
    		<item>
    			<descricao>".$ver_venda['ref']."</descricao>
    			<valor>" . $valor . "</valor>
    			<qtde>1</qtde>
    			<desconto>0</desconto>
    		</item>
    	</itens>
    	<vencimento>" . datasV($vencimento). "</vencimento>
    </boleto>";




    $xml = str_replace("\n", '', $xml);
    $xml = str_replace("\r", '', $xml);
    $xml = str_replace("\t", '', $xml);
    $ch = curl_init();


    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    $data = array('entrada' => $xml);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'seu agente');
    $resposta = curl_exec($ch);
    curl_close($ch);

    $resposta;

    // Apenas um exemplo de como Extrair informações do XML de resposta. Veja que é necessário verificar a estrutura da resposta para acessar os campos desejados.


    $retorno = simplexml_load_string($resposta);
     //echo '<pre>';
      //print_r( $resposta);
     //echo '</pre>';
    // Resposta em caso de sucesso na emissão
	$dataAtual = date("Y-m-d");

    if ($retorno->statusCod == 2) {


        $linkss = $retorno->resposta->cobrancasGeradas->cliente->cobranca->link;
        $chave = $retorno->resposta->cobrancasGeradas->cliente->cobranca->chave;
        $ret = $retorno->resposta->cobrancasGeradas->cliente->cobranca->retorno;
        $lik = mysqli_query("UPDATE faturas SET linkGerencia = '$linkss', chaveGerencia='$chave' WHERE id_venda = '$id_venda' ");

// corpo da mensagem







 

// verifica se enviou corretament


//////////////////////////////////////////////////////////////////////////////////////////		
		
		
		
		
		print "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=$linkss'>";
		exit;
	
		
    } else {

        echo "Erro ao gerar fatura. Revise as configurações do gerencianet.";
    }
    	




