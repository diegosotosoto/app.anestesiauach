<?php
$titulo_pagina = "Score de Caprini";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para estimar riesgo de tromboembolismo venoso mediante el modelo de Caprini y orientar medidas generales de tromboprofilaxis según puntaje total.";
$formula = "Estratificación orientativa: 0–1 bajo riesgo, 2 riesgo moderado, 3–4 alto riesgo, ≥5 muy alto riesgo. El score informa la decisión de profilaxis, pero no la prescribe por sí solo. Debe interpretarse junto al riesgo de sangrado, función renal, neuroeje, tipo de cirugía y protocolo institucional.";
$referencias = array(
  "Caprini JA. Risk assessment as a guide for the prevention of the many faces of venous thromboembolism. Am J Surg. 2010.",
  "Cronin M, Dengler N, Krauss ES, et al. Completion of the Updated Caprini Risk Assessment Model (2013 Version). Clin Appl Thromb Hemost. 2019.",
  "Gould MK, Garcia DA, Wren SM, et al. Prevention of VTE in nonorthopedic surgical patients: ACCP Guidelines. Chest. 2012.",
  "Ajustar siempre a protocolo institucional, riesgo hemorrágico, función renal y técnica anestésica."
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
          .caprini-group{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }

          .caprini-group:last-child{
            margin-bottom:0;
          }

          .caprini-group-title{
            display:flex;
            align-items:center;
            gap:.55rem;
            font-size:1rem;
            font-weight:850;
            line-height:1.2;
            color:var(--note-text);
            margin:0 0 .25rem 0;
          }

          .caprini-group-title i{
            color:#3559b7;
            font-size:.98rem;
          }

          .caprini-group-subtitle{
            font-size:.84rem;
            color:var(--note-muted);
            line-height:1.35;
            margin:0 0 .8rem 0;
          }

          .caprini-subblock-title{
            font-size:.8rem;
            color:var(--note-muted);
            font-weight:800;
            letter-spacing:.04em;
            text-transform:uppercase;
            margin:.35rem 0 .55rem 0;
          }

          .caprini-grid-2,
          .caprini-grid-3,
          .caprini-grid-4{
            display:grid;
            gap:.75rem;
          }

          .caprini-grid-2{grid-template-columns:repeat(2,minmax(0,1fr));}
          .caprini-grid-3{grid-template-columns:repeat(3,minmax(0,1fr));}
          .caprini-grid-4{grid-template-columns:repeat(4,minmax(0,1fr));}

          .caprini-option{
            min-width:0;
          }

          .caprini-points{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:38px;
            margin-top:.35rem;
            padding:.16rem .46rem;
            border-radius:999px;
            background:#eef3ff;
            color:#3559b7;
            font-size:.76rem;
            font-weight:900;
            line-height:1.1;
          }

          .caprini-selected-list{
            display:flex;
            flex-wrap:wrap;
            gap:.35rem;
          }

          .caprini-selected-pill{
            display:inline-flex;
            align-items:center;
            gap:.3rem;
            padding:.28rem .58rem;
            border-radius:999px;
            background:#eaf7ef;
            color:#1f7a4d;
            font-size:.78rem;
            line-height:1.2;
            font-weight:800;
            max-width:100%;
            overflow-wrap:anywhere;
          }

          body.theme-dark .caprini-selected-pill{
            background:#1a4a33;
            color:#6ee7b7;
          }

          .caprini-selected-empty{
            color:var(--note-muted);
            font-size:.9rem;
          }

          .caprini-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          body.theme-dark .caprini-plan-line{
            background:var(--note-card);
          }

          .caprini-plan-line:last-child{
            margin-bottom:0;
          }

          .caprini-low{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .caprini-moderate{
            background:#f2f8ff !important;
            border-color:#d4e6ff !important;
          }

          .caprini-high{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .caprini-veryhigh{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          body.theme-dark .caprini-low{
            background:#1a4a33 !important;
            border-color:#3a9e6e !important;
          }

          body.theme-dark .caprini-moderate{
            background:#1e3a5f !important;
            border-color:#4a90d9 !important;
          }

          body.theme-dark .caprini-high{
            background:#5c4a1a !important;
            border-color:#d4a017 !important;
          }

          body.theme-dark .caprini-veryhigh{
            background:#5a1f1f !important;
            border-color:#c45c5c !important;
          }

          @media (max-width:900px){
            .caprini-grid-4{grid-template-columns:repeat(2,minmax(0,1fr));}
            .caprini-grid-3{grid-template-columns:repeat(2,minmax(0,1fr));}
          }

          @media (max-width:420px){
            .caprini-grid-2,
            .caprini-grid-3,
            .caprini-grid-4{
              grid-template-columns:1fr;
            }
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · TROMBOPROFILAXIS · TEV</div>
          <h2>Score de Caprini</h2>
          <div class="note-hero-subtitle">Calcula riesgo de tromboembolismo venoso perioperatorio y orienta profilaxis según puntaje, contexto y riesgo hemorrágico.</div>
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
            <div class="note-section-label">Factores de riesgo</div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-calendar-days"></i>Edad</div>
              <p class="caprini-group-subtitle">Escoge solo una opción.</p>
              <div class="caprini-grid-4">
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="edad_caprini" data-points="0" data-label="Edad menor de 41 años" checked>
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Menor de 41 años</div><span class="caprini-points">0</span></div></div>
                </label>
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="edad_caprini" data-points="1" data-label="Edad 41–60 años">
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">41–60 años</div><span class="caprini-points">+1</span></div></div>
                </label>
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="edad_caprini" data-points="2" data-label="Edad 61–74 años">
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">61–74 años</div><span class="caprini-points">+2</span></div></div>
                </label>
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="edad_caprini" data-points="3" data-label="Edad ≥75 años">
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">≥75 años</div><span class="caprini-points">+3</span></div></div>
                </label>
              </div>
            </div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-scalpel-line-dashed"></i>Cirugía planificada</div>
              <p class="caprini-group-subtitle">Escoge solo una opción.</p>
              <div class="caprini-grid-4">
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="cirugia_caprini" data-points="0" data-label="Sin cirugía relevante" checked>
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Sin cirugía relevante</div><span class="caprini-points">0</span></div></div>
                </label>
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="cirugia_caprini" data-points="1" data-label="Cirugía menor <45 minutos">
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Cirugía menor &lt;45 min</div><span class="caprini-points">+1</span></div></div>
                </label>
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="cirugia_caprini" data-points="2" data-label="Cirugía mayor >45 minutos">
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Cirugía mayor &gt;45 min</div><span class="caprini-points">+2</span></div></div>
                </label>
                <label class="caprini-option">
                  <input class="note-checklist-item-input caprini-radio" type="radio" name="cirugia_caprini" data-points="1" data-label="Cirugía de más de 2 horas">
                  <div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Cirugía &gt;2 horas</div><span class="caprini-points">+1</span></div></div>
                </label>
              </div>
            </div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-bed"></i>Movilidad / inmovilización / acceso</div>
              <p class="caprini-group-subtitle">Reposo en cama es excluyente. Yeso y acceso venoso central pueden coexistir.</p>

              <div class="caprini-subblock-title">Reposo / movilidad</div>
              <div class="caprini-grid-3 mb-3">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-radio" type="radio" name="reposo_caprini" data-points="0" data-label="Sin reposo relevante" checked><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Sin reposo relevante</div><span class="caprini-points">0</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-radio" type="radio" name="reposo_caprini" data-points="1" data-label="Reposo en cama <72 horas"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Reposo &lt;72 h</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-radio" type="radio" name="reposo_caprini" data-points="2" data-label="Reposo en cama ≥72 horas"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Reposo ≥72 h</div><span class="caprini-points">+2</span></div></div></label>
              </div>

              <div class="caprini-grid-2">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="2" data-label="Yeso o inmovilizador de extremidad inferior"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Yeso / inmovilizador EEII</div><span class="caprini-points">+2</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="2" data-label="Acceso venoso central"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Acceso venoso central</div><span class="caprini-points">+2</span></div></div></label>
              </div>
            </div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-weight-scale"></i>Hallazgos y comorbilidades de 1 punto</div>
              <p class="caprini-group-subtitle">BMI es excluyente. El resto puede coexistir.</p>

              <div class="caprini-subblock-title">BMI</div>
              <div class="caprini-grid-3 mb-3">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-radio" type="radio" name="bmi_caprini" data-points="0" data-label="BMI <25" checked><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">BMI &lt;25</div><span class="caprini-points">0</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-radio" type="radio" name="bmi_caprini" data-points="1" data-label="BMI ≥25"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">BMI ≥25</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-radio" type="radio" name="bmi_caprini" data-points="1" data-label="BMI >40"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">BMI &gt;40</div><span class="caprini-points">+1</span></div></div></label>
              </div>

              <div class="caprini-grid-2">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Várices visibles"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Várices visibles</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Piernas hinchadas actuales"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Piernas hinchadas actuales</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Infarto al miocardio"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Infarto al miocardio</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Insuficiencia cardíaca congestiva"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Insuficiencia cardíaca</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Enfermedad inflamatoria intestinal"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Enfermedad inflamatoria intestinal</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Infección grave actual o reciente"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Infección grave / neumonía</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Enfermedad pulmonar existente"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Enfermedad pulmonar</div><span class="caprini-points">+1</span></div></div></label>
              </div>
            </div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-venus"></i>Mujeres / obstétrico</div>
              <p class="caprini-group-subtitle">Marca los que correspondan.</p>
              <div class="caprini-grid-2">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Uso de hormonas (ACO o TRH)"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Hormonas: ACO / TRH</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Embarazo o puerperio dentro de 1 mes"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Embarazo / puerperio &lt;1 mes</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Antecedentes obstétricos de riesgo"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Antecedentes obstétricos de riesgo</div><span class="caprini-points">+1</span></div></div></label>
              </div>
            </div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-notes-medical"></i>Otros factores</div>
              <p class="caprini-group-subtitle">Marca todos los que apliquen.</p>
              <div class="caprini-grid-2">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Tabaquismo"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Tabaquismo</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Diabetes insulinorrequirente"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Diabetes insulinorrequirente</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Quimioterapia"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Quimioterapia</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="1" data-label="Transfusiones sanguíneas"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Transfusiones sanguíneas</div><span class="caprini-points">+1</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="2" data-label="Malignidad presente o pasada"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Malignidad presente o pasada</div><span class="caprini-points">+2</span></div></div></label>
              </div>
            </div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-dna"></i>Factores de 3 puntos</div>
              <p class="caprini-group-subtitle">Trombosis previa, historia familiar o trombofilia elevan fuertemente el riesgo.</p>
              <div class="caprini-grid-2">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="3" data-label="Antecedente personal de TEV"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Antecedente personal de TEV</div><span class="caprini-points">+3</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="3" data-label="Antecedente familiar de TEV"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Antecedente familiar de TEV</div><span class="caprini-points">+3</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="3" data-label="Historia personal o familiar de trombofilia"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Trombofilia personal/familiar</div><span class="caprini-points">+3</span></div></div></label>
              </div>
            </div>

            <div class="caprini-group">
              <div class="caprini-group-title"><i class="fa-solid fa-triangle-exclamation"></i>Factores de 5 puntos</div>
              <p class="caprini-group-subtitle">Factores mayores: suelen desplazar al paciente a muy alto riesgo.</p>
              <div class="caprini-grid-2">
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="5" data-label="Artroplastía electiva de cadera o rodilla"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Artroplastía cadera/rodilla</div><span class="caprini-points">+5</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="5" data-label="Fractura de cadera, pelvis o pierna"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Fractura cadera / pelvis / pierna</div><span class="caprini-points">+5</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="5" data-label="Trauma severo o fracturas múltiples"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Trauma severo / fracturas múltiples</div><span class="caprini-points">+5</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="5" data-label="Lesión medular con parálisis"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">Lesión medular con parálisis</div><span class="caprini-points">+5</span></div></div></label>
                <label class="caprini-option"><input class="note-checklist-item-input caprini-item" type="checkbox" data-points="5" data-label="ACV"><div class="note-checklist-item"><div class="note-checklist-item-mark"><i class="fa-solid fa-check"></i></div><div class="note-checklist-item-copy"><div class="note-checklist-item-title">ACV</div><span class="caprini-points">+5</span></div></div></label>
              </div>
            </div>

          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">0 puntos. Bajo riesgo; generalmente basta deambulación precoz si el contexto clínico lo permite.</div>
          <div class="note-result-grid-2 mt-2">
            <div class="note-result-card">
              <div class="note-result-card-label">Puntaje total</div>
              <div id="scoreTotal" class="note-result-card-value">0</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Categoría</div>
              <div id="scoreCategory" class="note-result-card-value">Bajo riesgo</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Factores activos</div>
              <div id="scoreItemsCount" class="note-result-card-value">0 seleccionados</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Conducta inicial</div>
              <div id="summaryConduct" class="note-result-card-value">Deambulación precoz</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="scoreCard" class="note-result-card caprini-low">
            <div class="note-result-card-label">Score de Caprini</div>
            <div id="resultMain" class="note-result-card-value">0 puntos</div>
            <div id="resultNote" class="note-result-card-note">Estratificación orientativa de riesgo TEV.</div>
          </div>
          <div id="riskCard" class="note-result-card caprini-low">
            <div class="note-result-card-label">Riesgo</div>
            <div id="riskMain" class="note-result-card-value">Bajo riesgo</div>
            <div id="riskNote" class="note-result-card-note">0–1 puntos.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Interpretación y conducta</div>
          <div id="managementTitle" class="note-interpretation-main">Bajo riesgo</div>
          <div id="managementText" class="note-interpretation-soft">El score informa decisiones sobre prevención de TEV, pero no prescribe profilaxis por sí solo. En bajo riesgo, la deambulación precoz suele ser suficiente.</div>

          <div class="mt-3 text-start">
            <div class="caprini-plan-line"><strong>Conducta orientativa:</strong> <span id="managementExamples">Deambulación precoz; no suele requerirse profilaxis mecánica ni farmacológica de rutina.</span></div>
            <div class="caprini-plan-line"><strong>Factores seleccionados:</strong> <span id="selectedFactorsWrap" class="caprini-selected-empty">Aún no has seleccionado factores.</span></div>
            <div class="caprini-plan-line"><strong>Limitación:</strong> <span>Revisar riesgo hemorrágico, función renal, técnica neuroaxial, tipo de cirugía y protocolo institucional.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia:</strong>
          <div class="mt-2">El puntaje de Caprini orienta la tromboprofilaxis, pero no reemplaza evaluación de sangrado, plaquetas, función renal, neuroeje, tipo de cirugía ni protocolo institucional.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="note-warning-list">
              <div class="note-warning-item">
                <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
                <div class="note-warning-copy">
                  <div class="note-warning-title">Bajo riesgo</div>
                  <p class="note-warning-note">Deambulación precoz si no hay otros elementos clínicos que aumenten el riesgo.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Interpretar el score, no obedecerlo ciegamente</div>
          <div class="note-tips"><strong>Qué hacer:</strong> calcula Caprini y luego cruza el resultado con riesgo hemorrágico, cirugía, función renal, neuroeje y movilidad real.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> anticoagular por puntaje sin revisar sangrado activo, plaquetas, función renal o retiro de catéter neuroaxial.</div>
          <div class="note-tips"><strong>Muy alto riesgo:</strong> suele justificar profilaxis combinada y, en casos seleccionados, profilaxis extendida postalta.</div>
          <div class="note-tips"><strong>Reevaluación:</strong> el puntaje puede cambiar si el paciente prolonga inmovilidad, desarrolla infección o acumula nuevos factores.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> si no puedes usar profilaxis farmacológica por sangrado, no olvides profilaxis mecánica y deambulación.</div>
        </div>

        <div class="note-footer mt-3">
          Herramienta docente y de apoyo clínico. Ajustar siempre a riesgo hemorrágico, función renal, anestesia neuroaxial y protocolo institucional.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

  if(CNS.bindChecklistItems){
    CNS.bindChecklistItems('.note-checklist-item-input');
  }

  function setText(id, value){
    const el = document.getElementById(id);
    if(CNS.safeSetText) CNS.safeSetText(el, value);
    else if(el) el.textContent = value;
  }

  function setHTML(id, value){
    const el = document.getElementById(id);
    if(el) el.innerHTML = value;
  }

  function escapeHtml(s){
    return String(s)
      .replaceAll('&','&amp;')
      .replaceAll('<','&lt;')
      .replaceAll('>','&gt;')
      .replaceAll('"','&quot;')
      .replaceAll("'","&#039;");
  }

  function riskData(total){
    if(total <= 1){
      return {
        category:'Bajo riesgo',
        title:'Bajo riesgo',
        range:'0–1 puntos',
        conduct:'Deambulación precoz',
        text:'El score informa decisiones sobre prevención de TEV, pero no prescribe profilaxis por sí solo. En bajo riesgo, la deambulación precoz suele ser suficiente.',
        examples:'Deambulación precoz; no suele requerirse profilaxis mecánica ni farmacológica de rutina.',
        css:'caprini-low',
        level:'ok'
      };
    }
    if(total === 2){
      return {
        category:'Riesgo moderado',
        title:'Riesgo moderado',
        range:'2 puntos',
        conduct:'Mecánica o farmacológica',
        text:'Puede considerarse profilaxis mecánica o farmacológica según contexto clínico y riesgo hemorrágico.',
        examples:'Compresión neumática intermitente o profilaxis farmacológica según protocolo local y riesgo de sangrado.',
        css:'caprini-moderate',
        level:'mid'
      };
    }
    if(total <= 4){
      return {
        category:'Alto riesgo',
        title:'Alto riesgo',
        range:'3–4 puntos',
        conduct:'Farmacológica ± mecánica',
        text:'Suele recomendarse profilaxis farmacológica durante hospitalización, agregando métodos mecánicos cuando sea apropiado.',
        examples:'Profilaxis farmacológica durante hospitalización; agregar compresión neumática si corresponde.',
        css:'caprini-high',
        level:'high'
      };
    }
    return {
      category:'Muy alto riesgo',
      title:'Muy alto riesgo',
      range:'≥5 puntos',
      conduct:'Combinada; considerar extendida',
      text:'Se aconseja profilaxis combinada farmacológica y mecánica si no hay contraindicación. En pacientes seleccionados puede considerarse profilaxis extendida postalta.',
      examples:'Profilaxis farmacológica + mecánica; considerar profilaxis extendida postalta según cirugía, cáncer, movilidad y protocolo.',
      css:'caprini-veryhigh',
      level:'high'
    };
  }

  function selectedLabels(){
    const selected = [];

    document.querySelectorAll('.note-checklist-item-input.caprini-radio:checked').forEach(function(item){
      const pts = parseInt(item.dataset.points || '0', 10);
      if(pts > 0){
        selected.push({label:item.dataset.label || '', pts:pts});
      }
    });

    document.querySelectorAll('.note-checklist-item-input.caprini-item:checked').forEach(function(item){
      const pts = parseInt(item.dataset.points || '0', 10);
      selected.push({label:item.dataset.label || '', pts:pts});
    });

    return selected;
  }

  function calculateTotal(){
    let total = 0;
    document.querySelectorAll('.note-checklist-item-input.caprini-radio:checked, .note-checklist-item-input.caprini-item:checked').forEach(function(item){
      total += parseInt(item.dataset.points || '0', 10);
    });
    return total;
  }

  function renderSelected(selected){
    if(!selected.length){
      setHTML('selectedFactorsWrap', '<span class="caprini-selected-empty">Aún no has seleccionado factores.</span>');
      return;
    }

    const pills = selected.map(function(item){
      return '<span class="caprini-selected-pill"><i class="fa-solid fa-check"></i>' + escapeHtml(item.label) + ' (+' + item.pts + ')</span>';
    }).join('');

    setHTML('selectedFactorsWrap', '<span class="caprini-selected-list">' + pills + '</span>');
  }

  function renderActions(data, total){
    let items = [];

    if(data.level === 'ok'){
      items = [
        ['ok','Bajo riesgo','Deambulación precoz si no hay otros elementos clínicos que aumenten el riesgo.'],
        ['ok','Evitar sobretratamiento','No indicar profilaxis farmacológica por rutina si el riesgo de TEV es bajo y no hay otros factores.']
      ];
    } else if(total === 2){
      items = [
        ['mid','Riesgo moderado','Evaluar profilaxis mecánica o farmacológica según cirugía, movilidad y riesgo hemorrágico.'],
        ['mid','Individualizar','El mismo puntaje no pesa igual en cirugía menor ambulatoria que en cirugía mayor hospitalizada.']
      ];
    } else if(total <= 4){
      items = [
        ['high','Alto riesgo','Considerar profilaxis farmacológica si no hay contraindicación, más mecánica según contexto.'],
        ['mid','Revisar seguridad','Antes de anticoagular: sangrado, plaquetas, función renal, neuroeje y timing quirúrgico.']
      ];
    } else {
      items = [
        ['high','Muy alto riesgo','Suele justificar profilaxis combinada farmacológica y mecánica si el sangrado lo permite.'],
        ['high','Considerar profilaxis extendida','Especialmente en cáncer, cirugía mayor, movilidad reducida o puntajes muy altos, según protocolo.']
      ];
    }

    items.push(['mid','Reevaluar durante hospitalización','El score puede cambiar con inmovilidad prolongada, infección, acceso central o nuevos eventos.']);

    document.getElementById('actionList').innerHTML = items.map(function(item){
      return '<div class="note-warning-item">' +
        '<div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>' +
        '<div class="note-warning-copy">' +
          '<div class="note-warning-title">' + item[1] + '</div>' +
          '<p class="note-warning-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateCaprini(){
    const total = calculateTotal();
    const selected = selectedLabels();
    const data = riskData(total);

    setText('scoreTotal', String(total));
    setText('scoreCategory', data.category);
    setText('scoreItemsCount', selected.length + (selected.length === 1 ? ' seleccionado' : ' seleccionados'));
    setText('summaryConduct', data.conduct);
    setText('resultMain', total + (total === 1 ? ' punto' : ' puntos'));
    setText('riskMain', data.category);
    setText('riskNote', data.range + '.');
    setText('managementTitle', data.title);
    setText('managementText', data.text);
    setText('managementExamples', data.examples);

    const narrative = total + (total === 1 ? ' punto. ' : ' puntos. ') + data.category + '; ' + data.conduct.toLowerCase() + '. Ajustar siempre al riesgo hemorrágico y contexto quirúrgico.';
    setText('summaryNarrative', narrative);

    renderSelected(selected);

    document.getElementById('scoreCard').className = 'note-result-card ' + data.css;
    document.getElementById('riskCard').className = 'note-result-card ' + data.css;

    renderActions(data, total);
  }

  const allInputs = Array.from(document.querySelectorAll('.note-checklist-item-input.caprini-radio, .note-checklist-item-input.caprini-item'));
  allInputs.forEach(function(el){
    el.addEventListener('change', updateCaprini);
  });

  updateCaprini();
})();
</script>

<?php require("../footer.php"); ?>
