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
  header('Location: bitacora_autoriza.php');
} elseif ($usuario['staff_']==1) {
  header('Location: bitacora_autoriza.php');
} elseif ($usuario['intern_']==1 or $usuario['becad_otro']==1) {
  header('Location: bitacora_internos.php');
} elseif ($usuario['becad_']==1) {
  //CONTINUA EN LA PAGINA
}

//VARIABLES
$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Bitácora</span>";
$boton_navbar="<a></a>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

<style>
  .bitacora-shell{max-width:980px;margin:0 auto;}
  .bitacora-topbar{
    background:linear-gradient(135deg, #27458f, #3559b7);
    color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
    padding:1.15rem 1.25rem;margin-bottom:1rem;
  }
  .bitacora-topbar h1{color:#fff;}
  .subtle{font-size:.92rem;}
  .pill{display:inline-block;padding:.25rem .6rem;border-radius:999px;font-size:.8rem;font-weight:600;}
  .bitacora-tabs{margin-bottom:1rem;}
  .bitacora-tabs .nav-link{border-radius:.85rem;margin-right:.5rem;color:#3559b7;}
  .bitacora-tabs .nav-link.active{background:#3559b7;color:#fff;border-color:#3559b7;}
  .bitacora-tabs span.nav-link{display:block;cursor:default;}
  .bitacora-section-card,.bitacora-entry-card{
    border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);background:#fff;
  }
  .bitacora-section-card{margin-bottom:1rem;}
  .bitacora-section-header{
    background:linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);
    border-bottom:1px solid #e9eef5;padding:1rem 1.1rem;border-radius:1rem 1rem 0 0;
  }
  .bitacora-entry-card{margin-bottom:1rem;overflow:hidden;}
  .bitacora-entry-header{
    background:#eef4ff;padding:1rem 1.1rem;border-bottom:1px solid #dfe7f2;
  }
  .bitacora-entry-header-danger{
    background:#fef2f2;border-bottom:1px solid #f5c2c7;
  }
  .bitacora-entry-body{padding:1rem 1.1rem 1.15rem 1.1rem;}
  .bitacora-grid{display:grid;gap:.7rem;}
  .bitacora-item{
    display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;
    background:#f8fafc;border:1px solid #dfe7f2;border-radius:.9rem;padding:.85rem 1rem;
  }
  .bitacora-item-label{color:#5f6b76;font-weight:500;}
  .bitacora-item-value{color:#1f2a37;font-weight:600;text-align:right;}
  .bitacora-comments{
    background:#f8fafc;border:1px solid #dfe7f2;border-radius:.9rem;padding:1rem;white-space:pre-wrap;
  }
  .bitacora-feedback-label{
    font-size:.82rem;text-transform:uppercase;letter-spacing:.05em;color:#667085;margin-bottom:.55rem;
  }
  .bitacora-feedback{
    border-radius:.9rem;border:1px solid #dfe7f2;resize:none;
  }
  .bitacora-actions{display:flex;gap:.75rem;justify-content:flex-end;flex-wrap:wrap;margin-top:1rem;}
  .empty-state{text-align:center;color:#6c757d;padding:2rem 1rem;}
</style>

<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="bitacora-shell">

      <div class="bitacora-topbar">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • resumen pendiente</div>
            <h1 class="h4 mb-2">Resumen de Bitácoras</h1>
            <div class="subtle text-white-50">Vista rápida de registros pendientes para revisión y autorización.</div>
          </div>
          <span class="pill bg-light text-dark">Resumen</span>
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
          <h4 class="mb-1 fw-bold">Resumen Bitácoras</h4>
          <div class="text-black-50" style="font-size:14px">Registros aún no validados por el staff actual.</div>
        </div>
      </div>

<?php
$staff=$conexion->real_escape_string($_COOKIE['hkjh41lu4l1k23jhlkj13']);

$con_users="SELECT * FROM `bitacora_proced` WHERE `aprobado_staff_b` = '0' AND `staff_b` = '$staff' ";
$tab_users=$conexion->query($con_users);
$sin_bitacoras1=mysqli_num_rows($tab_users);

$con_internos="SELECT * FROM `bitacora_internos` WHERE `aprobado_staff_i` = '0' AND `staff_i` = '$staff' ";
$tab_internos=$conexion->query($con_internos);
$sin_bitacoras2=mysqli_num_rows($tab_internos);

if($sin_bitacoras1==0 and $sin_bitacoras2==0){
  echo "<div class='bitacora-entry-card'><div class='bitacora-entry-body'><div class='empty-state'>Sin elementos que validar.</div></div></div>";
}

// Becados
while($row_user=$tab_users->fetch_assoc()){
  $eco = ($row_user['invasivo_eco_b']=="1") ? "Sí" : "No";

  $email_int=$row_user['autor_b'];
  $consulta_int="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int' AND `verified` = '1'";
  $confirma_int=$conexion->query($consulta_int);
  $rows = $confirma_int->fetch_assoc();

  echo "<form action='bitacora_autoriza.php' method='post' class='bitacora-entry-card'>";
  echo "<div class='bitacora-entry-header'>";
  echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
  echo "<div><div class='small text-muted'>Becad@</div><h5 class='mb-1'>".app_h_text($rows['nombre_usuario'])."</h5></div>";
  echo "<div class='text-md-end'><div>".$row_user['fecha_b']."</div><div>".$row_user['rut_b']."</div><div>".$row_user['ficha_b']."</div></div>";
  echo "</div></div>";

  echo "<div class='bitacora-entry-body'><div class='bitacora-grid'>";
  $items = [
    ['Edad',$row_user['edad_b']],
    ['Procedimiento',$row_user['procedimiento_b']],
    ['Vía Aérea',$row_user['via_aerea_b']],
    ['Manejo VAD',$row_user['vad_b']],
    ['Acceso Vascular',$row_user['acceso_vascular_b']],
    ['Uso de Eco',$eco],
    ['A. Venoso Central',$row_user['cvc_b']],
    ['P. Invasivo',$row_user['invasivo_b']],
    ['A. Neuroaxial',$row_user['neuroaxial_b']],
    ['A. Regional',$row_user['regional_b']],
    ['P. Dolor',$row_user['dolor_b']],
  ];
  foreach($items as $it){
    echo "<div class='bitacora-item'><div class='bitacora-item-label'>{$it[0]}</div><div class='bitacora-item-value'>{$it[1]}</div></div>";
  }
  echo "<input type='hidden' name='bitacora_autoriza' value='".$row_user['id_b']."'/>";
  echo "<div class='bitacora-feedback-label pt-2'>Comentarios</div>";
  echo "<div class='bitacora-comments'>".$row_user['comentarios_b']."</div>";
  echo "<div class='bitacora-feedback-label pt-3'>Agregar feedback</div>";
  echo "<textarea class='form-control bitacora-feedback' maxlength='200' rows='3' name='comentarios_b_a' id='comentarios_b_a'></textarea>";
  echo "<div class='bitacora-actions'><button class='btn btn-primary' type='submit'>Autorizar</button></div>";
  echo "</div></div></form>";
}

// Internos
while($row_int=$tab_internos->fetch_assoc()){
  $evaluacion_i = $row_int['evaluacion_i']=="1" ? "Completa" : ($row_int['evaluacion_i']=="2" ? "Incompleta" : "No Realizada");
  $ventilacion_i = $row_int['ventilacion_i']=="1" ? "Solo" : ($row_int['ventilacion_i']=="2" ? "Con Ayuda" : "Fallida");
  $intubacion_i = $row_int['intubacion_i']=="1" ? "Solo" : ($row_int['intubacion_i']=="2" ? "Con Ayuda" : "Fallida");
  $ayudas_i = $row_int['ayudas_i']=="1" ? "Solo" : ($row_int['ayudas_i']=="2" ? "Con Ayuda" : "Fallida");
  $lma_i = $row_int['lma_i']=="1" ? "Solo" : ($row_int['lma_i']=="2" ? "Con Ayuda" : "Fallida");
  $vvp_i = $row_int['vvp_i']=="1" ? "Solo" : ($row_int['vvp_i']=="2" ? "Con Ayuda" : "Fallida");
  $espinal_i = $row_int['espinal_i']=="1" ? "Solo" : ($row_int['espinal_i']=="2" ? "Con Ayuda" : "Fallida");

  $email_int2=$row_int['autor_i'];
  $consulta_int2="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$email_int2' AND `verified` = '1'";
  $confirma_int2=$conexion->query($consulta_int2);
  $rows2 = $confirma_int2->fetch_assoc();

  echo "<form action='bitacora_autoriza.php' method='post' class='bitacora-entry-card'>";
  echo "<div class='bitacora-entry-header bitacora-entry-header-danger'>";
  echo "<div class='d-flex justify-content-between align-items-start gap-3 flex-wrap'>";
  echo "<div><div class='small text-muted'>Becad@ / Intern@</div><h5 class='mb-1'>".app_h_text($rows2['nombre_usuario'])."</h5></div>";
  echo "<div class='text-md-end'><div>".$row_int['fecha_i']."</div><div>".$row_int['rut_i']."</div><div>".$row_int['ficha_i']."</div></div>";
  echo "</div></div>";

  echo "<div class='bitacora-entry-body'><div class='bitacora-grid'>";
  $items = [
    ['Edad',$row_int['edad_i']],
    ['Procedimiento',$row_int['procedimiento_i']],
    ['Eval. Preanestésica',$evaluacion_i],
    ['Ventilación',$ventilacion_i],
    ['Intubación',$intubacion_i],
    ['Máscara Laríngea',$ayudas_i],
    ['Conductor / Bougie',$lma_i],
    ['Vía Venosa Periférica',$vvp_i],
    ['Espinal / Raquídea',$espinal_i],
  ];
  foreach($items as $it){
    echo "<div class='bitacora-item'><div class='bitacora-item-label'>{$it[0]}</div><div class='bitacora-item-value'>{$it[1]}</div></div>";
  }
  echo "<input type='hidden' name='bitacora_autoriza_i' value='".$row_int['id_i']."'/>";
  echo "<div class='bitacora-feedback-label pt-2'>Comentarios</div>";
  echo "<div class='bitacora-comments'>".$row_int['comentarios_i']."</div>";
  echo "<div class='bitacora-feedback-label pt-3'>Agregar feedback</div>";
  echo "<textarea class='form-control bitacora-feedback' maxlength='200' rows='3' name='comentarios_i_a' id='comentarios_i_a'></textarea>";
  echo "<div class='bitacora-actions'><button class='btn btn-primary' type='submit'>Autorizar</button></div>";
  echo "</div></div></form>";
}
?>

    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>
