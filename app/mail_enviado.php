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


				<div class="container text-center mt-4 pt-4">
				  <a href="#" class="btn shadow bg-primary me-2 rounded-3 text-white border-0 py-2" style="height: 150px;width: 320px; background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 0%, #44B2FF 100%);">
				  <div class="row pt-4">
				  	<h2>Correo Enviado</h2>
				  </div>
					  <div class="row py-2">			  
							<h1><i class="fa-regular fa-envelope ps-3"></i></h1>
				  </div>
				</a>
								  <div class="row py-4">
				    <div class="col py-4">
				      Por favor, revisa tu correo electrónico, hemos enviado un mail con información para restablecer la contraseña!
				    </div>
				  </div>





	</div>
</div>
</div>
	<?php
		//Conexión
		require("footer.php");

	?>

