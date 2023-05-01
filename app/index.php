<?php
//1 Validador login
	require("valida_pag.php");

//2 Variables
	$boton_toggler="<a class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></a>";

 	$titulo_navbar="<div class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></div>";

	$boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

//3 Carga Head de la página
	require("head.php");
 
?>


<div class="col col-sm-9 col-xl-9 pb-5 mx-0"><!- Columna principal (derecha) responsive->

		<?php 
					//GUARDAR PACIENTE NUEVO

			if($_POST['nombre_paciente']){
				$nombre_paciente=htmlentities(addslashes($_POST['nombre_paciente']));
				$rut=htmlentities(addslashes(strtoupper($_POST['rut'])));
				$ficha=htmlentities(addslashes($_POST['ficha']));
				$unidad_cama=htmlentities(addslashes($_POST['unidad_cama']));
				$procedimiento=htmlentities(addslashes($_POST['procedimiento']));
				$analgesia=htmlentities(addslashes($_POST['analgesia']));
				$nivel=htmlentities(addslashes($_POST['nivel']));
				$espacio=htmlentities(addslashes($_POST['espacio']));
				$distancia=htmlentities(addslashes($_POST['distancia']));
				$solucion=htmlentities(addslashes($_POST['solucion']));
				$infusion=htmlentities(addslashes($_POST['infusion']));
				$bolo=htmlentities(addslashes($_POST['bolo']));
				$lockout=htmlentities(addslashes($_POST['lockout']));
				$peso=htmlentities(addslashes($_POST['peso']));
				$comentarios=htmlentities(addslashes($_POST['comentarios']));
				$de_alta=0;
				$fecha_creacion=date("Y-m-d H:i:s",strtotime('-4 hour'));
				$creador=ucwords(strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj14'])));


				//PRIMERO BUSCA SI EL RUT EXISTE PREVIAMENTE Y ESTA ACTIVO
				$consulta_conf="SELECT `rut`, `nombre_paciente`,`ficha` FROM `pacientes` WHERE `rut`='$rut' AND `de_alta` = '0'";

				$confirmar=$conexion->query($consulta_conf); 

				if(mysqli_num_rows($confirmar)==0){

				//SEGUNDO BUSCA SI EL RUT EXISTE PREVIAMENTE Y ESTA DADO DE ALTA
						$consulta_conf_2="SELECT `rut`, `nombre_paciente`,`ficha` FROM `pacientes` WHERE `rut`='$rut' AND `de_alta` = '1'";

						$confirmar_2=$conexion->query($consulta_conf_2); 

						if(mysqli_num_rows($confirmar_2)==0){

									$consulta_n="INSERT INTO `pacientes` (`nombre_paciente`, `rut`, `ficha`, `unidad_cama`, `procedimiento`, `analgesia`, `nivel`, `espacio`, `distancia`, `solucion`, `infusion`, `bolo`, `lockout`, `peso`, `comentarios`, `de_alta`, `fecha_creacion`, `creador`) VALUES ('$nombre_paciente', '$rut', '$ficha', '$unidad_cama', '$procedimiento', '$analgesia', '$nivel', '$espacio', '$distancia', '$solucion', '$infusion', '$bolo', '$lockout', '$peso', '$comentarios', '$de_alta', '$fecha_creacion', '$creador') ";

										$escribir=$conexion->query($consulta_n);


										if($escribir==false){
											echo "Error en la consulta";

										}else{//NO EXISTE PREVIAMENTE NI FUE DADO DE ALTA

													echo "</br>
																<div class='alert alert-success alert-dismissible fade show'>
															    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
															    <strong>Info!</strong> Registro Guardado.
															  	</div>
													";
										}

						}else{ // EXISTE Y SE ENCUENTRA DADO DE ALTA

									$datos_alta=$confirmar_2->fetch_assoc();

									echo "
														<div class='alert alert-warning alert-dismissible fade show'>
													    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
													    <strong>Info!</strong> Este Rut ya se encuentra en la base de datos, EN ESTADO DADO DE ALTA.</br>
													    Nombre: ".$datos_alta['nombre_paciente']."</br> Rut: ".$datos_alta['rut']."</br> Ficha: ".$datos_alta['ficha']."
													  	</br>Desea Reactivar?
													  	</br>
													  	<form action='editar_paciente.php' method='post'>
													  	<input type='hidden' name='reactivar' value='yes'>
													  	<input type='hidden' name='reactivar' value='yes'>
													  	<input type='hidden' name='reactivar' value='yes'>

													  	<button class='btn shadow-sm' type='submit' name='editar' value='".$datos_alta['rut']."' />Reactivar!</button></form>
													  	</div>
											";   ////******   al enviar formulario debe editar al paciente sacarlo del alta y agregar los datos nuevos, excepto la ficha y nombre

						}


				}else{ // EXISTE Y SE ENCUENTRA ACTIVO
							echo "
										<div class='alert alert-danger alert-dismissible fade show'>
									    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
									    <strong>Info!</strong> Este Rut ya se encuentra ACTIVO en la base de datos.
									  	</div>
							";
				}



			}

		//Expluye Dolor de Cuentas de Internos
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' AND `verified`  = '1'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']!=1){


		echo "
					<div class='row pt-5 ps-0 pe-0'>
					    <div class='col text-center  ps-0 pe-0'>
					      <a href='nuevo_paciente.php' class='btn shadow btn-success ms-2 rounded-3 border-0 text-white' style='height: 150px;width: 150px; background-color: #016932; background-image: linear-gradient(62deg, #016932 0%, #009044 36%, #08d869 83%, #70fbb4 100%);
						'><i class='fa-solid fa-user-plus fa-2xl pt-5'></i><div class='text-center pt-3'>Nuevo<br> Paciente</div></a>
					    </div>

						<div class='col text-center ps-0 pe-0'>
					      <a href='hoja_dolor.php' class='btn shadow me-2 rounded-3 border-0 text-white' style='height: 150px;width: 150px; background-color: #026edd;background-image: linear-gradient(62deg, #026edd 33%, #41aafd 83%, #92c6f9 100%);
						'><i class='fa-solid fa-syringe fa-2xl pt-5'></i><div class='text-center pt-3 ps-2 pe-2'>Pacientes Dolor</div></a>
					    </div>
					</div>
					";


	  }





