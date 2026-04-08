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
            max-width:980px;
            margin:0 auto;
          }

          .telefonos-topbar{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
          }

          .telefonos-topbar h1{
            color:#fff;
          }

          .subtle{
            font-size:.92rem;
          }

          .pill{
            display:inline-block;
            padding:.25rem .6rem;
            border-radius:999px;
            font-size:.8rem;
            font-weight:600;
          }

          .telefono-card{
            border:0;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;
          }

          .telefono-search-input{
            min-height:56px;
            border-radius:1rem;
            border:1px solid #dfe7f2;
            font-size:1rem;
          }

          .telefono-section-title{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#667085;
            margin-bottom:.7rem;
          }

          .telefono-list{
            display:grid;
            gap:.75rem;
          }

          .telefono-item{
            display:block;
            text-decoration:none;
            color:#1f2a37;
            background:#f8fafc;
            border:1px solid #dfe7f2;
            border-radius:1rem;
            padding:1rem 1rem;
            box-shadow:0 6px 18px rgba(33,55,98,.06);
            transition:transform .15s ease, box-shadow .15s ease, background-color .15s ease;
          }

          .telefono-item:hover{
            transform:translateY(-1px);
            box-shadow:0 10px 22px rgba(33,55,98,.10);
            background:#ffffff;
            color:#1f2a37;
          }

          .telefono-item-inner{
            display:flex;
            align-items:center;
            gap:.9rem;
          }

          .telefono-item i{
            min-width:22px;
            text-align:center;
          }

          .telefono-name{
            font-weight:700;
            margin-bottom:.15rem;
          }

          .telefono-number{
            color:#2453c6;
            word-break:break-word;
          }

          .telefono-empty{
            color:#6c757d;
            text-align:center;
            padding:1rem;
          }
        </style>

        <div class="telefonos-shell">

          <div class="telefonos-topbar mb-3">
            <div class="d-flex justify-content-between align-items-start gap-3">
              <div>
                <div class="small opacity-75 mb-1">APP clínica • acceso rápido</div>
                <h1 class="h4 mb-2">Teléfonos Frecuentes</h1>
                <div class="subtle text-white-50">Busca por servicio o unidad y llama directamente desde la app.</div>
              </div>
              <span class="pill bg-light text-dark">HBV</span>
            </div>
          </div>

          <div class="telefono-card mb-3">
            <div class="p-3 p-md-4">
              <div class="section-title mb-2">Buscar</div>
              <input type="text" class="form-control telefono-search-input" id="search" placeholder="Busca un servicio...">
            </div>
          </div>

          <div class="telefono-card mb-3">
            <div class="p-3 p-md-4">
              <div class="telefono-section-title">Destacados</div>
              <div class="telefono-list" id="telefonosDestacados">
                <?php
                foreach ($array_frec as $servicio1 => $telefono1){
                  echo "<a href='tel:$telefono1' class='telefono-item telefono-entry'>
                          <div class='telefono-item-inner'>
                            <i class='fa-solid fa-star text-warning'></i>
                            <div>
                              <div class='telefono-name'>$servicio1</div>
                              <div class='telefono-number'>$telefono1</div>
                            </div>
                          </div>
                        </a>";
                }
                ?>
              </div>
            </div>
          </div>

          <div class="telefono-card">
            <div class="p-3 p-md-4">
              <div class="telefono-section-title">Otros</div>
              <div class="telefono-list" id="telefonosOtros">
                <?php
                foreach ($array_tel as $servicio => $telefono){
                  echo "<a href='tel:$telefono' class='telefono-item telefono-entry not-overlay'>
                          <div class='telefono-item-inner'>
                            <i class='fa-solid fa-phone text-success'></i>
                            <div>
                              <div class='telefono-name'>$servicio</div>
                              <div class='telefono-number'>$telefono</div>
                            </div>
                          </div>
                        </a>";
                }
                ?>
              </div>
              <div id="noResults" class="telefono-empty d-none">No se encontraron coincidencias.</div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $("#search").keyup(function(){
    const query = $(this).val().toLowerCase().trim();
    let visibleCount = 0;

    $.each($(".telefono-entry"), function() {
      if($(this).text().toLowerCase().indexOf(query) === -1){
        $(this).hide();
      } else {
        $(this).show();
        visibleCount++;
      }
    });

    if (visibleCount === 0) {
      $("#noResults").removeClass("d-none");
    } else {
      $("#noResults").addClass("d-none");
    }
  });
});
</script>

<?php
  require("footer.php");
?>
