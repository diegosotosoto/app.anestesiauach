<?php
$titulo_pagina = "Ultrasonido gástrico";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para apoyar la evaluación ecográfica del contenido gástrico y estimar volumen antral. Integra calidad del contenido, área antral en decúbito lateral derecho, peso y edad para orientar riesgo de broncoaspiración.";
$formula = "Modelo pediátrico Spencer: volumen = -7,8 + 3,5 × área antral DLD + 0,127 × edad en meses. Modelo adulto Perlas: volumen = 27 + 14,6 × área antral DLD - 1,28 × edad en años. Si el cálculo entrega un valor negativo, se trunca a 0 mL. Referencia docente: volumen relativo >1,5 mL/kg orienta a mayor riesgo, especialmente con líquido claro.";
$referencias = array(
  "Perlas A, Chan VW, Lupu CM, Mitsakakis N, Hanbidge A. Ultrasound assessment of gastric content and volume. Anesthesiology. 2009.",
  "Perlas A, Mitsakakis N, Liu L, et al. Validation of a mathematical model for ultrasound assessment of gastric volume by gastroscopic examination. Anesth Analg. 2013.",
  "Spencer AO, Walker AM, Yeung AK, et al. Ultrasound assessment of gastric volume in the fasted pediatric patient undergoing upper gastrointestinal endoscopy. Paediatr Anaesth. 2015.",
  "Bouvet L, Mazoit JX, Chassard D, Allaouchiche B, Boselli E, Benhamou D. Clinical assessment of the ultrasonographic measurement of antral area for estimating preoperative gastric content and volume. Anesthesiology. 2011.",
  "Van de Putte P, Perlas A. Ultrasound assessment of gastric content and volume. Br J Anaesth. 2014."
);

