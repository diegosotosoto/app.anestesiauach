<?php

$titulo_info = "Dosis Máximas";
$descripcion_info = "Guía orientativa de dosis máximas de anestésicos locales en adultos.";
$formula = "Dosis máxima = mg/kg × peso";
$referencias = array(
  "1.- Fichas técnicas de fabricantes (Lidocaína, Bupivacaína, Levobupivacaína, Cloroprocaína).",
  "2.- Neal JM. ASRA Practice Advisory on Local Anesthetic Systemic Toxicity.",
  "3.- NYSORA: Local anesthetic systemic toxicity."
);

$icono_apunte = "<i class='fa-solid fa-syringe pe-3 pt-2'></i>";
$titulo_apunte = "Dosis Máximas de Anestésicos Locales";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfoBox()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";  

require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="local-shell">

        <style>
          .local-shell{
            max-width:980px;
            margin:0 auto;
          }

          .topbar{
            background:linear-gradient(135deg,#27458f,#3559b7);
            color:white;
            padding:20px;
            border-radius:1rem;
            margin-bottom:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
          }

          .topbar h3{
            color:#fff;
            margin-bottom:.35rem;
          }

          .card-app{
            background:#fff;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1rem;
            margin-bottom:1rem;
          }

          .title{
            font-size:.8rem;
            text-transform:uppercase;
            color:#667085;
            letter-spacing:.05em;
          }

          .result{
            font-size:1.2rem;
            font-weight:bold;
          }

          .warning{
            background:#fff5f3;
            border:1px solid #f3c2bd;
            border-radius:1rem;
            padding:1rem;
          }
          .info-box{
            padding:0;
            overflow:hidden;
          }

          .info-box-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:1rem;
            padding:1rem;
          }

          .info-box-body{
            padding:0 1rem 1rem 1rem;
            border-top:1px solid #e9eef5;
          }

          .info-toggle-btn{
            border-radius:.75rem;
            white-space:nowrap;
          }

          .info-box-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:1rem;
            padding:1rem;
          }

          /* Botón compacto SIEMPRE */
          .info-toggle-btn{
            border-radius:.6rem;
            font-size:.85rem;
            padding:.35rem .7rem;
            white-space:nowrap;
          }

          /* MOBILE: mantener alineado a la derecha */
          @media (max-width:576px){
            .info-box-header{
              flex-direction:row; /* 🔥 clave: no columna */
            }

            .info-toggle-btn{
              margin-left:auto; /* 🔥 lo empuja a la derecha */
            }
          }
        </style>

        <div class="topbar">
          <h3>Dosis Máximas de Anestésicos Locales</h3>
          <div class="opacity-75">Guía orientativa en adultos</div>
        </div>


<div class="card-app info-box">
  <div class="info-box-header">
    <div class="title mb-0">Información</div>

    <button type="button" class="btn btn-secondary info-toggle-btn" onclick="toggleInfoBox()">
      Mostrar / ocultar
    </button>
  </div>

  <div id="infoExtraBox" class="info-box-body d-none">
    <div class="pt-2">
      <?php echo $descripcion_info; ?>

      <hr>

      <b>Fórmula:</b><br>
      <?php echo $formula; ?>
    </div>
  </div>
</div>



        <div class="card-app">
          <div class="title">Anestésico</div>
          <select id="farmaco" class="form-select mt-2" onchange="calcular()">
            <option value="lidocaina">Lidocaína</option>
            <option value="bupivacaina">Bupivacaína</option>
            <option value="levobupivacaina">Levobupivacaína</option>
            <option value="cloroprocaina">Cloroprocaína</option>
          </select>

          <div class="title mt-3">Peso (kg)</div>
          <input type="number" id="peso" class="form-control" value="70" onchange="calcular()">
        </div>

        <div class="card-app">
          <div class="title">Dosis máxima recomendada</div>
          <div id="sinEpi" class="result mt-2"></div>
          <div id="conEpi" class="result mt-2"></div>
        </div>

        <div class="card-app">
          <div class="title">Descripción</div>
          <div id="info"></div>
        </div>

        <div class="warning">
          <b>⚠️ IMPORTANTE</b><br><br>

          Estas dosis corresponden a recomendaciones de fabricante y literatura.<br>
          NO son universales ni garantizan seguridad.<br><br>

          <b>Factores de riesgo para toxicidad sistémica (LAST):</b><br>

          • Sepsis<br>
          • Desnutrición / hipoproteinemia<br>
          • Edad extrema (RN / ancianos)<br>
          • Embarazo<br>
          • Enfermedad hepática<br>
          • Enfermedad renal crónica<br>
          • Estados hiperdinámicos (embarazo, tirotoxicosis)<br>
          • Insuficiencia cardíaca<br>
          • Sitios de alta absorción (intercostal, epidural, plexos)<br><br>

          👉 Ajustar dosis SIEMPRE según contexto clínico
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function calcular(){
  let peso = parseFloat(document.getElementById("peso").value);
  let f = document.getElementById("farmaco").value;

  let datos = {
    lidocaina: {
      sin:4.5,
      con:7,
      texto:"Inicio rápido, duración intermedia. Uso muy frecuente."
    },
    bupivacaina: {
      sin:2.5,
      con:3,
      texto:"Alta potencia y duración. Mayor riesgo de cardiotoxicidad."
    },
    levobupivacaina: {
      sin:2.5,
      con:3,
      texto:"Menor cardiotoxicidad que bupivacaína."
    },
    cloroprocaina: {
      sin:11,
      con:14,
      texto:"Muy corta duración. Baja toxicidad sistémica."
    }
  };

  let d = datos[f];
  let sin = d.sin * peso;
  let con = d.con * peso;

  document.getElementById("sinEpi").innerHTML =
    "Sin epinefrina: " + d.sin + " mg/kg → <b>" + sin.toFixed(0) + " mg</b>";

  document.getElementById("conEpi").innerHTML =
    "Con epinefrina: " + d.con + " mg/kg → <b>" + con.toFixed(0) + " mg</b>";

  document.getElementById("info").innerHTML = d.texto;
}

calcular();
</script>
<script>
function toggleInfoBox(){
  const box = document.getElementById('infoExtraBox');
  box.classList.toggle('d-none');
}
</script>
<?php require("footer.php"); ?>