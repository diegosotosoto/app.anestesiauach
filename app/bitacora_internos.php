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
  //CONTINUA EN LA PAGINA
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
    padding:1.1rem 1.1rem 1.2rem 1.1rem;
  }

  .bitacora-field{
    margin-bottom:1rem;
  }

  .bitacora-label-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:1rem;
    margin-bottom:.45rem;
  }

  .bitacora-label{
    color:#5f6b76;
    font-weight:500;
  }

  .bitacora-required{
    font-size:.82rem;
    color:#98a2b3;
  }

  .bitacora-input,
  .bitacora-select,
  .bitacora-textarea{
    border:1px solid #dfe7f2;
    border-radius:.95rem;
  }

  .bitacora-input,
  .bitacora-select{
    min-height:52px;
  }

  .bitacora-textarea{
    resize:none;
  }

  .bitacora-submit{
    border-radius:.95rem;
    font-weight:600;
    padding:.85rem 1.1rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
  }

  @media (max-width: 767px){
    .bitacora-label-row{
      flex-direction:column;
      align-items:flex-start;
      gap:.15rem;
    }
  }
</style>

<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="bitacora-shell">

<?php
//Guarda la Bitácora
if($_POST['rut_i']){

  $autor_i=strtolower(urldecode($_COOKIE['hkjh41lu4l1k23jhlkj13']));
  $rut_i=htmlentities(addslashes(strtoupper($_POST['rut_i'])));
  $ficha_i=htmlentities(addslashes($_POST['ficha_i']));
  $edad_i=htmlentities(addslashes($_POST['edad_i']));
  $procedimiento_i=htmlentities(addslashes($_POST['procedimiento_i']));
  $fecha_i=htmlentities(addslashes($_POST['fecha_i']));
  $evaluacion_i=htmlentities(addslashes($_POST['evaluacion_i']));
  $ventilacion_i=htmlentities(addslashes($_POST['ventilacion_i']));
  $intubacion_i=htmlentities(addslashes($_POST['intubacion_i']));
  $lma_i=htmlentities(addslashes($_POST['lma_i']));
  $ayudas_i=htmlentities(addslashes($_POST['ayudas_i']));
  $vvp_i=htmlentities(addslashes($_POST['vvp_i']));
  $espinal_i=htmlentities(addslashes($_POST['espinal_i']));
  $seminario_i=htmlentities(addslashes($_POST['seminario_i']));
  $staff_i=htmlentities(addslashes($_POST['staff_i']));
  $comentarios_i=htmlentities(addslashes($_POST['comentarios_i']));

  $confirma_bitacora_i="SELECT * FROM `bitacora_internos` WHERE `rut_i` = '$rut_i' AND `ficha_i` = '$ficha_i' AND `fecha_i` = '$fecha_i' AND `autor_i` = '$autor_i' AND `evaluacion_i` = '$evaluacion_i' AND `ventilacion_i` = '$ventilacion_i' AND `intubacion_i` = '$intubacion_i' AND `lma_i` = '$lma_i' AND `ayudas_i` = '$ayudas_i' AND `vvp_i` = '$vvp_i' AND `espinal_i` = '$espinal_i'";
  $consulta_ci=$conexion->query($confirma_bitacora_i);
  $respuesta_ci=mysqli_num_rows($consulta_ci);

  if($respuesta_ci>=1){
    echo "<div class='alert alert-danger alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> Ya existe un registro ingresado por ".$autor_i." con fecha ".$fecha_i." , para el paciente Rut :".$rut_i.". <strong>No se ha ingresado el nuevo registro</strong>
    </div>";
  }else{
    $consulta_i="INSERT INTO `bitacora_internos` (`autor_i`, `rut_i`, `ficha_i`, `edad_i`, `procedimiento_i`, `fecha_i`, `evaluacion_i`, `ventilacion_i`, `intubacion_i`, `lma_i`, `ayudas_i`, `vvp_i`, `espinal_i`, `seminario_i`, `staff_i`, `comentarios_i`) VALUES ('$autor_i','$rut_i', '$ficha_i', '$edad_i', '$procedimiento_i', '$fecha_i', '$evaluacion_i', '$ventilacion_i', '$intubacion_i', '$lma_i', '$ayudas_i', '$vvp_i', '$espinal_i', '$seminario_i', '$staff_i', '$comentarios_i') ";
    $escribir_i=$conexion->query($consulta_i);

    if($escribir_i==false){
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
            <div class="small opacity-75 mb-1">APP clínica • registro de procedimientos</div>
            <h1 class="h4 mb-2">Ingreso de Bitácora</h1>
            <div class="subtle text-white-50">Registra actividades de internado o pasantía y asígnalas al anestesiólogo responsable para su validación.</div>
          </div>
          <span class="pill bg-light text-dark">Interno / Pasante</span>
        </div>
      </div>

      <ul class="nav nav-tabs bitacora-tabs">
        <li class="nav-item">
          <span class="nav-link active" aria-current="page">Ingreso</span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="bitacora_estad_i.php">Estadística</a>
        </li>
      </ul>

      <form class="needs-validation" name="form_ingreso_bit" id="form_ingreso_bit" method="post" action="bitacora_internos.php" novalidate>

        <div class="bitacora-card">
          <div class="bitacora-card-header">
            <h4 class='mb-1 fw-bold pt-2'>Bitácora de</h4>
            <div class='text-black-50 pb-2 pt-1' style='font-size: 14px'><?php echo $_COOKIE['hkjh41lu4l1k23jhlkj13']; ?></div>
          </div>

          <div class="bitacora-card-body">

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Rut Paciente <span class="opacity-50">(ej: 12345678-9)</span></div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <input class="form-control bitacora-input" type="text" oninput="checkRut(this)" name="rut_i" id="rut_i" required>
              <div class="invalid-feedback pt-1">Ingrese un RUT válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Ficha</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <input class="form-control bitacora-input" type="text" name="ficha_i" id="ficha_i" pattern="[0-9]{1,7}" required>
              <div class="invalid-feedback pt-1">Ingrese un número de ficha válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Edad</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <select class="form-select bitacora-select" id="edad_i" name="edad_i" required>
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
                <div class='bitacora-label'>Procedimiento</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <select class="form-select bitacora-select" id="procedimiento_i" name="procedimiento_i" required>
                <option value=""></option>
                <option value="Cirugía General">Cirugía General</option>
                <option value="Cirugía Pediátrica">Cirugía Pediátrica</option>
                <option value="Cesárea">Cesárea</option>
                <option value="Cirugía Vascular">Cirugía Vascular</option>
                <option value="Cirugía de Tórax">Cirugía de Tórax</option>
                <option value="Neurocirugía">Neurocirugía</option>
                <option value="Otra">Otra</option>
              </select>
              <div class="invalid-feedback pt-0">Ingrese un valor válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Fecha <span class="opacity-50">(dd/mm/aaaa)</span></div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <div class="input-group date">
                <input type="text" class="form-control bitacora-input" name="fecha_i" id="datepicker" required>
              </div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Evaluación Preanestésica</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="evaluacion_i" name="evaluacion_i">
                <option value=""></option>
                <option value="1">Evaluación Completa</option>
                <option value="2">Evaluación Incompleta</option>
                <option value="3">Evaluación No Realizada</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Ventilación</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="ventilacion_i" name="ventilacion_i">
                <option value=""></option>
                <option value="1">Exitosa Solo</option>
                <option value="2">Exitosa con Ayuda</option>
                <option value="3">Fallida</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Intubación</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="intubacion_i" name="intubacion_i">
                <option value=""></option>
                <option value="1">Exitosa Solo</option>
                <option value="2">Exitosa con Ayuda</option>
                <option value="3">Fallida</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Máscara Laríngea</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="lma_i" name="lma_i">
                <option value=""></option>
                <option value="1">Exitosa Solo</option>
                <option value="2">Exitosa con Ayuda</option>
                <option value="3">Fallida</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Uso Conductor / Bougie</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="ayudas_i" name="ayudas_i">
                <option value=""></option>
                <option value="1">Exitoso Solo</option>
                <option value="2">Exitoso con Ayuda</option>
                <option value="3">Fallido</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Vía Venosa Periférica</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="vvp_i" name="vvp_i">
                <option value=""></option>
                <option value="1">Exitosa Solo</option>
                <option value="2">Exitosa con Ayuda</option>
                <option value="3">Fallida</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Anestesia Espinal / Raquídea</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="espinal_i" name="espinal_i">
                <option value=""></option>
                <option value="1">Exitosa Solo</option>
                <option value="2">Exitosa con Ayuda</option>
                <option value="3">Fallida</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Realización Seminarios</div>
                <div class="bitacora-required"></div>
              </div>
              <select class="form-select bitacora-select" id="seminario_i" name="seminario_i">
                <option value=""></option>
                <option value="1">Vía Aérea</option>
                <option value="2">Anestesia Neuroaxial</option>
                <option value="3">RCP</option>
                <option value="4">Transfusiones</option>
                <option value="5">Dolor</option>
              </select>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Anestesiólog@ Responsable</div>
                <div class="bitacora-required">Requerido (*)</div>
              </div>
              <select class="form-select bitacora-select" id="staff_i" name="staff_i" required>
                <option value=""></option>
                <?php
                  $consulta_staff="SELECT `nombre_usuario` FROM `usuarios_dolor` WHERE `staff_` = '1' OR `admin` = '1' ";
                  $busqueda_staff=$conexion->query($consulta_staff);
                  while($staff=$busqueda_staff->fetch_assoc()){
                    echo "<option value='".$staff['nombre_usuario']."'>".$staff['nombre_usuario']."</option>";
                  }
                ?>
              </select>
              <div class="invalid-feedback pt-0 pb-1">Ingrese un valor válido</div>
            </div>

            <div class="bitacora-field">
              <div class='bitacora-label-row'>
                <div class='bitacora-label'>Comentarios</div>
                <div class="bitacora-required"></div>
              </div>
              <textarea class="form-control bitacora-textarea" maxlength="250" rows="5" name="comentarios_i" id="comentarios_i"></textarea>
            </div>

            <div class="pt-3 d-flex justify-content-end">
              <button class='btn btn-primary bitacora-submit shadow-sm border-light' type='submit' form='form_ingreso_bit' value='Submit' id='boton'>
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
