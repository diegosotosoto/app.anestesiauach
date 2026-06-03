const CACHE_NAME = "app-static-v19";

const STATIC_ASSETS = [
  "/",
  "/style.css",
  "/css/all.css",
  "/css/bootstrap.min.css",
  "/css/overlay.css",
  "/css/app-core.css",
  "/css/app-layout.css",
  "/css/app-components.css",
  "/css/admin-system.css",
  "/css/app-head.css",
  "/css/app-footer.css",
  "/css/accessibility.css",
  "/css/module-calculos-apuntes.css",
  "/css/module-pacientes-dolor.css",
  "/css/module-bitacora.css",
  "/css/module-calendarios-notificaciones.css",
  "/css/module-epa.css",
  "/css/module-otros.css",
  "/css/bitacora-rapido.css",
  "/css/clinical-note-system.css",
  "/js/bootstrap.bundle.min.js",
  "/js/jquery-3.6.1.min.js",
  "/js/app-core.js",
  "/js/offline-handler.js",
  "/js/push-notifications.js",
  "/js/index.js",
  "/images/icon-192.png",
  "/images/IMG0001.jpeg",
  "/images/austral.png",
  "/index.php",
  "/acerca_de.php",
  "/links.php",
  "/apuntes.php",
  "/telefonos.php",
  "/correos.php",
  "/apuntes/asa.php",
  "/apuntes/apfel_ponv.php",
  "/apuntes/aldrete.php",
  "/apuntes/caprini.php",
  "/apuntes/cormack.php",
  "/apuntes/dasi.php",
  "/apuntes/deltapp.php",
  "/apuntes/dilucion_farmacos.php",
  "/apuntes/dosis_obeso.php",
  "/apuntes/ecg_monitorizacion_isquemia.php",
  "/apuntes/emergencia_ped.php",
  "/apuntes/epidural.php",
  "/apuntes/escalares.php",
  "/apuntes/flacc.php",
  "/apuntes/glasgow.php",
  "/apuntes/mallampati.php",
  "/apuntes/perdida_admisible.php",
  "/apuntes/peri_ped.php",
  "/apuntes/regional_ped.php",
  "/apuntes/score_lee.php",
  "/apuntes/tdl_algoritmo.php",
  "/apuntes/us_gastrico.php",
  "/apuntes/premedicacion_ped.php",
  "/apuntes/stop_bang.php",
  "/apuntes/clinical_frailty_scale.php",
  "/apuntes/dermatomas.php",
  "/apuntes/img_apuntes/osteotomas_inferior.jpeg",
  "/apuntes/img_apuntes/osteotomas_superior.jpeg",
  "/apuntes/img_apuntes/dermatomas_dorsal.jpeg",
  "/apuntes/img_apuntes/dermatomas_frontal.jpeg",
  "/apuntes/img_apuntes/us_gastrico.jpeg",
  "/apuntes/img_apuntes/4.jpg",
  "/apuntes/img_apuntes/3.jpg",
  "/apuntes/img_apuntes/2b.jpg",
  "/apuntes/img_apuntes/2a.jpg",
  "/apuntes/img_apuntes/1.jpg",
  "/apuntes/img_apuntes/IMG_5528.jpg",
  "/apuntes/img_apuntes/IMG_5527.jpg",
  "/apuntes/img_apuntes/TABLE_5.jpeg",
  "/apuntes/img_apuntes/IMG_0036.png",
  "/apuntes/img_apuntes/NUMERO.png",
  "/apuntes/img_apuntes/Coronary.jpeg",
  "/apuntes/img_apuntes/estomago_vacio.jpg",
  "/apuntes/img_apuntes/liquido_claro.jpg",
  "/apuntes/img_apuntes/solido_fluido.jpg",
  "/apuntes/img_apuntes/solido_reciente.jpg",
  "/apuntes/img_apuntes/malampatti-scale.png",
  "/apuntes/img_apuntes/no_change_in_rate.jpeg",
  "/apuntes/img_apuntes/plexo_cervical.jpeg"
];

