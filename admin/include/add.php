<?php
if($_GET["form"]=='ad_config'){
  $title = 'Adicionar configuração do AD';
  $html = '<br />
  <form id="ad_config" name="ad_config" method="post" action="insert.php?page=ad_config" class="form-horizontal">
  <div class="form-group">
  <label for="name" class="col-sm-1 control-label">Nome</label>
  <div class="col-sm-6">
  <input type="text"   name="name"  class="form-control" id="name" placeholder="Nome" value="">
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="ad_gruop" class="col-sm-1 control-label">Grupo do AD</label>
  <div class="col-sm-6">
  <input type="ad_gruop"  name="ad_gruop" class="form-control" id="ad_gruop" placeholder="Grupo do AD" value="">
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="function" class="col-sm-1 control-label">Função</label>
  <div class="col-sm-6">
  <select id="function" name="function" class="form-control" >';

  $html2 = '</select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
  <button type="submit" class="btn btn-default">Salvar</button>
  </div>
  </div>
  </form>';
}elseif($_GET["form"]=='functions'){
  $title = 'Adicionar Função';
  if($_GET["img"] == "success"){
    echo '<div class="alert alert-success">
    <strong>Sucesso!</strong> Imagem salva com sucesso.
    </div>';
  }elseif($_GET["img"] == "erro_save"){
    echo '<div class="alert alert-danger">
    <strong>Perrigo!</strong> Erro ao salvar a Imagem.
    </div>';
  }elseif($_GET["img"] == "erro_type"){
    echo '<div class="alert alert-warning">
    <strong>Aviso!</strong> Tipo da Imagem é Invalido.
    </div>';
  }elseif($_GET["img"] == "empty"){
    echo '<div class="alert alert-info">
    <strong>Informação!</strong> Você nao Selecionou a Imagem.
    </div>';
  }
  if($_GET["db"] == "erro"){
    echo '<div class="alert alert-danger">
    <strong>Perrigo!</strong> Erro ao salvar no Banco de Dados.
    </div>';
  }elseif($_GET["db"] == "empty"){
    echo '<div class="alert alert-info">
    <strong>Informação!</strong> Algum Campo obrigatorio vazio.
    </div>';
  }
  $html = '</br>
  <form id="function" name="Function" method="post" action="insert.php?page=functions" class="form-horizontal">
  <div class="form-group">
  <label for="functions_name" class="col-sm-3 control-label">Nome da Função</label>
  <div class="col-sm-4">
  <input type="text"  name="functions_name" class="form-control" id="functions_name" placeholder="Nome da Função">
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="admin" class="col-sm-3 control-label">Permição de Administrado?</label>
  <div class="col-sm-4">
  <select id="admin" name="admin" class="form-control">
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="eventos" class="col-sm-3 control-label">Permição de Eventos?</label>
  <div class="col-sm-4">
  <select id="eventos" name="eventos" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="coordenacao" class="col-sm-3 control-label">Permição de Coordenação?</label>
  <div class="col-sm-4">
  <select id="coordenacao" name="coordenacao" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="secretaria_de_pesquisa" class="col-sm-3 control-label">Permição de Secretaria de Pesquisa?</label>
  <div class="col-sm-4">
  <select id="secretaria_de_pesquisa" name="secretaria_de_pesquisa" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="financeiro" class="col-sm-3 control-label">Permição de Secretaria de Finaceiro?</label>
  <div class="col-sm-4">
  <select id="financeiro" name="financeiro" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="conselhos" class="col-sm-3 control-label">Permição de Secretaria de Conselhos?</label>
  <div class="col-sm-4">
  <select id="conselhos" name="conselhos" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="convenios" class="col-sm-3 control-label">Permição de Secretaria de Convenios?</label>
  <div class="col-sm-4">
  <select id="convenios" name="convenios" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="processos" class="col-sm-3 control-label">Permição de Secretaria de Processos?</label>
  <div class="col-sm-4">
  <select id="processos" name="processos" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="inventario" class="col-sm-3 control-label">Permição Inventario?</label>
  <div class="col-sm-4">
  <select id="inventario" name="inventario" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
  </div>
  <div class="col-sm-5"></div>
  </div>
  <div class="form-group">
  <label for="ramal" class="col-sm-3 control-label">Permição de Ramal?</label>
  <div class="col-sm-4">
  <select id="ramal" name="ramal" class="form-control" >
  <option value="0" select>Não</option>
  <option value="1">Sim</option>
  </select>
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
