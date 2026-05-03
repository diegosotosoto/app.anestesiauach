<?php  //Conexión

$app_root_dir = __DIR__;
$script_dir = realpath(dirname($_SERVER['SCRIPT_FILENAME'] ?? __FILE__));
$script_dir = $script_dir ? $script_dir : $app_root_dir;
$root_path_norm = str_replace('\\', '/', $app_root_dir);
$script_path_norm = str_replace('\\', '/', $script_dir);
$relative_script_dir = '';

if (strpos($script_path_norm, $root_path_norm) === 0) {
  $relative_script_dir = trim(substr($script_path_norm, strlen($root_path_norm)), '/');
}

$script_depth = $relative_script_dir === '' ? 0 : count(explode('/', $relative_script_dir));
$is_apuntes_context = $relative_script_dir === 'apuntes';
$app_path_prefix = str_repeat('../', $script_depth);

function app_path($path) {
  global $app_path_prefix;
  return $app_path_prefix . ltrim((string)$path, '/');
}

function app_nav_url($path) {
  $path = (string)$path;
  if ($path === '' || preg_match('~^(https?:)?//|^mailto:|^tel:|^#~i', $path)) {
    return $path;
  }
  return app_path($path);
}

function app_asset_version($path) {
  global $app_root_dir;
  $full_path = $app_root_dir . '/' . ltrim((string)$path, '/');
  return @filemtime($full_path) ?: time();
}

function app_css_link($path) {
  return '<link rel="stylesheet" href="' . htmlspecialchars(app_path($path)) . '?v=' . app_asset_version($path) . '"/>';
}

function app_page_module_css_files() {
  global $relative_script_dir;
  $page = basename((string)($_SERVER['SCRIPT_FILENAME'] ?? ''));
  $modules = [];

  if ($page === 'apuntes.php') {
    $modules[] = 'css/module-calculos-apuntes.css';
  }

  if (in_array($page, ['hoja_dolor.php', 'nuevo_paciente.php', 'editar_paciente.php', 'vista_paciente.php', 'nueva_visita.php', 'listar_visitas.php', 'vista_visitas.php'], true)) {
    $modules[] = 'css/module-pacientes-dolor.css';
  }

  if (strpos($page, 'bitacora') === 0 || in_array($page, ['lista_bitacoras.php', 'gestion_bitacora.php'], true)) {
    $modules[] = 'css/module-bitacora.css';
  }

  if (strpos($page, 'admin_') === 0 || strpos($page, 'gestion_') === 0 || $page === 'configuracion_ui.php') {
    $modules[] = 'css/admin-system.css';
  }

  if (in_array($page, ['calendario.php', 'admin_calendarios.php', 'admin_notificaciones.php'], true)) {
    $modules[] = 'css/module-calendarios-notificaciones.css';
  }

  if (strpos($page, 'epa') !== false || in_array($page, ['formulario_epa.php', 'vista_epa.php', 'vista_epa_detalle.php', 'editar_epa.php', 'nueva_epa.php'], true)) {
    $modules[] = 'css/module-epa.css';
  }

  if (in_array($page, ['links.php', 'telefonos.php', 'correos.php', 'acerca_de.php'], true)) {
    $modules[] = 'css/module-otros.css';
  }

  return array_values(array_unique($modules));
}

require($app_root_dir . "/conectar.php");
require_once($app_root_dir . "/app_text_helpers.php");

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

$conexion->set_charset("utf8mb4");

require($app_root_dir . "/notificaciones_head.php");

function app_head_safe_text($value) {
  return app_h_text($value);
}

function app_ui_valid_modes() {
  return ['normal', 'nocturno', 'daltonico'];
}

function app_ui_column_exists($conexion) {
  if (!$conexion) {
    return false;
  }

  $res = $conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE 'ui_modo'");
  return $res && $res->num_rows > 0;
}

function app_ui_nav_column_exists($conexion) {
  if (!$conexion) {
    return false;
  }

  $res = $conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE 'ui_nav_posicion'");
  return $res && $res->num_rows > 0;
}

function app_ui_user_icon_columns_exist($conexion) {
  if (!$conexion) {
    return false;
  }

  $res_icono = $conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE 'ui_icono'");
  $res_color = $conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE 'ui_icono_color'");
  return $res_icono && $res_icono->num_rows > 0 && $res_color && $res_color->num_rows > 0;
}

function app_ui_valid_user_icons() {
  return ['fa-user', 'fa-user-astronaut', 'fa-user-doctor', 'fa-user-graduate', 'fa-user-ninja', 'fa-user-tie', 'fa-person-dress', 'fa-snowman', 'fa-head-side-mask', 'fa-skull', 'fa-poo', 'fa-user-secret', 'fa-brain', 'fa-ghost', 'fa-cat', 'fa-dog', 'fa-spider', 'fa-horse-head'];
}

