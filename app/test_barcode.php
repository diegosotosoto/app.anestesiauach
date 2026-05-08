<?php
// Página de prueba para escaneo de códigos de barras con Quagga 2
// NOTA: Esta página es solo para testing, no requiere autenticación

// Intentar cargar head.php si existe, sino usar un HTML básico
if (file_exists('head.php')) {
  $boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar = "<span class='text-white'>Test Barcode</span>";
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
  <title>Lector RUT-FICHA - Test</title>
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
  border: 3px dashed rgba(255, 255, 255, 0.9);
  border-radius: 12px;
  pointer-events: none;
  box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
  z-index: 100;
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

#barcode-result {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--app-blue, #2563eb);
  font-family: monospace;
  word-break: break-all;
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

/* Botón Reintentar */
.btn-retry {
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
  margin-top: 1rem;
}

.btn-retry:hover:not(:disabled) {
  background: linear-gradient(135deg, #1d4ed8, #2563eb);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-retry:disabled {
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

        <h1 class="scanner-title"><i class="fa-solid fa-barcode me-2"></i>Lector RUT-FICHA</h1>
        <p class="scanner-description">
          Apunta la cámara al código de barras. El formato es <strong>RUT-FICHA</strong> (ej: 12345678-1234567).
        </p>

        <!-- Área de cámara -->
        <div id="camera-container">
          <div id="interactive" class="viewport">
            <div class="scanner-overlay"></div>
          </div>
        </div>

        <!-- Check verde (aparece al completar) -->
        <div id="success-check" class="success-check hidden">
          <i class="fa-solid fa-check-circle"></i>
          <span>¡Código escaneado!</span>
        </div>

        <!-- Resultados -->
        <div class="result-container mt-4">
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="result-label">RUT:</div>
              <input type="text" id="input-rut" class="form-control form-control-lg" placeholder="Esperando escaneo..." readonly style="font-family:monospace;">
            </div>
            <div class="col-md-6 mb-3">
              <div class="result-label">Ficha:</div>
              <input type="text" id="input-ficha" class="form-control form-control-lg" placeholder="Esperando escaneo..." readonly style="font-family:monospace;">
            </div>
          </div>
        </div>

        <!-- Botón Reintentar -->
        <button id="btn-retry" class="btn-retry" onclick="retryScan()" disabled>
          <i class="fa-solid fa-rotate-right me-2"></i>Reintentar
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

<!-- Quagga 2 -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.8.4/dist/quagga.min.js"></script>

<script>
var isScanning = false;

// Iniciar escaneo automáticamente al cargar la página
document.addEventListener('DOMContentLoaded', function() {
  startScanning();
});

// Reintentar escaneo
function retryScan() {
  // Ocultar check y mostrar cámara
  document.getElementById('success-check').classList.add('hidden');
  document.getElementById('camera-container').classList.remove('hidden');

  // Limpiar resultados
  document.getElementById('input-rut').value = '';
  document.getElementById('input-ficha').value = '';

  // Deshabilitar botón
  document.getElementById('btn-retry').disabled = true;

  // Reiniciar escaneo
  startScanning();
}

// Iniciar escaneo
function startScanning() {
  // Forzar cámara trasera usando SOLO facingMode
  // NO usar deviceId porque puede anular facingMode en móviles
  var constraints = {
    width: { min: 640, ideal: 1280 },
    height: { min: 480, ideal: 720 },
    facingMode: { exact: "environment" } // exact fuerza cámara trasera
  };

  Quagga.init({
    inputStream: {
      name: "Live",
      type: "LiveStream",
      target: document.querySelector('#interactive'),
      constraints: constraints,
    },
    decoder: {
      readers: [
        "code_39_reader"
      ],
      debug: {
        showCanvas: false,
        showPatches: false,
        showFoundPatches: false,
        showSkeleton: false,
        showLabels: false,
        showPatchLabels: false,
        showRemainingPatchLabels: false,
        boxFromPatches: {
          showTransformed: false,
          showTransformedBox: false,
          showBB: false
        }
      }
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
    console.log('Escaneando con cámara trasera...');
  });

  // Configurar callback para cuando se detecta un código
  Quagga.onDetected(function(result) {
    var code = result.codeResult.code;
    var format = result.codeResult.format;

    console.log('Código detectado:', code, 'Formato:', format);

    // Separar código por guión (RUT-FICHA)
    var parts = code.split('-');
    var rut = '';
    var ficha = '';
    var rutNumeros = '';

    if (parts.length >= 2) {
      // El código viene sin dígito verificador en el RUT
      // Formato: "12345678-1234567" -> RUT: "12345678", FICHA: "1234567"
      // Calculamos el DV y formateamos: "12345678-5"
      rutNumeros = parts[0];
      ficha = parts[parts.length - 1]; // Última parte es la ficha
    } else if (parts.length === 1) {
      // Si no hay guión, asumimos que todo es el RUT
      rutNumeros = parts[0];
      ficha = '';
    } else {
      // Fallback
      rutNumeros = code;
      ficha = '';
    }

    // Formatear RUT con dígito verificador calculado
    rut = formatearRUTConDV(rutNumeros);

    // Llenar los inputs
    document.getElementById('input-rut').value = rut;
    document.getElementById('input-ficha').value = ficha;

    // Detener cámara
    stopScanning();

    // Ocultar cámara y mostrar check verde
    document.getElementById('camera-container').classList.add('hidden');
    document.getElementById('success-check').classList.remove('hidden');

    // Habilitar botón reintentar
    document.getElementById('btn-retry').disabled = false;
  });

}

// Detener escaneo
function stopScanning() {
  if (isScanning) {
    Quagga.stop();
    isScanning = false;
  }
}

// Calcular dígito verificador del RUT chileno
function calcularDigitoVerificador(rutNumeros) {
  // Limpiar el RUT dejando solo los números
  var numeros = rutNumeros.toString().replace(/[^0-9]/g, '');

  if (numeros.length === 0) return '';

  var suma = 0;
  var multiplo = 2;

  // Multiplicar dígitos de derecha a izquierda por 2,3,4,5,6,7
  for (var i = numeros.length - 1; i >= 0; i--) {
    suma += parseInt(numeros.charAt(i)) * multiplo;
    multiplo = multiplo < 7 ? multiplo + 1 : 2;
  }

  var resto = suma % 11;
  var dv = 11 - resto;

  if (dv === 11) {
    return '0';
  } else if (dv === 10) {
    return 'K';
  } else {
    return dv.toString();
  }
}

// Formatear RUT con dígito verificador
function formatearRUTConDV(rutSinDV) {
  // Limpiar dejando solo números
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
