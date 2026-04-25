<?php
$titulo_pagina = "Cormack-Lehane";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";
$titulo_info = "Utilidad clínica";
$descripcion_info = "La clasificación de Cormack-Lehane describe la visión laringoscópica obtenida durante la laringoscopía directa. Sirve para documentar la dificultad real de exposición glótica, orientar la planificación de futuros abordajes y registrar qué maniobras o dispositivos fueron necesarios.";

$referencias = array(
  "Cormack RS, Lehane J. Difficult tracheal intubation in obstetrics. Anaesthesia. 1984.",
  "Yentis SM, Lee DJ. Evaluation of an improved scoring system for the grading of direct laryngoscopy. Anaesthesia. 1998.",
  "American Society of Anesthesiologists Task Force on Management of the Difficult Airway. Practice Guidelines for Management of the Difficult Airway. Anesthesiology. 2022.",
  "Frerk C, Mitchell VS, McNarry AF, et al. Difficult Airway Society 2015 guidelines for management of unanticipated difficult intubation in adults. Br J Anaesth. 2015.",
  "OpenAirway. Cormack-Lehane Grading Examples [Internet]. Disponible en: https://openairway.org/cormack-lehane-grading-examples/"
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

<style>
:root{
  --cl-grade-1:#e8f7f2;
  --cl-grade-2a:#fff9e8;
  --cl-grade-2b:#fff2c7;
  --cl-grade-3:#fff0e1;
  --cl-grade-4:#fdebec;
}

.cl-grade-grid{
  display:grid;
  grid-template-columns:repeat(5,minmax(0,1fr));
  gap:.65rem;
}

.cl-grade-option{min-width:0;}
.cl-grade-option .note-option{
  width:100%;
  min-height:68px;
  justify-content:center;
  align-items:center;
  text-align:center;
  padding:.55rem .5rem;
}

.cl-grade-option .note-option small{
  font-size:.7rem;
  line-height:1.1;
}

.cl-grade-1{background:var(--cl-grade-1);}
.cl-grade-2a{background:var(--cl-grade-2a);}
.cl-grade-2b{background:var(--cl-grade-2b);}
.cl-grade-3{background:var(--cl-grade-3);}
.cl-grade-4{background:var(--cl-grade-4);}

.cl-main-grid{
  display:grid;
  grid-template-columns:1fr;
  gap:1rem;
  align-items:start;
}

.cl-image-shell{
  background:#fff;
  border:1px solid var(--note-line);
  border-radius:1rem;
  overflow:hidden;
}

.cl-image-shell img{
  width:100%;
  display:block;
  object-fit:cover;
}

.cl-grade-panel{
  border-radius:1rem;
  padding:1rem;
  border:1px solid transparent;
}

.cl-grade-panel.grade-1{background:#e9f8ef;border-color:#b7e4c7;}
.cl-grade-panel.grade-2a{background:#fff8db;border-color:#f4d35e;}
.cl-grade-panel.grade-2b{background:#fff2c7;border-color:#e9c46a;}
.cl-grade-panel.grade-3{background:#fff0e1;border-color:#f7b267;}
.cl-grade-panel.grade-4{background:#fdebec;border-color:#f2a7b1;}

.cl-meta-stack{display:grid;gap:.8rem;}

.cl-grade-summary .note-summary-box-title{color:#344054;}
.cl-grade-summary .note-summary-box-text{margin-bottom:.5rem;}
.cl-grade-summary{border:none;box-shadow:none;}
.cl-grade-summary.grade-1{background:#e9f8ef;border-color:transparent;}
.cl-grade-summary.grade-2a{background:#fff8db;border-color:transparent;}
.cl-grade-summary.grade-2b{background:#fff2c7;border-color:transparent;}
.cl-grade-summary.grade-3{background:#fff0e1;border-color:transparent;}
.cl-grade-summary.grade-4{background:#fdebec;border-color:transparent;}

.cl-reference-grid{display:grid;gap:.75rem;}

.cl-reference-card{
  border:1px solid var(--note-line);
  border-radius:1rem;
  padding:.9rem 1rem;
  background:#fff;
}

.cl-reference-card b{display:block;margin-bottom:.15rem;}

@media (max-width:768px){
  .cl-grade-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
  .cl-main-grid{grid-template-columns:1fr;}
}
</style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · LARINGOSCOPÍA DIRECTA</div>
          <h2>Clasificación de Cormack-Lehane</h2>
          <div class="note-hero-subtitle">Descripción intraoperatoria de la visión glótica durante laringoscopía directa para documentar dificultad real, anticipar futuras estrategias y enseñar cuándo optimizar o cambiar de plan.</div>
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
              <b>Comentario:</b><br>
              <?php echo "A diferencia de Mallampati, Cormack-Lehane es una clasificación intraoperatoria: se determina durante la laringoscopía y no en la evaluación preoperatoria."; ?>
            <?php } ?>
            <hr>
            <div class="small-note mb-2"><strong>Utilidad docente:</strong> registra el mejor grado obtenido y si la visión cambió con maniobras externas, hoja distinta, bougie o videolaringoscopio.</div>
            <hr>
            <b>Referencias:</b>
            <ul class="mb-0">
              <?php foreach($referencias as $ref){ echo "<li>" . $ref . "</li>"; } ?>
            </ul>
          </div>
        </div>


        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Selecciona el grado</div>
            <div class="cl-grade-grid">
              <div class="cl-grade-option">
                <input class="note-check cl-trigger" type="radio" name="clgrade" id="cl1" value="1" checked>
                <label class="note-option cl-grade-1" for="cl1">
                  <span>Grado I</span>
                  <small>Glotis completa</small>
                </label>
              </div>
              <div class="cl-grade-option">
                <input class="note-check cl-trigger" type="radio" name="clgrade" id="cl2a" value="2a">
                <label class="note-option cl-grade-2a" for="cl2a">
                  <span>Grado IIa</span>
                  <small>Visión parcial</small>
                </label>
              </div>
              <div class="cl-grade-option">
                <input class="note-check cl-trigger" type="radio" name="clgrade" id="cl2b" value="2b">
                <label class="note-option cl-grade-2b" for="cl2b">
                  <span>Grado IIb</span>
                  <small>Aritenoides</small>
                </label>
              </div>
              <div class="cl-grade-option">
                <input class="note-check cl-trigger" type="radio" name="clgrade" id="cl3" value="3">
                <label class="note-option cl-grade-3" for="cl3">
                  <span>Grado III</span>
                  <small>Solo epiglotis</small>
                </label>
              </div>
              <div class="cl-grade-option">
                <input class="note-check cl-trigger" type="radio" name="clgrade" id="cl4" value="4">
                <label class="note-option cl-grade-4" for="cl4">
                  <span>Grado IV</span>
                  <small>Ni glotis ni epiglotis</small>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Resultado principal</div>
            <div id="gradePanel" class="cl-grade-panel grade-1">
              <div class="cl-main-grid">
                <div>
                  <div class="cl-image-shell mb-3">
                    <img id="clImage" src="img_apuntes/1.jpg" alt="Cormack-Lehane grado seleccionado">
                  </div>

                  <div id="gradeSummaryBox" class="note-summary-box cl-grade-summary grade-1">
                    <div class="note-summary-box-title">Resumen</div>
                    <div id="summaryNarrative" class="note-summary-box-text">Cormack-Lehane I: glotis completa visible, compatible con exposición glótica favorable.</div>
                    <div class="note-summary-grid-2">
                      <div class="note-summary-item">
                        <div class="note-summary-k">Grado seleccionado</div>
                        <div id="summaryGrade" class="note-summary-v">Grado I</div>
                      </div>
                      <div class="note-summary-item">
                        <div class="note-summary-k">Visión</div>
                        <div id="summaryVision" class="note-summary-v">Glotis completa visible</div>
                      </div>
                      <div class="note-summary-item">
                        <div class="note-summary-k">Lectura clínica</div>
                        <div id="summaryMeaning" class="note-summary-v">Laringoscopía favorable</div>
                      </div>
                      <div class="note-summary-item">
                        <div class="note-summary-k">Conducta inmediata</div>
                        <div id="summaryAction" class="note-summary-v">Documentar el grado real y el contexto</div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="note-interpretation mb-3">
          <div class="note-interpretation-label">Significado clínico</div>
          <div id="interpMain" class="note-interpretation-main">Un Cormack-Lehane alto describe dificultad real de exposición glótica, no solo una sospecha preoperatoria.</div>
          <div id="interpSoft" class="note-interpretation-soft">Lo útil no es solo asignar el número: es registrar si la visión mejoró con BURP, reposicionamiento, bougie o cambio de dispositivo.</div>
        </div>

        <div class="note-warning mb-3">
          <div class="note-card-title">Advertencia visible</div>
          <div id="warningText">No confundas Cormack-Lehane con Mallampati. Mallampati es preoperatorio; Cormack-Lehane es una clasificación intraoperatoria durante laringoscopía.</div>
        </div>

        <div class="section-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Resumen rápido por grados</div>
            <div class="cl-reference-grid">
              <div class="cl-reference-card" style="background:#e9f8ef;border-color:#b7e4c7;">
                <b>Grado I</b>
                Se visualiza la glotis completa.
              </div>
              <div class="cl-reference-card" style="background:#fff8db;border-color:#f4d35e;">
                <b>Grado IIa</b>
                Se visualiza parte de la glotis, habitualmente su porción posterior.
              </div>
              <div class="cl-reference-card" style="background:#fff2c7;border-color:#e9c46a;">
                <b>Grado IIb</b>
                Se observan solo aritenoides o una mínima porción posterior de la glotis.
              </div>
              <div class="cl-reference-card" style="background:#fff0e1;border-color:#f7b267;">
                <b>Grado III</b>
                No se ve la glotis; solo se observa la epiglotis.
              </div>
              <div class="cl-reference-card" style="background:#fdebec;border-color:#f2a7b1;">
                <b>Grado IV</b>
                No se observa ni glotis ni epiglotis.
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap mt-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Describe lo que ves, pero documenta también cómo lograste verlo</div>
          <div class="note-tips">
            <strong>Qué hacer:</strong> documenta el mejor grado obtenido y si mejoró con maniobras externas, reposicionamiento, hoja distinta, bougie o videolaringoscopio.
          </div>
          <div class="note-tips">
            <strong>Qué evitar:</strong> asumir que un grado alto significa repetir intentos traumáticos sin cambiar técnica ni estrategia.
          </div>
          <div class="note-tips">
            <strong>Error frecuente:</strong> confundir Mallampati con Cormack-Lehane. El primero predice; el segundo describe la visión real durante la laringoscopía.
          </div>
          <div class="note-tips mb-0">
            <strong>Perla para residentes:</strong> un grado III no significa fracaso automático. Antes de insistir, optimiza posición, usa BURP, cambia hoja o considera un introductor/dispositivo alternativo según contexto.
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  if (CNS) {
    CNS.bindSelectionSync('.cl-trigger');
  }

  const gradeData = {
    '1': {
      image: 'img_apuntes/1.jpg',
      panelClass: 'grade-1',
      grade: 'Grado I',
      vision: 'Glotis completa visible',
      meaning: 'Laringoscopía favorable',
      soft: 'Exposición glótica amplia, habitualmente compatible con intubación directa sencilla.',
      pearl: 'Documenta el grado real obtenido y qué maniobras o dispositivos fueron necesarios.',
      action: 'Documentar el grado real y el contexto',
      interpMain: 'Un Cormack-Lehane I describe exposición glótica amplia y suele corresponder a una intubación directa favorable.',
      interpSoft: 'Aun así, registra si fue con laringoscopía directa, videolaringoscopio o maniobras auxiliares.',
      warning: 'Aunque el grado sea bajo, la documentación sigue siendo importante: dispositivo, maniobras externas y dificultad real aportan más que el número aislado.',
      summary: 'Cormack-Lehane I: glotis completa visible, compatible con exposición glótica favorable.'
    },
    '2a': {
      image: 'img_apuntes/2a.jpg',
      panelClass: 'grade-2a',
      grade: 'Grado IIa',
      vision: 'Porción posterior de la glotis visible',
      meaning: 'Exposición algo limitada',
      soft: 'Suele permitir intubación, aunque puede requerir mejor posicionamiento o maniobras externas.',
      pearl: 'Optimiza eje, posición y presión laríngea externa antes de escalar innecesariamente.',
      action: 'Optimizar posición y maniobras externas',
      interpMain: 'Un grado IIa sigue siendo compatible con intubación, pero ya sugiere que la exposición no es completamente amplia.',
      interpSoft: 'La respuesta correcta suele ser optimizar técnica, no precipitar cambios mayores si la oxigenación y la situación clínica son favorables.',
      warning: 'No minimices la dificultad solo porque aún ves parte de la glotis; documenta si hubo necesidad de BURP, reposicionamiento o cambios de hoja.',
      summary: 'Cormack-Lehane IIa: parte de la glotis visible, generalmente la porción posterior, con exposición algo limitada.'
    },
    '2b': {
      image: 'img_apuntes/2b.jpg',
      panelClass: 'grade-2b',
      grade: 'Grado IIb',
      vision: 'Solo aritenoides o mínima visión posterior',
      meaning: 'Mayor dificultad técnica',
      soft: 'La exposición glótica es pobre y aumenta la probabilidad de requerir bougie u otra ayuda.',
      pearl: 'Si la visión es mínima, un introductor puede ser más útil que insistir con el tubo directamente.',
      action: 'Considerar introductor o ayuda adicional',
      interpMain: 'Un grado IIb ya marca una exposición glótica pobre y eleva la probabilidad de dificultad técnica real.',
      interpSoft: 'La diferencia entre IIa y IIb importa: en IIb el umbral para usar bougie, maniobras externas eficaces o cambiar estrategia debe ser más bajo.',
      warning: 'No confundas una visión mínima con una visión suficiente. Repetir intentos con tubo directo puede aumentar trauma y empeorar la exposición.',
      summary: 'Cormack-Lehane IIb: solo aritenoides o mínima visión posterior; aumenta la probabilidad de necesitar bougie u otra ayuda.'
    },
    '3': {
      image: 'img_apuntes/3.jpg',
      panelClass: 'grade-3',
      grade: 'Grado III',
      vision: 'Solo epiglotis visible',
      meaning: 'Exposición glótica difícil',
      soft: 'No se visualiza la glotis. Requiere optimización seria de técnica o cambio de estrategia.',
      pearl: 'Antes de repetir, prueba BURP, reposicionamiento, hoja diferente, bougie o videolaringoscopio según contexto.',
      action: 'Optimizar fuerte o cambiar de estrategia',
      interpMain: 'Un grado III describe dificultad real de exposición glótica y debe bajar tu umbral para optimizar o cambiar de plan.',
      interpSoft: 'No implica fracaso automático, pero sí que insistir con la misma técnica sin cambios suele ser mala idea.',
      warning: 'Un grado III no debe manejarse como “seguir intentando igual”. Repetir intentos traumáticos sin cambio técnico aumenta edema, sangrado e hipoxemia.',
      summary: 'Cormack-Lehane III: no se visualiza la glotis y solo se observa la epiglotis; requiere optimización seria o cambio de estrategia.'
    },
    '4': {
      image: 'img_apuntes/4.jpg',
      panelClass: 'grade-4',
      grade: 'Grado IV',
      vision: 'No se ve glotis ni epiglotis',
      meaning: 'Exposición extremadamente difícil',
      soft: 'Corresponde a una laringoscopía crítica. Insistir sin estrategia aumenta trauma, edema e hipoxemia.',
      pearl: 'Debes bajar rápido el umbral para plan alternativo y evitar múltiples intentos fallidos.',
      action: 'Cambiar precozmente a estrategia alternativa',
      interpMain: 'Un grado IV representa una exposición crítica y obliga a pensar precozmente en rescate o cambio de estrategia.',
      interpSoft: 'Lo peligroso aquí no es solo el grado, sino insistir con intentos repetidos sin beneficio esperable.',
      warning: 'Grado IV cambia rápido el umbral de rescate. No se debe normalizar como “intento un poco más”. La prioridad es seguridad, oxigenación y estrategia alternativa.',
      summary: 'Cormack-Lehane IV: no se observa ni glotis ni epiglotis; corresponde a una exposición extremadamente difícil.'
    }
  };

  const imageEl = document.getElementById('clImage');
  const panelEl = document.getElementById('gradePanel');
  const interpMain = document.getElementById('interpMain');
  const interpSoft = document.getElementById('interpSoft');
  const warningText = document.getElementById('warningText');
  const gradeSummaryBox = document.getElementById('gradeSummaryBox');
  const summaryNarrative = document.getElementById('summaryNarrative');
  const summaryGrade = document.getElementById('summaryGrade');
  const summaryVision = document.getElementById('summaryVision');
  const summaryMeaning = document.getElementById('summaryMeaning');
  const summaryAction = document.getElementById('summaryAction');

  function renderGrade(grade){
    const data = gradeData[grade] || gradeData['1'];
    imageEl.src = data.image;
    imageEl.alt = 'Cormack-Lehane ' + data.grade;
    panelEl.className = 'cl-grade-panel ' + data.panelClass;
    gradeSummaryBox.className = 'note-summary-box cl-grade-summary ' + data.panelClass;
    CNS.safeSetText(interpMain, data.interpMain);
    CNS.safeSetText(interpSoft, data.interpSoft);
    CNS.safeSetText(warningText, data.warning);
    CNS.safeSetText(summaryNarrative, data.summary);
    CNS.safeSetText(summaryGrade, data.grade);
    CNS.safeSetText(summaryVision, data.vision);
    CNS.safeSetText(summaryMeaning, data.meaning);
    CNS.safeSetText(summaryAction, data.action);
  }

  document.querySelectorAll('.cl-trigger').forEach(function(input){
    input.addEventListener('change', function(){
      if (input.checked) renderGrade(input.value);
    });
  });

  renderGrade('1');
})();
</script>

<?php require("../footer.php"); ?>
