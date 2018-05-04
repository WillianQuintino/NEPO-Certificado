<?php

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['id'])) {
  // Destrói a sessão por segurança
  session_destroy();
  // Redireciona o visitante de volta pro login
  header("Location: index.php"); exit;
}
// php config
require_once( "../src/config/db.config");
require_once( "../src/config/site.config");
// php include
require_once(__ROOT__.'\include\functions\db.php');
if($_GET["form"]=='type_event'){
  $title = 'Adicionar Tipo de Evento';
  $html = '</br>
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
}else{
  $title = 'Pagina não Existe';
  $html = '<h1>Pagina não Existe</h1>';
}
?>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo $title; ?></h4></div>

  <?php
  echo $html;
  if($_GET["form"]=='ad_config'){
    datalist_functions();
    echo $html2;
  }
  ?>
</div>
