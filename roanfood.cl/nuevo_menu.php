<?php
//variables
		$boton_toggler="<a class='btn pt-2 pb-2 navbar-toggler border-secondary btn-seconday d-xs-block d-sm-none' style='; --bs-border-opacity: .1;' type='button' href='index.php'><div><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='fs-5'><img class='pe-2' src='images/icon.png' style='width: 48px' /></span>MENÚ <small class='ps-5 opacity-50' style='font-size: 10px'>&nbsp;</small>";


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
   <div class="col col-sm-8 col-xl-8">

	<form class="needs-validation" name="form_menu" id="form_menu" method="post" action="preview.php" novalidate>
<!-  NAVBAR  ->	


			<ul class="list-group pt-3">
			<li class='list-group-item pt-2 pb-4'><br><h5 class='mb-1 fw-bold'>NUEVO MENÚ</h5></li>
			</ul>


		<!– TABLA DE REGISTROS –>
				<div class='container'>
				<div class='row'>	

				<div class='col'>


					<div class='d-flex justify-content-between mt-3'><div class='text-muted pt-2'>Fecha Menú</div></div>
				 <div class="input-group date">
				  <input type="text" class="form-control" name="fecha_menu" id="datepicker">
				  </div>

			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Opcion 1</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="opcion_1" name="opcion_1">
					  <option value=""></option>
						<?php
							//carga tabla de platos de fondo
				      $consulta_fondos="SELECT * FROM `fondo_rf`";
			        $confirma_fondos=$conexion->query($consulta_fondos); 
         
							while($fondos_g=$confirma_fondos->fetch_assoc()){
								$id_fondo=$fondos_g['id_fondo'];
								$nombre_fondo=$fondos_g['nombre_plato_fon'];

								echo "<option value='$id_fondo'>$nombre_fondo</option>";

							}
						?>	
					</select>

				<input type="hidden" name="rut_v" id="rut_v" value="asdasd">

			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Opcion 2</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="opcion_2" name="opcion_2">
					  <option value=""></option>									
						<?php
							//carga tabla de platos de fondo
				      $consulta_fondos="SELECT * FROM `fondo_rf`";
			        $confirma_fondos=$conexion->query($consulta_fondos); 
         
							while($fondos_g=$confirma_fondos->fetch_assoc()){
								$id_fondo=$fondos_g['id_fondo'];
								$nombre_fondo=$fondos_g['nombre_plato_fon'];

								echo "<option value='$id_fondo'>$nombre_fondo</option>";

							}
						?>					  
					</select>

			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Opcion 3</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="opcion_3" name="opcion_3">
					  <option value=""></option>						
						<?php
							//carga tabla de platos de fondo
				      $consulta_fondos="SELECT * FROM `fondo_rf`";
			        $confirma_fondos=$conexion->query($consulta_fondos); 
         
							while($fondos_g=$confirma_fondos->fetch_assoc()){
								$id_fondo=$fondos_g['id_fondo'];
								$nombre_fondo=$fondos_g['nombre_plato_fon'];

								echo "<option value='$id_fondo'>$nombre_fondo</option>";

							}
						?>	
					</select>


			    <div class='d-flex justify-content-between pt-3'><div class='text-muted'>Opcion 4</div><div class="fw-lighter text-muted"><small>Requerido (*)</small></div></div>
					<select class="form-select mb-2" id="opcion_4" name="opcion_4">
					  <option value=""></option>						
						<?php
							//carga tabla de platos de fondo
				      $consulta_fondos="SELECT * FROM `fondo_rf`";
			        $confirma_fondos=$conexion->query($consulta_fondos); 
         
							while($fondos_g=$confirma_fondos->fetch_assoc()){
								$id_fondo=$fondos_g['id_fondo'];
								$nombre_fondo=$fondos_g['nombre_plato_fon'];

								echo "<option value='$id_fondo'>$nombre_fondo</option>";

							}
						?>		  
					</select>

					<div class="text-end pt-4 pb-4">
						<button class="btn btn-primary" type="Submit">GUARDAR</button>
					</div>


					</div>
				</div>
				</div>

		</form>

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