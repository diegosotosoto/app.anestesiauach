<?php 
$titulo_pagina = "Clasificación ASA";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "La clasificación ASA Physical Status permite describir el estado físico preoperatorio del paciente, estandarizar la comunicación clínica y apoyar la estimación global de riesgo perioperatorio. No reemplaza la valoración individual ni el riesgo propio del procedimiento.";
$formula = "ASA I–VI según gravedad de la enfermedad sistémica. Agregar sufijo E cuando la cirugía es de urgencia / emergencia. ASA describe al paciente; no clasifica la cirugía ni la técnica anestésica.";
$referencias = array(
  "American Society of Anesthesiologists. ASA Physical Status Classification System.",
  "Sankar A, et al. Comparison of the ASA Physical Status Classification System and other risk classification systems. Br J Anaesth. 2014.",
  "Hackett NJ, et al. ASA class is a reliable independent predictor of medical complications. Anesthesiology. 2015.",
  "Yevenes S, Epulef V, Rocco C, Geisse F, Vial M. Clasificación American Society of Anesthesiologists Physical Status: Revisión de ejemplos locales - Chile. Rev Chil Anest. 2022;51(3):251-260."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=2"></script>

        <style>
          .asa-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .asa-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .asa-option{
            display:flex;
            align-items:flex-start;
            gap:.7rem;
            min-height:86px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.75rem .85rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            color:var(--note-text);
          }

          .asa-input:checked + .asa-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .asa-checkmark{
            flex:0 0 auto;
            width:28px;
            height:28px;
            border-radius:999px;
            border:2px solid #c9d3df;
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            margin-top:.05rem;
            transition:.15s ease;
          }

          .asa-input:checked + .asa-option .asa-checkmark{
            background:#2ea663;
            border-color:#2ea663;
            color:#fff;
          }

          .asa-option-copy{
            min-width:0;
            flex:1;
          }

          .asa-option-top{
            display:flex;
            align-items:center;
            gap:.45rem;
            flex-wrap:wrap;
            margin-bottom:.15rem;
          }

          .asa-pill{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:58px;
            padding:.18rem .48rem;
            border-radius:.65rem;
            font-weight:900;
            font-size:.82rem;
            line-height:1.1;
          }

          .asa-pill-1{background:#198754;color:#fff;}
          .asa-pill-2{background:#f4d35e;color:#3d2d00;}
          .asa-pill-3{background:#6b5e3c;color:#fff;}
          .asa-pill-4{background:#dc3545;color:#fff;}
          .asa-pill-5{background:#8b3a3a;color:#fff;}
          .asa-pill-6{background:#6c757d;color:#fff;}

          .asa-option-title{
            font-size:.96rem;
            font-weight:850;
            line-height:1.16;
            color:var(--note-text);
            margin:0;
          }

          .asa-option-sub{
            font-size:.82rem;
            line-height:1.3;
            color:var(--note-muted);
            margin:0;
          }

          .asa-bg-1{background:#e8f7f2;}
          .asa-bg-2{background:#fff9e8;}
          .asa-bg-3{background:#fff2e0;}
          .asa-bg-4{background:#ffecec;}
          .asa-bg-5{background:#ffdede;}
          .asa-bg-6{background:#f5f5f5;}

          .asa-emergency-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .asa-emergency-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:80px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.5rem .65rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.12rem;
          }

          .asa-emergency-option i{
            color:#3559b7;
            font-size:.95rem;
          }

          .asa-input:checked + .asa-emergency-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .asa-emergency-title{
            font-size:.92rem;
            font-weight:850;
            line-height:1.12;
            color:var(--note-text);
          }

          .asa-emergency-sub{
            font-size:.75rem;
            line-height:1.18;
            color:var(--note-muted);
            font-weight:650;
          }

          .asa-result-low{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .asa-result-mid{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .asa-result-high{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          .asa-result-critical{
            background:#ffe6e6 !important;
            border-color:#ef9a9a !important;
          }

          .asa-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .asa-plan-line:last-child{
            margin-bottom:0;
          }

          @media (max-width:768px){
            .asa-choice-grid{
              grid-template-columns:1fr;
            }

            .asa-emergency-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .asa-emergency-grid{
              grid-template-columns:1fr;
            }
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">
        
<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">


        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · EVALUACIÓN PREOPERATORIA</div>
          <h2>Clasificación ASA</h2>
          <div class="note-hero-subtitle">Selecciona el estado físico preoperatorio y agrega sufijo E si la cirugía es urgente o emergente.</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
            <hr>
            <b>Concepto:</b><br>
            <?php echo $formula; ?>
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
            <div class="note-section-label">Selecciona la clase ASA</div>

            <div class="asa-choice-grid">
              <label>
                <input class="asa-input asa-trigger" type="radio" name="asaClass" value="1" checked>
                <div class="asa-option asa-bg-1">
                  <div class="asa-checkmark"><i class="fa-solid fa-check"></i></div>
                  <div class="asa-option-copy">
                    <div class="asa-option-top">
                      <span class="asa-pill asa-pill-1">ASA I</span>
                      <div class="asa-option-title">Paciente sano</div>
                    </div>
                    <p class="asa-option-sub">Sin enfermedad sistémica clínicamente relevante.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="asa-input asa-trigger" type="radio" name="asaClass" value="2">
                <div class="asa-option asa-bg-2">
                  <div class="asa-checkmark"><i class="fa-solid fa-check"></i></div>
                  <div class="asa-option-copy">
                    <div class="asa-option-top">
                      <span class="asa-pill asa-pill-2">ASA II</span>
                      <div class="asa-option-title">Enfermedad sistémica leve</div>
                    </div>
                    <p class="asa-option-sub">Comorbilidad leve, sin limitación funcional importante.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="asa-input asa-trigger" type="radio" name="asaClass" value="3">
                <div class="asa-option asa-bg-3">
                  <div class="asa-checkmark"><i class="fa-solid fa-check"></i></div>
                  <div class="asa-option-copy">
                    <div class="asa-option-top">
                      <span class="asa-pill asa-pill-3">ASA III</span>
                      <div class="asa-option-title">Enfermedad sistémica severa</div>
                    </div>
                    <p class="asa-option-sub">Limitación funcional significativa o compromiso sistémico mayor.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="asa-input asa-trigger" type="radio" name="asaClass" value="4">
                <div class="asa-option asa-bg-4">
                  <div class="asa-checkmark"><i class="fa-solid fa-check"></i></div>
                  <div class="asa-option-copy">
                    <div class="asa-option-top">
                      <span class="asa-pill asa-pill-4">ASA IV</span>
                      <div class="asa-option-title">Amenaza constante para la vida</div>
                    </div>
                    <p class="asa-option-sub">Enfermedad crítica activa con alto compromiso fisiológico.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="asa-input asa-trigger" type="radio" name="asaClass" value="5">
                <div class="asa-option asa-bg-5">
                  <div class="asa-checkmark"><i class="fa-solid fa-check"></i></div>
                  <div class="asa-option-copy">
                    <div class="asa-option-top">
                      <span class="asa-pill asa-pill-5">ASA V</span>
                      <div class="asa-option-title">Paciente moribundo</div>
                    </div>
                    <p class="asa-option-sub">No sobrevivirá sin intervención quirúrgica inmediata.</p>
                  </div>
                </div>
              </label>

              <label>
                <input class="asa-input asa-trigger" type="radio" name="asaClass" value="6">
                <div class="asa-option asa-bg-6">
                  <div class="asa-checkmark"><i class="fa-solid fa-check"></i></div>
                  <div class="asa-option-copy">
                    <div class="asa-option-top">
                      <span class="asa-pill asa-pill-6">ASA VI</span>
                      <div class="asa-option-title">Muerte cerebral</div>
                    </div>
                    <p class="asa-option-sub">Donante de órganos con soporte vital.</p>
                  </div>
                </div>
              </label>
            </div>

            <div class="note-section-label mt-4">Urgencia / emergencia</div>
            <div class="asa-emergency-grid">
              <label>
                <input class="asa-input asa-trigger" type="radio" name="emergency" value="no" checked>
                <div class="asa-emergency-option">
                  <i class="fa-solid fa-calendar-check"></i>
                  <div class="asa-emergency-title">Electiva / programada</div>
                  <div class="asa-emergency-sub">sin sufijo E</div>
                </div>
              </label>

              <label>
                <input class="asa-input asa-trigger" type="radio" name="emergency" value="yes">
                <div class="asa-emergency-option">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                  <div class="asa-emergency-title">Urgencia / emergencia</div>
                  <div class="asa-emergency-sub">agregar E</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">ASA I: paciente sano. Procedimiento electivo/programado.</div>
          <div class="note-result-grid-2 mt-2">
            <div class="note-result-card">
              <div class="note-result-card-label">Clasificación</div>
              <div id="summaryClass" class="note-result-card-value">ASA I</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Urgencia</div>
              <div id="summaryEmergency" class="note-result-card-value">No</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Qué describe</div>
              <div class="note-result-card-value">Estado físico</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Qué no describe</div>
              <div class="note-result-card-value">Riesgo quirúrgico total</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="asaResultCard" class="note-result-card asa-result-low">
            <div class="note-result-card-label">Resultado ASA</div>
            <div id="asaResult" class="note-result-card-value">ASA I</div>
            <div id="asaResultNote" class="note-result-card-note">Paciente sano.</div>
          </div>
          <div id="riskCard" class="note-result-card asa-result-low">
            <div class="note-result-card-label">Lectura clínica</div>
            <div id="riskLevel" class="note-result-card-value">Bajo riesgo basal</div>
            <div id="riskNote" class="note-result-card-note">La clase ASA debe integrarse con el procedimiento y la reserva funcional.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación</div>
          <div id="interpMain" class="note-interpretation-main">ASA describe al paciente; no mide la cirugía.</div>
          <div id="interpSoft" class="note-interpretation-soft">A mayor ASA, mayor probabilidad de complicaciones perioperatorias, pero el riesgo final depende del procedimiento, urgencia, reserva funcional y contexto clínico.</div>

          <div class="mt-3 text-start">
            <div class="asa-plan-line"><strong>Definición:</strong> <span id="definitionText">Paciente sano, sin enfermedad sistémica clínicamente relevante.</span></div>
            <div class="asa-plan-line"><strong>Ejemplos adulto:</strong> <span id="adultExamples">Sano, no fumador, sin consumo relevante de alcohol.</span></div>
            <div class="asa-plan-line"><strong>Ejemplos pediátricos:</strong> <span id="pedsExamples">Sano, sin enfermedad aguda o crónica.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">No confundas ASA con riesgo quirúrgico total. Una cirugía menor no baja una clase ASA alta, y una cirugía urgente no modifica la clase: agrega el sufijo <strong>E</strong>.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Clasificación basal</div>
                  <p class="note-warning-note">Registrar ASA I si el paciente realmente no tiene enfermedad sistémica clínicamente relevante.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Clasifica según la condición sistémica más relevante actual</div>
          <div class="note-tips"><strong>Qué hacer:</strong> define la clase por el estado físico del paciente, luego integra cirugía, urgencia, capacidad funcional y reserva fisiológica.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> bajar el ASA porque el procedimiento es pequeño o subirlo solo porque la cirugía es compleja.</div>
          <div class="note-tips"><strong>Error frecuente:</strong> confundir urgencia con severidad fisiológica. La urgencia agrega <strong>E</strong>, no cambia el número.</div>
          <div class="note-tips"><strong>Duda entre dos categorías:</strong> busca limitación funcional, descompensación, amenaza fisiológica sostenida o necesidad de soporte.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> documenta el ASA como comunicación clínica, no como sustituto de evaluación preoperatoria completa.</div>
        </div>

        <div class="note-footer mt-3">
          Herramienta docente y de apoyo clínico. Confirmar clasificación con evaluación anestésica completa, comorbilidades activas, reserva funcional, urgencia y riesgo propio del procedimiento.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const ASA_DATA = {
    1:{
      label:'ASA I',
      title:'Paciente sano',
      risk:'Bajo riesgo basal',
      definition:'Paciente sano, sin enfermedad sistémica clínicamente relevante.',
      adult:'Sano, no fumador, sin consumo relevante de alcohol.',
      peds:'Sano, sin enfermedad aguda o crónica.',
      css:'asa-result-low',
      action:'Registrar ASA I si el paciente realmente no tiene enfermedad sistémica clínicamente relevante.',
      level:'ok'
    },
    2:{
      label:'ASA II',
      title:'Enfermedad sistémica leve',
      risk:'Riesgo basal levemente aumentado',
      definition:'Enfermedad sistémica leve, controlada y sin limitación funcional importante.',
      adult:'Fumador, embarazo, IMC 30–40, DM o HTA controlada.',
      peds:'Asma controlada, epilepsia controlada, cardiopatía congénita leve.',
      css:'asa-result-low',
      action:'Confirmar que la comorbilidad esté controlada y que no exista limitación funcional relevante.',
      level:'ok'
    },
    3:{
      label:'ASA III',
      title:'Enfermedad sistémica severa',
      risk:'Riesgo aumentado',
      definition:'Enfermedad sistémica severa con limitación funcional significativa o compromiso sistémico mayor.',
      adult:'EPOC, obesidad mórbida, cirrosis compensada, ERC en diálisis, DM mal controlada.',
      peds:'DM insulinodependiente, OSA severa, desnutrición, cardiopatía relevante.',
      css:'asa-result-mid',
      action:'Planificar optimización, monitorización y destino postoperatorio según comorbilidad y cirugía.',
      level:'mid'
    },
    4:{
      label:'ASA IV',
      title:'Amenaza constante para la vida',
      risk:'Alto riesgo basal',
      definition:'Enfermedad crítica activa con amenaza constante para la vida.',
      adult:'IAM reciente, sepsis, shock, insuficiencia cardíaca avanzada o falla respiratoria significativa.',
      peds:'Sepsis, encefalopatía hipóxica, falla respiratoria, cardiopatía sintomática.',
      css:'asa-result-high',
      action:'Requiere planificación anestésica explícita, optimización posible, monitorización avanzada y comunicación del riesgo.',
      level:'high'
    },
    5:{
      label:'ASA V',
      title:'Paciente moribundo',
      risk:'Riesgo crítico',
      definition:'Paciente moribundo que no sobrevivirá sin intervención quirúrgica inmediata.',
      adult:'Hemorragia intracraneal, aneurisma roto, isquemia intestinal o trauma exanguinante.',
      peds:'Trauma masivo, falla multiorgánica, paro cardiorrespiratorio recuperado.',
      css:'asa-result-critical',
      action:'Enfocar en control de daño, comunicación clara, reanimación y objetivos terapéuticos realistas.',
      level:'high'
    },
    6:{
      label:'ASA VI',
      title:'Muerte cerebral',
      risk:'Donante de órganos',
      definition:'Paciente en muerte cerebral mantenido con soporte vital para procuramiento de órganos.',
      adult:'Donante de órganos con diagnóstico de muerte cerebral.',
      peds:'Donante pediátrico en muerte cerebral con soporte vital.',
      css:'asa-result-mid',
      action:'Manejo orientado a preservación de órganos, coordinación con equipo de procuramiento y protocolo local.',
      level:'mid'
    }
  };

  const CNS = window.ClinicalNoteSystem || {};

  function setText(id, value){
    const el = document.getElementById(id);
    if(CNS.safeSetText) CNS.safeSetText(el, value);
    else if(el) el.textContent = value;
  }

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function renderActions(data, emergency){
    let items = [];

    if(data.level === 'ok'){
      items.push(['ok','Clasificación basal',data.action]);
      items.push(['ok','Integrar contexto','ASA bajo no significa riesgo cero: considerar procedimiento, vía aérea, sangrado, comorbilidades ocultas y capacidad funcional.']);
    } else if(data.level === 'mid'){
      items.push(['mid','Riesgo aumentado o contexto especial',data.action]);
      items.push(['mid','Planificar más allá del número','Revisar optimización, necesidad de monitorización, analgesia, fluidos y destino postoperatorio.']);
    } else {
      items.push(['high','Alto compromiso fisiológico',data.action]);
      items.push(['high','Comunicación del riesgo','Alinear plan anestésico, quirúrgico, reanimación, UCI y objetivos de cuidado.']);
    }

    if(emergency){
      items.unshift(['high','Sufijo E agregado','La urgencia aumenta riesgo y limita optimización, pero no cambia el número ASA: se documenta como ' + data.label + 'E.']);
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      return '<div class="note-warning-item">' +
        '<div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>' +
        '<div class="note-warning-copy">' +
          '<div class="note-warning-title">' + item[1] + '</div>' +
          '<p class="note-warning-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateASA(){
    const selected = Number(getSelected('asaClass') || 1);
    const emergency = getSelected('emergency') === 'yes';
    const data = ASA_DATA[selected] || ASA_DATA[1];
    const label = data.label + (emergency ? 'E' : '');

    setText('summaryClass', label);
    setText('summaryEmergency', emergency ? 'Sí · sufijo E' : 'No');
    setText('summaryNarrative', label + ': ' + data.title.toLowerCase() + '. ' + (emergency ? 'Cirugía urgente/emergente: agregar sufijo E.' : 'Procedimiento electivo/programado.'));
    setText('asaResult', label);
    setText('asaResultNote', data.title + '.');
    setText('riskLevel', data.risk);
    setText('riskNote', emergency ? 'La urgencia aumenta riesgo y reduce tiempo de optimización.' : 'La clase ASA debe integrarse con el procedimiento y la reserva funcional.');
    setText('definitionText', data.definition);
    setText('adultExamples', data.adult);
    setText('pedsExamples', data.peds);

    document.getElementById('asaResultCard').className = 'note-result-card ' + data.css;
    document.getElementById('riskCard').className = 'note-result-card ' + (emergency && selected >= 3 ? 'asa-result-high' : data.css);

    setText('interpMain', emergency ? label + ': estado físico + urgencia' : label + ': ' + data.title);
    setText('interpSoft', emergency
      ? 'El sufijo E comunica que el procedimiento es urgente o emergente. No modifica la clase base, pero sí el riesgo operativo y la posibilidad de optimización.'
      : 'ASA describe el estado físico basal del paciente. No reemplaza evaluación de cirugía, vía aérea, sangrado, fragilidad, reserva funcional ni contexto anestésico.'
    );

    renderActions(data, emergency);
  }

  document.querySelectorAll('.asa-trigger').forEach(function(input){
    input.addEventListener('change', updateASA);
  });

  updateASA();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
