<?php
$titulo_pagina = "Regional pediátrica";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para estimar volumen orientativo y carga total de anestésico local en bloqueos regionales pediátricos. Prioriza masa total, concentración, edad/fisiología, sitio anatómico, lateralidad y margen respecto al máximo teórico.";
$formula = "Volumen orientativo = peso × rango mL/kg del bloqueo × número de lados. Masa total = volumen × concentración en mg/mL. Máximo teórico: bupivacaína/levobupivacaína 2,5 mg/kg; ropivacaína 3 mg/kg. En pediatría la masa total y la fisiología pesan más que la tabla de volumen.";
$referencias = array(
  "Lönnqvist PA, Ecoffey C, Bosenberg A, et al. The European society of regional anaesthesia and pain therapy and the American society of regional anesthesia and pain medicine joint committee practice advisory on controversial topics in pediatric regional anesthesia.",
  "NYSORA. Pediatric Regional Anesthesia.",
  "Bosenberg A. Pediatric regional anesthesia update. Paediatr Anaesth.",
  "Suresh S, Ecoffey C, Bosenberg A, et al. The European Society of Regional Anaesthesia and Pain Therapy / American Society of Regional Anesthesia practice advisory on pediatric regional anesthesia.",
  "Documentos docentes locales de anestesia regional pediátrica."
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
          .reg-choice-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .reg-choice-grid.reg-grid-2{
            grid-template-columns:repeat(2,minmax(0,1fr));
          }

          .reg-choice-grid.reg-grid-4{
            grid-template-columns:repeat(4,minmax(0,1fr));
          }

          .reg-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .reg-option{
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

          .reg-option i{
            color:#3559b7;
            font-size:1rem;
          }


          .reg-cat-head{background:#f2efff;}
          .reg-cat-braquial{background:#e8f7f2;}
          .reg-cat-abdomen{background:#fff8db;}
          .reg-cat-miembro{background:#e6f4ff;}

          .reg-block-option{
            border-color:rgba(31,42,55,.10);
          }

          .reg-block-option .reg-option-title,
          .reg-block-option .reg-option-sub{
            color:#1f2a37;
          }

          .reg-option-input:checked + .reg-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .reg-option-input:disabled + .reg-option{
            opacity:.45;
            pointer-events:none;
          }

          .reg-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .reg-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .reg-drug-chip{
            display:inline-block;
            padding:.22rem .48rem;
            border-radius:.6rem;
            font-weight:800;
            border:1px solid rgba(31,42,55,.12);
            line-height:1.1;
            color:#111827;
            background:var(--drug-local);
          }

          .reg-block-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .reg-action-list{
            display:grid;
            gap:.75rem;
          }

          .reg-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .reg-action-mark{
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

          .reg-action-mark.ok{background:#2ea663;}
          .reg-action-mark.mid{background:#f4c542;}
          .reg-action-mark.high{background:#d92d20;}

          .reg-action-copy{min-width:0;flex:1;}

          .reg-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .reg-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .reg-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .reg-plan-line:last-child{margin-bottom:0;}

          .reg-ok-card{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .reg-mid-card{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .reg-danger-card{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          @media (max-width:992px){
            .reg-choice-grid.reg-grid-4,
            .reg-block-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
          }

          @media (max-width:420px){
            .reg-choice-grid,
            .reg-choice-grid.reg-grid-2,
            .reg-choice-grid.reg-grid-4,
            .reg-block-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ANESTESIA REGIONAL · PEDIATRÍA</div>
          <h2>Regional pediátrica</h2>
          <div class="note-hero-subtitle">Calcula volumen orientativo y masa total de anestésico local según bloqueo, concentración, lateralidad y fisiología pediátrica.</div>
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
            <div class="note-section-label">Datos del paciente y anestésico local</div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Peso</label>
                <div class="note-input-inline">
                  <input id="peso" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Idea central</label>
                <div class="note-result-secondary">
                  Primero decide <strong>masa total segura</strong>. Luego juzga volumen y concentración para el bloqueo elegido.
                </div>
              </div>
            </div>

            <div class="note-section-label">Edad / fisiología</div>
            <div class="reg-choice-grid reg-grid-4 mb-3">
              <label>
                <input class="reg-option-input" type="radio" name="edadgrp" value="rn">
                <div class="reg-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="reg-option-title">RN</div>
                  <div class="reg-option-sub">más inmaduro</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="edadgrp" value="lt6m" checked>
                <div class="reg-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="reg-option-title">&lt;6 meses</div>
                  <div class="reg-option-sub">alto riesgo LAST</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="edadgrp" value="6m1a">
                <div class="reg-option">
                  <i class="fa-solid fa-baby-carriage"></i>
                  <div class="reg-option-title">6–12 meses</div>
                  <div class="reg-option-sub">intermedio</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="edadgrp" value="gt1a">
                <div class="reg-option">
                  <i class="fa-solid fa-child"></i>
                  <div class="reg-option-title">&gt;1 año</div>
                  <div class="reg-option-sub">más estable</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Anestésico local</div>
            <div class="reg-choice-grid mb-3">
              <label>
                <input class="reg-option-input" type="radio" name="droga" value="bupi" checked>
                <div class="reg-option drug-local">
                  <div class="reg-option-title">Bupivacaína</div>
                  <div class="reg-option-sub">máx 2,5 mg/kg</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="droga" value="levo">
                <div class="reg-option drug-local">
                  <div class="reg-option-title">Levobupivacaína</div>
                  <div class="reg-option-sub">máx 2,5 mg/kg</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="droga" value="ropi">
                <div class="reg-option drug-local">
                  <div class="reg-option-title">Ropivacaína</div>
                  <div class="reg-option-sub">máx 3 mg/kg</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Concentración</div>
            <div class="reg-choice-grid">
              <label>
                <input class="reg-option-input" type="radio" name="conc" value="1.25">
                <div class="reg-option drug-local">
                  <div class="reg-option-title">0,125%</div>
                  <div class="reg-option-sub">1,25 mg/mL</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="conc" value="2">
                <div class="reg-option drug-local">
                  <div class="reg-option-title">0,2%</div>
                  <div class="reg-option-sub">2 mg/mL</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="conc" value="2.5" checked>
                <div class="reg-option drug-local">
                  <div class="reg-option-title">0,25%</div>
                  <div class="reg-option-sub">2,5 mg/mL</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Selección del bloqueo</div>

            <div class="reg-choice-grid reg-grid-4 mb-3">
              <label>
                <input class="reg-option-input" type="radio" name="grupo" value="cabeza" checked>
                <div class="reg-option reg-cat-head">
                  <i class="fa-solid fa-head-side-mask"></i>
                  <div class="reg-option-title">Cabeza / cuello</div>
                  <div class="reg-option-sub">superficiales</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="grupo" value="braquial">
                <div class="reg-option reg-cat-braquial">
                  <i class="fa-solid fa-hand"></i>
                  <div class="reg-option-title">Plexo braquial</div>
                  <div class="reg-option-sub">miembro superior</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="grupo" value="abdomen">
                <div class="reg-option reg-cat-abdomen">
                  <i class="fa-solid fa-bandage"></i>
                  <div class="reg-option-title">Abdomen / ingle</div>
                  <div class="reg-option-sub">planos fasciales</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="grupo" value="miembro">
                <div class="reg-option reg-cat-miembro">
                  <i class="fa-solid fa-shoe-prints"></i>
                  <div class="reg-option-title">Miembro inferior</div>
                  <div class="reg-option-sub">periféricos</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Bloqueo específico</div>
            <div id="bloqueoWrap" class="reg-block-grid mb-3"></div>

            <div class="note-section-label">Lateralidad</div>
            <div class="reg-choice-grid reg-grid-2">
              <label>
                <input class="reg-option-input" type="radio" name="lado" id="lado_uni" value="1" checked>
                <div class="reg-option">
                  <div class="reg-option-title">Unilateral</div>
                  <div class="reg-option-sub">1 lado</div>
                </div>
              </label>
              <label>
                <input class="reg-option-input" type="radio" name="lado" id="lado_bi" value="2">
                <div class="reg-option">
                  <div class="reg-option-title">Bilateral</div>
                  <div class="reg-option-sub">2 lados</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso y selecciona bloqueo para estimar volumen y masa total.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Peso / edad</div>
              <div id="sumPatient" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Droga / concentración</div>
              <div id="sumDrug" class="note-summary-v">Bupivacaína 0,25%</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Bloqueo</div>
              <div id="sumBlock" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Lateralidad</div>
              <div id="sumSide" class="note-summary-v">Unilateral</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="volumeCard" class="note-result-card">
            <div class="note-result-card-label">Volumen orientativo</div>
            <div id="mainVolume" class="note-result-card-value">-</div>
            <div id="volumeNote" class="note-result-card-note">Según bloqueo, peso y lateralidad.</div>
          </div>
          <div id="massCard" class="note-result-card">
            <div class="note-result-card-label">Masa total administrada</div>
            <div id="mainMass" class="note-result-card-value">-</div>
            <div id="massNote" class="note-result-card-note">Este es el dato de seguridad más importante.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Lectura clínica</div>
          <div id="riskTitle" class="note-interpretation-main">Pendiente</div>
          <div id="riskText" class="note-interpretation-soft">Completa peso, droga, concentración y bloqueo para estimar carga total y margen de seguridad.</div>

          <div class="mt-3 text-start">
            <div class="reg-plan-line"><strong>Límite máximo teórico:</strong> <span id="outMax">-</span></div>
            <div class="reg-plan-line"><strong>Relación con el máximo:</strong> <span id="outPct">-</span></div>
            <div class="reg-plan-line"><strong>Comentario del bloqueo:</strong> <span id="blockInfoText">-</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">La tabla de volumen no manda sola. El límite de seguridad real depende de masa total, concentración, edad, sitio de inyección, aspiración, fraccionamiento, suma de infiltraciones y fisiología del paciente.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="reg-action-list">
              <div class="reg-action-item">
                <div class="reg-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="reg-action-copy">
                  <div class="reg-action-title">Completa datos de entrada</div>
                  <p class="reg-action-note">El cálculo solo es útil si revisas masa total y contexto fisiológico, no solo volumen.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">En pediatría, el volumen orienta la cobertura; la masa total define el margen de seguridad</div>
          <div class="note-tips"><strong>Qué hacer:</strong> calcula mL, pero decide mirando mg totales, mg/kg, concentración, edad y suma de todos los anestésicos locales.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> perseguir el extremo alto del rango solo porque la tabla lo permite, especialmente en RN y lactantes.</div>
          <div class="note-tips"><strong>Menores de 6 meses:</strong> sé más conservador aunque el cálculo “quepa” dentro del máximo teórico.</div>
          <div class="note-tips"><strong>Planos fasciales:</strong> el volumen importa para cobertura; aun así, no puede separarse de la masa total administrada.</div>
          <div class="note-tips"><strong>Plexo braquial proximal:</strong> interescalénico y supraclavicular no deben plantearse bilateralmente por riesgo respiratorio.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si haces más de un bloqueo o el cirujano infiltra, suma toda la droga antes de celebrar que cada técnica “por separado” estaba dentro de rango.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

  const BLOCKS = {
    cabeza: [
      {id:'supra', name:'Supraorbitario / Supratroclear', volMin:1.0, volMax:2.0, unit:'mL/kg', info:'Bloqueo superficial para cuero cabelludo frontal. La masa total sigue siendo más importante que perseguir el extremo alto del rango.'},
      {id:'infra', name:'Infraorbitario', volMin:0.5, volMax:1.0, volMaxChild:2.0, unit:'mL/kg', info:'En lactantes suele requerir menos volumen que en niños mayores. Vigilar lesiones labiales o mordedura al despertar.'},
      {id:'cervical', name:'Plexo cervical superficial', volMin:1.0, volMax:3.0, unit:'mL/kg', info:'Mantener técnica superficial. Evitar profundizar innecesariamente.'}
    ],
    braquial: [
      {id:'inter', name:'Interescalénico', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Bloqueo proximal del plexo braquial. Alto riesgo de bloqueo frénico ipsilateral; no plantear bilateral.'},
      {id:'supra', name:'Supraclavicular', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Útil para extremidad superior, pero puede comprometer el hemidiafragma. No plantear bilateral.'},
      {id:'infra', name:'Infraclavicular', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Más distal y más phrenic-sparing que interescalénico/supraclavicular, aunque existen reportes aislados de compromiso frénico.'},
      {id:'axilar', name:'Axilar', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Adecuado para cirugía distal de miembro superior. Sin impacto clínico esperado sobre diafragma.'}
    ],
    abdomen: [
      {id:'tap', name:'TAP', volMin:0.3, volMax:0.5, unit:'mL/kg por lado', fascial:true, info:'Plano fascial clásico. El volumen pesa más que en un perineural puro, pero la masa total sigue limitando.'},
      {id:'subtap', name:'Subcostal TAP', volMin:0.3, volMax:0.5, unit:'mL/kg por lado', fascial:true, info:'Útil para abdomen superior. Buena cobertura requiere volumen, sin olvidar la masa total.'},
      {id:'rectus', name:'Rectus sheath', volMin:0.2, volMax:0.3, unit:'mL/kg por lado', fascial:true, info:'Frecuentemente bilateral. No cubre dolor visceral.'},
      {id:'ilio', name:'Ilioinguinal / Iliohipogástrico', volMin:0.2, volMax:0.3, unit:'mL/kg', info:'Muy frecuente en cirugía inguinal. Cuenta en la carga total si se combina con infiltración quirúrgica.'},
      {id:'pene', name:'Bloqueo peneano', volMin:0.1, volMax:0.1, unit:'mL/kg por lado', info:'Frecuente y útil. Aun con poco volumen, la concentración importa si se suma a otras infiltraciones.'},
      {id:'esp', name:'ESP', volMin:0.3, volMax:0.5, unit:'mL/kg por lado', fascial:true, info:'Bloqueo interfascial moderno. Aquí el volumen vuelve a ser especialmente relevante.'}
    ],
    miembro: [
      {id:'fem', name:'Femoral', volMin:0.2, volMax:0.4, unit:'mL/kg', info:'Útil en fractura femoral. Valorar si se necesita complemento analgésico adicional.'},
      {id:'sciprox', name:'Ciático proximal', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Bloqueo de volumen moderado; sumar masa si se combina con femoral o safeno.'},
      {id:'scipop', name:'Ciático poplíteo', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Frecuente en cirugía distal de EEII. El volumen no debe ocultar la masa total.'}
    ]
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
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? selected.value : null;
  }

  function drugData(){
    const drug = getSelected('droga') || 'bupi';
    if(drug === 'ropi') return {name:'Ropivacaína', maxMgKg:3.0};
    if(drug === 'levo') return {name:'Levobupivacaína', maxMgKg:2.5};
    return {name:'Bupivacaína', maxMgKg:2.5};
  }

  function ageText(age){
    if(age === 'rn') return 'RN';
    if(age === 'lt6m') return '<6 meses';
    if(age === '6m1a') return '6–12 meses';
    return '>1 año';
  }

  function getCurrentBlock(){
    const grupo = getSelected('grupo') || 'cabeza';
    const selected = getSelected('bloqueo');
    return (BLOCKS[grupo] || BLOCKS.cabeza).find(function(b){ return b.id === selected; }) || (BLOCKS[grupo] || BLOCKS.cabeza)[0];
  }

  function renderBlockButtons(){
    const grupo = getSelected('grupo') || 'cabeza';
    const wrap = document.getElementById('bloqueoWrap');
    const blocks = BLOCKS[grupo] || BLOCKS.cabeza;
    const groupClass = {
      cabeza:'reg-cat-head',
      braquial:'reg-cat-braquial',
      abdomen:'reg-cat-abdomen',
      miembro:'reg-cat-miembro'
    }[grupo] || 'reg-cat-head';

    wrap.innerHTML = blocks.map(function(b, idx){
      const id = 'bloq_' + grupo + '_' + b.id;
      return '<label>' +
        '<input class="reg-option-input bloqueo-radio" type="radio" name="bloqueo" id="' + id + '" value="' + b.id + '"' + (idx === 0 ? ' checked' : '') + '>' +
        '<div class="reg-option reg-block-option ' + groupClass + '">' +
          '<div class="reg-option-title">' + b.name + '</div>' +
          '<div class="reg-option-sub">' + b.unit + '</div>' +
        '</div>' +
      '</label>';
    }).join('');

    document.querySelectorAll('.bloqueo-radio').forEach(function(input){
      input.addEventListener('change', updateRegionalPed);
    });
  }

  function enforceSideRestrictions(block){
    const ladoUni = document.getElementById('lado_uni');
    const ladoBi = document.getElementById('lado_bi');

    ladoBi.disabled = false;

    if(block && (block.id === 'inter' || block.id === 'supra') && getSelected('grupo') === 'braquial'){
      ladoBi.checked = false;
      ladoUni.checked = true;
      ladoBi.disabled = true;
    }
  }

  function renderActions(level, block, pctMax, age){
    const items = [];

    if(level === 'pending'){
      items.push(['mid','Completa datos de entrada','El cálculo solo es útil si revisas masa total y contexto fisiológico, no solo volumen.']);
    } else {
      if(age === 'rn' || age === 'lt6m'){
        items.push(['high','Fisiología vulnerable','En RN y <6 meses, usa margen más conservador aunque el cálculo no supere el máximo teórico.']);
      }

      if(pctMax >= 80){
        items.push(['high','Carga cercana al máximo','Considera bajar volumen, bajar concentración, elegir ropivacaína si aplica o replantear la estrategia.']);
      } else if(pctMax >= 60){
        items.push(['mid','Carga intermedia','Revisa si realmente necesitas el extremo alto del rango; suma cualquier infiltración quirúrgica.']);
      } else {
        items.push(['ok','Margen matemático cómodo','Aun así, aspirar, fraccionar, observar distribución ecográfica y sumar todas las dosis.']);
      }

      if(block && block.fascial){
        items.push(['mid','Plano fascial','El volumen importa para cobertura, pero no debe llevarte a exceder masa total segura.']);
      }

      if(block && getSelected('grupo') === 'braquial' && (block.id === 'inter' || block.id === 'supra')){
        items.unshift(['high','No bilateral','Bloqueo proximal con riesgo respiratorio por compromiso frénico. En esta nota se fuerza unilateral.']);
      }

      if(block && getSelected('grupo') === 'braquial' && block.id === 'infra'){
        items.push(['mid','Infraclavicular más distal','Más phrenic-sparing que interescalénico/supraclavicular, pero no implica riesgo cero.']);
      }
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="reg-action-item">' +
        '<div class="reg-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="reg-action-copy">' +
          '<div class="reg-action-title">' + item[1] + '</div>' +
          '<p class="reg-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateRegionalPed(){
    const peso = parseLocal(document.getElementById('peso').value);
    const age = getSelected('edadgrp') || 'lt6m';
    const conc = parseLocal(getSelected('conc') || '2.5');
    const drug = drugData();
    const block = getCurrentBlock();

    enforceSideRestrictions(block);

    const lado = parseLocal(getSelected('lado') || '1') || 1;
    const concPct = conc / 10;

    setText('sumPatient', peso && peso > 0 ? fmt(peso,1) + ' kg · ' + ageText(age) : ageText(age));
    setText('sumDrug', drug.name + ' ' + fmt(concPct,3) + '%');
    setText('sumBlock', block ? block.name : '-');
    setText('sumSide', lado === 2 ? 'Bilateral' : 'Unilateral');

    if(!peso || peso <= 0 || !block){
      setText('summaryNarrative', 'Ingresa peso y selecciona bloqueo para estimar volumen y masa total.');
      setText('mainVolume', '-');
      setText('mainMass', '-');
      setText('outMax', '-');
      setText('outPct', '-');
      setText('blockInfoText', block ? block.info : '-');
      setText('riskTitle', 'Pendiente');
      setText('riskText', 'Completa peso, droga, concentración y bloqueo para estimar carga total y margen de seguridad.');
      document.getElementById('volumeCard').className = 'note-result-card';
      document.getElementById('massCard').className = 'note-result-card';
      renderActions('pending', block, null, age);
      return;
    }

    let vMin = peso * block.volMin * lado;
    let vMax = peso * ((block.volMaxChild && age === 'gt1a') ? block.volMaxChild : block.volMax) * lado;

    const mgMin = vMin * conc;
    const mgMax = vMax * conc;
    const maxAllowed = peso * drug.maxMgKg;
    const pctMin = (mgMin / maxAllowed) * 100;
    const pctMax = (mgMax / maxAllowed) * 100;

    setText('summaryNarrative', ageText(age) + ', ' + fmt(peso,1) + ' kg, ' + drug.name + ' ' + fmt(concPct,3) + '%, ' + block.name + ' ' + (lado === 2 ? 'bilateral' : 'unilateral') + '. Volumen ' + fmt(vMin,1) + '–' + fmt(vMax,1) + ' mL; masa ' + fmt(mgMin,1) + '–' + fmt(mgMax,1) + ' mg.');
    setText('mainVolume', fmt(vMin,1) + '–' + fmt(vMax,1) + ' mL');
    setText('volumeNote', block.unit + ' · ' + (lado === 2 ? 'bilateral' : 'unilateral'));
    setText('mainMass', fmt(mgMin,1) + '–' + fmt(mgMax,1) + ' mg');
    setText('massNote', fmt(pctMin,0) + '–' + fmt(pctMax,0) + '% del máximo teórico.');
    setText('outMax', fmt(maxAllowed,1) + ' mg (' + fmt(drug.maxMgKg,1) + ' mg/kg)');
    setText('outPct', fmt(pctMin,0) + '–' + fmt(pctMax,0) + '%');
    setText('blockInfoText', block.info);

    let riskTitle = 'Margen cómodo';
    let riskText = 'La masa calculada parece alejada del máximo teórico. La seguridad real depende de técnica, aspiración, fraccionamiento, suma de infiltraciones y fisiología.';
    let riskClass = 'note-result-card reg-ok-card';

    if(age === 'rn' || age === 'lt6m'){
      riskTitle = 'Paciente fisiológicamente vulnerable';
      riskText = 'Aunque no supere el máximo teórico, el margen fisiológico es menor. Conviene usar el extremo bajo del rango si la distribución ecográfica es adecuada.';
      riskClass = 'note-result-card reg-mid-card';
    }

    if(pctMax >= 80){
      riskTitle = 'Carga alta de anestésico local';
      riskText = 'El extremo superior se acerca al máximo teórico. Replantea volumen, concentración, lateralidad o técnica.';
      riskClass = 'note-result-card reg-danger-card';
    } else if(pctMax >= 60){
      riskTitle = 'Carga intermedia / prudencia';
      riskText = 'La masa total ocupa una fracción importante del máximo. Revisa si necesitas el extremo alto del rango.';
      riskClass = 'note-result-card reg-mid-card';
    }

    if(getSelected('grupo') === 'braquial' && block.id === 'inter'){
      riskTitle = 'Interescalénico: evitar bilateral';
      riskText = 'Riesgo frecuente de bloqueo frénico y hemiparesia diafragmática. Se fuerza unilateral por seguridad respiratoria.';
      riskClass = 'note-result-card reg-danger-card';
    }

    if(getSelected('grupo') === 'braquial' && block.id === 'supra'){
      riskTitle = 'Supraclavicular: evitar bilateral';
      riskText = 'Puede comprometer hemidiafragma. Se fuerza unilateral por seguridad respiratoria.';
      riskClass = 'note-result-card reg-danger-card';
    }

    setText('riskTitle', riskTitle);
    setText('riskText', riskText);
    document.getElementById('massCard').className = riskClass;
    document.getElementById('volumeCard').className = 'note-result-card';

    renderActions('ok', block, pctMax, age);
  }

  document.querySelectorAll('input[name="grupo"]').forEach(function(input){
    input.addEventListener('change', function(){
      renderBlockButtons();
      updateRegionalPed();
    });
  });

  document.querySelectorAll('input[name="edadgrp"], input[name="droga"], input[name="conc"], input[name="lado"]').forEach(function(input){
    input.addEventListener('change', updateRegionalPed);
  });

  document.getElementById('peso').addEventListener('input', updateRegionalPed);

  renderBlockButtons();
  updateRegionalPed();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
