<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para revisar, en el paciente obeso adulto, qué descriptor corporal conviene usar para bolo/inducción y para mantención/infusión según el fármaco. El objetivo es orientar una decisión rápida y segura al lado del pabellón, no reemplazar juicio clínico, monitorización ni protocolos locales.";
$formula = "Este apunte no recalcula dosis absolutas en mg o mcg. Muestra el descriptor sugerido y su valor estimado para el paciente. Para el detalle matemático de los escalares, usa el enlace a Escalares de Peso En propofol, el concepto central es que la mantención no debe escalarse linealmente a TBW en obesidad mórbida; una aproximación clínica simple es ABW con FC 0,4.";
$referencias = array(
  "1.- Tabla-resumen actualizada de dosificación en paciente adulto obeso aportada por el usuario.",
  "2.- Cortínez LI. Anestesia intravenosa total en el paciente obeso. Rev Chil Anest. 2024;53(4):369-376.",
  "3.- Janmahasatian S et al. Quantification of lean bodyweight. Clin Pharmacokinet. 2005;44(10):1051-1065.",
  "4.- Shibutani K et al. Accuracy of pharmacokinetic models for predicting plasma fentanyl concentrations in lean and obese surgical patients: derivation of dosing weight ('pharmacokinetic mass'). Anesthesiology. 2004;101:603-613.",
  "5.- Eleveld DJ et al. An allometric model of remifentanil pharmacokinetics and pharmacodynamics. Anesthesiology. 2017;126:1005-1018.",
  "6.- Cortínez LI et al. Dexmedetomidine pharmacokinetics in the obese. Eur J Clin Pharmacol. 2015;71:1501-1508.",
  "7.- Morse JD et al. A universal pharmacokinetic model for dexmedetomidine in children and adults. J Clin Med. 2020;9:3480.",
  "8.- Li JY et al. Pharmacokinetics of a cisatracurium dose according to fat-free mass for anesthesia induction in morbidly obese patients. Nan Fang Yi Ke Da Xue Xue Bao. 2016;36(10):1396-1400."
);

$icono_apunte = "<i class='fa-solid fa-syringe pe-3 pt-2'></i>";
$titulo_apunte = "Dosificación de Fármacos en el Paciente Obeso Adulto";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm' style='width:80px; height:40px;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white' onclick='toggleInfo()'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
<div class="container-fluid px-0 px-md-2">
<div class="ob-shell">

<style>
:root{
  --ob-yellow:#fff7cc;
  --ob-yellow-bd:#e6d36a;

  --ob-blue:#e8f1ff;
  --ob-blue-bd:#9fc2ff;

  --ob-red:#fdebec;
  --ob-red-bd:#ef9a9a;

  --ob-orange:#fff0e1;
  --ob-orange-bd:#f7b267;

  --ob-green:#eaf8ef;
  --ob-green-bd:#9bd3ae;

  --ob-purple:#f1edff;
  --ob-purple-bd:#c9b8ff;

  --ob-gray:#f5f7fb;
  --ob-gray-bd:#cfd8e3;

  --ob-dark:#1f2937;
  --ob-muted:#667085;
  --ob-border:#dbe2ea;
}

.ob-shell{max-width:1080px;margin:0 auto;}

.topbar{
  background:linear-gradient(135deg,#27458f,#3559b7);
  color:#fff;
  border-radius:1.25rem;
  padding:1.2rem;
  margin-bottom:1rem;
}

.info-box,
.section-card{
  background:#fff;
  border-radius:1rem;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  margin-bottom:1rem;
}

.info-box-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:1rem;
  padding:1rem;
}

.info-box-content{
  display:none;
  padding:1rem;
  border-top:1px solid #e5e7eb;
}

.section-card{padding:1rem;}

.section-title{
  font-size:.8rem;
  text-transform:uppercase;
  color:var(--ob-muted);
  letter-spacing:.04em;
  margin-bottom:.8rem;
}

.choice-grid-2,
.choice-grid-3{
  display:grid;
  gap:.65rem;
}

.choice-grid-2{grid-template-columns:repeat(2,1fr);}
.choice-grid-3{grid-template-columns:repeat(3,1fr);}

.choice-check,
.cat-check,
.drug-check{display:none;}

.choice-label,
.cat-label,
.drug-label{
  display:flex;
  justify-content:center;
  align-items:center;
  text-align:center;
  cursor:pointer;
  border:1px solid var(--ob-border);
  border-radius:.95rem;
  background:#fff;
  transition:.18s ease;
  font-weight:800;
}

.choice-label{
  display:flex;
  flex-direction:column;
  align-items:flex-start;
  justify-content:center;
  min-height:92px;
  padding:.9rem 1rem;
  border-radius:1rem;
  border:1px solid #dfe7f2;
  background:#fff;
  font-weight:700;
  cursor:pointer;
  line-height:1.15;
}

.choice-label i{
  font-size:1.1rem;
  margin-bottom:.35rem;
  color:#3f5bd1;
}

.choice-label small{
  display:block;
  margin-top:.2rem;
  font-size:.8rem;
  font-weight:500;
  color:#667085;
}

.choice-check:checked + .choice-label{
  outline:2px solid #27458f;
  background:#eef3ff;
  box-shadow:0 8px 18px rgba(0,0,0,.08);
  transform:translateY(-1px);
}

