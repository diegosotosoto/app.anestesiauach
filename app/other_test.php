<?php
// Página combinada Tesseract.js + Quagga2 para lectura de códigos de barras
// NOTA: Esta página es solo para testing, no requiere autenticación

// Intentar cargar head.php si existe, sino usar un HTML básico
if (file_exists('head.php')) {
  $boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar = "<span class='text-white'>OCR + Barcode</span>";
  $boton_navbar = "<a></a>";
  require("head.php");
} else {
  // HTML básico si no existe head.php
  ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lector OCR + Barcode - Test</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="container mt-4">
<?php
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
.scanner-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.scanner-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1rem;
  text-align: center;
}

.scanner-description {
  color: #64748b;
  text-align: center;
  margin-bottom: 1.5rem;
}

#interactive {
  position: relative;
  width: 100%;
  height: 300px;
  background: #000;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 1.5rem;
}

#interactive video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

#interactive canvas {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.scanner-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 95%;
  height: 70%;
  border: 3px dashed rgba(255, 255, 255, 0.8);
  border-radius: 12px;
  pointer-events: none;
  box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.3);
}

.scanner-overlay::before {
  content: 'Alinea el código de barras aquí';
  position: absolute;
  top: -30px;
  left: 50%;
  transform: translateX(-50%);
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.85rem;
  white-space: nowrap;
}

/* Guías visuales según formato de ficha hospitalaria */
.guide-barcode {
  position: absolute;
  top: 10%;
  left: 15%;
  width: 80%;
  height: 18%;
  border: 3px solid rgba(255, 0, 0, 0.7);
  border-radius: 8px;
  pointer-events: none;
  box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.3);
}

.guide-barcode::before {
  content: 'CÓDIGO DE BARRAS';
  position: absolute;
  bottom: -20px;
  left: 5px;
  color: rgba(255, 0, 0, 0.9);
  font-size: 0.7rem;
  font-weight: 600;
}

.guide-rut {
  position: absolute;
  top: 2%;
  left: 15%;
  width: 45%;
  height: 7%;
  border: 3px solid rgba(0, 123, 255, 0.9);
  border-radius: 8px;
  pointer-events: none;
}

.guide-rut::before {
  content: 'RUN / RUT';
  position: absolute;
  top: -18px;
  left: 5px;
  color: rgba(0, 123, 255, 1);
  font-size: 0.7rem;
  font-weight: 700;
}

.guide-ficha {
  position: absolute;
  top: 2%;
  left: 2%;
  width: 12%;
  height: 65%;
  border: 3px solid rgba(40, 167, 69, 0.9);
  border-radius: 8px;
  pointer-events: none;
}

.guide-ficha::before {
  content: 'FICHA';
  position: absolute;
  top: -18px;
  left: 5px;
  color: rgba(40, 167, 69, 1);
  font-size: 0.7rem;
  font-weight: 700;
}

