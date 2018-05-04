<?php

// Recebe chave para criptografia
$encryption_key = "NEPO";
//Função de Redirecionamento no login
function redirect($url1){
    $defaultUrl = $SITE_URL;
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
      echo "Erro:Email não validado! Enviaremos novamente um email de validação. Por Favor verifique o email ". $rs['email'] ."|";

      sendVerificationMail($id_user, $link);

      logoff();

  }
}
?>
