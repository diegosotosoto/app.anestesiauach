<?php

// ===============================
// RECIBIR DATOS
// ===============================
$peso  = isset($_POST['peso']) ? $_POST['peso'] : '';
$talla = isset($_POST['talla']) ? $_POST['talla'] : '';
$edad  = isset($_POST['edad']) ? $_POST['edad'] : '';

$pesoVar   = floatval($peso);
$edadInput = floatval($edad);
$tipo = (isset($_POST['meses']) && $_POST['meses'] == '1') ? 'meses' : 'años';

$titulo = "Dosis Pediátrica de Emergencia";

date_default_timezone_set('America/Santiago');

// ===============================
// FUNCIONES AUXILIARES
// ===============================
function fmt($valor, $dec = 1) {
    if ($valor === '' || $valor === null || !is_numeric($valor)) return '';
    return number_format((float)$valor, $dec, '.', '');
}

function edadEnMeses($edad, $tipo) {
    if (!is_numeric($edad) || $edad < 0) return null;
    return ($tipo === 'años') ? $edad * 12 : $edad;
}

function obtenerGrupoEtario($edad, $tipo) {
    $meses = edadEnMeses($edad, $tipo);
    if ($meses === null) return ['grupo' => '—', 'fc' => '—', 'pa' => '—'];

    if ($meses < 3) {
        return ['grupo' => 'RN–3 m', 'fc' => '110–180', 'pa' => '60–75 / 35–45'];
    } elseif ($meses < 12) {
        return ['grupo' => '3–12 m', 'fc' => '100–170', 'pa' => '70–90 / 40–55'];
    } elseif ($meses < 48) {
        return ['grupo' => '1–3 a', 'fc' => '90–150', 'pa' => '80–100 / 50–65'];
    } elseif ($meses < 72) {
        return ['grupo' => '4–5 a', 'fc' => '80–140', 'pa' => '80–110 / 55–70'];
    } elseif ($meses < 144) {
        return ['grupo' => '6–12 a', 'fc' => '70–120', 'pa' => '90–120 / 60–75'];
    } else {
        return ['grupo' => '≥13 a', 'fc' => '60–100', 'pa' => '100–135 / 65–85'];
    }
}

function calcularTubo($edadInput, $tipo) {
    if ($edadInput <= 0) return '';

    if ($tipo == 'años') {
        $tubo = $edadInput / 4 + 3.5;
        if ($tubo < 2.5) $tubo = 2.5;
        if ($tubo > 7.0) $tubo = 7.0;
    } else {
        if ($edadInput >= 18) {
            $tubo = $edadInput / 12 / 4 + 3.5;
        } elseif ($edadInput >= 9) {
            $tubo = 3.5;
        } elseif ($edadInput >= 3) {
            $tubo = 3.0;
        } else {
            $tubo = 2.5;
        }
    }

    return round($tubo * 2) / 2;
}

function calcularDistBoca($edadInput, $tipo) {
    if ($edadInput <= 0) return '';

    if ($tipo == 'años') {
        $dist = $edadInput / 2 + 12;
        if ($dist < 7.5) $dist = 7.5;
        if ($dist > 21.0) $dist = 21.0;
    } else {
        if ($edadInput >= 18) {
            $dist = $edadInput / 12 / 2 + 12;
        } elseif ($edadInput >= 9) {
            $dist = 10.5;
        } elseif ($edadInput >= 3) {
            $dist = 9.0;
        } else {
            $dist = 7.5;
        }
    }

    return round($dist * 2) / 2;
}

function calcularSC($pesoVar) {
    if ($pesoVar <= 0) return '';
    return ($pesoVar < 10.0)
        ? ((($pesoVar * 4) + 9) / 100)
        : ((($pesoVar * 4) + 7) / ($pesoVar + 90));
}

function calcularCVC($pesoVar) {
    if ($pesoVar <= 0) return '';
    return ($pesoVar < 2.0) ? 3 :
        (($pesoVar <= 2.9) ? 4 :
        (($pesoVar <= 4.9) ? 5 :
        (($pesoVar <= 6.9) ? 6 :
        (($pesoVar <= 9.9) ? 7 :
        (($pesoVar <= 12.9) ? 8 :
        (($pesoVar <= 19.9) ? 9 :
        (($pesoVar <= 29.9) ? 10 :
        (($pesoVar <= 39.9) ? 11 :
        (($pesoVar <= 49.9) ? 12 :
        (($pesoVar <= 59.9) ? 13 :
        (($pesoVar <= 69.9) ? 14 :
        (($pesoVar <= 79.9) ? 15 : 16))))))))))));
}

