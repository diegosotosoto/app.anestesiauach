<?php

//1 Validador login
	require("valida_pag.php");
	

	//Conexión
	require("conectar.php");
	require_once __DIR__ . '/app_security.php';
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

//Saca a los internos, otros becados y usuarios externos del area de dolor
	  $usuario = app_current_user($conexion);
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1 or $usuario['external_']==1){
	  	header('Location: index.php');
	  }



	 
//Variable
		if($_POST['vista']){
			$formulario=htmlentities(addslashes($_POST['vista']));
		}elseif($_POST['rut_v']){
			$formulario=htmlentities(addslashes($_POST['rut_v']));
		}elseif($_POST['rut_e']){
			$formulario=htmlentities(addslashes($_POST['rut_e']));
		}elseif(isset($_GET['rut'])){
			$formulario=htmlentities(addslashes(strtoupper($_GET['rut'])));
		}

		//Conexión
		  require("conectar.php");
		  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
		  $conexion->set_charset("utf8");
  
		$consulta_m="SELECT * FROM `pacientes` WHERE `rut` = '$formulario'";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_assoc();

    	$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='hoja_dolor.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$boton_navbar="<form action='editar_paciente.php' method='post'><button class='d-sm-block d-sm-none app-nav-action' type='submit' name='editar' value='".$fila['rut']."' aria-label='Editar paciente'><i class='fa-solid fa-pen fa-lg' aria-hidden='true'></i></button></form>";


	//Carga Head de la página
	require("head.php");