function app_ui_admin_user_icons() {
  return ['fa-hat-wizard', 'fa-crown'];
}

function app_ui_user_icon_colors() {
  return [
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
}

function app_ui_get_user_mode($conexion) {
  $ui_modo = 'normal';

  if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    return $ui_modo;
  }

  if (!app_ui_column_exists($conexion)) {
    return $ui_modo;
  }

  $email_usuario = trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']);
  $stmt = $conexion->prepare("SELECT `ui_modo` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");

  if ($stmt) {
    $stmt->bind_param("s", $email_usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
      $ui_modo = (string)($row['ui_modo'] ?? 'normal');
    }

    $stmt->close();
  }

  return in_array($ui_modo, app_ui_valid_modes(), true) ? $ui_modo : 'normal';
}

function app_ui_get_nav_position($conexion) {
  $ui_nav_posicion = 'left';

  if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    return $ui_nav_posicion;
  }

  if (!app_ui_nav_column_exists($conexion)) {
    return $ui_nav_posicion;
  }

  $email_usuario = trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']);
  $stmt = $conexion->prepare("SELECT `ui_nav_posicion` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");

  if ($stmt) {
    $stmt->bind_param("s", $email_usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
      $ui_nav_posicion = (string)($row['ui_nav_posicion'] ?? 'left');
    }

    $stmt->close();
  }

  return in_array($ui_nav_posicion, ['left', 'right'], true) ? $ui_nav_posicion : 'left';
}

function app_ui_get_user_icon_config($conexion) {
  $config = ['icon' => 'fa-user-doctor', 'color' => '#2e9b55', 'admin_icon' => false];

  if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) || trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']) === '') {
    return $config;
  }

  if (!app_ui_user_icon_columns_exist($conexion)) {
    return $config;
  }

  $email_usuario = trim((string)$_COOKIE['hkjh41lu4l1k23jhlkj13']);
  $stmt = $conexion->prepare("SELECT `ui_icono`, `ui_icono_color`, `admin` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");

  if ($stmt) {
    $stmt->bind_param("s", $email_usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
      $icono = (string)($row['ui_icono'] ?? 'fa-user-doctor');
      $color_key = (string)($row['ui_icono_color'] ?? 'green');
      $colores = app_ui_user_icon_colors();
      $es_admin = (int)($row['admin'] ?? 0) === 1;
      $iconos_permitidos = $es_admin ? array_merge(app_ui_valid_user_icons(), app_ui_admin_user_icons()) : app_ui_valid_user_icons();

      if (in_array($icono, $iconos_permitidos, true)) {
        $config['icon'] = $icono;
        $config['admin_icon'] = in_array($icono, app_ui_admin_user_icons(), true);
      }

      if (array_key_exists($color_key, $colores)) {
        $config['color'] = $colores[$color_key];
      }
    }

    $stmt->close();
  }

  return $config;
}

function app_render_user_inline_icon($user_row, $class = 'app-inline-user-icon') {
  $config = ['icon' => 'fa-user-doctor', 'color' => '#2e9b55', 'admin_icon' => false];
  $icono = (string)($user_row['ui_icono'] ?? 'fa-user-doctor');
  $color_key = (string)($user_row['ui_icono_color'] ?? 'green');
  $es_admin = (int)($user_row['admin'] ?? 0) === 1;
  $iconos_permitidos = $es_admin ? array_merge(app_ui_valid_user_icons(), app_ui_admin_user_icons()) : app_ui_valid_user_icons();
  $colores = app_ui_user_icon_colors();

  if (in_array($icono, $iconos_permitidos, true)) {
    $config['icon'] = $icono;
    $config['admin_icon'] = in_array($icono, app_ui_admin_user_icons(), true);
  }

  if (array_key_exists($color_key, $colores)) {
    $config['color'] = $colores[$color_key];
  }

  $classes = trim($class . ' fa-solid ' . $config['icon'] . ($config['admin_icon'] ? ' app-inline-user-icon-admin' : ''));
  return '<i class="' . htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') . '" style="background:' . htmlspecialchars($config['color'], ENT_QUOTES, 'UTF-8') . ';"></i>';
}

function app_ui_body_classes($ui_modo, $ui_nav_posicion = 'left') {
  $sidebar_class = $ui_nav_posicion === 'right' ? 'sidebar-right' : 'sidebar-left';
  $classes = [$sidebar_class, 'font-normal', 'ui-' . $ui_modo];

  if ($ui_modo === 'nocturno') {
    $classes[] = 'theme-dark';
  }

  return implode(' ', array_map('htmlspecialchars', $classes));
}

