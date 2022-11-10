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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/css/datepicker.min.css'>   
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>
<body>
	
<!-  NAVBAR  ->	

	<?php
		$formulario=htmlentities(addslashes($_POST['visita']));	

		$boton_toggler="<a class='btn btn-lg shadow-sm' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Visita";
		echo "<form name='form_ed' id='form_ed' method='post' action='vista_paciente.php' class='needs-validation' novalidate>";
		$boton_navbar="<button class='btn shadow-sm btn-lg' type='submit' value='Submit'><div class='text-white'>Guardar</div></button>";

		require("navbar.php");
	?>
<br><br>
	<?php
		$consulta_ed="SELECT `nombre_paciente`,`rut` FROM `pacientes` WHERE `rut` = '$formulario' ";
		$busqueda3=$conexion->query($consulta_ed);
		$fila=$busqueda3->fetch_array();
	?>

		<ul class="list-group">

	<!– TABLA DE REGISTROS –>

	<?php
		echo "<li class='list-group-item'><br><h5 class='mb-1 fw-bold'>$fila[0]</h5>";
		echo "<p class='mb-1'>$fila[1]</p></li>";
	?>
			</ul>

<input type="hidden" name="nombre_paciente_v" id="nombre_paciente_v" value="<?php echo $fila[0];?>">
<input type="hidden" name="rut_v" id="rut_v" value="<?php echo $fila[1];?>">


		<!– TABLA DE REGISTROS –>
