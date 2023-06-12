<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Al conocer la VFG, el anestesiólogo puede ajustar la dosis de medicamentos que presentan excreción renal, como analgésicos, opioides, BNM, entre otros; además de minimizar el riesgo de toxicidad y efectos adversos relacionados algunos fármacos, como AINES y Antibióticos.
        			";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("1. Cockcroft DW, Gault MH.: Prediction of Creatinine clearance from serum creatinine. Nephron 1976; 16: 31-41
"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-filter pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Velocidad de Filtración Glomerular";//texto obligatorio

$input = array(array("Edad:","edad","años"),array("Peso","peso","Kg"),array("Creatinina","crea","mg/dL"));//INPUTS DE LA FORMULA array de 2 dimensiones array("inputX" => array("titulo","id","unidad"));

$input_ch = array(array("Mujer","mujer"));//array de 2 dimensiones array("inputX" => array("titulo","id")); CHECKLIST


$resultado = array(array("VFG","resultado1","ml/min","(mujerVar == true ? (0.85*((140-parseFloat(edadVar))*parseFloat(pesoVar))/(parseFloat(creaVar)*72)) : ((140-parseFloat(edadVar))*parseFloat(pesoVar))/(parseFloat(creaVar)*72))","1"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado")); en este caso el array contiene un if a modo de triada que se almacena en la variable: var B = (A ==="red") ? "hot":"cool";


//Otro elemento en Javascript permite dejar un texto asociado al cálculo (interpretación del resultado), en formato Javascript
$otro_elemento = "
					$( '#otro_elemento' ).text( 'Ecuación de Cockroft-Gault' );
				"; // en JavaScript

	//PLANTILLA
	require("plantilla_apunte.php");

?>
