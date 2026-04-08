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
  $boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></button>";
  $titulo_navbar="<span class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></span>";
  $boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

  //Carga Head de la página
  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="login-shell">

        <style>
          .password-shell{
            max-width: 980px;
            margin: 0 auto;
          }

          .password-grid{
            display:grid;
            grid-template-columns: minmax(280px, 420px) minmax(320px, 520px);
            gap: 1rem;
            align-items: stretch;
          }

          .password-hero,
          .password-card{
            border:0;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            overflow:hidden;
          }

          .password-hero{
            background:var(--app-gradient) !important;
            color:#fff;
            padding:1.4rem 1.35rem;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
          }

          .password-hero h1{
            color:#fff;
            font-weight:700;
          }

          .password-pill{
            display:inline-block;
            padding:.25rem .6rem;
            border-radius:999px;
            font-size:.8rem;
            font-weight:600;
            background:rgba(255,255,255,.16);
            color:#fff;
            width:max-content;
          }

          .password-hero-list{
            display:grid;
            gap:.7rem;
            margin-top:1rem;
          }

          .password-hero-item{
            display:flex;
            gap:.75rem;
            align-items:flex-start;
            background:rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.12);
            border-radius:1rem;
            padding:.9rem 1rem;
          }

          .password-card{
            background:#fff;
          }

          .password-card-body{
            padding:1.35rem 1.2rem 1.35rem 1.2rem;
          }

          .password-section-title{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#667085;
            margin-bottom:.7rem;
            text-align:center;
          }

          .password-input{
            min-height:54px;
            border-radius:1rem;
            border:1px solid #dfe7f2;
          }

          .password-addon{
            border-radius:0 1rem 1rem 0 !important;
          }

          .password-helper{
            color:#6b7280;
            font-size:.95rem;
            line-height:1.55;
            text-align:center;
          }

          .password-submit{
            border-radius:1rem;
            padding:.85rem 1.1rem;
            font-weight:600;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
          }

          @media (max-width: 991px){
            .password-grid{
              grid-template-columns:1fr;
            }
          }

          @media (max-width: 549px){
            .password-hero,
            .password-card{
              border-radius:1rem;
            }

            .password-hero{
              padding:1.1rem 1rem;
            }

            .password-card-body{
              padding:1.1rem 1rem;
            }
          }
        </style>

        <div class="password-shell">

          <?php
            if(!empty($alerta_login)){
              echo $alerta_login;
            }
          ?>

          <form class="needs-validation" action="nuevo_password.php" method="post" novalidate autocomplete="off">
            <div class="password-grid">

              <div class="password-hero">
                <div>
                  <div class="small opacity-75 mb-2">APP clínica • recuperación de acceso</div>
                  <span class="password-pill mb-3">Contraseña</span>
                  <h1 class="h3 mb-3">¿Olvidaste tu contraseña? <i class="fa-solid fa-key ps-2"></i></h1>
                  <div class="text-white-50">Ingresa tu correo electrónico y te enviaremos un mensaje con instrucciones para recuperar el acceso.</div>
                </div>

                <div class="password-hero-list">
                  <div class="password-hero-item">
                    <i class="fa-solid fa-envelope pt-1"></i>
                    <div>La recuperación se realiza mediante correo electrónico.</div>
                  </div>
                  <div class="password-hero-item">
                    <i class="fa-solid fa-shield-halved pt-1"></i>
                    <div>Solo cuentas validadas y activas dentro del sistema pueden solicitar recuperación.</div>
                  </div>
                  <div class="password-hero-item">
                    <i class="fa-solid fa-user-check pt-1"></i>
                    <div>Si tienes problemas, contacta a un administrador del programa.</div>
                  </div>
                </div>
              </div>

              <div class="password-card">
                <div class="password-card-body">
                  <div class="password-section-title">Recuperación</div>

                  <div class="password-helper mb-4">
                    Por favor, ingresa tu correo electrónico y te enviaremos un mail con la información necesaria.
                  </div>

                  <div class="mb-3">
                    <label class="form-label text-muted">E-Mail</label>
                    <div class="input-group">
                      <input type="email" name="email_usuario_r" class="form-control password-input" required>
                      <span class="input-group-text bg-primary text-white password-addon"><i class="fa fa-envelope"></i></span>
                    </div>
                  </div>

                  <div class="pt-3">
                    <button type="submit" name="registro" class="btn btn-primary btn-lg password-submit">
                      <i class="fa-solid fa-paper-plane pe-2"></i>Enviar
                    </button>
                  </div>
                </div>
              </div>

            </div>
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
