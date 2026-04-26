<?php

if (!function_exists('app_decode_text')) {
    function app_decode_text($value) {
        $texto = urldecode((string)$value);
        $entidades_es = [
            'aacute' => 'á',
            'eacute' => 'é',
            'iacute' => 'í',
            'oacute' => 'ó',
            'uacute' => 'ú',
            'ntilde' => 'ñ',
            'uuml' => 'ü'
        ];
        $entidades_es_mayus = [
            'aacute' => 'Á',
            'eacute' => 'É',
            'iacute' => 'Í',
            'oacute' => 'Ó',
            'uacute' => 'Ú',
            'ntilde' => 'Ñ',
            'uuml' => 'Ü'
        ];

        for ($i = 0; $i < 4; $i++) {
            $previo = $texto;
            $decodificado = html_entity_decode($texto, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $decodificado = preg_replace_callback(
                '/&(?:amp;)?(aacute|eacute|iacute|oacute|uacute|ntilde|uuml);?/i',
                function($match) use ($entidades_es, $entidades_es_mayus) {
                    $key = strtolower($match[1]);
                    $es_mayuscula = strtoupper($match[1]) === $match[1] || ctype_upper(substr($match[1], 0, 1));

                    return $es_mayuscula
                        ? ($entidades_es_mayus[$key] ?? $match[0])
                        : ($entidades_es[$key] ?? $match[0]);
                },
                $decodificado
            );

            if ($decodificado === $previo) {
                break;
            }

            $texto = $decodificado;
        }

        return $texto;
    }
}

if (!function_exists('app_h_text')) {
    function app_h_text($value) {
        return htmlspecialchars(app_decode_text($value), ENT_QUOTES, 'UTF-8');
    }
}
