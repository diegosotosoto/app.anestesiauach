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

                FROM usuarios_dolor

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

$sql_toggle = "INSERT INTO usuario_notas (

                    usuario_id,

                    nota_id,

                    es_favorita

               )

               VALUES (?, ?, 1)

               ON DUPLICATE KEY UPDATE

                    es_favorita = IF(es_favorita = 1, 0, 1),

                    updated_at = NOW()";

$stmt_toggle = $conexion->prepare($sql_toggle);

if (!$stmt_toggle) {

    http_response_code(500);

    echo json_encode([

        'ok' => false,

        'message' => 'Error preparando toggle'

    ]);

    exit;

}

$stmt_toggle->bind_param("ii", $usuario_id, $nota_id);

if (!$stmt_toggle->execute()) {

    http_response_code(500);

    echo json_encode([

        'ok' => false,

        'message' => 'Error ejecutando toggle'

    ]);

    exit;

}

$stmt_toggle->close();

$sql_estado = "SELECT es_favorita

               FROM usuario_notas

               WHERE usuario_id = ?

                 AND nota_id = ?

               LIMIT 1";

$stmt_estado = $conexion->prepare($sql_estado);

$stmt_estado->bind_param("ii", $usuario_id, $nota_id);

$stmt_estado->execute();

$res_estado = $stmt_estado->get_result();

$es_favorita = 0;

if ($fila_estado = $res_estado->fetch_assoc()) {

    $es_favorita = (int)$fila_estado['es_favorita'];

}

$stmt_estado->close();

echo json_encode([

    'ok' => true,

    'nota_id' => $nota_id,

    'es_favorita' => $es_favorita

]);

exit;

?>