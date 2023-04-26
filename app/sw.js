self.addEventListener("install", (event) => {
  event.waitUntil(
    caches
      .open("screen")
      .then((cache) =>
        cache.addAll([    
          "style.css",
          "images/logo192.png",
          "css/all.css",
          "css/bootstrap.min.css",
          "js/bootstrap.bundle.min.js",
          "js/jquery-3.6.1.min.js",
          "images/IMG0001.jpeg",
          "images/austral.png",
          "index.php",
          "apuntes.php",
          "acerca_de.php",          
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


