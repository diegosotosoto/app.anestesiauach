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
                  <label class="form-label text-muted pb-0 mb-0">Nombre y Apellido</label><div class="auth-helper auth-full">(Como aparecerá en registro oficial de la App)</div> 
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
                    <input type="password" name="pass_usuario" id="pass_usuario" class="form-control login-input" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,50}$" aria-describedby="button-addon2">
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
                  Contraseña mayor de 8 caracteres, incluyendo una mayúscula, un número y un símbolo (!@#$%^&*_=+-)
                </div>
                <div class="py-3"></div>

                <div class="mb-4 auth-full">
                  <div class="about-closing">
                    <strong>Icono de usuario</strong>
                  </div>
                  <p class="text-muted small">Elige el icono y color que se mostrará en tu perfil.</p>
                  
                  <div class="ui-avatar-picker">
                    <div id="uiAvatarPreview" class="ui-avatar-preview" style="background: #2e9b55;">
                      <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    
                    <div class="ui-avatar-options">
                      <div class="ui-avatar-group" role="radiogroup" aria-label="Icono de usuario">
                        <?php
                        $iconos_opciones = ['fa-user', 'fa-user-astronaut', 'fa-user-doctor', 'fa-user-graduate', 'fa-user-ninja', 'fa-user-tie', 'fa-person-dress', 'fa-snowman', 'fa-head-side-mask', 'fa-skull', 'fa-poo', 'fa-user-secret', 'fa-brain', 'fa-ghost', 'fa-cat', 'fa-dog', 'fa-spider', 'fa-horse-head'];
                        foreach ($iconos_opciones as $icono_opcion): ?>
                          <label class="ui-avatar-square">
                            <input type="radio" name="ui_icono" value="<?= htmlspecialchars($icono_opcion) ?>" <?= $icono_opcion === 'fa-user-doctor' ? 'checked' : '' ?>>
                            <span><i class="fa-solid <?= htmlspecialchars($icono_opcion) ?>"></i></span>
                          </label>
                        <?php endforeach; ?>
                      </div>

                      <div class="ui-color-group" role="radiogroup" aria-label="Color del icono de usuario">
                        <?php
                        $colores_opciones = [
                          'blue' => '#1f5fbf',
                          'green' => '#2e9b55',
                          'red' => '#ce2e2e',
                          'yellow' => '#d4a900',
                          'orange' => '#ff5a00',
                          'purple' => '#6405d0',
                          'teal' => '#29a09b',
                          'pink' => '#d9027d',
                          'cyan' => '#0ea5e9',
                          'indigo' => '#f9a8d4',
                          'slate' => '#475569',
                          'black' => '#111827'
                        ];
                        foreach ($colores_opciones as $color_key => $color_hex): ?>
                          <label class="ui-color-square">
                            <input type="radio" name="ui_icono_color" value="<?= htmlspecialchars($color_key) ?>" data-color="<?= htmlspecialchars($color_hex) ?>" <?= $color_key === 'green' ? 'checked' : '' ?>>
                            <span style="background: <?= htmlspecialchars($color_hex) ?>;"></span>
                          </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="mb-3 auth-full">            
                  <div class="about-closing">
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

<style>
.ui-avatar-picker {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-top: .75rem;
    flex-direction: row;
}

.ui-avatar-options {
    display: grid;
    gap: .7rem;
    width: 100%;
}

.ui-avatar-group,
.ui-color-group {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .35rem;
}

.ui-avatar-square,
.ui-color-square {
    position: relative;
    width: 38px;
    height: 38px;
    cursor: pointer;
}

.ui-avatar-square input,
.ui-color-square input {
    position: absolute;
    opacity: 0;
    inset: 0;
}

.ui-avatar-square span,
.ui-color-square span {
    width: 38px;
    height: 38px;
    display: grid;
    place-items: center;
    border-radius: 7px;
    border: 2px solid rgba(15, 23, 42, .16);
    box-shadow: 0 1px 4px rgba(15, 23, 42, .12);
    transition: transform .15s ease, border-color .15s ease, box-shadow .15s ease;
}

.ui-avatar-square span {
    background: #f8fafc;
    color: #14345f;
    font-size: 1.15rem;
}

.ui-color-square span {
    color: #111827;
}

.ui-avatar-square input:checked + span,
.ui-color-square input:checked + span {
    border-color: #111827;
    box-shadow: 0 0 0 3px rgba(17, 24, 39, .18);
    transform: translateY(-1px);
}

.ui-color-square input:checked + span::after {
    content: "\f00c";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-size: 1.05rem;
    color: #111827;
    text-shadow: 0 1px 2px rgba(255, 255, 255, .45);
}

.ui-avatar-preview {
    width: 86px;
    height: 86px;
    aspect-ratio: 1/1;
    border-radius: 999px;
    display: grid;
    place-items: center;
    color: #ffffff;
    font-size: 2.6rem;
    box-shadow: 0 16px 30px rgba(15, 23, 42, .22);
    flex: 0 0 auto;
}

body.theme-dark .ui-avatar-square span {
    background: #0f172a;
    color: #dbeafe;
    border-color: rgba(147, 197, 253, .28);
}

body.theme-dark .ui-avatar-square input:checked + span,
body.theme-dark .ui-color-square input:checked + span {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(147, 197, 253, .2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('uiAvatarPreview');
    const iconInputs = document.querySelectorAll('input[name="ui_icono"]');
    const colorInputs = document.querySelectorAll('input[name="ui_icono_color"]');

    function updateAvatarPreview() {
        if (!preview) return;

        const selectedIcon = document.querySelector('input[name="ui_icono"]:checked');
        const selectedColor = document.querySelector('input[name="ui_icono_color"]:checked');
        const icon = selectedIcon ? selectedIcon.value : 'fa-user-doctor';
        const color = selectedColor ? selectedColor.dataset.color : '#2e9b55';

        preview.style.background = color;
        preview.innerHTML = '<i class="fa-solid ' + icon.replace(/[^a-z0-9-]/gi, '') + '"></i>';
    }

    iconInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });

    colorInputs.forEach(function(input) {
        input.addEventListener('change', updateAvatarPreview);
    });
});
</script>

<?php
  require("footer.php");
?>
