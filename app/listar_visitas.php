<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
	//Carga Head de la página
	require("head.php");

?>

</head>
<body>
<br>
<br>
<!-  NAVBAR  ->	
<form method='post' action='vista_paciente.php'>

	<?php
		$formulario=htmlentities(addslashes($_POST['lista_v']));
		//ENVIA EL POST VISTA CON LA VARIABLE FLORMULARIO PARA CANCELAR
		$boton_toggler="<button class='btn shadow-sm btn-lg border-light' style='; --bs-border-opacity: .1;' type='submit' name='vista' value='$formulario'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></button>";
		$titulo_navbar="Visitas Dolor";

		$boton_navbar="<a class='navbar-brand mr-auto ms-5' href='#'' role='button'></a>";

		//Conexión
		require("navbar.php");

	?>
</form>
		<div class="list-group py-3">

	<?php 

	$consulta_b="SELECT `fecha_v`,`editor_v`,`rut_v` FROM `visita_diaria` WHERE `rut_v` = '$formulario'";
	
	$busqueda=$conexion->query($consulta_b);



		while($fila=$busqueda->fetch_array()){

		$phpdate = strtotime( $fila[0] );
		$fecha = date( 'd-m-y H:i', $phpdate );

				echo "<form action='vista_visitas.php' method='post'><button class='list-group-item list-group-item-action' type='submit' value='Submit'><input type='hidden' name='fecha_v' id='fecha_v' value='$fila[0]'><input type='hidden' name='rut_v' id='rut_v' value='$fila[2]'><h5 class='mb-1'>$fecha</h5><small class='text-muted'>$fila[1]</small></button></form>";

	} 

	?>

		</div>
	<?php 
		//Cierre Conexión
		$conexion->close();
	?>

<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

</body>
</html>
