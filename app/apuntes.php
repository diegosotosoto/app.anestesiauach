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
</br></br></br>
<!-  NAVBAR  ->	

	<?php
		//Botones del Toggle NAVBAR


		$boton_toggler="<a class='btn btn-lg shadow-sm border-light' style='; --bs-border-opacity: .1;'  href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Apuntes";
		$boton_navbar="<a></a><a></a>";
		//Conexión
		require("navbar.php");
	?>





<div class="accordion" id="accordionPanelsStayOpenExample">
<!- INICIO DEL ITEM ->

  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
        Renal
      </button>
    </h2>

    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
      <div class="accordion-body">

			<div class="list-group">
			  <a href="apuntes/bica.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;"  class="fa-solid fa-flask-vial"></i>Corrección de bicarbonato</a> 
			</div>

      </div>
    </div>
  </div>
<!- FIN DEL ITEM ->

  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        Volumen y Reposición
      </button>
    </h2>

    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
      <div class="accordion-body">


			<div class="list-group">
			  <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-droplet"></i>Pérdida Admisible </a> 
			</div>

    </div>
  </div>
 </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
        Cardiovascular
      </button>
    </h2>

    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
      <div class="accordion-body">

			<div class="list-group">
			  <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-heart-pulse"></i>Pérdida Admisible </a> 
			</div>

    </div>
  </div>
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