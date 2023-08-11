<?php
// Recibir las variables enviadas por POST
$peso_pdf = $_POST['peso'];
$talla_pdf = $_POST['talla'];
$atropina_pdf = $_POST['atropina'];
// ... Repite esto para todas las otras variables ...

// Cargar la librería FPDF
    require('tfpdf.php');//

// Crear una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Agregar contenido al PDF
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Dosificación', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Peso: ' . $peso_pdf . ' kg', 0, 1);
$pdf->Cell(0, 10, 'Talla: ' . $talla_pdf . ' cm', 0, 1);
$pdf->Cell(0, 10, 'Dosis de Atropina: ' . $atropina_pdf . ' mg', 0, 1);
// ... Repite esto para todas las otras variables ...

// Guardar el PDF en un archivo o mostrarlo en pantalla
$pdf->Output('D', 'reporte.pdf'); // Descarga el PDF con el nombre 'reporte.pdf'

?>
