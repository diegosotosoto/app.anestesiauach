<?php
//Conexión
require("conectar.php");
require_once __DIR__ . '/app_security.php';
date_default_timezone_set('America/Santiago');
$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
$conexion->set_charset("utf8");

app_require_login($conexion, 'login.php');

//redirección segun nivel de usuario
$usuario = app_current_user($conexion);
if(!$usuario){
  header('Location: login.php');
  exit;
}

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

// Preparar lista de staff para el buscador JS
$staff_lista = array();
$consulta_staff_js = "SELECT `nombre_usuario`, `email_usuario` FROM `usuarios_dolor` WHERE `staff_` = '1' OR `admin` = '1' ORDER BY `nombre_usuario` ASC";
$result_staff_js = $conexion->query($consulta_staff_js);
if($result_staff_js){
  while($s = $result_staff_js->fetch_assoc()){
    $staff_lista[] = array(
      'nombre' => function_exists('app_decode_text') ? app_decode_text($s['nombre_usuario']) : html_entity_decode($s['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
      'email' => $s['email_usuario']
    );
  }
}

// Obtener último staff ingresado por el usuario actual
$ultimo_staff = array('nombre' => '', 'email' => '');
if($usuario && isset($usuario['email_usuario']) && !empty($usuario['email_usuario'])){
  $email_becado = $conexion->real_escape_string($usuario['email_usuario']);
  $consulta_ultimo_staff = "SELECT `staff_b` FROM `bitacora_proced` WHERE `autor_b` = '$email_becado' ORDER BY `fecha_b` DESC LIMIT 1";
  $result_ultimo = @mysqli_query($conexion, $consulta_ultimo_staff);
  if($result_ultimo){
    $fila_ultimo = mysqli_fetch_assoc($result_ultimo);
    if($fila_ultimo && !empty($fila_ultimo['staff_b'])){
      $ultimo_staff_email = $conexion->real_escape_string($fila_ultimo['staff_b']);
      $consulta_nombre_staff = "SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$ultimo_staff_email' LIMIT 1";
      $result_nombre = @mysqli_query($conexion, $consulta_nombre_staff);
      if($result_nombre){
        $fila_nombre = mysqli_fetch_assoc($result_nombre);
        if($fila_nombre && !empty($fila_nombre['nombre_usuario'])){
          $ultimo_staff = array(
            'nombre' => html_entity_decode($fila_nombre['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'email' => $fila_ultimo['staff_b']
          );
        }
      }
    }
  }
}
?>
<link rel="stylesheet" href="css/bitacora-rapido.css?v=<?= @filemtime(__DIR__ . '/css/bitacora-rapido.css') ?: time() ?>">

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

  $autor_b=strtolower(urldecode($app_current_user['email_usuario']));
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
      <strong>Info!</strong> Selecciona un staff responsable válido.
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
          <a class="nav-link" href="bitacora_ingreso_old.php">Ingreso (Antiguo)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_rechazos.php">Rechazos</a>
        </li>
      </ul>

     <?php echo "<form class='needs-validation' name='form_ingreso_bit' id='form_ingreso_bit' method='post' action='bitacora_ingreso.php' novalidate autocomplete='off'>"; ?>

        <div class="bitacora-card">
          <div class="bitacora-card-header">
            <div class="d-flex align-items-center gap-3">
              <?php
                if (function_exists('app_render_user_inline_icon')) {
                  $icono_usuario = app_render_user_inline_icon($usuario, 'app-inline-user-icon-large');
                  // Forzar tamaño grande con estilos inline directamente en el elemento i
                  $icono_usuario = str_replace('style="background:', 'style="width:64px!important;height:64px!important;font-size:1.8rem!important;background:', $icono_usuario);
                } else {
                  $icono_usuario = '<div class="staff-option-avatar" style="background:#10b981; width:64px; height:64px; font-size:1.8rem;"><i class="fa-solid fa-graduation-cap" style="font-size:1.8rem;"></i></div>';
                }
                $nombre_usuario = function_exists('app_h_text') ? app_h_text($usuario['nombre_usuario']) : htmlspecialchars(html_entity_decode((string)$usuario['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8');
              ?>
              <div class="correo-name fs-3"><?php echo $icono_usuario . '<span class="fw-bold">' . $nombre_usuario . '</span>'; ?></div>
            </div>
          </div>

          <div class="bitacora-card-body">

            <div class="bitacora-field" id="rut-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Rut Paciente <span class="opacity-50">(ej: 12345678-9)</span></div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <div style="position:relative;">
                <input class="form-control bitacora-input bitacora-input-rut" type="text" oninput="formatRut(this)" onblur="validateRutImmediate(this)" name="rut_b" id="rut_b" required placeholder="12345678-9">
                <span class="rut-validation-icon" id="rut-icon"></span>
              </div>
              <div class="rut-feedback" id="rut-feedback"></div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Ficha</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <div class="input-group">
                <input class="form-control bitacora-input" type="text" name="ficha_b" id="ficha_b" pattern="[0-9]{1,7}" required>
                <button type="button" class="btn btn-outline-primary" onclick="openBarcodeScanner()" title="Escanear código de barras">
                  <i class="fa-solid fa-barcode"></i>
                </button>
              </div>
              <div class="invalid-feedback pt-1">Ingrese un número de ficha válido</div>
            </div>

            <div class="bitacora-field" id="edad-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Edad</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <input type="hidden" name="edad_b" id="edad_b" required>
              <div class="edad-grid">
                <button type="button" class="edad-btn" data-value="RNPT" onclick="selectEdad(this)">
                  <i class="fa-solid fa-baby"></i>
                  <span>RNPT</span>
                </button>
                <button type="button" class="edad-btn" data-value="Neonato" onclick="selectEdad(this)">
                  <i class="fa-solid fa-baby-carriage"></i>
                  <span>Neonato</span>
                </button>
                <button type="button" class="edad-btn" data-value="Menor de 6 meses" onclick="selectEdad(this)">
                  <i class="fa-solid fa-child"></i>
                  <span>&lt; 6 meses</span>
                </button>
                <button type="button" class="edad-btn" data-value="6 meses a 1 año" onclick="selectEdad(this)">
                  <i class="fa-solid fa-cake-candles"></i>
                  <span>6m - 1a</span>
                </button>
                <button type="button" class="edad-btn" data-value="1 Año a 15 años" onclick="selectEdad(this)">
                  <i class="fa-solid fa-children"></i>
                  <span>1 - 15 años</span>
                </button>
                <button type="button" class="edad-btn" data-value="Adulto" onclick="selectEdad(this)">
                  <i class="fa-solid fa-user"></i>
                  <span>Adulto</span>
                </button>
                <button type="button" class="edad-btn" data-value="Adulto de 70 años y mayor" onclick="selectEdad(this)">
                  <i class="fa-solid fa-person-cane"></i>
                  <span>Adulto 70+</span>
                </button>
              </div>
              <div class="invalid-feedback pt-1" id="edad-feedback">Selecciona un rango etáreo</div>
            </div>

            <div class="bitacora-field" id="proced-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Curso / Rotación</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <div class="staff-search-container">
                <input type="text" class="staff-search-input" id="procedimiento_b" name="procedimiento_b" required placeholder="Escribe o selecciona un curso..." autocomplete="off">
                <div class="staff-dropdown" id="proced-dropdown"></div>
                <div class="staff-selected-display hidden" id="proced-selected">
                  <div class="staff-option-avatar" style="background:#10b981;"><i class="fa-solid fa-graduation-cap" style="color:#fff;"></i></div>
                  <div class="staff-option-info">
                    <div class="staff-option-name" id="proced-name"></div>
                    <div class="staff-option-email" style="opacity:0.7;font-size:.75rem;">Curso / Rotación</div>
                  </div>
                  <button type="button" class="btn btn-sm btn-link" onclick="clearProced()" style="color:#dc3545;"><i class="fa-solid fa-times"></i></button>
                </div>
              </div>
              <div class="invalid-feedback pt-1" id="proced-feedback">Ingrese un curso/rotación</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Fecha <span class="opacity-50">(dd/mm/aaaa)</span></div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <div class="input-group date">
                <input type="text" class="form-control bitacora-input" name="fecha_b" id="datepicker" required value="<?php echo date('d/m/Y'); ?>">
              </div>
            </div>

            <div class="bitacora-field" id="staff-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Staff Responsable</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>

              <div class="staff-search-container">
                <div class="input-group">
                  <input type="text" class="staff-search-input" id="staff_b" name="staff_b" required placeholder="Escribe nombre o busca del staff..." autocomplete="off">
                  <?php if($ultimo_staff['nombre']): ?>
                    <button type="button" class="btn btn-outline-secondary" onclick="repetirUltimoStaff()" title="Repetir último staff">
                      <i class="fa-solid fa-rotate-left"></i>
                    </button>
                  <?php endif; ?>
                </div>
                <?php if($ultimo_staff['nombre']): ?>
                  <div class="staff-helper-text">
                    <i class="fa-solid fa-rotate-left me-1"></i>
                    <span>Repetir último staff ingresado: <?php echo htmlspecialchars($ultimo_staff['nombre'], ENT_QUOTES, 'UTF-8'); ?></span>
                  </div>
                <?php endif; ?>
                <div class="staff-dropdown" id="staff-dropdown"></div>
                <div class="staff-selected-display hidden" id="staff-selected">
                  <div class="staff-option-avatar" id="staff-avatar"></div>
                  <div class="staff-option-info">
                    <div class="staff-option-name" id="staff-name"></div>
                    <div class="staff-option-email" id="staff-email-display"></div>
                  </div>
                  <button type="button" class="btn btn-sm btn-link" onclick="clearStaff()" style="color:#dc3545;"><i class="fa-solid fa-times"></i></button>
                </div>
              </div>

              <div class="invalid-feedback pt-1" id="staff-feedback">Ingrese un staff responsable</div>

              <!-- Botones de prellenado rápido -->
              <div class="prellenado-section">
                <div class="prellenado-label">Prellenado rápido:</div>
                <div class="prellenado-grid">
                  <button type="button" class="prellenado-btn" onclick="prellenarTOGA(this)">
                    <i class="fa-solid fa-lungs"></i>
                    <span>TOGA</span>
                    <small>Tubo Orotraqueal</small>
                  </button>
                  <button type="button" class="prellenado-btn" onclick="prellenarLMA(this)">
                    <i class="fa-solid fa-mask-ventilator"></i>
                    <span>LMA</span>
                    <small>Máscara Laríngea</small>
                  </button>
                  <button type="button" class="prellenado-btn" onclick="prellenarEspinal(this)">
                    <i class="fa-solid fa-syringe"></i>
                    <span>A. Espinal</span>
                    <small>Anestesia Neuroaxial</small>
                  </button>
                </div>
                <button type="button" class="btn-pre-enviar" onclick="enviarPrellenado()">
                  <i class="fa-solid fa-paper-plane"></i> Enviar con prellenado
                </button>
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
                <div class='bitacora-label'>Comentarios</div>
                <div class="bitacora-required"></div>
              </div>
              <textarea class="form-control bitacora-textarea" maxlength="250" rows="5" name="comentarios_b" id="comentarios_b"></textarea>
            </div>

            <!-- Resumen de selecciones -->
            <div class="resumen-chips-container" id="resumen-chips">
              <div class="resumen-chips-title">Resumen de la bitácora</div>
              <div class="resumen-chips-grid" id="chips-grid">
                <span class="resumen-chip empty" id="chip-rut"><i class="fa-solid fa-id-card"></i> RUT: —</span>
                <span class="resumen-chip empty" id="chip-edad"><i class="fa-solid fa-user"></i> Edad: —</span>
                <span class="resumen-chip empty" id="chip-proced"><i class="fa-solid fa-hospital"></i> Procedimiento: —</span>
                <span class="resumen-chip empty" id="chip-staff"><i class="fa-solid fa-user-doctor"></i> Staff: —</span>
                <span class="resumen-chip empty" id="chip-fecha"><i class="fa-solid fa-calendar"></i> Fecha: —</span>
                <span class="resumen-chip empty" id="chip-via-aerea"><i class="fa-solid fa-lungs"></i> Vía Aérea: —</span>
                <span class="resumen-chip empty" id="chip-acceso"><i class="fa-solid fa-syringe"></i> Acceso: —</span>
                <span class="resumen-chip empty" id="chip-invasivo"><i class="fa-solid fa-heart-pulse"></i> Invasivo: —</span>
                <span class="resumen-chip empty" id="chip-neuroaxial"><i class="fa-solid fa-brain"></i> Neuroaxial: —</span>
                <span class="resumen-chip empty" id="chip-regional"><i class="fa-solid fa-hand-dots"></i> Regional: —</span>
                <span class="resumen-chip empty" id="chip-dolor"><i class="fa-solid fa-pills"></i> Dolor: —</span>
              </div>
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
// ========== 1. VALIDACIÓN INMEDIATA DEL RUT ==========
function formatRut(rut) {
  var valor = rut.value.replace(/[^0-9kK]/g, '');
  if (valor.length > 1) {
    var cuerpo = valor.slice(0, -1);
    var dv = valor.slice(-1).toUpperCase();
    rut.value = cuerpo + '-' + dv;
  } else {
    rut.value = valor;
  }
}

function validateRutImmediate(rut) {
  var valor = rut.value.replace(/[^0-9kK]/g, '');
  var field = document.getElementById('rut-field');
  var icon = document.getElementById('rut-icon');
  var feedback = document.getElementById('rut-feedback');

  if (valor.length < 8) {
    showRutValidation(false, 'RUT incompleto');
    updateChip('chip-rut', 'RUT: —', true);
    return false;
  }

  var cuerpo = valor.slice(0, -1);
  var dv = valor.slice(-1).toUpperCase();

  var suma = 0;
  var multiplo = 2;
  for(var i = 1; i <= cuerpo.length; i++) {
    var index = multiplo * valor.charAt(cuerpo.length - i);
    suma = suma + index;
    if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  }
  var dvEsperado = 11 - (suma % 11);
  dv = (dv == 'K') ? 10 : dv;
  dv = (dv == 0) ? 11 : dv;

  if(dvEsperado != dv) {
    showRutValidation(false, 'RUT no válido');
    updateChip('chip-rut', 'RUT: —', true);
    return false;
  }

  showRutValidation(true, 'RUT válido');
  updateChip('chip-rut', 'RUT: ' + rut.value, false);
  return true;
}

function showRutValidation(isValid, message) {
  var input = document.getElementById('rut_b');
  var icon = document.getElementById('rut-icon');
  var feedback = document.getElementById('rut-feedback');
  var field = document.getElementById('rut-field');

  input.classList.remove('is-valid', 'is-invalid');
  icon.className = 'rut-validation-icon';
  feedback.className = 'rut-feedback show';

  if (isValid) {
    input.classList.add('is-valid');
    icon.classList.add('valid');
    icon.innerHTML = '<i class="fa-solid fa-check-circle"></i>';
    feedback.classList.add('valid');
    feedback.textContent = message;
    field.classList.remove('is-invalid');
  } else {
    input.classList.add('is-invalid');
    icon.classList.add('invalid');
    icon.innerHTML = '<i class="fa-solid fa-exclamation-circle"></i>';
    feedback.classList.add('invalid');
    feedback.textContent = message;
    field.classList.add('is-invalid');
  }
}

// ========== 2. BOTONES DE EDAD ==========
function selectEdad(btn) {
  var value = btn.getAttribute('data-value');
  var input = document.getElementById('edad_b');
  var buttons = document.querySelectorAll('.edad-btn');

  if (value === '') {
    input.value = '';
    buttons.forEach(function(b) { b.classList.remove('is-selected'); });
    updateChip('chip-edad', 'Edad: —', true);
    return;
  }

  input.value = value;
  buttons.forEach(function(b) {
    if (b.getAttribute('data-value') === value) {
      b.classList.add('is-selected');
    } else {
      b.classList.remove('is-selected');
    }
  });

  updateChip('chip-edad', 'Edad: ' + value, false);
  document.getElementById('edad-field').classList.remove('is-invalid');
}

// ========== OPCIONES DE CURSO/ROTACIÓN ==========
var procedOptions = [
  'Cirugía General',
  'Cirugía Pediátrica',
  'Gineco-Obstetricia',
  'Cirugía de Tórax/Vascular',
  'Neurocirugía',
  'Cirugía Cardiovascular',
  'Cirugía Ambulatoria',
  'Turno/Urgencias',
  'Cirugía Urológica',
  'Traumatología y Regional',
  'Dolor',
  'Electivo',
  'UCI/UTI'
];

var procedIcons = {
  'Cirugía General': '<i class="fa-solid fa-user-doctor"></i>',
  'Cirugía Pediátrica': '<i class="fa-solid fa-baby"></i>',
  'Gineco-Obstetricia': '<i class="fa-solid fa-person-pregnant"></i>',
  'Cirugía de Tórax/Vascular': '<i class="fa-solid fa-lungs"></i>',
  'Neurocirugía': '<i class="fa-solid fa-brain"></i>',
  'Cirugía Cardiovascular': '<i class="fa-solid fa-heart-pulse"></i>',
  'Cirugía Ambulatoria': '<i class="fa-solid fa-person-walking"></i>',
  'Turno/Urgencias': '<i class="fa-solid fa-truck-medical"></i>',
  'Cirugía Urológica': '<i class="fa-solid fa-faucet-drip"></i>',
  'Traumatología y Regional': '<i class="fa-solid fa-bone"></i>',
  'Dolor': '<i class="fa-solid fa-face-frown-open"></i>',
  'Electivo': '<i class="fa-solid fa-calendar-check"></i>',
  'UCI/UTI': '<i class="fa-regular fa-face-dizzy"></i>'
};

function getProcedIcon(opt) {
  return procedIcons[opt] || '<i class="fa-solid fa-graduation-cap"></i>';
}

// ========== 3. COMBOBOX STAFF ==========
var staffLista = <?php echo json_encode($staff_lista); ?>;
var ultimoStaff = <?php echo json_encode($ultimo_staff); ?>;

document.addEventListener('DOMContentLoaded', function() {
  // --- Curso/Rotación Combobox ---
  var procedInput = document.getElementById('procedimiento_b');
  var procedDropdown = document.getElementById('proced-dropdown');

  procedInput.addEventListener('input', function() {
    var query = this.value.toLowerCase().trim();

    // Ocultar etiqueta seleccionada al escribir
    document.getElementById('proced-selected').classList.add('hidden');

    if (query.length < 1) {
      procedDropdown.classList.remove('show');
      updateChip('chip-proced', 'Procedimiento: ' + this.value, this.value === '');
      return;
    }

    var matches = procedOptions.filter(function(opt) {
      return opt.toLowerCase().includes(query);
    }).slice(0, 6);

    if (matches.length > 0) {
      procedDropdown.innerHTML = matches.map(function(opt) {
        return '<div class="staff-option" onclick="selectProced(\'' + opt.replace(/\'/g, "\\'") + '\')">' +
          '<div class="staff-option-info">' +
            '<div class="staff-option-name">' + getProcedIcon(opt) + '<span class="ms-2">' + opt + '</span></div>' +
          '</div>' +
        '</div>';
      }).join('');
      procedDropdown.classList.add('show');
    } else {
      procedDropdown.classList.remove('show');
    }

    updateChip('chip-proced', 'Procedimiento: ' + this.value, this.value === '');
    document.getElementById('proced-field').classList.remove('is-invalid');
  });

  procedInput.addEventListener('focus', function() {
    if (this.value.trim().length >= 0) {
      procedDropdown.innerHTML = procedOptions.slice(0, 6).map(function(opt) {
        return '<div class="staff-option" onclick="selectProced(\'' + opt.replace(/\'/g, "\\'") + '\')">' +
          '<div class="staff-option-info">' +
            '<div class="staff-option-name">' + getProcedIcon(opt) + '<span class="ms-2">' + opt + '</span></div>' +
          '</div>' +
        '</div>';
      }).join('');
      procedDropdown.classList.add('show');
    }
  });

  procedInput.addEventListener('blur', function() {
    setTimeout(function() { procedDropdown.classList.remove('show'); }, 200);
  });

  // --- Staff Combobox ---
  var staffInput = document.getElementById('staff_b');
  var staffDropdown = document.getElementById('staff-dropdown');
  var staffSelected = document.getElementById('staff-selected');

  staffInput.addEventListener('input', function() {
    var query = this.value.toLowerCase().trim();
    if (query.length < 2) {
      staffDropdown.classList.remove('show');
      staffSelected.classList.add('hidden');
      updateChip('chip-staff', 'Staff: ' + this.value, this.value === '');
      return;
    }

    var matches = staffLista.filter(function(s) {
      return s.nombre.toLowerCase().includes(query) || s.email.toLowerCase().includes(query);
    }).slice(0, 5);

    renderStaffDropdown(matches);
    staffSelected.classList.add('hidden');
    updateChip('chip-staff', 'Staff: ' + this.value, false);
    document.getElementById('staff-field').classList.remove('is-invalid');
  });

  staffInput.addEventListener('focus', function() {
    if (this.value.trim().length >= 2) {
      staffDropdown.classList.add('show');
    }
  });

  // Cerrar dropdowns al clickear fuera
  document.addEventListener('click', function(e) {
    if (!e.target.closest('#proced-field')) {
      procedDropdown.classList.remove('show');
    }
    if (!e.target.closest('#staff-field')) {
      staffDropdown.classList.remove('show');
    }
  });

  // Actualizar chips al cambiar selects
  var selects = ['procedimiento_b', 'seeAnotherFieldGroup', 'acceso_vascular_b', 'invasivo_b', 'neuroaxial_b', 'regional_b', 'dolor_b'];
  selects.forEach(function(id) {
    var el = document.getElementById(id);
    if (el) {
      el.addEventListener('change', updateChips);
    }
  });

  // Inicializar chips
  updateChips();
});

function selectProced(valor) {
  document.getElementById('procedimiento_b').value = valor;
  document.getElementById('proced-dropdown').classList.remove('show');

  document.getElementById('proced-name').textContent = valor;
  document.getElementById('proced-selected').classList.remove('hidden');

  updateChip('chip-proced', 'Procedimiento: ' + valor, false);
  document.getElementById('proced-field').classList.remove('is-invalid');
}

function clearProced() {
  document.getElementById('procedimiento_b').value = '';
  document.getElementById('proced-selected').classList.add('hidden');
  updateChip('chip-proced', 'Procedimiento: —', true);
}

// ========== FUNCIONES DE PRELLENADO RÁPIDO ==========
function prellenarTOGA(btn) {
  // Anestesia General con Tubo Orotraqueal
  document.getElementById('seeAnotherFieldGroup').value = 'Tubo Orotraqueal';
  updateChips();
  // Selección visual del botón
  selectPrellenadoBtn(btn);
  // Feedback visual
  showPrellenadoFeedback('TOGA: Tubo Orotraqueal seleccionado');
}

function prellenarLMA(btn) {
  // Anestesia General con Máscara Laríngea
  document.getElementById('seeAnotherFieldGroup').value = 'Máscara Laríngea';
  updateChips();
  // Selección visual del botón
  selectPrellenadoBtn(btn);
  // Feedback visual
  showPrellenadoFeedback('LMA: Máscara Laríngea seleccionada');
}

function prellenarEspinal(btn) {
  // Anestesia Neuroaxial Espinal
  document.getElementById('neuroaxial_b').value = 'Espinal';
  updateChips();
  // Selección visual del botón
  selectPrellenadoBtn(btn);
  // Feedback visual
  showPrellenadoFeedback('A. Espinal: Anestesia neuroaxial seleccionada');
}

function selectPrellenadoBtn(btn) {
  var buttons = document.querySelectorAll('.prellenado-btn');
  buttons.forEach(function(b) { b.classList.remove('is-selected'); });
  btn.classList.add('is-selected');
}

function repetirUltimoStaff() {
  if(ultimoStaff && ultimoStaff.email){
    var staffInput = document.getElementById('staff_b');
    staffInput.value = ultimoStaff.nombre;
    staffInput.dataset.email = ultimoStaff.email;
    showStaffSelected(ultimoStaff.nombre, ultimoStaff.email);
    updateChip('chip-staff', 'Staff: ' + ultimoStaff.nombre.split(' ')[0], false);
    document.getElementById('staff-field').classList.remove('is-invalid');
  }
}

function showPrellenadoFeedback(mensaje) {
  // Crear toast temporal
  var toast = document.createElement('div');
  toast.style.cssText = 'position:fixed;top:20px;right:20px;background:#2563eb;color:#fff;padding:12px 20px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:9999;font-size:.9rem;font-weight:500;animation:slideIn .3s ease;';
  toast.innerHTML = '<i class="fa-solid fa-check-circle me-2"></i>' + mensaje;
  document.body.appendChild(toast);

  setTimeout(function() {
    toast.style.animation = 'slideOut .3s ease';
    setTimeout(function() { toast.remove(); }, 300);
  }, 2000);
}

function enviarPrellenado() {
  // Verificar campos obligatorios mínimos
  var rut = document.getElementById('rut_b').value;
  var edad = document.getElementById('edad_b').value;
  var proced = document.getElementById('procedimiento_b').value;
  var fecha = document.getElementById('datepicker').value;
  var staff = document.getElementById('staff_b').value;

  var faltantes = [];
  if (!rut || !validateRutImmediate(document.getElementById('rut_b'))) faltantes.push('RUT válido');
  if (!edad) faltantes.push('Edad');
  if (!proced.trim()) faltantes.push('Curso/Rotación');
  if (!fecha) faltantes.push('Fecha');
  if (!staff.trim()) faltantes.push('Staff Responsable');

  if (faltantes.length > 0) {
    alert('Complete los campos obligatorios: ' + faltantes.join(', '));
    return;
  }

  // Enviar formulario
  document.getElementById('form_ingreso_bit').submit();
}

function renderStaffDropdown(staff) {
  var dropdown = document.getElementById('staff-dropdown');
  if (staff.length === 0) {
    dropdown.innerHTML = '<div class="staff-option" style="opacity:0.6;cursor:default;"><div class="staff-option-info"><div class="staff-option-name">No se encontraron resultados</div></div></div>';
    dropdown.classList.add('show');
    return;
  }

  dropdown.innerHTML = staff.map(function(s) {
    var initial = s.nombre.charAt(0).toUpperCase();
    return '<div class="staff-option" onclick="selectStaff(\'' + s.email + '\', \'' + s.nombre.replace(/\'/g, "\\'") + '\')">' +
      '<div class="staff-option-avatar">' + initial + '</div>' +
      '<div class="staff-option-info">' +
        '<div class="staff-option-name">' + s.nombre + '</div>' +
        '<div class="staff-option-email">' + s.email + '</div>' +
      '</div>' +
      '<div class="staff-option-check"><i class="fa-solid fa-check"></i></div>' +
    '</div>';
  }).join('');

  dropdown.classList.add('show');
}

function selectStaff(email, nombre) {
  document.getElementById('staff_b').value = nombre;
  document.getElementById('staff-dropdown').classList.remove('show');

  document.getElementById('staff-avatar').textContent = nombre.charAt(0).toUpperCase();
  document.getElementById('staff-name').textContent = nombre;
  document.getElementById('staff-email-display').textContent = email;
  document.getElementById('staff-selected').classList.remove('hidden');

  updateChip('chip-staff', 'Staff: ' + nombre.split(' ')[0], false);
  document.getElementById('staff-field').classList.remove('is-invalid');
}

function clearStaff() {
  document.getElementById('staff_b').value = '';
  document.getElementById('staff-selected').classList.add('hidden');
  updateChip('chip-staff', 'Staff: —', true);
}

// ========== 5. CHIPS DE RESUMEN ==========
function updateChip(chipId, text, isEmpty) {
  var chip = document.getElementById(chipId);
  if (isEmpty || text.includes('—')) {
    chip.classList.add('empty');
    chip.innerHTML = chip.innerHTML.split('</i>')[0] + '</i> ' + text.split(':')[0] + ': —';
  } else {
    chip.classList.remove('empty');
    var icon = chip.querySelector('i').outerHTML;
    chip.innerHTML = icon + ' ' + text;
  }
}

function updateChips() {
  // RUT
  var rut = document.getElementById('rut_b').value;
  if (rut) updateChip('chip-rut', 'RUT: ' + rut, false);

  // Edad (ya se actualiza en selectEdad)

  // Procedimiento
  var proced = document.getElementById('procedimiento_b');
  if (proced && proced.value) updateChip('chip-proced', 'Procedimiento: ' + proced.value, false);

  // Fecha
  var fecha = document.getElementById('datepicker').value;
  if (fecha) updateChip('chip-fecha', 'Fecha: ' + fecha, false);

  // Vía Aérea
  var viaAerea = document.getElementById('seeAnotherFieldGroup');
  if (viaAerea && viaAerea.value) updateChip('chip-via-aerea', 'Vía Aérea: ' + viaAerea.value, false);

  // Acceso Vascular
  var acceso = document.getElementById('acceso_vascular_b');
  if (acceso && acceso.value) updateChip('chip-acceso', 'Acceso: ' + acceso.value, false);

  // Invasivo
  var invasivo = document.getElementById('invasivo_b');
  if (invasivo && invasivo.value) updateChip('chip-invasivo', 'Invasivo: ' + invasivo.value, false);

  // Neuroaxial
  var neuro = document.getElementById('neuroaxial_b');
  if (neuro && neuro.value) updateChip('chip-neuroaxial', 'Neuroaxial: ' + neuro.value, false);

  // Regional
  var regional = document.getElementById('regional_b');
  if (regional && regional.value) updateChip('chip-regional', 'Regional: ' + regional.value, false);

  // Dolor
  var dolor = document.getElementById('dolor_b');
  if (dolor && dolor.value) updateChip('chip-dolor', 'Dolor: ' + dolor.value, false);
}

// ========== VALIDACIÓN DEL FORMULARIO ==========
(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      var isValid = true;

      // Validar RUT
      var rutInput = document.getElementById('rut_b');
      if (!validateRutImmediate(rutInput)) {
        isValid = false;
      }

      // Validar Edad
      if (!document.getElementById('edad_b').value) {
        document.getElementById('edad-field').classList.add('is-invalid');
        isValid = false;
      }

      // Validar Curso/Rotación
      if (!document.getElementById('procedimiento_b').value.trim()) {
        document.getElementById('proced-field').classList.add('is-invalid');
        isValid = false;
      }

      // Validar Staff
      if (!document.getElementById('staff_b').value.trim()) {
        document.getElementById('staff-field').classList.add('is-invalid');
        isValid = false;
      }

      if (!isValid || !form.checkValidity()) {
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

<!-- Modal del Escáner de Código de Barras -->
<div class="modal" id="barcodeScannerModal" tabindex="-1" aria-labelledby="barcodeScannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="barcodeScannerModalLabel">
          <i class="fa-solid fa-barcode me-2"></i>Escanear Código de Barras
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeBarcodeScanner()"></button>
      </div>
      <div class="modal-body">
        <div class="scanner-container">
          <p class="scanner-description">
            Escanea el código de barras de la ficha hospitalaria. El sistema usa Barcode + OCR en paralelo.
          </p>

          <!-- Área de cámara -->
          <div id="camera-container">
            <div id="interactive" class="viewport">
              <!-- Guías visuales según formato ficha hospitalaria -->
              <div class="guide-barcode"></div>
              <div class="guide-rut"></div>
              <div class="guide-ficha"></div>
            </div>
          </div>

          <!-- Check verde (aparece al completar) -->
          <div id="success-check" class="success-check hidden">
            <i class="fa-solid fa-check-circle"></i>
            <span>¡Código escaneado!</span>
          </div>

          <!-- Estado OCR -->
          <div class="ocr-status" id="ocr-status"></div>

          <!-- Resultados -->
          <div class="result-container mt-4">
            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="result-label">RUT:</div>
                <input type="text" id="scan-rut" class="form-control form-control-lg" placeholder="Esperando escaneo..." readonly style="font-family:monospace;">
              </div>
              <div class="col-md-6 mb-3">
                <div class="result-label">Ficha:</div>
                <input type="text" id="scan-ficha" class="form-control form-control-lg" placeholder="Esperando escaneo..." readonly style="font-family:monospace;">
              </div>
            </div>
          </div>

          <!-- Botón Reintentar -->
          <button id="btn-retry" class="btn-retry" onclick="retryScan()" disabled>
            <i class="fa-solid fa-rotate-right me-2"></i>Reintentar
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeBarcodeScanner()">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="confirmScan()" id="btn-confirm" disabled>
          <i class="fa-solid fa-check me-2"></i>Confirmar Datos
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Estilos del escáner -->
<style>
.scanner-container {
  max-width: 100%;
  margin: 0 auto;
}

.scanner-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--app-text, #1e293b);
  margin-bottom: 0.5rem;
}

.scanner-description {
  color: var(--app-muted, #64748b);
  margin-bottom: 1.5rem;
  text-align: center;
}

.viewport {
  position: relative;
  width: 100%;
  height: 60vh;
  background: #000;
  border-radius: 12px;
  overflow: hidden;
}

#camera-container.hidden {
  display: none;
}

.scanner-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 95%;
  height: 70%;
  border: 3px dashed rgba(255, 255, 255, 0.9);
  border-radius: 12px;
  pointer-events: none;
  box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
  z-index: 100;
}

.scanner-overlay::before {
  content: 'Alinea el código de barras aquí';
  position: absolute;
  top: -30px;
  left: 50%;
  transform: translateX(-50%);
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.85rem;
  white-space: nowrap;
}

/* Guías visuales según formato de ficha hospitalaria */
.guide-barcode {
  position: absolute;
  top: 10%;
  left: 15%;
  width: 80%;
  height: 18%;
  border: 3px solid rgba(255, 0, 0, 0.7);
  border-radius: 8px;
  pointer-events: none;
  box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.3);
}

.guide-barcode::before {
  content: 'CÓDIGO DE BARRAS';
  position: absolute;
  bottom: -20px;
  left: 5px;
  color: rgba(255, 0, 0, 0.9);
  font-size: 0.7rem;
  font-weight: 600;
}

.guide-rut {
  position: absolute;
  top: 2%;
  left: 15%;
  width: 45%;
  height: 7%;
  border: 3px solid rgba(0, 123, 255, 0.9);
  border-radius: 8px;
  pointer-events: none;
}

.guide-rut::before {
  content: 'RUN / RUT';
  position: absolute;
  top: -18px;
  left: 5px;
  color: rgba(0, 123, 255, 1);
  font-size: 0.7rem;
  font-weight: 700;
}

.guide-ficha {
  position: absolute;
  top: 2%;
  left: 2%;
  width: 12%;
  height: 65%;
  border: 3px solid rgba(40, 167, 69, 0.9);
  border-radius: 8px;
  pointer-events: none;
}

.guide-ficha::before {
  content: 'FICHA';
  position: absolute;
  top: -18px;
  left: 5px;
  color: rgba(40, 167, 69, 1);
  font-size: 0.7rem;
  font-weight: 700;
}

.result-container {
  background: var(--app-card, #ffffff);
  border: 1px solid var(--app-border, #e2e8f0);
  border-radius: 12px;
  padding: 1.5rem;
}

.result-label {
  font-weight: 600;
  color: var(--app-text, #1e293b);
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
}

.success-check {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 1.5rem;
  background: rgba(16, 185, 129, 0.1);
  border-radius: 12px;
  color: #059669;
  font-size: 1.1rem;
  font-weight: 600;
  margin-top: 1rem;
}

.success-check.hidden {
  display: none;
}

.success-check i {
  font-size: 1.5rem;
}

.btn-retry {
  width: 100%;
  padding: 12px 20px;
  background: var(--app-blue, #2563eb);
  color: #ffffff;
  border: none;
  border-radius: var(--app-radius-md, .95rem);
  font-size: .95rem;
  font-weight: 500;
  cursor: pointer;
  margin-top: 1rem;
  transition: all .2s ease;
}

.btn-retry:hover:not(:disabled) {
  background: #1d4ed8;
}

.btn-retry:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.ocr-status {
  margin-top: 1rem;
  padding: 10px 15px;
  background: rgba(59, 130, 246, 0.1);
  border-radius: 8px;
  color: var(--app-blue, #2563eb);
  font-size: 0.85rem;
  text-align: center;
}

body.theme-dark .result-container {
  background: var(--app-card, #1e293b);
  border-color: var(--app-border, #334155);
}

body.theme-dark .result-label {
  color: var(--app-text, #f1f5f9);
}

body.theme-dark .success-check {
  background: rgba(16, 185, 129, 0.15);
  color: #10b981;
}

body.theme-dark .ocr-status {
  background: rgba(59, 130, 246, 0.15);
  color: #60a5fa;
}
</style>

<!-- Quagga 2 y Tesseract.js -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.8.4/dist/quagga.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>

<!-- JavaScript del escáner -->
<script>
var isScanning = false;
var track = null;
var resultFound = false;
var ocrWorker = null;
var ocrInterval = null;
var scannerModal = null;

// Inicializar modal cuando carga Bootstrap
document.addEventListener('DOMContentLoaded', function() {
  if (typeof bootstrap !== 'undefined') {
    scannerModal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
  }
});

// Abrir modal del escáner
function openBarcodeScanner() {
  if (scannerModal) {
    scannerModal.show();
    setTimeout(startParallelScanning, 500);
  } else {
    // Fallback si Bootstrap no está cargado
    document.getElementById('barcodeScannerModal').style.display = 'block';
    document.getElementById('barcodeScannerModal').classList.add('show');
    setTimeout(startParallelScanning, 500);
  }
}

// Cerrar modal del escáner
function closeBarcodeScanner() {
  stopScanning();
  if (scannerModal) {
    scannerModal.hide();
  } else {
    document.getElementById('barcodeScannerModal').style.display = 'none';
    document.getElementById('barcodeScannerModal').classList.remove('show');
  }
}

// Confirmar datos escaneados
function confirmScan() {
  var rut = document.getElementById('scan-rut').value;
  var ficha = document.getElementById('scan-ficha').value;

  if (rut) {
    document.getElementById('rut_b').value = rut;
    formatRut(document.getElementById('rut_b'));
    validateRutImmediate(document.getElementById('rut_b'));
  }

  if (ficha) {
    document.getElementById('ficha_b').value = ficha;
  }

  closeBarcodeScanner();
}

// Reintentar escaneo
function retryScan() {
  document.getElementById('success-check').classList.add('hidden');
  document.getElementById('camera-container').classList.remove('hidden');
  document.getElementById('scan-rut').value = '';
  document.getElementById('scan-ficha').value = '';
  document.getElementById('ocr-status').textContent = '';
  document.getElementById('btn-retry').disabled = true;
  document.getElementById('btn-confirm').disabled = true;
  resultFound = false;
  startParallelScanning();
}

// Iniciar escaneo paralelo: Quagga + OCR
async function startParallelScanning() {
  resultFound = false;
  document.getElementById('ocr-status').textContent = 'Iniciando escaneo paralelo (Barcode + OCR)...';

  var constraints = {
    width: { min: 640, ideal: 1280 },
    height: { min: 480, ideal: 720 },
    facingMode: { exact: "environment" }
  };

  Quagga.init({
    inputStream: {
      name: "Live",
      type: "LiveStream",
      target: document.querySelector('#interactive'),
      constraints: constraints,
      area: {
        top: "0%",
        right: "0%",
        left: "0%",
        bottom: "55%"
      }
    },
    decoder: {
      readers: [{
        format: "code_39_reader",
        config: {
          suppressCode128: true
        }
      }]
    },
    locator: {
      patchSize: "medium",
      halfSample: true
    },
    numOfWorkers: 2,
    frequency: 10,
    locate: true
  }, function(err) {
    if (err) {
      console.error('Error iniciando Quagga:', err);
      document.getElementById('ocr-status').textContent = 'Error al iniciar la cámara. Asegúrate de dar permisos.';
      return;
    }

    Quagga.start();
    isScanning = true;

    // Guardar referencia al track para flash
    var video = document.querySelector('#interactive video');
    if (video && video.srcObject) {
      track = video.srcObject.getVideoTracks()[0];
    }

    console.log('Escaneando con cámara trasera...');

    // Iniciar OCR en paralelo
    startParallelOCR();
  });

  // Callback cuando se detecta código con Quagga
  Quagga.onDetected(function(result) {
    if (resultFound) return;
    var code = result.codeResult.code;
    console.log('Quagga detectó:', code);
    handleResult('barcode', code);
  });
}

// Iniciar OCR en paralelo con Quagga
async function startParallelOCR() {
  try {
    // Esperar un poco para que la cámara se estabilice
    await new Promise(resolve => setTimeout(resolve, 1000));

    // Ejecutar OCR periódicamente
    ocrInterval = setInterval(async function() {
      if (resultFound || !isScanning) {
        clearInterval(ocrInterval);
        return;
      }

      try {
        var fullCanvas = captureImageForOCR();
        var rutCanvas = cropArea(fullCanvas, 2, 15, 45, 7);
        var fichaCanvas = cropArea(fullCanvas, 2, 2, 12, 65);

        const workerRut = await Tesseract.createWorker('spa');
        await workerRut.setParameters({ tessedit_char_whitelist: '0123456789.-Kk' });
        const resultRut = await workerRut.recognize(rutCanvas);
        await workerRut.terminate();

        const workerFicha = await Tesseract.createWorker('spa');
        await workerFicha.setParameters({ tessedit_char_whitelist: '0123456789' });
        const resultFicha = await workerFicha.recognize(fichaCanvas);
        await workerFicha.terminate();

        var rutText = resultRut.data.text.trim();
        var fichaText = resultFicha.data.text.trim();

        if (rutText || fichaText) {
          console.log('OCR detectó - RUT:', rutText, 'Ficha:', fichaText);
          handleResult('ocr', { rut: rutText, ficha: fichaText });
        }
      } catch (err) {
        console.error('Error en OCR paralelo:', err);
      }
    }, 2000); // Intentar OCR cada 2 segundos

  } catch (err) {
    console.error('Error iniciando OCR paralelo:', err);
  }
}

// Manejar resultado (sea de Quagga u OCR)
function handleResult(source, data) {
  if (resultFound) return;
  resultFound = true;

  // Detener ambos procesos
  clearInterval(ocrInterval);
  stopScanning();

  console.log('Resultado ganador:', source, data);

  if (source === 'barcode') {
    // Procesar código de barras
    processBarcode(data);
  } else if (source === 'ocr') {
    // Procesar resultado OCR
    processOCRResult(data.rut, data.ficha);
  }
}

// Procesar resultado OCR
function processOCRResult(rutText, fichaText) {
  var updated = false;

  // Procesar RUT del OCR
  if (rutText) {
    var cleanRut = rutText.replace(/\s/g, '');
    var rutMatch = cleanRut.match(/(\d{1,2}\.?\d{3}\.?\d{3}-[\dKk])/);
    var rutSimple = cleanRut.match(/(\d{7,8}-[\dKk])/);

    if (rutMatch) {
      document.getElementById('scan-rut').value = rutMatch[1];
      updated = true;
    } else if (rutSimple) {
      document.getElementById('scan-rut').value = rutSimple[1].toUpperCase();
      updated = true;
    }
  }

  // Procesar Ficha del OCR
  if (fichaText) {
    var cleanFicha = fichaText.replace(/\s/g, '');
    var fichaMatch = cleanFicha.match(/(\d{6})/);
    if (fichaMatch) {
      document.getElementById('scan-ficha').value = fichaMatch[1];
      updated = true;
    }
  }

  if (updated) {
    document.getElementById('ocr-status').textContent = '¡OCR ganó la carrera! Datos capturados.';
  }

  // Ocultar cámara y mostrar éxito
  document.getElementById('camera-container').classList.add('hidden');
  document.getElementById('success-check').classList.remove('hidden');
  document.getElementById('btn-retry').disabled = false;
  document.getElementById('btn-confirm').disabled = false;
}

// Procesar código de barras: separar RUT-FICHA y calcular DV
function processBarcode(code) {
  var parts = code.split('-');
  var rutNumeros = '';
  var ficha = '';

  if (parts.length >= 2) {
    rutNumeros = parts[0];
    ficha = parts[parts.length - 1];
  } else if (parts.length === 1) {
    rutNumeros = parts[0];
    ficha = '';
  } else {
    rutNumeros = code;
    ficha = '';
  }

  // Calcular DV y formatear RUT
  var rut = formatearRUTConDV(rutNumeros);

  // Guardar en inputs del escáner
  document.getElementById('scan-rut').value = rut;
  document.getElementById('scan-ficha').value = ficha;

  document.getElementById('ocr-status').textContent = '¡Barcode ganó la carrera! Código escaneado.';

  // Ocultar cámara y mostrar éxito
  document.getElementById('camera-container').classList.add('hidden');
  document.getElementById('success-check').classList.remove('hidden');

  // Habilitar botones
  document.getElementById('btn-retry').disabled = false;
  document.getElementById('btn-confirm').disabled = false;
}

// Calcular dígito verificador del RUT chileno
function calcularDV(rut) {
  var suma = 0;
  var multiplo = 2;
  for (var i = rut.length - 1; i >= 0; i--) {
    suma += parseInt(rut.charAt(i)) * multiplo;
    multiplo = multiplo < 7 ? multiplo + 1 : 2;
  }
  var dv = 11 - (suma % 11);
  if (dv === 11) return '0';
  if (dv === 10) return 'K';
  return dv.toString();
}

// Formatear RUT con DV
function formatearRUTConDV(rutNumeros) {
  var dv = calcularDV(rutNumeros);
  return rutNumeros + '-' + dv;
}

// Capturar imagen del video para OCR
function captureImageForOCR() {
  var video = document.querySelector('#interactive video');
  if (!video) {
    throw new Error('No se encontró el elemento de video');
  }

  var canvas = document.createElement('canvas');
  canvas.width = video.videoWidth || 640;
  canvas.height = video.videoHeight || 480;

  var ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

  return canvas;
}

// Crop de área específica para OCR
function cropArea(sourceCanvas, topPct, leftPct, widthPct, heightPct) {
  var width = sourceCanvas.width;
  var height = sourceCanvas.height;

  var cropCanvas = document.createElement('canvas');
  cropCanvas.width = width * (widthPct / 100);
  cropCanvas.height = height * (heightPct / 100);

  var ctx = cropCanvas.getContext('2d');
  ctx.drawImage(
    sourceCanvas,
    width * (leftPct / 100),
    height * (topPct / 100),
    width * (widthPct / 100),
    height * (heightPct / 100),
    0,
    0,
    cropCanvas.width,
    cropCanvas.height
  );

  return cropCanvas;
}

// Detener escaneo
function stopScanning() {
  if (isScanning) {
    Quagga.stop();
    isScanning = false;
  }
}
</script>

</file>
