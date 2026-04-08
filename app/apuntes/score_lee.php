<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "El Índice de Riesgo Cardíaco Revisado de Lee fue desarrollado para estimar el riesgo de complicaciones cardíacas mayores en cirugía no cardíaca. Considera seis variables clínicas simples y ayuda a identificar pacientes que pueden requerir evaluación perioperatoria adicional.";
$formula = "Puntaje = número de factores presentes (0 a 6)";
$referencias = array(
  "1.- Lee TH, Marcantonio ER, Mangione CM, et al. Derivation and prospective validation of a simple index for prediction of cardiac risk of major noncardiac surgery. Circulation. 1999;100(10):1043-1049.",
  "2.- Fleisher LA, Beckman JA, Brown KA, et al. 2009 ACCF/AHA focused update on perioperative beta blockade incorporated into the ACC/AHA 2007 guidelines on perioperative cardiovascular evaluation and care for noncardiac surgery. Circulation. 2009;120(21):e169-e276."
);

$icono_apunte = "<i class='fa-solid fa-heart-circle-exclamation pe-3 pt-2'></i>";
$titulo_apunte = "Índice de Riesgo Cardíaco Revisado";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="lee-shell">

        <style>
          .lee-shell{max-width:980px;margin:0 auto;}
          .lee-topbar{
            background:linear-gradient(135deg,#27458f,#3559b7);
            color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;margin-bottom:1rem;
          }
          .lee-topbar h1{color:#fff;}
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
          .risk-check{
            display:flex;align-items:flex-start;gap:.85rem;padding:1rem;
            border:1px solid #e7ebf2;border-radius:1rem;background:#f8fafc;transition:.15s ease;
          }
          .risk-check.active{
            background:#edf4ff;border-color:#bfd2ff;
          }
          .risk-check input{
            width:1.25rem;height:1.25rem;margin-top:.12rem;flex:0 0 auto;
          }
          .risk-label{
            font-weight:600;color:#1f2a37;line-height:1.25;
          }
          .result-box{
            border-radius:1rem;border:1px solid #dfe7f2;background:#f8fafc;padding:1rem;
          }
          .result-main{
            font-size:1.1rem;font-weight:700;color:#1f2a37;
          }
          .result-score{
            font-size:2rem;font-weight:800;line-height:1;color:#3559b7;
          }
          .algo-box{
            border-radius:1rem;padding:1rem;border:1px solid #dfe7f2;
          }
          .algo-low{background:#edf8f7;}
          .algo-mid{background:#fff9e8;}
          .algo-high{background:#fff5f3;}
          .drug-line{
            padding:.7rem .8rem;border-radius:.85rem;background:#fff;border:1px solid #e6e9ef;margin-bottom:.55rem;
          }
          .drug-line:last-child{margin-bottom:0;}
          .small-note{
            font-size:.84rem;color:#667085;
          }
          .refs-card{display:none;}
          .refs-card ul{
            color:#667085;line-height:1.55;padding-left:1.1rem;margin-bottom:0;
          }
        </style>

        <div class="lee-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Índice de Riesgo Cardíaco Revisado</h1>
              <div class="subtle text-white-50">Checklist rápido para estimar riesgo cardíaco perioperatorio en cirugía no cardíaca.</div>
            </div>
            <span class="pill bg-light text-dark">Lee / RCRI</span>
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
            <div class="section-title mb-3">Factores de riesgo</div>

            <div class="d-grid gap-2">
              <label class="risk-check" id="wrap_cirugia">
                <input class="form-check-input lee-check" type="checkbox" id="cirugia">
                <div>
                  <div class="risk-label">Cirugía de riesgo alto</div>
                  <div class="small-note">Intraperitoneal, intratorácica o suprainguinal vascular.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_infarto">
                <input class="form-check-input lee-check" type="checkbox" id="infarto">
                <div>
                  <div class="risk-label">Antecedentes de cardiopatía isquémica</div>
                  <div class="small-note">IAM previo, angina o evidencia equivalente.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_insuf">
                <input class="form-check-input lee-check" type="checkbox" id="insuf">
                <div>
                  <div class="risk-label">Antecedentes de insuficiencia cardíaca</div>
                  <div class="small-note">ICC clínica actual o previa.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_cerebro">
                <input class="form-check-input lee-check" type="checkbox" id="cerebro">
                <div>
                  <div class="risk-label">Antecedentes de ACV / AIT</div>
                  <div class="small-note">Historia cerebrovascular previa.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_insulina">
                <input class="form-check-input lee-check" type="checkbox" id="insulina">
                <div>
                  <div class="risk-label">Usuario de insulina</div>
                  <div class="small-note">Diabetes tratada con insulina.</div>
                </div>
              </label>

              <label class="risk-check" id="wrap_creatinina">
                <input class="form-check-input lee-check" type="checkbox" id="creatinina">
                <div>
                  <div class="risk-label">Creatinina &gt; 2.0 mg/dL</div>
                  <div class="small-note">Disfunción renal significativa.</div>
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
                  <div class="small-note">Puntaje total</div>
                  <div id="scoreText" class="result-main">0 factores de riesgo</div>
                </div>
                <div id="scoreNum" class="result-score">0</div>
              </div>

              <div id="riskPercent" class="result-main mb-2">Riesgo estimado: 0.4%</div>
              <div id="riskInterpretation" class="subtle">Riesgo bajo de complicaciones cardíacas mayores perioperatorias.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Interpretación</div>

            <div id="algoBox" class="algo-box algo-low">
              <div id="algoRisk" class="fw-semibold mb-2">Conducta sugerida</div>

              <div id="drugPlan">
                <div class="drug-line">Riesgo bajo. Proceder con evaluación perioperatoria estándar según contexto clínico.</div>
              </div>

              <div id="algoExtra" class="small-note mt-3">
                Este índice complementa, pero no reemplaza, la valoración clínica integral.
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleReferencias(e){
  if(e) e.preventDefault();
  const box = document.getElementById('referenciasBox');
  box.style.display = (box.style.display === 'block') ? 'none' : 'block';
}

(function () {
  const checks = Array.from(document.querySelectorAll('.lee-check'));

  function updateVisualChecks() {
    checks.forEach(ch => {
      const wrap = document.getElementById('wrap_' + ch.id);
      if (wrap) wrap.classList.toggle('active', ch.checked);
    });
  }

  function calcularLee() {
    const cirugia = document.getElementById('cirugia').checked ? 1 : 0;
    const infarto = document.getElementById('infarto').checked ? 1 : 0;
    const insuf = document.getElementById('insuf').checked ? 1 : 0;
    const cerebro = document.getElementById('cerebro').checked ? 1 : 0;
    const insulina = document.getElementById('insulina').checked ? 1 : 0;
    const creatinina = document.getElementById('creatinina').checked ? 1 : 0;

    const score = cirugia + infarto + insuf + cerebro + insulina + creatinina;

    const scoreNum = document.getElementById('scoreNum');
    const scoreText = document.getElementById('scoreText');
    const riskPercent = document.getElementById('riskPercent');
    const riskInterpretation = document.getElementById('riskInterpretation');
    const algoBox = document.getElementById('algoBox');
    const algoRisk = document.getElementById('algoRisk');
    const drugPlan = document.getElementById('drugPlan');
    const algoExtra = document.getElementById('algoExtra');

    scoreNum.textContent = score;
    scoreText.textContent = score + (score === 1 ? ' factor de riesgo' : ' factores de riesgo');

    algoBox.classList.remove('algo-low', 'algo-mid', 'algo-high');

    if (score === 0) {
      riskPercent.textContent = 'Riesgo estimado: 0.4%';
      riskInterpretation.textContent = 'Riesgo bajo de complicaciones cardíacas mayores perioperatorias.';
      algoBox.classList.add('algo-low');
      algoRisk.textContent = 'Conducta sugerida';
      drugPlan.innerHTML = `
        <div class="drug-line">Riesgo bajo. Proceder con evaluación perioperatoria estándar según contexto clínico.</div>
      `;
      algoExtra.textContent = 'No excluye juicio clínico, capacidad funcional ni necesidad de evaluación adicional si existen otros elementos relevantes.';
    }
    else if (score === 1) {
      riskPercent.textContent = 'Riesgo estimado: 0.9%';
      riskInterpretation.textContent = 'Riesgo discretamente aumentado de complicaciones cardíacas mayores.';
      algoBox.classList.add('algo-low');
      algoRisk.textContent = 'Conducta sugerida';
      drugPlan.innerHTML = `
        <div class="drug-line">Riesgo bajo-intermedio. Ajustar evaluación perioperatoria según cirugía, capacidad funcional y contexto cardiovascular.</div>
      `;
      algoExtra.textContent = 'Considera integrar el resultado con METs, síntomas, cirugía y comorbilidades.';
    }
    else if (score === 2) {
      riskPercent.textContent = 'Riesgo estimado: 6.6%';
      riskInterpretation.textContent = 'Riesgo intermedio de complicaciones cardíacas mayores.';
      algoBox.classList.add('algo-mid');
      algoRisk.textContent = 'Conducta sugerida';
      drugPlan.innerHTML = `
        <div class="drug-line">Riesgo intermedio. Puede justificar evaluación perioperatoria más detallada según la magnitud del procedimiento y la situación clínica.</div>
      `;
      algoExtra.textContent = 'Integra el índice con guías perioperatorias vigentes y necesidad de optimización médica.';
    }
    else {
      riskPercent.textContent = 'Riesgo estimado: 11%';
      riskInterpretation.textContent = 'Riesgo alto de complicaciones cardíacas mayores perioperatorias.';
      algoBox.classList.add('algo-high');
      algoRisk.textContent = 'Conducta sugerida';
      drugPlan.innerHTML = `
        <div class="drug-line">Riesgo alto. Requiere evaluación cardiovascular perioperatoria más exhaustiva y optimización antes del procedimiento, según urgencia clínica.</div>
      `;
      algoExtra.textContent = 'Recuerda que el RCRI es una ayuda para estratificación, no una indicación automática de exámenes o suspensión quirúrgica.';
    }

    updateVisualChecks();
  }

  checks.forEach(el => {
    el.addEventListener('change', calcularLee);
  });

  calcularLee();
})();
</script>
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
<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("footer.php"); ?>
