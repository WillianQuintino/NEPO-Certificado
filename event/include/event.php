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
    $rs = mysqli_query($link, "SELECT event.id, name, caption, speaker, type_event.event_name, type_event.color_code, organizer, start_inscrition, start_event, end_event, start_time, end_time FROM event JOIN type_event ON event.id_type_event = type_event.Id LIMIT ".($page-1) * $item.", ".$item) or die(mysql_error());
    $usercont = mysqli_num_rows($rs);
    //Finaliza Conexão
    db_close($link);
    ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col" align=center>Nome</th>
          <th scope="col" align=center>Subtitulo</th>
          <th scope="col" align=center>Palestrante</th>
          <th scope="col" align=center>Cor do Titulo</th>
          <th scope="col" align=center>Organizadores</th>
          <th scope="col"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></i></th>
          <th colspan="4"><i class="fas fa-trash"></i></th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($row =  mysqli_fetch_assoc($rs)) {
          if($row['end_event'] == "0000-00-00"){
            $end_event = '<b>Fim: </b>'.date('d/m/Y', strtotime($row['start_event'])). ' ás '.$row['end_time'].'';
          }else{
            $end_event = '<b>Fim: </b>'.date('d/m/Y', strtotime($row['end_event'])). ' ás '.$row['end_time'].'';
          }
          echo '<tr>';
          echo '<td><b>'.$row['name'].'</b><br />
          <span style="font-size: 12px;"><b>Incrições: </b>'.date('d/m/Y', strtotime($row['start_inscrition'])). '<br />
          <b>Inicio: </b>'.date('d/m/Y', strtotime($row['start_event'])). ' ás '.$row['start_time'].'<br />
          '.$end_event.'</span>
          </td>
          <td>'.$row['caption'].'</td>
          <td>'.$row['speaker'].'</td>
          <td style="color : '.$row['color_code'].'">'.$row['event_name'].'</td>
          <td>'.organizerformate($row['organizer']).'</td>
          <td><a class="nav-link" href="'.SITE_URL.'event/index.php?page=edit&type=event&id='.$row['id'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>';
          echo '<td colspan="4"><a href="'.SITE_URL.'event/remove.php?page=event&v='.new_encrypt($row['id'], 'casa12').'" onclick="return confirm(\'Tem certeza que deseja deletar este registro?\')"><i class="fas fa-trash"></i></a></td>';
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
    <?php pagination($usercont, $_GET["page"], $itempage, $page); ?>
  </div>
</div>
<script>
maxheight = $(window).height();
$("#table").css("max-height", maxheight);
</script>
