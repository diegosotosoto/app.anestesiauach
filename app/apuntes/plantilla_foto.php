<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: ../login.php');
	}
	//Conexión
	require("../conectar.php");
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
		$boton_toggler="<a class='btn btn-lg border-light shadow-sm' style='--bs-border-opacity: .1;' href='../apuntes.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Apuntes";
		$boton_navbar="<button class='navbar-toggler text-white shadow-sm' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>";
		//Conexión
		require("../navbar.php");
	?>
<br><br>
    <div class="pt-2 collapse navbar-collapse" id="navbarSupportedContent" style="background-color: #42A5FF;">
    	<div class="pt-4 container ms-auto">

      <ul class="list-group pb-3">

        <li class="list-group-item list-group-item-secondary">
          <div class="text-center text-capitalize fw-normal fs-5">

      			<h6>
      							<!-   ****** TÍTULO INFORMATIVO ******  ->  
      							<?php  echo $titulo_info;  ?>
      			</h6>
      		<div>
        </li>
        <li class="list-group-item">
        	      		<!-   ****** DESCRIPCIÓN ******  ->  
          				<div class="pt-2">
        					<?php  echo $descripcion_info;  ?>
          				</div>
        </li>

  					<?php
  						//GENERA LAS REFERENCIAS SI EXISTE EL ARRAY
	  					if($referencias){
	    					echo "
	    					<li class='list-group-item'>
	    	        <!-   ****** TÍTULO FÓRMULA ******  ->  
	      				<div class='pt-2'>
	      				Referencias:
	      				</div>
	      				<div class='pt-2'><small>
	    	        	<!-   ****** REFERENCIAS ******  ->
	    	        	";            			
	      				foreach ($referencias as $valor) {
							    echo "$valor </br>";
								}
			        	echo "
			        	</small></div>
	    					</li>
	    					";
    					}
          	?>

					<!-   ****** FOOTER DE LA INFO ******  ->  
      </ul>
    </div>
    </div>
<ul class="pt-4 list-group">
<div class="container text-center">

  <div class="row">
    <div class="col text-center fs-5">

      <li class="list-group-item active shadow-sm bg-primary rounded-top text-white pt-2" style="background-image: var(--bs-gradient);">

      							<!-   ****** ICONO CON FORMATO PE-3 PT-2 ******  -> <!-   ****** TITULO ******  ->   		

						      			<?php

      				echo $icono_apunte;
      				echo $titulo_apunte;

      			?>

    </li>



    </div>
   </div>

   		<li class='list-group-item pb-4'>
   			<div class="ms-4 me-4">

   				<?php

   				echo "<image class='pt-3' src='".$imagen."' style='max-width: 100%'/>";




   				?>


			</div>

   		<li class='list-group-item mb-2'>
   			<div class="ms-4 me-4">

   				<?php

   				echo "<div class='text-muted fs-6 pt-4'>".$caption."</div>";

   				?>


			</div>

			</br>

			</li>









</div>

</ul>

<div class="pt-4 mb-2 text-center">
	  <p class="text-muted pb-2">Anestesia<small class='fw-bold'>  UACH &nbsp;<img src='../images/austral.png' style='height: 36px; width: 36px; filter: invert(60%);'/></small></p>
</div>

	<?php 
		//Cierre Conexión
		$conexion->close();
	?>


	<?php
		//Conexión
		require("footer.php");

	?>

</body>
</html>	