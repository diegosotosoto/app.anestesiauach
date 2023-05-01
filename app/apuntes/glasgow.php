<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "La escala de Glasgow es una herramienta clínica que se utiliza para evaluar el estado de conciencia de un paciente. Esta escala mide tres aspectos principales: la respuesta ocular, la respuesta verbal y la respuesta motora, y utiliza una puntuación que va de 3 a 15 para describir el nivel de conciencia de un paciente en situaciones de emergencia o en el contexto de una lesión cerebral. La puntuación de la escala de Glasgow se correlaciona con el pronóstico del paciente y puede ayudar a tomar decisiones en cuanto al tratamiento y la necesidad de monitoreo.";//texto obligatorio

$formula = "Glasgow = respuesta ocular (1-4) + respuesta verbal (1-5) + respuesta motora (1-6)";//texto opcional en formato html
$referencias = array("1.- Teasdale G, Jennett B. Assessment of coma and impaired consciousness. A practical scale. Lancet. 1974 Jul 13;2(7872):81-4","2.- Rowley G, Fielding K. Reliability and accuracy of the Glasgow Coma scale with experienced and inexperienced users. Lancet 1991;337(8740):535-538.", "3.- Reith FC, Van den Brande R, Synnot A, Gruen R, Maas AI. The reliability of the Glasgow Coma Scale: a systematic review. Intensive Care Med. 2016 Jan;42(1):3-15."); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-brain pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Escala de Glasgow";//texto obligatorio


$input_e = array(array("Ocular","ocular",array(''=>'','Espontánea' => 4,'Orden Verbal'=> 3,'Dolor'=>2,'No Responde'=>1)),array("Verbal","verbal",array(''=>'','Orientado Conversando' => 5,'Desorientado'=> 4,'Palabras Inapropiadas'=>3,'Sonidos Incomprensibles'=>2,'Sin Respuesta'=>1)),array("Motora","motora",array(''=>'','Obedece Órdenes' => 6,'Localiza el Dolor' => 5,'Retira al dolor'=> 4,'Flexion Anormal'=>3,'Extensión'=>2,'Sin Respuesta'=>1)));//array de 3 dimensiones array("Select" => array("titulo","id",array('Nombre Selector'=>'id_select'));

$resultado = array(array("Resultado","resultado1","ptos","Number(ocularVar) + Number(verbalVar) + Number(motoraVar)","0"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado")); en este caso el array contiene un if a modo de triada que se almacena en la variable: var B = (A ==="red") ? "hot":"cool";


//Otro elemento en Javascript permite dejar un texto asociado al cálculo (interpretación del resultado), en formato Javascript
$otro_elemento = "
				if (Number(resultado1Var) >= 13) {

					$( '#otro_elemento' ).text( 'De 13 - 15 Ptos: TEC Leve ' );

				} else if (Number(resultado1Var) >= 9){
					$( '#otro_elemento' ).text( 'De 9 - 12 Ptos: TEC Moderado ' );
				} else {
					$( '#otro_elemento' ).text( 'De 3 - 8 Ptos: TEC Grave ' );
				} 

				"; // en JavaScript

	//PLANTILLA
	require("plantilla_apunte.php");

?>