?>


			<div class="row pt-5  ps-0 pe-0">
			    <div class="col text-center  ps-0 pe-0">
			      <a href='telefonos.php' class="btn shadow btn-success ms-2 rounded-3 border-0 text-white" style="height: 150px;width: 150px; background-color: #6405d0; background-image: linear-gradient(62deg, #6405d0 32%, #9b4df1 78%, #cea3fb 100%);"><i class="fa-solid fa-phone fa-2xl pt-5"></i><div class="text-center pt-3">Teléfonos<br> Frecuentes</div></a>
			    </div>

			    <div class="col text-center ps-0 pe-0">
			      <a href="apuntes.php" class="btn shadow me-2 rounded-3 border-0" style="height: 150px;width: 150px; background-color: #fd980f;background-image: linear-gradient(62deg, #fd980f 30%, #f7de68 83%, #fff5b4 100%);
				"><div class="opacity-75"><i class="fa-solid fa-calculator fa-2xl pt-5"></i><div class="text-center pt-3 ps-2 pe-2">Cálculos</div></div></a>
			    </div>


			</div>

			<div class="row pt-5  ps-0 pe-0">

			    <div class="col text-center ps-0 pe-0">
			      	<a href="bitacora.php" class="btn shadow btn-danger ms-2 bg-opacity-25 rounded-3 border-0" style="height: 150px;width: 150px; background-color: #CE2E2E; background-image: linear-gradient(62deg, #CE2E2E 25%, #f73f3f 83%, #ff8080 100%);
					"> <i class="fa-solid fa-clipboard fa-2xl pt-5"></i><div class="text-center pt-3 ps-2 pe-2">Bitácora Procedimientos</div></a>
			    </div>

			    <div class="col text-center ps-0 pe-0">
			      	<a href="correos.php" class="btn shadow btn-danger me-2 bg-opacity-25 rounded-3 border-0" style="height: 150px;width: 150px; background-color: #29A09B; background-image: linear-gradient(62deg, #29A09B 25%, #7BD3CE 83%, #DDF3F2 100%);
					"> <i class="fa-solid fa-envelope fa-2xl pt-5"></i><div class="text-center pt-3 ps-2 pe-2">Directorio<br>Correos</div></a>
			    </div>
			</div>


		</div>
	</div>

</div>



<!-  CIERRE DE CONEXION  ->
  <?php 
    //Cierre Conexión
    $conexion->close();
  ?>


<!-  FOOTER  ->
	<?php
		//Conexión
		require("footer.php");

	?>



