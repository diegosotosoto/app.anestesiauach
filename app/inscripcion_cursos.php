<?php

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	  //Variables

		$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
		$boton_navbar="<a></a><a></a>";

	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col"><!- Columna principal (derecha) responsive->
	<div class="apunte-surface">
		<div class="container-fluid px-0 px-md-2">
			<div class="admin-shell">

<?php



			//GUARDAR EDICIÓN DE USUARIO
				if($_POST['aceptado']=="1"){

			$rut_inscrito=strtolower(htmlentities(addslashes(strtoupper($_POST['rut_inscrito']))));				
			$sexo_inscrito=htmlentities(addslashes($_POST['sexo_inscrito']));			
			$telefono_inscrito=htmlentities(addslashes($_POST['telefono_inscrito']));
			$correo_inscrito=htmlentities(addslashes($_POST['correo_inscrito']));
			$tipo_inscrito=htmlentities(addslashes($_POST['tipo_inscrito']));		
			
			if($_POST['taller']=="1"){
				$taller="1";
			}else{
				$taller="0";
			}

			if($_POST['fiesta']=="1"){
				$fiesta="1";
			}else{
				$fiesta="0";
			}






			$consulta_us="UPDATE `pacientes` SET `nombre_paciente`='$nombre_pat', `ficha`='$ficha_pat', `rut`='$rut_pat', `de_alta`='$de_alta_pat' WHERE `rut`='$rut_init'";

			$escribir_us=$conexion->query($consulta_us);


			if($escribir_us==false){
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
						    <strong>Info!</strong> Edición de Paciente Guardada: </br>
						    $nombre_pat</br>
						    $rut_pat</br>
						    $ficha_pat</br>";

						   	if($de_alta_pat=="1"){
								echo "De Alta";
							}elseif($de_alta_pat=="0"){
								echo "Sin Alta Actual";
							}

				echo "</div>";

			} 
		}

?>




<section class="admin-card mb-3">
<div class='admin-field'>
    <label class="admin-label" for="search">Buscar inscrito</label>
    <input type='text' class='admin-input' id='search' placeholder='Buscar un Nombre...'>
</div>
</section>
<div class='pt-2 pb-4' id='mytable'>

		<div class='row'>

<?php 
$i=0;
	$con_users="SELECT `nombre_paciente`,`rut`,`ficha`,`de_alta` FROM `pacientes`";

	$tab_users=$conexion->query($con_users);

	while($row_user=$tab_users->fetch_assoc()){

		$nombre_paciente=$row_user['nombre_paciente'];
		$rut=$row_user['rut'];
		$ficha=$row_user['ficha'];

		if($row_user['de_alta']=="1"){ 
			$de_alta="checked";
		}else {
			$de_alta="";
		}


		echo "<ul class='list-group'><li class='list-group-item admin-card mb-2'><form action='gestion_pacientes.php' method='post'>";
		echo "<div class='col pt-2'>Nombre Paciente<input class='form-control mb-2' type='text' name='nombre_paciente' id='nombre_paciente".$i."' value='$nombre_paciente' required/></div>";
		echo "<div class='col pt-2'>Rut <input class='form-control mb-2' type='text' name='rut' id='rut' value='$rut' required/></div>";
		echo "<input type='hidden' name='rut_init' value='$rut'/>";
		echo "<div class='col pt-2'>Ficha <input class='form-control mb-2' type='text' name='ficha' id='ficha' value='$ficha' required/></div>";
		echo "<div class='col pt-2'>De Alta <input class='form-check-input' type='checkbox' name='de_alta' id='de_alta' value='1' $de_alta/></div>";
		echo "<div class='col pt-3'><button type='submit' class='btn btn-app-primary' value'Submit'>OK</button></div></form></li></ul>";
	$i++;
	}

?>

				</div>
			</div>
			</div>
		</div>
	</div>
		</div>

	
<script>
$(document).ready(function () {
    $("#search").keyup(function () {
        let searchText = $(this).val().toLowerCase();

        // Itera a través de los campos de entrada cuyos IDs comienzan por "nombre_paciente"
        $("[id^='nombre_paciente']").each(function () {
            let fieldValue = $(this).val().toLowerCase();
            
            // Encuentra el elemento li padre
            let listItem = $(this).closest('li.list-group-item');

            // Comprueba si el valor del campo contiene el texto de búsqueda
            if (fieldValue.includes(searchText)) {
                listItem.show();
            } else {
                listItem.hide();
            }
        });
    });
});
</script>






<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

</body>
