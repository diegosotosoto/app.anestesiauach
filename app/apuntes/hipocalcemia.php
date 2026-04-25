<?php
$titulo_pagina = "Reposición de calcio";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para apoyo en reposición intraoperatoria de calcio. Prioriza calcio iónico, pero permite ingresar calcio total o calcio iónico en distintas unidades y muestra las equivalencias relevantes en el resumen.";
$formula = "Calcio total normal: 8,8–10,3 mg/dL ≈ 2,2–2,6 mmol/L ≈ 4,4–5,2 mEq/L. Calcio iónico normal: 1,1–1,3 mmol/L ≈ 4,4–5,2 mg/dL ≈ 2,2–2,6 mEq/L. Conversión aproximada: mmol/L = mg/dL ÷ 4; mEq/L = mmol/L × 2. Reposición expresada como calcio elemental: gluconato 10% ≈ 9,3 mg/mL; cloruro 10% ≈ 27 mg/mL.";
$referencias = array(
  "OpenAnesthesia. Hypocalcemia. Actualizado 2025.",
  "Aguilera IM, Vaughan RS. Calcium and the anaesthetist. Anaesthesia. 2000;55(8):779-790.",
  "DailyMed. Calcium Gluconate Injection USP 10%: 9,3 mg/mL de calcio elemental.",
  "DailyMed. Calcium Chloride Injection 10%: 27 mg/mL de calcio elemental; administrar lentamente por vena central o profunda.",
  "Nota docente del usuario: reposición intraoperatoria de calcio, hipocalcemia por citrato, objetivos intraoperatorios y precauciones farmacológicas."
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
          .cal-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .cal-choice-grid.cal-grid-3{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }

          .cal-choice-grid.cal-grid-4{
            grid-template-columns:repeat(4,minmax(0,1fr));
          }

          .cal-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .cal-option{
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

          .cal-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .cal-option-input:checked + .cal-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .cal-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .cal-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .cal-action-list{
            display:grid;
            gap:.75rem;
          }

          .cal-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .cal-action-mark{
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

          .cal-action-mark.ok{background:#2ea663;}
          .cal-action-mark.mid{background:#f4c542;}
          .cal-action-mark.high{background:#d92d20;}

          .cal-action-copy{min-width:0;flex:1;}

          .cal-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .cal-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .cal-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .cal-plan-line:last-child{
            margin-bottom:0;
          }

          .cal-drug{
            display:inline-block;
            padding:.22rem .48rem;
            border-radius:.6rem;
            font-weight:800;
            border:1px solid rgba(31,42,55,.12);
            line-height:1.1;
            color:#111827;
            background:var(--drug-other);
          }

          .cal-drug-critical{background:#fff1f1;}
          .cal-drug-maint{background:#fff9e8;}
          .cal-drug-safe{background:#edf8f1;}

          .cal-ok-card{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .cal-mid-card{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .cal-danger-card{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          @media (max-width:992px){
            .cal-choice-grid.cal-grid-4{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:768px){
            .cal-choice-grid,
            .cal-choice-grid.cal-grid-3,
            .cal-choice-grid.cal-grid-4{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .cal-choice-grid,
            .cal-choice-grid.cal-grid-3,
            .cal-choice-grid.cal-grid-4{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ELECTROLITOS · HEMODINAMIA</div>
          <h2>Reposición intraoperatoria de calcio</h2>
          <div class="note-hero-subtitle">Convierte calcio total o iónico, interpreta severidad y calcula bolus/mantención orientativa según formulación.</div>
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
                <label id="calciumInputLabel" class="note-label">Calcio iónico</label>
                <div class="note-input-inline">
                  <input id="calciumInput" type="text" inputmode="decimal" class="note-input">
                  <div id="calciumInputUnit" class="note-input-unit">mmol/L</div>
                </div>
              </div>
            </div>

            <div class="note-section-label">Tipo de medición</div>
            <div class="cal-choice-grid cal-grid-3 mb-3">
              <label>
                <input class="cal-option-input" type="radio" name="calciumType" value="ion_mmol" checked>
                <div class="cal-option">
                  <i class="fa-solid fa-bolt"></i>
                  <div class="cal-option-title">Ca iónico</div>
                  <div class="cal-option-sub">mmol/L</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="calciumType" value="ion_mgdl">
                <div class="cal-option">
                  <i class="fa-solid fa-bolt"></i>
                  <div class="cal-option-title">Ca iónico</div>
                  <div class="cal-option-sub">mg/dL</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="calciumType" value="ion_meq">
                <div class="cal-option">
                  <i class="fa-solid fa-bolt"></i>
                  <div class="cal-option-title">Ca iónico</div>
                  <div class="cal-option-sub">mEq/L</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="calciumType" value="total_mgdl">
                <div class="cal-option">
                  <i class="fa-solid fa-vial"></i>
                  <div class="cal-option-title">Ca total</div>
                  <div class="cal-option-sub">mg/dL</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="calciumType" value="total_mmol">
                <div class="cal-option">
                  <i class="fa-solid fa-vial"></i>
                  <div class="cal-option-title">Ca total</div>
                  <div class="cal-option-sub">mmol/L</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="calciumType" value="total_meq">
                <div class="cal-option">
                  <i class="fa-solid fa-vial"></i>
                  <div class="cal-option-title">Ca total</div>
                  <div class="cal-option-sub">mEq/L</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Gravedad clínica</div>
            <div class="cal-choice-grid cal-grid-3 mb-3">
              <label>
                <input class="cal-option-input" type="radio" name="gravedad" value="incidental" checked>
                <div class="cal-option">
                  <i class="fa-regular fa-circle"></i>
                  <div class="cal-option-title">Incidental</div>
                  <div class="cal-option-sub">sin síntomas ni QT</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="gravedad" value="qt">
                <div class="cal-option">
                  <i class="fa-solid fa-wave-square"></i>
                  <div class="cal-option-title">QT / tetania</div>
                  <div class="cal-option-sub">parestesias, tetania, QT</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="gravedad" value="shock">
                <div class="cal-option">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                  <div class="cal-option-title">Severo</div>
                  <div class="cal-option-sub">laringoespasmo, convulsión, hipotensión</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Contexto dominante</div>
            <div class="cal-choice-grid cal-grid-4">
              <label>
                <input class="cal-option-input" type="radio" name="contexto" value="aislado" checked>
                <div class="cal-option">
                  <i class="fa-solid fa-vial-circle-check"></i>
                  <div class="cal-option-title">Aislado</div>
                  <div class="cal-option-sub">bajo Ca i sin pérdida activa</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="contexto" value="citrato">
                <div class="cal-option">
                  <i class="fa-solid fa-droplet"></i>
                  <div class="cal-option-title">Citrato</div>
                  <div class="cal-option-sub">transfusión masiva / rápida</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="contexto" value="cpb">
                <div class="cal-option">
                  <i class="fa-solid fa-heart-pulse"></i>
                  <div class="cal-option-title">CPB / ECMO</div>
                  <div class="cal-option-sub">hemodilución / citrato</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="contexto" value="cuello">
                <div class="cal-option">
                  <i class="fa-solid fa-user-doctor"></i>
                  <div class="cal-option-title">Cuello</div>
                  <div class="cal-option-sub">tiroides / paratiroides</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Formulación y acceso</div>

            <div class="cal-choice-grid mb-3">
              <label>
                <input class="cal-option-input" type="radio" name="sal" value="gluconato" checked>
                <div class="cal-option">
                  <i class="fa-solid fa-syringe"></i>
                  <div class="cal-option-title">Gluconato 10%</div>
                  <div class="cal-option-sub">9,3 mg/mL elemental</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="sal" value="cloruro">
                <div class="cal-option">
                  <i class="fa-solid fa-bolt"></i>
                  <div class="cal-option-title">Cloruro 10%</div>
                  <div class="cal-option-sub">27 mg/mL elemental</div>
                </div>
              </label>
            </div>

            <div class="cal-choice-grid">
              <label>
                <input class="cal-option-input" type="radio" name="acceso" value="periferico" checked>
                <div class="cal-option">
                  <i class="fa-solid fa-hand-holding-medical"></i>
                  <div class="cal-option-title">Periférico</div>
                  <div class="cal-option-sub">preferir gluconato</div>
                </div>
              </label>
              <label>
                <input class="cal-option-input" type="radio" name="acceso" value="central">
                <div class="cal-option">
                  <i class="fa-solid fa-circle-nodes"></i>
                  <div class="cal-option-title">Central</div>
                  <div class="cal-option-sub">preferido para cloruro</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso y calcio para interpretar equivalencias, severidad y reposición orientativa.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Medición ingresada</div>
              <div id="summaryInput" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Equivalencia</div>
              <div id="summaryEquiv" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Severidad</div>
              <div id="summarySeverity" class="note-summary-v">Pendiente</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Sal / acceso</div>
              <div id="summarySalt" class="note-summary-v">Gluconato · periférico</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="severityCard" class="note-result-card">
            <div class="note-result-card-label">Interpretación</div>
            <div id="severityMain" class="note-result-card-value">-</div>
            <div id="severityText" class="note-result-card-note">Ingresa calcio para interpretar.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Bolus sugerido</div>
            <div id="outBolus" class="note-result-card-value">-</div>
            <div id="outBolusNote" class="note-result-card-note">Expresado en calcio elemental y convertido a la sal elegida.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Conducta orientativa</div>
          <div id="mainDecision" class="note-interpretation-main">Pendiente</div>
          <div id="mainSoft" class="note-interpretation-soft">Basada en tipo de medición, gravedad clínica, contexto y seguridad del acceso.</div>

          <div class="mt-3 text-start">
            <div class="cal-plan-line"><strong>Equivalencia detallada:</strong> <span id="outEquivDetail">-</span></div>
            <div class="cal-plan-line"><strong>Mantención orientativa:</strong> <span id="outMaint">-</span></div>
            <div class="cal-plan-line"><strong>Administración:</strong> <span id="outAdmin">-</span></div>
            <div class="cal-plan-line"><strong>Objetivo intraoperatorio:</strong> <span id="outGoal">Mantener Ca iónico &gt; 0,8 mmol/L cuando sea relevante.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">El calcio total puede bajar por hipoalbuminemia sin hipocalcemia iónica real. Para decidir tratamiento intraoperatorio, el calcio iónico es la medición prioritaria.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Lectura clínica</div>
            <div id="actionList" class="cal-action-list">
              <div class="cal-action-item">
                <div class="cal-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="cal-action-copy">
                  <div class="cal-action-title">Completa peso y calcio</div>
                  <p class="cal-action-note">La reposición se debe guiar por calcio iónico, contexto y repercusión clínica, no solo por calcio total.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Consideraciones anestésicas y causa probable</div>
            <div class="cal-action-list">
              <div class="cal-action-item">
                <div class="cal-action-mark mid"><i class="fa-solid fa-mask-ventilator"></i></div>
                <div class="cal-action-copy">
                  <div class="cal-action-title">Implicancias anestésicas</div>
                  <p id="anesthText" class="cal-action-note">-</p>
                </div>
              </div>
              <div class="cal-action-item">
                <div class="cal-action-mark ok"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="cal-action-copy">
                  <div class="cal-action-title">Causa probable / estrategia adicional</div>
                  <p id="causeText" class="cal-action-note">-</p>
                </div>
              </div>
              <div id="accessWarningItem" class="cal-action-item" style="display:none;">
                <div class="cal-action-mark high"><i class="fa-solid fa-bolt"></i></div>
                <div class="cal-action-copy">
                  <div class="cal-action-title">Selección insegura de acceso</div>
                  <p id="accessWarningText" class="cal-action-note">Cloruro de calcio 10% por vía periférica no es buena elección por riesgo de extravasación y necrosis tisular.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">El número que manda en pabellón es el calcio iónico</div>
          <div class="note-tips"><strong>Qué hacer:</strong> interpreta calcio total con albúmina y contexto; usa calcio iónico para decisiones rápidas de reposición.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> tratar una “hipocalcemia de papel” por hipoalbuminemia con calcio iónico normal.</div>
          <div class="note-tips"><strong>Perla:</strong> alcalosis por hiperventilación aumenta unión a albúmina y baja calcio iónico; puede empeorar tetania, QT o laringoespasmo.</div>
          <div class="note-tips"><strong>Contexto:</strong> citrato, transfusión masiva, CPB/ECMO y cirugía de cuello requieren recontroles seriados, no una sola corrección aislada.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> gluconato es más amable para vía periférica; cloruro es más concentrado, más irritante y preferentemente central.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const pesoInput = document.getElementById('peso');
  const calciumInput = document.getElementById('calciumInput');

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

  function calciumTypeLabel(type){
    const map = {
      ion_mmol:'Ca iónico',
      ion_mgdl:'Ca iónico',
      ion_meq:'Ca iónico',
      total_mgdl:'Ca total',
      total_mmol:'Ca total',
      total_meq:'Ca total'
    };
    return map[type] || 'Calcio';
  }

  function calciumUnit(type){
    if(type.indexOf('mgdl') !== -1) return 'mg/dL';
    if(type.indexOf('meq') !== -1) return 'mEq/L';
    return 'mmol/L';
  }

  function saltLabel(val){
    return val === 'gluconato' ? 'Gluconato 10%' : 'Cloruro 10%';
  }

  function accessLabel(val){
    return val === 'periferico' ? 'periférico' : 'central';
  }

  function severityLabel(val){
    if(val === 'qt') return 'QT / tetania';
    if(val === 'shock') return 'Severo';
    return 'Incidental';
  }

  function contextLabel(val){
    if(val === 'citrato') return 'Citrato / transfusión';
    if(val === 'cpb') return 'CPB / ECMO';
    if(val === 'cuello') return 'Cuello / hipopara';
    return 'Aislado';
  }

  function convertCalcium(value, type){
    const isIon = type.indexOf('ion_') === 0;
    let mmol = null;

    if(type.indexOf('mgdl') !== -1){
      mmol = value / 4.0;
    } else if(type.indexOf('meq') !== -1){
      mmol = value / 2.0;
    } else {
      mmol = value;
    }

    return {
      isIon:isIon,
      mmol:mmol,
      mgdl:mmol * 4.0,
      meq:mmol * 2.0
    };
  }

  function classifyCalcium(conv){
    if(!conv || !Number.isFinite(conv.mmol)) return {level:'pending', label:'Pendiente', text:'Ingresa calcio para interpretar.', css:''};

    if(conv.isIon){
      const cai = conv.mmol;
      if(cai >= 1.1) return {level:'normal', label:'Ca iónico normal', text:'Rango normal aproximado: 1,1–1,3 mmol/L.', css:'cal-ok-card'};
      if(cai >= 0.8) return {level:'mild', label:'Ca iónico bajo leve', text:'Bajo el rango normal, pero sobre el objetivo intraoperatorio práctico de 0,8 mmol/L.', css:'cal-mid-card'};
      if(cai >= 0.75) return {level:'relevant', label:'Bajo objetivo intraoperatorio', text:'Menor a 0,8 mmol/L; considerar contexto, ECG y síntomas.', css:'cal-mid-card'};
      if(cai >= 0.6) return {level:'significant', label:'Hipocalcemia significativa', text:'Riesgo de QT prolongado, depresión miocárdica y síntomas neuromusculares.', css:'cal-danger-card'};
      return {level:'critical', label:'Hipocalcemia crítica', text:'Puede asociarse a depresión ventricular marcada, convulsiones, laringoespasmo o shock.', css:'cal-danger-card'};
    }

    const totalMg = conv.mgdl;
    if(totalMg >= 8.8 && totalMg <= 10.3) return {level:'normal_total', label:'Ca total normal', text:'Rango normal aproximado: 8,8–10,3 mg/dL.', css:'cal-ok-card'};
    if(totalMg < 8.8 && totalMg >= 8.0) return {level:'mild_total', label:'Ca total bajo leve', text:'Interpretar con albúmina y confirmar calcio iónico si hay duda.', css:'cal-mid-card'};
    if(totalMg < 8.0) return {level:'low_total', label:'Ca total bajo', text:'Puede representar hipocalcemia real o efecto de hipoalbuminemia; prioriza calcio iónico.', css:'cal-danger-card'};
    return {level:'high_total', label:'Ca total alto', text:'No corresponde a hipocalcemia. Revisar diagnóstico y contexto.', css:'cal-mid-card'};
  }

  function shouldBolus(conv, gravedad, contexto){
    if(!conv || !Number.isFinite(conv.mmol)) return 0;

    if(!conv.isIon){
      if(gravedad === 'shock') return 100;
      if(gravedad === 'qt') return 100;
      return 0;
    }

    const cai = conv.mmol;

    if(cai >= 0.8 && gravedad === 'incidental') return 0;
    if((cai >= 0.75 && cai < 0.8) || gravedad === 'qt') return 100;
    if(cai < 0.75 || gravedad === 'shock') return 200;
    if((contexto === 'citrato' || contexto === 'cpb') && cai < 0.9) return 100;

    return 0;
  }

  function renderActions(level, isIon, gravedad, contexto, unsafe){
    const box = document.getElementById('actionList');
    let items = [];

    if(level === 'pending'){
      items = [
        ['mid','Completa peso y calcio','La reposición se debe guiar por calcio iónico, contexto y repercusión clínica, no solo por calcio total.']
      ];
    } else if(!isIon){
      items = [
        ['mid','Confirmar con calcio iónico si es posible','El calcio total puede bajar por hipoalbuminemia sin hipocalcemia iónica real.'],
        ['mid','No tratar solo el número total','Trata si hay síntomas, QT, inestabilidad o un contexto compatible; de lo contrario confirma y reevalúa.']
      ];
    } else if(level === 'normal'){
      items = [
        ['ok','Evitar bolos reflejos','Con Ca iónico normal, no corrijas solo por calcio total bajo o albúmina baja.'],
        ['ok','Buscar causa si el contexto no calza','Revisa pH, albúmina, transfusión, citrato, magnesio y tendencia.']
      ];
    } else if(level === 'mild'){
      items = [
        ['mid','Monitorizar y recontrolar','Bajo rango normal, pero sobre 0,8 mmol/L. La reposición depende de síntomas y contexto dinámico.'],
        ['mid','Evitar alcalosis','La hiperventilación puede bajar más el calcio iónico.']
      ];
    } else {
      items = [
        ['high','Reponer si hay repercusión clínica','QT, tetania, laringoespasmo, convulsión, depresión miocárdica o hipotensión refractaria justifican tratamiento.'],
        ['high','Recontrolar calcio iónico','Especialmente en citrato, transfusión masiva, CPB/ECMO o cirugía de cuello.']
      ];
    }

    if(contexto === 'citrato'){
      items.push(['high','Pensar en citrato','Mantener temperatura, perfusión hepática y flujo sanguíneo adecuado ayuda a metabolizar citrato.']);
    }

    if(contexto === 'cuello'){
      items.push(['mid','Buscar hipoparatiroidismo postquirúrgico','Tras cirugía tiroidea/paratiroidea, vigilar tetania, QT, laringoespasmo y necesidad de reposición sostenida.']);
    }

    if(unsafe){
      items.unshift(['high','Cambiar formulación o acceso','Cloruro de calcio 10% por vía periférica es irritante y puede producir necrosis si extravasa.']);
    }

    box.innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="cal-action-item">' +
        '<div class="cal-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="cal-action-copy">' +
          '<div class="cal-action-title">' + item[1] + '</div>' +
          '<p class="cal-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateInputLabels(){
    const type = getSelected('calciumType') || 'ion_mmol';
    document.getElementById('calciumInputLabel').textContent = calciumTypeLabel(type);
    document.getElementById('calciumInputUnit').textContent = calciumUnit(type);
  }

  function updateCalciumNote(){
    updateInputLabels();

    const peso = parseLocal(pesoInput.value);
    const caValue = parseLocal(calciumInput.value);
    const type = getSelected('calciumType') || 'ion_mmol';
    const gravedad = getSelected('gravedad') || 'incidental';
    const contexto = getSelected('contexto') || 'aislado';
    const sal = getSelected('sal') || 'gluconato';
    const acceso = getSelected('acceso') || 'periferico';

    const mgPerMl = sal === 'gluconato' ? 9.3 : 27.0;
    const unsafe = sal === 'cloruro' && acceso === 'periferico';
    const conv = caValue && caValue > 0 ? convertCalcium(caValue, type) : null;
    const cls = classifyCalcium(conv);

    document.getElementById('summarySalt').textContent = saltLabel(sal) + ' · ' + accessLabel(acceso);

    if(!peso || peso <= 0 || !caValue || caValue <= 0){
      document.getElementById('summaryInput').textContent = caValue && caValue > 0 ? fmt(caValue,2) + ' ' + calciumUnit(type) : '-';
      document.getElementById('summaryEquiv').textContent = '-';
      document.getElementById('summarySeverity').textContent = 'Pendiente';
      document.getElementById('summaryNarrative').textContent = 'Ingresa peso y calcio para interpretar equivalencias, severidad y reposición orientativa.';
      document.getElementById('severityMain').textContent = '-';
      document.getElementById('severityText').textContent = 'Ingresa calcio para interpretar.';
      document.getElementById('severityCard').className = 'note-result-card';
      document.getElementById('outBolus').textContent = '-';
      document.getElementById('outBolusNote').textContent = 'Expresado en calcio elemental y convertido a la sal elegida.';
      document.getElementById('mainDecision').textContent = 'Pendiente';
      document.getElementById('mainSoft').textContent = 'Basada en tipo de medición, gravedad clínica, contexto y seguridad del acceso.';
      document.getElementById('outEquivDetail').textContent = '-';
      document.getElementById('outMaint').textContent = '-';
      document.getElementById('outAdmin').textContent = '-';
      document.getElementById('anesthText').textContent = '-';
      document.getElementById('causeText').textContent = '-';
      document.getElementById('accessWarningItem').style.display = unsafe ? 'flex' : 'none';
      renderActions('pending', true, gravedad, contexto, unsafe);
      return;
    }

    const inputText = fmt(caValue,2) + ' ' + calciumUnit(type) + ' (' + calciumTypeLabel(type) + ')';
    const equivShort = conv.isIon
      ? fmt(conv.mmol,2) + ' mmol/L · ' + fmt(conv.mgdl,1) + ' mg/dL · ' + fmt(conv.meq,2) + ' mEq/L'
      : fmt(conv.mgdl,1) + ' mg/dL · ' + fmt(conv.mmol,2) + ' mmol/L · ' + fmt(conv.meq,2) + ' mEq/L';

    document.getElementById('summaryInput').textContent = inputText;
    document.getElementById('summaryEquiv').textContent = equivShort;
    document.getElementById('summarySeverity').textContent = cls.label;
    document.getElementById('severityMain').textContent = cls.label;
    document.getElementById('severityText').textContent = cls.text;
    document.getElementById('severityCard').className = 'note-result-card ' + cls.css;
    document.getElementById('outEquivDetail').innerHTML = conv.isIon
      ? '<strong>Calcio iónico:</strong> ' + equivShort
      : '<strong>Calcio total:</strong> ' + equivShort + '<br><span class="note-result-secondary">No equivale a calcio iónico; interpretar con albúmina y pH.</span>';

    const bolusMg = shouldBolus(conv, gravedad, contexto);
    let bolusText = 'No rutinario';
    let bolusNote = 'Monitorizar, confirmar causa y recontrolar según contexto.';
    let mainDecision = 'Observar y recontrolar';
    let mainSoft = 'No hay indicación automática de bolus si el paciente está estable y sin repercusión.';

    if(unsafe){
      bolusText = 'No sugerido';
      bolusNote = 'Selección insegura: cambia a gluconato o usa acceso central.';
      mainDecision = 'Cambiar acceso o sal';
      mainSoft = 'Cloruro de calcio 10% por vía periférica es irritante y puede causar necrosis por extravasación.';
    } else if(bolusMg > 0){
      const bolusMl = bolusMg / mgPerMl;
      bolusText = fmt(bolusMg,0) + ' mg';
      bolusNote = '≈ ' + fmt(bolusMl,1) + ' mL de ' + saltLabel(sal) + '. Pasar lento.';
      mainDecision = bolusMg === 100 ? 'Bolus prudente' : 'Bolus de rescate';
      mainSoft = 'Reposición orientativa expresada en calcio elemental; recontrolar calcio iónico y respuesta clínica.';
    } else if(!conv.isIon){
      mainDecision = 'Confirmar Ca iónico';
      mainSoft = 'El calcio total puede inducir error si hay hipoalbuminemia o cambios de pH.';
    }

    document.getElementById('outBolus').textContent = bolusText;
    document.getElementById('outBolusNote').textContent = bolusNote;
    document.getElementById('mainDecision').textContent = mainDecision;
    document.getElementById('mainSoft').textContent = mainSoft;

    let maintText = 'No de rutina';
    if(!unsafe && (contexto === 'citrato' || contexto === 'cpb' || contexto === 'cuello' || cls.level === 'significant' || cls.level === 'critical' || gravedad !== 'incidental')){
      const lowMgH = peso * 0.5;
      const highMgH = peso * 1.5;
      const lowMlH = lowMgH / mgPerMl;
      const highMlH = highMgH / mgPerMl;
      maintText = '<span class="cal-drug cal-drug-maint">' + fmt(lowMgH,0) + '–' + fmt(highMgH,0) + ' mg/h elemental</span> ' +
                  '≈ ' + fmt(lowMlH,1) + '–' + fmt(highMlH,1) + ' mL/h de ' + saltLabel(sal);
    }

    document.getElementById('outMaint').innerHTML = maintText;

    let adminText = sal === 'gluconato'
      ? 'Diluir y pasar lento; bolus en 10–20 min según urgencia.'
      : 'Preferir acceso central o vena profunda; administrar lentamente y vigilar extravasación.';
    if(unsafe){
      adminText = '<span class="cal-drug cal-drug-critical">No recomendado: cloruro por vía periférica</span>';
    }
    document.getElementById('outAdmin').innerHTML = adminText;

    document.getElementById('accessWarningItem').style.display = unsafe ? 'flex' : 'none';

    let summary = inputText + '. ' + cls.label + '. ';
    summary += conv.isIon
      ? 'Equivalente: ' + equivShort + '. '
      : 'Equivalente total: ' + equivShort + '; confirmar Ca iónico si la decisión es clínica. ';
    summary += 'Conducta: ' + mainDecision + '.';
    document.getElementById('summaryNarrative').textContent = summary;

    let anesthText = 'La hipocalcemia puede potenciar bloqueo neuromuscular no despolarizante, favorecer laringoespasmo y empeorar depresión miocárdica con halogenados. Evita alcalosis por hiperventilación, porque baja más el calcio iónico.';
    if(conv.isIon && conv.mmol < 0.75){
      anesthText += ' Con Ca iónico <0,75 mmol/L, vigila QT, contractilidad y respuesta hemodinámica.';
    }
    if(contexto === 'citrato'){
      anesthText += ' En citrato, el problema puede reaparecer mientras siga entrando carga de hemoderivados.';
    }
    if(contexto === 'cpb'){
      anesthText += ' En CPB/ECMO, hemodilución, citrato y cambios de proteínas pueden mantener el Ca iónico bajo.';
    }
    document.getElementById('anesthText').textContent = anesthText;

    let causeText = '';
    if(contexto === 'aislado'){
      causeText = conv.isIon
        ? 'Si el Ca iónico está bajo de verdad, busca pH, magnesio, fósforo, fármacos y tendencia. Si solo el total está bajo, piensa en albúmina.'
        : 'El calcio total aislado puede ser engañoso. La hipoalbuminemia baja Ca total sin necesariamente bajar Ca iónico.';
    } else if(contexto === 'citrato'){
      causeText = 'El citrato quela calcio y puede producir hipotensión, depresión miocárdica y coagulopatía. Mantener temperatura, perfusión hepática y flujo adecuado ayuda a metabolizarlo.';
    } else if(contexto === 'cpb'){
      causeText = 'En CPB/ECMO, corrige solo lo necesario para estabilidad y objetivo iónico; evita perseguir hipercorrección innecesaria.';
    } else {
      causeText = 'Tras tiroides/paratiroides, vigila tetania, QT prolongado, laringoespasmo e hipoparatiroidismo. Puede requerir reposición sostenida.';
    }
    if(gravedad === 'shock'){
      causeText += ' Si la hipotensión es refractaria a vasopresores y el Ca iónico está bajo, la reposición cobra más sentido clínico.';
    }
    document.getElementById('causeText').textContent = causeText;

    renderActions(cls.level, conv.isIon, gravedad, contexto, unsafe);
  }

  pesoInput.addEventListener('input', updateCalciumNote);
  calciumInput.addEventListener('input', updateCalciumNote);
  document.querySelectorAll('input[name="calciumType"], input[name="gravedad"], input[name="contexto"], input[name="sal"], input[name="acceso"]').forEach(function(input){
    input.addEventListener('change', updateCalciumNote);
  });

  updateCalciumNote();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
