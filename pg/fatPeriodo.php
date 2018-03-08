<script type="text/javascript">  
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function validar_uni() {
var ref = formu.ref.value;
var valor = formu.valor.value;
var parcelas = formu.parcelas.value;
var dia = formu.dia.value;

if (ref == "") {
alert('Digite a referência da fatura.');
formu.ref.focus();
return false;
}
if (valor == "" || valor == "0,00") {
alert('Digite o valor das parcelas.');
formu.valor.focus();
return false;
}
if (parcelas == "1") {
alert('Selecione a quantidade de parcelas.');
formu.parcelas.focus();
return false;
}
if (dia == "0") {
alert('Selecione o dia do vencimento.');
formu.dia.focus();
return false;
}

}
</script>
<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script>
    $(document).ready(function () {
        $(".data_venci").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Proximo',
            prevText: 'Anterior'
        });
      });
    </script>
	<div id="menufatura">
	<ul>
    	<li>
            <div class="control-group">
            <div class="controls">
                <div class="btn ewButton" name="user" id="btnsubmit"/ >
                <a href="inicio.php?pg=lancafatura" style=" text-decoration:none; color:#000;">
                <i class="icon-refresh"></i> Fatura unica</a>
            </div>
            </div>
      </li>
      <li>
        <div class="control-group">
        <div class="controls">
            <div class="btn ewButton" name="user" id="btnsubmit"/ >
            <a href="inicio.php?pg=periodica" style=" text-decoration:none; color:#000;">
            <i class="icon-refresh"></i> Fatura para grupo de clientes</a>
            </div>
        </div>
      </li>
      <li>
        <div class="control-group">
        <div class="controls">
            <div class="btn ewButton" name="user" id="btnsubmit"/ >
            <a href="inicio.php?pg=carne" style=" text-decoration:none; color:#000;">
            <i class="icon-refresh"></i> Gerar Carnê</a>
            </div>
        </div>
      </li>
  </ul>

</div>
<div style="clear:both;"></div><br/><br>
<script type="text/javascript" src="js/jquery.mask-money.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        $("#valores").maskMoney({decimal:",",thousands:""});
      });


</script>
<?php
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
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

$data = date("Y-m-d");

