<?php

/*
 * Helpers para envío de Web Push Notifications.
 *
 * Requiere:
 *   - vendor/autoload.php (minishlink/web-push)
 *   - secure_config/push_config.php con APP_PUSH_VAPID_* definidas
 */

function app_push_load_config(): bool {
    $config_path = __DIR__ . '/secure_config/push_config.php';
    if (is_readable($config_path)) {
        require_once $config_path;
    }
    return defined('APP_PUSH_ENABLED') && APP_PUSH_ENABLED
        && defined('APP_PUSH_VAPID_PUBLIC_KEY')
        && defined('APP_PUSH_VAPID_PRIVATE_KEY')
        && defined('APP_PUSH_VAPID_SUBJECT');
}

/*
 * Envía una notificación push a uno o varios usuarios.
 *
 * @param mysqli   $conexion    Conexión activa a la BD
 * @param int[]    $usuario_ids Array de IDs de usuarios destinatarios
 * @param string   $titulo      Título de la notificación
 * @param string   $mensaje     Cuerpo del mensaje
 * @param string   $url         URL destino al hacer clic (relativa, ej: '/apuntes/asa.php')
 * @param string   $icono       Clase FontAwesome opcional (solo referencial, el SW usa el icono PWA)
 * @return array{sent:int, failed:int, skipped:int}
 */
function app_push_send_to_users(
    mysqli $conexion,
    array $usuario_ids,
    string $titulo,
    string $mensaje,
    string $url = '/',
    string $icono = '',
    string $categoria = ''
): array {
    $result = ['sent' => 0, 'failed' => 0, 'skipped' => 0];

    if (empty($usuario_ids)) {
        return $result;
    }

    $autoload = __DIR__ . '/vendor/autoload.php';
    if (!is_readable($autoload)) {
        return $result;
    }

    if (!app_push_load_config()) {
        return $result;
    }

    try {
        require_once $autoload;
    } catch (Throwable $e) {
        error_log('app_push: Error cargando autoload: ' . $e->getMessage());
        return $result;
    }

    if (!class_exists('\Minishlink\WebPush\WebPush')) {
        return $result;
    }

    $auth = [
        'VAPID' => [
            'subject'    => APP_PUSH_VAPID_SUBJECT,
            'publicKey'  => APP_PUSH_VAPID_PUBLIC_KEY,
            'privateKey' => APP_PUSH_VAPID_PRIVATE_KEY,
        ],
    ];

    $webPush = new \Minishlink\WebPush\WebPush($auth);

    $placeholders = implode(',', array_fill(0, count($usuario_ids), '?'));
    $types        = str_repeat('i', count($usuario_ids));

    $cat_col = '';
    if ($categoria !== '') {
        $allowed_cats = ['notif_calendario', 'notif_bitacora', 'notif_dolor', 'notif_sistema'];
        if (in_array($categoria, $allowed_cats, true)) {
            $cat_col = $categoria;
        }
    }

    $prefs_join = $cat_col !== ''
        ? "LEFT JOIN `user_push_prefs` pp ON pp.`usuario_id` = ps.`usuario_id`"
        : "";
    $prefs_where = $cat_col !== ''
        ? "AND (pp.`push_enabled` IS NULL OR pp.`push_enabled` = 1) AND (pp.`$cat_col` IS NULL OR pp.`$cat_col` = 1)"
        : "AND (SELECT COALESCE(p2.`push_enabled`,1) FROM `user_push_prefs` p2 WHERE p2.`usuario_id`=ps.`usuario_id` LIMIT 1) = 1";

    $stmt = $conexion->prepare("
        SELECT ps.`id`, ps.`endpoint`, ps.`p256dh`, ps.`auth`, ps.`content_encoding`
        FROM `push_subscriptions` ps
        $prefs_join
        WHERE ps.`usuario_id` IN ($placeholders)
          AND ps.`enabled` = 1
          $prefs_where
    ");

    if (!$stmt) {
        return $result;
    }

    $stmt->bind_param($types, ...array_values($usuario_ids));
    $stmt->execute();
    $res = $stmt->get_result();

    if (!$res || $res->num_rows === 0) {
        $stmt->close();
        $result['skipped'] = count($usuario_ids);
        return $result;
    }

    $payload = json_encode([
        'title' => $titulo,
        'body'  => $mensaje,
        'url'   => $url,
        'icon'  => $icono,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $subscription_ids = [];

    while ($row = $res->fetch_assoc()) {
        $subscription = \Minishlink\WebPush\Subscription::create([
            'endpoint'        => $row['endpoint'],
            'contentEncoding' => $row['content_encoding'] ?: 'aes128gcm',
            'keys'            => [
                'p256dh' => $row['p256dh'],
                'auth'   => $row['auth'],
            ],
        ]);

        $webPush->queueNotification($subscription, $payload);
        $subscription_ids[$row['endpoint']] = (int)$row['id'];
    }

    $stmt->close();

    $expired_ids = [];

    foreach ($webPush->flush() as $report) {
        if ($report->isSuccess()) {
            $result['sent']++;
        } else {
            $result['failed']++;
            if ($report->isSubscriptionExpired()) {
                $ep = $report->getRequest()->getUri()->__toString();
                if (isset($subscription_ids[$ep])) {
                    $expired_ids[] = $subscription_ids[$ep];
                }
            }
        }
    }

    if (!empty($expired_ids)) {
        $exp_placeholders = implode(',', array_fill(0, count($expired_ids), '?'));
        $exp_types        = str_repeat('i', count($expired_ids));
        $stmt_exp = $conexion->prepare("
            UPDATE `push_subscriptions`
            SET `enabled` = 0, `updated_at` = NOW()
            WHERE `id` IN ($exp_placeholders)
        ");
        if ($stmt_exp) {
            $stmt_exp->bind_param($exp_types, ...array_values($expired_ids));
            $stmt_exp->execute();
            $stmt_exp->close();
        }
    }

    return $result;
}

/*
 * Obtiene todos los IDs de usuarios destinatarios de una notificación ya creada.
 */
function app_push_get_destinatarios(mysqli $conexion, int $notificacion_id): array {
    $stmt = $conexion->prepare("
        SELECT `usuario_id` FROM `notificacion_destinatarios`
        WHERE `notificacion_id` = ?
    ");
    if (!$stmt) return [];
    $stmt->bind_param('i', $notificacion_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $ids = [];
    while ($row = $res->fetch_assoc()) {
        $ids[] = (int)$row['usuario_id'];
    }
    $stmt->close();
    return $ids;
}

/*
 * Envía push a todos los usuarios con un rol/condición específica.
 * $where_sql: fragmento SQL seguro (sin interpolación de usuario) para WHERE en usuarios_dolor
 */
function app_push_send_to_group(
    mysqli $conexion,
    string $where_sql,
    string $titulo,
    string $mensaje,
    string $url = '/',
    string $icono = '',
    string $categoria = ''
): array {
    $res = $conexion->query("SELECT `ID` FROM `usuarios_dolor` WHERE $where_sql AND `verified` = 1");
    if (!$res) return ['sent' => 0, 'failed' => 0, 'skipped' => 0];
    $ids = [];
    while ($row = $res->fetch_assoc()) {
        $ids[] = (int)$row['ID'];
    }
    return app_push_send_to_users($conexion, $ids, $titulo, $mensaje, $url, $icono, $categoria);
}
