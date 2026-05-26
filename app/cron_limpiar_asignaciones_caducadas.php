<?php
require('conectar.php');
require_once __DIR__ . '/google-calendar/config.php';

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

if ($conexion->connect_error) {
    error_log("Error de conexión: " . $conexion->connect_error);
    exit(1);
}

$hoy = date('Y-m-d');

// Buscar asignaciones caducadas (fecha_fin < hoy y fecha_fin no es NULL)
$sql_caducadas = "SELECT ca.`id`, ca.`calendario_id`, c.`calendar_id`
    FROM `calendario_asignaciones` ca
    INNER JOIN `calendarios_app` c ON c.`id` = ca.`calendario_id`
    WHERE ca.`fecha_fin` IS NOT NULL 
      AND ca.`fecha_fin` < ?
      AND ca.`activo` = 1";

$stmt_caducadas = $conexion->prepare($sql_caducadas);
if (!$stmt_caducadas) {
    error_log("Error preparando consulta de asignaciones caducadas: " . $conexion->error);
    $conexion->close();
    exit(1);
}

$stmt_caducadas->bind_param('s', $hoy);
$stmt_caducadas->execute();
$res_caducadas = $stmt_caducadas->get_result();

$eliminadas = 0;
$notificaciones_eliminadas = 0;

if ($res_caducadas && $res_caducadas->num_rows > 0) {
    $conexion->begin_transaction();
    try {
        while ($row = $res_caducadas->fetch_assoc()) {
            $asignacion_id = (int)$row['id'];
            $calendar_id_google = $row['calendar_id'];

            // Eliminar notificaciones de eventos de esta asignación
            if ($calendar_id_google !== '') {
                $stmt_notif = $conexion->prepare("DELETE FROM `notificaciones_calendario_eventos` WHERE `calendar_id` = ?");
                if ($stmt_notif) {
                    $stmt_notif->bind_param('s', $calendar_id_google);
                    $stmt_notif->execute();
                    $notificaciones_eliminadas += $stmt_notif->affected_rows;
                    $stmt_notif->close();
                }
            }

            // Desactivar o eliminar la asignación (aquí se desactiva para mantener historial)
            $stmt_asig = $conexion->prepare("UPDATE `calendario_asignaciones` SET `activo` = 0 WHERE `id` = ?");
            if ($stmt_asig) {
                $stmt_asig->bind_param('i', $asignacion_id);
                $stmt_asig->execute();
                if ($stmt_asig->affected_rows > 0) {
                    $eliminadas++;
                }
                $stmt_asig->close();
            }
        }

        $conexion->commit();
        error_log("Cron limpieza asignaciones caducadas: $eliminadas asignaciones desactivadas, $notificaciones_eliminadas notificaciones eliminadas. Fecha: $hoy");
    } catch (Exception $e) {
        $conexion->rollback();
        error_log("Error en cron limpieza asignaciones caducadas: " . $e->getMessage());
        $conexion->close();
        exit(1);
    }
} else {
    error_log("Cron limpieza asignaciones caducadas: No hay asignaciones caducadas. Fecha: $hoy");
}

$stmt_caducadas->close();
$conexion->close();

echo "Limpieza completada: $eliminadas asignaciones desactivadas, $notificaciones_eliminadas notificaciones eliminadas.\n";