include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=2">
<script src="js/clinical-note-system.js?v=2"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .gas-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .gas-choice-grid.gas-grid-4{
            grid-template-columns:repeat(4,minmax(0,1fr));
          }

          .gas-model-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.55rem;
          }

          .gas-model-option{
            min-height:58px;
            padding:.45rem .5rem;
            border-radius:.85rem;
          }

          .gas-model-option i{
            font-size:.85rem;
          }

          .gas-model-option .gas-option-title{
            font-size:.84rem;
          }

          .gas-model-option .gas-option-sub{
            font-size:.68rem;
          }

          .gas-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .gas-option{
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

          .gas-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .gas-option-input:checked + .gas-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .gas-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .gas-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .gas-content-vacio{background:#edf8f1;}
          .gas-content-liquido{background:#e6f4ff;}
          .gas-content-espeso{background:#fff9e8;}
          .gas-content-solido{background:#fff1f1;}

          .gas-visual-box{
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            background:#fff;
          }

          .gas-visual-box.is-low{
            background:var(--note-success-bg);
            border-color:var(--note-success-border);
          }

          .gas-visual-box.is-mid{
            background:#f2f8ff;
            border-color:#d4e6ff;
          }

          .gas-visual-box.is-warn{
            background:var(--note-warning-bg);
            border-color:var(--note-warning-border);
          }

          .gas-visual-box.is-danger{
            background:var(--note-danger-bg);
            border-color:var(--note-danger-border);
          }

          .gas-visual-grid{
            display:grid;
            grid-template-columns:.95fr 1.05fr;
            gap:1rem;
            align-items:start;
          }

          .gas-image-card{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            overflow:hidden;
          }

          .gas-image-card img{
            width:100%;
            display:block;
            object-fit:cover;
          }

          .gas-image-cap{
            padding:.65rem .75rem;
            font-size:.82rem;
            line-height:1.3;
            color:var(--note-muted);
            border-top:1px solid #eef2f6;
            background:#fff;
          }

          .gas-action-list{
            display:grid;
            gap:.75rem;
          }

          .gas-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .gas-action-mark{
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

          .gas-action-mark.ok{background:#2ea663;}
          .gas-action-mark.mid{background:#f4c542;}
          .gas-action-mark.high{background:#d92d20;}

          .gas-action-copy{min-width:0;flex:1;}

          .gas-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .gas-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .gas-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .gas-plan-line:last-child{
            margin-bottom:0;
          }

          .gas-ok-card{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .gas-mid-card{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .gas-danger-card{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          @media (max-width:768px){
            .gas-choice-grid,
            .gas-choice-grid.gas-grid-4,
            .gas-visual-grid{
              grid-template-columns:1fr;
            }

            .gas-model-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }
          .gas-content-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          @media (max-width:420px){
            .gas-content-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · POCUS · ASPIRACIÓN</div>
          <h2>Ultrasonido gástrico</h2>
          <div class="note-hero-subtitle">Estima contenido y volumen gástrico para orientar riesgo de broncoaspiración cuando el ayuno es incierto o clínicamente relevante.</div>
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
            <b>Técnica resumida:</b>
            <ul class="mb-0 mt-2">
              <li>Explorar epigastrio en eje longitudinal.</li>
              <li>Identificar hígado, antro gástrico, páncreas y aorta.</li>
              <li>Evaluar antro en decúbito supino y luego en decúbito lateral derecho.</li>
              <li>Usar transductor curvo en general; lineal puede ayudar en niños pequeños.</li>
            </ul>

            <hr>
            <b>Referencia visual de exploración:</b>
            <div class="gas-image-card mt-3">
              <img src="us_gastrico.jpeg" alt="Guía de posición del transductor y estructuras anatómicas">
              <div class="gas-image-cap">Posición del transductor y estructuras objetivo durante evaluación del antro gástrico.</div>
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
                <label class="note-label">Peso</label>
                <div class="note-input-inline">
                  <input id="peso" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Edad</label>
                <div class="note-input-inline mb-3">
                  <input id="edad" type="text" inputmode="decimal" class="note-input">
                  <div id="edadUnitText" class="note-input-unit">meses</div>
                </div>

                <div class="gas-choice-grid gas-model-grid">
                  <label>
                    <input class="gas-option-input" type="radio" name="edadunit" value="meses" checked>
                    <div class="gas-option gas-model-option">
                      <i class="fa-solid fa-child"></i>
                      <div class="gas-option-title">Pediátrico</div>
                      <div class="gas-option-sub">edad en meses · Spencer</div>
                    </div>
                  </label>
                  <label>
                    <input class="gas-option-input" type="radio" name="edadunit" value="anios">
                    <div class="gas-option gas-model-option">
                      <i class="fa-solid fa-user"></i>
                      <div class="gas-option-title">Adulto</div>
                      <div class="gas-option-sub">edad en años · Perlas</div>
                    </div>
                  </label>
                </div>

                <div id="modeloAutoTexto" class="note-result-secondary mt-2">
                  Se aplicará el modelo pediátrico de Spencer.
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Área antral en DLD</label>
                <div class="note-input-inline">
                  <input id="areaDLD" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">cm²</div>
                </div>
              </div>
            </div>

            <div class="note-section-label">Consistencia / aspecto del contenido</div>
              <div class="gas-choice-grid gas-content-grid">
              <label>
                <input class="gas-option-input" type="radio" name="contenido" value="vacio" checked>
                <div class="gas-option gas-content-vacio">
                  <i class="fa-regular fa-circle"></i>
                  <div class="gas-option-title">Vacío</div>
                  <div class="gas-option-sub">antro colapsado</div>
                </div>
              </label>
              <label>
                <input class="gas-option-input" type="radio" name="contenido" value="liquido">
                <div class="gas-option gas-content-liquido">
                  <i class="fa-solid fa-droplet"></i>
                  <div class="gas-option-title">Líquido claro</div>
                  <div class="gas-option-sub">anecoico</div>
                </div>
              </label>
              <label>
                <input class="gas-option-input" type="radio" name="contenido" value="espeso">
                <div class="gas-option gas-content-espeso">
                  <i class="fa-solid fa-cloud"></i>
                  <div class="gas-option-title">Espeso / mixto</div>
                  <div class="gas-option-sub">particulado</div>
                </div>
              </label>
              <label>
                <input class="gas-option-input" type="radio" name="contenido" value="solido">
                <div class="gas-option gas-content-solido">
                  <i class="fa-solid fa-cubes-stacked"></i>
                  <div class="gas-option-title">Sólido</div>
                  <div class="gas-option-sub">heterogéneo</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div id="contenidoVisualBox" class="gas-visual-box is-low mb-3">
          <div class="gas-visual-grid">
            <div>
              <div class="note-section-label">Referencia visual</div>
              <div id="visualTitulo" class="note-card-title">Estómago vacío</div>
              <div id="visualTexto" class="note-muted mb-3">
                Antro pequeño o colapsado, con paredes próximas y sin distensión evidente.
              </div>
              <div id="visualClinical" class="note-result-secondary">
                Si el antro está realmente vacío y no hay otros factores de riesgo, la lectura ecográfica orienta a bajo riesgo.
              </div>
            </div>
            <div class="gas-image-card">
              <img id="visualImg" src="estomago_vacio.jpg" alt="Referencia visual del contenido gástrico">
              <div id="visualCap" class="gas-image-cap">Referencia de antro vacío.</div>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso, edad y área antral para estimar volumen; la calidad del contenido siempre pesa en la decisión.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Peso / edad</div>
              <div id="summaryPatient" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Modelo aplicado</div>
              <div id="summaryModel" class="note-summary-v">Spencer</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Área DLD</div>
              <div id="summaryArea" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Contenido</div>
              <div id="summaryContent" class="note-summary-v">Vacío</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="volumeCard" class="note-result-card">
            <div class="note-result-card-label">Volumen estimado</div>
            <div id="volEstimado" class="note-result-card-value">-</div>
            <div id="formulaAplicada" class="note-result-card-note">Spencer: -7,8 + 3,5 × área DLD + 0,127 × edad.</div>
          </div>
          <div id="relativeCard" class="note-result-card">
            <div class="note-result-card-label">Volumen relativo</div>
            <div id="volRelativo" class="note-result-card-value">-</div>
            <div id="relativeNote" class="note-result-card-note">Referencia docente: &gt;1,5 mL/kg orienta a mayor riesgo.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Resultado principal</div>
          <div id="riesgoFinal" class="note-interpretation-main">Pendiente</div>
          <div id="riesgoTexto" class="note-interpretation-soft">Completa datos y clasifica contenido. La interpretación integra calidad del contenido + volumen relativo.</div>

          <div class="mt-3 text-start">
            <div class="gas-plan-line"><strong>Fórmula aplicada:</strong> <span id="formulaCorta">-</span></div>
            <div class="gas-plan-line"><strong>Lectura cualitativa:</strong> <span id="qualitativeText">Antro compatible con vacío.</span></div>
            <div class="gas-plan-line"><strong>Limitación:</strong> <span>Evitar usar el número aislado si el patrón parece sólido, espeso o la anatomía está alterada.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">El ultrasonido gástrico no reemplaza juicio clínico ni técnica competente. Es menos confiable con anatomía alterada: gastrectomía, bypass, banda gástrica, fundoplicatura o gran hernia hiatal.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="gas-action-list">
              <div class="gas-action-item">
                <div class="gas-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="gas-action-copy">
                  <div class="gas-action-title">Completa la evaluación</div>
                  <p class="gas-action-note">Primero define calidad del contenido; luego cuantifica el volumen si corresponde.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Primero calidad del contenido; después volumen</div>
          <div class="note-tips"><strong>Qué hacer:</strong> identificar antro, páncreas, hígado y aorta; evaluar supino y en DLD; integrar aspecto cualitativo y cálculo.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> tranquilizarse con un número bajo si el patrón parece sólido, espeso, heterogéneo o técnicamente dudoso.</div>
          <div class="note-tips"><strong>Umbral:</strong> &gt;1,5 mL/kg es una referencia docente de mayor riesgo, especialmente con líquido claro.</div>
          <div class="note-tips"><strong>Uso ideal:</strong> ayuno desconocido, no fiable, urgencia relativa o duda clínica que cambiará la estrategia anestésica.</div>
          <div class="note-tips"><strong>Limitación técnica:</strong> se requiere entrenamiento; se ha estimado una curva inicial de al menos varias decenas de exploraciones supervisadas.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si ves sólido o particulado, actúa como estómago lleno aunque la fórmula no parezca dramática.</div>
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
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function clampVol(num){
    if(!Number.isFinite(num)) return null;
    return num < 0 ? 0 : num;
  }

  function getContenidoLabel(val){
    const map = {
      vacio:'Vacío',
      liquido:'Líquido claro',
      espeso:'Espeso / mixto',
      solido:'Sólido'
    };
    return map[val] || '-';
  }

  function getContenidoVisual(val){
    const map = {
      vacio:{
        titulo:'Estómago vacío',
        texto:'Antro pequeño o colapsado, con paredes próximas y sin distensión evidente.',
        clinical:'Si el antro está realmente vacío y no hay otros factores de riesgo, la lectura ecográfica orienta a bajo riesgo.',
        img:'estomago_vacio.jpg',
        cap:'Referencia de antro vacío.',
        box:'gas-visual-box is-low'
      },
      liquido:{
        titulo:'Líquido claro',
        texto:'Contenido anecoico o hipoecoico, con distensión más uniforme del antro.',
        clinical:'El líquido claro requiere cuantificar volumen. Si supera 1,5 mL/kg, la preocupación por aspiración aumenta.',
        img:'liquido_claro.jpg',
        cap:'Referencia de líquido claro.',
        box:'gas-visual-box is-mid'
      },
      espeso:{
        titulo:'Contenido espeso / mixto',
        texto:'Material denso o particulado, con ecos internos y aspecto mixto.',
        clinical:'El material particulado pesa mucho en la decisión clínica, incluso si el volumen calculado no parece extremo.',
        img:'solido_fluido.jpg',
        cap:'Referencia de contenido espeso o mixto.',
        box:'gas-visual-box is-warn'
      },
      solido:{
        titulo:'Contenido sólido',
        texto:'Patrón heterogéneo, a veces con sombra acústica o aspecto tipo ground glass.',
        clinical:'Debe tratarse como alto riesgo práctico de aspiración.',
        img:'solido_reciente.jpg',
        cap:'Referencia de contenido sólido / sólido reciente.',
        box:'gas-visual-box is-danger'
      }
    };
    return map[val] || map.vacio;
  }

  function updateEdadUnitLabel(){
    const unidad = getSelected('edadunit') || 'meses';
    setText('edadUnitText', unidad === 'meses' ? 'meses' : 'años');
    setText('modeloAutoTexto', unidad === 'meses'
      ? 'Se aplicará el modelo pediátrico de Spencer.'
      : 'Se aplicará el modelo adulto de Perlas.'
    );
  }

  function updateVisualContent(contenido){
    const v = getContenidoVisual(contenido);
    const box = document.getElementById('contenidoVisualBox');
    box.className = v.box + ' mb-3';

    setText('visualTitulo', v.titulo);
    setText('visualTexto', v.texto);
    setText('visualClinical', v.clinical);
    document.getElementById('visualImg').src = v.img;
    setText('visualCap', v.cap);
  }

  function renderActions(riskLevel, contenido, relativo){
    const items = [];

    if(riskLevel === 'pending'){
      items.push(['mid','Completa la evaluación','Primero define calidad del contenido; luego cuantifica el volumen si corresponde.']);
    } else if(riskLevel === 'low'){
      items.push(['ok','Lectura ecográfica de bajo riesgo','Si el ayuno y el contexto clínico son concordantes, puede procederse con plan habitual.']);
      items.push(['ok','Mantener criterio clínico','Bajo riesgo ecográfico no anula otros riesgos: embarazo, obstrucción, urgencia, opioides, diabetes o gastroparesia.']);
    } else if(riskLevel === 'intermediate'){
      items.push(['mid','Riesgo intermedio','Integrar urgencia, ayuno, factores de gastroparesia y posibilidad de diferir o modificar técnica.']);
      items.push(['mid','Cuantificar líquido claro','El volumen relativo ayuda a decidir si tratar como mayor riesgo.']);
    } else {
      items.push(['high','Tratar como mayor riesgo de aspiración','Considerar estrategia de estómago lleno, diferir si corresponde o ajustar plan anestésico.']);
      items.push(['high','No dejarse tranquilizar por la fórmula','Con contenido sólido, espeso o particulado, la calidad manda sobre el número.']);
    }

    if(Number.isFinite(relativo) && relativo > 1.5){
      items.unshift(['high','Volumen relativo elevado','El volumen estimado supera 1,5 mL/kg, umbral docente de mayor riesgo.']);
    }

    if(contenido === 'solido'){
      items.unshift(['high','Sólido = alto riesgo práctico','Actúa como estómago lleno salvo razón clínica muy clara para no hacerlo.']);
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="gas-action-item">' +
        '<div class="gas-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="gas-action-copy">' +
          '<div class="gas-action-title">' + item[1] + '</div>' +
          '<p class="gas-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateGastricUS(){
    updateEdadUnitLabel();

    const peso = parseLocal(document.getElementById('peso').value);
    const edad = parseLocal(document.getElementById('edad').value);
    const area = parseLocal(document.getElementById('areaDLD').value);
    const unidadEdad = getSelected('edadunit') || 'meses';
    const contenido = getSelected('contenido') || 'vacio';
    const modelo = unidadEdad === 'meses' ? 'spencer' : 'perlas';

    updateVisualContent(contenido);

    setText('summaryPatient', (peso && peso > 0 ? fmt(peso,1) + ' kg' : '-') + ' / ' + (edad !== null && edad >= 0 ? fmt(edad,1) + ' ' + (unidadEdad === 'meses' ? 'meses' : 'años') : '-'));
    setText('summaryModel', modelo === 'spencer' ? 'Spencer' : 'Perlas');
    setText('summaryArea', area && area > 0 ? fmt(area,1) + ' cm²' : '-');
    setText('summaryContent', getContenidoLabel(contenido));

    let formulaTxt = modelo === 'spencer'
      ? 'Spencer: -7,8 + 3,5 × área DLD + 0,127 × edad.'
      : 'Perlas: 27 + 14,6 × área DLD - 1,28 × edad.';

    setText('formulaAplicada', formulaTxt);

    let volumen = null;
    let formulaShort = 'Completa edad y área DLD';

    if(edad !== null && edad >= 0 && area !== null && area > 0){
      if(modelo === 'spencer'){
        volumen = clampVol(-7.8 + (3.5 * area) + (0.127 * edad));
        formulaShort = '-7,8 + 3,5×' + fmt(area,1) + ' + 0,127×' + fmt(edad,1);
      } else {
        volumen = clampVol(27 + (14.6 * area) - (1.28 * edad));
        formulaShort = '27 + 14,6×' + fmt(area,1) + ' - 1,28×' + fmt(edad,1);
      }
    }

    setText('formulaCorta', formulaShort);
    setText('volEstimado', volumen !== null ? fmt(volumen,1) + ' mL' : '-');

    let relativo = null;
    if(volumen !== null && peso && peso > 0){
      relativo = volumen / peso;
      setText('volRelativo', fmt(relativo,2) + ' mL/kg');
    } else {
      setText('volRelativo', '-');
    }

    let riskLevel = 'pending';
    let riskMain = 'Pendiente';
    let riskText = 'Completa datos y clasifica contenido. La interpretación integra calidad del contenido + volumen relativo.';
    let cardClass = 'note-result-card';

    if(contenido === 'vacio'){
      riskLevel = 'low';
      riskMain = 'Bajo riesgo ecográfico';
      riskText = 'Antro compatible con vacío. Interpretar junto a ayuno, factores de gastroparesia y calidad técnica.';
      cardClass = 'note-result-card gas-ok-card';
    }

    if(contenido === 'liquido'){
      riskLevel = 'intermediate';
      riskMain = 'Riesgo intermedio';
      riskText = 'Líquido claro: cuantificar volumen relativo y leer en contexto clínico.';
      cardClass = 'note-result-card gas-mid-card';
    }

    if(contenido === 'espeso'){
      riskLevel = 'high';
      riskMain = 'Riesgo aumentado';
      riskText = 'Contenido espeso o particulado: la calidad del contenido pesa más que el volumen calculado.';
      cardClass = 'note-result-card gas-danger-card';
    }

    if(contenido === 'solido'){
      riskLevel = 'high';
      riskMain = 'Alto riesgo';
      riskText = 'Contenido sólido o heterogéneo: tratar como estómago lleno salvo contexto muy justificado.';
      cardClass = 'note-result-card gas-danger-card';
    }

    if(Number.isFinite(relativo) && relativo > 1.5 && (contenido === 'vacio' || contenido === 'liquido')){
      riskLevel = 'high';
      riskMain = 'Riesgo aumentado';
      riskText = 'Volumen relativo >1,5 mL/kg. En ayuno incierto o contexto de riesgo, tratar como mayor riesgo de aspiración.';
      cardClass = 'note-result-card gas-danger-card';
    }

    if(volumen === null && (contenido === 'vacio' || contenido === 'liquido')){
      riskLevel = contenido === 'vacio' ? 'low' : 'intermediate';
      riskText += ' Completar edad, área y peso mejora la cuantificación.';
    }

    setText('riesgoFinal', riskMain);
    setText('riesgoTexto', riskText);
    setText('qualitativeText', getContenidoVisual(contenido).clinical);

    document.getElementById('volumeCard').className = cardClass;
    document.getElementById('relativeCard').className = (Number.isFinite(relativo) && relativo > 1.5) ? 'note-result-card gas-danger-card' : 'note-result-card';

    setText('summaryNarrative',
      getContenidoLabel(contenido) + '. ' +
      (volumen !== null ? 'Volumen estimado ' + fmt(volumen,1) + ' mL' : 'Volumen no calculado') +
      (Number.isFinite(relativo) ? ' (' + fmt(relativo,2) + ' mL/kg)' : '') +
      '. Resultado: ' + riskMain + '.'
    );

    renderActions(riskLevel, contenido, relativo);
  }

  ['peso','edad','areaDLD'].forEach(function(id){
    document.getElementById(id).addEventListener('input', updateGastricUS);
  });

  document.querySelectorAll('input[name="edadunit"], input[name="contenido"]').forEach(function(input){
    input.addEventListener('change', updateGastricUS);
  });

  updateGastricUS();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php include("footer.php"); ?>
