<?php
$titulo_pagina = "Hiperkalemia";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Algoritmo interactivo para evaluación y manejo inicial de hiperkalemia perioperatoria. Integra valor de potasio, ECG, severidad clínica y necesidad de estabilización de membrana, redistribución y eliminación.";
$formula = "Clasificación orientativa: leve 5,0–5,9 mEq/L; moderada 6,0–6,5 mEq/L; severa >6,5 mEq/L. ECG alterado o inestabilidad clínica obligan a manejo como hiperkalemia severa independiente del valor absoluto.";
$referencias = array(
  "Weiner ID, Wingo CS. Hyperkalemia: a potential silent killer. J Am Soc Nephrol. 1998.",
  "American Heart Association. Guidelines for Emergency Cardiovascular Care: management of hyperkalemia in cardiac arrest and peri-arrest states.",
  "KDIGO clinical practice guidance and reviews on acute hyperkalemia management.",
  "Guías y revisiones clínicas sobre manejo agudo de hiperkalemia perioperatoria."
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
          .hk-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .hk-choice-grid.hk-grid-3{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }

          .hk-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .hk-option{
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

          .hk-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .hk-option-input:checked + .hk-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .hk-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .hk-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .hk-action-list{
            display:grid;
            gap:.75rem;
          }

          .hk-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .hk-action-mark{
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

          .hk-action-mark.ok{background:#2ea663;}
          .hk-action-mark.mid{background:#f4c542;}
          .hk-action-mark.high{background:#d92d20;}

          .hk-action-copy{min-width:0;flex:1;}

          .hk-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .hk-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .hk-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .hk-plan-line:last-child{
            margin-bottom:0;
          }

          .hk-drug{
            display:inline-block;
            padding:.22rem .48rem;
            border-radius:.6rem;
            font-weight:800;
            border:1px solid rgba(31,42,55,.12);
            line-height:1.1;
            color:#111827;
            background:var(--drug-other);
          }

          .hk-drug-warning{
            background:#fff9e8;
          }

          .hk-drug-danger{
            background:#fff1f1;
          }

          .hk-drug-glucose{
            background:#fff2b8;
          }

          .hk-drug-vent{
            background:#dff2ff;
          }

          .hk-severity-low{
            background:#edf8f1;
            border-color:#b7ddc3;
          }

          .hk-severity-mid{
            background:#fff9e8;
            border-color:#ead38a;
          }

          .hk-severity-high{
            background:#fff1f1;
            border-color:#efc0bd;
          }

          .hk-table-wrap{
            overflow-x:auto;
          }

          .hk-table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            overflow:hidden;
          }

          .hk-table th,
          .hk-table td{
            padding:.58rem .62rem;
            border-bottom:1px solid #eef2f6;
            border-right:1px solid #eef2f6;
            vertical-align:top;
            text-align:left;
            font-size:.88rem;
            line-height:1.28;
          }

          .hk-table th{
            background:#3559b7;
            color:#fff;
            font-size:.76rem;
            font-weight:800;
            line-height:1.2;
          }

          .hk-table th:last-child,
          .hk-table td:last-child{
            border-right:none;
          }

          .hk-table tr:last-child td{
            border-bottom:none;
          }

          .hk-table td:first-child{
            font-weight:800;
            color:var(--note-text);
            width:28%;
          }

          @media (max-width:768px){
            .hk-choice-grid,
            .hk-choice-grid.hk-grid-3{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .hk-choice-grid,
            .hk-choice-grid.hk-grid-3{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ELECTROLITOS · URGENCIA PERIOPERATORIA</div>
          <h2>Hiperkalemia</h2>
          <div class="note-hero-subtitle">Clasifica severidad, identifica criterios de manejo urgente y organiza el tratamiento por estabilización, redistribución y eliminación.</div>
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
            <div class="note-section-label">Evaluación inicial</div>

            <div class="note-input-group mb-3">
              <label class="note-label">Potasio plasmático</label>
              <div class="note-input-inline">
                <input id="kInput" type="text" inputmode="decimal" class="note-input">
                <div class="note-input-unit">mEq/L</div>
              </div>
            </div>

            <div class="note-section-label">ECG / clínica</div>
            <div class="hk-choice-grid hk-grid-3 mb-3">
              <label>
                <input class="hk-option-input" type="radio" name="ecgStatus" value="normal" checked>
                <div class="hk-option">
                  <i class="fa-solid fa-wave-square"></i>
                  <div class="hk-option-title">ECG normal</div>
                  <div class="hk-option-sub">Sin cambios sugerentes</div>
                </div>
              </label>
              <label>
                <input class="hk-option-input" type="radio" name="ecgStatus" value="altered">
                <div class="hk-option">
                  <i class="fa-solid fa-heart-pulse"></i>
                  <div class="hk-option-title">ECG alterado</div>
                  <div class="hk-option-sub">T picudas, QRS ancho, arritmia</div>
                </div>
              </label>
              <label>
                <input class="hk-option-input" type="radio" name="ecgStatus" value="unstable">
                <div class="hk-option">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                  <div class="hk-option-title">Inestable</div>
                  <div class="hk-option-sub">Arritmia / compromiso vital</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Contexto renal</div>
            <div class="hk-choice-grid">
              <label>
                <input class="hk-option-input" type="radio" name="renalStatus" value="ok" checked>
                <div class="hk-option">
                  <div class="hk-option-title">Función renal conservada</div>
                  <div class="hk-option-sub">Eliminación posible</div>
                </div>
              </label>
              <label>
                <input class="hk-option-input" type="radio" name="renalStatus" value="risk">
                <div class="hk-option">
                  <div class="hk-option-title">Falla renal / oliguria</div>
                  <div class="hk-option-sub">Bajo umbral para diálisis</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa potasio y contexto clínico para orientar severidad y manejo.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Potasio</div>
              <div id="summaryK" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Severidad</div>
              <div id="summarySeverity" class="note-summary-v">Pendiente</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">ECG / clínica</div>
              <div id="summaryEcg" class="note-summary-v">ECG normal</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Estrategia</div>
              <div id="summaryStrategy" class="note-summary-v">Pendiente</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="severityCard" class="note-result-card">
            <div class="note-result-card-label">Clasificación</div>
            <div id="severityMain" class="note-result-card-value">-</div>
            <div id="severityText" class="note-result-card-note">Ingresa potasio plasmático.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Prioridad</div>
            <div id="priorityMain" class="note-result-card-value">-</div>
            <div id="priorityText" class="note-result-card-note">Depende de ECG, severidad y contexto.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Conducta sugerida</div>
          <div id="algoMain" class="note-interpretation-main">Pendiente</div>
          <div id="algoSoft" class="note-interpretation-soft">Completa la evaluación inicial para organizar el manejo.</div>

          <div id="treatmentPlan" class="mt-3 text-start">
            <div class="hk-plan-line"><strong>1. Confirmar / detener aporte:</strong> <span id="planConfirm">Revisar muestra, suspender K exógeno y buscar causa.</span></div>
            <div class="hk-plan-line"><strong>2. Estabilizar membrana:</strong> <span id="planCalcium">Según ECG / severidad.</span></div>
            <div class="hk-plan-line"><strong>3. Redistribuir:</strong> <span id="planShift">Según severidad.</span></div>
            <div class="hk-plan-line"><strong>4. Eliminar potasio:</strong> <span id="planRemove">Según función renal y recurrencia.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">Puede existir hiperkalemia grave con ECG normal. El ECG alterado o la inestabilidad obligan a tratamiento urgente, no a esperar una nueva muestra.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="hk-action-list">
              <div class="hk-action-item">
                <div class="hk-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="hk-action-copy">
                  <div class="hk-action-title">Completa potasio y ECG</div>
                  <p class="hk-action-note">La severidad bioquímica no reemplaza la evaluación electrocardiográfica y clínica.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Dosis y medidas frecuentes</div>
            <div class="hk-table-wrap">
              <table class="hk-table">
                <thead>
                  <tr>
                    <th>Objetivo</th>
                    <th>Medida</th>
                    <th>Dosis orientativa</th>
                    <th>Comentario</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Estabilizar membrana</td>
                    <td><span class="hk-drug hk-drug-danger">Gluconato de calcio 10%</span></td>
                    <td>10 mL EV en 5–10 min</td>
                    <td>Inicio inmediato. Repetir si persisten cambios ECG. No baja el K.</td>
                  </tr>
                  <tr>
                    <td>Redistribución</td>
                    <td><span class="hk-drug hk-drug-glucose">Insulina + glucosa</span></td>
                    <td>10 U insulina regular + glucosa EV</td>
                    <td>Controlar glicemia. Riesgo de hipoglicemia tardía.</td>
                  </tr>
                  <tr>
                    <td>Redistribución</td>
                    <td><span class="hk-drug hk-drug-vent">Salbutamol</span></td>
                    <td>10–20 mg nebulizado</td>
                    <td>Puede ser adyuvante. Inicio ~30 min. Vigilar taquicardia.</td>
                  </tr>
                  <tr>
                    <td>Acidosis asociada</td>
                    <td><span class="hk-drug">Bicarbonato</span></td>
                    <td>Considerar si acidosis metabólica significativa</td>
                    <td>No usar como medida única. Riesgo de sobrecarga y alcalosis.</td>
                  </tr>
                  <tr>
                    <td>Eliminación renal</td>
                    <td><span class="hk-drug">Furosemida</span></td>
                    <td>40–80 mg EV en adultos, si diuresis posible</td>
                    <td>No útil si anuria. Vigilar volemia y respuesta.</td>
                  </tr>
                  <tr>
                    <td>Eliminación definitiva</td>
                    <td><span class="hk-drug hk-drug-warning">Hemodiálisis</span></td>
                    <td>Considerar precozmente</td>
                    <td>Severa, refractaria, falla renal, rebote o sobrecarga.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Calcio protege el corazón; insulina mueve potasio; diálisis elimina potasio</div>
          <div class="note-tips"><strong>Qué hacer:</strong> separa el manejo en estabilización de membrana, redistribución y eliminación. Monitoriza ECG, K seriado y glicemia.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> asumir que un ECG normal descarta riesgo, o creer que el calcio corrige el potasio plasmático.</div>
          <div class="note-tips"><strong>Perla:</strong> si hay ECG alterado, el primer problema no es “cuánto K tiene”, sino estabilizar la membrana miocárdica.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si el paciente tiene falla renal o hiperkalemia refractaria, piensa temprano en diálisis.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const kInput = document.getElementById('kInput');

  function parseLocal(value){
    if(CNS && typeof CNS.parseDecimal === 'function') return CNS.parseDecimal(value);
    const n = Number(String(value || '').replace(',', '.'));
    return Number.isFinite(n) ? n : null;
  }

  function fmt(value, decimals){
    if(!Number.isFinite(value)) return '-';
    if(CNS && typeof CNS.formatNumber === 'function') return CNS.formatNumber(value, decimals);
    return Number(value).toLocaleString('es-CL', {maximumFractionDigits: decimals});
  }

  function getSelected(name){
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? selected.value : null;
  }

  function ecgLabel(value){
    if(value === 'altered') return 'ECG alterado';
    if(value === 'unstable') return 'Inestable';
    return 'ECG normal';
  }

  function classifyK(k){
    if(!k || k <= 0) return {level:'pending', label:'Pendiente', short:'Pendiente', css:'', text:'Ingresa potasio plasmático.'};
    if(k < 5.0) return {level:'normal', label:'No hiperkalemia', short:'No hiperkalemia', css:'hk-severity-low', text:'Valor bajo el umbral de hiperkalemia.'};
    if(k < 6.0) return {level:'mild', label:'Hiperkalemia leve', short:'Leve', css:'hk-severity-low', text:'5,0–5,9 mEq/L.'};
    if(k <= 6.5) return {level:'moderate', label:'Hiperkalemia moderada', short:'Moderada', css:'hk-severity-mid', text:'6,0–6,5 mEq/L.'};
    return {level:'severe', label:'Hiperkalemia severa', short:'Severa', css:'hk-severity-high', text:'>6,5 mEq/L.'};
  }

  function renderActions(level){
    const box = document.getElementById('actionList');
    let items = [];

    if(level === 'pending'){
      items = [
        ['mid','Completa potasio y ECG','La severidad bioquímica no reemplaza la evaluación electrocardiográfica y clínica.']
      ];
    } else if(level === 'confirm'){
      items = [
        ['ok','Confirmar y buscar causa','Revisar pseudohiperkalemia, hemólisis, fármacos, falla renal, acidosis y aporte exógeno de K.'],
        ['ok','Monitorizar según contexto','Si el paciente está estable y K <5,0, no activar manejo de hiperkalemia.']
      ];
    } else if(level === 'mild'){
      items = [
        ['ok','Suspender aporte exógeno de K','Detener soluciones, suplementos o fármacos que aumenten potasio si corresponde.'],
        ['ok','Confirmar muestra y seguimiento','Repetir K si sospecha de hemólisis o error preanalítico. Monitorizar ECG según contexto.']
      ];
    } else if(level === 'moderate'){
      items = [
        ['mid','Redistribuir si hay riesgo o tendencia ascendente','Insulina + glucosa y salbutamol según contexto clínico, especialmente si se acerca a 6,5.'],
        ['mid','Plan de eliminación','Furosemida si diuresis posible; considerar bicarbonato si acidosis significativa; bajo umbral para diálisis si falla renal.']
      ];
    } else {
      items = [
        ['high','Estabilizar membrana si ECG alterado o inestable','Gluconato de calcio 10% 10 mL EV en 5–10 min. Repetir si persisten cambios ECG.'],
        ['high','Redistribuir de inmediato','Insulina + glucosa y salbutamol nebulizado como medidas temporales. Controlar glicemia seriada.'],
        ['high','Eliminar potasio','Buscar eliminación definitiva. Considerar diálisis precoz si severa, refractaria, falla renal, rebote o sobrecarga.']
      ];
    }

    box.innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="hk-action-item">' +
        '<div class="hk-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="hk-action-copy">' +
          '<div class="hk-action-title">' + item[1] + '</div>' +
          '<p class="hk-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateHK(){
    const k = parseLocal(kInput.value);
    const ecg = getSelected('ecgStatus') || 'normal';
    const renal = getSelected('renalStatus') || 'ok';
    const kClass = classifyK(k);

    const forcedSevere = ecg === 'altered' || ecg === 'unstable';
    let management = kClass.level;

    if(forcedSevere && k && k >= 5.0) management = 'severe';
    if(renal === 'risk' && management === 'moderate') management = 'severe';

    document.getElementById('summaryK').textContent = k && k > 0 ? fmt(k,1) + ' mEq/L' : '-';
    document.getElementById('summaryEcg').textContent = ecgLabel(ecg);
    document.getElementById('summarySeverity').textContent = kClass.short;
    document.getElementById('severityMain').textContent = kClass.label;
    document.getElementById('severityText').textContent = kClass.text;

    const severityCard = document.getElementById('severityCard');
    severityCard.className = 'note-result-card ' + kClass.css;

    if(!k || k <= 0){
      document.getElementById('summaryNarrative').textContent = 'Ingresa potasio y contexto clínico para orientar severidad y manejo.';
      document.getElementById('summaryStrategy').textContent = 'Pendiente';
      document.getElementById('priorityMain').textContent = '-';
      document.getElementById('priorityText').textContent = 'Depende de ECG, severidad y contexto.';
      document.getElementById('algoMain').textContent = 'Pendiente';
      document.getElementById('algoSoft').textContent = 'Completa la evaluación inicial para organizar el manejo.';
      document.getElementById('planCalcium').textContent = 'Según ECG / severidad.';
      document.getElementById('planShift').textContent = 'Según severidad.';
      document.getElementById('planRemove').textContent = 'Según función renal y recurrencia.';
      renderActions('pending');
      return;
    }

    if(k < 5.0 && ecg === 'normal'){
      document.getElementById('summaryNarrative').textContent = 'K ' + fmt(k,1) + ' mEq/L, ECG normal. No corresponde a hiperkalemia según umbral habitual.';
      document.getElementById('summaryStrategy').textContent = 'Confirmar contexto';
      document.getElementById('priorityMain').textContent = 'Baja';
      document.getElementById('priorityText').textContent = 'No activar algoritmo salvo sospecha clínica específica.';
      document.getElementById('algoMain').textContent = 'No hiperkalemia';
      document.getElementById('algoSoft').textContent = 'Revisar contexto, tendencia y causa si el valor no calza con el cuadro clínico.';
      document.getElementById('planCalcium').textContent = 'No indicado por este valor.';
      document.getElementById('planShift').textContent = 'No indicado por este valor.';
      document.getElementById('planRemove').textContent = 'No indicado por este valor.';
      renderActions('confirm');
      return;
    }

    if(management === 'mild' || management === 'normal'){
      document.getElementById('summaryNarrative').textContent = 'K ' + fmt(k,1) + ' mEq/L, ' + ecgLabel(ecg).toLowerCase() + '. Manejo conservador con confirmación, suspensión de K y monitorización.';
      document.getElementById('summaryStrategy').textContent = 'Conservador';
      document.getElementById('priorityMain').textContent = 'Baja / moderada';
      document.getElementById('priorityText').textContent = 'Confirmar muestra, suspender aporte y buscar causa.';
      document.getElementById('algoMain').textContent = 'Manejo conservador';
      document.getElementById('algoSoft').textContent = 'Confirmar pseudohiperkalemia, detener aporte de K y monitorizar tendencia.';
      document.getElementById('planCalcium').textContent = 'No de rutina si ECG normal y paciente estable.';
      document.getElementById('planShift').textContent = 'No de rutina; considerar si tendencia ascendente o contexto de riesgo.';
      document.getElementById('planRemove').textContent = 'Corregir causa; eliminación farmacológica según contexto.';
      renderActions('mild');
      return;
    }

    if(management === 'moderate'){
      document.getElementById('summaryNarrative').textContent = 'K ' + fmt(k,1) + ' mEq/L, ' + ecgLabel(ecg).toLowerCase() + '. Hiperkalemia moderada: redistribución y plan de eliminación según contexto.';
      document.getElementById('summaryStrategy').textContent = 'Redistribuir + eliminar';
      document.getElementById('priorityMain').textContent = 'Intermedia';
      document.getElementById('priorityText').textContent = 'No esperar a que sea severa si hay tendencia ascendente o alto riesgo.';
      document.getElementById('algoMain').textContent = 'Manejo moderado';
      document.getElementById('algoSoft').textContent = 'Redistribuir potasio y planificar eliminación. Monitorizar ECG, K y glicemia.';
      document.getElementById('planCalcium').textContent = 'No de rutina si ECG normal; usar si aparecen cambios ECG.';
      document.getElementById('planShift').innerHTML = '<span class="hk-drug hk-drug-glucose">Insulina + glucosa</span> y <span class="hk-drug hk-drug-vent">salbutamol</span> según riesgo.';
      document.getElementById('planRemove').textContent = renal === 'risk' ? 'Bajo umbral para diálisis.' : 'Furosemida si diuresis; tratar causa; considerar diálisis si refractaria.';
      renderActions('moderate');
      return;
    }

    document.getElementById('summaryNarrative').textContent = 'K ' + fmt(k,1) + ' mEq/L, ' + ecgLabel(ecg).toLowerCase() + '. Manejar como hiperkalemia severa/alto riesgo.';
    document.getElementById('summaryStrategy').textContent = 'Manejo urgente';
    document.getElementById('priorityMain').textContent = 'Alta';
    document.getElementById('priorityText').textContent = forcedSevere ? 'ECG alterado/inestabilidad: estabilizar membrana de inmediato.' : 'K severo o contexto renal de alto riesgo.';
    document.getElementById('algoMain').textContent = 'Manejo urgente';
    document.getElementById('algoSoft').textContent = 'Estabilizar membrana si ECG alterado o inestabilidad, redistribuir potasio y buscar eliminación definitiva.';
    document.getElementById('planCalcium').innerHTML = '<span class="hk-drug hk-drug-danger">Gluconato de calcio 10%</span> 10 mL EV en 5–10 min si ECG alterado/inestable; repetir si persiste.';
    document.getElementById('planShift').innerHTML = '<span class="hk-drug hk-drug-glucose">Insulina + glucosa</span> + <span class="hk-drug hk-drug-vent">salbutamol</span>. Controlar glicemia.';
    document.getElementById('planRemove').innerHTML = renal === 'risk'
      ? '<span class="hk-drug hk-drug-warning">Hemodiálisis precoz</span> si falla renal, refractaria, rebote o sobrecarga.'
      : 'Furosemida si diuresis posible; considerar diálisis si refractaria o severa persistente.';
    renderActions('severe');
  }

  kInput.addEventListener('input', updateHK);
  document.querySelectorAll('input[name="ecgStatus"], input[name="renalStatus"]').forEach(function(input){
    input.addEventListener('change', updateHK);
  });

  updateHK();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
