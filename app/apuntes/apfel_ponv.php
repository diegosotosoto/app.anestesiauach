<?php
$titulo_pagina = "Score de Apfel";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "El score de Apfel estima el riesgo basal de náuseas y vómitos postoperatorios en adultos y permite orientar una estrategia profiláctica rápida según la carga acumulada de factores de riesgo.";
$formula = "Apfel = sexo femenino + no fumador + antecedente de NVPO/cinetosis + uso esperado de opioides postoperatorios";
$referencias = array(
  "Apfel CC, Läärä E, Koivuranta M, Greim CA, Roewer N. A simplified risk score for predicting postoperative nausea and vomiting. Anesthesiology. 1999;91(3):693-700.",
  "Gan TJ, et al. Consensus guidelines for the management of postoperative nausea and vomiting.",
  "Usar el score como apoyo orientativo; la decisión final depende también del tipo de cirugía, técnica anestésica, opioides y contexto clínico."
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
          .apfel-question-card{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }
          .apfel-question-title{
            font-size:1rem;
            font-weight:800;
            line-height:1.3;
            color:#3559b7;
            margin:0 0 .75rem 0;
            text-align:center;
          }
          .apfel-binary-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }
          .apfel-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
          .apfel-option{
            display:flex;
            align-items:center;
            gap:.7rem;
            min-height:84px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.85rem .9rem;
            cursor:pointer;
            transition:.15s ease;
          }
          .apfel-option-input:checked + .apfel-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }
          .apfel-option-mark{
            width:30px;
            height:30px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 auto;
            background:#eaf7ef;
            color:#1f9d55;
            border:1px solid #b7e2c4;
          }
          .apfel-option-mark.no{
            background:#fff1f1;
            color:#d92d20;
            border-color:#f2b8b5;
          }
          .apfel-option-copy{
            min-width:0;
            flex:1;
            text-align:center;
          }
          .apfel-option-title{
            font-size:.95rem;
            font-weight:800;
            color:var(--note-text);
            line-height:1.2;
            margin:0;
          }

          .apfel-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }
          .apfel-plan-line:last-child{margin-bottom:0;}

          .apfel-other-risk{
            padding:.85rem .95rem;
            border-radius:.95rem;
            background:#f8fafc;
            border:1px solid var(--note-line-strong);
            margin-bottom:.55rem;
          }
          .apfel-other-risk:last-child{margin-bottom:0;}

          .apfel-dose-card{
            padding:1rem 1rem 1.1rem 1rem;
          }
          .apfel-dose-card .note-card-title{
            margin-bottom:.85rem;
          }
          .apfel-dose-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:1rem;
          }
          .apfel-dose-item{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1.2rem;
            padding:.85rem;
          }
          .apfel-dose-inner{
            display:block;
            width:100%;
            margin:0;
            padding:.95rem 1rem;
            border-radius:1rem;
            background:#f8fafc;
            border:1px solid rgba(31,42,55,.08);
            text-align:center;
          }
          .apfel-dose-name{
            font-size:1rem;
            font-weight:800;
            line-height:1.15;
            margin:0 0 .18rem 0;
            color:var(--note-text);
          }
          .apfel-dose-rule{
            font-size:.92rem;
            line-height:1.25;
            color:var(--note-text);
            font-weight:700;
            margin:0;
          }
          .apfel-dose-value{
            font-size:1rem;
            font-weight:800;
            color:#667085;
            margin-top:.5rem;
            text-align:center;
          }

          @media (max-width:360px){
            .apfel-binary-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · NVPO ADULTO</div>
          <h2>Score de Apfel</h2>
          <div class="note-hero-subtitle">Estimación rápida del riesgo basal de NVPO en adultos para orientar profilaxis y rescate.</div>
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
            <div class="note-section-label">Cuestionario</div>

            <?php
            $questions = array(
              array('id'=>'sexo','title'=>'1. Sexo femenino'),
              array('id'=>'fumador','title'=>'2. No fumador'),
              array('id'=>'historia','title'=>'3. Antecedente de NVPO o cinetosis'),
              array('id'=>'opioides','title'=>'4. Uso esperado de opioides postoperatorios')
            );
            foreach($questions as $q){ ?>
            <div class="apfel-question-card<?php echo $q['id']==='opioides' ? ' mb-0' : ''; ?>">
              <div class="apfel-question-title"><?php echo $q['title']; ?></div>
              <div class="apfel-binary-grid">
                <label>
                  <input class="apfel-option-input" type="radio" name="<?php echo $q['id']; ?>" value="1">
                  <div class="apfel-option">
                    <div class="apfel-option-mark"><i class="fa-solid fa-check"></i></div>
                    <div class="apfel-option-copy"><div class="apfel-option-title">Sí</div></div>
                  </div>
                </label>
                <label>
                  <input class="apfel-option-input" type="radio" name="<?php echo $q['id']; ?>" value="0" checked>
                  <div class="apfel-option">
                    <div class="apfel-option-mark no"><i class="fa-solid fa-xmark"></i></div>
                    <div class="apfel-option-copy"><div class="apfel-option-title">No</div></div>
                  </div>
                </label>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">0 factores de riesgo. Riesgo basal bajo.</div>
          <div class="note-result-grid-2 mt-2">
            <div class="note-result-card">
              <div class="note-result-card-label">Factores</div>
              <div id="summaryScore" class="note-result-card-value">0</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Riesgo estimado</div>
              <div id="summaryRisk" class="note-result-card-value">10%</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Nivel</div>
              <div id="summaryLevel" class="note-result-card-value">Bajo</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Estrategia</div>
              <div id="summaryStrategy" class="note-result-card-value">Observación / sin profilaxis rutinaria</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Puntaje</div>
            <div id="scoreNum" class="note-result-card-value">0</div>
            <div id="scoreText" class="note-result-card-note">0 factores de riesgo</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Riesgo estimado</div>
            <div id="riskPercent" class="note-result-card-value">10%</div>
            <div id="riskInterpretation" class="note-result-card-note">Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Profilaxis orientativa</div>
          <div id="algoRisk" class="note-interpretation-main">Bajo riesgo</div>
          <div id="algoExtra" class="note-interpretation-soft">Optimizar medidas generales, hidratación y reducción de opioides cuando sea posible.</div>
          <div id="drugPlan" class="mt-3 text-start">
            <div class="apfel-plan-line">Sin profilaxis rutinaria en pacientes de muy bajo riesgo.</div>
          </div>

          <div class="note-card mt-3">
            <div class="note-card-title text-center">Opciones de manejo frecuentes</div>
            <div class="apfel-dose-grid">

                <div class="drug-card drug-other">
                  <div class="drug-label-content">
                    <div class="drug-label-title">Dexametasona</div>
                    <div class="drug-label-subtitle">Profilaxis IV habitual · 4 mg</div>
                  </div>
                </div>

                <div class="drug-card drug-other">
                  <div class="drug-label-content">
                    <div class="drug-label-title">Ondansetrón</div>
                    <div class="drug-label-subtitle">Profilaxis IV habitual · 4 mg</div>
                  </div>
                </div>

                <div class="drug-card drug-other">
                  <div class="drug-label-content">
                    <div class="drug-label-title">Droperidol</div>
                    <div class="drug-label-subtitle">Profilaxis IV habitual · 0,625–1 mg</div>
                  </div>
                </div>
            </div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Rescate orientativo:</strong>
          <div id="rescueText" class="mt-2">Si presenta NVPO pese a la profilaxis, el rescate idealmente debe usar una clase farmacológica distinta a la ya administrada.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Factores contextuales no incluidos en el score</div>
            <div class="apfel-other-risk"><strong>Técnica anestésica:</strong> halogenados, opioides y reversión pueden aumentar riesgo.</div>
            <div class="apfel-other-risk"><strong>Cirugía:</strong> algunos procedimientos son más emetógenos que otros.</div>
            <div class="apfel-other-risk"><strong>Dolor y movilización:</strong> pueden facilitar NVPO en el postoperatorio inmediato.</div>
            <div class="apfel-other-risk"><strong>Hidratación:</strong> la optimización de fluidos puede actuar como medida coadyuvante.</div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">No confundas un score simple con una orden automática</div>
          <div class="note-tips"><strong>Qué hacer:</strong> ajusta profilaxis al puntaje, cirugía, técnica anestésica y plan analgésico.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> repetir en rescate la misma clase antiemética ya usada en profilaxis.</div>
          <div class="note-tips mb-0"><strong>Perla:</strong> en riesgo alto o muy alto, la prevención multimodal suele rendir mejor que escalar dosis de una sola clase.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const radios = Array.from(document.querySelectorAll('.apfel-option-input'));

  function getValue(name){
    const selected = document.querySelector(`input[name="${name}"]:checked`);
    return selected ? Number(selected.value) : 0;
  }

  function render(){
    const score = getValue('sexo') + getValue('fumador') + getValue('historia') + getValue('opioides');

    document.getElementById('scoreNum').textContent = score;
    document.getElementById('scoreText').textContent = score + (score === 1 ? ' factor de riesgo' : ' factores de riesgo');
    document.getElementById('summaryScore').textContent = String(score);

    if(score === 0){
      document.getElementById('riskPercent').textContent = '10%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.';
      document.getElementById('algoRisk').textContent = 'Bajo riesgo';
      document.getElementById('drugPlan').innerHTML = '<div class="apfel-plan-line">Sin profilaxis rutinaria en pacientes de muy bajo riesgo.</div>';
      document.getElementById('algoExtra').textContent = 'Además considerar TIVA, minimizar opioides, optimizar hidratación y anticipar rescate con clase distinta, especialmente si existen antecedentes marcados de NVPO/cinetosis o cirugía de alto riesgo emetógeno.';
      document.getElementById('rescueText').textContent = 'Si presenta NVPO, usar antiemético de rescate según contexto y fármacos ya administrados.';
      document.getElementById('summaryNarrative').textContent = '0 factores de riesgo. Riesgo basal bajo; profilaxis rutinaria habitualmente no necesaria.';
      document.getElementById('summaryRisk').textContent = '10%';
      document.getElementById('summaryLevel').textContent = 'Bajo';
      document.getElementById('summaryStrategy').textContent = 'Observación / sin profilaxis rutinaria';
    } else if(score === 1){
      document.getElementById('riskPercent').textContent = '20%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo bajo-moderado. Puede considerarse profilaxis simple.';
      document.getElementById('algoRisk').textContent = 'Riesgo bajo-moderado';
      document.getElementById('drugPlan').innerHTML = '<div class="apfel-plan-line"><strong>Profilaxis simple:</strong> considerar dexametasona 4 mg IV o estrategia equivalente según contexto.</div>';
      document.getElementById('algoExtra').textContent = 'Puede justificarse profilaxis si la cirugía o el contexto aumentan la carga emetógena.';
      document.getElementById('rescueText').textContent = 'Si recibió dexametasona y presenta NVPO, el rescate idealmente debe usar otra clase, por ejemplo un antagonista 5-HT3 si no fue usado.';
      document.getElementById('summaryNarrative').textContent = '1 factor de riesgo. Riesgo bajo-moderado; puede considerarse profilaxis simple.';
      document.getElementById('summaryRisk').textContent = '20%';
      document.getElementById('summaryLevel').textContent = 'Bajo-moderado';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis simple';
    } else if(score === 2){
      document.getElementById('riskPercent').textContent = '40%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo moderado. Se recomienda profilaxis combinada.';
      document.getElementById('algoRisk').textContent = 'Riesgo moderado';
      document.getElementById('drugPlan').innerHTML = '<div class="apfel-plan-line"><strong>1ª línea:</strong> Dexametasona 4 mg IV.</div><div class="apfel-plan-line"><strong>2ª línea:</strong> Ondansetrón 4 mg IV.</div>';
      document.getElementById('algoExtra').textContent = 'La combinación de clases distintas suele ser más razonable que escalar dosis de un solo fármaco.';
      document.getElementById('rescueText').textContent = 'Si ya recibió dexametasona + ondansetrón y presenta NVPO, considera rescate con otra clase, por ejemplo droperidol si no está contraindicado.';
      document.getElementById('summaryNarrative').textContent = '2 factores de riesgo. Riesgo moderado; la estrategia orientativa es profilaxis doble.';
      document.getElementById('summaryRisk').textContent = '40%';
      document.getElementById('summaryLevel').textContent = 'Moderado';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis doble';
    } else if(score === 3){
      document.getElementById('riskPercent').textContent = '60%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo alto. Se recomienda profilaxis múltiple.';
      document.getElementById('algoRisk').textContent = 'Riesgo alto';
      document.getElementById('drugPlan').innerHTML = '<div class="apfel-plan-line"><strong>1ª línea:</strong> Dexametasona 4 mg IV.</div><div class="apfel-plan-line"><strong>2ª línea:</strong> Ondansetrón 4 mg IV.</div><div class="apfel-plan-line"><strong>3ª línea:</strong> Droperidol 0,625–1 mg IV si es apropiado.</div>';
      document.getElementById('algoExtra').textContent = 'Además conviene usar técnica anestésica que disminuya riesgo, reducir opioides y reforzar analgesia multimodal.';
      document.getElementById('rescueText').textContent = 'Si ya recibió profilaxis múltiple, el rescate no debería repetir de entrada el mismo grupo farmacológico.';
      document.getElementById('summaryNarrative').textContent = '3 factores de riesgo. Riesgo alto; requiere profilaxis intensiva.';
      document.getElementById('summaryRisk').textContent = '60%';
      document.getElementById('summaryLevel').textContent = 'Alto';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis intensiva';
    } else {
      document.getElementById('riskPercent').textContent = '80%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo muy alto. Requiere profilaxis multimodal intensiva.';
      document.getElementById('algoRisk').textContent = 'Riesgo muy alto';
      document.getElementById('drugPlan').innerHTML = '<div class="apfel-plan-line"><strong>1ª línea:</strong> Dexametasona 4 mg IV.</div><div class="apfel-plan-line"><strong>2ª línea:</strong> Ondansetrón 4 mg IV.</div><div class="apfel-plan-line"><strong>3ª línea:</strong> Droperidol 0,625–1 mg IV si es apropiado.</div>';
      document.getElementById('algoExtra').textContent = 'Además considerar TIVA, minimizar opioides, optimizar hidratación y anticipar rescate con clase distinta.';
      document.getElementById('rescueText').textContent = 'Si pese a la profilaxis presenta NVPO, rescata con clase farmacológica distinta a las ya usadas y reevalúa causas contribuyentes.';
      document.getElementById('summaryNarrative').textContent = '4 factores de riesgo. Riesgo muy alto; requiere profilaxis multimodal agresiva.';
      document.getElementById('summaryRisk').textContent = '80%';
      document.getElementById('summaryLevel').textContent = 'Muy alto';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis multimodal';
    }
  }

  radios.forEach(function(r){ r.addEventListener('change', render); });
  render();
})();

function toggleInfo(){
  const box = document.getElementById('infoContent');
  box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
}
</script>

<?php require("../footer.php"); ?>