function app_head_render_notificaciones_widget($notificaciones_nav, $total_notificaciones_no_leidas, $dropdown_side = 'end') {
  $dropdown_class = $dropdown_side === 'start' ? 'dropdown-menu-start' : 'dropdown-menu-end';
  $wrap_class = $dropdown_side === 'start' ? 'notif-dropdown-open-start' : 'notif-dropdown-open-end';
  ?>
  <div class="dropdown flex-shrink-0 notif-dropdown-wrap <?= $wrap_class ?>" id="notif-widget">
    <button class="btn btn-light position-relative btn-icon-topbar rounded-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fa-solid fa-bell"></i>

      <?php if (!empty($total_notificaciones_no_leidas) && $total_notificaciones_no_leidas > 0): ?>
        <span id="notif-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          <?= $total_notificaciones_no_leidas > 99 ? '99+' : (int)$total_notificaciones_no_leidas ?>
        </span>
      <?php endif; ?>
    </button>

    <div class="dropdown-menu <?= $dropdown_class ?> p-0 shadow notif-dropdown notif-dropdown-menu">
      <div class="notif-dropdown-header">
        <div class="notif-dropdown-title">Notificaciones</div>
        <div class="notif-dropdown-subtitle" id="notif-count-text"><?= (int)$total_notificaciones_no_leidas ?> sin leer</div>
      </div>

      <div id="notif-list" class="notif-dropdown-body">
        <?php if (!empty($notificaciones_nav)): ?>
          <?php foreach ($notificaciones_nav as $notif): ?>
            <div
              class="dropdown-item py-3 border-bottom notif-item <?= ((int)$notif['leida'] === 0 ? 'notif-unread' : '') ?>"
              data-destinatario-id="<?= htmlspecialchars((string)$notif['destinatario_id']) ?>"
              data-es-sistema="<?= !empty($notif['es_sistema']) ? '1' : '0' ?>"
            >
              <div class="d-flex align-items-start gap-2">
                <div class="pt-1">
                  <i class="<?= !empty($notif['icono']) ? htmlspecialchars($notif['icono']) : 'fa-solid fa-bell' ?>"></i>
                </div>

                <div class="flex-grow-1">
                  <div class="fw-semibold"><?= htmlspecialchars($notif['titulo']) ?></div>

                  <div class="small text-muted mb-2 notif-mensaje">
                    <?= nl2br(htmlspecialchars($notif['mensaje'])) ?>
                  </div>

                  <div class="notif-actions">
                    <?php if (!empty($notif['url_destino'])): ?>
                      <a href="<?= htmlspecialchars(app_nav_url($notif['url_destino'])) ?>" class="btn btn-sm notif-btn-primary notif-open-btn">
                        Revisar
                      </a>
                    <?php endif; ?>

                    <?php if (empty($notif['es_sistema']) && (int)$notif['leida'] === 0): ?>
                      <button type="button" class="btn btn-sm notif-btn-success notif-read-btn">
                        Marcar leída
                      </button>
                    <?php endif; ?>

                    <?php if (!empty($notif['es_sistema'])): ?>
                      <button type="button" class="btn btn-sm notif-btn-secondary notif-hide-local-btn">
                        Descartar
                      </button>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="notif-dropdown-footer">
            <div class="text-muted small" id="notif-empty-state">No tienes notificaciones.</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php
}

$app_ui_modo = app_ui_get_user_mode($conexion);
$app_ui_nav_posicion = app_ui_get_nav_position($conexion);
$app_ui_user_icon_config = app_ui_get_user_icon_config($conexion);
$app_ui_nav_is_right = $app_ui_nav_posicion === 'right';
$app_ui_offcanvas_class = $app_ui_nav_is_right ? 'offcanvas-end' : 'offcanvas-start';
$app_ui_notif_dropdown_side = $app_ui_nav_is_right ? 'end' : 'start';

