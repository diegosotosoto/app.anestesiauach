<?php
if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    header('Location: login.php');
    exit;
}

require('conectar.php');
require_once(__DIR__ . '/app_text_helpers.php');

$conexion_ui = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion_ui->set_charset('utf8mb4');

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

$email_usuario = trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']);
$columna_ui_existe = ui_columna_existe($conexion_ui, 'ui_modo');
$columna_nav_existe = ui_columna_existe($conexion_ui, 'ui_nav_posicion');
$columna_icono_existe = ui_columna_existe($conexion_ui, 'ui_icono');
$columna_icono_color_existe = ui_columna_existe($conexion_ui, 'ui_icono_color');
$columna_verified_email_existe = ui_columna_existe($conexion_ui, 'verified_email');
$mensaje_ok = '';
$mensaje_error = '';
$usuario = null;

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

if (!$usuario) {
    header('Location: login.php');
    exit;
}

$modo_actual = in_array((string)($usuario['ui_modo'] ?? 'normal'), ui_modos_validos(), true) ? (string)$usuario['ui_modo'] : 'normal';
$nav_actual = in_array((string)($usuario['ui_nav_posicion'] ?? 'left'), ['left', 'right'], true) ? (string)$usuario['ui_nav_posicion'] : 'left';
$es_admin_ui = (int)($usuario['admin'] ?? 0) === 1;
$iconos_permitidos_usuario = $es_admin_ui ? array_merge(ui_iconos_validos(), ui_iconos_admin_validos()) : ui_iconos_validos();
$icono_actual = in_array((string)($usuario['ui_icono'] ?? 'fa-user-doctor'), $iconos_permitidos_usuario, true) ? (string)$usuario['ui_icono'] : 'fa-user-doctor';
$icono_color_actual = in_array((string)($usuario['ui_icono_color'] ?? 'green'), ui_colores_icono_validos(), true) ? (string)$usuario['ui_icono_color'] : 'green';
$icono_actual_admin = in_array($icono_actual, ui_iconos_admin_validos(), true);

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
                    $icono_actual_admin = in_array($icono_actual, ui_iconos_admin_validos(), true);
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
                <div class="user-check"><strong>Validación admin:</strong> <?= ((int)$usuario['verified'] === 1 ? 'Activa' : 'Pendiente') ?></div>
                <div class="user-check"><strong>Email verificado:</strong> <?= ((int)($usuario['verified_email'] ?? 0) === 1 ? 'Sí' : 'No') ?></div>
            </div>
        </section>

        <form method="post" action="configuracion_ui.php" class="app-card ui-settings-card" autocomplete="off">
            <input type="hidden" name="config_action" value="password">
            <div class="app-card-title">
                <span class="app-icon-circle"><i class="fa-solid fa-key"></i></span>
                <div>
                    <h3>Cambiar contraseña</h3>
                    <p>Solicita tu contraseña actual y luego confirma la nueva. Se enviará una notificación por correo.</p>
                </div>
            </div>
            <div class="login-form-box">
                <div class="mb-3"><label class="form-label text-muted">Contraseña actual</label><input type="password" name="pass_actual" class="form-control login-input" required></div>
                <div class="mb-3"><label class="form-label text-muted">Nueva contraseña</label><input type="password" name="pass_nueva" class="form-control login-input" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$"></div>
                <div class="mb-3"><label class="form-label text-muted">Repetir nueva contraseña</label><input type="password" name="pass_nueva2" class="form-control login-input" required></div>
                <div class="auth-helper auth-full">Contraseña de 8 a 12 caracteres, incluyendo una mayúscula, un número y un símbolo (!@#$%^&*_=+-)</div>
                <div class="admin-actions auth-full"><button type="submit" class="btn btn-app-primary"><i class="fa-solid fa-floppy-disk"></i> Cambiar contraseña</button></div>
            </div>
        </form>

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
    </main>
</div>

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
    border-radius: 18px;
    display: grid;
    place-items: center;
    color: #ffffff;
    font-size: 2.6rem;
    box-shadow: 0 16px 30px rgba(15, 23, 42, .22);
}

.ui-avatar-preview-admin {
    border: 4px solid #f59e0b;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, .18), 0 16px 30px rgba(15, 23, 42, .22);
}

@media (max-width: 575.98px) {
    .ui-avatar-picker {
        align-items: flex-start;
        flex-direction: column;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('uiAvatarPreview');
    const headerAvatar = document.getElementById('uiUserHeaderAvatar');
    const iconInputs = document.querySelectorAll('input[name="ui_icono"]');
    const colorInputs = document.querySelectorAll('input[name="ui_icono_color"]');

    function updateAvatarPreview() {
        if (!preview && !headerAvatar) return;

        const selectedIcon = document.querySelector('input[name="ui_icono"]:checked');
        const selectedColor = document.querySelector('input[name="ui_icono_color"]:checked');
        const icon = selectedIcon ? selectedIcon.value : 'fa-user-doctor';
        const color = selectedColor ? selectedColor.dataset.color : '#2e9b55';

        if (preview) {
            preview.style.background = color;
            preview.innerHTML = '<i class="fa-solid ' + icon.replace(/[^a-z0-9-]/gi, '') + '"></i>';
            preview.classList.toggle('ui-avatar-preview-admin', icon === 'fa-hat-wizard' || icon === 'fa-crown');
        }

        if (headerAvatar) {
            headerAvatar.style.background = color;
            headerAvatar.innerHTML = '<i class="fa-solid ' + icon.replace(/[^a-z0-9-]/gi, '') + '"></i>';
            headerAvatar.classList.toggle('ui-user-header-avatar-admin', icon === 'fa-hat-wizard' || icon === 'fa-crown');
        }
    }

    iconInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });

    colorInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });
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
