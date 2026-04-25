<?php
if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim($_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    header('Location: login.php');
    exit;
}

require('conectar.php');
require_once __DIR__ . '/google-calendar/config.php';

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

function h($txt)
{
    return htmlspecialchars((string)$txt, ENT_QUOTES, 'UTF-8');
}

function h_nombre($txt)
{
    return htmlspecialchars(
        html_entity_decode((string)$txt, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        ENT_QUOTES,
        'UTF-8'
    );
}

function calendar_event_start_value($event)
{
    if (isset($event['start']['dateTime'])) {
        return $event['start']['dateTime'];
    }

    return $event['start']['date'] ?? '';
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

$tiposPermitidos = array('general');
if ((int)$usuario['becad_'] === 1 && in_array((string)$usuario['anio_residencia'], array('1', '2', '3'), true)) {
    $tiposPermitidos[] = 'r' . (int)$usuario['anio_residencia'];
}

$calendarios = array();
$errores = array();
$eventos = array();
$tablaCalendariosExiste = true;

$placeholders = implode(',', array_fill(0, count($tiposPermitidos), '?'));
$sqlCalendarios = "SELECT `id`, `nombre`, `calendar_id`, `tipo`
    FROM `calendarios_app`
    WHERE `activo` = 1
      AND `tipo` IN ($placeholders)
    ORDER BY FIELD(`tipo`, 'general', 'r1', 'r2', 'r3'), `nombre` ASC";

$stmtCalendarios = $conexion->prepare($sqlCalendarios);
if (!$stmtCalendarios) {
    $tablaCalendariosExiste = false;
    $errores[] = 'No se pudo consultar calendarios_app. Verifica que la tabla exista.';
} else {
    if (count($tiposPermitidos) === 1) {
        $tipoUno = $tiposPermitidos[0];
        $stmtCalendarios->bind_param('s', $tipoUno);
    } else {
        $tipoUno = $tiposPermitidos[0];
        $tipoDos = $tiposPermitidos[1];
        $stmtCalendarios->bind_param('ss', $tipoUno, $tipoDos);
    }
    $stmtCalendarios->execute();
    $resCalendarios = $stmtCalendarios->get_result();
    if ($resCalendarios) {
        while ($row = $resCalendarios->fetch_assoc()) {
            $calendarios[] = $row;
        }
    }
    $stmtCalendarios->close();
}

$timeMin = new DateTime('today', new DateTimeZone('America/Santiago'));
$timeMax = (clone $timeMin)->modify('+90 days');

if ($tablaCalendariosExiste && count($calendarios) > 0 && google_calendar_is_configured()) {
    foreach ($calendarios as $cal) {
        try {
            $items = google_calendar_fetch_events($cal['calendar_id'], $timeMin, $timeMax, 40);
            foreach ($items as $item) {
                $item['_calendar_nombre'] = $cal['nombre'];
                $item['_calendar_tipo'] = $cal['tipo'];
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

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='--bs-border-opacity:.1;' href='index.php'><i class='fa fa-chevron-left me-1'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Calendario</span>";
$boton_navbar = "<a></a><a></a>";

require('head.php');
?>

<style>
.calendar-shell{
    width:100%;
    max-width:1120px;
    margin:0 auto;
    padding:0 .75rem 2rem;
}
.calendar-hero,
.calendar-card{
    background:#fff;
    border:1px solid #dbe3f0;
    border-radius:22px;
    box-shadow:0 .45rem 1.2rem rgba(31,41,55,.06);
}
.calendar-hero{
    background:linear-gradient(135deg, #27458f 0%, #3f5bd1 55%, #5f8df0 100%);
    border-color:rgba(255,255,255,.18);
    color:#fff;
    padding:1.25rem;
    margin-bottom:1rem;
}
.calendar-kicker{
    color:rgba(255,255,255,.86);
    font-weight:800;
    font-size:.78rem;
    text-transform:uppercase;
    letter-spacing:.04em;
}
.calendar-title{
    color:#fff;
    font-weight:850;
    margin:.2rem 0;
}
.calendar-subtitle{
    color:rgba(255,255,255,.82);
    max-width:720px;
    margin:0 auto;
}
.calendar-card{
    padding:1rem;
    margin-bottom:1rem;
}
.calendar-filter-row{
    display:flex;
    flex-wrap:wrap;
    gap:.5rem;
}
.calendar-chip{
    border:1px solid #dbe3f0;
    background:#f8fafc;
    color:#374151;
    border-radius:999px;
    padding:.45rem .75rem;
    font-weight:700;
    font-size:.9rem;
}
.calendar-chip.is-active{
    background:#2f55b7;
    border-color:#2f55b7;
    color:#fff;
}
.calendar-event{
    border:1px solid #dbe3f0;
    border-radius:18px;
    padding:1rem;
    background:#fff;
    margin-bottom:.75rem;
}
.calendar-event-date{
    color:#2f55b7;
    font-size:.9rem;
    font-weight:800;
}
.calendar-event-title{
    color:#1f2937;
    font-weight:850;
    font-size:1.05rem;
    margin:.15rem 0;
}
.calendar-event-meta{
    color:#6b7280;
    font-size:.9rem;
}
.calendar-badge{
    display:inline-flex;
    align-items:center;
    border-radius:999px;
    padding:.22rem .55rem;
    font-size:.78rem;
    font-weight:800;
    background:#eef3fb;
    color:#2f55b7;
}
.calendar-empty{
    text-align:center;
    color:#6b7280;
    padding:2rem 1rem;
}
.calendar-warning{
    background:#fff8e6;
    border:1px solid #fde3a4;
    color:#805700;
    border-radius:18px;
    padding:1rem;
    margin-bottom:1rem;
}
.calendar-admin-note{
    background:#eef3fb;
    border:1px solid #dbe3f0;
    color:#244aa5;
    border-radius:18px;
    padding:1rem;
    margin-bottom:1rem;
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<main class="calendar-shell">
    <section class="calendar-hero text-center">
        <div class="calendar-kicker">Actividades docentes</div>
        <h2 class="calendar-title">Calendario académico</h2>
        <div class="calendar-subtitle">
            Eventos generales<?php if ((int)$usuario['becad_'] === 1 && $usuario['anio_residencia']) { ?> y actividades R<?= (int)$usuario['anio_residencia'] ?><?php } ?> para <?= h_nombre($usuario['nombre_usuario']) ?>.
        </div>
    </section>

    <?php if ((int)$usuario['admin'] === 1) { ?>
        <div class="calendar-admin-note">
            <strong>Administración:</strong>
            puedes mantener los calendarios desde <a href="admin_calendarios.php">admin_calendarios.php</a>.
        </div>
    <?php } ?>

    <?php foreach ($errores as $error) { ?>
        <div class="calendar-warning"><?= h($error) ?></div>
    <?php } ?>

    <?php if (!google_calendar_is_configured()) { ?>
        <div class="calendar-warning">
            Falta configurar <strong>google-calendar/service-account.json</strong>. Comparte cada calendario con el email de la cuenta de servicio y deja el JSON en esa ruta del servidor.
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
                    <button class="calendar-chip" type="button" data-filter="<?= h($cal['tipo']) ?>"><?= h($cal['nombre']) ?></button>
                <?php } ?>
            </div>
        </div>

        <?php if (count($calendarios) === 0) { ?>
            <div class="calendar-empty">
                <div class="mb-2"><i class="fa-regular fa-calendar"></i></div>
                <strong>No hay calendarios activos para tu perfil.</strong>
                <div class="small mt-1">Un administrador debe registrar calendarios activos en <code>calendarios_app</code>.</div>
            </div>
        <?php } elseif (count($eventos) === 0) { ?>
            <div class="calendar-empty">
                <div class="mb-2"><i class="fa-regular fa-calendar-check"></i></div>
                <strong>No hay eventos próximos para mostrar.</strong>
                <div class="small mt-1">Si acabas de configurar Google Calendar, verifica permisos de la cuenta de servicio.</div>
            </div>
        <?php } else { ?>
            <div id="calendarEvents">
                <?php foreach ($eventos as $evento) { ?>
                    <article class="calendar-event" data-calendar-type="<?= h($evento['_calendar_tipo']) ?>">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                            <div>
                                <div class="calendar-event-date"><?= h(calendar_format_date($evento)) ?></div>
                                <div class="calendar-event-title"><?= h($evento['summary'] ?? 'Evento sin título') ?></div>
                                <?php if (!empty($evento['location'])) { ?>
                                    <div class="calendar-event-meta"><i class="fa-solid fa-location-dot me-1"></i><?= h($evento['location']) ?></div>
                                <?php } ?>
                            </div>
                            <div><span class="calendar-badge"><?= h($evento['_calendar_nombre']) ?></span></div>
                        </div>
                        <?php if (!empty($evento['description'])) { ?>
                            <div class="calendar-event-meta mt-2"><?= nl2br(h($evento['description'])) ?></div>
                        <?php } ?>
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
    const events = document.querySelectorAll('[data-calendar-type]');

    filters.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = btn.getAttribute('data-filter');
            filters.forEach(function (item) { item.classList.remove('is-active'); });
            btn.classList.add('is-active');

            events.forEach(function (eventCard) {
                const type = eventCard.getAttribute('data-calendar-type');
                eventCard.style.display = (filter === 'all' || filter === type) ? '' : 'none';
            });
        });
    });
});
</script>

<?php require('footer.php'); ?>
