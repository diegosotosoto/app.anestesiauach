<?php
require("../conectar.php");
require_once __DIR__ . "/../app_security.php";
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8mb4");

header('Content-Type: application/json; charset=utf-8');

$usuario_actual = app_current_user($conexion);

if (!$usuario_actual) {
    http_response_code(401);
    echo json_encode(['ok' => false]);
    exit;
}

$usuario_id = (int)$usuario_actual['ID'];
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