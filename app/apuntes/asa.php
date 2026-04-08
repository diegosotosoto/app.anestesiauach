<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "La clasificación ASA permite estimar el estado físico preoperatorio del paciente. Es una herramienta simple pero poderosa para estratificar riesgo anestésico, facilitar comunicación clínica y orientar planificación perioperatoria.";
$formula = "ASA I–VI según estado sistémico del paciente. Sufijo 'E' para cirugía de urgencia.";
$referencias = array(
  "1.- American Society of Anesthesiologists. ASA Physical Status Classification System.",
  "2.- Sankar A, et al. Comparison of the ASA Physical Status Classification System and other risk classification systems. Br J Anaesth. 2014.",
  "3.- Hackett NJ, et al. ASA class is a reliable independent predictor of medical complications. Anesthesiology. 2015.","4.- Yevenes, S., Epulef, V., Rocco, C., Geisse, F., & Vial, M. (2022). Clasificación American Society of Anesthesiologists Physical Status: Revisión de ejemplos locales - Chile. Revista Chilena de Anestesia, 51(3), 251-260."
);

$icono_apunte = "<i class='fa-solid fa-notes-medical pe-3 pt-2'></i>";
$titulo_apunte = "Clasificación ASA";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm' style='width:80px;height:40px;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px;height:40px;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
<div class="container-fluid px-0 px-md-2">
<div class="asa-shell">

<style>
:root{
  --asa1:#e8f7f2;
  --asa2:#fff9e8;
  --asa3:#fff2e0;
  --asa4:#ffe5e5;
  --asa5:#ffd6d6;
  --asa6:#f5f5f5;
}
.asa-shell{max-width:980px;margin:0 auto;}

.asa-card{
  border-radius:1rem;
  padding:1rem;
  border:1px solid #e5e7eb;
}

.asa-title{
  font-weight:800;
  font-size:1.1rem;
}

.asa-sub{
  font-weight:600;
  color:#1f2a37;
}

.asa-ex{
  font-size:.9rem;
  color:#667085;
}

.asa-badge{
  font-weight:800;
  font-size:1rem;
  padding:.4rem .7rem;
  border-radius:.6rem;
}

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
.asa3-badge{
  background:#6b5e3c; /* marrón oscuro cálido */
  color:#fff;
}
.asa5-badge{
  background:#8b3a3a; /* rojo oscuro desaturado */
  color:#fff;
}
.asa-sub{
  font-size:.85rem;
  color:#6b7280;
  line-height:1.4;
  margin-top:6px;
}

.asa-mini{
  font-weight:700;
  color:#374151;
  display:block;
}
</style>

<!-- TOPBAR -->
<div class="topbar">  
  <div class="small opacity-75">APP clínica • evaluación preoperatoria</div>
  <h1 class="h3 mb-1">Clasificación ASA</h1>
  <div class="subtle text-white-50">Estado físico preoperatorio</div>
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
    <b>Concepto:</b><br>
    <?php echo $formula; ?>

    <hr>
    <b>Referencias:</b>
    <ul class="small-note">
      <?php foreach($referencias as $ref){ ?>
        <li><?php echo $ref; ?></li>
      <?php } ?>
    </ul>
  </div>
</div>

<!-- ASA CARDS -->
<div class="section-card">
<div class="p-3">

<div class="section-title mb-3">Clasificación</div>

<div class="d-grid gap-3">

<!-- ASA I -->
<div class="asa-card" style="background:var(--asa1);">
  <div class="d-flex justify-content-between">
    <span class="asa-badge bg-success text-white">ASA I</span>
    <span class="asa-title">Paciente sano</span>
  </div>
  <div class="asa-ex mt-2">
    Sin comorbilidades.

    <div class="asa-sub">
      <span class="asa-mini">Adulto:</span> sano, no fumador, sin consumo relevante de alcohol
      <span class="asa-mini">Pediátrico:</span> sano, sin enfermedad aguda o crónica
    </div>
  </div>
</div>

<!-- ASA II -->
<div class="asa-card" style="background:var(--asa2);">
  <div class="d-flex justify-content-between">
    <span class="asa-badge bg-warning text-dark">ASA II</span>
    <span class="asa-title">Enfermedad sistémica leve</span>
  </div>
  <div class="asa-ex mt-2">
    HTA o DM2 controlada.

    <div class="asa-sub">
      <span class="asa-mini">Adulto:</span> fumador, IMC 30–40, embarazo, DM/HTA controlada
      <span class="asa-mini">Pediátrico:</span> asma controlada, epilepsia controlada, cardiopatía congénita leve
    </div>
  </div>
</div>

