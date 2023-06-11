<?php


$icono_apunte = "<i class='fa-solid fa-flask-vial pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Corrección de Bicarbonato";//TÍTULO DEL APUNTE (texto obligatorio)

$input = array(array("Peso:","peso","Kg"),array("Exceso de Base:","be","mEq/L"));//INPUTS DE LA FORMULA array de 2 dimensiones array("inputX" => array("titulo","id","unidad"));

$resultado = array(array("Déficit:","resultado1","gr","parseFloat(pesoVar) * parseFloat(beVar) * 0.3 / 12 * -1","2"),array("Reponer al 8.4%:","resultado2","ml","parseFloat(resultado1Var) / 0.084","2"),array("Reponer al 2/3 M: ","resultado3","ml","parseFloat(resultado1Var) / 14 * 250","0"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado"));


$titulo_info = "Utilidad Clínica";//TÍTULO DE SECCION "UTILIDAD CLÍNICA "texto obligatorio
$descripcion_info = "Este indicador permite conocer el déficit de Bicarbonato en el análisis de Gases Arteriales a partir del Base Excess. 
        					Entrega el resultado para reponer el 100% del déficit calculado, en ml de solución de Bicarbonato de Sodio al 8.4% y al 2/3 molar.";//DESCRIPCIÓN texto obligatorio

$formula = "Déficit(gr) = BE x 0,3 x Peso / 12";//FÓRMULA (texto opcional en formato html)
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //REFERENCIAS BIBIOGRÁFICAS array opcional ordenada por números


$otro_elemento = "

					$( '#otro_elemento' ).text( 'Resultado propuesto para reposición del 100% del déficit. Se recomienda iniciar con un 50% del total y controlar.' );

				"; // en JavaScript


	//PLANTILLA
	require("plantilla_apunte.php");

?>

