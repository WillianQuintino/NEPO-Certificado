<?php
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
require_once(__ROOT__.'\src\include\functions\upload.php');

setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
date_default_timezone_set(TIMEZONE);

$link = db_connection();

$rs = mysqli_query($link, "SELECT `date`, `date_presence`, `user`.`name`, `event`.`name` AS 'event_name', `image_certificate`, `id_type_certificate`, `caption`, `event`.`organizer`, TIME_FORMAT(start_time, \"%H:%i\") as start_time, TIME_FORMAT(end_time, \"%H:%i\") as end_time, `event_model_certificate`.`html`  FROM user_presence JOIN event ON event.Id = user_presence.id_event JOIN user ON user.id_user = user_presence.id_user JOIN event_model_certificate ON event_model_certificate.id = event.id_event_model_certificate WHERE `event`.id = 8");
$evento = mysqli_fetch_assoc($rs);

$html = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<style>
html,body{
	width: 100%;
	height: 100%;
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	line-height: 35px;
	text-align: justify;
}
@page {
	margin: 0.8cm;
}
#Background{
	position: absolute;
	width: 100%;
	height: 100%;
	background-image: url(\'http://www.nepo.unicamp.br/dev/src/include/file.php?arq='.$evento['image_certificate'].'\');
	background-repeat: no-repeat;
	background-size: 100% 100%;
	font-size:20px;
}
#Titulo{
	position: absolute;
	width: 100%;
	height: 100%;
	top: 8%;
	font-size: 25px;
	text-align: center;
}
#Content{
	position: absolute;
	width: 75%;
	top: 25%;
	left: 5%;
	text-indent:10%;
	line-height:53px;
	text-align:justify;
	font-family:Arial,Helvetica,sans-serif;
}
#LData{
	text-align:right;
	font-family:Arial,Helvetica,sans-serif;
	font-size:20px;
}
.Sign{
	position: absolute;
	top: 50%;
	width: 100%;
	text-align:center;
	font-size:18px;
}
.col-md-auto img{
	width: 250px;
	height: 1.5cm;
}
</style>
</head>
<body>
';
$html .= $evento['html'];
/*$html .= '
<div id="Background"></div>
<!--<div id="Titulo"><h1>'.$evento['event_name'].'</h1></div>-->
<div id="Content">
<br>This document is to certify that "<strong>'. $evento['name'] .'</strong>" ';
//echo $rs['id_type_certificate'];
/*switch($rs['id_type_certificate']){
case 0: $html .= 'participated in the '; break;
case 1: $html .= 'proferiu a palestra '; break;
case 2: $html .= 'coordenou Sessões do '; break;
case 3: $html .= 'participou da mesa de abertura do '; break;
case 4: $html .= 'participou como debatedor e comentarista do '; break;
case 5: $html .= 'participou como debatedor do '; break;
case 6: $html .= 'participou como comentarista do '; break;
case 7: $html .= 'coordenou o evento '; break;
default: $html .= 'participou do '; break;
}
$html .= '<span style="color: #EF3E22">';
if(empty($evento['event_name']) && empty($evento['caption'])) exit("noName");
if(!empty($evento['event_name'])) $html .= $evento['event_name'];
if(!empty($evento['event_name']) && !empty($evento['caption'])) $html .= ' - ';

$html .= ' </span>, between 19 and 21 May 2016 in the city of Campinas - SP.';

$html .= '<div id="LData">Campinas, 19-21 May 2016.</div>';

echo $html;

$sign = unserialize($evento['organizer']);

if(isset($sign[0])){
$sql = $sign[0];
}
if(isset($sign[1])){
$sql .= ",".$sign[1];
}
if(isset($sign[2])){
$sql .= ",".$sign[2];
}
//echo "SELECT name, signature FROM user WHERE id_user in(".$sql.")";
//$rs = mysqli_query($link, "SELECT name, signature FROM user WHERE id_user in(".$sql.")");

/*for($i=0;$i<mysql_num_rows($rs);$i++) {
$organizador = mysql_fetch_assoc($rs);
print_r($sign[4]);
unset($sign[$i]);
if(file_exists('http://www.nepo.unicamp.br/dev/src/include/file.php?arq='. $organizador['signature'] .'.png')) $sign[$i] = '<img src="http://www.nepo.unicamp.br/dev/src/include/file.php?arq='. $organizador['signature'] .'.png"/>'. $organizador['name'] .'<br/>Organizador(a)';
else $sign[$i] = '<img src="http://www.nepo.unicamp.br/dev/src/include/file.php?arq=/uploads/imagens/signatures/sign.png"/>'. $organizador['name'] .'<br/>Organizador(a)';
}
switch(sizeof($sign)){
case 1: $html .= '<div class="Sign" style="left: 40%;">'. $sign[0] .'</div>';break;
case 2: $html .= '<div class="Sign" style="left: 15%;">'. $sign[0] .'</div><div class="Sign" style="left: 65%;">'. $sign[1] .'</div>';break;
case 3: $html .= '<div class="Sign" style="left: 10%;">'. $sign[0] .'</div><div class="Sign" style="left: 40%;">'. $sign[1] .'</div><div class="Sign" style="left: 70%;">'. $sign[2] .'</div>';break;
}*/

