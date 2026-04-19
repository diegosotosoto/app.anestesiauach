<?php
$titulo_pagina = "Escala FLACC";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "La escala FLACC permite evaluar dolor en lactantes, niños pequeños o pacientes no comunicativos mediante cinco dominios observacionales: cara, piernas, actividad, llanto y consolabilidad. Cada dominio puntúa 0, 1 o 2 para un total de 0 a 10.";
$formula = "FLACC = Cara (0-2) + Piernas (0-2) + Actividad (0-2) + Llanto (0-2) + Consolabilidad (0-2)";
$referencias = array(
  "Merkel SI, Voepel-Lewis T, Shayevitz JR, Malviya S. The FLACC: a behavioral scale for scoring postoperative pain in young children. Pediatr Nurs. 1997;23(3):293-297.",
  "Voepel-Lewis T, Zanotti J, Dammeyer JA, Merkel S. Reliability and validity of the Face, Legs, Activity, Cry, Consolability behavioral tool in assessing acute pain in critically ill patients. Am J Crit Care. 2010;19(1):55-61."
);

include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .flacc-domain-card{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }
          .flacc-domain-head{
            display:flex;
            align-items:center;
            gap:.65rem;
            margin-bottom:.85rem;
          }
          .flacc-domain-icon{
            color:#3559b7;
            font-size:1.05rem;
            width:1.2rem;
            text-align:center;
            flex:0 0 auto;
          }
          .flacc-domain-title{
            font-size:1rem;
            font-weight:800;
            line-height:1.3;
            color:var(--note-text);
            margin:0;
          }
          .flacc-score-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:.75rem;
          }
          .flacc-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
