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

		$boton_toggler="<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='; --bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
		$boton_navbar="<a></a><a></a>";

	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-8 col-xl-9"><!- Columna principal (derecha) responsive->

<?php 


			//GUARDAR EDICIÓN DE USUARIO
				if($_POST['nombre_usuario']){

			$email_init=strtolower(htmlentities(addslashes(strtoupper($_POST['email_init']))));				
			$nombre_us=htmlentities(addslashes($_POST['nombre_usuario']));			
			$email_us=htmlentities(addslashes($_POST['email_usuario']));
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

			$consulta_us="UPDATE `usuarios_dolor` SET `nombre_usuario`='$nombre_us', `email_usuario`='$email_us', `verified`='$verified_us', `admin`='$admin_us', `staff_`='$staff_us', `becad_`='$becad_us', `intern_`='$intern_us'  WHERE `email_usuario`='$email_init'";
			

			$escribir_us=$conexion->query($consulta_us);


			if($escribir_us==false){
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

?>








<div class='container text-center pt-5'>
		<div class='row'>
<?php 

	$con_users="SELECT `nombre_usuario`,`email_usuario`,`verified`,`admin`,`staff_`,`becad_`,`intern_`  FROM `usuarios_dolor`";

	$tab_users=$conexion->query($con_users);

	while($row_user=$tab_users->fetch_assoc()){

		$user=$row_user['nombre_usuario'];
		$email=$row_user['email_usuario'];

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

		if($row_user['intern_']=="1"){ 
			$intern="checked";
		}else {
			$intern="";
		}		
		echo "<form action='gestion_usuarios.php' method='post'>";
		echo "<div class='col'>Nombre Usuario<input class='form-control mb-2' type='text' name='nombre_usuario' id='nombre_usuario' value='$user' required/></div>";
		echo "<div class='col'>Email<input class='form-control mb-2' type='text' name='email_usuario' id='email_usuario' value='$email' required/></div>";
		echo "<div class='col'>Verificado <input class='form-check-input' type='checkbox' name='verified' id='verified' value='1' $verified/></div>";
		echo "<div class='col'>Administrador <input class='form-check-input' type='checkbox' name='admin' id='admin' value='1' $admin/></div>";
		echo "<div class='col'>Staff <input class='form-check-input' type='checkbox' name='staff' id='staff' value='1' $staff/></div>";
		echo "<div class='col'>Becad@ <input class='form-check-input' type='checkbox' name='becad' id='becad' value='1' $becad/></div>";
		echo "<div class='col'>Intern@ <input class='form-check-input' type='checkbox' name='intern' id='intern' value='1' $intern/></div>";		
		echo "</br><input type='hidden' name='email_init' value='$email'/>";
		echo "<div class='col'><button type='submit' value'Submit'>OK</button></div></form></div></br><hr></br><div class='row'>";

	}

?>
					</div>
			</div>			
		</div>


	





<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>