<!-- ASA III -->
<div class="asa-card" style="background:var(--asa3);">
  <div class="d-flex justify-content-between">
    <span class="asa-badge asa3-badge">ASA III</span>
    <span class="asa-title">Enfermedad sistémica severa</span>
  </div>
  <div class="asa-ex mt-2">
    Limitación funcional significativa.

    <div class="asa-sub">
      <span class="asa-mini">Adulto:</span> EPOC, obesidad mórbida, cirrosis compensada, ERC en diálisis
      <span class="asa-mini">Pediátrico:</span> DM insulinodependiente, OSA severa, desnutrición, cardiopatía relevante
    </div>
  </div>
</div>

<!-- ASA IV -->
<div class="asa-card" style="background:var(--asa4);">
  <div class="d-flex justify-content-between">
    <span class="asa-badge bg-danger text-white">ASA IV</span>
    <span class="asa-title">Amenaza constante para la vida</span>
  </div>
  <div class="asa-ex mt-2">
    Enfermedad crítica activa.

    <div class="asa-sub">
      <span class="asa-mini">Adulto:</span> IAM reciente, sepsis, shock, insuficiencia cardíaca avanzada
      <span class="asa-mini">Pediátrico:</span> sepsis, encefalopatía hipóxica, falla respiratoria, cardiopatía sintomática
    </div>
  </div>
</div>

<!-- ASA V -->
<div class="asa-card" style="background:var(--asa5);">
  <div class="d-flex justify-content-between">
    <span class="asa-badge asa5-badge">ASA V</span>
    <span class="asa-title">Paciente moribundo</span>
  </div>
  <div class="asa-ex mt-2">
    No sobrevivirá sin cirugía.

    <div class="asa-sub">
      <span class="asa-mini">Adulto:</span> hemorragia intracraneal, aneurisma roto, isquemia intestinal
      <span class="asa-mini">Pediátrico:</span> trauma masivo, falla multiorgánica, paro cardiorrespiratorio
    </div>
  </div>
</div>

<!-- ASA VI -->
<div class="asa-card" style="background:var(--asa6);">
  <div class="d-flex justify-content-between">
    <span class="asa-badge bg-secondary text-white">ASA VI</span>
    <span class="asa-title">Muerte cerebral</span>
  </div>
  <div class="asa-ex mt-2">
    Donante de órganos.

    <div class="asa-sub">
      <span class="asa-mini">Adulto / Pediátrico:</span> paciente en muerte cerebral con soporte vital
    </div>
  </div>
</div>

</div>
</div>
</div>

<!-- PERLAS -->
<div class="section-card">
<div class="p-3">

<div class="teaching-wrap">

<div class="teaching-title">Perlas docentes</div>

<div class="teaching-main">
ASA NO mide riesgo quirúrgico… mide al paciente
</div>

<div class="teaching-grid">

<div class="teaching-card">
<div class="teaching-label">Concepto clave</div>
<div class="teaching-text">No depende de la cirugía</div>
<div class="teaching-soft">
Un paciente ASA IV puede someterse a cirugía menor y sigue siendo ASA IV.
</div>
</div>

<div class="teaching-card">
<div class="teaching-label">Error frecuente</div>
<div class="teaching-text">Confundir gravedad con urgencia</div>
<div class="teaching-soft">
El sufijo “E” (emergencia) es independiente del ASA.
</div>
</div>

<div class="teaching-card">
  <div class="teaching-label">Usa el puntaje MÁS ALTO</div>
  <div class="teaching-text">Clasifica según la condición de mayor gravedad</div>
  <div class="teaching-soft">
    El ASA PS se define por la condición más severa del paciente en ese momento. 
    Si coexisten múltiples patologías, se debe asignar el puntaje correspondiente a la de mayor impacto sistémico.
    <br><br>
    Ejemplo: una paciente con absceso mamario podría ser ASA II, pero si evoluciona a sepsis, corresponde ASA IV. 
    En este caso, la clasificación correcta es ASA IV.
  </div>
</div>


<div class="teaching-card">
<div class="teaching-label">Uso clínico</div>
<div class="teaching-text">Predice complicaciones</div>
<div class="teaching-soft">
A mayor ASA, mayor riesgo de mortalidad y eventos perioperatorios.
</div>
</div>

<div class="teaching-card">
<div class="teaching-label">Perla de residente</div>
<div class="teaching-text">Duda → sube ASA</div>
<div class="teaching-soft">
Es más seguro sobreestimar gravedad que subestimarla.
</div>
</div>

<div class="teaching-card">
<div class="teaching-label">Evaluación real</div>
<div class="teaching-text">Integra funcionalidad</div>
<div class="teaching-soft">
No solo diagnóstico: importa cuánto limita al paciente.
</div>
</div>

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
</script>

<?php require("footer.php"); ?>