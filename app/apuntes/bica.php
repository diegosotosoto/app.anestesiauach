<?php

$titulo_info = "Utilidad clínica";
$descripcion_info = "Esta herramienta estima el déficit de bicarbonato a partir del Base Excess y calcula volúmenes orientativos para soluciones de bicarbonato de sodio. Sirve para planificar una corrección parcial inicial y la reevaluación seriada, no como indicación automática de reposición completa.";
$formula = "Déficit (mEq) ≈ 0,3 × peso × |BE|. NaHCO₃ 8,4% = 1 mEq/ml. Solución 2/3 M ≈ 0,67 mEq/ml.";
$referencias = array(
  "Kraut JA, Madias NE. Treatment of acute metabolic acidosis: a pathophysiologic approach. Nat Rev Nephrol. 2012;8(10):589-601.",
  "Brown RM, Semler MW. Sodium bicarbonate for severe metabolic acidaemia. Lancet. 2019;393(10179):1414-1415.",
  "Sodium Bicarbonate. StatPearls. NCBI Bookshelf. Updated 2024.",
  "Ghauri SK, Javaeed A, Mustafa KJ, Khan AS. Bicarbonate Therapy for Critically Ill Patients with Metabolic Acidosis: A Systematic Review. Cureus. 2019;11(5):e4295."
);

