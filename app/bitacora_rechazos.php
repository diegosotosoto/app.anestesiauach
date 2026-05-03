<?php
  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
  }

  //Conexión
  require("conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");

  //redirección segun nivel de usuario: BECADO
  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
  $con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
  $users_b=$conexion->query($con_users_b);
  $usuario=$users_b->fetch_assoc();
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
          <h5 class='mb-1 fw-bold'>Rechazos de Bitácora</h5>
        </div>

        <div class="bitacora-card-body">
          <div class="rechazo-list">
            <?php
              $autor_b=$_COOKIE['hkjh41lu4l1k23jhlkj13'];

              $con_users="SELECT bp.`autor_b`, bp.`staff_b`, COUNT(bp.`staff_b`) AS `cantidad`, u.`nombre_usuario` AS `staff_nombre`
                          FROM `bitacora_proced` bp
                          LEFT JOIN `usuarios_dolor` u
                            ON u.`email_usuario` = bp.`staff_b`
                          WHERE bp.`autor_b` = '$autor_b' AND bp.`aprobado_staff_b` = 3
                          GROUP BY bp.`autor_b`, bp.`staff_b`, u.`nombre_usuario`";

              $tab_users=$conexion->query($con_users);

              if ($tab_users->num_rows > 0) {
                $i=0;
                while ($row = $tab_users->fetch_assoc()) {
                  $staff_label = !empty($row["staff_nombre"]) ? app_h_text($row["staff_nombre"]) : htmlspecialchars($row["staff_b"], ENT_QUOTES, 'UTF-8');
                  $staff_email = htmlspecialchars($row["staff_b"], ENT_QUOTES, 'UTF-8');
                  echo "<form id='gest".$i."' action='bitacora_rechazos_detalle.php' method='post'>
                          <input type='hidden' name='staff_email' value='".$staff_email."'/>
                          <a href='#' onclick='envioForm".$i."(); return false;' class='rechazo-item not-overlay'>
                            <div class='rechazo-row'>
                              <div>
                                <div class='small text-muted'>Staff</div>
                                <div class='rechazo-label'>" . $staff_label . "</div>
                                <div class='small text-muted'>" . $staff_email . "</div>
                              </div>
                              <div class='text-end'>
                                <div class='small text-muted'>Cantidad rechazada</div>
                                <div class='rechazo-count'>" . $row["cantidad"] . "</div>
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
                echo "<div class='empty-state'>No se encontraron rechazos registrados.</div>";
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
