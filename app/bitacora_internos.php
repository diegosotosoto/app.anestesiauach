<?php
//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
	//redirección segun nivel de usuario
	$check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	$con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
	$users_b=$conexion->query($con_users_b);
	$usuario=$users_b->fetch_assoc();
	if($usuario['admin']==1){
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['staff_']==1) {
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['intern_']==1) {
			//CONTINUA EN LA PAGINA
		} elseif ($usuario['becad_']==1) {
			header('Location: bitacora_ingreso.php');
		}


//VARIABLES
	
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Bitácora</span>";
		$boton_navbar="<a></a>";

	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->


<?php
//Guarda la Bitácora


			//GUARDAR EDICIÓN DE USUARIO
				if($_POST['rut_i']){

			$autor_i=strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj13']));
			$rut_i=htmlentities(addslashes(strtoupper($_POST['rut_i'])));
			$ficha_i=htmlentities(addslashes($_POST['ficha_i']));
			$edad_i=htmlentities(addslashes($_POST['edad_i']));
			$procedimiento_i=htmlentities(addslashes($_POST['procedimiento_i']));
			$fecha_i=htmlentities(addslashes($_POST['fecha_i']));

			$evaluacion_i=htmlentities(addslashes($_POST['evaluacion_i']));
			$ventilacion_i=htmlentities(addslashes($_POST['ventilacion_i']));
			$intubacion_i=htmlentities(addslashes($_POST['intubacion_i']));
			$lma_i=htmlentities(addslashes($_POST['lma_i']));
			$ayudas_i=htmlentities(addslashes($_POST['ayudas_i']));
			$vvp_i=htmlentities(addslashes($_POST['vvp_i']));			
			$espinal_i=htmlentities(addslashes($_POST['espinal_i']));
			$seminario_i=htmlentities(addslashes($_POST['seminario_i']));
			$staff_i=htmlentities(addslashes($_POST['staff_i']));
			$comentarios_i=htmlentities(addslashes($_POST['comentarios_i']));



			$consulta_i="INSERT INTO `bitacora_internos` (`autor_i`, `rut_i`, `ficha_i`, `edad_i`, `procedimiento_i`, `fecha_i`, `evaluacion_i`, `ventilacion_i`, `intubacion_i`, `lma_i`, `ayudas_i`, `vvp_i`, `espinal_i`, `seminario_i`, `staff_i`, `comentarios_i`) VALUES ('$autor_i','$rut_i', '$ficha_i', '$edad_i', '$procedimiento_i', '$fecha_i', '$evaluacion_i', '$ventilacion_i', '$intubacion_i', '$lma_i', '$ayudas_i', '$vvp_i', '$espinal_i', '$seminario_i', '$staff_i', '$comentarios_i') ";
			

			$escribir_i=$conexion->query($consulta_i);


			if($escribir_i==false){
				echo "
							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
						  	</div>
				";

			}else{

				echo "
							<div class='alert alert-success alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Registro Guardado.
						  	</div>
				";

			} 
		}







?>

<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Ingreso</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="bitacora_estad_i.php">Estadística</a>
  </li>
</ul>


	<form class="needs-validation" name="form_ingreso_bit" id="form_ingreso_bit" method="post" action="bitacora_internos.php" novalidate>
