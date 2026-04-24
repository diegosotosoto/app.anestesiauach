<?php
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
			header('Location: login.php');
		}

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	//chequea privilegios de administrador

	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `admin`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['admin']!=1){
		header('Location: login.php');
	  }


	  //Variables

		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión Pacientes</span>";
		$boton_navbar="<a></a><a></a>";

	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->

<?php



			//GUARDAR EDICIÓN DE USUARIO
				if($_POST['nombre_paciente']){

			$rut_pat=strtolower(htmlentities(addslashes(strtoupper($_POST['rut']))));				
			$nombre_pat=htmlentities(addslashes($_POST['nombre_paciente']));			
			$ficha_pat=htmlentities(addslashes($_POST['ficha']));
			$rut_init=htmlentities(addslashes($_POST['rut_init']));
			if($_POST['de_alta']=="1"){
				$de_alta_pat="1";
			}else{
				$de_alta_pat="0";
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




<div class='form-group text-center ms-3 pt-3 pb-3 mt-2'>
    <input type='text' class='form-control' style='width:90%' id='search' placeholder='Buscar un Nombre...'>
</div>
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


		echo "<ul class='list-group'><li class='list-group-item bg-secondary bg-gradient bg-opacity-10 ms-3 py-3 mb-2 ' style='font-size: min(max(14px, 1.5vw), 16px)'><form action='gestion_pacientes.php' method='post'>";
		echo "<div class='col pt-2'>Nombre Paciente<input class='form-control mb-2' type='text' name='nombre_paciente' id='nombre_paciente".$i."' value='$nombre_paciente' required/></div>";
		echo "<div class='col pt-2'>Rut <input class='form-control mb-2' type='text' name='rut' id='rut' value='$rut' required/></div>";
		echo "<input type='hidden' name='rut_init' value='$rut'/>";
		echo "<div class='col pt-2'>Ficha <input class='form-control mb-2' type='text' name='ficha' id='ficha' value='$ficha' required/></div>";
		echo "<div class='col pt-2'>De Alta <input class='form-check-input' type='checkbox' name='de_alta' id='de_alta' value='1' $de_alta/></div>";
		echo "<div class='col pt-3'><button type='submit' class='btn btn-primary' value'Submit'>OK</button></div></form></li></ul>";
	$i++;
	}

?>

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