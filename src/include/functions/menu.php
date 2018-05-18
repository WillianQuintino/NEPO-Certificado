<?php
function menuDefault($link, $id_function, $activePage){
  $rs = mysqli_fetch_array(mysqli_query($link, "SELECT eventos, coordenacao, secretaria_de_pesquisa, financeiro, conselhos, convenios, processos, inventario  FROM `functions` WHERE id='".$id_function."'"));
  echo '
  <ul class="nav navbar-nav">
  <li ';
  if($activePage === 'default')echo 'class="active"';
  echo '><a href="'.SITE_URL.'home.php">Home <span class="sr-only">(current)</span></a></li>
  <li ';
  if($activePage === 'eventos')echo 'class="active dropdown"';
  echo '>
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Eventos <span class="caret"></span></a>
  <ul class="dropdown-menu">
  <li><a href="'.SITE_URL.'event/index.php?page=registration">Inscrições abertas</a></li>';

  if(checkuser($link, 'eventos', $id_function)){
    echo '
    <li><a href="'.SITE_URL.'event/index.php?page=create">Criar</a></li>
    <li><a href="'.SITE_URL.'event/index.php?page=event">Administrar</a></li>';
  }
  echo '
  </ul>
  </li>';
  if(checkuser($link, 'eventos', $id_function)){
    echo '<li ';
    if($activePage === 'certificados')echo 'class="active"';
    echo '><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Certificados <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><a href="'.SITE_URL.'certificates/index.php?page=download">Download</a></li>
    <li><a href="'.SITE_URL.'certificates/index.php?page=model">Modelos de Eventos</a></li>
    <li><a href="'.SITE_URL.'certificates/index.php?page=type">Tipos de Participantes</a></li>
    </ul>';
  }else{
    echo '<li ';
    if($activePage === 'certificados')echo 'class="active"';
    echo '><a href="#">Certificados</a></li>';
  }
  echo '<li ';
  if($activePage === 'contacts')echo 'class="active"';
  echo '><a href="'.SITE_URL.'home.php?page=contacts">Contatos</a></li>';
  if (checkuser($link, 'coordenacao', $id_function) or checkuser($link, 'secretaria_de_pesquisa', $id_function) or checkuser($link, 'financeiro', $id_function)){
    echo  '
    <li ';
    if($activePage === 'oficio')echo 'class="active dropdown"';
    echo '>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Oficio <span class="caret"></span></a>
    <ul class="dropdown-menu">';
    if(checkuser($link, 'coordenacao', $id_function)){
      echo '
      <li><a href="#">Coordenação</a></li>
      ';
    }
    if(checkuser($link, 'secretaria_de_pesquisa', $id_function)){
      echo '
      <li><a href="#">Secretaria de Pesquisa</a></li>
      ';
    }
    if(checkuser($link, 'financeiro', $id_function)){
      echo '
      <li><a href="#">Financeiro</a></li>
      ';
    }
    echo '
    </ul>
    </li>';
  }
  if(checkuser($link, 'conselhos', $id_function)){
    echo '<li ';
    if($activePage === 'conselhos')echo 'class="active"';
    echo '><a href="#">Conselhos</a></li>';
  }
  if(checkuser($link, 'convenios', $id_function)){
    echo '<li ';
    if($activePage === 'convenios')echo 'class="active"';
    echo '><a href="#">Convenios</a></li>';
  }
  if(checkuser($link, 'processos', $id_function)){
    echo '<li ';
    if($activePage === 'processos')echo 'class="active"';
    echo '><a href="#">Processos</a></li>';
  }
  if(checkuser($link, 'inventario', $id_function)){
    echo '<li><a href="http://www.nepo.unicamp.br/inventario/new_site/inventario/manutencao_index.html">Inventario</a></li>';
  }
  echo '</ul>';
}
function menuUser($link, $id_function, $activePage, $name){
  echo'
  <ul class="nav navbar-nav navbar-right">
  <li ';
  if($activePage === 'user')echo 'class="dropdown active"';
  echo '>
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$name.' <span class="caret"></span></a>
  <ul class="dropdown-menu">
  <li><a href="'.SITE_URL.'profile/index.php">Atualizar Informações</a></li>';
  if(checkuser($link, 'admin', $id_function)){
    echo '<li><a href="'.SITE_URL.'admin/index.php">Administrar</a></li>';
  }
  echo'
  <li role="separator" class="divider"></li>
  <li><a href="'.SITE_URL.'logoff.php">Logoff</a></li>
  </ul>
  </li>
  </ul>';
}
function menu($link, $id_function, $activePage, $name){
  echo '<nav class="navbar navbar-default">
  <div class="container-fluid">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
  <span class="sr-only">Toggle navigation</span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#"><img src="http://www.nepo.unicamp.br/images/unicamp_nepo35c.png" width="125" height="70"></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">';
  menuDefault($link, $id_function, $activePage);
  menuUser($link, $id_function, $activePage, $name);
  echo'
  </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  </nav>
  ';
}
function rollPageId($link, $data, $namedb, $nameid, $pageurl){

  $rs = mysqli_query($link, "SELECT * FROM ".$namedb) or die(mysql_error());
  while(($row =  mysqli_fetch_assoc($rs))) {
    $maxid = $row[$nameid];
  }
  ?>
  <a href="<?php echo SITE_URL.$pageurl.($_GET[$nameid]-1).'&b=back'; ?>" class="btn btn-default <?php if($_GET["id"] <= 1) echo 'disabled'?>" >< Anterior</a>
  <a href="<?php echo SITE_URL.$pageurl.($_GET[$nameid]+1).'&b=next'; ?>" class="btn btn-default <?php if($_GET["id"] >= $maxid) echo 'disabled'?>">Proximo ></a>
  <?php
  if(!isset($data) AND $_GET["b"] == 'back' AND $_GET["id"] > 1){
    $url = SITE_URL.$pageurl.($_GET["id"]-1).'&b=back';
    echo "<script>window.location.href = '".$url."';</script>";
  }
  if(!isset($data) AND $_GET["b"] == 'next' AND $_GET["id"] < $maxid){
    $url = SITE_URL.$pageurl.($_GET["id"]+1).'&b=next';
    echo "<script>window.location.href = '".$url."';</script>";
  }
  if(!isset($data) AND $_GET["b"] == 'next' OR $_GET["id"] > $maxid){
    $url = SITE_URL.$pageurl.($_GET["id"]-1).'&b=back';
    echo "<script>window.location.href = '".$url."';</script>";
  }
  if(!isset($data) AND $_GET["b"] == 'back' OR $_GET["id"] < 1){
    $url = SITE_URL.$pageurl.($_GET["id"]+1).'&b=next';
    echo "<script>window.location.href = '".$url."';</script>";
  }
}
function pagination($total, $getpage, $itempage, $page, $field, $ord, $param, $search_value){

  //cria o inicio do link
  $endereco = explode("/",$_SERVER ['REQUEST_URI']);
  $php_name = explode("?",$endereco[3]);
  $link = SITE_URL.$endereco[2]."/".$php_name[0]."?";
  if(isset($getpage)){
    $link .= "page=".$getpage."&";
  }

  //verifica se foi setado variavel na url
  if(isset($field)){
    $link .= "field=".$field."&";
  }
  if(isset($ord)){
    $link .= "ord=".$ord."&";
  }
  if(isset($param)){
    $link .= "search_param=".$param."&";
  }
  if(isset($search_value)){
    $link .= "search=".$search_value."&";
  }

  //se tiver vasil a variavel $itempage ou $page seta um valot padrão
  if(empty($itempage)){
    $itempage = 10;
  }
  if(empty($page)){
    $page = 1;
  }
  //amazena pagina sem ateração
  $pageold = $page;
  //faz a divizão e arendonta inteiro para cima
  $pagination = ceil($total/$itempage);

  //seta paginação para 6 e for menor que 6
  if($page < 7){
    $page = 7;
  }
  //seta paginação para sete e for menor que 45 se formaior que 45
  if($page > 46){
    $page = 46;
  }
  echo '    <nav aria-label="Page navigation">
  <ul class="pagination">';
  //inicia o Laço de repetição começando 5 antes da pagina atual e finaliza 5 depois
  for ($i = $page-5; $i <= $page+5; $i++) {
    if($i == $page-5){
      if( 1 >= $pageold){
        echo '<li class="disabled"><a href="">Previous</a></li>';
      } else{
        echo '<li><a href="'.$link.'item='.$itempage.'&p='.($page-1).'">Previous</a></li>';
      }
      if($i >= 3){
        echo '<li><a href="'.$link.'item='.$itempage.'&p=1">1</a></li><li class="disabled"><a>...</a></li>';
      }elseif($pageold == 1){
        echo '<li class="active"><a href="">1</a></li>';
      }else{
        echo '<li><a href="'.$link.'item='.$itempage.'&p=1">1</a></li>';
      }
    }
    if($i >= 2 AND $i <= $pagination-1){
      if($pageold == $i){
        echo '<li class="active"><a href="">'.$i.'</a></li>';
      }else{
        echo '<li><a href="'.$link.'item='.$itempage.'&p='.$i.'">'.$i.'</a></li>';
      }
    }
    if($i == $page+5){
      if($i <= $pagination-2){
        echo '<li class="disabled"><a>...</a></li><li><a href="'.$link.'item='.$itempage.'&p='.$pagination.'">'.$pagination.'</a></li>';
      }elseif($pageold == $pagination AND $pagination >= 2){
        echo '<li class="active"><a href="">'.$pagination.'</a></li>';
      }elseif($pagination >= 2){
        echo '<li><a href="'.$link.'item='.$itempage.'&p='.$pagination.'">'.$pagination.'</a></li>';
      }
      if($pageold < $pagination){
        echo '<li><a href="'.$link.'item='.$itempage.'&p='.($page+1).'">Next</a></li>';
      }else {
        echo '<li class="disabled"><a href="">Next</a></li>';
      }
    }
  }
  echo '</ul>
  </nav>';
}
function subdate($data1, $data2){
  if($data1 == "0000-00-00" OR $data2 == "0000-00-00"){
    //echo "Entre as duas datas informadas, existem 1 dia.";
    return 1;
  }else{
    // converte as datas para o formato timestamp
    $d1 = strtotime($data1);
    $d2 = strtotime($data2);
    // verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
    $dataFinal = ($d2 - $d1) /86400;
    // caso a data 2 seja menor que a data 1
    if($dataFinal < 0)
    $dataFinal = $dataFinal * -1;
    //echo "Entre as duas datas informadas, existem $dataFinal dias.";
    return $dataFinal;
  }
}
?>
