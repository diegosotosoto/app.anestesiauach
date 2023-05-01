<?php

//1 Validador login
	require("valida_pag.php");


//2 Variables con conexion
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");


	$formulario=htmlentities(addslashes($_POST['lista_v']));
	//ENVIA EL POST VISTA CON LA VARIABLE FORMULARIO PARA CANCELAR
		$boton_toggler="<form method='post' action='vista_paciente.php'><button class='btn d-sm-block d-sm-none shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' type='submit' name='vista' value='$formulario'><div class='text-white'><i class='d-sm-block d-sm-none fa fa-chevron-left'></i>Atrás</div></button></form>";
		$titulo_navbar="<p class='d-sm-block d-sm-none text-white'>Visitas Dolor</p>";

		$boton_navbar="<a class='navbar-brand mr-auto ms-5 d-sm-block d-sm-none' href='#'' role='button'></a>";


//Carga Head de la página
	require("head.php");

	?>


<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->
<div class="row text-center ps-2 pt-5">

		<div class="list-group">

	<?php 

	$consulta_b="SELECT `fecha_v`,`editor_v`,`rut_v` FROM `visita_diaria` WHERE `rut_v` = '$formulario'";
	
	$busqueda=$conexion->query($consulta_b);



		while($fila=$busqueda->fetch_array()){

		$phpdate = strtotime( $fila[0] );
		$fecha = date( 'd-m-y H:i', $phpdate );

				echo "<form action='vista_visitas.php' method='post'><button class='list-group-item list-group-item-action' type='submit' value='Submit'><input type='hidden' name='fecha_v' id='fecha_v' value='$fila[0]'><input type='hidden' name='rut_v' id='rut_v' value='$fila[2]'><h5 class='mb-1'>$fecha</h5><small class='text-black-50'>$fila[1]</small></button></form>";

	} 

	?>

		</div>

</div>
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
