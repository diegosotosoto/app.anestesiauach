<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Algoritmo docente para elección de tubo de doble lumen (TDL) en anestesiología. Integra selección inicial por lado, recomendación de tamaño por sexo y talla, ajuste opcional por diámetro bronquial y perlas prácticas para posicionamiento y verificación.";
$formula = "Elección habitual: TDL izquierdo. Tamaño inicial por sexo y talla; ajuste fino por diámetro bronquial cuando hay imagen disponible.";
$referencias = array(
  "1.- Campos JH. Current techniques for perioperative lung isolation in adults. Anesthesiology. 2002.",
  "2.- Slinger P, Campos JH. Anesthesia for Thoracic Surgery. En: Miller's Anesthesia.",
  "3.- Brodsky JB, Lemmens HJ. Left double-lumen tubes: clinical experience with double-lumen tubes. J Cardiothorac Vasc Anesth.",
  "4.- Benumof JL. Lung isolation and one-lung ventilation. Anesthesiology Clinics."
);

$icono_apunte = "<i class='fa-solid fa-lungs pe-3 pt-2'></i>";
$titulo_apunte = "Elección de Tubo de Doble Lumen";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="tdl-shell">

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
          .tdl-shell{max-width:980px;margin:0 auto;}

          .tdl-topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }
          .tdl-topbar h1{color:#fff;}

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
          .small-note{font-size:.84rem;color:var(--muted);}
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

          .schema-wrap{
            border:1px solid var(--line);
            border-radius:1.4rem;
            background:var(--soft);
            padding:1rem;
          }
          .schema-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:1rem;
          }
          .schema-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:1rem;
          }
          .schema-title{
            text-align:center;
            font-weight:800;
            color:#1f2a37;
            margin-bottom:.8rem;
          }
          .svg-wrap{
            background:#fbfcfe;
            border:1px solid #eef2f6;
            border-radius:1rem;
            padding:.5rem;
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
            margin-bottom:.5rem;
          }

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.75rem;
          }

          .choice-check{
            display:none;
          }

          .choice-card{
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:72px;
            text-align:center;
            padding:1rem;
            border:1px solid var(--line);
            border-radius:1rem;
            background:#fff;
            cursor:pointer;
            transition:.15s ease;
            font-weight:700;
            color:#1f2a37;
          }

          .choice-card:hover{
            background:#f8fbff;
            border-color:#bfd2ff;
          }

          .choice-check:checked + .choice-card{
            background:#edf4ff;
            border-color:#3559b7;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(53,89,183,.08) inset;
          }

          @media (max-width:576px){
            .choice-grid{
              grid-template-columns:1fr;
            }
          }

          .result-box{
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
            padding:1rem;
          }
          .result-main{
            font-size:1.08rem;
            font-weight:700;
            color:var(--text);
          }
          .result-num{
            font-size:2rem;
            font-weight:800;
            line-height:1;
            color:#3559b7;
          }

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

          .algo-wrap{
            border:1px solid var(--line);
            border-radius:1.4rem;
            background:var(--soft);
            padding:1.25rem;
          }
          .algo-title{
            font-size:1rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#64748b;
            text-align:center;
            margin-bottom:1rem;
          }
          .algo-main{
            font-size:1.8rem;
            font-weight:800;
            text-align:center;
            color:#1f2a37;
            line-height:1.15;
            margin-bottom:1.2rem;
          }
          .algo-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }
          .algo-card{
            background:#fff;
            border-radius:1.25rem;
            padding:1.1rem 1rem;
            border:1px solid #e6e9ef;
            text-align:center;
          }
          .algo-label{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#667085;
            margin-bottom:.55rem;
          }
          .algo-text{
            font-size:1rem;
            line-height:1.45;
            color:#1f2a37;
            font-weight:600;
          }
          .algo-soft{
            font-size:.95rem;
            line-height:1.5;
            color:#667085;
            font-weight:500;
            margin-top:.35rem;
          }

          .table thead th{white-space:nowrap;}
          .table td,.table th{vertical-align:middle;}

          @media (max-width:768px){
            .schema-grid{grid-template-columns:1fr;}
            .calc-grid{grid-template-columns:1fr;}
          }
          @media (max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .result-num{font-size:1.8rem;}
            .algo-main{font-size:1.45rem;}
          }
          .tdl-diagram{
            width:100%;
            max-width:420px;
            height:auto;
            border-radius:1rem;
            display:block;
            margin:0 auto;
          }
        </style>

        <div class="tdl-topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • algoritmo interactivo</div>
              <h1 class="h3 mb-2">Elección de Tubo de Doble Lumen</h1>
              <div class="subtle text-white-50">Selección inicial por lado, recomendación de tamaño por talla y ajuste opcional por diámetro bronquial.</div>
            </div>
            <span class="pill bg-light text-dark">Tórax</span>
          </div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>




          <div id="infoContent" class="info-box-content">

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Esquema general</div>

            <div class="schema-wrap">
              <div class="schema-grid">
                <div class="schema-card">
                  <div class="schema-title">TDL izquierdo</div>
                  <div class="svg-wrap text-center">
                    <img src="IMG_5527.jpg" alt="Esquema TDL izquierdo" class="tdl-diagram">
                  </div>
                  <div class="small text-center text-muted mt-2">Elección habitual por mayor margen anatómico antes de la primera emergencia lobar.</div>
                </div>

                <div class="schema-card">
                  <div class="schema-title">TDL derecho</div>
                    <div class="svg-wrap text-center">
                      <img src="IMG_5528.jpg" alt="Esquema TDL derecho" class="tdl-diagram">
                    </div>
                  <div class="small text-center text-muted mt-2">Reservado para indicaciones anatómicas o quirúrgicas específicas.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Tamaño inicial por sexo y talla</div>
            <div class="table-responsive">
              <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Sexo</th>
                    <th>Altura (cm)</th>
                    <th>Tamaño TDL (Fr)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td rowspan="3"><strong>Hombre</strong></td>
                    <td>&gt; 170</td>
                    <td>41</td>
                  </tr>
                  <tr>
                    <td>160 - 170</td>
                    <td>39</td>
                  </tr>
                  <tr>
                    <td>&lt; 160</td>
                    <td>37 o 39</td>
                  </tr>
                  <tr>
                    <td rowspan="3"><strong>Mujer</strong></td>
                    <td>&gt; 160</td>
                    <td>37</td>
                  </tr>
                  <tr>
                    <td>150 - 160</td>
                    <td>35</td>
                  </tr>
                  <tr>
                    <td>&lt; 150</td>
                    <td>32 o 35</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Ajuste opcional por diámetro bronquial izquierdo</div>
            <div class="table-responsive">
              <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Diámetro bronquial (mm)</th>
                    <th>Tamaño TDL (Fr)</th>
                    <th>Mallinckrodt (mm)</th>
                    <th>Rusch (mm)</th>
                    <th>Sheridan (mm)</th>
                    <th>Portex (mm)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>&ge; 12</td>
                    <td>41</td>
                    <td>10.6</td>
                    <td>11.5</td>
                    <td>10.7</td>
                    <td>12.0</td>
                  </tr>
                  <tr>
                    <td>12</td>
                    <td>39</td>
                    <td>10.1</td>
                    <td>10.8</td>
                    <td>9.9</td>
                    <td>11.2</td>
                  </tr>
                  <tr>
                    <td>11</td>
                    <td>37</td>
                    <td>10.0</td>
                    <td>10.1</td>
                    <td>9.9</td>
                    <td>10.2</td>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td>35</td>
                    <td>9.5</td>
                    <td>9.4</td>
                    <td>9.3</td>
                    <td>9.7</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

            
            <?php echo $descripcion_info; ?>
            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Resumen:</b><br>
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
            <div class="section-title mb-3">Datos de entrada</div>



            <div class="calc-grid">

            <div class="card-block">
              <label class="form-label-lite">Sexo</label>
              <div class="choice-grid">
                  <input type="radio" class="choice-check calc-trigger" name="sexo" id="sexo_hombre" value="hombre" autocomplete="off" checked>       
                  <label class="choice-card" for="sexo_hombre">Hombre</label>

                <input type="radio" class="choice-check calc-trigger" name="sexo" id="sexo_mujer" value="mujer" autocomplete="off">
                <label class="choice-card" for="sexo_mujer">Mujer</label>
              </div>
            </div>


            <div class="card-block">
              <label class="form-label-lite">Lado sugerido</label>
              <div class="choice-grid">
                <input type="radio" class="choice-check calc-trigger" name="lado" id="lado_izquierdo" value="izquierdo" autocomplete="off" checked>
                <label class="choice-card" for="lado_izquierdo">Izquierdo</label>

                <input type="radio" class="choice-check calc-trigger" name="lado" id="lado_derecho" value="derecho" autocomplete="off">
                <label class="choice-card" for="lado_derecho">Derecho</label>
              </div>
              <div class="small text-muted mt-2">El izquierdo es la elección habitual; el derecho se reserva para situaciones anatómicas o quirúrgicas específicas.</div>
            </div>

              <div class="card-block">
                <label class="form-label-lite">Altura</label>
                <div class="input-group">
                  <input type="number" id="altura" class="form-control calc-trigger" value="">
                  <span class="input-group-text">cm</span>
                </div>
              </div>

              <div class="card-block">
                <label class="form-label-lite">Diámetro bronquial izquierdo (opcional)</label>
                <div class="input-group">
                  <input type="number" step="0.1" id="diametro" class="form-control calc-trigger" value="">
                  <span class="input-group-text">mm</span>
                </div>
                <div class="small text-muted mt-2">Si cuentas con TC o medición confiable, úsala para ajustar la elección inicial por talla.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="section-title mb-3">Resultado</div>

            <div class="result-box mb-3">
              <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                  <div class="small-note">Tamaño recomendado</div>
                  <div id="resultadoTexto" class="result-main">Ingresa sexo y altura.</div>
                </div>
                <div id="resultadoNum" class="result-num">-</div>
              </div>
            </div>

            <div id="conductBox" class="conduct-box conduct-mid">
              <div id="conductTitle" class="conduct-title">Interpretación</div>
              <div id="conductText">Completa sexo y altura. Si además conoces el diámetro bronquial izquierdo, podrás ajustar mejor el tamaño del TDL.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="algo-wrap">
              <div class="algo-title">Guía práctica en anestesia</div>
              <div class="algo-main">El TDL izquierdo es la elección habitual y la posición debe confirmarse siempre con fibrobroncoscopio</div>

              <div class="algo-grid">
                <div class="algo-card">
                  <div class="algo-label">Elección del lado</div>
                  <div class="algo-text">El TDL izquierdo es el estándar</div>
                  <div class="algo-soft">Se prefiere porque el bronquio fuente izquierdo tiene trayecto más largo hasta la primera emergencia lobar, lo que entrega mayor margen de seguridad para el lumen bronquial.</div>
                </div>

                <div class="algo-card">
                  <div class="algo-label">TDL derecho</div>
                  <div class="algo-text">Reservarlo para casos seleccionados</div>
                  <div class="algo-soft">Considerarlo si existe cirugía sobre bronquio izquierdo, distorsión anatómica izquierda, compresión, tumor o razones quirúrgicas específicas. El bronquio derecho ofrece menos margen y es más fácil ocluir el lóbulo superior.</div>
                </div>

                <div class="algo-card">
                  <div class="algo-label">Confirmación</div>
                  <div class="algo-text">La fibrobroncoscopía no es opcional</div>
                  <div class="algo-soft">La auscultación sola no basta. Verifica posición del lumen traqueal y bronquial, y confirma que no ocluyes bronquios lobares.</div>
                </div>

                <div class="algo-card">
                  <div class="algo-label">Cuff bronquial</div>
                  <div class="algo-text">Inflar solo lo necesario</div>
                  <div class="algo-soft">El cuff bronquial debe insuflarse con el volumen mínimo que logre sellado adecuado. Si puedes, controla presión de inflado para evitar lesión mucosa o sobreinflado.</div>
                </div>

                <div class="algo-card">
                  <div class="algo-label">Cambio de posición</div>
                  <div class="algo-text">Revisar siempre después de mover al paciente</div>
                  <div class="algo-soft">Después del decúbito lateral o de reposicionamiento quirúrgico, la posición del TDL puede cambiar. Reconfirmar con fibrobroncoscopio es una conducta obligada.</div>
                </div>

                <div class="algo-card">
                  <div class="algo-label">Si ventila mal</div>
                  <div class="algo-text">Primero piensa en malposición</div>
                  <div class="algo-soft">Ante hipoventilación, fuga, mala exclusión pulmonar o dificultad de insuflar un pulmón, la causa más probable es desplazamiento o posición incorrecta del TDL hasta demostrar lo contrario.</div>
                </div>

                <div class="algo-card">
                  <div class="algo-label">Perla docente</div>
                  <div class="algo-text">El mayor TDL que el paciente tolere suele funcionar mejor</div>
                  <div class="algo-soft">Un tubo demasiado pequeño ventila peor, dificulta broncoscopía y puede aislar mal. Pero un tubo excesivamente grande aumenta riesgo de trauma. Por eso la talla y, si existe, el diámetro bronquial son útiles juntos.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. La elección definitiva del TDL debe integrar anatomía, cirugía, imágenes, experiencia del operador y disponibilidad de fibrobroncoscopio.
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

