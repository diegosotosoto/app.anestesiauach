<?php

  //Variables
  $boton_toggler="<button class='navbar-toggler app-nav-toggle' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'><i class='fa-solid fa-bars'></i></button>";
  $titulo_navbar="<div class='app-navbar-brand app-navbar-brand-compact'><img src='images/austral.png' alt='Universidad Austral de Chile' />Anestesia <small>UACh</small></div>";
  $boton_navbar="<a class='d-sm-block d-sm-none app-nav-action' href='acerca_de.php' aria-label='Acerca de'><i class='fa-solid fa-question'></i></a>";

  //Carga Head de la página
  require("head.php");
?>
<script type="text/javascript" src="js/not_reload.js"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">
        <div class="login-shell">

<?php
if (!empty($_POST['email_usuario_rec'])) {

  $email_usuario_final=htmlentities(addslashes($_POST['email_usuario_rec']));
  $pass_usuario_final=htmlentities(addslashes($_POST['pass_usuario']));
  $pass_cifrado_final=password_hash($pass_usuario_final, PASSWORD_DEFAULT);

  $consulta_final="UPDATE `usuarios_dolor` SET `password`='$pass_cifrado_final', `token_rec`='', `token_activ`='0', `token_hr`='' WHERE `email_usuario`='$email_usuario_final'";
  $escribir_pass=$conexion->query($consulta_final);

  echo "
    <div class='alert alert-success alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> Se ha cambiado la contraseña correctamente.
    </div>
  ";

  header('Location: login.php');
  exit();

} else {

  $token_rec = $_GET['962eb831a0df54562eb40fed6bf13b'] ?? '';
  $token_activ = $_GET['89cd7e5e18f25d8e1214f1d8f273da'] ?? '';
  $email_usuario_rec = $_GET['a52f7597ca4d6c24937711a66fd058'] ?? '';

  if($token_rec){

    $chequea_tokens1="SELECT `token_rec`,`token_activ`,`token_hr` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario_rec' AND `verified`= '1'";
    $result_chk=$conexion->query($chequea_tokens1);
    $cheqtok=$result_chk->fetch_assoc();

    $chk_token_rec=$cheqtok['token_rec'] ?? '';
    $chk_token_activ=$cheqtok['token_activ'] ?? '';
    $chk_token_hr=$cheqtok['token_hr'] ?? '';

    if($chk_token_hr){
      $hora_limite=$chk_token_hr+300;
    } else {
      $hora_limite=0;
    }

    $hora_actual=time();

    if($chk_token_rec==$token_rec AND $chk_token_activ==1 AND $hora_limite>$hora_actual){
?>

        <form class="needs-validation" action="password_reset.php" method="post" novalidate autocomplete="off" oninput='pass_usuario2.setCustomValidity(pass_usuario2.value != pass_usuario.value ? "Passwords do not match." : "")'>
          <input type="hidden" name="email_usuario_rec" value="<?php echo htmlspecialchars($email_usuario_rec); ?>">

          <section class="about-card login-panel-card mb-3">
            <div class="login-card-body">
              <div class="login-section-title">Nueva contraseña</div>

              <div class="login-form-box">
                <div class="auth-helper auth-full">
                  Crea una nueva contraseña para <?php echo htmlspecialchars($email_usuario_rec); ?>. El enlace es temporal.
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Contraseña</label>
                  <div class="input-group mb-2">
                    <input type="password" name="pass_usuario" id="pass_usuario" class="form-control login-input" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$" aria-describedby="button-addon2">
                    <button class="btn login-toggle" type="button" id="button-addon2" onclick="mostrar()"><i id="icono" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text app-input-addon login-addon"><i class="fa fa-key"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Repetir contraseña</label>
                  <div class="input-group mb-2">
                    <input type="password" name="pass_usuario2" id="pass_usuario2" class="form-control login-input" required aria-describedby="button-addon">
                    <button class="btn login-toggle" type="button" id="button-addon" onclick="mostrar2()"><i id="icono2" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text app-input-addon login-addon"><i class="fa fa-key"></i></span>
                    <div class="invalid-feedback pt-0">Las contraseñas deben coincidir...</div>
                  </div>
                </div>

                <div class="auth-helper auth-full">
                  Contraseña de 8 a 12 caracteres, incluyendo una mayúscula, un número y un símbolo (!@#$%^&*_=+-)
                </div>

                <div class="pt-3 text-center auth-full">
                  <button type="submit" name="registro" class="btn btn-app-primary login-submit">
                    <i class="fa-solid fa-check-to-slot pe-2"></i>Guardar nueva contraseña
                  </button>
                </div>

              </div>
            </div>
          </section>
        </form>

<?php
    } else {
?>
        <section class="about-card login-panel-card mb-3">
          <div class="login-card-body">
            <div class="login-section-title">Recuperación</div>
            <div class="login-form-box text-center">
              <p class="auth-helper auth-full mb-4">El enlace para restablecer la contraseña ha expirado. Por favor solicita uno nuevo.</p>
              <div class="auth-full">
                <a class="btn btn-app-primary login-submit" href="nuevo_password.php">
                <i class="fa-solid fa-rotate pe-2"></i>Solicitar nuevo enlace
                </a>
              </div>
            </div>
          </div>
        </section>
<?php
    }

  } else {
?>
      <section class="about-card login-panel-card mb-3">
        <div class="login-card-body">
          <div class="login-section-title">Recuperación</div>
          <div class="login-form-box text-center">
            <p class="auth-helper auth-full mb-4">El enlace para restablecer la contraseña ha expirado o no es válido. Inténtalo nuevamente.</p>
            <div class="auth-full">
              <a class="btn btn-app-primary login-submit" href="nuevo_password.php">
              <i class="fa-solid fa-rotate pe-2"></i>Solicitar nuevo enlace
              </a>
            </div>
          </div>
        </div>
      </section>
<?php
  }
}
?>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function mostrar() {
  var tipo = document.getElementById('pass_usuario');
  var icono = document.getElementById('icono');
  if(tipo.type == 'password') {
    tipo.type = 'text';
    icono.className = 'fa-solid fa-eye-slash';
  } else {
    tipo.type = 'password';
    icono.className = 'fa-solid fa-eye';
  }
}

function mostrar2() {
  var tipo2 = document.getElementById('pass_usuario2');
  var icono2 = document.getElementById('icono2');
  if(tipo2.type == 'password') {
    tipo2.type = 'text';
    icono2.className = 'fa-solid fa-eye-slash';
  } else {
    tipo2.type = 'password';
    icono2.className = 'fa-solid fa-eye';
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

<?php
  require("footer.php");
?>
