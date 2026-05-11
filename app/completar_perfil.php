<?php
require('conectar.php');
require_once(__DIR__ . '/app_text_helpers.php');
require_once(__DIR__ . '/app_security.php');

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

app_require_login($conexion, 'login.php');

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function ui_iconos_validos() {
    return ['fa-user', 'fa-user-astronaut', 'fa-user-doctor', 'fa-user-graduate', 'fa-user-ninja', 'fa-user-tie', 'fa-person-dress', 'fa-snowman', 'fa-head-side-mask', 'fa-skull', 'fa-poo', 'fa-user-secret', 'fa-brain', 'fa-ghost', 'fa-cat', 'fa-dog', 'fa-spider', 'fa-horse-head'];
}

function ui_colores_icono_validos() {
    return ['blue', 'green', 'red', 'yellow', 'orange', 'purple', 'teal', 'pink', 'cyan', 'indigo', 'slate', 'black'];
}

function ui_columna_existe($conexion, $columna) {
    $columna_db = $conexion->real_escape_string($columna);
    $res = $conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE '$columna_db'");
    return $res && $res->num_rows > 0;
}

$usuario = app_current_user($conexion);

if (!$usuario) {
    header('Location: login.php');
    exit;
}

$email_usuario = trim((string)$usuario['email_usuario']);
$columna_icono_existe = ui_columna_existe($conexion, 'ui_icono');
$columna_icono_color_existe = ui_columna_existe($conexion, 'ui_icono_color');

$select_ui_icono = $columna_icono_existe ? "`ui_icono`" : "'fa-user-doctor' AS `ui_icono`";
$select_ui_icono_color = $columna_icono_color_existe ? "`ui_icono_color`" : "'green' AS `ui_icono_color`";

$stmt = $conexion->prepare("SELECT `ID`, `nombre_usuario`, $select_ui_icono, $select_ui_icono_color FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param('s', $email_usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $usuario = $res->fetch_assoc();
    $stmt->close();
}

$iconos_permitidos_usuario = ui_iconos_validos();
$icono_actual = in_array((string)($usuario['ui_icono'] ?? 'fa-user-doctor'), $iconos_permitidos_usuario, true) ? (string)$usuario['ui_icono'] : 'fa-user-doctor';
$icono_color_actual = in_array((string)($usuario['ui_icono_color'] ?? 'green'), ui_colores_icono_validos(), true) ? (string)$usuario['ui_icono_color'] : 'green';

