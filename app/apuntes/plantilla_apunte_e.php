<?php

	// Ve si está activa la cookie o redirige al login
	// if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
	//	header('Location: ../login.php');
	// }

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
   						echo "<div class='row pt-4'><div class='col text-start'>";
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
		   						echo "<div class='row pt-4'><div class='col text-start'>";
		   						echo $clave_input_e[0]; //título
		   						echo "</div><div class='col input-group'>";   	
						      echo "<select class='form-select mb-0' id='".$clave_input_e[1]."' required>"; //id

						      foreach($clave_input_e[2] as $selopt => $selvalue){

		  					      echo "<option value='".$selvalue."'>".$selopt."";

						      }


		   						echo "</select></div></div>	";
			   					}
			   	}
   			?>
					

   									<!-  INPUTS ESPECIAL (CHECK) ->   		
   			<?php
   			if($input_ch){
   				foreach($input_ch as $clave_input_ch){
   						echo "<div class='row pt-4'><div class='d-flex justify-content-between'><div class='text-start'>";
   						echo $clave_input_ch[0]; //título
   						echo "</div><div class='text-end'>    	
				      <input class='form-check-input' type='checkbox' id='$clave_input_ch[1]'>"; //id
							echo "</div></div></div>	";
	   					}
	   			}
   			?>







  <script>
    $(document).ready(function() {
      $('#btnCambiar').click(function() {
        var edadInput = $('#edad').val();
        var esAnios = $('#btnCambiar').hasClass('anios');
        var inputNuevo = '';

        if (esAnios) {
          inputNuevo = '<input type="number" id="edad" name="edad" class="form-control" placeholder="Edad"><span class="input-group-text" id="basic-addon2">meses</span>';
          $('#btnCambiar').removeClass('anios').html('<i class="fa-solid fa-rotate"></i>');   
        } else {
          inputNuevo = '<input type="number" id="edad" name="edad"  class="form-control" placeholder="Edad"><span class="input-group-text" id="basic-addon2">años</span>';
          $('#btnCambiar').addClass('anios').html('<i class="fa-solid fa-rotate"></i>');
        }

        $('#edadInput').html(inputNuevo);
        $('#edad').val(edadInput);
        $('#edad').focus();
      });

      $('#btnCalcular').click(function() {
        var edadInput = $('#edad').val();
        var resultadoX = '';
        var resultadoX2 = '';
        var resultadoF = '';
        var resultadoF2 = '';

        if (edadInput > 0) {

		        if ($('#btnCambiar').hasClass('anios')) {

		          resultadoX = edadInput / 4 + 3.5 ;
		          resultadoX2 = edadInput / 2 + 12 ;

		        } else {

				        	if (edadInput >= 18 ){
				        		resultadoX = edadInput / 12 / 4 + 3.5;
				        		resultadoX2 = edadInput / 12 / 2 + 12;
				        	} else if (edadInput < 18 && edadInput >= 9 ){
				        		resultadoX = 3.5;
				        		resultadoX2 = 10.5;
				        	} else if (edadInput < 9 && edadInput >= 3 ){
				          	resultadoX = 3.0;
				          	resultadoX2 = 9.0;
				        	} else if (edadInput < 3 ){
				        		resultadoX = 2.5;
				        		resultadoX2 = 7.5;
				        	} 
		        }

		        if (resultadoX > 7) {
		        	resultadoF = 7;
		        	resultadoF2 = 21;
		        } else if (resultadoX < 2.5) {
		        	resultadoF = 2.5;
		        	resultadoF2 = 7.5;
		        } else {
		        	resultadoF = resultadoX;
		        	resultadoF2 = resultadoX2;
		        }

			}
        $('#resultadoX').attr('value',Math.round(resultadoF * 2) / 2);
        $('#resultadoX2').attr('value',Math.round(resultadoF2 * 2) / 2);


      });
    });
  </script>



	<div class="row pt-4">
		<div class='col-6 text-start'>   						
						Edad
		</div>
		<div class="col-5 pe-0 mx-0">
        <div class="input-group mb-2" id="edadInput">

    <input type="number" id="edad" name="edad"  class="form-control" placeholder="Edad"><span class="input-group-text" id="basic-addon2">años</span>

  			</div>
  	</div>
  	<div class="col-1 py-2 px-0 mx-0">
        <span class="input-group-text text-white px-0 mx-0 py-0 my-0" id="basic-addon2as"><button class="px-0 mx-0 py-0 my-0 btn btn-outline-secondary opacity-75 anios" id="btnCambiar" type="button" id="button-addon2" style="width: 100%; height: 100%;" ><i class="fa-solid fa-rotate"></i></button></span>
    </div>
  </div>





				<!-  BOTON DE CÁLCULO  ->
				   <div class="row pt-5 ms-1">
				    <div class="col">

				      <button class="btn btn-primary btn-lg shadow-sm me-4" onclick="doMath();" id="btnCalcular"><i class="fa-solid fa-calculator pe-3"></i>Calcular</button>
				      
				    </div>
				  </div>




				<div class='row pt-5'>
					<div class='col text-start'>   						
						Tubo
					</div>
					<div class='col input-group'>    	
							<input class='form-control' id="resultadoX" readonly>
							<span class='input-group-text' id='basic-addon2'>c/cuff
							</span>
					</div>
				</div>


				<div class='row pt-4'>
					<div class='col text-start'>   						
						Dist. Boca
					</div>
					<div class='col input-group'>    	
							<input class='form-control' id="resultadoX2" readonly>
							<span class='input-group-text' id='basic-addon2'>cm
							</span>
					</div>
				</div>




						<!-  RESULTADO  ->   		
   			<?php
   				foreach($resultado as $clave_result){
   						echo "<div class='row pt-4'><div class='col text-start'>";
   						echo $clave_result[0]; //título
   						echo "</div><div class='col input-group'>    	
				      <input class='form-control' type='number' id='$clave_result[1]' readonly>"; //id
   						echo "<span class='input-group-text' id='basic-addon2'>";	
   						echo $clave_result[2]; //unidad
   						echo "</span></div></div>	";
   							if($clave_result[5]){ 
   								echo "<div class='text-start pb-1 pt-1 opacity-50'>".$clave_result[5]."</div>";
   							}

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


