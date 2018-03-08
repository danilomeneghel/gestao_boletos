<html>
    <head>
        <meta charset="utf-8">
        <title>Etiquetas</title>
        <style>
            #carta{width:22cm; height:27.94cm; margin: 0 auto;}
            #etiqueta{ width:6.67cm; height:2.54cm ; float:left; margin-left: 0.48cm; margin-bottom: 6px; }
            @media print {
                #carta { 
                    page-break-after: always; 
                }
            }
        </style>
    </head>
    <body>
        <div id="carta">
            <?php
            $i = 0;
            $Pedido = $_GET['pedido'];
            include "../classes/conexao.php";
            $url = mysqli_query($conexao, "SELECT * FROM faturas WHERE pedido='$Pedido'");
           while ($lista = mysqli_fetch_array($url)) {
                $i++;
                $Sql = "SELECT * FROM cliente WHERE id_cliente='" . $lista['id_cliente'] . "'";
                $cli = mysqli_query($conexao, $Sql);
                $dados = mysqli_fetch_array($cli);
            ?>
                <div id="etiqueta">
                    <?= $dados['nome'] ?><br/>
                    <?= $dados['endereco']?><br/>
                    <?= $dados['bairro']?><br/>
                    CEP: <?= $dados['cep']?><br/>
                    <?= $dados['cidade']. ' - '. $dados['uf']?><br/>
                </div>            
            <?php 
            if($i == 30){
                echo '</div>';
                echo '<div id="carta">';
                $i=0;
            } 
        } ?>
        </div>
    </body>

</html>