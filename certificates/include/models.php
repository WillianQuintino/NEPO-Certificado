<?php $title="Eventos"; ?>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo $title; ?></h4>
    <div class="btn-group pull-right">
      <a href="index.php?page=create" class="btn btn-default btn-sm"><i class="fas fa-plus"></i>Novo Evento</a>
    </div>
  </div>

  <div id="table" style="overflow:auto;  max-height: 50px;">
    <?php

    // Inicia Conexão
    $link = db_connection();
    if(isset($_GET["p"]))$page = $_GET["p"]; else $page = 1;
    if(isset($_GET["item"]))$item = $_GET["item"]; else $item = 10;
    //busca
    $rs = mysqli_query($link, "SELECT event_model_certificate.Id, event_model_certificate.name, language, user_type_certificate.name AS type FROM event_model_certificate JOIN user_type_certificate ON user_type_certificate.id = event_model_certificate.id_user_type_certificate ORDER BY name ASC LIMIT ".($page-1) * $item.", ".$item) or die(mysql_error());
    $usercont = mysqli_num_rows($rs);
    //Finaliza Conexão
    db_close($link);
    ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col" align=center>Nome</th>
          <th scope="col" align=center>Tipo de Usuário</th>
          <th scope="col" align=center>Idioma</th>
          <th colspan="4"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></i></th>
          <th colspan="4"><i class="fas fa-trash"></i></th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($row =  mysqli_fetch_assoc($rs)) {
          echo '<tr>';
          echo '<td>'.$row['name'].'</td>
          <td>'.$row['type'].'</td>
          <td>'.$row['language'].'</td>
          <td colspan="4"><a class="nav-link" href="'.SITE_URL.'certificates/index.php?page=model&id='.$row['Id'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>';
          echo '<td colspan="4"><a href="'.SITE_URL.'certificates/remove.php?page=event&v='.new_encrypt($row['Id'], 'casa12').'" onclick="return confirm(\'Tem certeza que deseja deletar este registro?\')"><i class="fas fa-trash"></i></a></td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
    <?php pagination($usercont, $_GET["page"], $itempage, $page); ?>
  </div>
</div>
<script>
maxheight = $(window).height();
$("#table").css("max-height", maxheight);
</script>
