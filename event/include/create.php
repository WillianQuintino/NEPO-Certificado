<?php $title="Criar Evento"; ?>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading "><?php echo $title ?></div>
  <div class="row">
  <br />
    <form id="event" name="Event" method="post" enctype="multipart/form-data" action="insert.php?page=event" class="form-horizontal">
      <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Nome do Evento*</label>
        <div class="col-sm-4">
          <input type="text" required="required" name="name" class="form-control" id="name" placeholder="Nome do Evento">
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <label for="caption" class="col-sm-3 control-label">Subtitulo do Evento</label>
        <div class="col-sm-4">
          <input type="text"  name="caption" class="form-control" id="caption" placeholder="Subtitulo do Evento">
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <label for="speaker" class="col-sm-3 control-label">Palestrante</label>
        <div class="col-sm-4">
          <input type="text"  name="speaker" class="form-control" id="speaker" placeholder="Palestrante">
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <label for="color" class="col-sm-3 control-label">Cor do Titulo*</label>
        <div class="col-sm-4">
          <select id="color" name="color" class="form-control selectpicker">
            <?php datalist_color_event(); ?>
          </select>

        </div>
        <div class="col-sm-5"><a href="<?php echo SITE_URL ?>event/index.php?page=type_event"><button type="button" class="btn btn-default" style="width:250px">Gerenciar Cores</button></a></div>
      </div>
      <div class="form-group">
        <label for="organizer" class="col-sm-3 control-label">Organizadores</label>
        <div class="col-sm-4">
          <select id="organizer" required="required" name="organizer[]" class="form-control selectpicker" multiple data-max-options="3" data-live-search="true">
            <?php datalist_organizer(); ?>
          </select>
        </div>
        <div class="col-sm-5"><a href="<?php echo SITE_URL ?>admin/index.php?page=users"><button type="button" class="btn btn-default" style="width:250px">Gerenciar Organizadores</button></a></div>
      </div>
      <div class="form-group">
        <label for="date_inscrition" class="col-sm-3 control-label">Início das Inscrições*</label>
        <div class="col-sm-4">
          <input type="date" min="2013-10-01" required="required" name="date_inscrition" class="form-control" id="date_inscrition" placeholder="Início das Inscrições">
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <label for="date_event" class="col-sm-3 control-label">Início do Evento*</label>
        <div class="col-sm-4">
          <input type="date" min="2013-10-01" required="required" name="date_event" class="form-control" id="date_event" placeholder="Início do Evento">
        </div>
        <div class="col-sm-5">
          <input id="ManyDays" type="checkbox">
          <label for="ManyDays">Evento Extenso</label>
        </div>
      </div>
      <div id="date_end" class="form-group" style="display:none">
        <label for="date_event_end" class="col-sm-3 control-label">Fim do Evento*</label>
        <div class="col-sm-4">
          <input type="date" min="2013-10-01" name="date_event_end" class="form-control" id="date_event_end" placeholder="Início do Evento">
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <label for="time_start" class="col-sm-3 control-label">Horario de Início*</label>
        <div class="col-sm-4">
          <input type="time" required="required" name="time_start" class="form-control" id="time_start" placeholder="Horario de Início">
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <label for="time_end" class="col-sm-3 control-label">Horario de Término*</label>
        <div class="col-sm-4">
          <input type="time" required="required" name="time_end" class="form-control" id="time_end" placeholder="Horario de Término">
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <label for="organizer" class="col-sm-3 control-label">Imagem do Certificado</label>
        <div class="col-sm-4">
          <div class="input-group image-preview">
            <input type="text" class="sn't send oform-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doen POST/GET -->
            <span class="input-group-btn">
              <!-- image-preview-clear button -->
              <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                <span class="glyphicon glyphicon-remove"></span> Clear
              </button>
              <!-- image-preview-input -->
              <div class="btn btn-default image-preview-input">
                <span class="glyphicon glyphicon-folder-open"></span>
                <span class="image-preview-input-title">Browse</span>
                <input type="file" accept=".jpg" required name="image"/> <!-- rename it -->
              </div>
            </span>
          </div>
        </div>
        <div class="col-sm-5"></div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-2">
          <button type="submit" class="btn btn-default" name="submit">Criar Evento</button>
        </div>
        <div class="col-sm-offset-2 col-sm-6">
          <button type="button" class="btn btn-default">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
$(function() {
  enable_cb();
  $("#ManyDays").click(enable_cb);
});

function enable_cb() {
  if (this.checked) {
    $("div#date_end").css("display", "block");
    $("input#date_event_end").attr("required", "required");
  } else {
    $("div#date_end").css("display", "none");
    $("input#date_event_end").removeAttr("required", "required");
  }
}
// Mantém os inputs em cache:
var inputs = $('input');

// Chama a função de verificação quando as entradas forem modificadas
// Usei o 'keyup', mas 'change' ou 'keydown' são também eventos úteis aqui
inputs.on('keyup', min_date);
inputs.on('mouseup', min_date);

function min_date(){
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();

  if(dd<10) {
    dd = '0'+dd
  }

  if(mm<10) {
    mm = '0'+mm
  }

  today = yyyy + '-' + mm + '-' + dd;

  $("input#date_inscrition").attr("min", today);
  date_inscrition = $("input#date_inscrition").val();
  if(!date_inscrition){
    $("input#date_event").attr("min", today);
  }else{
    $("input#date_event").attr("min", $("input#date_inscrition").val());
  }
  date_event = $("input#date_event").val();
  if(!date_event){
    $("input#date_event_end").attr("min", today);
  }else{
    $("input#date_event_end").attr("min", $("input#date_event").val());
  }

}
min_date();
</script>
