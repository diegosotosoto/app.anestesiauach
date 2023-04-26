<?php

$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Cálculo de dosis de infusión y bolo para analgesia epidural pediátrica. 
        			";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("1.- asdasdasdasdasdasd","2.- aljsdhasldasdasdasdasd", "3.- asdjasldasdasdasdasdasd"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-brain pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Escala de Glasgow";//texto obligatorio


$input_e = array(array("Ocular","ocular",array(''=>'','Espontánea' => 4,'Orden Verbal'=> 3,'Dolor'=>2,'No Responde'=>1)),array("Verbal","verbal",array(''=>'','Orientado Conversando' => 5,'Desorientado'=> 4,'Palabras Inapropiadas'=>3,'Sonidos Incomprensibles'=>2,'Sin Respuesta'=>1)),array("Motora","motora",array(''=>'','Obedece Órdenes' => 6,'Localiza el Dolor' => 5,'Retira al dolor'=> 4,'Flexion Anormal'=>3,'Extensión'=>2,'Sin Respuesta'=>1)));//array de 3 dimensiones array("Select" => array("titulo","id",array('Nombre Selector'=>'id_select'));

$resultado = array(array("Resultado","resultado1","ptos","ocularVar + verbalVar + motoraVar","0"));//array de 2 dimensiones array(array("titulo","id","unidad","calculo en formato JS","decimales en el resultado")); en este caso el array contiene un if a modo de triada que se almacena en la variable: var B = (A ==="red") ? "hot":"cool";


//Otro elemento en Javascript permite dejar un texto asociado al cálculo (interpretación del resultado), en formato Javascript
$otro_elemento = "
				if (parseFloat(resultado1Var) >= 5.0 || parseFloat(resultado2Var) >= 5.0 ) {

					$( '#otro_elemento' ).text( 'El valor máximo del bolo o infusión es de 5.0 ml/hr. ' );

				} 

				"; // en JavaScript

	//PLANTILLA
	require("plantilla_apunte.php");

?>
