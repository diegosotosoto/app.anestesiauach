<?php
/**
 * Script de cron para enviar emails de notificaciones de calendario
 * 
 * EJECUCIÓN MANUAL:
 *   php cron_notificaciones_calendario.php
 * 
 * CONFIGURACIÓN CRON (ejecutar cada hora entre 8-17, L-V) - USA HORA DE CHILE:
 *   0 8-17 * * 1-5 /usr/bin/php /ruta/absoluta/cron_notificaciones_calendario.php >> /ruta/logs/cron_calendario.log 2>&1
 * 
 * NOTA: Las notificaciones in-app se crean automáticamente al entrar a la app
 * (index.php o calendario.php). Este cron SOLO envía los emails en la hora
 * configurada para cada calendario.
 */

require('conectar.php');
if (file_exists(__DIR__ . '/app_text_helpers.php')) {
    require_once __DIR__ . '/app_text_helpers.php';
}
require_once __DIR__ . '/app_security.php';
require_once __DIR__ . '/google-calendar/config.php';

// Configuración SMTP para envío de correos
$smtp_config_path = __DIR__ . '/secure_config/smtp_config.php';
if(file_exists($smtp_config_path)){
    require_once($smtp_config_path);
}

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

// Establecer zona horaria de Chile para hora de notificaciones
date_default_timezone_set('America/Santiago');

// Función de logging
function log_calendario($msg) {
    $fecha = date('Y-m-d H:i:s');
    echo "[$fecha] $msg\n";
}

// Funciones de utilidad
function h($txt) {
    return htmlspecialchars((string)$txt, ENT_QUOTES, 'UTF-8');
}

// Funciones de email (copiadas de admin_notificaciones.php)
function app_notificaciones_es_localhost() {
    // Si se ejecuta desde CLI (cron), no es localhost
    if (php_sapi_name() === 'cli' || php_sapi_name() === 'cgi-fcgi') {
        return false;
    }
    $host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
    $server = strtolower((string)($_SERVER['SERVER_NAME'] ?? ''));
    return $host === '' || strpos($host, 'localhost') === 0 || strpos($host, '127.0.0.1') === 0 || $server === 'localhost' || $server === '127.0.0.1';
}

function app_notificaciones_cargar_phpmailer() {
    static $cargado = null;
    if ($cargado !== null) return $cargado;
    
    $archivos = [
        __DIR__ . '/PHPMailer/src/Exception.php',
        __DIR__ . '/PHPMailer/src/PHPMailer.php',
        __DIR__ . '/PHPMailer/src/SMTP.php'
    ];
    
    foreach ($archivos as $archivo) {
        if (!is_readable($archivo)) {
            $cargado = false;
            return false;
        }
    }
    
    require_once $archivos[0];
    require_once $archivos[1];
    require_once $archivos[2];
    
    $cargado = class_exists('\PHPMailer\PHPMailer\PHPMailer');
    return $cargado;
}

function app_notificaciones_smtp_config_valida() {
    if (!defined('APP_SMTP_HOST') || trim((string)APP_SMTP_HOST) === '') return false;
    if (!defined('APP_SMTP_USER') || trim((string)APP_SMTP_USER) === '') return false;
    if (!defined('APP_SMTP_PASS') || trim((string)APP_SMTP_PASS) === '') return false;
    return APP_SMTP_PASS !== 'AQUI_VA_LA_PASSWORD_REAL';
}

