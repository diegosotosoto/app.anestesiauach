<?php
$titulo_info = "Utilidad clínica";
$descripcion_info = "Checklist interactivo para sospecha y manejo inicial de toxicidad sistémica por anestésicos locales (LAST), con apoyo para emulsión lipídica, control de convulsión, adaptación de la reanimación y registro rápido del evento.";
$formula = "<strong>Emulsión lipídica 20%</strong><br>
&lt; 70 kg: bolo inicial 1,5 mL/kg en 2–3 min + infusión 0,25 mL/kg/min.<br>
≥ 70 kg: bolo aproximado 100 mL en 2–3 min + luego ~250 mL en 15–20 min.<br>
Dosis máxima orientativa total: 12 mL/kg.";
$referencias = array(
  "Neal JM, Barrington MJ, Fettiplace MR, et al. The Third American Society of Regional Anesthesia and Pain Medicine Practice Advisory on Local Anesthetic Systemic Toxicity. Reg Anesth Pain Med. 2018;43(2):113–123.",
  "American Society of Regional Anesthesia and Pain Medicine (ASRA). Checklist for Treatment of Local Anesthetic Systemic Toxicity. 2020 update.",
  "El-Boghdadly K, Chin KJ. Local anesthetic systemic toxicity: continuing professional development. Can J Anaesth. 2016;63(3):330–349."
);

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=2"></script>

