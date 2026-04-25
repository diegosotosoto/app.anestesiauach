<?php
$titulo_pagina = "Transfusión de CE en alícuotas";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Calculadora docente para estimar volumen de concentrado eritrocitario necesario para alcanzar un hematocrito objetivo y el ascenso esperado tras transfundir una alícuota, especialmente útil en pediatría.";
$formula = "VSE = peso × volemia estimada. Volumen CE requerido = [(Hto deseado − Hto actual) × VSE] / Hto del CE. Ascenso esperado del Hto = [volumen transfundido × Hto del CE] / VSE. Los hematocritos se ingresan como porcentaje y los volúmenes en mL. Para CE, 55% se usa como concentración habitual orientativa; 50–60% permite ajustar según banco de sangre.";
$referencias = array(
  "Roseff SD, Luban NLC, Manno CS. Guidelines for assessing appropriateness of pediatric transfusion. Transfusion. 2002;42(11):1398-1413.",
  "Kleinman S, et al. Red blood cell transfusion in children: indications and dosing principles. Transfusion medicine references and institutional practice standards.",
  "British Committee for Standards in Haematology. Guidelines on transfusion for fetuses, neonates and older children.",
  "Protocolos docentes locales de transfusión perioperatoria pediátrica."
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
          .hcto-choice-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .hcto-choice-grid.hcto-grid-2{
            grid-template-columns:repeat(2,minmax(0,1fr));
          }

          .hcto-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .hcto-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:68px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.5rem .65rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.12rem;
            color:var(--note-text);
          }

          .hcto-option i{
            color:#3559b7;
            font-size:.95rem;
          }

          .hcto-input:checked + .hcto-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .hcto-option-title{
            font-size:.92rem;
            font-weight:850;
            line-height:1.12;
            color:var(--note-text);
          }

          .hcto-option-sub{
            font-size:.74rem;
            line-height:1.18;
            color:var(--note-muted);
            font-weight:650;
          }

          .hcto-result-low{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .hcto-result-mid{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .hcto-result-high{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          .hcto-action-list{
            display:grid;
            gap:.75rem;
          }

          .hcto-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .hcto-action-mark{
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

          .hcto-action-mark.ok{background:#2ea663;}
          .hcto-action-mark.mid{background:#f4c542;}
          .hcto-action-mark.high{background:#d92d20;}

          .hcto-action-copy{min-width:0;flex:1;}

          .hcto-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .hcto-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .hcto-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .hcto-plan-line:last-child{
            margin-bottom:0;
          }

          .hcto-formula-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .hcto-formula-box{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            min-width:0;
          }

          .hcto-formula-title{
            font-size:.96rem;
            font-weight:850;
            color:var(--note-text);
            text-align:center;
            margin-bottom:.75rem;
          }

          .hcto-fraction{
            display:flex;
            flex-direction:column;
            align-items:center;
            text-align:center;
            color:var(--note-text);
            font-size:.92rem;
            line-height:1.3;
            min-width:0;
          }

          .hcto-fraction-top,
          .hcto-fraction-bottom{
            width:100%;
            overflow-wrap:anywhere;
          }

          .hcto-fraction-top{
            border-bottom:2px solid #98a2b3;
            padding:0 .25rem .4rem .25rem;
            font-weight:800;
          }

          .hcto-fraction-bottom{
            padding:.4rem .25rem 0 .25rem;
            font-weight:800;
          }

          @media (max-width:768px){
            .hcto-choice-grid,
            .hcto-choice-grid.hcto-grid-2{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }

            .hcto-formula-grid{
              grid-template-columns:1fr;
            }
          }

          @media (max-width:420px){
            .hcto-choice-grid,
            .hcto-choice-grid.hcto-grid-2{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · HEMOTERAPIA · PEDIATRÍA</div>
          <h2>Transfusión de CE en alícuotas</h2>
          <div class="note-hero-subtitle">Estima volumen requerido y ascenso esperado del hematocrito, priorizando reevaluación clínica y seguridad transfusional.</div>
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
            <div class="note-section-label">Datos del paciente</div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Peso</label>
                <div class="note-input-inline">
                  <input id="peso" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Alícuota a transfundir</label>
                <div class="note-input-inline">
                  <input id="aliquota" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mL</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Hto actual</label>
                <div class="note-input-inline">
                  <input id="hto_actual" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">%</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Hto deseado</label>
                <div class="note-input-inline">
                  <input id="hto_deseado" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">%</div>
                </div>
              </div>
            </div>

            <div class="note-section-label">Volemia estimada</div>
            <div class="hcto-choice-grid mb-3">
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="vseKg" value="70" checked>
                <div class="hcto-option">
                  <i class="fa-solid fa-person"></i>
                  <div class="hcto-option-title">70 mL/kg</div>
                  <div class="hcto-option-sub">adulto / referencia</div>
                </div>
              </label>
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="vseKg" value="80">
                <div class="hcto-option">
                  <i class="fa-solid fa-child"></i>
                  <div class="hcto-option-title">80 mL/kg</div>
                  <div class="hcto-option-sub">niño mayor</div>
                </div>
              </label>
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="vseKg" value="85">
                <div class="hcto-option">
                  <i class="fa-solid fa-baby-carriage"></i>
                  <div class="hcto-option-title">85 mL/kg</div>
                  <div class="hcto-option-sub">lactante</div>
                </div>
              </label>
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="vseKg" value="90">
                <div class="hcto-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="hcto-option-title">90 mL/kg</div>
                  <div class="hcto-option-sub">recién nacido</div>
                </div>
              </label>
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="vseKg" value="65">
                <div class="hcto-option">
                  <i class="fa-solid fa-user-minus"></i>
                  <div class="hcto-option-title">65 mL/kg</div>
                  <div class="hcto-option-sub">menor volemia relativa</div>
                </div>
              </label>
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="vseKg" value="75">
                <div class="hcto-option">
                  <i class="fa-solid fa-user-plus"></i>
                  <div class="hcto-option-title">75 mL/kg</div>
                  <div class="hcto-option-sub">adulto delgado</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Hematocrito del concentrado eritrocitario</div>
            <div class="hcto-choice-grid hcto-grid-2">
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="htoCE" value="50">
                <div class="hcto-option">
                  <i class="fa-solid fa-droplet"></i>
                  <div class="hcto-option-title">50%</div>
                  <div class="hcto-option-sub">CE menos concentrado</div>
                </div>
              </label>
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="htoCE" value="55" checked>
                <div class="hcto-option">
                  <i class="fa-solid fa-droplet"></i>
                  <div class="hcto-option-title">55%</div>
                  <div class="hcto-option-sub">concentración habitual</div>
                </div>
              </label>
              <label>
                <input class="hcto-input hcto-trigger" type="radio" name="htoCE" value="60">
                <div class="hcto-option">
                  <i class="fa-solid fa-droplet"></i>
                  <div class="hcto-option-title">60%</div>
                  <div class="hcto-option-sub">CE más concentrado</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso y hematocritos para estimar volumen requerido. Ingresa alícuota para estimar ascenso.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Paciente / VSE</div>
              <div id="summaryVSE" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Objetivo</div>
              <div id="summaryTarget" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">CE</div>
              <div id="summaryCE" class="note-summary-v">Hto 55%</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Alícuota</div>
              <div id="summaryAliquot" class="note-summary-v">-</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="requiredCard" class="note-result-card">
            <div class="note-result-card-label">Volumen de CE requerido</div>
            <div id="reqValue" class="note-result-card-value">-</div>
            <div id="reqNote" class="note-result-card-note">Para alcanzar Hto objetivo.</div>
          </div>
          <div id="riseCard" class="note-result-card">
            <div class="note-result-card-label">Ascenso esperado del Hto</div>
            <div id="riseValue" class="note-result-card-value">-</div>
            <div id="riseNote" class="note-result-card-note">Según alícuota ingresada.</div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="vseCard" class="note-result-card">
            <div class="note-result-card-label">Volumen sanguíneo estimado</div>
            <div id="vseValue" class="note-result-card-value">-</div>
            <div id="vseNote" class="note-result-card-note">Peso × volemia estimada.</div>
          </div>
          <div id="postCard" class="note-result-card">
            <div class="note-result-card-label">Hto estimado postransfusión</div>
            <div id="postValue" class="note-result-card-value">-</div>
            <div id="postNote" class="note-result-card-note">Hto actual + ascenso esperado.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación clínica</div>
          <div id="conductTitle" class="note-interpretation-main">Pendiente</div>
          <div id="conductText" class="note-interpretation-soft">Completa los campos para generar una orientación. El cálculo no reemplaza reevaluación clínica ni control postransfusional.</div>

          <div class="mt-3 text-start">
            <div class="hcto-plan-line"><strong>Lectura del objetivo:</strong> <span id="targetLine">-</span></div>
            <div class="hcto-plan-line"><strong>Lectura de la alícuota:</strong> <span id="aliquotLine">-</span></div>
            <div class="hcto-plan-line"><strong>Limitación:</strong> <span>La respuesta real cambia con sangrado activo, hemodilución, fluidos, hemólisis, tiempos de control y laboratorio.</span></div>
          </div>
        </div>

        <div id="validityWarning" class="note-danger note-hidden mb-3">
          <strong>Dato a verificar:</strong>
          <div id="validityWarningText" class="mt-2"></div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div class="mt-2">No transfundas solo por el número calculado. Integra perfusión, sangrado activo, cardiopatía, lactato, ventilación, tendencia de Hb/Hto, disponibilidad de sangre y protocolo local.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Fórmula visual</div>
            <div class="hcto-formula-grid">
              <div class="hcto-formula-box">
                <div class="hcto-formula-title">Volumen de CE requerido</div>
                <div class="hcto-fraction">
                  <div class="hcto-fraction-top">[Hto deseado − Hto actual] × VSE</div>
                  <div class="hcto-fraction-bottom">Hto del CE</div>
                </div>
              </div>
              <div class="hcto-formula-box">
                <div class="hcto-formula-title">Ascenso esperado por alícuota</div>
                <div class="hcto-fraction">
                  <div class="hcto-fraction-top">Volumen transfundido × Hto del CE</div>
                  <div class="hcto-fraction-bottom">VSE</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="hcto-action-list">
              <div class="hcto-action-item">
                <div class="hcto-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="hcto-action-copy">
                  <div class="hcto-action-title">Completa datos para calcular</div>
                  <p class="hcto-action-note">Peso y volemia permiten estimar VSE; hematocritos y alícuota permiten estimar volumen requerido y respuesta esperada.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">En pediatría, la alícuota ayuda a corregir de forma gradual</div>
          <div class="note-tips"><strong>Qué hacer:</strong> calcula volumen, transfunde con vigilancia, reevalúa sangrado y controla Hb/Hto según contexto y timing.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> perseguir un hematocrito objetivo sin considerar perfusión, hemodilución, pérdidas activas y reserva cardiopulmonar.</div>
          <div class="note-tips"><strong>VSE:</strong> es una estimación; recién nacidos y lactantes tienen volemia relativa mayor que adultos.</div>
          <div class="note-tips"><strong>Alícuotas:</strong> fraccionar permite evitar sobretransfusión y facilita reevaluación entre dosis.</div>
          <div class="note-tips"><strong>Regla rápida:</strong> 10–15 mL/kg de CE suele producir un ascenso moderado, pero el efecto real depende del contexto.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si hay sangrado activo, la fórmula describe un escenario que ya está cambiando; reevalúa en ciclos cortos.</div>
        </div>

        <div class="note-footer mt-3">
          Herramienta docente de apoyo. No reemplaza protocolos institucionales, banco de sangre ni juicio clínico perioperatorio.
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

  function getSelectedNumber(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? parseLocal(el.value) : null;
  }

  function showWarning(text){
    const box = document.getElementById('validityWarning');
    box.classList.remove('note-hidden');
    setText('validityWarningText', text);
  }

  function hideWarning(){
    const box = document.getElementById('validityWarning');
    box.classList.add('note-hidden');
    setText('validityWarningText', '');
  }

  function renderActions(state, reqVolume, rise, aliquota, peso){
    let items = [];

    if(state === 'pending'){
      items = [
        ['mid','Completa datos para calcular','Peso y volemia permiten estimar VSE; hematocritos y alícuota permiten estimar volumen requerido y respuesta esperada.']
      ];
    } else {
      if(Number.isFinite(reqVolume)){
        items.push(['ok','Volumen objetivo calculado','Usa el volumen requerido como orientación y considera transfundir en alícuotas si el contexto lo permite.']);
      }
      if(Number.isFinite(rise)){
        items.push(['ok','Ascenso esperado disponible','La alícuota ingresada permite estimar el Hto postransfusional, pero debe confirmarse con control clínico/laboratorio.']);
      }
      if(Number.isFinite(aliquota) && Number.isFinite(peso)){
        const mlkg = aliquota / peso;
        if(mlkg > 20){
          items.unshift(['high','Alícuota alta en mL/kg','La alícuota equivale a ' + fmt(mlkg,1) + ' mL/kg. Revisa indicación, velocidad y riesgo de sobrecarga.']);
        } else if(mlkg >= 10){
          items.push(['mid','Alícuota clínicamente significativa','Equivale a ' + fmt(mlkg,1) + ' mL/kg. Reevalúa antes de repetir.']);
        }
      }
      items.push(['mid','Reevaluar contexto','Sangrado activo, fluidos, hemodilución y laboratorio pueden modificar mucho la respuesta real.']);
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="hcto-action-item">' +
        '<div class="hcto-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="hcto-action-copy">' +
          '<div class="hcto-action-title">' + item[1] + '</div>' +
          '<p class="hcto-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateHcto(){
    const peso = parseLocal(document.getElementById('peso').value);
    const aliquota = parseLocal(document.getElementById('aliquota').value);
    const htoActual = parseLocal(document.getElementById('hto_actual').value);
    const htoDeseado = parseLocal(document.getElementById('hto_deseado').value);
    const htoCE = getSelectedNumber('htoCE') || 55;
    const vseKg = getSelectedNumber('vseKg') || 70;

    const hasPeso = peso !== null && peso > 0;
    const vse = hasPeso ? peso * vseKg : null;

    setText('summaryCE', 'Hto ' + fmt(htoCE,0) + '%');
    setText('summaryAliquot', aliquota !== null && aliquota > 0 ? fmt(aliquota,0) + ' mL' + (hasPeso ? ' · ' + fmt(aliquota / peso,1) + ' mL/kg' : '') : '-');
    setText('summaryTarget', (htoActual !== null && htoDeseado !== null) ? fmt(htoActual,1) + '% → ' + fmt(htoDeseado,1) + '%' : '-');

    if(hasPeso){
      setText('vseValue', fmt(vse,0) + ' mL');
      setText('vseNote', fmt(peso,2) + ' kg × ' + fmt(vseKg,0) + ' mL/kg.');
      setText('summaryVSE', fmt(peso,2) + ' kg · VSE ' + fmt(vse,0) + ' mL');
    } else {
      setText('vseValue', '-');
      setText('vseNote', 'Peso × volemia estimada.');
      setText('summaryVSE', '-');
    }

    let warnings = [];
    if(peso !== null && (peso < 0.5 || peso > 250)) warnings.push('El peso ingresado parece implausible para esta herramienta.');
    if(htoActual !== null && (htoActual < 0 || htoActual > 75)) warnings.push('Hto actual fuera de rango esperable; verifica el dato.');
    if(htoDeseado !== null && (htoDeseado < 0 || htoDeseado > 75)) warnings.push('Hto deseado fuera de rango esperable; verifica el dato.');
    if(htoActual !== null && htoDeseado !== null && htoDeseado < htoActual) warnings.push('El Hto deseado es menor que el actual; esta calculadora está pensada para metas ascendentes.');
    if(warnings.length) showWarning(warnings.join(' ')); else hideWarning();

    let reqVolume = null;
    if(hasPeso && htoActual !== null && htoDeseado !== null && htoCE > 0 && htoDeseado >= htoActual){
      reqVolume = ((htoDeseado - htoActual) * vse) / htoCE;
      setText('reqValue', fmt(reqVolume,0) + ' mL');
      setText('reqNote', 'Para subir de ' + fmt(htoActual,1) + '% a ' + fmt(htoDeseado,1) + '%.');
      document.getElementById('requiredCard').className = 'note-result-card hcto-result-mid';
      setText('targetLine', 'Volumen requerido estimado: ' + fmt(reqVolume,0) + ' mL de CE.');
    } else {
      setText('reqValue', '-');
      setText('reqNote', 'Para alcanzar Hto objetivo.');
      document.getElementById('requiredCard').className = 'note-result-card';
      setText('targetLine', 'Completa Hto actual, Hto deseado y peso.');
    }

    let rise = null;
    if(hasPeso && aliquota !== null && aliquota > 0 && htoCE > 0){
      rise = (aliquota * htoCE) / vse;
      setText('riseValue', '+' + fmt(rise,1) + ' puntos');
      setText('riseNote', 'Con ' + fmt(aliquota,0) + ' mL de CE Hto ' + fmt(htoCE,0) + '%.');
      document.getElementById('riseCard').className = 'note-result-card hcto-result-low';
      setText('aliquotLine', 'La alícuota equivale a ' + fmt(aliquota / peso,1) + ' mL/kg y subiría el Hto cerca de ' + fmt(rise,1) + ' puntos.');
    } else {
      setText('riseValue', '-');
      setText('riseNote', 'Según alícuota ingresada.');
      document.getElementById('riseCard').className = 'note-result-card';
      setText('aliquotLine', 'Ingresa alícuota y peso para estimar ascenso.');
    }

    if(htoActual !== null && rise !== null){
      setText('postValue', fmt(htoActual + rise,1) + '%');
      setText('postNote', 'Estimación matemática; confirmar según timing y contexto.');
      document.getElementById('postCard').className = 'note-result-card hcto-result-low';
    } else {
      setText('postValue', '-');
      setText('postNote', 'Hto actual + ascenso esperado.');
      document.getElementById('postCard').className = 'note-result-card';
    }

    if(!hasPeso){
      setText('summaryNarrative', 'Ingresa peso y hematocritos para estimar volumen requerido. Ingresa alícuota para estimar ascenso.');
      setText('conductTitle', 'Pendiente');
      setText('conductText', 'Completa peso para estimar VSE y realizar cálculos útiles.');
      renderActions('pending', reqVolume, rise, aliquota, peso);
      return;
    }

    let narrativeParts = ['VSE ' + fmt(vse,0) + ' mL'];
    if(reqVolume !== null) narrativeParts.push('requerimiento ' + fmt(reqVolume,0) + ' mL');
    if(rise !== null) narrativeParts.push('ascenso esperado +' + fmt(rise,1) + ' puntos');
    setText('summaryNarrative', narrativeParts.join(' · ') + '. Reevalúa según sangrado activo y control postransfusional.');

    if(reqVolume !== null && rise !== null){
      setText('conductTitle', 'Cálculo completo disponible');
      setText('conductText', 'Dispones de volumen requerido y ascenso esperado por alícuota. Úsalos como orientación y reevalúa en ciclos clínicos.');
      document.getElementById('algoBox').className = 'note-interpretation mb-3';
      renderActions('complete', reqVolume, rise, aliquota, peso);
    } else if(reqVolume !== null || rise !== null){
      setText('conductTitle', 'Estimación parcial disponible');
      setText('conductText', 'El cálculo ya entrega una orientación útil, pero faltan datos para una lectura completa de objetivo y respuesta esperada.');
      renderActions('partial', reqVolume, rise, aliquota, peso);
    } else {
      setText('conductTitle', 'Faltan datos relevantes');
      setText('conductText', 'Completa hematocritos y/o alícuota para obtener resultados clínicamente útiles.');
      renderActions('pending', reqVolume, rise, aliquota, peso);
    }
  }

  document.querySelectorAll('#peso, #aliquota, #hto_actual, #hto_deseado').forEach(function(el){
    el.addEventListener('input', updateHcto);
  });

  document.querySelectorAll('.hcto-trigger').forEach(function(el){
    el.addEventListener('change', updateHcto);
  });

  updateHcto();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
