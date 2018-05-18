<?php
//tipo da pagina para segurança
$typepage = 'eventos';
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
require_once(__ROOT__.'\src\include\functions\upload.php');
$url = SITE_URL.'admin/index.php';
//verifica se foi redirecionado pelo profile.php e executa a sua função
if($_GET["page"]=='model'){
  // inicia conecção com banco de dados
  $link = db_connection();

  $sql = "UPDATE `event_model_certificate` SET `Id`='".$_POST['id'];
  if(isset($_POST['name'])) $sql = $sql."', `name`='".$_POST['name'];
  if(isset($_POST['type'])) $sql = $sql."', `id_user_type_certificate`='".$_POST['type'];
  if(isset($_POST['language'])) $sql = $sql."', `language`='".$_POST['language'];
  if(isset($_POST['html'])) $sql = $sql."', `html`='".html_entity_decode($_POST['html']);
  $sql = $sql."' WHERE Id='".$_POST['id']."'";
  //Atualiza Informações no Banco de dados
  mysqli_query($link, $sql) or die(mysql_error());

  // Finaliza conecção com banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'certificates/index.php?page=model&id='.$_POST['id'].$erro;
}
echo "<script>window.location.href = '".$url."';</script>";
?>
