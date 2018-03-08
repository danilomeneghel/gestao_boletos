<?php

function get_files_dir($dir, $tipos = null){
      if(file_exists($dir)){
          $dh =  opendir($dir);
          while (false !== ($filename = readdir($dh))) {
              if($filename != '.' && $filename != '..'){
                  if(is_array($tipos)){
                      $extensao = get_extensao_file($filename);
                      if(in_array($extensao, $tipos)){
                          $files[] = $filename;
                      }
                  }
                  else{
                      $files[] = $filename;
                  }
              }
          }
          if(is_array($files)){
              sort($files);
          }
          return $files;
      }
      else{
          return false;
      }
}


function get_extensao_file($nome){
    $verifica = explode('.', $nome);
    return $verifica[count($verifica) - 1];
}



function criar_arquivo($nome, $conteudo, $pasta, $sobrepor = true){
    $caminho = $pasta . $nome;
    if((file_exists($caminho) && $sobrepor) || (!file_exists($caminho))){
        $ponteiro = fopen($caminho, 'w');
        if(!$ponteiro){
            return false;
        }
        fwrite($ponteiro, $conteudo);
        fclose($ponteiro);
        return $caminho;
    }
    else{
        return false;
    }
}


function ler_arquivo($arquivo){
    $ponteiro = fopen($arquivo, 'r');
    if($ponteiro){
        while(!feof($ponteiro)){
            $conteudo[] = fgets($ponteiro);
        }
        fclose($ponteiro);
        return $conteudo;
    }
    else{
        return false;
    }
}


function criar_diretorio($caminho){
    if(!file_exists($caminho)){
        if(mkdir($caminho)){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}
?>