<?php
include "../classes/conexao.php";

#Verifica se tem um email para pesquisa
if(isset($_POST['email'])){

    #Recebe o email Postado
    $email = $_POST['email'];

    #Conecta banco de dados
    $sql = mysqli_query($conexao,"SELECT * FROM cliente WHERE email = '$email'") or die(mysqli_error());

    #Se o retorno for maior do que zero, diz que já existe um.
    if(mysqli_num_rows($sql)>0)
        echo json_encode(array('email' => 'Erro! E-mail já cadastrado, informe outro.'));
    else
        echo json_encode(array('email' => 0));
}
?>
