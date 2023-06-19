<?php
  //si existe la cookie se salta el area de login y va al index
    if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){

    }else{
                header('Location: index.php');
    }
    //Conexión
    require("conectar.php");
    $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if($_POST['email_usuario_rec']){

    $email_usuario_rec=$_POST['email_usuario_rec'];



//generar variables


function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

$token_rec=generateRandomString();
$token_activ=1;
$token_hr=time();

//escribir base de datos
            $consulta_token="UPDATE `usuarios_dolor` SET `token_rec`='$token_rec', `token_activ`='1', `token_hr`='$token_hr' WHERE `email_usuario`='$email_usuario_rec'";
            
            $escribir_token=$conexion->query($consulta_token);


//generar link en get
$link_token="https://app.anestesiauach.cl/password_reset.php?962eb831a0df54562eb40fed6bf13b=".$token_rec."&89cd7e5e18f25d8e1214f1d8f273da=".$token_activ."&a52f7597ca4d6c24937711a66fd058=".$email_usuario_rec;


//enviar mail
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.anestesiauach.cl';                  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'administrador@anestesiauach.cl';             // SMTP username
        $mail->Password = '';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('administrador@anestesiauach.cl', 'Anestesia UACH');          //This is the email your form sends From
        $mail->addAddress($email_usuario_rec, 'Usuario'); // Add a recipient address

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Reseteo de Password';

        $mail->Body    = '
            <h4>Resetar Password</h4>
            <p>Estimad@  '.$email_usuario_rec.':</p>
            <p>Hemos enviado este correo porque has solicitado restablecer tu contraseña.</p>

            <p>Por favor sigue el siguiente <a href='.$link_token.'>LINK</a> para resetear tu contraseña. Si tú no has solicitado restrablecer tu contraseña, te pedimos dejar este correo sin efecto y contactar un administrador del sitio.</p><br>
            <p>Gracias</p>
            <p>Anestesia UACH</p>
        ';


        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        header('Location: mail_enviado.php'); //página para resetear password
        exit();

    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

}

?>