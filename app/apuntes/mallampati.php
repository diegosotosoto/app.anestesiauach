<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "El score de Mallampati es una herramienta clínica simple para estimar dificultad de vía aérea, basada en la visualización de estructuras orofaríngeas.";
$formula = "";
$referencias = array(
  "1.- Mallampati SR et al. A clinical sign to predict difficult tracheal intubation. Can Anaesth Soc J. 1985.",
  "2.- Samsoon GL, Young JR. Difficult tracheal intubation: a retrospective study. Anaesthesia. 1987.",
  "3.- Practice Guidelines for Management of the Difficult Airway. ASA 2022.",
  "4.- Lundstrom LH et al. Poor prognostic value of Mallampati. Anesthesiology. 2011."
);

$icono_apunte = "<i class='fa-solid fa-lungs pe-3 pt-2'></i>";
$titulo_apunte = "Score de Mallampati";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm' style='width:80px; height:40px;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>"; 
$boton_navbar = "<button class='navbar-toggler text-white' onclick='toggleInfo()'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");

?>
 
<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
<div class="container-fluid px-0 px-md-2">
<div class="mallampati-shell">

<style>
:root{
  --asa1:#e8f7f2;
  --asa2:#fff9e8;
  --asa3:#fff2e0;
  --asa4:#ffe5e5;
  --asa5:#ffd6d6;
  --asa6:#f5f5f5;
}

.mallampati-shell{max-width:980px;margin:0 auto;}

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
}

.img-box{
  border-radius:1rem;
  overflow:hidden;
  border:1px solid #e5e7eb;
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
  padding:1rem;
}

.info-box-content{
  display:none;
  padding:1rem;
  border-top:1px solid #e5e7eb;
}

.level-card{
  border:1px solid #e5e7eb;
  border-radius:1rem;
  padding:1rem;
  background:#f8fafc;
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
}

.teaching-main{
  text-align:center;
  font-size:1.8rem;
  font-weight:800;
  margin-bottom:1rem;
}

.teaching-card{
  background:#fff;
  border-radius:1rem;
  padding:1rem;
  border:1px solid #e5e7eb;
  margin-bottom:.8rem;
}
.level-card{
  border:1px solid #e5e7eb;
  border-radius:1rem;
  padding:1rem;
  background:#f8fafc;
}

.level-green{
  background:#e9f8ef;
  border-color:#b7e4c7;
}

.level-yellow{
  background:#fff8db;
  border-color:#f4d35e;
}

.level-orange{
  background:#fff0e1;
  border-color:#f7b267;
}

.level-red{
  background:#fdebec;
  border-color:#f2a7b1;
}
</style>

<!-- HEADER -->
<div class="topbar">
  <div class="small opacity-75">APP clínica • evaluación vía aérea</div>
  <h1 class="h3">Score de Mallampati</h1>
</div>

<!-- INFO -->
<div class="info-box">
  <div class="info-box-header">
    <div>Información</div>
    <button onclick="toggleInfo()" class="btn btn-sm btn-secondary">Mostrar / ocultar</button>
  </div>

  
  <div id="infoContent" class="info-box-content">
    <?php echo $descripcion_info; ?>

    <hr>
    <b>Referencias:</b>
    <ul>
      <?php foreach($referencias as $ref){ echo "<li>$ref</li>"; } ?>
    </ul>
  </div>
</div>

<!-- IMAGEN -->
<div class="section-card p-3">
  <div class="section-title mb-2">Visualización</div>
  <div class="img-box">
    <img src="../images/malampatti-scale.png" style="width:100%;">



  </div>
</div>

<!-- CLASIFICACIÓN -->
<div class="section-card p-3">
  <div class="section-title mb-3">Clasificación</div>

<div class="level-card level-green mb-2">
    <b>Mallampati I</b><br>
    Paladar blando, úvula completa y pilares visibles → Vía aérea fácil
  </div>

<div class="level-card level-yellow mb-2">
    <b>Mallampati II</b><br>
    Paladar blando + úvula parcial → Baja probabilidad de dificultad
  </div>

<div class="level-card level-orange mb-2">
    <b>Mallampati III</b><br>
    Solo base de úvula → Posible dificultad
  </div>

<div class="level-card level-red">
    <b>Mallampati IV</b><br>
    Solo paladar duro → Alta probabilidad de dificultad
  </div>

</div>

<!-- DOCENCIA -->
<div class="section-card p-3">
<div class="teaching-wrap">

<div class="teaching-title">Guía práctica</div>
<div class="teaching-main">
El Mallampati aislado, NO es buen predictor de vía aérea difícil
</div>

<div class="teaching-card">
<b>Cómo se realiza correctamente</b><br>
Paciente sentado, cabeza neutra, boca máxima abierta, sin fonación, lengua relajada.
</div>

<div class="teaching-card">
<b>¿Y si está acostado?</b><br>
Sobreestima la dificultad. La evidencia muestra menor precisión en supino.
</div>

<div class="teaching-card">
<b>Error frecuente</b><br>
Hacerlo con el paciente hablando → invalida completamente el resultado.
</div>

<div class="teaching-card">
<b>Qué estructuras debes identificar</b><br>
Paladar blando, úvula, pilares amigdalinos, base de lengua.
</div>

<div class="teaching-card">
  <b>Utilidad real del Mallampati</b><br>
  Sirve como parte del screening, pero <strong>no debe usarse solo</strong> para predecir intubación difícil.
</div>

<div class="teaching-card">
  <b>Rendimiento de Mallampati aislado</b><br>
  La sensibilidad de Mallampati solo es limitada. En la literatura clásica/reportes amplios suele ser claramente insuficiente como prueba única.
</div>

<div class="teaching-card">
  <b>Qué combinación conviene usar</b><br>
  La mejor estrategia práctica es combinar Mallampati con:
  <ul class="mt-2 mb-0 text-start">
    <li>Distancia tiromentoniana (DTM)</li>
    <li>Apertura bucal / interincisor gap</li>
    <li>Movilidad cervical</li>
    <li>Antecedentes de vía aérea difícil</li>
  </ul>
</div>


<div class="teaching-card">
  <b>Adulto mayor y edentado</b><br>
  No sobreinterpretes un Mallampati aparentemente “bueno”. La dificultad puede venir por apertura limitada, rigidez cervical, retrognatia, fragilidad tisular o mala reserva fisiológica.
</div>


<div class="card border-danger mb-2">
  <div class="card-header">Mensaje final para residentes</div>
  <div class="card-body text-danger">

    <p class="card-text">Mallampati alto aumenta tu alerta.</p>
    <h5 class="card-title">Mallampati bajo NO descarta vía aérea difícil.</h5>

  </div>


</div>

</div>
</div>

<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "block") ? "none" : "block";
}
</script>

<?php require("footer.php"); ?>