<?php
$titulo_pagina = "Analgesia EV Pediátrica";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para analgesia endovenosa perioperatoria pediátrica. Permite seleccionar peso, rango etáreo, grupo farmacológico, modo de uso y fármaco para obtener dosis orientativas, interpretación clínica y advertencias de seguridad.";
$formula = "La analgesia EV pediátrica debe ajustarse por peso, edad, tipo de fármaco, contexto perioperatorio y riesgo respiratorio. La multimodalidad con no opioides reduce requerimientos de opioides, pero no reemplaza el juicio clínico ni la monitorización.";
$referencias = array(
  "Vittinghoff M, et al. Postoperative Pain Management in children: guidance from the Pain Committee of the European Society for Paediatric Anaesthesiology (ESPA Pain Management Ladder Initiative) Part II. Anaesthesia Critical Care & Pain Medicine. 2024;43:101427.",
  "Vittinghoff M, et al. Postoperative pain management in children: Guidance from the pain committee of the European Society for Paediatric Anaesthesiology. Paediatr Anaesth. 2018;28:493-506.",
  "Russell P, von Ungern-Sternberg BS, Schug SA. Perioperative analgesia in pediatric surgery. Curr Opin Anaesthesiol. 2013;26:420-427.",
  "Williams G. Perioperative analgesic pharmacology in children. Update in Anaesthesia.",
  "Tabla docente local de analgésicos pediátricos perioperatorios."
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
          .analg-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .analg-choice-grid.analg-grid-3{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }

          .analg-choice-grid.analg-grid-4{
            grid-template-columns:repeat(4,minmax(0,1fr));
          }

          .analg-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .analg-option{
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

          .analg-option i{
            color:#3559b7;
            font-size:.95rem;
            margin-bottom:.05rem;
          }

          .analg-input:checked + .analg-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .analg-option-title{
            font-size:.92rem;
            font-weight:800;
            line-height:1.12;
            color:var(--note-text);
            margin:0;
          }

          .analg-option-sub{
            font-size:.75rem;
            line-height:1.18;
            color:var(--note-muted);
            margin:0;
            font-weight:650;
          }

          .analg-drug-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .analg-drug-chip{
            display:inline-block;
            padding:.22rem .48rem;
            border-radius:.6rem;
            font-weight:800;
            border:1px solid rgba(31,42,55,.12);
            line-height:1.1;
            color:#111827;
          }

          .analg-result-low{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .analg-result-mid{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .analg-result-high{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          .analg-action-list{
            display:grid;
            gap:.75rem;
          }

          .analg-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .analg-action-mark{
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

          .analg-action-mark.ok{background:#2ea663;}
          .analg-action-mark.mid{background:#f4c542;}
          .analg-action-mark.high{background:#d92d20;}

          .analg-action-copy{min-width:0;flex:1;}

          .analg-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .analg-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .analg-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .analg-plan-line:last-child{
            margin-bottom:0;
          }

          .analg-drug-option.drug-opioid{background:var(--drug-opioid);}
          .analg-drug-option.drug-local{background:var(--drug-local);}
          .analg-drug-option.drug-inductor{background:var(--drug-inductor);}
          .analg-drug-option.drug-other{background:var(--drug-other);}

          @media (max-width:768px){
            .analg-choice-grid.analg-grid-3,
            .analg-choice-grid.analg-grid-4,
            .analg-drug-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .analg-choice-grid,
            .analg-choice-grid.analg-grid-3,
            .analg-choice-grid.analg-grid-4,
            .analg-drug-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ANALGESIA PEDIÁTRICA · EV</div>
          <h2>Analgesia EV Pediátrica Perioperatoria</h2>
          <div class="note-hero-subtitle">Calcula dosis orientativas por peso y edad, integrando grupo farmacológico, modo de uso y seguridad de monitorización.</div>
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
              <b>Comentario:</b><br>
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
            <div class="note-section-label">Datos de entrada</div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Peso</label>
                <div class="note-input-inline">
                  <input id="pesoPaciente" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Prioridad clínica</label>
                <div class="note-result-secondary">
                  Calcula dosis, pero decide según edad, comorbilidades, vía aérea, dolor esperado y nivel de monitorización.
                </div>
              </div>
            </div>

            <div class="note-section-label">Rango etáreo</div>
            <div class="analg-choice-grid analg-grid-4 mb-3">
              <label>
                <input class="analg-input note-trigger" type="radio" name="edad" id="edad_lt3m" value="lt3m">
                <div class="analg-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="analg-option-title">&lt;3 m</div>
                  <div class="analg-option-sub">máxima cautela</div>
                </div>
              </label>
              <label>
                <input class="analg-input note-trigger" type="radio" name="edad" id="edad_3to12m" value="3to12m" checked>
                <div class="analg-option">
                  <i class="fa-solid fa-baby-carriage"></i>
                  <div class="analg-option-title">3–12 m</div>
                  <div class="analg-option-sub">menor margen</div>
                </div>
              </label>
              <label>
                <input class="analg-input note-trigger" type="radio" name="edad" id="edad_gt1y" value="gt1y">
                <div class="analg-option">
                  <i class="fa-solid fa-child"></i>
                  <div class="analg-option-title">&gt;1 a</div>
                  <div class="analg-option-sub">habitual</div>
                </div>
              </label>
              <label>
                <input class="analg-input note-trigger" type="radio" name="edad" id="edad_gt12y" value="gt12y">
                <div class="analg-option">
                  <i class="fa-solid fa-user"></i>
                  <div class="analg-option-title">&gt;12 a</div>
                  <div class="analg-option-sub">adolescente</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Grupo farmacológico</div>
            <div class="analg-choice-grid mb-3">
              <label>
                <input class="analg-input note-trigger" type="radio" name="grupo" id="grupo_noopioide" value="noopioide" checked>
                <div class="analg-option">
                  <i class="fa-solid fa-capsules"></i>
                  <div class="analg-option-title">No opioide</div>
                  <div class="analg-option-sub">base multimodal</div>
                </div>
              </label>
              <label>
                <input class="analg-input note-trigger" type="radio" name="grupo" id="grupo_opioide" value="opioide">
                <div class="analg-option">
                  <i class="fa-solid fa-syringe"></i>
                  <div class="analg-option-title">Opioide</div>
                  <div class="analg-option-sub">mayor vigilancia</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Modo de uso</div>
            <div class="analg-choice-grid analg-grid-3">
              <label>
                <input class="analg-input note-trigger" type="radio" name="modo" id="modo_bolo" value="bolo" checked>
                <div class="analg-option">
                  <i class="fa-solid fa-burst"></i>
                  <div class="analg-option-title">Bolo</div>
                  <div class="analg-option-sub">carga / intraop</div>
                </div>
              </label>
              <label>
                <input class="analg-input note-trigger" type="radio" name="modo" id="modo_inf" value="infusion">
                <div class="analg-option">
                  <i class="fa-solid fa-wave-square"></i>
                  <div class="analg-option-title">Infusión</div>
                  <div class="analg-option-sub">continua</div>
                </div>
              </label>
              <label>
                <input class="analg-input note-trigger" type="radio" name="modo" id="modo_rescate" value="rescate">
                <div class="analg-option">
                  <i class="fa-solid fa-life-ring"></i>
                  <div class="analg-option-title">Rescate</div>
                  <div class="analg-option-sub">postop / PACU</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Fármaco</div>
            <div id="drugButtons" class="analg-drug-grid"></div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso y selecciona edad, grupo, modo y fármaco para calcular dosis orientativa.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Paciente</div>
              <div id="summaryPatient" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Fármaco</div>
              <div id="summaryDrug" class="note-summary-v">Paracetamol</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Modo</div>
              <div id="summaryMode" class="note-summary-v">Bolo</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Clase</div>
              <div id="summaryClass" class="note-summary-v">No opioide</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="doseCard" class="note-result-card">
            <div class="note-result-card-label">Dosis calculada</div>
            <div id="doseValue" class="note-result-card-value">-</div>
            <div id="doseNote" class="note-result-card-note">Según peso y contexto clínico.</div>
          </div>
          <div id="presentationCard" class="note-result-card">
            <div class="note-result-card-label">Presentación / vía</div>
            <div id="presentationValue" class="note-result-card-value">-</div>
            <div id="presentationNote" class="note-result-card-note">Presentación sugerida del apunte.</div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="freqCard" class="note-result-card">
            <div class="note-result-card-label">Frecuencia o ritmo</div>
            <div id="frequencyValue" class="note-result-card-value">-</div>
            <div id="frequencyNote" class="note-result-card-note">Frecuencia sugerida / infusión.</div>
          </div>
          <div id="safetyCard" class="note-result-card">
            <div class="note-result-card-label">Seguridad principal</div>
            <div id="safetyShort" class="note-result-card-value">Pendiente</div>
            <div id="safetyNote" class="note-result-card-note">Aparecerá según fármaco y edad.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación clínica</div>
          <div id="riskText" class="note-interpretation-main">Sin cálculo aún</div>
          <div id="riskSoft" class="note-interpretation-soft">Completa peso, edad, grupo, modo y fármaco para obtener una guía orientativa.</div>

          <div class="mt-3 text-start">
            <div class="analg-plan-line"><strong>Dosis base:</strong> <span id="baseDoseText">-</span></div>
            <div class="analg-plan-line"><strong>Presentación:</strong> <span id="presentationLine">-</span></div>
            <div class="analg-plan-line"><strong>Advertencia específica:</strong> <span id="safetyText">La seguridad del fármaco seleccionado aparecerá aquí.</span></div>
          </div>
        </div>

        <div id="validityWarning" class="note-danger note-hidden mb-3">
          <strong>Dato a verificar:</strong>
          <div id="validityWarningText" class="mt-2"></div>
        </div>

        <div class="note-warning mb-3">
          <strong>Seguridad:</strong>
          <div class="mt-2">Las dosis son orientativas. Verifica concentración real, edad, función renal/hepática, comorbilidades, monitorización disponible y protocolo institucional antes de indicar.</div>
        </div>

        <div class="note-success mb-3">
          <strong>Multimodalidad:</strong>
          <div class="mt-2">Paracetamol y AINEs deben considerarse de base cuando no estén contraindicados, para disminuir requerimiento de opioides y sus efectos adversos.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="analg-action-list">
              <div class="analg-action-item">
                <div class="analg-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="analg-action-copy">
                  <div class="analg-action-title">Completa datos para calcular</div>
                  <p class="analg-action-note">La dosis depende de peso, edad, fármaco, modo y monitorización disponible.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">En analgesia EV pediátrica, el número no reemplaza la vigilancia</div>
          <div class="note-tips"><strong>Qué hacer:</strong> usar analgesia multimodal, calcular dosis por peso y reevaluar dolor, sedación, FR, hemodinamia y eventos adversos.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> indicar opioides EV o infusiones continuas sin monitorización proporcional al riesgo.</div>
          <div class="note-tips"><strong>Menores de 1 año:</strong> tienen menos margen para opioides, especialmente morfina; vigila depresión respiratoria y acumulación.</div>
          <div class="note-tips"><strong>OSA:</strong> reduce opioides 25–50% o evítalos si es posible; prioriza multimodalidad y vigilancia respiratoria.</div>
          <div class="note-tips"><strong>Infusiones:</strong> lidocaína, dexmedetomidina, ketamina, morfina, sufentanilo y remifentanilo requieren indicación clara y seguimiento estrecho.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si un niño necesita infusión continua de opioide o coadyuvante EV, piensa primero en monitorización y destino postoperatorio.</div>
        </div>

        <div class="note-footer">Herramienta docente y de apoyo clínico. Confirmar dosis, vía, contraindicaciones, función renal/hepática y nivel de monitorización requerido antes de indicar.</div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

  const DRUGS = {
    noopioide: {
      paracetamol: {
        nombre:'Paracetamol', clase:'other', presentacion:'EV 10 mg/mL', via:'EV, oral, rectal',
        safety:'Reducir dosis en neonatos o si hay riesgo hepático. Dosis máxima diaria 60–90 mg/kg según edad y vía.',
        safetyShort:'Revisar dosis diaria',
        dosis:{ bolo:{label:'Carga EV', unit:'mg/kg', min:15, max:20, freq:'cada 6–8 h'}, infusion:null, rescate:{label:'Mantenimiento EV', unit:'mg/kg', min:10, max:15, freq:'cada 6–8 h'} }
      },
      metamizol: {
        nombre:'Metamizol', clase:'other', presentacion:'EV / oral', via:'EV, oral',
        safety:'Uso hospitalario y corto plazo por riesgo de agranulocitosis. Útil en cirugía abdominal por efecto espasmolítico.',
        safetyShort:'Uso corto plazo',
        dosis:{ bolo:{label:'Bolo EV', unit:'mg/kg', min:10, max:15, freq:'cada 8 h'}, infusion:{label:'Infusión EV', unit:'mg/kg/h', min:2.5, max:2.5, freq:'continua'}, rescate:{label:'Oral / bolo', unit:'mg/kg', min:10, max:10, freq:'cada 8 h'} }
      },
      ibuprofeno: {
        nombre:'Ibuprofeno', clase:'other', presentacion:'EV / oral / rectal', via:'EV, oral, rectal',
        safety:'Generalmente no recomendado en <6 meses, aunque disponible desde los 3 meses en algunos países. Evitar en hipovolemia, falla renal o riesgo de sangrado.',
        safetyShort:'Evitar <6 m / renal',
        dosis:{ bolo:{label:'EV', unit:'mg/kg', min:10, max:10, freq:'cada 8 h'}, infusion:null, rescate:{label:'Oral / rectal', unit:'mg/kg', min:10, max:10, freq:'cada 8 h'} }
      },
      ketorolaco: {
        nombre:'Ketorolaco', clase:'other', presentacion:'EV', via:'EV',
        safety:'Solo uso corto plazo. Precaución en asmáticos, falla renal, hipovolemia o riesgo hemorrágico.',
        safetyShort:'Máx 48 h',
        dosis:{ bolo:{label:'Bolo intraop', unit:'mg/kg', min:0.5, max:1.0, freq:'máx 30 mg'}, infusion:null, rescate:{label:'Mantenimiento', unit:'mg/kg', min:0.15, max:0.2, freq:'cada 6 h · máx 10 mg'} }
      },
      lidocaina: {
        nombre:'Lidocaína', clase:'local', presentacion:'EV', via:'EV',
        safety:'Requiere monitorización cardíaca continua y observación clínica. Suspender ante síntomas neurológicos o arritmias.',
        safetyShort:'ECG continuo',
        dosis:{ bolo:{label:'Bolo', unit:'mg/kg', min:1.5, max:1.5, freq:'inicial'}, infusion:{label:'Infusión', unit:'mg/kg/h', min:1.5, max:1.5, freq:'continua hasta fin de cirugía'}, rescate:null }
      },
      dexmedetomidina: {
        nombre:'Dexmedetomidina', clase:'inductor', presentacion:'EV', via:'EV',
        safety:'Agonista alfa-2; útil como ahorrador de opioides, pero puede producir bradicardia e hipotensión.',
        safetyShort:'Bradicardia / hipotensión',
        dosis:{ bolo:{label:'Bolo', unit:'mcg/kg', min:0.5, max:1.0, freq:'inicial'}, infusion:{label:'Infusión', unit:'mcg/kg/h', min:0.2, max:0.7, freq:'continua'}, rescate:null }
      },
      ketamina: {
        nombre:'Ketamina', clase:'inductor', presentacion:'EV', via:'EV',
        safety:'Útil como co-analgésico ahorrador de opioides. Evitar en neonatos según este esquema.',
        safetyShort:'Evitar neonatos',
        dosis:{ bolo:{label:'Bolo intraop', unit:'mg/kg', min:0.5, max:0.5, freq:'según contexto'}, infusion:{label:'Infusión EV', unit:'mg/kg/h', min:0.1, max:0.2, freq:'continua'}, rescate:null }
      }
    },
    opioide: {
      morfina: {
        nombre:'Morfina', clase:'opioid', presentacion:'EV / SC', via:'EV bolo/infusión, SC infusión',
        safety:'Cuidado en <1 año, falla renal, hipovolemia y OSA. Vigilar depresión respiratoria y acumulación.',
        safetyShort:'Vigilar FR/sedación',
        dosis:{ bolo:{label:'Intraop EV', unit:'mcg/kg', min:25, max:100, freq:'bolo'}, infusion:{label:'Infusión EV', unit:'mcg/kg/h', min:10, max:40, freq:'continua'}, rescate:{label:'Rescate', unit:'mcg/kg', min:50, max:200, freq:'cada 4–6 h según edad'} }
      },
      fentanilo: {
        nombre:'Fentanilo', clase:'opioid', presentacion:'EV', via:'EV',
        safety:'Opioide de acción corta, útil en PACU; requiere titulación al efecto y vigilancia respiratoria.',
        safetyShort:'Titular al efecto',
        dosis:{ bolo:{label:'Intraop', unit:'mcg/kg', min:1, max:2, freq:'bolo'}, infusion:null, rescate:{label:'Rescate PACU', unit:'mcg/kg', min:0.5, max:1, freq:'titulado al efecto'} }
      },
      tramadol: {
        nombre:'Tramadol', clase:'opioid', presentacion:'EV / oral', via:'EV, oral',
        safety:'Menor riesgo de depresión respiratoria, pero puede bajar umbral convulsivo. Evitar combinación con fármacos serotoninérgicos.',
        safetyShort:'Convulsiones / náuseas',
        dosis:{ bolo:{label:'Bolo', unit:'mg/kg', min:1, max:1.5, freq:'cada 4–6 h'}, infusion:null, rescate:{label:'Rescate', unit:'mg/kg', min:1, max:1.5, freq:'cada 4–6 h'} }
      },
      nalbufina: {
        nombre:'Nalbufina', clase:'opioid', presentacion:'EV', via:'EV',
        safety:'Útil como rescate en infantes y niños mayores. Ajustar con prudencia en <3 meses.',
        safetyShort:'Reducir <3 m',
        dosis:{ bolo:null, infusion:null, rescate:{label:'Rescate', unit:'mg/kg', minLt3m:0.05, maxLt3m:0.05, min:0.1, max:0.2, freq:'cada 3–4 h'} }
      },
      sufentanilo: {
        nombre:'Sufentanilo', clase:'opioid', presentacion:'EV', via:'EV',
        safety:'Potente, útil para atenuar respuesta hemodinámica a intubación; requiere monitorización estricta.',
        safetyShort:'Alta potencia',
        dosis:{ bolo:{label:'Bolo', unit:'mcg/kg', min:0.5, max:1, freq:'inicial'}, infusion:{label:'Infusión', unit:'mcg/kg/h', min:0.5, max:1, freq:'continua'}, rescate:null }
      },
      remifentanilo: {
        nombre:'Remifentanilo', clase:'opioid', presentacion:'EV', via:'EV',
        safety:'Vida media ultra corta. Puede asociarse a hiperalgesia al suspenderse; requiere transición analgésica.',
        safetyShort:'Plan de transición',
        dosis:{ bolo:null, infusion:{label:'Infusión', unit:'mcg/kg/min', min:0.05, max:0.3, freq:'continua'}, rescate:null }
      }
    }
  };

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

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function drugClassToCss(clase){
    if(clase === 'opioid') return 'drug-opioid';
    if(clase === 'local') return 'drug-local';
    if(clase === 'inductor') return 'drug-inductor';
    return 'drug-other';
  }

  function ageText(age){
    if(age === 'lt3m') return '<3 meses';
    if(age === '3to12m') return '3–12 meses';
    if(age === 'gt1y') return '>1 año';
    return '>12 años';
  }

  function groupText(group){
    return group === 'opioide' ? 'Opioide' : 'No opioide';
  }

  function modeText(mode){
    if(mode === 'infusion') return 'Infusión';
    if(mode === 'rescate') return 'Rescate';
    return 'Bolo';
  }

  function rangeText(min, max, decimals){
    if(min === null || typeof min === 'undefined' || max === null || typeof max === 'undefined') return '-';
    if(Math.abs(min - max) < 0.00001) return fmt(min, decimals);
    return fmt(min, decimals) + '–' + fmt(max, decimals);
  }

  function renderDrugButtons(){
    const grupo = getSelected('grupo') || 'noopioide';
    const container = document.getElementById('drugButtons');
    const groupDrugs = DRUGS[grupo];

    container.innerHTML = Object.keys(groupDrugs).map(function(key, index){
      const drug = groupDrugs[key];
      const id = 'drug_' + key;
      return '<label>' +
        '<input class="analg-input note-trigger" type="radio" name="farmaco" id="' + id + '" value="' + key + '"' + (index === 0 ? ' checked' : '') + '>' +
        '<div class="analg-option analg-drug-option ' + drugClassToCss(drug.clase) + '">' +
          '<i class="fa-solid fa-vial"></i>' +
          '<div class="analg-option-title">' + drug.nombre + '</div>' +
          '<div class="analg-option-sub">' + groupText(grupo) + '</div>' +
        '</div>' +
      '</label>';
    }).join('');
  }

  function renderActions(level, drug, grupo, edad, modeData){
    let items = [];

    if(level === 'pending'){
      items = [
        ['mid','Completa datos para calcular','La dosis depende de peso, edad, fármaco, modo y monitorización disponible.']
      ];
    } else {
      if(grupo === 'opioide'){
        items.push(['high','Opioide EV = vigilancia respiratoria','Monitoriza FR, sedación, SpO₂, dolor y respuesta clínica. En OSA reduce dosis o evita opioides si es posible.']);
      } else {
        items.push(['ok','Base multimodal','Usa no opioides de base si no hay contraindicaciones para reducir requerimientos de opioides.']);
      }

      if(edad === 'lt3m' || edad === '3to12m'){
        items.push(['mid','Menor margen por edad','En lactantes, reduce umbral de alarma y reevalúa antes de repetir dosis.']);
      }

      if(drug.nombre === 'Lidocaína'){
        items.push(['high','ECG continuo','La lidocaína EV requiere monitorización cardíaca continua y vigilancia de toxicidad neurológica.']);
      }

      if(drug.nombre === 'Ketamina' && edad === 'lt3m'){
        items.unshift(['high','Evitar en neonatos','Según este esquema, no usar ketamina en <3 meses.']);
      }

      if(!modeData){
        items.unshift(['mid','Modo no aplicable','Selecciona otro modo o un fármaco compatible con el esquema.']);
      }
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="analg-action-item">' +
        '<div class="analg-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="analg-action-copy">' +
          '<div class="analg-action-title">' + item[1] + '</div>' +
          '<p class="analg-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function showValidityWarning(text){
    const box = document.getElementById('validityWarning');
    box.classList.remove('note-hidden');
    setText('validityWarningText', text);
  }

  function hideValidityWarning(){
    const box = document.getElementById('validityWarning');
    box.classList.add('note-hidden');
    setText('validityWarningText', '');
  }

  function updateAnalgesia(){
    const peso = parseLocal(document.getElementById('pesoPaciente').value);
    const edad = getSelected('edad') || '3to12m';
    const grupo = getSelected('grupo') || 'noopioide';
    const modo = getSelected('modo') || 'bolo';
    const farmacoKey = getSelected('farmaco');

    const drug = farmacoKey ? DRUGS[grupo][farmacoKey] : null;

    setText('summaryPatient', (peso && peso > 0 ? fmt(peso,2) + ' kg' : '-') + ' · ' + ageText(edad));
    setText('summaryDrug', drug ? drug.nombre : '-');
    setText('summaryMode', modeText(modo));
    setText('summaryClass', groupText(grupo));

    if(!drug || !peso || peso <= 0){
      hideValidityWarning();
      setText('summaryNarrative', 'Ingresa peso y selecciona edad, grupo, modo y fármaco para calcular dosis orientativa.');
      setText('doseValue', '-');
      setText('doseNote', 'Según peso y contexto clínico.');
      setText('presentationValue', '-');
      setText('presentationNote', 'Presentación sugerida del apunte.');
      setText('frequencyValue', '-');
      setText('frequencyNote', 'Frecuencia sugerida / infusión.');
      setText('safetyShort', 'Pendiente');
      setText('safetyNote', 'Aparecerá según fármaco y edad.');
      setText('riskText', 'Sin cálculo aún');
      setText('riskSoft', 'Completa peso, edad, grupo, modo y fármaco para obtener una guía orientativa.');
      setText('baseDoseText', '-');
      setText('presentationLine', '-');
      setText('safetyText', 'La seguridad del fármaco seleccionado aparecerá aquí.');
      document.getElementById('doseCard').className = 'note-result-card';
      document.getElementById('safetyCard').className = 'note-result-card';
      renderActions('pending', drug || {}, grupo, edad, null);
      return;
    }

    if(peso < 0.5 || peso > 120){
      showValidityWarning('Peso fuera de rango razonable para esta calculadora. Verifica el dato antes de interpretar dosis.');
    } else {
      hideValidityWarning();
    }

    const modeData = drug.dosis[modo];

    setText('presentationValue', drug.presentacion);
    setText('presentationNote', drug.via);
    setText('presentationLine', drug.presentacion + ' · ' + drug.via);
    setText('safetyShort', drug.safetyShort);
    setText('safetyNote', drug.safety);
    setText('safetyText', drug.safety);

    if(!modeData){
      setText('summaryNarrative', drug.nombre + ' no tiene esquema de ' + modeText(modo).toLowerCase() + ' en esta nota.');
      setText('doseValue', 'No aplica');
      setText('doseNote', 'Selecciona otro modo o fármaco compatible.');
      setText('frequencyValue', '-');
      setText('frequencyNote', 'No descrito');
      setText('riskText', 'Modo no definido');
      setText('riskSoft', 'Selecciona otro modo o un fármaco compatible.');
      setText('baseDoseText', 'No aplica para este modo.');
      document.getElementById('doseCard').className = 'note-result-card analg-result-mid';
      document.getElementById('safetyCard').className = grupo === 'opioide' ? 'note-result-card analg-result-high' : 'note-result-card analg-result-mid';
      renderActions('ok', drug, grupo, edad, modeData);
      return;
    }

    let min = modeData.min;
    let max = modeData.max;

    if(drug.nombre === 'Nalbufina' && modo === 'rescate' && edad === 'lt3m'){
      min = modeData.minLt3m;
      max = modeData.maxLt3m;
    }

    const totalMin = peso * min;
    const totalMax = peso * max;

    let decimals = 2;
    if(modeData.unit.includes('mcg')) decimals = 1;
    if(modeData.unit.includes('mg/kg') && totalMax >= 10) decimals = 1;

    let unitOut;
    if(modeData.unit.includes('/kg/h') || modeData.unit.includes('/kg/min')){
      unitOut = modeData.unit.replace('/kg', '');
    } else {
      unitOut = modeData.unit.split('/')[0];
    }

    const doseDisplay = rangeText(totalMin, totalMax, decimals) + ' ' + unitOut;
    const baseDose = rangeText(min, max, 2) + ' ' + modeData.unit + ' × ' + fmt(peso,2) + ' kg';

    setText('doseValue', doseDisplay);
    setText('doseNote', baseDose);
    setText('frequencyValue', modeData.freq);
    setText('frequencyNote', modeData.label);
    setText('baseDoseText', baseDose);

    let interp = 'Uso habitual';
    let interpSoft = 'Integra siempre contexto clínico, comorbilidades, edad y necesidad real de monitorización.';
    let doseClass = 'note-result-card analg-result-low';
    let safetyClass = 'note-result-card analg-result-low';

    if(grupo === 'opioide'){
      interp = 'Mayor vigilancia';
      interpSoft = 'Los opioides EV requieren monitoreo respiratorio y de sedación. En OSA, considera reducir dosis 25–50% o evitarlos si es posible.';
      safetyClass = 'note-result-card analg-result-high';
      doseClass = 'note-result-card analg-result-mid';
    }

    if(drug.nombre === 'Remifentanilo'){
      interp = 'Infusión de alta vigilancia';
      interpSoft = 'Útil por vida media ultra corta, pero puede favorecer hiperalgesia tras suspensión; planifica transición analgésica.';
      safetyClass = 'note-result-card analg-result-high';
    }

    if(drug.nombre === 'Lidocaína'){
      interp = 'Monitoreo ECG obligatorio';
      interpSoft = 'La lidocaína EV exige monitorización cardíaca continua y observación clínica.';
      safetyClass = 'note-result-card analg-result-high';
    }

    if(drug.nombre === 'Ketamina' && edad === 'lt3m'){
      interp = 'Evitar en neonatos';
      interpSoft = 'Según este esquema, la ketamina debe evitarse en neonatos por preocupación de neurotoxicidad.';
      doseClass = 'note-result-card analg-result-high';
      safetyClass = 'note-result-card analg-result-high';
    }

    if(drug.nombre === 'Morfina' && (edad === 'lt3m' || edad === '3to12m')){
      interp = 'Usar con especial prudencia';
      interpSoft = 'En menores de 1 año el margen de seguridad es menor; vigila depresión respiratoria y acumulación.';
      safetyClass = 'note-result-card analg-result-high';
    }

    setText('riskText', interp);
    setText('riskSoft', interpSoft);
    setText('summaryNarrative', ageText(edad) + ', ' + fmt(peso,2) + ' kg. ' + drug.nombre + ' en modo ' + modeText(modo).toLowerCase() + ': ' + doseDisplay + '.');

    document.getElementById('doseCard').className = doseClass;
    document.getElementById('safetyCard').className = safetyClass;

    renderActions('ok', drug, grupo, edad, modeData);
  }

  document.addEventListener('change', function(e){
    if(e.target.classList.contains('note-trigger')){
      if(e.target.name === 'grupo'){
        renderDrugButtons();
      }
      updateAnalgesia();
    }
  });

  document.getElementById('pesoPaciente').addEventListener('input', updateAnalgesia);

  renderDrugButtons();
  updateAnalgesia();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
