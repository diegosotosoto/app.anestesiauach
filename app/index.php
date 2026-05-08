<?php
//1 Validador login
	require("valida_pag.php");

//2 Variables
	$boton_toggler="<a class='navbar-toggler app-nav-toggle' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'><i class='fa-solid fa-bars'></i></a>";

 	$titulo_navbar="<div class='app-navbar-brand app-navbar-brand-compact'><img src='images/austral.png' alt='Universidad Austral de Chile' />Anestesia <small>UACh</small></div>";

	$boton_navbar="<a class='d-sm-block d-sm-none app-nav-action' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

// Función para crear notificación de pacientes en Dolor
function crearNotificacionPacientesDolor($conexion, $usuario_id, $usuario_email) {
    // Obtener todos los pacientes activos con sus días
    $sql_pacientes = "SELECT nombre_paciente, rut, fecha_creacion
                      FROM pacientes
                      WHERE de_alta = 0
                        AND fecha_creacion >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                      ORDER BY fecha_creacion DESC";

    $stmt = $conexion->prepare($sql_pacientes);
    if (!$stmt) return false;

    $stmt->execute();
    $pacientes = [];
    $dias_pacientes = [];

    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $pacientes[] = $row;
        }
    } else {
        $stmt->bind_result($nombre_tmp, $rut_tmp, $fecha_tmp);
        while ($stmt->fetch()) {
            $pacientes[] = [
                'nombre_paciente' => $nombre_tmp,
                'rut' => $rut_tmp,
                'fecha_creacion' => $fecha_tmp
            ];
        }
    }
    $stmt->close();

    // Calcular días para cada paciente
    foreach ($pacientes as $paciente) {
        $fecha_creacion = new DateTime($paciente['fecha_creacion']);
        $fecha_actual = new DateTime();
        $diferencia = $fecha_creacion->diff($fecha_actual);
        $dias = $diferencia->days;
        if ($dias > 0) {
            $dias_pacientes[] = $dias;
        }
    }

    if (empty($dias_pacientes)) return false;

    $total_pacientes = count($dias_pacientes);
    sort($dias_pacientes);
    $dias_texto = implode(', ', $dias_pacientes);
    $mensaje = "Ingresaste {$total_pacientes} paciente(s) en Dolor hace {$dias_texto} día(s).";

    // Verificar si ya existe una notificación similar hoy para este usuario
    $sql_check = "SELECT n.id
                  FROM notificaciones n
                  INNER JOIN notificacion_destinatarios nd ON n.id = nd.notificacion_id
                  WHERE nd.usuario_id = ?
                    AND n.titulo = 'Pacientes en Dolor'
                    AND DATE(n.fecha_inicio) = CURDATE()
                    AND nd.archivada = 0";

    $stmt_check = $conexion->prepare($sql_check);
    if (!$stmt_check) return false;

    $stmt_check->bind_param("i", $usuario_id);
    $stmt_check->execute();

    $existe = false;
    if (method_exists($stmt_check, 'get_result')) {
        $res_check = $stmt_check->get_result();
        if ($res_check->fetch_assoc()) {
            $existe = true;
        }
    } else {
        $stmt_check->bind_result($id_tmp);
        if ($stmt_check->fetch()) {
            $existe = true;
        }
    }
    $stmt_check->close();

    if ($existe) return false; // Ya existe notificación hoy

    // Crear nueva notificación
    $titulo = "Pacientes en Dolor";
    $tipo = "info";
    $alcance = "individual";
    $url_destino = "hoja_dolor.php";
    $icono = "fa-solid fa-syringe";
    $fecha_inicio = date('Y-m-d H:i:s');
    $fecha_fin = null;
    $publicada = 1;

    $stmt_notif = $conexion->prepare("
        INSERT INTO `notificaciones`
        (`titulo`,`mensaje`,`tipo`,`alcance`,`grupo_destino`,`url_destino`,`icono`,`creada_por`,`publicada`,`fecha_inicio`,`fecha_fin`)
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?)
    ");

    if (!$stmt_notif) return false;

    $stmt_notif->bind_param(
        "sssssssiiss",
        $titulo,
        $mensaje,
        $tipo,
        $alcance,
        null,
        $url_destino,
        $icono,
        $usuario_id,
        $publicada,
        $fecha_inicio,
        $fecha_fin
    );

    if (!$stmt_notif->execute()) {
        $stmt_notif->close();
        return false;
    }

    $notificacion_id = $stmt_notif->insert_id;
    $stmt_notif->close();

    // Asignar notificación al usuario
    $stmt_dest = $conexion->prepare("
        INSERT INTO `notificacion_destinatarios` (`notificacion_id`,`usuario_id`)
        VALUES (?,?)
    ");

    if (!$stmt_dest) return false;

    $stmt_dest->bind_param("ii", $notificacion_id, $usuario_id);
    $stmt_dest->execute();
    $stmt_dest->close();

    return true;
}