<!-  NAVBAR  ->	


			<ul class="list-group">
			<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><h4 class='mb-1 fw-bold pt-3'>Bitácora de</h4><div class='text-black-75 pb-3 pt-1' style='font-size: 14px'> <?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?>	
			</div>
			</li>
			</ul>


		<!– TABLA DE REGISTROS –>
				<div class='container'>
				<div class='row'>	
				<div class='col'>

				<div>
				<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Rut Paciente <span class="opacity-50">(ej: 12345678-9)</span></div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-2" type="text" oninput="checkRut(this)" name="rut_i" id="rut_i" required>
				<div class="invalid-feedback pt-1">
						Ingrese un RUT válido
			    </div>
				</div>

  				<div>
				<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Ficha</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-1" type="text" name="ficha_i" id="ficha_i" pattern="[0-9]{1,7}" required>
				<div class="invalid-feedback pt-1">
			      Ingrese un número de ficha válido
			    </div>
				</div>

				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Edad</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="edad_i" name="edad_i" required>
					  <option value=""></option>
					  <option value="RNPT">RNPT</option>
					  <option value="Neonato">Neonato</option>
					  <option value="Menor de 6 meses">Menor de 6 meses</option>
					  <option value="6 meses a 1 año">6 meses a 1 año</option>
					  <option value="1 Año a 15 años">1 Año a 15 años</option>
					  <option value="Adulto">Adulto</option>
					  <option value="Adulto de 70 años y mayor">Adulto de 70 años y mayor</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>			

				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Procedimiento</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="procedimiento_i" name="procedimiento_i" required>
					  <option value=""></option>
					  <option value="Cirugía General">Cirugía General</option>
					  <option value="Cirugía Pediátrica">Cirugía Pediátrica</option>
					  <option value="Cesárea">Cesárea</option>
					  <option value="Cirugía Vascular">Cirugía Vascular</option>
					  <option value="Cirugía de Tórax">Cirugía de Tórax</option>
					  <option value="Neurocirugía">Neurocirugía</option>
					  <option value="Otra">Otra</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>	
		

				 <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Fecha <span class="opacity-50">(dd/mm/aaaa)</span></div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				 <div class="input-group date">
				  <input type="text" class="form-control" name="fecha_i" id="datepicker" required>
				  </div>


				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Evaluación Preanestésica</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="evaluacion_i" name="evaluacion_i" required>
					  <option value=""></option>
					  <option value="1">Evaluación Completa</option>
					  <option value="2">Evaluación Incompleta</option>
					  <option value="3">Evaluación No Realizada</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>	

				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Ventilación</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="ventilacion_i" name="ventilacion_i">
					  <option value=""></option>
					  <option value="1">Exitosa Solo</option>
					  <option value="2">Exitosa con Ayuda</option>				  
					  <option value="3">Fallida</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>	


				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Intubación</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="intubacion_i" name="intubacion_i">
					  <option value=""></option>
					  <option value="1">Exitosa Solo</option>
					  <option value="2">Exitosa con Ayuda</option>				  
					  <option value="3">Fallida</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>	

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Máscara Laríngea</div><div class="fw-lighter text-muted"><small></small></div></div>
					<div class="input-group mb-2">
					<select class="form-select mb-2" id="lma_i" name="lma_i">
					  <option value=""></option>						
					  <option value="1">Exitosa Solo</option>
					  <option value="2">Exitosa con Ayuda</option>				  
					  <option value="3">Fallida</option>
					</select>
					<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
					</div>


				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Uso Conductor/Bougie</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="ayudas_i" name="ayudas_i">
					  <option value=""></option>
					  <option value="1">Exitoso Solo</option>
					  <option value="2">Exitoso con Ayuda</option>				  
					  <option value="3">Fallido</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>	

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Vía Venosa Periférica</div><div class="fw-lighter text-muted"><small></small></div></div>
					<div class="input-group mb-2">
					<select class="form-select mb-2" id="vvp_i" name="vvp_i">
					  <option value=""></option>						
					  <option value="1">Exitosa Solo</option>
					  <option value="2">Exitosa con Ayuda</option>				  
					  <option value="3">Fallida</option>
					</select>
					</div>


					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Anestesia Espinal/Raquídea</div><div class="fw-lighter text-muted"><small></small></div></div>
					<div class="input-group mb-2">
					<select class="form-select mb-2" id="espinal_i" name="espinal_i">
					  <option value=""></option>						
					  <option value="1">Exitosa Solo</option>
					  <option value="2">Exitosa con Ayuda</option>				  
					  <option value="3">Fallida</option>
					</select>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Realización Seminarios</div><div class="fw-lighter text-muted"><small></small></div></div>
					<div class="input-group mb-2">
					<select class="form-select mb-2" id="seminario_i" name="seminario_i">
					  <option value=""></option>						
					  <option value="1">Vía Aérea</option>
					  <option value="2">Anestesia Neuroaxial</option>
					  <option value="3">RCP</option>
					  <option value="4">Transfusiones</option>	
					  <option value="5">Dolor</option>
					</select>
					</div>

			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Anestesiólog@ Responsable</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="staff_i" name="staff_i" required>
					  <option value=""></option>
				<?php

				$consulta_staff="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `staff_` = '1' OR  `admin` = '1' ";
				$busqueda_staff=$conexion->query($consulta_staff);

				while($staff=$busqueda_staff->fetch_assoc()){

 				echo "<option value='".$staff['nombre_usuario']."'>".$staff['nombre_usuario']."</option>";

				}

				?>
					</select>
					<div class="invalid-feedback pt-0 pb-3 float-end">
			      Ingrese un valor válido
			    </div>
				</div>	


			<div class='col'>
			    <div class='text-muted pt-4'>Comentarios</div><textarea class="form-control mb-2" style="resize: none;" maxlength="250" rows="5" name="comentarios_b" id="comentarios_b"></textarea>
			  </div>


		</form>


		<div class="pt-3 ps-3 me-3 d-flex justify-content-end">
		<button class='btn pull-right btn-primary shadow-sm border-light' style='; --bs-border-opacity: .1;' type='submit' form='form_ingreso_bit' value='Submit' id='boton'><div class='text-white'>Guardar Bitácora</div></button>
		</div>



</div></div>


<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
		require("footer.php");

	?>

<script type="text/javascript" src="js/not_reload.js"></script>
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
      } else {
          // Desactivar el botón de envío del formulario
          $('#boton').prop('disabled', true);
        }

      form.classList.add('was-validated')
    }, false)
  })
})()

</script>


<!-  FOOTER  ->
