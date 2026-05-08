<?php

require_once __DIR__ . '/app_security.php';

require('conectar.php');
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset('utf8mb4');

app_require_login($conexion, 'login.php');

?>