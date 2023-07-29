  

 <!-  INCIO DEL FORMULARIO  ->

<?php

////chk_alerg_med,chk_alerg_alim,chk_alerg_latex,alerg

if($chk_alerg_med == '1' or $chk_alerg_alim == '1' or $chk_alerg_latex == '1'){

	if($chk_alerg_med == '1'){ $med = "<div class='badge fs-6 py-2 bg-danger'>Medicamentos</div>"; }
	if($chk_alerg_alim == '1'){ $alim = "<div class='badge fs-6 py-2 bg-danger'>Alimentos</div>"; }
	if($chk_alerg_latex == '1'){ $latex = "<div class='badge fs-6 py-2 bg-danger'>Látex</div>"; }
	if($alerg !== 'NULL'){ $detalle_alerg_ = "<div class='badge fs-6 py-2 bg-danger'>".$alerg."</div>"; }

	echo "<li class='list-group-item'>
		<div class='badge fs-6 py-2 bg-danger'>Alergia!</div>".$med.$alim.$latex
	.$detalle_alerg_."</li>";


}

?>
	<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><div class="col-9"><img class='btn-imagen' src='images/IMG_3987.PNG'/>Datos Personales</div></li>
	<li class='list-group-item'>

<?php

function generarInputGral($titulo, $required=false, $id, $feedback, $value, $other,$disabled=false,$span) {

		$esconder_campos = $GLOBALS['esconder_campos_nulos'];

		if ($esconder_campos == '1'){

			if($value !== '' and $value !== 'NULL' and $value !== null){

        		if ($required == true){
					$requerido = "Requerido (*)";
					$required = "required";
					$el_feedback = "<div class='invalid-feedback mt-1'>".$feedback."</div>";
				} else {
					$requerido = "";
					$required = "";
					$el_feedback ="";
				}

				if ($disabled == true){
					$disabled = "disabled";
				} else {
					$disabled = "";
				}

				if ($span!==""){
					$span_a="<div class='input-group'>";
					$span_b="<span class='input-group-text' id='basic-addon2'> ".$span."</span></div>";
				}

			    // Generar el texto con el título, contenido y número de elemento
			    $construyeInpunt = "<div class='d-flex justify-content-between mt-3'><div class='text-muted'>".$titulo."</div><div class='fw-lighter text-muted'><small>".$requerido."</small></div></div>
			    		".$span_a."
							<input class='form-control' type='text' name='".$id."' id='".$id."'".$other." value='".$value."' ".$required." ".$disabled.">
						  ".$span_b."	
							".$el_feedback." ";

			} else {
				$construyeInpunt = "";
			}

		} else{

			    if($value=='NULL'){
        			$value = "";
        		}

        		if ($required == true){
					$requerido = "Requerido (*)";
					$required = "required";
					$el_feedback = "<div class='invalid-feedback mt-1'>".$feedback."</div>";
				} else {
					$requerido = "";
					$required = "";
					$el_feedback ="";
				}

				if ($disabled == true){
					$disabled = "disabled";
				} else {
					$disabled = "";
				}

				if ($span!==""){
					$span_a="<div class='input-group'>";
					$span_b="<span class='input-group-text' id='basic-addon2'> ".$span."</span></div>";
				}

			    // Generar el texto con el título, contenido y número de elemento
			    $construyeInpunt = "<div class='d-flex justify-content-between mt-3'><div class='text-muted'>".$titulo."</div><div class='fw-lighter text-muted'><small>".$requerido."</small></div></div>
			    		".$span_a."
							<input class='form-control' type='text' name='".$id."' id='".$id."'".$other." value='".$value."' ".$required." ".$disabled.">
						  ".$span_b."	
							".$el_feedback." ";

		}

    return $construyeInpunt;
}



function generarSelect($titulo, $required = false, $id, $options = [], $selectedValue = "", $disabled = false, $feedback = "")
{

	$esconder_campos = $GLOBALS['esconder_campos_nulos'];


		if ($esconder_campos == '1'){

			if($selectedValue !== '' and $selectedValue !== 'NULL' and $selectedValue !== null){

				    $selectOptions = "";

				    foreach ($options as $value => $label) {
				        $selected = $value == $selectedValue ? "selected" : "";
				        $selectOptions .= "<option value='$value' $selected>$label</option>";
				    }

				    if ($required) {
				        $requerido = "Requerido (*)";
				        $requiredAttr = "required";
				        $el_feedback = "<div class='invalid-feedback pt-1'>$feedback</div>";
				    } else {
				        $requerido = "";
				        $requiredAttr = "";
				        $el_feedback = "";
				    }

				    if ($disabled) {
				        $disabledAttr = "disabled";
				    } else {
				        $disabledAttr = "";
				    }

				    $selectInput = "
				        <div class='d-flex justify-content-between pt-3'>
				            <div class='text-muted'>$titulo</div>
				            <div class='fw-lighter text-muted'><small>$requerido</small></div>
				        </div>
				        <select class='form-select mb-2' id='$id' name='$id' $requiredAttr $disabledAttr>
				            $selectOptions
				        </select>
				        $el_feedback
				    ";
			} else {

				$selectInput = "";
			}


		} else{

				    $selectOptions = "";

				    foreach ($options as $value => $label) {
				        $selected = $value == $selectedValue ? "selected" : "";
				        $selectOptions .= "<option value='$value' $selected>$label</option>";
				    }

				    if ($required) {
				        $requerido = "Requerido (*)";
				        $requiredAttr = "required";
				        $el_feedback = "<div class='invalid-feedback pt-1'>$feedback</div>";
				    } else {
				        $requerido = "";
				        $requiredAttr = "";
				        $el_feedback = "";
				    }

				    if ($disabled) {
				        $disabledAttr = "disabled";
				    } else {
				        $disabledAttr = "";
				    }

				    $selectInput = "
				        <div class='d-flex justify-content-between pt-3'>
				            <div class='text-muted'>$titulo</div>
				            <div class='fw-lighter text-muted'><small>$requerido</small></div>
				        </div>
				        <select class='form-select mb-2' id='$id' name='$id' $requiredAttr $disabledAttr>
				            $selectOptions
				        </select>
				        $el_feedback
				    ";

		}

    return $selectInput;
}


function generarCheckDoble($t_check1, $id_check1, $checked1, $is_disabled, $is_required=false, $always_show=false) {
    // Generar el doble con el título, y contenido con id


if($checked1 !== "1" and $GLOBALS['esconder_campos_nulos'] == "1" and $always_show==false){

  $texto_cd = "";

} else {

		if($is_disabled==true){
			$is_disabled_="disabled";
		}

		if($checked1!=="1"){
			$checked1=""; 
		} else {
			$checked1="checked";
		}

		if($is_required==true){
			$is_required="required";
		} else {
			$is_required="";
		}

   		 $texto_cd = "<div class='col-6'>
						<div class='form-check mx-2'>
						  <input class='form-check-input'  type='checkbox' value='1' id='".$id_check1."' name='".$id_check1."' ".$checked1." ".$is_disabled_." ".$is_required.">
						  <label class='form-check-label float-start opacity-75' for='".$id_check1."'>"
						    .$t_check1.
						  "</label>
						</div>
					</div>";

	}

    return $texto_cd;
}


function generarAccordion($icono, $titulo, $contenido, $valor_elementos=100) {
    // Variable estática para llevar la cuenta de los elementos
    static $nE = 1;

					$show_accordion_ = $GLOBALS['show_accordion'];

					if($show_accordion_ !== 'show'){
						$revision_sistemas = "#revision_sistemas";
					}


	      	if($show_accordion_ == 'show' and $valor_elementos==0){
	      	$badge = "<small class='ms-2 mt-0 badge bg-danger'> Negativo </small>";
					} else {
					$badge = "";
					}


    // Generar el texto con el título, contenido y número de elemento
    $texto = "<div class='accordion-item'>
		    <h2 class='accordion-header' id='headingOne".$nE."'>
	      <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseOne".$nE."' aria-expanded='false' aria-controls='collapseOne".$nE."'>
	      	<i class='".$icono." mt-0 ps-2 pe-4'></i>"
	      	.$titulo.
	      	"".
					$badge.
	      	"</button>
		    </h2>
		    <div id='collapseOne".$nE."' class='accordion-collapse collapse ".$show_accordion_."' aria-labelledby='headingOne".$nE."' data-bs-parent='$revision_sistemas'>
		      <div class='accordion-body'>"
	      	.$contenido.
	      	"</div>
				</div>
			</div>";

    // Incrementar el número de elemento para la próxima llamada
    $nE++;

    return $texto;
}


