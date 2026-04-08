<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Las fórmulas proporcionadas se utilizan para calcular la dosis de bupivacaína para una carga intraoperatoria de analgesia epidural, calculada en ml para una solución de Levobupivacaína al 0,25%. Además se proporciona una fórmula para la mantención de analgesia epidural pediátrica postoperatoria, calculada para una infusión de Bupivacaína 0,1%. Cada fórmula considera el peso y el rango etáreo del paciente. No olvide adaptar las dosis a las necesidades particulares y factores de riesgo de cada niño, para garantizar una administración precisa y segura, minimizando riesgo de intoxicación sistémica por anestésicos locales.";
$formula = "";
$referencias = array(
  "1.- Suresh S, Ecoffey C, Bosenberg A, Lonnqvist PA, de Oliveira GS Jr, de Leon Casasola O, de Andrés J, Ivani G. The European Society of Regional Anaesthesia and Pain Therapy/American Society of Regional Anesthesia and Pain Medicine Recommendations on Local Anesthetics and Adjuvants Dosage in Pediatric Regional Anesthesia. Reg Anesth Pain Med. 2018 Feb;43(2):211-216.",
  "2.- Suresh S, Lonnqvist P-A. Regional Anesthesia in Children. En Miller's Anesthesia, 9th Edition.",
  "3.- Tabla de dosificación de Analgesia Epidural Pediátrica, PUC."
);

$icono_apunte = "<i class='fa-solid fa-baby pe-3 pt-2'></i>";
$titulo_apunte = "Peridural Pediátrica";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="peri-shell">

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
          }

          body{background:var(--bg);}

          .peri-shell{
            max-width:980px;
            margin:0 auto;
          }

          .peri-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .peri-topbar h1{color:#fff;}

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

          .result-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:1rem;
            padding:.8rem .9rem;
            border:1px solid #e6e9ef;
            border-radius:.9rem;
            background:#fff;
            margin-bottom:.6rem;
          }

          .result-row:last-child{margin-bottom:0;}

          .result-name{
            font-weight:600;
            color:#1f2a37;
            line-height:1.2;
          }

          .result-note{
            font-size:.8rem;
            color:#667085;
            margin-top:.15rem;
          }

          .result-value-wrap{
            min-width:150px;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid #ecd798;
            border-radius:1rem;
            padding:1rem;
          }

          .footer-note{
            font-size:.82rem;
            color:#6c757d;
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column; align-items:flex-start;}
            .result-value-wrap{width:100%; min-width:0;}
          }

          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="peri-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Peridural Pediátrica</h1>
              <div class="subtle text-white-50">Cálculo automático de cargas epidurales y parámetros de PCA según peso y rango etáreo.</div>
            </div>
            <span class="pill bg-light text-dark">Pediatría</span>
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
            <div class="section-title mb-3">Datos de entrada</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Peso</label>
                <div class="input-group">
                  <input class="form-control calc-trigger" type="number" id="peso" value="">
                  <span class="input-group-text">Kg</span>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Rango Edad</label>
                <select class="form-select calc-trigger" id="select" required>
                  <option value=""></option>
                  <option value="0.25">Neonato</option>
                  <option value="0.3">1 a 4 meses</option>
                  <option value="0.35">5 a 8 meses</option>
                  <option value="0.4">8 a 12 meses</option>
                  <option value="0.5">Mayor 1 año</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Cargas peridurales</div>

            <div class="card-block mb-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Carga Peri Lumbar</div>
                  <div class="result-note">Calculada para Levobupivacaína 0,25%</div>
                </div>
                <div class="result-value-wrap input-group input-group-sm">
                  <input class="form-control" type="number" id="resultado0" readonly>
                  <span class="input-group-text">ml</span>
                </div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Carga Peri Torácica</div>
                  <div class="result-note">Calculada para Levobupivacaína 0,25%</div>
                </div>
                <div class="result-value-wrap input-group input-group-sm">
                  <input class="form-control" type="number" id="resultado3" readonly>
                  <span class="input-group-text">ml</span>
                </div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Top-Up Peridural</div>
                  <div class="result-note">Calculada para Levobupivacaína 0,25%</div>
                </div>
                <div class="result-value-wrap input-group input-group-sm">
                  <input class="form-control" type="number" id="resultado4" readonly>
                  <span class="input-group-text">ml</span>
                </div>
              </div>
            </div>

            <div class="warn-box">
              <strong>* Dosis de carga calculadas para una solución de L-Bupivacaína 0,25%</strong>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">PCA postoperatoria</div>

            <div class="card-block mb-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Infusión PCA</div>
                  <div class="result-note">Calculada para Bupivacaína 0,1%</div>
                </div>
                <div class="result-value-wrap input-group input-group-sm">
                  <input class="form-control" type="number" id="resultado1" readonly>
                  <span class="input-group-text">ml/hr</span>
                </div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Bolo PCA</div>
                  <div class="result-note">Calculado para Bupivacaína 0,1%</div>
                </div>
                <div class="result-value-wrap input-group input-group-sm">
                  <input class="form-control" type="number" id="resultado2" readonly>
                  <span class="input-group-text">ml</span>
                </div>
              </div>
            </div>

            <div class="warn-box">
              <strong>** Bolo e infusión de PCA calculados para una solución de bupivacaína al 0,1%</strong>
            </div>

            <div id="otro_elemento" class="small-note pt-3"></div>
          </div>
        </div>

        <div class="footer-note">
          Los cálculos se actualizan automáticamente al modificar peso o rango etáreo. Ajustar siempre según edad, comorbilidades, técnica y riesgo de toxicidad sistémica por anestésicos locales.
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

