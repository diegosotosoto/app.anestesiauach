<?php

//1 Validador login
	require("valida_pag.php");

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");


//Saca a los internos y otros becados del area de dolor
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1){
	  	header('Location: login.php');
	  }





	$formulario=htmlentities(addslashes($_POST['lista_v']));
		//ENVIA EL POST VISTA CON LA VARIABLE FORMULARIO PARA CANCELAR
			$boton_toggler="<form method='post' action='vista_paciente.php'><button class='d-sm-block d-sm-none admin-back-btn' type='submit' name='vista' value='$formulario'><i class='fa fa-chevron-left'></i>Atrás</button></form>";
			$titulo_navbar="<span>Visitas</span>";

		$boton_navbar="<a class='navbar-brand mr-auto ms-5 d-sm-block d-sm-none' href='#'' role='button'></a>";


//Carga Head de la página
	require("head.php");

	?>


	<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
	<div class="apunte-surface">
	<div class="container-fluid px-0 px-md-2">
	<div class="pain-shell">

			<div class="patient-summary-stack">



	<?php

	$consulta_a="SELECT `nombre_paciente_v` FROM `visita_diaria` WHERE `rut_v` = '$formulario'";
	
	$busqueda_a=$conexion->query($consulta_a);

	$nombre_visit=$busqueda_a->fetch_assoc();

	echo "<section class='pain-card'>";
	echo "<div class='pain-card-header'>";
	echo "<div><h3>Visitas de Dolor</h3>";
	if(isset($nombre_visit['nombre_paciente_v']) && trim((string)$nombre_visit['nombre_paciente_v']) !== ''){
		echo "<p>".app_h_text($nombre_visit['nombre_paciente_v'])."</p>";
	}
	echo "</div>";
	echo "<form method='post' action='vista_paciente.php'><button class='admin-back-btn d-none d-sm-inline-flex' type='submit' name='vista' value='".app_h_text($formulario)."'><i class='fa fa-chevron-left'></i>Atrás</button></form>";
	echo "</div>";
	?>

		<div class="pain-list-host">

	<?php 

	$consulta_b="SELECT `fecha_v`,`editor_v`,`rut_v` FROM `visita_diaria` WHERE `rut_v` = '$formulario'";
	
	$busqueda=$conexion->query($consulta_b);

		while($fila=$busqueda->fetch_assoc()){

		$phpdate = strtotime( $fila['fecha_v'] );
		$fecha = date( 'd-m-y H:i', $phpdate );

			echo "<form action='vista_visitas.php' method='post'><button class='bitacora-entry-card w-100 text-start border-0' type='submit' value='Submit'><input type='hidden' name='fecha_v' id='fecha_v' value='".app_h_text($fila['fecha_v'])."'><input type='hidden' name='rut_v' id='rut_v' value='".app_h_text($fila['rut_v'])."'><div class='bitacora-entry-body'><h5 class='mb-1'>".app_h_text($fecha)."</h5><small class='text-black-50'>".app_h_text($fila['editor_v'])."</small></div></button></form>";

	} 

	?>

	</div>
	</section>
	</div>
	</div>
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
