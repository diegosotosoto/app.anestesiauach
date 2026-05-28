<?php
require('conectar.php');
require_once(__DIR__ . '/app_text_helpers.php');
require_once(__DIR__ . '/app_security.php');

$conexion_ui = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion_ui->set_charset('utf8mb4');

app_require_login($conexion_ui, 'login.php');

function ui_h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function ui_modos_validos() {
    return ['normal', 'nocturno'];
}

function ui_iconos_validos() {
    return ['fa-user', 'fa-user-astronaut', 'fa-user-doctor', 'fa-user-graduate', 'fa-user-ninja', 'fa-user-tie', 'fa-person-dress', 'fa-snowman', 'fa-head-side-mask', 'fa-skull', 'fa-poo', 'fa-user-secret', 'fa-brain', 'fa-ghost', 'fa-cat', 'fa-dog', 'fa-spider', 'fa-horse-head'];
}

function ui_iconos_admin_validos() {
    return ['fa-hat-wizard', 'fa-crown'];
}

function ui_colores_icono_validos() {
    return ['blue', 'green', 'red', 'yellow', 'orange', 'purple', 'teal', 'pink', 'cyan', 'indigo', 'slate', 'black'];
}

function ui_columna_existe($conexion, $columna) {
    $columna_db = $conexion->real_escape_string($columna);
    $res = $conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE '$columna_db'");
    return $res && $res->num_rows > 0;
}

function ui_enviar_mail_password_cambiada($email_usuario) {
    $smtp_config_path = __DIR__ . '/secure_config/smtp_config.php';
    if (file_exists($smtp_config_path)) {
        require_once($smtp_config_path);
    }

    require_once __DIR__ . '/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;

        if (defined('APP_SMTP_HOST') && defined('APP_SMTP_USER') && defined('APP_SMTP_PASS') && APP_SMTP_PASS !== 'AQUI_VA_LA_PASSWORD_REAL') {
            $mail->isSMTP();
            $mail->Host = APP_SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = APP_SMTP_USER;
            $mail->Password = APP_SMTP_PASS;
            $mail->SMTPSecure = defined('APP_SMTP_SECURE') ? APP_SMTP_SECURE : '';
            $mail->Port = defined('APP_SMTP_PORT') ? (int)APP_SMTP_PORT : 587;
        } else {
            $mail->isMail();
        }

        $from_email = defined('APP_SMTP_FROM_EMAIL') ? APP_SMTP_FROM_EMAIL : 'administrador@anestesiauach.cl';
        $from_name = defined('APP_SMTP_FROM_NAME') ? APP_SMTP_FROM_NAME : 'Anestesia UACh';
        $safe_email = ui_h($email_usuario);

        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($email_usuario, 'Usuario');
        $mail->isHTML(true);
        $mail->Subject = 'Contraseña actualizada - Anestesia UACh';
        $mail->Body = '<!doctype html><html lang="es"><body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;"><table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f7fb;margin:0;padding:32px 12px;"><tr><td align="center"><table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 18px 45px rgba(15,23,42,.12);"><tr><td style="background:linear-gradient(135deg,#123c7c,#1b75bb);padding:28px 30px;color:#ffffff;text-align:center;"><div style="font-size:12px;letter-spacing:.16em;text-transform:uppercase;font-weight:800;opacity:.85;">Seguridad de cuenta</div><h1 style="margin:10px 0 0;font-size:28px;line-height:1.15;font-weight:800;">Contraseña actualizada</h1></td></tr><tr><td style="padding:30px;"><p style="font-size:16px;line-height:1.6;margin:0 0 18px;">Te informamos que la contraseña asociada a tu cuenta fue modificada correctamente.</p><div style="background:#eef5ff;border:1px solid #d8e8ff;border-radius:18px;padding:16px 18px;margin:0 0 24px;"><div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#3559b7;font-weight:800;margin-bottom:6px;">Cuenta</div><div style="font-size:17px;font-weight:800;color:#111827;">' . $safe_email . '</div></div><p style="font-size:14px;line-height:1.6;color:#6b7280;margin:0 0 18px;">Si tú no realizaste este cambio, contacta inmediatamente al administrador.</p><div style="height:1px;background:#e5e7eb;margin:24px 0;"></div><p style="font-size:14px;line-height:1.5;color:#6b7280;margin:0;">Saludos,<br><strong style="color:#111827;">Anestesia UACh</strong></p></td></tr></table></td></tr></table></body></html>';
        $mail->AltBody = "Contraseña actualizada\n\nLa contraseña asociada a tu cuenta fue modificada correctamente.\n\nSi tú no realizaste este cambio, contacta inmediatamente al administrador.\n\nAnestesia UACh";
        $mail->send();
        return true;
    } catch (Throwable $e) {
        error_log('Error PHPMailer cambio password: ' . $mail->ErrorInfo . ' | ' . $e->getMessage());
        return false;
    }
}

$usuario = app_current_user($conexion_ui);

if (!$usuario) {
    header('Location: login.php');
    exit;
}

$email_usuario = trim((string)$usuario['email_usuario']);
$columna_ui_existe = ui_columna_existe($conexion_ui, 'ui_modo');
$columna_nav_existe = ui_columna_existe($conexion_ui, 'ui_nav_posicion');
$columna_icono_existe = ui_columna_existe($conexion_ui, 'ui_icono');
$columna_icono_color_existe = ui_columna_existe($conexion_ui, 'ui_icono_color');
$columna_verified_email_existe = ui_columna_existe($conexion_ui, 'verified_email');
$mensaje_ok = '';
$mensaje_error = '';

