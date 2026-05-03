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

			$boton_toggler="<form method='post' action='listar_visitas.php'><button class='d-sm-block d-sm-none admin-back-btn' type='submit' name='lista_v' value='$rut_v'><i class='fa fa-chevron-left'></i>Atrás</button></form>";
			$titulo_navbar=" ";
			$boton_navbar="<form method='post' action='https://anestesiauach.cl/pdf/generar_pdf.php' target='_blank');'><input type='hidden' name='fecha_v' value='$fecha_v'><button class='btn btn-app-primary navbar-save-btn' type='submit' name='rut_v' value='$rut_v' aria-label='Exportar PDF'><i class='fa-solid fa-file-pdf'></i></button></form>";

	//Carga Head de la página
	require("head.php");

?>

	<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
	<div class="apunte-surface">
	<div class="container-fluid px-0 px-md-2">
	<div class="pain-shell">


<div class="patient-summary-stack">

	<?php
	
		$consulta_m="SELECT * FROM `visita_diaria` WHERE `rut_v` = '$rut_v' AND `fecha_v` = '$fecha_v' ";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_assoc();

		$phpdate1 = strtotime( $fila['fecha_v'] );
		$fecha1 = date( 'd-m-y H:i', $phpdate1 );
		$consulta_fc="SELECT `ficha` FROM `pacientes` WHERE `rut` = '$rut_v'";
		$busqueda_fc=$conexion->query($consulta_fc);
		$fc=$busqueda_fc->fetch_assoc();

		$string_rut = $fila['rut_v'];
		$parts = explode("-", $string_rut);
		$result_rut = $parts[0];

		function visit_detail_has_value($value){
			return trim((string)$value) !== '';
		}

		function visit_detail_render_item($label, $value, $suffix = ''){
			$value = trim((string)$value);
			if($value === ''){
				return;
			}
			echo "<div class='bitacora-item'><div class='bitacora-item-label'>".app_h_text($label)."</div><div class='bitacora-item-value'>".app_h_text($value.$suffix)."</div></div>";
		}

		function visit_detail_section($title, $items){
			$has_values = false;
			foreach($items as $item){
				if(visit_detail_has_value($item[1])){
					$has_values = true;
					break;
				}
			}
			if(!$has_values){
				return;
			}
			echo "<div class='bitacora-feedback-label pt-3'>".app_h_text($title)."</div>";
			echo "<div class='bitacora-grid'>";
			foreach($items as $item){
				$suffix = isset($item[2]) ? $item[2] : '';
				visit_detail_render_item($item[0], $item[1], $suffix);
			}
			echo "</div>";
		}

		echo "<section class='bitacora-entry-card'>";
		echo "<div class='bitacora-entry-header'>";
		echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
		echo "<div><div class='small text-muted'>Evolución diaria</div><h5 class='mb-1'>".app_h_text($fila['nombre_paciente_v'])."</h5></div>";
		echo "<div class='text-md-end'><div>".app_h_text($fecha1)."</div>";
		if(visit_detail_has_value($fila['rut_v'])){
			echo "<div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/0/".app_h_text($result_rut)."' target='_blank'>".app_h_text($fila['rut_v'])."</a></div>";
		}
		if(isset($fc['ficha']) && visit_detail_has_value($fc['ficha'])){
			echo "<div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/1/".app_h_text($fc['ficha'])."' target='_blank'>".app_h_text($fc['ficha'])."</a></div>";
		}
		echo "</div></div>";
		echo "<div class='pain-actions d-none d-sm-flex pt-3'>";
		echo "<form method='post' action='listar_visitas.php'><button class='admin-back-btn' type='submit' name='lista_v' value='".app_h_text($rut_v)."'><i class='fa fa-chevron-left'></i>Atrás</button></form>";
		echo "<form method='post' action='https://anestesiauach.cl/pdf/generar_pdf.php' target='_blank');'><input type='hidden' name='fecha_v' value='".app_h_text($fecha_v)."'><button class='btn btn-app-primary pain-action-btn' type='submit' name='rut_v' value='".app_h_text($rut_v)."' aria-label='Exportar PDF'><i class='fa-solid fa-file-pdf'></i></button></form>";
		echo "</div></div>";
		echo "<div class='bitacora-entry-body'>";
		visit_detail_section('Examen físico', [
			['EVA estático', $fila['eva_estatico']],
			['EVA dinámico', $fila['eva_dinamico']],
			['Sedación', $fila['sedacion']],
			['Examen motor', $fila['motor']],
			['Bolos PCA: solicitados / administrados', $fila['bolos']],
		]);
		visit_detail_section('Signos vitales', [
			['PAS', $fila['pas'], ' mmHg'],
			['PAD', $fila['pad'], ' mmHg'],
			['FC', $fila['fc'], ' x min'],
			['SaO2', $fila['sao2'], ' %'],
			['FiO2', $fila['fio2'], ' %'],
		]);
		visit_detail_section('Exámenes', [
			['Fecha exámenes', $fila['fecha_exs']],
			['INR', $fila['inr']],
			['TTPA', $fila['ttpa'], ' seg'],
			['Plaquetas', $fila['plaq'], ' x10^3'],
			['Creatinina', $fila['crea'], ' mg/dL'],
		]);
		visit_detail_section('Indicaciones diarias', [
			['Anticoagulación', $fila['anticoagulante']],
			['1', $fila['indic1']],
			['2', $fila['indic2']],
			['3', $fila['indic3']],
			['4', $fila['indic4']],
			['5', $fila['indic5']],
			['6', $fila['indic6']],
		]);
		if(visit_detail_has_value($fila['comentarios_v'])){
			echo "<div class='bitacora-feedback-label pt-3'>Plan / Comentarios</div>";
			echo "<div class='bitacora-comments'>".app_h_text($fila['comentarios_v'])."</div>";
		}
		echo "<div class='small text-muted pt-3'>Creado el ".app_h_text($fecha1);
		if(visit_detail_has_value($fila['editor_v'])){
			echo ", por ".app_h_text($fila['editor_v']);
		}
		echo "</div></div></section>";
			
	?>

</div>
	</div>
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
