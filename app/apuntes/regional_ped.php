<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Apunte interactivo de anestesia regional pediátrica. Prioriza la relación entre volumen, masa total de anestésico local, concentración utilizada, edad/fisiología del paciente y sitio anatómico del bloqueo.";
$formula = "La seguridad real depende más de la masa total administrada (mg) que del volumen aislado. En técnicas ecoguiadas, el objetivo es buena distribución perineural o interfascial; no perseguir ciegamente un volumen máximo por tabla.";
$referencias = array(
  "1.- NYSORA. Peripheral Nerve Blocks for Children.",
  "2.- Tabla docente pediátrica del usuario, depurada para práctica frecuente.",
  "3.- En menores de 6 meses existe mayor vulnerabilidad fisiológica a LAST."
);

$icono_apunte = "<i class='fa-solid fa-syringe pe-3 pt-2'></i>";
$titulo_apunte = "Regional Pediátrica / Volumen y Dosis";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="regional-shell">

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
          }

          body{background:var(--bg);}
          .regional-shell{max-width:1060px;margin:0 auto;}

          .regional-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .regional-topbar h1{color:#fff;}

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
          .small-note{font-size:.82rem;color:#667085;line-height:1.45;}
          .footer-note{font-size:.82rem;color:#6c757d;}

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

          .info-toggle-btn:hover{background:#5a6268;color:white;}

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

          .choice-check,.choice-radio{display:none;}

          .choice-grid-2{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.55rem;
          }

          .choice-grid-3{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.55rem;
          }

          .choice-grid-4{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:.55rem;
          }

          .choice-btn{
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            justify-content:center;
            text-align:left;
            min-height:68px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:.85rem;
            padding:.6rem .7rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.12;
            box-shadow:0 4px 14px rgba(0,0,0,.04);
            font-size:.92rem;
          }

          .choice-btn small{
            font-weight:500;
            color:#667085;
            margin-top:.14rem;
            line-height:1.15;
            font-size:.72rem;
          }

          .choice-check:checked + .choice-btn,
          .choice-radio:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset, 0 8px 18px rgba(0,0,0,.06);
            transform:translateY(-1px);
          }

          .form-label-lite{
            font-size:.92rem;
            font-weight:600;
            color:var(--text);
            margin-bottom:.35rem;
          }

          .summary-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:.75rem;
          }

          .summary-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.9rem;
          }

          .summary-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#667085;
            margin-bottom:.25rem;
          }

          .summary-value{
            font-size:1rem;
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
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
            min-width:145px;
            text-align:right;
            font-weight:800;
            color:#27458f;
            line-height:1.25;
          }

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid #ecd798;
            border-radius:1rem;
            padding:1rem;
          }

          .danger-box{
            background:var(--danger);
            border:1px solid #efc4be;
            border-radius:1rem;
            padding:1rem;
          }

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.1rem;
          }

          .tip-list li{margin-bottom:.45rem;}

          @media (max-width:900px){
            .choice-grid-4{grid-template-columns:repeat(2,1fr);}
            .choice-grid-3{grid-template-columns:repeat(2,1fr);}
            .summary-grid{grid-template-columns:repeat(2,1fr);}
          }

          @media (max-width:768px){
            .calc-grid{grid-template-columns:1fr;}
            .result-row{flex-direction:column;align-items:flex-start;}
            .result-value{text-align:left;min-width:0;}
          }

          @media (max-width:576px){
            .choice-grid-4,.choice-grid-3,.choice-grid-2{grid-template-columns:repeat(2,1fr);}
            .summary-grid{grid-template-columns:1fr;}
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
          }
          .choice-btn i{
            font-size:1rem;
            margin-bottom:.28rem;
            color:#3559b7;
          }
        </style>

        <div class="regional-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • volumen y seguridad</div>
              <h1 class="h3 mb-2">Regional Pediátrica</h1>
              <div class="subtle text-white-50">Volumen, masa total, concentración, fisiología y sitio anatómico del bloqueo.</div>
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
          </div>
        </div>

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

                <label class="form-label-lite">Edad / fisiología</label>
                <div class="choice-grid-4">
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="edadgrp" id="edad_rn" value="rn">
                    <label class="choice-btn" for="edad_rn">RN<small>más inmaduro</small></label>
                  </div>
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="edadgrp" id="edad_lt6m" value="lt6m" checked>
                    <label class="choice-btn" for="edad_lt6m">&lt;6 m<small>alto riesgo LAST</small></label>
                  </div>
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="edadgrp" id="edad_6m_1a" value="6m1a">
                    <label class="choice-btn" for="edad_6m_1a">6–12 m<small>intermedio</small></label>
                  </div>
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="edadgrp" id="edad_gt1a" value="gt1a">
                    <label class="choice-btn" for="edad_gt1a">&gt;1 año<small>más estable</small></label>
                  </div>
                </div>

                <div class="mint-box mt-3">
                  <strong>Idea central</strong><br>
                  <div class="small-note mt-2">
                    Primero decide <b>cuántos mg</b> quieres administrar con seguridad. Luego juzga si el volumen y la concentración elegidos son razonables para ese bloqueo.
                  </div>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Anestésico local</label>
                <div class="choice-grid-3 mb-3">
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="droga" id="droga_bupi" value="bupi" checked>
                    <label class="choice-btn" for="droga_bupi">Bupivacaína<small>máx 2.5 mg/kg</small></label>
                  </div>
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="droga" id="droga_levo" value="levo">
                    <label class="choice-btn" for="droga_levo">Levobupi<small>máx 2.5 mg/kg</small></label>
                  </div>
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="droga" id="droga_ropi" value="ropi">
                    <label class="choice-btn" for="droga_ropi">Ropivacaína<small>máx 3 mg/kg</small></label>
                  </div>
                </div>

                <label class="form-label-lite">Concentración</label>
                <div class="choice-grid-3">
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="conc" id="conc_0125" value="1.25">
                    <label class="choice-btn" for="conc_0125">0,125%<small>1.25 mg/mL</small></label>
                  </div>
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="conc" id="conc_02" value="2">
                    <label class="choice-btn" for="conc_02">0,2%<small>2 mg/mL</small></label>
                  </div>
                  <div>
                    <input class="choice-radio calc-trigger-radio" type="radio" name="conc" id="conc_025" value="2.5" checked>
                    <label class="choice-btn" for="conc_025">0,25%<small>2.5 mg/mL</small></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">B. Selección del bloqueo</div>

            <div class="calc-grid">
              <div class="card-block">
                <label class="form-label-lite">Grupo anatómico</label>
