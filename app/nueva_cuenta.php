<?php

  //Variables
  $boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></button>";
  $titulo_navbar="<span class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></span>";
  $boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

  //Carga Head de la página
  require("head.php");
?>

<style type="text/css">
  input.texto-seguro{
    -webkit-text-security: disc;
    -moz-text-security: disc;
    text-security: disc;
  }

  .registro-shell{
    max-width: 980px;
    margin: 0 auto;
  }

  .registro-grid{
    display:grid;
    grid-template-columns: minmax(280px, 420px) minmax(320px, 560px);
    gap: 1rem;
    align-items: stretch;
  }

  .registro-hero,
  .registro-card{
    border:0;
    border-radius:1.25rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    overflow:hidden;
  }

  .registro-hero{
    background:var(--app-gradient) !important;
    color:#fff;
    padding:1.4rem 1.35rem;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
  }

  .registro-hero h1{
    color:#fff;
    font-weight:700;
  }

  .registro-pill{
    display:inline-block;
    padding:.25rem .6rem;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
    background:rgba(255,255,255,.16);
    color:#fff;
    width:max-content;
  }

  .registro-hero-list{
    display:grid;
    gap:.7rem;
    margin-top:1rem;
  }

  .registro-hero-item{
    display:flex;
    gap:.75rem;
    align-items:flex-start;
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.12);
    border-radius:1rem;
    padding:.9rem 1rem;
  }

  .registro-card{
    background:#fff;
  }

  .registro-card-body{
    padding:1.35rem 1.2rem 1.35rem 1.2rem;
  }

  .registro-section-title{
    font-size:.82rem;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#667085;
    margin-bottom:.7rem;
    text-align:center;
  }

  .registro-input{
    min-height:54px;
    border-radius:1rem;
    border:1px solid #dfe7f2;
  }

  .registro-addon{
    border-radius:0 1rem 1rem 0 !important;
  }

  .registro-toggle{
    border-radius:0 !important;
  }

  .registro-helper{
    color:#6b7280;
    font-size:.88rem;
    line-height:1.45;
  }

  .registro-terms{
    resize:none;
    border-radius:1rem;
    border:1px solid #dfe7f2;
    background:#f8fafc;
  }

  .registro-submit{
    border-radius:1rem;
    padding:.85rem 1.1rem;
    font-weight:600;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
  }

  @media (max-width: 991px){
    .registro-grid{
      grid-template-columns:1fr;
    }
  }

  @media (max-width: 549px){
    .registro-hero,
    .registro-card{
      border-radius:1rem;
    }

    .registro-hero{
      padding:1.1rem 1rem;
    }

    .registro-card-body{
      padding:1.1rem 1rem;
    }
  }
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="registro-shell">

        <form class="needs-validation" action="login.php" method="post" novalidate autocomplete="off" oninput='pass_usuario2.setCustomValidity(pass_usuario2.value != pass_usuario.value ? "Passwords do not match." : "")'>
          <div class="registro-grid">

            <div class="registro-hero">
              <div>
                <div class="small opacity-75 mb-2">APP clínica • registro de usuarios</div>
                <span class="registro-pill mb-3">Nueva cuenta</span>
                <h1 class="h3 mb-3">¿Eres nuev@? <i class="fa-solid fa-crow ps-2"></i></h1>
                <div class="text-white-50">Regístrate para solicitar acceso a herramientas clínicas, apuntes, directorios y recursos internos del programa.</div>
              </div>

              <div class="registro-hero-list">
                <div class="registro-hero-item">
                  <i class="fa-solid fa-user-doctor pt-1"></i>
                  <div>Acceso para internos, residentes y staff del programa.</div>
                </div>
                <div class="registro-hero-item">
                  <i class="fa-solid fa-shield-halved pt-1"></i>
                  <div>Tu cuenta debe ser validada por un administrador antes del primer ingreso.</div>
                </div>
                <div class="registro-hero-item">
                  <i class="fa-solid fa-book-medical pt-1"></i>
                  <div>Una vez activada, podrás usar cálculos clínicos, bitácoras y material de estudio.</div>
                </div>
              </div>
            </div>

            <div class="registro-card">
              <div class="registro-card-body">
                <div class="registro-section-title">Registro</div>

                <div class="mb-3">
                  <label class="form-label text-muted">Nombre y apellido</label>
                  <div class="input-group">
                    <input type="text" name="nombre_usuario" class="form-control registro-input" pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' required>
                    <span class="input-group-text bg-primary text-white registro-addon"><i class="fa fa-user"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">E-Mail</label>
                  <div class="input-group">
                    <input type="email" name="email_usuario" class="form-control registro-input" required>
                    <span class="input-group-text bg-primary text-white registro-addon"><i class="fa fa-envelope"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Contraseña</label>
                  <div class="input-group">
                    <input type="password" name="pass_usuario" id="pass_usuario" class="form-control registro-input" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary border-secondary border-opacity-25 registro-toggle" type="button" id="button-addon2" onclick="mostrar()"><i id="icono" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text bg-primary text-white registro-addon"><i class="fa fa-key"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Repetir contraseña</label>
                  <div class="input-group">
                    <input type="password" name="pass_usuario2" id="pass_usuario2" class="form-control registro-input" required aria-describedby="button-addon">
                    <button class="btn btn-outline-secondary border-secondary border-opacity-25 registro-toggle" type="button" id="button-addon" onclick="mostrar2()"><i id="icono2" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text bg-primary text-white registro-addon"><i class="fa fa-key"></i></span>
                    <div class="invalid-feedback pt-1">
                      Las contraseñas deben coincidir...
                    </div>
                  </div>
                </div>

                <div class="registro-helper mb-3">
                  Contraseña de 8 a 12 caracteres, incluyendo una mayúscula, un número y un símbolo (!@#$%^&*_=+-)
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Términos y condiciones</label>
                  <textarea class="form-control registro-terms opacity-75" id="terms_conditions" rows="6" readonly>
Al utilizar nuestra aplicación web progresiva "Anestesia UACh", aceptas los siguientes términos y condiciones:

1. Al registrarte en nuestra aplicación, autorizas al Administrador a recopilar y utilizar tu información personal, incluyendo tu nombre y dirección de correo electrónico, para fines de manejo interno del sitio y para conocimiento exclusivo de los internos, residentes y staff de Anestesia de la Universidad Austral de Chile.

2. Tu información personal no será compartida con terceros sin tu consentimiento previo.

3. Nos comprometemos a mantener la privacidad y seguridad de tu información personal, y a utilizarla únicamente para fines relacionados con la administración de la aplicación web progresiva.

4. En cualquier momento, tienes derecho a solicitar el acceso a tu información personal, así como a solicitar la modificación o eliminación de dicha información.

5. Cualquier cambio en estos términos y condiciones será comunicado previamente, siendo efectivo inmediatamente después de su publicación en la aplicación.

6. Al utilizar nuestra aplicación, aceptas estos términos y condiciones y te comprometes a cumplir con todas las leyes y regulaciones aplicables.

Si tienes alguna pregunta o inquietud con respecto a estos términos y condiciones, no dudes en contactarnos.
                  </textarea>
                </div>

                <div class="pt-2">
                  <button type="submit" name="registro" class="btn btn-primary btn-lg registro-submit">
                    <i class="fa-solid fa-check-to-slot pe-2"></i>Registrar
                  </button>
                </div>
              </div>
            </div>

          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function mostrar() {
  var tipo = document.getElementById("pass_usuario");
  var icono = document.getElementById("icono");
  if(tipo.type == 'password') {
    tipo.type = 'text';
    icono.className = 'fa-solid fa-eye-slash';
  } else {
    tipo.type = 'password';
    icono.className = 'fa-solid fa-eye';
  }
}

function mostrar2() {
  var tipo2 = document.getElementById("pass_usuario2");
  var icono2 = document.getElementById("icono2");
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
