<?php

if (!defined('APP_AUTH_EMAIL_COOKIE')) {
    define('APP_AUTH_EMAIL_COOKIE', 'hkjh41lu4l1k23jhlkj13');
}

if (!defined('APP_AUTH_NAME_COOKIE')) {
    define('APP_AUTH_NAME_COOKIE', 'hkjh41lu4l1k23jhlkj14');
}

if (!defined('APP_AUTH_TOKEN_COOKIE')) {
    define('APP_AUTH_TOKEN_COOKIE', 'app_auth_token');
}

if (!defined('APP_AUTH_COOKIE_TTL')) {
    define('APP_AUTH_COOKIE_TTL', 60 * 60 * 24 * 30);
}

function app_is_https_request() {
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return true;
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
        return true;
    }

    return false;
}

function app_cookie_options($expires) {
    return array(
        'expires' => $expires,
        'path' => '/',
        'secure' => app_is_https_request(),
        'httponly' => true,
        'samesite' => 'Lax'
    );
}

function app_set_cookie($name, $value, $expires) {
    setcookie($name, $value, app_cookie_options($expires));
    $_COOKIE[$name] = $value;
}

function app_clear_cookie($name) {
    $expired = time() - 3600;
    setcookie($name, '', app_cookie_options($expired));
    setcookie($name, '', $expired);
    unset($_COOKIE[$name]);
}

function app_set_legacy_auth_cookies($email, $nombre) {
    $expires = time() + APP_AUTH_COOKIE_TTL;
    app_set_cookie(APP_AUTH_EMAIL_COOKIE, (string)$email, $expires);
    app_set_cookie(APP_AUTH_NAME_COOKIE, (string)$nombre, $expires);
}

function app_clear_auth_cookies() {
    app_revoke_current_auth_session();
    app_clear_cookie(APP_AUTH_TOKEN_COOKIE);
    app_clear_cookie(APP_AUTH_EMAIL_COOKIE);
    app_clear_cookie(APP_AUTH_NAME_COOKIE);
}

function app_current_user_email_cookie() {
    return isset($_COOKIE[APP_AUTH_EMAIL_COOKIE]) ? trim((string)$_COOKIE[APP_AUTH_EMAIL_COOKIE]) : '';
}

function app_auth_token_hash($token) {
    return hash('sha256', (string)$token);
}

