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
  $boton_navbar="<button class='navbar-toggler text-white shadow-sm' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";

  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">

      <div class="apunte-card mb-3">
        <div class="apunte-hero d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • utilidad interactiva</div>
            <div class="apunte-title">
              <?php echo $icono_apunte; ?>
              <span><?php echo $titulo_apunte; ?></span>
            </div>
          </div>
          <span class="badge rounded-pill text-bg-light text-dark fs-6">Apunte</span>
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
                    <div class='info-label'>Fórmula</div>
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

          <?php
          if($input){
            foreach($input as $clave_input){
              echo "<div class='row calc-row align-items-center g-3'>
                      <div class='col-md-5 text-start calc-label'>".$clave_input[0]."</div>
                      <div class='col-md-7'>
                        <div class='input-group'>
                          <input class='form-control calc-input' type='number' id='".$clave_input[1]."'>
                          <span class='input-group-text'>".$clave_input[2]."</span>
                        </div>
                      </div>
                    </div>";
            }
          }

          if($input_e){
            foreach($input_e as $clave_input_e){
              echo "<div class='row calc-row align-items-center g-3'>
                      <div class='col-md-5 text-start calc-label'>".$clave_input_e[0]."</div>
                      <div class='col-md-7'>
                        <select class='form-select calc-select' id='".$clave_input_e[1]."' name='analgesia' required>";
              foreach($clave_input_e[2] as $selopt => $selvalue){
                echo "<option value='".$selvalue."'>".$selopt."</option>";
              }
              echo "    </select>
                      </div>
                    </div>";
            }
          }

          if($input_ch){
            foreach($input_ch as $clave_input_ch){
              echo "<div class='row calc-row align-items-center g-3'>
                      <div class='col-9 text-start calc-label'>".$clave_input_ch[0]."</div>
                      <div class='col-3 text-end'>
                        <input class='form-check-input fs-5' type='checkbox' id='".$clave_input_ch[1]."'>
                      </div>
                    </div>";
            }
          }
          ?>

          <div class="row pt-4">
            <div class="col">
              <button class="btn btn-primary btn-lg btn-calc-main" onclick="doMath();">
                <i class="fa-solid fa-calculator pe-3"></i>Calcular
              </button>
            </div>
          </div>

          <?php
          foreach($resultado as $clave_result){
            echo "<div class='row calc-row align-items-center g-3 mt-1'>
                    <div class='col-md-5 text-start calc-label'>".$clave_result[0]."</div>
                    <div class='col-md-7'>
                      <div class='input-group calc-result'>
                        <input class='form-control calc-result-input border-0 bg-transparent' type='number' id='".$clave_result[1]."' readonly>
                        <span class='input-group-text border-0 bg-transparent'>".$clave_result[2]."</span>
                      </div>
                    </div>
                  </div>";
          }

          if($elemento_fijo0){
            echo "<div class='pt-4 footer-note'>".$elemento_fijo0."</div>";
          }

          foreach($resultado2 as $clave_result2){
            echo "<div class='row calc-row align-items-center g-3 mt-1'>
                    <div class='col-md-5 text-start calc-label'>".$clave_result2[0]."</div>
                    <div class='col-md-7'>
                      <div class='input-group calc-result'>
                        <input class='form-control calc-result-input border-0 bg-transparent' type='number' id='".$clave_result2[1]."' readonly>
                        <span class='input-group-text border-0 bg-transparent'>".$clave_result2[2]."</span>
                      </div>
                    </div>
                  </div>";
          }
          ?>

          <div id='otro_elemento' class='pt-4'></div>

          <script>
            function doMath() {
              <?php
                foreach($input as $var_input){
                  echo "var ".$var_input[1]."Var = document.getElementById('".$var_input[1]."').value; ";
                }

                foreach($input_e as $var_input_e){
                  echo "var ".$var_input_e[1]."Var = document.getElementById('".$var_input_e[1]."').value; ";
                }

                foreach($input_ch as $var_input_ch){
                  echo "var ".$var_input_ch[1]."Var = document.getElementById('".$var_input_ch[1]."').checked; ";
                }

                foreach($resultado as $var_calc){
                  echo "var ".$var_calc[1]."Var = ".$var_calc[3]."; ";
                }

                foreach($resultado as $var_result){
                  echo "$('#".$var_result[1]."').attr('value', ".$var_result[1]."Var.toFixed(".$var_result[4].")); ";
                }

                foreach($resultado2 as $var_calc2){
                  echo "var ".$var_calc2[1]."Var = ".$var_calc2[3]."; ";
                }

                foreach($resultado2 as $var_result2){
                  echo "$('#".$var_result2[1]."').attr('value', ".$var_result2[1]."Var.toFixed(".$var_result2[4].")); ";
                }

                if($otro_elemento){
                  echo $otro_elemento;
                }
              ?>
            }
          </script>

          <?php
          if($elemento_fijo){
            echo "<div class='pt-4 footer-note'>".$elemento_fijo."</div>";
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
