<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "El Índice de Riesgo Cardiaco Revisado, fue desarrollado en pacientes mayores de 50 años que se sometian a procedimientos de cirugía mayor electiva no cardiaca. Identifica a los pacientes con riesgo de complicaciones como Infarto Miocárdico, Edema Pulmonar, Fibrilación Ventricular, Paro Cardiaco Primario y Bloqueo Cardiaco Completo. Puede determinar la necesidad de mayores estudios previos a la cirugía o de uso de técnicas alternativas para el manejo operatorio.
        			";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("1. Thomas H. Lee, MD, SM; Edward R. Marcantonio, MD, SM; Carol M. Mangione, MD, SM; Eric J. Thomas, MD, SM; Carisi A. Polanczyk, MD; E. Francis Cook, ScD; David J. Sugarbaker, MD; Magruder C. Donaldson, MD; Robert Poss, MD; Kalon K. L. Ho, MD, SM; Lynn E. Ludwig, MS, RN; Alex Pedan, PhD; Lee Goldman, MD, MPH.
Derivation and prospective validation of a simple index for prediction of cardiac risk of major noncardiac surgery.
Circulation 1999 September 7, 100 (10): 1043-9","2. Lee A. Fleisher, Joshua A. Beckman, Kenneth A. Brown, Hugh Calkins, Elliot L. Chaikof, Kirsten E. Fleischmann, William K. Freeman, James B. Froehlich, Edward K. Kasper, Judy R. Kersten, Barbara Riegel and John F. Robb.
2009 ACCF/AHA focused update on perioperative beta blockade incorporated into the ACC/AHA 2007 guidelines on perioperative cardiovascular evaluation and care for noncardiac surgery: a report of the American college of cardiology foundation/American heart association task force on practice guidelines.
Circulation 2009 November 24, 120 (21): e169-276"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-calendar-plus pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Índice de Riesgo Cardiaco Revisado";//texto obligatorio

$input_ch = array(array("Cirugía de Riesgo Alto","cirugia"),array("Antecedentes de IAM","infarto"),array("Antecedentes de ICC","insuf"),array("Antecedentes de ACV","cerebro"),array("Usuario de Insulina","insulina"),array("Creatinina >2.0 mg/dL","creatinina"));//array de 2 dimensiones array("inputX" => array("titulo","id")); CHECKLIST


$resultado = array(array("Riesgo","resultado1","%","((cirugiaVar == true ? 1 : 0) + (infartoVar == true ? 1 : 0) + (insufVar == true ? 1 : 0) + (cerebroVar == true ? 1 : 0) + (insulinaVar == true ? 1 : 0) + (creatininaVar == true ? 1 : 0)) > 2 ? 11 : ((cirugiaVar == true ? 1 : 0) + (infartoVar == true ? 1 : 0) + (insufVar == true ? 1 : 0) + (cerebroVar == true ? 1 : 0) + (insulinaVar == true ? 1 : 0) + (creatininaVar == true ? 1 : 0)) == 2 ? 6.6 : ((cirugiaVar == true ? 1 : 0) + (infartoVar == true ? 1 : 0) + (insufVar == true ? 1 : 0) + (cerebroVar == true ? 1 : 0) + (insulinaVar == true ? 1 : 0) + (creatininaVar == true ? 1 : 0)) == 1 ? 0.6 : 0.4","1"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado")); en este caso el array contiene un if a modo de triada que se almacena en la variable: var B = (A ==="red") ? "hot":"cool";


//Otro elemento en Javascript permite dejar un texto asociado al cálculo (interpretación del resultado), en formato Javascript
$otro_elemento = "

					$( '#otro_elemento' ).text( 'Riesgo de complicaciones como Infarto Miocárdico, Edema Pulmonar, Fibrilación Ventricular, Paro Cardiaco Primario y Bloqueo Cardiaco Completo' );

				

				"; // en JavaScript

	//PLANTILLA
	require("plantilla_apunte.php");

?>
