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
            'a[href*="vista_visitas"]',
            'a[href*="reuniones"]',
            'a[href*="uachcl-my.sharepoint.com"]',
            'a[href*="admin"]',
            'a[href*="lista_usuarios"]',
            'a[href*="usuarios_activos"]',
            'a[href*="crear_usuario"]'
        ];

        // Form IDs for admin tools
        const adminFormIds = [
            'gest_users',
            'gest_pacientes',
            'gest_bitacora',
            'admin_notas',
            'admin_notificaciones',
            'admin_calendarios',
            'admin_exportar_bitacoras'
        ];

        dbDependentSelectors.forEach(selector => {
            document.querySelectorAll(selector).forEach(link => {
                // Skip tel: links (phone calls work offline)
                if (link.href && link.href.startsWith('tel:')) {
                    return;
                }
                // Skip admin-back-btn links (back buttons in notes)
                if (link.classList.contains('admin-back-btn')) {
                    return;
                }
                link.classList.add('offline-disabled');
                link.style.pointerEvents = 'none';
                link.style.opacity = '0.5';
                link.style.filter = 'grayscale(100%)';
            });
        });

        // Disable admin forms
        adminFormIds.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                const link = form.querySelector('a');
                if (link) {
                    link.classList.add('offline-disabled');
                    link.style.pointerEvents = 'none';
                    link.style.opacity = '0.5';
                    link.style.filter = 'grayscale(100%)';
                }
            }
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

    // Debug: Exponer funciones globales para debug del cache
    window.debugCache = {
        // Verificar qué URLs están cacheadas
        checkCache: async function() {
            if (!('serviceWorker' in navigator)) {
                console.log('Service Worker no soportado');
                return;
            }
            
            const registration = await navigator.serviceWorker.ready;
            if (!registration.active) {
                console.log('Service Worker no está activo');
                return;
            }
            
            // Enviar mensaje al SW para obtener estado del cache
            const messageChannel = new MessageChannel();
            messageChannel.port1.onmessage = (event) => {
                if (event.data && event.data.type === 'CACHE_STATUS') {
                    console.log('=== URLs Cacheadas ===');
                    console.log('Total:', event.data.total);
                    event.data.cachedUrls.forEach((url, i) => {
                        console.log(`${i + 1}. ${url}`);
                    });
                    
                    // Verificar específicamente las páginas de apuntes
                    const apuntesUrls = event.data.cachedUrls.filter(url => url.includes('/apuntes/'));
                    console.log('\n=== Apuntes Cacheados ===');
                    console.log('Total apuntes:', apuntesUrls.length);
                    apuntesUrls.forEach((url, i) => console.log(`${i + 1}. ${url}`));
                }
            };
            
            registration.active.postMessage({ type: 'GET_CACHE_STATUS' }, [messageChannel.port2]);
        },
        
        // Verificar estado del SW
        swStatus: async function() {
            if (!('serviceWorker' in navigator)) {
                console.log('Service Worker no soportado');
                return;
            }
            
            const registration = await navigator.serviceWorker.ready;
            console.log('=== Service Worker Status ===');
            console.log('Scope:', registration.scope);
            console.log('Active:', registration.active ? 'Sí' : 'No');
            console.log('Waiting:', registration.waiting ? 'Sí' : 'No');
            console.log('Installing:', registration.installing ? 'Sí' : 'No');
            
            // Verificar control de páginas
            const controlled = navigator.serviceWorker.controller !== null;
            console.log('Controlando esta página:', controlled);
        },
        
        // Forzar recarga del SW
        forceUpdate: async function() {
            if (!('serviceWorker' in navigator)) {
                console.log('Service Worker no soportado');
                return;
            }
            
            const registration = await navigator.serviceWorker.ready;
            await registration.update();
            console.log('Service Worker update solicitado');
            
            if (registration.waiting) {
                console.log('Nuevo SW esperando, activando...');
                registration.waiting.postMessage({ type: 'SKIP_WAITING' });
            }
        }
    };
    
    console.log('Debug cache disponible. Usa: debugCache.checkCache(), debugCache.swStatus(), debugCache.forceUpdate()');
})();