<ul class="list-group">
	<li class='list-group-item mb-2'><img class='btn-imagen' src='/images/IMG_3987.PNG'/>Exámen Físico</li>
	<li class='list-group-item mb-2'>


				<div class='d-flex justify-content-between'><div class='text-muted'>EVA Estático</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="eva_estatico" name="eva_estatico" required>
					  <option value=""></option>
					  <option value="0">0</option>					  						
					  <option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					  <option value="4">4</option>
					  <option value="5">5</option>
					  <option value="6">6</option>
					  <option value="7">7</option>
					  <option value="8">8</option>
					  <option value="9">9</option>
					  <option value="10">10</option>				  
				</select>
			

				<div class='d-flex justify-content-between pt-4'><div class='text-muted'>EVA Dinámico</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="eva_dinamico" name="eva_dinamico" required>
					  <option value=""></option>
					  <option value="0">0</option>					  						
					  <option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					  <option value="4">4</option>
					  <option value="5">5</option>
					  <option value="6">6</option>
					  <option value="7">7</option>
					  <option value="8">8</option>
					  <option value="9">9</option>
					  <option value="10">10</option>				  
				</select>

				<div class='d-flex justify-content-between pt-4'><div class='text-muted'>Sedación (Ramsay)</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="sedacion" name="sedacion" required>
					  <option value=""></option>
					  <option value="1. Despierto agitado/ansioso">1. Despierto agitado/ansioso</option>					  						
					  <option value="2. Despierto tranquilo">2. Despierto tranquilo</option>
					  <option value="3. Dormido c/respuesta">3. Dormido c/respuesta</option>
					  <option value="4. Somnoliento poco responsivo">4. Somnoliento poco responsivo</option>
					  <option value="5. Dormido con Resp a Dolor">5. Dormido con Resp a Dolor</option>
					  <option value="6. Sin Respuesta a estímulos">6. Sin Respuesta a estímulos</option>		  
				</select>

				<div class='text-muted pt-4'>Exámen Motor</div>
					<select class="form-select mb-2" id="motor" name="motor">
					  <option value=""></option>
					  <option value="M0 - Sin Movimiento">M0 - Sin Movimiento</option>					  						
					  <option value="M1 - Contracción s/movimiento">M1 - Contracción s/movimiento</option>
					  <option value="M2 - Mov. arco parcial">M2 - Mov. arco parcial</option>
					  <option value="M3 - Mov. completo">M3 - Mov. completo</option>
					  <option value="M5 - Mov. Normal">M5 - Mov. Normal</option>	  
				</select>

				<div class='text-muted pt-3'>Bolos PCA: Solicitados / Administrados</div><input class="form-control mb-4" type="text" name="bolos" id="bolos"></li>

				<li class='list-group-item mb-2'><img class='btn-imagen' src='/images/IMG_3992.PNG'/>Signos Vitales</li>
				<li class='list-group-item mb-2'>

				<div class='text-muted'>PAS</div>
				<div class="input-group mb-2">
				  <input type="number"  max="300" class="form-control" name="pas" id="pas">
				  <span class="input-group-text" id="basic-addon2"> mmHg</span>
				</div>

				<div class='text-muted'>PAD</div>
				<div class="input-group mb-2">
				  <input type="number"  max="200" class="form-control" name="pad" id="pad">
				  <span class="input-group-text" id="basic-addon2"> mmHg</span>
				</div>

				<div class='text-muted'>FC</div>
				<div class="input-group mb-2">
				  <input type="number" max="250" class="form-control" name="fc" id="fc">
				  <span class="input-group-text" id="basic-addon2"> x min</span>
				</div>

				<div class='text-muted'>SaO2</div>
				<div class="input-group mb-2">
				  <input  type="number" max="100" class="form-control" name="sao2" id="sao2">
				  <span class="input-group-text" id="basic-addon2"> %</span>
				</div>

				<div class='text-muted'>FiO2</div>
				<div class="input-group mb-2">
				  <input  type="number" max="100" class="form-control" name="fio2" id="fio2">
				  <span class="input-group-text" id="basic-addon2"> %</span>
				</div>
				</li>

				<li class='list-group-item mb-2'><img class='btn-imagen' src='/images/IMG_3990.PNG'/>Exámenes</li>
				<li class='list-group-item mb-2'>
				 <div class="input-group date" id="datepicker">
				        <input type="text" class="form-control" name="fecha_exs" id="fecha_exs"/>
				        <span class="input-group-append">
				          <span class="input-group-text bg-light d-block">
				            <i class="fa fa-calendar"></i>
				          </span>
				        </span>
				      </div>

				<div>
				<div class='text-muted pt-2'>INR</div><input class="form-control mb-2" type="number" max="20" step=".1"  name="inr" id="inr">
				</div>

				<div class='text-muted'>TTPA</div>
				<div class="input-group mb-2">
				  <input  type="number" max="1000" step=".1"  class="form-control" name="ttpa" id="ttpa">
				  <span class="input-group-text" id="basic-addon2"> seg</span>
				</div>

				<div class='text-muted'>Plaquetas</div>
				<div class="input-group mb-2">
				  <input  type="number" max="2000" class="form-control" name="plaq" id="plaq">
				  <span class="input-group-text" id="basic-addon2"> x10^3</span>
				</div>

				<div class='text-muted'>Creatinina</div>
				<div class="input-group mb-2">
				  <input type="number" max="20" step=".1" class="form-control" name="crea" id="crea">
				  <span class="input-group-text" id="basic-addon2"> mg/dL</span>
				</div>
				</li>


				<li class='list-group-item mb-2'><img class='btn-imagen' src='/images/IMG_3981.PNG'/>Indicaciones Diarias</li>
				<li class='list-group-item mb-2'>

				<div class='text-muted'>Anticoagulación</div>
					<select class="form-select mb-2" id="anticoagulante" name="anticoagulante">
					  <option value=""></option>
					  <option value="Ninguna">Ninguna</option>					  						
					  <option value="Heparina SC profilaxis">Heparina SC profilaxis</option>
					  <option value="TACO">TACO</option>
					  <option value="NOAC">NOAC</option>
					  <option value="AAS">AAS</option>
					  <option value="Doble Antiagregación">Doble Antiagregación</option>
					  <option value="Otra (Comentarios)">Otra (Comentarios)</option>  
				</select>


				<div class='text-muted'>Indicación 1</div><input class="form-control mb-2" type="text" name="indic1" id="indic1" list="indicaciones">
				<div class='text-muted'>Indicación 2</div><input class="form-control mb-2" type="text" name="indic2" id="indic2" list="indicaciones">
				<div class='text-muted'>Indicación 3</div><input class="form-control mb-2" type="text" name="indic3" id="indic3" list="indicaciones">
				<div class='text-muted'>Indicación 4</div><input class="form-control mb-2" type="text" name="indic4" id="indic4" list="indicaciones">
				<div class='text-muted'>Indicación 5</div><input class="form-control mb-2" type="text" name="indic5" id="indic5" list="indicaciones">
				<div class='text-muted'>Indicación 6</div><input class="form-control mb-2" type="text" name="indic6" id="indic6" list="indicaciones">
				<datalist id="indicaciones">
					<option value="Paracetamol 1gr c/8 hrs vo"></option>
					<option value="Paracetamol 1gr c/6 hrs vo"></option>
					<option value="Ketorolaco 30mg c/8 hrs ev"></option>
					<option value="Nefersil 100mg c/8 hrs ev"></option>
					<option value="Metamizol 1gr c/8 hrs ev"></option>
					<option value="Metamizol 1gr c/6 hrs ev"></option>
					<option value="Tramadol 100mg c/12 hrs ev"></option>
					<option value="Tramadol 100mg c/8 hrs ev"></option>
				</datalist>
				</li>

				<li class='list-group-item mb-2'>
			    <div class='text-muted'><img class='btn-imagen' src='/images/IMG_3977.PNG'/>Comentarios</div><textarea class="form-control mb-2" style="resize: none;" maxlength="250" rows="5" name="comentarios_v" id="comentarios_v"></textarea></li>
			    <br>
			    <br>

		</form>
</ul>
<br>
<br>

<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
	?>
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
<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="bootstrap-datepicker.es.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker({
            	    format: 'dd/mm/yyyy',
            	    language: 'es',
            	    weekStart: 1,
            }

            	);

        });
    </script>

</body>
</html>
