
<?php
include "classes/conexao.php";

	 if(isset($_POST['xml'])){

     $objXml = simplexml_load_string($_POST['xml']);
     
     $nome = $objXml->cliente->cliente;
     
     $chave = $objXml->cobranca->chave;
     
     $retorno = $objXml->cobranca->retorno;
     
     $numeroPedido = $objXml->cobranca->documento;
     
     $valorPago = $objXml->cobranca->valorPago;
     
     $pag = $objXml->cobranca->pag;
     
     /**
     * Capturar dados dos itens
     */
	 $data = date('Y-m-d');
	 
	 
     $produtos = array($objXml);
     foreach($objXml->cobranca as $item){
	    $retorno 	= $item->retorno;		 
     	$chave 		= $item->chave;
		$valorP 	= $item->valorPago;
		
		$valorRec = number_format($valorP / 100, 2, '.', '');
		
	    $status 	= $item->status;
		  
			
		 if($status == "p"){
		 // $total = $item->total;
		  $sql = mysqli_query($conexao,"UPDATE faturas SET dbaixa = '$data', situacao='B', valor_recebido='$valorRec' WHERE chaveGerencia = '$chave'")or die(mysqli_error());
					
				if($sql == 1){
			echo 'ok. Baixado';
					}else{
			echo 'erro ao baixar';
					}
			
			} 


	// print_r($chave);

	 
    }

}


?>

<form action="" method="post" enctype="multipart/form-data">
<textarea name="xml" cols="80" rows="20"></textarea><br/>

<input name="asdf" type="submit" value="Submit">

</form>