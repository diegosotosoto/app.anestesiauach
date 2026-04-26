<?php
if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim($_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    header('Location: login.php');
    exit;
}

require('conectar.php');
if (file_exists(__DIR__ . '/app_text_helpers.php')) {
    require_once __DIR__ . '/app_text_helpers.php';
}

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
    $interno = isset($usr['intern_']) ? (int)$usr['intern_'] : 0;
    $becad = isset($usr['becad_']) ? (int)$usr['becad_'] : 0;
    $becadOtro = isset($usr['becad_otro']) ? (int)$usr['becad_otro'] : 0;
    $anio = isset($usr['anio_residencia']) ? (int)$usr['anio_residencia'] : 0;

    if ($becad === 1 || $anio > 0) {
        return 'becados';
    }
    if ($becadOtro === 1 || $interno === 1) {
        return 'becados_pasantes';
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
        'becados' => 'Becados',
        'becados_pasantes' => 'Becados Pasantes',
        'staff' => 'Staff',
        'individual' => 'Individual'
    );
    return $labels[$grupo] ?? 'Individual';
}

function tipo_label($tipo)
{
    $labels = array(
        'general' => 'General',
        'r1' => 'R1',
        'r2' => 'R2',
        'r3' => 'R3',
        'staff' => 'Staff',
        'turnos' => 'Turnos',
        'examenes' => 'Ex&aacute;menes',
        'rotaciones' => 'Rotaciones',
        'classroom' => 'Classroom',
        'personal' => 'Personal'
    );
    return $labels[$tipo] ?? strtoupper((string)$tipo);
}

$emailUsuario = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);
$usuarioAdmin = null;

