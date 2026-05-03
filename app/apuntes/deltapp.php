<?php
$titulo_pagina = "Delta PP";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "El Delta de Presión de Pulso (Delta PP o PPV) es una herramienta dinámica para estimar respuesta a volumen en pacientes con ventilación mecánica. Un valor elevado solo es interpretable si se cumplen criterios estrictos de validez fisiológica.";
$formula = "Delta PP = (PPmáx - PPmín) / ((PPmáx + PPmín) / 2) × 100";
$referencias = array(
  "Hofer CK, Müller SM, Furrer L, Klaghofer R, Genoni M, Zollinger A. Stroke volume and pulse pressure variation for prediction of fluid responsiveness in patients undergoing off-pump coronary artery bypass grafting. Chest. 2005;128(2):848-854.",
  "Mahjoub Y, Lejeune V, Muller L, et al. Evaluation of pulse pressure variation validity criteria in critically ill patients: a prospective observational multicentre point-prevalence study. Br J Anaesth. 2014;112(4):681-685.",
  "Michard F, Boussat S, Chemla D, et al. Relation between respiratory changes in arterial pulse pressure and fluid responsiveness in septic patients with acute circulatory failure. Am J Respir Crit Care Med. 2000;162(1):134-138."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .dpp-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;}
          .dpp-summary-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .dpp-main-result{background:linear-gradient(180deg,var(--note-brand-soft) 0%,#f7faff 100%);border:1px solid var(--note-brand-soft-border);border-radius:1rem;padding:1rem 1.1rem;}
          .dpp-main-result-value{font-size:2rem;font-weight:900;line-height:1;color:var(--note-brand);}
          .dpp-main-result-label{font-size:.82rem;text-transform:uppercase;letter-spacing:.06em;color:#3559b7;font-weight:700;margin-bottom:.35rem;}
          .dpp-main-result-title{font-size:1.15rem;font-weight:800;color:var(--note-text);line-height:1.2;}
          .dpp-question-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .dasi-question-card{border:1px solid var(--note-line);background:#fff;border-radius:1rem;padding:.9rem;box-shadow:0 4px 14px rgba(15,23,42,.04);}
          .dasi-question-text{font-size:.92rem;font-weight:700;color:#3559b7;line-height:1.35;margin-bottom:.7rem;}
          body.theme-dark .dasi-question-text{color:#8bb3ff;}
          .dasi-choice-inline{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.5rem;}
          .dasi-yn-label{display:flex;align-items:center;justify-content:center;gap:.45rem;min-height:58px;border:1px solid #dfe7f2;background:#fff;border-radius:.85rem;padding:.55rem .45rem;font-weight:700;color:#1f2a37;cursor:pointer;transition:.15s ease;box-shadow:0 4px 14px rgba(0,0,0,.04);font-size:.92rem;}
          .dasi-yn-icon{width:26px;height:26px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:800;flex:0 0 auto;}
          .dasi-yn-yes .dasi-yn-icon{background:#eaf7ef;color:#1f9d55;border:1px solid #bfe4cb;}
          .dasi-yn-no .dasi-yn-icon{background:#fff1ef;color:#d92d20;border:1px solid #efc2bb;}
          .choice-check:checked + .dasi-yn-label{background:#eef3ff;border-color:#9fb9f8;color:#27458f;box-shadow:0 0 0 3px rgba(47,128,237,.12), 0 8px 18px rgba(0,0,0,.06);}
          .dpp-binary{min-width:0;}
          .dpp-binary-help{font-size:.78rem;color:var(--note-muted);line-height:1.25;margin-top:.12rem;}
          .dpp-footer-note{text-align:center;color:var(--note-muted);font-size:.86rem;}
          @media (max-width:768px){
            .dpp-grid,.dpp-question-grid{grid-template-columns:1fr;}
          }
          @media (max-width:420px){
            .dasi-choice-inline,.dpp-summary-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · HEMODINÁMICA</div>
          <h2>Delta de presión de pulso</h2>
          <div class="note-hero-subtitle">Estimación orientativa de respuesta a volumen basada en variación respiratoria de la presión de pulso, con verificación explícita de validez fisiológica.</div>
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
              <b>Fórmula:</b><br>
              <?php echo $formula; ?>
            <?php } ?>
            <hr>
            <div class="small-note mb-2"><strong>Interpretación prudente:</strong> un Delta PP alto no obliga automáticamente a administrar volumen. Debe integrarse con perfusión, contexto quirúrgico, sangrado, función ventricular y riesgos de sobrecarga.</div>
            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0 small-note">
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
            <div class="dpp-grid">
              <div class="note-input-group">
                <label class="note-label" for="s_max">Sistólica máxima</label>
                <div class="note-input-inline">
                  <input type="text" id="s_max" class="note-input" inputmode="decimal" value="">
                  <div class="note-input-unit">mmHg</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label" for="d_max">Diastólica máxima</label>
                <div class="note-input-inline">
                  <input type="text" id="d_max" class="note-input" inputmode="decimal" value="">
                  <div class="note-input-unit">mmHg</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label" for="s_min">Sistólica mínima</label>
                <div class="note-input-inline">
                  <input type="text" id="s_min" class="note-input" inputmode="decimal" value="">
                  <div class="note-input-unit">mmHg</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label" for="d_min">Diastólica mínima</label>
                <div class="note-input-inline">
                  <input type="text" id="d_min" class="note-input" inputmode="decimal" value="">
                  <div class="note-input-unit">mmHg</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="section-title mb-3">Criterios de validez</div>
            <div class="dpp-question-grid">
              <div class="dasi-question-card">
                <div class="dasi-question-text">¿Tórax cerrado?</div>
                <div class="dasi-choice-inline">
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="thorax" id="thorax_yes" value="yes" checked>
                    <label class="dasi-yn-label dasi-yn-yes" for="thorax_yes"><span class="dasi-yn-icon"><i class="fa-solid fa-check"></i></span><span>Sí</span></label>
                  </div>
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="thorax" id="thorax_no" value="no">
                    <label class="dasi-yn-label dasi-yn-no" for="thorax_no"><span class="dasi-yn-icon"><i class="fa-solid fa-xmark"></i></span><span>No</span></label>
                  </div>
                </div>
              </div>
              <div class="dasi-question-card">
                <div class="dasi-question-text">¿Ventilación mecánica controlada, sin respiración espontánea importante?</div>
                <div class="dasi-choice-inline">
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="control" id="control_yes" value="yes" checked>
                    <label class="dasi-yn-label dasi-yn-yes" for="control_yes"><span class="dasi-yn-icon"><i class="fa-solid fa-check"></i></span><span>Sí</span></label>
                  </div>
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="control" id="control_no" value="no">
                    <label class="dasi-yn-label dasi-yn-no" for="control_no"><span class="dasi-yn-icon"><i class="fa-solid fa-xmark"></i></span><span>No</span></label>
                  </div>
                </div>
              </div>
              <div class="dasi-question-card">
                <div class="dasi-question-text">¿Volumen corriente ≥ 8 mL/kg?</div>
                <div class="dasi-choice-inline">
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="vt" id="vt_yes" value="yes" checked>
                    <label class="dasi-yn-label dasi-yn-yes" for="vt_yes"><span class="dasi-yn-icon"><i class="fa-solid fa-check"></i></span><span>Sí</span></label>
                  </div>
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="vt" id="vt_no" value="no">
                    <label class="dasi-yn-label dasi-yn-no" for="vt_no"><span class="dasi-yn-icon"><i class="fa-solid fa-xmark"></i></span><span>No</span></label>
                  </div>
                </div>
              </div>
              <div class="dasi-question-card">
                <div class="dasi-question-text">¿Ritmo sinusal?</div>
                <div class="dasi-choice-inline">
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="sinus" id="sinus_yes" value="yes" checked>
                    <label class="dasi-yn-label dasi-yn-yes" for="sinus_yes"><span class="dasi-yn-icon"><i class="fa-solid fa-check"></i></span><span>Sí</span></label>
                  </div>
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="sinus" id="sinus_no" value="no">
                    <label class="dasi-yn-label dasi-yn-no" for="sinus_no"><span class="dasi-yn-icon"><i class="fa-solid fa-xmark"></i></span><span>No</span></label>
                  </div>
                </div>
              </div>
              <div class="dasi-question-card">
                <div class="dasi-question-text">¿Decúbito supino, sin cambios posturales relevantes?</div>
                <div class="dasi-choice-inline">
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="position" id="position_yes" value="yes" checked>
                    <label class="dasi-yn-label dasi-yn-yes" for="position_yes"><span class="dasi-yn-icon"><i class="fa-solid fa-check"></i></span><span>Sí</span></label>
                  </div>
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="position" id="position_no" value="no">
                    <label class="dasi-yn-label dasi-yn-no" for="position_no"><span class="dasi-yn-icon"><i class="fa-solid fa-xmark"></i></span><span>No</span></label>
                  </div>
                </div>
              </div>
              <div class="dasi-question-card">
                <div class="dasi-question-text">¿Hay condiciones que invalidan o distorsionan la medición?</div>
                <div class="dpp-binary-help mb-2">Ej: tórax abierto, ventilación muy protectora, esfuerzo espontáneo importante, hipertensión intraabdominal relevante, PEEP/VD muy alterados.</div>
                <div class="dasi-choice-inline">
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="invalidator" id="invalidator_no" value="no" checked>
                    <label class="dasi-yn-label dasi-yn-yes" for="invalidator_no"><span class="dasi-yn-icon"><i class="fa-solid fa-check"></i></span><span>No</span></label>
                  </div>
                  <div class="dpp-binary">
                    <input class="choice-check validity-check" type="radio" name="invalidator" id="invalidator_yes" value="yes">
                    <label class="dasi-yn-label dasi-yn-no" for="invalidator_yes"><span class="dasi-yn-icon"><i class="fa-solid fa-xmark"></i></span><span>Sí</span></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa las presiones y revisa los criterios de validez para interpretar el Delta PP con seguridad.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">PP máxima</div>
                <div id="ppMax" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">PP mínima</div>
                <div id="ppMin" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Validez del índice</div>
                <div id="summaryValidity" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Categoría</div>
                <div id="summaryCategory" class="note-result-card-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title mb-3">Resultado e interpretación</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Resultado principal</div>
                <div id="resultTitle" class="note-result-card-value">Delta PP</div>
                <div id="deltaPP" class="note-result-card-note">-</div>
                <div id="resultText" class="small-note text-muted mt-1">Resultado orientativo; interpretar solo si los criterios de validez son aceptables.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Interpretación clínica</div>
                <div id="interpretationMain" class="note-result-card-value">Pendiente de cálculo</div>
                <div id="interpretationSoft" class="small-note text-muted mt-1">Integra el resultado con perfusión, sangrado, función ventricular y riesgos del paciente.</div>
              </div>
            </div>
          </div>
        </div>

        <div id="warningBox" class="note-warning mb-3">
          <div class="note-card-title">Advertencia</div>
          <div id="warningText" class="mb-0">Si el índice no cumple criterios de validez, el número puede ser matemáticamente correcto pero clínicamente engañoso.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta sugerida</div>
            <div id="conductBox" class="conduct-box">
              <div id="conductText">Usa el Delta PP como herramienta dinámica complementaria. Si el valor cae en zona gris o la validez es parcial, apóyate en otras maniobras dinámicas o ecografía.</div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mt-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Un Delta PP alto no siempre significa “dar volumen”</div>
          <div class="note-tips"><strong>Qué hacer:</strong> confirmar que la fisiología del paciente hace interpretable el índice antes de actuar.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> tratar un Delta PP aislado como orden automática de fluidos.</div>
          <div class="note-tips mb-0"><strong>Error frecuente:</strong> usar el índice con arritmia, respiración espontánea importante o ventilación no comparable, y luego confiar en el número.</div>
        </div>

        <div class="dpp-footer-note mt-3">Este cálculo orienta interpretación hemodinámica simplificada. No reemplaza juicio clínico integral ni otras herramientas de evaluación de respuesta a fluidos.</div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const ids = ['s_max','d_max','s_min','d_min'];
  const inputs = ids.map(id => document.getElementById(id));

  if (CNS && CNS.bindSelectionSync) {
    CNS.bindSelectionSync('.validity-check');
  }

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function getValidityState(){
    const required = [
      getSelected('thorax') === 'yes',
      getSelected('control') === 'yes',
      getSelected('vt') === 'yes',
      getSelected('sinus') === 'yes',
      getSelected('position') === 'yes',
      getSelected('invalidator') === 'no'
    ];
    const validCount = required.filter(Boolean).length;
    if (validCount === required.length) return 'valid';
    if (validCount >= 4) return 'partial';
    return 'invalid';
  }

  function update(){
    const sMax = CNS.parseDecimal(document.getElementById('s_max').value);
    const dMax = CNS.parseDecimal(document.getElementById('d_max').value);
    const sMin = CNS.parseDecimal(document.getElementById('s_min').value);
    const dMin = CNS.parseDecimal(document.getElementById('d_min').value);

    if ([sMax,dMax,sMin,dMin].some(v => !Number.isFinite(v))) {
      CNS.safeSetText('ppMax','-');
      CNS.safeSetText('ppMin','-');
      CNS.safeSetText('deltaPP','-');
      CNS.safeSetText('summaryValidity','Pendiente');
      CNS.safeSetText('summaryCategory','Pendiente');
      CNS.safeSetText('resultTitle','Delta PP');
      CNS.safeSetText('resultText','Completa las presiones y revisa los criterios de validez.');
      CNS.safeSetText('interpretationMain','Pendiente de cálculo');
      CNS.safeSetText('interpretationSoft','Integra el resultado con perfusión, sangrado, función ventricular y riesgos del paciente.');
      CNS.safeSetText('warningText','Si el índice no cumple criterios de validez, el número puede ser matemáticamente correcto pero clínicamente engañoso.');
      CNS.safeSetText('conductText','Usa el Delta PP como herramienta dinámica complementaria. Si el valor cae en zona gris o la validez es parcial, apóyate en otras maniobras dinámicas o ecografía.');
      CNS.safeSetText('summaryNarrative','Ingresa las presiones y revisa los criterios de validez para interpretar el Delta PP con seguridad.');
      return;
    }

    const ppMax = sMax - dMax;
    const ppMin = sMin - dMin;
    const meanPP = (ppMax + ppMin) / 2;
    const delta = meanPP > 0 ? ((ppMax - ppMin) / meanPP) * 100 : NaN;

    CNS.safeSetText('ppMax', Number.isFinite(ppMax) ? CNS.formatNumber(ppMax, 0) + ' mmHg' : '-');
    CNS.safeSetText('ppMin', Number.isFinite(ppMin) ? CNS.formatNumber(ppMin, 0) + ' mmHg' : '-');
    CNS.safeSetText('deltaPP', Number.isFinite(delta) ? CNS.formatNumber(delta, 1) + '%' : '-');

    const validity = getValidityState();
    let validityLabel = 'Parcial';
    if (validity === 'valid') validityLabel = 'Adecuada';
    if (validity === 'invalid') validityLabel = 'No adecuada';
    CNS.safeSetText('summaryValidity', validityLabel);

    let category = 'Zona gris';
    let main = 'Interpretación intermedia';
    let resultText = 'Resultado orientativo; interpretar solo si los criterios de validez son aceptables.';
    let interpretationSoft = 'Integra el resultado con perfusión, sangrado, función ventricular y riesgos del paciente.';
    let warningText = 'Si el índice no cumple criterios de validez, el número puede ser matemáticamente correcto pero clínicamente engañoso.';
    let conductText = 'Usa el Delta PP como herramienta dinámica complementaria. Si el valor cae en zona gris o la validez es parcial, apóyate en otras maniobras dinámicas o ecografía.';

    if (Number.isFinite(delta)) {
      if (delta > 12) {
        category = 'Alto';
        main = validity === 'valid' ? 'Probable respondedor a volumen' : 'Delta PP alto con validez limitada';
        resultText = validity === 'valid'
          ? 'Valor elevado, compatible con alta probabilidad de respuesta a volumen si el contexto clínico acompaña.'
          : 'El valor es alto, pero la confianza fisiológica del índice es incompleta.';
        interpretationSoft = validity === 'valid'
          ? 'Si existe hipoperfusión y el resto del contexto acompaña, puedes considerar prueba de volumen o estrategia dinámica equivalente.'
          : 'No uses este resultado aislado para imponer fluidos; confirma con otras herramientas o mejora primero las condiciones de medición.';
        conductText = validity === 'valid'
          ? 'Delta PP > 12–13% con criterios de validez adecuados: probable respondedor a volumen. Integra con perfusión, sangrado y riesgo de sobrecarga.'
          : 'Delta PP alto pero con validez parcial/no adecuada: confirma con elevación pasiva de piernas, eco o prueba de volumen pequeña antes de decidir.';
      } else if (delta < 9) {
        category = 'Bajo';
        main = validity === 'valid' ? 'Poco probable respondedor a volumen' : 'Delta PP bajo con validez limitada';
        resultText = validity === 'valid'
          ? 'Valor bajo, poco compatible con respuesta a fluidos si el índice es fiable.'
          : 'El valor es bajo, pero las condiciones de medición reducen la confianza del resultado.';
        interpretationSoft = validity === 'valid'
          ? 'Si persiste inestabilidad, considera otras causas: vasodilatación, disfunción miocárdica, obstrucción o sangrado no resuelto.'
          : 'Un valor bajo sin criterios válidos no excluye hipovolemia ni otras causas de hipoperfusión.';
        conductText = validity === 'valid'
          ? 'Delta PP < 9% con validez adecuada: poco probable respondedor a volumen. Replantea otras causas de inestabilidad.'
          : 'Delta PP bajo con validez insuficiente: no descartes respuesta a volumen solo por este resultado.';
      } else {
        category = 'Zona gris';
        main = 'Resultado intermedio';
        resultText = 'El valor cae en una zona gris. No clasifica con seguridad como respondedor o no respondedor.';
        interpretationSoft = 'Usa otras maniobras dinámicas o ecocardiografía para refinar la decisión.';
        conductText = 'Delta PP entre 9 y 12%: no tomes decisiones sólo con este valor. Prefiere maniobras complementarias o integración multimodal.';
      }
    }

    if (validity === 'invalid') {
      warningText = 'Los criterios de validez son insuficientes. No deberías usar este Delta PP como base principal para decidir fluidos.';
    } else if (validity === 'partial') {
      warningText = 'La validez del índice es parcial. Interpreta con cautela y apóyate en otras herramientas dinámicas.';
    } else {
      warningText = 'Aunque el índice sea válido, nunca reemplaza juicio clínico integral ni evaluación de riesgo de sobrecarga.';
    }

    CNS.safeSetText('summaryCategory', category);
    CNS.safeSetText('resultTitle', main);
    CNS.safeSetText('resultText', resultText);
    CNS.safeSetText('interpretationMain', main);
    CNS.safeSetText('interpretationSoft', interpretationSoft);
    CNS.safeSetText('warningText', warningText);
    CNS.safeSetText('conductText', conductText);
    CNS.safeSetText('summaryNarrative', 'PP máxima ' + CNS.formatNumber(ppMax,0) + ' mmHg, PP mínima ' + CNS.formatNumber(ppMin,0) + ' mmHg. Delta PP ' + CNS.formatNumber(delta,1) + '%. Validez ' + validityLabel.toLowerCase() + ' del índice.');
  }

  inputs.forEach(el => el.addEventListener('input', update));
  document.querySelectorAll('.validity-check').forEach(el => el.addEventListener('change', update));
  update();
})();
</script>

<?php
require("../footer.php");
?>