function getCheckedValue(name){
  const el = document.querySelector('input[name="' + name + '"]:checked');
  return el ? el.value : '';
}

function recomendarPorTalla(sexo, altura){
  if(sexo === 'hombre'){
    if(altura > 170) return '41 Fr';
    if(altura >= 160) return '39 Fr';
    return '37-39 Fr';
  }
  if(sexo === 'mujer'){
    if(altura > 160) return '37 Fr';
    if(altura >= 150) return '35 Fr';
    return '32-35 Fr';
  }
  return '-';
}

function recomendarPorDiametro(d){
  if(isNaN(d) || d <= 0) return null;
  if(d >= 12) return '41 Fr';
  if(d >= 11.5) return '39 Fr';
  if(d >= 10.5) return '37 Fr';
  if(d >= 10) return '35 Fr';
  return '35 Fr o menor / reconsiderar anatomía';
}

function doMath(){
  const sexo = getCheckedValue('sexo');
  const altura = parseFloat(document.getElementById('altura').value);
  const diametro = parseFloat(document.getElementById('diametro').value);
  const lado = getCheckedValue('lado') || 'izquierdo';

  const resultadoNum = document.getElementById('resultadoNum');
  const resultadoTexto = document.getElementById('resultadoTexto');
  const box = document.getElementById('conductBox');
  const title = document.getElementById('conductTitle');
  const text = document.getElementById('conductText');

  if(!sexo || isNaN(altura) || altura <= 0){
    resultadoNum.textContent = '-';
    resultadoTexto.textContent = 'Ingresa sexo y altura.';
    box.className = 'conduct-box conduct-mid';
    title.textContent = 'Interpretación';
    text.textContent = 'Completa sexo y altura. Si además conoces el diámetro bronquial izquierdo, podrás ajustar mejor el tamaño del TDL.';
    return;
  }

  const tallaSug = recomendarPorTalla(sexo, altura);
  const diamSug = recomendarPorDiametro(diametro);

  resultadoNum.textContent = diamSug ? diamSug : tallaSug;
  resultadoTexto.textContent = diamSug
    ? 'El diámetro bronquial sugiere ' + diamSug + '; compáralo con la recomendación por talla (' + tallaSug + ').'
    : 'Recomendación inicial por sexo y talla: ' + tallaSug;

  if(lado === 'izquierdo'){
    box.className = 'conduct-box conduct-ok';
    title.textContent = 'Elección habitual';
    text.innerHTML = 'El <strong>TDL izquierdo</strong> es la opción habitual. Confirma posición con fibrobroncoscopio, insufla el cuff bronquial con el volumen mínimo necesario y vuelve a revisar la posición tras movilizar al paciente.';
  } else {
    box.className = 'conduct-box conduct-no';
    title.textContent = 'Lado derecho: usar con indicación';
    text.innerHTML = 'El <strong>TDL derecho</strong> debe reservarse para situaciones anatómicas o quirúrgicas justificadas. Requiere especial cuidado por la relación con la emergencia del lóbulo superior derecho y una verificación broncoscópica aún más estricta.';
  }
}

document.addEventListener('DOMContentLoaded', function(){
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
