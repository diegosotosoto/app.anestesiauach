<?php
	//Ve si están activas AMBAS cookies o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}elseif($_COOKIE['hkjh41lu4l1k23jhlkj13']!="diegosotosoto@gmail.com"){
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
			if($_POST['becad']=="1"){
				$becad_us="1";
			}else{
				$becad_us="0";
			}
			$consulta_us="UPDATE `usuarios_dolor` SET `nombre_usuario`='$nombre_us', `email_usuario`='$email_us', `verified`='$verified_us', `admin`='$admin_us', `becad_`='$becad_us' WHERE `email_usuario`='$email_init'";
			


			echo "<br><br><br>";

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




	<?php

		$boton_toggler="<a class='btn btn-lg shadow-sm border-light' style='; --bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Gestión";
		$boton_navbar="<a></a><a></a>";

		require("navbar.php");
	?>
<br><br><br>



<div class='container text-center'>
		<div class='row'>
<?php 

	$con_users="SELECT `nombre_usuario`,`email_usuario`,`verified`,`admin`,`becad_` FROM `usuarios_dolor`";

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
		if($row_user['becad_']=="1"){ 
			$becad="checked";
		}else {
			$becad="";
		}		
		echo "<form action='gestion_usuarios.php' method='post'>";
		echo "<div class='col'>Nombre Usuario<input class='form-control mb-2' type='text' name='nombre_usuario' id='nombre_usuario' value='$user' required/></div>";
		echo "<div class='col'>Email<input class='form-control mb-2' type='text' name='email_usuario' id='email_usuario' value='$email' required/></div>";
		echo "<div class='col'>Verificado <input class='form-check-input' type='checkbox' name='verified' id='verified' value='1' $verified/></div>";
		echo "<div class='col'>Administrador <input class='form-check-input' type='checkbox' name='admin' id='admin' value='1' $admin/></div>";
		echo "<div class='col'>Becad@ <input class='form-check-input' type='checkbox' name='becad' id='becad' value='1' $becad/></div>";
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

</body>