<?php
//tipo da pagina para segurança
$typepage = 'admin';
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
require_once(__ROOT__.'\src\include\functions\upload.php');
$url = SITE_URL.'admin/index.php';
//verifica se foi redirecionado pelo profile.php e executa a sua função
if($_GET["page"]=='profile'){
  // inicia conecção com banco de dados
  $link = db_connection();

  if ($_POST['sendMailException'] === "true"){
    $_POST['sendMailException'] = '1';
  }else{
    $_POST['sendMailException'] = '0';
  }
  if ($_POST['organizer'] === "true"){
    $_POST['organizer'] = '1';
  }else{
    $_POST['organizer'] = '0';
  }

  verified_institution($link, strtoupper($_POST['institution']));

  $destino = upload_imagens('/uploads/imagens/frames/',$_POST['signature'],".png");
  echo $destino."<br />";

  $sql = "UPDATE `user` SET `id_user`='".$_POST['id'];
  $sql = $sql."', `user`='".$_POST['user'];
  $sql = $sql."', `name`='".$_POST['name'];
  $sql = $sql."', `email`='".$_POST['email'];
  $sql = $sql."', `institution`='".strtoupper($_POST['institution']);
  $sql = $sql."', `function`='".$_POST['function'];
  $sql = $sql."', `extra_information`='".$_POST['extra_information'];
  $sql = $sql."', `sendMailException`='".$_POST['sendMailException'];
  $sql = $sql."', `organizer`='".$_POST['organizer'];
  if(isset($destino)){
    $sql =$sql."', `signature`='".$destino;
  }
  if($_POST['ramal'] == 0 OR empty($_POST['ramal'])){
    $sql = $sql."', `ramal`= Null";
  }else{
    $sql = $sql."', `ramal`='".$_POST['ramal']."'";
  }
  $sql = $sql." WHERE id_user='".$_POST['id']."'";
  //Atualiza Informações no Banco de dados
  mysqli_query($link, $sql) or die(mysql_error());

  // Finaliza conecção com banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=edit&type=profile&id='.$_POST['id'].$erro;
}

//verifica se foi redirecionado pelo config.php e executa a sua função
if($_GET["page"]=='config'){

  $link = db_connection();

  //Pega o nome das configurações/post
  $config_name = explode("|", $_POST['config_name']);

  for($i=0; $i < (count($config_name)-1); $i++){

    $sql = "UPDATE `config_site` SET `config_value`='".$_POST[$config_name[$i]]."' WHERE config_name='".$config_name[$i]."'";
    //Atualiza Informações no Banco de dados
    mysqli_query($link, $sql) or die(mysql_error());
  }

  // Finaliza conecção com banco de dados
  db_close($link);
  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=config';
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
