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
$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Bitácora</span>";
$boton_navbar="<button class='btn shadow-sm border-light' style='--bs-border-opacity: .1;' type='submit' form='form_ingreso_bit' value='Submit'><div class='text-white'>Guardar</div></button>";

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
    padding:1.2rem 1.1rem 1.25rem 1.1rem;
  }

  .empty-state{
    text-align:center;
    color:#6c757d;
    padding:2rem 1rem;
  }
</style>

<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="bitacora-shell">

<?php
//Guarda la Bitácora
if($_POST['rut_b']){

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
  $staff_b=htmlentities(addslashes($_POST['staff_b']));
  $comentarios_b=htmlentities(addslashes($_POST['comentarios_b']));

  $consulta_b="INSERT INTO `bitacora_proced` (`autor_b`, `rut_b`, `ficha_b`, `edad_b`, `procedimiento_b`, `fecha_b`, `via_aerea_b`, `vad_b`, `acceso_vascular_b`, `invasivo_b`, `invasivo_eco_b`, `neuroaxial_b`, `regional_b`, `dolor_b`, `staff_b`, `comentarios_b`) VALUES ('$autor_b','$rut_b', '$ficha_b', '$edad_b', '$procedimiento_b', '$fecha_b', '$via_aerea_b', '$vad_b', '$acceso_vascular_b', '$invasivo_b', '$invasivo_eco_b', '$neuroaxial_b', '$regional_b', '$dolor_b', '$staff_b', '$comentarios_b') ";

  $escribir_b=$conexion->query($consulta_b);

  if($escribir_b==false){
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
          <div class='text-black-50 pb-2 pt-1' style='font-size: 14px'><?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?></div>
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
