<?php
include '../classes/conexao.php';


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



$sql = mysqli_query($conexao,"SELECT * FROM config")or die(mysqli_error($conexao));
$ver = mysqli_fetch_array($sql);


$sql2 = mysqli_query($conexao,"SELECT * FROM bancos WHERE situacao='1'")or die(mysqli_error($conexao));
$banco = mysqli_fetch_array($sql2);




include 'vendor/autoload.php';

switch ($banco['id_banco']) {
	case 1:
		$codigo_banco = Cnab\Banco::BANCO_DO_BRASIL;
		$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);	
		break;
	case 2:
		$codigo_banco = Cnab\Banco::BRADESCO;
		$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);	
		break;
	case 3;	
		$codigo_banco = Cnab\Banco::CEF;	
		$arquivo = new Cnab\Remessa\Cnab240\Arquivo($codigo_banco);
		break;
	case 4;	
	$codigo_banco = Cnab\Banco::ITAU;
	$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);
		break;
}


/* if($banco['id_banco'] == '1'){
	
$codigo_banco = Cnab\Banco::BANCO_DO_BRASIL;
$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);	
}
elseif($banco['id_banco'] == '2'){
$codigo_banco = Cnab\Banco::BRADESCO;
$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);	
}
elseif($banco['id_banco'] == '3'){
$codigo_banco = Cnab\Banco::CEF;	
$arquivo = new Cnab\Remessa\Cnab240\Arquivo($codigo_banco);
}
elseif($banco['id_banco'] == '4'){
	$codigo_banco = Cnab\Banco::ITAU;
	$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);
}
elseif($banco['id_banco'] == '5'){
$codigo_banco = Cnab\Banco::SANTANDER;	
$arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);
 }*/

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
    'conta_dac'     => $banco['digito_co']	
	
	

));



foreach($_POST['id_venda'] as $key => $id_cliente){	
	$id_venda = isset($_POST['id_venda'][$key])? $_POST['id_venda'][$key] :null;
	
	$seleciona  = mysqli_query($conexao,"SELECT * FROM faturas WHERE id_venda = '$id_venda'") or die(mysqli_error($conexao));
	$fatura = mysqli_fetch_array($seleciona);
	
		$IdCliente = $fatura['id_cliente'];
		$sq = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$IdCliente'") or die(mysqli_error($conexao));
		$cliente = mysqli_fetch_array($sq);
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
	'sacado_razao_social' => $cliente['nome'],
    'sacado_tipo'       => $documento, //campo fixo, escreva 'cpf' (sim as letras cpf) se for pessoa fisica, cnpj se for pessoa juridica
    'sacado_cpf'        => $cliente['cpfcnpj'],
	'sacado_cnpj'		=> $cliente['cpfcnpj'],
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
	'aceite' 			=> 'N'

));
}
$arrnome = $nomeArquivo.'.REM';
// para salvar
$arquivo->save($arrnome);

if($arquivo){
foreach($_POST['id_venda'] as $key => $id_cliente){	
	$id_venda = isset($_POST['id_venda'][$key])? $_POST['id_venda'][$key] :null;
	$up = mysqli_query($conexao,"UPDATE faturas SET remessa = '1' WHERE id_venda = '$id_venda'");
}
	$dataNow = date("Y-m-d H:i:s");
	$grava = mysqli_query($conexao,"INSERT INTO remessas (data ,nome, grupo)VALUES('$dataNow', '$arrnome', '0')") or die(mysqli_error($conexao));
if($up == 1){
		
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=listaremessa'>
					  <script type=\"text/javascript\">
		  				alert(\"ARQUIVO DE REMESSA GERADO COM SUCESSO!\");
		  				</script>";

	}
	
}
mysqli_close($conexao);

?>