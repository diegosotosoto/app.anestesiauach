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

<!-  NAVBAR  ->	

<form method='post' action='listar_visitas.php'>

	<?php
		$rut_v=htmlentities(addslashes($_POST['rut_v']));
		$fecha_v=htmlentities(addslashes($_POST['fecha_v']));

		$boton_toggler="<button class='btn btn-lg shadow-sm' type='submit' name='lista_v' value='$rut_v'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></button>";
		$titulo_navbar=" ";
		$boton_navbar="<a></a><a></a>";

		require("navbar.php");
	?>
<br><br>
<ul class="list-group">

	<?php
		$consulta_m="SELECT * FROM `visita_diaria` WHERE `rut_v` = '$rut_v' AND `fecha_v` = '$fecha_v' ";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_array();


		$phpdate1 = strtotime( $fila[3] );
		$fecha1 = date( 'd-m-y H:i', $phpdate1 );


		echo "<li class='list-group-item'><br><h5 class='mb-1 fw-bold'>$fila[1]</h5>";
		echo "<p class='mb-1'>$fila[2]</p></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Fecha</div><div>$fila[3]</div></div></li>";
		echo "<li class='list-group-item mb-2 py-3'><img class='btn-imagen' src='/images/IMG_3987.PNG'/>Exámen Físico</li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>EVA Estático</div><div>$fila[4]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>EVA Dinámico</div><div>$fila[5]</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Sedación</div><div>$fila[6]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Exámen Motor</div><div>$fila[7]</div></div></li>";	
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Bolos PCA: Solicitados / Administrados</div><div>$fila[8]</div></div></li>";
		echo "<li class='list-group-item mb-2 py-3'><img class='btn-imagen' src='/images/IMG_3992.PNG'/>Signos Vitales</li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>PAS</div><div>$fila[9] mmHg</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>PAD</div><div>$fila[10] mmHg</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>FC</div><div>$fila[11] x min</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>SaO2</div><div>$fila[12] %</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>FiO2</div><div>$fila[13] %</div></div></li>";
		echo "<li class='list-group-item mb-2 py-3'><img class='btn-imagen' src='/images/IMG_3990.PNG'/>Exámenes</li>";		
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Fecha Exámenes</div><div>$fila[14] </div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>INR</div><div>$fila[15]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>TTPA</div><div>$fila[16] seg</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Plaquetas</div><div>$fila[17] x10^3</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Creatinina</div><div>$fila[18] mg/dL</div></div></li>";
		echo "<li class='list-group-item mb-2 py-3'><img class='btn-imagen' src='/images/IMG_3981.PNG'/>Indicaciones Diarias</li>";			
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Anticoagulación</div><div>$fila[19]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>1.-</div><div>$fila[20]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>2.-</div><div>$fila[21]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>3.-</div><div>$fila[22]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>4.-</div><div>$fila[23]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>5.-</div><div>$fila[24]</div></div></li>";
		echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>6.-</div><div>$fila[25]</div></div></li>";
		echo "<li class='list-group-item mb-2 py-3'><img class='btn-imagen' src='/images/IMG_3977.PNG'/>Comentarios";				
		echo "<div class='py-2'>$fila[26]</div></div></li>";
		echo "<li class='list-group-item'><small class='text-muted'>Creado el $fecha1, por $fila[27]</small></li>";
		echo "<br>";
			
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
</form>
</body>
</html>
