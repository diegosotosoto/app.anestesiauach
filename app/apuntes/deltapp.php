<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Este indicador es un parámetro dinámico de respuesta a volumen. 
        			";//texto obligatorio

$formula = "Delta PP = (PP Max - PP Min) / (PP Max + PP Min)/2 * 100";//texto opcional en formato html
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-wave-square pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Delta PP";//texto obligatorio

$input = array(array("Sistólica Max:","s_max","mmHg"),array("Diastólica Max","d_max","mmHg"),array("Sistólica Min","s_min","mmHg"),array("Diastólica Min","d_min","mmHg"));//array de 2 dimensiones array("inputX" => array("titulo","id","unidad"));

$resultado = array(array("PP Max","resultado1","mmHg","parseFloat(s_maxVar) - parseFloat(d_maxVar)","0"),array("PP Min","resultado2","mmHg","parseFloat(s_minVar) - parseFloat(d_minVar)","0"),array("Delta PP","resultado3","","(parseFloat(resultado1Var) - parseFloat(resultado2Var))/((parseFloat(resultado1Var) + parseFloat(resultado2Var))/2) * 100","2"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado"));


$otro_elemento = "
				if (parseFloat(resultado3Var) > 12.0) {
					$( '#otro_elemento' ).text( 'Respondedor a Volumen' );
				} else if (parseFloat(resultado3Var) <= 12.0 && parseFloat(resultado3Var) >= 8.0) {
					$( '#otro_elemento' ).text( 'Zona Intermedia de respuesta a Volumen' );
				} else if (parseFloat(resultado3Var) < 8.0) {
					$( '#otro_elemento' ).text( 'No respondedor a Volumen' );
				}

				"; // en JavaScript


	//PLANTILLA
	require("plantilla_apunte.php");

?>
