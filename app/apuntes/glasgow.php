<?php
$titulo_pagina = "Escala de Glasgow";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "La escala de Glasgow evalúa el nivel de conciencia mediante tres dominios: respuesta ocular, verbal y motora. Su suma total va de 3 a 15 puntos y ayuda a describir gravedad neurológica, orientar vigilancia y anticipar implicancias anestésicas.";
$formula = "Glasgow = ocular (1–4) + verbal (1–5) + motora (1–6)";
$referencias = array(
  "Teasdale G, Jennett B. Assessment of coma and impaired consciousness. A practical scale. Lancet. 1974;2(7872):81-84.",
  "Rowley G, Fielding K. Reliability and accuracy of the Glasgow Coma scale with experienced and inexperienced users. Lancet. 1991;337(8740):535-538.",
  "Reith FC, Van den Brande R, Synnot A, Gruen R, Maas AI. The reliability of the Glasgow Coma Scale: a systematic review. Intensive Care Med. 2016;42(1):3-15."
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
          .gcs-domain-card{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }
          .gcs-domain-head{
            display:flex;
            align-items:center;
            gap:.65rem;
            margin-bottom:.85rem;
          }
          .gcs-domain-icon{
            color:#3559b7;
            font-size:1.05rem;
            width:1.2rem;
            text-align:center;
            flex:0 0 auto;
          }
          .gcs-domain-title{
            font-size:1rem;
            font-weight:800;
            line-height:1.3;
            color:var(--note-text);
            margin:0;
          }
          .gcs-option-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:.75rem;
          }
          .gcs-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
          .gcs-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:68px;
            border:2px solid var(--note-line);
            border-radius:.9rem;
            padding:.55rem .75rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.08rem;
          }
          .gcs-option-ok{background:#eef8f3;}
          .gcs-option-mid{background:#fff8e1;}
          .gcs-option-bad{background:#fff1f1;}
          .gcs-option-input:checked + .gcs-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }
          .gcs-option-text{
            font-size:.88rem;
            line-height:1.22;
            color:var(--note-text);
            margin:0;
            font-weight:700;
          }
          .gcs-option-points{
            font-size:1.08rem;
            font-weight:900;
            line-height:1;
            color:#3559b7;
            margin-top:.1rem;
          }
          .gcs-legend-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }
          .gcs-legend-item{
            border-radius:1rem;
            padding:.85rem;
            text-align:center;
            font-weight:800;
          }
          .gcs-legend-item small{
            display:block;
            font-weight:600;
            line-height:1.25;
            margin-top:.2rem;
          }
          .gcs-l0{background:#eaf8ef;color:#227a56;}
          .gcs-l1{background:#fff4cf;color:#9a6a00;}
          .gcs-l2{background:#fde2e2;color:#b42318;}
          .gcs-management-card{
            border-radius:1rem;
            padding:1rem;
            border:1px solid var(--note-line);
          }
          .gcs-management-ok{background:#edf8f1;border-color:#b7ddc3;}
          .gcs-management-mid{background:#fff9e8;border-color:#ead38a;}
          .gcs-management-high{background:#fff1f1;border-color:#efc0bd;}
          .gcs-management-title{
            font-size:1.08rem;
            font-weight:800;
            color:var(--note-text);
            margin-bottom:.6rem;
          }
          .gcs-check-item{
            display:flex;
            align-items:flex-start;
            gap:.8rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.95rem 1rem;
          }
          .gcs-check-mark{
            flex:0 0 auto;
            width:34px;
            height:34px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            margin-top:.08rem;
          }
          .gcs-check-mark.ok{background:#2ea663;}
          .gcs-check-mark.mid{background:#f4c542;}
          .gcs-check-mark.high{background:#d92d20;}
          .gcs-check-copy{min-width:0;flex:1;}
          .gcs-check-title{
            font-size:1rem;
            font-weight:800;
            line-height:1.22;
            color:var(--note-text);
            margin-bottom:.15rem;
          }
          .gcs-check-note{
            margin:0;
            font-size:.9rem;
            line-height:1.4;
            color:var(--note-muted);
          }
          @media (max-width:768px){
            .gcs-legend-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · EVALUACIÓN NEUROLÓGICA</div>
          <h2>Escala de Glasgow</h2>
          <div class="note-hero-subtitle">Selecciona una opción por dominio para calcular Glasgow total, gravedad neurológica e implicancias anestésicas.</div>
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
              <b>Fórmula:</b><br>
              <?php echo $formula; ?>
            <?php } ?>
            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mb-0 mt-2">
                <?php foreach($referencias as $ref){ ?>
                  <li class="mb-2"><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Cuestionario</div>

            <?php
            $domains = array(
              "ocular" => array(
                "title" => "Respuesta ocular",
                "icon" => "fa-eye",
                "options" => array(
                  array("score" => 4, "text" => "Espontánea", "level" => "ok"),
                  array("score" => 3, "text" => "A la voz / orden verbal", "level" => "mid"),
                  array("score" => 2, "text" => "Al dolor", "level" => "bad"),
                  array("score" => 1, "text" => "No responde", "level" => "bad")
                )
              ),
              "verbal" => array(
                "title" => "Respuesta verbal",
                "icon" => "fa-comment-medical",
                "options" => array(
                  array("score" => 5, "text" => "Orientado, conversa", "level" => "ok"),
                  array("score" => 4, "text" => "Desorientado", "level" => "mid"),
                  array("score" => 3, "text" => "Palabras inapropiadas", "level" => "mid"),
                  array("score" => 2, "text" => "Sonidos incomprensibles", "level" => "bad"),
                  array("score" => 1, "text" => "Sin respuesta", "level" => "bad")
                )
              ),
              "motora" => array(
                "title" => "Respuesta motora",
                "icon" => "fa-hand",
                "options" => array(
                  array("score" => 6, "text" => "Obedece órdenes", "level" => "ok"),
                  array("score" => 5, "text" => "Localiza el dolor", "level" => "mid"),
                  array("score" => 4, "text" => "Retira al dolor", "level" => "mid"),
                  array("score" => 3, "text" => "Flexión anormal", "level" => "bad"),
                  array("score" => 2, "text" => "Extensión", "level" => "bad"),
                  array("score" => 1, "text" => "Sin respuesta", "level" => "bad")
                )
              )
            );

            foreach($domains as $key => $domain){ ?>
              <div class="gcs-domain-card<?php echo $key === 'motora' ? ' mb-0' : ''; ?>">
                <div class="gcs-domain-head">
                  <div class="gcs-domain-icon"><i class="fa-solid <?php echo $domain['icon']; ?>"></i></div>
                  <div class="gcs-domain-title"><?php echo $domain['title']; ?></div>
                </div>
                <div class="gcs-option-grid">
                  <?php foreach($domain['options'] as $opt){ ?>
                    <label>
                      <input class="gcs-option-input" type="radio" name="<?php echo $key; ?>" value="<?php echo $opt['score']; ?>">
                      <div class="gcs-option gcs-option-<?php echo $opt['level']; ?>">
                        <p class="gcs-option-text"><?php echo $opt['text']; ?></p>
                        <div class="gcs-option-points"><?php echo $opt['score']; ?></div>
                      </div>
                    </label>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>

          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Selecciona respuesta ocular, verbal y motora para calcular Glasgow total.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Ocular</div>
                <div id="summaryOcular" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Verbal</div>
                <div id="summaryVerbal" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Motora</div>
                <div id="summaryMotora" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Categoría</div>
                <div id="summarySeverity" class="note-result-card-value">No completado</div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Glasgow total</div>
            <div id="totalScore" class="note-result-card-value">0</div>
            <div id="scoreText" class="note-result-card-note">Selecciona una opción por cada dominio.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Severidad</div>
            <div id="severityMain" class="note-result-card-value">—</div>
            <div id="severityText" class="note-result-card-note">Aún no evaluado completamente.</div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Interpretación rápida</div>
            <div class="gcs-legend-grid">
              <div class="gcs-legend-item gcs-l0">13–15<small>Compromiso leve</small></div>
              <div class="gcs-legend-item gcs-l1">9–12<small>Compromiso moderado</small></div>
              <div class="gcs-legend-item gcs-l2">3–8<small>Compromiso grave</small></div>
            </div>
          </div>
        </div>

        <div id="managementBox" class="gcs-management-card gcs-management-mid mb-3">
          <div id="managementTitle" class="gcs-management-title">Manejo anestésico sugerido</div>
          <div id="managementText">Completa ocular, verbal y motora para emitir una orientación.</div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">Glasgow describe el estado neurológico observado, pero debe interpretarse con contexto: sedación, intoxicación, bloqueo neuromuscular, hipoxia, shock, hipoglicemia, trauma y fármacos pueden modificar la respuesta.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="checklistBox" class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Completa los tres dominios antes de concluir</div>
                  <p class="note-warning-note">Un Glasgow incompleto puede ocultar deterioro neurológico o inducir falsa seguridad.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">No uses Glasgow como una cifra aislada: documenta componentes y tendencia</div>
          <div class="note-tips"><strong>Qué hacer:</strong> registra O+V+M además del total, reevalúa tendencia y busca causas reversibles de alteración de conciencia.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> sedar innecesariamente antes de documentar el basal neurológico si no hay una urgencia de vía aérea o seguridad.</div>
          <div class="note-tips"><strong>Perla:</strong> Glasgow 3–8 en contexto apropiado debe hacerte anticipar pérdida de reflejos protectores y necesidad de manejo avanzado de vía aérea.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> en anestesia, la prioridad no es solo clasificar; es proteger oxigenación, ventilación, perfusión cerebral y reevaluar.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const domains = ['ocular','verbal','motora'];

  function getSelectedValue(name){
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? Number(selected.value) : null;
  }

  function renderChecklist(level){
    const box = document.getElementById('checklistBox');
    let items = [];

    if(level === 'incomplete'){
      items = [
        ['mid','Completa los tres dominios antes de concluir','Un Glasgow incompleto puede ocultar deterioro neurológico o inducir falsa seguridad.']
      ];
    } else if(level === 'mild'){
      items = [
        ['ok','Documenta tendencia neurológica','Un Glasgow alto no reemplaza reevaluación seriada si el contexto clínico puede cambiar.'],
        ['ok','Evita deterioro secundario','Mantén oxigenación, normocapnia razonable, hemodinamia estable y control metabólico.']
      ];
    } else if(level === 'moderate'){
      items = [
        ['mid','Anticipa deterioro y baja reserva','Mantén vigilancia estrecha de vía aérea, ventilación, perfusión y cambios del examen neurológico.'],
        ['mid','Evita hipoxia, hipotensión e hipercapnia','Son agresiones secundarias relevantes en paciente neurológico vulnerable.']
      ];
    } else {
      items = [
        ['high','Anticipa manejo avanzado de vía aérea','Glasgow 3–8, en contexto apropiado, implica alto riesgo de pérdida de reflejos protectores.'],
        ['high','Coordina estrategia neuroprotectora','Prioriza oxigenación, ventilación, presión arterial, glicemia, temperatura y causa reversible.']
      ];
    }

    box.innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="note-warning-item">' +
        '<div class="note-warning-icon ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="note-warning-copy">' +
          '<div class="note-warning-title">' + item[1] + '</div>' +
          '<p class="note-warning-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateGlasgow(){
    const ocular = getSelectedValue('ocular');
    const verbal = getSelectedValue('verbal');
    const motora = getSelectedValue('motora');
    const values = [ocular, verbal, motora];
    const complete = values.every(function(v){ return v !== null; });
    const total = values.reduce(function(acc, v){ return acc + (v === null ? 0 : v); }, 0);

    document.getElementById('totalScore').textContent = total;
    document.getElementById('summaryOcular').textContent = ocular === null ? '—' : 'O' + ocular;
    document.getElementById('summaryVerbal').textContent = verbal === null ? '—' : 'V' + verbal;
    document.getElementById('summaryMotora').textContent = motora === null ? '—' : 'M' + motora;

    if(!complete){
      document.getElementById('scoreText').textContent = 'Selecciona una opción por cada dominio.';
      document.getElementById('severityMain').textContent = '—';
      document.getElementById('severityText').textContent = 'Aún no evaluado completamente.';
      document.getElementById('summaryNarrative').textContent = 'Selecciona respuesta ocular, verbal y motora para calcular Glasgow total.';
      document.getElementById('summarySeverity').textContent = 'No completado';
      document.getElementById('managementBox').className = 'gcs-management-card gcs-management-mid mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo anestésico sugerido';
      document.getElementById('managementText').textContent = 'Completa ocular, verbal y motora para emitir una orientación.';
      document.getElementById('warningText').textContent = 'Glasgow describe el estado neurológico observado, pero debe interpretarse con contexto: sedación, intoxicación, bloqueo neuromuscular, hipoxia, shock, hipoglicemia, trauma y fármacos pueden modificar la respuesta.';
      renderChecklist('incomplete');
      return;
    }

    document.getElementById('scoreText').textContent = 'O' + ocular + ' + V' + verbal + ' + M' + motora + ' = ' + total + ' / 15';

    if(total >= 13){
      document.getElementById('severityMain').textContent = 'Compromiso leve';
      document.getElementById('severityText').textContent = 'Glasgow 13–15.';
      document.getElementById('summaryNarrative').textContent = 'Glasgow ' + total + '/15 (O' + ocular + ' V' + verbal + ' M' + motora + '). Compromiso neurológico leve; documentar tendencia y contexto.';
      document.getElementById('summarySeverity').textContent = 'Leve';
      document.getElementById('managementBox').className = 'gcs-management-card gcs-management-ok mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo anestésico sugerido';
      document.getElementById('managementText').textContent = 'Mantén reevaluación frecuente, documenta tendencia y evita sedación innecesaria antes de completar valoración neurológica si no hay urgencia de seguridad.';
      document.getElementById('warningText').textContent = 'Glasgow leve no excluye deterioro si hay trauma, intoxicación, sangrado intracraneano, hipoxia u otra causa evolutiva.';
      renderChecklist('mild');
    } else if(total >= 9){
      document.getElementById('severityMain').textContent = 'Compromiso moderado';
      document.getElementById('severityText').textContent = 'Glasgow 9–12.';
      document.getElementById('summaryNarrative').textContent = 'Glasgow ' + total + '/15 (O' + ocular + ' V' + verbal + ' M' + motora + '). Compromiso neurológico moderado; requiere vigilancia estrecha.';
      document.getElementById('summarySeverity').textContent = 'Moderado';
      document.getElementById('managementBox').className = 'gcs-management-card gcs-management-mid mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo anestésico sugerido';
      document.getElementById('managementText').textContent = 'Alta vigilancia de vía aérea y ventilación. Evita hipotensión, hipoxemia e hipercapnia. Anticipa posible deterioro neurológico.';
      document.getElementById('warningText').textContent = 'Un Glasgow moderado puede deteriorarse. La tendencia y la causa importan tanto como el número aislado.';
      renderChecklist('moderate');
    } else {
      document.getElementById('severityMain').textContent = 'Compromiso grave';
      document.getElementById('severityText').textContent = 'Glasgow 3–8.';
      document.getElementById('summaryNarrative').textContent = 'Glasgow ' + total + '/15 (O' + ocular + ' V' + verbal + ' M' + motora + '). Compromiso neurológico grave; alto riesgo de pérdida de reflejos protectores.';
      document.getElementById('summarySeverity').textContent = 'Grave';
      document.getElementById('managementBox').className = 'gcs-management-card gcs-management-high mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo anestésico sugerido';
      document.getElementById('managementText').textContent = 'En contexto apropiado, Glasgow 3–8 debe hacer anticipar manejo avanzado de vía aérea, neuroprotección y control estricto de oxigenación, ventilación y presión arterial.';
      document.getElementById('warningText').textContent = 'Antes de atribuir Glasgow bajo solo a daño neurológico, busca causas reversibles: hipoglicemia, hipoxia, shock, intoxicación, sedantes o bloqueo neuromuscular.';
      renderChecklist('severe');
    }
  }

  domains.forEach(function(domain){
    document.querySelectorAll('input[name="' + domain + '"]').forEach(function(input){
      input.addEventListener('change', updateGlasgow);
    });
  });

  updateGlasgow();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
