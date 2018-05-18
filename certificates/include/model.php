<?php
// Inicia Conexão
$link = db_connection();

$title="Editar Modelo";

//busca Usuário pelo id
$rs = mysqli_query($link, "SELECT * FROM event_model_certificate where Id='".$_GET["id"]."'") or die(mysql_error());
$rs  = mysqli_fetch_array($rs);

//Finaliza Conexão
db_close($link);

?>
<br />
<form id="profile" name="Profile" method="post" action="update.php?page=model" class="form-horizontal">
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

        rollPageId($link, $rs['name'], "event_model_certificate", "Id", "event/index.php?page=model&id=");

        //Finaliza Conexão
        db_close($link);
        ?>
      </div>
      <div class="col-sm-8"></div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Nome do Modelo</label>
      <div class="col-sm-6">
        <input type="text"  name="name" class="form-control" id="name" placeholder="Nome do Modelo" value="<?php if(isset($rs['name'])) echo $rs['name']; ?>">
      </div>
      <div class="col-sm-4"></div>
    </div>
    <div class="form-group">
      <label for="type" class="col-sm-2 control-label">Tipo de Usuário</label>
      <div class="col-sm-6">
        <select id="type" class="selectpicker" data-live-search="true" placeholder="Selecione o tipo" name="type">
          <?php datalist_user_type_certificate($rs['id_user_type_certificate']); ?>
        </select>
      </div>
      <div class="col-sm-4"></div>
    </div>
    <div class="form-group">
      <label for="language" class="col-sm-2 control-label">Idioma</label>
      <div class="col-sm-6">
        <input type="text" list="language_list" name="language"  class="form-control" id="language" placeholder="Idioma" value="<?php if(isset($rs['language'])) echo $rs['language']; ?>">
        <datalist id="language_list">
          <?php datalist_language(); ?>
        </datalist>
      </div>
      <div class="col-sm-4"></div>
    </div>
    <div class="form-group">
      <label for="html" class="col-sm-2 control-label">Modelo</label>
      <div class="col-sm-9">
        <!--  <div id="Background">
        <div id="Content">
        <p>Certifico que <strong>[[Nome do Usuário]]</strong> proferiu a palestra <strong>[[Nome do Evento]]</strong>realizado em [[Data do Evento]], das [[Hora Inicial]] &agrave;s [[Hora Final]], no N&uacute;cleo de Estudos de Popula&ccedil;&atilde;o &ldquo;Elza Berqu&oacute;&rdquo; da Universidade Estadual de Campinas.</p>

        <div id="LData"><p>Cidade Universit&aacute;ria &ldquo;Zeferino Vaz&rdquo;, [[Dia da Presença]].</p></div>
      </div>

      <div class="Sign">
      [[Assinatura]]
    </div>
  </div>-->
  <textarea name="html" id="html">
    <?php if(isset($rs['html'])) echo $rs['html']; ?>
  </textarea>
  <script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  CKEDITOR.replace( 'html');
  nanospell.ckeditor('html',{
    dictionary : "pt_br",  // "es" is for spanish
    server : "php" });
    </script>
  </div>
  <div class="col-sm-1"></div>
</div>
<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-default">Salvar</button>
  </div>
</div>
</form>
