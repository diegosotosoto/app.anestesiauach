<?php
$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Anticoagulantes / Antiagregantes 
              ";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("Kopp, S. L., Vandermeulen, E., McBane, R. D., Perlas, A., Leffert, L., & Horlocker, T. (2025). Regional anesthesia in the patient receiving antithrombotic or thrombolytic therapy: American Society of Regional Anesthesia and Pain Medicine Evidence-Based Guidelines (fifth edition). Regional Anesthesia and Pain Medicine. https://doi.org/10.1136/rapm-2024-105766"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-pills pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Anticoagulantes / Antiagregantes";//texto obligatorio
  ?>



<?php

  // Ve si está activa la cookie o redirige al login
  // if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
  //  header('Location: ../login.php');
  // }

  //Conexión
  require("../conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");

  //Variables
    $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
    $titulo_navbar="<span class='text-white'>Apuntes</span>";
    $boton_navbar="<button class='navbar-toggler text-white shadow-sm' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>";

  //Carga Head de la página
  require("head.php");
 

  ?>
  <style>
    :root{
      --brand:#27458f;
      --teal:#4f9c9b;
      --salmon:#e97a66;
      --sky:#79b8df;
      --warn:#f2c76b;
      --bg:#f4f7fb;
    }
    body{background:var(--bg);}


