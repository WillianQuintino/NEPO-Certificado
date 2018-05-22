<?php
header("Content-Type: text/html;charset=".CHARSET);
//Função para Coneção no db
function db_connection(){
  //Recebe variaveis derinidas em ../config/db-config.php.
  $host       = DB_HOST;
  $password   = DB_PASSWORD;
  $user       = DB_USER;
  $db         = DB_NAME;

  //efetua conecção no db e retona o acesso para variavel $link
  error_reporting(E_ERROR | E_PARSE);
  $link = mysqli_connect($host, $user, $password, $db);

  //Busca o Charset da pagina e aplica
  $rs = mysqli_query($link, "SELECT config_value FROM config_site WHERE Id='7'") or die(mysql_error());
  $rs = mysqli_fetch_array($rs);
  $rs['config_value'] = str_replace("-", "", $rs['config_value']);
  mysqli_set_charset($link, $rs['config_value']);

  return $link;
}
//Fecha conexão com banco de dados
function db_close($link){
  $check = mysqli_close ($link);

  if($check === FALSE){
    logoff("index.php?erro=dbconection&e=close");
  }

  return $check;
}
//Função para listar tabela institution para datalist
function datalist_institution(){
  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT institution FROM institution order by institution asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    echo "<option>".$row['institution']. "</option>";
  }
  db_close($link);
}
//Função para listar language institution para datalist
function datalist_language(){
  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT DISTINCT language FROM event_model_certificate order by language asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    echo "<option>".$row['language']. "</option>";
  }
  db_close($link);
}
//Função para listar tabela funçoes para functions
function datalist_functions($function_id){

  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT id, functions_name FROM functions order by functions_name asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    if($function_id == $row['id']){
      $select = 'selected';
    }else{
      $select = '';
    }
    echo '<option value="'.$row['id'].'" '.$select.'>'.utf8_encode($row['functions_name']).'</option>';
  }
  db_close($link);
}
//Função para listar tabela funçoes para functions
function datalist_charset(){
  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT charset FROM charset order by charset asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    echo "<option>".$row['charset']. "</option>";
  }
  db_close($link);
}
//Função para listar tabela funçoes para functions
function datalist_time_zones(){

  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT time_zones FROM time_zones order by time_zones asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    echo "<option>".$row['time_zones']. "</option>";
  }
  db_close($link);
}
function datalist_color_event($id){

  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT Id, color_code, event_name FROM type_event order by event_name asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    echo '<option style="color: '.$row['color_code'].';" value="'.$row['Id'].'" '.$select.'>'.$row['event_name'].'</option>';
  }
  db_close($link);
}
function datalist_organizer($data){
  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT id_user, name FROM user WHERE organizer='1' order by name asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    echo '<option value="'.$row['id_user'].'" '.$select.'>'.$row['name'].'</option>';
  }
  echo "<script>$('#organizer').selectpicker('val',[".$data[0].','.$data[1].','.$data[2]."]);</script>";
  db_close($link);
}
function datalist_user_type_certificate($data){
  //Inicia conexão com o db
  $link = db_connection();

  //busca
  $rs = mysqli_query($link, "SELECT Id, name FROM user_type_certificate order by name asc") or die(mysql_error());

  while( $row = mysqli_fetch_array($rs))
  {
    echo '<option value="'.$row['Id'].'" '.$select.'>'.$row['name'].'</option>';
  }
  echo "<script>$('#type').selectpicker('val',".$data.");</script>";
  db_close($link);
}
function list_type_certificate($id_event, $id_user, $indice){
  $link = db_connection();
  //busca
  $rs = mysqli_query($link, "SELECT Id, name FROM user_type_certificate order by name asc") or die(mysql_error());
  echo '<select id="user'.$indice.'" class="selectpicker" data-live-search="true" placeholder="Selecione o tipo" name="user['.$indice.'][type]">';
  while( $row = mysqli_fetch_array($rs))
  {
    echo '<option value="'.$row['Id'].'" '.$select.'>'.$row['name'].'</option>';
  }
  echo '</select>';
  $rs1 = mysqli_query($link, "SELECT `id_type_certificate` FROM `user_presence` WHERE `id_user` = ".$id_user." AND `id_event` = '".$id_event."' ORDER BY date LIMIT 1") or die(mysql_error());
  while ($row1 = mysqli_fetch_array($rs1)) {
    echo "<script>$('#user".$indice."').val('".$row1['id_type_certificate']."');</script>";
  }
  db_close($link);
}
function checked_date_type_certificate($id_event, $id_user, $date){
  $link = db_connection();
  $rs1 = mysqli_query($link, "SELECT `id_user` FROM `user_presence` WHERE `id_user` = ".$id_user." AND `id_event` = '".$id_event."' AND `date`= '".$date."' LIMIT 1") or die(mysql_error());
  while ($row1 = mysqli_fetch_array($rs1)) {
    if(isset($row1['id_user'])){
      return 'checked';
    }else {
      return '';
    }
  }
  db_close($link);
}
function organizerformate($organizer){
  $organizer = unserialize($organizer);
  $rs = "";
  $link = db_connection();
  if(!($organizer[0] == "")){
    $row = mysqli_fetch_array(mysqli_query($link, "SELECT name FROM user WHERE id_user=".$organizer[0]));
    $rs .= $row['name'];
  }
  if(!($organizer[1] == "")){
    $row = mysqli_fetch_array(mysqli_query($link, "SELECT name FROM user WHERE id_user=".$organizer[1]));
    $rs .= ", <br />".$row['name'];
  }
  if(!($organizer[2] == "")){
    $row = mysqli_fetch_array(mysqli_query($link, "SELECT name FROM user WHERE id_user=".$organizer[2]));
    $rs .= ", <br />".$row['name'];
  }
  db_close($link);
  return $rs;
}
//Função para listar tabela Usuário
function tablelist_users($field, $ord, $param, $search_value, $maxpage, $page){
  //cria o inicio do link
  $endereco = explode("/",$_SERVER ['REQUEST_URI']);
  $url = SITE_URL.$endereco[2]."/index.php?page=users";

  //verifica se foi setado variavel na url
  if(isset($maxpage)){
    $url .= "&item=".$maxpage;
  }
  if(isset($page)){
    $url .= "&p=".$page;
  }
  //Inicia conexão com o db
  $link = db_connection();

  $ico = '<i class="fa fa-sort" aria-hidden="true"></i>';
  $name_ico = $ico;
  $user_ico = $ico;
  $email_ico = $ico;
  $institution_ico = $ico;
  $function_ico = $ico;
  $date_ts_ico = $ico;
  $user_active_ico = $ico;
  $sendMailException_ico = $ico;

  $ord_name = 'asc';
  $ord_name = $ord_name;
  $ord_user = $ord_name;
  $ord_email = $ord_name;
  $ord_institution = $ord_name;
  $ord_function = $ord_name;
  $ord_date_ts = $ord_name;
  $ord_user_active = $ord_name;
  $ord_sendMailException = $ord_name;

  //verifica se tem valores na variavel e atribui code sql na variavel '$ordem'
  if(isset($field) and isset($ord)){
    $ordem = "order by ".$field." ".$ord;

    if($ord == "asc"){
      $ord_type = "-up";
    }elseif($ord == "desc"){
      $ord_type = "-down";
    }else{
      $ord="";
    }

    if($field === "name"){
      $name_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_name = 'desc';
      }else{
        $ord_name = 'asc';
      }
    }elseif($field === "user"){
      $user_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_user = 'desc';
      }else{
        $ord_user = 'asc';
      }
    }elseif($field === "email"){
      $email_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_email = 'desc';
      }else{
        $ord_email = 'asc';
      }
    }elseif($field === "institution"){
      $institution_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_institution = 'desc';
      }else{
        $ord_institution = 'asc';
      }
    }elseif($field === "function"){
      $function_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_function = 'desc';
      }else{
        $ord_function = 'asc';
      }
    }elseif($field === "date_ts"){
      $date_ts_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_date_ts = 'desc';
      }else{
        $ord_date_ts = 'asc';
      }
    }elseif($field === "user_active"){
      $user_active_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_user_active = 'desc';
      }else{
        $ord_user_active = 'asc';
      }
    }elseif($field === "sendMailException"){
      $sendMailException_ico = '<i class="fa fa-sort'.$ord_type.'" aria-hidden="true"></i>';
      if($ord === "asc"){
        $ord_sendMailException = 'desc';
      }else{
        $ord_sendMailException = 'asc';
      }
    }
  }else{
    $ordem = "ORDER BY `name`";
  }
  if(isset($param) and isset($search_value)){
    if($param === 'all'){
      $search = "WHERE user LIKE '%".$search_value."%' OR name LIKE '%".$search_value."%' OR email LIKE '%".$search_value."%' OR institution LIKE '%".$search_value."%'";
    }elseif($param === 'id_user'){
      $search = "WHERE id_user LIKE '".$search_value."'";
    }else{
      $search = "WHERE ".$param." LIKE '%".$search_value."%' ";
    }
    $ord_name = $ord_name.'&search_param='.$param.'&search='.$search_value;
    $ord_user = $ord_user.'&search_param='.$param.'&search='.$search_value;
    $ord_email = $ord_email.'&search_param='.$param.'&search='.$search_value;
    $ord_institution = $ord_institution.'&search_param='.$param.'&search='.$search_value;
    $ord_function = $ord_function.'&search_param='.$param.'&search='.$search_value;
    $ord_date_ts = $ord_date_ts.'&search_param='.$param.'&search='.$search_value;
    $ord_user_active = $ord_user_active.'&search_param='.$param.'&search='.$search_value;
    $ord_sendMailException = $ord_sendMailException.'&search_param='.$param.'&search='.$search_value;
  }else{
    $search = "";
  }
  //verifica se $page Foi setado senao seta 1
  if($page == ""){
    $page = 1;
  }
  //verifica se $maxpage Foi setado senao seta 50
  if($maxpage == ""){
    $maxpage = 10;
  }
  //conta usuario db
  $rs = mysqli_query($link, "SELECT id_user, user, name, email, institution, function, ramal, date_ts, extra_information, user_active, sendMailException FROM user ".$search.$ordem) or die(mysql_error());
  $usercont = mysqli_num_rows($rs);
  //busca
  $rs = mysqli_query($link, "SELECT id_user, user, name, email, institution, function, ramal, date_ts, extra_information, user_active, sendMailException FROM user ".$search.$ordem." LIMIT ".($page-1) * $maxpage.", ".$maxpage) or die(mysql_error());
  echo '<table class="table">
  <thead>
  <tr>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=name&ord='.$ord_name.'">Nome '.$name_ico.'</a></th>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=user&ord='.$ord_user.'">Username '.$user_ico.'</a></th>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=email&ord='.$ord_email.'">Email '.$email_ico.'</a></th>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=institution&ord='.$ord_institution.'">Intituição '.$institution_ico.'</a></th>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=function&ord='.$ord_function.'">Função '.$function_ico.'</a></th>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=date_ts&ord='.$ord_date_ts.'">Data de Inscrição '.$date_ts_ico.'</a></th>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=user_active&ord='.$ord_user_active.'">Ativo? '.$user_active_ico.'</a></th>
  <th scope="col"><a class="nav-link" href="'.$url.'&field=sendMailException&ord='.$ord_sendMailException.'"><i class="fa fa-bell" aria-hidden="true"></i>'.$sendMailException_ico.'</a></th>
  <th scope="col"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></i></th>
  <th colspan="4"><i class="fas fa-trash"></i></th>
  </tr>
  </thead>
  <tbody>';

  while(($row =  mysqli_fetch_assoc($rs))) {
    if ($row['user_active'] === "0"){
      $user_active = '<spam style="color: red;"><i class="fa fa-times-circle" aria-hidden="true"></i></spam>';
    }else{
      $user_active = '<spam style="color: green;"><i class="fa fa-check-circle" aria-hidden="true"></i></spam>';
    }
    if ($row['sendMailException'] === "0"){
      $sendMailException = '<i class="fa fa-bell-slash" aria-hidden="true"></i>';
    }else{
      $sendMailException = '<i class="fa fa-bell" aria-hidden="true"></i>';
    }
    echo '<tr>
    <td>'.$row['name'].'</td>
    <td>'.$row['user'].'</td>
    <td>'.$row['email'].'</td>
    <td>'.$row['institution'].'</td>
    <td>'.functionsname($row['function']).'</td>
    <td>'.$row['date_ts'].'</td>
    <td>'.$user_active.'</td>
    <td>'.$sendMailException.'</td>
    <td><a class="nav-link" href="'.SITE_URL.'admin/index.php?page=edit&type=profile&id='.$row['id_user'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
    <td colspan="4"><a href="remove.php?page=profile&v='.new_encrypt($row['id_user'], 'casa12').'" onclick="return confirm(\'Tem certeza que deseja deletar este registro?\')" ><i class="fas fa-trash"></i></a></td>
    </tr>';
  }
  echo  '</tbody>
  </table>';

  db_close($link);
  return $usercont;
}
function functionsname($functionid){
  $link = db_connection();
  $rs = mysqli_query($link, "SELECT functions_name FROM functions WHERE Id='".$functionid."'") or die(mysql_error());
  $row = mysqli_fetch_assoc($rs);
  db_close($link);
  return $row['functions_name'];
}
function config_ad($link, $config_name){
  if(!$link){
    mysqli_close($link);
    logoff("index.php?erro=dbconection");
  }else{
    $sql = "SELECT `config_value` FROM `config_site` WHERE config_name='" . $config_name . "'";
    $sql = mysqli_query($link, $sql);
    if(isset($sql)){
      $rs  = mysqli_fetch_array($sql);
    }else{
      $rs['config_value'] = false;
    }
  }
  return $rs['config_value'];
}

