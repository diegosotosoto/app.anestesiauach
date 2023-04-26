<?php

//Validador login
    require("valida_pag.php");

//Variables sin conexion
$formulario=$_POST['editar'];

$boton_toggler="<form action='vista_paciente.php' method='post'><button class='d-sm-block d-sm-none btn shadow-sm' type='submit' name='vista' value='$formulario'><div class='text-white'>Cancelar</div></button></form>";

$titulo_navbar="";

$boton_navbar="<button class='btn shadow-sm' type='submit' name='editar' value='Submit' onclick='envioForm_ed_pacte()'><div class='text-white'>Guardar</div></button>";

//Carga Head de la página
require("head.php");

?>


<div class="col col-sm-8 col-xl-9"><!- Columna principal (derecha) responsive->


	<?php


	?>

	<?php


		$consulta_ed="SELECT * FROM `pacientes` WHERE `rut` = '$formulario'";

		$busqueda3=$conexion->query($consulta_ed);

		$fila=$busqueda3->fetch_assoc();


	?>



		<!– TABLA DE REGISTROS –>

			<ul class="list-group">
	<?php
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold'>".$fila['nombre_paciente']."</h5>


		<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<form action='vista_paciente.php' method='post'><button class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' type='submit' name='vista' value='$formulario'><div class='text-white'>Cancelar</div></button></form>
		</div>

		<span class='float-end'>
		<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
		<button class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' type='submit' name='editar' value='Submit' onclick='envioForm_ed_pacte()'><div class='text-white'>Guardar</div></button>
		</div>
		</span>";


		echo "<div class='mb-1'>Rut: ".$fila['rut']."</div>";
		echo "<div class='mb-1'>FC: ".$fila['ficha']."</div></li>";
	?>

	<form class='needs-validation' name='form_ed_pacte' id='form_ed_pacte' method='post' action='vista_paciente.php' novalidate>
		<input type="hidden" name="rut_e" id="rut_e" value="<?php echo $fila['rut'];?>">

			</ul>
			<br>


		<!– TABLA DE REGISTROS –>
				<div class="container">
				<div class="row">
				<div class="col">


				<div>
				<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Unidad / Cama</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-2" type="text" name="unidad_cama_e" id="unidad_cama_e" list="unidades" value="<?php echo html_entity_decode($fila['unidad_cama']);?>" autocomplete="off" required>
					<datalist id="unidades">
						<option value="100 - MEDICINA"></option>
						<option value="UHD - UNIDAD  HOSPIT. DOMICILIARIA"></option>
						<option value="CCV - CLINICA COSTANERA VALDIVIA"></option>
						<option value="102 - UNIDAD HEMATOLOGIA INTENSIVA"></option>
						<option value="119 - MEDICO QUIRURGICO INDIFERENCIADO"></option>
						<option value="145 - PEDIATRICO QUIRURG. INDIFEREN"></option>
						<option value="200 - CIRUGIA ADULTO"></option>
						<option value="210 - CIRUGIA MAYOR AMBULATORIA"></option>
						<option value="300 - TRAUMATOLOGIA ADULTO"></option>
						<option value="400 - CIRUGIA INFANTIL"></option>
						<option value="403 - TRAUMATOLOGIA INFANTIL"></option>
						<option value="501 - NEONATO CUIDADOS INTENSIVOS"></option>
						<option value="502 - NEONATO CUIDADOS INTERMEDIOS"></option>
						<option value="503 - NEONATO CUIDADOS BASICOS"></option>
						<option value="506 - PEDIATRIA"></option>
						<option value="507 - SEGUNDA INFANCIA"></option>
						<option value="509 - UNIDAD ONCO HEMATOLOGIA INFANT"></option>
						<option value="510 - UTI PEDIATRICA"></option>
						<option value="600 - PUERPERIO"></option>
						<option value="601 - ARO - OBSTETRICIA"></option>
						<option value="602 - GINECOLOGIA"></option>
						<option value="603 - PARTO - OBSTETRICIA"></option>
						<option value="701 - UCI ADULTO"></option>
						<option value="707 - UCI-2"></option>
						<option value="702 - UCI PEDIATRICA"></option>
						<option value="703 - UCI INTERMEDIA"></option>
						<option value="705 - UTI-1"></option>
						<option value="706 - UTI-3"></option>
						<option value="804 - NEUROCIRUGIA"></option>
						<option value="807 - PSIQUIATRIA"></option>
						<option value="811 - OFTALMOLOGIA"></option>
						<option value="812 - ONCOLOGIA"></option>
						<option value="813 - OTORRINOLARINGOLOGIA"></option>
						<option value="814 - UROLOGIA"></option>
						<option value="901 - SOU (SALA OBSERVACION ADULTO)"></option>
						<option value="910 - PENSIONADO"></option>
						<option value="931 - PABELLON CENTRAL"></option>
						<option value="932 - PABELLON PARTOS"></option>
						<option value="941 - RECUPERACION PABELLON CENTRAL"></option>
				</datalist>
					<div class="invalid-feedback pt-1">
			      	Ingrese un valor válido
			    	</div>
					</div>
			   		
			   		<div>
					<div class='text-muted pt-3'>Procedimiento</div><input class="form-control mb-2" type="text" name="procedimiento_e" id="procedimiento_e" value="<?php echo html_entity_decode($fila['procedimiento']);?>" required pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' />
					<div class="invalid-feedback pt-1">
			      	Ingrese un valor válido
			    	</div>
					</div>

				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Analgesia</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="seeAnotherFieldGroup" name="analgesia_e" required>
					  <option value=""></option>						
					  <option value="PCA EV" <?php if("PCA EV"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>PCA EV</option>
					  <option value="Peridural" <?php if("Peridural"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Peridural</option>
					  <option value="Plexo Braquial" <?php if("Plexo Braquial"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Plexo Braquial</option>
					  <option value="Ciático Poplíteo" <?php if("Ciático Poplíteo"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Ciático Poplíteo</option>
					  <option value="Femoral" <?php if("Femoral"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Femoral</option>
					  <option value="Canal Aductor" <?php if("Canal Aductor"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Canal Aductor</option>
					  <option value="ESP" <?php if("ESP"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>ESP</option>
					  <option value="Pared Abdominal" <?php if("Pared Abdominal"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Pared Abdominal</option>
					  <option value="Fascia Ilíaca" <?php if("Fascia Ilíaca"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Fascia Ilíaca</option>
					  <option value="Otro (Comentarios)" <?php if("Otro (Comentarios)"==html_entity_decode($fila['analgesia'])){echo "selected='selected'";}?>>Otro (Comentarios)</option>
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
					  <option value="T5 - T6" <?php if("T5 - T6"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T5 - T6</option>
					  <option value="T6 - T7" <?php if("T6 - T7"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T6 - T7</option>
					  <option value="T7 - T8" <?php if("T7 - T8"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T7 - T8</option>
					  <option value="T8 - T9" <?php if("T8 - T9"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T8 - T9</option>
					  <option value="T9 - T10" <?php if("T9 - T10"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T9 - T10</option>
					  <option value="T10 - T11" <?php if("T10 - T11"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T10 - T11</option>
					  <option value="T11 - T12" <?php if("T11 - T12"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T11 - T12</option>
					  <option value="T12 - L1" <?php if("T12 - L1"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>T12 - L1</option>
					  <option value="L1 - L2" <?php if("L1 - L2"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>L1 - L2</option>
					  <option value="L2 - L3" <?php if("L2 - L3"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>L2 - L3</option>
					  <option value="L3 - L4" <?php if("L3 - L4"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>L3 - L4</option>
					  <option value="L4 - L5" <?php if("L4 - L5"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>L4 - L5</option>
					  <option value="L5 - S1" <?php if("L5 - S1"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>L5 - S1</option>
					  <option value="Otro (Comentarios)" <?php if("Otro (Comentarios)"==html_entity_decode($fila['nivel'])){echo "selected='selected'";}?>>Otro (Comentarios)</option>	
					</select>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Distancia Espacio Epidural</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<div class="input-group mb-2">
					  <input type="number" max="12" step=".1" class="form-control" name="espacio_e" id="espacio_e" value="<?php echo html_entity_decode($fila['espacio']);?>">
					  <span class="input-group-text" id="basic-addon2"> cm</span>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Distancia del Catéter</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<div class="input-group mb-2">
					  <input type="number" max="12" step=".1" class="form-control" name="distancia_e" id="distancia_e" value="<?php echo html_entity_decode($fila['distancia']);?>">
					<span class="input-group-text" id="basic-addon2"> cm</span>
					</div>
			 </div>

			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Solución</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="solucion_e" name="solucion_e" required>
					  <option value=""></option>
					  <option value="Bupi 0,1% + Fentanyl 1,6 ug" <?php if("Bupi 0,1% + Fentanyl 1,6 ug"==html_entity_decode($fila['solucion'])){echo "selected='selected'";}?>>Bupi 0,1% + Fentanyl 1,6 ug</option>
					  <option value="Bupivacaína 0,1%" <?php if("Bupivacaína 0,1%"==html_entity_decode($fila['solucion'])){echo "selected='selected'";}?>>Bupivacaína 0,1%</option>
					  <option value="Morfina 0,2 mg/ml" <?php if("Morfina 0,2 mg/ml"==html_entity_decode($fila['solucion'])){echo "selected='selected'";}?>>Morfina 0,2 mg/ml</option>
					  <option value="Metadona 0,2 mg/ml" <?php if("Metadona 0,2 mg/ml"==html_entity_decode($fila['solucion'])){echo "selected='selected'";}?>>Metadona 0,2 mg/ml</option>
					  <option value="Fentanyl 2 ug/ml" <?php if("Fentanyl 2 ug/ml"==html_entity_decode($fila['solucion'])){echo "selected='selected'";}?>>Fentanyl 2 ug/ml</option>
					  <option value="Otro (Comentarios)" <?php if("Otro (Comentarios)"==html_entity_decode($fila['solucion'])){echo "selected='selected'";}?>>Otro (Comentarios)</option>				  
					</select>
					<div class="invalid-feedback pt-0 float-end">
			      Ingrese un valor válido
			    </div>
				</div>	


					 <div>
					<div class='text-muted pt-4'>Infusión PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="infusion_e" id="infusion_e" value="<?php echo html_entity_decode($fila['infusion']);?>">
					  <span class="input-group-text" id="basic-addon2"> ml/hr</span>
					</div>
					</div>


					<div class='text-muted pt-3'>Bolo PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="bolo_e" id="bolo_e" value="<?php echo html_entity_decode($fila['bolo']);?>">
					  <span class="input-group-text" id="basic-addon2"> ml</span>
					</div>


					<div class='text-muted pt-3'>Lockout PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="lockout_e" id="lockout_e" value="<?php echo html_entity_decode($fila['lockout']);?>">
					  <span class="input-group-text" id="basic-addon2"> ml</span>
					</div>


					<div class='text-muted pt-3'>Peso</div>
					<div class="input-group mb-2">
					  <input type="number" max="1000" step=".1" class="form-control" name="peso_e" id="peso_e" value="<?php echo html_entity_decode($fila['peso']);?>" required>
					  <span class="input-group-text" id="basic-addon2"> Kg</span>
					 <div class="invalid-feedback pt-0">
				      Ingrese un valor válido
				    </div>
					</div>

				<div class='col'>
			    <div class='text-muted pt-4'>Comentarios</div><textarea class="form-control mb-2" style="resize: none;" maxlength="250" rows="5" name="comentarios_e" id="comentarios_e"><?php echo html_entity_decode($fila['comentarios']);?></textarea>
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


							<?php

							if($_POST['reactivar']){ //SI SE REACTIVA EL REGISTRO
									if($_POST['reactivar']=='yes'){

										echo "<input class='form-check-input form-switch-md' style='transform: scale(1.3);' type='checkbox' role='switch' id='flexSwitchCheckDefault' name='de_alta_e'><label class='form-check-label' for='flexSwitchCheckDefault'></label>";

									}else {
										echo "<input class='form-check-input form-switch-md' style='transform: scale(1.3);' type='checkbox' role='switch' id='flexSwitchCheckChecked' name='de_alta_e' checked><label class='form-check-label' for='flexSwitchCheckChecked'></label> ";
										
									}
							}else{ //edicion normal

								echo "<input class='form-check-input form-switch-md' style='transform: scale(1.3);' type='checkbox' role='switch' id='flexSwitchCheckDefault' name='de_alta_e'><label class='form-check-label' for='flexSwitchCheckDefault'></label>";

							}
							?>


						</div>
					</div>
					</div>
					</div>
				</li>

<br>
<br>
</ul>


		</form>
</div>

	<?php 

		$conexion->close();

	?>
<script>function envioForm_ed_pacte() {document.getElementById('form_ed_pacte').submit(); }</script>


<script>
$("#seeAnotherFieldGroup").change(function() {
			if ($(this).val() == "Peridural") {
				$('#otherFieldGroupDiv').show();
				$('#nivel_e').attr('required','');
				$('#nivel_e').attr('data-error', 'Este campo es requerido.');
				$('#espacio_e').attr('required','');
				$('#espacio_e').attr('data-error', 'Este campo es requerido.');
        $('#distancia_e').attr('required','');
				$('#distancia_e').attr('data-error', 'Este campo es requerido.');
				$("#solucion_e option[value='Morfina 0,2 mg/ml']").hide();
				$("#solucion_e option[value='Metadona 0,2 mg/ml']").hide();
				$("#solucion_e option[value='Fentanyl 2 ug/ml']").hide();
				$("#solucion_e option[value='Bupi 0,1% + Fentanyl 1,6 ug']").show();
				$("#solucion_e option[value='Bupivacaína 0,1%']").show();										
			} else if ($(this).val() == "PCA EV") {
				$("#solucion_e option[value='Morfina 0,2 mg/ml']").show();
				$("#solucion_e option[value='Metadona 0,2 mg/ml']").show();
				$("#solucion_e option[value='Fentanyl 2 ug/ml']").show();
				$("#solucion_e option[value='Bupi 0,1% + Fentanyl 1,6 ug']").hide();
				$("#solucion_e option[value='Bupivacaína 0,1%']").hide();				
				$('#otherFieldGroupDiv').hide();		
				$('#nivel_e').removeAttr('required');
				$('#nivel_e').removeAttr('data-error');
				$('#espacio_e').removeAttr('required');
				$('#espacio_e').removeAttr('data-error');				
        $('#distancia_e').removeAttr('required');
				$('#distancia_e').removeAttr('data-error');	
			} else if ($(this).val() == "Otro (Comentarios)") {
				$("#solucion_e option[value='Morfina 0,2 mg/ml']").hide();
				$("#solucion_e option[value='Metadona 0,2 mg/ml']").hide();
				$("#solucion_e option[value='Fentanyl 2 ug/ml']").hide();
				$("#solucion_e option[value='Bupi 0,1% + Fentanyl 1,6 ug']").hide();
				$("#solucion_e option[value='Bupivacaína 0,1%']").hide();				
				$('#otherFieldGroupDiv').hide();		
				$('#nivel_e').removeAttr('required');
				$('#nivel_e').removeAttr('data-error');
				$('#espacio_e').removeAttr('required');
				$('#espacio_e').removeAttr('data-error');				
        $('#distancia_e').removeAttr('required');
				$('#distancia_e').removeAttr('data-error');	
			} else {
				$("#solucion_e option[value='Morfina 0,2 mg/ml']").hide();
				$("#solucion_e option[value='Metadona 0,2 mg/ml']").hide();
				$("#solucion_e option[value='Fentanyl 2 ug/ml']").hide();				
				$("#solucion_e option[value='Bupi 0,1% + Fentanyl 1,6 ug']").hide();
				$("#solucion_e option[value='Bupivacaína 0,1%']").show();				
				$('#otherFieldGroupDiv').hide();
				$('#nivel_e').removeAttr('required');
				$('#nivel_e').removeAttr('data-error');
				$('#espacio_e').removeAttr('required');
				$('#espacio_e').removeAttr('data-error');				
        $('#distancia_e').removeAttr('required');
				$('#distancia_e').removeAttr('data-error');	
			}

		});
		$("#seeAnotherFieldGroup").trigger("change");	
</script>


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
