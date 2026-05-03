<?php

//1 Validador login
	require("valida_pag.php");


	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	//Saca a los internos y otros becados del area de vpa
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`, `becad_otro`   FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1){
	  	header('Location: login.php');
	  }

//VARIABLES
			$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='vista_epa.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
			$titulo_navbar="<span>Nuevo</span>";
			$boton_navbar="<button class='btn btn-app-primary navbar-save-btn' type='submit' form='form_epa' value='Submit'>Agregar</button>";

	//Carga Head de la página
	require("head.php");

?>
	<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
	<div class="apunte-surface">
	<div class="container-fluid px-0 px-md-2">
	<div class="epa-shell">


	<form class="needs-validation" name="form_epa" id="form_epa" method="post" action="vista_epa.php" novalidate>

	<input type="hidden" name="mail_user_epa" id="mail_user_epa" value="<?php echo $check_usuario;?>">

<!-  NAVBAR  ->	

			<ul class="list-group">

	<!– TABLA DE REGISTROS –>
	<?php
		//TITULO DE LA PAGINA
			echo "<li class='list-group-item epa-section-title'><h5 class='mb-1 fw-bold opacity-75'>Evaluación Preanestésica</h5>";

			//BOTON A LA IZQUIERDA DEL TITULO
			echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
			<a class='admin-back-btn d-none d-sm-inline-flex' href='vista_epa.php'><i class='fa fa-chevron-left'></i>Atrás</a>
			</div>";

			//BOTÓN A LA DERECHA DEL TITULO
			echo "<span class='float-end'>
			<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
			<button class='btn btn-app-primary pain-action-btn d-none d-sm-inline-flex' type='submit' form='form_epa' value='Submit'>Agregar</button>
			</div>
			</span>";

		//SUBTITULO
		echo "<div class='mb-1'></div>";
		echo "<div class='mb-1'></div></li>";


// CAMPOS DEL FORMULARIO DESHABILITADOS
$is_disabled = false; // desabilita select, inputs y checkbox //   true / false
$is_disabled_html = "";// desabilita objetos escritos en html //  disabled / ""
$is_disabled_html_ta = ""; // desabilita los objetos textarea html // readonly / ""
$is_disabled_dp = ""; //desabilita los datepickers //  1 / ""
$is_required = "required"; //alergias requeridas** // required / ""


//******** desabilita lo botones de guardado?

	$boton_final = "<span class='float-end pe-3 pb-5'>
				<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
				<button class='btn btn-app-primary pain-action-btn' type='submit' form='form_epa' value='Submit'>Guardar Visita</button>
				</div>
			</span></form>";

		require("formulario_epa.php");

	?>


<!- chequear que no haya otro ingresado antes -> 

	</div>
	</div>
	</div>
	</div>

	<?php 

		$conexion->close();
	?>


<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>
