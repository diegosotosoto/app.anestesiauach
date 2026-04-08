<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Estimación de la pérdida sanguínea admisible antes de alcanzar un hematocrito objetivo. Esta herramienta ayuda a anticipar reposición de volumen y eventual necesidad de hemocomponentes en pabellón, siempre integrada al contexto clínico.";
$formula = "PSA = Volemia estimada x (Hto inicial - Hto objetivo) / Hto inicial";
$referencias = array(
  "1.- Miller's Anesthesia. Blood loss and transfusion principles.",
  "2.- American Society of Anesthesiologists. Practice Guidelines for Perioperative Blood Management.",
  "3.- UpToDate. Perioperative blood management: Strategies to minimize transfusions."
);

$icono_apunte = "<i class='fa-solid fa-droplet pe-3 pt-2'></i>";
$titulo_apunte = "Pérdida Sanguínea Admisible";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="psa-shell">

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
          .psa-shell{max-width:980px;margin:0 auto;}

          .psa-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }
          .psa-topbar h1{color:#fff;}

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

          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .form-label-lite{
            font-size:.92rem;
            font-weight:600;
            color:var(--text);
            margin-bottom:.35rem;
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

          .conduct-box{
            padding:1rem;
            border-radius:1rem;
            border:1px solid var(--line);
          }
          .conduct-ok{background:var(--good);}
          .conduct-mid{background:var(--warn);}
          .conduct-no{background:var(--danger);}
          .conduct-title{
            font-size:1.08rem;
            font-weight:800;
            color:#1f2a37;
            margin-bottom:.65rem;
          }

          .teaching-wrap{
            border:1px solid var(--line);
            border-radius:1.4rem;
            background:var(--soft);
            padding:1.25rem;
          }
          .teaching-title{
            font-size:1rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#64748b;
            text-align:center;
            margin-bottom:1rem;
          }
          .teaching-main{
            font-size:1.8rem;
            font-weight:800;
            text-align:center;
            color:#1f2a37;
            line-height:1.15;
            margin-bottom:1.2rem;
          }
          .teaching-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }
          .teaching-card{
            background:#fff;
            border-radius:1.25rem;
            padding:1.1rem 1rem;
            border:1px solid #e6e9ef;
            text-align:center;
          }
          .teaching-label{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#667085;
            margin-bottom:.55rem;
          }
          .teaching-text{
            font-size:1rem;
            line-height:1.45;
            color:#1f2a37;
            font-weight:600;
          }
          .teaching-soft{
            font-size:.95rem;
            line-height:1.5;
            color:#667085;
            font-weight:500;
            margin-top:.35rem;
          }

          .small-note{font-size:.84rem;color:var(--muted);}
          .footer-note{font-size:.82rem;color:#6c757d;}

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
          }

          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .result-num{font-size:1.8rem;}
            .teaching-main{font-size:1.45rem;}
          }
        </style>

        <div class="psa-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Pérdida Sanguínea Admisible</h1>
              <div class="subtle text-white-50">Cálculo automático de pérdida tolerable antes de alcanzar el hematocrito objetivo.</div>
            </div>
            <span class="pill bg-light text-dark">Sangrado</span>
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
                  <span class="input-group-text">kg</span>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Volemia estimada</label>
                <select class="form-select calc-trigger" id="volemiaTipo">
                  <option value="70" selected>Adulto promedio (70 ml/kg)</option>
                  <option value="65">Adulto mayor / menor volemia relativa (65 ml/kg)</option>
                  <option value="75">Mujer joven / adulto delgado (75 ml/kg)</option>
                  <option value="80">Niño mayor (80 ml/kg)</option>
                  <option value="85">Lactante (85 ml/kg)</option>
                  <option value="90">Recién nacido (90 ml/kg)</option>
                </select>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Hematocrito inicial</label>
                <div class="input-group">
                  <input class="form-control calc-trigger" type="number" id="hto_i" value="">
                  <span class="input-group-text">%</span>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Hematocrito objetivo</label>
                <div class="input-group">
                  <input class="form-control calc-trigger" type="number" id="hto_f" value="">
                  <span class="input-group-text">%</span>
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
                  <div class="small-note">Pérdida sanguínea admisible</div>
                  <div id="resultadoTexto" class="result-main">Ingresa los datos.</div>
                </div>
                <div id="resultadoNum" class="result-num">0</div>
              </div>
            </div>

            <div id="conductBox" class="conduct-box conduct-mid">
              <div id="conductTitle" class="conduct-title">Interpretación clínica</div>
              <div id="conductText">Completa peso, volemia y hematocritos para estimar la pérdida admisible.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Guía práctica en anestesia</div>
              <div class="teaching-main">La reposición inicial suele comenzar con cristaloides, pero la transfusión depende del contexto clínico, no solo del cálculo</div>

              <div class="teaching-grid">
                <div class="teaching-card">
                  <div class="teaching-label">Reposición inicial</div>
                  <div class="teaching-text">Partir con cristaloides balanceados</div>
                  <div class="teaching-soft">En la mayoría de los sangrados iniciales la reposición comienza con cristaloides, idealmente balanceados. Evita la sobrecarga innecesaria y la hemodilución excesiva.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Cuándo pensar en transfusión</div>
                  <div class="teaching-text">No depende solo de superar la PSA</div>
                  <div class="teaching-soft">Considera transfusión de hemocomponentes si hay sangrado activo relevante, inestabilidad hemodinámica, mala perfusión, Hb o Hto en rango crítico, cardiopatía, sepsis, cirugía mayor o contexto de baja tolerancia a anemia.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Hemocomponentes</div>
                  <div class="teaching-text">Transfusión guiada por contexto y objetivos</div>
                  <div class="teaching-soft">Si el sangrado se vuelve importante o masivo, no basta con glóbulos rojos aislados. Evalúa necesidad de plasma, plaquetas, fibrinógeno o protocolos tipo transfusión masiva según el escenario.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Error frecuente</div>
                  <div class="teaching-text">Usar la PSA como regla rígida</div>
                  <div class="teaching-soft">La PSA es orientativa. No reemplaza monitorización, perfusión, lactato, tendencia de Hb, evaluación del campo quirúrgico ni velocidad real del sangrado.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Perla clínica</div>
                  <div class="teaching-text">Una anemia bien tolerada no es igual a shock hemorrágico</div>
                  <div class="teaching-soft">El problema no es solo cuánto hematocrito queda, sino si el paciente mantiene entrega adecuada de oxígeno, estabilidad hemodinámica y reserva fisiológica.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. La decisión de reposición o transfusión debe integrar magnitud del sangrado, velocidad, contexto quirúrgico, perfusión y comorbilidades.
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

