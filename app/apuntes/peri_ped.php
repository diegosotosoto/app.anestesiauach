<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Calculadora docente para analgesia epidural pediátrica. Integra carga inicial según nivel lumbar o torácico, top-up estándar y top-up conservador en lactantes pequeños, además de parámetros de PCA epidural según edad y peso.";
$formula = "La PCA se calcula a partir de la dosis máxima por hora en mg. De esa dosis, 2/3 se administran como infusión continua y 1/3 como bolo. Si la infusión calculada supera 5 mL/h, se limita a 5 mL/h. Lockout habitual: 30 min.";
$referencias = array(
  "1.- Suresh S, Ecoffey C, Bosenberg A, et al. ESRA/ASRA Recommendations on Local Anesthetics and Adjuvants Dosage in Pediatric Regional Anesthesia. Reg Anesth Pain Med. 2018.",
  "2.- Miller's Anesthesia. Pediatric Regional Anesthesia. Concepto de Tmax y top-up conservador con bupivacaína/levobupivacaína/ropivacaína.",
  "3.- Esquema docente UC de PCA epidural pediátrica: dosis máxima por hora en mg, con reparto 2/3 infusión y 1/3 bolo."
);

$icono_apunte = "<i class='fa-solid fa-baby pe-3 pt-2'></i>";
$titulo_apunte = "Peridural Pediátrica / PCA";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="peri-shell">

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
          .peri-shell{max-width:980px;margin:0 auto;}

          .peri-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .peri-topbar h1{color:#fff;}

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

          .small-note{
            font-size:.82rem;
            color:#667085;
            line-height:1.45;
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

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(5,1fr);
            gap:.65rem;
          }

          .choice-grid-2{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.65rem;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:78px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:1rem;
            padding:.8rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.15;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
          }

          .choice-btn i{
            font-size:1.1rem;
            margin-bottom:.35rem;
            color:#3559b7;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
            transform:translateY(-1px);
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
            font-size:1.02rem;
            font-weight:700;
            color:var(--text);
          }

          .result-num{
            font-size:1.7rem;
            font-weight:800;
            line-height:1;
            color:#3559b7;
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
            min-width:140px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .meta-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:.75rem;
          }

          .meta-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.9rem;
          }

          .meta-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#667085;
            margin-bottom:.25rem;
          }

          .meta-value{
            font-size:1rem;
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
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

          .teaching-wrap{
            border-radius:1.3rem;
            background:#f4f7fb;
            padding:1.2rem;
          }

          .teaching-title{
            text-align:center;
            font-size:.9rem;
            text-transform:uppercase;
            color:#64748b;
            letter-spacing:.05em;
          }

          .teaching-main{
            text-align:center;
            font-size:1.6rem;
            font-weight:800;
            margin-bottom:1rem;
            line-height:1.15;
          }

          .teaching-card{
            background:#fff;
            border-radius:1rem;
            padding:1rem;
            border:1px solid #e5e7eb;
            margin-bottom:.8rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{margin-bottom:.4rem;}

          @media (max-width:900px){
            .choice-grid{grid-template-columns:repeat(3,1fr);}
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .meta-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
          }

          @media (max-width:576px){
            .choice-grid{grid-template-columns:repeat(2,1fr);}
            .choice-grid-2{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .teaching-main{font-size:1.25rem;}
          }
        </style>

        <div class="peri-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Peridural Pediátrica / PCA</h1>
              <div class="subtle text-white-50">Carga inicial, top-up y parámetros de PCA según peso, nivel y rango etáreo.</div>
            </div>
            <span class="pill bg-light text-dark">Pediatría</span>
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
            <div class="section-title mb-3">Datos de entrada</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Peso</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="peso" value="">
                  <span class="input-group-text">kg</span>
                </div>

                <label class="form-label-lite">Nivel epidural</label>
                <div class="choice-grid-2">
                  <div>
                    <input class="choice-check" type="radio" name="nivel" id="nivel_lumbar" value="lumbar" checked>
                    <label class="choice-btn" for="nivel_lumbar">
                      <i class="fa-solid fa-arrow-down-wide-short"></i>
                      Lumbar
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="nivel" id="nivel_toracica" value="toracica">
                    <label class="choice-btn" for="nivel_toracica">
                      <i class="fa-solid fa-arrow-up-wide-short"></i>
                      Torácica
                    </label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Rango etáreo</label>
                <div class="choice-grid">
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_rn" value="rn" checked>
                    <label class="choice-btn" for="edad_rn">
                      <i class="fa-solid fa-baby"></i>
                      RN
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_1_4m" value="1_4m">
                    <label class="choice-btn" for="edad_1_4m">
                      <i class="fa-solid fa-baby"></i>
                      1–4 m
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_5_8m" value="5_8m">
                    <label class="choice-btn" for="edad_5_8m">
                      <i class="fa-solid fa-baby-carriage"></i>
                      5–8 m
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_9_12m" value="9_12m">
                    <label class="choice-btn" for="edad_9_12m">
                      <i class="fa-solid fa-child-reaching"></i>
                      9–12 m
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_gt1a" value="gt1a">
                    <label class="choice-btn" for="edad_gt1a">
                      <i class="fa-solid fa-child"></i>
                      &gt;1 año
                    </label>
                  </div>
                </div>
                <div class="small-note mt-2">
                  Los rangos etáreos ajustan la estrategia de PCA y modifican el comportamiento del top-up en lactantes pequeños.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- CARGA Y TOP UP -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Carga inicial y top-up</div>

            <div class="result-box mb-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Carga inicial intraoperatoria</div>
                  <div id="cargaNota" class="result-note">Levobupivacaína / Chiro 0,25% según nivel epidural.</div>
                </div>
                <div id="cargaValor" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Top-up estándar</div>
                  <div id="topupStdNota" class="result-note">Chiro 0,25% 0,2 mL/kg.</div>
                </div>
                <div id="topupStdValor" class="result-value">-</div>
              </div>
            </div>

            <div id="topupConservadorBox" class="warn-box mb-3" style="display:none;">
              <strong>Top-up conservador en &le;4 meses</strong><br>
              <div class="small-note mt-2 mb-2">
                En bupivacaína / levobupivacaína / ropivacaína, el Tmax es más tardío en lactantes pequeños. Para minimizar acumulación:
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Opción A</div>
                  <div class="result-note">Usar 1/3 de la dosis inicial y no reinyectar antes de 45 min.</div>
                </div>
                <div id="topupAValor" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Opción B</div>
                  <div class="result-note">Usar 1/2 de la dosis inicial y no reinyectar antes de 90 min.</div>
                </div>
                <div id="topupBValor" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Si requiere un nuevo top-up</div>
                  <div class="result-note">Reducir el top-up usado previamente a la mitad, respetando la misma demora.</div>
                </div>
                <div id="topupRepeticionValor" class="result-value">-</div>
              </div>
            </div>

            <div id="topupGeneralBox" class="good-box" style="display:block;">
              <strong>Top-up habitual</strong><br>
              <div class="small-note mt-2">
                En niños mayores, puede usarse el top-up estándar según peso y contexto. Aun así, evita redosificar precozmente con bupivacaína / levobupivacaína / ropivacaína sin reevaluar efecto clínico y tiempo transcurrido.
              </div>
            </div>
          </div>
        </div>

        <!-- PCA -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">PCA epidural postoperatoria</div>

            <div class="mint-box mb-3">
              <strong>Esquema docente:</strong><br>
              La dosis máxima por hora se expresa en <strong>mg/h</strong>. De esa dosis: <strong>2/3</strong> se usan como infusión continua y <strong>1/3</strong> como bolo. Si la infusión calculada supera <strong>5 mL/h</strong>, debe ajustarse a 5 mL/h. Lockout habitual: <strong>30 min</strong>.
            </div>

            <div class="meta-grid mb-3">
              <div class="meta-card">
                <div class="meta-label">Rango seleccionado</div>
                <div id="edadPcaTexto" class="meta-value">RN</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Dosis máxima por hora</div>
                <div id="maxHoraTexto" class="meta-value">-</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Infusión continua</div>
                <div id="infusionTexto" class="meta-value">-</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Bolo PCA</div>
                <div id="boloTexto" class="meta-value">-</div>
              </div>
            </div>

            <div id="pcaWarn" class="warn-box">
              <strong>Advertencia etaria</strong><br>
              <div id="pcaWarnText" class="small-note mt-2">
                En los más pequeños debe extremarse la vigilancia clínica y el seguimiento de signos de toxicidad.
              </div>
            </div>
          </div>
        </div>

        <!-- DOCENCIA -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">

              <div class="teaching-title">Tips para residentes</div>
              <div class="teaching-main">
                En epidural pediátrica, el error no suele ser “quedarse corto”, sino redosificar demasiado rápido o no respetar la edad
              </div>

              <div class="teaching-card">
                <b>La edad cambia la farmacocinética</b><br>
                En menores de 4 meses debes ser más conservador con top-up y con infusiones continuas. Si puedes, prefiere levobupivacaína o ropivacaína sobre bupivacaína racémica.
              </div>

              <div class="teaching-card">
                <b>Carga inicial no es lo mismo que top-up</b><br>
                La carga depende del nivel epidural. El top-up no debe copiar mecánicamente la carga inicial, especialmente en lactantes pequeños.
              </div>

              <div class="teaching-card">
                <b>Top-up precoz = riesgo de acumulación</b><br>
                Con bupivacaína / levobupivacaína / ropivacaína, respeta tiempos. Si debes redosificar en lactantes pequeños, usa fracciones de la dosis inicial y no olvides que una segunda redosis debe volver a reducirse.
              </div>

              <div class="teaching-card">
                <b>La PCA se calcula en mg, pero se programa en mL</b><br>
                Si trabajas con bupivacaína / levobupivacaína 0,1%, 1 mL equivale a 1 mg. Eso simplifica mucho la programación.
              </div>

              <div class="teaching-card">
                <b>No ignores el límite de 5 mL/h</b><br>
                Si la infusión calculada supera 5 mL/h, ajústala. No sirve calcular bonito si luego programas una bomba poco realista para el tamaño del paciente.
              </div>

              <div class="teaching-card">
                <b>Perlas prácticas</b><br>
                Línea de Tuffier más baja hasta el año de vida, la posición lateral suele favorecer el espacio epidural en niños, y el catéter idealmente no debería dejarse a más de 3 cm.
              </div>

            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Verificar siempre concentración real del anestésico local, edad exacta, condición hemodinámica y protocolos institucionales.
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

function round1(num){
  return Math.round(num * 10) / 10;
}

function formatOneOrRange(minVal, maxVal, unit=''){
  if(minVal === maxVal){
    return round1(minVal).toString().replace('.', ',') + unit;
  }
  return round1(minVal).toString().replace('.', ',') + ' – ' + round1(maxVal).toString().replace('.', ',') + unit;
}

function updatePeriPed(){
  const peso = parseFloat(document.getElementById('peso').value);
  const nivel = getSelected('nivel') || 'lumbar';
  const edad = getSelected('edadgrp') || 'rn';

  const cargaValor = document.getElementById('cargaValor');
  const cargaNota = document.getElementById('cargaNota');
  const topupStdValor = document.getElementById('topupStdValor');
  const topupStdNota = document.getElementById('topupStdNota');

  const topupConservadorBox = document.getElementById('topupConservadorBox');
  const topupGeneralBox = document.getElementById('topupGeneralBox');
  const topupAValor = document.getElementById('topupAValor');
  const topupBValor = document.getElementById('topupBValor');
  const topupRepeticionValor = document.getElementById('topupRepeticionValor');

  const edadPcaTexto = document.getElementById('edadPcaTexto');
  const maxHoraTexto = document.getElementById('maxHoraTexto');
  const infusionTexto = document.getElementById('infusionTexto');
  const boloTexto = document.getElementById('boloTexto');
  const pcaWarnText = document.getElementById('pcaWarnText');

  if(isNaN(peso) || peso <= 0){
    cargaValor.textContent = '-';
    topupStdValor.textContent = '-';
    topupAValor.textContent = '-';
    topupBValor.textContent = '-';
    topupRepeticionValor.textContent = '-';
    edadPcaTexto.textContent = '-';
    maxHoraTexto.textContent = '-';
    infusionTexto.textContent = '-';
    boloTexto.textContent = '-';
    pcaWarnText.textContent = 'Ingresa un peso para calcular.';
    return;
  }

  // Carga inicial
  let cargaMlKg = (nivel === 'lumbar') ? 0.5 : 0.3;
  let cargaMl = peso * cargaMlKg;
  let cargaMg = cargaMl * 2.5; // 0,25% = 2,5 mg/mL

  cargaValor.innerHTML = round1(cargaMl).toString().replace('.', ',') + ' mL<br><span class="small-note">' + round1(cargaMg).toString().replace('.', ',') + ' mg</span>';
  cargaNota.textContent = (nivel === 'lumbar')
    ? 'Levobupivacaína / Chiro 0,25% 0,5 mL/kg.'
    : 'Levobupivacaína / Chiro 0,25% 0,3 mL/kg.';

  // Top-up estándar
  let topupStdMl = peso * 0.2;
  let topupStdMg = topupStdMl * 2.5;
  topupStdValor.innerHTML = round1(topupStdMl).toString().replace('.', ',') + ' mL<br><span class="small-note">' + round1(topupStdMg).toString().replace('.', ',') + ' mg</span>';
  topupStdNota.textContent = 'Chiro 0,25% 0,2 mL/kg.';

  // Top-up conservador <=4 meses
  if(edad === 'rn' || edad === '1_4m'){
    topupConservadorBox.style.display = 'block';
    topupGeneralBox.style.display = 'none';

    const topA = cargaMl / 3;
    const topB = cargaMl / 2;

    topupAValor.innerHTML = round1(topA).toString().replace('.', ',') + ' mL<br><span class="small-note">' + round1(topA * 2.5).toString().replace('.', ',') + ' mg</span>';
    topupBValor.innerHTML = round1(topB).toString().replace('.', ',') + ' mL<br><span class="small-note">' + round1(topB * 2.5).toString().replace('.', ',') + ' mg</span>';
    topupRepeticionValor.innerHTML =
      'Si usaste A: ' + round1(topA / 2).toString().replace('.', ',') + ' mL<br>' +
      '<span class="small-note">Si usaste B: ' + round1(topB / 2).toString().replace('.', ',') + ' mL</span>';
  } else {
    topupConservadorBox.style.display = 'none';
    topupGeneralBox.style.display = 'block';
  }

  // PCA por edad (bupi / levobupi 0,1% = 1 mg/mL)
  let minMgKgHr = 0;
  let maxMgKgHr = 0;
  let edadTxt = '';
  let warnTxt = '';

  if(edad === 'rn'){
    minMgKgHr = 0.25;
    maxMgKgHr = 0.25;
    edadTxt = 'RN';
    warnTxt = 'Máxima cautela. En lactantes muy pequeños existe mayor riesgo de acumulación. Si es posible, preferir levobupivacaína o ropivacaína y vigilar signos de toxicidad.';
  }

  if(edad === '1_4m'){
    minMgKgHr = 0.30;
    maxMgKgHr = 0.30;
    edadTxt = '1–4 meses';
    warnTxt = 'Grupo especialmente sensible. El top-up debe ser conservador y la infusión continua requiere vigilancia estrecha. No asumir meseta farmacocinética estable.';
  }

  if(edad === '5_8m'){
    minMgKgHr = 0.35;
    maxMgKgHr = 0.40;
    edadTxt = '5–8 meses';
    warnTxt = 'Aún existe riesgo de acumulación relativo. Usa el extremo inferior del rango si hay dudas clínicas, fragilidad o recuperación lenta.';
  }

  if(edad === '9_12m'){
    minMgKgHr = 0.40;
    maxMgKgHr = 0.40;
    edadTxt = '9–12 meses';
    warnTxt = 'Mayor margen farmacocinético que en lactantes pequeños, pero sigue siendo fundamental vigilar clínica, bloqueo y necesidad real de rescates.';
  }

  if(edad === 'gt1a'){
    minMgKgHr = 0.50;
    maxMgKgHr = 0.50;
    edadTxt = '>1 año';
    warnTxt = 'En mayores de 1 año puedes usar el esquema habitual por peso. Si es adolescente, recuerda que en algunas referencias se usan límites de 0,3 mg/kg/h para bupi/levobupi y 0,4 mg/kg/h para ropi.';
  }

  const minMaxHoraMg = peso * minMgKgHr;
  const maxMaxHoraMg = peso * maxMgKgHr;

  let minInf = (minMaxHoraMg * 2 / 3);
  let maxInf = (maxMaxHoraMg * 2 / 3);
  let minBol = (minMaxHoraMg / 3);
  let maxBol = (maxMaxHoraMg / 3);

  let infusionCapped = false;
  if(minInf > 5){ minInf = 5; infusionCapped = true; }
  if(maxInf > 5){ maxInf = 5; infusionCapped = true; }

  edadPcaTexto.textContent = edadTxt;
  maxHoraTexto.textContent = formatOneOrRange(minMaxHoraMg, maxMaxHoraMg, ' mg/h');
  infusionTexto.innerHTML = formatOneOrRange(minInf, maxInf, ' mL/h') + (infusionCapped ? '<br><span class="small-note">ajustada a 5 mL/h</span>' : '');
  boloTexto.innerHTML = formatOneOrRange(minBol, maxBol, ' mL') + '<br><span class="small-note">lockout 30 min</span>';
  pcaWarnText.textContent = warnTxt;
}

document.addEventListener('DOMContentLoaded', function(){
  document.getElementById('peso').addEventListener('input', updatePeriPed);

  document.querySelectorAll('input[name="nivel"]').forEach(el => {
    el.addEventListener('change', updatePeriPed);
  });

  document.querySelectorAll('input[name="edadgrp"]').forEach(el => {
    el.addEventListener('change', updatePeriPed);
  });

  updatePeriPed();
});
</script>

<?php require("footer.php"); ?>