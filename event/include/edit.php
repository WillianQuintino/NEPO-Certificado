<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div id="panel-editar" class="panel-heading"><h4 class="panel-title pull-left" style="padding-top: 7.5px;">Editar</h4></div>

  <div>
    <?php
    if ($_GET["type"] === "type_event"){
      // Inicia Conexão
      $link = db_connection();

      $title="Editar Tipo do Evento";

      //busca Usuário pelo id
      $rs = mysqli_query($link, "SELECT * FROM type_event where id='".$_GET["id"]."'") or die(mysql_error());
      $rs  = mysqli_fetch_array($rs);

      //Finaliza Conexão
      db_close($link);

      ?>
      <br />
      <form id="type_event" name="Type Event" method="post" action="update.php?page=type_event" class="form-horizontal">
        <div class="form-group">
          <label for="id" class="col-sm-3 control-label">ID</label>
          <div class="col-sm-1">
            <p class="form-control-static"><?php if(isset($_GET['id'])) echo $_GET['id']; ?></p>
            <input type="number"  name="id" class="form-control" id="id" placeholder="ID" value="<?php if(isset($_GET['id'])) echo $_GET['id']; ?>" style="display: none">
            </div>
            <div class="col-sm-4">
              <?php
              // Inicia Conexão
              $link = db_connection();

              rollPageId($link, $rs['color'], "type_event", "Id", "event/index.php?page=edit&type=type_event&id=");

              //Finaliza Conexão
              db_close($link);
              ?>
            </div>
            <div class="col-sm-4"></div>
          </div>
          <div class="form-group">
            <label for="color" class="col-sm-3 control-label">Cor</label>
            <div class="col-sm-4">
              <input type="text"  name="color" class="form-control" id="color" placeholder="Nome da Cor" value="<?php if(isset($rs['color'])) echo $rs['color']; ?>">
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="color_code" class="col-sm-3 control-label">Cor em Hex</label>
            <div class="col-sm-4">
              <div id="cp2" class="input-group colorpicker-component">
                <input id="color_code" name="color_code" type="text" class="form-control" value="<?php if(isset($rs['color_code'])) echo $rs['color_code']; ?>"/>
                <span class="input-group-addon"><i></i></span>
              </div>
              <script>
              $(function() {
                $('#cp2').colorpicker();
              });
              </script>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="event_name" class="col-sm-3 control-label">Evento</label>
            <div class="col-sm-4">
              <input type="text"  name="event_name" class="form-control" id="event_name" placeholder="Nome do Evento" value="<?php if(isset($rs['event_name'])) echo $rs['event_name']; ?>">
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Salvar</button>
            </div>
          </div>
        </form>
      <?php }elseif($_GET["type"] === "event"){

        // Inicia Conexão
        $link = db_connection();

        $title="Editar Evento";

        //busca Usuário pelo id
        $rs = mysqli_query($link, "SELECT id, name, caption, speaker, id_type_event, start_inscrition, start_event, end_event, TIME_FORMAT(start_time, \"%H:%i\") as start_time, TIME_FORMAT(end_time, \"%H:%i\") as end_time, image_certificate, organizer FROM event where id='".$_GET["id"]."'") or die(mysql_error());
        $rs  = mysqli_fetch_array($rs);

        //Finaliza Conexão
        db_close($link);
        ?>
        <br />
        <form id="event" name="Event" method="post" enctype="multipart/form-data" action="update.php?page=event" class="form-horizontal">
          <div class="form-group">
            <label for="id" class="col-sm-3 control-label">ID</label>
            <div class="col-sm-1">
              <p class="form-control-static"><?php if(isset($_GET['id'])) echo $_GET['id']; ?></p>
              <input type="number"  name="id" class="form-control" id="id" placeholder="ID" value="<?php if(isset($_GET['id'])) echo $_GET['id']; ?>" style="display: none">
              </div>
              <div class="col-sm-4">
                <?php
                // Inicia Conexão
                $link = db_connection();

                rollPageId($link, $rs['name'], "event", "Id", "event/index.php?page=edit&type=event&id=");

                //Finaliza Conexão
                db_close($link);
                ?>
              </div>
              <div class="col-sm-4"></div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Nome do Evento*</label>
              <div class="col-sm-4">
                <input type="text" required="required" name="name" class="form-control" id="name" placeholder="Nome do Evento" value="<?php if(isset($rs['name'])) echo $rs['name']; ?>">
              </div>
              <div class="col-sm-5"></div>
            </div>
            <div class="form-group">
              <label for="caption" class="col-sm-3 control-label">Subtitulo do Evento</label>
              <div class="col-sm-4">
                <input type="text"  name="caption" class="form-control" id="caption" placeholder="Subtitulo do Evento" value="<?php if(isset($rs['caption'])) echo $rs['caption']; ?>">
              </div>
              <div class="col-sm-5"></div>
            </div>
            <div class="form-group">
              <label for="speaker" class="col-sm-3 control-label">Palestrante</label>
              <div class="col-sm-4">
                <input type="text"  name="speaker" class="form-control" id="speaker" placeholder="Palestrante" value="<?php if(isset($rs['speaker'])) echo $rs['speaker']; ?>">
              </div>
              <div class="col-sm-5"></div>
            </div>
            <div class="form-group">
              <label for="color" class="col-sm-3 control-label">Cor do Titulo*</label>
              <div class="col-sm-4">
                <select id="color" name="color" class="form-control selectpicker">
                  <?php datalist_color_event($rs['id_type_event']); ?>
                </select>
              <script>$('#color').selectpicker('val','<?php echo $rs['id_type_event']; ?>');</script>
              </div>
              <div class="col-sm-5"><a href="<?php echo SITE_URL ?>event/index.php?page=type_event"><button type="button" class="btn btn-default" style="width:250px">Gerenciar Cores</button></a></div>
            </div>
            <div class="form-group">
              <label for="organizer" class="col-sm-3 control-label">Organizadores</label>
              <div class="col-sm-4">
                <select id="organizer" required="required" name="organizer[]" class="form-control selectpicker" multiple data-max-options="3" data-live-search="true" >
                  <?php datalist_organizer(unserialize($rs['organizer'])); ?>
                </select>

              </div>
              <div class="col-sm-5"><a href="<?php echo SITE_URL ?>admin/index.php?page=users"><button type="button" class="btn btn-default" style="width:250px">Gerenciar Organizadores</button></a></div>
            </div>
            <div class="form-group">
              <label for="date_inscrition" class="col-sm-3 control-label">Início das Inscrições*</label>
              <div class="col-sm-4">
                <input type="date" min="2013-10-01" required="required" name="date_inscrition" class="form-control" id="date_inscrition" placeholder="Início das Inscrições" value="<?php if(isset($rs['start_inscrition'])) echo $rs['start_inscrition']; ?>">
              </div>
              <div class="col-sm-5"></div>
            </div>
            <div class="form-group">
              <label for="date_event" class="col-sm-3 control-label">Início do Evento*</label>
              <div class="col-sm-4">
                <input type="date" min="2013-10-01" required="required" name="date_event" class="form-control" id="date_event" placeholder="Início do Evento" value="<?php if(isset($rs['start_event'])) echo $rs['start_event']; ?>">
              </div>
              <div class="col-sm-5">
                <input id="ManyDays" type="checkbox" <?php if($rs['end_event'] != "0000-00-00") echo 'checked'; ?>>
                <label for="ManyDays">Evento Extenso</label>
              </div>
            </div>
            <div id="date_end" class="form-group" style="display:none">
              <label for="date_event_end" class="col-sm-3 control-label">Fim do Evento*</label>
              <div class="col-sm-4">
                <input type="date" min="2013-10-01" name="date_event_end" class="form-control" id="date_event_end" placeholder="Início do Evento" value="<?php if(isset($rs['end_event'])) echo $rs['end_event']; ?>">
              </div>
              <div class="col-sm-5"></div>
            </div>
            <div class="form-group">
              <label for="time_start" class="col-sm-3 control-label">Horario de Início*</label>
              <div class="col-sm-4">
                <input type="time" required="required" name="time_start" class="form-control" id="time_start" placeholder="Horario de Início" value="<?php if(isset($rs['start_time'])) echo $rs['start_time']; ?>">
              </div>
              <div class="col-sm-5"></div>
            </div>
            <div class="form-group">
              <label for="time_end" class="col-sm-3 control-label">Horario de Término*</label>
              <div class="col-sm-4">
                <input type="time" required="required" name="time_end" class="form-control" id="time_end" placeholder="Horario de Término" value="<?php if(isset($rs['end_time'])) echo $rs['end_time']; ?>">
              </div>
              <div class="col-sm-5"></div>
            </div>
            <div class="form-group">
              <label for="image_certificate" class="col-sm-3 control-label">Imagem do Certificado</label>
              <div class="col-sm-4">
                <input type="text" name="image_certificate" class="form-control" id="image_certificate" value="<?php if(isset($rs['image_certificate'])) echo $rs['image_certificate']; ?>" style="display: none">
                  <img style="width:100%;" src='<?php echo SITE_URL ?>src/include/file.php?arq=<?php if(isset($rs['image_certificate'])) echo $rs['image_certificate']; ?>'>
                </div>
                <div class="col-sm-5"></div>
              </div>
              <div class="form-group">
                <label for="image" class="col-sm-3 control-label">Atualizar Imagem do Certificado</label>
                <div class="col-sm-4">
                  <div class="input-group image-preview">
                    <input type="text" class="form-control image-preview-filename" disabled="disabled" value="<?php if(isset($rs['image_certificate'])) echo basename($rs['image_certificate']); ?>"> <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                      <!-- image-preview-clear button -->
                      <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                        <span class="glyphicon glyphicon-remove"></span> Clear
                      </button>
                      <!-- image-preview-input -->
                      <div class="btn btn-default image-preview-input">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="image-preview-input-title">Browse</span>
                        <input type="file" accept=".jpg" name="image"/> <!-- rename it -->
                      </div>
                    </span>
                  </div>
                </div>
                <div class="col-sm-5"></div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-2">
                  <button type="submit" class="btn btn-default" name="submit">Editar Evento</button>
                </div>
                <div class="col-sm-offset-2 col-sm-6">
                  <button type="button" class="btn btn-default">Cancelar</button>
                </div>
              </div>
            </form>
            <script>
            if($("#ManyDays").prop("checked")){
              $("div#date_end").css("display", "block");
              $("input#date_event_end").attr("required", "required");
            }else {
              $("div#date_end").css("display", "none");
              $("input#date_event_end").removeAttr("required", "required");
            };
            $(function() {
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
          <?php }else{
            echo "<h1>Esta Pagina Não Existe</h1>";
            $title="Esta Pagina Não Existe";
          } ?>
        </div>
      </div>
      <script>
      document.getElementById("panel-editar").innerHTML = "<?php echo $title; ?>";
      </script>