$select_verified_email = $columna_verified_email_existe ? "`verified_email`" : "0 AS `verified_email`";
$select_ui_modo = $columna_ui_existe ? "`ui_modo`" : "'normal' AS `ui_modo`";
$select_ui_nav = $columna_nav_existe ? "`ui_nav_posicion`" : "'left' AS `ui_nav_posicion`";
$select_ui_icono = $columna_icono_existe ? "`ui_icono`" : "'fa-user-doctor' AS `ui_icono`";
$select_ui_icono_color = $columna_icono_color_existe ? "`ui_icono_color`" : "'green' AS `ui_icono_color`";

$stmt = $conexion_ui->prepare("SELECT `ID`, `nombre_usuario`, `email_usuario`, `password`, `verified`, $select_verified_email, `admin`, `staff_`, `becad_`, `intern_`, `becad_otro`, $select_ui_modo, $select_ui_nav, $select_ui_icono, $select_ui_icono_color FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param('s', $email_usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $usuario = $res->fetch_assoc();
    $stmt->close();
}

function ui_get_push_prefs(mysqli $conn, int $uid): array {
    $defaults = ['push_enabled'=>1,'notif_calendario'=>1,'notif_bitacora'=>1,'notif_dolor'=>1,'notif_sistema'=>1];
    $stmt = $conn->prepare("SELECT `push_enabled`,`notif_calendario`,`notif_bitacora`,`notif_dolor`,`notif_sistema` FROM `user_push_prefs` WHERE `usuario_id`=? LIMIT 1");
    if (!$stmt) return $defaults;
    $stmt->bind_param('i',$uid);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    if (!$row) return $defaults;
    return [
        'push_enabled'     => (int)$row['push_enabled'],
        'notif_calendario' => (int)$row['notif_calendario'],
        'notif_bitacora'   => (int)$row['notif_bitacora'],
        'notif_dolor'      => (int)$row['notif_dolor'],
        'notif_sistema'    => (int)$row['notif_sistema'],
    ];
}

$modo_actual = in_array((string)($usuario['ui_modo'] ?? 'normal'), ui_modos_validos(), true) ? (string)$usuario['ui_modo'] : 'normal';
$nav_actual = in_array((string)($usuario['ui_nav_posicion'] ?? 'left'), ['left', 'right'], true) ? (string)$usuario['ui_nav_posicion'] : 'left';
$es_admin_ui = (int)($usuario['admin'] ?? 0) === 1;
$iconos_permitidos_usuario = $es_admin_ui ? array_merge(ui_iconos_validos(), ui_iconos_admin_validos()) : ui_iconos_validos();
$icono_actual = in_array((string)($usuario['ui_icono'] ?? 'fa-user-doctor'), $iconos_permitidos_usuario, true) ? (string)$usuario['ui_icono'] : 'fa-user-doctor';
$icono_color_actual = in_array((string)($usuario['ui_icono_color'] ?? 'green'), ui_colores_icono_validos(), true) ? (string)$usuario['ui_icono_color'] : 'green';
$icono_actual_admin = $es_admin_ui;

