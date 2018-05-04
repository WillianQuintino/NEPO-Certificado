<?php
// URL: http://www.guj.com.br/t/sistema-de-upload-de-imagem/322104/2
function upload_imagens( $folder, $olddestino, $extensao_valida){

  $arquivo_tmp = $_FILES['image']['tmp_name'];
  $nome = $_FILES['image']['name'];

  // Pega a extensao
  $extensao = strrchr($nome, '.');

  // Converte a extensao para mimusculo
  $extensao = strtolower($extensao);

  // Somente imagens, .jpg;.jpeg;.gif;.png
  // Aqui eu enfilero as extesões permitidas e separo por ';'
  // Isso server apenas para eu poder pesquisar dentro desta String
  //if(strstr('.jpg;.jpeg;.gif;.png', $extensao)){
  if(strstr($extensao_valida, $extensao)){

    // Cria um nome único para esta imagem
    // Evita que duplique as imagens no servidor.
    $novoNome = md5(microtime()) . $extensao;

    if($olddestino == ""){
      // Concatenaa pasta com o nome
      $destino = $folder . $novoNome;
      //echo $destino;
    } else {
      $destino = $olddestino;
    }
    $file = str_replace("\\new_site", "", $_SERVER['DOCUMENT_ROOT']).$destino;
    // tenta mover o arquivo para o destino
    if( @move_uploaded_file( $arquivo_tmp, $file ))
    {
      return $destino;
      //echo "Arquivo salvo com sucesso em : <strong>" . $destino . "</strong><br />";
      //echo "<img src="" . $destino . "" />";
    }
    else{
      //echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />";
    }
  }
  else{
    //echo "Você poderá enviar apenas arquivos <br />";
  }
}
?>
