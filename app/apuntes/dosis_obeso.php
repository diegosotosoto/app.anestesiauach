<?php
$titulo_pagina = "Dosis Obeso";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Apunte interactivo para orientar qué descriptor corporal usar en el paciente obeso adulto según el fármaco y el momento de administración. No calcula dosis en mg: muestra el escalar sugerido para bolo/inducción y para mantención/infusión.";
$formula = "Escalares mostrados: TBW = peso total; IBW/PCI = peso ideal; FFM/LBW = masa libre de grasa; ABW = peso ajustado; PK Mass = masa farmacocinética. En propofol, una aproximación clínica útil para mantención es ABW con factor de corrección 0,4, porque el aclaramiento no escala linealmente con TBW en obesidad mórbida.";
$referencias = array(
  "1.- Tabla-resumen actualizada de dosificación en paciente adulto obeso aportada por el usuario.",
  "2.- Cortínez LI. Anestesia intravenosa total en el paciente obeso. Rev Chil Anest. 2024;53(4):369-376.",
  "3.- Janmahasatian S et al. Quantification of lean bodyweight. Clin Pharmacokinet. 2005;44(10):1051-1065.",
  "4.- Shibutani K et al. Accuracy of pharmacokinetic models for predicting plasma fentanyl concentrations in lean and obese surgical patients. Anesthesiology. 2004;101:603-613.",
  "5.- Eleveld DJ et al. An allometric model of remifentanil pharmacokinetics and pharmacodynamics. Anesthesiology. 2017;126:1005-1018.",
  "6.- Cortínez LI et al. Dexmedetomidine pharmacokinetics in the obese. Eur J Clin Pharmacol. 2015;71:1501-1508.",
  "7.- Morse JD et al. A universal pharmacokinetic model for dexmedetomidine in children and adults. J Clin Med. 2020;9:3480.",
  "8.- Li JY et al. Pharmacokinetics of a cisatracurium dose according to fat-free mass for anesthesia induction in morbidly obese patients. Nan Fang Yi Ke Da Xue Xue Bao. 2016;36(10):1396-1400."
);
include("head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=1">
<script src="js/clinical-note-system.js?v=1"></script>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0 ob-note-shell">

<style>
.ob-note-shell{max-width:1080px;}
.ob-drug-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:.65rem;}
.ob-cat-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.65rem;}
.ob-result-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:1rem;align-items:start;}
.ob-scale-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.8rem;}
.ob-scale-box{background:rgba(255,255,255,.78);border:1px solid rgba(16,42,67,.08);border-radius:1rem;padding:.95rem;}
.ob-scale-title{font-size:.76rem;text-transform:uppercase;letter-spacing:.05em;color:var(--note-muted);margin-bottom:.2rem;}
.ob-scale-name{font-size:1.12rem;font-weight:900;color:#0f172a;line-height:1.15;}
.ob-scale-value{font-size:1rem;font-weight:700;color:#1d4ed8;margin-top:.15rem;}
.ob-scale-sub{font-size:.84rem;color:#52627a;line-height:1.35;margin-top:.25rem;}
.ob-scalar-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:.65rem;}
.ob-scalar-pill{border-radius:1rem;border:1px solid #e5e7eb;padding:.8rem;background:#fff;}
.ob-scalar-pill .k{font-size:.72rem;text-transform:uppercase;color:var(--note-muted);margin-bottom:.15rem;}
.ob-scalar-pill .v{font-weight:800;color:var(--note-text);font-size:1rem;}
.ob-main-card{border-radius:1rem;padding:1rem;border:1px solid var(--note-brand-soft-border);background:var(--note-brand-soft);}
.ob-main-card.main-yellow{background:#fff7cc;border-color:#e6d36a;}
.ob-main-card.main-blue{background:#e8f1ff;border-color:#9fc2ff;}
.ob-main-card.main-red{background:#fdebec;border-color:#ef9a9a;}
.ob-main-card.main-gray{background:#f5f7fb;border-color:#cfd8e3;}
.ob-big-drug{font-size:1.8rem;font-weight:900;line-height:1.05;margin-bottom:.35rem;color:#102a43;}
.ob-big-cat{font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;color:#52627a;margin-bottom:.8rem;}
.ob-quick-card{background:#fff;border:1px solid #e5e7eb;border-radius:1rem;padding:1rem;margin-bottom:.8rem;}
.ob-quick-card a{font-weight:800;text-decoration:none;}
.ob-table-wrap{overflow:auto;border-radius:1rem;border:1px solid #e5e7eb;background:#fff;}
.ob-table{width:100%;border-collapse:collapse;min-width:900px;}
.ob-table th,.ob-table td{padding:.85rem .8rem;border-bottom:1px solid #e5e7eb;vertical-align:top;}
.ob-table thead th{background:#f8fafc;color:#0f172a;font-weight:800;font-size:.88rem;}
.ob-table .group-row td{background:#eef4ff;font-weight:900;color:#27458f;}
.ob-tag{display:inline-block;padding:.18rem .45rem;border-radius:999px;font-size:.74rem;font-weight:800;}
.ob-tag-yellow{background:#fff7cc;color:#8a6a00;}.ob-tag-blue{background:#e8f1ff;color:#1d4ed8;}.ob-tag-red{background:#fdebec;color:#b91c1c;}.ob-tag-orange{background:#fff0e1;color:#c2410c;}.ob-tag-green{background:#eaf8ef;color:#15803d;}.ob-tag-purple{background:#f1edff;color:#7c3aed;}.ob-tag-gray{background:#f5f7fb;color:#374151;}
.note-option.ob-choice,.note-option.ob-drug-option,.note-option.ob-cat-option{align-items:flex-start;justify-content:flex-start;text-align:left;padding:.8rem .85rem;min-height:72px;}
.note-option.ob-drug-option small,.note-option.ob-choice small,.note-option.ob-cat-option small{font-size:.74rem;}
.ob-cat-option.cat-hypnotics{background:#fff7cc;border-color:#e6d36a;}
.ob-cat-option.cat-opioids{background:#e8f1ff;border-color:#9fc2ff;}
.ob-cat-option.cat-nmb{background:#fdebec;border-color:#ef9a9a;}
.ob-cat-option.cat-reversal{background:repeating-linear-gradient(-45deg,#f5f7fb 0 12px,#e4e7eb 12px 24px);border-color:#bcc4cf;}
.ob-drug-option.drug-hypnotics{background:#fff7cc;border-color:#e6d36a;}
.ob-drug-option.drug-opioids{background:#e8f1ff;border-color:#9fc2ff;}
.ob-drug-option.drug-nmb{background:#fdebec;border-color:#ef9a9a;}
.ob-drug-option.drug-reversal{background:repeating-linear-gradient(-45deg,#f5f7fb 0 12px,#e4e7eb 12px 24px);border-color:#bcc4cf;}
@media (max-width:980px){.ob-result-grid{grid-template-columns:1fr;}.ob-scalar-grid{grid-template-columns:repeat(3,minmax(0,1fr));}.ob-cat-grid{grid-template-columns:repeat(2,minmax(0,1fr));}.ob-drug-grid{grid-template-columns:repeat(3,minmax(0,1fr));}}
@media (max-width:700px){.ob-scale-grid{grid-template-columns:1fr;}.ob-scalar-grid{grid-template-columns:repeat(2,minmax(0,1fr));}.ob-drug-grid{grid-template-columns:repeat(2,minmax(0,1fr));}}
@media (max-width:480px){.ob-scalar-grid{grid-template-columns:1fr;}.ob-big-drug{font-size:1.45rem;}}
</style>

<?php
$drugDB = array(
  'hipnoticos' => array(
    'nombre' => 'Hipnóticos y sedantes',
    'color' => 'main-yellow',
    'items' => array(
      'propofol' => array('nombre'=>'Propofol','bolo'=>array('IBW','FFM'),'mant'=>array('ABW40'),'mantLabel'=>'TBW alométrico o ABW (FC 0.4)','meaning'=>'Para inducción conviene usar un descriptor conservador como IBW o FFM. Para mantención, la evidencia moderna favorece escalado no lineal; clínicamente, ABW con FC 0,4 es una aproximación simple y útil.','pearl'=>'El error clásico es mantener propofol estrictamente proporcional a TBW en obesidad mórbida. Eso favorece sobredosis en infusión.'),
      'dexmedetomidina' => array('nombre'=>'Dexmedetomidina','bolo'=>array('IBW','ABW40'),'mant'=>array('FFM','ABW30','ABW40'),'mantLabel'=>'FFM o ABW (FC 0.3–0.4)','meaning'=>'La masa grasa tiene poco efecto sobre los clearances de dexmedetomidina. La mantención debe ajustarse con FFM o con ABW usando un FC bajo.','pearl'=>'Si subes la infusión linealmente con TBW, las concentraciones serán más altas de lo previsto en el obeso.'),
      'tiopental' => array('nombre'=>'Tiopental','bolo'=>array('FFM','TBW'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'El material docente lo sitúa en un rango entre FFM y TBW para el bolo. Interprétalo como intervalo clínico, no como permiso para ir siempre a TBW.','pearl'=>'Mientras más incierta sea la reserva hemodinámica, más sentido tiene iniciar en el extremo conservador del rango.'),
      'etomidato' => array('nombre'=>'Etomidato','bolo'=>array('FFM'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'Se aproxima a FFM para inducción, evitando sobredosificación por exceso de tejido adiposo.','pearl'=>'Etomidato resuelve menos el problema circulatorio, pero igual requiere un descriptor prudente.'),
      'midazolam' => array('nombre'=>'Midazolam','bolo'=>array('TBW'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'En la tabla resumida se mantiene con TBW para dosis inicial. Aun así, en obesidad y apnea del sueño debe titularse con cautela por acumulación y depresión respiratoria.','pearl'=>'Que la tabla diga TBW no significa que el bolo deba ser liberal.')
    )
  ),
  'opioides' => array(
    'nombre' => 'Opioides',
    'color' => 'main-blue',
    'items' => array(
      'fentanilo' => array('nombre'=>'Fentanilo','bolo'=>array('TBW'),'mant'=>array('FFM','PK'),'mantLabel'=>'FFM o PK Mass','meaning'=>'El bolo puede orientarse a TBW, pero la lógica de mantención se correlaciona mejor con FFM o PK Mass.','pearl'=>'PK Mass no es lo mismo que FFM. Es un descriptor farmacocinético con fórmula propia.'),
      'remifentanilo' => array('nombre'=>'Remifentanilo','bolo'=>array('IBW','FFM'),'mant'=>array('FFM'),'mantLabel'=>'FFM (masa libre de grasa)','meaning'=>'La obesidad no altera de forma relevante su metabolismo; por eso FFM/LBW funciona mejor que TBW.','pearl'=>'Remifentanilo por TBW en obesidad es una forma rápida de sobredosificar.'),
      'sufentanilo' => array('nombre'=>'Sufentanilo','bolo'=>array('TBW'),'mant'=>array('IBW'),'mantLabel'=>'IBW / PCI','meaning'=>'El bolo se aproxima a TBW y la mantención a IBW; separa claramente carga y fase sostenida.','pearl'=>'No asumas que por ser lipofílico todo el esquema debe ir por TBW.'),
      'morfina' => array('nombre'=>'Morfina','bolo'=>array('FFM'),'mant'=>array('TITULAR'),'mantLabel'=>'Titular según efecto','meaning'=>'Se prefiere FFM para la carga. La continuación no se resume en un descriptor fijo y debe titularse según analgesia, ventilación y contexto clínico.','pearl'=>'En obesidad, especialmente con OSA/OHS, “titular según efecto” es una medida de seguridad, no una vaguedad.')
    )
  ),
  'relajantes' => array(
    'nombre' => 'Bloqueadores neuromusculares',
    'color' => 'main-red',
    'items' => array(
      'succinilcolina' => array('nombre'=>'Succinilcolina','bolo'=>array('TBW'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'Es la excepción importante: en obesidad la dosis de succinilcolina sí se aproxima a TBW.','pearl'=>'No extrapoles esta regla a los no despolarizantes.'),
      'rocuronio' => array('nombre'=>'Rocuronio','bolo'=>array('IBW'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'Como relajante hidrófilo, no debería escalarse libremente por TBW en el obeso.','pearl'=>'TBW aumenta el riesgo de bloqueo más prolongado del esperado.'),
      'vecuronio' => array('nombre'=>'Vecuronio','bolo'=>array('IBW'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'En la tabla actual se resume con IBW / PCI.','pearl'=>'Es preferible un descriptor conservador más TOF que exceso de carga.'),
      'atracurio' => array('nombre'=>'Atracurio','bolo'=>array('TBW'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'La tabla lo resume con TBW. Sigue siendo razonable contrastarlo con respuesta neuromuscular real.','pearl'=>'Cuando una droga aparece en TBW, monitorizar sigue siendo obligatorio.'),
      'cisatracurio' => array('nombre'=>'Cisatracurio','bolo'=>array('FFM','TBW'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'La tabla actual acepta FFM o TBW, pero la evidencia moderna apoya bien FFM como descriptor funcional en obesidad.','pearl'=>'Si tienes FFM disponible, es una opción más coherente con la fisiología que un TBW automático.')
    )
  ),
  'reversores' => array(
    'nombre' => 'Reversores',
    'color' => 'main-gray',
    'items' => array(
      'sugammadex' => array('nombre'=>'Sugammadex','bolo'=>array('TBW','ABW40'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'En reversión profunda, usar TBW o ABW con FC 0,4 es defendible para evitar infradosificación.','pearl'=>'Quedarse corto en la reversión suele ser más peligroso que un pequeño exceso de fármaco.'),
      'neostigmina' => array('nombre'=>'Neostigmina','bolo'=>array('TBWMAX5'),'mant'=>array(),'mantLabel'=>'—','meaning'=>'Se resume como TBW con tope máximo de 5 mg.','pearl'=>'Aquí el máximo es tan importante como el descriptor.')
    )
  )
);
?>

<div class="note-hero mb-3">
  <div class="note-hero-kicker">APP CLÍNICA · FARMACOLOGÍA PERIOPERATORIA · OBESIDAD</div>
  <h2>Dosificación de fármacos en el paciente obeso adulto</h2>
  <div class="note-hero-subtitle">Resumen interactivo por categorías con el descriptor sugerido para bolo/inducción y para mantención/infusión.</div>
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
    <hr>
    <b>Referencias:</b>
    <ul class="mb-0"><?php foreach($referencias as $ref){ echo "<li>$ref</li>"; } ?></ul>
  </div>
</div>

<div class="note-card mb-3">
  <div class="note-card-body">
    <div class="note-card-title">Datos del paciente</div>
    <div class="note-grid">
      <div class="note-input-group">
        <label class="note-label">Sexo</label>
        <div class="note-choice-grid">
          <div>
            <input class="note-check" type="radio" name="sexo" id="sexo_m" checked>
            <label class="note-option ob-choice" for="sexo_m" onclick="setSexo('m')"><i class="fa-solid fa-person"></i>Hombre</label>
          </div>
          <div>
            <input class="note-check" type="radio" name="sexo" id="sexo_f">
            <label class="note-option ob-choice" for="sexo_f" onclick="setSexo('f')"><i class="fa-solid fa-person-dress"></i>Mujer</label>
          </div>
        </div>
      </div>
      <div class="note-input-group">
        <label class="note-label" for="peso">Peso total</label>
        <div class="note-input-inline"><input type="text" id="peso" class="note-input" inputmode="decimal"><div class="note-input-unit">kg</div></div>
      </div>
      <div class="note-input-group">
        <label class="note-label" for="talla">Talla</label>
        <div class="note-input-inline"><input type="text" id="talla" class="note-input" inputmode="decimal"><div class="note-input-unit">cm</div></div>
      </div>
      <div class="note-summary-box">
        <div class="note-summary-box-title">Resumen</div>
        <div id="summaryNarrative" class="note-summary-box-text">Ingresa peso total, talla y categoría farmacológica para mostrar los escalares disponibles y el descriptor sugerido.</div>
        <div class="note-summary-grid-2">
          <div class="note-summary-item"><div class="note-summary-k">Sexo</div><div id="sumSexo" class="note-summary-v">Hombre</div></div>
          <div class="note-summary-item"><div class="note-summary-k">IMC</div><div id="sumIMC" class="note-summary-v">—</div></div>
          <div class="note-summary-item"><div class="note-summary-k">Categoría</div><div id="sumCat" class="note-summary-v">Hipnóticos y sedantes</div></div>
          <div class="note-summary-item"><div class="note-summary-k">Fármaco</div><div id="sumDrug" class="note-summary-v">Propofol</div></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="note-card mb-3">
  <div class="note-card-body">
    <div class="note-card-title">Escalares disponibles</div>
    <div class="ob-scalar-grid">
      <div class="ob-scalar-pill"><div class="k">TBW</div><div id="vTBW" class="v">—</div></div>
      <div class="ob-scalar-pill"><div class="k">IBW / PCI</div><div id="vIBW" class="v">—</div></div>
      <div class="ob-scalar-pill"><div class="k">FFM / LBW</div><div id="vFFM" class="v">—</div></div>
      <div class="ob-scalar-pill"><div class="k">ABW</div><div id="vABW" class="v">—</div></div>
      <div class="ob-scalar-pill"><div class="k">PK Mass</div><div id="vPK" class="v">—</div></div>
    </div>
  </div>
</div>

<div class="note-card mb-3">
  <div class="note-card-body">
    <div class="note-card-title">Categoría farmacológica</div>
    <div class="ob-cat-grid">
      <div><input class="note-check" type="radio" name="categoria" id="cat_hip" checked><label class="note-option ob-cat-option cat-hypnotics" for="cat_hip" onclick="setCategoria('hipnoticos')"><i class="fa-solid fa-moon"></i>Hipnóticos / sedantes</label></div>
      <div><input class="note-check" type="radio" name="categoria" id="cat_op"><label class="note-option ob-cat-option cat-opioids" for="cat_op" onclick="setCategoria('opioides')"><i class="fa-solid fa-droplet"></i>Opioides</label></div>
      <div><input class="note-check" type="radio" name="categoria" id="cat_nm"><label class="note-option ob-cat-option cat-nmb" for="cat_nm" onclick="setCategoria('relajantes')"><i class="fa-solid fa-bolt"></i>Bloqueantes neuromusculares</label></div>
      <div><input class="note-check" type="radio" name="categoria" id="cat_rev"><label class="note-option ob-cat-option cat-reversal" for="cat_rev" onclick="setCategoria('reversores')"><i class="fa-solid fa-rotate-left"></i>Reversores</label></div>
    </div>
  </div>
</div>

<div class="note-card mb-3">
  <div class="note-card-body">
    <div class="note-card-title">Fármaco</div>
    <div id="drugGrid" class="ob-drug-grid"></div>
  </div>
</div>

<div class="ob-result-grid mb-3">
  <div class="ob-main-card main-yellow" id="mainCard">
    <div id="drugName" class="ob-big-drug">Propofol</div>
    <div id="drugCat" class="ob-big-cat">Hipnóticos y sedantes</div>
    <div class="ob-scale-grid mb-3">
      <div class="ob-scale-box">
        <div class="ob-scale-title">Bolo / inducción</div>
        <div id="boloName" class="ob-scale-name">IBW / FFM</div>
        <div id="boloValue" class="ob-scale-value">—</div>
        <div id="boloSub" class="ob-scale-sub">Usar descriptor conservador para evitar sobredosificación inicial.</div>
      </div>
      <div class="ob-scale-box">
        <div class="ob-scale-title">Mantención / infusión</div>
        <div id="mantName" class="ob-scale-name">TBW alométrico o ABW (FC 0.4)</div>
        <div id="mantValue" class="ob-scale-value">—</div>
        <div id="mantSub" class="ob-scale-sub">ABW 0,4 actúa como aproximación clínica simple del escalado no lineal.</div>
      </div>
    </div>
    <div class="note-card mb-3"><b>Interpretación clínica</b><br><span id="drugMeaning">El bolo e infusión de propofol no siguen la misma lógica. En mantención, el aclaramiento no aumenta linealmente con el peso real en obesidad mórbida.</span></div>
    <div class="note-warning"><b>Perla docente</b><br><span id="drugPearl">Cuando no dispones de un modelo TCI apropiado para obesidad, ABW con FC 0,4 es una aproximación práctica razonable para mantención de propofol.</span></div>
  </div>
  <div>
    <div class="ob-quick-card"><b>Escalares usados en este apunte</b><div class="small-note mt-2 mb-2">Aquí solo se muestra el nombre del descriptor y su valor. El detalle matemático está en el apunte de escalares.</div><a href="escalares.php"><i class="fa-solid fa-up-right-from-square pe-2"></i>Ir a Escalares de Peso</a></div>
    <div class="ob-quick-card"><b>Criterio práctico</b><br>En el obeso adulto no debes preguntar “¿todo por qué peso?”. La pregunta útil es “¿qué descriptor explica mejor el volumen de distribución inicial o el aclaramiento de este fármaco?”.</div>
    <div class="note-danger"><b>Seguridad</b><br>Este apunte orienta descriptor y lógica de ajuste. La dosis final debe titularse a contexto clínico, profundidad anestésica, EEG procesado si está disponible, hemodinamia, función orgánica y respuesta real del paciente.</div>
  </div>
</div>

<div class="note-card mb-3">
  <div class="note-card-body">
    <div class="note-card-title">Tabla completa resumida</div>
    <div class="ob-table-wrap"><table class="ob-table"><thead><tr><th>Fármaco</th><th>Bolo / inducción</th><th>Mantención / infusión</th><th>Comentario docente</th></tr></thead><tbody id="tablaCompleta"></tbody></table></div>
  </div>
</div>

<div class="note-teaching-wrap mb-3">
  <div class="note-teaching-title">Puntos clave</div>
  <div class="note-teaching-main">En el paciente obeso, el descriptor para la carga rara vez es el mismo que para la mantención</div>
  <div class="note-tips"><b>Propofol</b><br>El aclaramiento en obesidad se predice mejor con escalado no lineal; clínicamente, ABW con FC 0,4 es una alternativa simple para mantención.</div>
  <div class="note-tips"><b>Remifentanilo</b><br>La obesidad no justifica usar TBW. El descriptor más razonable es FFM/LBW, tanto para inicio como para mantención.</div>
  <div class="note-tips"><b>Dexmedetomidina</b><br>A mayor peso, no mantengas la misma tasa en mcg/kg/h basada en TBW. La mantención debe reducirse usando FFM o ABW con FC 0,3–0,4.</div>
  <div class="note-tips"><b>Fórmulas de James</b><br>En IMC &gt; 40 las ecuaciones antiguas de masa magra pueden comportarse mal. Este apunte usa una FFM válida en obesidad mórbida.</div>
  <div class="note-tips"><b>Cisatracurio</b><br>La nueva evidencia apoya que FFM funciona adecuadamente. Si tu medio aún usa TBW, al menos entiende que no es la única opción defendible.</div>
  <div class="note-danger"><b>Mensaje final</b><br>El descriptor correcto reduce error, pero no reemplaza titulación clínica. En obesidad con OSA/OHS, hipovolemia, fragilidad hemodinámica, edad avanzada o disfunción orgánica, la dosis efectiva puede ser menor que la sugerida por el descriptor.</div>
</div>

<script>
const CNS = window.ClinicalNoteSystem;
let sexoActual = 'm';
let categoriaActual = 'hipnoticos';
let farmacoActual = 'propofol';
const drugDB = <?php echo json_encode($drugDB, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); ?>;

function toggleInfo(){ window.toggleInfo ? window.toggleInfo() : document.getElementById('infoContent').classList.toggle('show'); }
function setSexo(s){ sexoActual = s; recalcularTodo(); }
function setCategoria(cat){ categoriaActual = cat; const keys = Object.keys(drugDB[cat].items); if(!keys.includes(farmacoActual)){ farmacoActual = keys[0]; } renderDrugGrid(); renderFarmaco(); }
function setFarmaco(key){ farmacoActual = key; renderFarmaco(); }
function n(v,d=1){ return Number.isFinite(v) ? CNS.formatNumber(v,d) : '—'; }
function getPeso(){ const v = CNS.parseDecimal(document.getElementById('peso').value); return Number.isFinite(v) ? v : 0; }
function getTallaCm(){ const v = CNS.parseDecimal(document.getElementById('talla').value); return Number.isFinite(v) ? v : 0; }
function getTallaM(){ return getTallaCm()/100; }
function calcBMI(){ const p=getPeso(), t=getTallaM(); return (p&&t)? p/(t*t):0; }
function bmiCategoria(v){ if(v < 18.5) return 'Bajo peso'; if(v < 25) return 'Normopeso'; if(v < 30) return 'Sobrepeso'; if(v < 35) return 'Obesidad clase 1'; if(v < 40) return 'Obesidad clase 2'; return 'Obesidad clase 3'; }
function calcIBW(){ const tallaCm=getTallaCm(); if(!tallaCm) return 0; const tallaIn=tallaCm/2.54; return sexoActual==='m' ? 50 + 2.3*(tallaIn-60) : 45.5 + 2.3*(tallaIn-60); }
function calcFFM(){ const peso=getPeso(), tallaM=getTallaM(); if(!peso||!tallaM) return 0; const talla2=tallaM*tallaM; if(sexoActual==='m'){ return (42.92*talla2*peso)/((30.93*talla2)+peso); } return (37.99*talla2*peso)/((35.98*talla2)+peso); }
function calcABW(fc){ const tbw=getPeso(), ibw=calcIBW(); return (tbw&&ibw)? ibw + fc*(tbw-ibw):0; }
function calcPK(){ const tbw=getPeso(); return tbw ? 52 / (1 + ((196.4 * Math.exp(-0.025 * tbw) - 53.66) / 100)) : 0; }
function scalarDisplay(code){ const tbw=getPeso(), ibw=calcIBW(), ffm=calcFFM(), abw40=calcABW(0.4), abw30=calcABW(0.3), pk=calcPK();
  if(code==='TBW') return {name:'TBW', value: tbw ? n(tbw,1)+' kg' : '—', sub:'Peso total'};
  if(code==='IBW') return {name:'IBW / PCI', value: ibw ? n(ibw,1)+' kg' : '—', sub:'Peso ideal'};
  if(code==='FFM') return {name:'FFM / LBW', value: ffm ? n(ffm,1)+' kg' : '—', sub:'Masa libre de grasa'};
  if(code==='ABW40') return {name:'ABW (FC 0.4)', value: abw40 ? n(abw40,1)+' kg' : '—', sub:'Peso ajustado'};
  if(code==='ABW30') return {name:'ABW (FC 0.3)', value: abw30 ? n(abw30,1)+' kg' : '—', sub:'Peso ajustado'};
  if(code==='PK') return {name:'PK Mass', value: pk ? n(pk,1)+' kg' : '—', sub:'Masa farmacocinética'};
  if(code==='TITULAR') return {name:'Titular según efecto', value:'No fijo', sub:'Sin descriptor único'};
  if(code==='TBWMAX5') return {name:'TBW (máx. 5 mg)', value: tbw ? n(tbw,1)+' kg' : '—', sub:'Recordar máximo absoluto'};
  return {name:'—',value:'—',sub:'—'};
}
function tagHTML(code){ if(code==='TBW') return '<span class="ob-tag ob-tag-blue">TBW</span>'; if(code==='IBW') return '<span class="ob-tag ob-tag-yellow">IBW</span>'; if(code==='FFM') return '<span class="ob-tag ob-tag-green">FFM/LBW</span>'; if(code==='ABW40') return '<span class="ob-tag ob-tag-orange">ABW 0.4</span>'; if(code==='ABW30') return '<span class="ob-tag ob-tag-orange">ABW 0.3</span>'; if(code==='PK') return '<span class="ob-tag ob-tag-purple">PK Mass</span>'; if(code==='TITULAR') return '<span class="ob-tag ob-tag-red">Titular</span>'; if(code==='TBWMAX5') return '<span class="ob-tag ob-tag-blue">TBW máx 5 mg</span>'; return '<span class="ob-tag ob-tag-gray">—</span>'; }
function tagsAndValues(codes){ if(!codes || !codes.length) return '<span class="ob-tag ob-tag-gray">—</span>'; return codes.map(c=>{ const s=scalarDisplay(c); return `<div style="margin-bottom:.25rem;">${tagHTML(c)} <span class="fw-bold">${s.value}</span></div>`; }).join(''); }
function resolveDrugButtonClass(catKey){ if(catKey==='hipnoticos') return 'drug-hypnotics'; if(catKey==='opioides') return 'drug-opioids'; if(catKey==='relajantes') return 'drug-nmb'; if(catKey==='reversores') return 'drug-reversal'; return ''; }
function updateSummary(){ const peso=getPeso(), talla=getTallaCm(), bmi=calcBMI(); CNS.safeSetText('sumSexo', sexoActual==='m' ? 'Hombre':'Mujer'); CNS.safeSetText('sumIMC', (peso&&talla)? n(bmi,1)+' kg/m²':'—'); CNS.safeSetText('sumCat', drugDB[categoriaActual].nombre); CNS.safeSetText('sumDrug', drugDB[categoriaActual].items[farmacoActual].nombre); CNS.safeSetText('vTBW', peso ? n(peso,1)+' kg':'—'); CNS.safeSetText('vIBW', talla ? n(calcIBW(),1)+' kg':'—'); CNS.safeSetText('vFFM', (peso&&talla) ? n(calcFFM(),1)+' kg':'—'); CNS.safeSetText('vABW', (peso&&talla) ? n(calcABW(0.4),1)+' kg':'—'); CNS.safeSetText('vPK', peso ? n(calcPK(),1)+' kg':'—'); const summary = !peso || !talla ? 'Ingresa peso total, talla y categoría farmacológica para mostrar los escalares disponibles y el descriptor sugerido.' : `${drugDB[categoriaActual].items[farmacoActual].nombre}; IMC ${n(bmi,1)} kg/m² (${bmiCategoria(bmi)}). Revisa si el descriptor para bolo coincide o no con el de mantención.`; CNS.safeSetText('summaryNarrative', summary); }
function renderDrugGrid(){ const wrap=document.getElementById('drugGrid'); const cat=drugDB[categoriaActual]; wrap.innerHTML = Object.entries(cat.items).map(([key,item])=>`<div><input class="note-check" type="radio" name="drug" id="drug_${key}" ${key===farmacoActual?'checked':''}><label class="note-option ob-drug-option ${resolveDrugButtonClass(categoriaActual)}" for="drug_${key}" onclick="setFarmaco('${key}')">${item.nombre}<small>${item.bolo.length ? item.bolo.join(' / ').replaceAll('ABW40','ABW0.4').replaceAll('ABW30','ABW0.3') : 'sin bolo fijo'}</small></label></div>`).join(''); }
function renderFarmaco(){ const cat=drugDB[categoriaActual]; const drug=cat.items[farmacoActual]; const card=document.getElementById('mainCard'); card.className = 'ob-main-card ' + cat.color; CNS.safeSetText('drugName', drug.nombre); CNS.safeSetText('drugCat', cat.nombre); CNS.safeSetText('sumCat', cat.nombre); CNS.safeSetText('sumDrug', drug.nombre);
  const peso=getPeso(), talla=getTallaCm(); if(!peso || !talla){ CNS.safeSetText('boloName','—'); CNS.safeSetText('boloValue','—'); CNS.safeSetText('boloSub','Ingresa peso y talla para calcular los descriptores.'); CNS.safeSetText('mantName','—'); CNS.safeSetText('mantValue','—'); CNS.safeSetText('mantSub','Ingresa peso y talla para calcular los descriptores.'); CNS.safeSetText('drugMeaning','Para mostrar los valores reales de los descriptores, primero ingresa peso total y talla.'); CNS.safeSetText('drugPearl','Evita trabajar con valores por defecto.'); renderTablaCompleta(); return; }
  CNS.safeSetText('boloName', drug.bolo && drug.bolo.length ? drug.bolo.map(c => scalarDisplay(c).name).join(' / ') : '—');
  CNS.safeSetText('boloValue', drug.bolo && drug.bolo.length ? drug.bolo.map(c => scalarDisplay(c).value).join(' / ') : '—');
  CNS.safeSetText('boloSub', drug.bolo && drug.bolo.length ? drug.bolo.map(c => scalarDisplay(c).sub).join(' / ') : 'Sin descriptor fijo');
  CNS.safeSetText('mantName', drug.mantLabel ? drug.mantLabel : (drug.mant && drug.mant.length ? drug.mant.map(c=>scalarDisplay(c).name).join(' / ') : '—'));
  CNS.safeSetText('mantValue', drug.mant && drug.mant.length ? drug.mant.map(c=>scalarDisplay(c).value).join(' / ') : '—');
  CNS.safeSetText('mantSub', drug.mant && drug.mant.length ? drug.mant.map(c=>scalarDisplay(c).sub).join(' / ') : 'No aplica / no estandarizado');
  CNS.safeSetText('drugMeaning', drug.meaning); CNS.safeSetText('drugPearl', drug.pearl); renderTablaCompleta(); }
function renderTablaCompleta(){ const tbody=document.getElementById('tablaCompleta'); let html=''; Object.keys(drugDB).forEach(catKey=>{ const cat=drugDB[catKey]; html += `<tr class="group-row"><td colspan="4">${cat.nombre}</td></tr>`; Object.values(cat.items).forEach(drug=>{ html += `<tr><td><b>${drug.nombre}</b></td><td>${tagsAndValues(drug.bolo)}</td><td>${tagsAndValues(drug.mant)}</td><td>${drug.pearl}</td></tr>`;});}); tbody.innerHTML=html; }
function recalcularTodo(){ updateSummary(); renderFarmaco(); }
document.getElementById('peso').addEventListener('input', recalcularTodo); document.getElementById('talla').addEventListener('input', recalcularTodo);
document.addEventListener('DOMContentLoaded', function(){ updateSummary(); renderDrugGrid(); renderFarmaco(); });
</script>

      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