if ($is_apuntes_context) {
  $archivo_actual = basename($_SERVER['PHP_SELF']);
  $archivos_excluidos = [
    'apuntes.php',
    'head.php',
    'head_apuntes.php',
    'footer.php',
    'dosis_ped_pdf.php',
    'marcar_notificacion_leida.php',
    'notificacion_accion_ajax.php'
  ];

  if (!in_array($archivo_actual, $archivos_excluidos, true)) {
    $usuario_id = 0;

    if (isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) && $_COOKIE['hkjh41lu4l1k23jhlkj13'] !== '') {
      $email_usuario_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);
      $sql_usuario = "SELECT ID
                      FROM usuarios_dolor
                      WHERE email_usuario = ?
                        AND verified = 1
                      LIMIT 1";
      $stmt_usuario = $conexion->prepare($sql_usuario);

      if ($stmt_usuario) {
        $stmt_usuario->bind_param("s", $email_usuario_cookie);
        $stmt_usuario->execute();
        $res_usuario = $stmt_usuario->get_result();

        if ($fila_usuario = $res_usuario->fetch_assoc()) {
          $usuario_id = (int)$fila_usuario['ID'];
        }

        $stmt_usuario->close();
      }
    }

    if ($usuario_id > 0) {
      $ruta_actual = 'apuntes/' . $archivo_actual;
      $sql_nota = "SELECT id
                   FROM notas
                   WHERE ruta = ?
                     AND estado = 'publicada'
                   LIMIT 1";
      $stmt_nota = $conexion->prepare($sql_nota);

      if ($stmt_nota) {
        $stmt_nota->bind_param("s", $ruta_actual);
        $stmt_nota->execute();
        $res_nota = $stmt_nota->get_result();

        if ($fila_nota = $res_nota->fetch_assoc()) {
          $nota_id = (int)$fila_nota['id'];
          $sql_vista = "INSERT INTO usuario_notas (
                          usuario_id,
                          nota_id,
                          vista_at,
                          ultima_visita_at
                        )
                        VALUES (?, ?, NOW(), NOW())
                        ON DUPLICATE KEY UPDATE
                          vista_at = COALESCE(vista_at, NOW()),
                          ultima_visita_at = NOW(),
                          updated_at = NOW()";
          $stmt_vista = $conexion->prepare($sql_vista);

          if ($stmt_vista) {
            $stmt_vista->bind_param("ii", $usuario_id, $nota_id);
            $stmt_vista->execute();
            $stmt_vista->close();
          }
        }

        $stmt_nota->close();
      }
    }
  }
}

?>

 
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#27458f">
	<meta http-equiv="Cache-control" content="no-cache">
	<title>App Anestesia UACH</title>
	<link rel="icon" type="image/x-icon" href="<?= app_path('images/favicon.ico') ?>">
	<link rel="manifest" href="<?= app_path('manifest.json') ?>"/>
	<link rel="apple-touch-icon" href="<?= app_path('images/logo192.png') ?>"/>	
    <link href="<?= app_path('css/bootstrap.min.css') ?>" rel="stylesheet"/>
	<link rel="stylesheet" href="<?= app_path('css/all.css') ?>"/>
	<link rel="stylesheet" href="<?= app_path('style.css') ?>"/>
	<link rel="stylesheet" href="<?= app_path('css/overlay.css') ?>"/>
	<link rel="stylesheet" href="<?= app_path('css/app-core.css') ?>"/>
	<link rel="stylesheet" href="<?= app_path('css/app-layout.css') ?>"/>
		<link rel="stylesheet" href="<?= app_path('css/app-components.css') ?>?v=<?= @filemtime($app_root_dir . '/css/app-components.css') ?: time() ?>"/>
	<link rel="stylesheet" href="<?= app_path('css/admin-system.css') ?>?v=<?= @filemtime($app_root_dir . '/css/admin-system.css') ?: time() ?>"/>
  <?php foreach (app_page_module_css_files() as $module_css): ?>
    <?php if ($module_css !== 'css/admin-system.css'): ?>
      <?= app_css_link($module_css) . "\n" ?>
    <?php endif; ?>
  <?php endforeach; ?>
	<link rel="stylesheet" href="<?= app_path('css/app-head.css') ?>?v=<?= @filemtime($app_root_dir . '/css/app-head.css') ?: time() ?>"/>
	<link rel="stylesheet" href="<?= app_path('css/app-footer.css') ?>?v=<?= @filemtime($app_root_dir . '/css/app-footer.css') ?: time() ?>"/>
	<link rel="stylesheet" href="<?= app_path('css/accessibility.css') ?>?v=<?= @filemtime($app_root_dir . '/css/accessibility.css') ?: time() ?>"/>
	<script src="<?= app_path('js/jquery-3.6.1.min.js') ?>"></script>
	<script src="<?= app_path('js/app-core.js') ?>"></script>
</head>
<body class="<?= app_ui_body_classes($app_ui_modo, $app_ui_nav_posicion) ?>">

