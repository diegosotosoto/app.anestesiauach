<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

require('conectar.php');
require_once __DIR__ . '/app_text_helpers.php';
require_once __DIR__ . '/app_security.php';

// Función para recrear notificación de Pacientes en Dolor si fue descartada
function crearNotificacionPacientesDolorSiNecesaria($conexion, $usuario_id, $usuario_email) {
    // Verificar si hay notificación archivada de "Pacientes en Dolor" hoy
    $sql_check = "SELECT n.id
                  FROM notificaciones n
                  INNER JOIN notificacion_destinatarios nd ON n.id = nd.notificacion_id
                  WHERE nd.usuario_id = ?
                    AND n.titulo = 'Pacientes en Dolor'
                    AND DATE(n.fecha_inicio) = CURDATE()
                    AND nd.archivada = 1";

    $stmt_check = $conexion->prepare($sql_check);
    if (!$stmt_check) return false;

    $stmt_check->bind_param("i", $usuario_id);
    $stmt_check->execute();

    $fue_descartada = false;
    if (method_exists($stmt_check, 'get_result')) {
        $res_check = $stmt_check->get_result();
        if ($res_check->fetch_assoc()) {
            $fue_descartada = true;
        }
    } else {
        $stmt_check->bind_result($id_tmp);
        if ($stmt_check->fetch()) {
            $fue_descartada = true;
        }
    }
    $stmt_check->close();

    if (!$fue_descartada) return false; // No fue descartada, no recrear

    // Obtener todos los pacientes activos con sus días
    $sql_pacientes = "SELECT nombre_paciente, rut, fecha_creacion
                      FROM pacientes
                      WHERE de_alta = 0
                        AND fecha_creacion >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                      ORDER BY fecha_creacion DESC";

    $stmt = $conexion->prepare($sql_pacientes);
    if (!$stmt) return false;

    $stmt->execute();
    $pacientes = [];
    $dias_pacientes = [];

    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $pacientes[] = $row;
        }
    } else {
        $stmt->bind_result($nombre_tmp, $rut_tmp, $fecha_tmp);
        while ($stmt->fetch()) {
            $pacientes[] = [
                'nombre_paciente' => $nombre_tmp,
                'rut' => $rut_tmp,
                'fecha_creacion' => $fecha_tmp
            ];
        }
    }
    $stmt->close();

    // Calcular días para cada paciente
    foreach ($pacientes as $paciente) {
        $fecha_creacion = new DateTime($paciente['fecha_creacion']);
        $fecha_actual = new DateTime();
        $diferencia = $fecha_creacion->diff($fecha_actual);
        $dias = $diferencia->days;
        if ($dias > 0) {
            $dias_pacientes[] = $dias;
        }
    }

    if (empty($dias_pacientes)) return false;

    $total_pacientes = count($dias_pacientes);
    sort($dias_pacientes);
    $dias_texto = implode(', ', $dias_pacientes);
    $mensaje = "Ingresaste {$total_pacientes} paciente(s) en Dolor hace {$dias_texto} día(s).";

    // Crear nueva notificación
    $titulo = "Pacientes en Dolor";
    $tipo = "info";
    $alcance = "individual";
    $url_destino = "hoja_dolor.php";
    $icono = "fa-solid fa-syringe";
    $fecha_inicio = date('Y-m-d H:i:s');
    $fecha_fin = null;
    $publicada = 1;

    $stmt_notif = $conexion->prepare("
        INSERT INTO `notificaciones`
        (`titulo`,`mensaje`,`tipo`,`alcance`,`grupo_destino`,`url_destino`,`icono`,`creada_por`,`publicada`,`fecha_inicio`,`fecha_fin`)
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?)
    ");

    if (!$stmt_notif) return false;

    $stmt_notif->bind_param(
        "sssssssiiss",
        $titulo,
        $mensaje,
        $tipo,
        $alcance,
        null,
        $url_destino,
        $icono,
        $usuario_id,
        $publicada,
        $fecha_inicio,
        $fecha_fin
    );

    if (!$stmt_notif->execute()) {
        $stmt_notif->close();
        return false;
    }

    $notificacion_id = $stmt_notif->insert_id;
    $stmt_notif->close();

    // Asignar notificación al usuario
    $stmt_dest = $conexion->prepare("
        INSERT INTO `notificacion_destinatarios` (`notificacion_id`,`usuario_id`)
        VALUES (?,?)
    ");

    if (!$stmt_dest) return false;

    $stmt_dest->bind_param("ii", $notificacion_id, $usuario_id);
    $stmt_dest->execute();
    $stmt_dest->close();

    return true;
}

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

