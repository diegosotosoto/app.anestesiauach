<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "El score de Eberhart permite estimar el riesgo de vómitos postoperatorios en niños y orientar una estrategia profiláctica rápida.";
$formula = "Eberhart = edad >3 años + cirugía >30 min + cirugía de estrabismo + antecedente personal/familiar de POV-PONV";
$referencias = array(
  "1.- Eberhart LH, Geldner G, Kranke P, Morin AM, Schäuffelen A, Treiber H, Wulf H. The development and validation of a risk score to predict the probability of postoperative vomiting in pediatric patients. Anesth Analg. 2004;99(6):1630-1637.",
  "2.- Gan TJ, et al. Consensus guidelines for the management of postoperative nausea and vomiting.",
  "3.- Validaciones pediátricas posteriores en cirugía no oftalmológica."
);

$icono_apunte = "<i class='fa-solid fa-face-dizzy pe-3 pt-2'></i>";
$titulo_apunte = "Score de Eberhart / POV pediátrico";

$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Apuntes</span>";
$boton_navbar="
<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>
";

require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="eberhart-shell">

        <style>
          .eberhart-shell{max-width:980px;margin:0 auto;}
          .eberhart-topbar{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
          }
          .eberhart-topbar h1{color:#fff;}
          .subtle{font-size:.94rem;color:#5f6b76;}
          .pill{
            display:inline-block;
            padding:.2rem .55rem;
            border-radius:999px;
            font-size:.78rem;
            background:#eef3ff;
            color:#3559b7;
            font-weight:600;
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
            color:#667085;
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
            color:#1f2a37;
            line-height:1.25;
          }
          .result-box{
            border-radius:1rem;
            border:1px solid #dfe7f2;
            background:#f8fafc;
            padding:1rem;
          }
          .result-main{
            font-size:1.1rem;
            font-weight:700;
            color:#1f2a37;
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
            border:1px solid #dfe7f2;
          }
          .algo-low{background:#edf8f7;}
          .algo-mid{background:#fff9e8;}
          .algo-high{background:#fff5f3;}
          .drug-line{
            padding:.65rem .8rem;
            border-radius:.85rem;
            background:#fff;
            border:1px solid #e6e9ef;
            margin-bottom:.55rem;
          }
          .drug-line:last-child{margin-bottom:0;}
          .small-note{
            font-size:.84rem;
            color:#667085;
          }
          .other-risk{
            padding:.8rem .9rem;
            border-radius:.9rem;
            background:#f8fafc;
            border:1px solid #e6e9ef;
            margin-bottom:.55rem;
          }
          .references-card{
            display:none;
          }
          .references-card ul{
            line-height:1.5;
            color:#667085;
            padding-left:1.1rem;
          }
          @media (max-width:576px){
            .risk-check{padding:.9rem;}
            .result-score{font-size:1.8rem;}
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

        <div class="eberhart-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Score de Eberhart / POV pediátrico</h1>
              <div class="subtle text-white-50">Checklist rápido para estimar riesgo de vómitos postoperatorios en niños.</div>
            </div>
            <div class="d-flex align-items-start gap-2">
              <span class="pill bg-light text-dark">Pediatría</span>

            </div>
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
  </div>
</div>




        <div id="referenciasBox" class="section-card references-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Referencias</div>
            <ul class="mb-0">
              <?php foreach($referencias as $ref){ ?>
                <li class="mb-2"><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Factores de riesgo</div>

            <div class="d-grid gap-2">
              <label class="risk-check" id="wrap_edad">
                <input class="form-check-input eberhart-check" type="checkbox" id="edad">
                <div>
                  <div class="risk-label">Edad &gt; 3 años</div>
                  <div class="small-note">Factor incluido en la clasificación original.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_duracion">
                <input class="form-check-input eberhart-check" type="checkbox" id="duracion">
                <div>
                  <div class="risk-label">Duración quirúrgica &gt; 30 min</div>
                  <div class="small-note">Mayor exposición anestésica, mayor riesgo.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_estrabismo">
                <input class="form-check-input eberhart-check" type="checkbox" id="estrabismo">
                <div>
                  <div class="risk-label">Cirugía de estrabismo</div>
                  <div class="small-note">Factor clásico pediátrico de alto peso.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_historia">
                <input class="form-check-input eberhart-check" type="checkbox" id="historia">
                <div>
                  <div class="risk-label">Antecedente de POV / familiar con POV-PONV</div>
                  <div class="small-note">Incluye antecedente personal o familiar relevante.</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="section-card">
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

              <div id="riskPercent" class="result-main mb-2">Riesgo estimado: 9%</div>
              <div id="riskInterpretation" class="subtle">Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Mini algoritmo de profilaxis</div>

            <div id="algoBox" class="algo-box algo-low">
              <div id="algoRisk" class="fw-semibold mb-2">Estrategia sugerida</div>

              <div id="drugPlan">
                <div class="drug-line">Sin profilaxis rutinaria en pacientes de muy bajo riesgo.</div>
              </div>

              <div id="algoExtra" class="small-note mt-3">
                Reevaluar si existen otros factores pediátricos no incluidos en el score.
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Rescate orientativo</div>
            <div id="rescueText" class="subtle">
              Si recibió profilaxis, idealmente usar en rescate un fármaco de otra clase distinta a la ya administrada. Opciones habituales: droperidol o metoclopramida, según contexto clínico.
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Otros factores relevantes en niños</div>

            <div class="other-risk"><strong>Cirugía:</strong> apendicectomía, amigdalectomía y otras cirugías con mayor riesgo.</div>
            <div class="other-risk"><strong>Fármacos:</strong> ketamina, halogenados, opioides y neostigmina pueden aumentar el riesgo.</div>
            <div class="other-risk"><strong>Otros:</strong> dolor y movimientos también favorecen POV.</div>
            <div class="other-risk"><strong>Ingesta oral:</strong> no se ha asociado claramente como factor de riesgo.</div>
            <div class="other-risk"><strong>Fluidos EV intraoperatorios:</strong> pueden actuar como factor protector.</div>
          </div>
        </div>

        <div class="small text-muted">
          Dosis profilácticas orientativas: Dexametasona 0,15 mg/kg; Ondansetron 0,1 mg/kg; Droperidol 10 mcg/kg (máximo 1,25 mg). Ajustar a contexto clínico, edad, peso y contraindicaciones.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleReferencias(e){
  if(e) e.preventDefault();
  const box = document.getElementById('referenciasBox');
  if(box.style.display === 'none' || box.style.display === ''){
    box.style.display = 'block';
    box.scrollIntoView({behavior:'smooth', block:'start'});
  } else {
    box.style.display = 'none';
  }
}

(function () {
  const checks = Array.from(document.querySelectorAll('.eberhart-check'));

  function updateVisualChecks() {
    checks.forEach(ch => {
      const wrap = document.getElementById('wrap_' + ch.id);
      if (wrap) wrap.classList.toggle('active', ch.checked);
    });
  }

  function calcularEberhart() {
    const edad = document.getElementById('edad').checked ? 1 : 0;
    const duracion = document.getElementById('duracion').checked ? 1 : 0;
    const estrabismo = document.getElementById('estrabismo').checked ? 1 : 0;
    const historia = document.getElementById('historia').checked ? 1 : 0;
    const score = edad + duracion + estrabismo + historia;

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
      riskPercent.textContent = 'Riesgo estimado: 9%';
      riskInterpretation.textContent = 'Riesgo bajo. Profilaxis rutinaria habitualmente no necesaria.';
      algoBox.classList.add('algo-low');
      algoRisk.textContent = 'Bajo riesgo';
      drugPlan.innerHTML = `<div class="drug-line">Sin profilaxis rutinaria.</div>`;
      algoExtra.textContent = 'Si hay otros factores pediátricos relevantes, puedes escalar la profilaxis.';
      rescueText.textContent = 'Si presenta POV, considerar rescate con una clase antiemética apropiada según el contexto clínico.';
    } else if (score === 1) {
      riskPercent.textContent = 'Riesgo estimado: 10%';
      riskInterpretation.textContent = 'Riesgo bajo-moderado. Puede considerarse profilaxis simple.';
      algoBox.classList.add('algo-low');
      algoRisk.textContent = 'Riesgo bajo-moderado';
      drugPlan.innerHTML = `<div class="drug-line"><strong>Profilaxis simple:</strong> Dexametasona 0,15 mg/kg <em>o</em> Ondansetron 0,1 mg/kg.</div>`;
      algoExtra.textContent = 'En cirugía de mayor riesgo clínico, puedes optar por estrategia más intensiva.';
      rescueText.textContent = 'Si recibió dexametasona, el rescate idealmente debiera ser con otra clase, por ejemplo ondansetron. Si recibió ondansetron, considerar otra clase en rescate.';
    } else if (score === 2) {
      riskPercent.textContent = 'Riesgo estimado: 30%';
      riskInterpretation.textContent = 'Riesgo moderado. Se recomienda profilaxis doble.';
      algoBox.classList.add('algo-mid');
      algoRisk.textContent = 'Riesgo moderado';
      drugPlan.innerHTML = `
        <div class="drug-line"><strong>1ª línea:</strong> Dexametasona 0,15 mg/kg.</div>
        <div class="drug-line"><strong>2ª línea:</strong> Ondansetron 0,1 mg/kg.</div>
      `;
      algoExtra.textContent = 'Esto es especialmente razonable en cirugías con mayor riesgo emetógeno.';
      rescueText.textContent = 'Si ya recibió dexametasona + ondansetron y presenta POV, usar rescate con otra clase, por ejemplo droperidol o metoclopramida según el contexto.';
    } else if (score === 3) {
      riskPercent.textContent = 'Riesgo estimado: 55%';
      riskInterpretation.textContent = 'Riesgo alto. Requiere profilaxis intensiva.';
      algoBox.classList.add('algo-high');
      algoRisk.textContent = 'Riesgo alto';
      drugPlan.innerHTML = `
        <div class="drug-line"><strong>1ª línea:</strong> Dexametasona 0,15 mg/kg.</div>
        <div class="drug-line"><strong>2ª línea:</strong> Ondansetron 0,1 mg/kg.</div>
        <div class="drug-line"><strong>3ª línea:</strong> Considerar Droperidol 10 mcg/kg (máx. 1,25 mg).</div>
      `;
      algoExtra.textContent = 'Además conviene minimizar opioides y otros desencadenantes cuando sea posible.';
      rescueText.textContent = 'Si recibió profilaxis múltiple, el rescate no debería repetir de entrada el mismo grupo farmacológico.';
    } else {
      riskPercent.textContent = 'Riesgo estimado: 70%';
      riskInterpretation.textContent = 'Riesgo muy alto. Requiere profilaxis multimodal agresiva.';
      algoBox.classList.add('algo-high');
      algoRisk.textContent = 'Riesgo muy alto';
      drugPlan.innerHTML = `
        <div class="drug-line"><strong>1ª línea:</strong> Dexametasona 0,15 mg/kg.</div>
        <div class="drug-line"><strong>2ª línea:</strong> Ondansetron 0,1 mg/kg.</div>
        <div class="drug-line"><strong>3ª línea:</strong> Droperidol 10 mcg/kg (máx. 1,25 mg).</div>
      `;
      algoExtra.textContent = 'Considerar además reducción de halogenados, opioides y otros factores favorecedores.';
      rescueText.textContent = 'Si pese a la profilaxis presenta POV, rescatar con clase distinta a las ya utilizadas y reevaluar dolor, movimientos y estímulos desencadenantes.';
    }

    updateVisualChecks();
  }

  checks.forEach(el => el.addEventListener('change', calcularEberhart));
  calcularEberhart();
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
