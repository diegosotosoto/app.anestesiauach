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

		} elseif ($usuario['staff_']==1) {

		} elseif ($usuario['intern_']==1) {
			header('Location: bitacora_ingreso.php');
		} elseif ($usuario['becad_']==1) {
			header('Location: bitacora_ingreso.php');
		}


//VARIABLES
	
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Bitácora</span>";
		$boton_navbar="<a></a>";

	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-8 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->





<?php
//Guarda la Bitácora

				if($_POST['bitacora_autoriza']){


					$id_b=$_POST['bitacora_autoriza'];


					$consulta_us="UPDATE `bitacora_proced` SET `aprobado_staff_b`='1' WHERE `id_b`='$id_b'";
					

					$escribir_us=$conexion->query($consulta_us);


					if($escribir_us==false){
						echo "Error en la consulta";

					}else{

						echo "
									<div class='alert alert-success alert-dismissible fade show'>
								    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
								    <strong>Info!</strong> Bitácora Autorizada.
								  	</div>
						";

						} 


				}


?>


<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Validación</a>
  </li>
</ul>



			<ul class="list-group">
			<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><h4 class='mb-1 fw-bold pt-3'>Validar Bitácora</h4><div class='text-black-75 pt-1' style='font-size: 14px'> <?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?>	
			</div>
			</li>
			</ul>

		<!– TABLA DE REGISTROS –>
<div class='container text-center pt-3'>
		
<?php 




	$staff=$_COOKIE['hkjh41lu4l1k23jhlkj14'];

	$con_users="SELECT *  FROM `bitacora_proced` WHERE `aprobado_staff_b` = '0' AND `staff_b` = '$staff' ";

	$tab_users=$conexion->query($con_users);

	$sin_bitacoras=mysqli_num_rows($tab_users);

	if($sin_bitacoras==0){
		echo "<ul class='list-group'><li class='list-group-item py-5'><div class='opacity-50'> Sin Elementos que Validar</div></li></ul>";

	}


	while($row_user=$tab_users->fetch_assoc()){

		if($row_user['invasivo_eco_b']=="1"){ 
			$eco="Sí";
		}else {
			$eco="No";
		}	

		echo "<ul class='list-group'><form action='bitacora_autoriza.php' method='post'>";
		echo "<li class='list-group-item' style='background-color: #e9effb;'><br><h6 class='mb-1 pb-3 fw-bold'>".$row_user['autor_b']."</h6>";
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
