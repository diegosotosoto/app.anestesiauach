<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "La estimación de función renal ayuda a ajustar dosis de fármacos, anticipar acumulación de metabolitos, evaluar riesgo perioperatorio y orientar vigilancia de volemia, electrolitos y equilibrio ácido-base. Este módulo incluye Cockcroft-Gault y MDRD en pestañas separadas.";
$formula = "Cockcroft-Gault: CrCl = ((140 - edad) x peso) / (72 x creatinina), x0.85 si mujer. MDRD abreviada (IDMS): eGFR = 175 x Cr^-1.154 x edad^-0.203 x 0.742 si mujer.";
$referencias = array(
  "1.- Cockcroft DW, Gault MH. Prediction of creatinine clearance from serum creatinine. Nephron. 1976;16(1):31-41.",
  "2.- Levey AS, Coresh J, Greene T, et al. Expressing the MDRD Study equation for estimating GFR with standardized serum creatinine values. Clin Chem. 2007;53(4):766-772.",
  "3.- National Kidney Foundation. Cockcroft-Gault Formula.",
  "4.- National Kidney Foundation. Standardized Assays for Calculating GFR in Adults.",
  "5.- National Kidney Foundation. eGFR / CKD-EPI resources."
);

$icono_apunte = "<i class='fa-solid fa-filter pe-3 pt-2'></i>";
$titulo_apunte = "Velocidad de Filtración Glomerular";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="vfg-shell">

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
          .vfg-shell{max-width:980px;margin:0 auto;}

          .vfg-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;margin-bottom:1rem;overflow:hidden;
          }
          .vfg-topbar h1{color:#fff;}

          .section-card{
            border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;overflow:hidden;margin-bottom:1rem;
          }
          .section-title{
            font-size:.8rem;letter-spacing:.05em;text-transform:uppercase;color:var(--muted);
          }
          .pill{
            display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.78rem;
            background:#eef3ff;color:#3559b7;font-weight:600;
          }
          .subtle{font-size:.94rem;color:#5f6b76;}

          .info-box{
            background:#fff;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            margin-bottom:1rem;overflow:hidden;
          }
          .info-box-header{
            display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:1rem;
          }
          .info-box-title{
            font-size:.8rem;text-transform:uppercase;color:#667085;letter-spacing:.08em;
          }
          .info-toggle-btn{
            border-radius:.6rem;font-size:.85rem;padding:.35rem .7rem;white-space:nowrap;
            background:#6c757d;border:none;color:white;transition:.2s;
          }
          .info-toggle-btn:hover{background:#5a6268;color:white;}
          .info-box-content{
            padding:1rem;display:none;animation:fadeIn .2s ease-in-out;border-top:1px solid #e9eef5;
          }
          @keyframes fadeIn{
            from{opacity:0; transform:translateY(-5px);}
            to{opacity:1; transform:translateY(0);}
          }

          .tabs-wrap{
            display:flex;gap:.75rem;flex-wrap:wrap;
          }
          .tab-btn{
            border:1px solid #d7dde6;background:#fff;color:#3559b7;border-radius:999px;
            padding:.6rem 1rem;font-weight:700;cursor:pointer;transition:.15s ease;
          }
          .tab-btn.active{
            background:#3559b7;color:#fff;border-color:#3559b7;
          }

          .tab-panel{display:none;}
          .tab-panel.active{display:block;}

          .calc-grid{
            display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;
          }
          .card-block{
            border:1px solid var(--line);border-radius:1rem;background:var(--soft);padding:1rem;
          }
          .form-label-lite{
            font-size:.92rem;font-weight:600;color:var(--text);margin-bottom:.35rem;
          }

          .sex-choice-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.75rem;
          }
          .sex-check{
            display:none;
          }
          .sex-card{
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            min-height:92px;
            text-align:center;
            padding:1rem;
            border:1px solid var(--line);
            border-radius:1rem;
            background:#fff;
            cursor:pointer;
            transition:.15s ease;
            margin:0;
          }
          .sex-title{
            font-weight:800;
            color:#1f2a37;
            font-size:1rem;
            line-height:1.15;
          }
          .sex-sub{
            margin-top:.35rem;
            font-size:.82rem;
            color:#667085;
            line-height:1.25;
          }
          .sex-check:checked + .sex-card{
            background:#edf4ff;
            border-color:#3559b7;
            box-shadow:0 0 0 2px rgba(53,89,183,.08) inset;
          }
          .sex-check:checked + .sex-card .sex-title{
            color:#3559b7;
          }

          .result-box{
            border-radius:1rem;border:1px solid var(--line);background:var(--soft);padding:1rem;
          }
          .result-main{
            font-size:1.08rem;font-weight:700;color:var(--text);
          }
          .result-num{
            font-size:2rem;font-weight:800;line-height:1;color:#3559b7;
          }

          .conduct-box{
            padding:1rem;border-radius:1rem;border:1px solid var(--line);
          }
          .conduct-ok{background:var(--good);}
          .conduct-mid{background:var(--warn);}
          .conduct-no{background:var(--danger);}
          .conduct-title{
            font-size:1.08rem;font-weight:800;color:#1f2a37;margin-bottom:.65rem;
          }

          .teaching-wrap{
            border:1px solid var(--line);
            border-radius:1.4rem;
            background:var(--soft);
            padding:1.25rem;
            overflow:hidden;
          }
          .teaching-title{
            font-size:1rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#64748b;
            text-align:center;
            margin-bottom:1rem;
          }
          .teaching-main{
            font-size:1.8rem;
            font-weight:800;
            text-align:center;
            color:#1f2a37;
            line-height:1.15;
            margin-bottom:1.2rem;
            max-width:100%;
            overflow-wrap:anywhere;
          }
          .teaching-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }
          .teaching-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1.25rem;
            padding:1.1rem 1rem;
            text-align:center;
            max-width:100%;
            overflow:hidden;
          }
          .teaching-label{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#667085;
            margin-bottom:.55rem;
          }
          .teaching-text{
            font-size:1rem;
            line-height:1.45;
            color:#1f2a37;
            font-weight:600;
            max-width:100%;
            overflow-wrap:anywhere;
          }
          .teaching-soft{
            font-size:.95rem;
            line-height:1.5;
            color:#667085;
            font-weight:500;
            margin-top:.35rem;
            max-width:100%;
            overflow-wrap:anywhere;
            word-break:normal;
          }

          .small-note{font-size:.84rem;color:var(--muted);}
          .footer-note{font-size:.82rem;color:#6c757d;}

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
          }
          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .result-num{font-size:1.8rem;}
            .teaching-main{font-size:1.45rem;}
            .sex-choice-grid{grid-template-columns:1fr;}
          }
        </style>

        <div class="vfg-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Velocidad de Filtración Glomerular</h1>
              <div class="subtle text-white-50">Cálculo automático con Cockcroft-Gault y MDRD, con perlas docentes orientadas a anestesia.</div>
            </div>
            <span class="pill bg-light text-dark">Función renal</span>
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
              <b>Fórmulas:</b><br>
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
            <div class="section-title mb-3">Método de cálculo</div>
            <div class="tabs-wrap">
              <button class="tab-btn active" type="button" data-tab="cg">Cockcroft-Gault</button>
              <button class="tab-btn" type="button" data-tab="mdrd">MDRD</button>
            </div>
          </div>
        </div>

        <div id="panel-cg" class="tab-panel active">
          <div class="section-card">
            <div class="p-3 p-md-4">
              <div class="section-title mb-3">Cockcroft-Gault</div>

              <div class="calc-grid">
                <div class="card-block">
                  <label class="form-label-lite">Edad</label>
                  <div class="input-group mb-3">
                    <input class="form-control calc-cg" type="number" id="cg_edad" value="">
                    <span class="input-group-text">años</span>
                  </div>

                  <label class="form-label-lite">Peso</label>
                  <div class="input-group mb-3">
                    <input class="form-control calc-cg" type="number" id="cg_peso" value="">
                    <span class="input-group-text">kg</span>
                  </div>

                  <label class="form-label-lite">Creatinina</label>
                  <div class="input-group">
                    <input class="form-control calc-cg" type="number" step="0.01" id="cg_crea" value="">
                    <span class="input-group-text">mg/dL</span>
                  </div>
                </div>

                <div class="card-block">
                  <label class="form-label-lite">Sexo</label>
                  <div class="sex-choice-grid">
                    <input class="sex-check calc-cg" type="radio" name="cg_sexo" id="cg_hombre" value="hombre" checked>
                    <label class="sex-card" for="cg_hombre">
                      <span class="sex-title">Hombre</span>
                      <span class="sex-sub">x 1.0</span>
                    </label>

                    <input class="sex-check calc-cg" type="radio" name="cg_sexo" id="cg_mujer" value="mujer">
                    <label class="sex-card" for="cg_mujer">
                      <span class="sex-title">Mujer</span>
                      <span class="sex-sub">x 0.85</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="result-box mt-3">
                <div class="d-flex justify-content-between align-items-center gap-3">
                  <div>
                    <div class="small-note">Clearance estimado</div>
                    <div id="cg_text" class="result-main">Ingresa los datos.</div>
                  </div>
                  <div id="cg_num" class="result-num">0</div>
                </div>
              </div>

              <div id="cg_conduct" class="conduct-box conduct-mid mt-3">
                <div class="conduct-title">Interpretación</div>
                <div id="cg_conduct_text">Completa los campos para estimar clearance por Cockcroft-Gault.</div>
              </div>
            </div>
          </div>
        </div>

        <div id="panel-mdrd" class="tab-panel">
          <div class="section-card">
            <div class="p-3 p-md-4">
              <div class="section-title mb-3">MDRD</div>

              <div class="calc-grid">
                <div class="card-block">
                  <label class="form-label-lite">Edad</label>
                  <div class="input-group mb-3">
                    <input class="form-control calc-mdrd" type="number" id="mdrd_edad" value="">
                    <span class="input-group-text">años</span>
                  </div>

                  <label class="form-label-lite">Creatinina</label>
                  <div class="input-group">
                    <input class="form-control calc-mdrd" type="number" step="0.01" id="mdrd_crea" value="">
                    <span class="input-group-text">mg/dL</span>
                  </div>
                </div>

                <div class="card-block">
                  <label class="form-label-lite">Sexo</label>

                  <div class="sex-choice-grid mb-3">
                    <input class="sex-check calc-mdrd" type="radio" name="mdrd_sexo" id="mdrd_hombre" value="hombre" checked>
                    <label class="sex-card" for="mdrd_hombre">
                      <span class="sex-title">Hombre</span>
                      <span class="sex-sub">x 1.0</span>
                    </label>

                    <input class="sex-check calc-mdrd" type="radio" name="mdrd_sexo" id="mdrd_mujer" value="mujer">
                    <label class="sex-card" for="mdrd_mujer">
                      <span class="sex-title">Mujer</span>
                      <span class="sex-sub">x 0.742</span>
                    </label>
                  </div>

                  <div class="small-note">Resultado expresado como mL/min/1.73 m².</div>
                </div>
              </div>

              <div class="result-box mt-3">
                <div class="d-flex justify-content-between align-items-center gap-3">
                  <div>
                    <div class="small-note">eGFR estimada</div>
                    <div id="mdrd_text" class="result-main">Ingresa los datos.</div>
                  </div>
                  <div id="mdrd_num" class="result-num">0</div>
                </div>
              </div>

              <div id="mdrd_conduct" class="conduct-box conduct-mid mt-3">
                <div class="conduct-title">Interpretación</div>
                <div id="mdrd_conduct_text">Completa los campos para estimar VFG por MDRD.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Perlas docentes en anestesia</div>
              <div class="teaching-main">La creatinina aislada puede subestimar el problema renal, especialmente en adultos mayores</div>

              <div class="teaching-grid">
                <div class="teaching-card">
                  <div class="teaching-label">Adulto mayor</div>
                  <div class="teaching-text">Una creatinina “normal” no excluye insuficiencia renal</div>
                  <div class="teaching-soft">La menor masa muscular reduce la producción de creatinina. Por eso, un valor aparentemente normal puede coexistir con VFG significativamente disminuida.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Revisión preoperatoria</div>
                  <div class="teaching-text">No mirar solo el número</div>
                  <div class="teaching-soft">Revisa tendencia de creatinina, diuresis, potasio, bicarbonato, signos de sobrecarga o depleción de volumen, nefrotóxicos y contexto clínico completo. Esto es especialmente importante si sospechas lesión renal aguda perioperatoria.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Fármacos</div>
                  <div class="teaching-text">Ajusta dosis y evita acumulación</div>
                  <div class="teaching-soft">Opioides, antibióticos, relajantes neuromusculares y varios coadyuvantes pueden requerir ajuste o vigilancia especial cuando la función renal cae. La estimación de VFG ayuda a anticipar toxicidad y prolongación de efectos.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Ecuación</div>
                  <div class="teaching-text">Cockcroft y MDRD no significan exactamente lo mismo</div>
                  <div class="teaching-soft">Cockcroft-Gault estima clearance de creatinina en mL/min y usa peso. MDRD entrega eGFR ajustada a 1.73 m². Ambas orientan, pero no sustituyen la valoración clínica integral.</div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Perla clínica</div>
                  <div class="teaching-text">Si el caso “huele a renal”, compórtate como si fuera renal hasta demostrar lo contrario</div>
                  <div class="teaching-soft">Verifica volemia, electrolitos, ácido-base, nefrotóxicos, contraste reciente, insuficiencia cardíaca, sepsis, rabdomiólisis y riesgo de obstrucción. En pabellón, la visión global vale más que un valor aislado.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Las ecuaciones estiman función renal, pero no reemplazan juicio clínico, evolución temporal ni necesidad de evaluación nefrológica o laboratorial adicional.
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

