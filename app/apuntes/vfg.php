<?php
$titulo_pagina = "Velocidad de Filtración Glomerular";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Herramienta docente para estimar función renal perioperatoria con Cockcroft-Gault y MDRD. Útil para ajustar fármacos, anticipar acumulación, identificar riesgo renal y evitar interpretar creatinina aislada como función renal normal.";
$formula = "Cockcroft-Gault: CrCl = ((140 - edad) × peso kg) / (72 × creatinina mg/dL); multiplicar por 0,85 en mujer. MDRD: eGFR = 175 × creatinina^-1,154 × edad^-0,203; multiplicar por 0,742 en mujer. Cockcroft entrega mL/min; MDRD entrega mL/min/1,73 m².";
$referencias = array(
  "Cockcroft DW, Gault MH. Prediction of creatinine clearance from serum creatinine. Nephron. 1976;16(1):31-41.",
  "Levey AS, Bosch JP, Lewis JB, Greene T, Rogers N, Roth D. A more accurate method to estimate glomerular filtration rate from serum creatinine: a new prediction equation. Ann Intern Med. 1999;130(6):461-470.",
  "Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.",
  "Miller RD. Miller's Anesthesia. Perioperative renal function and drug dosing considerations."
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
          .vfg-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .vfg-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .vfg-option{
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

          .vfg-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .vfg-option-input:checked + .vfg-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .vfg-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .vfg-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .vfg-method-note{
            border:1px solid var(--note-line);
            border-radius:1rem;
            background:var(--note-soft);
            padding:.85rem .95rem;
          }

          .vfg-result-low{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .vfg-result-mid{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .vfg-result-high{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          .vfg-action-list{
            display:grid;
            gap:.75rem;
          }

          .vfg-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .vfg-action-mark{
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

          .vfg-action-mark.ok{background:#2ea663;}
          .vfg-action-mark.mid{background:#f4c542;}
          .vfg-action-mark.high{background:#d92d20;}

          .vfg-action-copy{min-width:0;flex:1;}

          .vfg-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .vfg-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .vfg-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .vfg-plan-line:last-child{
            margin-bottom:0;
          }

          @media (max-width:768px){
            .vfg-choice-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .vfg-choice-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · FUNCIÓN RENAL · DOSIS DE FÁRMACOS</div>
          <h2>Velocidad de Filtración Glomerular</h2>
          <div class="note-hero-subtitle">Estima función renal con Cockcroft-Gault o MDRD e interpreta su impacto perioperatorio.</div>
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
              <b>Fórmulas:</b><br>
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
                <label class="note-label">Edad</label>
                <div class="note-input-inline">
                  <input id="edadInput" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">años</div>
                </div>
              </div>

              <div id="pesoInputGroup" class="note-input-group">
                <label class="note-label">Peso</label>
                <div class="note-input-inline">
                  <input id="pesoInput" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">kg</div>
                </div>
                <div class="note-result-secondary">Necesario para Cockcroft-Gault.</div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Creatinina plasmática</label>
                <div class="note-input-inline">
                  <input id="creaInput" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mg/dL</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Método seleccionado</label>
                <div id="methodNote" class="note-result-secondary">
                  Cockcroft-Gault estima clearance en mL/min y usa peso.
                </div>
              </div>
            </div>

            <div class="note-section-label">Método</div>
            <div class="vfg-choice-grid mb-3">
              <label>
                <input class="vfg-option-input" type="radio" name="metodo" value="cg" checked>
                <div class="vfg-option">
                  <i class="fa-solid fa-scale-balanced"></i>
                  <div class="vfg-option-title">Cockcroft-Gault</div>
                  <div class="vfg-option-sub">mL/min · usa peso</div>
                </div>
              </label>

              <label>
                <input class="vfg-option-input" type="radio" name="metodo" value="mdrd">
                <div class="vfg-option">
                  <i class="fa-solid fa-flask"></i>
                  <div class="vfg-option-title">MDRD</div>
                  <div class="vfg-option-sub">mL/min/1,73 m²</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Sexo</div>
            <div class="vfg-choice-grid">
              <label>
                <input class="vfg-option-input" type="radio" name="sexo" value="hombre" checked>
                <div class="vfg-option">
                  <i class="fa-solid fa-person"></i>
                  <div class="vfg-option-title">Hombre</div>
                  <div id="maleFactor" class="vfg-option-sub">factor 1,0</div>
                </div>
              </label>

              <label>
                <input class="vfg-option-input" type="radio" name="sexo" value="mujer">
                <div class="vfg-option">
                  <i class="fa-solid fa-person-dress"></i>
                  <div class="vfg-option-title">Mujer</div>
                  <div id="femaleFactor" class="vfg-option-sub">factor 0,85</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa edad, creatinina y peso si usas Cockcroft-Gault.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Método</div>
              <div id="summaryMethod" class="note-summary-v">Cockcroft-Gault</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Paciente</div>
              <div id="summaryPatient" class="note-summary-v">Hombre · - años</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Creatinina</div>
              <div id="summaryCreat" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Peso usado</div>
              <div id="summaryWeight" class="note-summary-v">-</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="gfrCard" class="note-result-card">
            <div class="note-result-card-label">Resultado estimado</div>
            <div id="gfrValue" class="note-result-card-value">-</div>
            <div id="gfrUnit" class="note-result-card-note">Completa los datos.</div>
          </div>
          <div id="stageCard" class="note-result-card">
            <div class="note-result-card-label">Lectura renal</div>
            <div id="stageValue" class="note-result-card-value">Pendiente</div>
            <div id="stageNote" class="note-result-card-note">La interpretación depende del contexto clínico y de la tendencia.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación perioperatoria</div>
          <div id="interpMain" class="note-interpretation-main">Pendiente</div>
          <div id="interpSoft" class="note-interpretation-soft">Completa los campos para estimar función renal y orientar ajuste de fármacos.</div>

          <div class="mt-3 text-start">
            <div class="vfg-plan-line"><strong>Fórmula aplicada:</strong> <span id="formulaApplied">-</span></div>
            <div class="vfg-plan-line"><strong>Uso práctico:</strong> <span id="clinicalUse">Ajustar fármacos y evaluar riesgo renal con la historia completa.</span></div>
            <div class="vfg-plan-line"><strong>Limitación:</strong> <span id="limitationText">Las ecuaciones son estimaciones y pueden ser engañosas en lesión renal aguda, caquexia, embarazo, extremos de edad o masa muscular muy alterada.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">La creatinina aislada puede parecer “normal” en adultos mayores o pacientes con baja masa muscular. Revisa tendencia, diuresis, potasio, ácido-base, volemia y nefrotóxicos.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="vfg-action-list">
              <div class="vfg-action-item">
                <div class="vfg-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="vfg-action-copy">
                  <div class="vfg-action-title">Completa datos de entrada</div>
                  <p class="vfg-action-note">Cockcroft-Gault requiere edad, peso, creatinina y sexo; MDRD requiere edad, creatinina y sexo.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">La creatinina aislada puede subestimar el problema renal</div>
          <div class="note-tips"><strong>Qué hacer:</strong> revisar tendencia de creatinina, diuresis, potasio, bicarbonato, volemia, nefrotóxicos y contexto clínico completo.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> concluir “riñón normal” solo porque la creatinina cae dentro del rango de laboratorio.</div>
          <div class="note-tips"><strong>Fármacos:</strong> ajustar o vigilar opioides, antibióticos, anticoagulantes, relajantes neuromusculares y coadyuvantes con eliminación renal.</div>
          <div class="note-tips"><strong>Cockcroft-Gault:</strong> suele ser más útil para dosificación de fármacos porque estima clearance en mL/min y usa peso.</div>
          <div class="note-tips"><strong>MDRD:</strong> entrega eGFR normalizada a 1,73 m²; sirve como estimación poblacional, no como verdad absoluta en el paciente agudo.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si el caso “huele a renal”, compórtate como renal hasta demostrar lo contrario.</div>
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
    return Number(value).toLocaleString('es-CL', {maximumFractionDigits:decimals});
  }

  function setText(id, value){
    const el = document.getElementById(id);
    if(CNS.safeSetText) CNS.safeSetText(el, value);
    else if(el) el.textContent = value;
  }

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function classifyGFR(value){
    if(!Number.isFinite(value) || value <= 0) return null;

    if(value >= 90){
      return {
        label:'Conservada',
        note:'Función renal conservada o discretamente alterada si hay otros marcadores de daño renal.',
        css:'vfg-result-low',
        level:'ok'
      };
    }

    if(value >= 60){
      return {
        label:'Disminución leve',
        note:'Disminución leve-moderada. Revisar edad, comorbilidades y tendencia.',
        css:'vfg-result-low',
        level:'ok'
      };
    }

    if(value >= 30){
      return {
        label:'Disminución moderada',
        note:'Rango clínicamente relevante para ajuste de fármacos y vigilancia perioperatoria.',
        css:'vfg-result-mid',
        level:'mid'
      };
    }

    if(value >= 15){
      return {
        label:'Disminución severa',
        note:'Alto riesgo de acumulación farmacológica, alteraciones hidroelectrolíticas y complicaciones perioperatorias.',
        css:'vfg-result-high',
        level:'high'
      };
    }

    return {
      label:'Falla renal avanzada',
      note:'Rango de falla renal avanzada o terminal. Requiere planificación perioperatoria cuidadosa.',
      css:'vfg-result-high',
      level:'high'
    };
  }

  function renderActions(level, method, value){
    let items = [];

    if(level === 'pending'){
      items = [
        ['mid','Completa datos de entrada','Cockcroft-Gault requiere edad, peso, creatinina y sexo; MDRD requiere edad, creatinina y sexo.']
      ];
    } else if(level === 'ok'){
      items = [
        ['ok','Función renal relativamente conservada','Aun así revisa tendencia, diuresis, potasio y fármacos de riesgo si el contexto lo sugiere.'],
        ['ok','No sobreactuar por un número aislado','Integra edad, volemia, sepsis, insuficiencia cardíaca y exposición a nefrotóxicos.']
      ];
    } else if(level === 'mid'){
      items = [
        ['mid','Ajustar fármacos relevantes','Revisar dosis e intervalos de fármacos renales, especialmente antibióticos, anticoagulantes y algunos opioides.'],
        ['mid','Vigilar electrolitos y volemia','Potasio, ácido-base, diuresis y balance hídrico importan tanto como el valor calculado.']
      ];
    } else {
      items = [
        ['high','Alto riesgo perioperatorio renal','Planificar fármacos, fluidos, potasio, ácido-base, diuresis y destino postoperatorio.'],
        ['high','Evitar nefrotóxicos y acumulación','Revisar AINEs, contraste, aminoglucósidos, vancomicina, anticoagulantes y relajantes según contexto.']
      ];
    }

    if(method === 'cg' && Number.isFinite(value)){
      items.push(['mid','Cockcroft-Gault para dosis','Útil para ajuste farmacológico, pero depende mucho del peso usado y de la estabilidad de la creatinina.']);
    }

    if(method === 'mdrd' && Number.isFinite(value)){
      items.push(['mid','MDRD está indexado','El resultado es mL/min/1,73 m²; no es exactamente equivalente a clearance absoluto para dosificación.']);
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="vfg-action-item">' +
        '<div class="vfg-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="vfg-action-copy">' +
          '<div class="vfg-action-title">' + item[1] + '</div>' +
          '<p class="vfg-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateMethodUI(){
    const method = getSelected('metodo') || 'cg';
    const pesoGroup = document.getElementById('pesoInputGroup');

    if(method === 'cg'){
      pesoGroup.style.display = '';
      setText('summaryMethod', 'Cockcroft-Gault');
      setText('methodNote', 'Cockcroft-Gault estima clearance en mL/min y usa peso.');
      setText('maleFactor', 'factor 1,0');
      setText('femaleFactor', 'factor 0,85');
    } else {
      pesoGroup.style.display = 'none';
      setText('summaryMethod', 'MDRD');
      setText('methodNote', 'MDRD estima eGFR indexada a 1,73 m²; no usa peso.');
      setText('maleFactor', 'factor 1,0');
      setText('femaleFactor', 'factor 0,742');
    }
  }

  function updateVFG(){
    updateMethodUI();

    const method = getSelected('metodo') || 'cg';
    const sexo = getSelected('sexo') || 'hombre';
    const edad = parseLocal(document.getElementById('edadInput').value);
    const peso = parseLocal(document.getElementById('pesoInput').value);
    const crea = parseLocal(document.getElementById('creaInput').value);

    setText('summaryPatient', (sexo === 'hombre' ? 'Hombre' : 'Mujer') + ' · ' + (edad && edad > 0 ? fmt(edad,0) + ' años' : '- años'));
    setText('summaryCreat', crea && crea > 0 ? fmt(crea,2) + ' mg/dL' : '-');
    setText('summaryWeight', method === 'cg' ? (peso && peso > 0 ? fmt(peso,1) + ' kg' : '-') : 'No usado');

    let valid = false;
    let result = null;
    let unit = '';
    let formula = '-';

    if(method === 'cg'){
      valid = Boolean(edad && edad > 0 && peso && peso > 0 && crea && crea > 0);
      if(valid){
        result = ((140 - edad) * peso) / (72 * crea);
        if(sexo === 'mujer') result *= 0.85;
        unit = 'mL/min';
        formula = '((140 - ' + fmt(edad,0) + ') × ' + fmt(peso,1) + ') / (72 × ' + fmt(crea,2) + ')' + (sexo === 'mujer' ? ' × 0,85' : '');
      }
    } else {
      valid = Boolean(edad && edad > 0 && crea && crea > 0);
      if(valid){
        result = 175 * Math.pow(crea, -1.154) * Math.pow(edad, -0.203);
        if(sexo === 'mujer') result *= 0.742;
        unit = 'mL/min/1,73 m²';
        formula = '175 × ' + fmt(crea,2) + '^-1,154 × ' + fmt(edad,0) + '^-0,203' + (sexo === 'mujer' ? ' × 0,742' : '');
      }
    }

    if(!valid){
      setText('summaryNarrative', method === 'cg' ? 'Ingresa edad, peso y creatinina para calcular Cockcroft-Gault.' : 'Ingresa edad y creatinina para calcular MDRD.');
      setText('gfrValue', '-');
      setText('gfrUnit', 'Completa los datos.');
      setText('stageValue', 'Pendiente');
      setText('stageNote', 'La interpretación depende del contexto clínico y de la tendencia.');
      setText('interpMain', 'Pendiente');
      setText('interpSoft', 'Completa los campos para estimar función renal y orientar ajuste de fármacos.');
      setText('formulaApplied', '-');
      document.getElementById('gfrCard').className = 'note-result-card';
      document.getElementById('stageCard').className = 'note-result-card';
      renderActions('pending', method, null);
      return;
    }

    const cls = classifyGFR(result);

    setText('gfrValue', fmt(result,1));
    setText('gfrUnit', unit);
    setText('stageValue', cls.label);
    setText('stageNote', cls.note);
    setText('interpMain', cls.label);
    setText('interpSoft', cls.note + ' Revisa fármacos, electrolitos, volemia, tendencia y contexto perioperatorio.');
    setText('formulaApplied', formula);
    setText('summaryNarrative', (method === 'cg' ? 'Cockcroft-Gault' : 'MDRD') + ': ' + fmt(result,1) + ' ' + unit + '. Lectura: ' + cls.label + '.');

    document.getElementById('gfrCard').className = 'note-result-card ' + cls.css;
    document.getElementById('stageCard').className = 'note-result-card ' + cls.css;

    renderActions(cls.level, method, result);
  }

  ['edadInput','pesoInput','creaInput'].forEach(function(id){
    document.getElementById(id).addEventListener('input', updateVFG);
  });

  document.querySelectorAll('input[name="metodo"], input[name="sexo"]').forEach(function(input){
    input.addEventListener('change', updateVFG);
  });

  updateVFG();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
