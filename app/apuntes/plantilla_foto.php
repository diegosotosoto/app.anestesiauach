<?php

/*
  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: ../login.php');
  }
*/
 
  require("../conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");

  $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar="<span class='text-white'>Apuntes</span>";
  $boton_navbar="<button class='navbar-toggler text-white shadow-sm border-light' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";

  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">

      <div class="apunte-card mb-3">
        <div class="apunte-hero d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • recurso visual</div>
            <div class="apunte-title">
              <?php echo $icono_apunte; ?>
              <span><?php echo $titulo_apunte; ?></span>
            </div>
          </div>
          <span class="badge rounded-pill text-bg-light text-dark fs-6">Imagen</span>
        </div>

        <div class="sticky-tools p-3">
          <div class="row g-2 align-items-center">
            <div class="col text-center text-md-start">
              <div class="section-title">Información</div>
            </div>
            <div class="col-auto">
              <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#metaApunte" aria-expanded="false" aria-controls="metaApunte">
                Mostrar / ocultar
              </button>
            </div>
          </div>
        </div>

        <div class="collapse" id="metaApunte">
          <div class="apunte-body pt-0">
            <div class="info-card overflow-hidden">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="info-label"><?php echo $titulo_info; ?></div>
                  <div><?php echo $descripcion_info; ?></div>
                </li>

                <?php
                if($formula){
                  echo "<li class='list-group-item'>
                    <div class='info-label'>Fórmula / Nota</div>
                    <div>$formula</div>
                  </li>";
                }

                if($referencias){
                  echo "<li class='list-group-item'>
                    <div class='info-label'>Referencias</div>
                    <div><small>";
                  foreach ($referencias as $valor) {
                    echo $valor . "<br>";
                  }
                  echo "</small></div></li>";
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="apunte-card">
        <div class="apunte-body">
          <?php if(!empty($elemento_fijo0)){ ?>
            <div class="footer-note mb-3"><?php echo $elemento_fijo0; ?></div>
          <?php } ?>

          <div class="info-card p-3 p-md-4 text-center">
            <?php
              if(!empty($imagen)){
                echo "<image class='pt-3' src='".$imagen."' style='max-width: 100%'/>";
              } elseif(!empty($imagen_html)){
                echo $imagen_html;
              } elseif(!empty($contenido_html)){
                echo $contenido_html;
              } else {
                echo "<div class='text-muted'>No se encontró contenido visual para mostrar.</div>";
              }
            ?>

          </div>

          <?php if(!empty($otro_elemento)){ ?>
            <div id="otro_elemento" class="pt-4">
              <?php echo $otro_elemento; ?>
            </div>
          <?php } ?>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>
