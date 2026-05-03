<?php
$titulo_pagina = "Dosis AALL";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Referencia interactiva orientativa para calcular dosis máximas de anestésicos locales en adultos según peso, droga y eventual uso de epinefrina. La cifra resultante no reemplaza el ajuste clínico según sitio de bloqueo, absorción esperada, comorbilidad y riesgo de LAST.";
$formula = "Dosis máxima total (mg) = mg/kg × peso";
$referencias = array(
  "DailyMed. Lidocaine Hydrochloride Injection, USP / Lidocaine Hydrochloride and Epinephrine Injection, USP. Máximos orientativos de 4.5 mg/kg sin epinefrina y 7 mg/kg con epinefrina en adultos normales.",
  "DailyMed. Bupivacaine Hydrochloride Injection / Bupivacaine Hydrochloride and Epinephrine Injection. Las dosis deben individualizarse según técnica, absorción esperada y condición del paciente.",
  "Neal JM, et al. ASRA Practice Advisory on Local Anesthetic Systemic Toxicity. Recomendaciones de prevención y manejo de LAST.",
  "StatPearls. Chloroprocaine. Dosis orientativa máxima de 11 mg/kg sin epinefrina y 14 mg/kg con epinefrina para infiltración o bloqueo periférico."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<?php
$drugs = array(
  'lidocaina' => array(
    'label' => 'Lidocaína',
    'clase' => 'drug-local',
    'mgkg_sin' => 4.5,
    'mgkg_con' => 7.0,
    'max_sin' => 300,
    'max_con' => 500,
    'texto' => 'Inicio rápido y duración intermedia. Muy usada para infiltración, nervios periféricos y neuroeje. La epinefrina aumenta el máximo orientativo pero no elimina el riesgo de LAST.'
  ),
  'bupivacaina' => array(
    'label' => 'Bupivacaína',
    'clase' => 'drug-local',
    'mgkg_sin' => 2.5,
    'mgkg_con' => 3.0,
    'max_sin' => 175,
    'max_con' => 225,
    'texto' => 'Alta potencia y larga duración. Mayor preocupación por cardiotoxicidad. Sé especialmente conservador en bloqueos con alta absorción o en pacientes frágiles.'
  ),
  'levobupivacaina' => array(
    'label' => 'Levobupivacaína',
    'clase' => 'drug-local',
    'mgkg_sin' => 2.5,
    'mgkg_con' => 3.0,
    'max_sin' => 150,
    'max_con' => 225,
    'texto' => 'Alternativa de larga duración con menor cardiotoxicidad relativa que bupivacaína, pero sigue requiriendo cautela con dosis altas o absorción rápida.'
  ),
  'cloroprocaina' => array(
    'label' => 'Cloroprocaína',
    'clase' => 'drug-local',
    'mgkg_sin' => 11.0,
    'mgkg_con' => 14.0,
    'max_sin' => 800,
    'max_con' => 1000,
    'texto' => 'Éster de muy corta duración. Se usa cuando interesa instalación rápida y menor permanencia, pero la toxicidad sistémica sigue dependiendo de dosis total y velocidad de absorción.'
  )
);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .aall-shell{max-width:980px;margin:0 auto;}
          .aall-drug-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .aall-drug-grid > label{display:flex;}
          .aall-drug-grid .drug-card{height:100%;width:100%;min-height:88px;align-items:center;justify-content:flex-start;text-align:left;}
          .aall-grid-2{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;}
          .aall-risk-list{margin:0;padding-left:1rem;}
          .aall-risk-list li{margin-bottom:.22rem;}
          .aall-description{background:#fff;border:1px solid var(--note-line);border-radius:1rem;padding:1rem;}
          .aall-empty{font-size:.95rem;color:var(--note-muted);}
          .aall-highlight{background:linear-gradient(180deg,var(--note-brand-soft) 0%,#f7faff 100%);}
          .note-check:checked + .drug-card{box-shadow:0 0 0 3px rgba(47,128,237,.3), 0 4px 12px rgba(15,23,42,.15);transform:translateY(-1px);}
          .note-choice-grid .note-option{min-height:56px;}
          @media (max-width:768px){
            .aall-grid-2{grid-template-columns:1fr;}
            .aall-drug-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:.5rem;}
          }
          @media (max-width:460px){
            .aall-drug-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="aall-shell">
          <div class="note-hero mb-3">
            <div class="note-hero-kicker">APP CLÍNICA · ANESTÉSICOS LOCALES</div>
            <h2>Dosis máximas de anestésicos locales</h2>
            <div class="note-hero-subtitle">Cálculo orientativo en adultos con énfasis en dosis total, techo absoluto y riesgo de LAST.</div>
          </div>

          <div class="info-box mb-3">
            <div class="info-box-header">
              <div class="info-box-title">Información</div>
              <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
            </div>
            <div id="infoContent" class="info-box-content">
              <p class="mb-2"><?php echo $descripcion_info; ?></p>
              <hr>
              <b>Fórmula:</b><br>
              <?php echo $formula; ?>
              <hr>
              <div class="small-note mb-2"><strong>Lectura práctica:</strong> primero piensa en mg totales, luego traduce a volumen según concentración real de la jeringa. Una cifra matemáticamente correcta puede ser insegura si el sitio tiene absorción alta o el paciente tiene menor reserva fisiológica.</div>
              <hr>
              <b>Referencias:</b>
              <ul class="mb-0 ps-3">
                <?php foreach($referencias as $ref){ ?>
                  <li><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            </div>
          </div>

          <div class="note-card mb-3">
            <div class="note-card-body">
              <div class="note-section-label">Selección principal</div>
              <div class="aall-grid-2">
                <div class="note-input-group">
                  <label class="note-label" for="peso">Peso</label>
                  <div class="note-input-inline">
                    <input type="text" id="peso" class="note-input" inputmode="decimal" value="" aria-label="Peso en kg">
                    <div class="note-input-unit">kg</div>
                  </div>
                </div>
                <div class="note-input-group">
                  <div class="note-label">Contexto</div>
                  <div class="note-choice-grid">
                    <label>
                      <input class="note-check" type="radio" name="epi" value="sin" checked>
                      <span class="note-option">
                        <span class="note-drug-title">Sin epinefrina</span>
                        <span class="note-sub">escenario basal</span>
                      </span>
                    </label>
                    <label>
                      <input class="note-check" type="radio" name="epi" value="con">
                      <span class="note-option">
                        <span class="note-drug-title">Con epinefrina</span>
                        <span class="note-sub">si es apropiado usarla</span>
                      </span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="note-label mt-3">Anestésico local</div>
              <div class="aall-drug-grid">
                <?php foreach($drugs as $key => $drug){ ?>
                  <label>
                    <input class="note-check" type="radio" name="farmaco" value="<?php echo $key; ?>" <?php echo $key === 'lidocaina' ? 'checked' : ''; ?>>
                    <span class="drug-card <?php echo $drug['clase']; ?>">
                      <div class="drug-label-content">
                        <div class="drug-label-title"><?php echo $drug['label']; ?></div>
                        <div class="drug-label-subtitle">Anestésico local</div>
                      </div>
                    </span>
                  </label>
                <?php } ?>
              </div>
            </div>
          </div>

          <div class="note-card mb-3">
            <div class="note-card-body">
              <div class="note-card-title">Resumen</div>
              <div id="summaryText" class="note-summary-box-text mb-3">Lidocaína 70 kg sin epinefrina.</div>
              <div class="note-result-grid-2">
                <div class="note-result-card">
                  <div class="note-result-card-label">Droga</div>
                  <div id="summaryDrugLabel" class="drug-label drug-local"><div class="drug-label-content"><div class="drug-label-title" id="summaryDrug">Lidocaína</div></div></div>
                </div>
                <div class="note-result-card">
                  <div class="note-result-card-label">Escenario</div>
                  <div id="summaryScenario" class="note-result-card-value">Sin epinefrina</div>
                </div>
                <div class="note-result-card">
                  <div class="note-result-card-label">Peso usado</div>
                  <div id="summaryWeight" class="note-result-card-value">70 kg</div>
                </div>
                <div class="note-result-card">
                  <div class="note-result-card-label">Límite por peso</div>
                  <div id="summaryMgKg" class="note-result-card-value">4.5 mg/kg</div>
                </div>
              </div>
            </div>
          </div>

          <div class="note-result-grid-2 mb-3">
            <div class="note-result-card aall-highlight">
              <div class="note-result-card-label">Dosis máxima total</div>
              <div id="mainDose" class="note-result-card-value">315 mg</div>
              <div class="note-result-card-note">Se muestra la cifra más conservadora entre cálculo por peso y techo absoluto.</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Tope absoluto</div>
              <div id="absoluteCap" class="note-result-card-value">300 mg</div>
              <div class="note-result-card-note">Nunca superarlo solo porque el peso permitiría más.</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Cálculo por peso</div>
              <div id="weightDose" class="note-result-card-value">315 mg</div>
              <div class="note-result-card-note">mg/kg × peso ingresado.</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Límite orientativo final</div>
              <div id="finalDose" class="note-result-card-value">300 mg</div>
              <div class="note-result-card-note">Es la referencia práctica a utilizar para preparar dosis y volumen.</div>
            </div>
          </div>

          <div class="aall-description mb-3">
            <div class="note-card-title">Interpretación clínica</div>
            <div id="drugInfo" class="mb-0">Inicio rápido y duración intermedia. Muy usada para infiltración, nervios periféricos y neuroeje. La epinefrina aumenta el máximo orientativo pero no elimina el riesgo de LAST.</div>
          </div>

          <div id="validityWarning" class="note-warning mb-3 note-hidden">
            <div class="note-card-title">Advertencia visible</div>
            <div id="warningText">El cálculo es solo orientativo y debe bajarse si existen factores de mayor absorción o menor reserva fisiológica.</div>
          </div>

<div class="note-checklist-section mb-3">
  <div class="note-checklist-section-head">
    <div>
      <div class="note-checklist-section-title">Factores que obligan a ser más conservador</div>
      <div class="note-checklist-section-help">Si uno o más están presentes, usa una estrategia más prudente y reevalúa dosis total, sitio y contexto clínico.</div>
    </div>
  </div>

  <div class="note-checklist-section-body" style="display:block;border-top:none;padding-top:0;">
    <div class="note-warning-list">

      <div class="note-warning-item">
        <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
        <div class="note-warning-copy">
          <div class="note-warning-title">Mayor susceptibilidad sistémica</div>
          <p class="note-warning-note">Sepsis, embarazo, extremos de edad, desnutrición o hipoproteinemia.</p>
        </div>
      </div>

      <div class="note-warning-item">
        <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
        <div class="note-warning-copy">
          <div class="note-warning-title">Reserva orgánica reducida</div>
          <p class="note-warning-note">Hepatopatía, insuficiencia cardíaca, enfermedad renal crónica o shock.</p>
        </div>
      </div>

      <div class="note-warning-item">
        <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
        <div class="note-warning-copy">
          <div class="note-warning-title">Sitios de absorción alta</div>
          <p class="note-warning-note">Intercostal, epidural, plexos o infiltración extensa.</p>
        </div>
      </div>

      <div class="note-warning-item">
        <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
        <div class="note-warning-copy">
          <div class="note-warning-title">Uso combinado de varios anestésicos locales</div>
          <p class="note-warning-note">Piensa siempre en dosis total acumulada y no sólo en cada fármaco por separado.</p>
        </div>
      </div>

    </div>
  </div>
</div>

          <div class="note-teaching-wrap">
            <div class="note-teaching-title">Perlas docentes</div>
            <div class="note-teaching-main">Primero calcula masa total; después piensa en volumen y sitio</div>
            <div class="note-tips"><strong>Qué hacer:</strong> calcular mg totales, revisar concentración real de la jeringa y anticipar absorción según el bloqueo elegido.</div>
            <div class="note-tips"><strong>Qué evitar:</strong> tratar el máximo mg/kg como permiso automático para infiltrar todo ese total en cualquier paciente o sitio.</div>
            <div class="note-tips mb-0"><strong>Error frecuente:</strong> sumar volúmenes de distintas concentraciones sin convertirlos primero a mg totales.</div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const drugData = <?php echo json_encode($drugs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

  const pesoEl = document.getElementById('peso');
  const summaryText = document.getElementById('summaryText');
  const summaryDrug = document.getElementById('summaryDrug');
  const summaryScenario = document.getElementById('summaryScenario');
  const summaryWeight = document.getElementById('summaryWeight');
  const summaryMgKg = document.getElementById('summaryMgKg');
  const mainDose = document.getElementById('mainDose');
  const absoluteCap = document.getElementById('absoluteCap');
  const weightDose = document.getElementById('weightDose');
  const finalDose = document.getElementById('finalDose');
  const drugInfo = document.getElementById('drugInfo');
  const validityWarning = document.getElementById('validityWarning');
  const warningText = document.getElementById('warningText');

  function getSelectedDrug(){
    return document.querySelector('input[name="farmaco"]:checked')?.value || 'lidocaina';
  }

  function getSelectedScenario(){
    return document.querySelector('input[name="epi"]:checked')?.value || 'sin';
  }

  function formatKg(value){
    return CNS.formatNumber(value, 1) + ' kg';
  }

  function calculate(){
    const drugKey = getSelectedDrug();
    const scenario = getSelectedScenario();
    const weight = CNS.parseDecimal(pesoEl.value);
    const drug = drugData[drugKey];

    if(!drug || !Number.isFinite(weight) || weight <= 0){
      CNS.safeSetText(summaryText, 'Ingresa un peso válido y selecciona un anestésico local.');
      CNS.safeSetText(summaryDrug, drug ? drug.label : '-');
      CNS.safeSetText(summaryScenario, scenario === 'con' ? 'Con epinefrina' : 'Sin epinefrina');
      CNS.safeSetText(summaryWeight, '-');
      CNS.safeSetText(summaryMgKg, '-');
      CNS.safeSetText(mainDose, '-');
      CNS.safeSetText(absoluteCap, '-');
      CNS.safeSetText(weightDose, '-');
      CNS.safeSetText(finalDose, '-');
      CNS.safeSetText(drugInfo, drug ? drug.texto : '-');
      validityWarning.classList.add('note-hidden');
      return;
    }

    const mgkg = scenario === 'con' ? drug.mgkg_con : drug.mgkg_sin;
    const absCap = scenario === 'con' ? drug.max_con : drug.max_sin;
    const byWeight = mgkg * weight;
    const finalMg = Math.min(byWeight, absCap);

    CNS.safeSetText(summaryText, `${drug.label} ${CNS.formatNumber(weight,1)} kg ${scenario === 'con' ? 'con' : 'sin'} epinefrina.`);
    const drugLabelEl = document.getElementById('summaryDrugLabel');
    if(drugLabelEl){ drugLabelEl.className = 'drug-label ' + (drug.clase || 'drug-local'); }
    CNS.safeSetText(summaryDrug, drug.label);
    CNS.safeSetText(summaryScenario, scenario === 'con' ? 'Con epinefrina' : 'Sin epinefrina');
    CNS.safeSetText(summaryWeight, formatKg(weight));
    CNS.safeSetText(summaryMgKg, `${CNS.formatNumber(mgkg, 1)} mg/kg`);

    CNS.safeSetText(mainDose, `${CNS.formatNumber(finalMg, 0)} mg`);
    CNS.safeSetText(absoluteCap, `${CNS.formatNumber(absCap, 0)} mg`);
    CNS.safeSetText(weightDose, `${CNS.formatNumber(byWeight, 0)} mg`);
    CNS.safeSetText(finalDose, `${CNS.formatNumber(finalMg, 0)} mg`);
    CNS.safeSetText(drugInfo, drug.texto);

    let warnings = [];
    if(byWeight > absCap){
      warnings.push(`El cálculo por peso excede el techo absoluto orientativo para ${drug.label}; se muestra el límite más conservador.`);
    }
    if(weight < 40 || weight > 120){
      warnings.push('Peso fuera del rango habitual del adulto promedio: revisa con especial cuidado masa magra, sitio de inyección y reserva fisiológica.');
    }
    if(scenario === 'con'){
      warnings.push('La epinefrina no vuelve segura una dosis alta si el sitio tiene absorción rápida o el paciente tiene factores de riesgo para LAST.');
    }

    if(warnings.length){
      validityWarning.classList.remove('note-hidden');
      CNS.safeSetText(warningText, warnings.join(' '));
    } else {
      validityWarning.classList.add('note-hidden');
    }
  }

  pesoEl.addEventListener('input', calculate);
  document.querySelectorAll('input[name="farmaco"], input[name="epi"]').forEach(el => {
    el.addEventListener('change', calculate);
  });

  calculate();
})();
</script>

<?php require("../footer.php"); ?>