function activateTab(tab){
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelector('[data-tab="' + tab + '"]').classList.add('active');
  document.getElementById('panel-' + tab).classList.add('active');
}

function classifyGFR(gfr){
  if(isNaN(gfr) || gfr <= 0) return null;
  if(gfr >= 90) return ['Función renal conservada o discretamente alterada', 'conduct-ok'];
  if(gfr >= 60) return ['Disminución leve-moderada', 'conduct-ok'];
  if(gfr >= 30) return ['Disminución moderada-importante', 'conduct-mid'];
  if(gfr >= 15) return ['Disminución severa', 'conduct-no'];
  return ['Falla renal avanzada o rango terminal', 'conduct-no'];
}

function calcCG(){
  const edad = parseFloat(document.getElementById('cg_edad').value);
  const peso = parseFloat(document.getElementById('cg_peso').value);
  const crea = parseFloat(document.getElementById('cg_crea').value);
  const mujer = document.getElementById('cg_mujer').checked;

  if([edad,peso,crea].some(v => isNaN(v) || v <= 0)){
    document.getElementById('cg_num').textContent = '0';
    document.getElementById('cg_text').textContent = 'Ingresa los datos.';
    document.getElementById('cg_conduct').className = 'conduct-box conduct-mid mt-3';
    document.getElementById('cg_conduct_text').textContent = 'Completa los campos para estimar clearance por Cockcroft-Gault.';
    return;
  }

  let cg = (((140 - edad) * peso) / (72 * crea));
  if(mujer) cg *= 0.85;

  document.getElementById('cg_num').textContent = cg.toFixed(1);
  document.getElementById('cg_text').textContent = 'Clearance estimado: ' + cg.toFixed(1) + ' mL/min';

  const klass = classifyGFR(cg);
  document.getElementById('cg_conduct').className = 'conduct-box ' + klass[1] + ' mt-3';
  document.getElementById('cg_conduct_text').innerHTML =
    klass[0] + '. Revisa ajuste de dosis de fármacos, potasio, equilibrio ácido-base, diuresis y tendencia de creatinina. Integra siempre el contexto clínico completo.';
}

