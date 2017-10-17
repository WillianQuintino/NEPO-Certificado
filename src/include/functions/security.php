<?php

// Recebe chave para criptografia
$encryption_key = KEY;
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
?>
