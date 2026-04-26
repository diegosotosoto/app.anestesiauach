<?php
//1 Validador login
	require("valida_pag.php");

//2 Variables
	$boton_toggler="<a class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></a>";

 	$titulo_navbar="<div class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></div>";

	$boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

//3 Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">

        <div class="apuntes-hero mt-2 mt-md-3">
          <div class="small opacity-75 mb-1">APP clínica • acceso rápido</div>
          <div class="apuntes-hero-title">Panel principal</div>
          <div class="apuntes-hero-subtitle">Accesos directos a las herramientas clínicas, docentes y administrativas de la app.</div>
        </div>

        <div class="links-grid">

          <a href='links.php' class='link-tile' style='background-image:linear-gradient(145deg,#0a7d3d 0%,#18b565 55%,#7fe0b0 100%); color:#ffffff;'>
            <i class="fa-solid fa-link fa-2x mb-2"></i>
            <div class='link-title text-white'>Links Útiles</div>
            <div class='link-desc text-white-50'>Recursos externos clínicos y académicos.</div>
          </a>

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

													  	<button class='btn shadow-sm' type='submit' name='editar' value='".$datos_alta['rut']."' />Reactivar!</button></form>
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

//Saca a los internos y otros becados del area de dolor  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
  $con_users_b="SELECT `intern_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
  $users_b=$conexion->query($con_users_b);
  $usuario=$users_b->fetch_assoc();

  if(!($usuario['intern_']==1 or $usuario['becad_otro']==1)){
    echo "
      <a href='hoja_dolor.php' class='link-tile' style='background-image:linear-gradient(145deg,#0f63d8 0%,#2d7fe0 55%,#7fb3f2 100%); color:#ffffff;'>
        <i class='fa-solid fa-syringe fa-2x mb-2'></i>
        <div class='link-title text-white'>Pacientes Dolor</div>
        <div class='link-desc text-white-50'>Registro y seguimiento clínico.</div>
      </a>
    ";
  }
  ?>

          <a href="bitacora.php" class="link-tile" style="background-image:linear-gradient(145deg,#c82333 0%,#e03a48 55%,#f29aa2 100%); color:#ffffff;">
            <i class="fa-solid fa-clipboard fa-2x mb-2"></i>
            <div class="link-title text-white">Bitácora Procedimientos</div>
            <div class="link-desc text-white-50">Registro docente y validación.</div>
          </a>

          <a href="apuntes.php" class="link-tile" style="background-image:linear-gradient(145deg,#e69500 0%,#f2b632 55%,#f5e3a3 100%); color:#ffffff;">
            <i class="fa-solid fa-calculator fa-2x mb-2"></i>
            <div class="link-title text-white">Cálculos y Apuntes</div>
            <div class="link-desc text-white-50">Herramientas rápidas de consulta.</div>
          </a>

          <a href="telefonos.php" class="link-tile" style="background-image:linear-gradient(145deg,#5b00b3 0%,#7d2ae8 55%,#c3a5f5 100%); color:#ffffff;">
            <i class="fa-solid fa-phone fa-2x mb-2"></i>
            <div class="link-title text-white">Teléfonos Frecuentes</div>
            <div class="link-desc text-white-50">Números clínicos y de apoyo.</div>
          </a>

          <a href="correos.php" class="link-tile" style="background-image:linear-gradient(145deg,#1f8a8c 0%,#4fb3b5 55%,#bfe4e5 100%); color:#ffffff;">
            <i class="fa-solid fa-envelope fa-2x mb-2"></i>
            <div class="link-title text-white">Directorio Correos</div>
            <div class="link-desc text-white-50">Correos del equipo y residentes.</div>
          </a>

          <a href="vista_epa.php" class="link-tile" style="background-image:linear-gradient(145deg,#d94c00 0%,#f57a2a 55%,#ffd3b0 100%); color:#ffffff;">
            <i class="fa-solid fa-clipboard fa-2x mb-2"></i>
            <div class="link-title text-white">Evaluación Preanestésica</div>
            <div class="link-desc text-white-50">Versión beta para evaluación clínica.</div>
          </a>

          <a href="https://uachcl-my.sharepoint.com/:f:/r/personal/docentes_anestesia_uach_cl/Documents/Reuniones%20Clinicas?e=5%3a1d4a50a99f8747659eaf40e9bd942188&sharingv2=true&fromShare=true&at=9" target="_blank" class="link-tile" style="background-image:linear-gradient(145deg,#9e0059 0%,#c2187a 55%,#e5a3c6 100%); color:#ffffff;">
            <i class="fa-solid fa-chalkboard-user fa-2x mb-2"></i>
            <div class="link-title text-white">Reuniones Clínicas</div>
            <div class="link-desc text-white-50">Acceso a material compartido.</div>
          </a>

        </div>

      </div>
    </div>
  </div>
</div>

<style>
  .apuntes-hero{
    background: linear-gradient(135deg, var(--app-navy), #3559b7);
    color: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
    padding: 1.15rem 1.25rem;
    margin-top: 0;
    margin-bottom: 1.35rem;
  }

  .apuntes-hero-title{
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.2;
  }

  .apuntes-hero-subtitle{
    color: rgba(255,255,255,.75);
    margin-top: .35rem;
  }

  .links-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:16px;
    padding-bottom: 2rem;
  }

  .link-tile{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    min-height:164px;
    padding:18px 14px;
    border-radius:18px;
    text-decoration:none;
    border:0;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
    transition:.15s;
  }

  .link-tile:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 26px rgba(0,0,0,.12);
    color:#ffffff;
  }

  .link-title{
    font-weight:700;
    font-size:.98rem;
    line-height:1.25;
  }

  .link-desc{
    font-size:.82rem;
    margin-top:6px;
    line-height:1.35;
    max-width:22ch;
  }

  @media (min-width:768px){
    .links-grid{
      grid-template-columns:repeat(3,1fr);
    }
  }

  @media (min-width:1200px){
    .links-grid{
      grid-template-columns:repeat(4,1fr);
    }
  }


</style>

<?php 
  $conexion->close();
  require("footer.php");
?>
