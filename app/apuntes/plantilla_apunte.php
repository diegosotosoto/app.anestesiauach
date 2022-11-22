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
  						//GENERA LA FÓRMULA SI EXISTE     
  						if($formula){   
	        			echo "<li class='list-group-item'>
	        	        	<!-   ****** TÍTULO FORMULA ******  ->  
	          					<div class='pt-2'>
	          					Fórmula:
	          					</div>
	          					<div class='pt-2'>
	        	      	  <!-   ****** FORMULA ******  ->            			
	          					$formula
					       		 	</div>
		     						 	</li>
	     						 	";
	     				}

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
      							<!-   ****** ICONO CON FORMATO PE-3 PT-2 ******  -> <!-   ****** TITULO ******  ->   		
      			<?php

      				echo $icono_apunte;
      				echo $titulo_apunte;

      			?>

      </h5></div></li>
    </div>
   </div>

   		<li class='list-group-item mb-2'>


						<!-  INPUTS  ->   		
   			<?php
   				foreach($input as $clave_input){
   						echo "<div class='row pt-5'><div class='col text-start'>";
   						echo $clave_input[0]; //título
   						echo "</div><div class='col input-group'>    	
				      <input class='form-control' type='number' id='$clave_input[1]'>"; //id
   						echo "<span class='input-group-text' id='basic-addon2'>";	
   						echo $clave_input[2]; //unidad
   						echo "</span></div></div>	";
	   					}

   			?>
	

				<!-  BOTON DE CÁLCULO  ->
				   <div class="row pt-5 ms-1">
				    <div class="col">
				      <button class="btn btn-primary me-4" onclick="doMath();">Calcular</button>
				    </div>
				  </div>

						<!-  RESULTADO  ->   		
   			<?php
   				foreach($resultado as $clave_result){
   						echo "<div class='row pt-5'><div class='col text-start'>";
   						echo $clave_result[0]; //título
   						echo "</div><div class='col input-group'>    	
				      <input class='form-control' type='number' id='$clave_result[1]'>"; //id
   						echo "<span class='input-group-text' id='basic-addon2'>";	
   						echo $clave_result[2]; //unidad
   						echo "</span></div></div>	";
	   					}

   			?>


			   <script>
			      function doMath() {

			      	<?php  
			      		foreach($input as $var_input){  //construye las variables Javascript de los inputs
			      			echo "var $var_input[1]Var = document.getElementById('$var_input[1]').value; "; //pesoVar beVar
			      		}

			      		foreach($resultado as $var_calc){
			      			echo "var $var_calc[1]Var = $var_calc[3]; "; //construye las variables de reslutado y el calculo correspondiente
			      		}

			      		foreach($resultado as $var_result){  //construye los resultados
		      			echo "$('#$var_result[1]').attr('value', $var_result[1]Var.toFixed($var_result[4])); ";
		      			}
			      	?>

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
		require("footer.php");

	?>

</body>
</html>	