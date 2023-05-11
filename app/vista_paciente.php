<?php

//1 Validador login
	require("valida_pag.php");
	

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

//Saca a los internos del area de dolor
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1){
	  	header('Location: login.php');
	  }


	
//Variable
		if($_POST['vista']){
			$formulario=htmlentities(addslashes($_POST['vista']));
		}elseif($_POST['rut_v']){
			$formulario=htmlentities(addslashes($_POST['rut_v']));
		}elseif($_POST['rut_e']){
			$formulario=htmlentities(addslashes($_POST['rut_e']));
		}

		//Conexión
		  require("conectar.php");
		  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
		  $conexion->set_charset("utf8");
  
		$consulta_m="SELECT * FROM `pacientes` WHERE `rut` = '$formulario'";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_assoc();

    	$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='hoja_dolor.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$boton_navbar="<form action='editar_paciente.php' method='post'><button class='d-sm-block d-sm-none btn btn-md shadow-sm border-light' style='; --bs-border-opacity: .1;'  type='submit' name='editar' value='".$fila['rut']."'/><i class='fa-solid fa-pen fa-lg' style='color:white' aria-hidden='true'></i></button></form>";


	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->
<div class="row text-center ps-2">


<!-  GUARDAR REGISTROS  ->	

		<?php 
		//Guardar Edición de paciente
		if($_POST['vista']){ //NO HACE NADA PORQUE SI ESTÁ 'VISTA' SE PRESIONO CANCELAR
		}else{

			if($_POST['rut_e']){

			$rut_e=htmlentities(addslashes(strtoupper($_POST['rut_e'])));
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
			$fecha_edicion_e=date("Y-m-d H:i:s",strtotime('-4 hour'));
			$editor_e=ucwords(strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj14'])));


			if($_POST['de_alta_e']=="on"){
						
				$de_alta_e="1";
			}else{
				$de_alta_e="0";
			}

			$consulta_e="UPDATE `pacientes` SET `unidad_cama`='$unidad_cama_e', `procedimiento`='$procedimiento_e', `analgesia`='$analgesia_e', `nivel`='$nivel_e', `espacio`='$espacio_e', `distancia`='$distancia_e', `solucion`='$solucion_e', `infusion`='$infusion_e', `bolo`='$bolo_e', `lockout`='$lockout_e', `peso`='$peso_e', `comentarios`='$comentarios_e', `de_alta`='$de_alta_e', `fecha_edicion`='$fecha_edicion_e', `editor`='$editor_e' WHERE `rut`='$rut_e'";
			
			$escribir=$conexion->query($consulta_e);


			if($escribir==false){
				echo "
							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
						  	</div>
				";

			}else{

				echo "		</br>
							<div class='alert alert-success alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Registro Guardado.</div>
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
					$fecha_v=date("Y-m-d H:i:s",strtotime('-4 hour'));
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
					$editor_v=ucwords(strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj14'])));

					$consulta_v="INSERT INTO `visita_diaria` (`nombre_paciente_v`, `rut_v`, `fecha_v`, `eva_estatico`, `eva_dinamico`, `sedacion`, `motor`, `bolos`, `pas`, `pad`, `fc`, `sao2`, `fio2`, `fecha_exs`, `inr`, `ttpa`, `plaq`, `crea`, `anticoagulante`, `indic1`, `indic2`, `indic3`, `indic4`, `indic5`, `indic6`, `comentarios_v`, `editor_v`) VALUES ('$nombre_paciente_v', '$rut_v', '$fecha_v', '$eva_estatico', '$eva_dinamico', '$sedacion', '$motor', '$bolos', '$pas', '$pad', '$fc', '$sao2', '$fio2', '$fecha_exs', '$inr', '$ttpa', '$plaq', '$crea',  '$anticoagulante', '$indic1', '$indic2', '$indic3', '$indic4', '$indic5', '$indic6', '$comentarios_v', '$editor_v');";

					$escribir=$conexion->query($consulta_v);



					if($escribir==false){
						echo "
							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
						  	</div>
						";

					}else{

						echo "</br>
							<div class='alert alert-success alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Registro Guardado.
						  	</div>
						";

						}
				}
			}

	?>

<ul class="list-group">

	<?php
		$consulta_m="SELECT * FROM `pacientes` WHERE `rut` = '$formulario'";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_assoc();

		$phpdate1 = strtotime( $fila['fecha_creacion'] );
		$fecha1 = date( 'd-m-y H:i', $phpdate1 );

		if(isset($fila['fecha_edicion'])){
			$phpdate2 = strtotime( $fila['fecha_edicion'] );
			$fecha2 = date( 'd-m-y H:i', $phpdate2 );
		}
		


		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold'>".$fila['nombre_paciente']."</h5>		

		<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' href='hoja_dolor.php'><i class='fa fa-chevron-left'></i>Atrás</a>
		</div>

		<span class='float-end'>
		<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
		<form action='editar_paciente.php' method='post'><button class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;'  type='submit' name='editar' value='".$fila['rut']."'/><i class='fa-solid fa-pen fa-lg' style='color:white' aria-hidden='true'></i></button></form>
		</div>
		</span>";
		



		
		echo "<p class='mb-1'>Rut:&nbsp;".$fila['rut']."</p>";
		echo "<p class='mb-1'>FC:&nbsp;".$fila['ficha']."</p>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Unidad&nbsp&nbsp</div><div class='text-end'>".$fila['unidad_cama']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Procedimiento</div><div>".$fila['procedimiento']."</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Analgesia</div><div>".$fila['analgesia']."</div></div></li>";

			if($fila['analgesia']=="Peridural"){
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Nivel</div><div>".$fila['nivel']."</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Distancia Espacio Epidural</div><div>".$fila['espacio']." cm</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Distancia Catéter</div><div>".$fila['distancia']." cm</div></div></li>";
			}

		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Solución</div><div>".$fila['solucion']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Infusión PCA</div><div>".$fila['infusion']." ml/hr</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Bolo PCA</div><div>".$fila['bolo']." ml</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Lockout PCA</div><div>".$fila['lockout']." min</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Peso</div><div>".$fila['peso']." kg</div></div></li>";

		echo "<li class='list-group-item mb-2 py-3'><img class='btn-imagen' src='images/IMG_3977.PNG'/>Comentarios";				
		echo "<div class='py-2'>".$fila['comentarios']."</div></div></li>";

		echo "<li class='list-group-item mb-2 py-3'><div><img class='btn-imagen' src='images/IMG_3978.PNG'/>EVOLUCIONES DIARIAS</div>";
			

		$consulta_elementos="SELECT `rut_v` FROM `visita_diaria` WHERE `rut_v`='$formulario'";
		$confirmar_e=$conexion->query($consulta_elementos);
		$elementos=mysqli_num_rows($confirmar_e);
		

		if($elementos>0){
				echo "<div class='py-2'><form action='listar_visitas.php' method='post'><button class='btn btn-light btn-lg shadow-sm' type='submit' name='lista_v' value='$formulario' >$elementos elementos</button></form></div></li>";	
		}else{
			echo "<div class='py-2'><button class='btn btn-light btn-lg shadow-sm'>$elementos elementos</button></div></></li>";	
		}

	

		echo "<li class='list-group-item'><div><form action='nueva_visita.php' method='post'><button class='btn btn-primary btn-lg' type='submit' name='visita' value='$formulario' ><img class='btn-imagen' src='images/IMG_3981.PNG'/>Nueva Evolución Diaria</button></form></li>";

		echo "<li class='list-group-item'><small class='text-muted'>Creado el $fecha1, por ".$fila['creador']."</small></li>";
		if(isset($fila['fecha_edicion'])){
			echo "<li class='list-group-item pb-5'><small class='text-muted'>Editado el $fecha2, por ".$fila['editor']."</small></li>";
		}



	?>

</ul>
</div>
</div>
	<?php 
		//Cierre Conexión
		$conexion->close();
	?>

<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

