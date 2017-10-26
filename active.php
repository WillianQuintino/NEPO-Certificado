<?php
  // Include config in code
  include_once 'src/config/db.config';
  include_once 'src/config/site.config';

  //Include funtions in code
  include_once 'src/include/functions/db.php';
  include_once 'src/include/functions/security.php';

  //Data coming by url
  $id = $_GET['id'];
  $emailMd5 = $_GET['email'];
  $key = $_GET['uid'];
  $dataMd5 = $_GET['key'];

  $link = db_connection();
  if(!$link){
    echo 'Erro:Não Foi Possivel conectar com db!|';
  }else{
    //Search the data base
    $sql = "SELECT `email`, `user_active`, `key`, `date_ts` FROM `user` WHERE id_user='".$id."'";
    if( !mysqli_query( $link, $sql)  ) {
        echo "Erro:Não Foi Possivel conectar tabela do db!".mysqli_error()."|";
        mysqli_close($link);
    } else {

        $sql = mysqli_query( $link, $sql );
        $rs = mysqli_fetch_array( $sql );
        mysqli_close($link);
        if($rs['active'] !== '1'){
            //compare the data what caught base, with the data coming by url
            $valido = true;

            if( $emailMd5 !== md5($rs['email']) )
                $valido = false;

            if( $key !== $rs['key'] )
                $valido = false;

            if( $dataMd5 !== md5($rs['date_ts']) )
                $valido = false;


            // the data is correct, time to activate the registration
            if( $valido === true ) {
                $sql = "update user set user_active='1' where id_user='$id'";
                $link = db_connection();
                mysqli_query($link, $sql);
                mysqli_close($link);
                echo "Cadastro ativado com sucesso!";
            } else {
                echo "Informações inválidas";
            }
        }else{
            echo "Erro:Email já ativado!";
        }
    }
}

?>
