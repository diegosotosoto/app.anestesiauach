<?php
$titulo_pagina = "Reposición de Fluidos en Cx. Plástica";
$navbar_titulo  = "Apuntes";
$boton_toggler  = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar  = "<span class='text-white'>Apuntes</span>";
$boton_navbar   = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info      = "Reposición de Fluidos en Cirugía Plástica";
$descripcion_info = "Calculadora del Radio Intraoperatorio de Fluidos (RIF) para procedimientos de liposucción. El RIF orienta el volumen de reposición intravascular según el aspirado total. Debe complementarse siempre con evaluación clínica, monitorización hemodinámica y débito urinario.";
$formula          = "RIF = Volumen EV administrado ÷ Volumen de aspirado graso. Para aspirados < 4 L: RIF 1,8–2,1. Para aspirados > 5 L: RIF 1,2–1,4.";
$referencias      = array(
  "Rohrich RJ, et al. Practical Approach to Liposuction. Plastic and Reconstructive Surgery. 2021.",
  "ASPS Safety Committee. Evidence-based patient safety advisory: Liposuction. Plast Reconstr Surg. 2009.",
  "Gan TJ, et al. Consensus guidelines for the management of postoperative nausea and vomiting. Anesth Analg. 2020.",
  "ERAS Society. Guidelines for perioperative fluid management.",
  "Recomendaciones docentes locales para cirugía plástica estética.",
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
          .note-input{
            min-height:46px;
            padding:.55rem .75rem;
            font-size:1rem;
          }
          .note-input-unit{
            min-height:46px;
            padding:.55rem .75rem;
            font-size:.95rem;
          }
          .rif-alert{
            display:flex;
            gap:.65rem;
            align-items:flex-start;
            border-radius:.75rem;
            padding:.7rem .9rem;
            font-size:.9rem;
            line-height:1.45;
          }
          .rif-alert i{margin-top:.15rem;flex-shrink:0;}
          .rif-alert-warning{
            background:var(--note-warning-bg,rgba(250,204,21,.12));
            border:1px solid var(--note-warning-border,rgba(250,204,21,.45));
            color:var(--note-text);
          }
          .rif-alert-warning i{color:var(--note-warning-accent,#facc15);}
          .rif-alert-info{
            background:var(--note-brand-soft,#e8f0fe);
            border:1px solid var(--note-brand-soft-border,rgba(178,204,255,.22));
            color:var(--note-text);
          }
          .rif-alert-info i{color:var(--note-brand,#27458f);}
          .rif-alert-danger{
            background:var(--note-danger-bg,#fff0f0);
            border:1px solid var(--note-danger-border,#f5a0a0);
            color:var(--note-text);
          }
          .rif-alert-danger i{color:#e53e3e;}
          .rif-pillars-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.7rem;
          }
          @media(min-width:600px){
            .rif-pillars-grid{grid-template-columns:repeat(4,1fr);}
          }
          .rif-pillar{
            border:1.5px solid var(--note-line);
            border-radius:.9rem;
            padding:.8rem .7rem;
            text-align:center;
            background:var(--note-card,#fff);
          }
          .rif-pillar-icon{
            font-size:1.4rem;
            color:#3559b7;
            margin-bottom:.3rem;
          }
          .rif-pillar-title{
            font-size:.82rem;
            font-weight:800;
            color:var(--note-text);
            margin-bottom:.2rem;
          }
          .rif-pillar-body{
            font-size:.74rem;
            color:var(--note-muted);
            line-height:1.3;
          }
          .rif-pillar-badge{
            display:inline-block;
            margin-top:.3rem;
            font-size:.68rem;
            font-weight:700;
            background:var(--note-warning-bg,rgba(250,204,21,.15));
            color:#92400e;
            border-radius:.4rem;
            padding:.1rem .45rem;
          }
          .gly-table-wrap{overflow-x:auto;}
          .gly-table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            background:var(--note-card,#fff);
            border:1px solid var(--note-line);
            border-radius:1rem;
            overflow:hidden;
          }
          .gly-table th,
          .gly-table td{
            padding:.58rem .65rem;
            border-bottom:1px solid var(--note-line,#eef2f6);
            border-right:1px solid var(--note-line,#eef2f6);
            vertical-align:middle;
            text-align:left;
          }
          .gly-table th{
            background:#3559b7;
            color:#fff;
            font-size:.76rem;
            font-weight:800;
            line-height:1.2;
            white-space:normal;
          }
          .gly-table td{font-size:.88rem;line-height:1.28;}
          .gly-table th:last-child,
          .gly-table td:last-child{border-right:none;}
          .gly-table tr:last-child td{border-bottom:none;}
          .gly-table td:first-child{font-weight:800;color:var(--note-text);}
          .rif-td-ok     {color:#15803d;font-weight:700;}
          .rif-td-warn   {color:#b45309;font-weight:700;}
          .rif-td-neutral{color:var(--note-muted);font-weight:600;}
          .rif-td-danger {color:#c53030;font-weight:700;}
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · CIRUGÍA PLÁSTICA · FLUIDOS</div>
          <h2>Reposición de Fluidos en Cx. Plástica</h2>
          <div class="note-hero-subtitle">Radio Intraoperatorio de Fluidos (RIF) · Liposucción · Manejo guiado por objetivos</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content" style="display:none;">
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

        <!-- ── CALCULADORA RIF ─────────────────────────────────── -->
        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Datos del procedimiento</div>
            <div class="note-grid">
              <div class="note-input-group">
                <label class="note-label">Peso del paciente</label>
                <div class="note-input-inline">
                  <input id="rif-weight" type="text" inputmode="decimal" class="note-input" placeholder="ej. 70">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label">Volumen aspirado (grasa)</label>
                <div class="note-input-inline">
                  <input id="rif-aspirado" type="text" inputmode="decimal" class="note-input" placeholder="ej. 3000">
                  <div class="note-input-unit">mL</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label">Volumen infiltrado (tumescente)</label>
                <div class="note-input-inline">
                  <input id="rif-infiltrado" type="text" inputmode="decimal" class="note-input" placeholder="ej. 4000">
                  <div class="note-input-unit">mL</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label">Volumen EV administrado</label>
                <div class="note-input-inline">
                  <input id="rif-ev" type="text" inputmode="decimal" class="note-input" placeholder="ej. 2500">
                  <div class="note-input-unit">mL</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ── RESUMEN RIF ─────────────────────────────────────── -->
        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resultado RIF</div>
          <div id="rif-summary-text" class="note-summary-box-text">Ingresa el volumen aspirado y el volumen EV administrado para calcular el RIF.</div>
          <div class="note-result-grid-2 mt-2" id="rif-result-grid"></div>
        </div>

        <!-- ── CONTEXTO CLÍNICO: RIF ──────────────────────────── -->
        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Radio Intraoperatorio de Fluidos (RIF)</div>
            <p class="mb-2" style="font-size:.93rem;">El RIF orienta el volumen de reposición intravascular en liposucción. Se define como:</p>
            <div class="note-summary-box mb-3" style="padding:.75rem 1rem;">
              <div class="note-summary-box-text" style="font-size:.95rem;font-weight:600;">RIF = Volumen EV administrado ÷ Volumen de aspirado graso</div>
            </div>
            <div class="note-result-grid-2 mb-3">
              <div class="note-result-card">
                <div class="note-result-card-label">Aspirado &lt; 4 L</div>
                <div class="note-result-card-value">1,8 – 2,1</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Aspirado &gt; 5 L</div>
                <div class="note-result-card-value">1,2 – 1,4</div>
              </div>
            </div>
            <div class="rif-alert rif-alert-warning mb-2">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span>El RIF <strong>no es infalible</strong>. Debe primar siempre el criterio clínico, con monitorización estricta de hemodinamia y débito urinario (sonda Foley).</span>
            </div>
            <div class="rif-alert rif-alert-info">
              <i class="fa-solid fa-circle-info"></i>
              <span>Gran parte del líquido infiltrado (tumescente) se reabsorbe. Esto puede alterar el balance hídrico real y no siempre queda reflejado en el RIF.</span>
            </div>
          </div>
        </div>

        <!-- ── MANEJO MODERNO: GDFT ───────────────────────────── -->
        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Enfoque moderno: Terapia guiada por objetivos (GDFT)</div>
            <p class="mb-3" style="font-size:.93rem;">Las guías actuales (post-2015) favorecen un manejo <strong>individualizado y dinámico</strong>, complementando o reemplazando el uso exclusivo del RIF.</p>

            <div class="rif-pillars-grid mb-3">
              <div class="rif-pillar">
                <div class="rif-pillar-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                <div class="rif-pillar-title">Hemodinamia</div>
                <div class="rif-pillar-body">Presión arterial y frecuencia cardíaca continua</div>
              </div>
              <div class="rif-pillar">
                <div class="rif-pillar-icon"><i class="fa-solid fa-droplet"></i></div>
                <div class="rif-pillar-title">Débito urinario</div>
                <div class="rif-pillar-body">Meta: 0,5–1 mL/kg/h · &gt;2,5 mL/kg/h sugiere sobrecarga</div>
              </div>
              <div class="rif-pillar">
                <div class="rif-pillar-icon"><i class="fa-solid fa-wave-square"></i></div>
                <div class="rif-pillar-title">Variación sistólica</div>
                <div class="rif-pillar-body">SVV o PPV como guía dinámica de precarga</div>
                <div class="rif-pillar-badge">Cuando está disponible</div>
              </div>
              <div class="rif-pillar">
                <div class="rif-pillar-icon"><i class="fa-solid fa-vial"></i></div>
                <div class="rif-pillar-title">Lactato</div>
                <div class="rif-pillar-body">En procedimientos complejos o de alto riesgo</div>
              </div>
            </div>

            <div class="note-section-label mb-2" style="margin-top:.5rem;">Grandes volúmenes (&gt; 5 L de aspirado)</div>
            <div class="rif-alert rif-alert-danger mb-2">
              <i class="fa-solid fa-circle-exclamation"></i>
              <span>Mayor riesgo de <strong>sobrecarga hídrica</strong>, embolia grasa y toxicidad por lidocaína. Requiere monitorización más estricta, posiblemente invasiva, y entorno hospitalario.</span>
            </div>
          </div>
        </div>

        <!-- ── DÉBITO URINARIO: REFERENCIA ───────────────────── -->
        <div class="note-card mb-4">
          <div class="note-card-body">
            <div class="note-section-label">Referencia: Débito urinario intraoperatorio</div>
            <p style="font-size:.88rem;color:var(--note-muted);margin-bottom:.75rem;">Monitorizado en tiempo real mediante sonda Foley. Meta habitual: 0,5–1 mL/kg/h.</p>
            <div class="gly-table-wrap">
              <table class="gly-table">
                <thead>
                  <tr>
                    <th>Débito urinario</th>
                    <th>Interpretación</th>
                    <th>Conducta sugerida</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>&lt; 0,5 mL/kg/h</td>
                    <td class="rif-td-warn">Oliguria / posible hipovolemia</td>
                    <td>Evaluar volemia, considerar bolo cuidadoso</td>
                  </tr>
                  <tr>
                    <td>0,5 – 1 mL/kg/h</td>
                    <td class="rif-td-ok">Rango objetivo ✓</td>
                    <td>Mantener conducta actual</td>
                  </tr>
                  <tr>
                    <td>1 – 2,5 mL/kg/h</td>
                    <td class="rif-td-neutral">Límite superior aceptable</td>
                    <td>Reducir aporte EV, monitorizar</td>
                  </tr>
                  <tr>
                    <td>&gt; 2,5 mL/kg/h</td>
                    <td class="rif-td-danger">Posible sobrecarga moderada</td>
                    <td>Restringir fluidos, reevaluar balance</td>
                  </tr>
                </tbody>
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

  const $ = id => document.getElementById(id);
  function v(id) { return parseFloat(($(id).value || '').replace(',', '.')) || 0; }

  function fmt(n, dec) {
    if (!isFinite(n) || n <= 0) return '—';
    return n.toFixed(dec);
  }

  function rifClass(rif, aspiradoL) {
    if (rif <= 0) return '';
    if (aspiradoL < 4) {
      if (rif >= 1.8 && rif <= 2.1) return 'rif-ok';
      if (rif > 2.1) return 'rif-high';
      return 'rif-low';
    } else {
      if (rif >= 1.2 && rif <= 1.4) return 'rif-ok';
      if (rif > 1.4) return 'rif-high';
      return 'rif-low';
    }
  }

  function rifLabel(rif, aspiradoL) {
    if (rif <= 0) return '';
    if (aspiradoL < 4) {
      if (rif >= 1.8 && rif <= 2.1) return 'Dentro del rango recomendado (1,8–2,1)';
      if (rif > 2.1) return 'Por encima del rango — evaluar sobrecarga';
      return 'Por debajo del rango — evaluar hipovolemia';
    } else {
      if (rif >= 1.2 && rif <= 1.4) return 'Dentro del rango recomendado (1,2–1,4)';
      if (rif > 1.4) return 'Por encima del rango — evaluar sobrecarga';
      return 'Por debajo del rango — evaluar hipovolemia';
    }
  }

  function renderGrid(gridId, cards) {
    const grid = $(gridId);
    grid.innerHTML = '';
    cards.forEach(c => {
      const div = document.createElement('div');
      div.className = 'note-result-card' + (c.cls ? ' ' + c.cls : '');
      div.innerHTML =
        '<div class="note-result-card-label">' + c.label + '</div>' +
        '<div class="note-result-card-value">'  + c.value + '</div>' +
        (c.note ? '<div class="note-result-card-note">' + c.note + '</div>' : '');
      grid.appendChild(div);
    });
  }

  function calculate() {
    const weight     = v('rif-weight');
    const aspirado   = v('rif-aspirado');
    const infiltrado = v('rif-infiltrado');
    const ev         = v('rif-ev');

    // ── RIF ──
    const aspiradoL = aspirado / 1000;
    const rif       = (aspirado > 0 && ev > 0) ? ev / aspirado : 0;
    const rifRange  = aspiradoL > 0 && aspiradoL < 4 ? '1,8–2,1' : aspiradoL >= 5 ? '1,2–1,4' : '—';

    let summary = 'Ingresa el volumen aspirado y el volumen EV administrado para calcular el RIF.';
    const cards = [];

    if (aspirado > 0 && ev > 0) {
      const cls   = rifClass(rif, aspiradoL);
      const lbl   = rifLabel(rif, aspiradoL);
      summary = lbl;
      cards.push({ label: 'RIF calculado',       value: rif.toFixed(2), note: 'Rango: ' + rifRange, cls });
      cards.push({ label: 'Volumen EV (mL)',      value: fmt(ev, 0) });
      cards.push({ label: 'Aspirado graso (mL)',  value: fmt(aspirado, 0) });
    }
    if (infiltrado > 0 && ev > 0) {
      const balance = ev + infiltrado - aspirado;
      cards.push({ label: 'Balance estimado (mL)', value: (balance >= 0 ? '+' : '') + fmt(Math.abs(balance), 0), note: balance >= 0 ? 'Positivo' : 'Negativo' });
    }

    $('rif-summary-text').textContent = summary;
    renderGrid('rif-result-grid', cards);
  }

  document.querySelectorAll('.note-input').forEach(el => el.addEventListener('input', calculate));
  calculate();

})();

function toggleInfo() {
  var c = document.getElementById('infoContent');
  c.style.display = (c.style.display === 'none' || c.style.display === '') ? 'block' : 'none';
}
</script>

<?php require("../footer.php"); ?>
