<?php
$titulo_pagina = "Calculadora de Infusión EV";
$navbar_titulo  = "Apuntes";
$boton_toggler  = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar  = "<span class='text-white'>Apuntes</span>";
$boton_navbar   = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info      = "Calculadora de Infusión EV";
$descripcion_info = "Herramienta para calcular velocidades de infusión endovenosa continua. Permite conversión bidireccional entre mcg/kg/min, mg/h y mL/h según la preparación del fármaco. Incluye tabla de titulación y duración estimada según volumen disponible.";
$formula          = "Concentración (mcg/mL) = Cantidad fármaco (mcg) ÷ Volumen total (mL). Velocidad (mL/h) = Dosis (mcg/kg/min) × Peso (kg) × 60 ÷ Concentración (mcg/mL).";
$referencias      = array(
  "Miller RD. Miller's Anesthesia, 8th ed. Target-Controlled Infusion and Pharmacokinetic Principles.",
  "Absalom AR, Glen JI. Pharmacokinetics and pharmacodynamics of intravenous anaesthetic agents.",
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<style>
  /* ── Modo de conversión: opciones radio estilo gly-option ── */
  .inf-mode-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: .65rem;
  }
  @media (max-width: 500px) {
    .inf-mode-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }
  .inf-mode-input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }
  .inf-mode-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 64px;
    border: 2px solid var(--note-line);
    background: var(--note-card, #fff);
    border-radius: 1rem;
    padding: .6rem .5rem;
    cursor: pointer;
    transition: .15s ease;
    box-shadow: 0 3px 10px rgba(15,23,42,.04);
    gap: .12rem;
  }
  .inf-mode-input:checked + .inf-mode-option {
    box-shadow: 0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
    border: 4px solid var(--note-selected, #3b82f6);
    transform: translateY(-1px);
  }
  .inf-mode-title {
    font-size: .82rem;
    font-weight: 800;
    line-height: 1.15;
    color: var(--note-text);
  }
  .inf-mode-sub {
    font-size: .72rem;
    line-height: 1.2;
    color: var(--note-muted);
    font-weight: 600;
  }
  /* ── Tabla titulación estilo gly-table ── */
  .inf-gly-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: var(--note-card, #fff);
    border: 1px solid var(--note-line);
    border-radius: 1rem;
    overflow: hidden;
  }
  .inf-gly-table th {
    background: #3559b7;
    color: #fff;
    font-size: .76rem;
    font-weight: 800;
    padding: .5rem .65rem;
    text-align: left;
    white-space: normal;
    border-bottom: 1px solid #eef2f6;
    border-right: 1px solid rgba(255,255,255,.15);
  }
  .inf-gly-table th:last-child { border-right: none; }
  .inf-gly-table td {
    padding: .52rem .65rem;
    font-size: .88rem;
    border-bottom: 1px solid #eef2f6;
    border-right: 1px solid #eef2f6;
    color: var(--note-text);
    vertical-align: middle;
  }
  .inf-gly-table td:last-child { border-right: none; }
  .inf-gly-table tr:last-child td { border-bottom: none; }
  .inf-gly-table td:first-child { font-weight: 700; }
  .inf-gly-table .inf-td-val { font-weight: 800; color: #3559b7; }
  /* ── Concentración inline ── */
  .inf-conc-note {
    margin-top: .5rem;
    font-size: .88rem;
    color: var(--note-muted);
  }
  .inf-conc-note strong { color: var(--note-brand, #27458f); }
</style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · INFUSIONES · CÁLCULOS</div>
          <h2>Calculadora de Infusión EV</h2>
          <div class="note-hero-subtitle">Conversión bidireccional de dosis y velocidades</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?= $descripcion_info ?></p>
            <hr>
            <b>Fórmulas:</b><br><?= $formula ?>
            <hr>
            <b>Referencias:</b>
            <ul class="mb-0 mt-2">
              <?php foreach ($referencias as $ref): ?>
                <li class="mb-2"><?= $ref ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <!-- ── PACIENTE ────────────────────────────────────────── -->
        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Datos del paciente</div>
            <div class="note-input-group">
              <label class="note-label">Peso</label>
              <div class="note-input-inline">
                <input id="inf-weight" type="text" inputmode="decimal" class="note-input" value="">
                <div class="note-input-unit">kg</div>
              </div>
            </div>
          </div>
        </div>

        <!-- ── PREPARACIÓN ─────────────────────────────────────── -->
        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Preparación del fármaco</div>
            <div class="note-input-group mb-3">
              <label class="note-label">Medicamento preconfigurado</label>
              <select id="inf-preset" class="note-input note-input-unit" style="height:auto;padding:.55rem .75rem;">
                <option value="">Personalizado</option>
                <option value="prop1">Propofol (1%) 1000 mg / 100 mL</option>
                <option value="prop2">Propofol (2%) 2000 mg / 100 mL</option>
                <option value="remi">Remifentanilo 2 mg / 40 mL</option>
                <option value="dex">Dexmedetomidina 200 mcg / 50 mL</option>
                <option value="nora">Noradrenalina 8 mg / 250 mL</option>
                <option value="nora4">Noradrenalina 4 mg / 250 mL</option>
                <option value="adre">Adrenalina 8 mg / 250 mL</option>
                <option value="feni100">Fenilefrina 10 mg / 100 mL</option>
                <option value="feni250">Fenilefrina 10 mg / 250 mL</option>
                <option value="ketamina">Ketamina 500 mg / 50 mL</option>
              </select>
            </div>
            <div class="note-grid">
              <div class="note-input-group">
                <label class="note-label">Cantidad de fármaco</label>
                <div class="note-input-inline">
                  <input id="inf-drug-amount" type="text" inputmode="decimal" class="note-input" value="">
                  <select id="inf-drug-unit" class="note-input-unit" style="border:none;background:transparent;font-size:.95rem;padding:.1rem .3rem;">
                    <option value="mg">mg</option>
                    <option value="mcg">mcg</option>
                  </select>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label">Volumen total</label>
                <div class="note-input-inline">
                  <input id="inf-volume" type="text" inputmode="decimal" class="note-input" value="">
                  <div class="note-input-unit">mL</div>
                </div>
              </div>
            </div>
            <div class="inf-conc-note mt-2">Concentración: <strong id="inf-conc">—</strong></div>
          </div>
        </div>

        <!-- ── MODO DE CONVERSIÓN ──────────────────────────────── -->
        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Modo de conversión</div>
            <div class="inf-mode-grid mb-3">
              <label>
                <input class="inf-mode-input" type="radio" name="infmode" value="dose2ml" checked>
                <div class="inf-mode-option">
                  <div class="inf-mode-title">Dosis → mL/h</div>
                </div>
              </label>
              <label>
                <input class="inf-mode-input" type="radio" name="infmode" value="ml2dose">
                <div class="inf-mode-option">
                  <div class="inf-mode-title">mL/h → Dosis</div>
                </div>
              </label>
              <label>
                <input class="inf-mode-input" type="radio" name="infmode" value="mgh2ml">
                <div class="inf-mode-option">
                  <div class="inf-mode-title">mg/h → mL/h</div>
                </div>
              </label>
              <label>
                <input class="inf-mode-input" type="radio" name="infmode" value="ml2mgh">
                <div class="inf-mode-option">
                  <div class="inf-mode-title">mL/h → mg/h</div>
                </div>
              </label>
              <label>
                <input class="inf-mode-input" type="radio" name="infmode" value="mcgmin2ml">
                <div class="inf-mode-option">
                  <div class="inf-mode-title">mcg/min → mL/h</div>
                </div>
              </label>
              <label>
                <input class="inf-mode-input" type="radio" name="infmode" value="ml2mcgmin">
                <div class="inf-mode-option">
                  <div class="inf-mode-title">mL/h → mcg/min</div>
                </div>
              </label>
            </div>

            <!-- Panel: Dosis → mL/h -->
            <div id="panel-dose2ml" class="inf-panel">
              <div class="note-grid">
                <div class="note-input-group">
                  <label class="note-label">Dosis objetivo</label>
                  <div class="note-input-inline">
                    <input id="inf-dose" type="text" inputmode="decimal" class="note-input" value="3">
                    <select id="inf-dose-unit" class="note-input-unit" style="border:none;background:transparent;font-size:.88rem;padding:.1rem .2rem;">
                      <option value="mcgkgmin">mcg/kg/min</option>
                      <option value="mcgkghr">mcg/kg/h</option>
                      <option value="mgkghr">mg/kg/h</option>
                      <option value="mcgmin">mcg/min</option>
                      <option value="mghr">mg/h</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Panel: mL/h → Dosis -->
            <div id="panel-ml2dose" class="inf-panel" style="display:none;">
              <div class="note-grid">
                <div class="note-input-group">
                  <label class="note-label">Velocidad</label>
                  <div class="note-input-inline">
                    <input id="inf-mlhr-in" type="text" inputmode="decimal" class="note-input" value="10">
                    <div class="note-input-unit">mL/h</div>
                  </div>
                </div>
                <div class="note-input-group">
                  <label class="note-label">Unidad resultado</label>
                  <select id="inf-rev-unit" class="note-input note-input-unit" style="height:auto;padding:.55rem .75rem;">
                    <option value="mcgkgmin">mcg/kg/min</option>
                    <option value="mcgkghr">mcg/kg/h</option>
                    <option value="mgkghr">mg/kg/h</option>
                    <option value="mcgmin">mcg/min</option>
                    <option value="mghr">mg/h</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Panel: mg/h → mL/h -->
            <div id="panel-mgh2ml" class="inf-panel" style="display:none;">
              <div class="note-input-group">
                <label class="note-label">Dosis</label>
                <div class="note-input-inline">
                  <input id="inf-mgh-in" type="text" inputmode="decimal" class="note-input" value="5">
                  <div class="note-input-unit">mg/h</div>
                </div>
              </div>
            </div>

            <!-- Panel: mL/h → mg/h -->
            <div id="panel-ml2mgh" class="inf-panel" style="display:none;">
              <div class="note-input-group">
                <label class="note-label">Velocidad</label>
                <div class="note-input-inline">
                  <input id="inf-mlhr-mgh-in" type="text" inputmode="decimal" class="note-input" value="10">
                  <div class="note-input-unit">mL/h</div>
                </div>
              </div>
            </div>

            <!-- Panel: mcg/min → mL/h -->
            <div id="panel-mcgmin2ml" class="inf-panel" style="display:none;">
              <div class="note-input-group">
                <label class="note-label">Dosis</label>
                <div class="note-input-inline">
                  <input id="inf-mcgmin-in" type="text" inputmode="decimal" class="note-input" value="10">
                  <div class="note-input-unit">mcg/min</div>
                </div>
              </div>
            </div>

            <!-- Panel: mL/h → mcg/min -->
            <div id="panel-ml2mcgmin" class="inf-panel" style="display:none;">
              <div class="note-input-group">
                <label class="note-label">Velocidad</label>
                <div class="note-input-inline">
                  <input id="inf-mlhr-mcgmin-in" type="text" inputmode="decimal" class="note-input" value="10">
                  <div class="note-input-unit">mL/h</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ── RESUMEN / RESULTADOS ────────────────────────────── -->
        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resultado</div>
          <div id="inf-summary-text" class="note-summary-box-text">Completa los datos de preparación y dosis objetivo.</div>
          <div class="note-result-grid-2 mt-2" id="inf-result-grid">
            <!-- generado por JS -->
          </div>
        </div>

        <!-- ── DURACIÓN ESTIMADA ───────────────────────────────── -->
        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Duración estimada según volumen</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">20 mL</div>
                <div id="dur20" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">50 mL</div>
                <div id="dur50" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">100 mL</div>
                <div id="dur100" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">250 mL</div>
                <div id="dur250" class="note-result-card-value">—</div>
              </div>
            </div>
          </div>
        </div>

        <!-- ── TABLA DE TITULACIÓN ────────────────────────────── -->
        <div class="note-card mb-4">
          <div class="note-card-body">
            <div class="note-section-label">Tabla de titulación</div>
            <p class="note-section-label mb-2" style="font-weight:400;text-transform:none;font-size:.85rem;">Velocidades calculadas para el peso actual del paciente</p>
            <div style="overflow-x:auto;">
              <table class="inf-gly-table">
                <thead>
                  <tr>
                    <th>mcg/kg/min</th>
                    <th>mcg/min</th>
                    <th>mg/h</th>
                    <th>mL/h</th>
                  </tr>
                </thead>
                <tbody id="inf-titration-body"></tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function () {

  const PRESETS = {
    prop1:   { amount: 1000, unit: 'mg',  vol: 100 },
    prop2:   { amount: 2000, unit: 'mg',  vol: 100 },
    remi:    { amount: 2,    unit: 'mg',  vol: 40  },
    dex:     { amount: 200,  unit: 'mcg', vol: 50  },
    nora:    { amount: 8,    unit: 'mg',  vol: 250 },
    nora4:   { amount: 4,    unit: 'mg',  vol: 250 },
    adre:    { amount: 8,    unit: 'mg',  vol: 250 },
    feni100: { amount: 10,   unit: 'mg',  vol: 100 },
    feni250: { amount: 10,   unit: 'mg',  vol: 250 },
    ketamina:{ amount: 500,  unit: 'mg',  vol: 50  },
  };
  const TAPER_DOSES = [0.02, 0.05, 0.1, 0.2, 0.3, 0.5, 0.75, 1, 1.5, 2, 3];

  const $ = id => document.getElementById(id);

  function v(id) { return parseFloat($(id).value.replace(',', '.')) || 0; }

  function fmt(n, dec) {
    if (!isFinite(n) || n <= 0) return '—';
    return n.toFixed(dec);
  }

  function fmtDuration(hours) {
    if (!isFinite(hours) || hours <= 0) return '—';
    const tot = Math.round(hours * 60);
    const h = Math.floor(tot / 60), m = tot % 60;
    return h > 0 ? h + ' h ' + m + ' min' : m + ' min';
  }

  function getConc() {
    const amount = v('inf-drug-amount');
    const unit   = $('inf-drug-unit').value;
    const vol    = v('inf-volume') || 1;
    const totalMcg = unit === 'mg' ? amount * 1000 : amount;
    return totalMcg / vol;
  }

  function doseToMcgMin(dose, unit, weight) {
    switch (unit) {
      case 'mcgkgmin': return dose * weight;
      case 'mcgkghr':  return (dose * weight) / 60;
      case 'mgkghr':   return (dose * 1000 * weight) / 60;
      case 'mcgmin':   return dose;
      case 'mghr':     return (dose * 1000) / 60;
    }
    return 0;
  }

  function mcgMinToUnit(mcgMin, unit, weight) {
    switch (unit) {
      case 'mcgkgmin': return weight > 0 ? mcgMin / weight : 0;
      case 'mcgkghr':  return weight > 0 ? (mcgMin * 60) / weight : 0;
      case 'mgkghr':   return weight > 0 ? (mcgMin * 60) / (weight * 1000) : 0;
      case 'mcgmin':   return mcgMin;
      case 'mghr':     return (mcgMin * 60) / 1000;
    }
    return 0;
  }

  function unitLabel(unit) {
    const map = { mcgkgmin:'mcg/kg/min', mcgkghr:'mcg/kg/h', mgkghr:'mg/kg/h', mcgmin:'mcg/min', mghr:'mg/h' };
    return map[unit] || unit;
  }

  function currentMode() {
    return document.querySelector('input[name="infmode"]:checked').value;
  }

  function renderResultGrid(cards) {
    const grid = $('inf-result-grid');
    grid.innerHTML = '';
    cards.forEach(c => {
      const div = document.createElement('div');
      div.className = 'note-result-card';
      div.innerHTML =
        '<div class="note-result-card-label">' + c.label + '</div>' +
        '<div class="note-result-card-value">'  + c.value + '</div>' +
        (c.note ? '<div class="note-result-card-note">' + c.note + '</div>' : '');
      grid.appendChild(div);
    });
  }

  function buildTitration(conc, weight) {
    const tbody = $('inf-titration-body');
    tbody.innerHTML = '';
    TAPER_DOSES.forEach(d => {
      const mcgMin = d * weight;
      const mlHr   = conc > 0 ? (mcgMin / conc) * 60 : 0;
      const mgHr   = (mcgMin * 60) / 1000;
      const ok     = weight > 0 && conc > 0;
      const tr = document.createElement('tr');
      tr.innerHTML =
        '<td>' + d + '</td>' +
        '<td class="inf-td-val">' + (ok ? mcgMin.toFixed(1) : '—') + '</td>' +
        '<td class="inf-td-val">' + (ok ? mgHr.toFixed(2)   : '—') + '</td>' +
        '<td class="inf-td-val">' + (ok ? mlHr.toFixed(2)   : '—') + '</td>';
      tbody.appendChild(tr);
    });
  }

  function updateDurations(mlHr) {
    [20, 50, 100, 250].forEach(vol => {
      $('dur' + vol).textContent = fmtDuration(vol / mlHr);
    });
  }

  function calculate() {
    const weight = v('inf-weight');
    const conc   = getConc();
    const mode   = currentMode();

    $('inf-conc').textContent = conc > 0
      ? (conc >= 1000 ? (conc / 1000).toFixed(3) + ' mg/mL' : conc.toFixed(2) + ' mcg/mL')
      : '—';

    let mlHr = 0, cards = [], summary = '';

    switch (mode) {
      case 'dose2ml': {
        const dose     = v('inf-dose');
        const doseUnit = $('inf-dose-unit').value;
        const mcgMin   = doseToMcgMin(dose, doseUnit, weight);
        mlHr = conc > 0 ? (mcgMin / conc) * 60 : 0;
        const mgHr  = (mcgMin * 60) / 1000;
        const mlMin = mlHr / 60;
        summary = dose + ' ' + unitLabel(doseUnit) + ' → <strong>' + fmt(mlHr, 2) + ' mL/h</strong>';
        cards = [
          { label: 'Velocidad (mL/h)',   value: fmt(mlHr, 2)  },
          { label: 'Velocidad (mL/min)', value: fmt(mlMin, 3) },
          { label: 'Dosis (mcg/min)',    value: fmt(mcgMin, 1) },
          { label: 'Dosis (mg/h)',       value: fmt(mgHr, 3)  },
        ];
        break;
      }
      case 'ml2dose': {
        mlHr = v('inf-mlhr-in');
        const revUnit = $('inf-rev-unit').value;
        const mcgMin  = conc > 0 ? (mlHr / 60) * conc : 0;
        const doseRes = mcgMinToUnit(mcgMin, revUnit, weight);
        const mgHr    = (mcgMin * 60) / 1000;
        summary = mlHr + ' mL/h → <strong>' + fmt(doseRes, 3).replace(/\.?0+$/, '') + ' ' + unitLabel(revUnit) + '</strong>';
        cards = [
          { label: 'Dosis (' + unitLabel(revUnit) + ')', value: fmt(doseRes, 4).replace(/\.?0+$/, '') },
          { label: 'mcg/min',    value: fmt(mcgMin, 1) },
          { label: 'mg/h',       value: fmt(mgHr, 3)   },
          { label: 'mL/h',       value: fmt(mlHr, 2)   },
        ];
        break;
      }
      case 'mgh2ml': {
        const mgH    = v('inf-mgh-in');
        const mcgMin = (mgH * 1000) / 60;
        mlHr = conc > 0 ? (mcgMin / conc) * 60 : 0;
        summary = mgH + ' mg/h → <strong>' + fmt(mlHr, 2) + ' mL/h</strong>';
        cards = [
          { label: 'Velocidad (mL/h)', value: fmt(mlHr, 2)   },
          { label: 'mcg/min',          value: fmt(mcgMin, 1)  },
          { label: 'mg/h (entrada)',   value: fmt(mgH, 3)     },
        ];
        break;
      }
      case 'ml2mgh': {
        mlHr = v('inf-mlhr-mgh-in');
        const mcgMin = conc > 0 ? (mlHr / 60) * conc : 0;
        const mgH    = (mcgMin * 60) / 1000;
        summary = mlHr + ' mL/h → <strong>' + fmt(mgH, 3) + ' mg/h</strong>';
        cards = [
          { label: 'mg/h',             value: fmt(mgH, 3)    },
          { label: 'mcg/min',          value: fmt(mcgMin, 1) },
          { label: 'Velocidad (mL/h)', value: fmt(mlHr, 2)   },
        ];
        break;
      }
      case 'mcgmin2ml': {
        const mcgMin = v('inf-mcgmin-in');
        mlHr = conc > 0 ? (mcgMin / conc) * 60 : 0;
        const mgHr   = (mcgMin * 60) / 1000;
        const doseKg = weight > 0 ? mcgMin / weight : 0;
        summary = mcgMin + ' mcg/min → <strong>' + fmt(mlHr, 2) + ' mL/h</strong>';
        cards = [
          { label: 'Velocidad (mL/h)', value: fmt(mlHr, 2)   },
          { label: 'mg/h',             value: fmt(mgHr, 3)   },
          { label: 'mcg/kg/min',       value: fmt(doseKg, 3) },
        ];
        break;
      }
      case 'ml2mcgmin': {
        mlHr = v('inf-mlhr-mcgmin-in');
        const mcgMin = conc > 0 ? (mlHr / 60) * conc : 0;
        const mgHr   = (mcgMin * 60) / 1000;
        const doseKg = weight > 0 ? mcgMin / weight : 0;
        summary = mlHr + ' mL/h → <strong>' + fmt(mcgMin, 1) + ' mcg/min</strong>';
        cards = [
          { label: 'mcg/min',          value: fmt(mcgMin, 1) },
          { label: 'mg/h',             value: fmt(mgHr, 3)   },
          { label: 'mcg/kg/min',       value: fmt(doseKg, 3) },
          { label: 'Velocidad (mL/h)', value: fmt(mlHr, 2)   },
        ];
        break;
      }
    }

    $('inf-summary-text').innerHTML = summary || 'Completa los datos de preparación y dosis objetivo.';
    renderResultGrid(cards);
    updateDurations(mlHr);
    buildTitration(conc, weight);
  }

  // Cambio de modo: mostrar panel correspondiente
  document.querySelectorAll('input[name="infmode"]').forEach(radio => {
    radio.addEventListener('change', function () {
      document.querySelectorAll('.inf-panel').forEach(p => p.style.display = 'none');
      document.getElementById('panel-' + this.value).style.display = '';
      calculate();
    });
  });

  // Preset
  $('inf-preset').addEventListener('change', function () {
    const p = PRESETS[this.value];
    if (!p) {
      $('inf-drug-amount').value = '';
      $('inf-volume').value      = '';
      calculate();
      return;
    }
    $('inf-drug-amount').value = p.amount;
    $('inf-drug-unit').value   = p.unit;
    $('inf-volume').value      = p.vol;
    calculate();
  });

  // Todos los inputs
  document.querySelectorAll('.note-input, .note-input-unit, #inf-drug-unit, #inf-dose-unit, #inf-rev-unit').forEach(el => {
    el.addEventListener('input', calculate);
  });

  calculate();

})();

function toggleInfo() {
  var c = document.getElementById('infoContent');
  c.style.display = (c.style.display === 'none' || c.style.display === '') ? 'block' : 'none';
}
</script>

<?php require("../footer.php"); ?>
