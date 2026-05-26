<?php
require('conectar.php');
if (file_exists(__DIR__ . '/app_text_helpers.php')) {
    require_once __DIR__ . '/app_text_helpers.php';
}
require_once __DIR__ . '/app_security.php';

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

function h($txt)
{
    return htmlspecialchars((string)$txt, ENT_QUOTES, 'UTF-8');
}

function h_nombre($txt)
{
    if (function_exists('app_h_text')) {
        return app_h_text($txt);
    }
    return htmlspecialchars(html_entity_decode((string)$txt, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8');
}

function app_lower_text($txt, $encoding = 'UTF-8')
{
    $txt = (string)$txt;
    if (function_exists('mb_strtolower')) {
        return mb_strtolower($txt, $encoding);
    }
    return strtolower($txt);
}

function post_val($key, $default = '')
{
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}
function usuario_grupo_key($usr)
{
    $admin = isset($usr['admin']) ? (int)$usr['admin'] : 0;
    $staff = isset($usr['staff_']) ? (int)$usr['staff_'] : 0;
    $docente = isset($usr['docente_']) ? (int)$usr['docente_'] : 0;
    $interno = isset($usr['intern_']) ? (int)$usr['intern_'] : 0;
    $becad = isset($usr['becad_']) ? (int)$usr['becad_'] : 0;
    $becadOtro = isset($usr['becad_otro']) ? (int)$usr['becad_otro'] : 0;
    $nivel = isset($usr['nivel_residencia']) ? $usr['nivel_residencia'] : '';

    // Prioridad: R1, R2, R3 por nivel_residencia
    if ($nivel === 'r1') {
        return 'r1';
    }
    if ($nivel === 'r2') {
        return 'r2';
    }
    if ($nivel === 'r3') {
        return 'r3';
    }
    // Fallback por becad_ + anio_residencia (compatibilidad)
    $anio = isset($usr['anio_residencia']) ? (int)$usr['anio_residencia'] : 0;
    if ($becad === 1 || $anio > 0) {
        return 'becados';
    }
    if ($becadOtro === 1 || $interno === 1) {
        return 'becados_pasantes';
    }
    // Staff: diferenciar docente vs no-docente
    if ($staff === 1 && $docente === 1) {
        return 'docente';
    }
    if ($staff === 1) {
        return 'staff';
    }
    if ($admin === 1) {
        return 'individual';
    }
    return 'individual';
}

function usuario_grupo_label($grupo)
{
    $labels = array(
        'r1' => 'R1',
        'r2' => 'R2',
        'r3' => 'R3',
        'becados' => 'Becados (sin nivel)',
        'becados_pasantes' => 'Becados Pasantes',
        'docente' => 'Docentes',
        'staff' => 'Staff (no docente)',
        'individual' => 'Individual'
    );
    return $labels[$grupo] ?? 'Individual';
}

function tipo_label($tipo)
{
    $labels = array(
        'general' => 'General (todos)',
        'r1' => 'Residentes R1',
        'r2' => 'Residentes R2',
        'r3' => 'Residentes R3',
        'staff' => 'Staff',
        'docente' => 'Docentes',
        'intern' => 'Internos',
        'anestesia_programa' => 'Programa Anestesia (Residentes + Staff)',
        'turnos' => 'Turnos',
        'examenes' => 'Ex&aacute;menes',
        'rotaciones' => 'Rotaciones',
        'classroom' => 'Classroom',
        'personal' => 'Personal'
    );
    return $labels[$tipo] ?? strtoupper((string)$tipo);
}

app_require_login($conexion, 'login.php');

$usuarioAdmin = app_current_user($conexion);

if (!$usuarioAdmin || (int)$usuarioAdmin['admin'] !== 1) {
    header('Location: login.php');
    exit;
}

if($usuarioAdmin['external_']==1){
  header('Location: index.php');
  exit;
}

$emailUsuario = trim((string)$usuarioAdmin['email_usuario']);
$mensajeOk = '';
$mensajeError = '';
$tiposValidos = array('general', 'r1', 'r2', 'r3', 'staff', 'docente', 'intern', 'anestesia_programa', 'turnos', 'examenes', 'rotaciones', 'classroom', 'personal');

// Notification settings labels
$opcionesNotif = array(
    'first' => 'Primera notificación',
    'same_day' => 'El mismo día',
    'email' => 'También por email'
);

// Días disponibles para primera notificación (1-7 días)
$dias_notif_opciones = array(1 => '1 día antes', 2 => '2 días antes', 3 => '3 días antes', 4 => '4 días antes', 5 => '5 días antes', 6 => '6 días antes', 7 => '7 días antes');

// Horas disponibles para envío de email (8:00 a 17:00, días de semana)
$horas_email_opciones = array();
for ($h = 8; $h <= 17; $h++) {
    $hora_str = sprintf('%02d:00', $h);
    $horas_email_opciones[$hora_str] = $hora_str;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = post_val('accion');

    if ($accion === 'guardar_calendario') {
        $id = (int)post_val('id', '0');
        $nombre = post_val('nombre');
        $calendarId = post_val('calendar_id');
        $tipo = strtolower(post_val('tipo'));
        $activo = isset($_POST['activo']) ? 1 : 0;
        $notif_dias = isset($_POST['notif_dias']) ? min(7, max(1, (int)$_POST['notif_dias'])) : 2;
        $notif_same_day = isset($_POST['notif_same_day']) ? 1 : 0;
        $notif_email = isset($_POST['notif_email']) ? 1 : 0;
        $notif_weekdays = isset($_POST['notif_weekdays']) ? 1 : 0;
        $notif_hora = isset($_POST['notif_hora']) ? preg_replace('/[^0-9:]/', '', $_POST['notif_hora']) : '08:00';
        if (!preg_match('/^([0-9]{2}):([0-9]{2})$/', $notif_hora)) {
            $notif_hora = '08:00';
        }

        if ($nombre === '' || $calendarId === '' || !in_array($tipo, $tiposValidos, true)) {
            $mensajeError = 'Faltan datos obligatorios o el tipo no es v&aacute;lido.';
        } elseif ($id > 0) {
            $stmt = $conexion->prepare("UPDATE `calendarios_app`
                SET `nombre` = ?, `calendar_id` = ?, `tipo` = ?, `activo` = ?, `notif_dias` = ?, `notif_same_day` = ?, `notif_email` = ?, `notif_weekdays` = ?, `notif_hora` = ?
                WHERE `id` = ?
                LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('sssiiiiisi', $nombre, $calendarId, $tipo, $activo, $notif_dias, $notif_same_day, $notif_email, $notif_weekdays, $notif_hora, $id);
                if ($stmt->execute()) {
                    $mensajeOk = 'Calendario actualizado.';
                } else {
                    $mensajeError = 'No se pudo actualizar el calendario: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar el guardado.';
            }
        } else {
            $stmt = $conexion->prepare("INSERT INTO `calendarios_app` (`nombre`, `calendar_id`, `tipo`, `activo`, `notif_dias`, `notif_same_day`, `notif_email`, `notif_weekdays`, `notif_hora`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('sssiiiiis', $nombre, $calendarId, $tipo, $activo, $notif_dias, $notif_same_day, $notif_email, $notif_weekdays, $notif_hora);
                if ($stmt->execute()) {
                    $mensajeOk = 'Calendario agregado.';
                } else {
                    $mensajeError = 'No se pudo agregar el calendario: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar el nuevo calendario. Verifica la tabla calendarios_app.';
            }
        }
    }

    if ($accion === 'eliminar_calendario') {
        $id = (int)post_val('id', '0');
        if ($id <= 0) {
            $mensajeError = 'No se recibi&oacute; el calendario a eliminar.';
        } else {
            // Obtener el calendar_id de Google Calendar antes de eliminar
            $stmt_info = $conexion->prepare("SELECT `calendar_id` FROM `calendarios_app` WHERE `id` = ?");
            if ($stmt_info) {
                $stmt_info->bind_param('i', $id);
                $stmt_info->execute();
                $res_info = $stmt_info->get_result();
                $calendar_id_google = '';
                if ($res_info && $row_info = $res_info->fetch_assoc()) {
                    $calendar_id_google = $row_info['calendar_id'];
                }
                $stmt_info->close();
            }

            $conexion->begin_transaction();
            try {
                // Eliminar asignaciones de este calendario
                $stmt_asignaciones = $conexion->prepare("DELETE FROM `calendario_asignaciones` WHERE `calendario_id` = ?");
                if ($stmt_asignaciones) {
                    $stmt_asignaciones->bind_param('i', $id);
                    $stmt_asignaciones->execute();
                    $stmt_asignaciones->close();
                }

                // Eliminar notificaciones de calendario de eventos
                if ($calendar_id_google !== '') {
                    $stmt_notif_eventos = $conexion->prepare("DELETE FROM `notificaciones_calendario_eventos` WHERE `calendar_id` = ?");
                    if ($stmt_notif_eventos) {
                        $stmt_notif_eventos->bind_param('s', $calendar_id_google);
                        $stmt_notif_eventos->execute();
                        $stmt_notif_eventos->close();
                    }
                }

                // Eliminar el calendario
                $stmt = $conexion->prepare("DELETE FROM `calendarios_app` WHERE `id` = ? LIMIT 1");
                if ($stmt) {
                    $stmt->bind_param('i', $id);
                    if ($stmt->execute()) {
                        $conexion->commit();
                        $mensajeOk = 'Calendario eliminado junto con sus asignaciones y notificaciones de eventos.';
                    } else {
                        $conexion->rollback();
                        $mensajeError = 'No se pudo eliminar el calendario: ' . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $conexion->rollback();
                    $mensajeError = 'No se pudo preparar la eliminaci&oacute;n.';
                }
            } catch (Exception $e) {
                $conexion->rollback();
                $mensajeError = 'Error al eliminar calendario: ' . $e->getMessage();
            }
        }
    }

    if ($accion === 'guardar_asignacion') {
        $id = (int)post_val('id', '0');
        $usuarioId = (int)post_val('usuario_id', '0');
        $grupoSeleccionado = post_val('grupo_seleccionado', '');
        $calendarioId = (int)post_val('calendario_id', '0');
        $fechaInicio = post_val('fecha_inicio');
        $fechaFin = post_val('fecha_fin');
        $activo = isset($_POST['activo']) ? 1 : 0;
        $fechaFinDb = $fechaFin !== '' ? $fechaFin : null;

        // Determinar si es asignación por grupo o individual
        $esAsignacionPorGrupo = ($grupoSeleccionado !== '' && $grupoSeleccionado !== 'individual' && $usuarioId <= 0);

        if (!$esAsignacionPorGrupo && ($usuarioId <= 0 || $calendarioId <= 0 || $fechaInicio === '')) {
            $mensajeError = 'Faltan datos obligatorios para asignar calendario.';
        } elseif ($esAsignacionPorGrupo && ($calendarioId <= 0 || $fechaInicio === '')) {
            $mensajeError = 'Faltan datos obligatorios para asignar calendario por grupo.';
        } elseif ($fechaFin !== '' && strtotime($fechaFin) < strtotime($fechaInicio)) {
            $mensajeError = 'La fecha final no puede ser anterior a la fecha de inicio.';
        } elseif ($id > 0) {
            // Edición de asignación individual (no se permite editar asignaciones por grupo)
            $stmt = $conexion->prepare("UPDATE `calendario_asignaciones`
                SET `usuario_id` = ?, `calendario_id` = ?, `fecha_inicio` = ?, `fecha_fin` = ?, `activo` = ?
                WHERE `id` = ?
                LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('iissii', $usuarioId, $calendarioId, $fechaInicio, $fechaFinDb, $activo, $id);
                if ($stmt->execute()) {
                    $mensajeOk = 'Asignaci&oacute;n actualizada.';
                } else {
                    $mensajeError = 'No se pudo actualizar la asignaci&oacute;n: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar la actualizaci&oacute;n de asignaci&oacute;n.';
            }
        } else {
            // Nueva asignación
            if ($esAsignacionPorGrupo) {
                // Asignación por grupo: obtener usuarios del grupo
                $whereGrupo = '';
                switch ($grupoSeleccionado) {
                    case 'r1':
                        $whereGrupo = "`verified` = 1 AND `nivel_residencia` = 'r1'";
                        break;
                    case 'r2':
                        $whereGrupo = "`verified` = 1 AND `nivel_residencia` = 'r2'";
                        break;
                    case 'r3':
                        $whereGrupo = "`verified` = 1 AND `nivel_residencia` = 'r3'";
                        break;
                    case 'becados':
                        $whereGrupo = "`verified` = 1 AND `becad_` = 1";
                        break;
                    case 'becados_pasantes':
                        $whereGrupo = "`verified` = 1 AND (`becad_otro` = 1 OR `intern_` = 1)";
                        break;
                    case 'docente':
                        $whereGrupo = "`verified` = 1 AND `staff_` = 1 AND `docente_` = 1";
                        break;
                    case 'staff':
                        $whereGrupo = "`verified` = 1 AND `staff_` = 1";
                        break;
                    default:
                        $whereGrupo = "`verified` = 1";
                }

                // Excluir usuarios externos
                $whereGrupo .= " AND (`external_` IS NULL OR `external_` <> 1)";

                $resUsuariosGrupo = $conexion->query("SELECT `ID` FROM `usuarios_dolor` WHERE $whereGrupo");
                if ($resUsuariosGrupo && $resUsuariosGrupo->num_rows > 0) {
                    $conexion->begin_transaction();
                    try {
                        $stmt = $conexion->prepare("INSERT INTO `calendario_asignaciones` (`calendario_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `activo`)
                            VALUES (?, ?, ?, ?, ?)");
                        if ($stmt) {
                            $stmt->bind_param('iissi', $calendarioId, $uid, $fechaInicio, $fechaFinDb, $activo);
                            $asignacionesCreadas = 0;
                            while ($row = $resUsuariosGrupo->fetch_assoc()) {
                                $uid = (int)$row['ID'];
                                if ($stmt->execute()) {
                                    $asignacionesCreadas++;
                                }
                            }
                            $stmt->close();
                            $conexion->commit();
                            $mensajeOk = "Calendario asignado a $asignacionesCreadas usuarios del grupo.";
                        } else {
                            $conexion->rollback();
                            $mensajeError = 'No se pudo preparar la asignaci&oacute;n por grupo.';
                        }
                    } catch (Exception $e) {
                        $conexion->rollback();
                        $mensajeError = 'Error al crear asignaciones por grupo: ' . $e->getMessage();
                    }
                } else {
                    $mensajeError = 'No se encontraron usuarios en el grupo seleccionado.';
                }
            } else {
                // Asignación individual
                $stmt = $conexion->prepare("INSERT INTO `calendario_asignaciones` (`calendario_id`, `usuario_id`, `fecha_inicio`, `fecha_fin`, `activo`)
                    VALUES (?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param('iissi', $calendarioId, $usuarioId, $fechaInicio, $fechaFinDb, $activo);
                    if ($stmt->execute()) {
                        $mensajeOk = 'Calendario asignado.';
                    } else {
                        $mensajeError = 'No se pudo crear la asignaci&oacute;n: ' . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $mensajeError = 'No se pudo preparar la nueva asignaci&oacute;n. Verifica la tabla calendario_asignaciones.';
                }
            }
        }
    }

    if ($accion === 'eliminar_asignacion') {
        $id = (int)post_val('id', '0');
        if ($id <= 0) {
            $mensajeError = 'No se recibi&oacute; la asignaci&oacute;n a eliminar.';
        } else {
            // Obtener calendario_id de la asignación
            $stmt_info = $conexion->prepare("SELECT ca.`calendario_id`, c.`calendar_id` 
                FROM `calendario_asignaciones` ca
                INNER JOIN `calendarios_app` c ON c.`id` = ca.`calendario_id`
                WHERE ca.`id` = ?");
            if ($stmt_info) {
                $stmt_info->bind_param('i', $id);
                $stmt_info->execute();
                $res_info = $stmt_info->get_result();
                $calendario_id_app = 0;
                $calendar_id_google = '';
                if ($res_info && $row_info = $res_info->fetch_assoc()) {
                    $calendario_id_app = (int)$row_info['calendario_id'];
                    $calendar_id_google = $row_info['calendar_id'];
                }
                $stmt_info->close();
            }

            $conexion->begin_transaction();
            try {
                // Eliminar notificaciones de eventos de esta asignación
                if ($calendar_id_google !== '') {
                    $stmt_notif_eventos = $conexion->prepare("DELETE FROM `notificaciones_calendario_eventos` WHERE `calendar_id` = ?");
                    if ($stmt_notif_eventos) {
                        $stmt_notif_eventos->bind_param('s', $calendar_id_google);
                        $stmt_notif_eventos->execute();
                        $stmt_notif_eventos->close();
                    }
                }

                // Eliminar la asignación
                $stmt = $conexion->prepare("DELETE FROM `calendario_asignaciones` WHERE `id` = ? LIMIT 1");
                if ($stmt) {
                    $stmt->bind_param('i', $id);
                    if ($stmt->execute()) {
                        $conexion->commit();
                        $mensajeOk = 'Asignaci&oacute;n eliminada junto con sus notificaciones de eventos.';
                    } else {
                        $conexion->rollback();
                        $mensajeError = 'No se pudo eliminar la asignaci&oacute;n: ' . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $conexion->rollback();
                    $mensajeError = 'No se pudo preparar la eliminaci&oacute;n.';
                }
            } catch (Exception $e) {
                $conexion->rollback();
                $mensajeError = 'Error al eliminar asignaci&oacute;n: ' . $e->getMessage();
            }
        }
    }
}

$calendarios = array();
$tablaCalendariosExiste = true;
$resCalendarios = $conexion->query("SELECT `id`, `nombre`, `calendar_id`, `tipo`, `activo`, `notif_dias`, `notif_same_day`, `notif_email`, `notif_weekdays`, `notif_hora`
    FROM `calendarios_app`
    ORDER BY FIELD(`tipo`, 'general', 'r1', 'r2', 'r3', 'staff', 'turnos', 'examenes', 'rotaciones', 'classroom', 'personal'), `nombre` ASC");

if ($resCalendarios) {
    while ($row = $resCalendarios->fetch_assoc()) {
        $calendarios[] = $row;
    }
} else {
    $tablaCalendariosExiste = false;
}

$usuarios = array();
$resUsuarios = $conexion->query("SELECT `ID`, `nombre_usuario`, `email_usuario`, `admin`, `staff_`, `docente_`, `intern_`, `becad_`, `becad_otro`, `anio_residencia`, `nivel_residencia`, `verified`, `external_`
    FROM `usuarios_dolor`
    WHERE `verified` = 1
      AND (`external_` IS NULL OR `external_` <> 1)
    ORDER BY `nivel_residencia` ASC, `becad_` DESC, `anio_residencia` ASC, `nombre_usuario` ASC");
if ($resUsuarios) {
    while ($row = $resUsuarios->fetch_assoc()) {
        $row['grupo_usuario'] = usuario_grupo_key($row);
        $row['grupo_usuario_label'] = usuario_grupo_label($row['grupo_usuario']);
        $usuarios[] = $row;
    }
}

$asignaciones = array();
$tablaAsignacionesExiste = true;
$resAsignaciones = $conexion->query("SELECT ca.`id`, ca.`calendario_id`, ca.`usuario_id`, ca.`fecha_inicio`, ca.`fecha_fin`, ca.`activo`,
           c.`nombre` AS calendario_nombre, c.`tipo` AS calendario_tipo,
           u.`nombre_usuario`, u.`email_usuario`, u.`anio_residencia`, u.`admin`, u.`staff_`, u.`intern_`, u.`becad_`, u.`becad_otro`
    FROM `calendario_asignaciones` ca
    INNER JOIN `calendarios_app` c ON c.`id` = ca.`calendario_id`
    INNER JOIN `usuarios_dolor` u ON u.`ID` = ca.`usuario_id`
    ORDER BY ca.`fecha_inicio` DESC, u.`nombre_usuario` ASC, c.`nombre` ASC");
if ($resAsignaciones) {
    while ($row = $resAsignaciones->fetch_assoc()) {
        $row['grupo_usuario'] = usuario_grupo_key($row);
        $row['grupo_usuario_label'] = usuario_grupo_label($row['grupo_usuario']);
        $asignaciones[] = $row;
    }
} else {
    $tablaAsignacionesExiste = false;
}

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Calendarios</span>";
$boton_navbar = "<a></a><a></a>";

require('head.php');
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<main class="admin-page">
    <section class="app-hero app-hero-admin admin-header-card mb-3">
        <div class="app-hero-kicker">Administración</div>
        <h2>Calendarios docentes</h2>
        <p>Administra calendarios Google, Classroom y asignaciones temporales por becado.</p>
        <span class="app-hero-pill">Solo administradores</span>
    </section>

    <?php if ($mensajeOk !== '') { ?>
        <div class="alert alert-success"><?= $mensajeOk ?></div>
    <?php } ?>
    <?php if ($mensajeError !== '') { ?>
        <div class="alert alert-danger"><?= $mensajeError ?></div>
    <?php } ?>

    <?php if (!$tablaCalendariosExiste) { ?>
        <div class="alert alert-warning">
            Falta crear la tabla <code>calendarios_app</code>.
        </div>
    <?php } ?>
    <?php if (!$tablaAsignacionesExiste) { ?>
        <div class="alert alert-warning">
            Falta crear la tabla <code>calendario_asignaciones</code>.
        </div>
    <?php } ?>

    <!-- Tabs de navegación con Bootstrap -->
    <ul class="nav nav-tabs mb-3" id="adminCalendariosTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="calendarios-tab" data-bs-toggle="tab" data-bs-target="#tab-calendarios" type="button" role="tab" aria-controls="tab-calendarios" aria-selected="true">
                <i class="fa-regular fa-calendar-plus me-1"></i>Calendarios fuente
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="asignaciones-tab" data-bs-toggle="tab" data-bs-target="#tab-asignaciones" type="button" role="tab" aria-controls="tab-asignaciones" aria-selected="false">
                <i class="fa-solid fa-user-clock me-1"></i>Asignaciones temporales
            </button>
        </li>
    </ul>

    <!-- Contenido de tabs -->
    <div class="tab-content" id="adminCalendariosTabsContent">
        <?php include __DIR__ . '/admin_calendarios_tabs_content.php'; ?>
    </div>
</main>
</div>

<?php require('footer.php'); ?>
