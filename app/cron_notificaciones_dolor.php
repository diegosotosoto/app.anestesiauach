<?php
/**
 * Script de cron para notificaciones diarias de pacientes de dolor
 * 
 * EJECUCIÓN MANUAL:
 *   php cron_notificaciones_dolor.php
 * 
 * CONFIGURACIÓN CRON (ejecutar todos los días a las 08:00) - USA HORA DE CHILE:
 *   0 8 * * * /usr/bin/php /ruta/absoluta/cron_notificaciones_dolor.php >> /ruta/logs/cron_dolor.log 2>&1
 * 
 * Genera notificaciones recordatorio para usuarios con pacientes activos de dolor,
 * indicando cuántos días lleva cada paciente ingresado.
 */

require('conectar.php');
if (file_exists(__DIR__ . '/app_text_helpers.php')) {
    require_once __DIR__ . '/app_text_helpers.php';
}
require_once __DIR__ . '/app_security.php';
require_once __DIR__ . '/app_push_helpers.php';

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

// Establecer zona horaria de Chile
date_default_timezone_set('America/Santiago');

// Función de logging
function log_dolor($msg) {
    $fecha = date('Y-m-d H:i:s');
    echo "[$fecha] $msg\n";
}

// Función helper para escape HTML
function h($txt) {
    return htmlspecialchars((string)$txt, ENT_QUOTES, 'UTF-8');
}

