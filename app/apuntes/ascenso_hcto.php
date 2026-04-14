<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Cálculo rápido para estimar el volumen de concentrado eritrocitario (CE) necesario para alcanzar un hematocrito objetivo, y también para estimar el ascenso esperado del hematocrito cuando se transfunde una alícuota en pediatría.";
$formula = "
Volumen CE requerido (mL) = ((Hto deseado - Hto actual) × VSE) / Hto del CE<br>
Ascenso esperado de Hto (%) = (Volumen transfundido × Hto del CE) / VSE<br><br>
Donde VSE = peso × volumen sanguíneo estimado (mL/kg)
";
$referencias = array(
  "1.- Royal Children's Hospital Melbourne. Clinical Practice Guidelines: Blood product prescription.",
  "2.- Guidelines for the Management of Transfusion-Dependent β-Thalassaemia (NCBI Bookshelf). Cálculo de volumen para alcanzar Hb/Hto objetivo; asume volumen sanguíneo total de 70 mL/kg.",
  "3.- Canadian Paediatric Society. Minimizing blood loss and need for transfusions in newborns. Fórmula basada en peso, volumen sanguíneo estimado y Hb/Hto del donante.",
  "4.- PICU Handbook / AccessPediatrics. Fórmulas prácticas de transfusión pediátrica y estimación de volumen sanguíneo."
);