$icono_apunte = "<i class='fa-solid fa-flask-vial pe-3 pt-2'></i>";
$titulo_apunte = "Corrección de bicarbonato";

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell">

        <style>
          .bica-reco-wrap{
            border:1px solid var(--note-line);
            border-radius:1.35rem;
            background:var(--note-soft);
            padding:1.2rem;
          }
          .bica-reco-title{
            text-align:center;
            font-size:.9rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#64748b;
            margin-bottom:.95rem;
          }
          .bica-reco-main{
            text-align:center;
            font-size:1.45rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin-bottom:1rem;
          }
          .bica-reco-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.9rem;
          }
          .bica-reco-card{
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:1rem;
            padding:1rem;
          }
          .bica-reco-label{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#667085;
            margin-bottom:.5rem;
          }
          .bica-reco-text{
            font-size:.96rem;
            line-height:1.42;
            color:var(--note-text);
            font-weight:600;
          }
          .bica-reco-soft{
            font-size:.9rem;
            line-height:1.45;
            color:var(--note-muted);
            font-weight:500;
          }
          .bica-reco-highlight{
            display:inline-block;
            margin-top:.55rem;
            padding:.5rem .85rem;
            border-radius:999px;
            background:#dfe7f6;
            color:#3559b7;
            font-weight:800;
            font-size:.95rem;
            line-height:1.2;
          }
          .bica-empty{opacity:.8;}
          @media (max-width:768px){
            .bica-reco-grid{grid-template-columns:1fr;}
            .bica-reco-main{font-size:1.2rem;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero">
          <div class="note-hero-kicker">APP CLÍNICA · ÁCIDO-BASE</div>
          <h2>Corrección de Bicarbonato</h2>
          <p class="note-hero-subtitle">Estimación rápida de déficit, volumen teórico y corrección inicial orientativa para acidosis metabólica con reevaluación seriada.</p>
        </div>

        <div class="info-box">
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
            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0 small-note">
                <?php foreach($referencias as $ref){ ?>
                  <li><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="note-card">
          <div class="note-card-body">
            <div class="note-section-label">Datos de entrada</div>
            <div class="note-grid">
              <div class="note-input-group">
                <label class="note-label" for="peso">Peso</label>
                <div class="note-input-inline">
                  <input class="note-input calc-trigger" type="text" id="peso" inputmode="decimal" placeholder="Ej: 18,5">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label" for="be">Base Excess</label>
                <div class="note-input-inline">
                  <input class="note-input calc-trigger" type="text" id="be" inputmode="decimal" placeholder="Ej: -12">
                  <div class="note-input-unit">mEq/L</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa peso y Base Excess para mostrar un resumen clínico rápido.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Peso usado</div>
                <div id="summaryPeso" class="note-result-card-value">No ingresado</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">BE usado</div>
                <div id="summaryBe" class="note-result-card-value">No ingresado</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Déficit estimado</div>
                <div id="summaryDeficit" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Corrección inicial</div>
                <div id="summaryInitial" class="note-result-card-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-formula-box mb-3">
          <div class="note-formula-label">Fórmula visual</div>
          <div class="note-formula-wrap">
            <div class="note-formula-left">Déficit de HCO₃⁻</div>
            <div class="note-formula-equals">=</div>
            <div class="note-formula-fraction">
              <div class="note-formula-num">0,3 × peso × |BE|</div>
              <div class="note-formula-line"></div>
              <div class="note-formula-den">mEq estimados de reposición total</div>
            </div>
          </div>
          <div class="note-formula-note">La corrección práctica suele iniciarse con una reposición parcial y reevaluación seriada, no con el 100% del déficit en forma ciega.</div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Déficit total estimado</div>
            <div id="deficitNum" class="note-result-card-value">-</div>
            <div id="deficitText" class="note-result-card-note">Ingresa peso y BE.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Corrección inicial sugerida</div>
            <div id="resultado4Card" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Objetivo inicial: 50% del déficit total.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">NaHCO₃ 8,4% al 100%</div>
            <div id="resultado2Card" class="note-result-card-value">-</div>
            <div class="note-result-card-note">1 mEq/ml. Reposición teórica completa.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">NaHCO₃ 2/3 M al 100%</div>
            <div id="resultado3Card" class="note-result-card-value">-</div>
            <div class="note-result-card-note">≈ 0,67 mEq/ml. Reposición teórica completa.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">NaHCO₃ 8,4% al 50%</div>
            <div id="resultado5Card" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Volumen orientativo para corrección parcial.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">NaHCO₃ 2/3 M al 50%</div>
            <div id="resultado6Card" class="note-result-card-value">-</div>
            <div class="note-result-card-note">Volumen orientativo para corrección parcial.</div>
          </div>
        </div>

        <div class="note-warning mb-3" id="validityWarning">
          <strong>Advertencia de seguridad:</strong>
          <span id="validityWarningText">Este cálculo es orientativo y debe integrarse con gasometría, causa de la acidosis, ventilación y hemodinamia.</span>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Interpretación y conducta</div>
            <div id="conductBox" class="conduct-box conduct-mid">
              <div id="conductTitle" class="note-card-title mb-2">Orientación inicial</div>
              <div id="conductText">Ingresa peso y Base Excess para mostrar una orientación de manejo basada en el déficit calculado.</div>
            </div>

            <div class="bica-reco-wrap mt-3">
              <div class="bica-reco-title">Principios y precauciones en pabellón</div>
              <div class="bica-reco-main">La corrección del bicarbonato debe ser parcial, contextual y reevaluable</div>
              <div class="bica-reco-grid">
                <div class="bica-reco-card">
                  <div class="bica-reco-label">Objetivo inicial</div>
                  <div class="bica-reco-text">Corregir aproximadamente el <strong>50% del déficit calculado</strong> y reevaluar con gases arteriales.</div>
                  <div class="bica-reco-highlight">Evitar la sobrecorrección rápida</div>
                </div>
                <div class="bica-reco-card">
                  <div class="bica-reco-label">Tratamiento de base</div>
                  <div class="bica-reco-text">Buscar y tratar el desencadenante.</div>
                  <div class="bica-reco-soft mt-2">Sepsis, hipoperfusión, cetoacidosis, deshidratación, falla renal, pérdidas gastrointestinales o fármacos.</div>
                </div>
                <div class="bica-reco-card">
                  <div class="bica-reco-label">Ventilación</div>
                  <div class="bica-reco-text">Ajustar la ventilación según el contexto clínico.</div>
                  <div class="bica-reco-soft mt-2">Considerar riesgo de polipnea compensadora, fatiga respiratoria y eventual falla de extubación si la compensación ventilatoria es crítica.</div>
                </div>
                <div class="bica-reco-card">
                  <div class="bica-reco-label">Uso de bicarbonato</div>
                  <div class="bica-reco-text">El bicarbonato <strong>no reemplaza</strong> el tratamiento etiológico.</div>
                  <div class="bica-reco-soft mt-2">Puede ser útil como medida de apoyo en acidosis metabólica significativa, pero siempre integrado al cuadro clínico completo.</div>
                </div>
                <div class="bica-reco-card">
                  <div class="bica-reco-label">Acceso venoso</div>
                  <div class="bica-reco-text">Preferir acceso venoso central cuando se anticipen formulaciones concentradas o infusiones relevantes.</div>
                  <div class="bica-reco-soft mt-2">Especialmente si se utiliza bicarbonato 2/3 M o si la osmolaridad/irritación vascular puede ser un problema.</div>
                </div>
                <div class="bica-reco-card">
                  <div class="bica-reco-label">Monitorización</div>
                  <div class="bica-reco-text">Recontrolar en forma seriada.</div>
                  <div class="bica-reco-soft mt-2">Gases arteriales, sodio, potasio, calcio ionizado, ventilación, hemodinamia y respuesta clínica tras cada intervención.</div>
                </div>
                <div class="bica-reco-card">
                  <div class="bica-reco-label">Perla docente</div>
                  <div class="bica-reco-soft">Un BE muy negativo no significa automáticamente “dar todo el bicarbonato”. En pabellón, lo importante es entender <strong>por qué</strong> el paciente está acidótico, cuánto está compensando respiratoriamente y cuánto margen real tiene para tolerar la corrección.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mb-3">
          <div class="note-teaching-title">Teaching tips</div>
          <div class="note-teaching-main">Qué hacer y qué evitar</div>
          <div class="note-tips"><strong>Qué hacer:</strong> corregir causa de base, optimizar ventilación y hemodinamia, y reevaluar después de una corrección parcial.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> usar el déficit total como orden automática de reposición completa o ignorar la compensación respiratoria.</div>
          <div class="note-tips"><strong>Error frecuente:</strong> tratar el número sin integrar acidemia, perfusión, potasio, calcio ionizado y contexto quirúrgico.</div>
        </div>

        <div class="footer-note">Herramienta orientativa. La terapia con bicarbonato no reemplaza la corrección de la causa ni la reevaluación gasométrica seriada.</div>

      </div>
    </div>
  </div>
</div>

<script src="js/clinical-note-system.js?v=20260416-2"></script>
<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  const pesoInput = document.getElementById('peso');
  const beInput = document.getElementById('be');

  function setText(id, value){ if(CNS) CNS.safeSetText(id, value); }

  function resetState(){
    setText('deficitNum', '-');
    setText('deficitText', 'Ingresa peso y BE.');
    setText('resultado2Card', '-');
    setText('resultado3Card', '-');
    setText('resultado4Card', '-');
    setText('resultado5Card', '-');
    setText('resultado6Card', '-');
    setText('summaryPeso', 'No ingresado');
    setText('summaryBe', 'No ingresado');
    setText('summaryDeficit', '-');
    setText('summaryInitial', '-');
    setText('summaryNarrative', 'Ingresa peso y Base Excess para mostrar un resumen clínico rápido.');
    setText('conductTitle', 'Orientación inicial');
    document.getElementById('conductText').textContent = 'Ingresa peso y Base Excess para mostrar una orientación de manejo basada en el déficit calculado.';
    const conductBox = document.getElementById('conductBox');
    conductBox.classList.remove('conduct-ok','conduct-mid','conduct-no');
    conductBox.classList.add('conduct-mid');
    if(CNS){
      CNS.showValidityWarning('validityWarning','validityWarningText','Este cálculo es orientativo y debe integrarse con gasometría, causa de la acidosis, ventilación y hemodinamia.');
    }
  }

  function calculate(){
    const peso = CNS ? CNS.parseDecimal(pesoInput.value) : parseFloat(pesoInput.value);
    const beRaw = CNS ? CNS.parseDecimal(beInput.value) : parseFloat(beInput.value);

    if(!Number.isFinite(peso) || !Number.isFinite(beRaw) || peso <= 0){
      resetState();
      return;
    }

    if(CNS){
      if(peso < 1 || peso > 300){
        CNS.showValidityWarning('validityWarning','validityWarningText','Peso fuera de rango razonable. Verifica el dato antes de interpretar el cálculo.');
      } else {
        CNS.showValidityWarning('validityWarning','validityWarningText','Este cálculo es orientativo y debe integrarse con gasometría, causa de la acidosis, ventilación y hemodinamia.');
      }
    }

    const beAbs = Math.abs(beRaw);
    const deficit = peso * beAbs * 0.3;
    const total84 = deficit;
    const total23M = deficit / 0.67;
    const mitad = deficit * 0.5;
    const mitad84 = total84 * 0.5;
    const mitad23M = total23M * 0.5;

    setText('deficitNum', (CNS ? CNS.formatNumber(deficit,1) : deficit.toFixed(1)) + ' mEq');
    setText('deficitText', 'Déficit total estimado de bicarbonato.');
    setText('resultado2Card', (CNS ? CNS.formatNumber(total84,1) : total84.toFixed(1)) + ' ml');
    setText('resultado3Card', (CNS ? CNS.formatNumber(total23M,0) : total23M.toFixed(0)) + ' ml');
    setText('resultado4Card', (CNS ? CNS.formatNumber(mitad,1) : mitad.toFixed(1)) + ' mEq');
    setText('resultado5Card', (CNS ? CNS.formatNumber(mitad84,1) : mitad84.toFixed(1)) + ' ml');
    setText('resultado6Card', (CNS ? CNS.formatNumber(mitad23M,0) : mitad23M.toFixed(0)) + ' ml');

    setText('summaryPeso', (CNS ? CNS.formatNumber(peso,1) : peso.toFixed(1)) + ' kg');
    setText('summaryBe', (CNS ? CNS.formatNumber(beRaw,1) : beRaw.toFixed(1)) + ' mEq/L');
    setText('summaryDeficit', (CNS ? CNS.formatNumber(deficit,1) : deficit.toFixed(1)) + ' mEq');
    setText('summaryInitial', (CNS ? CNS.formatNumber(mitad,1) : mitad.toFixed(1)) + ' mEq');
    setText('summaryNarrative', 'Paciente de ' + (CNS ? CNS.formatNumber(peso,1) : peso.toFixed(1)) + ' kg con BE ' + (CNS ? CNS.formatNumber(beRaw,1) : beRaw.toFixed(1)) + '. Se estima un déficit orientativo de ' + (CNS ? CNS.formatNumber(deficit,1) : deficit.toFixed(1)) + ' mEq y una corrección inicial sugerida de 50%.');

    const conductBox = document.getElementById('conductBox');
    const conductTitle = document.getElementById('conductTitle');
    const conductText = document.getElementById('conductText');
    conductBox.classList.remove('conduct-ok','conduct-mid','conduct-no');

    if(beAbs < 8){
      conductBox.classList.add('conduct-ok');
      conductTitle.textContent = 'Déficit leve';
      conductText.innerHTML = 'Acidosis metabólica leve. En pabellón, priorizar tratamiento de la causa y optimización ventilatoria/hemodinámica. El bicarbonato no suele ser la primera medida si no hay acidemia severa ni contexto específico que lo justifique.';
    } else if(beAbs < 15){
      conductBox.classList.add('conduct-mid');
      conductTitle.textContent = 'Déficit moderado';
      conductText.innerHTML = 'Considerar corrección parcial inicial, habitualmente <strong>50% del déficit calculado</strong>, con reevaluación seriada. Ajustar ventilación según contexto, evitar sobrecorrección y revisar causas reversibles como hipoperfusión, sepsis, cetoacidosis o pérdidas digestivas.';
    } else {
      conductBox.classList.add('conduct-no');
      conductTitle.textContent = 'Déficit importante';
      conductText.innerHTML = 'Acidosis metabólica significativa. Corregir causa de base en forma agresiva, vigilar compensación respiratoria y riesgo de polipnea/falla de extubación. Si se decide usar bicarbonato, preferir <strong>corrección inicial parcial</strong> con controles estrechos; considerar acceso venoso central si se usarán formulaciones concentradas o volúmenes/osmolaridad relevantes.';
    }
  }

  document.addEventListener('DOMContentLoaded', function(){
    [pesoInput, beInput].forEach(function(el){
      el.addEventListener('input', calculate);
      el.addEventListener('change', calculate);
    });
    calculate();
  });
})();
</script>

<?php require("../footer.php"); ?>
