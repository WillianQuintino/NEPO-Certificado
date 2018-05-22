<?php
$disable_security = 1;

//$_POST['fullNamePost'] = "WILLIAN custodio qUINtinO";
//$_POST['usernamePost'] = "TeStE";
//$_POST['passwordPost'] = "teste123";
//$_POST['emailPost'] = "GamERWyll@gmail.com";
//$_POST['institutionPost'] = "unicamp - NEPO";

// Include config in code
include_once 'src/config/db.config';
include_once 'src/config/site.config';

//Include funtions in code
include __ROOT__."/src/include/functions/db.php";
include __ROOT__."/src/include/functions/security.php";
include __ROOT__."/src/include/functions/mail.php";
include __ROOT__."/lib/Ldap-Core/vendor/autoload.php";
include __ROOT__."/src/include/functions/ldap.php";

//remove space
$_POST['usernamePost'] = str_replace(" ", "", $_POST['usernamePost']);
$_POST['emailPost']    = str_replace(" ", "", $_POST['emailPost']);

//start connection with db and return link
$link = db_connection();

//query config ad from db
$ad_host = config_ad($link, 'HOST');
$ad_port = config_ad($link, 'PORT');
$ad_domain = config_ad($link, 'DOMAIN');
$ad_groups = config_ad($link, 'GROUPS');
$ad_user = config_ad($link, 'DEFAULT_USER');
$ad_pass = config_ad($link, 'DEFAULT_PASS');

//close conection db
db_close($link);

//start conection ad
$con = ad_connection($ad_host, $ad_port);


$issetPost = true;

if (!isset($_POST['fullNamePost'])) {
  $issetPost = false;
  echo "Erro:Insira Nickname|";
}
if (!isset($_POST['usernamePost'])) {
  $issetPost = false;
  echo "Erro:Insira Nickname|";
}
if (!isset($_POST['passwordPost'])) {
  $issetPost = false;
  echo "Erro:Insira Password|";
} else {
  if (8 > strlen($_POST['passwordPost'])) {
    $issetPost = false;
    echo "Erro:Senha Curta|";
  }
  if (!isset($_POST['emailPost'])) {
    $issetPost = false;
    echo "Erro:Insira o email|";
  }
  if(check_ad($con, $_POST['usernamePost'], $ad_user, $ad_pass, $ad_groups)){
    $issetPost = false;
    echo "Erro: Usuario AD|";
  }
  if(strpos($_POST['emailPost'], $ad_domain)){
    $issetPost = false;
    echo "Erro: Email AD|";
  }

  if ($issetPost AND isset($_POST['usernamePost'])) {
    $loc = setlocale(LC_CTYPE, 'pt_BR');

    $frase = $_POST['fullNamePost'];
    echo $frase;
    $palavras = str_word_count($frase, 1);
    $count_palavras = str_word_count($frase);
    for($i=0; $i < $count_palavras; $i++){

      $palavra = (strlen($palavras[$i]) > 3) ? (ucwords(strtolower($palavras[$i]))) : (strtolower($palavras[$i]));

      $name .= ($i < $count_palavras) ? $palavra." " : $palavra;

    }
    echo $name;
    $_POST['usernamePost'] = strtolower($_POST['usernamePost']);
    $_POST['emailPost'] = strtolower($_POST['emailPost']);
    $_POST['institutionPost'] = strtoupper($_POST['institutionPost']);
    //encrypt $_POST['usernamePost'] and $_POST['passwordPost']
    $_POST['usernamePost'] = encrypt($_POST['usernamePost']);
    $_POST['emailPost']    = encrypt($_POST['emailPost']);
    $rs = encrypt($_POST['passwordPost']);
    $_POST['passwordPost']="";
    for($i=0;$i<strlen($rs);$i++) $_POST['passwordPost'] .= ord(substr($rs,$i,1))."\f;\n";

    //start connection with db and return link
    $link = db_connection();

    //check $_POST['sendMailExeptionPost'] and atribution $sendMailExeption value 0 = not accept | 1 = accept
    if (isset($_POST['sendMailExeptionPost'])) {
      $sendMailExeption = 1;
    } else {
      $sendMailExeption = 0;
    }

    //Set variable for Conection sql
    $user        = decrypt($_POST['usernamePost']);
    $password    = $_POST['passwordPost'];
    $email       = decrypt($_POST['emailPost']);
    $institution = $_POST['institutionPost'];
    $function    = 0;
    $date_ts     = time();
    $user_active = 0; //value 0 = not active | 1 = active

    if ($link) {
      //make sql code
      $sql = "INSERT INTO `user` (`id_user`, `user`, `password`, `name`, `email`, `institution`, `function`, `date_ts`, `user_active`, `sendMailException`) VALUES (NULL,'" . $user . "','" . $password . "','" . $name . "','" . $email . "','" . $institution . "','" . $function . "','" . $date_ts . "','" .$user_active . "','" .$sendMailExeption. "')";
      echo $sql;
      //query FROM users
      $id_user = mysqli_fetch_array(mysqli_query ($link, "SELECT `id_user` FROM `user` WHERE user='".$user."'"));
      if(isset($id_user['id_user'])){
        if (!mysqli_query($link, $sql)) {
          logoff("index.php?erro=dbconection");
          //echo "Erro:Houve um erro inserindo o registro" . mysqli_error() . "|";
          mysqli_close($link);
        } else { // Register inser with success, send email inserido com sucesso, mandar email

          $id = mysqli_insert_id($link);
          sendVerificationMail($id, $link);
          mysqli_close($link);

          echo "Registro inserido com sucesso|";
          logoff("index.php?erro=registration");
        }
      }else{
        sendVerificationMail($id_user['id_user'], $link);
        logoff("index.php?erro=UserExist");
      }
    } else {
      logoff("index.php?erro=dbconection");
      //echo 'Erro:Não Foi Possivel conectar com db!';
    }
  }
}
?>
