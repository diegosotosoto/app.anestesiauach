<?php

  //si existe la cookie se salta el area de login y va al index
  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
  }else{
    header('Location: index.php');
  }

  //Conexión
  require("conectar.php");
  require_once __DIR__ . "/app_text_helpers.php";
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");

  $alerta_login = "";

  //LOGIN NORMAL DE USUARIO YA REGISTRADO
  if(!empty($_POST['email_usuario_v'])){
    $email_usuario_v=htmlentities(addslashes($_POST['email_usuario_v']));
    $pass_usuario_v=htmlentities(addslashes($_POST['pass_usuario_v']));

    $sql="SELECT `password`,`nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario_v' AND `verified`= '1'";
    $result_sql=$conexion->query($sql);

    if(mysqli_num_rows($result_sql)==0){
      $alerta_login = "<div class='alert alert-danger alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Info!</strong> Usuario o contraseña no válidos.
      </div>";
    }else{
      $usuario=$result_sql->fetch_assoc();
      $confirma_pass=password_verify($pass_usuario_v,$usuario['password']);

      if($confirma_pass){
        $galletita_mail=$email_usuario_v;
        $galletita_user=app_decode_text($usuario['nombre_usuario']);
        setcookie("hkjh41lu4l1k23jhlkj13",$galletita_mail, time()+60*60*24*30*6);
        setcookie("hkjh41lu4l1k23jhlkj14",$galletita_user, time()+60*60*24*30*6);
        header('Location: index.php');
      }else{
        $alerta_login = "<div class='alert alert-danger alert-dismissible fade show'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Info!</strong> Usuario o contraseña no válidos.
        </div>";
      }
    }
  }

  // registro nuevo usuario desde nueva_cuenta.php
  if(!empty($_POST['email_usuario'])){
    $email_usuario=htmlentities(addslashes($_POST['email_usuario']));
    $nombre_usuario=$conexion->real_escape_string(app_decode_text($_POST['nombre_usuario']));
    $pass_usuario=htmlentities(addslashes($_POST['pass_usuario']));
    $pass_cifrado=password_hash($pass_usuario, PASSWORD_DEFAULT);

    $chequea_email="SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario'";
    $result=$conexion->query($chequea_email);
    $conteo=mysqli_num_rows($result);

    if($conteo==0){
      $nuevo_usuario="INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`, `verified_email`) VALUES ('$nombre_usuario','$email_usuario','$pass_cifrado','0')";
      $registro_usuario=$conexion->query($nuevo_usuario);

      $alerta_login = "<div class='alert alert-success alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Info!</strong> Se ha registrado un nuevo usuario.<br>Te enviaremos un correo para verificar tu dirección. Luego tu cuenta quedará pendiente de validación administrativa.
      </div>

      <form method='POST' action='mail.php' name='mail_post'>
        <input type='hidden' name='mail_context' value='email_verification'>
        <input type='hidden' name='email_usuario_verif' value='".$email_usuario."'>
      </form>

      <script>
        window.onload = function(){
          document.forms['mail_post'].submit();
        }
      </script>";
    }else{
      $alerta_login = "<div class='alert alert-danger alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Info!</strong> Al parecer el correo $email_usuario ya se encuentra registrado.<br>Si olvidaste tu contraseña, puedes solicitar una nueva <a href='nuevo_password.php'>aquí</a>.
      </div>";
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

          <form class="needs-validation" action="login.php" method="post" novalidate autocomplete="off">

<div class="about-card about-welcome-card mb-3">
  <img src="images/about.jpg" class="about-hero-img" alt="App Anestesia UACh">

  <div class="about-welcome-body">
    <div class="about-section-title text-center">Bienvenidos</div>

    <h2 class="about-welcome-title">
      ¡Bienvenido a App Anestesia UACh!
    </h2>

    <div class="about-title-line"></div>

    <p class="about-welcome-text">
      Tu plataforma integral de recursos, cálculo clínico y apoyo docente para residentes e internos de Anestesiología.
    </p>

    <div class="about-feature-grid">
      <div class="about-feature-card">
        <i class="fa-solid fa-book-open"></i>
        <div>
          <strong>Recursos</strong>
          <span>Material de estudio y guías clínicas</span>
        </div>
      </div>

      <div class="about-feature-card">
        <i class="fa-solid fa-calculator"></i>
        <div>
          <strong>Cálculos Clínicos</strong>
          <span>Herramientas de apoyo para la práctica clínica</span>
        </div>
      </div>

      <div class="about-feature-card">
        <i class="fa-solid fa-stethoscope"></i>
        <div>
          <strong>Casos Clínicos</strong>
          <span>Aprende con casos reales y simulados</span>
        </div>
      </div>

      <div class="about-feature-card">
        <i class="fa-solid fa-users"></i>
        <div>
          <strong>Comunidad</strong>
          <span>Conecta con residentes y especialistas</span>
        </div>
      </div>
    </div>

    <div class="about-closing">
      <strong>Aprende, calcula, comparte y crece.</strong>
      <span>Todo lo que necesitas, en un solo lugar.</span>
    </div>
  </div>
</div>




<section class="about-card login-panel-card mb-3">
  <div class="login-card-body">
    <div class="login-section-title">Ingreso</div>

    <div class="login-form-box">
      <div class="mb-3">
        <label class="form-label text-muted">E-Mail</label>
        <div class="input-group">
          <input type="email" name="email_usuario_v" class="form-control login-input" required>
          <span class="input-group-text app-input-addon login-addon">
            <i class="fa fa-envelope"></i>
          </span>
        </div>
      </div>

      <div class="mb-2">
        <label class="form-label text-muted">Contraseña</label>
        <div class="input-group">
          <input type="password" name="pass_usuario_v" id="pass_usuario_v" class="form-control login-input" required>

          <button class="btn login-toggle" type="button" id="button-addon2" onclick="mostrar()">
            <i id="icono" class="opacity-75 fa-solid fa-eye"></i>
          </button>

          <span class="input-group-text app-input-addon login-addon">
            <i class="fa fa-key"></i>
          </span>
        </div>
      </div>

      <div class="login-links">
        <small><a href="nueva_cuenta.php">Crear nueva cuenta</a></small>
        <small><a href="nuevo_password.php">Olvidé mi contraseña</a></small>
      </div>

      <div class="pt-3 text-center">
        <button type="submit" name="registro" class="btn btn-app-primary login-submit">
          <i class="fa-solid fa-right-to-bracket pe-2"></i>Ingresar
        </button>
      </div>
    </div>
  </div>
</section>
          </form>

          <script type="text/javascript">
            function mostrar() {
              var tipo = document.getElementById("pass_usuario_v");
              var icono = document.getElementById("icono");
              if(tipo.type == 'password') {
                tipo.type = 'text';
                icono.className = 'fa-solid fa-eye-slash';
              } else {
                tipo.type = 'password';
                icono.className = 'fa-solid fa-eye';
              }
            }
          </script>

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
