<?php

require("conectar.php");
require_once __DIR__ . '/app_security.php';

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

$conexion->set_charset("utf8mb4");

header('Content-Type: application/json; charset=utf-8');

$usuario_actual = app_current_user($conexion);

if (!$usuario_actual) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = (int)$usuario_actual['ID'];

$nota_id = isset($_POST['nota_id']) ? (int)$_POST['nota_id'] : 0;

if ($nota_id <= 0) {

    http_response_code(400);

    echo json_encode([

        'ok' => false,

        'message' => 'nota_id inválido'

    ]);

    exit;

}

$sql_vista = "INSERT INTO usuario_notas (

                usuario_id,

                nota_id,

                vista_at,

                ultima_visita_at

              )

              VALUES (?, ?, NOW(), NOW())

              ON DUPLICATE KEY UPDATE

                vista_at = COALESCE(vista_at, NOW()),

                ultima_visita_at = NOW(),

                updated_at = NOW()";

$stmt_vista = $conexion->prepare($sql_vista);

if (!$stmt_vista) {

    http_response_code(500);

    echo json_encode([

        'ok' => false,

        'message' => 'Error preparando vista'

    ]);

    exit;

}

$stmt_vista->bind_param("ii", $usuario_id, $nota_id);

if (!$stmt_vista->execute()) {

    http_response_code(500);

    echo json_encode([

        'ok' => false,

        'message' => 'Error ejecutando vista'

    ]);

    exit;

}

$stmt_vista->close();

echo json_encode([

    'ok' => true,

    'nota_id' => $nota_id

]);

exit;

?>