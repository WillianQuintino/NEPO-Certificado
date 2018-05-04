<?php
  // Include config in code
  include_once 'src/config/db.config';

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
      $sql = "SELECT `email`, `user_active`, `key`, `date_ts`, `function` FROM `user` WHERE id_user='".$id."'";
      if( !mysqli_query( $link, $sql)  ) {
          echo "Erro:Não Foi Possivel conectar tabela do db!".mysqli_error()."|";
          mysqli_close($link);
      } else {
      $sql = mysqli_query( $link, $sql );
      $rs = mysqli_fetch_array( $sql );
      //compare the data what caught base, with the data coming by url
      $valido = true;
      echo $rs['function'];
      if( md5($emailMd5) !== $rs['email'] )
          $valido = false;

      if( $key !== $rs['key'] )
          $valido = false;

      if( md5($dataMd5) !== $rs['date_ts'])
          $valido = false;
          echo "</br>key db: ";
          echo $rs['date_ts'];
          echo "</br>key decrypt: ";
          echo decrypt($dataMd5);


      // the data is correct, time to activate the registration
      if( $valido === true ) {
          $sql = "update users set active='1' where id='$id'";
          mysqli_query($link, $sql);
          echo "Cadastro ativado com sucesso!";
      } else {
          echo "Informações inválidas";
      }

      // verifica se a função esta em 0 e atribui função aluno
      if ($rs['function'] === "0"){
        $sql = "update users set function='2' where id='$id'";
        mysqli_query($link, $sql);
        echo "inserido Função aluno";
      }
      }
      mysqli_close($link);
    }
  }

?>
