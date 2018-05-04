<?php $title="Usuários"; ?>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading ">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo $title; ?> <span id="count" class="badge"></span></h4></div>
        <div class="col-sm-6">
          <form role="search" method="get" action="http://www.nepo.unicamp.br/dev/admin/index.php?page=users">
            <div class="input-group">
              <div class="input-group-btn search-panel">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <span id="search_concept">Filtrar Por</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#id_user" type="number">ID</a></li>
                  <li><a href="#name" type="text">Nome</a></li>
                  <li><a href="#user" type="text">Usuário</a></li>
                  <li><a href="#email" type="email">Email</a></li>
                  <li><a href="#institution" type="text">Instituição</a></li>
                  <li class="divider"></li>
                  <li><a href="#all" type="text">Todos</a></li>
                </ul>
              </div>
              <div class="input-group-btn quantity-panel">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <span id="quantity_items">Itens por Pagina</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#10">10</a></li>
                  <li><a href="#20">20</a></li>
                  <li><a href="#30">30</a></li>
                  <li><a href="#40">40</a></li>
                  <li><a href="#50">50</a></li>
                </ul>
              </div>
              <input type="hidden" name="item" value="10" id="item">
              <input type="hidden" name="search_param" value="all" id="search_param">
              <input type="text" list="" name="search" class="form-control" id="search" placeholder="Pesquise..." onkeypress="" value="<?php if($_GET["search"] == '')echo ''; else echo $_GET["search"]; ?>">
              <datalist id="institution">
                <?php datalist_institution(); ?>
              </datalist>
              <div class="input-group-btn">
                <button class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div >

      <?php
      //gera lista de usuarios
      $usercont = tablelist_users($_GET["field"], $_GET["ord"], $_GET["search_param"], $_GET["search"], $_GET["item"], $_GET["p"]);
      //gera a paginação
      pagination($usercont, $_GET["page"], $_GET["item"], $_GET["p"], $_GET["field"], $_GET["ord"], $_GET["search_param"], $_GET["search"])
      ?>
    </div>
  </div>
  <script>
  object = $('.search-panel .dropdown-menu li a').toArray();
  var search_param = '<?php echo $_GET["search_param"]; ?>';
  if(!(typeof search_param == "undefined")){
    for (var i = 0; i < object['length']; i++) {
      if(search_param == object[i]['hash'].replace("#","")){
        $('.search-panel span#search_concept').text(object[i]['text']);
        $('.input-group #search_param').val(object[i]['hash'].replace("#",""));
        document.getElementById('search').type = object[i]['type'];
        if(object[i]['type'] == 'number'){
          document.getElementById('search').setAttribute("onkeypress", "return isNumberKey(event)");
        }
        if(object[i]['hash'].replace("#","") == 'institution'){
          document.getElementById('search').setAttribute("list", "institution");
        }
      }
    }
  }
  $(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
      e.preventDefault();
      var param = $(this).attr("href").replace("#","");
      var type = $(this).attr("type");
      var concept = $(this).text();
      $('.search-panel span#search_concept').text(concept);
      $('.input-group #search_param').val(param);
      document.getElementById('search').type = type;
      if(param == "institution"){
        document.getElementById('search').setAttribute("list", "institution");
      }else{
        document.getElementById('search').setAttribute("list", "");
      }
      if(type == "number"){
        document.getElementById('search').setAttribute("onkeypress", "return isNumberKey(event)");
      }else{
        document.getElementById('search').setAttribute("onkeypress", "");
      }
    });
  });
  object1 = $('.quantity-panel .dropdown-menu li a').toArray();
  var quantity_items = '<?php echo $_GET["item"]; ?>';
  if(!(typeof quantity_items == "undefined")){
    for (var i = 0; i < object1['length']; i++) {
      if(quantity_items == object1[i]['hash'].replace("#","")){
        $('.quantity-panel span#quantity_items').text(object1[i]['text']);
        $('.input-group #item').val(object1[i]['hash'].replace("#",""));
      }
    }
  }
  $(document).ready(function(e){
    $('.quantity-panel .dropdown-menu').find('a').click(function(e) {
      e.preventDefault();
      var param = $(this).attr("href").replace("#","");
      var concept = $(this).text();
      $('.quantity-panel span#quantity_items').text(concept);
      $('.input-group #item').val(param);

    });
  });
  document.getElementById("count").innerHTML = "<?php echo $usercont; ?>";
  function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }
</script>
<script src="..\src\js\script.js"></script>
