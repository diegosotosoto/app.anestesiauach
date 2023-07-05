<?php

//1 Validador login
	require("valida_pag.php");


	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

//Saca a los internos y otros becados del area de dolor
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`, `becad_otro`   FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1){
	  	header('Location: login.php');
	  }




//Variables	

		$formulario=htmlentities(addslashes($_POST['visita']));	


		$boton_toggler="<form action='vista_paciente.php' method='post'><button class='d-sm-block d-sm-none btn shadow-sm' type='submit' name='vista' value='$formulario'><div class='text-white'>Cancelar</div></button></form>";
		$titulo_navbar="<a class='d-sm-block d-sm-none'> Visita </a>";

		$boton_navbar="<button class='btn shadow-sm border-light' style='; --bs-border-opacity: .1;' type='submit' form='form_ed' value='Submit'><div class='text-white'>Guardar</div></button>";


	//Carga Head de la página
	require("head.php");

?>


<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->

	<?php
		$consulta_ed="SELECT `nombre_paciente`,`rut` FROM `pacientes` WHERE `rut` = '$formulario' ";
		$busqueda3=$conexion->query($consulta_ed);
		$fila=$busqueda3->fetch_assoc();
	?>

		<ul class="list-group">







	<!– TABLA DE REGISTROS –>

	<?php


		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><br><h5 class='mb-1 fw-bold'>".$fila['nombre_paciente']."</h5>";


		//BOTON A LA IZQUIERDA DEL TITULO class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<form action='vista_paciente.php' method='post'><button class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' type='submit' name='vista' value='$formulario'><div class='text-white'>Cancelar</div></button></form>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 pe-3 me-2 d-flex float-end'>
	<button class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;' type='submit' form='form_ed' value='Submit'><div class='text-white'>Guardar</div></button>
		</div>";


		//SUBTITULO
		echo "<p class='mb-1'>".$fila['rut']."</p></li>";
		echo "<div class='mb-1'></div></li>";



	?>


</ul>
<form name='form_ed' id='form_ed' method='post' action='vista_paciente.php' class='needs-validation' novalidate>
<input type="hidden" name="nombre_paciente_v" id="nombre_paciente_v" value="<?php echo $fila['nombre_paciente'];?>">
<input type="hidden" name="rut_v" id="rut_v" value="<?php echo $fila['rut'];?>">


		<!– TABLA DE REGISTROS –>
<ul class="list-group">
	<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='/images/IMG_3987.PNG'/>Exámen Físico</li>
	<li class='list-group-item'>


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

				<div class='text-muted pt-4 text-start'>Exámen Motor</div>
					<select class="form-select mb-2" id="motor" name="motor">
					  <option value=""></option>
					  <option value="M0 - Sin Movimiento">M0 - Sin Movimiento</option>					  						
					  <option value="M1 - Contracción s/movimiento">M1 - Contracción s/movimiento</option>
					  <option value="M2 - Mov. arco parcial">M2 - Mov. arco parcial</option>
					  <option value="M3 - Mov. completo">M3 - Mov. completo</option>
					  <option value="M5 - Mov. Normal">M5 - Mov. Normal</option>	  
				</select>

				<div class='text-muted pt-3 text-start'>Bolos PCA: Solicitados / Administrados</div><input class="form-control mb-4" type="text" name="bolos" id="bolos"></li>

				<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='/images/IMG_3992.PNG'/>Signos Vitales</li>
				<li class='list-group-item'>

				<div class='text-muted text-start'>PAS</div>
				<div class="input-group mb-2">
				  <input type="number"  max="300" class="form-control" name="pas" id="pas">
				  <span class="input-group-text" id="basic-addon2"> mmHg</span>
				</div>

				<div class='text-muted text-start'>PAD</div>
				<div class="input-group mb-2">
				  <input type="number"  max="200" class="form-control" name="pad" id="pad">
				  <span class="input-group-text" id="basic-addon2"> mmHg</span>
				</div>

				<div class='text-muted text-start'>FC</div>
				<div class="input-group mb-2">
				  <input type="number" max="250" class="form-control" name="fc" id="fc">
				  <span class="input-group-text" id="basic-addon2"> x min</span>
				</div>

				<div class='text-muted text-start'>SaO2</div>
				<div class="input-group mb-2">
				  <input  type="number" max="100" class="form-control" name="sao2" id="sao2">
				  <span class="input-group-text" id="basic-addon2"> %</span>
				</div>

				<div class='text-muted text-start'>FiO2</div>
				<div class="input-group mb-3">
				  <input  type="number" max="100" class="form-control" name="fio2" id="fio2">
				  <span class="input-group-text" id="basic-addon2"> %</span>
				</div>
				</li>

				<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='/images/IMG_3990.PNG'/>Exámenes</li>

				<li class='list-group-item'>

					<div class='text-muted pt-2 text-start'>Fecha Exámenes (dd/mm/aaaa)</div>
				 <div class="input-group date">
				  <input type="text" class="form-control" name="fecha_exs" id="datepicker">
				  </div>


				<div>
				<div class='text-muted pt-2 text-start'>INR</div><input class="form-control mb-2" type="text" pattern="^\d+(\.\d{1})?$"  name="inr" id="inr">
				</div>

				<div class='text-muted text-start'>TTPA</div>
				<div class="input-group mb-2">
				  <input type="text" pattern="^\d+(\.\d{1})?$" class="form-control" name="ttpa" id="ttpa">
				  <span class="input-group-text" id="basic-addon2"> seg</span>
				</div>

				<div class='text-muted text-start'>Plaquetas</div>
				<div class="input-group mb-2">
				  <input  type="number" max="2000" class="form-control" name="plaq" id="plaq">
				  <span class="input-group-text" id="basic-addon2"> x10^3</span>
				</div>

				<div class='text-muted text-start'>Creatinina</div>
				<div class="input-group mb-2">
				  <input type="text" pattern="^\d+(\.\d{1})?$" class="form-control" name="crea" id="crea">
				  <span class="input-group-text" id="basic-addon2"> mg/dL</span>
				</div>
				</li>


				<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='/images/IMG_3981.PNG'/>Indicaciones Diarias</li>
				<li class='list-group-item'>

				<div class='text-muted text-start'>Anticoagulación</div>
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


				<div class='text-muted text-start'>Indicación 1</div><input class="form-control mb-2" type="text" name="indic1" id="indic1" list="indicaciones">
				<div class='text-muted text-start'>Indicación 2</div><input class="form-control mb-2" type="text" name="indic2" id="indic2" list="indicaciones">
				<div class='text-muted text-start'>Indicación 3</div><input class="form-control mb-2" type="text" name="indic3" id="indic3" list="indicaciones">
				<div class='text-muted text-start'>Indicación 4</div><input class="form-control mb-2" type="text" name="indic4" id="indic4" list="indicaciones">
				<div class='text-muted text-start'>Indicación 5</div><input class="form-control mb-2" type="text" name="indic5" id="indic5" list="indicaciones">
				<div class='text-muted text-start'>Indicación 6</div><input class="form-control mb-2" type="text" name="indic6" id="indic6" list="indicaciones">
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

				<li class='list-group-item mb-2' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'>
			    <div class='text-muted'><img class='btn-imagen' src='/images/IMG_3977.PNG'/>Plan / Comentarios</div><textarea class="form-control mb-2" style="resize: none;" maxlength="250" rows="5" name="comentarios_v" id="comentarios_v"></textarea></li>
			    <br>
			    <br>

		</form>
</ul>

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



    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    	    var today, datepicker;
    			today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $(function() {
            $('#datepicker').datepicker({
            	 		uiLibrary: 'bootstrap5',
            	    format: 'dd/mm/yyyy',
            	    weekStartDay: 1,
            	    autoclose: true,
            	    maxDate: today,
            	    showRightIcon: true,

            }

            	);

        });


    </script>
<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
	?>





<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>



