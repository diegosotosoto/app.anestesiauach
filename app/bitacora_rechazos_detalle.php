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
  $boton_toggler="<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='--bs-border-opacity: .1;' href='bitacora_rechazos.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
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
    margin-bottom:1rem;
  }

  .bitacora-card-header{
    background:linear-gradient(0deg, #fef2f2 0%, #ffffff 40%, #ffffff 100%);
    border-bottom:1px solid #f5c2c7;
    padding:1rem 1.1rem;
  }

  .bitacora-card-body{
    padding:1.1rem 1.1rem 1.2rem 1.1rem;
  }

  .bitacora-grid{
    display:grid;
    gap:.7rem;
  }

  .bitacora-item{
    display:flex;
    justify-content:space-between;
    gap:1rem;
    align-items:flex-start;
    background:#f8fafc;
    border:1px solid #dfe7f2;
    border-radius:.9rem;
    padding:.85rem 1rem;
  }

  .bitacora-item-label{
    color:#5f6b76;
    font-weight:500;
  }

  .bitacora-item-value{
    color:#1f2a37;
    font-weight:600;
    text-align:right;
  }

  .bitacora-block-title{
    font-size:.82rem;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#667085;
    margin-top:.7rem;
    margin-bottom:.45rem;
  }

  .bitacora-comments{
    background:#f8fafc;
    border:1px solid #dfe7f2;
    border-radius:.9rem;
    padding:1rem;
    white-space:pre-wrap;
    line-height:1.55;
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
            <div class="small opacity-75 mb-1">APP clínica • detalle de rechazos</div>
            <h1 class="h4 mb-2">Detalle de Bitácoras Rechazadas</h1>
            <div class="subtle text-white-50">Revisa los registros rechazados por un anestesiólogo específico y el feedback entregado para su corrección.</div>
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

<?php
  $autor_b=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
  $staff_b=isset($_POST['nombre_staff']) ? $_POST['nombre_staff'] : '';

  if($staff_b){
    echo "<div class='bitacora-card'>
            <div class='bitacora-card-header'>
              <h5 class='mb-1 fw-bold'>Rechazos asociados a ".$staff_b."</h5>
            </div>
          </div>";
  }

  $con_users="SELECT * FROM `bitacora_proced` WHERE `aprobado_staff_b` = '3' AND `autor_b` = '$autor_b' AND `staff_b` = '$staff_b' ";
  $tab_users=$conexion->query($con_users);
  $sin_bitacoras1=mysqli_num_rows($tab_users);

  if($sin_bitacoras1==0){
    echo "<div class='bitacora-card'><div class='bitacora-card-body'><div class='empty-state'>No se encontraron rechazos para este staff.</div></div></div>";
  }

  while($row_user=$tab_users->fetch_assoc()){
    $eco = ($row_user['invasivo_eco_b']=="1") ? "Sí" : "No";

    $string_rut = $row_user['rut_b'];
    $parts = explode("-", $string_rut);
    $result_rut = $parts[0];

    echo "<div class='bitacora-card'>";
    echo "<div class='bitacora-card-header'>";
    echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
    echo "<div><div class='small text-muted'>Registro rechazado</div><h5 class='mb-1'>".$row_user['fecha_b']."</h5></div>";
    echo "<div class='text-md-end'>
            <div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/0/".$result_rut."' target='_blank'>".$row_user['rut_b']."</a></div>
            <div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/1/".$row_user['ficha_b']."' target='_blank'>".$row_user['ficha_b']."</a></div>
          </div>";
    echo "</div></div>";

    echo "<div class='bitacora-card-body'><div class='bitacora-grid'>";
    $items = [
      ['Edad',$row_user['edad_b']],
      ['Procedimiento',$row_user['procedimiento_b']],
      ['Vía Aérea',$row_user['via_aerea_b']],
      ['Manejo VAD',$row_user['vad_b']],
      ['Acceso Vascular',$row_user['acceso_vascular_b']],
      ['Uso de Eco',$eco],
      ['P. Invasivo',$row_user['invasivo_b']],
      ['A. Venoso Central',$row_user['cvc_b']],
      ['A. Neuroaxial',$row_user['neuroaxial_b']],
      ['A. Regional',$row_user['regional_b']],
      ['P. Dolor',$row_user['dolor_b']],
    ];
    foreach($items as $it){
      echo "<div class='bitacora-item'><div class='bitacora-item-label'>{$it[0]}</div><div class='bitacora-item-value'>{$it[1]}</div></div>";
    }

    echo "<div class='bitacora-block-title'>Comentarios</div>";
    echo "<div class='bitacora-comments'>".$row_user['comentarios_b']."</div>";

    echo "<div class='bitacora-block-title'>Feedback</div>";
    echo "<div class='bitacora-comments'>".$row_user['feedback_b']."</div>";

    echo "</div></div></div>";
  }
?>

    </div>
  </div>
</div>

<?php
  require("footer.php");
?>
