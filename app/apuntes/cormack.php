<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "La utilidad clínica de la escala de Cormack-Lehane es que ayuda a los anestesiólogos y otros profesionales de la salud a prever la dificultad de la intubación traqueal y, por lo tanto, prepararse para el procedimiento y tomar decisiones en consecuencia.";//texto obligatorio

$referencias = array("1.- Cormack, R. S., & Lehane, J. (1984). Difficult tracheal intubation in obstetrics. Anaesthesia, 39(11), 1105-1111.","2.- Yentis, S. M., Lee, D. J., & Hirsch, N. P. (1998). A comparison of the upper airway in the supine and lateral positions using magnetic resonance imaging in normal subjects. Anaesthesia, 53(8), 750-754.","3.- El-Ganzouri, A. R., McCarthy, R. J., & Tuman, K. J. (1996). Preoperative airway assessment: predictive value of a multivariate risk index. Anesthesia & Analgesia, 82(6), 1197-1204."); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-lungs pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Clasificación de Cormack - Lehane modificada";//texto obligatorio

$imagen = "../images/cormack.jpeg";
$caption = "La escala de Cormack-Lehane es una herramienta utilizada para clasificar la visualización de las cuerdas vocales durante la laringoscopia y así evaluar la dificultad para intubar a un paciente. Esta escala se divide en cuatro grados, desde el grado I (visualización completa de las cuerdas vocales) hasta el grado IV (no se puede visualizar ninguna parte de las cuerdas vocales). Posteriormente fue modificada separando el grado II en tipo A y B.";


	//PLANTILLA
	require("plantilla_foto.php");

?>
