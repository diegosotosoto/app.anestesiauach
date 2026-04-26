<?php
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
    exit;
}

require('conectar.php');
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function post_val($key, $default = ''){
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

$check_usuario = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);
$stmt_admin = $conexion->prepare("SELECT `ID`, `admin`, `nombre_usuario`, `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
if(!$stmt_admin){
    die('Error preparando consulta de usuario.');
}
$stmt_admin->bind_param('s', $check_usuario);
$stmt_admin->execute();

$usuario_admin = null;
if(method_exists($stmt_admin, 'get_result')){
    $res_admin = $stmt_admin->get_result();
    $usuario_admin = $res_admin->fetch_assoc();
}else{
    $stmt_admin->bind_result($id_tmp, $admin_tmp, $nombre_tmp, $email_tmp);
    if($stmt_admin->fetch()){
        $usuario_admin = array(
            'ID' => $id_tmp,
            'admin' => $admin_tmp,
            'nombre_usuario' => $nombre_tmp,
            'email_usuario' => $email_tmp
        );
    }
}
$stmt_admin->close();

if(!$usuario_admin || (int)$usuario_admin['admin'] !== 1){
    header('Location: login.php');
    exit;
}

$mensaje_ok = '';
$mensaje_error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $accion = post_val('accion');

    if($accion === 'guardar_usuario'){
        $email_init = strtolower(post_val('email_init'));
        $nombre_us = post_val('nombre_usuario');
        $email_us = strtolower(post_val('email_usuario'));
        $link_minicex = post_val('link_minicex');
        $anio_residencia_raw = post_val('anio_residencia');
        $anio_residencia = in_array($anio_residencia_raw, array('1','2','3'), true) ? (int)$anio_residencia_raw : null;

        $verified_us = isset($_POST['verified']) ? 1 : 0;
        $admin_us = isset($_POST['admin']) ? 1 : 0;
        $staff_us = isset($_POST['staff']) ? 1 : 0;
        $becad_us = isset($_POST['becad']) ? 1 : 0;
        $intern_us = isset($_POST['intern']) ? 1 : 0;
        $becad_otro_us = isset($_POST['becad_otro']) ? 1 : 0;

        if($email_init === '' || $email_us === '' || $nombre_us === ''){
            $mensaje_error = 'Faltan datos obligatorios para guardar el usuario.';
        }elseif(!filter_var($email_us, FILTER_VALIDATE_EMAIL)){
            $mensaje_error = 'El correo ingresado no tiene un formato válido.';
        }else{
            $stmt_update = $conexion->prepare("UPDATE `usuarios_dolor`
                SET `nombre_usuario` = ?,
                    `email_usuario` = ?,
                    `verified` = ?,
                    `admin` = ?,
                    `staff_` = ?,
                    `becad_` = ?,
                    `becad_otro` = ?,
                    `intern_` = ?,
                    `link_minicex` = ?,
                    `anio_residencia` = ?
                WHERE `email_usuario` = ?
                LIMIT 1");

            if(!$stmt_update){
                $mensaje_error = 'Error preparando el guardado: ' . $conexion->error;
            }else{
                $stmt_update->bind_param(
                    'ssiiiiiisis',
                    $nombre_us,
                    $email_us,
                    $verified_us,
                    $admin_us,
                    $staff_us,
                    $becad_us,
                    $becad_otro_us,
                    $intern_us,
                    $link_minicex,
                    $anio_residencia,
                    $email_init
                );

                if($stmt_update->execute()){
                    $mensaje_ok = 'Usuario guardado correctamente.';
                    if($email_init === $check_usuario && $email_us !== $check_usuario){
                        setcookie('hkjh41lu4l1k23jhlkj13', $email_us, time() + (86400 * 30), '/');
                        $check_usuario = $email_us;
                    }
                }else{
                    $mensaje_error = 'Error en el guardado. Contacta al administrador.';
                }
                $stmt_update->close();
            }
        }
    }

    if($accion === 'borrar_usuario'){
        $email_delete = strtolower(post_val('email_delete'));
        $confirm_delete = post_val('confirm_delete');

        if($email_delete === ''){
            $mensaje_error = 'No se recibió el usuario a borrar.';
        }elseif($email_delete === strtolower($check_usuario)){
            $mensaje_error = 'No puedes borrar tu propio usuario mientras estás logueado.';
        }elseif($confirm_delete !== 'CONFIRMAR'){
            $mensaje_error = 'La eliminación fue rechazada o no confirmada.';
        }else{
            $stmt_delete = $conexion->prepare("DELETE FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
            if(!$stmt_delete){
                $mensaje_error = 'Error preparando la eliminación: ' . $conexion->error;
            }else{
                $stmt_delete->bind_param('s', $email_delete);
                if($stmt_delete->execute()){
                    if($stmt_delete->affected_rows > 0){
                        $mensaje_ok = 'Usuario eliminado definitivamente de la base de datos.';
                    }else{
                        $mensaje_error = 'No se encontró el usuario solicitado.';
                    }
                }else{
                    $mensaje_error = 'No se pudo eliminar el usuario. Revisa si existen restricciones asociadas.';
                }
                $stmt_delete->close();
            }
        }
    }
}

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark admin-back-btn' style='--bs-border-opacity:.1;' href='index.php'><i class='fa fa-chevron-left me-1'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Gestión Usuarios</span>";
$boton_navbar = "<a></a><a></a>";

require('head.php');

$resumen = array(
    'total' => 0,
    'pendientes' => 0,
    'admins' => 0,
    'becados' => 0,
    'internos' => 0,
    'pasantes' => 0,
    'r1' => 0,
    'r2' => 0,
    'r3' => 0
);

$res_resumen = $conexion->query("SELECT
    COUNT(*) AS total,
    SUM(CASE WHEN `verified` = 0 THEN 1 ELSE 0 END) AS pendientes,
    SUM(CASE WHEN `admin` = 1 THEN 1 ELSE 0 END) AS admins,
    SUM(CASE WHEN `becad_` = 1 THEN 1 ELSE 0 END) AS becados,
    SUM(CASE WHEN `intern_` = 1 THEN 1 ELSE 0 END) AS internos,
    SUM(CASE WHEN `becad_otro` = 1 THEN 1 ELSE 0 END) AS pasantes,
    SUM(CASE WHEN `becad_` = 1 AND `anio_residencia` = 1 THEN 1 ELSE 0 END) AS r1,
    SUM(CASE WHEN `becad_` = 1 AND `anio_residencia` = 2 THEN 1 ELSE 0 END) AS r2,
    SUM(CASE WHEN `becad_` = 1 AND `anio_residencia` = 3 THEN 1 ELSE 0 END) AS r3
    FROM `usuarios_dolor`");

if($res_resumen){
    $row_resumen = $res_resumen->fetch_assoc();
    foreach($resumen as $k => $v){
        $resumen[$k] = isset($row_resumen[$k]) ? (int)$row_resumen[$k] : 0;
    }
}

$usuarios = array();
$con_users = "SELECT `ID`, `nombre_usuario`, `email_usuario`, `verified`, `admin`, `staff_`, `becad_`, `intern_`, `becad_otro`, `link_minicex`, `anio_residencia`
              FROM `usuarios_dolor`
              ORDER BY `verified` ASC, `nombre_usuario` ASC";
$tab_users = $conexion->query($con_users);
if($tab_users){
    while($row_user = $tab_users->fetch_assoc()){
        $usuarios[] = $row_user;
    }
}
?>

<style>
.user-shell{
    max-width:1100px;
    margin:0 auto;
}

.user-card{
    background:#fff;
    border:1px solid #dfe7f2;
    border-radius:18px;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    padding:1rem 1.1rem;
    margin-bottom:1rem;
}

.user-title{
    font-size:1.25rem;
    font-weight:800;
    color:#1f2a37;
}

.user-subtle{
    color:#6b7280;
    font-size:.92rem;
}

.user-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(135px, 1fr));
    gap:12px;
}

.user-stat{
    background:linear-gradient(0deg, #e9effb 0%, #ffffff 42%, #ffffff 100%);
    border:1px solid #dfe7f2;
    border-radius:16px;
    padding:1rem;
}

.user-stat-num{
    font-size:1.55rem;
    font-weight:800;
    color:#244aa5;
}

.user-stat-label{
    color:#4b5563;
    font-weight:700;
    line-height:1.2;
}

.user-search-card{
    display:flex;
    gap:12px;
    align-items:center;
}

.user-search-icon{
    width:44px;
    height:44px;
    border-radius:14px;
    background:#eef4ff;
    color:#2f63d8;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 44px;
}

.user-form-grid{
    display:grid;
    grid-template-columns:1.15fr 1.15fr 1fr;
    gap:12px;
    align-items:end;
}

.user-label{
    font-weight:700;
    color:#1f2a37;
    margin-bottom:.35rem;
}

.user-role-grid{
    display:grid;
    grid-template-columns:repeat(3, minmax(0, 1fr));
    gap:10px;
    margin-top:14px;
}

.user-check{
    display:flex;
    align-items:center;
    gap:8px;
    border:1px solid #dfe7f2;
    border-radius:14px;
    background:#f8fafc;
    padding:.72rem .85rem;
    font-weight:700;
    color:#344054;
}

.resident-year-wrap{
    display:none;
    margin-top:12px;
    border:1px solid #dfe7f2;
    border-radius:16px;
    background:#f8fafc;
    padding:.9rem 1rem;
}

.resident-year-wrap.is-visible{
    display:block;
}

.resident-year-inner{
    max-width:260px;
}


.user-actions{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    justify-content:flex-end;
    align-items:center;
    margin-top:14px;
}

.user-status-pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    border-radius:999px;
    padding:.28rem .65rem;
    font-size:.82rem;
    font-weight:800;
}

.user-status-ok{
    background:#e8f7ef;
    color:#087443;
}

.user-status-pending{
    background:#fff7e6;
    color:#9a6a00;
}

.user-delete-warning{
    background:#fff1f2;
    border:1px solid #fecdd3;
    color:#991b1b;
    border-radius:16px;
    padding:.9rem 1rem;
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
    .user-grid,
    .user-form-grid,
    .user-role-grid{
        grid-template-columns:1fr;
    }

    .user-actions{
        justify-content:stretch;
    }

    .user-actions .btn{
        width:100%;
    }
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5">
    <div class="container-fluid user-shell">

        <?php if($mensaje_error !== ''){ ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error:</strong> <?= h($mensaje_error) ?>
            </div>
        <?php } ?>

        <?php if($mensaje_ok !== ''){ ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Listo:</strong> <?= h($mensaje_ok) ?>
            </div>
        <?php } ?>

        <div class="user-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <div class="user-title">Gestión de Usuarios</div>
                    <div class="user-subtle">Administra permisos, verificación, roles, año de residencia y acceso de usuarios de la app.</div>
                </div>

            </div>
        </div>

        <div class="user-grid mb-3">
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['total'] ?></div>
                <div class="user-stat-label">Usuarios</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['pendientes'] ?></div>
                <div class="user-stat-label">Pendientes</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['admins'] ?></div>
                <div class="user-stat-label">Admins</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['becados'] ?></div>
                <div class="user-stat-label">Becados Anestesia</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['internos'] ?></div>
                <div class="user-stat-label">Internos</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['pasantes'] ?></div>
                <div class="user-stat-label">Pasantes</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['r1'] ?></div>
                <div class="user-stat-label">Residentes 1°</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['r2'] ?></div>
                <div class="user-stat-label">Residentes 2°</div>
            </div>
            <div class="user-stat">
                <div class="user-stat-num"><?= (int)$resumen['r3'] ?></div>
                <div class="user-stat-label">Residentes 3°</div>
            </div>
        </div>

        <div class="user-card user-search-card">
            <div class="user-search-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
            <input type="text" class="form-control" id="search" placeholder="Buscar por nombre o correo...">
        </div>

        <div id="mytable">
            <?php foreach($usuarios as $i => $row_user){
                $user = function_exists('app_decode_text') ? app_decode_text($row_user['nombre_usuario']) : (string)$row_user['nombre_usuario'];
                $email = (string)$row_user['email_usuario'];
                $link_minicex = (string)$row_user['link_minicex'];
                $anio_residencia = isset($row_user['anio_residencia']) ? (int)$row_user['anio_residencia'] : 0;
                $is_self = strtolower($email) === strtolower($check_usuario);
            ?>
                <div class="user-card user-item" data-search="<?= h(strtolower($user . ' ' . $email . ' r' . $anio_residencia . ' ' . $anio_residencia . ' año')) ?>">
                    <form action="gestion_usuarios.php" method="post">
                        <input type="hidden" name="accion" value="guardar_usuario">
                        <input type="hidden" name="email_init" value="<?= h($email) ?>">

                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div>
                                <span class="user-status-pill <?= ((int)$row_user['verified'] === 1 ? 'user-status-ok' : 'user-status-pending') ?>">
                                    <i class="fa-solid <?= ((int)$row_user['verified'] === 1 ? 'fa-circle-check' : 'fa-clock') ?>"></i>
                                    <?= ((int)$row_user['verified'] === 1 ? 'Verificado' : 'Pendiente') ?>
                                </span>
                            </div>
                            <div class="user-subtle">ID: <?= h($row_user['ID']) ?></div>
                        </div>

                        <div class="user-form-grid">
                            <div>
                                <label class="user-label" for="nombre_usuario<?= (int)$i ?>">Nombre usuario</label>
                                <input class="form-control" type="text" name="nombre_usuario" id="nombre_usuario<?= (int)$i ?>" value="<?= h($user) ?>" required>
                            </div>
                            <div>
                                <label class="user-label" for="email_usuario<?= (int)$i ?>">Email</label>
                                <input class="form-control" type="email" name="email_usuario" id="email_usuario<?= (int)$i ?>" value="<?= h($email) ?>" required>
                            </div>
                            <div>
                                <label class="user-label" for="link_minicex<?= (int)$i ?>">Link Minicex</label>
                                <input class="form-control" type="text" name="link_minicex" id="link_minicex<?= (int)$i ?>" value="<?= h($link_minicex) ?>" placeholder="Opcional">
                            </div>                        </div>

                        <div class="user-role-grid">
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="verified" value="1" <?= ((int)$row_user['verified'] === 1 ? 'checked' : '') ?>> Verificado</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="admin" value="1" <?= ((int)$row_user['admin'] === 1 ? 'checked' : '') ?>> Administrador</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="staff" value="1" <?= ((int)$row_user['staff_'] === 1 ? 'checked' : '') ?>> Staff</label>
                            <label class="user-check"><input class="form-check-input js-becad-anestesia" type="checkbox" name="becad" value="1" <?= ((int)$row_user['becad_'] === 1 ? 'checked' : '') ?>> Becad@ Anestesia</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="intern" value="1" <?= ((int)$row_user['intern_'] === 1 ? 'checked' : '') ?>> Intern@</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="becad_otro" value="1" <?= ((int)$row_user['becad_otro'] === 1 ? 'checked' : '') ?>> Becad@ Pasante</label>
                        </div>

                        <div class="resident-year-wrap <?= ((int)$row_user['becad_'] === 1 ? 'is-visible' : '') ?>">
                            <div class="resident-year-inner">
                                <label class="user-label" for="anio_residencia<?= (int)$i ?>">Año residencia <span class="text-danger">*</span></label>
                                <select class="form-select js-anio-residencia" name="anio_residencia" id="anio_residencia<?= (int)$i ?>" <?= ((int)$row_user['becad_'] === 1 ? 'required' : '') ?>>
                                    <option value="" <?= ($anio_residencia < 1 || $anio_residencia > 3 ? 'selected' : '') ?>>Seleccionar año</option>
                                    <option value="1" <?= ($anio_residencia === 1 ? 'selected' : '') ?>>1° año</option>
                                    <option value="2" <?= ($anio_residencia === 2 ? 'selected' : '') ?>>2° año</option>
                                    <option value="3" <?= ($anio_residencia === 3 ? 'selected' : '') ?>>3° año</option>
                                </select>
                                <div class="user-subtle mt-1">Obligatorio solo para Becad@ Anestesia.</div>
                            </div>
                        </div>

                        <div class="user-actions">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Guardar
                            </button>

                            <button class="btn btn-outline-danger user-delete-btn" type="button"
                                data-email="<?= h($email) ?>"
                                data-name="<?= h($user) ?>"
                                <?= $is_self ? 'disabled title="No puedes borrar tu propio usuario"' : '' ?>>
                                <i class="fa-solid fa-trash-can me-1"></i> Borrar definitivamente
                            </button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="user-delete-warning mb-3">
                    Esta acción borrará definitivamente el usuario de la base de datos. No se puede deshacer.
                </div>
                <p class="mb-1"><strong>Usuario:</strong> <span id="deleteUserName"></span></p>
                <p class="mb-0"><strong>Email:</strong> <span id="deleteUserEmail"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">RECHAZAR</button>
                <form action="gestion_usuarios.php" method="post" class="m-0">
                    <input type="hidden" name="accion" value="borrar_usuario">
                    <input type="hidden" name="email_delete" id="deleteEmailInput" value="">
                    <input type="hidden" name="confirm_delete" value="CONFIRMAR">
                    <button type="submit" class="btn btn-danger">CONFIRMAR eliminación</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var search = document.getElementById('search');
    var items = document.querySelectorAll('.user-item');

    if(search){
        search.addEventListener('input', function(){
            var q = this.value.toLowerCase().trim();
            items.forEach(function(item){
                var txt = item.getAttribute('data-search') || '';
                item.style.display = txt.indexOf(q) !== -1 ? '' : 'none';
            });
        });
    }

    document.querySelectorAll('.user-item form').forEach(function(form){
        var becad = form.querySelector('.js-becad-anestesia');
        var wrap = form.querySelector('.resident-year-wrap');
        var select = form.querySelector('.js-anio-residencia');

        function toggleResidentYear(){
            if(!becad || !wrap || !select){
                return;
            }

            if(becad.checked){
                wrap.classList.add('is-visible');
                select.required = true;
            }else{
                wrap.classList.remove('is-visible');
                select.required = false;
                select.value = '';
            }
        }

        if(becad){
            becad.addEventListener('change', toggleResidentYear);
            toggleResidentYear();
        }
    });

    var modalElement = document.getElementById('deleteUserModal');
    var deleteModal = null;
    if(modalElement && window.bootstrap){
        deleteModal = new bootstrap.Modal(modalElement);
    }

    document.querySelectorAll('.user-delete-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            var email = this.getAttribute('data-email') || '';
            var name = this.getAttribute('data-name') || '';

            document.getElementById('deleteUserName').textContent = name;
            document.getElementById('deleteUserEmail').textContent = email;
            document.getElementById('deleteEmailInput').value = email;

            if(deleteModal){
                deleteModal.show();
            }else{
                if(confirm('CONFIRMAR eliminación definitiva de ' + email + '?')){
                    this.closest('form').insertAdjacentHTML('beforeend', '<input type="hidden" name="accion" value="borrar_usuario"><input type="hidden" name="email_delete" value="' + email.replace(/"/g, '&quot;') + '"><input type="hidden" name="confirm_delete" value="CONFIRMAR">');
                    this.closest('form').submit();
                }
            }
        });
    });
});
</script>

<?php
require('footer.php');
?>
