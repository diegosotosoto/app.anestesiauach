<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Calculadora docente de diluciones de drogas vasoactivas en pediatría / neonatología, basada en un esquema local de uso habitual en unidad neonatal. Permite ingresar el peso del paciente y obtener la preparación sugerida para que 1 mL/h de infusión corresponda a una dosis fija según cada fármaco.";
$formula = "Todas las diluciones se preparan en jeringa de 50 mL con SG 5%. El objetivo es que 1 mL/h entregue una dosis conocida por kg/min según la droga seleccionada.";
$referencias = array(
  "1.- Esquema local de diluciones de drogas vasoactivas en pediatría / neonatología, aportado por el usuario.",
  "2.- Referencia práctica institucional: verificar siempre protocolo local y presentación real de la ampolla antes de preparar.",
  "3.- Las presentaciones comerciales pueden variar según país, laboratorio y unidad clínica."
);

$icono_apunte = "<i class='fa-solid fa-heart-pulse pe-3 pt-2'></i>";
$titulo_apunte = "Dilución de Vasoactivos en Neonatología";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="vaso-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --bg:#f4f7fb;
            --soft:#f8fafc;
            --line:#dfe7f2;
            --text:#1f2a37;
            --muted:#667085;
            --good:#edf8f7;
            --warn:#fff9e8;
            --danger:#fff5f3;
            --mint:#eef7ff;
            --mint-border:#cfe1ff;
          }

          body{background:var(--bg);}
          .vaso-shell{max-width:980px;margin:0 auto;}

          .topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }
          .topbar h1{color:#fff;}

          .section-card{
            border:0;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;
            overflow:hidden;
            margin-bottom:1rem;
          }

          .section-title{
            font-size:.8rem;
            letter-spacing:.05em;
            text-transform:uppercase;
            color:var(--muted);
          }

          .pill{
            display:inline-block;
            padding:.2rem .55rem;
            border-radius:999px;
            font-size:.78rem;
            background:#eef3ff;
            color:#3559b7;
            font-weight:600;
          }

          .subtle{font-size:.94rem;color:#5f6b76;}
          .small-note{font-size:.84rem;color:var(--muted);}
          .footer-note{font-size:.82rem;color:#6c757d;}

          .info-box{
            background:#fff;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            margin-bottom:1rem;
            overflow:hidden;
          }

          .info-box-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:1rem;
            padding:1rem;
          }

          .info-box-title{
            font-size:.8rem;
            text-transform:uppercase;
            color:#667085;
            letter-spacing:.08em;
          }

          .info-toggle-btn{
            border-radius:.6rem;
            font-size:.85rem;
            padding:.35rem .7rem;
            white-space:nowrap;
            background:#6c757d;
            border:none;
            color:white;
            transition:.2s;
          }

          .info-toggle-btn:hover{background:#5a6268;color:white;}

          .info-box-content{
            padding:1rem;
            display:none;
            animation:fadeIn .2s ease-in-out;
            border-top:1px solid #e9eef5;
          }

          @keyframes fadeIn{
            from{opacity:0; transform:translateY(-5px);}
            to{opacity:1; transform:translateY(0);}
          }

          .calc-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:1rem;
          }

          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .form-label-lite{
            font-size:.92rem;
            font-weight:600;
            color:var(--text);
            margin-bottom:.5rem;
          }

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.7rem;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:90px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:1rem;
            padding:.75rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.15;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
          }

          .choice-btn i{
            font-size:1.15rem;
            margin-bottom:.35rem;
          }

          .choice-check:checked + .choice-btn{
            transform:translateY(-1px);
            box-shadow:0 8px 18px rgba(0,0,0,.12);
            border:3px solid #3b82f6; /* azul fuerte */
          }

          .btn-ne{background:#eef4ff;}
          .btn-epi{background:#fff1f1;}
          .btn-dopa{background:#fff8db;}
          .btn-dobu{background:#edf8f7;}
          .btn-milri{background:#f3efff;}

          .choice-check:checked + .btn-ne{background:#dfe9ff;}
          .choice-check:checked + .btn-epi{background:#ffdede;}
          .choice-check:checked + .btn-dopa{background:#ffeeb0;}
          .choice-check:checked + .btn-dobu{background:#dbf3ef;}
          .choice-check:checked + .btn-milri{background:#e3d9ff;}

          .result-box{
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
            padding:1rem;
          }

          .result-row{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:1rem;
            padding:.9rem 1rem;
            border:1px solid #e6e9ef;
            border-radius:.9rem;
            background:#fff;
            margin-bottom:.7rem;
          }
          .result-row:last-child{margin-bottom:0;}

          .result-name{
            font-weight:700;
            color:#1f2a37;
            line-height:1.2;
          }

          .result-note{
            font-size:.84rem;
            color:#667085;
            margin-top:.2rem;
            line-height:1.4;
          }

          .result-value{
            min-width:160px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .highlight-dose{
            border-radius:1rem;
            padding:1.2rem;
            background:#fff7db;
            border:1px solid #f1db8b;
            text-align:center;
          }

          .highlight-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#7a5a00;
            margin-bottom:.45rem;
            font-weight:700;
          }

          .highlight-main{
            font-size:1.55rem;
            font-weight:900;
            color:#5f4600;
            line-height:1.2;
          }

          .highlight-soft{
            margin-top:.55rem;
            font-size:.92rem;
            color:#6b5a2b;
          }

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid #ecd798;
            border-radius:1rem;
            padding:1rem;
          }

          .danger-box{
            background:var(--danger);
            border:1px solid #efc4be;
            border-radius:1rem;
            padding:1rem;
          }

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .teaching-wrap{
            border-radius:1.3rem;
            background:#f4f7fb;
            padding:1.2rem;
          }

          .teaching-title{
            text-align:center;
            font-size:.9rem;
            text-transform:uppercase;
            color:#64748b;
            letter-spacing:.05em;
          }

          .teaching-main{
            text-align:center;
            font-size:1.6rem;
            font-weight:800;
            margin-bottom:1rem;
            line-height:1.15;
          }

          .teaching-card{
            background:#fff;
            border-radius:1rem;
            padding:1rem;
            border:1px solid #e5e7eb;
            margin-bottom:.8rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{margin-bottom:.4rem;}

          @media(max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .choice-grid{grid-template-columns:repeat(2,1fr);}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
            .teaching-main{font-size:1.25rem;}
          }

          @media(max-width:576px){
            .choice-grid{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • neonatología</div>
              <h1 class="h3 mb-2">Dilución de drogas vasoactivas en pediatría</h1>
              <div class="subtle text-white-50">Cálculo rápido según peso para preparaciones habituales en jeringa de 50 mL.</div>
            </div>
            <span class="pill bg-light text-dark">Neonatología</span>
          </div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>

          <div id="infoContent" class="info-box-content">
            <?php echo $descripcion_info; ?>

            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Comentario:</b><br>
              <?php echo $formula; ?>
            <?php } ?>

            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0">
                <?php foreach($referencias as $ref){ ?>
                  <li><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Datos de entrada</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Peso del paciente</label>
                <div class="input-group">
                  <input type="number" step="0.1" min="0" id="pesoPaciente" class="form-control">
                  <span class="input-group-text">kg</span>
                </div>
                <div class="small-note mt-2">
                  La calculadora asume preparación en jeringa de 50 mL con SG 5%, según el esquema local.
                </div>
              </div>




            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Drogas vasoactivas</div>

            <div class="choice-grid">
              <div>
                <input class="choice-check vaso-trigger" type="radio" name="vaso" id="vaso_ne" value="ne" checked>
                <label class="choice-btn btn-ne" for="vaso_ne">
                  <i class="fa-solid fa-arrow-up-right-dots"></i>
                  Noradrenalina
                  <span class="small-note mt-1">4 mg / 4 mL</span>
                </label>
              </div>

              <div>
                <input class="choice-check vaso-trigger" type="radio" name="vaso" id="vaso_epi" value="epi">
                <label class="choice-btn btn-epi" for="vaso_epi">
                  <i class="fa-solid fa-heart-circle-bolt"></i>
                  Adrenalina
                  <span class="small-note mt-1">1 mg / mL</span>
                </label>
              </div>

              <div>
                <input class="choice-check vaso-trigger" type="radio" name="vaso" id="vaso_dopa" value="dopa">
                <label class="choice-btn btn-dopa" for="vaso_dopa">
                  <i class="fa-solid fa-bolt"></i>
                  Dopamina
                  <span class="small-note mt-1">200 mg / 5 mL</span>
                </label>
              </div>

              <div>
                <input class="choice-check vaso-trigger" type="radio" name="vaso" id="vaso_dobu" value="dobu">
                <label class="choice-btn btn-dobu" for="vaso_dobu">
                  <i class="fa-solid fa-wave-square"></i>
                  Dobutamina
                  <span class="small-note mt-1">250 mg / 5 mL</span>
                </label>
              </div>

              <div>
                <input class="choice-check vaso-trigger" type="radio" name="vaso" id="vaso_milri" value="milri">
                <label class="choice-btn btn-milri" for="vaso_milri">
                  <i class="fa-solid fa-droplet"></i>
                  Milrinona
                  <span class="small-note mt-1">10 mg / 10 mL</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Preparación</div>

            <div class="result-box">
              <div class="result-row">
                <div>
                  <div class="result-name">Droga seleccionada</div>
                  <div id="drogaNombre" class="result-note">-</div>
                </div>
                <div id="drogaPresentacion" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Preparar en jeringa de 50 mL</div>
                  <div id="preparacionBase" class="result-note">Con suero glucosado al 5%</div>
                </div>
                <div id="cantidadMg" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Volumen a extraer desde la ampolla</div>
                  <div id="volumenAmpollaNota" class="result-note">Según presentación habitual</div>
                </div>
                <div id="volumenAmpolla" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Descripción práctica</div>
                  <div id="descripcionPreparacion" class="result-note">-</div>
                </div>
                <div id="descripcionCorta" class="result-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Dosis resultante</div>

            <div class="highlight-dose">
              <div class="highlight-label">Al programar la bomba en 1 mL/h</div>
              <div id="dosisEnfasis" class="highlight-main">-</div>
              <div id="dosisEnfasisSoft" class="highlight-soft">-</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">

              <div class="teaching-title">Tips para residentes</div>
              <div class="teaching-main">
                En vasoactivos neonatales, el error más peligroso no es calcular lento: es no verificar la presentación real de la ampolla
              </div>

              <div class="teaching-card">
                <b>La concentración se individualiza por peso</b><br>
                En este esquema, cada niño requiere una preparación distinta. No reutilices una jeringa ni asumas que “la concentración habitual” sirve para todos.
              </div>

              <div class="teaching-card">
                <b>1 mL/h no siempre significa lo mismo</b><br>
                Solo entrega la dosis indicada si preparaste exactamente la concentración correcta para ese peso y esa droga.
              </div>

              <div class="teaching-card">
                <b>Primero mg, después mL</b><br>
                Calcula siempre cuántos miligramos deben ir en la jeringa. Recién después traduce eso a mililitros según la presentación de la ampolla.
              </div>

              <div class="teaching-card">
                <b>Etiqueta siempre</b><br>
                Debe quedar escrito qué droga contiene la jeringa, cuánto se colocó, en qué volumen total quedó y a qué dosis corresponde 1 mL/h.
              </div>

              <div class="teaching-card">
                <b>Verifica compatibilidad y vía</b><br>
                Aunque el cálculo esté correcto, la seguridad depende además de la vía, la bomba correcta, la velocidad programada y la monitorización clínica del paciente.
              </div>

              <div class="danger-box">
                <b>Advertencia importante</b><br>
                Las ampollas pueden variar en presentación. Antes de preparar, comprueba la etiqueta física del medicamento y no te bases solo en memoria o costumbre.
              </div>

            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente basada en esquema local de diluciones. Verificar siempre presentación comercial, protocolo institucional y condición clínica del paciente.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

function getSelected(name){
  const el = document.querySelector('input[name="' + name + '"]:checked');
  return el ? el.value : null;
}

function round1(num){
  return Math.round(num * 10) / 10;
}

function updateVasoactivos(){
  const peso = parseFloat(document.getElementById('pesoPaciente').value);
  const droga = getSelected('vaso') || 'ne';

  const drogaNombre = document.getElementById('drogaNombre');
  const drogaPresentacion = document.getElementById('drogaPresentacion');
  const cantidadMg = document.getElementById('cantidadMg');
  const volumenAmpolla = document.getElementById('volumenAmpolla');
  const volumenAmpollaNota = document.getElementById('volumenAmpollaNota');
  const descripcionPreparacion = document.getElementById('descripcionPreparacion');
  const descripcionCorta = document.getElementById('descripcionCorta');
  const dosisEnfasis = document.getElementById('dosisEnfasis');
  const dosisEnfasisSoft = document.getElementById('dosisEnfasisSoft');

  if(isNaN(peso) || peso <= 0){
    drogaNombre.textContent = 'Ingresa peso y selecciona una droga';
    drogaPresentacion.textContent = '-';
    cantidadMg.textContent = '-';
    volumenAmpolla.textContent = '-';
    volumenAmpollaNota.textContent = 'Según presentación habitual';
    descripcionPreparacion.textContent = '-';
    descripcionCorta.textContent = '-';
    dosisEnfasis.textContent = '-';
    dosisEnfasisSoft.textContent = 'La dosis por 1 mL/h aparecerá aquí.';
    return;
  }

  let nombre = '';
  let presentacion = '';
  let mg = 0;
  let mlAmp = 0;
  let dosis = '';

  if(droga === 'epi'){
    nombre = 'Adrenalina (Epinefrina)';
    presentacion = '1 mg/mL';
    mg = peso * 0.3;
    mlAmp = mg; // 1 mg/mL
    dosis = '0,1 µg/kg/min';
  }

  if(droga === 'ne'){
    nombre = 'Noradrenalina (Norepinefrina)';
    presentacion = '4 mg / 4 mL';
    mg = peso * 0.3;
    mlAmp = mg; // 1 mg/mL equivalente
    dosis = '0,1 µg/kg/min';
  }

  if(droga === 'dopa'){
    nombre = 'Dopamina';
    presentacion = '200 mg / 5 mL';
    mg = peso * 18;
    mlAmp = mg * 0.025;
    dosis = '6 µg/kg/min';
  }

  if(droga === 'dobu'){
    nombre = 'Dobutamina';
    presentacion = '250 mg / 5 mL';
    mg = peso * 6;
    mlAmp = mg * 0.02;
    dosis = '2 µg/kg/min';
  }

  if(droga === 'milri'){
    nombre = 'Milrinona';
    presentacion = '10 mg / 10 mL';
    mg = peso * 3;
    mlAmp = mg; // 1 mg/mL
    dosis = '1 µg/kg/min';
  }

  drogaNombre.textContent = nombre;
  drogaPresentacion.textContent = presentacion;

  cantidadMg.innerHTML = round1(mg).toString().replace('.', ',') + ' mg<br><span class="small-note">a colocar en 50 mL</span>';

  volumenAmpolla.innerHTML = round1(mlAmp).toString().replace('.', ',') + ' mL';
  volumenAmpollaNota.textContent = 'Volumen calculado desde la presentación habitual de la ampolla';

  descripcionPreparacion.textContent = 'Preparar en jeringa con 50 mL de suero glucosado al 5%. Colocar la cantidad calculada y completar volumen final.';
  descripcionCorta.textContent = round1(mg).toString().replace('.', ',') + ' mg en 50 mL';

let colorBox = '#fff7db'; // default
let colorBorder = '#f1db8b';

if(droga === 'ne'){
  colorBox = '#eef4ff';
  colorBorder = '#3b82f6';
}
if(droga === 'epi'){
  colorBox = '#ffe5e5';
  colorBorder = '#3b82f6';
}
if(droga === 'dopa'){
  colorBox = '#fff3c4';
  colorBorder = '#3b82f6';
}
if(droga === 'dobu'){
  colorBox = '#e4f7f3';
  colorBorder = '#3b82f6';
}
if(droga === 'milri'){
  colorBox = '#eee8ff';
  colorBorder = '#3b82f6';
}

// aplicar color dinámico
const highlightBox = document.querySelector('.highlight-dose');
highlightBox.style.background = colorBox;
highlightBox.style.border = '3px solid ' + colorBorder;

// texto dinámico con nombre de droga
dosisEnfasis.innerHTML = '1 mL/h entrega <br>' + dosis + ' de <b>' + nombre + '</b>';

dosisEnfasisSoft.textContent = 'Siempre que la preparación haya sido realizada para este peso y con esta presentación.';
}

document.addEventListener('DOMContentLoaded', function(){
  document.getElementById('pesoPaciente').addEventListener('input', updateVasoactivos);

  document.querySelectorAll('.vaso-trigger').forEach(el => {
    el.addEventListener('change', updateVasoactivos);
  });

  updateVasoactivos();
});
</script>

<?php require("footer.php"); ?>