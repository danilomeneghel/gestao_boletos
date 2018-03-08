<?php
if(isset($_GET['atualizar']) == "true"){
	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=fluxo#tabs-2'>";
}

$dia_lanc = date("d");
$mes_atual = date("m");
$verifica_data = mysqli_query($conexao,"SELECT * FROM flux_fixas WHERE dia_vencimento <= $dia_lanc");
$contar = mysqli_num_rows($verifica_data);
if($contar >= 1){

while($ins = mysqli_fetch_array($verifica_data)){

$dia_vencimento = $ins['dia_vencimento'];
$valor_fixa = $ins['valor_fixa'];
$descr_fixa = $ins['descricao_fixa'];
$dataagora = date('Y-m-').$dia_vencimento;

$sel = mysqli_query($conexao,"SELECT * FROM flux_entrada WHERE data = '$dataagora' AND descricao = '$descr_fixa'") or die(mysqli_error());
$cont = mysqli_num_rows($sel);
$confere = mysqli_fetch_array($sel);

if($cont < 1){
$lanca_automatico = mysqli_query($conexao,"INSERT INTO flux_entrada (data, tipo, descricao, valor)VALUES('$dataagora','D','$descr_fixa','$valor_fixa')");

}

}
}

?>


<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(pagina,nome,settings);
	}
window.name = "main";

</script>


<div id="entrada">
<div id="cabecalho"><h2><i class="icon-list-alt"></i> Fluxo de Caixa</h2></div>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js"></script>

<div align="left" style="padding:10px 12px"><strong>Movimento</strong></div>

<?php
$anoinicio = date("Y") - 5;
$anofim = date("Y") + 5;
if(isset($_GET['ano'])){
	$hoje = $_GET['ano'];
}else{
$hoje = date("Y");
}
$meshoje = date("m");
?>

<div id="meses">
	<ul>
    	<li style="background-color:transparent; border:0;">
        <form name="form" id="form">
          <select name="ano" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" style=" width:auto; margin-top:-6px;">
          <?php
						for($i =$anoinicio; $i < $anofim; $i++){ ?>
						<option value="?pg=fluxo&mes=<?php echo $meshoje ?>&ano=<?php echo $i ?>" <?php if(!(strcmp($i, $hoje))) {echo "selected=\"selected\"";} ?>><?php echo $i ?></option>';
          <?php
					}
					?>
          </select>
        </form>
      </li>
    	<li><a href="inicio.php?pg=fluxo&mes=1&ano=<?php echo $hoje?>" class="meses">Janeiro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=2&ano=<?php echo $hoje?>" class="meses">Fevereiro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=3&ano=<?php echo $hoje?>" class="meses">Março</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=4&ano=<?php echo $hoje?>" class="meses">Abril</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=5&ano=<?php echo $hoje?>" class="meses">Maio</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=6&ano=<?php echo $hoje?>" class="meses">Junho</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=7&ano=<?php echo $hoje?>" class="meses">Julho</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=8&ano=<?php echo $hoje?>" class="meses">Agosto</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=9&ano=<?php echo $hoje?>" class="meses">Setembro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=10&ano=<?php echo $hoje?>" class="meses">Outubro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=11&ano=<?php echo $hoje?>" class="meses">Novembro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=12&ano=<?php echo $hoje?>" class="meses">Dezembro</a></li>
    </ul>
</div>

<?php
   $mes_agora = date('m');
	$ano = date('Y');

	if(isset($_GET['mes'])){
		$mes_sel = $_GET['mes'];
	}else{
		$mes_sel = $mes_agora;
	}
	if(isset($_GET['ano'])){
	$ano_sel = $_GET['ano'];
	}else{
		$ano_sel = $ano;
	}

switch ($mes_sel){

case 1: $mes = "Janeiro"; break;
case 2: $mes = "Fevereiro"; break;
case 3: $mes = "Março"; break;
case 4: $mes = "Abril"; break;
case 5: $mes = "Maio"; break;
case 6: $mes = "Junho"; break;
case 7: $mes = "Julho"; break;
case 8: $mes = "Agosto"; break;
case 9: $mes = "Setembro"; break;
case 10: $mes = "Outubro"; break;
case 11: $mes = "Novembro"; break;
case 12: $mes = "Dezembro"; break;

}


   $bolet = mysqli_query($conexao,"SELECT SUM(valor_recebido) AS total FROM faturas WHERE situacao='B' AND MONTH(dbaixa) ='$mes_sel' AND YEAR(dbaixa) = '$ano_sel'")
   or die(mysqli_error());
   $boletos = mysqli_fetch_array($bolet);

   $ent = mysqli_query($conexao,"SELECT SUM(valor) AS total FROM flux_entrada WHERE tipo='R' AND MONTH(data) ='$mes_sel' AND YEAR(data) = '$ano_sel'")or die(mysqli_error());
   $entradas = mysqli_fetch_array($ent);

   $totalentrada = $boletos['total'] + $entradas['total'];

   $sai = mysqli_query($conexao,"SELECT SUM(valor) AS total FROM flux_entrada WHERE tipo='D' AND MONTH(data) ='$mes_sel' AND YEAR(data) = '$ano_sel'")or die(mysqli_error());
   $saida = mysqli_fetch_array($sai);
   $resultado = $totalentrada - $saida['total'];
   if($resultado < 0){$cor = "resultadonegativo";}else{$cor = "resultadopositivo";}
   ?>

<table width="85%" border="0" style="padding:25px 0px">
  <tr>
    <td width="51%">
    	<fieldset><legend class="legend">Entradas e Saídas deste mês</legend>
        	<table width="99%" border="0">
              <tr>
                <td align="left"><span class="receita">Entradas de boletos:</span></td>
                <td align="right"><span class="receita"><?php echo number_format($boletos['total'], 2,',','.') ?></span></td>
              </tr>
              <tr>
                <td width="77%" align="left"><span class="receita">Outras Entradas:</span></td>
                <td width="23%" align="right"><span class="receita"><?php echo number_format($entradas['total'], 2,',','.') ?></span></td>
              </tr>
              <tr>
                <td align="left"><span class="azul">Total de entradas:</span></td>
                <td align="right"><span class="azul"><?php echo number_format($totalentrada, 2,',','.') ?></span></td>
              </tr>
              <tr>
                <td align="left"><span class="despesa">Saídas:</span></td>
                <td align="right"><span class="despesa"><?php echo number_format($saida['total'], 2,',','.') ?></span></td>
              </tr>
              <tr align="left">
                <td colspan="2"><hr/></td>
                </tr>
              <tr>
                <td align="left"><span class="<?php echo $cor ?>">Resultado:</span></td>
                <td align="right"><span class="<?php echo $cor ?>"><?php echo number_format($resultado, 2,',','.') ?></span></td>
              </tr>
            </table>
        </fieldset>
    </td>
	</tr>
</table>

<script type="text/javascript">
function marcardesmarcar(){
   if ($("#todos").attr("checked")){
      $('.marcar').each(
         function(){
            $(this).attr("checked", true);
         }
      );
   }else{
      $('.marcar').each(
         function(){
            $(this).attr("checked", false);
         }
      );
   }
}

function validaCheckbox(v){
    todos = document.getElementsByTagName('input');
    for(x = 0; x < todos.length; x++) {
        if (todos[x].checked){
            return true;
        }
    }
    alert("Selecione pelo menos uma fatura!");
    return false;
}
</script>
</div>
