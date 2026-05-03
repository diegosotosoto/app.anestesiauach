<?php
$titulo_pagina = "Hidratación pediátrica";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para estimar una estrategia inicial de fluidoterapia intraoperatoria pediátrica. Separa mantención basal y pérdidas por exposición quirúrgica, y agrega sugerencias docentes para fiebre, sangrado, diuresis y riesgo de hipoglicemia.";
$formula = "Mantención basal por Holliday-Segar / regla 4-2-1. La pérdida por exposición quirúrgica se presenta como una estimación docente en mL/kg/h según rango etáreo y magnitud quirúrgica.";
$referencias = array(
  "Holliday MA, Segar WE. The maintenance need for water in parenteral fluid therapy. Pediatrics. 1957.",
  "Concha Pinto M, Rattalino M. Fluidoterapia perioperatoria en niños. Rev Chil Anest. 2022.",
  "NICE Guideline NG29. Intravenous fluid therapy in children and young people in hospital.",
  "OpenAnesthesia. Perioperative Fluid Administration in Children."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .fluid-choice-grid{
            display:grid;
            grid-template-columns:repeat(5,minmax(0,1fr));
            gap:.75rem;
          }
          .fluid-choice-grid.fluid-exp-grid{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }
          .fluid-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
          .fluid-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:82px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.75rem .65rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.25rem;
          }
          .fluid-option i{
            color:#3559b7;
            font-size:1.05rem;
          }
          .fluid-option-input:checked + .fluid-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }
          .fluid-option-title{
            font-size:.92rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }
          .fluid-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .fluid-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }
          .fluid-plan-line:last-child{margin-bottom:0;}

          @media (max-width:992px){
            .fluid-choice-grid{grid-template-columns:repeat(3,minmax(0,1fr));}
          }
          @media (max-width:768px){
            .fluid-choice-grid,
            .fluid-choice-grid.fluid-exp-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
          }
          @media (max-width:420px){
            .fluid-choice-grid,
            .fluid-choice-grid.fluid-exp-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · PEDIATRÍA · FLUIDOTERAPIA</div>
          <h2>Reposición intraoperatoria pediátrica</h2>
          <div class="note-hero-subtitle">Calcula mantención basal, estima pérdidas por exposición quirúrgica y obtiene un aporte horario inicial orientativo.</div>
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
            <b>Fundamento docente:</b>
            <p class="mb-0 mt-2">La planificación perioperatoria debe considerar requerimientos basales y pérdidas derivadas de la cirugía. El ayuno habitual no se repone de rutina y el “tercer espacio” no debe usarse como indicación automática de volumen adicional.</p>
            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mb-0 mt-2">
                <?php foreach($referencias as $ref){ ?>
                  <li class="mb-2"><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Datos de entrada</div>

            <div class="note-input-group mb-3">
              <label class="note-label">Peso</label>
              <div class="note-input-inline">
                <input class="note-input" type="text" inputmode="decimal" id="peso">
                <div class="note-input-unit">kg</div>
              </div>
            </div>

            <div class="note-section-label">Rango etáreo</div>
            <div class="fluid-choice-grid mb-3">
              <label>
                <input class="fluid-option-input" type="radio" name="edadgrp" value="rn" checked>
                <div class="fluid-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="fluid-option-title">RN</div>
                </div>
              </label>
              <label>
                <input class="fluid-option-input" type="radio" name="edadgrp" value="1_4m">
                <div class="fluid-option">
                  <i class="fa-solid fa-baby"></i>
                  <div class="fluid-option-title">1–4 m</div>
                </div>
              </label>
              <label>
                <input class="fluid-option-input" type="radio" name="edadgrp" value="5_8m">
                <div class="fluid-option">
                  <i class="fa-solid fa-baby-carriage"></i>
                  <div class="fluid-option-title">5–8 m</div>
                </div>
              </label>
              <label>
                <input class="fluid-option-input" type="radio" name="edadgrp" value="9_12m">
                <div class="fluid-option">
                  <i class="fa-solid fa-child-reaching"></i>
                  <div class="fluid-option-title">9–12 m</div>
                </div>
              </label>
              <label>
                <input class="fluid-option-input" type="radio" name="edadgrp" value="gt1a">
                <div class="fluid-option">
                  <i class="fa-solid fa-child"></i>
                  <div class="fluid-option-title">&gt;1 año</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Exposición quirúrgica</div>
            <div class="fluid-choice-grid fluid-exp-grid">
              <label>
                <input class="fluid-option-input" type="radio" name="exposicion" value="minima" checked>
                <div class="fluid-option">
                  <div class="fluid-option-title">Mínima</div>
                  <div class="fluid-option-sub">Superficial, corta</div>
                </div>
              </label>
              <label>
                <input class="fluid-option-input" type="radio" name="exposicion" value="moderada">
                <div class="fluid-option">
                  <div class="fluid-option-title">Moderada</div>
                  <div class="fluid-option-sub">Abdominal simple / ORL mayor</div>
                </div>
              </label>
              <label>
                <input class="fluid-option-input" type="radio" name="exposicion" value="mayor">
                <div class="fluid-option">
                  <div class="fluid-option-title">Mayor</div>
                  <div class="fluid-option-sub">Tórax / laparotomía amplia</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa peso para calcular mantención basal, pérdida por exposición y aporte horario orientativo.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Peso</div>
                <div id="resPeso" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Rango etáreo</div>
                <div id="resEdad" class="note-result-card-value">RN</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Exposición</div>
                <div id="resExp" class="note-result-card-value">Mínima</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Riesgo glucosa</div>
                <div id="resGlucosa" class="note-result-card-value">Alto / valorar</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Mantención basal</div>
            <div id="mantBasal" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Regla de Holliday-Segar / 4-2-1.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Pérdida por exposición</div>
            <div id="perdExp" class="note-result-card-value">-</div>
            <div id="expNota" class="note-result-card-note">Estimación orientativa en mL/kg/h según edad y magnitud quirúrgica.</div>
          </div>
        </div>

        <div class="note-interpretation mb-3">
          <div class="note-interpretation-label">Resultado principal</div>
          <div id="aporteHoraBig" class="note-interpretation-main">-</div>
          <div id="aporteSoft" class="note-interpretation-soft">Mantención basal + exposición quirúrgica. Ajustar a respuesta clínica, pérdidas reales y protocolo institucional.</div>

          <div id="drugPlan" class="mt-3 text-start">
            <div class="fluid-plan-line"><strong>Fluido de mantención sugerido:</strong> <span id="fluidoMant">-</span></div>
            <div class="fluid-plan-line"><strong>Glucosa:</strong> <span id="glucosaNota">Ingresa un peso para emitir recomendación.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">La estimación es orientativa. Sangrado, fiebre, diuresis, inestabilidad hemodinámica, comorbilidad y laboratorio deben manejarse por separado.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Sugerencias de manejo</div>
            <div class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-temperature-high"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Pérdidas por fiebre</div>
                  <p class="note-warning-note">Como referencia práctica, considerar alrededor de 10% del mantenimiento por cada °C sobre 37. Reinterpretar según contexto y duración quirúrgica.</p>
                </div>
              </div>
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-droplet"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Pérdidas por sangrado</div>
                  <p class="note-warning-note">El sangrado se maneja por separado con plan específico de reposición según magnitud, velocidad, volemia estimada, Hb/Hto y condición clínica.</p>
                </div>
              </div>
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-filter"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Diuresis</div>
                  <p class="note-warning-note">No perseguir diuresis "bonita" con volumen automático. La antidiuresis puede ser respuesta fisiológica al trauma quirúrgico.</p>
                </div>
              </div>
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-cubes-stacked"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Glucosa e hipoglicemia</div>
                  <p class="note-warning-note">RN, prematuros, PEG, hijos de madre diabética, NPT, hipercatabolismo y falla hepática requieren mayor vigilancia y control de glicemia.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">La meta no es “dar volumen”, sino mantener homeostasis y perfusión evitando déficit y exceso</div>
          <div class="note-tips"><strong>Qué hacer:</strong> separa mantención, exposición quirúrgica, sangrado y pérdidas reales. Reevalúa con signos clínicos, monitorización y laboratorio.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> reponer ayuno de rutina, perseguir diuresis aislada con bolos automáticos o usar “tercer espacio” como indicación rígida.</div>
          <div class="note-tips"><strong>Perla:</strong> en cirugía simple y superficial, el aporte adicional puede ser mínimo; en cirugía intracavitaria o prolongada, el plan debe ser más activo.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> la fórmula inicia la conversación; el paciente y la cirugía la corrigen.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const pesoInput = document.getElementById('peso');

  function parseLocal(value){
    if(CNS && typeof CNS.parseDecimal === 'function') return CNS.parseDecimal(value);
    const n = Number(String(value || '').replace(',', '.'));
    return Number.isFinite(n) ? n : null;
  }

  function fmt(value, decimals){
    if(CNS && typeof CNS.formatNumber === 'function') return CNS.formatNumber(value, decimals);
    return Number(value).toLocaleString('es-CL', {maximumFractionDigits: decimals});
  }

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function round1(num){
    return Math.round(num * 10) / 10;
  }

  function maintenance421(weight){
    if(!weight || weight <= 0) return 0;
    if(weight <= 10) return weight * 4;
    if(weight <= 20) return 40 + (weight - 10) * 2;
    return 60 + (weight - 20);
  }

  function getAgeMeta(age){
    const map = {
      rn: {
        label:'RN',
        glucosaLabel:'Alto / valorar',
        glucosa:true,
        glucosaMsg:'RN: mayor riesgo de hipoglicemia. Considerar solución balanceada con glucosa y control seriado de glicemia.',
        exp:{ minima:0.5, moderada:2.0, mayor:4.0 }
      },
      '1_4m': {
        label:'1–4 m',
        glucosaLabel:'Valorar',
        glucosa:true,
        glucosaMsg:'1–4 meses: valorar glucosa según contexto, duración quirúrgica, ayuno y riesgo metabólico.',
        exp:{ minima:0.5, moderada:2.0, mayor:4.0 }
      },
      '5_8m': {
        label:'5–8 m',
        glucosaLabel:'Individualizar',
        glucosa:false,
        glucosaMsg:'5–8 meses: en general no obligatoria de rutina; considerar si hay riesgo metabólico o cirugía prolongada.',
        exp:{ minima:1.0, moderada:3.0, mayor:5.0 }
      },
      '9_12m': {
        label:'9–12 m',
        glucosaLabel:'Individualizar',
        glucosa:false,
        glucosaMsg:'9–12 meses: generalmente no obligatoria de rutina; individualizar según ayuno y contexto.',
        exp:{ minima:1.0, moderada:3.0, mayor:5.0 }
      },
      gt1a: {
        label:'>1 año',
        glucosaLabel:'Habitualmente no',
        glucosa:false,
        glucosaMsg:'>1 año: en la mayoría de las cirugías pediátricas no se requiere glucosa de rutina, salvo factores de riesgo o procedimientos prolongados.',
        exp:{ minima:1.0, moderada:4.0, mayor:6.0 }
      }
    };
    return map[age] || map.rn;
  }

  function getExpLabel(exp){
    if(exp === 'minima') return 'Mínima';
    if(exp === 'moderada') return 'Moderada';
    return 'Mayor';
  }

  function updateFluidPed(){
    const peso = parseLocal(pesoInput.value);
    const edad = getSelected('edadgrp') || 'rn';
    const exposicion = getSelected('exposicion') || 'minima';
    const edadMeta = getAgeMeta(edad);

    document.getElementById('resPeso').textContent = peso && peso > 0 ? fmt(peso,1) + ' kg' : '-';
    document.getElementById('resEdad').textContent = edadMeta.label;
    document.getElementById('resExp').textContent = getExpLabel(exposicion);
    document.getElementById('resGlucosa').textContent = edadMeta.glucosaLabel;

    if(!peso || peso <= 0){
      document.getElementById('summaryNarrative').textContent = 'Ingresa peso para calcular mantención basal, pérdida por exposición y aporte horario orientativo.';
      document.getElementById('mantBasal').textContent = '-';
      document.getElementById('perdExp').textContent = '-';
      document.getElementById('aporteHoraBig').textContent = '-';
      document.getElementById('aporteSoft').textContent = 'Mantención basal + exposición quirúrgica. Ajustar a respuesta clínica, pérdidas reales y protocolo institucional.';
      document.getElementById('expNota').textContent = 'Estimación orientativa en mL/kg/h según edad y magnitud quirúrgica.';
      document.getElementById('fluidoMant').textContent = '-';
      document.getElementById('glucosaNota').textContent = 'Ingresa un peso para emitir recomendación.';
      return;
    }

    const basal = maintenance421(peso);
    const expRate = edadMeta.exp[exposicion];
    const expMlHr = peso * expRate;
    const aporte = basal + expMlHr;

    document.getElementById('summaryNarrative').textContent =
      edadMeta.label + ', ' + fmt(peso,1) + ' kg, exposición ' + getExpLabel(exposicion).toLowerCase() + '. Aporte horario inicial orientativo: ' + fmt(round1(aporte),1) + ' mL/h.';

    document.getElementById('mantBasal').textContent = fmt(round1(basal),1) + ' mL/h';
    document.getElementById('perdExp').textContent = fmt(round1(expMlHr),1) + ' mL/h';
    document.getElementById('aporteHoraBig').textContent = fmt(round1(aporte),1) + ' mL/h';
    document.getElementById('aporteSoft').textContent = 'Aporte horario propuesto = mantención basal ' + fmt(round1(basal),1) + ' mL/h + exposición ' + fmt(round1(expMlHr),1) + ' mL/h.';
    document.getElementById('expNota').textContent = 'Estimación orientativa: ' + fmt(expRate,1) + ' mL/kg/h según edad y magnitud quirúrgica.';
    document.getElementById('fluidoMant').textContent = edadMeta.glucosa ? 'Balanceada + valorar glucosa' : 'Solución balanceada isotónica';
    document.getElementById('glucosaNota').textContent = edadMeta.glucosaMsg;
  }

  pesoInput.addEventListener('input', updateFluidPed);
  document.querySelectorAll('input[name="edadgrp"], input[name="exposicion"]').forEach(function(el){
    el.addEventListener('change', updateFluidPed);
  });

  updateFluidPed();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