.cat-check:checked + .cat-label,
.drug-check:checked + .drug-label{
  outline:3px solid #27458f;
  box-shadow:0 10px 20px rgba(0,0,0,.10);
  transform:translateY(-1px);
}

.summary-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:.75rem;
}

.summary-item{
  background:#fff;
  border:1px solid #e5e7eb;
  border-radius:1rem;
  padding:.9rem;
}

.summary-k{
  font-size:.74rem;
  text-transform:uppercase;
  letter-spacing:.05em;
  color:var(--ob-muted);
  margin-bottom:.2rem;
}

.summary-v{
  font-size:1rem;
  font-weight:800;
  color:var(--ob-dark);
}

.scalar-strip{
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:.65rem;
}

.scalar-pill{
  border-radius:1rem;
  border:1px solid #e5e7eb;
  padding:.8rem;
  background:#fff;
}

.scalar-pill .k{
  font-size:.72rem;
  text-transform:uppercase;
  color:var(--ob-muted);
  margin-bottom:.15rem;
}

.scalar-pill .v{
  font-weight:800;
  color:var(--ob-dark);
  font-size:1rem;
}

.main-grid{
  display:grid;
  grid-template-columns:1.1fr .9fr;
  gap:1rem;
  align-items:start;
}

.main-card{
  border-radius:1rem;
  border:1px solid #dbe2ea;
  padding:1rem;
}

.main-yellow{background:var(--ob-yellow);border-color:var(--ob-yellow-bd);}
.main-blue{background:var(--ob-blue);border-color:var(--ob-blue-bd);}
.main-red{background:var(--ob-red);border-color:var(--ob-red-bd);}
.main-orange{background:var(--ob-orange);border-color:var(--ob-orange-bd);}
.main-green{background:var(--ob-green);border-color:var(--ob-green-bd);}
.main-purple{background:var(--ob-purple);border-color:var(--ob-purple-bd);}
.main-gray{background:var(--ob-gray);border-color:var(--ob-gray-bd);}
.main-striped{
  background:
    repeating-linear-gradient(
      -45deg,
      #f5f7fb 0px,
      #f5f7fb 12px,
      #e4e7eb 12px,
      #e4e7eb 24px
    );
  border-color:#bcc4cf;
}

.big-drug{
  font-size:1.8rem;
  font-weight:900;
  line-height:1.05;
  margin-bottom:.35rem;
  color:#102a43;
}

.big-cat{
  font-size:.85rem;
  text-transform:uppercase;
  letter-spacing:.05em;
  color:#52627a;
  margin-bottom:.8rem;
}

.row-scale{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:.8rem;
  margin-bottom:.8rem;
}

.scale-box{
  background:rgba(255,255,255,.78);
  border:1px solid rgba(16,42,67,.08);
  border-radius:1rem;
  padding:.95rem;
}

.scale-title{
  font-size:.76rem;
  text-transform:uppercase;
  letter-spacing:.05em;
  color:var(--ob-muted);
  margin-bottom:.2rem;
}

.scale-name{
  font-size:1.12rem;
  font-weight:900;
  color:#0f172a;
}

.scale-value{
  font-size:1rem;
  font-weight:700;
  color:#1d4ed8;
}

.scale-sub{
  font-size:.84rem;
  color:#52627a;
  line-height:1.35;
  margin-top:.25rem;
}

.quick-link-card,
.note-card,
.warn-card{
  background:#fff;
  border:1px solid #e5e7eb;
  border-radius:1rem;
  padding:1rem;
  margin-bottom:.8rem;
}

.quick-link-card a{
  font-weight:800;
  text-decoration:none;
}

.cat-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:.65rem;
}

.cat-label{
  min-height:68px;
  padding:.55rem;
  flex-direction:column;
  line-height:1.1;
}

.cat-label i{
  font-size:1.1rem;
  margin-bottom:.3rem;
}

.drug-grid{
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:.65rem;
}

.drug-label{
  min-height:66px;
  padding:.5rem;
  line-height:1.1;
  flex-direction:column;
  font-size:.95rem;
}

.drug-label small{
  display:block;
  margin-top:.2rem;
  font-size:.72rem;
  font-weight:600;
  color:var(--ob-muted);
}

.table-wrap{
  overflow:auto;
  border-radius:1rem;
  border:1px solid #e5e7eb;
  background:#fff;
}

.ob-table{
  width:100%;
  border-collapse:collapse;
  min-width:900px;
}

.ob-table th,
.ob-table td{
  padding:.85rem .8rem;
  border-bottom:1px solid #e5e7eb;
  vertical-align:top;
}

.ob-table thead th{
  background:#f8fafc;
  color:#0f172a;
  font-weight:800;
  font-size:.88rem;
}

.group-row td{
  background:#eef4ff;
  font-weight:900;
  color:#27458f;
}

.tag{
  display:inline-block;
  padding:.18rem .45rem;
  border-radius:999px;
  font-size:.74rem;
  font-weight:800;
}

