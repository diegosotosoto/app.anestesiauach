<?php
$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para estimar capacidad funcional con el cuestionario DASI en español adaptado a población chilena. Permite obtener puntaje total, VO2 estimado, METs estimados y una orientación práctica para evaluación perioperatoria, especialmente en cirugía no cardíaca.";
$formula = "Puntaje DASI = suma de respuestas positivas. VO2 estimado = (DASI x 0,43) + 9,6. METs estimados = VO2 / 3,5. Regla práctica perioperatoria: una capacidad funcional < 4 METs se considera reducida y obliga a interpretar el contexto clínico y quirúrgico con mayor cautela.";
$referencias = array(
  "1.- Hlatky MA, Boineau RE, Higginbotham MB, et al. A brief self-administered questionnaire to determine functional capacity (The Duke Activity Status Index). Am J Cardiol. 1989;64:651-654.",
  "2.- Varleta P, Von Chrismar M, Manzano G, et al. Evaluación y Utilidad del Cuestionario DASI para la Estimación de Capacidad Funcional en Población Chilena. Rev Chil Cardiol. 2021;40(2):104-113.",
  "3.- Galleguillos G, Cecioni G, Pereira F, Álvarez F. Evaluación del riesgo cardíaco previo a la cirugía no cardíaca. Rev Chil Anest. 2022;51(5):510-520.",
  "4.- Wijeysundera DN, Beattie WS, Hillis GS, et al. Integration of the Duke Activity Status Index into preoperative risk evaluation: a multicenter prospective cohort study. Br J Anaesth. 2020;124(3):261-270.",
  "5.- Kristensen SD, Knuuti J, Saraste A, et al. 2014 ESC/ESA Guidelines on non-cardiac surgery: cardiovascular assessment and management. Eur Heart J. 2014;35:2383-2431."
);

