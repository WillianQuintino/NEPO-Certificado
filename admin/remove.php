<?php

// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
$url = SITE_URL.'admin/index.php';
//verifica se foi redirecionado pelo profile.php e executa a sua função
if($_GET["page"]=='profile'){

  //inicia Conexão Com O banco de dados
  $link = db_connection();

  //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
  if(isset($_GET["v"])){
    $_GET["v"] = str_replace(" ", "+", $_GET["v"]);
    $id = new_decrypt($_GET["v"], 'casa12');

    $sqldelete = "DELETE FROM `user` WHERE `id_user`='".$id."'";
    mysqli_query($link, $sqldelete) or die(mysql_error());

  }

  //Finaliza Conexão Com O banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=users';
}

//verifica se foi redirecionado pelo ad_config.php e executa a sua função
if($_GET["page"]=='ad_config'){

  //inicia Conexão Com O banco de dados
  $link = db_connection();

  //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
  if(isset($_GET["v"])){
    $_GET["v"] = str_replace(" ", "+", $_GET["v"]);
    $id = new_decrypt($_GET["v"], 'casa12');

    $sqldelete = "DELETE FROM `ldap_groups` WHERE `Id`='".$id."'";
    mysqli_query($link, $sqldelete) or die(mysql_error());
    //encontra o ultimo numero da hierarchy eadiciona na variavel $hierarchy
    $rs = mysqli_query($link, "SELECT Id FROM ldap_groups order by ldap_hierarchy ASC") or die(mysql_error());
    $i = 0;
    while(($row =  mysqli_fetch_assoc($rs))){
      $i++;
      $sqlupdate = "UPDATE `ldap_groups` SET `ldap_hierarchy`='".$i."'  WHERE `Id`='".$row['Id']."'";
      db_close($link);
      $link = db_connection();
      mysqli_query($link, $sqlupdate) or die(mysql_error());
    }
  }

  //Finaliza Conexão Com O banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=ad_config';
}
//verifica se foi redirecionado pelo functions.php e executa a sua função
if($_GET["page"]=='function'){

    //inicia Conexão Com O banco de dados
    $link = db_connection();

    //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
    if(isset($_GET["v"])){
      $_GET["v"] = str_replace(" ", "+", $_GET["v"]);
      $id = new_decrypt($_GET["v"], 'casa12');

      $sqldelete = "DELETE FROM `functions` WHERE `Id`='".$id."'";
      mysqli_query($link, $sqldelete) or die(mysql_error());
    }

    //Finaliza Conexão Com O banco de dados
    db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=functions';
}
echo "<script>window.location.href = '".$url."';</script>";
?>
