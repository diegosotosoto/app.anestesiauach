<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "La escala de Glasgow evalúa el nivel de conciencia mediante tres dominios: respuesta ocular, verbal y motora. Su suma total va de 3 a 15 puntos y ayuda a describir gravedad neurológica, orientar vigilancia y anticipar implicancias anestésicas.";
$formula = "Glasgow = ocular (1–4) + verbal (1–5) + motora (1–6)";
$referencias = array(
  "1.- Teasdale G, Jennett B. Assessment of coma and impaired consciousness. A practical scale. Lancet. 1974;2(7872):81-84.",
  "2.- Rowley G, Fielding K. Reliability and accuracy of the Glasgow Coma scale with experienced and inexperienced users. Lancet. 1991;337(8740):535-538.",
  "3.- Reith FC, Van den Brande R, Synnot A, Gruen R, Maas AI. The reliability of the Glasgow Coma Scale: a systematic review. Intensive Care Med. 2016;42(1):3-15."
);

$icono_apunte = "<i class='fa-solid fa-brain pe-3 pt-2'></i>";
$titulo_apunte = "Escala de Glasgow";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="glasgow-shell">

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

          .glasgow-shell{max-width:1100px;margin:0 auto;}

          .glasgow-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .glasgow-topbar h1{color:#fff;}

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

          .score-grid.grid-4{grid-template-columns:repeat(4,1fr);}
          .score-grid.grid-5{grid-template-columns:repeat(5,1fr);}
          .score-grid.grid-6{grid-template-columns:repeat(3,1fr);}

          .score-btn{
            min-height:132px;
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
          .conduct-no{background:var(--danger);}
          .conduct-mid{background:var(--warn);}

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

          @media (max-width:992px){
            .score-grid,.score-grid.grid-4,.score-grid.grid-5,.score-grid.grid-6{
              grid-template-columns:1fr;
            }
            .score-btn{min-height:auto;gap:.8rem;}
          }

          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="glasgow-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Escala de Glasgow</h1>
              <div class="subtle text-white-50">Selecciona una opción por dominio. El puntaje total y la orientación anestésica se actualizan automáticamente.</div>
            </div>
            <span class="pill bg-light text-dark">Neurológico</span>
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
              <div class="domain-title">Respuesta ocular</div>
              <div class="score-grid grid-4">
                <div class="score-btn" id="ocular_0" onclick="setScore('ocular',4,0)">
                  <div class="score-text">Espontánea</div>
                  <div class="score-points">4</div>
                </div>
                <div class="score-btn" id="ocular_1" onclick="setScore('ocular',3,1)">
                  <div class="score-text">A la voz / orden verbal</div>
                  <div class="score-points">3</div>
                </div>
                <div class="score-btn" id="ocular_2" onclick="setScore('ocular',2,2)">
                  <div class="score-text">Al dolor</div>
                  <div class="score-points">2</div>
                </div>
                <div class="score-btn" id="ocular_3" onclick="setScore('ocular',1,3)">
                  <div class="score-text">No responde</div>
                  <div class="score-points">1</div>
                </div>
              </div>
            </div>

            <div class="domain-card">
              <div class="domain-title">Respuesta verbal</div>
              <div class="score-grid grid-5">
                <div class="score-btn" id="verbal_0" onclick="setScore('verbal',5,0)">
                  <div class="score-text">Orientado, conversa</div>
                  <div class="score-points">5</div>
                </div>
                <div class="score-btn" id="verbal_1" onclick="setScore('verbal',4,1)">
                  <div class="score-text">Desorientado</div>
                  <div class="score-points">4</div>
                </div>
                <div class="score-btn" id="verbal_2" onclick="setScore('verbal',3,2)">
                  <div class="score-text">Palabras inapropiadas</div>
                  <div class="score-points">3</div>
                </div>
                <div class="score-btn" id="verbal_3" onclick="setScore('verbal',2,3)">
                  <div class="score-text">Sonidos incomprensibles</div>
                  <div class="score-points">2</div>
                </div>
                <div class="score-btn" id="verbal_4" onclick="setScore('verbal',1,4)">
                  <div class="score-text">Sin respuesta</div>
                  <div class="score-points">1</div>
                </div>
              </div>
            </div>

            <div class="domain-card">
              <div class="domain-title">Respuesta motora</div>
              <div class="score-grid grid-6">
                <div class="score-btn" id="motora_0" onclick="setScore('motora',6,0)">
                  <div class="score-text">Obedece órdenes</div>
                  <div class="score-points">6</div>
                </div>
                <div class="score-btn" id="motora_1" onclick="setScore('motora',5,1)">
                  <div class="score-text">Localiza el dolor</div>
                  <div class="score-points">5</div>
                </div>
                <div class="score-btn" id="motora_2" onclick="setScore('motora',4,2)">
                  <div class="score-text">Retira al dolor</div>
                  <div class="score-points">4</div>
                </div>
                <div class="score-btn" id="motora_3" onclick="setScore('motora',3,3)">
                  <div class="score-text">Flexión anormal</div>
                  <div class="score-points">3</div>
                </div>
                <div class="score-btn" id="motora_4" onclick="setScore('motora',2,4)">
                  <div class="score-text">Extensión</div>
                  <div class="score-points">2</div>
                </div>
                <div class="score-btn" id="motora_5" onclick="setScore('motora',1,5)">
                  <div class="score-text">Sin respuesta</div>
                  <div class="score-points">1</div>
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
                  <div id="scoreText" class="fw-semibold">Selecciona una opción por cada dominio.</div>
                  <div id="severityText" class="small-note mt-2">Aún no evaluado completamente.</div>
                </div>
                <div id="totalScore" class="total-score">0</div>
              </div>
            </div>

            <div id="conductBox" class="conduct-box conduct-mid">
              <div id="conductTitle" class="conduct-title">Manejo anestésico sugerido</div>
              <div id="conductText">Completa ocular, verbal y motora para emitir una orientación.</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
const glasgowState = {
  ocular: null,
  verbal: null,
  motora: null
};

function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}

function setScore(domain, value, idx){
  glasgowState[domain] = value;

  const maxIdx = {ocular:4, verbal:5, motora:6}[domain];
  for(let i = 0; i < maxIdx; i++){
    const el = document.getElementById(domain + '_' + i);
    if(el) el.classList.toggle('active', i === idx);
  }

  updateGlasgow();
}

function updateGlasgow(){
  const values = Object.values(glasgowState);
  const complete = values.every(v => v !== null);
  const total = values.reduce((acc, v) => acc + (v === null ? 0 : v), 0);

  document.getElementById('totalScore').textContent = total;

  if(!complete){
    document.getElementById('scoreText').textContent = 'Selecciona una opción por cada dominio.';
    document.getElementById('severityText').textContent = 'Aún no evaluado completamente.';
    document.getElementById('conductBox').className = 'conduct-box conduct-mid';
    document.getElementById('conductTitle').textContent = 'Manejo anestésico sugerido';
    document.getElementById('conductText').textContent = 'Completa ocular, verbal y motora para emitir una orientación.';
    return;
  }

  document.getElementById('scoreText').innerHTML = 'Glasgow total: <strong>' + total + ' / 15</strong>';

  if(total >= 13){
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-ok">TEC leve / alteración leve del sensorio</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-ok';
    document.getElementById('conductTitle').textContent = 'Manejo anestésico sugerido';
    document.getElementById('conductText').innerHTML =
      'Paciente con compromiso neurológico leve. Mantener reevaluación frecuente, documentar tendencia, evitar sedación innecesaria antes de completar valoración neurológica y planificar anestesia según contexto clínico. Si requiere anestesia, cuidar hemodinamia, oxigenación y normocapnia.';
  } else if(total >= 9){
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-mid">TEC moderado / compromiso neurológico intermedio</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-mid';
    document.getElementById('conductTitle').textContent = 'Manejo anestésico sugerido';
    document.getElementById('conductText').innerHTML =
      'Paciente con compromiso neurológico moderado. Alta vigilancia de vía aérea y ventilación. Considerar monitorización más estrecha, evitar hipotensión, hipoxemia e hipercapnia. Si requiere procedimiento, anticipar posible deterioro neurológico y baja reserva fisiológica.';
  } else {
    document.getElementById('severityText').innerHTML = '<span class="badge-soft badge-no">TEC grave / Glasgow 3–8</span>';
    document.getElementById('conductBox').className = 'conduct-box conduct-no';
    document.getElementById('conductTitle').textContent = 'Manejo anestésico sugerido';
    document.getElementById('conductText').innerHTML =
      'Glasgow 3–8 implica compromiso neurológico grave y, en contexto apropiado, debe asumirse alto riesgo de pérdida de reflejos protectores de vía aérea. Considerar manejo avanzado de vía aérea, estrategia de neuroprotección, control estricto de oxigenación, ventilación y presión arterial, y coordinación con equipo crítico/neuroquirúrgico según el caso.';
  }
}
</script>

<?php
require("footer.php");
?>
