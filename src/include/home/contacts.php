<?php

// php config
require_once( "src/config/db.config");
require_once( "src/config/site.config");
// php include
require_once(__ROOT__.'\include\functions\db.php');
require_once(__ROOT__.'\include\functions\mail.php');
require_once(__ROOT__.'\include\functions\security.php');
require_once(__ROOT__.'\include\functions\menu.php');
// inicia conecção com banco de dados
$link = db_connection();

$sql_user = "SELECT name, function, email, ramal FROM user WHERE ramal IS NOT NULL AND function <> '6'";

//busca as informações e coloca na variavel $row
$rs_user = mysqli_query($link, $sql_user) or die(mysql_error());

$sql_pesquisador = "SELECT name, function, email, ramal FROM user WHERE ramal IS NOT NULL AND function = '6'";

//busca as informações e coloca na variavel $row
$rs_pesquisador = mysqli_query($link, $sql_pesquisador) or die(mysql_error());

// Finaliza conecção com banco de dados
db_close($link);

?>

<siv class="container">
  <div class="row" style="margin: 0 auto;">
    <div class="col-md-6">
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Colaboradores</div>
        <div class="panel-body">
        </div>

        <!-- Table -->
        <div style="overflow: scroll;">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Função</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Ramal</th>
              </tr>
            </thead>
            <tbody>
                <?php while( $row_user = mysqli_fetch_array($rs_user)){
                  echo "<tr>
                  <td>".functionsname($row_user['function'])."</td>
                  <td>".$row_user['name']."</td>
                  <td>".$row_user['email']."</td>
                  <td>".$row_user['ramal']."</td>
                </tr>";
                } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Pesquisadores</div>
        <div class="panel-body">
        </div>

        <!-- Table -->
        <div style="overflow: scroll;">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Função</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Ramal</th>
              </tr>
            </thead>
            <tbody>
                <?php while( $row_pesquisador = mysqli_fetch_array($rs_pesquisador)){
                  echo "<tr>
                  <td>".functionsname($row_pesquisador['function'])."</td>
                  <td>".$row_pesquisador['name']."</td>
                  <td>".$row_pesquisador['email']."</td>
                  <td>".$row_pesquisador['ramal']."</td>
                  </tr>";
                } ?>
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
