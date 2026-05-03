<?php

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


        <div class="about-card about-welcome-card mb-3">

          <div class="about-welcome-body">
            <div class="about-section-title text-center">Registro</div>

            <h2 class="about-welcome-title">
              Registra una nueva cuenta
            </h2>

            <div class="about-title-line"></div>

            <p class="about-welcome-text">
              Regístrate para solicitar acceso. Tu cuenta debe ser validada por un administrador antes del primer ingreso.
            </p>

            <div class="about-feature-grid">

              <div class="about-feature-card">
                <i class="fa-solid fa-envelope"></i>
                <div>
                  <strong>Correo</strong>
                  <span>Enviaremos un correo a tu email para verificarlo</span>
                </div>
              </div>

              <div class="about-feature-card">
                <i class="fa-solid fa-key"></i>
                <div>
                  <strong>Contraseña</strong>
                  <span>Algunos modulos al interior del sitio contienen información sensible de pacientes, lo que requiere autenticación con contraseña</span>
                </div>
              </div>

            </div>

          </div>
        </div>


        <form class="needs-validation" action="login.php" method="post" novalidate autocomplete="off" oninput='pass_usuario2.setCustomValidity(pass_usuario2.value != pass_usuario.value ? "Passwords do not match." : "")'>
          <section class="about-card login-panel-card mb-3">
            <div class="login-card-body">

                <div class="mb-3">
                  <label class="form-label text-muted">Nombre y apellido</label>
                  <div class="input-group">
                    <input type="text" name="nombre_usuario" class="form-control login-input" pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' required>
                    <span class="input-group-text app-input-addon login-addon"><i class="fa fa-user"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">E-Mail</label>
                  <div class="input-group">
                    <input type="email" name="email_usuario" class="form-control login-input" required>
                    <span class="input-group-text app-input-addon login-addon"><i class="fa fa-envelope"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Contraseña</label>
                  <div class="input-group">
                    <input type="password" name="pass_usuario" id="pass_usuario" class="form-control login-input" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$" aria-describedby="button-addon2">
                    <button class="btn login-toggle" type="button" id="button-addon2" onclick="mostrar()"><i id="icono" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text app-input-addon login-addon"><i class="fa fa-key"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Repetir contraseña</label>
                  <div class="input-group">
                    <input type="password" name="pass_usuario2" id="pass_usuario2" class="form-control login-input" required aria-describedby="button-addon">
                    <button class="btn login-toggle" type="button" id="button-addon" onclick="mostrar2()"><i id="icono2" class="fa-solid fa-eye"></i></button>
                    <span class="input-group-text app-input-addon login-addon"><i class="fa fa-key"></i></span>
                    <div class="invalid-feedback pt-1">
                      Las contraseñas deben coincidir...
                    </div>
                  </div>
                </div>

                <div class="auth-helper auth-full">
                  Contraseña de 8 a 12 caracteres, incluyendo una mayúscula, un número y un símbolo (!@#$%^&*_=+-)
                </div>
                <div class="py-3"></div>
                <div class="mb-3 auth-full">            <div class="about-closing">
                  <strong>Términos y condiciones</strong></div>
                  <textarea class="form-control auth-terms opacity-75" id="terms_conditions" rows="6" readonly>
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

                <div class="pt-3 text-center auth-full">
                  <button type="submit" name="registro" class="btn btn-app-primary login-submit">
                    <i class="fa-solid fa-check-to-slot pe-2"></i>Registrar
                  </button>
                </div>
              </div>
            </div>
          </section>
        </form>

        </div>
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