function doMath(){
  const peso = parseFloat(document.getElementById('peso').value);
  const volemiaKg = parseFloat(document.getElementById('volemiaTipo').value);
  const htoI = parseFloat(document.getElementById('hto_i').value);
  const htoF = parseFloat(document.getElementById('hto_f').value);

  if([peso, volemiaKg, htoI, htoF].some(v => isNaN(v) || v <= 0) || htoF >= htoI){
    document.getElementById('resultadoNum').textContent = '0';
    document.getElementById('resultadoTexto').textContent = 'Ingresa datos válidos. El hematocrito objetivo debe ser menor que el inicial.';
    document.getElementById('conductBox').className = 'conduct-box conduct-mid';
    document.getElementById('conductTitle').textContent = 'Interpretación clínica';
    document.getElementById('conductText').textContent = 'Completa peso, volemia y hematocritos para estimar la pérdida admisible.';
    return;
  }

  const volemia = peso * volemiaKg;
  const psa = volemia * ((htoI - htoF) / htoI);

  document.getElementById('resultadoNum').textContent = psa.toFixed(0) + ' ml';
  document.getElementById('resultadoTexto').textContent = 'PSA estimada con volemia aproximada de ' + volemia.toFixed(0) + ' ml';

  const box = document.getElementById('conductBox');
  const title = document.getElementById('conductTitle');
  const text = document.getElementById('conductText');

  box.classList.remove('conduct-ok','conduct-mid','conduct-no');

  if(psa >= 1500){
    box.classList.add('conduct-ok');
    title.textContent = 'Reserva relativamente amplia';
    text.innerHTML = 'Existe margen mayor antes de alcanzar el hematocrito objetivo, pero eso <strong>no descarta transfusión</strong> si el sangrado es rápido, el paciente es frágil o hay mala perfusión. La reposición inicial suele comenzar con cristaloides.';
  } else if(psa >= 700){
    box.classList.add('conduct-mid');
    title.textContent = 'Reserva intermedia';
    text.innerHTML = 'Zona de vigilancia estrecha. Reevaluar frecuencia del sangrado, campo quirúrgico, perfusión, Hb seriada y contexto clínico. Puede requerirse transfusión según tolerancia individual y velocidad de pérdida.';
  } else {
    box.classList.add('conduct-no');
    title.textContent = 'Baja tolerancia estimada';
    text.innerHTML = 'Pequeñas pérdidas pueden llevar rápido al hematocrito objetivo. En este escenario conviene anticipar estrategia de reposición y considerar precozmente hemocomponentes si el contexto lo justifica.';
  }
}

document.addEventListener('DOMContentLoaded', function(){
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
