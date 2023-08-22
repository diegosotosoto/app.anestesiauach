<?php


// Recibir los datos enviados por POST
$peso = isset($_POST['peso']) ? $_POST['peso'] : '';
$pesoVar = $peso;
$talla = isset($_POST['talla']) ? $_POST['talla'] : '';
$edad = isset($_POST['edad']) ? $_POST['edad'] : '';
$edadInput = $edad;
$tipo = $_POST['meses']=='1' ? 'meses' : 'años';
$titulo = "Dosis Pediátrica de Emergencia"; 
// ...recibir otros datos...


if ( $tipo == 'años' and $edadInput > 0) {
    
    if($edadInput / 4 + 3.5 >= 2.5 and $edadInput / 4 + 3.5 <= 7.0 ){
        $tubo = $edadInput / 4 + 3.5;
    } else if ($edadInput < 2.5 ) { 
        $tubo = 2.5;
    } else if ($edadInput > 7.0 ) { 
        $tubo = 7.0;
    }
          
} else if ( $tipo == 'meses' and $edadInput > 0) {
    if ($edadInput >= 18 ){
        $tubo = $edadInput / 12 / 4 + 3.5;
    } else if ($edadInput >= 9 and $edadInput < 18 ){
        $tubo = 3.5;
    } else if ($edadInput >= 3 and $edadInput < 9 ){
        $tubo = 3.0;
    } else if ($edadInput < 3 ){
        $tubo = 2.5;
    } 
}

$resultado = round($tubo * 2) / 2;
$resultadoD = number_format($resultado, 1, '.', ''); 




if ( $tipo == 'años' and $edadInput > 0 ) {
    if($edadInput / 2 + 12 >= 7.5 and $edadInput / 2 + 12 <= 21.0 ){
        $tubo_dist = $edadInput / 2 + 12;
    } else if ($edadInput < 7.5 ) { 
        $tubo_dist = 7.5;
    } else if ($edadInput > 21.0 ) {    
        $tubo_dist = 21.0;
    }
          
} else if ( $tipo == 'meses' and $edadInput > 0 ) {
    if ($edadInput >= 18 ){
        $tubo_dist = $edadInput / 12 / 2 + 12;
    } else if ($edadInput >= 9 and $edadInput < 18 ){
        $tubo_dist = 10.5;
    } else if ($edadInput >= 3 and $edadInput < 9 ){
        $tubo_dist = 9.0;
    } else if ($edadInput < 3 ){
        $tubo_dist = 7.5;
    } 
}

$resultado_dist = round($tubo_dist * 2) / 2;
$resultadoD_dist = number_format($resultado_dist, 1, '.', ''); 




if ($pesoVar > 0){
$numeroSCT = (($pesoVar < 10.0) ? (($pesoVar*4)+9)/100 : (($pesoVar*4)+7)/ ($pesoVar+90));
$CVC = ($pesoVar < 2.0) ? 3 : ($pesoVar >= 2.0 && $pesoVar <= 2.9 ? 4 : ($pesoVar >= 3.0 && $pesoVar <= 4.9 ? 5 : ($pesoVar >= 5.0 && $pesoVar <= 6.9 ? 6 : ($pesoVar >= 7.0 && $pesoVar <= 9.9 ? 7 : ($pesoVar >= 10.0 && $pesoVar <= 12.9 ? 8 : ($pesoVar >= 13.0 && $pesoVar <= 19.9 ? 9 : ($pesoVar >= 20.0 && $pesoVar <= 29.9 ? 10 : ($pesoVar >= 30.0 && $pesoVar <= 39.9 ? 11 : ($pesoVar >= 40.0 && $pesoVar <= 49.9 ? 12 : ($pesoVar >= 50.0 && $pesoVar <= 59.9 ? 13 : ($pesoVar >= 60.0 && $pesoVar <= 69.9 ? 14 : ($pesoVar >= 70.0 && $pesoVar <= 79.9 ? 15 : ($pesoVar >= 80 ? 16 : 'Peso Inválido')))))))))))));
} else {
    $numeroSCT = 0;
    $CVC = 0;
}

// Aquí puedes hacer los cálculos basados en los datos recibidos


