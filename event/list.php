<?php

// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");

// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
require_once(__ROOT__."\lib\PHPExcel\Classes\PHPExcel.php");

header( 'Content-Type: text/html; charset=iso-8859-1' );
setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
date_default_timezone_set( TIMEZONE );
if( !isset($_GET['Event']) ) exit("Error");

$event = $_GET['Event'];


$link = db_connection();
$rs = mysqli_query($link, "SELECT user.name, user.institution, user.email, event.name AS event, event.speaker, event.caption,  event.start_event FROM registration JOIN user ON user.id_user = registration.id_user JOIN event ON event.id = registration.id_event WHERE id_event='".$event."'");
//if(mysqli_num_rows($rs)==0) exit("Nobody");
	$excel = PHPExcel_IOFactory::load("Download/_Tempo_de_Debate.xlsx");
	$plan = $excel->getSheet(0);
	for($i=1;$i<=mysqli_num_rows($rs);$i++){
		$user = mysqli_fetch_assoc($rs);
    $j = $i + 5;
		$plan->setCellValue("A$j", ucwords($user['name']));
		$plan->setCellValue("B$j", $user['institution']);
    $plan->setCellValue("C$j", $user['email']);
	}
  $event = (empty($user['event']) ? $user['caption'] : $user['event']);
  $plan->setCellValue("A1", $user['event']);
  $plan->setCellValue("A2", ucwords($user['speaker']));
  $plan->setCellValue("A3", strftime('%d de %B de %Y',strtotime($user['start_event'])));
	$file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	$event = str_replace(" ","_",$event);
	$event = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($event)));
	$file->save("Download/$event.xlsx");
	echo "Success";

//exit();

?>
