<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
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
</br></br></br>
<!-  NAVBAR  ->	

	<?php
		//Botones del Toggle NAVBAR
		$boton_toggler="<a class='btn btn-lg shadow-sm' href='../apuntes.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Apuntes";
		$boton_navbar="<button class='navbar-toggler text-white' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>";
		//Conexión
		require("../navbar.php");
	?>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    	<div class="container ms-auto">

      <ul class="list-group">

        <li class="list-group-item list-group-item-secondary">
          <div class="text-center text-capitalize fw-normal">
      			<h6>
      							<!-   ****** TÍTULO INFORMATIVO ******  ->  
      							Utilidad Clínica 	
      			</h6>
      		<div>
        </li>

        <li class="list-group-item">
        	      		<!-   ****** DESCRIPCIÓN ******  ->  
          				<div class="pt-2">
        					Este indicador permite conocer el détficit de Bicarbonato en el análisis de Gases Arteriales a partir del Base Excess. 
        					Entrega el resultado para reponer el 100% del déficit calculado, en ml de solución de Bicarbonato de Sodio al 8.4% y al 2/3 molar.
          				</div>
        </li>

        <li class="list-group-item">

        	        	<!-   ****** TÍTULO REFERENCIAS ******  ->  
          				<div class="pt-2">
          					Referencias
          				</div>
          			<div class="pt-2"><small>
        	        	<!-   ****** REFERENCIAS ******  ->            			
          			1.- ASdasd. Lorem, ipsum dolor sit amet consectetur, adipisicing elit. Explicabo, illum! Velit, qui, placeat autem consectetur.
          			</br>
          			2.- asperiores vitae tempore laudantium at. Commodi suscipit officiis unde vero tenetur praesentium incidunt, nihil consectetur.
				        </small></div>
	      </li>

					<!-   ****** FOOTER DE LA INFO ******  ->  
        <li class="list-group-item"></li>


      </ul>
    </div>
    </div>


<ul class="list-group">
<div class="container text-center">

  <div class="row pt-1">
    <div class="col text-center">
      <li class="list-group-item active"><div class="text-capitalize fw-normal">
      	<h5>
      							<!-   ****** ICONO ******  ->   		
      		<i class="fa-solid fa-flask-vial pe-3 pt-2"></i>

      							<!-   ****** TITULO ******  ->   
      	Corrección de bicarbonato

      </h5></div></li>
    </div>
   </div>

   		<li class='list-group-item mb-2'>

					<!-  INPUT 1  ->   			
					<div class="row pt-5">
				    <div class="col text-start">
      							<!-   ****** TITULO INPUT 1 ******  ->   				    	
				      Peso:
				    </div>
				     <div class="col input-group">
      							<!-   ****** ID INPUT 1 ******  ->   				     	
				      <input class="form-control" type="number" id="peso">
      							<!-   ****** UNIDAD INPUT 1 ******  ->   				 				      
				       <span class="input-group-text" id="basic-addon2"> Kg</span>
							</div>
				  </div>	

				  <!-  INPUT 2  ->   		
				   <div class="row pt-5">
				    <div class="col text-start">
      							<!-   ****** TITULO INPUT 2 ******  ->   						    	
				      Exceso de Base:
				    </div>
				     <div class="col input-group">
      							<!-   ****** ID INPUT 2 ******  ->   						     	
				      <input type="number" class="form-control" id="be">
      							<!-   ****** UNIDAD INPUT 2 ******  ->   				 				      
					    <span class="input-group-text" id="basic-addon2"> mEq/L</span>
				    </div>
				  </div>

				<!-  BOTON DE CÁLCULO  ->
				   <div class="row pt-5 ms-1">
				    <div class="col">
				      <button class="btn btn-primary me-4" onclick="doMath();">Calcular</button>
				    </div>
				  </div>

				<!-  RESULTADO 1  ->
					<div class='row pt-5 ms-1'>
						<div class='col text-start'>
							Déficit:
						</div>
						<div class="col input-group">
						<input class="form-control" type='number' id='resultado1' style="color: #000000; pointer-events: none;">
	 					<span class="input-group-text" id="basic-addon2"> gr</span>
						</div>
					</div>

				<!-  RESULTADO 2  ->
					<div class='row pt-5 ms-1'>
						<div class='col text-start'>
      							<!-   ****** TITULO RESULTADO 1 ******  ->   			
							Reponer al 8.4%:
						</div>
						<div class="col input-group">
      							<!-   ****** ID RESULTADO 1 ******  ->   													
						<input class="form-control" type='number' id='resultado2' style="color: #000000; pointer-events: none;">
      							<!-   ****** UNIDAD RESULTADO 1 ******  ->   								
	 					<span class="input-group-text" id="basic-addon2"> ml</span>
						</div>
					</div>


			   <script>
			      function doMath() {
			          var input1 = document.getElementById('peso').value;
			          var input2 = document.getElementById('be').value;
			          var resultado1 = parseFloat(input1) * parseFloat(input2) * 0.3 / 12 * -1;
			          var resultado2 = parseFloat(resultado1) / 0.084;
			          $('#resultado1').attr('value', resultado1.toFixed(2));
			          $('#resultado2').attr('value', resultado2.toFixed(2));
								}
			  </script>


			</br></br>

			</li>









</div>

</ul>



	<?php 
		//Cierre Conexión
		$conexion->close();
	?>


	<?php
		//Conexión
		require("../footer.php");

	?>

</body>
</html>	