<?php
if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim($_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    header('Location: login.php');
    exit;
}

require('conectar.php');
if (file_exists(__DIR__ . '/app_text_helpers.php')) {
    require_once __DIR__ . '/app_text_helpers.php';
}
require_once __DIR__ . '/google-calendar/config.php';

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

function calendar_column_exists($conexion, $table, $column)
{
    $table = $conexion->real_escape_string($table);
    $column = $conexion->real_escape_string($column);
    $res = $conexion->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $res && $res->num_rows > 0;
}

function calendar_event_start_value($event)
{
    if (isset($event['start']['dateTime'])) {
        return $event['start']['dateTime'];
    }
    return $event['start']['date'] ?? '';
}

function calendar_event_end_value($event)
{
    if (isset($event['end']['dateTime'])) {
        return $event['end']['dateTime'];
    }
    return $event['end']['date'] ?? '';
}

function calendar_event_ts($event)
{
    $value = calendar_event_start_value($event);
    return $value !== '' ? strtotime($value) : PHP_INT_MAX;
}

function calendar_format_date($event)
{
    $value = calendar_event_start_value($event);
    if ($value === '') {
        return 'Fecha por definir';
    }

    $ts = strtotime($value);
    if (!$ts) {
        return $value;
    }

    $isAllDay = isset($event['start']['date']) && !isset($event['start']['dateTime']);
    $dias = array('Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb');
    $meses = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
    $label = $dias[(int)date('w', $ts)] . ' ' . date('j', $ts) . ' ' . $meses[(int)date('n', $ts) - 1];

    return $isAllDay ? $label . ' · todo el día' : $label . ' · ' . date('H:i', $ts);
}

function calendar_tipo_label($tipo)
{
    $labels = array(
        'general' => 'General',
        'r1' => 'R1',
        'r2' => 'R2',
        'r3' => 'R3',
        'staff' => 'Staff',
        'turnos' => 'Turnos',
        'examenes' => 'Exámenes',
        'rotaciones' => 'Rotaciones',
        'classroom' => 'Classroom',
        'personal' => 'Personal'
    );
    return $labels[$tipo] ?? strtoupper((string)$tipo);
}

function calendar_default_color($tipo)
{
    $colors = array(
        'general' => '#315bc5',
        'r1' => '#16a34a',
        'r2' => '#f59e0b',
        'r3' => '#dc2626',
        'staff' => '#0f766e',
        'turnos' => '#ef4444',
        'examenes' => '#7c3aed',
        'rotaciones' => '#8b5cf6',
        'classroom' => '#2563eb',
        'personal' => '#0891b2'
    );
    return $colors[$tipo] ?? '#315bc5';
}

$emailUsuario = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);
$usuario = null;