<div class="container-xxl text-center px-0">
  <div class="row px-0 mx-0 app-shell-row">
    <div class="col-sm col-sm-3 col-xl-3 px-0 app-shell-left">
      <nav class="navbar navbar-expand-sm">

    <div class="container-fluid pt-3 flex-sm-column align-items-stretch">
      <div class="app-mobile-nav-actions <?= $app_ui_nav_is_right ? 'app-mobile-nav-actions-right' : 'app-mobile-nav-actions-left' ?>">
        <?php if(!$app_ui_nav_is_right): ?>
          <span class="app-mobile-back-slot"><?php if($boton_toggler){echo $boton_toggler;} ?></span>
        <?php endif; ?>

        <?php if($app_ui_nav_is_right): ?>
          <div class="d-flex d-md-none align-items-center app-mobile-notif-slot">
            <div id="notif-slot-mobile" class="me-2">
              <?php if($usuario_id_nav > 0){ app_head_render_notificaciones_widget($notificaciones_nav, $total_notificaciones_no_leidas, $app_ui_notif_dropdown_side); } ?>
            </div>
          </div>
        <?php endif; ?>

        <a class="navbar-brand d-sm-block d-sm-none app-mobile-title-slot" href="#">
          <?php if($titulo_navbar){echo $titulo_navbar;} ?>
        </a>

        <?php if(!$app_ui_nav_is_right): ?>
          <div class="d-flex d-md-none align-items-center app-mobile-notif-slot">
            <div id="notif-slot-mobile" class="ms-2">
              <?php if($usuario_id_nav > 0){ app_head_render_notificaciones_widget($notificaciones_nav, $total_notificaciones_no_leidas, $app_ui_notif_dropdown_side); } ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if($app_ui_nav_is_right): ?>
          <span class="app-mobile-back-slot"><?php if($boton_toggler){echo $boton_toggler;} ?></span>
        <?php endif; ?>
      </div>





          <div class="offcanvas <?= $app_ui_offcanvas_class ?> px-0 mx-0 bg-sidebar" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="h-100 d-flex flex-column">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title ps-4" id="offcanvasNavbarLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

              <div class="offcanvas-body">
                <div class="container text-center pb-5">
                  <div class="row ps-1 pt-3 pb-3 d-xs-none d-none d-sm-block">
                    <div class="navbar-brand"><img src="<?= app_path('images/austral_b.png') ?>" class="app-sidebar-logo" alt="Anestesia UACH"></div>
                  </div>


                  <div class='list-group' id='offcanvasExampleLabel'>





<?php if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])): ?>
  <div class="sidebar-wa-user-card">
    <div class="d-none d-md-flex sidebar-desktop-notif-corner <?= $app_ui_nav_is_right ? 'sidebar-desktop-notif-corner-right' : 'sidebar-desktop-notif-corner-left' ?>" id="notif-slot-desktop"></div>
    <div class="sidebar-user-grid">
      <div class="sidebar-user-icon-col">
        <i class="sidebar-user-icon <?= !empty($app_ui_user_icon_config['admin_icon']) ? 'sidebar-user-icon-admin' : '' ?> fa-solid <?= htmlspecialchars($app_ui_user_icon_config['icon']) ?>" style="background: <?= htmlspecialchars($app_ui_user_icon_config['color']) ?>;"></i>
      </div>

      <div class="sidebar-user-text-col">
        <h6 class="mb-1">
          <?= app_head_safe_text($_COOKIE['hkjh41lu4l1k23jhlkj14']) ?>
        </h6>
        <div class="app-user-email text-black-50">
          <?= app_head_safe_text($_COOKIE['hkjh41lu4l1k23jhlkj13']) ?>
        </div>
      </div>

      <div class="sidebar-user-config-col">
        <a href="<?= app_path('configuracion_ui.php') ?>" class="sidebar-user-config-link" aria-label="Configuración de interfaz">
          <i class="fa-solid fa-gear"></i>
        </a>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="list-group">
    <a href="<?= app_path('login.php') ?>" class="sidebar-wa-btn list-group-item list-group-item-action fs-6">
      <i class="fa-solid fa-right-to-bracket ps-2 pe-3 fs-3" data-wa-color="#44B2FF"></i>Login
    </a>
  </div>
