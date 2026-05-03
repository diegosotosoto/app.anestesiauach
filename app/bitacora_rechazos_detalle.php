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
  $boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='bitacora_rechazos.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
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
  $staff_b=isset($_POST['staff_email']) ? trim($_POST['staff_email']) : (isset($_POST['nombre_staff']) ? trim($_POST['nombre_staff']) : '');
  $staff_b=$conexion->real_escape_string($staff_b);
  $staff_label=$staff_b;
  if($staff_b){
    $consulta_staff="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$staff_b' LIMIT 1";
    $confirma_staff=$conexion->query($consulta_staff);
    if($confirma_staff && $row_staff=$confirma_staff->fetch_assoc()){
      $staff_label=app_h_text($row_staff['nombre_usuario']);
    }else{
      $staff_label=htmlspecialchars($staff_b, ENT_QUOTES, 'UTF-8');
    }
  }

  if($staff_b){
    echo "<div class='bitacora-card'>
            <div class='bitacora-card-header bitacora-card-header-danger'>
              <h5 class='mb-1 fw-bold'>Rechazos asociados a ".$staff_label."</h5>
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
    echo "<div class='bitacora-card-header bitacora-card-header-danger'>";
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
