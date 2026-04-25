<?php
$titulo_pagina = "ECG e isquemia";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para seleccionar modalidad de monitorización ECG intraoperatoria, priorizar derivaciones según territorio/arteria de interés y recordar la correlación anatómica práctica para detección de isquemia.";
$formula = "Decisión clínica = modalidad de monitorización + territorio/arteria que deseas vigilar";
$referencias = array(
  "London MJ, Hollenberg M, Wong MG, et al. Intraoperative myocardial ischemia: localization by continuous electrocardiography. Anesthesiology.",
  "Hollenberg M, Mangano DT, Browner WS, et al. Predictors of postoperative myocardial ischemia in patients undergoing noncardiac surgery. JAMA.",
  "Tablas docentes de correlación anatómica entre territorios coronarios, derivadas ECG y localización miocárdica."
);

$img_montajes    = "img_apuntes/" . rawurlencode("IMG_0036.png");
$img_sensibilidad= "img_apuntes/" . rawurlencode("NUMERO.png");
$img_territorios = "img_apuntes/" . rawurlencode("TABLE_5.jpeg");
$img_coronarias  = "img_apuntes/" . rawurlencode("Coronary.jpeg");

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .ecg-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }
          .ecg-choice-grid.ecg-territory-grid{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }
          .ecg-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
          .ecg-option{
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            justify-content:flex-start;
            text-align:left;
            gap:.25rem;
            min-height:88px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.9rem .95rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
          }
          .ecg-option-input:checked + .ecg-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }
          .ecg-option-title{
            font-size:.98rem;
            font-weight:800;
            line-height:1.2;
            color:var(--note-text);
            margin:0;
          }
          .ecg-option-sub{
            font-size:.87rem;
            line-height:1.35;
            color:var(--note-muted);
            margin:0;
          }
          .ecg-reco-main{
            font-size:1.18rem;
            font-weight:900;
            line-height:1.2;
            color:var(--note-text);
            margin-bottom:.65rem;
          }
          .ecg-image-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:1rem;
          }
          .ecg-image-card{
            background:#f8fafc;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:.8rem;
          }
          .ecg-image-card img{
            width:100%;
            height:auto;
            border-radius:.75rem;
            border:1px solid #dfe7f2;
            background:#fff;
            display:block;
          }
          .ecg-image-cap{
            margin-top:.6rem;
            font-size:.88rem;
            line-height:1.4;
            color:var(--note-muted);
          }
          .ecg-table-wrap{
            overflow-x:auto;
          }
          .ecg-table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            min-width:760px;
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            overflow:hidden;
          }
          .ecg-table th,
          .ecg-table td{
            padding:.8rem .85rem;
            border-bottom:1px solid #eef2f6;
            border-right:1px solid #eef2f6;
            vertical-align:top;
            text-align:left;
          }
          .ecg-table th{
            background:#3559b7;
            color:#fff;
            font-size:.84rem;
            font-weight:800;
          }
          .ecg-table th:last-child,
          .ecg-table td:last-child{
            border-right:none;
          }
          .ecg-table tr:last-child td{
            border-bottom:none;
          }
          .ecg-table td:first-child{
            font-weight:800;
            color:var(--note-text);
          }
          @media (max-width:992px){
            .ecg-choice-grid.ecg-territory-grid{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }
            .ecg-image-grid{
              grid-template-columns:1fr;
            }
          }
          @media (max-width:520px){
            .ecg-choice-grid,
            .ecg-choice-grid.ecg-territory-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · MONITORIZACIÓN INTRAOPERATORIA</div>
          <h2>Monitorización ECG e isquemia miocárdica</h2>
          <div class="note-hero-subtitle">Selecciona modalidad de monitorización y territorio de interés para obtener una recomendación práctica de derivaciones a vigilar.</div>
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

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Imágenes clave</div>
            <div class="ecg-image-grid">
              <div class="ecg-image-card">
                <img src="<?php echo $img_montajes; ?>" alt="Montajes ECG">
                <div class="ecg-image-cap"><strong>Montajes útiles en anestesia.</strong> CS5, CB5 y CM5 permiten obtener V5 modificada u otras configuraciones prácticas.</div>
              </div>
              <div class="ecg-image-card">
                <img src="<?php echo $img_sensibilidad; ?>" alt="Sensibilidad derivaciones">
                <div class="ecg-image-cap"><strong>Sensibilidad isquémica.</strong> Una derivación no es igual a dos o tres; la sensibilidad aumenta marcadamente al combinar derivaciones.</div>
              </div>
              <div class="ecg-image-card">
                <img src="<?php echo $img_territorios; ?>" alt="Territorios y derivadas">
                <div class="ecg-image-cap"><strong>Territorio vs derivada.</strong> Correlación entre localización anatómica, derivadas ECG y territorio miocárdico.</div>
              </div>
              <div class="ecg-image-card">
                <img src="<?php echo $img_coronarias; ?>" alt="Anatomía coronaria">
                <div class="ecg-image-cap"><strong>Anatomía coronaria.</strong> Antes de elegir derivación, piensa qué arteria o territorio quieres vigilar.</div>
              </div>
            </div>
          </div>
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
            <div class="note-section-label">1. Modalidad de monitorización</div>
            <div class="ecg-choice-grid">
              <label>
                <input class="ecg-option-input" type="radio" name="monitorMode" value="3" checked>
                <div class="ecg-option">
                  <div class="ecg-option-title">3 electrodos</div>
                  <div class="ecg-option-sub">1 derivación continua. Puede cambiarse manualmente según objetivo clínico.</div>
                </div>
              </label>
              <label>
                <input class="ecg-option-input" type="radio" name="monitorMode" value="5">
                <div class="ecg-option">
                  <div class="ecg-option-title">5 electrodos</div>
                  <div class="ecg-option-sub">2 derivaciones continuas. Mayor sensibilidad para isquemia.</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">2. Territorio / arteria a vigilar</div>
            <div class="ecg-choice-grid ecg-territory-grid">
              <?php
              $territorios = array(
                array('id'=>'screen','title'=>'Screening general','sub'=>'Riesgo isquémico global'),
                array('id'=>'rca','title'=>'RCA','sub'=>'Inferior / posible VD'),
                array('id'=>'lad_septal','title'=>'LAD septal','sub'=>'Territorio septal'),
                array('id'=>'lad_anterior','title'=>'LAD anterior','sub'=>'Pared anterior'),
                array('id'=>'cx','title'=>'Circunfleja (CX)','sub'=>'Pared lateral'),
                array('id'=>'posterior','title'=>'Posterior','sub'=>'RCA / CX'),
                array('id'=>'vd','title'=>'Ventrículo derecho','sub'=>'RCA proximal')
              );
              foreach($territorios as $t){ ?>
              <label>
                <input class="ecg-option-input" type="radio" name="territory" value="<?php echo $t['id']; ?>" <?php echo $t['id']==='screen' ? 'checked' : ''; ?>>
                <div class="ecg-option">
                  <div class="ecg-option-title"><?php echo $t['title']; ?></div>
                  <div class="ecg-option-sub"><?php echo $t['sub']; ?></div>
                </div>
              </label>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Screening general con 3 electrodos. En anestesia, V5 modificada o DII según objetivo clínico.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Modo</div>
              <div id="summaryMode" class="note-summary-v">3 electrodos</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Territorio</div>
              <div id="summaryTerritory" class="note-summary-v">Screening general</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Derivaciones sugeridas</div>
              <div id="summaryLeads" class="note-summary-v">V5 modificada o DII</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Sensibilidad aproximada</div>
              <div id="summarySensitivity" class="note-summary-v">V5 ≈ 75%</div>
            </div>
          </div>
        </div>

        <div class="note-interpretation mb-3">
          <div class="note-interpretation-label">Recomendación práctica</div>
          <div id="algoMain" class="ecg-reco-main">Screening general con 3 electrodos</div>
          <div id="algoLeads" class="note-interpretation-soft">Derivaciones sugeridas: V5 modificada o DII según objetivo clínico.</div>

          <div class="note-result-grid-2 mt-3">
            <div class="note-result-card">
              <div class="note-result-card-label">Territorio / arteria</div>
              <div id="algoArea" class="note-result-card-value">Screening global</div>
              <div id="algoAreaNote" class="note-result-card-note">V5 es la derivación aislada más sensible para isquemia.</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Sensibilidad aproximada</div>
              <div id="algoSensitivity" class="note-result-card-value">1 derivación: V5 ≈ 75%</div>
              <div id="algoPractical" class="note-result-card-note">Con 3 electrodos puedes dejar una derivación continua y cambiarla manualmente si lo necesitas.</div>
            </div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="algoPearl" class="mt-2">Una sola derivación no equivale a dos. Si el riesgo isquémico es alto o quieres combinar vigilancia de ritmo e isquemia, 5 electrodos ofrece una ventaja real.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Correlación anatómica</div>
            <div class="ecg-table-wrap">
              <table class="ecg-table">
                <thead>
                  <tr>
                    <th>Territorio / arteria</th>
                    <th>Derivadas indicativas</th>
                    <th>Área afectada</th>
                    <th>Comentario práctico</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>RCA / CX</td>
                    <td>II, III, aVF</td>
                    <td>Inferior</td>
                    <td>Si el antecedente es coronaria derecha o inferior, DII es muy útil en pabellón.</td>
                  </tr>
                  <tr>
                    <td>LAD</td>
                    <td>V1, V2</td>
                    <td>Septal</td>
                    <td>Útil si quieres vigilar compromiso septal.</td>
                  </tr>
                  <tr>
                    <td>LAD</td>
                    <td>V3, V4</td>
                    <td>Anterior</td>
                    <td>Priorizar si el antecedente coronario fue de pared anterior.</td>
                  </tr>
                  <tr>
                    <td>CX / LAD</td>
                    <td>I, aVL, V5, V6</td>
                    <td>Lateral</td>
                    <td>V5 modificada es especialmente útil en anestesia para screening de isquemia lateral.</td>
                  </tr>
                  <tr>
                    <td>CX o RCA</td>
                    <td>V1–V3 (recíprocos)</td>
                    <td>Posterior</td>
                    <td>Buscar cambios recíprocos si sospechas pared posterior.</td>
                  </tr>
                  <tr>
                    <td>RCA proximal</td>
                    <td>V1, V4R</td>
                    <td>Ventrículo derecho</td>
                    <td>Considerar si sospechas compromiso del VD.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">La derivación ideal depende de la pregunta clínica</div>
          <div class="note-tips"><strong>Qué hacer:</strong> define primero si quieres screening global o vigilancia dirigida de un territorio/arteria específico.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> asumir que DII sirve para todo o que una sola derivación basta en un paciente de alto riesgo.</div>
          <div class="note-tips mb-0"><strong>Perla:</strong> si puedes usar solo una derivación para detectar isquemia, V5 suele ser la más sensible; DII agrega información de ritmo e isquemia inferior.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const modeInputs = Array.from(document.querySelectorAll('input[name="monitorMode"]'));
  const territoryInputs = Array.from(document.querySelectorAll('input[name="territory"]'));

  const data = {
    screen: {
      territoryLabel: 'Screening general',
      title3: 'Screening general con 3 electrodos',
      title5: 'Screening general con 5 electrodos',
      leads3: 'V5 modificada o DII según objetivo clínico',
      leads5: 'DII + V5',
      areaValue: 'Screening global',
      areaNote: 'V5 es la derivación aislada más sensible para isquemia.',
      practical3: 'Con 3 electrodos puedes dejar una derivación continua y cambiarla manualmente si lo necesitas.',
      practical5: 'Con 5 electrodos, la combinación práctica clásica es DII + V5.',
      sens3: '1 derivación: V5 ≈ 75%',
      sens5: '2 derivaciones: DII + V5 ≈ 82%',
      summary3: 'Screening general con 3 electrodos. En anestesia, V5 modificada o DII según objetivo clínico.',
      summary5: 'Screening general con 5 electrodos. La combinación práctica clásica es DII + V5.',
      pearl: 'Si puedes elegir solo una derivación para detectar isquemia, V5 suele ser la mejor. DII agrega ritmo e información inferior.'
    },
    rca: {
      territoryLabel: 'RCA',
      title3: 'Vigilancia dirigida de RCA con 3 electrodos',
      title5: 'Vigilancia dirigida de RCA con 5 electrodos',
      leads3: 'Priorizar DII',
      leads5: 'DII + V5',
      areaValue: 'Inferior / posible VD',
      areaNote: 'Territorio inferior dependiente de RCA; si es proximal puede asociarse a VD.',
      practical3: 'Si el antecedente es coronaria derecha o inferior, deja DII continua.',
      practical5: 'Mantén DII y suma V5 para no perder screening lateral/global.',
      sens3: 'Vigilancia territorial útil; menor sensibilidad global',
      sens5: 'DII + V5 mejora screening sin perder territorio inferior',
      summary3: 'RCA con 3 electrodos. DII es la derivación práctica más útil para territorio inferior.',
      summary5: 'RCA con 5 electrodos. DII + V5 permite vigilancia inferior y screening global.',
      pearl: 'En un stent de RCA, DII suele ser la derivación más útil en pabellón.'
    },
    lad_septal: {
      territoryLabel: 'LAD septal',
      title3: 'Vigilancia septal con 3 electrodos',
      title5: 'Vigilancia septal con 5 electrodos',
      leads3: 'Priorizar V1–V2',
      leads5: 'V1/V2 + V5 o DII según contexto',
      areaValue: 'Septal',
      areaNote: 'Territorio septal dependiente de LAD.',
      practical3: 'Si el objetivo es septal específico, reconfigura a una derivación precordial útil.',
      practical5: 'Combina vigilancia septal dirigida con una derivación de screening.',
      sens3: 'Vigilancia más dirigida, menos global',
      sens5: 'Mejor equilibrio entre territorio específico y screening general',
      summary3: 'LAD septal con 3 electrodos. V1–V2 tienen más sentido que una derivación inferior.',
      summary5: 'LAD septal con 5 electrodos. Combina derivación septal con una de screening.',
      pearl: 'No siempre basta con DII + V5 si el territorio que más te interesa es septal.'
    },
    lad_anterior: {
      territoryLabel: 'LAD anterior',
      title3: 'Vigilancia anterior con 3 electrodos',
      title5: 'Vigilancia anterior con 5 electrodos',
      leads3: 'Priorizar V3–V4',
      leads5: 'V3/V4 + V5 o DII según contexto',
      areaValue: 'Anterior',
      areaNote: 'Pared anterior dependiente de LAD.',
      practical3: 'Si el antecedente es LAD anterior, una derivación anterior es mejor que DII aislada.',
      practical5: 'Con 5 electrodos puedes mantener una derivación anterior y otra de screening.',
      sens3: 'V4 aislada tiene mayor sensibilidad que DII para isquemia',
      sens5: 'Combinar una anterior con V5 amplía la vigilancia',
      summary3: 'LAD anterior con 3 electrodos. V3–V4 son más pertinentes que una derivación inferior.',
      summary5: 'LAD anterior con 5 electrodos. Combina una derivación anterior con otra de screening.',
      pearl: 'En territorio LAD anterior, V3–V4 tienen más sentido que una derivación inferior.'
    },
    cx: {
      territoryLabel: 'Circunfleja (CX)',
      title3: 'Vigilancia lateral con 3 electrodos',
      title5: 'Vigilancia lateral con 5 electrodos',
      leads3: 'Priorizar V5 modificada',
      leads5: 'V5 + DII',
      areaValue: 'Lateral',
      areaNote: 'Pared lateral; suele corresponder a circunfleja.',
      practical3: 'Si el antecedente es CX o lateral, V5 modificada es especialmente útil.',
      practical5: 'V5 sigue siendo central y puedes sumar una segunda derivación.',
      sens3: 'V5 es la derivación aislada más sensible para isquemia',
      sens5: 'DII + V5 es una excelente combinación práctica',
      summary3: 'Circunfleja con 3 electrodos. V5 modificada es la derivación estrella.',
      summary5: 'Circunfleja con 5 electrodos. DII + V5 ofrece excelente rendimiento práctico.',
      pearl: 'Para vigilar CX en anestesia, V5 suele ser la derivación más útil.'
    },
    posterior: {
      territoryLabel: 'Posterior',
      title3: 'Vigilancia posterior con 3 electrodos',
      title5: 'Vigilancia posterior con 5 electrodos',
      leads3: 'Buscar cambios recíprocos en V1–V3',
      leads5: 'Combinar derivación precordial anterior con otra derivación útil',
      areaValue: 'Posterior',
      areaNote: 'Pared posterior; suele depender de RCA o CX.',
      practical3: 'No siempre es fácil con monitorización básica; piensa en cambios recíprocos.',
      practical5: 'Permite mejor vigilancia continua de cambios indirectos.',
      sens3: 'Limitada si no dispones de configuración adecuada',
      sens5: 'Mejor vigilancia continua de cambios recíprocos',
      summary3: 'Territorio posterior con 3 electrodos. Piensa en cambios recíprocos más que en una derivación directa.',
      summary5: 'Territorio posterior con 5 electrodos. Mantén una derivación anterior continua y otra de apoyo.',
      pearl: 'La pared posterior suele vigilarse por cambios recíprocos más que por una derivación directa.'
    },
    vd: {
      territoryLabel: 'Ventrículo derecho',
      title3: 'Vigilancia de ventrículo derecho con 3 electrodos',
      title5: 'Vigilancia de ventrículo derecho con 5 electrodos',
      leads3: 'Considerar V1 o V4R según posibilidad técnica',
      leads5: 'Derivación de VD + otra derivación de screening',
      areaValue: 'Ventrículo derecho',
      areaNote: 'Suele asociarse a RCA proximal.',
      practical3: 'Si sospechas compromiso de VD, una derivación derecha puede ser más útil que DII sola.',
      practical5: 'Con 5 electrodos puedes combinar vigilancia de VD con screening global.',
      sens3: 'Más dirigida, menos global',
      sens5: 'Mejor balance entre vigilancia territorial y general',
      summary3: 'Ventrículo derecho con 3 electrodos. Una derivación derecha puede cambiar tu estrategia.',
      summary5: 'Ventrículo derecho con 5 electrodos. Combina VD con una derivación de screening.',
      pearl: 'El compromiso de VD es un escenario donde una derivación derecha sí cambia tu estrategia.'
    }
  };

  function getSelected(name){
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? selected.value : '';
  }

  function renderRecommendation(){
    const mode = getSelected('monitorMode') || '3';
    const territory = getSelected('territory') || 'screen';
    const d = data[territory];

    document.getElementById('summaryMode').textContent = mode === '3' ? '3 electrodos' : '5 electrodos';
    document.getElementById('summaryTerritory').textContent = d.territoryLabel;
    document.getElementById('summaryLeads').textContent = mode === '3' ? d.leads3 : d.leads5;
    document.getElementById('summarySensitivity').textContent = mode === '3' ? d.sens3 : d.sens5;
    document.getElementById('summaryNarrative').textContent = mode === '3' ? d.summary3 : d.summary5;

    document.getElementById('algoMain').textContent = mode === '3' ? d.title3 : d.title5;
    document.getElementById('algoLeads').textContent = 'Derivaciones sugeridas: ' + (mode === '3' ? d.leads3 : d.leads5);
    document.getElementById('algoArea').textContent = d.areaValue;
    document.getElementById('algoAreaNote').textContent = d.areaNote;
    document.getElementById('algoSensitivity').textContent = mode === '3' ? d.sens3 : d.sens5;
    document.getElementById('algoPractical').textContent = mode === '3' ? d.practical3 : d.practical5;
    document.getElementById('algoPearl').textContent = d.pearl;
  }

  modeInputs.forEach(function(input){ input.addEventListener('change', renderRecommendation); });
  territoryInputs.forEach(function(input){ input.addEventListener('change', renderRecommendation); });

  renderRecommendation();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
