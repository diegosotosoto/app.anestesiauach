<?php
require("conectar.php");
require_once __DIR__ . '/app_security.php';
require("valida_pag.php");

function h_server($value){
	return htmlspecialchars(html_entity_decode((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, ENT_SUBSTITUTE, 'UTF-8');
}

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8mb4");

$usuario = app_current_user($conexion);

if (!$usuario || (int)$usuario['intern_'] === 1 || (int)$usuario['becad_otro'] === 1) {
	http_response_code(403);
	exit;
}

$consulta_b = "SELECT `nombre_paciente`, `rut`, `analgesia` FROM `pacientes` WHERE `de_alta` = '0' ORDER BY `nombre_paciente` ASC";
$busqueda = $conexion->query($consulta_b);

if (!$busqueda) {
	http_response_code(500);
	exit;
}

while($fila = $busqueda->fetch_assoc()){
	$rut = h_server($fila['rut']);
	$nombre = h_server($fila['nombre_paciente']);
	$analgesia = h_server($fila['analgesia']);

	echo "
		<form action='vista_paciente.php' method='post' class='pain-patient-form'>
			<button type='submit' name='vista' value='{$rut}' class='pain-patient-card'>
				<span class='pain-patient-main'>
					<strong>{$nombre}</strong>
					<span>{$rut}</span>
				</span>
				<span class='pain-patient-meta'>{$analgesia}</span>
			</button>
		</form>
	";
}

$conexion->close();
?>
