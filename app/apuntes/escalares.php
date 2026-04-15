<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para visualizar los principales escalares de dosificación en el paciente obeso adulto. Permite ingresar sexo, talla y peso total, seleccionar un escalar y mostrar su valor calculado, su relación con el peso total, su utilidad clínica y una fórmula docente simplificada.";
$formula = "Este apunte no reemplaza el juicio farmacológico. En obesidad, el peso total (TBW) rara vez debe usarse de forma automática para todos los fármacos. La elección del escalar depende del comportamiento farmacocinético, la hidrosolubilidad/liposolubilidad, el aclaramiento esperado y el objetivo clínico. En obesidad mórbida, la evidencia moderna favorece FFM válida sobre fórmulas antiguas de masa magra tipo James. Además, para algunos fármacos como propofol, el aclaramiento escala mejor con modelos alométricos que con relación lineal pura al peso real.";
$referencias = array(
  "1.- Tabla de escalares de dosificación en el paciente obeso adulto aportada por el usuario.",
  "2.- Cortínez LI. Anestesia intravenosa total en el paciente obeso. Rev Chil Anest. 2024;53(4):369-376.",
  "3.- Janmahasatian S et al. Quantification of lean bodyweight. Clin Pharmacokinet. 2005;44(10):1051-1065.",
  "4.- Shibutani K et al. Accuracy of pharmacokinetic models for predicting plasma fentanyl concentrations in lean and obese surgical patients: derivation of dosing weight ('pharmacokinetic mass'). Anesthesiology. 2004;101:603-613.",
  "5.- Revisión sobre manejo anestésico del paciente obeso adulto (BMC Anesthesiology, 2022).",
  "6.- Nota del usuario: farmacología en obesos, con énfasis en propofol, remifentanilo, fentanilo y dexmedetomidina."
);

$icono_apunte = "<i class='fa-solid fa-scale-balanced pe-3 pt-2'></i>";
$titulo_apunte = "Escalares de Dosificación en el Paciente Obeso Adulto";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm' style='width:80px; height:40px;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white' onclick='toggleInfo()'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
<div class="container-fluid px-0 px-md-2">
<div class="esc-shell">

<style>
:root{
  --esc-blue:#eaf2ff;
  --esc-cyan:#eaf7fb;
  --esc-green:#eaf8ef;
  --esc-yellow:#fff8db;
  --esc-orange:#fff0e1;
  --esc-red:#fdebec;
  --esc-purple:#f1edff;
  --esc-gray:#f5f7fb;
}

.esc-shell{max-width:1020px;margin:0 auto;}

