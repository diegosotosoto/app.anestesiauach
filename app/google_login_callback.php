<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

require('conectar.php');
require_once __DIR__ . '/app_text_helpers.php';

$config_path = __DIR__ . '/secure_config/google_login_config.php';
if (!file_exists($config_path)) {
    header('Location: login.php?google_error=config');
    exit;
}
require_once $config_path;

if (!defined('APP_GOOGLE_CLIENT_ID') || trim((string)APP_GOOGLE_CLIENT_ID) === '') {
    header('Location: login.php?google_error=config');
    exit;
}

$credential = isset($_POST['credential']) ? trim((string)$_POST['credential']) : '';
if ($credential === '') {
    header('Location: login.php?google_error=token');
    exit;
}

$tokeninfo_url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($credential);
$tokeninfo_json = @file_get_contents($tokeninfo_url);
if ($tokeninfo_json === false) {
    header('Location: login.php?google_error=token');
    exit;
}

$tokeninfo = json_decode($tokeninfo_json, true);
if (!is_array($tokeninfo)) {
    header('Location: login.php?google_error=token');
    exit;
}

$aud = isset($tokeninfo['aud']) ? (string)$tokeninfo['aud'] : '';
$email = isset($tokeninfo['email']) ? strtolower(trim((string)$tokeninfo['email'])) : '';
$email_verified = isset($tokeninfo['email_verified']) ? (string)$tokeninfo['email_verified'] : 'false';
$name = isset($tokeninfo['name']) ? trim((string)$tokeninfo['name']) : '';

if ($aud !== APP_GOOGLE_CLIENT_ID || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $email_verified !== 'true') {
    header('Location: login.php?google_error=invalid');
    exit;
}

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

$stmt = $conexion->prepare("SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
if (!$stmt) {
    header('Location: login.php?google_error=db');
    exit;
}
$stmt->bind_param('s', $email);
$stmt->execute();
$user = null;
if (method_exists($stmt, 'get_result')) {
    $res = $stmt->get_result();
    $user = $res ? $res->fetch_assoc() : null;
} else {
    $stmt->bind_result($nombre_tmp);
    if ($stmt->fetch()) {
        $user = array('nombre_usuario' => $nombre_tmp);
    }
}
$stmt->close();

if (!$user) {
    if ($name === '') {
        $name = $email;
    }
    $password_hash = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
    $verified = 1;
    $verified_email = 1;
    $external = 1;
    $stmt_insert = $conexion->prepare("INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`, `verified`, `verified_email`, `external_`) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt_insert) {
        header('Location: login.php?google_error=db');
        exit;
    }
    $name_db = app_decode_text($name);
    $stmt_insert->bind_param('sssiii', $name_db, $email, $password_hash, $verified, $verified_email, $external);
    if (!$stmt_insert->execute()) {
        $stmt_insert->close();
        header('Location: login.php?google_error=db');
        exit;
    }
    $stmt_insert->close();
    $user = array('nombre_usuario' => $name_db);
} else {
    $stmt_update = $conexion->prepare("UPDATE `usuarios_dolor` SET `verified_email` = 1 WHERE `email_usuario` = ? LIMIT 1");
    if (!$stmt_update) {
        header('Location: login.php?google_error=db');
        exit;
    }
    $stmt_update->bind_param('s', $email);
    if (!$stmt_update->execute()) {
        $stmt_update->close();
        header('Location: login.php?google_error=db');
        exit;
    }
    $stmt_update->close();
}

$nombre_cookie = function_exists('app_decode_text') ? app_decode_text($user['nombre_usuario']) : (string)$user['nombre_usuario'];
setcookie('hkjh41lu4l1k23jhlkj13', $email, time() + 60 * 60 * 24 * 30 * 6, '/');
setcookie('hkjh41lu4l1k23jhlkj14', $nombre_cookie, time() + 60 * 60 * 24 * 30 * 6, '/');

$conexion->close();
header('Location: index.php');
exit;
