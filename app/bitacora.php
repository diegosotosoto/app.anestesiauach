<?php
//Conexión
require("conectar.php");
require_once __DIR__ . '/app_security.php';
$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
$conexion->set_charset("utf8");

app_require_login($conexion, 'login.php');

//redirección segun nivel de usuario
$usuario = app_current_user($conexion);
if(!$usuario){
    header('Location: login.php');
    exit;
}

if($usuario['external_']==1){
    header('Location: index.php');
    exit;
}

if($usuario['admin']==1){
    header('Location: bitacora_autoriza.php');
} elseif ($usuario['staff_']==1) {
    header('Location: bitacora_autoriza.php');
} elseif ($usuario['intern_']==1 or $usuario['becad_otro']==1) {
    header('Location: bitacora_internos.php');
} elseif ($usuario['becad_']==1) {
    header('Location: bitacora_ingreso.php');
}
?>