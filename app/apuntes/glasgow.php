<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "La Escala de Coma de Glasgow (en Inglés Glasgow Coma Scale (GCS)) es una escala de aplicación neurológica que permite medir el nivel de conciencia de una persona. Utiliza tres parámetros que han demostrado ser muy replicables en su apreciación entre los distintos observadores: la respuesta verbal, la respuesta ocular y la respuesta motora. 
        			";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //array opcional ordenada por números

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
