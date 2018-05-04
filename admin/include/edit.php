<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div id="panel-editar" class="panel-heading"><h4 class="panel-title pull-left" style="padding-top: 7.5px;">Editar</h4></div>

  <div>
    <?php
    if ($_GET["type"] === "profile"){
      // Inicia Conexão
      $link = db_connection();

      $title="Editar Usuários";

      //busca Usuário pelo id
      $rs = mysqli_query($link, "SELECT * FROM user where id_user='".$_GET["id"]."'") or die(mysql_error());
      $rs  = mysqli_fetch_array($rs);

      //Finaliza Conexão
      db_close($link);

      if ($rs['user_active'] === "1"){
        $user_active = '<spam style="color: green;"><i class="fa fa-check-circle" aria-hidden="true"></i> Sim</spam>';
      }else{
        $user_active = '<spam style="color: red;"><i class="fa fa-times-circle" aria-hidden="true"></i> Não</spam>';
      }
      if ($rs['sendMailException'] === "1"){
        $sendMailException = 'checked';
      }else{
        $sendMailException = '';
      }
      if ($rs['organizer'] === "1"){
        $organizer = 'checked';
      }else{
        $organizer = '';
      }

      ?>
      <br />
      <form id="profile" name="Profile" method="post" enctype="multipart/form-data" action="update.php?page=profile" class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label">Data de Registro</label></label>
          <div class="col-sm-2">
            <p class="form-control-static"><?php if(isset($rs['date_ts'])) echo $rs['date_ts']; ?></p>
          </div>
          <label class="col-sm-2 control-label">Usuário está Ativo?</label></label>
          <div class="col-sm-2">
            <p class="form-control-static"><?php if(isset($user_active)) echo $user_active; ?></p>
          </div>
          <div class="col-sm-2"></div>
        </div>
        <div class="form-group">
          <label for="id" class="col-sm-1 control-label">ID</label>
          <div class="col-sm-1">
            <p class="form-control-static"><?php if(isset($_GET['id'])) echo $_GET['id']; ?></p>
            <input type="number"  name="id" class="form-control" id="id" placeholder="ID" value="<?php if(isset($_GET['id'])) echo $_GET['id']; ?>" style="display: none">
            </div>
            <div class="col-sm-2">
              <?php
              // Inicia Conexão
              $link = db_connection();

              rollPageId($link, $rs['user'], "user", "id_user", "admin/index.php?page=edit&type=profile&id=");

              //Finaliza Conexão
              db_close($link);
              ?>
            </div>
            <label for="ramal" class="col-sm-1 control-label">Ramal</label>
            <div class="col-sm-2">
              <input type="number"  name="ramal" class="form-control" id="ramal" placeholder="Ramal" value="<?php if(isset($rs['ramal'])) echo $rs['ramal']; ?>" min="0" max="99999">
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="user" class="col-sm-1 control-label">Usuário</label>
            <div class="col-sm-6">
              <input type="text"  name="user" class="form-control" id="user" placeholder="Usuário" value="<?php if(isset($rs['user'])) echo $rs['user']; ?>">
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-1 control-label">Nome</label>
            <div class="col-sm-6">
              <input type="text"   name="name"  class="form-control" id="name" placeholder="Nome" value="<?php if(isset($rs['name'])) echo $rs['name']; ?>">
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-1 control-label">E-Mail</label>
            <div class="col-sm-6">
              <input type="email"  name="email" class="form-control" id="email" placeholder="E-Mail" value="<?php if(isset($rs['email'])) echo $rs['email']; ?>">
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="institution" class="col-sm-1 control-label">Instituição</label>
            <div class="col-sm-6">
              <input type="text" list="institutionList" name="institution" class="form-control" id="institution" placeholder="Instituição" value="<?php if(isset($rs['institution'])) echo $rs['institution']; ?>">
              <datalist id="institutionList">
                <?php datalist_institution(); ?>
              </datalist>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="function" class="col-sm-1 control-label">Função</label>
            <div class="col-sm-6">
              <select id="function" name="function" class="form-control" >
                <?php datalist_functions($rs['function']); ?>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="extra_information" class="col-sm-1 control-label">Informações Extras</label>
            <div class="col-sm-6">
              <textarea id="extra_information" name="extra_information" class="form-control" rows="3"><?php if(isset($rs['extra_information'])) echo $rs['extra_information']; ?></textarea>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="sendMailException" id="sendMailException" value="true" <?php if(isset($sendMailException)) echo $sendMailException; ?>>Receber Aviso de Novos Eventos
                </label>
                <label>
                  <input type="checkbox" name="organizer" id="organizer" value="true" <?php if(isset($organizer)) echo $organizer; ?>>Organizador de Eventos
                </label>
              </div>
            </div>
          </div>
          <div id="signature" class="form-group" style="display:none">
            <label for="signature" class="col-sm-3 control-label">Imagem do Certificado</label>
            <div class="col-sm-4">
              <input type="text" name="signature" class="form-control" id="signature" value="<?php if(isset($rs['signature'])) echo $rs['signature']; ?>" style="display: none">
              <div class="input-group image-preview">
                <input type="text" class="form-control image-preview-filename" disabled="disabled" value="<?php if(isset($rs['signature'])) echo basename($rs['signature']); ?>"> <!-- don't give a name === doesn't send on POST/GET -->
                <span class="input-group-btn">
                  <!-- image-preview-clear button -->
                  <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                  </button>
                  <!-- image-preview-input -->
                  <div class="btn btn-default image-preview-input">
                    <span class="glyphicon glyphicon-folder-open"></span>
                    <span class="image-preview-input-title">Browse</span>
                    <input type="file" accept=".png" name="image"/> <!-- rename it -->
                  </div>
                </span>
              </div>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Salvar</button>
            </div>
          </div>
        </form>
        <script>
        if($("#organizer").prop("checked")){
            $("div#signature").css("display", "block");
          }
        $(function() {
          $("#organizer").click(enable_cb);
        });
        function enable_cb() {
          if (this.checked) {
            $("div#signature").css("display", "block");
          } else {
            $("div#signature").css("display", "none");
          }
        }
        </script>
      <?php }elseif($_GET["type"] === "function"){

        $title="Editar Função";

        // Inicia Conexão
        $link = db_connection();

        //busca por id
        $rs = mysqli_query($link, "SELECT * FROM functions where id='".$_GET["id"]."'") or die(mysql_error());
        $rs  = mysqli_fetch_array($rs);

        //Finaliza Conexão
        db_close($link);
        ?>
      </br>
      <form id="function" name="Function" method="post" action="update.php?page=functions" class="form-horizontal">
        <div class="form-group">
          <label for="id" class="col-sm-1 control-label">ID</label>
          <div class="col-sm-1">
            <p class="form-control-static"><?php if(isset($_GET['id'])) echo $_GET['id']; ?></p>
            <input type="number"  name="id" class="form-control" id="id" placeholder="ID" value="<?php if(isset($_GET['id'])) echo $_GET['id']; ?>" style="display: none">
            </div>
            <div class="col-sm-2">
              <?php
              // Inicia Conexão
              $link = db_connection();

              rollPageId($link, $rs['functions_name'], "functions", "Id", "admin/index.php?page=edit&type=function&id=");

              //Finaliza Conexão
              db_close($link);
              ?>
            </div>
            <div class="col-sm-8"></div>
          </div>
          <div class="form-group">
            <label for="functions_name" class="col-sm-3 control-label">Nome da Função</label>
            <div class="col-sm-4">
              <input type="text"  name="functions_name" class="form-control" id="functions_name" placeholder="Nome da Função" value="<?php if(isset($rs['functions_name'])) echo $rs['functions_name']; ?>">
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="admin" class="col-sm-3 control-label">Permição de Administrado?</label>
            <div class="col-sm-4">
              <select id="admin" name="admin" class="form-control">
                <option value="0" <?php if($rs['admin'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['admin'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="eventos" class="col-sm-3 control-label">Permição de Eventos?</label>
            <div class="col-sm-4">
              <select id="eventos" name="eventos" class="form-control" >
                <option value="0" <?php if($rs['eventos'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['eventos'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="coordenacao" class="col-sm-3 control-label">Permição de Coordenação?</label>
            <div class="col-sm-4">
              <select id="coordenacao" name="coordenacao" class="form-control" >
                <option value="0" <?php if($rs['coordenacao'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['coordenacao'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="secretaria_de_pesquisa" class="col-sm-3 control-label">Permição de Secretaria de Pesquisa?</label>
            <div class="col-sm-4">
              <select id="secretaria_de_pesquisa" name="secretaria_de_pesquisa" class="form-control" >
                <option value="0" <?php if($rs['secretaria_de_pesquisa'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['secretaria_de_pesquisa'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="financeiro" class="col-sm-3 control-label">Permição de Secretaria de Finaceiro?</label>
            <div class="col-sm-4">
              <select id="financeiro" name="financeiro" class="form-control" >
                <option value="0" <?php if($rs['financeiro'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['financeiro'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="conselhos" class="col-sm-3 control-label">Permição de Secretaria de Conselhos?</label>
            <div class="col-sm-4">
              <select id="conselhos" name="conselhos" class="form-control" >
                <option value="0" <?php if($rs['conselhos'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['conselhos'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="convenios" class="col-sm-3 control-label">Permição de Secretaria de Convenios?</label>
            <div class="col-sm-4">
              <select id="convenios" name="convenios" class="form-control" >
                <option value="0" <?php if($rs['convenios'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['convenios'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="processos" class="col-sm-3 control-label">Permição de Secretaria de Processos?</label>
            <div class="col-sm-4">
              <select id="processos" name="processos" class="form-control" >
                <option value="0" <?php if($rs['processos'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['processos'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="inventario" class="col-sm-3 control-label">Permição de Inventario?</label>
            <div class="col-sm-4">
              <select id="inventario" name="inventario" class="form-control" >
                <option value="0" <?php if($rs['inventario'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['inventario'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label for="ramal" class="col-sm-3 control-label">Permição de Ramal?</label>
            <div class="col-sm-4">
              <select id="ramal" name="ramal" class="form-control" >
                <option value="0" <?php if($rs['ramal'] == 0) echo "selected";?>>Não</option>
                <option value="1" <?php if($rs['ramal'] == 1) echo "selected";?>>Sim</option>
              </select>
            </div>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Salvar</button>
            </div>
          </div>
        </form>
      <?php }else{
        echo "<h1>Esta Pagina Não Existe</h1>";
        $title="Esta Pagina Não Existe";
      } ?>
    </div>
  </div>
  <script>
  document.getElementById("panel-editar").innerHTML = "<?php echo $title; ?>";
  </script>
