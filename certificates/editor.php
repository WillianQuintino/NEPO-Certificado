<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>bootstrap4</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js"></script>
  </head>
  <body>
    <div id="summernote"></div>
    <script>
      $('#summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 100
      });
    </script>
  </body>
</html>

<?php
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\src\include\functions\db.php');
require_once(__ROOT__.'\src\include\functions\security.php');
require_once(__ROOT__.'\src\include\functions\upload.php');

$link = db_connection();

$rs = mysqli_query($link, "SELECT user.name, event.name as event_name, image_certificate FROM user_presence JOIN event ON event.Id = user_presence.id_event JOIN user ON user.id_user user_presence.id_user WHERE id = 7");
$evento = mysqli_fetch_assoc($rs);

db_close($link);
	//require_once("../dompdf/dompdf_config.inc.php");
	//$dompdf = new DOMPDF();
	//$dompdf->load_html($html);
	//$dompdf->set_paper("a4", 'landscape');
	//$dompdf->render();
	//$dompdf = $dompdf->output();
	//file_put_contents("./Download/". $user ."_". $event .".pdf", $dompdf);
	//echo "Success";
//}
//exit();
?>
