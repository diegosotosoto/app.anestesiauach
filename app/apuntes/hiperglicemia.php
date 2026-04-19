<?php
$titulo_pagina = "Hiperglicemia perioperatoria";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Resumen interactivo para manejo perioperatorio de hiperglicemia en pabellón. Integra metas glicémicas, decisión entre corrección subcutánea e infusión EV, conducta en usuarios de GLP-1 RA, ajuste de insulina y orientación postoperatoria.";
$formula = "Corrección SC = (glicemia medida - 100) / factor de sensibilidad. Factor de sensibilidad = 1800 / TDD. Si no se conoce TDD, puede usarse 40 UI/día como referencia docente. En procedimientos prolongados, inestabilidad o alta variabilidad metabólica debe preferirse infusión EV.";
$referencias = array(
  "Perioperative Hyperglycemia Management: An Update. Anesthesiology. 2017.",
  "American Diabetes Association. Standards of Care in Diabetes. Hospital care and perioperative glycemic targets.",
  "Kindel TL, et al. Multi-society clinical practice guidance for the safe use of GLP-1 receptor agonists in the perioperative period. 2024.",
  "Recomendaciones docentes locales de manejo perioperatorio de glicemia intraoperatoria."
);

include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?php echo time(); ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .gly-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }
          .gly-choice-grid.gly-grid-3{
            grid-template-columns:repeat(3,minmax(0,1fr));
          }
          .gly-choice-grid.gly-grid-4{
            grid-template-columns:repeat(4,minmax(0,1fr));
          }
          .gly-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }
          .gly-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:76px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.7rem .75rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.18rem;
          }
          .gly-option i{
            color:#3559b7;
            font-size:1rem;
          }
          .gly-option-input:checked + .gly-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .note-input{
            min-height:46px;
            padding:.55rem .75rem;
            font-size:1rem;
          }
          .note-input-unit{
            min-height:46px;
            padding:.55rem .75rem;
            font-size:.95rem;
          }
          .gly-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }
          .gly-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .gly-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }
          .gly-plan-line:last-child{margin-bottom:0;}

          .gly-safety-list{
            display:grid;
            gap:.75rem;
          }
          .gly-safety-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.72rem .85rem;
          }
          .gly-safety-mark{
            flex:0 0 auto;
            width:30px;
            height:30px;
            border-radius:999px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            margin-top:.08rem;
          }
          .gly-safety-mark.ok{background:#2ea663;}
          .gly-safety-mark.mid{background:#f4c542;}
          .gly-safety-mark.high{background:#d92d20;}
          .gly-safety-copy{min-width:0;flex:1;}
          .gly-safety-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }
          .gly-safety-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .gly-table-wrap{overflow-x:auto;}
          .gly-table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            min-width:0;
            table-layout:auto;
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            overflow:hidden;
          }
          .gly-table th,
          .gly-table td{
            padding:.58rem .62rem;
            border-bottom:1px solid #eef2f6;
            border-right:1px solid #eef2f6;
            vertical-align:top;
            text-align:left;
            word-break:normal;
            overflow-wrap:normal;
            hyphens:none;
          }
          .gly-table th{
            background:#3559b7;
            color:#fff;
            font-size:.76rem;
            font-weight:800;
            line-height:1.2;
            white-space:normal;
          }
          .gly-table td{
            font-size:.88rem;
            line-height:1.28;
          }
          .gly-table th:last-child,
          .gly-table td:last-child{border-right:none;}
          .gly-table tr:last-child td{border-bottom:none;}
          .gly-table td:first-child{font-weight:800;color:var(--note-text);width:27%;}
          .gly-table th:nth-child(2),.gly-table td:nth-child(2){width:18%;}
          .gly-table th:nth-child(3),.gly-table td:nth-child(3){width:24%;}
          .gly-table th:nth-child(4),.gly-table td:nth-child(4){width:31%;}
          .gly-small{font-size:.86rem;color:var(--note-muted);line-height:1.35;}

          .gly-drug-badge{
            display:inline-block;
            padding:.22rem .48rem;
            border-radius:.6rem;
            font-weight:800;
            border:1px solid rgba(31,42,55,.12);
            line-height:1.1;
            color:#111827;
            background:#fff;
          }
          .gly-drug-other{background:#fff;color:#111827;}
          .gly-drug-insulin{background:#fff;color:#111827;}
          .gly-drug-warning{background:#fff9e8;color:#111827;}

          .gly-section-card{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }

          .gly-section-head{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:.75rem;
            cursor:pointer;
          }
          .gly-section-title{
            margin:0;
            color:var(--note-text);
            font-size:1.02rem;
            font-weight:900;
            line-height:1.2;
          }
          .gly-section-sub{
            color:var(--note-muted);
            font-size:.9rem;
            line-height:1.35;
            margin-top:.2rem;
          }
          .gly-section-arrow{
            color:#667085;
            transition:.2s ease;
          }
          .gly-section-content{
            display:none;
            margin-top:1rem;
            padding-top:1rem;
            border-top:1px solid #e7edf5;
          }
          .gly-section-card.is-open .gly-section-content{display:block;}
          .gly-section-card.is-open .gly-section-arrow{transform:rotate(180deg);}

          @media (max-width:992px){
            .gly-choice-grid.gly-grid-4{grid-template-columns:repeat(2,minmax(0,1fr));}
          }
          @media (max-width:768px){
            .gly-choice-grid,
            .gly-choice-grid.gly-grid-3,
            .gly-choice-grid.gly-grid-4{grid-template-columns:repeat(2,minmax(0,1fr));}
          }
          @media (max-width:420px){
            .gly-choice-grid,
            .gly-choice-grid.gly-grid-3,
            .gly-choice-grid.gly-grid-4{grid-template-columns:1fr;}
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · METABOLISMO · DIABETES</div>
          <h2>Manejo perioperatorio de hiperglicemia</h2>
          <div class="note-hero-subtitle">Decide entre observación, corrección subcutánea o insulina EV según glicemia, contexto quirúrgico y riesgo metabólico.</div>
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
            <div class="note-section-label">Puntos clave</div>
            <div class="gly-safety-list">
              <div class="gly-safety-item">
                <div class="gly-safety-mark ok"><i class="fa-solid fa-bullseye"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">Target perioperatorio razonable</div>
                  <p class="gly-safety-note">Usualmente 140–180 mg/dL. Evita perseguir normalidad estricta si aumenta riesgo de hipoglicemia.</p>
                </div>
              </div>
              <div class="gly-safety-item">
                <div class="gly-safety-mark mid"><i class="fa-solid fa-clock"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">Frecuencia de control</div>
                  <p class="gly-safety-note">SC: mínimo cada 2 h. EV: horario. Hipoglicemia: controles más frecuentes.</p>
                </div>
              </div>
              <div class="gly-safety-item">
                <div class="gly-safety-mark high"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">SGLT2 / gliflozinas</div>
                  <p class="gly-safety-note">Riesgo de cetoacidosis euglicémica. No descartes cetosis solo porque la glicemia no es extrema.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Evaluación intraoperatoria</div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Glicemia actual</label>
                <div class="note-input-inline">
                  <input id="glyValue" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mg/dL</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">TDD si se conoce</label>
                <div class="note-input-inline">
                  <input id="tddValue" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">UI/día</div>
                </div>
              </div>
            </div>

            <div class="note-section-label">Contexto quirúrgico</div>
            <div class="gly-choice-grid gly-grid-3 mb-3">
              <label>
                <input class="gly-option-input" type="radio" name="ivcriteria" value="no" checked>
                <div class="gly-option">
                  <i class="fa-solid fa-user-check"></i>
                  <div class="gly-option-title">Caso estable</div>
                  <div class="gly-option-sub">Corrección SC posible</div>
                </div>
              </label>
              <label>
                <input class="gly-option-input" type="radio" name="ivcriteria" value="yes">
                <div class="gly-option">
                  <i class="fa-solid fa-syringe"></i>
                  <div class="gly-option-title">Criterios EV</div>
                  <div class="gly-option-sub">Preferir infusión</div>
                </div>
              </label>
              <label>
                <input class="gly-option-input" type="radio" name="ivcriteria" value="uncertain">
                <div class="gly-option">
                  <i class="fa-solid fa-circle-question"></i>
                  <div class="gly-option-title">Dudoso</div>
                  <div class="gly-option-sub">Ser conservador</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Referencia para TDD</div>
            <div class="gly-choice-grid mb-0">
              <label>
                <input class="gly-option-input" type="radio" name="tddmode" value="unknown" checked>
                <div class="gly-option">
                  <div class="gly-option-title">TDD desconocida</div>
                  <div class="gly-option-sub">Usar 40 UI/día</div>
                </div>
              </label>
              <label>
                <input class="gly-option-input" type="radio" name="tddmode" value="known">
                <div class="gly-option">
                  <div class="gly-option-title">TDD conocida</div>
                  <div class="gly-option-sub">Usar valor ingresado</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa glicemia actual y contexto quirúrgico para orientar la estrategia intraoperatoria.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Glicemia</div>
              <div id="summaryGly" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Contexto</div>
              <div id="summaryContext" class="note-summary-v">Caso estable</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">TDD usada</div>
              <div id="summaryTdd" class="note-summary-v">40 UI/día</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Estrategia</div>
              <div id="summaryStrategy" class="note-summary-v">Pendiente</div>
            </div>
          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div class="note-result-card">
            <div class="note-result-card-label">Corrección SC orientativa</div>
            <div id="corrNum" class="note-result-card-value">-</div>
            <div id="corrText" class="note-result-card-note">Ingresa la glicemia actual.</div>
          </div>
          <div class="note-result-card">
            <div class="note-result-card-label">Insulina EV</div>
            <div id="evInitialRate" class="note-result-card-value">-</div>
            <div id="evText" class="note-result-card-note">Decide según contexto y glicemia.</div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Conducta intraoperatoria sugerida</div>
          <div id="algoMain" class="note-interpretation-main">Pendiente</div>
          <div id="algoSoft" class="note-interpretation-soft">Completa glicemia actual para orientar corrección SC o infusión EV.</div>

          <div id="drugPlan" class="mt-3 text-start">
            <div class="gly-plan-line"><strong>Factor de sensibilidad:</strong> <span id="metaFs">-</span></div>
            <div class="gly-plan-line"><strong>Fórmula SC:</strong> <span id="metaFormula">-</span></div>
            <div class="gly-plan-line"><strong>Control recomendado:</strong> <span id="metaControl">Según estrategia</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">No acumules insulina rápida SC: no repetir antes de 2 horas y no dar más de 2 dosis SC en 4 horas. Si el caso es dinámico, cambia de estrategia en vez de insistir con bolos.</div>
        </div>

        <div class="gly-section-card is-open">
          <div class="gly-section-head" onclick="toggleGlySection(this)">
            <div>
              <div class="gly-section-title">Preoperatorio</div>
              <div class="gly-section-sub">Antidiabéticos, GLP-1 RA e insulina basal</div>
            </div>
            <i class="fa-solid fa-chevron-down gly-section-arrow"></i>
          </div>

          <div class="gly-section-content">
            <div class="note-section-label">Antidiabéticos orales</div>
            <div class="gly-table-wrap mb-3">
              <table class="gly-table">
                <thead>
                  <tr>
                    <th>Fármaco</th>
                    <th>Día previo</th>
                    <th>Cirugía menor</th>
                    <th>Mayor / ↓ VO</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><span class="gly-drug-badge gly-drug-other">Secretagogos</span><br><span class="gly-small">Sulfonilureas / meglitinidas</span></td>
                    <td>Tomar</td>
                    <td>Suspender</td>
                    <td>Suspender</td>
                  </tr>
                  <tr>
                    <td><span class="gly-drug-badge gly-drug-warning">SGLT2</span><br><span class="gly-small">Gliflozinas</span></td>
                    <td>Suspender</td>
                    <td>Suspender</td>
                    <td>Suspender</td>
                  </tr>
                  <tr>
                    <td><span class="gly-drug-badge gly-drug-other">Tiazolidinedionas</span><br><span class="gly-small">Pioglitazona</span></td>
                    <td>Tomar</td>
                    <td>Tomar</td>
                    <td>Suspender</td>
                  </tr>
                  <tr>
                    <td><span class="gly-drug-badge gly-drug-other">Metformina</span></td>
                    <td>Tomar*</td>
                    <td>Tomar*</td>
                    <td>Suspender</td>
                  </tr>
                  <tr>
                    <td><span class="gly-drug-badge gly-drug-other">iDPP-4</span><br><span class="gly-small">Sitagliptina / linagliptina</span></td>
                    <td>Tomar</td>
                    <td>Tomar</td>
                    <td>Tomar</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="gly-small mb-3">* Suspender metformina si se utilizará contraste EV o TFG &lt;45 mL/min.</div>

            <div class="note-section-label">Usuarios de GLP-1 RA</div>
            <div class="gly-choice-grid mb-3">
              <label>
                <input class="gly-option-input" type="radio" name="glp1symptoms" value="no" checked>
                <div class="gly-option">
                  <div class="gly-option-title">Sin síntomas</div>
                  <div class="gly-option-sub">Continuar en la mayoría</div>
                </div>
              </label>
              <label>
                <input class="gly-option-input" type="radio" name="glp1symptoms" value="yes">
                <div class="gly-option">
                  <div class="gly-option-title">Con síntomas GI</div>
                  <div class="gly-option-sub">Riesgo aumentado</div>
                </div>
              </label>
            </div>

            <div id="glp1IntakeBlock">
              <div class="note-section-label">Tipo de ingesta previa</div>
              <div class="gly-choice-grid gly-grid-3 mb-3">
                <label>
                  <input class="gly-option-input" type="radio" name="glp1intake" value="solids">
                  <div class="gly-option">
                    <div class="gly-option-title">Sólidos</div>
                    <div class="gly-option-sub">Riesgo mayor</div>
                  </div>
                </label>
                <label>
                  <input class="gly-option-input" type="radio" name="glp1intake" value="highcarb">
                  <div class="gly-option">
                    <div class="gly-option-title">Líquidos altos HC</div>
                    <div class="gly-option-sub">≥10% glucosa</div>
                  </div>
                </label>
                <label>
                  <input class="gly-option-input" type="radio" name="glp1intake" value="lowcarb" checked>
                  <div class="gly-option">
                    <div class="gly-option-title">Líquidos bajos HC</div>
                    <div class="gly-option-sub">&lt;10% glucosa</div>
                  </div>
                </label>
              </div>
            </div>

            <div id="glp1Conduct" class="gly-safety-item mb-3">
              <div id="glp1Mark" class="gly-safety-mark ok"><i class="fa-solid fa-check"></i></div>
              <div class="gly-safety-copy">
                <div id="glp1ConductTitle" class="gly-safety-title">Conducta GLP-1 RA</div>
                <p id="glp1ConductText" class="gly-safety-note">Si no hay síntomas significativos, puede continuarse GLP-1 RA en la mayoría de los pacientes. Individualizar si hay alto riesgo gastrointestinal.</p>
              </div>
            </div>

            <div class="note-summary-grid-2 mb-3">
              <div class="note-summary-item">
                <div class="note-summary-k">Ayuno orientativo</div>
                <div id="glp1Fasting" class="note-summary-v">4 h</div>
              </div>
              <div class="note-summary-item">
                <div class="note-summary-k">Resumen</div>
                <div id="glp1Summary" class="note-summary-v">Líquidos claros bajos en HC</div>
              </div>
            </div>

            <div class="note-section-label">Usuarios de insulina</div>
            <div class="gly-safety-list">
              <div class="gly-safety-item">
                <div class="gly-safety-mark mid"><i class="fa-solid fa-syringe"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">Insulina basal</div>
                  <p class="gly-safety-note">Generalmente no se suspende completamente. En DM1 siempre debe mantenerse aporte basal.</p>
                </div>
              </div>
              <div class="gly-safety-item">
                <div class="gly-safety-mark ok"><i class="fa-solid fa-utensils"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">Insulina prandial</div>
                  <p class="gly-safety-note">Suspender al iniciar ayuno. Corregir según glicemia y contexto.</p>
                </div>
              </div>
              <div class="gly-safety-item">
                <div class="gly-safety-mark high"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">DM1</div>
                  <p class="gly-safety-note">Nunca dejes al paciente sin basal. El riesgo no es solo hiperglicemia, también cetosis y descompensación metabólica.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="gly-section-card">
          <div class="gly-section-head" onclick="toggleGlySection(this)">
            <div>
              <div class="gly-section-title">Infusión EV: ajuste dinámico</div>
              <div class="gly-section-sub">Usar si cumple criterios de alta variabilidad metabólica</div>
            </div>
            <i class="fa-solid fa-chevron-down gly-section-arrow"></i>
          </div>

          <div class="gly-section-content">
            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Glicemia actual</label>
                <div class="note-input-inline">
                  <input id="evCurrentBg" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mg/dL</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label">Glicemia previa</label>
                <div class="note-input-inline">
                  <input id="evPrevBg" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">mg/dL</div>
                </div>
              </div>
              <div class="note-input-group">
                <label class="note-label">Tasa previa</label>
                <div class="note-input-inline">
                  <input id="evPrevRate" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">U/h</div>
                </div>
              </div>
            </div>

            <div class="note-result-grid-2 mb-3">
              <div class="note-result-card">
                <div class="note-result-card-label">Ajuste sugerido</div>
                <div id="evResultNum" class="note-result-card-value">-</div>
                <div id="evResultText" class="note-result-card-note">Ingresa glicemia actual.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Bolo inicial</div>
                <div id="evBolus" class="note-result-card-value">-</div>
                <div id="evDeltaText" class="note-result-card-note">Sin dato previo.</div>
              </div>
            </div>

            <div id="evDynamicConduct" class="gly-safety-item">
              <div id="evDynamicMark" class="gly-safety-mark mid"><i class="fa-solid fa-clock"></i></div>
              <div class="gly-safety-copy">
                <div id="evDynamicConductTitle" class="gly-safety-title">Interpretación</div>
                <p id="evDynamicConductText" class="gly-safety-note">La infusión EV se ajusta según glicemia actual y cambio respecto a medición previa.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="gly-section-card">
          <div class="gly-section-head" onclick="toggleGlySection(this)">
            <div>
              <div class="gly-section-title">Postoperatorio</div>
              <div class="gly-section-sub">Basal-plus si NPO; basal-bolus si tolera vía oral</div>
            </div>
            <i class="fa-solid fa-chevron-down gly-section-arrow"></i>
          </div>

          <div class="gly-section-content">
            <div class="note-input-group mb-3">
              <label class="note-label">Peso</label>
              <div class="note-input-inline">
                <input id="postopPeso" type="text" inputmode="decimal" class="note-input">
                <div class="note-input-unit">kg</div>
              </div>
            </div>

            <div class="note-section-label">Tolerancia oral</div>
            <div class="gly-choice-grid mb-3">
              <label>
                <input class="gly-option-input" type="radio" name="postop_oral" value="npo" checked>
                <div class="gly-option">
                  <div class="gly-option-title">NPO / mala VO</div>
                  <div class="gly-option-sub">Basal-plus</div>
                </div>
              </label>
              <label>
                <input class="gly-option-input" type="radio" name="postop_oral" value="vo">
                <div class="gly-option">
                  <div class="gly-option-title">VO normal</div>
                  <div class="gly-option-sub">Basal-bolus</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Sensibilidad a insulina</div>
            <div class="gly-choice-grid gly-grid-3 mb-3">
              <label>
                <input class="gly-option-input" type="radio" name="postop_sens" value="sensitive">
                <div class="gly-option">
                  <div class="gly-option-title">Sensible</div>
                  <div class="gly-option-sub">Anciano / TFG baja</div>
                </div>
              </label>
              <label>
                <input class="gly-option-input" type="radio" name="postop_sens" value="usual" checked>
                <div class="gly-option">
                  <div class="gly-option-title">Usual</div>
                  <div class="gly-option-sub">0,2–0,25 U/kg/d</div>
                </div>
              </label>
              <label>
                <input class="gly-option-input" type="radio" name="postop_sens" value="resistant">
                <div class="gly-option">
                  <div class="gly-option-title">Resistente</div>
                  <div class="gly-option-sub">BMI &gt;35 / corticoides</div>
                </div>
              </label>
            </div>

            <div class="note-result-grid-2 mb-3">
              <div class="note-result-card">
                <div class="note-result-card-label">Esquema sugerido</div>
                <div id="postopSchemeNum" class="note-result-card-value">-</div>
                <div id="postopSchemeText" class="note-result-card-note">Ingresa peso.</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">TDD estimada</div>
                <div id="postopTDD" class="note-result-card-value">-</div>
                <div id="postopFactor" class="note-result-card-note">Factor usado.</div>
              </div>
            </div>

            <div class="note-summary-grid-2 mb-3">
              <div class="note-summary-item">
                <div class="note-summary-k">Basal sugerida</div>
                <div id="postopBasal" class="note-summary-v">-</div>
              </div>
              <div class="note-summary-item">
                <div class="note-summary-k">Prandial / corrección</div>
                <div id="postopPrandial" class="note-summary-v">-</div>
              </div>
            </div>

            <div id="postopConduct" class="gly-safety-item mb-3">
              <div id="postopMark" class="gly-safety-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
              <div class="gly-safety-copy">
                <div id="postopConductTitle" class="gly-safety-title">Interpretación</div>
                <p id="postopConductText" class="gly-safety-note">Selecciona contexto clínico para estimar esquema postoperatorio.</p>
              </div>
            </div>

            <div class="gly-safety-list">
              <div class="gly-safety-item">
                <div class="gly-safety-mark mid"><i class="fa-solid fa-mobile-screen"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">Usuarios de bomba</div>
                  <p class="gly-safety-note">Verificar tasa basal, sitio de inserción, glicemias y posibilidad real de continuar manejo seguro en recuperación o sala.</p>
                </div>
              </div>
              <div class="gly-safety-item">
                <div class="gly-safety-mark ok"><i class="fa-solid fa-vial"></i></div>
                <div class="gly-safety-copy">
                  <div class="gly-safety-title">Control</div>
                  <p class="gly-safety-note">Privilegiar laboratorio central si el valor capilar no cuadra con el cuadro clínico o con la hemodinamia.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">La primera decisión no es “cuánta insulina SC doy”, sino “¿este caso necesita vía EV?”</div>
          <div class="note-tips"><strong>Qué hacer:</strong> define estabilidad metabólica, duración quirúrgica, recambio de volumen, inotrópicos, temperatura y tipo de diabetes antes de elegir estrategia.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> perseguir glicemias normales, acumular insulina rápida SC o suspender completamente basal en DM1.</div>
          <div class="note-tips"><strong>Perla:</strong> si el contexto es dinámico, una infusión EV con control horario suele ser más segura que múltiples bolos SC.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> hiperglicemia, hipoglicemia y cetosis son problemas distintos; no los trates como si fueran solo “un número alto”.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;

  function parseLocal(value){
    if(CNS && typeof CNS.parseDecimal === 'function') return CNS.parseDecimal(value);
    const n = Number(String(value || '').replace(',', '.'));
    return Number.isFinite(n) ? n : null;
  }

  function fmt(value, decimals){
    if(!Number.isFinite(value)) return '-';
    if(CNS && typeof CNS.formatNumber === 'function') return CNS.formatNumber(value, decimals);
    return Number(value).toLocaleString('es-CL', {maximumFractionDigits: decimals});
  }

  function round1(num){
    return Math.round(num * 10) / 10;
  }

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function setSafetyBox(prefix, level, icon, title, text){
    const mark = document.getElementById(prefix + 'Mark');
    const titleEl = document.getElementById(prefix + 'Title') || document.getElementById(prefix + 'ConductTitle');
    const textEl = document.getElementById(prefix + 'Text') || document.getElementById(prefix + 'ConductText');
    if(mark){
      mark.className = 'gly-safety-mark ' + level;
      mark.innerHTML = '<i class="fa-solid ' + icon + '"></i>';
    }
    if(titleEl) titleEl.textContent = title;
    if(textEl) textEl.innerHTML = text;
  }

  function contextLabel(mode){
    if(mode === 'yes') return 'Criterios EV';
    if(mode === 'uncertain') return 'Dudoso';
    return 'Caso estable';
  }

  function updateMainCalc(){
    const gly = parseLocal(document.getElementById('glyValue').value);
    const mode = getSelected('ivcriteria') || 'no';
    const tddMode = getSelected('tddmode') || 'unknown';
    let tdd = parseLocal(document.getElementById('tddValue').value);

    if(tddMode === 'unknown' || !tdd || tdd <= 0) tdd = 40;

    const fs = 1800 / tdd;
    const summaryStrategy = document.getElementById('summaryStrategy');

    document.getElementById('summaryGly').textContent = gly && gly > 0 ? fmt(gly,0) + ' mg/dL' : '-';
    document.getElementById('summaryContext').textContent = contextLabel(mode);
    document.getElementById('summaryTdd').textContent = fmt(tdd,1) + ' UI/día';
    document.getElementById('metaFs').textContent = fmt(fs,1);
    document.getElementById('metaControl').textContent = mode === 'yes' ? 'Horario si infusión EV' : 'Cada 2 h mínimo si SC';

    if(!gly || gly <= 0){
      document.getElementById('corrNum').textContent = '-';
      document.getElementById('corrText').textContent = 'Ingresa la glicemia actual.';
      document.getElementById('evInitialRate').textContent = '-';
      document.getElementById('evText').textContent = 'Decide según contexto y glicemia.';
      document.getElementById('metaFormula').textContent = '-';
      document.getElementById('algoMain').textContent = 'Pendiente';
      document.getElementById('algoSoft').textContent = 'Completa glicemia actual para orientar corrección SC o infusión EV.';
      document.getElementById('summaryNarrative').textContent = 'Ingresa glicemia actual y contexto quirúrgico para orientar la estrategia intraoperatoria.';
      summaryStrategy.textContent = 'Pendiente';
      return;
    }

    let scDose = (gly - 100) / fs;
    if(scDose < 0) scDose = 0;
    const scDoseRounded = round1(scDose);
    document.getElementById('metaFormula').textContent = '(' + fmt(gly,0) + ' - 100) / ' + fmt(fs,1);

    if(gly < 70){
      document.getElementById('corrNum').textContent = '0 UI';
      document.getElementById('corrText').textContent = 'Hipoglicemia: no corregir con insulina.';
      document.getElementById('evInitialRate').textContent = 'Suspender';
      document.getElementById('evText').textContent = 'Manejo de hipoglicemia.';
      document.getElementById('algoMain').textContent = 'Hipoglicemia';
      document.getElementById('algoSoft').textContent = 'No administrar insulina. Confirmar valor y tratar según protocolo.';
      summaryStrategy.textContent = 'Tratar hipoglicemia';
    } else if(gly < 140){
      document.getElementById('corrNum').textContent = '0 UI';
      document.getElementById('corrText').textContent = 'Sin corrección.';
      document.getElementById('evInitialRate').textContent = 'No';
      document.getElementById('evText').textContent = 'No iniciar infusión por glicemia.';
      document.getElementById('algoMain').textContent = 'Observación';
      document.getElementById('algoSoft').textContent = 'Bajo o dentro de rango. Vigilar y recontrolar según contexto.';
      summaryStrategy.textContent = 'Observación';
    } else if(gly < 180){
      document.getElementById('corrNum').textContent = '0 UI';
      document.getElementById('corrText').textContent = 'Sobre meta baja, sin umbral habitual de corrección.';
      document.getElementById('evInitialRate').textContent = 'No';
      document.getElementById('evText').textContent = 'Recontrolar.';
      document.getElementById('algoMain').textContent = 'Recontrol sin corrección';
      document.getElementById('algoSoft').textContent = 'Target perioperatorio habitual 140–180 mg/dL. Reevalúa tendencia y contexto.';
      summaryStrategy.textContent = 'Recontrol';
    } else {
      document.getElementById('corrNum').textContent = fmt(scDoseRounded,1) + ' UI';
      document.getElementById('corrText').textContent = 'Insulina rápida SC orientativa.';
      document.getElementById('evInitialRate').textContent = fmt(round1(gly / 100),1) + ' U/h';
      document.getElementById('evText').textContent = 'Si se decide infusión EV; bolo inicial orientativo BG/40.';

      if(mode === 'yes'){
        document.getElementById('algoMain').textContent = 'Preferir insulina EV';
        document.getElementById('algoSoft').textContent = 'Cumple criterios de alta variabilidad metabólica. Usar control horario y ajustar según tendencia.';
        summaryStrategy.textContent = 'Insulina EV';
      } else if(mode === 'uncertain' || gly >= 250){
        document.getElementById('algoMain').textContent = 'Considerar EV antes de acumular SC';
        document.getElementById('algoSoft').textContent = 'La glicemia es alta o el contexto es dudoso. Si hay cirugía prolongada o fisiología dinámica, preferir infusión EV.';
        summaryStrategy.textContent = 'SC vs EV según contexto';
      } else {
        document.getElementById('algoMain').textContent = 'Corrección SC razonable';
        document.getElementById('algoSoft').textContent = 'Caso estable sin criterios EV. Control mínimo cada 2 h y evitar acumulación de insulina rápida.';
        summaryStrategy.textContent = 'Corrección SC';
      }
    }

    document.getElementById('summaryNarrative').textContent =
      'Glicemia ' + fmt(gly,0) + ' mg/dL, ' + contextLabel(mode).toLowerCase() + ', TDD usada ' + fmt(tdd,1) + ' UI/día. Estrategia: ' + summaryStrategy.textContent + '.';
  }

  function updateIVCalculator(){
    const currentBg = parseLocal(document.getElementById('evCurrentBg').value);
    const prevBg = parseLocal(document.getElementById('evPrevBg').value);
    const prevRate = parseLocal(document.getElementById('evPrevRate').value);

    const evResultNum = document.getElementById('evResultNum');
    const evResultText = document.getElementById('evResultText');
    const evBolus = document.getElementById('evBolus');
    const evDeltaText = document.getElementById('evDeltaText');
    const title = document.getElementById('evDynamicConductTitle');
    const text = document.getElementById('evDynamicConductText');
    const mark = document.getElementById('evDynamicMark');

    if(!currentBg || currentBg <= 0){
      evResultNum.textContent = '-';
      evResultText.textContent = 'Ingresa glicemia actual.';
      evBolus.textContent = '-';
      evDeltaText.textContent = 'Sin dato previo.';
      mark.className = 'gly-safety-mark mid';
      mark.innerHTML = '<i class="fa-solid fa-clock"></i>';
      title.textContent = 'Interpretación';
      text.textContent = 'La infusión EV se ajusta según glicemia actual y cambio respecto a medición previa.';
      return;
    }

    evBolus.textContent = currentBg > 180 ? fmt(round1(currentBg / 40),1) + ' UI' : 'No necesario';

    if(!prevBg || prevBg <= 0 || prevRate === null || prevRate < 0){
      evResultNum.textContent = currentBg > 180 ? fmt(round1(currentBg / 100),1) + ' U/h' : 'No iniciar';
      evResultText.textContent = currentBg > 180 ? 'Tasa inicial teórica' : 'No iniciar infusión';
      evDeltaText.textContent = 'Sin dato previo';
      mark.className = currentBg > 180 ? 'gly-safety-mark ok' : 'gly-safety-mark mid';
      mark.innerHTML = currentBg > 180 ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-clock"></i>';
      title.textContent = 'Interpretación';
      text.innerHTML = currentBg > 180
        ? 'Si BG es <strong>&gt;180 mg/dL</strong>, considerar infusión EV. Tasa inicial aproximada: <strong>BG/100 U/h</strong>.'
        : 'Con esta glicemia no hay indicación automática de iniciar infusión EV.';
      return;
    }

    const delta = currentBg - prevBg;
    evDeltaText.textContent = delta > 0 ? 'Aumentó ' + fmt(round1(delta),1) + ' mg/dL' : 'Disminuyó ' + fmt(round1(Math.abs(delta)),1) + ' mg/dL';

    let action = '';
    let newRate = prevRate;
    let level = 'ok';
    let icon = 'fa-check';
    let msg = '';

    if(currentBg > 241){
      if(delta > 0 || Math.abs(delta) < 30){ newRate = prevRate + 3; action = 'Subir +3 U/h'; } else { action = 'Sin cambio'; }
    } else if(currentBg >= 211){
      if(delta > 0 || Math.abs(delta) < 30){ newRate = prevRate + 2; action = 'Subir +2 U/h'; } else { action = 'Sin cambio'; }
    } else if(currentBg >= 181){
      if(delta > 0 || Math.abs(delta) < 30){ newRate = prevRate + 1; action = 'Subir +1 U/h'; } else { action = 'Sin cambio'; }
    } else if(currentBg >= 141){
      action = 'Sin cambio';
    } else if(currentBg >= 110){
      if(delta > 0){ action = 'Sin cambio'; }
      else if(Math.abs(delta) < 30){ newRate = Math.max(0, prevRate - 0.5); action = 'Bajar -0,5 U/h'; }
      else { newRate = 0; action = 'Suspender infusión'; }
    } else if(currentBg >= 100){
      newRate = 0; action = 'Suspender infusión'; level = 'mid'; icon = 'fa-triangle-exclamation';
      msg = 'Suspender infusión, controlar glicemia cada hora y reiniciar a mitad de tasa previa si BG >180 mg/dL.';
    } else if(currentBg >= 71){
      newRate = 0; action = 'Suspender infusión'; level = 'high'; icon = 'fa-triangle-exclamation';
      msg = 'Suspender infusión. Control cada 30 min hasta BG >100 mg/dL. Reiniciar a mitad de tasa previa si BG >180 mg/dL.';
    } else {
      newRate = 0; action = 'Hipoglicemia'; level = 'high'; icon = 'fa-bolt';
      msg = currentBg >= 50
        ? 'BG 50–70 mg/dL: administrar 25 mL de D50 y controlar cada 30 min hasta BG >100 mg/dL.'
        : 'BG <50 mg/dL: administrar 50 mL de D50, controlar cada 15 min hasta >70 mg/dL y luego cada 30 min hasta >100 mg/dL.';
    }

    evResultNum.textContent = action === 'Hipoglicemia' ? 'D50' : fmt(round1(newRate),1) + ' U/h';
    evResultText.textContent = action;

    if(!msg){
      if(action.indexOf('Subir') !== -1) msg = 'Ajuste sugerido según glicemia actual y tendencia respecto de la medición previa.';
      else if(action === 'Sin cambio') msg = 'Mantener tasa actual y continuar control horario.';
      else msg = 'Suspender infusión y vigilar estrechamente la evolución de la glicemia.';
    }

    mark.className = 'gly-safety-mark ' + level;
    mark.innerHTML = '<i class="fa-solid ' + icon + '"></i>';
    title.textContent = 'Interpretación';
    text.innerHTML = msg;
  }

  function updateGLP1Decision(){
    const symptoms = getSelected('glp1symptoms');
    const intake = getSelected('glp1intake');
    const intakeBlock = document.getElementById('glp1IntakeBlock');
    const mark = document.getElementById('glp1Mark');

    if(symptoms === 'yes'){
      intakeBlock.style.display = 'none';
      mark.className = 'gly-safety-mark high';
      mark.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>';
      document.getElementById('glp1ConductTitle').textContent = 'Riesgo aumentado';
      document.getElementById('glp1ConductText').innerHTML = 'Con náuseas severas, vómitos, distensión o mala tolerancia oral, considerar diferir cirugía electiva o manejar como estómago lleno según urgencia.';
      document.getElementById('glp1Fasting').textContent = 'No aplicar tabla';
      document.getElementById('glp1Summary').textContent = 'Primero resolver síntomas y reevaluar.';
      return;
    }

    intakeBlock.style.display = 'block';
    mark.className = 'gly-safety-mark ok';
    mark.innerHTML = '<i class="fa-solid fa-check"></i>';
    document.getElementById('glp1ConductTitle').textContent = 'Conducta GLP-1 RA';
    document.getElementById('glp1ConductText').innerHTML = 'Si no hay síntomas significativos, puede continuarse GLP-1 RA en la mayoría de los pacientes. Individualizar si hay fase de escalamiento de dosis o alto riesgo GI.';

    if(intake === 'solids'){
      document.getElementById('glp1Fasting').textContent = '24 h';
      document.getElementById('glp1Summary').textContent = 'Evitar sólidos 24 h; considerar dieta líquida.';
    } else if(intake === 'highcarb'){
      document.getElementById('glp1Fasting').textContent = '8 h';
      document.getElementById('glp1Summary').textContent = 'Líquidos claros altos en carbohidratos.';
    } else {
      document.getElementById('glp1Fasting').textContent = '4 h';
      document.getElementById('glp1Summary').textContent = 'Líquidos claros bajos o sin carbohidratos.';
    }
  }

  function updatePostopCalc(){
    const peso = parseLocal(document.getElementById('postopPeso').value);
    const oral = getSelected('postop_oral') || 'npo';
    const sens = getSelected('postop_sens') || 'usual';

    if(!peso || peso <= 0){
      document.getElementById('postopSchemeNum').textContent = '-';
      document.getElementById('postopSchemeText').textContent = 'Ingresa peso.';
      document.getElementById('postopTDD').textContent = '-';
      document.getElementById('postopFactor').textContent = 'Factor usado.';
      document.getElementById('postopBasal').textContent = '-';
      document.getElementById('postopPrandial').textContent = '-';
      document.getElementById('postopMark').className = 'gly-safety-mark mid';
      document.getElementById('postopMark').innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>';
      document.getElementById('postopConductTitle').textContent = 'Interpretación';
      document.getElementById('postopConductText').textContent = 'Selecciona contexto clínico para estimar esquema postoperatorio.';
      return;
    }

    let factor = 0.2;
    let factorLabel = '0,2–0,25 U/kg/día';
    if(sens === 'sensitive'){ factor = 0.125; factorLabel = '0,1–0,15 U/kg/día'; }
    else if(sens === 'resistant'){ factor = 0.3; factorLabel = '0,3 U/kg/día'; }

    const tdd = peso * factor;
    document.getElementById('postopTDD').textContent = fmt(round1(tdd),1) + ' U/día';
    document.getElementById('postopFactor').textContent = factorLabel;
    document.getElementById('postopMark').className = 'gly-safety-mark ok';
    document.getElementById('postopMark').innerHTML = '<i class="fa-solid fa-check"></i>';
    document.getElementById('postopConductTitle').textContent = 'Conducta sugerida';

    if(oral === 'npo'){
      document.getElementById('postopSchemeNum').textContent = 'Basal-plus';
      document.getElementById('postopSchemeText').textContent = 'NPO o mala tolerancia oral.';
      document.getElementById('postopBasal').textContent = fmt(round1(tdd),1) + ' U/día basal';
      document.getElementById('postopPrandial').textContent = 'Corrección rápida si BG >180 mg/dL';
      document.getElementById('postopConductText').innerHTML = 'Usar <strong>basal-plus</strong>: basal diaria y corrección con insulina rápida si BG &gt;180 mg/dL.';
    } else {
      const basal = tdd * 0.5;
      const prandial = tdd * 0.5;
      const mealDose = prandial / 3;
      document.getElementById('postopSchemeNum').textContent = 'Basal-bolus';
      document.getElementById('postopSchemeText').textContent = 'Paciente con vía oral normal.';
      document.getElementById('postopBasal').textContent = fmt(round1(basal),1) + ' U/día basal';
      document.getElementById('postopPrandial').textContent = fmt(round1(prandial),1) + ' U/día prandial (~' + fmt(round1(mealDose),1) + ' U/comida)';
      document.getElementById('postopConductText').innerHTML = 'Usar <strong>basal-bolus</strong>: 50% basal y 50% prandial, más corrección si BG &gt;180 mg/dL.';
    }
  }

  document.getElementById('glyValue').addEventListener('input', updateMainCalc);
  document.getElementById('tddValue').addEventListener('input', updateMainCalc);
  document.getElementById('evCurrentBg').addEventListener('input', updateIVCalculator);
  document.getElementById('evPrevBg').addEventListener('input', updateIVCalculator);
  document.getElementById('evPrevRate').addEventListener('input', updateIVCalculator);
  document.getElementById('postopPeso').addEventListener('input', updatePostopCalc);

  document.querySelectorAll('input[name="ivcriteria"], input[name="tddmode"]').forEach(function(el){
    el.addEventListener('change', updateMainCalc);
  });
  document.querySelectorAll('input[name="glp1symptoms"], input[name="glp1intake"]').forEach(function(el){
    el.addEventListener('change', updateGLP1Decision);
  });
  document.querySelectorAll('input[name="postop_oral"], input[name="postop_sens"]').forEach(function(el){
    el.addEventListener('change', updatePostopCalc);
  });

  updateMainCalc();
  updateIVCalculator();
  updateGLP1Decision();
  updatePostopCalc();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

function toggleGlySection(head){
  const section = head.closest('.gly-section-card');
  section.classList.toggle('is-open');
}
</script>

<?php include("footer.php"); ?>
