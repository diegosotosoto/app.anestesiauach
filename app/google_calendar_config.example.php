<?php
/**
 * Configuración de Google Calendar API
 * Copiar este archivo a: secure_config/google_calendar_config.php
 * 
 * Requisitos:
 * 1. Crear proyecto en Google Cloud Console: https://console.cloud.google.com
 * 2. Habilitar Google Calendar API
 * 3. Crear cuenta de servicio y descargar credenciales JSON
 * 4. Compartir calendarios con el email de la cuenta de servicio
 */

// Ruta al archivo JSON de credenciales de cuenta de servicio
// Ejemplo: '/ruta/absoluta/a/credenciales-servicio.json'
define('APP_GOOGLE_CALENDAR_CREDENTIALS', '/ruta/a/credenciales.json');

// Email de la cuenta de servicio (opcional, para referencia)
define('APP_GOOGLE_SERVICE_ACCOUNT', 'tu-servicio@tu-proyecto.iam.gserviceaccount.com');
