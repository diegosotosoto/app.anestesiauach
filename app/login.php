<?php

  //si existe la cookie se salta el area de login y va al index
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){

	}else{
				header('Location: index.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);

	$conexion->set_charset("utf8");



	if(empty($_POST['email_usuario_v'])){
		//no hace nada si no hay post
	}
	else{ //cuando existe post
		$email_usuario_v=htmlentities(addslashes($_POST['email_usuario_v']));
		$pass_usuario_v=htmlentities(addslashes($_POST['pass_usuario_v']));

		$sql="SELECT `password`,`nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario_v' AND `verified`= '1'";
		$result_sql=$conexion->query($sql);

		if(mysqli_num_rows($result_sql)==0){


					$alerta_login = "
							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Usuario o Contraseña no válidos.
						  	</div>
		      ";

				}else{
				$usuario=$result_sql->fetch_assoc();
				$confirma_pass=password_verify($pass_usuario_v,$usuario['password']);
				if($confirma_pass){

					$galletita_mail=$email_usuario_v;
					$galletita_user=$usuario['nombre_usuario'];
					setcookie("hkjh41lu4l1k23jhlkj13",$galletita_mail, time()+60*60*24*30*6);
					setcookie("hkjh41lu4l1k23jhlkj14",$galletita_user, time()+60*60*24*30*6);

					header('Location: index.php');
					
				}else{

					$alerta_login =  "

							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Usuario o Contraseña no válidos.
						  	</div>

		      ";

			}
	}

}

	//Variables
		$boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></button>";

	  	$titulo_navbar="<span class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></span>";

		$boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

	//Carga Head de la página
		require("head.php");

?>

<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->
<div class="row justify-content-md-center">

					<?php


					if(empty($_POST['email_usuario'])){

					}else{
						$email_usuario=htmlentities(addslashes($_POST['email_usuario']));
						$nombre_usuario=htmlentities(addslashes($_POST['nombre_usuario']));
						$pass_usuario=htmlentities(addslashes($_POST['pass_usuario']));		
						$pass_cifrado=password_hash($pass_usuario, PASSWORD_DEFAULT);


						$chequea_email="SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario' AND `verified`= '1'";
						$result=$conexion->query($chequea_email);
						$conteo=mysqli_num_rows($result);

						if($conteo==0){
							
							$nuevo_usuario="INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`) VALUES ('$nombre_usuario','$email_usuario','$pass_cifrado')";

							$registro_usuario=$conexion->query($nuevo_usuario);

							$alerta_login = "
												<div class='alert alert-success alert-dismissible fade show'>
										    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
										    <strong>Info!</strong> Se ha Registrado un Nuevo Usuario. <br> ***Para ingresar PRIMERO comunícate con un Administrador para validar tu cuenta!***
										  	</div>

							";


						}else{

							$alerta_login = "
											<div class='alert alert-danger alert-dismissible fade show'>
										    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
										    <strong>Info!</strong> Error en el registro, contacte al administrador.
										  	</div>

				      ";
						}
					}

					?>


				<?php



				 if($alerta_login){

				 	echo $alerta_login;

				 }




				?>




				<form class="needs-validation" action="login.php" method="post" novalidate autocomplete="nope">
				<div class="container text-center mt-4 pt-4">
				  <a href="#" class="btn shadow bg-primary me-2 rounded-3 text-white border-0 pt-2" style="height: 150px;width: 320px; background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 0%, #44B2FF 100%);">
				  <div class="row pt-4">
				  	<h1>¡Hola!<i class="fa-solid fa-face-smile-wink ps-3"></i></h1>
				  </div>
				  <div class="row pt-3">
				    <div class="col">
				      Por favor, ingresa tus datos!
				    </div>
				  </div>
				</a>
				  <div class="row pt-4 justify-content-md-center">
				    <div class="col col-lg-6">
							<div class='text-muted pt-3'>E-Mail</div>
							<div class="input-group mb-2">
				    	<input type="email" name="email_usuario_v" class="form-control" required/>
				    	<span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="fa fa-envelope"></i></span>
				    </div>
				  </div>
				</div>






				  <div class="row pt-3 justify-content-md-center">
				    <div class="col col-lg-6">
							<div class='text-muted pt-3'>Contraseña</div>
							<div class="input-group mb-2">
<input type="password" name="pass_usuario_v" id="pass_usuario_v" class="form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary border-secondary border-opacity-25" type="button" id="button-addon2" onclick="mostrar()"><i id="icono" class="opacity-75 fa-solid fa-eye"></i></button>
        <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="fa fa-key"></i></span>
        <script type="text/javascript">
        function mostrar() {
          var tipo = document.getElementById("pass_usuario_v");
          var icono = document.getElementById("icono"); // obtén el elemento del icono
          if(tipo.type == 'password') {
            tipo.type = 'text';
            icono.className = 'fa-solid fa-eye-slash'; // actualiza la clase del icono
            icono.innerHTML = ''; // elimina el contenido HTML del icono
          } else {
            tipo.type = 'password';
            icono.className = 'fa-solid fa-eye'; // actualiza la clase del icono
            icono.innerHTML = ''; // elimina el contenido HTML del icono
          }
        }
        </script>

				    	</div>
					    	<div class="pt-2"><small><a href="nueva_cuenta.php" class="text-primary"/>Crear nueva cuenta</a></small>
					    	</div>
					    	<div class="pt-2"><small><a href="nuevo_password.php" class="text-primary"/>Olvidé mi contraseña</a></small>
					    	</div>
				    	</div>
				  </div> 




				  <div class="row pt-5 pb-5">
				  	<div class="col">
				  		<button type="submit" name="registro" class="btn btn-primary btn-lg shadow"><i class="fa-solid fa-right-to-bracket pe-2"></i>Ingresar</button>
				  	</div>
				  </div>

			</div>


				<script>
					// Example starter JavaScript for disabling form submissions if there are invalid fields
				(() => {
				  'use strict'

				  // Fetch all the forms we want to apply custom Bootstrap validation styles to
				  const forms = document.querySelectorAll('.needs-validation')

				  // Loop over them and prevent submission
				  Array.from(forms).forEach(form => {
				    form.addEventListener('submit', event => {
				      if (!form.checkValidity()) {
				        event.preventDefault()
				        event.stopPropagation()
				      }

				      form.classList.add('was-validated')
				    }, false)
				  })
				})()

				</script>
				</form>

	</div>
</div>
	<?php
		//Conexión
		require("footer.php");

	?>

