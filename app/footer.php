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

<!-- ── Botón volver arriba ─────────────────────────────────────── -->
<button id="scroll-top-btn" aria-label="Volver arriba" title="Volver arriba">
  <i class="fa-solid fa-chevron-up"></i>
</button>
<style>
  #scroll-top-btn {
    position: fixed;
    bottom: 1.5rem;
    right: 1.25rem;
    z-index: 500;
    width: 2.75rem;
    height: 2.75rem;
    border-radius: 50%;
    border: none;
    background: #27458f;
    color: #fff;
    font-size: 1rem;
    box-shadow: 0 4px 16px rgba(39,69,143,.35);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transform: translateY(8px);
    transition: opacity .22s ease, transform .22s ease;
  }
  #scroll-top-btn.visible {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
  }
  #scroll-top-btn:hover {
    background: #3559b7;
  }
  body.sidebar-right #scroll-top-btn {
    right: auto;
    left: 1.25rem;
  }
  /* En desktop el sidebar ocupa espacio lateral — alejar un poco */
  @media (min-width: 576px) {
    body.sidebar-left #scroll-top-btn  { right: 1.75rem; }
    body.sidebar-right #scroll-top-btn { left: 1.75rem; }
  }
</style>
<script>
(function () {
  // ── Variable CSS global para offset sticky ────────────────────
  function setAppStickyTop() {
    var navbar = document.querySelector('.app-shell-left');
    var navH = (navbar && window.innerWidth < 576) ? navbar.getBoundingClientRect().height : 0;
    var offset = navH > 0 ? (navH + 6) + 'px' : '.65rem';
    document.documentElement.style.setProperty('--app-sticky-top', offset);
  }
  setAppStickyTop();
  window.addEventListener('resize', setAppStickyTop, { passive: true });
})();

(function () {
  var btn = document.getElementById('scroll-top-btn');
  if (!btn) return;

  window.addEventListener('scroll', function () {
    if ((window.scrollY || window.pageYOffset) > 200) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  }, { passive: true });

  btn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
})();
</script>

<script src="<?= function_exists('app_path') ? app_path('js/bootstrap.bundle.min.js') : 'js/bootstrap.bundle.min.js' ?>"></script>
<script type="text/javascript" src="<?= function_exists('app_path') ? app_path('index.js') : 'index.js' ?>"></script>
<script>window.APP_PUSH_ENDPOINT = window.location.origin + "/push_subscription.php";</script>
<script type="text/javascript" src="<?= function_exists('app_path') ? app_path('js/push-notifications.js') : 'js/push-notifications.js' ?>"></script>

</body>
</html>
