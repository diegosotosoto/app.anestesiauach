<?php

  //Ve si está activa la cookie o redirige al login
  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
  }
  //Conexión
  require("conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");
  
  //Carga Head de la página
  require("head.php");

?>

</head>
<body>
</br></br></br>
<!-  NAVBAR  -> 

  <?php
    //Botones del Toggle NAVBAR


    $boton_toggler="<a class='btn btn-lg shadow-sm border-light' style='; --bs-border-opacity: .1;'  href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
    $titulo_navbar="Apuntes";
    $boton_navbar="<a></a><a></a>";
    //Conexión
    require("navbar.php");
  ?>

<?php

$cabeceras = array(
'Generalidades' => array('icono'=>'apuntes/icons/anesthesia.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA'),
    )),
'Evaluación y Riesgo' => array('icono'=>'apuntes/icons/compliance.png',
      array(array('apuntes/score_lee.php','fa-solid fa-calendar-plus','Índice de Riesgo Cardiaco Revisado'),        
    )),
'Monitorización' => array('icono'=>'apuntes/icons/vital-signs.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA'),
    )),
'Farmacología' => array('icono'=>'apuntes/icons/vaccination.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA'),
    )),
'Cardiovascular' => array('icono'=>'apuntes/icons/heart.png',array(
      array('apuntes/deltapp.php','fa-solid fa-wave-square','Delta PP'),
    )),
'Neurocirugía' => array('icono'=>'apuntes/icons/brain.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA')
    )),
'Pediatría' => array('icono'=>'apuntes/icons/children.png',array(
      array('apuntes/peri_ped.php','fa-solid fa-baby','Dosis Peridural Ped.')
    )),
'Nefrourología' => array('icono'=>'apuntes/icons/kidney.png',array(
      array('apuntes/bica.php','fa-solid fa-flask-vial','Corrección de bicarbonato'),
    )),
'Obstetricia' => array('icono'=>'apuntes/icons/pregnancy.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA')
    )),
'Regional/Dolor' => array('icono'=>'apuntes/icons/ultrasound.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA')
    )),
'Respiratorio' => array('icono'=>'apuntes/icons/lungs.png',array(
      array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA')
    )),
'Volumen y Reposición' => array('icono'=>'apuntes/icons/transfusion.png',array(
      array('apuntes/perdida_admisible.php','fa-solid fa-droplet','Pérdida Admisible')
    ))
);

$generalidades = array(); //array de arrays que contiene 1.href 2.icono de fa 3.titulo para cada elemento
$eval_riesgo = array(array('apuntes/asa.php','fa-solid fa-lightbulb','Clasificación ASA'));
$monitorizacion = array();
$farmacologia = array();
$cardiovasc = array();
$neurocirugia = array();
$pediatria = array();
$nefro_uro = array(array('apuntes/bica.php','fa-solid fa-flask-vial','Corrección de bicarbonato'));
$obstetricia = array();
$regional_dolor = array();
$respiratorio = array();
$volumen_repo = array(array('apuntes/perdida_admisible.php','fa-solid fa-droplet','Pérdida Admisible'));


?>



<div class="accordion" id="accordionPanelsStayOpenExample">
<?php

$i = 0;

      foreach ($cabeceras  as $nombre => $ext){
          
        echo "
            <div class='accordion-item'>
              <h2 class='accordion-header' id='panelsStayOpen-heading$i'>
                <button class='accordion-button collapsed pt-4 pb-4 fs-5' type='button' data-bs-toggle='collapse' data-bs-target='#panelsStayOpen-collapse$i' aria-expanded='false' aria-controls='panelsStayOpen-collapse$i' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                  <img src='".$ext['icono']."' style='height: 34px; width: 34px; margin-left:10px; margin-right:20px'/>$nombre
                </button>
              </h2>

              <div id='panelsStayOpen-collapse$i' class='accordion-collapse collapse' aria-labelledby='panelsStayOpen-heading$i'>
                <div class='accordion-body'>

                ";

                $j = 0;
                foreach ($ext[$j] as $contenido){
                    echo "
                          <div class='list-group'>
                          <a href='".$contenido[0]."' class='list-group-item list-group-item-action text-primary fs-5'><i style='padding-right:10px; padding-left: 10px;' class='".$contenido[1]."'></i>".$contenido[2]."</a> 
                        </div>
                        ";
                    $j++;
                }

                echo "
                </div>
              </div>
            </div>
            ";

        $i++;
      }

?>

</div>
<div class="pt-5 mb-2 text-center">
    <p class="text-muted pb-2">Anestesia<small class='fw-bold'>  UACH &nbsp;<img src='images/austral.png' style='height: 36px; width: 36px; filter: invert(60%);'/></small></p>
</div>


  <?php 
    //Cierre Conexión
    $conexion->close();
  ?>

<!-  FOOTER  ->

  <?php
    //Conexión
    require("footer.php");

  ?>

</body>
</html> 