<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "La escala de Aldrete modificada permite evaluar la recuperación postanestésica inmediata y orientar la decisión de traslado desde recuperación.";
$formula = "Aldrete modificado = conciencia + actividad física + estabilidad hemodinámica + estabilidad respiratoria + saturación de oxígeno + dolor posoperatorio + síntomas eméticos posoperatorios";
$referencias = array(
  "1.- Aldrete JA, Kroulik D. A postanesthetic recovery score. Anesth Analg. 1970;49(6):924-934. doi: 10.1213/00000539-197011000-00010. PMID: 5484089.",
  "2.- Aldrete JA. The post anaesthesia recovery score revisited. J Clin Anesth. 1995;7:89-91.",
  "3.- McGrath B, Chung F. Postoperative recovery and discharge. Anesthesiology Clin N Am. 2003;21:367-86."
);

$icono_apunte = "<i class='fa-solid fa-bed-pulse pe-3 pt-2'></i>";
$titulo_apunte = "Score de Aldrete Modificado";

$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Apuntes</span>";
$boton_navbar="<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";

require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="aldrete-shell">

        <style>
          .aldrete-shell{max-width:1100px;margin:0 auto;}
          .aldrete-topbar{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;margin-bottom:1rem;
          }
          .aldrete-topbar h1{color:#fff;}
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
          .refs-card{display:none;}
          .refs-card ul{color:#667085;line-height:1.55;padding-left:1.1rem;margin-bottom:0;}

          .domain-card{
            background:#fff;border:1px solid #e6e9ef;border-radius:1rem;padding:1rem;margin-bottom:1rem;
          }
          .domain-title{
            font-size:1rem;font-weight:800;color:#1f2a37;margin-bottom:.85rem;
          }
          .score-grid{
            display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;
          }
          .score-btn{
            min-height:132px;
            border:1px solid #dfe7f2;border-radius:1rem;background:#f8fafc;
            padding:.9rem .8rem;cursor:pointer;transition:.15s ease;user-select:none;
            display:flex;flex-direction:column;justify-content:space-between;
          }
          .score-btn.active{
            background:#edf4ff;border-color:#bfd2ff;box-shadow:0 0 0 2px rgba(53,89,183,.08) inset;
          }
          .score-btn.zero.active{
            background:#fff5f3;border-color:#f3c2bd;box-shadow:0 0 0 2px rgba(220,53,69,.08) inset;
          }
          .score-text{
            font-size:.92rem;line-height:1.25;color:#1f2a37;
          }
          .score-points{
            font-size:1.4rem;font-weight:800;color:#3559b7;text-align:right;line-height:1;
          }
          .score-btn.zero .score-points{
            color:#dc3545;
          }

          .summary-box{
            padding:1rem;border-radius:1rem;border:1px solid #dfe7f2;background:#f8fafc;
          }
          .summary-main{
            font-size:1.12rem;font-weight:800;color:#1f2a37;margin-bottom:.85rem;
          }
          .summary-grid{
            display:grid;grid-template-columns:1fr auto;gap:1rem;align-items:center;
          }
          .total-score{
            font-size:2.2rem;font-weight:900;color:#3559b7;line-height:1;
          }
          .badge-soft{
            display:inline-block;padding:.3rem .65rem;border-radius:999px;font-size:.78rem;font-weight:700;
          }
          .badge-ok{background:#edf8f7;color:#1e7a5a;}
          .badge-no{background:#fff5f3;color:#b42318;}

          .conduct-box{
            padding:1rem;border-radius:1rem;border:1px solid #dfe7f2;
          }
          .conduct-ok{background:#edf8f7;}
          .conduct-no{background:#fff9e8;}
          .conduct-alert{background:#fff5f3;}
          .conduct-title{
            font-size:1.08rem;font-weight:800;color:#1f2a37;margin-bottom:.65rem;
          }

          .small-note{font-size:.84rem;color:#667085;}

          @media (max-width:992px){
            .score-grid{grid-template-columns:1fr;}
            .score-btn{min-height:auto;gap:.8rem;}
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
        <div class="aldrete-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo interactivo</div>
              <h1 class="h3 mb-2">Score de Aldrete Modificado</h1>
              <div class="subtle text-white-50">Selecciona una opción por dominio. El cálculo y la conducta se actualizan automáticamente.</div>
            </div>
            <span class="pill bg-light text-dark">URPA</span>
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

        <?php
          $domains = array(
            "conciencia" => array(
              "title" => "Nivel de conciencia",
              "options" => array(
                array("Consciente y orientado", 2),
                array("Alertable con mínima estimulación", 1),
                array("Alertable únicamente con estimulación táctil", 0)
              )
            ),
            "actividad" => array(
              "title" => "Actividad física",
              "options" => array(
                array("Capacidad para movilizar todas las extremidades", 2),
                array("Cierta debilidad en el movimiento de las extremidades", 1),
                array("Incapaz de mover voluntariamente las extremidades", 0)
              )
            ),
            "hemodinamica" => array(
              "title" => "Estabilidad hemodinámica",
              "options" => array(
                array("Presión arterial ±15% de la presión arterial media inicial", 2),
                array("Presión arterial ±15–30% de la presión arterial media inicial", 1),
                array("Presión arterial ±30% de la presión arterial media inicial", 0)
              )
            ),
            "respiratoria" => array(
              "title" => "Estabilidad respiratoria",
              "options" => array(
                array("Capacidad de respirar profundo", 2),
                array("Taquipnea con buena tos", 1),
                array("Disnea con tos débil", 0)
              )
            ),
            "saturacion" => array(
              "title" => "Saturación de oxígeno",
              "options" => array(
                array("Mantiene un valor mayor a 90% con aire ambiente", 2),
                array("Requiere oxígeno suplementario", 1),
                array("Saturación menor de 90% con oxígeno suplementario", 0)
              )
            ),
            "dolor" => array(
              "title" => "Dolor posoperatorio",
              "options" => array(
                array("Ninguno o mínimo dolor", 2),
                array("Dolor moderado a severo controlado con analgésicos endovenosos", 1),
                array("Dolor severo persistente", 0)
              )
            ),
            "emeticos" => array(
              "title" => "Síntomas eméticos posoperatorios",
              "options" => array(
                array("Ninguno o náuseas leves sin vómito", 2),
                array("Vómito transitorio o arcada", 1),
                array("Náuseas y vómitos persistentes moderado a severo", 0)
              )
            )
          );

          foreach($domains as $key => $domain){
        ?>
          <div class="section-card">
            <div class="p-3 p-md-4">
              <div class="domain-title"><?php echo $domain["title"]; ?></div>
              <div class="score-grid">
                <?php foreach($domain["options"] as $idx => $option){ ?>
                  <div class="score-btn <?php echo ($option[1] == 0 ? 'zero' : ''); ?>" id="<?php echo $key; ?>_<?php echo $idx; ?>" onclick="setScore('<?php echo $key; ?>', <?php echo $option[1]; ?>, <?php echo $idx; ?>)">
                    <div class="score-text"><?php echo $option[0]; ?></div>
                    <div class="score-points"><?php echo $option[1]; ?></div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado</div>

            <div class="summary-box mb-3">
              <div class="summary-main">Puntaje total</div>
              <div class="summary-grid">
                <div>
                  <div id="scoreText" class="fw-semibold">Selecciona una opción por cada ítem.</div>
                  <div id="zeroText" class="small-note mt-2">Aún no evaluado completamente.</div>
                </div>
                <div id="totalScore" class="total-score">0</div>
              </div>
            </div>

            <div id="conductBox" class="conduct-box conduct-no">
              <div id="conductTitle" class="conduct-title">Conducta</div>
              <div id="conductText">Completa todos los ítems para emitir una recomendación.</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
const aldreteState = {
  conciencia: null,
  actividad: null,
  hemodinamica: null,
  respiratoria: null,
  saturacion: null,
  dolor: null,
  emeticos: null
};

function toggleReferencias(e){
  if(e) e.preventDefault();
  const box = document.getElementById('referenciasBox');
  box.style.display = (box.style.display === 'block') ? 'none' : 'block';
}

function setScore(domain, value, idx){
  aldreteState[domain] = value;

  for(let i = 0; i < 3; i++){
    const el = document.getElementById(domain + '_' + i);
    if(el) el.classList.toggle('active', i === idx);
  }

  updateAldrete();
}

function updateAldrete(){
  const values = Object.values(aldreteState);
  const complete = values.every(v => v !== null);
  const total = values.reduce((acc, v) => acc + (v === null ? 0 : v), 0);
  const hasZero = values.some(v => v === 0);

  document.getElementById('totalScore').textContent = total;

  if(!complete){
    document.getElementById('scoreText').textContent = 'Selecciona una opción por cada ítem.';
    document.getElementById('zeroText').textContent = 'Aún no evaluado completamente.';
    document.getElementById('conductBox').className = 'conduct-box conduct-no';
    document.getElementById('conductTitle').textContent = 'Conducta';
    document.getElementById('conductText').textContent = 'Completa todos los dominios antes de tomar decisión de traslado.';
    return;
  }

  document.getElementById('scoreText').innerHTML = 'Aldrete total: <strong>' + total + ' / 14</strong>';

  if(hasZero){
    document.getElementById('zeroText').innerHTML = '<span class="badge-soft badge-no">Existe al menos un ítem con 0 puntos</span>';
  } else {
    document.getElementById('zeroText').innerHTML = '<span class="badge-soft badge-ok">No hay ítems con 0 puntos</span>';
  }

  if(total >= 12 && !hasZero){
    document.getElementById('conductBox').className = 'conduct-box conduct-ok';
    document.getElementById('conductTitle').textContent = 'Conducta sugerida';
    document.getElementById('conductText').innerHTML = 'Cumple criterio de <strong>traslado desde recuperación</strong>: Aldrete ≥ 12 y ningún ítem en 0 puntos.';
    return;
  }

  if(total >= 12 && hasZero){
    document.getElementById('conductBox').className = 'conduct-box conduct-alert';
    document.getElementById('conductTitle').textContent = 'Conducta sugerida';
    document.getElementById('conductText').innerHTML = 'Aunque el puntaje total es ≥ 12, <strong>NO cumple criterio de traslado</strong> porque existe al menos un ítem en 0 puntos.';
    return;
  }

  document.getElementById('conductBox').className = 'conduct-box conduct-no';
  document.getElementById('conductTitle').textContent = 'Conducta sugerida';
  document.getElementById('conductText').innerHTML = 'Mantener en recuperación, reevaluar y tratar los déficits detectados. Requiere <strong>Aldrete ≥ 12</strong> y <strong>ningún ítem en 0</strong> para traslado.';
}
</script>
<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>
<?php require("footer.php"); ?>