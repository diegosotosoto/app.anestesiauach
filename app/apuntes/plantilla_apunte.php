<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: ../login.php');
	}

	//Conexión
	require("../conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	//Variables
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Apuntes</span>";
		$boton_navbar="<button class='navbar-toggler text-white shadow-sm' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>";

	//Carga Head de la página
	require("head.php");
 

	?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

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
      </ul>
    </div>
    </div>
<ul class="pt-4 list-group">
<div class="container text-center">

  <div class="row">

      <li class="list-group-item active shadow-sm bg-primary rounded-top text-white pt-2" style="background-image: var(--bs-gradient);">
      	
		<span class='float-end'>
				<div class='pt-0 pb-1 ps-3 me-3 d-flex justify-content-end'>
					<button class='btn btn-primary shadow-sm border-light d-none d-sm-block' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>
				</div>
		</span>

      							<!-   ****** ICONO CON FORMATO PE-3 PT-2 ******  -> <!-   ****** TITULO ******  ->   		

						      			<?php

      				echo $icono_apunte;
      				echo $titulo_apunte;

      			?>



    </li>

    </div>
   </div>

   		<li class='list-group-item mb-2'>
   			<div class="ms-4 me-4">

						<!-  INPUTS  ->   		
   			<?php
   			if($input){
   				foreach($input as $clave_input){
   						echo "<div class='row pt-5'><div class='col text-start'>";
   						echo $clave_input[0]; //título
   						echo "</div><div class='col input-group'>    	
				      <input class='form-control' type='number' id='$clave_input[1]'>"; //id
   						echo "<span class='input-group-text' id='basic-addon2'>";	
   						echo $clave_input[2]; //unidad
   						echo "</span></div></div>	";
	   					}
	   			}
   			?>


   									<!-  INPUTS ESPECIAL (Select) ->   		
   			<?php
   				if($input_e){
		   				foreach($input_e as $clave_input_e){
		   						echo "<div class='row pt-5'><div class='col text-start'>";
		   						echo $clave_input_e[0]; //título
		   						echo "</div><div class='col input-group'>";   	
						      echo "<select class='form-select mb-0' id='".$clave_input_e[1]."' name='analgesia' required>"; //id

						      foreach($clave_input_e[2] as $selopt => $selvalue){

		  					      echo "<option value='".$selvalue."'>".$selopt."</option>";

						      }


		   						echo "</select></div></div>	";
			   					}
			   	}
   			?>
					

   									<!-  INPUTS ESPECIAL (CHECK) ->   		
   			<?php
   			if($input_ch){
   				foreach($input_ch as $clave_input_ch){
   						echo "<div class='row pt-5'><div class='d-flex justify-content-between'><div class='text-start'>";
   						echo $clave_input_ch[0]; //título
   						echo "</div><div class='text-end'>    	
				      <input class='form-check-input' type='checkbox' id='$clave_input_ch[1]'>"; //id
							echo "</div></div></div>	";
	   					}
	   			}
   			?>

				<!-  BOTON DE CÁLCULO  ->
				   <div class="row pt-5 ms-1">
				    <div class="col">
				      <button class="btn btn-primary btn-lg shadow-sm me-4" onclick="doMath();"><i class="fa-solid fa-calculator pe-3"></i>Calcular</button>
				    </div>
				  </div>

						<!-  RESULTADO  ->   		
   			<?php
   				foreach($resultado as $clave_result){
   						echo "<div class='row pt-5'><div class='col text-start'>";
   						echo $clave_result[0]; //título
   						echo "</div><div class='col input-group'>    	
				      <input class='form-control' type='number' id='$clave_result[1]' readonly>"; //id
   						echo "<span class='input-group-text' id='basic-addon2'>";	
   						echo $clave_result[2]; //unidad
   						echo "</span></div></div>	";
	   					}

   			?>



   					<!- INTERPRETACION RESULTADO (otro_elemento) ->
					<div id='otro_elemento' class='pt-5'></div> 


			   <script>
			      function doMath() {

			      	<?php  
			      		foreach($input as $var_input){  //construye las variables Javascript de los inputs
			      			echo "var $var_input[1]Var = document.getElementById('$var_input[1]').value; "; //pesoVar beVar
			      		}

			      		foreach($input_e as $var_input_e){  //construye las variables Javascript de los inputs tipo select
			      			echo "var $var_input_e[1]Var = document.getElementById('$var_input_e[1]').value; "; //pesoVar beVar
			      		}

			      		foreach($input_ch as $var_input_ch){  //construye las variables Javascript de los inputs tipo check
			      			echo "var $var_input_ch[1]Var = document.getElementById('$var_input_ch[1]').checked; "; //pesoVar beVar
			      		}

			      		foreach($resultado as $var_calc){
			      			echo "var $var_calc[1]Var = $var_calc[3]; "; //construye las variables de reslutado y el calculo correspondiente
			      		}

			      		foreach($resultado as $var_result){  //construye los resultados
		      			echo "$('#$var_result[1]').attr('value', $var_result[1]Var.toFixed($var_result[4])); ";
		      			}

				   				//Otros elementos
				   			if($otro_elemento){

				   					echo $otro_elemento;

				   			}


   			?>

			      }



			  </script>




			</div>


			</br></br>

			</li>









</div>

</ul>


</div>

	<?php 
		//Cierre Conexión
		$conexion->close();
	?>


	<?php
		//Conexión
		require("footer.php");

	?>