function app_ensure_auth_sessions_table($conexion) {
    if (!$conexion) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `app_auth_sessions` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `token_hash` CHAR(64) NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `expires_at` DATETIME NOT NULL,
        `revoked_at` DATETIME NULL DEFAULT NULL,
        `last_seen_at` DATETIME NULL DEFAULT NULL,
        `user_agent_hash` CHAR(64) NULL DEFAULT NULL,
        `ip_hash` CHAR(64) NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `token_hash` (`token_hash`),
        KEY `user_id` (`user_id`),
        KEY `expires_at` (`expires_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    return (bool)$conexion->query($sql);
}

function app_client_fingerprint_hash($value) {
    $value = trim((string)$value);
    return $value === '' ? null : hash('sha256', $value);
}

function app_create_auth_session($conexion, $user_id) {
    $user_id = (int)$user_id;
    if ($user_id <= 0 || !app_ensure_auth_sessions_table($conexion)) {
        return false;
    }

    $token = bin2hex(random_bytes(32));
    $token_hash = app_auth_token_hash($token);
    $expires_at = date('Y-m-d H:i:s', time() + APP_AUTH_COOKIE_TTL);
    $user_agent_hash = app_client_fingerprint_hash($_SERVER['HTTP_USER_AGENT'] ?? '');
    $ip_hash = app_client_fingerprint_hash($_SERVER['REMOTE_ADDR'] ?? '');

    $stmt = $conexion->prepare("INSERT INTO `app_auth_sessions` (`user_id`, `token_hash`, `expires_at`, `user_agent_hash`, `ip_hash`) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('issss', $user_id, $token_hash, $expires_at, $user_agent_hash, $ip_hash);
    $ok = $stmt->execute();
    $stmt->close();

    if (!$ok) {
        return false;
    }

    app_set_cookie(APP_AUTH_TOKEN_COOKIE, $token, time() + APP_AUTH_COOKIE_TTL);
    return true;
}

function app_set_auth_session_for_email($conexion, $email) {
    $email = trim((string)$email);
    if ($email === '') {
        return false;
    }

    $stmt = $conexion->prepare("SELECT `ID` FROM `usuarios_dolor` WHERE `email_usuario` = ? LIMIT 1");
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user_id = 0;

    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        $user_id = $row ? (int)$row['ID'] : 0;
    } else {
        $stmt->bind_result($id_tmp);
        if ($stmt->fetch()) {
            $user_id = (int)$id_tmp;
        }
    }

    $stmt->close();
    return app_create_auth_session($conexion, $user_id);
}

function app_revoke_current_auth_session() {
    if (!isset($_COOKIE[APP_AUTH_TOKEN_COOKIE]) || $_COOKIE[APP_AUTH_TOKEN_COOKIE] === '') {
        return false;
    }

    $token_hash = app_auth_token_hash($_COOKIE[APP_AUTH_TOKEN_COOKIE]);
    $config_path = __DIR__ . '/conectar.php';
    if (!file_exists($config_path)) {
        return false;
    }

    require $config_path;
    if (!isset($db_host, $db_usuario, $db_contra, $db_nombre)) {
        return false;
    }

    $conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
    if ($conexion->connect_errno) {
        return false;
    }

    $conexion->set_charset('utf8mb4');
    if (!app_ensure_auth_sessions_table($conexion)) {
        $conexion->close();
        return false;
    }

    $stmt = $conexion->prepare("UPDATE `app_auth_sessions` SET `revoked_at` = NOW() WHERE `token_hash` = ? AND `revoked_at` IS NULL LIMIT 1");
    if (!$stmt) {
        $conexion->close();
        return false;
    }

    $stmt->bind_param('s', $token_hash);
    $ok = $stmt->execute();
    $stmt->close();
    $conexion->close();
    return $ok;
}

function app_current_user_from_token($conexion) {
    if (!isset($_COOKIE[APP_AUTH_TOKEN_COOKIE]) || $_COOKIE[APP_AUTH_TOKEN_COOKIE] === '') {
        return null;
    }

    if (!app_ensure_auth_sessions_table($conexion)) {
        return null;
    }

    $token_hash = app_auth_token_hash($_COOKIE[APP_AUTH_TOKEN_COOKIE]);
    $stmt = $conexion->prepare("SELECT u.`ID`, u.`nombre_usuario`, u.`email_usuario`, u.`admin`, u.`staff_`, u.`intern_`, u.`becad_`, u.`becad_otro`, u.`external_`, u.`ui_modo`, u.`ui_nav_posicion`, u.`ui_icono`, u.`ui_icono_color`, u.`verified`
        FROM `app_auth_sessions` s
        INNER JOIN `usuarios_dolor` u ON u.`ID` = s.`user_id`
        WHERE s.`token_hash` = ?
          AND s.`revoked_at` IS NULL
          AND s.`expires_at` > NOW()
          AND u.`verified` = 1
        LIMIT 1");

    if (!$stmt) {
        return null;
    }

    $stmt->bind_param('s', $token_hash);
    $stmt->execute();
    $usuario = null;

    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        $usuario = $res ? $res->fetch_assoc() : null;
    } else {
        $stmt->bind_result($id_tmp, $nombre_tmp, $email_tmp, $admin_tmp, $staff_tmp, $intern_tmp, $becad_tmp, $becad_otro_tmp, $external_tmp, $ui_modo_tmp, $ui_nav_tmp, $ui_icono_tmp, $ui_color_tmp, $verified_tmp);
        if ($stmt->fetch()) {
            $usuario = array(
                'ID' => $id_tmp,
                'nombre_usuario' => $nombre_tmp,
                'email_usuario' => $email_tmp,
                'admin' => $admin_tmp,
                'staff_' => $staff_tmp,
                'intern_' => $intern_tmp,
                'becad_' => $becad_tmp,
                'becad_otro' => $becad_otro_tmp,
                'external_' => $external_tmp,
                'ui_modo' => $ui_modo_tmp,
                'ui_nav_posicion' => $ui_nav_tmp,
                'ui_icono' => $ui_icono_tmp,
                'ui_icono_color' => $ui_color_tmp,
                'verified' => $verified_tmp
            );
        }
    }

    $stmt->close();

    if ($usuario) {
        $stmt_seen = $conexion->prepare("UPDATE `app_auth_sessions` SET `last_seen_at` = NOW() WHERE `token_hash` = ? LIMIT 1");
        if ($stmt_seen) {
            $stmt_seen->bind_param('s', $token_hash);
            $stmt_seen->execute();
            $stmt_seen->close();
        }
    }

    return $usuario;
}

function app_current_user_email($conexion) {
    $usuario = app_current_user_from_token($conexion);
    if ($usuario && !empty($usuario['email_usuario'])) {
        return trim((string)$usuario['email_usuario']);
    }

    return app_current_user_email_cookie();
}

function app_current_user($conexion) {
    $usuario = app_current_user_from_token($conexion);
    if ($usuario) {
        return $usuario;
    }

    $email = app_current_user_email_cookie();
    if ($email === '') {
        return null;
    }

    $stmt = $conexion->prepare("SELECT `ID`, `nombre_usuario`, `email_usuario`, `admin`, `staff_`, `intern_`, `becad_`, `becad_otro`, `external_`, `ui_modo`, `ui_nav_posicion`, `ui_icono`, `ui_icono_color`, `verified`
        FROM `usuarios_dolor`
        WHERE `email_usuario` = ?
          AND `verified` = 1
        LIMIT 1");

    if (!$stmt) {
        return null;
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $usuario = null;

    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        $usuario = $res ? $res->fetch_assoc() : null;
    } else {
        $stmt->bind_result($id_tmp, $nombre_tmp, $email_tmp, $admin_tmp, $staff_tmp, $intern_tmp, $becad_tmp, $becad_otro_tmp, $external_tmp, $ui_modo_tmp, $ui_nav_tmp, $ui_icono_tmp, $ui_color_tmp, $verified_tmp);
        if ($stmt->fetch()) {
            $usuario = array(
                'ID' => $id_tmp,
                'nombre_usuario' => $nombre_tmp,
                'email_usuario' => $email_tmp,
                'admin' => $admin_tmp,
                'staff_' => $staff_tmp,
                'intern_' => $intern_tmp,
                'becad_' => $becad_tmp,
                'becad_otro' => $becad_otro_tmp,
                'external_' => $external_tmp,
                'ui_modo' => $ui_modo_tmp,
                'ui_nav_posicion' => $ui_nav_tmp,
                'ui_icono' => $ui_icono_tmp,
                'ui_icono_color' => $ui_color_tmp,
                'verified' => $verified_tmp
            );
        }
    }

    $stmt->close();
    return $usuario;
}

function app_is_authenticated($conexion) {
    return app_current_user($conexion) !== null;
}

function app_require_login($conexion, $login_path = 'login.php') {
    if (!app_is_authenticated($conexion)) {
        header('Location: ' . $login_path);
        exit;
    }
}
