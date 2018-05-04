<!doctype html>
<html lang="pt">
<?php
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php head
require_once( "../src/include/head.php");
?>
<body>
  <?php
  // inicia conecção com banco de dados
  $link = db_connection();

  menu($link, $row['function'], 'eventos', $row['name']);
  // Finaliza conecção com banco de dados
  db_close($link);
  if (!isset($_GET["page"])) $_GET["page"]="functions";
  ?>
  <siv class="container">
    <div class="row" style="margin: 0 auto;">
      <div class="col-md-12">
        <?php
        if($_GET["page"] == "create"){
          include "include/create.php";
        }elseif($_GET["page"] == "type_event"){
          include "include/type_event.php";
        }elseif($_GET["page"] == "add"){
          include "include/add.php";
        }elseif($_GET["page"] == "edit"){
          include "include/edit.php";
        }elseif($_GET["page"] == "event"){
          include "include/event.php";
        }elseif($_GET["page"] == "registration"){
          include "include/registration.php";
        }else{
          echo '<h1>Pagina não Existe</h1>';
        }
        ?>
      </div>
    </div>
  </div>
  <div>
  </br>
</div>
</div>
</body>
<script>
document.getElementById("title").innerHTML = "<?php echo $title; ?> | <?php echo SYSTEM_NAME; ?>";
</script>
</html>
