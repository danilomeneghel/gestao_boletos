<?php 
include '../classes/conexao.php';

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);


function gerarNome($total_caracteres){

     $caracteres = 'ABCDEFGHIJKLMNOPQRSTUWXYZ';
     $caracteres .= 'abcdefghijklmnopqrstuwxyz';
     $caracteres .= '0123456789';
     $max = strlen($caracteres)-1;
     $senha = null;
     for($i=0; $i < $total_caracteres; $i++){
        $senha .= $caracteres{mt_rand(0, $max)};
    }
    return $senha;
 }
 $total_caracteres = 8;
 $nomeArquivo = gerarNome($total_caracteres);


$sql = mysql_query("SELECT * FROM config")or die(mysql_error());
$ver = mysql_fetch_array($sql);

$sql2 = mysql_query("SELECT * FROM bancos WHERE situacao='1'")or die(mysql_error());
$banco = mysql_fetch_array($sql2);


include 'vendor/autoload.php';
if($banco['id_banco'] == '1'){
	
$codigo_banco = Cnab\Banco::BANCO_DO_BRASIL;	
}
elseif($banco['id_banco'] == '2'){
$codigo_banco = Cnab\Banco::BRADESCO;	
}
elseif($banco['id_banco'] == '3'){
$codigo_banco = Cnab\Banco::CEF;	
}
elseif($banco['id_banco'] == '4'){
	$codigo_banco = Cnab\Banco::ITAU;
}
elseif($banco['id_banco'] == '5'){
$codigo_banco = Cnab\Banco::SANTANDER;	
}


$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);
$arquivo->configure(array(
    'data_geracao'  => new DateTime(),
    'data_gravacao' => new DateTime(), 
    'nome_fantasia' => $ver['nome'], 
    'razao_social'  => $ver['nome'],  
    'cnpj'          => preg_replace( '#[^0-9]#', '', $ver['cpf'] ), 
    'banco'         => $codigo_banco, 
    'logradouro'    => $ver['endereco'],
    'numero'        => $ver['numero'],
    'bairro'        => $ver['bairro'], 
    'cidade'        => $ver['cidade'],
    'uf'            => $ver['uf'],
    'cep'           => preg_replace( '#[^0-9]#', '', $ver['cep'] ),
    'agencia'       => $banco['agencia'], 
    'conta'         => $banco['conta'], 
    'conta_dac'     => $banco['digito_co'], 
));

$grupo = $_POST['grupo'];

$sqlGera = "SELECT * FROM faturas WHERE grupoCliente = '$grupo' AND remessa = '0'";	
	$seleciona  = mysql_query($sqlGera) or die(mysql_error());
	if(mysql_num_rows($seleciona) == 0){
		
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=remessagrupo'>
					  <script type=\"text/javascript\">
		  				alert(\"ERRO! Todas as remessas para este grupo já foram geradas!\");
		  				</script>";
						exit;
		
			
	}
	
	while($fatura = mysql_fetch_array($seleciona)){
	
		$IdCliente = $fatura['id_cliente'];
		$sq = mysql_query("SELECT * FROM cliente WHERE id_cliente='$IdCliente'") or die(mysql_error());
		$cliente = mysql_fetch_array($sq);
			if(strlen($cliente['cpfcnpj']) > 14){
				$documento = 'cnpj';	
			}else{
				$documento = 'cpf';
			}

$arquivo->insertDetalhe(array(
    'codigo_ocorrencia' => 1, // 1 = Entrada de título, futuramente poderemos ter uma constante
    'nosso_numero'      => $fatura['id_venda'],
    'numero_documento'  => $fatura['id_venda'],
    'carteira'          => $banco['carteira'],
    'especie'           => $banco['especie'], // Você pode consultar as especies Cnab\Especie
    'valor'             => $fatura['valor'], // Valor do boleto
    'instrucao1'        => '05', // 1 = Protestar com (Prazo) dias, 2 = Devolver após (Prazo) dias, futuramente poderemos ter uma constante
    'instrucao2'        => '09', // preenchido com zeros
    'sacado_nome'       => $cliente['nome'], // O Sacado é o cliente, preste atenção nos campos abaixo
    'sacado_tipo'       => $documento, //campo fixo, escreva 'cpf' (sim as letras cpf) se for pessoa fisica, cnpj se for pessoa juridica
    'sacado_cpf'        => $cliente['cpfcnpj'],
    'sacado_logradouro' => $cliente['endereco'],
    'sacado_bairro'     => $cliente['bairro'],
    'sacado_cep'        => preg_replace( '#[^0-9]#', '', $cliente['cep'] ), // sem hífem
    'sacado_cidade'     => $cliente['cidade'],
    'sacado_uf'         => $cliente['uf'],
    'data_vencimento'   => new DateTime($fatura['data_venci']),
    'data_cadastro'     => new DateTime($fatura['data']),
    'juros_de_um_dia'     => 0.10, // Valor do juros de 1 dia'
    'data_desconto'       => new DateTime($fatura['data_venci']),
    'valor_desconto'      => 0.0, // Valor do desconto
    'prazo'               => 10, // prazo de dias para o cliente pagar após o vencimento
    'taxa_de_permanencia' => '00', //00 = Acata Comissão por Dia (recomendável), 51 Acata Condições de Cadastramento na CAIXA
    'mensagem'            => '',
    'data_multa'          => new DateTime($fatura['data_venci']), // data da multa
    'valor_multa'         => 0.0, // valor da multa

));
}

$arrnome = $nomeArquivo.'.REM';
// para salvar
$arquivo->save($arrnome);

if($arquivo){
	
	if($grupo != 'todos'){
	$sqlUpa = "UPDATE faturas SET remessa = '1' WHERE grupoCliente = '$grupo' AND remessa='0'";	
	}else{
	$sqlUpa = "UPDATE faturas SET remessa = '1' WHERE remessa='0'";	
	}
	$dataNow = date("Y-m-d H:i:s");
	$grava = mysql_query("INSERT INTO remessas (data ,nome, grupo)VALUES('$dataNow', '$arrnome', '$grupo')") or die(mysql_error());
	

	$up = mysql_query($sqlUpa) or die(mysql_error());


if($up == 1){
		
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=listaremessa'>
					  <script type=\"text/javascript\">
		  				alert(\"ARQUIVO DE REMESSA GERADO COM SUCESSO!\");
		  				</script>";

	}
	
}

?>