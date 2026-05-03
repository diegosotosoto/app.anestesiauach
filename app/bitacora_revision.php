<?php
//Ve si está activa la cookie o redirige al login
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
  header('Location: login.php');
}

//Conexión
require("conectar.php");
$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
$conexion->set_charset("utf8");

//redirección segun nivel de usuario
$check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
$con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
$users_b=$conexion->query($con_users_b);
$usuario=$users_b->fetch_assoc();
if($usuario['admin']==1){
  //CONTINUA EN LA PAGINA
} elseif ($usuario['staff_']==1) {
  //CONTINUA EN LA PAGINA
} elseif ($usuario['intern_']==1 or $usuario['becad_otro']==1) {
  header('Location: bitacora_internos.php');
} elseif ($usuario['becad_']==1) {
  header('Location: bitacora_ingreso.php');
}

//VARIABLES
$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Bitácora</span>";
$boton_navbar="<a></a>";

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
            <div class="small opacity-75 mb-1">APP clínica • revisión docente</div>
            <h1 class="h4 mb-2">Revisión de Bitácora</h1>
            <div class="subtle text-white-50">Selecciona un usuario para revisar sus registros y estadísticas de procedimientos.</div>
          </div>
          <span class="pill bg-light text-dark">Staff</span>
        </div>
      </div>

      <ul class="nav nav-tabs bitacora-tabs">
        <li class="nav-item">
          <a class="nav-link" href="bitacora_autoriza.php">Validación</a>
        </li>
        <li class="nav-item">
          <span class="nav-link active" aria-current="page">Revisión</span>
        </li>
      </ul>

      <div class="bitacora-entry-card">
        <div class="bitacora-entry-body">
          <form action='bitacora_estadistica.php' method='post'>
            <div class="bitacora-field-label">Becados de Anestesia</div>
            <div class="d-flex justify-content-between align-items-center gap-3 bitacora-inline">
              <select class="form-select bitacora-select" id="revision" name="revision" required>
                <option value=""></option>
                <?php
                  $con_users_b="SELECT `nombre_usuario`,`email_usuario` FROM `usuarios_dolor` WHERE `becad_` = '1' ";
                  $users_b=$conexion->query($con_users_b);

                  while ($usuari=$users_b->fetch_assoc()) {
                    echo "<option value='".htmlspecialchars($usuari['email_usuario'], ENT_QUOTES, 'UTF-8')."'>".app_h_text($usuari['nombre_usuario'])."</option>";
                  }
                ?>
              </select>
              <button class='btn btn-app-primary bitacora-action' type='submit' name='editar'>Revisar</button>
            </div>
          </form>
        </div>
      </div>

      <div class="bitacora-entry-card">
        <div class="bitacora-entry-body">
          <form action='bitacora_estad_i.php' method='post'>
            <div class="bitacora-field-label">Internos y Otros Becados</div>
            <div class="d-flex justify-content-between align-items-center gap-3 bitacora-inline">
              <select class="form-select bitacora-select" id="revision_i" name="revision_i" required>
                <option value=""></option>
                <?php
                  $con_users_b="SELECT `nombre_usuario`,`email_usuario` FROM `usuarios_dolor` WHERE `intern_` = '1' OR `becad_otro` = '1' ";
                  $users_b=$conexion->query($con_users_b);

                  while ($usuari=$users_b->fetch_assoc()) {
                    echo "<option value='".htmlspecialchars($usuari['email_usuario'], ENT_QUOTES, 'UTF-8')."'>".app_h_text($usuari['nombre_usuario'])."</option>";
                  }
                ?>
              </select>
              <button class='btn btn-app-primary bitacora-action' type='submit' name='editar'>Revisar</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>
