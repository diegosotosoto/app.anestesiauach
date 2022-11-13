<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Este indicador permite conocer el límite admisible de sangrado intraoperatorio, para llegar desde un Hematocrito basal a un objetivo.";//texto obligatorio

$formula = "Pérdidas(gr) = (Hcto Basal - Hcto Objetivo)/ Hcto Basal * 70 * Peso";//texto opcional en formato html
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-droplet pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Pérdidas Admisibles";//texto obligatorio

$input = array(array("Hcto Inicial:","hcto_inicial","%"),array("Hcto Final:","hcto_final","%"),array("Peso:","peso","Kg"));//array de 2 dimensiones array("inputX" => array("titulo","id","unidad"));

$resultado = array(array("Pérdida:","resultado1","ml","(parseFloat(hcto_inicialVar) - parseFloat(hcto_finalVar))/parseFloat(hcto_inicialVar) * parseFloat(pesoVar) * 70","0"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado"));


	//PLANTILLA
	require("plantilla_apunte.php");

?>
