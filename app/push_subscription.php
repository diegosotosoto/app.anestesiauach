<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/conectar.php';
require_once __DIR__ . '/app_security.php';

if (!isset($conexion) || !$conexion instanceof mysqli) {
    $conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
    $conexion->set_charset('utf8mb4');
}

$config_path = __DIR__ . '/secure_config/push_config.php';
if (is_readable($config_path)) {
    require_once $config_path;
}

function app_push_json($payload, $status = 200) {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function app_push_public_key() {
    return defined('APP_PUSH_VAPID_PUBLIC_KEY') ? (string)APP_PUSH_VAPID_PUBLIC_KEY : '';
}

function app_push_enabled() {
    return defined('APP_PUSH_ENABLED') ? (bool)APP_PUSH_ENABLED : false;
}

$usuario = app_current_user($conexion);
if (!$usuario) {
    app_push_json(['ok' => false, 'error' => 'No autenticado.'], 401);
}

$usuario_id = (int)$usuario['ID'];
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$action = $_GET['action'] ?? '';

if ($method === 'GET') {
    $endpoint_hash = trim((string)($_GET['endpoint_hash'] ?? ''));
    $active = false;

    if ($endpoint_hash !== '' && preg_match('/^[a-f0-9]{64}$/i', $endpoint_hash)) {
        $stmt = $conexion->prepare('SELECT `id` FROM `push_subscriptions` WHERE `usuario_id` = ? AND `endpoint_hash` = ? AND `enabled` = 1 LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('is', $usuario_id, $endpoint_hash);
            $stmt->execute();
            if (method_exists($stmt, 'get_result')) {
                $res = $stmt->get_result();
                $active = $res && $res->num_rows > 0;
            } else {
                $stmt->store_result();
                $active = $stmt->num_rows > 0;
            }
            $stmt->close();
        }
    }

    app_push_json([
        'ok' => true,
        'enabled' => app_push_enabled(),
        'publicKey' => app_push_public_key(),
        'active' => $active,
        'isSecureContext' => app_is_https_request() || strpos((string)($_SERVER['HTTP_HOST'] ?? ''), 'localhost') === 0,
    ]);
}

if ($method !== 'POST') {
    app_push_json(['ok' => false, 'error' => 'Método no permitido.'], 405);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    app_push_json(['ok' => false, 'error' => 'JSON inválido.'], 400);
}

if ($action === 'unsubscribe') {
    $endpoint = trim((string)($data['endpoint'] ?? ''));
    if ($endpoint === '') {
        app_push_json(['ok' => false, 'error' => 'Endpoint faltante.'], 400);
    }

    $endpoint_hash = hash('sha256', $endpoint);
    $stmt = $conexion->prepare('UPDATE `push_subscriptions` SET `enabled` = 0, `updated_at` = NOW() WHERE `usuario_id` = ? AND `endpoint_hash` = ?');
    if (!$stmt) {
        app_push_json(['ok' => false, 'error' => 'No se pudo preparar la desuscripción.'], 500);
    }

    $stmt->bind_param('is', $usuario_id, $endpoint_hash);
    $ok = $stmt->execute();
    $stmt->close();

    app_push_json(['ok' => (bool)$ok]);
}

$subscription = $data['subscription'] ?? null;
if (!is_array($subscription)) {
    app_push_json(['ok' => false, 'error' => 'Suscripción faltante.'], 400);
}

$endpoint = trim((string)($subscription['endpoint'] ?? ''));
$keys = $subscription['keys'] ?? [];
$p256dh = trim((string)($keys['p256dh'] ?? ''));
$auth = trim((string)($keys['auth'] ?? ''));
$content_encoding = trim((string)($data['contentEncoding'] ?? 'aes128gcm'));
$platform = trim((string)($data['platform'] ?? ''));
$user_agent = substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 1000);

if ($endpoint === '' || $p256dh === '' || $auth === '') {
    app_push_json(['ok' => false, 'error' => 'Datos incompletos de suscripción.'], 400);
}

$endpoint_hash = hash('sha256', $endpoint);

$stmt = $conexion->prepare('
    INSERT INTO `push_subscriptions`
        (`usuario_id`, `endpoint`, `endpoint_hash`, `p256dh`, `auth`, `content_encoding`, `user_agent`, `platform`, `enabled`, `last_seen_at`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())
    ON DUPLICATE KEY UPDATE
        `usuario_id` = VALUES(`usuario_id`),
        `endpoint` = VALUES(`endpoint`),
        `p256dh` = VALUES(`p256dh`),
        `auth` = VALUES(`auth`),
        `content_encoding` = VALUES(`content_encoding`),
        `user_agent` = VALUES(`user_agent`),
        `platform` = VALUES(`platform`),
        `enabled` = 1,
        `last_seen_at` = NOW(),
        `updated_at` = NOW()
');

if (!$stmt) {
    app_push_json(['ok' => false, 'error' => 'No se pudo preparar la suscripción.'], 500);
}

$stmt->bind_param('isssssss', $usuario_id, $endpoint, $endpoint_hash, $p256dh, $auth, $content_encoding, $user_agent, $platform);
$ok = $stmt->execute();
$stmt->close();

app_push_json(['ok' => (bool)$ok, 'endpoint_hash' => $endpoint_hash]);
