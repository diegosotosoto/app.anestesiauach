<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para apoyo en evaluación y corrección de hipernatremia en contexto perioperatorio adulto. Integra estimación de agua corporal total, déficit de agua libre, meta inicial, velocidad segura de corrección y selector de solución para proponer un plan orientativo.";
$formula = "Déficit de agua libre ≈ ACT × ((Na actual / Na objetivo) - 1). Cambio esperado de Na por litro (orientativo): (Na de la solución - Na sérico) / (ACT + 1). La corrección debe ser gradual, idealmente >48 horas si la hipernatremia es crónica o incierta, con controles seriados.";
$referencias = array(
  "1.- Sonani B, Al-Dhahir MA. Hypernatremia. StatPearls [Internet]. Treasure Island (FL): StatPearls Publishing; actualización 2023. NCBI Bookshelf.",
  "2.- Yun G, Baek SH, Kim S. Evaluation and management of hypernatremia in adults: clinical perspectives. Korean J Intern Med. 2023;38(3):290-302.",
  "3.- Lewis JL III. Hypernatremia. Merck Manual Professional Edition. Revisado 2025.",
  "4.- Leung AA, McAlister FA, Finlayson SRG, Bates DW. Preoperative hypernatremia predicts increased perioperative morbidity and mortality. Am J Med. 2013;126(10):877-886.",
  "5.- Cole JH, Highland KB, Hughey SB, et al. The Association Between Borderline Dysnatremia and Perioperative Morbidity and Mortality. JMIR Perioper Med. 2023.",
  "6.- Pokhriyal SC, Joshi P, Gupta U, et al. Hypernatremia and Its Rate of Correction: The Evidence So Far. Cureus. 2024;16(2):e54699.",
  "7.- Goshima T, Terasawa T, Iwata M, et al. Treatment of acute hypernatremia caused by sodium overload in adults: A systematic review. Medicine (Baltimore). 2022;101(8):e28945."
);

