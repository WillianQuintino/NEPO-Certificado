<script>
function validarSenha(){
NovaSenha = document.getElementById('passwordPost').value;
CNovaSenha = document.getElementById('cPasswordPost').value;
if (NovaSenha != CNovaSenha) {
  alert("SENHAS DIFERENTES!\nFAVOR DIGITAR SENHAS IGUAIS");
}else{
  document.FormSenha.submit();
}
}
    </script>
<div class="flat-form">
  <ul class="tabs">
    <li>
      <a href="#login" class="active" onclick="setTitle('Login');">Login</a>
    </li>
    <li>
      <a href="#register" onclick="setTitle('Register');">Register</a>
    </li>
    <li>
      <a href="#reset" onclick="setTitle('Reset Password');">Reset Password</a>
    </li>
  </ul>
  <div id="login" class="form-action show">
    <h1>Login</h1>
    <!--<p>Lorem ipsum by <a href="https://codepen.io/davideast">David East</a> dolor sit amet, consectetur adipisicing elit. Veritatis, magni culpa facilis.</p>-->
    <p><?php
    if(isset($_GET['erro'])) switch($_GET['erro']){
      case "MultipleUser":
      ?>
      Usuário duplicado no sistema!!<br/><br/>
      <?php
      break;
      case "ADMultipleUser":
      ?>
      Usuário duplicado no AD!!<br/><br/>
      <?php
      break;
      case "LDAPerror":
      ?>
      Serviço AD temporariamente indisponível, tente novamente após alguns minutos<br/><br/>
      <?php
      break;
      case "dbconection":
      ?>
      Falha na tentativa de conexão com o banco de dados, contate o administrador do sistema<br/><br/>
      <?php
      break;
      case "blankpass":
      ?>
      Senha em branco.<br/><br/>
      <?php
      break;
      case "blankuser":
      ?>
      Usuário em branco.<br/><br/>
      <?php
      break;
      case "blankname":
      ?>
      Nome Completo em branco.<br/><br/>
      <?php
      break;
      case "blankmail":
      ?>
      Email em branco.<br/><br/>
      <?php
      break;
      case "shortpass":
      ?>
      Senha Menor que 8 Digitos.<br/><br/>
      <?php
      break;
      case "diferentpass":
      ?>
      Senha diferente da confirmação.<br/><br/>
      <?php
      break;
      case "WhrongWait":
      ?>
      Tentativas de login excedidas,<br/>
      aguarde <?php if(isset($_GET['tmrest'])) echo $_GET['tmrest'];  ?> antes de tentar novamente.</font><br/><br/>
      <?php
      break;
      case "WhrongUser":
      ?>
      Usuário não existe<br/><br/>
      <?php
      break;
      case "WhrongPass":
      ?>
      Senha incorreta<br/><br/>
      <?php
      break;
      case "ADWhrongPass":
      ?>
      Senha do AD incorreta<br/><br/>
      <?php
      break;
      case "WhrongCredentials":
      ?>
      Os dados inseridos são inválidos!<br/><br/>
      <?php
      break;
      case "Activate":
      ?>
      A sua conta ainda não foi ativada.<br/>
      Acesse seu email <?php if(isset($_GET['email'])) echo $_GET['email'];  ?> e clique no link que foi enviado para ativá-la. <br/>
      <br/><br/>
      <?php
      break;
      case "Blacklist":
      ?>
      Este usuario não é permitido para logar!<br/><br/>
      <?php
      break;
      case "registration":
      ?>
      Usuario registrado com sucesso!<br/><br/>
      <?php
      break;
      case "UserExist":
      ?>
      Usuario já registrando. Se esqueceu a senha tente resetar!<br/><br/>
      <?php
      break;
      case "userAD":
      ?>
      Usuario do AD. Se esqueceu a senha entr em contato com a Informatica pelo link: <a href="http://www.nepo.unicamp.br/nepo/informatica.html">http://www.nepo.unicamp.br/nepo/informatica.html</a>!<br/><br/>
      <?php
      break;
      case "emailAD":
      ?>
      Email do AD. Se esqueceu a senha entr em contato com a Informatica pelo link: <a href="http://www.nepo.unicamp.br/nepo/informatica.html">http://www.nepo.unicamp.br/nepo/informatica.html</a>!>Informatica</a>!<br/><br/>
      <?php
      break;
    }
    ?>
  </p>
  <form id="Login" name="Login" method="post" action="do_login.php<?php if(isset($_GET['redir'])) echo '?redir='.$_GET['redir']; ?>">
    <ul>
      <li>
        <input type="text" placeholder="Username" id="username" name="usernamePost" size="30" onblur="CheckBlank(this)" value="<?php if(isset($_GET['user'])) echo $_GET['user']; ?>" required/>
      </li>
      <li>
        <input type="password" placeholder="Password" id="password" name="passwordPost" type="password" required/>
      </li>
      <li>
        <input id="login" name="loginPost" value="Login" type="submit" class="button" />
      </li>
    </ul>
  </form>
</div>
<!--/#login.form-action-->
<div id="register" class="form-action hide">
  <h1>Register</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod, culpa repudiandae.</p>
  <form id="Cadastro" name="Cadastro" method="post" action="do_register.php">
    <ul>
      <li>
        <input type="text" placeholder="Nome Completo" name="fullNamePost" required/>
      </li>
      <li>
        <input type="text" placeholder="Usuário" name="usernamePost" required/>
      </li>
      <li>
        <!--<input type="text" placeholder="Instituição" />-->
        <input type="text" list="institution" placeholder="Instituição" name="institutionPost" />
        <datalist id="institution">
          <?php datalist_institution(); ?>
        </datalist>
      </li>
      <li>
        <input type="email" placeholder="E-mail" name="emailPost" required/>
      </li>
      <li>
        <input type="password" placeholder="Senha" name="passwordPost" required/>
      </li>
      <li>
        <input type="password" placeholder="Confirmação Senha" name="cPasswordPost" required/>
      </li>
      <li>
        <input type="checkbox" name="sendMailExeption" value="sendMailExeption" >Deseja Receber email de atualizações, promoções e outros.
      </li>
    </br>
    <li>
      <input type="submit" value="Sign Up" class="button"/>
    </li>
  </ul>
</form>
</div>
<!--/#register.form-action-->
<div id="reset" class="form-action hide">
  <h1>Reset Password</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, provident in accusamus possimus.</p>
  <form>
    <ul>
      <li>
        <input type="text" placeholder="Email" />
      </li>
      <li>
        <input type="submit" value="Send" class="button" />
      </li>
    </ul>
  </form>
</div>
<!--/#register.form-action-->
</div>
<script>
document.getElementById("title").innerHTML = "Login | <?php echo SYSTEM_NAME; ?>";
function setTitle(title) {
  var title = title+" | <?php echo SYSTEM_NAME; ?>";
  document.getElementById("title").innerHTML = title;
}</script>