.result-container {
  background: var(--app-card, #ffffff);
  border: 1px solid var(--app-border, #e2e8f0);
  border-radius: 12px;
  padding: 1.5rem;
}

.result-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--app-muted, #64748b);
  margin-bottom: 0.5rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

#barcode-input {
  width: 100%;
  padding: 12px 16px;
  font-size: 1.1rem;
  border: 2px solid var(--app-border, #e2e8f0);
  border-radius: 8px;
  background: var(--app-card, #ffffff);
  color: var(--app-text, #334155);
  font-family: monospace;
}

#barcode-input:focus {
  outline: none;
  border-color: var(--app-blue, #2563eb);
}

/* Dark mode */
body.theme-dark .result-container {
  background: var(--app-card, #1e293b);
  border-color: var(--app-border, #334155);
}

body.theme-dark #barcode-input {
  background: var(--app-card, #1e293b);
  border-color: var(--app-border, #334155);
  color: var(--app-text, #e2e8f0);
}

/* Check verde de éxito */
.success-check {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  background: rgba(16, 185, 129, 0.1);
  border: 2px solid #10b981;
  border-radius: 12px;
  margin-bottom: 1rem;
  animation: fadeIn 0.3s ease;
}

.success-check.hidden {
  display: none;
}

.success-check i {
  font-size: 4rem;
  color: #10b981;
  margin-bottom: 0.5rem;
}

.success-check span {
  font-size: 1.1rem;
  font-weight: 600;
  color: #059669;
}

/* Botones de acción */
.btn-retry, .btn-ocr {
  width: 100%;
  padding: 14px 24px;
  background: linear-gradient(135deg, #2563eb, #3b82f6);
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-top: 0.5rem;
}

.btn-ocr {
  background: linear-gradient(135deg, #7c3aed, #8b5cf6);
}

.btn-retry:hover:not(:disabled), .btn-ocr:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-ocr:hover:not(:disabled) {
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
}

.btn-retry:disabled, .btn-ocr:disabled {
  background: #9ca3af;
  cursor: not-allowed;
  opacity: 0.7;
}

/* Animación fadeIn */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Ocultar cámara */
#camera-container.hidden {
  display: none;
}

/* Estado OCR */
.ocr-status {
  text-align: center;
  padding: 0.5rem;
  font-size: 0.85rem;
  color: #64748b;
  min-height: 1.5rem;
}

body.theme-dark .success-check {
  background: rgba(16, 185, 129, 0.15);
  border-color: #34d399;
}

body.theme-dark .success-check span {
  color: #34d399;
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="scanner-container">

        <h1 class="scanner-title"><i class="fa-solid fa-barcode me-2"></i>Lector OCR + Barcode</h1>
        <p class="scanner-description">
          Escanea el código de barras o usa OCR para leer RUT y FICHA. El dígito verificador se calcula automáticamente.
        </p>

        <!-- Área de cámara -->
        <div id="camera-container">
          <div id="interactive" class="viewport">
            <!-- Guías visuales según formato ficha hospitalaria -->
            <div class="guide-barcode"></div>
            <div class="guide-rut"></div>
            <div class="guide-ficha"></div>
          </div>
        </div>

        <!-- Check verde (aparece al completar) -->
        <div id="success-check" class="success-check hidden">
          <i class="fa-solid fa-check-circle"></i>
          <span>¡Código escaneado!</span>
        </div>

        <!-- Estado OCR -->
        <div id="ocr-status" class="ocr-status"></div>

        <!-- Resultados -->
        <div class="result-container mt-4">
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="result-label">RUT (con DV calculado):</div>
              <input type="text" id="input-rut" class="form-control form-control-lg" placeholder="Esperando escaneo..." readonly style="font-family:monospace;">
            </div>
            <div class="col-md-6 mb-3">
              <div class="result-label">Ficha:</div>
              <input type="text" id="input-ficha" class="form-control form-control-lg" placeholder="Esperando escaneo..." readonly style="font-family:monospace;">
            </div>
          </div>
        </div>

        <!-- Botones -->
        <button id="btn-retry" class="btn-retry" onclick="retryScan()" disabled>
          <i class="fa-solid fa-rotate-right me-2"></i>Reintentar
        </button>
        <button id="btn-ocr" class="btn-ocr" onclick="runOCR()" style="display:none;">
          <i class="fa-solid fa-eye me-2"></i>Refinar con OCR
        </button>

      </div>
    </div>
  </div>
</div>

<?php
  // Cerrar HTML básico si no se cargó head.php
  if (!file_exists('head.php')) {
    echo '</div></body></html>';
  } else {
    require("footer.php");
  }
?>

<!-- Quagga 2 y Tesseract.js -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.8.4/dist/quagga.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>

<script>
var isScanning = false;
var track = null;
var resultFound = false;
var ocrWorker = null;
var ocrInterval = null;

// Iniciar escaneo automáticamente al cargar la página
document.addEventListener('DOMContentLoaded', function() {
  startParallelScanning();
});

// Reintentar escaneo
function retryScan() {
  document.getElementById('success-check').classList.add('hidden');
  document.getElementById('camera-container').classList.remove('hidden');
  document.getElementById('input-rut').value = '';
  document.getElementById('input-ficha').value = '';
  document.getElementById('ocr-status').textContent = '';
  document.getElementById('btn-retry').disabled = true;
  resultFound = false;
  startParallelScanning();
}

// Iniciar escaneo paralelo: Quagga + OCR
async function startParallelScanning() {
  resultFound = false;
  document.getElementById('ocr-status').textContent = 'Iniciando escaneo paralelo (Barcode + OCR)...';

  var constraints = {
    width: { min: 640, ideal: 1280 },
    height: { min: 480, ideal: 720 },
    facingMode: { exact: "environment" }
  };

  Quagga.init({
    inputStream: {
      name: "Live",
      type: "LiveStream",
      target: document.querySelector('#interactive'),
      constraints: constraints,
      area: {
        top: "0%",
        right: "0%",
        left: "0%",
        bottom: "55%"
      }
    },
    decoder: {
      readers: [{
        format: "code_39_reader",
        config: {
          suppressCode128: true
        }
      }]
    },
    locator: {
      patchSize: "medium",
      halfSample: true
    },
    numOfWorkers: 2,
    frequency: 10,
    locate: true
  }, function(err) {
    if (err) {
      console.error('Error iniciando Quagga:', err);
      alert('Error al iniciar la cámara. Asegúrate de dar permisos de cámara.');
      return;
    }

    Quagga.start();
    isScanning = true;

    // Guardar referencia al track para flash
    var video = document.querySelector('#interactive video');
    if (video && video.srcObject) {
      track = video.srcObject.getVideoTracks()[0];
    }

    console.log('Escaneando con cámara trasera...');

    // Iniciar OCR en paralelo
    startParallelOCR();
  });

  // Callback cuando se detecta código con Quagga
  Quagga.onDetected(function(result) {
    if (resultFound) return;
    var code = result.codeResult.code;
    console.log('Quagga detectó:', code);
    handleResult('barcode', code);
  });
}

// Iniciar OCR en paralelo con Quagga
async function startParallelOCR() {
  try {
    // Esperar un poco para que la cámara se estabilice
    await new Promise(resolve => setTimeout(resolve, 1000));

    // Ejecutar OCR periódicamente
    ocrInterval = setInterval(async function() {
      if (resultFound || !isScanning) {
        clearInterval(ocrInterval);
        return;
      }

      try {
        var fullCanvas = captureImageForOCR();
        var rutCanvas = cropArea(fullCanvas, 2, 15, 45, 7);
        var fichaCanvas = cropArea(fullCanvas, 2, 2, 12, 65);

        const workerRut = await Tesseract.createWorker('spa');
        await workerRut.setParameters({ tessedit_char_whitelist: '0123456789.-Kk' });
        const resultRut = await workerRut.recognize(rutCanvas);
        await workerRut.terminate();

        const workerFicha = await Tesseract.createWorker('spa');
        await workerFicha.setParameters({ tessedit_char_whitelist: '0123456789' });
        const resultFicha = await workerFicha.recognize(fichaCanvas);
        await workerFicha.terminate();

        var rutText = resultRut.data.text.trim();
        var fichaText = resultFicha.data.text.trim();

        if (rutText || fichaText) {
          console.log('OCR detectó - RUT:', rutText, 'Ficha:', fichaText);
          handleResult('ocr', { rut: rutText, ficha: fichaText });
        }
      } catch (err) {
        console.error('Error en OCR paralelo:', err);
      }
    }, 2000); // Intentar OCR cada 2 segundos

  } catch (err) {
    console.error('Error iniciando OCR paralelo:', err);
  }
}

// Manejar resultado (sea de Quagga u OCR)
function handleResult(source, data) {
  if (resultFound) return;
  resultFound = true;

  // Detener ambos procesos
  clearInterval(ocrInterval);
  stopScanning();

  console.log('Resultado ganador:', source, data);

  if (source === 'barcode') {
    // Procesar código de barras
    processBarcode(data);
  } else if (source === 'ocr') {
    // Procesar resultado OCR
    processOCRResult(data.rut, data.ficha);
  }
}

// Procesar resultado OCR
function processOCRResult(rutText, fichaText) {
  var updated = false;

  // Procesar RUT del OCR
  if (rutText) {
    var cleanRut = rutText.replace(/\s/g, '');
    var rutMatch = cleanRut.match(/(\d{1,2}\.?\d{3}\.?\d{3}-[\dKk])/);
    var rutSimple = cleanRut.match(/(\d{7,8}-[\dKk])/);

    if (rutMatch) {
      document.getElementById('input-rut').value = rutMatch[1];
      updated = true;
    } else if (rutSimple) {
      document.getElementById('input-rut').value = rutSimple[1].toUpperCase();
      updated = true;
    }
  }

  // Procesar Ficha del OCR
  if (fichaText) {
    var cleanFicha = fichaText.replace(/\s/g, '');
    var fichaMatch = cleanFicha.match(/(\d{6})/);
    if (fichaMatch) {
      document.getElementById('input-ficha').value = fichaMatch[1];
      updated = true;
    }
  }

  if (updated) {
    document.getElementById('ocr-status').textContent = '¡OCR ganó la carrera! Datos capturados.';
  }

  // Ocultar cámara y mostrar éxito
  document.getElementById('camera-container').classList.add('hidden');
  document.getElementById('success-check').classList.remove('hidden');
  document.getElementById('btn-retry').disabled = false;
}

// Procesar código de barras: separar RUT-FICHA y calcular DV
function processBarcode(code) {
  var parts = code.split('-');
  var rutNumeros = '';
  var ficha = '';

  if (parts.length >= 2) {
    rutNumeros = parts[0];
    ficha = parts[parts.length - 1];
  } else if (parts.length === 1) {
    rutNumeros = parts[0];
    ficha = '';
  } else {
    rutNumeros = code;
    ficha = '';
  }

  // Calcular DV y formatear RUT
  var rut = formatearRUTConDV(rutNumeros);

  // Guardar en inputs
  document.getElementById('input-rut').value = rut;
  document.getElementById('input-ficha').value = ficha;

  document.getElementById('ocr-status').textContent = '¡Barcode ganó la carrera! Código escaneado.';

  // Ocultar cámara y mostrar éxito
  document.getElementById('camera-container').classList.add('hidden');
  document.getElementById('success-check').classList.remove('hidden');

  // Habilitar botón reintentar
  document.getElementById('btn-retry').disabled = false;
}

// Capturar imagen del video para OCR
function captureImageForOCR() {
  var video = document.querySelector('#interactive video');
  if (!video) {
    throw new Error('No se encontró el elemento de video');
  }

  var canvas = document.createElement('canvas');
  canvas.width = video.videoWidth || 640;
  canvas.height = video.videoHeight || 480;

  var ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

  return canvas;
}

// Crop de área específica para OCR
function cropArea(sourceCanvas, topPct, leftPct, widthPct, heightPct) {
  var width = sourceCanvas.width;
  var height = sourceCanvas.height;

  var cropCanvas = document.createElement('canvas');
  cropCanvas.width = width * (widthPct / 100);
  cropCanvas.height = height * (heightPct / 100);

  var ctx = cropCanvas.getContext('2d');
  ctx.drawImage(
    sourceCanvas,
    width * (leftPct / 100),
    height * (topPct / 100),
    width * (widthPct / 100),
    height * (heightPct / 100),
    0,
    0,
    cropCanvas.width,
    cropCanvas.height
  );

  return cropCanvas;
}

// Detener escaneo
function stopScanning() {
  if (isScanning) {
    Quagga.stop();
    isScanning = false;
  }
}

// Toggle flash (si está disponible)
function toggleFlash() {
  if (track) {
    var settings = track.getSettings();
    var isTorch = settings.torch || false;
    track.applyConstraints({ advanced: [{ torch: !isTorch }] }).catch(function(e) {
      console.log('Flash no soportado:', e);
    });
  }
}

// Calcular dígito verificador del RUT chileno
function calcularDigitoVerificador(rutNumeros) {
  var numeros = rutNumeros.toString().replace(/[^0-9]/g, '');
  if (numeros.length === 0) return '';

  var suma = 0;
  var multiplo = 2;

  for (var i = numeros.length - 1; i >= 0; i--) {
    suma += parseInt(numeros.charAt(i)) * multiplo;
    multiplo = multiplo < 7 ? multiplo + 1 : 2;
  }

  var resto = suma % 11;
  var dv = 11 - resto;

  if (dv === 11) return '0';
  if (dv === 10) return 'K';
  return dv.toString();
}

// Formatear RUT con dígito verificador
function formatearRUTConDV(rutSinDV) {
  var numeros = rutSinDV.toString().replace(/[^0-9]/g, '');
  if (numeros.length === 0) return '';

  var dv = calcularDigitoVerificador(numeros);
  return numeros + '-' + dv;
}

// Limpiar al cerrar la página
window.addEventListener('beforeunload', function() {
  if (isScanning) {
    Quagga.stop();
  }
});
</script>
