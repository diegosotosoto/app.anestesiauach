<?php

if (isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])) {
    header('Location: index.php');
    exit();
}

require("conectar.php");

$smtp_config_path = __DIR__ . '/secure_config/smtp_config.php';
if (file_exists($smtp_config_path)) {
    require_once($smtp_config_path);
}

function app_mail_smtp_config_valida() {
    if (!defined('APP_SMTP_HOST') || trim((string)APP_SMTP_HOST) === '') {
        return false;
    }

    if (!defined('APP_SMTP_USER') || trim((string)APP_SMTP_USER) === '') {
        return false;
    }

    if (!defined('APP_SMTP_PASS') || trim((string)APP_SMTP_PASS) === '') {
        return false;
    }

    return APP_SMTP_PASS !== 'AQUI_VA_LA_PASSWORD_REAL';
}

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

if ($conexion->connect_error) {
    die('Error de conexión.');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

function app_mail_template($title, $pretitle, $intro, $email, $button_text, $button_url, $note) {
    $safe_title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safe_pretitle = htmlspecialchars($pretitle, ENT_QUOTES, 'UTF-8');
    $safe_intro = htmlspecialchars($intro, ENT_QUOTES, 'UTF-8');
    $safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $safe_button_text = htmlspecialchars($button_text, ENT_QUOTES, 'UTF-8');
    $safe_button_url = htmlspecialchars($button_url, ENT_QUOTES, 'UTF-8');
    $safe_note = htmlspecialchars($note, ENT_QUOTES, 'UTF-8');

    return '
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $safe_title . '</title>
  </head>
  <body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f7fb;margin:0;padding:32px 12px;">
      <tr>
        <td align="center">
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 18px 45px rgba(15,23,42,.12);">
            <tr>
              <td style="background:linear-gradient(135deg,#123c7c,#1b75bb);padding:28px 30px;color:#ffffff;text-align:center;">
                <div style="font-size:12px;letter-spacing:.16em;text-transform:uppercase;font-weight:800;opacity:.85;">' . $safe_pretitle . '</div>
                <h1 style="margin:10px 0 0;font-size:28px;line-height:1.15;font-weight:800;">' . $safe_title . '</h1>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;">
                <p style="font-size:16px;line-height:1.6;margin:0 0 18px;">' . $safe_intro . '</p>
                <div style="background:#eef5ff;border:1px solid #d8e8ff;border-radius:18px;padding:16px 18px;margin:0 0 24px;">
                  <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#3559b7;font-weight:800;margin-bottom:6px;">Cuenta</div>
                  <div style="font-size:17px;font-weight:800;color:#111827;">' . $safe_email . '</div>
                </div>
                <div style="text-align:center;margin:30px 0;">
                  <a href="' . $safe_button_url . '" style="display:inline-block;background:#155da8;color:#ffffff;text-decoration:none;font-weight:800;border-radius:999px;padding:14px 24px;box-shadow:0 10px 24px rgba(21,93,168,.28);">' . $safe_button_text . '</a>
                </div>
                <p style="font-size:14px;line-height:1.6;color:#6b7280;margin:0 0 18px;">' . $safe_note . '</p>
                <div style="height:1px;background:#e5e7eb;margin:24px 0;"></div>
                <p style="font-size:14px;line-height:1.5;color:#6b7280;margin:0;">Saludos,<br><strong style="color:#111827;">Anestesia UACh</strong></p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';
}

$mail_context = $_POST['mail_context'] ?? 'password_recovery';
$email_post_key = $mail_context === 'email_verification' ? 'email_usuario_verif' : 'email_usuario_rec';
$redirect_base = $mail_context === 'email_verification' ? 'login.php' : 'nuevo_password.php';

if (!isset($_POST[$email_post_key]) || trim($_POST[$email_post_key]) === '') {
    header('Location: ' . $redirect_base);
    exit();
}

$email_usuario_rec = trim($_POST[$email_post_key]);

if (!filter_var($email_usuario_rec, FILTER_VALIDATE_EMAIL)) {
    header('Location: ' . $redirect_base . '?error=email');
    exit();
}

$email_usuario_rec_db = $conexion->real_escape_string($email_usuario_rec);

if ($mail_context === 'email_verification') {
    $usuario_query = "SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_usuario_rec_db' LIMIT 1";
} else {
    $usuario_query = "SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_usuario_rec_db' AND `verified` = '1' LIMIT 1";
}

$usuario_result = $conexion->query($usuario_query);
if (!$usuario_result || mysqli_num_rows($usuario_result) === 0) {
    header('Location: ' . $redirect_base . '?error=usuario');
    exit();
}

$token_rec = generateRandomString(40);
$token_activ = 1;
$token_hr = time();

$token_rec_db = $conexion->real_escape_string($token_rec);
$token_hr_db = $conexion->real_escape_string($token_hr);

$consulta_token = "
    UPDATE `usuarios_dolor`
    SET 
        `token_rec` = '$token_rec_db',
        `token_activ` = '1',
        `token_hr` = '$token_hr_db'
    WHERE `email_usuario` = '$email_usuario_rec_db'
";

$escribir_token = $conexion->query($consulta_token);

if (!$escribir_token) {
    die('No fue posible generar el token de recuperación.');
}

if ($mail_context === 'email_verification') {
    $link_token = "https://app.anestesiauach.cl/verificar_email.php"
        . "?962eb831a0df54562eb40fed6bf13b=" . urlencode($token_rec)
        . "&89cd7e5e18f25d8e1214f1d8f273da=" . urlencode($token_activ)
        . "&a52f7597ca4d6c24937711a66fd058=" . urlencode($email_usuario_rec);
} else {
    $link_token = "https://app.anestesiauach.cl/password_reset.php"
        . "?962eb831a0df54562eb40fed6bf13b=" . urlencode($token_rec)
        . "&89cd7e5e18f25d8e1214f1d8f273da=" . urlencode($token_activ)
        . "&a52f7597ca4d6c24937711a66fd058=" . urlencode($email_usuario_rec);
}

$mail = new PHPMailer(true);

try {
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = function($str, $level) {
        error_log('PHPMailer recuperación password debug [' . $level . ']: ' . $str);
    };

    if (app_mail_smtp_config_valida()) {
        $mail->isSMTP();
        $mail->Host = APP_SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = APP_SMTP_USER;
        $mail->Password = APP_SMTP_PASS;
        $mail->SMTPSecure = defined('APP_SMTP_SECURE') ? APP_SMTP_SECURE : '';
        $mail->Port = defined('APP_SMTP_PORT') ? (int)APP_SMTP_PORT : 587;
    } else {
        $mail->isMail();
    }

    $from_email = defined('APP_SMTP_FROM_EMAIL') ? APP_SMTP_FROM_EMAIL : 'administrador@anestesiauach.cl';
    $from_name = defined('APP_SMTP_FROM_NAME') ? APP_SMTP_FROM_NAME : 'Anestesia UACh';

    $mail->setFrom($from_email, $from_name);
    $mail->addAddress($email_usuario_rec, 'Usuario');

    $mail->isHTML(true);
    if ($mail_context === 'email_verification') {
        $mail->Subject = 'Verificación de correo - Anestesia UACh';
        $mail->Body = app_mail_template(
            'Verifica tu correo',
            'Registro Anestesia UACh',
            'Recibimos una solicitud de registro para esta cuenta. Para confirmar que el correo te pertenece, abre el siguiente enlace.',
            $email_usuario_rec,
            'Verificar correo',
            $link_token,
            'Después de verificar tu correo, tu cuenta quedará pendiente de validación por un administrador antes del primer ingreso.'
        );
        $mail->AltBody = "Verificación de correo\n\n"
            . "Para verificar tu correo, abre este enlace:\n"
            . $link_token . "\n\n"
            . "Después de verificar tu correo, tu cuenta quedará pendiente de validación por un administrador.\n\n"
            . "Anestesia UACh";
    } else {
        $mail->Subject = 'Recuperación de contraseña - Anestesia UACh';
        $mail->Body = app_mail_template(
            'Recuperación de contraseña',
            'Anestesia UACh',
            'Hemos enviado este correo porque se solicitó restablecer la contraseña asociada a esta cuenta.',
            $email_usuario_rec,
            'Restablecer contraseña',
            $link_token,
            'Si tú no solicitaste este cambio, puedes ignorar este correo. El enlace es temporal.'
        );
        $mail->AltBody = "Recuperación de contraseña\n\n"
            . "Para restablecer tu contraseña, abre este enlace:\n"
            . $link_token . "\n\n"
            . "Si tú no solicitaste este cambio, puedes ignorar este correo.\n\n"
            . "Anestesia UACh";
    }

    $mail->send();

    $mail_redirect = $mail_context === 'email_verification' ? 'mail_enviado.php?context=email_verification' : 'mail_enviado.php';
    header('Location: ' . $mail_redirect);
    exit();

} catch (Throwable $e) {
    error_log('Error PHPMailer recuperación password: ' . $mail->ErrorInfo . ' | ' . $e->getMessage());

    header('Location: ' . $redirect_base . '?error=mail');
    exit();
}

?>
