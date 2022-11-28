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



<div class="accordion" id="accordionPanelsStayOpenExample">

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingGen">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseGen" aria-expanded="false" aria-controls="panelsStayOpen-collapseGen" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/anesthesia.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Generalidades
      </button>
    </h2>

    <div id="panelsStayOpen-collapseGen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingGen">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/bica.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;"  class="fa-solid fa-flask-vial"></i>Corrección de bicarbonato</a> 
      </div>

      </div>
    </div>
  </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingEval">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEval" aria-expanded="false" aria-controls="panelsStayOpen-collapseEval" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/compliance.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Evaluación y Riesgo
      </button>
    </h2>

    <div id="panelsStayOpen-collapseEval" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingEval">
      <div class="accordion-body">


      <div class="list-group">
        <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-droplet"></i>Pérdida Admisible </a> 
      </div>

    </div>
  </div>
 </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingMonit">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseMonit" aria-expanded="false" aria-controls="panelsStayOpen-collapseMonit" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/vital-signs.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Monitorización
      </button>
    </h2>

    <div id="panelsStayOpen-collapseMonit" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingMonit">
      <div class="accordion-body">


      <div class="list-group">
        <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-droplet"></i>Pérdida Admisible </a> 
      </div>

    </div>
  </div>
 </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingFarm">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFarm" aria-expanded="false" aria-controls="panelsStayOpen-collapseFarm" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/vaccination.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Farmacología
      </button>
    </h2>

    <div id="panelsStayOpen-collapseFarm" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFarm">
      <div class="accordion-body">


      <div class="list-group">
        <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-droplet"></i>Pérdida Admisible </a> 
      </div>

    </div>
  </div>
 </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->  
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingCardio">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseCardio" aria-expanded="false" aria-controls="panelsStayOpen-collapseCardio" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
         <img src="apuntes/icons/heart.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Cardiovascular
      </button>
    </h2>

    <div id="panelsStayOpen-collapseCardio" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingCardio">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-heart-pulse"></i>Pérdida Admisible </a> 
      </div>

    </div>
  </div>
 </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->  
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingNeuro">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseNeuro" aria-expanded="false" aria-controls="panelsStayOpen-collapseNeuro" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
         <img src="apuntes/icons/brain.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Neurocirugía
      </button>
    </h2>

    <div id="panelsStayOpen-collapseNeuro" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingNeuro">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-heart-pulse"></i>Pérdida Admisible </a> 
      </div>

    </div>
  </div>
 </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->  
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingPed">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsePed" aria-expanded="false" aria-controls="panelsStayOpen-collapsePed" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
         <img src="apuntes/icons/children.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Pediatría
      </button>
    </h2>

    <div id="panelsStayOpen-collapsePed" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingPed">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-heart-pulse"></i>Pérdida Admisible </a> 
      </div>

    </div>
  </div>
 </div>
<!- FIN DEL ITEM -> 

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingRen">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseRen" aria-expanded="false" aria-controls="panelsStayOpen-collapseRen" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/kidney.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Nefrourología
      </button>
    </h2>

    <div id="panelsStayOpen-collapseRen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingRen">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/bica.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;"  class="fa-solid fa-flask-vial"></i>Corrección de bicarbonato</a> 
      </div>

      </div>
    </div>
  </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingObst">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseObst" aria-expanded="false" aria-controls="panelsStayOpen-collapseObst" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/pregnancy.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Obstetricia
      </button>
    </h2>

    <div id="panelsStayOpen-collapseObst" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingObst">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/bica.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;"  class="fa-solid fa-flask-vial"></i>Corrección de bicarbonato</a> 
      </div>

      </div>
    </div>
  </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingReg">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseReg" aria-expanded="false" aria-controls="panelsStayOpen-collapseReg" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/ultrasound.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Regional / Dolor
      </button>
    </h2>

    <div id="panelsStayOpen-collapseReg" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingReg">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/bica.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;"  class="fa-solid fa-flask-vial"></i>Corrección de bicarbonato</a> 
      </div>

      </div>
    </div>
  </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingResp">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseResp" aria-expanded="false" aria-controls="panelsStayOpen-collapseResp" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/lungs.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Respiratorio
      </button>
    </h2>

    <div id="panelsStayOpen-collapseResp" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingResp">
      <div class="accordion-body">

      <div class="list-group">
        <a href="apuntes/bica.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;"  class="fa-solid fa-flask-vial"></i>Corrección de bicarbonato</a> 
      </div>

      </div>
    </div>
  </div>
<!- FIN DEL ITEM ->

<!- INICIO DEL ITEM ->
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingVol">
      <button class="accordion-button collapsed pt-4 pb-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseVol" aria-expanded="false" aria-controls="panelsStayOpen-collapseVol" style="background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);">
        <img src="apuntes/icons/transfusion.png" style="height: 34px; width: 34px; margin-left:10px; margin-right:20px"/>Volumen y Reposición
      </button>
    </h2>

    <div id="panelsStayOpen-collapseVol" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingVol">
      <div class="accordion-body">


      <div class="list-group">
        <a href="apuntes/perdida_admisible.php" class="list-group-item list-group-item-action text-primary fs-5"><i style="padding-right:10px; padding-left: 10px;" class="fa-solid fa-droplet"></i>Pérdida Admisible </a> 
      </div>

    </div>
  </div>
 </div>
 <div class="pt-5 mb-2 text-center">
    <p class="text-muted pb-2">Anestesia<small class='fw-bold'>  UACH &nbsp;<img src='images/austral.png' style='height: 36px; width: 36px; filter: invert(60%);'/></small></p>
</div>
<!- FIN DEL ITEM ->






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