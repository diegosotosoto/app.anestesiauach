<?php
require("conectar.php");
require_once __DIR__ . '/app_security.php';

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Error de conexi&oacute;n.");
}

/* =========================================================
   SEGURIDAD / ADMIN
========================================================= */

$usuario = app_current_user($conexion);

if (!$usuario || intval($usuario['admin']) !== 1) {
    header('Location: login.php');
    exit;
}

if($usuario['external_']==1){
  header('Location: index.php');
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

    $rut_init        = trim($_POST['rut_init'] ?? '');
    $rut             = strtolower(dbtxt($_POST['rut'] ?? ''));
    $nombre_paciente = dbtxt($_POST['nombre_paciente'] ?? '');
    $ficha           = dbtxt($_POST['ficha'] ?? '');
    $tabla_origen    = $_POST['tabla_origen'] ?? 'pacientes'; // 'pacientes' o 'pacientes_alta'

    if ($rut_init === "" || $rut === "" || $nombre_paciente === "" || $ficha === "") {

        $tipo_mensaje = "danger";
        $mensaje = "Faltan datos obligatorios. No se guardaron cambios.";

    } else {

        $tabla = ($tabla_origen === 'pacientes_alta') ? 'pacientes_alta' : 'pacientes';
        $id_col = ($tabla === 'pacientes_alta') ? '`id` = ?' : '`rut` = ?';
        $id_val = ($tabla === 'pacientes_alta') ? intval($_POST['rut_init_id'] ?? 0) : $rut_init;

        $stmt_update = $conexion->prepare("
            UPDATE `$tabla`
            SET `nombre_paciente` = ?, `ficha` = ?, `rut` = ?
            WHERE $id_col
            LIMIT 1
        ");

        if ($tabla === 'pacientes_alta') {
            $stmt_update->bind_param("sssi", $nombre_paciente, $ficha, $rut, $id_val);
        } else {
            $stmt_update->bind_param("ssss", $nombre_paciente, $ficha, $rut, $id_val);
        }

        if ($stmt_update->execute()) {
            $tipo_mensaje = "success";
            $mensaje = "<strong>Paciente actualizado correctamente.</strong><br>"
                . h($nombre_paciente) . "<br>"
                . "<span class='text-muted'>RUT:</span> " . h($rut)
                . " &middot; <span class='text-muted'>Ficha:</span> " . h($ficha);
        } else {
            $tipo_mensaje = "danger";
            $mensaje = "Error al guardar. Contacta al administrador.";
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
    $like = "%" . $q . "%";
    $like_entities = "%" . htmlentities($q, ENT_QUOTES | ENT_HTML5, 'UTF-8') . "%";
    $where[] = "(`nombre_paciente` LIKE ? OR `nombre_paciente` LIKE ? OR `rut` LIKE ? OR `ficha` LIKE ?)";
    $params[] = $like; $params[] = $like_entities; $params[] = $like; $params[] = $like;
    $types .= "ssss";
}

$where_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

// Determinar qué tabla(s) consultar según filtro
if ($filtro_estado === 'alta') {
    $sql_pacientes = "SELECT `id`, `nombre_paciente`, `rut`, `ficha`, 'pacientes_alta' AS _tabla FROM `pacientes_alta` $where_sql ORDER BY `nombre_paciente` ASC LIMIT 150";
} elseif ($filtro_estado === 'activos') {
    $sql_pacientes = "SELECT 0 AS `id`, `nombre_paciente`, `rut`, `ficha`, 'pacientes' AS _tabla FROM `pacientes` $where_sql ORDER BY `nombre_paciente` ASC LIMIT 150";
} else {
    // todos: union de ambas tablas
    $sql_pacientes = "(SELECT 0 AS `id`, `nombre_paciente`, `rut`, `ficha`, 'pacientes' AS _tabla FROM `pacientes` $where_sql)
                      UNION ALL
                      (SELECT `id`, `nombre_paciente`, `rut`, `ficha`, 'pacientes_alta' AS _tabla FROM `pacientes_alta` $where_sql)
                      ORDER BY `nombre_paciente` ASC LIMIT 150";
    // params duplicados para el UNION
    if (count($params) > 0) { $params = array_merge($params, $params); $types .= $types; }
}

$stmt_pacientes = $conexion->prepare($sql_pacientes);
if (count($params) > 0) { $stmt_pacientes->bind_param($types, ...$params); }
$stmt_pacientes->execute();
$tab_pacientes = $stmt_pacientes->get_result();

/* =========================================================
   CONTADORES
========================================================= */

$total_activos   = intval($conexion->query("SELECT COUNT(*) AS c FROM `pacientes`")->fetch_assoc()['c'] ?? 0);
$total_altas     = intval($conexion->query("SELECT COUNT(*) AS c FROM `pacientes_alta`")->fetch_assoc()['c'] ?? 0);
$total_pacientes = $total_activos + $total_altas;
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
            <a class="stat-card stat-filter-btn <?php echo $filtro_estado === 'todos' ? 'is-active' : ''; ?>" href="gestion_pacientes.php?estado=todos<?php echo $q !== '' ? '&q=' . urlencode($q) : ''; ?>">
                <div>
                    <div class="stat-value"><?php echo $total_pacientes; ?></div>
                    <div class="stat-label">Total</div>
                </div>
            </a>

            <a class="stat-card stat-filter-btn <?php echo $filtro_estado === 'activos' ? 'is-active' : ''; ?>" href="gestion_pacientes.php?estado=activos<?php echo $q !== '' ? '&q=' . urlencode($q) : ''; ?>">
                <div>
                    <div class="stat-value"><?php echo $total_activos; ?></div>
                    <div class="stat-label">Seguimiento<br>activo</div>
                </div>
            </a>

            <a class="stat-card stat-filter-btn <?php echo $filtro_estado === 'alta' ? 'is-active' : ''; ?>" href="gestion_pacientes.php?estado=alta<?php echo $q !== '' ? '&q=' . urlencode($q) : ''; ?>">
                <div>
                    <div class="stat-value"><?php echo $total_altas; ?></div>
                    <div class="stat-label">De alta</div>
                </div>
            </a>
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
                $tabla_row   = $row['_tabla'] ?? 'pacientes';
                $id_row      = intval($row['id'] ?? 0);
                $badge_class = ($tabla_row === 'pacientes_alta') ? "status-alta" : "status-active";
                $badge_text  = ($tabla_row === 'pacientes_alta') ? "De alta" : "Seguimiento activo";
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
                            <input type="hidden" name="tabla_origen" value="<?php echo h_raw($tabla_row); ?>">
                            <input type="hidden" name="rut_init_id" value="<?php echo $id_row; ?>">

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
<?php require("footer.php"); ?>
