<?php

$file = str_replace("\\new_site", "", $_SERVER['DOCUMENT_ROOT']).$_GET["arq"];

$filename = basename($file);

$file_extension = strtolower(substr(strrchr($filename,"."),1));


switch( $file_extension ) {
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg": $ctype="image/jpeg"; break;
    case "jpg": $ctype="image/jpg"; break;
    default:
}
header('Content-type: ' . $ctype);
header('Content-Length: ' . filesize($file));
readfile($file);
 ?>
