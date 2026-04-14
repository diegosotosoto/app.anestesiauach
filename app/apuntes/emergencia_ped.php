<?php

$titulo_info = "Utilidad Clínica";
$descripcion_info = "Guía rápida para estimar dosis de fármacos y parámetros útiles en una emergencia pediátrica. Los resultados se actualizan automáticamente al ingresar peso, talla y edad. Mantiene la exportación a PDF para impresión o archivo.";
$formula = "";
$referencias = array(
  "1.- Planilla Unidad Paciente Crítico Pediátrico. Hospital Clínico Regional Valdivia.",
  "2.- Cote CJ, Lerman J, Anderson BJ. A Practice of Anesthesia for Infants and Children. Pocket Reference Guide.",
  "3.- Planilla Unidad Paciente Crítico Pediátrico. Hospital Clínico Universidad Católica.",
  "4.- Andropoulos DB, Bent ST, Skjonsby B, Stayer SA. The optimal length of insertion of central venous catheters for pediatric patients. Anesth Analg. 2001;93:883-886.",
  "5.- PALS / rangos fisiológicos pediátricos usuales para referencia clínica."
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
            --brand:#21409a;
            --brand-2:#3359c9;
            --brand-3:#eaf0ff;
            --bg:#f4f7fc;
            --surface:#ffffff;
            --soft:#f8fbff;
            --line:#d9e3f1;
            --text:#1f2a37;
            --muted:#667085;
            --danger-soft:#fff1f2;
            --warn-soft:#fff8e6;
            --ok-soft:#eefbf3;
            --blue-soft:#eef4ff;
          }

          body{
            background:var(--bg);
          }

          .ped-shell{
            max-width:1100px;
            margin:0 auto;
          }

          .ped-hero{
            background:linear-gradient(135deg,var(--brand),var(--brand-2));
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 14px 34px rgba(33,64,154,.18);
            padding:1.15rem 1.25rem;
            margin-bottom:1rem;
            overflow:hidden;
          }

          .ped-hero h1{
            color:#fff;
            margin-bottom:.35rem;
          }

          .hero-kicker{
            font-size:.78rem;
            letter-spacing:.06em;
            text-transform:uppercase;
            opacity:.82;
            margin-bottom:.35rem;
          }

          .hero-subtitle{
            color:rgba(255,255,255,.82);
            font-size:.95rem;
            margin-bottom:0;
          }

          .hero-badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:86px;
            height:34px;
            border-radius:.75rem;
            background:rgba(255,255,255,.16);
            color:#fff;
            font-weight:700;
            font-size:.82rem;
            border:1px solid rgba(255,255,255,.16);
          }

          .section-card{
            background:var(--surface);
            border:1px solid rgba(214,223,237,.7);
            border-radius:1.15rem;
            box-shadow:0 10px 28px rgba(15,23,42,.05);
            overflow:hidden;
            margin-bottom:1rem;
          }

          .section-inner{
            padding:1rem 1rem 1.05rem 1rem;
          }

          .section-title{
            font-size:.78rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:var(--muted);
            margin-bottom:.85rem;
            font-weight:700;
          }

          .section-subtle{
            font-size:.88rem;
            color:var(--muted);
          }

          .info-card-head{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:1rem;
            padding:1rem;
          }

          .info-toggle-btn{
            border:none;
            border-radius:.7rem;
            min-width:120px;
            height:36px;
            background:#5d6b85;
            color:#fff;
            font-size:.84rem;
            font-weight:600;
          }

          .info-toggle-btn:hover{
            background:#4b5870;
            color:#fff;
          }

          .info-content{
            display:none;
            padding:0 1rem 1rem 1rem;
            border-top:1px solid #edf2f8;
            animation:fadeIn .18s ease-in-out;
          }

          @keyframes fadeIn{
            from{opacity:0; transform:translateY(-4px);}
            to{opacity:1; transform:translateY(0);}
          }

          .mini-note{
            font-size:.82rem;
            color:var(--muted);
          }

          .field-label{
            font-size:.9rem;
            font-weight:700;
            color:var(--text);
            margin-bottom:.4rem;
          }

          .control-box{
            background:var(--soft);
            border:1px solid var(--line);
            border-radius:1rem;
            padding:.9rem;
            height:100%;
          }

          .input-clean{
            border-radius:.8rem;
            border:1px solid #d7dfeb;
            min-height:42px;
          }

          .input-clean:focus{
            box-shadow:none;
            border-color:#7d98df;
          }

          .unit-btn-group{
            display:flex;
            gap:.45rem;
          }

          .unit-btn{
            width:46px;
            height:42px;
            border-radius:.7rem;
            border:1px solid #cfd8e7;
            background:#fff;
            color:#475467;
            font-size:.8rem;
            font-weight:700;
            padding:0;
          }

          .unit-btn.active-years{
            background:#e8f0ff;
            color:#2243a4;
            border-color:#9cb4ee;
          }

          .unit-btn.active-months{
            background:#fff3d8;
            color:#9a5a00;
            border-color:#e3be69;
          }

          .summary-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:.75rem;
          }

          .summary-chip{
            background:linear-gradient(180deg,#ffffff,#f8fbff);
            border:1px solid var(--line);
            border-radius:1rem;
            padding:.85rem .9rem;
            min-height:84px;
          }

          .summary-k{
            font-size:.74rem;
            letter-spacing:.07em;
            text-transform:uppercase;
            color:var(--muted);
            margin-bottom:.35rem;
            font-weight:700;
          }

          .summary-v{
            font-size:1.05rem;
            font-weight:800;
            color:var(--text);
            line-height:1.15;
          }

          .summary-s{
            font-size:.8rem;
            color:var(--muted);
            margin-top:.2rem;
          }

          .results-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:1rem;
          }

          .stack-card{
            background:var(--soft);
            border:1px solid var(--line);
            border-radius:1rem;
            padding:1rem;
          }

          .stack-card.blue{ background:var(--blue-soft); }
          .stack-card.warn{ background:var(--warn-soft); }
          .stack-card.ok{ background:var(--ok-soft); }
          .stack-card.danger{ background:var(--danger-soft); }

          .result-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:.8rem;
            padding:.72rem .8rem;
            background:#fff;
            border:1px solid #e6edf7;
            border-radius:.85rem;
            margin-bottom:.6rem;
          }

          .result-row:last-child{
            margin-bottom:0;
          }

          .result-left{
            min-width:0;
          }

          .result-name{
            font-weight:700;
            color:var(--text);
            line-height:1.15;
          }

          .result-note{
            font-size:.78rem;
            color:var(--muted);
            margin-top:.18rem;
            line-height:1.2;
          }

          .result-value-wrap{
            min-width:150px;
          }

          .input-group-sm .form-control,
          .input-group-sm .input-group-text{
            min-height:36px;
          }

          .callout{
            border-radius:1rem;
            padding:.95rem 1rem;
            border:1px solid #dbe5f3;
            background:#f9fbff;
            font-size:.88rem;
            color:#415168;
          }

          .callout strong{
            color:#22324d;
          }

          .tip-list{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:.8rem;
          }

          .tip-card{
            border:1px solid var(--line);
            border-radius:1rem;
            background:#fff;
            padding:.9rem;
            height:100%;
          }

          .tip-title{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:var(--muted);
            margin-bottom:.45rem;
            font-weight:700;
          }

          .tip-card ul{
            padding-left:1rem;
            margin-bottom:0;
          }

          .tip-card li{
            margin-bottom:.35rem;
            color:#334155;
            font-size:.88rem;
          }

          .print-bar{
            display:flex;
            justify-content:center;
            align-items:center;
            gap:.75rem;
            flex-wrap:wrap;
          }

          .btn-pdf{
            min-height:42px;
            border-radius:.85rem;
            font-weight:700;
            padding:.55rem 1rem;
          }

          .footer-note{
            font-size:.82rem;
            color:#6b7280;
            margin-top:.35rem;
          }

          .small-ref{
            font-size:.83rem;
          }

          @media (max-width: 992px){
            .summary-grid{
              grid-template-columns:repeat(2,1fr);
            }
            .tip-list{
              grid-template-columns:1fr;
            }
          }

          @media (max-width: 768px){
            .results-grid{
              grid-template-columns:1fr;
            }
          }

          @media (max-width: 576px){
            .summary-grid{
              grid-template-columns:1fr 1fr;
            }
            .hero-badge{
              min-width:auto;
            }
            .info-card-head{
              align-items:flex-start;
            }
          }
        </style>

        <div class="ped-hero">
          <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
            <div>
              <div class="hero-kicker">Apunte clínico • cálculo automático</div>
              <h1 class="h3">Dosis de Emergencia Pediátrica</h1>
              <p class="hero-subtitle">Dosis útiles, parámetros fisiológicos orientativos y exportación directa a PDF para impresión o archivo.</p>
            </div>
            <div class="hero-badge">Pediatría</div>
          </div>
        </div>

        <div class="section-card">
          <div class="info-card-head">
            <div>
              <div class="section-title mb-1">Utilidad y referencias</div>
              <div class="section-subtle">Mostrar / ocultar utilidad clínica, advertencias y referencias del apunte.</div>
            </div>
            <button type="button" onclick="toggleInfo()" class="info-toggle-btn" id="infoToggleBtn">
              Mostrar
            </button>
          </div>

          <div id="infoContent" class="info-content">
            <div class="mb-3"><?php echo $descripcion_info; ?></div>

            <div class="callout mb-3">
              <strong>Importante:</strong> La frecuencia cardíaca y la presión arterial mostradas corresponden a valores orientativos esperables para un niño <strong>despierto y en reposo</strong>. En un paciente dormido, anestesiado o en reposo profundo, la presión arterial puede ser aproximadamente <strong>20% menor que el basal</strong>.
            </div>

            <?php if(!empty($referencias)){ ?>
              <div class="small-ref">
                <b>Referencias:</b>
                <ul class="mt-2 mb-0">
                  <?php foreach($referencias as $ref){ ?>
                    <li><?php echo $ref; ?></li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
          </div>
        </div>

        <form id="formPDF" method="post" action="https://anestesiauach.cl/pdf/emergencia_ped_pdf.php" target="_blank">

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Datos de entrada</div>

              <div class="row g-3">
                <div class="col-12 col-md-4">
                  <div class="control-box">
                    <label class="field-label">Peso</label>
                    <div class="input-group">
                      <input class="form-control input-clean calc-trigger" type="number" id="peso" name="peso" value="" placeholder="Ej: 18">
                      <span class="input-group-text">kg</span>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4">
                  <div class="control-box">
                    <label class="field-label">Talla</label>
                    <div class="input-group">
                      <input class="form-control input-clean calc-trigger" type="number" id="talla" name="talla" value="" placeholder="Ej: 105">
                      <span class="input-group-text">cm</span>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4">
                  <div class="control-box">
                    <label class="field-label">Edad</label>
                    <div class="row g-2 align-items-stretch">
                      <div class="col-8">
                        <div class="input-group" id="edadInput">
                          <input type="number" id="edad" name="edad" class="form-control input-clean calc-trigger" placeholder="Edad">
                          <span class="input-group-text" id="edadUnit">años</span>
                          <input type="hidden" id="hiddenInput" name="anios" value="1">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="unit-btn-group justify-content-end">
                          <button class="unit-btn active-years" id="btnYears" type="button" title="Edad en años">A</button>
                          <button class="unit-btn" id="btnMonths" type="button" title="Edad en meses">M</button>
                        </div>
                      </div>
                    </div>
                    <div class="mini-note mt-2">A = años / M = meses</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Resumen del paciente</div>
              <div class="summary-grid">
                <div class="summary-chip">
                  <div class="summary-k">Peso</div>
                  <div class="summary-v" id="resumenPeso">—</div>
                  <div class="summary-s">Dato ingresado</div>
                </div>
                <div class="summary-chip">
                  <div class="summary-k">Talla</div>
                  <div class="summary-v" id="resumenTalla">—</div>
                  <div class="summary-s">Dato ingresado</div>
                </div>
                <div class="summary-chip">
                  <div class="summary-k">Edad</div>
                  <div class="summary-v" id="resumenEdad">—</div>
                  <div class="summary-s" id="resumenEdadUnidad">Sin dato</div>
                </div>
                <div class="summary-chip">
                  <div class="summary-k">Grupo etario</div>
                  <div class="summary-v" id="grupoEtario">—</div>
                  <div class="summary-s">Referencia fisiológica</div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Exportar</div>
                <div class="print-bar justify-content-center">
                  <button type="button" class="btn btn-primary shadow-sm btn-pdf" onclick="envioFormPDF()">
                    <i class="fa-solid fa-file-pdf pe-2"></i>Imprimir PDF
                  </button>
                </div>
            </div>
          </div>

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Parámetros generales</div>

              <div class="results-grid">

                <div class="stack-card ok">
                  <div class="result-row">
                    <div class="result-left">
                      <div class="result-name">FC normal para la edad</div>
                      <div class="result-note">Paciente despierto y en reposo</div>
                    </div>
                    <div class="result-value-wrap input-group input-group-sm">
                      <input class="form-control" id="fcNormal" readonly>
                      <span class="input-group-text">lpm</span>
                    </div>
                  </div>

                  <div class="result-row">
                    <div class="result-left">
                      <div class="result-name">PA normal para la edad</div>
                      <div class="result-note">Paciente despierto y en reposo</div>
                    </div>
                    <div class="result-value-wrap input-group input-group-sm">
                      <input class="form-control" id="paNormal" readonly>
                      <span class="input-group-text">mmHg</span>
                    </div>
                  </div>
                </div>




                
                <div class="stack-card ok">
                  <div class="result-row">
                    <div class="result-left">
                      <div class="result-name">Superficie corporal</div>
                    </div>
                    <div class="result-value-wrap input-group input-group-sm">
                      <input class="form-control" type="number" id="resultado1" readonly>
                      <span class="input-group-text">m²</span>
                    </div>
                  </div>

                  <div class="result-row">
                    <div class="result-left">
                      <div class="result-name">Distancia CVC</div>
                      <div class="result-note">Desde vena yugular interna derecha</div>
                    </div>
                    <div class="result-value-wrap input-group input-group-sm">
                      <input class="form-control" type="number" id="distanciaCVC" readonly>
                      <span class="input-group-text">cm</span>
                    </div>
                  </div>
                </div>

              </div>

              <div class="callout mt-3">
                <strong>Recordatorio:</strong> estos valores hemodinámicos son una guía clínica para un niño despierto y en reposo. En sueño, sedación o anestesia la PA puede ser hasta <strong>20% menor que el basal</strong>, por lo que siempre debe interpretarse en contexto clínico.
              </div>
            </div>
          </div>

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Tubo y distancia</div>
              <div class="results-grid">
                <div class="stack-card blue">
                  <div class="result-row">
                    <div class="result-left">
                      <div class="result-name">Tubo endotraqueal</div>
                      <div class="result-note">Estimación orientativa para tubo con cuff</div>
                    </div>
                    <div class="result-value-wrap input-group input-group-sm">
                      <input class="form-control" id="resultadoX" readonly>
                      <span class="input-group-text">ID</span>
                    </div>
                  </div>
                </div>

                <div class="stack-card blue">
                  <div class="result-row">
                    <div class="result-left">
                      <div class="result-name">Distancia a boca</div>
                      <div class="result-note">Profundidad orientativa desde labios</div>
                    </div>
                    <div class="result-value-wrap input-group input-group-sm">
                      <input class="form-control" id="resultadoX2" readonly>
                      <span class="input-group-text">cm</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Fármacos de emergencia</div>

              <div class="results-grid">
                <div class="stack-card danger">
                  <div class="result-row"><div class="result-left"><div class="result-name">Atropina</div><div class="result-note">Bradicardia sintomática</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="atropina" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Bicarbonato 8%</div><div class="result-note">No usar de rutina en PCR</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="bicarbonato" readonly><span class="input-group-text">mL</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Epinefrina (PCR)</div><div class="result-note">Verificar concentración antes de administrar</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="epinefrina" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Calcio cloruro 10%</div><div class="result-note">Preferir vía segura; mayor irritación tisular</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="calcioCl" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Calcio gluconato 10%</div><div class="result-note">Menos irritante que CaCl</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="calcioGl" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Adenosina</div><div class="result-note">Bolo rápido + flush inmediato</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="adenosina" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Amiodarona</div><div class="result-note">Taquiarritmias seleccionadas</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="amiodarona" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Lidocaína</div><div class="result-note">Alternativa según contexto</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="lidocaina" readonly><span class="input-group-text">mg</span></div></div>
                </div>

                <div class="stack-card warn">
                  <div class="result-row"><div class="result-left"><div class="result-name">Rocuronio (2 DE95)</div><div class="result-note">Intubación</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="rocuronio" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Midazolam</div><div class="result-note">Valorar contexto hemodinámico</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="midazolam" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Fentanyl (inducción)</div><div class="result-note">Cuidado con rigidez de pared torácica</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="fentaInd" readonly><span class="input-group-text">µg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Fentanyl (analgesia)</div><div class="result-note">Titular según dolor y contexto</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="fentaAna" readonly><span class="input-group-text">µg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Morfina</div><div class="result-note">Vigilar depresión respiratoria</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="morfina" readonly><span class="input-group-text">mg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Glucosa 30%</div><div class="result-note">Corregir hipoglicemia con confirmación clínica</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="glucosa" readonly><span class="input-group-text">mL</span></div></div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Reversión</div>
              <div class="results-grid">
                <div class="stack-card blue">
                  <div class="result-row"><div class="result-left"><div class="result-name">Naloxona</div><div class="result-note">Reversión de opioides; evitar retiro brusco innecesario</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="naloxona" readonly><span class="input-group-text">µg</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Flumazenil</div><div class="result-note">Precaución en pacientes con riesgo convulsivo</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="flumazenil" readonly><span class="input-group-text">µg</span></div></div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-card">
            <div class="section-inner">
              <div class="section-title">Cardioversión / desfibrilación</div>

              <div class="results-grid">
                <div class="stack-card danger">
                  <div class="result-row"><div class="result-left"><div class="result-name">Cardioversión 1</div><div class="result-note">Energía inicial orientativa</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="cardiov" readonly><span class="input-group-text">J</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Desfibrilación 1</div><div class="result-note">Primera descarga</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="desfibr" readonly><span class="input-group-text">J</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Desfibrilación 2–3</div><div class="result-note">Escalamiento posterior</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="desfibr2" readonly><span class="input-group-text">J</span></div></div>
                  <div class="result-row"><div class="result-left"><div class="result-name">Desfibrilación 2–3</div><div class="result-note">Escalamiento posterior</div></div><div class="result-value-wrap input-group input-group-sm"><input class="form-control" type="number" id="desfibr2" readonly><span class="input-group-text">J</span></div></div>
                </div>
              </div>
            </div>
          </div>
        </form>

        <div class="section-card">
          <div class="section-inner">
            <div class="section-title">Tips docentes y de seguridad</div>

            <div class="tip-list">
              <div class="tip-card">
                <div class="tip-title">Seguridad farmacológica</div>
                <ul>
                  <li>Confirmar siempre si la dosis está en <strong>mg, µg o mL</strong>.</li>
                  <li>Antes de usar epinefrina, verificar <strong>concentración y dilución</strong>.</li>
                  <li>Si el contexto es crítico, idealmente hacer <strong>doble chequeo verbal</strong>.</li>
                </ul>
              </div>

              <div class="tip-card">
                <div class="tip-title">Interpretación clínica</div>
                <ul>
                  <li>La calculadora orienta, pero no reemplaza el juicio clínico.</li>
                  <li>La PA normal mostrada es para <strong>vigilia y reposo</strong>.</li>
                  <li>En anestesia o sueño profundo, una PA hasta 20% menor puede ser esperable.</li>
                </ul>
              </div>

              <div class="tip-card">
                <div class="tip-title">Docencia práctica</div>
                <ul>
                  <li>Usar el apunte como apoyo, no como sustituto de preparación previa.</li>
                  <li>En simulación, insistir en “<strong>indicación + dosis + vía + concentración</strong>”.</li>
                  <li>Para adenosina, entrenar siempre la secuencia: bolo rápido + flush inmediato.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="footer-note">
          Los cálculos se actualizan automáticamente. El formulario conserva el mismo identificador y la misma acción original para exportación PDF.
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleInfo(){
  const box = document.getElementById("infoContent");
  const btn = document.getElementById("infoToggleBtn");
  const isOpen = box.style.display === "block";
  box.style.display = isOpen ? "none" : "block";
  btn.textContent = isOpen ? "Mostrar" : "Ocultar";
}

function setFieldValue(id, value, decimals){
  const el = document.getElementById(id);
  if(!el) return;

  if(value === '' || value === null || value === undefined || (typeof value === 'number' && !isFinite(value))){
    el.value = '';
    return;
  }

  if(typeof value === 'string'){
    el.value = value;
    return;
  }

  el.value = Number(value).toFixed(decimals);
}

function clearFields(ids){
  ids.forEach(id => {
    const el = document.getElementById(id);
    if(el) el.value = '';
  });
}

function isYearsMode(){
  return document.getElementById('btnYears').classList.contains('active-years');
}

function getAgeInMonths(){
  const edad = parseFloat(document.getElementById('edad').value);
  if(isNaN(edad) || edad < 0) return null;
  return isYearsMode() ? edad * 12 : edad;
}

function getAgeDisplay(){
  const edad = parseFloat(document.getElementById('edad').value);
  if(isNaN(edad) || edad < 0) return '—';
  return isYearsMode() ? `${edad} años` : `${edad} meses`;
}

function getAgeGroupData(){
  const meses = getAgeInMonths();
  if(meses === null) return null;

  if(meses < 3){
    return {
      grupo:'RN–3 m',
      fc:'110–180',
      pa:'60–75 / 35–45'
    };
  } else if(meses < 12){
    return {
      grupo:'3–12 m',
      fc:'100–170',
      pa:'70–90 / 40–55'
    };
  } else if(meses < 48){
    return {
      grupo:'1–3 a',
      fc:'90–150',
      pa:'80–100 / 50–65'
    };
  } else if(meses < 72){
    return {
      grupo:'4–5 a',
      fc:'80–140',
      pa:'80–110 / 55–70'
    };
  } else if(meses < 144){
    return {
      grupo:'6–12 a',
      fc:'70–120',
      pa:'90–120 / 60–75'
    };
  } else {
    return {
      grupo:'≥13 a',
      fc:'60–100',
      pa:'100–135 / 65–85'
    };
  }
}

function updateSummary(){
  const peso = document.getElementById('peso').value;
  const talla = document.getElementById('talla').value;
  const edad = parseFloat(document.getElementById('edad').value);
  const groupData = getAgeGroupData();

  document.getElementById('resumenPeso').textContent = peso ? `${peso} kg` : '—';
  document.getElementById('resumenTalla').textContent = talla ? `${talla} cm` : '—';
  document.getElementById('resumenEdad').textContent = !isNaN(edad) && edad >= 0 ? getAgeDisplay() : '—';
  document.getElementById('resumenEdadUnidad').textContent = isYearsMode() ? 'Edad expresada en años' : 'Edad expresada en meses';
  document.getElementById('grupoEtario').textContent = groupData ? groupData.grupo : '—';

  setFieldValue('fcNormal', groupData ? groupData.fc : '', 0);
  setFieldValue('paNormal', groupData ? groupData.pa : '', 0);
}

function calculateTubeAndDistance(){
  const edad = parseFloat(document.getElementById('edad').value);
  let resultadoF = '';
  let resultadoF2 = '';

  if(!isNaN(edad) && edad > 0){
    if(isYearsMode()){
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

  updateSummary();

  if(!isNaN(pesoVar) && pesoVar > 0){
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
    const bicarbonatoVar = (pesoVar * 1 > 50) ? 50 : (pesoVar * 1);
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
    clearFields([
      'resultado1','distanciaCVC','atropina','bicarbonato','epinefrina',
      'calcioCl','calcioGl','adenosina','amiodarona','lidocaina',
      'rocuronio','midazolam','fentaInd','fentaAna','morfina',
      'glucosa','naloxona','flumazenil','cardiov','desfibr','desfibr2'
    ]);
  }

  calculateTubeAndDistance();
}

function setAgeMode(mode){
  const btnYears = document.getElementById('btnYears');
  const btnMonths = document.getElementById('btnMonths');
  const edadUnit = document.getElementById('edadUnit');
  const oldHidden = document.getElementById('hiddenInput');

  if(oldHidden) oldHidden.remove();

  const hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.id = 'hiddenInput';

  if(mode === 'years'){
    btnYears.classList.add('active-years');
    btnMonths.classList.remove('active-months');
    edadUnit.textContent = 'años';
    hidden.name = 'anios';
    hidden.value = '1';
  } else {
    btnYears.classList.remove('active-years');
    btnMonths.classList.add('active-months');
    edadUnit.textContent = 'meses';
    hidden.name = 'meses';
    hidden.value = '1';
  }

  document.getElementById('edadInput').appendChild(hidden);
  doMath();
}

function envioFormPDF() {
  document.getElementById('formPDF').submit();
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', doMath);
    el.addEventListener('change', doMath);
  });

  document.getElementById('btnYears').addEventListener('click', function(){
    setAgeMode('years');
  });

  document.getElementById('btnMonths').addEventListener('click', function(){
    setAgeMode('months');
  });

  doMath();
});
</script>

<?php
require("footer.php");
?>