//3 Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="content-shell">

		<?php 
					//GUARDAR PACIENTE NUEVO

			if($_POST['nombre_paciente']){
				$nombre_paciente=htmlentities(addslashes($_POST['nombre_paciente']));
				$rut=htmlentities(addslashes(strtoupper($_POST['rut'])));
				$ficha=htmlentities(addslashes($_POST['ficha']));
				$unidad_cama=htmlentities(addslashes($_POST['unidad_cama']));
				$procedimiento=htmlentities(addslashes($_POST['procedimiento']));
				$analgesia=htmlentities(addslashes($_POST['analgesia']));
				$nivel=htmlentities(addslashes($_POST['nivel']));
				$espacio=htmlentities(addslashes($_POST['espacio']));
				$distancia=htmlentities(addslashes($_POST['distancia']));
				$solucion=htmlentities(addslashes($_POST['solucion']));
				$infusion=htmlentities(addslashes($_POST['infusion']));
				$bolo=htmlentities(addslashes($_POST['bolo']));
				$lockout=htmlentities(addslashes($_POST['lockout']));
				$peso=htmlentities(addslashes($_POST['peso']));
				$comentarios=htmlentities(addslashes($_POST['comentarios']));
				$de_alta=0;
				$fecha_creacion=date("Y-m-d H:i:s",strtotime('-4 hour'));
				$creador=ucwords(strtolower(app_decode_text($app_current_user['nombre_usuario'])));


				//PRIMERO BUSCA SI EL RUT EXISTE PREVIAMENTE Y ESTA ACTIVO
				$consulta_conf="SELECT `rut`, `nombre_paciente`,`ficha` FROM `pacientes` WHERE `rut`='$rut' AND `de_alta` = '0'";

				$confirmar=$conexion->query($consulta_conf); 

				if(mysqli_num_rows($confirmar)==0){

				//SEGUNDO BUSCA SI EL RUT EXISTE PREVIAMENTE Y ESTA DADO DE ALTA
						$consulta_conf_2="SELECT `rut`, `nombre_paciente`,`ficha` FROM `pacientes` WHERE `rut`='$rut' AND `de_alta` = '1'";

						$confirmar_2=$conexion->query($consulta_conf_2); 

						if(mysqli_num_rows($confirmar_2)==0){

									$consulta_n="INSERT INTO `pacientes` (`nombre_paciente`, `rut`, `ficha`, `unidad_cama`, `procedimiento`, `analgesia`, `nivel`, `espacio`, `distancia`, `solucion`, `infusion`, `bolo`, `lockout`, `peso`, `comentarios`, `de_alta`, `fecha_creacion`, `creador`) VALUES ('$nombre_paciente', '$rut', '$ficha', '$unidad_cama', '$procedimiento', '$analgesia', '$nivel', '$espacio', '$distancia', '$solucion', '$infusion', '$bolo', '$lockout', '$peso', '$comentarios', '$de_alta', '$fecha_creacion', '$creador') ";

										$escribir=$conexion->query($consulta_n);


										if($escribir==false){
											echo "
															<div class='alert alert-danger alert-dismissible fade show'>
														    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
														    <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
														  	</div>
											";

										}else{//NO EXISTE PREVIAMENTE NI FUE DADO DE ALTA
										    // Crear notificación con todos los pacientes ingresados y sus días
										    crearNotificacionPacientesDolor($conexion, $app_current_user['ID'], $app_current_user['email_usuario']);

													echo "</br>
															<div class='alert alert-success alert-dismissible fade show'>
														    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
														    <strong>Info!</strong> Registro Guardado.
														  	</div>
											";
										}

						}else{ // EXISTE Y SE ENCUENTRA DADO DE ALTA

									$datos_alta=$confirmar_2->fetch_assoc();

									echo "
													<div class='alert alert-warning alert-dismissible fade show'>
													    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
													    <strong>Info!</strong> Este Rut ya se encuentra en la base de datos, EN ESTADO DADO DE ALTA.</br>
													    Nombre: ".$datos_alta['nombre_paciente']."</br> Rut: ".$datos_alta['rut']."</br> Ficha: ".$datos_alta['ficha']."
													  	</br>Desea Reactivar?
													  	</br>
													  	<form action='editar_paciente.php' method='post'>
													  	<input type='hidden' name='reactivar' value='yes'>
													  	<input type='hidden' name='rut_reactivar' value='".$datos_alta['rut']."'>
													  	<input type='hidden' name='crear_notificacion_dolor' value='1'>

														  	<button class='btn btn-app-primary' type='submit' name='editar' value='".$datos_alta['rut']."'>Reactivar</button></form>
													  	</div>
									";   ////******   al enviar formulario debe editar al paciente sacarlo del alta y agregar los datos nuevos, excepto la ficha y nombre

						}


				}else{ // EXISTE Y SE ENCUENTRA ACTIVO
							echo "
									<div class='alert alert-danger alert-dismissible fade show'>
									    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
									    <strong>Info!</strong> Este Rut ya se encuentra ACTIVO en la base de datos.
									  	</div>
							";
				}
			}

  ?>


    <section class="app-hero app-hero-blue mt-md-3">
      <div class="app-hero-row">
        <div class="app-hero-body">
          <div class="app-hero-kicker">APP clínica • acceso rápido</div>
          <h2>Panel principal</h2>
          <p>Accesos directos a las herramientas clínicas, docentes y administrativas de la app.</p>
        </div>
      </div>
    </section>
        <div class="links-grid home-grid">

