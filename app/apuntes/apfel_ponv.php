<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "El score de Apfel permite estimar el riesgo de náuseas y vómitos postoperatorios (NVPO) en adultos y orientar una estrategia profiláctica rápida.";
$formula = "Apfel = sexo femenino + no fumador + antecedente de NVPO/cinetosis + uso esperado de opioides postoperatorios";
$referencias = array(
  "1.- Apfel CC, Läärä E, Koivuranta M, Greim CA, Roewer N. A simplified risk score for predicting postoperative nausea and vomiting. Anesthesiology. 1999 Sep;91(3):693-700.",
  "2.- Gan TJ. Risk factors for postoperative nausea and vomiting. Anesth Analg. 2006;102:1884–1898."
);

$icono_apunte = "<i class='fa-solid fa-face-dizzy pe-3 pt-2'></i>";
$titulo_apunte = "Score de Apfel (NVPO / PONV)";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apfel-shell">

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

          .apfel-shell{
            max-width:980px;
            margin:0 auto;
          }

          .apfel-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .apfel-topbar h1{
            color:#fff;
          }

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

          .risk-check{
            display:flex;
            align-items:flex-start;
            gap:.85rem;
            padding:1rem;
            border:1px solid #e7ebf2;
            border-radius:1rem;
            background:#f8fafc;
            transition:.15s ease;
          }

          .risk-check.active{
            background:#edf4ff;
            border-color:#bfd2ff;
          }

          .risk-check input{
            width:1.25rem;
            height:1.25rem;
            margin-top:.12rem;
            flex:0 0 auto;
          }

          .risk-label{
            font-weight:600;
            color:var(--text);
            line-height:1.25;
          }

          .result-box{
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
            padding:1rem;
          }

          .result-main{
            font-size:1.1rem;
            font-weight:700;
            color:var(--text);
          }

          .result-score{
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
            padding:.65rem .8rem;
            border-radius:.85rem;
            background:#fff;
            border:1px solid #e6e9ef;
            margin-bottom:.55rem;
          }

          .drug-line:last-child{
            margin-bottom:0;
          }

          .small-note{
            font-size:.84rem;
            color:var(--muted);
          }

          .footer-note{
            font-size:.82rem;
            color:#6c757d;
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

          @media (max-width:576px){
            .risk-check{
              padding:.9rem;
            }

            .result-score{
              font-size:1.8rem;
            }

            .info-box-header{
              flex-direction:row;
            }

            .info-toggle-btn{
              margin-left:auto;
            }
          }
        </style>

        <div class="apfel-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Score de Apfel / NVPO</h1>
              <div class="subtle text-white-50">Checklist rápido para estimar riesgo de náuseas y vómitos postoperatorios en adultos.</div>
            </div>
            <span class="pill bg-light text-dark">Adultos</span>
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

        <div class="section-card bg-white mb-3">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Factores de riesgo</div>

            <div class="d-grid gap-2">
              <label class="risk-check" id="wrap_sexo">
                <input class="form-check-input apfel-check" type="checkbox" id="sexo">
                <div>
                  <div class="risk-label">Sexo femenino</div>
                  <div class="small-note">Factor predictor clásico del score de Apfel.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_fumador">
                <input class="form-check-input apfel-check" type="checkbox" id="fumador">
                <div>
                  <div class="risk-label">No fumador</div>
                  <div class="small-note">El tabaquismo se asocia a menor riesgo relativo de NVPO.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_historia">
                <input class="form-check-input apfel-check" type="checkbox" id="historia">
                <div>
                  <div class="risk-label">Antecedente de NVPO o cinetosis</div>
                  <div class="small-note">Incluye historia previa de náuseas/vómitos postoperatorios o mareo por movimiento.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_opioides">
                <input class="form-check-input apfel-check" type="checkbox" id="opioides">
                <div>
                  <div class="risk-label">Uso esperado de opioides postoperatorios</div>
                  <div class="small-note">Considera analgesia postoperatoria con opioides sistémicos.</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="section-card bg-white mb-3">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado</div>

            <div class="result-box">
              <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                <div>
                  <div class="small-note">Puntaje</div>
                  <div id="scoreText" class="result-main">0 factores de riesgo</div>
                </div>
                <div id="scoreNum" class="result-score">0</div>
              </div>

              <div id="riskPercent" class="result-main mb-2">Riesgo estimado: 10%</div>
              <div id="riskInterpretation" class="subtle">Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.</div>
            </div>
          </div>
        </div>

        <div class="section-card bg-white mb-3">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Mini algoritmo de profilaxis</div>

            <div id="algoBox" class="algo-box algo-low">
              <div id="algoRisk" class="fw-semibold mb-2">Estrategia sugerida</div>

              <div id="drugPlan">
                <div class="drug-line">Sin profilaxis rutinaria en pacientes de bajo riesgo.</div>
              </div>

              <div id="algoExtra" class="small-note mt-3">
                Reevaluar si aparecen nuevos factores intraoperatorios o si el contexto clínico cambia.
              </div>
            </div>
          </div>
        </div>

        <div class="section-card bg-white mb-3">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Rescate orientativo si presenta NVPO</div>

            <div id="rescueText" class="subtle">
              Si recibió profilaxis, idealmente usar en rescate un fármaco de otra clase distinta a la ya administrada.
            </div>
          </div>
        </div>

        <div class="footer-note">
          Este módulo utiliza el score de Apfel para NVPO en adultos y una estrategia escalonada simplificada como apoyo clínico.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function () {
  const checks = Array.from(document.querySelectorAll('.apfel-check'));

  function updateVisualChecks() {
    checks.forEach(ch => {
      const wrap = document.getElementById('wrap_' + ch.id);
      if (wrap) wrap.classList.toggle('active', ch.checked);
    });
  }

  function calcularApfel() {
    const sexo = document.getElementById('sexo').checked ? 1 : 0;
    const fumador = document.getElementById('fumador').checked ? 1 : 0;
    const historia = document.getElementById('historia').checked ? 1 : 0;
    const opioides = document.getElementById('opioides').checked ? 1 : 0;

    const score = sexo + fumador + historia + opioides;

    const scoreNum = document.getElementById('scoreNum');
    const scoreText = document.getElementById('scoreText');
    const riskPercent = document.getElementById('riskPercent');
    const riskInterpretation = document.getElementById('riskInterpretation');
    const algoBox = document.getElementById('algoBox');
    const algoRisk = document.getElementById('algoRisk');
    const drugPlan = document.getElementById('drugPlan');
    const algoExtra = document.getElementById('algoExtra');
    const rescueText = document.getElementById('rescueText');

    scoreNum.textContent = score;
    scoreText.textContent = score + (score === 1 ? ' factor de riesgo' : ' factores de riesgo');

    algoBox.classList.remove('algo-low', 'algo-mid', 'algo-high');

    if (score === 0) {
      riskPercent.textContent = 'Riesgo estimado: 10%';
      riskInterpretation.textContent = 'Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.';
      algoBox.classList.add('algo-low');
      algoRisk.textContent = 'Bajo riesgo';
      drugPlan.innerHTML = `
        <div class="drug-line">Sin profilaxis rutinaria.</div>
      `;
      algoExtra.textContent = 'Optimizar medidas generales: hidratación, minimizar opioides si es posible.';
      rescueText.textContent = 'Si presenta NVPO, usar un antiemético de rescate según contexto clínico.';
    }
    else if (score === 1) {
      riskPercent.textContent = 'Riesgo estimado: 20%';
      riskInterpretation.textContent = 'Riesgo bajo-moderado. Puede considerarse profilaxis simple.';
      algoBox.classList.add('algo-low');
      algoRisk.textContent = 'Riesgo bajo-moderado';
      drugPlan.innerHTML = `
        <div class="drug-line"><strong>1ª línea:</strong> Dexametasona 4 mg IV.</div>
      `;
      algoExtra.textContent = 'Útil si el contexto quirúrgico o el equipo clínico prefieren una estrategia preventiva.';
      rescueText.textContent = 'Si recibió dexametasona y hace NVPO, el rescate debe idealmente usar otra clase, por ejemplo ondansetron.';
    }
    else if (score === 2) {
      riskPercent.textContent = 'Riesgo estimado: 40%';
      riskInterpretation.textContent = 'Riesgo moderado. Se recomienda profilaxis combinada.';
      algoBox.classList.add('algo-mid');
      algoRisk.textContent = 'Riesgo moderado';
      drugPlan.innerHTML = `
        <div class="drug-line"><strong>1ª línea:</strong> Dexametasona 4 mg IV.</div>
        <div class="drug-line"><strong>2ª línea:</strong> Ondansetron 4 mg IV.</div>
      `;
      algoExtra.textContent = 'Estrategia razonable de dos fármacos en clases distintas.';
      rescueText.textContent = 'Si recibió dexametasona + ondansetron y presenta NVPO, considerar rescate con otra clase, por ejemplo droperidol si no está contraindicado.';
    }
    else if (score === 3) {
      riskPercent.textContent = 'Riesgo estimado: 60%';
      riskInterpretation.textContent = 'Riesgo alto. Se recomienda profilaxis múltiple.';
      algoBox.classList.add('algo-high');
      algoRisk.textContent = 'Riesgo alto';
      drugPlan.innerHTML = `
        <div class="drug-line"><strong>1ª línea:</strong> Dexametasona 4 mg IV.</div>
        <div class="drug-line"><strong>2ª línea:</strong> Ondansetron 4 mg IV.</div>
        <div class="drug-line"><strong>3ª línea:</strong> Droperidol 0,625–1 mg IV.</div>
      `;
      algoExtra.textContent = 'Conviene además usar técnica anestésica que disminuya el riesgo, cuando sea posible.';
      rescueText.textContent = 'Si ya recibió estas clases, el rescate no debería repetir de entrada el mismo grupo farmacológico.';
    }
    else {
      riskPercent.textContent = 'Riesgo estimado: 80%';
      riskInterpretation.textContent = 'Riesgo muy alto. Requiere profilaxis multimodal agresiva.';
      algoBox.classList.add('algo-high');
      algoRisk.textContent = 'Riesgo muy alto';
      drugPlan.innerHTML = `
        <div class="drug-line"><strong>1ª línea:</strong> Dexametasona 4 mg IV.</div>
        <div class="drug-line"><strong>2ª línea:</strong> Ondansetron 4 mg IV.</div>
        <div class="drug-line"><strong>3ª línea:</strong> Droperidol 0,625–1 mg IV.</div>
      `;
      algoExtra.textContent = 'Además considerar TIVA, minimizar opioides y reforzar estrategia multimodal preventiva.';
      rescueText.textContent = 'Si pese a la profilaxis presenta NVPO, rescatar con un antiemético de distinta clase a los ya usados y reevaluar causas contribuyentes.';
    }

    updateVisualChecks();
  }

  checks.forEach(el => {
    el.addEventListener('change', calcularApfel);
  });

  calcularApfel();
})();
</script>

<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php
require("footer.php");
?>