// Crear notificación en el sistema
function crear_notificacion_dolor($conexion, $titulo, $mensaje, $usuario_id) {
    $fecha_inicio = date('Y-m-d H:i:s');
    $fecha_fin = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    $stmt = $conexion->prepare("INSERT INTO `notificaciones` 
        (`titulo`, `mensaje`, `tipo`, `alcance`, `url_destino`, `icono`, `creada_por`, `publicada`, `fecha_inicio`, `fecha_fin`)
        VALUES (?, ?, 'warning', 'individual', 'hoja_dolor.php', 'fa-solid fa-bell-medical', ?, 1, ?, ?)");
    
    if (!$stmt) {
        log_dolor("ERROR preparando statement: " . $conexion->error);
        return false;
    }
    
    $stmt->bind_param('ssiss', $titulo, $mensaje, $usuario_id, $fecha_inicio, $fecha_fin);
    
    if (!$stmt->execute()) {
        log_dolor("ERROR ejecutando statement: " . $stmt->error);
        $stmt->close();
        return false;
    }
    
    $notif_id = $stmt->insert_id;
    $stmt->close();
    return $notif_id;
}

// Asignar destinatario a notificación
function asignar_destinatario_notif($conexion, $notif_id, $usuario_id) {
    $stmt = $conexion->prepare("INSERT INTO `notificacion_destinatarios` (`notificacion_id`, `usuario_id`) VALUES (?, ?)");
    if (!$stmt) return false;
    $stmt->bind_param('ii', $notif_id, $usuario_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Verificar si ya existe notificación para este usuario hoy
function existe_notif_dolor_hoy($conexion, $usuario_id) {
    $hoy_inicio = date('Y-m-d 00:00:00');
    $hoy_fin = date('Y-m-d 23:59:59');
    
    $stmt = $conexion->prepare("SELECT n.`id` FROM `notificaciones` n
        INNER JOIN `notificacion_destinatarios` nd ON nd.`notificacion_id` = n.`id`
        WHERE nd.`usuario_id` = ? 
        AND n.`url_destino` = 'hoja_dolor.php'
        AND n.`fecha_inicio` BETWEEN ? AND ?
        LIMIT 1");
    
    if (!$stmt) return true; // Por seguridad, asumir que existe
    
    $stmt->bind_param('iss', $usuario_id, $hoy_inicio, $hoy_fin);
    $stmt->execute();
    $res = $stmt->get_result();
    $existe = $res->num_rows > 0;
    $stmt->close();
    
    return $existe;
}

// Obtener pacientes activos agrupados por creador
function obtener_pacientes_por_creador($conexion) {
    $pacientes_por_usuario = [];
    
    $sql = "SELECT 
            p.`nombre_paciente`, 
            p.`rut`, 
            p.`unidad_cama`, 
            p.`fecha_creacion`,
            p.`creador`,
            u.`ID` as usuario_id,
            u.`email_usuario`
        FROM `pacientes` p
        LEFT JOIN `usuarios_dolor` u ON u.`nombre_usuario` = p.`creador`
        WHERE p.`creador` IS NOT NULL 
        AND p.`creador` != ''
        AND u.`ID` IS NOT NULL
        ORDER BY p.`creador`, p.`fecha_creacion` ASC";
    
    $res = $conexion->query($sql);
    if (!$res) {
        log_dolor("ERROR consultando pacientes: " . $conexion->error);
        return $pacientes_por_usuario;
    }
    
    while ($row = $res->fetch_assoc()) {
        $uid = (int)$row['usuario_id'];
        if (!isset($pacientes_por_usuario[$uid])) {
            $pacientes_por_usuario[$uid] = [
                'usuario_id' => $uid,
                'email' => $row['email_usuario'],
                'nombre_creador' => $row['creador'],
                'pacientes' => []
            ];
        }
        
        // Calcular días de ingreso
        $fecha_ing = strtotime($row['fecha_creacion']);
        $fecha_hoy = strtotime(date('Y-m-d'));
        $dias_diff = max(1, floor(($fecha_hoy - $fecha_ing) / (60 * 60 * 24)));
        
        $pacientes_por_usuario[$uid]['pacientes'][] = [
            'nombre' => $row['nombre_paciente'],
            'rut' => $row['rut'],
            'unidad' => $row['unidad_cama'],
            'dias' => $dias_diff,
            'fecha_creacion' => $row['fecha_creacion']
        ];
    }
    
    return $pacientes_por_usuario;
}

// Procesar notificaciones de dolor
function procesar_notificaciones_dolor($conexion) {
    log_dolor("=== Iniciando notificaciones de pacientes dolor ===");
    log_dolor("Hora Chile: " . date('Y-m-d H:i:s'));
    
    // Obtener pacientes agrupados por creador
    $pacientes_por_usuario = obtener_pacientes_por_creador($conexion);
    
    if (empty($pacientes_por_usuario)) {
        log_dolor("No hay pacientes activos con creador asignado");
        return 0;
    }
    
    $notif_creadas = 0;
    
    foreach ($pacientes_por_usuario as $uid => $data) {
        // Verificar si ya existe notificación para este usuario hoy
        if (existe_notif_dolor_hoy($conexion, $uid)) {
            log_dolor("Usuario #{$uid}: Ya tiene notificación hoy, omitiendo");
            continue;
        }
        
        $cantidad = count($data['pacientes']);
        if ($cantidad === 0) continue;
        
        // Encontrar el paciente más antiguo (máximo días)
        $max_dias = 0;
        foreach ($data['pacientes'] as $pac) {
            if ($pac['dias'] > $max_dias) {
                $max_dias = $pac['dias'];
            }
        }
        
        // Preparar texto según cantidad
        if ($cantidad === 1) {
            $titulo = "🏥 Tienes 1 paciente activo en Dolor";
            $dias_texto = ($max_dias == 1) ? "1 día" : "{$max_dias} días";
            $mensaje = "Tienes 1 paciente activo hace {$dias_texto} en manejo de dolor agudo. No olvides la evaluación diaria.";
        } else {
            $titulo = "🏥 Tienes {$cantidad} pacientes activos en Dolor";
            $dias_texto = ($max_dias == 1) ? "1 día" : "{$max_dias} días";
            $mensaje = "Tienes {$cantidad} pacientes activos, el más antiguo hace {$dias_texto}, en manejo de dolor agudo. No olvides la evaluación diaria.";
        }
        
        // Crear notificación
        $notif_id = crear_notificacion_dolor($conexion, $titulo, $mensaje, $uid);
        if ($notif_id) {
            asignar_destinatario_notif($conexion, $notif_id, $uid);
            app_push_send_to_users($conexion, [$uid], $titulo, $mensaje, '/hoja_dolor.php', 'fa-solid fa-bell-medical', 'notif_dolor');
            log_dolor("Notificación creada para usuario #{$uid} ({$cantidad} pacientes)");
            $notif_creadas++;
        } else {
            log_dolor("ERROR creando notificación para usuario #{$uid}");
        }
    }
    
    log_dolor("=== Proceso completado: {$notif_creadas} notificaciones creadas ===\n");
    return $notif_creadas;
}

// === EJECUCIÓN PRINCIPAL ===

log_dolor("Cron de notificaciones dolor iniciado");

// Procesar notificaciones
$total = procesar_notificaciones_dolor($conexion);

$conexion->close();
log_dolor("Script finalizado");