$push_prefs = ui_get_push_prefs($conexion_ui, (int)$usuario['ID']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = (string)($_POST['config_action'] ?? '');

    if ($accion === 'ui') {
        $modo_post = (string)($_POST['ui_modo'] ?? 'normal');
        $nav_post = (string)($_POST['ui_nav_posicion'] ?? 'left');
        $icono_post = (string)($_POST['ui_icono'] ?? 'fa-user-doctor');
        $icono_color_post = (string)($_POST['ui_icono_color'] ?? 'green');

        if (!in_array($modo_post, ui_modos_validos(), true)) {
            $modo_post = 'normal';
        }
        if (!in_array($nav_post, ['left', 'right'], true)) {
            $nav_post = 'left';
        }
        if (!in_array($icono_post, $iconos_permitidos_usuario, true)) {
            $icono_post = 'fa-user-doctor';
        }
        if (!in_array($icono_color_post, ui_colores_icono_validos(), true)) {
            $icono_color_post = 'green';
        }

        if (!$columna_ui_existe || !$columna_nav_existe || !$columna_icono_existe || !$columna_icono_color_existe) {
            $mensaje_error = 'Falta ejecutar la migración de base de datos para activar todas las preferencias.';
        } else {
            $stmt = $conexion_ui->prepare("UPDATE `usuarios_dolor` SET `ui_modo` = ?, `ui_nav_posicion` = ?, `ui_icono` = ?, `ui_icono_color` = ? WHERE `email_usuario` = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('sssss', $modo_post, $nav_post, $icono_post, $icono_color_post, $email_usuario);
                if ($stmt->execute()) {
                    $modo_actual = $modo_post;
                    $nav_actual = $nav_post;
                    $icono_actual = $icono_post;
                    $icono_color_actual = $icono_color_post;
                    $icono_actual_admin = $es_admin_ui;
                    $mensaje_ok = 'Preferencias de interfaz guardadas.';
                } else {
                    $mensaje_error = 'No fue posible guardar las preferencias.';
                }
                $stmt->close();
            }
        }
    }

    if ($accion === 'password') {
        $pass_actual = (string)($_POST['pass_actual'] ?? '');
        $pass_nueva = (string)($_POST['pass_nueva'] ?? '');
        $pass_nueva2 = (string)($_POST['pass_nueva2'] ?? '');

        if (!password_verify($pass_actual, (string)$usuario['password'])) {
            $mensaje_error = 'La contraseña actual no es correcta.';
        } elseif ($pass_nueva !== $pass_nueva2) {
            $mensaje_error = 'Las nuevas contraseñas no coinciden.';
        } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$/', $pass_nueva)) {
            $mensaje_error = 'La nueva contraseña debe tener 8 a 12 caracteres, una mayúscula, un número y un símbolo.';
        } else {
            $pass_cifrado = password_hash($pass_nueva, PASSWORD_DEFAULT);
            $stmt = $conexion_ui->prepare("UPDATE `usuarios_dolor` SET `password` = ? WHERE `email_usuario` = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('ss', $pass_cifrado, $email_usuario);
                if ($stmt->execute()) {
                    $usuario['password'] = $pass_cifrado;
                    $mail_ok = ui_enviar_mail_password_cambiada($email_usuario);
                    $mensaje_ok = $mail_ok ? 'Contraseña actualizada. Enviamos una notificación a tu correo.' : 'Contraseña actualizada. No fue posible enviar la notificación por correo.';
                } else {
                    $mensaje_error = 'No fue posible actualizar la contraseña.';
                }
                $stmt->close();
            }
        }
    }

    if ($accion === 'notif') {
        $uid_notif = (int)$usuario['ID'];
        $push_enabled_post     = isset($_POST['push_enabled'])     ? 1 : 0;
        $notif_calendario_post = isset($_POST['notif_calendario']) ? 1 : 0;
        $notif_bitacora_post   = isset($_POST['notif_bitacora'])   ? 1 : 0;
        $notif_dolor_post      = isset($_POST['notif_dolor'])      ? 1 : 0;
        $notif_sistema_post    = isset($_POST['notif_sistema'])    ? 1 : 0;

        $stmt_notif = $conexion_ui->prepare("
            INSERT INTO `user_push_prefs`
                (`usuario_id`,`push_enabled`,`notif_calendario`,`notif_bitacora`,`notif_dolor`,`notif_sistema`)
            VALUES (?,?,?,?,?,?)
            ON DUPLICATE KEY UPDATE
                `push_enabled`=VALUES(`push_enabled`),
                `notif_calendario`=VALUES(`notif_calendario`),
                `notif_bitacora`=VALUES(`notif_bitacora`),
                `notif_dolor`=VALUES(`notif_dolor`),
                `notif_sistema`=VALUES(`notif_sistema`)
        ");
        if ($stmt_notif) {
            $stmt_notif->bind_param('iiiiii',$uid_notif,$push_enabled_post,$notif_calendario_post,$notif_bitacora_post,$notif_dolor_post,$notif_sistema_post);
            if ($stmt_notif->execute()) {
                $push_prefs = [
                    'push_enabled'     => $push_enabled_post,
                    'notif_calendario' => $notif_calendario_post,
                    'notif_bitacora'   => $notif_bitacora_post,
                    'notif_dolor'      => $notif_dolor_post,
                    'notif_sistema'    => $notif_sistema_post,
                ];
                $mensaje_ok = 'Preferencias de notificaciones guardadas.';
                if ($push_enabled_post === 0) {
                    $stmt_dis = $conexion_ui->prepare("UPDATE `push_subscriptions` SET `enabled`=0, `updated_at`=NOW() WHERE `usuario_id`=?");
                    if ($stmt_dis) { $stmt_dis->bind_param('i',$uid_notif); $stmt_dis->execute(); $stmt_dis->close(); }
                }
            } else {
                $mensaje_error = 'No fue posible guardar las preferencias de notificaciones.';
            }
            $stmt_notif->close();
        } else {
            $mensaje_error = 'Error preparando la consulta de preferencias.';
        }
    }

    if ($accion === 'request_password_reset') {
        $email_solicitud = (string)($_POST['email_usuario_r'] ?? $email_usuario);

        $chequea_email = "SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= ? AND `verified`= '1'";
        $stmt_check = $conexion_ui->prepare($chequea_email);
        if ($stmt_check) {
            $stmt_check->bind_param('s', $email_solicitud);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            $conteo = $result_check->num_rows;
            $stmt_check->close();

            if ($conteo == 0) {
                $mensaje_error = 'Error en el registro, contacta al administrador.';
            } else {
                $mensaje_ok = 'Se ha enviado un correo a la cuenta indicada.';
                echo '<form method="POST" action="mail.php" name="mail_post">';
                echo '<input type="hidden" name="email_usuario_rec" value="' . htmlspecialchars($email_solicitud) . '">';
                echo '</form>';
                echo '<script>window.onload = function(){ document.forms["mail_post"].submit(); }</script>';
            }
        }
    }
}

$roles = [];
if ((int)$usuario['admin'] === 1) { $roles[] = 'Admin'; }
if ((int)$usuario['staff_'] === 1) { $roles[] = 'Staff'; }
if ((int)$usuario['becad_'] === 1) { $roles[] = 'Becado'; }
if ((int)$usuario['intern_'] === 1) { $roles[] = 'Interno'; }
if ((int)$usuario['becad_otro'] === 1) { $roles[] = 'Pasante'; }
$grupo_usuario = $roles ? implode(' / ', $roles) : 'None';

$opciones_ui = [
    'normal' => ['titulo' => 'Light mode', 'subtitulo' => 'Tema claro institucional.', 'icono' => 'fa-solid fa-sun', 'clase' => 'ui-preview-normal'],
    'nocturno' => ['titulo' => 'Dark mode', 'subtitulo' => 'Fondo oscuro para baja luminosidad.', 'icono' => 'fa-solid fa-moon', 'clase' => 'ui-preview-nocturno']
];

$opciones_icono_color = [
    'blue' => '#1f5fbf',
    'green' => '#2e9b55',
    'red' => '#ce2e2e',
    'yellow' => '#d4a900',
    'orange' => '#ff5a00',
    'purple' => '#6405d0',
    'teal' => '#29a09b',
    'pink' => '#d9027d',
    'cyan' => '#0ea5e9',
    'indigo' => '#f9a8d4',
    'slate' => '#475569',
    'black' => '#111827'
];

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<div>Configuración</div>";
$boton_navbar = "<a></a>";

