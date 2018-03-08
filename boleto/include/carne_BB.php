<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>EMISSAO DE CARNÊS</title>
<style>
.cp {  font:10px Arial; color: black; margin-top:-5px;}
.ti {  font: 9px Arial, Helvetica, sans-serif;}
.ld { font: bold 15px Arial; color: #000000;}
.ct { font: 9px "Arial Narrow"; color: #000; margin-left:2px; margin-top:-8px; padding:0;} 
.cn { FONT: 9px Arial; COLOR: black; }
.bc { font: bold 16px Arial; color: #000000; }
.ld2 { font: bold 12px Arial; color: #00000;0 }

body{margin: 0; font:Arial, Helvetica, sans-serif;}
#carne{width:870px; margin:0 auto;}
.master{margin:0 auto;}
.ti {font: 9px Arial, Helvetica, sans-serif;}
.bordaRight{border-right:1px solid #000;}
.bordaLeft{border-left:1px solid #000;}
.claro{color:#999;}
td{border-bottom:1px solid #000; height:25px; padding:0; padding-left:5px; font-size:9px;}
.campo{text-align:right; font:9px Arial; color: #000; float:right; margin-left:2px; margin-top:3px;}
.campo2{text-align:right; font: bold 10px Arial; color: #000; margin-left:2px; }
.ct1 {FONT: 9px "Arial Narrow"; COLOR: #000033; text-align:left;}
.ct2 {FONT: 9px "Arial Narrow"; COLOR: #000033}
.cp1 {font: bold 10px Arial; color: black}
hr{margin:17px 0px ;}
.vertical-text {
	transform: rotate(90deg);
	transform-origin: left top 0;
}
p{margin:2px 0 0 0;}
@media print {
    #carne { 
        page-break-after: always; 
    }
}
</style>
</head>

<body>

<div id="carne">
<?php @++$i;?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="master">
  <tr>
  <!-- ESQUERDA -->
    <td width="191" valign="top" style="border:0;">
    <table width="172" border="0" cellspacing="0" cellpadding="0" style="border:0;">
      <tr>
        <td width="191" valign="top" style="border:0;">
            	<table width="172" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="81" height="37" class="bordaRight"><img src="imagens/logobb.jpg" width="75" height="20"></td>
            <td width="55" align="center" class="bordaRight"><font class='bc'><?php echo $dadosboleto["codigo_banco_com_dv"]?></font></td>
            <td width="37" align="center"><span class="claro">Recibo sacado</span></td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft">Parcela<br/>
                        <span class="campo">
            <?php 
			echo '<strong>'.$a++.' / '.$contar.'</strong>' ?>&nbsp;&nbsp;
            </span>
            </td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct">Agência/Código cedente</span><br/>
                  <span class="campo">
        <?php echo $dadosboleto["agencia_codigo"]?>&nbsp;&nbsp;
        </span>
            </td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct1">Nossonúmero</span><br/>
                     <span class="campo">
					 <?php echo $dadosboleto["nosso_numero"]?>&nbsp;&nbsp;
                     </span>
            </td>
          </tr>
          <tr>
            <td colspan="3" class="bordaRight bordaLeft">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%" valign="top" class="bordaRight " style="border-bottom:0;"><span class="ct2">Espécie</span><br/>

<?php echo $dadosboleto["especie"]?>

    </td>
    <td width="60%" valign="top" style="border-bottom:0;">Quantidade</td>
  </tr>
</table>

            
            
            </td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct2">(=) Valor documento</span>
                   <span class="campo">
   <?php 
     if($dadosboleto["valor_boleto"] == 0.00){
   $dadosboleto["valor_boleto"] = "";
  }
   echo $dadosboleto["valor_boleto"] ?>&nbsp;&nbsp;
   </span>
            </td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct2">(-) 
Desconto / Abatimentos</span></td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct2">(-) 
Outras deduções</span></td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct2">(+) 
Mora / Multa</span></td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct2">(+) 
Outros acréscimos</span></td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft"><span class="ct2">(=) 
      Valor cobrado</span></td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="bordaRight bordaLeft">Sacado<br/> <?php echo $dadosboleto["sacado"]?><br/>
            
            
            </td>
          </tr>
          </table>
        </td>
      </tr>
    </table></td><!-- FIM ESQUERDA -->
    
    
    <!-- DIVIDA -->
    <td width="10" valign="top" style="border:0;">&nbsp;</td>
    
    
    <!-- DIREITA -->
    <td width="1102" valign="top" style="border:0;">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="90" class="bordaRight"><img src="imagens/logobb.jpg" width="75" height="20"></td>
    <td width="48" align="center" class="bordaRight"><font class='bc'><?php echo $dadosboleto["codigo_banco_com_dv"]?></font></td>
    <td width="478" align="right" class="ld"><?php echo $dadosboleto["linha_digitavel"]?></td>
  </tr>
</table>
	
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5" valign="top" class="bordaRight bordaLeft">
    <span class="ct">Local de pagamento</span><br/>
    <span class="cp">Pagável em qualquer Banco até o vencimento</span></td>
    <td width="156" valign="top">
      <span class="ct">Vencimento</span><br/>
      <span class="campo">
        <?php echo ($data_venc != "") ? $dadosboleto["data_vencimento"] : "Contra Apresentação" ?>
        </span>
      
    </td>
  </tr>
  <tr>
    <td colspan="5" valign="top" class="bordaRight bordaLeft">
    <span class="ct">Cedente</span><br/>
      	<span class="campo" style="float:none;">
 		 <?php echo $dadosboleto["cedente"]?>
  		</span>
    </td>
    <td valign="top">
      <span class="ct">Agência/Código cedente</span><br/>
      <span class="campo">
        <?php echo $dadosboleto["agencia_codigo"]?>
        </span>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" class="bordaRight bordaLeft">
    <span class="ct1">Data do documento</span><br/>
    <span class="campo2"><?php echo $dadosboleto["data_documento"]?></span>

</td>
    <td width="89" align="center" valign="top" class="bordaRight"><span class="ct1">N<u>o</u> documento</span><br/>
    <span class="campo2"><?php echo $dadosboleto["numero_documento"]?></span>
    </td>
    <td width="75" align="center" valign="top" class="bordaRight"><span class="ct1">Espéciedoc.</span><br/>
    <span class="campo2"><?php echo $dadosboleto["especie_doc"]?></span>
    </td>
    <td width="84" align="center" valign="top" class="bordaRight"><span class="ct1">Aceite</span><br/>
    <span class="campo2"><?php echo $dadosboleto["aceite"]?></span>
    
    </td>
    <td width="137" align="center" valign="top" class="bordaRight"><span class="ct1">Data processamento</span><br/>
    <span class="campo2"><?php echo $dadosboleto["data_processamento"]?></span>
    </td>
    <td valign="top"><span class="ct1">Nossonúmero</span><br/>
         <span class="campo">
     <?php echo $dadosboleto["nosso_numero"]?>
     </span>
    </td>
  </tr>
  <tr>
    <td  width=89 height=12 align="left" valign="top" class="bordaRight bordaLeft"><span class="ct1">Uso 
do banco</span></td>
    <td align="center" valign="top" class="bordaRight"><span class="ct1">Carteira</span><br/>
<span class="campo2">
  <?php echo $dadosboleto["carteira"]?>
</span>
    </td>
    <td align="center" valign="top" class="bordaRight"><span class="ct2">Espécie</span><br/>
    <span class="campo2">
<?php echo $dadosboleto["especie"]?>
</span> 
    </td>
    <td align="center" valign="top" class="bordaRight"><span class="ct2">Quantidade</span><br/>
     <span class="campo2">
 <?php echo $dadosboleto["quantidade"]?>
 </span> 
    </td>
    <td align="center" valign="top" class="bordaRight"><span class="ct2">Valor Documento</span><br/>
       <span class="campo2">
   <?php echo $dadosboleto["valor_unitario"]?>
   </span>
    </td>
    <td valign="top"><span class="ct2">(=) Valor documento</span><br/>
       <span class="campo">
   <?php 
     if($dadosboleto["valor_boleto"] == 0.00){
   $dadosboleto["valor_boleto"] = "";
  }
   echo $dadosboleto["valor_boleto"] ?>
   </span>
    </td>
  </tr>
  <tr>
    <td colspan="5" rowspan="5" align="left" class="bordaRight bordaLeft">
    <span class="cp"><strong>Instruções (Texto de responsabilidade do cedente)</strong></span>
    				<p><?php echo $dadosboleto["instrucoes1"]; ?></p>
					<p><?php echo $dadosboleto["instrucoes2"]; ?></p>
					<p><?php echo $dadosboleto["instrucoes3"]; ?></p>
					<p><?php echo $dadosboleto["instrucoes4"]; ?></p><br/>
                    <p><span class="dt"><strong>Detalhes da fatura:</strong></span></p>
                    <p><?php echo nl2br($dadosboleto["demonstrativo1"]); ?> </p>
    </td>
    <td height="12" valign="top"><span class="ct2">(-) 
Desconto / Abatimentos</span><br/><br/></td>
  </tr>
  <tr>
    <td height="12" valign="top"><span class="ct2">(-) 
Outras deduções</span></td>
  </tr>
  <tr>
    <td height="12" valign="top"><span class="ct2">(+) 
Mora / Multa</span></td>
  </tr>
  <tr>
    <td height="12" valign="top"><span class="ct2">(+) 
Outros acréscimos</span></td>
  </tr>
  <tr>
    <td height="12" valign="top"><span class="ct2">(=) 
      Valor cobrado</span></td>
  </tr>
  <tr>
    <td height="12" colspan="6" align="left" class="bordaLeft" ><span class="ct2">Sacado</span><br/>
    <span class="campo2">
    <?php echo $dadosboleto["sacado"]?>
    </span>
    </td>
    </tr>
  <tr>
    <td height="12" colspan="6" align="left" style="border:none;" >
    <TABLE cellSpacing=0 cellPadding=0 border=0 width=666>
      <TBODY>
        <TR>
          <TD class=ct2  width=7 height=12 style="border:none;"></TD>
          <TD class=ct2  width=409 style="border:none;">Sacador/Avalista</TD>
          <TD class=ct2  width=250  style="border:none;"><div align=right>Autenticação 
            mecânica - <b class=cp1>Ficha de Compensação</b></div></TD>
        </TR>
        </tbody>
    </table>
    <TABLE cellSpacing=0 cellPadding=0 width=666 border=0><TBODY><TR><TD vAlign=bottom align=left height=50 style="border:none;"><?php fbarcode($dadosboleto["codigo_barras"]); ?> 
 </TD>
</tr></tbody></table>
    </td>
  </tr>
    </table>

    
    
    
    </td>
  </tr>
</table>
<hr>
<?php if($i == 3){ echo '</div>'; $i=0;}?>
</body>
</html>