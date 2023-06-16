<?php
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
			header('Location: login.php');
		}

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");


	//redirección segun nivel de usuario: BECADO
	$check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	$con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
	$users_b=$conexion->query($con_users_b);
	$usuario=$users_b->fetch_assoc();
	if($usuario['admin']==1){
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['staff_']==1) {
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['intern_']==1) {
 			header('Location: bitacora_internos.php');
		} elseif ($usuario['becad_']==1) {
			//CONTINUA EN LA PAGINA
		}


	  //Variables

		$boton_toggler="<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='; --bs-border-opacity: .1;' href='bitacora_rechazos.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
		$boton_navbar="<a></a><a></a>";

	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link" href="bitacora_ingreso.php">Ingreso</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
  </li>
   <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Rechazos</a>
  </li> 
</ul>


<ul class="list-group">


 
	<?php
		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold'> Rechazos Bitácoras</h5>";


		//BOTON A LA IZQUIERDA DEL TITULO
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' href='bitacora_rechazos.php'><i class='fa fa-chevron-left'></i>Atrás</a>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO
		echo "<span class='float-end'>
		<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
		<a class='pe-5'></a>
		</div>
		</span>";

		//SUBTITULO
		echo "<div class='mb-1'></div>";
		echo "<div class='mb-1'></div></li>";
	?>


		<!– TABLA DE REGISTROS –>
<div class='container text-center pt-3'>
		
<?php 


	//mensaje sin elementos que validar
	$autor_b=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	$staff_b=$_POST['nombre_staff'];

	$con_users="SELECT *  FROM `bitacora_proced` WHERE `aprobado_staff_b` = '3' AND `autor_b` = '$autor_b' AND `staff_b` = '$staff_b' ";
	$tab_users=$conexion->query($con_users);
	$sin_bitacoras1=mysqli_num_rows($tab_users);


	if($sin_bitacoras1==0){
		echo "<ul class='list-group'><li class='list-group-item py-5'><div class='opacity-50'> Sin Elementos que Validar</div></li></ul>";

	}

//Bitácora de Becados

	while($row_user=$tab_users->fetch_assoc()){

		if($row_user['invasivo_eco_b']=="1"){ 
			$eco="Sí";
		}else {
			$eco="No";
		}	

		$email_int=$row_user['autor_b'];
		$consulta_int="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int' AND `verified` = '1'";
		$confirma_int=$conexion->query($consulta_int);
		$rows = $confirma_int->fetch_assoc();


		echo "<ul class='list-group'><form action='bitacora_autoriza.php' method='post'>";
		echo "<li class='list-group-item' style='background-color: #e9effb;'>";
		echo "<div class='d-flex justify-content-between'> <div>".$row_user['fecha_b']."</div> <div>".$row_user['rut_b']."</div> <div>".$row_user['ficha_b']."</div> </div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Edad</div><div class='text-end'>".$row_user['edad_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Procedimiento</div><div>".$row_user['procedimiento_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Via Aérea</div><div>".$row_user['via_aerea_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Manejo VAD</div><div>".$row_user['vad_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Acceso Vascular</div><div>".$row_user['acceso_vascular_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Uso de Eco</div><div>".$eco."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>P. Invasivo</div><div>".$row_user['invasivo_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>A. Venoso Central</div><div>".$row_user['cvc_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>A. Neuroaxial</div><div>".$row_user['neuroaxial_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>A. Regional</div><div class='text-end'>".$row_user['regional_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>P. Dolor</div><div>".$row_user['dolor_b']."</div></div></li>";	
		echo "<input type='hidden' name='bitacora_autoriza' value='".$row_user['id_b']."'/>";
		echo "<li class='list-group-item' style='background-color: #e9effb;'>Comentarios</li>";				
		echo "<li class='list-group-item py-2'><div class='py-4'>".$row_user['comentarios_b']."</div></li>";
		echo "<li class='list-group-item' style='background-color: #e9effb;'>Feedback</li>";		
		echo "<li class='list-group-item mb-2 py-2'><div class='py-4'>".$row_user['feedback_b']."</div></li>";


		echo "<hr></br>";
	}
				

?>





			</ul>
					</div>







	





<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>
