<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para estimar riesgo de tromboembolismo venoso mediante el modelo de Caprini 2013 y orientar medidas generales de profilaxis según el puntaje total.";
$formula = "Estratificación orientativa: 0–1 bajo riesgo, 2 moderado, 3–4 alto, ≥5 muy alto. El score informa la decisión de profilaxis, pero no la prescribe por sí solo. Debe interpretarse junto al riesgo de sangrado, el tipo de cirugía y el contexto clínico.";
$referencias = array(
  "1.- Caprini Risk Assessment Model 2013.",
  "2.- Prophylaxis Recommendations Based on Risk Level (según material adjunto).",
  "3.- Ajustar siempre a protocolo institucional, riesgo hemorrágico, función renal y técnica anestésica."
);

$icono_apunte = "<i class='fa-solid fa-shield-heart pe-3 pt-2'></i>";
$titulo_apunte = "Score de Caprini / Riesgo TVP";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="caprini-shell">

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
          .caprini-shell{max-width:1080px;margin:0 auto;}

          .caprini-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .caprini-topbar h1{color:#fff;}

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

          .group-title{
            font-size:.95rem;
            font-weight:700;
            color:var(--text);
            margin-bottom:.25rem;
          }

          .group-subtitle{
            font-size:.8rem;
            color:#667085;
            margin-bottom:.75rem;
          }


          .factor-check,
          .factor-radio{
            display:none;
          }

.factor-grid-2{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:.55rem;
}

.factor-grid-3{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:.55rem;
}

.factor-grid-4{
  display:grid;
  grid-template-columns:repeat(4,minmax(0,1fr));
  gap:.55rem;
}

.factor-btn{
  display:flex;
  flex-direction:column;
  align-items:flex-start;
  justify-content:center;
  text-align:left;
  min-height:68px;
  border:1px solid #dfe7f2;
  background:#fff;
  border-radius:.85rem;
  padding:.6rem .7rem;
  font-weight:700;
  color:#1f2a37;
  cursor:pointer;
  transition:.15s ease;
  line-height:1.12;
  box-shadow:0 4px 14px rgba(0,0,0,.04);
  font-size:.92rem;
}

.factor-btn small{
  font-weight:500;
  color:#667085;
  margin-top:.14rem;
  line-height:1.15;
  font-size:.72rem;
}

.factor-points{
  display:inline-block;
  margin-top:.28rem;
  font-size:.7rem;
  font-weight:800;
  color:#3559b7;
  background:#eef3ff;
  border-radius:999px;
  padding:.14rem .4rem;
}

          .factor-check:checked + .factor-btn,
          .factor-radio:checked + .factor-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
            transform:translateY(-1px);
          }

          .summary-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
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

          .result-main-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
          }

          .result-main-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .result-main-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .result-main-value{
            font-size:2rem;
            font-weight:800;
            line-height:1.05;
            color:#27458f;
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

          .selected-list{
            background:#f8fafc;
            border:1px solid #dfe7f2;
            border-radius:1rem;
            padding:1rem;
            min-height:88px;
          }

          .selected-list ul{
            margin:0;
            padding-left:1.1rem;
          }

          .selected-list li{
            margin-bottom:.35rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{
            margin-bottom:.45rem;
          }

@media (max-width:900px){
  .factor-grid-4{
    grid-template-columns:repeat(3,minmax(0,1fr));
  }

  .factor-grid-3{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }

  .factor-grid-2{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }

  .summary-grid{
    grid-template-columns:repeat(2,1fr);
  }
}

@media (max-width:576px){
  .factor-grid-4{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }

  .factor-grid-3{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }

  .factor-grid-2{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }

  .factor-btn{
    min-height:64px;
    padding:.55rem .6rem;
    font-size:.88rem;
  }

  .factor-btn small{
    font-size:.68rem;
  }

  .summary-grid{
    grid-template-columns:1fr;
  }

  .info-box-header{
    flex-direction:row;
  }

  .info-toggle-btn{
    margin-left:auto;
  }
}

          @media (max-width:768px){
            .calc-grid{
              grid-template-columns:1fr;
            }
          }

          @media (max-width:576px){
            .summary-grid{
              grid-template-columns:1fr;
            }
            .info-box-header{
              flex-direction:row;
            }
            .info-toggle-btn{
              margin-left:auto;
            }
          }
        </style>

        <div class="caprini-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • tromboprofilaxis</div>
              <h1 class="h3 mb-2">Score de Caprini</h1>
              <div class="subtle text-white-50">Estimación interactiva de riesgo de TEV y sugerencias generales de profilaxis.</div>
            </div>
            <span class="pill bg-light text-dark">TVP / TEV</span>
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
            <div class="section-title mb-3">A. Factores de riesgo</div>

            <div class="calc-grid">

              <div class="card-block">
                <div class="group-title">Edad</div>
                <div class="group-subtitle">Escoge solo una opción.</div>
                <div class="factor-grid-4">
                  <div>
                    <input class="factor-radio caprini-radio" type="radio" name="edad_caprini" id="edad_0" data-points="0" data-label="Edad menor de 41 años" checked>
                    <label class="factor-btn" for="edad_0">Menor de 41 años <span class="factor-points">0</span></label>
                  </div>
                  <div>
                    <input class="factor-radio caprini-radio" type="radio" name="edad_caprini" id="edad_1" data-points="1" data-label="Edad 41–60 años">
                    <label class="factor-btn" for="edad_1">41–60 años <span class="factor-points">+1</span></label>
                  </div>
                  <div>
                    <input class="factor-radio caprini-radio" type="radio" name="edad_caprini" id="edad_2" data-points="2" data-label="Edad 61–74 años">
                    <label class="factor-btn" for="edad_2">61–74 años <span class="factor-points">+2</span></label>
                  </div>
                  <div>
                    <input class="factor-radio caprini-radio" type="radio" name="edad_caprini" id="edad_3" data-points="3" data-label="Edad ≥75 años">
                    <label class="factor-btn" for="edad_3">≥75 años <span class="factor-points">+3</span></label>
                  </div>
                </div>
              </div>

<div class="card-block">
  <div class="group-title">Cirugía planificada</div>
  <div class="group-subtitle">Escoge solo una opción.</div>
  <div class="factor-grid-4">
    <div>
      <input class="factor-radio caprini-radio" type="radio" name="cirugia_caprini" id="cx_0" data-points="0" data-label="Sin cirugía relevante" checked>
      <label class="factor-btn" for="cx_0">
        Sin cirugía relevante
        <span class="factor-points">0</span>
      </label>
    </div>
    <div>
      <input class="factor-radio caprini-radio" type="radio" name="cirugia_caprini" id="cx_1" data-points="1" data-label="Cirugía menor planificada <45 minutos">
      <label class="factor-btn" for="cx_1">
        Cirugía menor &lt;45 min
        <span class="factor-points">+1</span>
      </label>
    </div>
    <div>
      <input class="factor-radio caprini-radio" type="radio" name="cirugia_caprini" id="cx_2" data-points="2" data-label="Cirugía mayor planificada >45 minutos">
      <label class="factor-btn" for="cx_2">
        Cirugía mayor &gt;45 min
        <span class="factor-points">+2</span>
      </label>
    </div>
    <div>
      <input class="factor-radio caprini-radio" type="radio" name="cirugia_caprini" id="cx_3" data-points="1" data-label="Cirugía de más de 2 horas">
      <label class="factor-btn" for="cx_3">
        Cirugía &gt;2 horas
        <span class="factor-points">+1</span>
      </label>
    </div>
  </div>
</div>

<div class="card-block">
  <div class="group-title">Movilidad / inmovilización / acceso</div>
  <div class="group-subtitle">Reposo en cama es excluyente. Yeso y acceso venoso central pueden coexistir.</div>

  <div class="mb-3">
    <div class="small-note mb-2"><b>Reposo / movilidad</b></div>
    <div class="factor-grid-3">
      <div>
        <input class="factor-radio caprini-radio" type="radio" name="reposo_caprini" id="rep_0" data-points="0" data-label="Sin reposo relevante" checked>
        <label class="factor-btn" for="rep_0">
          Sin reposo relevante
          <span class="factor-points">0</span>
        </label>
      </div>
      <div>
        <input class="factor-radio caprini-radio" type="radio" name="reposo_caprini" id="rep_1" data-points="1" data-label="Reposo o movilidad reducida <72 horas">
        <label class="factor-btn" for="rep_1">
          Reposo &lt;72 h
          <span class="factor-points">+1</span>
        </label>
      </div>
      <div>
        <input class="factor-radio caprini-radio" type="radio" name="reposo_caprini" id="rep_2" data-points="2" data-label="Reposo en cama ≥72 horas">
        <label class="factor-btn" for="rep_2">
          Reposo ≥72 h
          <span class="factor-points">+2</span>
        </label>
      </div>
    </div>
  </div>

  <div class="factor-grid-2">
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="fmob_3" data-points="2" data-label="Yeso inmovilizador en el último mes">
      <label class="factor-btn" for="fmob_3">
        Yeso inmovilizador último mes
        <span class="factor-points">+2</span>
      </label>
    </div>
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="fmob_4" data-points="2" data-label="Acceso venoso central en el último mes">
      <label class="factor-btn" for="fmob_4">
        Acceso venoso central último mes
        <span class="factor-points">+2</span>
      </label>
    </div>
  </div>
</div>

<div class="card-block">
  <div class="group-title">Hallazgos y comorbilidades de 1 punto</div>
  <div class="group-subtitle">BMI es excluyente. El resto puede coexistir.</div>

  <div class="mb-3">
    <div class="small-note mb-2"><b>BMI</b></div>
    <div class="factor-grid-3">
      <div>
        <input class="factor-radio caprini-radio" type="radio" name="bmi_caprini" id="bmi_0" data-points="0" data-label="BMI <25" checked>
        <label class="factor-btn" for="bmi_0">
          BMI &lt;25
          <span class="factor-points">0</span>
        </label>
      </div>
      <div>
        <input class="factor-radio caprini-radio" type="radio" name="bmi_caprini" id="bmi_1" data-points="1" data-label="BMI ≥25">
        <label class="factor-btn" for="bmi_1">
          BMI ≥25
          <span class="factor-points">+1</span>
        </label>
      </div>
      <div>
        <input class="factor-radio caprini-radio" type="radio" name="bmi_caprini" id="bmi_2" data-points="1" data-label="BMI >40">
        <label class="factor-btn" for="bmi_2">
          BMI &gt;40
          <span class="factor-points">+1</span>
        </label>
      </div>
    </div>
  </div>

  <div class="factor-grid-2">
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="f1_1" data-points="1" data-label="Várices visibles">
      <label class="factor-btn" for="f1_1">Várices visibles <span class="factor-points">+1</span></label>
    </div>
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="f1_2" data-points="1" data-label="Piernas hinchadas actuales">
      <label class="factor-btn" for="f1_2">Piernas hinchadas actuales <span class="factor-points">+1</span></label>
    </div>
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="f1_4" data-points="1" data-label="Infarto al miocardio">
      <label class="factor-btn" for="f1_4">Infarto al miocardio <span class="factor-points">+1</span></label>
    </div>
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="f1_5" data-points="1" data-label="Insuficiencia cardíaca congestiva">
      <label class="factor-btn" for="f1_5">Insuficiencia cardíaca congestiva <span class="factor-points">+1</span></label>
    </div>
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="f1_6" data-points="1" data-label="Enfermedad inflamatoria intestinal">
      <label class="factor-btn" for="f1_6">Enfermedad inflamatoria intestinal <span class="factor-points">+1</span></label>
    </div>
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="f1_7" data-points="1" data-label="Infección grave actual o reciente">
      <label class="factor-btn" for="f1_7">Infección grave / neumonía <span class="factor-points">+1</span></label>
    </div>
    <div>
      <input class="factor-check caprini-item" type="checkbox" id="f1_8" data-points="1" data-label="Enfermedad pulmonar existente (ej. EPOC)">
      <label class="factor-btn" for="f1_8">Enfermedad pulmonar (ej. EPOC) <span class="factor-points">+1</span></label>
    </div>
  </div>
</div>


              <div class="card-block">
                <div class="group-title">Mujeres</div>
                <div class="group-subtitle">Marca los que correspondan.</div>
                <div class="factor-grid-2">
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="fw_1" data-points="1" data-label="Uso de hormonas (ACO o TRH)">
                    <label class="factor-btn" for="fw_1">Hormonas: ACO / TRH <span class="factor-points">+1</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="fw_2" data-points="1" data-label="Embarazo o puerperio dentro de 1 mes">
                    <label class="factor-btn" for="fw_2">Embarazo / puerperio &lt;1 mes <span class="factor-points">+1</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="fw_3" data-points="1" data-label="Óbito inexplicado, aborto recurrente >3, parto prematuro con preeclampsia o RCIU">
                    <label class="factor-btn" for="fw_3">Antecedentes obstétricos de riesgo <span class="factor-points">+1</span></label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <div class="group-title">Otros factores de 1 punto</div>
                <div class="group-subtitle">Marca todos los que apliquen.</div>
                <div class="factor-grid-2">
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="fo_2" data-points="1" data-label="Tabaquismo">
                    <label class="factor-btn" for="fo_2">Tabaquismo <span class="factor-points">+1</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="fo_3" data-points="1" data-label="Diabetes que requiere insulina">
                    <label class="factor-btn" for="fo_3">Diabetes insulinorrequirente <span class="factor-points">+1</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="fo_4" data-points="1" data-label="Quimioterapia">
                    <label class="factor-btn" for="fo_4">Quimioterapia <span class="factor-points">+1</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="fo_5" data-points="1" data-label="Transfusiones sanguíneas">
                    <label class="factor-btn" for="fo_5">Transfusiones sanguíneas <span class="factor-points">+1</span></label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <div class="group-title">Otros Factores de 2 puntos</div>
                <div class="factor-grid-2">
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f2_1" data-points="2" data-label="Malignidad presente o pasada">
                    <label class="factor-btn" for="f2_1">Malignidad presente o pasada <span class="factor-points">+2</span></label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <div class="group-title">Factores de 3 puntos</div>
                <div class="group-subtitle">Marca los que apliquen.</div>
                <div class="factor-grid-2">
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f3_1" data-points="3" data-label="Antecedente personal de TEV">
                    <label class="factor-btn" for="f3_1">Antecedente personal de TEV <span class="factor-points">+3</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f3_2" data-points="3" data-label="Antecedente familiar de TEV">
                    <label class="factor-btn" for="f3_2">Antecedente familiar de TEV <span class="factor-points">+3</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f3_3" data-points="3" data-label="Historia personal o familiar de trombofilia conocida">
                    <label class="factor-btn" for="f3_3">Historia personal/familiar de trombofilia <span class="factor-points">+3</span></label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <div class="group-title">Factores de 5 puntos</div>
                <div class="group-subtitle">Marca los que apliquen.</div>
                <div class="factor-grid-2">
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f5_1" data-points="5" data-label="Artroplastía electiva de cadera o rodilla">
                    <label class="factor-btn" for="f5_1">Artroplastía electiva cadera/rodilla <span class="factor-points">+5</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f5_2" data-points="5" data-label="Fractura de cadera, pelvis o pierna">
                    <label class="factor-btn" for="f5_2">Fractura cadera / pelvis / pierna <span class="factor-points">+5</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f5_3" data-points="5" data-label="Trauma severo o fracturas múltiples">
                    <label class="factor-btn" for="f5_3">Trauma severo / fracturas múltiples <span class="factor-points">+5</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f5_4" data-points="5" data-label="Lesión medular con parálisis">
                    <label class="factor-btn" for="f5_4">Lesión medular con parálisis <span class="factor-points">+5</span></label>
                  </div>
                  <div>
                    <input class="factor-check caprini-item" type="checkbox" id="f5_5" data-points="5" data-label="ACV">
                    <label class="factor-btn" for="f5_5">ACV <span class="factor-points">+5</span></label>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Tarjeta resumen</div>

            <div class="summary-grid mb-3">
              <div class="summary-card">
                <div class="summary-label">Puntaje total</div>
                <div id="scoreTotal" class="summary-value">0</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Categoría</div>
                <div id="scoreCategory" class="summary-value">Bajo riesgo</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Factores activos</div>
                <div id="scoreItemsCount" class="summary-value">0 seleccionados</div>
              </div>
            </div>

            <div class="selected-list">
              <div class="summary-label mb-2">Opciones seleccionadas</div>
              <div id="selectedFactorsWrap" class="small-note">Aún no has seleccionado factores.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Resultado principal</div>

            <div id="resultCard" class="result-main-card">
              <div class="result-main-label">Score de Caprini</div>
              <div class="result-main-note">Estratificación orientativa de riesgo TEV</div>
              <div id="resultMain" class="result-main-value">0 puntos</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Sugerencias de manejo</div>

            <div id="managementBox" class="good-box">
              <strong id="managementTitle">Bajo riesgo</strong><br>
              <div id="managementText" class="small-note mt-2">
                El score informa decisiones sobre prevención de TEV, pero no prescribe profilaxis por sí solo. En bajo riesgo suele bastar la deambulación precoz.
              </div>
            </div>

            <div id="managementExamples" class="mint-box mt-3">
              <strong>Ejemplos orientativos</strong>
              <ul class="tip-list mt-2">
                <li>Deambulación precoz.</li>
                <li>No suele requerirse profilaxis mecánica ni farmacológica de rutina.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Tips docentes</div>

            <div class="warn-box">
              <ul class="tip-list">
                <li>El score de Caprini informa la decisión de profilaxis, pero la selección final depende también del riesgo de sangrado.</li>
                <li>En riesgo alto y muy alto, la profilaxis farmacológica suele ser razonable, pero revisa siempre función renal, sangrado activo, plaquetas, neuroeje y tipo de cirugía.</li>
                <li>En muy alto riesgo, el material adjunto sugiere considerar profilaxis combinada farmacológica y mecánica, y en algunos casos profilaxis extendida postalta.</li>
                <li>Un puntaje alto no obliga a anticoagular a todo paciente: primero define si la profilaxis está contraindicada o debe priorizarse la profilaxis mecánica.</li>
                <li>Reevalúa el score si el paciente cambia de condición, prolonga su inmovilidad o acumula nuevos factores durante la hospitalización.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Ajustar siempre a riesgo hemorrágico, función renal, anestesia neuroaxial y protocolo institucional.
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

function applyResultStyle(level){
  const resultCard = document.getElementById('resultCard');
  const managementBox = document.getElementById('managementBox');

  resultCard.classList.remove('good-box','warn-box','danger-box','mint-box');
  managementBox.classList.remove('good-box','warn-box','danger-box','mint-box');

  if(level === 'low'){
    resultCard.classList.add('good-box');
    managementBox.classList.add('good-box');
  } else if(level === 'moderate'){
    resultCard.classList.add('mint-box');
    managementBox.classList.add('mint-box');
  } else if(level === 'high'){
    resultCard.classList.add('warn-box');
    managementBox.classList.add('warn-box');
  } else {
    resultCard.classList.add('danger-box');
    managementBox.classList.add('danger-box');
  }
}

function updateCaprini(){
  const checkItems = document.querySelectorAll('.caprini-item:checked');
  const radioItems = document.querySelectorAll('.caprini-radio:checked');

  let total = 0;
  let selected = [];

  radioItems.forEach(item => {
    const pts = parseInt(item.dataset.points || '0', 10);
    total += pts;
    if(pts > 0){
      selected.push(item.dataset.label + ' (+' + pts + ')');
    }
  });

  checkItems.forEach(item => {
    const pts = parseInt(item.dataset.points || '0', 10);
    total += pts;
    selected.push(item.dataset.label + ' (+' + pts + ')');
  });

  document.getElementById('scoreTotal').textContent = total;
  document.getElementById('scoreItemsCount').textContent = selected.length + ' seleccionados';
  document.getElementById('resultMain').textContent = total + ' puntos';

  const selectedWrap = document.getElementById('selectedFactorsWrap');
  if(selected.length === 0){
    selectedWrap.textContent = 'Aún no has seleccionado factores.';
  } else {
    selectedWrap.innerHTML = '<ul><li>' + selected.join('</li><li>') + '</li></ul>';
  }

  let category = '';
  let title = '';
  let text = '';
  let examples = '';
  let style = 'low';

  if(total <= 1){
    category = 'Bajo riesgo';
    title = 'Bajo riesgo (0–1 puntos)';
    text = 'El score informa decisiones sobre prevención de TEV, pero no prescribe profilaxis por sí solo. En bajo riesgo, la deambulación precoz suele ser suficiente.';
    examples = `
      <ul class="tip-list mt-2">
        <li>Deambulación precoz.</li>
        <li>No suele requerirse profilaxis mecánica ni farmacológica de rutina.</li>
      </ul>`;
    style = 'low';
  } else if(total === 2){
    category = 'Riesgo moderado';
    title = 'Riesgo moderado (2 puntos)';
    text = 'Puede considerarse profilaxis mecánica o farmacológica según el contexto clínico.';
    examples = `
      <ul class="tip-list mt-2">
        <li>Compresión neumática intermitente.</li>
        <li>Profilaxis farmacológica según contexto clínico y riesgo hemorrágico.</li>
      </ul>`;
    style = 'moderate';
  } else if(total >= 3 && total <= 4){
    category = 'Alto riesgo';
    title = 'Alto riesgo (3–4 puntos)';
    text = 'Se recomienda profilaxis farmacológica durante la hospitalización, agregando métodos mecánicos cuando sea apropiado.';
    examples = `
      <ul class="tip-list mt-2">
        <li>Profilaxis farmacológica durante hospitalización.</li>
        <li>Agregar compresión neumática intermitente si corresponde.</li>
        <li>Ejemplos frecuentes: HNF o HBPM según protocolo local.</li>
      </ul>`;
    style = 'high';
  } else {
    category = 'Muy alto riesgo';
    title = 'Muy alto riesgo (≥5 puntos)';
    text = 'Se aconseja profilaxis combinada farmacológica y mecánica. A menudo puede considerarse profilaxis extendida postalta por 7–10 días. En algunos casos, puntajes mayores de 8 podrían beneficiarse de profilaxis más prolongada, habitualmente hasta 30 días.';
    examples = `
      <ul class="tip-list mt-2">
        <li>Profilaxis farmacológica + profilaxis mecánica.</li>
        <li>Considerar profilaxis extendida postalta 7–10 días.</li>
        <li>En pacientes seleccionados con puntajes &gt;8, considerar prolongación hasta 30 días.</li>
      </ul>`;
    style = 'veryhigh';
  }

  document.getElementById('scoreCategory').textContent = category;
  document.getElementById('managementTitle').textContent = title;
  document.getElementById('managementText').textContent = text;
  document.getElementById('managementExamples').innerHTML = '<strong>Ejemplos orientativos</strong>' + examples;

  applyResultStyle(style);
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.caprini-item, .caprini-radio').forEach(el => {
    el.addEventListener('change', updateCaprini);
  });

  updateCaprini();
});
</script>

<?php require("footer.php"); ?>