$icono_apunte = "<i class='fa-solid fa-heart-pulse pe-3 pt-2'></i>";
$titulo_apunte = "DASI • Capacidad Funcional";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; border:0; --bs-border-opacity:0;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="dasi-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --good-bg:#eefaf3;
            --good-bd:#bfe4cb;
            --warn-bg:#fff8e8;
            --warn-bd:#ecd99a;
            --danger-bg:#fff1ef;
            --danger-bd:#efc2bb;
            --mint-bg:#eef6ff;
            --mint-bd:#cfe0ff;
            --line:#dfe7f2;
            --soft:#f8fafc;
            --text:#1f2a37;
            --muted:#667085;
          }

          .dasi-shell{
            max-width:1080px;
            margin:0 auto;
          }

          .dasi-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .dasi-topbar h1{color:#fff;}
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
            color:var(--muted);
          }

          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
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
            color:#fff;
          }

          .info-box-content{
            padding:1rem;
            display:none;
            border-top:1px solid #e9eef5;
          }

          .calc-grid{
            display:grid;
            grid-template-columns:1.2fr .8fr;
            gap:1rem;
          }

          .question-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.75rem;
          }

          .question-card{
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:1rem;
            padding:.9rem;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
          }

          .question-text{
            font-size:.92rem;
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
            margin-bottom:.7rem;
          }

          .question-points{
            font-size:.78rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .choice-inline{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.5rem;
          }

          .choice-check{
            display:none;
          }

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:58px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:.85rem;
            padding:.55rem .45rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.1;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
            font-size:.86rem;
          }

          .choice-btn i{
            font-size:1rem;
            margin-bottom:.22rem;
            color:#3559b7;
          }

          .choice-btn small{
            margin-top:.12rem;
            font-size:.7rem;
            color:#667085;
            font-weight:500;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
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
            font-weight:800;
            color:#1f2a37;
            line-height:1.35;
          }

          .main-result-card,
          .dose-result-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
          }

          .dose-result-card{
            margin-top:1rem;
          }

          .main-result-label,
          .dose-result-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .main-result-note,
          .dose-result-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .main-result-value{
            font-size:2rem;
            font-weight:800;
            line-height:1.05;
            color:#27458f;
          }

          .dose-result-value{
            font-size:1.5rem;
            font-weight:800;
            line-height:1.18;
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
            min-width:240px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .good-box,.warn-box,.danger-box,.mint-box{
            border-radius:1rem;
            padding:1rem;
          }

          .good-box{background:var(--good-bg);border:1px solid var(--good-bd);}
          .warn-box{background:var(--warn-bg);border:1px solid var(--warn-bd);}
          .danger-box{background:var(--danger-bg);border:1px solid var(--danger-bd);}
          .mint-box{background:var(--mint-bg);border:1px solid var(--mint-bd);}

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{
            margin-bottom:.45rem;
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

          @media (max-width:980px){
            .calc-grid{grid-template-columns:1fr;}
            .summary-grid{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:700px){
            .question-grid{grid-template-columns:1fr;}
            .summary-grid{grid-template-columns:1fr;}
            .result-row{
              flex-direction:column;
              align-items:flex-start;
            }
            .result-value{
              min-width:0;
              text-align:left;
            }
          }
        </style>

        <div class="dasi-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • evaluación funcional perioperatoria</div>
              <h1 class="h3 mb-2">DASI • Duke Activity Status Index</h1>
              <div class="subtle text-white-50">Capacidad funcional estimada en METs y orientación perioperatoria práctica.</div>
            </div>
            <span class="pill bg-light text-dark">METs</span>
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
              <b>Fórmula / comentario:</b><br>
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
            <div class="section-title mb-3">A. Cuestionario DASI</div>

            <div class="calc-grid">
              <div class="card-block">
                <div class="question-grid">

                  <?php
                  $preguntas = array(
                    array("id"=>"q1","texto"=>"¿Puede Usted realizar sus actividades de autocuidado, tales como alimentarse, vestirse, bañarse, o usar el baño?","pts"=>"2.75"),
                    array("id"=>"q2","texto"=>"¿Puede Usted caminar dentro de su casa y alrededor de ésta?","pts"=>"1.75"),
                    array("id"=>"q3","texto"=>"¿Puede Usted caminar una o dos cuadras, sin pendiente?","pts"=>"2.75"),
                    array("id"=>"q4","texto"=>"¿Puede subir un tramo de escalones (ej: dos pisos de escaleras) sin detenerse?","pts"=>"5.50"),
                    array("id"=>"q5","texto"=>"¿Puede correr una pequeña distancia?","pts"=>"8.00"),
                    array("id"=>"q6","texto"=>"¿Puede realizar trabajos livianos en su casa tales como sacudir el polvo, o lavar platos?","pts"=>"2.70"),
                    array("id"=>"q7","texto"=>"¿Puede realizar trabajo moderado en su casa tal como pasar la aspiradora, barrer los pisos, o acarrear comestibles desde una tienda o mercado?","pts"=>"3.50"),
                    array("id"=>"q8","texto"=>"¿Puede realizar trabajo pesado en su casa tal como el fregado de piso, o levantar o desplazar muebles pesados?","pts"=>"8.00"),
                    array("id"=>"q9","texto"=>"¿Puede hacer trabajos en el jardín tales como rastrillar las hojas, desmalezar o empujar una cortadora de pasto?","pts"=>"4.50"),
                    array("id"=>"q10","texto"=>"¿Puede tener relaciones sexuales?","pts"=>"5.25"),
                    array("id"=>"q11","texto"=>"¿Puede participar en actividades recreacionales físicas de intensidad moderada como baile entretenido, zumba, jugar tenis (en dobles), jugar golf o lanzar pelotas?","pts"=>"6.00"),
                    array("id"=>"q12","texto"=>"¿Puede participar en deportes intensos como natación, tenis individual, fútbol, baloncesto o esquí?","pts"=>"7.50")
                  );

                  foreach($preguntas as $p){
                    echo "
                    <div class='question-card'>
                      <div class='question-text'>{$p['texto']}</div>
                      <div class='question-points'>Puntaje si responde sí: <strong>{$p['pts']}</strong></div>
                      <div class='choice-inline'>
                        <div>
                          <input class='choice-check dasi-trigger' type='radio' name='{$p['id']}' id='{$p['id']}_si' value='{$p['pts']}'>
                          <label class='choice-btn' for='{$p['id']}_si'>
                            <i class='fa-solid fa-check'></i>
                            Sí
                            <small>Suma puntaje</small>
                          </label>
                        </div>
                        <div>
                          <input class='choice-check dasi-trigger' type='radio' name='{$p['id']}' id='{$p['id']}_no' value='0' checked>
                          <label class='choice-btn' for='{$p['id']}_no'>
                            <i class='fa-solid fa-xmark'></i>
                            No
                            <small>No suma</small>
                          </label>
                        </div>
                      </div>
                    </div>";
                  }
                  ?>
                </div>
              </div>

              <div class="card-block">
                <div class="section-title mb-3">Parámetros de interpretación</div>

                <label class="form-label-lite">Contexto quirúrgico</label>
                <div class="choice-inline mb-3" style="grid-template-columns:1fr 1fr;">
                  <div>
                    <input class="choice-check dasi-trigger" type="radio" name="surgeryRisk" id="risk_low" value="low" checked>
                    <label class="choice-btn" for="risk_low">
                      <i class="fa-solid fa-user-doctor"></i>
                      Bajo / intermedio
                      <small>Cx habitual</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check dasi-trigger" type="radio" name="surgeryRisk" id="risk_high" value="high">
                    <label class="choice-btn" for="risk_high">
                      <i class="fa-solid fa-heart-circle-exclamation"></i>
                      Alto riesgo
                      <small>Mayor estrés CV</small>
                    </label>
                  </div>
                </div>

                <label class="form-label-lite">Síntomas o datos de alarma cardiovasculares</label>
                <div class="choice-inline mb-3" style="grid-template-columns:1fr 1fr;">
                  <div>
                    <input class="choice-check dasi-trigger" type="radio" name="activeCardiac" id="active_no" value="no" checked>
                    <label class="choice-btn" for="active_no">
                      <i class="fa-solid fa-shield-heart"></i>
                      No
                      <small>sin alarma activa</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check dasi-trigger" type="radio" name="activeCardiac" id="active_yes" value="yes">
                    <label class="choice-btn" for="active_yes">
                      <i class="fa-solid fa-triangle-exclamation"></i>
                      Sí
                      <small>angina, IC, arritmia, etc.</small>
                    </label>
                  </div>
                </div>

                <div class="mint-box">
                  <strong>Recordatorio clínico</strong><br>
                  <div class="small-note mt-2">
                    El DASI orienta la capacidad funcional, pero no reemplaza la evaluación clínica integral. Si existen síntomas cardiovasculares activos o una condición inestable, la conducta no debe depender solo del puntaje.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Tarjeta resumen</div>

            <div class="summary-grid">
              <div class="summary-card">
                <div class="summary-label">Puntaje DASI</div>
                <div id="sumDasi" class="summary-value">0</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">VO₂ estimado</div>
                <div id="sumVo2" class="summary-value">0 ml/kg/min</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">METs estimados</div>
                <div id="sumMets" class="summary-value">0</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Capacidad funcional</div>
                <div id="sumCategory" class="summary-value">No calculada</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Resultado principal</div>

            <div class="main-result-card">
              <div class="main-result-label">Interpretación principal</div>
              <div class="main-result-note">Estimación funcional rápida para apoyo en evaluación perioperatoria</div>
              <div id="mainDecision" class="main-result-value">Capacidad funcional no calculada</div>
            </div>

            <div class="dose-result-card">
              <div class="dose-result-label">Conducta sugerida</div>
              <div class="dose-result-note">Guía operativa rápida según METs estimados y contexto clínico</div>
              <div id="mainPlan" class="dose-result-value">Complete el cuestionario</div>
            </div>

            <div class="mt-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Clasificación funcional</div>
                  <div class="result-note">Umbrales clásicos de capacidad funcional en METs.</div>
                </div>
                <div id="outClass" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Riesgo perioperatorio práctico</div>
                  <div class="result-note">En anestesia suele importar especialmente si el paciente está por debajo de 4 METs.</div>
                </div>
                <div id="outPeriop" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">VO₂ estimado</div>
                  <div class="result-note">Orientación fisiológica derivada del puntaje DASI.</div>
                </div>
                <div id="outVo2" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">METs estimados</div>
                  <div class="result-note">Cálculo directo desde VO₂ estimado.</div>
                </div>
                <div id="outMets" class="result-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Interpretación clínica</div>

            <div id="riskBox" class="good-box">
              <strong id="riskTitle">Lectura clínica</strong><br>
              <div id="riskText" class="small-note mt-2">
                Responda el cuestionario para obtener una estimación funcional y una orientación perioperatoria.
              </div>
            </div>

            <div class="warn-box mt-3">
              <strong>Qué significa en preoperatorio</strong><br>
              <div id="periopText" class="small-note mt-2">-</div>
            </div>

            <div class="mint-box mt-3">
              <strong>Limitaciones / cautelas</strong><br>
              <div id="caveatText" class="small-note mt-2">-</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Tips docentes</div>
            <div class="warn-box">
              <ul class="tip-list">
                <li>El DASI es una herramienta rápida para estimar capacidad funcional, no un reemplazo de la anamnesis cardiovascular ni del examen físico.</li>
                <li>En perioperatorio, el corte práctico más usado es <strong>4 METs</strong>: por debajo de eso, la reserva funcional es limitada.</li>
                <li>Un DASI alto tranquiliza menos si el paciente tiene angina, insuficiencia cardíaca descompensada, arritmia sintomática o valvulopatía severa.</li>
                <li>Cuando el resultado es bajo y además la cirugía es de alto riesgo, debes integrar riesgo quirúrgico, comorbilidades, necesidad de estudio adicional y monitorización postoperatoria.</li>
                <li>Si el paciente no puede responder confiablemente o sobreestima su actividad, el cuestionario pierde precisión.</li>
                <li>Úsalo como ayuda rápida para decidir si la capacidad funcional parece adecuada, deficiente o claramente reducida.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. El resultado es orientativo y debe integrarse con síntomas, tipo de cirugía, antecedentes cardiovasculares y condición clínica actual.
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

function fmt(num, decimals=1){
  if(num === null || num === undefined || isNaN(num)) return '-';
  return Number(num).toFixed(decimals).replace('.', ',');
}

function updateDasi(){
  let total = 0;

  for(let i=1;i<=12;i++){
    const val = parseFloat(getSelected('q'+i) || 0);
    if(!isNaN(val)) total += val;
  }

  const vo2 = (total * 0.43) + 9.6;
  const mets = vo2 / 3.5;
  const surgeryRisk = getSelected('surgeryRisk') || 'low';
  const activeCardiac = getSelected('activeCardiac') || 'no';

  let category = '';
  if(mets > 10){
    category = 'Excelente';
  } else if(mets >= 7){
    category = 'Buena';
  } else if(mets >= 4){
    category = 'Moderada';
  } else if(mets > 0){
    category = 'Deficiente';
  } else {
    category = 'No calculada';
  }

  document.getElementById('sumDasi').textContent = fmt(total,2);
  document.getElementById('sumVo2').textContent = fmt(vo2,1) + ' ml/kg/min';
  document.getElementById('sumMets').textContent = fmt(mets,1);
  document.getElementById('sumCategory').textContent = category;

  if(total <= 0){
    document.getElementById('mainDecision').textContent = 'Capacidad funcional no calculada';
    document.getElementById('mainPlan').textContent = 'Complete el cuestionario';
    document.getElementById('outClass').textContent = '-';
    document.getElementById('outPeriop').textContent = '-';
    document.getElementById('outVo2').textContent = '-';
    document.getElementById('outMets').textContent = '-';
    document.getElementById('riskTitle').textContent = 'Lectura clínica';
    document.getElementById('riskText').textContent = 'Responda el cuestionario para obtener una estimación funcional y una orientación perioperatoria.';
    document.getElementById('riskBox').className = 'good-box';
    document.getElementById('periopText').textContent = '-';
    document.getElementById('caveatText').textContent = '-';
    return;
  }

  let mainDecision = '';
  let mainPlan = '';
  let periopRisk = '';
  let riskTitle = '';
  let riskText = '';
  let periopText = '';
  let caveatText = '';
  let riskClass = 'good-box';

  if(activeCardiac === 'yes'){
    mainDecision = 'Síntomas / condición activa predominan sobre el DASI';
    mainPlan = 'No confiar solo en METs estimados.<br><span class="small-note">Optimizar, revalorar y escalar estudio o conducta según contexto.</span>';
    periopRisk = 'Evaluación clínica prioritaria';
    riskTitle = 'Alarma cardiovascular activa';
    riskText = 'Si hay angina inestable, insuficiencia cardíaca aguda o descompensada, arritmia significativa o valvulopatía severa, el algoritmo funcional no basta.';
    periopText = 'Aunque el DASI sea aceptable, la presencia de síntomas o hallazgos activos puede obligar a diferir, optimizar o estudiar más antes de cirugía electiva.';
    caveatText = 'El cuestionario estima función, no estabilidad cardiovascular. Un paciente puede “sumar puntos” y aun así ser clínicamente de alto riesgo.';
    riskClass = 'danger-box';
  } else if(mets < 4){
    mainDecision = 'Capacidad funcional reducida';
    if(surgeryRisk === 'high'){
      mainPlan = 'Paciente bajo 4 METs + cirugía de alto riesgo.<br><span class="small-note">Interpretar con cautela, considerar optimización, evaluación adicional y plan perioperatorio reforzado.</span>';
    } else {
      mainPlan = 'Paciente bajo 4 METs.<br><span class="small-note">Integrar síntomas, comorbilidades y riesgo quirúrgico antes de decidir estudio adicional.</span>';
    }
    periopRisk = 'Mayor riesgo funcional';
    riskTitle = 'Capacidad funcional deficiente';
    riskText = 'Un valor estimado menor de 4 METs sugiere reserva funcional limitada y se asocia a mayor probabilidad de eventos perioperatorios y peores resultados a largo plazo.';
    periopText = 'En cirugía no cardíaca, un paciente incapaz de sostener al menos 4 METs merece una evaluación más cuidadosa del riesgo cardiovascular, especialmente si el procedimiento es de mayor complejidad.';
    caveatText = 'Un DASI bajo no diagnostica cardiopatía, pero sí debe hacerte más conservador en la interpretación perioperatoria.';
    riskClass = 'danger-box';
  } else if(mets < 7){
    mainDecision = 'Capacidad funcional aceptable, no alta';
    mainPlan = 'METs entre 4 y 6,9.<br><span class="small-note">Habitualmente permite continuar evaluación estándar si el paciente está clínicamente estable.</span>';
    periopRisk = 'Riesgo funcional intermedio';
    riskTitle = 'Capacidad funcional moderada';
    riskText = 'Sobre 4 METs suele ser suficiente para muchas decisiones perioperatorias, pero no equivale a “riesgo cero”.';
    periopText = 'Si no hay síntomas cardiovasculares activos y la cirugía no es de alto riesgo, la capacidad funcional suele ser tranquilizadora. Si el resto del perfil es adverso, integra más variables.';
    caveatText = 'El resultado es una estimación indirecta. Si la historia clínica es discordante, pesa más la clínica.';
    riskClass = 'warn-box';
  } else if(mets <= 10){
    mainDecision = 'Buena capacidad funcional';
    mainPlan = 'METs 7 a 10.<br><span class="small-note">En ausencia de síntomas activos, suele ser un hallazgo favorable.</span>';
    periopRisk = 'Riesgo funcional bajo';
    riskTitle = 'Capacidad funcional buena';
    riskText = 'El paciente probablemente tolera actividades aeróbicas habituales sin gran limitación y su reserva funcional parece adecuada.';
    periopText = 'En contexto estable, una capacidad funcional buena reduce la probabilidad de complicaciones cardiovasculares perioperatorias comparado con pacientes de mala reserva.';
    caveatText = 'Un buen DASI no reemplaza la pesquisa de cardiopatía activa ni la consideración del riesgo propio de la cirugía.';
    riskClass = 'good-box';
  } else {
    mainDecision = 'Excelente capacidad funcional';
    mainPlan = 'METs >10.<br><span class="small-note">Hallazgo muy tranquilizador si el paciente está clínicamente estable.</span>';
    periopRisk = 'Muy buen perfil funcional';
    riskTitle = 'Capacidad funcional excelente';
    riskText = 'El paciente reporta una reserva funcional alta, compatible con buena aptitud aeróbica en actividades de la vida diaria y ejercicio más exigente.';
    periopText = 'En ausencia de síntomas o enfermedad activa, este perfil suele apoyar la continuación del manejo perioperatorio habitual sin escalar estudios solo por función.';
    caveatText = 'Siempre recuerda que algunos pacientes sobreestiman su capacidad real; si la historia no convence, no te quedes solo con el cuestionario.';
    riskClass = 'good-box';
  }

  document.getElementById('mainDecision').textContent = mainDecision;
  document.getElementById('mainPlan').innerHTML = mainPlan;
  document.getElementById('outClass').textContent = category + ' (' + fmt(mets,1) + ' METs)';
  document.getElementById('outPeriop').textContent = periopRisk;
  document.getElementById('outVo2').textContent = fmt(vo2,1) + ' ml/kg/min';
  document.getElementById('outMets').textContent = fmt(mets,1) + ' METs';

  document.getElementById('riskTitle').textContent = riskTitle;
  document.getElementById('riskText').textContent = riskText;
  document.getElementById('riskBox').className = riskClass;
  document.getElementById('periopText').textContent = periopText;
  document.getElementById('caveatText').textContent = caveatText;
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.dasi-trigger').forEach(el => {
    el.addEventListener('change', updateDasi);
    el.addEventListener('input', updateDasi);
  });
  updateDasi();
});
</script>

<?php require("footer.php"); ?>