$mensaje_ok = '';
$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_post = trim((string)($_POST['nombre_usuario'] ?? ''));
    $icono_post = (string)($_POST['ui_icono'] ?? 'fa-user-doctor');
    $icono_color_post = (string)($_POST['ui_icono_color'] ?? 'green');
    
    // Validar nombre
    if (empty($nombre_post) || !preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}$/', $nombre_post)) {
        $mensaje_error = 'El nombre y apellido debe tener al menos 2 caracteres y solo puede contener letras y espacios.';
    } else {
        // Convertir nombre a formato título
        $nombre_formateado = mb_convert_case(mb_strtolower($nombre_post, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
        
        // Validar icono y color
        if (!in_array($icono_post, $iconos_permitidos_usuario, true)) {
            $icono_post = 'fa-user-doctor';
        }
        if (!in_array($icono_color_post, ui_colores_icono_validos(), true)) {
            $icono_color_post = 'green';
        }
        
        // Actualizar nombre
        $stmt_nombre = $conexion->prepare("UPDATE `usuarios_dolor` SET `nombre_usuario` = ? WHERE `email_usuario` = ? LIMIT 1");
        if ($stmt_nombre) {
            $stmt_nombre->bind_param('ss', $nombre_formateado, $email_usuario);
            if ($stmt_nombre->execute()) {
                $usuario['nombre_usuario'] = $nombre_formateado;
            } else {
                $mensaje_error = 'No fue posible actualizar el nombre.';
            }
            $stmt_nombre->close();
        }
        
        // Actualizar icono si las columnas existen
        if ($columna_icono_existe || $columna_icono_color_existe) {
            if ($columna_icono_existe && $columna_icono_color_existe) {
                $stmt_icono = $conexion->prepare("UPDATE `usuarios_dolor` SET `ui_icono` = ?, `ui_icono_color` = ? WHERE `email_usuario` = ? LIMIT 1");
                if ($stmt_icono) {
                    $stmt_icono->bind_param('sss', $icono_post, $icono_color_post, $email_usuario);
                    if ($stmt_icono->execute()) {
                        $icono_actual = $icono_post;
                        $icono_color_actual = $icono_color_post;
                        $mensaje_ok = 'Perfil actualizado correctamente.';
                    } else {
                        $mensaje_error = 'No fue posible actualizar el icono.';
                    }
                    $stmt_icono->close();
                }
            } elseif ($columna_icono_existe) {
                $stmt_icono = $conexion->prepare("UPDATE `usuarios_dolor` SET `ui_icono` = ? WHERE `email_usuario` = ? LIMIT 1");
                if ($stmt_icono) {
                    $stmt_icono->bind_param('ss', $icono_post, $email_usuario);
                    if ($stmt_icono->execute()) {
                        $icono_actual = $icono_post;
                        $mensaje_ok = 'Perfil actualizado correctamente.';
                    } else {
                        $mensaje_error = 'No fue posible actualizar el icono.';
                    }
                    $stmt_icono->close();
                }
            } elseif ($columna_icono_color_existe) {
                $stmt_icono = $conexion->prepare("UPDATE `usuarios_dolor` SET `ui_icono_color` = ? WHERE `email_usuario` = ? LIMIT 1");
                if ($stmt_icono) {
                    $stmt_icono->bind_param('ss', $icono_color_post, $email_usuario);
                    if ($stmt_icono->execute()) {
                        $icono_color_actual = $icono_color_post;
                        $mensaje_ok = 'Perfil actualizado correctamente.';
                    } else {
                        $mensaje_error = 'No fue posible actualizar el icono.';
                    }
                    $stmt_icono->close();
                }
            }
        } else {
            $mensaje_ok = 'Perfil actualizado correctamente.';
        }
        
        // Redirigir a index.php si no hay errores
        if ($mensaje_ok !== '') {
            $conexion->close();
            header('Location: index.php');
            exit;
        }
    }
}

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

$boton_toggler = "<button class='navbar-toggler app-nav-toggle' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'><i class='fa-solid fa-bars'></i></button>";
$titulo_navbar = "<div class='app-navbar-brand app-navbar-brand-compact'><img src='images/austral.png' alt='Universidad Austral de Chile' />Anestesia <small>UACh</small></div>";
$boton_navbar = "<a></a>";

require('head.php');
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">
        <div class="login-shell">

        <div class="about-card about-welcome-card mb-3">

          <div class="about-welcome-body">
            <div class="about-section-title text-center">Completar Perfil</div>

            <h2 class="about-welcome-title">
              Bienvenido a Anestesia UACh
            </h2>

            <div class="about-title-line"></div>

            <p class="about-welcome-text">
              Para comenzar, por favor completa tu perfil con tu nombre y apellido y elige un icono de usuario.
            </p>

          </div>
        </div>

        <?php if ($mensaje_ok !== ''): ?>
            <div class="alert alert-success alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><strong>Listo:</strong> <?= h($mensaje_ok) ?></div>
        <?php endif; ?>

        <?php if ($mensaje_error !== ''): ?>
            <div class="alert alert-danger alert-dismissible fade show"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><strong>Error:</strong> <?= h($mensaje_error) ?></div>
        <?php endif; ?>

        <form class="needs-validation" action="completar_perfil.php" method="post" novalidate autocomplete="off">
          <section class="about-card login-panel-card mb-3">
            <div class="login-card-body">

                <div class="mb-3">
                  <label class="form-label text-muted pb-0 mb-0">Nombre y Apellido</label><div class="auth-helper auth-full">(Como aparecerá en registro oficial de la App)</div>
                  <div class="input-group">
                    <input type="text" name="nombre_usuario" class="form-control login-input" pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' required value="<?= h($usuario['nombre_usuario'] ?? '') ?>">
                    <span class="input-group-text app-input-addon login-addon"><i class="fa fa-user"></i></span>
                  </div>
                </div>

                <div class="mb-4 auth-full">
                  <div class="about-closing">
                    <strong>Icono de usuario</strong>
                  </div>
                  <p class="text-muted small">Elige el icono y color que se mostrará en tu perfil.</p>
                  
                  <div class="ui-avatar-picker">
                    <div id="uiAvatarPreview" class="ui-avatar-preview" style="background: <?= h($opciones_icono_color[$icono_color_actual] ?? '#2e9b55') ?>;">
                      <i class="fa-solid <?= h($icono_actual) ?>"></i>
                    </div>
                    
                    <div class="ui-avatar-options">
                      <div class="ui-avatar-group" role="radiogroup" aria-label="Icono de usuario">
                        <?php foreach ($iconos_permitidos_usuario as $icono_opcion): ?>
                          <label class="ui-avatar-square">
                            <input type="radio" name="ui_icono" value="<?= h($icono_opcion) ?>" <?= $icono_actual === $icono_opcion ? 'checked' : '' ?> <?= !$columna_icono_existe ? 'disabled' : '' ?>>
                            <span><i class="fa-solid <?= h($icono_opcion) ?>"></i></span>
                          </label>
                        <?php endforeach; ?>
                      </div>

                      <div class="ui-color-group" role="radiogroup" aria-label="Color del icono de usuario">
                        <?php foreach ($opciones_icono_color as $color_key => $color_hex): ?>
                          <label class="ui-color-square">
                            <input type="radio" name="ui_icono_color" value="<?= h($color_key) ?>" data-color="<?= h($color_hex) ?>" <?= $icono_color_actual === $color_key ? 'checked' : '' ?> <?= !$columna_icono_color_existe ? 'disabled' : '' ?>>
                            <span style="background: <?= h($color_hex) ?>;"></span>
                          </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="pt-3 text-center auth-full">
                  <button type="submit" class="btn btn-app-primary login-submit">
                    <i class="fa-solid fa-check-to-slot pe-2"></i>Guardar y Continuar
                  </button>
                </div>
              </div>
            </div>
          </section>
        </form>

        </div>
      </div>
    </div>
  </div>
</div>

<style>
.ui-avatar-picker {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-top: .75rem;
    flex-direction: row;
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

.ui-color-square input:checked + span::after {
    content: "\f00c";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-size: 1.05rem;
    color: #111827;
    text-shadow: 0 1px 2px rgba(255, 255, 255, .45);
}

.ui-avatar-preview {
    width: 86px;
    height: 86px;
    aspect-ratio: 1/1;
    border-radius: 999px;
    display: grid;
    place-items: center;
    color: #ffffff;
    font-size: 2.6rem;
    box-shadow: 0 16px 30px rgba(15, 23, 42, .22);
    flex: 0 0 auto;
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
    const iconInputs = document.querySelectorAll('input[name="ui_icono"]');
    const colorInputs = document.querySelectorAll('input[name="ui_icono_color"]');

    function updateAvatarPreview() {
        if (!preview) return;

        const selectedIcon = document.querySelector('input[name="ui_icono"]:checked');
        const selectedColor = document.querySelector('input[name="ui_icono_color"]:checked');
        const icon = selectedIcon ? selectedIcon.value : 'fa-user-doctor';
        const color = selectedColor ? selectedColor.dataset.color : '#2e9b55';

        preview.style.background = color;
        preview.innerHTML = '<i class="fa-solid ' + icon.replace(/[^a-z0-9-]/gi, '') + '"></i>';
    }

    iconInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });

    colorInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });
    
    // Validación del formulario
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});
</script>

<?php
if (isset($conexion) && $conexion instanceof mysqli) {
    $conexion->close();
}
require('footer.php');
?>
