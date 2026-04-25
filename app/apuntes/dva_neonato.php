<?php
$titulo_pagina = "DVA neonato";
$navbar_titulo = "Apuntes";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Calculadora docente de diluciones de drogas vasoactivas en neonatología. Usa un esquema de preparación en jeringa de 50 mL para que 1 mL/h corresponda a una dosis fija por kg/min según la droga seleccionada.";
$formula = "Todas las preparaciones se expresan para jeringa de 50 mL. Verifica siempre la presentación real de la ampolla y el protocolo institucional antes de preparar.";
$referencias = array(
  "Esquema local de diluciones de drogas vasoactivas en neonatología aportado por el usuario.",
  "Verificar siempre protocolo local, presentación comercial disponible y compatibilidad real antes de preparar.",
  "Las presentaciones comerciales pueden variar según país, laboratorio y unidad clínica."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0 dva-shell">

        <style>
          .dva-shell{max-width:980px;margin:0 auto;}
          .dva-drug-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .dva-drug-grid .note-option{
            width:100%;
            min-height:92px;
            align-items:flex-start;
            justify-content:flex-start;
            text-align:left;
            gap:.35rem;
            padding:.8rem .85rem;
          }
          .dva-drug-grid .note-option i{margin-bottom:.1rem;}
          .dva-drug-grid .note-option .drug-line{font-size:.96rem;font-weight:800;line-height:1.18;color:var(--note-text);}
          .dva-drug-grid .note-option .drug-sub{font-size:.78rem;line-height:1.28;color:var(--note-muted);}

          .dva-result-main{
            background:linear-gradient(180deg,var(--note-brand-soft) 0%, #f7faff 100%);
            border:1px solid var(--note-brand-soft-border);
            border-radius:1rem;
            padding:1.15rem 1rem;
            text-align:center;
          }
          .dva-result-main .k{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#3559b7;
            font-weight:700;
            margin-bottom:.45rem;
          }
          .dva-result-main .v{
            font-size:1.45rem;
            line-height:1.15;
            font-weight:900;
            color:var(--note-text);
          }
          .dva-result-main .n{
            margin-top:.55rem;
            font-size:.92rem;
            line-height:1.4;
            color:var(--note-muted);
          }
          .dva-help-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .dva-help-card{
            background:#fff;
            border:1px solid var(--note-line-strong);
            border-radius:1rem;
            padding:.95rem 1rem;
          }
          .dva-help-card .k{
            font-size:.78rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:var(--note-muted);
            margin-bottom:.22rem;
          }
          .dva-help-card .v{
            font-size:1rem;
            line-height:1.28;
            font-weight:800;
            color:var(--note-text);
          }
          .dva-help-card .n{
            margin-top:.22rem;
            font-size:.86rem;
            line-height:1.34;
            color:var(--note-muted);
          }
          .dva-warning-item{
            display:flex;
            align-items:flex-start;
            gap:.8rem;
            border:1px solid #ead38a;
            border-radius:1rem;
            background:#fff9e8;
            padding:.95rem 1rem;
          }
          .dva-warning-mark{
            flex:0 0 auto;
            width:34px;
            height:34px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#f4c542;
            color:#fff;
            margin-top:.08rem;
          }
          .dva-warning-copy{min-width:0;flex:1;}
          .dva-warning-title{font-size:1rem;font-weight:800;line-height:1.22;color:var(--note-text);margin-bottom:.15rem;text-align:center;}
          .dva-warning-note{margin:0;font-size:.9rem;line-height:1.4;color:var(--note-muted);text-align:center;}

          @media (max-width:768px){
            .dva-drug-grid,.dva-help-grid{grid-template-columns:1fr;}
            .dva-result-main .v{font-size:1.28rem;}
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · NEONATOLOGÍA</div>
          <h2>Dilución de vasoactivos en neonatología</h2>
          <div class="note-hero-subtitle">Cálculo rápido según peso para preparaciones habituales en jeringa de 50 mL.</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
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

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Datos de entrada</div>
            <div class="note-grid">
              <div class="note-input-group">
                <label class="note-label" for="pesoPaciente">Peso del paciente</label>
                <div class="note-input-inline">
                  <input type="text" id="pesoPaciente" class="note-input" inputmode="decimal">
                  <div class="note-input-unit">kg</div>
                </div>
                <div class="small-note mt-2">Se asume preparación final en jeringa de 50 mL.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Drogas vasoactivas</div>
            <div class="dva-drug-grid">
              <div>
                <input class="note-check vaso-trigger" type="radio" name="vaso" id="vaso_ne" value="ne" checked>
                <label class="note-option drug-vasoactive" for="vaso_ne">
                  <i class="fa-solid fa-arrow-up-right-dots"></i>
                  <div class="drug-line">Noradrenalina</div>
                  <div class="drug-sub">4 mg / 4 mL · Objetivo 0,1 µg/kg/min por 1 mL/h</div>
                </label>
              </div>
              <div>
                <input class="note-check vaso-trigger" type="radio" name="vaso" id="vaso_epi" value="epi">
                <label class="note-option drug-vasoactive" for="vaso_epi">
                  <i class="fa-solid fa-heart-circle-bolt"></i>
                  <div class="drug-line">Adrenalina</div>
                  <div class="drug-sub">1 mg / mL · Objetivo 0,1 µg/kg/min por 1 mL/h</div>
                </label>
              </div>
              <div>
                <input class="note-check vaso-trigger" type="radio" name="vaso" id="vaso_dopa" value="dopa">
                <label class="note-option drug-vasoactive" for="vaso_dopa">
                  <i class="fa-solid fa-bolt"></i>
                  <div class="drug-line">Dopamina</div>
                  <div class="drug-sub">200 mg / 5 mL · Objetivo 6 µg/kg/min por 1 mL/h</div>
                </label>
              </div>
              <div>
                <input class="note-check vaso-trigger" type="radio" name="vaso" id="vaso_dobu" value="dobu">
                <label class="note-option drug-vasoactive" for="vaso_dobu">
                  <i class="fa-solid fa-wave-square"></i>
                  <div class="drug-line">Dobutamina</div>
                  <div class="drug-sub">250 mg / 5 mL · Objetivo 2 µg/kg/min por 1 mL/h</div>
                </label>
              </div>
              <div>
                <input class="note-check vaso-trigger" type="radio" name="vaso" id="vaso_milri" value="milri">
                <label class="note-option drug-vasoactive" for="vaso_milri">
                  <i class="fa-solid fa-droplet"></i>
                  <div class="drug-line">Milrinona</div>
                  <div class="drug-sub">10 mg / 10 mL · Objetivo 1 µg/kg/min por 1 mL/h</div>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa el peso y selecciona una droga para ver la preparación sugerida.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Peso usado</div>
              <div id="summaryPeso" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Droga</div>
              <div id="summaryDroga" class="note-summary-v">Noradrenalina</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Presentación</div>
              <div id="summaryPresentacion" class="note-summary-v">4 mg / 4 mL</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Objetivo a 1 mL/h</div>
              <div id="summaryObjetivo" class="note-summary-v">0,1 µg/kg/min</div>
            </div>
          </div>
        </div>

        <div class="dva-result-main mb-3">
          <div class="k">Resultado principal</div>
          <div id="dosisEnfasis" class="v">-</div>
          <div id="dosisEnfasisSoft" class="n">La dosis entregada por 1 mL/h aparecerá aquí.</div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Mg a colocar en 50 mL</div>
            <div id="cantidadMg" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Cantidad total de principio activo en la jeringa.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Volumen desde ampolla</div>
            <div id="volumenAmpolla" class="note-result-card-value">-</div>
            <div id="volumenAmpollaNota" class="note-result-card-note">Según presentación habitual.</div>
          </div>
        </div>

        <div class="dva-help-grid mb-3">
          <div class="dva-help-card">
            <div class="k">Droga seleccionada</div>
            <div id="drogaNombre" class="v">-</div>
            <div id="drogaPresentacion" class="n">-</div>
          </div>
          <div class="dva-help-card">
            <div class="k">Preparación corta</div>
            <div id="descripcionCorta" class="v">-</div>
            <div id="descripcionPreparacion" class="n">-</div>
          </div>
        </div>

        <div class="note-mint mb-3">
          <div class="note-card-title text-center">Interpretación</div>
          <p id="interpretacionTexto" class="mb-0 text-center">Verás una preparación pensada para que 1 mL/h entregue una dosis fija orientativa según peso y droga.</p>
        </div>

        <div class="note-checklist-section mb-3">
          <div class="note-checklist-section-head">
            <div>
              <div class="note-checklist-section-title">Factores de seguridad que obligan a detenerse y verificar</div>
              <div class="note-checklist-section-help">Antes de preparar o programar la bomba, revisa estos puntos críticos.</div>
            </div>
          </div>
          <div class="note-checklist-section-body" style="display:block;border-top:none;padding-top:0;">
            <div class="note-checklist-list">
              <div class="dva-warning-item">
                <div class="dva-warning-mark"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="dva-warning-copy">
                  <div class="dva-warning-title">Presentación real de la ampolla</div>
                  <p class="dva-warning-note">No asumas la concentración por memoria. Verifica etiqueta física, volumen y miligramos totales.</p>
                </div>
              </div>
              <div class="dva-warning-item">
                <div class="dva-warning-mark"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="dva-warning-copy">
                  <div class="dva-warning-title">Preparación individualizada por peso</div>
                  <p class="dva-warning-note">En este esquema, la concentración final cambia con el peso. No reutilices una jeringa preparada para otro paciente.</p>
                </div>
              </div>
              <div class="dva-warning-item">
                <div class="dva-warning-mark"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="dva-warning-copy">
                  <div class="dva-warning-title">Concordancia entre jeringa, bomba y vía</div>
                  <p class="dva-warning-note">Una preparación correcta puede volverse insegura si la bomba, la vía o la velocidad programada no corresponden.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mt-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Primero calcula miligramos, después traduce a mililitros</div>
          <div class="note-tips"><strong>Qué hacer:</strong> confirma peso, droga, presentación comercial, volumen total final y objetivo de dosis antes de preparar.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> asumir que “1 mL/h” significa lo mismo entre pacientes o entre distintas drogas.</div>
          <div class="note-tips"><strong>Error frecuente:</strong> copiar una dilución previa sin recalcularla para el peso actual.</div>
          <div class="note-tips mb-0"><strong>Pearl:</strong> etiqueta siempre la jeringa con droga, cantidad total cargada, volumen final y objetivo clínico de la infusión.</div>
        </div>

        <div class="footer-note mt-3">Herramienta docente basada en esquema local. Verifica siempre presentación comercial, protocolo institucional y contexto clínico real del paciente.</div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleInfo(){
  const box = document.getElementById('infoContent');
  if(!box) return;
  box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
}

(function(){
  const CNS = window.ClinicalNoteSystem || {};
  const parseDecimal = CNS.parseDecimal || function(value){
    if(typeof value !== 'string') value = String(value ?? '');
    value = value.trim().replace(',', '.');
    const num = parseFloat(value);
    return Number.isFinite(num) ? num : NaN;
  };
  const formatNumber = CNS.formatNumber || function(value, decimals){
    if(!Number.isFinite(value)) return '-';
    return Number(value).toLocaleString('es-CL', {minimumFractionDigits:decimals, maximumFractionDigits:decimals});
  };
  const safeSetText = CNS.safeSetText || function(target, text){
    const el = typeof target === 'string' ? document.getElementById(target) : target;
    if(el) el.textContent = text;
  };

  const weightInput = document.getElementById('pesoPaciente');

  const drugData = {
    ne: {
      nombre: 'Noradrenalina',
      presentacion: '4 mg / 4 mL',
      mgPorMl: 1,
      factorMgKg: 0.3,
      objetivo: '0,1 µg/kg/min'
    },
    epi: {
      nombre: 'Adrenalina',
      presentacion: '1 mg / mL',
      mgPorMl: 1,
      factorMgKg: 0.3,
      objetivo: '0,1 µg/kg/min'
    },
    dopa: {
      nombre: 'Dopamina',
      presentacion: '200 mg / 5 mL',
      mgPorMl: 40,
      factorMgKg: 18,
      objetivo: '6 µg/kg/min'
    },
    dobu: {
      nombre: 'Dobutamina',
      presentacion: '250 mg / 5 mL',
      mgPorMl: 50,
      factorMgKg: 6,
      objetivo: '2 µg/kg/min'
    },
    milri: {
      nombre: 'Milrinona',
      presentacion: '10 mg / 10 mL',
      mgPorMl: 1,
      factorMgKg: 3,
      objetivo: '1 µg/kg/min'
    }
  };

  function getSelectedDrug(){
    const checked = document.querySelector('input[name="vaso"]:checked');
    return checked ? checked.value : 'ne';
  }

  function updateUI(){
    const peso = parseDecimal(weightInput.value);
    const drugKey = getSelectedDrug();
    const drug = drugData[drugKey];

    safeSetText('summaryDroga', drug.nombre);
    safeSetText('summaryPresentacion', drug.presentacion);
    safeSetText('summaryObjetivo', drug.objetivo);
    safeSetText('drogaNombre', drug.nombre);
    safeSetText('drogaPresentacion', drug.presentacion);

    if(!Number.isFinite(peso) || peso <= 0){
      safeSetText('summaryNarrative', 'Ingresa el peso y selecciona una droga para ver la preparación sugerida.');
      safeSetText('summaryPeso', '-');
      safeSetText('cantidadMg', '-');
      safeSetText('volumenAmpolla', '-');
      safeSetText('volumenAmpollaNota', 'Según presentación habitual.');
      safeSetText('descripcionCorta', '-');
      safeSetText('descripcionPreparacion', '-');
      safeSetText('dosisEnfasis', '-');
      safeSetText('dosisEnfasisSoft', 'La dosis entregada por 1 mL/h aparecerá aquí.');
      safeSetText('interpretacionTexto', 'Verás una preparación pensada para que 1 mL/h entregue una dosis fija orientativa según peso y droga.');
      return;
    }

    const mg = peso * drug.factorMgKg;
    const mlAmp = mg / drug.mgPorMl;

    safeSetText('summaryPeso', formatNumber(peso, 1) + ' kg');
    safeSetText('summaryNarrative', `${drug.nombre} para ${formatNumber(peso,1)} kg; preparación en jeringa de 50 mL para que 1 mL/h corresponda a ${drug.objetivo}.`);
    safeSetText('cantidadMg', formatNumber(mg, 1) + ' mg');
    safeSetText('volumenAmpolla', formatNumber(mlAmp, 1) + ' mL');
    safeSetText('volumenAmpollaNota', 'Volumen calculado desde la presentación habitual de la ampolla.');
    safeSetText('descripcionCorta', formatNumber(mg, 1) + ' mg en 50 mL');
    safeSetText('descripcionPreparacion', 'Cargar la cantidad calculada y completar volumen final con SG 5%.');
    safeSetText('dosisEnfasis', `1 mL/h entrega ${drug.objetivo}`);
    safeSetText('dosisEnfasisSoft', `${drug.nombre}; válido solo si la jeringa fue preparada para este peso y con esta presentación.`);
    safeSetText('interpretacionTexto', `El cálculo individualiza la concentración para este peso. La seguridad depende además de verificar ampolla, bomba, vía y monitorización real del paciente.`);
  }

  document.querySelectorAll('.vaso-trigger').forEach(function(el){ el.addEventListener('change', updateUI); });
  if(weightInput) weightInput.addEventListener('input', updateUI);
  updateUI();
})();
</script>

<?php require("../footer.php"); ?>