$calculos = array(
    "tubo" => array(
        "id" => "tubo",
        "nombre" => "Tubo",
        "valor" => $resultadoD, // Ejemplo: 0.5 + $pesoVar
        "unidad" => "mm" // Ejemplo: "mm"
    ),
    "dist_boca" => array(
        "id" => "distBoca",
        "nombre" => "Dist. Boca",
        "valor" => $resultadoD_dist, // Ejemplo: 2 * $pesoVar
        "unidad" => "cm" // Ejemplo: "cm"
    ),
    "superficie_corporal" => array(
        "id" => "superficieCorporal",
        "nombre" => "Superficie Corporal",
        "valor" => round($numeroSCT, 2),
        "unidad" => "m2SC"
    ),
    "distancia_cvc" => array(
        "id" => "distanciaCVC",
        "nombre" => "Distancia CVC *",
        "valor" => $CVC,
        "unidad" => "cm"
    ),
    'atropina' => array(
        'nombre' => 'Atropina',
        'valor' => (floatval($peso) * 0.02 > 0.3) ? 0.3 : floatval($peso) * 0.02,
        'unidad' => 'mg'
    ),
    'bicarbonato' => array(
        'nombre' => 'Bicarbonato 8%',
        'valor' => (floatval($peso) * 1 > 50) ? 50 : floatval($peso),
        'unidad' => 'ml'
    ),
    'epinefrina' => array(
        'nombre' => 'Epinefrina (PCR)',
        'valor' => (floatval($peso) * 0.01 > 1.0) ? 1.0 : floatval($peso) * 0.01,
        'unidad' => 'mg'
    ),
    'calcioCl' => array(
        'id' => 'calcioCl',
        'nombre' => 'Calcio Cloruro (10%)',
        'valor' => (floatval($peso) * 10 > 1000) ? 1000 : floatval($peso) * 10,
        'unidad' => 'mg'
    ),
    'calcioGl' => array(
        'id' => 'calcioGl',
        'nombre' => 'Calcio Gluconato (10%)',
        'valor' => (floatval($peso) * 30 > 3000) ? 3000 : floatval($peso) * 30,
        'unidad' => 'mg'
    ),
    'adenosina' => array(
        'id' => 'adenosina',
        'nombre' => 'Adenosina',
        'valor' => (floatval($peso) * 0.2 > 6.0) ? 6.0 : floatval($peso) * 0.2,
        'unidad' => 'mg'
    ),
    'amiodarona' => array(
        'id' => 'amiodarona',
        'nombre' => 'Amiodarona',
        'valor' => (floatval($peso) * 2 > 300) ? 300 : floatval($peso) * 2,
        'unidad' => 'mg'
    ),
    'lidocaina' => array(
        'id' => 'lidocaina',
        'nombre' => 'Lidocaína',
        'valor' => (floatval($peso) * 1 > 100) ? 100 : floatval($peso) * 1,
        'unidad' => 'mg'
    )
);

$pesoVar = $_POST['peso'];

$calculos2 = array(
    'rocuronio' => array(
        'id' => 'rocuronio',
        'nombre' => 'Rocuronio (2DE95)',
        'valor' => (floatval($pesoVar) * 0.6 > 50) ? 50 : floatval($pesoVar) * 0.6,
        'unidad' => 'mg'
    ),
    'midazolam' => array(
        'id' => 'midazolam',
        'nombre' => 'Midazolam',
        'valor' => round((floatval($pesoVar) * 0.2 > 5) ? 5 : floatval($pesoVar) * 0.2, 2),
        'unidad' => 'mg'
    ),
    'fentaInd' => array(
        'id' => 'fentaInd',
        'nombre' => 'Fentanyl (inducción)',
        'valor' => (floatval($pesoVar) * 3 > 300) ? 300 : floatval($pesoVar) * 3,
        'unidad' => 'ug'
    ),
    'fentaAna' => array(
        'id' => 'fentaAna',
        'nombre' => 'Fentanyl (analgesia)',
        'valor' => (floatval($pesoVar) * 0.5 > 50) ? 50 : floatval($pesoVar) * 0.5,
        'unidad' => 'ug'
    ),
    'morfina' => array(
        'id' => 'morfina',
        'nombre' => 'Morfina',
        'valor' => (floatval($pesoVar) * 0.05 > 3) ? 3 : floatval($pesoVar) * 0.05,
        'unidad' => 'mg'
    ),
    'glucosa' => array(
        'id' => 'glucosa',
        'nombre' => 'Glucosa (30%)',
        'valor' => (floatval($pesoVar) * 0.15 > 6) ? 6 : floatval($pesoVar) * 0.15,
        'unidad' => 'gr'
    ),
    'naloxona' => array(
        'id' => 'naloxona',
        'nombre' => 'Naloxona',
        'valor' => (floatval($pesoVar) * 5 > 400) ? 400 : floatval($pesoVar) * 5,
        'unidad' => 'ug'
    ),
    'flumazenil' => array(
        'id' => 'flumazenil',
        'nombre' => 'Flumazenil',
        'valor' => (floatval($pesoVar) * 5 > 100) ? 100 : floatval($pesoVar) * 5,
        'unidad' => 'ug'
    ),
    'cardiov' => array(
        'id' => 'cardiov',
        'nombre' => 'Cardioversión 1',
        'valor' => (floatval($pesoVar) * 0.5 > 100) ? 100 : floatval($pesoVar) * 0.5,
        'unidad' => 'J'
    ),
    'desfibr' => array(
        'id' => 'desfibr',
        'nombre' => 'Desfibrilación 1',
        'valor' => (floatval($pesoVar) * 2 > 200) ? 200 : floatval($pesoVar) * 2,
        'unidad' => 'J'
    ),    
    'desfibr2' => array(
        'id' => 'desfibr2',
        'nombre' => 'Desfibrilación 2 y 3',
        'valor' => (floatval($pesoVar) * 4 > 200) ? 200 : floatval($pesoVar) * 4,
        'unidad' => 'J'
    )
);