?>

	<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
	<div class="apunte-surface">
	<div class="container-fluid px-0 px-md-2">
	<div class="pain-shell">


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
			$editor_e=ucwords(strtolower(app_decode_text($app_current_user['nombre_usuario'])));


			if($_POST['de_alta_e']=="on"){

			// Dar de alta: copiar a pacientes_alta y borrar de pacientes
			$fecha_alta_e = date("Y-m-d H:i:s", strtotime('-4 hour'));
			$consulta_copia = "INSERT INTO `pacientes_alta`
				(`nombre_paciente`,`rut`,`ficha`,`edad`,`unidad_cama`,`procedimiento`,`analgesia`,`nivel`,`espacio`,`distancia`,`solucion`,`infusion`,`bolo`,`lockout`,`peso`,`comentarios`,`fecha_creacion`,`creador`,`fecha_edicion`,`editor`,`fecha_alta`)
				SELECT `nombre_paciente`,`rut`,`ficha`,`edad`,`unidad_cama`,`procedimiento`,`analgesia`,`nivel`,`espacio`,`distancia`,`solucion`,`infusion`,`bolo`,`lockout`,`peso`,`comentarios`,`fecha_creacion`,`creador`,'$fecha_edicion_e','$editor_e','$fecha_alta_e'
				FROM `pacientes` WHERE `rut`='$rut_e'";
			$conexion->query($consulta_copia);
			$consulta_e = "DELETE FROM `pacientes` WHERE `rut`='$rut_e'";

		} else {
			// Edición normal: solo UPDATE
			$consulta_e = "UPDATE `pacientes` SET `unidad_cama`='$unidad_cama_e', `procedimiento`='$procedimiento_e', `analgesia`='$analgesia_e', `nivel`='$nivel_e', `espacio`='$espacio_e', `distancia`='$distancia_e', `solucion`='$solucion_e', `infusion`='$infusion_e', `bolo`='$bolo_e', `lockout`='$lockout_e', `peso`='$peso_e', `comentarios`='$comentarios_e', `fecha_edicion`='$fecha_edicion_e', `editor`='$editor_e' WHERE `rut`='$rut_e'";
		}

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
					$editor_v=ucwords(strtolower(app_decode_text($app_current_user['nombre_usuario'] ?? '')));

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

	<div class="patient-summary-stack">

		<?php
			$consulta_m="SELECT * FROM `pacientes` WHERE `rut` = '$formulario'";
			$busqueda2=$conexion->query($consulta_m);
			$fila=$busqueda2->fetch_assoc();

			$phpdate1 = strtotime( $fila['fecha_creacion'] );
			$fecha1 = date( 'd-m-y H:i', $phpdate1 );

			if(isset($fila['fecha_edicion']) && trim((string)$fila['fecha_edicion']) !== ''){
				$phpdate2 = strtotime( $fila['fecha_edicion'] );
				$fecha2 = date( 'd-m-y H:i', $phpdate2 );
			}

			function patient_summary_has_value($value){
				return trim((string)$value) !== '';
			}

			function patient_summary_render_item($label, $value, $suffix = ''){
				$value = trim((string)$value);
				if($value === ''){
					return;
				}
				echo "<div class='bitacora-item'><div class='bitacora-item-label'>".app_h_text($label)."</div><div class='bitacora-item-value'>".app_h_text($value.$suffix)."</div></div>";
			}

			$string_rut = $fila['rut'];
			$parts = explode("-", $string_rut);
			$result_rut = $parts[0];

			echo "<section class='bitacora-entry-card'>";
			echo "<div class='bitacora-entry-header'>";
			echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
			echo "<div><div class='small text-muted'>Paciente</div><h5 class='mb-1'>".app_h_text($fila['nombre_paciente'])."</h5></div>";
			echo "<div class='text-md-end'>";
			if(patient_summary_has_value($fecha1)){
				echo "<div>".app_h_text($fecha1)."</div>";
			}
			if(patient_summary_has_value($fila['rut'])){
				echo "<div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/0/".app_h_text($result_rut)."' target='_blank'>".app_h_text($fila['rut'])."</a></div>";
			}
			if(patient_summary_has_value($fila['ficha'])){
				echo "<div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/1/".app_h_text($fila['ficha'])."' target='_blank'>".app_h_text($fila['ficha'])."</a></div>";
			}
			echo "</div></div>";
			echo "<div class='pain-actions pt-3'>";
			echo "<form action='editar_paciente.php' method='post'><button class='btn btn-app-primary pain-action-btn' type='submit' name='editar' value='".app_h_text($fila['rut'])."' aria-label='Editar paciente'><i class='fa-solid fa-pen fa-lg' aria-hidden='true'></i></button></form>";
			echo "</div>";
			echo "</div>";

			echo "<div class='bitacora-entry-body'><div class='bitacora-grid'>";
			patient_summary_render_item('Unidad', $fila['unidad_cama']);
			patient_summary_render_item('Procedimiento', $fila['procedimiento']);
			patient_summary_render_item('Analgesia', $fila['analgesia']);
			if($fila['analgesia']=="Peridural"){
				patient_summary_render_item('Nivel', $fila['nivel']);
				patient_summary_render_item('Distancia Espacio Epidural', $fila['espacio'], ' cm');
				patient_summary_render_item('Distancia Catéter', $fila['distancia'], ' cm');
			}
			patient_summary_render_item('Solución', $fila['solucion']);
			patient_summary_render_item('Infusión PCA', $fila['infusion'], ' ml/hr');
			patient_summary_render_item('Bolo PCA', $fila['bolo'], ' ml');
			patient_summary_render_item('Lockout PCA', $fila['lockout'], ' min');
			patient_summary_render_item('Peso', $fila['peso'], ' kg');
			echo "</div>";

			if(patient_summary_has_value($fila['comentarios'])){
				echo "<div class='bitacora-feedback-label pt-3'>Comentarios</div>";
				echo "<div class='bitacora-comments'>".app_h_text($fila['comentarios'])."</div>";
			}

			echo "<div class='small text-muted pt-3'>Creado el ".app_h_text($fecha1);
			if(patient_summary_has_value($fila['creador'])){
				echo ", por ".app_h_text($fila['creador']);
			}
			echo "</div>";
			if(isset($fecha2)){
				echo "<div class='small text-muted pt-1'>Editado el ".app_h_text($fecha2);
				if(patient_summary_has_value($fila['editor'])){
					echo ", por ".app_h_text($fila['editor']);
				}
				echo "</div>";
			}
			echo "</div></section>";

			$consulta_elementos="SELECT `rut_v` FROM `visita_diaria` WHERE `rut_v`='$formulario' AND `fecha_v` >= '{$fila['fecha_creacion']}'";
			$confirmar_e=$conexion->query($consulta_elementos);
			$elementos=mysqli_num_rows($confirmar_e);

			echo "<section class='pain-card'>";
			echo "<div class='pain-card-header'><div><h3>Evoluciones diarias</h3><p>".app_h_text($elementos)." elemento(s) registrados</p></div></div>";
			echo "<div class='pain-actions'>";
			if($elementos>0){
				echo "<form action='listar_visitas.php' method='post'><input type='hidden' name='fecha_ingreso' value='".app_h_text($fila['fecha_creacion'])."'><button class='btn btn-app-secondary pain-action-btn' type='submit' name='lista_v' value='".app_h_text($formulario)."'>Ver evoluciones</button></form>";
			}else{
				echo "<button class='btn btn-app-secondary pain-action-btn' type='button' disabled>Sin evoluciones</button>";
			}
			echo "<form action='nueva_visita.php' method='post'><button class='btn btn-app-primary pain-action-btn' type='submit' name='visita' value='".app_h_text($formulario)."'><i class='fa fa-plus fa-lg' aria-hidden='true'></i>Nueva Evolución Diaria</button></form>";
			echo "</div></section>";

			// Antecedentes: ingresos previos en pacientes_alta
			$consulta_prev = "SELECT `fecha_creacion`, `fecha_alta`, `procedimiento`, `analgesia`, `solucion` FROM `pacientes_alta` WHERE `rut`='$formulario' ORDER BY `fecha_alta` DESC";
			$res_prev = $conexion->query($consulta_prev);
			if ($res_prev && $res_prev->num_rows > 0) {
				$card_s  = "style='border:1px solid var(--app-border,#dee2e6);border-radius:.5rem;padding:.6rem .75rem;background:var(--app-card,#fff)'";
				$cell    = "style='background:var(--app-bg,#f8f9fa);border:1px solid var(--app-border,#dee2e6);border-radius:.4rem;padding:.35rem .6rem'";
				$lbl     = "style='font-size:.68rem;text-transform:uppercase;letter-spacing:.04em;color:var(--app-muted,#6c757d);margin-bottom:.1rem'";
				$val     = "style='font-size:.82rem;color:var(--app-text,#495057)'";
				echo "<section class='pain-card' style='background:var(--app-bg,#f5f5f5);border:1px solid var(--app-border,#dee2e6);opacity:.9'>";
				echo "<div class='pain-card-header' style='border-bottom:1px solid var(--app-border,#dee2e6)'><div>";
				echo "<h3 style='font-size:1rem;color:var(--app-muted,#6c757d);margin:0'>Ingresos Previos</h3>";
				echo "</div></div>";
				echo "<div class='bitacora-entry-body' style='display:flex;flex-direction:column;gap:1.2rem'>";
				while ($prev = $res_prev->fetch_assoc()) {
					$f_ing = $prev['fecha_creacion'] ? date('d-m-Y', strtotime($prev['fecha_creacion'])) : '—';
					$f_alt = $prev['fecha_alta']      ? date('d-m-Y', strtotime($prev['fecha_alta']))      : '—';
					$proc  = trim((string)$prev['procedimiento']);
					$analg = trim((string)$prev['analgesia']);
					$sol   = trim((string)$prev['solucion']);
					echo "<div $card_s>";
					// Subtítulo: fechas de ingreso y alta
					echo "<div style='font-size:.78rem;color:var(--app-muted,#6c757d);margin-bottom:.5rem;padding-bottom:.4rem;border-bottom:1px solid var(--app-border,#dee2e6);text-transform:uppercase;letter-spacing:.03em'>";
					echo "INGRESO: ".app_h_text($f_ing)."  /  ALTA: ".app_h_text($f_alt);
					echo "</div>";
					// Fila 2: Procedimiento (ancho completo)
					if ($proc !== '') {
						echo "<div style='margin-bottom:.4rem'><div $cell><div $lbl>Procedimiento</div><div $val>".app_h_text($proc)."</div></div></div>";
					}
					// Fila 3: Analgesia + Solución
					if ($analg !== '' || $sol !== '') {
						echo "<div style='display:grid;grid-template-columns:1fr 1fr;gap:.4rem .75rem;margin-bottom:.4rem'>";
						echo "<div $cell><div $lbl>Analgesia</div><div $val>".($analg !== '' ? app_h_text($analg) : '—')."</div></div>";
						echo "<div $cell><div $lbl>Solución</div><div $val>".($sol !== '' ? app_h_text($sol) : '—')."</div></div>";
						echo "</div>";
					}
					// Evoluciones del episodio previo
					$fc_ing = $prev['fecha_creacion'] ?? '1970-01-01 00:00:00';
					$fc_alt = $prev['fecha_alta']      ?? date('Y-m-d H:i:s');
					$stmt_ev = $conexion->prepare("SELECT `fecha_v`,`eva_estatico`,`eva_dinamico`,`sedacion`,`motor`,`editor_v` FROM `visita_diaria` WHERE `rut_v`=? AND `fecha_v` BETWEEN ? AND ? ORDER BY `fecha_v` ASC");
					$stmt_ev->bind_param("sss", $formulario, $fc_ing, $fc_alt);
					$stmt_ev->execute();
					$res_ev = $stmt_ev->get_result();
					$n_ev = $res_ev ? $res_ev->num_rows : 0;
						echo "<div style='border-top:1px solid var(--app-border,#dee2e6);margin-top:.5rem;padding-top:.5rem;display:flex;flex-direction:column;gap:.4rem'>";
					if ($n_ev > 0) {
						echo "<div style='font-size:.75rem;color:var(--app-muted,#6c757d);margin-bottom:.2rem;text-transform:uppercase;letter-spacing:.03em'>Evoluciones diarias</div>";
						$idx = 0;
						while ($ev = $res_ev->fetch_assoc()) {
							$idx++;
							$ev_id = 'ev_' . md5($fc_ing . $fc_alt . $ev['fecha_v']) . '_' . $idx;
							$fev     = $ev['fecha_v'] ? date('d-m-Y H:i', strtotime($ev['fecha_v'])) : '—';
							$ev_est  = trim((string)$ev['eva_estatico']);
							$ev_din  = trim((string)$ev['eva_dinamico']);
							$ev_sed  = trim((string)$ev['sedacion']);
							$ev_mot  = trim((string)$ev['motor']);
							$ev_edit = trim((string)$ev['editor_v']);
							echo "<button type='button'
								onclick=\"var d=document.getElementById('{$ev_id}');var o=d.style.display==='block';d.style.display=o?'none':'block';this.querySelector('i').className=o?'fa fa-chevron-right':'fa fa-chevron-down';\"
								style='text-align:left;background:var(--app-bg,#f8f9fa);border:1px solid var(--app-border,#dee2e6);border-radius:.4rem;padding:.4rem .6rem;font-size:.82rem;color:var(--app-text,#495057);cursor:pointer;display:flex;align-items:center;gap:.4rem'>
								<i class='fa fa-chevron-right' style='font-size:.65rem;color:var(--app-muted,#6c757d)'></i>
								<span>".app_h_text($fev).($ev_edit !== '' ? " &middot; ".app_h_text($ev_edit) : '')."</span>
							</button>";
							echo "<div id='{$ev_id}' style='display:none;padding:.4rem 0 .6rem .8rem;font-size:.79rem'>";
							echo "<div style='display:grid;grid-template-columns:1fr 1fr;gap:.3rem .5rem'>";
							if ($ev_est !== '') echo "<div $cell><div $lbl>EVA estático</div><div $val>".app_h_text($ev_est)."</div></div>";
							if ($ev_din !== '') echo "<div $cell><div $lbl>EVA dinámico</div><div $val>".app_h_text($ev_din)."</div></div>";
							if ($ev_sed !== '') echo "<div $cell><div $lbl>Sedación</div><div $val>".app_h_text($ev_sed)."</div></div>";
							if ($ev_mot !== '') echo "<div $cell><div $lbl>Motor</div><div $val>".app_h_text($ev_mot)."</div></div>";
							echo "</div>";
							echo "</div>";
						}
					} else {
						echo "<span style='font-size:.79rem;color:var(--app-muted,#6c757d)'>Sin evoluciones registradas</span>";
					}
					echo "</div>";
					$stmt_ev->close();
					echo "</div>";
				}
				echo "</div></section>";
			}
		?>

	</div>
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
