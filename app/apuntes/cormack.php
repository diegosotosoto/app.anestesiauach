<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "La clasificación de Cormack-Lehane describe la visión laringoscópica obtenida durante la laringoscopía directa. Es útil para documentar la dificultad real de exposición glótica y para anticipar estrategias futuras de manejo de vía aérea.";
$formula = "A diferencia de Mallampati, Cormack-Lehane es una clasificación intraoperatoria: se determina durante la laringoscopía y no en la evaluación preoperatoria.";
$referencias = array(
  "1.- Cormack RS, Lehane J. Difficult tracheal intubation in obstetrics. Anaesthesia. 1984.",
  "2.- Yentis SM, Lee DJ. Evaluation of an improved scoring system for the grading of direct laryngoscopy. Anaesthesia. 1998.",
  "3.- Practice Guidelines for Management of the Difficult Airway. ASA 2022.",
  "4.- Frerk C et al. Difficult Airway Society 2015 guidelines for management of unanticipated difficult intubation in adults.",
  "OpenAirway. (2014, 10 de noviembre). Cormack-Lehane Grading Examples. https://openairway.org/cormack-lehane-grading-examples/. En estilo Vancouver, se estructura como: OpenAirway. Cormack-Lehane Grading Examples [Internet]. Ciudad del Cabo: OpenAirway; 2014 [citado el 8 de abr de 2026]. Disponible en: https://openairway.org/cormack-lehane-grading-examples/."
);

$icono_apunte = "<i class='fa-solid fa-video pe-3 pt-2'></i>";
$titulo_apunte = "Clasificación de Cormack-Lehane";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm' style='width:80px; height:40px;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white' onclick='toggleInfo()'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
<div class="container-fluid px-0 px-md-2">
<div class="cl-shell">

<style>
:root{
  --cl1:#e8f7f2;
  --cl2:#fff9e8;
  --cl3:#fff0e1;
  --cl4:#fdebec;
}

.cl-shell{max-width:980px;margin:0 auto;}

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