$array_nombre_paciente = ["Nombre del Paciente",true,"nombre_paciente","Ingrese un Nombre y Dos Apellidos",$nombre_paciente_original,"pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}'", $is_disabled,""];
$array_rut =["Rut (sin puntos ej: 12345678-9)",true,"rut","Ingrese un RUT válido",$rut_original,"oninput='checkRut(this)'",$is_disabled,""];
$array_ficha=["Ficha",true,"ficha","Ingrese un número de ficha válido",$ficha_original,"pattern='[0-9]{1,7}'",$is_disabled,""];
$array_edad = ["Edad",true,"edad","Ingrese un valor válido",$edad_original,"step='0.1'",$is_disabled,"años"];
$array_peso = ["Peso",true,"peso","Ingrese un valor válido",$peso,"step='0.1'",$is_disabled,"Kg"];
$array_talla = ["Talla",false,"talla","Ingrese un valor válido",$talla,"step='0.1'",$is_disabled,"mt"];


	echo generarInputGral(...$array_nombre_paciente);
	echo generarInputGral(...$array_rut);
	echo generarInputGral(...$array_ficha);
	echo generarInputGral(...$array_edad);


$options_sexo = ["" => "","Femenino" => "Femenino","Masculino" => "Masculino","Otro" => "Otro",];

	echo generarSelect("Sexo", true, "sexo", $options_sexo, $sexo_original, $is_disabled, "Ingrese un valor válido");

	echo generarInputGral(...$array_peso);
	echo generarInputGral(...$array_talla);

$array_imc= ["IMC",false,"imc","",$imc,"step='0.1'",true,"Kg/mt2"];

	echo generarInputGral(...$array_imc);

?>
    <script>
        // Función para calcular el IMC
        function calcularIMC() {
            // Obtener los valores ingresados por el usuario
            var peso = parseFloat(document.getElementById("peso").value);
            var talla = parseFloat(document.getElementById("talla").value);

            // Verificar si la talla es válida antes de calcular el IMC
            if (isNaN(talla) || talla <= 0) {
                document.getElementById("imc").value = "";
            } else {
                // Calcular el IMC
                var imc = peso / (talla * talla);

                // Mostrar el resultado en el campo de entrada deshabilitado
                document.getElementById("imc").value = imc.toFixed(2);
            }
        }

        // Escuchar el evento "input" en los campos de entrada de peso y talla
        document.getElementById("peso").addEventListener("input", calcularIMC);
        document.getElementById("talla").addEventListener("input", calcularIMC);
    </script>

				</li>

		<!– SIGNOS VITALES –>
		<div class="accordion" id="eval_pre_anest">
            <div class='accordion-item'>
              <h2 class='accordion-header' id='headingOne'>
                <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapseOne' aria-expanded='false' aria-controls='collapseOne' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                 	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3992.PNG'/>Signos Vitales</div>
                </button>
              </h2>
              <div id='collapseOne' class='accordion-collapse collapse' aria-labelledby='headingOne'>
                <div class='accordion-body'>

		<div class='d-flex justify-content-between pt-3'><div class='text-muted'>PA (PAS / PAD)</div><div class="fw-lighter text-muted"><small></small></div></div>
				<div class="input-group mb-2">

<?php

	$array_pas=["",false,"pas","",$pas,"type='number'  max='300'",$is_disabled,""];
	echo generarInputGral(...$array_pas);

?>
 &nbsp; / &nbsp;

<?php

	$array_pad=["",false,"pad","",$pad,"type='number'  max='300'",$is_disabled,""];
	echo generarInputGral(...$array_pad);

?>
		</div>


<?php

$array_fc = ["FC",false,"fc","",$fc,"type='number' max='250'",$is_disabled,"x min",];
echo generarInputGral(...$array_fc);

$array_sao2 = ["SaO2", false, "sao2", "", $sao2, "type='number' max='100'", $is_disabled, "%"];
echo generarInputGral(...$array_sao2);

$array_fio2 = ["FiO2", false, "fio2", "", $fio2, "type='number' max='100'", $is_disabled, "%"];
echo generarInputGral(...$array_fio2);

$array_temp = ["T°", false, "temp", "", $temp, "type='number' max='100' step='0.1'", $is_disabled, "°C"];
echo generarInputGral(...$array_temp);

?>
                </div>
              </div>
            </div>

		<!– SIGNOS VITALES –>


		<!– DIAGNOSTICO –>

            <div class='accordion-item'>
              <h2 class='accordion-header' id='heading2'>
                <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse2' aria-expanded='false' aria-controls='collapse2' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                 	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3976.PNG'/>Diagnóstico (*)</div>
                </button>
              </h2>
              <div id='collapse2' class='accordion-collapse collapse' aria-labelledby='heading2'>
                <div class='accordion-body'>

<?php

$array_diagnostico = ["Diagnóstico", true, "diagnostico", "Ingrese un valor válido", $diagnostico_original, "class='form-control mb-2' type='text' required", $is_disabled, ""];
echo generarInputGral(...$array_diagnostico);


$array_intervencion = ["Intervención Propuesta", true, "intervencion", "Ingrese un valor válido", $intervencion_original, "class='form-control mb-2' required", $is_disabled, ""];
echo generarInputGral(...$array_intervencion);

$array_fecha_int = ["Fecha Intervención (dd/mm/aaaa)", true, "fecha_int", "", $fecha_int_original, "autocomplete='off'", $is_disabled, ""];
echo generarInputGral(...$array_fecha_int);

$array_cirujano = ["Cirujano", false, "cirujano", "", $cirujano_original, "", $is_disabled, ""];
echo generarInputGral(...$array_cirujano);

$options_riesgo = ["" => "","Bajo" => "Bajo","Intermedio" => "Intermedio","Alto" => "Alto",];
echo generarSelect("Riesgo", true, "riesgo", $options_riesgo, $riesgo_original, $is_disabled, "");

?>

                </div>
              </div>
            </div>
		<!– DIAGNOSTICO –>

		<!– CIRUGIAS PREVIAS –>

            <div class='accordion-item'>
              <h2 class='accordion-header' id='heading21'>
                <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse21' aria-expanded='false' aria-controls='collapse21' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                 	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3980.PNG'/>Cirugías Previas</div>
                </button>
              </h2>
              <div id='collapse21' class='accordion-collapse collapse' aria-labelledby='heading21'>
                <div class='accordion-body'>


<?php

			if ($cirugias_prev_original == "" and $esconder_campos_nulos == "1"){

			} else {
				echo "<div class='text-muted text-start'>Cirugías / Anestesias</div>
			    	<textarea class='form-control mb-2' style='resize: none;' maxlength='250' rows='2' name='cirugias_prev' id='cirugias_prev' $is_disabled_html_ta >$cirugias_prev_original</textarea>";
			   }

			if ($antec_familiares_original == "" and $esconder_campos_nulos == "1"){

			} else {
				echo "<div class='text-muted text-start'>Antecedentes Familiares</div>
			    	<textarea class='form-control mb-2' style='resize: none;' maxlength='250' rows='2' name='antec_familiares' id='antec_familiares' $is_disabled_html_ta >$antec_familiares_original</textarea>";
			   }


				$entrada_dc = "<div class='row'>";
				$salida_dc = "</div>";
				$antec_dc1 = generarCheckDoble('NVPO / Cinetosis', 'nvpo', $nvpo, $is_disabled);
				$antec_dc2 = generarCheckDoble('Sospecha HM', 'hipertermia',$hipertermia, $is_disabled);
				echo $entrada_dc;
				echo $antec_dc1;
				echo $antec_dc2;
				echo $salida_dc;				

