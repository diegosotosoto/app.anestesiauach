<?php

  //Conexión
  require("conectar.php");
  require_once __DIR__ . "/app_text_helpers.php";
  require_once __DIR__ . "/app_security.php";
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");

  if(app_is_authenticated($conexion)){
    header('Location: index.php');
    exit;
  }

  // Función para recrear notificación de Pacientes en Dolor si fue descartada
  function crearNotificacionPacientesDolorSiNecesaria($conexion, $usuario_id, $usuario_email) {
    // Verificar si hay notificación archivada de "Pacientes en Dolor" hoy
    $sql_check = "SELECT n.id
                  FROM notificaciones n
                  INNER JOIN notificacion_destinatarios nd ON n.id = nd.notificacion_id
                  WHERE nd.usuario_id = ?
                    AND n.titulo = 'Pacientes en Dolor'
                    AND DATE(n.fecha_inicio) = CURDATE()
                    AND nd.archivada = 1";

    $stmt_check = $conexion->prepare($sql_check);
    if (!$stmt_check) return false;

    $stmt_check->bind_param("i", $usuario_id);
    $stmt_check->execute();

    $fue_descartada = false;
    if (method_exists($stmt_check, 'get_result')) {
        $res_check = $stmt_check->get_result();
        if ($res_check->fetch_assoc()) {
            $fue_descartada = true;
        }
    } else {
        $stmt_check->bind_result($id_tmp);
        if ($stmt_check->fetch()) {
            $fue_descartada = true;
        }
    }
    $stmt_check->close();

    if (!$fue_descartada) return false; // No fue descartada, no recrear

    // Obtener todos los pacientes activos con sus días
    $sql_pacientes = "SELECT nombre_paciente, rut, fecha_creacion
                      FROM pacientes
                      WHERE de_alta = 0
                        AND fecha_creacion >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                      ORDER BY fecha_creacion DESC";

    $stmt = $conexion->prepare($sql_pacientes);
    if (!$stmt) return false;

    $stmt->execute();
    $pacientes = [];
    $dias_pacientes = [];

    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $pacientes[] = $row;
        }
    } else {
        $stmt->bind_result($nombre_tmp, $rut_tmp, $fecha_tmp);
        while ($stmt->fetch()) {
            $pacientes[] = [
                'nombre_paciente' => $nombre_tmp,
                'rut' => $rut_tmp,
                'fecha_creacion' => $fecha_tmp
            ];
        }
    }
    $stmt->close();

    // Calcular días para cada paciente
    foreach ($pacientes as $paciente) {
        $fecha_creacion = new DateTime($paciente['fecha_creacion']);
        $fecha_actual = new DateTime();
        $diferencia = $fecha_creacion->diff($fecha_actual);
        $dias = $diferencia->days;
        if ($dias > 0) {
            $dias_pacientes[] = $dias;
        }
    }

    if (empty($dias_pacientes)) return false;

    $total_pacientes = count($dias_pacientes);
    sort($dias_pacientes);
    $dias_texto = implode(', ', $dias_pacientes);
    $mensaje = "Ingresaste {$total_pacientes} paciente(s) en Dolor hace {$dias_texto} día(s).";

    // Crear nueva notificación
    $titulo = "Pacientes en Dolor";
    $tipo = "info";
    $alcance = "individual";
    $url_destino = "hoja_dolor.php";
    $icono = "fa-solid fa-syringe";
    $fecha_inicio = date('Y-m-d H:i:s');
    $fecha_fin = null;
    $publicada = 1;

    $stmt_notif = $conexion->prepare("
        INSERT INTO `notificaciones`
        (`titulo`,`mensaje`,`tipo`,`alcance`,`grupo_destino`,`url_destino`,`icono`,`creada_por`,`publicada`,`fecha_inicio`,`fecha_fin`)
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?)
    ");

    if (!$stmt_notif) return false;

    $stmt_notif->bind_param(
        "sssssssiiss",
        $titulo,
        $mensaje,
        $tipo,
        $alcance,
        null,
        $url_destino,
        $icono,
        $usuario_id,
        $publicada,
        $fecha_inicio,
        $fecha_fin
    );

    if (!$stmt_notif->execute()) {
        $stmt_notif->close();
        return false;
    }

    $notificacion_id = $stmt_notif->insert_id;
    $stmt_notif->close();

    // Asignar notificación al usuario
    $stmt_dest = $conexion->prepare("
        INSERT INTO `notificacion_destinatarios` (`notificacion_id`,`usuario_id`)
        VALUES (?,?)
    ");

    if (!$stmt_dest) return false;

    $stmt_dest->bind_param("ii", $notificacion_id, $usuario_id);
    $stmt_dest->execute();
    $stmt_dest->close();

    return true;
  }

  $alerta_login = "";
  $google_client_id = "";
  $google_config_path = __DIR__ . "/secure_config/google_login_config.php";
  if(file_exists($google_config_path)){
    require_once $google_config_path;
    if(defined('APP_GOOGLE_CLIENT_ID')){
      $google_client_id = trim((string)APP_GOOGLE_CLIENT_ID);
    }
  }

  if(!empty($_GET['google_error'])){
    $alerta_login = "<div class='alert alert-danger alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> No fue posible iniciar sesión con Google. Intenta nuevamente o contacta al administrador.
    </div>";
  }

  //LOGIN NORMAL DE USUARIO YA REGISTRADO
  if(!empty($_POST['email_usuario_v'])){
    $email_usuario_v=htmlentities(addslashes($_POST['email_usuario_v']));
    $pass_usuario_v=htmlentities(addslashes($_POST['pass_usuario_v']));

    $sql="SELECT `ID`,`password`,`nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario_v' AND `verified`= '1'";
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
        app_set_auth_session_for_email($conexion, $galletita_mail);

        // Recrear notificación de Pacientes en Dolor si fue descartada anteriormente
        crearNotificacionPacientesDolorSiNecesaria($conexion, $usuario['ID'], $email_usuario_v);

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
    $nombre_usuario_raw=app_decode_text($_POST['nombre_usuario']);
    // Convertir nombre a minúsculas con primera letra mayúscula
    $nombre_usuario=mb_convert_case(mb_strtolower($nombre_usuario_raw, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    $nombre_usuario=$conexion->real_escape_string($nombre_usuario);
    $pass_usuario=htmlentities(addslashes($_POST['pass_usuario']));
    $pass_cifrado=password_hash($pass_usuario, PASSWORD_DEFAULT);

    // Obtener icono seleccionado
    $ui_icono=isset($_POST['ui_icono']) ? htmlentities(addslashes($_POST['ui_icono'])) : 'fa-user-doctor';
    $ui_icono_color=isset($_POST['ui_icono_color']) ? htmlentities(addslashes($_POST['ui_icono_color'])) : 'green';

    // Verificar si las columnas UI existen
    $columna_ui_icono_existe=false;
    $columna_ui_icono_color_existe=false;
    $res_columnas=$conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE 'ui_icono'");
    if($res_columnas && $res_columnas->num_rows > 0){
      $columna_ui_icono_existe=true;
    }
    $res_columnas2=$conexion->query("SHOW COLUMNS FROM `usuarios_dolor` LIKE 'ui_icono_color'");
    if($res_columnas2 && $res_columnas2->num_rows > 0){
      $columna_ui_icono_color_existe=true;
    }

    $chequea_email="SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario'";
    $result=$conexion->query($chequea_email);
    $conteo=mysqli_num_rows($result);

    if($conteo==0){
      // Construir INSERT según las columnas disponibles
      if($columna_ui_icono_existe && $columna_ui_icono_color_existe){
        $nuevo_usuario="INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`, `verified_email`, `ui_icono`, `ui_icono_color`) VALUES ('$nombre_usuario','$email_usuario','$pass_cifrado','0','$ui_icono','$ui_icono_color')";
      }elseif($columna_ui_icono_existe){
        $nuevo_usuario="INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`, `verified_email`, `ui_icono`) VALUES ('$nombre_usuario','$email_usuario','$pass_cifrado','0','$ui_icono')";
      }elseif($columna_ui_icono_color_existe){
        $nuevo_usuario="INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`, `verified_email`, `ui_icono_color`) VALUES ('$nombre_usuario','$email_usuario','$pass_cifrado','0','$ui_icono_color')";
      }else{
        $nuevo_usuario="INSERT INTO `usuarios_dolor` (`nombre_usuario`, `email_usuario`, `password`, `verified_email`) VALUES ('$nombre_usuario','$email_usuario','$pass_cifrado','0')";
      }
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

      <?php if($google_client_id !== ''){ ?>
        <div class="auth-helper auth-full text-center pt-3 pb-2">o ingresa con Google</div>
        <div class="google-login-wrap">
          <div id="g_id_onload"
              data-client_id="<?= htmlspecialchars($google_client_id, ENT_QUOTES, 'UTF-8') ?>"
              data-context="signin"
              data-ux_mode="popup"
              data-login_uri="google_login_callback.php"
              data-auto_prompt="false">
          </div>
          <div class="g_id_signin"
              data-type="standard"
              data-shape="pill"
              data-theme="outline"
              data-text="signin_with"
              data-size="large"
              data-logo_alignment="left">
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
          </form>

          <?php if($google_client_id !== ''){ ?>
            <script src="https://accounts.google.com/gsi/client" async defer></script>
          <?php } ?>

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
