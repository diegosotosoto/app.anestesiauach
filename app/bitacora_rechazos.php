<?php
  //Conexión
  require("conectar.php");
  require_once __DIR__ . '/app_security.php';
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");

  app_require_login($conexion, 'login.php');

  //redirección segun nivel de usuario: BECADO
  $usuario = app_current_user($conexion);
  if(!$usuario){
    header('Location: login.php');
    exit;
  }

  if($usuario['external_']==1){
    header('Location: index.php');
    exit;
  }

  if($usuario['admin']==1){
    header('Location: bitacora_autoriza.php');
  } elseif ($usuario['staff_']==1) {
    header('Location: bitacora_autoriza.php');
  } elseif ($usuario['intern_']==1 or $usuario['becad_otro']==1) {
    header('Location: bitacora_internos.php');
  } elseif ($usuario['becad_']==1) {
    //CONTINUA EN LA PAGINA
  }

  //Variables
  $boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
  $boton_navbar="<a></a><a></a>";

  //Carga Head de la página
  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="bitacora-shell">

      <div class="bitacora-topbar">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • seguimiento personal</div>
            <h1 class="h4 mb-2">Rechazos de Bitácora</h1>
            <div class="subtle text-white-50">Revisa qué anestesiólogos han rechazado registros y accede al detalle para corregirlos.</div>
          </div>
          <span class="pill bg-light text-dark">Becado</span>
        </div>
      </div>

      <ul class="nav nav-tabs bitacora-tabs">
        <li class="nav-item">
          <a class="nav-link" href="bitacora_ingreso.php">Ingreso</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
        </li>
        <li class="nav-item">
          <span class="nav-link active" aria-current="page">Rechazos</span>
        </li>
      </ul>

      <div class="bitacora-card">
        <div class="bitacora-card-header">
          <div>
            <h5 class='mb-2 fw-bold'>Rechazos y Pendientes de</h5>
            <div class="d-flex align-items-center gap-3">
              <?php
                $icono_usuario = function_exists('app_render_user_inline_icon') ? app_render_user_inline_icon($usuario, 'app-inline-user-icon-large') : '<div class="staff-option-avatar" style="background:#10b981;"><i class="fa-solid fa-graduation-cap"></i></div>';
                // Forzar tamaño grande con estilos inline directamente en el elemento i
                $icono_usuario = str_replace('style="background:', 'style="width:64px!important;height:64px!important;font-size:1.8rem!important;background:', $icono_usuario);
                $nombre_usuario = function_exists('app_h_text') ? app_h_text($usuario['nombre_usuario']) : htmlspecialchars(html_entity_decode((string)$usuario['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8');
              ?>
              <div class="correo-name fs-3"><?php echo $icono_usuario . '<span class="fw-bold">' . $nombre_usuario . '</span>'; ?></div>
            </div>
          </div>
        </div>

        <div class="bitacora-card-body">
          <div class="rechazo-list">
            <?php
              $autor_b=$app_current_user['email_usuario'];

              $con_users="SELECT bp.`autor_b`, bp.`staff_b`, bp.`aprobado_staff_b`, COUNT(bp.`staff_b`) AS `cantidad`, u.`nombre_usuario` AS `staff_nombre`
                          FROM `bitacora_proced` bp
                          LEFT JOIN `usuarios_dolor` u
                            ON u.`email_usuario` = bp.`staff_b`
                          WHERE bp.`autor_b` = '$autor_b' AND (bp.`aprobado_staff_b` = 3 OR bp.`aprobado_staff_b` = 0)
                          GROUP BY bp.`autor_b`, bp.`staff_b`, bp.`aprobado_staff_b`, u.`nombre_usuario`";

              $tab_users=$conexion->query($con_users);

              if ($tab_users->num_rows > 0) {
                $i=0;
                while ($row = $tab_users->fetch_assoc()) {
                  $staff_label = !empty($row["staff_nombre"]) ? app_h_text($row["staff_nombre"]) : htmlspecialchars($row["staff_b"], ENT_QUOTES, 'UTF-8');
                  $staff_email = htmlspecialchars($row["staff_b"], ENT_QUOTES, 'UTF-8');
                  $estado = $row["aprobado_staff_b"] == 3 ? 'rechazada' : 'pendiente';
                  $estado_label = $row["aprobado_staff_b"] == 3 ? 'Cantidad rechazada' : 'Cantidad pendiente';
                  $estado_class = $row["aprobado_staff_b"] == 3 ? 'rechazo-count' : 'pendiente-count';
                  echo "<form id='gest".$i."' action='bitacora_rechazos_detalle.php' method='post'>
                          <input type='hidden' name='staff_email' value='".$staff_email."'/>
                          <input type='hidden' name='estado' value='".$estado."'/>
                          <a href='#' onclick='envioForm".$i."(); return false;' class='rechazo-item not-overlay'>
                            <div class='rechazo-row'>
                              <div>
                                <div class='small text-muted'>Staff</div>
                                <div class='rechazo-label'>" . $staff_label . "</div>
                                <div class='small text-muted'>" . $staff_email . "</div>
                              </div>
                              <div class='text-end'>
                                <div class='small text-muted'>" . $estado_label . "</div>
                                <div class='".$estado_class."'>" . $row["cantidad"] . "</div>
                              </div>
                            </div>
                          </a>
                        </form>
                        <script>
                          function envioForm".$i."() {
                            document.getElementById('gest".$i."').submit();
                          }
                        </script>";
                  $i++;
                }
              } else {
                echo "<div class='empty-state'>No se encontraron rechazos ni pendientes registrados.</div>";
              }
            ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
  require("footer.php");
?>
