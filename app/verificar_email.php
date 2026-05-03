<?php

  $boton_toggler="<button class='navbar-toggler app-nav-toggle' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'><i class='fa-solid fa-bars'></i></button>";
  $titulo_navbar="<div class='app-navbar-brand app-navbar-brand-compact'><img src='images/austral.png' alt='Universidad Austral de Chile' />Anestesia <small>UACh</small></div>";
  $boton_navbar="<a class='d-sm-block d-sm-none app-nav-action' href='acerca_de.php' aria-label='Acerca de'><i class='fa-solid fa-question'></i></a>";

  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">
        <div class="login-shell">

<?php
  $token_rec = $_GET['962eb831a0df54562eb40fed6bf13b'] ?? '';
  $token_activ = $_GET['89cd7e5e18f25d8e1214f1d8f273da'] ?? '';
  $email_usuario_rec = $_GET['a52f7597ca4d6c24937711a66fd058'] ?? '';
  $estado_titulo = 'Verificación';
  $estado_icono = 'fa-circle-exclamation';
  $estado_mensaje = 'El enlace de verificación no es válido. Solicita un nuevo registro o contacta al administrador.';
  $estado_accion = '<a class="btn btn-app-primary login-submit" href="nueva_cuenta.php"><i class="fa-solid fa-user-plus pe-2"></i>Crear nueva cuenta</a>';

  if($token_rec && $email_usuario_rec){
    $email_usuario_db = $conexion->real_escape_string($email_usuario_rec);
    $token_rec_db = $conexion->real_escape_string($token_rec);

    $chequea_tokens="SELECT `token_rec`,`token_activ`,`token_hr`,`verified` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario_db' LIMIT 1";
    $result_chk=$conexion->query($chequea_tokens);
    $cheqtok=$result_chk ? $result_chk->fetch_assoc() : null;

    if($cheqtok){
      $chk_token_rec=$cheqtok['token_rec'] ?? '';
      $chk_token_activ=$cheqtok['token_activ'] ?? '';
      $chk_token_hr=$cheqtok['token_hr'] ?? '';
      $hora_limite=$chk_token_hr ? $chk_token_hr + 86400 : 0;
      $hora_actual=time();

      if($chk_token_rec==$token_rec_db && $chk_token_activ==1 && $hora_limite>$hora_actual){
        $consulta_final="UPDATE `usuarios_dolor` SET `token_rec`='', `token_activ`='0', `token_hr`='' WHERE `email_usuario`='$email_usuario_db'";
        $conexion->query($consulta_final);
        $estado_titulo = 'Correo verificado';
        $estado_icono = 'fa-circle-check';
        $estado_mensaje = 'Tu correo fue verificado correctamente. Ahora tu cuenta queda pendiente de validación por un administrador antes del primer ingreso.';
        $estado_accion = '<a class="btn btn-app-primary login-submit" href="login.php"><i class="fa-solid fa-right-to-bracket pe-2"></i>Ir a ingreso</a>';
      } else {
        $estado_titulo = 'Enlace expirado';
        $estado_mensaje = 'El enlace de verificación expiró o ya fue utilizado. Si necesitas acceso, vuelve a registrarte o contacta al administrador.';
      }
    }
  }
?>

          <section class="about-card login-panel-card mb-3">
            <div class="login-card-body">
              <div class="login-section-title"><?php echo $estado_titulo; ?></div>
              <div class="login-form-box text-center">
                <div class="auth-status-icon auth-full">
                  <i class="fa-solid <?php echo $estado_icono; ?>"></i>
                </div>
                <p class="auth-helper auth-full py-3 mb-0">
                  <?php echo htmlspecialchars($estado_mensaje); ?>
                </p>
                <div class="pt-3 text-center auth-full">
                  <?php echo $estado_accion; ?>
                </div>
              </div>
            </div>
          </section>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
  require("footer.php");
?>