?>


                </div>
              </div>
            </div>


		<!– CIRUGIAS PREVIAS –>

		<!– ANTECEDENTES –>
            <div class='accordion-item'>
              <h2 class='accordion-header' id='heading3'>
                <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse3' aria-expanded='false' aria-controls='collapse3' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                 	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3977.PNG'/>Antecedentes / Sistemas</div>
                </button>
              </h2>
              <div id='collapse3' class='accordion-collapse collapse' aria-labelledby='heading3'>
                <div class='accordion-body'>

			
		<div class="accordion" id="revision_sistemas">

<!– Subitem Cardio –>

<?php

$cardio_dc1 = generarCheckDoble('HTA', 'ant_hta',$ant_hta,$is_disabled);
$cardio_dc2 = generarCheckDoble('ICC', 'ant_icc',$ant_icc, $is_disabled);

$cardio_dc3 = generarCheckDoble('IAM', 'ant_iam',$ant_iam, $is_disabled);
$cardio_dc4 = generarCheckDoble('Valvulopatía', 'ant_valv',$ant_valv, $is_disabled);

$cardio_dc5 = generarCheckDoble('C.Coronaria/Angor', 'ant_coronaria',$ant_coronaria, $is_disabled);
$cardio_dc6 = generarCheckDoble('Arritmia', 'ant_arr',$ant_arr, $is_disabled);


$arr_cardio_oth = ["Otro / Detalles",false, "otro_cardio", "", $otro_cardio_original, "", $is_disabled, ""];
$cardio_oth = generarInputGral(...$arr_cardio_oth);


$options_cf_cf = [
    "" => "",
    "CF I" => "CF I",
    "CF II" => "CF II",
    "CF III" => "CF III",
    "CF IV" => "CF IV",
    "No Evaluable" => "No Evaluable",
];

$cardio_cf_cf = generarSelect("Capacidad Funcional", false, "cf_cf", $options_cf_cf,$cf_cf,$is_disabled);


$cont_cardio = "
				<div class='row mx-1'>".$cardio_cf_cf."
				</div>"
				.$entrada_dc
				.$cardio_dc1
				.$cardio_dc2
				.$cardio_dc3
				.$cardio_dc4
				.$cardio_dc5
				.$cardio_dc6
				.$salida_dc				
				.$cardio_oth;


$accordion_cardio = [$cf_cf,$ant_hta,$ant_icc,$ant_iam,$ant_valv,$ant_coronaria,$ant_arr,$otro_cardio_original];


function assignZeroIfAllEmpty($array, &$resultVariable) {
    $isEmpty = true;
    foreach ($array as $element) {
        if ($element !== "NULL" and $element !== "") {
            $isEmpty = false;
            break;
        }
    }

    if ($isEmpty) {
        $resultVariable = 0;
    } else {
         $resultVariable = 100;
    }
}

assignZeroIfAllEmpty($accordion_cardio,$array_cardio);

$ico_cardio = "fa-solid fa-heart-pulse";
$tit_cardio = "Cardiaco";

echo generarAccordion($ico_cardio, $tit_cardio, $cont_cardio, $array_cardio);

?>

<!– Subitem Respiratorio –>

<?php

$respi_dc1 = generarCheckDoble('Asma', 'ant_asma',$ant_asma, $is_disabled);
$respi_dc2 = generarCheckDoble('SAHOS', 'ant_sahos',$ant_sahos, $is_disabled);
$respi_dc3 = generarCheckDoble('EPOC', 'ant_epoc',$ant_epoc, $is_disabled);
$respi_dc4 = generarCheckDoble('Usuario O2', 'ant_o2',$ant_o2, $is_disabled);
$respi_dc5 = generarCheckDoble('IRA / NAC', 'ant_nac',$ant_nac, $is_disabled);
$respi_dc6 = generarCheckDoble('Tos', 'ant_tos',$ant_tos, $is_disabled);

$arr_respi_oth = ["Otro / Detalles",false, "otro_respirat", "", $otro_respirat_original, "", $is_disabled, ""];
$respi_oth = generarInputGral(...$arr_respi_oth);

$cont_respi = 	$entrada_dc
				.$respi_dc1
				.$respi_dc2
				.$respi_dc3
				.$respi_dc4
				.$respi_dc5
				.$respi_dc6
				.$salida_dc				
				.$respi_oth;


$accordion_respi = [$ant_asma,$ant_sahos,$ant_epoc,$ant_o2,$ant_nac,$ant_tos,$otro_respirat_original];
assignZeroIfAllEmpty($accordion_respi,$array_respi);


$ico_respi = "fa-solid fa-lungs";
$tit_respi = "Respiratorio";

echo generarAccordion($ico_respi, $tit_respi, $cont_respi,$array_respi);

?>

<!– Subitem Neurológico –>

<?php

$neuro_dc1 = generarCheckDoble('Convulsiones', 'ant_convuls',$ant_convuls, $is_disabled);
$neuro_dc2 = generarCheckDoble('ACV / TIA', 'ant_acv',$ant_acv, $is_disabled);
$neuro_dc3 = generarCheckDoble('PIC Elevada', 'ant_pic',$ant_pic, $is_disabled);
$neuro_dc4 = generarCheckDoble('Cefalea', 'ant_cefalea',$ant_cefalea, $is_disabled);
$neuro_dc5 = generarCheckDoble('Vértigo', 'ant_vertigo',$ant_vertigo, $is_disabled);
$neuro_dc6 = generarCheckDoble('Daño Medular', 'ant_medula',$ant_medula, $is_disabled);
$arr_neuro_oth = ["Otro / Detalles / Glasgow",false, "otro_neuro", "", $otro_neuro_original, "", $is_disabled, ""];
$neuro_oth = generarInputGral(...$arr_neuro_oth);


$accordion_neuro = [$ant_convuls,$ant_acv,$ant_pic,$ant_cefalea,$ant_vertigo,$ant_medula,$otro_neuro_original];
assignZeroIfAllEmpty($accordion_neuro,$array_neuro);


$ico_neuro = "fa-solid fa-brain";
$tit_neuro = "Neurológico";

$cont_neuro = 	$entrada_dc
				.$neuro_dc1
				.$neuro_dc2
				.$neuro_dc3
				.$neuro_dc4
				.$neuro_dc5
				.$neuro_dc6
				.$salida_dc				
				.$neuro_oth;


echo generarAccordion($ico_neuro,$tit_neuro,$cont_neuro,$array_neuro);

?>

<!– Subitem Hepático –>

<?php

$hepato_dc1 = generarCheckDoble('Hepatitis', 'ant_hepatitis',$ant_hepatitis, $is_disabled);
$hepato_dc2 = generarCheckDoble( 'Cirrosis', 'ant_cirrosis',$ant_cirrosis, $is_disabled);
$hepato_dc3 = generarCheckDoble('Ictericia', 'ant_ictericia',$ant_ictericia, $is_disabled);
$hepato_dc4 = generarCheckDoble('Ascitis', 'ant_ascitis',$ant_ascitis, $is_disabled);

$arr_hepato_oth = ["Otro / Detalles / CHILD-MELD",false, "otro_hepatico", "", $otro_hepatico_original, "", $is_disabled, ""];
$hepato_oth = generarInputGral(...$arr_hepato_oth);

$accordion_hepato = [$ant_hepatitis,$ant_cirrosis,$ant_ictericia,$ant_ascitis,$otro_hepatico_original];
assignZeroIfAllEmpty($accordion_hepato,$array_hepato);


$ico_hepato = "fa-solid fa-gears";
$tit_hepato = "Hepático";

$cont_hepato = 	$entrada_dc
				.$hepato_dc1
				.$hepato_dc2
				.$hepato_dc3
				.$hepato_dc4
				.$salida_dc				
				.$hepato_oth;


echo generarAccordion($ico_hepato,$tit_hepato,$cont_hepato,$array_hepato);

?>


<!– Subitem Renal –>

<?php

