<?php  //Conexión
  require("conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#3587ff">
	<meta http-equiv="Cache-control" content="no-cache">
	<title>App Anestesia UACH</title>
	<link rel="icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="manifest" href="manifest.json"/>
	<link rel="apple-touch-icon" href="images/logo192.png"/>	
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="css/all.css"/>
	<link rel="stylesheet" href="style.css"/>
	<script src="js/jquery-3.6.1.min.js"></script>

<body>
<div class="container-xxl text-center px-0">
  <div class="row px-0 mx-0 ">
    <div class="col-sm col-sm-3 col-xl-3 px-0" style="background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 100px, #44B2FF 100%);"> 
    <nav class="navbar navbar-expand-sm">

        <div class="container-fluid">
          <span class="ps-1"><?php if($boton_toggler){echo $boton_toggler;} ?></span>


        <a class="navbar-brand d-sm-block d-sm-none" href="#">
          <?php if($titulo_navbar){echo $titulo_navbar;} ?>
		    </a>


        <a class="d-sm-block d-sm-none pe-1" href="#">
		    <?php if($boton_navbar){echo $boton_navbar;} ?>
		  	</a>

    <div class="offcanvas offcanvas-start px-0 mx-0 bg-sidebar" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    	<div class="mh-100">
	      <div class="offcanvas-header">
	        <h5 class="offcanvas-title ps-4" id="offcanvasNavbarLabel"></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	      </div>

      <div class="offcanvas-body">
          	<div class="container text-center">
							<div class="row ps-1 pt-3 pb-3">
	                <a class="navbar-brand d-xs-none d-none d-sm-block" href="#"><img src="images/austral_b.png" style="width: 30% ;"></a>
	            </div>
									<div class='list-group' id='offcanvasExampleLabel'>
									<?php

										//Ve si está activa la cookie o redirige al login
										  if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
											       echo "

											        	<div class='list-group-item list-group-item-action fs-5'>
												        	<h6><i class='fs-2 fa-solid fa-user-doctor ps-2 pe-3 text-success'></i>".urldecode($_COOKIE['hkjh41lu4l1k23jhlkj14'])."</h6>


													        <div class='text-black-50 text-break' style='font-size: 12px'>
													          	".$_COOKIE['hkjh41lu4l1k23jhlkj13']."	
													        </div></div>
													    ";} else {


													    	echo "<div class='list-group'>
																		  <a href='login.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-right-to-bracket ps-2 pe-3 fs-3' style='color: #44B2FF'></i>Login</a>
																		</div>";
													    }
										?>

<hr class='pt-0'>

	      	<ul class='list-group pt-2'>

						<div class='list-group'>
						  <a href='index.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-house ps-2 pe-3 fs-3' style='color: #44B2FF'></i>Inicio</a> 
						</div>

				<?php
				//BUSCA SI EL USUARIO ESTÁ REGISTRADO Y AGREGA MENÚ DE REGISTRADOS
				if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){


					//Genera las badges si es staff o admin
				  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
				  $nombre_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj14'];
				  $con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
				  $users_b=$conexion->query($con_users_b);
				  $usuario=$users_b->fetch_assoc();
				  if($usuario['admin']==1 or $usuario['staff_']==1){
				      
				              $query_badge="SELECT `staff_b` FROM `bitacora_proced` WHERE `staff_b` = '$nombre_usuario' AND `aprobado_staff_b` = '0' ";
        							$consutal_badge=$conexion->query($query_badge);
        							$badge = mysqli_num_rows($consutal_badge);
        							$escribe_badge="<span class='badge text-bg-danger'>$badge</span>";
				    } 

				echo "<div class='list-group'>
								  <a href='apuntes.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-calculator ps-2 pe-3 fs-3' style='color: #FFD700'></i>Cálculos</a> 
							</div>";
				echo "<div class='list-group'>
				  <a href='bitacora.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3' style='color: #CE2E2E'></i>Bitácora &nbsp;$escribe_badge</a> 
							</div>";
				echo "<div class='list-group'>
				  <a href='correos.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-envelope ps-2 pe-3 fs-3' style='color: #29A09B'></i>Directorio Correos</a> 
							</div>";

				}

				?>

            <div class="row">

				<?php 

										//BUSCA SI EL USUARIO ES ADMIN Y AGREGA MENÚ DE ADMIN
										$email_user=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
										$consulta_user="SELECT * FROM `usuarios_dolor` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";

										$confirma_user=$conexion->query($consulta_user); 

										if(mysqli_num_rows($confirma_user)==0){//AL NO ENCONRAR REGISTROS DE ADMIN NO AGREGA NADA

										}else{ 
								
							              echo "
														<form id='gest_users' action='gestion_usuarios.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
														<div class='list-group'>
														  <a href='#' onclick='envioForm1()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-users ps-2 pe-3 fs-3 text-primary'></i>Gestión Usuarios</a> 
														</div></form>
							              <script>function envioForm1() {document.getElementById('gest_users').submit(); }</script>
							              ";

							              echo "<form id='gest_pacientes' action='gestion_pacientes.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
														<div class='list-group'>
														  <a href='#' onclick='envioForm2()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-bed ps-2 pe-3 fs-3 text-primary'></i>Gestión Pacientes</a> 
														</div></form>
							              <script>function envioForm2() {document.getElementById('gest_pacientes').submit(); }</script>
							              ";

										}

							?>				
					</div>

						<div class='list-group'>
					  	<a href='acerca_de.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-circle-question ps-2 pe-3 fs-3' style="color: #FF6347;"></i>Acerca de</a> 
						</div>

					</ul>

<?php
if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
			echo "<ul class='list-group pt-5'>
					<div class='list-group'>
					  <a href='cierra_sesion.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-door-open ps-2 pe-3 fs-3 text-success'></i>Cerrar sesión</a> 
					</div>
        			</ul>";
    }

?>


					<!- FOOTER DEl navbar ->
	                <div class="mb-0 px-0 pt-4 text-center text-black-50">
	                <hr>
	                </div>
	                <div class="mb-0 px-0 py-4 text-center text-black-50">
	                </div>
	                <!- FOOTER DEl navbar ->





</div>
          </div><!- DIV DEL CONTENEDOR DEL OFF CANVAS ->		              
        </div><!- DIV DEL CONTENEDOR OFF CANVAS START -> </div>
      </div><!- DIV DEL TITULO DEL OFF CANVAS ->
      </div>
    </nav>
  </div><!- DIV DE LA COLUMNA CANVAS IZQUIERDA ->

    <style>
    	@media (max-width: 350px) {
      .offcanvas-start {
        background-color: transparent;
        background-image: none;
      }
   		}
   		@media (max-width: 549px) {
      .offcanvas-start {
						background-color: #0050ff;
						background-image: linear-gradient(45deg, #0050ff 100px, #44B2FF 100%);
      }
   		}
    </style>