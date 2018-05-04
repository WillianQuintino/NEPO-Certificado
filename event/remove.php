<?php
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
$url = SITE_URL.'home.php';
//verifica se foi redirecionado pelo functions.php e executa a sua função
if($_GET["page"]=='type_event'){

    //inicia Conexão Com O banco de dados
    $link = db_connection();

    //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
    if(isset($_GET["v"])){
      $_GET["v"] = str_replace(" ", "+", $_GET["v"]);
      $id = new_decrypt($_GET["v"], 'casa12');

      $sqldelete = "DELETE FROM `type_event` WHERE `id`='".$id."'";
      mysqli_query($link, $sqldelete) or die(mysql_error());
    }

    //Finaliza Conexão Com O banco de dados
    db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'event/index.php?page=type_event';
}
if($_GET["page"]=='event'){

    //inicia Conexão Com O banco de dados
    $link = db_connection();

    //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
    if(isset($_GET["v"])){
      $_GET["v"] = str_replace(" ", "+", $_GET["v"]);
      $id = new_decrypt($_GET["v"], 'casa12');

      $sqldelete = "DELETE FROM `event` WHERE `id`='".$id."'";
      mysqli_query($link, $sqldelete) or die(mysql_error());
    }

    //Finaliza Conexão Com O banco de dados
    db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'event/index.php?page=event';
}
if($_GET["page"]=='registration'){

    //inicia Conexão Com O banco de dados
    $link = db_connection();

    //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
    if(isset($_GET["v"])){
      $_GET["v"] = str_replace(" ", "+", $_GET["v"]);
      $id = new_decrypt($_GET["v"], 'casa12');

      $sqldelete = "DELETE FROM `registration` WHERE `id_user`='".$_SESSION['id']."' AND `id_event`='".$id."'";
      mysqli_query($link, $sqldelete) or die(mysql_error());
    }

    //Finaliza Conexão Com O banco de dados
    db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'event/index.php?page=registration';
}
echo "<script>window.location.href = '".$url."';</script>";
?>
