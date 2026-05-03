<?php
$titulo_pagina = "PIEB / PCEA";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para preparación y programación de analgesia epidural obstétrica en modalidad PIEB/PCEA. Calcula la receta de preparación para una solución de bupivacaína 0,0625% + fentanyl 2 mcg/mL y muestra parámetros habituales de programación.";
$formula = "Bupivacaína 0,0625% = 0,625 mg/mL. Si se usa bupivacaína 0,5% = 5 mg/mL, se requieren 0,125 mL por cada mL de volumen final. Fentanyl final deseado en mcg/mL requiere volumen final × concentración final deseada. En Chile, la presentación habitual es fentanyl 50 mcg/mL. Volumen a retirar del matraz = volumen de bupivacaína + volumen de fentanyl agregado.";
$referencias = array(
  "Wong CA. Patient-controlled epidural analgesia for labor. Anesth Analg. 2009.",
  "Chestnut DH. Chestnut's Obstetric Anesthesia: Principles and Practice.",
  "Wong CA, McCarthy RJ, Hewlett B. The effect of manipulation of the programmed intermittent bolus time interval and injection volume on total drug use for labor epidural analgesia. Anesth Analg. 2011.",
  "George RB, Allen TK, Habib AS. Intermittent epidural bolus compared with continuous epidural infusions for labor analgesia: a systematic review and meta-analysis. Anesth Analg. 2013.",
  "Documentos docentes locales de analgesia epidural obstétrica."
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
          .pieb-choice-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .pieb-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .pieb-option{
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

          .pieb-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .pieb-option-input:checked + .pieb-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .pieb-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .pieb-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .pieb-step-list{
            display:grid;
            gap:.75rem;
          }

          .pieb-step{
            display:flex;
            align-items:flex-start;
            gap:.7rem;
            border:1px solid var(--note-line);
            border-radius:1rem;
            background:#fff;
            padding:.78rem .85rem;
          }

          .pieb-step-num{
            flex:0 0 auto;
            width:32px;
            height:32px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            background:#3559b7;
            font-weight:800;
            margin-top:.05rem;
          }

          .pieb-step-title{
            font-size:.96rem;
            font-weight:800;
            line-height:1.2;
            color:var(--note-text);
            margin-bottom:.12rem;
          }

          .pieb-step-note{
            margin:0;
            font-size:.84rem;
            line-height:1.35;
            color:var(--note-muted);
          }

          .pieb-program-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .pieb-program-card{
            background:linear-gradient(180deg, var(--note-brand-soft) 0%, #f7faff 100%);
            border:1px solid var(--note-brand-soft-border);
            border-radius:1rem;
            padding:.9rem 1rem;
            text-align:center;
          }

          .pieb-program-label{
            font-size:.78rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#3559b7;
            font-weight:700;
            margin-bottom:.22rem;
          }

          .pieb-program-value{
            font-size:1.25rem;
            line-height:1.15;
            font-weight:900;
            color:var(--note-text);
          }

          .pieb-program-note{
            margin-top:.28rem;
            font-size:.84rem;
            line-height:1.3;
            color:var(--note-muted);
          }

          .pieb-action-list{
            display:grid;
            gap:.75rem;
          }

          .pieb-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .pieb-action-mark{
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

          .pieb-action-mark.ok{background:#2ea663;}
          .pieb-action-mark.mid{background:#f4c542;}
          .pieb-action-mark.high{background:#d92d20;}

          .pieb-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .pieb-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .mt-1{margin-top:.25rem;}

          .pieb-recipe-box{
            background:#edf8f7;
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          @media (max-width:768px){
            .pieb-choice-grid,
            .pieb-program-grid{
              grid-template-columns:1fr;
            }
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ANALGESIA OBSTÉTRICA · EPIDURAL</div>
          <h2>Preparación y programación PIEB / PCEA</h2>
          <div class="note-hero-subtitle">Calcula solución epidural obstétrica y revisa parámetros de programación.</div>
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
            <div class="note-section-label">Datos de preparación</div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Volumen final deseado</label>
                <div class="note-input-inline">
                  <input id="finalVolumeInput" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mL</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Fentanyl final deseado</label>
                <div class="note-input-inline">
                  <input id="fentanylConcentrationInput" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mcg/mL</div>
                </div>
              </div>
            </div>

            <div class="note-section-label">Fármacos a utilizar</div>
            <div class="note-summary-grid-2 mb-0">

                <div class="note-summary-v"><span class="drug-card drug-local"><span class="drug-label-content"><span class="drug-label-title">Bupi/Levobupivacaína 0,5%</span></span></span></div>
                <div class="note-summary-v"><span class="drug-card drug-opioid"><span class="drug-label-content"><span class="drug-label-title">Fentanyl 50 mcg/mL</span></span></span></div>

            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa volumen final y concentración final deseada de fentanyl.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Volumen final</div>
                <div id="summaryVolume" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Bupivacaína</div>
                <div id="summaryBupiConc" class="note-result-card-value">0,0625%</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Fentanyl</div>
                <div id="summaryFentConc" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Programación</div>
                <div id="summaryProgram" class="note-result-card-value">0 · 9/10 · 45/60</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Bupivacaína a agregar</div>
            <div id="bupiResult" class="note-result-card-value">-</div>
            <div id="bupiNote" class="note-result-card-note">Ingresa volumen final.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Fentanyl a agregar</div>
            <div id="fentResult" class="note-result-card-value">-</div>
            <div id="fentNote" class="note-result-card-note">Ingresa fentanyl final deseado.</div>
          </div>
        </div>

        <div class="note-interpretation mb-3">
          <div class="note-interpretation-label">Receta de preparación</div>
          <div id="mainRecipe" class="note-interpretation-main">Pendiente</div>
          <div id="mainSoft" class="note-interpretation-soft">Luego agregar bupivacaína + fentanyl para mantener el volumen final deseado.</div>

          <div class="pieb-recipe-box mt-3 text-start">
            <div class="pieb-step-list">
              <div class="pieb-step">
                <div class="pieb-step-num">1</div>
                <div>
                  <div class="pieb-step-title">Retirar volumen del matraz</div>
                  <p id="stepRemove" class="pieb-step-note">Dato incompleto.</p>
                </div>
              </div>
              <div class="pieb-step">
                <div class="pieb-step-num">2</div>
                <div>
                  <div class="pieb-step-title">Agregar anestésico local</div>
                  <p id="stepBupi" class="pieb-step-note">Dato incompleto.</p>
                </div>
              </div>
              <div class="pieb-step">
                <div class="pieb-step-num">3</div>
                <div>
                  <div class="pieb-step-title">Agregar opioide</div>
                  <p id="stepFent" class="pieb-step-note">Dato incompleto.</p>
                </div>
              </div>
              <div class="pieb-step">
                <div class="pieb-step-num">4</div>
                <div>
                  <div class="pieb-step-title">Rotular y registrar</div>
                  <p class="pieb-step-note">Rotular concentración final, fecha/hora, responsable y vía epidural.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Programación habitual PIEB / PCEA</div>
            <div class="pieb-program-grid">
              <div class="pieb-program-card">
                <div class="pieb-program-label">Infusión basal</div>
                <div class="pieb-program-value">0 mL/h</div>
                <div class="pieb-program-note">Sin infusión continua basal cuando se usa PIEB como base.</div>
              </div>
              <div class="pieb-program-card">
                <div class="pieb-program-label">PIEB</div>
                <div class="pieb-program-value">9–10 mL</div>
                <div class="pieb-program-note">Bolo programado cada <strong>45–60 min</strong>.</div>
              </div>
              <div class="pieb-program-card">
                <div class="pieb-program-label">PCEA</div>
                <div class="pieb-program-value">10 mL</div>
                <div class="pieb-program-note">Bolo a demanda con <strong>lockout 10 min</strong>.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">Verifica siempre concentración final, volumen total, rotulación, vía de administración y protocolo local. La receta es docente y debe ajustarse a presentación disponible y política institucional.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Lectura clínica</div>
            <div class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">PIEB distribuye volumen de forma intermitente</div>
                  <p class="note-warning-note">El beneficio práctico no es solo usar menos droga: los bolos intermitentes favorecen distribución epidural más homogénea.</p>
                </div>
              </div>
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Evaluar bloqueo motor y analgesia por etapa del trabajo de parto</div>
                  <p class="note-warning-note">Más concentración no siempre mejora analgesia y puede aumentar bloqueo motor; el volumen y el patrón de administración importan.</p>
                </div>
              </div>
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">No confundir receta con orden automática</div>
                  <p class="note-warning-note">Ajustar a respuesta clínica, altura del bloqueo, dolor irruptivo, lateralización, hipotensión, prurito y protocolo local.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">En analgesia epidural obstétrica, volumen y patrón de administración importan tanto como la droga</div>
          <div class="note-tips"><strong>Qué hacer:</strong> piensa en volumen epidural, cobertura de raíces, lockout, lateralización y necesidad de rescates, no solo en concentración.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> subir concentración ante todo dolor irruptivo sin evaluar nivel, catéter, lateralización y etapa del trabajo de parto.</div>
          <div class="note-tips"><strong>PCEA:</strong> los bolos a demanda reducen intervenciones no programadas frente a esquemas sin bolos, pero pueden aumentar consumo total si se combinan con basal continua.</div>
          <div class="note-tips"><strong>PIEB:</strong> suele asociarse a menor consumo total de anestésico local y distribución más uniforme que infusión continua equivalente.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> un esquema fácil de recordar es <strong>0 · 9/10 · 45/60</strong>: sin basal, PIEB 9–10 mL cada 45–60 min, PCEA 10 mL con lockout 10 min.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};
  const finalVolumeInput = document.getElementById('finalVolumeInput');
  const fentanylConcentrationInput = document.getElementById('fentanylConcentrationInput');

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

  function updatePIEB(){
    const finalVolume = parseLocal(finalVolumeInput.value);
    const fentFinal = parseLocal(fentanylConcentrationInput.value);
    const fentStock = 50;
    const bupiStock = 5;

    if(!finalVolume || finalVolume <= 0 || !fentFinal || fentFinal <= 0 || !bupiStock || bupiStock <= 0){
      setText('summaryNarrative', 'Ingresa volumen final y concentraciones disponibles para calcular la preparación.');
      setText('summaryVolume', '-');
      setText('summaryBupiConc', '-');
      setText('summaryFentConc', '-');
      setText('bupiResult', '-');
      setText('bupiNote', 'Dato incompleto.');
      setText('fentResult', '-');
      setText('fentNote', 'Dato incompleto.');
      setText('mainRecipe', 'Pendiente');
      setText('mainSoft', 'Completa los datos para calcular volumen a retirar y aditivos.');
      setText('stepRemove', 'Dato incompleto.');
      setText('stepBupi', 'Dato incompleto.');
      setText('stepFent', 'Dato incompleto.');
      return;
    }

    const targetBupiMgPerMl = 0.625;
    const targetFentMcgPerMl = fentFinal;

    const totalBupiMg = finalVolume * targetBupiMgPerMl;
    const bupiMl = totalBupiMg / bupiStock;
    const totalFentMcg = finalVolume * targetFentMcgPerMl;
    const fentMl = totalFentMcg / fentStock;
    const removeMl = bupiMl + fentMl;

    const bupiPercent = (bupiStock / 10);
    const finalBagText = finalVolume === 100 ? 'un matraz de 100 mL' : 'un matraz con volumen final ajustado';

    setText('summaryNarrative', 'Solución final ' + fmt(finalVolume,0) + ' mL: bupivacaína 0,0625% + fentanyl 2 mcg/mL. Retirar ' + fmt(removeMl,1) + ' mL y reponer con los aditivos.');
    setText('summaryVolume', fmt(finalVolume,0) + ' mL');
    setText('summaryBupiConc', '0,0625%');
    setText('summaryFentConc', '2 mcg/mL');
    setText('summaryProgram', '0 · 9/10 · 45/60');

    setText('bupiResult', fmt(bupiMl,1) + ' mL');
    setText('bupiNote', 'Equivale a ' + fmt(totalBupiMg,1) + ' mg de bupivacaína.');
    setText('fentResult', fmt(fentMl,1) + ' mL');
    setText('fentNote', 'Equivale a ' + fmt(totalFentMcg,0) + ' mcg de fentanyl.');

    setText('mainRecipe', 'Retirar ' + fmt(removeMl,1) + ' mL del matraz');
    setText('mainSoft', 'Agregar ' + fmt(bupiMl,1) + ' mL de bupivacaína y ' + fmt(fentMl,1) + ' mL de fentanyl para mantener ' + fmt(finalVolume,0) + ' mL finales.');

    setText('stepRemove', 'Extraer ' + fmt(removeMl,1) + ' mL desde ' + finalBagText + '.');
    setText('stepBupi', 'Agregar ' + fmt(bupiMl,1) + ' mL de bupivacaína ' + fmt(bupiPercent,3) + '% (' + fmt(totalBupiMg,1) + ' mg).');
    setText('stepFent', 'Agregar ' + fmt(totalFentMcg,0) + ' mcg de fentanyl (' + fmt(fentMl,1) + ' mL si la ampolla es ' + fmt(fentStock,0) + ' mcg/mL).');
  }

  finalVolumeInput.addEventListener('input', updatePIEB);
  fentanylConcentrationInput.addEventListener('input', updatePIEB);
  updatePIEB();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
