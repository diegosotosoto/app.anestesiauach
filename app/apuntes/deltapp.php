<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "El Delta de Presión de Pulso (Delta PP o PPV) es una herramienta dinámica para predecir respuesta a volumen en pacientes con ventilación mecánica. Un valor alto sugiere probabilidad de respuesta a fluidos, pero solo es interpretable si se cumplen criterios estrictos de validez.";
$formula = "Delta PP = (PPmáx - PPmín) / ((PPmáx + PPmín) / 2) × 100";
$referencias = array(
  "1.- Hofer CK, Müller SM, Furrer L, Klaghofer R, Genoni M, Zollinger A. Stroke volume and pulse pressure variation for prediction of fluid responsiveness in patients undergoing off-pump coronary artery bypass grafting. Chest. 2005;128(2):848-854.",
  "2.- Mahjoub Y, Lejeune V, Muller L, et al. Evaluation of pulse pressure variation validity criteria in critically ill patients: a prospective observational multicentre point-prevalence study. Br J Anaesth. 2014;112(4):681-685.",
  "3.- Michard F, Boussat S, Chemla D, et al. Relation between respiratory changes in arterial pulse pressure and fluid responsiveness in septic patients with acute circulatory failure. Am J Respir Crit Care Med. 2000;162(1):134-138."
);

