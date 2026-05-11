// Offline connection handler with toast notifications

(function() {
    // Create toast element
    function createToast() {
        const toast = document.createElement('div');
        toast.id = 'connection-toast';
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: opacity 0.3s ease;
        `;
        document.body.appendChild(toast);
        return toast;
    }

    // Update toast appearance and message
    function updateToast(toast, isOnline) {
        if (isOnline) {
            toast.style.backgroundColor = '#28a745';
            toast.innerHTML = '<i class="fa-solid fa-wifi"></i> Conexión restaurada';
        } else {
            toast.style.backgroundColor = '#dc3545';
            toast.innerHTML = '<i class="fa-solid fa-wifi-slash"></i> Sin conexión a internet';
        }
        toast.style.display = 'flex';
    }

    // Hide toast
    function hideToast(toast) {
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.style.display = 'none';
            toast.style.opacity = '1';
        }, 300);
    }

    // Disable DB-dependent links
    function disableDBDependentLinks() {
        // Links that depend on database
        const dbDependentSelectors = [
            'a[href*="bitacora"]',
            'a[href*="hoja_dolor"]',
            'a[href*="pacientes"]',
            'a[href*="telefonos"]',
            'a[href*="correos"]',
            'a[href*="vista_epa"]',
            'a[href*="calendario"]',
            'a[href*="nuevo_paciente"]',
            'a[href*="editar_paciente"]',
            'a[href*="lista_bitacoras"]',
            'a[href*="bitacora_rechazos"]',
            'a[href*="bitacora_revision"]',
            'a[href*="bitacora_estadistica"]',
            'a[href*="bitacora_internos"]',
            'a[href*="bitacora_resumen"]',
            'a[href*="bitacora_autoriza"]',
            'a[href*="valida_pag"]',
            'a[href*="configuracion_ui"]',
            'a[href*="admin_calendarios"]',
            'a[href*="vista_visitas"]'
        ];

        dbDependentSelectors.forEach(selector => {
            document.querySelectorAll(selector).forEach(link => {
                link.classList.add('offline-disabled');
                link.style.pointerEvents = 'none';
                link.style.opacity = '0.5';
                link.style.filter = 'grayscale(100%)';
            });
        });

        // Add CSS for disabled state
        if (!document.getElementById('offline-styles')) {
            const style = document.createElement('style');
            style.id = 'offline-styles';
            style.textContent = `
                .offline-disabled {
                    cursor: not-allowed !important;
                    text-decoration: none !important;
                }
                .offline-disabled:hover {
                    opacity: 0.5 !important;
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Enable DB-dependent links
    function enableDBDependentLinks() {
        const disabledLinks = document.querySelectorAll('.offline-disabled');
        disabledLinks.forEach(link => {
            link.classList.remove('offline-disabled');
            link.style.pointerEvents = '';
            link.style.opacity = '';
            link.style.filter = '';
        });
    }

    // Handle connection change
    function handleConnectionChange(toast, isOnline, wasOffline) {
        // Only show toast if there was a state change
        if (isOnline && wasOffline) {
            updateToast(toast, true);
            enableDBDependentLinks();
            setTimeout(() => hideToast(toast), 3000);
        } else if (!isOnline) {
            updateToast(toast, false);
            disableDBDependentLinks();
        }
    }

    // Initialize
    function init() {
        const toast = createToast();
        let isOnline = navigator.onLine;
        let wasOffline = sessionStorage.getItem('wasOffline') === 'true';

        // Only apply initial state without showing toast
        if (!isOnline) {
            handleConnectionChange(toast, false, false);
            sessionStorage.setItem('wasOffline', 'true');
        } else {
            // If online and was offline, show restoration toast
            if (wasOffline) {
                handleConnectionChange(toast, true, true);
                sessionStorage.setItem('wasOffline', 'false');
            } else {
                // Just enable links, don't show toast
                enableDBDependentLinks();
            }
        }

        // Listen for connection changes
        window.addEventListener('online', () => {
            isOnline = true;
            sessionStorage.setItem('wasOffline', 'false');
            handleConnectionChange(toast, true, true);
        });

        window.addEventListener('offline', () => {
            isOnline = false;
            sessionStorage.setItem('wasOffline', 'true');
            handleConnectionChange(toast, false, false);
        });
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
