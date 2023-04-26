<?php
  //Conexión
  require("conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");
  
  //Carga Head de la página
  require("head.php");
?>

</head>
<body>






<div class="container text-center">

  <div class="row">

    <div class="col-sm">


    <nav class="navbar navbar-expand-sm bg-light">

        <div class="container-fluid">

          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>


          

          <div><a class="navbar-brand d-sm-block d-sm-none" href="#">Roanfood</a></br></div>



          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Opciones</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

          <div class="container text-center">

              <div class="row">
                <a class="navbar-brand d-xs-none d-none d-sm-block" href="#">GRANDE</a></br>
              </div>
              <div class="row">
                asdasd
              </div>
              <div class="row">
                asdasd
              </div>

              <div class="row">
                asdasd
              </div>
          </div>


    </div>
  </div>
</nav>

    </div>

    <div class="col col-lg-8">

      <div class="pt-5">asdfasdfasdfasdfasdf asdfasdfsdadfasdf asdfasdfas dfa sdf asd asdfasdfasdf asdfasdfasdf asdfasdfa</div>

    </div>
  </div>
</div>

</body>


<!-  FOOTER  ->
  <?php 
    //Cierre Conexión
    $conexion->close();

    //Carga los scripts finales
    require("footer.php");
  ?>
</body>
</html>

