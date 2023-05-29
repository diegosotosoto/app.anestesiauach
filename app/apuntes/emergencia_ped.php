<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Cálculo de dosis de infusión y bolo para analgesia epidural pediátrica. 
        			";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-truck-medical pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Dosis de Emergencia Pediátrica";//texto obligatorio
 
$input = array(array("Peso","peso","Kg"),array("Talla","talla","cm"));//array de 2 dimensiones array("inputX" => array("titulo","id","unidad"));

$resultado = array(array("Superficie Corporal","resultado1","m2SC","((parseFloat(pesoVar) < 10.0) ? ((parseFloat(pesoVar)*4)+9)/100 : ((parseFloat(pesoVar)*4)+7)/ (parseFloat(pesoVar)+90))","2"),array("Distancia CVC","distanciaCVC","cm","((parseFloat(pesoVar) < 2.0) ? 3 : (parseFloat(pesoVar) >= 2.0 && parseFloat(pesoVar) <= 2.9 ? 4 : (parseFloat(pesoVar) >= 3.0 && parseFloat(pesoVar) <= 4.9 ? 5 : (parseFloat(pesoVar) >= 5.0 && parseFloat(pesoVar) <= 6.9 ? 6 : (parseFloat(pesoVar) >= 7.0 && parseFloat(pesoVar) <= 9.9 ? 7 : (parseFloat(pesoVar) >= 10.0 && parseFloat(pesoVar) <= 12.9 ? 8 : (parseFloat(pesoVar) >= 13.0 && parseFloat(pesoVar) <= 19.9 ? 9 : (parseFloat(pesoVar) >= 20.0 && parseFloat(pesoVar) <= 29.9 ? 10 : (parseFloat(pesoVar) >= 30.0 && parseFloat(pesoVar) <= 39.9 ? 11 : (parseFloat(pesoVar) >= 40.0 && parseFloat(pesoVar) <= 49.9 ? 12 : (parseFloat(pesoVar) >= 50.0 && parseFloat(pesoVar) <= 59.9 ? 13 : (parseFloat(pesoVar) >= 60.0 && parseFloat(pesoVar) <= 69.9 ? 14 : (parseFloat(pesoVar) >= 70.0 && parseFloat(pesoVar) <= 79.9 ? 15 : (parseFloat(pesoVar) >= 80 ? 16 : 'Peso Inválido'))))))))))))))","0"),array("Atropina","atropina","mg","(parseFloat(pesoVar)*0.02 > 0.3) ? (0.3) : (parseFloat(pesoVar)*0.02)","2"),array("Epinefrina (PCR)","epinefrina","mg","(parseFloat(pesoVar)*0.01 > 1.0) ? (1.0) : (parseFloat(pesoVar)*0.01)","2"),array("Calcio Cloruro (10%)","calcioCl","mg","(parseFloat(pesoVar)*10 > 1000) ? (1000) : (parseFloat(pesoVar)*10)","0"),array("Calcio Gluconato (10%)","calcioGl","mg","(parseFloat(pesoVar)*30 > 3000) ? (3000) : (parseFloat(pesoVar)*30)","0"),array("Adenosina","adenosina","mg","(parseFloat(pesoVar)*0.1 > 6.0) ? (6.0) : (parseFloat(pesoVar)*0.1)","1"),array("Amiodarona","amiodarona","mg","(parseFloat(pesoVar)*2 > 300) ? (300) : (parseFloat(pesoVar)*2)","1"),array("Lidocaína","lidocaina","mg","(parseFloat(pesoVar)*1 > 100) ? (100) : (parseFloat(pesoVar)*1)","1"),array("Rocuronio (2DE95)","rocuronio","mg","(parseFloat(pesoVar)*0.6 > 50) ? (50) : (parseFloat(pesoVar)*0.6)","1"),array("Midazolam","midazolam","mg","(parseFloat(pesoVar)*0.1 > 5) ? (5) : (parseFloat(pesoVar)*0.1)","1"),array("Fenantyl (inducción)","fentaInd","ug","(parseFloat(pesoVar)*3 > 300) ? (300) : (parseFloat(pesoVar)*3)","0"),array("Fenantyl (analgesia)","fentaAna","ug","(parseFloat(pesoVar)*0.5 > 50) ? (50) : (parseFloat(pesoVar)*0.5)","0"),array("Morfina","morfina","mg","(parseFloat(pesoVar)*0.05 > 3) ? (3) : (parseFloat(pesoVar)*0.05)","1"),array("Glucosa (30%)","glucosa","gr","(parseFloat(pesoVar)*0.15 > 6) ? (6) : (parseFloat(pesoVar)*0.15)","1"),array("Naloxona","naloxona","ug","(parseFloat(pesoVar)*5 > 400) ? (400) : (parseFloat(pesoVar)*5)","0"),array("Flumazenil","flumazenil","ug","(parseFloat(pesoVar)*5 > 100) ? (100) : (parseFloat(pesoVar)*5)","0"),array("Cardioversion","cardiov","J","(parseFloat(pesoVar)*0.5 > 100) ? (100) : (parseFloat(pesoVar)*0.5)","0"),array("Desfibrilacion","desfibr","J","(parseFloat(pesoVar)*2 > 200) ? (200) : (parseFloat(pesoVar)*2)","0"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado")); en este caso el array contiene un if a modo de triada que se almacena en la variable: var B = (A ==="red") ? "hot":"cool";


//Otro elemento en Javascript permite dejar un texto asociado al cálculo (interpretación del resultado), en formato Javascript
$otro_elemento = ""; // en JavaScript

	//PLANTILLA
	require("plantilla_apunte_e.php");

?>
