<?php
$titulo_pagina = "Score de Eberhart";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "El score de Eberhart permite estimar el riesgo de vómitos postoperatorios en niños y orientar una estrategia profiláctica rápida en base a 4 factores clínicos simples.";
$formula = "Eberhart = edad >3 años + cirugía >30 min + cirugía de estrabismo + antecedente personal/familiar de POV-PONV";
$referencias = array(
  "Eberhart LH, Geldner G, Kranke P, Morin AM, Schäuffelen A, Treiber H, Wulf H. The development and validation of a risk score to predict the probability of postoperative vomiting in pediatric patients. Anesth Analg. 2004;99(6):1630-1637.",
  "Gan TJ, et al. Consensus guidelines for the management of postoperative nausea and vomiting.",
  "Aplicar juicio clínico adicional en cirugía pediátrica no oftalmológica y cuando existan factores no incluidos en el score."
);

include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .eberhart-question-card{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }
          .eberhart-question-title{
            font-size:1rem;
            font-weight:800;
            line-height:1.3;
            color:#3559b7;
            margin:0 0 .75rem 0;
            text-align:center;
          }
          .eberhart-binary-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }
          .eberhart-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
          .eberhart-option{
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
          .eberhart-option-input:checked + .eberhart-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }
          .eberhart-option-mark{
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
          .eberhart-option-mark.no{
            background:#fff1f1;
            color:#d92d20;
            border-color:#f2b8b5;
          }
          .eberhart-option-copy{
            min-width:0;
            flex:1;
            text-align:center;
          }
          .eberhart-option-title{
            font-size:.95rem;
            font-weight:800;
            color:var(--note-text);
            line-height:1.2;
            margin:0;
          }

          .eberhart-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }
          .eberhart-plan-line:last-child{margin-bottom:0;}

          .eberhart-other-risk{
            padding:.85rem .95rem;
            border-radius:.95rem;
            background:#f8fafc;
            border:1px solid var(--note-line-strong);
            margin-bottom:.55rem;
          }
          .eberhart-other-risk:last-child{margin-bottom:0;}

          .eberhart-dose-card{
            padding:1rem 1rem 1.1rem 1rem;
          }
          .eberhart-dose-card .note-card-title{
            margin-bottom:.85rem;
          }
          .eberhart-dose-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }
          .eberhart-dose-item{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1.2rem;
            padding:.85rem;
          }
          .eberhart-dose-inner{
            display:block;
            width:100%;
            margin:0;
            padding:.95rem 1rem;
            border-radius:1rem;
            background:#f8fafc;
            border:1px solid rgba(31,42,55,.08);
            text-align:center;
          }
          .eberhart-dose-name{
            font-size:1rem;
            font-weight:800;
            line-height:1.15;
            margin:0 0 .18rem 0;
            color:var(--note-text);
          }
          .eberhart-dose-rule{
            font-size:.92rem;
            line-height:1.25;
            color:var(--note-text);
            font-weight:700;
            margin:0;
          }
          .eberhart-dose-value{
            font-size:1rem;
            font-weight:800;
            color:#667085;
            margin-top:.5rem;
            text-align:center;
          }

          @media (max-width:360px){
            .eberhart-binary-grid{grid-template-columns:1fr;}
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · NVPO PEDIÁTRICO</div>
          <h2>Score de Eberhart</h2>
          <div class="note-hero-subtitle">Estimación rápida del riesgo de vómitos postoperatorios en niños para orientar profilaxis y rescate.</div>
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

        <div class="note-input-group mb-3">
          <label class="note-label">Peso del paciente</label>
          <div class="note-input-inline">
            <input id="weightInput" type="text" inputmode="decimal" class="note-input">
            <div class="note-input-unit">kg</div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Cuestionario</div>

            <?php
            $questions = array(
              array('id'=>'edad','title'=>'1. Edad mayor de 3 años'),
              array('id'=>'duracion','title'=>'2. Duración quirúrgica mayor de 30 minutos'),
              array('id'=>'estrabismo','title'=>'3. Cirugía de estrabismo'),
              array('id'=>'historia','title'=>'4. Antecedente personal de POV o antecedente familiar de POV/PONV')
            );
            foreach($questions as $q){ ?>
            <div class="eberhart-question-card<?php echo $q['id']==='historia' ? ' mb-0' : ''; ?>">
              <div class="eberhart-question-title"><?php echo $q['title']; ?></div>
              <div class="eberhart-binary-grid">
                <label>
                  <input class="eberhart-option-input" type="radio" name="<?php echo $q['id']; ?>" value="1">
                  <div class="eberhart-option">
                    <div class="eberhart-option-mark"><i class="fa-solid fa-check"></i></div>
                    <div class="eberhart-option-copy"><div class="eberhart-option-title">Sí</div></div>
                  </div>
                </label>
                <label>
                  <input class="eberhart-option-input" type="radio" name="<?php echo $q['id']; ?>" value="0" checked>
                  <div class="eberhart-option">
                    <div class="eberhart-option-mark no"><i class="fa-solid fa-xmark"></i></div>
                    <div class="eberhart-option-copy"><div class="eberhart-option-title">No</div></div>
                  </div>
                </label>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">0 factores de riesgo. Riesgo estimado bajo.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item"><div class="note-summary-k">Peso</div><div id="summaryWeight" class="note-summary-v">-</div></div>
            <div class="note-summary-item"><div class="note-summary-k">Riesgo estimado</div><div id="summaryRisk" class="note-summary-v">9%</div></div>
            <div class="note-summary-item"><div class="note-summary-k">Nivel</div><div id="summaryLevel" class="note-summary-v">Bajo</div></div>
            <div class="note-summary-item"><div class="note-summary-k">Estrategia</div><div id="summaryStrategy" class="note-summary-v">Observación / sin profilaxis rutinaria</div></div>
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
            <div id="riskPercent" class="note-result-card-value">9%</div>
            <div id="riskInterpretation" class="note-result-card-note">Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Profilaxis orientativa</div>
          <div id="algoRisk" class="note-interpretation-main">Bajo riesgo</div>
          <div id="algoExtra" class="note-interpretation-soft">Si hay otros factores pediátricos relevantes, puedes escalar la profilaxis.</div>
          <div id="drugPlan" class="mt-3 text-start">
            <div class="eberhart-plan-line">Sin profilaxis rutinaria en pacientes de muy bajo riesgo.</div>
          </div>

<div class="note-card mt-3 eberhart-dose-card">
  <div id="doseCardTitle" class="note-card-title text-center">Opciones de manejo (ajustadas a peso)</div>
  <div class="eberhart-dose-grid">

                <div class="eberhart-dose-inner">
                  <div class="eberhart-dose-name">Dexametasona</div>
                  <div class="eberhart-dose-rule">0,15 mg/kg (máx 4 mg)</div>
                  <div id="doseDexa" class="eberhart-dose-value">-</div>
                </div>



                <div class="eberhart-dose-inner">
                  <div class="eberhart-dose-name">Ondansetrón</div>
                  <div class="eberhart-dose-rule">0,1 mg/kg (máx 4 mg)</div>
                  <div id="doseOndansetron" class="eberhart-dose-value">-</div>
                </div>



                <div class="eberhart-dose-inner">
                  <div class="eberhart-dose-name">Droperidol</div>
                  <div class="eberhart-dose-rule">10 mcg/kg (máx. 1,25 mg)</div>
                  <div id="doseDroperidol" class="eberhart-dose-value">-</div>
                </div>

            </div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Rescate orientativo:</strong>
          <div id="rescueText" class="mt-2">Si presenta POV, considerar rescate con una clase antiemética apropiada según el contexto clínico.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Otros factores relevantes en niños</div>
            <div class="eberhart-other-risk"><strong>Cirugía:</strong> apéndice, amígdalas y procedimientos con mayor riesgo.</div>
            <div class="eberhart-other-risk"><strong>Drogas:</strong> ketamina, halogenados, opioides y neostigmina pueden aumentar el riesgo.</div>
            <div class="eberhart-other-risk"><strong>Otros:</strong> dolor y movimientos también favorecen POV.</div>
            <div class="eberhart-other-risk"><strong>Ingesta oral:</strong> no se ha asociado claramente como factor de riesgo.</div>
            <div class="eberhart-other-risk"><strong>Fluidos EV intraoperatorios:</strong> podrían actuar como factor protector.</div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">No confundas un score simple con una decisión automática</div>
          <div class="note-tips"><strong>Qué hacer:</strong> Ajusta la profilaxis al puntaje, al tipo de cirugía y al perfil emetógeno global del niño.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> Repetir en rescate el mismo grupo antiemético usado en profilaxis si puedes elegir otra clase.</div>


      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const weightInput = document.getElementById('weightInput');
  const doseDexa = document.getElementById('doseDexa');
  const doseOndansetron = document.getElementById('doseOndansetron');
  const doseDroperidol = document.getElementById('doseDroperidol');
  const radios = Array.from(document.querySelectorAll('.eberhart-option-input'));

  function parseDecimalLocal(value){
    if(value === null || value === undefined) return null;
    const normalized = String(value).trim().replace(',', '.');
    if(normalized === '') return null;
    const n = Number(normalized);
    return Number.isFinite(n) ? n : null;
  }

  function formatNumberLocal(value, decimals){
    if(!Number.isFinite(value)) return '-';
    return value.toLocaleString('es-CL', {
      minimumFractionDigits: 0,
      maximumFractionDigits: decimals
    });
  }

  function getValue(name){
    const selected = document.querySelector(`input[name="${name}"]:checked`);
    return selected ? Number(selected.value) : 0;
  }

  function renderDrugDoses(weight){
    if(!weight || weight <= 0){
      doseDexa.textContent = '-';
      doseOndansetron.textContent = '-';
      doseDroperidol.textContent = '-';
      return;
    }

    doseDexa.textContent = formatNumberLocal(Math.min(0.15 * weight, 4), 1) + ' mg';
    doseOndansetron.textContent = formatNumberLocal(Math.min(0.1 * weight, 4), 1) + ' mg';
    doseDroperidol.textContent = formatNumberLocal(Math.min(10 * weight, 1250), 0) + ' mcg';
  }

  function render(){
    const score = getValue('edad') + getValue('duracion') + getValue('estrabismo') + getValue('historia');

    document.getElementById('scoreNum').textContent = score;
    document.getElementById('scoreText').textContent = score + (score === 1 ? ' factor de riesgo' : ' factores de riesgo');
   const weight = parseDecimalLocal(weightInput.value); 
    const doseCardTitle = document.getElementById('doseCardTitle');
    doseCardTitle.textContent = weight && weight > 0
      ? 'Opciones de manejo (ajustadas a ' + formatNumberLocal(weight, 2) + ' kg)'
      : 'Opciones de manejo (ajustadas a peso)';
      document.getElementById('summaryWeight').textContent = weight && weight > 0 ? formatNumberLocal(weight, 2) + ' kg' : '-';

    if(score === 0){
      document.getElementById('riskPercent').textContent = '9%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.';
      document.getElementById('algoRisk').textContent = 'Bajo riesgo';
      document.getElementById('drugPlan').innerHTML = '<div class="eberhart-plan-line">Sin profilaxis rutinaria en pacientes de muy bajo riesgo.</div>';
      document.getElementById('algoExtra').textContent = 'Si hay otros factores pediátricos relevantes, puedes escalar la profilaxis.';
      document.getElementById('rescueText').textContent = 'Si presenta POV, considerar rescate con una clase antiemética apropiada según el contexto clínico.';
      document.getElementById('summaryNarrative').textContent = '0 factores de riesgo. Riesgo estimado bajo; profilaxis rutinaria habitualmente no necesaria.';
      document.getElementById('summaryRisk').textContent = '9%';
      document.getElementById('summaryLevel').textContent = 'Bajo';
      document.getElementById('summaryStrategy').textContent = 'Observación / sin profilaxis rutinaria';
    } else if(score === 1){
      document.getElementById('riskPercent').textContent = '10%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo bajo-moderado. Puede considerarse profilaxis simple.';
      document.getElementById('algoRisk').textContent = 'Riesgo bajo-moderado';
      document.getElementById('drugPlan').innerHTML = '<div class="eberhart-plan-line"><strong>Profilaxis simple:</strong> Dexametasona 0,15 mg/kg <em>o</em> Ondansetrón 0,1 mg/kg.</div>';
      document.getElementById('algoExtra').textContent = 'En cirugía de mayor riesgo clínico, puedes optar por una estrategia más intensiva.';
      document.getElementById('rescueText').textContent = 'Si recibió dexametasona, el rescate idealmente debiera ser con otra clase, por ejemplo ondansetrón. Si recibió ondansetrón, considerar otra clase en rescate.';
      document.getElementById('summaryNarrative').textContent = '1 factor de riesgo. Riesgo bajo-moderado; puede considerarse profilaxis simple.';
      document.getElementById('summaryRisk').textContent = '10%';
      document.getElementById('summaryLevel').textContent = 'Bajo-moderado';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis simple';
    } else if(score === 2){
      document.getElementById('riskPercent').textContent = '30%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo moderado. Se recomienda profilaxis doble.';
      document.getElementById('algoRisk').textContent = 'Riesgo moderado';
      document.getElementById('drugPlan').innerHTML = '<div class="eberhart-plan-line"><strong>1ª línea:</strong> Dexametasona 0,15 mg/kg.</div><div class="eberhart-plan-line"><strong>2ª línea:</strong> Ondansetrón 0,1 mg/kg.</div>';
      document.getElementById('algoExtra').textContent = 'Esto es especialmente razonable en cirugías con mayor riesgo emetógeno.';
      document.getElementById('rescueText').textContent = 'Si ya recibió dexametasona + ondansetrón y presenta POV, usar rescate con otra clase, por ejemplo droperidol o metoclopramida según el contexto.';
      document.getElementById('summaryNarrative').textContent = '2 factores de riesgo. Riesgo moderado; la estrategia orientativa es profilaxis doble.';
      document.getElementById('summaryRisk').textContent = '30%';
      document.getElementById('summaryLevel').textContent = 'Moderado';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis doble';
    } else if(score === 3){
      document.getElementById('riskPercent').textContent = '55%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo alto. Requiere profilaxis intensiva.';
      document.getElementById('algoRisk').textContent = 'Riesgo alto';
      document.getElementById('drugPlan').innerHTML = '<div class="eberhart-plan-line"><strong>1ª línea:</strong> Dexametasona 0,15 mg/kg.</div><div class="eberhart-plan-line"><strong>2ª línea:</strong> Ondansetrón 0,1 mg/kg.</div><div class="eberhart-plan-line"><strong>3ª línea:</strong> Considerar Droperidol 10 mcg/kg (máx. 1,25 mg).</div>';
      document.getElementById('algoExtra').textContent = 'Además conviene minimizar opioides y otros desencadenantes cuando sea posible.';
      document.getElementById('rescueText').textContent = 'Si recibió profilaxis múltiple, el rescate no debería repetir de entrada el mismo grupo farmacológico.';
      document.getElementById('summaryNarrative').textContent = '3 factores de riesgo. Riesgo alto; requiere profilaxis intensiva.';
      document.getElementById('summaryRisk').textContent = '55%';
      document.getElementById('summaryLevel').textContent = 'Alto';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis intensiva';
    } else {
      document.getElementById('riskPercent').textContent = '70%';
      document.getElementById('riskInterpretation').textContent = 'Riesgo muy alto. Requiere profilaxis multimodal agresiva.';
      document.getElementById('algoRisk').textContent = 'Riesgo muy alto';
      document.getElementById('drugPlan').innerHTML = '<div class="eberhart-plan-line"><strong>1ª línea:</strong> Dexametasona 0,15 mg/kg.</div><div class="eberhart-plan-line"><strong>2ª línea:</strong> Ondansetrón 0,1 mg/kg.</div><div class="eberhart-plan-line"><strong>3ª línea:</strong> Droperidol 10 mcg/kg (máx. 1,25 mg).</div>';
      document.getElementById('algoExtra').textContent = 'Considerar además reducción de halogenados, opioides y otros factores favorecedores.';
      document.getElementById('rescueText').textContent = 'Si pese a la profilaxis presenta POV, rescatar con clase distinta a las ya utilizadas y reevaluar dolor, movimientos y estímulos desencadenantes.';
      document.getElementById('summaryNarrative').textContent = '4 factores de riesgo. Riesgo muy alto; requiere profilaxis multimodal agresiva.';
      document.getElementById('summaryRisk').textContent = '70%';
      document.getElementById('summaryLevel').textContent = 'Muy alto';
      document.getElementById('summaryStrategy').textContent = 'Profilaxis multimodal';
    }

renderDrugDoses(weight);
  }

  radios.forEach(function(r){ r.addEventListener('change', render); });
  weightInput.addEventListener('input', render);

  render();
})();

function toggleInfo(){
  const box = document.getElementById('infoContent');
  box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
}
</script>

<?php include("footer.php"); ?>
