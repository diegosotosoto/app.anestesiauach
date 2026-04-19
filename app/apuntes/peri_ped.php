<?php
$titulo_pagina = "Peridural pediátrica / PCA";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para cálculo docente de carga inicial, top-up y PCA epidural postoperatoria en pediatría. Integra peso, rango etáreo y nivel epidural para ajustar dosis, volumen y advertencias de seguridad.";
$formula = "Carga inicial con levobupivacaína 0,25%: lumbar 0,5 mL/kg; torácica 0,3 mL/kg. Top-up estándar: 0,2 mL/kg. PCA con bupivacaína/levobupivacaína 0,1%: 1 mg/mL. Dosis máxima por hora según edad; 2/3 como infusión continua y 1/3 como bolo, con límite de infusión de 5 mL/h.";
$referencias = array(
  "Bosenberg A. Pediatric regional anesthesia update. Paediatr Anaesth.",
  "NYSORA. Pediatric Epidural and Spinal Anesthesia.",
  "ESRA/ASRA educational reviews on pediatric neuraxial analgesia and local anesthetic dosing.",
  "Lönnqvist PA, Ecoffey C, Bosenberg A, et al. The European society of regional anaesthesia and pain therapy and the American society of regional anesthesia and pain medicine joint committee practice advisory on controversial topics in pediatric regional anesthesia.",
  "Protocolos docentes locales de analgesia epidural pediátrica."
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
          .peri-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .peri-choice-grid.peri-grid-5{
            grid-template-columns:repeat(5,minmax(0,1fr));
          }

          .peri-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .peri-option{
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

          .peri-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .peri-option-input:checked + .peri-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .peri-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .peri-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .peri-drug-chip{
            display:inline-block;
            padding:.22rem .48rem;
            border-radius:.6rem;
            font-weight:800;
            border:1px solid rgba(31,42,55,.12);
            line-height:1.1;
            color:#111827;
            background:var(--drug-local);
          }

          .peri-action-list{
            display:grid;
            gap:.75rem;
          }

          .peri-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .peri-action-mark{
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

          .peri-action-mark.ok{background:#2ea663;}
          .peri-action-mark.mid{background:#f4c542;}
          .peri-action-mark.high{background:#d92d20;}

          .peri-action-copy{min-width:0;flex:1;}

          .peri-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .peri-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .peri-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .peri-plan-line:last-child{
            margin-bottom:0;
          }

          .peri-program-grid{
            display:grid;
            grid-template-columns:repeat(4,minmax(0,1fr));
            gap:.75rem;
          }

          .peri-program-card{
            background:linear-gradient(180deg, var(--note-brand-soft) 0%, #f7faff 100%);
            border:1px solid var(--note-brand-soft-border);
            border-radius:1rem;
            padding:.9rem 1rem;
            text-align:center;
          }

          .peri-program-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#3559b7;
            font-weight:700;
            margin-bottom:.22rem;
          }

          .peri-program-value{
            font-size:1.08rem;
            line-height:1.15;
            font-weight:900;
            color:var(--note-text);
          }

          .peri-program-note{
            margin-top:.28rem;
            font-size:.82rem;
            line-height:1.3;
            color:var(--note-muted);
          }

          .peri-topup-card{
            border-radius:1rem;
            border:1px solid var(--note-warning-border);
            background:var(--note-warning-bg);
            padding:1rem;
          }

          .peri-topup-card.is-general{
            border-color:var(--note-success-border);
            background:var(--note-success-bg);
          }

          @media (max-width:992px){
            .peri-choice-grid.peri-grid-5,
            .peri-program-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .peri-choice-grid,
            .peri-choice-grid.peri-grid-5,
            .peri-program-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ANESTESIA REGIONAL · PEDIATRÍA</div>
          <h2>Peridural pediátrica / PCA</h2>
          <div class="note-hero-subtitle">Calcula carga inicial, top-up y programación PCA epidural.</div>
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
                <label class="note-label">Solución para carga / top-up</label>
                <div class="note-summary-v"><span class="peri-drug-chip p-3">Levobupivacaína 0,25%</span></div>
                <div class="note-result-secondary">2,5 mg/mL</div>
              </div>
            </div>

            <div class="note-section-label">Nivel epidural</div>
            <div class="peri-choice-grid mb-3">
              <label>
                <input class="peri-option-input" type="radio" name="nivel" value="lumbar" checked>
                <div class="peri-option">
                  <i class="fa-solid fa-arrow-down-wide-short"></i>
                  <div class="peri-option-title">Lumbar</div>
                  <div class="peri-option-sub">0,5 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="peri-option-input" type="radio" name="nivel" value="toracica">
                <div class="peri-option">
                  <i class="fa-solid fa-arrow-up-wide-short"></i>
                  <div class="peri-option-title">Torácica</div>
                  <div class="peri-option-sub">0,3 mL/kg</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Rango etáreo</div>
            <div class="peri-choice-grid peri-grid-5">
              <label>
                <input class="peri-option-input" type="radio" name="edadgrp" value="rn" checked>
                <div class="peri-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="peri-option-title">RN</div>
                  <div class="peri-option-sub">0,25 mg/kg/h</div>
                </div>
              </label>
              <label>
                <input class="peri-option-input" type="radio" name="edadgrp" value="1_4m">
                <div class="peri-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="peri-option-title">1–4 m</div>
                  <div class="peri-option-sub">0,30 mg/kg/h</div>
                </div>
              </label>
              <label>
                <input class="peri-option-input" type="radio" name="edadgrp" value="5_8m">
                <div class="peri-option">
                  <i class="fa-solid fa-baby-carriage"></i>
                  <div class="peri-option-title">5–8 m</div>
                  <div class="peri-option-sub">0,35–0,40</div>
                </div>
              </label>
              <label>
                <input class="peri-option-input" type="radio" name="edadgrp" value="9_12m">
                <div class="peri-option">
                  <i class="fa-solid fa-child-reaching"></i>
                  <div class="peri-option-title">9–12 m</div>
                  <div class="peri-option-sub">0,40 mg/kg/h</div>
                </div>
              </label>
              <label>
                <input class="peri-option-input" type="radio" name="edadgrp" value="gt1a">
                <div class="peri-option">
                  <i class="fa-solid fa-child"></i>
                  <div class="peri-option-title">&gt;1 año</div>
                  <div class="peri-option-sub">0,50 mg/kg/h</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso para calcular carga inicial, top-up y programación PCA epidural.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Peso</div>
              <div id="summaryWeight" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Nivel epidural</div>
              <div id="summaryLevel" class="note-summary-v">Lumbar</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Rango etáreo</div>
              <div id="summaryAge" class="note-summary-v">RN</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Anestésico local</div>
              <div id="summaryDrug" class="note-summary-v">Levo 0,25% / 0,1%</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Carga inicial</div>
            <div id="loadResult" class="note-result-card-value">-</div>
            <div id="loadNote" class="note-result-card-note">Levobupivacaína 0,25% según nivel epidural.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Top-up estándar</div>
            <div id="topupResult" class="note-result-card-value">-</div>
            <div id="topupNote" class="note-result-card-note">Levobupivacaína 0,25% 0,2 mL/kg.</div>
          </div>
        </div>

        <div id="topupBox" class="peri-topup-card mb-3">
          <div class="note-card-title" id="topupTitle">Top-up conservador en RN / 1–4 meses</div>
          <div id="topupText" class="note-muted mb-3">En lactantes pequeños, el Tmax de bupivacaína / levobupivacaína / ropivacaína es más tardío. Evita redosificación precoz.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Opción A</div>
              <div id="topupA" class="note-summary-v">-</div>
              <div class="note-result-secondary">1/3 de carga inicial; no antes de 45 min</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Opción B</div>
              <div id="topupB" class="note-summary-v">-</div>
              <div class="note-result-secondary">1/2 de carga inicial; no antes de 90 min</div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">PCA epidural postoperatoria</div>

            <div class="note-warning mb-3">
              <strong>Esquema docente:</strong>
              <div class="mt-2">
                PCA calculada con <span class="peri-drug-chip">bupivacaína / levobupivacaína 0,1%</span> = 1 mg/mL. De la dosis máxima por hora: 2/3 como infusión continua y 1/3 como bolo. Límite de infusión: 5 mL/h. Lockout habitual: 30 min.
              </div>
            </div>

            <div class="peri-program-grid">
              <div class="peri-program-card">
                <div class="peri-program-label">Dosis máxima</div>
                <div id="pcaMaxHour" class="peri-program-value">-</div>
                <div class="peri-program-note">mg/h</div>
              </div>
              <div class="peri-program-card">
                <div class="peri-program-label">Infusión</div>
                <div id="pcaInfusion" class="peri-program-value">-</div>
                <div class="peri-program-note">2/3 de dosis máxima</div>
              </div>
              <div class="peri-program-card">
                <div class="peri-program-label">Bolo PCA</div>
                <div id="pcaBolus" class="peri-program-value">-</div>
                <div class="peri-program-note">1/3 de dosis máxima</div>
              </div>
              <div class="peri-program-card">
                <div class="peri-program-label">Lockout</div>
                <div class="peri-program-value">30 min</div>
                <div class="peri-program-note">habitual</div>
              </div>
            </div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación clínica</div>
          <div id="interpMain" class="note-interpretation-main">Pendiente</div>
          <div id="interpSoft" class="note-interpretation-soft">Ingresa peso para generar una estrategia orientativa. Vigilar edad, signos de toxicidad, bloqueo motor y sedación.</div>

          <div class="mt-3 text-start">
            <div class="peri-plan-line"><strong>Edad seleccionada:</strong> <span id="ageDetail">RN</span></div>
            <div class="peri-plan-line"><strong>Advertencia etaria:</strong> <span id="ageWarning">En los más pequeños debe extremarse vigilancia clínica y seguimiento de toxicidad.</span></div>
            <div class="peri-plan-line"><strong>Límite práctico:</strong> <span id="practicalLimit">Infusión continua máxima 5 mL/h.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">Herramienta docente. Verifica concentración real, edad exacta, función hepática/renal, estado hemodinámico, bloqueo motor, sedación, protocolo institucional y disponibilidad de rescate para toxicidad por anestésico local.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="peri-action-list">
              <div class="peri-action-item">
                <div class="peri-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="peri-action-copy">
                  <div class="peri-action-title">Ingresa peso para calcular</div>
                  <p class="peri-action-note">La programación se expresa en mL, pero el límite de seguridad se entiende en mg/kg/h y edad.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">En epidural pediátrica, el error peligroso suele ser redosificar demasiado rápido</div>
          <div class="note-tips"><strong>Qué hacer:</strong> calcula en mg, programa en mL y reevalúa bloqueo, dolor, sedación, hemodinamia y signos de toxicidad.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> repetir top-up en lactantes pequeños antes de que el primer bolo alcance efecto máximo.</div>
          <div class="note-tips"><strong>Menores de 9 meses:</strong> usa estrategia conservadora para top-up por Tmax más tardío y riesgo de acumulación; en 9–12 meses y mayores no aplica esa regla específica.</div>
          <div class="note-tips"><strong>PCA:</strong> con bupivacaína/levobupivacaína 0,1%, 1 mL equivale a 1 mg, lo que facilita programación y revisión mental.</div>
          <div class="note-tips"><strong>Perla técnica:</strong> en menores de 1 año la línea de Tuffier puede quedar más baja; la posición lateral suele favorecer el espacio epidural y el catéter idealmente no debería avanzarse más de 3 cm.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si la infusión calculada supera 5 mL/h, ajusta a 5 mL/h y no “compenses” aumentando bolos sin reevaluar.</div>
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
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? selected.value : null;
  }

  function rangeText(minVal, maxVal, decimals, unit){
    if(Math.abs(minVal - maxVal) < 0.0001) return fmt(minVal, decimals) + unit;
    return fmt(minVal, decimals) + '–' + fmt(maxVal, decimals) + unit;
  }

  function ageMeta(age){
    const data = {
      rn:{
        label:'RN',
        min:0.25,
        max:0.25,
        warning:'Máxima cautela. Mayor riesgo de acumulación por inmadurez metabólica y mayor fracción libre. Vigilar toxicidad y preferir estrategias conservadoras.',
        actions:[
          ['high','Máxima cautela farmacocinética','En RN evita redosificación precoz y usa vigilancia estrecha de sedación, bloqueo motor, hemodinamia y toxicidad.'],
          ['mid','Preferir estrategia conservadora','Si hay duda, reduce dosis, aumenta intervalos y reevalúa antes de repetir top-up.']
        ]
      },
      '1_4m':{
        label:'1–4 meses',
        min:0.30,
        max:0.30,
        warning:'Grupo especialmente sensible. Top-up conservador e infusión con vigilancia estrecha; no asumir meseta farmacocinética estable.',
        actions:[
          ['high','Top-up conservador','Usa fracciones de la carga inicial y respeta tiempos prolongados antes de redosificar.'],
          ['mid','Vigilar acumulación','Controla sedación, bloqueo motor, hemodinamia y signos neurológicos.']
        ]
      },
      '5_8m':{
        label:'5–8 meses',
        min:0.35,
        max:0.40,
        warning:'Aún existe riesgo relativo de acumulación. Mantén estrategia conservadora de top-up y usa el extremo inferior del rango si hay fragilidad, recuperación lenta o duda clínica.',
        actions:[
          ['mid','Usar extremo inferior si hay duda','Especialmente si hay comorbilidad, bajo peso, hipoproteinemia o catéter de comportamiento incierto.'],
          ['ok','Reevaluar antes de rescatar','No aumentes dosis sin revisar nivel, lateralización y bloqueo motor.']
        ]
      },
      '9_12m':{
        label:'9–12 meses',
        min:0.40,
        max:0.40,
        warning:'Mayor margen farmacocinético que en lactantes pequeños, pero la vigilancia clínica sigue siendo obligatoria.',
        actions:[
          ['ok','Margen mayor, no ausencia de riesgo','Vigila clínica y necesidad real de rescates.'],
          ['ok','Programar con límite de volumen','Mantén el tope de 5 mL/h si la infusión calculada lo supera.']
        ]
      },
      gt1a:{
        label:'>1 año',
        min:0.50,
        max:0.50,
        warning:'Puede usarse esquema habitual por peso. En adolescentes algunas referencias usan límites menores para bupi/levobupi; ajustar a contexto.',
        actions:[
          ['ok','Esquema habitual por peso','Aun en mayores, revisar concentración real y límite de volumen de la bomba.'],
          ['mid','Adolescente no es adulto pequeño automático','Considerar límites institucionales y comorbilidades si el peso es alto.']
        ]
      }
    };
    return data[age] || data.rn;
  }

  function renderActions(items){
    const box = document.getElementById('actionList');
    box.innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="peri-action-item">' +
        '<div class="peri-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="peri-action-copy">' +
          '<div class="peri-action-title">' + item[1] + '</div>' +
          '<p class="peri-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updatePeriPed(){
    const peso = parseLocal(document.getElementById('peso').value);
    const nivel = getSelected('nivel') || 'lumbar';
    const edad = getSelected('edadgrp') || 'rn';
    const meta = ageMeta(edad);

    setText('summaryLevel', nivel === 'lumbar' ? 'Lumbar' : 'Torácica');
    setText('summaryAge', meta.label);
    setText('ageDetail', meta.label);

    if(!peso || peso <= 0){
      setText('summaryWeight', '-');
      setText('summaryNarrative', 'Ingresa peso para calcular carga inicial, top-up y programación PCA epidural.');
      setText('loadResult', '-');
      setText('topupResult', '-');
      setText('pcaMaxHour', '-');
      setText('pcaInfusion', '-');
      setText('pcaBolus', '-');
      setText('interpMain', 'Pendiente');
      setText('interpSoft', 'Ingresa peso para generar una estrategia orientativa. Vigilar edad, signos de toxicidad, bloqueo motor y sedación.');
      setText('ageWarning', 'En los más pequeños debe extremarse vigilancia clínica y seguimiento de toxicidad.');
      setText('topupA', '-');
      setText('topupB', '-');
      renderActions([
        ['mid','Ingresa peso para calcular','La programación se expresa en mL, pero el límite de seguridad se entiende en mg/kg/h y edad.']
      ]);
      return;
    }

    const cargaMlKg = nivel === 'lumbar' ? 0.5 : 0.3;
    const cargaMl = peso * cargaMlKg;
    const cargaMg = cargaMl * 2.5;

    const topupMl = peso * 0.2;
    const topupMg = topupMl * 2.5;

    const topA = cargaMl / 3;
    const topB = cargaMl / 2;

    const minMaxHourMg = peso * meta.min;
    const maxMaxHourMg = peso * meta.max;

    let minInf = minMaxHourMg * 2 / 3;
    let maxInf = maxMaxHourMg * 2 / 3;
    const minBol = minMaxHourMg / 3;
    const maxBol = maxMaxHourMg / 3;

    let capped = false;
    if(minInf > 5){ minInf = 5; capped = true; }
    if(maxInf > 5){ maxInf = 5; capped = true; }

    setText('summaryWeight', fmt(peso,1) + ' kg');
    setText('summaryNarrative', meta.label + ', ' + fmt(peso,1) + ' kg, epidural ' + (nivel === 'lumbar' ? 'lumbar' : 'torácica') + '. Carga inicial ' + fmt(cargaMl,1) + ' mL; PCA máxima ' + rangeText(minMaxHourMg, maxMaxHourMg,1,' mg/h') + '.');

    setText('loadResult', fmt(cargaMl,1) + ' mL');
    setText('loadNote', 'Levobupivacaína 0,25% ' + fmt(cargaMlKg,1) + ' mL/kg = ' + fmt(cargaMg,1) + ' mg.');
    setText('topupResult', fmt(topupMl,1) + ' mL');
    setText('topupNote', 'Top-up estándar 0,2 mL/kg = ' + fmt(topupMg,1) + ' mg.');

    setText('topupA', fmt(topA,1) + ' mL');
    setText('topupB', fmt(topB,1) + ' mL');

    const topupBox = document.getElementById('topupBox');
    if(edad === 'rn' || edad === '1_4m' || edad === '5_8m'){
      topupBox.className = 'peri-topup-card mb-3';
      setText('topupTitle', 'Top-up conservador en <9 meses');
      setText('topupText', 'En RN, 1–4 meses y 5–8 meses, usar estrategia conservadora por Tmax más tardío y riesgo de acumulación. Si requiere nuevo top-up, reducir el volumen usado previamente a la mitad y respetar el mismo intervalo.');
      document.getElementById('topupA').closest('.note-summary-grid-2').style.display = 'grid';
    } else {
      topupBox.className = 'peri-topup-card is-general mb-3';
      setText('topupTitle', 'Top-up habitual en 9–12 meses y >1 año');
      setText('topupText', 'En pacientes de 9–12 meses y mayores no se aplica la regla conservadora basada en Tmax. Usar el top-up estándar según peso y contexto, reevaluando analgesia, nivel, lateralización y bloqueo motor antes de repetir.');
      document.getElementById('topupA').closest('.note-summary-grid-2').style.display = 'none';
    }

    setText('pcaMaxHour', rangeText(minMaxHourMg, maxMaxHourMg,1,' mg/h'));
    setText('pcaInfusion', rangeText(minInf, maxInf,1,' mL/h'));
    setText('pcaBolus', rangeText(minBol, maxBol,1,' mL'));

    setText('interpMain', capped ? 'Programar con límite de 5 mL/h' : 'Programación orientativa generada');
    setText('interpSoft', capped ? 'La infusión continua calculada supera el límite práctico; se ajusta a 5 mL/h. No compenses automáticamente con bolos.' : 'La programación respeta el límite práctico de infusión continua. Reevalúa analgesia, bloqueo motor y toxicidad.');
    setText('ageWarning', meta.warning);
    setText('practicalLimit', capped ? 'Infusión ajustada a 5 mL/h por límite práctico.' : 'Infusión continua dentro del límite de 5 mL/h.');

    const actions = meta.actions.slice();
    actions.push(['mid','Verificar concentración real','Carga/top-up calculados para levobupivacaína 0,25%; PCA calculada para bupi/levobupi 0,1%.']);
    if(capped){
      actions.unshift(['high','Infusión capada a 5 mL/h','No aumentes bolos para compensar sin reevaluación clínica.']);
    }
    renderActions(actions);
  }

  document.getElementById('peso').addEventListener('input', updatePeriPed);
  document.querySelectorAll('input[name="nivel"], input[name="edadgrp"]').forEach(function(input){
    input.addEventListener('change', updatePeriPed);
  });

  updatePeriPed();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php include("footer.php"); ?>
