<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../PHPMailer/src/Exception.php';
require '../../../PHPMailer/src/PHPMailer.php';
require '../../../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.nepo.unicamp.br;mail.nepo.unicamp.br';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'nepo\admimnepo1';                 // SMTP username
    $mail->Password = '100%mc.wyll$';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 443;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('willian@nepo.unicamp.br', 'Willian');
    $mail->addAddress('williancustodioquintino@gmail.com', 'Willian Recebe');     // Add a recipient
    $mail->addAddress('mcwyll2010@yahoo.com.br');               // Name is optional
    $mail->addReplyTo('mc_wyll_2009@hotmail.com', 'Information');
    $mail->addCC('willian@nepo.unicamp.br');
    $mail->addBCC('willian@nepo.unicamp.br');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('mail.php', 'teste.php');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
 ?>
