<!--PHP links-->
<div class="flat-form">
  <ul class="tabs">
    <li>
      <a href="#login" class="active">Login</a>
    </li>
    <li>
      <a href="#register">Register</a>
    </li>
    <li>
      <a href="#reset">Reset Password</a>
    </li>
  </ul>
  <div id="login" class="form-action show">
    <h1>Login</h1>
    <!--<p>Lorem ipsum by <a href="https://codepen.io/davideast">David East</a> dolor sit amet, consectetur adipisicing elit. Veritatis, magni culpa facilis.</p>-->
  <p><?php
	if(isset($_GET['reason'])) switch($_GET['reason']){
		case "MultipleUser":
			?>
		    Usuário duplicado no sistema!!<br/><br/>
			<?php
			break;
		case "LDAPerror":
			?>
			   Serviço temporariamente indisponível, tente novamente após alguns minutos<br/><br/>
			<?php
			break;
		case "SecurityError":
			?>
			   Falha na tentativa de conexão segura, contate o administrador do sistema<br/><br/>
			<?php
			break;
		case "blankpass":
			?>
			   Por favor, faça login novamente.<br/><br/>
			<?php
			break;
		case "WhrongWait":
			?>
			   Tentativas de login excedidas,<br/>
          aguarde alguns minutos antes de tentar novamente.</font><br/><br/>
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
		case "WhrongCredentials":
			?>
			   Os dados inseridos são inválidos!<br/><br/>
			<?php
			break;
		case "Activate":
			?>
			     A sua conta ainda não foi ativada.<br/>
			     Acesse seu email e clique no link que foi enviado para ativá-la. <br/>
            <br/><br/>
			<?php
			break;
		}
    ?>
    </p>
    <form id="Login" name="Login" method="post" action="login.php">
      <ul>
        <li>
          <input type="text" placeholder="Username" id="username" name="username" size="30" onblur="CheckBlank(this)" value="<?php if(isset($_GET['user'])) echo $_GET['user']; ?>" />
        </li>
        <li>
          <input type="password" placeholder="Password" id="password" name="password" type="password" />
        </li>
        <li>
          <input id="login" name="login" value="Login" type="submit" class="button" />
        </li>
      </ul>
    </form>
  </div>
  <!--/#login.form-action-->
  <div id="register" class="form-action hide">
    <h1>Register</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod, culpa repudiandae.</p>
    <form id="Cadastro" name="Cadastro" method="post" action="register.php">
      <ul>
        <li>
          <input type="text" placeholder="Nome Completo" id="namePost" name="namePost" />
        </li>
        <li>
          <input type="text" placeholder="Usuario" id="usernamePost" name="usernamePost" />
        </li>
        <li>
          <!--<input type="text" placeholder="Instituição" />-->
          <input type="text" list="institution" placeholder="Instituição" name="institutionPost" />
          <datalist id="institution">
            <?php datalist_institution(); ?>
          </datalist>
        </li>
        <li>
          <input type="email" placeholder="E-mail" id="email" name="emailPost" />
        </li>
        <li>
          <input type="password" placeholder="Senha" id="password" name="passwordPost" />
        </li>
        <li>
          <input type="password" placeholder="Confirmação Senha" />
        </li>
        <li>
          <input type="checkbox" name="sendMailExeption" value="sendMailExeption" >Deseja Receber email de atualizações, promoções e outros.
        </li>
      </br>
        <li>
          <input type="submit" value="Sign Up" class="button" />
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
