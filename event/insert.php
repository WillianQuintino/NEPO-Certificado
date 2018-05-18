<?php
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
require_once(__ROOT__.'\src\include\functions\upload.php');

$url = SITE_URL.'home.php';
//verifica se foi redirecionado pelo create.php e executa a sua função
if($_GET["page"]=='event'){


  $destino = upload_imagens('/uploads/imagens/frames/','','.jpg');

  //inicia Conexão Com O banco de dados
  $link = db_connection();

  //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
  if(isset($_POST['name']) AND isset($_POST['speaker']) AND isset($_POST['color']) AND isset($_POST['organizer']) AND isset($_POST['date_inscrition']) AND isset($_POST['date_event']) AND isset($_POST['time_start']) AND isset($_POST['time_end']) AND isset($destino)){

    $sql = "INSERT INTO `event`(`Id`, `name`, `caption`, `speaker`, `id_type_event`, `organizer`, `start_inscrition`, `start_event`, `end_event`, `start_time`, `end_time`, `image_certificate`) VALUES (Null,'".$_POST['name']."','".$_POST['caption']."','".$_POST['speaker']."','".$_POST['color']."','".serialize($_POST['organizer'])."','".$_POST['date_inscrition']."','".$_POST['date_event']."','".$_POST['date_event_end']."','".$_POST['time_start']."','".$_POST['time_end']."','".$destino."')";
    $rs = mysqli_query($link, $sql) or die(mysql_error());
  }else{
    $erro .= '&db=empty';
  }

  //print_r(unserialize(mysqli_fetch_array($rs)[0]));

  //Finaliza Conexão Com O banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'event/index.php?page=create';
  if(isset($erro)){
    $url = $url.$erro;
  }
}elseif($_GET["page"]=='type_event'){
  //inicia Conexão Com O banco de dados
  $link = db_connection();

  //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
  if(isset($_POST['color']) AND isset($_POST['color_code']) AND isset($_POST['event_name'])){
    $sql = "INSERT INTO `type_event`(`Id`, `color`, `color_code`, `event_name`) VALUES (Null,'".$_POST['color']."','".$_POST['color_code']."','".$_POST['event_name']."')";
    mysqli_query($link, $sql) or die(mysql_error());
  }
  //Finaliza Conexão Com O banco de dados
  db_close($link);

  //Redireciona para o Usuário alterado
  $url = SITE_URL.'event/index.php?page=type_event';
}elseif($_GET["page"]=='registration'){
  $_GET["v"] = str_replace(" ", "+", $_GET["v"]);
  $id = new_decrypt($_GET["v"], 'casa12');

  //inicia Conexão Com O banco de dados
  $link = db_connection();

  //verifica se nao esta vazio as variaveis se não ele nao executa o mysql
  if(isset($_GET['v'])){
    $sql = "INSERT INTO `registration`(`Id`, `id_event`, `id_user`) VALUES (Null,'".$id."','".$_SESSION['id']."')";
    mysqli_query($link, $sql) or die(mysql_error());
  }
  //Finaliza Conexão Com O banco de dados
  db_close($link);
  $url = SITE_URL.'event/index.php?page=registration';
}elseif($_GET["page"]=='present'){
  for ($i=1; $i <= $_POST['user']['count'] ; $i++) {
    for ($j=0; $j < $_POST['user'][$i]['date']['count']; $j++) {
      if (isset($_POST['user'][$i]['date'][$j]['check'])) {
        //$sql .= "INSERT INTO `user_presence` ( `id_event`, `id_user`, `date`, `id_type_certificate`) VALUES  ('".$_POST['id_event']."', '".$_POST['user'][$i]['value']."', '".$_POST['user'][$i]['date'][$j]['value']."', '".$_POST['user'][$i]['type']."') ON DUPLICATE KEY UPDATE id_type_certificate='".$_POST['user'][$i]['type']."';";
        //$sql .= "INSERT INTO `user_presence` ( `id_event`, `id_user`, `date`, `id_type_certificate`) SELECT * FROM  (SELECT '".$_POST['id_event']."', '".$_POST['user'][$i]['value']."', '".$_POST['user'][$i]['date'][$j]['value']."', '".$_POST['user'][$i]['type']."') AS tmp WHERE NOT EXISTS (SELECT * FROM user_presence WHERE id_event = '".$_POST['id_event']."' AND id_user = '".$_POST['user'][$i]['value']."' AND date = '".$_POST['user'][$i]['date'][$j]['value']."') LIMIT 1;";
        $sql .= "IF (SELECT 1=1 FROM user_presence WHERE id_event = '".$_POST['id_event']."' AND id_user = '".$_POST['user'][$i]['value']."' AND  date = '".$_POST['user'][$i]['date'][$j]['value']."') THEN BEGIN UPDATE `user_presence` SET id_type_certificate = '".$_POST['user'][$i]['type']."' WHERE id_event = '".$_POST['id_event']."' AND id_user = '".$_POST['user'][$i]['value']."' AND  date = '".$_POST['user'][$i]['date'][$j]['value']."'; END; ELSE BEGIN INSERT INTO `user_presence` ( `id_event`, `id_user`, `date`, `id_type_certificate`) VALUES  ('".$_POST['id_event']."', '".$_POST['user'][$i]['value']."', '".$_POST['user'][$i]['date'][$j]['value']."', '".$_POST['user'][$i]['type']."'); END; END IF;";
      }else{
        $sql .= "DELETE FROM user_presence WHERE id_event = '".$_POST['id_event']."' AND id_user = '".$_POST['user'][$i]['value']."' AND  date = '".$_POST['user'][$i]['date'][$j]['value']."';";
      }
    }
  }
    //inicia Conexão Com O banco de dados
    $link = db_connection();

    mysqli_multi_query($link, $sql) or die(mysql_error());

    //Finaliza Conexão Com O banco de dados
    db_close($link);

  $url = SITE_URL.'event/index.php?page=add&form=present&id='.$_POST['id_event'];
}
echo "<script>window.location.href = '".$url."';</script>";
?>