$usuario_configuracion = $usuario;
require('head.php');
$usuario = $usuario_configuracion;
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
    <main class="admin-page ui-settings-page">
        <?php if ($mensaje_ok !== ''): ?>
            <div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><strong>Listo:</strong> <?= ui_h($mensaje_ok) ?></div>
        <?php endif; ?>

        <?php if ($mensaje_error !== ''): ?>
            <div class="alert alert-danger alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><strong>Error:</strong> <?= ui_h($mensaje_error) ?></div>
        <?php endif; ?>

        <?php if (!$columna_ui_existe || !$columna_nav_existe): ?>
            <div class="alert alert-warning">Falta ejecutar la migración de base de datos para activar todas las preferencias.</div>
        <?php endif; ?>

        <section class="app-hero app-hero-blue">
            <div class="app-hero-row">
                <div class="app-hero-body">
                    <div class="app-hero-kicker">Cuenta y preferencias</div>
                    <h2>Configuración personal</h2>
                    <p>Revisa tu información, cambia tu contraseña y ajusta la interfaz según tu preferencia.</p>
                </div>
            </div>
        </section>

        <section class="app-card ui-settings-card">
            <div class="app-card-title ui-user-title">
                <span id="uiUserHeaderAvatar" class="ui-user-header-avatar <?= $icono_actual_admin ? 'ui-user-header-avatar-admin' : '' ?>" style="background: <?= ui_h($opciones_icono_color[$icono_color_actual] ?? '#2e9b55') ?>;"><i class="fa-solid <?= ui_h($icono_actual) ?>"></i></span>
                <div>
                    <h3><?= ui_h(app_decode_text($usuario['nombre_usuario'] ?? 'Usuario')) ?></h3>
                    <p>Datos asociados a tu cuenta institucional dentro de la app.</p>
                </div>
            </div>
            <div class="user-role-grid">
                <div class="user-check"><strong>Email:</strong> <?= ui_h($usuario['email_usuario'] ?? '') ?></div>
                <div class="user-check"><strong>Grupo:</strong> <?= ui_h($grupo_usuario) ?></div>
                <div class="user-check"><strong>Email verificado:</strong> <?= ((int)($usuario['verified_email'] ?? 0) === 1 ? 'Sí' : 'No') ?></div>
            </div>
        </section>

        <?php if ((int)($usuario['verified_email'] ?? 0) === 1): ?>
        <form method="post" action="configuracion_ui.php" class="app-card ui-settings-card" id="passwordChangeForm" autocomplete="off">
            <input type="hidden" name="config_action" value="password">
            <div class="app-card-title">
                <span class="app-icon-circle"><i class="fa-solid fa-key"></i></span>
                <div>
                    <h3>Cambiar contraseña</h3>
                    <p>Solicita tu contraseña actual y luego confirma la nueva. Se enviará una notificación por correo.</p>
                </div>
            </div>
            <div class="login-form-box">
                <div class="mb-3">
                    <label class="form-label text-muted">Contraseña actual</label>
                    <div class="input-group password-toggle-group">
                        <input type="password" name="pass_actual" class="form-control login-input" required>
                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" aria-label="Mostrar contraseña">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Nueva contraseña</label>
                    <div class="input-group password-toggle-group">
                        <input type="password" name="pass_nueva" class="form-control login-input" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$">
                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" aria-label="Mostrar contraseña">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Repetir nueva contraseña</label>
                    <div class="input-group password-toggle-group">
                        <input type="password" name="pass_nueva2" class="form-control login-input" required>
                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" aria-label="Mostrar contraseña">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="auth-helper auth-full">Contraseña de 8 a 12 caracteres, incluyendo una mayúscula, un número y un símbolo (!@#$%^&*_=+-)</div>
                <div class="admin-actions auth-full"><button type="submit" class="btn btn-app-primary"><i class="fa-solid fa-floppy-disk"></i> Cambiar contraseña</button></div>
            </div>
        </form>
        <?php else: ?>
        <form method="post" action="configuracion_ui.php" class="app-card ui-settings-card" autocomplete="off">
            <input type="hidden" name="config_action" value="request_password_reset">
            <div class="app-card-title">
                <span class="app-icon-circle"><i class="fa-solid fa-key"></i></span>
                <div>
                    <h3>Verificar email y cambiar contraseña</h3>
                    <p>Para cambiar tu contraseña, primero debes verificar tu correo electrónico. Te enviaremos un enlace para crear una nueva contraseña.</p>
                </div>
            </div>
            <div class="login-form-box">
                <div class="mb-3">
                    <label class="form-label text-muted">E-Mail</label>
                    <div class="input-group">
                        <input type="email" name="email_usuario_r" class="form-control login-input" value="<?= htmlspecialchars($email_usuario) ?>" required>
                        <span class="input-group-text app-input-addon login-addon"><i class="fa fa-envelope"></i></span>
                    </div>
                </div>
                <div class="admin-actions auth-full"><button type="submit" class="btn btn-app-primary"><i class="fa-solid fa-paper-plane"></i> Enviar enlace de verificación</button></div>
            </div>
        </form>
        <?php endif; ?>

        <form method="post" action="configuracion_ui.php" class="app-card ui-settings-card">
            <input type="hidden" name="config_action" value="ui">
            <div class="app-card-title">
                <span class="app-icon-circle"><i class="fa-solid fa-palette"></i></span>
                <div>
                    <h3>Interfaz de usuario</h3>
                    <p>Selecciona modo visual y posición del menú lateral.</p>
                </div>
            </div>

            <div class="ui-mode-grid" role="radiogroup" aria-label="Modo de interfaz">
                <?php foreach ($opciones_ui as $modo => $opcion): ?>
                    <label class="ui-mode-option">
                        <input type="radio" name="ui_modo" value="<?= ui_h($modo) ?>" <?= $modo_actual === $modo ? 'checked' : '' ?> <?= !$columna_ui_existe ? 'disabled' : '' ?>>
                        <span class="ui-mode-icon <?= ui_h($opcion['clase']) ?>"><i class="<?= ui_h($opcion['icono']) ?>"></i></span>
                        <span class="ui-mode-copy"><strong><?= ui_h($opcion['titulo']) ?></strong><span><?= ui_h($opcion['subtitulo']) ?></span></span>
                        <span class="ui-mode-check"><i class="fa-solid fa-check"></i></span>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="ui-mode-grid mt-3" role="radiogroup" aria-label="Posición del menú">
                <label class="ui-mode-option">
                    <input type="radio" name="ui_nav_posicion" value="left" <?= $nav_actual === 'left' ? 'checked' : '' ?> <?= !$columna_nav_existe ? 'disabled' : '' ?>>
                    <span class="ui-mode-icon ui-preview-normal"><i class="fa-solid fa-hand-point-left"></i></span>
                    <span class="ui-mode-copy"><strong>Menú a la izquierda</strong><span>Distribución estándar.</span></span>
                    <span class="ui-mode-check"><i class="fa-solid fa-check"></i></span>
                </label>
                <label class="ui-mode-option">
                    <input type="radio" name="ui_nav_posicion" value="right" <?= $nav_actual === 'right' ? 'checked' : '' ?> <?= !$columna_nav_existe ? 'disabled' : '' ?>>
                    <span class="ui-mode-icon ui-preview-daltonico"><i class="fa-solid fa-hand-point-right"></i></span>
                    <span class="ui-mode-copy"><strong>Menú a la derecha</strong><span>Opción útil para zurdos.</span></span>
                    <span class="ui-mode-check"><i class="fa-solid fa-check"></i></span>
                </label>
            </div>

            <div class="app-card-title mt-4">
                <span id="uiAvatarPreview" class="ui-avatar-preview <?= $icono_actual_admin ? 'ui-avatar-preview-admin' : '' ?>" style="background: <?= ui_h($opciones_icono_color[$icono_color_actual] ?? '#2e9b55') ?>;">
                    <i class="fa-solid <?= ui_h($icono_actual) ?>"></i>
                </span>
                <div>
                    <h3>Icono de usuario</h3>
                    <p>Elige el icono y color que se mostrará en tu tarjeta del menú lateral.</p>
                </div>
            </div>

            <div class="ui-avatar-picker">
                <div class="ui-avatar-options">
                    <div class="ui-avatar-group" role="radiogroup" aria-label="Icono de usuario">
                        <?php foreach ($iconos_permitidos_usuario as $icono_opcion): ?>
                            <?php $icono_es_admin = in_array($icono_opcion, ui_iconos_admin_validos(), true); ?>
                            <label class="ui-avatar-square <?= $icono_es_admin ? 'ui-avatar-admin-square' : '' ?>">
                                <input type="radio" name="ui_icono" value="<?= ui_h($icono_opcion) ?>" <?= $icono_actual === $icono_opcion ? 'checked' : '' ?> <?= !$columna_icono_existe ? 'disabled' : '' ?>>
                                <span><i class="fa-solid <?= ui_h($icono_opcion) ?>"></i></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="ui-color-group" role="radiogroup" aria-label="Color del icono de usuario">
                        <?php foreach ($opciones_icono_color as $color_key => $color_hex): ?>
                            <label class="ui-color-square">
                                <input type="radio" name="ui_icono_color" value="<?= ui_h($color_key) ?>" data-color="<?= ui_h($color_hex) ?>" <?= $icono_color_actual === $color_key ? 'checked' : '' ?> <?= !$columna_icono_color_existe ? 'disabled' : '' ?>>
                                <span style="background: <?= ui_h($color_hex) ?>;"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="admin-actions">
                <button type="submit" class="btn btn-app-primary" <?= (!$columna_ui_existe || !$columna_nav_existe || !$columna_icono_existe || !$columna_icono_color_existe) ? 'disabled' : '' ?>>
                    <i class="fa-solid fa-floppy-disk"></i> Guardar preferencias
                </button>
            </div>
        </form>

        <form method="post" action="configuracion_ui.php" class="app-card ui-settings-card" id="notifPrefsForm">
            <input type="hidden" name="config_action" value="notif">
            <div class="app-card-title">
                <span class="app-icon-circle"><i class="fa-solid fa-bell"></i></span>
                <div>
                    <h3>Notificaciones push</h3>
                    <p>Activa o desactiva las notificaciones en este dispositivo y personaliza qué tipos quieres recibir.</p>
                </div>
            </div>

            <div class="notif-prefs-list">

                <div class="notif-pref-row notif-pref-master">
                    <div class="notif-pref-info">
                        <span class="notif-pref-icon"><i class="fa-solid fa-bell"></i></span>
                        <div>
                            <strong>Notificaciones activadas</strong>
                            <span class="notif-pref-desc">Permite que la app te envíe notificaciones en este dispositivo.</span>
                        </div>
                    </div>
                    <label class="notif-toggle" id="masterToggleLabel">
                        <input type="checkbox" name="push_enabled" id="pushMasterSwitch" <?= $push_prefs['push_enabled'] ? 'checked' : '' ?> value="1">
                        <span class="notif-toggle-slider"></span>
                    </label>
                </div>

                <div id="notifSubPrefs" class="notif-subprefs <?= $push_prefs['push_enabled'] ? '' : 'notif-subprefs-disabled' ?>">

                    <div class="notif-pref-row">
                        <div class="notif-pref-info">
                            <span class="notif-pref-icon notif-pref-icon-cal"><i class="fa-regular fa-calendar"></i></span>
                            <div>
                                <strong>Calendario</strong>
                                <span class="notif-pref-desc">Recordatorios de eventos próximos en tu calendario académico.</span>
                            </div>
                        </div>
                        <label class="notif-toggle">
                            <input type="checkbox" name="notif_calendario" <?= $push_prefs['notif_calendario'] ? 'checked' : '' ?> value="1" class="notif-sub-check">
                            <span class="notif-toggle-slider"></span>
                        </label>
                    </div>

                    <div class="notif-pref-row">
                        <div class="notif-pref-info">
                            <span class="notif-pref-icon notif-pref-icon-bit"><i class="fa-solid fa-clipboard-list"></i></span>
                            <div>
                                <strong>Bitácora</strong>
                                <span class="notif-pref-desc">Avisos cuando un residente ingresa un procedimiento para tu revisión.</span>
                            </div>
                        </div>
                        <label class="notif-toggle">
                            <input type="checkbox" name="notif_bitacora" <?= $push_prefs['notif_bitacora'] ? 'checked' : '' ?> value="1" class="notif-sub-check">
                            <span class="notif-toggle-slider"></span>
                        </label>
                    </div>

                    <div class="notif-pref-row">
                        <div class="notif-pref-info">
                            <span class="notif-pref-icon notif-pref-icon-dolor"><i class="fa-solid fa-hospital-user"></i></span>
                            <div>
                                <strong>Pacientes Dolor</strong>
                                <span class="notif-pref-desc">Recordatorio diario de pacientes activos en manejo de dolor agudo.</span>
                            </div>
                        </div>
                        <label class="notif-toggle">
                            <input type="checkbox" name="notif_dolor" <?= $push_prefs['notif_dolor'] ? 'checked' : '' ?> value="1" class="notif-sub-check">
                            <span class="notif-toggle-slider"></span>
                        </label>
                    </div>

                    <div class="notif-pref-row">
                        <div class="notif-pref-info">
                            <span class="notif-pref-icon notif-pref-icon-sis"><i class="fa-solid fa-bullhorn"></i></span>
                            <div>
                                <strong>Avisos del sistema</strong>
                                <span class="notif-pref-desc">Notificaciones enviadas por el administrador a todo el equipo.</span>
                            </div>
                        </div>
                        <label class="notif-toggle">
                            <input type="checkbox" name="notif_sistema" <?= $push_prefs['notif_sistema'] ? 'checked' : '' ?> value="1" class="notif-sub-check">
                            <span class="notif-toggle-slider"></span>
                        </label>
                    </div>

                </div>

            </div>

            <div id="notifPermBanner" class="notif-perm-banner" style="display:none;"></div>

            <div class="admin-actions">
                <button type="submit" class="btn btn-app-primary" id="notifSaveBtn">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar preferencias
                </button>
            </div>
        </form>

    </main>
