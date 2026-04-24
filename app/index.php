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

<div class="dashboard-grid pt-5">

      <a href='links.php'
         class='btn shadow dashboard-tile rounded-3 border-0'
         style='background-image:linear-gradient(145deg,#0a7d3d 0%,#18b565 55%,#7fe0b0 100%);'>
    <i class="fa-solid fa-link fa-2xl"></i>
        <div class='tile-label'>Links<br>Útiles</div>
      </a>


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
											echo "
																<div class='alert alert-danger alert-dismissible fade show'>
															    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
															    <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
															  	</div>
													";

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





//Saca a los internos y otros becados del area de dolor  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
  $con_users_b="SELECT `intern_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
  $users_b=$conexion->query($con_users_b);
  $usuario=$users_b->fetch_assoc();

  if(!($usuario['intern_']==1 or $usuario['becad_otro']==1)){
    echo "
      <a href='hoja_dolor.php'
         class='btn shadow dashboard-tile rounded-3 border-0'
         style='background-image:linear-gradient(145deg,#0f63d8 0%,#2d7fe0 55%,#7fb3f2 100%);'>
        <i class='fa-solid fa-syringe fa-2xl'></i>
        <div class='tile-label'>Pacientes<br>Dolor</div>
      </a>
    ";
  }
  ?>



  <a href="bitacora.php"
     class="btn shadow dashboard-tile rounded-3 border-0"
     style="background-image:linear-gradient(145deg,#c82333 0%,#e03a48 55%,#f29aa2 100%);">
    <i class="fa-solid fa-clipboard fa-2xl"></i>
    <div class="tile-label">Bitácora<br>Procedimientos</div>
  </a>

  <a href="apuntes.php"
     class="btn shadow dashboard-tile tile-gold rounded-3 border-0"
     style="background-image:linear-gradient(145deg,#e69500 0%,#f2b632 55%,#f5e3a3 100%);">
    <i class="fa-solid fa-calculator fa-2xl"></i>
    <div class="tile-label">
    	Cálculos<br>y Apuntes
    </div>
  </a>

  <a href="telefonos.php"
     class="btn shadow dashboard-tile rounded-3 border-0"
     style="background-image:linear-gradient(145deg,#5b00b3 0%,#7d2ae8 55%,#c3a5f5 100%);">
    <i class="fa-solid fa-phone fa-2xl"></i>
    <div class="tile-label">Teléfonos<br>Frecuentes</div>
  </a>

  <a href="correos.php"
     class="btn shadow dashboard-tile rounded-3 border-0"
     style="background-image:linear-gradient(145deg,#1f8a8c 0%,#4fb3b5 55%,#bfe4e5 100%);">
    <i class="fa-solid fa-envelope fa-2xl"></i>
    <div class="tile-label">Directorio<br>Correos</div>
  </a>

  <a href="vista_epa.php"
     class="btn shadow dashboard-tile rounded-3 border-0"
     style="background-image:linear-gradient(145deg,#d94c00 0%,#f57a2a 55%,#ffd3b0 100%);">
    <i class="fa-solid fa-clipboard fa-2xl"></i> 
    <div class="tile-label">
      Evaluación<br>Preanestésica
      <span class="beta-pill">Beta</span>
    </div>
  </a>


  <a href="https://uachcl-my.sharepoint.com/:f:/r/personal/docentes_anestesia_uach_cl/Documents/Reuniones%20Clinicas?e=5%3a1d4a50a99f8747659eaf40e9bd942188&sharingv2=true&fromShare=true&at=9"
     target="_blank"
     class="btn shadow dashboard-tile rounded-3 border-0"
     style="background-image:linear-gradient(145deg,#9e0059 0%,#c2187a 55%,#e5a3c6 100%);">
    <i class="fa-solid fa-chalkboard-user fa-2xl"></i>
    <div class="tile-label">Reuniones<br>Clínicas</div>
  </a>


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



