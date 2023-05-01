<?php
//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	

//Ve que cual es el nivel del usuario



//VARIABLES
	
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Bitácora</span>";
		$boton_navbar="<button class='btn shadow-sm border-light' style='; --bs-border-opacity: .1;' type='submit' form='form_ingreso_bit' value='Submit'><div class='text-white'>Guardar</div></button>";

	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->


<?php
//Guarda la Bitácora


			//GUARDAR EDICIÓN DE USUARIO
				if($_POST['rut_b']){

			$autor_b=strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj13']));
			$rut_b=htmlentities(addslashes(strtoupper($_POST['rut_b'])));
			$ficha_b=htmlentities(addslashes($_POST['ficha_b']));
			$edad_b=htmlentities(addslashes($_POST['edad_b']));

			$procedimiento_b=htmlentities(addslashes($_POST['procedimiento_b']));
			$fecha_b=htmlentities(addslashes($_POST['fecha_b']));
			$via_aerea_b=htmlentities(addslashes($_POST['via_aerea_b']));
			$vad_b=htmlentities(addslashes($_POST['vad_b']));
			$acceso_vascular_b=htmlentities(addslashes($_POST['acceso_vascular_b']));
			$invasivo_b=htmlentities(addslashes($_POST['invasivo_b']));

			if($_POST['invasivo_eco_b']=="1"){
				$invasivo_eco_b="1";
			}else{
				$invasivo_eco_b="0";
			}

			$neuroaxial_b=htmlentities(addslashes($_POST['neuroaxial_b']));
			$regional_b=htmlentities(addslashes($_POST['regional_b']));
			$dolor_b=htmlentities(addslashes($_POST['dolor_b']));

			$staff_b=htmlentities(addslashes($_POST['staff_b']));
			$comentarios_b=htmlentities(addslashes($_POST['comentarios_b']));



			$consulta_b="INSERT INTO `bitacora_proced` (`autor_b`, `rut_b`, `ficha_b`, `edad_b`, `procedimiento_b`, `fecha_b`, `via_aerea_b`, `vad_b`, `acceso_vascular_b`, `invasivo_b`, `invasivo_eco_b`, `neuroaxial_b`, `regional_b`, `dolor_b`, `staff_b`, `comentarios_b`) VALUES ('$autor_b','$rut_b', '$ficha_b', '$edad_b', '$procedimiento_b', '$fecha_b', '$via_aerea_b', '$vad_b', '$acceso_vascular_b', '$invasivo_b', '$invasivo_eco_b', '$neuroaxial_b', '$regional_b', '$dolor_b', '$staff_b', '$comentarios_b') ";
			

			$escribir_b=$conexion->query($consulta_b);


			if($escribir_b==false){
				echo "Error en la consulta";

			}else{

				echo "
							<div class='alert alert-success alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Registro Guardado.
						  	</div>
				";

			} 
		}







?>

<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Ingreso</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
  </li>
</ul>


	<form class="needs-validation" name="form_ingreso_bit" id="form_ingreso_bit" method="post" action="bitacora_ingreso.php" novalidate>
<!-  NAVBAR  ->	


			<ul class="list-group">
			<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><h4 class='mb-1 fw-bold pt-3'>Bitácora de</h4><div class='text-black-75 pb-3 pt-1' style='font-size: 14px'> <?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?>	
			</div>
			</li>
			</ul>


		<!– TABLA DE REGISTROS –>
				<div class='container'>
				<div class='row'>	
				<div class='col'>


				</div>
				</div>
				</div>



	


</div>


<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
		require("footer.php");

	?>





<!-  FOOTER  ->