// Enviar correo de notificación
function enviar_email_notificacion($destinatarios, $titulo, $mensaje, $remitente_email, $remitente_nombre) {
    if (empty($destinatarios)) {
        return ['ok' => false, 'enviados' => 0, 'error' => 'No hay destinatarios'];
    }
    
    if (app_notificaciones_es_localhost()) {
        return ['ok' => true, 'enviados' => 0, 'omitido' => true, 'error' => 'Localhost - omitido'];
    }
    
    if (!app_notificaciones_cargar_phpmailer()) {
        return ['ok' => false, 'enviados' => 0, 'error' => 'PHPMailer no disponible'];
    }
    
    if (!app_notificaciones_smtp_config_valida()) {
        return ['ok' => false, 'enviados' => 0, 'error' => 'SMTP no configurado'];
    }
    
    $enviados = 0;
    $errores = [];
    
    foreach ($destinatarios as $dest) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = APP_SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = APP_SMTP_USER;
            $mail->Password = APP_SMTP_PASS;
            $mail->SMTPSecure = defined('APP_SMTP_SECURE') ? APP_SMTP_SECURE : 'tls';
            $mail->Port = defined('APP_SMTP_PORT') ? (int)APP_SMTP_PORT : 587;
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom($remitente_email, $remitente_nombre);
            $mail->addAddress($dest['email'], $dest['nombre']);
            $mail->Subject = $titulo;
            $mail->Body = $mensaje;
            $mail->isHTML(false);
            
            $mail->send();
            $enviados++;
        } catch (Exception $e) {
            $errores[] = $dest['email'] . ': ' . $e->getMessage();
        }
    }
    
    return [
        'ok' => $enviados > 0,
        'enviados' => $enviados,
        'errores' => $errores
    ];
}

