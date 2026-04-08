<?php



// Head de la pagina



    require('../pdf/tfpdf.php');//       require('../../pdf/tfpdf.php');   //         require('../pdf/tfpdf.php');

    $pdf = new tFPDF('P','mm','Letter');
    $pdf->AddPage();
    $pdf->SetTitle('pdf_ped',true);

    
    $pdf->SetCreator('www.anestesiauach.cl');
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
	$pdf->AddFont('DejaVuSans-Bold','','DejaVuSans-Bold.ttf',true);

$pdf->Image('minsal.png', 9, 2, 21, 18.5);
$pdf->SetFont('DejaVuSans-Bold','',6);

$pdf->SetY(2.5);
$pdf->SetX(39);
$pdf->Cell(18, 8, 'MINISTERIO DE SALUD', 0, 0);

$pdf->Ln(2.8);
$pdf->SetX(40);
$pdf->Cell(18, 8, 'REGION DE LOS RÍOS', 0, 0);

$pdf->Ln(2.8);
$pdf->SetX(37);
$pdf->Cell(18, 8, 'SERVICIO SALUD VALDIVIA', 0, 0);

$pdf->SetFont('DejaVu','',6.5);

$pdf->Ln(2.8);
$pdf->SetX(39);
$pdf->Cell(18, 8, 'HOSPITAL BASE VALDIVIA', 0, 0);

$pdf->Ln(2.8);
$pdf->SetX(32);
$pdf->Cell(18, 8, 'SUBDEPTO. PABELLON Y ANESTESIA', 0, 0);

$pdf->Ln(2.8);
$pdf->SetX(49);
$pdf->Cell(18, 8, 'JGB/gca', 0, 0);


$pdf->SetY(8);
$pdf->SetX(98);
$pdf->SetFont('DejaVuSans-Bold','',10);
$pdf->Cell(18, 8, 'EVALUACION PREANESTESICA ANEXO II', 0, 0);

$pdf->SetLineWidth(0.3);

/*

*/


$pdf->SetY(17);
foreach (range(0, 52) as $i) {

$pdf->Ln(4.6);
$pdf->Rect(9, $pdf->GetY(), 192, 4.6); // NOMBRE
    // Aquí va el código que se ejecutará en cada iteración

}



//FC 130+40

/*
$pdf->Rect(9, 26.8, 131.5, 4.8); // Edad
$pdf->Rect(9, 31.6, 131.5, 4.8); // P. Art
$pdf->Rect(9, 36.4, 131.5, 4.8); // Diagnosticos
*/




$pdf->Ln(10);

	

    $pdf->Output('I', 'pdf_ped.pdf');


?>