$nefro_dc1 = generarCheckDoble('ERC', 'ant_erc',$ant_erc, $is_disabled);
$nefro_dc2 = generarCheckDoble( 'AKI', 'ant_aki',$ant_aki, $is_disabled);
$nefro_dc3 = generarCheckDoble( 'Hemodiálisis', 'chk_hd',$chk_hd, $is_disabled);

$arr_nefro_oth = ["Otro / Detalles / VFG",false, "otro_renal", "", $otro_renal_original, "", $is_disabled, ""];
$nefro_oth = generarInputGral(...$arr_nefro_oth);


$accordion_nefro = [$ant_erc,$ant_aki,$chk_hd,$ultima_hd,$otro_renal_original];
assignZeroIfAllEmpty($accordion_nefro,$array_nefro);


$ico_nefro = "fa-solid fa-filter";
$tit_nefro= "Renal";

$arr_nefro_uhd = ["Última Diálisis",false, "ultima_hd", "", $ultima_hd, "class='form-control my-input2'", true, ""];
$nefro_ultima_hd = generarInputGral(...$arr_nefro_uhd);


$cont_nefro = 	$entrada_dc
				.$nefro_dc1
				.$nefro_dc2
				.$nefro_dc3
				.$salida_dc
				.$nefro_ultima_hd
				."<script>
				$(document).ready(function() {
				  $('#chk_hd').change(function() {
				    if ($(this).is(':checked')) {
				      $('#ultima_hd').prop('disabled', false); //SUBITEM NO ES REQUIRED
				      $('#ultima_hd').prop('required', true);		      
				    } else {
				      $('#ultima_hd').prop('disabled', true);
				      $('#ultima_hd').prop('required', false);						      
				    }
				  });
				});
				</script>"
				.$nefro_oth;


echo generarAccordion($ico_nefro,$tit_nefro,$cont_nefro,$array_nefro);

?>

<!– Subitem Gastrointestinal –>

<?php

$gastro_dc1 = generarCheckDoble('Reflujo GE', 'ant_rge',$ant_rge,  $is_disabled);
$gastro_dc2 = generarCheckDoble('H. Hiatal', 'ant_hiatal',$ant_hiatal, $is_disabled);
$gastro_dc3 = generarCheckDoble('Ulcera GD', 'ant_ugd',$ant_ugd,$is_disabled);
$gastro_dc4 = generarCheckDoble('Obstr. Intestinal', 'ant_obstr',$ant_obstr, $is_disabled);
$gastro_dc5 = generarCheckDoble('Gastritis Ag/Cr', 'ant_gastritis',$ant_gastritis, $is_disabled);
$gastro_dc6 = generarCheckDoble('Vómito/Diarrea', 'ant_vomito',$ant_vomito, $is_disabled);

$arr_gastro_oth = ["Otro / Detalles",false, "otro_gastro", "", $otro_gastro_original, "", $is_disabled, ""];
$gastro_oth = generarInputGral(...$arr_gastro_oth);

$accordion_gastro = [$ant_rge,$ant_hiatal,$ant_ugd,$ant_obstr,$ant_gastritis,$ant_vomito,$otro_gastro_original];
assignZeroIfAllEmpty($accordion_gastro,$array_gastro);

$ico_gastro = "fa-solid fa-cookie-bite";
$tit_gastro = "Gastrointestinal";

$cont_gastro = 	$entrada_dc
				.$gastro_dc1
				.$gastro_dc2
				.$gastro_dc3
				.$gastro_dc4
				.$gastro_dc5
				.$gastro_dc6	
				.$salida_dc	
				.$gastro_oth;


echo generarAccordion($ico_gastro,$tit_gastro,$cont_gastro,$array_gastro);

?>

<!– Subitem Hematología –>

<?php

$hemato_dc1 = generarCheckDoble('Anemia', 'ant_anemia',$ant_anemia, $is_disabled);
$hemato_dc2 = generarCheckDoble('Tx Previas', 'ant_tx',$ant_tx, $is_disabled);
$hemato_dc3 = generarCheckDoble('Coagulopatía', 'ant_coagulop',$ant_coagulop, $is_disabled);
$hemato_dc4 = generarCheckDoble('R.Adversa Tx', 'ant_reactx',$ant_reactx, $is_disabled);
$hemato_dc5 = generarCheckDoble('Trombocitopenia', 'ant_trombocit',$ant_trombocit,$is_disabled);
$hemato_dc6 = generarCheckDoble( 'Recibe Tx.', 'ant_aceptatx',$ant_aceptatx, $is_disabled);

$arr_hemato_oth = ["Otro / Detalles",false, "otro_hemato", "", $otro_hemato_original, "", $is_disabled, ""];
$hemato_oth = generarInputGral(...$arr_hemato_oth);


$accordion_hemato = [$ant_anemia,$ant_tx,$ant_coagulop,$ant_reactx,$ant_trombocit,$ant_aceptatx,$otro_hemato_original];
assignZeroIfAllEmpty($accordion_hemato,$array_hemato);

$ico_hemato = "fa-solid fa-droplet";
$tit_hemato = "Hematología";

$cont_hemato = 	$entrada_dc
				.$hemato_dc1
				.$hemato_dc2
				.$hemato_dc3
				.$hemato_dc4
				.$hemato_dc5
				.$hemato_dc6
				.$salida_dc							
				.$hemato_oth;


echo generarAccordion($ico_hemato,$tit_hemato,$cont_hemato,$array_hemato);

?>


<!– Subitem Endocrino –>

<?php

$endocrino_dc1 = generarCheckDoble('Hipotiroidismo', 'ant_hipot',$ant_hipot, $is_disabled);
$endocrino_dc2 = generarCheckDoble('Diabetes', 'ant_dm',$ant_dm, $is_disabled);
$endocrino_dc3 = generarCheckDoble('Hipertiroidismo', 'ant_hipert',$ant_hipert, $is_disabled);
$endocrino_dc4 = generarCheckDoble('Uso Corticoides', 'ant_corticoid',$ant_corticoid, $is_disabled);

$arr_endocrino_oth = ["Otro / Detalles",false, "otro_endocrino", "", $otro_endrocrino_original, "", $is_disabled, ""];
$endocrino_oth = generarInputGral(...$arr_endocrino_oth);

$accordion_endocrino = [$ant_hipot,$ant_dm,$ant_hipert,$ant_corticoid,$otro_endrocrino_original];
assignZeroIfAllEmpty($accordion_endocrino,$array_endocrino);

$ico_endocrino = "fa-solid fa-cloud";
$tit_endocrino = "Endocrino";

$cont_endocrino = $entrada_dc
				.$endocrino_dc1
				.$endocrino_dc2
				.$endocrino_dc3
				.$endocrino_dc4
				.$salida_dc			
				.$endocrino_oth;


echo generarAccordion($ico_endocrino,$tit_endocrino,$cont_endocrino,$array_endocrino);

?>

<!– Subitem Musculoesquelético –>

<?php

$musculo_dc1 = generarCheckDoble('Dolor Lumbar', 'ant_dlumbar',$ant_dlumbar, $is_disabled);
$musculo_dc2 = generarCheckDoble('Artritis/AR', 'ant_artritis',$ant_artritis, $is_disabled);
$musculo_dc3 = generarCheckDoble('Distrofia Muscular', 'ant_distrofia',$ant_distrofia, $is_disabled);
$musculo_dc4 = generarCheckDoble('Escoliosis', 'ant_escoliosis',$ant_escoliosis, $is_disabled);

$arr_musculo_oth = ["Otro / Detalles",false, "otro_musculo", "", $otro_musculo_original, "", $is_disabled, ""];
$musculo_oth = generarInputGral(...$arr_musculo_oth);

$accordion_musculo = [$ant_dlumbar,$ant_artritis,$ant_distrofia,$ant_escoliosis,$otro_musculo_original];
assignZeroIfAllEmpty($accordion_musculo,$array_musculo);

$ico_musculo = "fa-solid fa-person-running";
$tit_musculo = "Musculoesquelético";

