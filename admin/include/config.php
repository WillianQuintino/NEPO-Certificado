<?php
$title="Configuração do Site";

//TODO Fazer um tabela que a ordenação seja em drop and down
$link = db_connection();

//busca
$grups = mysqli_query($link, "SELECT DISTINCT config_group FROM config_site") or die(mysql_error());
//inicia array para salvar tipo de grupos
$config_grups = array();

$j = 0;
while(($row =  mysqli_fetch_assoc($grups))) {
  $config_grups[$j] = $row['config_group'];
  $j++;
}

for($i=0; $i < count($config_grups); $i++){
  $post_name = "";
  $config_site = mysqli_query($link, "SELECT * FROM config_site WHERE config_group='".$config_grups[$i]."'") or die(mysql_error());
  ?>
  <div class="col-md-4">
    <div class="panel panel-primary">
      <!-- Default panel contents -->
      <div class="panel-heading"><?php echo $config_grups[$i] ?></div>
      <!-- Table -->
      <div style="height: 500px; padding:10px">
      </br>
      <form id="<?php echo $config_grups[$i] ?>" name="<?php echo $config_grups[$i] ?>" method="post" action="update.php?page=config" class="form-horizontal">
        <?php while(($row =  mysqli_fetch_assoc($config_site))) {?>
          <div class="form-group">
            <label for="<?php echo $row['config_name'];?>" class="col-sm-6 control-label"><?php echo $row['config_fullname'];?></label>
            <div class="col-sm-6">
              <input list="" type="text"  name="<?php echo $row['config_name'];?>" class="form-control <?php echo $row['mask'];?>" id="<?php echo $row['config_name'];?>" placeholder="<?php echo $row['config_fullname'];?>" min="" max="" value="<?php if(isset($row['config_value'])) echo $row['config_value']; ?>">
              <?php
              if($row['mask'] == "charset"){
                echo '<datalist id="charset">';
                datalist_charset();
                echo '</datalist>';
              }elseif($row['mask'] == "time_zone"){
                echo '<datalist id="time_zone">';
                datalist_time_zones();
                echo '</datalist>';
              }
              ?>
            </div>
          </div>
          <?php
          $post_name = $row['config_name'].'|'.$post_name;
        }
        ?>
        <input type="text"  name="config_name" class="form-control" id="config_name" value="<?php echo $post_name; ?>" style="display: none">

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Salvar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
}
//Finaliza Conexão
db_close($link);
?>
