<?php
$titulo_pagina = "DASI";
$navbar_titulo = "Apuntes";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para estimar capacidad funcional con el cuestionario DASI en español adaptado a población chilena. Permite obtener puntaje total, VO₂ estimado, METs estimados y una orientación práctica para evaluación perioperatoria, especialmente en cirugía no cardíaca.";
$formula = "Puntaje DASI = suma de respuestas positivas. VO₂ estimado = (DASI × 0,43) + 9,6. METs estimados = VO₂ / 3,5. En evaluación perioperatoria, una capacidad funcional &lt; 4 METs sugiere reserva funcional reducida y obliga a interpretar el contexto clínico y quirúrgico con mayor cautela.";
$referencias = array(
  "Hlatky MA, Boineau RE, Higginbotham MB, et al. A brief self-administered questionnaire to determine functional capacity (The Duke Activity Status Index). Am J Cardiol. 1989;64:651-654.",
  "Varleta P, Von Chrismar M, Manzano G, et al. Evaluación y utilidad del cuestionario DASI para la estimación de capacidad funcional en población chilena. Rev Chil Cardiol. 2021;40(2):104-113.",
  "Galleguillos G, Cecioni G, Pereira F, Álvarez F. Evaluación del riesgo cardíaco previo a la cirugía no cardíaca. Rev Chil Anest. 2022;51(5):510-520.",
  "Wijeysundera DN, Beattie WS, Hillis GS, et al. Integration of the Duke Activity Status Index into preoperative risk evaluation: a multicenter prospective cohort study. Br J Anaesth. 2020;124(3):261-270.",
  "Kristensen SD, Knuuti J, Saraste A, et al. 2014 ESC/ESA Guidelines on non-cardiac surgery: cardiovascular assessment and management. Eur Heart J. 2014;35:2383-2431."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<style>
  .dasi-shell{max-width:1080px;margin:0 auto;}
  .dasi-badge{
    display:inline-flex;align-items:center;justify-content:center;
    min-width:74px;padding:.38rem .78rem;border-radius:999px;
    background:#eef3ff;color:#3559b7;font-weight:800;font-size:.92rem;
  }
  .dasi-layout{display:grid;grid-template-columns:1.2fr .8fr;gap:1rem;}
  .dasi-question-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
  .dasi-question-card{
    border:1px solid var(--note-line);background:#fff;border-radius:1rem;padding:.9rem;
    box-shadow:0 4px 14px rgba(15,23,42,.04);
  }
  .dasi-question-text{font-size:.92rem;font-weight:700;color:#3559b7;line-height:1.35;margin-bottom:.7rem;}
  .dasi-question-points{font-size:.78rem;color:var(--note-muted);margin-bottom:.55rem;}
  .dasi-choice-inline{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.5rem;}
  .dasi-yn-label{
    display:flex;align-items:center;justify-content:center;gap:.45rem;
    min-height:58px;border:1px solid #dfe7f2;background:#fff;border-radius:.85rem;
    padding:.55rem .45rem;font-weight:700;color:#1f2a37;cursor:pointer;transition:.15s ease;
    box-shadow:0 4px 14px rgba(0,0,0,.04);font-size:.92rem;
  }
  .dasi-yn-icon{
    width:26px;height:26px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;
    font-size:.9rem;font-weight:800;flex:0 0 auto;
  }
  .dasi-yn-yes .dasi-yn-icon{background:#eaf7ef;color:#1f9d55;border:1px solid #bfe4cb;}
  .dasi-yn-no .dasi-yn-icon{background:#fff1ef;color:#d92d20;border:1px solid #efc2bb;}
  .choice-check:checked + .dasi-yn-label{
    background:#eef3ff;border-color:#9fb9f8;color:#27458f;
    box-shadow:0 0 0 3px rgba(47,128,237,.12), 0 8px 18px rgba(0,0,0,.06);
  }
  .dasi-side-stack{display:grid;gap:1rem;}
  .dasi-context-grid{display:grid;gap:.85rem;}
  .dasi-context-block{border:1px solid var(--note-line);border-radius:1rem;background:var(--note-soft);padding:1rem;}
  .dasi-context-options{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.6rem;}
  .dasi-main-result{
    background:linear-gradient(180deg,var(--note-brand-soft) 0%, #f7faff 100%);
    border:1px solid var(--note-brand-soft-border);border-radius:1.15rem;padding:1.1rem 1.2rem;
  }
  .dasi-main-result-title{font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;color:#3559b7;font-weight:700;margin-bottom:.4rem;}
  .dasi-main-result-value{font-size:1.45rem;font-weight:900;line-height:1.15;color:var(--note-text);margin-bottom:.35rem;}
  .dasi-main-result-note{font-size:.92rem;color:var(--note-muted);line-height:1.4;}
  .dasi-summary-box{background:var(--note-brand-soft);border:1px solid var(--note-brand-soft-border);border-radius:1rem;padding:1rem;}
  .dasi-footer-note{font-size:.84rem;color:var(--note-muted);text-align:center;}

  @media (max-width:980px){
    .dasi-layout{grid-template-columns:1fr;}
  }
  @media (max-width:760px){
    .dasi-question-grid,.dasi-context-options{grid-template-columns:1fr;}
  }
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="dasi-shell note-shell px-1 px-md-0 py-0">

        <div class="note-hero mb-3">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="note-hero-kicker">APP CLÍNICA · EVALUACIÓN FUNCIONAL PERIOPERATORIA</div>
              <h2>Duke Activity Status Index</h2>
              <div class="note-hero-subtitle">Capacidad funcional estimada en METs y orientación perioperatoria práctica.</div>
            </div>
            <span class="dasi-badge">METs</span>
          </div>
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
            <div class="section-title mb-3">A. Cuestionario DASI</div>

            <div class="dasi-layout">
              <div class="note-input-group">
                <div class="dasi-question-grid">
                  <?php
                  $preguntas = array(
                    array("id"=>"q1","texto"=>"¿Puede Usted realizar sus actividades de autocuidado, tales como alimentarse, vestirse, bañarse, o usar el baño?","pts"=>"2.75"),
                    array("id"=>"q2","texto"=>"¿Puede Usted caminar dentro de su casa y alrededor de ésta?","pts"=>"1.75"),
                    array("id"=>"q3","texto"=>"¿Puede Usted caminar una o dos cuadras, sin pendiente?","pts"=>"2.75"),
                    array("id"=>"q4","texto"=>"¿Puede subir un tramo de escalones (ej: dos pisos de escaleras) sin detenerse?","pts"=>"5.50"),
                    array("id"=>"q5","texto"=>"¿Puede correr una pequeña distancia?","pts"=>"8.00"),
                    array("id"=>"q6","texto"=>"¿Puede realizar trabajos livianos en su casa tales como sacudir el polvo, o lavar platos?","pts"=>"2.70"),
                    array("id"=>"q7","texto"=>"¿Puede realizar trabajo moderado en su casa tal como pasar la aspiradora, barrer los pisos, o acarrear comestibles desde una tienda o mercado?","pts"=>"3.50"),
                    array("id"=>"q8","texto"=>"¿Puede realizar trabajo pesado en su casa tal como el fregado de piso, o levantar o desplazar muebles pesados?","pts"=>"8.00"),
                    array("id"=>"q9","texto"=>"¿Puede hacer trabajos en el jardín tales como rastrillar las hojas, desmalezar o empujar una cortadora de pasto?","pts"=>"4.50"),
                    array("id"=>"q10","texto"=>"¿Puede tener relaciones sexuales?","pts"=>"5.25"),
                    array("id"=>"q11","texto"=>"¿Puede participar en actividades recreacionales físicas de intensidad moderada como baile entretenido, zumba, jugar tenis (en dobles), jugar golf o lanzar pelotas?","pts"=>"6.00"),
                    array("id"=>"q12","texto"=>"¿Puede participar en deportes intensos como natación, tenis individual, fútbol, baloncesto o esquí?","pts"=>"7.50")
                  );

                  foreach($preguntas as $p){
                    echo "
                    <div class='dasi-question-card'>
                      <div class='dasi-question-text'>{$p['texto']}</div>
                      <div class='dasi-question-points'>Puntaje si responde sí: <strong>{$p['pts']}</strong></div>
                      <div class='dasi-choice-inline'>
                        <div>
                          <input class='choice-check dasi-trigger' type='radio' name='{$p['id']}' id='{$p['id']}_si' value='{$p['pts']}'>
                          <label class='dasi-yn-label dasi-yn-yes' for='{$p['id']}_si'>
                            <span class='dasi-yn-icon'><i class='fa-solid fa-check'></i></span>
                            <span>Sí</span>
                          </label>
                        </div>
                        <div>
                          <input class='choice-check dasi-trigger' type='radio' name='{$p['id']}' id='{$p['id']}_no' value='0' checked>
                          <label class='dasi-yn-label dasi-yn-no' for='{$p['id']}_no'>
                            <span class='dasi-yn-icon'><i class='fa-solid fa-xmark'></i></span>
                            <span>No</span>
                          </label>
                        </div>
                      </div>
                    </div>";
                  }
                  ?>
                </div>
              </div>

              <div class="dasi-side-stack">
                <div class="note-input-group">
                  <div class="section-title mb-3">Contexto clínico</div>
                  <div class="dasi-context-grid">
                    <div class="dasi-context-block">
                      <label class="note-label">Contexto quirúrgico</label>
                      <div class="dasi-context-options">
                        <div>
                          <input class="choice-check dasi-trigger" type="radio" name="surgeryRisk" id="risk_low" value="low" checked>
                          <label class="choice-btn" for="risk_low">
                            <i class="fa-solid fa-user-doctor"></i>
                            Bajo / intermedio
                            <small>Cx habitual</small>
                          </label>
                        </div>
                        <div>
                          <input class="choice-check dasi-trigger" type="radio" name="surgeryRisk" id="risk_high" value="high">
                          <label class="choice-btn" for="risk_high">
                            <i class="fa-solid fa-heart-circle-exclamation"></i>
                            Alto riesgo
                            <small>Mayor estrés CV</small>
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="dasi-context-block">
                      <label class="note-label">Síntomas o datos de alarma cardiovasculares</label>
                      <div class="dasi-context-options">
                        <div>
                          <input class="choice-check dasi-trigger" type="radio" name="activeCardiac" id="active_no" value="no" checked>
                          <label class="choice-btn" for="active_no">
                            <i class="fa-solid fa-shield-heart"></i>
                            No
                            <small>sin alarma activa</small>
                          </label>
                        </div>
                        <div>
                          <input class="choice-check dasi-trigger" type="radio" name="activeCardiac" id="active_yes" value="yes">
                          <label class="choice-btn" for="active_yes">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            Sí
                            <small>angina, IC, arritmia, etc.</small>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="note-warning">
                  <strong>Recordatorio clínico</strong><br>
                  <div class="small-note mt-2">
                    El DASI orienta la capacidad funcional, pero no reemplaza la evaluación clínica integral. Si existen síntomas cardiovasculares activos o una condición inestable, la conducta no debe depender solo del puntaje.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">B. Tarjeta resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Complete el cuestionario para ver puntaje, VO₂ estimado, METs y lectura funcional perioperatoria.</div>
          <div class="note-summary-grid-2 mt-3">
            <div class="note-summary-item">
              <div class="note-summary-k">Puntaje DASI</div>
              <div id="sumDasi" class="note-summary-v">0</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">VO₂ estimado</div>
              <div id="sumVo2" class="note-summary-v">0 ml/kg/min</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">METs estimados</div>
              <div id="sumMets" class="note-summary-v">0</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Capacidad funcional</div>
              <div id="sumCategory" class="note-summary-v">No calculada</div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="section-title mb-3">C. Resultado principal</div>

            <div class="dasi-main-result mb-3">
              <div class="dasi-main-result-title">Interpretación principal</div>
              <div id="mainDecision" class="dasi-main-result-value">Capacidad funcional no calculada</div>
              <div id="mainPlan" class="dasi-main-result-note">Complete el cuestionario para obtener una orientación funcional y perioperatoria.</div>
            </div>

            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Clasificación funcional</div>
                <div id="outClass" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Umbrales clásicos de capacidad funcional en METs.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Riesgo perioperatorio práctico</div>
                <div id="outPeriop" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Importa especialmente si el paciente está por debajo de 4 METs.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">VO₂ estimado</div>
                <div id="outVo2" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Orientación fisiológica derivada del puntaje DASI.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">METs estimados</div>
                <div id="outMets" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Cálculo directo desde VO₂ estimado.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="section-title mb-3">D. Interpretación clínica</div>

            <div id="riskBox" class="note-mint mb-3">
              <strong id="riskTitle">Lectura clínica</strong><br>
              <div id="riskText" class="small-note mt-2">Responda el cuestionario para obtener una estimación funcional y una orientación perioperatoria.</div>
            </div>

            <div class="note-warning mb-3">
              <strong>Qué significa en preoperatorio</strong><br>
              <div id="periopText" class="small-note mt-2">-</div>
            </div>

            <div class="note-mint">
              <strong>Limitaciones / cautelas</strong><br>
              <div id="caveatText" class="small-note mt-2">-</div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mb-3">
          <div class="note-teaching-title">E. Tips docentes</div>
          <div class="note-teaching-main">Interpreta el DASI como herramienta, no como veredicto</div>
          <div class="note-tips"><strong>Qué hacer:</strong> Usa el resultado para estimar si la reserva funcional parece adecuada, limitada o claramente reducida, e intégralo con tipo de cirugía y estabilidad clínica.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> Dar por seguro que un METs aceptable descarta cardiopatía activa o que un DASI bajo equivale por sí solo a enfermedad cardíaca significativa.</div>
          <div class="note-tips mb-0"><strong>Error frecuente:</strong> Quedarse solo con el número y no considerar síntomas, historia discordante o limitaciones en la confiabilidad de las respuestas.</div>
        </div>

        <div class="dasi-footer-note pb-3">
          Herramienta docente y de apoyo clínico. El resultado es orientativo y debe integrarse con síntomas, tipo de cirugía, antecedentes cardiovasculares y condición clínica actual.
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

  function updateDasi(){
    let total = 0;
    for(let i = 1; i <= 12; i++){
      const val = Number(getSelected('q' + i) || 0);
      if(!Number.isNaN(val)) total += val;
    }

    const vo2 = (total * 0.43) + 9.6;
    const mets = vo2 / 3.5;
    const surgeryRisk = getSelected('surgeryRisk') || 'low';
    const activeCardiac = getSelected('activeCardiac') || 'no';

    let category = 'No calculada';
    if(mets > 10) category = 'Excelente';
    else if(mets >= 7) category = 'Buena';
    else if(mets >= 4) category = 'Moderada';
    else if(mets > 0) category = 'Deficiente';

    CNS.safeSetText('sumDasi', total > 0 ? CNS.formatNumber(total, 2) : '0');
    CNS.safeSetText('sumVo2', total > 0 ? CNS.formatNumber(vo2, 1) + ' ml/kg/min' : '0 ml/kg/min');
    CNS.safeSetText('sumMets', total > 0 ? CNS.formatNumber(mets, 1) : '0');
    CNS.safeSetText('sumCategory', category);

    if(total <= 0){
      CNS.safeSetText('summaryNarrative', 'Complete el cuestionario para ver puntaje, VO₂ estimado, METs y lectura funcional perioperatoria.');
      CNS.safeSetText('mainDecision', 'Capacidad funcional no calculada');
      CNS.safeSetText('mainPlan', 'Complete el cuestionario para obtener una orientación funcional y perioperatoria.');
      CNS.safeSetText('outClass', '-');
      CNS.safeSetText('outPeriop', '-');
      CNS.safeSetText('outVo2', '-');
      CNS.safeSetText('outMets', '-');
      CNS.safeSetText('riskTitle', 'Lectura clínica');
      CNS.safeSetText('riskText', 'Responda el cuestionario para obtener una estimación funcional y una orientación perioperatoria.');
      CNS.safeSetText('periopText', '-');
      CNS.safeSetText('caveatText', '-');
      document.getElementById('riskBox').className = 'note-mint mb-3';
      return;
    }

    let mainDecision = '';
    let mainPlan = '';
    let periopRisk = '';
    let riskTitle = '';
    let riskText = '';
    let periopText = '';
    let caveatText = '';
    let riskClass = 'note-success mb-3';

    if(activeCardiac === 'yes'){
      mainDecision = 'Síntomas o condición cardiovascular activa predominan sobre el DASI';
      mainPlan = 'No confíes solo en los METs estimados. Prioriza evaluación clínica, optimización y eventual estudio adicional según contexto.';
      periopRisk = 'Evaluación clínica prioritaria';
      riskTitle = 'Alarma cardiovascular activa';
      riskText = 'Si hay angina inestable, insuficiencia cardíaca descompensada, arritmia significativa o valvulopatía severa, el algoritmo funcional no basta.';
      periopText = 'Aunque el DASI sea aceptable, la presencia de síntomas o hallazgos activos puede obligar a diferir, optimizar o estudiar más antes de cirugía electiva.';
      caveatText = 'El cuestionario estima función, no estabilidad cardiovascular. Un paciente puede sumar puntos y aun así ser clínicamente de alto riesgo.';
      riskClass = 'note-danger mb-3';
    } else if(mets < 4){
      mainDecision = 'Capacidad funcional reducida';
      mainPlan = surgeryRisk === 'high'
        ? 'Paciente bajo 4 METs + cirugía de alto riesgo. Interprétalo con cautela y considera optimización, evaluación adicional y plan perioperatorio reforzado.'
        : 'Paciente bajo 4 METs. Integra síntomas, comorbilidades y riesgo quirúrgico antes de decidir conducta adicional.';
      periopRisk = 'Mayor riesgo funcional';
      riskTitle = 'Capacidad funcional deficiente';
      riskText = 'Un valor estimado menor de 4 METs sugiere reserva funcional limitada y se asocia a mayor probabilidad de eventos perioperatorios.';
      periopText = 'En cirugía no cardíaca, un paciente incapaz de sostener al menos 4 METs merece una evaluación más cuidadosa del riesgo cardiovascular, especialmente si el procedimiento es de mayor complejidad.';
      caveatText = 'Un DASI bajo no diagnostica cardiopatía, pero sí debe hacerte más conservador en la interpretación perioperatoria.';
      riskClass = 'note-danger mb-3';
    } else if(mets < 7){
      mainDecision = 'Capacidad funcional aceptable, pero no alta';
      mainPlan = 'METs entre 4 y 6,9. Habitualmente permite continuar evaluación estándar si el paciente está clínicamente estable.';
      periopRisk = 'Riesgo funcional intermedio';
      riskTitle = 'Capacidad funcional moderada';
      riskText = 'Sobre 4 METs suele ser suficiente para muchas decisiones perioperatorias, pero no equivale a riesgo cero.';
      periopText = 'Si no hay síntomas cardiovasculares activos y la cirugía no es de alto riesgo, la capacidad funcional suele ser tranquilizadora. Si el resto del perfil es adverso, integra más variables.';
      caveatText = 'El resultado es una estimación indirecta. Si la historia clínica es discordante, pesa más la clínica.';
      riskClass = 'note-warning mb-3';
    } else if(mets <= 10){
      mainDecision = 'Buena capacidad funcional';
      mainPlan = 'METs entre 7 y 10. En ausencia de síntomas activos, suele ser un hallazgo favorable para el perioperatorio.';
      periopRisk = 'Riesgo funcional bajo';
      riskTitle = 'Capacidad funcional buena';
      riskText = 'El paciente probablemente tolera actividades aeróbicas habituales sin gran limitación y su reserva funcional parece adecuada.';
      periopText = 'En contexto estable, una capacidad funcional buena reduce la probabilidad de complicaciones cardiovasculares perioperatorias comparado con pacientes de mala reserva.';
      caveatText = 'Un buen DASI no reemplaza la pesquisa de cardiopatía activa ni la consideración del riesgo propio de la cirugía.';
      riskClass = 'note-success mb-3';
    } else {
      mainDecision = 'Excelente capacidad funcional';
      mainPlan = 'METs sobre 10. Hallazgo muy tranquilizador si el paciente está clínicamente estable.';
      periopRisk = 'Muy buen perfil funcional';
      riskTitle = 'Capacidad funcional excelente';
      riskText = 'El paciente reporta una reserva funcional alta, compatible con buena aptitud aeróbica en actividades de la vida diaria y ejercicio más exigente.';
      periopText = 'En ausencia de síntomas o enfermedad activa, este perfil suele apoyar la continuación del manejo perioperatorio habitual sin escalar estudios solo por función.';
      caveatText = 'Siempre recuerda que algunos pacientes sobreestiman su capacidad real; si la historia no convence, no te quedes solo con el cuestionario.';
      riskClass = 'note-success mb-3';
    }

    CNS.safeSetText('summaryNarrative', 'Puntaje DASI ' + CNS.formatNumber(total, 2) + '; VO₂ estimado ' + CNS.formatNumber(vo2, 1) + ' ml/kg/min; ' + CNS.formatNumber(mets, 1) + ' METs. Contexto quirúrgico ' + (surgeryRisk === 'high' ? 'alto riesgo' : 'bajo/intermedio') + '.');
    CNS.safeSetText('mainDecision', mainDecision);
    CNS.safeSetText('mainPlan', mainPlan);
    CNS.safeSetText('outClass', category + ' (' + CNS.formatNumber(mets, 1) + ' METs)');
    CNS.safeSetText('outPeriop', periopRisk);
    CNS.safeSetText('outVo2', CNS.formatNumber(vo2, 1) + ' ml/kg/min');
    CNS.safeSetText('outMets', CNS.formatNumber(mets, 1) + ' METs');
    CNS.safeSetText('riskTitle', riskTitle);
    CNS.safeSetText('riskText', riskText);
    CNS.safeSetText('periopText', periopText);
    CNS.safeSetText('caveatText', caveatText);
    document.getElementById('riskBox').className = riskClass;
  }

  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.dasi-trigger').forEach(function(el){
      el.addEventListener('change', updateDasi);
      el.addEventListener('input', updateDasi);
    });
    updateDasi();
  });
})();
</script>

<?php require("../footer.php"); ?>