$html .= '
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
';
$html = str_replace("[[Nome do Usuário]]", $evento['name'] , $html);

if(empty($evento['event_name']) && empty($evento['caption'])) exit("noName");
if(!empty($evento['event_name'])) $evento_name = $evento['event_name'];
if(!empty($evento['event_name']) && !empty($evento['caption'])) $evento_name .= ' - '.$evento['caption'];
$html = str_replace("[[Nome do Evento]]", $evento_name , $html);

$html = str_replace("[[Data do Evento]]", strftime( '%d de %B de %Y',  strtotime($evento['date'])) , $html);
$html = str_replace("[[Hora Inicial]]", $evento['start_time'] , $html);
$html = str_replace("[[Hora Final]]", $evento['end_time'] , $html);
$html = str_replace("[[Dia da Presença]]",  strftime( '%d de %B de %Y',  strtotime($evento['date_presence'])) , $html);

$sign = unserialize($evento['organizer']);

if(isset($sign[0])){
	$sql = $sign[0];
}
if(isset($sign[1])){
	$sql .= ",".$sign[1];
}
if(isset($sign[2])){
	$sql .= ",".$sign[2];
}
//echo "SELECT name, signature FROM user WHERE id_user in(".$sql.")";
$rs = mysqli_query($link, "SELECT name, signature FROM user WHERE id_user in(".$sql.")");

for($i=0;$i<mysqli_num_rows($rs);$i++) {
	$organizador = mysqli_fetch_assoc($rs);
	unset($sign[$i]);
	if(isset($organizador['signature'])) $sign[$i] = '<img src="http://www.nepo.unicamp.br/dev/src/include/file.php?arq='. $organizador['signature'] .'"/><br/><span>'. $organizador['name'] .'</span><br/>Organizador(a)';
		else $sign[$i] = '<img src="http://www.nepo.unicamp.br/dev/src/include/file.php?arq=/uploads/imagens/signatures/sign.png"/><br/><span>'. $organizador['name'] .'</span><br/>Organizador(a)';
		}
		switch(sizeof($sign)){
			case 1: $signs .= '<div class="col-md-auto">'. $sign[0] .'</div>';break;
			case 2: $signs .= '<div class="col-md-auto">'. $sign[0] .'</div><div class="col-md-auto">'. $sign[1] .'</div>';break;
			case 3: $signs .= '<div class="col-md-auto">'. $sign[0] .'</div><div class="col-md-auto">'. $sign[1] .'</div><div class="col-md-auto">'. $sign[2] .'</div>';break;
		}
		$html = str_replace("[[Assinatura]]", $signs, $html);
		echo $html;
		db_close($link);
		//require_once(__ROOT__."\lib\dompdf\autoload.inc.php");
		// reference the Dompdf namespace
		//use Dompdf\Dompdf;

		//$dompdf = new DOMPDF();
		//$dompdf->load_html($html);
		//$dompdf->set_paper("a4", 'landscape');
		//$dompdf->render();
		//$dompdf = $dompdf->output();
		//file_put_contents("./Download/". $evento['name'] ."_". $evento_name .".pdf", $dompdf);
		//echo "Success";
		//}
		//exit();
		?>