$cont_musculo = $entrada_dc
				.$musculo_dc1
				.$musculo_dc2
				.$musculo_dc3
				.$musculo_dc4
				.$salida_dc
				.$musculo_oth;


echo generarAccordion($ico_musculo,$tit_musculo,$cont_musculo,$array_musculo);

?>

<!– Subitem Salud Mental –>

<?php

$mental_dc1 = generarCheckDoble('Depresión', 'ant_depresion',$ant_depresion, $is_disabled);
$mental_dc2 = generarCheckDoble('Esquizofrenia', 'ant_eqz',$ant_eqz, $is_disabled);
$mental_dc3 = generarCheckDoble('Tr. Ansiedad', 'ant_ansiedad',$ant_ansiedad, $is_disabled);
$mental_dc4 = generarCheckDoble('Psicofármacos', 'ant_psicofarmacos',$ant_psicofarmacos, $is_disabled);

$arr_mental_oth = ["Otro / Detalles",false, "otro_mental", "", $otro_mental_original, "", $is_disabled, ""];
$mental_oth = generarInputGral(...$arr_mental_oth);

$accordion_mental = [$ant_depresion,$ant_eqz,$ant_ansiedad,$ant_psicofarmacos,$otro_mental_original];
assignZeroIfAllEmpty($accordion_mental,$array_mental);

$ico_mental = "fa-solid fa-face-frown";
$tit_mental = "Salud Mental";

$cont_mental = 	$entrada_dc
				.$mental_dc1
				.$mental_dc2
				.$mental_dc3
				.$mental_dc4
				.$salida_dc
				.$mental_oth;


echo generarAccordion($ico_mental,$tit_mental,$cont_mental,$array_mental);

?>

<!– Subitem Ginecológico–>

<?php

$gine_dc1 = generarCheckDoble('ACO', 'ant_aco',$ant_aco, $is_disabled);
$gine_dc2 = generarCheckDoble('Menopausia', 'ant_meno',$ant_meno, $is_disabled);

$arr_gine_formula = ["Fórmula Obstétrica",false, "ant_formulaob", "", $ant_formulaob, "", $is_disabled, ""];
$gine_formula = generarInputGral(...$arr_gine_formula);

$arr_gine_oth = ["Otro / Detalles",false, "otro_gine", "", $otro_gine_original, "", $is_disabled, ""];
$gine_oth = generarInputGral(...$arr_gine_oth);

$arr_gine_oth = ["Otro / Detalles",false, "otro_gine", "", $otro_gine_original, "", $is_disabled, ""];
$gine_oth = generarInputGral(...$arr_gine_oth);

$arr_ant_fur = ["Fecha Última Regla (dd/mm/aaaa)",false, "ant_fur", "", $ant_fur, "autocomplete='off'", $is_disabled, ""];
$gine_ant_fur = generarInputGral(...$arr_ant_fur);


$accordion_gine = [$ant_aco,$ant_meno,$ant_formulaob,$ant_fur,$otro_gine_original];
assignZeroIfAllEmpty($accordion_gine,$array_gine);

$ico_gine = "fa-solid fa-person-pregnant";
$tit_gine = "Ant. Gineco-Ostétricos";





$cont_gine = 	$entrada_dc
				.$gine_dc1
				.$gine_dc2
				.$salida_dc
				.$gine_ant_fur
				.$gine_formula
				.$gine_oth;


echo generarAccordion($ico_gine,$tit_gine,$cont_gine,$array_gine);

?>


            </div>
            </div>
            </div>    	

		<!– ANTECEDENTES –>


		<!– ESTADO ACTUAL –>
            <div class='accordion-item'>
              <h2 class='accordion-header' id='heading22'>
                <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse22' aria-expanded='false' aria-controls='collapse22' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                 	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_4231.PNG'/>Estado Actual / Hábitos</div>
                </button>
              </h2>
              <div id='collapse22' class='accordion-collapse collapse' aria-labelledby='heading22'>
                <div class='accordion-body'>

<?php




function transformaInput($value){
	if($value=='NULL'){
		$value = "";
	}
	return $value;
}

$e_gestacional = transformaInput($e_gestacional);
$frecuencia_oh = transformaInput($frecuencia_oh);
$cig_dia = transformaInput($cig_dia);
$detalle_drogas = transformaInput($detalle_drogas);

?>

				<div class="row">

<?php
echo generarCheckDoble('Embarazo', 'chk_emb',$chk_emb, $is_disabled);
?>
					<div class="col-6 px-2">
					</div>
					<div class="col-4 px-2">
					</div>
					<div class="col-8 px-2">
<?php

$arr_e_estacional = ["E.Gestacional",false, "e_gestacional", "", $e_gestacional, "autocomplete='off'", true, ""];
echo generarInputGral(...$arr_e_estacional);

?>
					</div>
				</div>

				<div class="row">

<?php
echo generarCheckDoble('OH', 'chk_oh',$chk_oh, $is_disabled);
?>
					<div class="col-6 px-2">
					</div>
					<div class="col-4 px-2">
					</div>
					<div class="col-8 px-2">
<?php

				$arr_frec_oh = ["Frecuencia",false, "frecuencia_oh", "", $frecuencia_oh, "autocomplete='off'", true, ""];
				echo generarInputGral(...$arr_frec_oh);

?>
					</div>
				</div>

				<div class="row">

<?php
echo generarCheckDoble('Tabaco', 'chk_tabaco',$chk_tabaco, $is_disabled);
?>
	
					<div class="col-6 px-2">
					</div>
					<div class="col-4 px-2">
					</div>
					<div class="col-8 px-2">

<?php

				$arr_cig_dia = ["Cigarrillos /dia",false, "cig_dia", "", $cig_dia, "autocomplete='off'", true, ""];
				echo generarInputGral(...$arr_cig_dia);

?>						
					</div>
				</div>

				<div class="row">


<?php
echo generarCheckDoble('Drogas', 'chk_drogas',$chk_drogas, $is_disabled);
?>
	
					<div class="col-6 px-2">
					</div>
					<div class="col-4 px-2">
					</div>

					<div class="col-8 px-2">
<?php

				$arr_detalle_drogas = ["Detalle",false, "detalle_drogas", "", $detalle_drogas, "autocomplete='off'", true, ""];
				echo generarInputGral(...$arr_detalle_drogas);

?>	
					</div>
				</div>


				<script>
				$(document).ready(function() {
				  $('#chk_emb').change(function() {
				    if ($(this).is(':checked')) {
				      $('#e_gestacional').prop('disabled', false);
				    } else {
				      $('#e_gestacional').prop('disabled', true);
				    }
				  });
				  $('#chk_oh').change(function() {
				    if ($(this).is(':checked')) {
				      $('#frecuencia_oh').prop('disabled', false);
				    } else {
				      $('#frecuencia_oh').prop('disabled', true);
				    }
				  });
				  $('#chk_tabaco').change(function() {
				    if ($(this).is(':checked')) {
				      $('#cig_dia').prop('disabled', false);
				    } else {
				      $('#cig_dia').prop('disabled', true);
				    }
				  });
				  $('#chk_drogas').change(function() {
				    if ($(this).is(':checked')) {
				      $('#detalle_drogas').prop('disabled', false);
				    } else {
				      $('#detalle_drogas').prop('disabled', true);
				    }
				  });
				});
				</script>

                </div>
              </div>
            </div>


		<!– ESTADO ACTUAL –>



		<!– MEDICAMENTOS ACTUALES–>

            <div class='accordion-item'>
              <h2 class='accordion-header' id='heading31'>
                <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse31' aria-expanded='false' aria-controls='collapse31' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                 	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3988.PNG'/>Indicaciones Actuales</div>
                </button>
              </h2>
              <div id='collapse31' class='accordion-collapse collapse' aria-labelledby='heading31'>
                <div class='accordion-body'>

<?php

$options_anticoagulacion = [
    "" => "",
    "Ninguna" => "Ninguna",
    "Heparina SC profilaxis" => "Heparina SC profilaxis",
    "TACO" => "TACO",
    "NOAC" => "NOAC",
    "AAS" => "AAS",
    "Doble Antiagregación" => "Doble Antiagregación",
    "Otra (Comentarios)" => "Otra (Comentarios)",
];

