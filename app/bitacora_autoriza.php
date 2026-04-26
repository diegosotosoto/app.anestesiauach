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
  // CONTINUA
} elseif ($usuario['staff_']==1) {
  // CONTINUA
} elseif ($usuario['intern_']==1 or $usuario['becad_otro']==1) {
  header('Location: bitacora_internos.php');
} elseif ($usuario['becad_']==1) {
  header('Location: bitacora_ingreso.php');
}

//VARIABLES
$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Bitácora</span>";
$boton_navbar="<a></a>";

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

  .bitacora-section-card,
  .bitacora-entry-card{
    border:0;
    border-radius:1rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    background:#fff;
  }

  .bitacora-section-card{
    margin-bottom:1rem;
  }

  .bitacora-section-header{
    background:linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);
    border-bottom:1px solid #e9eef5;
    padding:1rem 1.1rem;
    border-radius:1rem 1rem 0 0;
  }

  .bitacora-entry-card{
    margin-bottom:1rem;
    overflow:hidden;
  }

  .bitacora-entry-header{
    background:#eef4ff;
    padding:1rem 1.1rem;
    border-bottom:1px solid #dfe7f2;
  }

  .bitacora-entry-header-danger{
    background:#fef2f2;
    border-bottom:1px solid #f5c2c7;
  }

  .bitacora-entry-body{
    padding:1rem 1.1rem 1.15rem 1.1rem;
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

  .bitacora-comments{
    background:#f8fafc;
    border:1px solid #dfe7f2;
    border-radius:.9rem;
    padding:1rem;
    white-space:pre-wrap;
  }

  .bitacora-feedback-label{
    font-size:.82rem;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#667085;
    margin-bottom:.55rem;
  }

  .bitacora-feedback{
    border-radius:.9rem;
    border:1px solid #dfe7f2;
    resize:none;
  }

  .bitacora-actions{
    display:flex;
    gap:.75rem;
    justify-content:space-between;
    flex-wrap:wrap;
    margin-top:1rem;
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
//Guarda la Bitácora para becado
if(!empty($_POST['bitacora_autoriza'])){
  $submit_b = (int)$_POST['submit_b'];
  $id_b = (int)$_POST['bitacora_autoriza'];

  $consulta_us="UPDATE `bitacora_proced` SET `aprobado_staff_b`='$submit_b' WHERE `id_b`='$id_b'";
  $escribir_us=$conexion->query($consulta_us);

  if(!empty($_POST['comentarios_b_a'])){
    $comentario_b_a = $conexion->real_escape_string($_POST['comentarios_b_a']);
    $nombre_feedback = $conexion->real_escape_string(app_decode_text($_COOKIE['hkjh41lu4l1k23jhlkj14']));
    $feedback_b = $nombre_feedback.": ".$comentario_b_a;
    $consulta_fb="UPDATE `bitacora_proced` SET `feedback_b`= '$feedback_b' WHERE `id_b`='$id_b'";
    $escribir_fb=$conexion->query($consulta_fb);
  }

  if($escribir_us==false){
    echo "<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Info!</strong> Error en el guardado. Contacta al administrador.</div>";
  }else if($submit_b==1){
    echo "<div class='alert alert-success alert-dismissible fade show'><button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Info!</strong> Bitácora autorizada.</div>";
  }else if($submit_b==3){
    echo "<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Info!</strong> Bitácora rechazada.</div>";
  }
}

//Guarda la Bitácora para interno
if(!empty($_POST['bitacora_autoriza_i'])){
  $submit_i = (int)$_POST['submit_i'];
  $id_i = (int)$_POST['bitacora_autoriza_i'];

  $consulta_usi="UPDATE `bitacora_internos` SET `aprobado_staff_i`='$submit_i' WHERE `id_i`='$id_i'";
  $escribir_usi=$conexion->query($consulta_usi);

  if(!empty($_POST['comentarios_i_a'])){
    $comentario_i_a = $conexion->real_escape_string($_POST['comentarios_i_a']);
    $nombre_feedback = $conexion->real_escape_string(app_decode_text($_COOKIE['hkjh41lu4l1k23jhlkj14']));
    $feedback_i = $nombre_feedback.": ".$comentario_i_a;
    $consulta_fbi="UPDATE `bitacora_internos` SET `feedback_i`= '$feedback_i' WHERE `id_i`='$id_i'";
    $escribir_fbi=$conexion->query($consulta_fbi);
  }

  if($escribir_usi==false){
    echo "<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Info!</strong> Error en el guardado. Contacta al administrador.</div>";
  }else if($submit_i==1){
    echo "<div class='alert alert-success alert-dismissible fade show'><button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Info!</strong> Bitácora autorizada.</div>";
  }else if($submit_i==3){
    echo "<div class='alert alert-danger alert-dismissible fade show'><button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Info!</strong> Bitácora rechazada.</div>";
  }
}
?>

      <div class="bitacora-topbar">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • validación docente</div>
            <h1 class="h4 mb-2">Validación de Bitácora</h1>
            <div class="subtle text-white-50">Autoriza o rechaza fichas ingresadas por becados e internos, con feedback escrito cuando corresponda.</div>
          </div>
          <span class="pill bg-light text-dark">Staff</span>
        </div>
      </div>

      <ul class="nav nav-tabs bitacora-tabs">
        <li class="nav-item">
          <span class="nav-link active" aria-current="page">Validación</span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_revision.php">Revisión</a>
        </li>
      </ul>

      <div class="bitacora-section-card">
        <div class="bitacora-section-header">
          <h4 class="mb-1 fw-bold">Validar Bitácora</h4>
          <div class="text-black-50" style="font-size:14px">Fichas pendientes de autorización o rechazo.</div>
        </div>
      </div>

<?php
$staff = $_COOKIE['hkjh41lu4l1k23jhlkj13'];
$staff = $conexion->real_escape_string($staff);

$con_users = "SELECT * FROM `bitacora_proced` WHERE `aprobado_staff_b` = '0' AND `staff_b` = '$staff'";
$tab_users = $conexion->query($con_users);
$sin_bitacoras1 = $tab_users ? mysqli_num_rows($tab_users) : 0;

$con_internos = "SELECT * FROM `bitacora_internos` WHERE `aprobado_staff_i` = '0' AND `staff_i` = '$staff'";
$tab_internos = $conexion->query($con_internos);
$sin_bitacoras2 = $tab_internos ? mysqli_num_rows($tab_internos) : 0;

if($sin_bitacoras1 == 0 && $sin_bitacoras2 == 0){
  echo "<div class='bitacora-entry-card'><div class='bitacora-entry-body'><div class='empty-state'>Sin elementos que validar.</div></div></div>";
}

//Bitácora de Becados
while($row_user=$tab_users->fetch_assoc()){
  $eco = ($row_user['invasivo_eco_b']=="1") ? "Sí" : "No";

  $email_int=$row_user['autor_b'];
  $consulta_int="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int' AND `verified` = '1'";
  $confirma_int=$conexion->query($consulta_int);
  $rows = $confirma_int->fetch_assoc();

  $modalId = "confirmarModalB".$row_user['id_b'];

  echo "<form action='bitacora_autoriza.php' method='post' class='bitacora-entry-card'>";
  echo "<div class='bitacora-entry-header'>";
  echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
  echo "<div><div class='small text-muted'>Becado</div><h5 class='mb-1'>".app_h_text($rows['nombre_usuario'])."</h5></div>";
  echo "<div class='text-md-end'><div>".$row_user['fecha_b']."</div><div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/0/".$row_user['rut_b']."' target='_blank'>".$row_user['rut_b']."</a></div><div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/1/".$row_user['ficha_b']."' target='_blank'>".$row_user['ficha_b']."</a></div></div>";
  echo "</div></div>";

  echo "<div class='bitacora-entry-body'><div class='bitacora-grid'>";
  $items = [
    ['Edad',$row_user['edad_b']],
    ['Procedimiento',$row_user['procedimiento_b']],
    ['Vía aérea',$row_user['via_aerea_b']],
    ['Manejo VAD',$row_user['vad_b']],
    ['Acceso vascular',$row_user['acceso_vascular_b']],
    ['Uso de eco',$eco],
    ['P. invasivo',$row_user['invasivo_b']],
    ['A. venoso central',$row_user['cvc_b']],
    ['A. neuroaxial',$row_user['neuroaxial_b']],
    ['A. regional',$row_user['regional_b']],
    ['P. dolor',$row_user['dolor_b']],
  ];
  foreach($items as $it){
    echo "<div class='bitacora-item'><div class='bitacora-item-label'>{$it[0]}</div><div class='bitacora-item-value'>{$it[1]}</div></div>";
  }

  echo "<input type='hidden' name='bitacora_autoriza' value='".$row_user['id_b']."'/>";
  echo "<div class='bitacora-feedback-label pt-2'>Comentarios del becado</div>";
  echo "<div class='bitacora-comments'>".$row_user['comentarios_b']."</div>";
  echo "<div class='bitacora-feedback-label pt-3'>Agregar feedback</div>";
  echo "<textarea class='form-control bitacora-feedback' maxlength='200' rows='3' name='comentarios_b_a' id='comentarios_b_a'></textarea>";
  echo "<div class='bitacora-actions'>
          <button class='btn btn-primary' type='submit' name='submit_b' value='1'>Autorizar</button>
          <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#".$modalId."'>Rechazar</button>
        </div>";

  echo "</div></div>";

  echo "<div class='modal fade' id='".$modalId."' tabindex='-1' aria-labelledby='".$modalId."Label' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='".$modalId."Label'>Confirmar rechazo</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                ¿Estás seguro de que deseas rechazar? Se notificará al becado del rechazo para su corrección.
              </div>
              <div class='modal-footer'>
                <button type='submit' name='submit_b' value='3' class='btn btn-danger'>Sí, rechazar</button>
              </div>
            </div>
          </div>
        </div></form>";
}

//Bitácora de internos
while($row_int=$tab_internos->fetch_assoc()){
  if($row_int['evaluacion_i']=="1"){ $evaluacion_i="Completa"; }
  elseif($row_int['evaluacion_i']=="2"){ $evaluacion_i="Incompleta"; }
  elseif($row_int['evaluacion_i']=="3"){ $evaluacion_i="No realizada"; } else { $evaluacion_i="-"; }

  if($row_int['ventilacion_i']=="1"){ $ventilacion_i="Solo"; }
  elseif($row_int['ventilacion_i']=="2"){ $ventilacion_i="Con ayuda"; }
  elseif($row_int['ventilacion_i']=="3"){ $ventilacion_i="Fallida"; } else { $ventilacion_i="-"; }

  if($row_int['intubacion_i']=="1"){ $intubacion_i="Solo"; }
  elseif($row_int['intubacion_i']=="2"){ $intubacion_i="Con ayuda"; }
  elseif($row_int['intubacion_i']=="3"){ $intubacion_i="Fallida"; } else { $intubacion_i="-"; }

  if($row_int['ayudas_i']=="1"){ $ayudas_i="Solo"; }
  elseif($row_int['ayudas_i']=="2"){ $ayudas_i="Con ayuda"; }
  elseif($row_int['ayudas_i']=="3"){ $ayudas_i="Fallida"; } else { $ayudas_i="-"; }

  if($row_int['lma_i']=="1"){ $lma_i="Solo"; }
  elseif($row_int['lma_i']=="2"){ $lma_i="Con ayuda"; }
  elseif($row_int['lma_i']=="3"){ $lma_i="Fallida"; } else { $lma_i="-"; }

  if($row_int['vvp_i']=="1"){ $vvp_i="Solo"; }
  elseif($row_int['vvp_i']=="2"){ $vvp_i="Con ayuda"; }
  elseif($row_int['vvp_i']=="3"){ $vvp_i="Fallida"; } else { $vvp_i="-"; }

  if($row_int['espinal_i']=="1"){ $espinal_i="Solo"; }
  elseif($row_int['espinal_i']=="2"){ $espinal_i="Con ayuda"; }
  elseif($row_int['espinal_i']=="3"){ $espinal_i="Fallida"; } else { $espinal_i="-"; }

  $email_int2=$row_int['autor_i'];
  $consulta_int2="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int2' AND `verified` = '1'";
  $confirma_int2=$conexion->query($consulta_int2);
  $rows2 = $confirma_int2->fetch_assoc();

  $modalId = "confirmarModalI".$row_int['id_i'];

  echo "<form action='bitacora_autoriza.php' method='post' class='bitacora-entry-card'>";
  echo "<div class='bitacora-entry-header bitacora-entry-header-danger'>";
  echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
  echo "<div><div class='small text-muted'>Interno</div><h5 class='mb-1'>".app_h_text($rows2['nombre_usuario'])."</h5></div>";
  echo "<div class='text-md-end'><div>".$row_int['fecha_i']."</div><div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/0/".$row_int['rut_i']."' target='_blank'>".$row_int['rut_i']."</a></div><div><a class='text-decoration-none' href='https://www.hbvaldivia.cl/core/farmacia/receta/1/".$row_int['ficha_i']."' target='_blank'>".$row_int['ficha_i']."</a></div></div>";
  echo "</div></div>";

  echo "<div class='bitacora-entry-body'><div class='bitacora-grid'>";
  $items = [
    ['Edad',$row_int['edad_i']],
    ['Procedimiento',$row_int['procedimiento_i']],
    ['Eval. preanestésica',$evaluacion_i],
    ['Ventilación',$ventilacion_i],
    ['Intubación',$intubacion_i],
    ['Máscara laríngea',$lma_i],
    ['Conductor / Bougie',$ayudas_i],
    ['Vía venosa periférica',$vvp_i],
    ['Espinal / Raquídea',$espinal_i],
  ];
  foreach($items as $it){
    echo "<div class='bitacora-item'><div class='bitacora-item-label'>{$it[0]}</div><div class='bitacora-item-value'>{$it[1]}</div></div>";
  }

  echo "<input type='hidden' name='bitacora_autoriza_i' value='".$row_int['id_i']."'/>";
  echo "<div class='bitacora-feedback-label pt-2'>Comentarios del interno</div>";
  echo "<div class='bitacora-comments'>".$row_int['comentarios_i']."</div>";
  echo "<div class='bitacora-feedback-label pt-3'>Agregar feedback</div>";
  echo "<textarea class='form-control bitacora-feedback' maxlength='200' rows='3' name='comentarios_i_a' id='comentarios_i_a'></textarea>";
  echo "<div class='bitacora-actions'>
          <button class='btn btn-primary' type='submit' name='submit_i' value='1'>Autorizar</button>
          <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#".$modalId."'>Rechazar</button>
        </div>";

  echo "</div></div>";

  echo "<div class='modal fade' id='".$modalId."' tabindex='-1' aria-labelledby='".$modalId."Label' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='".$modalId."Label'>Confirmar rechazo</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                ¿Estás seguro de que deseas rechazar? Se notificará al interno del rechazo para su corrección.
              </div>
              <div class='modal-footer'>
                <button type='submit' name='submit_i' value='3' class='btn btn-danger'>Sí, rechazar</button>
              </div>
            </div>
          </div>
        </div></form>";
}
?>

    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>
