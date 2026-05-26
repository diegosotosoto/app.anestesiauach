<?php
$titulo_pagina = "Clinical Frailty Scale";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "La Clinical Frailty Scale (CFS) es una escala clínica de 9 niveles que resume el estado global de fragilidad de una persona mayor a partir del juicio clínico, funcionalidad basal, dependencia, carga de enfermedad y situación vital previa al evento agudo.";
$formula = "CFS = juicio clínico estructurado; no es un cuestionario ni una suma aritmética de puntos.";
$referencias = array(
  "Rockwood K, Song X, MacKnight C, Bergman H, Hogan DB, McDowell I, Mitnitski A. A global clinical measure of fitness and frailty in elderly people. CMAJ. 2005;173(5):489-495.",
  "Rockwood K, Theou O. Using the Clinical Frailty Scale in Allocating Scarce Health Care Resources. Can Geriatr J. 2020;23(3):210-215.",
  "Dalhousie University, Geriatric Medicine Research. Clinical Frailty Scale, versión 2.0, escala actual de 9 puntos. <a href='https://www.dal.ca/sites/gmr/our-tools/clinical-frailty-scale.html' target='_blank' rel='noopener noreferrer'>https://www.dal.ca/sites/gmr/our-tools/clinical-frailty-scale.html</a>
  "
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .cfs-scale-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.85rem;
          }
          .cfs-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
          .cfs-option{
            display:flex;
            flex-direction:column;
            min-height:166px;
            height:100%;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1.1rem;
            padding:.95rem;
            cursor:pointer;
            transition:.15s ease;
          }
          .cfs-option-input:checked + .cfs-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }
          .cfs-option-input:checked + .cfs-option .cfs-number{
            background:#eaf7ef;
            color:#1f9d55;
            border-color:#bfe4cb;
          }
          .cfs-option-top{
            display:flex;
            align-items:center;
            gap:.7rem;
            margin-bottom:.65rem;
          }
          .cfs-number{
            width:38px;
            height:38px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 auto;
            background:#eef4ff;
            color:#3559b7;
            border:1px solid #c7d7fe;
            font-weight:900;
            font-size:1.05rem;
          }
          .cfs-title{
            font-size:.98rem;
            font-weight:900;
            color:var(--note-text);
            line-height:1.15;
            margin:0;
          }
          .cfs-subtitle{
            font-size:.84rem;
            font-weight:800;
            color:#667085;
            margin:.1rem 0 0 0;
            line-height:1.15;
          }
          .cfs-desc{
            font-size:.9rem;
            line-height:1.35;
            color:#344054;
            margin:0;
          }
          .cfs-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }
          .cfs-plan-line:last-child{margin-bottom:0;}
          .cfs-other-risk{
            padding:.85rem .95rem;
            border-radius:.95rem;
            background:#f8fafc;
            border:1px solid var(--note-line-strong);
            margin-bottom:.55rem;
          }
          .cfs-other-risk:last-child{margin-bottom:0;}
          .cfs-pill-row{
            display:flex;
            flex-wrap:wrap;
            gap:.5rem;
            justify-content:center;
            margin-top:.8rem;
          }
          .cfs-pill{
            border-radius:999px;
            padding:.42rem .68rem;
            background:#f8fafc;
            border:1px solid var(--note-line-strong);
            color:#344054;
            font-size:.84rem;
            font-weight:800;
          }
          .cfs-dose-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:1rem;
          }
          @media (max-width:992px){
            .cfs-scale-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
          }
          @media (max-width:520px){
            .cfs-scale-grid{grid-template-columns:1fr;}
            .cfs-dose-grid{grid-template-columns:1fr;}
          }

          /* Dark mode overrides */
          body.theme-dark .cfs-number,
          body.ui-nocturno .cfs-number{
            background:var(--app-card);
            border-color:var(--app-border);
            color:var(--app-text);
          }
          body.theme-dark .cfs-option-input:checked + .cfs-option .cfs-number,
          body.ui-nocturno .cfs-option-input:checked + .cfs-option .cfs-number{
            background:rgba(31,157,85,.15);
            color:#6fe496;
            border-color:rgba(31,157,85,.3);
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · EVALUACIÓN PREOPERATORIA</div>
          <h2>Clinical Frailty Scale</h2>
          <div class="note-hero-subtitle">Escala clínica de fragilidad de 9 niveles para estratificar funcionalidad basal, dependencia y vulnerabilidad perioperatoria.</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Concepto:</b><br>
              <?php echo $formula; ?>
            <?php } ?>
            <hr>
            <b>Referencias:</b>
            <ul class="mb-0 mt-2">
              <?php foreach($referencias as $ref){ ?>
                <li class="mb-2"><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Selecciona el nivel que mejor describe la condición basal</div>
            <div class="note-warning mb-3">
              <strong>Clave:</strong> evalúa la situación habitual del paciente antes de la enfermedad aguda actual. No puntúes la dependencia transitoria producida por sepsis, trauma, dolor, delirium, fractura o cirugía reciente.
            </div>

            <?php
            $levels = array(
              array('n'=>1,'label'=>'Muy en forma','tag'=>'robusto','desc'=>'Persona activa, energética y motivada; suele ejercitarse o mantenerse físicamente exigente para su edad.'),
              array('n'=>2,'label'=>'En forma','tag'=>'independiente','desc'=>'Sin síntomas activos importantes; menos activa que el nivel 1, pero estable y funcionalmente independiente.'),
              array('n'=>3,'label'=>'Se maneja bien','tag'=>'controlado','desc'=>'Problemas médicos controlados; no realiza actividad intensa regularmente, pero mantiene independencia cotidiana.'),
              array('n'=>4,'label'=>'Fragilidad muy leve','tag'=>'vulnerable','desc'=>'No depende de otros para actividades básicas, pero los síntomas limitan la actividad y las tareas demandantes.'),
              array('n'=>5,'label'=>'Fragilidad leve','tag'=>'ayuda parcial','desc'=>'Necesita ayuda en actividades instrumentales complejas como compras, transporte, finanzas, medicamentos o tareas domésticas pesadas.'),
              array('n'=>6,'label'=>'Fragilidad moderada','tag'=>'ayuda diaria','desc'=>'Requiere ayuda para actividades fuera del hogar y algunas tareas personales; suele conservar parte del autocuidado.'),
              array('n'=>7,'label'=>'Fragilidad severa','tag'=>'dependiente','desc'=>'Dependiente para el cuidado personal por causas físicas o cognitivas, aunque no necesariamente en fase terminal.'),
              array('n'=>8,'label'=>'Fragilidad muy severa','tag'=>'muy dependiente','desc'=>'Completamente dependiente y con reserva fisiológica muy limitada; vulnerable incluso ante agresiones menores.'),
              array('n'=>9,'label'=>'Enfermedad terminal','tag'=>'final de vida','desc'=>'Expectativa de vida limitada por enfermedad terminal, con o sin fragilidad avanzada evidente.')
            );
            ?>

            <div class="cfs-scale-grid">
              <?php foreach($levels as $level){ ?>
              <label>
                <input class="cfs-option-input" type="radio" name="cfs_level" value="<?php echo $level['n']; ?>">
                <div class="cfs-option">
                  <div class="cfs-option-top">
                    <div class="cfs-number"><?php echo $level['n']; ?></div>
                    <div>
                      <div class="cfs-title"><?php echo $level['label']; ?></div>
                      <div class="cfs-subtitle"><?php echo $level['tag']; ?></div>
                    </div>
                  </div>
                  <p class="cfs-desc"><?php echo $level['desc']; ?></p>
                </div>
              </label>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Selecciona un nivel CFS para ver la explicación y las recomendaciones.</div>
          <div class="note-result-grid-2 mt-2">
            <div class="note-result-card">
              <div class="note-result-card-label">CFS</div>
              <div id="summaryScore" class="note-result-card-value">—</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Categoría</div>
              <div id="summaryLevel" class="note-result-card-value">Sin seleccionar</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Reserva</div>
              <div id="summaryReserve" class="note-result-card-value">—</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Estrategia</div>
              <div id="summaryStrategy" class="note-result-card-value">—</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Puntaje</div>
            <div id="scoreNum" class="note-result-card-value">—</div>
            <div id="scoreText" class="note-result-card-note">Selecciona una categoría</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Interpretación clínica</div>
            <div id="riskLabel" class="note-result-card-value">—</div>
            <div id="riskInterpretation" class="note-result-card-note">La interpretación aparecerá al seleccionar un nivel.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Recomendaciones orientativas</div>
          <div id="algoRisk" class="note-interpretation-main">Sin selección</div>
          <div id="algoExtra" class="note-interpretation-soft">Selecciona un nivel para generar recomendaciones orientativas.</div>
          <div id="managementPlan" class="mt-3 text-start">
            <div class="cfs-plan-line">Las recomendaciones aparecerán al seleccionar una categoría.</div>
          </div>




        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Ejes de manejo perioperatorio</div>
          <div class="note-result-grid-2 mt-2">
            <div class="note-result-card"> 
              <div class="note-result-card-label">Funcionalidad basal</div>
              <div id="summaryScore" class="note-result-card-value">ADL, IADL, movilidad, caídas</div>
                </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Cognición</div>
              <div id="summaryScore" class="note-result-card-value">delirium previo, demencia, tamizaje</div>
              </div>
            <div class="note-result-card">
          <div class="note-summary-box-title">Medicamentos</div>
              <div id="summaryScore" class="note-result-card-value">polifarmacia, anticolinérgicos, sedantes</div>
                </div>
            <div class="note-result-card">
          <div class="note-summary-box-title">Objetivos de cuidado</div>
              <div id="summaryScore" class="note-result-card-value">expectativas, límites, recuperación esperada</div>

            </div>
          </div>
        </div>





        <div class="note-warning mb-3">
          <strong>No usar como número aislado:</strong>
          <div id="warningText" class="mt-2">La CFS requiere juicio clínico. Si el puntaje obtenido no calza con la impresión global, revisa funcionalidad basal, cognición, movilidad y dependencia antes de decidir.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Factores que deben acompañar a la CFS</div>
            <div class="cfs-other-risk"><strong>Basal real:</strong> pregunta cómo estaba 2 semanas a 3 meses antes del evento agudo, no solo cómo está hoy hospitalizado.</div>
            <div class="cfs-other-risk"><strong>Actividades instrumentales:</strong> compras, transporte, cocina, aseo pesado, medicamentos y finanzas suelen separar CFS 4 de CFS 5.</div>
            <div class="cfs-other-risk"><strong>Actividades básicas:</strong> ayuda para baño, vestirse, continencia, transferencias o alimentación orienta a CFS 6-7.</div>
            <div class="cfs-other-risk"><strong>Cognición:</strong> deterioro cognitivo puede aumentar dependencia aunque la fuerza física parezca aceptable.</div>
            <div class="cfs-other-risk"><strong>Terminalidad:</strong> CFS 9 se define por expectativa vital limitada; no exige que el paciente sea muy frágil.</div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">La CFS no mide “qué tan enfermo está hoy”, sino cuánta reserva tenía antes de enfermar</div>
          <div class="note-tips"><strong>Qué hacer:</strong> documenta el CFS junto a movilidad, independencia, soporte social, cognición y objetivos de cuidado.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> subir el CFS solo porque el paciente está postrado por una neumonía, fractura o dolor agudo.</div>
          <div class="note-tips"><strong>Perla:</strong> desde CFS 5 cambia la conversación: no basta “apto/no apto”; hay que anticipar delirium, dependencia postoperatoria, destino al alta y rehabilitación.</div>
          <div class="note-tips mb-0"><strong>Para residentes:</strong> si no sabes diferenciar CFS 4, 5 y 6, pregunta “¿qué cosas podía hacer solo en casa?” y “¿qué necesitaba que otro hiciera por él?”.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const radios = Array.from(document.querySelectorAll('.cfs-option-input'));

  const data = {
    1: {
      label:'Muy en forma', reserve:'Excelente', group:'Robusto', strategy:'Manejo habitual',
      interpretation:'Reserva fisiológica alta para su edad; suele tolerar mejor agresiones, aunque el riesgo quirúrgico sigue dependiendo del procedimiento y comorbilidades.',
      narrative:'CFS 1. Persona muy activa, robusta y con excelente reserva funcional.',
      algo:'Paciente robusto',
      extra:'Enfocar la evaluación en riesgo quirúrgico específico, comorbilidades y preferencias; no asumir bajo riesgo solo por buen estado funcional.',
      plan:[
        'Manejo anestésico habitual ajustado al procedimiento y comorbilidades.',
        'Promover movilización precoz, analgesia multimodal y prevención estándar de complicaciones.',
        'Documentar funcionalidad basal como referencia para recuperación postoperatoria.'
      ],
      warning:'Buen estado funcional no elimina riesgo cardiovascular, pulmonar, farmacológico ni quirúrgico.'
    },
    2: {
      label:'En forma', reserve:'Alta', group:'Independiente', strategy:'Manejo habitual + optimización',
      interpretation:'Paciente independiente y estable, sin dependencia funcional significativa.',
      narrative:'CFS 2. Paciente en forma, independiente y clínicamente estable.',
      algo:'Paciente independiente con buena reserva',
      extra:'Evaluación preoperatoria estándar, optimización de comorbilidades y plan de recuperación funcional.',
      plan:[
        'Confirmar capacidad funcional, fármacos crónicos y estabilidad de enfermedades conocidas.',
        'Planificar analgesia que favorezca movilización y disminuya opioides innecesarios.',
        'Evitar iatrogenia: hipotensión prolongada, sedación excesiva y ayunos innecesarios.'
      ],
      warning:'No confundas “edad avanzada” con fragilidad: la CFS se basa en función y reserva, no en edad cronológica.'
    },
    3: {
      label:'Se maneja bien', reserve:'Conservada', group:'No frágil', strategy:'Manejo habitual + optimización',
      interpretation:'Independiente, comorbilidades controladas, riesgo dependiente principalmente de cirugía y enfermedad de base.',
      narrative:'Selecciona un nivel CFS para ver la explicación y las recomendaciones.',
      algo:'Paciente no frágil o vulnerable leve',
      extra:'Mantener evaluación preoperatoria estándar, optimizar comorbilidades y documentar funcionalidad basal.',
      plan:[
        'Confirmar capacidad funcional basal, autonomía, fármacos crónicos y red de apoyo.',
        'Plan anestésico según cirugía, comorbilidades y riesgo específico del procedimiento.',
        'Anticipar recuperación esperada y criterios de alta seguros.'
      ],
      warning:'Una CFS baja no reemplaza escalas específicas cuando el problema dominante es cardiaco, pulmonar o neurológico.'
    },
    4: {
      label:'Fragilidad muy leve', reserve:'Disminuida', group:'Vulnerable', strategy:'Optimización + prevención',
      interpretation:'Independiente para autocuidado, pero con síntomas o limitación que reducen reserva ante estrés quirúrgico.',
      narrative:'CFS 4. Vulnerabilidad funcional; no hay dependencia básica, pero existe menor reserva.',
      algo:'Paciente vulnerable',
      extra:'La prioridad es no convertir vulnerabilidad en dependencia postoperatoria.',
      plan:[
        'Buscar causas modificables: anemia, desnutrición, mal control glicémico, insuficiencia cardiaca, EPOC, dolor, sarcopenia.',
        'Planificar movilización precoz, analgesia multimodal y retiro oportuno de sondas/catéteres.',
        'Comunicar riesgo aumentado de delirium, caídas y recuperación lenta según cirugía.'
      ],
      warning:'CFS 4 no es “sano”; es el punto donde pequeños errores perioperatorios pueden generar deterioro funcional.'
    },
    5: {
      label:'Fragilidad leve', reserve:'Baja', group:'Frágil leve', strategy:'Manejo geriátrico-perioperatorio',
      interpretation:'Dependencia en actividades instrumentales complejas; mayor riesgo de complicaciones, delirium y pérdida funcional.',
      narrative:'CFS 5. Fragilidad leve: requiere ayuda parcial para tareas complejas de la vida diaria.',
      algo:'Paciente frágil leve',
      extra:'Desde este nivel conviene activar mirada geriátrica, plan de alta y prevención activa de delirium.',
      plan:[
        'Revisar polifarmacia: benzodiacepinas, anticolinérgicos, hipnóticos, opioides crónicos y antihipertensivos de riesgo.',
        'Definir plan de analgesia multimodal, movilización, nutrición y prevención de delirium desde el preoperatorio.',
        'Conversar objetivos de cuidado, expectativa funcional y destino probable al alta.'
      ],
      warning:'CFS 5 cambia el umbral de vigilancia: anticipa delirium, dependencia nueva y necesidad de rehabilitación.'
    },
    6: {
      label:'Fragilidad moderada', reserve:'Muy baja', group:'Frágil moderado', strategy:'Plan individualizado',
      interpretation:'Necesita ayuda diaria o frecuente; alto riesgo de complicaciones, estadía prolongada y recuperación incompleta.',
      narrative:'CFS 6. Fragilidad moderada: dependencia relevante para actividades fuera del hogar y parte del autocuidado.',
      algo:'Paciente frágil moderado',
      extra:'La pregunta ya no es solo “si se puede operar”, sino qué resultado funcional es realista.',
      plan:[
        'Solicitar apoyo geriátrico/medicina interna si está disponible, especialmente en cirugía mayor o urgencia.',
        'Definir objetivos de cuidado, techo terapéutico razonable, manejo del dolor y estrategia de delirium.',
        'Planificar postoperatorio: unidad de destino, rehabilitación, nutrición, prevención de úlceras y caídas.'
      ],
      warning:'Evita consentimientos centrados solo en mortalidad; en CFS 6 importa mucho la probabilidad de no volver al basal.'
    },
    7: {
      label:'Fragilidad severa', reserve:'Crítica', group:'Frágil severo', strategy:'Decisión compartida + plan de límites',
      interpretation:'Dependiente para cuidado personal; alto riesgo de mal resultado funcional, delirium, institucionalización y muerte según contexto.',
      narrative:'CFS 7. Fragilidad severa: dependencia importante para el autocuidado.',
      algo:'Paciente frágil severo',
      extra:'Requiere decisión compartida explícita, proporcionalidad terapéutica y planificación postoperatoria realista.',
      plan:[
        'Aclarar objetivos: alivio de síntomas, supervivencia, retorno al domicilio, evitar UCI, evitar dependencia mayor.',
        'Discutir riesgos de ventilación prolongada, delirium, falla de rehabilitación y destino al alta.',
        'Ajustar anestesia y monitorización a proporcionalidad terapéutica, no a rutina automática.'
      ],
      warning:'En CFS 7, “cirugía técnicamente posible” no equivale a “cirugía clínicamente beneficiosa”.'
    },
    8: {
      label:'Fragilidad muy severa', reserve:'Mínima', group:'Muy frágil', strategy:'Proporcionalidad / paliativo integrado',
      interpretation:'Dependencia completa y reserva muy limitada; incluso intervenciones menores pueden precipitar deterioro severo.',
      narrative:'CFS 8. Fragilidad muy severa: dependencia completa y muy baja reserva fisiológica.',
      algo:'Paciente muy severamente frágil',
      extra:'El manejo debe centrarse en proporcionalidad, confort, objetivos de cuidado y beneficio real de la intervención.',
      plan:[
        'Considerar alternativas no quirúrgicas, técnicas menos invasivas o enfoque paliativo si el beneficio es dudoso.',
        'Si se opera, definir previamente UCI, reintubación, RCP, vasopresores y límites terapéuticos.',
        'Priorizar analgesia, confort, prevención de delirium y comunicación clara con familia/equipo.'
      ],
      warning:'No normalices escalamiento terapéutico automático en CFS 8; debe existir una meta clínica alcanzable.'
    },
    9: {
      label:'Enfermedad terminal', reserve:'Limitada por terminalidad', group:'Terminal', strategy:'Objetivos de cuidado',
      interpretation:'Expectativa vital limitada por enfermedad terminal; la CFS 9 puede existir incluso sin dependencia funcional extrema.',
      narrative:'CFS 9. Enfermedad terminal: expectativa de vida limitada, con o sin fragilidad avanzada.',
      algo:'Paciente con enfermedad terminal',
      extra:'La decisión debe partir por objetivos de cuidado, control de síntomas y proporcionalidad de la intervención.',
      plan:[
        'Aclarar si la cirugía es curativa, paliativa, de control de síntomas o potencialmente fútil.',
        'Definir límites: RCP, UCI, ventilación, transfusión, vasopresores y reintervención.',
        'Coordinar con equipo tratante, cuidados paliativos y familia; documentar acuerdos claramente.'
      ],
      warning:'CFS 9 no significa automáticamente “muy dependiente”; significa enfermedad terminal y expectativa vital limitada.'
    }
  };

  function getLevel(){
    const selected = document.querySelector('input[name="cfs_level"]:checked');
    return selected ? Number(selected.value) : null;
  }

  function planHtml(items){
    return items.map(function(item){ return '<div class="cfs-plan-line">' + item + '</div>'; }).join('');
  }

  function render(){
    const level = getLevel();

    if(level === null){
      document.getElementById('scoreNum').textContent = '—';
      document.getElementById('scoreText').textContent = 'Selecciona una categoría';
      document.getElementById('riskLabel').textContent = '—';
      document.getElementById('riskInterpretation').textContent = 'La interpretación aparecerá al seleccionar un nivel.';

      document.getElementById('summaryNarrative').textContent = 'Selecciona un nivel CFS para ver la explicación y las recomendaciones.';
      document.getElementById('summaryScore').textContent = '—';
      document.getElementById('summaryLevel').textContent = 'Sin seleccionar';
      document.getElementById('summaryReserve').textContent = '—';
      document.getElementById('summaryStrategy').textContent = '—';

      document.getElementById('algoRisk').textContent = 'Sin selección';
      document.getElementById('algoExtra').textContent = 'Selecciona un nivel para generar recomendaciones orientativas.';
      document.getElementById('managementPlan').innerHTML = '<div class="cfs-plan-line">Las recomendaciones aparecerán al seleccionar una categoría.</div>';
      document.getElementById('warningText').textContent = 'La CFS requiere juicio clínico. Si el puntaje obtenido no calza con la impresión global, revisa funcionalidad basal, cognición, movilidad y dependencia antes de decidir.';
      return;
    }

    const item = data[level];

    document.getElementById('scoreNum').textContent = level;
    document.getElementById('scoreText').textContent = 'CFS ' + level + ' · ' + item.label;
    document.getElementById('riskLabel').textContent = item.reserve;
    document.getElementById('riskInterpretation').textContent = item.interpretation;

    document.getElementById('summaryNarrative').textContent = item.narrative;
    document.getElementById('summaryScore').textContent = String(level);
    document.getElementById('summaryLevel').textContent = item.label;
    document.getElementById('summaryReserve').textContent = item.reserve;
    document.getElementById('summaryStrategy').textContent = item.strategy;

    document.getElementById('algoRisk').textContent = item.algo;
    document.getElementById('algoExtra').textContent = item.extra;
    document.getElementById('managementPlan').innerHTML = planHtml(item.plan);
    document.getElementById('warningText').textContent = item.warning;
  }

  radios.forEach(function(r){ r.addEventListener('change', render); });
  render();
})();

function toggleInfo(){
  const box = document.getElementById('infoContent');
  box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
}
</script>

<?php require("../footer.php"); ?>
