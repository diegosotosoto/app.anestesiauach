<?php
//1 Validador login
	require("valida_pag.php");

//2 Variables
	$boton_toggler="<a class='navbar-toggler app-nav-toggle' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'><i class='fa-solid fa-bars'></i></a>";

 	$titulo_navbar="<div class='app-navbar-brand app-navbar-brand-compact'><img src='images/austral.png' alt='Universidad Austral de Chile' />Anestesia <small>UACh</small></div>";

	$boton_navbar="<a class='d-sm-block d-sm-none app-nav-action' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

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
				$creador=ucwords(strtolower(app_decode_text($_COOKIE['hkjh41lu4l1k23jhlkj14'])));


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
													  	<input type='hidden' name='reactivar' value='yes'>
													  	<input type='hidden' name='reactivar' value='yes'>

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
