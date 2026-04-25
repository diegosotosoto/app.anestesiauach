<?php
if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim($_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    header('Location: login.php');
    exit;
}

require('conectar.php');
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

function h($txt)
{
    return htmlspecialchars((string)$txt, ENT_QUOTES, 'UTF-8');
}

function post_val($key, $default = '')
{
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

$emailUsuario = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);
$stmtAdmin = $conexion->prepare("SELECT `ID`, `admin`, `nombre_usuario`, `email_usuario`
    FROM `usuarios_dolor`
    WHERE `email_usuario` = ?
    LIMIT 1");

$usuarioAdmin = null;
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
$tiposValidos = array('general', 'r1', 'r2', 'r3');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = post_val('accion');

    if ($accion === 'guardar') {
        $id = (int)post_val('id', '0');
        $nombre = post_val('nombre');
        $calendarId = post_val('calendar_id');
        $tipo = strtolower(post_val('tipo'));
        $activo = isset($_POST['activo']) ? 1 : 0;

        if ($nombre === '' || $calendarId === '' || !in_array($tipo, $tiposValidos, true)) {
            $mensajeError = 'Faltan datos obligatorios o el tipo no es válido.';
        } elseif ($id > 0) {
            $stmt = $conexion->prepare("UPDATE `calendarios_app`
                SET `nombre` = ?, `calendar_id` = ?, `tipo` = ?, `activo` = ?
                WHERE `id` = ?
                LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('sssii', $nombre, $calendarId, $tipo, $activo, $id);
                $mensajeOk = $stmt->execute() ? 'Calendario actualizado.' : 'No se pudo actualizar el calendario.';
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar el guardado.';
            }
        } else {
            $stmt = $conexion->prepare("INSERT INTO `calendarios_app` (`nombre`, `calendar_id`, `tipo`, `activo`)
                VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('sssi', $nombre, $calendarId, $tipo, $activo);
                $mensajeOk = $stmt->execute() ? 'Calendario agregado.' : 'No se pudo agregar el calendario.';
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar el nuevo calendario. Verifica que exista la tabla calendarios_app.';
            }
        }
    }

    if ($accion === 'eliminar') {
        $id = (int)post_val('id', '0');
        if ($id <= 0) {
            $mensajeError = 'No se recibió el calendario a eliminar.';
        } else {
            $stmt = $conexion->prepare("DELETE FROM `calendarios_app` WHERE `id` = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('i', $id);
                $mensajeOk = $stmt->execute() ? 'Calendario eliminado.' : 'No se pudo eliminar el calendario.';
                $stmt->close();
            } else {
                $mensajeError = 'No se pudo preparar la eliminación.';
            }
        }
    }
}

