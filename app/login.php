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
      $nuevo_usuario="INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`) VALUES ('$nombre_usuario','$email_usuario','$pass_cifrado')";
      $registro_usuario=$conexion->query($nuevo_usuario);

      $alerta_login = "<div class='alert alert-success alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Info!</strong> Se ha registrado un nuevo usuario.<br>*** Para ingresar, primero comunícate con un administrador para validar tu cuenta. ***
      </div>";
    }else{
      $alerta_login = "<div class='alert alert-danger alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Info!</strong> Al parecer el correo $email_usuario ya se encuentra registrado.<br>Si olvidaste tu contraseña, puedes solicitar una nueva <a href='nuevo_password.php'>aquí</a>.
      </div>";
    }
  }

  //Variables
  $boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></button>";
  $titulo_navbar="<span class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></span>";
  $boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

  //Carga Head de la página
  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">

<style>
.login-shell{
  max-width:980px;
  margin:0 auto;
}

.about-card{
  border:0;
  border-radius:24px;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  background:#fff;
}

.about-section-title,
.login-section-title{
  font-size:.82rem;
  text-transform:uppercase;
  letter-spacing:.12em;
  color:#667085;
  margin-bottom:16px;
  text-align:center;
}

/* Bienvenida */

.about-welcome-card{
  overflow:hidden;
  border-radius:28px;
  padding:8px 18px 14px;
}

.about-hero-img{
  width:100%;
  display:block;
  border-radius:28px;
  margin:0;
}

.about-welcome-body{
  padding:14px 0 0;
  text-align:center;
}

.about-welcome-title{
  font-size:1.55rem;
  font-weight:800;
  color:#10265f;
  line-height:1.15;
  margin:0;
}

.about-title-line{
  width:54px;
  height:4px;
  border-radius:999px;
  background:#2f63d8;
  margin:14px auto 16px;
}

.about-welcome-text{
  font-size:1.02rem;
  color:#4b5563;
  line-height:1.55;
  margin:0 auto 22px;
  max-width:620px;
}

.about-feature-grid{
  display:grid;
  grid-template-columns:1fr;
  gap:12px;
}

.about-feature-card{
  display:flex;
  align-items:center;
  gap:16px;
  text-align:left;
  border:1px solid #e3eaf5;
  background:#fff;
  border-radius:18px;
  padding:16px;
  box-shadow:0 8px 20px rgba(33,55,98,.06);
}

.about-feature-card i{
  font-size:2rem;
  color:#2f63d8;
  width:42px;
  text-align:center;
  flex:0 0 42px;
}

.about-feature-card strong{
  display:block;
  font-size:1.05rem;
  color:#10265f;
  line-height:1.2;
}

.about-feature-card span{
  display:block;
  margin-top:4px;
  font-size:.95rem;
  color:#5f6b7a;
  line-height:1.35;
}

.about-closing{
  margin-top:22px;
  padding-top:18px;
  border-top:1px solid #dfe7f2;
}

.about-closing strong{
  display:block;
  font-size:1.1rem;
  color:#1d5fd3;
}

.about-closing span{
  display:block;
  margin-top:4px;
  font-size:.95rem;
  color:#5f6b7a;
}

/* Login */

.login-panel-card{
  padding:24px 16px;
}

.login-card-body{
  max-width:520px;
  margin:0 auto;
  padding:0;
}

.login-section-title{
  margin-bottom:22px;
}

.login-form-box{
  border:1px solid #dfe7f2;
  border-radius:22px;
  background:#f8fafc;
  padding:18px 16px;
}

.login-form-box .form-label{
  display:block;
  font-size:.95rem;
  margin-bottom:6px;
  text-align:center;
}

.login-input{
  min-height:42px;
  border-radius:14px;
  border:1px solid #dfe7f2;
  font-size:.95rem;
}

.login-addon{
  min-width:46px;
  justify-content:center;
  border-radius:0 14px 14px 0 !important;
}

.login-toggle{
  min-width:42px;
  border-radius:0 !important;
}

.login-links{
  display:grid;
  gap:6px;
  margin-top:12px;
  text-align:center;
}

.login-links a{
  color:#2453c6;
  text-decoration:none;
}

.login-links a:hover{
  text-decoration:underline;
}

.login-submit{
  min-height:42px;
  border-radius:16px;
  padding:8px 20px;
  font-size:1rem;
  font-weight:700;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
}

/* Responsive */

@media (min-width:768px){
  .about-feature-grid{
    grid-template-columns:repeat(2, 1fr);
  }
}

@media (max-width:549px){
  .about-card{
    border-radius:22px;
  }

  .about-welcome-card{
    padding:8px 14px 14px;
  }

  .about-welcome-title{
    font-size:1.38rem;
  }

  .about-welcome-text{
    font-size:1rem;
  }

  .login-panel-card{
    padding:20px 14px;
  }

  .login-section-title{
    margin-bottom:20px;
  }

  .login-form-box{
    padding:16px 14px;
  }
}
@media (min-width:992px){
  .login-card-body{
    max-width:960px;
  }

  .login-form-box{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px 22px;
    align-items:end;
  }

  .login-links{
    grid-column:1 / -1;
    display:flex;
    justify-content:center;
    gap:28px;
    margin-top:4px;
  }

  .login-form-box .pt-3{
    grid-column:1 / -1;
    padding-top:6px !important;
  }

  .login-input{
    min-height:42px;
  }
}
</style>

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
          <span class="input-group-text bg-primary text-white login-addon">
            <i class="fa fa-envelope"></i>
          </span>
        </div>
      </div>

      <div class="mb-2">
        <label class="form-label text-muted">Contraseña</label>
        <div class="input-group">
          <input type="password" name="pass_usuario_v" id="pass_usuario_v" class="form-control login-input" required>

          <button class="btn btn-outline-secondary border-secondary border-opacity-25 login-toggle" type="button" id="button-addon2" onclick="mostrar()">
            <i id="icono" class="opacity-75 fa-solid fa-eye"></i>
          </button>

          <span class="input-group-text bg-primary text-white login-addon">
            <i class="fa fa-key"></i>
          </span>
        </div>
      </div>

      <div class="login-links">
        <small><a href="nueva_cuenta.php">Crear nueva cuenta</a></small>
        <small><a href="nuevo_password.php">Olvidé mi contraseña</a></small>
      </div>

      <div class="pt-3 text-center">
        <button type="submit" name="registro" class="btn btn-primary login-submit">
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