$icono_apunte = "<i class='fa-solid fa-droplet pe-3 pt-2'></i>";
$titulo_apunte = "Ascenso de Hematocrito por Transfusión en Alícuotas";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="transf-shell">

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
          .transf-shell{max-width:980px;margin:0 auto;}

          .topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
          }
          .topbar h1{color:#fff;}

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

          .small-note{font-size:.84rem;color:var(--muted);}
          .footer-note{font-size:.82rem;color:#6c757d;}

          .teaching-wrap{
            border:1px solid var(--line);
            border-radius:1.4rem;
            background:var(--soft);
            padding:1.25rem;
            overflow:hidden;
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
            font-size:1.6rem;
            font-weight:800;
            text-align:center;
            color:#1f2a37;
            line-height:1.15;
            margin-bottom:1.2rem;
            max-width:100%;
            overflow-wrap:anywhere;
          }

          .teaching-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }

          .teaching-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1.25rem;
            padding:1.1rem 1rem;
            text-align:center;
            max-width:100%;
            overflow:hidden;
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
            max-width:100%;
            overflow-wrap:anywhere;
          }

          .teaching-soft{
            font-size:.95rem;
            line-height:1.5;
            color:#667085;
            font-weight:500;
            margin-top:.35rem;
            max-width:100%;
            overflow-wrap:anywhere;
            word-break:normal;
          }

          .fraction{
            display:inline-block;
            width:100%;
            text-align:center;
            line-height:1.35;
          }

          .fraction .top{
            display:block;
            padding:0 8px 6px 8px;
            border-bottom:2px solid #212529;
            font-weight:500;
            word-break:break-word;
          }

          .fraction .bottom{
            display:block;
            padding-top:6px;
            font-weight:500;
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
          }

          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .result-num{font-size:1.8rem;}
            .teaching-main{font-size:1.35rem;}
            .fraction{font-size:1rem !important;}
          }

           .form-select{
            border-radius:.75rem;
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Transfusión de CE en alícuotas</h1>
              <div class="subtle text-white-50">Estimación del volumen requerido y del ascenso esperado del hematocrito en pediatría.</div>
            </div>
            <span class="pill bg-light text-dark">Pediatría</span>
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
              <b>Fórmulas:</b><br>
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
            <div class="section-title mb-3">Datos del paciente y del hemocomponente</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Peso</label>
                <div class="input-group mb-3">
                  <input class="form-control transf-calc" type="number" step="0.1" id="peso" value="">
                  <span class="input-group-text">kg</span>
                </div>

                <label class="form-label-lite">Hto actual</label>
                <div class="input-group mb-3">
                  <input class="form-control transf-calc" type="number" step="0.1" id="hto_actual" value="">
                  <span class="input-group-text">%</span>
                </div>

                <label class="form-label-lite">Hto deseado</label>
                <div class="input-group">
                  <input class="form-control transf-calc" type="number" step="0.1" id="hto_deseado" value="">
                  <span class="input-group-text">%</span>
                </div>
              </div>


<div class="card-block">
  <label class="form-label-lite">Hto del CE</label>
  <div class="input-group mb-3">
    <select class="form-select transf-calc" id="hto_ce">
      <option value="50">50 %</option>
      <option value="55" selected>55 %</option>
      <option value="60">60 %</option>
    </select>
    <span class="input-group-text">%</span>
  </div>

  <label class="form-label-lite">Volemia estimada</label>
  <div class="input-group mb-3">
    <select class="form-select transf-calc" id="vse_kg">
      <option value="70" selected>Adulto promedio (70 mL/kg)</option>
      <option value="65">Adulto mayor / menor volemia relativa (65 mL/kg)</option>
      <option value="75">Mujer joven / adulto delgado (75 mL/kg)</option>
      <option value="80">Niño mayor (80 mL/kg)</option>
      <option value="85">Lactante (85 mL/kg)</option>
      <option value="90">Recién nacido (90 mL/kg)</option>
    </select>
    <span class="input-group-text">mL/kg</span>
  </div>

  <label class="form-label-lite">Alícuota a transfundir</label>
  <div class="input-group">
    <input class="form-control transf-calc" type="number" step="0.1" id="aliquota" value="">
    <span class="input-group-text">mL</span>
  </div>
</div>


            </div>

            <div class="small-note mt-3">
              Sugerencia práctica: en la mayoría de los niños puedes comenzar con VSE 70 mL/kg; en lactantes pequeños o neonatos ese valor puede ser mayor.
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultados</div>

            <div class="calc-grid">
              <div>
                <div class="result-box mb-3">
                  <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                      <div class="small-note">Volumen sanguíneo estimado</div>
                      <div id="vse_text" class="result-main">Ingresa los datos.</div>
                    </div>
                    <div id="vse_num" class="result-num">0</div>
                  </div>
                </div>

                <div class="result-box">
                  <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                      <div class="small-note">Volumen de CE requerido</div>
                      <div id="req_text" class="result-main">Para alcanzar el Hto objetivo.</div>
                    </div>
                    <div id="req_num" class="result-num">0</div>
                  </div>
                </div>
              </div>

              <div>
                <div class="result-box mb-3">
                  <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                      <div class="small-note">Ascenso esperado de Hto</div>
                      <div id="rise_text" class="result-main">Si transfundes la alícuota indicada.</div>
                    </div>
                    <div id="rise_num" class="result-num">0</div>
                  </div>
                </div>

                <div class="result-box">
                  <div class="small-note mb-2">Hto estimado postransfusión</div>
                  <div id="post_hto" class="result-main">-</div>
                </div>
              </div>
            </div>

            <div id="conduct_box" class="conduct-box conduct-mid mt-3">
              <div class="conduct-title">Interpretación</div>
              <div id="conduct_text">
                Completa los campos para calcular volumen requerido y ascenso esperado.
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Fórmula visual</div>

            <div class="card-block mb-3">
              <p class="mb-3"><strong>Volumen de CE requerido</strong></p>
              <div class="fraction mb-3" style="font-size:1.15rem;">
                <div class="top">[Hto deseado − Hto actual] × VSE</div>
                <div class="bottom">Hto del CE</div>
              </div>
              <div class="small-note">Expresa hematocritos en porcentaje y VSE en mL.</div>
            </div>

            <div class="card-block">
              <p class="mb-3"><strong>Ascenso esperado del Hto por la alícuota</strong></p>
              <div class="fraction mb-3" style="font-size:1.15rem;">
                <div class="top">Volumen transfundido × Hto del CE</div>
                <div class="bottom">VSE</div>
              </div>
              <div class="small-note">Te entrega el incremento esperado en puntos de hematocrito (%).</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Docencia para residentes</div>
              <div class="teaching-main">La fórmula sirve para orientarte, no para apagar el juicio clínico</div>

              <div class="teaching-grid">
                <div class="teaching-card">
                  <div class="teaching-label">Perla 1</div>
                  <div class="teaching-text">El VSE es una estimación</div>
                  <div class="teaching-soft">Si el niño está hemodiluido, sangrando o muy vasoconstricto, la respuesta real puede alejarse de la calculada.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Perla 2</div>
                  <div class="teaching-text">No transfundas un número aislado</div>
                  <div class="teaching-soft">Cruza el resultado con perfusión, sangrado, lactato, contexto quirúrgico, cardiopatía, ventilación y tendencia de Hb/Hto.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Perla 3</div>
                  <div class="teaching-text">Las alícuotas permiten corrección gradual</div>
                  <div class="teaching-soft">En pediatría, fraccionar en mL o mL/kg ayuda a evitar sobretransfusión, sobrecarga y correcciones excesivamente rápidas.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Perla 4</div>
                  <div class="teaching-text">Regla rápida útil</div>
                  <div class="teaching-soft">Una dosis de 10–15 mL/kg de CE suele generar un ascenso moderado de Hb/Hto, pero la magnitud real depende mucho del contexto clínico.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Perla 5</div>
                  <div class="teaching-text">Control postransfusional inteligente</div>
                  <div class="teaching-soft">Interpreta el valor de control según el tiempo transcurrido, balance de fluidos, persistencia del sangrado y estabilidad hemodinámica.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente de apoyo. No reemplaza protocolos institucionales, banco de sangre ni el juicio clínico perioperatorio.
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

function calcTransfusion(){
  const peso = parseFloat(document.getElementById('peso').value);
  const htoActual = parseFloat(document.getElementById('hto_actual').value);
  const htoDeseado = parseFloat(document.getElementById('hto_deseado').value);
  const htoCE = parseFloat(document.getElementById('hto_ce').value);
  const vseKg = parseFloat(document.getElementById('vse_kg').value);
  const aliquota = parseFloat(document.getElementById('aliquota').value);

  const vseNum = document.getElementById('vse_num');
  const vseText = document.getElementById('vse_text');
  const reqNum = document.getElementById('req_num');
  const reqText = document.getElementById('req_text');
  const riseNum = document.getElementById('rise_num');
  const riseText = document.getElementById('rise_text');
  const postHto = document.getElementById('post_hto');
  const conductBox = document.getElementById('conduct_box');
  const conductText = document.getElementById('conduct_text');

  if (isNaN(peso) || isNaN(vseKg) || peso <= 0 || vseKg <= 0){
    vseNum.textContent = '0';
    vseText.textContent = 'Ingresa peso y VSE.';
    reqNum.textContent = '0';
    riseNum.textContent = '0';
    postHto.textContent = '-';
    conductBox.className = 'conduct-box conduct-mid mt-3';
    conductText.textContent = 'Completa al menos peso y VSE para comenzar.';
    return;
  }

  const vse = peso * vseKg;
  vseNum.textContent = vse.toFixed(0);
  vseText.textContent = 'VSE estimado: ' + vse.toFixed(0) + ' mL';

  let reqVolume = null;
  if (!isNaN(htoActual) && !isNaN(htoDeseado) && !isNaN(htoCE) && htoCE > 0 && htoDeseado >= htoActual){
    reqVolume = ((htoDeseado - htoActual) * vse) / htoCE;
    reqNum.textContent = reqVolume.toFixed(0);
    reqText.textContent = 'Volumen estimado de CE para llegar al objetivo.';
  } else {
    reqNum.textContent = '0';
    reqText.textContent = 'Ingresa Hto actual, deseado y Hto del CE.';
  }

  let rise = null;
  if (!isNaN(aliquota) && !isNaN(htoCE) && aliquota > 0 && htoCE > 0){
    rise = (aliquota * htoCE) / vse;
    riseNum.textContent = rise.toFixed(1);
    riseText.textContent = 'Ascenso esperado del Hto: ' + rise.toFixed(1) + ' puntos';
  } else {
    riseNum.textContent = '0';
    riseText.textContent = 'Ingresa una alícuota para estimar ascenso.';
  }

  if (!isNaN(htoActual) && rise !== null){
    postHto.textContent = (htoActual + rise).toFixed(1) + ' %';
  } else {
    postHto.textContent = '-';
  }

  if (reqVolume !== null && rise !== null){
    conductBox.className = 'conduct-box conduct-ok mt-3';
    conductText.innerHTML = 'Ya tienes ambas estimaciones: <strong>volumen requerido</strong> y <strong>ascenso esperado por la alícuota</strong>. Úsalas como orientación y reevalúa según sangrado activo, hemodilución y respuesta clínica.';
  } else if (reqVolume !== null || rise !== null){
    conductBox.className = 'conduct-box conduct-mid mt-3';
    conductText.textContent = 'Tienes una estimación parcial. Completa los otros campos si quieres calcular también el objetivo transfusional o el ascenso esperado.';
  } else {
    conductBox.className = 'conduct-box conduct-mid mt-3';
    conductText.textContent = 'Completa Hto actual, objetivo, Hto del CE y/o alícuota para obtener resultados útiles.';
  }

  if (!isNaN(htoDeseado) && !isNaN(htoActual) && htoDeseado < htoActual){
    conductBox.className = 'conduct-box conduct-no mt-3';
    conductText.textContent = 'El Hto deseado es menor que el actual. Revisa los datos ingresados.';
  }
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.transf-calc').forEach(el => {
    el.addEventListener('input', calcTransfusion);
    el.addEventListener('change', calcTransfusion);
  });

  calcTransfusion();
});
</script>

<?php
require("footer.php");
?>