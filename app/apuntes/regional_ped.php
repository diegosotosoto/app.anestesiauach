<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Calculadora interactiva de anestesia regional pediátrica. Relaciona edad, tipo de bloqueo, anestésico local, concentración y volumen para estimar volumen final, dosis total en mg, porcentaje de dosis máxima y nivel de riesgo.";
$formula = "La dosis clínica final depende de 5 factores: edad, tipo de bloqueo, anestésico local, concentración y volumen elegido. En menores de 6 meses debe reducirse la dosis máxima permitida en 30–50%; esta herramienta usa un ajuste conservador del 50%.";
$referencias = array(
  "1.- Armitage E. Caudal block in children. Anaesthesia, 1979.",
  "2.- StatPearls - Pediatric Regional Anesthesia. Feehan T, Packiasabapathy S. 2023.",
  "3.- OpenAnesthesia. Regional Anesthesia in Children: An Overview. 2024.",
  "4.- Suresh S, et al. ESRA/ASRA Recommendations on Local Anesthetics and Adjuvants Dosage in Pediatric Regional Anesthesia. 2018.",
  "5.- NYSORA. Peripheral Nerve Blocks for Children.",
  "6.- Marhofer P, et al. Pediatric Regional Anesthesia: A Practical Guideline for Daily Clinical Practice. Anesthesiology, 2025.",
  "7.- Ivani G, et al. Practice Advisory on Controversial Topics in Pediatric Regional Anesthesia. Reg Anesth Pain Med, 2015."
);

