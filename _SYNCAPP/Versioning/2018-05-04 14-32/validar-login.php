<?php

// Include config in code
include_once 'src/config/db.config';
include_once 'src/config/site.config';

//Include funtions in code
include_once 'src/include/functions/db.php';
include_once 'src/include/functions/security.php';
include_once 'src/include/functions/mail.php';

$issetPost = true;
$redir     = "index.php";
//start connection with db and return link
$link = db_connection();
$ipAddress=$_SERVER['REMOTE_ADDR'];

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

    $sql = "SELECT `id_user`, `user`, `password`, `email`, `user_active` FROM `user` WHERE user='" . $_POST['usernamePost'] . "' OR email='" . $_POST['usernamePost'] . "'";
    $sql = mysqli_query($link, $sql);
    $rs  = mysqli_fetch_array($sql);
    mysqli_close($link);

    if ($issetPost) {
            if (isset($rs['id_user'])) {
                /*if ($rs['password'] === $_POST['passwordPost']) {
                  $link = db_connection();

                  remove_login_attempts($link, $ipAddress);
                  login($link, $rs['user_active'], $rs['id_user'], 'home.php');
                  mysqli_close($link);

                }else{
                    $validationPassword = false;
                    echo "Erro:password Invalido!|";
                    $link = db_connection();
                    add_login_attempts($link, $_POST['usernamePost'], $redir, 'password Invalido!', $ipAddress);
                    mysqli_close($link);
                    //logoff("index.php?user=".$_POST['usernamePost']."&erro=invalidPass");
                }*/
                $_POST['passwordPost'] = encrypt($_POST['passwordPost']);
                $_POST['pass']="";
                $rs['password'] = explode("\f;\n",$rs['password']);
                if(!empty($rs['password'][sizeof($rs['password'])-1])) redirect("./?reason=Activate");
                else array_pop($rs['password']);
                for($i=0;$i<sizeof($rs['password']);$i++) $_POST['pass'] .= chr($rs['password'][$i]);
                if($_POST['pass']===$_POST['passwordPost']) {
                    $link = db_connection();

                    remove_login_attempts($link, $ipAddress);
                    login($link, $rs['user_active'], $rs['id_user'], 'home.php');
                    mysqli_close($link);
                } else {
                    $validationPassword = false;
                    echo "Erro:password Invalido!|";
                    $link = db_connection();
                    add_login_attempts($link, $_POST['usernamePost'], $redir, 'password Invalido!', $ipAddress);
                    mysqli_close($link);
                    //logoff("index.php?user=".$_POST['usernamePost']."&erro=invalidPass");
                }
            }else{
                $validationNickname = false;
                echo "Erro:Usuario ou Email Invalido!|";
                $link = db_connection();
                add_login_attempts($link, $_POST['usernamePost'], $redir, 'Usuario ou Email Invalido!', $ipAddress);
                mysqli_close($link);
                //logoff("index.php?erro=invaliduser");
            }
        }


}

?>
