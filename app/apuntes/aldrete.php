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

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

require("../head.php");

$domains = array(
  "conciencia" => array(
    "title" => "Nivel de conciencia",
    "icon" => "fa-brain",
    "options" => array(
      array("score" => 2, "text" => "Despierto y orientado"),
      array("score" => 1, "text" => "Despierta con mínima estimulación"),
      array("score" => 0, "text" => "Responde solo a estímulo táctil")
    )
  ),
  "actividad" => array(
    "title" => "Actividad física",
    "icon" => "fa-person-walking",
    "options" => array(
      array("score" => 2, "text" => "Mueve voluntariamente las 4 extremidades"),
      array("score" => 1, "text" => "Debilidad parcial para movilizar extremidades"),
      array("score" => 0, "text" => "No moviliza voluntariamente las extremidades")
    )
  ),
  "hemodinamica" => array(
    "title" => "Estabilidad hemodinámica",
    "icon" => "fa-heart-pulse",
    "options" => array(
      array("score" => 2, "text" => "PA dentro de ±15% del basal"),
      array("score" => 1, "text" => "PA a ±15–30% del basal"),
      array("score" => 0, "text" => "PA fuera de ±30% del basal")
    )
  ),
  "respiratoria" => array(
    "title" => "Estabilidad respiratoria",
    "icon" => "fa-lungs",
    "options" => array(
      array("score" => 2, "text" => "Respira profundo y eficazmente"),
      array("score" => 1, "text" => "Taquipnea con tos efectiva"),
      array("score" => 0, "text" => "Disnea o tos débil")
    )
  ),
  "saturacion" => array(
    "title" => "Saturación de oxígeno",
    "icon" => "fa-wave-square",
    "options" => array(
      array("score" => 2, "text" => "SpO₂ &gt; 90% en aire ambiente"),
      array("score" => 1, "text" => "Requiere O₂ suplementario"),
      array("score" => 0, "text" => "SpO₂ &lt; 90% pese a O₂ suplementario")
    )
  ),
  "dolor" => array(
    "title" => "Dolor posoperatorio",
    "icon" => "fa-hand-dots",
    "options" => array(
      array("score" => 2, "text" => "Sin dolor o dolor leve"),
      array("score" => 1, "text" => "Dolor moderado/severo controlado con analgesia EV"),
      array("score" => 0, "text" => "Dolor severo persistente")
    )
  ),
  "emeticos" => array(
    "title" => "Síntomas eméticos posoperatorios",
    "icon" => "fa-face-dizzy",
    "options" => array(
      array("score" => 2, "text" => "Sin náuseas o náuseas leves sin vómitos"),
      array("score" => 1, "text" => "Arcadas o vómito transitorio"),
      array("score" => 0, "text" => "Náuseas o vómitos persistentes moderados-severos")
    )
  )
);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell aldrete-shell">

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
          body .note-shell .flacc-option .flacc-option-text{background:transparent !important;background-color:transparent !important;}
          body .note-shell .flacc-option .flacc-option-points{background:transparent !important;background-color:transparent !important;}
          .note-label{font-size:.9rem;font-weight:700;color:var(--note-text);margin-bottom:.35rem;display:block;}

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
        <link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
        <link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
              <div class="note-hero-kicker">APP clínica • recuperación postanestésica</div>
              <h1 class="h2 mb-2">Score de Aldrete Modificado / Fast-track</h1>
              <div class="note-hero-subtitle">Evalúa recuperación fisiológica, dolor y emesis para orientar fast-track o traslado desde fase I.</div>
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

            <?php
            foreach($domains as $key => $domain){ ?>
              <div class="flacc-domain-card<?php echo $key === 'emeticos' ? ' mb-0' : ''; ?>">
                <div class="flacc-domain-head">
                  <div class="flacc-domain-icon"><i class="fa-solid <?php echo $domain['icon']; ?>"></i></div>
                  <div class="flacc-domain-title"><?php echo $domain['title']; ?></div>
                </div>
                <div class="flacc-score-grid">
                  <?php foreach($domain['options'] as $opt){ ?>
                    <label>
                      <input class="flacc-option-input" type="radio" name="<?php echo $key; ?>" value="<?php echo $opt['score']; ?>">
                      <div class="flacc-option flacc-option-<?php echo $opt['score']; ?>">
                        <p class="flacc-option-text"><?php echo $opt['text']; ?></p>
                        <div class="flacc-option-points"><?php echo $opt['score']; ?></div>
                      </div>
                    </label>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>

          </div>
        </div>

        <div class="note-card">
          <div class="note-card-body">
            <div class="note-section-label">Resultado</div>
            <div class="note-result-grid-2 mb-3">
              <div class="note-result-card">
                <div class="note-result-card-label">Puntaje calculado</div>
                <div id="scoreValue" class="note-result-card-value">Seleccione todos los items</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Criterio estructural</div>
                <div id="criteriaValue" class="note-result-card-value">-</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Conducta sugerida</div>
                <div id="nextStepValue" class="note-result-card-value">-</div>
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

function showEmptyState(){
  hideValidityWarning();
  safeSetText('scoreValue', 'Seleccione todos los items');
  safeSetText('criteriaValue', '-');
  safeSetText('nextStepValue', '-');
  safeSetText('riskText', 'Sin evaluación completa aún');
  safeSetText('riskSoft', 'Completa los 7 dominios para obtener una guía orientativa de fast-track o permanencia en fase I.');
  safeSetText('safetyText', 'Un puntaje alto no reemplaza la reevaluación clínica ni la vigilancia adecuada del contexto postoperatorio.');
}

function updateAldrete(){
  const selections = getSelections();

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

  safeSetHTML('scoreValue', total + ' / 14');

  if(total >= 12 && !hasZero){
    safeSetHTML('criteriaValue', 'Cumple');
    safeSetHTML('nextStepValue', 'Fast-track posible');
    safeSetText('riskText', 'Elegibilidad orientativa para fast-track');
    safeSetText('riskSoft', 'La combinación de estabilidad fisiológica con control razonable de dolor y emesis favorece traslado o bypass de fase I, si el contexto quirúrgico también lo permite.');
    safeSetText('safetyText', 'Aunque cumpla criterio, no ignores sangrado, obstrucción de vía aérea, inestabilidad dinámica ni necesidad de monitorización adicional.');
    return;
  }

  if(total >= 12 && hasZero){
    safeSetHTML('criteriaValue', 'No cumple');
    safeSetHTML('nextStepValue', 'Tratar y reevaluar');
    safeSetText('riskText', 'Total suficiente, estructura insuficiente');
    safeSetText('riskSoft', 'Un dominio en 0 identifica vulnerabilidad clínica relevante. La decisión correcta es tratar el déficit específico y reevaluar.');
    safeSetText('safetyText', 'El error clásico es mirar solo la suma. En este escenario, el total es engañoso si no se repara el dominio en 0.');
    showValidityWarning('El puntaje total puede parecer aceptable, pero un dominio en 0 invalida la elegibilidad para fast-track.');
    return;
  }

  safeSetHTML('criteriaValue', 'No cumple');
  safeSetHTML('nextStepValue', 'Mantener en fase I');
  safeSetText('riskText', 'Todavía no reúne condiciones orientativas de fast-track');
  safeSetText('riskSoft', 'En la práctica, los dominios que más retrasan salida suelen ser dolor, emesis, oxigenación y recuperación neuromuscular/actividad.');
  safeSetText('safetyText', hasOne ? 'Persisten déficits parciales. El próximo paso útil suele ser tratar la causa clínica dominante y repetir la evaluación.' : 'Si el paciente no llega al umbral, la salida correcta no es forzar el score, sino revisar estabilidad, analgesia, emesis y respiración.');
}

document.addEventListener('change', function(e){
  if(e.target.matches('.flacc-option-input')){
    updateAldrete();
  }
});

showEmptyState();
</script>
<?php require("../footer.php"); ?>
