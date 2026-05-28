<?php
$titulo_pagina = "Premedicación Pediátrica";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Nota interactiva basada en el Protocolo de Premedicación Preoperatoria en Pacientes Pediátricos del Hospital Base Valdivia. Integra indicaciones, exclusiones, cálculo de dosis, monitorización, UMSS, mYPAS-E simplificada y manejo inicial de complicaciones. <div> La dexmedetomidina intranasal se considera primera línea para premedicación pediátrica por su perfil sedante, ansiolítico y analgésico, con baja depresión respiratoria. La indicación farmacológica debe ser médica y requiere monitorización proporcional al riesgo.</div>";
$formula = "mYPAS = ((A / 4) + (B / 6) + (C / 4) + (D / 4) + (E / 4)) * 20";
$referencias = array(
  "Protocolo Premedicación Preoperatoria en Pacientes Pediátricos Hospital Base Valdivia. Servicio de Anestesiología HBV.",
  "Anexo 1: Tabla de fármacos, dosificación y vía. Dexmedetomidina, midazolam y ketamina.",
  "Anexo 2: Escala de Sedación de la Universidad de Michigan (UMSS).",
  "Anexo 5: Hoja de Evaluación Clínica mYPAS-E para ansiedad preoperatoria."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=2"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .analg-choice-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
          .analg-choice-grid.analg-grid-3{grid-template-columns:repeat(3,minmax(0,1fr));}
          .analg-choice-grid.analg-grid-4{grid-template-columns:repeat(4,minmax(0,1fr));}
          .analg-choice-grid.analg-grid-5{grid-template-columns:repeat(5,minmax(0,1fr));}

          .analg-input{position:absolute;opacity:0;pointer-events:none;}
          .analg-option{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;min-height:68px;border:2px solid var(--note-line);background:#fff;border-radius:1rem;padding:.5rem .65rem;cursor:pointer;transition:.15s ease;box-shadow:0 3px 10px rgba(15,23,42,.04);gap:.12rem;color:var(--note-text);}
          .analg-option i{color:#3559b7;font-size:.95rem;margin-bottom:.05rem;}
          .analg-input:checked + .analg-option{box-shadow:0 0 0 3px rgba(47,128,237,.14),0 8px 18px rgba(15,23,42,.10);border:4px solid var(--note-selected);transform:translateY(-1px);}
          .analg-option-title{font-size:.92rem;font-weight:800;line-height:1.12;color:var(--note-text);margin:0;}
          .analg-option-sub{font-size:.75rem;line-height:1.18;color:var(--note-muted);margin:0;font-weight:650;}
          .analg-drug-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:.75rem;}
          .analg-drug-grid > label{display:flex;}
          .analg-drug-grid .drug-card{height:100%;width:100%;align-items:center;justify-content:flex-start;text-align:left;}
          .analg-drug-chip{display:inline-block;padding:.22rem .48rem;border-radius:.6rem;font-weight:800;border:1px solid rgba(31,42,55,.12);line-height:1.1;color:#111827;}
          .analg-result-low{background:#edf8f1!important;border-color:#b7ddc3!important;}
          .analg-result-mid{background:#fff9e8!important;border-color:#ead38a!important;}
          .analg-result-high{background:#fff1f1!important;border-color:#efc0bd!important;}
          .analg-plan-line{padding:.75rem .85rem;border-radius:.9rem;background:#fff;border:1px solid var(--note-line-strong);margin-bottom:.6rem;}
          .analg-plan-line:last-child{margin-bottom:0;}
          .prem-table{width:100%;border-collapse:separate;border-spacing:0 .45rem;}
          .prem-table td{padding:.55rem .65rem;background:#fff;border-top:1px solid var(--note-line);border-bottom:1px solid var(--note-line);font-size:.86rem;vertical-align:top;}
          .prem-table td:first-child{border-left:1px solid var(--note-line);border-radius:.75rem 0 0 .75rem;font-weight:800;white-space:nowrap;}
          .prem-table td:last-child{border-right:1px solid var(--note-line);border-radius:0 .75rem .75rem 0;}
          @media (max-width:768px){.analg-choice-grid.analg-grid-3,.analg-choice-grid.analg-grid-4,.analg-choice-grid.analg-grid-5,.analg-drug-grid{grid-template-columns:repeat(2,minmax(0,1fr));}}
          @media (max-width:420px){.analg-choice-grid,.analg-choice-grid.analg-grid-3,.analg-choice-grid.analg-grid-4,.analg-choice-grid.analg-grid-5,.analg-drug-grid{grid-template-columns:1fr;}.prem-table td{display:block;border-radius:0!important;border-left:1px solid var(--note-line);border-right:1px solid var(--note-line);}.prem-table td:first-child{border-radius:.75rem .75rem 0 0!important;}.prem-table td:last-child{border-radius:0 0 .75rem .75rem!important;border-top:0;}}

          /* UMSS Grid Styles - Horizontal layout */
          .umss-info-grid{display:grid;grid-template-columns:1fr;gap:.6rem;}
          .umss-cell{display:flex;flex-direction:row;align-items:flex-start;justify-content:flex-start;text-align:left;padding:.9rem 1rem;border-radius:1rem;border:2px solid var(--note-line);background:#fff;transition:.15s ease;gap:.9rem;}
          .umss-cell-num{font-size:1.35rem;font-weight:800;line-height:1;color:var(--note-text);min-width:2rem;text-align:center;}
          .umss-cell-lbl{font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.02em;min-width:5rem;margin-top:.15rem;}
          .umss-cell-desc{font-size:.78rem;line-height:1.4;color:var(--note-muted);flex:1;margin-top:.05rem;}
          .umss-info-0{background:#f8fafc;border-color:#cbd5e1;}
          .umss-info-0 .umss-cell-lbl{color:#64748b;}
          .umss-info-1{background:#ecfdf5;border-color:#6ee7b7;}
          .umss-info-1 .umss-cell-lbl{color:#059669;}
          .umss-info-3{background:#fff7ed;border-color:#fdba74;}
          .umss-info-3 .umss-cell-lbl{color:#ea580c;}
          .umss-info-4{background:#fef2f2;border-color:#fca5a5;}
          .umss-info-4 .umss-cell-lbl{color:#dc2626;}

          /* Dark mode overrides */
          body.theme-dark .analg-option,
          body.ui-nocturno .analg-option{
            background:var(--app-card);
            border-color:var(--app-border);
            color:var(--app-text);
          }
          body.theme-dark .analg-option i,
          body.ui-nocturno .analg-option i{
            color:#8bb3ff;
          }
          body.theme-dark .analg-drug-chip,
          body.ui-nocturno .analg-drug-chip{
            background:var(--app-card);
            border-color:var(--app-border);
            color:var(--app-text);
          }
          body.theme-dark .analg-plan-line,
          body.ui-nocturno .analg-plan-line{
            background:var(--app-card);
            border-color:var(--app-border);
          }
          body.theme-dark .prem-table td,
          body.ui-nocturno .prem-table td{
            background:var(--app-card);
            border-color:var(--app-border);
          }
          body.theme-dark .analg-result-low,
          body.ui-nocturno .analg-result-low{
            background:rgba(31,157,85,.15)!important;
            border-color:rgba(31,157,85,.3)!important;
          }
          body.theme-dark .analg-result-mid,
          body.ui-nocturno .analg-result-mid{
            background:rgba(250,204,21,.15)!important;
            border-color:rgba(250,204,21,.3)!important;
          }
          body.theme-dark .analg-result-high,
          body.ui-nocturno .analg-result-high{
            background:rgba(217,45,32,.15)!important;
            border-color:rgba(217,45,32,.3)!important;
          }

          /* UMSS Dark mode */
          body.theme-dark .umss-cell,
          body.ui-nocturno .umss-cell{background:var(--app-card);border-color:var(--app-border);}
          body.theme-dark .umss-info-0,
          body.ui-nocturno .umss-info-0{background:rgba(100,116,139,.15);border-color:rgba(148,163,184,.35);}
          body.theme-dark .umss-info-0 .umss-cell-lbl,
          body.ui-nocturno .umss-info-0 .umss-cell-lbl{color:#94a3b8;}
          body.theme-dark .umss-info-1,
          body.ui-nocturno .umss-info-1{background:rgba(16,185,129,.15);border-color:rgba(16,185,129,.35);}
          body.theme-dark .umss-info-1 .umss-cell-lbl,
          body.ui-nocturno .umss-info-1 .umss-cell-lbl{color:#6ee7b7;}
          body.theme-dark .umss-info-3,
          body.ui-nocturno .umss-info-3{background:rgba(249,115,22,.15);border-color:rgba(251,146,60,.35);}
          body.theme-dark .umss-info-3 .umss-cell-lbl,
          body.ui-nocturno .umss-info-3 .umss-cell-lbl{color:#fdba74;}
          body.theme-dark .umss-info-4,
          body.ui-nocturno .umss-info-4{background:rgba(220,38,38,.15);border-color:rgba(248,113,113,.35);}
          body.theme-dark .umss-info-4 .umss-cell-lbl,
          body.ui-nocturno .umss-info-4 .umss-cell-lbl{color:#fca5a5;}
          body.theme-dark .umss-cell-desc,
          body.ui-nocturno .umss-cell-desc{color:var(--app-muted);border-color:var(--app-border);}
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>&umss=1">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · PREMEDICACIÓN PEDIÁTRICA</div>
          <h2>Premedicación Preoperatoria Pediátrica</h2>
          <div class="note-hero-subtitle">Dexmedetomidina intranasal como primera línea, con cálculo de dosis, criterios de seguridad, UMSS y tipos de apoyo</div>
        </div>

        <div class="info-box mb-3">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
            <?php if(!empty($formula)){ ?><hr><b>Fórmula:</b><br><?php echo $formula; ?><?php } ?>
            <hr>
            <b>Referencias:</b>
            <ul class="mb-0 mt-2">
              <?php foreach($referencias as $ref){ ?><li class="mb-2"><?php echo $ref; ?></li><?php } ?>
            </ul>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Datos de entrada</div>
            <div class="note-input-group mb-3">
              <label class="note-label">Peso</label>
              <div class="note-input-inline">
                <input id="pesoPaciente" type="text" inputmode="decimal" class="note-input">
                <div class="note-input-unit">kg</div>
              </div>
            </div>

            <div class="note-section-label">Criterios de exclusión / alerta</div>
            <div class="analg-choice-grid analg-grid-4">
              <label><input class="analg-input note-trigger exclusion" type="checkbox" value="Vía aérea difícil o riesgo de aspiración"><div class="analg-option"><i class="fa-solid fa-lungs"></i><div class="analg-option-title">VA difícil</div><div class="analg-option-sub">o aspiración</div></div></label>
              <label><input class="analg-input note-trigger exclusion" type="checkbox" value="Apnea central u obstructiva del sueño"><div class="analg-option"><i class="fa-solid fa-bed-pulse"></i><div class="analg-option-title">Apnea/OSA</div><div class="analg-option-sub">excluir</div></div></label>
              <label><input class="analg-input note-trigger exclusion" type="checkbox" value="PIC elevada, GCS alterado o sepsis"><div class="analg-option"><i class="fa-solid fa-brain"></i><div class="analg-option-title">PIC/GCS</div><div class="analg-option-sub">o sepsis</div></div></label>
              <label><input class="analg-input note-trigger exclusion" type="checkbox" value="Bloqueo AV, bradicardia significativa o hipotensión no corregida"><div class="analg-option"><i class="fa-solid fa-heart-pulse"></i><div class="analg-option-title">Bradi/HipoTA</div><div class="analg-option-sub">o BAV</div></div></label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Fármaco y vía</div>
            <div id="drugButtons" class="analg-drug-grid mb-3"></div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">mYPAS-E estándar</div>
            

            <!-- Actividad -->
            <div class="flacc-domain-card">
              <div class="flacc-domain-head">
                <div class="flacc-domain-title">Actividad</div>
              </div>
              <div class="flacc-score-grid">
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasActividad" value="1" checked><div class="flacc-option mypas-opt-1"><p class="flacc-option-text">Juega tranquilo, normal para la edad</p><div class="flacc-option-points">1</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasActividad" value="2"><div class="flacc-option mypas-opt-2"><p class="flacc-option-text">Inquietud leve, movimientos ocasionales</p><div class="flacc-option-points">2</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasActividad" value="3"><div class="flacc-option mypas-opt-3"><p class="flacc-option-text">Inquieto, movimientos frecuentes</p><div class="flacc-option-points">3</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasActividad" value="4"><div class="flacc-option mypas-opt-4"><p class="flacc-option-text">Muy agitado, no permanece quieto</p><div class="flacc-option-points">4</div></div></label>
              </div>
            </div>

            <!-- Vocalización -->
            <div class="flacc-domain-card mypas-domain-vocal">
              <div class="flacc-domain-head">
                <div class="flacc-domain-title">Vocalización</div>
              </div>
              <div class="flacc-score-grid">
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasVocal" value="1" checked><div class="flacc-option mypas-opt-1"><p class="flacc-option-text">Conversación normal o silencio tranquilo</p><div class="flacc-option-points">1</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasVocal" value="2"><div class="flacc-option mypas-opt-2"><p class="flacc-option-text">Preguntas ocasionales o leve preocupación</p><div class="flacc-option-points">2</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasVocal" value="3"><div class="flacc-option mypas-opt-3"><p class="flacc-option-text">Quejas frecuentes o verbaliza miedo</p><div class="flacc-option-points">3</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasVocal" value="4"><div class="flacc-option mypas-opt-4"><p class="flacc-option-text">Llanto o vocalización ansiosa</p><div class="flacc-option-points">4</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasVocal" value="5"><div class="flacc-option mypas-opt-5"><p class="flacc-option-text">Gritos o llanto inconsolable</p><div class="flacc-option-points">5</div></div></label>
              </div>
            </div>

            <!-- Expresión -->
            <div class="flacc-domain-card">
              <div class="flacc-domain-head">
                <div class="flacc-domain-title">Expresión emocional</div>
              </div>
              <div class="flacc-score-grid">
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasExpresion" value="1" checked><div class="flacc-option mypas-opt-1"><p class="flacc-option-text">Relajado / expresión neutra</p><div class="flacc-option-points">1</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasExpresion" value="2"><div class="flacc-option mypas-opt-2"><p class="flacc-option-text">Leve preocupación</p><div class="flacc-option-points">2</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasExpresion" value="3"><div class="flacc-option mypas-opt-3"><p class="flacc-option-text">Ansioso / preocupado</p><div class="flacc-option-points">3</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasExpresion" value="4"><div class="flacc-option mypas-opt-4"><p class="flacc-option-text">Muy ansioso / angustiado</p><div class="flacc-option-points">4</div></div></label>
              </div>
            </div>

            <!-- Alerta -->
            <div class="flacc-domain-card">
              <div class="flacc-domain-head">
                <div class="flacc-domain-title">Estado de alerta</div>
              </div>
              <div class="flacc-score-grid">
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasAlerta" value="1" checked><div class="flacc-option mypas-opt-1"><p class="flacc-option-text">Calmado, atento al entorno</p><div class="flacc-option-points">1</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasAlerta" value="2"><div class="flacc-option mypas-opt-2"><p class="flacc-option-text">Algo vigilante</p><div class="flacc-option-points">2</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasAlerta" value="3"><div class="flacc-option mypas-opt-3"><p class="flacc-option-text">Muy vigilante / tenso</p><div class="flacc-option-points">3</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasAlerta" value="4"><div class="flacc-option mypas-opt-4"><p class="flacc-option-text">Hipervigilante / claramente asustado</p><div class="flacc-option-points">4</div></div></label>
              </div>
            </div>

            <!-- Relación padres -->
            <div class="flacc-domain-card mb-0">
              <div class="flacc-domain-head">
                <div class="flacc-domain-title">Relación con padres</div>
              </div>
              <div class="flacc-score-grid">
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasPadres" value="1" checked><div class="flacc-option mypas-opt-1"><p class="flacc-option-text">Independiente</p><div class="flacc-option-points">1</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasPadres" value="2"><div class="flacc-option mypas-opt-2"><p class="flacc-option-text">Contacto ocasional</p><div class="flacc-option-points">2</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasPadres" value="3"><div class="flacc-option mypas-opt-3"><p class="flacc-option-text">Busca frecuentemente a los padres</p><div class="flacc-option-points">3</div></div></label>
                <label><input class="flacc-option-input note-trigger" type="radio" name="mypasPadres" value="4"><div class="flacc-option mypas-opt-4"><p class="flacc-option-text">Se aferra o depende completamente</p><div class="flacc-option-points">4</div></div></label>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa peso y revisa criterios para obtener dosis y conducta sugerida.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card"><div class="note-result-card-label">Paciente</div><div id="summaryPatient" class="note-result-card-value">-</div></div>
              <div class="note-result-card"><div class="note-result-card-label">Fármaco</div><div id="summaryDrug" class="note-result-card-value">Dexmedetomidina IN</div></div>

              <div class="note-result-card">
                <div class="note-result-card-label">Dosis</div>
                <div id="doseValue" class="note-result-card-value">-</div>
               <div id="doseNote" class="note-result-card-note">Según peso, vía y fármaco seleccionado.</div>
              </div>

              <div class="note-result-card"><div class="note-result-card-label">mYPAS-E estándar</div><div id="summaryMypas" class="note-result-card-value">23,3</div></div>
            </div>
          </div>
        </div>

        <div class="note-result-grid mb-3">
          <div id="timeCard" class="note-result-card">
            <div class="note-result-card-label">Inicio / duración</div>
            <div id="timeValue" class="note-result-card-value">20–45 min</div>
            <div id="timeNote" class="note-result-card-note">Premedicar oportunamente; la mayoría requiere al menos 30 min.</div>
          </div>
        </div>

        <div class="note-result-grid mb-3">
          <div id="safetyCard" class="note-result-card">
            <div class="note-result-card-label">Seguridad principal</div>
            <div id="safetyShort" class="note-result-card-value">Bradicardia / hipotensión</div>
            <div id="safetyNote" class="note-result-card-note">Vigilar sedación, FC, SpO₂ y signos de obstrucción.</div>
          </div>
        </div>

        <div class="note-result-grid mb-3">
          <div id="monitorCard" class="note-result-card">
            <div class="note-result-card-label">Monitorización</div>
            <div id="monitorValue" class="note-result-card-value">Cada 15 min</div>
            <div id="monitorNote" class="note-result-card-note">ECG, saturómetro, PA si corresponde y UMSS.</div>
          </div>
        </div>






        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación clínica</div>
          <div class="note-result-secondary mb-2">Contexto clínico: candidato regular ASA I–II, niño que coopera.</div>
          <div id="riskText" class="note-interpretation-main">Evaluación pendiente</div>
          <div id="riskSoft" class="note-interpretation-soft">Completa datos para definir si procede premedicación y qué vigilancia requiere.</div>
          <div class="mt-3 text-start">
            <div class="analg-plan-line"><strong>Indicación:</strong> <span id="indicationLine">-</span></div>
            <div class="analg-plan-line"><strong>Administración:</strong> <span id="administrationLine">-</span></div>
            <div class="analg-plan-line"><strong>Advertencia:</strong> <span id="warningLine">-</span></div>
          </div>
        </div>

        <div id="validityWarning" class="note-danger note-hidden mb-3"><strong>Dato a verificar:</strong><div id="validityWarningText" class="mt-2"></div></div>

        <div class="note-warning mb-3"><strong>Implementación:</strong><div class="mt-2">Premedicar en un lugar con camilla con barandas, saturómetro, ECG, oxígeno, succión y carro de paro disponible. El niño debe permanecer acostado, con barandas y acompañado por familiar/tutor.</div></div>

        <div class="note-success mb-3"><strong>Objetivo práctico:</strong><div class="mt-2">Lograr UMSS 1–2: niño tranquilo, cooperador y seguro, sin comprometer vía aérea ni ventilación.</div></div>


        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">
              <span>Objetivo de sedación UMSS</span>
            </div>

              <div class="note-result-secondary mb-2">Escala UMSS para valoración del nivel de sedación en pediatría.</div>
              <div class="umss-info-grid mb-2">
                <div class="umss-cell umss-info-0">
                  <div class="umss-cell-num">0</div>
                  <div class="umss-cell-lbl">Alerta</div>
                  <div class="umss-cell-desc">Niño activo, despierto, responde espontáneamente. Sedación insuficiente para procedimientos.</div>
                </div>
                <div class="umss-cell umss-info-1">
                  <div class="umss-cell-num">1</div>
                  <div class="umss-cell-lbl">Ideal</div>
                  <div class="umss-cell-desc">Tranquilo, algo adormecido, responde fácilmente a estímulos verbales. Rango objetivo.</div>
                </div>
                <div class="umss-cell umss-info-1">
                  <div class="umss-cell-num">2</div>
                  <div class="umss-cell-lbl">Ideal</div>
                  <div class="umss-cell-desc">Dormido pero responde a estímulos suaves (voz o tacto ligero). Rango objetivo.</div>
                </div>
                <div class="umss-cell umss-info-3">
                  <div class="umss-cell-num">3</div>
                  <div class="umss-cell-lbl">Excesiva</div>
                  <div class="umss-cell-desc">Responde solo a estímulos más intensos o repetidos. Vigilancia estrecha requerida.</div>
                </div>
                <div class="umss-cell umss-info-4">
                  <div class="umss-cell-num">4</div>
                  <div class="umss-cell-lbl">Alarma</div>
                  <div class="umss-cell-desc">Sin respuesta a estímulos. Sedación muy profunda. Tratar como alarma clínica.</div>
                </div>
              </div>
              <div class="note-result-secondary">Rango útil: UMSS 1–2 (tranquilo/cooperador). UMSS ≥3 requiere vigilancia estrecha.</div>
            </div>
          </div>



        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Complicaciones y manejo inicial</div>
            <div class="note-warning-list">
              <div class="note-warning-item"><div class="note-warning-icon mid"><i class="fa-solid fa-heart-pulse"></i></div><div class="note-warning-copy"><div class="note-warning-title">Bradicardia sintomática</div><p class="note-warning-note">FC &lt;60: llamar a médico responsable. Considerar atropina 0,02–0,04 mg/kg IM según protocolo.</p></div></div>
              <div class="note-warning-item"><div class="note-warning-icon mid"><i class="fa-solid fa-droplet"></i></div><div class="note-warning-copy"><div class="note-warning-title">Hipotensión</div><p class="note-warning-note">PAM &lt;60: elevar EEII, considerar efedrina 0,1 mg/kg IM y cristaloides 10 mL/kg si hay vía venosa.</p></div></div>
              <div class="note-warning-item"><div class="note-warning-icon high"><i class="fa-solid fa-lungs"></i></div><div class="note-warning-copy"><div class="note-warning-title">Depresión respiratoria / obstrucción</div><p class="note-warning-note">Oxígeno y soporte ventilatorio según gravedad. Flumazenil si se atribuye a benzodiacepina.</p></div></div>
            </div>
          </div>
        </div>


        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Tips para residentes</div>
          <div class="note-teaching-main">La premedicación no es “dar algo para que se duerma”: es una intervención con indicación, monitorización y plan de rescate.</div>
          <div class="note-tips"><strong>Primera línea:</strong> dexmedetomidina intranasal 1–2 mcg/kg, especialmente si quieres ansiolisis/sedación cooperativa sin depresión respiratoria significativa.</div>
          <div class="note-tips"><strong>Timing:</strong> administra con anticipación. Intranasal suele requerir 20–45 min; oral puede requerir 30–60 min.</div>
          <div class="note-tips"><strong>Antes de indicar:</strong> descarta vía aérea difícil, aspiración, OSA/apnea central, PIC/GCS alterado, sepsis, BAV, bradicardia o hipotensión no corregida.</div>
          <div class="note-tips"><strong>UMSS:</strong> 1–2 es el rango útil. UMSS ≥3 no es éxito: es exceso de sedación y exige vigilancia estrecha.</div>
          <div class="note-tips"><strong>Midazolam:</strong> útil, pero considera depresión respiratoria, reacciones paradójicas y mayor delirium emergente frente a dexmedetomidina.</div>
          <div class="note-tips mb-0"><strong>Ketamina:</strong> reserva para escenarios seleccionados; vigila hipersalivación, náuseas/vómitos, taquicardia, hipertensión y reacciones psicomiméticas.</div>
        </div>

        <div class="note-footer">Herramienta docente y de apoyo clínico. La premedicación farmacológica debe ser indicada por médico/a. Verificar protocolo institucional, concentración disponible, exclusiones, monitorización y destino perioperatorio antes de administrar.</div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

  const DRUGS = {
    dex_in:{nombre:'Dexmedetomidina IN', clase:'inductor', via:'Intranasal', doseUnit:'mcg/kg', min:1, max:2, absMax:null, inicio:'20–45 min', duracion:'60–120 min', safety:'Bradicardia, hipotensión y sedación prolongada dependiente de dosis. Bajo riesgo de depresión respiratoria significativa.', short:'Bradi / hipoTA', first:true},
    dex_oral:{nombre:'Dexmedetomidina VO', clase:'inductor', via:'Oral', doseUnit:'mcg/kg', min:2, max:4, absMax:null, inicio:'30–60 min', duracion:'90–150 min', safety:'Inicio más lento y duración mayor. Usar con líquido claro o SG5% según protocolo.', short:'Inicio lento'},
    mida_oral:{nombre:'Midazolam VO', clase:'opioid', via:'Oral', doseUnit:'mg/kg', min:0.25, max:0.5, absMax:20, inicio:'15–30 min', duracion:'60–90 min', safety:'Riesgo de depresión respiratoria, reacción paradójica y mayor delirium emergente comparado con dexmedetomidina.', short:'Depresión respiratoria'},
    mida_in:{nombre:'Midazolam IN', clase:'opioid', via:'Intranasal', doseUnit:'mg/kg', min:0.2, max:0.2, absMax:10, inicio:'10–15 min', duracion:'60–90 min', safety:'Puede irritar mucosa nasal. Vigilar ventilación y sedación.', short:'Vigilar ventilación'},
    keta_im:{nombre:'Ketamina IM', clase:'other', via:'Intramuscular', doseUnit:'mg/kg', min:2, max:5, absMax:null, inicio:'5–10 min', duracion:'30–60 min', safety:'Hipersalivación, náuseas/vómitos, taquicardia, hipertensión y reacciones psicomiméticas.', short:'Respuesta adrenérgica'},
    keta_in:{nombre:'Ketamina IN', clase:'other', via:'Intranasal', doseUnit:'mg/kg', min:3, max:5, absMax:null, inicio:'5–10 min', duracion:'30–60 min', safety:'Inicio rápido. Considerar secreciones, náuseas/vómitos y respuesta simpática.', short:'Secreciones / N-V'},
    keta_oral:{nombre:'Ketamina VO', clase:'other', via:'Oral', doseUnit:'mg/kg', min:5, max:10, absMax:null, inicio:'20–30 min', duracion:'45–90 min', safety:'Mayor latencia que IN/IM. Vigilar vómitos y fenómenos psicomiméticos.', short:'Vómitos / agitación'}
  };

  function parseLocal(value){ if(CNS.parseDecimal) return CNS.parseDecimal(value); const n=Number(String(value||'').replace(',', '.')); return Number.isFinite(n)?n:null; }
  function fmt(value, decimals){ if(!Number.isFinite(value)) return '-'; if(CNS.formatNumber) return CNS.formatNumber(value, decimals); return Number(value).toLocaleString('es-CL',{maximumFractionDigits:decimals}); }
  function setText(id, value){ const el=document.getElementById(id); if(CNS.safeSetText) CNS.safeSetText(el, value); else if(el) el.textContent=value; }
  function getSelected(name){ const el=document.querySelector('input[name="'+name+'"]:checked'); return el ? el.value : null; }
  function drugClassToCss(clase){ if(clase==='opioid') return 'drug-opioid'; if(clase==='local') return 'drug-local'; if(clase==='inductor') return 'drug-inductor'; return 'drug-other'; }
  function checkedExclusions(){ return Array.from(document.querySelectorAll('.exclusion:checked')).map(el => el.value); }
  function doseDecimals(unit){ return unit.indexOf('mcg')>=0 ? 0 : 2; }

  function renderDrugButtons(){
    const container=document.getElementById('drugButtons');
    container.innerHTML=Object.keys(DRUGS).map(function(key){
      const drug=DRUGS[key];
      return '<label>'+
        '<input class="note-check note-trigger" type="radio" name="farmaco" id="drug_'+key+'" value="'+key+'"'+(key==='dex_in'?' checked':'')+'>'+
        '<div class="drug-card '+drugClassToCss(drug.clase)+'">'+
          '<div class="drug-label-content">'+
            '<div class="drug-label-title"><i class="fa-solid fa-vial pe-2"></i>'+drug.nombre+'</div>'+
            '<div class="drug-label-subtitle">'+drug.via+' · '+drug.min+'–'+drug.max+' '+drug.doseUnit+'</div>'+
          '</div>'+
        '</div>'+
      '</label>';
    }).join('');
  }

  function calcDose(drug, weight){
    if(!Number.isFinite(weight) || weight <= 0) return {range:'-', capped:false, raw:'Ingrese peso'};
    const d= doseDecimals(drug.doseUnit);
    let low=weight*drug.min;
    let high=weight*drug.max;
    let capped=false;
    if(drug.absMax !== null){
      if(low > drug.absMax){ low = drug.absMax; capped=true; }
      if(high > drug.absMax){ high = drug.absMax; capped=true; }
    }
    const same=Math.abs(low-high)<0.00001;
    return {range:(same ? fmt(low,d) : fmt(low,d)+'–'+fmt(high,d))+' '+drug.doseUnit.replace('/kg',''), capped:capped, raw:fmt(weight*drug.min,d)+'–'+fmt(weight*drug.max,d)+' '+drug.doseUnit.replace('/kg','')};
  }

  function mypasScore(){
    const a=Number(getSelected('mypasActividad') || 0);
    const b=Number(getSelected('mypasVocal') || 0);
    const c=Number(getSelected('mypasExpresion') || 0);
    const d=Number(getSelected('mypasAlerta') || 0);
    const e=Number(getSelected('mypasPadres') || 0);
    return ((a / 4) + (b / 6) + (c / 4) + (d / 4) + (e / 4)) * 20;
  }

  function mypasText(score){
    if(score > 60) return 'Ansiedad alta: avisar a anestesiólogo y considerar intervención.';
    if(score >= 40) return 'Ansiedad clínicamente significativa: requiere evaluación e intervención según contexto.';
    if(score >= 30) return 'Ansiedad leve: observar evolución y considerar medidas no farmacológicas o farmacológicas según contexto.';
    return 'Ansiedad mínima esperada según mYPAS-E estándar.';
  }

  function umssText(v){
    if(v === '0') return 'Sedación insuficiente: niño alerta. Puede no facilitar separación o inducción.';
    if(v === '1' || v === '2') return 'Rango objetivo: tranquilo/cooperador sin compromiso respiratorio esperado.';
    if(v === '3') return 'Sedación profunda: vigilancia estrecha y riesgo respiratorio.';
    return 'No responde: sedación muy profunda. Tratar como alarma clínica.';
  }

  function render(){
    const weight=parseLocal(document.getElementById('pesoPaciente').value);
    const drug=DRUGS[getSelected('farmaco') || 'dex_in'];
    const exclusions=checkedExclusions();
    const umss=getSelected('umss') || '1';
    const mypas=mypasScore();
    const dose=calcDose(drug, weight);

    const weightTxt=Number.isFinite(weight) ? fmt(weight, Number.isInteger(weight) ? 0 : 1)+' kg' : 'peso no ingresado';
    setText('summaryPatient', weightTxt);
    setText('summaryDrug', drug.nombre);
    setText('summaryMypas', fmt(mypas,1));
    setText('doseValue', dose.range);
    setText('doseNote', (dose.capped ? 'Dosis limitada por máximo. Rango: '+dose.raw+'.' : 'Según peso, vía y fármaco seleccionado.'));
    setText('timeValue', drug.inicio+' / '+drug.duracion);
    setText('timeNote', 'Inicio aproximado / duración del efecto según vía seleccionada.');
    setText('safetyShort', drug.short);
    setText('safetyNote', drug.safety);
    setText('monitorValue', umss==='3' || umss==='4' ? 'Vigilancia estrecha' : 'Cada 15 min');
    setText('monitorNote', 'ECG, SpO₂, UMSS; PA si corresponde. '+umssText(umss));

    let warnings=[];
    if(!Number.isFinite(weight) || weight <= 0) warnings.push('Ingresa peso válido para calcular dosis.');
    exclusions.forEach(function(x){ warnings.push('Criterio de exclusión/alerta: '+x+'.'); });
    if(umss === '3' || umss === '4') warnings.push('UMSS '+umss+': sedación excesiva. Requiere vigilancia estrecha y evaluación médica.');
    if(mypas >= 40) warnings.push('mYPAS-E '+fmt(mypas,1)+': ansiedad clínicamente significativa.');

    const validity=document.getElementById('validityWarning');
    const validityText=document.getElementById('validityWarningText');
    if(warnings.length){ validity.classList.remove('note-hidden'); validityText.innerHTML=warnings.map(w=>'<div>• '+w+'</div>').join(''); }
    else { validity.classList.add('note-hidden'); validityText.textContent=''; }

    let riskMain='Candidato a premedicación según evaluación clínica';
    let riskSoft='Dexmedetomidina intranasal es la primera línea si no hay exclusiones y existe indicación médica.';
    let cardClass='note-result-card analg-result-low';
    if(warnings.length){ riskMain='Requiere revisión antes de premedicar'; riskSoft='Hay criterios de alerta, exclusión o datos incompletos. No administrar automáticamente.'; cardClass='note-result-card analg-result-high'; }
    else if(mypas < 30){ riskMain='Ansiedad mínima según mYPAS-E'; riskSoft='No requiere acción inmediata por ansiedad, salvo criterio clínico.'; cardClass='note-result-card analg-result-low'; }
    else if(mypas < 40){ riskMain='Ansiedad leve según mYPAS-E'; riskSoft='Considerar medidas no farmacológicas y reevaluar necesidad de premedicación según contexto.'; cardClass='note-result-card analg-result-mid'; }
    else if(mypas <= 60){ riskMain='Ansiedad clínicamente significativa'; riskSoft='Premedicación razonable si no hay exclusiones. Indicación debe ser médica y oportuna.'; cardClass='note-result-card analg-result-high'; }
    else { riskMain='Ansiedad alta según mYPAS-E'; riskSoft='Avisar a anestesiólogo y considerar intervención.'; cardClass='note-result-card analg-result-high'; }

    ['timeCard','safetyCard','monitorCard'].forEach(function(id){ const el=document.getElementById(id); if(el) el.className = cardClass; });
    setText('riskText', riskMain);
    setText('riskSoft', riskSoft);
    setText('summaryNarrative', drug.nombre+' '+drug.via+': '+dose.range+'. '+mypasText(mypas));
    setText('indicationLine', riskSoft);
    setText('administrationLine', 'Administrar oportunamente. Explicar a padres/tutores vía, efecto esperado y signos de alarma. Mantener camilla con barandas y monitorización.');
    setText('warningLine', warnings.length ? warnings.join(' ') : drug.safety);
  }

  renderDrugButtons();
  document.querySelectorAll('.note-trigger').forEach(function(el){ el.addEventListener('change', render); el.addEventListener('input', render); });
  document.getElementById('pesoPaciente').addEventListener('input', render);
  document.getElementById('drugButtons').addEventListener('change', render);
  render();
})();
</script>

<?php require("../footer.php"); ?>
