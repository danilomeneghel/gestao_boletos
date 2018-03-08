<?php 
session_start();
ob_start();
/* error_reporting(E_ALL);
ini_set('display_errors','On'); */


if(isset($_GET['log'])){
$logs = $_GET['log'];
$per = $_GET['permissao'];

$user = 'griffelson';
$senha = 'cb102030!@#';

if($logs == $user){
	$_SESSION['log'] = $user;
}else{
	unlink($_SESSION['log']);
}
if($per == $senha){
	$_SESSION['senha'] == $per;	
}else{
	unlink($_SESSION['senha']);
}

}
if(!isset($_SESSION['senha']) && !isset($_SESSION['log'])){
		echo utf8_decode("Você não tem permisao para acessar diretamente");
		exit;
}

require_once('config.php');

$arquivos = get_files_dir(TEMPLATES, array('php', 'css', 'html','js'));

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>tinymce by griffsistemas</title>
</head>

<body>

<ul>
<?php  
if(count($arquivos) > 0){ 
	foreach($arquivos as $arquivo){
		echo '<li><a href="editar.php?arquivo='.$arquivo.'">'.$arquivo.'</a></li>';
	}

}else{
	echo 'Nenhum arquivo encontrado.';	
}?>
</ul>


</body>
</html>