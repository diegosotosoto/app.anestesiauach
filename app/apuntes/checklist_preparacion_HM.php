<?php
$titulo_pagina = "Checklist preparación HM";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Checklist interactivo para preparación de pabellón en paciente susceptible de Hipertermia Maligna según recomendaciones SACHILE.";
$formula = "";
$referencias = array(
  "Sociedad de Anestesiología de Chile. Manejo de la crisis de Hipertermia Maligna y del paciente susceptible de Hipertermia Maligna.",
  "Malignant Hyperthermia Association of the United States (MHAUS). Recommendations for preparation of the anesthesia workstation for MH-susceptible patients.",
  "Rosenberg H, Pollock N, Schiemann A, Bulger T, Stowell K. Malignant Hyperthermia: a review. Orphanet J Rare Dis. 2015;10:93."
);

include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<style>
.prep-shell{max-width:980px;margin:0 auto;}
.prep-warning-card{
  background:#fff8e8;
  border:1px solid #e6cb7a;
  border-radius:1.15rem;
  padding:1rem 1.1rem;
}
.prep-warning-title{
  font-size:.9rem;
  font-weight:800;
  text-align:center;
  color:#1f2a37;
  margin-bottom:.45rem;
}
.prep-section-chevron{
  color:#64748b;
  font-size:1.2rem;
  transition:transform .18s ease;
}
.note-checklist-section.is-collapsed .prep-section-chevron{transform:rotate(-90deg);}
.last-check-item{
  display:flex;
  align-items:flex-start;
  gap:.8rem;
  border:1px solid #dfe7f2;
  border-radius:1rem;
  background:#fff;
  padding:.9rem 1rem;
  cursor:pointer;
  transition:.16s ease;
}
.last-check-item:hover{
  border-color:#c9d4e5;
  box-shadow:0 4px 12px rgba(15,23,42,.04);
}
.last-check-input{
  position:absolute;
  opacity:0;
  pointer-events:none;
  width:1px;
  height:1px;
}
.last-check-mark{
  flex:0 0 auto;
  width:34px;
  height:34px;
  border-radius:999px;
  border:2px solid #b8c2d0;
  display:flex;
  align-items:center;
  justify-content:center;
  background:#fff;
  color:#fff;
  margin-top:.08rem;
  transition:.16s ease;
}
.last-check-mark i{font-size:.95rem;}
.last-check-copy{min-width:0;flex:1;}
.last-check-title{
  font-size:1rem;
  font-weight:800;
  line-height:1.22;
  color:var(--note-text);
  margin-bottom:.15rem;
}
.last-check-note{
  margin:0;
  font-size:.9rem;
  line-height:1.4;
  color:var(--note-muted);
}
.last-check-item.is-done{
  background:#edf8f1;
  border-color:#b7ddc3;
}
.last-check-item.is-done .last-check-mark{
  background:#2ea663;
  border-color:#2ea663;
}
.prep-record-label{
  font-size:.82rem;
  text-transform:uppercase;
  letter-spacing:.06em;
  color:var(--note-muted);
  font-weight:700;
  margin-bottom:.35rem;
}
.prep-grid-2{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
.prep-chip-list{display:flex;flex-wrap:wrap;gap:.35rem;}
.prep-chip{
  display:inline-flex;
  align-items:center;
  gap:.35rem;
  padding:.35rem .6rem;
  border-radius:999px;
  border:1px solid var(--note-line-strong);
  background:#fff;
  font-size:.82rem;
  font-weight:700;
  color:var(--note-text);
}
.prep-chip-danger{
  background:#fff5f3;
  border-color:#efc4be;
  color:#b42318;
}
.prep-chip-safe{
  background:#edf8f7;
  border-color:#cfe8e6;
  color:#1e7a5a;
}
@media (max-width:768px){
  .prep-grid-2{grid-template-columns:1fr;}
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="prep-shell note-shell px-1 px-md-0 py-0">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · CHECKLIST</div>
          <h2>Preparación de pabellón: paciente susceptible a HM</h2>
          <div class="note-hero-subtitle">
            Checklist interactivo para organizar preparación de pabellón en un paciente susceptible de Hipertermia Maligna.
          </div>
        </div>

        <div class="note-checklist-progress-block px-3 py-2 mb-3">
          <div class="note-checklist-progress-head">
            <div class="note-checklist-progress-title">Progreso del checklist</div>
            <div id="progressText" class="note-checklist-progress-badge">0%</div>
          </div>

          <div class="note-checklist-progress-track">
            <div id="progressBar" class="note-checklist-progress-bar"></div>
          </div>

          <div class="note-checklist-toolbar">
            <button type="button" id="expandAllBtn" class="btn note-checklist-btn">Expandir todo</button>
            <button type="button" id="collapseAllBtn" class="btn note-checklist-btn">Colapsar todo</button>
            <button type="button" id="resetBtn" class="btn note-checklist-btn note-checklist-btn-danger">Reiniciar</button>
          </div>
        </div>

        <div class="prep-warning-card mb-3">
          <div class="prep-warning-title">Advertencia visible</div>
          <p class="mb-0 text-center">
            Este checklist es para <strong>preparación</strong> de un paciente susceptible a Hipertermia Maligna, no para el manejo de una crisis activa. La meta es evitar exposición a gatillantes y tener los recursos críticos listos antes de iniciar la anestesia.
          </p>
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
              <b>Fórmula:</b><br>
              <?php echo $formula; ?>
            <?php } ?>
            <hr>
            <div class="small-note mb-2">Punto clave: la preparación correcta del pabellón y de la máquina de anestesia disminuye exposición inadvertida a gatillantes y reduce demoras críticas si apareciera una crisis.</div>
            <hr>
            <b>Referencias:</b>
            <ul class="mt-2 mb-0">
              <?php foreach($referencias as $ref){ ?>
                <li><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="note-checklist-section">
          <div class="note-checklist-section-head">
            <div>
              <div class="note-checklist-section-title">1. Identificación del paciente susceptible</div>
              <div class="note-checklist-section-help">Confirmar el riesgo real antes de programar el procedimiento.</div>
            </div>
            <div class="prep-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
          </div>
          <div class="note-checklist-section-body">
            <div class="note-checklist-list">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Antecedente personal de crisis previa de HM</div>
                  <p class="last-check-note">Confirmado o altamente sospechoso.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Antecedente familiar de Hipertermia Maligna</div>
                  <p class="last-check-note">Incluye muerte anestésica inexplicada o evento grave en pabellón.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Miopatía predisponente conocida</div>
                  <p class="last-check-note">Por ejemplo Central Core disease, Multiminicore disease o síndrome de King-Denborough.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Otros antecedentes sugerentes revisados</div>
                  <p class="last-check-note">Rabdomiólisis, orinas oscuras, heat stroke o antecedentes musculares dudosos.</p>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-checklist-section">
          <div class="note-checklist-section-head">
            <div>
              <div class="note-checklist-section-title">2. Programación y coordinación del pabellón</div>
              <div class="note-checklist-section-help">Asegurar entorno, personal y soporte antes del ingreso del paciente.</div>
            </div>
            <div class="prep-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
          </div>
          <div class="note-checklist-section-body">
            <div class="note-checklist-list">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Cirugía idealmente programada a primera hora</div>
                  <p class="last-check-note">Reduce retrasos y facilita preparación completa del pabellón.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Laboratorio y apoyo crítico coordinados</div>
                  <p class="last-check-note">Incluye exámenes, disponibilidad de UCI y desfibrilador.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Personal de apoyo informado y con roles definidos</div>
                  <p class="last-check-note">Incluye enfermería, arsenalera y apoyo técnico de pabellón.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Algoritmo o póster de manejo de crisis disponible</div>
                  <p class="last-check-note">Visible dentro del pabellón o junto al carro de HM.</p>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-checklist-section">
          <div class="note-checklist-section-head">
            <div>
              <div class="note-checklist-section-title">3. Dantrolene y recursos críticos</div>
              <div class="note-checklist-section-help">Verificar stock, acceso y preparación práctica.</div>
            </div>
            <div class="prep-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
          </div>
          <div class="note-checklist-section-body">
            <div class="note-warning mb-3">
              <div class="note-card-title">Objetivo operativo</div>
              <div>El pabellón debe contar al menos con la primera dosis de dantrolene y con claridad sobre cómo obtener dosis adicionales oportunamente.</div>
            </div>
            <div class="note-checklist-list mb-3">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Primera dosis de dantrolene físicamente disponible</div>
                  <p class="last-check-note">No solo “pedida” o “ubicable”.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Confirmadas dosis subsiguientes o convenio</div>
                  <p class="last-check-note">Idealmente con acceso en menos de una hora si no están en el mismo centro.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Agua destilada disponible con el dantrolene</div>
                  <p class="last-check-note">Verificar además vencimiento, almacenamiento y rotulación.</p>
                </div>
              </label>
            </div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Tratamiento completo sugerido</div>
                <div class="note-result-card-value">10 mg/kg</div>
                <div class="note-result-card-note">Carga acumulada orientativa si la crisis persiste.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Referencia práctica adulto 70 kg</div>
                <div class="note-result-card-value">≈ 20 frascos</div>
                <div class="note-result-card-note">Para disponer de ataque inicial amplio durante la primera hora.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-checklist-section">
          <div class="note-checklist-section-head">
            <div>
              <div class="note-checklist-section-title">4. Preparación de la máquina de anestesia</div>
              <div class="note-checklist-section-help">Eliminar exposición residual a gatillantes antes del ingreso del paciente.</div>
            </div>
            <div class="prep-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
          </div>
          <div class="note-checklist-section-body">
            <div class="note-danger mb-3">
              <div class="note-card-title">Meta</div>
              <div>Asegurar una técnica completamente libre de halogenados y succinilcolina.</div>
            </div>
            <div class="note-checklist-list">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Vaporizadores retirados o vaciados y cerrados</div>
                  <p class="last-check-note">Eliminar físicamente la posibilidad de administración inadvertida.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Absorbedor de CO₂ cambiado si corresponde</div>
                  <p class="last-check-note">Según protocolo local y tipo de máquina.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Lavado de máquina realizado</div>
                  <p class="last-check-note">O₂ 10 L/min por al menos 20 min, o 10 min si se reemplazó la manguera de gas fresco.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Analizador de gases usado para confirmar ausencia de anestésico residual</div>
                  <p class="last-check-note">Idealmente antes de comenzar el caso.</p>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-checklist-section">
          <div class="note-checklist-section-head">
            <div>
              <div class="note-checklist-section-title">5. Evaluación preoperatoria y medidas preventivas</div>
              <div class="note-checklist-section-help">Checklist final del plan anestésico preventivo.</div>
            </div>
            <div class="prep-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
          </div>
          <div class="note-checklist-section-body">
            <div class="note-checklist-list mb-3">
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">CK preoperatoria solicitada o revisada si corresponde</div>
                  <p class="last-check-note">Según contexto clínico e indicación local.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Técnica anestésica libre de gatillantes definida</div>
                  <p class="last-check-note">TIVA, regional o local según el caso.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Monitorización básica completa asegurada</div>
                  <p class="last-check-note">PA, temperatura, ECG, SpO₂ y capnografía.</p>
                </div>
              </label>
              <label class="last-check-item">
                <input class="last-check-input task-check" type="checkbox">
                <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
                <div class="last-check-copy">
                  <div class="last-check-title">Monitoreo invasivo considerado si cirugía o paciente lo requieren</div>
                  <p class="last-check-note">Incluye línea arterial u otras medidas avanzadas.</p>
                </div>
              </label>
            </div>

            <div class="prep-grid-2">
              <div class="note-success">
                <div class="note-card-title">Técnicas / fármacos seguros</div>
                <div class="prep-chip-list">
                  <span class="prep-chip prep-chip-safe">TIVA / Propofol</span>
                  <span class="prep-chip prep-chip-safe">Benzodiacepinas</span>
                  <span class="prep-chip prep-chip-safe">Opioides</span>
                  <span class="prep-chip prep-chip-safe">Ketamina</span>
                  <span class="prep-chip prep-chip-safe">Etomidato</span>
                  <span class="prep-chip prep-chip-safe">Óxido nitroso</span>
                  <span class="prep-chip prep-chip-safe">Rocuronio / Vecuronio</span>
                  <span class="prep-chip prep-chip-safe">Atracurio / Mivacurio</span>
                  <span class="prep-chip prep-chip-safe">Neostigmina / Atropina</span>
                  <span class="prep-chip prep-chip-safe">Anestesia local / regional / espinal / peridural</span>
                </div>
              </div>
              <div class="note-danger">
                <div class="note-card-title">Gatillantes inseguros</div>
                <div class="prep-chip-list">
                  <span class="prep-chip prep-chip-danger">Sevoflurano</span>
                  <span class="prep-chip prep-chip-danger">Isoflurano</span>
                  <span class="prep-chip prep-chip-danger">Desflurano</span>
                  <span class="prep-chip prep-chip-danger">Halotano / Enflurano</span>
                  <span class="prep-chip prep-chip-danger">Succinilcolina</span>
                </div>
                <div class="small-note mt-2">No usar halogenados ni succinilcolina.</div>
              </div>
            </div>

            <div class="note-warning mt-3 mb-0">
              <div class="note-card-title">Profilaxis con dantrolene</div>
              <div>No se recomienda de rutina en la mayoría de los pacientes susceptibles. Considerarla caso a caso. Si se usa, la referencia orientativa es 2,5 mg/kg IV 30 min antes. Evitar asociación con bloqueadores del calcio.</div>
            </div>
          </div>
        </div>

        <div class="note-checklist-section">
          <div class="note-checklist-section-head">
            <div>
              <div class="note-checklist-section-title">6. Registro rápido</div>
              <div class="note-checklist-section-help">Resumen exportable de la preparación completada.</div>
            </div>
            <div class="prep-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
          </div>
          <div class="note-checklist-section-body">
            <div class="prep-grid-2 mb-3">
              <div>
                <div class="prep-record-label">Fecha</div>
                <input type="date" id="dateLog" class="note-text-input">
              </div>
              <div>
                <div class="prep-record-label">Pabellón</div>
                <input type="text" id="theatreLog" class="note-text-input" placeholder="Ej: Pabellón 3">
              </div>
              <div>
                <div class="prep-record-label">Paciente / iniciales</div>
                <input type="text" id="patientLog" class="note-text-input" placeholder="Iniciales o código">
              </div>
              <div>
                <div class="prep-record-label">Notas breves</div>
                <input type="text" id="notesBox" class="note-text-input" placeholder="Ej: vaporizadores retirados, lavado 20 min, UCI avisada">
              </div>
            </div>

            <div class="note-checklist-record">
              <div class="note-card-title mb-2">Registro resumido</div>
              <textarea id="recordOutput" class="note-checklist-record-box"></textarea>
              <div class="note-checklist-toolbar mt-2">
                <button type="button" id="copySummaryBtn" class="btn note-checklist-btn"><i class="fa-solid fa-copy me-1"></i> Copiar</button>
                <button type="button" id="downloadTxtBtn" class="btn note-checklist-btn"><i class="fa-solid fa-file-arrow-down me-1"></i> Descargar TXT</button>
              </div>
              <div id="copyFeedback" class="small-note mt-2 note-hidden">Resumen copiado al portapapeles.</div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mt-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Preparar bien el entorno es parte del tratamiento preventivo</div>
          <div class="note-tips"><strong>Qué hacer:</strong> llegar al caso con máquina preparada, dantrolene disponible y equipo coordinado.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> asumir que “como no habrá gatillantes, no pasa nada” y descuidar el plan de rescate.</div>
          <div class="note-tips mb-0"><strong>Error frecuente:</strong> recordar succinilcolina y olvidar vaporizadores, analizador de gases o logística de dosis subsiguientes de dantrolene.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const checks = Array.from(document.querySelectorAll('.task-check'));
  const progressBar = document.getElementById('progressBar');
  const progressText = document.getElementById('progressText');
  const sections = Array.from(document.querySelectorAll('.note-checklist-section'));
  const recordOutput = document.getElementById('recordOutput');
  const copyFeedback = document.getElementById('copyFeedback');

  function setChecklistItemState(input){
    const item = input.closest('.last-check-item');
    if(item) item.classList.toggle('is-done', !!input.checked);
  }

  function updateProgress(){
    const total = checks.length;
    const done = checks.filter(c => c.checked).length;
    const percent = total ? Math.round((done / total) * 100) : 0;
    progressBar.style.width = percent + '%';
    progressText.textContent = percent + '%';
    checks.forEach(setChecklistItemState);
    updateRecordOutput();
  }

  function toggleSection(section, force){
    const shouldCollapse = typeof force === 'boolean' ? force : !section.classList.contains('is-collapsed');
    section.classList.toggle('is-collapsed', shouldCollapse);
  }

  document.querySelectorAll('.note-checklist-section-head').forEach(function(head){
    head.addEventListener('click', function(){
      const section = head.closest('.note-checklist-section');
      if(section) toggleSection(section);
    });
  });

  document.getElementById('expandAllBtn').addEventListener('click', function(){
    sections.forEach(section => toggleSection(section, false));
  });

  document.getElementById('collapseAllBtn').addEventListener('click', function(){
    sections.forEach(section => toggleSection(section, true));
  });

  function buildSummary(){
    const done = checks.filter(c => c.checked).length;
    const total = checks.length;
    const dateLog = document.getElementById('dateLog').value || '-';
    const theatreLog = document.getElementById('theatreLog').value.trim() || '-';
    const patientLog = document.getElementById('patientLog').value.trim() || '-';
    const notes = document.getElementById('notesBox').value.trim() || '-';

    const checkedItems = checks
      .filter(c => c.checked)
      .map(c => '- ' + c.closest('.last-check-item').querySelector('.last-check-title').textContent.trim())
      .join('\n') || '- Ninguno';

    return [
      'CHECKLIST PREPARACIÓN DE PABELLÓN - PACIENTE SUSCEPTIBLE A HM',
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

  function updateRecordOutput(){
    recordOutput.value = buildSummary();
  }

  checks.forEach(check => check.addEventListener('change', updateProgress));
  ['dateLog','theatreLog','patientLog','notesBox'].forEach(function(id){
    const el = document.getElementById(id);
    if(el) el.addEventListener('input', updateRecordOutput);
  });

  document.getElementById('resetBtn').addEventListener('click', function(){
    checks.forEach(c => {
      c.checked = false;
      setChecklistItemState(c);
    });
    ['dateLog','theatreLog','patientLog','notesBox'].forEach(function(id){
      const el = document.getElementById(id);
      if(el) el.value = '';
    });
    copyFeedback.classList.add('note-hidden');
    updateProgress();
    window.scrollTo({top:0, behavior:'smooth'});
  });

  document.getElementById('copySummaryBtn').addEventListener('click', async function(){
    try {
      await navigator.clipboard.writeText(buildSummary());
      copyFeedback.classList.remove('note-hidden');
    } catch(e) {
      alert('No se pudo copiar automáticamente. Usa descargar TXT.');
    }
  });

  document.getElementById('downloadTxtBtn').addEventListener('click', function(){
    const text = buildSummary();
    const blob = new Blob([text], {type:'text/plain;charset=utf-8'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'checklist_preparacion_pabellon_HM_susceptible.txt';
    a.click();
    URL.revokeObjectURL(a.href);
  });

  updateProgress();
})();
</script>

<?php
include("footer.php");
?>
