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

			//chequea si viene post
					if($_POST['email_usuario_r']){
						$email_usuario=htmlentities(addslashes($_POST['email_usuario_r']));

						$chequea_email="SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario' AND `verified`= '1'";
						$result=$conexion->query($chequea_email);
						$conteo=mysqli_num_rows($result);

						if($conteo==0){

							$alerta_login = "
												<div class='alert alert-danger alert-dismissible fade show'>
										    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
										    <strong>Info!</strong> Error en el registro, contacte al administrador.
										  	</div>
							";
						}else{



							$alerta_login = "
												<div class='alert alert-success alert-dismissible fade show'>
										    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
										    <strong>Info!</strong> Se ha enviado un correo a la cuenta indicada.
										  	</div>

										  	<form method='POST' action='mail.php' name='mail_post'>
										  		<input type=hidden name='email_usuario_rec' value='".$email_usuario."'>
										  	</form>

												<script>
														window.onload = function(){
														  document.forms['mail_post'].submit();
														}
												</script>


				      ";
						}
					}

					?>


				<?php


				 if($alerta_login){

				 	echo $alerta_login;

				 }




				?>





				<form class="needs-validation" action="nuevo_password.php" method="post" novalidate autocomplete="nope">
				<div class="container text-center mt-4 pt-4">
				  <a href="#" class="btn shadow bg-primary me-2 rounded-3 text-white border-0 py-2" style="height: 150px;width: 320px; background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 0%, #44B2FF 100%);">
				  <div class="row pt-4">
				  	<h2>Olvidaste tu Contraseña?<i class="fa-solid fa-key pt-3 ps-3"></i></h2>
				  </div>
					 		  
							
				  
				</a>
								  <div class="row pt-4">
				    <div class="col">
				      Por favor, ingresa tu correo electrónico, y te enviaremos un mail con información!
				    </div>
				  </div>
				  <div class="row pt-4 justify-content-md-center">
				    <div class="col col-lg-6">
							<div class='text-muted pt-3'>E-Mail</div>
							<div class="input-group mb-2">
				    	<input type="email" name="email_usuario_r" class="form-control" required/>
				    	<span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="fa fa-envelope"></i></span>
				    </div>
				  </div>
				</div>



				  <div class="row pt-5 pb-5">
				  	<div class="col">
				  		<button type="submit" name="registro" class="btn btn-primary btn-lg shadow"><i class="fa-solid fa-right-to-bracket pe-2"></i>Enviar</button>
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

