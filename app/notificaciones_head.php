<?php
$notificaciones_nav = [];
$total_notificaciones_no_leidas = 0;
$usuario_id_nav = 0;
$email_usuario_cookie = null;

if (isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) && $_COOKIE['hkjh41lu4l1k23jhlkj13'] !== '') {
    $email_usuario_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

    $sql_usuario_nav = "SELECT ID
                        FROM usuarios_dolor
                        WHERE email_usuario = ?
                          AND verified = 1
                        LIMIT 1";

    $stmt_usuario_nav = $conexion->prepare($sql_usuario_nav);

    if ($stmt_usuario_nav) {
        $stmt_usuario_nav->bind_param("s", $email_usuario_cookie);
        $stmt_usuario_nav->execute();

        if (method_exists($stmt_usuario_nav, 'get_result')) {
            $res_usuario_nav = $stmt_usuario_nav->get_result();
            if ($fila_usuario_nav = $res_usuario_nav->fetch_assoc()) {
                $usuario_id_nav = (int)$fila_usuario_nav['ID'];
            }
        } else {
            $stmt_usuario_nav->bind_result($usuario_id_tmp);
            if ($stmt_usuario_nav->fetch()) {
                $usuario_id_nav = (int)$usuario_id_tmp;
            }
        }

        $stmt_usuario_nav->close();
    }
}

if ($usuario_id_nav > 0) {
    $sql_count = "SELECT COUNT(*) AS total_no_leidas
                  FROM notificacion_destinatarios nd
                  INNER JOIN notificaciones n
                      ON n.id = nd.notificacion_id
                  WHERE nd.usuario_id = ?
                    AND nd.leida = 0
                    AND nd.archivada = 0
                    AND n.publicada = 1
                    AND n.fecha_inicio <= NOW()
                    AND (n.fecha_fin IS NULL OR n.fecha_fin >= NOW())";

    $stmt_count = $conexion->prepare($sql_count);

    if ($stmt_count) {
        $stmt_count->bind_param("i", $usuario_id_nav);
        $stmt_count->execute();

        if (method_exists($stmt_count, 'get_result')) {
            $res_count = $stmt_count->get_result();
            if ($fila_count = $res_count->fetch_assoc()) {
                $total_notificaciones_no_leidas = (int)$fila_count['total_no_leidas'];
            }
        } else {
            $stmt_count->bind_result($total_no_leidas_tmp);
            if ($stmt_count->fetch()) {
                $total_notificaciones_no_leidas = (int)$total_no_leidas_tmp;
            }
        }

        $stmt_count->close();
    }

    $sql_nav = "SELECT
                    nd.id AS destinatario_id,
                    nd.leida,
                    n.id AS notificacion_id,
                    n.titulo,
                    n.mensaje,
                    n.tipo,
                    n.url_destino,
                    n.icono,
                    n.fecha_inicio
                FROM notificacion_destinatarios nd
                INNER JOIN notificaciones n
                    ON n.id = nd.notificacion_id
                WHERE nd.usuario_id = ?
                  AND nd.archivada = 0
                  AND n.publicada = 1
                  AND n.fecha_inicio <= NOW()
                  AND (n.fecha_fin IS NULL OR n.fecha_fin >= NOW())
                ORDER BY nd.leida ASC, n.fecha_inicio DESC, n.id DESC
                LIMIT 5";

    $stmt_nav = $conexion->prepare($sql_nav);

    if ($stmt_nav) {
        $stmt_nav->bind_param("i", $usuario_id_nav);
        $stmt_nav->execute();

        if (method_exists($stmt_nav, 'get_result')) {
            $res_nav = $stmt_nav->get_result();
            while ($row_nav = $res_nav->fetch_assoc()) {
                $notificaciones_nav[] = $row_nav;
            }
        } else {
            $stmt_nav->bind_result(
                $destinatario_id_tmp,
                $leida_tmp,
                $notificacion_id_tmp,
                $titulo_tmp,
                $mensaje_tmp,
                $tipo_tmp,
                $url_destino_tmp,
                $icono_tmp,
                $fecha_inicio_tmp
            );

            while ($stmt_nav->fetch()) {
                $notificaciones_nav[] = [
                    'destinatario_id' => $destinatario_id_tmp,
                    'leida' => $leida_tmp,
                    'notificacion_id' => $notificacion_id_tmp,
                    'titulo' => $titulo_tmp,
                    'mensaje' => $mensaje_tmp,
                    'tipo' => $tipo_tmp,
                    'url_destino' => $url_destino_tmp,
                    'icono' => $icono_tmp,
                    'fecha_inicio' => $fecha_inicio_tmp
                ];
            }
        }

        $stmt_nav->close();
    }
}
?>



