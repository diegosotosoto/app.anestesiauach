<?php

  //si existe la cookie se salta el area de login y va al index
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){

	}else{
				header('Location: index.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);

	$conexion->set_charset("utf8");
  $mail_context = $_GET['context'] ?? 'password_recovery';
  $mail_title = $mail_context === 'email_verification' ? 'Verificación enviada' : 'Correo enviado';
  $mail_message = $mail_context === 'email_verification'
    ? 'Por favor, revisa tu correo electrónico. Hemos enviado un mail para verificar tu dirección antes de la validación administrativa.'
    : 'Por favor, revisa tu correo electrónico. Hemos enviado un mail con información para restablecer la contraseña.';


		//Variables
			$boton_toggler="<button class='navbar-toggler app-nav-toggle' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'><i class='fa-solid fa-bars'></i></button>";
		  	$titulo_navbar="<div class='app-navbar-brand app-navbar-brand-compact'><img src='images/austral.png' alt='Universidad Austral de Chile' />Anestesia <small>UACh</small></div>";
			$boton_navbar="<a class='d-sm-block d-sm-none app-nav-action' href='acerca_de.php' aria-label='Acerca de'><i class='fa-solid fa-question'></i></a>";

	//Carga Head de la página
		require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">
        <div class="login-shell">
          <section class="about-card login-panel-card mb-3">
            <div class="login-card-body">
              <div class="login-section-title"><?php echo $mail_title; ?></div>
              <div class="login-form-box text-center">
                <div class="auth-status-icon auth-full">
                  <i class="fa-regular fa-envelope"></i>
                </div>
                <p class="auth-helper auth-full py-3 mb-0">
                  <?php echo $mail_message; ?>
                </p>
                                <p class="auth-helper auth-full py-3 mb-0">
                  Puedes cerrar esta ventana
                </p>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
	<?php
		//Conexión
		require("footer.php");

	?>
