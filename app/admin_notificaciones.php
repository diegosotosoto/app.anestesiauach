<?php
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
    exit;
}

// Conexión
require("conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8mb4");

// Chequea privilegios de administrador
$check_usuario = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

$stmt_admin = $conexion->prepare("
    SELECT `ID`, `admin`, `nombre_usuario`, `email_usuario`
    FROM `usuarios_dolor`
    WHERE `email_usuario` = ?
    LIMIT 1
");

if(!$stmt_admin){
    die("Error preparando consulta de usuario.");
}

$stmt_admin->bind_param("s", $check_usuario);
$stmt_admin->execute();

$usuario_actual = null;

if(method_exists($stmt_admin, 'get_result')){
    $res_admin = $stmt_admin->get_result();
    $usuario_actual = $res_admin->fetch_assoc();
}else{
    $stmt_admin->bind_result($id_tmp, $admin_tmp, $nombre_tmp, $email_tmp);
    if($stmt_admin->fetch()){
        $usuario_actual = [
            'ID' => $id_tmp,
            'admin' => $admin_tmp,
            'nombre_usuario' => $nombre_tmp,
            'email_usuario' => $email_tmp
        ];
    }
}

$stmt_admin->close();

if(!$usuario_actual || (int)$usuario_actual['admin'] !== 1){
    header('Location: login.php');
    exit;
}

$usuario_id_actual = (int)$usuario_actual['ID'];

// Variables navbar
$boton_toggler = "<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='--bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Notificaciones</span>";
$boton_navbar = "<a></a><a></a>";

// Carga Head de la página
require("head.php");

function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function h_usuario($v){
    return htmlspecialchars(
        html_entity_decode((string)$v, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        ENT_QUOTES,
        'UTF-8'
    );
}

function datetime_local_to_sql($value){
    $value = trim((string)$value);
    if($value === ''){
        return null;
    }
    $value = str_replace('T', ' ', $value);
    if(strlen($value) === 16){
        $value .= ':00';
    }
    return $value;
}

$mensaje = "";
$error = "";

/*
|--------------------------------------------------------------------------
| Grupos disponibles
|--------------------------------------------------------------------------
*/
$grupos_disponibles = [
    'admin' => 'Admins',
    'staff_' => 'Staff',
    'becad_' => 'Becad@ Anestesia',
    'becad_otro' => 'Becad@ Pasante',
    'intern_' => 'Internos',
    'todos_alumnos' => 'Todos los alumnos',
    'todos_verificados' => 'Todos los verificados'
];

/*
|--------------------------------------------------------------------------
| Acciones rápidas
|--------------------------------------------------------------------------
*/
if(isset($_POST['accion_admin']) && $_POST['accion_admin'] !== ''){
    $accion_admin = trim($_POST['accion_admin']);
    $notificacion_id_accion = isset($_POST['notificacion_id']) ? (int)$_POST['notificacion_id'] : 0;

    if($notificacion_id_accion <= 0){
        $error = "Notificación inválida.";
    }else{
        if($accion_admin === 'toggle_publicada'){
            $stmt = $conexion->prepare("
                UPDATE `notificaciones`
                SET `publicada` = IF(`publicada` = 1, 0, 1),
                    `updated_at` = NOW()
                WHERE `id` = ?
            ");

            if($stmt){
                $stmt->bind_param("i", $notificacion_id_accion);
                if($stmt->execute()){
                    $mensaje = "Estado de publicación actualizado.";
                }else{
                    $error = "No se pudo actualizar el estado.";
                }
                $stmt->close();
            }else{
                $error = "Error preparando la actualización.";
            }
        }

        if($accion_admin === 'eliminar'){
            $stmt = $conexion->prepare("DELETE FROM `notificaciones` WHERE `id` = ?");

            if($stmt){
                $stmt->bind_param("i", $notificacion_id_accion);
                if($stmt->execute()){
                    $mensaje = "Notificación eliminada.";
                }else{
                    $error = "No se pudo eliminar la notificación.";
                }
                $stmt->close();
            }else{
                $error = "Error preparando la eliminación.";
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| Crear notificación
|--------------------------------------------------------------------------
*/
if(isset($_POST['crear_notificacion']) && $_POST['crear_notificacion'] === '1'){
    $titulo = trim($_POST['titulo'] ?? '');
    $mensaje_notif = trim($_POST['mensaje'] ?? '');
    $tipo = trim($_POST['tipo'] ?? 'info');
    $alcance = trim($_POST['alcance'] ?? 'global');
    $url_destino = trim($_POST['url_destino'] ?? '');
    $icono = trim($_POST['icono'] ?? '');
    $fecha_inicio = datetime_local_to_sql($_POST['fecha_inicio'] ?? '');
    $fecha_fin = datetime_local_to_sql($_POST['fecha_fin'] ?? '');
    $publicada = isset($_POST['publicada']) ? 1 : 0;
    $usuario_individual = isset($_POST['usuario_id']) ? (int)$_POST['usuario_id'] : 0;
    $grupo = trim($_POST['grupo'] ?? '');

    $tipos_validos = ['info','warning','success','urgent'];
    $alcances_validos = ['individual','grupo','global'];

    if($titulo === '' || $mensaje_notif === ''){
        $error = "Título y mensaje son obligatorios.";
    }elseif(!in_array($tipo, $tipos_validos, true)){
        $error = "Tipo inválido.";
    }elseif(!in_array($alcance, $alcances_validos, true)){
        $error = "Alcance inválido.";
    }elseif($alcance === 'individual' && $usuario_individual <= 0){
        $error = "Debes seleccionar un usuario.";
    }elseif($alcance === 'grupo' && !array_key_exists($grupo, $grupos_disponibles)){
        $error = "Debes seleccionar un grupo válido.";
    }elseif($fecha_inicio !== null && $fecha_fin !== null && $fecha_fin <= $fecha_inicio){
        $error = "La fecha de término debe ser mayor que la fecha de inicio.";
    }else{

        if($fecha_inicio === null){
            $fecha_inicio = date('Y-m-d H:i:s');
        }

        $conexion->begin_transaction();

        try{
            $grupo_sql = ($alcance === 'grupo') ? $grupo : null;

            $stmt_notif = $conexion->prepare("
                INSERT INTO `notificaciones`
                (`titulo`,`mensaje`,`tipo`,`alcance`,`grupo_destino`,`url_destino`,`icono`,`creada_por`,`publicada`,`fecha_inicio`,`fecha_fin`)
                VALUES
                (?,?,?,?,?,?,?,?,?,?,?)
            ");

            if(!$stmt_notif){
                throw new Exception("Error preparando la notificación.");
            }

            $stmt_notif->bind_param(
                "sssssssiiss",
                $titulo,
                $mensaje_notif,
                $tipo,
                $alcance,
                $grupo_sql,
                $url_destino,
                $icono,
                $usuario_id_actual,
                $publicada,
                $fecha_inicio,
                $fecha_fin
            );

            if(!$stmt_notif->execute()){
                throw new Exception("Error creando la notificación.");
            }

            $notificacion_id = (int)$stmt_notif->insert_id;
            $stmt_notif->close();

            // Individual
            if($alcance === 'individual'){
                $stmt_dest = $conexion->prepare("
                    INSERT INTO `notificacion_destinatarios` (`notificacion_id`,`usuario_id`)
                    VALUES (?,?)
                ");

                if(!$stmt_dest){
                    throw new Exception("Error preparando destinatario individual.");
                }

                $stmt_dest->bind_param("ii", $notificacion_id, $usuario_individual);

                if(!$stmt_dest->execute()){
                    throw new Exception("Error asignando destinatario individual.");
                }

                $stmt_dest->close();
            }

            // Global
            if($alcance === 'global'){
                $sql_global = "
                    INSERT INTO `notificacion_destinatarios` (`notificacion_id`,`usuario_id`)
                    SELECT ?, `ID`
                    FROM `usuarios_dolor`
                    WHERE `verified` = 1
                ";

                $stmt_global = $conexion->prepare($sql_global);

                if(!$stmt_global){
                    throw new Exception("Error preparando destinatarios globales.");
                }

                $stmt_global->bind_param("i", $notificacion_id);

                if(!$stmt_global->execute()){
                    throw new Exception("Error asignando destinatarios globales.");
                }

                $stmt_global->close();
            }

            // Grupo
            if($alcance === 'grupo'){
                $where_grupo = "";

                switch($grupo){
                    case 'admin':
                        $where_grupo = "`verified` = 1 AND `admin` = 1";
                        break;
                    case 'staff_':
                        $where_grupo = "`verified` = 1 AND `staff_` = 1";
                        break;
                    case 'becad_':
                        $where_grupo = "`verified` = 1 AND `becad_` = 1";
                        break;
                    case 'becad_otro':
                        $where_grupo = "`verified` = 1 AND `becad_otro` = 1";
                        break;
                    case 'intern_':
                        $where_grupo = "`verified` = 1 AND `intern_` = 1";
                        break;
                    case 'todos_alumnos':
                        $where_grupo = "`verified` = 1 AND (`becad_` = 1 OR `becad_otro` = 1 OR `intern_` = 1)";
                        break;
                    case 'todos_verificados':
                        $where_grupo = "`verified` = 1";
                        break;
                    default:
                        throw new Exception("Grupo inválido.");
                }

                $sql_grupo = "
                    INSERT INTO `notificacion_destinatarios` (`notificacion_id`,`usuario_id`)
                    SELECT ?, `ID`
                    FROM `usuarios_dolor`
                    WHERE $where_grupo
                ";

                $stmt_grupo = $conexion->prepare($sql_grupo);

                if(!$stmt_grupo){
                    throw new Exception("Error preparando destinatarios por grupo.");
                }

                $stmt_grupo->bind_param("i", $notificacion_id);

                if(!$stmt_grupo->execute()){
                    throw new Exception("Error asignando destinatarios por grupo.");
                }

                $stmt_grupo->close();
            }

            $conexion->commit();
            $mensaje = "Notificación creada correctamente.";

        }catch(Throwable $e){
            $conexion->rollback();
            $error = "Error al crear la notificación: " . $e->getMessage();
        }
    }
}

/*
|--------------------------------------------------------------------------
| Usuarios para selector individual
|--------------------------------------------------------------------------
*/
$usuarios = [];
$res_usuarios = $conexion->query("
    SELECT `ID`,`nombre_usuario`,`email_usuario`,`admin`,`staff_`,`intern_`,`becad_`,`becad_otro`
    FROM `usuarios_dolor`
    WHERE `verified` = 1
    ORDER BY `nombre_usuario` ASC
");

if($res_usuarios){
    while($row = $res_usuarios->fetch_assoc()){
        $usuarios[] = $row;
    }
}

/*
|--------------------------------------------------------------------------
| Listado de notificaciones
|--------------------------------------------------------------------------
|
| Para alcance individual, el destinatario se obtiene desde
| notificacion_destinatarios / usuarios_dolor.
|
*/
$notificaciones = [];

$sql_listado = "
    SELECT
        n.`id`,
        n.`titulo`,
        n.`mensaje`,
        n.`tipo`,
        n.`alcance`,
        n.`grupo_destino`,
        n.`url_destino`,
        n.`icono`,
        n.`publicada`,
        n.`fecha_inicio`,
        n.`fecha_fin`,
        n.`created_at`,
        ud.`nombre_usuario` AS creador,

        COUNT(nd.`id`) AS total_destinatarios,
        SUM(CASE WHEN nd.`leida` = 1 THEN 1 ELSE 0 END) AS total_leidas,

        MIN(CASE WHEN n.`alcance` = 'individual' THEN ud_ind.`nombre_usuario` ELSE NULL END) AS usuario_destino_nombre,
        MIN(CASE WHEN n.`alcance` = 'individual' THEN ud_ind.`email_usuario` ELSE NULL END) AS usuario_destino_email

    FROM `notificaciones` n
    LEFT JOIN `notificacion_destinatarios` nd
        ON nd.`notificacion_id` = n.`id`
    LEFT JOIN `usuarios_dolor` ud
        ON ud.`ID` = n.`creada_por`
    LEFT JOIN `usuarios_dolor` ud_ind
        ON ud_ind.`ID` = nd.`usuario_id`

    GROUP BY
        n.`id`, n.`titulo`, n.`mensaje`, n.`tipo`, n.`alcance`, n.`grupo_destino`,
        n.`url_destino`, n.`icono`, n.`publicada`, n.`fecha_inicio`, n.`fecha_fin`,
        n.`created_at`, ud.`nombre_usuario`

    ORDER BY n.`id` DESC
";

$res_listado = $conexion->query($sql_listado);

if($res_listado){
    while($row = $res_listado->fetch_assoc()){
        $notificaciones[] = $row;
    }
}
?>

<style>
.admin-card{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:16px;
    margin-bottom:14px;
}

.admin-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
    align-items:start;
}

.admin-full{
    grid-column:1 / -1;
}

.admin-label{
    display:block;
    font-weight:700;
    margin-bottom:6px;
}

.admin-input, .admin-select, .admin-textarea{
    width:100%;
    box-sizing:border-box;
    padding:11px 12px;
    border:1px solid #d1d5db;
    border-radius:10px;
    font-size:14px;
    max-width:100%;
}

.admin-textarea{
    min-height:120px;
    resize:vertical;
}

.admin-actions{
    margin-top:18px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.badge-notif{
    display:inline-block;
    padding:.25rem .55rem;
    border-radius:999px;
    font-size:.78rem;
    font-weight:700;
    margin-right:6px;
}

.badge-info{ background:#dbeafe; color:#1d4ed8; }
.badge-warning{ background:#fef3c7; color:#92400e; }
.badge-success{ background:#dcfce7; color:#166534; }
.badge-urgent{ background:#fee2e2; color:#b91c1c; }
.badge-pub{ background:#dcfce7; color:#166534; }
.badge-nopub{ background:#e5e7eb; color:#374151; }

.admin-muted{ color:#6b7280; }
.hidden{ display:none; }

.admin-btn-inline{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
    margin-top:12px;
}

.usuario-resultados{
    max-height:260px;
    overflow-y:auto;
    border:1px solid #d1d5db;
    border-radius:12px;
    background:#fff;
}

.usuario-resultado-item{
    display:block;
    width:100%;
    text-align:left;
    padding:10px 12px;
    border:0;
    border-bottom:1px solid #edf1f5;
    background:#fff;
    font-size:14px;
    color:#1f2937;
    cursor:pointer;
}

.usuario-resultado-item:last-child{
    border-bottom:0;
}

.usuario-resultado-item:hover,
.usuario-resultado-item.activo{
    background:#eef4ff;
}

.usuario-resultado-item.oculto{
    display:none;
}

.icon-picker-grid{
    display:grid;
    grid-template-columns:repeat(6, minmax(0, 1fr));
    gap:10px;
}

.icon-picker-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    height:54px;
    width:100%;
    border:1px solid #d1d5db;
    border-radius:12px;
    background:#fff;
    font-size:22px;
    color:#334155;
    cursor:pointer;
    transition:.15s ease;
    padding:0;
}

.icon-picker-btn:hover{
    background:#eef4ff;
    border-color:#93c5fd;
    color:#1d4ed8;
}

.icon-picker-btn.activo{
    background:#dbeafe;
    border-color:#3b82f6;
    color:#1d4ed8;
    box-shadow:0 0 0 2px rgba(59,130,246,.12);
}

@media (max-width: 991.98px){
    .admin-grid{
        grid-template-columns:1fr;
    }

    .admin-full{
        grid-column:auto;
    }

    .admin-card{
        padding:14px;
    }

    .admin-input, .admin-select, .admin-textarea{
        font-size:16px;
    }

    .icon-picker-grid{
        grid-template-columns:repeat(4, minmax(0, 1fr));
    }

    .icon-picker-btn{
        height:56px;
        font-size:24px;
    }
}

@media (max-width: 575.98px){
    .admin-card{
        padding:12px;
        border-radius:12px;
    }

    .admin-grid{
        gap:14px;
    }

    .icon-picker-grid{
        grid-template-columns:repeat(4, minmax(0, 1fr));
        gap:8px;
    }

    .icon-picker-btn{
        height:52px;
        font-size:22px;
        border-radius:10px;
    }

    .usuario-resultados{
        max-height:220px;
    }
}
</style>

<div class="col col-sm-9 col-xl-9">
    <div class="container-fluid pt-3 pb-4">

        <?php if($mensaje != ""){ ?>
            <div class='alert alert-success alert-dismissible fade show'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Info!</strong> <?= h($mensaje) ?>
            </div>
        <?php } ?>

        <?php if($error != ""){ ?>
            <div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Error:</strong> <?= h($error) ?>
            </div>
        <?php } ?>

        <div class="admin-card">
            <h3 class="mb-2">Administrador de Notificaciones</h3>
            <div class="admin-muted mb-3">
                Usuario actual: <strong><?= h_usuario($usuario_actual['nombre_usuario']) ?></strong> (<?= h($usuario_actual['email_usuario']) ?>)
            </div>

            <form method="post" id="formNotificacion">
                <input type="hidden" name="crear_notificacion" value="1">

                <div class="admin-grid">
                    <div>
                        <label class="admin-label">Título</label>
                        <input class="admin-input" type="text" name="titulo" required>
                    </div>

                    <div>
                        <label class="admin-label">Tipo</label>
                        <select class="admin-select" name="tipo">
                            <option value="info">Info</option>
                            <option value="warning">Warning</option>
                            <option value="success">Success</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>

                    <div class="admin-full">
                        <label class="admin-label">Mensaje</label>
                        <textarea class="admin-textarea" name="mensaje" required></textarea>
                    </div>

                    <div>
                        <label class="admin-label">Alcance</label>
                        <select class="admin-select" name="alcance" id="alcanceSelect">
                            <option value="global">Global</option>
                            <option value="grupo">Grupo</option>
                            <option value="individual">Individual</option>
                        </select>
                    </div>

                    <div id="grupoWrap" class="hidden">
                        <label class="admin-label">Grupo</label>
                        <select class="admin-select" name="grupo">
                            <option value="">Selecciona un grupo</option>
                            <?php foreach($grupos_disponibles as $key => $label){ ?>
                                <option value="<?= h($key) ?>"><?= h($label) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div id="usuarioWrap" class="hidden">
                        <label class="admin-label">Usuario individual</label>

                        <input type="hidden" name="usuario_id" id="usuario_id_hidden" value="0">

                        <input
                            type="text"
                            id="usuarioSearch"
                            class="admin-input"
                            placeholder="Escribe nombre o correo..."
                            autocomplete="off"
                        >

                        <div id="usuarioSeleccionado" class="admin-muted mt-2" style="display:none;"></div>

                        <div id="usuarioResultados" class="usuario-resultados mt-2">
                            <?php foreach($usuarios as $u){ ?>
                                <?php
                                    $nombre_usuario_limpio = html_entity_decode((string)$u['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                    $email_usuario_limpio = (string)$u['email_usuario'];
                                ?>
                                <button
                                    type="button"
                                    class="usuario-resultado-item"
                                    data-id="<?= (int)$u['ID'] ?>"
                                    data-nombre="<?= htmlspecialchars(mb_strtolower($nombre_usuario_limpio, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>"
                                    data-email="<?= htmlspecialchars(mb_strtolower($email_usuario_limpio, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>"
                                    data-label="<?= htmlspecialchars($nombre_usuario_limpio . ' (' . $email_usuario_limpio . ')', ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    <?= h_usuario($u['nombre_usuario']) ?> (<?= h($u['email_usuario']) ?>)
                                </button>
                            <?php } ?>
                        </div>
                    </div>

                    <div>
                        <label class="admin-label">URL destino</label>
                        <input class="admin-input" type="text" name="url_destino" placeholder="ej: apuntes.php o apuntes/hiperkalemia.php">
                    </div>

<div class="admin-full">
    <label class="admin-label">Ícono sugerido</label>

    <input type="hidden" name="icono" id="iconoSeleccionado" value="fa-solid fa-bell">

    <div class="icon-picker-grid">
        <button type="button" class="icon-picker-btn activo" data-icono="fa-solid fa-bell" title="Aviso general">
            <i class="fa-solid fa-bell"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-triangle-exclamation" title="Warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-file-pen" title="Examen o prueba">
            <i class="fa-solid fa-file-pen"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-clipboard-check" title="Evaluación">
            <i class="fa-solid fa-clipboard-check"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-chalkboard-user" title="Clase">
            <i class="fa-solid fa-chalkboard-user"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-users" title="Reunión docente">
            <i class="fa-solid fa-users"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-mobile-screen-button" title="App o sistema">
            <i class="fa-solid fa-mobile-screen-button"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-book-medical" title="Apuntes o contenido">
            <i class="fa-solid fa-book-medical"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-clipboard" title="Bitácora o registro">
            <i class="fa-solid fa-clipboard"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-envelope" title="Mensaje o correo">
            <i class="fa-solid fa-envelope"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-calendar-days" title="Calendario o fecha">
            <i class="fa-solid fa-calendar-days"></i>
        </button>

        <button type="button" class="icon-picker-btn" data-icono="fa-solid fa-circle-info" title="Información">
            <i class="fa-solid fa-circle-info"></i>
        </button>
    </div>

    <div class="admin-muted mt-2">
        Ícono seleccionado: <span id="iconoTextoSeleccionado">fa-solid fa-bell</span>
    </div>
</div>



<div>
    <label class="admin-label">Fecha inicio</label>
    <input class="admin-input" type="datetime-local" name="fecha_inicio">
</div>

<div>
    <label class="admin-label">Fecha fin</label>
    <input class="admin-input" type="datetime-local" name="fecha_fin">
</div>


                    <div class="admin-full">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="publicada" id="publicada" checked>
                            <label class="form-check-label" for="publicada">Publicada inmediatamente</label>
                        </div>
                    </div>
                </div>

                <div class="admin-actions">
                    <button class="btn btn-primary" type="submit">Crear notificación</button>
                </div>
            </form>
        </div>

        <div class="admin-card">
            <h4 class="mb-3">Notificaciones existentes</h4>

            <?php if(empty($notificaciones)){ ?>
                <div class="admin-muted">No hay notificaciones creadas aún.</div>
            <?php } ?>

            <?php foreach($notificaciones as $n){ ?>
                <div class="border rounded p-3 mb-3 bg-light">
                    <h5 class="mb-2"><?= h($n['titulo']) ?></h5>

                    <div class="mb-2">
                        <span class="badge-notif badge-<?= h($n['tipo']) ?>"><?= h(strtoupper($n['tipo'])) ?></span>
                        <span class="badge-notif <?= ((int)$n['publicada'] === 1 ? 'badge-pub' : 'badge-nopub') ?>">
                            <?= ((int)$n['publicada'] === 1 ? 'PUBLICADA' : 'OCULTA') ?>
                        </span>
                    </div>

                    <div class="mb-2" style="white-space:pre-wrap;"><?= h($n['mensaje']) ?></div>

                    <div class="admin-muted">
                        <strong>Alcance:</strong> <?= h($n['alcance']) ?><br>

                        <?php if($n['alcance'] === 'grupo'){ ?>
                            <strong>Grupo:</strong>
                            <?= (!empty($n['grupo_destino']) && isset($grupos_disponibles[$n['grupo_destino']]))
                                ? h($grupos_disponibles[$n['grupo_destino']])
                                : (!empty($n['grupo_destino']) ? h($n['grupo_destino']) : '—') ?>
                            <br>
                        <?php } ?>

                        <?php if($n['alcance'] === 'individual'){ ?>
                            <strong>Usuario destino:</strong>
                            <?= !empty($n['usuario_destino_nombre'])
                                ? h_usuario($n['usuario_destino_nombre']) . (!empty($n['usuario_destino_email']) ? ' (' . h($n['usuario_destino_email']) . ')' : '')
                                : '—' ?>
                            <br>
                        <?php } ?>

                        <?php if($n['alcance'] === 'global'){ ?>
                            <strong>Destino lógico:</strong> Todos los verificados<br>
                        <?php } ?>

                        <strong>URL destino:</strong> <?= ($n['url_destino'] ? h($n['url_destino']) : '—') ?><br>
                        <strong>Icono:</strong> <?= ($n['icono'] ? h($n['icono']) : '—') ?><br>
                        <strong>Inicio:</strong> <?= h($n['fecha_inicio']) ?><br>
                        <strong>Fin:</strong> <?= ($n['fecha_fin'] ? h($n['fecha_fin']) : 'Sin término') ?><br>
                        <strong>Creada por:</strong> <?= ($n['creador'] ? h_usuario($n['creador']) : '—') ?><br>
                        <strong>Destinatarios:</strong> <?= (int)$n['total_destinatarios'] ?><br>
                        <strong>Leídas:</strong> <?= (int)$n['total_leidas'] ?><br>
                        <strong>Creada:</strong> <?= h($n['created_at']) ?>
                    </div>

                    <div class="admin-btn-inline">
                        <form method="post" class="d-inline">
                            <input type="hidden" name="accion_admin" value="toggle_publicada">
                            <input type="hidden" name="notificacion_id" value="<?= (int)$n['id'] ?>">
                            <button type="submit" class="btn btn-warning">
                                <?= ((int)$n['publicada'] === 1 ? 'Despublicar' : 'Publicar') ?>
                            </button>
                        </form>

                        <form method="post" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta notificación?');">
                            <input type="hidden" name="accion_admin" value="eliminar">
                            <input type="hidden" name="notificacion_id" value="<?= (int)$n['id'] ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>

<script>
const alcanceSelect = document.getElementById('alcanceSelect');
const grupoWrap = document.getElementById('grupoWrap');
const usuarioWrap = document.getElementById('usuarioWrap');

function actualizarCamposAlcance() {
    const alcance = alcanceSelect.value;

    grupoWrap.classList.add('hidden');
    usuarioWrap.classList.add('hidden');

    if (alcance === 'grupo') {
        grupoWrap.classList.remove('hidden');
    }

    if (alcance === 'individual') {
        usuarioWrap.classList.remove('hidden');
    }
}

alcanceSelect.addEventListener('change', actualizarCamposAlcance);
actualizarCamposAlcance();

const usuarioSearch = document.getElementById('usuarioSearch');
const usuarioResultados = document.getElementById('usuarioResultados');
const usuarioIdHidden = document.getElementById('usuario_id_hidden');
const usuarioSeleccionado = document.getElementById('usuarioSeleccionado');

function limpiarSeleccionUsuario() {
    if (!usuarioIdHidden || !usuarioSeleccionado) return;
    usuarioIdHidden.value = 0;
    usuarioSeleccionado.style.display = 'none';
    usuarioSeleccionado.textContent = '';
}

function filtrarUsuarios() {
    if (!usuarioSearch || !usuarioResultados) return;

    const texto = usuarioSearch.value.trim().toLowerCase();
    const items = usuarioResultados.querySelectorAll('.usuario-resultado-item');

    items.forEach(item => {
        const nombre = item.dataset.nombre || '';
        const email = item.dataset.email || '';
        const coincide = texto === '' || nombre.includes(texto) || email.includes(texto);

        if (coincide) {
            item.classList.remove('oculto');
        } else {
            item.classList.add('oculto');
        }
    });
}

if (usuarioSearch) {
    usuarioSearch.addEventListener('input', function() {
        limpiarSeleccionUsuario();
        filtrarUsuarios();
    });
}

if (usuarioResultados) {
    usuarioResultados.addEventListener('click', function(e) {
        const item = e.target.closest('.usuario-resultado-item');
        if (!item) return;

        const id = item.dataset.id || '0';
        const label = item.dataset.label || '';

        if (usuarioIdHidden) {
            usuarioIdHidden.value = id;
        }

        if (usuarioSearch) {
            usuarioSearch.value = label;
        }

        if (usuarioSeleccionado) {
            usuarioSeleccionado.textContent = 'Seleccionado: ' + label;
            usuarioSeleccionado.style.display = 'block';
        }

        usuarioResultados.querySelectorAll('.usuario-resultado-item').forEach(btn => {
            btn.classList.remove('activo');
        });
        item.classList.add('activo');
    });
}
</script>
<script>
const iconoSeleccionado = document.getElementById('iconoSeleccionado');
const iconoTextoSeleccionado = document.getElementById('iconoTextoSeleccionado');

document.querySelectorAll('.icon-picker-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const icono = this.dataset.icono || '';

        if (iconoSeleccionado) {
            iconoSeleccionado.value = icono;
        }

        if (iconoTextoSeleccionado) {
            iconoTextoSeleccionado.textContent = icono;
        }

        document.querySelectorAll('.icon-picker-btn').forEach(b => b.classList.remove('activo'));
        this.classList.add('activo');
    });
});
</script>

<?php
require("footer.php");
?>