.topbar{
  background:linear-gradient(135deg,#27458f,#3559b7);
  color:#fff;
  border-radius:1.25rem;
  padding:1.2rem;
  margin-bottom:1rem;
}

.section-card{
  border-radius:1rem;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  background:#fff;
  margin-bottom:1rem;
}

.section-title{
  font-size:.8rem;
  text-transform:uppercase;
  color:#667085;
  letter-spacing:.04em;
}

.info-box{
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

.choice-grid-2{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:.65rem;
}

.choice-check{display:none;}

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
  box-shadow:0 8px 18px rgba(0,0,0,.08);
  transform:translateY(-1px);
  background:#eef3ff;
}

.scalar-btns{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:.65rem;
}

.scalar-check{display:none;}

.scalar-label{
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  min-height:74px;
  border-radius:.95rem;
  border:1px solid #dbe2ea;
  font-weight:800;
  cursor:pointer;
  transition:.18s ease;
  background:#fff;
  text-align:center;
  padding:.55rem .5rem;
  line-height:1.1;
}

.scalar-label small{
  font-size:.72rem;
  font-weight:600;
  color:#667085;
  margin-top:.18rem;
}

.scalar-check:checked + .scalar-label{
  outline:2px solid #27458f;
  box-shadow:0 8px 18px rgba(0,0,0,.08);
  transform:translateY(-1px);
}

.s-tbw{background:var(--esc-blue);}
.s-bmi{background:var(--esc-yellow);}
.s-ibw{background:var(--esc-cyan);}
.s-ffm{background:var(--esc-green);}
.s-abw{background:var(--esc-orange);}
.s-pk{background:var(--esc-purple);}
.s-bsa{background:var(--esc-gray);}

.result-card{
  border:1px solid #e5e7eb;
  border-radius:1rem;
  padding:1rem;
  background:#f8fafc;
}

.result-blue{background:var(--esc-blue);border-color:#bfd3ff;}
.result-yellow{background:var(--esc-yellow);border-color:#edd57a;}
.result-cyan{background:var(--esc-cyan);border-color:#b7ddeb;}
.result-green{background:var(--esc-green);border-color:#b7e4c7;}
.result-orange{background:var(--esc-orange);border-color:#f7b267;}
.result-purple{background:var(--esc-purple);border-color:#d2c3ff;}
.result-gray{background:var(--esc-gray);border-color:#d9e0ea;}
.result-red{background:var(--esc-red);border-color:#ef9a9a;}

.esc-grid{
  display:block;
}

.meta{
  display:grid;
  gap:.8rem;
}

.meta-card{
  background:#fff;
  border:1px solid #e5e7eb;
  border-radius:1rem;
  padding:.9rem 1rem;
}

.meta-label{
  font-size:.78rem;
  text-transform:uppercase;
  letter-spacing:.05em;
  color:#667085;
  margin-bottom:.25rem;
}

.meta-value{
  font-size:1rem;
  line-height:1.35;
  color:#1f2937;
  font-weight:700;
}

.meta-soft{
  font-size:.92rem;
  color:#667085;
  line-height:1.45;
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
  color:#667085;
  margin-bottom:.2rem;
}

.summary-v{
  font-size:1rem;
  font-weight:800;
  color:#1f2937;
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

.tip-final{
  border:1px solid #f1c6c6;
  background:#fff5f5;
  border-radius:1rem;
  padding:1rem;
}

.tip-final-title{
  font-weight:800;
  color:#b42318;
  margin-bottom:.4rem;
}

.mini-note{
  font-size:.84rem;
  color:#667085;
  line-height:1.4;
}

@media (max-width:900px){
  .scalar-btns{grid-template-columns:repeat(3,1fr);}
  .summary-grid{grid-template-columns:repeat(2,1fr);}
}

@media (max-width:768px){
  .scalar-btns{grid-template-columns:repeat(2,1fr);}
  .choice-grid-2{grid-template-columns:1fr 1fr;}
  .teaching-main{font-size:1.3rem;}
}

@media (max-width:480px){
  .summary-grid{grid-template-columns:1fr;}
}
</style>

<div class="topbar">
  <div class="small opacity-75">APP clínica • obesidad • farmacología perioperatoria</div>
  <h1 class="h3">Escalares de Dosificación en el Paciente Obeso Adulto</h1>
  <div class="opacity-75">Visualización rápida de TBW, BMI, IBW, FFM, ABW, PK Mass y BSA/SCT para apoyo anestésico.</div>
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
    <div class="result-card result-red mb-3">
      <b>Advertencia importante</b><br>
      En obesidad mórbida, las fórmulas antiguas de masa magra tipo James pueden mostrar comportamiento anómalo y dejar de ser fiables. En este apunte se prioriza FFM válida sobre “LBW clásica”.
    </div>

    <b>Referencias:</b>
    <ul class="mb-0">
      <?php foreach($referencias as $ref){ echo "<li>$ref</li>"; } ?>
    </ul>
  </div>
</div>

<div class="section-card p-3">
  <div class="section-title mb-3">Datos de entrada</div>

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

<div class="section-card p-3">
  <div class="section-title mb-3">Escalar seleccionado</div>

  <div class="scalar-btns mb-3">
    <div>
      <input class="scalar-check" type="radio" name="scalar" id="tbw" checked>
      <label class="scalar-label s-tbw" for="tbw" onclick="setEscalar('tbw')">TBW<small>Peso total</small></label>
    </div>

    <div>
      <input class="scalar-check" type="radio" name="scalar" id="bmi">
      <label class="scalar-label s-bmi" for="bmi" onclick="setEscalar('bmi')">BMI<small>IMC</small></label>
    </div>

    <div>
      <input class="scalar-check" type="radio" name="scalar" id="ibw">
      <label class="scalar-label s-ibw" for="ibw" onclick="setEscalar('ibw')">IBW / PCI<small>Peso ideal</small></label>
    </div>

    <div>
      <input class="scalar-check" type="radio" name="scalar" id="ffm">
      <label class="scalar-label s-ffm" for="ffm" onclick="setEscalar('ffm')">FFM<small>Masa libre de grasa</small></label>
    </div>

    <div>
      <input class="scalar-check" type="radio" name="scalar" id="abw">
      <label class="scalar-label s-abw" for="abw" onclick="setEscalar('abw')">ABW<small>Peso ajustado</small></label>
    </div>

    <div>
      <input class="scalar-check" type="radio" name="scalar" id="pk">
      <label class="scalar-label s-pk" for="pk" onclick="setEscalar('pk')">PK Mass<small>Masa farmacocinética</small></label>
    </div>

    <div>
      <input class="scalar-check" type="radio" name="scalar" id="bsa">
      <label class="scalar-label s-bsa" for="bsa" onclick="setEscalar('bsa')">BSA / SCT<small>Superficie corporal</small></label>
    </div>
  </div>

  <div id="mainCard" class="result-card result-blue">
    <div class="esc-grid">
      <div class="meta">
        <div class="meta-card">
          <div class="meta-label">Valor calculado</div>
          <div id="valorEscalar" class="meta-value">—</div>
        </div>

        <div class="meta-card">
          <div class="meta-label">Qué representa</div>
          <div id="meaningEscalar" class="meta-value">—</div>
          <div id="softEscalar" class="meta-soft mt-1">Ingresa peso y talla para calcular los escalares.</div>
        </div>

        <div class="meta-card">
          <div class="meta-label">Fórmula</div>
          <div id="formulaEscalar" class="meta-soft">—</div>
        </div>

        <div class="meta-card">
          <div class="meta-label">Utilidad anestésica</div>
          <div id="pearlEscalar" class="meta-soft">—</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section-card p-3">
  <div class="section-title mb-3">Tarjeta de resumen</div>

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
      <div class="summary-k">IMC / categoría</div>
      <div id="sumIMC" class="summary-v">—</div>
      <div id="sumIMCcat" class="mini-note mt-1">—</div>
    </div>
  </div>
</div>

<div class="section-card p-3">
  <div class="section-title mb-3">Resumen rápido de todos los escalares</div>

  <div class="result-card result-blue mb-2">
    <b>TBW (Total Body Weight)</b><br>
    Peso real medido del paciente. Útil para describir al paciente, pero no como descriptor universal de dosificación.
  </div>

  <div class="result-card result-yellow mb-2">
    <b>BMI (Body Mass Index)</b><br>
    Clasifica el grado de obesidad, pero no es un escalar directo de dosificación farmacológica.
  </div>

  <div class="result-card result-cyan mb-2">
    <b>IBW / PCI (Ideal Body Weight)</b><br>
    Peso basado en talla y sexo; sirve como referencia estructural y como base para otros escalares.
  </div>

  <div class="result-card result-green mb-2">
    <b>FFM (Fat-Free Mass / Masa Libre de Grasa)</b><br>
    Descriptor moderno preferido en obesidad mórbida para varios modelos farmacocinéticos. Más robusto que la masa magra clásica tipo James.
  </div>

  <div class="result-card result-orange mb-2">
    <b>ABW (Adjusted Body Weight)</b><br>
    Peso intermedio: IBW + 40% del exceso de peso. Sigue siendo una aproximación clínica simple muy útil.
  </div>

  <div class="result-card result-purple mb-2">
    <b>PK Mass</b><br>
    Descriptor farmacocinético con fórmula propia. No equivale a FFM.
  </div>

  <div class="result-card result-gray mb-2">
    <b>BSA / SCT</b><br>
    Superficie corporal total; útil para algunos modelos fisiológicos, gasto cardíaco y VFG.
  </div>

  <div class="result-card result-red">
    <b>Alometría</b><br>
    No es “otro peso”, sino una forma no lineal de escalar funciones como aclaramiento. Explica por qué en obesidad TBW lineal puede sobreestimar mantención.
  </div>
</div>

<div class="section-card p-3">
  <div class="teaching-wrap">

    <div class="teaching-title">Guía práctica</div>
    <div class="teaching-main">
      En el obeso adulto, el error más frecuente es dosificar “todo por peso total”
    </div>

    <div class="teaching-card">
      <b>TBW no es el default universal</b><br>
      El peso total sirve para medir al paciente, pero no necesariamente representa el compartimento farmacológicamente relevante.
    </div>

    <div class="teaching-card">
      <b>IMC clasifica, no dosifica</b><br>
      El BMI ayuda a describir el grado de obesidad y el riesgo global, pero no debería ser el escalar principal para calcular dosis.
    </div>

    <div class="teaching-card">
      <b>FFM importa más que la vieja “masa magra”</b><br>
      En obesidad mórbida, la evidencia moderna favorece FFM válida porque las ecuaciones antiguas de James pueden comportarse mal. Para varios fármacos, FFM es una referencia más segura y fisiológicamente coherente.
    </div>

    <div class="teaching-card">
      <b>ABW sigue siendo útil</b><br>
      Cuando el fármaco se distribuye parcialmente en grasa o cuando necesitas una aproximación clínica simple, ABW sigue siendo una solución práctica y razonable.
    </div>

    <div class="teaching-card">
      <b>PK Mass no debe entenderse como “nuevo peso total”</b><br>
      Su utilidad está en estimar aclaramiento de ciertos fármacos, especialmente cuando el comportamiento farmacocinético no sigue bien ni a TBW ni a FFM.
    </div>

    <div class="teaching-card">
      <b>Alometría explica por qué algunos mantenimientos cambian</b><br>
      En fármacos como propofol, el aclaramiento no aumenta linealmente con el peso real. Por eso TBW puro puede sobredosificar mantención y es mejor pensar en escalado no lineal o en aproximaciones como ABW.
    </div>

    <div class="teaching-card">
      <b>SCT/BSA tiene rol fisiológico</b><br>
      Es más útil para algunos contextos hemodinámicos y de superficie corporal que para dosificación rutinaria de la mayoría de los anestésicos.
    </div>

    <div class="tip-final">
      <div class="tip-final-title">Mensaje final para residentes</div>
      <div>
        Antes de calcular una dosis en el obeso, pregúntate qué importa más para ese fármaco: volumen de distribución inicial, FFM, aclaramiento, tejido adiposo o superficie corporal. Elegir mal el escalar puede ser más peligroso que equivocarse en unos pocos miligramos.
      </div>
    </div>

  </div>
</div>

</div>
</div>
</div>

<script>
let sexoActual = 'm';
let escalarActual = 'tbw';

function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "block") ? "none" : "block";
}

function setSexo(s){
  sexoActual = s;
  recalcularTodo();
}

function setEscalar(e){
  escalarActual = e;
  renderEscalar();
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

  document.getElementById('sumSexo').textContent = (sexoActual === 'm') ? 'Hombre' : 'Mujer';
  document.getElementById('sumPeso').textContent = peso ? n(peso,1) + ' kg' : '—';
  document.getElementById('sumTalla').textContent = talla ? n(talla,0) + ' cm' : '—';
  document.getElementById('sumIMC').textContent = (peso && talla) ? n(bmi,1) + ' kg/m²' : '—';

  const imcCat = document.getElementById('sumIMCcat');
  if(imcCat) imcCat.textContent = (peso && talla) ? bmiCategoria(bmi) : '—';
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

  const card = document.getElementById('mainCard');
  const valor = document.getElementById('valorEscalar');
  const meaning = document.getElementById('meaningEscalar');
  const soft = document.getElementById('softEscalar');
  const formula = document.getElementById('formulaEscalar');
  const pearl = document.getElementById('pearlEscalar');

  if(!peso || !talla){
    card.className = 'result-card result-blue';
    valor.textContent = '—';
    meaning.textContent = 'Ingrese peso y talla';
    soft.textContent = 'El escalar seleccionado se mostrará cuando ingreses los datos del paciente.';
    formula.textContent = '—';
    pearl.textContent = 'Evita usar valores por defecto: pueden inducir error clínico.';
    return;
  }

  if(escalarActual === 'tbw'){
    card.className = 'result-card result-blue';
    valor.textContent = n(tbw,1) + ' kg';
    meaning.textContent = 'Peso real medido del paciente';
    soft.textContent = 'Es el valor bruto en balanza y no distingue masa grasa, masa libre de grasa ni compartimentos farmacológicos.';
    formula.textContent = 'TBW = peso medido en balanza (kg).';
    pearl.textContent = 'Útil para describir al paciente, pero en obesidad no debe asumirse como base universal de dosificación.';
  }

  if(escalarActual === 'bmi'){
    card.className = 'result-card result-yellow';
    valor.textContent = n(bmi,1) + ' kg/m²';
    meaning.textContent = bmiCategoria(bmi);
    soft.textContent = 'Clasifica el grado de obesidad. Es una herramienta de estratificación, no un escalar directo de farmacodosis.';
    formula.textContent = 'BMI = Peso(kg) / Talla(m)².';
    pearl.textContent = 'Sirve para clasificar obesidad y riesgo global, pero no para decidir por sí solo cuánto propofol, opioide o relajante usar.';
  }

  if(escalarActual === 'ibw'){
    card.className = 'result-card result-cyan';
    valor.textContent = n(ibw,1) + ' kg';
    meaning.textContent = 'Peso ideal / peso corporal ideal';
    soft.textContent = 'Representa un peso basado en talla y sexo. En obesidad es mucho menor al TBW.';
    formula.textContent = (sexoActual === 'm')
      ? 'IBW (Devine, hombre) = 50 + 2.3 × (pulgadas sobre 60).'
      : 'IBW (Devine, mujer) = 45.5 + 2.3 × (pulgadas sobre 60).';
    pearl.textContent = 'Muy útil como referencia estructural y como base para otros escalares, pero puede subestimar requerimientos si se usa solo.';
  }

  if(escalarActual === 'ffm'){
    card.className = 'result-card result-green';
    valor.textContent = n(ffm,1) + ' kg';
    meaning.textContent = 'Fat-Free Mass / masa libre de grasa';
    soft.textContent = 'Descriptor moderno preferido en obesidad mórbida. Representa el compartimento no graso metabólicamente activo.';
    formula.textContent = (sexoActual === 'm')
      ? 'FFM (Janmahasatian, hombre) = [42.92 × talla² × peso] / [(30.93 × talla²) + peso].'
      : 'FFM (Janmahasatian, mujer) = [37.99 × talla² × peso] / [(35.98 × talla²) + peso].';
    pearl.textContent = 'En obesidad mórbida, FFM es más confiable que la masa magra clásica tipo James para varios modelos farmacocinéticos.';
  }

  if(escalarActual === 'abw'){
    card.className = 'result-card result-orange';
    valor.textContent = n(abw,1) + ' kg';
    meaning.textContent = 'Peso ajustado';
    soft.textContent = 'Escalar intermedio entre IBW y TBW. Corrige parcialmente el exceso de peso.';
    formula.textContent = 'ABW = IBW + 0.4 × (TBW − IBW).';
    pearl.textContent = 'Útil cuando el fármaco se distribuye parcialmente en grasa. También sirve como aproximación clínica simple cuando no dispones de un modelo alométrico.';
  }

  if(escalarActual === 'pk'){
    card.className = 'result-card result-purple';
    valor.textContent = n(pk,1) + ' kg';
    meaning.textContent = 'Masa farmacocinética';
    soft.textContent = 'Escalar relacionado con el aclaramiento de ciertos fármacos, especialmente útil como referencia docente para fentanyl en obesidad.';
    formula.textContent = 'PK Mass = 52 / [1 + ((196.4 × e^(-0.025 × TBW) - 53.66) / 100)]';
    pearl.textContent = 'No equivale a FFM. Aunque ambos se relacionan, PK Mass usa una fórmula propia y puede comportarse distinto del peso magro.';
  }

  if(escalarActual === 'bsa'){
    card.className = 'result-card result-gray';
    valor.textContent = n(bsa,2) + ' m²';
    meaning.textContent = 'Superficie corporal total';
    soft.textContent = 'Escalar fisiológico basado en peso y talla. Se usa en algunos contextos de gasto cardíaco, VFG y fisiología global.';
    formula.textContent = 'Mosteller: BSA = √[(Peso × Talla cm) / 3600].';
    pearl.textContent = 'No suele ser el escalar de primera línea para la mayoría de las dosis anestésicas, pero sí puede aportar contexto fisiológico.';
  }
}

function recalcularTodo(){
  updateSummary();
  renderEscalar();
}

document.addEventListener('DOMContentLoaded', function(){
  recalcularTodo();
});
</script>

<?php require("footer.php"); ?>