.topbar{
  background:linear-gradient(135deg,var(--brand),#3559b7);
  color:#fff;
  border-radius:1.5rem;
  margin-bottom:1rem;
} 

    .section-card{border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);}
    .section-title{font-size:.78rem;letter-spacing:.06em;text-transform:uppercase;color:#6c757d;}
    .decision{background:#fff5f3;border:1px solid #ffd2ca;border-radius:1rem;}
    .warning-box{background:#fff9e8;border:1px solid #f1df9d;border-radius:1rem;}
    .good-box{background:#edf8f7;border:1px solid #cfe8e6;border-radius:1rem;}
    .check-item{padding:.75rem .9rem;border-radius:.9rem;background:#f8f9fa;border:1px solid #eceff3;}
    .check-item.done{background:#edf8f7;border-color:#c6e4e2;}
    .subtle{font-size:.92rem;color:#5f6b76;}
    .mono{font-variant-numeric:tabular-nums;}
    .sticky-tools{position:sticky;top:0;z-index:1000;background:rgba(255,255,255,.95);backdrop-filter:blur(8px);border-bottom:1px solid #e9ecef;}
    .pill{display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.78rem;background:#eef3ff;color:#3559b7;font-weight:600}
    .small-table td,.small-table th{padding:.45rem .5rem;font-size:.86rem;vertical-align:middle;}
    .footer-note{font-size:.8rem;color:#6c757d;}
    @media (max-width:576px){
      .small-table td,.small-table th{padding:.35rem .4rem;font-size:.78rem;}
      .btn{--bs-btn-padding-y:.45rem}
    }
  </style>




</head>
<body>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="hk-shell">


  <div class="topbar p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-start gap-3">
      <div>
        <div class="small opacity-75 mb-1">APP clínica • checklist interactivo</div>
        <h1 class="h3 mb-2">LAST / Toxicidad sistémica por anestésicos locales</h1>
        <div class="subtle text-white-50">Basado en checklist ASRA 2020. Herramienta interactiva para apoyo dentro de la app.</div>
      </div>
      <span class="pill bg-light text-dark">ASRA 2020</span>
    </div>
  </div>

  <div class="sticky-tools p-3">
    <div class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="small text-muted mb-1">Progreso del checklist</div>
        <div class="progress" style="height:10px;">
          <div id="progressBar" class="progress-bar" role="progressbar" style="width:0%"></div>
        </div>
      </div>
      <div class="col-12 col-md-6 text-md-end">
        <button id="expandAllBtn" class="btn btn-outline-secondary btn-sm">Expandir todo</button>
        <button id="collapseAllBtn" class="btn btn-outline-secondary btn-sm">Colapsar todo</button>
        <button id="resetBtn" class="btn btn-outline-danger btn-sm">Reiniciar</button>
      </div>
    </div>
  </div>

  <div class="p-3 p-md-4">
    <div class="accordion" id="lastAccordion">

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header" id="heading0">
         <button class="accordion-button js-accordion-toggle" type="button" data-bs-target="#collapse0" aria-expanded="true">1. Acciones inmediatas
          </button>
        </h2>
        <div id="collapse0" class="accordion-collapse collapse show" data-bs-parent="#lastAccordion">
          <div class="accordion-body">
            <div class="section-title mb-2">Prioridad inicial</div>
            <div class="d-grid gap-2">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Solicitar ayuda de inmediato.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Buscar kit de rescate de LAST.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Considerar activación temprana de equipo de circulación extracorpórea / bypass cardiopulmonar si el contexto lo permite.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Considerar administración precoz de emulsión lipídica 20%.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Suspender de inmediato la administración de anestésico local.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header" id="heading1">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#collapse1">
            2. Emulsión lipídica 20%
          </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#lastAccordion">
          <div class="accordion-body">
            <div class="good-box p-3 mb-3">
              <div class="fw-semibold mb-1">Nota</div>
              <div class="subtle">El orden de administración y el método de infusión no son críticos. Lo importante es administrarla precozmente.</div>
            </div>

            <div class="row g-3 align-items-end mb-3">
              <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Peso del paciente (kg)</label>
                <input id="weightInput" type="number" min="1" step="0.1" class="form-control" placeholder="Ej: 65">
              </div>
              <div class="col-12 col-md-4">
                <button id="calcDoseBtn" class="btn btn-primary w-100">Calcular dosis</button>
              </div>
              <div class="col-12 col-md-4">
                <button id="fillDemoBtn" class="btn btn-outline-secondary w-100">Ejemplo 70 kg</button>
              </div>
            </div>

            <div id="doseResult" class="d-none">
              <div class="table-responsive">
                <table class="table table-bordered small-table align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Peso</th>
                      <th>Bolo inicial</th>
                      <th>Velocidad infusión</th>
                      <th>Dosis máxima</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td id="outWeight" class="mono"></td>
                      <td id="outBolus" class="mono"></td>
                      <td id="outInfusion" class="mono"></td>
                      <td id="outMax" class="mono"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="warning-box p-3 mt-2">
                <div class="fw-semibold mb-1">Si el paciente sigue inestable</div>
                <ul class="mb-0">
                  <li>Repetir el bolo.</li>
                  <li>Duplicar la velocidad de infusión.</li>
                </ul>
              </div>
            </div>

            <div class="subtle mt-3">
              <strong>Regla del checklist:</strong><br>
              <span class="mono">≥70 kg:</span> bolo aproximado 100 mL en 2–3 min + infusión 250 mL en 15–20 min.<br>
              <span class="mono">&lt;70 kg:</span> bolo 1.5 mL/kg en 2–3 min + infusión 0.25 mL/kg/min.
            </div>

            <div class="d-grid gap-2 mt-3">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Emulsión lipídica disponible/preparada.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Bolo inicial administrado.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Infusión continua iniciada.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header" id="heading2">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#collapse2">
            3. ¿Convulsión?
          </button>
        </h2>
        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#lastAccordion">
          <div class="accordion-body">
            <div class="decision p-3 mb-3">
              <div class="fw-semibold mb-1">Objetivo</div>
              <div class="subtle">Control temprano de la vía aérea y manejo de convulsiones con la estrategia recomendada.</div>
            </div>
            <div class="d-grid gap-2">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Asegurar vía aérea y ventilación adecuadas.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Usar benzodiazepina como primera elección si hay convulsión.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Si solo hay propofol disponible, usar dosis bajas/tituladas (ejemplo del checklist: incrementos de 20 mg).</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header" id="heading3">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#collapse3">
            4. ¿Arritmia o hipotensión?
          </button>
        </h2>
        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#lastAccordion">
          <div class="accordion-body">
            <div class="warning-box p-3 mb-3">
              <div class="fw-semibold mb-1">Ojo</div>
              <div class="subtle">La reanimación en LAST es <strong>diferente</strong> del ACLS estándar.</div>
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <div class="good-box p-3 h-100">
                  <div class="fw-semibold mb-2">Epinefrina</div>
                  <ul class="mb-0">
                    <li>Dosis menores a las habituales.</li>
                    <li>Comenzar con ≤1 mcg/kg.</li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="decision p-3 h-100">
                  <div class="fw-semibold mb-2">Evitar</div>
                  <ul class="mb-0">
                    <li>Anestésicos locales adicionales.</li>
                    <li>Beta-bloqueadores.</li>
                    <li>Bloqueadores de canales de calcio.</li>
                    <li>Vasopresina.</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="d-grid gap-2 mt-3">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Consideré que este paro/arritmia puede corresponder a LAST y adapté la reanimación.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Epinefrina usada en dosis pequeñas, si fue necesaria.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Evité vasopresina, beta-bloqueadores y calcioantagonistas.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header" id="heading4">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#collapse4">
            5. Si el paciente está estable
          </button>
        </h2>
        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#lastAccordion">
          <div class="accordion-body">
            <div class="d-grid gap-2 mb-3">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Continuar emulsión lipídica al menos 15 min una vez alcanzada estabilidad hemodinámica.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Verificar no exceder dosis máxima total de lípidos: 12 mL/kg.</label>
            </div>

            <div class="good-box p-3">
              <div class="fw-semibold mb-2">Observación posterior una vez estable</div>
              <ul class="mb-0">
                <li>2 horas después de convulsión.</li>
                <li>4–6 horas después de inestabilidad cardiovascular.</li>
                <li>Más tiempo según contexto, por ejemplo tras paro cardíaco.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header" id="heading5">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#collapse5">
            6. Registro rápido
          </button>
        </h2>
        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#lastAccordion">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Hora de sospecha de LAST</label>
                <input type="time" id="timeStart" class="form-control">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Peso (kg)</label>
                <input type="number" min="1" step="0.1" id="weightLog" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Notas clínicas</label>
                <textarea id="notesBox" rows="5" class="form-control" placeholder="Ej: bloqueo interescalénico, parestesias, convulsión, bolo lipídico iniciado, respuesta hemodinámica..."></textarea>
              </div>
            </div>
            <div class="mt-3 d-flex flex-wrap gap-2">
              <button id="copySummaryBtn" class="btn btn-primary">Copiar resumen</button>
              <button id="downloadTxtBtn" class="btn btn-outline-secondary">Descargar TXT</button>
            </div>
            <div id="copyFeedback" class="small text-success mt-2 d-none">Resumen copiado al portapapeles.</div>
          </div>
        </div>
      </div>

    </div>

    <div class="footer-note mt-4">
      Herramienta interactiva basada en el esquema visual ASRA 2020 para LAST. Úsala como apoyo rápido, no como reemplazo del juicio clínico ni de los protocolos institucionales.
    </div>
  </div>
</div>
  </div>
</div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    const accordionButtons = Array.from(document.querySelectorAll('.js-accordion-toggle'));

      accordionButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();

          const targetSelector = this.getAttribute('data-bs-target');
          const targetEl = document.querySelector(targetSelector);
          if (!targetEl) return;

          const collapseInstance = bootstrap.Collapse.getOrCreateInstance(targetEl, {
            toggle: false
          });

          if (targetEl.classList.contains('show')) {
            collapseInstance.hide();
          } else {
            collapseInstance.show();
          }
        });
      });
  const checks = Array.from(document.querySelectorAll('.task-check'));
  const progressBar = document.getElementById('progressBar');
  const accordions = Array.from(document.querySelectorAll('.accordion-collapse'));
  const expandAllBtn = document.getElementById('expandAllBtn');
  const collapseAllBtn = document.getElementById('collapseAllBtn');
  const resetBtn = document.getElementById('resetBtn');

  function updateProgress() {
    const total = checks.length;
    const done = checks.filter(c => c.checked).length;
    const percent = total ? Math.round((done / total) * 100) : 0;
    progressBar.style.width = percent + '%';
    progressBar.textContent = percent ? percent + '%' : '';
    checks.forEach(ch => {
      const wrapper = ch.closest('.check-item');
      if (wrapper) wrapper.classList.toggle('done', ch.checked);
    });
  }

  checks.forEach(c => c.addEventListener('change', updateProgress));
  updateProgress();

  expandAllBtn.addEventListener('click', () => {
    accordions.forEach(el => bootstrap.Collapse.getOrCreateInstance(el, {toggle:false}).show());
  });

  collapseAllBtn.addEventListener('click', () => {
    accordions.forEach(el => bootstrap.Collapse.getOrCreateInstance(el, {toggle:false}).hide());
  });

  resetBtn.addEventListener('click', () => {
    checks.forEach(c => c.checked = false);
    document.getElementById('weightInput').value = '';
    document.getElementById('weightLog').value = '';
    document.getElementById('timeStart').value = '';
    document.getElementById('notesBox').value = '';
    document.getElementById('doseResult').classList.add('d-none');
    document.getElementById('copyFeedback').classList.add('d-none');
    updateProgress();
    window.scrollTo({top:0, behavior:'smooth'});
  });

  function renderDose(weight) {
    const doseResult = document.getElementById('doseResult');
    const outWeight = document.getElementById('outWeight');
    const outBolus = document.getElementById('outBolus');
    const outInfusion = document.getElementById('outInfusion');
    const outMax = document.getElementById('outMax');

    if (!weight || weight <= 0) return;

    let bolusText = '';
    let infusionText = '';
    if (weight >= 70) {
      bolusText = '≈100 mL en 2–3 min';
      infusionText = '≈250 mL en 15–20 min';
    } else {
      const bolus = (1.5 * weight).toFixed(1);
      const infusion = (0.25 * weight).toFixed(1);
      bolusText = bolus + ' mL en 2–3 min';
      infusionText = infusion + ' mL/min';
    }

    outWeight.textContent = weight.toFixed(1) + ' kg';
    outBolus.textContent = bolusText;
    outInfusion.textContent = infusionText;
    outMax.textContent = (12 * weight).toFixed(1) + ' mL total';
    doseResult.classList.remove('d-none');
  }

  document.getElementById('calcDoseBtn').addEventListener('click', () => {
    const weight = parseFloat(document.getElementById('weightInput').value);
    renderDose(weight);
  });

  document.getElementById('fillDemoBtn').addEventListener('click', () => {
    document.getElementById('weightInput').value = 70;
    renderDose(70);
  });

  function buildSummary() {
    const done = checks.filter(c => c.checked).length;
    const total = checks.length;
    const timeStart = document.getElementById('timeStart').value || '-';
    const weightLog = document.getElementById('weightLog').value || '-';
    const notes = document.getElementById('notesBox').value.trim() || '-';

    const checkedItems = checks
      .filter(c => c.checked)
      .map(c => '- ' + c.parentElement.textContent.trim())
      .join('\n') || '- Ninguno';

    return [
      'CHECKLIST LAST / ASRA 2020',
      'Hora sospecha: ' + timeStart,
      'Peso: ' + weightLog + ' kg',
      'Progreso: ' + done + '/' + total,
      '',
      'Acciones marcadas:',
      checkedItems,
      '',
      'Notas:',
      notes
    ].join('\n');
  }

  document.getElementById('copySummaryBtn').addEventListener('click', async () => {
    const text = buildSummary();
    try {
      await navigator.clipboard.writeText(text);
      document.getElementById('copyFeedback').classList.remove('d-none');
    } catch (e) {
      alert('No se pudo copiar automáticamente. Usa descargar TXT.');
    }
  });

  document.getElementById('downloadTxtBtn').addEventListener('click', () => {
    const text = buildSummary();
    const blob = new Blob([text], {type:'text/plain;charset=utf-8'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'checklist_LAST_ASRA2020.txt';
    a.click();
    URL.revokeObjectURL(a.href);
  });
})();
</script>

  <?php 
    //Cierre Conexión
    $conexion->close();
  ?>


  <?php
    //Conexión
    require("footer.php");

  ?>

