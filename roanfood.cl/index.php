
<?php
  //Variables
  $boton_toggler="<button class='navbar-toggler' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar'><span class='navbar-toggler-icon'></span></button>";

  $titulo_navbar="<span class='fs-5'><img class='pe-2' src='images/icon.png' style='width: 48px' /></span>Roanfood <small class='ps-2 opacity-50' style='font-size: 10px'>Sabor Casero</small>";


  
  //Carga Head de la página
  require("head.php");


  //Accede al registro de la fecha actual
      $fecha_menu=date('d/m/Y');
      $consulta_menu_rf="SELECT * FROM `menu_diario_rf` WHERE `fecha` = '$fecha_menu'";
          $confirma_menu_rf=$conexion->query($consulta_menu_rf); 
          $menu_g=$confirma_menu_rf->fetch_assoc();
?>



<div class="col col-sm-8 col-xl-8"> 



<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">

        <div class="carousel-item active">


              <!- ********** INICIO MENU ********** ->
                <div id="container" class="container text-center"  style="background-image: url(images/fondo_menu.jpeg); background-size: 100% auto;">
                <div class="row">
                  <div class="col col-7 text-light"> 

              <?php
                    //CABECERA MENÚ EJECUTIVO
                    echo "
                      <div class='container text-start pt-3'>
                         <div class='row pt-2'>
                          <div class='pt-0 pb-0 text-light text-center' style='font-size: min(max(24px, 3.5vw), 34px)'>MENÚ EJECUTIVO</div>
                          <div class='pt-0 pb-2 text-light text-center opacity-50' style='font-size: min(max(12px, 1.5vw), 20px);font-weight: bold;'>
                    ";

                          $orgDate = date('d/m/Y'); //con $menu_g['fecha'] escribe la base de datos
                          $date = str_replace('/', '-', $orgDate);
                          setlocale(LC_TIME, 'es_CL.UTF-8','esp');
                          echo  strtoupper(strftime('%A %d de %B', strtotime($date)));
                          echo $newDate;

                     echo "
                        </div>
                        <hr class='border-5 opacity-75 text-center' style='width:95%'>
                      </div>";
              ?>
              <?php
                        //INICIO MENÚ EJECUTIVO
                      if($menu_g){
                        echo "
                       <div class='row pt-3'>
                          <div class='col col-6 ms-0 me-0 ps-0'>
                            <img src='images/".$menu_g['foto_1'].".jpg' class='rounded-circle' style='max-width: 100% ; border: 3px solid #555;' />
                          </div>
                          <div class='col col-6 ms-0 me-0 ps-0 pt-1'>
                            <div class='text-start' style='font-size: min(max(12px, 2vw), 22px)'>".$menu_g['opcion_1']."</div>
                            <div class='text-start pt-2 opacity-50' style='font-size: min(max(10px, 1.5vw), 18px)'>".$menu_g['descripcion_1']."</div>
                            <div><hr class='text-muted mt-1 mb-1'></div>
                            <div class='text-end text-warning pt-0 text-nowrap' style='font-size: min(max(12px, 2vw), 22px)'>$ ".number_format($menu_g['precio_1'], 0, ' ', '.')."</div>
                          </div>
                       </div>

                       <div class='row pt-3'>
                          <div class='col col-6 ms-0 me-0 ps-0'>
                            <img src='images/".$menu_g['foto_2'].".jpg' class='rounded-circle' style='max-width: 100% ; border: 3px solid #555;' />
                          </div>
                          <div class='col col-6 ms-0 me-0 ps-0 pt-1'>
                            <div class='text-start' style='font-size: min(max(12px, 2vw), 22px)'>".$menu_g['opcion_2']."</div>
                            <div class='text-start pt-2 opacity-50' style='font-size: min(max(10px, 1.5vw), 18px)'>".$menu_g['descripcion_2']."</div>
                            <div><hr class='text-muted mt-1 mb-1'></div>
                            <div class='text-end text-warning pt-0 text-nowrap' style='font-size: min(max(12px, 2vw), 22px)'>$ ".number_format($menu_g['precio_2'], 0, ' ', '.')."</div>
                          </div>
                       </div>

                       <div class='row pt-3'>
                          <div class='col col-6 ms-0 me-0 ps-0'>
                            <img src='images/".$menu_g['foto_3'].".jpg' class='rounded-circle' style='max-width: 100% ; border: 3px solid #555;' />
                          </div>
                          <div class='col col-6 ms-0 me-0 ps-0 pt-1'>
                            <div class='text-start' style='font-size: min(max(12px, 2vw), 22px)'>".$menu_g['opcion_3']."</div>
                            <div class='text-start pt-2 opacity-50' style='font-size: min(max(10px, 1.5vw), 18px)'>".$menu_g['descripcion_3']."</div>
                            <div><hr class='text-muted mt-1 mb-1'></div>
                            <div class='text-end text-warning pt-0 text-nowrap' style='font-size: min(max(12px, 2vw), 22px)'>$ ".number_format($menu_g['precio_3'], 0, ' ', '.')."</div>
                          </div>
                       </div>

                       <div class='row pt-3 pb-4'>
                          <div class='col col-6 ms-0 me-0 ps-0'>
                            <img src='images/".$menu_g['foto_4'].".jpg' class='rounded-circle' style='max-width: 100% ; border: 3px solid #555;' />
                          </div>
                          <div class='col col-6 ms-0 me-0 ps-0 pt-1'>
                            <div class='text-start' style='font-size: min(max(12px, 2vw), 22px)'>".$menu_g['opcion_4']."</div>
                            <div class='text-start pt-2 opacity-50' style='font-size: min(max(10px, 1.5vw), 18px)'>".$menu_g['descripcion_4']."</div>
                            <div><hr class='text-muted mt-1 mb-1'></div>
                            <div class='text-end text-warning pt-0 text-nowrap' style='font-size: min(max(12px, 2vw), 22px)'>$ ".number_format($menu_g['precio_4'], 0, ' ', '.')."</div>
                          </div>
                       </div>         
                       ";
                     }else{
                      echo "<div class='pt-3 text-center text-light opacity-50' style='font-size: min(max(12px, 1.5vw), 20px);font-weight: bold;'>SIN MENÚ EJECUTIVO PARA HOY</div>";
                     }
              ?>

                    </div> <!- DIV DE LA COLUMNA TOTAL IZQUIERDA ->
                  </div> <!- DIV DE LA FILA TOTAL IZQUIERDA ->



                  <div class="col ps-1 col-5">
                       <div class="row ps-1 pt-2 mt-2">

                        <div class="pt-2 pb-2 text-secondary text-center" style="font-size: min(max(20px, 3vw), 30px)">Hipocalóricos</div>
                        <hr class="border-5 pb-0 mb-0 opacity-50 text-center" style="width:95%">   
                      </div>


                    <?php
                        $consulta_menu_hc="SELECT * FROM `hipocaloricos_rf`";
                        $confirma_menu_hc=$conexion->query($consulta_menu_hc); 
                        $i=0;
                        while($menu_hc=$confirma_menu_hc->fetch_assoc()){
                              $id_hc=$menu_hc['id_hipocaloricos'];
                              $nombre_menu=$menu_hc['nombre_plato_hc'];
                              $descripcion_menu=$menu_hc['descripcion_plato_hc'];
                              $precio_menu=$menu_hc['precio_plato_hc'];
                              $nombre_foto_menu=$menu_hc['nombre_foto_hc'];

                        echo "
                         <div class='row ps-1 pt-2 mt-2'>
                              <li class='list-group-item'><div class='d-flex justify-content-between'>
                              <div class='text-start ps-2' style='font-size: min(max(12px, 2vw), 22px)'>$nombre_menu</div>
                              <div class='text-end pt-0 pe-2 text-nowrap' style='font-size: min(max(12px, 2vw), 22px); color: #D9AD00; font-weight: bold;'>$ ".number_format($precio_menu, 0, ' ', '.')."</div>
                              </li>
                              <div class='text-start pt-1 pb-1 opacity-75' style='font-size: min(max(10px, 1.5vw), 18px)'>$descripcion_menu</div>
                              <div><hr class='text-muted mt-1 mb-1'></div>      
                         </div>
                        ";

                            $i++;
                        }

                      ?>

                       <div class="row ps-2 pt-2 mt-2">
                          <div class="pb-2 text-secondary text-center" style="font-size: min(max(18px, 2.5vw), 26px)">Bebidas</div>
                          <hr class="border-5 pb-1 opacity-50 text-center" style="width:95%">  
                       </div> 

                        <div class="row pt-0 ps-1 pe-1 pb-4">
                            <li class='list-group-item'><div class='d-flex justify-content-between'><div class="text-start pt-1 ms-2" style="font-size: min(max(12px, 2vw), 22px)">Lata 350cc</div><div class="text-end pt-0 me-2 text-nowrap" style="font-size: min(max(12px, 2vw), 20px); color: #D9AD00; font-weight: bold;">$ 1.200</div></div></li>

                            <li class='list-group-item'><div class='d-flex justify-content-between'><div class="text-start pt-1 ms-2" style="font-size: min(max(12px, 2vw), 22px)">Botella 250 cc</div><div class="text-end pt-0 me-2 text-nowrap" style="font-size: min(max(12px, 2vw), 20px); color: #D9AD00; font-weight: bold;">$ 1.000</div></div></li>
                       </div>     

                  </div> <!- DIV DEL LA COLUMNA DE MENU DE LA DERECHA ->

                <hr class="border-0 ms-4 mb-1 text-light opacity-75 text-center" style="height: 2px; width:90%; background-image: linear-gradient(to right, white, black);">

                    <div class="row pt-5">               
                    </div>

              </div> <!- DIV DEL CONTENEDOR DE MENU ->


              <!- ********** FIN DEL MENU ********** ->
      </div> 
      </div><!- FIN DEL DIV DEL ITEM ACTIVE CAROUSEL->



      <div class="carousel-item">
        <div id="container" class="container text-center"  style="background-image: url(images/fondo_menu.jpeg); background-size: 100% auto;">
          <div class="row">

              asdfasdfasdf<br>
              asdfasdfasdf<br>
              asdfasdfasdf<br>
              asdfasdfasdf<br>
              asdfasdfasdf<br>
              asdfasdfasdf<br>

          </div>
        </div>
      </div>

      <div class="carousel-item">
        <div id="container" class="container text-center"  style="background-image: url(images/fondo_menu.jpeg); background-size: 100% auto;">
          <div class="row">
            asdfasdfasdf<br>
            asdfasdfasdf<br>
            asdfasdfasdf<br>
            asdfasdfasdf<br>
            asdfasdfasdf<br>
            asdfasdfasdf<br>
          </div>
        </div>
      </div>

</div> <!- FIN DEL HEADER DEL CAROUSEL ->

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previo</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>



    </div>
  </div><!- DIVISION DE COLUMNA LATERAL DERECHA ->
</div><!- DIV DEL ROW TOTAL ->
</div><!- DIV DEL CONTAINER TOTAL ->

  <?php 
    //Cierre Conexión
    $conexion->close();

    //Carga los scripts finales
    require("footer.php");
  ?>

</body>
</html>

