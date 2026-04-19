<?php
$titulo_pagina = "Checklist intubación vigil";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Checklist interactivo para preparación y ejecución de intubación vigil. Ordena preparación del paciente, equipo, procedimiento y verificación final, incorporando un cálculo orientativo del tope total de lidocaína.";
$formula = '
<div class="note-formula-box mt-2">
  <div class="note-formula-label">Tope orientativo de lidocaína total</div>
  <div class="note-formula-wrap">
    <div class="note-formula-left">Lidocaína máxima orientativa</div>
    <div class="note-formula-equals">=</div>
    <div class="note-formula-fraction">
      <div class="note-formula-num">7 mg × peso (kg)</div>
      <div class="note-formula-line"></div>
      <div class="note-formula-den">1</div>
    </div>
  </div>
  <div class="note-formula-note">Úsalo como recordatorio de seguridad para sumar spray, nebulización, gel, infiltración y dosis transtraqueal. No reemplaza juicio clínico, comorbilidades ni otras fuentes de anestésico local.</div>
</div>';
$referencias = array(
  "Ahmad I, El-Boghdadly K, Bhagrath R, et al. Difficult Airway Society guidelines for awake tracheal intubation (ATI) in adults. Anaesthesia. 2020;75(4):509-528.",
  "Miller RD, Cohen NH, Eriksson LI, et al. Miller's Anesthesia. Secciones de manejo de vía aérea difícil e intubación vigil.",
  "Compilación local del usuario basada en DAS, Miller y notas operativas de pabellón para intubación vigil con fibroscopio / Ambuscope."
);

require('head.php');
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=20260416-3">
<script src="js/clinical-note-system.js?v=20260416-1"></script>

