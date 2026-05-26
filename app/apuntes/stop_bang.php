<?php
$titulo_pagina = "STOP-BANG Score";
$navbar_titulo = "Apuntes";

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para aplicar la escala STOP-Bang como tamizaje de apnea obstructiva del sueño en evaluación preoperatoria. No diagnostica apnea del sueño ni evalúa apnea central; orienta riesgo y ayuda a planificar precauciones perioperatorias.";
$formula = "Puntaje STOP-Bang = suma de 8 variables dicotómicas: ronquido, cansancio, apneas observadas, presión arterial, IMC &gt; 35 kg/m², edad &gt; 50 años, circunferencia cervical &gt; 40 cm y sexo masculino. Cada respuesta positiva suma 1 punto. Interpretación habitual: 0-2 bajo riesgo, 3-4 riesgo intermedio, 5-8 alto riesgo de apnea obstructiva del sueño.";
$referencias = array(
  "Chung F, Yegneswaran B, Liao P, et al. STOP questionnaire: a tool to screen patients for obstructive sleep apnea. Anesthesiology. 2008;108(5):812-821.",
  "Chung F, Abdullah HR, Liao P. STOP-Bang Questionnaire: A Practical Approach to Screen for Obstructive Sleep Apnea. Chest. 2016;149(3):631-638.",
  "Chung F, Subramanyam R, Liao P, Sasaki E, Shapiro C, Sun Y. High STOP-Bang score indicates a high probability of obstructive sleep apnoea. Br J Anaesth. 2012;108(5):768-775.",
  "MDCalc. STOP-BANG Score for Obstructive Sleep Apnea. Consultado como referencia de estructura de ítems e interpretación clínica."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<style>
  .stopbang-shell{max-width:1080px;margin:0 auto;}
  .stopbang-badge{
    display:inline-flex;align-items:center;justify-content:center;
    min-width:74px;padding:.38rem .78rem;border-radius:999px;
    background:#eef3ff;color:#3559b7;font-weight:800;font-size:.92rem;
  }
  .stopbang-layout{display:grid;grid-template-columns:1fr;gap:1rem;}
  .stopbang-layout .note-input-group{background:transparent !important;border:none !important;padding:0 !important;}
  .stopbang-question-grid{display:grid;grid-template-columns:1fr;gap:.75rem;}
  .stopbang-question-card{
    border:1px solid var(--note-line);background:#fff;border-radius:1rem;padding:.9rem;
    box-shadow:0 4px 14px rgba(15,23,42,.04);
  }
  .stopbang-question-text{font-size:.92rem;font-weight:700;color:#3559b7;line-height:1.35;margin-bottom:.7rem;}
  body.theme-dark .stopbang-question-text{color:#8bb3ff;}
  .stopbang-question-points{font-size:.78rem;color:var(--note-muted);margin-bottom:.55rem;}
  .stopbang-choice-inline{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.5rem;}
  .stopbang-yn-label{
    display:flex;align-items:center;justify-content:center;gap:.45rem;
    min-height:58px;border:1px solid #dfe7f2;background:#fff;border-radius:.85rem;
    padding:.55rem .45rem;font-weight:700;color:#1f2a37;cursor:pointer;transition:.15s ease;
    box-shadow:0 4px 14px rgba(0,0,0,.04);font-size:.92rem;
  }
  .stopbang-yn-icon{
    width:26px;height:26px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;
    font-size:.9rem;font-weight:800;flex:0 0 auto;
  }
  .stopbang-yn-yes .stopbang-yn-icon{background:#eaf7ef;color:#1f9d55;border:1px solid #bfe4cb;}
  .stopbang-yn-no .stopbang-yn-icon{background:#fff1ef;color:#d92d20;border:1px solid #efc2bb;}
  .choice-check:checked + .stopbang-yn-label{
    background:#eef3ff;border-color:#9fb9f8;color:#27458f;
    box-shadow:0 0 0 3px rgba(47,128,237,.12), 0 8px 18px rgba(0,0,0,.06);
  }

  /* Dark mode overrides */
  body.theme-dark .stopbang-yn-label,
  body.ui-nocturno .stopbang-yn-label{
    background:var(--app-card);
    border-color:var(--app-border);
    color:var(--app-text);
  }
  body.theme-dark .stopbang-yn-yes .stopbang-yn-icon,
  body.ui-nocturno .stopbang-yn-yes .stopbang-yn-icon{
    background:rgba(31,157,85,.15);
    color:#6fe496;
    border-color:rgba(31,157,85,.3);
  }
  body.theme-dark .stopbang-yn-no .stopbang-yn-icon,
  body.ui-nocturno .stopbang-yn-no .stopbang-yn-icon{
    background:rgba(217,45,32,.15);
    color:#f87171;
    border-color:rgba(217,45,32,.3);
  }
  body.theme-dark .choice-check:checked + .stopbang-yn-label,
  body.ui-nocturno .choice-check:checked + .stopbang-yn-label{
    background:rgba(47,128,237,.15);
    border-color:rgba(111,174,255,.5);
    color:#6faeff;
    box-shadow:0 0 0 3px rgba(111,174,255,.12), 0 8px 18px rgba(0,0,0,.2);
  }
  .stopbang-side-stack{display:grid;gap:1rem;}
  .stopbang-context-grid{display:grid;gap:.85rem;}
  .stopbang-context-block{border:1px solid var(--note-line);border-radius:1rem;background:var(--note-soft);padding:1rem;}
  .stopbang-context-options{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.6rem;}
  .stopbang-main-result{
    background:linear-gradient(180deg,var(--note-brand-soft) 0%, #f7faff 100%);
    border:1px solid var(--note-brand-soft-border);border-radius:1.15rem;padding:1.1rem 1.2rem;
  }
  .stopbang-main-result-title{font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;color:#3559b7;font-weight:700;margin-bottom:.4rem;}
  .stopbang-main-result-value{font-size:1.45rem;font-weight:900;line-height:1.15;color:var(--note-text);margin-bottom:.35rem;}
  .stopbang-main-result-note{font-size:.92rem;color:var(--note-muted);line-height:1.4;}
  .stopbang-summary-box{background:var(--note-brand-soft);border:1px solid var(--note-brand-soft-border);border-radius:1rem;padding:1rem;}
  .stopbang-footer-note{font-size:.84rem;color:var(--note-muted);text-align:center;}

  @media (max-width:760px){
    .stopbang-context-options{grid-template-columns:repeat(2,minmax(0,1fr));}
    .stopbang-context-options .choice-btn{min-height:80px;font-size:.88rem;}
  }
</style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="stopbang-shell note-shell px-1 px-md-0 py-0">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · TAMIZAJE PREOPERATORIO DE AOS</div>
          <h2>STOP-BANG Score</h2>
          <div class="note-hero-subtitle">Tamizaje simple de riesgo de apnea obstructiva del sueño y orientación perioperatoria práctica.</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
            <hr>
            <b>Fórmula / comentario:</b><br>
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
            <div class="section-title mb-3">A. Cuestionario STOP-Bang</div>

            <div class="stopbang-layout">
              <div class="note-input-group">
                <div class="stopbang-question-grid">
                  <?php
                  $preguntas = array(
                    array("id"=>"q1","grupo"=>"S · Snoring","texto"=>"¿Ronca fuerte?","detalle"=>"Más fuerte que hablar o lo suficientemente fuerte como para ser escuchado a través de una puerta cerrada."),
                    array("id"=>"q2","grupo"=>"T · Tiredness","texto"=>"¿Se siente frecuentemente cansado, fatigado o somnoliento durante el día?","detalle"=>"Incluye somnolencia diurna relevante o fatiga habitual no explicada."),
                    array("id"=>"q3","grupo"=>"O · Observed apnea","texto"=>"¿Alguien ha observado que deja de respirar durante el sueño?","detalle"=>"Pausas respiratorias, apneas presenciadas o respiración interrumpida durante el sueño."),
                    array("id"=>"q4","grupo"=>"P · Pressure","texto"=>"¿Tiene hipertensión arterial o recibe tratamiento para hipertensión?","detalle"=>"Diagnóstico conocido de HTA o uso de antihipertensivos."),
                    array("id"=>"q5","grupo"=>"B · BMI","texto"=>"¿IMC mayor de 35 kg/m²?","detalle"=>"Medida objetiva. Si no conoce el IMC, calcúlelo antes de marcar."),
                    array("id"=>"q6","grupo"=>"A · Age","texto"=>"¿Edad mayor de 50 años?","detalle"=>"Criterio positivo desde 51 años o más."),
                    array("id"=>"q7","grupo"=>"N · Neck","texto"=>"¿Circunferencia cervical mayor de 40 cm?","detalle"=>"Medir a nivel del cuello; criterio positivo si supera 40 cm."),
                    array("id"=>"q8","grupo"=>"G · Gender","texto"=>"¿Sexo masculino?","detalle"=>"Criterio demográfico de la escala original."),
                  );

                  foreach($preguntas as $p){
                    echo "
                    <div class='stopbang-question-card'>
                      <div class='stopbang-question-text'>{$p['grupo']}<br>{$p['texto']}</div>
                      <div class='stopbang-question-points'>{$p['detalle']} <strong>Si responde sí: +1 punto</strong></div>
                      <div class='stopbang-choice-inline'>
                        <div>
                          <input class='choice-check stopbang-trigger' type='radio' name='{$p['id']}' id='{$p['id']}_si' value='1'>
                          <label class='stopbang-yn-label stopbang-yn-yes' for='{$p['id']}_si'>
                            <span class='stopbang-yn-icon'><i class='fa-solid fa-check'></i></span>
                            <span>Sí</span>
                          </label>
                        </div>
                        <div>
                          <input class='choice-check stopbang-trigger' type='radio' name='{$p['id']}' id='{$p['id']}_no' value='0' checked>
                          <label class='stopbang-yn-label stopbang-yn-no' for='{$p['id']}_no'>
                            <span class='stopbang-yn-icon'><i class='fa-solid fa-xmark'></i></span>
                            <span>No</span>
                          </label>
                        </div>
                      </div>
                    </div>";
                  }
                  ?>
                </div>
              </div>

              <div class="stopbang-side-stack">
                <div class="note-input-group">
                  <div class="section-title mb-3">Contexto clínico</div>
                  <div class="stopbang-context-grid">
                    <div class="stopbang-context-block">
                      <label class="note-label">Contexto perioperatorio</label>
                      <div class="stopbang-context-options">
                        <div>
                          <input class="choice-check stopbang-trigger" type="radio" name="periopContext" id="context_ambulatory" value="standard" checked>
                          <label class="choice-btn" for="context_ambulatory">
                            <i class="fa-solid fa-user-doctor"></i>
                            Estándar
                            <small>cirugía habitual</small>
                          </label>
                        </div>
                        <div>
                          <input class="choice-check stopbang-trigger" type="radio" name="periopContext" id="context_high" value="high">
                          <label class="choice-btn" for="context_high">
                            <i class="fa-solid fa-lungs"></i>
                            Mayor cautela
                            <small>opioides, vía aérea, comorbilidad</small>
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="stopbang-context-block">
                      <label class="note-label">Diagnóstico/tratamiento conocido de AOS</label>
                      <div class="stopbang-context-options">
                        <div>
                          <input class="choice-check stopbang-trigger" type="radio" name="knownOsa" id="osa_no" value="no" checked>
                          <label class="choice-btn" for="osa_no">
                            <i class="fa-solid fa-circle-question"></i>
                            No conocido
                            <small>tamizaje</small>
                          </label>
                        </div>
                        <div>
                          <input class="choice-check stopbang-trigger" type="radio" name="knownOsa" id="osa_yes" value="yes">
                          <label class="choice-btn" for="osa_yes">
                            <i class="fa-solid fa-mask-ventilator"></i>
                            AOS conocida
                            <small>CPAP/BiPAP o estudio previo</small>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="note-warning">
                  <strong>Recordatorio clínico</strong><br>
                  <div class="small-note mt-2">
                    STOP-Bang es una herramienta de tamizaje. Un puntaje alto no confirma AOS y un puntaje bajo no reemplaza el juicio clínico si hay síntomas, hipoxemia, obesidad severa o antecedentes respiratorios relevantes.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">B. Tarjeta resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Complete el cuestionario para ver puntaje, categoría de riesgo y orientación perioperatoria.</div>
          <div class="note-result-grid-2 mt-2">
            <div class="note-result-card">
              <div class="note-result-card-label">Puntaje STOP-Bang</div>
              <div id="sumScore" class="note-result-card-value">0 / 8</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Categoría</div>
              <div id="sumCategory" class="note-result-card-value">Bajo riesgo</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Elementos STOP</div>
              <div id="sumStop" class="note-result-card-value">0 / 4</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Elementos Bang</div>
              <div id="sumBang" class="note-result-card-value">0 / 4</div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="section-title mb-3">C. Resultado principal</div>

            <div class="stopbang-main-result mb-3">
              <div class="stopbang-main-result-title">Interpretación principal</div>
              <div id="mainDecision" class="stopbang-main-result-value">Bajo riesgo de AOS por STOP-Bang</div>
              <div id="mainPlan" class="stopbang-main-result-note">Puntaje 0-2. Si no hay sospecha clínica adicional, continuar evaluación perioperatoria habitual.</div>
            </div>

            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Riesgo estimado</div>
                <div id="outRisk" class="note-result-card-value">Bajo</div>
                <div class="note-result-card-note">0-2 bajo, 3-4 intermedio, 5-8 alto.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Puntaje total</div>
                <div id="outScore" class="note-result-card-value">0 / 8</div>
                <div class="note-result-card-note">Cada criterio positivo suma 1 punto.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Lectura práctica</div>
                <div id="outPeriop" class="note-result-card-value">Manejo habitual</div>
                <div class="note-result-card-note">Debe integrarse con cirugía, opioides, vía aérea y comorbilidades.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Sospecha reforzada</div>
                <div id="outPattern" class="note-result-card-value">No</div>
                <div class="note-result-card-note">Ciertos patrones pueden reforzar cautela clínica.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="section-title mb-3">D. Interpretación clínica</div>

            <div id="riskBox" class="note-success mb-3">
              <strong id="riskTitle">Bajo riesgo</strong><br>
              <div id="riskText" class="small-note mt-2">Puntaje 0-2: baja probabilidad de AOS clínicamente significativa por STOP-Bang, si la historia clínica es concordante.</div>
            </div>

            <div class="note-warning mb-3">
              <strong>Qué significa en preoperatorio</strong><br>
              <div id="periopText" class="small-note mt-2">En bajo riesgo y sin sospecha clínica adicional, habitualmente basta manejo perioperatorio estándar.</div>
            </div>

            <div class="note-mint">
              <strong>Limitaciones / cautelas</strong><br>
              <div id="caveatText" class="small-note mt-2">No diagnostica AOS. Si el paciente ya tiene AOS, usa CPAP/BiPAP o tiene hipoxemia/síntomas marcados, el plan debe basarse en el cuadro clínico, no solo en el puntaje.</div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mb-3">
          <div class="note-teaching-title">E. Tips docentes</div>
          <div class="note-teaching-main">STOP-Bang sirve para decidir cuánto debes sospechar, no para diagnosticar</div>
          <div class="note-tips"><strong>Qué hacer:</strong> Si el puntaje es intermedio o alto, anticipa vía aérea potencialmente difícil, sensibilidad a opioides, eventos respiratorios en recuperación y necesidad de monitorización adecuada.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> Tratar el puntaje como polisomnografía. La escala es un tamizaje y debe integrarse con clínica, cirugía y comorbilidades.</div>
          <div class="note-tips mb-0"><strong>Error frecuente:</strong> Ignorar el CPAP del paciente. Si lo usa en casa, debe indicarse que lo lleve al hospital y considerar disponibilidad de soporte ventilatorio postoperatorio.</div>
        </div>

        <div class="stopbang-footer-note pb-3">
          Herramienta docente y de apoyo clínico. El resultado es orientativo y debe integrarse con síntomas, examen físico, riesgo quirúrgico, plan analgésico, vía aérea y condición respiratoria actual.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function yes(name){
    return Number(getSelected(name) || 0) === 1;
  }

  function updateStopBang(){
    let total = 0;
    for(let i = 1; i <= 8; i++){
      const val = Number(getSelected('q' + i) || 0);
      if(!Number.isNaN(val)) total += val;
    }

    const stop = ['q1','q2','q3','q4'].reduce(function(acc, key){ return acc + (yes(key) ? 1 : 0); }, 0);
    const bang = ['q5','q6','q7','q8'].reduce(function(acc, key){ return acc + (yes(key) ? 1 : 0); }, 0);
    const periopContext = getSelected('periopContext') || 'standard';
    const knownOsa = getSelected('knownOsa') || 'no';

    const reinforcedPattern = (stop >= 2 && (yes('q8') || yes('q5') || yes('q7'))) || total >= 5 || knownOsa === 'yes';

    let category = 'Bajo riesgo';
    let categoryShort = 'Bajo';
    let mainDecision = 'Bajo riesgo de AOS por STOP-Bang';
    let mainPlan = 'Puntaje 0-2. Si no hay sospecha clínica adicional, continuar evaluación perioperatoria habitual.';
    let periopRisk = 'Manejo habitual';
    let riskTitle = 'Bajo riesgo';
    let riskText = 'Puntaje 0-2: baja probabilidad de AOS clínicamente significativa por STOP-Bang, si la historia clínica es concordante.';
    let periopText = 'En bajo riesgo y sin sospecha clínica adicional, habitualmente basta manejo perioperatorio estándar.';
    let caveatText = 'No diagnostica AOS. Si el paciente ya tiene AOS, usa CPAP/BiPAP o tiene hipoxemia/síntomas marcados, el plan debe basarse en el cuadro clínico, no solo en el puntaje.';
    let riskClass = 'note-success mb-3';

    if(knownOsa === 'yes'){
      category = total >= 5 ? 'Alto riesgo / AOS conocida' : (total >= 3 ? 'Riesgo intermedio / AOS conocida' : 'AOS conocida');
      categoryShort = 'AOS conocida';
      mainDecision = 'AOS conocida: planificar manejo perioperatorio específico';
      mainPlan = 'El diagnóstico o tratamiento previo pesa más que el tamizaje. Verifica severidad, adherencia a CPAP/BiPAP, eventos respiratorios previos y plan de monitorización.';
      periopRisk = 'Precauciones por AOS';
      riskTitle = 'Paciente con AOS conocida';
      riskText = 'STOP-Bang puede registrar el perfil de riesgo, pero no debe usarse para descartar un diagnóstico ya establecido.';
      periopText = 'Solicita que lleve su CPAP/BiPAP si lo usa, minimiza opioides cuando sea posible, considera analgesia multimodal y define monitorización postoperatoria según cirugía y comorbilidades.';
      caveatText = 'El puntaje puede ser bajo en pacientes tratados o con fenotipos no clásicos. La conducta debe basarse en el diagnóstico conocido y la situación clínica actual.';
      riskClass = 'note-danger mb-3';
    } else if(total >= 5){
      category = 'Alto riesgo';
      categoryShort = 'Alto';
      mainDecision = 'Alto riesgo de AOS por STOP-Bang';
      mainPlan = 'Puntaje 5-8. Anticipa eventos respiratorios perioperatorios, sensibilidad a sedantes/opioides y posible necesidad de monitorización reforzada.';
      periopRisk = 'Precauciones reforzadas';
      riskTitle = 'Alto riesgo de AOS';
      riskText = 'Puntaje 5-8: alta probabilidad de apnea obstructiva del sueño. El resultado no confirma diagnóstico, pero sí justifica mayor cautela clínica.';
      periopText = 'Considera estrategia ahorradora de opioides, extubación completamente despierto cuando corresponda, vigilancia en recuperación y disponibilidad de soporte con presión positiva si el contexto lo exige.';
      caveatText = 'La decisión de hospitalizar, monitorizar o estudiar depende del tipo de cirugía, eventos respiratorios, comorbilidades, requerimiento de opioides y recursos disponibles.';
      riskClass = 'note-danger mb-3';
    } else if(total >= 3){
      category = 'Riesgo intermedio';
      categoryShort = 'Intermedio';
      mainDecision = 'Riesgo intermedio de AOS por STOP-Bang';
      mainPlan = 'Puntaje 3-4. Integra patrón de respuestas, vía aérea, obesidad, requerimiento de opioides y riesgo quirúrgico.';
      periopRisk = reinforcedPattern || periopContext === 'high' ? 'Cautela aumentada' : 'Cautela clínica';
      riskTitle = 'Riesgo intermedio';
      riskText = 'Puntaje 3-4: sospecha moderada. El riesgo práctico aumenta si se combinan síntomas STOP con sexo masculino, IMC elevado o cuello aumentado.';
      periopText = periopContext === 'high'
        ? 'Por el contexto de mayor cautela, trata este resultado como clínicamente relevante: optimiza analgesia, sedación y monitorización respiratoria.'
        : 'En cirugía habitual, revisa factores adicionales antes de escalar medidas. En cirugía mayor o con opioides relevantes, aumenta la cautela.';
      caveatText = 'Un puntaje intermedio puede comportarse como relevante si existen obesidad severa, cuello ancho, apneas presenciadas, hipoxemia o historia clínica sugerente.';
      riskClass = 'note-warning mb-3';
    } else {
      if(periopContext === 'high' || reinforcedPattern){
        periopRisk = 'Manejo habitual con cautela';
        mainPlan = 'Puntaje 0-2. Aunque es bajo riesgo por escala, el contexto clínico seleccionado exige no relajar la vigilancia.';
        periopText = 'Con bajo puntaje, el manejo suele ser estándar; sin embargo, si habrá opioides, sedación profunda o cirugía de mayor riesgo respiratorio, mantén vigilancia proporcional.';
      }
    }

    CNS.safeSetText('sumScore', total + ' / 8');
    CNS.safeSetText('sumCategory', category);
    CNS.safeSetText('sumStop', stop + ' / 4');
    CNS.safeSetText('sumBang', bang + ' / 4');
    CNS.safeSetText('summaryNarrative', 'STOP-Bang ' + total + '/8: ' + category.toLowerCase() + '. STOP ' + stop + '/4; Bang ' + bang + '/4. Contexto: ' + (periopContext === 'high' ? 'mayor cautela perioperatoria' : 'estándar') + '.');

    CNS.safeSetText('mainDecision', mainDecision);
    CNS.safeSetText('mainPlan', mainPlan);
    CNS.safeSetText('outRisk', categoryShort);
    CNS.safeSetText('outScore', total + ' / 8');
    CNS.safeSetText('outPeriop', periopRisk);
    CNS.safeSetText('outPattern', reinforcedPattern ? 'Sí' : 'No');
    CNS.safeSetText('riskTitle', riskTitle);
    CNS.safeSetText('riskText', riskText);
    CNS.safeSetText('periopText', periopText);
    CNS.safeSetText('caveatText', caveatText);
    document.getElementById('riskBox').className = riskClass;
  }

  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.stopbang-trigger').forEach(function(el){
      el.addEventListener('change', updateStopBang);
      el.addEventListener('input', updateStopBang);
    });
    updateStopBang();
  });
})();
</script>

<?php require("../footer.php"); ?>
