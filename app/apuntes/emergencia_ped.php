<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Cálculo rápido de dosis y parámetros útiles en emergencia pediátrica. Mantiene el formulario de impresión PDF y actualiza automáticamente los resultados al ingresar los datos.";
$formula = "";
$referencias = array(
  "1.- Planilla Unidad Paciente Crítico Pediátrico. Hospital Clínico Regional Valdivia.",
  "2.- Cote CJ, Lerman J, Anderson BJ. A Practice of Anesthesia for Infants and Children. Pocket Reference Guide.",
  "3.- Planilla Unidad Paciente Crítico Pediátrico. Hospital Clínico Universidad Católica.",
  "4.- Andropoulos DB, Bent ST, Skjonsby B, Stayer SA. The optimal length of insertion of central venous catheters for pediatric patients. Anesth Analg. 2001;93:883-886."
);

$icono_apunte = "<i class='fa-solid fa-truck-medical pe-3 pt-2'></i>";
$titulo_apunte = "Dosis de Emergencia Pediátrica";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="ped-shell">

        <style>
          :root{
            --brand:#27458f;
            --brand2:#3559b7;
            --bg:#f4f7fb;
            --soft:#f8fafc;
            --line:#dfe7f2;
            --text:#1f2a37;
            --muted:#667085;
          }
          body{background:var(--bg);}
          .ped-shell{max-width:980px;margin:0 auto;}
          .ped-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;border-radius:1.25rem;box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;margin-bottom:1rem;overflow:hidden;
          }
          .ped-topbar h1{color:#fff;}
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
          .card-block{
            border:1px solid var(--line);border-radius:1rem;background:var(--soft);padding:1rem;
          }
          .form-label-lite{
            font-size:.92rem;font-weight:600;color:var(--text);margin-bottom:.35rem;
          }
          .results-grid{
            display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;
          }
          .result-row{
            display:flex;align-items:center;justify-content:space-between;gap:1rem;
            padding:.8rem .9rem;border:1px solid #e6e9ef;border-radius:.9rem;background:#fff;margin-bottom:.6rem;
          }
          .result-row:last-child{margin-bottom:0;}
          .result-name{
            font-weight:600;color:#1f2a37;line-height:1.2;
          }
          .result-note{
            font-size:.8rem;color:#667085;margin-top:.15rem;
          }
          .result-value-wrap{min-width:140px;}
          .age-toggle-btn{height:38px;}
          .print-bar{
            display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;
          }
          .footer-note{font-size:.82rem;color:#6c757d;}
          @media (max-width:768px){
            .results-grid{grid-template-columns:1fr;}
          }
          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
        </style>

        <div class="ped-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • cálculo automático</div>
              <h1 class="h3 mb-2">Dosis de Emergencia Pediátrica</h1>
              <div class="subtle text-white-50">Resultados automáticos sin botón de calcular. El envío a PDF se mantiene sin cambios.</div>
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

        <form id="formPDF" method="post" action="https://anestesiauach.cl/pdf/emergencia_ped_pdf.php" target="_blank">

          <div class="section-card">
            <div class="p-3 p-md-4">
              <div class="section-title mb-3">Datos de entrada</div>

              <div class="row g-3">
                <div class="col-12 col-md-6">
                  <label class="form-label-lite">Peso</label>
                  <div class="input-group">
                    <input class="form-control calc-trigger" type="number" id="peso" name="peso" value="">
                    <span class="input-group-text">Kg</span>
                  </div>
                </div>

                <div class="col-12 col-md-6">
                  <label class="form-label-lite">Talla</label>
                  <div class="input-group">
                    <input class="form-control calc-trigger" type="number" id="talla" name="talla" value="">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>

                <div class="col-12 col-md-6">
                  <label class="form-label-lite">Edad</label>
                  <div class="row g-2">
                    <div class="col-10">
                      <div class="input-group" id="edadInput">
                        <input type="number" id="edad" name="edad" class="form-control calc-trigger" placeholder="Edad">
                        <span class="input-group-text" id="edadUnit">años</span>
                        <input type="hidden" id="hiddenInput" name="anios" value="1">
                      </div>
                    </div>
                    <div class="col-2">
                      <button class="btn btn-outline-secondary w-100 age-toggle-btn anios" id="btnCambiar" type="button" title="Cambiar unidad de edad">
                        <i class="fa-solid fa-rotate"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>


              <div class="section-card">
                <div class="p-3 p-md-4">
                  <div class="section-title mb-3">Exportar</div>
                  <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary shadow-sm" onclick="envioFormPDF()">
                      <i class="fa-solid fa-file-pdf pe-2"></i>Imprimir PDF
                    </button>
                  </div>
                </div>
              </div>


            </div>
          </div>

          <div class="section-card">
            <div class="p-3 p-md-4">
              <div class="section-title mb-3">Tubo y distancia</div>

              <div class="results-grid">
                <div class="card-block">
                  <label class="form-label-lite">Tubo</label>
                  <div class="input-group">
                    <input class="form-control" id="resultadoX" readonly>
                    <span class="input-group-text">c/cuff</span>
                  </div>
                </div>

                <div class="card-block">
                  <label class="form-label-lite">Dist. Boca</label>
                  <div class="input-group">
                    <input class="form-control" id="resultadoX2" readonly>
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

<div class="section-card">
  <div class="p-3 p-md-4">
    <div class="section-title mb-3">Parámetros generales</div>

    <div class="results-grid">
      <div class="card-block">
        <div class="result-row">
          <div>
            <div class="result-name">Superficie Corporal</div>
          </div>
          <div class="result-value-wrap input-group input-group-sm">
            <input class="form-control" type="number" id="resultado1" readonly>
            <span class="input-group-text">m2SC</span>
          </div>
        </div>

        <div class="result-row">
          <div>
            <div class="result-name">Distancia CVC</div>
            <div class="result-note">* Desde Vena Yugular Interna Derecha</div>
          </div>
          <div class="result-value-wrap input-group input-group-sm">
            <input class="form-control" type="number" id="distanciaCVC" readonly>
            <span class="input-group-text">cm</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section-card">
  <div class="p-3 p-md-4">
    <div class="section-title mb-3">Fármacos de emergencia</div>

    <div class="results-grid">
      <div class="card-block">
        <div class="result-row"><div class="result-name">Atropina</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="atropina" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Bicarbonato 8%</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="bicarbonato" readonly><span class="input-group-text">ml</span></div></div>
        <div class="result-row"><div class="result-name">Epinefrina (PCR)</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="epinefrina" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Calcio Cloruro (10%)</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="calcioCl" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Calcio Gluconato (10%)</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="calcioGl" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Adenosina</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="adenosina" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Amiodarona</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="amiodarona" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Lidocaína</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="lidocaina" readonly><span class="input-group-text">mg</span></div></div>
      </div>

      <div class="card-block">
        <div class="result-row"><div class="result-name">Rocuronio (2DE95)</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="rocuronio" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Midazolam</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="midazolam" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Fentanyl (inducción)</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="fentaInd" readonly><span class="input-group-text">ug</span></div></div>
        <div class="result-row"><div class="result-name">Fentanyl (analgesia)</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="fentaAna" readonly><span class="input-group-text">ug</span></div></div>
        <div class="result-row"><div class="result-name">Morfina</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="morfina" readonly><span class="input-group-text">mg</span></div></div>
        <div class="result-row"><div class="result-name">Glucosa (30%)</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="glucosa" readonly><span class="input-group-text">ml</span></div></div>
      </div>
    </div>
  </div>
</div>

<div class="section-card">
  <div class="p-3 p-md-4">
    <div class="section-title mb-3">Reversión</div>

    <div class="results-grid">
      <div class="card-block">
        <div class="result-row"><div class="result-name">Naloxona</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="naloxona" readonly><span class="input-group-text">ug</span></div></div>
        <div class="result-row"><div class="result-name">Flumazenil</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="flumazenil" readonly><span class="input-group-text">ug</span></div></div>
      </div>
    </div>
  </div>
</div>

<div class="section-card">
  <div class="p-3 p-md-4">
    <div class="section-title mb-3">Cardioversión / Desfibrilación</div>

    <div class="results-grid">
      <div class="card-block">
        <div class="result-row"><div class="result-name">Cardioversión 1</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="cardiov" readonly><span class="input-group-text">J</span></div></div>
        <div class="result-row"><div class="result-name">Desfibrilación 1</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="desfibr" readonly><span class="input-group-text">J</span></div></div>
        <div class="result-row"><div class="result-name">Desfibrilación 2-3</div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="desfibr2" readonly><span class="input-group-text">J</span></div></div>
      </div>
    </div>

    <div id="otro_elemento" class="small-note pt-3"></div>
  </div>
</div>

        </form>

        <div class="footer-note">
          Los cálculos se actualizan automáticamente. El formulario de impresión PDF mantiene su acción original y el mismo identificador de formulario.
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

function calculateTubeAndDistance(){
  const edadEl = document.getElementById('edad');
  const edad = parseFloat(edadEl.value);
  let resultadoF = '';
  let resultadoF2 = '';

  if(!isNaN(edad) && edad > 0){
    if(document.getElementById('btnCambiar').classList.contains('anios')){
      let resultadoX = edad / 4 + 3.5;
      let resultadoX2 = edad / 2 + 12;

      if (resultadoX > 7) {
        resultadoF = 7;
        resultadoF2 = 21;
      } else if (resultadoX < 2.5) {
        resultadoF = 2.5;
        resultadoF2 = 7.5;
      } else {
        resultadoF = resultadoX;
        resultadoF2 = resultadoX2;
      }
    } else {
      if (edad >= 18 ){
        resultadoF = edad / 12 / 4 + 3.5;
        resultadoF2 = edad / 12 / 2 + 12;
      } else if (edad < 18 && edad >= 9 ){
        resultadoF = 3.5;
        resultadoF2 = 10.5;
      } else if (edad < 9 && edad >= 3 ){
        resultadoF = 3.0;
        resultadoF2 = 9.0;
      } else if (edad < 3 ){
        resultadoF = 2.5;
        resultadoF2 = 7.5;
      }

      if (resultadoF > 7) {
        resultadoF = 7;
        resultadoF2 = 21;
      } else if (resultadoF < 2.5) {
        resultadoF = 2.5;
        resultadoF2 = 7.5;
      }
    }
  }

  const tuboEl = document.getElementById('resultadoX');
  const bocaEl = document.getElementById('resultadoX2');
  tuboEl.value = (resultadoF === '' ? '' : (Math.round(resultadoF * 2) / 2).toFixed(1));
  bocaEl.value = (resultadoF2 === '' ? '' : (Math.round(resultadoF2 * 2) / 2).toFixed(1));
}

function doMath(){
  const pesoVar = parseFloat(document.getElementById('peso').value);

  if(!isNaN(pesoVar)){
    const resultado1Var = (pesoVar < 10.0) ? (((pesoVar * 4) + 9) / 100) : (((pesoVar * 4) + 7) / (pesoVar + 90));
    const distanciaCVCVar =
      (pesoVar < 2.0) ? 3 :
      (pesoVar >= 2.0 && pesoVar <= 2.9) ? 4 :
      (pesoVar >= 3.0 && pesoVar <= 4.9) ? 5 :
      (pesoVar >= 5.0 && pesoVar <= 6.9) ? 6 :
      (pesoVar >= 7.0 && pesoVar <= 9.9) ? 7 :
      (pesoVar >= 10.0 && pesoVar <= 12.9) ? 8 :
      (pesoVar >= 13.0 && pesoVar <= 19.9) ? 9 :
      (pesoVar >= 20.0 && pesoVar <= 29.9) ? 10 :
      (pesoVar >= 30.0 && pesoVar <= 39.9) ? 11 :
      (pesoVar >= 40.0 && pesoVar <= 49.9) ? 12 :
      (pesoVar >= 50.0 && pesoVar <= 59.9) ? 13 :
      (pesoVar >= 60.0 && pesoVar <= 69.9) ? 14 :
      (pesoVar >= 70.0 && pesoVar <= 79.9) ? 15 :
      (pesoVar >= 80) ? 16 : NaN;

    const atropinaVar = (pesoVar * 0.02 > 0.3) ? 0.3 : (pesoVar * 0.02);
    const bicarbonatoVar = (pesoVar * 1 > 50) ? 0.3 : (pesoVar * 1);
    const epinefrinaVar = (pesoVar * 0.01 > 1.0) ? 1.0 : (pesoVar * 0.01);
    const calcioClVar = (pesoVar * 10 > 1000) ? 1000 : (pesoVar * 10);
    const calcioGlVar = (pesoVar * 30 > 3000) ? 3000 : (pesoVar * 30);
    const adenosinaVar = (pesoVar * 0.2 > 6.0) ? 6.0 : (pesoVar * 0.2);
    const amiodaronaVar = (pesoVar * 2 > 300) ? 300 : (pesoVar * 2);
    const lidocainaVar = (pesoVar * 1 > 100) ? 100 : (pesoVar * 1);
    const rocuronioVar = (pesoVar * 0.6 > 50) ? 50 : (pesoVar * 0.6);
    const midazolamVar = (pesoVar * 0.2 > 5) ? 5 : (pesoVar * 0.2);
    const fentaIndVar = (pesoVar * 3 > 300) ? 300 : (pesoVar * 3);
    const fentaAnaVar = (pesoVar * 0.5 > 50) ? 50 : (pesoVar * 0.5);
    const morfinaVar = (pesoVar * 0.05 > 3) ? 3 : (pesoVar * 0.05);
    const glucosaVar = (pesoVar * 0.5 > 60) ? 60 : (pesoVar * 0.5);
    const naloxonaVar = (pesoVar * 5 > 400) ? 400 : (pesoVar * 5);
    const flumazenilVar = (pesoVar * 5 > 100) ? 100 : (pesoVar * 5);
    const cardiovVar = (pesoVar * 0.5 > 100) ? 100 : (pesoVar * 0.5);
    const desfibrVar = (pesoVar * 2 > 200) ? 200 : (pesoVar * 2);
    const desfibr2Var = (pesoVar * 4 > 200) ? 200 : (pesoVar * 4);

    setFieldValue('resultado1', resultado1Var, 2);
    setFieldValue('distanciaCVC', distanciaCVCVar, 0);
    setFieldValue('atropina', atropinaVar, 2);
    setFieldValue('bicarbonato', bicarbonatoVar, 0);
    setFieldValue('epinefrina', epinefrinaVar, 2);
    setFieldValue('calcioCl', calcioClVar, 0);
    setFieldValue('calcioGl', calcioGlVar, 0);
    setFieldValue('adenosina', adenosinaVar, 1);
    setFieldValue('amiodarona', amiodaronaVar, 1);
    setFieldValue('lidocaina', lidocainaVar, 1);
    setFieldValue('rocuronio', rocuronioVar, 1);
    setFieldValue('midazolam', midazolamVar, 1);
    setFieldValue('fentaInd', fentaIndVar, 0);
    setFieldValue('fentaAna', fentaAnaVar, 0);
    setFieldValue('morfina', morfinaVar, 1);
    setFieldValue('glucosa', glucosaVar, 1);
    setFieldValue('naloxona', naloxonaVar, 0);
    setFieldValue('flumazenil', flumazenilVar, 0);
    setFieldValue('cardiov', cardiovVar, 0);
    setFieldValue('desfibr', desfibrVar, 0);
    setFieldValue('desfibr2', desfibr2Var, 0);
  } else {
    ['resultado1','distanciaCVC','atropina','bicarbonato','epinefrina','calcioCl','calcioGl','adenosina','amiodarona','lidocaina','rocuronio','midazolam','fentaInd','fentaAna','morfina','glucosa','naloxona','flumazenil','cardiov','desfibr','desfibr2']
      .forEach(id => document.getElementById(id).value = '');
  }

  calculateTubeAndDistance();
  document.getElementById('otro_elemento').textContent = '';
}

function envioFormPDF() {
  document.getElementById('formPDF').submit();
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', doMath);
    el.addEventListener('change', doMath);
  });

  document.getElementById('btnCambiar').addEventListener('click', function() {
    const edadInput = document.getElementById('edad');
    const edadValor = edadInput.value;
    const esAnios = this.classList.contains('anios');
    const edadUnit = document.getElementById('edadUnit');
    const oldHidden = document.getElementById('hiddenInput');
    if(oldHidden) oldHidden.remove();

    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.id = 'hiddenInput';

    if (esAnios) {
      edadUnit.textContent = 'meses';
      hidden.name = 'meses';
      hidden.value = '1';
      this.classList.remove('anios');
    } else {
      edadUnit.textContent = 'años';
      hidden.name = 'anios';
      hidden.value = '1';
      this.classList.add('anios');
    }

    document.getElementById('edadInput').appendChild(hidden);
    edadInput.value = edadValor;
    edadInput.focus();
    doMath();
  });

  doMath();
});
</script>

<?php
require("footer.php");
?>