$stmtAdmin = $conexion->prepare("SELECT `ID`, `admin`, `nombre_usuario`, `email_usuario`
    FROM `usuarios_dolor`
    WHERE `email_usuario` = ?
    LIMIT 1");

if ($stmtAdmin) {
    $stmtAdmin->bind_param('s', $emailUsuario);
    $stmtAdmin->execute();
    $resAdmin = $stmtAdmin->get_result();
    $usuarioAdmin = $resAdmin ? $resAdmin->fetch_assoc() : null;
    $stmtAdmin->close();
}

if (!$usuarioAdmin || (int)$usuarioAdmin['admin'] !== 1) {
    header('Location: login.php');
    exit;
}

$mensajeOk = '';
$mensajeError = '';
$tiposValidos = array('general', 'r1', 'r2', 'r3', 'staff', 'turnos', 'examenes', 'rotaciones', 'classroom', 'personal');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = post_val('accion');

    if ($accion === 'guardar_calendario') {
        $id = (int)post_val('id', '0');
        $nombre = post_val('nombre');
        $calendarId = post_val('calendar_id');
        $tipo = strtolower(post_val('tipo'));
        $activo = isset($_POST['activo']) ? 1 : 0;

        if ($nombre === '' || $calendarId === '' || !in_array($tipo, $tiposValidos, true)) {
            $mensajeError = 'Faltan datos obligatorios o el tipo no es v&aacute;lido.';
        } elseif ($id > 0) {
            $stmt = $conexion->prepare("UPDATE `calendarios_app`
                SET `nombre` = ?, `calendar_id` = ?, `tipo` = ?, `activo` = ?
                WHERE `id` = ?
                LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('sssii', $nombre, $calendarId, $tipo, $activo, $id);
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
            $stmt = $conexion->prepare("INSERT INTO `calendarios_app` (`nombre`, `calendar_id`, `tipo`, `activo`)
                VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('sssi', $nombre, $calendarId, $tipo, $activo);
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
            $stmt = $conexion->prepare("DELETE FROM `calendarios_app` WHERE `id` = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('i', $id);
                if ($stmt->execute()) {
                    $mensajeOk = 'Calendario eliminado.';
                } else {
                    $mensajeError = 'No se pudo eliminar el calendario: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar la eliminaci&oacute;n.';
            }
        }
    }

    if ($accion === 'guardar_asignacion') {
        $id = (int)post_val('id', '0');
        $usuarioId = (int)post_val('usuario_id', '0');
        $calendarioId = (int)post_val('calendario_id', '0');
        $fechaInicio = post_val('fecha_inicio');
        $fechaFin = post_val('fecha_fin');
        $activo = isset($_POST['activo']) ? 1 : 0;
        $fechaFinDb = $fechaFin !== '' ? $fechaFin : null;

        if ($usuarioId <= 0 || $calendarioId <= 0 || $fechaInicio === '') {
            $mensajeError = 'Faltan datos obligatorios para asignar calendario.';
        } elseif ($fechaFin !== '' && strtotime($fechaFin) < strtotime($fechaInicio)) {
            $mensajeError = 'La fecha final no puede ser anterior a la fecha de inicio.';
        } elseif ($id > 0) {
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

    if ($accion === 'eliminar_asignacion') {
        $id = (int)post_val('id', '0');
        if ($id <= 0) {
            $mensajeError = 'No se recibi&oacute; la asignaci&oacute;n a eliminar.';
        } else {
            $stmt = $conexion->prepare("DELETE FROM `calendario_asignaciones` WHERE `id` = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('i', $id);
                if ($stmt->execute()) {
                    $mensajeOk = 'Asignaci&oacute;n eliminada.';
                } else {
                    $mensajeError = 'No se pudo eliminar la asignaci&oacute;n: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar la eliminaci&oacute;n de asignaci&oacute;n.';
            }
        }
    }
}

$calendarios = array();
$tablaCalendariosExiste = true;
$resCalendarios = $conexion->query("SELECT `id`, `nombre`, `calendar_id`, `tipo`, `activo`
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
$resUsuarios = $conexion->query("SELECT `ID`, `nombre_usuario`, `email_usuario`, `admin`, `staff_`, `intern_`, `becad_`, `becad_otro`, `anio_residencia`, `verified`
    FROM `usuarios_dolor`
    WHERE `verified` = 1
    ORDER BY `becad_` DESC, `anio_residencia` ASC, `nombre_usuario` ASC");
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

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark admin-back-btn' style='--bs-border-opacity:.1;' href='index.php'><i class='fa fa-chevron-left me-1'></i>Atr&aacute;s</a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Calendarios</span>";
$boton_navbar = "<a></a><a></a>";

require('head.php');
?>

<style>
.admin-page{width:100%;max-width:1180px;margin:0 auto;padding:0 .75rem 2rem;}
.admin-header-card,.admin-filter-card,.admin-item-card{background:#fff;border:1px solid #dbe3f0;border-radius:1.35rem;box-shadow:0 .35rem 1rem rgba(31,41,55,.05);}
.admin-header-title{color:#1f2937;font-weight:850;margin:0;}
.admin-header-subtitle,.admin-item-meta,.admin-help-text{color:#6b7280;}
.admin-section-title{color:#1f2937;font-weight:850;margin:0 0 .7rem;display:flex;align-items:center;gap:.45rem;}
.admin-form-label{color:#374151;font-size:.85rem;font-weight:800;margin-bottom:.25rem;}
.admin-input,.admin-select{border-color:#dbe3f0;border-radius:.85rem;}
.btn-admin-primary{background:#2f55b7;border-color:#2f55b7;color:#fff;border-radius:.85rem;font-weight:800;}
.btn-admin-primary:hover{background:#244aa5;border-color:#244aa5;color:#fff;}
.btn-admin-danger{background:#dc3545;border-color:#dc3545;color:#fff;border-radius:.85rem;font-weight:800;}
.btn-admin-outline{border:1px solid #dbe3f0;color:#2f55b7;background:#fff;border-radius:.85rem;font-weight:800;}
.admin-badge{display:inline-flex;align-items:center;border-radius:999px;padding:.25rem .6rem;font-size:.78rem;font-weight:850;}
.admin-badge-primary{background:#eef3fb;color:#2f55b7;}
.admin-badge-muted{background:#f3f4f6;color:#6b7280;}
.admin-badge-success{background:#e8f6ef;color:#198754;}
.admin-badge-warning{background:#fff8e6;color:#946200;}
.admin-badge-purple{background:#f1e8ff;color:#6f1ed6;}
.admin-empty-state{color:#6b7280;text-align:center;padding:2rem 1rem;}
.admin-item-header{display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;margin-bottom:.8rem;}
.admin-item-title{color:#1f2937;font-weight:850;}
.admin-tabs{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem;}
.admin-tab{border:1px solid #dbe3f0;background:#fff;color:#2f55b7;border-radius:999px;padding:.5rem .85rem;font-weight:850;text-decoration:none;}
.admin-tab:hover{color:#244aa5;background:#eef3fb;}
.admin-inline-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:.6rem;}
.admin-source-grid,.admin-assignment-grid{display:grid;gap:.6rem;align-items:end;grid-template-columns:minmax(160px,1.2fr) minmax(260px,2fr) minmax(150px,.9fr) 76px minmax(92px,auto);}
.admin-assignment-grid{grid-template-columns:minmax(190px,1.4fr) minmax(180px,1.25fr) minmax(130px,.75fr) minmax(130px,.75fr) 76px minmax(92px,auto);}
.admin-active-cell{min-width:70px;}
.btn-admin-primary{white-space:nowrap;min-height:38px;padding-left:1rem;padding-right:1rem;}
.admin-item-meta{word-break:break-word;overflow-wrap:anywhere;}
.admin-user-picker{border:1px solid #dbe3f0;border-radius:1rem;background:#f8fbff;padding:.75rem;margin-bottom:.75rem;}
.admin-user-picker-grid{display:grid;grid-template-columns:minmax(180px,.75fr) minmax(220px,1fr);gap:.65rem;align-items:end;}
.admin-user-list{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:.5rem;max-height:260px;overflow:auto;padding:.25rem;margin-top:.65rem;}
.admin-user-option{border:1px solid #dbe3f0;background:#fff;border-radius:.9rem;padding:.65rem .75rem;text-align:left;color:#1f2937;transition:.15s ease;}
.admin-user-option:hover{border-color:#8bb8ff;background:#eef6ff;}
.admin-user-option.is-selected{border-color:#2f55b7;background:#eef3fb;box-shadow:0 0 0 .18rem rgba(47,85,183,.16);}
.admin-user-name{font-weight:850;line-height:1.15;}
.admin-user-email{font-size:.82rem;color:#6b7280;overflow-wrap:anywhere;}
.admin-user-group-badge{display:inline-flex;margin-top:.35rem;border-radius:999px;padding:.15rem .5rem;font-size:.72rem;font-weight:850;background:#eef3fb;color:#2f55b7;}
.admin-selected-user{margin-top:.55rem;color:#198754;font-weight:800;}
.admin-assignment-filters{display:grid;grid-template-columns:minmax(180px,.5fr) minmax(260px,1fr);gap:.65rem;align-items:end;}
.admin-filter-summary{color:#6b7280;font-size:.9rem;margin-top:.5rem;}
@media (max-width: 1199.98px){
  .admin-source-grid{grid-template-columns:1fr 1fr;}
  .admin-assignment-grid{grid-template-columns:1fr 1fr;}
  .admin-source-grid .admin-action-cell,.admin-assignment-grid .admin-action-cell{grid-column:1 / -1;}
}
@media (max-width: 575.98px){.admin-item-header{flex-direction:column;}.admin-page{padding-inline:.5rem;}.admin-source-grid,.admin-assignment-grid,.admin-user-picker-grid,.admin-assignment-filters{grid-template-columns:1fr;}.admin-active-cell{min-width:0;}.btn-admin-primary{width:100%;}}
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<main class="admin-page">
    <div class="card admin-header-card mb-3">
        <div class="card-body">
            <h4 class="admin-header-title">Calendarios docentes</h4>
            <div class="admin-header-subtitle">Administra calendarios Google, Classroom y asignaciones temporales por residente.</div>
        </div>
    </div>

    <div class="admin-tabs">
        <a class="admin-tab" href="#calendarios"><i class="fa-regular fa-calendar me-1"></i>Calendarios fuente</a>
        <a class="admin-tab" href="#asignaciones"><i class="fa-solid fa-user-clock me-1"></i>Asignaciones temporales</a>
    </div>

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

    <section id="calendarios" class="card admin-filter-card mb-3">
        <div class="card-body">
            <h5 class="admin-section-title"><i class="fa-regular fa-calendar-plus"></i>Agregar calendario fuente</h5>
            <form method="post">
                <input type="hidden" name="accion" value="guardar_calendario">
                <div class="admin-source-grid">
                    <div>
                        <label class="admin-form-label">Nombre</label>
                        <input class="form-control admin-input" name="nombre" placeholder="Classroom Pediatr&iacute;a, R1, Turnos..." required>
                    </div>
                    <div>
                        <label class="admin-form-label">Calendar ID</label>
                        <input class="form-control admin-input" name="calendar_id" placeholder="xxxx@group.calendar.google.com" required>
                    </div>
                    <div>
                        <label class="admin-form-label">Tipo</label>
                        <select class="form-select admin-select" name="tipo" required>
                            <?php foreach ($tiposValidos as $tipo) { ?>
                                <option value="<?= h($tipo) ?>"><?= tipo_label($tipo) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="admin-active-cell">
                        <label class="admin-form-label">Activo</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="activo" checked>
                        </div>
                    </div>
                    <div class="admin-action-cell d-grid">
                        <button class="btn btn-admin-primary">Agregar</button>
                    </div>
                </div>
            </form>
            <div class="admin-help-text small mt-2">
                <strong>Importante:</strong> comparte cada calendario en Google con el email de la cuenta de servicio y permiso &quot;Ver todos los detalles&quot;.
            </div>
        </div>
    </section>

    <?php if (count($calendarios) === 0) { ?>
        <div class="card admin-item-card mb-3">
            <div class="admin-empty-state">
                <div class="mb-2"><i class="fa-regular fa-calendar"></i></div>
                <strong>No hay calendarios registrados.</strong>
                <div class="small mt-1">Agrega el calendario general y luego los de nivel, Classroom o rotaciones.</div>
            </div>
        </div>
    <?php } ?>

    <?php foreach ($calendarios as $cal) { ?>
        <div class="card admin-item-card mb-3">
            <div class="card-body">
                <div class="admin-item-header">
                    <div>
                        <div class="admin-item-title"><?= h($cal['nombre']) ?></div>
                        <div class="admin-item-meta"><?= h($cal['calendar_id']) ?></div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap justify-content-end">
                        <span class="admin-badge admin-badge-primary"><?= tipo_label($cal['tipo']) ?></span>
                        <span class="admin-badge <?= (int)$cal['activo'] === 1 ? 'admin-badge-success' : 'admin-badge-muted' ?>">
                            <?= (int)$cal['activo'] === 1 ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </div>
                </div>

                <form method="post">
                    <input type="hidden" name="accion" value="guardar_calendario">
                    <input type="hidden" name="id" value="<?= (int)$cal['id'] ?>">
                    <div class="admin-source-grid">
                        <div>
                            <label class="admin-form-label">Nombre</label>
                            <input class="form-control admin-input" name="nombre" value="<?= h($cal['nombre']) ?>" required>
                        </div>
                        <div>
                            <label class="admin-form-label">Calendar ID</label>
                            <input class="form-control admin-input" name="calendar_id" value="<?= h($cal['calendar_id']) ?>" required>
                        </div>
                        <div>
                            <label class="admin-form-label">Tipo</label>
                            <select class="form-select admin-select" name="tipo" required>
                                <?php foreach ($tiposValidos as $tipo) { ?>
                                    <option value="<?= h($tipo) ?>" <?= $cal['tipo'] === $tipo ? 'selected' : '' ?>><?= tipo_label($tipo) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label">Activo</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="activo" <?= (int)$cal['activo'] === 1 ? 'checked' : '' ?>>
                            </div>
                        </div>
                        <div class="admin-action-cell d-grid">
                            <button class="btn btn-admin-primary">Guardar</button>
                        </div>
                    </div>
                </form>

                <form method="post" class="mt-2 text-end">
                    <input type="hidden" name="accion" value="eliminar_calendario">
                    <input type="hidden" name="id" value="<?= (int)$cal['id'] ?>">
                    <button class="btn btn-sm btn-admin-danger" data-confirm="&iquest;Confirmas eliminar este calendario de la app? Tambi&eacute;n se eliminar&aacute;n sus asignaciones. No borra el calendario en Google.">Eliminar</button>
                </form>
            </div>
        </div>
    <?php } ?>

    <section id="asignaciones" class="card admin-filter-card mb-3 mt-4">
        <div class="card-body">
            <h5 class="admin-section-title"><i class="fa-solid fa-user-clock"></i>Asignar calendario temporal</h5>
            <form method="post">
                <input type="hidden" name="accion" value="guardar_asignacion">
                <div class="admin-assignment-grid">
                    <div class="admin-user-picker" style="grid-column:1 / -1;">
                        <input type="hidden" name="usuario_id" id="asignar_usuario_id" required>
                        <div class="admin-user-picker-grid">
                            <div>
                                <label class="admin-form-label">Grupo</label>
                                <select class="form-select admin-select" id="asignar_grupo_usuario">
                                    <option value="becados">Becados</option>
                                    <option value="becados_pasantes">Becados Pasantes</option>
                                    <option value="staff">Staff</option>
                                    <option value="individual">Individual</option>
                                    <option value="todos">Todos</option>
                                </select>
                            </div>
                            <div>
                                <label class="admin-form-label">Buscar por nombre o correo</label>
                                <input class="form-control admin-input" type="search" id="asignar_buscar_usuario" placeholder="Escribe para filtrar usuarios...">
                            </div>
                        </div>
                        <div class="admin-user-list" id="asignar_lista_usuarios">
                            <?php foreach ($usuarios as $usr) {
                                $usrTexto = html_entity_decode((string)$usr['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8') . ' ' . (string)$usr['email_usuario'];
                            ?>
                                <button type="button"
                                        class="admin-user-option"
                                        data-user-id="<?= (int)$usr['ID'] ?>"
                                        data-user-group="<?= h($usr['grupo_usuario']) ?>"
                                        data-user-text="<?= h(app_lower_text($usrTexto, 'UTF-8')) ?>"
                                        data-user-label="<?= h_nombre($usr['nombre_usuario']) ?> · <?= h($usr['email_usuario']) ?>">
                                    <div class="admin-user-name"><?= h_nombre($usr['nombre_usuario']) ?></div>
                                    <div class="admin-user-email"><?= h($usr['email_usuario']) ?><?= (int)$usr['becad_'] === 1 && $usr['anio_residencia'] ? ' · R' . (int)$usr['anio_residencia'] : '' ?></div>
                                    <span class="admin-user-group-badge"><?= h(usuario_grupo_label($usr['grupo_usuario'])) ?></span>
                                </button>
                            <?php } ?>
                        </div>
                        <div class="admin-selected-user" id="asignar_usuario_seleccionado">Selecciona un usuario de la lista.</div>
                    </div>
                    <div>
                        <label class="admin-form-label">Calendario</label>
                        <select class="form-select admin-select" name="calendario_id" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($calendarios as $cal) { ?>
                                <option value="<?= (int)$cal['id'] ?>"><?= h($cal['nombre']) ?> · <?= tipo_label($cal['tipo']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <label class="admin-form-label">Inicio</label>
                        <input class="form-control admin-input" type="date" name="fecha_inicio" required>
                    </div>
                    <div>
                        <label class="admin-form-label">Fin</label>
                        <input class="form-control admin-input" type="date" name="fecha_fin">
                    </div>
                    <div class="admin-active-cell">
                        <label class="admin-form-label">Activo</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="activo" checked>
                        </div>
                    </div>
                    <div class="admin-action-cell d-grid">
                        <button class="btn btn-admin-primary">Asignar</button>
                    </div>
                </div>
            </form>
            <div class="admin-help-text small mt-2">
                Para Classroom por rotaci&oacute;n, registra primero el calendario como tipo <strong>Classroom</strong> o <strong>Rotaciones</strong>, luego as&iacute;gnalo al residente con fechas.
            </div>
        </div>
    </section>

    <section class="card admin-filter-card mb-3">
        <div class="card-body">
            <h5 class="admin-section-title"><i class="fa-solid fa-filter"></i>Filtrar asignaciones</h5>
            <div class="admin-assignment-filters">
                <div>
                    <label class="admin-form-label">Grupo</label>
                    <select class="form-select admin-select" id="filtro_asignaciones_grupo">
                        <option value="todos">Todos</option>
                        <option value="becados">Becados</option>
                        <option value="becados_pasantes">Becados Pasantes</option>
                        <option value="staff">Staff</option>
                        <option value="individual">Individual</option>
                    </select>
                </div>
                <div>
                    <label class="admin-form-label">Individuo / texto</label>
                    <input class="form-control admin-input" type="search" id="filtro_asignaciones_texto" placeholder="Filtrar por nombre, correo o calendario...">
                </div>
            </div>
            <div class="admin-filter-summary" id="resumen_filtro_asignaciones"></div>
        </div>
    </section>
    <?php if (count($asignaciones) === 0) { ?>
        <div class="card admin-item-card mb-3">
            <div class="admin-empty-state">
                <div class="mb-2"><i class="fa-solid fa-user-clock"></i></div>
                <strong>No hay asignaciones temporales.</strong>
                <div class="small mt-1">Los calendarios tipo general/R1/R2/R3 se muestran por perfil. Classroom, rotaciones y personales deben asignarse aqu&iacute;.</div>
            </div>
        </div>
    <?php } ?>

    <?php foreach ($asignaciones as $asig) { ?>
        <div class="card admin-item-card admin-assignment-card mb-3" data-user-group="<?= h($asig['grupo_usuario']) ?>" data-user-text="<?= h(app_lower_text(html_entity_decode((string)$asig['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8') . ' ' . (string)$asig['email_usuario'] . ' ' . (string)$asig['calendario_nombre'], 'UTF-8')) ?>">
            <div class="card-body">
                <div class="admin-item-header">
                    <div>
                        <div class="admin-item-title"><?= h_nombre($asig['nombre_usuario']) ?></div>
                        <div class="admin-item-meta">
                            <?= h($asig['email_usuario']) ?> &middot; <?= h($asig['calendario_nombre']) ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap justify-content-end">
                        <span class="admin-badge admin-badge-primary"><?= h($asig['grupo_usuario_label']) ?></span>
                        <span class="admin-badge admin-badge-purple"><?= tipo_label($asig['calendario_tipo']) ?></span>
                        <span class="admin-badge admin-badge-warning"><?= h($asig['fecha_inicio']) ?> a <?= h($asig['fecha_fin'] ?: 'sin fin') ?></span>
                        <span class="admin-badge <?= (int)$asig['activo'] === 1 ? 'admin-badge-success' : 'admin-badge-muted' ?>">
                            <?= (int)$asig['activo'] === 1 ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </div>
                </div>

                <form method="post">
                    <input type="hidden" name="accion" value="guardar_asignacion">
                    <input type="hidden" name="id" value="<?= (int)$asig['id'] ?>">
                    <div class="admin-assignment-grid">
                        <div>
                            <label class="admin-form-label">Usuario</label>
                            <select class="form-select admin-select" name="usuario_id" required>
                                <?php foreach ($usuarios as $usr) { ?>
                                    <option value="<?= (int)$usr['ID'] ?>" <?= (int)$asig['usuario_id'] === (int)$usr['ID'] ? 'selected' : '' ?>>
                                        <?= h_nombre($usr['nombre_usuario']) ?> · <?= h($usr['email_usuario']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label class="admin-form-label">Calendario</label>
                            <select class="form-select admin-select" name="calendario_id" required>
                                <?php foreach ($calendarios as $cal) { ?>
                                    <option value="<?= (int)$cal['id'] ?>" <?= (int)$asig['calendario_id'] === (int)$cal['id'] ? 'selected' : '' ?>><?= h($cal['nombre']) ?> · <?= tipo_label($cal['tipo']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label class="admin-form-label">Inicio</label>
                            <input class="form-control admin-input" type="date" name="fecha_inicio" value="<?= h($asig['fecha_inicio']) ?>" required>
                        </div>
                        <div>
                            <label class="admin-form-label">Fin</label>
                            <input class="form-control admin-input" type="date" name="fecha_fin" value="<?= h($asig['fecha_fin']) ?>">
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label">Activo</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="activo" <?= (int)$asig['activo'] === 1 ? 'checked' : '' ?>>
                            </div>
                        </div>
                        <div class="admin-action-cell d-grid">
                            <button class="btn btn-admin-primary">Guardar</button>
                        </div>
                    </div>
                </form>

                <form method="post" class="mt-2 text-end">
                    <input type="hidden" name="accion" value="eliminar_asignacion">
                    <input type="hidden" name="id" value="<?= (int)$asig['id'] ?>">
                    <button class="btn btn-sm btn-admin-danger" data-confirm="&iquest;Confirmas eliminar esta asignaci&oacute;n temporal?">Eliminar</button>
                </form>
            </div>
        </div>
    <?php } ?>
</main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-confirm]').forEach(function (btn) {
        btn.addEventListener('click', function (event) {
            const msg = btn.getAttribute('data-confirm');
            if (msg && !confirm(msg)) {
                event.preventDefault();
            }
        });
    });

    function normalizarTexto(txt) {
        return (txt || '').toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    const grupoSelect = document.getElementById('asignar_grupo_usuario');
    const buscarInput = document.getElementById('asignar_buscar_usuario');
    const usuarioHidden = document.getElementById('asignar_usuario_id');
    const seleccionado = document.getElementById('asignar_usuario_seleccionado');
    const userButtons = Array.from(document.querySelectorAll('#asignar_lista_usuarios .admin-user-option'));

    function filtrarUsuariosAsignacion() {
        if (!grupoSelect || !buscarInput) return;
        const grupo = grupoSelect.value;
        const q = normalizarTexto(buscarInput.value);
        let visibles = 0;

        userButtons.forEach(function (btn) {
            const group = btn.getAttribute('data-user-group') || 'individual';
            const text = normalizarTexto(btn.getAttribute('data-user-text') || '');
            const matchGrupo = grupo === 'todos' || group === grupo || grupo === 'individual';
            const matchTexto = q === '' || text.includes(q);
            const mostrar = matchGrupo && matchTexto;
            btn.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });

        if (grupo === 'individual') {
            buscarInput.placeholder = 'Escribe nombre o correo del usuario individual...';
            buscarInput.focus({preventScroll:true});
        } else {
            buscarInput.placeholder = 'Escribe para filtrar usuarios...';
        }

        if (seleccionado && usuarioHidden && usuarioHidden.value === '') {
            seleccionado.textContent = visibles > 0 ? 'Selecciona un usuario de la lista.' : 'No hay usuarios para este filtro.';
        }
    }

    userButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            userButtons.forEach(function (b) { b.classList.remove('is-selected'); });
            btn.classList.add('is-selected');
            if (usuarioHidden) usuarioHidden.value = btn.getAttribute('data-user-id') || '';
            if (seleccionado) seleccionado.textContent = 'Seleccionado: ' + (btn.getAttribute('data-user-label') || 'usuario');
        });
    });

    if (grupoSelect) grupoSelect.addEventListener('change', function () {
        if (usuarioHidden) usuarioHidden.value = '';
        userButtons.forEach(function (b) { b.classList.remove('is-selected'); });
        filtrarUsuariosAsignacion();
    });
    if (buscarInput) buscarInput.addEventListener('input', filtrarUsuariosAsignacion);
    filtrarUsuariosAsignacion();

    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const accion = form.querySelector('input[name="accion"]');
            if (accion && accion.value === 'guardar_asignacion' && form.querySelector('#asignar_usuario_id') && usuarioHidden && !usuarioHidden.value) {
                event.preventDefault();
                alert('Selecciona un usuario antes de asignar el calendario.');
            }
        });
    });

    const filtroGrupo = document.getElementById('filtro_asignaciones_grupo');
    const filtroTexto = document.getElementById('filtro_asignaciones_texto');
    const resumenFiltro = document.getElementById('resumen_filtro_asignaciones');
    const assignmentCards = Array.from(document.querySelectorAll('.admin-assignment-card'));

    function filtrarAsignaciones() {
        const grupo = filtroGrupo ? filtroGrupo.value : 'todos';
        const q = filtroTexto ? normalizarTexto(filtroTexto.value) : '';
        let visibles = 0;

        assignmentCards.forEach(function (card) {
            const group = card.getAttribute('data-user-group') || 'individual';
            const text = normalizarTexto(card.getAttribute('data-user-text') || '');
            const matchGrupo = grupo === 'todos' || group === grupo;
            const matchTexto = q === '' || text.includes(q);
            const mostrar = matchGrupo && matchTexto;
            card.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });

        if (resumenFiltro) {
            resumenFiltro.textContent = visibles + ' asignación(es) visible(s) de ' + assignmentCards.length + '.';
        }
    }

    if (filtroGrupo) filtroGrupo.addEventListener('change', filtrarAsignaciones);
    if (filtroTexto) filtroTexto.addEventListener('input', filtrarAsignaciones);
    filtrarAsignaciones();
});
</script>


<?php require('footer.php'); ?>
