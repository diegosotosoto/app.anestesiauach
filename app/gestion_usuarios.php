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
		$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión Usuarios</span>";
		$boton_navbar="<a></a><a></a>";

	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->

<?php 


			//GUARDAR EDICIÓN DE USUARIO
				if($_POST['nombre_usuario']){

			$email_init=strtolower(htmlentities(addslashes(strtoupper($_POST['email_init']))));				
			$nombre_us=htmlentities(addslashes($_POST['nombre_usuario']));			
			$email_us=htmlentities(addslashes($_POST['email_usuario']));
			$link_minicex=htmlentities(addslashes($_POST['link_minicex']));
			if($_POST['verified']=="1"){
				$verified_us="1";
			}else{
				$verified_us="0";
			}

			if($_POST['admin']=="1"){
				$admin_us="1";
			}else{
				$admin_us="0";
			}

			if($_POST['staff']=="1"){
				$staff_us="1";
			}else{
				$staff_us="0";
			}			

			if($_POST['becad']=="1"){
				$becad_us="1";
			}else{
				$becad_us="0";
			}

			if($_POST['intern']=="1"){
				$intern_us="1";
			}else{
				$intern_us="0";
			}

			if($_POST['becad_otro']=="1"){
				$becad_otro_us="1";
			}else{
				$becad_otro_us="0";
			}			

			$consulta_us="UPDATE `usuarios_dolor` SET `nombre_usuario`='$nombre_us', `email_usuario`='$email_us', `verified`='$verified_us', `admin`='$admin_us', `staff_`='$staff_us', `becad_`='$becad_us', `becad_otro`='$becad_otro_us', `intern_`='$intern_us', `link_minicex`='$link_minicex'   WHERE `email_usuario`='$email_init'";
			

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
						    <strong>Info!</strong> Registro Guardado.
						  	</div>
				";

			} 
		}

?>







<div class='form-group text-center ms-3 pt-3 pb-3 mt-2'>
    <input type='text' class='form-control' style='width:90%' id='search' placeholder='Buscar un Nombre o Correo...'>
</div>
<div class='pt-2 pb-4' id='mytable'>

		<div class='row'>
<?php 
$i=0;
	$con_users="SELECT `nombre_usuario`,`email_usuario`,`verified`,`admin`,`staff_`,`becad_`,`intern_`,`becad_otro`, `link_minicex`  FROM `usuarios_dolor` ORDER BY `verified` ASC, `nombre_usuario` ASC";

	$tab_users=$conexion->query($con_users);

	while($row_user=$tab_users->fetch_assoc()){

		$user=$row_user['nombre_usuario'];
		$email=$row_user['email_usuario'];

		$link_minicex=$row_user['link_minicex'];

		if($row_user['verified']=="1"){ 
			$verified="checked";
		}else {
			$verified="";
		}

		if($row_user['admin']=="1"){ 
			$admin="checked";
		}else {
			$admin="";
		}

		if($row_user['staff_']=="1"){ 
			$staff="checked";
		}else {
			$staff="";
		}
		if($row_user['becad_']=="1"){ 
			$becad="checked";
		}else {
			$becad="";
		}

		if($row_user['becad_otro']=="1"){ 
			$becad_otro="checked";
		}else {
			$becad_otro="";
		}
		if($row_user['intern_']=="1"){ 
			$intern="checked";
		}else {
			$intern="";
		}

		echo "<ul class='list-group'><li class='list-group-item ms-3 py-3 mb-2 bg-secondary bg-gradient bg-opacity-10' style='font-size: min(max(14px, 1.5vw), 16px)'><form action='gestion_usuarios.php' method='post'>";
		echo "<div class='col'>Nombre Usuario<input class='form-control mb-2' type='text' name='nombre_usuario' id='nombre_usuario".$i."' value='$user' required/></div>";
		echo "<div class='col'>Email<input class='form-control mb-2' type='text' name='email_usuario' id='email_usuario".$i."' value='$email' required/></div>";

		if ($row_user['becad_']=="1"){

			echo "<div class='col'>Link Minicex<input class='form-control mb-2' type='text' name='link_minicex' id='link_minicex".$i."' value='$link_minicex'/></div>";

			}


		echo "<div class='col'>Verificado <input class='form-check-input' type='checkbox' name='verified' id='verified' value='1' $verified/></div>";
		echo "<div class='col'>Administrador <input class='form-check-input' type='checkbox' name='admin' id='admin' value='1' $admin/></div>";
		echo "<div class='col'>Staff <input class='form-check-input' type='checkbox' name='staff' id='staff' value='1' $staff/></div>";
		echo "<div class='col'>Becad@ Anestesia<input class='form-check-input' type='checkbox' name='becad' id='becad' value='1' $becad/></div>";
		echo "<div class='col'>Intern@ <input class='form-check-input' type='checkbox' name='intern' id='intern' value='1' $intern/></div>";
		echo "<div class='col'>Becad@ Pasante <input class='form-check-input' type='checkbox' name='becad_otro' id='becad_otro' value='1' $becad_otro/></div>";		
		echo "</br><input type='hidden' name='email_init' value='$email'/>";
		echo "<div class='col'><button class='btn btn-primary' type='submit' value'Submit'>OK</button></div></form></li></ul>";
	$i++;

	}

?>
					
    <!-- Tu tabla y contenido aquí -->
</div>
					</div>
			</div>			
		</div>


<script>
$(document).ready(function () {
    $("#search").keyup(function () {
        let searchText = $(this).val().toLowerCase();

        // Itera a través de los elementos con la estructura <ul><div><form>
        $("ul.list-group > li.list-group-item > form").each(function () {
            let fieldValue = $(this).find("[id^='email_usuario'], [id^='nombre_usuario']").val().toLowerCase();

            // Comprueba si el valor del campo contiene el texto de búsqueda
            if (fieldValue.includes(searchText)) {
                // Muestra el contenedor de la fila (por ejemplo, el div con clase 'list-group-item' en tu estructura)
                $(this).closest('.list-group-item').show();
            } else {
                // Oculta el contenedor de la fila
                $(this).closest('.list-group-item').hide();
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
