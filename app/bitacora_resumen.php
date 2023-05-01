<?php
//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
	//redirección segun nivel de usuario
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


//VARIABLES
	
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Bitácora</span>";
		$boton_navbar="<a></a>";

	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-8 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Validación</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="bitacora_revision.php">Revisión</a>
  </li>  
</ul>



			<ul class="list-group">
			<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><h4 class='mb-1 fw-bold pt-2'>Resumen Bitácoras</h4><div class='text-black-75 pt-1' style='font-size: 14px'> 
			</div>
			</li>
			</ul>

		<!– TABLA DE REGISTROS –>
<div class='container text-center pt-3'>
		
<?php 


	//mensaje sin elementos que validar
	$staff=$_COOKIE['hkjh41lu4l1k23jhlkj14'];

	$con_users="SELECT *  FROM `bitacora_proced` WHERE `aprobado_staff_b` = '0' AND `staff_b` = '$staff' ";
	$tab_users=$conexion->query($con_users);
	$sin_bitacoras1=mysqli_num_rows($tab_users);

	$con_internos="SELECT *  FROM `bitacora_internos` WHERE `aprobado_staff_i` = '0' AND `staff_i` = '$staff' ";
	$tab_internos=$conexion->query($con_internos);
	$sin_bitacoras2=mysqli_num_rows($tab_internos);

	if($sin_bitacoras1==0 and $sin_bitacoras2==0){
		echo "<ul class='list-group'><li class='list-group-item py-5'><div class='opacity-50'> Sin Elementos que Validar</div></li></ul>";

	}


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
		echo "<li class='list-group-item' style='background-color: #e9effb;'><br><h6 class='mb-1 pb-3 fw-bold'>Becado: ".$rows['nombre_usuario']."</h6>";
		echo "<div class='d-flex justify-content-between'> <div>".$row_user['fecha_b']."</div> <div>".$row_user['rut_b']."</div> <div>".$row_user['ficha_b']."</div> </div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Edad</div><div class='text-end'>".$row_user['edad_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Procedimiento</div><div>".$row_user['procedimiento_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Via Aérea</div><div>".$row_user['via_aerea_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Manejo VAD</div><div>".$row_user['vad_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Acceso Vascular</div><div>".$row_user['acceso_vascular_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Uso de Eco</div><div>".$eco."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>P. Invasivo</div><div>".$row_user['invasivo_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>A. Neuroaxial</div><div>".$row_user['neuroaxial_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>A. Regional</div><div class='text-end'>".$row_user['regional_b']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>P. Dolor</div><div>".$row_user['dolor_b']."</div></div></li>";	
		echo "<input type='hidden' name='bitacora_autoriza' value='".$row_user['id_b']."'/>";
		echo "<li class='list-group-item' style='background-color: #e9effb;'>Comentarios</li>";				
		echo "<li class='list-group-item mb-2 py-2'><div class='py-4'>".$row_user['comentarios_b']."</div></li>";
		echo "<div class='text-primary pt-4'>Agregar Feedback</div><textarea class='form-control mb-2' style='resize: none;' maxlength='200' rows='3' name='comentarios_b_a' id='comentarios_b_a'></textarea>
			 ";
		echo "<div class='col'><button class='btn btn-primary' type='submit' value'Submit'>Autorizar</button></div></form></ul></br>";
		echo "<hr></br>";
	}


	while($row_int=$tab_internos->fetch_assoc()){


		if($row_int['evaluacion_i']=="1"){ 
			$evaluacion_i="Completa";
		}elseif($row_int['evaluacion_i']=="2"){
			$evaluacion_i="Incompleta";
		}elseif($row_int['evaluacion_i']=="3"){
			$evaluacion_i="No Realizada";
		}

		if($row_int['ventilacion_i']=="1"){ 
			$ventilacion_i="Solo";
		}elseif($row_int['ventilacion_i']=="2"){
			$ventilacion_i="Con Ayuda";
		}elseif($row_int['ventilacion_i']=="3"){
			$ventilacion_i="Fallida";
		}

		if($row_int['intubacion_i']=="1"){ 
			$intubacion_i="Solo";
		}elseif($row_int['intubacion_i']=="2"){
			$intubacion_i="Con Ayuda";
		}elseif($row_int['intubacion_i']=="3"){
			$intubacion_i="Fallida";
		}


		if($row_int['ayudas_i']=="1"){ 
			$ayudas_i="Solo";
		}elseif($row_int['ayudas_i']=="2"){
			$ayudas_i="Con Ayuda";
		}elseif($row_int['ayudas_i']=="3"){
			$ayudas_i="Fallida";
		}


		if($row_int['lma_i']=="1"){ 
			$lma_i="Solo";
		}elseif($row_int['lma_i']=="2"){
			$lma_i="Con Ayuda";
		}elseif($row_int['lma_i']=="3"){
			$lma_i="Fallida";
		}

		if($row_int['vvp_i']=="1"){ 
			$vvp_i="Solo";
		}elseif($row_int['vvp_i']=="2"){
			$vvp_i="Con Ayuda";
		}elseif($row_int['vvp_i']=="3"){
			$vvp_i="Fallida";
		}

		if($row_int['espinal_i']=="1"){ 
			$espinal_i="Solo";
		}elseif($row_int['espinal_i']=="2"){
			$espinal_i="Con Ayuda";
		}elseif($row_int['espinal_i']=="3"){
			$espinal_i="Fallida";
		}



		$email_int2=$row_int['autor_i'];
		$consulta_int2="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int2' AND `verified` = '1'";
		$confirma_int2=$conexion->query($consulta_int2);
		$rows2 = $confirma_int2->fetch_assoc();


		echo "<ul class='list-group'><form action='bitacora_autoriza.php' method='post'>";
		echo "<li class='list-group-item' style='background-color: #e9effb;'><br><h6 class='mb-1 pb-3 fw-bold'>Interno: ".$rows2['nombre_usuario']."</h6>";
		echo "<div class='d-flex justify-content-between'> <div>".$row_int['fecha_i']."</div> <div>".$row_int['rut_i']."</div> <div>".$row_int['ficha_i']."</div> </div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Edad</div><div class='text-end'>".$row_int['edad_i']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Procedimiento</div><div>".$row_int['procedimiento_i']."</div></div></li>";

		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Eval.Preanestésica</div><div>".$evaluacion_i."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Ventilación</div><div>".$ventilacion_i."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Intubación</div><div>".$intubacion_i."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Máscara Laríngea</div><div>".$ayudas_i."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Conductor/Bougie</div><div>".$lma_i."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Vía Venosa Periférica</div><div class='text-end'>".$vvp_i."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Espinal/Raquidea</div><div class='text-end'>".$espinal_i."</div></div></li>";
		echo "<input type='hidden' name='bitacora_autoriza_i' value='".$row_int['id_i']."'/>";
		echo "<li class='list-group-item' style='background-color: #e9effb;'>Comentarios</li>";				
		echo "<li class='list-group-item mb-2 py-2'><div class='py-4'>".$row_int['comentarios_i']."</div></li>";
		echo "<div class='text-primary pt-4'>Agregar Feedback</div><textarea class='form-control mb-2' style='resize: none;' maxlength='200' rows='3' name='comentarios_i_a' id='comentarios_i_a'></textarea>
	  ";
		echo "<div class='col'><button class='btn btn-primary' type='submit' value'Submit'>Autorizar</button></div></form></ul></br>";
		echo "<hr></br>";


	}








?>
					
					</div>
			</div>			



	


</div>


<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
		require("footer.php");

	?>





<!-  FOOTER  ->
