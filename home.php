<!doctype html>
<html lang="pt">
<?php
// php config
require_once( "/src/config/db.config");
require_once( "/src/config/site.config");
// php head
require_once( "/src/include/head.php");
?>
<body>
  <?php
  // inicia conecção com banco de dados
  $link = db_connection();

  menu($link, $row['function'], 'home', $row['name']);

  // Finaliza conecção com banco de dados
  db_close($link);
  if($_GET['page'] == 'contacts'){
    require_once( "/src/include/contacts.php");
  }else{
    ?>
    <siv class="container">
      <div class="row" style="margin: 0 auto;">
        <div class="col-md-9">
          <?php $_GET["item"] = 3; 
          require_once( "/event/include/registration.php"); ?>
        </div>
        <div class="col-md-3">
          <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Certificados</div>
            <div class="panel-body">
              <p>Seus Certificados</p>
            </div>

            <!-- Table -->
            <div style="overflow: scroll;">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Download</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Seminário Demografia da Infância e Juventude</td>
                    <td><a class="nav-link" href="#">Link</a></td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Seminário Demografia da Infância e Juventude</td>
                    <td><a class="nav-link" href="#">Link</a></td>
                  </tr>
                  <tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>Seminário Demografia da Infância e Juventude</td>
                      <td><a class="nav-link" href="#">Link</a></td>
                    </tr>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div>
      </br>
    </div>
  </div>
<?php }?>
</body>
</html>
