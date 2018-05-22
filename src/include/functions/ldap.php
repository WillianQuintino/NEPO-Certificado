<?php
// Import the class into current namespace
use Dreamscapes\Ldap\Core\Ldap;
//function start conection ad
function ad_connection($ldaphost, $ldapport){
  try {
    $con = new Ldap($ldaphost.':'.$ldapport);
    return $con;
  }
  catch (Exception $e) {
    //echo $e->getMessage();
    exit;
    logoff("index.php?erro=LDAPerror");
  }
  return false;
}

function ad_function($link, $ad_result){
  $result = mysqli_query($link, "SELECT * FROM ldap_groups ORDER BY ldap_hierarchy");
  $i = 0;
  while($rs = mysqli_fetch_array($result)) {
    $ldap_gruops['ldap_gruops_ad_gruop'][$i] = $rs['ldap_gruops_ad_gruop'];
    $ldap_gruops['id_functions'][$i] = $rs['id_functions'];
    $ldap_gruops['count'] =  $i;
    $i++;
  }
  for ($i=0; $i < $ldap_gruops['count']; $i++) {
    for($j=0; $j < $ad_result['count']; $j++){
      if($ad_result[$j] == $ldap_gruops['ldap_gruops_ad_gruop'][$i]){
        $function = $ldap_gruops['id_functions'][$i];
        break;
      }
    }
  }
  return $function;
}
//function login ad conection
function loginad($link, $con, $username, $password, $domain, $grupo, $ad_user, $ad_pass, $url){
  try {
    //login ad conection
    @$con->bind($username.$domain, $password);

    $res = $con->search($grupo,'samaccountname='.$username,array('memberof','samaccountname','displayname','mail'));
    $var = $res->getEntries();
    if($res->countEntries() == 1 AND check_restricted_users($link, $var[0]['samaccountname'][0])){
      $result = mysqli_query($link, "SELECT id_user, user_active, date_ts, name, email, function FROM user WHERE user='".$var[0]['samaccountname'][0]."'");
      $rs = mysqli_fetch_array($result);
      if(isset($rs["id_user"])){
        $date = date("Y-m-d H:i:s");
        if(empty($var[0]['mail'][0])){
          $email = $var[0]['samaccountname'][0].$domain;
        }else{
          $email = $var[0]['mail'][0];
        }
        $sql = "UPDATE user SET ";
        if(!($var[0]['displayname'][0] === $rs["name"])){
          $sql .= "name = '".$var[0]['displayname'][0]."', ";
        }
        if(!($email === $rs["email"])){
          $sql .= "email = '".$email."', ";
        }
        if(!(ad_function($link, $var[0]['memberof']) == $rs["function"])){
          $sql .= "function = ".ad_function($link, $var[0]['memberof']).", ";
        }
        if($rs["date_ts"] == "0000-00-00 00:00:00"){
          $sql .= "date_ts = '".$date."', ";
        }
        $sql .= "user_active = 1 WHERE user='".$var[0]['samaccountname'][0]."'";
        mysqli_query($link, $sql);
        $erro_con = true;
      }else{
        $date = date("Y-m-d H:i:s");
        if(empty($var[0]['mail'][0])){
          $email = $var[0]['samaccountname'][0].$domain;
        }else{
          $email = $var[0]['mail'][0];
        }
        mysqli_query($link, "INSERT INTO user  VALUES (NULL, '".$var[0]['samaccountname'][0]."', NULL, '".$var[0]['displayname'][0]."', '".$email."', 'UNICAMP - NEPO', ".ad_function($link, $var[0]['memberof']).", NULL, '".$date."', NULL, 1, 0, '".md5(uniqid(""))."', NULL, NULL)");
        $erro_con = true;
      }
      $result = mysqli_query($link, "SELECT id_user, user_active FROM user WHERE user='".$var[0]['samaccountname'][0]."'");
      $rs = mysqli_fetch_array($result);
      remove_login_attempts($link, IP_USER);
      login($link, $rs["user_active"], $rs["id_user"], $url);
    }else {
      add_login_attempts($link, $username, SITE_URL.'index.php', 'Usuario Não Permitido!', IP_USER);
      logoff("index.php?erro=Blacklist");
    }
  }
  catch (Exception $e) {
    //echo $e->getMessage();
    try {
      @$con->bind($ad_user, $ad_pass);
      $res = $con->search($grupo,'samaccountname='.$username,array('memberof','samaccountname','displayname','mail'));
      $var = $res->getEntries();
      if($res->countEntries() == 1){
        $result = mysqli_query($link, "SELECT id_user, user_active, date_ts, name, email, function FROM user WHERE user='".$var[0]['samaccountname'][0]."'");
        $rs = mysqli_fetch_array($result);
        if(isset($rs["id_user"])){
          $date = date("Y-m-d H:i:s");
          if(empty($var[0]['mail'][0])){
            $email = $var[0]['samaccountname'][0].$domain;
          }else{
            $email = $var[0]['mail'][0];
          }
          $sql = "UPDATE user SET ";
          if(!($var[0]['displayname'][0] === $rs["name"])){
            $sql .= "name = '".$var[0]['displayname'][0]."', ";
          }
          if(!($email === $rs["email"])){
            $sql .= "email = '".$email."', ";
          }
          if(!(ad_function($link, $var[0]['memberof']) == $rs["function"])){
            $sql .= "function = ".ad_function($link, $var[0]['memberof']).", ";
          }
          if($rs["date_ts"] == "0000-00-00 00:00:00"){
            $sql .= "date_ts = '".$date."', ";
          }
          $sql .= "user_active = 1 WHERE user='".$var[0]['samaccountname'][0]."'";
          mysqli_query($link, $sql);
          $erro_con = true;
        }else{
          $date = date("Y-m-d H:i:s");
          if(empty($var[0]['mail'][0])){
            $email = $var[0]['samaccountname'][0].$domain;
          }else{
            $email = $var[0]['mail'][0];
          }
          mysqli_query($link, "INSERT INTO user  VALUES (NULL, '".$var[0]['samaccountname'][0]."', NULL, '".$var[0]['displayname'][0]."', '".$email."', 'UNICAMP - NEPO', ".ad_function($link, $var[0]['memberof']).", NULL, '".$date."', NULL, 1, 0, '".md5(uniqid(""))."', NULL, NULL)");
          $erro_con = true;
        }
        add_login_attempts($link, $username, SITE_URL.'index.php', 'password Invalido!', IP_USER);
        logoff("index.php?erro=ADWhrongPass&user=".$var[0]['samaccountname'][0]);
      }elseif($res->countEntries() > 1 ){
        $erro_con = true;
        logoff("index.php?erro=ADMultipleUser");
      }elseif($var['count'] < 1){
        $erro_con = false;
        mysqli_query($link, "INSERT INTO user  VALUES (NULL, '".$var[0]['samaccountname'][0]."', '".$password."', '".$var[0]['displayname'][0]."', '".$email."', 'UNICAMP - NEPO', ".ad_function($link, $var[0]['memberof']).", NULL, '".$date."', NULL, 1, 0, '".md5(uniqid(""))."', NULL, NULL)");
      }
      $erro_con = true;
    }
    catch (Exception $e) {
      //echo $e->getMessage();
      exit;
      $erro_con = false;
      logoff("index.php?erro=LDAPerror");
      //retorna erro
    }
  }
  return $erro_con;
}
function check_ad($con, $username, $ad_user, $ad_pass, $grupo)
{
  try {
    @$con->bind($ad_user, $ad_pass);
    $res = $con->search($grupo,'samaccountname='.$username,array('memberof','samaccountname','displayname','mail'));
    $var = $res->getEntries();
    if($res->countEntries() == 1){
        $erro_con = true;
    }elseif($var['count'] < 1){
      $erro_con = false;
    }
  }
  catch (Exception $e) {
    //echo $e->getMessage();
    exit;
    $erro_con = false;
    logoff("index.php?erro=LDAPerror");
    //retorna erro
  }
  return $erro_con;
}
?>
