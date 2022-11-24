<?php

	//Conexión
	require("app/conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	

		$rut_v=htmlentities(addslashes($_POST['rut_v']));
		$fecha_v=htmlentities(addslashes($_POST['fecha_v']));

		$consulta_m="SELECT * FROM `visita_diaria` WHERE `rut_v` = '$rut_v' AND `fecha_v` = '$fecha_v' ";
		$busqueda2=$conexion->query($consulta_m);
		$fila=$busqueda2->fetch_assoc();


		$phpdate1 = strtotime( $fila['fecha_v'] );
		$fecha1 = date( 'd-m-y H:i', $phpdate1 );


		$phpdate1 = strtotime( $fila['fecha_v'] );
		$fecha1 = date( 'd-m-y H:i', $phpdate1 );

	$nombre_paciente = html_entity_decode($fila['nombre_paciente_v']);
	$rut_v = html_entity_decode($fila['rut_v']);
	$eva_estatico = html_entity_decode($fila['eva_estatico']);
	$eva_dinamico = html_entity_decode($fila['eva_dinamico']);
	$sedacion = html_entity_decode($fila['sedacion']);
	$motor = html_entity_decode($fila['motor']);
	$bolos = html_entity_decode($fila['bolos']);
	$pas = html_entity_decode($fila['pas']);
	$pad = html_entity_decode($fila['pad']);
	$fc = html_entity_decode($fila['fc']);
	$sao2 = html_entity_decode($fila['sao2']);
	$fio2 = html_entity_decode($fila['fio2']);

	$fecha_exs = html_entity_decode($fila['fecha_exs']);
	$inr = html_entity_decode($fila['inr']);
	$ttpa = html_entity_decode($fila['ttpa']);
	$plaq = html_entity_decode($fila['plaq']);
	$crea = html_entity_decode($fila['crea']);

	$anticoagulante = html_entity_decode($fila['anticoagulante']);
	$indic1 = html_entity_decode($fila['indic1']);
	$indic2 = html_entity_decode($fila['indic2']);
	$indic3 = html_entity_decode($fila['indic3']);
	$indic4 = html_entity_decode($fila['indic4']);
	$indic5 = html_entity_decode($fila['indic5']);
	$indic6 = html_entity_decode($fila['indic6']);
	$comentarios_v = html_entity_decode($fila['comentarios_v']);
	$editor_v = html_entity_decode($fila['editor_v']);


	require('app/tfpdf.php');

	$pdf = new tFPDF('P','mm','Letter');
	$pdf->AddPage();
	$pdf->SetTitle('Visita Dolor '.$nombre_paciente.' '.$fecha1,true);
	$pdf->SetAuthor($editor_v,true);
	$pdf->SetCreator('www.anestesiauach.cl');
	$pdf->SetMargins(20,25,10);
	$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
	$pdf->SetFont('DejaVu','',12);

	$pdf->Ln(10);
	$pdf->Cell(40,10,'Nombre Paciente: '.$nombre_paciente,0,0,'L');
	$pdf->Cell(130,10,'Rut: '.$rut_v,0,0,'R');
	$pdf->Ln(10);
	$pdf->Cell(80,5,'Fecha: '.$fecha1,0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(180,10,'VISITA DIARIA DOLOR',0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(10);
	$pdf->Write(8,'Paciente hoy se encuenta con EVA estático '.$eva_estatico.' y EVA dinámico de '.$eva_dinamico.'. Nivel de Sedación según escala de Ramsay: '.$sedacion);

	if($motor){
		$pdf->Write(8,'. Nivel de Función Motora escala MRC: '.$motor);
	}

	if($bolos){
		$pdf->Write(8,'. Bolos de PCA Solicitados/Administrados: '.$bolos.'.');
	}

	$pdf->Ln(15);
	$pdf->Cell(10);
	if($pas or $pad or $fc or $sao2 or $fio2){
		$pdf->Write(8,'Al Exámen Físico: ');
	}
	if($pas or $pad){
		$pdf->Write(8,'PA: '.$pas.'/'.$pad.' mmHg');
	}
	if($fc){
		$pdf->Write(8,' ;  FC: '.$fc.' x min');
	}
	if($sao2){
		$pdf->Write(8,' ;  SaO2: '.$sao2.' %');
	}
	if($fio2){
		$pdf->Write(8,' ;  FiO2: '.$fio2.' %');
	}

	$pdf->Ln(15);
	$pdf->Cell(10);
	if($inr or $ttpa or $plaq or $crea){
		$pdf->Write(8,'Exámenes');
	}
	if($fecha_exs){
		$pdf->Write(8,' del '.$fecha_exs);
	}

		if($inr or $ttpa or $plaq or $crea){
		$pdf->Write(8,':');
	}

	if($inr){
		$pdf->Write(8,' INR: '.$inr);
	}
	if($ttpa){
		$pdf->Write(8,' ;  TTPA: '.$fc.' seg.');
	}
	if($plaq){
		$pdf->Write(8,' ;  Plaquetas: '.$plaq.' x 10^3');
	}
	if($crea){
		$pdf->Write(8,' ;  Creatinina: '.$crea.' mg/dL');
	}



	if($anticoagulante or $indic1 or $indic2 or $indic3 or $indic4 or $indic5 or $indic6){
		$pdf->Ln(16);
		$pdf->Cell(10);
		$pdf->Write(8,'Indicaciones:');
	}

	if($anticoagulante){
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,'Anticoagulación: '.$anticoagulante);
	}
	if($indic1){
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,'1.- '.$indic1);
	}
	if($indic2){
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,'2.- '.$indic2);
	}
	if($indic3){
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,'3.- '.$indic3);
	}
	if($indic4){
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,'4.- '.$indic4);
	}

	if($indic5){
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,'5.- '.$indic5);

	}

	if($indic6){
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,'6.- '.$indic6);
	}

	if($comentarios_v){
		$pdf->Ln(16);
		$pdf->Cell(10);
		$pdf->Write(8,'Plan / Comentarios: ');
		$pdf->Ln(8);
		$pdf->Cell(10);
		$pdf->Write(8,$comentarios_v);
	}

		$pdf->Ln(16);
		$pdf->Cell(150,10,'Dr(a): '.$editor_v,0,0,'R');
		$pdf->Ln(7);
		$pdf->Cell(150,10,"Anestesiólogo(a)",0,0,'R');




    $pdf->Output('I', 'visita'.$nombre_paciente.'.pdf');


	$conexion->close();

?>