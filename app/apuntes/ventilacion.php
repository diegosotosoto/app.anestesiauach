<?php
$titulo_pagina = "Peso ideal y ventilación";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Cálculo de peso ideal y volumen corriente protector para ventilación mecánica perioperatoria. Ayuda a evitar sobreventilación, especialmente en obesidad, talla baja y pacientes con baja compliance.";
$formula = "Peso ideal Devine: Hombre = 50 + 0,91 × (talla cm − 152,4). Mujer = 45,5 + 0,91 × (talla cm − 152,4). Volumen corriente protector habitual: 6–8 mL/kg de peso ideal. En pulmón vulnerable o ARDS, preferir 6 mL/kg y guiar por presión meseta, driving pressure, oxigenación y ventilación minuto.";
$referencias = array(
  "Devine BJ. Gentamicin therapy. Drug Intell Clin Pharm. 1974.",
  "The Acute Respiratory Distress Syndrome Network. Ventilation with lower tidal volumes as compared with traditional tidal volumes for acute lung injury and the acute respiratory distress syndrome. N Engl J Med. 2000;342:1301-1308.",
  "Neto AS, Hemmes SNT, Barbas CSV, et al. Association between driving pressure and development of postoperative pulmonary complications in patients undergoing mechanical ventilation for general anaesthesia. Lancet Respir Med. 2016.",
  "Young CC, Harris EM, Vacchiano C, et al. Lung-protective ventilation for the surgical patient: international expert panel-based consensus recommendations. Br J Anaesth. 2019."
);

