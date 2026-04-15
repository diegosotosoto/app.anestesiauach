<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para apoyo en reposición de calcio intraoperatoria. Integra calcio iónico, contexto clínico, formulación elegida y acceso venoso para sugerir interpretación, bolus orientativo, mantención y advertencias anestésicas relevantes.";
$formula = "La lógica del apunte prioriza calcio iónico, gravedad clínica, contexto perioperatorio y formulación usada. La reposición se expresa en calcio elemental. Referencias prácticas: gluconato de calcio 10% = 9,3 mg/mL de calcio elemental; cloruro de calcio 10% = 27 mg/mL de calcio elemental.";
$referencias = array(
  "1.- OpenAnesthesia. Hypocalcemia. Actualizado 30 abril 2025.",
  "2.- Aguilera IM, Vaughan RS. Calcium and the anaesthetist. Anaesthesia. 2000;55(8):779-790.",
  "3.- DailyMed. Calcium Gluconate Injection, USP 10%: 9,3 mg/mL de calcio elemental.",
  "4.- DailyMed. Calcium Chloride Injection 10%: 27 mg/mL de calcio elemental; administrar lentamente por vena central o profunda.",
  "5.- Nota docente del usuario: reposición intraoperatoria de calcio, hipocalcemia por citrato, objetivos intraoperatorios y precauciones farmacológicas."
);

