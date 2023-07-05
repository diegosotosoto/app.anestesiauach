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
	$con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
	$users_b=$conexion->query($con_users_b);
	$usuario=$users_b->fetch_assoc();
	if($usuario['admin']==1){
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['staff_']==1) {
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['intern_']==1 or $usuario['becad_otro']==1) {
 			header('Location: bitacora_internos.php');
		} elseif ($usuario['becad_']==1) {
			//CONTINUA EN LA PAGINA
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
				if($_POST['rut_b']){

			$autor_b=strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj13']));
			$rut_b=htmlentities(addslashes(strtoupper($_POST['rut_b'])));
			$ficha_b=htmlentities(addslashes($_POST['ficha_b']));
			$edad_b=htmlentities(addslashes($_POST['edad_b']));

			$procedimiento_b=htmlentities(addslashes($_POST['procedimiento_b']));
			$fecha_b=htmlentities(addslashes($_POST['fecha_b']));
			$via_aerea_b=htmlentities(addslashes($_POST['via_aerea_b']));
			$vad_b=htmlentities(addslashes($_POST['vad_b']));
			$acceso_vascular_b=htmlentities(addslashes($_POST['acceso_vascular_b']));
			$invasivo_b=htmlentities(addslashes($_POST['invasivo_b']));
			$cvc_b=htmlentities(addslashes($_POST['cvc_b']));

			if($_POST['invasivo_eco_b']=="1"){
				$invasivo_eco_b="1";
			}else{
				$invasivo_eco_b="0";
			}

			$neuroaxial_b=htmlentities(addslashes($_POST['neuroaxial_b']));
			$regional_b=htmlentities(addslashes($_POST['regional_b']));
			$dolor_b=htmlentities(addslashes($_POST['dolor_b']));
			$staff_b=htmlentities(addslashes($_POST['staff_b']));
			$comentarios_b=htmlentities(addslashes($_POST['comentarios_b']));


	$confirma_bitacora_b="SELECT *  FROM `bitacora_proced` WHERE `rut_b` = '$rut_b' AND `ficha_b` = '$ficha_b' AND `fecha_b` = '$fecha_b' AND `autor_b` = '$autor_b' AND `via_aerea_b` = '$via_aerea_b' AND `vad_b` = '$vad_b' AND `acceso_vascular_b` = '$acceso_vascular_b' AND `invasivo_b` = '$invasivo_b' AND `cvc_b` = '$cvc_b' AND `neuroaxial_b` = '$neuroaxial_b' AND `regional_b` = '$regional_b'";
	$consulta_cb=$conexion->query($confirma_bitacora_b);

	$respuesta_cb=mysqli_num_rows($consulta_cb);

	if($respuesta_cb>=1){

				echo "
							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Ya existe un registro ingresado por ".$autor_b." con fecha ".$fecha_b." , para el paciente Rut :".$rut_b.". <strong>No se ha ingresado el nuevo registro</strong>
						  	</div>
				";


	}else{



			$consulta_b="INSERT INTO `bitacora_proced` (`autor_b`, `rut_b`, `ficha_b`, `edad_b`, `procedimiento_b`, `fecha_b`, `via_aerea_b`, `vad_b`, `acceso_vascular_b`, `invasivo_b`, `invasivo_eco_b`, `neuroaxial_b`, `regional_b`, `dolor_b`, `staff_b`, `comentarios_b`, `cvc_b`) VALUES ('$autor_b','$rut_b', '$ficha_b', '$edad_b', '$procedimiento_b', '$fecha_b', '$via_aerea_b', '$vad_b', '$acceso_vascular_b', '$invasivo_b', '$invasivo_eco_b', '$neuroaxial_b', '$regional_b', '$dolor_b', '$staff_b', '$comentarios_b', '$cvc_b') ";
			


			$escribir_b=$conexion->query($consulta_b);


			if($escribir_b==false){
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


}




?>

<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Ingreso</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="bitacora_rechazos.php">Rechazos</a>
  </li> 
</ul>


	<form class="needs-validation" name="form_ingreso_bit" id="form_ingreso_bit" method="post" action="bitacora_ingreso.php" novalidate>
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
				<input class="form-control mb-2" type="text" oninput="checkRut(this)" name="rut_b" id="rut_b" required>
				<div class="invalid-feedback pt-1">
						Ingrese un RUT válido
			    </div>
				</div>

  				<div>
				<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Ficha</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				<input class="form-control mb-1" type="text" name="ficha_b" id="ficha_b" pattern="[0-9]{1,7}" required>
				<div class="invalid-feedback pt-1">
			      Ingrese un número de ficha válido
			    </div>
				</div>

				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Edad</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="edad_b" name="edad_b" required>
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
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Curso/Rotación</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="procedimiento_b" name="procedimiento_b" required>
					  <option value=""></option>
					  <option value="Cirugía General">Cirugía General</option>
					  <option value="Cirugía Pediátrica">Cirugía Pediátrica</option>
					  <option value="Gineco-Obstetricia">Gineco-Obstetricia</option>
					  <option value="Cirugía de Tórax/Vascular">Cirugía de Tórax/Vascular</option>
					  <option value="Neurocirugía">Neurocirugía</option>
					  <option value="Cirugía Cardiovascular">Cirugía Cardiovascular</option>
					  <option value="Cirugía Ambulatoria">Cirugía Ambulatoria</option>
					  <option value="Turno/Urgencias">Turno/Urgencias</option>
					  <option value="Cirugía Urológica">Cirugía Urológica</option>
					  <option value="Traumatología y Regional">Traumatología y Regional</option>
					  <option value="Dolor">Dolor</option>
					  <option value="Electivo">Electivo</option>
					  <option value="UCI/UTI">UCI/UTI</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>	
		

				 <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Fecha <span class="opacity-50">(dd/mm/aaaa)</span></div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
				 <div class="input-group date">
				  <input type="text" class="form-control" name="fecha_b" id="datepicker" required>
				  </div>


				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Manejo de Vía Aérea</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="seeAnotherFieldGroup" name="via_aerea_b">
					  <option value=""></option>
					  <option value="Tubo Orotraqueal">Tubo Orotraqueal</option>		  
					  <option value="Máscara Laríngea">Máscara Laríngea</option>
					  <option value="Tubo Nasotraqueal">Tubo Nasotraqueal</option>
					  <option value="Tubo Doble Lumen">Tubo Doble Lumen</option>
					  <option value="Otra Via Aérea Supraglótica">Otra Via Aérea Supraglótica</option>
					</select>
				<div class="invalid-feedback pt-0">
			      Ingrese un valor válido
			    </div>
				</div>	


				<div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Vía Aérea Dificil</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-2" id="vad_b" name="vad_b">
					  <option value=""></option>						
					  <option value="Bougie">Bougie</option>
					  <option value="Guía o Conductor">Guía o Conductor</option>
					  <option value="Videolaringoscopio">Videolaringoscopio</option>
					  <option value="Dispositivo Supraglótico">Dispositivo Supraglótico</option>
					  <option value="Fibrobroncoscopio">Fibrobroncoscopio</option>
					  <option value="Fastrack">Fastrack</option>
					  <option value="Bonfils">Bonfils</option>
					  <option value="Ventilación en Jet">Ventilación en Jet</option>
					  <option value="Via Aérea Quirúrgica">Via Aérea Quirúrgica</option>			  
					</select>
					</div>

					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Acceso Vascular</div><div class="fw-lighter text-muted"><small></small></div></div>
					<div class="input-group mb-2">
					<select class="form-select mb-2" id="acceso_vascular_b" name="acceso_vascular_b">
					  <option value=""></option>						
					  <option value="Vía Venosa Periférica">Vía Venosa Periférica</option>
					  <option value="Midline">Midline</option>
					  <option value="PICC">PICC</option>	  
					</select>
					</div>

				    <div>
				    <div class='d-flex justify-content-between pt-0 pb-3'><div class='text-muted'>Uso de Ecógrafo</div><div class="fw-lighter text-muted">
				    <input class='form-check-input' type='checkbox' name='invasivo_eco_b' id='invasivo_eco_b' value='1'/>
					</div>
					</div>
					</div>


					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Monitorización Invasiva</div><div class="fw-lighter text-muted"><small></small></div></div>
					<div class="input-group mb-2">
					<select class="form-select mb-2" id="invasivo_b" name="invasivo_b">
					  <option value=""></option>						
					  <option value="Línea Arterial">Línea Arterial</option>
					  <option value="Línea Arterial con Eco">Línea Arterial con Eco</option>
					</select>
					</div>


					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>A. Venoso Central</div><div class="fw-lighter text-muted"><small></small></div></div>
					<div class="input-group mb-2">
					<select class="form-select mb-2" id="cvc_b" name="cvc_b">
					  <option value=""></option>						
					  <option value="CVC">CVC</option>
					  <option value="Cateter de Arteria Pulmonar">Cateter de Arteria Pulmonar</option>
					  <option value="CVC con reparos anatómicos">CVC con reparos anatómicos</option>
					  <option value="Cateter Pulmonar por anatomía">Cateter Pulmonar por anatomía</option>
					</select>
					</div>




			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Anestesia Neuroaxial</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="neuroaxial_b" name="neuroaxial_b">
					  <option value=""></option>
					  <option value="Anestesia Espinal">Anestesia Espinal</option>
					  <option value="Combinada Espinal-Epidural">Combinada Espinal-Epidural</option>
					  <option value="Analgesia Epidural Lumbar">Analgesia Epidural Lumbar</option>
					  <option value="Analgesia Epidural Torácica">Analgesia Epidural Torácica</option>
					  <option value="Anestesia Caudal">Anestesia Caudal</option>
					  <option value="Otro">Otro</option>				  
					</select>
					<div class="invalid-feedback pt-0 float-end">
			      Ingrese un valor válido
			    </div>
				</div>	

			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Anestesia Regional</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="regional_b" name="regional_b">
					  <option value=""></option>
					  <option value="Bloqueo de Plaxo Braquial">Bloqueo de Plexo Braquial</option>
					  <option value="Bloqueo de EEII">Bloqueo de EEII</option>
					  <option value="Bloqueo de Pared/Interfascial">Bloqueo de Pared/Interfascial</option>
					  <option value="Bloqueo Nervio Dorsal del Pene">Bloqueo Nervio Dorsal del Pene</option>
					  <option value="Bloqueo Paravertebral">Bloqueo Paravertebral</option>
					  <option value="Bloqueo Plexo Lumbar">Bloqueo Plexo Lumbar</option>
					  <option value="Bloqueo Nervio Periférico">Bloqueo Nervio Periférico</option>					  
					  <option value="Regional Ev">Regional Ev</option>				
					  <option value="Otro">Otro</option>		  
					</select>
					<div class="invalid-feedback pt-0 float-end">
			      Ingrese un valor válido
			    </div>
				</div>	

			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Manejo de Dolor</div><div class="fw-lighter text-muted"><small></small></div></div>
					<select class="form-select mb-0" id="dolor_b" name="dolor_b">
					  <option value=""></option>
					  <option value="PCA Endovenosa">PCA Endovenosa</option>
					  <option value="PCA Peridural">PCA Peridural</option> 
					  <option value="PCA Plexo/Elastomérica">PCA Plexo/Elastomérica</option> 					  
					  <option value="Dolor Crónico">Dolor Crónico</option>
					  <option value="Otro">Otro</option>		  
					</select>
					<div class="invalid-feedback pt-0 float-end">
			      Ingrese un valor válido
			    </div>
				</div>


			    <div>
			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Anestesiólog@ Responsable</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-0" id="staff_b" name="staff_b" required>
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

			    <div>
			    <div class='d-flex justify-content-between pt-5 pb-3'><div class='text-muted'>Autorizado por Staff</div><div class="fw-lighter text-muted">
			    <input class='form-check-input' type='checkbox' name='aprobado_staff_b' id='aprobado_staff_b' value='1' disabled/>
					</div></div>
					</div>




			<div class='col'>
			    <div class='text-muted pt-4'>Comentarios</div><textarea class="form-control mb-2" style="resize: none;" maxlength="250" rows="5" name="comentarios_b" id="comentarios_b"></textarea>
			  </div>


		</form>


		<div class="pt-3 ps-3 me-3 d-flex justify-content-end">
		<button class='btn pull-right btn-primary shadow-sm border-light' style='; --bs-border-opacity: .1;' type='submit' form='form_ingreso_bit' value='Submit'id='boton'><div class='text-white'>Guardar Bitácora</div></button>
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
