<!doctype html>
<html>
<head>

  <!--PHP links-->
  <?php
  echo '<b>ID Session</b>'.$_SESSION['id'];
    // php config
   include dirname(__FILE__)."/src/config/site.php";
   include dirname(__FILE__)."/src/config/db.php";
   // php include
   include dirname(__FILE__)."/src/include/functions/db.php";
   include dirname(__FILE__)."/src/include/functions/security.php";
  ?>
  <meta charset="<?php echo CHARSET; ?>">
  <title><scrip></scrip></title>
  <meta name="generator" content="WYSIWYG Web Builder 12 Trial Version - http://www.wysiwygwebbuilder.com">
  <link href="/src/fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
  <link href="/src/css/menu.css" rel="stylesheet">
  <link href="/src/css/style.css" rel="stylesheet">
  <script src="/src/js/jquery-1.12.4.min.js"></script>
  <script src="/src/js/wb.panel.min.js"></script>
  <script>
  $(document).ready(function()
  {
     $("#PanelMenu1").panel({animate: true, animationDuration: 200, animationEasing: 'linear', dismissible: true, display: 'push', position: 'left', toggle: true});
  });
  </script>
</head>
<body>
<hr id="Line1" style="position:relative;left:0px;top:0px;width:970px;z-index:0;width: 100%;">
<a href="http://www.wysiwygwebbuilder.com" target="_blank"><img src="images/builtwithwwb12.png" alt="WYSIWYG Web Builder" style="position:absolute;left:441px;top:967px;border-width:0;z-index:250"></a>
<div id="wb_PanelMenu1" style="position:absolute;left:0px;top:0px;width:41px;height:34px;text-align:center;z-index:2;">
<a href="#PanelMenu1_markup" id="PanelMenu1">&nbsp;</a>
<div id="PanelMenu1_markup">
<ul>
  <?php
    $link = db_connection();
    if(!isset($_SESSION)) {
      session_name("Sessao");
      session_start();
    }
    echo '<li><a href="/"><i class="fa fa-home fa-fw">&nbsp;</i><span>Home</span></a></li>';
    echo $_SESSION['lastactivity'];
    if (isset($_SESSION['lastactivity'])) {
      //$name = decrypt($_SESSION['displayname']);

      echo $username = $_SESSION['username'];
      echo decrypt($_SESSION['username']);
      echo $email = $_SESSION['email'];
      $function_id = mysqli_query($link,"SELECT function FROM user WHERE username='$username' or email='$email'");
      $admin = mysqli_query($link, "SELECT * FROM function WHERE id='$function_id'");

      //echo $admin[0][0]."</br>".$admin[0][1]."</br>".$admin[0][2]."</br>".$admin[0][3]."</br>";

      if ($admin === 1){
        echo '<li><a href=""><i class="fa fa-home fa-fw">&nbsp;</i><span>Administração</span></a></li>';
      }
      if($oficio === 1){
        echo '<li><a href=""><i class="fa fa-home fa-fw">&nbsp;</i><span>Oficio</span></a></li>';
      }
    }else{
      $name = "Visitante";
    }
  ?>
   <!--<li><a href=""><i class="fa fa-home fa-fw">&nbsp;</i><span>Home</span></a></li>
   <li><a href=""><i class="fa fa-address-card-o fa-fw">&nbsp;</i><span>About Me</span></a></li>
   <li><a href=""><i class="fa fa-picture-o fa-fw">&nbsp;</i><span>Gallery</span></a></li>
   <li><a href=""><i class="fa fa-newspaper-o fa-fw">&nbsp;</i><span>Blog</span></a></li>
   <li><a href=""><i class="fa fa-link fa-fw">&nbsp;</i><span>Links</span></a></li>-->
</ul>
</div>
</div>
<?php
?>
<div class='bar'>
</div>
<div class='content'>
Sejá Bem Vindo <?php echo $name; ?>!
</div>
</body>
</html>