<?php
//Saca a los internos y otros becados del area de dolor  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
  $con_users_b="SELECT `intern_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
  $users_b=$conexion->query($con_users_b);
  $usuario=$users_b->fetch_assoc();

  if(!($usuario['intern_']==1 or $usuario['becad_otro']==1)){
    echo "
      <a href='hoja_dolor.php' class='link-tile home-tile home-tile-dolor'>
        <i class='fa-solid fa-syringe fa-2x mb-2'></i>
        <div class='link-title'>Pacientes Dolor</div>
        <div class='link-desc'>Registro y seguimiento clínico.</div>
      </a>
    ";
  }
  ?>


      <a href='links.php' class='link-tile home-tile home-tile-links'>
        <i class="fa-solid fa-link fa-2x mb-2"></i>
        <div class='link-title'>Links Útiles</div>
        <div class='link-desc'>Recursos externos clínicos y académicos.</div>
      </a>  

          <a href="bitacora.php" class="link-tile home-tile home-tile-bitacora">
            <i class="fa-solid fa-clipboard fa-2x mb-2"></i>
            <div class="link-title">Bitácora Procedimientos</div>
            <div class="link-desc">Registro docente y validación.</div>
          </a>

          <a href="apuntes.php" class="link-tile home-tile home-tile-apuntes">
            <i class="fa-solid fa-calculator fa-2x mb-2"></i>
            <div class="link-title">Cálculos y Apuntes</div>
            <div class="link-desc">Herramientas rápidas de consulta.</div>
          </a>

          <a href="telefonos.php" class="link-tile home-tile home-tile-telefonos">
            <i class="fa-solid fa-phone fa-2x mb-2"></i>
            <div class="link-title">Teléfonos Frecuentes</div>
            <div class="link-desc">Números clínicos y de apoyo.</div>
          </a>

          <a href="correos.php" class="link-tile home-tile home-tile-correos">
            <i class="fa-solid fa-envelope fa-2x mb-2"></i>
            <div class="link-title">Directorio Correos</div>
            <div class="link-desc">Correos del equipo y residentes.</div>
          </a>

          <a href="vista_epa.php" class="link-tile home-tile home-tile-epa">
            <i class="fa-solid fa-clipboard fa-2x mb-2"></i>
            <div class="link-title">Evaluación Preanestésica</div>
            <div class="link-desc">Versión beta para evaluación clínica.</div>
          </a>

          <a href="https://uachcl-my.sharepoint.com/:f:/r/personal/docentes_anestesia_uach_cl/Documents/Reuniones%20Clinicas?e=5%3a1d4a50a99f8747659eaf40e9bd942188&sharingv2=true&fromShare=true&at=9" target="_blank" class="link-tile home-tile home-tile-reuniones">
            <i class="fa-solid fa-chalkboard-user fa-2x mb-2"></i>
            <div class="link-title">Reuniones Clínicas</div>
            <div class="link-desc">Acceso a material compartido.</div>
          </a>

        </div>

      </div>
    </div>
  </div>
</div>

<?php 
  $conexion->close();
  require("footer.php");
?>
