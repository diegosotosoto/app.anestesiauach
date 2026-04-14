<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Calculadora docente de ultrasonido gástrico para estimar tamaño y consistencia del contenido gástrico en pacientes con ayuno desconocido o no fiable. Integra la estimación ecográfica del volumen con la apariencia cualitativa del antro para orientar el riesgo de broncoaspiración.";
$formula = "Si la edad se ingresa en meses, se aplica el modelo pediátrico de Spencer: Volumen = -7,8 + 3,5 × área DLD (cm²) + 0,127 × edad (meses). Si la edad se ingresa en años, se aplica el modelo de Perlas: Volumen = 27 + 14,6 × área DLD (cm²) - 1,28 × edad (años). Umbral docente de mayor riesgo: > 1,5 mL/kg.";
$referencias = array(
  "1.- Spencer et al. Modelo pediátrico de estimación de volumen gástrico por ultrasonido.",
  "2.- Perlas et al. Modelo de estimación de volumen gástrico con área antral en DLD.",
  "3.- Apunte docente: el US gástrico permite evaluar calidad y magnitud del contenido gástrico para orientar riesgo de broncoaspiración.",
  "4.- Se requieren aproximadamente 33 evaluaciones para alcanzar un mínimo de pericia técnica."
);

$icono_apunte = "<i class='fa-solid fa-stomach pe-3 pt-2'></i>";
$titulo_apunte = "US Gástrico Pediátrico";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="gastro-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --bg:#f4f7fb;
            --soft:#f8fafc;
            --line:#dfe7f2;
            --text:#1f2a37;
            --muted:#667085;
            --mint:#eef7ff;
            --mint-border:#cfe1ff;
            --good:#edf8f7;
            --good-border:#cfe8e6;
            --warn:#fff9e8;
            --warn-border:#ecd798;
            --danger:#fff5f3;
            --danger-border:#efc4be;
            --violet:#f2efff;
            --violet-border:#d8cdfc;
          }

          body{background:var(--bg);}
          .gastro-shell{max-width:1080px;margin:0 auto;}

          .gastro-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .gastro-topbar h1{color:#fff;}

          .section-card{
            border:0;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;
            overflow:hidden;
            margin-bottom:1rem;
          }

          .section-title{
            font-size:.8rem;
            letter-spacing:.05em;
            text-transform:uppercase;
            color:var(--muted);
          }

          .pill{
            display:inline-block;
            padding:.2rem .55rem;
            border-radius:999px;
            font-size:.78rem;
            background:#eef3ff;
            color:#3559b7;
            font-weight:600;
          }

          .subtle{
            font-size:.94rem;
            color:#5f6b76;
          }

          .small-note{
            font-size:.82rem;
            color:#667085;
            line-height:1.45;
          }

          .footer-note{
            font-size:.82rem;
            color:#6c757d;
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

          .calc-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:1rem;
          }

          .card-block{
            border:1px solid var(--line);
            border-radius:1rem;
            background:var(--soft);
            padding:1rem;
          }

          .form-label-lite{
            font-size:.92rem;
            font-weight:600;
            color:var(--text);
            margin-bottom:.35rem;
          }

          .choice-grid-4{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:.65rem;
          }

          .choice-grid-2{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.65rem;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:84px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:1rem;
            padding:.8rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.15;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
          }

          .choice-btn i{
            font-size:1.1rem;
            margin-bottom:.35rem;
            color:#3559b7;
          }

          .choice-sub{
            display:block;
            margin-top:.25rem;
            font-size:.72rem;
            font-weight:500;
            line-height:1.25;
            color:#667085;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
            transform:translateY(-1px);
          }

          .choice-check:checked + .choice-btn .choice-sub{
            color:#5b6f9f;
          }

          .result-row{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:1rem;
            padding:.9rem 1rem;
            border:1px solid #e6e9ef;
            border-radius:.9rem;
            background:#fff;
            margin-bottom:.65rem;
          }

          .result-row:last-child{margin-bottom:0;}

          .result-name{
            font-weight:700;
            color:#1f2a37;
            line-height:1.2;
          }

          .result-note{
            font-size:.82rem;
            color:#667085;
            margin-top:.2rem;
            line-height:1.4;
          }

          .result-value{
            min-width:150px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .meta-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:.75rem;
          }

          .meta-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.9rem;
          }

          .meta-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#667085;
            margin-bottom:.25rem;
          }

          .meta-value{
            font-size:1rem;
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
          }

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .good-box{
            background:var(--good);
            border:1px solid var(--good-border);
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid var(--warn-border);
            border-radius:1rem;
            padding:1rem;
          }

          .danger-box{
            background:var(--danger);
            border:1px solid var(--danger-border);
            border-radius:1rem;
            padding:1rem;
          }

          .violet-box{
            background:var(--violet);
            border:1px solid var(--violet-border);
            border-radius:1rem;
            padding:1rem;
          }

          .result-main-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
          }

          .result-main-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .result-main-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .result-main-value{
            font-size:2rem;
            font-weight:800;
            line-height:1.05;
            color:#27458f;
          }

          .image-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.8rem;
          }

          .image-card{
            border:1px solid var(--line);
            border-radius:1rem;
            background:#fff;
            padding:.65rem;
          }

          .image-card img{
            width:100%;
            height:auto;
            display:block;
            border-radius:.8rem;
          }

          .image-cap{
            font-size:.78rem;
            color:#667085;
            margin-top:.45rem;
            line-height:1.35;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{margin-bottom:.45rem;}

          @media (max-width:900px){
            .choice-grid-4{grid-template-columns:repeat(2,1fr);}
            .meta-grid{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .image-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
          }

          @media (max-width:576px){
            .choice-grid-2,.choice-grid-4{grid-template-columns:1fr;}
            .meta-grid{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }

 .content-choice-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:.65rem;
}

.content-choice-btn{
  min-height:96px;
  padding:.7rem .55rem;
  border-radius:.95rem;
}

.content-choice-btn i{
  font-size:1rem;
  margin-bottom:.28rem;
}

.content-choice-btn .choice-sub{
  font-size:.68rem;
  line-height:1.2;
  margin-top:.22rem;
}

@media (max-width:768px){
  .content-choice-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .content-choice-btn{
    min-height:92px;
  }
}         
#contenidoVisualBox{
  margin-top: .9rem;
}

.age-model-grid{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:.65rem;
}

.age-model-btn{
  min-height:74px;
  padding:.65rem .75rem;
  border-radius:.9rem;
}

.age-model-btn i{
  font-size:1rem;
  margin-bottom:.22rem;
}

.age-model-btn .choice-sub{
  margin-top:.18rem;
  font-size:.7rem;
  line-height:1.2;
}

@media (max-width:576px){
  .age-model-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .age-model-btn{
    min-height:70px;
    padding:.55rem .55rem;
  }
}
        </style>

        <div class="gastro-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Ultrasonido Gástrico</h1>
              <div class="subtle text-white-50">Estimación de volumen y evaluación cualitativa del contenido gástrico para orientar riesgo de broncoaspiración.</div>
            </div>
            <span class="pill bg-light text-dark">POCUS</span>
          </div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>

          <div id="infoContent" class="info-box-content">
            <?php echo $descripcion_info; ?>

            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Comentario:</b><br>
              <?php echo $formula; ?>
            <?php } ?>

            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0">
                <?php foreach($referencias as $ref){ ?>
                  <li><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>

            <hr>
            <div class="small-note">
              Técnica resumida: transductor curvo en general y lineal en niños pequeños; explorar epigastrio en eje longitudinal, evaluar el antro en decúbito dorsal y luego en DLD para estimar calidad y magnitud del contenido.
            </div>
          </div>
        </div>

        <!-- A. DATOS DE ENTRADA -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">A. Datos de entrada</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Peso</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="peso" value="">
                  <span class="input-group-text">kg</span>
                </div>

                <label class="form-label-lite">Edad</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="edad" value="">
                  <span class="input-group-text" id="edadUnitText">meses</span>
                </div>

<label class="form-label-lite">Modelo / población</label>
<div class="age-model-grid">
  <div>
    <input class="choice-check" type="radio" name="edadunit" id="edad_meses" value="meses" checked>
    <label class="choice-btn age-model-btn" for="edad_meses">
      <i class="fa-solid fa-child"></i>
      Pediátrica
      <small class="choice-sub">Edad en meses</small>
    </label>
  </div>

  <div>
    <input class="choice-check" type="radio" name="edadunit" id="edad_anios" value="anios">
    <label class="choice-btn age-model-btn" for="edad_anios">
      <i class="fa-solid fa-user"></i>
      Adultos
      <small class="choice-sub">Edad en años</small>
    </label>
  </div>
</div>

<div class="mint-box mt-3">
  <strong>Selección automática de fórmula</strong><br>
  <div id="modeloAutoTexto" class="small-note mt-2">
    En modo pediátrico se aplicará Spencer. En modo adultos se aplicará Perlas.
  </div>
</div>


              </div>




              <div class="card-block">
                <label class="form-label-lite">Área antral en DLD</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="areaDLD" value="">
                  <span class="input-group-text">cm²</span>
                </div>


              </div>
            </div>



<div class="card-block mt-3">
  <label class="form-label-lite">Consistencia / aspecto del contenido</label>

  <div class="content-choice-grid">
    <div>
      <input class="choice-check" type="radio" name="contenido" id="cont_vacio" value="vacio" checked>
      <label class="choice-btn content-choice-btn" for="cont_vacio">
        <i class="fa-regular fa-circle"></i>
        Vacío
        <small class="choice-sub">Antro colapsado</small>
      </label>
    </div>

    <div>
      <input class="choice-check" type="radio" name="contenido" id="cont_liquido" value="liquido">
      <label class="choice-btn content-choice-btn" for="cont_liquido">
        <i class="fa-solid fa-droplet"></i>
        Líquido claro
        <small class="choice-sub">Anecoico</small>
      </label>
    </div>

    <div>
      <input class="choice-check" type="radio" name="contenido" id="cont_espeso" value="espeso">
      <label class="choice-btn content-choice-btn" for="cont_espeso">
        <i class="fa-solid fa-cloud"></i>
        Espeso / mixto
        <small class="choice-sub">Particulado</small>
      </label>
    </div>

    <div>
      <input class="choice-check" type="radio" name="contenido" id="cont_solido" value="solido">
      <label class="choice-btn content-choice-btn" for="cont_solido">
        <i class="fa-solid fa-cubes-stacked"></i>
        Sólido
        <small class="choice-sub">Sombra / heterogéneo</small>
      </label>
    </div>
  </div>

  <div id="contenidoVisualBox" class="good-box mt-2">
    <strong id="visualTitulo">Estómago vacío</strong><br>
    <div id="visualTexto" class="small-note mt-2 mb-3">
      Antro pequeño o colapsado, con paredes próximas y sin distensión evidente.
    </div>

    <div class="image-card">
      <img id="visualImg" src="estomago_vacio.jpg" alt="Referencia visual del contenido gástrico">
      <div id="visualCap" class="image-cap">Referencia de antro vacío.</div>
    </div>
  </div>
</div>








        <!-- B. RESUMEN -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Tarjeta resumen</div>

            <div class="meta-grid">
              <div class="meta-card">
                <div class="meta-label">Peso</div>
                <div id="resPeso" class="meta-value">-</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Edad</div>
                <div id="resEdad" class="meta-value">-</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Fórmula aplicada</div>
                <div id="resModelo" class="meta-value">Spencer</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Consistencia</div>
                <div id="resContenido" class="meta-value">Vacío</div>
              </div>
            </div>
          </div>
        </div>

        <!-- C. CALCULO -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Estimación de volumen y riesgo</div>

            <div class="mint-box mb-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Fórmula aplicada</div>
                  <div id="formulaAplicada" class="result-note">Spencer: -7,8 + 3,5 × área DLD + 0,127 × edad (meses).</div>
                </div>
                <div id="formulaCorta" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Volumen estimado</div>
                  <div class="result-note">Si el cálculo arroja valor negativo, se corrige a 0 mL.</div>
                </div>
                <div id="volEstimado" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Volumen relativo</div>
                  <div class="result-note">Referencia docente: &gt; 1,5 mL/kg orienta a mayor riesgo.</div>
                </div>
                <div id="volRelativo" class="result-value">-</div>
              </div>
            </div>

            <div class="result-main-card">
              <div class="result-main-label">Resultado principal</div>
              <div class="result-main-note">Interpretación docente integrada: calidad + volumen</div>
              <div id="riesgoFinal" class="result-main-value">Bajo riesgo</div>
            </div>
          </div>
        </div>



        <!-- E. GUIA DE EXPLORACION -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Guía orientativa de exploración</div>

            <div class="warn-box mb-3">
              <strong>Posición del probe y estructuras objetivo</strong>
              <ul class="tip-list mt-2">
                <li>Evaluar el antro en decúbito supino y en DLD.</li>
                <li>El objetivo es identificar <strong>hígado, antro gástrico, páncreas y aorta</strong>.</li>
                <li>El contenido líquido suele verse hipoecoico y el sólido puede generar imagen heterogénea o “ground glass”.</li>
              </ul>
            </div>

            <div class="image-card">
              <img src="us_gastrico.jpeg" alt="Guía de posición del probe y estructuras">
              <div class="image-cap">Guía visual de posicionamiento del transductor y estructuras anatómicas que se deben buscar durante la exploración del antro.</div>
            </div>
          </div>
        </div>


        <!-- . TIPS -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Tips docentes</div>

            <div class="violet-box">
              <ul class="tip-list">
                <li>Primero decide la <strong>calidad del contenido</strong>; luego usa la fórmula para cuantificar. Si el patrón parece sólido, el número rara vez manda por sí solo.</li>
                <li>Cuando la edad está en <strong>meses</strong>, usa el modelo pediátrico de Spencer. Cuando está en <strong>años</strong>, usa Perlas. Así evitas selectores redundantes y errores de interpretación.</li>
                <li>El umbral de <strong>&gt; 1,5 mL/kg</strong> es una referencia docente útil de mayor riesgo, pero debe leerse junto al aspecto del contenido y el contexto clínico.</li>
                <li>El US gástrico es especialmente útil cuando el ayuno es desconocido, no fiable o existe una duda clínica real.</li>
                <li>No es adecuado en pacientes con anatomía alterada: gastrectomía previa, bypass, banda, gran hernia hiatal o fundoplicatura previa.</li>
                <li>Se estima que se requieren unas <strong>33 evaluaciones</strong> para alcanzar un mínimo de pericia técnica.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. No reemplaza juicio clínico, contexto anestésico ni evaluación ecográfica competente.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleInfo(){
  const box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

function getSelected(name){
  const el = document.querySelector('input[name="' + name + '"]:checked');
  return el ? el.value : null;
}

function round1(num){
  return Math.round(num * 10) / 10;
}

function round2(num){
  return Math.round(num * 100) / 100;
}

function clampVol(num){
  if(isNaN(num) || !isFinite(num)) return NaN;
  return num < 0 ? 0 : num;
}

function updateEdadUnitLabel(){
  const unidad = getSelected('edadunit') || 'meses';
  document.getElementById('edadUnitText').textContent = unidad === 'meses' ? 'meses' : 'años';
document.getElementById('modeloAutoTexto').textContent =
  unidad === 'meses'
    ? 'En modo pediátrico se aplicará Spencer.'
    : 'En modo adultos se aplicará Perlas.';
}

function getContenidoLabel(val){
  const map = {
    vacio:'Vacío',
    liquido:'Líquido claro',
    espeso:'Espeso / mixto',
    solido:'Sólido'
  };
  return map[val] || '-';
}

function getContenidoVisual(val){
  const map = {
    vacio:{
      titulo:'Estómago vacío',
      texto:'Antro pequeño o colapsado, con paredes próximas y sin distensión evidente.',
      img:'estomago_vacio.jpg',
      cap:'Referencia de antro vacío.',
      box:'good-box'
    },
    liquido:{
      titulo:'Líquido claro',
      texto:'Contenido anecoico o hipoecoico, con distensión más uniforme del antro. Puede verse un patrón compatible con líquido claro.',
      img:'liquido_claro.jpg',
      cap:'Referencia de líquido claro.',
      box:'mint-box'
    },
    espeso:{
      titulo:'Contenido espeso / mixto',
      texto:'Material denso o particulado, con ecos internos y aspecto mixto. Puede impedir una lectura simple de estructuras profundas.',
      img:'solido_fluido.jpg',
      cap:'Referencia de contenido espeso o mixto.',
      box:'warn-box'
    },
    solido:{
      titulo:'Contenido sólido',
      texto:'Patrón heterogéneo, frecuentemente con sombra acústica o aspecto tipo ground glass. Debe considerarse de alto riesgo práctico.',
      img:'solido_reciente.jpg',
      cap:'Referencia de contenido sólido / sólido precoz.',
      box:'danger-box'
    }
  };
  return map[val] || map.vacio;
}

function applyRiskStyle(level){
  const box = document.querySelector('.result-main-card');
  if(!box) return;

  box.classList.remove('good-box', 'warn-box', 'danger-box', 'mint-box');

  if(level === 'bajo'){
    box.classList.add('good-box');
  } else if(level === 'intermedio'){
    box.classList.add('warn-box');
  } else {
    box.classList.add('danger-box');
  }
}

function updateVisualContent(contenido){
  const v = getContenidoVisual(contenido);
  const box = document.getElementById('contenidoVisualBox');
  box.className = v.box;

  document.getElementById('visualTitulo').textContent = v.titulo;
  document.getElementById('visualTexto').textContent = v.texto;
  document.getElementById('visualImg').src = v.img;
  document.getElementById('visualCap').textContent = v.cap;
}

function updateGastricUS(){
  updateEdadUnitLabel();

  const peso = parseFloat(document.getElementById('peso').value);
  const edad = parseFloat(document.getElementById('edad').value);
  const area = parseFloat(document.getElementById('areaDLD').value);
  const unidadEdad = getSelected('edadunit') || 'meses';
  const contenido = getSelected('contenido') || 'vacio';

  updateVisualContent(contenido);

  const modelo = (unidadEdad === 'meses') ? 'spencer' : 'perlas';

  document.getElementById('resPeso').textContent = (!isNaN(peso) && peso > 0) ? round1(peso).toString().replace('.', ',') + ' kg' : '-';
  document.getElementById('resEdad').textContent = (!isNaN(edad) && edad >= 0) ? round1(edad).toString().replace('.', ',') + ' ' + (unidadEdad === 'meses' ? 'meses' : 'años') : '-';
  document.getElementById('resModelo').textContent = modelo === 'spencer' ? 'Spencer' : 'Perlas';
  document.getElementById('resContenido').textContent = getContenidoLabel(contenido);

  let volumen = NaN;
  let formulaTxt = '';
  let formulaShort = '-';

  if(modelo === 'spencer'){
    formulaTxt = 'Spencer: -7,8 + 3,5 × área DLD + 0,127 × edad (meses).';
    if(!isNaN(edad) && !isNaN(area)){
      volumen = -7.8 + (3.5 * area) + (0.127 * edad);
      formulaShort = '-7,8 + 3,5×' + round1(area).toString().replace('.', ',') + ' + 0,127×' + round1(edad).toString().replace('.', ',');
    } else {
      formulaShort = 'Completa edad y área';
    }
  }

  if(modelo === 'perlas'){
    formulaTxt = 'Perlas: 27 + 14,6 × área DLD - 1,28 × edad (años).';
    if(!isNaN(edad) && !isNaN(area)){
      volumen = 27 + (14.6 * area) - (1.28 * edad);
      formulaShort = '27 + 14,6×' + round1(area).toString().replace('.', ',') + ' - 1,28×' + round1(edad).toString().replace('.', ',');
    } else {
      formulaShort = 'Completa edad y área';
    }
  }

  volumen = clampVol(volumen);

  document.getElementById('formulaAplicada').textContent = formulaTxt;
  document.getElementById('formulaCorta').textContent = formulaShort;

  if(!isNaN(volumen)){
    document.getElementById('volEstimado').innerHTML = round1(volumen).toString().replace('.', ',') + ' mL';
  } else {
    document.getElementById('volEstimado').textContent = '-';
  }

  let relativo = NaN;
  if(!isNaN(volumen) && !isNaN(peso) && peso > 0){
    relativo = volumen / peso;
    document.getElementById('volRelativo').innerHTML = round2(relativo).toString().replace('.', ',') + ' mL/kg';
  } else {
    document.getElementById('volRelativo').textContent = '-';
  }

  let riskLevel = 'bajo';
  let riskTitle = 'Contenido compatible con estómago vacío';
  let riskText = 'Si el antro está colapsado y el cálculo no sugiere volumen relevante, el riesgo ecográfico parece bajo en este contexto.';
  let riskMain = 'Bajo riesgo';

  if(contenido === 'liquido'){
    riskLevel = 'intermedio';
    riskTitle = 'Contenido líquido claro';
    riskText = 'El líquido claro aislado no equivale automáticamente a alto riesgo, pero si el volumen relativo supera 1,5 mL/kg la preocupación por aspiración aumenta.';
    riskMain = 'Riesgo intermedio';
  }

  if(contenido === 'espeso'){
    riskLevel = 'alto';
    riskTitle = 'Contenido espeso / mixto';
    riskText = 'La presencia de material particulado o espeso pesa mucho en la interpretación clínica y obliga a mayor precaución, aunque el volumen calculado no sea extremo.';
    riskMain = 'Riesgo aumentado';
  }

  if(contenido === 'solido'){
    riskLevel = 'alto';
    riskTitle = 'Contenido sólido';
    riskText = 'Un patrón sólido o francamente heterogéneo debe considerarse de alto riesgo práctico frente a broncoaspiración.';
    riskMain = 'Alto riesgo';
  }

  if(!isNaN(relativo) && relativo > 1.5 && (contenido === 'vacio' || contenido === 'liquido')){
    riskLevel = 'alto';
    riskTitle = 'Volumen relativo elevado';
    riskText = 'El volumen estimado supera 1,5 mL/kg. En este contexto el riesgo de aspiración debe considerarse aumentado, especialmente si el ayuno es incierto o poco fiable.';
    riskMain = 'Riesgo aumentado';
  }

applyRiskStyle(riskLevel === 'alto' ? 'alto' : riskLevel);
document.getElementById('riesgoFinal').innerHTML =
  riskMain + '<br><span style="font-size:.95rem;font-weight:600;">' +
  riskTitle + '</span><br><span style="font-size:.82rem;font-weight:500;color:#5f6b76;line-height:1.35;display:inline-block;margin-top:.35rem;">' +
  riskText + '</span>';
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', updateGastricUS);
    el.addEventListener('change', updateGastricUS);
  });

  document.querySelectorAll('input[name="edadunit"], input[name="contenido"]').forEach(el => {
    el.addEventListener('change', updateGastricUS);
  });

  updateGastricUS();
});
</script>

<?php require("footer.php"); ?>