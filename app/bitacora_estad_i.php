<?php
// Ve si está activa la cookie o redirige al login
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
  header('Location: login.php');
  exit;
}

// Conexión
require("conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8");

// Redirección según nivel de usuario
$check_usuario = $_COOKIE['hkjh41lu4l1k23jhlkj13'];
$con_users_b = "SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
$users_b = $conexion->query($con_users_b);
$usuario = $users_b->fetch_assoc();

if($usuario['admin'] == 1){
  // continúa
} elseif($usuario['staff_'] == 1){
  // continúa
} elseif($usuario['intern_'] == 1 || $usuario['becad_otro'] == 1){
  // continúa
} elseif($usuario['becad_'] == 1){
  header('Location: bitacora_estadistica.php');
  exit;
}

// Variables UI
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Bitácora</span>";
$boton_navbar = "<a></a>";

// Carga Head
require("head.php");

if (isset($_POST['revision_i']) && !empty($_POST['revision_i'])) {
  $autor_i = $_POST['revision_i'];
} else {
  $autor_i = $_COOKIE['hkjh41lu4l1k23jhlkj13'];
}

// Datos del usuario revisado
$select_name = "SELECT `nombre_usuario`, `link_minicex` FROM `usuarios_dolor` WHERE `email_usuario` = '$autor_i'";
$name_query = $conexion->query($select_name);
$name_row = $name_query->fetch_assoc();

// Busca los datos del interno según autor, que estén validados
$consulta_est = "SELECT * FROM `bitacora_internos` WHERE `autor_i` = '$autor_i' AND `aprobado_staff_i` = '1'";
$busqueda_est = $conexion->query($consulta_est);

if(!$busqueda_est){
  die("Error SQL bitacora_internos: " . $conexion->error);
}

$total_registros_i = mysqli_num_rows($busqueda_est);

// Catálogos
$edad_1='RNPT';
$edad_2='Neonato';
$edad_3='Menor de 6 meses';
$edad_4='6 meses a 1 año';
$edad_5='1 Año a 15 años';
$edad_6='Adulto';
$edad_7='Adulto de 70 años y mayor';

$procedimiento_1='Cirugía General';
$procedimiento_2='Cirugía Pediátrica';
$procedimiento_3='Gineco-Obstetricia';
$procedimiento_4='Cirugía de Tórax/Vascular';
$procedimiento_5='Neurocirugía';
$procedimiento_6='Cirugía Cardiovascular';
$procedimiento_7='Cirugía Ambulatoria';
$procedimiento_8='Turno/Urgencias';
$procedimiento_9='Cirugía Urológica';
$procedimiento_10='Traumatología y Regional';
$procedimiento_11='Dolor';
$procedimiento_12='Electivo';
$procedimiento_13='UCI/UTI';

$edad_b_1=0; $edad_b_2=0; $edad_b_3=0; $edad_b_4=0; $edad_b_5=0; $edad_b_6=0; $edad_b_7=0;

$procedimiento_b_1=0; $procedimiento_b_2=0; $procedimiento_b_3=0; $procedimiento_b_4=0;
$procedimiento_b_5=0; $procedimiento_b_6=0; $procedimiento_b_7=0; $procedimiento_b_8=0;
$procedimiento_b_9=0; $procedimiento_b_10=0; $procedimiento_b_11=0; $procedimiento_b_12=0;
$procedimiento_b_13=0;

$evaluacion_ok=0; $evaluacion_ayuda=0; $evaluacion_fallida=0;
$ventilacion_ok=0; $ventilacion_ayuda=0; $ventilacion_fallida=0;
$intubacion_ok=0; $intubacion_ayuda=0; $intubacion_fallida=0;
$lma_ok=0; $lma_ayuda=0; $lma_fallida=0;
$ayudas_ok=0; $ayudas_ayuda=0; $ayudas_fallida=0;
$vvp_ok=0; $vvp_ayuda=0; $vvp_fallida=0;
$espinal_ok=0; $espinal_ayuda=0; $espinal_fallida=0;

