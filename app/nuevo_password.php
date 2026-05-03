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

  $alerta_login = "";

  //chequea si viene post
  if(!empty($_POST['email_usuario_r'])){
    $email_usuario=htmlentities(addslashes($_POST['email_usuario_r']));

    $chequea_email="SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario' AND `verified`= '1'";
    $result=$conexion->query($chequea_email);
    $conteo=mysqli_num_rows($result);

    if($conteo==0){
      $alerta_login = "
        <div class='alert alert-danger alert-dismissible fade show'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Info!</strong> Error en el registro, contacta al administrador.
        </div>
      ";
    }else{
      $alerta_login = "
        <div class='alert alert-success alert-dismissible fade show'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Info!</strong> Se ha enviado un correo a la cuenta indicada.
        </div>

        <form method='POST' action='mail.php' name='mail_post'>
          <input type='hidden' name='email_usuario_rec' value='".$email_usuario."'>
        </form>

        <script>
          window.onload = function(){
            document.forms['mail_post'].submit();
          }
        </script>
      ";
    }
  }

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

          <?php
            if(!empty($alerta_login)){
              echo $alerta_login;
            }
          ?>


        <div class="about-card about-welcome-card mb-3">

          <div class="about-welcome-body">
            <div class="about-section-title text-center">Recuperación</div>

            <h2 class="about-welcome-title">
              Recuperación de Contraseña
            </h2>

            <div class="about-title-line"></div>

            <p class="about-welcome-text">
              Ingresa tu correo electrónico y te enviaremos un mensaje con instrucciones para recuperar el acceso.
            </p>

            <div class="about-feature-grid">

              <div class="about-feature-card">
                <i class="fa-solid fa-envelope"></i>
                <div>
                  <strong>Correo registrado</strong>
                  <span>Enviaremos un correo a tu email registrado</span>
                </div>
              </div>

              <div class="about-feature-card">
                <i class="fa-solid fa-key"></i>
                <div>
                  <strong>Contraseña</strong>
                  <span>tendrás algunos minutos para crear una nueva contraseña</span>
                </div>
              </div>

            </div>

          </div>
        </div>


          <form class="needs-validation" action="nuevo_password.php" method="post" novalidate autocomplete="off">
            <section class="about-card login-panel-card mb-3">
              <div class="login-card-body">

                <div class="login-form-box">

                  <div class="mb-3 auth-full auth-field-narrow">
                    <label class="form-label text-muted">E-Mail</label>
                    <div class="input-group">
                      <input type="email" name="email_usuario_r" class="form-control login-input" required>
                      <span class="input-group-text app-input-addon login-addon"><i class="fa fa-envelope"></i></span>
                    </div>
                  </div>

                  <div class="pt-3 text-center auth-full">
                    <button type="submit" name="registro" class="btn btn-app-primary login-submit">
                      <i class="fa-solid fa-paper-plane pe-2"></i>Enviar
                    </button>
                  </div>
                </div>
              </div>
            </section>
          </form>

          <script>
            (() => {
              'use strict'
              const forms = document.querySelectorAll('.needs-validation')
              Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                  if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                  }
                  form.classList.add('was-validated')
                }, false)
              })
            })()
          </script>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
  require("footer.php");
?>
