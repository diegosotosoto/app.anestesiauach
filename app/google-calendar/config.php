<?php

define('GOOGLE_CALENDAR_SERVICE_ACCOUNT_FILE', __DIR__ . '/service-account.json');
define('GOOGLE_CALENDAR_TOKEN_URI', 'https://oauth2.googleapis.com/token');
define('GOOGLE_CALENDAR_SCOPE', 'https://www.googleapis.com/auth/calendar.readonly');

function google_calendar_base64url($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function google_calendar_is_configured()
{
    return is_readable(GOOGLE_CALENDAR_SERVICE_ACCOUNT_FILE);
}

function google_calendar_get_service_account()
{
    if (!google_calendar_is_configured()) {
        throw new RuntimeException('No se encontró google-calendar/service-account.json.');
    }

    $raw = file_get_contents(GOOGLE_CALENDAR_SERVICE_ACCOUNT_FILE);
    $data = json_decode($raw, true);

    if (!is_array($data) || empty($data['client_email']) || empty($data['private_key'])) {
        throw new RuntimeException('service-account.json no tiene el formato esperado.');
    }

    return $data;
}

function google_calendar_get_access_token()
{
    static $cachedToken = null;
    static $cachedUntil = 0;

    if ($cachedToken && $cachedUntil > time() + 60) {
        return $cachedToken;
    }

    if (!function_exists('curl_init')) {
        throw new RuntimeException('La extensión cURL de PHP no está disponible.');
    }

    if (!function_exists('openssl_sign')) {
        throw new RuntimeException('La extensión OpenSSL de PHP no está disponible.');
    }

    $account = google_calendar_get_service_account();
    $now = time();

    $header = array(
        'alg' => 'RS256',
        'typ' => 'JWT'
    );

    $claim = array(
        'iss' => $account['client_email'],
        'scope' => GOOGLE_CALENDAR_SCOPE,
        'aud' => GOOGLE_CALENDAR_TOKEN_URI,
        'iat' => $now,
        'exp' => $now + 3600
    );

    $unsigned = google_calendar_base64url(json_encode($header)) . '.' . google_calendar_base64url(json_encode($claim));
    $signature = '';

    if (!openssl_sign($unsigned, $signature, $account['private_key'], OPENSSL_ALGO_SHA256)) {
        throw new RuntimeException('No se pudo firmar el JWT de Google Calendar.');
    }

    $assertion = $unsigned . '.' . google_calendar_base64url($signature);

    $ch = curl_init(GOOGLE_CALENDAR_TOKEN_URI);
    curl_setopt_array($ch, array(
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
        CURLOPT_POSTFIELDS => http_build_query(array(
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $assertion
        )),
        CURLOPT_TIMEOUT => 15
    ));

    $response = curl_exec($ch);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false || $httpCode < 200 || $httpCode >= 300) {
        throw new RuntimeException('Google no entregó token de acceso. ' . ($curlError ?: 'HTTP ' . $httpCode));
    }

    $tokenData = json_decode($response, true);
    if (!is_array($tokenData) || empty($tokenData['access_token'])) {
        throw new RuntimeException('Respuesta de token inválida desde Google.');
    }

    $cachedToken = $tokenData['access_token'];
    $cachedUntil = $now + (int)($tokenData['expires_in'] ?? 3600);

    return $cachedToken;
}

function google_calendar_fetch_events($calendarId, DateTimeInterface $timeMin, DateTimeInterface $timeMax, $maxResults = 50)
{
    if (!function_exists('curl_init')) {
        throw new RuntimeException('La extensión cURL de PHP no está disponible.');
    }

    $token = google_calendar_get_access_token();
    $url = 'https://www.googleapis.com/calendar/v3/calendars/' . rawurlencode($calendarId) . '/events?' . http_build_query(array(
        'singleEvents' => 'true',
        'orderBy' => 'startTime',
        'timeMin' => $timeMin->format(DateTime::RFC3339),
        'timeMax' => $timeMax->format(DateTime::RFC3339),
        'maxResults' => max(1, min(250, (int)$maxResults))
    ));

    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token),
        CURLOPT_TIMEOUT => 15
    ));

    $response = curl_exec($ch);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false || $httpCode < 200 || $httpCode >= 300) {
        throw new RuntimeException('No se pudieron leer eventos del calendario. ' . ($curlError ?: 'HTTP ' . $httpCode));
    }

    $data = json_decode($response, true);
    if (!is_array($data)) {
        throw new RuntimeException('Respuesta inválida desde Google Calendar.');
    }

    return $data['items'] ?? array();
}

