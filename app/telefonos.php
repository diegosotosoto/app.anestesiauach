<?php

  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
  }

  $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar="<div class='text-white'>Teléfonos</div>";
  $boton_navbar="<a></a><a></a>";

  require("head.php");
?>

<?php
$array_frec = array(
'RECUPERACIÓN CENTRAL' => '63 2263491',
'RECUPERACIÓN H' => '63 2263996',
'RECUPERACIÓN MATERNIDAD' => '63 2263604',
'BANCO SANGRE TECNÓLOGO' => '63 2263768',
'BANCO SANGRE' => '63 2263775',
'UCI 1' => '63 2263499',
'UCI 2' => '63 2263554',
'UCI PEDIÁTRICA' => '63 2263654',
'UCI NEONATOLOGÍA' => '63 2263589',
'UCI PED. RESID. MÉDICA' => '63 2263650',
'UTI QUIRÚRGICA' => '63 2263815',
'UTI MÉDICA' => '63 2263517',
'UTI 3' => '63 2263527',
'RESI BECADOS ANESTESIA' => '63 2263511',
'PARTOS PABELLÓN' => '63 2263605',
'PREPARTO' => '63 2263599',
'EST. MATRONERÍA PARTOS' => '63 2263604',
'SALA ESTAR PERSONAL' => '63 2263496',
'RESI MÉDICA ANESTESIA' => '63 2263495',
'GESTIÓN DE CAMAS' => '63 2263847',
'GESTIÓN DE CAMAS 2' => '63 2263916',
'LABORATORIO CENTRAL RECEPCION' => '63 2263309',
'LABORATORIO CENTRAL SEC.' => '63 2263305',
'RESIDENCIA UCI 1.' => '63 2263635'
);

