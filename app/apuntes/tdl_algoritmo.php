<?php
$titulo_pagina = "Tubo de doble lumen";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Algoritmo docente para elección inicial de tubo de doble lumen en anestesia torácica. Integra lado, sexo, talla y ajuste opcional por diámetro bronquial izquierdo cuando hay imagen disponible.";
$formula = "Elección habitual: TDL izquierdo. Tamaño inicial por sexo y talla; ajuste fino por diámetro bronquial cuando hay medición confiable. La posición debe confirmarse con fibrobroncoscopía.";
$referencias = array(
  "Campos JH. Current techniques for perioperative lung isolation in adults. Anesthesiology. 2002.",
  "Slinger P, Campos JH. Anesthesia for Thoracic Surgery. En: Miller's Anesthesia.",
  "Brodsky JB, Lemmens HJ. Left double-lumen tubes: clinical experience with double-lumen tubes. J Cardiothorac Vasc Anesth.",
  "Benumof JL. Lung isolation and one-lung ventilation. Anesthesiology Clinics."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=2"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .tdl-sections-row{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:1rem;
          }

          .tdl-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .tdl-choice-grid.tdl-grid-3{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }

          .tdl-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .tdl-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:72px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.65rem .75rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.18rem;
          }

          .tdl-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .tdl-option-input:checked + .tdl-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .tdl-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .tdl-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .tdl-ok-card{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .tdl-mid-card{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .tdl-danger-card{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          .tdl-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .tdl-plan-line:last-child{
            margin-bottom:0;
          }

          .tdl-schema-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .tdl-schema-card{
            border:1px solid var(--note-line);
            border-radius:1rem;
            background:#fff;
            padding:.85rem;
          }

          .tdl-schema-title{
            font-size:.95rem;
            font-weight:800;
            color:var(--note-text);
            text-align:center;
            margin-bottom:.65rem;
          }

          .tdl-diagram{
            width:100%;
            max-width:420px;
            height:auto;
            border-radius:1rem;
            display:block;
            margin:0 auto;
            border:1px solid #e6e9ef;
          }

          .tdl-table-wrap{
            overflow-x:auto;
            -webkit-overflow-scrolling:touch;
          }

          .tdl-table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            overflow:hidden;
          }

          .tdl-table th,
          .tdl-table td{
            padding:.62rem .7rem;
            border-bottom:1px solid #eef2f6;
            border-right:1px solid #eef2f6;
            vertical-align:top;
            text-align:left;
            font-size:.88rem;
            line-height:1.28;
          }

          .tdl-table th{
            background:#3559b7;
            color:#fff;
            font-size:.76rem;
            font-weight:800;
            line-height:1.2;
          }

          .tdl-table th:last-child,
          .tdl-table td:last-child{
            border-right:none;
          }

          .tdl-table tr:last-child td{
            border-bottom:none;
          }

          .tdl-table td:first-child{
            font-weight:800;
          }

          @media (max-width:768px){
            .tdl-sections-row{
              grid-template-columns:1fr;
            }
            .tdl-schema-grid{
              grid-template-columns:1fr;
            }
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · TÓRAX · AISLAMIENTO PULMONAR</div>
          <h2>Elección de tubo de doble lumen</h2>
          <div class="note-hero-subtitle">Selecciona lado y estima tamaño inicial por sexo/talla, con ajuste opcional por diámetro bronquial izquierdo.</div>
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
            <b>Esquema anatómico:</b>
            <div class="tdl-schema-grid mt-3">
              <div class="tdl-schema-card">
                <div class="tdl-schema-title">TDL izquierdo</div>
                <img src="img_apuntes/IMG_5527.jpg" alt="Esquema TDL izquierdo" class="tdl-diagram">
                <div class="note-muted mt-2 text-center">Elección habitual por mayor margen anatómico antes de la primera emergencia lobar.</div>
              </div>
              <div class="tdl-schema-card">
                <div class="tdl-schema-title">TDL derecho</div>
                <img src="img_apuntes/IMG_5528.jpg" alt="Esquema TDL derecho" class="tdl-diagram">
                <div class="note-muted mt-2 text-center">Reservado para indicaciones anatómicas o quirúrgicas específicas.</div>
              </div>
            </div>

            <hr>
            <b>Tabla rápida por sexo y talla:</b>
            <div class="tdl-table-wrap mt-3">
              <table class="tdl-table">
                <thead>
                  <tr>
                    <th>Sexo</th>
                    <th>Altura</th>
                    <th>Tamaño inicial</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td>Hombre</td><td>&gt;170 cm</td><td>41 Fr</td></tr>
                  <tr><td>Hombre</td><td>160–170 cm</td><td>39 Fr</td></tr>
                  <tr><td>Hombre</td><td>&lt;160 cm</td><td>37–39 Fr</td></tr>
                  <tr><td>Mujer</td><td>&gt;160 cm</td><td>37 Fr</td></tr>
                  <tr><td>Mujer</td><td>150–160 cm</td><td>35 Fr</td></tr>
                  <tr><td>Mujer</td><td>&lt;150 cm</td><td>32–35 Fr</td></tr>
                </tbody>
              </table>
            </div>

            <hr>
            <b>Ajuste opcional por diámetro bronquial izquierdo:</b>
            <div class="tdl-table-wrap mt-3">
              <table class="tdl-table">
                <thead>
                  <tr>
                    <th>Diámetro bronquial</th>
                    <th>Tamaño sugerido</th>
                    <th>Comentario</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td>≥12 mm</td><td>41 Fr</td><td>Compatibilizar con talla y marca disponible.</td></tr>
                  <tr><td>11,5–11,9 mm</td><td>39 Fr</td><td>Comparar con recomendación por talla.</td></tr>
                  <tr><td>10,5–11,4 mm</td><td>37 Fr</td><td>Evitar sobredimensionar.</td></tr>
                  <tr><td>10–10,4 mm</td><td>35 Fr</td><td>Usar con criterio anatómico.</td></tr>
                  <tr><td>&lt;10 mm</td><td>35 Fr o menor</td><td>Reconsiderar anatomía, dispositivo y estrategia.</td></tr>
                </tbody>
              </table>
            </div>

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
                <label class="note-label">Altura</label>
                <div class="note-input-inline">
                  <input id="altura" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">cm</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Diámetro bronquial izquierdo</label>
                <div class="note-input-inline">
                  <input id="diametro" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mm</div>
                </div>
                <div class="note-result-secondary">Opcional. Usar solo si proviene de TC o medición confiable.</div>
              </div>
            </div>

            <div class="">
              <div>
                <div class="note-section-label">Sexo</div>
                <div class="tdl-choice-grid">
                  <label>
                    <input class="tdl-option-input" type="radio" name="sexo" value="hombre" checked>
                    <div class="tdl-option">
                      <i class="fa-solid fa-person"></i>
                      <div class="tdl-option-title">Hombre</div>
                      <div class="tdl-option-sub">tabla por talla</div>
                    </div>
                  </label>
                  <label>
                    <input class="tdl-option-input" type="radio" name="sexo" value="mujer">
                    <div class="tdl-option">
                      <i class="fa-solid fa-person-dress"></i>
                      <div class="tdl-option-title">Mujer</div>
                      <div class="tdl-option-sub">tabla por talla</div>
                    </div>
                  </label>
                </div>
              </div>

              <div>
                <div class="note-section-label">Lado del TDL</div>
                <div class="tdl-choice-grid">
                  <label>
                    <input class="tdl-option-input" type="radio" name="lado" value="izquierdo" checked>
                    <div class="tdl-option">
                      <i class="fa-solid fa-lungs"></i>
                      <div class="tdl-option-title">Izquierdo</div>
                      <div class="tdl-option-sub">elección habitual</div>
                    </div>
                  </label>
                  <label>
                    <input class="tdl-option-input" type="radio" name="lado" value="derecho">
                    <div class="tdl-option">
                      <i class="fa-solid fa-triangle-exclamation"></i>
                      <div class="tdl-option-title">Derecho</div>
                      <div class="tdl-option-sub">indicación específica</div>
                    </div>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
          <div class="note-card-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa altura para estimar tamaño inicial del TDL.</div>
          <div class="note-result-grid-2">
            <div class="note-result-card">
              <div class="note-result-card-label">Sexo / altura</div>
              <div id="sumPatient" class="note-result-card-value">Hombre · -</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Lado</div>
              <div id="sumSide" class="note-result-card-value">Izquierdo</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Por talla</div>
              <div id="sumSizeHeight" class="note-result-card-value">-</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Por bronquio</div>
              <div id="sumSizeBronchus" class="note-result-card-value">No ingresado</div>
            </div>
          </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="sizeCard" class="note-result-card">
            <div class="note-result-card-label">Tamaño recomendado</div>
            <div id="resultadoNum" class="note-result-card-value">-</div>
            <div id="resultadoTexto" class="note-result-card-note">Ingresa altura para calcular.</div>
          </div>
          <div id="sideCard" class="note-result-card tdl-ok-card">
            <div class="note-result-card-label">Lado seleccionado</div>
            <div id="sideMain" class="note-result-card-value">Izquierdo</div>
            <div id="sideText" class="note-result-card-note">Elección habitual por mayor margen anatómico.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Lectura clínica</div>
          <div id="conductTitle" class="note-interpretation-main">Pendiente</div>
          <div id="conductText" class="note-interpretation-soft">Completa sexo y altura. Si además conoces el diámetro bronquial izquierdo, podrás ajustar mejor el tamaño del TDL.</div>

          <div class="mt-3 text-start">
            <div class="tdl-plan-line"><strong>Elección del lado:</strong> <span id="planSide">TDL izquierdo como elección habitual.</span></div>
            <div class="tdl-plan-line"><strong>Confirmación:</strong> <span>Fibrobroncoscopía antes y después del cambio de posición.</span></div>
            <div class="tdl-plan-line"><strong>Cuff bronquial:</strong> <span>Inflar solo con el volumen mínimo que logre sellado adecuado.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">La auscultación sola no basta. Todo TDL debe verificarse con fibrobroncoscopio, especialmente tras decúbito lateral, mala ventilación, fuga, mala exclusión pulmonar o cambios de posición.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Completa talla</div>
                  <p class="note-warning-note">La recomendación inicial se basa en sexo y altura; el diámetro bronquial puede refinar la decisión si es confiable.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">El TDL izquierdo es la elección habitual; el derecho se gana con una indicación</div>
          <div class="note-tips"><strong>Qué hacer:</strong> elegir tamaño por talla, ajustar con imagen si existe y confirmar siempre con fibrobroncoscopio.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> usar TDL derecho por rutina o confiar solo en auscultación.</div>
          <div class="note-tips"><strong>TDL derecho:</strong> exige más precisión por la emergencia precoz del bronquio lobar superior derecho.</div>
          <div class="note-tips"><strong>Mal aislamiento:</strong> ante ventilación difícil, fuga o mala exclusión, primero piensa en malposición hasta demostrar lo contrario.</div>
          <div class="note-tips"><strong>Tamaño:</strong> un TDL demasiado pequeño ventila peor, dificulta broncoscopía y puede aislar mal; uno excesivo aumenta trauma.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> después de posicionar al paciente en lateral, vuelve a mirar con fibrobroncoscopio.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

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
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? selected.value : null;
  }

  function recomendarPorTalla(sexo, altura){
    if(!altura || altura <= 0) return null;
    if(sexo === 'hombre'){
      if(altura > 170) return '41 Fr';
      if(altura >= 160) return '39 Fr';
      return '37–39 Fr';
    }
    if(sexo === 'mujer'){
      if(altura > 160) return '37 Fr';
      if(altura >= 150) return '35 Fr';
      return '32–35 Fr';
    }
    return null;
  }

  function recomendarPorDiametro(d){
    if(!d || d <= 0) return null;
    if(d >= 12) return '41 Fr';
    if(d >= 11.5) return '39 Fr';
    if(d >= 10.5) return '37 Fr';
    if(d >= 10) return '35 Fr';
    return '35 Fr o menor';
  }

  function renderActions(hasHeight, lado, diametro, mismatch){
    let items = [];

    if(!hasHeight){
      items = [
        ['mid','Completa talla','La recomendación inicial se basa en sexo y altura; el diámetro bronquial puede refinar la decisión si es confiable.']
      ];
    } else {
      items.push(['ok','Confirmar con fibrobroncoscopio','Verifica lumen traqueal y bronquial antes y después de posicionar en lateral.']);

      if(diametro && diametro > 0){
        items.push(['mid','Comparar talla versus bronquio','Si la recomendación por diámetro no coincide con talla, prioriza anatomía medida e integra marca disponible.']);
      }

      if(mismatch){
        items.unshift(['mid','Recomendaciones discordantes','La talla y el diámetro bronquial sugieren tamaños distintos. Revisa imagen, marca del TDL y tolerancia anatómica.']);
      }

      if(lado === 'derecho'){
        items.unshift(['high','TDL derecho requiere indicación','Evita ocluir bronquio lobar superior derecho. Usa fibrobroncoscopía estricta y revisa profundidad.']);
      } else {
        items.push(['ok','TDL izquierdo como estándar','Mayor margen anatómico hasta la primera emergencia lobar.']);
      }
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="note-warning-item">' +
        '<div class="note-warning-icon"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="note-warning-copy">' +
          '<div class="note-warning-title">' + item[1] + '</div>' +
          '<p class="note-warning-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateTDL(){
    const sexo = getSelected('sexo') || 'hombre';
    const lado = getSelected('lado') || 'izquierdo';
    const altura = parseLocal(document.getElementById('altura').value);
    const diametro = parseLocal(document.getElementById('diametro').value);

    const tallaSug = recomendarPorTalla(sexo, altura);
    const diamSug = recomendarPorDiametro(diametro);
    const finalSug = diamSug || tallaSug;
    const mismatch = Boolean(tallaSug && diamSug && tallaSug !== diamSug);

    setText('sumPatient', (sexo === 'hombre' ? 'Hombre' : 'Mujer') + ' · ' + (altura && altura > 0 ? fmt(altura,1) + ' cm' : '-'));
    setText('sumSide', lado === 'izquierdo' ? 'Izquierdo' : 'Derecho');
    setText('sumSizeHeight', tallaSug || '-');
    setText('sumSizeBronchus', diamSug || 'No ingresado');

    setText('sideMain', lado === 'izquierdo' ? 'Izquierdo' : 'Derecho');
    const sideCard = document.getElementById('sideCard');

    if(lado === 'izquierdo'){
      sideCard.className = 'note-result-card tdl-ok-card';
      setText('sideText', 'Elección habitual por mayor margen anatómico.');
      setText('planSide', 'TDL izquierdo como elección habitual.');
    } else {
      sideCard.className = 'note-result-card tdl-danger-card';
      setText('sideText', 'Usar solo con indicación anatómica o quirúrgica específica.');
      setText('planSide', 'TDL derecho solo si hay indicación; vigilar emergencia del lóbulo superior derecho.');
    }

    if(!tallaSug){
      setText('summaryNarrative', 'Ingresa altura para estimar tamaño inicial del TDL.');
      setText('resultadoNum', '-');
      setText('resultadoTexto', 'Ingresa altura para calcular.');
      setText('conductTitle', 'Pendiente');
      setText('conductText', 'Completa sexo y altura. Si además conoces el diámetro bronquial izquierdo, podrás ajustar mejor el tamaño del TDL.');
      document.getElementById('sizeCard').className = 'note-result-card';
      renderActions(false, lado, diametro, false);
      return;
    }

    setText('resultadoNum', finalSug);
    setText('resultadoTexto', diamSug ? 'Ajuste por diámetro bronquial. Por talla: ' + tallaSug + '.' : 'Recomendación inicial por sexo y talla.');
    setText('summaryNarrative', 'TDL ' + (lado === 'izquierdo' ? 'izquierdo' : 'derecho') + ', ' + (sexo === 'hombre' ? 'hombre' : 'mujer') + ', ' + fmt(altura,1) + ' cm. Tamaño sugerido: ' + finalSug + (diamSug ? ' por diámetro bronquial.' : ' por talla.'));

    const sizeCard = document.getElementById('sizeCard');
    if(mismatch){
      sizeCard.className = 'note-result-card tdl-mid-card';
      setText('conductTitle', 'Recomendación discordante');
      setText('conductText', 'El diámetro bronquial sugiere ' + diamSug + ', mientras la talla sugiere ' + tallaSug + '. Revisa medición, marca del TDL y anatomía antes de decidir.');
    } else if(lado === 'derecho'){
      sizeCard.className = 'note-result-card tdl-danger-card';
      setText('conductTitle', 'TDL derecho: usar con indicación');
      setText('conductText', 'El tamaño sugerido es ' + finalSug + ', pero el lado derecho exige indicación específica y confirmación broncoscópica estricta por riesgo de obstruir el bronquio lobar superior derecho.');
    } else {
      sizeCard.className = 'note-result-card tdl-ok-card';
      setText('conductTitle', 'Elección habitual');
      setText('conductText', 'TDL izquierdo ' + finalSug + ' como elección inicial razonable. Confirmar posición con fibrobroncoscopio y reevaluar tras lateralizar.');
    }

    renderActions(true, lado, diametro, mismatch);
  }

  document.getElementById('altura').addEventListener('input', updateTDL);
  document.getElementById('diametro').addEventListener('input', updateTDL);
  document.querySelectorAll('input[name="sexo"], input[name="lado"]').forEach(function(input){
    input.addEventListener('change', updateTDL);
  });

  updateTDL();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
