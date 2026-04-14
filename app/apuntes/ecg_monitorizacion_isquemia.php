<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para monitorización ECG intraoperatoria orientada a detección de isquemia, selección de derivaciones y correlación anatómica/coronaria.";
$formula = "Decisión clínica = modalidad de monitorización + territorio/arteria a vigilar";
$referencias = array(
  "1.- London MJ, Hollenberg M, Wong MG, et al. Intraoperative myocardial ischemia: localization by continuous electrocardiography. Anesthesiology.",
  "2.- Hollenberg M, Mangano DT, Browner WS, et al. Predictors of postoperative myocardial ischemia in patients undergoing noncardiac surgery. JAMA.",
  "3.- Tablas docentes de correlación anatómica vs derivadas ECG vs territorio coronario."
);

$icono_apunte = "<i class='fa-solid fa-heart-pulse pe-3 pt-2'></i>";
$titulo_apunte = "Monitorización ECG e Isquemia Miocárdica";

$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Apuntes</span>";
$boton_navbar="<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";

/*
  IMPORTANTE:
  Deja estas 4 imágenes en la MISMA carpeta que este archivo PHP.
  Si las renombras, cambia aquí los nombres.
*/
$img_montajes    = rawurlencode("IMG_0036.png");
$img_sensibilidad= rawurlencode("NUMERO.png");
$img_territorios = rawurlencode("TABLE_5.jpeg");
$img_coronarias  = rawurlencode("Coronary.jpeg");