$array_tel = array(
'AP ADULTO MÉDICO TURNO' => '63 2263765',
'AP ADULTO OBSERVACIÓN' => '63 2263761',
'AP PEDIÁTRICA RECEPCIÓN' => '63 2263754',
'BOX URGENCIA' => '63 2263607',
'CUIDADOS INTERMEDIOS' => '63 2263554',
'EST. ENF. ARO' => '63 2263735',
'EST. ENF. CIRUGÍA HOMBRE' => '63 2263705',
'EST. ENF. CIRUGÍA MUJER' => '63 2263703',
'EST. ENF. CIRUGÍA DIGESTIVO' => '63 2263698',
'EST. ENF. CIRUGÍA INFANTIL' => '63 2263648',
'EST. ENF. GINECOLOGÍA' => '63 2263730',
'EST. ENF. UCI INFANTIL' => '63 2263654',
'EST. ENF. LACTANTE' => '63 2263687',
'EST. ENF. MEDICINA 2DO P' => '63 2263516',
'EST. ENF. MEDICINA 2DO P 2' => '63 2263517',
'EST. ENF. MEDICINA HOMBRE' => '63 2263534',
'EST. ENF. MEDICINA MUJER' => '63 2263527',
'EST. ENF. MEDICINA' => '63 2263530',
'EST. ENF. MEDICINA INFANTIL' => '63 2263687',
'EST. ENF. HEMATO ADULTO' => '63 2263690',
'EST. ENF. UTI3' => '63 2263527',
'EST. ENF. NEONATOLOGIA' => '63 2263596',
'EST. ENF. NEUROCIRUGÍA 1' => '63 2263025',
'EST. ENF. NEUROCIRUGÍA 2' => '63 2263714',
'EST. ENF. ONCOLOGÍA' => '63 2263584',
'EST. ENF. ONCO INFANTIL' => '63 2263690',
'EST. ENF. PABELLÓN' => '63 2263510',
'EST. ENF. PENSIONADO' => '63 2263670',
'EST. ENF. PUERPERIO' => '63 2263733',
'EST. ENF. TRAUMA ADULTO' => '63 2263717',
'EST. ENF. TRAUMA INFANTIL' => '63 2263719',
'EST. DE ENF. UCI NEO' => '63 2263589',
'EST. ENF. UCI ADULTO' => '63 2263499',
'EST. ENF. UTI' => '63 2263554',
'EST. ENF. UROLOGÍA' => '63 2263663',
'ESTERILIZACION MAT. BLANCO' => '63 2263462',
'ESTERILIZACION MAT. ESTERIL' => '63 2263457',
'ESTERILIZACION MAT. SUCIO' => '63 2263463',
'ESTERILIZACION PREP. MATERIAL' => '63 2263458',
'ESTERILIZACION SEC.' => '63 2263461',
'ESTERILIZACION JEFATURA' => '63 2263460',
'FARMACIA MEDICAMENTO' => '63 2263616',
'FARMACIA PREP. SOLUCIONES' => '63 2263611',
'FARMACIA SEC.' => '63 2263615',
'GASES CLINICOS' => '63 2263993',
'TOMA DE MUESTRA' => '63 2263336',
'LABORATORIO HEMATOLOGÍA' => '63 2263326',
'LABORATORIO NEFROLOGÍA' => '63 2263323',
'PABELLON 1' => '63 2263500',
'PABELLON 2' => '63 2263501',
'PABELLON 3' => '63 2263502',
'PABELLON 4' => '63 2263503',
'PABELLON 5' => '63 2263504',
'PABELLON 6' => '63 2263505',
'PABELLON 7' => '63 2263506',
'PABELLON 9' => '63 2263508',
'PABELLON EST. ENF.' => '63 2263510',
'RAYOS PASILLO' => '63 2263402',
'RAYOS SCANNER' => '63 2263405',
'SEC. SERVICIO CIRUGÍA' => '63 2263706',
'SEC. SERVICIO CIRUGIA INFANTIL' => '63 2263906',
'SEC. SERVICIO GINECOLOGIA' => '63 2263736',
'SEC. SERVICIO MEDICINA' => '63 2263518',
'SEC. SERVICIO NEUROCIRUGÍA' => '63 2263721',
'SEC. SERVICIO ONCOLOGÍA' => '63 2263989',
'SEC. SERVICIO PEDIATRÍA' => '63 2263683',
'UGA' => '63 2263383',
'URGENCIA ADULTO SHAP' => '63 2263761',
'URGENCIA PEDRIATRICA' => '63 2263548',
'URGENCIA PROCEDIMIENTO' => '63 2263571',
'URGENCIA REANIMADOR' => '63 2263802'
);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">

        <style>
          .telefonos-shell{
            max-width:1080px;
            margin:0 auto;
          }

          .telefonos-hero{
            background:linear-gradient(135deg, #0f2f6d 0%, #21479d 55%, #2f62d0 100%);
            color:#fff;
            border-radius:1.35rem;
            box-shadow:0 14px 34px rgba(22,34,66,.14);
            padding:1.25rem;
            overflow:hidden;
            position:relative;
          }

          .telefonos-hero:after{
            content:"";
            position:absolute;
            inset:auto -60px -60px auto;
            width:180px;
            height:180px;
            border-radius:50%;
            background:rgba(255,255,255,.08);
          }

          .telefonos-hero h1{
            color:#fff;
            margin-bottom:.25rem;
          }

          .telefonos-subtitle{
            color:rgba(255,255,255,.78);
            font-size:.95rem;
            max-width:680px;
          }

          .hero-badge{
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            background:rgba(255,255,255,.12);
            color:#fff;
            border:1px solid rgba(255,255,255,.14);
            border-radius:999px;
            padding:.38rem .75rem;
            font-size:.82rem;
            font-weight:600;
            backdrop-filter:blur(4px);
          }

          .hero-stats{
            display:flex;
            gap:.65rem;
            flex-wrap:wrap;
            margin-top:.9rem;
          }

          .hero-stat{
            background:rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.12);
            border-radius:1rem;
            padding:.75rem .95rem;
            min-width:120px;
          }

          .hero-stat-number{
            font-size:1.2rem;
            font-weight:800;
            line-height:1;
          }

          .hero-stat-label{
            font-size:.78rem;
            color:rgba(255,255,255,.72);
            margin-top:.2rem;
          }

          .telefono-panel{
            border:1px solid #e5ebf5;
            border-radius:1.15rem;
            background:#fff;
            box-shadow:0 8px 24px rgba(26,39,68,.06);
          }

          .telefono-panel-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:1rem;
            margin-bottom:1rem;
          }

          .telefono-section-title{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#6b7280;
            margin-bottom:.35rem;
            font-weight:700;
          }

          .telefono-section-heading{
            font-size:1.12rem;
            font-weight:800;
            color:#162033;
            margin:0;
          }

          .section-counter{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:34px;
            height:34px;
            border-radius:999px;
            padding:0 .75rem;
            font-size:.86rem;
            font-weight:700;
            color:#24449a;
            background:#eef4ff;
            border:1px solid #dbe7ff;
          }

          .telefono-search-wrap{
            position:relative;
          }

          .telefono-search-icon{
            position:absolute;
            left:1rem;
            top:50%;
            transform:translateY(-50%);
            color:#8a94a6;
            pointer-events:none;
          }

          .telefono-search-input{
            min-height:58px;
            border-radius:1rem;
            border:1px solid #d9e2ef;
            font-size:1rem;
            padding-left:2.8rem;
            padding-right:7rem;
            background:#fbfcfe;
          }

          .telefono-search-input:focus{
            border-color:#2f62d0;
            box-shadow:0 0 0 .2rem rgba(47,98,208,.12);
            background:#fff;
          }

          .telefono-search-meta{
            position:absolute;
            right:1rem;
            top:50%;
            transform:translateY(-50%);
            font-size:.8rem;
            color:#6b7280;
            background:#fff;
            border:1px solid #e6ebf2;
            border-radius:999px;
            padding:.22rem .55rem;
          }

          .telefono-grid{
            display:grid;
            gap:1rem;
          }

          .telefono-list{
            display:grid;
            gap:.72rem;
          }

          .telefono-item{
            display:block;
            text-decoration:none;
            color:#1f2937;
            background:linear-gradient(180deg, #ffffff 0%, #f9fbfe 100%);
            border:1px solid #e4eaf3;
            border-radius:1rem;
            padding:.95rem 1rem;
            box-shadow:0 6px 16px rgba(26,39,68,.05);
            transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
          }

          .telefono-item:hover{
            transform:translateY(-1px);
            box-shadow:0 12px 24px rgba(26,39,68,.09);
            border-color:#cfdaf0;
            color:#1f2937;
          }

          .telefono-item-inner{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:1rem;
          }

          .telefono-main{
            display:flex;
            align-items:flex-start;
            gap:.9rem;
            min-width:0;
          }

          .telefono-icon{
            width:42px;
            height:42px;
            border-radius:.95rem;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            flex:0 0 42px;
            font-size:1rem;
          }

          .telefono-icon-featured{
            background:#fff4d6;
            color:#c88a00;
          }

          .telefono-icon-regular{
            background:#edf4ff;
            color:#2252c5;
          }

          .telefono-text{
            min-width:0;
          }

          .telefono-name{
            font-weight:800;
            color:#142033;
            line-height:1.2;
            margin-bottom:.2rem;
          }

          .telefono-caption{
            font-size:.78rem;
            color:#7b8794;
          }

          .telefono-actions{
            text-align:right;
            flex:0 0 auto;
          }

          .telefono-number{
            color:#1d4ed8;
            font-weight:800;
            letter-spacing:.02em;
            font-variant-numeric:tabular-nums;
            white-space:nowrap;
          }

          .telefono-call{
            margin-top:.25rem;
            font-size:.78rem;
            color:#6b7280;
          }

          .telefono-empty{
            color:#6b7280;
            text-align:center;
            padding:1.25rem 1rem .5rem;
          }

          @media (min-width: 992px){
            .telefono-grid{
              grid-template-columns: 1fr 1.35fr;
              align-items:start;
            }
          }

          @media (max-width: 575.98px){
            .telefono-item-inner{
              align-items:flex-start;
            }

            .telefono-actions{
              min-width:92px;
            }

            .telefono-number{
              white-space:normal;
            }
          }
        </style>

        <div class="telefonos-shell">

          <div class="telefonos-hero mb-3 mb-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 position-relative" style="z-index:1;">
              <div>
                <span class="hero-badge"><i class="fa-solid fa-phone-volume"></i> Acceso rápido hospitalario</span>
                <h1 class="h3 mt-2">Teléfonos frecuentes</h1>
                <div class="telefonos-subtitle">Directorio clínico ordenado para encontrar rápido una unidad, llamar desde el móvil y reducir el ruido visual.</div>
                <div class="hero-stats">
                  <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo count($array_frec); ?></div>
                    <div class="hero-stat-label">Destacados</div>
                  </div>
                  <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo count($array_tel); ?></div>
                    <div class="hero-stat-label">Otros teléfonos</div>
                  </div>
                  <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo count($array_frec) + count($array_tel); ?></div>
                    <div class="hero-stat-label">Total disponible</div>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-start justify-content-md-end">
                <span class="hero-badge"><i class="fa-solid fa-hospital"></i> HBV</span>
              </div>
            </div>
          </div>

          <div class="telefono-panel mb-3 mb-md-4">
            <div class="p-3 p-md-4">
              <div class="telefono-section-title">Buscar</div>
              <div class="telefono-search-wrap">
                <i class="fa-solid fa-magnifying-glass telefono-search-icon"></i>
                <input type="text" class="form-control telefono-search-input" id="telefonoSearchInput" placeholder="Busca por servicio, unidad o área...">
                <span class="telefono-search-meta" id="searchCount"><?php echo count($array_frec) + count($array_tel); ?> resultados</span>
              </div>
            </div>
          </div>

          <div class="telefono-grid">

            <div class="telefono-panel">
              <div class="p-3 p-md-4">
                <div class="telefono-panel-header">
                  <div>
                    <div class="telefono-section-title">Prioridad</div>
                    <h2 class="telefono-section-heading">Destacados</h2>
                  </div>
                  <span class="section-counter" id="countDestacados"><?php echo count($array_frec); ?></span>
                </div>

                <div class="telefono-list" id="telefonosDestacados">
                  <?php
                  foreach ($array_frec as $servicio1 => $telefono1){
                    echo "<a href='tel:$telefono1' class='telefono-item telefono-entry telefono-entry-featured'>
                            <div class='telefono-item-inner'>
                              <div class='telefono-main'>
                                <span class='telefono-icon telefono-icon-featured'><i class='fa-solid fa-star'></i></span>
                                <div class='telefono-text'>
                                  <div class='telefono-name'>$servicio1</div>
                                  <div class='telefono-caption'>Contacto frecuente</div>
                                </div>
                              </div>
                              <div class='telefono-actions'>
                                <div class='telefono-number'>$telefono1</div>
                                <div class='telefono-call'>Tocar para llamar</div>
                              </div>
                            </div>
                          </a>";
                  }
                  ?>
                </div>
              </div>
            </div>

            <div class="telefono-panel">
              <div class="p-3 p-md-4">
                <div class="telefono-panel-header">
                  <div>
                    <div class="telefono-section-title">Directorio</div>
                    <h2 class="telefono-section-heading">Otros teléfonos</h2>
                  </div>
                  <span class="section-counter" id="countOtros"><?php echo count($array_tel); ?></span>
                </div>

                <div class="telefono-list" id="telefonosOtros">
                  <?php
                  foreach ($array_tel as $servicio => $telefono){
                    echo "<a href='tel:$telefono' class='telefono-item telefono-entry telefono-entry-regular'>
                            <div class='telefono-item-inner'>
                              <div class='telefono-main'>
                                <span class='telefono-icon telefono-icon-regular'><i class='fa-solid fa-phone'></i></span>
                                <div class='telefono-text'>
                                  <div class='telefono-name'>$servicio</div>
                                  <div class='telefono-caption'>Línea interna</div>
                                </div>
                              </div>
                              <div class='telefono-actions'>
                                <div class='telefono-number'>$telefono</div>
                                <div class='telefono-call'>Tocar para llamar</div>
                              </div>
                            </div>
                          </a>";
                  }
                  ?>
                </div>
                <div id="noResults" class="telefono-empty d-none">
                  <i class="fa-solid fa-circle-info me-1"></i>No se encontraron coincidencias.
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  function filtrarTelefonos() {
    const query = $("#telefonoSearchInput").val().toLowerCase().trim();
    let visibleCount = 0;
    let visibleDestacados = 0;
    let visibleOtros = 0;

    $.each($(".telefono-entry"), function() {
      const matches = $(this).text().toLowerCase().indexOf(query) !== -1;
      $(this).toggle(matches);

      if(matches){
        visibleCount++;
        if($(this).hasClass("telefono-entry-featured")){
          visibleDestacados++;
        }
        if($(this).hasClass("telefono-entry-regular")){
          visibleOtros++;
        }
      }
    });

    $("#searchCount").text(visibleCount + (visibleCount === 1 ? " resultado" : " resultados"));
    $("#countDestacados").text(visibleDestacados);
    $("#countOtros").text(visibleOtros);
    $("#noResults").toggleClass("d-none", visibleCount !== 0);
  }

  $("#telefonoSearchInput").on("input keyup search", filtrarTelefonos);

  // Ejecuta también al pegar texto o al autocompletar
  document.getElementById("telefonoSearchInput").addEventListener("paste", function(){
    setTimeout(filtrarTelefonos, 0);
  });

  filtrarTelefonos();
});
</script>

<?php
  require("footer.php");
?>
