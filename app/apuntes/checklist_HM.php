<?php
$titulo_info = "Utilidad clínica";
$descripcion_info = "Checklist interactivo para sospecha y manejo inicial de Hipertermia Maligna en Pabellón";

$referencias = array(
  "Larach MG, Brandom BW, Allen GC, et al. Malignant hyperthermia deaths related to inadequate temperature monitoring, 1990–2010: a review of reports to the North American Malignant Hyperthermia Registry. Anesth Analg. 2014.",
  "Rosenberg H, Pollock N, Schiemann A, Bulger T, Stowell K. Malignant Hyperthermia: a review. Orphanet J Rare Dis. 2015;10:93.",
  "MHAUS. Malignant Hyperthermia Association of the United States. Emergency Therapy for MH. Consultado para estructura operativa del checklist."
);

$titulo_pagina = "Checklist HM";
$navbar_titulo = "Apuntes";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>";


require("../head.php");
?>

<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<style>
.hm-shell{max-width:980px;margin:0 auto;}
.hm-warning-card{
  background:#fff8e8;
  border:1px solid #e6cb7a;
  border-radius:1.15rem;
  padding:1rem 1.1rem;
}
.hm-warning-title{
  font-size:.9rem;
  font-weight:800;
  text-align:center;
  color:#1f2a37;
  margin-bottom:.45rem;
}
.hm-section-icon{
  color:#64748b;
  font-size:1.1rem;
}
.hm-section-chevron{
  color:#64748b;
  font-size:1.2rem;
  transition:transform .18s ease;
}
.note-checklist-section.is-collapsed .hm-section-chevron{
  transform:rotate(-90deg);
}
.last-check-item{
  display:flex;
  align-items:flex-start;
  gap:.8rem;
  border:1px solid #cfe8d9;
  border-radius:1rem;
  background:#fff;
  padding:.9rem 1rem;
  cursor:pointer;
  transition:.16s ease;
}
.last-check-item:hover{
  border-color:#b9d9c8;
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
.last-check-copy{
  min-width:0;
  flex:1;
}
.last-check-title{
  font-size:1rem;
  font-weight:800;
  line-height:1.22;
  color:var(--note-text);
  margin-bottom:.15rem;
  text-align:center;
}
.last-check-note{
  margin:0;
  font-size:.9rem;
  line-height:1.4;
  color:var(--note-muted);
  text-align:center;
}
.last-check-item.is-done{
  background:#edf8f1;
  border-color:#b7ddc3;
}
.last-check-item.is-done .last-check-mark{
  background:#2ea663;
  border-color:#2ea663;
}
.hm-dantrolene-grid{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:.75rem;
}
.hm-dantrolene-card{
  background:linear-gradient(180deg,var(--note-brand-soft) 0%, #f7faff 100%);
  border:1px solid var(--note-brand-soft-border);
  border-radius:1rem;
  padding:1rem;
}
.hm-dantrolene-card .k{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.06em;
  color:#3559b7;
  font-weight:700;
  margin-bottom:.25rem;
  text-align:center;
}
.hm-dantrolene-card .v{
  font-size:1.25rem;
  font-weight:800;
  color:var(--note-text);
  line-height:1.15;
  text-align:center;
}
.hm-dantrolene-card .n{
  margin-top:.25rem;
  font-size:.9rem;
  line-height:1.35;
  color:var(--note-muted);
  text-align:center;
}
.hm-inline-inputs{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:.75rem;
}
.hm-record-label{
  font-size:.82rem;
  text-transform:uppercase;
  letter-spacing:.06em;
  color:var(--note-muted);
  font-weight:700;
  margin-bottom:.35rem;
}
@media (max-width: 768px){
  .hm-dantrolene-grid,
  .hm-inline-inputs{
    grid-template-columns:1fr;
  }
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="last-shell px-1 px-md-0 py-0  ">

  <div class="note-hero note-hero-emergency mb-3">
    <div class="note-hero-kicker">APP CLÍNICA · CHECKLIST DE URGENCIA</div>
    <h2>Hipertermia maligna</h2>
    <div class="note-hero-subtitle">
      Checklist interactivo para sospecha diagnóstica, tratamiento agudo, cálculo rápido de dantrolene, fase post-aguda y registro resumido de la crisis.
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

  <div class="hm-warning-card mb-3">
    <div class="hm-warning-title">Advertencia visible</div>
    <p class="mb-0 text-center">
      Ante sospecha real de hipertermia maligna, la prioridad es suspender gatillantes, hiperventilar con O<sub>2</sub> al 100%, pedir ayuda y administrar dantrolene precozmente. Este checklist ordena la respuesta, pero no reemplaza juicio clínico ni protocolos institucionales.
    </p>
  </div>

  <div class="info-box mb-3">
    <div class="info-box-header">
      <div class="info-box-title">Información</div>
      <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
    </div>
    <div id="infoContent" class="info-box-content">
      <p class="mb-2">
        Utiliza este checklist para reconocer una crisis compatible con hipertermia maligna, priorizar medidas inmediatas, calcular una dosis inicial de dantrolene y ordenar el registro del evento.
      </p>
      <hr>
      <div class="small-note mb-2"><strong>Punto crítico:</strong> ETCO<sub>2</sub> en ascenso con ventilación adecuada, rigidez, hipertermia tardía, acidosis, hiperkalemia y rabdomiólisis deben hacer actuar precozmente.</div>
      <hr>
      <strong>Referencias:</strong>
      <ul class="mb-0">
        <?php foreach($referencias as $ref){ ?>
          <li><?php echo $ref; ?></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <div class="note-checklist-section">
    <div class="note-checklist-section-head">
      <div>
        <div class="note-checklist-section-title">1. Sospecha diagnóstica inmediata</div>
        <div class="note-checklist-section-help">Signos clínicos de alarma que deben disparar la respuesta.</div>
      </div>
      <div class="hm-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
    </div>

    <div class="note-checklist-section-body">
      <div class="note-checklist-list">
        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Aumento real y significativo de ETCO₂</div>
            <p class="last-check-note">Con ventilación aparentemente adecuada y sin otra explicación inmediata.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Taquicardia, hipertensión o taquipnea sin causa clara</div>
            <p class="last-check-note">Puede preceder a hipertermia franca.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Rigidez muscular o espasmo del masetero</div>
            <p class="last-check-note">Especialmente tras succinilcolina.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Acidosis, hiperkalemia, mioglobinuria o hipertermia rápida</div>
            <p class="last-check-note">No esperes a que todos los signos estén presentes.</p>
          </div>
        </label>
      </div>
    </div>
  </div>

  <div class="note-checklist-section">
    <div class="note-checklist-section-head">
      <div>
        <div class="note-checklist-section-title">2. Medidas inmediatas</div>
        <div class="note-checklist-section-help">Acciones prioritarias en los primeros minutos.</div>
      </div>
      <div class="hm-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
    </div>

    <div class="note-checklist-section-body">
      <div class="note-checklist-list">
        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Suspender inmediatamente volátiles y succinilcolina</div>
            <p class="last-check-note">Eliminar todos los posibles gatillantes.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Hiperventilar con O₂ al 100%</div>
            <p class="last-check-note">Con flujos altos y control agresivo de hipercapnia.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Pedir ayuda y activar protocolo institucional</div>
            <p class="last-check-note">Asignar roles y preparar carro/kit de MH.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Iniciar enfriamiento si hay hipertermia relevante</div>
            <p class="last-check-note">Medidas físicas y fluidos fríos cuando corresponda.</p>
          </div>
        </label>
      </div>
    </div>
  </div>

  <div class="note-checklist-section">
    <div class="note-checklist-section-head">
      <div>
        <div class="note-checklist-section-title">3. Dantrolene</div>
        <div class="note-checklist-section-help">Cálculo rápido para dosis inicial y carga acumulada.</div>
      </div>
      <div class="hm-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
    </div>

    <div class="note-checklist-section-body">
      <div class="hm-inline-inputs mb-3">
        <div class="note-input-group">
          <label class="note-label" for="weightInput">Peso</label>
          <div class="note-input-inline">
            <input type="text" id="weightInput" class="note-input" inputmode="decimal" placeholder="Ej: 70">
            <div class="note-input-unit">kg</div>
          </div>
        </div>

        <div class="note-input-group">
          <label class="note-label" for="weightLog">Peso usado en registro</label>
          <div class="note-input-inline">
            <input type="text" id="weightLog" class="note-input" inputmode="decimal" placeholder="Opcional">
            <div class="note-input-unit">kg</div>
          </div>
        </div>
      </div>

      <div class="note-checklist-toolbar mb-3">
        <button type="button" id="calcDoseBtn" class="btn note-checklist-btn"><i class="fa-solid fa-calculator me-1"></i> Calcular</button>
        <button type="button" id="fillDemoBtn" class="btn note-checklist-btn"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Ejemplo 70 kg</button>
      </div>

      <div class="hm-dantrolene-grid">
        <div class="hm-dantrolene-card">
          <div class="k">Peso usado</div>
          <div id="outWeight" class="v">-</div>
          <div class="n">Base del cálculo actual.</div>
        </div>
        <div class="hm-dantrolene-card">
          <div class="k">Dosis inicial</div>
          <div id="outInitialDose" class="v">-</div>
          <div class="n">Orientativa: 2,5 mg/kg IV.</div>
        </div>
        <div class="hm-dantrolene-card">
          <div class="k">Viales de 20 mg</div>
          <div id="outVials20" class="v">-</div>
          <div class="n">Redondeo práctico para preparación rápida.</div>
        </div>
        <div class="hm-dantrolene-card">
          <div class="k">Carga acumulada 10 mg/kg</div>
          <div id="outMaxDose" class="v">-</div>
          <div class="n">Si persiste la sospecha o respuesta incompleta.</div>
        </div>
      </div>
    </div>
  </div>

  <div class="note-checklist-section">
    <div class="note-checklist-section-head">
      <div>
        <div class="note-checklist-section-title">4. Tratamiento de complicaciones</div>
        <div class="note-checklist-section-help">Reanimación paralela mientras se corrige la crisis.</div>
      </div>
      <div class="hm-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
    </div>

    <div class="note-checklist-section-body">
      <div class="note-checklist-list">
        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Tratar hiperkalemia y acidosis</div>
            <p class="last-check-note">Calcio, bicarbonato, insulina/glucosa según contexto.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Tratar arritmias evitando bloqueadores cálcicos</div>
            <p class="last-check-note">No combinar dantrolene con calcioantagonistas.</p>
          </div>
        </label>

        <label class="last-check-item">
          <input class="last-check-input task-check" type="checkbox">
          <div class="last-check-mark"><i class="fa-solid fa-check"></i></div>
          <div class="last-check-copy">
            <div class="last-check-title">Mantener diuresis y vigilar rabdomiólisis</div>
            <p class="last-check-note">Mioglobinuria, CK, función renal y potasio.</p>
          </div>
        </label>
      </div>
    </div>
  </div>

  <div class="note-checklist-section">
    <div class="note-checklist-section-head">
      <div>
        <div class="note-checklist-section-title">5. Registro rápido</div>
        <div class="note-checklist-section-help">Resumen exportable del evento.</div>
      </div>
      <div class="hm-section-chevron"><i class="fa-solid fa-chevron-down"></i></div>
    </div>

    <div class="note-checklist-section-body">
      <div class="hm-inline-inputs mb-3">
        <div>
          <div class="hm-record-label">Hora de sospecha</div>
          <input type="time" id="timeStart" class="note-text-input">
        </div>
        <div>
          <div class="hm-record-label">Notas breves</div>
          <input type="text" id="notesBox" class="note-text-input" placeholder="Ej: ETCO2 68, rigidez, se administra dantrolene">
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
    <div class="note-teaching-main">Actúa antes de tener la foto completa</div>

    <div class="note-tips">
      <strong>Qué hacer:</strong> Suspender gatillantes, ventilar con O₂ al 100%, pedir ayuda y preparar dantrolene sin esperar hipertermia franca.
    </div>
    <div class="note-tips">
      <strong>Qué evitar:</strong> Retrasar tratamiento esperando confirmación completa o usar calcioantagonistas junto con dantrolene.
    </div>
    <div class="note-tips mb-0">
      <strong>Error frecuente:</strong> Asociar MH sólo a temperatura elevada. El aumento de ETCO₂ y la rigidez suelen aparecer antes.
    </div>
  </div>

</div>
</div></div></div>
<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const checks = Array.from(document.querySelectorAll('.task-check'));
  const progressBar = document.getElementById('progressBar');
  const progressText = document.getElementById('progressText');

  const weightInput = document.getElementById('weightInput');
  const weightLog = document.getElementById('weightLog');
  const outWeight = document.getElementById('outWeight');
  const outInitialDose = document.getElementById('outInitialDose');
  const outVials20 = document.getElementById('outVials20');
  const outMaxDose = document.getElementById('outMaxDose');

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
    head.addEventListener('click', function(e){
      if(e.target.closest('button')) return;
      const section = head.closest('.note-checklist-section');
      if(section) toggleSection(section);
    });
  });

  document.getElementById('expandAllBtn').addEventListener('click', function(){
    document.querySelectorAll('.note-checklist-section').forEach(function(section){ toggleSection(section, false); });
  });

  document.getElementById('collapseAllBtn').addEventListener('click', function(){
    document.querySelectorAll('.note-checklist-section').forEach(function(section){ toggleSection(section, true); });
  });

  function formatWeight(weight){
    return CNS.formatNumber(weight, 1) + ' kg';
  }

  function clearDoseOutputs(){
    CNS.safeSetText(outWeight, '-');
    CNS.safeSetText(outInitialDose, '-');
    CNS.safeSetText(outVials20, '-');
    CNS.safeSetText(outMaxDose, '-');
  }

  function renderDose(weight){
    if(!weight || weight <= 0){
      clearDoseOutputs();
      updateRecordOutput();
      return;
    }

    const initialDose = 2.5 * weight;
    const maxDose = 10 * weight;
    const vials20 = Math.ceil(initialDose / 20);

    CNS.safeSetText(outWeight, formatWeight(weight));
    CNS.safeSetText(outInitialDose, CNS.formatNumber(initialDose, 1) + ' mg');
    CNS.safeSetText(outVials20, vials20 + ' vial(es)');
    CNS.safeSetText(outMaxDose, CNS.formatNumber(maxDose, 1) + ' mg');
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
      updateRecordOutput();
    }
  });

  function buildSummary(){
    const timeStart = document.getElementById('timeStart').value || '-';
    const weight = weightLog.value.trim() || (getCurrentWeight() ? CNS.formatNumber(getCurrentWeight(),1) : '-');
    const notes = document.getElementById('notesBox').value.trim() || '-';
    const doneItems = checks.filter(function(c){
      return c.checked;
    }).map(function(c){
      return '- ' + c.closest('.last-check-item').querySelector('.last-check-title').textContent.trim();
    }).join('\n') || '- Ninguna acción marcada';

    return [
      'CHECKLIST HIPERTERMIA MALIGNA',
      'Hora sospecha: ' + timeStart,
      'Peso: ' + weight + (String(weight).includes('kg') || weight === '-' ? '' : ' kg'),
      'Progreso: ' + (progressText.textContent || '0%'),
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
    copyFeedback.classList.add('note-hidden');
    updateProgress();
    window.scrollTo({top:0,behavior:'smooth'});
  });

  document.getElementById('copySummaryBtn').addEventListener('click', async function(){
    try{
      await navigator.clipboard.writeText(buildSummary());
      copyFeedback.classList.remove('note-hidden');
    } catch(e){
      alert('No se pudo copiar automáticamente. Usa descargar TXT.');
    }
  });

  document.getElementById('downloadTxtBtn').addEventListener('click', function(){
    const text = buildSummary();
    const blob = new Blob([text], {type:'text/plain;charset=utf-8'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'checklist_HM.txt';
    a.click();
    URL.revokeObjectURL(a.href);
  });

  clearDoseOutputs();
  updateProgress();
})();
</script>

<?php
require("../footer.php");
?>