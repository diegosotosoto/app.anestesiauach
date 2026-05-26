<?php
/**
 * Script de cron para limpiar sesiones de autenticación expiradas o revocadas
 * 
 * Ejecutar manualmente: php cron_limpiar_sesiones.php
 * Configuración cron (cPanel): 
 *   0 */6 * * * /usr/local/bin/php /home/anestes1/public_html/app/cron_limpiar_sesiones.php >> /home/anestes1/logs/cron_sesiones.log 2>&1
 */

// Cargar configuración de base de datos
require('conectar.php');

// Conectar a la base de datos
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

// Verificar conexión
if ($conexion->connect_error) {
    error_log("[cron_limpiar_sesiones] Error de conexión: " . $conexion->connect_error);
    exit(1);
}

$conexion->set_charset('utf8mb4');

// Ejecutar limpieza de sesiones
$sql = "DELETE FROM app_auth_sessions WHERE revoked_at IS NOT NULL OR expires_at < NOW()";

if ($conexion->query($sql)) {
    $afectadas = $conexion->affected_rows;
    $fecha = date('Y-m-d H:i:s');
    $mensaje = "[$fecha] Sesiones limpiadas: $afectadas filas eliminadas";
    
    // Log a archivo (si se redirige) o stdout
    echo $mensaje . "\n";
    
    // También log al error_log del sistema
    if ($afectadas > 0) {
        error_log("[cron_limpiar_sesiones] $mensaje");
    }
    
    $conexion->close();
    exit(0);
} else {
    $fecha = date('Y-m-d H:i:s');
    $error = "[$fecha] Error al limpiar sesiones: " . $conexion->error;
    echo $error . "\n";
    error_log("[cron_limpiar_sesiones] $error");
    
    $conexion->close();
    exit(1);
}