</div>

<script>
(function () {
    const master  = document.getElementById('pushMasterSwitch');
    const subPane = document.getElementById('notifSubPrefs');
    const banner  = document.getElementById('notifPermBanner');
    const form    = document.getElementById('notifPrefsForm');
    const subChecks = document.querySelectorAll('.notif-sub-check');

    function syncSubPane() {
        if (master.checked) {
            subPane.classList.remove('notif-subprefs-disabled');
            subChecks.forEach(c => c.disabled = false);
        } else {
            subPane.classList.add('notif-subprefs-disabled');
            subChecks.forEach(c => c.disabled = true);
        }
    }

    syncSubPane();

    master.addEventListener('change', function () {
        if (!master.checked) {
            syncSubPane();
            return;
        }

        if (!('Notification' in window) || !('serviceWorker' in navigator)) {
            banner.textContent = 'Tu navegador no soporta notificaciones push.';
            banner.className = 'notif-perm-banner notif-perm-warn';
            banner.style.display = '';
            master.checked = false;
            syncSubPane();
            return;
        }

        const perm = Notification.permission;

        if (perm === 'granted') {
            syncSubPane();
            banner.style.display = 'none';
            return;
        }

        if (perm === 'denied') {
            banner.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i>El navegador bloqueó los permisos. Actívalos en <strong>Configuración del navegador → Privacidad → Notificaciones</strong> para este sitio.';
            banner.className = 'notif-perm-banner notif-perm-warn';
            banner.style.display = '';
            master.checked = false;
            syncSubPane();
            return;
        }

        Notification.requestPermission().then(function (result) {
            if (result === 'granted') {
                syncSubPane();
                banner.style.display = 'none';
                if (typeof AppPushNotifications !== 'undefined') {
                    AppPushNotifications.subscribe().catch(function () {});
                }
            } else {
                banner.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i>Permiso denegado. Para recibirlas, activa las notificaciones en la configuración de tu navegador o sistema operativo.';
                banner.className = 'notif-perm-banner notif-perm-warn';
                banner.style.display = '';
                master.checked = false;
                syncSubPane();
            }
        });
    });

    <?php if ($push_prefs['push_enabled']): ?>
    if ('Notification' in window && Notification.permission === 'default') {
        banner.innerHTML = '<i class="fa-solid fa-circle-info me-2"></i>Tienes las notificaciones activadas pero no has concedido el permiso en este navegador. Haz clic en el switch para que aparezca el diálogo.';
        banner.className = 'notif-perm-banner notif-perm-info';
        banner.style.display = '';
    }
    if ('Notification' in window && Notification.permission === 'denied') {
        banner.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i>El permiso está bloqueado en este navegador. Para activarlas, ve a <strong>Configuración del navegador → Notificaciones</strong> y permite este sitio.';
        banner.className = 'notif-perm-banner notif-perm-warn';
        banner.style.display = '';
    }
    <?php endif; ?>
})();
</script>

