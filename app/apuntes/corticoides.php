<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para estimar riesgo de supresión del eje hipotálamo-hipófisis-suprarrenal en pacientes con uso crónico de glucocorticoides y proponer suplementación perioperatoria según magnitud del procedimiento. Incluye conversión interna a equivalentes de prednisona y sugerencia de manejo inmediato postoperatorio.";
$formula = "La nota convierte la dosis diaria habitual del corticoide a mg equivalentes de prednisona. Regla práctica docente: >5 mg/día de prednisona o equivalente debe hacer pensar en supresión posible del eje, especialmente si el uso ha sido prolongado o se suspendió en los últimos 3 meses. La suplementación se escala según el estrés quirúrgico.";
$referencias = array(
  "1.- Nazar C, Bastidas J, Zamora M, Coloma R, Fuentes R. Manejo perioperatorio de pacientes con patología tiroidea y tratamiento crónico con corticoides. Rev Chil Cir. 2016;68(1):87-93.",
  "2.- Woodcock T, Barker P, Daniel S, et al. Guidelines for the management of glucocorticoids during the peri-operative period for patients with adrenal insufficiency. Anaesthesia. 2020;75(5):654-663.",
  "3.- OpenAnesthesia. Adrenal Insufficiency and Perioperative Corticosteroids. Actualizado 24 mayo 2024.",
  "4.- Miggelbrink LA, Marsman M, van de Wetering J, van Klei WA, Kappen TH. Peri-operative corticosteroid supplementation guideline adherence. Anaesthesia. 2025;80(4):454-455.",
  "5.- RCCC. Cálculo equivalencias de corticoides. Tabla práctica de equivalencias y dosis aproximadas supresoras del eje HH."
);

