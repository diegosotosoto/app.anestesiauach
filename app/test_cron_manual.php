<?php
/**
 * Test manual del cron de calendario
 * Ejecutar desde navegador para ver resultado
 */

echo "<html><head><title>Test Cron Calendario</title></head><body>";
echo "<h2>Test de Cron Notificaciones Calendario</h2>";
echo "<pre style='background:#f5f5f5;padding:15px;border:1px solid #ddd;'>";

// Capturar output del cron
ob_start();

// Incluir y ejecutar el cron
include 'cron_notificaciones_calendario.php';

$output = ob_get_clean();
echo htmlspecialchars($output);

echo "</pre>";
echo "<p><a href='javascript:location.reload()'>Recargar</a> | <a href='admin_calendarios.php'>Volver a Calendarios</a></p>";
echo "</body></html>";