$icono_apunte = "<i class='fa-solid fa-bolt pe-3 pt-2'></i>";
$titulo_apunte = "Reposición de Calcio Intraoperatoria";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; border:0; --bs-border-opacity:0;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="cal-shell">

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
          .cal-shell{max-width:1060px;margin:0 auto;}

          .cal-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .cal-topbar h1{color:#fff;}

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
            min-height:74px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:.9rem;
            padding:.72rem .8rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.12;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
            font-size:.9rem;
          }

          .choice-btn small{
            font-weight:500;
            color:#667085;
            margin-top:.15rem;
            line-height:1.22;
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
            grid-template-columns:repeat(5,1fr);
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

          .main-result-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
          }

          .main-result-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .main-result-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .main-result-value{
            font-size:1.9rem;
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
            min-width:210px;
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

          @media (max-width:980px){
            .summary-grid{grid-template-columns:repeat(3,1fr);}
          }

          @media (max-width:900px){
            .choice-grid-4{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
            .summary-grid{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:576px){
            .choice-grid-4,.choice-grid-3,.choice-grid-2{grid-template-columns:repeat(2,1fr);}
            .summary-grid{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="cal-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • hemodinamia y transfusión</div>
              <h1 class="h3 mb-2">Reposición de Calcio Intraoperatoria</h1>
              <div class="subtle text-white-50">Interpretación por calcio iónico, gravedad clínica, formulación elegida y advertencias anestésicas.</div>
            </div>
            <span class="pill bg-light text-dark">Calcio</span>
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

        <!-- A. DATOS DE ENTRADA -->
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

                <label class="form-label-lite">Calcio iónico</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.01" id="cai" value="">
                  <span class="input-group-text">mmol/L</span>
                </div>

                <div class="small-note">
                  Orientación rápida: normal 1,0–1,25 mmol/L. Objetivo intraoperatorio práctico: mantener &gt;0,8 mmol/L.
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Gravedad clínica</label>
                <div class="choice-grid-3 mb-3">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="gravedad" id="grav_incidental" value="incidental" checked>
                    <label class="choice-btn" for="grav_incidental">
                      <i class="fa-regular fa-circle"></i>
                      Incidental
                      <small>sin síntomas ni QT</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="gravedad" id="grav_qt" value="qt">
                    <label class="choice-btn" for="grav_qt">
                      <i class="fa-solid fa-wave-square"></i>
                      QT / tetania
                      <small>tetania, parestesias, QT</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="gravedad" id="grav_shock" value="shock">
                    <label class="choice-btn" for="grav_shock">
                      <i class="fa-solid fa-triangle-exclamation"></i>
                      Severo
                      <small>laringoespasmo, convulsión, hipotensión</small>
                    </label>
                  </div>
                </div>

                <label class="form-label-lite">Contexto dominante</label>
                <div class="choice-grid-4">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="contexto" id="ctx_aislado" value="aislado" checked>
                    <label class="choice-btn" for="ctx_aislado">
                      <i class="fa-solid fa-vial-circle-check"></i>
                      Aislado
                      <small>bajo Ca i sin gran pérdida activa</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="contexto" id="ctx_citrato" value="citrato">
                    <label class="choice-btn" for="ctx_citrato">
                      <i class="fa-solid fa-droplet"></i>
                      Citrato
                      <small>transfusión masiva / rápida</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="contexto" id="ctx_cpb" value="cpb">
                    <label class="choice-btn" for="ctx_cpb">
                      <i class="fa-solid fa-heart-pulse"></i>
                      CPB / ECMO
                      <small>hemodilución / citrato / proteínas</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="contexto" id="ctx_cuello" value="cuello">
                    <label class="choice-btn" for="ctx_cuello">
                      <i class="fa-solid fa-user-doctor"></i>
                      Cuello
                      <small>post-tiroides / paratiroides</small>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- B. SELECCIÓN DE SAL -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Formulación y acceso</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Sal de calcio</label>
                <div class="choice-grid-2">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="sal" id="sal_gluconato" value="gluconato" checked>
                    <label class="choice-btn" for="sal_gluconato">
                      <i class="fa-solid fa-syringe"></i>
                      Gluconato 10%
                      <small>9,3 mg/mL elemental</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="sal" id="sal_cloruro" value="cloruro">
                    <label class="choice-btn" for="sal_cloruro">
                      <i class="fa-solid fa-bolt"></i>
                      Cloruro 10%
                      <small>27 mg/mL elemental</small>
                    </label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Acceso venoso disponible</label>
                <div class="choice-grid-2">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="acceso" id="acc_periferico" value="periferico" checked>
                    <label class="choice-btn" for="acc_periferico">
                      <i class="fa-solid fa-hand-holding-medical"></i>
                      Periférico
                      <small>mejor para gluconato</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="acceso" id="acc_central" value="central">
                    <label class="choice-btn" for="acc_central">
                      <i class="fa-solid fa-circle-nodes"></i>
                      Central
                      <small>preferido para cloruro</small>
                    </label>
                  </div>
                </div>
                <div class="small-note mt-2">
                  El cloruro de calcio es más concentrado e irritante. Si eliges cloruro con acceso periférico, el apunte marcará la selección como insegura.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- C. RESUMEN -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Tarjeta resumen</div>

            <div class="summary-grid">
              <div class="summary-card">
                <div class="summary-label">Peso</div>
                <div id="sumPeso" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Ca i</div>
                <div id="sumCai" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Gravedad</div>
                <div id="sumGrav" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Contexto</div>
                <div id="sumCtx" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Sal / acceso</div>
                <div id="sumSal" class="summary-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <!-- D. RESULTADO PRINCIPAL -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Resultado principal</div>

            <div class="main-result-card">
              <div class="main-result-label">Conducta orientativa</div>
              <div class="main-result-note">Basada en calcio iónico, severidad, contexto y seguridad del acceso</div>
              <div id="mainDecision" class="main-result-value">-</div>
            </div>

            <div class="mt-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Interpretación fisiológica</div>
                  <div class="result-note">Umbrales prácticos basados en calcio iónico y repercusión clínica.</div>
                </div>
                <div id="outSeverity" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Bolus sugerido</div>
                  <div class="result-note">Expresado en calcio elemental y convertido a la sal elegida.</div>
                </div>
                <div id="outBolus" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Mantención orientativa</div>
                  <div class="result-note">Útil si hay pérdidas en curso, citrato, CPB o riesgo de rebote. No siempre se requiere.</div>
                </div>
                <div id="outMaint" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Velocidad / forma de administración</div>
                  <div class="result-note">Lenta y vigilada, especialmente con cloruro de calcio.</div>
                </div>
                <div id="outAdmin" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Objetivo inmediato</div>
                  <div class="result-note">Meta práctica perioperatoria.</div>
                </div>
                <div id="outGoal" class="result-value">&gt; 0,8 mmol/L</div>
              </div>
            </div>
          </div>
        </div>

        <!-- E. INTERPRETACIÓN -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Interpretación clínica</div>

            <div id="warnAccess" class="danger-box" style="display:none;">
              <strong>Selección insegura de acceso</strong><br>
              <div class="small-note mt-2" id="warnAccessText">
                -
              </div>
            </div>

            <div id="riskBox" class="good-box">
              <strong id="riskTitle">Lectura clínica</strong><br>
              <div id="riskText" class="small-note mt-2">
                Ingresa peso y calcio iónico para activar la interpretación.
              </div>
            </div>

            <div id="anesthBox" class="warn-box mt-3">
              <strong>Implicancias anestésicas</strong><br>
              <div id="anesthText" class="small-note mt-2">-</div>
            </div>

            <div id="causeBox" class="mint-box mt-3">
              <strong>Causa probable / estrategia adicional</strong><br>
              <div id="causeText" class="small-note mt-2">-</div>
            </div>
          </div>
        </div>

        <!-- F. DOCENCIA -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">F. Tips docentes</div>

            <div class="warn-box">
              <ul class="tip-list">
                <li>No trates una hipocalcemia “de papel” basada solo en calcio total si el calcio iónico es normal. La hipoalbuminemia baja el calcio total, no necesariamente el iónico.</li>
                <li>La alcalosis aumenta la unión del calcio a albúmina y baja el calcio iónico. Hiperventilar puede empeorar tetania, QT prolongado y laringoespasmo.</li>
                <li>En citrato, transfusión masiva y CPB, el problema suele ser dinámico: importa más recontrolar calcio iónico que “corregir una vez”.</li>
                <li>Si el paciente está en digoxina, la reposición rápida de calcio puede precipitar arritmias. Sé especialmente prudente.</li>
                <li>El cloruro de calcio es más potente por mL, pero también más agresivo para el tejido. Si no tienes acceso central, piensa primero en gluconato.</li>
                <li>La hipocalcemia puede potenciar bloqueo neuromuscular no despolarizante y empeorar depresión miocárdica con halogenados.</li>
                <li>Hipomagnesemia puede perpetuar la hipocalcemia. Si el calcio “no se sostiene”, piensa en magnesio.</li>
                <li>No uses calcio como reflejo automático tras reperfusión o after CPB si el calcio iónico ya es adecuado: el exceso puede ser inútil o potencialmente dañino.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Prioriza siempre calcio iónico, estado hemodinámico, velocidad de pérdidas, contexto transfusional y juicio clínico. Los cálculos son orientativos.
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

function fmt(num, decimals=1){
  if(num === null || num === undefined || isNaN(num)) return '-';
  return Number(num).toFixed(decimals).replace('.', ',');
}

function severityLabel(val){
  if(val === 'incidental') return 'Incidental';
  if(val === 'qt') return 'QT / tetania';
  return 'Severo';
}

function contextLabel(val){
  if(val === 'aislado') return 'Aislado';
  if(val === 'citrato') return 'Citrato / transfusión';
  if(val === 'cpb') return 'CPB / ECMO';
  return 'Cuello / hipopara';
}

function saltLabel(val){
  return val === 'gluconato' ? 'Gluconato 10%' : 'Cloruro 10%';
}

function accessLabel(val){
  return val === 'periferico' ? 'Periférico' : 'Central';
}

function updateCalciumNote(){
  const peso = parseFloat(document.getElementById('peso').value);
  const cai = parseFloat(document.getElementById('cai').value);
  const gravedad = getSelected('gravedad') || 'incidental';
  const contexto = getSelected('contexto') || 'aislado';
  const sal = getSelected('sal') || 'gluconato';
  const acceso = getSelected('acceso') || 'periferico';

  const mgPerMl = (sal === 'gluconato') ? 9.3 : 27.0;

  document.getElementById('sumPeso').textContent = (!isNaN(peso) && peso > 0) ? fmt(peso,1) + ' kg' : '-';
  document.getElementById('sumCai').textContent = (!isNaN(cai) && cai > 0) ? fmt(cai,2) + ' mmol/L' : '-';
  document.getElementById('sumGrav').textContent = severityLabel(gravedad);
  document.getElementById('sumCtx').textContent = contextLabel(contexto);
  document.getElementById('sumSal').textContent = saltLabel(sal) + ' · ' + accessLabel(acceso);

  const warnAccess = document.getElementById('warnAccess');
  const warnAccessText = document.getElementById('warnAccessText');

  if(sal === 'cloruro' && acceso === 'periferico'){
    warnAccess.style.display = 'block';
    warnAccessText.textContent = 'El cloruro de calcio 10% no es una buena elección por vía periférica por riesgo de extravasación, necrosis tisular y calcinosis. Usa acceso central o cambia a gluconato.';
  } else {
    warnAccess.style.display = 'none';
    warnAccessText.textContent = '-';
  }

  if(isNaN(peso) || peso <= 0 || isNaN(cai) || cai <= 0){
    document.getElementById('mainDecision').textContent = '-';
    document.getElementById('outSeverity').textContent = '-';
    document.getElementById('outBolus').textContent = '-';
    document.getElementById('outMaint').textContent = '-';
    document.getElementById('outAdmin').textContent = '-';
    document.getElementById('riskTitle').textContent = 'Lectura clínica';
    document.getElementById('riskText').textContent = 'Ingresa peso y calcio iónico para activar la interpretación.';
    document.getElementById('riskBox').className = 'good-box';
    document.getElementById('anesthText').textContent = '-';
    document.getElementById('causeText').textContent = '-';
    return;
  }

  let interpre = '';
  let riskTitle = '';
  let riskText = '';
  let riskClass = 'good-box';

  if(cai >= 1.0){
    interpre = 'Normal';
    riskTitle = 'Sin hipocalcemia significativa';
    riskText = 'Con calcio iónico en rango normal, evita “dar calcio porque sí”. Si el calcio total está bajo pero el iónico está bien, piensa primero en albúmina.';
    riskClass = 'good-box';
  } else if(cai >= 0.8){
    interpre = 'Bajo leve';
    riskTitle = 'Bajo para laboratorio, pero sobre meta intraoperatoria';
    riskText = 'Está por debajo del rango normal, pero aún sobre la meta intraoperatoria práctica de 0,8 mmol/L. No siempre requiere bolus si el paciente está estable y sin síntomas.';
    riskClass = 'warn-box';
  } else if(cai >= 0.75){
    interpre = 'Bajo relevante';
    riskTitle = 'Por debajo del objetivo intraoperatorio';
    riskText = 'Ya está bajo la meta práctica intraoperatoria. Si hay QT prolongado, tetania o contexto dinámico, la reposición es razonable.';
    riskClass = 'warn-box';
  } else if(cai >= 0.60){
    interpre = 'Hipocalcemia significativa';
    riskTitle = 'Riesgo eléctrico y hemodinámico';
    riskText = 'Con calcio iónico <0,75 mmol/L aumenta el riesgo de QT prolongado; si se acerca a 0,6 mmol/L la contractilidad puede deprimirse claramente.';
    riskClass = 'danger-box';
  } else {
    interpre = 'Hipocalcemia crítica';
    riskTitle = 'Emergencia metabólica';
    riskText = 'Con calcio iónico <0,6 mmol/L puede haber depresión ventricular marcada, hipotensión, laringoespasmo, convulsiones y riesgo vital.';
    riskClass = 'danger-box';
  }

  let bolusMg = 0;
  if(cai >= 0.8 && gravedad === 'incidental'){
    bolusMg = 0;
  } else if((cai >= 0.75 && cai < 0.8) || gravedad === 'qt'){
    bolusMg = 100;
  } else if(cai < 0.75 || gravedad === 'shock'){
    bolusMg = 200;
  }

  // Si elección insegura, no dar plan automático
  let unsafeSelection = (sal === 'cloruro' && acceso === 'periferico');

  let bolusText = 'No rutinario';
  let mainDecision = 'Observar y recontrolar';
  if(bolusMg > 0 && !unsafeSelection){
    const bolusMl = bolusMg / mgPerMl;
    bolusText = fmt(bolusMg,0) + ' mg elemental<br><span class="small-note">≈ ' + fmt(bolusMl,1) + ' mL de ' + saltLabel(sal) + '</span>';
    mainDecision = (bolusMg === 100 ? 'Bolus prudente' : 'Bolus de rescate');
  }
  if(unsafeSelection){
    mainDecision = 'Cambiar formulación o acceso';
    bolusText = 'No sugerido<br><span class="small-note">selección insegura</span>';
  }

  let maintText = 'No de rutina';
  if(!unsafeSelection && (contexto === 'citrato' || contexto === 'cpb' || contexto === 'cuello' || cai < 0.75 || gravedad !== 'incidental')){
    const maintLowMgH = peso * 0.5;
    const maintHighMgH = peso * 1.5;
    const maintLowMlH = maintLowMgH / mgPerMl;
    const maintHighMlH = maintHighMgH / mgPerMl;
    maintText = fmt(maintLowMgH,0) + '–' + fmt(maintHighMgH,0) + ' mg/h<br><span class="small-note">≈ ' + fmt(maintLowMlH,1) + '–' + fmt(maintHighMlH,1) + ' mL/h</span>';
  }

  let adminText = '';
  if(sal === 'gluconato'){
    adminText = 'Diluir y pasar lento<br><span class="small-note">bolus en ~10 min</span>';
  } else {
    adminText = 'Vena central / profunda<br><span class="small-note">no exceder 1 mL/min</span>';
  }
  if(unsafeSelection){
    adminText = 'No recomendado<br><span class="small-note">cloruro por periférica</span>';
  }

  let anesthText = 'La hipocalcemia puede potenciar bloqueo neuromuscular no despolarizante, favorecer laringoespasmo y empeorar la depresión miocárdica de halogenados. Evita alcalosis por hiperventilación, porque baja aún más el calcio iónico.';
  if(cai < 0.75){
    anesthText += ' Con este calcio iónico, vigila QT, contractilidad y respuesta hemodinámica muy de cerca.';
  }
  if(contexto === 'citrato'){
    anesthText += ' En citrato, el problema puede reaparecer mientras siga entrando carga de productos sanguíneos.';
  }
  if(contexto === 'cpb'){
    anesthText += ' En CPB/ECMO, hemodilución, citrato y soluciones pobres en proteínas pueden mantener el calcio iónico bajo.';
  }

  let causeText = '';
  if(contexto === 'aislado'){
    causeText = 'Piensa en hipocalcemia verdadera solo si el calcio iónico está bajo. Si el total está bajo con albúmina baja y el iónico es normal, no “corrijas el número equivocado”.';
  } else if(contexto === 'citrato'){
    causeText = 'El citrato quelará calcio y puede causar depresión miocárdica, coagulopatía e hipotensión. Recontrola calcio iónico después de cada intervención relevante o si continúa la transfusión rápida.';
  } else if(contexto === 'cpb'){
    causeText = 'En CPB/ECMO, la caída puede ser multifactorial. Corrige solo lo suficiente para mantener estabilidad y evita sobretratar si el calcio iónico ya es adecuado.';
  } else {
    causeText = 'Tras cirugía tiroidea/paratiroidea, la hipocalcemia puede presentarse con tetania, QT prolongado o laringoespasmo. Si el cuadro es convincente, no esperes demasiado para tratar.';
  }

  if(gravedad === 'shock'){
    causeText += ' Si la hipotensión es refractaria a vasopresores y el calcio iónico está bajo, la reposición tiene más sentido clínico.';
  }

  if(cai >= 0.8 && contexto === 'aislado' && gravedad === 'incidental'){
    causeText += ' En este escenario, monitorizar y buscar causa suele ser mejor que dar bolos reflejos.';
  }

  if((contexto === 'cpb' || contexto === 'citrato') && cai >= 0.8){
    causeText += ' Recuerda que el calcio también se ha relacionado con lesión por reperfusión y stunning; no persigas una “hipercorrección”.';
  }

  document.getElementById('mainDecision').textContent = mainDecision;
  document.getElementById('outSeverity').innerHTML = interpre + '<br><span class="small-note">' + fmt(cai,2) + ' mmol/L</span>';
  document.getElementById('outBolus').innerHTML = bolusText;
  document.getElementById('outMaint').innerHTML = maintText;
  document.getElementById('outAdmin').innerHTML = adminText;

  document.getElementById('riskTitle').textContent = riskTitle;
  document.getElementById('riskText').textContent = riskText;
  document.getElementById('riskBox').className = riskClass;
  document.getElementById('anesthText').textContent = anesthText;
  document.getElementById('causeText').textContent = causeText;
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', updateCalciumNote);
    el.addEventListener('change', updateCalciumNote);
  });

  document.querySelectorAll('.calc-trigger-radio').forEach(el => {
    el.addEventListener('change', updateCalciumNote);
  });

  updateCalciumNote();
});
</script>

<?php require("footer.php"); ?>