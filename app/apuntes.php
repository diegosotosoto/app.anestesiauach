<?php
//Validador login


//  require("valida_pag.php");   ****   PERMITE QUE LA PÁGINA SEA PÚBLICA   *****

//Variables sin conexion
$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<div class='text-white'>Cálculos y Apuntes</div>";
$boton_navbar="<a></a><a></a>";

//Carga Head de la página
require("head.php");





$cabeceras = array(
'Generalidades' => array('icono'=>'apuntes/icons/anesthesia.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA'),
      array('apuntes/cormack.php','fa-solid fa-lungs','Clasificación de Cormack-Lehane'),
      array('apuntes/apfel_ponv.php','fa-solid fa-face-dizzy','Manejo NVPO Adultos'),
      array('apuntes/hiperglicemia.php','fa-solid fa-candy-cane','Manejo Glicemia e Insulina')     
    )),
'Evaluación y Riesgo' => array('icono'=>'apuntes/icons/compliance.png',array(
      array('apuntes/score_lee.php','fa-solid fa-calendar-plus','Índice de Riesgo Cardiaco Revisado'),
      array('apuntes/mallampati.php','fa-solid fa-head-side-cough','Score de Mallampati'),
      array('apuntes/aldrete.php','fa-solid fa-star','Score de Aldrete re Modificado'),
    )),
'Monitorización' => array('icono'=>'apuntes/icons/vital-signs.png',array(
          array('apuntes/ecg_monitorizacion_isquemia.php','fa-solid fa-heart-pulse','Monitorización ECG')
    )),
'Farmacología' => array('icono'=>'apuntes/icons/vaccination.png',array(
        array('apuntes/dilucion_farmacos.php','fa-solid fa-syringe','Dilución de Drogas'),
        array('apuntes/antitromboticos_buscador.php','fa-solid fa-pills','Anticoagulantes'),
        array('apuntes/checklist_preparacion_HM.php','fa-solid fa-fire','Preparación libre de gatillantes'),
        array('apuntes/dosis_aall.php','fa-solid fa-syringe','Dosis Máxima AALL')
    )),
'Cardiovascular' => array('icono'=>'apuntes/icons/heart.png',array(
      array('apuntes/deltapp.php','fa-solid fa-wave-square','Delta PP'),
    )),
'Neurocirugía' => array('icono'=>'apuntes/icons/brain.png',array(
      array('apuntes/glasgow.php','fa-solid fa-brain','Escala de Glasgow')
    )),
'Pediatría' => array('icono'=>'apuntes/icons/children.png',array(
      array('apuntes/emergencia_ped.php','fa-solid fa-truck-medical','Dosis de Emergencia Ped.'),
      array('apuntes/peri_ped.php','fa-solid fa-baby','Dosis Peridural Ped.'),
      array('apuntes/flacc.php','fa-solid fa-hands-holding-child','Escala FLACC'),
      array('apuntes/atb_ped.php','fa-solid fa-bacterium','Profilaxis Antibiótica'),
      array('apuntes/dva_neonato.php','fa-solid fa-heart-circle-bolt','DVA UPC Neonatal'),      
      array('apuntes/eberhart_ponv.php','fa-solid fa-face-dizzy','Manejo NVPO Pediátrico'),
      array('apuntes/regional_ped.php','fa-solid fa-baby','Regional Pediátrica')       
    )),
'Nefrourología' => array('icono'=>'apuntes/icons/kidney.png',array(
      array('apuntes/bica.php','fa-solid fa-flask-vial','Corrección de bicarbonato'),
      array('apuntes/vfg.php','fa-solid fa-filter','Velocidad Filtración Glomerular'),
      array('apuntes/hiperkalemia.php','fa-solid fa-bolt','Manejo Hiperkalemia')
    )),
'Obstetricia' => array('icono'=>'apuntes/icons/pregnancy.png',array(
        array('apuntes/epidural.php','fa-solid fa-person-pregnant','Dosis Analgesia Epidural'),
        array('apuntes/PCEA-PIEB.php','fa-solid fa-square-check','Preparación PIEB')
    )),
'Regional/Dolor' => array('icono'=>'apuntes/icons/ultrasound.png',array(
         array('apuntes/regional_ped.php','fa-solid fa-baby','Regional Pediátrica') 
    )),
'Respiratorio' => array('icono'=>'apuntes/icons/lungs.png',array(
        array('apuntes/ventilacion.php','fa-solid fa-lungs','Ventilación por Peso Ideal'),
         array('apuntes/tdl_algoritmo.php','fa-solid fa-lungs','Tamaño Tubo Doble Lumen')       
    )),
'Volumen y Reposición' => array('icono'=>'apuntes/icons/transfusion.png',array(
      array('apuntes/perdida_admisible.php','fa-solid fa-droplet','Pérdida Admisible'),
      array('apuntes/ascenso_hcto.php','fa-solid fa-bottle-droplet','Ascenso de Hematocrito')

    ))
);
?>

<style>

