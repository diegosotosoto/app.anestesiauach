<?php

	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
?>
<?php
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
?>
<!-  HEAD  ->	
	<?php
		//Conexión
		require("head.php");

	?>
</head>
<body>
<!-  NAVBAR  ->	
<form class="needs-validation" method='post' action='vista_paciente.php' novalidate>
	<?php
		$formulario=$_POST['editar'];
		//ENVIA EL POST VISTA CON LA VARIABLE FLORMULARIO PARA CANCELAR
		$boton_toggler="<button class='btn btn-lg shadow-sm' type='submit' name='vista' value='$formulario'><div class='text-white'>Cancelar</div></button>";

		$titulo_navbar="";

		$boton_navbar="<button class='btn btn-lg shadow-sm' type='submit' name='editar' value='Submit'><div class='text-white'>Guardar</div></button>";
		require("navbar.php");
	?>
<br><br>
	<?php


		$consulta_ed="SELECT * FROM `pacientes` WHERE `rut` = '$formulario' AND `de_alta`='0' ";

		$busqueda3=$conexion->query($consulta_ed);

		$fila=$busqueda3->fetch_array();


	?>
		<input type="hidden" name="rut_e" id="rut_e" value="<?php echo $fila[2];?>">

		<!– TABLA DE REGISTROS –>

			<ul class="list-group">
	<?php
		echo "<li class='list-group-item'><br><h5 class='mb-1 fw-bold'>$fila[1]</h5>";
		echo "<div class='mb-1'>$fila[2]</div></li>";
	?>
			</ul>
			<br>


		<!– TABLA DE REGISTROS –>
				<div class="container">
				<div class="row">
				<div class="col">
					<div class='text-muted  mt-3'>Ficha Clínica</div><input class="form-control mb-2" type="text" name="ficha_e" id="ficha_e" value="<?php echo html_entity_decode($fila[3]);?>" pattern="[0-9]{1,7}" required/> 
					<div class="invalid-feedback pt-1">
			      	Ingrese un número de ficha válido
			    	</div>
					</div>

					<div>
					<div class='text-muted pt-3'>Unidad / Cama</div><input class="form-control mb-2" type="text" name="unidad_cama_e" id="unidad_cama_e" required pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]{2,}' value="<?php echo html_entity_decode($fila[4]);?>"/>
					<div class="invalid-feedback pt-1">
			      	Ingrese un número de ficha válido
			    	</div>
					</div>
			   		
			   		<div>
					<div class='text-muted pt-3'>Procedimiento</div><input class="form-control mb-2" type="text" name="procedimiento_e" id="procedimiento_e" value="<?php echo html_entity_decode($fila[5]);?>" required pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' />
					<div class="invalid-feedback pt-1">
			      	Ingrese un valor válido
			    	</div>
					</div>

				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Analgesia</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="seeAnotherFieldGroup" name="analgesia_e" required>
					  <option value=""></option>						
					  <option value="PCA EV" <?php if("PCA EV"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>PCA EV</option>
					  <option value="Peridural" <?php if("Peridural"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Peridural</option>
					  <option value="Plexo Braquial" <?php if("Plexo Braquial"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Plexo Braquial</option>
					  <option value="Ciático Poplíteo" <?php if("Ciático Poplíteo"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Ciático Poplíteo</option>
					  <option value="Femoral" <?php if("Femoral"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Femoral</option>
					  <option value="Canal Aductor" <?php if("Canal Aductor"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Canal Aductor</option>
					  <option value="ESP" <?php if("ESP"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>ESP</option>
					  <option value="Pared Abdominal" <?php if("Pared Abdominal"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Pared Abdominal</option>
					  <option value="Fascia Ilíaca" <?php if("Fascia Ilíaca"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Fascia Ilíaca</option>
					  <option value="Otro (Comentarios)" <?php if("Otro (Comentarios)"==html_entity_decode($fila[6])){echo "selected='selected'";}?>>Otro (Comentarios)</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>			


			<div class="form-group" id="otherFieldGroupDiv">
				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Nivel</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="nivel_e" name="nivel_e">
					  <option value=""></option>
					  <option value="T5 - T6" <?php if("T5 - T6"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T5 - T6</option>
					  <option value="T6 - T7" <?php if("T6 - T7"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T6 - T7</option>
					  <option value="T7 - T8" <?php if("T7 - T8"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T7 - T8</option>
					  <option value="T8 - T9" <?php if("T8 - T9"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T8 - T9</option>
					  <option value="T9 - T10" <?php if("T9 - T10"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T9 - T10</option>
					  <option value="T10 - T11" <?php if("T10 - T11"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T10 - T11</option>
					  <option value="T11 - T12" <?php if("T11 - T12"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T11 - T12</option>
					  <option value="T12 - L1" <?php if("T12 - L1"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>T12 - L1</option>
					  <option value="L1 - L2" <?php if("L1 - L2"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>L1 - L2</option>
					  <option value="L2 - L3" <?php if("L2 - L3"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>L2 - L3</option>
					  <option value="L3 - L4" <?php if("L3 - L4"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>L3 - L4</option>
					  <option value="L4 - L5" <?php if("L4 - L5"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>L4 - L5</option>
					  <option value="L5 - S1" <?php if("L5 - S1"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>L5 - S1</option>
					  <option value="Otro (Comentarios)" <?php if("Otro (Comentarios)"==html_entity_decode($fila[7])){echo "selected='selected'";}?>>Otro (Comentarios)</option>	
					</select>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Distancia Espacio Epidural</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<div class="input-group mb-2">
					  <input type="number" max="12" step=".1" class="form-control" name="espacio_e" id="espacio_e" value="<?php echo html_entity_decode($fila[8]);?>">
					  <span class="input-group-text" id="basic-addon2"> cm</span>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Distancia del Catéter</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<div class="input-group mb-2">
					  <input type="number" max="12" step=".1" class="form-control" name="distancia_e" id="distancia_e" value="<?php echo html_entity_decode($fila[9]);?>">
					<span class="input-group-text" id="basic-addon2"> cm</span>
					</div>
			 </div>

			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Solución</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="solucion_e" name="solucion_e" required>
					  <option value=""></option>
					  <option value="Bupi 0,1% + Fentanyl 1,6 ug" <?php if("Bupi 0,1% + Fentanyl 1,6 ug"==html_entity_decode($fila[10])){echo "selected='selected'";}?>>Bupi 0,1% + Fentanyl 1,6 ug</option>
					  <option value="Bupivacaína 0,1%" <?php if("Bupivacaína 0,1%"==html_entity_decode($fila[10])){echo "selected='selected'";}?>>Bupivacaína 0,1%</option>
					  <option value="Morfina 0,2 mg/ml" <?php if("Morfina 0,2 mg/ml"==html_entity_decode($fila[10])){echo "selected='selected'";}?>>Morfina 0,2 mg/ml</option>
					  <option value="Metadona 0,2 mg/ml" <?php if("Metadona 0,2 mg/ml"==html_entity_decode($fila[10])){echo "selected='selected'";}?>>Metadona 0,2 mg/ml</option>
					  <option value="Fentanyl 2 ug/ml" <?php if("Fentanyl 2 ug/ml"==html_entity_decode($fila[10])){echo "selected='selected'";}?>>Fentanyl 2 ug/ml</option>
					  <option value="Otro (Comentarios)" <?php if("Otro (Comentarios)"==html_entity_decode($fila[10])){echo "selected='selected'";}?>>Otro (Comentarios)</option>				  
					</select>
					<div class="invalid-feedback pt-0 float-end">
			      Ingrese un valor válido
			    </div>
				</div>	


					 <div>
					<div class='text-muted pt-4'>Infusión PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="infusion_e" id="infusion_e" value="<?php echo html_entity_decode($fila[11]);?>">
					  <span class="input-group-text" id="basic-addon2"> ml/hr</span>
					</div>
					</div>


					<div class='text-muted pt-3'>Bolo PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="bolo_e" id="bolo_e" value="<?php echo html_entity_decode($fila[12]);?>">
					  <span class="input-group-text" id="basic-addon2"> ml</span>
					</div>


					<div class='text-muted pt-3'>Lockout PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="lockout_e" id="lockout_e" value="<?php echo html_entity_decode($fila[13]);?>">
					  <span class="input-group-text" id="basic-addon2"> ml</span>
					</div>


					<div class='text-muted pt-3'>Peso</div>
					<div class="input-group mb-2">
					  <input type="number" max="1000" step=".1" class="form-control" name="peso_e" id="peso_e" value="<?php echo html_entity_decode($fila[14]);?>" required>
					  <span class="input-group-text" id="basic-addon2"> Kg</span>
					 <div class="invalid-feedback pt-0">
				      Ingrese un valor válido
				    </div>
					</div>

				<div class='col'>
			    <div class='text-muted pt-4'>Comentarios</div><textarea class="form-control mb-2" style="resize: none;" maxlength="250" rows="5" name="comentarios_e" id="comentarios_e"><?php echo html_entity_decode($fila[15]);?></textarea>
				</div>
</div>
</div>
</div>
			<br>

			<ul class="list-group">
			    <li class="list-group-item active" aria-current="true">Dar de alta este Paciente (No se puede deschacer)<img class='btn-imagen' style='margin-left:10px'src='/images/IMG_3982.PNG'/></li>
			    <li class="list-group-item">
					<div class="container">
					<div class="row py-4">
			      	<div class="col">
					</div>
			      	<div class="col">Dar de Alta
					</div>
			      	<div class="col">

						<div class="form-check form-switch">
						  <input class="form-check-input form-switch-md" style="transform: scale(1.3);" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="de_alta_e" value="1">
						  <label class="form-check-label" for="flexSwitchCheckDefault"></label>
						</div>
					</div>
					</div>
					</div>
				</li>

<br>
<br>
</ul>


		</form>


	<?php 

		$conexion->close();

	?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="hide-show-fields-form.js"></script>		
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

</body>
</html>
