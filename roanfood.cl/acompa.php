<?php
//variables
		$boton_toggler="<a class='btn pt-2 pb-2 navbar-toggler border-secondary btn-seconday d-xs-block d-sm-none' style='; --bs-border-opacity: .1;' type='button' href='index.php'><div><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='fs-5'><img class='pe-2' src='images/icon.png' style='width: 48px' /></span>INVENTARIO <small class='ps-5 opacity-50' style='font-size: 10px'>&nbsp;</small>";


	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41laa8u4l1k23jhlkj1387s76d8as76a9sd8'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
	//Carga Head de la página
	require("head.php");

?>

<!- INICIO DE LA COLUMNA ->

   <div class="col col-sm-8 col-xl-8">

<?php 
			//VARIABLES
				$nombre_bd="acomp_rf";
				$nombre_bd_id="id_acomp";
				$nombre_bd_plato="nombre_plato_acomp";
				$nombre_bd_descripcion="descripcion_plato_acomp";
				$nombre_bd_precio="precio_plato_acomp";
				$nombre_bd_foto="nombre_foto_acomp";
				$nombre_bd_otro="otro_acomp";
				$direccion_sitio="acompa.php";
				$titulo_pagina="Acompañamientos";
				$fondo_activo="";
				$acompa_activo="active";				
				$hipoc_activo="";
				$postres_activo="";
				$entrada_activo="";









			//GUARDAR NUEVO PLATO
				if($_POST['new_plato']){
					$new_nombre_pl=htmlentities(addslashes($_POST['new_nombre_plato']));			
					$new_precio_pl=htmlentities(addslashes($_POST['new_precio_plato']));
					$new_foto_pl=htmlentities(addslashes($_POST['new_nombre_foto']));
					$new_descrip_pl=htmlentities(addslashes($_POST['new_descripcion']));

							$consulta_new="INSERT INTO `$nombre_bd` (`$nombre_bd_id`, `$nombre_bd_plato`, `$nombre_bd_descripcion`, `$nombre_bd_precio`, `$nombre_bd_foto`, `$nombre_bd_otro`) VALUES (NULL, '$new_nombre_pl', '$new_descrip_pl', '$new_precio_pl', '$new_foto_pl', NULL);";

							$escribir_new=$conexion->query($consulta_new);

							if($escribir_new==false){
								echo "Error en la consulta";

							}else{

								echo "
											<div class='alert alert-success alert-dismissible fade show'>
										    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
										    <strong>Info!</strong> Registro Guardado.
										  	</div>
								";

							} 


				}

			//GUARDAR EDICIÓN DE PLATO
				if($_POST['nombre_plato']){	
					$nombre_pl=htmlentities(addslashes($_POST['nombre_plato']));			
					$precio_pl=htmlentities(addslashes($_POST['precio_plato']));
					$foto_pl=htmlentities(addslashes($_POST['nombre_foto']));
					$descrip_pl=htmlentities(addslashes($_POST['descripcion']));
					$id_pl=htmlentities(addslashes($_POST['id_fondo']));

					$consulta_us="UPDATE `$nombre_bd` SET `$nombre_bd_plato`='$nombre_pl', `$nombre_bd_precio`='$precio_pl', `$nombre_bd_foto`='$foto_pl', `$nombre_bd_descripcion`='$descrip_pl' WHERE `$nombre_bd_id`='$id_pl'";

					$escribir_us=$conexion->query($consulta_us);

					if($escribir_us==false){
						echo "Error en la consulta";

					}else{

						echo "
									<div class='alert alert-success alert-dismissible fade show'>
								    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
								    <strong>Info!</strong> Registro Actualizado.
								  	</div>
						";

					} 
		}


			//GUARDAR ELIMINACIÓN DE PLATO
				if($_POST['delete']){	
					$id_pl_del=htmlentities(addslashes($_POST['id_fondo_del']));

					$consulta_del="DELETE FROM `$nombre_bd` WHERE `$nombre_bd_id`='$id_pl_del'";

					$escribir_del=$conexion->query($consulta_del);

					if($escribir_del==false){
						echo "Error en la consulta";

					}else{

						echo "
									<div class='alert alert-danger alert-dismissible fade show'>
								    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
								    <strong>Info!</strong> Registro BORRADO.
								  	</div>
						";

					} 					

			}


			//CARGA TABLA DE PLATOS
      $consulta_fondos="SELECT * FROM `$nombre_bd`";
      $confirma_fondos=$conexion->query($consulta_fondos); 
			$i=1;
			$k=1;



