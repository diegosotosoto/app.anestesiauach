<?php
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
    exit;
}

require('conectar.php');
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

$check_usuario = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);
$stmt_admin = $conexion->prepare("SELECT `ID`, `admin`, `nombre_usuario`, `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
if(!$stmt_admin){
    die('Error preparando consulta de usuario.');
}
$stmt_admin->bind_param('s', $check_usuario);
$stmt_admin->execute();

$usuario = null;
if(method_exists($stmt_admin, 'get_result')){
    $res_admin = $stmt_admin->get_result();
    $usuario = $res_admin->fetch_assoc();
}else{
    $stmt_admin->bind_result($id_tmp, $admin_tmp, $nombre_tmp, $email_tmp);
    if($stmt_admin->fetch()){
        $usuario = [
            'ID' => $id_tmp,
            'admin' => $admin_tmp,
            'nombre_usuario' => $nombre_tmp,
            'email_usuario' => $email_tmp
        ];
    }
}
$stmt_admin->close();

if(!$usuario || (int)$usuario['admin'] !== 1){
    header('Location: login.php');
    exit;
}

function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function h_nombre($v){
    return function_exists('app_h_text') ? app_h_text($v) : htmlspecialchars(html_entity_decode((string)$v, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8');
}

function validar_fecha_export($fecha){
    $fecha = trim((string)$fecha);
    if($fecha === '') return '';
    if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) return '';
    return $fecha;
}

function definiciones_bitacoras($tipo){
    $defs = [
        'becados' => [[
            'tabla' => 'bitacora_proced',
            'alias' => 'bp',
            'id_col' => 'id_b',
            'fecha_col' => 'fecha_b',
            'autor_col' => 'autor_b',
            'staff_col' => 'staff_b',
            'label' => 'Becados / residentes Anestesiología',
            'join_usuario' => '',
            'extra_where' => ''
        ]],
        'internos' => [[
            'tabla' => 'bitacora_internos',
            'alias' => 'bi',
            'id_col' => 'id_i',
            'fecha_col' => 'fecha_i',
            'autor_col' => 'autor_i',
            'staff_col' => 'staff_i',
            'label' => 'Internos',
            'join_usuario' => "INNER JOIN `usuarios_dolor` uf ON uf.`email_usuario` = bi.`autor_i`",
            'extra_where' => 'AND uf.`intern_` = 1'
        ]],
        'otras_especialidades' => [[
            'tabla' => 'bitacora_internos',
            'alias' => 'bi',
            'id_col' => 'id_i',
            'fecha_col' => 'fecha_i',
            'autor_col' => 'autor_i',
            'staff_col' => 'staff_i',
            'label' => 'Residentes de otras especialidades',
            'join_usuario' => "INNER JOIN `usuarios_dolor` uf ON uf.`email_usuario` = bi.`autor_i`",
            'extra_where' => 'AND uf.`becad_otro` = 1'
        ]],
        'internos_y_otras' => [[
            'tabla' => 'bitacora_internos',
            'alias' => 'bi',
            'id_col' => 'id_i',
            'fecha_col' => 'fecha_i',
            'autor_col' => 'autor_i',
            'staff_col' => 'staff_i',
            'label' => 'Internos y residentes de otras especialidades',
            'join_usuario' => '',
            'extra_where' => ''
        ]]
    ];

    if($tipo === 'todas'){
        return array_merge($defs['becados'], $defs['internos_y_otras']);
    }

    return $defs[$tipo] ?? $defs['todas'] ?? array_merge($defs['becados'], $defs['internos_y_otras']);
}

function consulta_exportacion($conexion, $def, $desde, $hasta, $solo_raw = false){
    $a = $def['alias'];
    $fecha_col = $def['fecha_col'];
    $autor_col = $def['autor_col'];
    $staff_col = $def['staff_col'];

    $select = $solo_raw
        ? "$a.*"
        : "'" . $conexion->real_escape_string($def['label']) . "' AS `_origen`, $a.*, ua.`nombre_usuario` AS `_autor_nombre`, us.`nombre_usuario` AS `_staff_nombre`";

    $sql = "SELECT $select
            FROM `{$def['tabla']}` $a
            {$def['join_usuario']}";

    if(!$solo_raw){
        $sql .= "
            LEFT JOIN `usuarios_dolor` ua ON ua.`email_usuario` = $a.`$autor_col`
            LEFT JOIN `usuarios_dolor` us ON us.`email_usuario` = $a.`$staff_col`";
    }

    $sql .= " WHERE 1=1 {$def['extra_where']}";

    $params = [];
    $types = '';

    if($desde !== ''){
        $sql .= " AND $a.`$fecha_col` >= ?";
        $params[] = $desde;
        $types .= 's';
    }

    if($hasta !== ''){
        $sql .= " AND $a.`$fecha_col` <= ?";
        $params[] = $hasta . ' 23:59:59';
        $types .= 's';
    }

    $sql .= " ORDER BY $a.`$fecha_col` ASC, $a.`{$def['id_col']}` ASC";

    $stmt = $conexion->prepare($sql);
    if(!$stmt){
        throw new Exception('No se pudo preparar la consulta de exportación: ' . $conexion->error);
    }

    if(!empty($params)){
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $rows = [];

    if(method_exists($stmt, 'get_result')){
        $res = $stmt->get_result();
        while($row = $res->fetch_assoc()){
            $rows[] = $row;
        }
    }else{
        throw new Exception('El servidor PHP requiere mysqlnd para esta exportación.');
    }

    $stmt->close();
    return $rows;
}

function obtener_datos_exportacion($conexion, $tipo, $desde, $hasta, $solo_raw = false){
    $datos = [];
    foreach(definiciones_bitacoras($tipo) as $def){
        $rows = consulta_exportacion($conexion, $def, $desde, $hasta, $solo_raw);
        if($solo_raw){
            $datos[] = ['def' => $def, 'rows' => $rows];
        }else{
            foreach($rows as $row){
                $datos[] = $row;
            }
        }
    }
    return $datos;
}

function nombre_archivo_export($formato, $tipo, $desde, $hasta){
    $rango = ($desde !== '' || $hasta !== '') ? '_' . ($desde ?: 'inicio') . '_a_' . ($hasta ?: 'hoy') : '';
    return 'bitacoras_' . preg_replace('/[^a-z0-9_\-]/i', '', $tipo) . $rango . '.' . $formato;
}

function exportar_csv($datos, $filename){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo "\xEF\xBB\xBF";

    $out = fopen('php://output', 'w');
    if(empty($datos)){
        fputcsv($out, ['Sin datos para el rango seleccionado'], ';');
        fclose($out);
        exit;
    }

    $headers = [];
    foreach($datos as $row){
        foreach(array_keys($row) as $key){
            $headers[$key] = true;
        }
    }
    $headers = array_keys($headers);
    fputcsv($out, $headers, ';');

    foreach($datos as $row){
        $line = [];
        foreach($headers as $key){
            $line[] = $row[$key] ?? '';
        }
        fputcsv($out, $line, ';');
    }

    fclose($out);
    exit;
}

function exportar_json($datos, $filename){
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit;
}

function exportar_xls($datos, $filename){
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo "\xEF\xBB\xBF";
    echo "<table border='1'>";

    if(empty($datos)){
        echo "<tr><td>Sin datos para el rango seleccionado</td></tr></table>";
        exit;
    }

    $headers = [];
    foreach($datos as $row){
        foreach(array_keys($row) as $key){
            $headers[$key] = true;
        }
    }
    $headers = array_keys($headers);

    echo '<thead><tr>';
    foreach($headers as $h){
        echo '<th>' . htmlspecialchars($h, ENT_QUOTES, 'UTF-8') . '</th>';
    }
    echo '</tr></thead><tbody>';

    foreach($datos as $row){
        echo '<tr>';
        foreach($headers as $key){
            echo '<td>' . htmlspecialchars((string)($row[$key] ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
    exit;
}

function sql_valor($conexion, $v){
    if($v === null) return 'NULL';
    return "'" . $conexion->real_escape_string((string)$v) . "'";
}

function exportar_sql($conexion, $bloques, $filename){
    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    echo "-- Exportación de bitácoras App Anestesia UACh\n";
    echo "-- Generado: " . date('Y-m-d H:i:s') . "\n\n";

    $total = 0;
    foreach($bloques as $bloque){
        $tabla = $bloque['def']['tabla'];
        foreach($bloque['rows'] as $row){
            $total++;
            $cols = array_map(fn($c) => '`' . str_replace('`', '``', $c) . '`', array_keys($row));
            $vals = array_map(fn($v) => sql_valor($conexion, $v), array_values($row));
            echo 'INSERT INTO `' . $tabla . '` (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $vals) . ");\n";
        }
    }

    if($total === 0){
        echo "-- Sin datos para el rango seleccionado.\n";
    }
    exit;
}

$tipo = $_GET['tipo'] ?? 'todas';
$formato = $_GET['formato'] ?? 'csv';
$desde = validar_fecha_export($_GET['desde'] ?? '');
$hasta = validar_fecha_export($_GET['hasta'] ?? '');
$accion = $_GET['accion'] ?? '';
$error_export = '';

$tipos_validos = ['todas', 'becados', 'internos', 'otras_especialidades', 'internos_y_otras'];
$formatos_validos = ['csv', 'xls', 'json', 'sql'];

if(!in_array($tipo, $tipos_validos, true)) $tipo = 'todas';
if(!in_array($formato, $formatos_validos, true)) $formato = 'csv';

if($accion === 'exportar'){
    try{
        if($desde !== '' && $hasta !== '' && $desde > $hasta){
            throw new Exception('La fecha desde no puede ser posterior a la fecha hasta.');
        }

        if($formato === 'sql'){
            $bloques = obtener_datos_exportacion($conexion, $tipo, $desde, $hasta, true);
            exportar_sql($conexion, $bloques, nombre_archivo_export('sql', $tipo, $desde, $hasta));
        }

        $datos = obtener_datos_exportacion($conexion, $tipo, $desde, $hasta, false);

        if($formato === 'csv') exportar_csv($datos, nombre_archivo_export('csv', $tipo, $desde, $hasta));
        if($formato === 'xls') exportar_xls($datos, nombre_archivo_export('xls', $tipo, $desde, $hasta));
        if($formato === 'json') exportar_json($datos, nombre_archivo_export('json', $tipo, $desde, $hasta));
    }catch(Throwable $e){
        $error_export = $e->getMessage();
    }
}

$resumen_export = [
    'becados' => 0,
    'internos' => 0,
    'otras_especialidades' => 0,
    'internos_y_otras' => 0
];

$q = $conexion->query("SELECT COUNT(*) AS total FROM `bitacora_proced`");
if($q && $r = $q->fetch_assoc()) $resumen_export['becados'] = (int)$r['total'];

$q = $conexion->query("SELECT COUNT(*) AS total FROM `bitacora_internos`");
if($q && $r = $q->fetch_assoc()) $resumen_export['internos_y_otras'] = (int)$r['total'];

$q = $conexion->query("SELECT COUNT(*) AS total FROM `bitacora_internos` bi INNER JOIN `usuarios_dolor` u ON u.`email_usuario` = bi.`autor_i` WHERE u.`intern_` = 1");
if($q && $r = $q->fetch_assoc()) $resumen_export['internos'] = (int)$r['total'];

$q = $conexion->query("SELECT COUNT(*) AS total FROM `bitacora_internos` bi INNER JOIN `usuarios_dolor` u ON u.`email_usuario` = bi.`autor_i` WHERE u.`becad_otro` = 1");
if($q && $r = $q->fetch_assoc()) $resumen_export['otras_especialidades'] = (int)$r['total'];

$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Exportar Bitácoras</span>";
$boton_navbar = "<a></a><a></a>";

require('head.php');
?>

<style>
.export-shell{
    max-width:1100px;
    margin:0 auto;
}

.export-card{
    background:#fff;
    border:1px solid #dfe7f2;
    border-radius:18px;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    padding:1rem 1.1rem;
    margin-bottom:1rem;
}

.export-title{
    font-size:1.25rem;
    font-weight:800;
    color:#1f2a37;
}

.export-subtle{
    color:#6b7280;
    font-size:.92rem;
}

.export-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:12px;
}

.export-stat{
    background:linear-gradient(0deg, #e9effb 0%, #ffffff 42%, #ffffff 100%);
    border:1px solid #dfe7f2;
    border-radius:16px;
    padding:1rem;
}

.export-stat-num{
    font-size:1.55rem;
    font-weight:800;
    color:#244aa5;
}

.export-stat-label{
    color:#4b5563;
    font-weight:700;
    line-height:1.2;
}

.export-form-grid{
    display:grid;
    grid-template-columns:1.3fr .8fr .8fr .8fr;
    gap:14px;
    align-items:end;
}

.export-label{
    font-weight:700;
    color:#1f2a37;
    margin-bottom:.35rem;
}

.export-help{
    color:#6b7280;
    font-size:.9rem;
    line-height:1.35;
}

.export-actions{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    justify-content:flex-end;
    align-items:center;
}

.export-note{
    background:#f8fafc;
    border:1px solid #dfe7f2;
    border-radius:16px;
    padding:.9rem 1rem;
    color:#4b5563;
    line-height:1.45;
}

.admin-back-btn{
    width:auto !important;
    height:44px !important;
    min-height:44px !important;
    padding:0 14px !important;
    border-radius:14px !important;
    font-size:1rem !important;
    line-height:1 !important;
}

@media (max-width: 991.98px){
    .export-grid,
    .export-form-grid{
        grid-template-columns:1fr;
    }

    .export-actions{
        justify-content:stretch;
    }

    .export-actions .btn{
        width:100%;
    }
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5">
    <div class="container-fluid export-shell">

        <?php if($error_export !== ''){ ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error:</strong> <?= h($error_export) ?>
            </div>
        <?php } ?>

        <div class="export-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <div class="export-title">Exportar Bitácoras</div>
                    <div class="export-subtle">Descarga completa o filtrada por fechas de las bitácoras de becados, internos y residentes de otras especialidades.</div>
                </div>

            </div>
        </div>

        <div class="export-grid mb-3">
            <div class="export-stat">
                <div class="export-stat-num"><?= (int)$resumen_export['becados'] ?></div>
                <div class="export-stat-label">Becados / residentes Anestesiología</div>
            </div>
            <div class="export-stat">
                <div class="export-stat-num"><?= (int)$resumen_export['internos'] ?></div>
                <div class="export-stat-label">Internos</div>
            </div>
            <div class="export-stat">
                <div class="export-stat-num"><?= (int)$resumen_export['otras_especialidades'] ?></div>
                <div class="export-stat-label">Residentes otras especialidades</div>
            </div>
            <div class="export-stat">
                <div class="export-stat-num"><?= (int)$resumen_export['internos_y_otras'] ?></div>
                <div class="export-stat-label">Total bitácora internos/pasantes</div>
            </div>
        </div>

        <div class="export-card">
            <form method="get">
                <input type="hidden" name="accion" value="exportar">

                <div class="export-form-grid">
                    <div>
                        <label class="export-label" for="tipo">Datos a exportar</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="todas" <?= $tipo === 'todas' ? 'selected' : '' ?>>Todas las bitácoras</option>
                            <option value="becados" <?= $tipo === 'becados' ? 'selected' : '' ?>>Becados / residentes Anestesiología</option>
                            <option value="internos" <?= $tipo === 'internos' ? 'selected' : '' ?>>Internos</option>
                            <option value="otras_especialidades" <?= $tipo === 'otras_especialidades' ? 'selected' : '' ?>>Residentes de otras especialidades</option>
                            <option value="internos_y_otras" <?= $tipo === 'internos_y_otras' ? 'selected' : '' ?>>Internos + residentes otras especialidades</option>
                        </select>
                    </div>

                    <div>
                        <label class="export-label" for="desde">Desde</label>
                        <input type="date" class="form-control" id="desde" name="desde" value="<?= h($desde) ?>">
                    </div>

                    <div>
                        <label class="export-label" for="hasta">Hasta</label>
                        <input type="date" class="form-control" id="hasta" name="hasta" value="<?= h($hasta) ?>">
                    </div>

                    <div>
                        <label class="export-label" for="formato">Formato</label>
                        <select class="form-select" id="formato" name="formato">
                            <option value="csv" <?= $formato === 'csv' ? 'selected' : '' ?>>CSV / Excel</option>
                            <option value="xls" <?= $formato === 'xls' ? 'selected' : '' ?>>Excel .xls</option>
                            <option value="json" <?= $formato === 'json' ? 'selected' : '' ?>>JSON</option>
                            <option value="sql" <?= $formato === 'sql' ? 'selected' : '' ?>>SQL</option>
                        </select>
                    </div>
                </div>

                <div class="export-note mt-3">
                    <strong>Rango de fechas:</strong> si dejas ambos campos vacíos, se exporta todo el histórico. El filtro usa <code>fecha_b</code> para becados/residentes y <code>fecha_i</code> para internos/residentes de otras especialidades.
                </div>

                <div class="export-actions mt-3">
                    <a href="admin_exportar_bitacoras.php" class="btn btn-outline-secondary">
                        Limpiar filtros
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-file-export me-1"></i> Exportar
                    </button>
                </div>
            </form>
        </div>

        <div class="export-card">
            <div class="export-title mb-2">Formatos disponibles</div>
            <div class="row g-3">
                <div class="col-12 col-md-3"><div class="export-note h-100"><strong>CSV</strong><br>Recomendado para Excel, Google Sheets y análisis rápido.</div></div>
                <div class="col-12 col-md-3"><div class="export-note h-100"><strong>XLS</strong><br>Archivo compatible con Excel sin librerías externas.</div></div>
                <div class="col-12 col-md-3"><div class="export-note h-100"><strong>JSON</strong><br>Útil para respaldos legibles por sistemas y futuras migraciones.</div></div>
                <div class="col-12 col-md-3"><div class="export-note h-100"><strong>SQL</strong><br>Genera sentencias INSERT con los datos crudos de las tablas.</div></div>
            </div>
        </div>

    </div>
</div>

<?php
require('footer.php');
?>
