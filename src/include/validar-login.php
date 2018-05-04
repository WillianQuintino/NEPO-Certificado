<?php
// Inclui Cnfigurações do Banco de dados
include "../config/db.php";
// Inclui funções php
include "/functions/db.php";
include "/functions/security.php";

$link = db_connection();

mysqli_query($link, "DELETE FROM login_attempts WHERE Time<" . (time() - (60 * 5)));
if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['login'])); //redirect($url+"/");

if ($_POST['password'] == ""); //redirect("/?reason=blankpass");
$secure   = true;
$httponly = true;
$username = strtolower($_POST["username"]);


if (ini_set('session.use_only_cookies', 1) === FALSE); //redirect("/?reason=SecurityError");
$ldaphost = "143.106.156.15";
$ldapport = 389;
$ds       = ldap_connect($ldaphost, $ldapport); //or redirect("/?reason=LDAPerror");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

echo "<script> alert('" . $_POST['username'] . "|" . $_POST['password'] . "|" . $_POST['login'] . "');</script>";

$rs = mysqli_query($link, "SELECT * FROM login_attempts WHERE user='$username'");
if (mysqli_num_rows($rs) >= 5); //redirect("/?reason=WhrongWait");


$rs = mysqli_query($link, "SELECT * FROM user WHERE user='$username'or email='$username'");
if (mysqli_num_rows($rs) == 0)
               $isNepoUser = true;
else {
               if (mysqli_num_rows($rs) != 1) redirect("/?reason=MultipleUser");
               $rs = mysqli_fetch_assoc($rs);
               if ($rs['password'])
                               $isNepoUser = false;
               else
                               $isNepoUser = true;
}

if ($isNepoUser) {
               if (ldap_bind($ds, $username . "@nepo.unicamp.br", $_POST['password'])) {
                               $_SESSION['lastactivity'] = time();
                               $_SESSION['username']     = encrypt($username);

                               $grupo    = 'DC=nepo,DC=unicamp,DC=br';
                               $filtro   = "(&(cn=$username))";
                               $pesquisa = ldap_search($ds, $grupo, $filtro);
                               $info     = ldap_get_entries($ds, $pesquisa);
                               ldap_unbind($ds);
               } else {
                               ldap_bind($ds, "visitante@nepo.unicamp.br", "visitante");
                               $grupo    = 'DC=nepo,DC=unicamp,DC=br';
                               $filtro   = "(&(cn=$username))";
                               $pesquisa = ldap_search($ds, $grupo, $filtro);
                               $info     = ldap_get_entries($ds, $pesquisa);
                               ldap_unbind($ds);
               }


               if (!isset($_SESSION['username'])) {
                               if ($info[count] === 0) {
                                               if (mysqli_num_rows($rs) === 0) redirect("/?reason=WhrongUser");
                                               else redirect("/updateEmail.php?user=".encrypt($username));
                               } else {
                                               mysqli_query($link, "INSERT INTO login_attempts(User,Time) values ('$username'," . time() . ")");
                                               redirect("/?reason=WhrongPass&user=$username");
                               }
               }

               session_name("Sessao");
               session_start();
               $_SESSION['displayname'] = encrypt($info[0]['displayname'][0]);


               $rs = mysqli_query($link, "SELECT * FROM user WHERE user='$username' or email='$username'");
               if (mysqli_num_rows($rs) == 0) {
                               for ($i = 0; $i < $info[0]['memberof']['count']; $i++) {
                                               switch ($info[0]['memberof'][$i]) {
                                                               case "CN=Admin,CN=Users,DC=nepo,DC=unicamp,DC=br":
                                                                               $type["Administrador"] = true;
                                                                               break;
                                                               case "CN=Alunos,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                               case "CN=doutor,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                               case "CN=mestrado,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                               case "CN=posdoc,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                                               $type["Aluno"] = true;
                                                                               break;
                                                               case "CN=biblio,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                                               $type["Biblioteca"] = true;
                                                                               break;
                                                               case "CN=Coordenacao,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                                               $type["Coordenacao"] = true;
                                                                               break;
                                                               case "CN=gap,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                                               $type["Funcionario"] = true;
                                                                               break;
                                                               case "CN=pesquisador,OU=Pesquisadores,OU=Grupos,OU=Campinas,DC=nepo,DC=unicamp,DC=br":
                                                                               $type["Pesquisador"] = true;
                                                                               break;
                                                               default:
                                                                               $type;
                                                                               break;
                                               }
                               }
                               $type[0] = 0;
                               for ($i = 0; $i < sizeof($type); $i++) {
                                               if ($type[key($type)] === true)
                                                               switch (key($type)) {
                                                                               case "Administrador":
                                                                                               $type[0] += 1;
                                                                                               break;
                                                                               case "Aluno":
                                                                                               $type[0] += 2;
                                                                                               break;
                                                                               case "Biblioteca":
                                                                                               $type[0] += 4;
                                                                                               break;
                                                                               case "Coordenacao":
                                                                                               $type[0] += 8;
                                                                                               break;
                                                                               case "Funcionario":
                                                                                               $type[0] += 16;
                                                                                               break;
                                                                               case "Pesquisador":
                                                                                               $type[0] += 32;
                                                                                               break;
                                                               }
                                               next($type);
                               }
                               mysqli_query($link, "INSERT INTO user(user,name,email,instituicao,function) values('$username','" . decrypt($_SESSION['displayname']) . "','$username@nepo.unicamp.br','UNICAMP - NEPO',$type[0])");
                               $_SESSION['lastactivity'] = time();
                               $_SESSION['username']     = encrypt($username);
                               $_SESSION['permission']   = encrypt($type[0]);
                               if (isset($_GET['redir']))
                                               header("Location: " . $_GET['redir']);
                               else header("Location: ../../home.php");
               } else {
                               if (mysqli_num_rows($rs) != 1)
                                               redirect("/?reason=MultipleUser");
                               $rs                       = mysqli_fetch_assoc($rs);
                               $_SESSION['lastactivity'] = time();
                               $_SESSION['username']     = encrypt($username);
                               $_SESSION['displayname']  = encrypt($rs['name']);
                               $_SESSION['permission']   = encrypt($rs['function']);
                               if (isset($_GET['redir']))
                                               header("Location: " . $_GET['redir']);
                               else header("Location: ../../home.php");
               }
} else {
               $_POST['password'] = encrypt($_POST['password']);
               $_POST['pass']     = "";
               $rs['password']    = explode("\f;\n", $rs['password']);
               if (!empty($rs['password'][sizeof($rs['password']) - 1]))
                               redirect("/?reason=Activate");
               else
                               array_pop($rs['password']);
               for ($i = 0; $i < sizeof($rs['password']); $i++)
                               $_POST['pass'] .= chr($rs['password'][$i]);
               if ($_POST['pass'] === $_POST['password']) {
                               session_name("Sessao");
                               session_start();
                               $_SESSION['lastactivity'] = time();
                               $_SESSION['username']     = encrypt($username);
                               $_SESSION['displayname']  = encrypt($rs['name']);
                               $_SESSION['permission']   = encrypt($rs['funtion']);
                               if (isset($_GET['redir']))
                                               header("Location: " . $_GET['redir']);
                               else header("Location: ../../home.php");
               } else {
                               mysqli_query($link, "INSERT INTO login_attempts(User,Time) values ('$username'," . time() . ")");
                               echo 'WhrongPass|'.$_POST['pass'].'|'.$_POST['password']; //redirect("/?reason=WhrongPass&user=$username");
               }
}
?>