<style>
  .last-shell{max-width:980px;margin:0 auto;}
  .last-section-card{background:var(--note-card);border:1px solid var(--note-line);border-radius:1.25rem;box-shadow:var(--note-shadow);overflow:hidden;margin-bottom:1rem;}

  .last-lipid-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.85rem;}

  .note-hero-emergency{background:linear-gradient(135deg,#8f1f32,#b52d45);}
  .note-hero-emergency .note-badge{background:rgba(255,255,255,.92);color:#6f1524;}

  @media (max-width:768px){
    .last-lipid-grid{grid-template-columns:1fr;}
  }
</style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="last-shell">

        <div class="note-hero note-hero-emergency">
          <div class="note-hero-kicker">APP CLÍNICA · CHECKLIST DE URGENCIA</div>
          <h2>LAST / Toxicidad sistémica por anestésicos locales</h2>
          <p class="note-hero-subtitle">Checklist interactivo según guías ASRA 2020</p>
        </div>

        <div class="note-checklist-progress-block px-3 py-2 mb-3">
          <div class="note-checklist-progress-head">
            <div class="note-checklist-progress-title">Progreso del checklist</div>
            <div id="lastProgressBadge" class="note-checklist-progress-badge">0%</div>
          </div>

          <div class="note-checklist-progress-track">
            <div id="lastProgressFill" class="note-checklist-progress-bar"></div>
          </div>

          <div class="note-checklist-toolbar">
            <button type="button" id="expandAllBtn" class="btn note-checklist-btn">Expandir todo</button>
            <button type="button" id="collapseAllBtn" class="btn note-checklist-btn">Colapsar todo</button>
            <button type="button" id="resetBtn" class="btn note-checklist-btn note-checklist-btn-danger">Reiniciar</button>
          </div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Esquema orientativo:</b><br>
              <?php echo $formula; ?>
            <?php } ?>
            <?php if(!empty($referencias)){ ?>
              <hr>
              <div class="small-note mb-2"><strong>Referencias:</strong></div>
              <ul class="mb-0 ps-3">
                <?php foreach($referencias as $ref){ ?>
                  <li class="mb-2"><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="last-checklist-section" data-section="1">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">1. Acciones inmediatas</h3>
              <p class="last-checklist-help">Orden inicial frente a sospecha de LAST: pedir ayuda, detener exposición y preparar rescate precoz.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="last-checklist-list">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Solicitar ayuda de inmediato</div><p class="last-check-note">Movilizar apoyo clínico, carro de paro y recursos críticos desde el inicio.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Buscar kit de rescate de LAST</div><p class="last-check-note">Priorizar emulsión lipídica y material necesario para vía aérea y reanimación.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Suspender de inmediato el anestésico local</div><p class="last-check-note">Evitar cualquier exposición adicional mientras se confirma o descarta el cuadro.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Considerar emulsión lipídica 20% de forma precoz</div><p class="last-check-note">La oportunidad de administración importa más que detalles menores del método de infusión.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Pensar temprano en soporte circulatorio avanzado si el contexto lo permite</div><p class="last-check-note">Si la inestabilidad es refractaria, anticipar estrategias de soporte extracorpóreo cuando estén disponibles.</p></div>
              </label>
            </div>
          </div>
        </div>

        <div class="last-checklist-section" data-section="2">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">2. Emulsión lipídica 20%</h3>
              <p class="last-checklist-help">Cálculo rápido y recordatorio operativo. Lo relevante es administrarla precozmente.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="note-success mb-3">
              <div class="fw-semibold mb-1">Nota operativa</div>
              <div class="small-note mb-0">El orden exacto y el método de infusión no son lo principal. El mensaje práctico es no retrasar el uso de emulsión lipídica cuando el cuadro lo justifica.</div>
            </div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label" for="weightInput">Peso del paciente</label>
                <div class="note-input-inline">
                  <input id="weightInput" type="text" class="note-input" inputmode="decimal" placeholder="Ej: 65">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label">Acciones rápidas</label>
                <div class="note-choice-grid">
                  <button type="button" id="calcDoseBtn" class="note-action-btn-sm note-action-btn-primary">
                    <i class="fa-solid fa-calculator"></i>
                    <span><span class="note-action-btn-title">Calcular</span><span class="note-action-btn-sub">Basado en el peso ingresado</span></span>
                  </button>
                  <button type="button" id="fillDemoBtn" class="note-action-btn-sm">
                    <i class="fa-solid fa-vial"></i>
                    <span><span class="note-action-btn-title">Ejemplo 70 kg</span><span class="note-action-btn-sub">Llenar con valores de referencia</span></span>
                  </button>
                </div>
              </div>
            </div>

            <div class="note-result-grid-2 mb-3">
              <div class="note-result-card">
                <div class="note-result-card-label">Bolo inicial</div>
                <div id="outBolus" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Bolo orientativo según peso.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Infusión</div>
                <div id="outInfusion" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Velocidad orientativa de inicio.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Peso usado</div>
                <div id="outWeight" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Se usa para cálculo y límites.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Dosis máxima total</div>
                <div id="outMax" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Límite orientativo acumulado.</div>
              </div>
            </div>

            <div class="note-warning mb-3">
              <div class="fw-semibold mb-1">Si el paciente sigue inestable</div>
              <div class="note-chip-list mt-2">
                <span class="note-chip note-chip-warn">Repetir el bolo si el contexto clínico lo exige.</span>
                <span class="note-chip note-chip-warn">Duplicar la velocidad de infusión si persiste compromiso cardiovascular grave.</span>
              </div>
            </div>

            <div class="last-checklist-list">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Emulsión lipídica disponible o preparada</div><p class="last-check-note">Confirmar físicamente disponibilidad al lado del paciente.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Bolo inicial administrado</div><p class="last-check-note">Registrar tiempo aproximado de inicio.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Infusión continua iniciada</div><p class="last-check-note">Mantener vigilancia hemodinámica y neurológica.</p></div>
              </label>
            </div>
          </div>
        </div>

        <div class="last-checklist-section is-collapsed" data-section="3">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">3. ¿Convulsión?</h3>
              <p class="last-checklist-help">Asegurar vía aérea, oxigenación y control anticonvulsivante precoz.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="note-danger mb-3">
              <div class="fw-semibold mb-1">Objetivo</div>
              <div class="small-note mb-0">Control temprano de vía aérea y convulsión. Priorizar benzodiazepinas. Si sólo hay propofol disponible, usarlo en dosis pequeñas y tituladas con cautela.</div>
            </div>

            <div class="last-checklist-list mb-3">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Asegurar vía aérea y ventilación adecuadas</div><p class="last-check-note">Evitar hipoxia, hipercapnia y acidosis que agravan LAST.</p></div>
              </label>
<label class="last-check-item">
  <input class="last-check-input task-check" type="checkbox">
  <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
  <div class="last-check-copy">
    <div class="last-check-title">Usar benzodiazepina como primera elección</div>
    <p class="last-check-note">
      Midazolam 0,1 mg/kg (<span id="convMidazolam">-</span>) o lorazepam 0,2 mg/kg (<span id="convLorazepam">-</span>).
    </p>
  </div>
</label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Si sólo hay propofol, usar pequeñas dosis tituladas</div><p class="last-check-note">Ejemplo operativo del checklist: incrementos bajos y reevaluación frecuente.</p></div>
              </label>
            </div>

            <div class="note-warning">
              <div class="fw-semibold mb-2">Dosis orientativas de benzodiazepinas</div>
              <div id="seizureDoseEmpty" class="small-note mb-0">Ingresa un peso válido en la sección de emulsión lipídica para calcular midazolam y lorazepam.</div>
              <div id="seizureDoseBox" class="d-none">
                <div class="note-result-grid-2">
                  <div class="note-result-card">
                    <div class="note-result-card-label">Peso</div>
                    <div id="szWeight" class="note-result-card-value">-</div>
                    <div class="note-result-card-note">Peso utilizado para las dosis orientativas.</div>
                  </div>
                  <div class="note-result-card">
                    <div class="note-result-card-label">Midazolam</div>
                    <div id="szMidazolam" class="note-result-card-value">-</div>
                    <div class="note-result-card-note">Sugerencia docente: 0,1 mg/kg.</div>
                  </div>
                  <div class="note-result-card">
                    <div class="note-result-card-label">Lorazepam</div>
                    <div id="szLorazepam" class="note-result-card-value">-</div>
                    <div class="note-result-card-note">Sugerencia docente: 0,2 mg/kg.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="last-checklist-section is-collapsed" data-section="4">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">4. ¿Arritmia o hipotensión?</h3>
              <p class="last-checklist-help">Recordatorio: la reanimación en LAST no es ACLS estándar.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="note-chip-grid mb-3">
              <div class="note-success">
                <div class="fw-semibold mb-2">Preferir</div>
                <div class="note-chip-list">
                  <span class="note-chip note-chip-safe">Epinefrina en dosis menores a las habituales.</span>
                  <span class="note-chip note-chip-safe">Comenzar con ≤ 1 mcg/kg si es necesaria.</span>
                  <span class="note-chip note-chip-safe">Amiodarona si aparecen arritmias ventriculares.</span>
                </div>
              </div>
              <div class="note-danger">
                <div class="fw-semibold mb-2">Evitar</div>
                <div class="note-chip-list">
                  <span class="note-chip note-chip-danger">Anestésicos locales adicionales.</span>
                  <span class="note-chip note-chip-danger">Beta-bloqueadores.</span>
                  <span class="note-chip note-chip-danger">Bloqueadores de canales de calcio.</span>
                  <span class="note-chip note-chip-danger">Vasopresina.</span>
                </div>
              </div>
            </div>

            <div class="last-checklist-list">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Adapté la reanimación pensando en LAST</div><p class="last-check-note">No seguir de forma ciega el algoritmo ACLS habitual.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Si usé epinefrina, fue en dosis pequeñas</div><p class="last-check-note">Evitar escaladas agresivas que empeoren la situación.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Evité vasopresina, beta-bloqueadores y calcioantagonistas</div><p class="last-check-note">Punto crítico del checklist para no empeorar la inestabilidad.</p></div>
              </label>
            </div>
          </div>
        </div>

        <div class="last-checklist-section is-collapsed" data-section="5">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">5. Si el paciente está estable</h3>
              <p class="last-checklist-help">Continuar soporte, vigilar recurrencia y observar un tiempo suficiente.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="last-checklist-list mb-3">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Mantener emulsión lipídica al menos 15 min tras estabilidad hemodinámica</div><p class="last-check-note">No suspender precozmente si aún existe riesgo de recaída.</p></div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy"><div class="last-check-title">Verificar no exceder dosis máxima total de lípidos</div><p class="last-check-note">Límite orientativo recordado por el checklist: 12 mL/kg.</p></div>
              </label>
            </div>

            <div class="note-success">
              <div class="fw-semibold mb-2">Observación posterior una vez estable</div>
              <div class="note-chip-list mt-2">
                <span class="note-chip note-chip-safe">2 horas después de convulsión.</span>
                <span class="note-chip note-chip-safe">4–6 horas después de inestabilidad cardiovascular.</span>
                <span class="note-chip note-chip-safe">Más tiempo según contexto, especialmente tras paro cardíaco.</span>
              </div>
            </div>
          </div>
        </div>

        <div class="last-checklist-section is-collapsed" data-section="6">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">6. Registro rápido</h3>
              <p class="last-checklist-help">Registro corto y exportable para dejar trazabilidad básica del evento.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label" for="timeStart">Hora de sospecha de LAST</label>
                <input type="time" id="timeStart" class="note-input">
              </div>
              <div class="note-input-group">
                <label class="note-label" for="weightLog">Peso registrado</label>
                <div class="note-input-inline">
                  <input type="text" id="weightLog" class="note-input" inputmode="decimal" placeholder="Opcional">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>
            </div>
            <div class="note-input-group mb-3">
              <label class="note-label" for="notesBox">Notas clínicas</label>
              <textarea id="notesBox" rows="5" class="note-text-input" placeholder="Ej: bloqueo periférico, síntomas iniciales, convulsión, bolo lipídico iniciado, respuesta hemodinámica..."></textarea>
            </div>

            <div class="iv-record-box">
              <div class="note-card-title mb-2">Registro resumido</div>
              <textarea id="recordOutput" class="iv-record-output"></textarea>
              <div class="note-checklist-toolbar mt-2">
                <button type="button" id="copySummaryBtn" class="btn note-checklist-btn"><i class="fa-solid fa-copy me-1"></i> Copiar</button>
                <button type="button" id="downloadTxtBtn" class="btn note-checklist-btn"><i class="fa-solid fa-file-arrow-down me-1"></i> Descargar TXT</button>
              </div>
              <div id="copyFeedback" class="small-note mt-2 note-hidden">Resumen copiado al portapapeles.</div>
            </div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <div class="fw-semibold mb-1">Advertencia</div>
          <div class="small-note mb-0">Esta herramienta organiza acciones y cálculos orientativos, pero no reemplaza el juicio clínico, la monitorización ni los protocolos institucionales vigentes.</div>
        </div>

        <div class="note-teaching-wrap mt-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Qué hacer y qué evitar en LAST</div>

          <div class="note-chip-grid mt-2">
            <div class="note-success">
              <div class="fw-semibold mb-2">Qué hacer</div>
              <div class="note-chip-list">
                <span class="note-chip note-chip-safe">Reconocer temprano síntomas neurológicos y cardiovasculares.</span>
                <span class="note-chip note-chip-safe">Oxigenar y ventilar bien para evitar acidosis e hipercapnia.</span>
                <span class="note-chip note-chip-safe">Administrar emulsión lipídica precozmente si el cuadro lo sugiere.</span>
                <span class="note-chip note-chip-safe">Registrar tiempo, intervenciones y respuesta clínica.</span>
              </div>
            </div>
            <div class="note-danger">
              <div class="fw-semibold mb-2">Qué evitar</div>
              <div class="note-chip-list">
                <span class="note-chip note-chip-danger">Seguir ACLS estándar sin adaptar la estrategia a LAST.</span>
                <span class="note-chip note-chip-danger">Retrasar la emulsión lipídica esperando confirmación absoluta.</span>
                <span class="note-chip note-chip-danger">Usar vasopresina, beta-bloqueadores o calcioantagonistas como si fuera un paro convencional.</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const checks = Array.from(document.querySelectorAll('.task-check'));
  const progressFill = document.getElementById('lastProgressFill');
  const progressBadge = document.getElementById('lastProgressBadge');
  const weightInput = document.getElementById('weightInput');
  const weightLog = document.getElementById('weightLog');
  const outWeight = document.getElementById('outWeight');
  const outBolus = document.getElementById('outBolus');
  const outInfusion = document.getElementById('outInfusion');
  const outMax = document.getElementById('outMax');
  const seizureDoseEmpty = document.getElementById('seizureDoseEmpty');
  const seizureDoseBox = document.getElementById('seizureDoseBox');
  const szWeight = document.getElementById('szWeight');
  const szMidazolam = document.getElementById('szMidazolam');
  const szLorazepam = document.getElementById('szLorazepam');
  const recordOutput = document.getElementById('recordOutput');
  const copyFeedback = document.getElementById('copyFeedback');

  function setChecklistItemState(input){
    const item = input.closest('.last-check-item');
    if(item) item.classList.toggle('is-done', !!input.checked);
  }

  function updateProgress(){
    const total = checks.length;
    const done = checks.filter(function(c){ return c.checked; }).length;
    const percent = total ? Math.round((done / total) * 100) : 0;
    progressFill.style.width = percent + '%';
    progressBadge.textContent = percent + '%';
    checks.forEach(setChecklistItemState);
    updateRecordOutput();
  }

  function toggleSection(section, force){
    const shouldCollapse = typeof force === 'boolean' ? force : !section.classList.contains('is-collapsed');
    section.classList.toggle('is-collapsed', shouldCollapse);
  }

  document.querySelectorAll('.last-checklist-head').forEach(function(head){
    head.addEventListener('click', function(){
      const section = head.closest('.last-checklist-section');
      if(section) toggleSection(section);
    });
  });

  document.getElementById('expandAllBtn').addEventListener('click', function(){
    document.querySelectorAll('.last-checklist-section').forEach(function(section){ toggleSection(section, false); });
  });

  document.getElementById('collapseAllBtn').addEventListener('click', function(){
    document.querySelectorAll('.last-checklist-section').forEach(function(section){ toggleSection(section, true); });
  });

  function formatWeight(weight){
    return CNS.formatNumber(weight, 1) + ' kg';
  }

  function clearDoseOutputs(){
    CNS.safeSetText(outWeight, '-');
    CNS.safeSetText(outBolus, '-');
    CNS.safeSetText(outInfusion, '-');
    CNS.safeSetText(outMax, '-');
  }

function renderSeizureDose(weight){
  if(!weight || weight <= 0){
    seizureDoseEmpty.classList.remove('d-none');
    seizureDoseBox.classList.add('d-none');
    CNS.safeSetText(szWeight, '-');
    CNS.safeSetText(szMidazolam, '-');
    CNS.safeSetText(szLorazepam, '-');
    CNS.safeSetText('convMidazolam', '-');
    CNS.safeSetText('convLorazepam', '-');
    return;
  }

  const seizureWeight = weight;
  const midazolam = 0.1 * seizureWeight;
  const lorazepam = 0.2 * seizureWeight;

  seizureDoseEmpty.classList.add('d-none');
  seizureDoseBox.classList.remove('d-none');
  CNS.safeSetText(szWeight, formatWeight(seizureWeight));
  CNS.safeSetText(szMidazolam, CNS.formatNumber(midazolam, 2) + ' mg');
  CNS.safeSetText(szLorazepam, CNS.formatNumber(lorazepam, 2) + ' mg');

  CNS.safeSetText('convMidazolam', CNS.formatNumber(midazolam, 2) + ' mg');
  CNS.safeSetText('convLorazepam', CNS.formatNumber(lorazepam, 2) + ' mg');
}

function renderDose(weight){
  if(!weight || weight <= 0){
    clearDoseOutputs();
    renderSeizureDose(null);
    return;
  }

  const bolusText = CNS.formatNumber(1.5 * weight, 1) + ' mL en 2–3 min';
  const infusionText = CNS.formatNumber(0.25 * weight, 1) + ' mL/min';

  CNS.safeSetText(outWeight, formatWeight(weight));
  CNS.safeSetText(outBolus, bolusText);
  CNS.safeSetText(outInfusion, infusionText);
  CNS.safeSetText(outMax, CNS.formatNumber(12 * weight, 1) + ' mL total');
  renderSeizureDose(weight);
  updateRecordOutput();
}

  function getCurrentWeight(){
    const weight = CNS.parseDecimal(weightInput.value);
    return Number.isFinite(weight) && weight > 0 ? weight : null;
  }

  document.getElementById('calcDoseBtn').addEventListener('click', function(){
    renderDose(getCurrentWeight());
  });

  document.getElementById('fillDemoBtn').addEventListener('click', function(){
    weightInput.value = '70';
    renderDose(70);
  });

  weightInput.addEventListener('input', function(){
    const weight = getCurrentWeight();
    if(weight){
      renderDose(weight);
    } else {
      clearDoseOutputs();
      renderSeizureDose(null);
      updateRecordOutput();
    }
  });

  function buildSummary(){
    const timeStart = document.getElementById('timeStart').value || '-';
    const weight = weightLog.value.trim() || (getCurrentWeight() ? CNS.formatNumber(getCurrentWeight(),1) : '-');
    const notes = document.getElementById('notesBox').value.trim() || '-';
    const doneItems = checks.filter(function(c){ return c.checked; }).map(function(c){
      return '- ' + c.closest('.last-check-item').querySelector('.last-check-title').textContent.trim();
    }).join('\n') || '- Ninguna acción marcada';
    const progress = progressBadge.textContent || '0%';

    return [
      'CHECKLIST LAST / TOXICIDAD SISTÉMICA POR ANESTÉSICOS LOCALES',
      'Hora sospecha: ' + timeStart,
      'Peso: ' + weight + (String(weight).includes('kg') || weight === '-' ? '' : ' kg'),
      'Progreso: ' + progress,
      '',
      'Acciones marcadas:',
      doneItems,
      '',
      'Notas:',
      notes
    ].join('\n');
  }

  function updateRecordOutput(){
    recordOutput.value = buildSummary();
  }

  checks.forEach(function(check){ check.addEventListener('change', updateProgress); });
  document.getElementById('timeStart').addEventListener('input', updateRecordOutput);
  weightLog.addEventListener('input', updateRecordOutput);
  document.getElementById('notesBox').addEventListener('input', updateRecordOutput);

  document.getElementById('resetBtn').addEventListener('click', function(){
    checks.forEach(function(c){ c.checked = false; setChecklistItemState(c); });
    weightInput.value = '';
    weightLog.value = '';
    document.getElementById('timeStart').value = '';
    document.getElementById('notesBox').value = '';
    clearDoseOutputs();
    renderSeizureDose(null);
    copyFeedback.classList.add('note-hidden');
    updateProgress();
    window.scrollTo({top:0,behavior:'smooth'});
  });

  document.getElementById('copySummaryBtn').addEventListener('click', async function(){
    try {
      await navigator.clipboard.writeText(buildSummary());
      copyFeedback.classList.remove('note-hidden');
    } catch (e) {
      alert('No se pudo copiar automáticamente. Usa descargar TXT.');
    }
  });

  document.getElementById('downloadTxtBtn').addEventListener('click', function(){
    const text = buildSummary();
    const blob = new Blob([text], {type:'text/plain;charset=utf-8'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'checklist_LAST.txt';
    a.click();
    URL.revokeObjectURL(a.href);
  });

  clearDoseOutputs();
  renderSeizureDose(null);
  updateProgress();
})();
</script>

<?php require("../footer.php"); ?>
