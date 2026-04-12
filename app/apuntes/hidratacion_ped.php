<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo para estimar una estrategia inicial de fluidoterapia intraoperatoria pediátrica. Separa mantención basal y pérdidas por exposición quirúrgica, y agrega sugerencias docentes para fiebre, sangrado, diuresis y riesgo de hipoglicemia.";
$formula = "Mantención basal por Holliday-Segar / regla 4-2-1. La pérdida por exposición quirúrgica se presenta como una estimación docente en mL/kg/h según rango etáreo y magnitud quirúrgica.";
$referencias = array(
  "1.- Holliday MA, Segar WE. The maintenance need for water in parenteral fluid therapy. Pediatrics. 1957.",
  "2.- Concha Pinto M, Rattalino M. Fluidoterapia perioperatoria en niños. Rev Chil Anest. 2022.",
  "3.- NICE Guideline NG29. Intravenous fluid therapy in children and young people in hospital.",
  "4.- OpenAnesthesia. Perioperative Fluid Administration in Children."
);

$icono_apunte = "<i class='fa-solid fa-droplet pe-3 pt-2'></i>";
$titulo_apunte = "Reposición Intraoperatoria Pediátrica";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="fluid-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --bg:#f4f7fb;
            --soft:#f8fafc;
            --line:#dfe7f2;
            --text:#1f2a37;
            --muted:#667085;
            --good:#edf8f7;
            --warn:#fff9e8;
            --danger:#fff5f3;
            --mint:#eef7ff;
            --mint-border:#cfe1ff;
            --orange:#fff4e8;
            --orange-border:#f1c38b;
            --yellow:#fff9e8;
            --yellow-border:#ecd798;
            --red:#fff1f2;
            --red-border:#efc4be;
          }

          body{background:var(--bg);}
          .fluid-shell{
            max-width:1100px;
            margin:0 auto;
          }

          .fluid-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .fluid-topbar h1{color:#fff;}

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

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(5,1fr);
            gap:.65rem;
          }

          @media (max-width:900px){
            .choice-grid{grid-template-columns:repeat(3,1fr);}
          }

          @media (max-width:576px){
            .choice-grid{grid-template-columns:repeat(2,1fr);}
          }

          .choice-grid-3{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.65rem;
          }

          .choice-grid-3 .choice-btn{
            min-height:88px;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:78px;
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

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
            transform:translateY(-1px);
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
            min-width:140px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .meta-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
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

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid var(--yellow-border);
            border-radius:1rem;
            padding:1rem;
          }

          .danger-box{
            background:var(--danger);
            border:1px solid var(--red-border);
            border-radius:1rem;
            padding:1rem;
          }

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .orange-box{
            background:var(--orange);
            border:1px solid var(--orange-border);
            border-radius:1rem;
            padding:1rem;
          }

          .yellow-box{
            background:var(--yellow);
            border:1px solid var(--yellow-border);
            border-radius:1rem;
            padding:1rem;
          }

          .red-box{
            background:var(--red);
            border:1px solid var(--red-border);
            border-radius:1rem;
            padding:1rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{margin-bottom:.45rem;}

          @media (max-width:900px){
            .choice-grid{grid-template-columns:repeat(3,1fr);}
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .meta-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
          }

          @media (max-width:576px){
            .choice-grid{grid-template-columns:repeat(2,1fr);}
            .choice-grid-3{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
          .choice-sub{
            display:block;
            margin-top:.28rem;
            font-size:.72rem;
            font-weight:500;
            line-height:1.25;
            color:#667085;
          }

          .choice-check:checked + .choice-btn .choice-sub{
            color:#5b6f9f;
          }

          .aporte-final-card{
            background:#eef4ff;
            border:3px solid #9fb9f8;
            border-radius:1.2rem;
            padding:1.15rem 1.2rem;
            text-align:center;
            box-shadow:0 8px 20px rgba(39,69,143,.08);
          }

          .aporte-final-label{
            font-size:.85rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#5d6b85;
            font-weight:700;
            margin-bottom:.25rem;
          }

          .aporte-final-note{
            font-size:.9rem;
            color:#667085;
            margin-bottom:.55rem;
          }

          .aporte-final-value{
            font-size:2rem;
            font-weight:800;
            line-height:1;
            color:#27458f;
          }

          .calc-grid-single{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }
        </style>

        <div class="fluid-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Reposición Intraoperatoria Pediátrica</h1>
              <div class="subtle text-white-50">Mantención basal y pérdidas por exposición quirúrgica, con sugerencias de manejo perioperatorio.</div>
            </div>
            <span class="pill bg-light text-dark">Pediatría</span>
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
              Fundamento docente: la planificación perioperatoria debe considerar requerimientos basales y pérdidas derivadas de la cirugía; el ayuno habitual no debe reponerse de rutina y el “tercer espacio” no debe usarse como indicación automática de volumen adicional.  [oai_citation:3‡revchilanestv5114061209 
            </div>
          </div>
        </div>

        <!-- A -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">A. Datos de entrada</div>

<div class="calc-grid-single">
              <div class="card-block">
                <label class="form-label-lite">Peso</label>
                <div class="input-group mb-3">
                  <input class="form-control calc-trigger" type="number" step="0.1" id="peso" value="">
                  <span class="input-group-text">kg</span>
                </div>

              <label class="form-label-lite">Exposición quirúrgica</label>
              <div class="choice-grid-3">
                <div>
                  <input class="choice-check" type="radio" name="exposicion" id="exp_min" value="minima" checked>
                  <label class="choice-btn" for="exp_min">
                    <span>Mínima</span>
                    <small class="choice-sub">Superficial, corta, escasa exposición</small>
                  </label>
                </div>

                <div>
                  <input class="choice-check" type="radio" name="exposicion" id="exp_mod" value="moderada">
                  <label class="choice-btn" for="exp_mod">
                    <span>Moderada</span>
                    <small class="choice-sub">Abdominal simple, urológica, ORL mayor</small>
                  </label>
                </div>

                <div>
                  <input class="choice-check" type="radio" name="exposicion" id="exp_may" value="mayor">
                  <label class="choice-btn" for="exp_may">
                    <span>Mayor</span>
                    <small class="choice-sub">Laparotomía amplia, tórax, cirugía mayor prolongada</small>
                  </label>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Rango etáreo</label>
                <div class="choice-grid">
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_rn" value="rn" checked>
                    <label class="choice-btn" for="edad_rn">
                      <i class="fa-solid fa-baby"></i>
                      RN
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_1_4m" value="1_4m">
                    <label class="choice-btn" for="edad_1_4m">
                      <i class="fa-solid fa-baby"></i>
                      1–4 m
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_5_8m" value="5_8m">
                    <label class="choice-btn" for="edad_5_8m">
                      <i class="fa-solid fa-baby-carriage"></i>
                      5–8 m
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_9_12m" value="9_12m">
                    <label class="choice-btn" for="edad_9_12m">
                      <i class="fa-solid fa-child-reaching"></i>
                      9–12 m
                    </label>
                  </div>
                  <div>
                    <input class="choice-check" type="radio" name="edadgrp" id="edad_gt1a" value="gt1a">
                    <label class="choice-btn" for="edad_gt1a">
                      <i class="fa-solid fa-child"></i>
                      &gt;1 año
                    </label>
                  </div>
                </div>
                <div class="small-note mt-2">
                  Los rangos etáreos ajustan la interpretación clínica, el riesgo metabólico y la estimación orientativa de pérdidas por exposición.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- B -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Resumen de datos</div>

            <div class="meta-grid">
              <div class="meta-card">
                <div class="meta-label">Peso</div>
                <div id="resPeso" class="meta-value">-</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Rango etáreo</div>
                <div id="resEdad" class="meta-value">RN</div>
              </div>
              <div class="meta-card">
                <div class="meta-label">Exposición quirúrgica</div>
                <div id="resExp" class="meta-value">Mínima</div>
              </div>
            </div>
          </div>
        </div>

        <!-- C -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Mantención basal</div>

            <div class="mint-box">
              <div class="result-row">
                <div>
                  <div class="result-name">Mantención basal</div>
                  <div class="result-note">Regla de Holliday-Segar / 4-2-1.</div>
                </div>
                <div id="mantBasal" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Fluido de mantención sugerido</div>
                  <div class="result-note">En general, solución balanceada; glucosa según edad/riesgo metabólico.</div>
                </div>
                <div id="fluidoMant" class="result-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <!-- D -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Pérdida por exposición quirúrgica</div>

            <div class="good-box">
              <div class="result-row">
                <div>
                  <div class="result-name">Pérdida por exposición</div>
                  <div id="expNota" class="result-note">Estimación orientativa en mL/kg/h según edad y magnitud quirúrgica.</div>
                </div>
                <div id="perdExp" class="result-value">-</div>
              </div>



            </div>
          </div>
        </div>



<div class="section-card">
  <div class="p-3 p-md-4">
    <div class="section-title mb-3">Resultado principal</div>

    <div class="aporte-final-card">
      <div class="aporte-final-label">Aporte horario propuesto</div>
      <div class="aporte-final-note">Mantención basal + exposición quirúrgica</div>
      <div id="aporteHoraBig" class="aporte-final-value">-</div>
    </div>
  </div>
</div>


        <!-- E -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Sugerencias de manejo</div>

            <div class="orange-box mb-3">
              <strong>Pérdidas por fiebre</strong><br>
              <div class="small-note mt-2">
                Como referencia práctica, puedes considerar agregar aproximadamente <strong>10% del mantenimiento por cada °C sobre 37</strong>. No debe transformarse en una regla rígida: reinterpretar según contexto clínico, duración quirúrgica y monitorización.
              </div>
            </div>

            <div class="red-box mb-3">
              <strong>Pérdidas por sangrado</strong><br>
              <div class="small-note mt-2">
                Deben manejarse por separado. El sangrado requiere un plan específico de reposición con cristaloides/coloides/hemoderivados según magnitud, velocidad, volemia estimada, Hb/Hto y condición clínica. El artículo recomienda un plan específico cuando existe sangrado importante.  
              </div>
            </div>

            <div class="yellow-box mb-3">
              <strong>Pérdidas por diuresis</strong><br>
              <div class="small-note mt-2">
                No perseguir diuresis “bonita” con volumen automático. La antidiuresis puede ser una respuesta fisiológica al trauma quirúrgico; una oliguria aislada no obliga a cargar volumen sin valorar perfusión, hemodinamia y contexto.  
              </div>
            </div>

            <div class="warn-box">
              <strong>Glucosa e hipoglicemia</strong><br>
              <div id="glucosaNota" class="small-note mt-2">
                -
              </div>
            </div>
          </div>
        </div>

        <!-- F -->
        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">F. Tips docentes</div>

            <div class="good-box">
              <ul class="tip-list">
                <li>No se reponen pérdidas por ayuno de rutina en el paciente pediátrico sano que se opera temprano en la mañana; considerar reposición solo si existe ayuno prolongado, deshidratación o pérdidas anormales. </li>
                <li>En general no se repone el “tercer espacio”. Ese enfoque favorece la sobrehidratación y no debe usarse como indicación automática de volumen. </li>
                <li>En la mayoría de las cirugías pediátricas, la glucosa puede no ser necesaria; sí debe considerarse en RN, prematuros, PEG, hijos de madre diabética, hipercatabolismo, NPT y falla hepática.  </li>
                <li>Las pérdidas no hemáticas importantes deben reevaluarse con frecuencia. La cirugía simple y superficial puede requerir poco o ningún aporte adicional, mientras que la cirugía intracavitaria o mayor exige un plan más activo.</li>
                <li>La meta no es “dar volumen”, sino mantener homeostasis, perfusión y un intravascular adecuado evitando tanto déficit como exceso.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Ajustar siempre al contexto, pérdidas reales, hemodinamia, laboratorio y protocolo institucional.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

function getSelected(name){
  const el = document.querySelector('input[name="' + name + '"]:checked');
  return el ? el.value : null;
}

function round1(num){
  return Math.round(num * 10) / 10;
}

function maintenance421(weight){
  if(isNaN(weight) || weight <= 0) return 0;
  if(weight <= 10) return weight * 4;
  if(weight <= 20) return 40 + (weight - 10) * 2;
  return 60 + (weight - 20);
}

function getAgeMeta(age){
  const map = {
    rn: {
      label:'RN',
      glucosa:true,
      glucosaMsg:'RN: mayor riesgo de hipoglicemia. Considerar solución balanceada con glucosa y control seriado de glicemia.',
      exp:{ minima:0.5, moderada:2.0, mayor:4.0 }
    },
    '1_4m': {
      label:'1–4 m',
      glucosa:true,
      glucosaMsg:'1–4 meses: valorar glucosa según contexto, duración quirúrgica, ayuno y riesgo metabólico.',
      exp:{ minima:0.5, moderada:2.0, mayor:4.0 }
    },
    '5_8m': {
      label:'5–8 m',
      glucosa:false,
      glucosaMsg:'5–8 meses: en general no obligatoria de rutina; considerar si hay riesgo metabólico o cirugía prolongada.',
      exp:{ minima:1.0, moderada:3.0, mayor:5.0 }
    },
    '9_12m': {
      label:'9–12 m',
      glucosa:false,
      glucosaMsg:'9–12 meses: generalmente no obligatoria de rutina; individualizar según ayuno y contexto.',
      exp:{ minima:1.0, moderada:3.0, mayor:5.0 }
    },
    gt1a: {
      label:'>1 año',
      glucosa:false,
      glucosaMsg:'>1 año: en la mayoría de las cirugías pediátricas no se requiere glucosa de rutina, salvo factores de riesgo o procedimientos prolongados.',
      exp:{ minima:1.0, moderada:4.0, mayor:6.0 }
    }
  };
  return map[age] || map.rn;
}

function getExpLabel(exp){
  if(exp === 'minima') return 'Mínima';
  if(exp === 'moderada') return 'Moderada';
  return 'Mayor';
}

function updateFluidPed(){
  const peso = parseFloat(document.getElementById('peso').value);
  const edad = getSelected('edadgrp') || 'rn';
  const exposicion = getSelected('exposicion') || 'minima';

  const resPeso = document.getElementById('resPeso');
  const resEdad = document.getElementById('resEdad');
  const resExp = document.getElementById('resExp');

  const mantBasal = document.getElementById('mantBasal');
  const fluidoMant = document.getElementById('fluidoMant');
  const expNota = document.getElementById('expNota');
  const perdExp = document.getElementById('perdExp');
  const aporteHoraBig = document.getElementById('aporteHoraBig');
  const glucosaNota = document.getElementById('glucosaNota');

  const edadMeta = getAgeMeta(edad);

  resPeso.textContent = (!isNaN(peso) && peso > 0) ? round1(peso).toString().replace('.', ',') + ' kg' : '-';
  resEdad.textContent = edadMeta.label;
  resExp.textContent = getExpLabel(exposicion);

  if(isNaN(peso) || peso <= 0){
    mantBasal.textContent = '-';
    fluidoMant.textContent = '-';
    perdExp.textContent = '-';
    aporteHoraBig.textContent = '-';
    expNota.textContent = 'Estimación orientativa en mL/kg/h según edad y magnitud quirúrgica.';
    glucosaNota.textContent = 'Ingresa un peso para calcular la mantención basal y el aporte horario.';
    return;
  }

  const basal = maintenance421(peso);
  const expRate = edadMeta.exp[exposicion];
  const expMlHr = peso * expRate;
  const aporte = basal + expMlHr;

  mantBasal.innerHTML = round1(basal).toString().replace('.', ',') + ' mL/h';
  perdExp.innerHTML = round1(expMlHr).toString().replace('.', ',') + ' mL/h';
  aporteHoraBig.innerHTML = round1(aporte).toString().replace('.', ',') + ' <span style="font-size:1.1rem;font-weight:700;">mL/h</span>';
  expNota.textContent = 'Estimación orientativa: ' + round1(expRate).toString().replace('.', ',') + ' mL/kg/h según edad y magnitud quirúrgica.';
  fluidoMant.textContent = edadMeta.glucosa ? 'Balanceada + valorar glucosa' : 'Solución balanceada isotónica';
  glucosaNota.textContent = edadMeta.glucosaMsg;
}

document.addEventListener('DOMContentLoaded', function(){
  document.getElementById('peso').addEventListener('input', updateFluidPed);

  document.querySelectorAll('input[name="edadgrp"]').forEach(el => {
    el.addEventListener('change', updateFluidPed);
  });

  document.querySelectorAll('input[name="exposicion"]').forEach(el => {
    el.addEventListener('change', updateFluidPed);
  });

  updateFluidPed();
});
</script>

<?php require("footer.php"); ?>