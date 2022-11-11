<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
	//Carga Head de la página
	require("head.php");

?>

</head>
<body>

<!-  NAVBAR  ->	

	<?php
		//Botones del Toggle NAVBAR


		$boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:70px; height:40px'><i class='fa-solid fa-bars' style='color:white'></i></button>";
		$titulo_navbar="Ficha Dolor HBV";
		$boton_navbar="<a class='btn btn-lg shadow-sm' href='nuevo_paciente.php' role='button'><i class='fa fa-plus fa-lg' style='color:white' aria-hidden='true'></i></a>";
		//Conexión
		require("navbar.php");
	?>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">


            <div class="" id="offcanvasExampleLabel"><h5><?php echo $_COOKIE['hkjh41lu4l1k23jhlkj14']; ?></h5></div>

          <div class="text-muted"><?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?></div>
          <hr>
              <div class="text-primary pt-4 fs-5">
              <i style="margin-left:10px" class="fa-solid fa-door-open"></i>
              <a style="padding-left:5px" href='cierra_sesion.php'> Cerrar sesión</a></div>

              <div class="text-primary pt-4 fs-5">
              <i style="margin-left:12px" class="fa-solid fa-file-arrow-up"></i>
              <a style="padding-left:8px" href='acerca_de.php'> Acerca de</a></div>


				<?php 

							//BUSCA SI EL USUARIO ES ADMIN Y AGREGA MENÚ DE ADMIN
							$email_user=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
							$consulta_user="SELECT * FROM `usuarios_dolor` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";

							$confirma_user=$conexion->query($consulta_user); 

							if(mysqli_num_rows($confirma_user)==0){//AL NO ENCONRAR REGISTROS DE ADMIN NO AGREGA NADA

							}else{ 
					
				              echo "<form id='gest_users' action='gestion_usuarios.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
				              <div class='text-primary pt-4 fs-5'>
				              <i style='margin-left:10px' class='fa-solid fa-users'></i>
				              <a style='padding-left:5px' href='#' onclick='envioForm()'> Gestión Usuarios</a></div></form>
				              <script>function envioForm() {document.getElementById('gest_users').submit(); }</script>
				              ";
							}

				?>
              <div class="fixed-bottom mb-6"><hr>
                <div class="container">
                <div class="row">
                  <div class="col text-muted">
                    <i class="fa-solid fa-user-gear" style="margin-left:40px"></i><small style="padding-left:15px">Diego Soto Soto - 2022</small></div>
                </div>
              </div></div>

        </div>
      </div>


<br>
<br>


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
			$fecha_creacion=date("Y-m-d H:i:s");
			$creador=ucwords(strtolower($_COOKIE['hkjh41lu4l1k23jhlkj14']));


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

												echo "
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
												  	</br>
												  	<form action='editar_paciente.php' method='post'><button class='btn shadow-sm' type='submit' name='editar' value='".$datos_alta['rut']."' />Desea Reactivar?</button></form>
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
	?>

		<div class="list-group py-3">

	<?php 

	$consulta_b="SELECT `nombre_paciente`,`rut`,`analgesia` FROM `pacientes` WHERE `de_alta` = '0'";

	$busqueda=$conexion->query($consulta_b);



		while($fila=$busqueda->fetch_assoc()){

				echo "<form action='vista_paciente.php' method='post'><button class='list-group-item list-group-item-action' type='submit' name='vista' value='".$fila['rut']."' /><h5 class='mb-1'>".$fila['nombre_paciente']."</h5><p class='mb-1'>".$fila['rut']."</p>
    <small class='text-muted'>".$fila['analgesia']."</small></button></form>";

	} 


	?>

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
