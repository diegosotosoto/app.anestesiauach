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

<?php
function bitacora_resuelve_staff_email($conexion, $staff_raw){
  $staff_raw = trim((string)$staff_raw);
  if($staff_raw === ''){
    return '';
  }

  if(filter_var($staff_raw, FILTER_VALIDATE_EMAIL)){
    $stmt = $conexion->prepare("SELECT `email_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = ? AND (`staff_` = 1 OR `admin` = 1) LIMIT 1");
    if($stmt){
      $stmt->bind_param("s", $staff_raw);
      $stmt->execute();
      $res = $stmt->get_result();
      if($fila = $res->fetch_assoc()){
        $stmt->close();
        return $fila['email_usuario'];
      }
      $stmt->close();
    }
  }

  // Fallback para formularios antiguos abiertos antes del cambio: venian con nombre.
  $res = $conexion->query("SELECT `nombre_usuario`, `email_usuario` FROM `usuarios_dolor` WHERE `staff_` = 1 OR `admin` = 1");
  if($res){
    while($fila = $res->fetch_assoc()){
      $nombre = function_exists('app_decode_text') ? app_decode_text($fila['nombre_usuario']) : html_entity_decode($fila['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
      if(trim($nombre) === $staff_raw){
        return $fila['email_usuario'];
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
  $cvc_b=htmlentities(addslashes($_POST['cvc_b']));

  if($_POST['invasivo_eco_b']=="1"){
    $invasivo_eco_b="1";
  }else{
    $invasivo_eco_b="0";
  }

  $neuroaxial_b=htmlentities(addslashes($_POST['neuroaxial_b']));
  $regional_b=htmlentities(addslashes($_POST['regional_b']));
  $dolor_b=htmlentities(addslashes($_POST['dolor_b']));
  $staff_b=bitacora_resuelve_staff_email($conexion, $_POST['staff_b'] ?? '');
  $staff_b=$conexion->real_escape_string($staff_b);
  $comentarios_b=htmlentities(addslashes($_POST['comentarios_b']));

  if($staff_b === ''){
    echo "<div class='alert alert-danger alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> Selecciona un anestesiólogo responsable válido.
    </div>";
  }else{
    $confirma_bitacora_b="SELECT * FROM `bitacora_proced` WHERE `rut_b` = '$rut_b' AND `ficha_b` = '$ficha_b' AND `fecha_b` = '$fecha_b' AND `autor_b` = '$autor_b' AND `via_aerea_b` = '$via_aerea_b' AND `vad_b` = '$vad_b' AND `acceso_vascular_b` = '$acceso_vascular_b' AND `invasivo_b` = '$invasivo_b' AND `cvc_b` = '$cvc_b' AND `neuroaxial_b` = '$neuroaxial_b' AND `regional_b` = '$regional_b'";
    $consulta_cb=$conexion->query($confirma_bitacora_b);
    $respuesta_cb=$consulta_cb ? mysqli_num_rows($consulta_cb) : 0;

    if($consulta_cb === false){
      error_log("bitacora_ingreso confirma_bitacora_b: ".$conexion->error);
    }

    if($respuesta_cb>=1){
    echo "<div class='alert alert-danger alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> Ya existe un registro ingresado por ".$autor_b." con fecha ".$fecha_b.", para el paciente Rut: ".$rut_b.". <strong>No se ha ingresado el nuevo registro.</strong>
    </div>";
    }else{
      $consulta_b="INSERT INTO `bitacora_proced` (`autor_b`, `rut_b`, `ficha_b`, `edad_b`, `procedimiento_b`, `fecha_b`, `via_aerea_b`, `vad_b`, `acceso_vascular_b`, `invasivo_b`, `invasivo_eco_b`, `neuroaxial_b`, `regional_b`, `dolor_b`, `staff_b`, `comentarios_b`, `cvc_b`) VALUES ('$autor_b','$rut_b', '$ficha_b', '$edad_b', '$procedimiento_b', '$fecha_b', '$via_aerea_b', '$vad_b', '$acceso_vascular_b', '$invasivo_b', '$invasivo_eco_b', '$neuroaxial_b', '$regional_b', '$dolor_b', '$staff_b', '$comentarios_b', '$cvc_b') ";
      $escribir_b=$conexion->query($consulta_b);

      if($escribir_b==false){
        error_log("bitacora_ingreso insert bitacora_proced: ".$conexion->error);
        echo "<div class='alert alert-danger alert-dismissible fade show'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Info!</strong> Error en el guardado. Contacta al administrador.
        </div>";
      }else{
        echo "<div class='alert alert-success alert-dismissible fade show'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Info!</strong> Registro guardado.
        </div>";
      }
    }
  }
}
?>

      <div class="bitacora-topbar">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • registro de procedimientos</div>
            <h1 class="h4 mb-2">Ingreso de Bitácora</h1>
            <div class="subtle text-white-50">Registra procedimientos realizados y asígnalos al anestesiólogo responsable para su validación.</div>
          </div>
          <span class="pill bg-light text-dark">Becado</span>
        </div>
      </div>

      <ul class="nav nav-tabs bitacora-tabs">
        <li class="nav-item">
          <span class="nav-link active" aria-current="page">Ingreso</span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_rechazos.php">Rechazos</a>
        </li>
      </ul>

      <form class="needs-validation" name="form_ingreso_bit" id="form_ingreso_bit" method="post" action="bitacora_ingreso.php" novalidate>

        <div class="bitacora-card">
          <div class="bitacora-card-header">
            <h4 class='mb-1 fw-bold pt-2'>Bitácora de</h4>
            <div class='text-black-50 pb-2 pt-1 bitacora-muted-small'><?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?></div>
          </div>

          <div class="bitacora-card-body">

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Rut Paciente <span class="opacity-50">(ej: 12345678-9)</span></div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <input class="form-control bitacora-input" type="text" oninput="checkRut(this)" name="rut_b" id="rut_b" required>
              <div class="invalid-feedback pt-1">Ingrese un RUT válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Ficha</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <input class="form-control bitacora-input" type="text" name="ficha_b" id="ficha_b" pattern="[0-9]{1,7}" required>
              <div class="invalid-feedback pt-1">Ingrese un número de ficha válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Edad</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <select class="form-select bitacora-select" id="edad_b" name="edad_b" required>
                <option value=""></option>
                <option value="RNPT">RNPT</option>
                <option value="Neonato">Neonato</option>
                <option value="Menor de 6 meses">Menor de 6 meses</option>
                <option value="6 meses a 1 año">6 meses a 1 año</option>
                <option value="1 Año a 15 años">1 Año a 15 años</option>
                <option value="Adulto">Adulto</option>
                <option value="Adulto de 70 años y mayor">Adulto de 70 años y mayor</option>
              </select>
              <div class="invalid-feedback pt-0">Ingrese un valor válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Curso / Rotación</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <select class="form-select bitacora-select" id="procedimiento_b" name="procedimiento_b" required>
                <option value=""></option>
                <option value="Cirugía General">Cirugía General</option>
                <option value="Cirugía Pediátrica">Cirugía Pediátrica</option>
                <option value="Gineco-Obstetricia">Gineco-Obstetricia</option>
                <option value="Cirugía de Tórax/Vascular">Cirugía de Tórax/Vascular</option>
                <option value="Neurocirugía">Neurocirugía</option>
                <option value="Cirugía Cardiovascular">Cirugía Cardiovascular</option>
                <option value="Cirugía Ambulatoria">Cirugía Ambulatoria</option>
                <option value="Turno/Urgencias">Turno/Urgencias</option>
                <option value="Cirugía Urológica">Cirugía Urológica</option>
                <option value="Traumatología y Regional">Traumatología y Regional</option>
                <option value="Dolor">Dolor</option>
                <option value="Electivo">Electivo</option>
                <option value="UCI/UTI">UCI/UTI</option>
              </select>
              <div class="invalid-feedback pt-0">Ingrese un valor válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Fecha <span class="opacity-50">(dd/mm/aaaa)</span></div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <div class="input-group date">
                <input type="text" class="form-control bitacora-input" name="fecha_b" id="datepicker" required>
              </div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Manejo de Vía Aérea</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="seeAnotherFieldGroup" name="via_aerea_b">
                <option value=""></option>
                <option value="Tubo Orotraqueal">Tubo Orotraqueal</option>
                <option value="Máscara Laríngea">Máscara Laríngea</option>
                <option value="Tubo Nasotraqueal">Tubo Nasotraqueal</option>
                <option value="Tubo Doble Lumen">Tubo Doble Lumen</option>
                <option value="Otra Via Aérea Supraglótica">Otra Via Aérea Supraglótica</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Vía Aérea Difícil</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="vad_b" name="vad_b">
                <option value=""></option>
                <option value="Bougie">Bougie</option>
                <option value="Guía o Conductor">Guía o Conductor</option>
                <option value="Videolaringoscopio">Videolaringoscopio</option>
                <option value="Dispositivo Supraglótico">Dispositivo Supraglótico</option>
                <option value="Fibrobroncoscopio">Fibrobroncoscopio</option>
                <option value="Fastrack">Fastrack</option>
                <option value="Bonfils">Bonfils</option>
                <option value="Ventilación en Jet">Ventilación en Jet</option>
                <option value="Via Aérea Quirúrgica">Via Aérea Quirúrgica</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Acceso Vascular</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="acceso_vascular_b" name="acceso_vascular_b">
                <option value=""></option>
                <option value="Vía Venosa Periférica">Vía Venosa Periférica</option>
                <option value="Midline">Midline</option>
                <option value="PICC">PICC</option>
              </select>
            </div>

            <div class="bitacora-switch-row">
              <div class='bitacora-label'>Uso de Ecógrafo</div>
              <input class='form-check-input fs-5' type='checkbox' name='invasivo_eco_b' id='invasivo_eco_b' value='1'/>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Monitorización Invasiva</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="invasivo_b" name="invasivo_b">
                <option value=""></option>
                <option value="Línea Arterial">Línea Arterial</option>
                <option value="Línea Arterial con Eco">Línea Arterial con Eco</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>A. Venoso Central</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="cvc_b" name="cvc_b">
                <option value=""></option>
                <option value="CVC">CVC</option>
                <option value="Cateter de Arteria Pulmonar">Cateter de Arteria Pulmonar</option>
                <option value="CVC con reparos anatómicos">CVC con reparos anatómicos</option>
                <option value="Cateter Pulmonar por anatomía">Cateter Pulmonar por anatomía</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Anestesia Neuroaxial</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="neuroaxial_b" name="neuroaxial_b">
                <option value=""></option>
                <option value="Anestesia Espinal">Anestesia Espinal</option>
                <option value="Combinada Espinal-Epidural">Combinada Espinal-Epidural</option>
                <option value="Analgesia Epidural Lumbar">Analgesia Epidural Lumbar</option>
                <option value="Analgesia Epidural Torácica">Analgesia Epidural Torácica</option>
                <option value="Anestesia Caudal">Anestesia Caudal</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Anestesia Regional</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="regional_b" name="regional_b">
                <option value=""></option>
                <option value="Bloqueo de Plaxo Braquial">Bloqueo de Plexo Braquial</option>
                <option value="Bloqueo de EEII">Bloqueo de EEII</option>
                <option value="Bloqueo de Pared/Interfascial">Bloqueo de Pared/Interfascial</option>
                <option value="Bloqueo Nervio Dorsal del Pene">Bloqueo Nervio Dorsal del Pene</option>
                <option value="Bloqueo Paravertebral">Bloqueo Paravertebral</option>
                <option value="Bloqueo Plexo Lumbar">Bloqueo Plexo Lumbar</option>
                <option value="Bloqueo Nervio Periférico">Bloqueo Nervio Periférico</option>
                <option value="Regional Ev">Regional Ev</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Manejo de Dolor</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="dolor_b" name="dolor_b">
                <option value=""></option>
                <option value="PCA Endovenosa">PCA Endovenosa</option>
                <option value="PCA Peridural">PCA Peridural</option>
                <option value="PCA Plexo/Elastomérica">PCA Plexo/Elastomérica</option>
                <option value="Dolor Crónico">Dolor Crónico</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Anestesiólog@ Responsable</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>

            <select class="form-select bitacora-select" id="staff_b" name="staff_b" required>
              <option value=""></option>
              <?php
                $consulta_staff="SELECT `nombre_usuario`, `email_usuario` FROM `usuarios_dolor` WHERE `staff_` = '1' OR `admin` = '1' ORDER BY `nombre_usuario` ASC";
                $busca_staff=$conexion->query($consulta_staff);
                while($staff=$busca_staff->fetch_assoc()){
                  $nombre_staff_limpio = function_exists('app_decode_text') ? app_decode_text($staff['nombre_usuario']) : html_entity_decode($staff['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                  $nombre_staff = htmlspecialchars($nombre_staff_limpio, ENT_QUOTES, 'UTF-8');
                  $email_staff = htmlspecialchars($staff['email_usuario'], ENT_QUOTES, 'UTF-8');
                  echo "<option value='".$email_staff."'>".$nombre_staff."</option>";
                }
              ?>
            </select>
                          
              <div class="invalid-feedback pt-0 pb-1">Ingrese un valor válido</div>
            </div>

            <div class="bitacora-switch-row pt-2 pb-3">
              <div class='bitacora-label'>Autorizado por Staff</div>
              <input class='form-check-input fs-5' type='checkbox' name='aprobado_staff_b' id='aprobado_staff_b' value='1' disabled/>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Comentarios</div>
                <div class="bitacora-required"></div>
              </div>
              <textarea class="form-control bitacora-textarea" maxlength="250" rows="5" name="comentarios_b" id="comentarios_b"></textarea>
            </div>

            <div class="pt-3 d-flex justify-content-end">
              <button class='btn btn-app-primary bitacora-submit shadow-sm border-light' type='submit' form='form_ingreso_bit' value='Submit' id='boton'>
                <div class='text-white'><i class="fa-solid fa-floppy-disk pe-2"></i>Guardar Bitácora</div>
              </button>
            </div>

          </div>
        </div>

      </form>

    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>

<script type="text/javascript" src="js/not_reload.js"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
  var today, datepicker;
  today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
  $(function() {
    $('#datepicker').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd/mm/yyyy',
      weekStartDay: 1,
      autoclose: true,
      maxDate: today,
      showRightIcon: true,
    });
  });
</script>

<script>
function checkRut(rut) {
  var valor = rut.value.replace('.','');
  valor = valor.replace('-','');
  cuerpo = valor.slice(0,-1);
  dv = valor.slice(-1).toUpperCase();
  rut.value = cuerpo + '-'+ dv
  if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
  suma = 0;
  multiplo = 2;
  for(i=1;i<=cuerpo.length;i++) {
    index = multiplo * valor.charAt(cuerpo.length - i);
    suma = suma + index;
    if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  }
  dvEsperado = 11 - (suma % 11);
  dv = (dv == 'K')?10:dv;
  dv = (dv == 0)?11:dv;
  if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
  rut.setCustomValidity('');
}
</script>

<script>
(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      } else {
        $('#boton').prop('disabled', true);
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