$icono_apunte = "<i class='fa-solid fa-hand-holding-medical pe-3 pt-2'></i>";
$titulo_apunte = "Anestesia Regional Pediátrica";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="pedra-shell">

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
          .pedra-shell{max-width:980px;margin:0 auto;}

          .topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }
          .topbar h1{color:#fff;}

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
          .small-note{font-size:.84rem;color:var(--muted);line-height:1.45;}
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
          .info-toggle-btn:hover{background:#5a6268;color:white;}
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



.choice-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:.65rem;
}

.choice-grid-3{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:.65rem;
}

.choice-grid-2{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:.65rem;
}

.choice-check{
  display:none;
}

.choice-btn{
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  text-align:center;

  /* CLAVE: eliminar cuadrado forzado */
  aspect-ratio:auto;

  min-height:58px;
  height:64px;

  border:2px solid #dfe7f2;
  background:#fff;
  border-radius:.85rem;
  padding:.45rem .5rem;

  font-weight:700;
  font-size:.92rem;
  color:#1f2a37;

  cursor:pointer;
  transition:.15s ease;
  line-height:1.05;

  box-shadow:0 3px 10px rgba(0,0,0,.04);
}

.choice-btn i{
  font-size:.85rem;
  margin-bottom:.12rem;
  color:#3559b7;
}

.choice-check:checked + .choice-btn{
  transform:translateY(-1px);
  box-shadow:0 8px 18px rgba(0,0,0,.12);
  border:3px solid #3b82f6;
  background:#eef4ff;  
}


.btn-age{background:#f5f9ff;}
.btn-block{background:#fafcff;}
.btn-la{background:#fffdfa;}
.btn-vol{background:#f7fbf8;}


          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .form-label-lite{
            font-size:.92rem;
            font-weight:700;
            color:var(--text);
            margin-bottom:.5rem;
          }

          .result-box{
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
            padding:1rem;
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
            margin-bottom:.7rem;
          }
          .result-row:last-child{margin-bottom:0;}

          .result-name{
            font-weight:800;
            color:#1f2a37;
            line-height:1.2;
          }

          .result-note{
            font-size:.84rem;
            color:#667085;
            margin-top:.2rem;
            line-height:1.45;
          }

          .result-value{
            min-width:180px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .meta-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.75rem;
          }

          .meta-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.95rem;
          }

          .meta-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#667085;
            margin-bottom:.25rem;
          }

          .meta-value{
            font-size:1rem;
            font-weight:800;
            color:#1f2a37;
            line-height:1.35;
          }

          .highlight-dose{
            border-radius:1rem;
            padding:1.2rem;
            background:#eef7ff;
            border:1px solid #cfe1ff;
            text-align:center;
          }

          .highlight-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#3559b7;
            margin-bottom:.45rem;
            font-weight:700;
          }

          .highlight-main{
            font-size:1.45rem;
            font-weight:900;
            color:#1f2a37;
            line-height:1.2;
          }

          .highlight-soft{
            margin-top:.55rem;
            font-size:.92rem;
            color:#5f6b76;
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

          .teaching-wrap{
            border-radius:1.3rem;
            background:#f4f7fb;
            padding:1.2rem;
          }

          .teaching-title{
            text-align:center;
            font-size:.9rem;
            text-transform:uppercase;
            color:#64748b;
            letter-spacing:.05em;
          }

          .teaching-main{
            text-align:center;
            font-size:1.55rem;
            font-weight:800;
            margin-bottom:1rem;
            line-height:1.15;
          }

          .teaching-card{
            background:#fff;
            border-radius:1rem;
            padding:1rem;
            border:1px solid #e5e7eb;
            margin-bottom:.8rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }
          .tip-list li{margin-bottom:.42rem;}

          .risk-ok{
            color:#0f766e;
            font-weight:800;
          }
          .risk-warn{
            color:#b45309;
            font-weight:800;
          }
          .risk-bad{
            color:#b42318;
            font-weight:900;
          }

          @media(max-width:900px){
            .choice-grid{grid-template-columns:repeat(2,1fr);}
            .meta-grid{grid-template-columns:1fr 1fr;}
          }

          @media(max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .choice-grid-3{grid-template-columns:1fr;}
            .choice-grid-2{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
            .teaching-main{font-size:1.25rem;}
          }

          @media(max-width:576px){
            .choice-grid{grid-template-columns:1fr;}
            .meta-grid{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }

          .plan-summary-label{
            font-size:.78rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#3559b7;
            font-weight:700;
            margin-bottom:.35rem;
          }

          .plan-summary-card{
            background:#eef7ff;
            border:1px solid #cfe1ff;
            border-radius:1rem;
            padding:.8rem .95rem;
          }

          .plan-summary-text{
            font-size:1rem;
            line-height:1.35;
            font-weight:800;
            color:#1f2a37;
          }

@media(max-width:768px){
  .calc-grid{
    grid-template-columns:1fr;
  }

  .choice-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .choice-grid-3{
    grid-template-columns:repeat(3,1fr);
  }

  .choice-grid-2{
    grid-template-columns:repeat(2,1fr);
  }

  .choice-btn{
    min-height:78px;
    padding:.45rem;
    font-size:.95rem;
    border-radius:.9rem;
  }

  .choice-btn i{
    font-size:.9rem;
    margin-bottom:.15rem;
  }

  .result-row{
    flex-direction:column;
    align-items:flex-start;
  }

  .result-value{
    text-align:left;
    min-width:0;
  }

  .teaching-main{
    font-size:1.25rem;
  }
}

@media(max-width:576px){
  .choice-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .choice-grid-3{
    grid-template-columns:repeat(3,1fr);
  }

  .choice-grid-2{
    grid-template-columns:repeat(2,1fr);
  }

  .choice-btn{
    min-height:72px;
    padding:.38rem;
    font-size:.9rem;
  }

  .choice-btn i{
    font-size:.82rem;
  }

  .meta-grid{
    grid-template-columns:1fr;
  }

  .info-box-header{
    flex-direction:row;
  }

  .info-toggle-btn{
    margin-left:auto;
  }
}

          @media(max-width:768px){
          .choice-btn{
            min-height:64px;
            padding:.45rem .5rem;
            font-size:.95rem;
          }

          .choice-btn i{
            font-size:.9rem;
            margin-bottom:.15rem;
          }
}
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • apoyo docente y seguridad</div>
              <h1 class="h3 mb-2">Anestesia Regional Pediátrica</h1>
              <div class="subtle text-white-50">Calculadora de volumen y dosis total según edad, tipo de bloqueo, anestésico local y concentración.</div>
            </div>
            <span class="pill bg-light text-dark">Pediatría</span>
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

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Datos de entrada</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Peso del paciente</label>
                <div class="input-group mb-3">
                  <input type="number" id="pesoPaciente" class="form-control calc-trigger" step="0.1" min="0" placeholder="Ej: 12">
                  <span class="input-group-text">kg</span>
                </div>

                <label class="form-label-lite">Rango etario</label>
                <div class="choice-grid mb-2">
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_lt3m" value="lt3m">
                    <label class="choice-btn btn-age" for="edad_lt3m">
                      <i class="fa-solid fa-baby"></i>
                      &lt;3 meses
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_3_5m" value="3to5m">
                    <label class="choice-btn btn-age" for="edad_3_5m">
                      <i class="fa-solid fa-baby"></i>
                      3–5 meses
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_6_12m" value="6to12m" checked>
                    <label class="choice-btn btn-age" for="edad_6_12m">
                      <i class="fa-solid fa-baby-carriage"></i>
                      6–12 meses
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_gt1y" value="gt1y">
                    <label class="choice-btn btn-age" for="edad_gt1y">
                      <i class="fa-solid fa-child"></i>
                      &gt;1 año
                    </label>
                  </div>
                </div>
                <div class="small-note">
                  En menores de 6 meses esta herramienta aplica una reducción conservadora del 50% a la dosis máxima de seguridad.
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Anestésico local</label>
                <div class="choice-grid-3 mb-3">
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="la" id="la_bupi" value="bupi" checked>
                    <label class="choice-btn btn-la" for="la_bupi">
                      <i class="fa-solid fa-flask-vial"></i>
                      Bupivacaína
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="la" id="la_levo" value="levobupi">
                    <label class="choice-btn btn-la" for="la_levo">
                      <i class="fa-solid fa-vial-circle-check"></i>
                      Levo-bupi
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="la" id="la_ropi" value="ropi">
                    <label class="choice-btn btn-la" for="la_ropi">
                      <i class="fa-solid fa-droplet"></i>
                      Ropivacaína
                    </label>
                  </div>
                </div>

                <label class="form-label-lite">Concentración</label>
                <div class="choice-grid-3">
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="conc" id="conc_0125" value="0.125">
                    <label class="choice-btn btn-vol" for="conc_0125">
                      <i class="fa-solid fa-percent"></i>
                      0,125%
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="conc" id="conc_02" value="0.2">
                    <label class="choice-btn btn-vol" for="conc_02">
                      <i class="fa-solid fa-percent"></i>
                      0,2%
                    </label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="conc" id="conc_025" value="0.25" checked>
                    <label class="choice-btn btn-vol" for="conc_025">
                      <i class="fa-solid fa-percent"></i>
                      0,25%
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Bloqueo y volumen</div>

            <div class="choice-grid mb-3">
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_plexolumbar" value="plexolumbar" checked>
                <label class="choice-btn btn-block" for="blk_plexolumbar">
                  <i class="fa-solid fa-bone"></i>
                  Plexo lumbar
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_digital" value="digital">
                <label class="choice-btn btn-block" for="blk_digital">
                  <i class="fa-solid fa-hand-point-up"></i>
                  Nervio digital
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_intercostal" value="intercostal">
                <label class="choice-btn btn-block" for="blk_intercostal">
                  <i class="fa-solid fa-lungs"></i>
                  Intercostal
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_cabezacuello" value="cabezacuello">
                <label class="choice-btn btn-block" for="blk_cabezacuello">
                  <i class="fa-solid fa-head-side-mask"></i>
                  Cabeza/cuello
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_infraorbital" value="infraorbital">
                <label class="choice-btn btn-block" for="blk_infraorbital">
                  <i class="fa-solid fa-eye"></i>
                  Infraorbital
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_cervicalsup" value="cervicalsup">
                <label class="choice-btn btn-block" for="blk_cervicalsup">
                  <i class="fa-solid fa-neck-brace"></i>
                  Plexo cervical
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_supraorb" value="supraorb">
                <label class="choice-btn btn-block" for="blk_supraorb">
                  <i class="fa-solid fa-skull"></i>
                  Supraorb./Supratroc.
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_paravertebral" value="paravertebral">
                <label class="choice-btn btn-block" for="blk_paravertebral">
                  <i class="fa-solid fa-rib-cage"></i>
                  Paravertebral T
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_muneca" value="muneca">
                <label class="choice-btn btn-block" for="blk_muneca">
                  <i class="fa-solid fa-hand"></i>
                  Muñeca
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_tobillo" value="tobillo">
                <label class="choice-btn btn-block" for="blk_tobillo">
                  <i class="fa-solid fa-shoe-prints"></i>
                  Tobillo
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_fasciailiaca" value="fasciailiaca">
                <label class="choice-btn btn-block" for="blk_fasciailiaca">
                  <i class="fa-solid fa-hippo"></i>
                  Fascia ilíaca
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="block" id="blk_tap" value="tap">
                <label class="choice-btn btn-block" for="blk_tap">
                  <i class="fa-solid fa-table-cells-large"></i>
                  Subcostal TAP
                </label>
              </div>
            </div>

            <label class="form-label-lite">Volumen a usar dentro del rango</label>
            <div class="choice-grid-3">
              <div>
                <input class="choice-check calc-trigger" type="radio" name="volsel" id="vol_min" value="min" checked>
                <label class="choice-btn btn-vol" for="vol_min">
                  <i class="fa-solid fa-arrow-down"></i>
                  Mínimo
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="volsel" id="vol_mid" value="mid">
                <label class="choice-btn btn-vol" for="vol_mid">
                  <i class="fa-solid fa-arrows-left-right"></i>
                  Medio
                </label>
              </div>
              <div>
                <input class="choice-check calc-trigger" type="radio" name="volsel" id="vol_max" value="max">
                <label class="choice-btn btn-vol" for="vol_max">
                  <i class="fa-solid fa-arrow-up"></i>
                  Máximo
                </label>
              </div>
            </div>
            <div class="small-note mt-2" id="blockRangeNote">Selecciona un bloqueo para ver rango e indicación habitual.</div>
          </div>
        </div>



<div class="section-card">
  <div class="p-3 p-md-4">
    <div class="section-title mb-3">Resumen del Plan</div>

    <div class="plan-summary-card">
      <div class="plan-summary-label">Configuración seleccionada</div>
      <div id="planSummaryText" class="plan-summary-text">
        Selecciona todos los parámetros para generar el resumen.
      </div>
    </div>
  </div>
</div>




        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado clínico y seguridad</div>

            <div class="result-box mb-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Volumen final seleccionado</div>
                  <div id="volumenNote" class="result-note">Basado en el rango del bloqueo elegido</div>
                </div>
                <div id="volumenFinal" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Dosis total administrada</div>
                  <div id="dosisTotalNote" class="result-note">Volumen × concentración</div>
                </div>
                <div id="dosisTotal" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Dosis máxima ajustada por seguridad</div>
                  <div id="dosisMaxNote" class="result-note">Según tipo de bloqueo y edad</div>
                </div>
                <div id="dosisMax" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Uso relativo de la dosis máxima</div>
                  <div id="porcentajeNote" class="result-note">Interpretación visual de cercanía a toxicidad</div>
                </div>
                <div id="porcentajeUso" class="result-value">-</div>
              </div>
            </div>

            <div class="highlight-dose">
              <div class="highlight-label">Interpretación</div>
              <div id="riskText" class="highlight-main">Ingresa peso y selecciona parámetros</div>
              <div id="riskSoft" class="highlight-soft">La herramienta mostrará volumen, mg totales y riesgo relativo.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="meta-grid mb-3">
              <div class="meta-card">
                <div class="meta-label">Indicación habitual</div>
                <div id="indicacionHabitual" class="meta-value">-</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Precaución principal</div>
                <div id="precaucionPrincipal" class="meta-value">-</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Infusión continua orientativa</div>
                <div id="infusionEdad" class="meta-value">-</div>
              </div>
            </div>

            <div class="warn-box">
              <b>Recordatorio</b><br>
              <div class="small-note mt-2">
                Si se combinan distintos anestésicos locales o múltiples bloqueos, la toxicidad es aditiva. No uses la dosis máxima de un fármaco si ya has consumido parte del margen con otro.
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Tips para residentes</div>
              <div class="teaching-main">
                En regional pediátrica, calcular solo el volumen no basta: lo peligroso es no traducirlo a mg/kg reales
              </div>

              <div class="teaching-card">
                <b>1. El mismo volumen no significa la misma seguridad</b><br>
                Un volumen aceptable con bupivacaína 0,125% puede ser riesgoso con 0,25%. La dosis total en mg siempre manda.
              </div>

              <div class="teaching-card">
                <b>2. Menores de 6 meses = más conservador</b><br>
                Tienen menos proteínas transportadoras, menor aclaramiento y mayor fracción libre del anestésico local. El margen de seguridad es menor.
              </div>

              <div class="teaching-card">
                <b>3. No todos los bloqueos absorben igual</b><br>
                Intercostales y planos fasciales tienen absorción sistémica más rápida. Aunque el número en mL parezca pequeño, el riesgo de LAST sube.
              </div>

              <div class="teaching-card">
                <b>4. El volumen máximo total también importa</b><br>
                Algunos bloqueos tienen un tope absoluto en mL. Aunque el cálculo por kg lo permita, no debes ignorar ese límite físico.
              </div>

              <div class="teaching-card">
                <b>5. LAST en niños bajo anestesia general se ve distinto</b><br>
                Los pródromos neurológicos suelen estar enmascarados. Los primeros signos pueden ser arritmias, cambios ST o colapso hemodinámico.
              </div>

              <div class="danger-box">
                <b>Mensaje final</b><br>
                Si tu cálculo supera 80% de la dosis máxima ajustada, deja de pensar en “qué volumen bonito da” y empieza a pensar en seguridad: bajar concentración, bajar volumen o cambiar estrategia.
              </div>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Debe integrarse con ecografía, aspiración cuidadosa, fraccionamiento de dosis, monitorización y protocolo de LAST disponible.
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

function round1(n){
  return Math.round(n * 10) / 10;
}

function round2(n){
  return Math.round(n * 100) / 100;
}

const BLOCKS = {
  plexolumbar: {
    nombre: "Plexo lumbar",
    indicacion: "Cirugía de cadera y fémur proximal",
    minMlKg: 0.2,
    maxMlKg: 0.5,
    maxTotalMl: 20,
    maxMgKg: 1.5,
    precaucion: "Bloqueo profundo; requiere ecografía y precauciones de coagulación tipo neuraxial."
  },
  digital: {
    nombre: "Nervio digital",
    indicacion: "Cirugía distal de dedos, uña encarnada, laceraciones",
    minMlKg: 0.05,
    maxMlKg: 0.1,
    maxTotalMl: 5,
    maxMgKg: 1.0,
    precaucion: "Nunca usar epinefrina por riesgo de isquemia digital."
  },
  intercostal: {
    nombre: "Intercostal",
    indicacion: "Drenaje torácico, toracoscopia",
    minMlKg: 0.05,
    maxMlKg: 0.5,
    maxTotalMl: 5,
    maxMgKg: 0.75,
    precaucion: "Absorción sistémica muy rápida; alto riesgo de LAST."
  },
  cabezacuello: {
    nombre: "Cabeza y cuello",
    indicacion: "Cirugías faciales, otoplastia, mastoidectomía",
    minMlKg: 0.1,
    maxMlKg: 0.1,
    maxTotalMl: 5,
    maxMgKg: 1.0,
    precaucion: "Bloqueos superficiales, generalmente sensoriales."
  },
  infraorbital: {
    nombre: "Infraorbital",
    indicacion: "Labio leporino, senos endoscópicos",
    minMlKg: 0.5,
    maxMlKg: 2.0,
    maxTotalMl: null,
    maxMgKg: 1.0,
    precaucion: "Evitar mordedura del labio anestesiado al despertar."
  },
  cervicalsup: {
    nombre: "Plexo cervical superficial",
    indicacion: "Otoplastia, implante coclear, tiroides",
    minMlKg: 1.0,
    maxMlKg: 3.0,
    maxTotalMl: null,
    maxMgKg: 1.0,
    precaucion: "Evitar inyección profunda por riesgo de Horner o bloqueo laríngeo recurrente."
  },
  supraorb: {
    nombre: "Supraorbital / Supratroclear",
    indicacion: "Incisiones frontales, craneotomía frontal",
    minMlKg: 1.0,
    maxMlKg: 2.0,
    maxTotalMl: null,
    maxMgKg: 1.0,
    precaucion: "Correlacionar agujero supraorbital con punto medio pupilar."
  },
  paravertebral: {
    nombre: "Paravertebral torácico",
    indicacion: "Toracotomía, cirugía renal, esternotomía, pectus",
    minMlKg: 0.3,
    maxMlKg: 0.5,
    maxTotalMl: 15,
    maxMgKg: 1.5,
    precaucion: "Riesgo de neumotórax; en neonatos puede difundirse al espacio epidural."
  },
  muneca: {
    nombre: "Muñeca",
    indicacion: "Cirugía de mano, sindactilia, dedo en gatillo",
    minMlKg: 0.1,
    maxMlKg: 0.2,
    maxTotalMl: 10,
    maxMgKg: 1.5,
    precaucion: "Útil para evitar bloqueo motor del brazo completo."
  },
  tobillo: {
    nombre: "Tobillo",
    indicacion: "Cirugía de pie y dedos",
    minMlKg: 0.1,
    maxMlKg: 0.2,
    maxTotalMl: 15,
    maxMgKg: 1.5,
    precaucion: "No usar epinefrina por arterias terminales."
  },
  fasciailiaca: {
    nombre: "Fascia ilíaca",
    indicacion: "Fractura de fémur, cirugía de cadera",
    minMlKg: 0.5,
    maxMlKg: 0.5,
    maxTotalMl: 20,
    maxMgKg: 0.75,
    precaucion: "Excelente alternativa al femoral para cobertura amplia, pero es un plano fascial."
  },
  tap: {
    nombre: "Subcostal TAP",
    indicacion: "Colecistectomía, sonda PEG",
    minMlKg: 0.3,
    maxMlKg: 0.5,
    maxTotalMl: 10,
    maxMgKg: 0.75,
    precaucion: "Plano fascial de absorción rápida; considerar riesgo de LAST."
  }
};

function getMgPerMl(conc){
  if(conc === "0.125") return 1.25;
  if(conc === "0.2") return 2.0;
  return 2.5; // 0.25%
}

function getInfusionByAge(age){
  if(age === "lt3m") return "0,2 mg/kg/h";
  if(age === "3to5m") return "0,2–0,3 mg/kg/h";
  if(age === "6to12m") return "0,3 mg/kg/h";
  return "0,4 mg/kg/h";
}

function adjustMaxDoseForAge(maxMgKg, age){
  if(age === "lt3m" || age === "3to5m"){
    return maxMgKg * 0.5;
  }
  return maxMgKg;
}

function getVolumeMl(peso, block, volsel){
  let mlkg = block.minMlKg;
  if(volsel === "mid"){
    mlkg = (block.minMlKg + block.maxMlKg) / 2;
  }
  if(volsel === "max"){
    mlkg = block.maxMlKg;
  }

  let vol = peso * mlkg;

  if(block.maxTotalMl !== null && vol > block.maxTotalMl){
    vol = block.maxTotalMl;
  }

  return {vol, mlkg};
}

function calculatePedRegional(){
  const peso = parseFloat(document.getElementById("pesoPaciente").value);
  const age = getSelected("edad");
  const la = getSelected("la") || "bupi";
  const conc = getSelected("conc") || "0.25";
  const blockKey = getSelected("block") || "plexolumbar";
  const volsel = getSelected("volsel") || "min";

  const block = BLOCKS[blockKey];
  const blockRangeNote = document.getElementById("blockRangeNote");
  const volumenFinal = document.getElementById("volumenFinal");
  const volumenNote = document.getElementById("volumenNote");
  const dosisTotal = document.getElementById("dosisTotal");
  const dosisTotalNote = document.getElementById("dosisTotalNote");
  const dosisMax = document.getElementById("dosisMax");
  const dosisMaxNote = document.getElementById("dosisMaxNote");
  const porcentajeUso = document.getElementById("porcentajeUso");
  const porcentajeNote = document.getElementById("porcentajeNote");
  const riskText = document.getElementById("riskText");
  const riskSoft = document.getElementById("riskSoft");
  const indicacionHabitual = document.getElementById("indicacionHabitual");
  const precaucionPrincipal = document.getElementById("precaucionPrincipal");
  const infusionEdad = document.getElementById("infusionEdad");
  const planSummaryText = document.getElementById("planSummaryText");

  if(!block){
    return;
  }

  const rangeText = (block.minMlKg === block.maxMlKg)
    ? `${block.minMlKg} mL/kg`
    : `${block.minMlKg}–${block.maxMlKg} mL/kg`;

  blockRangeNote.textContent = `${block.nombre}: ${rangeText}` + (block.maxTotalMl !== null ? ` • máximo total ${block.maxTotalMl} mL` : " • límite práctico definido por dosis máxima");

  indicacionHabitual.textContent = block.indicacion;
  precaucionPrincipal.textContent = block.precaucion;
  infusionEdad.textContent = getInfusionByAge(age || "6to12m");

  if(isNaN(peso) || peso <= 0 || !age){
    volumenFinal.textContent = '-';
    volumenNote.textContent = 'Ingresa peso y edad';
    dosisTotal.textContent = '-';
    dosisTotalNote.textContent = 'Se calculará con la concentración elegida';
    dosisMax.textContent = '-';
    dosisMaxNote.textContent = 'Se ajustará según tipo de bloqueo y edad';
    porcentajeUso.textContent = '-';
    porcentajeNote.textContent = 'Se mostrará el porcentaje de uso de la dosis máxima';
    riskText.textContent = 'Ingresa peso y selecciona parámetros';
    riskSoft.textContent = 'La herramienta mostrará volumen, mg totales y riesgo relativo.';
    planSummaryText.textContent = 'Selecciona peso, edad, bloqueo, anestésico local, concentración y volumen para generar el resumen.';
    return;
  }

  const {vol, mlkg} = getVolumeMl(peso, block, volsel);
  const mgPerMl = getMgPerMl(conc);
  const totalMg = vol * mgPerMl;
  const maxMgKgAgeAdjusted = adjustMaxDoseForAge(block.maxMgKg, age);
  const maxMg = peso * maxMgKgAgeAdjusted;
  const pct = (totalMg / maxMg) * 100;

  let volLabel = '';
  if(volsel === 'min') volLabel = 'Volumen mínimo del rango';
  if(volsel === 'mid') volLabel = 'Volumen intermedio del rango';
  if(volsel === 'max') volLabel = 'Volumen máximo del rango';

  volumenFinal.innerHTML = `${round2(vol).toString().replace('.', ',')} mL`;
  volumenNote.textContent = `${volLabel} (${round2(mlkg).toString().replace('.', ',')} mL/kg)` + (block.maxTotalMl !== null && (peso * mlkg) > block.maxTotalMl ? `, ajustado al máximo total de ${block.maxTotalMl} mL` : '');

  const laName = (la === 'bupi') ? 'Bupivacaína' : (la === 'levobupi') ? 'Levobupivacaína' : 'Ropivacaína';
  dosisTotal.innerHTML = `${round2(totalMg).toString().replace('.', ',')} mg`;
  dosisTotalNote.textContent = `${round2(vol).toString().replace('.', ',')} mL × ${mgPerMl.toString().replace('.', ',')} mg/mL (${laName} ${conc}%)`;

  dosisMax.innerHTML = `${round2(maxMg).toString().replace('.', ',')} mg`;
  let ageAdjText = '';
  if(age === 'lt3m' || age === '3to5m'){
    ageAdjText = ' • reducción conservadora 50% por <6 meses';
  }
  dosisMaxNote.textContent = `${round2(maxMgKgAgeAdjusted).toString().replace('.', ',')} mg/kg para este bloqueo${ageAdjText}`;


let edadTexto = '';
if(age === 'lt3m') edadTexto = 'RN';
if(age === '3to5m') edadTexto = 'de 1 a 4 meses';
if(age === '6to12m') edadTexto = 'de 5 a 12 meses';
if(age === 'gt1y') edadTexto = 'mayor de 1 año';

let volResumen = '';
if(volsel === 'min') volResumen = 'volumen mínimo';
if(volsel === 'mid') volResumen = 'volumen medio';
if(volsel === 'max') volResumen = 'volumen máximo';

planSummaryText.textContent =
  `Bloqueo ${block.nombre}, con ${laName.toLowerCase()} al ${conc.replace('.', ',')}%, usando ${volResumen}, para un paciente ${edadTexto} de ${peso.toString().replace('.', ',')} kg.`;

  let pctClass = 'risk-ok';
  let riskMain = 'Dentro de margen cómodo';
  let riskDetail = 'La dosis calculada está por debajo del 80% de la dosis máxima ajustada.';
  if(pct >= 80 && pct <= 100){
    pctClass = 'risk-warn';
    riskMain = 'Cercano a toxicidad';
    riskDetail = 'Has consumido más del 80% del margen calculado. Considera bajar concentración, reducir volumen o replantear la estrategia.';
  }
  if(pct > 100){
    pctClass = 'risk-bad';
    riskMain = 'Excede dosis segura';
    riskDetail = 'La dosis total calculada supera la dosis máxima ajustada para este escenario. No usar así.';
  }

  porcentajeUso.innerHTML = `<span class="${pctClass}">${round1(pct).toString().replace('.', ',')}%</span>`;
  porcentajeNote.textContent = `Porcentaje de la dosis máxima ajustada usado por este plan`;

  riskText.innerHTML = `${riskMain}`;
  riskSoft.textContent = riskDetail;
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('change', calculatePedRegional);
    el.addEventListener('input', calculatePedRegional);
  });
  document.getElementById('pesoPaciente').addEventListener('input', calculatePedRegional);
  calculatePedRegional();
});
</script>

<?php require("footer.php"); ?>