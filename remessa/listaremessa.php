<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['usuario_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}

if(isset($_GET['deleta']) && $_GET['deleta'] == "del"){
	$file = $_GET['file'];
	$id = $_GET['id'];
	
	$del = mysqli_query($conexao,"DELETE FROM remessas WHERE id='$id'")or die (mysqli_error($conexao));
	unlink("remessa/$arquivo");
	
}

?>

<div id="entrada">

<div id="cabecalho"><h2><i class="icon-download-alt  iconmd"></i> Lista de arquivos de remessa</h2> </div>

<div id="forms">
<div id="fundo-tabela2" style="width:70%;">
	   
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="1">
<tbody>
  <tr>
    <td width="226" bgcolor="#0490fc"><span class="fontebranca">NOME DO ARQUIVO</span></td>
    <td width="271" bgcolor="#0490fc"><span class="fontebranca">DATA</span></td>
    <td width="272" bgcolor="#0490fc"><span class="fontebranca">GRUPO</span></td>
    <td width="136" align="center" bgcolor="#0490fc"><span class="fontebranca">AÇÃO</span></td>
    </tr>
</tbody>


<?php
$sql = mysqli_query($conexao,"SELECT * FROM remessas ORDER BY id DESC") or die(mysqli_error($conexao));
while ($a = mysqli_fetch_array($sql)){
	   $arquivo = $a['nome'];
	   $grupo = $a['grupo'];
	   ?>

  <tr>
    <td width="226"><i class="icon-fixed-width icon-file-text pull-left icon-border" style="color:green;"></i> <?php echo $arquivo ?></td>
    <td width="271">
    
    <?php 
	
	$timestamp = strtotime($a['data']);
	echo date('d/m/Y - H:i:s', $timestamp);
	?>
    </td>
    <td width="272">
    
    <?php 
	if($grupo != 0){
	$g = mysqli_query($conexao,"SELECT * FROM grupo WHERE id_grupo = '$grupo'") or die(mysqli_error($conexao));
	$gr = mysqli_fetch_array($g);
	echo $gr['nomegrupo'];
	}else{
	echo "REMESSA AVULSA";	
	}
	 ?>
    </td>
    <td width="136" align="center">
      <a href="php/dwonload_remessa.php?download=<?php echo $arquivo  ?>" title="Download">
        <i class="icon-save icon-2x pull-left icon-border" style="color:#063; text-decoration:none; font-size:16px;"></i></a>
      
      <a href="inicio.php?pg=listaremessa&deleta=del&id=<?php echo $a['id']  ?>&file=<?php echo $arquivo  ?>" title="Excluir" onClick="return confirm('Confirma exclusão do arquivo?')">
        <i class="icon-trash icon-2x pull-left icon-border" style="color:#FF0000; text-decoration:none; font-size:16px;"></i></a></td>
  </tr>

	<?php   
	   
	   }


?>
</table>
</div></div></div>




