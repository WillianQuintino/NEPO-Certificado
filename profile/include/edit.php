<?php
// Inicia Conexão
$link = db_connection();

$title="Editar Usuários";

//busca ultimo id do banco de dados
$rs1 = mysqli_query($link, "SELECT * FROM user order by id_user asc") or die(mysql_error());
$cont1 = mysqli_num_rows($rs1);
for($i=0; $i < $cont1; $i++) {
  $row1 = mysqli_fetch_assoc($rs2);
  $maxdb1 = $row1["id_user"];
}

//busca Usuário pelo id
$rs = mysqli_query($link, "SELECT * FROM user where id_user='".$_SESSION['id']."'") or die(mysql_error());
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

?>
<br />
<form id="profile" name="Profile" method="post" action="update.php?page=profile" class="form-horizontal">
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
    <input type="number"  name="id" class="form-control" id="id" placeholder="ID" value="<?php if(isset($_SESSION['id'])) echo $_SESSION['id']; ?>" style="display: none">
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
    <?php
    // inicia conecção com banco de dados
    $link = db_connection();
    if(checkuser($link, 'ramal', $rs['function'])){?>
      <div class="form-group">
        <label for="ramal" class="col-sm-1 control-label">Ramal</label>
        <div class="col-sm-6">
          <input type="number"  name="ramal" class="form-control" id="ramal" placeholder="Ramal" value="<?php if(isset($rs['ramal'])) echo $rs['ramal']; ?>" min="0" max="99999">
        </div>
        <div class="col-sm-5"></div>
      </div>
    <?php }
    // Finaliza conecção com banco de dados
    db_close($link);
    ?>
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
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Salvar</button>
      </div>
    </div>
  </form>
