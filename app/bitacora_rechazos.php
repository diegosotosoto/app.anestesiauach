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
  $boton_toggler="<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='--bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
  $titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
  $boton_navbar="<a></a><a></a>";

  //Carga Head de la página
  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

<style>
  .bitacora-shell{
    max-width:980px;
    margin:0 auto;
  }

  .bitacora-topbar{
    background:linear-gradient(135deg, #27458f, #3559b7);
    color:#fff;
    border-radius:1.25rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    padding:1.15rem 1.25rem;
    margin-bottom:1rem;
  }

  .bitacora-topbar h1{
    color:#fff;
  }

  .subtle{
    font-size:.92rem;
  }

  .pill{
    display:inline-block;
    padding:.25rem .6rem;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
  }

  .bitacora-tabs{
    margin-bottom:1rem;
  }

  .bitacora-tabs .nav-link{
    border-radius:.85rem;
    margin-right:.5rem;
    color:#3559b7;
  }

  .bitacora-tabs .nav-link.active{
    background:#3559b7;
    color:#fff;
    border-color:#3559b7;
  }

  .bitacora-tabs span.nav-link{
    display:block;
    cursor:default;
  }

  .bitacora-card{
    border:0;
    border-radius:1rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    background:#fff;
    overflow:hidden;
  }

  .bitacora-card-header{
    background:linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);
    border-bottom:1px solid #e9eef5;
    padding:1rem 1.1rem;
  }

  .bitacora-card-body{
    padding:1.1rem 1.1rem 1.2rem 1.1rem;
  }

  .rechazo-list{
    display:grid;
    gap:.8rem;
  }

  .rechazo-item{
    display:block;
    text-decoration:none;
    color:#1f2a37;
    background:#f8fafc;
    border:1px solid #dfe7f2;
    border-radius:1rem;
    padding:1rem 1rem;
    box-shadow:0 6px 18px rgba(33,55,98,.06);
    transition:transform .15s ease, box-shadow .15s ease, background-color .15s ease;
  }

  .rechazo-item:hover{
    transform:translateY(-1px);
    box-shadow:0 10px 22px rgba(33,55,98,.10);
    background:#ffffff;
    color:#1f2a37;
  }

  .rechazo-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:1rem;
    flex-wrap:wrap;
  }

  .rechazo-label{
    font-weight:700;
  }

  .rechazo-count{
    color:#3559b7;
    font-weight:700;
  }

  .empty-state{
    text-align:center;
    color:#6c757d;
    padding:1.2rem 1rem;
  }
</style>

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
