<?php

$titulo_info = "Utilidad clínica";
$descripcion_info = "Esta versión corresponde al fast-track score derivado del Aldrete modificado e incorpora dolor y síntomas eméticos. Sirve para orientar si un paciente podría pasar directamente a recuperación fase II o ser trasladado desde recuperación cuando ha recuperado estabilidad clínica suficiente; no reemplaza el juicio clínico ni criterios de alta domiciliaria.";
$formula = "Fast-track / Aldrete ampliado = conciencia + actividad física + estabilidad hemodinámica + estabilidad respiratoria + saturación de oxígeno + dolor posoperatorio + síntomas eméticos posoperatorios";
$referencias = array(
  "1.- Aldrete JA, Kroulik D. A postanesthetic recovery score. Anesth Analg. 1970;49(6):924-934. doi:10.1213/00000539-197011000-00010.",
  "2.- Aldrete JA. The post anesthesia recovery score revisited. J Clin Anesth. 1995;7:89-91.",
  "3.- McGrath B, Chung F. Postoperative recovery and discharge. Anesthesiol Clin North America. 2003;21:367-386.",
  "4.- White PF, Song D. New Criteria for Fast-Tracking After Outpatient Anesthesia: A Comparison with the Modified Aldrete's Scoring System. Anesth Analg. 1999;88:1069-1072."
);

$icono_apunte = "<i class='fa-solid fa-bed-pulse pe-3 pt-2'></i>";
$titulo_apunte = "Score de Aldrete Modificado / Fast-track";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");

