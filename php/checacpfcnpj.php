<?php
include "../classes/conexao.php";

#Verifica se tem um cpfcnpj para pesquisa
if(isset($_POST['cpfcnpj'])){

    #Recebe o cpfcnpj Postado
    $cpfcnpj = $_POST['cpfcnpj'];

    #Conecta banco de dados
    $sql = mysqli_query($conexao,"SELECT * FROM cliente WHERE cpfcnpj = '$cpfcnpj'") or die(mysqli_error());

    #Se o retorno for maior do que zero, diz que já existe um.
    if(mysqli_num_rows($sql)>0)
        echo json_encode(array('cpfcnpj' => 'Erro! CPF/CNPJ já cadastrado, informe outro.'));
    else
        echo json_encode(array('cpfcnpj' => 0));
}
?>
