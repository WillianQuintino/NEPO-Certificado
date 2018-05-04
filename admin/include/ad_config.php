<?php $title="Configuração do Grupos do Active Director";

// Inicia Conexão
$link = db_connection();

//busca
$rs = mysqli_query($link, "SELECT Id, ldap_gruops_name, ldap_gruops_ad_gruop, id_functions, ldap_hierarchy FROM ldap_groups order by ldap_hierarchy ASC") or die(mysql_error());

//Finaliza Conexão
db_close($link);
?>
<div class="panel panel-primary">
  <!-- Default panel contents -->
    <!-- Table -->
    <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo $title; ?></h4>
        <div class="btn-group pull-right">
          <a href="javascript:{}" onclick="document.getElementById('ad_config').submit(); return false;"><button type="button" class="btn btn-default"><i class="fas fa-save"></i> Salvar</button></a>
          <a href="index.php?page=add&form=ad_config"><button type="button" class="btn btn-default"><i class="fas fa-plus"></i> Adicionar</button></a>
        </div>
      </div>
    </br>
    <form id="ad_config" name="AD_Config" method="post" action="update.php?page=ad_config" class="form-horizontal">
<div  style="overflow: scroll; height: 100%; width: 100%">
    <table class="table" style="min-width: 1000px;">
      <thead>
        <tr>
          <th colspan="4"><i class="fas fa-arrows-alt"></i></th>
          <th colspan="4">Original</th>
          <th colspan="4">Nome</th>
          <th colspan="4">Grupo AD</th>
          <th colspan="4">ID da Função</th>
          <th colspan="4">Hierarquia</th>
          <th colspan="4"><i class="fas fa-trash"></i></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="4"><i class="fas fa-arrows-alt"></i></th>
          <th colspan="4">Original</th>
          <th colspan="4">Nome</th>
          <th colspan="4">Grupo AD</th>
          <th colspan="4">ID da Função</th>
          <th colspan="4">Hierarquia</th>
          <th colspan="4"><i class="fas fa-trash"></i></th>
        </tr>
      </tfoot>
      <tbody>
        <?php
        while(($row =  mysqli_fetch_assoc($rs))) {
          echo '<tr id="'.$row['ldap_hierarchy'].'">
          <th colspan="4"><i class="fas fa-arrows-alt"></i></th>
          <th colspan="4">'.$row['ldap_hierarchy'].'</th>
          <td colspan="4"><input type="text"  name="name'.$row['Id'].'" class="form-control" id="nome" placeholder="Nome" value="'.$row['ldap_gruops_name'].'"></td>
          <td colspan="4"><input type="text"  name="grupo_ad'.$row['Id'].'" class="form-control" id="grupoad" placeholder="Grupo AD" value="'.$row['ldap_gruops_ad_gruop'].'"></td>
          <td colspan="4"><select id="function" name="function'.$row['Id'].'" class="form-control" >"';
          datalist_functions($row['id_functions']);
          echo '</select></td>
          <td colspan="4"><textarea style="resize: none; height: 35px; width:105px  "  name="hierarquia'.$row['Id'].'" class="form-control" id="hierarquia" placeholder="ID">'.$row['ldap_hierarchy'].'</textarea></td>
          <td colspan="4"><a href="remove.php?page=ad_config&v='.new_encrypt($row['Id'], 'casa12').'" onclick="return confirm(\'Tem certeza que deseja deletar este registro?\')"><i class="fas fa-trash"></i></a></td>
          </tr>';
        }
        ?>
      </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="../src/js/table-order.js"></script>
    <?php
    //TODO Fazer um tabela que a ordenação seja em drop and down
    $link = db_connection();

    //busca
    $rs = mysqli_query($link, "SELECT id, functions_name, admin, eventos, coordenacao, secretaria_de_pesquisa, financeiro, conselhos, convenios, processos, inventario FROM functions") or die(mysql_error());

    //Finaliza Conexão
    db_close($link);
    ?>
  </div>
  </div>
</form>
</div>
