<?php

  //Função para Coneção no db
  function db_connection(){
      //Recebe variaveis derinidas em ../config/db-config.php.
      $host       = DB_HOST;
      $password   = DB_PASSWORD;
      $user       = DB_USER;
      $db         = DB_NAME;

      //efetua conecção no db e retona o acesso para variavel $link
      error_reporting(E_ERROR | E_PARSE);
      $link = mysqli_connect($host, $user, $password, $db);

      return $link;
  }
  //Fecha conexão com banco de dados
  function db_close($link){
    $check = mysqli_close ($link);

    if($check === FALSE){
      echo '<script>alert("Erro ao Fechar DB");</script>';
    }

    return $check;
  }
  //Função para listar tabela institution para datalist
  function datalist_institution(){
    //Inicia conexão com o db
    $link = db_connection();

    //busca
    $rs = mysqli_query($link, "SELECT institution FROM institution order by institution asc") or die(mysql_error());

      while( $row = mysqli_fetch_array($rs))
      {
        echo "<option>".utf8_encode($row['institution']). "</option>";
      }
      db_close($link);
  }
?>
