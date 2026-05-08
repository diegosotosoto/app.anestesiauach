<?php
require('conectar.php');
require_once __DIR__ . '/app_security.php';
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

function h($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function post_val($key, $default = ''){
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

$usuario_admin = app_current_user($conexion);
if(!$usuario_admin || (int)$usuario_admin['admin'] !== 1){
    header('Location: login.php');
    exit;
}

$check_usuario = trim((string)$usuario_admin['email_usuario']);

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
        $verified_email_us = isset($_POST['verified_email']) ? 1 : 0;
        $admin_us = isset($_POST['admin']) ? 1 : 0;
        $staff_us = isset($_POST['staff']) ? 1 : 0;
        $becad_us = isset($_POST['becad']) ? 1 : 0;
        $intern_us = isset($_POST['intern']) ? 1 : 0;
        $becad_otro_us = isset($_POST['becad_otro']) ? 1 : 0;
        $external_us = isset($_POST['external']) ? 1 : 0;

        if($email_init === '' || $email_us === '' || $nombre_us === ''){
            $mensaje_error = 'Faltan datos obligatorios para guardar el usuario.';
        }elseif(!filter_var($email_us, FILTER_VALIDATE_EMAIL)){
            $mensaje_error = 'El correo ingresado no tiene un formato válido.';
        }else{
            $stmt_update = $conexion->prepare("UPDATE `usuarios_dolor`
                SET `nombre_usuario` = ?,
                    `email_usuario` = ?,
                    `verified` = ?,
                    `verified_email` = ?,
                    `admin` = ?,
                    `staff_` = ?,
                    `becad_` = ?,
                    `becad_otro` = ?,
                    `intern_` = ?,
                    `external_` = ?,
                    `link_minicex` = ?,
                    `anio_residencia` = ?
                WHERE `email_usuario` = ?
                LIMIT 1");

            if(!$stmt_update){
                $mensaje_error = 'Error preparando el guardado: ' . $conexion->error;
            }else{
                $stmt_update->bind_param(
                    'ssiiiiiiiisis',
                    $nombre_us,
                    $email_us,
                    $verified_us,
                    $verified_email_us,
                    $admin_us,
                    $staff_us,
                    $becad_us,
                    $becad_otro_us,
                    $intern_us,
                    $external_us,
                    $link_minicex,
                    $anio_residencia,
                    $email_init
                );

                if($stmt_update->execute()){
                    $mensaje_ok = 'Usuario guardado correctamente.';
                    if($email_init === $check_usuario && $email_us !== $check_usuario){
                        app_set_cookie(APP_AUTH_EMAIL_COOKIE, $email_us, time() + APP_AUTH_COOKIE_TTL);
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

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
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
    'externos' => 0,
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
    SUM(CASE WHEN `external_` = 1 THEN 1 ELSE 0 END) AS externos,
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
$con_users = "SELECT `ID`, `nombre_usuario`, `email_usuario`, `verified`, `verified_email`, `admin`, `staff_`, `becad_`, `intern_`, `becad_otro`, `external_`, `link_minicex`, `anio_residencia`
              FROM `usuarios_dolor`
              ORDER BY `verified` ASC, `nombre_usuario` ASC";
$tab_users = $conexion->query($con_users);
if($tab_users){
    while($row_user = $tab_users->fetch_assoc()){
        $usuarios[] = $row_user;
    }
}
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
    <main class="admin-page user-shell">

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

        <section class="app-hero app-hero-admin admin-header-card mb-3">
            <div class="app-hero-kicker">Administración</div>
            <h2>Gestión de Usuarios</h2>
            <p>Administra permisos, verificación, roles, año de beca y acceso de usuarios de la app.</p>
            <span class="app-hero-pill">Solo administradores</span>
        </section>

        <div class="user-grid mb-3">
            <button type="button" class="user-stat user-filter-btn is-active" data-filter-group="all">
                <div class="user-stat-num"><?= (int)$resumen['total'] ?></div>
                <div class="user-stat-label">Usuarios</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="pendientes">
                <div class="user-stat-num"><?= (int)$resumen['pendientes'] ?></div>
                <div class="user-stat-label">Pendientes</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="admins">
                <div class="user-stat-num"><?= (int)$resumen['admins'] ?></div>
                <div class="user-stat-label">Admins</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="becados">
                <div class="user-stat-num"><?= (int)$resumen['becados'] ?></div>
                <div class="user-stat-label">Becados Anestesia</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="internos">
                <div class="user-stat-num"><?= (int)$resumen['internos'] ?></div>
                <div class="user-stat-label">Internos</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="pasantes">
                <div class="user-stat-num"><?= (int)$resumen['pasantes'] ?></div>
                <div class="user-stat-label">Pasantes</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="externos">
                <div class="user-stat-num"><?= (int)$resumen['externos'] ?></div>
                <div class="user-stat-label">Externos</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="r1">
                <div class="user-stat-num"><?= (int)$resumen['r1'] ?></div>
                <div class="user-stat-label">Residentes 1°</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="r2">
                <div class="user-stat-num"><?= (int)$resumen['r2'] ?></div>
                <div class="user-stat-label">Residentes 2°</div>
            </button>
            <button type="button" class="user-stat user-filter-btn" data-filter-group="r3">
                <div class="user-stat-num"><?= (int)$resumen['r3'] ?></div>
                <div class="user-stat-label">Residentes 3°</div>
            </button>
        </div>

        <div class="user-card user-search-card">
            <div class="user-search-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
            <input type="text" class="form-control" id="search" placeholder="Buscar por nombre o correo...">
        </div>

        <div class="user-pagination-bar" id="userPaginationBar">
            <div class="user-pagination-info" id="userPaginationInfo"></div>
            <div class="user-pagination-controls">
                <button type="button" class="btn btn-app-secondary btn-sm" id="userPagePrev"><i class="fa-solid fa-chevron-left"></i> Anterior</button>
                <span class="user-pagination-current" id="userPaginationCurrent"></span>
                <button type="button" class="btn btn-app-secondary btn-sm" id="userPageNext">Siguiente <i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>

        <div id="mytable">
            <?php foreach($usuarios as $i => $row_user){
                $user = function_exists('app_decode_text') ? app_decode_text($row_user['nombre_usuario']) : (string)$row_user['nombre_usuario'];
                $email = (string)$row_user['email_usuario'];
                $link_minicex = (string)$row_user['link_minicex'];
                $anio_residencia = isset($row_user['anio_residencia']) ? (int)$row_user['anio_residencia'] : 0;
                $is_self = strtolower($email) === strtolower($check_usuario);
                $grupos_usuario = ['all'];
                if((int)$row_user['verified'] !== 1){ $grupos_usuario[] = 'pendientes'; }
                if((int)$row_user['admin'] === 1){ $grupos_usuario[] = 'admins'; }
                if((int)$row_user['becad_'] === 1){ $grupos_usuario[] = 'becados'; }
                if((int)$row_user['intern_'] === 1){ $grupos_usuario[] = 'internos'; }
                if((int)$row_user['becad_otro'] === 1){ $grupos_usuario[] = 'pasantes'; }
                if((int)$row_user['external_'] === 1){ $grupos_usuario[] = 'externos'; }
                if((int)$row_user['becad_'] === 1 && $anio_residencia === 1){ $grupos_usuario[] = 'r1'; }
                if((int)$row_user['becad_'] === 1 && $anio_residencia === 2){ $grupos_usuario[] = 'r2'; }
                if((int)$row_user['becad_'] === 1 && $anio_residencia === 3){ $grupos_usuario[] = 'r3'; }
            ?>
                <div class="user-card user-item" data-groups="<?= h(implode(' ', $grupos_usuario)) ?>" data-search="<?= h(strtolower($user . ' ' . $email . ' r' . $anio_residencia . ' ' . $anio_residencia . ' año')) ?>">
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
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="verified_email" value="1" <?= ((int)$row_user['verified_email'] === 1 ? 'checked' : '') ?>> Email verificado</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="admin" value="1" <?= ((int)$row_user['admin'] === 1 ? 'checked' : '') ?>> Administrador</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="staff" value="1" <?= ((int)$row_user['staff_'] === 1 ? 'checked' : '') ?>> Staff</label>
                            <label class="user-check"><input class="form-check-input js-becad-anestesia" type="checkbox" name="becad" value="1" <?= ((int)$row_user['becad_'] === 1 ? 'checked' : '') ?>> Becad@ Anestesia</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="intern" value="1" <?= ((int)$row_user['intern_'] === 1 ? 'checked' : '') ?>> Intern@</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="becad_otro" value="1" <?= ((int)$row_user['becad_otro'] === 1 ? 'checked' : '') ?>> Becad@ Pasante</label>
                            <label class="user-check"><input class="form-check-input" type="checkbox" name="external" value="1" <?= ((int)$row_user['external_'] === 1 ? 'checked' : '') ?>> Extern@</label>
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
                            <button class="btn btn-app-primary" type="submit">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Guardar
                            </button>

                            <button class="btn btn-app-danger user-delete-btn" type="button"
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
    </main>
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
                <button type="button" class="btn btn-app-secondary" data-bs-dismiss="modal">RECHAZAR</button>
                <form action="gestion_usuarios.php" method="post" class="m-0">
                    <input type="hidden" name="accion" value="borrar_usuario">
                    <input type="hidden" name="email_delete" id="deleteEmailInput" value="">
                    <input type="hidden" name="confirm_delete" value="CONFIRMAR">
                    <button type="submit" class="btn btn-app-danger">CONFIRMAR eliminación</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var search = document.getElementById('search');
    var items = document.querySelectorAll('.user-item');
    var filterButtons = document.querySelectorAll('.user-filter-btn');
    var paginationInfo = document.getElementById('userPaginationInfo');
    var paginationCurrent = document.getElementById('userPaginationCurrent');
    var pagePrev = document.getElementById('userPagePrev');
    var pageNext = document.getElementById('userPageNext');
    var activeGroup = 'all';
    var currentPage = 1;
    var itemsPerPage = 10;

    function getFilteredItems(){
        var q = search ? search.value.toLowerCase().trim() : '';
        return Array.prototype.filter.call(items, function(item){
            var txt = item.getAttribute('data-search') || '';
            var groups = (item.getAttribute('data-groups') || '').split(' ');
            var matchesGroup = activeGroup === 'all' || groups.indexOf(activeGroup) !== -1;
            var matchesSearch = q === '' || txt.indexOf(q) !== -1;
            return matchesGroup && matchesSearch;
        });
    }

    function applyUserFilters(){
        var filteredItems = getFilteredItems();
        var totalPages = Math.max(1, Math.ceil(filteredItems.length / itemsPerPage));
        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;

        if(currentPage > totalPages){
            currentPage = totalPages;
            startIndex = (currentPage - 1) * itemsPerPage;
            endIndex = startIndex + itemsPerPage;
        }

        items.forEach(function(item){
            item.style.display = 'none';
        });

        filteredItems.slice(startIndex, endIndex).forEach(function(item){
            item.style.display = '';
        });

        if(paginationInfo){
            if(filteredItems.length === 0){
                paginationInfo.textContent = 'Sin usuarios para mostrar';
            }else{
                paginationInfo.textContent = 'Mostrando ' + (startIndex + 1) + '-' + Math.min(endIndex, filteredItems.length) + ' de ' + filteredItems.length + ' usuarios';
            }
        }

        if(paginationCurrent){
            paginationCurrent.textContent = 'Página ' + currentPage + ' de ' + totalPages;
        }

        if(pagePrev){
            pagePrev.disabled = currentPage <= 1;
        }

        if(pageNext){
            pageNext.disabled = currentPage >= totalPages;
        }
    }

    filterButtons.forEach(function(btn){
        btn.addEventListener('click', function(){
            activeGroup = this.getAttribute('data-filter-group') || 'all';
            filterButtons.forEach(function(otherBtn){
                otherBtn.classList.toggle('is-active', otherBtn === btn);
            });
            currentPage = 1;
            applyUserFilters();
        });
    });

    if(search){
        search.addEventListener('input', function(){
            currentPage = 1;
            applyUserFilters();
        });
    }

    if(pagePrev){
        pagePrev.addEventListener('click', function(){
            if(currentPage > 1){
                currentPage--;
                applyUserFilters();
            }
        });
    }

    if(pageNext){
        pageNext.addEventListener('click', function(){
            currentPage++;
            applyUserFilters();
        });
    }

    applyUserFilters();

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