<?php endif; ?>






                    <hr class='pt-0'>

                    <ul class='list-group pt-2'>
                      <div class='list-group'>
                        <a href='<?= app_path('index.php') ?>' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-house ps-2 pe-3 fs-3' data-wa-color='#44B2FF'></i>Inicio</a>
                      </div>

                      <?php
                        if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
                          $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
                          $staff_email=$conexion->real_escape_string($check_usuario);
                          $con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
                          $users_b=$conexion->query($con_users_b);
                          $usuario=$users_b ? $users_b->fetch_assoc() : null;


                          $escribe_badge = "";

                          if($usuario && ($usuario['admin']==1 || $usuario['staff_']==1)){
                            $query_badge="SELECT `staff_b` FROM `bitacora_proced` WHERE `staff_b` = '$staff_email' AND `aprobado_staff_b` = '0'";
                            $consutal_badge=$conexion->query($query_badge);
                            $badge = $consutal_badge ? mysqli_num_rows($consutal_badge) : 0;

                            $query_badge2="SELECT `staff_i` FROM `bitacora_internos` WHERE `staff_i` = '$staff_email' AND `aprobado_staff_i` = '0'";
                            $consutal_badge2=$conexion->query($query_badge2);
                            $badge2 = $consutal_badge2 ? mysqli_num_rows($consutal_badge2) : 0;

                            $total_badge = $badge + $badge2;

                            if($total_badge > 0){
                              $escribe_badge = "<span class='badge text-bg-danger'>".$total_badge."</span>";
                            }
                          }

                          echo "<div class='list-group'>
                            <a href='".app_path('bitacora.php')."' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3' data-wa-color='#CE2E2E'></i>Bitácora". $escribe_badge ."</a>
                          </div>";

                          echo "<div class='list-group'>
                            <a href='".app_path('apuntes.php')."' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-calculator ps-2 pe-3 fs-3' data-wa-color='#FFD700'></i>Cálculos y Apuntes</a>
                          </div>";

                            echo "<div class='list-group'>
                              <a href='".app_path('calendario.php')."' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-calendar-days ps-2 pe-3 fs-3' data-wa-color='#3587ff'></i>Calendarios</a>
                            </div>";

                          echo "<div class='list-group'>
                            <a href='".app_path('vista_epa.php')."' class='sidebar-wa-btn list-group-item list-group-item-action fs-6 text-break'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3' data-wa-color='#FF5A00'></i>E. Preanestésica</a>
                          </div>";

                          echo "<div class='list-group'>
                            <a href='".app_path('telefonos.php')."' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-phone ps-2 pe-3 fs-3' data-wa-color='#6405d0'></i>Teléfonos Frecuentes</a>
                          </div>";

                          echo "<div class='list-group'>
                            <a href='".app_path('correos.php')."' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-envelope ps-2 pe-3 fs-3' data-wa-color='#29A09B'></i>Directorio Correos</a>
                          </div>";

                        }
                      ?>

                      <div class="row">
                        <?php
                          if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
                            $email_user=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
                            $consulta_user="SELECT * FROM `usuarios_dolor` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";
                            $confirma_user=$conexion->query($consulta_user);

                            if($confirma_user && mysqli_num_rows($confirma_user)>0){
                              $query_badge3="SELECT `verified` FROM `usuarios_dolor` WHERE `verified` = '0'";
                              $consutal_badge3=$conexion->query($query_badge3);
                              $badge3 = $consutal_badge3 ? mysqli_num_rows($consutal_badge3) : 0;
                              $escribe_badge3 = $badge3 > 0 ? "<span class='badge text-bg-danger'>".$badge3."</span>" : "";

                              echo "
                                <form id='gest_users' action='".app_path('gestion_usuarios.php')."' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm1()' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-users ps-2 pe-3 fs-3 text-primary'></i>Gestión Usuarios &nbsp;$escribe_badge3</a>
                                  </div>
                                </form>
                                <script>function envioForm1(){document.getElementById('gest_users').submit();}</script>
                              ";

                              echo "
                                <form id='gest_pacientes' action='".app_path('gestion_pacientes.php')."' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm2()' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-bed ps-2 pe-3 fs-3 text-primary'></i>Gestión Pacientes</a>
                                  </div>
                                </form>
                                <script>function envioForm2(){document.getElementById('gest_pacientes').submit();}</script>
                              ";

                              echo "
                                <form id='gest_bitacora' action='".app_path('gestion_bitacora.php')."' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm3()' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3 text-primary'></i>Gestión Bitácora</a>
                                  </div>
                                </form>
                                <script>function envioForm3(){document.getElementById('gest_bitacora').submit();}</script>
                              ";


                              echo "
                                <form id='admin_notas' action='".app_path('admin_notas.php')."' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm4()' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-calculator ps-2 pe-3 fs-3 text-primary'></i>Admin Apuntes</a>
                                  </div>
                                </form>
                                <script>function envioForm4(){document.getElementById('admin_notas').submit();}</script>
                              "; 


                              echo "
                                <form id='admin_notificaciones' action='".app_path('admin_notificaciones.php')."' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm5()' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-bell ps-2 pe-3 fs-3 text-primary'></i>Admin Notif</a>
                                  </div>
                                </form>
                                <script>function envioForm5(){document.getElementById('admin_notificaciones').submit();}</script>
                              ";            

                              echo "
                                <form id='admin_calendarios' action='".app_path('admin_calendarios.php')."' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm7()' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-calendar-check ps-2 pe-3 fs-3 text-primary'></i>Admin Calendario</a>
                                  </div>
                                </form>
                                <script>function envioForm7(){document.getElementById('admin_calendarios').submit();}</script>
                              ";

                              echo "
                                <form id='admin_exportar_bitacoras' action='".app_path('admin_exportar_bitacoras.php')."' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm6()' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-file-export ps-2 pe-3 fs-3 text-primary'></i>Exportar BBDD</a>
                                  </div>
                                </form>
                                <script>function envioForm6(){document.getElementById('admin_exportar_bitacoras').submit();}</script>
                              ";        

                            }
                          }
                        ?>
                      </div>

                      <div class='list-group'>
                        <a href='https://uachcl-my.sharepoint.com/:f:/r/personal/docentes_anestesia_uach_cl/Documents/Reuniones%20Clinicas?e=5%3a1d4a50a99f8747659eaf40e9bd942188&sharingv2=true&fromShare=true&at=9' target='_blank' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-chalkboard-user ps-2 pe-3 fs-3' data-wa-color="#D9027D"></i>Reuniones Clínicas</a>
                      </div>

                      <div class='list-group'>
                        <a href='<?= app_path('acerca_de.php') ?>' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-circle-question ps-2 pe-3 fs-3' data-wa-color="#FF6347"></i>Acerca de</a>
                      </div>
                    </ul>

                    <?php
                      if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
                        echo "<ul class='list-group pt-5'>
                          <div class='list-group'>
                            <a href='".app_path('cierra_sesion.php')."' class='sidebar-wa-btn list-group-item list-group-item-action fs-6'><i class='fa-solid fa-door-open ps-2 pe-3 fs-3 text-success'></i>Cerrar sesión</a>
                          </div>
                        </ul>";
                      }
                    ?>

                    <div class="mb-0 px-0 pt-4 text-center text-black-50"><hr></div>
                    <div class="mb-0 px-0 py-4 text-center text-black-50"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>

