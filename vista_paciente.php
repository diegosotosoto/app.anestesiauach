<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
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
<br><br>
<!-  GUARDAR REGISTROS  ->	

		<?php 
		//Guardar Edición de paciente
		if($_POST['vista']){ //NO HACE NADA PORQUE SI ESTÁ 'VISTA' SE PRESIONO CANCELAR
		}else{

			if($_POST['rut_e']){

			$rut_e=htmlentities(addslashes(strtoupper($_POST['rut_e'])));			
			$ficha_e=htmlentities(addslashes($_POST['ficha_e']));
			$unidad_cama_e=htmlentities(addslashes($_POST['unidad_cama_e']));
			$procedimiento_e=htmlentities(addslashes($_POST['procedimiento_e']));
			$analgesia_e=htmlentities(addslashes($_POST['analgesia_e']));
			$nivel_e=htmlentities(addslashes($_POST['nivel_e']));
			$espacio_e=htmlentities(addslashes($_POST['espacio_e']));
			$distancia_e=htmlentities(addslashes($_POST['distancia_e']));
			$solucion_e=htmlentities(addslashes($_POST['solucion_e']));
			$infusion_e=htmlentities(addslashes($_POST['infusion_e']));
			$bolo_e=htmlentities(addslashes($_POST['bolo_e']));
			$lockout_e=htmlentities(addslashes($_POST['lockout_e']));
			$peso_e=htmlentities(addslashes($_POST['peso_e']));
			$comentarios_e=htmlentities(addslashes($_POST['comentarios_e']));
			$fecha_edicion_e=date("Y-m-d H:i:s");
			$editor_e=ucwords(strtolower($_COOKIE['hkjh41lu4l1k23jhlkj14']));
			if($_POST['de_alta_e']=="1"){
				$de_alta_e="1";
			}else{
				$de_alta_e="0";
			}

			$consulta_e="UPDATE `pacientes` SET `ficha`='$ficha_e', `unidad_cama`='$unidad_cama_e', `procedimiento`='$procedimiento_e', `analgesia`='$analgesia_e', `nivel`='$nivel_e', `espacio`='$espacio_e', `distancia`='$distancia_e', `solucion`='$solucion_e', `infusion`='$infusion_e', `bolo`='$bolo_e', `lockout`='$lockout_e', `peso`='$peso_e', `comentarios`='$comentarios_e', `de_alta`='$de_alta_e', `fecha_edicion`='$fecha_edicion_e', `editor`='$editor_e' WHERE `rut`='$rut_e' AND `de_alta`='0' ";
			
			$escribir=$conexion->query($consulta_e);


			if($escribir==false){
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

		}


		//GUARDAR NUEVA VISITA
		if($_POST['vista']){ //NO HACE NADA PORQUE SI ESTÁ 'VISTA' SE PRESIONO CANCELAR
			}else{

				if($_POST['rut_v']){
					$nombre_paciente_v=htmlentities(addslashes($_POST['nombre_paciente_v']));
					$rut_v=htmlentities(addslashes(strtoupper($_POST['rut_v'])));
					$fecha_v=date("Y-m-d H:i:s");
					$eva_estatico=htmlentities(addslashes($_POST['eva_estatico']));
					$eva_dinamico=htmlentities(addslashes($_POST['eva_dinamico']));
					$sedacion=htmlentities(addslashes($_POST['sedacion']));
					$motor=htmlentities(addslashes($_POST['motor']));
					$bolos=htmlentities(addslashes($_POST['bolos']));
					$pas=htmlentities(addslashes($_POST['pas']));
					$pad=htmlentities(addslashes($_POST['pad']));
					$fc=htmlentities(addslashes($_POST['fc']));
					$sao2=htmlentities(addslashes($_POST['sao2']));
					$fio2=htmlentities(addslashes($_POST['fio2']));
					$fecha_exs=htmlentities(addslashes($_POST['fecha_exs']));
					$inr=htmlentities(addslashes($_POST['inr']));
					$ttpa=htmlentities(addslashes($_POST['ttpa']));
					$plaq=htmlentities(addslashes($_POST['plaq']));
					$crea=htmlentities(addslashes($_POST['crea']));
					$anticoagulante=htmlentities(addslashes($_POST['anticoagulante']));
					$indic1=htmlentities(addslashes($_POST['indic1']));
					$indic2=htmlentities(addslashes($_POST['indic2']));
					$indic3=htmlentities(addslashes($_POST['indic3']));
					$indic4=htmlentities(addslashes($_POST['indic4']));
					$indic5=htmlentities(addslashes($_POST['indic5']));
					$indic6=htmlentities(addslashes($_POST['indic6']));
					$comentarios_v=htmlentities(addslashes($_POST['comentarios_v']));
					$editor_v=ucwords(strtolower($_COOKIE['hkjh41lu4l1k23jhlkj14']));

					$consulta_v="INSERT INTO `visita_diaria` (`nombre_paciente_v`, `rut_v`, `fecha_v`, `eva_estatico`, `eva_dinamico`, `sedacion`, `motor`, `bolos`, `pas`, `pad`, `fc`, `sao2`, `fio2`, `fecha_exs`, `inr`, `ttpa`, `plaq`, `crea`, `anticoagulante`, `indic1`, `indic2`, `indic3`, `indic4`, `indic5`, `indic6`, `comentarios_v`, `editor_v`) VALUES ('$nombre_paciente_v', '$rut_v', '$fecha_v', '$eva_estatico', '$eva_dinamico', '$sedacion', '$motor', '$bolos', '$pas', '$pad', '$fc', '$sao2', '$fio2', '$fecha_exs', '$inr', '$ttpa', '$plaq', '$crea',  '$anticoagulante', '$indic1', '$indic2', '$indic3', '$indic4', '$indic5', '$indic6', '$comentarios_v', '$editor_v');";

					$escribir=$conexion->query($consulta_v);



					if($escribir==false){
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
			}

	?>



<!-  NAVBAR  ->	


	<?php
		if($_POST['vista']){
			$formulario=htmlentities(addslashes($_POST['vista']));
		}elseif($_POST['rut_v']){
			$formulario=htmlentities(addslashes($_POST['rut_v']));
		}elseif($_POST['rut_e']){
			$formulario=htmlentities(addslashes($_POST['rut_e']));
		}


		$consulta_m="SELECT * FROM `pacientes` WHERE `rut` = '$formulario' AND `de_alta`='0' ";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_row();

		$boton_toggler="<a class='btn btn-lg shadow-sm' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$boton_navbar="<form action='editar_paciente.php' method='post'><button class='btn btn-lg shadow-sm' type='submit' name='editar' value='$fila[2]' /><i class='fa fa-pencil fa-lg' style='color:white' aria-hidden='true'></i></button></form>";


		require("navbar.php");

	?>



<ul class="list-group">

	<?php

		$phpdate1 = strtotime( $fila[17] );
		$fecha1 = date( 'd-m-y H:i', $phpdate1 );

		if(isset($fila[19])){
			$phpdate2 = strtotime( $fila[19] );
			$fecha2 = date( 'd-m-y H:i', $phpdate2 );
		}
		
		echo "<li class='list-group-item'><br><h5 class='mb-1 fw-bold'>$fila[1]</h5>";
		echo "<p class='mb-1'>$fila[2]</p></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Ficha Clínica</div><div>$fila[3]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Unidad/Cama</div><div>$fila[4]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Procedimiento</div><div>$fila[5]</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Analgesia</div><div>$fila[6]</div></div></li>";

			if($fila[6]=="Peridural"){
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Nivel</div><div>$fila[7]</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Distancia Espacio Epidural</div><div>$fila[8] cm</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Distancia Catéter</div><div>$fila[9] cm</div></div></li>";
			}

		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Solución</div><div>$fila[10]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Infusión PCA</div><div>$fila[11] ml/hr</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Bolo PCA</div><div>$fila[12] ml</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Lockout PCA</div><div>$fila[13] min</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Peso</div><div>$fila[14] kg</div></div></li>";

		echo "<li class='list-group-item mb-2 py-3'><img class='btn-imagen' src='/images/IMG_3977.PNG'/>Comentarios";				
		echo "<div class='py-2'>$fila[15]</div></div></li>";

		echo "<li class='list-group-item mb-2 py-3'><div><img class='btn-imagen' src='/images/IMG_3978.PNG'/>EVOLUCIONES DIARIAS</div></div>";
			

		$consulta_elementos="SELECT `rut_v` FROM `visita_diaria` WHERE `rut_v`='$formulario'";
		$confirmar_e=$conexion->query($consulta_elementos);
		$elementos=mysqli_num_rows($confirmar_e);
		

		if($elementos>0){
				echo "<div class='py-2'><form action='listar_visitas.php' method='post'><button class='btn btn-lg' type='submit' name='lista_v' value='$formulario' >$elementos elementos</button></form></div></div></li>";	
		}else{
			echo "<div class='py-2'><button class='btn btn-lg'>$elementos elementos</button></div></div></li>";	
		}

	

		echo "<li class='list-group-item'><div><form action='nueva_visita.php' method='post'><button class='btn btn-primary btn-lg' type='submit' name='visita' value='$formulario' ><img class='btn-imagen' src='/images/IMG_3981.PNG'/>Nueva Evolución Diaria</button></form></li>";

		echo "<li class='list-group-item'><small class='text-muted'>Creado el $fecha1, por $fila[18]</small></li>";
		if(isset($fila[19])){
			echo "<li class='list-group-item'><small class='text-muted'>Editado el $fecha2, por $fila[20]</small></li>";
		}



	?>

</ul>
<br>
<br>
	<?php 
		//Cierre Conexión
		$conexion->close();
	?>

<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

</body>
</html>
