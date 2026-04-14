<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Resumen práctico para preparación y programación de analgesia epidural obstétrica con modalidad PIEB/PCEA. Incluye receta de preparación, parámetros habituales de programación y perlas docentes sobre outcomes clínicos.";
$formula = "PIEB habitual: solución de bupivacaína 0,0625% + fentanilo 2 µg/mL. Programación frecuente: 0 - 9/10 - 45/60. PCEA habitual: bolos de 10 mL con lockout de 10 minutos.";
$referencias = array(
  "1.- Wong CA. Patient-controlled epidural analgesia for labor. Anesth Analg. 2009; International Anesthesia Research Society.",
  "2.- Chestnut DH. Obstetric Anesthesia: Principles and Practice.",
  "3.- Wong CA, McCarthy RJ y cols. Estudios comparativos entre PIEB, PCEA y CIE en analgesia obstétrica.",
  "4.- Documentos docentes locales de analgesia obstétrica."
);

$icono_apunte = "<i class='fa-solid fa-syringe pe-3 pt-2'></i>";
$titulo_apunte = "Preparación y Programación PIEB";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="pieb-shell">

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
            --mint:#e8f8f2;
            --mint-border:#bfe6d7;
            --rose:#f8eef4;
            --rose-border:#e7c8d7;
          }

          body{background:var(--bg);}
          .pieb-shell{max-width:980px;margin:0 auto;}

          .topbar{
            background:linear-gradient(135deg,var(--brand),var(--brand2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }
          .topbar h1{color:#fff;}

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

          .section-box{
            background:#fff;
            border:1px solid #e5e9f2;
            border-radius:18px;
            padding:16px;
            box-shadow:0 8px 20px rgba(0,0,0,.05);
          }

          .section-title-ui{
            font-weight:700;
            font-size:1.02rem;
            color:#27458f;
            margin-bottom:14px;
          }

          .prep-steps{
            display:grid;
            grid-template-columns:1fr;
            gap:1rem;
          }

          .prep-card{
            background:var(--mint);
            border:1px solid var(--mint-border);
            border-radius:1rem;
            padding:1rem;
          }

          .prep-step-label{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#64748b;
            margin-bottom:.45rem;
          }

          .prep-step-main{
            font-size:1.1rem;
            font-weight:800;
            color:#1f2a37;
            line-height:1.3;
          }

          .program-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:1rem;
          }

          .program-card{
            background:var(--soft);
            border:1px solid var(--line);
            border-radius:1rem;
            padding:1rem;
            text-align:center;
          }

          .program-label{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#667085;
            margin-bottom:.45rem;
          }

          .program-value{
            font-size:1.7rem;
            font-weight:800;
            color:#27458f;
            line-height:1.1;
          }

          .program-sub{
            font-size:.9rem;
            color:#667085;
            margin-top:.35rem;
            line-height:1.4;
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
            font-size:1.7rem;
            font-weight:800;
            text-align:center;
            color:#1f2a37;
            line-height:1.15;
            margin-bottom:1.2rem;
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
            text-align:left;
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
            font-weight:700;
          }
          .teaching-soft{
            font-size:.95rem;
            line-height:1.55;
            color:#667085;
            font-weight:500;
            margin-top:.35rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.15rem;
          }
          .tip-list li{
            margin-bottom:.45rem;
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

          @media(max-width:768px){
            .program-grid{
              grid-template-columns:1fr;
            }
          }

          @media(max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .teaching-main{font-size:1.35rem;}
            .program-value{font-size:1.45rem;}
            .prep-step-main{font-size:1rem;}
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • analgesia obstétrica</div>
              <h1 class="h3 mb-2">Preparación de solución PIEB</h1>
              <div class="subtle text-white-50">Con programación habitual de PIEB/PCEA y outcomes docentes.</div>
            </div>
            <span class="pill bg-light text-dark">PIEB</span>
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

        <div class="section-box mb-4">
          <div class="section-title-ui">Preparación de la solución PIEB con Bupivacaína 0,0625% + Fentanyl 2 µg/mL</div>

          <div class="prep-steps">
            <div class="prep-card">
              <div class="prep-step-label">Paso 1</div>
              <div class="prep-step-main">Extraer <strong>16,5 mL</strong> de un matraz de <strong>100 mL</strong>.</div>
            </div>

            <div class="prep-card">
              <div class="prep-step-label">Paso 2</div>
              <div class="prep-step-main">Agregar <strong>12,5 mL de bupivacaína</strong> (<strong>62,5 mg</strong>).</div>
            </div>

            <div class="prep-card">
              <div class="prep-step-label">Paso 3</div>
              <div class="prep-step-main">Agregar <strong>200 µg de fentanyl</strong>.</div>
            </div>

            <div class="prep-card">
              <div class="prep-step-label">Paso 4</div>
              <div class="prep-step-main">No olvidar <strong>rotular</strong> y <strong>registrar</strong> la preparación.</div>
            </div>
          </div>
        </div>

        <div class="section-box mb-4">
          <div class="section-title-ui">Programación habitual PIEB</div>

          <div class="program-grid">
            <div class="program-card">
              <div class="program-label">Infusión continua</div>
              <div class="program-value">0 mL/h</div>
              <div class="program-sub">Sin infusión basal continua.</div>
            </div>

            <div class="program-card">
              <div class="program-label">PIEB</div>
              <div class="program-value">9-10 mL</div>
              <div class="program-sub">Bolo programado cada <strong>45-60 min</strong>.</div>
            </div>

            <div class="program-card">
              <div class="program-label">PCEA</div>
              <div class="program-value">10 mL</div>
              <div class="program-sub">Bolo administrado por paciente con <strong>lockout 10 min</strong>.</div>
            </div>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Notas docentes</div>
              <div class="teaching-main">En analgesia epidural obstétrica, el volumen y la forma de administración importan tanto como la droga</div>

              <div class="teaching-grid">

                <div class="teaching-card">
                  <div class="teaching-label">PCEA</div>
                  <div class="teaching-text">La infusión continua reduce intervenciones no programadas, pero aumenta consumo total de anestésico local</div>
                  <div class="teaching-soft">
                    <ul class="tip-list">
                      <li>Reduce el número de intervenciones médicas no programadas.</li>
                      <li>Mejoraría la analgesia respecto a usar solo bolos.</li>
                      <li>Sin diferencias en satisfacción materna.</li>
                      <li>Aumentaría el consumo total de AALL, sin reportes de aumento de toxicidad.</li>
                    </ul>
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Ropivacaína vs Bupivacaína</div>
                  <div class="teaching-text">La ropivacaína suele dar mejor movilidad; la bupivacaína más bloqueo motor</div>
                  <div class="teaching-soft">
                    <ul class="tip-list">
                      <li>Mayor incidencia de bloqueo motor con bupivacaína.</li>
                      <li>Mayor score de movilidad con ropivacaína.</li>
                      <li>Sin diferencias en satisfacción materna ni scores de analgesia.</li>
                      <li>Más rescates con bupi en primera etapa de TP y más rescates con ropi en segunda.</li>
                    </ul>
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Volumen y lockout</div>
                  <div class="teaching-text">Más volumen y lockout corto suelen funcionar mejor</div>
                  <div class="teaching-soft">
                    <ul class="tip-list">
                      <li>Mayor volumen mejora analgesia.</li>
                      <li>Mayor tasa de éxito con lockout cortos.</li>
                      <li>Sin diferencias en número de intervenciones no programadas.</li>
                      <li>Sin reportes de aumento de toxicidad.</li>
                      <li>No existe un volumen o lockout ideal universal.</li>
                      <li>Bolos mayores de anestésico diluido mejoran analgesia y satisfacción comparados con bolos pequeños en pacientes sin infusión.</li>
                    </ul>
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Concentración de drogas</div>
                  <div class="teaching-text">Más concentración no necesariamente significa mejor analgesia</div>
                  <div class="teaching-soft">
                    <ul class="tip-list">
                      <li>Sin diferencias en eficacia analgésica ni satisfacción materna.</li>
                      <li>Mayor bloqueo motor con mayor concentración y mayor consumo de drogas.</li>
                      <li>El prurito asociado a opioides es dosis dependiente.</li>
                    </ul>
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">PIEB vs CIE</div>
                  <div class="teaching-text">PIEB logra distribución más uniforme con menos consumo total</div>
                  <div class="teaching-soft">
                    <ul class="tip-list">
                      <li>Analgesia similar.</li>
                      <li>Satisfacción materna equivalente.</li>
                      <li>Menor cantidad de intervenciones no programadas.</li>
                      <li>Menor consumo total de bupivacaína.</li>
                      <li>Mecanismo probable: extensión más uniforme al usar mayores volúmenes intermitentes.</li>
                    </ul>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="warn-box mb-3">
          <strong>Perla para residentes:</strong><br>
          La ventaja práctica del PIEB no es solo “gastar menos droga”, sino lograr una <strong>distribución epidural más homogénea</strong>. Piensa en volumen, cobertura de raíces y menor necesidad de rescates.
        </div>

        <div class="good-box mb-3">
          <strong>Perla de programación:</strong><br>
          Un esquema habitual y simple de recordar es <strong>0 - 9/10 - 45/60</strong>: sin basal, bolos programados de 9-10 mL cada 45-60 minutos, y PCEA de 10 mL con lockout de 10 minutos.
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. No reemplaza protocolos locales, criterio del equipo obstétrico-anestésico ni supervisión de staff.
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
</script>

<?php
require("footer.php");
?>