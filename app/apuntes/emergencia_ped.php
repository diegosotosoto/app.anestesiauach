<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Cálculo de dosis de infusión y bolo para analgesia epidural pediátrica. 
        			";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-truck-medical pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Dosis de Emergencia Pediátrica";//texto obligatorio
 
$input = array(array("Peso","peso","Kg"),array("Talla","talla","mt"));//array de 2 dimensiones array("inputX" => array("titulo","id","unidad"));

$resultado = array(array("Infusión","resultado1","ml/hr","((parseFloat(pesoVar) * parseFloat(selectVar) / 3 * 2) > 5.0) ? 5.0:(parseFloat(pesoVar) * parseFloat(selectVar) / 3 * 2);","1"),array("Bolo","resultado2","ml","((parseFloat(pesoVar) * parseFloat(selectVar) / 3) > 5.0) ? 5.0:(parseFloat(pesoVar) * parseFloat(selectVar) / 3);","1"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado")); en este caso el array contiene un if a modo de triada que se almacena en la variable: var B = (A ==="red") ? "hot":"cool";


//Otro elemento en Javascript permite dejar un texto asociado al cálculo (interpretación del resultado), en formato Javascript
$otro_elemento = "
				if (parseFloat(resultado1Var) >= 5.0 || parseFloat(resultado2Var) >= 5.0 ) {

					$( '#otro_elemento' ).text( 'El valor máximo del bolo o infusión es de 5.0 ml/hr. ' );

				} 

				"; // en JavaScript

	//PLANTILLA
	require("plantilla_apunte.php");

?>