echo generarSelect("Anticoagulación", false, "anticoagulante", $options_anticoagulacion,$anticoagulante_original,$is_disabled);

// Indicación 1
$array_indic1 = ["Indicación 1", false, "indic1", "", $indic1_original, "autocomplete ='off'", $is_disabled, ""];
echo generarInputGral(...$array_indic1);

// Indicación 2
$array_indic2 = ["Indicación 2", false, "indic2", "", $indic2_original, "autocomplete ='off'", $is_disabled, ""];
echo generarInputGral(...$array_indic2);

// Indicación 3
$array_indic3 = ["Indicación 3", false, "indic3", "", $indic3_original, "autocomplete ='off'", $is_disabled, ""];
echo generarInputGral(...$array_indic3);

// Indicación 4
$array_indic4 = ["Indicación 4", false, "indic4", "", $indic4_original, "autocomplete ='off'", $is_disabled, ""];
echo generarInputGral(...$array_indic4);

// Indicación 5
$array_indic5 = ["Indicación 5", false, "indic5", "", $indic5_original, "autocomplete ='off'", $is_disabled, ""];
echo generarInputGral(...$array_indic5);

// Indicación 6
$array_indic6 = ["Indicación 6", false, "indic6", "", $indic6_original, "autocomplete ='off'", $is_disabled, ""];
echo generarInputGral(...$array_indic6);


?>

                </div>
              </div>
            </div>



		<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><div class="col-9"><img class='btn-imagen' src='images/IMG_3982.PNG'/> Alergias (*)</div></li>


<?php

?>
		<li class='list-group-item'>
				<div class="row py-3">
<?php
echo generarCheckDoble('Sí', 'chk_alerg',$chk_alerg, $is_disabled, $is_required,true);

echo generarCheckDoble('No', 'chk_alerg_no',$chk_alerg_no, $is_disabled, $is_required,true);
?>
	<div class="row py-4">	
<?php
echo generarCheckDoble('Medicamentos', 'chk_alerg_med',$chk_alerg_med,$is_disabled, false, true);

echo generarCheckDoble('Alimentos', 'chk_alerg_alim',$chk_alerg_alim,$is_disabled, false, true);

echo generarCheckDoble('Látex', 'chk_alerg_latex',$chk_alerg_latex,$is_disabled, false, true);
?>
						
					</div>	
					<div class="row ps-4"><div class="col">

<?php
			$array_alerg_det = ["Detalle Alimento/Medicamento", false, "alerg", "", $alerg, "class='form-control my-input' autocomplete ='off'", $is_disabled, ""];
			echo generarInputGral(...$array_alerg_det);
?>
					</div>

					</div>

				<script>
				$(document).ready(function() {
				  $('#chk_alerg').change(function() {
				    if ($(this).is(':checked')) {
				      $('#chk_alerg_med').removeClass("opacity-50");	//ACTIVA SUBITEMS
				      $('#chk_alerg_alim').removeClass("opacity-50");	//ACTIVA SUBITEMS
				      $('#chk_alerg_latex').removeClass("opacity-50");	//ACTIVA SUBITEMS
				      $('#chk_alerg_med').prop('disabled', false); //ACTIVA SUBITEMS
				      $('#chk_alerg_alim').prop('disabled', false); //ACTIVA SUBITEMS
				      $('#chk_alerg_latex').prop('disabled', false); //ACTIVA SUBITEMS

				      $('#chk_alerg_no').prop('disabled', true); //DESACTIVA NO
				      $('#chk_alerg_no').addClass("opacity-50"); //DESACTIVA NO

				      $('#chk_alerg_no').prop('required', false); //NO YA NO ES REQUIRED
				      $('#chk_alerg_med').prop('required', true); //SUBITEM REQUIRED
				      $('#chk_alerg_alim').prop('required', true); //SUBITEM REQUIRED
				      $('#chk_alerg_latex').prop('required', true); //SUBITEM REQUIRED
				      $('#alerg').prop('required', true); //DETALLE REQUIRED
				    } else {
				      $('#chk_alerg_med').prop('disabled', true); //DESACTIVA SUBITEMS
				      $('#chk_alerg_alim').prop('disabled', true); //DESACTIVA SUBITEMS
				      $('#chk_alerg_latex').prop('disabled', true); //DESACTIVA SUBITEMS

				      $('#chk_alerg_med').addClass("opacity-50"); //DESACTIVA SUBITEMS
				      $('#chk_alerg_alim').addClass("opacity-50"); //DESACTIVA SUBITEMS
				      $('#chk_alerg_latex').addClass("opacity-50"); //DESACTIVA SUBITEMS


				      $('#chk_alerg_no').prop('disabled', false); //ACTIVA NO
				      $('#chk_alerg_no').removeClass("opacity-50"); //ACTIVA NO
				      $('#chk_alerg_no').prop('required', true); //NO  ES REQUIRED
				      $('#chk_alerg_med').prop('required', false); //SUBITEM NO ES REQUIRED
				      $('#chk_alerg_alim').prop('required', false); //SUBITEM NO ES REQUIRED
				      $('#chk_alerg_latex').prop('required', false); //SUBITEM NO ES REQUIRED
				      $('#alerg').prop('required', false); //DETALLE NO ES REQUIRED
				      $('#label_detalles').text('Detalles'); //DETALLE REQUIRED				      
				    }
				  });

				  $('#chk_alerg_no').change(function() {
				    if ($(this).is(':checked')) {
				      $('#chk_alerg').prop('disabled', true); //DESACTIVA NO
				      $('#chk_alerg').addClass("opacity-50"); //DESACTIVA si
				      $('#chk_alerg').prop('required', false); //SI YA NO ES REQUIRED
				    } else {
				      $('#chk_alerg').prop('disabled', false); //ACTIVA si
				      $('#chk_alerg').removeClass("opacity-50"); //ACTIVA si
				      $('#chk_alerg').prop('required', true); //SI  ES REQUIRED
				    }
				  });

				  $('#chk_alerg_med').change(function() {
				    if ($(this).is(':checked')) {
				      $('#chk_alerg_alim').prop('required', false); //ALIM NO ES REQUIRED
				      $('#chk_alerg_latex').prop('required', false); //LATEX NO ES REQUIRED
				    } else {
						    if ($('#chk_alerg_alim').is(':checked') || $('#chk_alerg_latex').is(':checked')) {
						      $('#chk_alerg_alim').prop('required', false); //ALIM NO ES REQUIRED
						      $('#chk_alerg_latex').prop('required', false); //LATEX NO ES REQUIRED
						    } else {
						      $('#chk_alerg_alim').prop('required', true); //ALIM ES REQUIRED
						      $('#chk_alerg_latex').prop('required', true); //LATEX ES REQUIRED
						      $('#chk_alerg_med').prop('required', true); //LATEX ES REQUIRED						      
				  		}
				    }
				  });

				  $('#chk_alerg_alim').change(function() {
				    if ($(this).is(':checked')) {
				      $('#chk_alerg_med').prop('required', false); //ALIM NO ES REQUIRED
				      $('#chk_alerg_latex').prop('required', false); //LATEX NO ES REQUIRED
				    } else {
						    if ($('#chk_alerg_med').is(':checked') || $('#chk_alerg_latex').is(':checked')) {
						      $('#chk_alerg_med').prop('required', false); //ALIM NO ES REQUIRED
						      $('#chk_alerg_latex').prop('required', false); //LATEX NO ES REQUIRED
						    } else {
						      $('#chk_alerg_med').prop('required', true); //ALIM ES REQUIRED
						      $('#chk_alerg_latex').prop('required', true); //LATEX ES REQUIRED
						      $('#chk_alerg_alim').prop('required', true); //LATEX ES REQUIRED						      
				  		}
				    }
				  });

				  $('#chk_alerg_latex').change(function() {
				    if ($(this).is(':checked')) {
				      $('#chk_alerg_med').prop('required', false); //ALIM NO ES REQUIRED
				      $('#chk_alerg_alim').prop('required', false); //LATEX NO ES REQUIRED
				    } else {

						    if ($('#chk_alerg_med').is(':checked') || $('#chk_alerg_alim').is(':checked')) {
						      $('#chk_alerg_med').prop('required', false); //ALIM NO ES REQUIRED
						      $('#chk_alerg_alim').prop('required', false); //LATEX NO ES REQUIRED
						    } else {
						      $('#chk_alerg_med').prop('required', true); //ALIM ES REQUIRED
						      $('#chk_alerg_alim').prop('required', true); //LATEX ES REQUIRED
						      $('#chk_alerg_latex').prop('required', true); //LATEX ES REQUIRED
				  		}
				    }
				  });
				});
				</script>

		</li>

		<!– MEDICAMENTOS ACTUALES–>

		<!– EXAMEN FÍSICO –>

            <div class='accordion-item'>
              <h2 class='accordion-header' id='heading4'>
                <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse4' aria-expanded='false' aria-controls='collapse4' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
                 	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3987.PNG'/>Exámen Físico</div>
                </button>
              </h2>
              <div id='collapse4' class='accordion-collapse collapse' aria-labelledby='heading4'>
                <div class='accordion-body'>

