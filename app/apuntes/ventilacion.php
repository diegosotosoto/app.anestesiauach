<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Cálculo de peso ideal basado en talla y sexo. Permite estimar volumen corriente recomendado en ventilación mecánica (6–8 ml/kg).";
$formula = "Hombre: 50 + 0.91 × (talla cm − 152.4) | Mujer: 45.5 + 0.91 × (talla cm − 152.4)";
$referencias = array(
  "Devine BJ. Gentamicin therapy. Drug Intell Clin Pharm. 1974.",
  "ARDSNet. Ventilation with lower tidal volumes."
);

$icono_apunte = "<i class='fa-solid fa-weight-scale pe-3 pt-2'></i>";
$titulo_apunte = "Peso Ideal y Volumen Corriente";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px;height:40px;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px;height:40px;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
<div class="container-fluid px-0 px-md-2">

<style>
:root{
  --brand:#27458f;
  --brand2:#3559b7;
  --bg:#f4f7fb;
  --line:#dfe7f2;
  --text:#1f2a37;
  --muted:#667085;
  --good:#edf8f7;
}

body{background:var(--bg);}

.topbar{
  background:linear-gradient(135deg,var(--brand),var(--brand2));
  color:#fff;
  border-radius:1.5rem;
  margin-bottom:1rem;
  padding:1.2rem;
}

.section-card{
  border-radius:1rem;
  background:#fff;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  margin-bottom:1rem;
}

.btn-select{
  border:1px solid #dfe7f2;
  border-radius:1rem;
  padding:.8rem;
  text-align:center;
  cursor:pointer;
  font-weight:600;
}

.btn-select.active{
  background:#edf4ff;
  border-color:#3559b7;
}

.result-box{
  background:#f8fafc;
  border-radius:1rem;
  padding:1rem;
  border:1px solid var(--line);
}

.result-num{
  font-size:2rem;
  font-weight:800;
  color:#3559b7;
}

.teaching-card{
  background:#fff;
  border:1px solid #e6e9ef;
  border-radius:1rem;
  padding:1rem;
  margin-bottom:1rem;
}
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
  padding:1rem;
}

.info-box-title{
  font-size:.8rem;
  text-transform:uppercase;
  color:#667085;
}

.info-toggle-btn{
  border-radius:.6rem;
  font-size:.85rem;
  padding:.35rem .7rem;
  background:#6c757d;
  color:white;
  border:none;
}

.info-box-content{
  display:none;
  padding:1rem;
  border-top:1px solid #e9eef5;
} 
</style>

<div class="topbar">
  <div class="small opacity-75">APP clínica • cálculo automático</div>
  <h1 class="h4">Peso Ideal y Volumen Corriente</h1>
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
      <b>Fórmula:</b><br>
      <?php echo $formula; ?>
    <?php } ?>

    <?php if(!empty($referencias)){ ?>
      <hr>
      <b>Referencias:</b>
      <ul class="mt-2 mb-0 small-note">
        <?php foreach($referencias as $ref){ ?>
          <li><?php echo $ref; ?></li>
        <?php } ?>
      </ul>
    <?php } ?>
  </div>
</div>

<div class="section-card p-3">

  <div class="mb-3 text-uppercase small text-muted">Sexo</div>

  <div class="row g-2 mb-3">
    <div class="col">
      <div id="btn_hombre" class="btn-select active">Hombre</div>
    </div>
    <div class="col">
      <div id="btn_mujer" class="btn-select">Mujer</div>
    </div>
  </div>

  <div class="mb-2 small text-muted">Talla (cm)</div>
  <input id="talla" type="number" class="form-control mb-3">

  <div class="result-box">
    <div class="small text-muted">Peso ideal</div>
    <div id="peso" class="result-num">0</div>

    <hr>

    <div class="small text-muted">Volumen corriente</div>
    <div id="vc">-</div>
  </div>

</div>

<div class="section-card p-3">

  <div class="text-uppercase small text-muted mb-3">Perlas clínicas</div>

  <div class="teaching-card">
    <b>Siempre usar peso ideal</b><br>
    El volumen corriente debe calcularse con peso ideal, no peso real.
  </div>

  <div class="teaching-card">
    <b>Ventilación protectora</b><br>
    6 ml/kg es estándar en la mayoría de escenarios.
  </div>

  <div class="teaching-card">
    <b>Pacientes obesos</b><br>
    Usar peso real → sobreventilación → volutrauma.
  </div>

  <div class="teaching-card">
    <b>Contexto clínico manda</b><br>
    Ajustar según compliance, driving pressure y EtCO₂.
  </div>

</div>

<script>
let sexo = "hombre";
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") 
    ? "block" 
    : "none";
}
function calc(){
  let talla = parseFloat(document.getElementById("talla").value);
  if(!talla) return;

  let peso;

  if(sexo === "hombre"){
    peso = 50 + 0.91*(talla-152.4);
  }else{
    peso = 45.5 + 0.91*(talla-152.4);
  }

  document.getElementById("peso").innerText = peso.toFixed(1) + " kg";

  let vc6 = (peso*6).toFixed(0);
  let vc7 = (peso*7).toFixed(0);
  let vc8 = (peso*8).toFixed(0);

  document.getElementById("vc").innerHTML =
    "6 ml/kg: <b>"+vc6+" ml</b><br>"+
    "7 ml/kg: <b>"+vc7+" ml</b><br>"+
    "8 ml/kg: <b>"+vc8+" ml</b>";
}

document.getElementById("talla").addEventListener("input",calc);

document.getElementById("btn_hombre").onclick = ()=>{
  sexo="hombre";
  document.getElementById("btn_hombre").classList.add("active");
  document.getElementById("btn_mujer").classList.remove("active");
  calc();
};

document.getElementById("btn_mujer").onclick = ()=>{
  sexo="mujer";
  document.getElementById("btn_mujer").classList.add("active");
  document.getElementById("btn_hombre").classList.remove("active");
  calc();
};
</script>


<?php require("footer.php"); ?>