<?php
/*
|--------------------------------------------------------------------------
| Notificaciones automáticas de aprobaciones pendientes para staff
|--------------------------------------------------------------------------
|
| Se generan al vuelo cada vez que carga el head.
| NO se guardan en base de datos como notificaciones físicas.
| Si el staff las oculta pero no aprueba, reaparecen al volver a cargar.
|
*/

if (isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) && trim($_COOKIE['hkjh41lu4l1k23jhlkj13']) !== '') {
    $staff_email_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

    // Pendientes en bitácora de residentes / becados generales
    $pendientes_bitacora_b = 0;

    $sql_pend_b = "SELECT COUNT(*) AS total
                   FROM bitacora_proced
                   WHERE staff_b = ?
                     AND aprobado_staff_b = 0";

    $stmt_pend_b = $conexion->prepare($sql_pend_b);

    if ($stmt_pend_b) {
        $stmt_pend_b->bind_param("s", $staff_email_cookie);
        $stmt_pend_b->execute();

        if (method_exists($stmt_pend_b, 'get_result')) {
            $res_pend_b = $stmt_pend_b->get_result();
            if ($row_pend_b = $res_pend_b->fetch_assoc()) {
                $pendientes_bitacora_b = (int)$row_pend_b['total'];
            }
        } else {
            $stmt_pend_b->bind_result($pend_b_tmp);
            if ($stmt_pend_b->fetch()) {
                $pendientes_bitacora_b = (int)$pend_b_tmp;
            }
        }

        $stmt_pend_b->close();
    }

    // Pendientes en bitácora de internos / becados pasantes
    $pendientes_bitacora_i = 0;

    $sql_pend_i = "SELECT COUNT(*) AS total
                   FROM bitacora_internos
                   WHERE staff_i = ?
                     AND aprobado_staff_i = 0";

    $stmt_pend_i = $conexion->prepare($sql_pend_i);

    if ($stmt_pend_i) {
        $stmt_pend_i->bind_param("s", $staff_email_cookie);
        $stmt_pend_i->execute();

        if (method_exists($stmt_pend_i, 'get_result')) {
            $res_pend_i = $stmt_pend_i->get_result();
            if ($row_pend_i = $res_pend_i->fetch_assoc()) {
                $pendientes_bitacora_i = (int)$row_pend_i['total'];
            }
        } else {
            $stmt_pend_i->bind_result($pend_i_tmp);
            if ($stmt_pend_i->fetch()) {
                $pendientes_bitacora_i = (int)$pend_i_tmp;
            }
        }

        $stmt_pend_i->close();
    }

    // Armar notificaciones automáticas y ponerlas arriba
    $notificaciones_sistema = [];

    if ($pendientes_bitacora_b > 0) {
        $notificaciones_sistema[] = [
            'destinatario_id' => 'auto_bitacora_b_' . md5($staff_email_cookie),
            'leida' => 0,
            'notificacion_id' => 0,
            'titulo' => 'Bitácora pendiente de Aprobación',
            'mensaje' => 'Tienes ' . $pendientes_bitacora_b . ' procedimiento(s) por aprobar.',
            'tipo' => 'warning',
            'url_destino' => 'bitacora_autoriza.php',
            'icono' => 'fa-solid fa-clipboard-check',
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'es_sistema' => 1
        ];
    }

    if ($pendientes_bitacora_i > 0) {
        $notificaciones_sistema[] = [
            'destinatario_id' => 'auto_bitacora_i_' . md5($staff_email_cookie),
            'leida' => 0,
            'notificacion_id' => 0,
            'titulo' => 'Bitácora pendiente de Aprobación',
            'mensaje' => 'Tienes ' . $pendientes_bitacora_i . ' procedimiento(s) por aprobar.',
            'tipo' => 'warning',
            'url_destino' => 'bitacora_internos.php',
            'icono' => 'fa-solid fa-user-check',
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'es_sistema' => 1
        ];
    }

    if (!empty($notificaciones_sistema)) {
        $notificaciones_nav = array_merge($notificaciones_sistema, $notificaciones_nav);
        $total_notificaciones_no_leidas += count($notificaciones_sistema);
    }
}
?>
