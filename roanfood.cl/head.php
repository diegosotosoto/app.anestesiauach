<?php  //Conexión
  require("conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#F5F5F5">
	<meta http-equiv="Cache-control" content="no-cache">
	<title>Roanfood || Sabor Casero</title>
	<link rel="icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="manifest" href="manifest.json"/>
	<link rel="apple-touch-icon" href="images/logo192.png"/>	
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="css/all.css"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script src="js/jquery-3.6.1.min.js"></script>
</head>
<body>

<div class="container text-center ps-1 pe-1">
  <div class="row">

    <div class="col-sm col-sm-4">
    <nav class="navbar navbar-expand-sm">

        <div class="container-fluid">


          <?php if($boton_toggler){echo $boton_toggler;} ?>

          <a class="navbar-brand d-sm-block d-sm-none" href="#">

          <?php if($titulo_navbar){echo $titulo_navbar;} ?>

          </a><br>



          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="--bs-offcanvas-width: 320px;">

            <div class="offcanvas-header bg-secondary">
              <h5 class="offcanvas-title ps-4" id="offcanvasNavbarLabel"><img src="images/roanfood256.png" style="width: 40% ;border-radius: 70%;"><br></h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

          <div class="container text-center">
              <div class="row ps-1">
                <a class="navbar-brand d-xs-none d-none d-sm-block" href="#"><img src="images/roanfood256.png" style="width: 80% ;border-radius: 70%;"></a><br>
              </div>

              <div class="row ps-1">                
                <div class='list-group ps-2'><a href='index.php' class='list-group-item list-group-item-action fs-5'><i class="fa-solid fa-house ps-2 pe-3 fs-3 text-secondary"></i>Inicio</a></div>
              </div>

              <div class="row ps-1">
                <div class='list-group ps-2'><a href='acerca_de.php' class='list-group-item list-group-item-action fs-5'><i class="fa-solid fa-circle-question ps-2 pe-3 fs-3 text-secondary"></i>Acerca De</a></div>
              </div>

              <div class="row"> 

                <?php 


                   //BUSCA SI ESTA ESTABLECIDA LA COOKIE PARA MOSTRAR EL MENU
                  if(isset($_COOKIE['hkjh41laa8u4l1k23jhlkj1387s76d8as76a9sd8'])){

                      //BUSCA SI EL USUARIO ES ADMIN Y AGREGA MENÚ DE ADMIN

                      $email_user=$_COOKIE['hkjh41laa8u4l1k23jhlkj1387s76d8as76a9sd8'];
                      $consulta_user="SELECT * FROM `usuarios_rf` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";

                      $confirma_user=$conexion->query($consulta_user); 


                      if(mysqli_num_rows($confirma_user)==0){//AL NO ENCONRAR REGISTROS DE ADMIN NO AGREGA NADA

                      }else{ 
                  
                              echo "
                              <form id='gest_users' action='nuevo_menu.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                              <div class='list-group'>
                                <a href='#' onclick='envioForm1_asdf()' class='list-group-item list-group-item-action fs-5'><i class='fa-regular fa-rectangle-list ps-2 pe-3 fs-3 text-secondary'></i>
                                Menu</a> 
                              </div></form>
                              <script>function envioForm1_asdf() {document.getElementById('gest_users').submit(); }</script>
                              ";

                              echo "<form id='gest_pacientes' action='gestion_inventario.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                              <div class='list-group'>
                                <a href='#' onclick='envioForm2_asdf()' class='list-group-item list-group-item-action fs-5'><i class='fa-solid fa-kitchen-set ps-2 pe-3 fs-3 text-secondary'></i>Inventario</a> 
                              </div></form>
                              <script>function envioForm2_asdf() {document.getElementById('gest_pacientes').submit(); }</script>
                              ";

                              echo "<form><div class='list-group'><a href='cierra_sesion.php' class='list-group-item list-group-item-action fs-5'><i class='fa-solid fa-right-from-bracket ps-2 pe-3 fs-3 text-secondary'></i></i>Cerrar Sesion</a></div></form>
                              ";
                      }
                  }
                ?>    


              </div>

              <div class="row pb-5">
                <div class="col"></div>
              </div>
          </div><!- DIV DEL CONTENEDOR DEL OFF CANVAS ->
        </div><!- DIV DEL CONTENEDOR OFF CANVAS START ->
      </div><!- DIV DEL TITULO DEL OFF CANVAS ->
    </nav>
  </div><!- DIV DE LA COLUMNA CANVAS IZQUIERDA ->