?>



	<ul class="list-group pt-3 pb-3">
	<li class='list-group-item pb-4 bg-light'><br><h5 class='mb-1 fw-bold'>INVENTARIO</h5></li>
	</ul>



<!-  ****** PESTAÑAS ****** ->	


<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?php echo $fondo_activo; ?>" href="gestion_inventario.php">Platos de Fondo</a>
  </li>
   <li class="nav-item">
    <a class="nav-link <?php echo $acompa_activo; ?>" href="acompa.php">Acompañamientos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo $hipoc_activo; ?>" href="hipocaloricos.php">Hipocalóricos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo $postres_activo; ?>" href="postres.php">Postres</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo $entrada_activo; ?>">Entradas</a>
  </li>
</ul>



<!– TABLA DE REGISTROS –>

		<div class='container'>
		<div class='row'>	
      <div class="col pt-3 ms-0 me-0 ps-0 text-center" style="font-size: min(max(12px, 2vw), 22px)">
        <?php echo $titulo_pagina; ?>
      </div>			
		</div>


		<?php
			while($fondos_g=$confirma_fondos->fetch_assoc()){
				$id_fondo=$fondos_g[$nombre_bd_id];
				$nombre_fondo=$fondos_g[$nombre_bd_plato];
				$descripcion_fondo=$fondos_g[$nombre_bd_descripcion];
				$precio_fondo=$fondos_g[$nombre_bd_precio];
				$nombre_foto_fondo=$fondos_g[$nombre_bd_foto];


echo "<div class='row'>
		<ul class='list-group pt-3'>
			<li class='list-group-item pt-2 pb-4  bg-light'>
				<form id='gest_invent_$i' action='$direccion_sitio' method='post'>
				   <div class='row'>
							<div class='col col-5' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Plato</div><div class='fw-lighter text-muted'></div></div>
								<input class='form-control mb-2' type='text' name='nombre_plato' id='nombre_plato' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' value='$nombre_fondo' required>
								<div class='invalid-feedback pt-1'>
									Ingrese un nombre válido
						    </div>
							</div>

							<div class='col col-2' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Precio</div><div class='fw-lighter text-muted'></div></div>
								<input class='form-control mb-2' type='text' name='precio_plato' id='precio_plato' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{4,}' value='$precio_fondo' required>
								<div class='invalid-feedback pt-1'>
									Ingrese un precio válido
						    </div>
							</div>

							<div class='col col-5' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Foto</div><div class='fw-lighter text-muted'></div></div>
								<input class='form-control mb-2' type='text' name='nombre_foto' id='nombre_foto' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' value='$nombre_foto_fondo' required>
								<div class='invalid-feedback pt-1'>
									Ingrese un nombre válido
						    </div>
							</div>

							<div class='col col-12' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Descripción</div><div class='fw-lighter text-muted'></div></div>
								<textarea class='form-control mb-2' style='resize: none;' maxlength='250' rows='1' name='descripcion' id='descripcion'>$descripcion_fondo</textarea>
								<div class='invalid-feedback pt-1'>
									Ingrese una descripción válida
						    </div>
							</div>

							<input type='hidden' name='id_fondo' value='$id_fondo'/>

							<div class='col col-6 pt-4' style='font-size: min(max(12px, 2vw), 22px)'>	

				        <a href='#' onclick='envioForm$i()' type='button' class='btn btn-primary fs-5'>Actualizar</a> 
							</form>
				      <script>function envioForm$i() {document.getElementById('gest_invent_$i').submit(); }</script>
				    </div>

				    <div class='col col-6 pt-4' style='font-size: min(max(12px, 2vw), 22px)'>

								<form id='gest_del_$k' action='$direccion_sitio' method='post'>

									<input type='hidden' name='delete' value='delete'/>
									<input type='hidden' name='id_fondo_del' value='$id_fondo'/>

						<!-- Button trigger modal -->
						<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal_$i'>
						  <i class='fa-solid fa-trash'></i>
						</button>

						<!-- Modal -->
						<div class='modal fade' id='deleteModal_$i' tabindex='-1' aria-labelledby='exampleModalLabel_$i' aria-hidden='true'>
						  <div class='modal-dialog'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h1 class='modal-title fs-5' id='exampleModalLabel_$i'>Desea Eliminar el plato $nombre_fondo</h1>
						        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
						      </div>
						      <div class='modal-body'>
						        Esta acción no se puede desacer
						      </div>
						      <div class='modal-footer'>
						        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>

										<a href='#' onclick='envioForm_del$k()' type='button' class='btn btn-danger fs-5'>Eliminar</a>

						      </div>
						    </div>
						  </div>
						</div>




				    		</form>
				      <script>function envioForm_del$k() {document.getElementById('gest_del_$k').submit(); }</script>
				    </div>

				</div>
			</li>
	</ul>
</div>";



$i++;
$k++;

}