// ===============================
// CÁLCULOS
// ===============================
$tubo         = calcularTubo($edadInput, $tipo);
$distBoca     = calcularDistBoca($edadInput, $tipo);
$numeroSCT    = calcularSC($pesoVar);
$CVC          = calcularCVC($pesoVar);
$grupoEtario  = obtenerGrupoEtario($edadInput, $tipo);

// ===============================
// TABLAS DE DATOS
// ===============================
$calculos = array(
    array('nombre' => 'Superficie corporal',  'valor' => fmt($numeroSCT, 2),                'unidad' => 'm²'),
    array('nombre' => 'Distancia CVC *',      'valor' => $CVC,                              'unidad' => 'cm'),
    array('nombre' => 'Tubo endotraqueal',    'valor' => fmt($tubo, 1),                     'unidad' => 'ID'),
    array('nombre' => 'Dist. a boca',         'valor' => fmt($distBoca, 1),                 'unidad' => 'cm'),
    array('nombre' => 'Atropina',             'valor' => fmt(min($pesoVar * 0.02, 0.3), 2), 'unidad' => 'mg'),
    array('nombre' => 'Bicarbonato 8%',       'valor' => fmt(min($pesoVar * 1, 50), 0),     'unidad' => 'mL'),
    array('nombre' => 'Epinefrina (PCR)',     'valor' => fmt(min($pesoVar * 0.01, 1.0), 2), 'unidad' => 'mg'),
    array('nombre' => 'Calcio Cloruro 10%',   'valor' => fmt(min($pesoVar * 10, 1000), 0),  'unidad' => 'mg'),
    array('nombre' => 'Calcio Gluconato 10%', 'valor' => fmt(min($pesoVar * 30, 3000), 0),  'unidad' => 'mg')
);

$calculos2 = array(
    array('nombre' => 'Adenosina',            'valor' => fmt(min($pesoVar * 0.2, 6.0), 1), 'unidad' => 'mg'),
    array('nombre' => 'Amiodarona',           'valor' => fmt(min($pesoVar * 2, 300), 1),   'unidad' => 'mg'),
    array('nombre' => 'Lidocaína',            'valor' => fmt(min($pesoVar * 1, 100), 1),   'unidad' => 'mg'),
    array('nombre' => 'Rocuronio (2 DE95)',   'valor' => fmt(min($pesoVar * 0.6, 50), 1),  'unidad' => 'mg'),
    array('nombre' => 'Midazolam',            'valor' => fmt(min($pesoVar * 0.2, 5), 1),   'unidad' => 'mg'),
    array('nombre' => 'Fentanyl (inducción)', 'valor' => fmt(min($pesoVar * 3, 300), 0),   'unidad' => 'µg'),
    array('nombre' => 'Fentanyl (analgesia)', 'valor' => fmt(min($pesoVar * 0.5, 50), 0),  'unidad' => 'µg'),
    array('nombre' => 'Morfina',              'valor' => fmt(min($pesoVar * 0.05, 3), 1),  'unidad' => 'mg'),
    array('nombre' => 'Glucosa 30%',          'valor' => fmt(min($pesoVar * 0.5, 60), 1),  'unidad' => 'mL'),
    array('nombre' => 'Naloxona',             'valor' => fmt(min($pesoVar * 5, 400), 0),   'unidad' => 'µg'),
    array('nombre' => 'Flumazenil',           'valor' => fmt(min($pesoVar * 5, 100), 0),   'unidad' => 'µg'),
    array('nombre' => 'Cardioversión 1',      'valor' => fmt(min($pesoVar * 0.5, 100), 0), 'unidad' => 'J'),
    array('nombre' => 'Desfibrilación 1',     'valor' => fmt(min($pesoVar * 2, 200), 0),   'unidad' => 'J'),
    array('nombre' => 'Desfibrilación 2 y 3', 'valor' => fmt(min($pesoVar * 4, 200), 0),   'unidad' => 'J')
);

// ===============================
// PDF
// ===============================
require('../pdf/tfpdf.php');

