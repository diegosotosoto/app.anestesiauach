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
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='vista_epa.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Nuevo</span>";
		$boton_navbar="<button class='btn shadow-sm border-light' style='; --bs-border-opacity: .1;' type='submit' form='form_epa' value='Submit'><div class='text-white'>Agregar</div></button>";

	//Carga Head de la página
	require("head.php");

?>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
               -webkit-appearance: none;
                margin: 0;
        }
 
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->


	<form class="needs-validation" name="form_epa" id="form_epa" method="post" action="vista_epa.php" novalidate>

	<input type="hidden" name="mail_user_epa" id="mail_user_epa" value="<?php echo $check_usuario;?>">

<!-  NAVBAR  ->	

			<ul class="list-group">

	<!– TABLA DE REGISTROS –>
	<?php
		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold opacity-75'>Evaluación Preanestésica</h5>";

		//BOTON A LA IZQUIERDA DEL TITULO class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' href='vista_epa.php'><i class='fa fa-chevron-left'></i>Atrás</a>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<span class='float-end'>
		<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
		<button class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;' type='submit' form='form_epa' value='Submit'><div class='text-white'>Agregar</div></button>
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
			<button class='btn pull-right btn-primary shadow-sm border-light' style='; --bs-border-opacity: .1;' type='submit' form='form_epa' value='Submit'><div class='text-white'>Guardar Visita</div></button>
			</div>
		</span></form>";

		require("formulario_epa.php");

	?>


<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
	?>


<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>