$stmtUser = $conexion->prepare("SELECT `ID`, `nombre_usuario`, `email_usuario`, `verified`, `admin`, `becad_`, `anio_residencia`
    FROM `usuarios_dolor`
    WHERE `email_usuario` = ?
    LIMIT 1");

if ($stmtUser) {
    $stmtUser->bind_param('s', $emailUsuario);
    $stmtUser->execute();
    $resUser = $stmtUser->get_result();
    $usuario = $resUser ? $resUser->fetch_assoc() : null;
    $stmtUser->close();
}

if (!$usuario || (int)$usuario['verified'] !== 1) {
    header('Location: login.php');
    exit;
}

$usuarioId = (int)$usuario['ID'];
$esBecado = (int)$usuario['becad_'] === 1;
$esAdmin = (int)$usuario['admin'] === 1;
$anioResidencia = isset($usuario['anio_residencia']) ? (string)$usuario['anio_residencia'] : '';

$errores = array();
$eventos = array();
$calendarios = array();
$calendarioIdsYaAgregados = array();
$tablaCalendariosExiste = true;
$tablaAsignacionesExiste = true;
$tieneColor = calendar_column_exists($conexion, 'calendarios_app', 'color');
$selectColor = $tieneColor ? "`color`" : "NULL AS `color`";

$tiposBase = array('general');
if ($esBecado && in_array($anioResidencia, array('1', '2', '3'), true)) {
    $tiposBase[] = 'r' . (int)$anioResidencia;
}
if (!$esBecado && $esAdmin) {
    $tiposBase[] = 'staff';
}

$placeholders = implode(',', array_fill(0, count($tiposBase), '?'));
$sqlBase = "SELECT `id`, `nombre`, `calendar_id`, `tipo`, $selectColor
    FROM `calendarios_app`
    WHERE `activo` = 1
      AND `tipo` IN ($placeholders)
    ORDER BY FIELD(`tipo`, 'general', 'r1', 'r2', 'r3', 'staff'), `nombre` ASC";

$stmtBase = $conexion->prepare($sqlBase);
if (!$stmtBase) {
    $tablaCalendariosExiste = false;
    $errores[] = 'No se pudo consultar calendarios_app. Verifica que la tabla exista.';
} else {
    $types = str_repeat('s', count($tiposBase));
    $stmtBase->bind_param($types, ...$tiposBase);
    $stmtBase->execute();
    $resBase = $stmtBase->get_result();
    if ($resBase) {
        while ($row = $resBase->fetch_assoc()) {
            $id = (int)$row['id'];
            $row['origen'] = 'base';
            $row['color'] = $row['color'] ?: calendar_default_color($row['tipo']);
            $calendarios[] = $row;
            $calendarioIdsYaAgregados[$id] = true;
        }
    }
    $stmtBase->close();
}

$hoy = date('Y-m-d');
$sqlAsignados = "SELECT c.`id`, c.`nombre`, c.`calendar_id`, c.`tipo`, $selectColor,
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
if (!$stmtAsignados) {
    $tablaAsignacionesExiste = false;
    $errores[] = 'No se pudo consultar calendario_asignaciones. Verifica que la tabla exista.';
} else {
    $stmtAsignados->bind_param('iss', $usuarioId, $hoy, $hoy);
    $stmtAsignados->execute();
    $resAsignados = $stmtAsignados->get_result();
    if ($resAsignados) {
        while ($row = $resAsignados->fetch_assoc()) {
            $id = (int)$row['id'];
            if (isset($calendarioIdsYaAgregados[$id])) {
                continue;
            }
            $row['origen'] = 'asignado';
            $row['color'] = $row['color'] ?: calendar_default_color($row['tipo']);
            $calendarios[] = $row;
            $calendarioIdsYaAgregados[$id] = true;
        }
    }
    $stmtAsignados->close();
}

$timeMin = new DateTime('today', new DateTimeZone('America/Santiago'));
$timeMax = (clone $timeMin)->modify('+90 days');

if ($tablaCalendariosExiste && $tablaAsignacionesExiste && count($calendarios) > 0 && google_calendar_is_configured()) {
    foreach ($calendarios as $cal) {
        try {
            $items = google_calendar_fetch_events($cal['calendar_id'], $timeMin, $timeMax, 80);
            foreach ($items as $item) {
                $item['_calendar_id_app'] = (int)$cal['id'];
                $item['_calendar_nombre'] = $cal['nombre'];
                $item['_calendar_tipo'] = $cal['tipo'];
                $item['_calendar_tipo_label'] = calendar_tipo_label($cal['tipo']);
                $item['_calendar_color'] = $cal['color'] ?: calendar_default_color($cal['tipo']);
                $item['_calendar_origen'] = $cal['origen'];
                $eventos[] = $item;
            }
        } catch (Throwable $e) {
            $errores[] = 'No se pudo leer "' . $cal['nombre'] . '": ' . $e->getMessage();
        }
    }
}

usort($eventos, function ($a, $b) {
    return calendar_event_ts($a) <=> calendar_event_ts($b);
});

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Calendario</span>";
$boton_navbar = "<a></a><a></a>";

require('head.php');
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<main class="calendar-shell">
    <section class="app-hero app-hero-blue calendar-hero">
        <div class="app-hero-row">
            <div class="app-hero-body">
                <div class="app-hero-kicker calendar-kicker">Actividades docentes</div>
                <h2 class="calendar-title">Calendario académico</h2>
                <p class="calendar-subtitle">
                    Eventos generales<?php if ($esBecado && in_array($anioResidencia, array('1', '2', '3'), true)) { ?>, actividades R<?= (int)$anioResidencia ?><?php } ?> y calendarios asignados temporalmente para <?= h_nombre($usuario['nombre_usuario']) ?>.
                </p>
            </div>
        </div>
    </section>

    <?php if ($esAdmin) { ?>
        <div class="calendar-admin-note">
            <strong>Administración:</strong>
            puedes mantener calendarios y asignaciones desde <a href="admin_calendarios.php">Admin Calendario</a>.
        </div>
    <?php } ?>

    <?php foreach ($errores as $error) { ?>
        <div class="calendar-warning"><?= h($error) ?></div>
    <?php } ?>

    <?php if (!google_calendar_is_configured()) { ?>
        <div class="calendar-warning">
            Falta configurar <strong>google-calendar/service-account.json</strong> o ajustar la ruta del JSON en <strong>google-calendar/config.php</strong>.
        </div>
    <?php } ?>

    <?php if (!$tieneColor) { ?>
        <div class="calendar-warning">
            Recomendado: agrega el campo <strong>color</strong> a <strong>calendarios_app</strong> para personalizar cada calendario:<br>
            <code>ALTER TABLE calendarios_app ADD color VARCHAR(7) DEFAULT '#3b82f6';</code>
        </div>
    <?php } ?>

    <section class="calendar-card">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-3">
            <div>
                <strong>Calendarios visibles</strong>
                <div class="small text-muted">Ventana: próximos 90 días.</div>
            </div>
            <div class="calendar-filter-row" id="calendarFilters">
                <button class="calendar-chip is-active" type="button" data-filter="all">Todos</button>
                <?php foreach ($calendarios as $cal) { ?>
                    <button class="calendar-chip" type="button" data-filter="cal-<?= (int)$cal['id'] ?>"><?= h($cal['nombre']) ?></button>
                <?php } ?>
            </div>
        </div>

        <?php if (count($calendarios) === 0) { ?>
            <div class="calendar-empty">
                <div class="mb-2"><i class="fa-regular fa-calendar"></i></div>
                <strong>No hay calendarios activos para tu perfil.</strong>
                <div class="small mt-1">Un administrador debe registrar calendarios activos o asignarte calendarios temporales.</div>
            </div>
        <?php } elseif (count($eventos) === 0) { ?>
            <div class="calendar-empty">
                <div class="mb-2"><i class="fa-regular fa-calendar-check"></i></div>
                <strong>No hay eventos próximos para mostrar.</strong>
                <div class="small mt-1">Si acabas de configurar Google Calendar, verifica que el calendario tenga eventos futuros y esté compartido con la cuenta de servicio.</div>
            </div>
        <?php } else { ?>
            <div id="calendarEvents">
                <?php foreach ($eventos as $evento) { ?>
                    <article class="calendar-event" data-calendar="cal-<?= (int)$evento['_calendar_id_app'] ?>" data-calendar-type="<?= h($evento['_calendar_tipo']) ?>">
                        <div class="calendar-event-color" style="background:<?= h($evento['_calendar_color']) ?>"></div>
                        <div class="calendar-event-main">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                                <div>
                                    <div class="calendar-event-date"><?= calendar_format_date($evento) ?></div>
                                    <div class="calendar-event-title"><?= h($evento['summary'] ?? 'Evento sin título') ?></div>
                                    <div class="calendar-event-meta">
                                        <strong><?= h($evento['_calendar_nombre']) ?></strong>
                                        <span class="text-muted"> · <?= h($evento['_calendar_tipo_label']) ?></span>
                                    </div>
                                    <?php if (!empty($evento['location'])) { ?>
                                        <div class="calendar-event-meta mt-1"><i class="fa-solid fa-location-dot me-1"></i><?= h($evento['location']) ?></div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <span class="calendar-badge">
                                        <span class="calendar-badge-dot" style="background:<?= h($evento['_calendar_color']) ?>"></span>
                                        <?= h($evento['_calendar_nombre']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php if (!empty($evento['description'])) { ?>
                                <div class="calendar-event-meta mt-2"><?= nl2br(h($evento['description'])) ?></div>
                            <?php } ?>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </section>
</main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filters = document.querySelectorAll('[data-filter]');
    const events = document.querySelectorAll('[data-calendar]');

    filters.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = btn.getAttribute('data-filter');
            filters.forEach(function (item) { item.classList.remove('is-active'); });
            btn.classList.add('is-active');

            events.forEach(function (eventCard) {
                const calendar = eventCard.getAttribute('data-calendar');
                eventCard.style.display = (filter === 'all' || filter === calendar) ? '' : 'none';
            });
        });
    });
});
</script>

<?php require('footer.php'); ?>
