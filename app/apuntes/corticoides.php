<?php
$titulo_pagina = "Corticoides perioperatorios";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Nota interactiva para estimar riesgo de supresión del eje HH y orientar suplementación perioperatoria en pacientes con uso crónico de glucocorticoides. Convierte la dosis habitual a prednisona equivalente y propone una cobertura práctica según el estrés quirúrgico.";
$formula = "La dosis habitual se convierte a mg equivalentes de prednisona usando tablas docentes de equivalencia antiinflamatoria. Regla práctica: >5 mg/día de prednisona equivalente por más de 3 semanas o suspensión en los últimos 3 meses obliga a pensar en supresión del eje. La fludrocortisona se agrega a la tabla por equivalencia docente, pero no debe interpretarse como reemplazo glucocorticoide suficiente para estrés perioperatorio.";
$referencias = array(
  "Nazar C, Bastidas J, Zamora M, Coloma R, Fuentes R. Manejo perioperatorio de pacientes con patología tiroidea y tratamiento crónico con corticoides. Rev Chil Cir. 2016;68(1):87-93.",
  "Woodcock T, Barker P, Daniel S, et al. Guidelines for the management of glucocorticoids during the peri-operative period for patients with adrenal insufficiency. Anaesthesia. 2020;75(5):654-663.",
  "OpenAnesthesia. Adrenal Insufficiency and Perioperative Corticosteroids. Actualizado 24 mayo 2024.",
  "Tabla práctica de equivalencias de corticoides y dosis aproximadas supresoras del eje HH."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell steroid-shell px-1 px-md-0 py-0">

        <style>
          .steroid-shell{max-width:1040px;margin:0 auto;}
          .steroid-drug-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:.75rem;}
          .steroid-drug-grid .note-option{min-height:92px;align-items:flex-start;justify-content:flex-start;text-align:left;gap:.28rem;padding:.78rem .82rem;}
          .steroid-drug-grid .note-option i{margin-bottom:.08rem;}
          .steroid-muted-card{background:#fff;border:1px solid var(--note-line);border-radius:1rem;padding:1rem;}
          .steroid-quick-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .steroid-selector-sections{display:grid;grid-template-columns:1fr;gap:1rem;}
          .steroid-selector-options{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .steroid-interpret-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .steroid-mini-card{background:#fff;border:1px solid var(--note-line-strong);border-radius:1rem;padding:.9rem;}
          .steroid-mini-card .k{font-size:.76rem;text-transform:uppercase;letter-spacing:.06em;color:var(--note-muted);margin-bottom:.2rem;}
          .steroid-mini-card .v{font-size:1rem;font-weight:800;line-height:1.25;color:var(--note-text);}
          .steroid-mini-card .n{font-size:.85rem;color:var(--note-muted);line-height:1.35;margin-top:.2rem;}
          .steroid-highlight{background:linear-gradient(180deg,var(--note-brand-soft) 0%, #f7faff 100%);border:1px solid var(--note-brand-soft-border);border-radius:1rem;padding:1rem;}
          .steroid-highlight .k{font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;color:#3559b7;font-weight:700;margin-bottom:.25rem;}
          .steroid-highlight .v{font-size:1.45rem;font-weight:900;line-height:1.1;color:var(--note-text);}
          .steroid-highlight .n{font-size:.9rem;color:var(--note-muted);line-height:1.4;margin-top:.3rem;}
          .steroid-grade-summary{border-radius:1rem;padding:1rem;}
          .steroid-fludro{background:#fff6ea;border:1px solid #efd3aa;}
          .steroid-fludro .note-summary-box-title{color:#9a5a00;}
          .steroid-input-help{font-size:.82rem;color:var(--note-muted);margin-top:.3rem;line-height:1.35;}
          @media (max-width:900px){
            .steroid-drug-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
          }
          @media (max-width:768px){
            .steroid-quick-grid,.steroid-interpret-grid{grid-template-columns:1fr;}
          }
          @media (max-width:460px){
            .steroid-drug-grid,.steroid-selector-options{grid-template-columns:1fr;}
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ENDOCRINO PERIOPERATORIO</div>
          <h2>Suplementación de corticoides perioperatorios</h2>
          <div class="note-hero-subtitle">Conversión a equivalente, riesgo de supresión del eje y cobertura según estrés quirúrgico.</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
            <hr>
            <b>Comentario:</b><br>
            <?php echo $formula; ?>
            <hr>
            <b>Referencias:</b>
            <ul class="mt-2 mb-0">
              <?php foreach($referencias as $ref){ ?>
                <li><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Datos de entrada</div>
            <div class="note-grid">
              <div class="note-input-group">
                <label class="note-label">Glucocorticoide habitual</label>
                <div class="steroid-drug-grid">
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_prednisone" value="prednisone" checked><label class="note-option drug-other" for="st_prednisone"><i class="fa-solid fa-tablets"></i>Prednisona<small>5 mg = ref</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_prednisolone" value="prednisolone"><label class="note-option drug-other" for="st_prednisolone"><i class="fa-solid fa-tablets"></i>Prednisolona<small>5 mg = ref</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_hydrocortisone" value="hydrocortisone"><label class="note-option drug-other" for="st_hydrocortisone"><i class="fa-solid fa-capsules"></i>Hidrocortisona<small>20 mg = 5 mg pred</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_cortisone" value="cortisone"><label class="note-option drug-other" for="st_cortisone"><i class="fa-solid fa-capsules"></i>Cortisona<small>25 mg = 5 mg pred</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_methylpred" value="methylpred"><label class="note-option drug-other" for="st_methylpred"><i class="fa-solid fa-syringe"></i>Metilprednisolona<small>4 mg = 5 mg pred</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_triamcinolone" value="triamcinolone"><label class="note-option drug-other" for="st_triamcinolone"><i class="fa-solid fa-vial"></i>Triamcinolona<small>4 mg = 5 mg pred</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_deflazacort" value="deflazacort"><label class="note-option drug-other" for="st_deflazacort"><i class="fa-solid fa-capsules"></i>Deflazacort<small>7,5 mg = 5 mg pred</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_dexamethasone" value="dexamethasone"><label class="note-option drug-other" for="st_dexamethasone"><i class="fa-solid fa-bolt"></i>Dexametasona<small>0,75 mg = 5 mg pred</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_betamethasone" value="betamethasone"><label class="note-option drug-other" for="st_betamethasone"><i class="fa-solid fa-bolt"></i>Betametasona<small>0,6 mg = 5 mg pred</small></label></div>
                  <div><input class="note-check calc-trigger" type="radio" name="steroid" id="st_fludrocortisone" value="fludrocortisone"><label class="note-option drug-other" for="st_fludrocortisone"><i class="fa-solid fa-wind"></i>Fludrocortisona<small>2 mg = 5 mg pred*</small></label></div>
                </div>
                <div class="steroid-input-help">*La fludrocortisona se incluye por equivalencia docente de la tabla adjunta, pero su potente efecto mineralocorticoide obliga a interpretar con cautela la equivalencia glucocorticoide.</div>
              </div>

              <div class="note-input-group">
                <label class="note-label" for="dailyDose">Dosis diaria habitual</label>
                <div class="note-input-inline">
                  <input type="text" id="dailyDose" class="note-input calc-trigger" inputmode="decimal" placeholder="Ej: 10">
                  <div class="note-input-unit">mg/día</div>
                </div>

                <div class="steroid-selector-sections mt-3">
                  <div>
                    <div class="note-label mb-2">Duración</div>
                    <div class="steroid-selector-options">
                      <div><input class="note-check calc-trigger" type="radio" name="duration" id="dur_short" value="lt3w"><label class="note-option" for="dur_short">&lt; 3 semanas<small>menor riesgo</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="duration" id="dur_long" value="gt3w" checked><label class="note-option" for="dur_long">&gt; 3 semanas<small>más relevante</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="duration" id="dur_unknown" value="unknown"><label class="note-option" for="dur_unknown">Desconocida<small>ser conservador</small></label></div>
                    </div>
                  </div>
                  <div>
                    <div class="note-label mb-2">Eje / diagnóstico</div>
                    <div class="steroid-selector-options">
                      <div><input class="note-check calc-trigger" type="radio" name="axisStatus" id="axis_none" value="none" checked><label class="note-option" for="axis_none">Sin diagnóstico<small>evaluar por dosis</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="axisStatus" id="axis_primary" value="primary"><label class="note-option" for="axis_primary">Primaria<small>Addison</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="axisStatus" id="axis_secondary" value="secondary"><label class="note-option" for="axis_secondary">Secundaria<small>hipófisis</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="axisStatus" id="axis_tertiary" value="tertiary"><label class="note-option" for="axis_tertiary">Terciaria<small>supresión exógena</small></label></div>
                    </div>
                  </div>
                  <div>
                    <div class="note-label mb-2">Suspensión reciente</div>
                    <div class="steroid-selector-options">
                      <div><input class="note-check calc-trigger" type="radio" name="recentStop" id="recentStop_no" value="no" checked><label class="note-option" for="recentStop_no">No<small>continúa terapia</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="recentStop" id="recentStop_yes" value="yes"><label class="note-option" for="recentStop_yes">&lt; 3 meses<small>seguir considerándolo</small></label></div>
                    </div>
                  </div>
                  <div>
                    <div class="note-label mb-2">Estrés quirúrgico</div>
                    <div class="steroid-selector-options">
                      <div><input class="note-check calc-trigger" type="radio" name="surgery" id="sx_superficial" value="superficial"><label class="note-option" for="sx_superficial">Superficial<small>dental / biopsia</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="surgery" id="sx_minor" value="minor" checked><label class="note-option" for="sx_minor">Menor<small>endoscopia / hernia</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="surgery" id="sx_moderate" value="moderate"><label class="note-option" for="sx_moderate">Moderado<small>cole / colectomía</small></label></div>
                      <div><input class="note-check calc-trigger" type="radio" name="surgery" id="sx_major" value="major"><label class="note-option" for="sx_major">Severo / UCI<small>mayor o shock</small></label></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3" id="summaryBox">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Completa la dosis habitual y confirma el estrés quirúrgico para ver la recomendación.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item"><div class="note-summary-k">Droga</div><div id="sumDrug" class="note-summary-v">-</div></div>
            <div class="note-summary-item"><div class="note-summary-k">Dosis habitual</div><div id="sumDose" class="note-summary-v">-</div></div>
            <div class="note-summary-item"><div class="note-summary-k">Prednisona eq.</div><div id="sumPredEq" class="note-summary-v">-</div></div>
            <div class="note-summary-item"><div class="note-summary-k">Riesgo eje</div><div id="sumAxis" class="note-summary-v">-</div></div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Conducta sugerida</div>
            <div id="mainDecision" class="note-result-card-value">Complete required fields to view result</div>
            <div class="note-result-card-note">Decisión operativa según exposición y estrés quirúrgico.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Suplementación perioperatoria</div>
            <div id="mainDosePlan" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Esquema práctico para el día de cirugía y postoperatorio inicial.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Dosis día de cirugía</div>
            <div id="outDaySurgery" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Lo que debería recibir al inicio según riesgo y cirugía.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Equivalente metilpred</div>
            <div id="outMethylEq" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Alternativa útil si no usarás hidrocortisona.</div>
          </div>
        </div>

        <div class="steroid-interpret-grid mb-3">
          <div class="steroid-highlight">
            <div class="k">Interpretación clínica</div>
            <div id="outAxisInterp" class="v">-</div>
            <div id="riskText" class="n">La lectura final depende de dosis, duración y contexto del eje.</div>
          </div>
          <div class="steroid-highlight">
            <div class="k">Retorno a basal</div>
            <div id="outReturn" class="v">-</div>
            <div id="outPostop" class="n">-</div>
          </div>
        </div>

        <div id="validityWarning" class="note-warning mb-3 note-hidden">
          <strong>Advertencia visible</strong><br>
          <span id="validityWarningText"></span>
        </div>

        <div id="fludroWarning" class="note-warning mb-3 note-hidden">
          <strong>Fludrocortisona: cautela importante</strong><br>
          <span id="fludroWarningText">La fludrocortisona tiene gran potencia mineralocorticoide. Aunque la tabla entregue una equivalencia glucocorticoide docente, no debe asumirse como sustituto suficiente de hidrocortisona para cubrir estrés perioperatorio.</span>
        </div>

        <div class="steroid-muted-card mb-3">
          <div class="note-card-title mb-3">Tabla orientativa de equivalencias</div>
          <div class="note-detail-table-wrap">
            <table class="note-detail-table">
              <thead>
                <tr>
                  <th>Fármaco</th>
                  <th>Dosis equiv. (mg)</th>
                  <th>Pot. gluco.</th>
                  <th>Pot. mineral.</th>
                  <th>Vida media (h)</th>
                  <th>Dosis supresora eje HH (mg)</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>Cortisona</td><td>25</td><td>0,8</td><td>0,8</td><td>8–12</td><td>20–32</td></tr>
                <tr><td>Hidrocortisona</td><td>20</td><td>1,0</td><td>1,0</td><td>8–12</td><td>20–32</td></tr>
                <tr><td>Prednisona / Prednisolona</td><td>5</td><td>4</td><td>0,8</td><td>18–36</td><td>7,5</td></tr>
                <tr><td>Metilprednisolona</td><td>4</td><td>5</td><td>0,5</td><td>18–36</td><td>6</td></tr>
                <tr><td>Triamcinolona</td><td>4</td><td>5</td><td>0</td><td>18–36</td><td>6</td></tr>
                <tr><td>Fludrocortisona</td><td>2</td><td>10</td><td>125</td><td>18–36</td><td>2,5</td></tr>
                <tr><td>Deflazacort</td><td>7,5</td><td>4</td><td>0,5</td><td>18–36</td><td>9</td></tr>
                <tr><td>Dexametasona</td><td>0,75</td><td>25</td><td>0</td><td>36–54</td><td>1</td></tr>
                <tr><td>Betametasona</td><td>0,6</td><td>30</td><td>0</td><td>36–54</td><td>1</td></tr>
              </tbody>
            </table>
          </div>
          <div class="note-mobile-detail mt-3">
            <div class="note-mobile-detail-card"><div class="note-mobile-detail-row"><div class="note-mobile-detail-label">Fludrocortisona</div><div class="note-mobile-detail-value">2 mg; potencia glucocorticoide 10; potencia mineralocorticoide 125; vida media 18–36 h; dosis supresora eje HH ≈ 2,5 mg.</div></div></div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Tips docentes</div>
          <div class="note-teaching-main">Piensa en el eje, no solo en el nombre del corticoide</div>
          <div class="note-tips"><strong>Qué hacer:</strong> usa la dosis equivalente para estimar riesgo, pero adapta la cobertura al estrés quirúrgico y a la fisiología del paciente.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> dar stress dose alta por reflejo en cirugías superficiales o asumir que una equivalencia de tabla resuelve toda la interpretación clínica.</div>
          <div class="note-tips"><strong>Error frecuente:</strong> simplificar un paciente con insuficiencia suprarrenal conocida porque su dosis actual parece baja.</div>
          <div class="note-tips mb-0"><strong>Perla de residente:</strong> si existe hipotensión desproporcionada, hipoglicemia, hiponatremia o hiperkalemia en el perioperatorio, piensa temprano en insuficiencia suprarrenal relativa o crisis.</div>
        </div>

        <div class="footer-note mt-3">Herramienta docente y de apoyo clínico. No reemplaza juicio endocrinológico ni manejo de crisis suprarrenal establecida.</div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const DRUGS = {
    prednisone:{label:'Prednisona', eqDose:5, methylFactor:0.8, suppressive:7.5},
    prednisolone:{label:'Prednisolona', eqDose:5, methylFactor:0.8, suppressive:7.5},
    methylpred:{label:'Metilprednisolona', eqDose:4, methylFactor:1, suppressive:6},
    hydrocortisone:{label:'Hidrocortisona', eqDose:20, methylFactor:0.2, suppressive:20},
    cortisone:{label:'Cortisona', eqDose:25, methylFactor:0.16, suppressive:20},
    triamcinolone:{label:'Triamcinolona', eqDose:4, methylFactor:1, suppressive:6},
    deflazacort:{label:'Deflazacort', eqDose:7.5, methylFactor:(4/7.5), suppressive:9},
    dexamethasone:{label:'Dexametasona', eqDose:0.75, methylFactor:(4/0.75), suppressive:1},
    betamethasone:{label:'Betametasona', eqDose:0.6, methylFactor:(4/0.6), suppressive:1},
    fludrocortisone:{label:'Fludrocortisona', eqDose:2, methylFactor:2, suppressive:2.5}
  };

  const SURGERY_LABELS = {
    superficial:'Superficial',
    minor:'Menor',
    moderate:'Moderado',
    major:'Severo / UCI'
  };

  const doseInput = document.getElementById('dailyDose');

  function getSelected(name){
    return CNS.getSelected(name);
  }

  function calculate(){
    const steroid = getSelected('steroid') || 'prednisone';
    const duration = getSelected('duration') || 'gt3w';
    const axisStatus = getSelected('axisStatus') || 'none';
    const recentStop = getSelected('recentStop') || 'no';
    const surgery = getSelected('surgery') || 'minor';
    const drug = DRUGS[steroid];
    const dailyDose = CNS.parseDecimal(doseInput.value);

    const validDose = Number.isFinite(dailyDose) && dailyDose > 0;
    const predEq = validDose ? (dailyDose * 5 / drug.eqDose) : NaN;

    return {steroid, duration, axisStatus, recentStop, surgery, drug, dailyDose, validDose, predEq};
  }

  function updateSummary(state){
    CNS.safeSetText('sumDrug', state.drug.label);
    CNS.safeSetText('sumDose', state.validDose ? CNS.formatNumber(state.dailyDose, 1) + ' mg/día' : '-');
    CNS.safeSetText('sumPredEq', state.validDose ? CNS.formatNumber(state.predEq, 1) + ' mg pred/día' : '-');
    const axisLabelMap = {none:'Por exposición', primary:'Primaria', secondary:'Secundaria', tertiary:'Terciaria'};
    CNS.safeSetText('sumAxis', axisLabelMap[state.axisStatus] || '-');

    const narrative = !state.validDose
      ? 'Completa la dosis habitual y confirma el estrés quirúrgico para ver la recomendación.'
      : `${state.drug.label} ${CNS.formatNumber(state.dailyDose,1)} mg/día; equivalente a ${CNS.formatNumber(state.predEq,1)} mg/día de prednisona. Estrés quirúrgico ${SURGERY_LABELS[state.surgery]}.`;

    CNS.safeSetText('summaryNarrative', narrative);

    const summaryBox = document.getElementById('summaryBox');
    summaryBox.classList.toggle('steroid-fludro', state.steroid === 'fludrocortisone');
  }

  function clearResults(){
    CNS.safeSetText('mainDecision', 'Complete required fields to view result');
    CNS.safeSetText('mainDosePlan', '-');
    CNS.safeSetText('outDaySurgery', '-');
    CNS.safeSetText('outMethylEq', '-');
    CNS.safeSetText('outAxisInterp', '-');
    CNS.safeSetText('riskText', 'La lectura final depende de dosis, duración y contexto del eje.');
    CNS.safeSetText('outReturn', '-');
    CNS.safeSetText('outPostop', '-');
  }

  function updateWarning(state){
    CNS.hideValidityWarning('validityWarning', 'validityWarningText');
    if (!state.validDose) return;

    if (state.dailyDose > 500) {
      CNS.showValidityWarning('validityWarning', 'validityWarningText', 'La dosis ingresada es implausiblemente alta. Revisa si la unidad o la cifra son correctas antes de interpretar la recomendación.');
      return;
    }

    if (state.steroid === 'fludrocortisone') {
      CNS.showElement('fludroWarning', 'note-hidden');
    } else {
      CNS.hideElement('fludroWarning', 'note-hidden');
    }
  }

  function derivePlan(state){
    if (!state.validDose) return null;

    let axisRisk = 'Riesgo bajo';
    let highRisk = false;
    let grayZone = false;

    if (state.axisStatus !== 'none') {
      highRisk = true;
      axisRisk = 'Insuficiencia suprarrenal conocida';
    } else if (state.recentStop === 'yes') {
      highRisk = true;
      axisRisk = 'Suspensión reciente: riesgo persistente';
    } else if (state.predEq > 20 && state.duration !== 'lt3w') {
      highRisk = true;
      axisRisk = 'Supresión del eje muy probable';
    } else if (state.predEq > 5 && state.duration !== 'lt3w') {
      highRisk = true;
      axisRisk = 'Supresión del eje probable';
    } else if (state.predEq <= 5 && state.duration === 'lt3w') {
      axisRisk = 'Riesgo clínico bajo';
    } else if (state.predEq <= 5) {
      axisRisk = 'Riesgo bajo, pero contexto importa';
      grayZone = true;
    } else {
      grayZone = true;
      axisRisk = 'Zona gris';
    }

    let decision = '';
    let dosePlan = '';
    let daySurgery = '';
    let postop = '';
    let methylEq = '';
    let returnPlan = '';
    let riskText = '';

    if (state.steroid === 'fludrocortisone') {
      grayZone = false;
      highRisk = true;
      axisRisk = 'Interpretación especial por fludrocortisona';
    }

    if (!highRisk && !grayZone) {
      if (state.surgery === 'superficial') {
        decision = 'Solo dosis basal';
        dosePlan = 'Sin suplemento adicional';
        daySurgery = 'Mantener esquema basal';
        postop = 'Sin suplementación sistemática';
        methylEq = 'No aplica';
        returnPlan = 'Continuar basal';
        riskText = 'Con exposición baja y procedimiento superficial, una stress dose suele ser innecesaria.';
      } else {
        decision = 'Basal + vigilancia';
        dosePlan = 'Mantener dosis habitual; reevaluar si aparece hipotensión o inestabilidad';
        daySurgery = 'Dosis basal el día de cirugía';
        postop = 'Observación clínica y hemodinámica';
        methylEq = 'No aplica de rutina';
        returnPlan = 'Seguir basal';
        riskText = 'No todos los pacientes en corticoides crónicos necesitan suplementación extra. Aquí pesa más la vigilancia que la escalada automática.';
      }
    } else if (grayZone && !highRisk) {
      if (state.surgery === 'major') {
        decision = 'Cobertura conservadora';
        dosePlan = 'Considerar hidrocortisona 50–100 mg EV al inicio y luego reevaluar';
        daySurgery = '50–100 mg hidrocortisona EV';
        postop = 'Descenso rápido a basal si evolución estable';
        methylEq = '≈ 10–20 mg metilpred EV';
        returnPlan = 'Volver a basal en 24 h si no hay inestabilidad';
      } else if (state.surgery === 'moderate') {
        decision = 'Valorar caso a caso';
        dosePlan = 'Si hay duda real, 25–50 mg hidrocortisona EV';
        daySurgery = '25–50 mg hidrocortisona EV';
        postop = 'Continuar solo si contexto lo exige';
        methylEq = '≈ 5–10 mg metilpred EV';
        returnPlan = 'Volver precozmente a basal';
      } else {
        decision = 'Basal ± cobertura modesta';
        dosePlan = 'Probablemente basta con basal; suplementar solo si la historia es poco confiable';
        daySurgery = 'Basal o 25 mg hidrocortisona EV si duda razonable';
        postop = 'Sin esquema fijo';
        methylEq = '≈ 5 mg metilpred EV si decides cubrir';
        returnPlan = 'Mantener basal';
      }
      riskText = 'Hay datos insuficientes o exposición intermedia. En esta zona, la conducta debe ser prudente pero no exagerada.';
    } else {
      if (state.steroid === 'fludrocortisone') {
        if (state.surgery === 'superficial') {
          decision = 'No usar fludrocortisona como stress dose';
          dosePlan = 'Mantener fludrocortisona habitual; si se requiere cobertura glucocorticoide, usar hidrocortisona';
          daySurgery = 'Basal + valorar hidrocortisona según contexto';
          postop = 'No escales por equivalencia teórica solamente';
          methylEq = 'Preferir traducir la cobertura a hidrocortisona/metilpred, no a fludrocortisona';
          returnPlan = 'Volver al esquema basal cuando el estrés ceda';
        } else if (state.surgery === 'minor') {
          decision = 'Cobertura glucocorticoide pequeña';
          dosePlan = '25 mg hidrocortisona EV si el contexto hace sospechar dependencia del eje';
          daySurgery = '25 mg hidrocortisona EV';
          postop = 'Luego basal';
          methylEq = '≈ 5 mg metilpred EV';
          returnPlan = 'Retomar basal al reiniciar VO';
        } else if (state.surgery === 'moderate') {
          decision = 'Cobertura glucocorticoide 24 h';
          dosePlan = '50–75 mg hidrocortisona EV y luego descenso a basal';
          daySurgery = '50–75 mg hidrocortisona EV';
          postop = '24 h de cobertura inicial';
          methylEq = '≈ 10–15 mg metilpred EV';
          returnPlan = 'Descenso a basal en 24–48 h';
        } else {
          decision = 'Cobertura alta con hidrocortisona';
          dosePlan = '100 mg hidrocortisona EV inicial, luego 50 mg c/6–8 h o equivalente';
          daySurgery = '100 mg hidrocortisona EV';
          postop = '50 mg c/6–8 h inicialmente si cirugía mayor / UCI';
          methylEq = '≈ 20 mg metilpred EV';
          returnPlan = 'Taper según estabilidad hemodinámica';
        }
        riskText = 'La fludrocortisona puede aparecer como equivalente en la tabla, pero su perfil mineralocorticoide la vuelve una mala opción para pensar cobertura perioperatoria automática.';
      } else if (state.surgery === 'superficial') {
        decision = 'Basal o mínima cobertura';
        dosePlan = 'En muchos casos basta con mantener la dosis habitual';
        daySurgery = 'Mantener basal';
        postop = 'Sin esquema suplementario fijo';
        methylEq = 'No suele requerirse';
        returnPlan = 'Continuar basal';
        riskText = 'Aunque el eje esté suprimido, el estrés quirúrgico superficial rara vez exige una cobertura agresiva.';
      } else if (state.surgery === 'minor') {
        decision = 'Suplementación menor';
        dosePlan = '25 mg hidrocortisona EV al inicio; luego volver a basal';
        daySurgery = '25 mg hidrocortisona EV';
        postop = 'Luego continuar basal';
        methylEq = '≈ 5 mg metilpred EV';
        returnPlan = 'Retomar basal el mismo día o al reiniciar VO';
        riskText = 'Cirugía menor + supresión probable: cubrir de forma acotada, no prolongada.';
      } else if (state.surgery === 'moderate') {
        decision = 'Suplementación 24–48 h';
        dosePlan = '50–75 mg hidrocortisona EV y descenso progresivo';
        daySurgery = '50–75 mg hidrocortisona EV';
        postop = 'Cobertura inicial y retorno a basal en 24–48 h si estable';
        methylEq = '≈ 10–15 mg metilpred EV';
        returnPlan = 'Bajar a basal en 24–48 h';
        riskText = 'Aquí el estrés ya es relevante. La cobertura busca evitar respuesta insuficiente al trauma, no añadir esteroides sin propósito.';
      } else {
        decision = 'Suplementación alta / paciente crítico';
        dosePlan = '100 mg hidrocortisona EV inicial; luego 50 mg c/6–8 h o equivalente';
        daySurgery = '100 mg hidrocortisona EV';
        postop = '50 mg c/6–8 h inicialmente si cirugía mayor, shock o UCI';
        methylEq = '≈ 20 mg metilpred EV';
        returnPlan = 'Descenso progresivo según estabilidad';
        riskText = 'En cirugía mayor o paciente crítico, la incapacidad de responder al estrés puede traducirse en hipotensión refractaria. Aquí la cobertura sí debe ser más agresiva.';
      }
    }

    return {axisRisk, decision, dosePlan, daySurgery, postop, methylEq, returnPlan, riskText};
  }

  function updateUI(){
    const state = calculate();
    updateSummary(state);
    updateWarning(state);

    if (!state.validDose) {
      clearResults();
      CNS.hideElement('fludroWarning', 'note-hidden');
      return;
    }

    const plan = derivePlan(state);
    CNS.safeSetText('mainDecision', plan.decision);
    CNS.safeSetText('mainDosePlan', plan.dosePlan);
    CNS.safeSetText('outDaySurgery', plan.daySurgery);
    CNS.safeSetText('outMethylEq', plan.methylEq);
    CNS.safeSetText('outAxisInterp', plan.axisRisk);
    CNS.safeSetText('riskText', plan.riskText);
    CNS.safeSetText('outReturn', plan.returnPlan);
    CNS.safeSetText('outPostop', plan.postop);
  }

  document.querySelectorAll('.calc-trigger').forEach(function(el){
    el.addEventListener('input', updateUI);
    el.addEventListener('change', updateUI);
  });

  if (CNS && CNS.bindSelectionSync) CNS.bindSelectionSync('.note-check');
  updateUI();
})();
</script>

<?php require("../footer.php"); ?>
