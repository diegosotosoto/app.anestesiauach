const CACHE_NAME = "app-static-v6";

const STATIC_ASSETS = [
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
  "/js/bootstrap.bundle.min.js",
  "/js/jquery-3.6.1.min.js",
  "/js/app-core.js",
  "/images/logo192.png",
  "/images/IMG0001.jpeg",
  "/images/austral.png",
  "/bitacora_ingreso.php"
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS))
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
  const isSemiStatic = pathname.match(/(apuntes|links|telefonos|correos|calendario|vista_epa)\.php$/i);

  if (isStatic) {
    // Cache-first: servir del cache, actualizar en background
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
          .catch(() => cachedResponse);

        return cachedResponse || networkFetch;
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
        .catch(() => caches.match(event.request))
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
          .catch(() => cachedResponse);

        return cachedResponse || networkFetch;
      })
    );
    return;
  }

  // Default: network-first con fallback al cache
  event.respondWith(
    fetch(event.request).catch(() => caches.match(event.request))
  );
});
