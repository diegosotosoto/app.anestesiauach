<?php
//Ve si está activa la cookie o redirige al login
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
  header('Location: login.php');
}
//Conexión
require("conectar.php");
$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
$conexion->set_charset("utf8");

//VARIABLES
$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Bitácora</span>";
$boton_navbar="<button class='btn btn-app-primary navbar-save-btn' type='submit' form='form_ingreso_bit' value='Submit'>Guardar</button>";

//Carga Head de la página
require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="bitacora-shell">

<?php
function lista_bitacoras_resuelve_staff_email($conexion, $staff_raw){
  $staff_raw = trim((string)$staff_raw);
  if($staff_raw === ''){
    return '';
  }

  if(filter_var($staff_raw, FILTER_VALIDATE_EMAIL)){
    return $conexion->real_escape_string($staff_raw);
  }

  $res = $conexion->query("SELECT `nombre_usuario`, `email_usuario` FROM `usuarios_dolor` WHERE `staff_` = 1 OR `admin` = 1");
  if($res){
    while($fila = $res->fetch_assoc()){
      $nombre = function_exists('app_decode_text') ? app_decode_text($fila['nombre_usuario']) : html_entity_decode($fila['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
      if(trim($nombre) === $staff_raw){
        return $conexion->real_escape_string($fila['email_usuario']);
      }
    }
  }

  return '';
}

//Guarda la Bitácora
if(isset($_POST['rut_b']) && $_POST['rut_b'] !== ''){

  $autor_b=strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj13']));
  $rut_b=htmlentities(addslashes(strtoupper($_POST['rut_b'])));
  $ficha_b=htmlentities(addslashes($_POST['ficha_b']));
  $edad_b=htmlentities(addslashes($_POST['edad_b']));
  $procedimiento_b=htmlentities(addslashes($_POST['procedimiento_b']));
  $fecha_b=htmlentities(addslashes($_POST['fecha_b']));
  $via_aerea_b=htmlentities(addslashes($_POST['via_aerea_b']));
  $vad_b=htmlentities(addslashes($_POST['vad_b']));
  $acceso_vascular_b=htmlentities(addslashes($_POST['acceso_vascular_b']));
  $invasivo_b=htmlentities(addslashes($_POST['invasivo_b']));

  if($_POST['invasivo_eco_b']=="1"){
    $invasivo_eco_b="1";
  }else{
    $invasivo_eco_b="0";
  }

  $neuroaxial_b=htmlentities(addslashes($_POST['neuroaxial_b']));
  $regional_b=htmlentities(addslashes($_POST['regional_b']));
  $dolor_b=htmlentities(addslashes($_POST['dolor_b']));
  $staff_b=lista_bitacoras_resuelve_staff_email($conexion, $_POST['staff_b'] ?? '');
  $comentarios_b=htmlentities(addslashes($_POST['comentarios_b']));

  if($staff_b === ''){
    echo "<div class='alert alert-danger alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> Selecciona un anestesiólogo responsable válido.
    </div>";
  }else{
    $consulta_b="INSERT INTO `bitacora_proced` (`autor_b`, `rut_b`, `ficha_b`, `edad_b`, `procedimiento_b`, `fecha_b`, `via_aerea_b`, `vad_b`, `acceso_vascular_b`, `invasivo_b`, `invasivo_eco_b`, `neuroaxial_b`, `regional_b`, `dolor_b`, `staff_b`, `comentarios_b`) VALUES ('$autor_b','$rut_b', '$ficha_b', '$edad_b', '$procedimiento_b', '$fecha_b', '$via_aerea_b', '$vad_b', '$acceso_vascular_b', '$invasivo_b', '$invasivo_eco_b', '$neuroaxial_b', '$regional_b', '$dolor_b', '$staff_b', '$comentarios_b') ";

    $escribir_b=$conexion->query($consulta_b);

    if($escribir_b==false){
      error_log("lista_bitacoras insert bitacora_proced: ".$conexion->error);
      echo "<div class='alert alert-danger alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
      </div>";
    }else{
      echo "<div class='alert alert-success alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Info!</strong> Registro Guardado.
      </div>";
    }
  }
}
?>

      <div class="bitacora-topbar">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • listado de registros</div>
            <h1 class="h4 mb-2">Lista de Bitácoras</h1>
            <div class="subtle text-white-50">Vista contenedora para futuros registros, listados o filtros del módulo de bitácora.</div>
          </div>
          <span class="pill bg-light text-dark">Bitácora</span>
        </div>
      </div>

      <ul class="nav nav-tabs bitacora-tabs">
        <li class="nav-item">
          <span class="nav-link active" aria-current="page">Ingreso</span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
        </li>
      </ul>

      <div class="bitacora-card">
        <div class="bitacora-card-header">
          <h4 class='mb-1 fw-bold pt-2'>Bitácora de</h4>
          <div class='text-black-50 pb-2 pt-1 bitacora-muted-small'><?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?></div>
        </div>

        <div class="bitacora-card-body">
          <div class="empty-state">
            Esta vista no contiene aún listado o contenido funcional visible.<br>
            El formato ya quedó homologado con el resto del módulo.
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>
