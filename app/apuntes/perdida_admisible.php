<?php
$titulo_pagina = "Pérdida sanguínea admisible";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Estimación de la pérdida sanguínea admisible antes de alcanzar un hematocrito objetivo. Ayuda a anticipar reposición de volumen, necesidad de controles seriados y eventual transfusión, siempre integrada al contexto clínico.";
$formula = "PSA = Volemia estimada × (Hto inicial - Hto objetivo) / Hto inicial. La volemia estimada se calcula con peso × mL/kg según grupo clínico. El resultado es orientativo y no reemplaza evaluación de perfusión, velocidad del sangrado ni comorbilidades.";
$referencias = array(
  "Miller RD. Miller's Anesthesia. Principles of blood loss and transfusion management.",
  "American Society of Anesthesiologists Task Force on Perioperative Blood Management. Practice Guidelines for Perioperative Blood Management. Anesthesiology. 2015.",
  "AABB Clinical Practice Guidelines on Red Blood Cell Transfusion Thresholds and Storage. JAMA. 2016.",
  "UpToDate. Perioperative blood management: Strategies to minimize transfusions."
);

include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=2">
<script src="js/clinical-note-system.js?v=2"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .psa-choice-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .psa-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .psa-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:72px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.65rem .75rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.18rem;
          }

          .psa-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .psa-option-input:checked + .psa-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .psa-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .psa-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .psa-action-list{
            display:grid;
            gap:.75rem;
          }

          .psa-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .psa-action-mark{
            flex:0 0 auto;
            width:30px;
            height:30px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            margin-top:.08rem;
          }

          .psa-action-mark.ok{background:#2ea663;}
          .psa-action-mark.mid{background:#f4c542;}
          .psa-action-mark.high{background:#d92d20;}

          .psa-action-copy{min-width:0;flex:1;}

          .psa-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .psa-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .psa-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .psa-plan-line:last-child{
            margin-bottom:0;
          }

          .psa-ok-card{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .psa-mid-card{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .psa-danger-card{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          @media (max-width:768px){
            .psa-choice-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .psa-choice-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · HEMORRAGIA · TRANSFUSIÓN</div>
          <h2>Pérdida sanguínea admisible</h2>
          <div class="note-hero-subtitle">Estima cuánto sangrado puede tolerarse antes de alcanzar un hematocrito objetivo, con interpretación clínica y límites de seguridad.</div>
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
            <div class="note-section-label">Datos de entrada</div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Peso</label>
                <div class="note-input-inline">
                  <input id="peso" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Hematocrito inicial</label>
                <div class="note-input-inline">
                  <input id="htoInicial" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">%</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Hematocrito admisible</label>
                <div class="note-input-inline">
                  <input id="htoObjetivo" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">%</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Pérdida actual estimada</label>
                <div class="note-input-inline">
                  <input id="perdidaActual" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mL</div>
                </div>
              </div>
            </div>

            <div class="note-section-label">Volemia estimada</div>
            <div class="psa-choice-grid">
              <label>
                <input class="psa-option-input" type="radio" name="volemiaTipo" value="70" checked>
                <div class="psa-option">
                  <i class="fa-solid fa-person"></i>
                  <div class="psa-option-title">Adulto promedio</div>
                  <div class="psa-option-sub">70 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="psa-option-input" type="radio" name="volemiaTipo" value="65">
                <div class="psa-option">
                  <i class="fa-solid fa-person-cane"></i>
                  <div class="psa-option-title">Adulto Mayor</div>
                  <div class="psa-option-sub">65 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="psa-option-input" type="radio" name="volemiaTipo" value="75">
                <div class="psa-option">
                  <i class="fa-solid fa-person-running"></i>
                  <div class="psa-option-title">Adulto joven / delgado</div>
                  <div class="psa-option-sub">75 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="psa-option-input" type="radio" name="volemiaTipo" value="80">
                <div class="psa-option">
                  <i class="fa-solid fa-child"></i>
                  <div class="psa-option-title">Niño mayor</div>
                  <div class="psa-option-sub">80 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="psa-option-input" type="radio" name="volemiaTipo" value="85">
                <div class="psa-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="psa-option-title">Lactante</div>
                  <div class="psa-option-sub">85 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="psa-option-input" type="radio" name="volemiaTipo" value="90">
                <div class="psa-option">
                  <i class="fa-solid fa-baby-carriage"></i>
                  <div class="psa-option-title">Recién nacido</div>
                  <div class="psa-option-sub">90 mL/kg</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso, hematocrito inicial y hematocrito objetivo para calcular la pérdida sanguínea admisible.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Peso / volemia</div>
              <div id="summaryWeight" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Hematocritos</div>
              <div id="summaryHct" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Volemia total</div>
              <div id="summaryBloodVolume" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Pérdida actual</div>
              <div id="summaryCurrentLoss" class="note-summary-v">No ingresada</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="psaCard" class="note-result-card">
            <div class="note-result-card-label">Pérdida admisible</div>
            <div id="psaResult" class="note-result-card-value">-</div>
            <div id="psaNote" class="note-result-card-note">Resultado orientativo basado en volemia estimada.</div>
          </div>
          <div id="remainingCard" class="note-result-card">
            <div class="note-result-card-label">Margen restante</div>
            <div id="remainingResult" class="note-result-card-value">-</div>
            <div id="remainingNote" class="note-result-card-note">Ingresa pérdida actual si quieres estimar margen restante.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación clínica</div>
          <div id="interpMain" class="note-interpretation-main">Pendiente</div>
          <div id="interpSoft" class="note-interpretation-soft">La PSA orienta planificación, pero la transfusión depende de velocidad de sangrado, perfusión, Hb/Hto real, comorbilidad y contexto quirúrgico.</div>

          <div class="mt-3 text-start">
            <div class="psa-plan-line"><strong>Fórmula aplicada:</strong> <span id="formulaApplied">-</span></div>
            <div class="psa-plan-line"><strong>Reposición inicial:</strong> <span id="replacementText">-</span></div>
            <div class="psa-plan-line"><strong>Cuándo escalar:</strong> <span id="escalationText">-</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">La pérdida admisible no es un gatillo transfusional automático. En sangrado rápido, shock, cardiopatía, sepsis, anemia severa o mala perfusión, la decisión debe adelantarse al cálculo.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="psa-action-list">
              <div class="psa-action-item">
                <div class="psa-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="psa-action-copy">
                  <div class="psa-action-title">Completa los datos esenciales</div>
                  <p class="psa-action-note">La estimación requiere peso, volemia estimada, hematocrito inicial y hematocrito objetivo menor al inicial.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">La pérdida admisible ayuda a anticipar; no decide transfusión por sí sola</div>
          <div class="note-tips"><strong>Qué hacer:</strong> usa la PSA para planificar controles, acceso venoso, fluidos, disponibilidad de sangre y umbral de reevaluación.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> esperar a “superar la PSA” si el sangrado es rápido, hay hipotensión, mala perfusión o baja reserva fisiológica.</div>
          <div class="note-tips"><strong>Reposición inicial:</strong> en sangrado inicial estable, partir con cristaloides balanceados y reevaluar. Evita hemodilución excesiva por sobrecarga.</div>
          <div class="note-tips"><strong>Hemocomponentes:</strong> si el sangrado se vuelve importante, no pienses solo en glóbulos rojos; evalúa plasma, plaquetas, fibrinógeno y protocolo de hemorragia masiva.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> una anemia estable no es lo mismo que shock hemorrágico; la entrega de oxígeno y la perfusión mandan.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

  function parseLocal(value){
    if(CNS.parseDecimal) return CNS.parseDecimal(value);
    const n = Number(String(value || '').replace(',', '.'));
    return Number.isFinite(n) ? n : null;
  }

  function fmt(value, decimals){
    if(!Number.isFinite(value)) return '-';
    if(CNS.formatNumber) return CNS.formatNumber(value, decimals);
    return Number(value).toLocaleString('es-CL', {maximumFractionDigits: decimals});
  }

  function setText(id, value){
    const el = document.getElementById(id);
    if(CNS.safeSetText) CNS.safeSetText(el, value);
    else if(el) el.textContent = value;
  }

  function getSelected(name){
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? Number(selected.value) : null;
  }

  function renderActions(level, currentRatio){
    const box = document.getElementById('actionList');
    let items = [];

    if(level === 'pending'){
      items = [
        ['mid','Completa los datos esenciales','La estimación requiere peso, volemia estimada, hematocrito inicial y hematocrito objetivo menor al inicial.']
      ];
    } else if(level === 'wide'){
      items = [
        ['ok','Reserva estimada relativamente amplia','Hay margen matemático, pero no descarta transfusión si el sangrado es rápido o hay mala perfusión.'],
        ['ok','Planificar seguimiento','Monitoriza campo quirúrgico, hemodinamia, diuresis, lactato y Hb/Hto seriado según magnitud del sangrado.']
      ];
    } else if(level === 'intermediate'){
      items = [
        ['mid','Zona de vigilancia estrecha','Prepara estrategia de reposición y define momento de control de Hb/Hto o gasometría.'],
        ['mid','Anticipar disponibilidad de sangre','Si el sangrado continúa, conviene tener hemocomponentes disponibles antes de llegar al objetivo.']
      ];
    } else {
      items = [
        ['high','Baja tolerancia estimada','Pérdidas pequeñas pueden llevar rápido al hematocrito objetivo. Anticipa transfusión si el contexto lo justifica.'],
        ['high','No esperes al número si hay shock','Inestabilidad, mala perfusión o sangrado rápido obligan a actuar antes de agotar el margen calculado.']
      ];
    }

    if(Number.isFinite(currentRatio)){
      if(currentRatio >= 1){
        items.unshift(['high','Pérdida actual iguala o supera PSA','Reevaluar perfusión, Hb/Hto, necesidad de transfusión y protocolo de hemorragia si corresponde.']);
      } else if(currentRatio >= 0.7){
        items.unshift(['mid','Pérdida actual cercana al umbral','Recontrola laboratorio y anticipa hemocomponentes si el sangrado continúa.']);
      }
    }

    box.innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="psa-action-item">' +
        '<div class="psa-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="psa-action-copy">' +
          '<div class="psa-action-title">' + item[1] + '</div>' +
          '<p class="psa-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updatePSA(){
    const peso = parseLocal(document.getElementById('peso').value);
    const htoI = parseLocal(document.getElementById('htoInicial').value);
    const htoF = parseLocal(document.getElementById('htoObjetivo').value);
    const perdidaActual = parseLocal(document.getElementById('perdidaActual').value);
    const volemiaKg = getSelected('volemiaTipo') || 70;

    setText('summaryWeight', peso && peso > 0 ? fmt(peso,1) + ' kg · ' + fmt(volemiaKg,0) + ' mL/kg' : '-');
    setText('summaryHct', (htoI && htoF) ? fmt(htoI,1) + '% → ' + fmt(htoF,1) + '%' : '-');
    setText('summaryCurrentLoss', perdidaActual && perdidaActual > 0 ? fmt(perdidaActual,0) + ' mL' : 'No ingresada');

    const invalid = !peso || peso <= 0 || !htoI || htoI <= 0 || !htoF || htoF <= 0 || htoF >= htoI;

    if(invalid){
      setText('summaryNarrative', htoF && htoI && htoF >= htoI ? 'El hematocrito objetivo debe ser menor que el hematocrito inicial.' : 'Ingresa peso, hematocrito inicial y hematocrito objetivo para calcular la pérdida sanguínea admisible.');
      setText('summaryBloodVolume', '-');
      setText('psaResult', '-');
      setText('psaNote', 'Resultado orientativo basado en volemia estimada.');
      setText('remainingResult', '-');
      setText('remainingNote', 'Ingresa pérdida actual si quieres estimar margen restante.');
      setText('interpMain', 'Pendiente');
      setText('interpSoft', 'La PSA orienta planificación, pero la transfusión depende de velocidad de sangrado, perfusión, Hb/Hto real, comorbilidad y contexto quirúrgico.');
      setText('formulaApplied', '-');
      setText('replacementText', '-');
      setText('escalationText', '-');
      document.getElementById('psaCard').className = 'note-result-card';
      document.getElementById('remainingCard').className = 'note-result-card';
      renderActions('pending', null);
      return;
    }

    const volemia = peso * volemiaKg;
    const psa = volemia * ((htoI - htoF) / htoI);
    const remaining = (perdidaActual && perdidaActual > 0) ? psa - perdidaActual : null;
    const ratio = (perdidaActual && perdidaActual > 0) ? perdidaActual / psa : null;

    setText('summaryBloodVolume', fmt(volemia,0) + ' mL');
    setText('psaResult', fmt(psa,0) + ' mL');
    setText('psaNote', 'Volemia estimada: ' + fmt(volemia,0) + ' mL.');
    setText('formulaApplied', fmt(volemia,0) + ' × (' + fmt(htoI,1) + ' - ' + fmt(htoF,1) + ') / ' + fmt(htoI,1));

    if(remaining === null){
      setText('remainingResult', '-');
      setText('remainingNote', 'Ingresa pérdida actual si quieres estimar margen restante.');
      document.getElementById('remainingCard').className = 'note-result-card';
    } else {
      setText('remainingResult', fmt(remaining,0) + ' mL');
      setText('remainingNote', remaining >= 0 ? 'Margen estimado antes de alcanzar el Hto objetivo.' : 'La pérdida ingresada supera la PSA estimada.');
      document.getElementById('remainingCard').className = 'note-result-card ' + (remaining < 0 ? 'psa-danger-card' : (ratio >= 0.7 ? 'psa-mid-card' : 'psa-ok-card'));
    }

    let level = 'intermediate';
    let main = 'Reserva intermedia';
    let soft = 'Requiere vigilancia de sangrado, hemodinamia, perfusión y laboratorio seriado.';
    let cardClass = 'psa-mid-card';

    if(psa >= 1500){
      level = 'wide';
      main = 'Reserva estimada amplia';
      soft = 'Existe mayor margen matemático antes de llegar al Hto objetivo, pero el contexto clínico puede adelantar la indicación de transfusión.';
      cardClass = 'psa-ok-card';
    } else if(psa < 700){
      level = 'low';
      main = 'Baja tolerancia estimada';
      soft = 'Pérdidas relativamente pequeñas pueden llevar al Hto objetivo. Conviene anticipar estrategia de reposición y disponibilidad de sangre.';
      cardClass = 'psa-danger-card';
    }

    if(ratio !== null && ratio >= 1){
      main = 'Umbral alcanzado o superado';
      soft = 'La pérdida actual iguala o supera la PSA estimada. Reevalúa perfusión, Hb/Hto, velocidad del sangrado y necesidad de hemocomponentes.';
      cardClass = 'psa-danger-card';
    } else if(ratio !== null && ratio >= 0.7){
      main = 'Cerca del umbral estimado';
      soft = 'La pérdida actual se acerca a la PSA. Recontrola laboratorio y anticipa hemocomponentes si el sangrado continúa.';
      cardClass = 'psa-mid-card';
    }

    document.getElementById('psaCard').className = 'note-result-card ' + cardClass;
    setText('interpMain', main);
    setText('interpSoft', soft);
    setText('summaryNarrative', 'Peso ' + fmt(peso,1) + ' kg, volemia ' + fmt(volemiaKg,0) + ' mL/kg, Hto ' + fmt(htoI,1) + '% → ' + fmt(htoF,1) + '%. PSA estimada: ' + fmt(psa,0) + ' mL.');
    setText('replacementText', 'En sangrado inicial estable, comenzar con cristaloides balanceados y reevaluación. Evitar sobrecarga y hemodilución excesiva.');
    setText('escalationText', 'Escalar si hay sangrado rápido, inestabilidad, mala perfusión, Hb/Hto crítico, cardiopatía, sepsis, cirugía mayor o baja tolerancia a anemia.');

    renderActions(level, ratio);
  }

  ['peso','htoInicial','htoObjetivo','perdidaActual'].forEach(function(id){
    document.getElementById(id).addEventListener('input', updatePSA);
  });

  document.querySelectorAll('input[name="volemiaTipo"]').forEach(function(input){
    input.addEventListener('change', updatePSA);
  });

  updatePSA();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php include("footer.php"); ?>
