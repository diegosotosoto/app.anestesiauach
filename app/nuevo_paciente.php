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
	<form class="needs-validation" name="form_ingreso" id="form_ingreso" method="post" action="index.php" novalidate>
<!-  NAVBAR  ->	

	<?php
	

		$boton_toggler="<a class='btn btn-lg shadow-sm' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Nuevo";
		$boton_navbar="<button class='btn btn-lg shadow-sm' type='submit' form='form_ingreso' value='Submit'><div class='text-white'>Agregar</div></button>";

		require("navbar.php");
	?>
<br><br>
			<ul class="list-group">
			<li class='list-group-item'><br><h5 class='mb-1 fw-bold'>Ingresar Datos</h5></li>
			</ul>


		<!– TABLA DE REGISTROS –>
				<div class='container'>
				<div class='row'>	

				<div class='col'>
				<div class='d-flex justify-content-between mt-3'><div class='text-muted'>Nombre del Paciente</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-2" type="text" name="nombre_paciente" id="nombre_paciente" pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' required>
				 <div class="invalid-feedback pt-1">
			      Ingrese un Nombre y Dos Apellidos
			    </div>
				</div>

				<div>
				<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Rut (sin puntos ej: 12345678-9)</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-2" type="text" oninput="checkRut(this)" name="rut" id="rut" required>
				<div class="invalid-feedback pt-1">
						Ingrese un RUT válido
			    </div>
				</div>


  			<div>
				<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Ficha</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-2" type="text" name="ficha" id="ficha" pattern="[0-9]{1,7}" required>
				<div class="invalid-feedback pt-1 float-end">
			      Ingrese un número de ficha válido
			    </div>
				</div>

			    <div>
				<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Unidad / Cama</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-2" type="text" name="unidad_cama" id="unidad_cama" required list="unidades" autocomplete="off">
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
				<div class="invalid-feedback pt-1 float-end">
			      Ingrese un valor válido
			    </div>
				</div>



			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Procedimiento</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
			    <input class="form-control mb-2" type="text" name="procedimiento" id="procedimiento" required pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' >
				<div class="invalid-feedback pt-1">
			      Ingrese un valor válido
			    </div>
				</div>			    

				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Analgesia</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="seeAnotherFieldGroup" name="analgesia" required>
					  <option value=""></option>
					  <option value="PCA EV">PCA EV</option>
					  <option value="Peridural">Peridural</option>
					  <option value="Plexo Braquial">Plexo Braquial</option>
					  <option value="Ciático Poplíteo">Ciático Poplíteo</option>
					  <option value="Femoral">Femoral</option>
					  <option value="Canal Aductor">Canal Aductor</option>
					  <option value="ESP">ESP</option>
					  <option value="Pared Abdominal">Pared Abdominal</option>
					  <option value="Fascia Ilíaca">Fascia Ilíaca</option>
					  <option value="Otro (Comentarios)">Otro (Comentarios)</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>			


			<div class="form-group" id="otherFieldGroupDiv">
				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Nivel</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="nivel" name="nivel">
					  <option value=""></option>						
					  <option value="T5 - T6">T5 - T6</option>
					  <option value="T6 - T7">T6 - T7</option>
					  <option value="T7 - T8">T7 - T8</option>
					  <option value="T8 - T9">T8 - T9</option>
					  <option value="T9 - T10">T9 - T10</option>
					  <option value="T10 - T11">T10 - T11</option>
					  <option value="T11 - T12">T11 - T12</option>
					  <option value="T12 - L1">T12 - L1</option>
					  <option value="L1 - L2">L1 - L2</option>
					  <option value="L2 - L3">L2 - L3</option>
					  <option value="L3 - L4">L3 - L4</option>
					  <option value="L4 - L5">L4 - L5</option>
					  <option value="L5 - S1">L5 - S1</option>
					  <option value="Otro (Comentarios)">Otro (Comentarios)</option>					  
					</select>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Distancia Espacio Epidural</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<div class="input-group mb-2">
					  <input type="number" max="12" step=".1" class="form-control" name="espacio" id="espacio">
					  <span class="input-group-text" id="basic-addon2"> cm</span>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Distancia del Catéter</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<div class="input-group mb-2">
					  <input  type="number" max="12" step=".1" class="form-control" name="distancia" id="distancia">
					  <span class="input-group-text" id="basic-addon2"> cm</span>
					</div>
			 </div>

			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Solución</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="solucion" name="solucion" required>
					  <option value=""></option>
					  <option value="Bupi 0,1% + Fentanyl 1,6 ug">Bupi 0,1% + Fentanyl 1,6 ug</option>
					  <option value="Bupivacaína 0,1%">Bupivacaína 0,1%</option>
					  <option value="Morfina 0,2 mg/ml">Morfina 0,2 mg/ml</option>
					  <option value="Metadona 0,2 mg/ml">Metadona 0,2 mg/ml</option>
					  <option value="Fentanyl 2 ug/ml">Fentanyl 2 ug/ml</option>
					  <option value="Otro (Comentarios)">Otro (Comentarios)</option>				  
					</select>
					<div class="invalid-feedback pt-0 float-end">
			      Ingrese un valor válido
			    </div>
				</div>	

					 <div>
					<div class='text-muted pt-4'>Infusión PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="infusion" id="infusion">
					  <span class="input-group-text" id="basic-addon2"> ml/hr</span>
					</div>
					</div>

					<div class='text-muted pt-3'>Bolo PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="bolo" id="bolo">
					  <span class="input-group-text" id="basic-addon2"> ml</span>
					</div>

					<div class='text-muted pt-3'>Lockout PCA</div>
					<div class="input-group mb-2">
					  <input type="number" max="100" step=".1" class="form-control" name="lockout" id="lockout">
					  <span class="input-group-text" id="basic-addon2"> ml</span>
					</div>


					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Peso</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<div class="input-group mb-2">
					  <input type="number" max="1000" step=".1" class="form-control" name="peso" id="peso" required>
					  <span class="input-group-text" id="basic-addon2"> Kg</span>
					 <div class="invalid-feedback pt-0">
				      Ingrese un valor válido
				    </div>
					</div>

					<div class='col'>
			    <div class='text-muted pt-4'>Comentarios</div><textarea class="form-control mb-2" style="resize: none;" maxlength="250" rows="5" name="comentarios" id="comentarios"></textarea>
			  </div>
</div>
</div>

		</form>

<br>
<br>

<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
		require("footer.php");

	?>

<script>
$("#seeAnotherFieldGroup").change(function() {
			if ($(this).val() == "Peridural") {
				$('#otherFieldGroupDiv').show();
				$('#nivel').attr('required','');
				$('#nivel').attr('data-error', 'Este campo es requerido.');
				$('#espacio').attr('required','');
				$('#espacio').attr('data-error', 'Este campo es requerido.');
        $('#distancia').attr('required','');
				$('#distancia').attr('data-error', 'Este campo es requerido.');
			} else {
				$('#otherFieldGroupDiv').hide();		
				$('#nivel').removeAttr('required');
				$('#nivel').removeAttr('data-error');
				$('#espacio').removeAttr('required');
				$('#espacio').removeAttr('data-error');				
        $('#distancia').removeAttr('required');
				$('#distancia').removeAttr('data-error');	
			}
		});
		$("#seeAnotherFieldGroup").trigger("change");	
</script>	

<script>
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
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



</body>
</html>
