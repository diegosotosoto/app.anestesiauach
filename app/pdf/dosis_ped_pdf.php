<?php

require('../pdf/tfpdf.php');//

// Crear nuevo documento PDF
$pdf = new tFPDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Título de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, utf8_decode('HISTORIA CLINICA PREANESTESICA'), 1, 1, 'C');

// Primera fila: Identificación del paciente
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, utf8_decode('IDENTIFICACIÓN DEL PACIENTE'), 1, 0, 'C');
$pdf->Cell(95, 10, utf8_decode('DATOS DEL PROCEDIMIENTO'), 1, 1, 'C');

// Detalles de identificación del paciente
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(47.5, 10, utf8_decode('Nombre'), 1, 0);
$pdf->Cell(47.5, 10, '', 1, 0); // Espacio para escribir nombre del paciente
$pdf->Cell(47.5, 10, utf8_decode('Fecha'), 1, 0);
$pdf->Cell(47.5, 10, '', 1, 1); // Espacio para escribir fecha

$pdf->Cell(47.5, 10, utf8_decode('Edad'), 1, 0);
$pdf->Cell(47.5, 10, '', 1, 0); // Espacio para escribir edad
$pdf->Cell(47.5, 10, utf8_decode('Hora'), 1, 0);
$pdf->Cell(47.5, 10, '', 1, 1); // Espacio para escribir hora

$pdf->Cell(47.5, 10, utf8_decode('Sexo'), 1, 0);
$pdf->Cell(47.5, 10, '', 1, 0); // Espacio para escribir sexo
$pdf->Cell(47.5, 10, utf8_decode('Servicio'), 1, 0);
$pdf->Cell(47.5, 10, '', 1, 1); // Espacio para escribir servicio

$pdf->Cell(47.5, 10, utf8_decode('Procedencia'), 1, 0);
$pdf->Cell(47.5, 10, '', 1, 0); // Espacio para escribir procedencia
$pdf->Cell(95, 10, '', 1, 1); // Espacio para escribir otros datos si es necesario

// Guardar el PDF
$pdf->Output();
?>
