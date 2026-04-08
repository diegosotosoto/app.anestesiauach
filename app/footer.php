</div><!- DIV DEL ROW TOTAL -> 
</div><!- DIV DEL CONTAINER TOTAL ->

<footer class="bd-footer py-2 py-md-2 mt-0 bg-secondary text-start" style=' --bs-bg-opacity: 0.08;'>
  <div class="container py-2 py-md-5 px-4 px-md-3" style="font-size: min(max(14px, 1.5vw), 16px)">
    <div class="row">
    <div class="col-lg-3 mb-0">
        <a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="/" aria-label="Bootstrap" style="font-size: min(max(14px, 1.5vw), 18px)">
          <span class='fs-5' style='color:#22304a;'><img class='pe-2' src='images/austral_black.png' style='width: 48px; opacity:.72' />Anestesia <small class='ps-0 opacity-50'> UACH</small></span>
        </a>
        <hr class="ms-0 mt-1 mb-2 me-0">
        <ul class="list-unstyled small text-muted">
          <li class="mb-2" style="font-size: min(max(14px, 1.5vw), 16px)">Aplicación Web del Programa de Anestesiología y Reanimación de la Universidad Austral de Chile. Derechos Reservados</li>
          <li class="mb-2 mt-2 py-3 opacity-50">Diseñado por Diego Soto S. 2022-2026</li>
        </ul>
    </div>

    <div class="col-6 col-lg-2 offset-lg-1 mb-3">
      <h5>Este Sitio</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><a href="https://app.anestesiauach.cl/" target="_self"><i class="fa-solid fa-arrow-right pe-2"></i>Inicio</a></li>
        <li class="mb-2"><a href="https://app.anestesiauach.cl/acerca_de.php" target="_self"><i class="fa-solid fa-arrow-right pe-2"></i>Acerca de</a></li>
      </ul>
    </div>

    <div class="col-6 col-lg-2 mb-3">
      <h5>Contacto</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><a href="mailto:humberto.lopez@uach.cl"><i class="fa-solid fa-envelope pe-2"></i>Jefe Programa</a></li>
        <li class="mb-2"><a href="mailto:diegosotosoto@gmail.com"><i class="fa-solid fa-envelope pe-2"></i>Diseñador Web</a></li>
      </ul>
    </div>

    <div class="col-6 col-lg-2 mb-3">
      <h5>Enlaces</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><a href="http://medicina.uach.cl//" target="_blank"><i class="fa-solid fa-building-columns pe-2"></i>Medicina UACH</a></li>
        <li class="mb-2"><a href="http://medicina.uach.cl/postgrado/especialidades/anestesiologia-y-reanimacion/" target="_blank"><i class="fa-solid fa-syringe pe-2"></i>Anestesia</a></li>
        <li class="mb-2"><a href="https://linktr.ee/FAMEUACh/" target="_blank"><i class="fa-solid fa-link pe-2"></i>linktr.ee/FAMEUACh</a></li>   
        <li class="mb-2"><a href="https://pharmacopilot.glide.page/" target="_blank"><i class="fa-solid fa-link pe-2"></i>PharmaCopilot</a></li>           
      </ul>
    </div>

    <div class="col-6 col-lg-2 mb-3">
      <h5>Lugares</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><a href="https://goo.gl/maps/tzAEiwFYu1ZEKXs76" target="_blank"><i class="fa-solid fa-location-dot pe-2"></i>Hospital Base Valdivia</a></li>
        <li class="mb-2"><a href="https://goo.gl/maps/z3G5HPHcK16FEECQ7" target="_blank"><i class="fa-solid fa-location-dot pe-2"></i>Escuela de Graduados</a></li>
        <li class="mb-2"><a href="https://goo.gl/maps/gqv4p1zKeWt3G63Z8" target="_blank"><i class="fa-solid fa-location-dot pe-2"></i>Facultad de Medicina</a></li>        
      </ul>
    </div>

<hr>

</div><!- DIV DE LA COLUMNA DE COPIAR DATOS ->

</div><!- DIV DEL ROW ->  
</footer>

<!-- Overlay global de navegación -->
<div id="loading-overlay" aria-hidden="true">
  <div class="loading-card">
    <img src="images/logo192.png" alt="Cargando" class="loading-logo">
    <div class="loading-spinner"></div>
    <div class="loading-text">Cargando...</div>
  </div>
</div>

<style>
#loading-overlay{
  position:fixed;
  inset:0;
  display:none;
  align-items:center;
  justify-content:center;
  background:rgba(255,255,255,.62);
  backdrop-filter:blur(4px);
  -webkit-backdrop-filter:blur(4px);
  z-index:99999;
  touch-action:none;
}

.loading-card{
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  gap:.9rem;
  padding:1.35rem 1.4rem;
  min-width:150px;
  border-radius:1.2rem;
  background:rgba(255,255,255,.92);
  border:1px solid rgba(39,69,143,.10);
  box-shadow:0 14px 36px rgba(31,42,55,.16);
}

.loading-logo{
  width:72px;
  height:72px;
  object-fit:contain;
  display:block;
  user-select:none;
  pointer-events:none;
}

.loading-spinner{
  width:42px;
  height:42px;
  border:4px solid #dbe4f3;
  border-top-color:#3559b7;
  border-radius:50%;
  animation:loading-spin .8s linear infinite;
}

.loading-text{
  font-size:.95rem;
  font-weight:700;
  color:#27458f;
  letter-spacing:.02em;
}

@keyframes loading-spin{
  to{ transform:rotate(360deg); }
}
</style>

<script>
(function () {
  let isNavigating = false;
  let safetyTimer = null;

  const overlay = document.getElementById('loading-overlay');

  function showLoadingOverlay() {
    if (!overlay || isNavigating) return;

    isNavigating = true;
    overlay.style.display = 'flex';

    if (safetyTimer) clearTimeout(safetyTimer);
    safetyTimer = setTimeout(function () {
      hideLoadingOverlay();
    }, 12000);
  }

  function hideLoadingOverlay() {
    if (!overlay) return;

    overlay.style.display = 'none';
    isNavigating = false;

    if (safetyTimer) {
      clearTimeout(safetyTimer);
      safetyTimer = null;
    }
  }

  function shouldIgnoreLink(link) {
    if (!link) return true;

    const href = link.getAttribute('href');

    if (!href) return true;
    if (href === '#') return true;
    if (href.startsWith('#')) return true;
    if (href.startsWith('mailto:')) return true;
    if (href.startsWith('tel:')) return true;
    if (link.target === '_blank') return true;
    if (link.hasAttribute('download')) return true;
    if (link.dataset.noLoading === 'true') return true;

    return false;
  }

  document.addEventListener('click', function (e) {
    const link = e.target.closest('a');
    if (!link) return;
    if (shouldIgnoreLink(link)) return;

    showLoadingOverlay();
  }, true);

  document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!form) return;

    if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
      hideLoadingOverlay();
      return;
    }

    if (isNavigating) {
      e.preventDefault();
      return;
    }

    showLoadingOverlay();
  }, true);

  window.addEventListener('pageshow', function () {
    hideLoadingOverlay();
  });

  window.addEventListener('pagehide', function () {
    hideLoadingOverlay();
  });

  document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible') {
      hideLoadingOverlay();
    }
  });

  window.addEventListener('focus', function () {
    hideLoadingOverlay();
  });

})();
</script>

<script src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="index.js"></script>

</body>
</html>