<style>
.ui-avatar-picker {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-top: .75rem;
    flex-direction: column;
}

.ui-avatar-options {
    display: grid;
    gap: .7rem;
    width: 100%;
}

.ui-avatar-group,
.ui-color-group {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .35rem;
}

.ui-user-title {
    align-items: center;
}

.ui-user-header-avatar {
    width: 78px;
    height: 78px;
    min-width: 78px;
    border-radius: 999px;
    display: inline-grid;
    place-items: center;
    color: #ffffff;
    font-size: 2rem;
    box-shadow: 0 14px 28px rgba(15, 23, 42, .22);
}

.ui-user-header-avatar-admin {
    border: 4px solid #f59e0b;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, .18), 0 14px 28px rgba(15, 23, 42, .22);
}

.ui-avatar-square,
.ui-color-square {
    position: relative;
    width: 38px;
    height: 38px;
    cursor: pointer;
}

.ui-avatar-square input,
.ui-color-square input {
    position: absolute;
    opacity: 0;
    inset: 0;
}

.ui-avatar-square span,
.ui-color-square span {
    width: 38px;
    height: 38px;
    display: grid;
    place-items: center;
    border-radius: 7px;
    border: 2px solid rgba(15, 23, 42, .16);
    box-shadow: 0 1px 4px rgba(15, 23, 42, .12);
    transition: transform .15s ease, border-color .15s ease, box-shadow .15s ease;
}