<style>
  .last-shell{max-width:980px;margin:0 auto;}
  .last-checklist-section{background:#fff;border:1px solid var(--note-line);border-radius:1.1rem;overflow:hidden;margin-bottom:1rem;}
  .last-checklist-head{padding:1rem 1rem .95rem 1rem;display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;cursor:pointer;}
  .last-checklist-title{font-size:1.03rem;font-weight:800;color:var(--note-text);line-height:1.2;margin:0;}
  .last-checklist-help{font-size:.9rem;color:var(--note-muted);line-height:1.4;margin:.2rem 0 0 0;}
  .last-checklist-chevron{flex:0 0 auto;color:var(--note-muted);font-size:1rem;transition:transform .18s ease;}
  .last-checklist-section.is-collapsed .last-checklist-chevron{transform:rotate(-90deg);}
  .last-checklist-body{padding:0 1rem 1rem 1rem;border-top:1px solid #e9eef5;}
  .last-checklist-section.is-collapsed .last-checklist-body{display:none;}

  .last-checklist-list{display:grid;gap:.75rem;}
  .last-check-item{display:flex;align-items:flex-start;gap:.8rem;padding:.9rem .95rem;border:1px solid var(--note-line);border-radius:1rem;background:#fff;cursor:pointer;}
  .last-check-item.is-done{background:#f4fbf7;border-color:#cfe8d9;}
  .last-check-input{position:absolute;opacity:0;pointer-events:none;width:1px;height:1px;}
  .last-check-mark{flex:0 0 auto;width:24px;height:24px;border-radius:999px;border:2px solid #b9c3d0;display:flex;align-items:center;justify-content:center;margin-top:.1rem;background:#fff;color:#fff;}
  .last-check-item.is-done .last-check-mark{background:#2f9e62;border-color:#2f9e62;}
  .last-check-copy{min-width:0;flex:1;}
  .last-check-title{font-size:.96rem;font-weight:800;color:var(--note-text);line-height:1.25;margin:0 0 .12rem 0;}
  .last-check-note{font-size:.88rem;color:var(--note-muted);line-height:1.4;margin:0;}

  .iv-subtle-card{background:#fff;border:1px solid var(--note-line);border-radius:1rem;padding:1rem;}
  .iv-record-box{background:var(--note-brand-soft);border:1px solid var(--note-brand-soft-border);border-radius:1rem;padding:1rem;}
  .iv-record-output{width:100%;min-height:170px;border:1px solid #d0d5dd;border-radius:.9rem;padding:.85rem .95rem;background:#fff;color:#101828;font-size:.95rem;line-height:1.4;resize:vertical;}
  .iv-inline-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
  .iv-summary-box .note-summary-item{padding:.72rem .85rem;}
  .iv-summary-box .note-summary-v{line-height:1.15;}
  .iv-warning-inline{background:#fff9e8;border:1px solid #ecd798;border-radius:1rem;padding:1rem;}
  @media (max-width:768px){
    .iv-inline-grid{grid-template-columns:1fr;}
  }
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="last-shell px-1 px-md-0 py-0">

        <div class="note-hero">
          <div class="note-hero-kicker">APP CLÍNICA · CHECKLIST DE VÍA AÉREA</div>
          <h2>Intubación vigil</h2>
          <p class="note-hero-subtitle">Checklist interactivo para preparación del paciente, material y ejecución ordenada de una intubación vigil.</p>
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
            <button id="expandAllBtn" class="btn note-checklist-btn">Expandir todo</button>
            <button id="collapseAllBtn" class="btn note-checklist-btn">Colapsar todo</button>
            <button id="resetBtn" class="btn note-checklist-btn note-checklist-btn-danger">Reiniciar</button>
          </div>
        </div>

        <div class="section-card p-3 p-md-4 mb-3">
          <div class="section-title mb-3">Datos clave</div>
          <div class="iv-inline-grid">
            <div class="note-input-group">
              <label class="note-label" for="routeSelect">Ruta principal planificada</label>
              <div class="note-choice-grid">
                <div>
                  <input class="note-check route-check" type="radio" name="route" id="routeOral" value="Oral" checked>
                  <label class="note-option" for="routeOral"><i class="fa-solid fa-mouth"></i> Oral<small>Fibro o Ambuscope</small></label>
                </div>
                <div>
                  <input class="note-check route-check" type="radio" name="route" id="routeNasal" value="Nasal">
                  <label class="note-option" for="routeNasal"><i class="fa-solid fa-nose"></i> Nasal<small>Vasoconstrictor + preparación nasal</small></label>
                </div>
              </div>
            </div>

            <div class="note-input-group">
              <label class="note-label" for="weightInput">Peso</label>
              <div class="note-input-inline">
                <input type="text" id="weightInput" class="note-input" inputmode="decimal" placeholder="Ej: 70">
                <div class="note-input-unit">kg</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-summary-box iv-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Selecciona la ruta principal y, si lo deseas, agrega el peso para calcular un tope orientativo de lidocaína total.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Ruta</div>
              <div id="summaryRoute" class="note-summary-v">Oral</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Dispositivo</div>
              <div id="summaryDevice" class="note-summary-v">Fibro / Ambuscope</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Peso usado</div>
              <div id="summaryWeight" class="note-summary-v">No ingresado</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Lidocaína total orientativa</div>
              <div id="summaryLidoMax" class="note-summary-v">-</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Tope orientativo de lidocaína</div>
            <div id="lidoMaxResult" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Suma spray, nebulización, gel, infiltración y dosis transtraqueal.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Recordatorio crítico</div>
            <div id="topicalReminder" class="note-result-card-value">Topicalización probada</div>
            <div class="note-result-card-note">La sedación no debe reemplazar una anestesia tópica insuficiente.</div>
          </div>
        </div>

        <div id="lidoWarning" class="iv-warning-inline mb-3 note-hidden">
          <strong>Advertencia:</strong> el cálculo de lidocaína es solo orientativo. En intubación vigil, la absorción varía según mucosa, técnica, concentración, mezcla de preparaciones y comorbilidades. Si el plan requiere dosis altas, reevalúa la estrategia antes de empezar.
        </div>

        <div class="last-checklist-section" data-section="1">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">1. Preparación del paciente</h3>
              <p class="last-checklist-help">Consentimiento, evaluación, educación y condiciones iniciales antes de montar la técnica.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="last-checklist-list">
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Consentimiento y cooperación explicados</div><p class="last-check-note">Explicar que requerirá cooperación, sensación de spray, tos y necesidad de seguir instrucciones.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Revisar imágenes y antecedentes relevantes</div><p class="last-check-note">Imágenes, cirugía previa, radioterapia, masas, estenosis, movilidad cervical y examen de vía aérea.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Confirmar ayuno y riesgo de aspiración</div><p class="last-check-note">Si el contexto cambia la estrategia, no actuar como si fuera una ATI rutinaria.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Monitorización, VVP y pausa de seguridad</div><p class="last-check-note">Monitores completos, vía venosa permeable y chequeo final del plan primario.</p></div></label>
            </div>
          </div>
        </div>

        <div class="last-checklist-section" data-section="2">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">2. Preparación del material y del pabellón</h3>
              <p class="last-checklist-help">Material principal, oxigenación, succión, plan alternativo y ergonomía del procedimiento.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="last-checklist-list">
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Fibrobroncoscopio / Ambuscope probado</div><p class="last-check-note">Comprobar imagen, movilidad y paso real a través del tubo elegido antes de comenzar.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Tubo elegido y probado sobre el endoscopio</div><p class="last-check-note">Lubricado, cuff desinflado y técnica estéril. En ruta nasal, evitar tubo nasal preformado por la curva del fibro; considerar un número menor o reforzado.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Topicalización disponible y dosificada</div><p class="last-check-note">Spray, gel, ampollas, nebulización, material para infiltración / transtraqueal y cálculo previo de lidocaína total.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">O₂, aspiración y ventilación por fosa contralateral listos</div><p class="last-check-note">Tubo nasofaríngeo con conexión a tubo 6,0 si usarás ventilación contralateral durante la fibroscopia.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Sedación preparada con titulación fina</div><p class="last-check-note">TCI o estrategia equivalente. Remifentanilo titulable y, si lo usarás, propofol sin perder el objetivo de cooperación y ventilación espontánea.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Plan B / Plan C discutidos</div><p class="last-check-note">Incluye necesidad de cirujano lavado o acceso frontal de cuello si el escenario realmente lo exige.</p></div></label>
            </div>
          </div>
        </div>

        <div class="last-checklist-section" data-section="3">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">3. Justo antes de comenzar</h3>
              <p class="last-checklist-help">Últimos pasos que ordenan el inicio del procedimiento.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="last-checklist-list">
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Topicalización inicial completada y probada</div><p class="last-check-note">Nebulización, spray oral y/o nasal, gárgaras y comprobación clínica de que la anestesia tópica realmente funciona.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Bloqueos realizados si eran necesarios</div><p class="last-check-note">No hacer bloqueos por rutina si la topicalización ya es suficiente; hazlos si aportan comodidad y seguridad real.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Preoxigenación adecuada</div><p class="last-check-note">Antes de instrumentar y antes de profundizar sedación.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Ruta nasal: vasoconstrictor o algodón con fenilefrina / oximetazolina</div><p class="last-check-note">Preparar la fosa a intervenir y decidir qué lado está más favorable.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Tubo pasado previamente por el fibro y punta desempañada</div><p class="last-check-note">Lubricar, desinflar cuff y preparar antiempañante antes de introducir el endoscopio.</p></div></label>
            </div>
          </div>
        </div>

        <div class="last-checklist-section" data-section="4">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">4. Durante el procedimiento</h3>
              <p class="last-checklist-help">Secuencia técnica y recordatorios que ayudan a no perder el orden.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="last-checklist-list">
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Atropina si la tolera</div><p class="last-check-note">Puede ayudar a disminuir secreciones antes de la inducción si el paciente tolera taquicardia.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Sedación titulada sin perder cooperación</div><p class="last-check-note">Ir titulando remifentanilo y, si se usa, propofol. No profundizar hasta perder ventilación espontánea o respuesta útil.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Mantener visualización continua de la vía aérea</div><p class="last-check-note">No avanzar a ciegas; el endoscopio debe mantener visualización paso a paso.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Instilar lidocaína en cuerdas si hace falta</div><p class="last-check-note">Explicar que puede producir tos y administrar solo si añade control real del estímulo.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Atravesar glotis por el centro o comisura anterior</div><p class="last-check-note">La comisura anterior puede ser menos estimulante en algunos pacientes.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Pasar el tubo con rotación suave tras ver tráquea</div><p class="last-check-note">Si se traba, no empujar sin visión; reajusta posición, eje o rotación.</p></div></label>
            </div>
          </div>
        </div>

        <div class="last-checklist-section" data-section="5">
          <div class="last-checklist-head">
            <div>
              <h3 class="last-checklist-title">5. Post procedimiento</h3>
              <p class="last-checklist-help">Confirmación, inducción y cierre seguro del procedimiento.</p>
            </div>
            <i class="fa-solid fa-chevron-down last-checklist-chevron"></i>
          </div>
          <div class="last-checklist-body">
            <div class="last-checklist-list">
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Visualizar tubo inserto en tráquea</div><p class="last-check-note">Idealmente ver tráquea y, si es posible, carina antes de inducir.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Inflar cuff e inducir al paciente</div><p class="last-check-note">Solo una vez verificada la posición y con plan claro para el siguiente paso anestésico.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Confirmar posición con capnografía y/o visión directa</div><p class="last-check-note">No basarse en una sola señal ambigua si el contexto sigue siendo difícil.</p></div></label>
              <label class="last-check-item"><input class="last-check-input task-check" type="checkbox"><div class="last-check-mark"><i class="fa-solid fa-check"></i></div><div class="last-check-copy"><div class="last-check-title">Registrar dosis total de lidocaína y eventos relevantes</div><p class="last-check-note">Útil para seguridad, docencia y continuidad del caso.</p></div></label>
            </div>
          </div>
        </div>

        <div class="iv-subtle-card mb-3">
          <div class="note-card-title mb-2">Notas rápidas</div>
          <div class="iv-inline-grid">
            <div>
              <div class="small-note mb-2">Hora de inicio</div>
              <input type="time" id="timeStart" class="note-text-input">
            </div>
            <div>
              <div class="small-note mb-2">Notas breves</div>
              <input type="text" id="notesBox" class="note-text-input" placeholder="Ej: buena tolerancia, ruta nasal derecha, lidocaína total 280 mg">
            </div>
          </div>
        </div>

        <div class="iv-record-box mb-3">
          <div class="note-card-title mb-2">Registro resumido</div>
          <textarea id="recordOutput" class="iv-record-output"></textarea>
          <div class="note-checklist-toolbar mt-2">
            <button type="button" id="copySummaryBtn" class="btn note-checklist-btn"><i class="fa-solid fa-copy me-1"></i> Copiar</button>
            <button type="button" id="downloadTxtBtn" class="btn note-checklist-btn"><i class="fa-solid fa-file-arrow-down me-1"></i> Descargar TXT</button>
          </div>
          <div id="copyFeedback" class="small-note mt-2 note-hidden">Resumen copiado al portapapeles.</div>
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
              <?php echo $formula; ?>
            <?php } ?>
            <hr>
            <div class="small-note mb-2"><strong>Clave operativa:</strong> buena preparación, buena topicalización y sedación titulada pesan más que “empujar” el procedimiento.</div>
            <hr>
            <div class="small-note mb-2"><strong>Referencias:</strong></div>
            <ul class="mb-0 ps-3">
              <?php foreach($referencias as $ref){ ?>
                <li class="mb-2"><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="note-teaching-wrap mb-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Topicaliza bien antes de sedar más</div>
          <div class="note-tips"><strong>Qué hacer:</strong> montar el caso como un procedimiento planificado, con ruta, dispositivo, oxígeno, aspiración y plan alternativo ya listos antes de empezar.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> usar sedación como sustituto de una anestesia tópica insuficiente o avanzar a ciegas cuando la visión se pierde.</div>
          <div class="note-tips mb-0"><strong>Error frecuente:</strong> olvidar sumar todas las fuentes de lidocaína o no verificar de verdad que el tubo y el endoscopio son compatibles antes de comenzar.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  if (CNS) {
    CNS.bindSelectionSync('.route-check');
  }

  const checks = Array.from(document.querySelectorAll('.task-check'));
  const progressBar = document.getElementById('progressBar');
  const progressText = document.getElementById('progressText');
  const weightInput = document.getElementById('weightInput');
  const routeInputs = Array.from(document.querySelectorAll('.route-check'));
  const recordOutput = document.getElementById('recordOutput');
  const copyFeedback = document.getElementById('copyFeedback');

  const summaryRoute = document.getElementById('summaryRoute');
  const summaryDevice = document.getElementById('summaryDevice');
  const summaryWeight = document.getElementById('summaryWeight');
  const summaryLidoMax = document.getElementById('summaryLidoMax');
  const summaryNarrative = document.getElementById('summaryNarrative');
  const lidoMaxResult = document.getElementById('lidoMaxResult');
  const lidoWarning = document.getElementById('lidoWarning');

  function getSelectedRoute(){
    const selected = routeInputs.find(r => r.checked);
    return selected ? selected.value : 'Oral';
  }

  function getCurrentWeight(){
    const weight = CNS.parseDecimal(weightInput.value);
    return Number.isFinite(weight) && weight > 0 ? weight : null;
  }

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

  document.querySelectorAll('.last-checklist-head').forEach(function(head){
    head.addEventListener('click', function(){
      const section = head.closest('.last-checklist-section');
      if(section) toggleSection(section);
    });
  });

  document.getElementById('expandAllBtn').addEventListener('click', function(){
    document.querySelectorAll('.last-checklist-section').forEach(section => toggleSection(section, false));
  });

  document.getElementById('collapseAllBtn').addEventListener('click', function(){
    document.querySelectorAll('.last-checklist-section').forEach(section => toggleSection(section, true));
  });

  function updateSummary(){
    const route = getSelectedRoute();
    const weight = getCurrentWeight();
    const lidoMax = Number.isFinite(weight) ? 7 * weight : NaN;

    CNS.safeSetText(summaryRoute, route);
    CNS.safeSetText(summaryDevice, 'Fibro / Ambuscope');
    CNS.safeSetText(summaryWeight, Number.isFinite(weight) ? CNS.formatNumber(weight, 1) + ' kg' : 'No ingresado');
    CNS.safeSetText(summaryLidoMax, Number.isFinite(lidoMax) ? CNS.formatNumber(lidoMax, 0) + ' mg' : '-');
    CNS.safeSetText(lidoMaxResult, Number.isFinite(lidoMax) ? CNS.formatNumber(lidoMax, 0) + ' mg' : '-');

    summaryNarrative.textContent = Number.isFinite(weight)
      ? `Ruta ${route.toLowerCase()} seleccionada. Fibro / Ambuscope preparado. Tope orientativo de lidocaína total: ${CNS.formatNumber(lidoMax, 0)} mg.`
      : `Ruta ${route.toLowerCase()} seleccionada. Agrega el peso solo si quieres calcular un tope orientativo de lidocaína total.`;

    lidoWarning.classList.toggle('note-hidden', !(Number.isFinite(weight) && lidoMax >= 300));
  }

  function buildSummary(){
    const route = getSelectedRoute();
    const timeStart = document.getElementById('timeStart').value || '-';
    const weight = getCurrentWeight();
    const notes = document.getElementById('notesBox').value.trim() || '-';
    const lidoMax = Number.isFinite(weight) ? CNS.formatNumber(7 * weight, 0) + ' mg' : '-';
    const doneItems = checks.filter(c => c.checked).map(c => '- ' + c.closest('.last-check-item').querySelector('.last-check-title').textContent.trim()).join('\n') || '- Ninguna acción marcada';

    return [
      'CHECKLIST INTUBACIÓN VIGIL',
      'Ruta principal: ' + route,
      'Hora de inicio: ' + timeStart,
      'Peso: ' + (Number.isFinite(weight) ? CNS.formatNumber(weight, 1) + ' kg' : '-'),
      'Lidocaína total orientativa: ' + lidoMax,
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

  checks.forEach(check => check.addEventListener('change', updateProgress));
  routeInputs.forEach(r => r.addEventListener('change', function(){ updateSummary(); updateRecordOutput(); }));
  weightInput.addEventListener('input', function(){ updateSummary(); updateRecordOutput(); });
  document.getElementById('timeStart').addEventListener('input', updateRecordOutput);
  document.getElementById('notesBox').addEventListener('input', updateRecordOutput);

  document.getElementById('resetBtn').addEventListener('click', function(){
    checks.forEach(c => { c.checked = false; setChecklistItemState(c); });
    document.getElementById('routeOral').checked = true;
    weightInput.value = '';
    document.getElementById('timeStart').value = '';
    document.getElementById('notesBox').value = '';
    copyFeedback.classList.add('note-hidden');
    updateSummary();
    updateProgress();
    if (CNS) CNS.applySelectionBorder('.route-check');
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
    a.download = 'checklist_intubacion_vigil.txt';
    a.click();
    URL.revokeObjectURL(a.href);
  });

  updateSummary();
  updateProgress();
})();
</script>

<?php include('footer.php'); ?>