$icono_apunte = "<i class='fa-solid fa-wave-square pe-3 pt-2'></i>";
$titulo_apunte = "Delta PP";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="dpp-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --bg:#f4f7fb;
            --card:#ffffff;
            --soft:#f8fafc;
            --line:#dfe7f2;
            --text:#1f2a37;
            --muted:#667085;
            --good:#edf8f7;
            --warn:#fff9e8;
            --danger:#fff5f3;
          }

          body{background:var(--bg);}

          .dpp-shell{
            max-width:980px;
            margin:0 auto;
          }

          .dpp-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .dpp-topbar h1{color:#fff;}

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

          .subtle{
            font-size:.94rem;
            color:#5f6b76;
          }

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

          .input-card, .result-card{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .result-box{
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
            padding:1rem;
          }

          .result-main{
            font-size:1.08rem;
            font-weight:700;
            color:var(--text);
          }

          .result-num{
            font-size:2rem;
            font-weight:800;
            line-height:1;
            color:#3559b7;
          }

          .algo-box{
            border-radius:1rem;
            padding:1rem;
            border:1px solid var(--line);
          }

          .algo-low{background:var(--good);}
          .algo-mid{background:var(--warn);}
          .algo-high{background:var(--danger);}

          .drug-line{
            padding:.7rem .8rem;
            border-radius:.85rem;
            background:#fff;
            border:1px solid #e6e9ef;
            margin-bottom:.55rem;
          }

          .drug-line:last-child{margin-bottom:0;}

          .validity-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.75rem;
          }

          .validity-item{
            display:flex;
            align-items:flex-start;
            gap:.75rem;
            padding:.9rem;
            border-radius:1rem;
            border:1px solid #e7ebf2;
            background:#f8fafc;
          }

          .validity-item.bad{
            background:#fff5f3;
            border-color:#f3c2bd;
          }

          .small-note{
            font-size:.84rem;
            color:var(--muted);
          }

          .footer-note{
            font-size:.82rem;
            color:#6c757d;
          }

          @media (max-width:768px){
            .calc-grid, .validity-grid{
              grid-template-columns:1fr;
            }
          }

          @media (max-width:576px){
            .info-box-header{
              flex-direction:row;
            }
            .info-toggle-btn{
              margin-left:auto;
            }
            .result-num{
              font-size:1.8rem;
            }
          }
        </style>

        <div class="dpp-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Delta PP</h1>
              <div class="subtle text-white-50">Estimación de respuesta a volumen basada en variación respiratoria de la presión de pulso.</div>
            </div>
            <span class="pill bg-light text-dark">Hemodinámica</span>
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

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Datos de entrada</div>

            <div class="calc-grid">
              <div class="input-card">
                <label class="form-label fw-semibold">Sistólica máxima</label>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" id="s_max" value="120" oninput="calcularDeltaPP()">
                  <span class="input-group-text">mmHg</span>
                </div>

                <label class="form-label fw-semibold">Diastólica máxima</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="d_max" value="70" oninput="calcularDeltaPP()">
                  <span class="input-group-text">mmHg</span>
                </div>
              </div>

              <div class="input-card">
                <label class="form-label fw-semibold">Sistólica mínima</label>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" id="s_min" value="100" oninput="calcularDeltaPP()">
                  <span class="input-group-text">mmHg</span>
                </div>

                <label class="form-label fw-semibold">Diastólica mínima</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="d_min" value="65" oninput="calcularDeltaPP()">
                  <span class="input-group-text">mmHg</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado</div>

            <div class="calc-grid">
              <div class="result-card">
                <div class="small-note">PP máxima</div>
                <div id="ppMax" class="result-main">50 mmHg</div>
              </div>

              <div class="result-card">
                <div class="small-note">PP mínima</div>
                <div id="ppMin" class="result-main">35 mmHg</div>
              </div>
            </div>

            <div class="result-box mt-3">
              <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                  <div class="small-note">Delta PP</div>
                  <div id="interpretacion" class="result-main">Respondedor a volumen</div>
                </div>
                <div id="deltaPP" class="result-num">35.29%</div>
              </div>
              <div id="riskText" class="subtle mt-2">Valor claramente elevado, compatible con alta probabilidad de respuesta a volumen si el índice es válido.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Interpretación y manejo</div>

            <div id="algoBox" class="algo-box algo-high">
              <div id="algoTitle" class="fw-semibold mb-2">Conducta sugerida</div>

              <div id="algoPlan">
                <div class="drug-line">Delta PP > 12–13%: probable respondedor a volumen, si se cumplen criterios de validez.</div>
              </div>

              <div id="algoExtra" class="small-note mt-3">
                Un Delta PP alto no obliga automáticamente a aportar volumen: debe integrarse con contexto clínico, perfusión y riesgos del paciente.
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Requisitos para que el Delta PP sea fiable</div>

            <div class="validity-grid">
              <div class="validity-item">
                <input class="form-check-input mt-1" type="checkbox" checked disabled>
                <div>
                  <div class="fw-semibold">Tórax cerrado</div>
                  <div class="small-note">Pierde confiabilidad con tórax abierto.</div>
                </div>
              </div>

              <div class="validity-item">
                <input class="form-check-input mt-1" type="checkbox" checked disabled>
                <div>
                  <div class="fw-semibold">Ventilación mecánica controlada</div>
                  <div class="small-note">Idealmente sin respiración espontánea significativa.</div>
                </div>
              </div>

              <div class="validity-item">
                <input class="form-check-input mt-1" type="checkbox" checked disabled>
                <div>
                  <div class="fw-semibold">Volumen corriente ≥ 8 ml/kg</div>
                  <div class="small-note">Volúmenes bajos disminuyen sensibilidad del índice.</div>
                </div>
              </div>

              <div class="validity-item">
                <input class="form-check-input mt-1" type="checkbox" checked disabled>
                <div>
                  <div class="fw-semibold">Ritmo sinusal</div>
                  <div class="small-note">Las arritmias invalidan o distorsionan la medición.</div>
                </div>
              </div>

              <div class="validity-item">
                <input class="form-check-input mt-1" type="checkbox" checked disabled>
                <div>
                  <div class="fw-semibold">Paciente en decúbito supino</div>
                  <div class="small-note">Cambios posturales pueden alterar la interpretación.</div>
                </div>
              </div>

              <div class="validity-item bad">
                <input class="form-check-input mt-1" type="checkbox" disabled>
                <div>
                  <div class="fw-semibold">No usar si:</div>
                  <div class="small-note">Respira espontáneamente, tiene PEEP/tidal muy particulares, tórax abierto, hipertensión intraabdominal relevante o disfunción VD importante.</div>
                </div>
              </div>
            </div>

            <div class="small-note mt-3">
              El Delta PP es una herramienta útil, pero solo dentro de su contexto fisiológico de validez.
            </div>
          </div>
        </div>

        <div class="footer-note">
          Este módulo calcula Delta PP y orienta interpretación clínica simplificada. No reemplaza juicio clínico integral ni otras herramientas de evaluación de respuesta a fluidos.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function calcularDeltaPP(){
  const sMax = parseFloat(document.getElementById('s_max').value);
  const dMax = parseFloat(document.getElementById('d_max').value);
  const sMin = parseFloat(document.getElementById('s_min').value);
  const dMin = parseFloat(document.getElementById('d_min').value);

  if([sMax,dMax,sMin,dMin].some(v => isNaN(v))){
    return;
  }

  const ppMax = sMax - dMax;
  const ppMin = sMin - dMin;
  const delta = ((ppMax - ppMin) / ((ppMax + ppMin) / 2)) * 100;

  document.getElementById('ppMax').textContent = ppMax.toFixed(0) + ' mmHg';
  document.getElementById('ppMin').textContent = ppMin.toFixed(0) + ' mmHg';
  document.getElementById('deltaPP').textContent = delta.toFixed(2) + '%';

  const interpretacion = document.getElementById('interpretacion');
  const riskText = document.getElementById('riskText');
  const algoBox = document.getElementById('algoBox');
  const algoTitle = document.getElementById('algoTitle');
  const algoPlan = document.getElementById('algoPlan');
  const algoExtra = document.getElementById('algoExtra');

  algoBox.classList.remove('algo-low','algo-mid','algo-high');

  if(delta > 12){
    interpretacion.textContent = 'Respondedor a volumen';
    riskText.textContent = 'Valor compatible con alta probabilidad de respuesta a volumen si el índice es válido.';
    algoBox.classList.add('algo-high');
    algoTitle.textContent = 'Conducta sugerida';
    algoPlan.innerHTML = `
      <div class="drug-line"><strong>Delta PP > 12–13%:</strong> probable respondedor a volumen.</div>
      <div class="drug-line">Si el paciente presenta hipoperfusión y se cumplen criterios de validez, considerar prueba de volumen o estrategia dinámica equivalente.</div>
    `;
    algoExtra.textContent = 'Integra este hallazgo con contexto hemodinámico, sangrado, ecocardiografía y riesgo de sobrecarga.';
  } else if(delta >= 9 && delta <= 12){
    interpretacion.textContent = 'Zona gris';
    riskText.textContent = 'Interpretación intermedia. No clasifica con seguridad como respondedor o no respondedor.';
    algoBox.classList.add('algo-mid');
    algoTitle.textContent = 'Conducta sugerida';
    algoPlan.innerHTML = `
      <div class="drug-line"><strong>Delta PP 9–12%:</strong> zona intermedia o gris.</div>
      <div class="drug-line">Considerar otras maniobras dinámicas: elevación pasiva de piernas, prueba de volumen pequeña, eco o variación de volumen sistólico.</div>
    `;
    algoExtra.textContent = 'Evita tomar decisiones solo con este rango sin integrar otros datos.';
  } else {
    interpretacion.textContent = 'No respondedor a volumen';
    riskText.textContent = 'Valor bajo, poco compatible con respuesta a fluidos si el índice es válido.';
    algoBox.classList.add('algo-low');
    algoTitle.textContent = 'Conducta sugerida';
    algoPlan.innerHTML = `
      <div class="drug-line"><strong>Delta PP < 9%:</strong> poco probable respondedor a volumen.</div>
      <div class="drug-line">Si persiste inestabilidad, buscar otras causas: vasodilatación, disfunción miocárdica, obstrucción, sangrado no evaluado, etc.</div>
    `;
    algoExtra.textContent = 'Un valor bajo no excluye hipoperfusión por otras causas.';
  }
}

function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

calcularDeltaPP();
</script>

<?php
require("footer.php");
?>