<div class="choice-grid-4 mb-3">
  <div>
    <input class="choice-radio calc-trigger-radio" type="radio" name="grupo" id="grupo_cabeza" value="cabeza" checked>
    <label class="choice-btn" for="grupo_cabeza">
      <i class="fa-solid fa-head-side-mask"></i>
      Cabeza / cuello
      <small>superficiales</small>
    </label>
  </div>
  <div>
    <input class="choice-radio calc-trigger-radio" type="radio" name="grupo" id="grupo_braquial" value="braquial">
    <label class="choice-btn" for="grupo_braquial">
      <i class="fa-solid fa-hand"></i>
      Plexo braquial
      <small>miembro superior</small>
    </label>
  </div>
  <div>
    <input class="choice-radio calc-trigger-radio" type="radio" name="grupo" id="grupo_abdomen" value="abdomen">
    <label class="choice-btn" for="grupo_abdomen">
      <i class="fa-solid fa-bandage"></i>
      Abdomen / ingle
      <small>planos fasciales</small>
    </label>
  </div>
  <div>
    <input class="choice-radio calc-trigger-radio" type="radio" name="grupo" id="grupo_miembro" value="miembro">
    <label class="choice-btn" for="grupo_miembro">
      <i class="fa-solid fa-shoe-prints"></i>
      Miembro inferior
      <small>periféricos</small>
    </label>
  </div>
