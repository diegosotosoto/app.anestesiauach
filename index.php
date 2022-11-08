<?php

	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
?>
<?php
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
?>
<!-  HEAD  ->	
	<?php
		//Conexión
		require("head.php");

	?>

</head>
<body>

<!-  NAVBAR  ->	

	<?php

		$boton_toggler="<button class='navbar-toggler shadow-sm btn-lg' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvas' aria-controls='offcanvas'>
      	<i class='fa-solid fa-bars' style='color:white'></i></button>";
		$titulo_navbar="Ficha Dolor HBV";
		$boton_navbar="<a class='btn btn-lg shadow-sm' href='nuevo_paciente.php' role='button'><i class='fa fa-plus fa-lg' style='color:white' aria-hidden='true'></i></a>";
		//Conexión
		require("navbar.php");
	?>
	<div class="container-sm">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasExampleLabel">
          <div class="offcanvas-header">
            <div class="" id="offcanvasExampleLabel"> </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
			$email_user=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
			$consulta_user="SELECT * FROM `usuarios_dolor` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";

			$confirma_user=$conexion->query($consulta_user); 

			if(mysqli_num_rows($confirma_user)==0){//No HACE NADA

			}else{ 
	
              echo "<form action='gestion_usuarios.php' method='post'><div class='text-primary pt-4 fs-5'>
              <i style='margin-left:12px' class='fa-solid fa-file-arrow-up'></i><input type='hidden' name='email_user_ad' value='$email_user'/>
              <button type='submit' class='btn btn-link' value='Submit'>Gestión Usuarios</button></div></form>";


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
</div>

<br>
<br>


	<?php 
		if($_POST['nombre_paciente']){
		//Guardar paciente Nuevo
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

			$consulta_conf="SELECT `rut` FROM `pacientes` WHERE `rut`='$rut' AND `de_alta` = '0'";

			$confirmar=$conexion->query($consulta_conf); 

			if(mysqli_num_rows($confirmar)==0){

					$consulta_n="INSERT INTO `pacientes` (`nombre_paciente`, `rut`, `ficha`, `unidad_cama`, `procedimiento`, `analgesia`, `nivel`, `espacio`, `distancia`, `solucion`, `infusion`, `bolo`, `lockout`, `peso`, `comentarios`, `de_alta`, `fecha_creacion`, `creador`) VALUES ('$nombre_paciente', '$rut', '$ficha', '$unidad_cama', '$procedimiento', '$analgesia', '$nivel', '$espacio', '$distancia', '$solucion', '$infusion', '$bolo', '$lockout', '$peso', '$comentarios', '$de_alta', '$fecha_creacion', '$creador') ";

					$escribir=$conexion->query($consulta_n);


					if($escribir==false){
						echo "Error en la consulta";

			}else{

				echo "
							<div class='alert alert-success alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Registro Guardado.
						  	</div>
				";

			}


			}else{
				echo "

							<div class='alert alert-warning alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Este Rut ya se encuentra en la base de datos.
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