<?php

// Cardiaco
$array_cardiaco = ["Cardiaco", false, "cardiaco", "", $cardiaco_original, "class='form-control mb-2'", $is_disabled, ""];
echo generarInputGral(...$array_cardiaco);

// Pulmonar
$array_pulmonar = ["Pulmonar", false, "pulmonar", "", $pulmonar_original, "class='form-control mb-2'", $is_disabled, ""];
echo generarInputGral(...$array_pulmonar);

// Neurológico
$array_neurologico = ["Neurológico", false, "neurologico", "", $neurologico_original, "class='form-control mb-2'", $is_disabled, ""];
echo generarInputGral(...$array_neurologico);

// Sitios de Punción
$array_puncion = ["Sitios de Punción", false, "puncion", "", $puncion_original, "class='form-control mb-2'", $is_disabled, ""];
echo generarInputGral(...$array_puncion);

// Otro
$array_ef_otro = ["Otro", false, "ef_otro", "", $ef_otro_original, "class='form-control mb-2'", $is_disabled, ""];
echo generarInputGral(...$array_ef_otro);


$options_dolor_eva = [
    "" => "",
    "0" => "0",
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
    "5" => "5",
    "6" => "6",
    "7" => "7",
    "8" => "8",
    "9" => "9",
    "10" => "10",
];
echo generarSelect("Dolor (EVA)", false, "eva", $options_dolor_eva,$eva_original,$is_disabled);


?>

			</div>
			</div>
			</div>

		<!– EXAMEN FÍSICO –>


		<!– EVALUACIÓN DE VÍA AÉREA>
        <div class='accordion-item'>
          <h2 class='accordion-header' id='heading5'>
            <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse5' aria-expanded='false' aria-controls='collapse5' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
             	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3986.PNG'/>Vía Aérea (*)</div>
            </button>
          </h2>
          <div id='collapse5' class='accordion-collapse collapse' aria-labelledby='heading5'>
            <div class='accordion-body'>



				<div class='row'>

<?php
echo generarCheckDoble('Antec. VAD Previa', 'antec_vad',$antec_vad, $is_disabled);
?>


				</div>


<?php

$options_mallampati = [
    "" => "",
    "0" => "0",
    "I" => "I",
    "II" => "II",
    "III" => "III",
    "IV" => "IV",
];
echo generarSelect("Mallampati", false, "mallampati", $options_mallampati,htmlspecialchars_decode($mallampati),$is_disabled);

$options_dtm = [
    "" => "",
    "< 6 cm" => "< 6 cm",
    "6 - 6.5 cm" => "6 - 6.5 cm",
    "> 6.5 cm" => "> 6.5 cm",
];
echo generarSelect("Distancia Tiromentoniana", false, "dtm",$options_dtm,htmlspecialchars_decode($dtm),$is_disabled);

$options_movilidad_cervical = [
    "" => "",
    "Normal (>80 grados)" => "Normal (>80 grados)",
    "Reducida (<80 grados)" => "Reducida (<80 grados)",
    "Muy reducida" => "Muy reducida",
];
echo generarSelect("Movilidad Cervical", false, "cervical", $options_movilidad_cervical,htmlspecialchars_decode($cervical),$is_disabled);

$options_apertura_bucal = [
    "" => "",
    "Reducida (<3cm)" => "Reducida (<3cm)",
    "Normal (>3.5cm)" => "Normal (>3.5cm)",
    "Muy reducida" => "Muy reducida",
];
echo generarSelect("Apertura Bucal", false, "ap_bucal", $options_apertura_bucal,htmlspecialchars_decode($ap_bucal),$is_disabled);

$options_capac_prognar = [
    "" => "",
    "Clase I" => "Clase I",
    "Clase II" => "Clase II",
    "Clase III" => "Clase III",
];
echo generarSelect("Capac. Prognar", false, "prognar", $options_capac_prognar,htmlspecialchars_decode($prognar),$is_disabled);

$options_dentadura = [
    "" => "",
    "Buen Estado" => "Buen Estado",
    "Dientes Sueltos" => "Dientes Sueltos",
    "Edentado Parcial" => "Edentado Parcial",
    "Edentado Total" => "Edentado Total",
];
echo generarSelect("Dentadura", false, "dentadura", $options_dentadura,htmlspecialchars_decode($dentadura),$is_disabled);


$fecha_exs_real = transformaInput($fecha_exs);
?>
			
			</div>
			</div>
			</div>

		<!– EVALUACIÓN DE VÍA AÉREA>

		<!– EXÁMENES–>
	        <div class='accordion-item'>
	          <h2 class='accordion-header' id='heading6'>
	            <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse6' aria-expanded='false' aria-controls='collapse6' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
	             	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3990.PNG'/>Exámenes</div>
	            </button>
	          </h2>
	          <div id='collapse6' class='accordion-collapse collapse' aria-labelledby='heading6'>
	            <div class='accordion-body'>

<?php

$arr_fecha_exs = ["Fecha Exámenes (dd/mm/aaaa)",false, "fecha_exs", "", $fecha_exs_real, "autocomplete='off'", $is_disabled, ""];
echo generarInputGral(...$arr_fecha_exs);

$array_hcto = ["Hcto", false, "hcto", "", $hcto, "type='number' step='0.1' class='form-control'", $is_disabled, "%"];
echo generarInputGral(...$array_hcto);

$array_hb = ["Hb", false, "hb", "", $hb, "type='number' step='0.1' class='form-control'", $is_disabled, "mg/dL"];
echo generarInputGral(...$array_hb);

$array_leucocitos = ["Leucocitos", false, "leuc", "", $leuc, "type='number' max='2000' class='form-control'", $is_disabled, "x10^3"];
echo generarInputGral(...$array_leucocitos);

$array_plaquetas = ["Plaquetas", false, "plaq", "", $plaq, "type='number' max='2000' class='form-control'", $is_disabled, "x10^3"];
echo generarInputGral(...$array_plaquetas);

$array_creatinina = ["Creatinina", false, "crea", "", $crea, "type='number' step='0.1' class='form-control'", $is_disabled, "mg/dL"];
echo generarInputGral(...$array_creatinina);

$array_glicemia = ["Glicemia", false, "glic", "", $glic, "type='number' step='0.1' class='form-control'", $is_disabled, "mg/dL"];
echo generarInputGral(...$array_glicemia);

$e_na = transformaInput($e_na);
$e_k = transformaInput($e_k);
$e_cl = transformaInput($e_cl);



