<?php
/**
 * Funciones para crear notificaciones de calendario
 * Se usa en calendario.php y index.php
 */

// Verificar si ya existe notificación para este evento y usuario
function cal_notif_existe($conexion, $calendar_id, $event_id, $tipo_notif, $fecha_evento = null, $usuario_id = 0) {
    if ($fecha_evento !== null) {
        $stmt = $conexion->prepare("
            SELECT `id` FROM `notificaciones_calendario_eventos`
            WHERE `usuario_id` = ? AND `calendar_id` = ? AND `event_id` = ? AND `tipo_notif` = ? AND `fecha_evento` = ?
            LIMIT 1
        ");
        if (!$stmt) return true;
        $stmt->bind_param('issss', $usuario_id, $calendar_id, $event_id, $tipo_notif, $fecha_evento);
    } else {
        $stmt = $conexion->prepare("
            SELECT `id` FROM `notificaciones_calendario_eventos`
            WHERE `usuario_id` = ? AND `calendar_id` = ? AND `event_id` = ? AND `tipo_notif` = ?
            LIMIT 1
        ");
        if (!$stmt) return true;
        $stmt->bind_param('isss', $usuario_id, $calendar_id, $event_id, $tipo_notif);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    $existe = $res->num_rows > 0;
    $stmt->close();
    return $existe;
}

// Crear notificación en el sistema
function cal_notif_crear($conexion, $titulo, $mensaje, $creada_por) {
    $stmt = $conexion->prepare("
        INSERT INTO `notificaciones`
        (`titulo`, `mensaje`, `tipo`, `alcance`, `url_destino`, `icono`, `creada_por`, `publicada`, `fecha_inicio`, `fecha_fin`)
        VALUES (?, ?, 'info', 'individual', 'calendario.php', 'fa-regular fa-calendar', ?, 1, NOW(), NULL)
    ");
    if (!$stmt) return false;
    $stmt->bind_param('ssi', $titulo, $mensaje, $creada_por);
    try {
        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }
    } catch (Exception $e) {
        $stmt->close();
        return false;
    }
    $notif_id = $stmt->insert_id;
    $stmt->close();
    return $notif_id;
}

// Asignar destinatarios a notificación
function cal_notif_asignar_usuario($conexion, $notif_id, $usuario_id) {
    $stmt = $conexion->prepare("
        INSERT INTO `notificacion_destinatarios` (`notificacion_id`, `usuario_id`)
        VALUES (?, ?)
    ");
    if (!$stmt) return false;
    $stmt->bind_param('ii', $notif_id, $usuario_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Registrar evento como notificado (por usuario)
function cal_notif_registrar_evento($conexion, $calendar_id, $event_id, $tipo_notif, $notif_id, $fecha_evento = null, $usuario_id = 0) {
    $stmt = $conexion->prepare("
        INSERT INTO `notificaciones_calendario_eventos`
        (`usuario_id`, `calendar_id`, `event_id`, `tipo_notif`, `fecha_evento`, `notificacion_id`, `fecha_envio`)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmt) return false;
    $stmt->bind_param('issssi', $usuario_id, $calendar_id, $event_id, $tipo_notif, $fecha_evento, $notif_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Procesar eventos y crear notificaciones
function cal_notif_procesar_eventos($conexion, $usuario_id, $calendarios, $eventos) {
    if (empty($calendarios) || empty($eventos)) return 0;

    $hoy = date('Y-m-d');
    $notif_creadas = 0;

    // Indexar calendarios por ID
    $cals_por_id = [];
    foreach ($calendarios as $cal) {
        $cals_por_id[(int)$cal['id']] = $cal;
    }

    foreach ($eventos as $evento) {
        $cal_id_app = $evento['_calendar_id_app'] ?? 0;
        if (!isset($cals_por_id[$cal_id_app])) continue;

        $cal = $cals_por_id[$cal_id_app];
        $calendar_id_google = $cal['calendar_id'];
        $event_id = $evento['id'] ?? '';
        if (!$event_id) continue;

        $titulo_evento = $evento['summary'] ?? 'Evento sin título';

        // Obtener fecha del evento
        $fecha_evento_str = $evento['start']['dateTime'] ?? ($evento['start']['date'] ?? '');
        if (!$fecha_evento_str) continue;

        $fecha_evento = date('Y-m-d', strtotime($fecha_evento_str));
        $dias_hasta = (int)floor((strtotime($fecha_evento) - strtotime($hoy)) / 86400);

        // Solo procesar eventos futuros o de hoy
        if ($dias_hasta < 0) continue;

        // Determinar tipo de notificación
        $notif_dias = (int)($cal['notif_dias'] ?? 0);
        $notif_same_day = (int)($cal['notif_same_day'] ?? 0);

        $tipo_notif = null;
        $titulo_notif = null;

        // Notificación mismo día
        if ($notif_same_day && $dias_hasta === 0) {
            $tipo_notif = 'same_day';
            $titulo_notif = "📅 Hoy: $titulo_evento";
        }
        // Notificación anticipada en el día exacto configurado
        elseif ($notif_dias >= 1 && $dias_hasta === $notif_dias) {
            $tipo_notif = 'first';
            $titulo_notif = $notif_dias === 1
                ? "⏰ Mañana: $titulo_evento"
                : "⏰ En $notif_dias días: $titulo_evento";
        }
        // Notificación de rescate: se perdió el día ideal pero el evento aún no ocurre
        // Aplica si faltan entre 1 y notif_dias-1 días, y aún no existe notif 'first' para este evento+fecha
        elseif ($notif_dias >= 2 && $dias_hasta >= 1 && $dias_hasta < $notif_dias) {
            if (!cal_notif_existe($conexion, $calendar_id_google, $event_id, 'first', $fecha_evento, $usuario_id)) {
                $tipo_notif = 'first';
                $titulo_notif = $dias_hasta === 1
                    ? "⏰ Mañana: $titulo_evento"
                    : "⏰ En $dias_hasta días: $titulo_evento";
            }
        }

        if (!$tipo_notif || !$titulo_notif) continue;

        // Verificar si ya existe para este usuario y fecha (permite nueva notif si el evento fue reprogramado)
        if (cal_notif_existe($conexion, $calendar_id_google, $event_id, $tipo_notif, $fecha_evento, $usuario_id)) {
            continue;
        }

        // Preparar mensaje (sin título del evento que ya va en el título de la notificación)
        $mensaje_parts = [];

        // Solo mostrar fecha si no es notificación de "hoy"
        if ($tipo_notif !== 'same_day') {
            $fecha_formateada = date('d/m/Y', strtotime($fecha_evento_str));
            if (isset($evento['start']['dateTime'])) {
                $fecha_formateada .= ' ' . date('H:i', strtotime($fecha_evento_str));
            }
            $mensaje_parts[] = "📆 Fecha: $fecha_formateada";
        }

        if (!empty($evento['location'])) $mensaje_parts[] = "📍 Lugar: " . $evento['location'];
        if (!empty($evento['description'])) $mensaje_parts[] = "📝 Notas: " . $evento['description'];
        $mensaje_parts[] = "📋 Calendario: " . $cal['nombre'];

        $mensaje = implode("\n", $mensaje_parts);

        // Crear notificación
        $notif_id = cal_notif_crear($conexion, $titulo_notif, $mensaje, $usuario_id);
        if (!$notif_id) continue;

        // Asignar al usuario
        cal_notif_asignar_usuario($conexion, $notif_id, $usuario_id);

        // Registrar evento como notificado (por usuario)
        cal_notif_registrar_evento($conexion, $calendar_id_google, $event_id, $tipo_notif, $notif_id, $fecha_evento, $usuario_id);

        $notif_creadas++;
    }

    return $notif_creadas;
}

// Eliminar una notificación de calendario y limpiar sus referencias
function cal_notif_eliminar($conexion, $usuario_id, $nce_id, $notif_id) {
    $conexion->query("DELETE FROM notificaciones_calendario_eventos WHERE id = $nce_id");
    $conexion->query("DELETE FROM notificacion_destinatarios WHERE notificacion_id = $notif_id AND usuario_id = " . (int)$usuario_id);
    $chk = $conexion->query("SELECT COUNT(*) AS c FROM notificacion_destinatarios WHERE notificacion_id = $notif_id");
    if ($chk) {
        $cnt = $chk->fetch_assoc();
        if ((int)$cnt['c'] === 0) {
            $conexion->query("DELETE FROM notificaciones WHERE id = $notif_id");
        }
    }
}

// Eliminar notificaciones de eventos eliminados o reprogramados en Google Calendar
// $event_fechas_por_cal = [ gcal_id => [ event_id => fecha_actual_Y-m-d, ... ], ... ]
function cal_notif_limpiar_eliminados($conexion, $usuario_id, $event_fechas_por_cal) {
    if (empty($event_fechas_por_cal)) return;

    foreach ($event_fechas_por_cal as $gcal_id => $event_fechas) {
        $event_ids_activos = array_keys($event_fechas);

        // Obtener todos los registros de este calendario para este usuario (ahora con usuario_id en la tabla)
        $res = $conexion->query("
            SELECT nce.id, nce.event_id, nce.fecha_evento, nce.notificacion_id
            FROM notificaciones_calendario_eventos nce
            WHERE nce.calendar_id = '" . $conexion->real_escape_string($gcal_id) . "'
              AND nce.usuario_id = " . (int)$usuario_id
        );
        if (!$res) continue;

        while ($row = $res->fetch_assoc()) {
            $nce_id   = (int)$row['id'];
            $notif_id = (int)$row['notificacion_id'];
            $event_id = $row['event_id'];
            $fecha_registrada = $row['fecha_evento'];

            // Caso 1: evento eliminado de Google Calendar
            if (!in_array($event_id, $event_ids_activos, true)) {
                cal_notif_eliminar($conexion, $usuario_id, $nce_id, $notif_id);
                continue;
            }

            // Caso 2: evento reprogramado (misma fecha registrada != fecha actual en Google)
            $fecha_actual = $event_fechas[$event_id] ?? null;
            if ($fecha_actual && $fecha_registrada && $fecha_registrada !== $fecha_actual) {
                cal_notif_eliminar($conexion, $usuario_id, $nce_id, $notif_id);
            }
        }
    }
}

// Función principal: obtener calendarios del usuario y crear notificaciones
function cal_notif_generar_para_usuario($conexion, $usuario_id, $esBecado, $esAdmin, $anioResidencia, $usuario_extra = []) {
    // Solo cargar config si existe
    $config_path = __DIR__ . '/google-calendar/config.php';
    if (!file_exists($config_path)) return 0;
    require_once $config_path;

    if (!function_exists('google_calendar_is_configured') || !google_calendar_is_configured()) {
        return 0;
    }

    $hoy = date('Y-m-d');
    $calendarios = [];
    $calendarioIdsYaAgregados = [];

    // Determinar tipos base según usuario
    $tiposBase = ['general'];
    if ($esBecado && in_array($anioResidencia, ['1', '2', '3'], true)) {
        $tiposBase[] = 'r' . (int)$anioResidencia;
    }
    $tieneStaff = !empty($usuario_extra['staff_']);
    if ($esAdmin || $tieneStaff) {
        $tiposBase[] = 'staff';
    }
    if (!empty($usuario_extra['docente_'])) {
        $tiposBase[] = 'docente';
    }
    if (!empty($usuario_extra['intern_'])) {
        $tiposBase[] = 'intern';
    }
    // Calendarios del programa Anestesia: notificaciones para becados de anestesia y staff
    if ($esBecado || $tieneStaff) {
        $tiposBase[] = 'anestesia_programa';
    }

    // Verificar si existe columna color
    $res_col = $conexion->query("SHOW COLUMNS FROM `calendarios_app` LIKE 'color'");
    $tieneColor = $res_col && $res_col->num_rows > 0;
    $selectColor = $tieneColor ? "`color`" : "NULL AS `color`";

    // Calendarios base
    $placeholders = implode(',', array_fill(0, count($tiposBase), '?'));
    $sqlBase = "SELECT `id`, `nombre`, `calendar_id`, `tipo`, $selectColor,
            `notif_dias`, `notif_same_day`, `notif_email`, `notif_weekdays`, `notif_hora`
        FROM `calendarios_app`
        WHERE `activo` = 1
          AND `tipo` IN ($placeholders)
        ORDER BY FIELD(`tipo`, 'general', 'r1', 'r2', 'r3', 'staff', 'docente', 'intern', 'anestesia_programa'), `nombre` ASC";

    $stmtBase = $conexion->prepare($sqlBase);
    if ($stmtBase) {
        $types = str_repeat('s', count($tiposBase));
        $stmtBase->bind_param($types, ...$tiposBase);
        $stmtBase->execute();
        $resBase = $stmtBase->get_result();
        if ($resBase) {
            while ($row = $resBase->fetch_assoc()) {
                $id = (int)$row['id'];
                $row['origen'] = 'base';
                $calendarios[] = $row;
                $calendarioIdsYaAgregados[$id] = true;
            }
        }
        $stmtBase->close();
    }

    // Calendarios asignados
    $sqlAsignados = "SELECT c.`id`, c.`nombre`, c.`calendar_id`, c.`tipo`, $selectColor,
            c.`notif_dias`, c.`notif_same_day`, c.`notif_email`, c.`notif_weekdays`, c.`notif_hora`,
            ca.`fecha_inicio`, ca.`fecha_fin`
        FROM `calendario_asignaciones` ca
        INNER JOIN `calendarios_app` c ON c.`id` = ca.`calendario_id`
        WHERE ca.`usuario_id` = ?
          AND ca.`activo` = 1
          AND c.`activo` = 1
          AND ca.`fecha_inicio` <= ?
          AND (ca.`fecha_fin` IS NULL OR ca.`fecha_fin` = '0000-00-00' OR ca.`fecha_fin` >= ?)
        ORDER BY ca.`fecha_inicio` DESC, c.`nombre` ASC";

    $stmtAsignados = $conexion->prepare($sqlAsignados);
    if ($stmtAsignados) {
        $stmtAsignados->bind_param('iss', $usuario_id, $hoy, $hoy);
        $stmtAsignados->execute();
        $resAsignados = $stmtAsignados->get_result();
        if ($resAsignados) {
            while ($row = $resAsignados->fetch_assoc()) {
                $id = (int)$row['id'];
                if (isset($calendarioIdsYaAgregados[$id])) continue;
                $row['origen'] = 'asignado';
                $calendarios[] = $row;
                $calendarioIdsYaAgregados[$id] = true;
            }
        }
        $stmtAsignados->close();
    }

    if (empty($calendarios)) return 0;

    // Obtener eventos de Google Calendar
    $timeMin = new DateTime('today', new DateTimeZone('America/Santiago'));
    $timeMax = (clone $timeMin)->modify('+30 days');
    $eventos = [];
    // Rastrear event_id => fecha_actual por calendar_id de Google (para detectar eliminados y reprogramados)
    $event_fechas_por_cal = [];

    foreach ($calendarios as $cal) {
        try {
            if (!function_exists('google_calendar_fetch_events')) continue;
            $items = google_calendar_fetch_events($cal['calendar_id'], $timeMin, $timeMax, 50);
            $gcal_id = $cal['calendar_id'];
            if (!isset($event_fechas_por_cal[$gcal_id])) {
                $event_fechas_por_cal[$gcal_id] = [];
            }
            foreach ($items as $item) {
                $item['_calendar_id_app'] = (int)$cal['id'];
                $item['_calendar_nombre'] = $cal['nombre'];
                $eventos[] = $item;
                if (!empty($item['id'])) {
                    $fecha_item_str = $item['start']['dateTime'] ?? ($item['start']['date'] ?? '');
                    $fecha_item = $fecha_item_str ? date('Y-m-d', strtotime($fecha_item_str)) : null;
                    $event_fechas_por_cal[$gcal_id][$item['id']] = $fecha_item;
                }
            }
        } catch (Throwable $e) {
            // Ignorar errores de calendarios individuales
        }
    }

    // Limpiar notificaciones de eventos eliminados o reprogramados
    cal_notif_limpiar_eliminados($conexion, $usuario_id, $event_fechas_por_cal);

    // Crear notificaciones
    return cal_notif_procesar_eventos($conexion, $usuario_id, $calendarios, $eventos);
}
