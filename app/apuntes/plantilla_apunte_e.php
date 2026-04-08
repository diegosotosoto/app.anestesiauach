<?php 
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
          <form id='formPDF' method='post' action='https://anestesiauach.cl/pdf/emergencia_ped_pdf.php' target='_blank'>

            <?php
            if($input){
              foreach($input as $clave_input){
                echo "<div class='row calc-row align-items-center g-3'>
                        <div class='col-md-5 text-start calc-label'>".$clave_input[0]."</div>
                        <div class='col-md-7'>
                          <div class='input-group'>
                            <input class='form-control calc-input' type='number' id='".$clave_input[1]."' name='".$clave_input[1]."'>
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
                          <select class='form-select calc-select' id='".$clave_input_e[1]."' required>";
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

            <script>
              $(document).ready(function() {
                $('#btnCambiar').click(function() {
                  var edadInput = $('#edad').val();
                  var esAnios = $('#btnCambiar').hasClass('anios');
                  var inputNuevo = '';

                  if (esAnios) {
                    inputNuevo = '<input type="number" id="edad" name="edad" class="form-control calc-input" placeholder="Edad"><span class="input-group-text">meses</span><input type="hidden" id="hiddenInput" name="meses" value="1">';
                    $('#btnCambiar').removeClass('anios');
                  } else {
                    inputNuevo = '<input type="number" id="edad" name="edad" class="form-control calc-input" placeholder="Edad"><span class="input-group-text">años</span><input type="hidden" id="hiddenInput" name="anios" value="1">';
                    $('#btnCambiar').addClass('anios');
                  }

                  $('#edadInput').html(inputNuevo);
                  $('#edad').val(edadInput);
                  $('#edad').focus();
                });

                $('#btnCalcular').click(function() {
                  var edadInput = $('#edad').val();
                  var resultadoX = '';
                  var resultadoX2 = '';
                  var resultadoF = '';
                  var resultadoF2 = '';

                  if (edadInput > 0) {
                    if ($('#btnCambiar').hasClass('anios')) {
                      resultadoX = edadInput / 4 + 3.5;
                      resultadoX2 = edadInput / 2 + 12;
                    } else {
                      if (edadInput >= 18 ){
                        resultadoX = edadInput / 12 / 4 + 3.5;
                        resultadoX2 = edadInput / 12 / 2 + 12;
                      } else if (edadInput < 18 && edadInput >= 9 ){
                        resultadoX = 3.5;
                        resultadoX2 = 10.5;
                      } else if (edadInput < 9 && edadInput >= 3 ){
                        resultadoX = 3.0;
                        resultadoX2 = 9.0;
                      } else if (edadInput < 3 ){
                        resultadoX = 2.5;
                        resultadoX2 = 7.5;
                      }
                    }

                    if (resultadoX > 7) {
                      resultadoF = 7;
                      resultadoF2 = 21;
                    } else if (resultadoX < 2.5) {
                      resultadoF = 2.5;
                      resultadoF2 = 7.5;
                    } else {
                      resultadoF = resultadoX;
                      resultadoF2 = resultadoX2;
                    }
                  }

                  $('#resultadoX').attr('value',Math.round(resultadoF * 2) / 2);
                  $('#resultadoX2').attr('value',Math.round(resultadoF2 * 2) / 2);
                });
              });
            </script>

            <div class="row calc-row align-items-center g-3">
              <div class='col-md-5 text-start calc-label'>Edad</div>
              <div class="col-md-5">
                <div class="input-group" id="edadInput">
                  <input type="number" id="edad" name="edad" class="form-control calc-input" placeholder="Edad">
                  <span class="input-group-text">años</span>
                  <input type="hidden" id="hiddenInput" name="anios" value="1">
                </div>
              </div>
              <div class="col-md-2">
                <button class="btn btn-outline-secondary btn-calc-main toggle-pill anios w-100" id="btnCambiar" type="button">
                  <i class="fa-solid fa-rotate"></i>
                </button>
              </div>
            </div>

            <div class="row pt-4 g-3">
              <div class="col-auto">
                <button type="button" class="btn btn-primary btn-calc-main" id="btnCalcular">
                  <i class="fa-solid fa-calculator pe-2"></i>Calcular
                </button>
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-success btn-calc-main">
                  <i class="fa-solid fa-file-pdf pe-2"></i>PDF
                </button>
              </div>
            </div>

            <?php
            foreach($resultado as $clave_result){
              echo "<div class='row calc-row align-items-center g-3 mt-1'>
                      <div class='col-md-5 text-start calc-label'>".$clave_result[0]."</div>
                      <div class='col-md-7'>
                        <div class='input-group calc-result'>
                          <input class='form-control calc-result-input border-0 bg-transparent' type='number' id='".$clave_result[1]."' name='".$clave_result[1]."' readonly>
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

            <?php
            if($elemento_fijo){
              echo "<div class='pt-4 footer-note'>".$elemento_fijo."</div>";
            }
            ?>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
  $conexion->close();
  require("footer.php");
?>