$stmt = $conexion->prepare("SELECT `ID`, `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
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
    $stmt->bind_result($id_tmp, $nombre_tmp);
    if ($stmt->fetch()) {
        $user = array('ID' => $id_tmp, 'nombre_usuario' => $nombre_tmp);
    }
}
$stmt->close();

if (!$user) {
    $password_hash = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
    $verified = 1;
    $verified_email = 1;
    $external = 1;
    // NO guardar nombre de Google - usar string vacío para forzar completar perfil
    $nombre_vacio = '';
    $stmt_insert = $conexion->prepare("INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`, `verified`, `verified_email`, `external_`) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt_insert) {
        header('Location: login.php?google_error=db');
        exit;
    }
    $stmt_insert->bind_param('sssiii', $nombre_vacio, $email, $password_hash, $verified, $verified_email, $external);
    if (!$stmt_insert->execute()) {
        $stmt_insert->close();
        header('Location: login.php?google_error=db');
        exit;
    }
    $user_id = $stmt_insert->insert_id;
    $stmt_insert->close();
    $user = array('ID' => $user_id, 'nombre_usuario' => $nombre_vacio);

    // Usuario external_ nuevo - redirigir a completar perfil
    $nombre_cookie = $email;
    app_set_auth_session_for_email($conexion, $email);
    $conexion->close();
    header('Location: completar_perfil.php');
    exit;
} else {
    // Usuario ya existe - verificar si tiene nombre completo
    $nombre_usuario = trim((string)($user['nombre_usuario'] ?? ''));
    if ($nombre_usuario === '' || $nombre_usuario === null) {
        // Usuario sin nombre - actualizar verified_email y redirigir a completar perfil
        $stmt_update = $conexion->prepare("UPDATE `usuarios_dolor` SET `verified_email` = 1 WHERE `email_usuario` = ? LIMIT 1");
        if ($stmt_update) {
            $stmt_update->bind_param('s', $email);
            $stmt_update->execute();
            $stmt_update->close();
        }
        
        $nombre_cookie = $email;
        app_set_auth_session_for_email($conexion, $email);
        $conexion->close();
        header('Location: completar_perfil.php');
        exit;
    }
    
    // Usuario con nombre - solo actualizar verified_email
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
    
    // Recargar usuario desde la base de datos para obtener el nombre actualizado
    $stmt_reload = $conexion->prepare("SELECT `ID`, `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
    if ($stmt_reload) {
        $stmt_reload->bind_param('s', $email);
        $stmt_reload->execute();
        if (method_exists($stmt_reload, 'get_result')) {
            $res = $stmt_reload->get_result();
            $user = $res ? $res->fetch_assoc() : $user;
        } else {
            $stmt_reload->bind_result($id_tmp, $nombre_tmp);
            if ($stmt_reload->fetch()) {
                $user = array('ID' => $id_tmp, 'nombre_usuario' => $nombre_tmp);
            }
        }
        $stmt_reload->close();
    }
}

$nombre_cookie = function_exists('app_decode_text') ? app_decode_text($user['nombre_usuario']) : (string)$user['nombre_usuario'];
app_set_auth_session_for_email($conexion, $email);

// Recrear notificación de Pacientes en Dolor si fue descartada anteriormente
crearNotificacionPacientesDolorSiNecesaria($conexion, $user['ID'], $email);

$conexion->close();
header('Location: index.php');
exit;