include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=2">
<script src="js/clinical-note-system.js?v=2"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .vent-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .vent-choice-grid.vent-grid-3{
            grid-template-columns:repeat(2,minmax(0,1fr));
          }

          .vent-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .vent-option{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:72px;
            border:2px solid var(--note-line);
            background:#fff;
            border-radius:1rem;
            padding:.65rem .75rem;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.18rem;
          }

          .vent-option i{
            color:#3559b7;
            font-size:1rem;
          }

          .vent-option-input:checked + .vent-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .vent-option-title{
            font-size:.9rem;
            font-weight:800;
            line-height:1.15;
            color:var(--note-text);
            margin:0;
          }

          .vent-option-sub{
            font-size:.76rem;
            line-height:1.22;
            color:var(--note-muted);
            margin:0;
            font-weight:600;
          }

          .vent-vt-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:.75rem;
          }

          .vent-vt-card{
            background:#fff;
            border:1px solid var(--note-line);
            border-radius:1rem;
            padding:.9rem 1rem;
            text-align:center;
          }

          .vent-vt-card.is-main{
            background:linear-gradient(180deg, var(--note-brand-soft) 0%, #f7faff 100%);
            border-color:var(--note-brand-soft-border);
          }

          .vent-vt-label{
            font-size:.78rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#3559b7;
            font-weight:800;
            margin-bottom:.22rem;
          }

          .vent-vt-value{
            font-size:1.18rem;
            line-height:1.15;
            font-weight:900;
            color:var(--note-text);
          }

          .vent-vt-note{
            margin-top:.28rem;
            font-size:.82rem;
            line-height:1.3;
            color:var(--note-muted);
          }

          .vent-action-list{
            display:grid;
            gap:.75rem;
          }

          .vent-action-item{
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            border:1px solid #d9e2ef;
            border-radius:1rem;
            background:#fff;
            padding:.75rem .85rem;
          }

          .vent-action-mark{
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

          .vent-action-mark.ok{background:#2ea663;}
          .vent-action-mark.mid{background:#f4c542;}
          .vent-action-mark.high{background:#d92d20;}

          .vent-action-copy{min-width:0;flex:1;}

          .vent-action-title{
            font-size:.95rem;
            font-weight:800;
            line-height:1.18;
            color:var(--note-text);
            margin-bottom:.1rem;
          }

          .vent-action-note{
            margin:0;
            font-size:.82rem;
            line-height:1.32;
            color:var(--note-muted);
          }

          .vent-plan-line{
            padding:.75rem .85rem;
            border-radius:.9rem;
            background:#fff;
            border:1px solid var(--note-line-strong);
            margin-bottom:.6rem;
          }

          .vent-plan-line:last-child{
            margin-bottom:0;
          }

          .vent-ok-card{
            background:#edf8f1 !important;
            border-color:#b7ddc3 !important;
          }

          .vent-mid-card{
            background:#fff9e8 !important;
            border-color:#ead38a !important;
          }

          .vent-danger-card{
            background:#fff1f1 !important;
            border-color:#efc0bd !important;
          }

          @media (max-width:768px){
            .vent-choice-grid,
            .vent-choice-grid.vent-grid-3{
              grid-template-columns:repeat(2,minmax(0,1fr));
            }

            .vent-vt-grid{
              grid-template-columns:1fr;
            }
          }

          @media (max-width:420px){
            .vent-choice-grid,
            .vent-choice-grid.vent-grid-3,
            .vent-vt-grid{
              grid-template-columns:1fr;
            }
          }
        </style>

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · VENTILACIÓN MECÁNICA · PABELLÓN</div>
          <h2>Peso ideal y volumen corriente</h2>
          <div class="note-hero-subtitle">Calcula peso ideal y rango de volumen corriente protector usando talla y sexo, no peso real.</div>
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
            <div class="note-section-label">Datos de entrada</div>

            <div class="note-grid mb-3">
              <div class="note-input-group">
                <label class="note-label">Talla</label>
                <div class="note-input-inline">
                  <input id="talla" type="text" inputmode="decimal" class="note-input">
                  <div class="note-input-unit">cm</div>
                </div>
              </div>


            </div>

            <div class="note-section-label">Sexo biológico para fórmula Devine</div>
            <div class="vent-choice-grid mb-3">
              <label>
                <input class="vent-option-input" type="radio" name="sexo" value="hombre" checked>
                <div class="vent-option">
                  <i class="fa-solid fa-person"></i>
                  <div class="vent-option-title">Hombre</div>
                  <div class="vent-option-sub">50 + 0,91 × Δtalla</div>
                </div>
              </label>
              <label>
                <input class="vent-option-input" type="radio" name="sexo" value="mujer">
                <div class="vent-option">
                  <i class="fa-solid fa-person-dress"></i>
                  <div class="vent-option-title">Mujer</div>
                  <div class="vent-option-sub">45,5 + 0,91 × Δtalla</div>
                </div>
              </label>
            </div>

            <div class="note-section-label">Estrategia ventilatoria</div>
            <div class="vent-choice-grid vent-grid-3">
              <label>
                <input class="vent-option-input" type="radio" name="estrategia" value="protectora" checked>
                <div class="vent-option">
                  <i class="fa-solid fa-shield-heart"></i>
                  <div class="vent-option-title">Protectora estándar</div>
                  <div class="vent-option-sub">6–8 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="vent-option-input" type="radio" name="estrategia" value="pulmon_vulnerable">
                <div class="vent-option">
                  <i class="fa-solid fa-lungs-virus"></i>
                  <div class="vent-option-title">Pulmón vulnerable</div>
                  <div class="vent-option-sub">preferir 6 mL/kg</div>
                </div>
              </label>
              <label>
                <input class="vent-option-input" type="radio" name="estrategia" value="obesidad">
                <div class="vent-option">
                  <i class="fa-solid fa-weight-scale"></i>
                  <div class="vent-option-title">Obesidad</div>
                  <div class="vent-option-sub">nunca peso real</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-summary-box mb-3">
          <div class="note-summary-box-title">Resumen</div>
          <div id="summaryNarrative" class="note-summary-box-text">Ingresa talla para calcular peso ideal y volumen corriente protector.</div>
          <div class="note-summary-grid-2">
            <div class="note-summary-item">
              <div class="note-summary-k">Sexo / talla</div>
              <div id="summaryPatient" class="note-summary-v">Hombre · -</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Peso ideal</div>
              <div id="summaryPBW" class="note-summary-v">-</div>
            </div>
            <div class="note-summary-item">
              <div class="note-summary-k">Estrategia</div>
              <div id="summaryStrategy" class="note-summary-v">Protectora estándar</div>
            </div>

          </div>
        </div>

        <div class="note-result-grid-2 mb-3">
          <div id="pbwCard" class="note-result-card">
            <div class="note-result-card-label">Peso ideal</div>
            <div id="pbwResult" class="note-result-card-value">-</div>
            <div id="pbwNote" class="note-result-card-note">Usar para programar volumen corriente.</div>
          </div>
          <div id="vtCard" class="note-result-card">
            <div class="note-result-card-label">Volumen corriente sugerido</div>
            <div id="vtMain" class="note-result-card-value">-</div>
            <div id="vtNote" class="note-result-card-note">Rango protector según peso ideal.</div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Rango por mL/kg de peso ideal</div>
            <div class="vent-vt-grid">
              <div class="vent-vt-card is-main">
                <div class="vent-vt-label">6 mL/kg</div>
                <div id="vt6" class="vent-vt-value">-</div>
                <div class="vent-vt-note">Base protectora</div>
              </div>
              <div class="vent-vt-card">
                <div class="vent-vt-label">7 mL/kg</div>
                <div id="vt7" class="vent-vt-value">-</div>
                <div class="vent-vt-note">Intermedio</div>
              </div>
              <div class="vent-vt-card">
                <div class="vent-vt-label">8 mL/kg</div>
                <div id="vt8" class="vent-vt-value">-</div>
                <div class="vent-vt-note">Extremo alto protector</div>
              </div>
            </div>
          </div>
        </div>

        <div id="algoBox" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Lectura clínica</div>
          <div id="interpMain" class="note-interpretation-main">Pendiente</div>
          <div id="interpSoft" class="note-interpretation-soft">Completa talla para generar un rango de volumen corriente. Ajusta según presión meseta, driving pressure, compliance y EtCO₂.</div>

          <div class="mt-3 text-start">
            <div class="vent-plan-line"><strong>Fórmula aplicada:</strong> <span id="formulaApplied">-</span></div>
            <div class="vent-plan-line"><strong>Ajuste posterior:</strong> <span id="adjustText">Revisar presión meseta, driving pressure, capnografía, oxigenación y mecánica respiratoria.</span></div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia clínica:</strong>
          <div id="warningText" class="mt-2">El volumen corriente debe calcularse con peso ideal, no con peso real. En obesidad, usar peso real puede producir sobreventilación marcada y volutrauma.</div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Conducta práctica</div>
            <div id="actionList" class="vent-action-list">
              <div class="vent-action-item">
                <div class="vent-action-mark mid"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="vent-action-copy">
                  <div class="vent-action-title">Ingresa talla</div>
                  <p class="vent-action-note">La talla, no el peso real, define el peso ideal para programar volumen corriente.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">El volumen corriente se calcula con talla, no con peso real</div>
          <div class="note-tips"><strong>Qué hacer:</strong> parte con 6–8 mL/kg de peso ideal y ajusta con presión meseta, driving pressure, EtCO₂ y oxigenación.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> usar peso real en obesidad. Es una receta directa para sobreventilar.</div>
          <div class="note-tips"><strong>Pulmón vulnerable:</strong> parte cerca de 6 mL/kg y acepta hipercapnia moderada si el contexto lo permite, evitando presiones excesivas.</div>
          <div class="note-tips"><strong>Volumen minuto:</strong> si necesitas más eliminación de CO₂, suele ser más seguro ajustar frecuencia antes que subir mucho el volumen corriente.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> un volumen “correcto” puede ser inseguro si la driving pressure es alta; la mecánica respiratoria manda.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem || {};

  function parseLocal(value){
    if(CNS.parseDecimal) return CNS.parseDecimal(value);
    const n = Number(String(value || '').replace(',', '.'));
    return Number.isFinite(n) ? n : null;
  }

  function fmt(value, decimals){
    if(!Number.isFinite(value)) return '-';
    if(CNS.formatNumber) return CNS.formatNumber(value, decimals);
    return Number(value).toLocaleString('es-CL', {maximumFractionDigits:decimals});
  }

  function setText(id, value){
    const el = document.getElementById(id);
    if(CNS.safeSetText) CNS.safeSetText(el, value);
    else if(el) el.textContent = value;
  }

  function getSelected(name){
    const el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function strategyText(value){
    if(value === 'pulmon_vulnerable') return 'Pulmón vulnerable';
    if(value === 'obesidad') return 'Obesidad';
    return 'Protectora estándar';
  }

  function calculatePBW(sexo, talla){
    if(sexo === 'mujer') return 45.5 + 0.91 * (talla - 152.4);
    return 50 + 0.91 * (talla - 152.4);
  }

  function renderActions(strategy, pbw){
    let items = [];

    if(!Number.isFinite(pbw)){
      items = [
        ['mid','Ingresa talla','La talla, no el peso real, define el peso ideal para programar volumen corriente.']
      ];
    } else {
      if(strategy === 'pulmon_vulnerable'){
        items = [
          ['high','Preferir 6 mL/kg','En pulmón vulnerable, evitar subir volumen corriente para corregir CO₂ sin revisar presiones.'],
          ['mid','Vigilar driving pressure','Si la driving pressure es alta, el problema no se soluciona solo bajando o subiendo mL.']
        ];
      } else if(strategy === 'obesidad'){
        items = [
          ['high','No usar peso real','La obesidad aumenta peso real, no tamaño pulmonar. Programar con peso ideal.'],
          ['mid','Revisar atelectasia y PEEP','En obesidad la estrategia requiere PEEP/reclutamiento prudente, no solo volumen bajo.']
        ];
      } else {
        items = [
          ['ok','Rango protector inicial','6–8 mL/kg de peso ideal es un punto de partida, no el final del ajuste.'],
          ['ok','Ajustar con mecánica','Revisar presión meseta, driving pressure, compliance, EtCO₂ y saturación.']
        ];
      }
    }

    document.getElementById('actionList').innerHTML = items.map(function(item){
      const icon = item[0] === 'ok' ? 'fa-check' : (item[0] === 'mid' ? 'fa-triangle-exclamation' : 'fa-bolt');
      return '<div class="vent-action-item">' +
        '<div class="vent-action-mark ' + item[0] + '"><i class="fa-solid ' + icon + '"></i></div>' +
        '<div class="vent-action-copy">' +
          '<div class="vent-action-title">' + item[1] + '</div>' +
          '<p class="vent-action-note">' + item[2] + '</p>' +
        '</div>' +
      '</div>';
    }).join('');
  }

  function updateVent(){
    const talla = parseLocal(document.getElementById('talla').value);
    const sexo = getSelected('sexo') || 'hombre';
    const strategy = getSelected('estrategia') || 'protectora';

    setText('summaryPatient', (sexo === 'hombre' ? 'Hombre' : 'Mujer') + ' · ' + (talla && talla > 0 ? fmt(talla,1) + ' cm' : '-'));
    setText('summaryStrategy', strategyText(strategy));

    if(!talla || talla <= 0){
      setText('summaryNarrative', 'Ingresa talla para calcular peso ideal y volumen corriente protector.');
      setText('summaryPBW', '-');
      setText('pbwResult', '-');
      setText('pbwNote', 'Usar para programar volumen corriente.');
      setText('vtMain', '-');
      setText('vtNote', 'Rango protector según peso ideal.');
      setText('vt6', '-');
      setText('vt7', '-');
      setText('vt8', '-');
      setText('interpMain', 'Pendiente');
      setText('interpSoft', 'Completa talla para generar un rango de volumen corriente. Ajusta según presión meseta, driving pressure, compliance y EtCO₂.');
      setText('formulaApplied', '-');
      renderActions(strategy, null);
      return;
    }

    const pbw = calculatePBW(sexo, talla);
    const vt6 = pbw * 6;
    const vt7 = pbw * 7;
    const vt8 = pbw * 8;

    const mainLow = strategy === 'pulmon_vulnerable' ? vt6 : vt6;
    const mainHigh = strategy === 'pulmon_vulnerable' ? vt6 : vt8;

    setText('summaryPBW', fmt(pbw,1) + ' kg');
    setText('pbwResult', fmt(pbw,1) + ' kg');
    setText('pbwNote', sexo === 'hombre'
      ? 'Devine hombre: 50 + 0,91 × (' + fmt(talla,1) + ' − 152,4).'
      : 'Devine mujer: 45,5 + 0,91 × (' + fmt(talla,1) + ' − 152,4).'
    );

    setText('vt6', fmt(vt6,0) + ' mL');
    setText('vt7', fmt(vt7,0) + ' mL');
    setText('vt8', fmt(vt8,0) + ' mL');

    if(strategy === 'pulmon_vulnerable'){
      setText('vtMain', fmt(vt6,0) + ' mL');
      setText('vtNote', 'Preferir 6 mL/kg y ajustar según presiones y gases.');
      document.getElementById('vtCard').className = 'note-result-card vent-mid-card';
      setText('interpMain', 'Partir bajo y proteger pulmón');
      setText('interpSoft', 'Para pulmón vulnerable, 6 mL/kg de peso ideal suele ser el punto de partida. Evita subir volumen si la presión meseta o driving pressure son altas.');
    } else if(strategy === 'obesidad'){
      setText('vtMain', fmt(vt6,0) + '–' + fmt(vt8,0) + ' mL');
      setText('vtNote', 'Calculado con peso ideal. No usar peso real.');
      document.getElementById('vtCard').className = 'note-result-card vent-danger-card';
      setText('interpMain', 'Usar peso ideal, no peso real');
      setText('interpSoft', 'En obesidad, el error peligroso es programar volumen corriente por peso real. Considera además PEEP, reclutamiento prudente y mecánica respiratoria.');
    } else {
      setText('vtMain', fmt(vt6,0) + '–' + fmt(vt8,0) + ' mL');
      setText('vtNote', 'Rango protector inicial 6–8 mL/kg.');
      document.getElementById('vtCard').className = 'note-result-card vent-ok-card';
      setText('interpMain', 'Rango protector inicial');
      setText('interpSoft', 'Usa el rango como punto de partida. El ajuste real depende de presión meseta, driving pressure, compliance, capnografía y oxigenación.');
    }

    document.getElementById('pbwCard').className = 'note-result-card vent-ok-card';

    setText('formulaApplied', sexo === 'hombre'
      ? '50 + 0,91 × (' + fmt(talla,1) + ' − 152,4)'
      : '45,5 + 0,91 × (' + fmt(talla,1) + ' − 152,4)'
    );

    if(fr && fr > 0){
      const minuteLow = (mainLow * fr) / 1000;
      const minuteHigh = (mainHigh * fr) / 1000;
      const minuteText = Math.abs(minuteLow - minuteHigh) < 0.01
        ? fmt(minuteLow,1) + ' L/min'
        : fmt(minuteLow,1) + '–' + fmt(minuteHigh,1) + ' L/min';
      setText('summaryMinute', minuteText);
      setText('minuteText', minuteText + ' con FR ' + fmt(fr,0) + ' rpm.');
    } else {
    }

    setText('summaryNarrative', (sexo === 'hombre' ? 'Hombre' : 'Mujer') + ', talla ' + fmt(talla,1) + ' cm. Peso ideal ' + fmt(pbw,1) + ' kg. Volumen corriente sugerido: ' + document.getElementById('vtMain').textContent + '.');

    renderActions(strategy, pbw);
  }

  document.getElementById('talla').addEventListener('input', updateVent);
  document.querySelectorAll('input[name="sexo"], input[name="estrategia"]').forEach(function(input){
    input.addEventListener('change', updateVent);
  });

  updateVent();
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php include("footer.php"); ?>
