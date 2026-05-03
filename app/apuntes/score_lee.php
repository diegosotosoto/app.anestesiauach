<?php
$titulo_pagina = "Índice de Riesgo Cardíaco Revisado";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "El Índice de Riesgo Cardíaco Revisado de Lee, también conocido como RCRI, estima riesgo de complicaciones cardíacas mayores en cirugía no cardíaca usando seis variables clínicas simples. Es útil para estratificar riesgo y orientar evaluación perioperatoria adicional.";
$formula = "RCRI = número de factores presentes: cirugía de alto riesgo, cardiopatía isquémica, insuficiencia cardíaca, enfermedad cerebrovascular, diabetes tratada con insulina y creatinina >2,0 mg/dL. Puntaje total: 0 a 6.";
$referencias = array(
  "Lee TH, Marcantonio ER, Mangione CM, et al. Derivation and prospective validation of a simple index for prediction of cardiac risk of major noncardiac surgery. Circulation. 1999;100(10):1043-1049.",
  "Fleisher LA, Fleischmann KE, Auerbach AD, et al. 2014 ACC/AHA guideline on perioperative cardiovascular evaluation and management of patients undergoing noncardiac surgery. Circulation. 2014;130:e278-e333.",
  "Duceppe E, Parlow J, MacDonald P, et al. Canadian Cardiovascular Society Guidelines on Perioperative Cardiac Risk Assessment and Management for Patients Who Undergo Noncardiac Surgery. Can J Cardiol. 2017;33(1):17-32.",
  "2024 AHA/ACC guideline for perioperative cardiovascular management for noncardiac surgery."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=2"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .lee-factor-list{
            display:grid;
            gap:.75rem;
          }

          .lee-risk-low{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .lee-risk-mid{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .lee-risk-high{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          .note-checklist-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .note-checklist-plan-line:last-child{
            margin-bottom:0;
          }

          .note-checklist-pill{
            display:inline-flex;
            align-items:center;
            gap:.35rem;
            padding:.25rem .55rem;
            border-radius:999px;
            background:#f2f4f7;
            color:#475467;
            font-size:.78rem;
            font-weight:700;
            margin:.15rem .2rem .15rem 0;
          }

          .note-checklist-pill.active{
            background:#eaf7ef;
            color:#1f7a4d;
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · RIESGO CARDIOVASCULAR · CIRUGÍA NO CARDÍACA</div>
          <h2>Índice de Riesgo Cardíaco Revisado</h2>
          <div class="note-hero-subtitle">Checklist interactivo para estimar riesgo cardíaco perioperatorio y orientar la necesidad de evaluación adicional.</div>
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
            <b>Referencias:</b>
            <ul class="mb-0 mt-2">
              <?php foreach($referencias as $ref){ ?>
                <li class="mb-2"><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Factores del RCRI</div>

            <div class="lee-factor-list">
              <label>
                <input class="note-checklist-item-input lee-check" type="checkbox" id="cirugia" data-label="Cirugía alto riesgo">
                <div class="note-checklist-item">
                  <div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div>
                  <div class="note-checklist-item-copy">
                    <div class="note-checklist-item-title">Cirugía de alto riesgo</div>
                    <p class="note-checklist-item-note">Intraperitoneal, intratorácica o vascular suprainguinal.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="note-checklist-item-input lee-check" type="checkbox" id="isquemica" data-label="Cardiopatía isquémica">
                <div class="note-checklist-item">
                  <div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div>
                  <div class="note-checklist-item-copy">
                    <div class="note-checklist-item-title">Antecedente de cardiopatía isquémica</div>
                    <p class="note-checklist-item-note">IAM previo, angina, prueba positiva, uso de nitratos o Q patológica.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="note-checklist-item-input lee-check" type="checkbox" id="icc" data-label="Insuficiencia cardíaca">
                <div class="note-checklist-item">
                  <div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div>
                  <div class="note-checklist-item-copy">
                    <div class="note-checklist-item-title">Antecedente de insuficiencia cardíaca</div>
                    <p class="note-checklist-item-note">ICC clínica actual o previa, edema pulmonar, disnea paroxística nocturna o signos compatibles.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="note-checklist-item-input lee-check" type="checkbox" id="acv" data-label="ACV/AIT">
                <div class="note-checklist-item">
                  <div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div>
                  <div class="note-checklist-item-copy">
                    <div class="note-checklist-item-title">Antecedente de ACV o AIT</div>
                    <p class="note-checklist-item-note">Historia cerebrovascular previa.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="note-checklist-item-input lee-check" type="checkbox" id="insulina" data-label="Diabetes con insulina">
                <div class="note-checklist-item">
                  <div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div>
                  <div class="note-checklist-item-copy">
                    <div class="note-checklist-item-title">Diabetes tratada con insulina</div>
                    <p class="note-checklist-item-note">Usuario de insulina en el manejo habitual.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="note-checklist-item-input lee-check" type="checkbox" id="creatinina" data-label="Creatinina >2 mg/dL">
                <div class="note-checklist-item">
                  <div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div>
                  <div class="note-checklist-item-copy">
                    <div class="note-checklist-item-title">Creatinina &gt; 2,0 mg/dL</div>
                    <p class="note-checklist-item-note">Disfunción renal significativa según definición original del índice.</p>
                  </div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">0 factores RCRI seleccionados. Riesgo estimado bajo; integrar con capacidad funcional, urgencia y magnitud quirúrgica.</div>
          <div class="note-result-grid-2 mt-2">
            <div class="note-result-card">
              <div class="note-result-card-label">Puntaje</div>
              <div id="summaryScore" class="note-result-card-value">0</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Riesgo estimado</div>
              <div id="summaryRisk" class="note-result-card-value">0,4%</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Nivel</div>
              <div id="summaryLevel" class="note-result-card-value">Bajo</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Factores activos</div>
              <div id="summaryFactors" class="note-result-card-value">Ninguno</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="scoreCard" class="note-result-card lee-risk-low">
            <div class="note-result-card-label">Puntaje RCRI</div>
            <div id="scoreNum" class="note-result-card-value">0</div>
            <div id="scoreText" class="note-result-card-note">0 factores de riesgo</div>
          </div>
          <div id="riskCard" class="note-result-card lee-risk-low">
            <div class="note-result-card-label">Riesgo cardíaco estimado</div>
            <div id="riskPercent" class="note-result-card-value">0,4%</div>
            <div id="riskInterpretation" class="note-result-card-note">Riesgo bajo de complicaciones cardíacas mayores perioperatorias.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Conducta orientativa</div>
          <div id="algoRisk" class="note-interpretation-main">Riesgo bajo</div>
          <div id="algoExtra" class="note-interpretation-soft">Proceder con evaluación perioperatoria estándar si el contexto clínico, la cirugía y la capacidad funcional son favorables.</div>

          <div class="mt-3 text-start">
            <div class="note-checklist-plan-line"><strong>Lectura:</strong> <span id="planReading">Riesgo bajo. RCRI no sugiere por sí solo evaluación cardiovascular adicional.</span></div>
            <div class="note-checklist-plan-line"><strong>Qué integrar:</strong> <span id="planIntegrate">Capacidad funcional, síntomas cardiovasculares, urgencia, magnitud quirúrgica y biomarcadores si corresponden.</span></div>
            <div class="note-checklist-plan-line"><strong>Factores seleccionados:</strong> <span id="factorPills"><span class="note-checklist-pill">Ninguno</span></span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div class="mt-2">El RCRI no decide exámenes ni suspensión quirúrgica de forma automática. No reemplaza capacidad funcional, síntomas activos, inestabilidad clínica, tipo de cirugía, biomarcadores, ECG ni juicio perioperatorio.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon ok"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Riesgo bajo por RCRI</div>
                  <p class="note-warning-note">Completar evaluación clínica estándar, capacidad funcional y contexto quirúrgico.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">El RCRI estratifica; no autoriza ni cancela una cirugía por sí solo</div>
          <div class="note-tips"><strong>Qué hacer:</strong> úsalo junto a capacidad funcional, síntomas, urgencia, magnitud de la cirugía y evaluación médica actual.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> pedir exámenes “por puntaje” sin preguntarte si cambiarán conducta perioperatoria.</div>
          <div class="note-tips"><strong>Error frecuente:</strong> tratar el RCRI como score de riesgo anestésico global. Es cardíaco, no predice vía aérea, sangrado, delirium ni complicaciones pulmonares.</div>
          <div class="note-tips"><strong>Cirugía urgente:</strong> un RCRI alto no debe retrasar una cirugía impostergable; debe gatillar optimización posible, monitorización y planificación.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si hay angina inestable, insuficiencia cardíaca descompensada, arritmia significativa o valvulopatía severa sintomática, eso pesa más que el número del RCRI.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};
  const checks = Array.from(document.querySelectorAll('.lee-check'));

  function setText(id, value){
    const el = document.getElementById(id);
    if(CNS.safeSetText) CNS.safeSetText(el, value);
    else if(el) el.textContent = value;
  }

  function riskData(score){
    if(score === 0){
      return {
        risk:'0,4%',
        level:'Bajo',
        css:'lee-risk-low',
        interpretation:'Riesgo bajo de complicaciones cardíacas mayores perioperatorias.',
        algo:'Riesgo bajo',
        extra:'Proceder con evaluación perioperatoria estándar si el contexto clínico, la cirugía y la capacidad funcional son favorables.',
        reading:'Riesgo bajo. RCRI no sugiere por sí solo evaluación cardiovascular adicional.'
      };
    }

    if(score === 1){
      return {
        risk:'0,9%',
        level:'Bajo-intermedio',
        css:'lee-risk-low',
        interpretation:'Riesgo discretamente aumentado de complicaciones cardíacas mayores.',
        algo:'Riesgo bajo-intermedio',
        extra:'Integrar con capacidad funcional, síntomas, tipo de cirugía y estado cardiovascular actual.',
        reading:'Riesgo bajo-intermedio. Puede requerir ajuste de evaluación según cirugía y capacidad funcional.'
      };
    }

    if(score === 2){
      return {
        risk:'6,6%',
        level:'Intermedio',
        css:'lee-risk-mid',
        interpretation:'Riesgo intermedio de complicaciones cardíacas mayores.',
        algo:'Riesgo intermedio',
        extra:'Puede justificar evaluación más detallada si el resultado cambiará manejo, monitorización u optimización.',
        reading:'Riesgo intermedio. Evaluar necesidad de optimización, biomarcadores o monitorización según guías y contexto.'
      };
    }

    return {
      risk:'11%',
      level:'Alto',
      css:'lee-risk-high',
      interpretation:'Riesgo alto de complicaciones cardíacas mayores perioperatorias.',
      algo:'Riesgo alto',
      extra:'Requiere evaluación cardiovascular perioperatoria más cuidadosa y optimización según urgencia clínica.',
      reading:'Riesgo alto. No implica cancelar automáticamente, pero sí planificar optimización, monitorización y comunicación del riesgo.'
    };
  }

  function renderActions(score, activeLabels){
    let items = [];

    if(score === 0){
      items = [
        ['ok','Riesgo bajo por RCRI','Completar evaluación clínica estándar, capacidad funcional y contexto quirúrgico.'],
        ['ok','No pedir exámenes solo por rutina','Solicitar estudios solo si cambiarán conducta o hay síntomas/contexto que lo justifique.']
      ];
    } else if(score === 1){
      items = [
        ['ok','Integrar con METs y síntomas','Un factor aislado no define por sí solo necesidad de evaluación adicional.'],
        ['mid','Revisar magnitud quirúrgica','El mismo puntaje puede pesar distinto en cirugía menor versus cirugía mayor.']
      ];
    } else if(score === 2){
      items = [
        ['mid','Riesgo intermedio','Considerar evaluación adicional si cambiará conducta, monitorización o timing quirúrgico.'],
        ['mid','Optimizar condiciones modificables','Control de IC, isquemia, glicemia, presión, anemia y función renal según contexto.']
      ];
    } else {
      items = [
        ['high','Riesgo alto','Coordinar evaluación cardiovascular, anestésica y quirúrgica según urgencia y posibilidad real de optimización.'],
        ['high','Planificar monitorización y postoperatorio','Considerar unidad monitorizada, biomarcadores, ECG y manejo hemodinámico según protocolos.']
      ];
    }

    if(activeLabels.includes('Insuficiencia cardíaca')){
      items.push(['high','Insuficiencia cardíaca pesa clínicamente','Buscar descompensación, congestión, tolerancia al ejercicio y tratamiento optimizado.']);
    }

    if(activeLabels.includes('Cardiopatía isquémica')){
      items.push(['mid','Isquemia conocida','Preguntar por síntomas activos, estabilidad, tratamiento y capacidad funcional.']);
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="note-warning-item">' +
        '<div class="note-warning-icon ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="note-warning-copy">' +
          '<div class="note-warning-title">' + item[1] + '</div>' +
          '<p class="note-warning-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function renderPills(activeLabels){
    const box = document.getElementById('factorPills');
    if(activeLabels.length === 0){
      box.innerHTML = '<span class="note-checklist-pill">Ninguno</span>';
      return;
    }
    box.innerHTML = activeLabels.map(function(label){
      return '<span class="note-checklist-pill active"><i class="fa-solid fa-check"></i>' + label + '</span>';
    }).join('');
  }

  function updateLee(){
    const active = checks.filter(function(ch){ return ch.checked; });
    const score = active.length;
    const labels = active.map(function(ch){ return ch.getAttribute('data-label'); });
    const data = riskData(score);

    setText('scoreNum', String(score));
    setText('scoreText', score + (score === 1 ? ' factor de riesgo' : ' factores de riesgo'));
    setText('riskPercent', data.risk);
    setText('riskInterpretation', data.interpretation);
    setText('summaryScore', String(score));
    setText('summaryRisk', data.risk);
    setText('summaryLevel', data.level);
    setText('summaryFactors', labels.length ? labels.join(', ') : 'Ninguno');
    setText('summaryNarrative', score + (score === 1 ? ' factor RCRI seleccionado. ' : ' factores RCRI seleccionados. ') + 'Riesgo estimado ' + data.risk + '; ' + data.level.toLowerCase() + '. Integrar con capacidad funcional, síntomas y magnitud quirúrgica.');
    setText('algoRisk', data.algo);
    setText('algoExtra', data.extra);
    setText('planReading', data.reading);

    document.getElementById('scoreCard').className = 'note-result-card ' + data.css;
    document.getElementById('riskCard').className = 'note-result-card ' + data.css;

    renderPills(labels);
    renderActions(score, labels);
  }

  checks.forEach(function(ch){
    ch.addEventListener('change', updateLee);
  });

  updateLee();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
