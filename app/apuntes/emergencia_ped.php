<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Cálculo de dosis de infusión y bolo para analgesia epidural pediátrica. 
        			";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-truck-medical pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Dosis de Emergencia Pediátrica";//texto obligatorio
 
$input = array(array("Peso","peso","Kg"),array("Talla","talla","cm"));//array de 2 dimensiones array("inputX" => array("titulo","id","unidad"));

$resultado = array(array("Superficie Corporal","resultado1","m2SC","((parseFloat(pesoVar) < 10.0) ? ((parseFloat(pesoVar)*4)+9)/100 : ((parseFloat(pesoVar)*4)+7)/ (parseFloat(pesoVar)+90))","2"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado")); en este caso el array contiene un if a modo de triada que se almacena en la variable: var B = (A ==="red") ? "hot":"cool";


//Otro elemento en Javascript permite dejar un texto asociado al cálculo (interpretación del resultado), en formato Javascript
$otro_elemento = ""; // en JavaScript

	//PLANTILLA
	require("plantilla_apunte_e.php");

?>