function verified_institution($link, $institution){
  // buasca a instituição no banco de dados "institution"
  $rs_institution = mysqli_query($link, "SELECT institution FROM institution where institution='".$institution."'") or die(mysql_error());
  $rs_institution  = mysqli_fetch_array($rs_institution);

  // buasca a instituição no banco de dados "institution_new"
  $rs_institution_new = mysqli_query($link, "SELECT institution FROM institution_new where institution='".$institution."'") or die(mysql_error());
  $rs_institution_new  = mysqli_fetch_array($rs_institution_new);

  //insere instituições que nao existe nos bancos de dados
  if(!isset($rs_institution['institution']) and !isset($rs_institution_new['institution'])){
    mysqli_query($link, "INSERT INTO `institution_new`(`Id`, `institution`) VALUES (Null,'".$institution."')") or die(mysql_error());
  }
}
function verified_registration($event_id){
  $sql = "SELECT * FROM registration where id_user = ".$_SESSION['id']." AND id_event = ".$event_id;
  $link = db_connection();
  $rs = mysqli_query($link,$sql);
  db_close($link);
  $cont = mysqli_num_rows($rs);
  if($cont >= 1){
    return true;
  }else{
    return false;
  }
}
function verified_event_date($event_id){
  $sql = "SELECT start_event, end_event, end_time FROM event where id = ".$event_id;
  $link = db_connection();
  $rs = mysqli_query($link,$sql);
  $data = date("Y-m-d");
  $time = date("H:i:s");
  db_close($link);
  $row = mysqli_fetch_array($rs);
  if($row[end_event] == "0000-00-00"){
    if(($data <= $row['start_event'])){
      if($data == $row['start_event'] AND $time >= $row['end_time']){
        return false;
      }else{
        return true;
      }
    }else{
      return false;
    }
  }else{
    if(($data <= $row['end_event'])){
      if($data == $row['end_event'] AND $time >= $row['end_time']){
        return false;
      }else{
        return true;
      }
    }else{
      return false;
    }
  }
}
?>
