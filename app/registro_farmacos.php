<?php
/**
 * ============================================================================
 * WIZARD DE REGISTRO DE FÁRMACOS - ANESTESIA CAV
 * ============================================================================
 * 
 * Este archivo es un wizard standalone (autónomo) que no requiere:
 * - Autenticación de usuario (por ahora, hasta que se integre al sistema CAV)
 * - Conexión a base de datos
 * - Inclusión de archivos externos (head.php, footer.php)
 * 
 * Flujo del wizard:
 * 1. Ingreso de cuenta corriente (6 dígitos numéricos)
 * 2. Selección de fármaco y presentación
 * 3. Cálculo de sobrante/administrado (pestañas bidireccionales)
 * 4. Resumen y generación de tabla para impresión vía AirPrint en iPhone/Android
 * 
 * CONFIGURACIÓN DE IMPRESIÓN:
 * - Actualmente usa AirPrint (window.print()) para impresión desde el dispositivo
 * - La impresora debe estar en la misma red WiFi que el dispositivo (192.168.203.x)
 * - Modelo compatible: Kyocera ECOSYS MA5500ifx con AirPrint habilitado 
 *  (192.168.203.108) de pabellón central
 * 
 * NOTA IMPORTANTE:
 * Este wizard NO almacena datos del paciente. Solo genera un registro temporal
 * para impresión inmediata. Los datos se pierden al cerrar la página o iniciar
 * un nuevo registro.
 * ============================================================================
 */

// Configuración de zona horaria para Chile
date_default_timezone_set('America/Santiago');

// Variables de fecha y hora para mostrar en el wizard y la impresión
$fecha_hora = date('d/m/Y H:i');  // Fecha completa con hora (ej: 02/06/2026 18:22)
$fecha = date('d/m/Y');             // Solo fecha (ej: 02/06/2026)
$hora = date('H:i');                // Solo hora (ej: 18:22)

// Label genérico del responsable (se muestra en la columna "Eliminador" de la tabla)
// TODO: Implementar autenticación real para obtener el nombre del usuario logueado
$nombre_usuario = 'Anestesia CAV';
 
// --- Datos de fármacos ---
$farmacos = [
    'fentanyl'     => ['label' => 'Fentanyl',     'unidad' => 'ug', 'presentaciones' => ['0,1mg/2ml' => 100, '0,5mg/10ml' => 500]],
    'propofol'     => ['label' => 'Propofol',     'unidad' => 'mg', 'presentaciones' => ['1%/20ml' => 200, '1%/100ml' => 1000]],
    'midazolam'    => ['label' => 'Midazolam',    'unidad' => 'mg', 'presentaciones' => ['5mg/1ml' => 5]],
    'remifentanyl' => ['label' => 'Remifentanyl', 'unidad' => 'ug', 'presentaciones' => ['2mg' => 2000]],
    'morfina'      => ['label' => 'Morfina',      'unidad' => 'mg', 'presentaciones' => ['10mg/1ml' => 10]],
    'metadona'     => ['label' => 'Metadona',     'unidad' => 'mg', 'presentaciones' => ['10mg/2ml' => 10]],
    'ketamina'     => ['label' => 'Ketamina',     'unidad' => 'mg', 'presentaciones' => ['500mg/10ml' => 500]],
];
 
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Registro de Fármacos</title>
<!-- Bootstrap 5.3 CSS desde CDN jsDelivr -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome 6.4 desde CDN cdnjs -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ── Wizard shell ── */
.rf-wrap {
    max-width: 480px;
    margin: 0 auto;
    padding: 1rem 1rem 6rem;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
}
 
/* Step cards */
.rf-step { display: none; }
.rf-step.active { display: block; }
 