if($e_na == "" and $e_k == "" and $e_cl == "" and $esconder_campos_nulos == "1"){

} else {

echo "<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Electrolitos</div><div class='fw-lighter text-muted'><small></small></div></div>
				<div class='input-group mb-3'>";

			if ($e_na == "" and $esconder_campos_nulos == "1"){
			} else {
			echo "<div class='text-muted px-2'> Na: </div><input type='number' step ='0.1' max='200' class='form-control' name='e_na' id='e_na' value='$e_na' $is_disabled_html >
				  <span class='input-group-text' id='basic-addon2'>mEq</span>";
				  }

			if ($e_k == "" and $esconder_campos_nulos == "1"){

			} else {
			echo "<div class='text-muted px-2'> K: </div><input type='number' step ='0.1' max='10' class='form-control' name='e_k' id='e_k' value='$e_k' $is_disabled_html >
				  <span class='input-group-text' id='basic-addon2'>mEq</span>";
				  }

			if ($e_cl == "" and $esconder_campos_nulos == "1"){

			} else {
			echo "<div class='text-muted px-2'> Cl: </div><input type='number' step ='0.1' max='200' class='form-control' name='e_cl' id='e_cl' value='$e_cl' $is_disabled_html >
				  <span class='input-group-text' id='basic-addon2'>mEq</span>";
				  }

				echo "</div>";

}

$array_protrombina = ["Protrombina", false, "tp", "", $tp, "type='number' step='0.1' class='form-control'", $is_disabled, "%"];
echo generarInputGral(...$array_protrombina);

$array_inr = ["INR", false, "inr", "", $inr, "type='number' step='0.01' class='form-control mb-2'", $is_disabled, ""];
echo generarInputGral(...$array_inr);

$array_ttpa = ["TTPA", false, "ttpa", "", $ttpa, "type='number' step='0.1' class='form-control'", $is_disabled, "seg"];
echo generarInputGral(...$array_ttpa);

$array_ecg_otros = ["ECG / Otros", false, "otros_exs", "", $otros_exs_original, "class='form-control mb-2' style='resize: none;' maxlength='250' rows='3'", $is_disabled, ""];
echo generarInputGral(...$array_ecg_otros);

?>
			</div>
			</div>
			</div>
		<!– EXÁMENES–>

		<!– ASA->
		<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><div class="col-9"><img class='btn-imagen' src='images/IMG_3991.PNG'/> Clasificación ASA (*)</div></li>


		<li class='list-group-item'>
				<div class='d-flex justify-content-between'>

<?php

				$options_asa = [
				    "" => "",
				    "ASA I" => "ASA I",
				    "ASA II" => "ASA II",
				    "ASA III" => "ASA III",
				    "ASA IV" => "ASA IV",
				    "ASA V" => "ASA V",
				    "ASA VI" => "ASA VI",
				];

				echo generarSelect("ASA&nbsp;", false, "asa", $options_asa,$asa,$is_disabled);




?>
				<div class="px-2"></div>
				<div class="form-check form-check-inline pt-2">
				  <input class="form-check-input" type="checkbox" id="asa_e" value="1" <?php echo $is_disabled_html." ".$asa_e;?>>
				  <label class="form-check-label" for="asa_e">E</label>
				</div></div>
		</li>
		<!– ASA->

		<!– RESERVAS->
	        <div class='accordion-item'>
	          <h2 class='accordion-header' id='heading7'>
	            <button class='accordion-button collapsed pt-3 pb-3 fs-6' type='button' data-bs-toggle='collapse' data-bs-target='#collapse7' aria-expanded='false' aria-controls='collapse7' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'>
	             	<div class="mx-auto"><img class='btn-imagen' src='images/IMG_3981.PNG'/>Plan / Indicaciones (*)</div>
	            </button>
	          </h2>
	          <div id='collapse7' class='accordion-collapse collapse' aria-labelledby='heading7'>
	            <div class='accordion-body'>

<?php
$array_ayuno = ["Ayuno", true, "ayuno", "", $ayuno, "list='tipo_ayuno'", $is_disabled, ""];
echo generarInputGral(...$array_ayuno);


$array_farmacos = ["Fármacos", false, "farmacos", "", $farmacos, "", $is_disabled, ""];
echo generarInputGral(...$array_farmacos);

$options_monitorizacion = [
    "" => "",
    "Estándar" => "Estándar",
    "Invasiva L.Arterial" => "Invasiva L.Arterial",
    "Invasiva L.Arterial + CVC" => "Invasiva L.Arterial + CVC",
];
echo generarSelect("Monitorización", true, "monitorizacion", $options_monitorizacion,htmlspecialchars_decode($monitorizacion),$is_disabled);

$array_reserva_hemocomponentes = ["Reserva Hemocomponentes", false, "hemoc", "", $hemoc, "list='hemocomponentes' class='form-control mb-2'", $is_disabled, ""];
echo generarInputGral(...$array_reserva_hemocomponentes);

$options_analgesia_po = [
    "" => "",
    "Endovenosa" => "Endovenosa",
    "Epidural" => "Epidural",
    "Bloqueo Continuo" => "Bloqueo Continuo",
    "Otra" => "Otra",
];

echo generarSelect("Analgesia Post-Op", true, "analgesia_po", $options_analgesia_po,htmlspecialchars_decode($analgesia_po),$is_disabled);


$array_otro_plan = ["Otras Indicaciones", false, "otro_plan", "", $otro_plan_original, "", $is_disabled, ""];
echo generarInputGral(...$array_otro_plan);


$reservas_dc1 = generarCheckDoble('Reserva UTI/UCI', 'upc',$upc, 'Consentimiento firmado', 'consent',$consent, $is_disabled);

echo $reservas_dc1;

?>
				<datalist id="tipo_ayuno">
					<option value="Estándar"></option>
					<option value="Más de 8 horas"></option>
				</datalist>

				<datalist id="hemocomponentes">
					<option value="2 UGR"></option>
					<option value="4 UGR"></option>
					<option value="Plaquetas 1U / 10Kg"></option>
					<option value="Plasma 20 ml/kg"></option>
					<option value="Crioprecipitado 1U / 10Kg"></option>
					<option value="GR - Plasma - Plaquetas"></option>
					<option value="GR - Crioprecipitado - Plaquetas"></option>
				</datalist>

				</div>
				</div>
				</div>
</div>

		<!– RESERVAS->
			<li class='list-group-item mb-4' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'>
		    <div class='col-9 py-2'><img class='btn-imagen' src='images/IMG_3977.PNG'/>Observaciones / Comentarios</div>



<?php

			if ($comentarios_original == "" and $esconder_campos_nulos == "1"){

			} else {
				echo "<textarea class='form-control mb-2' style='resize: none;' maxlength='250' rows='2' name='comentarios' id='comentarios' $is_disabled_html_ta >$comentarios_original</textarea>";
			   }


?>


		  	</li>


<?php  

echo $boton_final; //contiene etiqueta de cierre


?>

 </form>

</ul>

</div>

<script>
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
</script>

<script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    	    var today, datepicker;
    			today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $(function() {
            $('#fecha_int').datepicker({
            	 		uiLibrary: 'bootstrap5',
            	    format: 'dd/mm/yyyy',
            	    weekStartDay: 1,
            	    autoclose: true,
            	    minDate: today,
            	    icons: {
             			rightIcon: '<i class="fa-solid fa-calendar"></i>'
        					}
        				<?php echo $is_disabled_dp  ?>
           			 });
       		 	});
        $(function() {
            $('#ant_fur').datepicker({
            	 		uiLibrary: 'bootstrap5',
            	    format: 'dd/mm/yyyy',
            	    weekStartDay: 1,
            	    autoclose: true,
            	    maxDate: today,
            	    icons: {
             			rightIcon: '<i class="fa-solid fa-calendar"></i>'
        					}
        				<?php echo $is_disabled_dp  ?>
           			 });
       		 	});
        $(function() {
            $('#fecha_exs').datepicker({
            	 		uiLibrary: 'bootstrap5',
            	    format: 'dd/mm/yyyy',
            	    weekStartDay: 1,
            	    autoclose: true,
            	    maxDate: today,
            	    icons: {
             			rightIcon: '<i class="fa-solid fa-calendar"></i>'
        					}
        				<?php echo $is_disabled_dp  ?>
           			 });
       		 	});
    </script>

<!-  FIN DEL FORMULARIO  ->