class PDF extends tFPDF {

    function Header() {
        $this->Image('../app/images/austral_b.png', 16, 8, 14, 16);

        $this->SetTextColor(85, 95, 110);
        $this->SetFont('DejaVu','',7.5);
        $this->SetXY(32, 9);
        $this->Cell(0, 4, 'Programa de Anestesiología', 0, 1);
        $this->SetX(32);
        $this->Cell(0, 4, 'Universidad Austral de Chile', 0, 1);
        $this->SetX(32);
        $this->Cell(0, 4, 'app.anestesiauach.cl', 0, 1);

        // Franja título
        $this->SetFillColor(33, 64, 154);
        $this->Rect(16, 26, 188, 11, 'F');
        $this->SetTextColor(255,255,255);
        $this->SetFont('DejaVu','',13);
        $this->SetXY(16, 28.2);
        $this->Cell(188, 5, 'Dosis Pediátrica de Emergencia', 0, 0, 'C');

        // Nombre paciente
        $this->SetTextColor(35, 45, 60);
        $this->SetFont('DejaVu','',9);
        $this->SetXY(16, 41);
        $this->Cell(22, 5, 'Paciente:', 0, 0);
        $this->Rect(38, 41, 100, 6.5);

        $this->SetXY(146, 41);
        $this->Cell(12, 5, 'Fecha:', 0, 0);
        $this->Cell(20, 5, date('d/m/Y'), 0, 0);

        $this->Ln(13);
    }

    function Footer() {
        $this->SetY(-12);
        $this->SetTextColor(120,120,120);
        $this->SetFont('DejaVu','',7);
        $this->Cell(0, 4, '* Distancia de CVC estimada desde Vena Yugular Interna Derecha', 0, 0, 'L');
    }

    function sectionTitle($x, $y, $w, $title) {
        $this->SetFillColor(235, 241, 255);
        $this->SetDrawColor(214, 223, 237);
        $this->Rect($x, $y, $w, 7, 'DF');
        $this->SetTextColor(85,95,110);
        $this->SetFont('DejaVu','',8);
        $this->SetXY($x + 2, $y + 1.4);
        $this->Cell($w - 4, 4, strtoupper($title), 0, 0, 'L');
    }

    function summaryBox($x, $y, $w, $h, $label, $value) {
        $this->SetFillColor(248,250,252);
        $this->SetDrawColor(220,227,238);
        $this->Rect($x, $y, $w, $h, 'DF');

        $this->SetTextColor(102,112,133);
        $this->SetFont('DejaVu','',7);
        $this->SetXY($x + 2, $y + 1.5);
        $this->Cell($w - 4, 3, $label, 0, 0, 'L');

        $this->SetTextColor(31,42,55);
        $this->SetFont('DejaVu','',10);
        $this->SetXY($x + 2, $y + 5.3);
        $this->Cell($w - 4, 4, $value, 0, 0, 'L');
    }

function rowCalc($x, $y, $w1, $w2, $w3, $nombre, $valor, $unidad, $fill=false) {
    if ($fill) {
        $this->SetFillColor(247,249,252);
    } else {
        $this->SetFillColor(255,255,255);
    }

    $this->SetDrawColor(224,230,238);
    $this->SetTextColor(35,45,60);
    $this->SetFont('DejaVu','',8.1);

    $esPA = ($nombre === 'PA normal edad');
    $h = $esPA ? 10.5 : 6.5;

    $this->Rect($x, $y, $w1, $h, 'DF');
    $this->Rect($x + $w1, $y, $w2, $h, 'DF');
    $this->Rect($x + $w1 + $w2, $y, $w3, $h, 'DF');

    // Nombre
    $this->SetXY($x + 1.6, $y + ($esPA ? 3.1 : 1.15));
    $this->Cell($w1 - 3, 4.2, $nombre, 0, 0, 'L');

    // Valor
    if ($esPA) {
        $valor2lineas = str_replace(' / ', "\n", $valor);

        $this->SetXY($x + $w1 + 0.5, $y + 1.2);
        $this->MultiCell($w2 - 1, 3.9, $valor2lineas, 0, 'C');
    } else {
        $this->SetXY($x + $w1, $y + 1.15);
        $this->Cell($w2, 4.2, $valor, 0, 0, 'C');
    }

    // Unidad
    $this->SetXY($x + $w1 + $w2, $y + ($esPA ? 3.1 : 1.15));
    $this->Cell($w3, 4.2, $unidad, 0, 0, 'C');

    return $h;
}

}