// Head de la pagina



    require('../pdf/tfpdf.php');//

    $pdf = new tFPDF('P','mm','Letter');
    $pdf->AddPage();
    $pdf->SetTitle('pdf_ped',true);

    
    $pdf->SetCreator('www.anestesiauach.cl');
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);



$pdf->Image('../app/images/austral_b.png', 5, 4, 15.5, 18.5);
$pdf->SetFont('DejaVu','',7);
$pdf->SetY(5);
$pdf->SetX(22);
$pdf->Cell(18, 8, 'Programa de Anestesiología', 0, 0);

$pdf->Ln(4);
$pdf->SetX(22);
$pdf->Cell(18, 8, 'Universidad Austral de Chile', 0, 0);

$pdf->Ln(4);
$pdf->SetX(25);
$pdf->Cell(18, 8, 'app.anestesiauach.cl', 0, 0);
$pdf->Ln(10);


$pdf->SetMargins(25,20,25); // Set margins to 0
$pdf->SetFont('DejaVu','',14);
$width = $pdf->GetStringWidth($titulo) + 6; // Get width of the string
$x = ($pdf->GetPageWidth() - $width) / 2;
$pdf->SetX($x); // Center the string on the page
$pdf->Cell($width, 10, $titulo, 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('DejaVu','',12);
$pdf->SetX(20);
$pdf->Cell(20, 10, 'Nombre:', 0, 0); // el último '0' indica que no se moverá a la siguiente línea
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 110, 8);

$pdf->SetX(155); 
date_default_timezone_set('America/Caracas'); // Caracas, Venezuela está en GMT-4
$pdf->Cell(20, 10, 'Fecha: '.date('d/m/Y'), 0, 0);
$pdf->Ln(8);

if ($peso){
$pdf->Cell(12, 10, 'Peso:', 0, 0); // el último '0' indica que no se moverá a la siguiente línea
$pdf->Cell(7, 10, $peso, 0, 0);
$pdf->Cell(30, 10, 'Kg', 0, 0);
}

if ($talla){
$pdf->Cell(12, 10, 'Talla:', 0, 0); // el último '0' indica que no se moverá a la siguiente línea
$pdf->Cell(7, 10, $talla, 0, 0);
$pdf->Cell(30, 10, 'cm', 0, 0);
}

if ($edad){
$pdf->Cell(12, 10, 'Edad:', 0, 0); // el último '0' indica que no se moverá a la siguiente línea
$pdf->Cell(7, 10, $edad, 0, 0);
$pdf->Cell(10, 10, $tipo, 0, 0);
}

//Celdas de cada una de los fármacos

$pdf->Sety(58);
foreach ($calculos as $medicamento) {

    if ($fill) {
        $pdf->SetFillColor(220, 220, 220);  // Establece el color de relleno a gris claro
    } else {
        $pdf->SetFillColor(255, 255, 255);  // Establece el color de relleno a blanco
    }


$pdf->Ln(10); 
$pdf->SetX(15);
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 55, 10, 'FD');
$pdf->SetX(18);
$pdf->Cell(80, 10, $medicamento['nombre'], 0, 0);

$pdf->SetX(70);
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 15, 10, 'FD' );
$pdf->SetX(72);
$pdf->Cell(10, 10, $medicamento['valor'], 0, 0);

$pdf->SetX(85);
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 20, 10, 'FD');
$pdf->SetX(87);
$pdf->Cell(10, 10, $medicamento['unidad'], 0, 0);

    $fill = !$fill;

}


$pdf->Sety(58);
foreach ($calculos2 as $medicamento2) {
    
    if ($fill2) {
        $pdf->SetFillColor(220, 220, 220);  // Establece el color de relleno a gris claro
    } else {
        $pdf->SetFillColor(255, 255, 255);  // Establece el color de relleno a blanco
    }    
    
$pdf->Ln(10); 
$pdf->SetX(110);
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 55, 10, 'FD');
$pdf->SetX(113);
$pdf->Cell(80, 10, $medicamento2['nombre'], 0, 0);

$pdf->SetX(165);
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 15, 10, 'FD');
$pdf->SetX(167);
$pdf->Cell(10, 10, $medicamento2['valor'], 0, 0);

$pdf->SetX(180);
$pdf->Rect($pdf->GetX(), $pdf->GetY(),20, 10, 'FD');
$pdf->SetX(182);
$pdf->Cell(10, 10, $medicamento2['unidad'], 0, 0);


    $fill2 = !$fill2;

}

$pdf->Sety(197);
$pdf->SetX(15);
$pdf->SetFont('DejaVu','',10);
$pdf->SetTextColor(127, 127, 127);
$pdf->Cell(10, 10, '* Distancia de CVC desde Vena Yugular Interna Derecha', 0, 0);


    $pdf->Output('I', 'pdf_ped.pdf');


?>