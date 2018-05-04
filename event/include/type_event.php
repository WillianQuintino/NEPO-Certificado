<?php $title="Tipos de Eventos"; ?>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo $title; ?></h4>
    <div class="btn-group pull-right">
      <a href="index.php?page=add&form=type_event" class="btn btn-default btn-sm"><i class="fas fa-plus"></i> Novo Tipo de Evento</a>
    </div>
  </div>

  <div style="overflow-x:scroll;">
    <?php

    // Inicia Conexão
    $link = db_connection();

    //busca
    $rs = mysqli_query($link, "SELECT id, color, color_code, event_name FROM type_event") or die(mysql_error());

    //Finaliza Conexão
    db_close($link);
    ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col" align=center>Cor</th>
          <th scope="col" align=center>Cor em Hex</th>
          <th scope="col" align=center>Eventos</th>
          <th scope="col"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></i></th>
          <th colspan="4"><i class="fas fa-trash"></i></th>
        </tr>
      </thead>
      <tbody>
        <?php
        while(($row =  mysqli_fetch_assoc($rs))) {
          echo '<tr style="color: '.$row['color_code'].'">';
          echo '<td>'.$row['color'].'</td>
          <td>'.$row['color_code'].'</td>
          <td>'.$row['event_name'].'</td>
          <td><a class="nav-link" href="'.SITE_URL.'event/index.php?page=edit&type=type_event&id='.$row['id'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>';
          echo '<td colspan="4"><a href="'.SITE_URL.'event/remove.php?page=type_event&v='.new_encrypt($row['id'], 'casa12').'" onclick="return confirm(\'Tem certeza que deseja deletar este registro?\')"><i class="fas fa-trash"></i></a></td>';
          echo '</tr>';
        }
        function active($input){
          if ($input === "0"){
            $code = '<spam style="color: red;"><i class="fa fa-times-circle" aria-hidden="true"></i></spam>';

          }else{
            $code = '<spam style="color: green;"><i class="fa fa-check-circle" aria-hidden="true"></i></spam>';
          }
          return $code;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
