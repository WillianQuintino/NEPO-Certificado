<div class="panel panel-primary">
  <!-- Default panel contents -->
  <?php

  if($_GET["form"]=='type_event'){
    $title = 'Adicionar Tipo de Evento';
    echo '<div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;">'.$title.'</h4></div>';
    echo '</br>
    <form id="type_event" name="Type Event" method="post" action="insert.php?page=type_event" class="form-horizontal">
    <div class="form-group">
    <label for="color" class="col-sm-3 control-label">Cor</label>
    <div class="col-sm-4">
    <input type="text"  name="color" class="form-control" id="color" placeholder="Nome da Cor">
    </div>
    <div class="col-sm-5"></div>
    </div>
    <div class="form-group">
    <label for="color_code" class="col-sm-3 control-label">Cor em Hex</label>
    <div class="col-sm-4">
    <div id="cp2" class="input-group colorpicker-component">
    <input id="color_code" name="color_code" type="text" value="#FF0000" class="form-control" />
    <span class="input-group-addon"><i></i></span>
    </div>
    <script>
    $(function() {
      $(\'#cp2\').colorpicker();
    });
    </script>
    </div>
    <div class="col-sm-5"></div>
    </div>
    <div class="form-group">
    <label for="event_name" class="col-sm-3 control-label">Evento</label>
    <div class="col-sm-4">
    <input type="text"  name="event_name" class="form-control" id="event_name" placeholder="Nome do Evento">
    </div>
    <div class="col-sm-5"></div>
    </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-default">Salvar</button>
    </div>
    </div>
    </form>';
  }elseif($_GET["form"]=='present'){
    $title = 'Confirmar Presentes';
    echo '<div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;">'.$title.'</h4></div>';
    $link = db_connection();
    if(isset($_GET["p"]))$page = $_GET["p"]; else $page = 1;
    if(isset($_GET["item"]))$item = $_GET["item"]; else $item = 50;
    //busca
    $rs = mysqli_query($link, "SELECT `registration`.`id_user`, `registration`.`id_event`, `user`.`name`, `user`.`institution` FROM `registration` JOIN `user` ON `user`.`id_user` = `registration`.`id_user` WHERE `registration`.`id_event` =".$_GET['id']." ORDER BY `user`.`name` ASC LIMIT ".($page-1) * $item.", ".$item) or die(mysql_error());
    $usercont = mysqli_num_rows(mysqli_query($link, "SELECT `registration`.`id_user`, `registration`.`id_event`, `user`.`name`, `user`.`institution` FROM `registration` JOIN `user` ON `user`.`id_user` = `registration`.`id_user` WHERE `registration`.`id_event` =".$_GET['id']." ORDER BY `user`.`name` ASC"));
    $rs2 = mysqli_query($link, "SELECT `start_event`, `end_event`, `name` FROM `event` WHERE `id` =".$_GET["id"]) or die(mysql_error());
    $row2 = mysqli_fetch_assoc($rs2);
    $start_event = $row2['start_event'];
    $datetotal = subdate($row2['start_event'], $row2['end_event']);
    //Finaliza Conexão
    db_close($link);

    echo '</br><div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12"  align="center"><h3 align="center"><b>Evento:</b> '.$row2['name'].'</h3></div><br />
    <form id="type_event" name="Type Event" method="post" action="insert.php?page=present" class="form-horizontal">
    <table class="table">
    <thead>
    <tr>
    <th scope="col" align=center>Nome do Inscrito</th>
    <th scope="col" align=center>Instituição</th>
    <th scope="col" align=center>Tipo de Certificado</th>
    <th scope="col" align=center>Esteve Presente</th>
    </tr>
    </thead>
    <tbody>';
    $i_user=0;
    while($row =  mysqli_fetch_assoc($rs)) {
      $i_user ++;
      echo '<tr>';
      echo '<td>'.$row['name'].'</td>
      <td>'.$row['institution'].'</td>
      <td>';
      list_type_certificate($row['id_event'], $row['id_user'], $i_user);
      echo '</td><td><div class="row">';
      for ($i=0; $i <= $datetotal; $i++) {
        echo '<div class="col-lg"><input type="checkbox" class="form-check-input" name="user['.$i_user.'][date]['.$i.'][check]" '.checked_date_type_certificate($row['id_event'], $row['id_user'], date('Y-m-d', strtotime('+'.$i.' days', strtotime($row2['start_event'])))).'>
        '.date('d/m/Y', strtotime('+'.$i.' days', strtotime($row2['start_event']))).'</div>
        <input type="hidden" name="user['.$i_user.'][date]['.$i.'][value]" value="'.date('Y-m-d', strtotime('+'.$i.' days', strtotime($row2['start_event']))).'" >';
      }
      echo '<input type="hidden" name="user['.$i_user.'][date][count]" value="'.$i.'">
      <input type="hidden" name="user['.$i_user.'][value]" value="'.$row['id_user'].'"></div></td></tr>';
    }
    echo '</tbody>
    </table><div class="form-group">
    <div class="col-sm-10">';
    pagination($usercont, $_GET["page"].'&form=present&id='.$_GET["id"], $item, $page);
    echo'
    </div>
    <div class="col-sm-2">
    <input type="hidden" name="user[count]" value="'.$i_user.'">
    <input type="hidden" name="id_event" value="'.$_GET["id"].'">
    <button type="submit" class="btn btn-default">Salvar</button>
    </div>
    </div></form>';
  }else{
    $title = 'Pagina não Existe';
    echo '<h1>Pagina não Existe</h1>';
  }
  ?>
</div>