self.addEventListener("install", (event) => {
  console.log('[SW] Installing, cache name:', CACHE_NAME);
  event.waitUntil(
    caches.open(CACHE_NAME).then(async (cache) => {
      console.log('[SW] Precaching', STATIC_ASSETS.length, 'assets...');
      
      // Cachear uno por uno para tolerar fallos individuales
      let successCount = 0;
      let failCount = 0;
      const failedUrls = [];
      
      for (const url of STATIC_ASSETS) {
        try {
          const response = await fetch(url, { credentials: 'same-origin' });
          if (response.ok) {
            await cache.put(url, response);
            successCount++;
          } else {
            console.warn('[SW] Failed to cache (status', response.status, '):', url);
            failCount++;
            failedUrls.push(url);
          }
        } catch (err) {
          console.warn('[SW] Failed to cache (error):', url, err.message);
          failCount++;
          failedUrls.push(url);
        }
      }
      
      console.log('[SW] Precaching complete. Success:', successCount, 'Failed:', failCount);
      if (failedUrls.length > 0) {
        console.log('[SW] Failed URLs:', failedUrls);
      }
    })
  );
  self.skipWaiting();
});

self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) =>
      Promise.all(
        cacheNames
          .filter((cacheName) => cacheName !== CACHE_NAME)
          .map((cacheName) => caches.delete(cacheName))
      )
    )
  );
  self.clients.claim();
});

self.addEventListener("fetch", (event) => {
  if (event.request.method !== "GET") {
    return;
  }

  const requestUrl = new URL(event.request.url);
  const pathname = requestUrl.pathname;

  // Cache-first para recursos estáticos (CSS, JS, imágenes)
  const isStatic = pathname.match(/\.(css|js|png|jpg|jpeg|gif|svg|webp|woff|woff2)$/i);

  // Network-first para datos críticos (bitácoras, pacientes)
  const isCriticalData = pathname.match(/(bitacora_ingreso|bitacora_estadistica|bitacora_rechazos|bitacora_autoriza|pacientes)\.php$/i);

  // Stale-while-revalidate para contenido semi-estático (apuntes, cálculos)
  const isSemiStatic = pathname.match(/(apuntes|links|telefonos|correos|calendario|vista_epa)\.php$/i) || pathname.match(/^\/apuntes\/.*\.php$/i);

  if (isStatic) {
    // Network-first con timeout: intentar red primero, fallback a cache si falla o es lento
    // Esto garantiza que siempre se vean las actualizaciones cuando hay conexión
    const networkFetch = fetch(event.request)
      .then((networkResponse) => {
        if (networkResponse && networkResponse.ok) {
          // Actualizar cache con versión fresca
          const responseClone = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(event.request, responseClone));
          console.log('[SW] Static asset from network:', pathname);
        }
        return networkResponse;
      });

    // Timeout de 3 segundos - si la red es lenta, usar cache
    const timeoutPromise = new Promise((resolve) => {
      setTimeout(() => {
        caches.match(event.request).then(cached => {
          if (cached) {
            console.log('[SW] Static asset from cache (timeout):', pathname);
            resolve(cached);
          }
        });
      }, 3000);
    });

    event.respondWith(
      Promise.race([networkFetch, timeoutPromise])
        .catch(() => {
          // Sin conexión: usar cache
          console.log('[SW] Static asset fallback to cache:', pathname);
          return caches.match(event.request).then(cached => {
            if (cached) return cached;
            return new Response('Error: Sin conexion y sin cache.', { status: 503 });
          });
        })
    );
    return;
  }

  if (isCriticalData) {
    // Network-first: siempre frescos, fallback al cache
    event.respondWith(
      fetch(event.request)
        .then((networkResponse) => {
          if (networkResponse && networkResponse.ok) {
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(event.request, responseClone));
          }
          return networkResponse;
        })
        .catch(() => {
          console.log('[SW] Critical data fallback to cache:', pathname);
          return caches.match(event.request).then(cached => {
            if (!cached) {
              return new Response('Error: Sin conexion y sin cache disponible.', { status: 503 });
            }
            return cached;
          });
        })
    );
    return;
  }

  if (isSemiStatic) {
    // Stale-while-revalidate: servir cache inmediato, actualizar en background
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        const networkFetch = fetch(event.request)
          .then((networkResponse) => {
            if (networkResponse && networkResponse.ok) {
              const responseClone = networkResponse.clone();
              caches.open(CACHE_NAME).then((cache) => cache.put(event.request, responseClone));
            }
            return networkResponse;
          })
          .catch((err) => {
            console.error('[SW] Network fetch failed for:', pathname, err);
            return cachedResponse;
          });

        // Si tenemos respuesta cacheada, servirla inmediatamente
        if (cachedResponse) {
          console.log('[SW] Serving from cache:', pathname);
          // Actualizar en background (no esperar)
          networkFetch.catch(err => console.log('[SW] Background update failed:', pathname));
          return cachedResponse;
        }
        
        // Si no hay cache, esperar el network
        console.log('[SW] No cache, fetching from network:', pathname);
        return networkFetch.then(response => {
          if (!response) {
            console.error('[SW] Network returned null for:', pathname);
            // Retornar una respuesta de error en lugar de null
            return new Response('Error cargando pagina. Verifica tu conexion.', {
              status: 503,
              statusText: 'Service Unavailable',
              headers: { 'Content-Type': 'text/plain' }
            });
          }
          return response;
        });
      })
    );
    return;
  }

  // Default: network-first con fallback al cache
  event.respondWith(
    fetch(event.request)
      .then(response => {
        if (!response) {
          console.error('[SW] Network returned null for:', pathname);
          return caches.match(event.request).then(cached => {
            if (cached) return cached;
            return new Response('Error de red. Sin cache disponible.', { status: 503 });
          });
        }
        return response;
      })
      .catch(() => {
        return caches.match(event.request).then(cached => {
          if (cached) {
            console.log('[SW] Default fallback to cache:', pathname);
            return cached;
          }
          console.error('[SW] No cache for:', pathname);
          return new Response('Sin conexion y sin cache disponible.', { status: 503 });
        });
      })
  );
});

