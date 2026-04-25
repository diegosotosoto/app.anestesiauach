<?php
$titulo_pagina = "Hipernatremia";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para apoyo en evaluación y corrección de hipernatremia en contexto perioperatorio adulto. Integra estimación de agua corporal total, déficit de agua libre, meta inicial, velocidad segura de corrección y selector de solución para proponer un plan orientativo.";
$formula = "Déficit de agua libre ≈ ACT × ((Na actual / Na objetivo) - 1). Cambio esperado de Na por litro: (Na de la solución - Na sérico) / (ACT + 1). La corrección debe ser gradual, especialmente si la hipernatremia es crónica o incierta.";
$referencias = array(
  "Sonani B, Al-Dhahir MA. Hypernatremia. StatPearls. Actualización 2023.",
  "Yun G, Baek SH, Kim S. Evaluation and management of hypernatremia in adults: clinical perspectives. Korean J Intern Med. 2023;38(3):290-302.",
  "Lewis JL III. Hypernatremia. Merck Manual Professional Edition. Revisado 2025.",
  "Leung AA, McAlister FA, Finlayson SRG, Bates DW. Preoperative hypernatremia predicts increased perioperative morbidity and mortality. Am J Med. 2013;126(10):877-886.",
  "Cole JH, Highland KB, Hughey SB, et al. The Association Between Borderline Dysnatremia and Perioperative Morbidity and Mortality. JMIR Perioper Med. 2023.",
  "Pokhriyal SC, Joshi P, Gupta U, et al. Hypernatremia and Its Rate of Correction: The Evidence So Far. Cureus. 2024;16(2):e54699.",
  "Goshima T, Terasawa T, Iwata M, et al. Treatment of acute hypernatremia caused by sodium overload in adults: A systematic review. Medicine. 2022;101(8):e28945."
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
          .hna-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .hna-choice-grid.hna-grid-3{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }

          .hna-choice-grid.hna-grid-4{
            grid-template-columns:repeat(4,minmax(0,1fr));
          }

          .hna-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .hna-option{
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

          .hna-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .hna-option-input:checked + .hna-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .hna-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .hna-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .hna-action-list{
            display:grid;
            gap:.75rem;
          }

          .hna-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .hna-action-mark{
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

          .hna-action-mark.ok{background:#2ea663;}
          .hna-action-mark.mid{background:#f4c542;}
          .hna-action-mark.high{background:#d92d20;}

          .hna-action-copy{min-width:0;flex:1;}

          .hna-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .hna-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .hna-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .hna-plan-line:last-child{
            margin-bottom:0;
          }

          .hna-solution-badge{
            display:inline-block;
            padding:.22rem .48rem;
            border-radius:.6rem;
            font-weight:800;
            border:1px solid rgba(31,42,55,.12);
            line-height:1.1;
            color:#111827;
            background:#fff;
          }

          .hna-water{background:#dff2ff;}
          .hna-half{background:#eef4ff;}
          .hna-iso{background:#fff9e8;}
          .hna-danger-card{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          .hna-mid-card{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .hna-ok-card{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          @media (max-width:992px){
            .hna-choice-grid.hna-grid-4{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:768px){
            .hna-choice-grid,
            .hna-choice-grid.hna-grid-3,
            .hna-choice-grid.hna-grid-4{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .hna-choice-grid,
            .hna-choice-grid.hna-grid-3,
            .hna-choice-grid.hna-grid-4{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ELECTROLITOS · FLUIDOTERAPIA</div>
          <h2>Corrección de hipernatremia</h2>
          <div class="note-hero-subtitle">Estima déficit de agua libre, meta inicial segura y velocidad orientativa de corrección en adultos.</div>
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
                <label class="note-label">Natremia actual</label>
                <div class="note-input-inline">
                  <input id="naActual" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mEq/L</div>
                </div>
              </div>
            </div>

            <div class="note-section-label">ACT estimada</div>
            <div class="hna-choice-grid mb-3">
              <label>
                <input class="hna-option-input" type="radio" name="tbwgrp" value="0.5" checked>
                <div class="hna-option">
                  <i class="fa-solid fa-person-dress"></i>
                  <div class="hna-option-title">Mujer adulta</div>
                  <div class="hna-option-sub">ACT 50%</div>
                </div>
              </label>
              <label>
                <input class="hna-option-input" type="radio" name="tbwgrp" value="0.6">
                <div class="hna-option">
                  <i class="fa-solid fa-person"></i>
                  <div class="hna-option-title">Hombre adulto</div>
                  <div class="hna-option-sub">ACT 60%</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Contexto clínico dominante</div>
            <div class="hna-choice-grid hna-grid-3 mb-3">
              <label>
                <input class="hna-option-input" type="radio" name="contexto" value="hipovolemico" checked>
                <div class="hna-option">
                  <i class="fa-solid fa-droplet-slash"></i>
                  <div class="hna-option-title">Hipovolémico</div>
                  <div class="hna-option-sub">pérdida de agua</div>
                </div>
              </label>
              <label>
                <input class="hna-option-input" type="radio" name="contexto" value="euvolemico">
                <div class="hna-option">
                  <i class="fa-solid fa-scale-balanced"></i>
                  <div class="hna-option-title">Euvolémico</div>
                  <div class="hna-option-sub">DI / pérdidas libres</div>
                </div>
              </label>
              <label>
                <input class="hna-option-input" type="radio" name="contexto" value="hipervolemico">
                <div class="hna-option">
                  <i class="fa-solid fa-water"></i>
                  <div class="hna-option-title">Hipervolémico</div>
                  <div class="hna-option-sub">exceso de sodio</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Duración probable</div>
            <div class="hna-choice-grid">
              <label>
                <input class="hna-option-input" type="radio" name="cronologia" value="aguda">
                <div class="hna-option">
                  <i class="fa-solid fa-bolt"></i>
                  <div class="hna-option-title">Aguda</div>
                  <div class="hna-option-sub">&lt;48 h</div>
                </div>
              </label>
              <label>
                <input class="hna-option-input" type="radio" name="cronologia" value="cronica" checked>
                <div class="hna-option">
                  <i class="fa-solid fa-hourglass-half"></i>
                  <div class="hna-option-title">Crónica / incierta</div>
                  <div class="hna-option-sub">corregir lento</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Solución seleccionada</div>
            <div class="hna-choice-grid hna-grid-4">
              <label>
                <input class="hna-option-input" type="radio" name="solucion" id="sol_d5w" value="0" checked>
                <div class="hna-option">
                  <i class="fa-solid fa-flask-vial"></i>
                  <div class="hna-option-title">Dextrosa 5%</div>
                  <div class="hna-option-sub">Na 0 mEq/L</div>
                </div>
              </label>
              <label>
                <input class="hna-option-input" type="radio" name="solucion" id="sol_half" value="77">
                <div class="hna-option">
                  <i class="fa-solid fa-prescription-bottle-medical"></i>
                  <div class="hna-option-title">NaCl 0,45%</div>
                  <div class="hna-option-sub">Na 77 mEq/L</div>
                </div>
              </label>
              <label>
                <input class="hna-option-input" type="radio" name="solucion" id="sol_iso" value="154">
                <div class="hna-option">
                  <i class="fa-solid fa-kit-medical"></i>
                  <div class="hna-option-title">Isotónico</div>
                  <div class="hna-option-sub">Na 154 mEq/L</div>
                </div>
              </label>
              <label>
                <input class="hna-option-input" type="radio" name="solucion" id="sol_enteral" value="0">
                <div class="hna-option">
                  <i class="fa-solid fa-glass-water"></i>
                  <div class="hna-option-title">Agua enteral/VO</div>
                  <div class="hna-option-sub">agua libre</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso y natremia para estimar déficit de agua libre y velocidad orientativa.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Peso / ACT</div>
              <div id="sumPesoAct" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Na actual</div>
              <div id="sumNa" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Contexto</div>
              <div id="sumContexto" class="note-summary-v">Hipovolémico</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Solución</div>
              <div id="sumSol" class="note-summary-v">Dextrosa 5%</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="naSeverityCard" class="note-result-card">
            <div class="note-result-card-label">Severidad</div>
            <div id="severityMain" class="note-result-card-value">-</div>
            <div id="severityText" class="note-result-card-note">Ingresa natremia actual.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Déficit de agua libre</div>
            <div id="outDeficit" class="note-result-card-value">-</div>
            <div id="deficitNote" class="note-result-card-note">Cálculo orientativo según meta inicial.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Plan orientativo</div>
          <div id="mainDecision" class="note-interpretation-main">Pendiente</div>
          <div id="mainSoft" class="note-interpretation-soft">Basado en ritmo seguro, déficit estimado y solución seleccionada.</div>

          <div id="correctionPlan" class="mt-3 text-start">
            <div class="hna-plan-line"><strong>ACT estimada:</strong> <span id="outACT">-</span></div>
            <div class="hna-plan-line"><strong>Meta inicial sugerida:</strong> <span id="outMeta">-</span></div>
            <div class="hna-plan-line"><strong>Velocidad máxima:</strong> <span id="outRate">-</span></div>
            <div class="hna-plan-line"><strong>Cambio de Na por litro:</strong> <span id="outDeltaLiter">-</span></div>
            <div class="hna-plan-line"><strong>Controles:</strong> <span id="outMonitoring">Cada 2–3 h durante corrección activa</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">Si hay hipovolemia o shock, primero restaura perfusión con solución isotónica. La corrección del agua libre viene después de estabilizar hemodinamia.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Lectura clínica</div>
            <div id="actionList" class="hna-action-list">
              <div class="hna-action-item">
                <div class="hna-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="hna-action-copy">
                  <div class="hna-action-title">Completa datos de entrada</div>
                  <p class="hna-action-note">La fórmula solo sirve si se interpreta junto a volemia, pérdidas en curso y controles seriados de sodio.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Plan de fluidos / mecanismo / anestesia</div>
            <div class="hna-action-list">
              <div class="hna-action-item">
                <div class="hna-action-mark ok"><i class="fa-solid fa-droplet"></i></div>
                <div class="hna-action-copy">
                  <div class="hna-action-title">Plan de corrección / fluidos</div>
                  <p id="fluidText" class="hna-action-note">-</p>
                </div>
              </div>
              <div class="hna-action-item">
                <div class="hna-action-mark high"><i class="fa-solid fa-brain"></i></div>
                <div class="hna-action-copy">
                  <div class="hna-action-title">Riesgo fisiológico de corrección rápida</div>
                  <p id="mechanismText" class="hna-action-note">-</p>
                </div>
              </div>
              <div class="hna-action-item">
                <div class="hna-action-mark mid"><i class="fa-solid fa-mask-ventilator"></i></div>
                <div class="hna-action-copy">
                  <div class="hna-action-title">Consideraciones anestésicas</div>
                  <p id="pharmText" class="hna-action-note">-</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Primero perfusión; después agua libre; siempre sodio seriado</div>
          <div class="note-tips"><strong>Qué hacer:</strong> define volemia, cronología, pérdidas en curso y función renal antes de confiar en el cálculo.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> corregir rápido una hipernatremia crónica o incierta, especialmente sin controles de Na cada 2–3 horas.</div>
          <div class="note-tips"><strong>Perla:</strong> D5W y agua enteral son agua libre; NaCl 0,45% corrige más lento; isotónico es para reanimación, no para bajar sodio.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> el déficit calculado es una estimación inicial; la velocidad real la manda la natremia seriada.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;

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

  function getSolutionId(){
    const selected = document.querySelector('input[name="solucion"]:checked');
    return selected ? selected.id : 'sol_d5w';
  }

  function getSolutionLabel(solId){
    if(solId === 'sol_d5w') return 'Dextrosa 5%';
    if(solId === 'sol_half') return 'NaCl 0,45%';
    if(solId === 'sol_iso') return 'Isotónico';
    return 'Agua enteral/VO';
  }

  function getContextLabel(ctx){
    if(ctx === 'euvolemico') return 'Euvolémico';
    if(ctx === 'hipervolemico') return 'Hipervolémico';
    return 'Hipovolémico';
  }

  function classifyNa(na){
    if(!na || na <= 0) return {level:'pending', label:'Pendiente', text:'Ingresa natremia actual.', css:''};
    if(na < 145) return {level:'normal', label:'No hipernatremia', text:'Bajo el umbral habitual de hipernatremia.', css:'hna-ok-card'};
    if(na < 150) return {level:'mild', label:'Leve / zona gris', text:'145–149 mEq/L. Evaluar contexto, volemia y tendencia.', css:'hna-mid-card'};
    if(na < 160) return {level:'significant', label:'Significativa', text:'150–159 mEq/L. Idealmente corregir antes de anestesia electiva.', css:'hna-danger-card'};
    return {level:'severe', label:'Severa', text:'≥160 mEq/L. Alto riesgo neurológico y cardiovascular.', css:'hna-danger-card'};
  }

  function renderActions(level, ctx, crono, solId){
    const box = document.getElementById('actionList');
    let items = [];

    if(level === 'pending'){
      items = [
        ['mid','Completa datos de entrada','La fórmula solo sirve si se interpreta junto a volemia, pérdidas en curso y controles seriados de sodio.']
      ];
    } else if(level === 'normal'){
      items = [
        ['ok','Revisar diagnóstico','La natremia ingresada no corresponde a hipernatremia. Verifica valor, unidad y contexto.'],
        ['ok','No activar corrección de agua libre','No aplicar el algoritmo si no existe hipernatremia real.']
      ];
    } else if(level === 'mild'){
      items = [
        ['mid','Interpretar contexto perioperatorio','Entre 145–150 no siempre hay que suspender, pero sí entender volemia, causa y tendencia.'],
        ['mid','Evitar corrección agresiva','Si es crónica o incierta, planifica corrección gradual y controlada.']
      ];
    } else {
      items = [
        ['high','Corregir de forma controlada','Definir meta inicial conservadora, velocidad segura y controles frecuentes de Na.'],
        ['high','Buscar causa y pérdidas en curso','Diabetes insípida, diuresis osmótica, pérdidas digestivas, fiebre, aporte de sodio o restricción de agua.'],
        ['mid','Ajustar con natremia seriada','El plan inicial debe modificarse con controles cada 2–3 h durante corrección activa.']
      ];
    }

    if(ctx === 'hipovolemico' && level !== 'pending' && level !== 'normal'){
      items.unshift(['high','Primero perfusión','Si hay shock o mala perfusión, reanimar inicialmente con isotónico antes de agua libre.']);
    }

    if(solId === 'sol_iso' && level !== 'pending' && level !== 'normal'){
      items.push(['mid','Isotónico no baja sodio','Úsalo para reanimación hemodinámica, no como estrategia principal de corrección de agua libre.']);
    }

    if(crono === 'cronica' && level !== 'pending' && level !== 'normal'){
      items.push(['high','Crónica o incierta: más lento','Evita caídas rápidas por riesgo de edema cerebral.']);
    }

    box.innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="hna-action-item">' +
        '<div class="hna-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="hna-action-copy">' +
          '<div class="hna-action-title">' + item[1] + '</div>' +
          '<p class="hna-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateHyperNa(){
    const peso = parseLocal(document.getElementById('peso').value);
    const naActual = parseLocal(document.getElementById('naActual').value);
    const tbwFrac = parseLocal(getSelected('tbwgrp') || '0.5') || 0.5;
    const contexto = getSelected('contexto') || 'hipovolemico';
    const cronologia = getSelected('cronologia') || 'cronica';
    const naInfusate = parseLocal(getSelected('solucion') || '0');
    const solId = getSolutionId();
    const naClass = classifyNa(naActual);

    document.getElementById('sumNa').textContent = naActual && naActual > 0 ? fmt(naActual,1) + ' mEq/L' : '-';
    document.getElementById('sumContexto').textContent = getContextLabel(contexto);
    document.getElementById('sumSol').textContent = getSolutionLabel(solId);
    document.getElementById('severityMain').textContent = naClass.label;
    document.getElementById('severityText').textContent = naClass.text;

    const severityCard = document.getElementById('naSeverityCard');
    severityCard.className = 'note-result-card ' + naClass.css;

    if(!peso || peso <= 0 || !naActual || naActual <= 0){
      document.getElementById('sumPesoAct').textContent = peso && peso > 0 ? fmt(peso,1) + ' kg' : '-';
      document.getElementById('summaryNarrative').textContent = 'Ingresa peso y natremia para estimar déficit de agua libre y velocidad orientativa.';
      document.getElementById('outDeficit').textContent = '-';
      document.getElementById('deficitNote').textContent = 'Cálculo orientativo según meta inicial.';
      document.getElementById('mainDecision').textContent = 'Pendiente';
      document.getElementById('mainSoft').textContent = 'Basado en ritmo seguro, déficit estimado y solución seleccionada.';
      document.getElementById('outACT').textContent = '-';
      document.getElementById('outMeta').textContent = '-';
      document.getElementById('outRate').textContent = '-';
      document.getElementById('outDeltaLiter').textContent = '-';
      document.getElementById('fluidText').textContent = '-';
      document.getElementById('mechanismText').textContent = '-';
      document.getElementById('pharmText').textContent = '-';
      renderActions('pending', contexto, cronologia, solId);
      return;
    }

    const act = peso * tbwFrac;
    document.getElementById('sumPesoAct').textContent = fmt(peso,1) + ' kg / ' + fmt(act,1) + ' L';

    let maxRateHour = cronologia === 'aguda' ? 1.0 : 0.5;
    let maxRate24h = cronologia === 'aguda' ? 10 : 8;

    let metaInicial = naActual;
    if(naActual >= 160){
      metaInicial = naActual - maxRate24h;
    } else if(naActual >= 150){
      metaInicial = Math.max(150, naActual - maxRate24h);
    } else if(naActual >= 145){
      metaInicial = Math.max(145, naActual - maxRate24h);
    }

    let deficit = 0;
    if(naActual > metaInicial){
      deficit = act * ((naActual / metaInicial) - 1);
    }

    const deltaNaPerL = (naInfusate - naActual) / (act + 1);
    let infusionMlH = null;
    let mainDecision = 'Valorar contexto';
    let mainSoft = 'El plan depende de volemia, cronología, solución elegida y controles seriados.';

    if(deltaNaPerL < 0){
      infusionMlH = (maxRateHour / Math.abs(deltaNaPerL)) * 1000;
      mainDecision = fmt(infusionMlH,0) + ' mL/h';
      mainSoft = 'Velocidad orientativa para no exceder una caída aproximada de ' + fmt(maxRateHour,1) + ' mEq/L/h con la solución elegida.';
    } else if(deltaNaPerL === 0){
      mainDecision = 'No baja Na';
      mainSoft = 'La solución seleccionada no genera gradiente para disminuir sodio sérico.';
    } else {
      mainDecision = 'Puede subir Na';
      mainSoft = 'La solución seleccionada puede aumentar sodio y no sirve como corrección de agua libre.';
    }

    if(naActual < 145){
      mainDecision = 'Revisar diagnóstico';
      mainSoft = 'La natremia ingresada no corresponde a hipernatremia.';
    } else if(solId === 'sol_iso' && deltaNaPerL >= 0){
      mainDecision = 'No usar para bajar Na';
      mainSoft = 'Isotónico puede ser correcto para reanimación inicial si hay hipovolemia, pero no para corregir agua libre.';
    } else if(solId === 'sol_half' && infusionMlH !== null && infusionMlH > 350){
      mainDecision = 'Velocidad alta';
      mainSoft = 'NaCl 0,45% baja sodio lentamente; puede requerir volúmenes altos. Replantea estrategia y controla Na seriado.';
    } else if((solId === 'sol_d5w' || solId === 'sol_enteral') && infusionMlH !== null && infusionMlH > 250){
      mainDecision = 'Corregir lento';
      mainSoft = 'El cálculo sugiere una velocidad alta para agua libre. Titrar y verificar con sodio seriado.';
    }

    document.getElementById('outACT').textContent = fmt(act,1) + ' L';
    document.getElementById('outMeta').textContent = fmt(metaInicial,1) + ' mEq/L';
    document.getElementById('outDeficit').textContent = fmt(deficit,2) + ' L';
    document.getElementById('deficitNote').textContent = 'Para meta inicial ' + fmt(metaInicial,1) + ' mEq/L.';
    document.getElementById('mainDecision').textContent = mainDecision;
    document.getElementById('mainSoft').textContent = mainSoft;

    document.getElementById('outRate').innerHTML = cronologia === 'aguda'
      ? 'Hasta 1–2 mEq/L/h; máx. aprox. 8–12 mEq/día'
      : '0,5–1 mEq/L/h; máx. aprox. 8 mEq/día; idealmente >48 h';

    document.getElementById('outDeltaLiter').textContent = fmt(deltaNaPerL,2) + ' mEq/L por L';

    document.getElementById('summaryNarrative').textContent =
      'Na ' + fmt(naActual,1) + ' mEq/L, ' + getContextLabel(contexto).toLowerCase() + ', ' + (cronologia === 'aguda' ? 'aguda' : 'crónica/incierta') + '. ' +
      'Déficit orientativo ' + fmt(deficit,2) + ' L; plan: ' + mainDecision + '.';

    let fluidText = '';
    if(contexto === 'hipovolemico'){
      if(solId === 'sol_iso'){
        fluidText = 'Buena elección para fase inicial si hay hipotensión o mala perfusión. Luego de estabilizar, cambiar a una estrategia que aporte agua libre.';
      } else {
        fluidText = 'Útil después de restaurar perfusión. Si el paciente está inestable, primero reanimar con isotónico y luego corregir agua libre.';
      }
    } else if(contexto === 'euvolemico'){
      if(solId === 'sol_d5w' || solId === 'sol_enteral'){
        fluidText = 'Buena herramienta para corregir agua libre en contexto euvolémico, siempre con control seriado de Na.';
      } else if(solId === 'sol_half'){
        fluidText = 'Opción razonable si buscas corrección más gradual que con agua libre pura.';
      } else {
        fluidText = 'El isotónico no suele ser la herramienta de elección para bajar sodio en euvolemia.';
      }
    } else {
      if(solId === 'sol_d5w' || solId === 'sol_enteral'){
        fluidText = 'Puede ayudar a corregir el exceso relativo de sodio, pero en hipervolemia puede requerirse además eliminar sodio y agua.';
      } else if(solId === 'sol_half'){
        fluidText = 'Puede aportar algo de agua libre, pero sigue entregando sodio. Usar con prudencia en hipervolemia.';
      } else {
        fluidText = 'Isotónico suele ser mala opción para corregir hipernatremia hipervolémica, salvo razón hemodinámica muy concreta.';
      }
    }

    if(cronologia === 'cronica'){
      fluidText += ' Al ser crónica o incierta, planificar corrección lenta, idealmente en más de 48 horas.';
    }

    const mechanismText = 'En hipernatremia crónica el cerebro acumula osmoles idiogénicos para defender su volumen. Si bajas el sodio demasiado rápido, entra agua a las neuronas y aumenta el riesgo de edema cerebral, convulsiones y deterioro neurológico. La corrección lenta protege el cerebro.';
    let pharmText = 'La hipernatremia puede aumentar la MAC de halogenados. Si hay deshidratación, la inducción IV puede causar hipotensión desproporcionada por menor volumen efectivo y labilidad hemodinámica. La menor perfusión renal puede prolongar fármacos dependientes de eliminación renal.';
    if(contexto === 'hipovolemico'){
      pharmText += ' En hipovolemia, la prioridad anestésica es perfusión: titular inducción y evitar colapso hemodinámico.';
    }
    if(cronologia === 'aguda'){
      pharmText += ' Si realmente es aguda, puede tolerar corrección algo más rápida que la forma crónica, pero requiere monitorización estrecha.';
    }

    document.getElementById('fluidText').textContent = fluidText;
    document.getElementById('mechanismText').textContent = mechanismText;
    document.getElementById('pharmText').textContent = pharmText;

    renderActions(naClass.level, contexto, cronologia, solId);
  }

  document.getElementById('peso').addEventListener('input', updateHyperNa);
  document.getElementById('naActual').addEventListener('input', updateHyperNa);
  document.querySelectorAll('input[name="tbwgrp"], input[name="contexto"], input[name="cronologia"], input[name="solucion"]').forEach(function(input){
    input.addEventListener('change', updateHyperNa);
  });

  updateHyperNa();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
