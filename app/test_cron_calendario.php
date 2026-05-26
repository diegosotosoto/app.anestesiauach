<?php
/**
 * Test manual del cron de notificaciones de calendario
 * Ejecutar desde navegador para debug
 */

require('conectar.php');
require_once __DIR__ . '/app_security.php';

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

date_default_timezone_set('America/Santiago');

echo "<pre>";
echo "=== TEST CRON NOTIFICACIONES CALENDARIO ===\n";
echo "Hora servidor: " . date('Y-m-d H:i:s') . "\n";
echo "Hora Chile: " . date('H:i', strtotime('-0 hour')) . "\n";

// Verificar configuración
$smtp_config_path = __DIR__ . '/secure_config/smtp_config.php';
echo "\nSMTP config existe: " . (file_exists($smtp_config_path) ? 'SI' : 'NO') . "\n";

if (file_exists($smtp_config_path)) {
    require_once($smtp_config_path);
    echo "SMTP Host definido: " . (defined('APP_SMTP_HOST') ? APP_SMTP_HOST : 'NO') . "\n";
    echo "SMTP User definido: " . (defined('APP_SMTP_USER') ? 'SI' : 'NO') . "\n";
}

// Verificar PHPMailer
$phpmailer_exists = file_exists(__DIR__ . '/PHPMailer/src/PHPMailer.php');
echo "PHPMailer existe: " . ($phpmailer_exists ? 'SI' : 'NO') . "\n";

// Ver registros pendientes
$res = $conexion->query("SELECT COUNT(*) as total FROM notificaciones_calendario_eventos WHERE email_enviado = 0");
$row = $res->fetch_assoc();
echo "\nRegistros pendientes: " . $row['total'] . "\n";

// Ver detalle de pendientes
$res2 = $conexion->query("SELECT nce.*, n.titulo, ca.notif_email, ca.notif_hora, ca.nombre as calendario_nombre 
    FROM notificaciones_calendario_eventos nce 
    INNER JOIN notificaciones n ON n.id = nce.notificacion_id 
    INNER JOIN calendarios_app ca ON ca.calendar_id = nce.calendar_id 
    WHERE nce.email_enviado = 0 AND ca.notif_email = 1");

echo "\nDetalle de pendientes con notif_email=1:\n";
if ($res2->num_rows === 0) {
    echo "  NINGUNO - Los registros pendientes no tienen notif_email activo en el calendario\n";
} else {
    while ($r = $res2->fetch_assoc()) {
        echo "  - {$r['titulo']} | Calendario: {$r['calendario_nombre']} | Hora config: {$r['notif_hora']} | Email: {$r['notif_email']}\n";
    }
}

// Ver hora actual vs hora configurada
$hora_actual = date('H:00');
echo "\nHora actual: $hora_actual\n";

echo "\n=== FIN TEST ===";
echo "</pre>";