$calendarios = array();
$tablaCalendariosExiste = true;
$resCalendarios = $conexion->query("SELECT `id`, `nombre`, `calendar_id`, `tipo`, `activo`
    FROM `calendarios_app`
    ORDER BY FIELD(`tipo`, 'general', 'r1', 'r2', 'r3'), `nombre` ASC");

if ($resCalendarios) {
    while ($row = $resCalendarios->fetch_assoc()) {
        $calendarios[] = $row;
    }
} else {
    $tablaCalendariosExiste = false;
}

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark admin-back-btn' style='--bs-border-opacity:.1;' href='index.php'><i class='fa fa-chevron-left me-1'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Calendarios</span>";
$boton_navbar = "<a></a><a></a>";

require('head.php');
?>

<style>
.admin-page{
    width:100%;
    max-width:1100px;
    margin:0 auto;
    padding:0 .75rem 2rem;
}
.admin-header-card,
.admin-filter-card,
.admin-item-card{
    background:#fff;
    border:1px solid #dbe3f0;
    border-radius:1.35rem;
    box-shadow:0 .35rem 1rem rgba(31,41,55,.05);
}
.admin-header-title{
    color:#1f2937;
    font-weight:850;
    margin:0;
}
.admin-header-subtitle,
.admin-item-meta,
.admin-help-text{
    color:#6b7280;
}
.admin-form-label{
    color:#374151;
    font-size:.85rem;
    font-weight:800;
    margin-bottom:.25rem;
}
.admin-input,
.admin-select{
    border-color:#dbe3f0;
    border-radius:.85rem;
}
.btn-admin-primary{
    background:#2f55b7;
    border-color:#2f55b7;
    color:#fff;
    border-radius:.85rem;
    font-weight:800;
}
.btn-admin-primary:hover{
    background:#244aa5;
    border-color:#244aa5;
    color:#fff;
}
.btn-admin-danger{
    background:#dc3545;
    border-color:#dc3545;
    color:#fff;
    border-radius:.85rem;
    font-weight:800;
}
.btn-admin-outline{
    border:1px solid #dbe3f0;
    color:#2f55b7;
    background:#fff;
    border-radius:.85rem;
    font-weight:800;
}
.admin-badge{
    display:inline-flex;
    align-items:center;
    border-radius:999px;
    padding:.25rem .6rem;
    font-size:.78rem;
    font-weight:850;
}
.admin-badge-primary{ background:#eef3fb; color:#2f55b7; }
.admin-badge-muted{ background:#f3f4f6; color:#6b7280; }
.admin-badge-success{ background:#e8f6ef; color:#198754; }
.admin-badge-warning{ background:#fff8e6; color:#946200; }
.admin-empty-state{
    color:#6b7280;
    text-align:center;
    padding:2rem 1rem;
}
.admin-item-header{
    display:flex;
    justify-content:space-between;
    gap:1rem;
    align-items:flex-start;
    margin-bottom:.8rem;
}
.admin-item-title{
    color:#1f2937;
    font-weight:850;
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<main class="admin-page">
    <div class="card admin-header-card mb-3">
        <div class="card-body">
            <h4 class="admin-header-title">Calendarios docentes</h4>
            <div class="admin-header-subtitle">Registra calendarios Google visibles para todos o por año de residencia.</div>
        </div>
    </div>

    <?php if ($mensajeOk !== '') { ?>
        <div class="alert alert-success"><?= h($mensajeOk) ?></div>
    <?php } ?>
    <?php if ($mensajeError !== '') { ?>
        <div class="alert alert-danger"><?= h($mensajeError) ?></div>
    <?php } ?>

    <?php if (!$tablaCalendariosExiste) { ?>
        <div class="alert alert-warning">
            Falta crear la tabla <code>calendarios_app</code>.
            <pre class="mt-2 mb-0 small">CREATE TABLE calendarios_app (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  calendar_id VARCHAR(255) NOT NULL,
  tipo VARCHAR(20) NOT NULL,
  activo TINYINT(1) DEFAULT 1
);</pre>
        </div>
    <?php } ?>

    <div class="card admin-filter-card mb-3">
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="accion" value="guardar">
                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="admin-form-label">Nombre</label>
                        <input class="form-control admin-input" name="nombre" placeholder="General, R1, R2..." required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="admin-form-label">Calendar ID</label>
                        <input class="form-control admin-input" name="calendar_id" placeholder="xxxx@group.calendar.google.com" required>
                    </div>
                    <div class="col-8 col-md-2">
                        <label class="admin-form-label">Tipo</label>
                        <select class="form-select admin-select" name="tipo" required>
                            <option value="general">General</option>
                            <option value="r1">R1</option>
                            <option value="r2">R2</option>
                            <option value="r3">R3</option>
                        </select>
                    </div>
                    <div class="col-4 col-md-1">
                        <label class="admin-form-label">Activo</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="activo" checked>
                        </div>
                    </div>
                    <div class="col-12 col-md-1 d-grid">
                        <button class="btn btn-admin-primary">Agregar</button>
                    </div>
                </div>
            </form>
            <div class="admin-help-text small mt-2">
                Comparte cada calendario en Google con el email de la cuenta de servicio y permiso "Ver todos los detalles".
            </div>
        </div>
    </div>

    <?php if (count($calendarios) === 0) { ?>
        <div class="card admin-item-card">
            <div class="admin-empty-state">
                <div class="mb-2"><i class="fa-regular fa-calendar"></i></div>
                <strong>No hay calendarios registrados.</strong>
                <div class="small mt-1">Agrega el calendario general y luego los de R1, R2 y R3.</div>
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
                        <span class="admin-badge admin-badge-primary"><?= h(strtoupper($cal['tipo'])) ?></span>
                        <span class="admin-badge <?= (int)$cal['activo'] === 1 ? 'admin-badge-success' : 'admin-badge-muted' ?>">
                            <?= (int)$cal['activo'] === 1 ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </div>
                </div>

                <form method="post">
                    <input type="hidden" name="accion" value="guardar">
                    <input type="hidden" name="id" value="<?= (int)$cal['id'] ?>">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-3">
                            <label class="admin-form-label">Nombre</label>
                            <input class="form-control admin-input" name="nombre" value="<?= h($cal['nombre']) ?>" required>
                        </div>
                        <div class="col-12 col-md-5">
                            <label class="admin-form-label">Calendar ID</label>
                            <input class="form-control admin-input" name="calendar_id" value="<?= h($cal['calendar_id']) ?>" required>
                        </div>
                        <div class="col-8 col-md-2">
                            <label class="admin-form-label">Tipo</label>
                            <select class="form-select admin-select" name="tipo" required>
                                <?php foreach ($tiposValidos as $tipo) { ?>
                                    <option value="<?= h($tipo) ?>" <?= $cal['tipo'] === $tipo ? 'selected' : '' ?>><?= h(strtoupper($tipo)) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4 col-md-1">
                            <label class="admin-form-label">Activo</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="activo" <?= (int)$cal['activo'] === 1 ? 'checked' : '' ?>>
                            </div>
                        </div>
                        <div class="col-12 col-md-1 d-grid">
                            <button class="btn btn-admin-primary">Guardar</button>
                        </div>
                    </div>
                </form>

                <form method="post" class="mt-2 text-end">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id" value="<?= (int)$cal['id'] ?>">
                    <button class="btn btn-sm btn-admin-danger" data-confirm="¿Confirmas eliminar este calendario de la app? No borra el calendario en Google.">Eliminar</button>
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
});
</script>

<?php require('footer.php'); ?>