require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="ecg-shell">

        <style>
          .ecg-shell{max-width:1100px;margin:0 auto;}
          .ecg-topbar{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;margin-bottom:1rem;
          }
          .ecg-topbar h1{color:#fff;}
          .section-card{
            border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;overflow:hidden;margin-bottom:1rem;
          }
          .section-title{
            font-size:.8rem;letter-spacing:.05em;text-transform:uppercase;color:#667085;
          }
          .pill{
            display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.78rem;
            background:#eef3ff;color:#3559b7;font-weight:600;
          }
          .subtle{font-size:.94rem;color:#5f6b76;}
          .choice-grid{
            display:grid;grid-template-columns:repeat(2,1fr);gap:.75rem;
          }
          .choice-grid.territory{grid-template-columns:repeat(3,1fr);}
          .choice-btn{
            border:1px solid #dfe7f2;border-radius:1rem;background:#f8fafc;
            padding:1rem .9rem;text-align:center;cursor:pointer;transition:.15s ease;user-select:none;
          }
          .choice-btn.active{
            background:#edf4ff;border-color:#bfd2ff;box-shadow:0 0 0 2px rgba(53,89,183,.08) inset;
          }
          .choice-btn .name{font-weight:700;color:#1f2a37;margin-bottom:.18rem;}
          .choice-btn .desc{font-size:.86rem;color:#667085;line-height:1.2;}
          .algo-box{
            padding:1rem;border-radius:1rem;border:1px solid #dfe7f2;background:#f8fafc;
          }
          .algo-main{
            font-size:1.08rem;font-weight:800;color:#1f2a37;margin-bottom:.85rem;
          }
          .algo-block{
            background:#fff;border:1px solid #e6e9ef;border-radius:.9rem;padding:.9rem 1rem;margin-bottom:.7rem;
          }
          .algo-block:last-child{margin-bottom:0;}
          .algo-label{font-size:.82rem;text-transform:uppercase;letter-spacing:.05em;color:#667085;margin-bottom:.35rem;}
          .algo-value{font-weight:700;color:#1f2a37;}
          .sensitivity-badge{
            display:inline-block;background:#eef3ff;color:#3559b7;font-weight:700;border-radius:999px;padding:.28rem .65rem;
          }
          .image-grid{
            display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;
          }
          .image-card{
            background:#f8fafc;border:1px solid #e6e9ef;border-radius:1rem;padding:.8rem;text-align:center;
          }
          .image-card img{
            width:100%;height:auto;border-radius:.65rem;border:1px solid #dfe7f2;background:#fff;
          }
          .image-card .cap{
            margin-top:.55rem;font-size:.88rem;color:#5f6b76;line-height:1.35;
          }
          .table-wrap{
            overflow-x:auto;
          }
          .corr-table{
            width:100%;border-collapse:separate;border-spacing:0;font-size:.95rem;
          }
          .corr-table th{
            background:#3559b7;color:#fff;padding:.85rem .8rem;border-right:1px solid rgba(255,255,255,.18);
            text-align:left;
          }
          .corr-table td{
            background:#fff;padding:.8rem;border-bottom:1px solid #e6e9ef;border-right:1px solid #eef1f6;vertical-align:top;
          }
          .corr-table tr td:first-child{font-weight:700;}
          .note-box{
            background:#fff9e8;border:1px solid #f1df9d;border-radius:1rem;padding:1rem;
          }
          .refs-card{display:none;}
          .refs-card ul{color:#667085;line-height:1.55;padding-left:1.1rem;margin-bottom:0;}
          .small-note{font-size:.84rem;color:#667085;}
          @media (max-width:992px){
            .choice-grid.territory{grid-template-columns:repeat(2,1fr);}
            .image-grid{grid-template-columns:1fr;}
          }
          @media (max-width:768px){
            .choice-grid,.choice-grid.territory{grid-template-columns:1fr;}
          }
        </style>
<style>
.info-box{
  background:#fff;
  border-radius:1rem;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  margin-bottom:1rem;
  overflow:hidden;
}

.info-box-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:1rem;
  padding:1rem;
}

.info-box-title{
  font-size:.8rem;
  text-transform:uppercase;
  color:#667085;
  letter-spacing:.08em;
}

.info-toggle-btn{
  border-radius:.6rem;
  font-size:.85rem;
  padding:.35rem .7rem;
  white-space:nowrap;
  background:#6c757d;
  border:none;
  color:white;
  transition:.2s;
}

.info-toggle-btn:hover{
  background:#5a6268;
  color:white;
}

.info-box-content{
  padding:1rem;
  display:none;
  animation:fadeIn .2s ease-in-out;
  border-top:1px solid #e9eef5;
}

@keyframes fadeIn{
  from{opacity:0; transform:translateY(-5px);}
  to{opacity:1; transform:translateY(0);}
}

@media (max-width:576px){
  .info-box-header{
    flex-direction:row;
  }

  .info-toggle-btn{
    margin-left:auto;
  }
}
</style>
        <div class="ecg-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • monitorización intraoperatoria</div>
              <h1 class="h3 mb-2">Monitorización ECG e Isquemia Miocárdica</h1>
              <div class="subtle text-white-50">Correlación entre modalidad de monitorización, territorio anatómico, arteria coronaria y derivadas ECG a vigilar.</div>
            </div>
            <span class="pill bg-light text-dark">Anestesia</span>
          </div>
        </div>


<div class="info-box">

  <div class="info-box-header">
    <div class="info-box-title">Información</div>

    <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">
      Mostrar / ocultar
    </button>
  </div>

  <div id="infoContent" class="info-box-content">
    <?php echo $descripcion_info; ?>

    <?php if(!empty($formula)){ ?>
      <hr>
      <b>Fórmula:</b><br>
      <?php echo $formula; ?>
    <?php } ?>
          <hr>
          <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Imágenes clave</div>
            <div class="image-grid">
              <div class="image-card">
                <img src="<?php echo $img_montajes; ?>" alt="Montajes ECG">
                <div class="cap"><strong>Montajes útiles en anestesia</strong><br>CS5, CB5 y CM5 para obtener V5 modificada u otras configuraciones prácticas.</div>
              </div>
              <div class="image-card">
                <img src="<?php echo $img_sensibilidad; ?>" alt="Sensibilidad derivaciones">
                <div class="cap"><strong>Sensibilidad isquémica</strong><br>Una derivación no es igual a dos o tres: la sensibilidad aumenta marcadamente.</div>
              </div>
              <div class="image-card">
                <img src="<?php echo $img_territorios; ?>" alt="Territorios y derivadas">
                <div class="cap"><strong>Territorio vs derivada</strong><br>Correlación entre localización anatómica, derivadas ECG y territorio miocárdico.</div>
              </div>
              <div class="image-card">
                <img src="<?php echo $img_coronarias; ?>" alt="Anatomía coronaria">
                <div class="cap"><strong>Anatomía coronaria</strong><br>Piensa siempre qué arteria quieres vigilar antes de elegir la derivación.</div>
              </div>
            </div>
          </div>
        </div>
  </div>
</div>


        <div id="referenciasBox" class="section-card refs-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Referencias</div>
            <ul>
              <?php foreach($referencias as $ref){ ?>
                <li class="mb-2"><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">1. Modalidad de monitorización</div>
            <div class="choice-grid">
              <div class="choice-btn active" id="btn_mode_3" onclick="setMode('3')">
                <div class="name">3 electrodos</div>
                <div class="desc">1 derivación continua<br>puede cambiarse manualmente en el monitor</div>
              </div>
              <div class="choice-btn" id="btn_mode_5" onclick="setMode('5')">
                <div class="name">5 electrodos</div>
                <div class="desc">2 derivaciones continuas<br>mayor sensibilidad isquémica</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">2. Territorio / arteria que deseas vigilar</div>
            <div class="choice-grid territory">
              <div class="choice-btn active" id="btn_terr_screen" onclick="setTerritory('screen')">
                <div class="name">Screening general</div>
                <div class="desc">riesgo isquémico global</div>
              </div>
              <div class="choice-btn" id="btn_terr_rca" onclick="setTerritory('rca')">
                <div class="name">RCA</div>
                <div class="desc">inferior / posible VD</div>
              </div>
              <div class="choice-btn" id="btn_terr_lad_septal" onclick="setTerritory('lad_septal')">
                <div class="name">LAD septal</div>
                <div class="desc">septal</div>
              </div>
              <div class="choice-btn" id="btn_terr_lad_anterior" onclick="setTerritory('lad_anterior')">
                <div class="name">LAD anterior</div>
                <div class="desc">pared anterior</div>
              </div>
              <div class="choice-btn" id="btn_terr_cx" onclick="setTerritory('cx')">
                <div class="name">Circunfleja (CX)</div>
                <div class="desc">pared lateral</div>
              </div>
              <div class="choice-btn" id="btn_terr_posterior" onclick="setTerritory('posterior')">
                <div class="name">Posterior</div>
                <div class="desc">RCA / CX</div>
              </div>
              <div class="choice-btn" id="btn_terr_vd" onclick="setTerritory('vd')">
                <div class="name">Ventrículo derecho</div>
                <div class="desc">RCA proximal</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">3. Recomendación práctica</div>
            <div class="algo-box">
              <div id="algoMain" class="algo-main">Screening general con 3 electrodos</div>

              <div class="algo-block">
                <div class="algo-label">Derivaciones sugeridas</div>
                <div id="algoLeads" class="algo-value">V5 modificada o DII según objetivo clínico</div>
              </div>

              <div class="algo-block">
                <div class="algo-label">Territorio / arteria</div>
                <div id="algoArea" class="algo-value">Vigilancia global de isquemia. V5 es la derivación individual más sensible.</div>
              </div>

              <div class="algo-block">
                <div class="algo-label">Aplicación en pabellón</div>
                <div id="algoPractical">Si usas 3 electrodos, puedes monitorizar una derivación continua y cambiar manualmente a otra si lo necesitas.</div>
              </div>

              <div class="algo-block">
                <div class="algo-label">Sensibilidad aproximada</div>
                <div id="algoSensitivity"><span class="sensitivity-badge">1 derivación: DII ≈ 33%, V4 ≈ 61%, V5 ≈ 75%</span></div>
              </div>

              <div class="algo-block">
                <div class="algo-label">Perla clínica</div>
                <div id="algoPearl" class="small-note">Si puedes elegir solo una derivación para detección de isquemia, V5 suele ser la más sensible. DII agrega información inferior y de ritmo.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">4. Correlación anatómica</div>
            <div class="table-wrap">
              <table class="corr-table">
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
                    <td>Si antecedente de stent en coronaria derecha, prioriza territorio inferior; en la práctica DII es muy útil.</td>
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
                    <td>Buscar cambios recíprocos si sospecha pared posterior.</td>
                  </tr>
                  <tr>
                    <td>RCA proximal</td>
                    <td>V1, V4R</td>
                    <td>Ventrículo derecho</td>
                    <td>Considerar si sospecha compromiso de VD.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">5. Idea clave</div>
            <div class="note-box">
              En anestesia, con 3 electrodos puedes seguir una derivación continua y cambiarla manualmente según el territorio que te interese. Con 5 electrodos puedes mantener dos derivaciones continuas, lo que mejora claramente la sensibilidad para isquemia. La selección ideal depende de si buscas <strong>screening global</strong> o <strong>vigilar una arteria/territorio específico</strong>.
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
let monitorMode = '3';
let territory = 'screen';

function toggleReferencias(e){
  if(e) e.preventDefault();
  const box = document.getElementById('referenciasBox');
  box.style.display = (box.style.display === 'block') ? 'none' : 'block';
}

function setMode(mode){
  monitorMode = mode;
  ['3','5'].forEach(id => {
    const el = document.getElementById('btn_mode_' + id);
    if(el) el.classList.toggle('active', id === mode);
  });
  renderRecommendation();
}

function setTerritory(t){
  territory = t;
  ['screen','rca','lad_septal','lad_anterior','cx','posterior','vd'].forEach(id => {
    const el = document.getElementById('btn_terr_' + id);
    if(el) el.classList.toggle('active', id === t);
  });
  renderRecommendation();
}

function renderRecommendation(){
  const data = {
    screen: {
      title3: 'Screening general con 3 electrodos',
      title5: 'Screening general con 5 electrodos',
      leads3: 'V5 modificada o DII según objetivo clínico',
      leads5: 'DII + V5',
      area: 'Vigilancia global de isquemia. V5 es la derivación individual más sensible.',
      practical3: 'Con 3 electrodos puedes dejar V5 si priorizas isquemia, o DII si priorizas ritmo/inferior, y cambiar manualmente según el momento clínico.',
      practical5: 'Con 5 electrodos, la combinación práctica clásica es DII + V5.',
      sens3: '1 derivación: DII ≈ 33%, V4 ≈ 61%, V5 ≈ 75%',
      sens5: '2 derivaciones: DII + V4 ≈ 80%, DII + V5 ≈ 82%',
      pearl: 'Si puedes elegir solo una derivación para detección de isquemia, V5 suele ser la mejor. DII agrega ritmo e información inferior.'
    },
    rca: {
      title3: 'Vigilancia dirigida de RCA con 3 electrodos',
      title5: 'Vigilancia dirigida de RCA con 5 electrodos',
      leads3: 'Priorizar DII (y cambiar a III/aVF si el monitor lo permite)',
      leads5: 'Mantener DII + agregar V5 para screening global',
      area: 'Territorio inferior. RCA explica la mayoría de los eventos inferiores; si es proximal puede asociar VD.',
      practical3: 'Paciente con stent en coronaria derecha: deja DII continua si quieres vigilar territorio inferior.',
      practical5: 'Con 5 electrodos, mantén DII y suma V5 para no perder screening lateral/global.',
      sens3: 'Territorialmente útil para pared inferior; 1 derivación tiene menor sensibilidad global.',
      sens5: 'DII + V5 mejora detección global sin perder vigilancia inferior.',
      pearl: 'En un stent de RCA, DII suele ser la derivación práctica más útil en pabellón.'
    },
    lad_septal: {
      title3: 'Vigilancia septal (LAD) con 3 electrodos',
      title5: 'Vigilancia septal (LAD) con 5 electrodos',
      leads3: 'Priorizar V1–V2 si tu monitor permite ese enfoque',
      leads5: 'Mantener una derivación septal/anterior + V5 o DII según contexto',
      area: 'Territorio septal dependiente de LAD.',
      practical3: 'Con 3 electrodos, si el objetivo es septal específico, reconfigura a una derivación precordial útil.',
      practical5: 'Con 5 electrodos, combina vigilancia dirigida con una derivación de screening.',
      sens3: 'Menor sensibilidad global, pero vigilancia más dirigida.',
      sens5: 'Mejor equilibrio entre territorio específico y screening general.',
      pearl: 'No siempre basta con DII + V5 si el territorio que más te interesa es septal.'
    },
    lad_anterior: {
      title3: 'Vigilancia anterior (LAD) con 3 electrodos',
      title5: 'Vigilancia anterior (LAD) con 5 electrodos',
      leads3: 'Priorizar V3–V4',
      leads5: 'V3/V4 + V5 o DII según necesidad clínica',
      area: 'Pared anterior dependiente de LAD.',
      practical3: 'Si el antecedente es LAD anterior, conviene una derivación anterior más que DII aislada.',
      practical5: 'Con 5 electrodos puedes mantener una derivación anterior continua y otra de screening.',
      sens3: 'V4 aislada tiene sensibilidad mejor que DII para isquemia.',
      sens5: 'Combinar una anterior con V5 amplía tu vigilancia.',
      pearl: 'En territorio LAD anterior, V3–V4 tienen más sentido que una derivación inferior.'
    },
    cx: {
      title3: 'Vigilancia lateral (CX) con 3 electrodos',
      title5: 'Vigilancia lateral (CX) con 5 electrodos',
      leads3: 'Priorizar V5 modificada',
      leads5: 'V5 + DII o V5 + otra lateral si el monitor lo permite',
      area: 'Pared lateral; suele corresponder a CX.',
      practical3: 'Si el antecedente es circunfleja o lateral, V5 modificada es especialmente útil.',
      practical5: 'Con 5 electrodos, V5 se mantiene como pieza central y puedes sumar una segunda derivación.',
      sens3: 'V5 es la derivación aislada más sensible para isquemia.',
      sens5: 'DII + V5 es una excelente combinación práctica.',
      pearl: 'Para vigilar CX en anestesia, V5 es la derivación estrella.'
    },
    posterior: {
      title3: 'Vigilancia posterior con 3 electrodos',
      title5: 'Vigilancia posterior con 5 electrodos',
      leads3: 'Buscar cambios recíprocos en V1–V3 según configuración posible',
      leads5: 'Combinar derivación precordial anterior con otra derivación útil',
      area: 'Pared posterior; suele depender de RCA o CX.',
      practical3: 'No siempre es fácil en monitorización básica; piensa en cambios recíprocos.',
      practical5: 'Mejor si puedes mantener una derivación anterior continua y otra de apoyo.',
      sens3: 'Más limitada si no dispones de configuración adecuada.',
      sens5: 'Permite mejor vigilancia continua de cambios indirectos.',
      pearl: 'La pared posterior muchas veces se vigila por cambios recíprocos más que por una derivación directa.'
    },
    vd: {
      title3: 'Vigilancia de ventrículo derecho con 3 electrodos',
      title5: 'Vigilancia de ventrículo derecho con 5 electrodos',
      leads3: 'Considerar V1 o V4R según posibilidad técnica',
      leads5: 'Mantener una derivación de VD + otra derivación de screening',
      area: 'Ventrículo derecho; suele asociarse a RCA proximal.',
      practical3: 'Si sospechas compromiso de VD, una derivación derecha puede ser más útil que DII sola.',
      practical5: 'Con 5 electrodos, puedes combinar vigilancia de VD con screening global.',
      sens3: 'Más dirigida, menos global.',
      sens5: 'Mejor balance entre vigilancia territorial y general.',
      pearl: 'El compromiso de VD es un escenario donde una derivación derecha sí cambia tu estrategia.'
    }
  };

  const d = data[territory];
  document.getElementById('algoMain').textContent = monitorMode === '3' ? d.title3 : d.title5;
  document.getElementById('algoLeads').textContent = monitorMode === '3' ? d.leads3 : d.leads5;
  document.getElementById('algoArea').textContent = d.area;
  document.getElementById('algoPractical').textContent = monitorMode === '3' ? d.practical3 : d.practical5;
  document.getElementById('algoSensitivity').innerHTML = '<span class="sensitivity-badge">' + (monitorMode === '3' ? d.sens3 : d.sens5) + '</span>';
  document.getElementById('algoPearl').textContent = d.pearl;
}

renderRecommendation();
</script>
<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>
<?php require("footer.php"); ?>
