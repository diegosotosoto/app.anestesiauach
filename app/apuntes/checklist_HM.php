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
      --brand:#7b1e2b;
      --brand2:#b73445;
      --soft-red:#fbeaec;
      --soft-red-border:#efc7cd;
      --teal:#4f9c9b;
      --soft-green:#edf8f7;
      --soft-green-border:#cfe8e6;
      --warn:#fff6df;
      --warn-border:#ecd798;
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
    .decision{background:var(--soft-red);border:1px solid var(--soft-red-border);border-radius:1rem;}
    .good-box{background:var(--soft-green);border:1px solid var(--soft-green-border);border-radius:1rem;}
    .warning-box{background:var(--warn);border:1px solid var(--warn-border);border-radius:1rem;}
    .check-item{padding:.75rem .9rem;border-radius:.9rem;background:#f8f9fa;border:1px solid #eceff3;display:block;}
    .check-item.done{background:#edf8f7;border-color:#c6e4e2;}
    .subtle{font-size:.92rem;color:#5f6b76;}
    .sticky-tools{position:sticky;top:0;z-index:1000;background:rgba(255,255,255,.95);backdrop-filter:blur(8px);border-bottom:1px solid #e9ecef;}
    .pill{display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.78rem;background:#eef3ff;color:#3559b7;font-weight:600}
    .small-table td,.small-table th{padding:.45rem .5rem;font-size:.86rem;vertical-align:middle;}
    .drug-badge{display:inline-block;padding:.3rem .55rem;border-radius:999px;font-size:.8rem;border:1px solid #d7dde6;background:#fff;margin:.15rem;}
    .footer-note{font-size:.8rem;color:#6c757d;}
    .mono{font-variant-numeric:tabular-nums;}
    @media (max-width:576px){
      .small-table td,.small-table th{padding:.35rem .4rem;font-size:.78rem;}
      .btn{--bs-btn-padding-y:.45rem}
      .check-item{padding:.65rem .75rem;}
    }
  </style>


<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="hk-shell">



  <div class="topbar p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-start gap-3">
      <div>
        <div class="small opacity-75 mb-1">APP clínica • checklist interactivo</div>
        <h1 class="h3 mb-2">Hipertermia Maligna</h1>
        <div class="subtle text-white-50">Checklist interactivo basado en la guía clínica de la Sociedad de Anestesiología de Chile.</div>
      </div>
      <span class="pill bg-light text-dark">SACHILE</span>
    </div>
  </div>

  <div class="sticky-tools p-3">
    <div class="row g-2 align-items-center">
      <div class="col-12 col-md-6">
        <div class="small text-muted mb-1">Progreso del checklist</div>
        <div class="progress" style="height:10px;">
          <div id="progressBar" class="progress-bar bg-danger" role="progressbar" style="width:0%"></div>
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
    <div class="accordion" id="hmAccordion">

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button js-accordion-toggle" type="button" data-bs-target="#hm0" aria-expanded="true">
            1. Sospecha diagnóstica inmediata
          </button>
        </h2>
        <div id="hm0" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <div class="section-title mb-2">Estar atento a los signos clínicos</div>
            <div class="d-grid gap-2">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Aumento real y significativo de ETCO₂ con ventilación adecuada.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Taquicardia / hipertensión / taquipnea sin otra causa clara.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Rigidez muscular o espasmo del masetero tras succinilcolina.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Aumento rápido de la temperatura corporal (signo tardío).</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Acidosis, hiperkalemia, mioglobinuria, arritmias o coagulopatía.</label>
            </div>

            <div class="table-responsive mt-3">
              <table class="table table-bordered small-table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Criterio</th>
                    <th>Dato guía</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td>Acidosis respiratoria</td><td>ETCO₂ >55 mmHg o PaCO₂ >60 mmHg con ventilación adecuada.</td></tr>
                  <tr><td>Acidosis metabólica</td><td>Déficit de base &lt; -8 mEq/L o pH &lt;7.25.</td></tr>
                  <tr><td>Destrucción muscular</td><td>CK &gt;10.000 U/L, coluria, mioglobinuria o K &gt;6 mEq/L.</td></tr>
                  <tr><td>Temperatura</td><td>Elevación rápida, T° &gt;38,8 °C.</td></tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#hm1">
            2. Tratamiento agudo inmediato
          </button>
        </h2>
        <div id="hm1" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="decision p-3 mb-3">
              <div class="fw-semibold mb-1">Prioridad</div>
              <div class="subtle">Actuar precozmente, pedir ayuda y administrar dantrolene lo antes posible.</div>
            </div>

            <div class="d-grid gap-2">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Pedir ayuda y solicitar dantrolene en pabellón.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Suspender halogenados y succinilcolina.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Hiperventilar con O₂ al 100% con flujos altos (≥10 L/min).</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Avisar al cirujano y finalizar el procedimiento lo antes posible.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Destinar personal a preparar dantrolene.</label>
            </div>

            <div class="warning-box p-3 mt-3">
              <div class="fw-semibold mb-2">Preparación del dantrolene</div>
              <ul class="mb-0">
                <li>Cada frasco contiene <strong>20 mg</strong> de dantrolene y 3 g de manitol.</li>
                <li>Disolver cada frasco en <strong>60 mL</strong> de agua bidestilada estéril.</li>
                <li>Mezclar/batir vigorosamente.</li>
                <li>Usar jeringa de 60 mL con aguja gruesa 19G.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#hm2">
            3. Calculadora de dantrolene
          </button>
        </h2>
        <div id="hm2" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3 align-items-end mb-3">
              <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Peso del paciente (kg)</label>
                <input id="weightInput" type="number" min="1" step="0.1" class="form-control" placeholder="Ej: 70">
              </div>
              <div class="col-12 col-md-4">
                <button id="calcDoseBtn" class="btn btn-danger w-100">Calcular</button>
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
                      <th>Frascos aprox.</th>
                      <th>Volumen reconstituido</th>
                      <th>Dosis objetivo 10 mg/kg</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td id="outWeight" class="mono"></td>
                      <td id="outBolus" class="mono"></td>
                      <td id="outVials" class="mono"></td>
                      <td id="outVolume" class="mono"></td>
                      <td id="outTarget" class="mono"></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="good-box p-3 mt-2">
                <div class="fw-semibold mb-1">Regla de repetición</div>
                <div class="subtle">Si persisten taquicardia, rigidez, aumento del ETCO₂ o temperatura, repetir <strong>2,5 mg/kg</strong> cada <strong>5–10 min</strong>. La guía señala que puede requerirse una dosis total &gt;10 mg/kg (hasta 30 mg/kg), aunque recomienda no superar <strong>400 mg/día</strong>.</div>
              </div>
            </div>

            <div class="d-grid gap-2 mt-3">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Calculé bolo inicial 2,5 mg/kg.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Estimé cantidad de frascos y agua requerida.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Tengo plan para repetir cada 5–10 min si persisten signos.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#hm3">
            4. Corrección de acidosis, hipertermia e hiperkalemia
          </button>
        </h2>
        <div id="hm3" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <div class="warning-box p-3 h-100">
                  <div class="fw-semibold mb-2">Acidosis / hipertermia</div>
                  <ul class="mb-0">
                    <li>Bicarbonato guiado por gases; si no hay gases: 1–2 mEq/kg IV.</li>
                    <li>Lavado de cavidades con solución salina helada.</li>
                    <li>Solución fisiológica fría IV. <strong>No usar Ringer lactato.</strong></li>
                    <li>Hielo o sábana hipotérmica.</li>
                    <li>Monitorizar temperatura central continuamente.</li>
                    <li>Detener enfriamiento si T° &lt; 38 °C.</li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="decision p-3 h-100">
                  <div class="fw-semibold mb-2">Hiperkalemia</div>
                  <ul class="mb-0">
                    <li>Hiperventilación, calcio, bicarbonato, glucosa e insulina.</li>
                    <li>Calcio: cloruro 10 mg/kg o gluconato 10–50 mg/kg EV lento.</li>
                    <li>Bicarbonato: 1–2 mEq/kg IV.</li>
                    <li>Adultos: 80 mL G30% + 10 U insulina IV en 30 min.</li>
                    <li>Niños: 80 mL G30% + 5 U insulina; dosis 1,6 mL/kg IV en 30 min.</li>
                    <li>Controlar glicemia cada 2 h o más frecuente si se requiere.</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 mt-3">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Corregí acidosis con bicarbonato según gases o esquema empírico.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Inicié enfriamiento activo y monitorización de temperatura central.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Tratamiento de hiperkalemia iniciado si corresponde.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#hm4">
            5. Arritmias, monitorización y diuresis
          </button>
        </h2>
        <div id="hm4" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="good-box p-3 mb-3">
              <div class="fw-semibold mb-2">Arritmias</div>
              <div class="subtle">Suelen responder al tratamiento de la acidosis e hiperkalemia. Si persisten o comprometen la vida, usar antiarrítmicos comunes, <strong>excepto bloqueadores de canales de calcio</strong>. La guía indica usar protocolo ACLS. No asociar calcioantagonistas con dantrolene.</div>
            </div>

            <div class="d-grid gap-2 mb-3">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Evité bloqueadores de canales de calcio.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Solicité/controlé ETCO₂, gases, temperatura central, CK, potasio, calcio, coagulación y diuresis.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Mantuve diuresis &gt;1 mL/kg/h con SF fría ± manitol/furosemida.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Instalé sonda Foley.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Consideré monitorización invasiva según cambios de volumen e inestabilidad hemodinámica.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#hm5">
            6. Fase post-aguda / UCI
          </button>
        </h2>
        <div id="hm5" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="warning-box p-3 mb-3">
              <div class="fw-semibold mb-2">Riesgo de recaída</div>
              <div class="subtle">La guía recomienda observación en UCI al menos 24 h. Puede haber recaída en 24–36 h y se describe hasta en 25% de los casos.</div>
            </div>
            <div class="d-grid gap-2">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Ingresé/solicité UCI por al menos 24 h.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Indiqué dantrolene 1 mg/kg IV cada 4–6 h o infusión 0,25 mg/kg/h por al menos 24 h.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Consideré luego dantrolene VO 1 mg/kg cada 6 h por 24 h si es necesario.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Control continuo de temperatura central hasta estabilización.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Terapia intensiva estándar de rabdomiolisis/mioglobinuria con meta de diuresis 2 mL/kg/h.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Controlé gases, CK, K, Ca, mioglobina urinaria/sérica y coagulación cada 6 h hasta normalización.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#hm6">
            7. Complicaciones y consejo familiar
          </button>
        </h2>
        <div id="hm6" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="mb-3">
              <span class="drug-badge">Insuficiencia renal aguda</span>
              <span class="drug-badge">Coagulopatía de consumo</span>
              <span class="drug-badge">Hiperkalemia</span>
              <span class="drug-badge">Edema/necrosis muscular</span>
              <span class="drug-badge">Secuela neurológica</span>
              <span class="drug-badge">Hipotermia inadvertida</span>
              <span class="drug-badge">Alteraciones de la conducción</span>
              <span class="drug-badge">Recurrencia de HM</span>
            </div>
            <div class="d-grid gap-2">
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Vigilé activamente complicaciones de la crisis.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Aconsejé al paciente y familia sobre HM y precauciones futuras.</label>
              <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Referí/consideré derivación al Comité de Hipertermia Maligna de la Sociedad Chilena de Anestesiología.</label>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item section-card mb-3">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#hm8">
            8. Registro rápido
          </button>
        </h2>
        <div id="hm8" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Hora sospecha HM</label>
                <input type="time" id="timeStart" class="form-control">
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Peso (kg)</label>
                <input type="number" min="1" step="0.1" id="weightLog" class="form-control">
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Temperatura máxima (°C)</label>
                <input type="number" min="30" step="0.1" id="tempMax" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Notas clínicas</label>
                <textarea id="notesBox" rows="5" class="form-control" placeholder="Ej: ETCO2, rigidez, temperatura, dosis de dantrolene, hiperkalemia, respuesta clínica..."></textarea>
              </div>
            </div>
            <div class="mt-3 d-flex flex-wrap gap-2">
              <button id="copySummaryBtn" class="btn btn-danger">Copiar resumen</button>
              <button id="downloadTxtBtn" class="btn btn-outline-secondary">Descargar TXT</button>
            </div>
            <div id="copyFeedback" class="small text-success mt-2 d-none">Resumen copiado al portapapeles.</div>
          </div>
        </div>
      </div>

    </div>

    <div class="footer-note mt-4">
      Esta herramienta resume y organiza la guía clínica en formato interactivo para uso rápido. Debe usarse junto al juicio clínico y los protocolos institucionales.
    </div>

  </div>
  </div>
  </div>
</div>
</div>




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
    ['weightInput','weightLog','timeStart','tempMax','notesBox'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
    document.getElementById('doseResult').classList.add('d-none');
    document.getElementById('copyFeedback').classList.add('d-none');
    updateProgress();
    window.scrollTo({top:0, behavior:'smooth'});
  });

  function renderDose(weight) {
    if (!weight || weight <= 0) return;
    const bolusMg = 2.5 * weight;
    const vialsInitial = Math.ceil(bolusMg / 20);
    const volumeInitial = vialsInitial * 60;
    const target10 = 10 * weight;

    document.getElementById('outWeight').textContent = weight.toFixed(1) + ' kg';
    document.getElementById('outBolus').textContent = bolusMg.toFixed(1) + ' mg';
    document.getElementById('outVials').textContent = vialsInitial + ' frascos';
    document.getElementById('outVolume').textContent = volumeInitial + ' mL';
    document.getElementById('outTarget').textContent = target10.toFixed(1) + ' mg';
    document.getElementById('doseResult').classList.remove('d-none');
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
    const tempMax = document.getElementById('tempMax').value || '-';
    const notes = document.getElementById('notesBox').value.trim() || '-';

    const checkedItems = checks
      .filter(c => c.checked)
      .map(c => '- ' + c.parentElement.textContent.trim())
      .join('\n') || '- Ninguno';

    return [
      'CHECKLIST HIPERTERMIA MALIGNA',
      'Hora sospecha: ' + timeStart,
      'Peso: ' + weightLog + ' kg',
      'T° máxima: ' + tempMax + ' °C',
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
    a.download = 'checklist_hipertermia_maligna_SACHILE.txt';
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

