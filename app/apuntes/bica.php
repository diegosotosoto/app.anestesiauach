<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Esta herramienta estima el déficit de bicarbonato a partir del Base Excess y calcula un volumen orientativo para soluciones de bicarbonato de sodio. Es una ayuda para planificar corrección parcial y reevaluación seriada, no una indicación automática de reposición completa.";
$formula = "Déficit (mEq) ≈ 0,3 × peso × |BE|. NaHCO₃ 8,4% = 1 mEq/ml. Solución 2/3 M ≈ 0,67 mEq/ml.";
$referencias = array(
  "1.- Kraut JA, Madias NE. Treatment of acute metabolic acidosis: a pathophysiologic approach. Nat Rev Nephrol. 2012;8(10):589-601.",
  "2.- Brown RM, Semler MW. Sodium bicarbonate for severe metabolic acidaemia. Lancet. 2019;393(10179):1414-1415.",
  "3.- Sodium Bicarbonate. StatPearls. NCBI Bookshelf. Updated 2024.",
  "4.- Ghauri SK, Javaeed A, Mustafa KJ, Khan AS. Bicarbonate Therapy for Critically Ill Patients with Metabolic Acidosis: A Systematic Review. Cureus. 2019;11(5):e4295."
);

$icono_apunte = "<i class='fa-solid fa-flask-vial pe-3 pt-2'></i>";
$titulo_apunte = "Corrección de Bicarbonato";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="bica-shell">

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
          }

          body{background:var(--bg);}
          .bica-shell{max-width:980px;margin:0 auto;}

          .bica-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;margin-bottom:1rem;overflow:hidden;
          }
          .bica-topbar h1{color:#fff;}

          .section-card{
            border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;overflow:hidden;margin-bottom:1rem;
          }
          .section-title{
            font-size:.8rem;letter-spacing:.05em;text-transform:uppercase;color:var(--muted);
          }
          .pill{
            display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.78rem;
            background:#eef3ff;color:#3559b7;font-weight:600;
          }
          .subtle{font-size:.94rem;color:#5f6b76;}

          .info-box{
            background:#fff;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            margin-bottom:1rem;overflow:hidden;
          }
          .info-box-header{
            display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:1rem;
          }
          .info-box-title{
            font-size:.8rem;text-transform:uppercase;color:#667085;letter-spacing:.08em;
          }
          .info-toggle-btn{
            border-radius:.6rem;font-size:.85rem;padding:.35rem .7rem;white-space:nowrap;
            background:#6c757d;border:none;color:white;transition:.2s;
          }
          .info-toggle-btn:hover{background:#5a6268;color:white;}
          .info-box-content{
            padding:1rem;display:none;animation:fadeIn .2s ease-in-out;border-top:1px solid #e9eef5;
          }
          @keyframes fadeIn{
            from{opacity:0; transform:translateY(-5px);}
            to{opacity:1; transform:translateY(0);}
          }

          .calc-grid{
            display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;
          }
          .card-block{
            border:1px solid var(--line);border-radius:1rem;background:var(--soft);padding:1rem;
          }
          .form-label-lite{
            font-size:.92rem;font-weight:600;color:var(--text);margin-bottom:.35rem;
          }

          .result-box{
            border-radius:1rem;border:1px solid var(--line);background:var(--soft);padding:1rem;
          }
          .result-main{
            font-size:1.08rem;font-weight:700;color:var(--text);
          }
          .result-num{
            font-size:2rem;font-weight:800;line-height:1;color:#3559b7;
          }

          .result-row{
            display:flex;align-items:center;justify-content:space-between;gap:1rem;
            padding:.8rem .9rem;border:1px solid #e6e9ef;border-radius:.9rem;background:#fff;margin-bottom:.6rem;
          }
          .result-row:last-child{margin-bottom:0;}
          .result-name{font-weight:600;color:#1f2a37;line-height:1.2;}
          .result-note{font-size:.8rem;color:#667085;margin-top:.15rem;}
          .result-value-wrap{min-width:160px;}

          .conduct-box{
            padding:1rem;border-radius:1rem;border:1px solid var(--line);
          }
          .conduct-ok{background:var(--good);}
          .conduct-mid{background:var(--warn);}
          .conduct-no{background:var(--danger);}
          .conduct-title{
            font-size:1.08rem;font-weight:800;color:#1f2a37;margin-bottom:.65rem;
          }

          .small-note{font-size:.84rem;color:var(--muted);}
          .footnote-box{
            background:#fff;border:1px solid #e6e9ef;border-radius:1rem;padding:.9rem;
          }
          .footer-note{font-size:.82rem;color:#6c757d;}

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value-wrap{width:100%;min-width:0;}
          }
          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .result-num{font-size:1.8rem;}
          }
          .reco-wrap{
  border:1px solid var(--line);
  border-radius:1.4rem;
  background:var(--soft);
  padding:1.25rem;
}

.reco-title{
  font-size:1rem;
  letter-spacing:.08em;
  text-transform:uppercase;
  color:#64748b;
  text-align:center;
  margin-bottom:1rem;
}

.reco-main{
  font-size:2.1rem;
  font-weight:800;
  text-align:center;
  color:#1f2a37;
  line-height:1.15;
  margin-bottom:1.2rem;
}

.reco-grid{
  display:grid;
  grid-template-columns:1fr;
  gap:1rem;
}

.reco-card{
  background:#fff;
  border:1px solid #e6e9ef;
  border-radius:1.25rem;
  padding:1.25rem 1.1rem;
  text-align:center;
}

.reco-label{
  font-size:.78rem;
  letter-spacing:.08em;
  text-transform:uppercase;
  color:#667085;
  margin-bottom:.55rem;
}

.reco-text{
  font-size:1rem;
  line-height:1.45;
  color:#1f2a37;
  font-weight:600;
}

.reco-highlight{
  display:inline-block;
  margin-top:.55rem;
  padding:.55rem .9rem;
  border-radius:999px;
  background:#dfe7f6;
  color:#3559b7;
  font-weight:800;
  font-size:1rem;
  line-height:1.3;
}

.reco-soft{
  font-size:.95rem;
  line-height:1.5;
  color:#667085;
  font-weight:500;
}

@media (max-width:576px){
  .reco-main{
    font-size:1.6rem;
  }

  .reco-card{
    padding:1rem .9rem;
  }

  .reco-text{
    font-size:.95rem;
  }

  .reco-highlight{
    font-size:.92rem;
  }
}
        </style>

        <div class="bica-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Corrección de Bicarbonato</h1>
              <div class="subtle text-white-50">Cálculo automático de déficit, volumen total y corrección inicial sugerida al 50%.</div>
            </div>
            <span class="pill bg-light text-dark">Ácido-base</span>
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
              <div class="card-block">
                <label class="form-label-lite">Peso</label>
                <div class="input-group">
                  <input class="form-control calc-trigger" type="number" id="peso" value="">
                  <span class="input-group-text">Kg</span>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Base Excess</label>
                <div class="input-group">
                  <input class="form-control calc-trigger" type="number" id="be" value="">
                  <span class="input-group-text">mEq/L</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado</div>

            <div class="result-box mb-3">
              <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                  <div class="small-note">Déficit total estimado</div>
                  <div id="deficitText" class="result-main">Ingresa peso y BE.</div>
                </div>
                <div id="deficitNum" class="result-num">0</div>
              </div>
            </div>

            <div class="calc-grid">
              <div class="card-block">
                <div class="result-row">
                  <div>
                    <div class="result-name">Déficit</div>
                    <div class="result-note">Equivalente total calculado</div>
                  </div>
                  <div class="result-value-wrap input-group input-group-sm">
                    <input class="form-control" type="number" id="resultado1" readonly>
                    <span class="input-group-text">mEq</span>
                  </div>
                </div>

                <div class="result-row">
                  <div>
                    <div class="result-name">NaHCO₃ 8,4%</div>
                    <div class="result-note">Reposición teórica del 100%</div>
                  </div>
                  <div class="result-value-wrap input-group input-group-sm">
                    <input class="form-control" type="number" id="resultado2" readonly>
                    <span class="input-group-text">ml</span>
                  </div>
                </div>

                <div class="result-row">
                  <div>
                    <div class="result-name">NaHCO₃ 2/3 M</div>
                    <div class="result-note">Reposición teórica del 100%</div>
                  </div>
                  <div class="result-value-wrap input-group input-group-sm">
                    <input class="form-control" type="number" id="resultado3" readonly>
                    <span class="input-group-text">ml</span>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <div class="result-row">
                  <div>
                    <div class="result-name">Corrección inicial sugerida</div>
                    <div class="result-note">Objetivo inicial: 50% del déficit total</div>
                  </div>
                  <div class="result-value-wrap input-group input-group-sm">
                    <input class="form-control" type="number" id="resultado4" readonly>
                    <span class="input-group-text">mEq</span>
                  </div>
                </div>

                <div class="result-row">
                  <div>
                    <div class="result-name">NaHCO₃ 8,4% al 50%</div>
                  </div>
                  <div class="result-value-wrap input-group input-group-sm">
                    <input class="form-control" type="number" id="resultado5" readonly>
                    <span class="input-group-text">ml</span>
                  </div>
                </div>

                <div class="result-row">
                  <div>
                    <div class="result-name">NaHCO₃ 2/3 M al 50%</div>
                  </div>
                  <div class="result-value-wrap input-group input-group-sm">
                    <input class="form-control" type="number" id="resultado6" readonly>
                    <span class="input-group-text">ml</span>
                  </div>
                </div>
              </div>
            </div>

            <div id="otro_elemento" class="small-note pt-3"></div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Guía breve de manejo en pabellón</div>

            <div id="conductBox" class="conduct-box conduct-mid">
              <div id="conductTitle" class="conduct-title">Orientación inicial</div>
              <div id="conductText">
                Ingresa peso y Base Excess para mostrar una orientación de manejo basada en el déficit calculado.
              </div>
            </div>

<div class="reco-wrap mt-3">
  <div class="reco-title">Principios y precauciones en pabellón</div>

  <div class="reco-main">
    La corrección del bicarbonato debe ser parcial, contextual y reevaluable
  </div>

  <div class="reco-grid">

    <div class="reco-card">
      <div class="reco-label">Objetivo inicial</div>
      <div class="reco-text">
        Corregir aproximadamente el <strong>50% del déficit calculado</strong> y reevaluar con gases arteriales.
      </div>
      <div class="reco-highlight">
        Evitar la sobrecorrección rápida
      </div>
    </div>

    <div class="reco-card">
      <div class="reco-label">Tratamiento de base</div>
      <div class="reco-text">
        Buscar y tratar el desencadenante:
      </div>
      <div class="reco-soft mt-2">
        sepsis, hipoperfusión, cetoacidosis, deshidratación, falla renal, pérdidas gastrointestinales o fármacos.
      </div>
    </div>

    <div class="reco-card">
      <div class="reco-label">Ventilación</div>
      <div class="reco-text">
        Ajustar la ventilación según el contexto clínico.
      </div>
      <div class="reco-soft mt-2">
        Considerar riesgo de polipnea compensadora, fatiga respiratoria y eventual falla en la extubación si la compensación ventilatoria es crítica.
      </div>
    </div>

    <div class="reco-card">
      <div class="reco-label">Uso de bicarbonato</div>
      <div class="reco-text">
        El bicarbonato <strong>no reemplaza</strong> el tratamiento etiológico.
      </div>
      <div class="reco-soft mt-2">
        Puede ser útil como medida de apoyo en acidosis metabólica significativa, pero siempre integrado al cuadro clínico completo.
      </div>
    </div>

    <div class="reco-card">
      <div class="reco-label">Acceso venoso</div>
      <div class="reco-text">
        Preferir acceso venoso central cuando se anticipen formulaciones más concentradas o infusiones relevantes.
      </div>
      <div class="reco-soft mt-2">
        Especialmente si se utiliza bicarbonato 2/3 M o si la osmolaridad/irritación vascular puede ser un problema.
      </div>
    </div>

    <div class="reco-card">
      <div class="reco-label">Monitorización</div>
      <div class="reco-text">
        Recontrolar en forma seriada:
      </div>
      <div class="reco-soft mt-2">
        gases arteriales, sodio, potasio, calcio ionizado, ventilación, hemodinamia y respuesta clínica tras cada intervención.
      </div>
    </div>

    <div class="reco-card">
      <div class="reco-label">Perla docente</div>
      <div class="reco-soft">
        Un BE muy negativo no significa automáticamente “dar todo el bicarbonato”. En pabellón, lo importante es entender <strong>por qué</strong> el paciente está acidótico, cuánto está compensando respiratoriamente y cuánto margen real tiene para tolerar la corrección.
      </div>
    </div>

  </div>
</div>


            
          </div>
        </div>

        <div class="footer-note">
          Herramienta orientativa. La terapia con bicarbonato no reemplaza la corrección de la causa ni la reevaluación gasométrica seriada.
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

function setFieldValue(id, value, decimals){
  const el = document.getElementById(id);
  if(!el) return;
  if(isNaN(value) || value === null || value === undefined || !isFinite(value)){
    el.value = '';
    return;
  }
  el.value = Number(value).toFixed(decimals);
}

function doMath(){
  const peso = parseFloat(document.getElementById('peso').value);
  const be = parseFloat(document.getElementById('be').value);

  if(isNaN(peso) || isNaN(be) || peso <= 0){
    ['resultado1','resultado2','resultado3','resultado4','resultado5','resultado6'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('deficitNum').textContent = '0';
    document.getElementById('deficitText').textContent = 'Ingresa peso y BE.';
    document.getElementById('otro_elemento').textContent = '';
    document.getElementById('conductBox').className = 'conduct-box conduct-mid';
    document.getElementById('conductTitle').textContent = 'Orientación inicial';
    document.getElementById('conductText').textContent = 'Ingresa peso y Base Excess para mostrar una orientación de manejo basada en el déficit calculado.';
    return;
  }

  const deficit = peso * Math.abs(be) * 0.3; // mEq aproximados
  const total84 = deficit;                   // 8.4% ~ 1 mEq/ml
  const total23M = deficit / 0.67;           // 2/3 M ~ 0.67 mEq/ml
  const mitad = deficit * 0.5;
  const mitad84 = total84 * 0.5;
  const mitad23M = total23M * 0.5;

  setFieldValue('resultado1', deficit, 1);
  setFieldValue('resultado2', total84, 1);
  setFieldValue('resultado3', total23M, 0);
  setFieldValue('resultado4', mitad, 1);
  setFieldValue('resultado5', mitad84, 1);
  setFieldValue('resultado6', mitad23M, 0);

  document.getElementById('deficitNum').textContent = deficit.toFixed(1);
  document.getElementById('deficitText').textContent = 'Déficit total estimado de bicarbonato';

  document.getElementById('otro_elemento').textContent = 'Resultado propuesto para reposición del 100% del déficit. En general, se prefiere iniciar con una corrección aproximada del 50% y reevaluar con gases arteriales.';

  const conductBox = document.getElementById('conductBox');
  const conductTitle = document.getElementById('conductTitle');
  const conductText = document.getElementById('conductText');

  conductBox.classList.remove('conduct-ok','conduct-mid','conduct-no');

  if (Math.abs(be) < 8) {
    conductBox.classList.add('conduct-ok');
    conductTitle.textContent = 'Déficit leve';
    conductText.innerHTML = 'Acidosis metabólica leve. En pabellón, priorizar tratamiento de la causa y optimización ventilatoria/hemodinámica. El bicarbonato no suele ser la primera medida si no hay acidemia severa ni contexto específico que lo justifique.';
  } else if (Math.abs(be) < 15) {
    conductBox.classList.add('conduct-mid');
    conductTitle.textContent = 'Déficit moderado';
    conductText.innerHTML = 'Considerar corrección parcial inicial, habitualmente <strong>50% del déficit calculado</strong>, con reevaluación seriada. Ajustar ventilación según contexto, evitar sobrecorrección y revisar causas reversibles como hipoperfusión, sepsis, cetoacidosis o pérdidas digestivas.';
  } else {
    conductBox.classList.add('conduct-no');
    conductTitle.textContent = 'Déficit importante';
    conductText.innerHTML = 'Acidosis metabólica significativa. Corregir causa de base en forma agresiva, vigilar compensación respiratoria y riesgo de polipnea/falla de extubación. Si se decide usar bicarbonato, preferir <strong>corrección inicial parcial</strong> con controles estrechos; considerar acceso venoso central si se usarán formulaciones concentradas o volúmenes/osmolaridad relevantes.';
  }
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', doMath);
    el.addEventListener('change', doMath);
  });
  doMath();
});
</script>

<?php
require("footer.php");
?>
