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

  menu($link, $row['function'], '', $row['name']);
  // Finaliza conecção com banco de dados
  db_close($link);
    if (!isset($_GET["page"])) $_GET["page"]="users";
  ?>
  <siv class="container">
    <div class="row" style="margin: 0 auto;">
      <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
          <script src="src\fontawesome-free-5.0.1\svg-with-js\js\fontawesome-all.js"></script>
          <li <?php if($_GET["page"] == "users" or $_GET["type"] == "profile")echo 'class="active"'; ?>><a href="index.php?page=users">Usuário</a></li>
          <li <?php if($_GET["page"] == "functions" or $_GET["type"] == "function" or $_GET["form"] == "functions")echo 'class="active"'; ?>><a href="index.php?page=functions">Funções</a></li>
          <li <?php if($_GET["page"] == "ad_config" or $_GET["form"] == "ad_config")echo 'class="active"'; ?>><a href="index.php?page=ad_config">Ad Grupos</a></li>
          <li <?php if($_GET["page"] == "config")echo 'class="active"'; ?>><a href="index.php?page=config">Configuração</a></li>
        </ul>
      </div>
      <div class="col-md-10">
        <?php
        if($_GET["page"] == "users"){
          include "include/users.php";
        }elseif($_GET["page"] == "edit"){
          include "include/edit.php";
        }elseif($_GET["page"] == "functions"){
            include "include/functions.php";
        }elseif($_GET["page"] == "ad_config"){
            include "include/ad_config.php";
            $title = "Usuários";
        }elseif($_GET["page"] == "config"){
            include "include/config.php";
            $title = "Usuários";
        }elseif($_GET["page"] == "add"){
            include "include/add.php";
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
