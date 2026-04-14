<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "La escala FLACC permite evaluar dolor en lactantes, niños pequeños o pacientes no comunicativos a través de cinco dominios observacionales: cara, piernas, actividad, llanto y consolabilidad. Cada dominio puntúa 0, 1 o 2, para un total de 0 a 10.";
$formula = "FLACC = Cara (0-2) + Piernas (0-2) + Actividad (0-2) + Llanto (0-2) + Consolabilidad (0-2)";
$referencias = array(
  "1.- Merkel SI, Voepel-Lewis T, Shayevitz JR, Malviya S. The FLACC: a behavioral scale for scoring postoperative pain in young children. Pediatr Nurs. 1997;23(3):293-297.",
  "2.- Voepel-Lewis T, Zanotti J, Dammeyer JA, Merkel S. Reliability and validity of the Face, Legs, Activity, Cry, Consolability behavioral tool in assessing acute pain in critically ill patients. Am J Crit Care. 2010;19(1):55-61."
);

$icono_apunte = "<i class='fa-solid fa-baby pe-3 pt-2'></i>";
$titulo_apunte = "Escala FLACC";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="flacc-shell">

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
          }

          body{background:var(--bg);}

          .flacc-shell{max-width:1100px;margin:0 auto;}

          .flacc-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .flacc-topbar h1{color:#fff;}

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

          .subtle{font-size:.94rem;color:#5f6b76;}

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

          .domain-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }

          .domain-title{
            font-size:1rem;
            font-weight:800;
            color:#1f2a37;
            margin-bottom:.85rem;
          }

          .score-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.75rem;
          }

          .score-btn{
            min-height:148px;
            border:1px solid #dfe7f2;
            border-radius:1rem;
            background:#f8fafc;
            padding:.9rem .8rem;
            cursor:pointer;
            transition:.15s ease;
            user-select:none;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
          }

          .score-btn.active{
            background:#edf4ff;
            border-color:#bfd2ff;
            box-shadow:0 0 0 2px rgba(53,89,183,.08) inset;
          }

          .score-text{
            font-size:.92rem;
            line-height:1.25;
            color:#1f2a37;
          }

          .score-points{
            font-size:1.4rem;
            font-weight:800;
            color:#3559b7;
            text-align:right;
            line-height:1;
          }

          .summary-box{
            padding:1rem;
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
          }

          .summary-main{
            font-size:1.12rem;
            font-weight:800;
            color:#1f2a37;
            margin-bottom:.85rem;
          }

          .summary-grid{
            display:grid;
            grid-template-columns:1fr auto;
            gap:1rem;
            align-items:center;
          }

          .total-score{
            font-size:2.2rem;
            font-weight:900;
            color:#3559b7;
            line-height:1;
          }

          .badge-soft{
            display:inline-block;
            padding:.3rem .65rem;
            border-radius:999px;
            font-size:.78rem;
            font-weight:700;
          }

          .badge-ok{background:#edf8f7;color:#1e7a5a;}
          .badge-mid{background:#fff9e8;color:#8a6514;}
          .badge-no{background:#fff5f3;color:#b42318;}

          .conduct-box{
            padding:1rem;
            border-radius:1rem;
            border:1px solid var(--line);
          }

          .conduct-ok{background:var(--good);}
          .conduct-mid{background:var(--warn);}
          .conduct-no{background:var(--danger);}

          .conduct-title{
            font-size:1.08rem;
            font-weight:800;
            color:#1f2a37;
            margin-bottom:.65rem;
          }

          .small-note{
            font-size:.84rem;
            color:var(--muted);
          }

          .legend-grid{
            display:grid;
            grid-template-columns:repeat(5,1fr);
            gap:.75rem;
          }

          .legend-item{
            border-radius:1rem;
            padding:.8rem;
            text-align:center;
            font-weight:700;
          }

          .legend-item small{
            display:block;
            font-weight:500;
            margin-top:.2rem;
          }

          .legend-0{background:#cdeee2;color:#0b6b50;}
          .legend-1{background:#dff3ea;color:#2d7d67;}
          .legend-2{background:#fff3c7;color:#9a6a00;}
          .legend-3{background:#ffe0a8;color:#a45a00;}
          .legend-4{background:#ffd3d3;color:#b42318;}

          @media (max-width:992px){
            .score-grid{grid-template-columns:1fr;}
            .score-btn{min-height:auto;gap:.8rem;}
            .legend-grid{grid-template-columns:1fr 1fr;}
          }

          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .legend-grid{grid-template-columns:1fr;}
          }
        </style>

        <div class="flacc-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Escala FLACC</h1>
              <div class="subtle text-white-50">Selecciona una opción por cada dominio. El puntaje total y la orientación de manejo se actualizan automáticamente.</div>
            </div>
            <span class="pill bg-light text-dark">Dolor pediátrico</span>
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

        <div class="section-card">
          <div class="p-3 p-md-4">

            <div class="domain-card">
              <div class="domain-title">Expresión facial</div>
              <div class="score-grid">
                <div class="score-btn" id="cara_0" onclick="setScore('cara',0,0)">
                  <div class="score-text">Relajada, expresión neutra</div>
                  <div class="score-points">0</div>
                </div>
                <div class="score-btn" id="cara_1" onclick="setScore('cara',1,1)">
                  <div class="score-text">Mueca o fruncimiento; niño retraído</div>
                  <div class="score-points">1</div>
                </div>
                <div class="score-btn" id="cara_2" onclick="setScore('cara',2,2)">
                  <div class="score-text">Mandíbula tensa, temblor en el mentón, expresión claramente dolorosa</div>
                  <div class="score-points">2</div>
                </div>
              </div>
            </div>

            <div class="domain-card">
              <div class="domain-title">Piernas</div>
              <div class="score-grid">
                <div class="score-btn" id="piernas_0" onclick="setScore('piernas',0,0)">
                  <div class="score-text">Posición normal, relajada</div>
                  <div class="score-points">0</div>
                </div>
                <div class="score-btn" id="piernas_1" onclick="setScore('piernas',1,1)">
                  <div class="score-text">Incómodo, inquieto, tenso</div>
                  <div class="score-points">1</div>
                </div>
                <div class="score-btn" id="piernas_2" onclick="setScore('piernas',2,2)">
                  <div class="score-text">Pataleo o elevación marcada de las piernas</div>
                  <div class="score-points">2</div>
                </div>
              </div>
            </div>

            <div class="domain-card">
              <div class="domain-title">Actividad</div>
              <div class="score-grid">
                <div class="score-btn" id="actividad_0" onclick="setScore('actividad',0,0)">
                  <div class="score-text">Tranquilo, se mueve normal</div>
                  <div class="score-points">0</div>
                </div>
                <div class="score-btn" id="actividad_1" onclick="setScore('actividad',1,1)">
                  <div class="score-text">Se retuerce, se balancea, tenso</div>
                  <div class="score-points">1</div>
                </div>
                <div class="score-btn" id="actividad_2" onclick="setScore('actividad',2,2)">
                  <div class="score-text">Cuerpo arqueado, rigidez o movimientos espasmódicos</div>
                  <div class="score-points">2</div>
                </div>
              </div>
            </div>

            <div class="domain-card">
              <div class="domain-title">Llanto</div>
              <div class="score-grid">
                <div class="score-btn" id="llanto_0" onclick="setScore('llanto',0,0)">
                  <div class="score-text">No llora ni está quejoso</div>
                  <div class="score-points">0</div>
                </div>
                <div class="score-btn" id="llanto_1" onclick="setScore('llanto',1,1)">
                  <div class="score-text">Quejido o llanto ocasional; se tranquiliza con la voz o con el abrazo</div>
                  <div class="score-points">1</div>
                </div>
                <div class="score-btn" id="llanto_2" onclick="setScore('llanto',2,2)">
                  <div class="score-text">Llanto persistente, gritos o quejido continuo</div>
                  <div class="score-points">2</div>
                </div>
              </div>
            </div>

            <div class="domain-card">
              <div class="domain-title">Capacidad de consuelo</div>
              <div class="score-grid">
                <div class="score-btn" id="consuelo_0" onclick="setScore('consuelo',0,0)">
                  <div class="score-text">Tranquilo</div>
                  <div class="score-points">0</div>
                </div>
                <div class="score-btn" id="consuelo_1" onclick="setScore('consuelo',1,1)">
                  <div class="score-text">Se tranquiliza con la voz o con el abrazo</div>
                  <div class="score-points">1</div>
                </div>
                <div class="score-btn" id="consuelo_2" onclick="setScore('consuelo',2,2)">
                  <div class="score-text">Difícil de consolar o tranquilizar</div>
                  <div class="score-points">2</div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado</div>

            <div class="summary-box mb-3">
              <div class="summary-main">Puntaje total</div>
              <div class="summary-grid">
                <div>
                  <div id="scoreText" class="fw-semibold">Selecciona una opción por cada parámetro.</div>
                  <div id="severityText" class="small-note mt-2">Aún no evaluado completamente.</div>
                </div>
                <div id="totalScore" class="total-score">0</div>
              </div>
            </div>

            <div class="legend-grid mb-3">
              <div class="legend-item legend-0">0<small>Sin dolor</small></div>
              <div class="legend-item legend-1">1-2<small>Dolor leve</small></div>
              <div class="legend-item legend-2">3-5<small>Dolor moderado</small></div>
              <div class="legend-item legend-3">6-8<small>Dolor intenso</small></div>
              <div class="legend-item legend-4">9-10<small>Máximo dolor imaginable</small></div>
            </div>

            <div id="conductBox" class="conduct-box conduct-mid">
              <div id="conductTitle" class="conduct-title">Manejo sugerido</div>
              <div id="conductText">Completa los cinco dominios para obtener el puntaje total y una orientación de manejo.</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
const flaccState = {
  cara: null,
  piernas: null,
  actividad: null,
  llanto: null,
  consuelo: null
};

function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

function setScore(domain, value, idx){
  flaccState[domain] = value;

  for(let i = 0; i < 3; i++){
    const el = document.getElementById(domain + '_' + i);
    if(el) el.classList.toggle('active', i === idx);
  }

  updateFLACC();
}

function updateFLACC(){
  const values = Object.values(flaccState);
  const complete = values.every(v => v !== null);
  const total = values.reduce((acc, v) => acc + (v === null ? 0 : v), 0);

  document.getElementById('totalScore').textContent = total;

  if(!complete){
    document.getElementById('scoreText').textContent = 'Selecciona una opción por cada parámetro.';
    document.getElementById('severityText').textContent = 'Aún no evaluado completamente.';
    document.getElementById('conductBox').className = 'conduct-box conduct-mid';
    document.getElementById('conductTitle').textContent = 'Manejo sugerido';
    document.getElementById('conductText').textContent = 'Completa los cinco dominios para obtener el puntaje total y una orientación de manejo.';
    return;
  }

  document.getElementById('scoreText').innerHTML = 'FLACC total: <strong>' + total + ' / 10</strong>';

  if(total === 0){
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-ok">Sin dolor</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-ok';
    document.getElementById('conductTitle').textContent = 'Manejo sugerido';
    document.getElementById('conductText').innerHTML =
      'Sin evidencia conductual de dolor. Mantener observación, reevaluación periódica y vigilancia del contexto clínico.';
  } else if(total <= 2){
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-ok">Dolor leve</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-ok';
    document.getElementById('conductTitle').textContent = 'Manejo sugerido';
    document.getElementById('conductText').innerHTML =
      'Dolor leve. Reforzar medidas no farmacológicas, revisar confort, posición, temperatura y estímulos. Reevaluar respuesta tras intervención.';
  } else if(total <= 5){
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-mid">Dolor moderado</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-mid';
    document.getElementById('conductTitle').textContent = 'Manejo sugerido';
    document.getElementById('conductText').innerHTML =
      'Dolor moderado. Considerar analgesia farmacológica apropiada según edad, procedimiento y contexto, junto con medidas no farmacológicas. Reevaluar FLACC tras tratamiento.';
  } else if(total <= 8){
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-no">Dolor intenso</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-no';
    document.getElementById('conductTitle').textContent = 'Manejo sugerido';
    document.getElementById('conductText').innerHTML =
      'Dolor intenso. Requiere tratamiento analgésico oportuno, evaluación de causa subyacente y reevaluación precoz. Considerar estrategia multimodal.';
  } else {
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-no">Máximo dolor imaginable</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-no';
    document.getElementById('conductTitle').textContent = 'Manejo sugerido';
    document.getElementById('conductText').innerHTML =
      'Puntaje extremadamente alto. Manejo urgente del dolor, revisión clínica inmediata, confirmación de causa y monitorización estrecha de la respuesta al tratamiento.';
  }
}
</script>

<?php
require("footer.php");
?>
