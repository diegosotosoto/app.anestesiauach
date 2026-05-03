<?php 
if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])) {
    header('Location: login.php');
    exit;
}

require("conectar.php");

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Error de conexi&oacute;n.");
}

/* =========================================================
   SEGURIDAD / ADMIN
========================================================= */

$check_usuario = $_COOKIE['hkjh41lu4l1k23jhlkj13'];

$stmt_admin = $conexion->prepare("
    SELECT `admin`
    FROM `usuarios_dolor`
    WHERE `email_usuario` = ?
    LIMIT 1
");
$stmt_admin->bind_param("s", $check_usuario);
$stmt_admin->execute();
$res_admin = $stmt_admin->get_result();
$usuario = $res_admin->fetch_assoc();

if (!$usuario || intval($usuario['admin']) !== 1) {
    header('Location: login.php');
    exit;
}

/* =========================================================
   VARIABLES NAVBAR
========================================================= */


$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";

$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Gesti&oacute;n Pacientes</span>";
$boton_navbar = "<a></a><a></a>";

require("head.php");

/* =========================================================
   HELPERS
========================================================= */

function h($txt) {
    return htmlspecialchars(
        html_entity_decode((string)$txt, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        ENT_QUOTES,
        'UTF-8'
    );
}

function h_raw($txt) {
    return htmlspecialchars((string)$txt, ENT_QUOTES, 'UTF-8');
}

function dbtxt($txt) {
    return trim((string)$txt);
}

$mensaje = "";
$tipo_mensaje = "";

/* =========================================================
   GUARDAR EDICI&Oacute;N
========================================================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_paciente'])) {

    $rut_init = trim($_POST['rut_init'] ?? '');
    $rut = strtolower(dbtxt($_POST['rut'] ?? ''));
    $nombre_paciente = dbtxt($_POST['nombre_paciente'] ?? '');
    $ficha = dbtxt($_POST['ficha'] ?? '');
    $de_alta = isset($_POST['de_alta']) && $_POST['de_alta'] === "1" ? 1 : 0;

    if ($rut_init === "" || $rut === "" || $nombre_paciente === "" || $ficha === "") {

        $tipo_mensaje = "danger";
        $mensaje = "Faltan datos obligatorios. No se guardaron cambios.";

    } else {

        $stmt_check = $conexion->prepare("
            SELECT COUNT(*) AS total
            FROM `pacientes`
            WHERE `rut` = ?
              AND `rut` <> ?
        ");
        $stmt_check->bind_param("ss", $rut, $rut_init);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        $row_check = $res_check->fetch_assoc();

        if (intval($row_check['total']) > 0) {

            $tipo_mensaje = "warning";
            $mensaje = "No se guard&oacute;: ya existe otro paciente con el RUT " . h($rut) . ".";

        } else {

            $stmt_update = $conexion->prepare("
                UPDATE `pacientes`
                SET
                    `nombre_paciente` = ?,
                    `ficha` = ?,
                    `rut` = ?,
                    `de_alta` = ?
                WHERE `rut` = ?
                LIMIT 1
            ");

            $stmt_update->bind_param(
                "sssis",
                $nombre_paciente,
                $ficha,
                $rut,
                $de_alta,
                $rut_init
            );

            if ($stmt_update->execute()) {

                $tipo_mensaje = "success";
                $estado_txt = $de_alta === 1 ? "De alta" : "Seguimiento activo";

                $mensaje = "
                    <strong>Paciente actualizado correctamente.</strong><br>
                    " . h($nombre_paciente) . "<br>
                    <span class='text-muted'>RUT:</span> " . h($rut) . " &middot;
                    <span class='text-muted'>Ficha:</span> " . h($ficha) . " &middot;
                    <span class='text-muted'>Estado:</span> " . h($estado_txt);

            } else {

                $tipo_mensaje = "danger";
                $mensaje = "Error al guardar. Contacta al administrador.";
            }
        }
    }
}

/* =========================================================
   B&Uacute;SQUEDA / FILTROS
========================================================= */

$q = trim($_GET['q'] ?? '');
$filtro_estado = $_GET['estado'] ?? 'todos';

if (!in_array($filtro_estado, ['todos', 'activos', 'alta'], true)) {
    $filtro_estado = 'todos';
}

$where = [];
$params = [];
$types = "";

if ($q !== "") {
    $where[] = "(
        `nombre_paciente` LIKE ?
        OR `nombre_paciente` LIKE ?
        OR `rut` LIKE ?
        OR `ficha` LIKE ?
    )";

    $like = "%" . $q . "%";
    $like_entities = "%" . htmlentities($q, ENT_QUOTES | ENT_HTML5, 'UTF-8') . "%";

    $params[] = $like;
    $params[] = $like_entities;
    $params[] = $like;
    $params[] = $like;
    $types .= "ssss";
}

if ($filtro_estado === "activos") {
    $where[] = "`de_alta` = 0";
} elseif ($filtro_estado === "alta") {
    $where[] = "`de_alta` = 1";
}

$where_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

$sql_pacientes = "
    SELECT
        `nombre_paciente`,
        `rut`,
        `ficha`,
        `de_alta`
    FROM `pacientes`
    $where_sql
    ORDER BY
        `de_alta` ASC,
        `nombre_paciente` ASC
    LIMIT 150
";

$stmt_pacientes = $conexion->prepare($sql_pacientes);

if (count($params) > 0) {
    $stmt_pacientes->bind_param($types, ...$params);
}

$stmt_pacientes->execute();
$tab_pacientes = $stmt_pacientes->get_result();

/* =========================================================
   CONTADORES
========================================================= */

$res_total = $conexion->query("
    SELECT
        COUNT(*) AS total,
        SUM(CASE WHEN `de_alta` = 0 THEN 1 ELSE 0 END) AS activos,
        SUM(CASE WHEN `de_alta` = 1 THEN 1 ELSE 0 END) AS altas
    FROM `pacientes`
");

$stats = $res_total->fetch_assoc();

$total_pacientes = intval($stats['total'] ?? 0);
$total_activos = intval($stats['activos'] ?? 0);
$total_altas = intval($stats['altas'] ?? 0);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
    <main class="admin-page admin-pacientes-wrap">

        <section class="app-hero app-hero-admin admin-header-card mb-3">
            <div class="app-hero-kicker">Administración</div>
            <h2>Gesti&oacute;n de Pacientes</h2>
            <p>Edita identificaci&oacute;n, ficha cl&iacute;nica y estado de alta de pacientes del m&oacute;dulo Dolor.</p>
            <span class="app-hero-pill">Solo administradores</span>
        </section>

        <?php if ($mensaje !== ""): ?>
            <div class="alert alert-<?php echo h($tipo_mensaje); ?> alert-dismissible fade show admin-alert mb-3">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <section class="stats-grid">
            <div class="stat-card">
                <div>
                    <div class="stat-value"><?php echo $total_pacientes; ?></div>
                    <div class="stat-label">Total</div>
                </div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-value"><?php echo $total_activos; ?></div>
                    <div class="stat-label">Seguimiento<br>activo</div>
                </div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-value"><?php echo $total_altas; ?></div>
                    <div class="stat-label">De alta</div>
                </div>
            </div>
        </section>

        <section class="admin-panel">
            <form method="get" action="gestion_pacientes.php" id="formBuscar">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-lg-7">
                        <label class="form-label" for="q">Buscar paciente</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control"
                                id="q"
                                name="q"
                                value="<?php echo h($q); ?>"
                                placeholder="Nombre, RUT o ficha cl&iacute;nica"
                                autocomplete="off"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label" for="estado">Estado</label>
                        <select class="form-select" name="estado" id="estado">
                            <option value="todos" <?php echo $filtro_estado === "todos" ? "selected" : ""; ?>>Todos</option>
                            <option value="activos" <?php echo $filtro_estado === "activos" ? "selected" : ""; ?>>Seguimiento activo</option>
                            <option value="alta" <?php echo $filtro_estado === "alta" ? "selected" : ""; ?>>De alta</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2 d-grid">
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>

                <?php if ($q !== "" || $filtro_estado !== "todos"): ?>
                    <div class="mt-3 d-flex justify-content-end">
                        <a href="gestion_pacientes.php" class="btn btn-admin-outline">
                            <i class="fa fa-times"></i> Limpiar filtros
                        </a>
                    </div>
                <?php endif; ?>

                <div class="filter-note">
                    Se muestran hasta <strong>150 resultados</strong>. La b&uacute;squeda revisa nombre, RUT y ficha cl&iacute;nica.
                </div>
            </form>
        </section>

        <div class="result-toolbar">
            <div>
                Mostrando m&aacute;ximo 150 resultados.
            </div>
            <?php if ($q !== ""): ?>
                <div>
                    B&uacute;squeda: <strong><?php echo h($q); ?></strong>
                </div>
            <?php endif; ?>
        </div>

        <section class="patient-grid">
            <?php
            $hay_pacientes = false;

            while ($row = $tab_pacientes->fetch_assoc()):
                $hay_pacientes = true;

                $nombre_paciente_raw = $row['nombre_paciente'] ?? '';
                $rut_raw = $row['rut'] ?? '';
                $ficha_raw = $row['ficha'] ?? '';

                $nombre_paciente = html_entity_decode($nombre_paciente_raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $rut = html_entity_decode($rut_raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $ficha = html_entity_decode($ficha_raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $de_alta = intval($row['de_alta'] ?? 0);

                $checked = $de_alta === 1 ? "checked" : "";
                $badge_class = $de_alta === 1 ? "status-alta" : "status-active";
                $badge_text = $de_alta === 1 ? "De alta" : "Seguimiento activo";
            ?>

                <article class="patient-card">
                    <div class="patient-card-header">
                        <div class="patient-topline">
                            <div>
                                <div class="patient-name"><?php echo h($nombre_paciente); ?></div>
                                <div class="patient-meta">
                                    <span class="meta-pill"><i class="fa fa-id-card"></i> RUT: <?php echo h($rut); ?></span>
                                    <span class="meta-pill"><i class="fa fa-folder-medical"></i> Ficha: <?php echo h($ficha); ?></span>
                                </div>
                            </div>
                            <span class="status-badge <?php echo $badge_class; ?>">
                                <?php echo h($badge_text); ?>
                            </span>
                        </div>
                    </div>

                    <div class="patient-card-body">
                        <form action="gestion_pacientes.php?<?php echo http_build_query(['q' => $q, 'estado' => $filtro_estado]); ?>" method="post">
                            <input type="hidden" name="guardar_paciente" value="1">
                            <input type="hidden" name="rut_init" value="<?php echo h_raw($rut_raw); ?>">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Nombre paciente</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="nombre_paciente"
                                        value="<?php echo h($nombre_paciente); ?>"
                                        required
                                    >
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">RUT</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="rut"
                                        value="<?php echo h($rut); ?>"
                                        required
                                    >
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Ficha cl&iacute;nica</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="ficha"
                                        value="<?php echo h($ficha); ?>"
                                        required
                                    >
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="de_alta"
                                            id="alta_<?php echo md5($rut_raw); ?>"
                                            value="1"
                                            <?php echo $checked; ?>
                                        >
                                        <label class="form-check-label" for="alta_<?php echo md5($rut_raw); ?>">
                                            Paciente de alta
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-admin-primary">
                                        <i class="fa fa-save"></i> Guardar cambios
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </article>

            <?php endwhile; ?>

            <?php if (!$hay_pacientes): ?>
                <div class="empty-state-card admin-grid-full">
                    <i class="fa fa-search fa-2x"></i>
                    <strong>No se encontraron pacientes.</strong>
                    <div>Prueba con otro nombre, RUT, ficha o cambia el filtro de estado.</div>
                </div>
            <?php endif; ?>
        </section>

    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("q");
    const selectEstado = document.getElementById("estado");
    const formBuscar = document.getElementById("formBuscar");

    let timer = null;

    if (inputBuscar) {
        inputBuscar.addEventListener("keyup", function () {
            clearTimeout(timer);

            timer = setTimeout(function () {
                const texto = inputBuscar.value.trim();

                if (texto.length === 0 || texto.length >= 3) {
                    formBuscar.submit();
                }
            }, 550);
        });
    }

    if (selectEstado) {
        selectEstado.addEventListener("change", function () {
            formBuscar.submit();
        });
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll("form").forEach(function(form) {

        form.addEventListener("submit", function(e) {

            const altaSwitch = form.querySelector('input[name="de_alta"]');

            if (!altaSwitch) return;

            if (altaSwitch.checked) {
                const confirmar = confirm(
                    "¿Confirmas que deseas dar de alta a este paciente?\n\n" +
                    "El paciente quedará marcado como de alta en el sistema de Dolor."
                );

                if (!confirmar) {
                    e.preventDefault();
                    return false;
                }
            }

        });

    });

});
</script>
<?php require("footer.php"); ?>
