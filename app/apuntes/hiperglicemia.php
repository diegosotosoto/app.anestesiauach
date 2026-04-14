<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Resumen práctico para manejo perioperatorio de la hiperglicemia, orientado a decisiones en pabellón. Incluye metas glicémicas, evaluación inicial de necesidad de insulina EV, cálculo de corrección subcutánea, conducta en usuarios de GLP-1 RA y perlas para residentes.";
$formula = "Corrección SC: (Glicemia medida - 100) / factor de sensibilidad. Factor de sensibilidad = 1800 / TDD. Si no se conoce la TDD, puede usarse 40 como referencia. En procedimientos con alta variabilidad metabólica o duración prolongada debe preferirse infusión EV.";
$referencias = array(
  "1.- Perioperative Hyperglycemia Management: An Update. Anesthesiology. March 2017.",
  "2.- Recomendaciones docentes personales de manejo perioperatorio de glicemia intraoperatoria.",
  "3.- Algoritmos de ayuno y conducta perioperatoria en usuarios de agonistas GLP-1."
);

$icono_apunte = "<i class='fa-solid fa-droplet pe-3 pt-2'></i>";
$titulo_apunte = "Glicemia intraoperatoria e insulina EV";

$boton_toggler = "<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity:.1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='navbar-toggler text-white shadow-sm' onclick='toggleInfo()' style='width:50px; height:40px; --bs-border-opacity:.1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="gly-shell">

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
          .gly-shell{max-width:980px;margin:0 auto;}

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
            margin-bottom:1rem;
          }

          .section-title-ui{
            font-weight:700;
            font-size:1.02rem;
            color:#27458f;
            margin-bottom:14px;
          }

          .badges-row{
            display:flex;
            flex-wrap:wrap;
            gap:.5rem;
          }

          .info-pill{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:.45rem .8rem;
            border-radius:999px;
            font-size:.82rem;
            font-weight:700;
            background:#eef3ff;
            color:#27458f;
            border:1px solid #dbe6ff;
          }

          .choice-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:.7rem;
          }

          .choice-check{display:none;}

          .choice-btn{
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            min-height:58px;
            border:1px solid #dfe7f2;
            background:#fff;
            border-radius:14px;
            padding:.75rem .8rem;
            font-weight:700;
            color:#1f2a37;
            cursor:pointer;
            transition:.15s ease;
            line-height:1.2;
          }

          .choice-check:checked + .choice-btn{
            background:#eef3ff;
            border-color:#9fb9f8;
            color:#27458f;
            box-shadow:0 0 0 2px rgba(39,69,143,.05) inset;
          }

          .calc-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:1rem;
          }

          .result-box{
            border-radius:1rem;
            border:1px solid var(--line);
            background:var(--soft);
            padding:1rem;
          }

          .result-main{
            font-size:1.02rem;
            font-weight:700;
            color:var(--text);
          }

          .result-num{
            font-size:1.8rem;
            font-weight:800;
            line-height:1;
            color:#3559b7;
          }

          .meta-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:.75rem;
          }

          .meta-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.9rem;
          }

          .meta-label{
            font-size:.76rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#667085;
            margin-bottom:.25rem;
          }

          .meta-value{
            font-size:1rem;
            font-weight:700;
            color:#1f2a37;
            line-height:1.35;
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
            font-size:1.05rem;
            font-weight:800;
            color:#1f2a37;
            margin-bottom:.55rem;
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
            font-size:1.65rem;
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

          .mint-box{
            background:var(--mint);
            border:1px solid var(--mint-border);
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

          .danger-box{
            background:var(--danger);
            border:1px solid #efc4be;
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

          .img-card{
            background:#fff;
            border:1px solid #e6e9ef;
            border-radius:1rem;
            padding:.8rem;
          }

          .img-card img{
            width:100%;
            height:auto;
            display:block;
            border-radius:.7rem;
          }

          @media(max-width:576px){
            .info-box-header{flex-direction:row;}
            .info-toggle-btn{margin-left:auto;}
            .teaching-main{font-size:1.3rem;}
            .calc-grid{grid-template-columns:1fr;}
            .meta-grid{grid-template-columns:1fr;}
            .choice-grid{grid-template-columns:1fr 1fr;}
          }
          .check-item{
            display:flex;
            align-items:center;
            gap:.6rem;
            background:#ffffff;
            border:1px solid #dbe4f0;
            border-radius:.6rem;
            padding:.5rem .7rem;
            font-size:.92rem;
          }

          .check-item i{
            color:#22c55e; /* verde check */
            font-size:.85rem;
          }
          .info-box-blue{
            background:#eef4ff;
            border:1px solid #cfe1ff;
            border-radius:1rem;
            padding:1rem;
          }

          .check-item-blue{
            display:flex;
            align-items:center;
            gap:.6rem;
            background:#ffffff;
            border:1px solid #d6e4ff;
            border-radius:.6rem;
            padding:.5rem .7rem;
            font-size:.92rem;
          }

          .check-item-blue i{
            color:#3b82f6; /* azul */
            font-size:.9rem;
          }

          .section-collapsible{
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 8px 20px rgba(0,0,0,.05);
            background:#fff;
            border:1px solid #e5e9f2;
          }

          .section-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:14px 16px;
            cursor:pointer;
            background:#f8fafc;
          }

          .section-header:hover{
            background:#eef2f8;
          }

          .section-arrow{
            transition:transform .25s ease;
            color:#667085;
          }

          .section-content{
            display:none;
            padding:16px;
            border-top:1px solid #e5e9f2;
          }

          .section-open .section-content{
            display:block;
          }

          .section-open .section-arrow{
            transform:rotate(180deg);
          }
          .subsection-card{
            background:#fbfcfe;
            border:1px solid #e3eaf4;
            border-radius:1rem;
            padding:1rem;
            margin-bottom:1rem;
          }

          .subsection-head{
            display:flex;
            align-items:center;
            gap:.65rem;
            margin-bottom:.9rem;
            padding-bottom:.65rem;
            border-bottom:1px solid #e7edf5;
          }

          .subsection-icon{
            width:38px;
            height:38px;
            border-radius:.8rem;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#eef4ff;
            color:#27458f;
            font-size:1rem;
            flex:0 0 auto;
          }

          .subsection-title{
            font-size:1.02rem;
            font-weight:800;
            color:#1f2a37;
            line-height:1.2;
          }

          .subsection-subtitle{
            font-size:.82rem;
            color:#667085;
            margin-top:.1rem;
            line-height:1.3;
          }
          .section-header.flash-highlight{
            background:#eaf2ff !important;
            box-shadow:0 0 0 2px rgba(53, 89, 183, .18) inset, 0 0 18px rgba(53, 89, 183, .10);
            transition:background .2s ease, box-shadow .2s ease;
          }
        </style>

        <div class="topbar">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="small opacity-75 mb-1">APP clínica • hiperglicemia perioperatoria</div>
              <h1 class="h3 ms-2 mb-2">Manejo de Glicemia e Insulina Perioperatoria</h1>
              <div class="subtle text-white-50">Manejo farmacológico preoperatorio, conducta intra y postoperatoria</div>
            </div>
            <span class="pill bg-light text-dark">Metabolismo</span>
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

              <hr>

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

        <div class="section-box">
<div class="info-box-blue mb-3">
  <strong>Puntos clave</strong>

  <div class="mt-2 d-flex flex-column gap-2">

    <div class="check-item-blue">
      <i class="fa-solid fa-circle-info"></i>
      <span>Ayuno normal: 70-100 mg/dL</span>
    </div>

    <div class="check-item-blue">
      <i class="fa-solid fa-circle-info"></i>
      <span>Target perioperatorio: 140-180 mg/dL</span>
    </div>

    <div class="check-item-blue">
      <i class="fa-solid fa-circle-info"></i>
      <span>Control Insulina SC: mínimo cada 2 h</span>
    </div>

    <div class="check-item-blue">
      <i class="fa-solid fa-circle-info"></i>
      <span>Control Insulina en infusión EV: horario</span>
    </div>

  </div>
</div>

          <div class="mint-box mb-3">
            <strong>Impacto clínico:</strong><br>
            La hiperglicemia perioperatoria se asocia a complicaciones de herida, infecciones, eventos renales, pulmonares y mayor mortalidad. Puede persistir varios días después de la cirugía.
          </div>

          <div class="warn-box">
            <strong>Ojo:</strong><br>
            Usuarios de inhibidores SGLT2 o gliflozinas pueden presentar cetoacidosis en el postoperatorio, incluso sin glicemias extremadamente altas.
          </div>
        </div>







<div class="section-collapsible mb-3">

  <div class="section-header" onclick="toggleSection(this)">
    <div class="section-title-ui mb-0">Preoperatorio</div>
    <i class="fa-solid fa-chevron-down section-arrow"></i>
  </div>

  <div class="section-content">



  <div class="section-title-ui">Manejo preoperatorio</div>

  <div class="mint-box mb-3">
    <strong>Idea clave:</strong><br>
    La conducta depende del riesgo quirúrgico, la ingesta oral esperada y el tipo de fármaco.
    En cirugías mayores o con cambios hemodinámicos → conducta más conservadora.
  </div>


<div class="subsection-card">
  <div class="subsection-head">
    <div class="subsection-icon">
      <i class="fa-solid fa-pills"></i>
    </div>
    <div>
      <div class="subsection-title">Antidiabéticos orales</div>
      <div class="subsection-subtitle">Suspensión o continuación según tipo de fármaco y magnitud quirúrgica</div>
    </div>
  </div>

  <div class="table-responsive mb-2">
    <table class="table table-bordered dose-table mb-0">
      <thead>
        <tr>
          <th>Fármaco</th>
          <th>Día previo</th>
          <th>Día cirugía<br><span class="small-note">Cirugía menor</span></th>
          <th>Día cirugía<br><span class="small-note">Cirugía mayor / ↓ VO</span></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <strong>Secretagogos</strong><br>
            <span class="small-note">Ej: sulfonilureas, meglitinidas</span>
          </td>
          <td>Tomar</td>
          <td>Suspender</td>
          <td>Suspender</td>
        </tr>
        <tr>
          <td>
            <strong>SGLT-2</strong><br>
            <span class="small-note">Ej: gliflozinas</span>
          </td>
          <td>Suspender</td>
          <td>Suspender</td>
          <td>Suspender</td>
        </tr>
        <tr>
          <td>
            <strong>Tiazolidinedionas</strong><br>
            <span class="small-note">Ej: pioglitazona</span>
          </td>
          <td>Tomar</td>
          <td>Tomar</td>
          <td>Suspender</td>
        </tr>
        <tr>
          <td>
            <strong>Metformina</strong><br>
            <span class="small-note">Biguanida</span>
          </td>
          <td>Tomar*</td>
          <td>Tomar*</td>
          <td>Suspender</td>
        </tr>
        <tr>
          <td>
            <strong>iDPP-4</strong><br>
            <span class="small-note">Ej: sitagliptina, linagliptina</span>
          </td>
          <td>Tomar</td>
          <td>Tomar</td>
          <td>Tomar</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="small-note">
    * Suspender metformina si se utilizará contraste EV o TFG &lt;45 ml/min.
  </div>
</div>




<div class="subsection-card">
  <div class="subsection-head">
    <div class="subsection-icon">
      <i class="fa-solid fa-utensils"></i>
    </div>
    <div>
      <div class="subsection-title">Usuarios de GLP-1 RA</div>
      <div class="subsection-subtitle">La conducta depende de síntomas digestivos y del tipo de ingesta previa</div>
    </div>
  </div>

  <div class="choice-grid mb-3">
    <div>
      <input class="choice-check" type="radio" name="glp1symptoms" id="glp1_no" value="no" checked>
      <label class="choice-btn" for="glp1_no">Sin síntomas significativos</label>
    </div>
    <div>
      <input class="choice-check" type="radio" name="glp1symptoms" id="glp1_yes" value="yes">
      <label class="choice-btn" for="glp1_yes">Con síntomas significativos</label>
    </div>
  </div>

  <div id="glp1IntakeBlock" class="mb-3">
    <label class="form-label fw-semibold">Tipo de ingesta previa</label>
    <div class="choice-grid">
      <div>
        <input class="choice-check" type="radio" name="glp1intake" id="glp1_solids" value="solids">
        <label class="choice-btn" for="glp1_solids">Sólidos</label>
      </div>
      <div>
        <input class="choice-check" type="radio" name="glp1intake" id="glp1_highcarb" value="highcarb">
        <label class="choice-btn" for="glp1_highcarb">Líquidos claros altos en H. de C.</label>
      </div>
      <div>
        <input class="choice-check" type="radio" name="glp1intake" id="glp1_lowcarb" value="lowcarb" checked>
        <label class="choice-btn" for="glp1_lowcarb">Líquidos claros sin / bajos en H. de C.</label>
      </div>
    </div>
  </div>

  <div id="glp1Conduct" class="conduct-box conduct-ok mb-3">
    <div id="glp1ConductTitle" class="conduct-title">Conducta</div>
    <div id="glp1ConductText">
      Si no hay síntomas significativos, puede continuarse el GLP-1 RA sin interrupción.
    </div>
  </div>

  <div class="meta-grid mb-3">
    <div class="meta-card">
      <div class="meta-label">Ayuno recomendado</div>
      <div id="glp1Fasting" class="meta-value">4 h</div>
    </div>
    <div class="meta-card">
      <div class="meta-label">Resumen</div>
      <div id="glp1Summary" class="meta-value">Líquidos claros con bajo o nulo contenido de glucosa.</div>
    </div>
  </div>

  <div class="small-note">
    Síntomas significativos: náuseas severas, vómitos o incapacidad para tolerar ingesta oral.
  </div>
</div>



<div class="subsection-card">
  <div class="subsection-head">
    <div class="subsection-icon">
      <i class="fa-solid fa-syringe"></i>
    </div>
    <div>
      <div class="subsection-title">Usuarios de insulina</div>
      <div class="subsection-subtitle">La basal se ajusta; la prandial se suspende al iniciar ayuno</div>
    </div>
  </div>

  <div class="mint-box mb-3">
    <strong>Idea clave:</strong><br>
    La insulina basal generalmente <strong>no se suspende completamente</strong>.
    En DM1 siempre debe mantenerse aporte basal. La insulina prandial se suspende al iniciar ayuno.
  </div>

  <div class="table-responsive mb-3">
    <table class="table table-bordered dose-table mb-0">
      <thead>
        <tr>
          <th>Situación</th>
          <th>Glargina / Detemir</th>
          <th>NPH o 70/30</th>
          <th>Rápidas / regular</th>
          <th>No insulínicos inyectables</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <strong>Día previo</strong><br>
            <span class="small-note">Dieta normal hasta medianoche</span>
          </td>
          <td>AM: dosis habitual<br>PM: 80% de la dosis habitual</td>
          <td>AM: 80% de la dosis habitual<br>PM: 80% de la dosis habitual</td>
          <td>Dosis habitual</td>
          <td>Dosis habitual</td>
        </tr>
        <tr>
          <td>
            <strong>Día previo</strong><br>
            <span class="small-note">Preparación intestinal / líquidos claros 12–24 h</span>
          </td>
          <td>AM: dosis habitual<br>PM: 80% de la dosis habitual</td>
          <td>AM: 80% de la dosis habitual<br>PM: 80% de la dosis habitual</td>
          <td>Dosis habitual</td>
          <td>Suspender al iniciar dieta líquida / bowel prep</td>
        </tr>
        <tr>
          <td>
            <strong>Día de cirugía</strong><br>
            <span class="small-note">Conducta general</span>
          </td>
          <td>80% de la dosis habitual si usa basal matinal o 2 veces al día</td>
          <td>50% de la dosis habitual si glicemia ≥120 mg/dL<br>Suspender si glicemia &lt;120 mg/dL</td>
          <td>Suspender</td>
          <td>Suspender</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="calc-grid mb-3">
    <div class="good-box">
      <strong>DM2</strong><br><br>
      <ul class="tip-list mb-0">
        <li>Glargina: disminuir 25% la noche previa o la dosis del día.</li>
        <li>NPH: usar 50% el día de la cirugía.</li>
        <li>No colocar NPH si glicemia &lt;120 mg/dL.</li>
      </ul>
    </div>

    <div class="warn-box">
      <strong>DM1</strong><br><br>
      <ul class="tip-list mb-0">
        <li>Usar 80% de la dosis basal la noche anterior y en la mañana.</li>
        <li>Suspender insulina prandial al comenzar ayuno.</li>
        <li>Si glicemia perioperatoria ≥180 mg/dL, requieren corrección SC.</li>
        <li>Alto riesgo de complicaciones si se suspende completamente la basal.</li>
        <li>Control cada 2 horas.</li>
      </ul>
    </div>
  </div>

  <div class="small-note">
    NPH = neutral protamine Hagedorn. La conducta final debe ajustarse a tipo de diabetes, horario habitual de insulina, ayuno real y riesgo quirúrgico.
  </div>
</div>





</div>
</div>








<div class="section-collapsible mb-3">

  <div class="section-header" onclick="toggleSection(this)">
    <div class="section-title-ui mb-0">Intraoperatorio</div>
    <i class="fa-solid fa-chevron-down section-arrow"></i>
  </div>

  <div class="section-content">
        <div class="section-title mb-3">INTRAOPERATORIO</div>
          <div class="section-title-ui">Paso 1: ¿Cumple criterios de insulina EV?</div>

            <div class="good-box mb-3">
              <strong>Indicación de infusión EV:</strong>

              <div class="mt-2 d-flex flex-column gap-2">

                <div class="check-item">
                  <i class="fa-solid fa-check"></i>
                  <span>Cirugías prolongadas (&gt;4 h)</span>
                </div>

                <div class="check-item">
                  <i class="fa-solid fa-check"></i>
                  <span>Cambios hemodinámicos importantes</span>
                </div>

                <div class="check-item">
                  <i class="fa-solid fa-check"></i>
                  <span>Recambio significativo de volumen</span>
                </div>

                <div class="check-item">
                  <i class="fa-solid fa-check"></i>
                  <span>Cambios de temperatura</span>
                </div>

                <div class="check-item">
                  <i class="fa-solid fa-check"></i>
                  <span>Uso de inotrópicos</span>
                </div>

              </div>
            </div>

          <div class="choice-grid mb-3">
            <div>
              <input class="choice-check" type="radio" name="ivcriteria" id="iv_no" value="no" checked>
              <label class="choice-btn" for="iv_no">No cumple criterios</label>
            </div>
            <div>
              <input class="choice-check" type="radio" name="ivcriteria" id="iv_yes" value="yes">
              <label class="choice-btn" for="iv_yes">Sí cumple criterios</label>
            </div>
          </div>

          <div id="ivConduct" class="conduct-box conduct-mid mb-3">
            <div id="ivConductTitle" class="conduct-title">Conducta inicial</div>
            <div id="ivConductText">
              Si no hay criterios de alta variabilidad metabólica, puedes considerar corrección SC cuando la glicemia sea mayor a 180 mg/dL.
            </div>
          </div>




  <div class="section-title-ui">Paso 2: Estrategia interactiva según decisión inicial</div>

  <!-- BLOQUE EV -->
  <div id="step2EV" style="display:none;">
    <div class="good-box mb-3">
      <strong>Esquema de infusión EV</strong><br>
      Si la glicemia es <strong>&gt;180 mg/dL</strong>, iniciar infusión EV.<br>
      Considerar bolo: <strong>BG / 40</strong><br>
      Tasa inicial: <strong>BG / 100 = U/h</strong>
    </div>

    <div class="calc-grid">
      <div>
        <label class="form-label fw-semibold">Glicemia actual</label>
        <div class="input-group mb-3">
          <input type="number" step="1" min="0" id="evCurrentBg" class="form-control">
          <span class="input-group-text">mg/dL</span>
        </div>

        <label class="form-label fw-semibold">Glicemia previa</label>
        <div class="input-group mb-3">
          <input type="number" step="1" min="0" id="evPrevBg" class="form-control">
          <span class="input-group-text">mg/dL</span>
        </div>

        <label class="form-label fw-semibold">Tasa previa de infusión</label>
        <div class="input-group mb-3">
          <input type="number" step="0.1" min="0" id="evPrevRate" class="form-control">
          <span class="input-group-text">U/h</span>
        </div>
      </div>

      <div>
        <div class="result-box mb-3">
          <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
              <div class="small-note">Conducta sugerida</div>
              <div id="evResultText" class="result-main">Ingresa glicemia actual, previa y tasa previa.</div>
            </div>
            <div id="evResultNum" class="result-num">-</div>
          </div>
        </div>

        <div class="meta-grid">
          <div class="meta-card">
            <div class="meta-label">Bolo sugerido (x 1 vez al iniciar infusión)</div>
            <div id="evBolus" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Tasa inicial teórica</div>
            <div id="evInitialRate" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Cambio respecto previo</div>
            <div id="evDeltaText" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Control</div>
            <div class="meta-value">Horario</div>
          </div>
        </div>
      </div>
    </div>

    <div id="evDynamicConduct" class="conduct-box conduct-mid mt-3">
      <div id="evDynamicConductTitle" class="conduct-title">Interpretación</div>
      <div id="evDynamicConductText">
        La infusión EV se ajusta según glicemia actual y su cambio respecto de la medición previa.
      </div>
    </div>

  </div>

  <!-- BLOQUE SC -->
  <div id="step2SC">
    <div class="warn-box mb-3">
      <strong>Corrección subcutánea</strong><br>
      Usar cuando el caso <strong>no cumple criterios de infusión EV</strong> y la glicemia supera <strong>180 mg/dL</strong>.
    </div>

    <div class="calc-grid">
      <div>
        <label class="form-label fw-semibold">Glicemia actual</label>
        <div class="input-group mb-3">
          <input type="number" step="1" min="0" id="glyValue" class="form-control">
          <span class="input-group-text">mg/dL</span>
        </div>

        <label class="form-label fw-semibold">Tipo de referencia para TDD</label>
        <div class="choice-grid mb-3">
          <div>
            <input class="choice-check" type="radio" name="tddmode" id="tdd_unknown" value="unknown" checked>
            <label class="choice-btn" for="tdd_unknown">TDD desconocida</label>
          </div>
          <div>
            <input class="choice-check" type="radio" name="tddmode" id="tdd_known" value="known">
            <label class="choice-btn" for="tdd_known">TDD conocida</label>
          </div>
        </div>

        <label class="form-label fw-semibold">Dosis total diaria (TDD)</label>
        <div class="input-group">
          <input type="number" step="1" min="0" id="tddValue" class="form-control">
          <span class="input-group-text">UI/día</span>
        </div>
        <div class="small-note mt-2">Si no se conoce la TDD, se usa 40 como valor de referencia.</div>
      </div>

      <div>
        <div class="result-box mb-3">
          <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
              <div class="small-note">Dosis de corrección SC</div>
              <div id="corrText" class="result-main">Ingresa la glicemia actual.</div>
            </div>
            <div id="corrNum" class="result-num">-</div>
          </div>
        </div>

        <div class="meta-grid">
          <div class="meta-card">
            <div class="meta-label">TDD usada</div>
            <div id="metaTdd" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Factor de sensibilidad</div>
            <div id="metaFs" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Fórmula aplicada</div>
            <div id="metaFormula" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Control</div>
            <div id="metaControl" class="meta-value">Cada 2 h mínimo</div>
          </div>
        </div>
      </div>
    </div>

    <div id="corrConduct" class="conduct-box conduct-mid mt-3">
      <div id="corrConductTitle" class="conduct-title">Interpretación</div>
      <div id="corrConductText">No repetir insulina rápida antes de 2 horas por riesgo de acumulación. No dar más de 2 dosis SC en 4 horas.</div>
    </div>
  </div>

</div>
</div>





<div class="section-collapsible mb-3">

  <div class="section-header" onclick="toggleSection(this)">
    <div class="section-title-ui mb-0">Postoperatorio</div>
    <i class="fa-solid fa-chevron-down section-arrow"></i>
  </div>

  <div class="section-content">

    <div class="section-title-ui">Manejo postoperatorio</div>

    <div class="mint-box mb-3">
      <strong>Idea clave:</strong><br>
      En el postoperatorio, la estrategia depende de la <strong>tolerancia oral</strong> y de la <strong>sensibilidad a la insulina</strong>.
      Si BG &gt;180 mg/dL, sigue indicada corrección con insulina rápida.
    </div>

    <div class="calc-grid mb-3">
      <div>
        <label class="form-label fw-semibold">Peso</label>
        <div class="input-group mb-3">
          <input type="number" step="0.1" min="0" id="postopPeso" class="form-control">
          <span class="input-group-text">kg</span>
        </div>

        <label class="form-label fw-semibold">Tolerancia oral</label>
        <div class="choice-grid mb-3">
          <div>
            <input class="choice-check" type="radio" name="postop_oral" id="postop_npo" value="npo" checked>
            <label class="choice-btn" for="postop_npo">NPO / mala tolerancia</label>
          </div>
          <div>
            <input class="choice-check" type="radio" name="postop_oral" id="postop_vo" value="vo">
            <label class="choice-btn" for="postop_vo">VO normal</label>
          </div>
        </div>

        <label class="form-label fw-semibold">Perfil de sensibilidad a insulina</label>
        <div class="choice-grid">
          <div>
            <input class="choice-check" type="radio" name="postop_sens" id="postop_sensitive" value="sensitive">
            <label class="choice-btn" for="postop_sensitive">Sensible</label>
          </div>
          <div>
            <input class="choice-check" type="radio" name="postop_sens" id="postop_usual" value="usual" checked>
            <label class="choice-btn" for="postop_usual">Usual</label>
          </div>
          <div>
            <input class="choice-check" type="radio" name="postop_sens" id="postop_resistant" value="resistant">
            <label class="choice-btn" for="postop_resistant">Resistente</label>
          </div>
        </div>

        <div class="small-note mt-2">
          Sensible: edad &gt;70 años o TFG &lt;45 ml/min. <br>
          Resistente: BMI &gt;35 o prednisona ≥20 mg/día.
        </div>
      </div>

      <div>
        <div class="result-box mb-3">
          <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
              <div class="small-note">Esquema sugerido</div>
              <div id="postopSchemeText" class="result-main">Ingresa peso y selecciona tolerancia oral.</div>
            </div>
            <div id="postopSchemeNum" class="result-num">-</div>
          </div>
        </div>

        <div class="meta-grid">
          <div class="meta-card">
            <div class="meta-label">Dosis total diaria</div>
            <div id="postopTDD" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Factor usado</div>
            <div id="postopFactor" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Basal sugerida</div>
            <div id="postopBasal" class="meta-value">-</div>
          </div>
          <div class="meta-card">
            <div class="meta-label">Prandial / corrección</div>
            <div id="postopPrandial" class="meta-value">-</div>
          </div>
        </div>
      </div>
    </div>

    <div id="postopConduct" class="conduct-box conduct-mid mb-4">
      <div id="postopConductTitle" class="conduct-title">Interpretación</div>
      <div id="postopConductText">
        Selecciona el contexto clínico para estimar un esquema postoperatorio.
      </div>
    </div>

    <div class="table-block-title">Usuarios de bomba de insulina</div>

    <div class="calc-grid mb-3">
      <div class="good-box">
        <strong>Conducta general</strong><br><br>
        <ul class="tip-list mb-0">
          <li>Continuar infusión intraoperatoria en basal, o cambiar a infusión EV.</li>
          <li>Suspender si glicemia &lt;110 mg/dL.</li>
          <li>Reiniciar si glicemia &gt;180 mg/dL.</li>
          <li>Continuar con bomba en el postoperatorio, si el contexto clínico lo permite.</li>
        </ul>
      </div>

      <div class="warn-box">
        <strong>Perla práctica</strong><br><br>
        <ul class="tip-list mb-0">
          <li>Si el paciente usa bomba, no asumir que “se arregla sola”.</li>
          <li>Siempre verificar tasa basal, sitio de inserción, glicemias y posibilidad de continuar manejo seguro en recuperación o sala.</li>
        </ul>
      </div>
    </div>


    <div class="calc-grid mb-3">
      <div class="mint-box">
        <strong>Control</strong><br><br>
        <ul class="tip-list mb-0">
          <li>Privilegiar control por laboratorio central cuando sea posible.</li>
          <li>Interpretar en el contexto clínico y hemodinámico.</li>
          <li>Si el valor capilar no cuadra con el cuadro clínico, confirmar.</li>
        </ul>
      </div>
    </div>

    <div class="small-note mt-2">
      Si el paciente cae en más de una categoría, usa la <strong>dosis más baja</strong> para disminuir riesgo de hipoglicemia.
    </div>
  </div>
</div>

        <div class="section-card">
          <div class="p-3 p-md-4">
            <div class="teaching-wrap">
              <div class="teaching-title">Tips para residentes</div>
              <div class="teaching-main">La primera decisión no es “¿cuánta insulina SC doy?”, sino “¿este caso necesita vía EV?”</div>

              <div class="teaching-grid">
                <div class="teaching-card">
                  <div class="teaching-label">Meta</div>
                  <div class="teaching-text">No persigas normalidad estricta</div>
                  <div class="teaching-soft">
                    El target razonable es 140-180 mg/dL. Buscar glicemias “perfectas” puede aumentar riesgo de hipoglicemia.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Corrección SC</div>
                  <div class="teaching-text">No acumules insulina SC</div>
                  <div class="teaching-soft">
                    No repetir antes de 2 horas. No más de 2 dosis SC en 4 horas. Si el contexto es muy dinámico, cambia de estrategia en vez de insistir con bolos.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">Infusión EV</div>
                  <div class="teaching-text">Úsala cuando la fisiología es inestable</div>
                  <div class="teaching-soft">
                    Si hay cambios hemodinámicos, gran recambio de fluidos, inotrópicos, cambios de temperatura o cirugía larga, la infusión EV es más controlable que múltiples rescates SC.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">DM1</div>
                  <div class="teaching-text">Nunca dejes al DM1 sin basal</div>
                  <div class="teaching-soft">
                    El riesgo no es solo la hiperglicemia, también la cetosis y descompensación metabólica.
                  </div>
                </div>

                <div class="teaching-card">
                  <div class="teaching-label">GLP-1 RA</div>
                  <div class="teaching-text">Los síntomas cambian la conducta</div>
                  <div class="teaching-soft">
                    Náuseas severas, vómitos o mala tolerancia oral obligan a diferir cirugía y reevaluar prescripción, dieta y medicamentos.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="warn-box">
          <strong>Perla clínica:</strong> antes de corregir una glicemia intraoperatoria, piensa en el contexto completo:
          tipo de diabetes, duración quirúrgica, ayuno, uso previo de insulina, estabilidad hemodinámica y posibilidad de una evolución muy dinámica que haga preferible infusión EV.
        </div>

        <div class="footer-note mt-3">
          Herramienta docente y de apoyo clínico. Verificar siempre protocolos institucionales y situación clínica individual.
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

function round1(num){
  return Math.round(num * 10) / 10;
}

function updateIVDecision(){
  const mode = getSelected('ivcriteria');

  const box = document.getElementById('ivConduct');
  const title = document.getElementById('ivConductTitle');
  const text = document.getElementById('ivConductText');

  const step2EV = document.getElementById('step2EV');
  const step2SC = document.getElementById('step2SC');

  if(mode === 'yes'){
    box.className = 'conduct-box conduct-ok mb-3';
    title.textContent = 'Conducta inicial';
    text.innerHTML = 'Este caso <strong>sí cumple criterios de infusión EV</strong>. Usa control horario y ajusta la tasa según la tabla.';
    step2EV.style.display = 'block';
    step2SC.style.display = 'none';
  } else {
    box.className = 'conduct-box conduct-mid mb-3';
    title.textContent = 'Conducta inicial';
    text.innerHTML = 'Si no hay criterios de alta variabilidad metabólica, puedes considerar <strong>corrección SC</strong> cuando la glicemia sea mayor a 180 mg/dL.';
    step2EV.style.display = 'none';
    step2SC.style.display = 'block';
  }
}

function updateIVCalculator(){
  const currentBg = parseFloat(document.getElementById('evCurrentBg').value);
  const prevBg = parseFloat(document.getElementById('evPrevBg').value);
  const prevRate = parseFloat(document.getElementById('evPrevRate').value);

  const evResultNum = document.getElementById('evResultNum');
  const evResultText = document.getElementById('evResultText');
  const evBolus = document.getElementById('evBolus');
  const evInitialRate = document.getElementById('evInitialRate');
  const evDeltaText = document.getElementById('evDeltaText');
  const box = document.getElementById('evDynamicConduct');
  const title = document.getElementById('evDynamicConductTitle');
  const text = document.getElementById('evDynamicConductText');

  if(isNaN(currentBg) || currentBg <= 0){
    evResultNum.textContent = '-';
    evResultText.textContent = 'Ingresa glicemia actual, previa y tasa previa.';
    evBolus.textContent = '-';
    evInitialRate.textContent = '-';
    evDeltaText.textContent = '-';
    box.className = 'conduct-box conduct-mid mt-3';
    title.textContent = 'Interpretación';
    text.textContent = 'La infusión EV se ajusta según glicemia actual y su cambio respecto de la medición previa.';
    return;
  }

  const theoreticalBolus = currentBg > 180 ? round1(currentBg / 40) + ' UI' : 'No necesario';
  const theoreticalRate = currentBg > 180 ? round1(currentBg / 100) + ' U/h' : 'No necesario';

  evBolus.textContent = theoreticalBolus;
  evInitialRate.textContent = theoreticalRate;

  if(isNaN(prevBg) || prevBg <= 0 || isNaN(prevRate) || prevRate < 0){
    evResultNum.textContent = theoreticalRate;
    evResultText.textContent = currentBg > 180 ? 'Tasa inicial sugerida' : 'No iniciar infusión';
    evDeltaText.textContent = 'Sin dato previo';
    box.className = currentBg > 180 ? 'conduct-box conduct-ok mt-3' : 'conduct-box conduct-mid mt-3';
    title.textContent = 'Interpretación';
    text.innerHTML = currentBg > 180
      ? 'Si BG es <strong>>180 mg/dL</strong>, considera iniciar infusión EV. La tasa inicial aproximada es <strong>BG/100 U/h</strong>.'
      : 'Con esta glicemia no existe indicación automática de iniciar infusión EV según este esquema.';
    return;
  }

  const delta = currentBg - prevBg;
  evDeltaText.textContent = delta > 0 ? 'Aumentó ' + round1(delta) + ' mg/dL' : 'Disminuyó ' + round1(Math.abs(delta)) + ' mg/dL';

  let action = '';
  let newRate = prevRate;
  let conductClass = 'conduct-ok';
  let conductMsg = '';

  if(currentBg > 241){
    if(delta > 0){
      newRate = prevRate + 3;
      action = 'Subir +3 U/h';
    } else if(Math.abs(delta) < 30){
      newRate = prevRate + 3;
      action = 'Subir +3 U/h';
    } else {
      newRate = prevRate;
      action = 'Sin cambio';
    }
  } else if(currentBg >= 211 && currentBg <= 240){
    if(delta > 0){
      newRate = prevRate + 2;
      action = 'Subir +2 U/h';
    } else if(Math.abs(delta) < 30){
      newRate = prevRate + 2;
      action = 'Subir +2 U/h';
    } else {
      newRate = prevRate;
      action = 'Sin cambio';
    }
  } else if(currentBg >= 181 && currentBg <= 210){
    if(delta > 0){
      newRate = prevRate + 1;
      action = 'Subir +1 U/h';
    } else if(Math.abs(delta) < 30){
      newRate = prevRate + 1;
      action = 'Subir +1 U/h';
    } else {
      newRate = prevRate;
      action = 'Sin cambio';
    }
  } else if(currentBg >= 141 && currentBg <= 180){
    newRate = prevRate;
    action = 'Sin cambio';
  } else if(currentBg >= 110 && currentBg <= 140){
    if(delta > 0){
      newRate = prevRate;
      action = 'Sin cambio';
    } else if(Math.abs(delta) < 30){
      newRate = Math.max(0, prevRate - 0.5);
      action = 'Bajar -0,5 U/h';
    } else {
      newRate = 0;
      action = 'Suspender infusión';
    }
  } else if(currentBg >= 100 && currentBg <= 109){
    newRate = 0;
    action = 'Suspender infusión';
    conductClass = 'conduct-mid';
    conductMsg = 'Suspender infusión, controlar glicemia cada hora y reiniciar a la mitad de la tasa previa si BG >180 mg/dL.';
  } else if(currentBg >= 71 && currentBg <= 99){
    newRate = 0;
    action = 'Suspender infusión';
    conductClass = 'conduct-no';
    conductMsg = 'Suspender infusión. Control cada 30 min hasta BG >100 mg/dL. Luego retomar controles horarios. Reiniciar a la mitad de la tasa previa si BG >180 mg/dL.';
  } else if(currentBg <= 70){
    newRate = 0;
    action = 'Hipoglicemia';
    conductClass = 'conduct-no';

    if(currentBg >= 50){
      conductMsg = 'BG 50-70 mg/dL: administrar 25 mL de D50 y controlar cada 30 min hasta BG >100 mg/dL.';
    } else {
      conductMsg = 'BG <50 mg/dL: administrar 50 mL de D50, controlar cada 15 min hasta >70 mg/dL, luego cada 30 min hasta >100 mg/dL. Considerar repetir D50 e iniciar D10 si recurre.';
    }
  }

  evResultNum.textContent = action === 'Hipoglicemia' ? 'D50' : round1(newRate) + ' U/h';
  evResultText.textContent = action;

  if(!conductMsg){
    if(action.includes('Subir')){
      conductMsg = 'Ajuste sugerido según glicemia actual y tendencia respecto de la medición previa.';
    } else if(action === 'Sin cambio'){
      conductMsg = 'Mantener tasa actual y continuar control horario.';
    } else if(action === 'Suspender infusión'){
      conductMsg = 'Suspender infusión y vigilar estrechamente la evolución de la glicemia.';
    }
  }

  box.className = 'conduct-box ' + conductClass + ' mt-3';
  title.textContent = 'Interpretación';
  text.innerHTML = conductMsg;
}

function updateGLP1Decision(){
  const symptoms = getSelected('glp1symptoms');
  const intake = getSelected('glp1intake');

  const box = document.getElementById('glp1Conduct');
  const title = document.getElementById('glp1ConductTitle');
  const text = document.getElementById('glp1ConductText');
  const fasting = document.getElementById('glp1Fasting');
  const summary = document.getElementById('glp1Summary');
  const intakeBlock = document.getElementById('glp1IntakeBlock');

  if(symptoms === 'yes'){
    box.className = 'conduct-box conduct-no mb-3';
    title.textContent = 'Conducta';
    text.innerHTML = 'Si hay <strong>síntomas significativos</strong>, diferir cirugía y derivar al médico tratante para modificación de dieta y tratamiento.';
    fasting.textContent = 'No aplicar tabla';
    summary.textContent = 'Primero resolver síntomas y reevaluar.';
    intakeBlock.style.display = 'none';
    return;
  }

  intakeBlock.style.display = 'block';
  box.className = 'conduct-box conduct-ok mb-3';
  title.textContent = 'Conducta';
  text.innerHTML = 'Si no hay síntomas significativos, puede continuarse el <strong>GLP-1 RA</strong> sin interrupción y ajustar el ayuno según el tipo de ingesta.';

  if(intake === 'solids'){
    fasting.textContent = '24 h';
    summary.textContent = 'Ayuno de sólidos por 24 h. Solo se permiten líquidos claros.';
  } else if(intake === 'highcarb'){
    fasting.textContent = '8 h';
    summary.textContent = 'Líquidos claros con alto contenido de carbohidratos (≥10% glucosa): ayuno 8 h.';
  } else {
    fasting.textContent = '4 h';
    summary.textContent = 'Líquidos claros sin o con bajo contenido de carbohidratos (<10% glucosa): ayuno 4 h.';
  }
}

function updateCorrectionCalc(){
  const gly = parseFloat(document.getElementById('glyValue').value);
  const tddMode = getSelected('tddmode');
  let tdd = parseFloat(document.getElementById('tddValue').value);

  const corrNum = document.getElementById('corrNum');
  const corrText = document.getElementById('corrText');
  const metaTdd = document.getElementById('metaTdd');
  const metaFs = document.getElementById('metaFs');
  const metaFormula = document.getElementById('metaFormula');
  const box = document.getElementById('corrConduct');
  const title = document.getElementById('corrConductTitle');
  const text = document.getElementById('corrConductText');

  if(tddMode === 'unknown' || isNaN(tdd) || tdd <= 0){
    tdd = 40;
  }

  if(isNaN(gly) || gly <= 0){
    corrNum.textContent = '-';
    corrText.textContent = 'Ingresa la glicemia actual.';
    metaTdd.textContent = tdd + ' UI/día';
    metaFs.textContent = '-';
    metaFormula.textContent = '-';
    box.className = 'conduct-box conduct-mid mt-3';
    title.textContent = 'Interpretación';
    text.textContent = 'No repetir insulina rápida antes de 2 horas por riesgo de acumulación. No dar más de 2 dosis SC en 4 horas.';
    return;
  }

  const fs = 1800 / tdd;
  let dose = (gly - 100) / fs;

  metaTdd.textContent = round1(tdd) + ' UI/día';
  metaFs.textContent = round1(fs);
  metaFormula.textContent = '(' + round1(gly) + ' - 100) / ' + round1(fs);

  if(gly < 70){
    corrNum.textContent = '0';
    corrText.textContent = 'Hipoglicemia.';
    box.className = 'conduct-box conduct-no mt-3';
    title.textContent = 'No corregir con insulina';
    text.innerHTML = 'La glicemia es <strong>&lt;70 mg/dL</strong>. Maneja como hipoglicemia y confirma según contexto.';
    return;
  }

  if(gly < 140){
    corrNum.textContent = '0';
    corrText.textContent = 'Sin corrección.';
    box.className = 'conduct-box conduct-ok mt-3';
    title.textContent = 'Dentro o cerca de meta';
    text.innerHTML = 'No requiere corrección. Mantén vigilancia y recontrol según contexto.';
    return;
  }

  if(gly < 180){
    corrNum.textContent = '0';
    corrText.textContent = 'Observación y control.';
    box.className = 'conduct-box conduct-ok mt-3';
    title.textContent = 'Sobre meta, pero sin umbral de corrección';
    text.innerHTML = 'Target perioperatorio habitual: <strong>140-180 mg/dL</strong>. Reevalúa y controla.';
    return;
  }

  if(dose < 0) dose = 0;
  const finalDose = round1(dose);

  corrNum.textContent = finalDose;
  corrText.textContent = 'UI de insulina rápida SC';

  if(gly >= 250){
    box.className = 'conduct-box conduct-mid mt-3';
    title.textContent = 'Considera si basta la vía subcutánea';
    text.innerHTML = 'Si el procedimiento es largo, hay cambios hemodinámicos, recambio de volumen, temperatura o inotrópicos, considera <strong>infusión EV</strong> más que seguir acumulando bolos SC.';
  } else {
    box.className = 'conduct-box conduct-ok mt-3';
    title.textContent = 'Corrección SC razonable';
    text.innerHTML = 'Controlar al menos cada <strong>2 horas</strong>. No repetir antes de 2 horas y no dar más de 2 dosis SC en 4 horas.';
  }
}

function updatePostopCalc(){
  const peso = parseFloat(document.getElementById('postopPeso').value);
  const oral = getSelected('postop_oral');
  const sens = getSelected('postop_sens');

  const schemeNum = document.getElementById('postopSchemeNum');
  const schemeText = document.getElementById('postopSchemeText');
  const tddBox = document.getElementById('postopTDD');
  const factorBox = document.getElementById('postopFactor');
  const basalBox = document.getElementById('postopBasal');
  const prandialBox = document.getElementById('postopPrandial');
  const conductBox = document.getElementById('postopConduct');
  const conductTitle = document.getElementById('postopConductTitle');
  const conductText = document.getElementById('postopConductText');

  if(isNaN(peso) || peso <= 0){
    schemeNum.textContent = '-';
    schemeText.textContent = 'Ingresa peso y selecciona tolerancia oral.';
    tddBox.textContent = '-';
    factorBox.textContent = '-';
    basalBox.textContent = '-';
    prandialBox.textContent = '-';
    conductBox.className = 'conduct-box conduct-mid mb-4';
    conductTitle.textContent = 'Interpretación';
    conductText.textContent = 'Selecciona el contexto clínico para estimar un esquema postoperatorio.';
    return;
  }

  let factor = 0.2;
  let factorLabel = '0.2–0.25 U/kg/día';

  if(sens === 'sensitive'){
    factor = 0.125;
    factorLabel = '0.1–0.15 U/kg/día';
  } else if(sens === 'resistant'){
    factor = 0.3;
    factorLabel = '0.3 U/kg/día';
  }

  const tdd = peso * factor;

  if(oral === 'npo'){
    const basal = tdd;
    schemeNum.textContent = 'Basal +';
    schemeText.textContent = 'Esquema basal plus';
    tddBox.textContent = tdd.toFixed(1).replace('.', ',') + ' U/día';
    factorBox.textContent = factorLabel;
    basalBox.textContent = basal.toFixed(1).replace('.', ',') + ' U/día basal';
    prandialBox.textContent = 'Corrección rápida si BG >180 mg/dL';

    conductBox.className = 'conduct-box conduct-ok mb-4';
    conductTitle.textContent = 'Conducta sugerida';
    conductText.innerHTML = 'Como el paciente está <strong>NPO o con mala tolerancia oral</strong>, usar <strong>basal plus</strong>: basal (glargina/detemir) más corrección con rápida si BG &gt;180 mg/dL.';
  } else {
    const basal = tdd * 0.5;
    const prandial = tdd * 0.5;
    const mealDose = prandial / 3;

    schemeNum.textContent = 'Basal-bolus';
    schemeText.textContent = 'Esquema basal bolus';
    tddBox.textContent = tdd.toFixed(1).replace('.', ',') + ' U/día';
    factorBox.textContent = factorLabel;
    basalBox.textContent = basal.toFixed(1).replace('.', ',') + ' U/día basal';
    prandialBox.textContent = prandial.toFixed(1).replace('.', ',') + ' U/día prandial (~' + mealDose.toFixed(1).replace('.', ',') + ' U por comida)';

    conductBox.className = 'conduct-box conduct-ok mb-4';
    conductTitle.textContent = 'Conducta sugerida';
    conductText.innerHTML = 'Como el paciente tiene <strong>ingesta oral normal</strong>, usar <strong>basal bolus</strong>: 50% basal y 50% prandial, más corrección si BG &gt;180 mg/dL.';
  }
}



document.addEventListener('DOMContentLoaded', function(){
  document.getElementById('glyValue').addEventListener('input', updateCorrectionCalc);
  document.getElementById('tddValue').addEventListener('input', updateCorrectionCalc);
  document.getElementById('evCurrentBg').addEventListener('input', updateIVCalculator);
  document.getElementById('evPrevBg').addEventListener('input', updateIVCalculator);
  document.getElementById('evPrevRate').addEventListener('input', updateIVCalculator);
document.getElementById('postopPeso').addEventListener('input', updatePostopCalc);

document.querySelectorAll('input[name="postop_oral"]').forEach(el => {
  el.addEventListener('change', updatePostopCalc);
});

document.querySelectorAll('input[name="postop_sens"]').forEach(el => {
  el.addEventListener('change', updatePostopCalc);
});

    document.querySelectorAll('input[name="glp1intake"]').forEach(el => {
    el.addEventListener('change', updateGLP1Decision);
  });

  document.querySelectorAll('input[name="tddmode"]').forEach(el => {
    el.addEventListener('change', updateCorrectionCalc);
  });

  document.querySelectorAll('input[name="ivcriteria"]').forEach(el => {
    el.addEventListener('change', updateIVDecision);
  });

  document.querySelectorAll('input[name="glp1symptoms"]').forEach(el => {
    el.addEventListener('change', updateGLP1Decision);
  });

  updateCorrectionCalc();
  updateIVDecision();
  updateGLP1Decision();
  updateCorrectionCalc();
  updateIVDecision();
  updateGLP1Decision();
  updateIVCalculator();
  updatePostopCalc();
});



function toggleSection(el){
  const parent = el.closest(".section-collapsible");
  const isOpen = parent.classList.contains("section-open");

  document.querySelectorAll(".section-collapsible").forEach(sec => {
    sec.classList.remove("section-open");
  });

  if(!isOpen){
    parent.classList.add("section-open");
  }

  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      const top = el.getBoundingClientRect().top + window.scrollY - 10;

      window.scrollTo({
        top: top
      });

      el.classList.remove("flash-highlight");
      void el.offsetWidth; // reinicia animación
      el.classList.add("flash-highlight");

      setTimeout(() => {
        el.classList.remove("flash-highlight");
      }, 900);
    });
  });
}
</script>

<?php
require("footer.php");
?>