</div>

                <label class="form-label-lite">Bloqueo específico</label>
                <div id="bloqueoWrap" class="choice-grid-3"></div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Lado</label>
                
<div class="choice-grid-2 mb-3">
  <div>
    <input class="choice-radio calc-trigger-radio" type="radio" name="lado" id="lado_uni" value="1" checked>
    <label class="choice-btn" for="lado_uni">Unilateral<small>1 lado</small></label>
  </div>
  <div>
    <input class="choice-radio calc-trigger-radio" type="radio" name="lado" id="lado_bi" value="2">
    <label class="choice-btn" for="lado_bi">Bilateral<small>2 lados</small></label>
  </div>
</div>

                <div class="warn-box">
                  <strong>Recordatorio práctico</strong><br>
                  <div class="small-note mt-2">
                    En bloqueos ecoguiados perineurales, si la distribución es excelente, no necesitas perseguir el extremo alto del rango. En planos fasciales, el volumen sigue siendo más importante.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">C. Tarjeta resumen</div>

            <div class="summary-grid">
              <div class="summary-card">
                <div class="summary-label">Peso</div>
                <div id="sumPeso" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Edad / fisiología</div>
                <div id="sumEdad" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Droga / concentración</div>
                <div id="sumDroga" class="summary-value">-</div>
              </div>
              <div class="summary-card">
                <div class="summary-label">Bloqueo</div>
                <div id="sumBloqueo" class="summary-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">D. Resultado principal</div>

            <div id="resultCard" class="result-main-card">
              <div class="result-main-label">Volumen orientativo</div>
              <div class="result-main-note">Interpretado según peso, concentración, masa total y fisiología</div>
              <div id="mainVolume" class="result-main-value">-</div>
            </div>

            <div class="mt-3">
              <div class="result-row">
                <div>
                  <div class="result-name">Rango de volumen</div>
                  <div class="result-note">Calculado desde la referencia del bloqueo seleccionado.</div>
                </div>
                <div id="outVol" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Masa total administrada</div>
                  <div class="result-note">mg = mL × mg/mL. Este es el dato más importante.</div>
                </div>
                <div id="outMg" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Límite máximo teórico</div>
                  <div class="result-note">Basado en droga seleccionada y peso.</div>
                </div>
                <div id="outMax" class="result-value">-</div>
              </div>

              <div class="result-row">
                <div>
                  <div class="result-name">Relación con el máximo</div>
                  <div class="result-note">Útil para juzgar margen de seguridad real.</div>
                </div>
                <div id="outPct" class="result-value">-</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">E. Lectura clínica</div>

            <div id="riskBox" class="good-box">
              <strong id="riskTitle">Riesgo basal</strong><br>
              <div id="riskText" class="small-note mt-2">
                Completa peso, droga, concentración y bloqueo para estimar carga total y margen de seguridad.
              </div>
            </div>

            <div id="blockInfo" class="mint-box mt-3">
              <strong>Comentario del bloqueo</strong><br>
              <div id="blockInfoText" class="small-note mt-2">-</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">F. Tips docentes</div>

            <div class="warn-box">
              <ul class="tip-list">
                <li>La tabla de volumen no manda sola. El verdadero límite de seguridad es la masa total administrada.</li>
                <li>En pediatría, cambiar concentración puede ser más peligroso que discutir una pequeña diferencia de volumen.</li>
                <li>En menores de 6 meses conviene ser más conservador incluso si el cálculo “cabe” dentro del máximo teórico.</li>
                <li>Si haces más de un bloqueo, o agregas infiltración quirúrgica, siempre suma toda la masa total administrada.</li>
                <li>En planos fasciales, el volumen importa más. En bloqueos perineurales bien ecoguiados, una buena distribución puede permitir usar menos volumen.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. Verificar siempre dosis máxima institucional, concentración preparada, suma total de droga y contexto fisiológico del paciente.
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

