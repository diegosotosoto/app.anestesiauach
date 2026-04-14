<?php

$titulo_info = "Hiperkalemia";
$descripcion_info = "Algoritmo clínico para evaluación y manejo rápido de hiperkalemia.";
$formula = "Clasificación por severidad + ECG + tratamiento secuencial";
$referencias = array(
  "1.- Weiner ID, Wingo CS. Hyperkalemia: a potential silent killer.",
  "2.- AHA Guidelines for Emergency Cardiovascular Care.",
  "3.- Guías y revisiones clínicas sobre manejo agudo de hiperkalemia."
);

$icono_apunte = "<i class='fa-solid fa-bolt pe-3 pt-2'></i>";
$titulo_apunte = "Hiperkalemia - Algoritmo Clínico";

$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Apuntes</span>";
$boton_navbar="<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";

require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="hk-shell">

        <style>
          .hk-shell{max-width:980px;margin:0 auto;}
          .hk-topbar{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;margin-bottom:1rem;
          }
          .hk-topbar h1{color:#fff;}
          .section-card{
            border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;overflow:hidden;margin-bottom:1rem;
          }
          .section-title{
            font-size:.8rem;letter-spacing:.05em;text-transform:uppercase;color:#667085;
          }
          .pill{
            display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.78rem;
            background:#eef3ff;color:#3559b7;font-weight:600;
          }
          .subtle{font-size:.94rem;color:#5f6b76;}
          .severity-grid{
            display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;
          }
          .severity-btn{
            border:1px solid #dfe7f2;border-radius:1rem;background:#f8fafc;
            padding:1rem .9rem;text-align:center;cursor:pointer;transition:.15s ease;user-select:none;
          }
          .severity-btn.active{
            background:#edf4ff;border-color:#bfd2ff;box-shadow:0 0 0 2px rgba(53,89,183,.08) inset;
          }
          .severity-btn .name{font-weight:700;color:#1f2a37;margin-bottom:.2rem;}
          .severity-btn .range{font-size:.88rem;color:#667085;}
          .ecg-check{
            display:flex;align-items:center;justify-content:center;gap:.6rem;padding-top:.4rem;
          }
          .algo-box{
            padding:1rem;border-radius:1rem;border:1px solid #dfe7f2;
          }
          .hk-low{background:#edf8f7;}
          .hk-mid{background:#fff9e8;}
          .hk-high{background:#fff5f3;}
          .algo-title{
            font-size:1.15rem;font-weight:800;color:#1f2a37;margin-bottom:.8rem;
          }
          .algo-block{
            background:#fff;border:1px solid #e6e9ef;border-radius:.9rem;
            padding:.85rem .95rem;margin-bottom:.7rem;
          }
          .algo-block:last-child{margin-bottom:0;}
          .algo-block h6{font-weight:800;margin-bottom:.55rem;}
          .dose{font-weight:700;color:#1f2a37;}
          .refs-card{display:none;}
          .refs-card ul{
            color:#667085;line-height:1.55;padding-left:1.1rem;margin-bottom:0;
          }
          @media (max-width:768px){
            .severity-grid{grid-template-columns:1fr;}
          }
        </style>
<style>
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
  gap:1rem;
  padding:1rem;
}

.info-box-title{
  font-size:.8rem;
  text-transform:uppercase;
  color:#667085;
  letter-spacing:.08em;
}

.info-toggle-btn{
  border-radius:.6rem;
  font-size:.85rem;
  padding:.35rem .7rem;
  white-space:nowrap;
  background:#6c757d;
  border:none;
  color:white;
  transition:.2s;
}

.info-toggle-btn:hover{
  background:#5a6268;
  color:white;
}

.info-box-content{
  padding:1rem;
  display:none;
  animation:fadeIn .2s ease-in-out;
  border-top:1px solid #e9eef5;
}

@keyframes fadeIn{
  from{opacity:0; transform:translateY(-5px);}
  to{opacity:1; transform:translateY(0);}
}

@media (max-width:576px){
  .info-box-header{
    flex-direction:row;
  }

  .info-toggle-btn{
    margin-left:auto;
  }
}
</style>
        <div class="hk-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Hiperkalemia</h1>
              <div class="subtle text-white-50">Algoritmo rápido con manejo detallado según severidad y alteraciones ECG.</div>
            </div>
            <span class="pill bg-light text-dark">Emergencia</span>
          </div>
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
  </div>
</div>


        <div id="referenciasBox" class="section-card refs-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Referencias</div>
            <ul>
              <?php foreach($referencias as $ref){ ?>
                <li class="mb-2"><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Clasificación</div>

            <div class="severity-grid">
              <div class="severity-btn active" id="btn_leve" onclick="setSeverity('leve')">
                <div class="name">Leve</div>
                <div class="range">5.0 – 5.9 mEq/L</div>
              </div>

              <div class="severity-btn" id="btn_moderada" onclick="setSeverity('moderada')">
                <div class="name">Moderada</div>
                <div class="range">6.0 – 6.5 mEq/L</div>
              </div>

              <div class="severity-btn" id="btn_severa" onclick="setSeverity('severa')">
                <div class="name">Severa</div>
                <div class="range">&gt; 6.5 mEq/L</div>
              </div>
            </div>

            <div class="ecg-check mt-3">
              <input class="form-check-input" type="checkbox" id="ecg" onchange="calcularHK()">
              <label class="form-check-label" for="ecg">ECG alterado</label>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Conducta</div>
            <div id="algoritmoBox" class="algo-box hk-low">
              <div id="algoritmoContenido"></div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
let severidadActual = 'leve';

function toggleReferencias(e){
  if(e) e.preventDefault();
  const box = document.getElementById('referenciasBox');
  box.style.display = (box.style.display === 'block') ? 'none' : 'block';
}

function setSeverity(level){
  severidadActual = level;
  ['leve','moderada','severa'].forEach(id => {
    const el = document.getElementById('btn_' + id);
    if(el) el.classList.toggle('active', id === level);
  });
  calcularHK();
}

function calcularHK(){
  const ecg = document.getElementById('ecg').checked;
  const box = document.getElementById('algoritmoBox');
  const out = document.getElementById('algoritmoContenido');

  if(severidadActual === 'leve' && !ecg){
    box.className = 'algo-box hk-low';
    out.innerHTML = `
      <div class="algo-title">Manejo leve</div>
      <div class="algo-block">
        - Confirmar pseudohiperkalemia<br>
        - Repetir muestra si hay sospecha de error preanalítico<br>
        - Suspender aporte exógeno de K<br>
        - Buscar etiología<br>
        - Monitorizar K seriado y ECG según contexto
      </div>
    `;
    return;
  }

  if(severidadActual === 'moderada' && !ecg){
    box.className = 'algo-box hk-mid';
    out.innerHTML = `
      <div class="algo-title">Manejo moderado</div>

      <div class="algo-block">
        <h6>1. Redistribución</h6>
        <span class="dose">Insulina + Glucosa:</span> 10 U en 80 ml al 30% EV<br>
        Adultos: 1 U cada 2,5 g de glucosa<br>
        Niños: 1 U cada 5 g de glucosa<br>
        Idealmente en 1 hora<br>
        Inicio: ~20 min | Duración: 4–6 h<br>
        Complicación: hipoglicemia
      </div>

      <div class="algo-block">
        <h6>2. Salbutamol</h6>
        <span class="dose">20 mg</span> nebulizado<br>
        Alternativa: inhalador en TOT si corresponde<br>
        Inicio: ~30 min | Duración: ~2 h<br>
        Complicación: taquicardia
      </div>

      <div class="algo-block">
        <h6>3. Eliminación</h6>
        Considerar según contexto:<br>
        - Furosemida 40–80 mg EV<br>
        - NaHCO₃ si acidosis concomitante<br>
        - Kayexalate 15–30 g VO / SNG<br>
        - Hemodiálisis si refractaria o falla renal significativa
      </div>
    `;
    return;
  }

  box.className = 'algo-box hk-high';
  out.innerHTML = `
    <div class="algo-title">Manejo severo / ECG alterado</div>

    <div class="algo-block">
      <h6>1. Estabilizar membrana</h6>
      <span class="dose">Gluconato de Ca 10%:</span> 10 ml EV en 10 min<br>
      Inicio: inmediato | Duración: 30–60 min<br>
      Complicación: hipercalcemia<br><br>

      <span class="dose">Cloruro de Ca:</span> 6.8 mmol / 10 ml<br>
      Ojo con dolor y daño tisular si extravasa<br>
      Precipita con NaHCO₃<br><br>

      <span class="dose">NaCl 3%:</span> solo si hay hiponatremia concomitante<br>
      Riesgo de sobrecarga de volumen
    </div>

    <div class="algo-block">
      <h6>2. Redistribución</h6>
      <span class="dose">Insulina + Glucosa:</span> 10 U en 80 ml al 30% EV<br>
      Adultos: 1 U cada 2,5 g de glucosa<br>
      Niños: 1 U cada 5 g de glucosa<br>
      Idealmente en 1 hora<br>
      Inicio: ~20 min | Duración: 4–6 h<br>
      Complicación: hipoglicemia<br><br>

      <span class="dose">Salbutamol:</span> 20 mg nebulizado<br>
      Inicio: ~30 min | Duración: ~2 h<br>
      Complicación: taquicardia
    </div>

    <div class="algo-block">
      <h6>3. Eliminación</h6>
      <span class="dose">Furosemida:</span> 40–80 mg EV<br>
      Inicio: ~15 min | Duración: 2–3 h<br>
      Complicación: depleción de volumen<br><br>

      <span class="dose">NaHCO₃:</span> infusión 2/3 M variable EV<br>
      Inicio: 4–6 h | Duración: infusión<br>
      Complicación: alcalosis metabólica, sobrecarga de volumen<br><br>

      <span class="dose">Kayexalate:</span> 15–30 g VO / SNG<br>
      Inicio: >2 h | Duración: 4–6 h<br>
      Complicación: eficacia variable<br><br>

      <span class="dose">Hemodiálisis:</span> considerar precozmente si refractaria, severa o con falla renal
    </div>

    <div class="algo-block">
      <h6>4. Monitorización</h6>
      - Monitorizar K seriado<br>
      - Monitorizar glucosa<br>
      - Vigilar recurrencia<br>
      - Recordar: puede existir hiperkalemia con ECG normal
    </div>
  `;
}

calcularHK();
</script>
<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php require("footer.php"); ?>
