<?php
include "../classes/conexao.php";

#Verifica se tem um usuario para pesquisa
if(isset($_POST['usuario'])){

    #Recebe o usuario Postado
    $usuario = $_POST['usuario'];

    #Conecta banco de dados
    $sql = mysqli_query($conexao,"SELECT * FROM usuario WHERE usuario = '$usuario'") or die(mysqli_error());

    #Se o retorno for maior do que zero, diz que já existe um.
    if(mysqli_num_rows($sql)>0)
        echo json_encode(array('usuario' => 'Erro! Usuário já cadastrado, informe outro.'));
    else
        echo json_encode(array('usuario' => 0));
}
?>