$domains = array(
  "conciencia" => array(
    "title" => "Nivel de conciencia",
    "icon" => "fa-brain",
    "short" => "Conciencia",
    "options" => array(
      array("Despierto y orientado", 2),
      array("Despierta con mínima estimulación", 1),
      array("Responde solo a estímulo táctil", 0)
    )
  ),
  "actividad" => array(
    "title" => "Actividad física",
    "icon" => "fa-person-walking",
    "short" => "Actividad",
    "options" => array(
      array("Mueve voluntariamente las 4 extremidades", 2),
      array("Debilidad parcial para movilizar extremidades", 1),
      array("No moviliza voluntariamente las extremidades", 0)
    )
  ),
  "hemodinamica" => array(
    "title" => "Estabilidad hemodinámica",
    "icon" => "fa-heart-pulse",
    "short" => "Hemodinámica",
    "options" => array(
      array("PA dentro de ±15% del basal", 2),
      array("PA a ±15–30% del basal", 1),
      array("PA fuera de ±30% del basal", 0)
    )
  ),
  "respiratoria" => array(
    "title" => "Estabilidad respiratoria",
    "icon" => "fa-lungs",
    "short" => "Respiratoria",
    "options" => array(
      array("Respira profundo y eficazmente", 2),
      array("Taquipnea con tos efectiva", 1),
      array("Disnea o tos débil", 0)
    )
  ),
  "saturacion" => array(
    "title" => "Saturación de oxígeno",
    "icon" => "fa-wave-square",
    "short" => "Saturación",
    "options" => array(
      array("SpO₂ &gt; 90% en aire ambiente", 2),
      array("Requiere O₂ suplementario", 1),
      array("SpO₂ &lt; 90% pese a O₂ suplementario", 0)
    )
  ),
  "dolor" => array(
    "title" => "Dolor posoperatorio",
    "icon" => "fa-hand-dots",
    "short" => "Dolor",
    "options" => array(
      array("Sin dolor o dolor leve", 2),
      array("Dolor moderado/severo controlado con analgesia EV", 1),
      array("Dolor severo persistente", 0)
    )
  ),
  "emeticos" => array(
    "title" => "Síntomas eméticos posoperatorios",
    "icon" => "fa-face-dizzy",
    "short" => "Emesis",
    "options" => array(
      array("Sin náuseas o náuseas leves sin vómitos", 2),
      array("Arcadas o vómito transitorio", 1),
      array("Náuseas o vómitos persistentes moderados-severos", 0)
    )
  )
);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell">

        <style>
          :root{
            --note-brand:#27458f;
            --note-brand-soft:#eef4ff;
            --note-brand-soft-border:#cfe1ff;
            --note-bg:#f4f7fb;
            --note-card:#ffffff;
            --note-soft:#f8fafc;
            --note-line:#dfe7f2;
            --note-text:#1f2a37;
            --note-muted:#667085;
            --note-success-bg:#edf8f7;
            --note-success-border:#cfe8e6;
            --note-warning-bg:#fff9e8;
            --note-warning-border:#ecd798;
            --note-danger-bg:#fff5f3;
            --note-danger-border:#efc4be;
            --note-radius:1rem;
            --note-radius-lg:1.25rem;
            --note-shadow:0 8px 24px rgba(15,23,42,.06);
            --note-selected:#2f80ed;
          }

          body{background:var(--note-bg);}
          .note-shell{max-width:980px;margin:0 auto;}
          .note-hero,.note-card,.note-info-card{background:var(--note-card);border-radius:var(--note-radius-lg);box-shadow:var(--note-shadow);overflow:hidden;margin-bottom:1rem;}
          .note-hero{background:linear-gradient(135deg,var(--note-brand),#3559b7);color:#fff;padding:1.15rem 1.25rem;}
          .note-hero h1{color:#fff;}
          .note-badge{display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.78rem;background:#eef3ff;color:#3559b7;font-weight:700;}
          .note-hero-subtle{font-size:.94rem;color:rgba(255,255,255,.78);}
          .note-card-body{padding:1rem;}
          .note-card-title{font-size:1rem;font-weight:800;color:var(--note-text);margin-bottom:.35rem;}
          .note-section-label{font-size:.8rem;letter-spacing:.05em;text-transform:uppercase;color:var(--note-muted);margin-bottom:.9rem;}
          .note-muted{font-size:.9rem;color:var(--note-muted);}
          .note-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;}
          .note-input-group{border:1px solid var(--note-line);border-radius:var(--note-radius);background:var(--note-soft);padding:1rem;}
          .note-label{font-size:.9rem;font-weight:700;color:var(--note-text);margin-bottom:.35rem;display:block;}
          .note-choice-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:.55rem;}
          .note-check{display:none;}
          .note-option{
            display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;
            min-height:74px;border:2px solid var(--note-line);background:#fff;border-radius:.85rem;padding:.4rem .45rem;
            font-weight:700;font-size:.85rem;color:var(--note-text);cursor:pointer;transition:.15s ease;line-height:1.08;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
          }
          .note-option i{font-size:.82rem;margin-bottom:.15rem;color:#3559b7;}
          .note-option small{
            display:block;
            font-size:1.08rem;
            font-weight:900;
            color:#3559b7;
            line-height:1;
            margin-top:.35rem;
            letter-spacing:.01em;
            opacity:1;
          }
          .note-option small::after{
            content:'';
          }
          .note-check:checked + .note-option{
            transform:translateY(-1px);
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
          }
          .score-good{background:#eef8f1;}
          .score-mid{background:#fff8df;}
          .score-zero{background:#fff5f3;}
          .score-zero small{color:#3559b7;}
          .score-domain-title{display:flex;align-items:center;gap:.55rem;font-size:1rem;font-weight:800;color:var(--note-text);margin-bottom:.85rem;}
          .score-domain-title i{color:#3559b7;}

          .note-summary{background:var(--note-brand-soft);border:1px solid var(--note-brand-soft-border);border-radius:var(--note-radius);padding:.9rem .95rem;}
          .note-summary-label{font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;color:#3559b7;font-weight:700;margin-bottom:.35rem;}
          .note-summary-text{font-size:1rem;line-height:1.35;font-weight:800;color:var(--note-text);}
          .note-summary-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:.55rem;margin-top:.9rem;}
          .note-summary-chip{background:#fff;border:1px solid #dbe4f0;border-radius:.8rem;padding:.6rem .7rem;font-size:.86rem;color:#475467;}
          .note-summary-chip strong{display:block;color:#1f2a37;margin-bottom:.18rem;}
          .chip-ok{border-color:#cfe8e6;background:#f7fffc;}
          .chip-warn{border-color:#ecd798;background:#fffdf4;}
          .chip-no{border-color:#efc4be;background:#fff8f7;}

          .note-results{border-radius:var(--note-radius);border:1px solid var(--note-line);background:var(--note-soft);padding:1rem;}
          .note-result-row{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;padding:.9rem 1rem;border:1px solid #e6e9ef;border-radius:.9rem;background:#fff;margin-bottom:.7rem;}
          .note-result-row:last-child{margin-bottom:0;}
          .note-result-main{font-weight:800;color:var(--note-text);line-height:1.2;}
          .note-result-secondary{font-size:.84rem;color:var(--note-muted);margin-top:.2rem;line-height:1.45;}
          .note-result-value{min-width:170px;text-align:right;font-weight:800;color:var(--note-brand);line-height:1.25;}

          .note-interpretation{border-radius:var(--note-radius);padding:1.2rem;background:var(--note-brand-soft);border:1px solid var(--note-brand-soft-border);text-align:center;}
          .note-interpretation-label{font-size:.85rem;text-transform:uppercase;letter-spacing:.06em;color:#3559b7;margin-bottom:.45rem;font-weight:700;}
          .note-interpretation-main{font-size:1.35rem;font-weight:900;color:var(--note-text);line-height:1.2;}
          .note-interpretation-soft{margin-top:.55rem;font-size:.92rem;color:#5f6b76;}

          .note-warning,.note-danger,.note-success{border-radius:var(--note-radius);padding:1rem;}
          .note-warning{background:var(--note-warning-bg);border:1px solid var(--note-warning-border);}
          .note-danger{background:var(--note-danger-bg);border:1px solid var(--note-danger-border);}
          .note-success{background:var(--note-success-bg);border:1px solid var(--note-success-border);}
          .note-hidden{display:none;}

          .note-info-header{display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:1rem;}
          .note-info-title{font-size:.8rem;text-transform:uppercase;color:var(--note-muted);letter-spacing:.08em;}
          .note-info-toggle{border-radius:.6rem;font-size:.85rem;padding:.35rem .7rem;white-space:nowrap;background:#6c757d;border:none;color:#fff;transition:.2s;}
          .note-info-toggle:hover{background:#5a6268;color:#fff;}
          .note-info-content{padding:1rem;display:none;animation:fadeIn .2s ease-in-out;border-top:1px solid #e9eef5;}
          @keyframes fadeIn{from{opacity:0;transform:translateY(-5px);}to{opacity:1;transform:translateY(0);}}

          .note-teaching-wrap{border-radius:1.3rem;background:#f4f7fb;padding:1.2rem;}
          .note-teaching-title{text-align:center;font-size:.9rem;text-transform:uppercase;color:#64748b;letter-spacing:.05em;}
          .note-teaching-main{text-align:center;font-size:1.45rem;font-weight:800;margin-bottom:1rem;line-height:1.15;}
          .note-tips{background:#fff;border-radius:1rem;padding:1rem;border:1px solid #e5e7eb;margin-bottom:.8rem;}
          .note-footer{font-size:.82rem;color:#6c757d;}

          @media(max-width:768px){
            .note-grid,.note-choice-grid-3,.note-summary-grid{grid-template-columns:1fr;}
            .note-result-row{flex-direction:column;align-items:flex-start;}
            .note-result-value{text-align:left;min-width:0;}
            .note-teaching-main{font-size:1.2rem;}
          }

          @media(max-width:576px){
            .note-option{min-height:68px;padding:.28rem .34rem;font-size:.82rem;border-radius:.8rem;}
            .note-option i{font-size:.75rem;margin-bottom:.06rem;}
            .note-info-toggle{margin-left:auto;}
          }
        </style>

        <div class="note-hero">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • recuperación postanestésica</div>
              <h1 class="h3 mb-2">Score de Aldrete Modificado / Fast-track</h1>
              <div class="note-hero-subtle">Evalúa recuperación fisiológica, dolor y emesis para orientar fast-track o traslado desde fase I.</div>
            </div>
            <span class="note-badge bg-light text-dark">URPA</span>
          </div>
        </div>

        <div class="note-info-card">
          <div class="note-info-header">
            <div>
              <div class="note-info-title">Información</div>
            </div>
            <button type="button" onclick="toggleInfo()" class="note-info-toggle">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="note-info-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
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
            <hr>
            <div class="small mb-0">Criterio orientativo: puntaje total <strong>&ge; 12</strong> y <strong>ningún dominio en 0</strong>.</div>
          </div>
        </div>

        <div class="note-card">
          <div class="note-card-body">
            <div class="note-section-label">Dominios del score</div>
            <div class="note-grid">
              <?php foreach($domains as $key => $domain){ ?>
                <div class="note-input-group">
                  <div class="score-domain-title"><i class="fa-solid <?php echo $domain['icon']; ?>"></i><?php echo $domain['title']; ?></div>
                  <div class="note-choice-grid-3">
                    <?php foreach($domain['options'] as $idx => $option){
                      $scoreClass = $option[1] === 2 ? 'score-good' : ($option[1] === 1 ? 'score-mid' : 'score-zero');
                      $inputId = $key . '_' . $idx;
                    ?>
                      <div>
                        <input class="note-check note-trigger score-radio" type="radio" name="<?php echo $key; ?>" id="<?php echo $inputId; ?>" value="<?php echo $option[1]; ?>" data-domain="<?php echo $key; ?>">
                        <label class="note-option <?php echo $scoreClass; ?>" for="<?php echo $inputId; ?>">
                          <?php echo $option[0]; ?>
                          <small><?php echo $option[1]; ?></small>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="note-card">
          <div class="note-card-body">
            <div class="note-section-label">Resumen del plan</div>
            <div class="note-summary">
              <div class="note-summary-label">Configuración evaluada</div>
              <div id="planSummaryText" class="note-summary-text">Selecciona una opción por cada dominio para emitir una recomendación orientativa.</div>
              <div id="summaryGrid" class="note-summary-grid"></div>
            </div>
          </div>
        </div>

        <div class="note-card">
          <div class="note-card-body">
            <div class="note-section-label">Resultado</div>
            <div class="note-results mb-3">
              <div class="note-result-row">
                <div>
                  <div class="note-result-main">Puntaje calculado</div>
                  <div id="scoreNote" class="note-result-secondary">Fast-track score sobre 14 puntos.</div>
                </div>
                <div id="scoreValue" class="note-result-value">-</div>
              </div>

              <div class="note-result-row">
                <div>
                  <div class="note-result-main">Criterio estructural</div>
                  <div id="criteriaNote" class="note-result-secondary">Exige puntaje total y revisar dominios críticos.</div>
                </div>
                <div id="criteriaValue" class="note-result-value">-</div>
              </div>

              <div class="note-result-row">
                <div>
                  <div class="note-result-main">Conducta sugerida</div>
                  <div id="nextStepNote" class="note-result-secondary">Recomendación orientativa según selección.</div>
                </div>
                <div id="nextStepValue" class="note-result-value">-</div>
              </div>
            </div>

            <div class="note-interpretation">
              <div class="note-interpretation-label">Interpretación</div>
              <div id="riskText" class="note-interpretation-main">Sin evaluación completa aún</div>
              <div id="riskSoft" class="note-interpretation-soft">Completa los 7 dominios para obtener una guía orientativa de fast-track o permanencia en fase I.</div>
            </div>
          </div>
        </div>

        <div class="note-card">
          <div class="note-card-body">
            <div id="validityWarning" class="note-danger note-hidden mb-3">
              <b>Dato a verificar</b><br>
              <div id="validityWarningText" class="small mt-2"></div>
            </div>

            <div class="note-warning mb-3">
              <b>Seguridad</b><br>
              <div id="safetyText" class="small mt-2">Un puntaje alto no reemplaza la reevaluación clínica ni la vigilancia adecuada del contexto postoperatorio.</div>
            </div>

            <div class="note-success">
              <b>Puntos prácticos</b><br>
              <div class="small mt-2">Si un dominio está en 0, la conducta correcta suele ser tratar la causa específica y reevaluar en serie, no discutir el total en abstracto.</div>
            </div>
          </div>
        </div>

        <div class="note-card">
          <div class="note-card-body">
            <div class="note-teaching-wrap">
              <div class="note-teaching-title">Tips para residentes</div>
              <div class="note-teaching-main">En fast-track, el error frecuente no es sumar mal el score: es olvidar que el total no corrige un dominio crítico mal resuelto.</div>

              <div class="note-tips"><b>1. Qué hacer</b><br>Corrige primero el déficit dominante: dolor, emesis, oxigenación, debilidad o compromiso ventilatorio. Luego reevalúa el score.</div>
              <div class="note-tips"><b>2. Qué evitar</b><br>No uses un total &ge;12 como aprobación automática si existe un 0 en cualquier dominio.</div>
              <div class="note-tips"><b>3. Perla docente</b><br>Agregar dolor y emesis vuelve esta herramienta más útil para fast-track que el Aldrete fisiológico clásico, porque anticipa intervenciones aún necesarias.</div>
              <div class="note-tips"><b>4. Revaluación</b><br>El valor real del instrumento también está en la tendencia: un paciente 9→11→13 con tratamiento adecuado dice más que una medición aislada.</div>

              <div class="note-danger"><b>Mensaje final</b><br>Este score orienta fast-track o traslado desde fase I. No es criterio de alta domiciliaria y no reemplaza juicio clínico, tipo de cirugía, sangrado, vía aérea ni necesidad de monitorización adicional.</div>
            </div>
          </div>
        </div>

        <div class="note-footer">Herramienta docente y de apoyo clínico. Confirmar estabilidad hemodinámica y respiratoria, dolor, emesis, vía aérea, sangrado y necesidades de vigilancia antes de trasladar.</div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleInfo(){
  const box = document.getElementById('infoContent');
  box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
}

const DOMAINS = <?php echo json_encode($domains, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
const DOMAIN_KEYS = Object.keys(DOMAINS);

function safeSetText(id, value){
  const el = document.getElementById(id);
  if(el) el.textContent = value;
}

function safeSetHTML(id, value){
  const el = document.getElementById(id);
  if(el) el.innerHTML = value;
}

function showValidityWarning(text){
  document.getElementById('validityWarning').classList.remove('note-hidden');
  safeSetText('validityWarningText', text);
}

function hideValidityWarning(){
  document.getElementById('validityWarning').classList.add('note-hidden');
  safeSetText('validityWarningText', '');
}

function getSelections(){
  const selections = {};
  DOMAIN_KEYS.forEach(function(key){
    const checked = document.querySelector('input[name="' + key + '"]:checked');
    selections[key] = checked ? Number(checked.value) : null;
  });
  return selections;
}

function renderSummary(selections){
  const summaryGrid = document.getElementById('summaryGrid');
  summaryGrid.innerHTML = '';

  DOMAIN_KEYS.forEach(function(key){
    const wrap = document.createElement('div');
    const value = selections[key];
    const stateClass = value === 2 ? 'chip-ok' : (value === 1 ? 'chip-warn' : (value === 0 ? 'chip-no' : ''));
    wrap.className = 'note-summary-chip ' + stateClass;
    wrap.innerHTML = '<strong>' + DOMAINS[key].short + '</strong>' + (value === null ? 'No seleccionado' : value + ' pt');
    summaryGrid.appendChild(wrap);
  });
}

function showEmptyState(){
  hideValidityWarning();
  safeSetText('planSummaryText', 'Selecciona una opción por cada dominio para emitir una recomendación orientativa.');
  renderSummary(getSelections());
  safeSetText('scoreValue', '-');
  safeSetText('scoreNote', 'Fast-track score sobre 14 puntos.');
  safeSetText('criteriaValue', '-');
  safeSetText('criteriaNote', 'Exige puntaje total y revisar dominios críticos.');
  safeSetText('nextStepValue', '-');
  safeSetText('nextStepNote', 'Recomendación orientativa según selección.');
  safeSetText('riskText', 'Sin evaluación completa aún');
  safeSetText('riskSoft', 'Completa los 7 dominios para obtener una guía orientativa de fast-track o permanencia en fase I.');
  safeSetText('safetyText', 'Un puntaje alto no reemplaza la reevaluación clínica ni la vigilancia adecuada del contexto postoperatorio.');
}

function updateAldrete(){
  const selections = getSelections();
  renderSummary(selections);

  const values = Object.values(selections);
  const complete = values.every(function(v){ return v !== null; });
  if(!complete){
    showEmptyState();
    return;
  }

  hideValidityWarning();
  const total = values.reduce(function(acc, value){ return acc + value; }, 0);
  const hasZero = values.some(function(v){ return v === 0; });
  const hasOne = values.some(function(v){ return v === 1; });

  safeSetText('planSummaryText', 'Fast-track score completado con los 7 dominios seleccionados.');
  safeSetHTML('scoreValue', total + ' / 14');
  safeSetText('scoreNote', 'Suma de conciencia, actividad, hemodinámica, respiración, SpO₂, dolor y emesis.');

  if(total >= 12 && !hasZero){
    safeSetHTML('criteriaValue', 'Cumple');
    safeSetText('criteriaNote', 'Puntaje ≥12 y ningún dominio en 0.');
    safeSetHTML('nextStepValue', 'Fast-track posible');
    safeSetText('nextStepNote', 'Confirmar estabilidad real, vigilancia requerida y plan de traslado.');
    safeSetText('riskText', 'Elegibilidad orientativa para fast-track');
    safeSetText('riskSoft', 'La combinación de estabilidad fisiológica con control razonable de dolor y emesis favorece traslado o bypass de fase I, si el contexto quirúrgico también lo permite.');
    safeSetText('safetyText', 'Aunque cumpla criterio, no ignores sangrado, obstrucción de vía aérea, inestabilidad dinámica ni necesidad de monitorización adicional.');
    return;
  }

  if(total >= 12 && hasZero){
    safeSetHTML('criteriaValue', 'No cumple');
    safeSetText('criteriaNote', 'Existe al menos un dominio en 0.');
    safeSetHTML('nextStepValue', 'Tratar y reevaluar');
    safeSetText('nextStepNote', 'El total por sí solo no habilita fast-track si hay un 0.');
    safeSetText('riskText', 'Total suficiente, estructura insuficiente');
    safeSetText('riskSoft', 'Un dominio en 0 identifica vulnerabilidad clínica relevante. La decisión correcta es tratar el déficit específico y reevaluar.');
    safeSetText('safetyText', 'El error clásico es mirar solo la suma. En este escenario, el total es engañoso si no se repara el dominio en 0.');
    showValidityWarning('El puntaje total puede parecer aceptable, pero un dominio en 0 invalida la elegibilidad para fast-track.');
    return;
  }

  safeSetHTML('criteriaValue', 'No cumple');
  safeSetText('criteriaNote', 'Aún no alcanza ≥12 o persisten déficits parciales relevantes.');
  safeSetHTML('nextStepValue', 'Mantener en fase I');
  safeSetText('nextStepNote', 'Corregir causa predominante y reevaluar seriado.');
  safeSetText('riskText', 'Todavía no reúne condiciones orientativas de fast-track');
  safeSetText('riskSoft', 'En la práctica, los dominios que más retrasan salida suelen ser dolor, emesis, oxigenación y recuperación neuromuscular/actividad.');
  safeSetText('safetyText', hasOne ? 'Persisten déficits parciales. El próximo paso útil suele ser tratar la causa clínica dominante y repetir la evaluación.' : 'Si el paciente no llega al umbral, la salida correcta no es forzar el score, sino revisar estabilidad, analgesia, emesis y respiración.');
}

document.addEventListener('change', function(e){
  if(e.target.matches('.score-radio')){
    updateAldrete();
  }
});

showEmptyState();
</script>
<?php require("footer.php"); ?>