.ui-avatar-square span {
    background: #f8fafc;
    color: #14345f;
    font-size: 1.15rem;
}

.ui-color-square span {
    color: #111827;
}

.ui-avatar-square input:checked + span,
.ui-color-square input:checked + span {
    border-color: #111827;
    box-shadow: 0 0 0 3px rgba(17, 24, 39, .18);
    transform: translateY(-1px);
}

.ui-avatar-admin-square span {
    border-color: #f59e0b;
    box-shadow: 0 0 0 2px rgba(245, 158, 11, .25), 0 1px 4px rgba(15, 23, 42, .12);
}

.ui-avatar-admin-square input:checked + span {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, .35), 0 10px 18px rgba(245, 158, 11, .18);
}

.ui-color-square input:checked + span::after {
    content: "\f00c";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-size: 1.05rem;
    color: #111827;
    text-shadow: 0 1px 2px rgba(255, 255, 255, .45);
}

.ui-avatar-preview-wrap {
    flex: 0 0 auto;
}

.ui-avatar-preview {
    width: 86px;
    height: 86px;
    aspect-ratio: 1/1;
    border-radius: 999px;
    padding: 0;
    box-sizing: border-box;
    display: grid;
    place-items: center;
    color: #ffffff;
    font-size: 2.6rem;
    box-shadow: 0 16px 30px rgba(15, 23, 42, .22);
}

.ui-avatar-preview-admin {
    border: 4px solid #f59e0b;
    padding: 0;
    box-sizing: border-box;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, .18), 0 16px 30px rgba(15, 23, 42, .22);
}

@media (max-width: 575.98px) {
    .ui-avatar-picker {
        align-items: flex-start;
        flex-direction: column;
    }
    
    .ui-avatar-preview {
        width: 86px;
        height: 86px;
        aspect-ratio: 1/1;
        border-radius: 999px;
    }
    
    .ui-avatar-preview-admin {
        width: 86px;
        height: 86px;
        aspect-ratio: 1/1;
        border-radius: 999px;
    }
}

body.theme-dark .ui-settings-card,
body.theme-dark .ui-settings-card .user-check {
    background: #172033 !important;
    color: #e5edf8 !important;
    border-color: rgba(147, 197, 253, .32) !important;
}

body.theme-dark .ui-settings-card .user-check strong,
body.theme-dark .ui-settings-card h3 {
    color: #f8fafc !important;
}

body.theme-dark .ui-settings-card p,
body.theme-dark .ui-settings-card .form-label,
body.theme-dark .ui-settings-card .auth-helper {
    color: #cbd5e1 !important;
}

body.theme-dark .ui-avatar-square span {
    background: #0f172a;
    color: #dbeafe;
    border-color: rgba(147, 197, 253, .28);
}

body.theme-dark .ui-avatar-square input:checked + span,
body.theme-dark .ui-color-square input:checked + span {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(147, 197, 253, .2);
}

.password-toggle-group .login-input {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.password-toggle-btn {
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
    min-width: 48px;
}

body.theme-dark .password-toggle-btn {
    background: #172033;
    color: #dbeafe;
    border-color: var(--app-border);
}

/* ── Notif prefs ── */
.notif-prefs-list {
    display: flex;
    flex-direction: column;
    gap: 0;
    border: 1.5px solid var(--app-border, rgba(15,23,42,.12));
    border-radius: 14px;
    overflow: hidden;
    margin-top: .25rem;
}

.notif-pref-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: .9rem 1.1rem;
    border-bottom: 1px solid var(--app-border, rgba(15,23,42,.08));
    background: transparent;
    transition: background .15s;
}