<!-- Overlay global -->
<div id="globalSavingOverlay" class="saving-overlay d-none">
  <div class="saving-box">
    <div class="saving-spinner"></div>
    <div class="saving-text">Guardando...</div>
  </div>
</div>

<script>
function ubicarWidgetNotificaciones() {
  const widget = document.getElementById('notif-widget');
  if (!widget) return;

  const mobileSlot = document.getElementById('notif-slot-mobile');
  const desktopSlot = document.getElementById('notif-slot-desktop');
  const isDesktop = window.matchMedia('(min-width: 768px)').matches;
  const targetSlot = isDesktop ? desktopSlot : mobileSlot;

  if (targetSlot && widget.parentElement !== targetSlot) {
    targetSlot.appendChild(widget);
  }

  const menu = widget.querySelector('.notif-dropdown-menu');
  const navRight = document.body.classList.contains('sidebar-right');
  const openStart = isDesktop ? !navRight : navRight;

  widget.classList.toggle('notif-dropdown-open-start', openStart);
  widget.classList.toggle('notif-dropdown-open-end', !openStart);

  if (menu) {
    menu.classList.toggle('dropdown-menu-start', openStart);
    menu.classList.toggle('dropdown-menu-end', !openStart);
  }
}

ubicarWidgetNotificaciones();
window.addEventListener('resize', ubicarWidgetNotificaciones);


function aplicarEstiloWhatsappSidebar(){
  const fallbackPorIcono = [
    ['fa-house', '#44B2FF'], ['fa-clipboard', '#CE2E2E'], ['fa-calculator', '#FFD700'],
    ['fa-phone', '#6405d0'], ['fa-envelope', '#29A09B'], ['fa-users', '#3587ff'],
    ['fa-bed', '#3587ff'], ['fa-bell', '#3587ff'], ['fa-file-export', '#3587ff'],
    ['fa-chalkboard-user', '#D9027D'], ['fa-circle-question', '#FF6347'],
    ['fa-door-open', '#29a85b'], ['fa-right-to-bracket', '#44B2FF']
  ];

  const esDesktopSidebar = window.matchMedia('(min-width: 576px)').matches;
  const colorTextoSidebar = esDesktopSidebar ? '#ffffff' : '#111827';

  document.querySelectorAll('#offcanvasExampleLabel .list-group-item-action').forEach(function(item){
    item.style.setProperty('color', colorTextoSidebar, 'important');
    item.style.setProperty('background-color', 'transparent', 'important');
  });

  document.querySelectorAll('#offcanvasExampleLabel .list-group-item-action > i').forEach(function(icon){
    let color = icon.getAttribute('data-wa-color') || icon.style.color || '';
    if (!color || color === 'inherit' || color === 'initial') {
      const match = fallbackPorIcono.find(function(pair){ return icon.classList.contains(pair[0]); });
      color = match ? match[1] : '#3587ff';
    }
    icon.setAttribute('data-wa-color', color);
    icon.style.setProperty('background-color', color, 'important');
    icon.style.setProperty('color', '#ffffff', 'important');
  });
}

aplicarEstiloWhatsappSidebar();
document.addEventListener('DOMContentLoaded', aplicarEstiloWhatsappSidebar);
window.addEventListener('resize', aplicarEstiloWhatsappSidebar);

