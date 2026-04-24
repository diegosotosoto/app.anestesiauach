<?php
require("conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8mb4");

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim($_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    http_response_code(401);
    echo json_encode(['ok' => false, 'message' => 'No autenticado']);
    exit;
}

$email_usuario_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

$stmtUser = $conexion->prepare("
    SELECT ID
    FROM usuarios_dolor
    WHERE email_usuario = ?
      AND verified = 1
    LIMIT 1
");

if (!$stmtUser) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Error usuario']);
    exit;
}

$stmtUser->bind_param("s", $email_usuario_cookie);
$stmtUser->execute();

$usuario_id = 0;

if (method_exists($stmtUser, 'get_result')) {
    $resUser = $stmtUser->get_result();
    if ($rowUser = $resUser->fetch_assoc()) {
        $usuario_id = (int)$rowUser['ID'];
    }
} else {
    $stmtUser->bind_result($usuario_id_tmp);
    if ($stmtUser->fetch()) {
        $usuario_id = (int)$usuario_id_tmp;
    }
}

$stmtUser->close();

if ($usuario_id <= 0) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'message' => 'Usuario inválido']);
    exit;
}

$destinatario_id = isset($_POST['destinatario_id']) ? (int)$_POST['destinatario_id'] : 0;
$accion = trim($_POST['accion'] ?? '');

if ($destinatario_id <= 0 || !in_array($accion, ['leer', 'archivar'], true)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Parámetros inválidos']);
    exit;
}

if ($accion === 'leer') {
    $stmt = $conexion->prepare("
        UPDATE notificacion_destinatarios
        SET leida = 1,
            leida_at = NOW(),
            archivada = 1,
            archivada_at = NOW(),
            updated_at = NOW()
        WHERE id = ?
          AND usuario_id = ?
    ");
} else {
    $stmt = $conexion->prepare("
        UPDATE notificacion_destinatarios
        SET archivada = 1,
            archivada_at = NOW(),
            updated_at = NOW()
        WHERE id = ?
          AND usuario_id = ?
    ");
}

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Error preparando acción']);
    exit;
}

$stmt->bind_param("ii", $destinatario_id, $usuario_id);
$ok = $stmt->execute();
$stmt->close();

if (!$ok) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'No se pudo actualizar']);
    exit;
}

$stmtCount = $conexion->prepare("
    SELECT COUNT(*) AS total_no_leidas
    FROM notificacion_destinatarios nd
    INNER JOIN notificaciones n
        ON n.id = nd.notificacion_id
    WHERE nd.usuario_id = ?
      AND nd.leida = 0
      AND nd.archivada = 0
      AND n.publicada = 1
      AND n.fecha_inicio <= NOW()
      AND (n.fecha_fin IS NULL OR n.fecha_fin >= NOW())
");

$total_no_leidas = 0;

if ($stmtCount) {
    $stmtCount->bind_param("i", $usuario_id);
    $stmtCount->execute();

    if (method_exists($stmtCount, 'get_result')) {
        $resCount = $stmtCount->get_result();
        if ($rowCount = $resCount->fetch_assoc()) {
            $total_no_leidas = (int)$rowCount['total_no_leidas'];
        }
    } else {
        $stmtCount->bind_result($total_tmp);
        if ($stmtCount->fetch()) {
            $total_no_leidas = (int)$total_tmp;
        }
    }

    $stmtCount->close();
}

echo json_encode([
    'ok' => true,
    'accion' => $accion,
    'destinatario_id' => $destinatario_id,
    'total_no_leidas' => $total_no_leidas
]);
exit;
?>