const BLOCKS = {
  cabeza: [
    {id:'supra', name:'Supraorbitario / Supratroclear', volMin:1.0, volMax:2.0, unit:'mL/kg', info:'Bloqueo superficial para cuero cabelludo frontal. La masa total sigue siendo más importante que perseguir el extremo alto del rango.'},
    {id:'infra', name:'Infraorbitario', volMin:0.5, volMax:1.0, volMaxChild:2.0, unit:'mL/kg', info:'En lactantes suele requerir menos volumen que en niños mayores. Vigilar lesiones labiales o mordedura al despertar.'},
    {id:'cervical', name:'Plexo cervical superficial', volMin:1.0, volMax:3.0, unit:'mL/kg', info:'Mantener técnica superficial. Evitar profundizar innecesariamente.'}
  ],
  braquial: [
    {id:'inter', name:'Interescalénico', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Bloqueo proximal del plexo braquial. Alto riesgo de compromiso frénico ipsilateral; no debe plantearse bilateral.'},
    {id:'supra', name:'Supraclavicular', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Muy útil para extremidad superior, pero puede asociarse a hemiparesia diafragmática. Evitar bilateral.'},
    {id:'infra', name:'Infraclavicular', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Alternativa más distal y mucho más “phrenic-sparing”, aunque hay reportes aislados de compromiso frénico.'},
    {id:'axilar', name:'Axilar', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Adecuado para cirugía distal de MS. Sin impacto clínico esperado sobre el diafragma.'}
  ],
  abdomen: [
    {id:'tap', name:'TAP', volMin:0.3, volMax:0.5, unit:'mL/kg por lado', info:'Plano fascial clásico. En este tipo de técnica, el volumen pesa más que en un perineural puro.'},
    {id:'subtap', name:'Subcostal TAP', volMin:0.3, volMax:0.5, unit:'mL/kg por lado', info:'Útil para abdomen superior. Buena cobertura requiere volumen, pero no olvidar la masa total.'},
    {id:'rectus', name:'Rectus sheath', volMin:0.2, volMax:0.3, unit:'mL/kg por lado', info:'Siempre bilateral en la referencia clásica. No cubre dolor visceral.'},
    {id:'ilio', name:'Ilioinguinal / Iliohipogástrico', volMin:0.2, volMax:0.3, unit:'mL/kg', info:'Muy frecuente en cirugía inguinal. Aunque el volumen sea moderado, cuenta en la carga total.'},
    {id:'pene', name:'Bloqueo peneano', volMin:0.1, volMax:0.1, unit:'mL/kg por lado', info:'Frecuente y útil. Aun con poco volumen, la concentración importa si se suma a otras infiltraciones.'},
    {id:'esp', name:'ESP', volMin:0.3, volMax:0.5, unit:'mL/kg por lado', info:'Bloqueo interfascial moderno. Aquí el volumen vuelve a ser especialmente relevante.'}
  ],
  miembro: [
    {id:'fem', name:'Femoral', volMin:0.2, volMax:0.4, unit:'mL/kg', info:'Útil en fractura femoral. Valorar si se necesita complemento analgésico adicional.'},
    {id:'sciprox', name:'Ciático proximal', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Bloqueo de volumen moderado; recuerda sumar masa si lo combinas con femoral o safeno.'},
    {id:'scipop', name:'Ciático poplíteo', volMin:0.3, volMax:0.5, unit:'mL/kg', info:'Frecuente en cirugía distal de EEII. El volumen no debe ocultar la masa total administrada.'}
  ]
};

function updateBlockButtons(){
  const grupo = getSelected('grupo') || 'cabeza';
  const wrap = document.getElementById('bloqueoWrap');
  const current = getSelected('bloqueo');
  wrap.innerHTML = '';

  BLOCKS[grupo].forEach((b, idx) => {
    const id = 'bloq_' + grupo + '_' + b.id;
    const checked = ((!current && idx === 0) || current === b.id) ? 'checked' : '';

    wrap.innerHTML += `
      <div>
        <input class="choice-radio calc-trigger-radio bloqueo-radio" type="radio" name="bloqueo" id="${id}" value="${b.id}" ${checked}>
        <label class="choice-btn" for="${id}">
          ${b.name}
          <small>${b.unit}</small>
        </label>
      </div>
    `;
  });

  document.querySelectorAll('.bloqueo-radio').forEach(el => {
    el.addEventListener('change', updateRegionalPed);
  });
}

function getDrugData(){
  const droga = getSelected('droga') || 'bupi';
  if(droga === 'ropi') return {name:'Ropivacaína', maxMgKg:3.0};
  if(droga === 'levo') return {name:'Levobupivacaína', maxMgKg:2.5};
  return {name:'Bupivacaína', maxMgKg:2.5};
}

function getAgeText(age){
  if(age === 'rn') return 'RN';
  if(age === 'lt6m') return '<6 meses';
  if(age === '6m1a') return '6–12 meses';
  return '>1 año';
}

function getSelectedBlock(){
  const grupo = getSelected('grupo') || 'cabeza';
  const bloqueId = getSelected('bloqueo');
  return BLOCKS[grupo].find(b => b.id === bloqueId) || BLOCKS[grupo][0];
}

function round1(num){
  return Math.round(num * 10) / 10;
}

function enforceSideRestrictions(block){
  const ladoUni = document.getElementById('lado_uni');
  const ladoBi = document.getElementById('lado_bi');
  const labelBi = document.querySelector('label[for="lado_bi"]');

  if(!ladoUni || !ladoBi || !labelBi || !block) return;

  // Reset visual/functional state
  ladoBi.disabled = false;
  labelBi.style.opacity = '1';
  labelBi.style.pointerEvents = 'auto';

  // Interescalénico y supraclavicular: no permitir bilateral
  if(block.id === 'inter' || block.id === 'supra'){
    ladoBi.checked = false;
    ladoUni.checked = true;
    ladoBi.disabled = true;
    labelBi.style.opacity = '.45';
    labelBi.style.pointerEvents = 'none';
  }
}

function updateRegionalPed(){
  updateBlockButtons();

  const peso = parseFloat(document.getElementById('peso').value);
  const edad = getSelected('edadgrp') || 'lt6m';
  const conc = parseFloat(getSelected('conc') || '2.5');
  const drug = getDrugData();
  const block = getSelectedBlock();

  enforceSideRestrictions(block);

  const lado = parseInt(getSelected('lado') || '1', 10);

  document.getElementById('sumPeso').textContent = (!isNaN(peso) && peso > 0) ? peso.toFixed(1) + ' kg' : '-';
  document.getElementById('sumEdad').textContent = getAgeText(edad);
  document.getElementById('sumDroga').textContent = drug.name + ' ' + (conc / 10).toString().replace('.', ',') + '%';
  document.getElementById('sumBloqueo').textContent = block ? block.name : '-';

  if(!block || isNaN(peso) || peso <= 0){
    document.getElementById('mainVolume').textContent = '-';
    document.getElementById('outVol').textContent = '-';
    document.getElementById('outMg').textContent = '-';
    document.getElementById('outMax').textContent = '-';
    document.getElementById('outPct').textContent = '-';
    document.getElementById('blockInfoText').textContent = block ? block.info : '-';
    document.getElementById('riskTitle').textContent = 'Riesgo basal';
    document.getElementById('riskText').textContent = 'Completa peso, droga, concentración y bloqueo para estimar la carga total de anestésico local.';
    document.getElementById('riskBox').className = 'good-box';
    return;
  }

  let vMin = peso * block.volMin;
  let vMax = peso * (block.volMaxChild && edad === 'gt1a' ? block.volMaxChild : block.volMax);

  vMin *= lado;
  vMax *= lado;

  const mgMin = vMin * conc;
  const mgMax = vMax * conc;
  const maxAllowed = peso * drug.maxMgKg;
  const pctMin = (mgMin / maxAllowed) * 100;
  const pctMax = (mgMax / maxAllowed) * 100;

  document.getElementById('mainVolume').textContent =
    round1(vMin).toString().replace('.', ',') + '–' + round1(vMax).toString().replace('.', ',') + ' mL';

  document.getElementById('outVol').textContent =
    round1(vMin).toString().replace('.', ',') + '–' + round1(vMax).toString().replace('.', ',') + ' mL';

  document.getElementById('outMg').textContent =
    round1(mgMin).toString().replace('.', ',') + '–' + round1(mgMax).toString().replace('.', ',') + ' mg';

  document.getElementById('outMax').textContent =
    round1(maxAllowed).toString().replace('.', ',') + ' mg';

  document.getElementById('outPct').textContent =
    round1(pctMin).toString().replace('.', ',') + '–' + round1(pctMax).toString().replace('.', ',') + ' %';

  document.getElementById('blockInfoText').textContent = block.info;

  const riskBox = document.getElementById('riskBox');
  let title = 'Margen cómodo';
  let text = 'La masa calculada parece alejada del máximo teórico. Aun así, la seguridad real depende de técnica, aspiración, fraccionamiento, suma de infiltraciones y fisiología del paciente.';
  riskBox.className = 'good-box';

  if(edad === 'rn' || edad === 'lt6m'){
    title = 'Paciente fisiológicamente más vulnerable';
    text = 'Aunque el cálculo no supere el máximo teórico, en lactantes pequeños el margen fisiológico es menor. Conviene ser más conservador.';
    riskBox.className = 'warn-box';
  }

  if(pctMax >= 80){
    title = 'Carga alta de anestésico local';
    text = 'El rango superior se acerca mucho al máximo teórico. Considera bajar concentración, bajar volumen o replantear la estrategia.';
    riskBox.className = 'danger-box';
  } else if(pctMax >= 60){
    title = 'Carga intermedia / prudencia';
    text = 'La masa total ya ocupa una fracción importante del máximo. Revisa si realmente necesitas el extremo alto del rango.';
    riskBox.className = 'warn-box';
  }

  // Restricción respiratoria importante
  if(block.id === 'inter'){
    title = 'Interescalénico: evitar bilateral';
    text = 'El interescalénico se asocia frecuentemente a bloqueo frénico y hemiparesia diafragmática. En este apunte se fuerza unilateral por riesgo respiratorio.';
    riskBox.className = 'danger-box';
  }

  if(block.id === 'supra'){
    title = 'Supraclavicular: evitar bilateral';
    text = 'El supraclavicular también puede comprometer el hemidiafragma. En este apunte se bloquea la opción bilateral por seguridad respiratoria.';
    riskBox.className = 'danger-box';
  }

  if(block.id === 'infra' && riskBox.className !== 'danger-box'){
    title = 'Infraclavicular: cautela respiratoria, pero más distal';
    text = 'El infraclavicular suele ser mucho más “phrenic-sparing” que el interescalénico y el supraclavicular, aunque existen reportes aislados de compromiso frénico. No se bloquea automático, pero requiere criterio clínico.';
    riskBox.className = 'mint-box';
  }

  if(block.id === 'tap' || block.id === 'subtap' || block.id === 'rectus' || block.id === 'esp'){
    if(block.id !== 'inter' && block.id !== 'supra'){
      if(pctMax < 60){
        title = 'Plano fascial: vigilar relación volumen-masa';
        text = 'En este tipo de bloqueo el volumen importa para cobertura, pero la masa total sigue siendo el verdadero límite de seguridad.';
        riskBox.className = 'mint-box';
      }
    }
  }

  document.getElementById('riskTitle').textContent = title;
  document.getElementById('riskText').textContent = text;
}

document.addEventListener('DOMContentLoaded', function(){
  updateBlockButtons();

  document.getElementById('peso').addEventListener('input', updateRegionalPed);

  document.querySelectorAll('.calc-trigger-radio').forEach(el => {
    el.addEventListener('change', updateRegionalPed);
  });

  updateRegionalPed();
});
</script>

<?php require("footer.php"); ?>