while($estad = $busqueda_est->fetch_assoc()){

  $edad_val = html_entity_decode(trim((string)$estad['edad_i']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $procedimiento_val = html_entity_decode(trim((string)$estad['procedimiento_i']), ENT_QUOTES | ENT_HTML5, 'UTF-8');

  if($edad_val === $edad_1) $edad_b_1++;
  if($edad_val === $edad_2) $edad_b_2++;
  if($edad_val === $edad_3) $edad_b_3++;
  if($edad_val === $edad_4) $edad_b_4++;
  if($edad_val === $edad_5) $edad_b_5++;
  if($edad_val === $edad_6) $edad_b_6++;
  if($edad_val === $edad_7) $edad_b_7++;

  if($procedimiento_val === $procedimiento_1) $procedimiento_b_1++;
  if($procedimiento_val === $procedimiento_2) $procedimiento_b_2++;
  if($procedimiento_val === $procedimiento_3) $procedimiento_b_3++;
  if($procedimiento_val === $procedimiento_4) $procedimiento_b_4++;
  if($procedimiento_val === $procedimiento_5) $procedimiento_b_5++;
  if($procedimiento_val === $procedimiento_6) $procedimiento_b_6++;
  if($procedimiento_val === $procedimiento_7) $procedimiento_b_7++;
  if($procedimiento_val === $procedimiento_8) $procedimiento_b_8++;
  if($procedimiento_val === $procedimiento_9) $procedimiento_b_9++;
  if($procedimiento_val === $procedimiento_10) $procedimiento_b_10++;
  if($procedimiento_val === $procedimiento_11) $procedimiento_b_11++;
  if($procedimiento_val === $procedimiento_12) $procedimiento_b_12++;
  if($procedimiento_val === $procedimiento_13) $procedimiento_b_13++;

  if($estad['evaluacion_i'] == "1") $evaluacion_ok++;
  if($estad['evaluacion_i'] == "2") $evaluacion_ayuda++;
  if($estad['evaluacion_i'] == "3") $evaluacion_fallida++;

  if($estad['ventilacion_i'] == "1") $ventilacion_ok++;
  if($estad['ventilacion_i'] == "2") $ventilacion_ayuda++;
  if($estad['ventilacion_i'] == "3") $ventilacion_fallida++;

  if($estad['intubacion_i'] == "1") $intubacion_ok++;
  if($estad['intubacion_i'] == "2") $intubacion_ayuda++;
  if($estad['intubacion_i'] == "3") $intubacion_fallida++;

  if($estad['lma_i'] == "1") $lma_ok++;
  if($estad['lma_i'] == "2") $lma_ayuda++;
  if($estad['lma_i'] == "3") $lma_fallida++;

  if($estad['ayudas_i'] == "1") $ayudas_ok++;
  if($estad['ayudas_i'] == "2") $ayudas_ayuda++;
  if($estad['ayudas_i'] == "3") $ayudas_fallida++;

  if($estad['vvp_i'] == "1") $vvp_ok++;
  if($estad['vvp_i'] == "2") $vvp_ayuda++;
  if($estad['vvp_i'] == "3") $vvp_fallida++;

  if($estad['espinal_i'] == "1") $espinal_ok++;
  if($estad['espinal_i'] == "2") $espinal_ayuda++;
  if($estad['espinal_i'] == "3") $espinal_fallida++;
}
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="bitacora-shell bitacora-shell-wide">

<?php if($usuario['admin']==1 || $usuario['staff_']==1){ ?>

      <div class='bitacora-topbar'>
        <div class='d-flex justify-content-between align-items-start gap-3'>
          <div>
            <div class='small opacity-75 mb-1'>APP clínica • estadística docente</div>
            <h1 class='h4 mb-2'>Estadística de Bitácora Internos</h1>
            <div class='subtle text-white-50'>Visualiza los registros validados de internos y otros usuarios equivalentes.</div>
          </div>
          <span class='pill bg-light text-dark'>Staff</span>
        </div>
      </div>

      <ul class='nav nav-tabs bitacora-tabs pt-1'>
        <li class='nav-item'>
          <a class='nav-link' href='bitacora_autoriza.php'>Validación</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='bitacora_revision.php'>Revisión</a>
        </li>
      </ul>

<?php } else { ?>

      <div class='bitacora-topbar'>
        <div class='d-flex justify-content-between align-items-start gap-3'>
          <div>
            <div class='small opacity-75 mb-1'>APP clínica • estadística personal</div>
            <h1 class='h4 mb-2'>Estadística de Bitácora Internos</h1>
            <div class='subtle text-white-50'>Revisa el resumen de tus procedimientos validados.</div>
          </div>
          <span class='pill bg-light text-dark'>Interno</span>
        </div>
      </div>

      <ul class='nav nav-tabs bitacora-tabs pt-1'>
        <li class='nav-item'>
          <a class='nav-link' href='bitacora_internos.php'>Ingreso</a>
        </li>
        <li class='nav-item'>
          <span class='nav-link active' aria-current='page'>Estadística</span>
        </li>
      </ul>

<?php } ?>

      <div class="bitacora-summary-card">
        <div class="bitacora-summary-header">
          <h4 class='mb-1 fw-bold pt-2'>Estadística de <?php echo app_h_text($name_row['nombre_usuario']); ?></h4>
        </div>
      </div>


<?php if($total_registros_i == 0){ ?>
  <div class="alert alert-warning">
    No se encontraron registros validados en <b>bitacora_internos</b> para:
    <br><b><?php echo $autor_i; ?></b>
  </div>
<?php } ?>




      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        google.charts.load("current", {packages:['corechart']});
      </script>

      <div class="charts-grid">

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_edad_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_proc_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_eval_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_vent_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_int_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_lma_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_ayudas_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_vvp_i" class="chart-canvas"></div>
          </div>
        </div>

        <div class="chart-col">
          <div class="bitacora-chart-card">
            <div id="chart_espinal_i" class="chart-canvas"></div>
          </div>
        </div>

      </div>

      <script type="text/javascript">
        function appChartThemeOptions(options){
          if (!document.body.classList.contains("theme-dark")) return options;

          return Object.assign({}, options, {
            backgroundColor: "transparent",
            titleTextStyle: { color: "#eef4ff", bold: true },
            legend: { position: "none", textStyle: { color: "#eef4ff" } },
            hAxis: Object.assign({}, options.hAxis || {}, {
              textStyle: { color: "#cbd5e1" },
              titleTextStyle: { color: "#eef4ff" },
              gridlines: { color: "#334155" },
              baselineColor: "#64748b"
            }),
            vAxis: Object.assign({}, options.vAxis || {}, {
              textStyle: { color: "#cbd5e1" },
              titleTextStyle: { color: "#eef4ff" },
              gridlines: { color: "#334155" },
              baselineColor: "#64748b"
            })
          });
        }

        function buildColumnChart(containerId, title, rows, slanted=false){
          var data = google.visualization.arrayToDataTable(rows);

          var view = new google.visualization.DataView(data);
          view.setColumns([
            0,
            1,
            {
              calc: "stringify",
              sourceColumn: 1,
              type: "string",
              role: "annotation"
            },
            2
          ]);

          var options = {
            title: title,
            height: 300,
            chartArea: {
              left: 45,
              right: 20,
              top: 40,
              bottom: 70,
              width: '100%',
              height: '70%'
            },
            bar: { groupWidth: "95%" },
            legend: { position: "none" },
            hAxis: {
              slantedText: slanted,
              slantedTextAngle: slanted ? 60 : 0
            }
          };

          var chart = new google.visualization.ColumnChart(document.getElementById(containerId));
          chart.draw(view, appChartThemeOptions(options));
        }

        function drawEdadI(){
          buildColumnChart("chart_edad_i", "Rango Etáreo", [
            ["Edad", "Valor", { role: "style" }],
            ["RNPT", <?php echo $edad_b_1; ?>, "#009044"],
            ["Neonato", <?php echo $edad_b_2; ?>, "#026edd"],
            ["1-6m", <?php echo $edad_b_3; ?>, "#9b4df1"],
            ["6m-1a", <?php echo $edad_b_4; ?>, "#f7de68"],
            ["1a-15a", <?php echo $edad_b_5; ?>, "#f73f3f"],
            ["Adulto", <?php echo $edad_b_6; ?>, "#7BD3CE"],
            [">70a", <?php echo $edad_b_7; ?>, "#F8BBD0"]
          ]);
        }

        function drawProcI(){
          buildColumnChart("chart_proc_i", "Tipo de Procedimiento", [
            ["Cirugía", "Valor", { role: "style" }],
            ["Gral", <?php echo $procedimiento_b_1; ?>, "#009044"],
            ["Ped", <?php echo $procedimiento_b_2; ?>, "#026edd"],
            ["Gine", <?php echo $procedimiento_b_3; ?>, "#9b4df1"],
            ["Tx/Vasc", <?php echo $procedimiento_b_4; ?>, "#f7de68"],
            ["Neuro", <?php echo $procedimiento_b_5; ?>, "#f73f3f"],
            ["Cardio", <?php echo $procedimiento_b_6; ?>, "#7BD3CE"],
            ["Amb.", <?php echo $procedimiento_b_7; ?>, "#F8BBD0"],
            ["Turno", <?php echo $procedimiento_b_8; ?>, "#009044"],
            ["Uro", <?php echo $procedimiento_b_9; ?>, "#026edd"],
            ["Trauma", <?php echo $procedimiento_b_10; ?>, "#9b4df1"],
            ["Dolor", <?php echo $procedimiento_b_11; ?>, "#f7de68"],
            ["Electivo", <?php echo $procedimiento_b_12; ?>, "#f73f3f"],
            ["UCI", <?php echo $procedimiento_b_13; ?>, "#7BD3CE"]
          ], true);
        }

        function drawEvalI(){
          buildColumnChart("chart_eval_i", "Eval. Preanestésica", [
            ["Evaluación", "Valor", { role: "style" }],
            ["Completa", <?php echo $evaluacion_ok; ?>, "#009044"],
            ["Con ayuda", <?php echo $evaluacion_ayuda; ?>, "#f7de68"],
            ["No realizada", <?php echo $evaluacion_fallida; ?>, "#f73f3f"]
          ]);
        }

        function drawVentI(){
          buildColumnChart("chart_vent_i", "Ventilación", [
            ["Ventilación", "Valor", { role: "style" }],
            ["Solo", <?php echo $ventilacion_ok; ?>, "#009044"],
            ["Con ayuda", <?php echo $ventilacion_ayuda; ?>, "#f7de68"],
            ["Fallida", <?php echo $ventilacion_fallida; ?>, "#f73f3f"]
          ]);
        }

        function drawIntI(){
          buildColumnChart("chart_int_i", "Intubación", [
            ["Intubación", "Valor", { role: "style" }],
            ["Solo", <?php echo $intubacion_ok; ?>, "#009044"],
            ["Con ayuda", <?php echo $intubacion_ayuda; ?>, "#f7de68"],
            ["Fallida", <?php echo $intubacion_fallida; ?>, "#f73f3f"]
          ]);
        }

        function drawLmaI(){
          buildColumnChart("chart_lma_i", "Máscara Laríngea", [
            ["LMA", "Valor", { role: "style" }],
            ["Solo", <?php echo $lma_ok; ?>, "#009044"],
            ["Con ayuda", <?php echo $lma_ayuda; ?>, "#f7de68"],
            ["Fallida", <?php echo $lma_fallida; ?>, "#f73f3f"]
          ]);
        }

        function drawAyudasI(){
          buildColumnChart("chart_ayudas_i", "Conductor / Bougie", [
            ["Ayudas", "Valor", { role: "style" }],
            ["Solo", <?php echo $ayudas_ok; ?>, "#009044"],
            ["Con ayuda", <?php echo $ayudas_ayuda; ?>, "#f7de68"],
            ["Fallida", <?php echo $ayudas_fallida; ?>, "#f73f3f"]
          ]);
        }

        function drawVvpI(){
          buildColumnChart("chart_vvp_i", "Vía Venosa Periférica", [
            ["VVP", "Valor", { role: "style" }],
            ["Solo", <?php echo $vvp_ok; ?>, "#009044"],
            ["Con ayuda", <?php echo $vvp_ayuda; ?>, "#f7de68"],
            ["Fallida", <?php echo $vvp_fallida; ?>, "#f73f3f"]
          ]);
        }

        function drawEspinalI(){
          buildColumnChart("chart_espinal_i", "Espinal / Raquídea", [
            ["Espinal", "Valor", { role: "style" }],
            ["Solo", <?php echo $espinal_ok; ?>, "#009044"],
            ["Con ayuda", <?php echo $espinal_ayuda; ?>, "#f7de68"],
            ["Fallida", <?php echo $espinal_fallida; ?>, "#f73f3f"]
          ]);
        }

        google.charts.setOnLoadCallback(drawEdadI);
        google.charts.setOnLoadCallback(drawProcI);
        google.charts.setOnLoadCallback(drawEvalI);
        google.charts.setOnLoadCallback(drawVentI);
        google.charts.setOnLoadCallback(drawIntI);
        google.charts.setOnLoadCallback(drawLmaI);
        google.charts.setOnLoadCallback(drawAyudasI);
        google.charts.setOnLoadCallback(drawVvpI);
        google.charts.setOnLoadCallback(drawEspinalI);

        window.addEventListener('resize', function(){
          drawEdadI();
          drawProcI();
          drawEvalI();
          drawVentI();
          drawIntI();
          drawLmaI();
          drawAyudasI();
          drawVvpI();
          drawEspinalI();
        });
      </script>

    </div>
  </div>
</div>
</div>
<?php
$conexion->close();
require("footer.php");
?>
