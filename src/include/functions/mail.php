<?php
    function sendVerificationMail($id, $link){

      //Make the variables for validate the email
      $sql = "SELECT `nickname` , `email`, `key`, `date_ts` FROM `users` WHERE id='".$id."'";
      if( !mysqli_query( $link, $sql)  ) {
          echo "Erro:Houve um erro ao conectar a tabela db".mysqli_error()."|";
          mysqli_close($link);
      } else {
        $sql = mysqli_query( $link, $sql );
        $rs = mysqli_fetch_array( $sql );

          $headers  = 'MIME-Version: 1.1' . "\r\n";// Certifique-se de utilizar o MIME 1.1, pois é o mais atual. A versão 1.0 não é recomendado.
        	$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
        	$headers .= 'From: '.NOME_GAME.' - Cadastro < cadastro@000webhostapp.com > ' . "\r\n";// Remetente precisa ser uma caixa postal do mesmo dominio da hospedagem
          $headers .= "Return-Path: Suporte <williancustodioquintino@gmail.com>\n"; // return-path. Precisa ser uma caixa postal do mesmo dominio da hospedagem

        	$subject = 'Confirmacao de Cadastro';//subject

          $to = $rs['email'];// destinatário. Você pode configurar uma variável para coletar o endereço preenchido no formulário

          //Make the variables for validate the email
          $url = sprintf( 'id=%s&email=%s&uid=%s&key=%s',$id, encrypt($rs['email'], $rs['key']), $rs['key'], encrypt($rs['date_ts'], $rs['key']));

          $mensagem = sprintf('Olá %s, Seja Bem Vindo ao %s', $rs['nickname'], NOME_GAME);
          $mensagem .= '</br> Para confirmar seu cadastro acesse o link:'."\n";
          $mensagem .= sprintf('https://magepotions.000webhostapp.com/active.php?%s',$url);

      	mail($to, $subject, $mensagem, $headers);
      }

    }

?>
