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
<br><br><br>
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
				echo "Error en la consulta";

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




	<?php

		$boton_toggler="<a class='btn btn-lg shadow-sm' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Pacientes";
		$boton_navbar="<a></a><a></a>";

		require("navbar.php");
	?>



<div class='container text-center'>
		<div class='row'>
<?php 

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


		echo "<form action='gestion_pacientes.php' method='post'>";
		echo "<div class='col pt-2'>Nombre Paciente<input class='form-control mb-2' type='text' name='nombre_paciente' id='nombre_paciente' value='$nombre_paciente' required/></div>";
		echo "<div class='col pt-2'>Rut <input class='form-control mb-2' type='text' name='rut' id='rut' value='$rut' required/></div>";
		echo "<input type='hidden' name='rut_init' value='$rut'/>";
		echo "<div class='col pt-2'>Ficha <input class='form-control mb-2' type='text' name='ficha' id='ficha' value='$ficha' required/></div>";
		echo "<div class='col pt-2'>De Alta <input class='form-check-input' type='checkbox' name='de_alta' id='de_alta' value='1' $de_alta/></div>";
		echo "<div class='col pt-3'><button type='submit' class='btn btn-primary' value'Submit'>OK</button></div></form></div></br><hr></br><div class='row'>";

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