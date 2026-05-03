</div><!- DIV DEL ROW TOTAL -> 
</div><!- DIV DEL CONTAINER TOTAL ->

<footer class="bd-footer app-footer py-2 py-md-2 mt-0 bg-secondary text-start">
  <div class="container app-footer-inner py-2 py-md-5 px-4 px-md-3">
    <div class="row">
    <div class="col-lg-3 mb-0">
        <a class="app-footer-brand d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="<?= function_exists('app_path') ? app_path('index.php') : '/' ?>" aria-label="Inicio App Anestesia UACH">
          <span class='fs-5'><img class='app-footer-logo pe-2' src='<?= function_exists('app_path') ? app_path('images/austral_black.png') : 'images/austral_black.png' ?>' alt="" />Anestesia <small class='ps-0 opacity-50'> UACH</small></span>
        </a>
        <hr class="ms-0 mt-1 mb-2 me-0">
        <ul class="list-unstyled small text-muted">
          <li class="mb-2">Aplicación Web del Programa de Anestesiología y Reanimación de la Universidad Austral de Chile. Derechos Reservados</li>
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
    <img src="<?= function_exists('app_path') ? app_path('images/logo192.png') : 'images/logo192.png' ?>" alt="Cargando" class="loading-logo">
    <div class="loading-spinner"></div>
    <div class="loading-text">Cargando...</div>
  </div>
</div>



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

<script src="<?= function_exists('app_path') ? app_path('js/bootstrap.bundle.min.js') : 'js/bootstrap.bundle.min.js' ?>"></script>
<script type="text/javascript" src="<?= function_exists('app_path') ? app_path('index.js') : 'index.js' ?>"></script>

</body>
</html>
