<html class=" -webkit-">
    <head>
        <!--PHP links-->
        <?php
          // php config
         include dirname(__FILE__)."/src/config/site.config";
         include dirname(__FILE__)."/src/config/db.config";
         // php include
         include dirname(__FILE__)."/src/include/functions/db.php";
        ?>

        <!-- Metas dados do Sites -->
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">

        <!-- CSS do Site-->
        <link rel="stylesheet" href="./src/css/style.css">
        <style media="" data-href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}</style>

        <!--Java Script do site-->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    </head>
    <body>
        <?php
            include dirname(__FILE__)."/src/include/login.php";
        ?>
        <script src="./src/js/script.js"></script>
        <script type="text/javascript">
          form = document.getElementById("Formulario");
          form.style.marginTop = (window.innerHeight-form.offsetHeight)/2+"px";
          Login.login.clicked=false;
          <?php
          if(isset($_GET['user'])) echo "Login.password.focus();";
          else echo "Login.username.focus();";
          ?>
          function CheckBlank(caller){
          if(Login.login.clicked){
            caller.style.outlineColor = "transparent";
            if(caller.id=="username") {
              document.getElementById("userError").innerHTML = "Digite o usuário<br/>";
              document.getElementById("userError").style.visibility = "hidden";
            }
            if(caller.id=="password") document.getElementById("passError").style.visibility = "hidden";
            if( caller.value.trim()=="" ){
              caller.style.outlineColor = "red";
              if(caller.id=="username") document.getElementById("userError").style.visibility = "visible";
              if(caller.id=="password") document.getElementById("passError").style.visibility = "visible";
              return false;
              }
          }
          }
          function CheckData(){
          Login.login.clicked=true;
          Login.username.focus();
          Login.password.focus();
          Login.login.focus();
          Login.login.clicked=false;
          if(Login.username.style.outlineColor == "red") {
            Login.username.focus();
            return false;
          }
          if(Login.password.style.outlineColor == "red") {
            Login.password.focus();
            return false;
          }
          return true;
          }
          function forgotPassword(caller){
          Login.login.clicked=true;
          Login.username.focus();
          caller.focus();
          Login.login.clicked=false;
          if(Login.username.style.outlineColor == "red") {
            Login.username.focus();
            return false;
          }

          url="lostPassword.php?user="+Login.username.value;
          if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
          else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          xmlhttp.addEventListener("load", function(){//executar quando acabar
            switch(caller.result){
              case "FullResult":
                document.getElementById("Formulario").innerHTML =
                "<span class='legenda_campos2'>Um e-mail para a recuperação de <br/>senha foi enviado para o E-mail cadastrado</span><br/>";
                document.getElementById("Formulario").innerHTML +=
                '<br/><input class="btn_login" type="button" value="Voltar" onclick="window.location.assign(\'./\')" />';
                break;
              case "EmptyResult":
                document.getElementById("userError").innerHTML = "Entre em contato com o NEPO para recuperar a senha";
                document.getElementById("userError").style.visibility = "visible";
                break;
              case "NoResult":
                document.getElementById("userError").innerHTML = "Este usuário não está cadastrado";
                document.getElementById("userError").style.visibility = "visible";
                break;
              case "EmptyUser":
                document.getElementById("userError").style.visibility = "visible";
                break;
              default:
                alert(caller.result);
            }
          }, false);
          xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
              caller.result = xmlhttp.responseText;
          }
          xmlhttp.open("GET",url,true);
          xmlhttp.send();
          return false;
          }
          </script>
    </body>
</html>
