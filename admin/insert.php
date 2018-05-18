<?php
//tipo da pagina para segurança
$typepage = 'admin';

// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');

$url = SITE_URL.'admin/index.php';
//verifica se foi redirecionado pelo ad_config.php e executa a sua função
if($_GET["page"]=='ad_config'){
  //inicia Conexão Com O banco de dados
  $link = db_connection();

  //encontra o ultimo numero da hierarchy eadiciona na variavel $hierarchy
  $rs = mysqli_query($link, "SELECT ldap_hierarchy FROM ldap_groups order by ldap_hierarchy ASC") or die(mysql_error());
  while(($row =  mysqli_fetch_assoc($rs))) {
    $hierarchy = $row['ldap_hierarchy'];
  }

  //Adiciona mais 1 no $hierarchy
  $hierarchy = $hierarchy+1;

  //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
  if(isset($_POST['name']) AND isset($_POST['ad_gruop']) AND isset($_POST['function'])){
    $sql = "INSERT INTO `ldap_groups`(`Id`, `ldap_gruops_name`, `ldap_gruops_ad_gruop`, `id_functions`, `ldap_hierarchy`) VALUES (Null,'".$_POST['name']."','".$_POST['ad_gruop']."','".$_POST['function']."','".$hierarchy."')";
    mysqli_query($link, $sql) or die(mysql_error());
  }
  //Finaliza Conexão Com O banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=ad_config';
}elseif($_GET["page"]=='functions'){
  //inicia Conexão Com O banco de dados
  $link = db_connection();

  //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
  if(isset($_POST['functions_name']) AND isset($_POST['admin']) AND isset($_POST['eventos']) AND isset($_POST['coordenacao']) AND isset($_POST['secretaria_de_pesquisa']) AND isset($_POST['financeiro']) AND isset($_POST['conselhos']) AND isset($_POST['convenios']) AND isset($_POST['processos']) AND isset($_POST['inventario']) AND isset($_POST['ramal'])){
    $sql = "INSERT INTO `functions`(`Id`, `functions_name`, `admin`, `eventos`, `coordenacao`, `secretaria_de_pesquisa`, `financeiro`, `conselhos`, `convenios`, `processos`, `inventario`, `ramal`) VALUES (Null,'".$_POST['functions_name']."','".$_POST['admin']."','".$_POST['eventos']."','".$_POST['coordenacao']."','".$_POST['secretaria_de_pesquisa']."','".$_POST['financeiro']."','".$_POST['conselhos']."','".$_POST['convenios']."','".$_POST['processos']."','".$_POST['inventario']."','".$_POST['ramal']."')";
    mysqli_query($link, $sql) or die(mysql_error());
  }
  //Finaliza Conexão Com O banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'admin/index.php?page=functions';
}
echo "<script>window.location.href = '".$url."';</script>";
?>
