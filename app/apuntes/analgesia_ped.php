<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Resumen práctico de analgesia en pediatría, con cálculo automático por peso para analgésicos no opioides, opioides y coadyuvantes. Incluye selección por grupo etario para paracetamol y parámetros de PCA pediátrica.";
$formula = "Las dosis se calculan por peso y deben interpretarse según edad, contexto clínico, función respiratoria, función renal/hepática y necesidad de monitorización. En neonatos y lactantes pequeños debe extremarse la vigilancia con opioides.";
$referencias = array(
  "1.- Coté CJ, Lerman J. A Practice of Anesthesia for Infants and Children.",
  "2.- WHO Guidelines on the Pharmacological Treatment of Persisting Pain in Children.",
  "3.- American Academy of Pediatrics. Pediatric Pain Management Guidelines."
);

$icono_apunte = "<i class='fa-solid fa-syringe pe-3 pt-2'></i>";
$titulo_apunte = "Analgesia en Pediatría";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="ped-shell">

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
          }

          body{background:var(--bg);}
          .ped-shell{max-width:980px;margin:0 auto;}

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

          .calc-box{
            background:#fff;
            border:1px solid #e5e9f2;
            border-radius:18px;
            padding:16px;
            box-shadow:0 8px 20px rgba(0,0,0,.05);
            margin-bottom:1rem;
          }

          .calc-title{
            font-weight:700;
            font-size:1.02rem;
            color:#27458f;
            margin-bottom:14px;
          }

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.65rem;
          }

          .choice-check{
            display:none;
          }

          .choice-btn{
            display:block;
            width:100%;
            text-align:center;
            padding:.75rem .8rem;
            border:1px solid #dfe7f2;
            border-radius:14px;
            background:#fff;
            color:#1f2a37;
            font-weight:700;
            cursor:pointer;
            transition:.15s ease;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.06) inset;
          }

          .drug-card{
            border:1px solid #e9ecef;
            border-radius:12px;
            padding:12px;
            margin-bottom:12px;
            background:#fff;
          }

          .drug-title{
            font-weight:800;
            color:#1f2a37;
            margin-bottom:6px;
          }

          .drug-sub{
            color:#667085;
            font-size:.92rem;
            margin-bottom:10px;
          }

          .dose-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:.65rem;
          }

          .dose-chip{
            background:#f8fafc;
            border:1px solid #dfe7f2;
            border-radius:12px;
            padding:.7rem .8rem;
          }

          .dose-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#667085;
            margin-bottom:.2rem;
          }

          .dose-value{
            font-weight:700;
            color:#1f2a37;
          }

          .alert-soft{
            border-radius:1rem;
            padding:1rem;
            border:1px solid #e6e9ef;
          }
          .alert-good{background:var(--good); border-color:#cfe8e6;}
          .alert-warn{background:var(--warn); border-color:#ecd798;}
          .alert-danger{background:var(--danger); border-color:#f1c4be;}

          .pca-table th{
            background:#f8fafc;
            white-space:nowrap;
          }
          .pca-table td,.pca-table th{
            vertical-align:middle;
            text-align:center;
          }

          .tips-box{
            background:#fffdf8;
            border:1px solid #e9ecef;
            border-radius:1rem;
            padding:1rem;
          }

          .tips-box ul{
            margin:0;
            padding-left:1.15rem;
            line-height:1.65;
          }

          @media(max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .dose-grid{grid-template-columns:1fr;}
            .drug-sub{font-size:.88rem;}
            .choice-grid{grid-template-columns:1fr 1fr;}
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • dolor agudo pediátrico</div>
              <h1 class="h3 mb-2">Analgesia en Pediatría</h1>
              <div class="subtle text-white-50">Cálculo automático por peso, selector etario para paracetamol, opioides y PCA pediátrica.</div>
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

        <div class="calc-box">
          <div class="calc-title">Datos del paciente</div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Peso</label>
            <div class="input-group">
              <input type="number" step="0.1" min="0" id="pesoPed" class="form-control">
              <span class="input-group-text">kg</span>
            </div>
          </div>

          <div>
            <label class="form-label fw-semibold">Grupo etario para paracetamol</label>
            <div class="choice-grid">
              <div>
                <input class="choice-check" type="radio" name="grupoEta" id="eta_rnpt" value="rnpt">
                <label class="choice-btn" for="eta_rnpt">RNPT</label>
              </div>
              <div>
                <input class="choice-check" type="radio" name="grupoEta" id="eta_neonato" value="neonato">
                <label class="choice-btn" for="eta_neonato">Neonato</label>
              </div>
              <div>
                <input class="choice-check" type="radio" name="grupoEta" id="eta_45" value="45sem">
                <label class="choice-btn" for="eta_45">>45 sem EPC</label>
              </div>
              <div>
                <input class="choice-check" type="radio" name="grupoEta" id="eta_nino" value="nino" checked>
                <label class="choice-btn" for="eta_nino">Niño mayor</label>
              </div>
            </div>
          </div>

          <div class="small-note mt-2">
            Ingresa el peso y selecciona el grupo etario para calcular dosis ponderales.
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Analgésicos no opioides</div>

            <div class="drug-card">
              <div class="drug-title">Paracetamol</div>
              <div class="drug-sub">La dosis depende del grupo etario seleccionado.</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Grupo seleccionado</div>
                  <div class="dose-value" id="paraGrupo">Niño mayor</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Esquema</div>
                  <div class="dose-value" id="paraEsquema">15–20 mg/kg/dosis</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Dosis mínima</div>
                  <div class="dose-value" id="paraMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Dosis máxima</div>
                  <div class="dose-value" id="paraMax">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Metamizol</div>
              <div class="drug-sub">15–25 mg/kg/dosis cada 8 h</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Dosis mínima</div>
                  <div class="dose-value" id="metamizolMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Dosis máxima</div>
                  <div class="dose-value" id="metamizolMax">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Ibuprofeno oral o rectal</div>
              <div class="drug-sub">10 mg/kg/dosis</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Dosis calculada</div>
                  <div class="dose-value" id="ibuprofenoDose">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Diclofenaco</div>
              <div class="drug-sub">1 mg/kg oral o rectal</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Dosis calculada</div>
                  <div class="dose-value" id="diclofenacoDose">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Ketorolaco</div>
              <div class="drug-sub">0,5 mg/kg/dosis EV cada 8–12 h</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Dosis calculada</div>
                  <div class="dose-value" id="ketorolacoDose">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Probextra</div>
              <div class="drug-sub">Escalado alométrico aproximado en niños mayores de 2 años</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Rango de peso</div>
                  <div class="dose-value" id="probextraRango">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Dosis sugerida</div>
                  <div class="dose-value" id="probextraDose">-</div>
                </div>
              </div>
              <div class="small-note mt-2">Dosis máxima: 40 mg.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Coadyuvantes</div>

            <div class="drug-card">
              <div class="drug-title">Dexametasona</div>
              <div class="drug-sub">100–150 µg/kg dosis</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Dosis mínima</div>
                  <div class="dose-value" id="dexaMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Dosis máxima</div>
                  <div class="dose-value" id="dexaMax">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Ketamina</div>
              <div class="drug-sub">Bolo EV 0,25–0,5 mg/kg. Infusión 0,1–0,15 mg/kg/h.</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Bolo mínimo</div>
                  <div class="dose-value" id="ketaBoloMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Bolo máximo</div>
                  <div class="dose-value" id="ketaBoloMax">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Infusión mínima</div>
                  <div class="dose-value" id="ketaInfMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Infusión máxima</div>
                  <div class="dose-value" id="ketaInfMax">-</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Opioides</div>

            <div class="drug-card">
              <div class="drug-title">Morfina</div>
              <div class="drug-sub">Bolo 50–100 µg/kg IV cada 6 h. Infusión 10–40 µg/kg/h.</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Bolo mínimo</div>
                  <div class="dose-value" id="morfinaBoloMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Bolo máximo</div>
                  <div class="dose-value" id="morfinaBoloMax">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Infusión mínima</div>
                  <div class="dose-value" id="morfinaInfMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Infusión máxima</div>
                  <div class="dose-value" id="morfinaInfMax">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Fentanilo</div>
              <div class="drug-sub">Bolo 0,5–2 µg/kg IV cada 2–4 h. Infusión 0,5–2 µg/kg/h.</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Bolo mínimo</div>
                  <div class="dose-value" id="fentaBoloMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Bolo máximo</div>
                  <div class="dose-value" id="fentaBoloMax">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Infusión mínima</div>
                  <div class="dose-value" id="fentaInfMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Infusión máxima</div>
                  <div class="dose-value" id="fentaInfMax">-</div>
                </div>
              </div>
            </div>

            <div class="drug-card">
              <div class="drug-title">Metadona</div>
              <div class="drug-sub">50–100 µg/kg EV en bolo cada 6 h</div>
              <div class="dose-grid">
                <div class="dose-chip">
                  <div class="dose-label">Bolo mínimo</div>
                  <div class="dose-value" id="metadonaMin">-</div>
                </div>
                <div class="dose-chip">
                  <div class="dose-label">Bolo máximo</div>
                  <div class="dose-value" id="metadonaMax">-</div>
                </div>
              </div>
            </div>

            <div id="opioidAlert" class="alert-soft alert-warn mt-3">
              <strong>Alerta:</strong> en neonatos, lactantes pequeños y pacientes con compromiso respiratorio, la decisión de usar opioides debe ir acompañada de monitorización adecuada y reevaluación frecuente.
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">PCA pediátrica</div>

            <div class="table-responsive">
              <table class="table table-bordered pca-table mb-0">
                <thead>
                  <tr>
                    <th>Droga</th>
                    <th>Carga (µg/kg)</th>
                    <th>Bolo (µg/kg)</th>
                    <th>Lockout (min)</th>
                    <th>Infusión (µg/kg/h)</th>
                    <th>Dosis máxima 4 h (µg/kg)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>Morfina</strong></td>
                    <td>25-100</td>
                    <td>10-20</td>
                    <td>8-15</td>
                    <td>0-20</td>
                    <td>250-400</td>
                  </tr>
                  <tr>
                    <td><strong>Fentanilo</strong></td>
                    <td>0,5-1</td>
                    <td>0,5</td>
                    <td>5-10</td>
                    <td>0-0,5</td>
                    <td>7-10</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="small-note mt-2">
              Basado en Coté and Lerman, <em>A Practice of Anesthesia for Infants and Children</em>, Fifth Edition, 2013.
            </div>
          </div>
        </div>

        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="toggleTips"
          onchange="document.getElementById('tipsBox').style.display = this.checked ? 'block' : 'none';">
          <label class="form-check-label fw-semibold">
            Mostrar tips docentes
          </label>
        </div>

        <div id="tipsBox" style="display:none;">
          <div class="tips-box">
            <ul>
              <li>Siempre privilegiar analgesia multimodal para reducir consumo de opioides.</li>
              <li>En RN y lactantes la depresión respiratoria es más probable y puede ser más insidiosa.</li>
              <li>La PCA mejora autonomía y satisfacción en niños mayores cuando están bien seleccionados.</li>
              <li>Las infusiones continuas exigen más vigilancia que el simple cálculo de dosis.</li>
              <li>Ketamina puede ahorrar opioides y ser útil en dolor refractario.</li>
              <li>Con fármacos de distribución no lineal, el ajuste alométrico puede ser más útil que extrapolar una dosis estándar.</li>
            </ul>
          </div>
        </div>

        <div class="footer-note mt-3">
          Herramienta docente y de apoyo clínico. Verificar siempre edad, peso, contexto respiratorio y protocolos institucionales.
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

function getSelectedAgeGroup(){
  const checked = document.querySelector('input[name="grupoEta"]:checked');
  return checked ? checked.value : 'nino';
}

function fmtMg(v){
  return v.toFixed(2).replace('.', ',') + ' mg';
}
function fmtUg(v){
  return v.toFixed(1).replace('.', ',') + ' µg';
}
function fmtMgHr(v){
  return v.toFixed(2).replace('.', ',') + ' mg/h';
}
function fmtUgHr(v){
  return v.toFixed(1).replace('.', ',') + ' µg/h';
}

function calcProbextra(weight){
  if(weight >= 70) return {rango:'≥70 kg', dose:'Máximo 40 mg'};
  if(weight >= 40) return {rango:'40–69 kg', dose: fmtMg(weight * 0.6)};
  if(weight >= 25) return {rango:'25–39 kg', dose: fmtMg(weight * 0.7)};
  if(weight >= 15) return {rango:'15–24 kg', dose: fmtMg(weight * 0.8)};
  if(weight >= 10) return {rango:'10–14 kg', dose: fmtMg(weight * 0.9)};
  return {rango:'<10 kg', dose:'No definido en tabla'};
}

function updateParacetamol(weight){
  const grupo = getSelectedAgeGroup();

  let grupoTxt = '';
  let esquemaTxt = '';
  let minDose = null;
  let maxDose = null;

  if(grupo === 'rnpt'){
    grupoTxt = 'RNPT';
    esquemaTxt = '7,5 mg/kg';
    minDose = weight * 7.5;
    maxDose = weight * 7.5;
  } else if(grupo === 'neonato'){
    grupoTxt = 'Neonato';
    esquemaTxt = '10 mg/kg';
    minDose = weight * 10;
    maxDose = weight * 10;
  } else if(grupo === '45sem'){
    grupoTxt = '>45 sem EPC';
    esquemaTxt = '10–15 mg/kg/dosis';
    minDose = weight * 10;
    maxDose = weight * 15;
  } else {
    grupoTxt = 'Niño mayor';
    esquemaTxt = '15–20 mg/kg/dosis';
    minDose = weight * 15;
    maxDose = weight * 20;
  }

  document.getElementById('paraGrupo').textContent = grupoTxt;
  document.getElementById('paraEsquema').textContent = esquemaTxt;
  document.getElementById('paraMin').textContent = isNaN(weight) || weight <= 0 ? '-' : fmtMg(minDose);
  document.getElementById('paraMax').textContent = isNaN(weight) || weight <= 0 ? '-' : fmtMg(maxDose);
}

function updateAnalgesia(){
  const peso = parseFloat(document.getElementById('pesoPed').value);

  const ids = [
    'metamizolMin','metamizolMax','ibuprofenoDose','diclofenacoDose','ketorolacoDose',
    'probextraRango','probextraDose',
    'dexaMin','dexaMax',
    'ketaBoloMin','ketaBoloMax','ketaInfMin','ketaInfMax',
    'morfinaBoloMin','morfinaBoloMax','morfinaInfMin','morfinaInfMax',
    'fentaBoloMin','fentaBoloMax','fentaInfMin','fentaInfMax',
    'metadonaMin','metadonaMax'
  ];

  updateParacetamol(peso);

  if(isNaN(peso) || peso <= 0){
    ids.forEach(id => document.getElementById(id).textContent = '-');
    document.getElementById('probextraRango').textContent = '-';
    document.getElementById('opioidAlert').className = 'alert-soft alert-warn mt-3';
    return;
  }

  document.getElementById('metamizolMin').textContent = fmtMg(peso * 15);
  document.getElementById('metamizolMax').textContent = fmtMg(peso * 25);
  document.getElementById('ibuprofenoDose').textContent = fmtMg(peso * 10);
  document.getElementById('diclofenacoDose').textContent = fmtMg(peso * 1);
  document.getElementById('ketorolacoDose').textContent = fmtMg(peso * 0.5);

  const px = calcProbextra(peso);
  document.getElementById('probextraRango').textContent = px.rango;
  document.getElementById('probextraDose').textContent = px.dose;

  document.getElementById('dexaMin').textContent = fmtUg(peso * 100);
  document.getElementById('dexaMax').textContent = fmtUg(peso * 150);

  document.getElementById('ketaBoloMin').textContent = fmtMg(peso * 0.25);
  document.getElementById('ketaBoloMax').textContent = fmtMg(peso * 0.5);
  document.getElementById('ketaInfMin').textContent = fmtMgHr(peso * 0.1);
  document.getElementById('ketaInfMax').textContent = fmtMgHr(peso * 0.15);

  document.getElementById('morfinaBoloMin').textContent = fmtUg(peso * 50);
  document.getElementById('morfinaBoloMax').textContent = fmtUg(peso * 100);
  document.getElementById('morfinaInfMin').textContent = fmtUgHr(peso * 10);
  document.getElementById('morfinaInfMax').textContent = fmtUgHr(peso * 40);

  document.getElementById('fentaBoloMin').textContent = fmtUg(peso * 0.5);
  document.getElementById('fentaBoloMax').textContent = fmtUg(peso * 2);
  document.getElementById('fentaInfMin').textContent = fmtUgHr(peso * 0.5);
  document.getElementById('fentaInfMax').textContent = fmtUgHr(peso * 2);

  document.getElementById('metadonaMin').textContent = fmtUg(peso * 50);
  document.getElementById('metadonaMax').textContent = fmtUg(peso * 100);

  const opioidAlert = document.getElementById('opioidAlert');
  if(peso < 10){
    opioidAlert.className = 'alert-soft alert-danger mt-3';
    opioidAlert.innerHTML = '<strong>Alerta alta:</strong> peso bajo / paciente pequeño. Usar opioides con vigilancia estrecha, especialmente si se trata de neonato o lactante pequeño.';
  } else if(peso < 20){
    opioidAlert.className = 'alert-soft alert-warn mt-3';
    opioidAlert.innerHTML = '<strong>Alerta:</strong> en lactantes y niños pequeños, la monitorización respiratoria y la reevaluación frecuente son especialmente importantes.';
  } else {
    opioidAlert.className = 'alert-soft alert-good mt-3';
    opioidAlert.innerHTML = '<strong>Recordatorio:</strong> incluso en niños mayores, la seguridad con opioides depende más de la monitorización clínica que del número calculado.';
  }
}

document.addEventListener('DOMContentLoaded', function(){
  document.getElementById('pesoPed').addEventListener('input', updateAnalgesia);
  document.querySelectorAll('input[name="grupoEta"]').forEach(el => {
    el.addEventListener('change', updateAnalgesia);
  });
  updateAnalgesia();
});
</script>

<?php
require("footer.php");
?>