$pdf = new PDF('P','mm','Letter');
$pdf->SetTitle('pdf_ped', true);
$pdf->SetCreator('www.anestesiauach.cl');
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetMargins(16,12,12);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

// ===============================
// RESUMEN SUPERIOR
// ===============================
$yResumen = 51;
$pdf->summaryBox(16,  $yResumen, 43, 12, 'Peso',  ($peso  !== '' ? $peso.' kg' : '—'));
$pdf->summaryBox(63,  $yResumen, 43, 12, 'Talla', ($talla !== '' ? $talla.' cm' : '—'));
$pdf->summaryBox(110, $yResumen, 43, 12, 'Edad',  ($edad  !== '' ? $edad.' '.$tipo : '—'));
$pdf->summaryBox(157, $yResumen, 47, 12, 'Grupo etario', $grupoEtario['grupo']);

// ===============================
// BLOQUE HEMODINÁMICO
// ===============================
$yHemo = 67;
$pdf->sectionTitle(16, $yHemo, 188, 'Parámetros fisiológicos orientativos');
$pdf->SetFillColor(249,251,255);
$pdf->SetDrawColor(220,227,238);
$pdf->Rect(16, $yHemo + 8, 188, 16, 'DF');

$pdf->SetTextColor(85,95,110);
$pdf->SetFont('DejaVu','',8);
$pdf->SetXY(19, $yHemo + 10);
$pdf->Cell(30, 4, 'FC normal edad:', 0, 0);
$pdf->SetTextColor(35,45,60);
$pdf->Cell(30, 4, $grupoEtario['fc'].' lpm', 0, 0);

$pdf->SetTextColor(85,95,110);
$pdf->Cell(32, 4, 'PA normal edad:', 0, 0);
$pdf->SetTextColor(35,45,60);
$pdf->Cell(48, 4, $grupoEtario['pa'].' mmHg', 0, 0);

$pdf->SetXY(19, $yHemo + 15);
$pdf->SetTextColor(102,112,133);
$pdf->SetFont('DejaVu','',7);
$pdf->MultiCell(
    178,
    9,
    'Valores orientativos para paciente despierto y en reposo. En paciente dormido, sedado o anestesiado, la PA puede ser 20% menor que el basal.',
    0,
    'L'
);

// ===============================
// COLUMNAS
// ===============================
$topY = 93;
$pdf->sectionTitle(16,  $topY, 88, 'Cálculos y fármacos');
$pdf->sectionTitle(112, $topY, 88, 'Fármacos y energía');

$y1 = $topY + 8;
$fill = false;
foreach ($calculos as $item) {
    $altoFila = $pdf->rowCalc(16, $y1, 52, 18, 18, $item['nombre'], $item['valor'], $item['unidad'], $fill);
    $y1 += $altoFila;
    $fill = !$fill;
}

$y2 = $topY + 8;
$fill2 = false;
foreach ($calculos2 as $item) {
    $altoFila = $pdf->rowCalc(112, $y2, 52, 18, 18, $item['nombre'], $item['valor'], $item['unidad'], $fill2);
    $y2 += $altoFila;
    $fill2 = !$fill2;
}

// ===============================
// NOTA DE SEGURIDAD
// ===============================
$ySeg = 197;
$pdf->sectionTitle(16, $ySeg, 188, 'Recordatorios de seguridad');
$pdf->SetFillColor(255,255,255);
$pdf->SetDrawColor(220,227,238);
$pdf->Rect(16, $ySeg + 8, 188, 14, 'DF');

$pdf->SetXY(19, $ySeg + 9.5);
$pdf->SetTextColor(35,45,60);
$pdf->SetFont('DejaVu','',7.2);
$pdf->MultiCell(
    180,
    3.3,
    "• Confirmar siempre concentración, vía y unidad antes de administrar.\n".
    "• Verificar epinefrina y adenosina verbalmente en escenarios críticos.\n".
    "• Hoja de apoyo rápido: no reemplaza juicio clínico ni evaluación del contexto.",
    0,
    'L'
);

$pdf->Output('I', 'pdf_ped.pdf');
?>