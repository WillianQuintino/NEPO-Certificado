<?php
// Include config in code
include_once 'src/config/db.config';
include_once 'src/config/site.config';

//Include funtions in code
include_once 'src/include/functions/db.php';
include_once 'src/include/functions/security.php';
include_once 'src/include/functions/mail.php';

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

  if ($issetPost AND isset($_POST['usernamePost'])) {


    //encrypt $_POST['usernamePost'] and $_POST['passwordPost']
    $_POST['usernamePost'] = encrypt(str_replace(" ", "", $_POST['usernamePost']));
    $_POST['passwordPost'] = encrypt($_POST['passwordPost']);
    $_POST['emailPost']    = encrypt(str_replace(" ", "", $_POST['emailPost']));

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
    $name        = $_POST['namePost'];
    $email       = decrypt($_POST['emailPost']);
    $institution = $_POST['institutionPost'];
    $function    = 0;
    $date_ts     = time();
    $user_active = 0; //value 0 = not active | 1 = active

    if ($link) {
      //make sql code
      $sql = "INSERT INTO `users`(`id_user`, `user`, `password`, `name`, `email`, `institution`, `function` ,`date_ts`, `user_active` , `sendMailExeptionPost`) VALUES(NULL,'" . $user . "','" . $password . "','" . $name . "','" . $email . "','" . $institution . "','" . $function . "','" . $date_ts . "','" .$user_active . "','" .$sendMailExeption. "')";

      //query FROM users
      if (!mysqli_query($link, $sql)) {
        echo "Erro:Houve um erro inserindo o registro" . mysqli_error() . "|";
        mysqli_close($link);
      } else { // Register inser with success, send email inserido com sucesso, mandar email

        $id = mysqli_insert_id($link);
        sendVerificationMail($id, $link);
        mysqli_close($link);

        echo "Registro inserido com sucesso|";
      }
    } else {
      echo 'Erro:Não Foi Possivel conectar com db!';
    }
  }
}
?>
