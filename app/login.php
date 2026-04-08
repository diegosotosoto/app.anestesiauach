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
        $galletita_user=$usuario['nombre_usuario'];
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
    $nombre_usuario=htmlentities(addslashes($_POST['nombre_usuario']));
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
            max-width: 980px;
            margin: 0 auto;
          }

          .login-grid{
            display:grid;
            grid-template-columns: minmax(280px, 420px) minmax(320px, 520px);
            gap: 1rem;
            align-items: stretch;
          }

          .login-hero,
          .login-card{
            border:0;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            overflow:hidden;
          }

          .login-hero{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;
            padding:1.4rem 1.35rem;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            min-height: 100%;
          }

          .login-hero h1{
            color:#fff;
            font-weight:700;
          }

          .login-pill{
            display:inline-block;
            padding:.25rem .6rem;
            border-radius:999px;
            font-size:.8rem;
            font-weight:600;
            background:rgba(255,255,255,.16);
            color:#fff;
            width:max-content;
          }

          .login-hero-list{
            display:grid;
            gap:.7rem;
            margin-top:1rem;
          }

          .login-hero-item{
            display:flex;
            gap:.75rem;
            align-items:flex-start;
            background:rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.12);
            border-radius:1rem;
            padding:.9rem 1rem;
          }

          .login-card{
            background:#fff;
          }

          .login-card-body{
            padding:1.35rem 1.2rem 1.35rem 1.2rem;
          }

          .login-section-title{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#667085;
            margin-bottom:.7rem;
          }

          .login-input{
            min-height:54px;
            border-radius:1rem;
            border:1px solid #dfe7f2;
          }

          .login-addon{
            border-radius:0 1rem 1rem 0 !important;
          }

          .login-toggle{
            border-radius:0 !important;
          }

          .login-links{
            display:grid;
            gap:.45rem;
            margin-top:.75rem;
          }

          .login-links a{
            color:#2453c6;
            text-decoration:none;
          }

          .login-links a:hover{
            text-decoration:underline;
          }

          .login-submit{
            border-radius:1rem;
            padding:.85rem 1.1rem;
            font-weight:600;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
          }

          @media (max-width: 991px){
            .login-grid{
              grid-template-columns:1fr;
            }
          }

          @media (max-width: 549px){
            .login-hero,
            .login-card{
              border-radius:1rem;
            }

            .login-hero{
              padding:1.1rem 1rem;
            }

            .login-card-body{
              padding:1.1rem 1rem;
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
            <div class="login-grid">

              <div class="login-hero">
                <div>
                  <div class="small opacity-75 mb-2">APP clínica • acceso seguro</div>
                  <span class="login-pill mb-3">Anestesia UACh</span>
                  <h1 class="h3 mb-3">¡Hola! <i class="fa-solid fa-face-smile-wink ps-2"></i></h1>
                  <div class="text-white-50">Ingresa tus datos para acceder a recursos docentes, cálculos clínicos, directorios y bitácoras.</div>
                </div>

                <div class="login-hero-list">
                  <div class="login-hero-item">
                    <i class="fa-solid fa-calculator pt-1"></i>
                    <div>Cálculos y herramientas clínicas de acceso rápido.</div>
                  </div>
                  <div class="login-hero-item">
                    <i class="fa-solid fa-book-medical pt-1"></i>
                    <div>Apuntes, checklists y material de apoyo para residentes.</div>
                  </div>
                  <div class="login-hero-item">
                    <i class="fa-solid fa-user-doctor pt-1"></i>
                    <div>Bitácoras, directorios y recursos del programa.</div>
                  </div>
                </div>
              </div>

              <div class="login-card">
                <div class="login-card-body">
                  <div class="login-section-title">Ingreso</div>

                  <div class="mb-3">
                    <label class="form-label text-muted">E-Mail</label>
                    <div class="input-group">
                      <input type="email" name="email_usuario_v" class="form-control login-input" required>
                      <span class="input-group-text bg-primary text-white login-addon"><i class="fa fa-envelope"></i></span>
                    </div>
                  </div>

                  <div class="mb-2">
                    <label class="form-label text-muted">Contraseña</label>
                    <div class="input-group">
                      <input type="password" name="pass_usuario_v" id="pass_usuario_v" class="form-control login-input" required>
                      <button class="btn btn-outline-secondary border-secondary border-opacity-25 login-toggle" type="button" id="button-addon2" onclick="mostrar()">
                        <i id="icono" class="opacity-75 fa-solid fa-eye"></i>
                      </button>
                      <span class="input-group-text bg-primary text-white login-addon"><i class="fa fa-key"></i></span>
                    </div>
                  </div>

                  <div class="login-links">
                    <small><a href="nueva_cuenta.php">Crear nueva cuenta</a></small>
                    <small><a href="nuevo_password.php">Olvidé mi contraseña</a></small>
                  </div>

                  <div class="pt-4">
                    <button type="submit" name="registro" class="btn btn-primary btn-lg login-submit">
                      <i class="fa-solid fa-right-to-bracket pe-2"></i>Ingresar
                    </button>
                  </div>
                </div>
              </div>

            </div>
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