self.addEventListener("push", (event) => {
  let data = {};
  if (event.data) {
    try {
      data = event.data.json();
    } catch (err) {
      data = { title: "Anestesia UACH", body: event.data.text() };
    }
  }

  const title = (data.title || "Anestesia UACH").trim();
  const body  = (data.body || data.message || "Tienes una nueva notificación.").trim();

  const options = {
    body: body,
    icon: "/images/icon-192.png",
    badge: "/images/icon-192.png",
    data: {
      url: data.url || "/",
      notificacion_id: data.notificacion_id || null
    },
    tag: data.tag || "app-anestesia-uach",
    renotify: Boolean(data.renotify),
    requireInteraction: Boolean(data.requireInteraction)
  };

  event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener("notificationclick", (event) => {
  event.notification.close();
  const targetUrl = event.notification.data && event.notification.data.url ? event.notification.data.url : "/";

  event.waitUntil(
    clients.matchAll({ type: "window", includeUncontrolled: true }).then((clientList) => {
      const absoluteUrl = new URL(targetUrl, self.location.origin).href;
      for (const client of clientList) {
        if (client.url === absoluteUrl && "focus" in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(targetUrl);
      }
      return null;
    })
  );
});

// Debug: Escuchar mensajes para listar cache
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'GET_CACHE_STATUS') {
    caches.open(CACHE_NAME).then(cache => {
      cache.keys().then(requests => {
        const urls = requests.map(r => r.url);
        console.log('[SW] Cached URLs:', urls);
        // Responder al cliente
        event.source.postMessage({
          type: 'CACHE_STATUS',
          cachedUrls: urls,
          total: urls.length
        });
      });
    });
  }
  
  if (event.data && event.data.type === 'SKIP_WAITING') {
    console.log('[SW] Skip waiting received');
    self.skipWaiting();
  }
});