.flacc-option{
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  text-align:center;
  min-height:68px;
  border:2px solid var(--note-line);
  border-radius:.9rem;
  padding:.62rem .8rem;
  cursor:pointer;
  transition:.15s ease;
  box-shadow:0 3px 10px rgba(15,23,42,.04);
  gap:.12rem;
}
          .flacc-option-0{background:#eef8f3;}
          .flacc-option-1{background:#fff8e1;}
          .flacc-option-2{background:#fff1f1;}

          .flacc-option-input:checked + .flacc-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

.flacc-option-text{
  font-size:.86rem;
  line-height:1.22;
  color:var(--note-text);
  margin:0;
  font-weight:700;
}
.flacc-option-points{
  font-size:1.05rem;
  font-weight:900;
  line-height:1;
  color:#3559b7;
}

          .flacc-legend-grid{
            display:grid;
            grid-template-columns:repeat(5,minmax(0,1fr));
            gap:.75rem;
          }
          .flacc-legend-item{
            border-radius:1rem;
            padding:.8rem;
            text-align:center;
            font-weight:800;
          }
          .flacc-legend-item small{
            display:block;
            font-weight:600;
            margin-top:.2rem;
            line-height:1.25;
          }
          .flacc-l0{background:#d8f3e7;color:#146c43;}
          .flacc-l1{background:#eaf8ef;color:#227a56;}
          .flacc-l2{background:#fff4cf;color:#9a6a00;}
          .flacc-l3{background:#ffe3b8;color:#9c5600;}
          .flacc-l4{background:#fde2e2;color:#b42318;}

          .flacc-management-card{
            border-radius:1rem;
            padding:1rem;
            border:1px solid var(--note-line);
          }
          .flacc-management-ok{background:#edf8f1;border-color:#b7ddc3;}
          .flacc-management-mid{background:#fff9e8;border-color:#ead38a;}
          .flacc-management-high{background:#fff1f1;border-color:#efc0bd;}

          .flacc-management-title{
            font-size:1.08rem;
            font-weight:800;
            color:var(--note-text);
            margin-bottom:.6rem;
          }

          .flacc-check-item{
            display:flex;
            align-items:flex-start;
            gap:.8rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.95rem 1rem;
          }
          .flacc-check-mark{
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
          .flacc-check-mark.ok{background:#2ea663;}
          .flacc-check-mark.mid{background:#f4c542;}
          .flacc-check-mark.high{background:#d92d20;}
          .flacc-check-copy{min-width:0;flex:1;}
          .flacc-check-title{
            font-size:1rem;
            font-weight:800;
            line-height:1.22;
            color:var(--note-text);
            margin-bottom:.15rem;
          }
          .flacc-check-note{
            margin:0;
            font-size:.9rem;
            line-height:1.4;
            color:var(--note-muted);
          }

          @media (max-width:992px){
            .flacc-legend-grid{grid-template-columns:repeat(3,minmax(0,1fr));}
          }
          @media (max-width:768px){
            .flacc-legend-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
          }
          @media (max-width:420px){
            .flacc-legend-grid{grid-template-columns:1fr;}
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · DOLOR PEDIÁTRICO</div>
          <h2>Escala FLACC</h2>
          <div class="note-hero-subtitle">Selecciona una opción por cada dominio para estimar dolor observacional y orientar reevaluación y manejo.</div>
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
              "cara" => array(
                "title" => "Expresión facial",
                "icon" => "fa-face-frown",
                "options" => array(
                  array("score" => 0, "text" => "Relajada, expresión neutra"),
                  array("score" => 1, "text" => "Mueca o fruncimiento; niño retraído"),
                  array("score" => 2, "text" => "Mandíbula tensa, temblor del mentón o expresión claramente dolorosa")
                )
              ),
              "piernas" => array(
                "title" => "Piernas",
                "icon" => "fa-person-walking",
                "options" => array(
                  array("score" => 0, "text" => "Posición normal, relajada"),
                  array("score" => 1, "text" => "Incómodo, inquieto o tenso"),
                  array("score" => 2, "text" => "Pataleo o elevación marcada de las piernas")
                )
              ),
              "actividad" => array(
                "title" => "Actividad",
                "icon" => "fa-child-reaching",
                "options" => array(
                  array("score" => 0, "text" => "Tranquilo, se mueve normal"),
                  array("score" => 1, "text" => "Se retuerce, se balancea o está tenso"),
                  array("score" => 2, "text" => "Cuerpo arqueado, rigidez o movimientos espasmódicos")
                )
              ),
              "llanto" => array(
                "title" => "Llanto",
                "icon" => "fa-volume-high",
                "options" => array(
                  array("score" => 0, "text" => "No llora ni está quejoso"),
                  array("score" => 1, "text" => "Quejido o llanto ocasional; se tranquiliza con la voz o el abrazo"),
                  array("score" => 2, "text" => "Llanto persistente, gritos o quejido continuo")
                )
              ),
              "consuelo" => array(
                "title" => "Capacidad de consuelo",
                "icon" => "fa-hand-holding-heart",
                "options" => array(
                  array("score" => 0, "text" => "Tranquilo"),
                  array("score" => 1, "text" => "Se tranquiliza con la voz o con el abrazo"),
                  array("score" => 2, "text" => "Difícil de consolar o tranquilizar")
                )
              )
            );

            foreach($domains as $key => $domain){ ?>
              <div class="flacc-domain-card<?php echo $key === 'consuelo' ? ' mb-0' : ''; ?>">
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

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Selecciona una opción por cada dominio para obtener un puntaje total FLACC y una orientación de manejo.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Puntaje total</div>
              <div id="summaryScore" class="note-summary-v">0 / 10</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Categoría</div>
              <div id="summarySeverity" class="note-summary-v">No completado</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Estado</div>
              <div id="summaryState" class="note-summary-v">Incompleto</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Conducta</div>
              <div id="summaryPlan" class="note-summary-v">Completar evaluación</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Puntaje total</div>
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
            <div class="flacc-legend-grid">
              <div class="flacc-legend-item flacc-l0">0<small>Sin dolor</small></div>
              <div class="flacc-legend-item flacc-l1">1–2<small>Dolor leve</small></div>
              <div class="flacc-legend-item flacc-l2">3–5<small>Dolor moderado</small></div>
              <div class="flacc-legend-item flacc-l3">6–8<small>Dolor intenso</small></div>
              <div class="flacc-legend-item flacc-l4">9–10<small>Máximo dolor imaginable</small></div>
            </div>
          </div>
        </div>

        <div id="managementBox" class="flacc-management-card flacc-management-mid mb-3">
          <div id="managementTitle" class="flacc-management-title">Manejo sugerido</div>
          <div id="managementText">Completa los cinco dominios para obtener el puntaje total y una orientación de manejo.</div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">FLACC orienta la evaluación del dolor observacional, pero no reemplaza la valoración del contexto clínico, la causa del malestar ni la reevaluación tras una intervención.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="checklistBox" class="d-grid gap-3">
              <div class="flacc-check-item">
                <div class="flacc-check-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="flacc-check-copy">
                  <div class="flacc-check-title">Completa los cinco dominios antes de concluir</div>
                  <p class="flacc-check-note">Un FLACC incompleto puede subestimar o distorsionar la impresión clínica del dolor.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">No confundas conducta dolorosa con una sola cifra</div>
          <div class="note-tips"><strong>Qué hacer:</strong> interpreta FLACC junto al procedimiento, el momento evolutivo, el estado basal y la respuesta al consuelo o a la analgesia.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> asumir que todo llanto o movimiento equivale automáticamente a dolor intenso sin revisar otras causas de malestar.</div>
          <div class="note-tips"><strong>Perla:</strong> el valor real de FLACC no es solo puntuar, sino reevaluar después de una intervención y verificar si la conducta cambia.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si la conducta no mejora tras analgesia adecuada, busca causa adicional y reexamina el contexto clínico.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const domains = ['cara','piernas','actividad','llanto','consuelo'];

  function getSelectedValue(name){
    const selected = document.querySelector('input[name="' + name + '"]:checked');
    return selected ? Number(selected.value) : null;
  }

  function renderChecklist(level){
    const box = document.getElementById('checklistBox');
    let items = [];

    if(level === 'incomplete'){
      items = [
        ['mid','Completa los cinco dominios antes de concluir','Un FLACC incompleto puede subestimar o distorsionar la impresión clínica del dolor.']
      ];
    } else if(level === 'none'){
      items = [
        ['ok','Mantén observación y reevaluación periódica','Sin evidencia conductual de dolor en este momento, pero el contexto clínico puede cambiar rápidamente.'],
        ['ok','Confirma confort global','Revisa posición, temperatura, contención y estímulos ambientales antes de asumir estabilidad sostenida.']
      ];
    } else if(level === 'mild'){
      items = [
        ['ok','Refuerza medidas no farmacológicas','Contención, voz, abrazo, reposicionamiento y reducción de estímulos pueden ser suficientes.'],
        ['ok','Reevalúa tras intervención simple','La tendencia del puntaje tras consuelo o analgesia es más útil que una cifra aislada.']
      ];
    } else if(level === 'moderate'){
      items = [
        ['mid','Considera analgesia farmacológica apropiada','Escala el tratamiento según edad, procedimiento y contexto clínico.'],
        ['mid','Reevalúa FLACC tras la intervención','La respuesta al manejo debe quedar documentada y no asumirse.']
      ];
    } else {
      items = [
        ['high','Trata el dolor de forma oportuna','No retrases manejo analgésico cuando la conducta sugiere dolor importante.'],
        ['high','Busca causa subyacente y monitoriza respuesta','Un puntaje alto obliga a confirmar diagnóstico, reevaluar y vigilar evolución estrechamente.']
      ];
    }

    box.innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="flacc-check-item">' +
        '<div class="flacc-check-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="flacc-check-copy">' +
          '<div class="flacc-check-title">' + item[1] + '</div>' +
          '<p class="flacc-check-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateFLACC(){
    const values = domains.map(getSelectedValue);
    const complete = values.every(function(v){ return v !== null; });
    const total = values.reduce(function(acc, v){ return acc + (v === null ? 0 : v); }, 0);

    document.getElementById('totalScore').textContent = total;
    document.getElementById('summaryScore').textContent = total + ' / 10';

    if(!complete){
      document.getElementById('scoreText').textContent = 'Selecciona una opción por cada dominio.';
      document.getElementById('severityMain').textContent = '—';
      document.getElementById('severityText').textContent = 'Aún no evaluado completamente.';
      document.getElementById('summaryNarrative').textContent = 'Selecciona una opción por cada dominio para obtener un puntaje total FLACC y una orientación de manejo.';
      document.getElementById('summarySeverity').textContent = 'No completado';
      document.getElementById('summaryState').textContent = 'Incompleto';
      document.getElementById('summaryPlan').textContent = 'Completar evaluación';
      document.getElementById('managementBox').className = 'flacc-management-card flacc-management-mid mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo sugerido';
      document.getElementById('managementText').textContent = 'Completa los cinco dominios para obtener el puntaje total y una orientación de manejo.';
      document.getElementById('warningText').textContent = 'FLACC orienta la evaluación del dolor observacional, pero no reemplaza la valoración del contexto clínico, la causa del malestar ni la reevaluación tras una intervención.';
      renderChecklist('incomplete');
      return;
    }

    document.getElementById('scoreText').textContent = total + (total === 1 ? ' punto total en FLACC.' : ' puntos totales en FLACC.');

    if(total === 0){
      document.getElementById('severityMain').textContent = 'Sin dolor';
      document.getElementById('severityText').textContent = 'Sin evidencia conductual de dolor.';
      document.getElementById('summaryNarrative').textContent = 'FLACC 0/10. Sin evidencia conductual de dolor en este momento.';
      document.getElementById('summarySeverity').textContent = 'Sin dolor';
      document.getElementById('summaryState').textContent = 'Completo';
      document.getElementById('summaryPlan').textContent = 'Observación y reevaluación';
      document.getElementById('managementBox').className = 'flacc-management-card flacc-management-ok mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo sugerido';
      document.getElementById('managementText').textContent = 'Sin evidencia conductual de dolor. Mantén observación clínica, confort y reevaluación periódica según el contexto.';
      document.getElementById('warningText').textContent = 'Un FLACC 0 no excluye del todo malestar o necesidad de reevaluación si el contexto clínico cambia.';
      renderChecklist('none');
    } else if(total <= 2){
      document.getElementById('severityMain').textContent = 'Dolor leve';
      document.getElementById('severityText').textContent = 'Conducta compatible con dolor leve.';
      document.getElementById('summaryNarrative').textContent = 'FLACC ' + total + '/10. Conducta compatible con dolor leve; prioriza medidas simples y reevaluación.';
      document.getElementById('summarySeverity').textContent = 'Leve';
      document.getElementById('summaryState').textContent = 'Completo';
      document.getElementById('summaryPlan').textContent = 'Medidas simples + reevaluación';
      document.getElementById('managementBox').className = 'flacc-management-card flacc-management-ok mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo sugerido';
      document.getElementById('managementText').textContent = 'Refuerza consuelo, contención y confort. Reevaluar después de medidas no farmacológicas o intervención leve.';
      document.getElementById('warningText').textContent = 'No interpretes todo llanto o movimiento como dolor puro sin revisar hambre, miedo, posición, temperatura u otros estímulos.';
      renderChecklist('mild');
    } else if(total <= 5){
      document.getElementById('severityMain').textContent = 'Dolor moderado';
      document.getElementById('severityText').textContent = 'Conducta compatible con dolor moderado.';
      document.getElementById('summaryNarrative').textContent = 'FLACC ' + total + '/10. Conducta compatible con dolor moderado; considerar analgesia y reevaluación precoz.';
      document.getElementById('summarySeverity').textContent = 'Moderado';
      document.getElementById('summaryState').textContent = 'Completo';
      document.getElementById('summaryPlan').textContent = 'Analgesia apropiada + reevaluación';
      document.getElementById('managementBox').className = 'flacc-management-card flacc-management-mid mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo sugerido';
      document.getElementById('managementText').textContent = 'Considera analgesia farmacológica apropiada según edad, procedimiento y contexto. Reevalúa FLACC tras el tratamiento.';
      document.getElementById('warningText').textContent = 'Un puntaje moderado debe interpretarse junto a la causa del malestar y a la respuesta tras la intervención.';
      renderChecklist('moderate');
    } else {
      const label = total <= 8 ? 'Dolor intenso' : 'Máximo dolor imaginable';
      document.getElementById('severityMain').textContent = label;
      document.getElementById('severityText').textContent = 'Conducta compatible con dolor importante.';
      document.getElementById('summaryNarrative').textContent = 'FLACC ' + total + '/10. Conducta compatible con dolor importante; requiere tratamiento oportuno y reevaluación estrecha.';
      document.getElementById('summarySeverity').textContent = label;
      document.getElementById('summaryState').textContent = 'Completo';
      document.getElementById('summaryPlan').textContent = 'Tratamiento oportuno + vigilancia';
      document.getElementById('managementBox').className = 'flacc-management-card flacc-management-high mb-3';
      document.getElementById('managementTitle').textContent = 'Manejo sugerido';
      document.getElementById('managementText').textContent = 'Trata el dolor de forma oportuna, busca la causa subyacente y monitoriza la respuesta. Considera enfoque multimodal cuando corresponda.';
      document.getElementById('warningText').textContent = 'Un FLACC alto obliga a tratar, pero también a confirmar la causa del malestar y documentar la respuesta tras la intervención.';
      renderChecklist('high');
    }
  }

  domains.forEach(function(domain){
    document.querySelectorAll('input[name="' + domain + '"]').forEach(function(input){
      input.addEventListener('change', updateFLACC);
    });
  });

  updateFLACC();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php include("footer.php"); ?>
