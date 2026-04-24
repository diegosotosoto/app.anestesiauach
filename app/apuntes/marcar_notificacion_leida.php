<?php
require("conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8mb4");

header('Content-Type: application/json; charset=utf-8');

if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || $_COOKIE['hkjh41lu4l1k23jhlkj13'] === '') {
    http_response_code(401);
    echo json_encode(['ok' => false]);
    exit;
}

$email_usuario_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

$sql_usuario = "SELECT ID
                FROM usuarios_dolor
                WHERE email_usuario = ?
                  AND verified = 1
                LIMIT 1";

$stmt_usuario = $conexion->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $email_usuario_cookie);
$stmt_usuario->execute();
$res_usuario = $stmt_usuario->get_result();
$fila_usuario = $res_usuario->fetch_assoc();
$stmt_usuario->close();

if (!$fila_usuario) {
    http_response_code(403);
    echo json_encode(['ok' => false]);
    exit;
}

$usuario_id = (int)$fila_usuario['ID'];
$destinatario_id = isset($_POST['destinatario_id']) ? (int)$_POST['destinatario_id'] : 0;

if ($destinatario_id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false]);
    exit;
}

$sql = "UPDATE notificacion_destinatarios
        SET leida = 1,
            leida_at = NOW(),
            updated_at = NOW()
        WHERE id = ?
          AND usuario_id = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $destinatario_id, $usuario_id);
$ok = $stmt->execute();
$stmt->close();

echo json_encode(['ok' => $ok]);
exit;
?>