.notif-pref-row:last-child { border-bottom: none; }
.notif-pref-master { background: var(--app-blue-soft, #eef5ff); }

.notif-pref-info {
    display: flex;
    align-items: center;
    gap: .75rem;
    min-width: 0;
}

.notif-pref-info > div {
    display: flex;
    flex-direction: column;
    gap: .15rem;
}

.notif-pref-info strong {
    font-size: .93rem;
    line-height: 1.3;
}

.notif-pref-desc {
    font-size: .78rem;
    color: var(--app-muted, #64748b);
    line-height: 1.35;
}

.notif-pref-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 9px;
    display: grid;
    place-items: center;
    font-size: .95rem;
    background: var(--app-blue-soft, #eef5ff);
    color: var(--app-blue, #2563eb);
}

.notif-pref-icon-cal  { background: #e0f2fe; color: #0284c7; }
.notif-pref-icon-bit  { background: #fef9c3; color: #a16207; }
.notif-pref-icon-dolor{ background: #fce7f3; color: #be185d; }
.notif-pref-icon-sis  { background: #dcfce7; color: #15803d; }

.notif-subprefs { transition: opacity .2s; }
.notif-subprefs-disabled { opacity: .38; pointer-events: none; }

/* Toggle switch */
.notif-toggle {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 26px;
    min-width: 46px;
    cursor: pointer;
    flex-shrink: 0;
}

.notif-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.notif-toggle-slider {
    position: absolute;
    inset: 0;
    background: #cbd5e1;
    border-radius: 999px;
    transition: background .18s;
}

.notif-toggle-slider::before {
    content: '';
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 4px rgba(15,23,42,.18);
    transition: transform .18s;
}

.notif-toggle input:checked + .notif-toggle-slider {
    background: #2563eb;
}

.notif-toggle input:checked + .notif-toggle-slider::before {
    transform: translateX(20px);
}

/* Banner */
.notif-perm-banner {
    border-radius: 10px;
    padding: .7rem 1rem;
    font-size: .84rem;
    margin-top: .75rem;
    line-height: 1.45;
}

.notif-perm-info { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.notif-perm-warn { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

/* Dark mode */
body.theme-dark .notif-prefs-list,
body.ui-nocturno .notif-prefs-list {
    border-color: rgba(147,197,253,.2) !important;
}

body.theme-dark .notif-pref-master,
body.ui-nocturno .notif-pref-master {
    background: rgba(37,99,235,.12) !important;
}

body.theme-dark .notif-pref-row,
body.ui-nocturno .notif-pref-row {
    border-color: rgba(147,197,253,.12) !important;
}

body.theme-dark .notif-pref-desc,
body.ui-nocturno .notif-pref-desc {
    color: #94a3b8 !important;
}

body.theme-dark .notif-pref-icon,
body.ui-nocturno .notif-pref-icon {
    background: rgba(37,99,235,.18) !important;
    color: #93c5fd !important;
}

body.theme-dark .notif-pref-icon-cal,
body.ui-nocturno .notif-pref-icon-cal  { background: rgba(2,132,199,.18) !important; color: #7dd3fc !important; }
body.theme-dark .notif-pref-icon-bit,
body.ui-nocturno .notif-pref-icon-bit  { background: rgba(161,98,7,.18) !important; color: #fde68a !important; }
body.theme-dark .notif-pref-icon-dolor,
body.ui-nocturno .notif-pref-icon-dolor{ background: rgba(190,24,93,.18) !important; color: #fbcfe8 !important; }
body.theme-dark .notif-pref-icon-sis,
body.ui-nocturno .notif-pref-icon-sis  { background: rgba(21,128,61,.18) !important; color: #86efac !important; }

body.theme-dark .notif-toggle-slider,
body.ui-nocturno .notif-toggle-slider { background: #334155; }

body.theme-dark .notif-perm-info,
body.ui-nocturno .notif-perm-info { background: rgba(37,99,235,.14); color: #93c5fd; border-color: rgba(147,197,253,.25); }

body.theme-dark .notif-perm-warn,
body.ui-nocturno .notif-perm-warn { background: rgba(194,65,12,.14); color: #fca5a5; border-color: rgba(252,165,110,.25); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('uiAvatarPreview');
    const headerAvatar = document.getElementById('uiUserHeaderAvatar');
    const iconInputs = document.querySelectorAll('input[name="ui_icono"]');
    const colorInputs = document.querySelectorAll('input[name="ui_icono_color"]');
    const isAdmin = <?= $es_admin_ui ? 'true' : 'false' ?>;

    function updateAvatarPreview() {
        if (!preview && !headerAvatar) return;

        const selectedIcon = document.querySelector('input[name="ui_icono"]:checked');
        const selectedColor = document.querySelector('input[name="ui_icono_color"]:checked');
        const icon = selectedIcon ? selectedIcon.value : 'fa-user-doctor';
        const color = selectedColor ? selectedColor.dataset.color : '#2e9b55';

        if (preview) {
            preview.style.background = color;
            preview.innerHTML = '<i class="fa-solid ' + icon.replace(/[^a-z0-9-]/gi, '') + '"></i>';
            preview.classList.toggle('ui-avatar-preview-admin', isAdmin);
        }

        if (headerAvatar) {
            headerAvatar.style.background = color;
            headerAvatar.innerHTML = '<i class="fa-solid ' + icon.replace(/[^a-z0-9-]/gi, '') + '"></i>';
            headerAvatar.classList.toggle('ui-user-header-avatar-admin', isAdmin);
        }
    }

    iconInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });

    colorInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });

    document.querySelectorAll('.password-toggle-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const group = this.closest('.password-toggle-group');
            const input = group ? group.querySelector('input') : null;
            const icon = this.querySelector('i');

            if (!input || !icon) return;

            const showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !showPassword);
            icon.classList.toggle('fa-eye-slash', showPassword);
            this.setAttribute('aria-label', showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });
    });

    const passwordForm = document.getElementById('passwordChangeForm');
    if (passwordForm) {
        const newPassword = passwordForm.querySelector('input[name="pass_nueva"]');
        const repeatPassword = passwordForm.querySelector('input[name="pass_nueva2"]');

        function validatePasswordMatch() {
            if (!newPassword || !repeatPassword) return true;
            const matches = repeatPassword.value === '' || newPassword.value === repeatPassword.value;
            repeatPassword.setCustomValidity(matches ? '' : 'Las contraseñas no coinciden.');
            return matches;
        }

        if (newPassword && repeatPassword) {
            newPassword.addEventListener('input', validatePasswordMatch);
            repeatPassword.addEventListener('input', validatePasswordMatch);
            passwordForm.addEventListener('submit', function(event) {
                if (!validatePasswordMatch()) {
                    event.preventDefault();
                    repeatPassword.reportValidity();
                    repeatPassword.focus();
                }
            });
        }
    }
});
</script>

<?php
if (isset($conexion_ui) && $conexion_ui instanceof mysqli) {
    $conexion_ui->close();
}
if (isset($conexion) && $conexion instanceof mysqli) {
    $conexion->close();
}
require('footer.php');
?>
