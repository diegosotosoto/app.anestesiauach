<?php 
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	$consulta_b="SELECT `nombre_paciente`,`rut`,`analgesia` FROM `pacientes` WHERE `de_alta` = '0'";

	$busqueda=$conexion->query($consulta_b);



		while($fila=$busqueda->fetch_assoc()){

				echo "<form action='vista_paciente.php' method='post'><button class='list-group-item list-group-item-action' type='submit' name='vista' value='".$fila['rut']."' /><h5 class='mb-1'>".$fila['nombre_paciente']."</h5><p class='mb-1'>".$fila['rut']."</p>
    <small class='text-muted'>".$fila['analgesia']."</small></button></form>";

	} 



 ?>
