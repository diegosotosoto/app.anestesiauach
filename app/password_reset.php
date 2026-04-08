<?php

  //Variables
  $boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></button>";
  $titulo_navbar="<span class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></span>";
  $boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

  //Carga Head de la página
  require("head.php");
?>
<script type="text/javascript" src="js/not_reload.js"></script>

<style type="text/css">
  input.texto-seguro{
    -webkit-text-security: disc;
    -moz-text-security: disc;
    text-security: disc;
  }

  .reset-shell{
    max-width: 980px;
    margin: 0 auto;
  }

  .reset-grid{
    display:grid;
    grid-template-columns: minmax(280px, 420px) minmax(320px, 560px);
    gap: 1rem;
    align-items: stretch;
  }

  .reset-hero,
  .reset-card{
    border:0;
    border-radius:1.25rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    overflow:hidden;
  }

  .reset-hero{
    background:var(--app-gradient) !important;
    color:#fff;
    padding:1.4rem 1.35rem;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
  }

  .reset-hero h1{
    color:#fff;
    font-weight:700;
  }

  .reset-pill{
    display:inline-block;
    padding:.25rem .6rem;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
    background:rgba(255,255,255,.16);
    color:#fff;
    width:max-content;
  }

  .reset-hero-list{
    display:grid;
    gap:.7rem;
    margin-top:1rem;
  }

  .reset-hero-item{
    display:flex;
    gap:.75rem;
    align-items:flex-start;
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.12);
    border-radius:1rem;
    padding:.9rem 1rem;
  }

  .reset-card{
    background:#fff;
  }

  .reset-card-body{
    padding:1.35rem 1.2rem 1.35rem 1.2rem;
  }

  .reset-section-title{
    font-size:.82rem;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#667085;
    margin-bottom:.7rem;
    text-align:center;
  }

  .reset-input{
    min-height:54px;
    border-radius:1rem;
    border:1px solid #dfe7f2;
  }

  .reset-addon{
    border-radius:0 1rem 1rem 0 !important;
  }

  .reset-toggle{
    border-radius:0 !important;
  }

  .reset-helper{
    color:#6b7280;
    font-size:.9rem;
    line-height:1.5;
  }

  .reset-submit{
    border-radius:1rem;
    padding:.85rem 1.1rem;
    font-weight:600;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
  }

  @media (max-width: 991px){
    .reset-grid{
      grid-template-columns:1fr;
    }
  }

  @media (max-width: 549px){
    .reset-hero,
    .reset-card{
      border-radius:1rem;
    }

    .reset-hero{
      padding:1.1rem 1rem;
    }

    .reset-card-body{
      padding:1.1rem 1rem;
    }
  }
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="reset-shell">

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
          <input type="hidden" name="email_usuario_rec" value="<?php echo $email_usuario_rec; ?>">

          <div class="reset-grid">

            <div class="reset-hero">
              <div>
                <div class="small opacity-75 mb-2">APP clínica • restablecimiento seguro</div>
                <span class="reset-pill mb-3">Nueva contraseña</span>
                <h1 class="h3 mb-3">Restablecer acceso <i class="fa-solid fa-key ps-2"></i></h1>
                <div class="text-white-50">Crea una nueva contraseña para la cuenta asociada al correo indicado.</div>
              </div>

              <div class="reset-hero-list">
                <div class="reset-hero-item">
                  <i class="fa-solid fa-envelope pt-1"></i>
                  <div><?php echo $email_usuario_rec; ?></div>
                </div>
                <div class="reset-hero-item">
                  <i class="fa-solid fa-shield-halved pt-1"></i>
                  <div>El enlace es temporal. Define una nueva clave segura antes de que expire.</div>
                </div>
                <div class="reset-hero-item">
                  <i class="fa-solid fa-lock pt-1"></i>
                  <div>Tu nueva contraseña debe incluir mayúscula, número y símbolo.</div>
                </div>
              </div>
            </div>

            <div class="reset-card">
              <div class="reset-card-body">
                <div class="reset-section-title">Nueva contraseña</div>

                <div class="mb-3">
                  <label class="form-label text-muted">Contraseña</label>
                  <div class="input-group mb-2">
                    <input type="password" name="pass_usuario" id="pass_usuario" class="form-control reset-input" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary border-secondary border-opacity-25 reset-toggle" type="button" id="button-addon2" onclick="mostrar()"><i id="icono" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text bg-primary text-white reset-addon"><i class="fa fa-key"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Repetir contraseña</label>
                  <div class="input-group mb-2">
                    <input type="password" name="pass_usuario2" id="pass_usuario2" class="form-control reset-input" required aria-describedby="button-addon">
                    <button class="btn btn-outline-secondary border-secondary border-opacity-25 reset-toggle" type="button" id="button-addon" onclick="mostrar2()"><i id="icono2" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text bg-primary text-white reset-addon"><i class="fa fa-key"></i></span>
                    <div class="invalid-feedback pt-0">Las contraseñas deben coincidir...</div>
                  </div>
                </div>

                <div class="reset-helper mb-4">
                  Contraseña de 8 a 12 caracteres, incluyendo una mayúscula, un número y un símbolo (!@#$%^&*_=+-)
                </div>

                <div class="pt-2">
                  <button type="submit" name="registro" class="btn btn-primary btn-lg reset-submit">
                    <i class="fa-solid fa-check-to-slot pe-2"></i>Guardar nueva contraseña
                  </button>
                </div>

              </div>
            </div>

          </div>
        </form>

<?php
    } else {
?>
        <div class="reset-grid">
          <div class="reset-hero">
            <div>
              <div class="small opacity-75 mb-2">APP clínica • restablecimiento seguro</div>
              <span class="reset-pill mb-3">Enlace expirado</span>
              <h1 class="h3 mb-3">Enlace expirado <i class="fa-regular fa-face-dizzy ps-2"></i></h1>
              <div class="text-white-50">El enlace para restablecer la contraseña ya no es válido.</div>
            </div>
          </div>

          <div class="reset-card">
            <div class="reset-card-body text-center">
              <div class="reset-section-title">Recuperación</div>
              <p class="reset-helper mb-4">El enlace para restablecer la contraseña ha expirado. Por favor solicita uno nuevo.</p>
              <a class="btn btn-primary btn-lg reset-submit" href="nuevo_password.php">
                <i class="fa-solid fa-rotate pe-2"></i>Solicitar nuevo enlace
              </a>
            </div>
          </div>
        </div>
<?php
    }

  } else {
?>
      <div class="reset-grid">
        <div class="reset-hero">
          <div>
            <div class="small opacity-75 mb-2">APP clínica • restablecimiento seguro</div>
            <span class="reset-pill mb-3">Enlace inválido</span>
            <h1 class="h3 mb-3">Enlace inválido <i class="fa-regular fa-face-dizzy ps-2"></i></h1>
            <div class="text-white-50">No se encontró un token válido para restablecer la contraseña.</div>
          </div>
        </div>

        <div class="reset-card">
          <div class="reset-card-body text-center">
            <div class="reset-section-title">Recuperación</div>
            <p class="reset-helper mb-4">El enlace para restablecer la contraseña ha expirado o no es válido. Inténtalo nuevamente.</p>
            <a class="btn btn-primary btn-lg reset-submit" href="nuevo_password.php">
              <i class="fa-solid fa-rotate pe-2"></i>Solicitar nuevo enlace
            </a>
          </div>
        </div>
      </div>
<?php
  }
}
?>

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
