<?php
    function sendVerificationMail($id, $link){
      //Make the variables for validate the email
      $sql = "SELECT `name` , `email`, `key`, `date_ts` FROM `user` WHERE id_user='".$id."'";
      if( !mysqli_query( $link, $sql)  ) {
          echo "Erro:Houve um erro ao conectar a tabela db".mysqli_error()."|";
          mysqli_close($link);
      } else {
        $sql = mysqli_query( $link, $sql );
        $rs = mysqli_fetch_array( $sql );

        if(!isset($rs['key'])){
          $rs['key'] = md5(uniqid(""));
          mysqli_query( $link, "UPDATE `user` SET `key`='".$rs['key']."' WHERE id_user='".$id."'" );
        }
        if($rs['date_ts'] < '1'){
          $rs['date_ts']     = time();
          mysqli_query( $link, "UPDATE `user` SET `date_ts`='".$rs['date_ts']."' WHERE id_user='".$id."'" );
        }
          $headers  = 'MIME-Version: 1.1' . "\r\n";// Certifique-se de utilizar o MIME 1.1, pois é o mais atual. A versão 1.0 não é recomendado.
        	$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
        	$headers .= 'From: Cadastro <cadastro@nepo.unicamp.com > ' . "\r\n";// Remetente precisa ser uma caixa postal do mesmo dominio da hospedagem
          $headers .= "Return-Path: Suporte <suporte@nepo.unicamp.com>\n"; // return-path. Precisa ser uma caixa postal do mesmo dominio da hospedagem

        	$subject = 'Confirmacao de Cadastro';//subject

          $to = $rs['email'];// destinatário. Você pode configurar uma variável para coletar o endereço preenchido no formulário

          //Make the variables for validate the email
          $url = sprintf( 'id=%s&email=%s&uid=%s&key=%s',$id, md5($rs['email']), $rs['key'], md5($rs['date_ts']) );

          $mensagem = sprintf('Olá %s, Seja Bem Vindo ao %s', $rs['name'], ORGANIZATION_NOME);
          $mensagem .= '</br> Para confirmar seu cadastro acesse o link:'."\n";
          $site_url = SITE_URL;
          $mensagem .= sprintf('%sactive.php?%s', $site_url ,$url);

      	mail($to, $subject, $mensagem, $headers);
      }

    }

?>