.tag-yellow{background:var(--ob-yellow);color:#8a6a00;}
.tag-blue{background:var(--ob-blue);color:#1d4ed8;}
.tag-red{background:var(--ob-red);color:#b91c1c;}
.tag-orange{background:var(--ob-orange);color:#c2410c;}
.tag-green{background:var(--ob-green);color:#15803d;}
.tag-purple{background:var(--ob-purple);color:#7c3aed;}
.tag-gray{background:var(--ob-gray);color:#374151;}
.tag-striped{
  background:
    repeating-linear-gradient(
      -45deg,
      #f5f7fb 0px,
      #f5f7fb 8px,
      #e4e7eb 8px,
      #e4e7eb 16px
    );
  color:#374151;
  border:1px solid #cfd8e3;
}

.teaching-wrap{
  border-radius:1.2rem;
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
  font-weight:900;
  line-height:1.15;
  margin-bottom:1rem;
}

.teaching-card{
  background:#fff;
  border-radius:1rem;
  padding:1rem;
  border:1px solid #e5e7eb;
  margin-bottom:.8rem;
}

.final-warning{
  border:1px solid #f5c2c7;
  background:#fff5f5;
  border-radius:1rem;
  padding:1rem;
}

.final-warning .title{
  font-weight:900;
  color:#b42318;
  margin-bottom:.35rem;
}

.mini-note{
  font-size:.84rem;
  color:#667085;
  line-height:1.4;
}

@media (max-width:980px){
  .main-grid{grid-template-columns:1fr;}
  .summary-grid{grid-template-columns:repeat(2,1fr);}
  .scalar-strip{grid-template-columns:repeat(3,1fr);}
  .cat-grid{grid-template-columns:repeat(2,1fr);}
  .drug-grid{grid-template-columns:repeat(3,1fr);}
}

@media (max-width:700px){
  .summary-grid{grid-template-columns:repeat(2,1fr);}
  .scalar-strip{grid-template-columns:repeat(2,1fr);}
  .drug-grid{grid-template-columns:repeat(2,1fr);}
  .row-scale{grid-template-columns:1fr;}
}

@media (max-width:480px){
  .summary-grid{grid-template-columns:1fr;}
  .scalar-strip{grid-template-columns:1fr;}
  .cat-grid{grid-template-columns:1fr 1fr;}
  .drug-grid{grid-template-columns:1fr 1fr;}
  .big-drug{font-size:1.45rem;}
}

.cat-hypnotics{
  background:var(--ob-yellow);
  border-color:var(--ob-yellow-bd);
}
.cat-opioids{
  background:var(--ob-blue);
  border-color:var(--ob-blue-bd);
}
.cat-nmb{
  background:var(--ob-red);
  border-color:var(--ob-red-bd);
}
.cat-reversal{
  background:
    repeating-linear-gradient(
      -45deg,
      #f5f7fb 0px,
      #f5f7fb 12px,
      #e4e7eb 12px,
      #e4e7eb 24px
    );
  border-color:#bcc4cf;
}

.drug-hypnotics{
  background:var(--ob-yellow);
  border-color:var(--ob-yellow-bd);
}
.drug-opioids{
  background:var(--ob-blue);
  border-color:var(--ob-blue-bd);
}
.drug-nmb{
  background:var(--ob-red);
  border-color:var(--ob-red-bd);
}
.drug-reversal{
  background:
    repeating-linear-gradient(
      -45deg,
      #f5f7fb 0px,
      #f5f7fb 12px,
      #e4e7eb 12px,
      #e4e7eb 24px
    );
  border-color:#bcc4cf;
}
</style>

<div class="topbar">
  <div class="small opacity-75">APP clínica • farmacología perioperatoria • obesidad</div>
  <h1 class="h3 mb-2">Dosificación de Fármacos en el Paciente Obeso Adulto</h1>
  <div class="opacity-75">Resumen interactivo por categorías con el descriptor sugerido para bolo y para infusión/mantención.</div>
</div>

<div class="info-box">
  <div class="info-box-header">
    <div>Información</div>
    <button onclick="toggleInfo()" class="btn btn-sm btn-secondary">Mostrar / ocultar</button>
  </div>
  <div id="infoContent" class="info-box-content">
    <?php echo $descripcion_info; ?>

    <?php if(!empty($formula)){ ?>
      <hr>
      <b>Comentario:</b><br>
      <?php echo $formula; ?>
    <?php } ?>

    <hr>
    <b>Referencias:</b>
    <ul class="mb-0">
      <?php foreach($referencias as $ref){ echo "<li>$ref</li>"; } ?>
    </ul>
  </div>
</div>

<div class="section-card">
  <div class="section-title">Datos del paciente</div>

  <div class="row g-3">
    <div class="col-12 col-md-4">
      <label class="form-label fw-bold">Sexo</label>
      <div class="choice-grid-2">
        <div>
          <input class="choice-check" type="radio" name="sexo" id="sexo_m" checked>
          <label class="choice-label" for="sexo_m" onclick="setSexo('m')">
            <i class="fa-solid fa-person"></i>
            Hombre
          </label>
        </div>
        <div>
          <input class="choice-check" type="radio" name="sexo" id="sexo_f">
          <label class="choice-label" for="sexo_f" onclick="setSexo('f')">
            <i class="fa-solid fa-person-dress"></i>
            Mujer
          </label>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <label class="form-label fw-bold">Peso total</label>
      <div class="input-group">
        <input type="number" class="form-control" id="peso" step="0.1" value="" oninput="recalcularTodo()">
        <span class="input-group-text">kg</span>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <label class="form-label fw-bold">Talla</label>
      <div class="input-group">
        <input type="number" class="form-control" id="talla" step="0.1" value="" oninput="recalcularTodo()">
        <span class="input-group-text">cm</span>
      </div>
    </div>
  </div>
</div>

<div class="section-card">
  <div class="section-title">Tarjeta de resumen</div>
  <div class="summary-grid">
    <div class="summary-item">
      <div class="summary-k">Sexo</div>
      <div id="sumSexo" class="summary-v">Hombre</div>
    </div>
    <div class="summary-item">
      <div class="summary-k">Peso total</div>
      <div id="sumPeso" class="summary-v">—</div>
    </div>
    <div class="summary-item">
      <div class="summary-k">Talla</div>
      <div id="sumTalla" class="summary-v">—</div>
    </div>
    <div class="summary-item">
      <div class="summary-k">IMC</div>
      <div id="sumIMC" class="summary-v">—</div>
      <div id="sumIMCcat" class="mini-note mt-1">—</div>
    </div>
  </div>
</div>

<div class="section-card">
  <div class="section-title">Valores de escalares disponibles</div>
  <div class="scalar-strip">
    <div class="scalar-pill">
      <div class="k">TBW</div>
      <div id="vTBW" class="v">—</div>
    </div>
    <div class="scalar-pill">
      <div class="k">IBW / PCI</div>
      <div id="vIBW" class="v">—</div>
    </div>
    <div class="scalar-pill">
      <div class="k">FFM / LBW</div>
      <div id="vFFM" class="v">—</div>
    </div>
    <div class="scalar-pill">
      <div class="k">ABW</div>
      <div id="vABW" class="v">—</div>
    </div>
    <div class="scalar-pill">
      <div class="k">PK Mass</div>
      <div id="vPK" class="v">—</div>
    </div>
  </div>
</div>

<div class="section-card">
  <div class="section-title">Categoría farmacológica</div>
  <div class="cat-grid">

    <div>
      <input class="cat-check" type="radio" name="categoria" id="cat_hip" checked>
      <label class="cat-label cat-hypnotics" for="cat_hip" onclick="setCategoria('hipnoticos')">
        <i class="fa-solid fa-moon"></i>
        Hipnóticos / sedantes
      </label>
    </div>

    <div>
      <input class="cat-check" type="radio" name="categoria" id="cat_op">
      <label class="cat-label cat-opioids" for="cat_op" onclick="setCategoria('opioides')">
        <i class="fa-solid fa-droplet"></i>
        Opioides
      </label>
    </div>

    <div>
      <input class="cat-check" type="radio" name="categoria" id="cat_nm">
      <label class="cat-label cat-nmb" for="cat_nm" onclick="setCategoria('relajantes')">
        <i class="fa-solid fa-bolt"></i>
        Bloqueantes Neuromusculares
      </label>
    </div>

    <div>
      <input class="cat-check" type="radio" name="categoria" id="cat_rev">
      <label class="cat-label cat-reversal" for="cat_rev" onclick="setCategoria('reversores')">
        <i class="fa-solid fa-rotate-left"></i>
        Reversores
      </label>
    </div>

  </div>
</div>

<div class="section-card">
  <div class="section-title">Fármaco</div>
  <div id="drugGrid" class="drug-grid"></div>
</div>

<div class="section-card">
  <div class="section-title">Resultado principal</div>

  <div class="main-grid">
    <div id="mainCard" class="main-card main-yellow">
      <div id="drugName" class="big-drug">Propofol</div>
      <div id="drugCat" class="big-cat">Hipnóticos y sedantes</div>

      <div class="row-scale">
        <div class="scale-box">
          <div class="scale-title">Bolo / inducción</div>
          <div id="boloName" class="scale-name">IBW o FFM</div>
          <div id="boloValue" class="scale-value">—</div>
          <div id="boloSub" class="scale-sub">Usar descriptor conservador para evitar sobredosificación inicial.</div>
        </div>

        <div class="scale-box">
          <div class="scale-title">Mantención / infusión</div>
          <div id="mantName" class="scale-name">TBW alométrico o ABW (FC 0.4)</div>
          <div id="mantValue" class="scale-value">—</div>
          <div id="mantSub" class="scale-sub">ABW 0,4 actúa como aproximación clínica simple del escalado no lineal.</div>
        </div>
      </div>

      <div class="note-card">
        <b>Interpretación clínica</b><br>
        <span id="drugMeaning">El bolo e infusión de propofol no siguen la misma lógica. En mantención, el aclaramiento no aumenta linealmente con el peso real en obesidad mórbida.</span>
      </div>

      <div class="warn-card">
        <b>Perla docente</b><br>
        <span id="drugPearl">Cuando no dispones de un modelo TCI apropiado para obesidad, ABW con FC 0,4 es una aproximación práctica razonable para mantención de propofol.</span>
      </div>
    </div>

    <div>
      <div class="quick-link-card">
        <b>Escalares usados en este apunte</b><br>
        <div class="mini-note mt-2 mb-2">
          Aquí solo se muestra el nombre del descriptor y su valor. El detalle matemático está en el apunte de escalares.
        </div>
        <a href="escalares.php"><i class="fa-solid fa-up-right-from-square pe-2"></i>Ir a Escalares de Peso</a>
      </div>

      <div class="note-card">
        <b>Criterio práctico</b><br>
        En el obeso adulto no debes preguntar “¿todo por qué peso?”. La pregunta útil es “¿qué descriptor explica mejor el volumen de distribución inicial o el aclaramiento de este fármaco?”.
      </div>

      <div class="warn-card">
        <b>Seguridad</b><br>
        Este apunte orienta descriptor y lógica de ajuste. La dosis final debe titularse a contexto clínico, profundidad anestésica, EEG procesado si está disponible, hemodinamia, función orgánica y respuesta real del paciente.
      </div>
    </div>
  </div>
</div>

<div class="section-card">
  <div class="section-title">Tabla completa resumida</div>
  <div class="table-wrap">
    <table class="ob-table">
      <thead>
        <tr>
          <th>Fármaco</th>
          <th>Bolo / inducción</th>
          <th>Mantención / infusión</th>
          <th>Comentario docente</th>
        </tr>
      </thead>
      <tbody id="tablaCompleta"></tbody>
    </table>
  </div>
</div>

<div class="section-card">
  <div class="teaching-wrap">
    <div class="teaching-title">Puntos clave</div>
    <div class="teaching-main">En el paciente obeso, el descriptor para la carga rara vez es el mismo que para la mantención</div>

    <div class="teaching-card">
      <b>Propofol</b><br>
      En la revisión chilena, el aclaramiento de propofol en obesos se predice mejor con escalado alométrico del peso y no con relación lineal pura; clínicamente, ABW con FC 0,4 es una alternativa simple para mantención.
    </div>

    <div class="teaching-card">
      <b>Remifentanilo</b><br>
      La obesidad no justifica usar TBW. El descriptor más razonable es FFM/LBW, tanto para inicio como para mantención.
    </div>

    <div class="teaching-card">
      <b>Dexmedetomidina</b><br>
      A mayor peso, no debes mantener la misma tasa en mcg/kg/h basada en TBW. La mantención debe reducirse usando FFM o un ABW con FC 0,3–0,4.
    </div>

    <div class="teaching-card">
      <b>Fórmulas de James</b><br>
      En IMC > 40 las ecuaciones antiguas de masa magra pueden comportarse mal. Por eso este apunte usa una FFM válida en obesidad mórbida.
    </div>

    <div class="teaching-card">
      <b>Cisatracurio</b><br>
      La nueva evidencia apoya que FFM funciona adecuadamente. Si tu medio aún usa TBW, al menos entiende que no es la única opción defendible.
    </div>

    <div class="final-warning">
      <div class="title">Mensaje final</div>
      El descriptor correcto reduce error, pero no reemplaza titulación clínica. En obesidad con OSA/OHS, hipovolemia, fragilidad hemodinámica, edad avanzada o disfunción orgánica, la dosis efectiva puede ser menor que la sugerida por el descriptor.
    </div>
  </div>
</div>

</div>
</div>
</div>

<script>
let sexoActual = 'm';
let categoriaActual = 'hipnoticos';
let farmacoActual = 'propofol';

const drugDB = {
  hipnoticos: {
    nombre: 'Hipnóticos y sedantes',
    color: 'main-yellow',
    items: {
      propofol: {
        nombre:'Propofol',
        bolo:['IBW','FFM'],
        mant:['ABW40'],
        mantLabel:'TBW alométrico o ABW (FC 0.4)',
        meaning:'Para inducción conviene usar un descriptor conservador como IBW o FFM. Para mantención, la evidencia moderna favorece escalado no lineal del peso; en clínica, ABW con FC 0,4 es una aproximación simple y útil.',
        pearl:'El error clásico es mantener propofol estrictamente proporcional a TBW en obesidad mórbida. Eso favorece sobredosis en infusión.'
      },
      dexmedetomidina: {
        nombre:'Dexmedetomidina',
        bolo:['IBW','ABW40'],
        mant:['FFM','ABW30','ABW40'],
        mantLabel:'FFM o ABW (FC 0.3–0.4)',
        meaning:'La masa grasa tiene poco efecto sobre los clearances de dexmedetomidina. La mantención debe ajustarse con FFM o con ABW usando un FC bajo.',
        pearl:'Si subes la infusión linealmente con TBW, las concentraciones serán más altas de lo previsto en el obeso.'
      },
      tiopental: {
        nombre:'Tiopental',
        bolo:['FFM','TBW'],
        mant:[],
        mantLabel:'—',
        meaning:'El material docente lo sitúa en un rango entre FFM y TBW para el bolo. No hay una única regla universal; conviene interpretarlo como intervalo clínico, no como permiso para ir siempre a TBW.',
        pearl:'Mientras más incierta sea la reserva hemodinámica, más sentido tiene iniciar en el extremo conservador del rango.'
      },
      etomidato: {
        nombre:'Etomidato',
        bolo:['FFM'],
        mant:[],
        mantLabel:'—',
        meaning:'Se aproxima a FFM para inducción, evitando sobredosificación por exceso de tejido adiposo.',
        pearl:'Etomidato resuelve menos el problema circulatorio, pero igual requiere un descriptor prudente.'
      },
      midazolam: {
        nombre:'Midazolam',
        bolo:['TBW'],
        mant:[],
        mantLabel:'—',
        meaning:'En la tabla resumida se mantiene con TBW para dosis inicial. Aun así, en obesidad y apnea del sueño debe titularse con cautela por acumulación y depresión respiratoria.',
        pearl:'Que la tabla diga TBW no significa que el bolo deba ser liberal.'
      }
    }
  },

  opioides: {
    nombre: 'Opiáceos',
    color: 'main-blue',
    items: {
      fentanilo: {
        nombre:'Fentanilo',
        bolo:['TBW'],
        mant:['FFM','PK'],
        mantLabel:'FFM o PK Mass',
        meaning:'El bolo puede orientarse a TBW, pero la lógica de mantención se correlaciona mejor con FFM o PK Mass. Es un ejemplo clásico de que carga y aclaramiento no usan necesariamente el mismo descriptor.',
        pearl:'PK Mass no es lo mismo que FFM. Es un descriptor farmacocinético con fórmula propia.'
      },
      remifentanilo: {
        nombre:'Remifentanilo',
        bolo:['IBW','FFM'],
        mant:['FFM'],
        mantLabel:'FFM (masa libre de grasa)',
        meaning:'La obesidad no altera de forma relevante su metabolismo por esterasas plasmáticas; por eso FFM/LBW funciona mejor que TBW.',
        pearl:'Remifentanilo por TBW en obesidad es una forma rápida de sobredosificar.'
      },
      sufentanilo: {
        nombre:'Sufentanilo',
        bolo:['TBW'],
        mant:['IBW'],
        mantLabel:'IBW / PCI',
        meaning:'En la tabla resumida, el bolo se aproxima a TBW y la mantención a IBW. Eso sugiere separar claramente carga y fase sostenida.',
        pearl:'No asumas que por ser lipofílico todo el esquema debe ir por TBW.'
      },
      morfina: {
        nombre:'Morfina',
        bolo:['FFM'],
        mant:['TITULAR'],
        mantLabel:'Titular según efecto',
        meaning:'Se prefiere FFM para la carga. La continuación no se resume en un descriptor fijo y debe titularse según analgesia, ventilación y contexto clínico.',
        pearl:'En obesidad, especialmente con OSA/OHS, la frase “titular según efecto” es una medida de seguridad, no una vaguedad.'
      }
    }
  },

  relajantes: {
    nombre: 'Bloqueadores neuromusculares',
    color: 'main-red',
    items: {
      succinilcolina: {
        nombre:'Succinilcolina',
        bolo:['TBW'],
        mant:[],
        mantLabel:'—',
        meaning:'Se mantiene como la excepción importante: en obesidad la dosis de succinilcolina sí se aproxima a TBW.',
        pearl:'No extrapoles esta regla a los no despolarizantes.'
      },
      rocuronio: {
        nombre:'Rocuronio',
        bolo:['IBW'],
        mant:[],
        mantLabel:'—',
        meaning:'Como relajante hidrófilo, no debería escalarse libremente por TBW en el obeso.',
        pearl:'TBW aumenta el riesgo de bloqueo más prolongado del esperado.'
      },
      vecuronio: {
        nombre:'Vecuronio',
        bolo:['IBW'],
        mant:[],
        mantLabel:'—',
        meaning:'En la tabla actual se resume con IBW / PCI.',
        pearl:'Es preferible un descriptor conservador más TOF que exceso de carga.'
      },
      atracurio: {
        nombre:'Atracurio',
        bolo:['TBW'],
        mant:[],
        mantLabel:'—',
        meaning:'La tabla lo resume con TBW. Sigue siendo razonable contrastarlo con respuesta neuromuscular real.',
        pearl:'Cuando una droga aparece en TBW, monitorizar sigue siendo obligatorio.'
      },
      cisatracurio: {
        nombre:'Cisatracurio',
        bolo:['FFM','TBW'],
        mant:[],
        mantLabel:'—',
        meaning:'La tabla actual acepta FFM o TBW, pero la evidencia moderna apoya bien FFM como descriptor funcional en obesidad.',
        pearl:'Si tienes FFM disponible, es una opción más coherente con la fisiología que un TBW automático.'
      }
    }
  },

  reversores: {
    nombre: 'Reversores',
    color: 'main-gray',
    items: {
      sugammadex: {
        nombre:'Sugammadex',
        bolo:['TBW','ABW40'],
        mant:[],
        mantLabel:'—',
        meaning:'En reversión profunda, usar TBW o ABW con FC 0,4 es defendible para evitar infradosificación.',
        pearl:'Quedarse corto en la reversión suele ser más peligroso que un pequeño exceso de fármaco.'
      },
      neostigmina: {
        nombre:'Neostigmina',
        bolo:['TBWMAX5'],
        mant:[],
        mantLabel:'—',
        meaning:'Se resume como TBW con tope máximo de 5 mg.',
        pearl:'Aquí el máximo es tan importante como el descriptor.'
      }
    }
  }
};

function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "block") ? "none" : "block";
}

function setSexo(s){
  sexoActual = s;
  recalcularTodo();
}

function setCategoria(cat){
  categoriaActual = cat;
  const keys = Object.keys(drugDB[cat].items);
  if(!keys.includes(farmacoActual)){
    farmacoActual = keys[0];
  }
  renderDrugGrid();
  renderFarmaco();
}

function setFarmaco(key){
  farmacoActual = key;
  renderFarmaco();
}

function n(v, d=1){
  if(isNaN(v)) return '—';
  return Number(v).toFixed(d);
}

function getPeso(){ return parseFloat(document.getElementById('peso').value) || 0; }
function getTallaCm(){ return parseFloat(document.getElementById('talla').value) || 0; }
function getTallaM(){ return getTallaCm()/100; }

function calcBMI(){
  const p = getPeso();
  const t = getTallaM();
  if(!p || !t) return 0;
  return p/(t*t);
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
  }else{
    return 45.5 + 2.3 * (tallaIn - 60);
  }
}

function calcFFM(){
  const peso = getPeso();
  const tallaM = getTallaM();
  if(!peso || !tallaM) return 0;

  // Janmahasatian / FFM validada en obesidad mórbida
  const talla2 = tallaM * tallaM;

  if(sexoActual === 'm'){
    const WHSmax = 42.92;
    const WHS50 = 30.93;
    return (WHSmax * talla2 * peso) / ((WHS50 * talla2) + peso);
  }else{
    const WHSmax = 37.99;
    const WHS50 = 35.98;
    return (WHSmax * talla2 * peso) / ((WHS50 * talla2) + peso);
  }
}

function calcABW(fc=0.4){
  const tbw = getPeso();
  const ibw = calcIBW();
  if(!tbw || !ibw) return 0;
  return ibw + fc * (tbw - ibw);
}

function calcPK(){
  const tbw = getPeso();
  if(!tbw) return 0;
  return 52 / (1 + ((196.4 * Math.exp(-0.025 * tbw) - 53.66) / 100));
}

function scalarDisplay(code){
  const tbw = getPeso();
  const ibw = calcIBW();
  const ffm = calcFFM();
  const abw40 = calcABW(0.4);
  const abw30 = calcABW(0.3);
  const pk = calcPK();

  if(code === 'TBW') return {name:'TBW', value: tbw ? n(tbw,1)+' kg' : '—', sub:'Peso total'};
  if(code === 'IBW') return {name:'IBW / PCI', value: ibw ? n(ibw,1)+' kg' : '—', sub:'Peso ideal'};
  if(code === 'FFM') return {name:'FFM / LBW', value: ffm ? n(ffm,1)+' kg' : '—', sub:'Masa libre de grasa'};
  if(code === 'ABW40') return {name:'ABW (FC 0.4)', value: abw40 ? n(abw40,1)+' kg' : '—', sub:'Peso ajustado'};
  if(code === 'ABW30') return {name:'ABW (FC 0.3)', value: abw30 ? n(abw30,1)+' kg' : '—', sub:'Peso ajustado'};
  if(code === 'PK') return {name:'PK Mass', value: pk ? n(pk,1)+' kg' : '—', sub:'Masa farmacocinética'};
  if(code === 'TITULAR') return {name:'Titular según efecto', value:'No fijo', sub:'Sin descriptor único'};
  if(code === 'TBWMAX5') return {name:'TBW (máx. 5 mg)', value: tbw ? n(tbw,1)+' kg' : '—', sub:'Recordar máximo absoluto'};
  return {name:'—', value:'—', sub:'—'};
}

function tagHTML(code){
  if(code === 'TBW') return '<span class="tag tag-blue">TBW</span>';
  if(code === 'IBW') return '<span class="tag tag-yellow">IBW</span>';
  if(code === 'FFM') return '<span class="tag tag-green">FFM/LBW</span>';
  if(code === 'ABW40') return '<span class="tag tag-orange">ABW 0.4</span>';
  if(code === 'ABW30') return '<span class="tag tag-orange">ABW 0.3</span>';
  if(code === 'PK') return '<span class="tag tag-purple">PK Mass</span>';
  if(code === 'TITULAR') return '<span class="tag tag-red">Titular</span>';
  if(code === 'TBWMAX5') return '<span class="tag tag-blue">TBW máx 5 mg</span>';
  return '<span class="tag tag-gray">—</span>';
}

function tagsAndValues(codes){
  if(!codes || !codes.length) return '<span class="tag tag-gray">—</span>';
  return codes.map(c=>{
    const s = scalarDisplay(c);
    return `<div style="margin-bottom:.25rem;">${tagHTML(c)} <span class="fw-bold">${s.value}</span></div>`;
  }).join('');
}

function resolveDrugButtonClass(catKey){
  if(catKey === 'hipnoticos') return 'drug-hypnotics';
  if(catKey === 'opioides') return 'drug-opioids';
  if(catKey === 'relajantes') return 'drug-nmb';
  if(catKey === 'reversores') return 'drug-reversal';
  return '';
}

function resolveCardColor(catColor){
  return catColor;
}

function updateSummary(){
  const peso = getPeso();
  const talla = getTallaCm();
  const bmi = calcBMI();

  document.getElementById('sumSexo').textContent = (sexoActual === 'm') ? 'Hombre' : 'Mujer';
  document.getElementById('sumPeso').textContent = peso ? n(peso,1) + ' kg' : '—';
  document.getElementById('sumTalla').textContent = talla ? n(talla,0) + ' cm' : '—';
  document.getElementById('sumIMC').textContent = (peso && talla) ? n(bmi,1) + ' kg/m²' : '—';

  const imcCat = document.getElementById('sumIMCcat');
  if(imcCat) imcCat.textContent = (peso && talla) ? bmiCategoria(bmi) : '—';

  document.getElementById('vTBW').textContent = peso ? n(peso,1) + ' kg' : '—';
  document.getElementById('vIBW').textContent = talla ? n(calcIBW(),1) + ' kg' : '—';
  document.getElementById('vFFM').textContent = (peso && talla) ? n(calcFFM(),1) + ' kg' : '—';
  document.getElementById('vABW').textContent = (peso && talla) ? n(calcABW(0.4),1) + ' kg' : '—';
  document.getElementById('vPK').textContent = peso ? n(calcPK(),1) + ' kg' : '—';
}

function renderDrugGrid(){
  const wrap = document.getElementById('drugGrid');
  const cat = drugDB[categoriaActual];
  const entries = Object.entries(cat.items);

  wrap.innerHTML = entries.map(([key, item])=>{
    const checked = key === farmacoActual ? 'checked' : '';
    const colorClass = resolveDrugButtonClass(categoriaActual);

    return `
      <div>
        <input class="drug-check" type="radio" name="drug" id="drug_${key}" ${checked}>
        <label class="drug-label ${colorClass}" for="drug_${key}" onclick="setFarmaco('${key}')">
          ${item.nombre}
          <small>${item.bolo.length ? item.bolo.join(' / ').replaceAll('FFM','FFM').replaceAll('ABW40','ABW0.4').replaceAll('ABW30','ABW0.3') : 'sin bolo fijo'}</small>
        </label>
      </div>
    `;
  }).join('');
}

function renderFarmaco(){
  const cat = drugDB[categoriaActual];
  const drug = cat.items[farmacoActual];
  const card = document.getElementById('mainCard');

  const peso = getPeso();
  const talla = getTallaCm();

  card.className = 'main-card ' + resolveCardColor(cat.color);

  if(!peso || !talla){
    document.getElementById('drugName').textContent = 'Seleccione e ingrese datos';
    document.getElementById('drugCat').textContent = cat.nombre;

    document.getElementById('boloName').textContent = '—';
    document.getElementById('boloValue').textContent = '—';
    document.getElementById('boloSub').textContent = 'Ingrese peso y talla para calcular los descriptores.';

    document.getElementById('mantName').textContent = '—';
    document.getElementById('mantValue').textContent = '—';
    document.getElementById('mantSub').textContent = 'Ingrese peso y talla para calcular los descriptores.';

    document.getElementById('drugMeaning').textContent = 'Para mostrar los valores reales de los descriptores, primero ingresa peso total y talla.';
    document.getElementById('drugPearl').textContent = 'Evita trabajar con valores por defecto.';
    renderTablaCompleta();
    return;
  }

  document.getElementById('drugName').textContent = drug.nombre;
  document.getElementById('drugCat').textContent = cat.nombre;

  const boloName = drug.bolo && drug.bolo.length ? drug.bolo.map(c => scalarDisplay(c).name).join(' / ') : '—';
  const mantName = drug.mantLabel ? drug.mantLabel : (drug.mant && drug.mant.length ? drug.mant.map(c => scalarDisplay(c).name).join(' / ') : '—');

  document.getElementById('boloName').textContent = boloName;
  document.getElementById('boloValue').textContent =
    drug.bolo && drug.bolo.length
      ? drug.bolo.map(c => scalarDisplay(c).value).join(' / ')
      : '—';
  document.getElementById('boloSub').textContent =
    drug.bolo && drug.bolo.length
      ? drug.bolo.map(c => scalarDisplay(c).sub).join(' / ')
      : 'Sin descriptor fijo';

  document.getElementById('mantName').textContent = mantName;
  document.getElementById('mantValue').textContent =
    drug.mant && drug.mant.length
      ? drug.mant.map(c => scalarDisplay(c).value).join(' / ')
      : '—';
  document.getElementById('mantSub').textContent =
    drug.mant && drug.mant.length
      ? drug.mant.map(c => scalarDisplay(c).sub).join(' / ')
      : 'No aplica / no estandarizado';

  document.getElementById('drugMeaning').textContent = drug.meaning;
  document.getElementById('drugPearl').textContent = drug.pearl;

  renderTablaCompleta();
}

function renderTablaCompleta(){
  const tbody = document.getElementById('tablaCompleta');
  let html = '';

  Object.keys(drugDB).forEach(catKey => {
    const cat = drugDB[catKey];
    html += `<tr class="group-row"><td colspan="4">${cat.nombre}</td></tr>`;

    Object.entries(cat.items).forEach(([key, drug]) => {
      html += `
        <tr>
          <td><b>${drug.nombre}</b></td>
          <td>${tagsAndValues(drug.bolo)}</td>
          <td>${tagsAndValues(drug.mant)}</td>
          <td>${drug.pearl}</td>
        </tr>
      `;
    });
  });

  tbody.innerHTML = html;
}

function recalcularTodo(){
  updateSummary();
  renderFarmaco();
}

document.addEventListener('DOMContentLoaded', function(){
  updateSummary();
  renderDrugGrid();
  renderFarmaco();
});
</script>

<?php require("footer.php"); ?>