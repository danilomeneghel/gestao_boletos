<?php
include "../classes/conexao.php";

$arquivo = $_FILES['logo'];
$arquivo_name = $arquivo['name'];

$diretorio = "../boleto/imagens/"; // pasta para onde vai o arquivo
$arquivo = "arquivo";
//pega o nome do arquivo e retira os espaços e acentos.

function arquiName($arquivo, $dir) {
  $parte = explode(".", $arquivo);
  $n = substr(md5(uniqid(time())), 0, 15);
  $nFinal = $n . "." . $parte[1];
  if(file_exists($dir . "/" . $nFinal)) {
    $nFinal = arquiNome($arquivo, $dir);
  }
  return $nFinal;
}

$nome_arquivo = @arquiName($_FILES['logo']['name']);

$extensao = pathinfo($nome_arquivo, PATHINFO_EXTENSION);

$_UP['extensoes'] = array('jpg', 'png', 'gif');

if (array_search($extensao, $_UP['extensoes']) === false) {
  print utf8_decode("
	<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=configuracoes'>
	<script type=\"text/javascript\">
	alert(\"ERRO!!. O arquivo selecionado não é uma imagem. Por favor envie: .jpg, .png ou .gif\");
	</script>");
  exit;
}

$nm = @arquiName($nome_arquivo, $dir); // novo nome
//Cria um arquivo temporário.
$arquivo_temporario = $_FILES['logo']["tmp_name"];
// realiza o upload.
move_uploaded_file($arquivo_temporario, "$diretorio/$nm");
// apaga a imagens anterior
$sql = mysqli_query($conexao,"SELECT logo FROM config");
$del = mysqli_fetch_array($sql);
$img = $del['logo'];
if($img != ""){
unlink("../boleto/imagens/$img");
}
// insere o nome no banco de dados.
$upload = mysqli_query($conexao,"UPDATE config SET logo = '$nm'");

print "
	<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=configuracoes'>
	<script type=\"text/javascript\">
	alert(\"Imagem enviada.\");
	</script>";


?>