function calcMDRD(){
  const edad = parseFloat(document.getElementById('mdrd_edad').value);
  const crea = parseFloat(document.getElementById('mdrd_crea').value);
  const mujer = document.getElementById('mdrd_mujer').checked;

  if([edad,crea].some(v => isNaN(v) || v <= 0)){
    document.getElementById('mdrd_num').textContent = '0';
    document.getElementById('mdrd_text').textContent = 'Ingresa los datos.';
    document.getElementById('mdrd_conduct').className = 'conduct-box conduct-mid mt-3';
    document.getElementById('mdrd_conduct_text').textContent = 'Completa los campos para estimar VFG por MDRD.';
    return;
  }

  let mdrd = 175 * Math.pow(crea, -1.154) * Math.pow(edad, -0.203);
  if(mujer) mdrd *= 0.742;

  document.getElementById('mdrd_num').textContent = mdrd.toFixed(1);
  document.getElementById('mdrd_text').textContent = 'eGFR estimada: ' + mdrd.toFixed(1) + ' mL/min/1.73 m²';

  const klass = classifyGFR(mdrd);
  document.getElementById('mdrd_conduct').className = 'conduct-box ' + klass[1] + ' mt-3';
  document.getElementById('mdrd_conduct_text').innerHTML =
    klass[0] + '. Útil como estimación global; recuerda que el laboratorio y la tendencia clínica suelen aportar más que un valor aislado.';
}

document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function(){
      activateTab(this.dataset.tab);
    });
  });

  document.querySelectorAll('.calc-cg').forEach(el => {
    el.addEventListener('input', calcCG);
    el.addEventListener('change', calcCG);
  });

  document.querySelectorAll('.calc-mdrd').forEach(el => {
    el.addEventListener('input', calcMDRD);
    el.addEventListener('change', calcMDRD);
  });

  calcCG();
  calcMDRD();
});
</script>

<?php
require("footer.php");
?>
