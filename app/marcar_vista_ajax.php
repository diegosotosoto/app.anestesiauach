<?php

require("conectar.php");

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

$conexion->set_charset("utf8mb4");

header('Content-Type: application/json; charset=utf-8');

if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || $_COOKIE['hkjh41lu4l1k23jhlkj13'] === '') {

    http_response_code(401);

    echo json_encode([

        'ok' => false,

        'message' => 'Usuario no autenticado'

    ]);

    exit;

}

$email_usuario_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

$sql_usuario = "SELECT ID

                FROM anestes1_hoja_dolor.usuarios_dolor

                WHERE email_usuario = ?

                  AND verified = 1

                LIMIT 1";

$stmt_usuario = $conexion->prepare($sql_usuario);

if (!$stmt_usuario) {

    http_response_code(500);

    echo json_encode([

        'ok' => false,

        'message' => 'Error preparando usuario'

    ]);

    exit;

}

$stmt_usuario->bind_param("s", $email_usuario_cookie);

$stmt_usuario->execute();

$res_usuario = $stmt_usuario->get_result();

if (!$fila_usuario = $res_usuario->fetch_assoc()) {

    http_response_code(403);

    echo json_encode([

        'ok' => false,

        'message' => 'Usuario inválido'

    ]);

    exit;

}

$usuario_id = (int)$fila_usuario['ID'];

$stmt_usuario->close();

$nota_id = isset($_POST['nota_id']) ? (int)$_POST['nota_id'] : 0;

if ($nota_id <= 0) {

    http_response_code(400);

    echo json_encode([

        'ok' => false,

        'message' => 'nota_id inválido'

    ]);

    exit;

}

$sql_vista = "INSERT INTO anestes1_hoja_dolor.usuario_notas (

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