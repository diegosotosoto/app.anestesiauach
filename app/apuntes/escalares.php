<?php
$titulo_pagina = "Escalares de dosificación";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para visualizar los principales escalares de dosificación en el paciente obeso adulto. Permite ingresar sexo, talla y peso total, seleccionar un escalar y mostrar su valor calculado, su relación con el peso total, su utilidad clínica y una fórmula docente simplificada.";
$formula = "Este apunte no reemplaza el juicio farmacológico. En obesidad, el peso total (TBW) rara vez debe usarse de forma automática para todos los fármacos. La elección del escalar depende del comportamiento farmacocinético, la hidrosolubilidad/liposolubilidad, el aclaramiento esperado y el objetivo clínico.";
$referencias = array(
  "Tabla de escalares de dosificación en el paciente obeso adulto aportada por el usuario.",
  "Cortínez LI. Anestesia intravenosa total en el paciente obeso. Rev Chil Anest. 2024;53(4):369-376.",
  "Janmahasatian S et al. Quantification of lean bodyweight. Clin Pharmacokinet. 2005;44(10):1051-1065.",
  "Shibutani K et al. Accuracy of pharmacokinetic models for predicting plasma fentanyl concentrations in lean and obese surgical patients: derivation of dosing weight ('pharmacokinetic mass'). Anesthesiology. 2004;101:603-613.",
  "Revisión sobre manejo anestésico del paciente obeso adulto (BMC Anesthesiology, 2022)."
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <style>
          .esc-sex-grid,
          .esc-scalar-grid{
            display:grid;
            gap:.75rem;
          }
          .esc-sex-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
          .esc-scalar-grid{grid-template-columns:repeat(4,minmax(0,1fr));}

          .esc-option-input{
            position:absolute;
            opacity:0;
            pointer-events:none;
          }

          .esc-option{
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:flex-start;
            text-align:left;
            min-height:56px;
            padding:.65rem .85rem;
            border-radius:1rem;
            border:2px solid var(--note-line);
            background:#fff;
            cursor:pointer;
            transition:.15s ease;
            box-shadow:0 3px 10px rgba(15,23,42,.04);
            gap:.75rem;
          }
          .esc-option-icon{
            font-size:1.1rem;
            color:var(--note-brand);
            width:1.5rem;
            text-align:center;
          }
          .esc-option-text{
            display:flex;
            flex-direction:column;
            gap:.15rem;
          }

          .esc-option-input:checked + .esc-option{
            box-shadow:0 0 0 3px rgba(47,128,237,.14), 0 8px 18px rgba(15,23,42,.10);
            border:4px solid var(--note-selected);
            transform:translateY(-1px);
          }

          .esc-choice-title{
            font-size:.98rem;
            font-weight:800;
            line-height:1.2;
            color:var(--note-text);
            margin:0;
          }
          .esc-choice-sub{
            font-size:.87rem;
            line-height:1.35;
            color:var(--note-muted);
            margin:0;
          }

          .esc-scalar-grid .esc-option{
            align-items:center;
            text-align:center;
            min-height:78px;
            padding:.7rem .65rem;
          }


          .esc-overview-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:.75rem;
          }

          .esc-overview-card{
            border-radius:1rem;
            padding:1rem;
            border:1px solid var(--note-line);
          }
          .esc-overview-card b{
            display:block;
            margin-bottom:.25rem;
          }

          .esc-blue{background:#eaf2ff;border-color:#bfd3ff;}
          .esc-yellow{background:#fff8db;border-color:#edd57a;}
          .esc-cyan{background:#eaf7fb;border-color:#b7ddeb;}
          .esc-green{background:#eaf8ef;border-color:#b7e4c7;}
          .esc-orange{background:#fff0e1;border-color:#f7b267;}
          .esc-purple{background:#f1edff;border-color:#d2c3ff;}
          .esc-gray{background:#f5f7fb;border-color:#d9e0ea;}
          .esc-red{background:#fdebec;border-color:#ef9a9a;}

          @media (max-width:992px){
            .esc-scalar-grid{grid-template-columns:repeat(3,minmax(0,1fr));}
          }
          @media (max-width:768px){
            .esc-scalar-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
            .esc-overview-grid{grid-template-columns:1fr;}
          }
          @media (max-width:420px){
            .esc-sex-grid{grid-template-columns:1fr;}
          }
        </style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · OBESIDAD · FARMACOLOGÍA PERIOPERATORIA</div>
          <h2>Escalares de dosificación en el paciente obeso adulto</h2>
          <div class="note-hero-subtitle">Selecciona sexo y escalar para visualizar el descriptor más útil según el contexto anestésico.</div>
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
            <div class="note-warning mb-3">
              <strong>Advertencia importante:</strong>
              <div class="mt-2">En obesidad mórbida, las fórmulas antiguas de masa magra tipo James pueden mostrar comportamiento anómalo y dejar de ser fiables. En este apunte se prioriza FFM válida sobre “LBW clásica”.</div>
            </div>
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

            <div class="esc-sex-grid mb-3">
              <label>
                <input class="esc-option-input" type="radio" name="sexo" value="m" checked>
                <div class="esc-option">
                  <div class="esc-option-icon"><i class="fa-solid fa-mars"></i></div>
                  <div class="esc-option-text">
                    <div class="esc-choice-title">Hombre</div>
                    <div class="esc-choice-sub">Pcte. masculino</div>
                  </div>
                </div>
              </label>
              <label>
                <input class="esc-option-input" type="radio" name="sexo" value="f">
                <div class="esc-option">
                  <div class="esc-option-icon"><i class="fa-solid fa-venus"></i></div>
                  <div class="esc-option-text">
                    <div class="esc-choice-title">Mujer</div>
                    <div class="esc-choice-sub">Pcte. femenina</div>
                  </div>
                </div>
              </label>
            </div>

            <div class="note-grid">
              <div class="note-input-group">
                <label class="note-label">Peso total</label>
                <div class="note-input-inline">
                  <input type="text" inputmode="decimal" class="note-input" id="peso">
                  <div class="note-input-unit">kg</div>
                </div>
              </div>

              <div class="note-input-group">
                <label class="note-label">Talla</label>
                <div class="note-input-inline">
                  <input type="text" inputmode="decimal" class="note-input" id="talla">
                  <div class="note-input-unit">cm</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Escalar seleccionado</div>

            <div class="esc-scalar-grid">
              <label>
                <input class="esc-option-input" type="radio" name="scalar" value="tbw" checked>
                <div class="esc-option esc-tbw">
                  <div class="esc-choice-title">TBW</div>
                  <div class="esc-choice-sub">Peso total</div>
                </div>
              </label>

              <label>
                <input class="esc-option-input" type="radio" name="scalar" value="bmi">
                <div class="esc-option esc-bmi">
                  <div class="esc-choice-title">BMI</div>
                  <div class="esc-choice-sub">IMC</div>
                </div>
              </label>

              <label>
                <input class="esc-option-input" type="radio" name="scalar" value="ibw">
                <div class="esc-option esc-ibw">
                  <div class="esc-choice-title">IBW / PCI</div>
                  <div class="esc-choice-sub">Peso ideal</div>
                </div>
              </label>

              <label>
                <input class="esc-option-input" type="radio" name="scalar" value="ffm">
                <div class="esc-option esc-ffm">
                  <div class="esc-choice-title">FFM</div>
                  <div class="esc-choice-sub">Masa libre de grasa</div>
                </div>
              </label>

              <label>
                <input class="esc-option-input" type="radio" name="scalar" value="abw">
                <div class="esc-option esc-abw">
                  <div class="esc-choice-title">ABW</div>
                  <div class="esc-choice-sub">Peso ajustado</div>
                </div>
              </label>

              <label>
                <input class="esc-option-input" type="radio" name="scalar" value="pk">
                <div class="esc-option esc-pk">
                  <div class="esc-choice-title">PK Mass</div>
                  <div class="esc-choice-sub">Masa farmacocinética</div>
                </div>
              </label>

              <label>
                <input class="esc-option-input" type="radio" name="scalar" value="bsa">
                <div class="esc-option esc-bsa">
                  <div class="esc-choice-title">BSA / SCT</div>
                  <div class="esc-choice-sub">Superficie corporal</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-card-title">Resumen</div>
            <div id="summaryNarrative" class="note-summary-box-text mb-3">Ingresa peso y talla para calcular el escalar seleccionado en un paciente obeso adulto.</div>
            <div class="note-result-grid-2">
              <div class="note-result-card">
                <div class="note-result-card-label">Sexo</div>
                <div id="sumSexo" class="note-result-card-value">Hombre</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Peso total</div>
                <div id="sumPeso" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">Talla</div>
                <div id="sumTalla" class="note-result-card-value">—</div>
              </div>
              <div class="note-result-card">
                <div class="note-result-card-label">IMC / categoría</div>
                <div id="sumIMC" class="note-result-card-value">—</div>
              </div>
            </div>
          </div>
        </div>

        <div id="mainCard" class="note-interpretation mb-3">
          <div class="note-interpretation-label">Escalar seleccionado</div>
          <div id="valorEscalar" class="note-interpretation-main">—</div>
          <div id="meaningEscalar" class="note-interpretation-soft">Ingrese peso y talla</div>

          <div class="note-result-grid-2 mt-3">
            <div class="note-result-card">
              <div class="note-result-card-label">Qué representa</div>
              <div id="softEscalar" class="note-result-card-note">El escalar seleccionado se mostrará cuando ingreses los datos del paciente.</div>
            </div>
            <div class="note-result-card">
              <div class="note-result-card-label">Fórmula</div>
              <div id="formulaEscalar" class="note-result-card-note">—</div>
            </div>
          </div>

          <div class="note-card p-3 mt-3">
            <div class="note-card-title">Utilidad anestésica</div>
            <div id="pearlEscalar" class="note-result-card-note">Evita usar valores por defecto: pueden inducir error clínico.</div>
          </div>
        </div>

        <div class="note-warning-item mb-3">
          <div class="note-warning-icon"><i class="fa-solid fa-check"></i></div>
          <div class="note-warning-copy">
            <div class="note-warning-title">Advertencia clínica</div>
            <p id="warningText" class="note-warning-note">En el paciente obeso, el error más frecuente es dosificar todo por peso total. El descriptor correcto depende de distribución, aclaramiento y objetivo farmacológico.</p>
          </div>
        </div>

        <div class="note-card mb-3">
          <div class="note-card-body">
            <div class="note-section-label">Resumen rápido de todos los escalares</div>
            <div class="esc-overview-grid">
              <div class="esc-overview-card esc-tbw"><b>TBW</b>Peso total real medido del paciente. Útil para describir al paciente, pero no como descriptor universal de dosis.</div>
              <div class="esc-overview-card esc-bmi"><b>BMI</b>Índice de masa corporal. Clasifica el grado de obesidad, pero no es un escalar directo de dosificación farmacológica.</div>
              <div class="esc-overview-card esc-ibw"><b>IBW / PCI</b>Peso Ideal. Peso basado en talla y sexo; sirve como referencia estructural y como base para otros escalares.</div>
              <div class="esc-overview-card esc-ffm"><b>FFM</b>Masa Libre de Grasa. Descriptor moderno preferido en obesidad mórbida para varios modelos farmacocinéticos.</div>
              <div class="esc-overview-card esc-abw"><b>ABW</b>Peso corregido: IBW + 40% del exceso de peso. Sigue siendo una aproximación clínica útil.</div>
              <div class="esc-overview-card esc-pk"><b>PK Mass</b>Masa Farmacocinética. Descriptor farmacocinético con fórmula propia. No equivale a FFM.</div>
              <div class="esc-overview-card esc-bsa"><b>BSA / SCT</b>Superficie corporal; útil para algunos contextos fisiológicos y hemodinámicos.</div>
              <div class="esc-overview-card esc-red"><b>Alometría</b>No es “otro peso”, sino una forma no lineal de escalar funciones como aclaramiento, en relación al tamaño y proporción de un órgano.</div>
            </div>
          </div>
        </div>

        <div class="note-teaching-wrap">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">En el obeso adulto, el error más frecuente es dosificar “todo por peso total”</div>
          <div class="note-tips"><strong>Qué hacer:</strong> antes de calcular una dosis, pregúntate si el fármaco depende más del volumen de distribución inicial, de la masa libre de grasa, del aclaramiento o de la superficie corporal.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> usar BMI como si fuera un escalar farmacológico o asumir que TBW sirve igual para inducción, mantención y opioides.</div>
          <div class="note-tips"><strong>Perla:</strong> FFM válida suele ser más robusta que las fórmulas antiguas de masa magra en obesidad mórbida. ABW sigue siendo útil como atajo clínico simple.</div>
          <div class="note-tips mb-0"><strong>Mensaje final:</strong> elegir mal el escalar puede ser más peligroso que equivocarse en unos pocos miligramos.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  const CNS = window.ClinicalNoteSystem;
  let sexoActual = 'm';
  let escalarActual = 'tbw';

  const pesoInput = document.getElementById('peso');
  const tallaInput = document.getElementById('talla');

  const scalarStyleMap = {
    tbw: {card: '', warning:'TBW describe al paciente, pero no debería asumirse como base universal de dosificación en obesidad.'},
    bmi: {card: '', warning:'El IMC clasifica obesidad, pero no es un escalar directo de farmacodosis.'},
    ibw: {card: '', warning:'IBW es una referencia estructural útil, pero puede subestimar requerimientos si se usa solo.'},
    ffm: {card: '', warning:'En obesidad mórbida, FFM suele ser más robusta que la masa magra clásica tipo James.'},
    abw: {card: '', warning:'ABW es una aproximación útil, pero sigue siendo una simplificación clínica.'},
    pk:  {card: '', warning:'PK Mass no equivale a FFM ni a TBW; su valor depende del contexto farmacocinético.'},
    bsa: {card: '', warning:'BSA aporta contexto fisiológico, pero rara vez es el escalar principal para dosis anestésicas.'}
  };

  function n(v, d){ return CNS.formatNumber(v, d); }

  function getPeso(){ return CNS.parseDecimal(pesoInput.value) || 0; }
  function getTallaCm(){ return CNS.parseDecimal(tallaInput.value) || 0; }
  function getTallaM(){ return getTallaCm() / 100; }

  function calcBMI(){
    const p = getPeso();
    const t = getTallaM();
    if(!p || !t) return 0;
    return p / (t * t);
  }

  function bmiCategoria(v){
    if(v < 18.5) return 'Bajo peso';
    if(v < 25) return 'Normopeso';
    if(v < 30) return 'Sobrepeso';
    if(v < 35) return 'Obesidad clase 1';
    if(v < 40) return 'Obesidad clase 2';
    return 'Obesidad clase 3';
  }

  function calcIBW(){
    const tallaCm = getTallaCm();
    if(!tallaCm) return 0;
    const tallaIn = tallaCm / 2.54;
    if(sexoActual === 'm'){
      return 50 + 2.3 * (tallaIn - 60);
    }
    return 45.5 + 2.3 * (tallaIn - 60);
  }

  function calcFFM(){
    const peso = getPeso();
    const tallaM = getTallaM();
    if(!peso || !tallaM) return 0;
    const talla2 = tallaM * tallaM;
    if(sexoActual === 'm'){
      const WHSmax = 42.92;
      const WHS50 = 30.93;
      return (WHSmax * talla2 * peso) / ((WHS50 * talla2) + peso);
    }
    const WHSmax = 37.99;
    const WHS50 = 35.98;
    return (WHSmax * talla2 * peso) / ((WHS50 * talla2) + peso);
  }

  function calcABW(){
    const tbw = getPeso();
    const ibw = calcIBW();
    if(!tbw || !ibw) return 0;
    return ibw + 0.4 * (tbw - ibw);
  }

  function calcPK(){
    const tbw = getPeso();
    if(!tbw) return 0;
    return 52 / (1 + ((196.4 * Math.exp(-0.025 * tbw) - 53.66) / 100));
  }

  function calcBSA(){
    const peso = getPeso();
    const tallaCm = getTallaCm();
    if(!peso || !tallaCm) return 0;
    return Math.sqrt((peso * tallaCm) / 3600);
  }

  function updateSummary(){
    const peso = getPeso();
    const talla = getTallaCm();
    const bmi = calcBMI();

    document.getElementById('sumSexo').textContent = sexoActual === 'm' ? 'Hombre' : 'Mujer';
    document.getElementById('sumPeso').textContent = peso ? n(peso,1) + ' kg' : '—';
    document.getElementById('sumTalla').textContent = talla ? n(talla,0) + ' cm' : '—';
    document.getElementById('sumIMC').textContent = (peso && talla) ? (n(bmi,1) + ' kg/m² · ' + bmiCategoria(bmi)) : '—';

    if(peso && talla){
      document.getElementById('summaryNarrative').textContent =
        (sexoActual === 'm' ? 'Hombre' : 'Mujer') + ' con ' + n(peso,1) + ' kg, ' + n(talla,0) + ' cm e IMC ' + n(bmi,1) + ' kg/m². Escalar seleccionado: ' + escalarActual.toUpperCase() + '.';
    } else {
      document.getElementById('summaryNarrative').textContent =
        'Ingresa peso y talla para calcular el escalar seleccionado en un paciente obeso adulto.';
    }
  }

  function renderEscalar(){
    const peso = getPeso();
    const talla = getTallaCm();

    const tbw = getPeso();
    const bmi = calcBMI();
    const ibw = calcIBW();
    const ffm = calcFFM();
    const abw = calcABW();
    const pk = calcPK();
    const bsa = calcBSA();

    const valor = document.getElementById('valorEscalar');
    const meaning = document.getElementById('meaningEscalar');
    const soft = document.getElementById('softEscalar');
    const formula = document.getElementById('formulaEscalar');
    const pearl = document.getElementById('pearlEscalar');
    const warningText = document.getElementById('warningText');

    if(!peso || !talla){
      valor.textContent = '—';
      meaning.textContent = 'Ingrese peso y talla';
      soft.textContent = 'El escalar seleccionado se mostrará cuando ingreses los datos del paciente.';
      formula.textContent = '—';
      pearl.textContent = 'Evita usar valores por defecto: pueden inducir error clínico.';
      warningText.textContent = 'En el paciente obeso, el error más frecuente es dosificar todo por peso total. El descriptor correcto depende de distribución, aclaramiento y objetivo farmacológico.';
      return;
    }

    if(escalarActual === 'tbw'){
      valor.textContent = n(tbw,1) + ' kg';
      meaning.textContent = 'Peso real medido del paciente';
      soft.textContent = 'Es el valor bruto en balanza y no distingue masa grasa, masa libre de grasa ni compartimentos farmacológicos.';
      formula.textContent = 'TBW = peso medido en balanza (kg).';
      pearl.textContent = 'Útil para describir al paciente, pero en obesidad no debe asumirse como base universal de dosificación.';
    } else if(escalarActual === 'bmi'){
      valor.textContent = n(bmi,1) + ' kg/m²';
      meaning.textContent = bmiCategoria(bmi);
      soft.textContent = 'Clasifica el grado de obesidad. Es una herramienta de estratificación, no un escalar directo de farmacodosis.';
      formula.textContent = 'BMI = Peso(kg) / Talla(m)².';
      pearl.textContent = 'Sirve para clasificar obesidad y riesgo global, pero no para decidir por sí solo cuánto anestésico u opioide usar.';
    } else if(escalarActual === 'ibw'){
      valor.textContent = n(ibw,1) + ' kg';
      meaning.textContent = 'Peso ideal / peso corporal ideal';
      soft.textContent = 'Representa un peso basado en talla y sexo. En obesidad es mucho menor al TBW.';
      formula.textContent = sexoActual === 'm'
        ? 'IBW (Devine, hombre) = 50 + 2.3 × (pulgadas sobre 60).'
        : 'IBW (Devine, mujer) = 45.5 + 2.3 × (pulgadas sobre 60).';
      pearl.textContent = 'Muy útil como referencia estructural y como base para otros escalares, pero puede subestimar requerimientos si se usa solo.';
    } else if(escalarActual === 'ffm'){
      valor.textContent = n(ffm,1) + ' kg';
      meaning.textContent = 'Fat-Free Mass / masa libre de grasa';
      soft.textContent = 'Descriptor moderno preferido en obesidad mórbida. Representa el compartimento no graso metabólicamente activo.';
      formula.textContent = sexoActual === 'm'
        ? 'FFM (Janmahasatian, hombre) = [42.92 × talla² × peso] / [(30.93 × talla²) + peso].'
        : 'FFM (Janmahasatian, mujer) = [37.99 × talla² × peso] / [(35.98 × talla²) + peso].';
      pearl.textContent = 'En obesidad mórbida, FFM es más confiable que la masa magra clásica tipo James para varios modelos farmacocinéticos.';
    } else if(escalarActual === 'abw'){
      valor.textContent = n(abw,1) + ' kg';
      meaning.textContent = 'Peso ajustado';
      soft.textContent = 'Escalar intermedio entre IBW y TBW. Corrige parcialmente el exceso de peso.';
      formula.textContent = 'ABW = IBW + 0.4 × (TBW − IBW).';
      pearl.textContent = 'Útil cuando el fármaco se distribuye parcialmente en grasa o cuando necesitas una aproximación clínica simple.';
    } else if(escalarActual === 'pk'){
      valor.textContent = n(pk,1) + ' kg';
      meaning.textContent = 'Masa farmacocinética';
      soft.textContent = 'Escalar relacionado con el aclaramiento de ciertos fármacos, especialmente útil como referencia docente para fentanyl en obesidad.';
      formula.textContent = 'PK Mass = 52 / [1 + ((196.4 × e^(-0.025 × TBW) - 53.66) / 100)].';
      pearl.textContent = 'No equivale a FFM. Aunque ambos se relacionan, PK Mass usa una fórmula propia y puede comportarse distinto del peso magro.';
    } else if(escalarActual === 'bsa'){
      valor.textContent = n(bsa,2) + ' m²';
      meaning.textContent = 'Superficie corporal total';
      soft.textContent = 'Escalar fisiológico basado en peso y talla. Se usa en algunos contextos de gasto cardíaco, VFG y fisiología global.';
      formula.textContent = 'Mosteller: BSA = √[(Peso × Talla cm) / 3600].';
      pearl.textContent = 'No suele ser el escalar de primera línea para la mayoría de las dosis anestésicas, pero sí puede aportar contexto fisiológico.';
    }

    warningText.textContent = scalarStyleMap[escalarActual].warning;
  }

  function recalculateAll(){
    updateSummary();
    renderEscalar();
    updateEscalarColors();
  }

  const escalarColors = {
    light: {
      tbw: ['#eaf2ff', '#c2d8ff'],
      bmi: ['#fff8db', '#edd57a'],
      ibw: ['#eaf7fb', '#b8e0f0'],
      ffm: ['#eaf8ef', '#b8e0c8'],
      abw: ['#fff0e1', '#ffd4a8'],
      pk: ['#f1edff', '#d4c8ff'],
      bsa: ['#f5f7fb', '#d9e0ea']
    },
    dark: {
      tbw: ['#1a3a5c', '#2d5a8a'],
      bmi: ['#5c501a', '#8a7a2d'],
      ibw: ['#1a4a5c', '#2d7a9a'],
      ffm: ['#1a4d3a', '#2d8a6a'],
      abw: ['#5c3a1a', '#8a5a2d'],
      pk: ['#3a1a5c', '#5a2d8a'],
      bsa: ['#3a3a3a', '#5a5a5a']
    }
  };

  function updateEscalarColors(){
    const isDark = document.body.classList.contains('theme-dark') || document.body.classList.contains('ui-nocturno');
    const colors = isDark ? escalarColors.dark : escalarColors.light;
    document.querySelectorAll('.esc-scalar-grid .esc-option, .esc-overview-card').forEach(function(el){
      const type = el.classList.contains('esc-tbw') ? 'tbw' :
        el.classList.contains('esc-bmi') ? 'bmi' :
        el.classList.contains('esc-ibw') ? 'ibw' :
        el.classList.contains('esc-ffm') ? 'ffm' :
        el.classList.contains('esc-abw') ? 'abw' :
        el.classList.contains('esc-pk') ? 'pk' :
        el.classList.contains('esc-bsa') ? 'bsa' : null;
      if(type && colors[type]){
        el.style.setProperty('background', colors[type][0], 'important');
        el.style.setProperty('border-color', colors[type][1], 'important');
      }
    });
  }

  document.querySelectorAll('input[name="sexo"]').forEach(function(input){
    input.addEventListener('change', function(){
      sexoActual = input.value;
      recalculateAll();
    });
  });

  document.querySelectorAll('input[name="scalar"]').forEach(function(input){
    input.addEventListener('change', function(){
      escalarActual = input.value;
      recalculateAll();
    });
  });

  pesoInput.addEventListener('input', recalculateAll);
  tallaInput.addEventListener('input', recalculateAll);

  recalculateAll();
  new MutationObserver(updateEscalarColors).observe(document.body, {attributes:true, attributeFilter:['class']});
})();

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("../footer.php"); ?>
