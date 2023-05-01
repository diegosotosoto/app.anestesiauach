<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "El Delta Pulse Pressure en el contexto de la predicción de respuesta a volumen es la diferencia entre la presión arterial sistólica en espiración máxima y la presión arterial sistólica en espiración mínima. Es útil para determinar si un paciente hipovolémico responde a la administración de líquidos. Se ha demostrado que un Delta PP mayor a 13 mmHg indica una alta probabilidad de respuesta a volumen, mientras que un valor menor a 8 mmHg sugiere que el paciente no responderá a la administración de líquidos.";//texto obligatorio

$formula = "Delta PP = (PP Max - PP Min) / (PP Max + PP Min)/2 * 100";//texto opcional en formato html
$referencias = array("1.- Biais M, Vidil L, Sarrabay P, Cottenceau V, Revel P, Sztark F. Changes in stroke volume induced by passive leg raising in spontaneously breathing patients: comparison between echocardiography and Vigileo/FloTrac device. Crit Care. 2009;13(6):R195. doi:10.1186/cc8195","2.- Hofer CK, Müller SM, Furrer L, Klaghofer R, Genoni M, Zollinger A. Stroke volume and pulse pressure variation for prediction of fluid responsiveness in patients undergoing off-pump coronary artery bypass grafting. Chest. 2005;128(2):848-854. doi:10.1378/chest.128.2.848", "3.- Mahjoub Y, Lejeune V, Muller L, et al. Evaluation of pulse pressure variation validity criteria in critically ill patients: a prospective observational multicentre point-prevalence study. Br J Anaesth. 2014;112(4):681-685. doi:10.1093/bja/aet384"); //array opcional ordenada por números

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