.img-box{
  border-radius:1rem;
  overflow:hidden;
  border:1px solid #e5e7eb;
  background:#fff;
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

.grade-btns{
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:.65rem;
}

.grade-check{display:none;}

.grade-label{
  display:flex;
  justify-content:center;
  align-items:center;
  min-height:52px;
  border-radius:.9rem;
  border:1px solid #dbe2ea;
  font-weight:800;
  cursor:pointer;
  transition:.18s ease;
  background:#fff;
}

.grade-check:checked + .grade-label{
  transform:translateY(-1px);
  box-shadow:0 8px 18px rgba(0,0,0,.08);
}

.grade-1{background:var(--cl1);}
.grade-2a{background:var(--cl2);}
.grade-2b{background:#fff4d8;}
.grade-3{background:var(--cl3);}
.grade-4{background:var(--cl4);}

.grade-card{
  border:1px solid #e5e7eb;
  border-radius:1rem;
  padding:1rem;
  background:#f8fafc;
}

.grade-green{
  background:#e9f8ef;
  border-color:#b7e4c7;
}

.grade-yellow{
  background:#fff8db;
  border-color:#f4d35e;
}

.grade-yellow2{
  background:#fff2c7;
  border-color:#e9c46a;
}

.grade-orange{
  background:#fff0e1;
  border-color:#f7b267;
}

.grade-red{
  background:#fdebec;
  border-color:#f2a7b1;
}

.cl-result-grid{
  display:grid;
  grid-template-columns:1.05fr .95fr;
  gap:1rem;
  align-items:start;
}

.cl-image-stage img{
  width:100%;
  display:block;
  border-radius:1rem;
}

.cl-meta{
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
  font-size:1.65rem;
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

@media (max-width:768px){
  .grade-btns{grid-template-columns:repeat(2,1fr);}
  .cl-result-grid{grid-template-columns:1fr;}
  .teaching-main{font-size:1.35rem;}
}

.grade-label{
  transition:.15s ease;
}

.grade-label.active{
  outline:2px solid #27458f;
  box-shadow:0 6px 14px rgba(0,0,0,.12);
  transform:translateY(-1px);
}

.grade-label.grade-1.active{ background:#d1f3e4; }
.grade-label.grade-2a.active{ background:#fff3bf; }
.grade-label.grade-2b.active{ background:#ffe8a3; }
.grade-label.grade-3.active{ background:#ffd8a8; }
.grade-label.grade-4.active{ background:#ffc9c9; }

</style>

<!-- HEADER -->
<div class="topbar">
  <div class="small opacity-75">APP clínica • laringoscopía directa</div>
  <h1 class="h3">Clasificación de Cormack-Lehane</h1>
  <div class="opacity-75">Descripción intraoperatoria de la visión glótica durante laringoscopía.</div>
</div>

<!-- INFO -->
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

<!-- CLASIFICACION INTERACTIVA -->
<div class="section-card p-3">
  <div class="section-title mb-3">Clasificación</div>

  <div class="grade-btns mb-3">
    <div>
      <input class="grade-check" type="radio" name="clgrade" id="cl1" checked>
      <label class="grade-label grade-1" for="cl1" onclick="setCL('1')">Grado I</label>
    </div>

    <div>
      <input class="grade-check" type="radio" name="clgrade" id="cl2a">
      <label class="grade-label grade-2a" for="cl2a" onclick="setCL('2a')">Grado IIa</label>
    </div>

    <div>
      <input class="grade-check" type="radio" name="clgrade" id="cl2b">
      <label class="grade-label grade-2b" for="cl2b" onclick="setCL('2b')">Grado IIb</label>
    </div>

    <div>
      <input class="grade-check" type="radio" name="clgrade" id="cl3">
      <label class="grade-label grade-3" for="cl3" onclick="setCL('3')">Grado III</label>
    </div>

    <div>
      <input class="grade-check" type="radio" name="clgrade" id="cl4">
      <label class="grade-label grade-4" for="cl4" onclick="setCL('4')">Grado IV</label>
    </div>
  </div>

  <div id="clCard" class="grade-card grade-green">
    <div class="cl-result-grid">

      <div class="img-box cl-image-stage">
        <img id="clImage" src="1.jpg" alt="Cormack Lehane">
      </div>

      <div class="cl-meta">
        <div class="meta-card">
          <div class="meta-label">Visión</div>
          <div id="clVision" class="meta-value">Glotis completa visible</div>
        </div>

        <div class="meta-card">
          <div class="meta-label">Interpretación</div>
          <div id="clMeaning" class="meta-value">Laringoscopía favorable</div>
          <div id="clSoft" class="meta-soft mt-1">Corresponde a una exposición glótica amplia, habitualmente compatible con intubación directa sencilla.</div>
        </div>

        <div class="meta-card">
          <div class="meta-label">Perla inmediata</div>
          <div id="clPearl" class="meta-soft">Documenta el grado real obtenido, ya que esta información es más útil que una predicción preoperatoria aislada.</div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- RESUMEN RÁPIDO -->
<div class="section-card p-3">
  <div class="section-title mb-3">Resumen rápido</div>

  <div class="grade-card grade-green mb-2">
    <b>Grado I</b><br>
    Se visualiza la glotis completa.
  </div>

  <div class="grade-card grade-yellow mb-2">
    <b>Grado IIa</b><br>
    Se visualiza una parte de la glotis, generalmente su porción posterior.
  </div>

  <div class="grade-card grade-yellow2 mb-2">
    <b>Grado IIb</b><br>
    Se visualizan solo los aritenoides o una mínima porción posterior de la glotis.
  </div>

  <div class="grade-card grade-orange mb-2">
    <b>Grado III</b><br>
    No se ve la glotis; solo se observa la epiglotis.
  </div>

  <div class="grade-card grade-red">
    <b>Grado IV</b><br>
    No se observa ni glotis ni epiglotis.
  </div>
</div>

<!-- DOCENCIA -->
<div class="section-card p-3">
  <div class="teaching-wrap">

    <div class="teaching-title">Guía práctica</div>
    <div class="teaching-main">
      Cormack-Lehane describe lo que ves al laringoscopio, no lo que predices antes
    </div>

    <div class="teaching-card">
      <b>Qué clasifica realmente</b><br>
      Es una clasificación <strong>intraoperatoria</strong> de la visión laríngea durante laringoscopía directa. No reemplaza la evaluación preoperatoria.
    </div>

    <div class="teaching-card">
      <b>Error frecuente</b><br>
      Confundir Mallampati con Cormack-Lehane. Mallampati es preoperatorio; Cormack-Lehane es la visión obtenida durante la laringoscopía.
    </div>

    <div class="teaching-card">
      <b>Grado III no significa fracaso automático</b><br>
      Si ves la epiglotis, aún puedes mejorar la exposición con maniobras externas, reposicionamiento, cambio de hoja o uso de bougie.
    </div>

    <div class="teaching-card">
      <b>Grado IV cambia rápido el umbral de rescate</b><br>
      Si no ves ni glotis ni epiglotis, debes pensar precozmente en estrategia alternativa y no insistir con intentos repetidos traumáticos.
    </div>

    <div class="teaching-card">
      <b>Documenta siempre el mejor grado y el contexto</b><br>
      Anota si fue con laringoscopía directa o videolaringoscopio, si usaste BURP, bougie, hoja especial o maniobras externas.
    </div>

    <div class="teaching-card">
      <b>La clasificación puede cambiar</b><br>
      Un mismo paciente puede tener distinta visión según posición, relajación, operador, dispositivo y calidad de maniobras de optimización.
    </div>

    <div class="tip-final">
      <div class="tip-final-title">Mensaje final para residentes</div>
      <div>
        Un Cormack-Lehane alto aumenta la dificultad real de exposición glótica, pero lo importante no es “forzar la intubación”:
        es reconocer temprano cuándo debes optimizar, usar un introductor o cambiar de estrategia.
      </div>
    </div>

  </div>
</div>

</div>
</div>
</div>

<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "block") ? "none" : "block";
}

function setCL(grade){
  const card = document.getElementById("clCard");
  const img = document.getElementById("clImage");
  const vision = document.getElementById("clVision");
  const meaning = document.getElementById("clMeaning");
  const soft = document.getElementById("clSoft");
  const pearl = document.getElementById("clPearl");

  // limpiar selección visual previa
  document.querySelectorAll('.grade-label').forEach(el => {
    el.classList.remove('active');
  });

  if(grade === '1'){
    card.className = 'grade-card grade-green';
    img.src = '1.jpg';
    vision.textContent = 'Glotis completa visible';
    meaning.textContent = 'Laringoscopía favorable';
    soft.textContent = 'Exposición glótica amplia, habitualmente compatible con intubación directa sencilla.';
    pearl.textContent = 'Documenta el grado real obtenido, ya que esta información es más útil que una predicción preoperatoria aislada.';
    document.querySelector('label[for="cl1"]').classList.add('active');
  }

  if(grade === '2a'){
    card.className = 'grade-card grade-yellow';
    img.src = '2a.jpg';
    vision.textContent = 'Porción posterior de la glotis visible';
    meaning.textContent = 'Exposición algo limitada';
    soft.textContent = 'Suele permitir intubación, aunque puede requerir mejor posicionamiento o maniobras externas.';
    pearl.textContent = 'Optimiza eje, posición y presión laríngea externa antes de escalar innecesariamente.';
    document.querySelector('label[for="cl2a"]').classList.add('active');
  }

  if(grade === '2b'){
    card.className = 'grade-card grade-yellow2';
    img.src = '2b.jpg';
    vision.textContent = 'Solo aritenoides o mínima visión posterior';
    meaning.textContent = 'Mayor dificultad técnica';
    soft.textContent = 'La exposición glótica es pobre y aumenta la probabilidad de requerir bougie u otra ayuda.';
    pearl.textContent = 'Si la visión es mínima, un introductor puede ser más útil que seguir intentando con el tubo directamente.';
    document.querySelector('label[for="cl2b"]').classList.add('active');
  }

  if(grade === '3'){
    card.className = 'grade-card grade-orange';
    img.src = '3.jpg';
    vision.textContent = 'Solo epiglotis visible';
    meaning.textContent = 'Exposición glótica difícil';
    soft.textContent = 'No se visualiza la glotis. Requiere optimización seria de técnica o cambio de estrategia.';
    pearl.textContent = 'Antes de repetir, prueba BURP, reposicionamiento, hoja diferente, bougie o videolaringoscopio según contexto.';
    document.querySelector('label[for="cl3"]').classList.add('active');
  }

  if(grade === '4'){
    card.className = 'grade-card grade-red';
    img.src = '4.jpg';
    vision.textContent = 'No se ve glotis ni epiglotis';
    meaning.textContent = 'Exposición extremadamente difícil';
    soft.textContent = 'Corresponde a una laringoscopía crítica. Insistir sin estrategia aumenta trauma, edema e hipoxemia.';
    pearl.textContent = 'Debes bajar rápido el umbral para plan alternativo y evitar múltiples intentos fallidos.';
    document.querySelector('label[for="cl4"]').classList.add('active');
  }
}

document.addEventListener('DOMContentLoaded', function(){
  setCL('1');
});
</script>

<?php require("footer.php"); ?>