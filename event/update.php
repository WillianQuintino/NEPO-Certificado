<?php
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
require_once(__ROOT__.'\src\include\functions\upload.php');

$url = SITE_URL.'home.php';
//verifica se foi redirecionado pelo type_event.php e executa a sua função
if($_GET["page"]=='type_event'){
  // inicia conecção com banco de dados
  $link = db_connection();

  $sql = "UPDATE `type_event` SET `id`='".$_POST['id'];
  $sql = $sql."', `color`='".$_POST['color'];
  $sql = $sql."', `color_code`='".$_POST['color_code'];
  $sql = $sql."', `event_name`='".$_POST['event_name'];
  $sql = $sql."' WHERE id='".$_POST['id']."'";

  //Atualiza Informações no Banco de dados
  mysqli_query($link, $sql) or die(mysql_error());

  // Finaliza conecção com banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'event/index.php?page=edit&type=type_event&id='.$_POST['id'];
}

//verifica se foi redirecionado pelo event.php e executa a sua função
if($_GET["page"]=='event'){

  $destino = upload_imagens('/uploads/imagens/frames/',$_POST['image_certificate'], '.jpg');

  $link = db_connection();

  $sql = "UPDATE `event` SET `Id`='".$_POST['id'];
  $sql = $sql."', `name`='".$_POST['name'];
  $sql = $sql."', `caption`='".$_POST['caption'];
  $sql = $sql."', `speaker`='".$_POST['speaker'];
  $sql = $sql."', `id_type_event`='".strtoupper($_POST['color']);
  $sql = $sql."', `start_inscrition`='".$_POST['date_inscrition'];
  $sql = $sql."', `start_event`='".$_POST['date_event'];
  $sql = $sql."', `end_event`='".$_POST['date_event_end'];
  $sql = $sql."', `start_time`='".$_POST['time_start'];
  $sql = $sql."', `end_time`='".$_POST['time_end'];
  if(isset($destino)){
    $sql = $sql."', `image_certificate`='".$destino;
  }
  $sql = $sql."', `organizer`='".serialize($_POST['organizer']);
  $sql = $sql."' WHERE Id='".$_POST['id']."'";

  //Atualiza Informações no Banco de dados
  mysqli_query($link, $sql) or die(mysql_error());

  // Finaliza conecção com banco de dados
  db_close($link);
  //Redireciona para o Evento alterado
  $url = SITE_URL.'event/index.php?page=edit&type=event&id='.$_POST['id'];
}
if($_GET["page"]=='ad_config'){
  $link = db_connection();


  $rs = mysqli_query($link, "SELECT Id, ldap_gruops_name, ldap_gruops_ad_gruop, id_functions, ldap_hierarchy FROM ldap_groups order by ldap_hierarchy ASC") or die(mysql_error());

  while(($row =  mysqli_fetch_assoc($rs))) {
    $i = $row['Id'];
    $sql = "UPDATE `ldap_groups` SET `ldap_gruops_name`='".$_POST['name'.$i]."', `ldap_gruops_ad_gruop`='".$_POST['grupo_ad'.$i]."', `ldap_hierarchy`='".$_POST['hierarquia'.$i]."', `id_functions`='".$_POST['function'.$i]."' WHERE Id='".$i."'";
    mysqli_query($link, $sql) or die(mysql_error());
  }

  db_close($link);
  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=ad_config';
}
//verifica se foi redirecionado pelo functions.php e executa a sua função
if($_GET["page"]=='functions'){

  $link = db_connection();

  $sql = "UPDATE `functions` SET `Id`='".$_POST['id'];
  $sql = $sql."', `functions_name`='".$_POST['functions_name'];
  $sql = $sql."', `admin`='".$_POST['admin'];
  $sql = $sql."', `eventos`='".$_POST['eventos'];
  $sql = $sql."', `coordenacao`='".strtoupper($_POST['coordenacao']);
  $sql = $sql."', `secretaria_de_pesquisa`='".$_POST['secretaria_de_pesquisa'];
  $sql = $sql."', `financeiro`='".$_POST['financeiro'];
  $sql = $sql."', `conselhos`='".$_POST['conselhos'];
  $sql = $sql."', `convenios`='".$_POST['convenios'];
  $sql = $sql."', `processos`='".$_POST['processos'];
  $sql = $sql."', `inventario`='".$_POST['inventario'];
  $sql = $sql."', `ramal`='".$_POST['ramal'];
  $sql = $sql."' WHERE Id='".$_POST['id']."'";

  //Atualiza Informações no Banco de dados
  mysqli_query($link, $sql) or die(mysql_error());

  // Finaliza conecção com banco de dados
  db_close($link);
  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=edit&type=function&id='.$_POST['id'];
}
echo "<script>window.location.href = '".$url."';</script>";
?>
