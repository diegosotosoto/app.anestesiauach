<?php 
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	$consulta_b="SELECT `nombre_paciente`,`rut`,`analgesia` FROM `pacientes` WHERE `de_alta` = '0'";

	$busqueda=$conexion->query($consulta_b);


	$i=0;

		while($fila=$busqueda->fetch_assoc()){

			$i++;
				echo "<form action='vista_paciente.php' method='post'><button type='submit' name='vista' value='".$fila['rut']."' class='list-group-item list-group-item-action";
		if ($i==1) {
			echo " list-group-item-light' "; //fondo blanco
		}else{
			echo " list-group-item-info opacity-75' "; //fondo gris
		}
				
				echo "style='background-image: var(--bs-gradient);'/><h5 class='mb-1'>".$fila['nombre_paciente']."</h5><p class='mb-1'>".$fila['rut']."</p><small class='text-muted'>".$fila['analgesia']."</small></button></form>";

		if ($i==2){
		$i=0;
		}

	} 



 ?>