document.addEventListener('click', function(e){
  const item = e.target.closest('.notif-item[data-destinatario-id]');
  if(!item) return;

  const destinatarioId = item.dataset.destinatarioId;
  if(!destinatarioId) return;

  if (item.dataset.esSistema === '1') return;

  const body = new URLSearchParams();
  body.append('destinatario_id', destinatarioId);
  body.append('accion', 'leer');

  if (navigator.sendBeacon) {
    const blob = new Blob([body.toString()], {
      type: 'application/x-www-form-urlencoded; charset=UTF-8'
    });
    navigator.sendBeacon('<?= app_path('notificacion_accion_ajax.php') ?>', blob);
  } else {
    fetch('<?= app_path('notificacion_accion_ajax.php') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
      },
      body: body.toString(),
      keepalive: true
    }).catch(() => {});
  }
});
</script>

<script>
const notifAjaxUrl = '<?= app_path('notificacion_accion_ajax.php') ?>';

document.addEventListener('click', function(e) {
  const hideBtn = e.target.closest('.notif-hide-local-btn');
  if (!hideBtn) return;

  e.preventDefault();
  e.stopPropagation();

  const item = e.target.closest('.notif-item');
  if (!item) return;

  item.remove();

  const badge = document.getElementById('notif-badge');
  const currentTotal = badge ? parseInt(badge.textContent, 10) || 0 : 0;
  actualizarBadgeNotificaciones(Math.max(0, currentTotal - 1));
  asegurarEstadoVacioNotificaciones();
});

document.addEventListener('click', async function(e) {
  const readBtn = e.target.closest('.notif-read-btn');
  if (!readBtn) return;

  e.preventDefault();
  e.stopPropagation();

  const item = e.target.closest('.notif-item');
  if (!item) return;

  const destinatarioId = item.dataset.destinatarioId;
  if (!destinatarioId) return;

  if (item.dataset.esSistema === '1') {
    item.remove();
    const badge = document.getElementById('notif-badge');
    const currentTotal = badge ? parseInt(badge.textContent, 10) || 0 : 0;
    actualizarBadgeNotificaciones(Math.max(0, currentTotal - 1));
    asegurarEstadoVacioNotificaciones();
    return;
  }

  try {
    const body = new URLSearchParams();
    body.append('destinatario_id', destinatarioId);
    body.append('accion', 'leer');

    const response = await fetch(notifAjaxUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
      },
      body: body.toString()
    });

    const raw = await response.text();
    console.log('Respuesta AJAX:', raw);

    let data;
    try {
      data = JSON.parse(raw);
    } catch (parseError) {
      throw new Error('La respuesta no es JSON válido');
    }

    if (!data.ok) {
      alert(data.message || 'No se pudo actualizar la notificación');
      return;
    }

    item.remove();
    actualizarBadgeNotificaciones(data.total_no_leidas);
    asegurarEstadoVacioNotificaciones();

  } catch (err) {
    console.error(err);
    alert('Error de red al actualizar la notificación: ' + err);
  }
});

document.addEventListener('click', function(e) {
  const openBtn = e.target.closest('.notif-open-btn');
  if (!openBtn) return;

  const item = e.target.closest('.notif-item');
  if (!item) return;

  const destinatarioId = item.dataset.destinatarioId;
  if (!destinatarioId) return;

  if (item.dataset.esSistema === '1') return;

  const body = new URLSearchParams();
  body.append('destinatario_id', destinatarioId);
  body.append('accion', 'leer');

  if (navigator.sendBeacon) {
    const blob = new Blob([body.toString()], {
      type: 'application/x-www-form-urlencoded; charset=UTF-8'
    });
    navigator.sendBeacon('<?= app_path('notificacion_accion_ajax.php') ?>', blob);
  } else {
    fetch('<?= app_path('notificacion_accion_ajax.php') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
      },
      body: body.toString(),
      keepalive: true
    }).catch(() => {});
  }
});

function actualizarBadgeNotificaciones(total) {
  const badge = document.getElementById('notif-badge');
  const countText = document.getElementById('notif-count-text');

  if (countText) {
    countText.textContent = total + ' sin leer';
  }

  if (total > 0) {
    if (badge) {
      badge.textContent = total > 99 ? '99+' : String(total);
    } else {
      const bellBtn = document.querySelector('.btn-icon-topbar');
      if (bellBtn) {
        const span = document.createElement('span');
        span.id = 'notif-badge';
        span.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
        span.textContent = total > 99 ? '99+' : String(total);
        bellBtn.appendChild(span);
      }
    }
  } else {
    if (badge) badge.remove();
  }
}

function asegurarEstadoVacioNotificaciones() {
  const list = document.getElementById('notif-list');
  if (!list) return;

  const items = list.querySelectorAll('.notif-item');
  let emptyState = document.getElementById('notif-empty-state');

  if (items.length === 0) {
    if (!emptyState) {
      emptyState = document.createElement('div');
      emptyState.id = 'notif-empty-state';
      emptyState.className = 'p-3 text-muted small';
      emptyState.textContent = 'No tienes notificaciones.';
      list.appendChild(emptyState);
    }
  } else {
    if (emptyState) emptyState.remove();
  }
}
</script>