$icono_apunte = "<i class='fa-solid fa-capsules pe-3 pt-2'></i>";
$titulo_apunte = "Suplementación de Corticoides Perioperatorios";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; border:0; --bs-border-opacity:0;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="steroid-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --bg:#f4f7fb;
            --soft:#f8fafc;
            --line:#dfe7f2;
            --text:#1f2a37;
            --muted:#667085;
            --good:#edf8f7;
            --warn:#fff9e8;
            --danger:#fff5f3;
            --mint:#eef7ff;
            --mint-border:#cfe1ff;
          }

          body{background:var(--bg);}
          .steroid-shell{max-width:1060px;margin:0 auto;}

          .steroid-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .steroid-topbar h1{color:#fff;}

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

          .pill{
            display:inline-block;
            padding:.2rem .55rem;
            border-radius:999px;
            font-size:.78rem;
            background:#eef3ff;
            color:#3559b7;
            font-weight:600;
          }

          .subtle{font-size:.94rem;color:#5f6b76;}
          .small-note{font-size:.82rem;color:#667085;line-height:1.45;}
          .footer-note{font-size:.82rem;color:#6c757d;}

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
            color:white;
            transition:.2s;
          }

          .info-toggle-btn:hover{
            background:#5a6268;
            color:white;
          }

          .info-box-content{
            padding:1rem;
            display:none;
            animation:fadeIn .2s ease-in-out;
            border-top:1px solid #e9eef5;
          }

          @keyframes fadeIn{
            from{opacity:0; transform:translateY(-5px);}
            to{opacity:1; transform:translateY(0);}
          }

          .calc-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:1rem;
          }

          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .choice-grid-2,
          .choice-grid-3,
          .choice-grid-4{
            display:grid;
            gap:.6rem;
          }

          .choice-grid-2{grid-template-columns:repeat(2,1fr);}
          .choice-grid-3{grid-template-columns:repeat(3,1fr);}
          .choice-grid-4{grid-template-columns:repeat(4,1fr);}

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            justify-content:center;
            text-align:left;
            min-height:74px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:.9rem;
            padding:.72rem .8rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.12;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
            font-size:.9rem;
          }

          .choice-btn small{
            font-weight:500;
            color:#667085;
            margin-top:.15rem;
            line-height:1.22;
            font-size:.72rem;
          }

          .choice-btn i{
            font-size:1rem;
            margin-bottom:.28rem;
            color:#3559b7;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
            transform:translateY(-1px);
          }

          .form-label-lite{
            font-size:.92rem;
            font-weight:600;
            color:var(--text);
            margin-bottom:.35rem;
          }

          .summary-grid{
            display:grid;
            grid-template-columns:repeat(5,1fr);
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
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
          }

          .main-result-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
          }
          .dose-result-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
            margin-top:1rem;
          }

          .dose-result-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .dose-result-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .dose-result-value{
            font-size:1.55rem;
            font-weight:800;
            line-height:1.15;
            color:#27458f;
          }
          .main-result-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .main-result-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .main-result-value{
            font-size:1.9rem;
            font-weight:800;
            line-height:1.05;
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
            min-width:230px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid #ecd798;
            border-radius:1rem;
            padding:1rem;
          }

          .danger-box{
            background:var(--danger);
            border:1px solid #efc4be;
            border-radius:1rem;
            padding:1rem;
          }

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{margin-bottom:.45rem;}

          @media (max-width:980px){
            .summary-grid{grid-template-columns:repeat(3,1fr);}
          }

          @media (max-width:900px){
            .choice-grid-4{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
            .summary-grid{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:576px){
            .choice-grid-4,.choice-grid-3,.choice-grid-2{grid-template-columns:repeat(2,1fr);}
            .summary-grid{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="steroid-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • endocrino perioperatorio</div>
              <h1 class="h3 mb-2">Suplementación de Corticoides Perioperatorios</h1>
              <div class="subtle text-white-50">Conversión a prednisona equivalente, riesgo de supresión del eje y cobertura intra/postoperatoria.</div>
            </div>
            <span class="pill bg-light text-dark">Stress dose</span>
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
          </div>
        </div>

        <!-- A. DATOS -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">A. Datos de entrada</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Glucocorticoide habitual</label>
                <div class="choice-grid-4 mb-3">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_prednisone" value="prednisone" checked>
                    <label class="choice-btn" for="st_prednisone">
                      <i class="fa-solid fa-tablets"></i>
                      Prednisona
                      <small>5 mg = ref</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_prednisolone" value="prednisolone">
                    <label class="choice-btn" for="st_prednisolone">
                      <i class="fa-solid fa-tablets"></i>
                      Prednisolona
                      <small>5 mg = ref</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_methylpred" value="methylpred">
                    <label class="choice-btn" for="st_methylpred">
                      <i class="fa-solid fa-syringe"></i>
                      Metilpred
                      <small>4 mg = 5 mg pred</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_hydrocortisone" value="hydrocortisone">
                    <label class="choice-btn" for="st_hydrocortisone">
                      <i class="fa-solid fa-capsules"></i>
                      Hidrocortisona
                      <small>20 mg = 5 mg pred</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_dexamethasone" value="dexamethasone">
                    <label class="choice-btn" for="st_dexamethasone">
                      <i class="fa-solid fa-bolt"></i>
                      Dexametasona
                      <small>0,75 mg = 5 mg pred</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_betamethasone" value="betamethasone">
                    <label class="choice-btn" for="st_betamethasone">
                      <i class="fa-solid fa-bolt"></i>
                      Betametasona
                      <small>0,75 mg = 5 mg pred</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_triamcinolone" value="triamcinolone">
                    <label class="choice-btn" for="st_triamcinolone">
                      <i class="fa-solid fa-vial"></i>
                      Triamcinolona
                      <small>4 mg = 5 mg pred</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="steroid" id="st_cortisone" value="cortisone">
                    <label class="choice-btn" for="st_cortisone">
                      <i class="fa-solid fa-vial"></i>
                      Cortisona
                      <small>25 mg = 5 mg pred</small>
                    </label>
                  </div>
                </div>

                <label class="form-label-lite">Dosis diaria habitual</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="dailyDose" value="">
                  <span class="input-group-text">mg/día</span>
                </div>

                <label class="form-label-lite">Duración de uso</label>
                <div class="choice-grid-3">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="duration" id="dur_short" value="lt3w">
                    <label class="choice-btn" for="dur_short">
                      <i class="fa-regular fa-clock"></i>
                      &lt;3 semanas
                      <small>menor riesgo</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="duration" id="dur_long" value="gt3w" checked>
                    <label class="choice-btn" for="dur_long">
                      <i class="fa-solid fa-hourglass-half"></i>
                      &gt;3 semanas
                      <small>más relevante</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="duration" id="dur_unknown" value="unknown">
                    <label class="choice-btn" for="dur_unknown">
                      <i class="fa-solid fa-circle-question"></i>
                      Desconocida
                      <small>ser conservador</small>
                    </label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Situación clínica del eje</label>
                <div class="choice-grid-4 mb-3">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="axisStatus" id="axis_none" value="none" checked>
                    <label class="choice-btn" for="axis_none">
                      <i class="fa-regular fa-circle"></i>
                      Sin diagnóstico
                      <small>evaluar por dosis</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="axisStatus" id="axis_primary" value="Primaria">
                    <label class="choice-btn" for="axis_primary">
                      <i class="fa-solid fa-triangle-exclamation"></i>
                      Primaria
                      <small>Addison / adrenal</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="axisStatus" id="axis_secondary" value="Secundaria">
                    <label class="choice-btn" for="axis_secondary">
                      <i class="fa-solid fa-brain"></i>
                      Secundaria
                      <small>hipófisis</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="axisStatus" id="axis_tertiary" value="Terciaria">
                    <label class="choice-btn" for="axis_tertiary">
                      <i class="fa-solid fa-capsules"></i>
                      Terciaria
                      <small>supresión exógena</small>
                    </label>
                  </div>
                </div>

                <label class="form-label-lite">Factores que suben sospecha</label>
                <div class="choice-grid-2 mb-3">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="recentStop" id="recentStop_no" value="no" checked>
                    <label class="choice-btn" for="recentStop_no">
                      <i class="fa-solid fa-ban"></i>
                      No suspendido
                      <small>continúa terapia</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="recentStop" id="recentStop_yes" value="yes">
                    <label class="choice-btn" for="recentStop_yes">
                      <i class="fa-solid fa-arrow-rotate-left"></i>
                      Suspendido &lt;3 meses
                      <small>seguir considerándolo</small>
                    </label>
                  </div>
                </div>

                <label class="form-label-lite">Tipo de procedimiento</label>
                <div class="choice-grid-4">
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="surgery" id="sx_superficial" value="superficial">
                    <label class="choice-btn" for="sx_superficial">
                      <i class="fa-solid fa-bandage"></i>
                      Superficial
                      <small>biopsia, dental</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="surgery" id="sx_minor" value="minor" checked>
                    <label class="choice-btn" for="sx_minor">
                      <i class="fa-solid fa-scissors"></i>
                      Menor
                      <small>hernioplastía, colonoscopia</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="surgery" id="sx_moderate" value="moderate">
                    <label class="choice-btn" for="sx_moderate">
                      <i class="fa-solid fa-hospital"></i>
                      Moderado
                      <small>cole, colectomía</small>
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger-radio" type="radio" name="surgery" id="sx_major" value="major">
                    <label class="choice-btn" for="sx_major">
                      <i class="fa-solid fa-heart-pulse"></i>
                      Severo / UCI
                      <small>cardio, Whipple, shock</small>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- B. RESUMEN -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Tarjeta resumen</div>

            <div class="summary-grid">
              <div class="summary-card">
                <div class="summary-label">Droga</div>
                <div id="sumDrug" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Dosis habitual</div>
                <div id="sumDose" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Prednisona eq.</div>
                <div id="sumPredEq" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Riesgo eje</div>
                <div id="sumAxis" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Procedimiento</div>
                <div id="sumSurgery" class="summary-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <!-- C. RESULTADO PRINCIPAL -->
        <!-- C. RESULTADO PRINCIPAL -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Resultado principal</div>

            <div class="main-result-card">
              <div class="main-result-label">Conducta sugerida</div>
              <div class="main-result-note">Basada en prednisona equivalente, contexto del eje y magnitud del estrés quirúrgico</div>
              <div id="mainDecision" class="main-result-value">-</div>
            </div>

            <div class="dose-result-card">
              <div class="dose-result-label">Suplementación perioperatoria sugerida</div>
              <div class="dose-result-note">Dosis operativa rápida para el día de cirugía y postoperatorio inmediato</div>
              <div id="mainDosePlan" class="dose-result-value">-</div>
            </div>

            <div class="mt-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Interpretación del eje</div>
                  <div class="result-note">Riesgo clínico de respuesta insuficiente al estrés quirúrgico.</div>
                </div>
                <div id="outAxisInterp" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Dosis del día de cirugía</div>
                  <div class="result-note">Suplementación perioperatoria inmediata cuando corresponde.</div>
                </div>
                <div id="outDaySurgery" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Postoperatorio inmediato</div>
                  <div class="result-note">Primeras 24–48 h o manejo inicial de paciente crítico.</div>
                </div>
                <div id="outPostop" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Equivalente en metilprednisolona</div>
                  <div class="result-note">Alternativa útil si no usarás hidrocortisona.</div>
                </div>
                <div id="outMethylEq" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Retorno a dosis basal</div>
                  <div class="result-note">Cuándo simplificar el esquema.</div>
                </div>
                <div id="outReturn" class="result-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <!-- D. INTERPRETACIÓN -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Interpretación clínica</div>

            <div id="riskBox" class="good-box">
              <strong id="riskTitle">Lectura clínica</strong><br>
              <div id="riskText" class="small-note mt-2">
                Ingresa la dosis diaria del corticoide y confirma el tipo de cirugía para activar la recomendación.
              </div>
            </div>

            <div id="anesthBox" class="warn-box mt-3">
              <strong>Implicancias anestésicas</strong><br>
              <div id="anesthText" class="small-note mt-2">-</div>
            </div>

            <div id="caveatBox" class="mint-box mt-3">
              <strong>Limitaciones / cautelas</strong><br>
              <div id="caveatText" class="small-note mt-2">-</div>
            </div>
          </div>
        </div>

        <!-- E. DOCENCIA -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Tips docentes</div>

            <div class="warn-box">
              <ul class="tip-list">
                <li>La pregunta importante no es solo “usa corticoides”, sino si el paciente puede montar una respuesta adecuada al estrés.</li>
                <li>Regla docente útil: más de 5 mg/día de prednisona equivalente merece manejo prudente, aunque no siempre exista prueba formal de supresión.</li>
                <li>Los pacientes con insuficiencia suprarrenal primaria, secundaria o terciaria conocida deben tratarse como de alto riesgo aunque su dosis actual parezca baja.</li>
                <li>En procedimientos muy menores o exposición baja y breve, muchas veces basta con la dosis basal. No sobretrates por reflejo.</li>
                <li>La suplementación es para prevenir hipotensión, shock y fracaso de respuesta al estrés, no para analgesia ni profilaxis de NVPO.</li>
                <li>Los corticoides perioperatorios también tienen costo: hiperglicemia, infección, debilidad muscular y mala cicatrización si se usan en exceso.</li>
                <li>Si hay hipotensión refractaria, hiponatremia, hiperkalemia, hipoglicemia o shock distributivo, piensa en crisis suprarrenal y actúa antes de “confirmar” todo.</li>
                <li>La evidencia moderna sigue siendo imperfecta; por eso esta nota privilegia una conducta conservadora y clínicamente segura.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. No reemplaza juicio endocrinológico ni manejo de crisis suprarrenal establecida. Si el contexto es séptico, en shock o de UCI, prioriza la clínica por sobre el algoritmo.
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

function steroidLabel(v){
  const map = {
    prednisone:'Prednisona',
    prednisolone:'Prednisolona',
    methylpred:'Metilprednisolona',
    hydrocortisone:'Hidrocortisona',
    dexamethasone:'Dexametasona',
    betamethasone:'Betametasona',
    triamcinolone:'Triamcinolona',
    cortisone:'Cortisona'
  };
  return map[v] || '-';
}

function surgeryLabel(v){
  const map = {
    superficial:'Superficial',
    minor:'Menor',
    moderate:'Moderado',
    major:'Severo / UCI'
  };
  return map[v] || '-';
}

function getPredEqFactor(steroid){
  const factors = {
    prednisone:1,
    prednisolone:1,
    methylpred:5/4,
    hydrocortisone:5/20,
    dexamethasone:5/0.75,
    betamethasone:5/0.75,
    triamcinolone:5/4,
    cortisone:5/25
  };
  return factors[steroid] || 1;
}

function updateSteroidNote(){
  const steroid = getSelected('steroid') || 'prednisone';
  const dose = parseFloat(document.getElementById('dailyDose').value);
  const duration = getSelected('duration') || 'gt3w';
  const axisStatus = getSelected('axisStatus') || 'none';
  const recentStop = getSelected('recentStop') || 'no';
  const surgery = getSelected('surgery') || 'minor';

  const predEq = (!isNaN(dose) && dose > 0) ? dose * getPredEqFactor(steroid) : NaN;

  document.getElementById('sumDrug').textContent = steroidLabel(steroid);
  document.getElementById('sumDose').textContent = (!isNaN(dose) && dose > 0) ? fmt(dose,1) + ' mg/día' : '-';
  document.getElementById('sumPredEq').textContent = (!isNaN(predEq)) ? fmt(predEq,1) + ' mg pred/día' : '-';
  document.getElementById('sumAxis').textContent = axisStatus === 'none' ? 'Por exposición' : axisStatus.charAt(0).toUpperCase() + axisStatus.slice(1);
  document.getElementById('sumSurgery').textContent = surgeryLabel(surgery);

  if(isNaN(dose) || dose <= 0){
    document.getElementById('mainDecision').textContent = '-';
    document.getElementById('mainDosePlan').innerHTML = '-';
    document.getElementById('outAxisInterp').textContent = '-';
    document.getElementById('outDaySurgery').textContent = '-';
    document.getElementById('outPostop').textContent = '-';
    document.getElementById('outMethylEq').textContent = '-';
    document.getElementById('outReturn').textContent = '-';
    document.getElementById('riskTitle').textContent = 'Lectura clínica';
    document.getElementById('riskText').textContent = 'Ingresa la dosis diaria del corticoide y confirma el tipo de cirugía para activar la recomendación.';
    document.getElementById('riskBox').className = 'good-box';
    document.getElementById('anesthText').textContent = '-';
    document.getElementById('caveatText').textContent = '-';
    return;
  }

  let highRisk = false;
  let axisInterp = '';

  if(axisStatus !== 'none'){
    highRisk = true;
    axisInterp = 'Insuficiencia suprarrenal conocida';
  } else if(recentStop === 'yes'){
    highRisk = true;
    axisInterp = 'Riesgo persistente por suspensión reciente';
  } else if(predEq > 20 && duration !== 'lt3w'){
    highRisk = true;
    axisInterp = 'Supresión del eje muy probable';
  } else if(predEq > 5 && duration !== 'lt3w'){
    highRisk = true;
    axisInterp = 'Supresión del eje probable';
  } else if(predEq <= 5 && duration === 'lt3w'){
    highRisk = false;
    axisInterp = 'Riesgo clínico bajo';
  } else if(predEq <= 5){
    highRisk = false;
    axisInterp = 'Riesgo bajo, pero contexto importa';
  } else {
    highRisk = false;
    axisInterp = 'Zona gris';
  }

  let mainDecision = '';
  let daySurgery = '';
  let postop = '';
  let methylEq = '';
  let returnPlan = '';
  let riskTitle = '';
  let riskText = '';
  let riskClass = 'good-box';
  let mainDosePlan = '';

  if(!highRisk){
    if(surgery === 'superficial'){
      mainDecision = 'Solo dosis basal';
      daySurgery = 'Sin suplemento adicional';
      postop = 'Sin esquema suplementario';
      methylEq = 'No aplica';
      returnPlan = 'Continuar esquema habitual';
      riskTitle = 'Probable no supresión del eje';
      riskText = 'Con exposición baja y breve, o sin datos fuertes de supresión, un procedimiento superficial rara vez exige stress dose.';
      riskClass = 'good-box';
    } else if(predEq <= 5){
      mainDecision = 'Basal ± vigilancia';
      daySurgery = 'Mantener dosis basal el día de cirugía';
      postop = 'Sin suplemento sistemático';
      methylEq = 'No aplica';
      returnPlan = 'Retomar o mantener basal';
      riskTitle = 'Riesgo bajo';
      riskText = 'La tabla de Nazar y cols. deja claro que ≤5 mg/día de prednisona equivalente suele manejarse con la dosis basal. Si la historia es poco confiable o el contexto es de alto estrés, sé más prudente.';

      riskClass = 'warn-box';
    } else {
      mainDecision = 'Valorar caso a caso';
      daySurgery = 'Considerar 25 mg hidrocortisona EV si hay duda real';
      postop = 'Observación clínica y hemodinámica';
      methylEq = '≈ 5 mg metilpred EV';
      returnPlan = 'Volver a basal precozmente';
      riskTitle = 'Zona gris';
      riskText = 'Cuando la exposición está en terreno intermedio o la duración no es clara, el cálculo solo no basta. En duda razonable, es preferible una cobertura modesta.';
      riskClass = 'warn-box';
    }
  } else {
    if(surgery === 'superficial'){
      mainDecision = 'Basal / mínima cobertura';
      daySurgery = 'Mantener dosis habitual; generalmente sin stress dose adicional';
      postop = 'Sin suplemento adicional si estable';
      methylEq = 'No suele requerirse';
      returnPlan = 'Continuar basal';
      riskTitle = 'Riesgo endocrino real, bajo estrés quirúrgico';
      riskText = 'Aunque el eje parezca suprimido, una cirugía realmente superficial no necesita el mismo esquema que una laparotomía o una cirugía cardíaca.';
      riskClass = 'warn-box';
    }

    if(surgery === 'minor'){
      mainDecision = 'Suplementación menor';
      daySurgery = '25 mg hidrocortisona EV';
      postop = 'Luego continuar dosis basal habitual';
      methylEq = '≈ 5 mg metilpred EV';
      returnPlan = 'Retomar basal el mismo día o al reiniciar VO';
      riskTitle = 'Supresión probable + cirugía menor';
      riskText = 'Para cirugía menor, la cobertura sugerida es limitada y no debe extenderse innecesariamente.';
      riskClass = 'warn-box';
    }

    if(surgery === 'moderate'){
      mainDecision = 'Suplementación 24–48 h';
      daySurgery = '50–75 mg hidrocortisona EV';
      postop = 'Mantener cobertura y volver progresivamente a basal en 24–48 h';
      methylEq = '≈ 10–15 mg metilpred EV';
      returnPlan = 'Descenso a basal dentro de 24–48 h si estable';
      riskTitle = 'Supresión probable + cirugía moderada';
      riskText = 'Aquí el estrés ya es relevante. El objetivo es prevenir respuesta insuficiente al trauma quirúrgico, no “dar corticoides por si acaso”.';
      riskClass = 'danger-box';
    }

    if(surgery === 'major'){
      mainDecision = 'Suplementación alta / paciente crítico';
      daySurgery = '100–150 mg hidrocortisona EV';
      postop = 'Si cirugía mayor: volver progresivamente a basal en 24–48 h. Si shock/UCI: 50–100 mg c/6–8 h inicialmente';
      methylEq = '≈ 20–30 mg metilpred EV';
      returnPlan = 'Taper progresivo; más lento si UCI, sepsis o inestabilidad';
      riskTitle = 'Supresión probable + cirugía severa o UCI';
      riskText = 'En cirugía mayor o paciente crítico, la incapacidad de responder al estrés puede traducirse en hipotensión refractaria o shock. Aquí la cobertura sí debe ser agresiva.';
      riskClass = 'danger-box';
    }
  }

    if(daySurgery === 'Sin suplemento adicional' || daySurgery === 'Mantener dosis basal el día de cirugía'){
    mainDosePlan = daySurgery + '<br><span class="small-note">' + postop + '</span>';
  } else {
    mainDosePlan = daySurgery + '<br><span class="small-note">' + postop + '</span>';
  }

  let anesthText = 'El déficit de cortisol reduce tono vascular y respuesta a catecolaminas, por lo que puede aparecer hipotensión desproporcionada tras inducción, vasoplejía o shock distributivo. Además, pueden coexistir hiponatremia, hiperkalemia e hipoglicemia.';
  if(surgery === 'major'){
    anesthText += ' En cirugía severa o UCI, la reevaluación clínica y hemodinámica pesa más que la belleza del esquema inicial.';
  }

  let caveatText = 'Las recomendaciones perioperatorias sobre stress dose no están apoyadas por evidencia perfecta y varias guías difieren en intensidad. Este apunte privilegia una estrategia conservadora y práctica.';
  if(recentStop === 'yes'){
    caveatText += ' La suspensión en los últimos 3 meses no elimina el riesgo de supresión.';
  }
  if(axisStatus !== 'none'){
    caveatText += ' Si ya existe insuficiencia suprarrenal diagnosticada, no simplifiques por una dosis habitual aparentemente baja.';
  }

  document.getElementById('mainDecision').textContent = mainDecision;
  document.getElementById('mainDosePlan').innerHTML = mainDosePlan;
  document.getElementById('outAxisInterp').textContent = axisInterp;
  document.getElementById('outDaySurgery').innerHTML = daySurgery;
  document.getElementById('outPostop').innerHTML = postop;
  document.getElementById('outMethylEq').innerHTML = methylEq;
  document.getElementById('outReturn').innerHTML = returnPlan;

  document.getElementById('riskTitle').textContent = riskTitle;
  document.getElementById('riskText').textContent = riskText;
  document.getElementById('riskBox').className = riskClass;
  document.getElementById('anesthText').textContent = anesthText;
  document.getElementById('caveatText').textContent = caveatText;
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', updateSteroidNote);
    el.addEventListener('change', updateSteroidNote);
  });

  document.querySelectorAll('.calc-trigger-radio').forEach(el => {
    el.addEventListener('change', updateSteroidNote);
  });

  updateSteroidNote();
});
</script>

<?php require("footer.php"); ?>