// Crear notificación en el sistema
function crear_notificacion_calendario($conexion, $titulo, $mensaje, $url_destino, $tipo, $alcance, $grupo_destino, $icono, $creada_por, $publicada, $fecha_inicio, $fecha_fin = null) {
    // Manejar fecha_fin NULL
    if ($fecha_fin === null) {
        $stmt = $conexion->prepare("
            INSERT INTO `notificaciones` 
            (`titulo`, `mensaje`, `tipo`, `alcance`, `grupo_destino`, `url_destino`, `icono`, `creada_por`, `publicada`, `fecha_inicio`, `fecha_fin`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)
        ");
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param('sssssssiis', $titulo, $mensaje, $tipo, $alcance, $grupo_destino, $url_destino, $icono, $creada_por, $publicada, $fecha_inicio);
    } else {
        $stmt = $conexion->prepare("
            INSERT INTO `notificaciones` 
            (`titulo`, `mensaje`, `tipo`, `alcance`, `grupo_destino`, `url_destino`, `icono`, `creada_por`, `publicada`, `fecha_inicio`, `fecha_fin`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param('sssssssiiss', $titulo, $mensaje, $tipo, $alcance, $grupo_destino, $url_destino, $icono, $creada_por, $publicada, $fecha_inicio, $fecha_fin);
    }
    
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }
    
    $notif_id = $stmt->insert_id;
    $stmt->close();
    return $notif_id;
}

// Asignar destinatarios a notificación
function asignar_destinatarios_notificacion($conexion, $notif_id, $usuario_ids) {
    if (empty($usuario_ids)) return 0;
    
    $asignados = 0;
    $stmt = $conexion->prepare("INSERT INTO `notificacion_destinatarios` (`notificacion_id`, `usuario_id`) VALUES (?, ?)");
    
    if (!$stmt) return 0;
    
    foreach ($usuario_ids as $uid) {
        $stmt->bind_param('ii', $notif_id, $uid);
        if ($stmt->execute()) {
            $asignados++;
        }
    }
    
    $stmt->close();
    return $asignados;
}

// Obtener usuarios asignados a un calendario
function obtener_usuarios_calendario($conexion, $calendario_id) {
    $usuarios = [];
    
    // Usuarios con asignación directa
    $stmt = $conexion->prepare("
        SELECT DISTINCT u.`ID`, u.`email_usuario`, u.`nombre_usuario`
        FROM `calendario_asignaciones` ca
        INNER JOIN `usuarios_dolor` u ON u.`ID` = ca.`usuario_id`
        WHERE ca.`calendario_id` = ?
        AND ca.`activo` = 1
        AND (ca.`fecha_fin` IS NULL OR ca.`fecha_fin` >= CURDATE())
        AND u.`verified` = 1
    ");
    
    if ($stmt) {
        $stmt->bind_param('i', $calendario_id);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $usuarios[$row['ID']] = $row;
        }
        $stmt->close();
    }
    
    return array_values($usuarios);
}

// Verificar si ya existe notificación para este evento y usuario
function existe_notificacion_evento($conexion, $calendar_id, $event_id, $tipo_notif, $usuario_id = 0) {
    $stmt = $conexion->prepare("
        SELECT `id` FROM `notificaciones_calendario_eventos`
        WHERE `usuario_id` = ? AND `calendar_id` = ? AND `event_id` = ? AND `tipo_notif` = ?
        LIMIT 1
    ");
    
    if (!$stmt) return true; // Por seguridad, asumir que existe
    
    $stmt->bind_param('isss', $usuario_id, $calendar_id, $event_id, $tipo_notif);
    $stmt->execute();
    $res = $stmt->get_result();
    $existe = $res->num_rows > 0;
    $stmt->close();
    
    return $existe;
}

// Registrar notificación de evento enviada (por usuario)
function registrar_notif_evento($conexion, $calendar_id, $event_id, $tipo_notif, $notif_id, $usuario_id = 0) {
    $stmt = $conexion->prepare("
        INSERT INTO `notificaciones_calendario_eventos` 
        (`usuario_id`, `calendar_id`, `event_id`, `tipo_notif`, `notificacion_id`, `fecha_envio`)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    
    if (!$stmt) return false;
    
    $stmt->bind_param('isssi', $usuario_id, $calendar_id, $event_id, $tipo_notif, $notif_id);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

// Obtener eventos del calendario usando google-calendar/config.php
function obtener_eventos_calendario($calendar_id, $time_min, $time_max) {
    if (!google_calendar_is_configured()) {
        log_calendario("ERROR: Google Calendar no está configurado (service-account.json no encontrado)");
        return null;
    }
    
    try {
        $dtMin = new DateTime($time_min);
        $dtMax = new DateTime($time_max);
        
        $eventos = google_calendar_fetch_events($calendar_id, $dtMin, $dtMax, 250);
        
        // Convertir formato de array a objetos stdClass para mantener compatibilidad
        $resultado = [];
        foreach ($eventos as $evento) {
            $obj = new stdClass();
            $obj->id = $evento['id'] ?? '';
            $obj->summary = $evento['summary'] ?? 'Evento sin título';
            $obj->description = $evento['description'] ?? '';
            $obj->location = $evento['location'] ?? '';
            
            // Fecha de inicio
            $start = new stdClass();
            if (isset($evento['start']['dateTime'])) {
                $start->dateTime = $evento['start']['dateTime'];
            } elseif (isset($evento['start']['date'])) {
                $start->date = $evento['start']['date'];
            }
            $obj->start = $start;
            
            // Fecha de fin (opcional)
            if (isset($evento['end'])) {
                $end = new stdClass();
                if (isset($evento['end']['dateTime'])) {
                    $end->dateTime = $evento['end']['dateTime'];
                } elseif (isset($evento['end']['date'])) {
                    $end->date = $evento['end']['date'];
                }
                $obj->end = $end;
            }
            
            $resultado[] = $obj;
        }
        
        return $resultado;
        
    } catch (Exception $e) {
        log_calendario("ERROR Google API: " . $e->getMessage());
        return null;
    }
}

// Marcar email como enviado (por usuario)
function marcar_email_enviado($conexion, $calendar_id, $event_id, $tipo_notif, $usuario_id = 0) {
    $stmt = $conexion->prepare("
        UPDATE `notificaciones_calendario_eventos`
        SET `email_enviado` = 1
        WHERE `usuario_id` = ? AND `calendar_id` = ? AND `event_id` = ? AND `tipo_notif` = ?
    ");
    if (!$stmt) return false;
    $stmt->bind_param('isss', $usuario_id, $calendar_id, $event_id, $tipo_notif);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Verificar si email ya fue enviado (por usuario)
function email_ya_enviado($conexion, $calendar_id, $event_id, $tipo_notif, $usuario_id = 0) {
    $stmt = $conexion->prepare("
        SELECT `id` FROM `notificaciones_calendario_eventos`
        WHERE `usuario_id` = ? AND `calendar_id` = ? AND `event_id` = ? AND `tipo_notif` = ? AND `email_enviado` = 1
        LIMIT 1
    ");
    if (!$stmt) return true;
    $stmt->bind_param('isss', $usuario_id, $calendar_id, $event_id, $tipo_notif);
    $stmt->execute();
    $res = $stmt->get_result();
    $existe = $res->num_rows > 0;
    $stmt->close();
    return $existe;
}

// Obtener destinatarios de una notificación
function obtener_destinatarios_notificacion($conexion, $notif_id) {
    $usuarios = [];
    $stmt = $conexion->prepare("
        SELECT u.`ID`, u.`email_usuario`, u.`nombre_usuario`
        FROM `notificacion_destinatarios` nd
        INNER JOIN `usuarios_dolor` u ON u.`ID` = nd.`usuario_id`
        WHERE nd.`notificacion_id` = ?
    ");
    if (!$stmt) return $usuarios;
    $stmt->bind_param('i', $notif_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $usuarios[] = $row;
    }
    $stmt->close();
    return $usuarios;
}

// Procesar calendarios y enviar emails (las notificaciones in-app ya fueron creadas por index.php/calendario.php)
function procesar_calendarios($conexion) {
    log_calendario("=== Iniciando envío de emails de calendario ===");
    log_calendario("Hora Chile: " . date('Y-m-d H:i:s') . " (hora notif: " . date('H:00') . ")");

    $hora_actual = date('H:00');
    $dia_semana = (int)date('N');
    $es_dia_semana = ($dia_semana >= 1 && $dia_semana <= 5);

    // Buscar notificaciones de calendario pendientes de email
    // que correspondan a la hora actual y día de la semana configurados
    $sql = "
        SELECT nce.`id`, nce.`usuario_id`, nce.`calendar_id`, nce.`event_id`, nce.`tipo_notif`, nce.`notificacion_id`,
               n.`titulo`, n.`mensaje`,
               ca.`notif_email`, ca.`notif_weekdays`, ca.`notif_hora`, ca.`nombre` as calendario_nombre
        FROM `notificaciones_calendario_eventos` nce
        INNER JOIN `notificaciones` n ON n.`id` = nce.`notificacion_id`
        INNER JOIN `calendarios_app` ca ON ca.`calendar_id` = nce.`calendar_id`
        WHERE nce.`email_enviado` = 0
          AND ca.`notif_email` = 1
          AND ca.`activo` = 1
          AND n.`publicada` = 1
    ";

    $res = $conexion->query($sql);

    if (!$res || $res->num_rows === 0) {
        log_calendario("No hay notificaciones pendientes de envío de email");
        return;
    }

    $admin_email = 'admin@anestesiauach.cl';
    $admin_nombre = 'Anestesia UACH';
    $emails_enviados = 0;

    while ($row = $res->fetch_assoc()) {
        $notif_hora = substr($row['notif_hora'], 0, 5); // Convertir 08:00:00 a 08:00
        $solo_weekdays = (int)$row['notif_weekdays'] === 1;

        // Verificar ventana de envío: desde hora configurada hasta 17:00
        $hora_actual_num = (int)str_replace(':', '', $hora_actual);     // ej: 900 para 09:00
        $notif_hora_num = (int)str_replace(':', '', $notif_hora);         // ej: 800 para 08:00
        $hora_limite = 1700; // 17:00

        if ($hora_actual_num < $notif_hora_num || $hora_actual_num > $hora_limite) {
            log_calendario("Notificación #{$row['notificacion_id']}: fuera de ventana (actual: $hora_actual, configurada: $notif_hora, límite: 17:00)");
            continue;
        }

        if ($solo_weekdays && !$es_dia_semana) {
            log_calendario("Notificación #{$row['notificacion_id']}: omitida (solo L-V)");
            continue;
        }

        // Obtener destinatarios de la notificación
        $destinatarios = obtener_destinatarios_notificacion($conexion, $row['notificacion_id']);
        if (empty($destinatarios)) {
            log_calendario("Notificación #{$row['notificacion_id']}: sin destinatarios");
            continue;
        }

        // Preparar destinatarios para email
        $email_destinatarios = array_map(function($u) {
            return ['email' => $u['email_usuario'], 'nombre' => $u['nombre_usuario']];
        }, $destinatarios);

        // Preparar asunto y mensaje con formato mejorado
        $asunto_email = 'Recordatorio: ' . $row['titulo'];
        $mensaje_email = "Notificación Automática de Recordatorio: " . $row['titulo'] . ", en el " . $row['mensaje'] . "\n\n";
        $mensaje_email .= "Este correo es enviado de forma automática por el sistema de Notificaciones. Por favor, no responder.\n\n";
        $mensaje_email .= "Saludos,\nEquipo Anestesia UACH";

        // Enviar email
        $resultado = enviar_email_notificacion(
            $email_destinatarios,
            $asunto_email,
            $mensaje_email,
            $admin_email,
            $admin_nombre
        );

        if ($resultado['ok']) {
            // Marcar email como enviado (por usuario)
            $usuario_id_nce = (int)($row['usuario_id'] ?? 0);
            marcar_email_enviado($conexion, $row['calendar_id'], $row['event_id'], $row['tipo_notif'], $usuario_id_nce);
            log_calendario("Email enviado para '{$row['titulo']}' ({$resultado['enviados']} destinatarios)");
            $emails_enviados++;
        } else {
            log_calendario("ERROR enviando email para '{$row['titulo']}': {$resultado['error']}");
        }
    }

    log_calendario("=== Envío completado: $emails_enviados emails enviados ===\n");
}

// Crear tabla de registro de eventos notificados si no existe (con usuario_id y fecha_evento)
function crear_tabla_registro($conexion) {
    $sql = "CREATE TABLE IF NOT EXISTS `notificaciones_calendario_eventos` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `usuario_id` INT NOT NULL DEFAULT 0,
        `calendar_id` VARCHAR(255) NOT NULL,
        `event_id` VARCHAR(255) NOT NULL,
        `tipo_notif` VARCHAR(20) NOT NULL,
        `fecha_evento` DATE DEFAULT NULL,
        `notificacion_id` INT NOT NULL,
        `fecha_envio` DATETIME NOT NULL,
        `email_enviado` TINYINT(1) NOT NULL DEFAULT 0,
        UNIQUE KEY `unique_event_notif` (`usuario_id`, `calendar_id`, `event_id`, `tipo_notif`, `fecha_evento`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conexion->query($sql);
    
    // Agregar columnas si no existen (para compatibilidad con versiones anteriores)
    $conexion->query("ALTER TABLE `notificaciones_calendario_eventos` ADD COLUMN IF NOT EXISTS `usuario_id` INT NOT NULL DEFAULT 0");
    $conexion->query("ALTER TABLE `notificaciones_calendario_eventos` ADD COLUMN IF NOT EXISTS `fecha_evento` DATE DEFAULT NULL");
    $conexion->query("ALTER TABLE `notificaciones_calendario_eventos` ADD COLUMN IF NOT EXISTS `email_enviado` TINYINT(1) NOT NULL DEFAULT 0");
    
    // Actualizar índice único si es necesario
    // Nota: Esto puede fallar silenciosamente si el índice ya existe con otra estructura
    $conexion->query("ALTER TABLE `notificaciones_calendario_eventos` DROP INDEX IF EXISTS `unique_event_notif`");
    $conexion->query("ALTER TABLE `notificaciones_calendario_eventos` ADD UNIQUE KEY `unique_event_notif` (`usuario_id`, `calendar_id`, `event_id`, `tipo_notif`, `fecha_evento`)");
}

// === EJECUCIÓN PRINCIPAL ===

log_calendario("Cron de notificaciones de calendario iniciado");

// Crear tabla de registro si no existe
crear_tabla_registro($conexion);

// Procesar calendarios
procesar_calendarios($conexion);

$conexion->close();
log_calendario("Script finalizado");
