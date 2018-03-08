<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors','On');

require_once('config.php');

if(isset($_POST['editar'])){
	
	$conteudo = $_POST['conteudo'];

	$verifica = criar_arquivo($_GET['arquivo'], $conteudo, TEMPLATES, true);
	
	if($verifica){
		$msg = "Editado com sucesso";	
	}else{
		$msg = "Erro ao editar";
	}
	

}

if(isset($_GET['sair'])){
	unset($_SESSION['log']);
	unset($_SESSION['senha']);	
	header("Location:index.php");
}



if(!isset($_SESSION['senha']) && !isset($_SESSION['log'])){
		echo "Você não tem permisao para acessar diretamente";
		exit;
}

$arquivo = $_GET['arquivo'];

/* if(file_exists(TEMPLATES . $arquivo)){ 
$conteudo = ler_arquivo(TEMPLATES . $arquivo);
 }else{
echo 'O arquivo nao <strong>'.$arquivo.'</strong> existe';	
}  */
$conteudo = ler_arquivo(TEMPLATES . $arquivo);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>editorhtml</title>
</head>

<body>

<form action="editar.php?arquivo=<?php echo $arquivo ?>" method="post" enctype="multipart/form-data">
<label><strong>Arquivo sendo editado: </strong><?php echo $arquivo ?></label><br/>
<textarea name="conteudo" style="width:100%; height:500px;">

<?php 


foreach($conteudo as $linha){
	echo $linha;	
}
?>


</textarea><br/>
<input name="editar" type="submit" value="editar">
</form>

<a href="?sair=sair">Sair</a>

</body>
</html>