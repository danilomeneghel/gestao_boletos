<div id="grafico">
  <div id="historico">
    <strong><?php echo $config['recebm'] ?></strong><br/>
    <hr>
    <table id="estatistica" width="30%" border="0">
      <tr>
        <td><?php echo $config['Recebidos'] ?></td>
        <td><?php echo $contb; ?></td>
      </tr>
      <tr>
        <td><?php echo $config['Ematraso'] ?></td>
        <td><?php echo $contv;?></td>
      </tr>
        <tr>
        <td><?php echo $config['Emaberto'] ?></td>
        <td><?php echo $contp ?></td>
      </tr>
    </table>
  </div>
  <div id="resumo">
    <strong>Resumo de valores do mês atual:</strong><br/>
    <hr><br/>
    <?php $juros = $valorr - $valorm ;?>
    <strong>Total em faturas: <?php echo  "R$ ". number_format($valorm, 2, ',', '.');?></strong><br/><br/>
    Total Recebido: <?php echo "R$ ". number_format($valorr, 2, ',', '.'); ?><br/>
    Total em aberto: <?php echo "R$ ". number_format($valorp, 2, ',', '.'); ?><br/>
    Total em atraso: <?php echo "R$ ". number_format($valorv, 2, ',', '.'); ?><br/><br/>
    Total de juros recebidos: <?php echo "R$ ". number_format($juros, 2, ',', '.'); ?><br/>
  </div>
</div>
<div style="clear:both"></div>
<div id="previa-do-dia">
	<div id="receber-hoje">
  	 <table width="100%" cellspacing="1" summary="Tabela de dados fictícios" data-rowindex="1" data-rowtype="1">
      <thead>
        <tr>
          <th colspan="4">PREVISÃO DE ENTRADAS DO DIA</th>
        </tr>
      </thead>
      <tbody>
       <tr>
				 	<td width="23%">Boletos vencendo hoje: </td>
          <td width="12%"><div id="hoje1" ><?php echo $reg; ?></div></td>
          <td width="29%">Previsão de recebimento para hoje:</td>
          <td width="36%"><div id="hoje1" class="iconfont fatura"><?php echo "R$ ". number_format($totalhoje, 2, ',', '.'); ?></div></td>
			  </tr>
       </tbody>
      </table>
  </div>
</div>
