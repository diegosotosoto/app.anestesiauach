<?php


/**  NADAAA
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


**/
?>

</head>
<body>

<!-  NAVBAR  ->	

	<?php
		//Botones del Toggle NAVBAR


		$boton_toggler="<button class='navbar-toggler app-nav-toggle' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' aria-label='Abrir menú'><i class='fa-solid fa-bars'></i></button>";
		$titulo_navbar="";
		$boton_navbar="<a class='app-nav-action' href='nuevo_paciente.php' role='button' aria-label='Nuevo paciente'><i class='fa fa-plus' aria-hidden='true'></i></a>";
		//Conexión
		require("navbar.php");
	?>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">


            <div class="" id="offcanvasExampleLabel"><h5><?php echo app_h_text($_COOKIE['hkjh41lu4l1k23jhlkj14']); ?></h5></div>

          <div class="text-muted"><?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?></div>
          <hr>
              <div class="text-primary pt-4 fs-5">
              <i style="margin-left:12px" class="fa-solid fa-clipboard"></i>
              <a class="text-decoration-none" style="padding-left:8px" href='apuntes.php'> Apuntes</a></div>

              <div class="text-primary pt-4 fs-5">
              <i style="margin-left:10px" class="fa-solid fa-door-open"></i>
              <a class="text-decoration-none" style="padding-left:5px" href='cierra_sesion.php'> Cerrar sesión</a></div>

              <div class="text-primary pt-4 fs-5">
              <i style="margin-left:12px" class="fa-solid fa-file-arrow-up"></i>
              <a class="text-decoration-none" style="padding-left:8px" href='acerca_de.php'> Acerca de</a></div>


				<?php 

							//BUSCA SI EL USUARIO ES ADMIN Y AGREGA MENÚ DE ADMIN
							$email_user=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
							$consulta_user="SELECT * FROM `usuarios_dolor` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";

							$confirma_user=$conexion->query($consulta_user); 

							if(mysqli_num_rows($confirma_user)==0){//AL NO ENCONRAR REGISTROS DE ADMIN NO AGREGA NADA

							}else{ 
					
				              echo "<form id='gest_users' action='gestion_usuarios.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
				              <div class='text-primary pt-4 fs-5'>
				              <i style='margin-left:10px' class='fa-solid fa-users'></i>
				              <a class='text-decoration-none' style='padding-left:5px' href='#' onclick='envioForm1()'> Gestión Usuarios</a></div></form>
				              <script>function envioForm1() {document.getElementById('gest_users').submit(); }</script>
				              ";

				              echo "<form id='gest_pacientes' action='gestion_pacientes.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
				              <div class='text-primary pt-4 fs-5'>
				              <i style='margin-left:10px' class='fa-solid fa-users'></i>
				              <a class='text-decoration-none' style='padding-left:5px' href='#' onclick='envioForm2()'> Gestión Pacientes</a></div></form>
				              <script>function envioForm2() {document.getElementById('gest_pacientes').submit(); }</script>
				              ";

							}

				?>
              <div class="fixed-bottom mb-6"><hr>
                <div class="container">
                <div class="row">
                  <div class="col text-muted pb-4">
                    <i class="fa-solid fa-user-gear" style="margin-left:40px"></i><small style="padding-left:15px">Diego Soto Soto - 2022</small></div>
                </div>
              </div></div>

        </div>
      </div>


</br>
</br>

<div class="content-shell px-3">
  <div class="links-grid home-grid">
    <a href="#" class="link-tile home-tile home-tile-dolor">
      <i class="fa-solid fa-user-plus fa-2x mb-2"></i>
      <div class="link-title">Nuevo Paciente</div>
      <div class="link-desc">Registro clínico inicial.</div>
    </a>

    <a href="#" class="link-tile home-tile home-tile-bitacora">
      <i class="fa-solid fa-syringe fa-2x mb-2"></i>
      <div class="link-title">Ingreso Dolor</div>
      <div class="link-desc">Seguimiento de analgesia.</div>
    </a>

    <a href="#" class="link-tile home-tile home-tile-epa disabled" aria-disabled="true">
      <i class="fa-solid fa-clipboard fa-2x mb-2"></i>
      <div class="link-title">Visita Preanestésica</div>
      <div class="link-desc">Flujo no disponible.</div>
    </a>

    <a href="apuntes.php" class="link-tile home-tile home-tile-apuntes">
      <i class="fa-solid fa-book fa-2x mb-2"></i>
      <div class="link-title">Apuntes</div>
      <div class="link-desc">Notas y calculadoras.</div>
    </a>
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

</body>
</html>
