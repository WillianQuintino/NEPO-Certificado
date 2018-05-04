<?php

$disable_security = 1;

//var teste
//$_POST['usernamePost'] = 'admimnepo1';
//echo $_POST['usernamePost']."<br />";
//$_POST['passwordPost'] = '100%mc.wyll$';
//echo $_POST['passwordPost']."<br />";

// Include config in code
include_once 'src/config/db.config';
include_once 'src/config/site.config';

//Include funtions in code
include __ROOT__."/src/include/functions/db.php";
include __ROOT__."/src/include/functions/security.php";
include __ROOT__."/src/include/functions/mail.php";
include __ROOT__."/lib/Ldap-Core/vendor/autoload.php";
include __ROOT__."/src/include/functions/ldap.php";

$issetPost = true;
$redir     = "index.php";

//get ip user
$ipAddress=IP_USER;

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

//set page redir to login
$url = SITE_URL."home.php";

$_POST['usernamePost'] = strtolower($_POST['usernamePost']);
$_POST['usernamePost'] = str_replace(strtolower($ad_domain), "", $_POST['usernamePost']);

//start conection db
$link = db_connection();

//if conection db false logoff error else esecute function
if (!$link) {
  logoff("index.php?erro=dbconection");
} else {

  //if usernamePost or passwordPost empty set false $issetPost and logoff error
  if (empty($_POST['usernamePost'])) {
    $issetPost = false;
    logoff("index.php?erro=blankuser");
  }elseif(empty($_POST['passwordPost'])) {
    $issetPost = false;
    logoff("index.php?erro=blankpass&user=".$_POST['usernamePost']);
  }elseif (!(check_restricted_users($link, $_POST['usernamePost']))) {
    $issetPost = false;
    add_login_attempts($link, $_POST['usernamePost'], SITE_URL.'index.php', 'Usuario Não Permitido!', IP_USER);
    logoff("index.php?erro=Blacklist");
  }

  //usernamePost or passwordPost empty set true exec function
  if ($issetPost) {
    //if checkAttempts not block execulte function else logoff error and time
    if(checkAttempts($link, $_POST['usernamePost'])['double']){

      //start conection ad
      $con = ad_connection($ad_host, $ad_port);

      //start conection db
      $link = db_connection();

      //ad login teste user
        $con_result = loginad($link, $con, $_POST['usernamePost'], $_POST['passwordPost'], $ad_domain, $ad_groups, $ad_user, $ad_pass, $url);
      //close conection db
      db_close($link);
      if($con_result){
        //start conection db
        $link = db_connection();
        $sql = "SELECT `id_user`, `user`, `password`, `email`, `user_active` FROM `user` WHERE user='" . $_POST['usernamePost'] . "' OR email='" . $_POST['usernamePost'] . "'";
        $sql = mysqli_query($link, $sql);
        $rs  = mysqli_fetch_array($sql);
        //close conection db
        db_close($link);
        if (isset($rs['id_user'])) {
          $_POST['passwordPost'] = encrypt($_POST['passwordPost']);
          $_POST['pass']="";
          $rs['password'] = explode("\f;\n",$rs['password']);
          if(!empty($rs['password'][sizeof($rs['password'])-1])){
            $link = db_connection();
            sendVerificationMail($rs['id_user'], $link);
            $result = mysqli_query($link, "SELECT email FROM user WHERE user='".$rs['id_user']."'");
            $rs = mysqli_fetch_array($result);
            db_close($link);
            logoff('index.php?erro=Activate&email='.$rs['email']);
          }else array_pop($rs['password']);
          for($i=0;$i<sizeof($rs['password']);$i++) $_POST['pass'] .= chr($rs['password'][$i]);
          if($_POST['pass']===$_POST['passwordPost']){
            $link = db_connection();

            remove_login_attempts($link, $ipAddress);
            login($link, $rs['user_active'], $rs['id_user'], 'home.php');
            db_close($link);
          } else {
            $validationPassword = false;
            $link = db_connection();
            //add_login_attempts($link, $_POST['usernamePost'], $redir, 'password Invalido!', $ipAddress);
            db_close($link);
            //logoff("index.php?erro=WhrongPass&user=".$_POST['usernamePost']);
          }
        }else {
          logoff("index.php?erro=WhrongUser");
        }
      }
    }else{
      logoff("index.php?erro=WhrongWait&user=".$_POST['usernamePost']."&tmrest=".checkAttempts($link, $_POST['usernamePost'])['tmrest']);
    }
  }
}
?>
