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

  menu($link, $row['function'], 'home', $row['name']);
  // Finaliza conecção com banco de dados
  db_close($link);
    if (!isset($_GET["page"])) $_GET["page"]="summary";
  ?>
  <siv class="container">
    <div class="row" style="margin: 0 auto;">
      <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
          <script src="src\fontawesome-free-5.0.1\svg-with-js\js\fontawesome-all.js"></script>
          <li <?php if($_GET["page"] == "summary")echo 'class="active"'; ?>><a href="index.php?page=summary">Resumo da Conta</a></li>
          <li <?php if($_GET["page"] == "edit")echo 'class="active"'; ?>><a href="index.php?page=edit">Minhas informações</a></li>
          <li <?php if($_GET["page"] == "certificates")echo 'class="active"'; ?>><a href="index.php?page=certificates">Certificados</a></li>
          <li <?php if($_GET["page"] == "config")echo 'class="active"'; ?>><a href="index.php?page=config">Configuração</a></li>
        </ul>
      </div>
      <div class="col-md-10">
        <?php
        if($_GET["page"] == "summary"){
          include "include/summary.php";
        }elseif($_GET["page"] == "edit"){
          include "include/edit.php";
        }elseif($_GET["page"] == "certificates"){
            include "include/certificates.php";
            $title = "Usuários";
        }elseif($_GET["page"] == "config"){
            include "include/config.php";
            $title = "Usuários";
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
