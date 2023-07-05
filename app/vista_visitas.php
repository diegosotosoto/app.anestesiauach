<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("../app/conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	

//Saca a los internos y otros becados del area de dolor
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`, `becad_otro`   FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1){
	  	header('Location: login.php');
	  }


?>

<!-  NAVBAR  ->	

	<?php
		$rut_v=htmlentities(addslashes($_POST['rut_v']));
		$fecha_v=htmlentities(addslashes($_POST['fecha_v']));

		$boton_toggler="<form method='post' action='listar_visitas.php'><button class='btn d-sm-block d-sm-none shadow-sm border-light' style='; --bs-border-opacity: .1;' type='submit' name='lista_v' value='$rut_v'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></button></form>";
		$titulo_navbar=" ";
		$boton_navbar="<form method='post' action='https://anestesiauach.cl/pdf/generar_pdf.php' target='_blank');'><input type='hidden' name='fecha_v' value='$fecha_v'><button class='btn shadow-sm border-light' style='width:60px; --bs-border-opacity: .1;' type='submit' name='rut_v' value='$rut_v'><div class='text-white'><i class='fa-solid fa-file-pdf'></i></div></button></form>";

	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->


<div class="row text-center ps-2">


<ul class="list-group">

	<?php
	
		$consulta_m="SELECT * FROM `visita_diaria` WHERE `rut_v` = '$rut_v' AND `fecha_v` = '$fecha_v' ";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_assoc();

		$phpdate1 = strtotime( $fila['fecha_v'] );
		$fecha1 = date( 'd-m-y H:i', $phpdate1 );




		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><br><h5 class='mb-1 fw-bold'>".$fila['nombre_paciente_v']."</h5>";


		//BOTON A LA IZQUIERDA DEL TITULO class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<form method='post' action='listar_visitas.php'><button class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;' type='submit' name='lista_v' value='$rut_v'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></button></form>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 pe-3 me-2 d-flex float-end'>
		<form method='post' action='https://anestesiauach.cl/pdf/generar_pdf.php' target='_blank');'><input type='hidden' name='fecha_v' value='$fecha_v'><button class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' style='width:60px; --bs-border-opacity: .1;' type='submit' name='rut_v' value='$rut_v'><div class='text-white'><i class='fa-solid fa-file-pdf'></i></div></button></form>
		</div>";


		//SUBTITULO
		echo "<p class='mb-1'>".$fila['rut_v']."</p></li>";
		echo "<div class='mb-1'></div></li>";




		echo "<li class='list-group-item py-3' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='images/IMG_3987.PNG'/>Exámen Físico</li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>EVA Estático</div><div>".$fila['eva_estatico']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>EVA Dinámico</div><div>".$fila['eva_dinamico']."</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Sedación</div><div>".$fila['sedacion']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Exámen Motor</div><div>".$fila['motor']."</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Bolos PCA: Solicitados / Administrados</div><div>".$fila['bolos']."</div></div></li>";

		echo "<li class='list-group-item py-3' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='images/IMG_3992.PNG'/>Signos Vitales</li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>PAS</div><div>".$fila['pas']." mmHg</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>PAD</div><div>".$fila['pad']." mmHg</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>FC</div><div>".$fila['fc']." x min</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>SaO2</div><div>".$fila['sao2']." %</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>FiO2</div><div>".$fila['fio2']." %</div></div></li>";

		echo "<li class='list-group-item py-3' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='images/IMG_3990.PNG'/>Exámenes</li>";		
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Fecha Exámenes</div><div>".$fila['fecha_exs']." </div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>INR</div><div>".$fila['inr']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>TTPA</div><div>".$fila['ttpa']." seg</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Plaquetas</div><div>".$fila['plaq']." x10^3</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Creatinina</div><div>".$fila['crea']." mg/dL</div></div></li>";

		echo "<li class='list-group-item py-3' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='images/IMG_3981.PNG'/>Indicaciones Diarias</li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Anticoagulación</div><div>".$fila['anticoagulante']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>1.-</div><div>".$fila['indic1']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>2.-</div><div>".$fila['indic2']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>3.-</div><div>".$fila['indic3']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>4.-</div><div>".$fila['indic4']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>5.-</div><div>".$fila['indic5']."</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>6.-</div><div>".$fila['indic6']."</div></div></li>";

		echo "<li class='list-group-item py-3' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><img class='btn-imagen' src='images/IMG_3977.PNG'/>Plan / Comentarios"."</li>";				
		echo "<li class='list-group-item'><div class='py-2'>".$fila['comentarios_v']."</div></li>";
		echo "<li class='list-group-item'><small class='text-muted'>Creado el $fecha1, por ".$fila['editor_v']."</small></li>";
		echo "<br>";
			
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


