# Cron Job - Limpieza de Sesiones de Autenticación

## Propósito
Eliminar sesiones expiradas y revocadas de la tabla `app_auth_sessions` para mantener la base de datos limpia.

## Base de datos
- **Local (XAMPP):** `anestes1_hoja_dolor`
- **Producción:** (tu base de datos en producción)

---

## Servidor de Producción (cPanel)

### Configuración
- **Frecuencia:** Todos los días a las 6:00 AM
- **Comando:**
```bash
/usr/bin/mysql -u TU_USUARIO_BD -p"TU_CLAVE_BD" NOMBRE_BD -e "DELETE FROM app_auth_sessions WHERE revoked_at IS NOT NULL OR expires_at < NOW();"
```

### Pasos en cPanel
1. Ingresar a cPanel
2. Buscar **"Cron Jobs"**
3. En "Common Settings" seleccionar: **"Once Per Day"** o ingresar manualmente: `0 6 * * *`
4. Pegar el comando (reemplazando credenciales)
5. Click **"Add New Cron Job"**

---

## Servidor Local (Mac + XAMPP)

### Configuración
- **Frecuencia:** Todos los días a las 6:00 AM
- **Comando:**
```bash
0 6 * * * /Applications/XAMPP/bin/mysql -u root -p"" -e "DELETE FROM anestes1_hoja_dolor.app_auth_sessions WHERE revoked_at IS NOT NULL OR expires_at < NOW();"
```

### Pasos en Terminal
1. Abrir **Terminal**
2. Ejecutar:
```bash
crontab -e
```
3. Agregar la línea del comando arriba
4. Guardar: `Ctrl+O`, `Enter`, `Ctrl+X`

### Verificar configuración
```bash
crontab -l
```

---

## SQL Equivalente (para ejecución manual)
```sql
DELETE FROM app_auth_sessions 
WHERE revoked_at IS NOT NULL 
   OR expires_at < NOW();
```

---

## Notas
- `revoked_at IS NOT NULL` = Sesiones cerradas por logout
- `expires_at < NOW()` = Sesiones que pasaron 30 días sin uso
- El cron job evita que la tabla crezca indefinidamente

## Fecha de creación
Mayo 2026 - Migración a sistema de tokens de autenticación
