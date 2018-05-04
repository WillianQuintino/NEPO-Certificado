<?php
  // Include config in code
  include_once 'src/config/db.config';
  include_once 'src/config/site.config';

  //Include funtions in code
  include_once 'src/functions/db.php';
  include_once 'src/functions/security.php';

  //Data coming by url
  $id = $_GET['id'];
  $emailMd5 = $_GET['email'];
  $key = $_GET['uid'];
  $dataMd5 = $_GET['key'];
  echo "key: ";
  echo $dataMd5;

  $link = db_connection();
  
    if(!$link){
      echo 'Erro:Não Foi Possivel conectar com db!|';
    }else{
      //Search the data base
      $sql = "SELECT `email`, `active`, `key`, `date_ts` FROM `users` WHERE id='".$id."'";
      if( !mysqli_query( $link, $sql)  ) {
          echo "Erro:Não Foi Possivel conectar tabela do db!".mysqli_error()."|";
          mysqli_close($link);
      } else {
      $sql = mysqli_query( $link, $sql );
      $rs = mysqli_fetch_array( $sql );
      //compare the data what caught base, with the data coming by url
      $valido = true;

      if( decrypt($emailMd5, $key) !== $rs['email'] )
          $valido = false;

      if( $key !== $rs['key'] )
          $valido = false;

      if( decrypt($dataMd5, $key) !== $rs['date_ts'])
          $valido = false;
          echo "</br>key db: ";
          echo $rs['date_ts'];
          echo "</br>key decrypt: ";
          echo decrypt($dataMd5, $key);


      // the data is correct, time to activate the registration
      if( $valido === true ) {
          $sql = "update users set active='1' where id='$id'";
          mysqli_query($link, $sql);
          echo "Cadastro ativado com sucesso!";
      } else {
          echo "Informações inválidas";
      }
      mysqli_close($link);
    }
  }

?>
