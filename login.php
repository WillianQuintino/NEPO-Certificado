<?php

// Include config in code
include_once 'src/config/db.config';
include_once 'src/config/site.config';

//Include funtions in code
include_once 'src/include/functions/db.php';
include_once 'src/include/functions/security.php';
include_once 'src/include/functions/mail.php';

$issetPost = true;

//start connection with db and return link
$link = db_connection();

echo $_POST['namePost']."</br>";
echo $_POST['usernamePost']."</br>";
echo $_POST['institutionPost']."</br>";
echo $_POST['emailPost']."</br>";
echo $_POST['passwordPost']."</br>";
echo $_POST['sendMailExeption']."</br>";

if (!$link) {
    echo 'Erro:Não Foi Possivel conectar com db!|';
} else {
    if (!isset($_POST['usernamePost'])) {
        $issetPost = false;
        echo "Erro:Insira Nickname|";
    }
    if (!isset($_POST['passwordPost'])) {
        $issetPost = false;
        echo "Erro:Insira Password|";
    }


    $sql = "SELECT `id`, `nickname`, `password`, `key`, `email`, `active` FROM `users` WHERE nickname='" . $_POST['nicknamePost'] . "' OR email='" . $_POST['nicknamePost'] . "'";
    $sql = mysqli_query($link, $sql);
    $rs  = mysqli_fetch_array($sql);
    mysqli_close($link);



    if (isset($_POST['keyPost'])) {
        $key = $_POST['keyPost'];
    } else {
        $key = $rs['key'];
    }

    if ($rs['active'] === '1') {
        if ($issetPost) {

            //encrypt $_POST['nicknamePost'] and $_POST['passwordPost']
            $_POST['nicknamePost'] = encrypt($_POST['nicknamePost'], $key);
            $_POST['passwordPost'] = encrypt($_POST['passwordPost'], $key);
            //teste vars
            if ($rs['nickname'] === decrypt($_POST['nicknamePost'], $key)) {
                $validationNickname = true;
            } else {
                if ($rs['email'] === decrypt($_POST['nicknamePost'], $key)) {
                    $validationNickname = true;
                } else {
                    $validationPassword = false;
                    echo "Erro:nickname Invalido!|";
                }
            }
            if (decrypt($rs['password'], $key) === decrypt($_POST['passwordPost'], $key)) {
                $validationPassword = true;
            } else {
                $validationPassword = false;
                echo "Erro:password Invalido!|";
            }
        }
        if ($validationNickname AND $validationPassword) {
            echo $rs['nickname'];
        }

    }else{
        echo "Erro:Email não validado! Enviaremos novamente um email de validação. Por Favor verifique o email ". $rs['email'] ."|";
        $link = db_connection();
        sendVerificationMail($rs['id'], $link);
        mysqli_close($link);
    }
}

?>
