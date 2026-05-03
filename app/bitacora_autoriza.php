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
$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Bitácora</span>";
$boton_navbar="<a></a>";

//Carga Head de la página
require("head.php");

if(!function_exists('bitacora_render_item_if_filled')){
  function bitacora_render_item_if_filled($label, $value){
    $value = trim((string)$value);
    if($value === '' || $value === '-'){
      return;
    }
    echo "<div class='bitacora-item'><div class='bitacora-item-label'>".app_h_text($label)."</div><div class='bitacora-item-value'>".app_h_text($value)."</div></div>";
  }
}
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

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
  $consulta_int="SELECT `nombre_usuario`, `ui_icono`, `ui_icono_color`, `admin` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int' AND `verified` = '1'";
  $confirma_int=$conexion->query($consulta_int);
  $rows = $confirma_int->fetch_assoc();

  $modalId = "confirmarModalB".$row_user['id_b'];

  echo "<form action='bitacora_autoriza.php' method='post' class='bitacora-entry-card'>";
  echo "<div class='bitacora-entry-header'>";
  echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
  $icono_autor = app_render_user_inline_icon($rows);
  echo "<div><div class='small text-muted'>Becado</div><h5 class='mb-1'>".$icono_autor.app_h_text($rows['nombre_usuario'])."</h5></div>";
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
    bitacora_render_item_if_filled($it[0], $it[1]);
  }

  echo "<input type='hidden' name='bitacora_autoriza' value='".$row_user['id_b']."'/>";
  echo "<div class='bitacora-feedback-label pt-2'>Comentarios del becado</div>";
  echo "<div class='bitacora-comments'>".$row_user['comentarios_b']."</div>";
  echo "<div class='bitacora-feedback-label pt-3'>Agregar feedback</div>";
  echo "<textarea class='form-control bitacora-feedback' maxlength='200' rows='3' name='comentarios_b_a' id='comentarios_b_a'></textarea>";
  echo "<div class='bitacora-actions'>
          <button class='btn btn-app-primary' type='submit' name='submit_b' value='1'>Autorizar</button>
          <button type='button' class='btn btn-app-danger' data-bs-toggle='modal' data-bs-target='#".$modalId."'>Rechazar</button>
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
                <button type='submit' name='submit_b' value='3' class='btn btn-app-danger'>Sí, rechazar</button>
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
  $consulta_int2="SELECT `nombre_usuario`, `ui_icono`, `ui_icono_color`, `admin` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int2' AND `verified` = '1'";
  $confirma_int2=$conexion->query($consulta_int2);
  $rows2 = $confirma_int2->fetch_assoc();

  $modalId = "confirmarModalI".$row_int['id_i'];

  echo "<form action='bitacora_autoriza.php' method='post' class='bitacora-entry-card'>";
  echo "<div class='bitacora-entry-header bitacora-entry-header-danger'>";
  echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
  $icono_autor2 = app_render_user_inline_icon($rows2);
  echo "<div><div class='small text-muted'>Interno</div><h5 class='mb-1'>".$icono_autor2.app_h_text($rows2['nombre_usuario'])."</h5></div>";
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
    bitacora_render_item_if_filled($it[0], $it[1]);
  }

  echo "<input type='hidden' name='bitacora_autoriza_i' value='".$row_int['id_i']."'/>";
  echo "<div class='bitacora-feedback-label pt-2'>Comentarios del interno</div>";
  echo "<div class='bitacora-comments'>".$row_int['comentarios_i']."</div>";
  echo "<div class='bitacora-feedback-label pt-3'>Agregar feedback</div>";
  echo "<textarea class='form-control bitacora-feedback' maxlength='200' rows='3' name='comentarios_i_a' id='comentarios_i_a'></textarea>";
  echo "<div class='bitacora-actions'>
          <button class='btn btn-app-primary' type='submit' name='submit_i' value='1'>Autorizar</button>
          <button type='button' class='btn btn-app-danger' data-bs-toggle='modal' data-bs-target='#".$modalId."'>Rechazar</button>
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
                <button type='submit' name='submit_i' value='3' class='btn btn-app-danger'>Sí, rechazar</button>
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
