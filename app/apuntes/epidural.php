<?php
$titulo_pagina = "Analgesia epidural";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Resumen práctico de dosis habituales para analgesia epidural, top up epidural y analgesia combinada espinal/epidural en trabajo de parto. Incluye además manejo del catéter intratecal accidental y recomendaciones prácticas para optimizar la calidad analgésica.";
$formula = "Las dosis deben titularse según dilatación cervical, dolor materno, respuesta clínica, nivel sensitivo y contexto obstétrico. Este apunte resume esquemas habituales de uso docente.";
$referencias = array(
  "Chestnut DH. Obstetric Anesthesia: Principles and Practice.",
  "Gambling DR, Douglas MJ. Obstetric Anesthesia and Uncommon Disorders.",
  "Sociedad de Anestesiología de Chile. Documentos docentes y recomendaciones de analgesia obstétrica.",
  "Wong CA. Labour analgesia: regional techniques."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<?php
$epiduralData = array(
  "inicio" => array(
    "title" => "Dosis epidural inicial",
    "volume" => "Volumen total aproximado: 20 mL",
    "rows" => array(
      "1-4" => array("Bupivacaína" => "10 mg", "Levobupivacaína" => "12,5 mg", "Ropivacaína" => "15 mg", "Fentanilo" => "50-100 µg", "Epinefrina" => "10-20 µg"),
      "4-8" => array("Bupivacaína" => "12,5 mg", "Levobupivacaína" => "15 mg", "Ropivacaína" => "20 mg", "Fentanilo" => "50-100 µg", "Epinefrina" => "10-20 µg"),
      ">8"  => array("Bupivacaína" => "15-20 mg", "Levobupivacaína" => "17,5-25 mg", "Ropivacaína" => "25-30 mg", "Fentanilo" => "50-100 µg", "Epinefrina" => "10-20 µg")
    )
  ),
  "topup" => array(
    "title" => "Top up epidural",
    "volume" => "Volumen total aproximado: 10-15 mL",
    "rows" => array(
      "2-6" => array("Bupivacaína" => "10 mg", "Levobupivacaína" => "12,5 mg", "Ropivacaína" => "15 mg", "Lidocaína" => "60 mg", "Fentanilo" => "20 µg", "Epinefrina" => "10 µg"),
      "6-8" => array("Bupivacaína" => "12,5 mg", "Levobupivacaína" => "15 mg", "Ropivacaína" => "17,5 mg", "Lidocaína" => "80 mg", "Fentanilo" => "20 µg", "Epinefrina" => "10-20 µg"),
      ">8"  => array("Bupivacaína" => "15-20 mg", "Levobupivacaína" => "17,5-25 mg", "Ropivacaína" => "25-30 mg", "Lidocaína" => "100 mg", "Fentanilo" => "20 µg", "Epinefrina" => "20 µg")
    )
  ),
  "cse" => array(
    "title" => "Dosis intratecal inicial (CSE)",
    "volume" => "Volumen intratecal aproximado: 5 mL",
    "rows" => array(
      "<4 solo fentanilo" => array("Bupivacaína" => "-", "Levobupivacaína" => "-", "Ropivacaína" => "-", "Fentanilo" => "15-25 µg"),
      "<4 con AL"         => array("Bupivacaína" => "1 mg", "Levobupivacaína" => "1-1,25 mg", "Ropivacaína" => "1,5 mg", "Fentanilo" => "10-20 µg"),
      ">4"                => array("Bupivacaína" => "2,5 mg", "Levobupivacaína" => "3,75 mg", "Ropivacaína" => "4-5 mg", "Fentanilo" => "20 µg")
    )
  ),
  "itcat" => array(
    "title" => "Catéter intratecal accidental",
    "volume" => "Uso titulado si se decide mantener el catéter",
    "rows" => array(
      "Dosis inicial"     => array("Bupivacaína" => "1-2,5 mg", "Fentanilo" => "15-20 µg"),
      "Dosis sucesivas"   => array("Bupivacaína" => "1-2 mg en bolos", "Fentanilo" => "Según respuesta / no siempre necesario"),
      "Perla práctica"    => array("Bupivacaína" => "Usar jeringas nuevas y rotulación clara", "Fentanilo" => "Vigilancia estrecha")
    )
  )
);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .epi-choice-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .epi-choice-grid.epi-stage-grid{grid-template-columns:repeat(3,minmax(0,1fr));}
          .epi-option-input{position:absolute;opacity:0;pointer-events:none;}
          .epi-option{
            display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-start;text-align:left;
            gap:.25rem;min-height:86px;border:2px solid var(--note-line);background:#fff;border-radius:1rem;
            padding:.9rem .95rem;cursor:pointer;transition:.15s ease;box-shadow:0 3px 10px rgba(15,23,42,.04);
          }
          .epi-option-input:checked + .epi-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);transform:translateY(-1px);
          }
          .epi-option-title{font-size:.98rem;font-weight:800;line-height:1.2;color:var(--note-text);margin:0;}
          .epi-option-sub{font-size:.87rem;line-height:1.35;color:var(--note-muted);margin:0;}
          .epi-plan-line{padding:.75rem .85rem;border-radius:.9rem;background:#fff;border:1px solid var(--note-line-strong);margin-bottom:.6rem;}
          .epi-plan-line:last-child{margin-bottom:0;}
          .epi-table-wrap{overflow-x:auto;}
          .epi-table{width:100%;border-collapse:separate;border-spacing:0;min-width:760px;background:#fff;border:1px solid var(--note-line);border-radius:1rem;overflow:hidden;}
          .epi-table th,.epi-table td{padding:.8rem .85rem;border-bottom:1px solid #eef2f6;border-right:1px solid #eef2f6;vertical-align:top;text-align:left;}
          .epi-table th{background:#3559b7;color:#fff;font-size:.84rem;font-weight:800;}
          .epi-table th:last-child,.epi-table td:last-child{border-right:none;}
          .epi-table tr:last-child td{border-bottom:none;}
          .epi-table td:first-child{font-weight:800;color:var(--note-text);}
          @media (max-width:768px){
            .epi-choice-grid,.epi-choice-grid.epi-stage-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
          }
          @media (max-width:420px){
            .epi-choice-grid,.epi-choice-grid.epi-stage-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ANALGESIA OBSTÉTRICA</div>
          <h2>Analgesia epidural / combinada en trabajo de parto</h2>
          <div class="note-hero-subtitle">Selecciona contexto y dilatación para obtener una orientación rápida de dosis, refuerzos y perlas prácticas de manejo.</div>
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
            <div class="note-section-label">1. Contexto analgésico</div>
            <div class="epi-choice-grid">
              <label>
                <input class="epi-option-input" type="radio" name="epiMode" value="inicio" checked>
                <div class="epi-option">
                  <div class="epi-option-title">Inicio epidural</div>
                  <div class="epi-option-sub">Dosis inicial habitual en trabajo de parto.</div>
                </div>
              </label>
              <label>
                <input class="epi-option-input" type="radio" name="epiMode" value="topup">
                <div class="epi-option">
                  <div class="epi-option-title">Top up epidural</div>
                  <div class="epi-option-sub">Refuerzo cuando el catéter ya está funcionando.</div>
                </div>
              </label>
              <label>
                <input class="epi-option-input" type="radio" name="epiMode" value="cse">
                <div class="epi-option">
                  <div class="epi-option-title">Combinada espinal/epidural</div>
                  <div class="epi-option-sub">Dosis intratecal inicial orientativa.</div>
                </div>
              </label>
              <label>
                <input class="epi-option-input" type="radio" name="epiMode" value="itcat">
                <div class="epi-option">
                  <div class="epi-option-title">Catéter intratecal accidental</div>
                  <div class="epi-option-sub">Si decides mantenerlo y titular a efecto.</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">2. Dilatación / escenario</div>
            <div id="stageSelector" class="epi-choice-grid epi-stage-grid"></div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Inicio epidural en dilatación 1-4 cm. Esquema orientativo con volumen total aproximado de 20 mL.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Modo</div>
                <div id="summaryMode" class="note-result-card-value">Inicio epidural</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Escenario</div>
                <div id="summaryStage" class="note-result-card-value">1-4</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Volumen / contexto</div>
                <div id="summaryVolume" class="note-result-card-value">20 mL aprox.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Foco práctico</div>
                <div id="summaryFocus" class="note-result-card-value">Titular según respuesta</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-interpretation mb-3">
          <div class="note-interpretation-label">Esquema orientativo</div>
          <div id="algoMain" class="note-interpretation-main">Inicio epidural · 1-4 cm</div>
          <div id="algoSoft" class="note-interpretation-soft">Volumen total aproximado: 20 mL. Titula según respuesta, nivel sensitivo y contexto obstétrico.</div>

          <div class="note-result-grid-2 mt-3">
            <div class="note-result-card">
              <div class="note-result-card-label">Anestésico local sugerido</div>
              <div id="algoLocal" class="note-result-card-value">Bupivacaína 10 mg</div>
              <div id="algoLocalNote" class="note-result-card-note">Alternativas: levobupivacaína 12,5 mg o ropivacaína 15 mg.</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Aditivos frecuentes</div>
              <div id="algoAdj" class="note-result-card-value">Fentanilo 50-100 µg</div>
              <div id="algoAdjNote" class="note-result-card-note">Epinefrina 10-20 µg cuando sea parte del esquema.</div>
            </div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">Estas dosis son orientativas. Deben titularse según dolor, dilatación, progresión del trabajo de parto, respuesta clínica, nivel sensitivo y seguridad materno-fetal.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Tabla docente rápida</div>
            <div class="epi-table-wrap">
              <table class="epi-table">
                <thead>
                  <tr id="epiHeadRow">
                    <th>Escenario</th>
                  </tr>
                </thead>
                <tbody id="epiTableBody"></tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Factores que obligan a ser más conservador</div>
            <div class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">No basta con “poner el catéter”</div>
                  <p class="note-warning-note">No te vayas hasta lograr una contracción sin dolor. La calidad depende del seguimiento y titulación, no solo de la técnica.</p>
                </div>
              </div>
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Dolor sacro en segunda etapa</div>
                  <p class="note-warning-note">Puede requerir volúmenes mayores iniciales para cubrir raíces sacras. No asumas que el mismo esquema siempre sirve.</p>
                </div>
              </div>
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Sospecha de epidural fallida o mal posicionada</div>
                  <p class="note-warning-note">Reevalúa nivel sensitivo bilateral, respuesta al bolo y posibilidad de instalación intravascular o catéter ineficaz.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Una buena analgesia obstétrica depende más del seguimiento y titulación que de “poner el catéter y salir”</div>
          <div class="note-tips"><strong>Troubleshooting epidural:</strong> si el alivio es insuficiente, busca nivel sensitivo y motor bilateral. Puede darse un bolo de bupivacaína 0,125-0,25% (7 a 10 mL), aumentar velocidad de infusión y reconsiderar el catéter si no responde.</div>
          <div class="note-tips"><strong>Segunda etapa:</strong> para dolor sacro puede necesitarse un bolo inicial de mayor volumen. Un esquema frecuente es 10 mL de bupivacaína 0,25% si el dolor es importante o 0,125% si es moderado.</div>
          <div class="note-tips"><strong>Punción dural accidental:</strong> si el contexto lo permite, suele preferirse usar el catéter intratecal con pequeñas dosis tituladas antes que repetir inmediatamente una nueva punción epidural.</div>
          <div class="note-tips mb-0"><strong>Catéter intratecal accidental:</strong> dosis inicial sugerida bupivacaína 1-2,5 mg + fentanilo 15-20 µg; luego bolos de bupivacaína 1-2 mg titulando a efecto. Usa jeringas nuevas y rotulación clara en cada bolo.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const data = <?php echo json_encode($epiduralData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
  const modeInputs = Array.from(document.querySelectorAll('input[name="epiMode"]'));
  const stageSelector = document.getElementById('stageSelector');
  const epiHeadRow = document.getElementById('epiHeadRow');
  const epiTableBody = document.getElementById('epiTableBody');

  const modeMeta = {
    inicio: {
      label: 'Inicio epidural',
      focus: 'Titular según respuesta',
      soft: 'Volumen total aproximado: 20 mL. Titula según respuesta, nivel sensitivo y contexto obstétrico.',
      warning: 'La dosis inicial debe titularse según dolor materno, dilatación, progresión del trabajo de parto y respuesta clínica.',
      pearl: 'En inicio epidural, prioriza un esquema que permita una contracción sin dolor antes de retirarte.'
    },
    topup: {
      label: 'Top up epidural',
      focus: 'Refuerzo del catéter',
      soft: 'Volumen total aproximado: 10-15 mL. Evalúa si el catéter sigue siendo funcional antes de insistir con bolos repetidos.',
      warning: 'Si el catéter no mejora pese a refuerzos razonables, sospecha mala posición, instalación intravascular o necesidad de reemplazo.',
      pearl: 'Un top up que no mejora obliga a reevaluar el catéter, no solo a aumentar la dosis.'
    },
    cse: {
      label: 'Combinada espinal/epidural',
      focus: 'Dosis intratecal inicial',
      soft: 'En CSE la dosis intratecal es pequeña y debe adaptarse a dilatación, intensidad del dolor y velocidad de progresión.',
      warning: 'No confundas dosis epidural con dosis intratecal. El margen de error es mucho menor.',
      pearl: 'En CSE, pequeñas diferencias de dosis cambian mucho el efecto clínico.'
    },
    itcat: {
      label: 'Catéter intratecal accidental',
      focus: 'Titulación muy conservadora',
      soft: 'Si decides mantener el catéter intratecal, usa bolos pequeños, jeringas nuevas y rotulación clara.',
      warning: 'La titulación debe ser extremadamente prudente y con vigilancia estrecha materno-fetal.',
      pearl: 'Cuando usas un catéter intratecal accidental, la seguridad del proceso importa tanto como la dosis.'
    }
  };

  function getSelectedMode(){
    const selected = document.querySelector('input[name="epiMode"]:checked');
    return selected ? selected.value : 'inicio';
  }

  function getSelectedStage(mode){
    const selected = document.querySelector('input[name="epiStage"]:checked');
    const keys = Object.keys(data[mode].rows);
    return selected ? selected.value : keys[0];
  }

  function renderStageOptions(mode){
    const rows = Object.keys(data[mode].rows);
    stageSelector.innerHTML = rows.map(function(key, index){
      return '<label>' +
        '<input class="epi-option-input" type="radio" name="epiStage" value="' + key.replace(/"/g, '&quot;') + '"' + (index===0 ? ' checked' : '') + '>' +
        '<div class="epi-option">' +
          '<div class="epi-option-title">' + key + '</div>' +
          '<div class="epi-option-sub">Escenario docente seleccionado</div>' +
        '</div>' +
      '</label>';
    }).join('');

    Array.from(document.querySelectorAll('input[name="epiStage"]')).forEach(function(input){
      input.addEventListener('change', renderAll);
    });
  }

  function drugBadgeHtml(drug){
    var clase = 'drug-other';
    if(['Bupivacaína','Levobupivacaína','Ropivacaína','Lidocaína'].includes(drug)) clase = 'drug-local';
    else if(drug === 'Fentanilo') clase = 'drug-opioid';
    else if(drug === 'Epinefrina') clase = 'drug-vasoactive';
    return '<span class="drug-label ' + clase + ' drug-label-sm"><span class="drug-label-title">' + drug + '</span></span>';
  }

  function renderTable(mode){
    const rows = data[mode].rows;
    const firstRow = rows[Object.keys(rows)[0]];
    const cols = Object.keys(firstRow);

    epiHeadRow.innerHTML = '<th>Escenario</th>' + cols.map(function(col){
      return '<th>' + drugBadgeHtml(col) + '</th>';
    }).join('');

    epiTableBody.innerHTML = Object.keys(rows).map(function(stage){
      const row = rows[stage];
      return '<tr><td>' + stage + '</td>' + cols.map(function(col){
        return '<td>' + (row[col] || '-') + '</td>';
      }).join('') + '</tr>';
    }).join('');
  }

  function renderAll(){
    const mode = getSelectedMode();
    const meta = modeMeta[mode];
    const stage = getSelectedStage(mode);
    const row = data[mode].rows[stage];

    document.getElementById('summaryMode').textContent = meta.label;
    document.getElementById('summaryStage').textContent = stage;
    document.getElementById('summaryVolume').textContent = data[mode].volume;
    document.getElementById('summaryFocus').textContent = meta.focus;
    document.getElementById('summaryNarrative').textContent = meta.label + ' en escenario ' + stage + '. ' + meta.soft;

    document.getElementById('algoMain').textContent = meta.label + ' · ' + stage;
    document.getElementById('algoSoft').textContent = meta.soft;
    document.getElementById('warningText').textContent = meta.warning;

    const keys = Object.keys(row);
    const locals = ['Bupivacaína','Levobupivacaína','Ropivacaína','Lidocaína'].filter(function(k){ return row[k]; });
    const adjs = keys.filter(function(k){ !locals.includes(k); });

    document.getElementById('algoLocal').textContent = locals.length ? (locals[0] + ' ' + row[locals[0]]) : 'Sin anestésico local dominante';
    document.getElementById('algoLocalNote').textContent = locals.length > 1
      ? ('Alternativas: ' + locals.slice(1).map(function(k){ return k + ' ' + row[k]; }).join(' · '))
      : (meta.pearl);

    if(mode === 'inicio' || mode === 'topup'){
      document.getElementById('algoAdj').textContent = 'Fentanilo 50-100 µg';
      document.getElementById('algoAdjNote').textContent = 'Trabajo de parto: considerar además epinefrina cuando sea parte del esquema y el contexto clínico lo justifique.';
    } else if(mode === 'cse'){
      document.getElementById('algoAdj').textContent = 'Fentanilo 15-20 µg';
      document.getElementById('algoAdjNote').textContent = 'En combinada espinal-epidural, usar como aditivo intratecal frecuente según escenario clínico y respuesta.';
    } else {
      document.getElementById('algoAdj').textContent = adjs.length ? (adjs[0] + ' ' + row[adjs[0]]) : 'Sin aditivos fijos';
      document.getElementById('algoAdjNote').textContent = adjs.length > 1
        ? adjs.slice(1).map(function(k){ return k + ' ' + row[k]; }).join(' · ')
        : meta.pearl;
    }

    document.getElementById('drugPlan').innerHTML =
      '<div class="epi-plan-line"><strong>' + data[mode].title + ':</strong> ' + data[mode].volume + '.</div>' +
      '<div class="epi-plan-line"><strong>Escenario:</strong> ' + stage + '.</div>' +
      '<div class="epi-plan-line"><strong>Perla práctica:</strong> ' + meta.pearl + '</div>';
  }

  modeInputs.forEach(function(input){
    input.addEventListener('change', function(){
      renderStageOptions(getSelectedMode());
      renderTable(getSelectedMode());
      renderAll();
    });
  });

  renderStageOptions(getSelectedMode());
  renderTable(getSelectedMode());
  renderAll();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
