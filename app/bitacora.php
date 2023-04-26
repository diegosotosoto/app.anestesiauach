<?php
//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");


	//redirección segun nivel de usuario
	$check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	$con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
	$users_b=$conexion->query($con_users_b);
	$usuario=$users_b->fetch_assoc();
	if($usuario['admin']==1){
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['staff_']==1) {
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['intern_']==1) {
			header('Location: bitacora_ingreso.php');
		} elseif ($usuario['becad_']==1) {
			header('Location: bitacora_ingreso.php');
		}

?>