$icono_apunte = "<i class='fa-solid fa-droplet pe-3 pt-2'></i>";
$titulo_apunte = "Corrección de Hipernatremia";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; border:0; --bs-border-opacity:0;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="hyperna-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --bg:#f4f7fb;
            --soft:#f8fafc;
            --line:#dfe7f2;
            --text:#1f2a37;
            --muted:#667085;
            --good:#edf8f7;
            --warn:#fff9e8;
            --danger:#fff5f3;
            --mint:#eef7ff;
            --mint-border:#cfe1ff;
          }

          body{background:var(--bg);}
          .hyperna-shell{max-width:1040px;margin:0 auto;}

          .hyperna-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .hyperna-topbar h1{color:#fff;}

          .section-card{
            border:0;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;
            overflow:hidden;
            margin-bottom:1rem;
          }

          .section-title{
            font-size:.8rem;
            letter-spacing:.05em;
            text-transform:uppercase;
            color:var(--muted);
          }

          .pill{
            display:inline-block;
            padding:.2rem .55rem;
            border-radius:999px;
            font-size:.78rem;
            background:#eef3ff;
            color:#3559b7;
            font-weight:600;
          }

          .subtle{font-size:.94rem;color:#5f6b76;}
          .small-note{font-size:.82rem;color:#667085;line-height:1.45;}
          .footer-note{font-size:.82rem;color:#6c757d;}

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

          .calc-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:1rem;
          }

          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .choice-grid-2{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.6rem;
          }

          .choice-grid-3{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.6rem;
          }

          .choice-grid-4{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:.6rem;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            justify-content:center;
            text-align:left;
            min-height:70px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:.9rem;
            padding:.7rem .8rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.12;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
            font-size:.92rem;
          }

          .choice-btn small{
            font-weight:500;
            color:#667085;
            margin-top:.15rem;
            line-height:1.2;
            font-size:.72rem;
          }

          .choice-btn i{
            font-size:1rem;
            margin-bottom:.28rem;
            color:#3559b7;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
            transform:translateY(-1px);
          }

          .form-label-lite{
            font-size:.92rem;
            font-weight:600;
            color:var(--text);
            margin-bottom:.35rem;
          }

          .summary-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:.75rem;
          }

          .summary-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.9rem;
          }

          .summary-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#667085;
            margin-bottom:.25rem;
          }

          .summary-value{
            font-size:1rem;
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
          }

          .result-main-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
          }

          .result-main-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .result-main-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .result-main-value{
            font-size:1.95rem;
            font-weight:800;
            line-height:1.05;
            color:#27458f;
          }

          .result-row{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:1rem;
            padding:.9rem 1rem;
            border:1px solid #e6e9ef;
            border-radius:.9rem;
            background:#fff;
            margin-bottom:.65rem;
          }

          .result-row:last-child{margin-bottom:0;}

          .result-name{
            font-weight:700;
            color:#1f2a37;
            line-height:1.2;
          }

          .result-note{
            font-size:.82rem;
            color:#667085;
            margin-top:.2rem;
            line-height:1.4;
          }

          .result-value{
            min-width:190px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid #ecd798;
            border-radius:1rem;
            padding:1rem;
          }

          .danger-box{
            background:var(--danger);
            border:1px solid #efc4be;
            border-radius:1rem;
            padding:1rem;
          }

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{margin-bottom:.45rem;}

          @media (max-width:900px){
            .choice-grid-4{grid-template-columns:repeat(2,1fr);}
            .summary-grid{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
          }

          @media (max-width:576px){
            .choice-grid-4,.choice-grid-3,.choice-grid-2{grid-template-columns:repeat(2,1fr);}
            .summary-grid{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="hyperna-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • fluidoterapia y electrolitos</div>
              <h1 class="h3 mb-2">Corrección de Hipernatremia</h1>
              <div class="subtle text-white-50">Solo adultos. Déficit de agua libre, velocidad segura, selector de solución y plan orientativo.</div>
            </div>
            <span class="pill bg-light text-dark">Adultos</span>
          </div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>

          <div id="infoContent" class="info-box-content">
            <?php echo $descripcion_info; ?>

            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Comentario:</b><br>
              <?php echo $formula; ?>
            <?php } ?>

            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0">
                <?php foreach($referencias as $ref){ ?>
                  <li><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">A. Datos de entrada</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Peso</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="peso" value="">
                  <span class="input-group-text">kg</span>
                </div>

                <label class="form-label-lite">Natremia actual</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="naActual" value="">
                  <span class="input-group-text">mEq/L</span>
                </div>

                <label class="form-label-lite">Sexo / ACT estimada</label>
                <div class="choice-grid-2">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="tbwgrp" id="tbw_mujer" value="0.5" checked>
                    <label class="choice-btn" for="tbw_mujer">
                      <i class="fa-solid fa-person-dress"></i>
                      Mujer adulta
                      <small>ACT 50%</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="tbwgrp" id="tbw_hombre" value="0.6">
                    <label class="choice-btn" for="tbw_hombre">
                      <i class="fa-solid fa-person"></i>
                      Hombre adulto
                      <small>ACT 60%</small>
                    </label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Contexto clínico dominante</label>
                <div class="choice-grid-3 mb-3">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="contexto" id="ctx_hipovolemico" value="hipovolemico" checked>
                    <label class="choice-btn" for="ctx_hipovolemico">
                      <i class="fa-solid fa-droplet-slash"></i>
                      Hipovolémico
                      <small>pérdida de agua</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="contexto" id="ctx_euvolemico" value="euvolemico">
                    <label class="choice-btn" for="ctx_euvolemico">
                      <i class="fa-solid fa-scale-balanced"></i>
                      Euvolémico
                      <small>DI / pérdidas libres</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="contexto" id="ctx_hipervolemico" value="hipervolemico">
                    <label class="choice-btn" for="ctx_hipervolemico">
                      <i class="fa-solid fa-water"></i>
                      Hipervolémico
                      <small>exceso de sodio</small>
                    </label>
                  </div>
                </div>

                <label class="form-label-lite">Duración probable</label>
                <div class="choice-grid-2">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="cronologia" id="crono_aguda" value="aguda">
                    <label class="choice-btn" for="crono_aguda">
                      <i class="fa-solid fa-bolt"></i>
                      Aguda
                      <small>&lt;48 h</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="cronologia" id="crono_cronica" value="cronica" checked>
                    <label class="choice-btn" for="crono_cronica">
                      <i class="fa-solid fa-hourglass-half"></i>
                      Crónica / incierta
                      <small>idealmente &gt;48 h</small>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Método de reposición</div>

            <div class="choice-grid-4">
              <div>
                <input class="choice-check calc-trigger-radio" type="radio" name="solucion" id="sol_d5w" value="0" checked>
                <label class="choice-btn" for="sol_d5w">
                  <i class="fa-solid fa-flask-vial"></i>
                  Dextrosa 5%
                  <small>Na 0 mEq/L</small>
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger-radio" type="radio" name="solucion" id="sol_half" value="77">
                <label class="choice-btn" for="sol_half">
                  <i class="fa-solid fa-prescription-bottle-medical"></i>
                  NaCl 0,45%
                  <small>Na 77 mEq/L</small>
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger-radio" type="radio" name="solucion" id="sol_iso" value="154">
                <label class="choice-btn" for="sol_iso">
                  <i class="fa-solid fa-kit-medical"></i>
                  Isotónico
                  <small>Na 154 mEq/L</small>
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger-radio" type="radio" name="solucion" id="sol_enteral" value="0">
                <label class="choice-btn" for="sol_enteral">
                  <i class="fa-solid fa-glass-water"></i>
                  Agua enteral/VO
                  <small>agua libre</small>
                </label>
              </div>
            </div>

            <div class="small-note mt-3">
              El selector estima un plan matemático orientativo. No reemplaza la reevaluación clínica ni los controles seriados de Na.
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Tarjeta resumen</div>

            <div class="summary-grid">
              <div class="summary-card">
                <div class="summary-label">Peso</div>
                <div id="sumPeso" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Na actual</div>
                <div id="sumNa" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">ACT estimada</div>
                <div id="sumACT" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Solución elegida</div>
                <div id="sumSol" class="summary-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Resultado principal</div>

            <div class="result-main-card">
              <div class="result-main-label">Plan orientativo</div>
              <div class="result-main-note">Basado en ritmo seguro, déficit estimado y solución seleccionada</div>
              <div id="mainDecision" class="result-main-value">-</div>
            </div>

            <div class="mt-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Agua corporal total estimada</div>
                  <div class="result-note">Basada en la fracción de ACT seleccionada.</div>
                </div>
                <div id="outACT" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Meta inicial sugerida</div>
                  <div class="result-note">Objetivo conservador de primera etapa.</div>
                </div>
                <div id="outMeta" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Déficit de agua libre</div>
                  <div class="result-note">Cálculo orientativo. No reemplaza balance ni pérdidas en curso.</div>
                </div>
                <div id="outDeficit" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Velocidad máxima sugerida</div>
                  <div class="result-note">Depende de si el cuadro es agudo o crónico/incierto.</div>
                </div>
                <div id="outRate" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Cambio estimado de Na por litro</div>
                  <div class="result-note">Aproximación matemática con la solución elegida.</div>
                </div>
                <div id="outDeltaLiter" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Velocidad orientativa</div>
                  <div class="result-note">mL/h para no exceder la caída segura, si la solución sí baja Na.</div>
                </div>
                <div id="outInfusion" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Controles de Na durante corrección</div>
                  <div class="result-note">Frecuencia sugerida mientras exista corrección activa.</div>
                </div>
                <div id="outMonitoring" class="result-value">Cada 2–3 h</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Lectura clínica</div>

            <div id="riskBox" class="good-box">
              <strong id="riskTitle">Interpretación</strong><br>
              <div id="riskText" class="small-note mt-2">
                Completa peso y natremia para interpretar el riesgo y la estrategia de corrección.
              </div>
            </div>

            <div id="fluidBox" class="mint-box mt-3">
              <strong>Plan de corrección / fluidos</strong><br>
              <div id="fluidText" class="small-note mt-2">-</div>
            </div>

            <div id="mechanismBox" class="danger-box mt-3">
              <strong>Riesgos de corrección rápida y mecanismo fisiológico</strong><br>
              <div id="mechanismText" class="small-note mt-2">-</div>
            </div>

            <div id="pharmBox" class="warn-box mt-3">
              <strong>Interacciones anestésicas / farmacológicas relevantes</strong><br>
              <div id="pharmText" class="small-note mt-2">-</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">F. Tips docentes</div>

            <div class="warn-box">
              <ul class="tip-list">
                <li>En cirugía electiva, idealmente iniciar anestesia con sodio menor de 150 mEq/L.</li>
                <li>Entre 145–150 mEq/L no siempre hay que suspender, pero sí interpretar el contexto, el volumen y la urgencia.</li>
                <li>Si la hipernatremia es crónica o incierta, la corrección idealmente debe hacerse en más de 48 horas, no de forma brusca.</li>
                <li>Si hay hipovolemia, primero perfundir. Corregir agua libre en un paciente colapsado con soluciones muy hipotónicas es una mala idea.</li>
                <li>La Dextrosa 5% y el agua enteral son agua libre; NaCl 0,45% corrige más lentamente; el isotónico sirve sobre todo para reanimación inicial.</li>
                <li>La hipernatremia puede aumentar la MAC y la deshidratación puede hacer que la inducción IV tenga un efecto hemodinámico exagerado.</li>
                <li>Lo importante no es solo el cálculo, sino la natremia seriada. Si no controlas cada 2–3 horas durante corrección activa, vuelas a ciegas.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Verificar etiología, estado de volumen, osmolaridad, función renal, pérdidas en curso y controles seriados de sodio antes de definir una estrategia.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

function getSelected(name){
  const el = document.querySelector('input[name="' + name + '"]:checked');
  return el ? el.value : null;
}

function round1(n){ return Math.round(n * 10) / 10; }
function round2(n){ return Math.round(n * 100) / 100; }

function getSolutionLabel(solId){
  if(solId === 'sol_d5w') return 'Dextrosa 5% IV';
  if(solId === 'sol_half') return 'NaCl 0,45%';
  if(solId === 'sol_iso') return 'Isotónico';
  return 'Agua enteral/VO';
}

function updateHyperNa(){
  const peso = parseFloat(document.getElementById('peso').value);
  const naActual = parseFloat(document.getElementById('naActual').value);
  const tbwFrac = parseFloat(getSelected('tbwgrp') || '0.5');
  const contexto = getSelected('contexto') || 'hipovolemico';
  const cronologia = getSelected('cronologia') || 'cronica';
  const naInfusate = parseFloat(getSelected('solucion') || '0');
  const solId = document.querySelector('input[name="solucion"]:checked')?.id || 'sol_d5w';

  document.getElementById('sumPeso').textContent = (!isNaN(peso) && peso > 0) ? peso.toFixed(1) + ' kg' : '-';
  document.getElementById('sumNa').textContent = (!isNaN(naActual) && naActual > 0) ? naActual.toFixed(1) + ' mEq/L' : '-';
  document.getElementById('sumACT').textContent = (tbwFrac * 100).toFixed(0) + '%';
  document.getElementById('sumSol').textContent = getSolutionLabel(solId);

  if(isNaN(peso) || peso <= 0 || isNaN(naActual) || naActual <= 0){
    document.getElementById('mainDecision').textContent = '-';
    document.getElementById('outACT').textContent = '-';
    document.getElementById('outMeta').textContent = '-';
    document.getElementById('outDeficit').textContent = '-';
    document.getElementById('outRate').textContent = '-';
    document.getElementById('outDeltaLiter').textContent = '-';
    document.getElementById('outInfusion').textContent = '-';
    document.getElementById('riskTitle').textContent = 'Interpretación';
    document.getElementById('riskText').textContent = 'Completa peso y natremia para interpretar el riesgo y la estrategia de corrección.';
    document.getElementById('riskBox').className = 'good-box';
    document.getElementById('fluidText').textContent = '-';
    document.getElementById('mechanismText').textContent = '-';
    document.getElementById('pharmText').textContent = '-';
    return;
  }

  const act = peso * tbwFrac;

  let maxRateHour = 0.5;
  let maxRate24h = 8;
  if(cronologia === 'aguda'){
    maxRateHour = 1.5; // centro de rango 1-2
    maxRate24h = 10;
  }

  let metaInicial = naActual;
  const maxDropAllowed = maxRate24h;

  if(naActual >= 160){
    metaInicial = naActual - maxDropAllowed;
  } else if(naActual >= 150){
    metaInicial = Math.max(150, naActual - maxDropAllowed);
  } else if(naActual >= 145){
    metaInicial = Math.max(145, naActual - maxDropAllowed);
  }

  let deficit = 0;
  if(naActual > metaInicial){
    deficit = act * ((naActual / metaInicial) - 1);
  }

  const deltaNaPerL = (naInfusate - naActual) / (act + 1);

  let infusionMlH = null;
  let mainDecision = 'Valorar contexto';

  if(deltaNaPerL < 0){
    infusionMlH = (maxRateHour / Math.abs(deltaNaPerL)) * 1000;
    mainDecision = round1(infusionMlH).toString().replace('.', ',') + ' mL/h';
  } else if(deltaNaPerL === 0){
    mainDecision = 'No baja Na';
  } else {
    mainDecision = 'Puede subir Na';
  }

  document.getElementById('outACT').textContent = round1(act).toString().replace('.', ',') + ' L';
  document.getElementById('outMeta').textContent = round1(metaInicial).toString().replace('.', ',') + ' mEq/L';
  document.getElementById('outDeficit').textContent = round2(deficit).toString().replace('.', ',') + ' L';

  if(cronologia === 'aguda'){
    document.getElementById('outRate').innerHTML = '1–2 mEq/L/h<br><span class="small-note">máx 8–12 mEq/día</span>';
  } else {
    document.getElementById('outRate').innerHTML = '0,5–1 mEq/L/h<br><span class="small-note">máx 8 mEq/día • idealmente >48 h</span>';
  }

  document.getElementById('outDeltaLiter').textContent = round2(deltaNaPerL).toString().replace('.', ',') + ' mEq/L por L';

  if(infusionMlH !== null && isFinite(infusionMlH)){
    document.getElementById('outInfusion').innerHTML = round1(infusionMlH).toString().replace('.', ',') + ' mL/h<br><span class="small-note">ajustar con controles</span>';
  } else {
    document.getElementById('outInfusion').innerHTML = 'No aplica<br><span class="small-note">la solución no reduce Na</span>';
  }

  const riskBox = document.getElementById('riskBox');
  let riskTitle = 'Hipernatremia leve';
  let riskText = 'No siempre obliga a suspender un procedimiento si el valor está entre 145–150 mEq/L, pero requiere evaluación clínica y del estado de volumen.';
  let fluidText = '';
  let mechanismText = '';
  let pharmText = '';

  if(naActual < 145){
    riskTitle = 'No corresponde a hipernatremia';
    riskText = 'Este apunte fue diseñado para hipernatremia.';
    riskBox.className = 'mint-box';
    mainDecision = 'Revisar diagnóstico';
  } else if(naActual >= 145 && naActual < 150){
    riskTitle = 'Hipernatremia leve / zona gris';
    riskText = 'No necesariamente impide anestesia, pero sugiere hiperosmolaridad y posible deshidratación.';
    riskBox.className = 'warn-box';
  } else if(naActual >= 150 && naActual < 160){
    riskTitle = 'Hipernatremia significativa';
    riskText = 'Idealmente corregir antes de anestesia. La corrección debe ser gradual y monitorizada.';
    riskBox.className = 'danger-box';
  } else {
    riskTitle = 'Hipernatremia severa';
    riskText = 'Alto riesgo neurológico y cardiovascular. En general no es buena condición para anestesia no impostergable.';
    riskBox.className = 'danger-box';
  }

  if(contexto === 'hipovolemico'){
    if(solId === 'sol_iso'){
      fluidText = 'Buena elección para la fase inicial si el paciente está hipotenso o con mala perfusión. Pero esto no corrige bien el agua libre. Tras estabilizar, cambia a una estrategia que sí baje el sodio.';
    } else {
      fluidText = 'En hipovolemia, esta solución puede ser útil después de restaurar perfusión. Si el paciente está inestable, primero resucita con isotónico y luego corrige agua libre.';
    }
  } else if(contexto === 'euvolemico'){
    if(solId === 'sol_d5w' || solId === 'sol_enteral'){
      fluidText = 'Buena herramienta para corregir agua libre en un contexto euvolémico, siempre con control seriado de Na.';
    } else if(solId === 'sol_half'){
      fluidText = 'Opción razonable si quieres una corrección más gradual que con agua libre pura.';
    } else {
      fluidText = 'El isotónico no suele ser la herramienta de elección para bajar sodio en euvolemia.';
    }
  } else {
    if(solId === 'sol_d5w' || solId === 'sol_enteral'){
      fluidText = 'Puede ayudar a corregir el exceso relativo de sodio, pero en hipervolemia suele requerirse estrategia adicional para eliminar sodio y agua.';
    } else if(solId === 'sol_half'){
      fluidText = 'Puede ser útil, pero sigue aportando sodio. Interpreta con prudencia en hipervolemia.';
    } else {
      fluidText = 'El isotónico suele ser mala elección para corregir hipernatremia hipervolémica, salvo una razón hemodinámica muy concreta.';
    }
  }

  if(solId === 'sol_iso' && deltaNaPerL >= 0){
    mainDecision = 'No usar para bajar Na';
  }

  if(solId === 'sol_half' && infusionMlH !== null && infusionMlH > 350){
    mainDecision = 'Velocidad alta';
  }

  if(solId === 'sol_d5w' && infusionMlH !== null && infusionMlH > 250){
    mainDecision = 'Corregir lento y monitorizar';
  }

  if(cronologia === 'cronica'){
    fluidText += ' Al ser crónica o incierta, idealmente planifica la corrección en más de 48 horas.';
  }

  mechanismText = 'En hipernatremia crónica, el cerebro acumula osmoles idiogénicos para defender su volumen. Si bajas el sodio demasiado rápido, el agua entra bruscamente a las neuronas, provocando edema cerebral, aumento de la presión intracraneana, convulsiones y eventualmente herniación. Por eso la corrección lenta no es un capricho: es protección cerebral.';

  pharmText = 'La hipernatremia puede aumentar la MAC de los halogenados. Si además hay deshidratación, una dosis estándar de propofol o tiopental puede producir una hipotensión desproporcionada por menor volumen de distribución y mayor labilidad hemodinámica. La menor perfusión renal puede prolongar el efecto de relajantes, y la hiperosmolaridad puede modificar la respuesta a anestésicos locales.';

  if(contexto === 'hipovolemico'){
    pharmText += ' En el hipovolémico, la inducción es especialmente delicada por riesgo de colapso hemodinámico.';
  }

  if(cronologia === 'aguda'){
    pharmText += ' Si realmente es aguda, el cerebro aún no ha desarrollado del todo mecanismos compensadores, por lo que puede tolerar una corrección más rápida que en la forma crónica.';
  }

  document.getElementById('mainDecision').textContent = mainDecision;
  document.getElementById('riskTitle').textContent = riskTitle;
  document.getElementById('riskText').textContent = riskText;
  document.getElementById('fluidText').textContent = fluidText;
  document.getElementById('mechanismText').textContent = mechanismText;
  document.getElementById('pharmText').textContent = pharmText;
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', updateHyperNa);
    el.addEventListener('change', updateHyperNa);
  });

  document.querySelectorAll('.calc-trigger-radio').forEach(el => {
    el.addEventListener('change', updateHyperNa);
  });

  updateHyperNa();
});
</script>

<?php require("footer.php"); ?>