<?php $title="Funções"; ?>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo $title; ?></h4>
    <div class="btn-group pull-right">
      <a href="index.php?page=add&form=functions" class="btn btn-default btn-sm"><i class="fas fa-plus"></i> Nova Função</a>
    </div>
  </div>

  <div style="overflow-x:scroll;">
    <?php

    // Inicia Conexão
    $link = db_connection();

    //busca
    $rs = mysqli_query($link, "SELECT id, functions_name, admin, eventos, coordenacao, secretaria_de_pesquisa, financeiro, conselhos, convenios, processos, inventario, ramal FROM functions") or die(mysql_error());

    //Finaliza Conexão
    db_close($link);
    ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col" align=center>Nome da Função</th>
          <th scope="col" align=center>Admin</th>
          <th scope="col" align=center>Eventos</th>
          <th scope="col" align=center>Coordenação</th>
          <th scope="col" align=center>Secretaria de Pesquisa</th>
          <th scope="col" align=center>Finaceiro</th>
          <th scope="col" align=center>Conselhos</th>
          <th scope="col" align=center>Convenios</th>
          <th scope="col" align=center>Processos</th>
          <th scope="col" align=center>Inventario</th>
          <th scope="col" align=center>Ramal</th>
          <th scope="col"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></i></th>
          <th colspan="4"><i class="fas fa-trash"></i></th>
        </tr>
      </thead>
      <tbody>
        <?php
        while(($row =  mysqli_fetch_assoc($rs))) {
          if($row['id'] > 0 ){
            echo '<tr>
            <td>'.$row['functions_name'].'</td>
            <td>'.active($row['admin']).'</td>
            <td>'.active($row['eventos']).'</td>
            <td>'.active($row['coordenacao']).'</td>
            <td>'.active($row['secretaria_de_pesquisa']).'</td>
            <td>'.active($row['financeiro']).'</td>
            <td>'.active($row['conselhos']).'</td>
            <td>'.active($row['convenios']).'</td>
            <td>'.active($row['processos']).'</td>
            <td>'.active($row['inventario']).'</td>
            <td>'.active($row['ramal']).'</td>
            <td><a class="nav-link" href="'.SITE_URL.'admin/index.php?page=edit&type=function&id='.$row['id'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>';
            if($row['id'] > 1 ){
              echo '<td colspan="4"><a href="remove.php?page=function&v='.new_encrypt($row['id'], 'casa12').'" onclick="return confirm(\'Tem certeza que deseja deletar este registro?\')"><i class="fas fa-trash"></i></a></td>';
            }else{
              echo '<td colspan="4"><i class="fas fa-trash"></i></td>';
            }
          }

          echo '</tr>';
        }
        function active($input){
          if ($input === "0"){
            $code = '<spam style="color: red;"><i class="fa fa-times-circle" aria-hidden="true"></i></spam>';

          }else{
            $code = '<spam style="color: green;"><i class="fa fa-check-circle" aria-hidden="true"></i></spam>';
          }
          return $code;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