?>


<!- REGISTRO NUEVO ->
		<div class='row'>	
      <div class="col pt-3 ms-0 me-0 ps-0 text-center" style="font-size: min(max(12px, 2vw), 22px)">
        CREAR NUEVO PLATO
      </div>			
		</div>
<div class='row'>
		<ul class='list-group pt-3'>
			<li class='list-group-item pt-2 pb-4 bg-success' style=' --bs-bg-opacity: 0.2;'>
				<form id='gest_invent_new' action='<?php echo $direccion_sitio; ?>' method='post'>
				   <div class='row'>
							<div class='col col-5' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Plato</div><div class='fw-lighter text-muted'></div></div>
								<input class='form-control mb-2' type='text' name='new_nombre_plato' id='new_nombre_plato' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' required>
								<div class='invalid-feedback pt-1'>
									Ingrese un nombre válido
						    </div>
							</div>

							<div class='col col-2' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Precio</div><div class='fw-lighter text-muted'></div></div>
								<input class='form-control mb-2' type='text' name='new_precio_plato' id='new_precio_plato' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{4,}' required>
								<div class='invalid-feedback pt-1'>
									Ingrese un precio válido
						    </div>
							</div>

							<div class='col col-5' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Foto</div><div class='fw-lighter text-muted'></div></div>
								<input class='form-control mb-2' type='text' name='new_nombre_foto' id='new_nombre_foto' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}'  required>
								<div class='invalid-feedback pt-1'>
									Ingrese un nombre válido
						    </div>
							</div>

							<div class='col col-12' style='font-size: min(max(12px, 2vw), 22px)'>
							<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Descripción</div><div class='fw-lighter text-muted'></div></div>
								<textarea class='form-control mb-2' style='resize: none;' maxlength='250' rows='1' name='new_descripcion' id='new_descripcion'></textarea>
								<div class='invalid-feedback pt-1'>
									Ingrese una descripción válida
						    </div>
							</div>

							<input type='hidden' name='new_plato' value='new_plato'/>

							<div class='col col-12 pt-4' style='font-size: min(max(12px, 2vw), 22px)'>	

				        <a href='#' onclick='envioForm_new()' type='button' class='btn btn-success fs-5'>Nuevo Plato</a> 
							</form>
				      <script>function envioForm_new() {document.getElementById('gest_invent_new').submit(); }</script>
				    </div>

				    <div class='col col-6 pt-4' style='font-size: min(max(12px, 2vw), 22px)'>
				    </div>

				</div>
			</li>
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
					var currentDate = new Date();
					var currentDayOfMonth = currentDate.getDate();
					var dayOfMonthFormatted = (currentDayOfMonth+1).toString().padStart(2, "0");
					var currentMonth = currentDate.getMonth().toString().padStart(1, "0"); // Be careful! January is 0, not 1
					var currentYear = currentDate.getFullYear();
					var dateString = (dayOfMonthFormatted) + "/" + (currentMonth + 1) + "/" + currentYear;

    			today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $(function() {
            $('#datepicker').datepicker({
            	 		uiLibrary: 'bootstrap5',
            	    format: 'dd/mm/yyyy',
            	    weekStartDay: 1,
            	    autoclose: true,
            	    showOnFocus: true,
            	    value: dateString,
            	    showRightIcon: true,
            }

            	);

        });


    </script>

	<?php 

		$conexion->close();
		require("footer.php");

	?>