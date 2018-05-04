<?php
if(empty($disable_security)){
  $disable_security = 0;
}

if($disable_security == 0){
  // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) session_start();

  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['id'])) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: index.php");
    logoff(SITE_URL); exit;
  }
}

// Recebe chave para criptografia
$encryption_key = KEY;
//Função de Redirecionamento no login
function redirect($url1){
  $defaultUrl = SITE_URL;
  $url = $defaultUrl.$url1;
  session_destroy();
  if(isset($_GET['redir'])) {
    $_GET['redir'] = urlencode($_GET['redir']);
    if(strpos($url,"?")===false) header("Location: $url?".$_GET['redir']);
    else header("Location: $url&redir=".$_GET['redir']);
  }else header("Location: $url");
  exit();
}

//função para criptografar usando a chave
function encrypt($encrypted_string) {

  global $encryption_key;

  $iv_size = mcrypt_get_iv_size(MCRYPT_GOST, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $encrypted_string = mcrypt_encrypt(MCRYPT_GOST, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);

  $iv_size = mcrypt_get_iv_size(MCRYPT_CAST_128, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $encrypted_string = mcrypt_encrypt(MCRYPT_CAST_128, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);

  $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $encrypted_string = mcrypt_encrypt(MCRYPT_3DES, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);

  return $encrypted_string;


}

//função para descriptografar usando a chave
function decrypt($decrypted_string) {

  global $encryption_key;

  $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $decrypted_string = mcrypt_decrypt(MCRYPT_3DES, $encryption_key, $decrypted_string, MCRYPT_MODE_ECB, $iv);

  $iv_size = mcrypt_get_iv_size(MCRYPT_CAST_128, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $decrypted_string = mcrypt_decrypt(MCRYPT_CAST_128, $encryption_key, $decrypted_string, MCRYPT_MODE_ECB, $iv);

  $iv_size = mcrypt_get_iv_size(MCRYPT_GOST, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $decrypted_string = mcrypt_decrypt(MCRYPT_GOST, $encryption_key, $decrypted_string, MCRYPT_MODE_ECB, $iv);

  $decrypted_string = str_replace("\0","",$decrypted_string);
  return $decrypted_string;

}

function new_encrypt($data, $key) {
  if(empty($key)){
    $key = $encryption_key;
  }
  // Remove the base64 encoding from our key
  $encryption_key = base64_decode($key);
  // Generate an initialization vector
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
  $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
  // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
  return base64_encode($encrypted . '::' . $iv);
}
//funtion for decrypt using key
function new_decrypt($data, $key) {
  if(empty($key)){
    $key = $encryption_key;
  }
  // Remove the base64 encoding from our key
  $encryption_key = base64_decode($key);
  // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
  list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
  return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

function add_login_attempts($link, $usernamePost, $redir, $errorType, $ipAddress){
  $date = date("Y-m-d H:i:s");
  $rs = mysqli_fetch_array(mysqli_query($link, "SELECT `contAttempts` FROM `login_attempts` WHERE user='" . $usernamePost . "'"));
  if(isset($rs['contAttempts'])){
    $contAttempts = $rs['contAttempts']+1;

    $sql  = "UPDATE `login_attempts` SET `datetime`='".$date."',`location`='".$redir."',`reason`='".$errorType."',`contAttempts`='".$contAttempts."',`IPaddress`='".$ipAddress."' WHERE user='".$usernamePost."'";
  }else{
    $sql  = "INSERT INTO `login_attempts`(`user`, `datetime`, `location`, `reason` , `contAttempts` , `IPaddress`)";
    $sql .=                     " VALUES ('".$usernamePost."','".$date."','".$redir."','".$errorType."','1','".$ipAddress."')";
  }
  mysqli_query($link, $sql);
}

function remove_login_attempts($link, $ipAddress){
  $sql  = "DELETE FROM `login_attempts` WHERE IPaddress='" . $ipAddress . "'";
  mysqli_query($link, $sql);
}

function logoff($url){
  if (!isset($_SESSION)) session_start();
  // Destrói a sessão por segurança
  session_destroy();
  if (!isset($url)) $url = "index.php";
  // Redireciona o visitante de volta pro login
  header("Location: ".$url); exit;
}

function login($link, $user_active, $id_user, $url){
  if ($user_active === '1') {
    // Se a sessão não existir, inicia uma
    if (!isset($_SESSION)) session_start();

    // Salva os dados encontrados na sessão
    $_SESSION['id'] = $id_user;


    if (!isset($url)){
      $url = "home.php";
    }
    header('location:'.$url);
  }else{
    //echo "Erro:Email não validado! Enviaremos novamente um email de validação. Por Favor verifique o email ". $rs['email'] ."|";
    sendVerificationMail($id_user, $link);
    $result = mysqli_query($link, "SELECT email FROM user WHERE user='".$id_user."'");
    $rs = mysqli_fetch_array($result);
    logoff('index.php?erro=Activate&email='.$rs['email']);

  }
}

function checkAttempts($link, $username){
  $rs = mysqli_fetch_array(mysqli_query($link, "SELECT `contAttempts`, `datetime` FROM `login_attempts` WHERE user='".$username."'"));
  $contAttempts = $rs['contAttempts'];
  if($contAttempts >= 5){
    // New Timezone Object
    $timezone = new DateTimeZone(TIMEZONE);

    // New DateTime Object
    $datenow =  new DateTime('now', $timezone);
    //echo $datenow->format('Y-m-d H:i:s');
    //echo '</br>';
    //echo $rs['datetime'].'</br>';
    $datedb = new DateTime($rs['datetime']);
    $datedb->add(new DateInterval('PT'.TIMEACCONT.'S'));
    //echo $datedb->format('Y-m-d H:i:s');
    //echo '</br>';
    if($datedb <= $datenow){
      return array(
        'double'  => true,
      );
    }else{
      $interval = $datenow->diff($datedb);
      $tmrest = sprintf('%s', $interval->format('%i minutos %s segundos restantes'));
      return array(
        'double'  => false,
        'tmrest'  => $tmrest,
      );
    }
  }else{
    return array(
      'double'  => true,
    );
  }
}

function checkuser($link, $namearea, $id_function){
  $rs = mysqli_fetch_array(mysqli_query($link, "SELECT ".$namearea."  FROM `functions` WHERE id='".$id_function."'"));
  if($rs[$namearea] === '1'){
    return true;
  }else{
    return false;
  }
}

function check_restricted_users($link, $userad){
  $result = mysqli_query($link, "SELECT user_ad  FROM `restricted_users` WHERE user_ad='".$userad."'");
  $rs = mysqli_num_rows($result);
  if($rs <= 0){
    return true;
  }else{
    return false;
  }
}
?>