.rf-card {
    background: var(--app-card-bg, #fff);
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(15,23,42,.10);
    padding: 1.6rem 1.4rem 1.8rem;
    margin-bottom: 1rem;
}
 
.rf-step-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--app-primary, #1d4ed8);
    margin-bottom: 1.2rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
 
.rf-step-badge {
    background: var(--app-primary, #1d4ed8);
    color: #fff;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    flex-shrink: 0;
}
 
/* Meta info */
.rf-meta {
    font-size: .95rem;
    color: #64748b;
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: .8rem;
}

/* Body base */
body {
    margin: 0;
    padding: .5rem;
    background: #f1f5f9;
}
body.theme-dark {
    background: #0f172a;
}
 
/* Drug grid - vertical with inline presentations */
.drug-grid {
    display: flex;
    flex-direction: column;
    gap: .5rem;
}
.drug-item {
    display: flex;
    flex-direction: column;
    gap: .5rem;
}
.drug-item-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .65rem;
}
.drug-btn {
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 12px;
    padding: .75rem .5rem;
    font-size: 1.05rem;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: all .2s ease-in-out;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .2rem;
    min-height: 64px; /* Altura uniforme para todos los botones */
    justify-content: center;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.drug-btn-sub {
    font-size: .85rem;
    font-weight: 500;
    color: #64748b;
}
.drug-btn:hover {
    border-color: var(--app-primary, #1d4ed8);
    background: #eff6ff;
    color: var(--app-primary, #1d4ed8);
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.drug-btn.selected {
    border: 4px solid var(--app-primary, #1d4ed8);
    background: #dbeafe;
    color: #1e40af;
    font-weight: 700;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25);
}

/* Colores específicos por fármaco */
.drug-btn.drug-fentanyl { background: #fdf2f8; border-color: #f9c4dd; color: #9d174d; }
.drug-btn.drug-fentanyl:hover { background: #fce7f3; border-color: #f9a8d4; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(190, 24, 93, 0.15); }
.drug-btn.drug-fentanyl.selected { background: #fbcfe8; border: 4px solid #f472b6; color: #831843; font-weight: 700; transform: scale(1.02); box-shadow: 0 4px 12px rgba(244, 114, 182, 0.35); }

.drug-btn.drug-remifentanyl { background: #fefce8; border-color: #fde047; color: #854d0e; }
.drug-btn.drug-remifentanyl:hover { background: #fef9c3; border-color: #facc15; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(202, 138, 4, 0.15); }
.drug-btn.drug-remifentanyl.selected { background: #fef08a; border: 4px solid #eab308; color: #713f12; font-weight: 700; transform: scale(1.02); box-shadow: 0 4px 12px rgba(234, 179, 8, 0.35); }

.drug-btn.drug-propofol { background: #ffffff; border-color: #d1d5db; color: #374151; }
.drug-btn.drug-propofol:hover { background: #f3f4f6; border-color: #9ca3af; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.drug-btn.drug-propofol.selected { background: #e5e7eb; border: 4px solid #6b7280; color: #1f2937; font-weight: 700; transform: scale(1.02); box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3); }

.drug-btn.drug-morfina { background: #fee2e2; border-color: #fca5a5; color: #991b1b; }
.drug-btn.drug-morfina:hover { background: #fecaca; border-color: #f87171; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(220, 38, 38, 0.15); }
.drug-btn.drug-morfina.selected { background: #fca5a5; border: 4px solid #ef4444; color: #7f1d1d; font-weight: 700; transform: scale(1.02); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35); }

.drug-btn.drug-metadona { background: #ffedd5; border-color: #fdba74; color: #9a3412; }
.drug-btn.drug-metadona:hover { background: #fed7aa; border-color: #fb923c; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(234, 88, 12, 0.15); }
.drug-btn.drug-metadona.selected { background: #fdba74; border: 4px solid #f97316; color: #7c2d12; font-weight: 700; transform: scale(1.02); box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35); }

.drug-btn.drug-midazolam { background: #e0f2fe; border-color: #7dd3fc; color: #075985; }
.drug-btn.drug-midazolam:hover { background: #bae6fd; border-color: #38bdf8; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(14, 165, 233, 0.15); }
.drug-btn.drug-midazolam.selected { background: #7dd3fc; border: 4px solid #0ea5e9; color: #0c4a6e; font-weight: 700; transform: scale(1.02); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35); }

.drug-btn.drug-ketamina { background: #dcfce7; border-color: #86efac; color: #166534; }
.drug-btn.drug-ketamina:hover { background: #bbf7d0; border-color: #4ade80; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(34, 197, 94, 0.15); }
.drug-btn.drug-ketamina.selected { background: #86efac; border: 4px solid #22c55e; color: #14532d; font-weight: 700; transform: scale(1.02); box-shadow: 0 4px 12px rgba(34, 197, 94, 0.35); }

/* Colores para botones de presentación según el fármaco */
.pres-btn.pres-fentanyl { background: #fdf2f8; border-color: #f9c4dd; color: #9d174d; }
.pres-btn.pres-fentanyl:hover, .pres-btn.pres-fentanyl.selected { background: #fce7f3; border-color: #f9a8d4; }

.pres-btn.pres-remifentanyl { background: #fefce8; border-color: #fde047; color: #854d0e; }
.pres-btn.pres-remifentanyl:hover, .pres-btn.pres-remifentanyl.selected { background: #fef9c3; border-color: #facc15; }

.pres-btn.pres-propofol { background: #ffffff; border-color: #d1d5db; color: #374151; }
.pres-btn.pres-propofol:hover, .pres-btn.pres-propofol.selected { background: #f3f4f6; border-color: #9ca3af; }

.pres-btn.pres-morfina { background: #fee2e2; border-color: #fca5a5; color: #991b1b; }
.pres-btn.pres-morfina:hover, .pres-btn.pres-morfina.selected { background: #fecaca; border-color: #f87171; }

.pres-btn.pres-metadona { background: #ffedd5; border-color: #fdba74; color: #9a3412; }
.pres-btn.pres-metadona:hover, .pres-btn.pres-metadona.selected { background: #fed7aa; border-color: #fb923c; }

.pres-btn.pres-midazolam { background: #e0f2fe; border-color: #7dd3fc; color: #075985; }
.pres-btn.pres-midazolam:hover, .pres-btn.pres-midazolam.selected { background: #bae6fd; border-color: #38bdf8; }

.pres-btn.pres-ketamina { background: #dcfce7; border-color: #86efac; color: #166534; }
.pres-btn.pres-ketamina:hover, .pres-btn.pres-ketamina.selected { background: #bbf7d0; border-color: #4ade80; }
.drug-pres-inline {
    animation: slideDown .2s ease;
    padding-bottom: 1rem;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
 
/* Presentations */
.pres-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .6rem;
    margin-top: .8rem;
}
.pres-btn {
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 10px;
    padding: .6rem .4rem;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
    text-align: center;
    color: #334155;
}
.pres-btn:hover, .pres-btn.selected {
    border-color: #0891b2;
    background: #ecfeff;
    color: #0891b2;
}
 
/* Multiplier */
.mult-row {
    display: flex;
    gap: .5rem;
    margin-top: .9rem;
    align-items: center;
}
.mult-label {
    font-size: .82rem;
    color: #64748b;
    white-space: nowrap;
}
.mult-btn {
    flex: 1;
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 10px;
    padding: .55rem 0;
    font-size: .9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all .15s;
    color: #475569;
}
.mult-btn:hover, .mult-btn.selected {
    border-color: #7c3aed;
    background: #f5f3ff;
    color: #7c3aed;
}
 
/* Tabs */
.rf-tabs {
    display: flex;
    gap: .3rem;
    margin-bottom: 1rem;
    background: #f1f5f9;
    padding: .25rem;
    border-radius: 10px;
}
.rf-tab {
    flex: 1;
    padding: .6rem .5rem;
    border: none;
    background: transparent;
    border-radius: 8px;
    font-size: .9rem;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all .15s;
}
.rf-tab.active {
    background: #fff;
    color: var(--app-primary, #1d4ed8);
    box-shadow: 0 1px 3px rgba(0,0,0,.1);
}
body.theme-dark .rf-tabs {
    background: #1e293b;
}
body.theme-dark .rf-tab.active {
    background: #334155;
    color: #93c5fd;
}

/* Sobrante / calc */
.rf-input-row {
    display: flex;
    align-items: center;
    gap: .6rem;
    margin-top: .2rem;
}
.rf-input-row input[type=number] {
    flex: 1;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: .65rem .9rem;
    font-size: 1.05rem;
    outline: none;
    transition: border-color .15s;
    background: #f8fafc;
}
.rf-input-row input[type=number]:focus {
    border-color: var(--app-primary, #1d4ed8);
    background: #fff;
}
.rf-input-unit {
    font-size: .9rem;
    font-weight: 700;
    color: #64748b;
    min-width: 2.5rem;
}
.rf-calc-row {
    margin-top: .9rem;
    background: #f1f5f9;
    border-radius: 10px;
    padding: .75rem 1rem;
    font-size: .95rem;
}
.rf-calc-row .rf-calc-label { color: #64748b; font-size: .82rem; }
.rf-calc-value {
    font-size: 1.35rem;
    font-weight: 800;
    color: #1d4ed8;
}
 
/* Responsable */
.rf-responsable-box {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: .9rem 1rem;
    display: flex;
    align-items: center;
    gap: .8rem;
}
.rf-resp-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: var(--app-primary, #1d4ed8);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.rf-resp-name { font-weight: 700; font-size: 1.1rem; }
.rf-resp-sub  { font-size: .95rem; color: #64748b; }
 
/* Drug summary chips */
.drug-summary-list {
    display: flex;
    flex-direction: column;
    gap: .4rem;
    margin-bottom: .8rem;
}
.drug-chip {
    background: #eff6ff;
    border: 1.5px solid #bfdbfe;
    border-radius: 10px;
    padding: .55rem .85rem;
    font-size: .88rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .5rem;
    box-sizing: border-box;
}
.drug-chip .chip-name { font-weight: 700; color: #1e40af; font-size: 1rem; }
.drug-chip .chip-detail { color: #475569; font-size: .9rem; }
.drug-chip .chip-admin { font-weight: 700; color: #059669; font-size: 1rem; }

/* Chips de colores por fármaco en el resumen (Step 4) */
.drug-chip.drug-chip-fentanyl { background: #fdf2f8; border-color: #f9c4dd; }
.drug-chip.drug-chip-fentanyl .chip-name { color: #9d174d; }

.drug-chip.drug-chip-remifentanyl { background: #fefce8; border-color: #fde047; }
.drug-chip.drug-chip-remifentanyl .chip-name { color: #854d0e; }

.drug-chip.drug-chip-propofol { background: #ffffff; border-color: #d1d5db; }
.drug-chip.drug-chip-propofol .chip-name { color: #374151; }

.drug-chip.drug-chip-morfina { background: #fee2e2; border-color: #fca5a5; }
.drug-chip.drug-chip-morfina .chip-name { color: #991b1b; }

.drug-chip.drug-chip-metadona { background: #ffedd5; border-color: #fdba74; }
.drug-chip.drug-chip-metadona .chip-name { color: #9a3412; }

.drug-chip.drug-chip-midazolam { background: #e0f2fe; border-color: #7dd3fc; }
.drug-chip.drug-chip-midazolam .chip-name { color: #075985; }

.drug-chip.drug-chip-ketamina { background: #dcfce7; border-color: #86efac; }
.drug-chip.drug-chip-ketamina .chip-name { color: #166534; }
 
/* Nav buttons */
.rf-btn-primary {
    width: 100%;
    background: var(--app-primary, #1d4ed8);
    color: #fff;
    border: none;
    border-radius: 14px;
    padding: 1rem;
    font-size: 1.15rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: .8rem;
    transition: opacity .15s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
}
.rf-btn-primary:disabled { opacity: .45; cursor: not-allowed; }
.rf-btn-secondary {
    width: 100%;
    background: #f1f5f9;
    color: #334155;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    padding: .8rem;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    margin-top: .5rem;
    transition: all .15s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
}
.rf-btn-danger {
    background: #fef2f2;
    color: #dc2626;
    border: 2px solid #fecaca;
}
 
/* Progress dots */
.rf-progress {
    display: flex;
    justify-content: center;
    gap: .45rem;
    margin-bottom: 1.2rem;
}
.rf-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #e2e8f0;
    transition: all .2s;
}
.rf-dot.done { background: #22c55e; }
.rf-dot.active { background: var(--app-primary, #1d4ed8); width: 20px; border-radius: 4px; }
 
/* Print preview */
.print-area {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
    font-size: .85rem;
    overflow-x: auto; /* Permitir scroll horizontal si la tabla es muy ancha */
    max-width: 100%;
    box-sizing: border-box;
}
.print-area h4 { font-size: .95rem; font-weight: 700; margin-bottom: .5rem; }
.print-table {
    width: 100%;
    min-width: 600px; /* Ancho mínimo para asegurar legibilidad */
    border-collapse: collapse;
    margin-top: .5rem;
    font-size: .7rem; /* Reducir tamaño de fuente para que quepa mejor */
}
.print-table th, .print-table td {
    border: 1px solid #94a3b8;
    padding: .3rem .25rem; /* Reducir padding */
    text-align: center;
    white-space: nowrap; /* Evitar que el texto se rompa */
}
.print-table th {
    background: #f1f5f9;
    font-weight: 600;
    font-size: .65rem;
}
.print-table td {
    height: 2rem;
    vertical-align: middle;
}
.print-table .empty-row td {
    border: 1px solid #94a3b8;
    height: 2.8rem;
}
@media print {
    .print-table { font-size: 9pt; }
    .print-table th { font-size: 8pt; }
    .print-table td { height: 35px; }
    .print-table .empty-row td { height: 50px; }
}
 
/* Dark mode */
body.theme-dark .rf-card { background: #172033; }
body.theme-dark .drug-btn, body.theme-dark .pres-btn, body.theme-dark .mult-btn { background: #1e293b; border-color: #334155; color: #cbd5e1; }
body.theme-dark .drug-btn.selected { background: #1e3a8a; border-color: #60a5fa; color: #93c5fd; }
body.theme-dark .drug-btn-sub { color: #94a3b8; }
body.theme-dark .pres-btn.selected { background: #164e63; border-color: #22d3ee; color: #67e8f9; }
body.theme-dark .mult-btn.selected { background: #2e1065; border-color: #a78bfa; color: #c4b5fd; }
body.theme-dark .rf-input-row input[type=number] { background: #1e293b; border-color: #334155; color: #f1f5f9; }
body.theme-dark .rf-calc-row { background: #1e293b; }
body.theme-dark .rf-responsable-box { background: #1e293b; border-color: #334155; }
body.theme-dark .drug-chip { background: #1e3a8a; border-color: #3b82f6; }

/* Dark mode para chips de colores por fármaco */
body.theme-dark .drug-chip.drug-chip-fentanyl { background: #500724; border-color: #9d174d; }
body.theme-dark .drug-chip.drug-chip-fentanyl .chip-name { color: #fbcfe8; }

body.theme-dark .drug-chip.drug-chip-remifentanyl { background: #422006; border-color: #a16207; }
body.theme-dark .drug-chip.drug-chip-remifentanyl .chip-name { color: #fde047; }

body.theme-dark .drug-chip.drug-chip-propofol { background: #1f2937; border-color: #6b7280; }
body.theme-dark .drug-chip.drug-chip-propofol .chip-name { color: #e5e7eb; }

body.theme-dark .drug-chip.drug-chip-morfina { background: #450a0a; border-color: #dc2626; }
body.theme-dark .drug-chip.drug-chip-morfina .chip-name { color: #fca5a5; }

body.theme-dark .drug-chip.drug-chip-metadona { background: #431407; border-color: #ea580c; }
body.theme-dark .drug-chip.drug-chip-metadona .chip-name { color: #fdba74; }

body.theme-dark .drug-chip.drug-chip-midazolam { background: #0c4a6e; border-color: #0ea5e9; }
body.theme-dark .drug-chip.drug-chip-midazolam .chip-name { color: #7dd3fc; }

body.theme-dark .drug-chip.drug-chip-ketamina { background: #064e3b; border-color: #10b981; }
body.theme-dark .drug-chip.drug-chip-ketamina .chip-name { color: #6ee7b7; }

body.theme-dark .rf-btn-secondary { background: #1e293b; border-color: #334155; color: #cbd5e1; }
body.theme-dark .print-area { background: #172033; border-color: #334155; }
body.theme-dark .print-table th { background: #1e293b; color: #cbd5e1; }
body.theme-dark .print-table td { color: #e2e8f0; }

/* CC Input styles */
.cc-input-wrap {
    margin: 1.2rem 0;
}
.cc-input-label {
    font-size: 1rem;
    color: #64748b;
    margin-bottom: .6rem;
    display: block;
}
.cc-input {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem .5rem;
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    letter-spacing: .15em;
    outline: none;
    transition: border-color .15s;
    background: #f8fafc;
}
.cc-input:focus {
    border-color: var(--app-primary, #1d4ed8);
    background: #fff;
}
body.theme-dark .cc-input {
    background: #1e293b;
    border-color: #334155;
    color: #f1f5f9;
}

@media print {
    @page {
        size: landscape;
        margin: 20mm 10mm 10mm 15mm; /* top right bottom left - más espacio arriba y a la izquierda para perforar */
    }
    .rf-step { display: none !important; }
    #step-print { display: block !important; }
    .rf-btn-primary, .rf-btn-secondary, .rf-progress, .rf-step-title { display: none !important; }
    .rf-card {
        background: white !important;
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .print-area {
        border: none !important;
        padding: 0 !important;
        background: white !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        width: 100% !important;
        overflow-x: visible !important; /* Eliminar scroll horizontal en impresión */
        max-width: none !important;
    }
    .print-area h4 {
        font-size: 14pt !important;
        font-weight: bold !important;
        margin-bottom: 15px !important;
        border-bottom: 2px solid #000 !important;
        padding-bottom: 8px !important;
    }
    .print-table {
        width: 100% !important;
        min-width: 0 !important; /* Eliminar ancho mínimo para impresión */
        border-collapse: collapse !important;
        font-size: 10pt !important;
        background: white !important;
    }
    .print-table th,
    .print-table td {
        border: 1px solid #000 !important;
        padding: 8px 6px !important;
        text-align: left !important;
        background: white !important;
        color: #000 !important;
        white-space: normal !important; /* Permitir que el texto se ajuste */
    }
    .print-table th {
        font-weight: bold !important;
        background: white !important;
        font-size: 9pt !important;
    }
    .print-table tr {
        background: white !important;
    }
    .empty-row td {
        height: 55px !important;
    }
    /* Aumentar ancho de columnas de firma en impresión */
    .print-table th:nth-child(9),
    .print-table th:nth-child(11),
    .print-table td:nth-child(9),
    .print-table td:nth-child(11) {
        min-width: 100px !important;
        width: 100px !important;
    }
    body, body.theme-dark, body.theme-light {
        background: white !important;
        color: #000 !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    #app-main-content, .app-main-content, .rf-wrap {
        background: white !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
}
</style>
</head>
<body class="theme-light">

<div class="rf-wrap">
 
    <!-- Progress -->
    <div class="rf-progress" id="rf-progress">
        <div class="rf-dot active" id="dot-0"></div>
        <div class="rf-dot" id="dot-1"></div>
        <div class="rf-dot" id="dot-2"></div>
        <div class="rf-dot" id="dot-3"></div>
    </div>
 
    <!-- STEP 0: Ingresar cuenta corriente -->
    <div class="rf-step active" id="step-0">
        <div class="rf-card">
            <div class="rf-step-title">
                <span class="rf-step-badge">1</span> Cuenta corriente
            </div>
            <div class="rf-meta">
                <span><i class="fa-solid fa-calendar-day me-1"></i><?= $fecha_hora ?></span>
            </div>
            <div class="cc-input-wrap">
                <label class="cc-input-label">Ingresa los 6 dígitos de la cuenta corriente</label>
                <input type="text" id="cc-input" class="cc-input" maxlength="6" inputmode="numeric" placeholder="000000" autocomplete="off">
            </div>
            <div id="cc-error" style="color:#dc2626;font-size:.85rem;text-align:center;margin-top:.5rem;display:none;">Debe ingresar 6 dígitos</div>
            <button class="rf-btn-primary" id="btn-step0-next" onclick="validateCC()">
                <i class="fa-solid fa-arrow-right"></i> Continuar
            </button>
        </div>
    </div>
 
    <!-- STEP 1: Selección de fármaco -->
    <div class="rf-step" id="step-1">
        <div class="rf-card">
            <div class="rf-step-title">
                <span class="rf-step-badge">2</span> Fármaco
            </div>
            <div class="drug-grid" id="drug-grid">
                <?php
                $farmacosArray = array_keys($farmacos);
                for ($i = 0; $i < count($farmacosArray); $i += 2):
                    $key1 = $farmacosArray[$i];
                    $f1 = $farmacos[$key1];
                    $presKeys1 = array_keys($f1['presentaciones']);
                    $singlePres1 = count($presKeys1) === 1 ? $presKeys1[0] : null;
                    $hasMultiple1 = count($presKeys1) > 1;

                    $key2 = $farmacosArray[$i + 1] ?? null;
                    $f2 = $key2 ? $farmacos[$key2] : null;
                    $presKeys2 = $key2 ? array_keys($f2['presentaciones']) : [];
                    $singlePres2 = $key2 && count($presKeys2) === 1 ? $presKeys2[0] : null;
                    $hasMultiple2 = $key2 && count($presKeys2) > 1;
                ?>
                <div class="drug-item" id="drug-item-<?= $key1 ?>">
                    <div class="drug-item-row">
                        <button class="drug-btn drug-<?= $key1 ?>" onclick="selectDrug('<?= $key1 ?>')" id="drug-<?= $key1 ?>">
                            <?= $f1['label'] ?>
                            <?php if ($singlePres1): ?>
                            <span class="drug-btn-sub"><?= $singlePres1 ?></span>
                            <?php endif; ?>
                        </button>
                        <?php if ($f2): ?>
                        <button class="drug-btn drug-<?= $key2 ?>" onclick="selectDrug('<?= $key2 ?>')" id="drug-<?= $key2 ?>">
                            <?= $f2['label'] ?>
                            <?php if ($singlePres2): ?>
                            <span class="drug-btn-sub"><?= $singlePres2 ?></span>
                            <?php endif; ?>
                        </button>
                        <?php endif; ?>
                    </div>
                    <!-- Presentaciones inline para fármacos con múltiples presentaciones -->
                    <?php if ($hasMultiple1): ?>
                    <div class="drug-pres-inline" id="pres-inline-<?= $key1 ?>" style="display:none;">
                        <div style="font-size:.85rem;font-weight:600;color:#64748b;margin-bottom:.3rem;">Presentación <?= $f1['label'] ?></div>
                        <div class="pres-grid" id="pres-grid-<?= $key1 ?>"></div>
                    </div>
                    <?php endif; ?>
                    <?php if ($hasMultiple2): ?>
                    <div class="drug-pres-inline" id="pres-inline-<?= $key2 ?>" style="display:none;">
                        <div style="font-size:.85rem;font-weight:600;color:#64748b;margin-bottom:.3rem;">Presentación <?= $f2['label'] ?></div>
                        <div class="pres-grid" id="pres-grid-<?= $key2 ?>"></div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Multiplicador -->
            <div id="mult-section" style="display:none;">
                <div class="mult-row">
                    <span class="mult-label">Cantidad:</span>
                    <button class="mult-btn selected" id="mult-1" onclick="selectMult(1)">×1</button>
                    <button class="mult-btn" id="mult-2" onclick="selectMult(2)">×2</button>
                    <button class="mult-btn" id="mult-3" onclick="selectMult(3)">×3</button>
                    <button class="mult-btn" id="mult-4" onclick="selectMult(4)">×4</button>
                </div>
            </div>
 
            <button class="rf-btn-primary" id="btn-step1-next" disabled onclick="goStep(2)">
                <i class="fa-solid fa-arrow-right"></i> Continuar
            </button>
            <button class="rf-btn-secondary" onclick="goStep(0)">
                <i class="fa-solid fa-arrow-left"></i> Atrás
            </button>
        </div>
    </div>
 
    <!-- STEP 2: Sobrante y Administrado -->
    <div class="rf-step" id="step-2">
        <div class="rf-card">
            <div class="rf-step-title">
                <span class="rf-step-badge">3</span> Cantidad
            </div>
            <div id="step2-drug-summary" style="font-size:.88rem;color:#475569;margin-bottom:.9rem;"></div>

            <!-- Tabs -->
            <div class="rf-tabs">
                <button class="rf-tab active" id="tab-sobrante" onclick="switchTab('sobrante')">Sobrante</button>
                <button class="rf-tab" id="tab-administrado" onclick="switchTab('administrado')">Administrado</button>
            </div>

            <!-- Tab: Sobrante -->
            <div id="panel-sobrante">
                <div class="rf-input-row">
                    <input type="number" id="input-sobrante" min="0" step="any" placeholder="0" oninput="calcFromSobrante()">
                    <span class="rf-input-unit" id="unit-sobrante">mg</span>
                </div>
                <div id="error-sobrante" style="display:none;color:#dc2626;font-size:.85rem;margin-top:.3rem;font-weight:600;">
                    <i class="fa-solid fa-triangle-exclamation"></i> El sobrante no puede ser mayor que el total
                </div>
                <div class="rf-calc-row">
                    <div class="rf-calc-label">Administrado</div>
                    <div class="rf-calc-value"><span id="val-administrado">–</span> <span id="unit-administrado" style="font-size:.95rem;font-weight:600;color:#64748b;"></span></div>
                </div>
            </div>

            <!-- Tab: Administrado -->
            <div id="panel-administrado" style="display:none;">
                <div class="rf-input-row">
                    <input type="number" id="input-administrado" min="0" step="any" placeholder="0" oninput="calcFromAdministrado()">
                    <span class="rf-input-unit" id="unit-administrado-input">mg</span>
                </div>
                <div id="error-administrado" style="display:none;color:#dc2626;font-size:.85rem;margin-top:.3rem;font-weight:600;">
                    <i class="fa-solid fa-triangle-exclamation"></i> El administrado no puede ser mayor que el total
                </div>
                <div class="rf-calc-row">
                    <div class="rf-calc-label">Sobrante</div>
                    <div class="rf-calc-value"><span id="val-sobrante">–</span> <span id="unit-sobrante-calc" style="font-size:.95rem;font-weight:600;color:#64748b;"></span></div>
                </div>
            </div>

            <button class="rf-btn-primary" id="btn-step2-next" onclick="goStep(3)">
                <i class="fa-solid fa-arrow-right"></i> Continuar
            </button>
            <button class="rf-btn-secondary" onclick="goStep(1)">
                <i class="fa-solid fa-arrow-left"></i> Atrás
            </button>
        </div>
    </div>
 
    <!-- STEP 3: Resumen + Agregar o Imprimir -->
    <div class="rf-step" id="step-3">
        <div class="rf-card">
            <div class="rf-step-title">
                <span class="rf-step-badge">4</span> Resumen y firma
            </div>
 
            <!-- Resumen del paciente -->
            <div style="font-size:1rem;color:#64748b;margin-bottom:.8rem;">
                <span><i class="fa-solid fa-calendar-day me-1"></i><?= $fecha_hora ?></span>
                &nbsp;|&nbsp;
                <span><i class="fa-solid fa-barcode me-1"></i>C.C. <strong id="summary-cc"></strong></span>
            </div>
 
            <!-- Lista de fármacos acumulados -->
            <div id="drug-summary-list" class="drug-summary-list"></div>
 
            <!-- Fármaco actual (pendiente de confirmar) -->
            <div id="current-drug-preview" class="drug-chip" style="display:none; margin-top: .4rem;">
                <div>
                    <div class="chip-name" id="preview-name" style="font-size:1.05rem;"></div>
                    <div class="chip-detail" id="preview-detail" style="font-size:.95rem;"></div>
                </div>
                <div class="chip-admin" id="preview-admin" style="font-size:1.05rem;"></div>
            </div>
 
            <!-- Responsable -->
            <div class="rf-responsable-box" style="margin:.9rem 0;">
                <div class="rf-resp-avatar"><i class="fa-solid fa-user-doctor"></i></div>
                <div>
                    <div class="rf-resp-name"><?= $nombre_usuario ?></div>
                    <div class="rf-resp-sub">Responsable del registro</div>
                </div>
            </div>
 
            <button class="rf-btn-secondary" onclick="addAnotherDrug()">
                <i class="fa-solid fa-plus"></i> Agregar otro fármaco
            </button>
            <button class="rf-btn-primary" onclick="printRecord()">
                <i class="fa-solid fa-print"></i> Imprimir
            </button>
            <button class="rf-btn-secondary" onclick="goStep(2)" style="margin-top:.5rem;">
                <i class="fa-solid fa-arrow-left"></i> Atrás
            </button>
            <button class="rf-btn-secondary rf-btn-danger" style="margin-top:.5rem;" data-bs-toggle="modal" data-bs-target="#cancelModal">
                <i class="fa-solid fa-trash"></i> Cancelar registro
            </button>
        </div>
    </div>

    <!-- Modal de confirmación para cancelar registro -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Confirmar cancelación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea cancelar el registro?</p>
                    <p class="text-danger"><strong>Se perderán todos los datos ingresados.</strong></p>
                    <div class="alert alert-info mt-3">
                        <i class="fa-solid fa-user me-2"></i>
                        <strong>Responsable:</strong> <?= $nombre_usuario ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver al registro</button>
                    <button type="button" class="btn btn-danger" onclick="nuevoRegistro()" data-bs-dismiss="modal">
                        <i class="fa-solid fa-trash me-1"></i>Sí, cancelar registro
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP PRINT (pantalla de impresión) -->
    <div class="rf-step" id="step-print">
        <div class="rf-card">
            <div class="rf-step-title">
                <span class="rf-step-badge"><i class="fa-solid fa-check"></i></span> Registro enviado a imprimir
            </div>
            <div id="print-area" class="print-area">
                <h4>REGISTRO DE FÁRMACOS - ANESTESIA CAV</h4>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cuenta C.C.</th>
                            <th>Fármaco</th>
                            <th>Presentación</th>
                            <th>Dosis Admin.</th>
                            <th>Dosis Elim.</th>
                            <th>Eliminador</th>
                            <th style="min-width: 100px;">Firma</th>
                            <th>Testigo</th>
                            <th style="min-width: 100px;">Firma Testigo</th>
                        </tr>
                    </thead>
                    <tbody id="print-tbody">
                        <!-- 3 empty rows minimum for signature space -->
                        <tr class="empty-row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr class="empty-row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr class="empty-row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>
            </div>
            <button class="rf-btn-secondary" onclick="nuevoRegistro()" style="margin-top:1rem;">
                <i class="fa-solid fa-plus"></i> Nuevo registro
            </button>
        </div>
    </div>
 
</div><!-- rf-wrap -->
</div><!-- app-main-content -->
 
<!-- Hidden form for accumulated drugs (no DB) -->
<form id="drugs-form" method="post" style="display:none;">
    <input type="hidden" name="drugs_json" id="drugs-json-field">
    <input type="hidden" name="cuenta_corriente" id="cc-field">
    <input type="hidden" name="fecha_hora" value="<?= $fecha_hora ?>">
    <input type="hidden" name="responsable" value="<?= $nombre_usuario ?>">
</form>

<!-- Bootstrap 5.3 JS Bundle (incluye Popper) desde CDN jsDelivr -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
 
<script>
/**
 * ════════════════════════════════════════════════════════════════════════════
 * JAVASCRIPT - WIZARD DE REGISTRO DE FÁRMACOS
 * ════════════════════════════════════════════════════════════════════════════
 * 
 * Este script gestiona toda la lógica del wizard: estado de la aplicación,
 * navegación entre pasos, cálculos de dosis y generación de la tabla para imprimir.
 * 
 * Estructura del estado (state):
 * - cc: Cuenta corriente del paciente (6 dígitos)
 * - selectedDrug: Key del fármaco seleccionado
 * - selectedPres: Nombre de la presentación seleccionada
 * - presValue: Valor numérico de la presentación (mg/ug)
 * - mult: Multiplicador (cantidad de ampolletas)
 * - sobrante: Cantidad sobrante calculada
 * - administrado: Cantidad administrada calculada
 * - unidad: Unidad de medida (mg, ug)
 * - drugs: Array de fármacos acumulados para el registro
 * ════════════════════════════════════════════════════════════════════════════
 */

// Datos de fármacos inyectados desde PHP
const FARMACOS_JS = <?= json_encode($farmacos) ?>;

/**
 * Estado global del wizard.
 * Se reinicia completamente al llamar nuevoRegistro().
 */
let state = {
    cc: '',
    selectedDrug: null,
    selectedPres: null,
    presValue: 0,      // Valor numérico en mg o ug por ampolla
    mult: 1,
    sobrante: 0,
    administrado: 0,
    unidad: '',
    drugs: []          // Array de fármacos acumulados
};

/**
 * ════════════════════════════════════════════════════════════════════════════
 * PASO 0: VALIDACIÓN DE CUENTA CORRIENTE
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Valida el formato de la cuenta corriente ingresada.
 * Debe contener exactamente 6 dígitos numéricos.
 * Si es válida, avanza al paso 1. Si no, muestra mensaje de error.
 */
function validateCC() {
    const input = document.getElementById('cc-input');
    const val = input.value.replace(/\D/g, ''); // Eliminar cualquier caracter no numérico
    
    if (val.length === 6) {
        // Cuenta válida: guardar en estado y avanzar
        state.cc = val;
        document.getElementById('cc-field').value = val;
        document.getElementById('cc-error').style.display = 'none';
        goStep(1);
    } else {
        // Cuenta inválida: mostrar error y mantener foco
        document.getElementById('cc-error').style.display = 'block';
        input.focus();
    }
}

/**
 * ════════════════════════════════════════════════════════════════════════════
 * PASO 1: SELECCIÓN DE FÁRMACO Y PRESENTACIÓN
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Actualiza los indicadores visuales de progreso (dots) según el paso actual.
 * 
 * @param {number} step - Paso actual (0 a 3)
 */
function updateDots(step) {
    const total = 4;
    for (let i = 0; i < total; i++) {
        const d = document.getElementById('dot-' + i);
        if (!d) continue;
        // Aplicar clase según estado: completado, activo o pendiente
        d.className = 'rf-dot' + (i < step ? ' done' : i === step ? ' active' : '');
    }
}

/**
 * Selecciona un fármaco del listado.
 * Configura el estado, destaca el botón seleccionado y gestiona las presentaciones.
 * Para fármacos con una sola presentación, la selecciona automáticamente.
 * Para fármacos con múltiples presentaciones, muestra los botones correspondientes.
 * 
 * @param {string} key - Identificador del fármaco (ej: 'fentanyl', 'propofol')
 */
function selectDrug(key) {
    // Actualizar estado con el fármaco seleccionado
    state.selectedDrug = key;
    state.selectedPres = null;
    state.presValue = 0;
    state.mult = 1;
    state.unidad = FARMACOS_JS[key].unidad;

    // Resaltar visualmente el botón seleccionado
    document.querySelectorAll('.drug-btn').forEach(b => b.classList.remove('selected'));
    document.getElementById('drug-' + key).classList.add('selected');

    // Ocultar todas las secciones de presentación inline
    document.querySelectorAll('.drug-pres-inline').forEach(el => el.style.display = 'none');

    // Construir botones de presentación según las disponibles
    const pres = FARMACOS_JS[key].presentaciones;
    const keys = Object.keys(pres);

    if (keys.length === 1) {
        // Caso 1: Solo hay una presentación → seleccionar automáticamente
        state.selectedPres = keys[0];
        state.presValue = pres[keys[0]];
    } else {
        // Caso 2: Múltiples presentaciones → mostrar opciones inline
        const inlineSection = document.getElementById('pres-inline-' + key);
        if (inlineSection) {
            const presGrid = document.getElementById('pres-grid-' + key);
            presGrid.innerHTML = '';
            keys.forEach((k, idx) => {
                const btn = document.createElement('button');
                btn.className = 'pres-btn pres-' + key;  // Agregar clase de color del fármaco
                btn.textContent = k;
                btn.onclick = () => selectPres(key, k, pres[k]);
                btn.id = 'pres-' + key + '-' + k.replace(/[^a-z0-9]/gi, '_');
                presGrid.appendChild(btn);
                // Pre-seleccionar la primera presentación por defecto
                if (idx === 0) {
                    state.selectedPres = k;
                    state.presValue = pres[k];
                    btn.classList.add('selected');
                }
            });
            inlineSection.style.display = '';
            validateStep1();
        }
    }

    // Reiniciar multiplicador a 1 y mostrar sección de cantidad
    selectMult(1);
    document.getElementById('mult-section').style.display = '';
    validateStep1();
}

/**
 * Selecciona una presentación específica de un fármaco.
 * Actualiza el estado y marca visualmente el botón seleccionado.
 * 
 * @param {string} drugKey - Identificador del fármaco (ej: 'fentanyl')
 * @param {string} presKey - Nombre de la presentación (ej: '0,1mg/2ml')
 * @param {number} value - Valor numérico de la presentación en unidades base
 */
function selectPres(drugKey, presKey, value) {
    state.selectedPres = presKey;
    state.presValue    = value;
    
    // Desmarcar todos los botones de presentación en la misma grilla
    const presGrid = document.getElementById('pres-grid-' + drugKey);
    if (presGrid) {
        presGrid.querySelectorAll('.pres-btn').forEach(b => b.classList.remove('selected'));
    }
    
    // Marcar el botón seleccionado (reemplazar caracteres especiales en el ID)
    const id = 'pres-' + drugKey + '-' + presKey.replace(/[^a-z0-9]/gi, '_');
    const el = document.getElementById(id);
    if (el) el.classList.add('selected');
    
    // Validar si se puede continuar al siguiente paso
    validateStep1();
}

/**
 * Selecciona el multiplicador (cantidad de ampolletas/frascos).
 * Actualiza el estado y marca visualmente el botón seleccionado.
 * 
 * @param {number} n - Multiplicador (1, 2, 3 o 4)
 */
function selectMult(n) {
    state.mult = n;
    document.querySelectorAll('.mult-btn').forEach(b => b.classList.remove('selected'));
    document.getElementById('mult-' + n).classList.add('selected');
}

/**
 * Valida si se ha completado la selección en el paso 1.
 * Requiere: fármaco seleccionado Y presentación seleccionada.
 * Habilita o deshabilita el botón "Continuar" según corresponda.
 */
function validateStep1() {
    const ok = state.selectedDrug && (state.selectedPres !== null);
    document.getElementById('btn-step1-next').disabled = !ok;
}
 
/**
 * ════════════════════════════════════════════════════════════════════════════
 * NAVEGACIÓN ENTRE PASOS
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Navega al paso especificado del wizard.
 * Oculta todos los pasos, muestra el paso objetivo, actualiza indicadores y
 * ejecuta inicializaciones específicas según el paso.
 * 
 * @param {number} n - Número de paso destino (0=Cuenta, 1=Fármaco, 2=Cantidad, 3=Resumen, 4=Imprimir)
 */
function goStep(n) {
    // Ocultar todos los pasos y mostrar solo el destino
    document.querySelectorAll('.rf-step').forEach(el => el.classList.remove('active'));
    const target = document.getElementById('step-' + n);
    if (target) {
        target.classList.add('active');
        updateDots(n < 4 ? n : 3);  // Actualizar indicadores de progreso
        window.scrollTo({ top: 0, behavior: 'smooth' });  // Scroll al inicio
    }
    
    // Inicializar pasos específicos según corresponda
    if (n === 2) initStep2();      // Paso 2: Configurar pestañas de cantidad
    if (n === 3) buildSummary();   // Paso 3: Construir resumen del registro
}
 
/**
 * ════════════════════════════════════════════════════════════════════════════
 * PASO 2: CÁLCULO DE SOBRANTE / ADMINISTRADO
 * ════════════════════════════════════════════════════════════════════════════
 * 
 * Este paso permite calcular las dosis de dos formas:
 * - Pestaña "Sobrante": Ingresar lo sobrante → calcula lo administrado
 * - Pestaña "Administrado": Ingresar lo administrado → calcula lo sobrante
 * 
 * Fórmula: Total = Presentación × Multiplicador
 *          Administrado = Total - Sobrante
 *          Sobrante = Total - Administrado
 * ════════════════════════════════════════════════════════════════════════════
 */

// Pestaña activa por defecto ('sobrante' o 'administrado')
let activeTab = 'sobrante';

/**
 * Inicializa el paso 2 con los datos del fármaco seleccionado.
 * Configura las etiquetas de unidad, muestra el resumen del fármaco
 * y activa la pestaña de sobrante por defecto.
 */
function initStep2() {
    const drug  = FARMACOS_JS[state.selectedDrug];
    const total = state.presValue * state.mult;

    // Actualizar todas las etiquetas de unidad (mg, ug, etc.)
    document.getElementById('unit-sobrante').textContent = state.unidad;
    document.getElementById('unit-administrado').textContent = state.unidad;
    document.getElementById('unit-administrado-input').textContent = state.unidad;
    document.getElementById('unit-sobrante-calc').textContent = state.unidad;

    // Mostrar resumen del fármaco seleccionado
    document.getElementById('step2-drug-summary').innerHTML =
        `<strong>${drug.label}</strong> ${state.selectedPres} × ${state.mult} = <strong>${total} ${state.unidad}</strong>`;

    // Limpiar inputs, errores y volver a pestaña sobrante por defecto
    document.getElementById('input-sobrante').value = '';
    document.getElementById('input-administrado').value = '';
    document.getElementById('error-sobrante').style.display = 'none';
    document.getElementById('error-administrado').style.display = 'none';
    document.getElementById('input-sobrante').style.borderColor = '';
    document.getElementById('input-administrado').style.borderColor = '';
    
    // Asegurar que el botón Continuar esté habilitado al entrar al paso
    const btnNext = document.getElementById('btn-step2-next');
    btnNext.disabled = false;
    btnNext.style.opacity = '1';
    
    switchTab('sobrante');

    // Auto-focus en el input después de un breve delay para asegurar que el DOM está listo
    setTimeout(() => {
        const input = document.getElementById('input-sobrante');
        if (input) input.focus();
    }, 100);
}

/**
 * Cambia entre las pestañas "Sobrante" y "Administrado".
 * Actualiza la interfaz visual y recalcula los valores según corresponda.
 * 
 * @param {string} tab - Pestaña a activar ('sobrante' o 'administrado')
 */
function switchTab(tab) {
    activeTab = tab;
    
    // Actualizar clases visuales de las pestañas
    document.querySelectorAll('.rf-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');

    // Mostrar/ocultar paneles correspondientes
    document.getElementById('panel-sobrante').style.display = tab === 'sobrante' ? '' : 'none';
    document.getElementById('panel-administrado').style.display = tab === 'administrado' ? '' : 'none';

    // Recalcular según la pestaña activa
    if (tab === 'sobrante') {
        calcFromSobrante();
    } else {
        calcFromAdministrado();
    }

    // Auto-focus en el input activo
    setTimeout(() => {
        const inputId = tab === 'sobrante' ? 'input-sobrante' : 'input-administrado';
        const input = document.getElementById(inputId);
        if (input) input.focus();
    }, 50);
}

/**
 * Calcula la dosis administrada a partir del sobrante ingresado.
 * Fórmula: Administrado = (Presentación × Multiplicador) - Sobrante
 * El resultado nunca es negativo (mínimo 0).
 * 
 * Validación: El sobrante no puede exceder el total disponible.
 */
function calcFromSobrante() {
    const total = state.presValue * state.mult;
    const sob = parseFloat(document.getElementById('input-sobrante').value) || 0;
    const errorEl = document.getElementById('error-sobrante');
    const inputEl = document.getElementById('input-sobrante');
    const btnNext = document.getElementById('btn-step2-next');
    
    // Validar que no exceda el total
    if (sob > total) {
        errorEl.style.display = 'block';
        inputEl.style.borderColor = '#dc2626';
        // Deshabilitar botón Continuar mientras exista error
        btnNext.disabled = true;
        btnNext.style.opacity = '0.5';
        // Limitar el valor al máximo permitido
        state.sobrante = total;
        state.administrado = 0;
        document.getElementById('val-administrado').textContent = '0';
        return;
    }
    
    // Ocultar error y habilitar botón si la validación pasa
    errorEl.style.display = 'none';
    inputEl.style.borderColor = '';
    btnNext.disabled = false;
    btnNext.style.opacity = '1';
    
    state.sobrante = sob;
    state.administrado = Math.max(0, total - sob);
    // Mostrar sin decimales innecesarios (ej: 100.00 → 100)
    document.getElementById('val-administrado').textContent = state.administrado.toFixed(2).replace(/\.?0+$/, '');
}

/**
 * Calcula el sobrante a partir de la dosis administrada ingresada.
 * Fórmula: Sobrante = (Presentación × Multiplicador) - Administrado
 * El resultado nunca es negativo (mínimo 0).
 * 
 * Validación: El administrado no puede exceder el total disponible.
 */
function calcFromAdministrado() {
    const total = state.presValue * state.mult;
    const adm = parseFloat(document.getElementById('input-administrado').value) || 0;
    const errorEl = document.getElementById('error-administrado');
    const inputEl = document.getElementById('input-administrado');
    const btnNext = document.getElementById('btn-step2-next');
    
    // Validar que no exceda el total
    if (adm > total) {
        errorEl.style.display = 'block';
        inputEl.style.borderColor = '#dc2626';
        // Deshabilitar botón Continuar mientras exista error
        btnNext.disabled = true;
        btnNext.style.opacity = '0.5';
        // Limitar el valor al máximo permitido
        state.administrado = total;
        state.sobrante = 0;
        document.getElementById('val-sobrante').textContent = '0';
        return;
    }
    
    // Ocultar error y habilitar botón si la validación pasa
    errorEl.style.display = 'none';
    inputEl.style.borderColor = '';
    btnNext.disabled = false;
    btnNext.style.opacity = '1';
    
    state.administrado = adm;
    state.sobrante = Math.max(0, total - adm);
    // Mostrar sin decimales innecesarios
    document.getElementById('val-sobrante').textContent = state.sobrante.toFixed(2).replace(/\.?0+$/, '');
}

/**
 * ════════════════════════════════════════════════════════════════════════════
 * PASO 3: RESUMEN Y CONFIRMACIÓN
 * ════════════════════════════════════════════════════════════════════════════
 * 
 * Muestra un resumen de todos los fármacos registrados para el paciente.
 * Permite agregar más fármacos o proceder a la impresión.
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Construye y muestra el resumen del registro actual.
 * Muestra el fármaco actual (si existe) y la lista de fármacos acumulados.
 */
function buildSummary() {
    // Show current drug preview with color
    if (state.selectedDrug) {
        const drug  = FARMACOS_JS[state.selectedDrug];
        const total = state.presValue * state.mult;
        const previewEl = document.getElementById('current-drug-preview');
        previewEl.style.display = '';
        // Aplicar clase de color según el fármaco
        previewEl.className = `drug-chip drug-chip-${state.selectedDrug}`;
        document.getElementById('preview-name').textContent   = drug.label;
        document.getElementById('preview-detail').textContent = `${state.selectedPres} × ${state.mult} | Sobrante: ${state.sobrante} ${state.unidad}`;
        document.getElementById('preview-admin').textContent  = `Adm: ${state.administrado} ${state.unidad}`;
    }
 
    // Accumulated drugs with colors
    document.getElementById('summary-cc').textContent = state.cc;
    const listEl = document.getElementById('drug-summary-list');
    listEl.innerHTML = '';
    state.drugs.forEach((d, i) => {
        const chip = document.createElement('div');
        // Aplicar clase de color según el key del fármaco
        chip.className = `drug-chip drug-chip-${d.key}`;
        chip.innerHTML = `
            <div>
                <div class="chip-name">${d.label}</div>
                <div class="chip-detail">${d.presentacion} × ${d.mult} | Sobrante: ${d.sobrante} ${d.unidad}</div>
            </div>
            <div class="chip-admin">Adm: ${d.administrado} ${d.unidad}</div>`;
        listEl.appendChild(chip);
    });
}
 
/**
 * Guarda el fármaco actual en la lista y vuelve al paso 1 para agregar otro.
 * Limpia el estado del fármaco actual pero mantiene la cuenta corriente y los fármacos acumulados.
 */
function addAnotherDrug() {
    // Guardar fármaco actual en el array de acumulados
    if (state.selectedDrug) {
        const drug = FARMACOS_JS[state.selectedDrug];
        state.drugs.push({
            key:          state.selectedDrug,  // Guardar key para aplicar colores
            label:        drug.label,
            presentacion: state.selectedPres,
            mult:         state.mult,
            sobrante:     state.sobrante,
            administrado: state.administrado,
            unidad:       state.unidad,
            presValue:    state.presValue
        });
    }
    
    // Reiniciar solo el estado del fármaco (no la CC ni los fármacos acumulados)
    state.selectedDrug = null;
    state.selectedPres = null;
    state.presValue    = 0;
    state.mult         = 1;
    state.sobrante     = 0;
    state.administrado = 0;
 
    // Limpiar la interfaz de selección de fármacos
    document.querySelectorAll('.drug-btn').forEach(b => b.classList.remove('selected'));
    document.querySelectorAll('.pres-btn').forEach(b => b.classList.remove('selected'));
    document.querySelectorAll('.drug-pres-inline').forEach(el => el.style.display = 'none');
    document.getElementById('mult-section').style.display = 'none';
    document.getElementById('btn-step1-next').disabled = true;
    selectMult(1);
 
    // Volver al paso 1 para seleccionar otro fármaco
    goStep(1);
}
 
/**
 * ════════════════════════════════════════════════════════════════════════════
 * PASO 4: GENERACIÓN DE TABLA PARA IMPRESIÓN
 * ════════════════════════════════════════════════════════════════════════════
 * 
 * Genera la tabla HTML con los datos del registro y abre el diálogo de impresión.
 * La tabla incluye mínimo 3 filas para dejar espacio de firmas, aunque haya menos fármacos.
 * 
 * NOTA: Usa AirPrint (window.print()) que permite al usuario seleccionar la impresora
 * de su red local (Kyocera MA5500ifx) desde el diálogo nativo de iOS.
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Genera la tabla de registro con todos los fármacos y abre el diálogo de impresión.
 * Guarda el fármaco actual (si existe) antes de generar la tabla.
 */
function printRecord() {
    // Guardar el fármaco actual antes de imprimir (si existe uno en edición)
    if (state.selectedDrug) {
        const drug = FARMACOS_JS[state.selectedDrug];
        state.drugs.push({
            key:          state.selectedDrug,  // Guardar key para aplicar colores
            label:        drug.label,
            presentacion: state.selectedPres,
            mult:         state.mult,
            sobrante:     state.sobrante,
            administrado: state.administrado,
            unidad:       state.unidad,
            presValue:    state.presValue
        });
        state.selectedDrug = null; // Evitar duplicar si se vuelve a imprimir
    }

    // Variables inyectadas desde PHP para la impresión
    const eliminador = '<?= $nombre_usuario ?>';
    const fecha = '<?= $fecha ?>';
    const hora = '<?= $hora ?>';

    // Generar filas de la tabla con los datos de cada fármaco
    const tbody = document.getElementById('print-tbody');
    tbody.innerHTML = '';

    state.drugs.forEach(d => {
        tbody.innerHTML += `<tr>
            <td>${fecha}</td>
            <td>${hora}</td>
            <td>${state.cc}</td>
            <td>${d.label}</td>
            <td>${d.presentacion}</td>
            <td>${d.administrado} ${d.unidad}</td>
            <td>${d.sobrante} ${d.unidad}</td>
            <td>${eliminador}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>`;
    });

    // Garantizar mínimo 3 filas vacías para espacio de firmas
    const minRows = 3;
    const currentRows = state.drugs.length;
    for (let i = currentRows; i < minRows; i++) {
        tbody.innerHTML += `<tr class="empty-row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>`;
    }
 
    // Store as JSON in hidden field
    document.getElementById('drugs-json-field').value = JSON.stringify({
        cc: state.cc,
        fecha: '<?= $fecha_hora ?>',
        responsable: '<?= $nombre_usuario ?>',
        drugs: state.drugs
    });
 
    // Show print step
    document.querySelectorAll('.rf-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step-print').classList.add('active');
    document.querySelector('.rf-progress').style.display = 'none';
 
    // Send to printer (network print via iframe)
    sendToPrinter();
}
 
/**
 * Abre el diálogo nativo de impresión del navegador (AirPrint).
 * 
 * IMPORTANTE: Esta función utiliza window.print() que en iOS abre el selector
 * de AirPrint. El usuario debe seleccionar manualmente la impresora Kyocera
 * MA5500ifx desde el diálogo. La impresora debe estar en la misma red WiFi.
 * 
 * La página se imprime en formato horizontal (landscape) con la tabla
 * generada en printRecord(). Ver CSS @media print para configuración.
 */
function sendToPrinter() {
    window.print();
}

/**
 * ════════════════════════════════════════════════════════════════════════════
 * FUNCIONES DE UTILIDAD
 * ════════════════════════════════════════════════════════════════════════════
 */

/**
 * Reinicia todo el estado del wizard para comenzar un nuevo registro.
 * Limpia todos los campos, el estado interno y vuelve al paso inicial.
 */
function nuevoRegistro() {
    // Reiniciar el objeto de estado a sus valores por defecto
    state = {
        cc: '',             // Cuenta corriente vacía
        selectedDrug: null, // Ningún fármaco seleccionado
        selectedPres: null, // Ninguna presentación seleccionada
        presValue: 0,       // Valor numérico de la presentación
        mult: 1,            // Multiplicador por defecto: 1
        sobrante: 0,        // Cantidad sobrante
        administrado: 0,    // Cantidad administrada
        unidad: '',         // Unidad de medida (mg, ug, etc.)
        drugs: []           // Array de fármacos acumulados
    };
    
    // Mostrar nuevamente la barra de progreso
    document.querySelector('.rf-progress').style.display = '';
    
    // Limpiar campos de entrada del paso 1 (Cuenta Corriente)
    document.getElementById('cc-input').value = '';
    document.getElementById('cc-field').value = '';
    document.getElementById('cc-error').style.display = 'none';

    // Volver al paso inicial (0 = Cuenta Corriente)
    goStep(0);
}

/**
 * Muestra un diálogo de confirmación antes de cancelar el registro actual.
 * Si el usuario confirma, se reinicia el wizard.
 */
function confirmReset() {
    if (confirm('¿Cancelar el registro? Se perderán los datos.')) {
        nuevoRegistro();
    }
}
 
/**
 * ════════════════════════════════════════════════════════════════════════════
 * INICIALIZACIÓN DEL WIZARD
 * ════════════════════════════════════════════════════════════════════════════
 * 
 * Se ejecuta cuando el DOM está completamente cargado.
 * Configura valores iniciales y handlers de eventos.
 * ════════════════════════════════════════════════════════════════════════════
 */

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Establecer multiplicador por defecto (1)
    selectMult(1);
    
    // Poner foco automático en el input de cuenta corriente al cargar
    document.getElementById('cc-input').focus();
});

// Configurar handlers para el input de cuenta corriente
document.addEventListener('DOMContentLoaded', function() {
    const ccInput = document.getElementById('cc-input');
    if (ccInput) {
        // Permitir enviar con tecla Enter
        ccInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                validateCC();
            }
        });
        
        // Solo permitir dígitos numéricos (eliminar cualquier otro caracter)
        ccInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
    }
});
</script>