<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'include/seCAIXA.php';

function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}
////////////// arredonda valores /////////////////////////////////
function ceil_dec($number,$precision,$separator)
{
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
//------------------------------------------------------------------------
$sql = mysqli_query($conexao,"SELECT * FROM config")or die (mysqli_error());
$linha = mysqli_fetch_array($sql);

$juros = $linha['juro'];
$multa = $linha['multa_atraso'];
$receber = $linha['receber'];

$demo2 = $linha['demo2'];
$demo3 = $linha['demo3'];
$demo1 = $linha['demo1'];
$demo4 = $linha['demo4'];

$nome = $linha['nome'];
$cpf = $linha['cpf'];
$endereco = $linha['endereco'];
$cidade = $linha['cidade'];
$uf = $linha['uf'];
$cedente = $linha['nome'];

$logo = $linha['logo'];

$banco = mysqli_query($conexao,"SELECT * FROM bancos WHERE id_banco='3'")or die (mysqli_error());
$li = mysqli_fetch_array($banco);

$str = $_SERVER['QUERY_STRING'];
$string = base64_decode($str);
$array = explode('&', $string);
foreach($array as $valores){
	$valores;
	$arrays = explode('=', $valores);
		foreach($arrays as $val){
		$dado[] = $val;
		}
}
$pedido = $_GET['pedido'];


////////////////////////////////////////////////////////////////////////////////

$compra = mysqli_query($conexao,"SELECT *,date_format(data_venci, '%d/%m/%Y') AS datad, date_format(data, '%d/%m/%Y') AS data FROM faturas WHERE pedido='$pedido' AND situacao !='B'")or die (mysqli_error());
$a = 1;
$contar = mysqli_num_rows($compra);
while($valor = mysqli_fetch_array($compra)){
	$valor_doc = $valor['valor'];
	$id_venda = $valor['id_venda'];
	
	$idcliente = $valor['id_cliente'];
	$dat_novo_venc = date("d/m/Y");


////////////////////////// CALCULA DIAS DE VENCIDO /////////////////////
$data_inicial = $valor['datad'];;
$data_final = date("d/m/Y");


$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
$diferenca = $time_final - $time_inicial; 
$dias = (int)floor( $diferenca / (60 * 60 * 24));
//------------- SE O VALOR FOR NEGATIVO COLOCA ZERO NA DIVERENCA ------------------------
if($dias <= 0){
	$dias = 0;		
}

////////////////////////////////////CALCULA JUROS //////////////////////////////////////////
//$jurost = ($juros * $dias);

$valordojuro = ($valor_doc * $juros / 100 ) * $dias ; 
$valorcomjuros = ($valor_doc + $valordojuro);
if($dias <= 0){
	$multa = 0;		
}
$valormulta = ($valorcomjuros * $multa / 100 );

$valor_boleto = @ceil_dec($valorcomjuros + $valormulta,2,'.');


// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = $receber;
$vencimento = data2banco($valor['datad']);
$data_atual = date("Y-m-d");
if($vencimento < $data_atual){
$data_venc = date("d/m/Y");
}else{
$data_venc = $valor['datad'];
}
//$valor_cobrado = $valor_boleto; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_boleto);
$valor_boleto = number_format($valor_cobrado, 2, ',', '');

// Composição Nosso Numero - CEF SIGCB
$dadosboleto["nosso_numero1"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
$dadosboleto["nosso_numero2"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente


// define tamanho do nosso numero
$numero = str_pad($valor['id_venda'], 9, 0, STR_PAD_LEFT);// tamanho 9

$dadosboleto["nosso_numero3"] = $numero;
$dadosboleto["nosso_numero"] = $id_venda; 
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = $valor['data']; // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$cli = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$idcliente'")or die (mysqli_error());
$cliente = mysqli_fetch_array($cli);
$Cnome = $cliente['nome'];
$cpfcnpj = $cliente['cpfcnpj'];
$endereco = $cliente['endereco'];
$numero = $cliente['numero'];
$bairro = $cliente['bairro'];
$cidade = $cliente['cidade'];
$estado = $cliente['uf'];
$cep = $cliente['cep'];


$dadosboleto["sacado"] = "$Cnome - CPF/CNPJ: $cpfcnpj";
$dadosboleto["endereco1"] = "$endereco, Nº $numero - $bairro";
$dadosboleto["endereco2"] = "$cidade - $estado - CEP: $cep";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = $valor['ref'];
$dadosboleto["demonstrativo2"] = $demo2;
$dadosboleto["demonstrativo3"] = $demo3;

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["demonstrativo1"] = $valor['ref'];
$dadosboleto["demonstrativo2"] = '';
$dadosboleto["demonstrativo3"] = '';
$dadosboleto["instrucoes1"] = $demo1;
$dadosboleto["instrucoes2"] = $demo2;
$dadosboleto["instrucoes3"] = $demo3;
$dadosboleto["instrucoes4"] = $demo4;


// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "NÃO";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - CEF
$dadosboleto["agencia"] = $li['agencia']; // Num da agencia, sem digito
$dadosboleto["conta"] = $li['conta']; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = $li['digito_co']; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$dadosboleto["conta_cedente"] = $li['convenio']; // Código Cedente do Cliente, com 6 digitos (Somente Números)
$dadosboleto["carteira"] = $li['carteira'];  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = $nome;
$dadosboleto["cpf_cnpj"] = $cpf;
$dadosboleto["endereco"] = $endereco;
$dadosboleto["cidade_uf"] = $cidade.' - '. $uf;
$dadosboleto["cedente"] = $nome;

// NÃO ALTERAR!
include("include/funcoes_cef_sigcb_m.php"); 
include("include/carne_caixa.php");
$numero = $dadosboleto["nosso_numero"];
//$rel = $numero[0].$numero[1];


$banco = "CAIXA ECONOMICA";
$up = mysqli_query($conexao,"UPDATE faturas SET nosso_numero ='$numero', banco ='$banco' WHERE id_venda='$id_venda'") or die(mysqli_error());
}
?>
