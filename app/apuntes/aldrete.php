<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "El Score de Aldrete ere modificado es útil en la evaluación objetiva de la recuperación de los pacientes postquirúrgicos en el área de recuperación postanestésica (PACU). Permite determinar si un paciente está listo para ser dado de alta de la PACU y ser trasladado a otra unidad.";//texto obligatorio

$referencias = array("1.- Aldrete JA, Kroulik D. A postanesthetic recovery score. Anesth Analg. 1970;49(6):924-934. doi: 10.1213/00000539-197011000-00010. PMID: 5484089.","2.- Aldrete JA. The post anaesthesia recovery score revisited. J Clin Anesth. 1995;7:89-91. ","3.- McGrath B, Chung F. Postoperative recovery and discharge. Anesthesiology Clin N Am. 2003; 21: 367-86."); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-star pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Score de Aldrete re Modificado";//texto obligatorio

$imagen = "../images/aldrete.jpeg";
$caption = " El Score de Aldrete re modificado es una herramienta utilizada para evaluar la recuperación de los pacientes después de la cirugía. Se basa en siete parámetros: el nivel de conciencia, actividad motora, respiración, circulación, conciencia, saturación de oxígeno, dolor y pesencia de náuseas y vómitos postoperatorios. Cada parámetro se puntúa de 0 a 2, y la puntuación total varía de 0 a 14. Para dar de alta un paciente de la recuperación, se requiere un puntaje mínimo de 12 puntos, con ningún ítem menor de 1 punto.";


	//PLANTILLA
	require("plantilla_foto.php");

?>
