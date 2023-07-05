<?php

//1 Validador login
	require("valida_pag.php");


//Saca a los internos y otros becados del area de dolor
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`, `becad_otro`   FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1){
	  	header('Location: login.php');
	  }


//2 Variables con conexion
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");


	$formulario=htmlentities(addslashes($_POST['lista_v']));
	//ENVIA EL POST VISTA CON LA VARIABLE FORMULARIO PARA CANCELAR
		$boton_toggler="<form method='post' action='vista_paciente.php'><button class='btn d-sm-block d-sm-none shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' type='submit' name='vista' value='$formulario'><div class='text-white'><i class='d-sm-block d-sm-none fa fa-chevron-left'></i>Atrás</div></button></form>";
		$titulo_navbar="<p class='d-sm-block d-sm-none text-white'></p>";

		$boton_navbar="<a class='navbar-brand mr-auto ms-5 d-sm-block d-sm-none' href='#'' role='button'></a>";


//Carga Head de la página
	require("head.php");

	?>


<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

			<ul class="list-group">



	<?php

	$consulta_a="SELECT `nombre_paciente_v` FROM `visita_diaria` WHERE `rut_v` = '$formulario'";
	
	$busqueda_a=$conexion->query($consulta_a);

	$nombre_visit=$busqueda_a->fetch_assoc();


		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold'> Visitas de Dolor</h5>";


		//BOTON A LA IZQUIERDA DEL TITULO class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<form method='post' action='vista_paciente.php'><button class='btn float-start btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' type='submit' name='vista' value='$formulario'><div class='text-white'><i class='d-sm-block d-sm-none fa fa-chevron-left'></i>Atrás</div></button></form>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 pe-3 me-3 d-flex float-end'>
		<a>&nbsp;</a><a>&nbsp;</a>
		</div>";


		//SUBTITULO
		echo "<div class='mb-1 float-none'>".$nombre_visit['nombre_paciente_v']."</div>";
		echo "<div class='mb-1'></div></li>";
	?>

			</ul>



<div class="row text-center ps-2 pt-5">

		<div class="list-group">

	<?php 

	$consulta_b="SELECT `fecha_v`,`editor_v`,`rut_v` FROM `visita_diaria` WHERE `rut_v` = '$formulario'";
	
	$busqueda=$conexion->query($consulta_b);

		while($fila=$busqueda->fetch_assoc()){

		$phpdate = strtotime( $fila['fecha_v'] );
		$fecha = date( 'd-m-y H:i', $phpdate );

				echo "<form action='vista_visitas.php' method='post'><button class='list-group-item list-group-item-action' type='submit' value='Submit'><input type='hidden' name='fecha_v' id='fecha_v' value='".$fila['fecha_v']."'><input type='hidden' name='rut_v' id='rut_v' value='".$fila['rut_v']."'><h5 class='mb-1'>".$fecha."</h5><small class='text-black-50'>".$fila['editor_v']."</small></button></form>";

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
