<?php

$titulo_info = "Utilidad clínica";
$descripcion_info = "Calculadora docente de profilaxis antibiótica pediátrica perioperatoria. Estima dosis por peso, muestra techo adulto cuando corresponde y recuerda redosis intraoperatoria.";
$formula = "Dosis pediátrica = mg/kg × peso. Cuando la guía lo indica, no debe excederse la dosis máxima adulta de referencia. La redosis intraoperatoria depende del antibiótico, la duración del procedimiento y el sangrado.";
$referencias = array(
  "Recommendations for Surgical Antibiotic Prophylaxis (Weight-Normalized).",
  "Bratzler DW, Dellinger EP, Olsen KM, et al. Clinical practice guidelines for antimicrobial prophylaxis in surgery.",
  "ASHP. Clinical practice guidelines for antimicrobial prophylaxis in surgery."
);

$icono_apunte = "<i class='fa-solid fa-shield-virus pe-3 pt-2'></i>";
$titulo_apunte = "Profilaxis antibiótica pediátrica";

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">

<?php
$abx_rows = array(
  array('key'=>'cefazolina','label'=>'Cefazolina','ped'=>'30 mg/kg','adult'=>'2 g; usar 3 g si >120 kg','redosis'=>'4 h'),
  array('key'=>'clindamicina','label'=>'Clindamicina','ped'=>'10 mg/kg','adult'=>'900 mg','redosis'=>'6 h'),
  array('key'=>'vancomicina','label'=>'Vancomicina','ped'=>'15 mg/kg','adult'=>'15 mg/kg','redosis'=>'NA'),
  array('key'=>'gentamicina','label'=>'Gentamicina','ped'=>'2,5 mg/kg (peso de dosificación)','adult'=>'5 mg/kg dosis única','redosis'=>'Dosis única'),
  array('key'=>'ampicilina','label'=>'Ampicilina','ped'=>'50 mg/kg','adult'=>'2 g','redosis'=>'2 h'),
  array('key'=>'ampicilina-sulbactam','label'=>'Ampicilina-sulbactam','ped'=>'50 mg/kg (componente ampicilina)','adult'=>'3 g','redosis'=>'2 h'),
  array('key'=>'cefuroximo','label'=>'Cefuroximo','ped'=>'50 mg/kg','adult'=>'1,5 g','redosis'=>'4 h'),
  array('key'=>'cefoxitina','label'=>'Cefoxitina','ped'=>'40 mg/kg','adult'=>'2 g','redosis'=>'2 h'),
  array('key'=>'metronidazol','label'=>'Metronidazol','ped'=>'15 mg/kg; RN <1200 g: 7,5 mg/kg dosis única','adult'=>'500 mg','redosis'=>'NA'),
  array('key'=>'piperacilina-tazobactam','label'=>'Piperacilina-tazobactam','ped'=>'2–9 meses: 80 mg/kg; >9 meses y ≤40 kg: 100 mg/kg (piperacilina)','adult'=>'3,375 g','redosis'=>'2 h')
);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell abx-note-shell">

        <style>
          .abx-drug-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.65rem;}
          .abx-option{min-width:0;display:flex;}
          .abx-option .drug-card{width:100%;min-height:68px;align-items:flex-start;justify-content:flex-start;text-align:left;padding:.55rem .65rem;}
          .abx-option .note-check:checked + .drug-card{box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);border:4px solid var(--note-selected);transform:translateY(-1px);}

          .abx-result-emphasis{font-size:2rem;font-weight:900;color:var(--note-brand);line-height:1;}
          .abx-reference-box{background:var(--note-card);border:1px solid var(--note-line);border-radius:1rem;padding:1rem;}
          .abx-table-card{background:var(--note-card);border:1px solid var(--note-line);border-radius:1rem;padding:1rem;}
          .abx-table{font-size:.92rem;margin-bottom:0;}
          .abx-table th{background:#f8fafc;font-size:.84rem;color:#475467;white-space:nowrap;}
          .abx-table td,.abx-table th{vertical-align:top;}
          .abx-note-shell .note-formula-left{font-size:.96rem;}
          .abx-note-shell .note-formula-num,.abx-note-shell .note-formula-den{font-size:.94rem;}

          @media(max-width:420px){
            .abx-drug-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero">
          <div class="note-hero-kicker">APP CLÍNICA · ANTIBIÓTICOS EN PABELLÓN</div>
          <h2>Profilaxis antibiótica pediátrica</h2>
          <p class="note-hero-subtitle">Cálculo por peso, techo adulto y redosis intraoperatoria para una lectura docente rápida y prudente.</p>
        </div>

        <div class="info-box">
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
            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0 ps-3">
                <?php foreach($referencias as $ref){ ?>
                  <li class="mb-1"><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Calculadora</div>

            <div class="note-input-group mb-3">
              <label class="note-label" for="pesoAbx">Peso</label>
              <div class="note-input-inline">
                <input type="text" id="pesoAbx" class="note-input" inputmode="decimal" placeholder="Ej: 18,5">
                <div class="note-input-unit">kg</div>
              </div>
            </div>

            <div class="note-input-group mb-3">
              <label class="note-label mb-2">Antibiótico</label>
              <div class="abx-drug-grid note-drug-grid">
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_cefazolina" value="cefazolina" checked>
                  <label class="drug-card drug-other" for="abx_cefazolina"><span class="drug-label-content"><span class="drug-label-title">Cefazolina</span><span class="drug-label-subtitle">30 mg/kg · redosis 4 h</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_clinda" value="clindamicina">
                  <label class="drug-card drug-other" for="abx_clinda"><span class="drug-label-content"><span class="drug-label-title">Clindamicina</span><span class="drug-label-subtitle">10 mg/kg · redosis 6 h</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_vanco" value="vancomicina">
                  <label class="drug-card drug-other" for="abx_vanco"><span class="drug-label-content"><span class="drug-label-title">Vancomicina</span><span class="drug-label-subtitle">15 mg/kg · sin redosis estándar</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_genta" value="gentamicina">
                  <label class="drug-card drug-other" for="abx_genta"><span class="drug-label-content"><span class="drug-label-title">Gentamicina</span><span class="drug-label-subtitle">2,5 mg/kg · dosis única</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_ampicilina" value="ampicilina">
                  <label class="drug-card drug-other" for="abx_ampicilina"><span class="drug-label-content"><span class="drug-label-title">Ampicilina</span><span class="drug-label-subtitle">50 mg/kg · redosis 2 h</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_ampisulb" value="ampicilina-sulbactam">
                  <label class="drug-card drug-other" for="abx_ampisulb"><span class="drug-label-content"><span class="drug-label-title">Ampi-Sulb</span><span class="drug-label-subtitle">50 mg/kg (ampicilina) · redosis 2 h</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_cefuroximo" value="cefuroximo">
                  <label class="drug-card drug-other" for="abx_cefuroximo"><span class="drug-label-content"><span class="drug-label-title">Cefuroximo</span><span class="drug-label-subtitle">50 mg/kg · redosis 4 h</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_cefoxitina" value="cefoxitina">
                  <label class="drug-card drug-other" for="abx_cefoxitina"><span class="drug-label-content"><span class="drug-label-title">Cefoxitina</span><span class="drug-label-subtitle">40 mg/kg · redosis 2 h</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_metronidazol" value="metronidazol">
                  <label class="drug-card drug-other" for="abx_metronidazol"><span class="drug-label-content"><span class="drug-label-title">Metronidazol</span><span class="drug-label-subtitle">15 mg/kg · sin redosis estándar</span></span></label>
                </div>
                <div class="abx-option">
                  <input class="note-check abx-check" type="radio" name="abx" id="abx_ptz" value="piperacilina-tazobactam">
                  <label class="drug-card drug-other" for="abx_ptz"><span class="drug-label-content"><span class="drug-label-title">Pip/Tazo</span><span class="drug-label-subtitle">80–100 mg/kg (piperacilina) · redosis 2 h</span></span></label>
                </div>
              </div>
            </div>

            <div id="validityWarning" class="note-warning note-hidden mb-3">
              <strong>Advertencia de validez:</strong> <span id="validityWarningText"></span>
            </div>

            <div class="note-card mb-3">
              <div class="note-card-body">
                <div class="note-card-title">Resumen</div>
                <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa el peso y selecciona un antibiótico para ver el resumen clínico rápido.</div>
                <div class="note-result-grid-2">
                  <div class="note-result-card">
                    <div class="note-result-card-label">Peso usado</div>
                    <div id="summaryPeso" class="note-result-card-value">No ingresado</div>
                  </div>
                  <div class="note-result-card">
                    <div class="note-result-card-label">Antibiótico</div>
                    <div id="summaryAbx" class="note-result-card-value">Cefazolina</div>
                  </div>
                  <div class="note-result-card">
                    <div class="note-result-card-label">Regla</div>
                    <div id="summaryRule" class="note-result-card-value">30 mg/kg</div>
                  </div>
                  <div class="note-result-card">
                    <div class="note-result-card-label">Redosis</div>
                    <div id="summaryRedose" class="note-result-card-value">4 h</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="note-result-grid-2 mb-3">
              <div class="note-result-card">
                <div class="note-result-card-label">Dosis calculada</div>
                <div id="abxNum" class="note-result-card-value">-</div>
                <div id="abxTexto" class="note-result-card-note">Ingresa el peso y selecciona un antibiótico.</div>
              </div>

              <div class="note-result-card">
                <div class="note-result-card-label">Dosis pediátrica usada</div>
                <div id="metaPediatrica" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Regla de la tabla para el cálculo inicial.</div>
              </div>

              <div class="note-result-card">
                <div class="note-result-card-label">Techo adulto</div>
                <div id="metaAdulto" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Se aplica cuando la guía lo define.</div>
              </div>

              <div class="note-result-card">
                <div class="note-result-card-label">Redosis intraoperatoria</div>
                <div id="metaRedosis" class="note-result-card-value">-</div>
                <div class="note-result-card-note">Depende de duración quirúrgica y sangrado.</div>
              </div>
            </div>

            <div id="conductBox" class="conduct-box note-warning">
              <div id="conductTitle" class="conduct-title">Interpretación</div>
              <div id="conductText">La dosis final debe integrarse con peso, edad, tipo de cirugía, alergias, función renal y protocolo local.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Tabla de referencia rápida</div>
            <div class="abx-reference-box mb-3">
              <strong>Lectura rápida:</strong> la dosis pediátrica se expresa en <strong>mg/kg</strong> y, cuando corresponde, <strong>no debe exceder la dosis máxima adulta</strong>.
            </div>
            <div class="abx-table-card">
              <div class="table-responsive">
                <table class="table table-bordered abx-table">
                  <thead>
                    <tr>
                      <th>Antibiótico</th>
                      <th>Dosis pediátrica</th>
                      <th>Dosis adulta</th>
                      <th>Redosis</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($abx_rows as $row){ ?>
                      <tr>
                        <td><?php echo $row['label']; ?></td>
                        <td><?php echo $row['ped']; ?></td>
                        <td><?php echo $row['adult']; ?></td>
                        <td><?php echo $row['redosis']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="note-teaching-wrap">
              <div class="note-teaching-title">Perlas para residentes</div>
              <div class="note-teaching-main">La profilaxis efectiva depende tanto de la dosis como del momento de administración</div>
              <div class="note-grid">
                <div class="note-tips">
                  <div class="teaching-label">Protocolos</div>
                  <div class="teaching-text">Primero mira la guía local</div>
                  <div class="teaching-soft">Este apunte sirve como apoyo docente, pero la selección final depende de flora esperada, epidemiología local y protocolos institucionales.</div>
                </div>
                <div class="note-tips">
                  <div class="teaching-label">Dosis pediátrica</div>
                  <div class="teaching-text">Calcula por peso, pero recuerda el techo adulto</div>
                  <div class="teaching-soft">El número matemático puede ser correcto y aun así no ser la dosis final adecuada si supera el máximo adulto de referencia.</div>
                </div>
                <div class="note-tips">
                  <div class="teaching-label">Timing</div>
                  <div class="teaching-text">No basta con dejar el antibiótico indicado</div>
                  <div class="teaching-soft">Debe administrarse con tiempo suficiente antes de la incisión para que existan concentraciones útiles cuando empieza la cirugía.</div>
                </div>
                <div class="note-tips">
                  <div class="teaching-label">Redosis</div>
                  <div class="teaching-text">Piensa en horas y en sangrado</div>
                  <div class="teaching-soft">Si la cirugía se prolonga o existe pérdida sanguínea importante, reevaluar redosis es parte del manejo intraoperatorio, no un detalle menor.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-warning mb-3">
          <strong>Advertencia visible:</strong> esta calculadora es orientativa. Verifica siempre alergias, función renal, edad, peso real útil para el cálculo, tipo de cirugía y protocolo institucional antes de administrar la profilaxis.
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. No reemplaza guías locales ni juicio clínico perioperatorio.
        </div>
      </div>
    </div>
  </div>
</div>

<script src="js/clinical-note-system.js?v=20260416-2"></script>
<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  if (CNS) CNS.bindSelectionSync('.abx-check');

  const abxData = {
    'cefazolina': {label:'Cefazolina', mgkg:30, adultMg:2000, redosis:'4 h', comment:'Usar 3 g si el paciente pesa >120 kg.', range:null},
    'clindamicina': {label:'Clindamicina', mgkg:10, adultMg:900, redosis:'6 h', comment:'Útil en alergia a betalactámicos según contexto.', range:null},
    'vancomicina': {label:'Vancomicina', mgkg:15, adultMg:null, redosis:'NA', comment:'La dosis adulta también se expresa por kg.', range:null},
    'gentamicina': {label:'Gentamicina', mgkg:2.5, adultMg:null, redosis:'Dosis única', comment:'Basada en peso de dosificación.', range:null},
    'ampicilina': {label:'Ampicilina', mgkg:50, adultMg:2000, redosis:'2 h', comment:'', range:null},
    'ampicilina-sulbactam': {label:'Ampicilina-sulbactam', mgkg:50, adultMg:3000, redosis:'2 h', comment:'Dosis expresada como componente ampicilina.', range:null},
    'cefuroximo': {label:'Cefuroximo', mgkg:50, adultMg:1500, redosis:'4 h', comment:'', range:null},
    'cefoxitina': {label:'Cefoxitina', mgkg:40, adultMg:2000, redosis:'2 h', comment:'', range:null},
    'metronidazol': {label:'Metronidazol', mgkg:15, adultMg:500, redosis:'NA', comment:'RN <1200 g: 7,5 mg/kg dosis única.', range:null},
    'piperacilina-tazobactam': {label:'Piperacilina-tazobactam', mgkg:null, adultMg:3375, redosis:'2 h', comment:'Dosis expresada como componente piperacilina.', range:'ptz'}
  };

  const pesoInput = document.getElementById('pesoAbx');
  const abxTexto = document.getElementById('abxTexto');
  const abxNum = document.getElementById('abxNum');
  const metaPediatrica = document.getElementById('metaPediatrica');
  const metaAdulto = document.getElementById('metaAdulto');
  const metaRedosis = document.getElementById('metaRedosis');
  const conductBox = document.getElementById('conductBox');
  const conductTitle = document.getElementById('conductTitle');
  const conductText = document.getElementById('conductText');
  const summaryNarrative = document.getElementById('summaryNarrative');
  const summaryPeso = document.getElementById('summaryPeso');
  const summaryAbx = document.getElementById('summaryAbx');
  const summaryRule = document.getElementById('summaryRule');
  const summaryRedose = document.getElementById('summaryRedose');

  function getSelectedAbx(){
    return CNS ? CNS.getSelected('abx') : (document.querySelector('input[name="abx"]:checked') || {}).value;
  }

  function formatMg(value){
    const n = Number(value);
    if (Number.isNaN(n)) return '-';
    if (n >= 1000) return CNS ? CNS.formatNumber(n / 1000, 2) + ' g' : (n / 1000).toFixed(2).replace('.', ',') + ' g';
    return CNS ? CNS.formatNumber(n, 1) + ' mg' : n.toFixed(1).replace('.', ',') + ' mg';
  }

  function setNeutralState(){
    abxNum.textContent = '-';
    abxTexto.textContent = 'Ingresa el peso y selecciona un antibiótico.';
    metaPediatrica.textContent = '-';
    metaAdulto.textContent = '-';
    metaRedosis.textContent = '-';
    summaryPeso.textContent = 'No ingresado';
    summaryNarrative.textContent = 'Ingresa el peso y selecciona un antibiótico para ver el resumen clínico rápido.';
    conductBox.className = 'conduct-box note-warning';
    conductTitle.textContent = 'Interpretación';
    conductText.textContent = 'La dosis final debe integrarse con peso, edad, tipo de cirugía, alergias, función renal y protocolo local.';
  }

  function calcDose(weight, data){
    if(data.range === 'ptz'){
      if(weight > 40){
        return {text:'No definido', raw:null, capped:false, pediatric:'Ver esquema adulto/local'};
      }
      const mgkg = weight > 9 ? 100 : 80;
      let dose = weight * mgkg;
      let capped = false;
      if(data.adultMg && dose > data.adultMg){
        dose = data.adultMg;
        capped = true;
      }
      return {text:formatMg(dose), raw:dose, capped:capped, pediatric:mgkg + ' mg/kg'};
    }

    let dose = weight * data.mgkg;
    let capped = false;
    if(data.adultMg && dose > data.adultMg){
      dose = data.adultMg;
      capped = true;
    }
    return {text:formatMg(dose), raw:dose, capped:capped, pediatric:data.mgkg + ' mg/kg'};
  }

  function updateUI(){
    const key = getSelectedAbx() || 'cefazolina';
    const data = abxData[key];
    const weight = CNS ? CNS.parseDecimal(pesoInput.value) : parseFloat(pesoInput.value);

    summaryAbx.textContent = data.label;
    summaryRule.textContent = data.range === 'ptz' ? '80–100 mg/kg' : (data.mgkg + ' mg/kg');
    summaryRedose.textContent = data.redosis;

    if (Number.isNaN(weight) || weight <= 0) {
      if (CNS) CNS.hideValidityWarning();
      setNeutralState();
      return;
    }

    const weightFmt = (CNS ? CNS.formatNumber(weight, 1) : String(weight).replace('.', ',')) + ' kg';
    summaryPeso.textContent = weightFmt;

    if (weight < 0.5 || weight > 150) {
      if (CNS) CNS.showValidityWarning('validityWarning', 'validityWarningText', 'El peso ingresado parece implausible para una calculadora pediátrica. Revisa unidad, coma decimal y contexto clínico.');
    } else if (CNS) {
      CNS.hideValidityWarning();
    }

    const res = calcDose(weight, data);

    abxNum.textContent = res.text;
    abxTexto.textContent = data.label + ': dosis calculada por peso.';
    metaPediatrica.textContent = res.pediatric;
    metaAdulto.textContent = data.adultMg ? formatMg(data.adultMg) : 'Sin techo fijo en esta tabla';
    metaRedosis.textContent = data.redosis;
    summaryNarrative.textContent = 'Paciente pediátrico de ' + weightFmt + '. ' + data.label + ' seleccionado. Dosis por peso, techo adulto cuando aplica y redosis orientativa.';

    if (res.capped) {
      conductBox.className = 'conduct-box note-danger';
      conductTitle.textContent = 'Techo adulto alcanzado';
      conductText.innerHTML = 'La dosis calculada por peso supera la dosis adulta máxima de referencia. Para este paciente se muestra el <strong>techo adulto</strong>.';
    } else if (data.redosis !== 'NA' && data.redosis !== 'Dosis única') {
      conductBox.className = 'conduct-box note-success';
      conductTitle.textContent = 'Considera redosis';
      conductText.innerHTML = 'Si la cirugía supera <strong>' + data.redosis + '</strong> o existe pérdida sanguínea importante, considera redosis intraoperatoria según contexto.';
    } else {
      conductBox.className = 'conduct-box note-warning';
      conductTitle.textContent = 'Sin redosis habitual';
      conductText.innerHTML = 'En esta tabla no se describe una redosis intraoperatoria estándar para este antibiótico. Igualmente integra duración quirúrgica y contexto clínico.';
    }
  }

  pesoInput.addEventListener('input', updateUI);
  document.querySelectorAll('input[name="abx"]').forEach(function(el){ el.addEventListener('change', updateUI); });
  updateUI();
})();
</script>

<?php require("../footer.php"); ?>