function setFieldValue(id, value, decimals){
  const el = document.getElementById(id);
  if(!el) return;
  if(isNaN(value) || value === null || value === undefined || !isFinite(value)){
    el.value = '';
    return;
  }
  el.value = Number(value).toFixed(decimals);
}

function doMath(){
  const pesoVar = parseFloat(document.getElementById('peso').value);
  const selectVar = parseFloat(document.getElementById('select').value);

  if(!isNaN(pesoVar)){
    const resultado0Var = ((pesoVar * 0.5) > 20.0) ? 20.0 : (pesoVar * 0.5);
    const resultado3Var = ((pesoVar * 0.3) > 15.0) ? 15.0 : (pesoVar * 0.3);
    const resultado4Var = ((pesoVar * 0.2) > 10.0) ? 10.0 : (pesoVar * 0.2);

    setFieldValue('resultado0', resultado0Var, 1);
    setFieldValue('resultado3', resultado3Var, 1);
    setFieldValue('resultado4', resultado4Var, 1);
  } else {
    ['resultado0','resultado3','resultado4'].forEach(id => document.getElementById(id).value = '');
  }

  if(!isNaN(pesoVar) && !isNaN(selectVar)){
    const resultado1Var = ((pesoVar * selectVar / 3 * 2) > 5.0) ? 5.0 : (pesoVar * selectVar / 3 * 2);
    const resultado2Var = ((pesoVar * selectVar / 3) > 5.0) ? 5.0 : (pesoVar * selectVar / 3);

    setFieldValue('resultado1', resultado1Var, 1);
    setFieldValue('resultado2', resultado2Var, 1);

    if (resultado1Var >= 5.0 || resultado2Var >= 5.0) {
      document.getElementById('otro_elemento').textContent = 'El valor máximo del bolo o de la infusión es de 5,0 ml/hr.';
    } else {
      document.getElementById('otro_elemento').textContent = '';
    }
  } else {
    ['resultado1','resultado2'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('otro_elemento').textContent = '';
  }
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', doMath);
    el.addEventListener('change', doMath);
  });
  doMath();
});
</script>

<?php
require("footer.php");
?>