.topbar{
  background: linear-gradient(135deg, #27458f, #3559b7);
  color: #fff;
  border-radius: 1.25rem;
}

.topbar h1{
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


  .apuntes-shell{
    max-width: 980px;
    margin: 0 auto;
  }

  .apuntes-hero{
    background: linear-gradient(135deg, var(--app-navy), #3559b7);
    color: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
    padding: 1.15rem 1.25rem;
    margin-bottom: 1rem;
  }

  .apuntes-hero-title{
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.2;
  }

  .apuntes-hero-subtitle{
    color: rgba(255,255,255,.75);
    margin-top: .35rem;
  }

  .apuntes-accordion .accordion-item{
    border: 0;
    border-radius: 1rem !important;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
    margin-bottom: .55rem;
  }

  .apuntes-accordion .accordion-button{
    padding: 1rem 1.1rem;
    font-size: 1rem;
    font-weight: 600;
    box-shadow: none !important;
  }

  .apuntes-accordion .accordion-button:not(.collapsed){
    color: #244aa5;
    background: #eef4ff;
  }

  .apuntes-accordion .accordion-button:focus{
    box-shadow: none;
  }

  .apuntes-accordion .accordion-body{
    background: #fff;
    padding: 1rem;
  }

  .apuntes-icon{
    height: 34px;
    width: 34px;
    margin-left: 4px;
    margin-right: 16px;
    flex: 0 0 auto;
  }

  .apuntes-emergency .accordion-button{
    background: linear-gradient(0deg, #f8d7da 0%, #f5c2c7 40%, #f1aeb5 100%);
    color: #000;
  }

  .apuntes-standard .accordion-button{
    background: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);
    color: #1f2a37;
  }

  .apuntes-list{
    display: grid;
    gap: .65rem;
  }

  .apuntes-link{
    display: flex;
    align-items: center;
    gap: .75rem;
    background: #f8fafc;
    border: 1px solid #dfe7f2;
    border-radius: .9rem;
    padding: .9rem 1rem;
    color: #2453c6;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(33,55,98,.06);
    transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
  }

  .apuntes-link:hover{
    transform: translateY(-1px);
    box-shadow: 0 10px 22px rgba(33,55,98,.10);
    background: #ffffff;
    color: #244aa5;
  }

  .apuntes-link i{
    min-width: 22px;
    text-align: center;
  }

  .apuntes-empty{
    color: #6c757d;
    font-size: .95rem;
    padding: .25rem 0;
  }

  @media (max-width: 549px){
    .apuntes-shell{
      max-width: 100%;
    }

    .apuntes-hero{
      border-radius: 1rem;
      padding: 1rem;
    }

    .apuntes-hero-title{
      font-size: 1.08rem;
    }

    .apuntes-accordion .accordion-button{
      padding: .95rem 1rem;
      font-size: .96rem;
    }

    .apuntes-icon{
      height: 30px;
      width: 30px;
      margin-right: 14px;
    }

    .apuntes-link{
      padding: .85rem .9rem;
      font-size: .96rem;
    }
  }
  
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="apuntes-shell">



      <div class="apuntes-hero">
        <div class="small opacity-75 mb-1">APP clínica • recursos y cálculos</div>
        <div class="apuntes-hero-title">Sección de Apuntes y Cálculos</div>
        <div class="apuntes-hero-subtitle">Acceso rápido a escalas, scores, buscadores, checklists y utilidades clínicas.</div>
      </div>




      <div class="accordion apuntes-accordion" id="accordionApuntes">

        <div class='accordion-item apuntes-emergency'>
          <h2 class='accordion-header' id='headingEmergencias'>
            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseEmergencias' aria-expanded='false' aria-controls='collapseEmergencias'>
              <img src='apuntes/icons/emergency.png'
                   class='apuntes-icon'
                   style='filter: drop-shadow(0 0 0 black) drop-shadow(1px 0 0 black) drop-shadow(-1px 0 0 black) drop-shadow(0 1px 0 black) drop-shadow(0 -1px 0 black);' />
              EMERGENCIAS
            </button>
          </h2>

          <div id='collapseEmergencias' class='accordion-collapse collapse' aria-labelledby='headingEmergencias'>
            <div class='accordion-body'>
              <div class='apuntes-list'>
                <a href='apuntes/checklist_LAST.php' class='apuntes-link'><i class='fa-solid fa-heart-circle-bolt'></i>Checklist LAST</a>
                <a href='apuntes/checklist_HM.php' class='apuntes-link'><i class='fa-solid fa-fire'></i>Checklist Hipertermia Maligna</a>
                <a href='apuntes/hiperkalemia.php' class='apuntes-link'><i class='fa-solid fa-bolt'></i>Manejo Hiperkalemia</a>               
              </div>
            </div>
          </div>
        </div>

<?php
$i = 0;
foreach ($cabeceras as $nombre => $ext){
  echo "
        <div class='accordion-item apuntes-standard'>
          <h2 class='accordion-header' id='heading$i'>
            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$i' aria-expanded='false' aria-controls='collapse$i'>
              <img src='".$ext['icono']."' class='apuntes-icon' />$nombre
            </button>
          </h2>

          <div id='collapse$i' class='accordion-collapse collapse' aria-labelledby='heading$i'>
            <div class='accordion-body'>";

  if (!empty($ext[0])) {
    echo "<div class='apuntes-list'>";
    foreach ($ext[0] as $contenido){
      echo "<a href='".$contenido[0]."' class='apuntes-link'><i class='".$contenido[1]."'></i>".$contenido[2]."</a>";
    }
    echo "</div>";
  } else {
    echo "<div class='apuntes-empty'>No hay recursos disponibles aún en esta sección.</div>";
  }

  echo "    </div>
          </div>
        </div>";
  $i++;
}
?>
</div>
      </div>
    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>
