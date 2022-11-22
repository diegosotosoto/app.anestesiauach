self.addEventListener("install", (event) => {
  event.waitUntil(
    caches
      .open("screen")
      .then((cache) =>
        cache.addAll([    
          "/images/logo192.png",
        ])
      )
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(async function() {
    try {
      return await fetch(event.request);
    } catch (err) {
      return caches.match(event.request);
    }
  }());
});
