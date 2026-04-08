<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Calculadora práctica de profilaxis antibiótica pediátrica perioperatoria. Permite estimar dosis por peso, mostrar el techo adulto cuando corresponde, y recordar el intervalo de redosis intraoperatoria.";
$formula = "En pediatría, la profilaxis antibiótica se calcula por peso (mg/kg), sin exceder la dosis máxima adulta cuando corresponde. La redosis intraoperatoria depende del tiempo quirúrgico y, en algunos casos, de pérdidas sanguíneas importantes.";
$referencias = array(
  "1.- Recommendations for Surgical Antibiotic Prophylaxis (Weight-Normalized).",
  "2.- Bratzler DW, Dellinger EP, Olsen KM, et al. Clinical practice guidelines for antimicrobial prophylaxis in surgery.",
  "3.- American Society of Health-System Pharmacists (ASHP). Surgical antimicrobial prophylaxis guidelines."
);

$icono_apunte = "<i class='fa-solid fa-shield-virus pe-3 pt-2'></i>";
$titulo_apunte = "Profilaxis Antibiótica Pediátrica";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="abx-shell">

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
          .abx-shell{max-width:980px;margin:0 auto;}

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
          .small-note{font-size:.84rem;color:var(--muted);}
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

          .section-box{
            background:#fff;
            border:1px solid #e5e9f2;
            border-radius:18px;
            padding:16px;
            box-shadow:0 8px 20px rgba(0,0,0,.05);
          }

          .section-title-ui{
            font-weight:700;
            font-size:1.02rem;
            color:#27458f;
            margin-bottom:14px;
          }

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.7rem;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:58px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:14px;
            padding:.75rem .8rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.2;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset;
          }

          .calc-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:1rem;
          }

          .result-box{
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
            padding:1rem;
          }

          .result-main{
            font-size:1.02rem;
            font-weight:700;
            color:var(--text);
          }

          .result-num{
            font-size:1.8rem;
            font-weight:800;
            line-height:1;
            color:#3559b7;
          }

          .meta-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:.75rem;
          }

          .meta-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.9rem;
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
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
          }

          .conduct-box{
            padding:1rem;
            border-radius:1rem;
            border:1px solid var(--line);
          }
          .conduct-ok{background:var(--good);}
          .conduct-mid{background:var(--warn);}
          .conduct-no{background:var(--danger);}
          .conduct-title{
            font-size:1.05rem;
            font-weight:800;
            color:#1f2a37;
            margin-bottom:.55rem;
          }

          .table-block-title{
            font-weight:700;
            color:#1f2a37;
            margin-bottom:10px;
            margin-top:2px;
          }

          .dose-table{
            font-size:.92rem;
          }
          .dose-table th{
            background:#f8fafc;
          }
          .dose-table td,.dose-table th{
            vertical-align:top;
          }

          .teaching-wrap{
            border:1px solid var(--line);
            border-radius:1.4rem;
            background:var(--soft);
            padding:1.25rem;
            overflow:hidden;
          }
          .teaching-title{
            font-size:1rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#64748b;
            text-align:center;
            margin-bottom:1rem;
          }
          .teaching-main{
            font-size:1.65rem;
            font-weight:800;
            text-align:center;
            color:#1f2a37;
            line-height:1.15;
            margin-bottom:1.2rem;
          }
          .teaching-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }
          .teaching-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1.25rem;
            padding:1.1rem 1rem;
            text-align:left;
          }
          .teaching-label{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#667085;
            margin-bottom:.55rem;
          }
          .teaching-text{
            font-size:1rem;
            line-height:1.45;
            color:#1f2a37;
            font-weight:700;
          }
          .teaching-soft{
            font-size:.95rem;
            line-height:1.55;
            color:#667085;
            font-weight:500;
            margin-top:.35rem;
          }

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid #ecd798;
            border-radius:1rem;
            padding:1rem;
          }

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          .small-chip{
            display:inline-block;
            padding:.18rem .5rem;
            border-radius:999px;
            background:#eef3ff;
            color:#27458f;
            font-size:.78rem;
            font-weight:700;
          }

          @media(max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .dose-table{font-size:.82rem;}
            .teaching-main{font-size:1.3rem;}
            .calc-grid{grid-template-columns:1fr;}
            .meta-grid{grid-template-columns:1fr;}
            .choice-grid{grid-template-columns:1fr 1fr;}
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • antibióticos en pabellón</div>
              <h1 class="h3 mb-2">Profilaxis antibiótica pediátrica</h1>
              <div class="subtle text-white-50">Calculadora por peso, techo adulto y redosis intraoperatoria.</div>
            </div>
            <span class="pill bg-light text-dark">Pediatría</span>
          </div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">
              Mostrar / ocultar
            </button>
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

        <div class="section-box mb-4">
          <div class="section-title-ui">Calculadora</div>

          <div class="calc-grid">
            <div>
              <label class="form-label fw-semibold">Peso</label>
              <div class="input-group mb-3">
                <input type="number" step="0.1" min="0" id="pesoAbx" class="form-control">
                <span class="input-group-text">kg</span>
              </div>
            </div>

            <div>
              <label class="form-label fw-semibold">Antibiótico</label>
              <div class="choice-grid">
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_cefazolina" value="cefazolina" checked>
                  <label class="choice-btn" for="abx_cefazolina">Cefazolina</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_clinda" value="clindamicina">
                  <label class="choice-btn" for="abx_clinda">Clindamicina</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_vanco" value="vancomicina">
                  <label class="choice-btn" for="abx_vanco">Vancomicina</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_genta" value="gentamicina">
                  <label class="choice-btn" for="abx_genta">Gentamicina</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_ampicilina" value="ampicilina">
                  <label class="choice-btn" for="abx_ampicilina">Ampicilina</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_ampisulb" value="ampicilina-sulbactam">
                  <label class="choice-btn" for="abx_ampisulb">Ampi-Sulb</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_cefuroximo" value="cefuroximo">
                  <label class="choice-btn" for="abx_cefuroximo">Cefuroximo</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_cefoxitina" value="cefoxitina">
                  <label class="choice-btn" for="abx_cefoxitina">Cefoxitina</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_metronidazol" value="metronidazol">
                  <label class="choice-btn" for="abx_metronidazol">Metronidazol</label>
                </div>
                <div>
                  <input class="choice-check" type="radio" name="abx" id="abx_ptz" value="piperacilin-tazobactam">
                  <label class="choice-btn" for="abx_ptz">Pip/Tazo</label>
                </div>
              </div>
            </div>
          </div>

          <div class="result-box mt-3">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
              <div>
                <div class="small-note">Dosis calculada</div>
                <div id="abxTexto" class="result-main">Ingresa el peso y selecciona un antibiótico.</div>
              </div>
              <div id="abxNum" class="result-num">-</div>
            </div>
          </div>

          <div class="meta-grid mt-3">
            <div class="meta-card">
              <div class="meta-label">Dosis pediátrica usada</div>
              <div id="metaPediatrica" class="meta-value">-</div>
            </div>
            <div class="meta-card">
              <div class="meta-label">Techo adulto</div>
              <div id="metaAdulto" class="meta-value">-</div>
            </div>
            <div class="meta-card">
              <div class="meta-label">Redosis intraoperatoria</div>
              <div id="metaRedosis" class="meta-value">-</div>
            </div>
            <div class="meta-card">
              <div class="meta-label">Comentario</div>
              <div id="metaComentario" class="meta-value">-</div>
            </div>
          </div>

          <div id="conductBox" class="conduct-box conduct-mid mt-3">
            <div id="conductTitle" class="conduct-title">Interpretación</div>
            <div id="conductText">La dosis final debe integrarse con peso, edad, tipo de cirugía, alergias, función renal y protocolo local.</div>
          </div>
        </div>

        <div class="section-box mb-4">
          <div class="section-title-ui">Tabla de referencia rápida</div>

          <div class="mint-box mb-3">
            <strong>Lectura rápida:</strong> la dosis pediátrica está expresada en <strong>mg/kg</strong> y, cuando corresponde, <strong>no debe exceder la dosis máxima adulta</strong>.
          </div>

          <div class="table-responsive">
            <table class="table table-bordered dose-table mb-0">
              <thead>
                <tr>
                  <th>Antibiótico</th>
                  <th>Dosis pediátrica</th>
                  <th>Dosis adulta</th>
                  <th>Redosis</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>Ampicilina-sulbactam</td><td>50 mg/kg (componente ampicilina)</td><td>3 g</td><td>2 h</td></tr>
                <tr><td>Ampicilina</td><td>50 mg/kg</td><td>2 g</td><td>2 h</td></tr>
                <tr><td>Aztreonam</td><td>30 mg/kg</td><td>2 g</td><td>4 h</td></tr>
                <tr><td>Cefazolina</td><td>30 mg/kg</td><td>2 g; usar 3 g si &gt;120 kg</td><td>4 h</td></tr>
                <tr><td>Cefuroximo</td><td>50 mg/kg</td><td>1.5 g</td><td>4 h</td></tr>
                <tr><td>Cefotaximo</td><td>50 mg/kg</td><td>1 g</td><td>3 h</td></tr>
                <tr><td>Cefoxitina</td><td>40 mg/kg</td><td>2 g</td><td>2 h</td></tr>
                <tr><td>Cefotetan</td><td>40 mg/kg</td><td>2 g</td><td>6 h</td></tr>
                <tr><td>Ceftriaxona</td><td>50-75 mg/kg</td><td>2 g</td><td>NA</td></tr>
                <tr><td>Ciprofloxacino</td><td>10 mg/kg</td><td>400 mg</td><td>NA</td></tr>
                <tr><td>Clindamycina</td><td>10 mg/kg</td><td>900 mg</td><td>6 h</td></tr>
                <tr><td>Ertapenem</td><td>15 mg/kg</td><td>1 g</td><td>NA</td></tr>
                <tr><td>Fluconazol</td><td>6 mg/kg</td><td>400 mg</td><td>NA</td></tr>
                <tr><td>Gentamicina</td><td>2.5 mg/kg (peso de dosificación)</td><td>5 mg/kg dosis única</td><td>Dosis única</td></tr>
                <tr><td>Levofloxacino</td><td>10 mg/kg</td><td>500 mg</td><td>NA</td></tr>
                <tr><td>Metronidazol</td><td>15 mg/kg; RN &lt;1200 g: 7.5 mg/kg dosis única</td><td>500 mg</td><td>NA</td></tr>
                <tr><td>Moxifloxacino</td><td>10 mg/kg</td><td>400 mg</td><td>NA</td></tr>
                <tr><td>Piperacilin-tazobactam</td><td>2–9 meses: 80 mg/kg piperacilina; &gt;9 meses y ≤40 kg: 100 mg/kg piperacilina</td><td>3.375 g</td><td>2 h</td></tr>
                <tr><td>Vancomicina</td><td>15 mg/kg</td><td>15 mg/kg</td><td>NA</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Perlas para residentes</div>
              <div class="teaching-main">La profilaxis antibiótica efectiva depende tanto de la dosis como del momento de administración</div>

              <div class="teaching-grid">
                <div class="teaching-card">
                  <div class="teaching-label">Dosis pediátrica</div>
                  <div class="teaching-text">Calcula por peso, pero recuerda el techo adulto</div>
                  <div class="teaching-soft">
                    En pediatría la mayoría de las dosis se expresan en mg/kg, pero no debe excederse la dosis máxima adulta cuando la guía lo indica.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Timing</div>
                  <div class="teaching-text">No basta con “dejarlo indicado”</div>
                  <div class="teaching-soft">
                    La profilaxis sirve si logra concentraciones adecuadas al momento de la incisión. Debe administrarse con tiempo suficiente antes del inicio quirúrgico.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Redosis</div>
                  <div class="teaching-text">Piensa en horas... y también en sangrado</div>
                  <div class="teaching-soft">
                    Si la cirugía se prolonga más allá del intervalo recomendado, o existe pérdida sanguínea importante, puede requerirse redosis intraoperatoria.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Perla práctica</div>
                  <div class="teaching-text">La profilaxis no reemplaza el juicio clínico</div>
                  <div class="teaching-soft">
                    El antibiótico depende del tipo de cirugía, flora esperada, alergias, edad, función renal, colonización conocida y protocolos locales.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="warn-box mb-3">
          <strong>Tip docente:</strong> antes de administrar profilaxis antibiótica en un niño, el residente debería poder responder tres preguntas:
          <strong>qué droga corresponde, cuánto pesa el paciente y si la cirugía va a requerir redosis</strong>.
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Verificar siempre protocolos institucionales, alergias, función renal y oportunidad de administración.
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

const abxData = {
  "cefazolina": {
    label: "Cefazolina",
    mgkg: 30,
    adultMg: 2000,
    redosis: "4 h",
    comment: "Usar 3 g si el paciente pesa >120 kg.",
    range: null
  },
  "clindamicina": {
    label: "Clindamycina",
    mgkg: 10,
    adultMg: 900,
    redosis: "6 h",
    comment: "Útil en alergia a betalactámicos según contexto.",
    range: null
  },
  "vancomicina": {
    label: "Vancomicina",
    mgkg: 15,
    adultMg: null,
    redosis: "NA",
    comment: "La dosis adulta también se expresa por kg.",
    range: null
  },
  "gentamicina": {
    label: "Gentamicina",
    mgkg: 2.5,
    adultMg: null,
    redosis: "Dosis única",
    comment: "Basada en peso de dosificación.",
    range: null
  },
  "ampicilina": {
    label: "Ampicilina",
    mgkg: 50,
    adultMg: 2000,
    redosis: "2 h",
    comment: "",
    range: null
  },
  "ampicilina-sulbactam": {
    label: "Ampicilina-sulbactam",
    mgkg: 50,
    adultMg: 3000,
    redosis: "2 h",
    comment: "Dosis expresada como componente ampicilina.",
    range: null
  },
  "cefuroximo": {
    label: "Cefuroximo",
    mgkg: 50,
    adultMg: 1500,
    redosis: "4 h",
    comment: "",
    range: null
  },
  "cefoxitina": {
    label: "Cefoxitina",
    mgkg: 40,
    adultMg: 2000,
    redosis: "2 h",
    comment: "",
    range: null
  },
  "metronidazol": {
    label: "Metronidazol",
    mgkg: 15,
    adultMg: 500,
    redosis: "NA",
    comment: "RN <1200 g: 7,5 mg/kg dosis única.",
    range: null
  },
  "piperacilin-tazobactam": {
    label: "Piperacilin-tazobactam",
    mgkg: null,
    adultMg: 3375,
    redosis: "2 h",
    comment: "Dosis expresada como componente piperacilina.",
    range: "ptz"
  }
};

function getSelectedAbx(){
  const el = document.querySelector('input[name="abx"]:checked');
  return el ? el.value : "cefazolina";
}

function fmtMg(v){
  if (v >= 1000) return (v/1000).toFixed(2).replace('.', ',') + " g";
  return v.toFixed(1).replace('.', ',') + " mg";
}

function calcDose(weight, data){
  if(data.range === "ptz"){
    if(weight > 40){
      return {text:"No definido en esta tabla para >40 kg", raw:null, capped:false, pediatric:"Ver esquema adulto/local"};
    }
    if(weight <= 0){
      return {text:"-", raw:null, capped:false, pediatric:"-"};
    }
    let mgkg = (weight > 9) ? 100 : 80;
    let dose = weight * mgkg;
    let capped = false;
    if(data.adultMg && dose > data.adultMg){
      dose = data.adultMg;
      capped = true;
    }
    return {
      text: fmtMg(dose),
      raw: dose,
      capped: capped,
      pediatric: mgkg + " mg/kg"
    };
  }

  if(weight <= 0){
    return {text:"-", raw:null, capped:false, pediatric:"-"};
  }

  let dose = weight * data.mgkg;
  let capped = false;

  if(data.adultMg && dose > data.adultMg){
    dose = data.adultMg;
    capped = true;
  }

  return {
    text: fmtMg(dose),
    raw: dose,
    capped: capped,
    pediatric: data.mgkg + " mg/kg"
  };
}

function updateAbxCalc(){
  const weight = parseFloat(document.getElementById('pesoAbx').value);
  const key = getSelectedAbx();
  const data = abxData[key];

  const abxNum = document.getElementById('abxNum');
  const abxTexto = document.getElementById('abxTexto');
  const metaPediatrica = document.getElementById('metaPediatrica');
  const metaAdulto = document.getElementById('metaAdulto');
  const metaRedosis = document.getElementById('metaRedosis');
  const metaComentario = document.getElementById('metaComentario');
  const conductBox = document.getElementById('conductBox');
  const conductTitle = document.getElementById('conductTitle');
  const conductText = document.getElementById('conductText');

  if(isNaN(weight) || weight <= 0){
    abxNum.textContent = "-";
    abxTexto.textContent = "Ingresa el peso y selecciona un antibiótico.";
    metaPediatrica.textContent = "-";
    metaAdulto.textContent = "-";
    metaRedosis.textContent = "-";
    metaComentario.textContent = "-";
    conductBox.className = "conduct-box conduct-mid mt-3";
    conductTitle.textContent = "Interpretación";
    conductText.textContent = "La dosis final debe integrarse con peso, edad, tipo de cirugía, alergias, función renal y protocolo local.";
    return;
  }

  const res = calcDose(weight, data);

  abxNum.textContent = res.text;
  abxTexto.textContent = data.label + ": dosis calculada por peso.";
  metaPediatrica.textContent = res.pediatric;
  metaAdulto.textContent = data.adultMg ? fmtMg(data.adultMg) : "Sin techo fijo en esta tabla";
  metaRedosis.textContent = data.redosis;
  metaComentario.textContent = data.comment ? data.comment : "Sin comentario adicional.";

  if(res.capped){
    conductBox.className = "conduct-box conduct-no mt-3";
    conductTitle.textContent = "Techo adulto alcanzado";
    conductText.innerHTML = "La dosis calculada por peso supera la dosis adulta máxima de referencia. Para este paciente se muestra el <strong>techo adulto</strong>.";
  } else if(data.redosis !== "NA" && data.redosis !== "Dosis única"){
    conductBox.className = "conduct-box conduct-ok mt-3";
    conductTitle.textContent = "Considera redosis";
    conductText.innerHTML = "Si la cirugía supera <strong>" + data.redosis + "</strong> o existe pérdida sanguínea importante, considera redosis intraoperatoria según contexto.";
  } else {
    conductBox.className = "conduct-box conduct-mid mt-3";
    conductTitle.textContent = "Sin redosis habitual";
    conductText.innerHTML = "En esta tabla no se describe una redosis intraoperatoria estándar para este antibiótico. Igualmente integra duración quirúrgica y contexto clínico.";
  }
}

document.addEventListener('DOMContentLoaded', function(){
  document.getElementById('pesoAbx').addEventListener('input', updateAbxCalc);
  document.querySelectorAll('input[name="abx"]').forEach(el => {
    el.addEventListener('change', updateAbxCalc);
  });
  updateAbxCalc();
});
</script>

<?php
require("footer.php");
?>