if(isset($_POST['lancar'])){

	$timestamp = strtotime($data . "+1 months 0 days");
	$dataPrimeiraParcela = date('d/m/Y', $timestamp);

function calcularParcelas($nParcelas, $dataPrimeiraParcela = null){
	if($dataPrimeiraParcela != null){
   	   $dataPrimeiraParcela = explode( "/",$dataPrimeiraParcela);
	   $dia = $dataPrimeiraParcela[0];
   	   $mes = $dataPrimeiraParcela[1];
	   $ano = $dataPrimeiraParcela[2];
      	} else {
       $dia = date("d");
	   $mes = date("m");
	   $ano = date("Y");
      	}


      	for($x = 0; $x < $nParcelas; $x++){
			$id_cliente = $_POST['id_cliente'];
			$ref = $_POST['ref'];
			$grupoCliente = $_POST['grupoCliente'];

			$valor = tiraMoeda($_POST['valor']);
			$data = date("Y/m/d");
			$dia = datas($_POST['dia']); // primeiro vencimento
			$nome = $_POST['nome'];
			$pedido = $_SESSION['boleto'] = md5(geraSenha(30).date("Y-m-d H:i"));

	   $dt_parcelas[] = date("Y-m-d", strtotime("+".$x." month",strtotime($dia)));
	  }//for

	  	include "classes/conexao.php";
	   foreach($dt_parcelas as $indice => $datas){
		 $sql = mysqli_query($conexao,"INSERT INTO faturas (id_cliente,grupoCliente,nome, ref, data, data_venci, valor, situacao,tipofatura,pedido )
		 VALUES ('$id_cliente','$grupoCliente','$nome', '$ref', '$data', '$datas', '$valor', 'P','carne','$pedido')") or die (mysqli_error());
	   }// fereach
	   //include 'email.php';
	   if($sql == 1){

			echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=carne'>
				<script type=\"text/javascript\">
				alert(\"Faturas lançadas com sucesso!\");
				</script>";

			unset($_SESSION['boleto']);
				}else{
					echo mysqli_error();
				}
   }//function


$parcelas = $_POST['parcelas'];
calcularParcelas($parcelas, $dataPrimeiraParcela);

}

?>

<div id="entrada">
  <div id="cabecalho"><h2><i class="icon-money iconmd"></i> Faturas periódicas</h2></div>
 <div id="forms">
<form action="" method="post" enctype="multipart/form-data">
  <select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
    <option>Selecione um cliente...</option>
    <?php
	$sql = mysqli_query($conexao,"SELECT * FROM cliente ORDER BY nome ASC")or die (mysqli_error());
	while($linha = mysqli_fetch_array($sql)){
	?>
    <option value="?pg=carne&id_cliente=<?php echo $linha['id_cliente'] ?>&nome=<?php echo $linha['nome']; ?>"><?php echo $linha['nome']; ?></option>
    <?php } ?>
  </select>
</form>
<!-- FORM FATURA -->
<?php if(isset($_GET['id_cliente'])){
	?>
<form action="" method="post" enctype="multipart/form-data" name="formu" onSubmit="return validar_uni(this);">
	<?php
	$id = $_GET['id_cliente'];
    $sq = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente='$id'")or die (mysqli_error());
    $l = mysqli_fetch_array($sq);
	$cnpj = $l['cpfcnpj'];
	$grupoCliente = $l['id_grupo'];
    ?>
    <hr/>
    <?php
	if($_GET['id_cliente']){
	?>

    <strong>Confira os dados do cliente:</strong><br/>
	<ul>
    <li><strong>Nome:</strong> <?php echo $l['nome']; ?></li>
    <?php
	if($cnpj != ""){
		echo '<li><strong>CPF/CNPJ: </strong>'.$l['cpfcnpj'].'</li>';
	}
	}
	?>
    </ul>
    <hr/>
	<div id="fatura">DADOS DA FATURA</div>

    <br/>
<table width="100%" border="0" cellspacing="3">
  <tr>
    <td width="16%" align="right">Referênte: <br/></td>
    <td width="84%"><input name="ref" type="text" size="60">
    <input name="id_cliente" type="hidden" value="<?php echo $_GET['id_cliente']?>">
    <input name="nome" type="hidden" value="<?php echo $_GET['nome']; ?>">
    <input name="grupoCliente" type="hidden" value="<?php echo  $l['id_grupo']?>">
    </td>
    </tr>
  <tr>
    <td align="right">Valor da parcela R$:</td>
    <td><input name="valor" type="text" size="8" id="valores" style="text-align:right;" ></td>
    </tr>
  <tr>
    <td align="right">Numero de Parcelas:</td>
    <td><select name="parcelas" id="select" style="width:50px;">
  <?php
	for($a = 01; $a <= 240; $a++){
	?>
    <option value="<?php echo $a ?>"><?php echo $a ?></option>
    <?php } ?>
  </select></td>
  </tr>
  <tr>
    <td align="right">Primeiro vencimento:</td>

<?php     $s = mysqli_query($conexao,"SELECT * FROM config")or die (mysqli_error());
	$lin = mysqli_fetch_array($s);
	$prazo = $lin['receber'];

	$timestamp = strtotime($data . "+1 months $prazo days");
	$vencimento = date('d', $timestamp);


	?>
    <td><br/>
    <div class="input-prepend">
    <span class="add-on"><i class="icon-calendar"></i></span>
    <input type="text" name="dia" class="data_venci" style="width:100px;"/>
    </div></td>
    </tr>
  <tr>
    <td colspan="2">
      <input name="lancar" type="submit" value="Lançar Faturas" id="lancar" style="margin-left:25px;" class="btn btn-success">


    </td>
    </tr>
</table>


</form>
</div>
<?php } ?>




</div>
