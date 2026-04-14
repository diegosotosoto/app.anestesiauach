<?php 
$titulo_info = "Utilidad Clínica";
$descripcion_info = "Preparación de pabellón en paciente susceptible de Hipertermia Maligna, según las recomendaciones actuales de la SACHILE.";
$formula = "";
$referencias = array(
  "Sociedad de Anestesiología de Chile. Manejo de la Crisis de Hipertermia Maligna y para el Manejo del Paciente Susceptible de Hipertermia Maligna."
);
$icono_apunte = "<i class='fa-solid fa-bed-pulse pe-3 pt-2'></i>";
$titulo_apunte = "Preparación de pabellón: paciente susceptible a HM";

require("../conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8");

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<style>
  :root{
    --brand:#7b1e2b;
    --brand2:#b73445;
    --soft-red:#fbeaec;
    --soft-red-border:#efc7cd;
    --soft-green:#edf8f7;
    --soft-green-border:#cfe8e6;
    --warn:#fff6df;
    --warn-border:#ecd798;
    --bg:#f4f7fb;
  }

  body{
    background:var(--bg);
  }

  .hm-shell{
    max-width:980px;
    margin:0 auto;
  }

  .topbar{
    background:linear-gradient(135deg,var(--brand),var(--brand2));
    color:#fff;
    border-radius:1rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
  }

  .section-card{
    border:0;
    border-radius:1rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
  }

  .section-title{
    font-size:.78rem;
    letter-spacing:.06em;
    text-transform:uppercase;
    color:#6c757d;
  }

  .decision{
    background:var(--soft-red);
    border:1px solid var(--soft-red-border);
    border-radius:1rem;
  }

  .good-box{
    background:var(--soft-green);
    border:1px solid var(--soft-green-border);
    border-radius:1rem;
  }

  .warning-box{
    background:var(--warn);
    border:1px solid var(--warn-border);
    border-radius:1rem;
  }

  .check-item{
    padding:.75rem .9rem;
    border-radius:.9rem;
    background:#f8f9fa;
    border:1px solid #eceff3;
    display:block;
  }

  .check-item.done{
    background:#edf8f7;
    border-color:#c6e4e2;
  }

  .subtle{
    font-size:.92rem;
    color:#5f6b76;
  }

  .sticky-tools{
    position:sticky;
    top:0;
    z-index:1000;
    background:rgba(255,255,255,.95);
    backdrop-filter:blur(8px);
    border-bottom:1px solid #e9ecef;
  }

  .pill{
    display:inline-block;
    padding:.2rem .55rem;
    border-radius:999px;
    font-size:.78rem;
    background:#eef3ff;
    color:#3559b7;
    font-weight:600;
  }

  .small-table td,
  .small-table th{
    padding:.45rem .5rem;
    font-size:.86rem;
    vertical-align:middle;
  }

  .drug-badge{
    display:inline-block;
    padding:.3rem .55rem;
    border-radius:999px;
    font-size:.8rem;
    border:1px solid #d7dde6;
    background:#fff;
    margin:.15rem;
  }

  .footer-note{
    font-size:.8rem;
    color:#6c757d;
  }

  .mono{
    font-variant-numeric:tabular-nums;
  }

  .info-box{
    background:#fff;
    border-radius:1rem;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    margin-bottom:1rem;
    overflow:hidden;
  }

  .info-box-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:1rem;
    padding:1rem;
  }

  .info-box-title{
    font-size:.8rem;
    text-transform:uppercase;
    color:#667085;
    letter-spacing:.08em;
  }

  .info-toggle-btn{
    border-radius:.6rem;
    font-size:.85rem;
    padding:.35rem .7rem;
    white-space:nowrap;
    background:#6c757d;
    border:none;
    color:white;
    transition:.2s;
  }

  .info-toggle-btn:hover{
    background:#5a6268;
    color:white;
  }

  .info-box-content{
    padding:1rem;
    display:none;
    animation:fadeIn .2s ease-in-out;
    border-top:1px solid #e9eef5;
  }

  @keyframes fadeIn{
    from{opacity:0; transform:translateY(-5px);}
    to{opacity:1; transform:translateY(0);}
  }

  @media (max-width:576px){
    .small-table td,
    .small-table th{
      padding:.35rem .4rem;
      font-size:.78rem;
    }

    .btn{
      --bs-btn-padding-y:.45rem;
    }

    .check-item{
      padding:.65rem .75rem;
    }

    .info-box-header{
      flex-direction:row;
    }

    .info-toggle-btn{
      margin-left:auto;
    }
  }
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="hm-shell">

        <div class="topbar p-3 p-md-4 mb-3">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • checklist interactivo</div>
              <h1 class="h3 mb-2">Preparación de pabellón en paciente susceptible a Hipertermia Maligna</h1>
              <div class="subtle text-white-50">Checklist interactivo basado en la guía clínica de la Sociedad de Anestesiología de Chile.</div>
            </div>
            <span class="pill bg-light text-dark">SACHILE</span>
          </div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">
              Mostrar / ocultar
            </button>
          </div>
          <div id="infoContent" class="info-box-content">
            <?php echo $descripcion_info; ?>

            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Fórmula:</b><br>
              <?php echo $formula; ?>
            <?php } ?>

            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0">
                <?php foreach($referencias as $ref){ ?>
                  <li><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
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
          <div class="accordion" id="hmPrepAccordion">

            <div class="accordion-item section-card mb-3">
              <h2 class="accordion-header">
                <button class="accordion-button js-accordion-toggle" type="button" data-bs-target="#prep0" aria-expanded="true">
                  1. Identificación del paciente susceptible
                </button>
              </h2>
              <div id="prep0" class="accordion-collapse collapse show" data-bs-parent="#hmPrepAccordion">
                <div class="accordion-body">
                  <div class="section-title mb-2">Confirmar riesgo antes de programar</div>
                  <div class="d-grid gap-2">
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Antecedente personal de crisis previa de HM.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Antecedente familiar de Hipertermia Maligna.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Miopatía predisponente conocida (por ejemplo Central Core disease, Multiminicore disease, síndrome de King-Denborough).</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Consideré otros antecedentes dudosos: rabdomiolisis previa, orinas oscuras, heat stroke, muerte familiar en pabellón o evento anestésico grave no aclarado.</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="accordion-item section-card mb-3">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#prep1" aria-expanded="false">
                  2. Programación y coordinación del pabellón
                </button>
              </h2>
              <div id="prep1" class="accordion-collapse collapse" data-bs-parent="#hmPrepAccordion">
                <div class="accordion-body">
                  <div class="warning-box p-3 mb-3">
                    <div class="fw-semibold mb-2">Objetivo</div>
                    <div class="subtle">Llegar a pabellón con el entorno, personal y recursos ya preparados antes de la inducción.</div>
                  </div>
                  <div class="d-grid gap-2">
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Programé la cirugía idealmente a primera hora de la mañana.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Coordiné con laboratorio la toma de exámenes el día de la cirugía.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Verifiqué disponibilidad de drogas e insumos necesarios para realizar el procedimiento en forma segura.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Aseguré que el personal de apoyo asignado tenga competencias para colaborar con este tipo de paciente.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Solicité apoyo de UCI antes del procedimiento.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Verifiqué disponibilidad de monitor desfibrilador en pabellón.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Dispuse de un algoritmo/póster de tratamiento de crisis de HM en pabellón.</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="accordion-item section-card mb-3">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#prep2" aria-expanded="false">
                  3. Dantrolene y recursos críticos
                </button>
              </h2>
              <div id="prep2" class="accordion-collapse collapse" data-bs-parent="#hmPrepAccordion">
                <div class="accordion-body">
                  <div class="good-box p-3 mb-3">
                    <div class="fw-semibold mb-2">Disponibilidad mínima</div>
                    <div class="subtle">El pabellón que atiende al paciente susceptible debe contar al menos con la primera dosis de dantrolene y verificar disponibilidad de dosis adicionales.</div>
                  </div>

                  <div class="d-grid gap-2 mb-3">
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">La primera dosis de dantrolene está físicamente disponible en pabellón.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Verifiqué si las dosis subsiguientes están disponibles en el mismo centro o mediante convenio.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Confirmé disponibilidad de agua destilada sin bacteriostáticos junto al dantrolene.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Confirmé almacenamiento visible, rotulado, a temperatura ambiente y protegido de la luz.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Revisé fechas de vencimiento del stock.</label>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered small-table align-middle">
                      <thead class="table-light">
                        <tr>
                          <th>Dato práctico</th>
                          <th>Referencia</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr><td>Tratamiento completo sugerido</td><td>10 mg/kg/día</td></tr>
                        <tr><td>Dosis mínima inmediata de ataque durante primera hora</td><td>Aproximadamente 20 frascos para adulto de 70 kg</td></tr>
                        <tr><td>Condición para reducir stock local</td><td>Disponer de dosis subsiguientes en menos de 1 hora mediante convenio</td></tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="accordion-item section-card mb-3">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#prep3" aria-expanded="false">
                  4. Preparación de máquina de anestesia
                </button>
              </h2>
              <div id="prep3" class="accordion-collapse collapse" data-bs-parent="#hmPrepAccordion">
                <div class="accordion-body">
                  <div class="decision p-3 mb-3">
                    <div class="fw-semibold mb-2">Eliminar exposición a gatillantes</div>
                    <div class="subtle">La meta es asegurar una técnica libre de halogenados y succinilcolina desde antes del ingreso del paciente a pabellón.</div>
                  </div>

                  <div class="d-grid gap-2">
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Removí los vaporizadores de la máquina de anestesia.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Si no fue posible removerlos, los vacié y los dejé en posición cerrada.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Consideré cambiar el absorbedor de CO₂.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Realicé lavado de la máquina con O₂ 10 L/min por al menos 20 min.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Si reemplacé la manguera de gas fresco, realicé lavado por al menos 10 min.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Instalé bolsa en la Y del sistema circular y ventilador para inflarla periódicamente durante el lavado.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Usé analizador de gases espirados para confirmar ausencia de anestésico residual.</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="accordion-item section-card mb-3">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#prep4" aria-expanded="false">
                  5. Evaluación preoperatoria y medidas preventivas
                </button>
              </h2>
              <div id="prep4" class="accordion-collapse collapse" data-bs-parent="#hmPrepAccordion">
                <div class="accordion-body">
                  <div class="d-grid gap-2 mb-3">
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Solicité o revisé CK preoperatoria cuando correspondía.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Dispuse sábana enfriadora sobre la mesa quirúrgica si estaba disponible.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Definí técnica anestésica libre de gatillantes.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Planifiqué monitorización básica incluyendo presión arterial, temperatura central, ECG, oximetría de pulso y capnografía.</label>
                    <label class="check-item"><input class="form-check-input me-2 task-check" type="checkbox">Consideré línea arterial, PVC u otro monitoreo invasivo si la cirugía o el paciente lo requerían.</label>
                  </div>

                  <div class="row g-3">
                    <div class="col-12 col-md-6">
                      <div class="good-box p-3 h-100">
                        <div class="fw-semibold mb-2">Drogas/técnicas seguras</div>
                        <div class="mb-2">
                          <span class="drug-badge">Local</span>
                          <span class="drug-badge">Regional</span>
                          <span class="drug-badge">Espinal</span>
                          <span class="drug-badge">Peridural</span>
                          <span class="drug-badge">Propofol / TIVA</span>
                          <span class="drug-badge">Benzodiacepinas</span>
                          <span class="drug-badge">Opioides</span>
                          <span class="drug-badge">Barbitúricos</span>
                          <span class="drug-badge">Ketamina</span>
                          <span class="drug-badge">Óxido nitroso</span>
                          <span class="drug-badge">Etomidato</span>
                          <span class="drug-badge">Rocuronio</span>
                          <span class="drug-badge">Vecuronio</span>
                          <span class="drug-badge">Pancuronio</span>
                          <span class="drug-badge">Atracurio</span>
                          <span class="drug-badge">Mivacurio</span>
                          <span class="drug-badge">Neostigmina</span>
                          <span class="drug-badge">Atropina</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="decision p-3 h-100">
                        <div class="fw-semibold mb-2">Gatillantes inseguros</div>
                        <div class="mb-2">
                          <span class="drug-badge">Sevoflurano</span>
                          <span class="drug-badge">Halotano</span>
                          <span class="drug-badge">Isoflurano</span>
                          <span class="drug-badge">Desflurano</span>
                          <span class="drug-badge">Enflurano</span>
                          <span class="drug-badge">Succinilcolina</span>
                        </div>
                        <div class="subtle">No usar halogenados ni succinilcolina.</div>
                      </div>
                    </div>
                  </div>

                  <div class="warning-box p-3 mt-3">
                    <div class="fw-semibold mb-2">Profilaxis con dantrolene</div>
                    <div class="subtle">No se recomienda para la mayoría de los pacientes susceptibles. Considerarla caso a caso. Si se usa, la dosis sugerida es <strong>2,5 mg/kg IV 30 min antes</strong>. No asociar con bloqueadores del calcio.</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="accordion-item section-card mb-3">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed js-accordion-toggle" type="button" data-bs-target="#prep5" aria-expanded="false">
                  6. Registro rápido
                </button>
              </h2>
              <div id="prep5" class="accordion-collapse collapse" data-bs-parent="#hmPrepAccordion">
                <div class="accordion-body">
                  <div class="row g-3">
                    <div class="col-12 col-md-4">
                      <label class="form-label fw-semibold">Fecha</label>
                      <input type="date" id="dateLog" class="form-control">
                    </div>
                    <div class="col-12 col-md-4">
                      <label class="form-label fw-semibold">Pabellón</label>
                      <input type="text" id="theatreLog" class="form-control" placeholder="Ej: Pabellón 3">
                    </div>
                    <div class="col-12 col-md-4">
                      <label class="form-label fw-semibold">Paciente / iniciales</label>
                      <input type="text" id="patientLog" class="form-control" placeholder="Iniciales o código">
                    </div>
                    <div class="col-12">
                      <label class="form-label fw-semibold">Notas</label>
                      <textarea id="notesBox" rows="5" class="form-control" placeholder="Ej: vaporizadores retirados, lavado 20 min, dantrolene disponible, apoyo UCI confirmado..."></textarea>
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
            Checklist interactivo de preparación de pabellón en paciente susceptible a Hipertermia Maligna. Herramienta de apoyo, no reemplaza protocolos institucionales.
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
  const checks = Array.from(document.querySelectorAll('.task-check'));
  const progressBar = document.getElementById('progressBar');
  const accordions = Array.from(document.querySelectorAll('.accordion-collapse'));
  const expandAllBtn = document.getElementById('expandAllBtn');
  const collapseAllBtn = document.getElementById('collapseAllBtn');
  const resetBtn = document.getElementById('resetBtn');

  function syncAccordionButton(btn, isOpen) {
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    btn.classList.toggle('collapsed', !isOpen);
  }

  accordionButtons.forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();

      const targetSelector = this.getAttribute('data-bs-target');
      const targetEl = document.querySelector(targetSelector);
      if (!targetEl) return;

      const collapseInstance = bootstrap.Collapse.getOrCreateInstance(targetEl, { toggle: false });
      const isOpen = targetEl.classList.contains('show');

      if (isOpen) {
        collapseInstance.hide();
        syncAccordionButton(this, false);
      } else {
        collapseInstance.show();
        syncAccordionButton(this, true);
      }
    });
  });

  accordions.forEach(panel => {
    panel.addEventListener('shown.bs.collapse', function () {
      const btn = document.querySelector('[data-bs-target="#' + this.id + '"]');
      if (btn) syncAccordionButton(btn, true);
    });

    panel.addEventListener('hidden.bs.collapse', function () {
      const btn = document.querySelector('[data-bs-target="#' + this.id + '"]');
      if (btn) syncAccordionButton(btn, false);
    });
  });

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
    accordions.forEach(el => {
      bootstrap.Collapse.getOrCreateInstance(el, {toggle:false}).show();
      const btn = document.querySelector('[data-bs-target="#' + el.id + '"]');
      if (btn) syncAccordionButton(btn, true);
    });
  });

  collapseAllBtn.addEventListener('click', () => {
    accordions.forEach(el => {
      bootstrap.Collapse.getOrCreateInstance(el, {toggle:false}).hide();
      const btn = document.querySelector('[data-bs-target="#' + el.id + '"]');
      if (btn) syncAccordionButton(btn, false);
    });
  });

  resetBtn.addEventListener('click', () => {
    checks.forEach(c => c.checked = false);
    ['dateLog','theatreLog','patientLog','notesBox'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
    document.getElementById('copyFeedback').classList.add('d-none');
    updateProgress();
    window.scrollTo({top:0, behavior:'smooth'});
  });

  function buildSummary() {
    const done = checks.filter(c => c.checked).length;
    const total = checks.length;
    const dateLog = document.getElementById('dateLog').value || '-';
    const theatreLog = document.getElementById('theatreLog').value || '-';
    const patientLog = document.getElementById('patientLog').value || '-';
    const notes = document.getElementById('notesBox').value.trim() || '-';

    const checkedItems = checks
      .filter(c => c.checked)
      .map(c => '- ' + c.parentElement.textContent.trim())
      .join('\n') || '- Ninguno';

    return [
      'CHECKLIST PREPARACIÓN DE PABELLÓN - HM SUSCEPTIBLE',
      'Fecha: ' + dateLog,
      'Pabellón: ' + theatreLog,
      'Paciente: ' + patientLog,
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
    a.download = 'checklist_preparacion_pabellon_HM_susceptible.txt';
    a.click();
    URL.revokeObjectURL(a.href);
  });
})();
</script>
<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php
$conexion->close();
require("footer.php");
?>