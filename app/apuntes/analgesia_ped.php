<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para analgesia endovenosa perioperatoria pediátrica. Permite seleccionar peso, rango etáreo, grupo farmacológico y fármaco para obtener dosis en bolo, rescate o infusión continua, además de advertencias de seguridad.";
$formula = "La analgesia pediátrica EV debe ajustarse por peso, edad, contexto clínico y riesgo respiratorio. Se privilegia la multimodalidad con no opioides y el uso prudente de opioides e infusiones continuas bajo monitorización.";
$referencias = array(
  "1.- Analgésicos pediatría.docx. Tabla de analgésicos no opioides, co-analgésicos y opioides perioperatorios.",
  "2.- Vittinghoff M, et al. (2024). Postoperative Pain Management in children: guidance from the Pain Committee of the European Society for Paediatric Anaesthesiology (ESPA Pain Management Ladder Initiative) Part II. Anaesthesia Critical Care & Pain Medicine, 43, 101427.",
  "3.- Vittinghoff M, et al. (2018). Postoperative pain management in children: Guidance from the pain committee of the European Society for Paediatric Anaesthesiology (ESPA Pain Management Ladder Initiative). Pediatric Anesthesia, 28, 493–506.",
  "4.- Russell P, von Ungern-Sternberg BS, Schug SA. (2013). Perioperative analgesia in pediatric surgery. Current Opinion in Anaesthesiology, 26, 420–427.",
  "5.- Williams G. (2006/reimpresión). Perioperative analgesic pharmacology in children. Update in Anaesthesia."
);

