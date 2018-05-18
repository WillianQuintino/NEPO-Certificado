<!doctype html>
<html lang="pt">
<?php
if($_GET["page"] == "model"){
  //tipo da pagina para segurança
  $typepage = 'eventos';
  $include = "include/model.php";
}elseif($_GET["page"] == "type"){
  //tipo da pagina para segurança
  $typepage = 'eventos';
  $include = "include/type.php";
}elseif($_GET["page"] == "models"){
  //tipo da pagina para segurança
  $typepage = 'eventos';
  $include = "include/models.php";
}
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

  menu($link, $row['function'], 'certificados', $row['name']);
  // Finaliza conecção com banco de dados
  db_close($link);
  if (!isset($_GET["page"])) $_GET["page"]="functions";
  ?>
  <siv class="container">
    <div class="row" style="margin: 0 auto;">
      <div class="col-md-12">
        <?php
        if(isset($include)){
          include $include;
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
