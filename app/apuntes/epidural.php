<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Resumen práctico de dosis habituales para analgesia epidural, top up epidural y analgesia combinada espinal/epidural en trabajo de parto. Incluye además manejo del catéter intratecal accidental y recomendaciones prácticas para optimizar la calidad analgésica.";
$formula = "Las dosis deben titularse según dilatación cervical, dolor materno, respuesta clínica, nivel sensitivo y contexto obstétrico. Este apunte resume esquemas habituales de uso docente.";
$referencias = array(
  "1.- Chestnut DH. Obstetric Anesthesia: Principles and Practice.",
  "2.- Gambling DR, Douglas MJ. Obstetric Anesthesia and Uncommon Disorders.",
  "3.- Sociedad de Anestesiología de Chile. Documentos docentes y recomendaciones de analgesia obstétrica.",
  "4.- Wong CA. Labour analgesia: regional techniques."
);

$icono_apunte = "<i class='fa-solid fa-baby pe-3 pt-2'></i>";
$titulo_apunte = "Analgesia Epidural en Trabajo de Parto";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="ob-shell">

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
            --rose:#f8eef4;
            --rose-border:#e7c8d7;
          }

          body{background:var(--bg);}
          .ob-shell{max-width:980px;margin:0 auto;}

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

          .table-block-title{
            font-weight:700;
            color:#1f2a37;
            margin-bottom:10px;
            margin-top:2px;
          }

          .dose-table{
            font-size:.94rem;
          }
          .dose-table th{
            background:#f8fafc;
            white-space:nowrap;
          }
          .dose-table td,.dose-table th{
            vertical-align:middle;
            text-align:center;
          }

          .table-pill{
            display:inline-block;
            min-width:54px;
            padding:.2rem .5rem;
            border-radius:999px;
            font-weight:700;
            background:#eef3ff;
            color:#27458f;
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

          .rose-box{
            background:var(--rose);
            border:1px solid var(--rose-border);
            border-radius:1rem;
            padding:1rem;
          }

          .warn-box{
            background:var(--warn);
            border:1px solid #ecd798;
            border-radius:1rem;
            padding:1rem;
          }

          .good-box{
            background:var(--good);
            border:1px solid #cfe8e6;
            border-radius:1rem;
            padding:1rem;
          }

          .tip-list{
            margin:0;
            padding-left:1.15rem;
          }
          .tip-list li{
            margin-bottom:.55rem;
          }

          @media(max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .dose-table{font-size:.82rem;}
            .teaching-main{font-size:1.35rem;}
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • analgesia obstétrica</div>
              <h1 class="h3 mb-2">Analgesia epidural / combinada en trabajo de parto</h1>
              <div class="subtle text-white-50">Dosis iniciales, refuerzos, analgesia combinada y perlas docentes para residentes.</div>
            </div>
            <span class="pill bg-light text-dark">Obstetricia</span>
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

        <div class="section-box mb-4">
          <div class="section-title-ui">Dosis habituales</div>

          <div class="table-block-title">Dosis epidural inicial (volumen total aproximado: 20 mL)</div>
          <div class="table-responsive mb-4">
            <table class="table table-bordered dose-table mb-0">
              <thead>
                <tr>
                  <th>Dilatación</th>
                  <th>Bupi (mg)</th>
                  <th>L-Bupi (mg)</th>
                  <th>Ropi (mg)</th>
                  <th>Fentanilo (µg)</th>
                  <th>Epi (µg)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="table-pill">1-4</span></td>
                  <td>10</td>
                  <td>12,5</td>
                  <td>15</td>
                  <td>50-100</td>
                  <td>10-20</td>
                </tr>
                <tr>
                  <td><span class="table-pill">4-8</span></td>
                  <td>12,5</td>
                  <td>15</td>
                  <td>20</td>
                  <td>50-100</td>
                  <td>10-20</td>
                </tr>
                <tr>
                  <td><span class="table-pill">&gt;8</span></td>
                  <td>15-20</td>
                  <td>17,5-25</td>
                  <td>25-30</td>
                  <td>50-100</td>
                  <td>10-20</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="table-block-title">Top up epidural (refuerzo) (volumen total aproximado: 10-15 mL)</div>
          <div class="table-responsive mb-4">
            <table class="table table-bordered dose-table mb-0">
              <thead>
                <tr>
                  <th>Dilatación</th>
                  <th>Bupi (mg)</th>
                  <th>L-Bupi (mg)</th>
                  <th>Ropi (mg)</th>
                  <th>Lido (mg)</th>
                  <th>Fentanilo (µg)</th>
                  <th>Epi (µg)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="table-pill">2-6</span></td>
                  <td>10</td>
                  <td>12,5</td>
                  <td>15</td>
                  <td>60</td>
                  <td>20</td>
                  <td>10</td>
                </tr>
                <tr>
                  <td><span class="table-pill">6-8</span></td>
                  <td>12,5</td>
                  <td>15</td>
                  <td>17,5</td>
                  <td>80</td>
                  <td>20</td>
                  <td>10-20</td>
                </tr>
                <tr>
                  <td><span class="table-pill">&gt;8</span></td>
                  <td>15-20</td>
                  <td>17,5-25</td>
                  <td>25-30</td>
                  <td>100</td>
                  <td>20</td>
                  <td>20</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="table-block-title">Dosis intratecal inicial (analgesia combinada espinal/epidural)</div>
          <div class="table-responsive">
            <table class="table table-bordered dose-table mb-0">
              <thead>
                <tr>
                  <th>Dilatación</th>
                  <th>Bupi (mg)</th>
                  <th>L-Bupi (mg)</th>
                  <th>Ropi (mg)</th>
                  <th>Fentanilo (µg)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="table-pill">&lt;4 cm</span></td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>20-25</td>
                </tr>
                <tr>
                  <td><span class="table-pill">&lt;4 cm</span></td>
                  <td>1</td>
                  <td>1-1,25</td>
                  <td>1,5</td>
                  <td>10-20</td>
                </tr>
                <tr>
                  <td><span class="table-pill">&gt;4 cm</span></td>
                  <td>2,5</td>
                  <td>3,75</td>
                  <td>4-5</td>
                  <td>20</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Tips para residentes</div>
              <div class="teaching-main">Una buena analgesia obstétrica depende más del seguimiento y titulación que de “poner el catéter y salir”</div>

              <div class="teaching-grid">

                <div class="teaching-card">
                  <div class="teaching-label">Troubleshooting epidural</div>
                  <div class="teaching-text">Si el alivio es insuficiente, primero evalúa:</div>
                  <div class="teaching-soft">
                    Busca nivel sensitivo y motor bilateral. Luego puede darse un bolo de <strong>bupivacaína 0,125-0,25% (7 a 10 mL)</strong> y aumentar velocidad de infusión y dosis máxima horaria si es necesario.<br>
                    Considera un segundo bolo. Si la paciente no siente alivio y no se explica por progresión rápida del trabajo de parto, sospecha instalación intravascular y considera una dosis de prueba con epinefrina <strong>(15 µg)</strong>.<br>
                    Si es negativa, tratar con una dosis mayor de bupivacaína 0,25% o considerar retirar parcialmente o cambiar el catéter, previa discusión con el staff.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Segunda etapa del parto</div>
                  <div class="teaching-text">El dolor sacro puede requerir un bolo inicial de mayor volumen</div>
                  <div class="teaching-soft">
                    Para alivio del dolor durante la segunda etapa del trabajo de parto:
                    <ul class="tip-list mt-2">
                      <li>10 mL de bupivacaína 0,25% si el dolor es importante.</li>
                      <li>10 mL de bupivacaína 0,125% si el dolor es moderado.</li>
                      <li>Puede ser necesario utilizar <strong>un bolo inicial con volúmenes mayores</strong> para cubrir raíces sacras.</li>
                    </ul>
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Alta calidad analgésica</div>
                  <div class="teaching-text">No te vayas hasta lograr una contracción sin dolor</div>
                  <div class="teaching-soft">
                    Las claves para una analgesia de alta calidad son:
                    <ul class="tip-list mt-2">
                      <li>No dejar a la paciente hasta que tenga una contracción sin dolor después de colocar el catéter.</li>
                      <li>Visitar a la paciente cada 1-2 horas y preguntar por EVA y movilidad de las piernas.</li>
                      <li>Doctorar o reemplazar el catéter que no esté funcionando bien.</li>
                    </ul>
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Punción dural accidental</div>
                  <div class="teaching-text">De preferencia, usar el catéter intratecal si el contexto lo permite</div>
                  <div class="teaching-soft">
                    Si ocurre una punción de duramadre-aracnoides, se puede dejar el catéter intratecal y usar pequeñas dosis intermitentes de bupivacaína <strong>1-2,5 mg</strong>, o reemplazar el catéter puncionando en otro espacio. De preferencia, la primera alternativa.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Catéter intratecal accidental</div>
                  <div class="teaching-text">Puede usarse si hubo punción accidental de duramadre-aracnoides</div>
                  <div class="teaching-soft">
                    Dosis inicial sugerida: <strong>bupivacaína 1-2,5 mg + fentanilo 15-20 µg</strong>.<br>
                    Dosis sucesivas: <strong>bupivacaína 1-2 mg en bolos</strong>, titulando a efecto.<br>
                    Usa jeringas nuevas en cada bolo, rótulalo con letras grandes como <strong>CATÉTER INTRATECAL</strong>, sigue la evolución y evalúa si hace cefalea.<br>
                    Cuando ya no se use, hazle un nudo y séllalo. Retíralo a las 24 horas. Avisa a todos los potenciales involucrados.
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="good-box mb-3">
          <strong>Perla docente:</strong> En analgesia obstétrica, memorizar solo la “receta” sirve poco. Lo realmente importante es entender <strong>qué volumen usar, en qué etapa del trabajo de parto, qué raíces quieres cubrir, y cómo titular según respuesta clínica</strong>.
        </div>

        <div class="footer-note">
          Herramienta docente y de apoyo clínico. No reemplaza protocolos locales, juicio clínico ni supervisión de staff en analgesia obstétrica.
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