$icono_apunte = "<i class='fa-solid fa-syringe pe-3 pt-2'></i>";
$titulo_apunte = "Analgesia EV Pediátrica Perioperatoria";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="anal-shell">

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
          .anal-shell{max-width:980px;margin:0 auto;}

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

          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .form-label-lite{
            font-size:.9rem;
            font-weight:700;
            color:var(--text);
            margin-bottom:.35rem;
          }

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.55rem;
          }

          .choice-grid-3{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.55rem;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            aspect-ratio:auto;
            min-height:0;
            height:54px;
            border:2px solid #dfe7f2;
            background:#fff;
            border-radius:.85rem;
            padding:.2rem .4rem;
            font-weight:700;
            font-size:.88rem;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.02;
            box-shadow:0 3px 10px rgba(0,0,0,.04);
          }

          .choice-btn i{
            font-size:.8rem;
            margin-bottom:.08rem;
            color:#3559b7;
          }

          .choice-check:checked + .choice-btn{
            transform:translateY(-1px);
            box-shadow:0 8px 18px rgba(0,0,0,.12);
            border:3px solid #3b82f6;
            background:#eef4ff;
          }

          .btn-age{background:#f5f9ff;}
          .btn-type{background:#fffdfa;}
          .btn-drug{background:#f7fbf8;}

          .plan-summary-card{
            background:#eef7ff;
            border:1px solid #cfe1ff;
            border-radius:1rem;
            padding:.8rem .95rem;
          }

          .plan-summary-label{
            font-size:.78rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#3559b7;
            font-weight:700;
            margin-bottom:.35rem;
          }

          .plan-summary-text{
            font-size:1rem;
            line-height:1.35;
            font-weight:800;
            color:#1f2a37;
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
            min-width:170px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
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
            font-size:1.35rem;
            font-weight:900;
            color:#1f2a37;
            line-height:1.2;
          }

          .highlight-soft{
            margin-top:.55rem;
            font-size:.92rem;
            color:#5f6b76;
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

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
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
            font-size:1.45rem;
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

          @media(max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .choice-grid-3{grid-template-columns:repeat(2,1fr);}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
            .teaching-main{font-size:1.2rem;}
          }

          @media(max-width:576px){
            .choice-btn{
              height:50px;
              padding:.15rem .3rem;
              font-size:.84rem;
              border-radius:.8rem;
            }

            .choice-btn i{
              font-size:.72rem;
              margin-bottom:.04rem;
            }

            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • analgesia perioperatoria</div>
              <h1 class="h3 mb-2">Analgesia EV Pediátrica Perioperatoria</h1>
              <div class="subtle text-white-50">Bolos, rescates e infusiones continuas ajustados por peso, edad y tipo de fármaco.</div>
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
                <label class="form-label-lite">Peso</label>
                <div class="input-group mb-3">
                  <input type="number" id="pesoPaciente" class="form-control calc-trigger" step="0.1" min="0" placeholder="Ej: 12">
                  <span class="input-group-text">kg</span>
                </div>

                <label class="form-label-lite">Rango etáreo</label>
                <div class="choice-grid">
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_lt3m" value="lt3m">
                    <label class="choice-btn btn-age" for="edad_lt3m"><i class="fa-solid fa-baby"></i>&lt;3 m</label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_3_12m" value="3to12m" checked>
                    <label class="choice-btn btn-age" for="edad_3_12m"><i class="fa-solid fa-baby-carriage"></i>3–12 m</label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_gt1y" value="gt1y">
                    <label class="choice-btn btn-age" for="edad_gt1y"><i class="fa-solid fa-child"></i>&gt;1 a</label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="edad" id="edad_gt12y" value="gt12y">
                    <label class="choice-btn btn-age" for="edad_gt12y"><i class="fa-solid fa-person"></i>&gt;12 a</label>
                  </div>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Grupo</label>
                <div class="choice-grid">
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="grupo" id="grupo_noopioide" value="noopioide" checked>
                    <label class="choice-btn btn-type" for="grupo_noopioide"><i class="fa-solid fa-capsules"></i>No opioide</label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="grupo" id="grupo_opioide" value="opioide">
                    <label class="choice-btn btn-type" for="grupo_opioide"><i class="fa-solid fa-syringe"></i>Opioide</label>
                  </div>
                </div>

                <label class="form-label-lite mt-3">Modo de uso</label>
                <div class="choice-grid-3">
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="modo" id="modo_bolo" value="bolo" checked>
                    <label class="choice-btn btn-drug" for="modo_bolo"><i class="fa-solid fa-burst"></i>Bolo</label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="modo" id="modo_inf" value="infusion">
                    <label class="choice-btn btn-drug" for="modo_inf"><i class="fa-solid fa-wave-square"></i>Infusión</label>
                  </div>
                  <div>
                    <input class="choice-check calc-trigger" type="radio" name="modo" id="modo_rescate" value="rescate">
                    <label class="choice-btn btn-drug" for="modo_rescate"><i class="fa-solid fa-life-ring"></i>Rescate</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Fármaco</div>
            <div id="drugButtons" class="choice-grid-3"></div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resumen del plan</div>
            <div class="plan-summary-card">
              <div class="plan-summary-label">Configuración seleccionada</div>
              <div id="planSummaryText" class="plan-summary-text">
                Selecciona peso, rango etáreo, grupo, modo y fármaco.
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado</div>

            <div class="result-box mb-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Dosis calculada</div>
                  <div id="doseNote" class="result-note">Según peso y contexto</div>
                </div>
                <div id="doseValue" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Presentación / vía</div>
                  <div id="presentationNote" class="result-note">Presentación sugerida del apunte</div>
                </div>
                <div id="presentationValue" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Frecuencia o ritmo</div>
                  <div id="frequencyNote" class="result-note">Frecuencia sugerida / infusión</div>
                </div>
                <div id="frequencyValue" class="result-value">-</div>
              </div>
            </div>

            <div class="highlight-dose">
              <div class="highlight-label">Interpretación</div>
              <div id="riskText" class="highlight-main">Sin cálculo aún</div>
              <div id="riskSoft" class="highlight-soft">Selecciona todos los parámetros para obtener una guía de uso.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="warn-box mb-3">
              <b>Seguridad</b><br>
              <div id="safetyText" class="small-note mt-2">La seguridad del fármaco seleccionado aparecerá aquí.</div>
            </div>

            <div class="good-box">
              <b>Multimodalidad</b><br>
              <div class="small-note mt-2">
                Paracetamol y AINEs deben considerarse de base cuando no estén contraindicados, para disminuir requerimiento de opioides y sus efectos adversos.
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Tips para residentes</div>
              <div class="teaching-main">
                En analgesia EV pediátrica, el error habitual no es elegir mal el fármaco: es no integrar edad, farmacología y monitorización
              </div>

              <div class="teaching-card">
                <b>1. Opioide no significa “simple rescate”</b><br>
                Un bolo EV o una infusión continua requieren personal entrenado, vigilancia respiratoria y evaluación seriada de sedación.
              </div>

              <div class="teaching-card">
                <b>2. Neonatos e infantes pequeños tienen menos margen</b><br>
                En menores de 1 año, especialmente con morfina, el riesgo de depresión respiratoria y acumulación es mayor.
              </div>

              <div class="teaching-card">
                <b>3. OSA cambia por completo el riesgo</b><br>
                En apnea obstructiva del sueño, reduce opioides 25–50% o evita su uso si es posible. 
              </div>

              <div class="teaching-card">
                <b>4. Las infusiones continuas son herramientas, no “piloto automático”</b><br>
                Lidocaína, dexmedetomidina, ketamina, morfina, sufentanilo o remifentanilo requieren indicación clara y vigilancia adecuada.
              </div>

              <div class="teaching-card">
                <b>5. Ketamina y lidocaína no son inocuas</b><br>
                La ketamina debe evitarse en neonatos según este esquema; la lidocaína EV exige monitoreo ECG continuo.
              </div>

              <div class="danger-box">
                <b>Mensaje final</b><br>
                Si un niño necesita infusión continua de opioide o co-analgésico EV, debes pensar siempre en monitorización, vía aérea, FR, sedación y contexto postoperatorio, no solo en el número de mcg/kg/h.
              </div>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Confirmar dosis, vía, contraindicaciones, función renal/hepática y nivel de monitorización requerido antes de indicar.
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

function round1(n){ return Math.round(n * 10) / 10; }
function round2(n){ return Math.round(n * 100) / 100; }

const DRUGS = {
  noopioide: {
    paracetamol: {
      nombre: "Paracetamol",
      presentacion: "EV 10 mg/mL",
      via: "EV, oral, rectal",
      safety: "Reducir dosis en neonatos o si hay riesgo hepático. Dosis máxima diaria 60–90 mg/kg según edad y vía.",
      dosis: {
        bolo: {label: "Carga EV", unit: "mg/kg", min: 15, max: 20, freq: "cada 6–8 h"},
        infusion: null,
        rescate: {label: "Mantenimiento EV", unit: "mg/kg", min: 10, max: 15, freq: "cada 6–8 h"}
      }
    },
    metamizol: {
      nombre: "Metamizol",
      presentacion: "EV / oral",
      via: "EV, oral",
      safety: "Uso hospitalario y corto plazo por riesgo de agranulocitosis. Útil en cirugía abdominal por efecto espasmolítico.",
      dosis: {
        bolo: {label: "Bolo EV", unit: "mg/kg", min: 10, max: 15, freq: "cada 8 h"},
        infusion: {label: "Infusión EV", unit: "mg/kg/h", min: 2.5, max: 2.5, freq: "continua"},
        rescate: {label: "Oral / bolo", unit: "mg/kg", min: 10, max: 10, freq: "cada 8 h"}
      }
    },
    ibuprofeno: {
      nombre: "Ibuprofeno",
      presentacion: "EV / oral / rectal",
      via: "EV, oral, rectal",
      safety: "Generalmente no recomendado en <6 meses, aunque disponible desde los 3 meses en algunos países.",
      dosis: {
        bolo: {label: "EV", unit: "mg/kg", min: 10, max: 10, freq: "cada 8 h"},
        infusion: null,
        rescate: {label: "Oral / rectal", unit: "mg/kg", min: 10, max: 10, freq: "cada 8 h"}
      }
    },
    ketorolaco: {
      nombre: "Ketorolaco",
      presentacion: "EV",
      via: "EV",
      safety: "Solo uso corto plazo (máx 48 h). Precaución en asmáticos o riesgo hemorrágico.",
      dosis: {
        bolo: {label: "Bolo intraop", unit: "mg/kg", min: 0.5, max: 1.0, freq: "máx 30 mg"},
        infusion: null,
        rescate: {label: "Mantenimiento", unit: "mg/kg", min: 0.15, max: 0.2, freq: "cada 6 h • máx 10 mg"}
      }
    },
    lidocaina: {
      nombre: "Lidocaína",
      presentacion: "EV",
      via: "EV",
      safety: "Requiere monitorización cardíaca continua y observación clínica.",
      dosis: {
        bolo: {label: "Bolo", unit: "mg/kg", min: 1.5, max: 1.5, freq: "inicial"},
        infusion: {label: "Infusión", unit: "mg/kg/h", min: 1.5, max: 1.5, freq: "continua hasta fin de cirugía"},
        rescate: null
      }
    },
    dexmedetomidina: {
      nombre: "Dexmedetomidina",
      presentacion: "EV",
      via: "EV",
      safety: "Agonista alfa-2; útil como ahorrador de opioides, pero puede producir bradicardia e hipotensión.",
      dosis: {
        bolo: {label: "Bolo", unit: "mcg/kg", min: 0.5, max: 1.0, freq: "inicial"},
        infusion: {label: "Infusión", unit: "mcg/kg/h", min: 0.2, max: 0.7, freq: "continua"},
        rescate: null
      }
    },
    ketamina: {
      nombre: "Ketamina",
      presentacion: "EV",
      via: "EV",
      safety: "Útil como co-analgésico ahorrador de opioides. Evitar en neonatos por neurotoxicidad según este esquema.",
      dosis: {
        bolo: {label: "Bolo intraop", unit: "mg/kg", min: 0.5, max: 0.5, freq: "según contexto"},
        infusion: {label: "Infusión EV", unit: "mg/kg/h", min: 0.1, max: 0.2, freq: "continua"},
        rescate: null
      }
    }
  },

  opioide: {
    morfina: {
      nombre: "Morfina",
      presentacion: "EV / SC",
      via: "EV bolo/infusión, SC infusión",
      safety: "Cuidado en <1 año, falla renal, hipovolemia y OSA. La vía SC es menos confiable.",
      dosis: {
        bolo: {label: "Intraop EV", unit: "mcg/kg", min: 25, max: 100, freq: "bolo"},
        infusion: {label: "Infusión EV", unit: "mcg/kg/h", min: 10, max: 40, freq: "continua"},
        rescate: {label: "Rescate", unit: "mcg/kg", min: 50, max: 200, freq: "cada 4–6 h según edad"}
      }
    },
    fentanilo: {
      nombre: "Fentanilo",
      presentacion: "EV",
      via: "EV",
      safety: "Opioide de acción corta, muy útil en PACU; requiere titulación al efecto.",
      dosis: {
        bolo: {label: "Intraop", unit: "mcg/kg", min: 1, max: 2, freq: "bolo"},
        infusion: null,
        rescate: {label: "Rescate PACU", unit: "mcg/kg", min: 0.5, max: 1, freq: "titulado al efecto"}
      }
    },
    tramadol: {
      nombre: "Tramadol",
      presentacion: "EV / oral",
      via: "EV, oral",
      safety: "Menor riesgo de depresión respiratoria, pero puede bajar umbral convulsivo. No combinar con ondansetrón.",
      dosis: {
        bolo: {label: "Bolo", unit: "mg/kg", min: 1, max: 1.5, freq: "cada 4–6 h"},
        infusion: null,
        rescate: {label: "Rescate", unit: "mg/kg", min: 1, max: 1.5, freq: "cada 4–6 h"}
      }
    },
    nalbufina: {
      nombre: "Nalbufina",
      presentacion: "EV",
      via: "EV",
      safety: "Útil como rescate en infantes y niños mayores.",
      dosis: {
        bolo: null,
        infusion: null,
        rescate: {label: "Rescate", unit: "mg/kg", minLt3m: 0.05, maxLt3m: 0.05, min: 0.1, max: 0.2, freq: "cada 3–4 h"}
      }
    },
    sufentanilo: {
      nombre: "Sufentanilo",
      presentacion: "EV",
      via: "EV",
      safety: "Potente, útil para atenuar respuesta hemodinámica a intubación; requiere monitorización estricta.",
      dosis: {
        bolo: {label: "Bolo", unit: "mcg/kg", min: 0.5, max: 1, freq: "inicial"},
        infusion: {label: "Infusión", unit: "mcg/kg/h", min: 0.5, max: 1, freq: "continua"},
        rescate: null
      }
    },
    remifentanilo: {
      nombre: "Remifentanilo",
      presentacion: "EV",
      via: "EV",
      safety: "Vida media ultra corta. Puede asociarse a hiperalgesia al suspenderse.",
      dosis: {
        bolo: null,
        infusion: {label: "Infusión", unit: "mcg/kg/min", min: 0.05, max: 0.3, freq: "continua"},
        rescate: null
      }
    }
  }
};

function renderDrugButtons(){
  const grupo = getSelected('grupo') || 'noopioide';
  const container = document.getElementById('drugButtons');
  container.innerHTML = '';

  const groupDrugs = DRUGS[grupo];
  Object.keys(groupDrugs).forEach(key => {
    const drug = groupDrugs[key];
    const id = 'drug_' + key;

    const wrap = document.createElement('div');
    wrap.innerHTML = `
      <input class="choice-check calc-trigger" type="radio" name="farmaco" id="${id}" value="${key}">
      <label class="choice-btn btn-drug" for="${id}">
        <i class="fa-solid fa-vial"></i>${drug.nombre}
      </label>
    `;
    container.appendChild(wrap);
  });

  const first = document.querySelector('input[name="farmaco"]');
  if(first){
    first.checked = true;
  }
}

function ageText(age){
  if(age === 'lt3m') return '<3 meses';
  if(age === '3to12m') return '3–12 meses';
  if(age === 'gt1y') return '>1 año';
  return '>12 años';
}

function rangeText(min, max){
  if(min === null || typeof min === 'undefined') return '-';
  if(min === max) return `${min}`;
  return `${min}–${max}`;
}

function calculateAnalgesia(){
  const peso = parseFloat(document.getElementById('pesoPaciente').value);
  const edad = getSelected('edad');
  const grupo = getSelected('grupo') || 'noopioide';
  const modo = getSelected('modo') || 'bolo';
  const farmacoKey = getSelected('farmaco');

  const planSummaryText = document.getElementById('planSummaryText');
  const doseValue = document.getElementById('doseValue');
  const doseNote = document.getElementById('doseNote');
  const presentationValue = document.getElementById('presentationValue');
  const presentationNote = document.getElementById('presentationNote');
  const frequencyValue = document.getElementById('frequencyValue');
  const frequencyNote = document.getElementById('frequencyNote');
  const riskText = document.getElementById('riskText');
  const riskSoft = document.getElementById('riskSoft');
  const safetyText = document.getElementById('safetyText');

  if(!farmacoKey || isNaN(peso) || peso <= 0 || !edad){
    planSummaryText.textContent = 'Selecciona peso, rango etáreo, grupo, modo y fármaco.';
    doseValue.textContent = '-';
    doseNote.textContent = 'Según peso y contexto';
    presentationValue.textContent = '-';
    frequencyValue.textContent = '-';
    riskText.textContent = 'Sin cálculo aún';
    riskSoft.textContent = 'Selecciona todos los parámetros para obtener una guía de uso.';
    safetyText.textContent = 'La seguridad del fármaco seleccionado aparecerá aquí.';
    return;
  }

  const drug = DRUGS[grupo][farmacoKey];
  const modeData = drug.dosis[modo];

  planSummaryText.textContent = `Paciente de ${peso.toString().replace('.', ',')} kg, ${ageText(edad)}, con ${drug.nombre} en modo ${modo}.`;

  if(!modeData){
    doseValue.textContent = 'No aplica';
    doseNote.textContent = `Este fármaco no tiene esquema de ${modo}.`;
    presentationValue.textContent = `${drug.presentacion}`;
    presentationNote.textContent = `${drug.via}`;
    frequencyValue.textContent = '-';
    frequencyNote.textContent = 'No descrito';
    riskText.textContent = 'Modo no definido';
    riskSoft.textContent = 'Selecciona otro modo o un fármaco compatible.';
    safetyText.textContent = drug.safety;
    return;
  }

  let min = modeData.min;
  let max = modeData.max;

  if(drug.nombre === 'Nalbufina' && modo === 'rescate'){
    if(edad === 'lt3m'){
      min = modeData.minLt3m;
      max = modeData.maxLt3m;
    }
  }

  let doseDisplay = '';
  let totalMin = null;
  let totalMax = null;

  if(modeData.unit.includes('/kg/h') || modeData.unit.includes('/kg/min')){
    totalMin = peso * min;
    totalMax = peso * max;
    doseDisplay = `${rangeText(round2(totalMin), round2(totalMax)).replace('.', ',')} ${modeData.unit.replace('/kg','')}`;
  } else {
    totalMin = peso * min;
    totalMax = peso * max;
    doseDisplay = `${rangeText(round2(totalMin), round2(totalMax)).replace('.', ',')} ${modeData.unit.split('/')[0]}`;
  }

  doseValue.innerHTML = doseDisplay;
  doseNote.textContent = `${rangeText(min, max).replace('.', ',')} ${modeData.unit} × ${peso.toString().replace('.', ',')} kg`;

  presentationValue.textContent = drug.presentacion;
  presentationNote.textContent = drug.via;

  frequencyValue.textContent = modeData.freq;
  frequencyNote.textContent = modeData.label;

  let interp = 'Uso habitual';
  let interpSoft = 'Integra siempre contexto clínico, comorbilidades, edad y necesidad real de monitorización.';

  if(grupo === 'opioide'){
    interp = 'Mayor vigilancia';
    interpSoft = 'Los opioides EV requieren monitoreo respiratorio y de sedación. En OSA, reducir dosis 25–50% o evitarlos si es posible.';
  }

  if(drug.nombre === 'Remifentanilo'){
    interp = 'Infusión de alta vigilancia';
    interpSoft = 'Es útil por su vida media ultra corta, pero puede favorecer hiperalgesia tras su suspensión.';
  }

  if(drug.nombre === 'Lidocaína'){
    interp = 'Monitoreo ECG obligatorio';
    interpSoft = 'La lidocaína EV exige monitorización cardíaca continua y observación clínica.';
  }

  if(drug.nombre === 'Ketamina' && edad === 'lt3m'){
    interp = 'Evitar en neonatos';
    interpSoft = 'Según este esquema, la ketamina debe evitarse en neonatos por preocupación de neurotoxicidad.';
  }

  if(drug.nombre === 'Morfina' && (edad === 'lt3m' || edad === '3to12m')){
    interp = 'Usar con especial prudencia';
    interpSoft = 'En menores de 1 año el margen de seguridad es menor; vigila depresión respiratoria y acumulación.';
  }

  riskText.textContent = interp;
  riskSoft.textContent = interpSoft;
  safetyText.textContent = drug.safety;
}

document.addEventListener('DOMContentLoaded', function(){
  renderDrugButtons();

  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('change', function(){
      if(el.name === 'grupo'){
        renderDrugButtons();
      }
      calculateAnalgesia();
    });
    el.addEventListener('input', calculateAnalgesia);
  });

  document.getElementById('pesoPaciente').addEventListener('input', calculateAnalgesia);

  document.addEventListener('change', function(e){
    if(e.target && e.target.name === 'farmaco'){
      calculateAnalgesia();
    }
    if(e.target && e.target.name === 'grupo'){
      setTimeout(calculateAnalgesia, 0);
    }
  });

  calculateAnalgesia();
});
</script>

<?php require("footer.php"); ?>