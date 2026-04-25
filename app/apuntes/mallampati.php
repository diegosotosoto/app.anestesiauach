<?php
$titulo_pagina = "Mallampati";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "El score de Mallampati es una evaluación clínica simple de estructuras orofaríngeas visibles con el paciente despierto. Sirve como parte del tamizaje preoperatorio de vía aérea, pero su rendimiento aislado para predecir intubación difícil es limitado.";
$formula = "Evaluación correcta: paciente sentado, cabeza neutra, boca máxima abierta, lengua protruyente relajada, sin fonación. No debe interpretarse como predictor único de vía aérea difícil.";
$referencias = array(
  "Mallampati SR, Gatt SP, Gugino LD, et al. A clinical sign to predict difficult tracheal intubation: a prospective study. Can Anaesth Soc J. 1985.",
  "Samsoon GL, Young JR. Difficult tracheal intubation: a retrospective study. Anaesthesia. 1987.",
  "American Society of Anesthesiologists Task Force on Management of the Difficult Airway. Practice Guidelines for Management of the Difficult Airway. Anesthesiology. 2022.",
  "Lundstrøm LH, Vester-Andersen M, Møller AM, et al. Poor prognostic value of the modified Mallampati score: a meta-analysis involving 177 088 patients. Br J Anaesth. 2011."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=2">
<script src="js/clinical-note-system.js?v=2"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          :root{
            --mp-grade-1:#e8f7f2;
            --mp-grade-2:#fff9e8;
            --mp-grade-3:#fff0e1;
            --mp-grade-4:#fdebec;
          }

          .mp-grade-grid{
            display:grid;
            grid-template-columns:repeat(4,minmax(0,1fr));
            gap:.65rem;
          }

          .mp-grade-option{min-width:0;}

          .mp-grade-option .note-option{
            width:100%;
            min-height:68px;
            justify-content:center;
            align-items:center;
            text-align:center;
            padding:.55rem .5rem;
          }

          .mp-grade-option .note-option small{
            font-size:.7rem;
            line-height:1.1;
          }

          .mp-grade-1{background:var(--mp-grade-1);}
          .mp-grade-2{background:var(--mp-grade-2);}
          .mp-grade-3{background:var(--mp-grade-3);}
          .mp-grade-4{background:var(--mp-grade-4);}

          .mp-main-grid{
            display:grid;
            grid-template-columns:1.05fr .95fr;
            gap:1rem;
            align-items:start;
          }

          .mp-image-shell{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            overflow:hidden;
          }

          .mp-image-shell img{
            width:100%;
            display:block;
            object-fit:cover;
          }

          .mp-grade-panel{
            border-radius:1rem;
            padding:1rem;
            border:1px solid transparent;
          }

          .mp-grade-panel.grade-1{background:#e9f8ef;border-color:#b7e4c7;}
          .mp-grade-panel.grade-2{background:#fff8db;border-color:#f4d35e;}
          .mp-grade-panel.grade-3{background:#fff0e1;border-color:#f7b267;}
          .mp-grade-panel.grade-4{background:#fdebec;border-color:#f2a7b1;}

          .mp-meta-stack{display:grid;gap:.8rem;}

          .mp-summary-box{
            border:0;
          }

          .mp-summary-box .note-summary-box-text{margin-bottom:.5rem;}

          .mp-reference-grid{display:grid;gap:.75rem;}

          .mp-reference-card{
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:.9rem 1rem;
            background:#fff;
          }

          .mp-reference-card b{
            display:block;
            margin-bottom:.15rem;
          }

          .mp-technique-list{
            display:grid;
            gap:.75rem;
          }

          .mp-technique-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .mp-technique-mark{
            flex:0 0 auto;
            width:30px;
            height:30px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            background:#3559b7;
            margin-top:.08rem;
          }

          .mp-technique-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .mp-technique-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          @media (max-width:768px){
            .mp-grade-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
            .mp-main-grid{grid-template-columns:1fr;}
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · VÍA AÉREA · EVALUACIÓN PREOPERATORIA</div>
          <h2>Score de Mallampati</h2>
          <div class="note-hero-subtitle">Clasifica la visualización orofaríngea y úsala como parte de una evaluación integrada de vía aérea, nunca como predictor aislado.</div>
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
            <div class="note-section-label">Selecciona el grado</div>
            <div class="mp-grade-grid">
              <div class="mp-grade-option">
                <input class="note-check mp-trigger" type="radio" name="mpgrade" id="mp1" value="1" checked>
                <label class="note-option mp-grade-1" for="mp1">
                  <span>Clase I</span>
                  <small>Úvula completa</small>
                </label>
              </div>
              <div class="mp-grade-option">
                <input class="note-check mp-trigger" type="radio" name="mpgrade" id="mp2" value="2">
                <label class="note-option mp-grade-2" for="mp2">
                  <span>Clase II</span>
                  <small>Úvula parcial</small>
                </label>
              </div>
              <div class="mp-grade-option">
                <input class="note-check mp-trigger" type="radio" name="mpgrade" id="mp3" value="3">
                <label class="note-option mp-grade-3" for="mp3">
                  <span>Clase III</span>
                  <small>Base de úvula</small>
                </label>
              </div>
              <div class="mp-grade-option">
                <input class="note-check mp-trigger" type="radio" name="mpgrade" id="mp4" value="4">
                <label class="note-option mp-grade-4" for="mp4">
                  <span>Clase IV</span>
                  <small>Solo paladar duro</small>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Resultado principal</div>
            <div id="gradePanel" class="mp-grade-panel grade-1">
              <div class="mp-main-grid">
                <div>
                  <div class="mp-image-shell">
                    <img id="mpImage" src="img_apuntes/malampatti-scale.png" alt="Score de Mallampati">
                  </div>
                  <div id="summaryBox" class="note-summary-box mp-summary-box mt-3 mb-0" style="background:#e9f8ef;border-color:#b7e4c7;">
                    <div class="note-summary-box-title">Resumen</div>
                    <div id="summaryNarrative" class="note-summary-box-text">Mallampati I: paladar blando, úvula completa y pilares visibles; hallazgo orofaríngeo favorable.</div>
                    <div class="note-summary-grid-2">
                      <div class="note-summary-item">
                        <div class="note-summary-k">Clase seleccionada</div>
                        <div id="summaryGrade" class="note-summary-v">Clase I</div>
                      </div>
                      <div class="note-summary-item">
                        <div class="note-summary-k">Conducta</div>
                        <div id="summaryAction" class="note-summary-v">Integrar con el resto de la vía aérea</div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mp-meta-stack">
                  <div class="note-meta-card">
                    <div class="note-meta-label">Perla inmediata</div>
                    <div id="mpPearl" class="note-meta-value">Registra técnica correcta y combínalo con DTM, apertura oral, movilidad cervical y antecedentes.</div>
                  </div>

                  <div class="note-meta-card">
                    <div class="note-meta-label">Qué no concluye</div>
                    <div class="note-muted">No predice por sí solo intubación difícil ni reemplaza una evaluación completa de vía aérea.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-interpretation mb-3">
          <div class="note-interpretation-label">Significado clínico</div>
          <div id="interpMain" class="note-interpretation-main">Mallampati es un dato de screening, no una sentencia sobre la intubación.</div>
          <div id="interpSoft" class="note-interpretation-soft">Un Mallampati alto aumenta la alerta; un Mallampati bajo no descarta dificultad. Debe integrarse con apertura oral, DTM, movilidad cervical, obesidad, barba, OSA y antecedentes.</div>
        </div>

        <div class="note-warning mb-3">
          <div class="note-card-title">Advertencia visible</div>
          <div id="warningText">Mallampati aislado tiene valor predictivo limitado. No lo uses como único criterio para decidir estrategia de vía aérea.</div>
        </div>

        <div class="section-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Técnica correcta</div>
            <div class="mp-technique-list">
              <div class="mp-technique-item">
                <div class="mp-technique-mark"><i class="fa-solid fa-chair"></i></div>
                <div>
                  <div class="mp-technique-title">Paciente sentado, cabeza neutra</div>
                  <p class="mp-technique-note">Evaluarlo en supino puede sobreestimar la dificultad y reducir la validez del examen.</p>
                </div>
              </div>
              <div class="mp-technique-item">
                <div class="mp-technique-mark"><i class="fa-solid fa-face-smile"></i></div>
                <div>
                  <div class="mp-technique-title">Boca máxima abierta, lengua protruyente</div>
                  <p class="mp-technique-note">La lengua debe estar relajada y sin ayuda del examinador.</p>
                </div>
              </div>
              <div class="mp-technique-item">
                <div class="mp-technique-mark"><i class="fa-solid fa-volume-xmark"></i></div>
                <div>
                  <div class="mp-technique-title">Sin fonación</div>
                  <p class="mp-technique-note">Pedir “aaah” eleva estructuras y puede mejorar artificialmente la visualización.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Resumen rápido por clases</div>
            <div class="mp-reference-grid">
              <div class="mp-reference-card" style="background:#e9f8ef;border-color:#b7e4c7;">
                <b>Clase I</b>
                Paladar blando, úvula completa y pilares amigdalinos visibles.
              </div>
              <div class="mp-reference-card" style="background:#fff8db;border-color:#f4d35e;">
                <b>Clase II</b>
                Paladar blando y úvula parcial visibles; pilares no visibles completamente.
              </div>
              <div class="mp-reference-card" style="background:#fff0e1;border-color:#f7b267;">
                <b>Clase III</b>
                Solo base de úvula o paladar blando parcialmente visible.
              </div>
              <div class="mp-reference-card" style="background:#fdebec;border-color:#f2a7b1;">
                <b>Clase IV</b>
                Solo paladar duro visible; no se visualiza paladar blando ni úvula.
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mt-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Mallampati alto aumenta alerta; Mallampati bajo no descarta dificultad</div>
          <div class="note-tips">
            <strong>Qué hacer:</strong> úsalo como una pieza del examen de vía aérea junto a distancia tiromentoniana, apertura bucal, movilidad cervical, mordida, anatomía facial y antecedentes.
          </div>
          <div class="note-tips">
            <strong>Qué evitar:</strong> basar el plan de intubación solo en Mallampati o hacerlo con el paciente hablando.
          </div>
          <div class="note-tips">
            <strong>Error frecuente:</strong> confundir Mallampati con Cormack-Lehane. Mallampati se estima antes; Cormack describe la visión real durante laringoscopía.
          </div>
          <div class="note-tips">
            <strong>Paciente edentado o adulto mayor:</strong> no sobreinterpretes un Mallampati “bueno”; la dificultad puede venir por apertura limitada, rigidez cervical, retrognatia o mala reserva fisiológica.
          </div>
          <div class="note-tips mb-0">
            <strong>Mensaje final:</strong> el examen correcto mejora la información; la decisión segura nace de integrar varios predictores, no de memorizar una clase.
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

  if (CNS.bindSelectionSync) {
    CNS.bindSelectionSync('.mp-trigger');
  }

  const gradeData = {
    '1': {
      panelClass: 'grade-1',
      captionBg: '#e9f8ef',
      captionBorder: '#b7e4c7',
      grade: 'Clase I',
      vision: 'Paladar blando, úvula completa y pilares visibles',
      meaning: 'Tamizaje favorable',
      soft: 'Menor alerta por este componente, pero no descarta vía aérea difícil.',
      pearl: 'Registra técnica correcta y combínalo con DTM, apertura oral, movilidad cervical y antecedentes.',
      action: 'Integrar con el resto de la vía aérea',
      interpMain: 'Mallampati I suele ser un hallazgo favorable, pero no descarta dificultad de vía aérea.',
      interpSoft: 'La vía aérea difícil puede depender de apertura bucal, movilidad cervical, obesidad, retrognatia, OSA, barba, reserva fisiológica o antecedentes.',
      warning: 'Mallampati bajo no descarta vía aérea difícil. Evita usarlo como criterio único para “relajarte” con la estrategia.',
      summary: 'Mallampati I: paladar blando, úvula completa y pilares visibles; hallazgo orofaríngeo favorable.',
      caption: 'Clase I: paladar blando, úvula completa y pilares visibles.'
    },
    '2': {
      panelClass: 'grade-2',
      captionBg: '#fff8db',
      captionBorder: '#f4d35e',
      grade: 'Clase II',
      vision: 'Paladar blando y úvula parcialmente visible',
      meaning: 'Tamizaje levemente menos favorable',
      soft: 'Baja probabilidad de dificultad por este componente aislado, pero requiere integración con otros predictores.',
      pearl: 'No lo conviertas en “normal” o “difícil”: documenta la clase y sigue evaluando el resto.',
      action: 'Completar evaluación integrada',
      interpMain: 'Mallampati II suele ser compatible con vía aérea no difícil, pero su valor aislado sigue siendo limitado.',
      interpSoft: 'Interpreta junto con distancia tiromentoniana, apertura oral, movilidad cervical y antecedentes.',
      warning: 'Mallampati II no debe cerrar la evaluación. Si otros predictores son malos, el plan debe ajustarse.',
      summary: 'Mallampati II: paladar blando y úvula parcialmente visibles; hallazgo intermedio-favorable.',
      caption: 'Clase II: paladar blando y úvula parcialmente visible.'
    },
    '3': {
      panelClass: 'grade-3',
      captionBg: '#fff0e1',
      captionBorder: '#f7b267',
      grade: 'Clase III',
      vision: 'Solo base de úvula o paladar blando parcialmente visible',
      meaning: 'Aumenta alerta de vía aérea',
      soft: 'Puede asociarse a mayor probabilidad de dificultad, especialmente si coexisten otros predictores.',
      pearl: 'Busca activamente apertura bucal limitada, DTM corta, rigidez cervical, OSA, obesidad o antecedentes.',
      action: 'Aumentar alerta y planificar respaldo',
      interpMain: 'Mallampati III aumenta la sospecha, pero no predice por sí solo una intubación difícil.',
      interpSoft: 'Su utilidad real aparece cuando se combina con otros hallazgos de vía aérea y con la reserva fisiológica del paciente.',
      warning: 'No sobrerreacciones al número aislado, pero tampoco lo ignores. El riesgo aumenta si se suma a otros predictores.',
      summary: 'Mallampati III: solo base de úvula o paladar blando parcialmente visible; aumenta la alerta de vía aérea.',
      caption: 'Clase III: solo base de úvula o paladar blando parcialmente visible.'
    },
    '4': {
      panelClass: 'grade-4',
      captionBg: '#fdebec',
      captionBorder: '#f2a7b1',
      grade: 'Clase IV',
      vision: 'Solo paladar duro visible',
      meaning: 'Alta alerta de dificultad potencial',
      soft: 'Hallazgo de alarma preoperatoria, especialmente si coexiste con apertura limitada, cuello rígido, retrognatia u OSA.',
      pearl: 'No significa fracaso automático, pero obliga a preparar estrategia, ayuda, dispositivos y plan alternativo.',
      action: 'Planificar estrategia de vía aérea',
      interpMain: 'Mallampati IV es un hallazgo de alto alerta y debe gatillar planificación más cuidadosa.',
      interpSoft: 'La pregunta clave no es si “va a ser imposible”, sino qué plan de vía aérea reduce intentos fallidos y mantiene oxigenación.',
      warning: 'Mallampati IV no debe manejarse con improvisación. Prepara dispositivos, ayuda, plan alternativo y criterios claros de escalamiento.',
      summary: 'Mallampati IV: solo paladar duro visible; hallazgo de alta alerta para dificultad potencial.',
      caption: 'Clase IV: solo paladar duro visible.'
    }
  };

  const panelEl = document.getElementById('gradePanel');
  const summaryBox = document.getElementById('summaryBox');
  const mpPearl = document.getElementById('mpPearl');
  const interpMain = document.getElementById('interpMain');
  const interpSoft = document.getElementById('interpSoft');
  const warningText = document.getElementById('warningText');
  const summaryNarrative = document.getElementById('summaryNarrative');
  const summaryGrade = document.getElementById('summaryGrade');
  const summaryAction = document.getElementById('summaryAction');

  function setText(el, value){
    if(CNS.safeSetText) CNS.safeSetText(el, value);
    else if(el) el.textContent = value;
  }

  function renderGrade(grade){
    const data = gradeData[grade] || gradeData['1'];

    panelEl.className = 'mp-grade-panel ' + data.panelClass;
    summaryBox.style.background = data.captionBg;
    summaryBox.style.borderColor = data.captionBorder;

    setText(mpPearl, data.pearl);
    setText(interpMain, data.interpMain);
    setText(interpSoft, data.interpSoft);
    setText(warningText, data.warning);
    setText(summaryNarrative, data.summary);
    setText(summaryGrade, data.grade);
    setText(summaryAction, data.action);
  }

  document.querySelectorAll('.mp-trigger').forEach(function(input){
    input.addEventListener('change', function(){
      if(input.checked) renderGrade(input.value);
    });
  });

  renderGrade('1');
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
