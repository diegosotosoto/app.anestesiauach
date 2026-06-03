<?php
$titulo_pagina = "Dermatomas y Osteotomas";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Mapa de dermatomas y osteotomas de referencia para anestesia regional. Permite identificar los niveles sensitivos correspondientes a cada territorio corporal, orientando la selección del nivel de bloqueo, el abordaje técnico y la evaluación del nivel sensitivo post-bloqueo.";
$formula = "Los mapas representan distribuciones promedio con variabilidad interindividual significativa. Usar siempre en conjunto con la clínica, la evaluación sensitiva intraoperatoria y las referencias anatómicas de superficie.";
$referencias = array(
  '<a href="https://www.nysora.com/topics/anatomy/functional-regional-anesthesia-anatomy/" target="_blank" rel="noopener">NYSORA – Functional Regional Anesthesia Anatomy</a>',
  '<a href="https://anesth.unboundmedicine.com/anesthesia/view/ClinicalAnesthesiaProcedures/728584/all/Regional_Anesthesia___Regional_Anesthesia_of_the_Neck" target="_blank" rel="noopener">Clinical Anesthesia Procedures – Regional Anesthesia of the Neck (Unbound Medicine)</a>',
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">

<style>
  /* ── ScrollSpy navbar ─────────────────────────────────────────── */
  .derm-scrollnav {
    position: sticky;
    top: 0; /* ajustado dinámicamente por JS según altura real del navbar */
    z-index: 100;
    background: var(--note-card);
    border-bottom: 1.5px solid var(--note-line);
    box-shadow: 0 2px 8px rgba(15,23,42,.06);
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    width: 100%;
  }
  .derm-scrollnav::-webkit-scrollbar { display: none; }
  .derm-scrollnav-inner {
    display: flex;
    gap: 0;
    min-width: max-content;
    padding: 0 .5rem;
  }
  .derm-scrollnav-inner .nav-link {
    font-size: .82rem;
    font-weight: 700;
    color: var(--note-muted);
    white-space: nowrap;
    padding: .65rem .95rem;
    border-bottom: 2.5px solid transparent;
    border-radius: 0;
    transition: color .15s, border-color .15s;
    letter-spacing: .01em;
  }
  .derm-scrollnav-inner .nav-link:hover {
    color: var(--note-brand-2);
  }
  .derm-scrollnav-inner .nav-link.active {
    color: var(--note-brand-2);
    border-bottom-color: var(--note-brand-2);
  }

  /* ── Imágenes ───────────────────────────────────────────────────── */
  .derm-img-card {
    background: var(--note-card);
    border: 1.5px solid var(--note-line);
    border-radius: var(--note-radius-lg);
    overflow: hidden;
    box-shadow: var(--note-shadow);
  }
  .derm-img-header {
    padding: .85rem 1.1rem .6rem;
    border-bottom: 1px solid var(--note-line);
  }
  .derm-img-title {
    font-size: .97rem;
    font-weight: 800;
    color: var(--note-text);
    margin: 0;
  }
  .derm-img-subtitle {
    font-size: .82rem;
    color: var(--note-muted);
    margin: .2rem 0 0;
  }
  .derm-img-wrap {
    background: #f8fafc;
    text-align: center;
    padding: 1rem;
  }
  .derm-img-wrap img {
    max-width: 100%;
    height: auto;
    max-height: 70vh;
    border-radius: .6rem;
    cursor: zoom-in;
  }
  .derm-img-caption {
    padding: .65rem 1.1rem .75rem;
    font-size: .81rem;
    color: var(--note-muted);
    border-top: 1px solid var(--note-line);
    background: var(--note-soft);
  }

  /* ── Lightbox simple ────────────────────────────────────────────── */
  #derm-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(10,15,30,.88);
    align-items: center;
    justify-content: center;
    cursor: zoom-out;
  }
  #derm-lightbox.open { display: flex; }
  #derm-lightbox img {
    max-width: 95vw;
    max-height: 92vh;
    border-radius: .75rem;
    box-shadow: 0 24px 64px rgba(0,0,0,.5);
    object-fit: contain;
    cursor: zoom-out;
  }
  #derm-lightbox-close {
    position: absolute;
    top: 1rem; right: 1.2rem;
    background: rgba(255,255,255,.15);
    border: none;
    border-radius: 50%;
    width: 2.5rem; height: 2.5rem;
    color: #fff;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
  }

  /* ── Tabla de niveles ───────────────────────────────────────────── */
  .derm-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: var(--note-card);
    border: 1px solid var(--note-line);
    border-radius: var(--note-radius);
    overflow: hidden;
    font-size: .86rem;
  }
  .derm-table th {
    background: var(--note-brand-2);
    color: #fff;
    font-weight: 800;
    padding: .65rem .9rem;
    text-align: left;
    border-bottom: 1px solid var(--note-line);
  }
  .derm-table td {
    padding: .6rem .9rem;
    border-bottom: 1px solid var(--note-line);
    vertical-align: top;
    color: var(--note-text);
  }
  .derm-table tr:last-child td { border-bottom: none; }
  .derm-table td:first-child {
    font-weight: 800;
    color: var(--note-brand);
  }
  .derm-level-badge {
    display: inline-block;
    background: var(--note-brand-soft);
    color: var(--note-brand);
    font-size: .78rem;
    font-weight: 800;
    border-radius: .4rem;
    padding: .1rem .45rem;
    margin-right: .25rem;
    border: 1px solid var(--note-brand-soft-border);
  }

  /* ── Secciones con scroll offset ───────────────────────────────── */
  .derm-section {
    scroll-margin-top: 110px; /* topbar 56px + scrollnav ~44px + margen */
  }
</style>

<!-- Lightbox -->
<div id="derm-lightbox" role="dialog" aria-modal="true" aria-label="Imagen ampliada">
  <button id="derm-lightbox-close" aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
  <img id="derm-lightbox-img" src="" alt="">
</div>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell px-1 px-md-0 py-0">

        <!-- Hero -->
        <div class="note-hero mb-3">
          <div class="note-hero-kicker">APP CLÍNICA · ANESTESIA REGIONAL</div>
          <h2>Dermatomas y Osteotomas</h2>
          <div class="note-hero-subtitle">Mapas de inervación sensitiva cutánea y ósea para orientación del bloqueo regional, evaluación del nivel sensitivo y planificación anestésica.</div>
        </div>

        <!-- Info box -->
        <div class="info-box mb-3" id="infoBox">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content" style="display:none;">
            <p class="mb-2"><?= $descripcion_info ?></p>
            <hr>
            <strong>Comentario:</strong><br><?= $formula ?>
            <hr>
            <strong>Referencias:</strong>
            <ul class="mb-0 mt-2">
              <?php foreach ($referencias as $ref): ?>
                <li class="mb-2"><?= $ref ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <!-- ScrollSpy navbar -->
        <nav class="derm-scrollnav mb-4" id="derm-scrollnav">
          <div class="derm-scrollnav-inner nav" id="derm-nav-links">
            <a class="nav-link active" href="#sec-dermatomas-frontal">Dermatomas — Frontal</a>
            <a class="nav-link" href="#sec-dermatomas-dorsal">Dermatomas — Dorsal</a>
            <a class="nav-link" href="#sec-osteotomas-sup">Osteotomas — MMSS</a>
            <a class="nav-link" href="#sec-osteotomas-inf">Osteotomas — MMII</a>
            <a class="nav-link" href="#sec-cervical">Plexo cervical</a>
            <a class="nav-link" href="#sec-niveles">Niveles de referencia</a>
          </div>
        </nav>

        <!-- ── DERMATOMAS FRONTAL ────────────────────────────────── -->
        <div class="derm-section mb-4" id="sec-dermatomas-frontal">
          <div class="derm-img-card">
            <div class="derm-img-header">
              <div class="derm-img-title">Dermatomas — Vista frontal</div>
              <div class="derm-img-subtitle">Distribución sensitiva cutánea, cara anterior</div>
            </div>
            <div class="derm-img-wrap">
              <img src="img_apuntes/dermatomas_frontal.jpeg"
                   alt="Mapa de dermatomas vista frontal"
                   onclick="abrirLightbox(this)"
                   loading="lazy">
            </div>
            <div class="derm-img-caption">
              Toca la imagen para ampliar. Los colores representan territorios de raíces espinales individuales. La superposición entre raíces adyacentes es frecuente y clínicamente relevante.
            </div>
          </div>
        </div>

        <!-- ── DERMATOMAS DORSAL ─────────────────────────────────── -->
        <div class="derm-section mb-4" id="sec-dermatomas-dorsal">
          <div class="derm-img-card">
            <div class="derm-img-header">
              <div class="derm-img-title">Dermatomas — Vista dorsal</div>
              <div class="derm-img-subtitle">Distribución sensitiva cutánea, cara posterior</div>
            </div>
            <div class="derm-img-wrap">
              <img src="img_apuntes/dermatomas_dorsal.jpeg"
                   alt="Mapa de dermatomas vista dorsal"
                   onclick="abrirLightbox(this)"
                   loading="lazy">
            </div>
            <div class="derm-img-caption">
              Vista posterior. Notar la distribución en banda de los niveles torácicos (T1–T12) y la mayor variabilidad en regiones de transición cervicotorácica y lumbosacra.
            </div>
          </div>
        </div>

        <!-- ── OSTEOTOMAS SUPERIORES ────────────────────────────── -->
        <div class="derm-section mb-4" id="sec-osteotomas-sup">
          <div class="derm-img-card">
            <div class="derm-img-header">
              <div class="derm-img-title">Osteotomas — Extremidad superior</div>
              <div class="derm-img-subtitle">Inervación sensitiva ósea, miembro superior</div>
            </div>
            <div class="derm-img-wrap">
              <img src="img_apuntes/osteotomas_superior.jpeg"
                   alt="Osteotomas extremidad superior"
                   onclick="abrirLightbox(this)"
                   loading="lazy">
            </div>
            <div class="derm-img-caption">
              Los osteotomas difieren de los dermatomas: la inervación del periostio y del hueso puede no coincidir con el territorio cutáneo superficial. Relevante para bloqueos destinados a cirugía ósea u ortopédica.
            </div>
          </div>
        </div>

        <!-- ── OSTEOTOMAS INFERIORES ────────────────────────────── -->
        <div class="derm-section mb-4" id="sec-osteotomas-inf">
          <div class="derm-img-card">
            <div class="derm-img-header">
              <div class="derm-img-title">Osteotomas — Extremidad inferior</div>
              <div class="derm-img-subtitle">Inervación sensitiva ósea, miembro inferior</div>
            </div>
            <div class="derm-img-wrap">
              <img src="img_apuntes/osteotomas_inferior.jpeg"
                   alt="Osteotomas extremidad inferior"
                   onclick="abrirLightbox(this)"
                   loading="lazy">
            </div>
            <div class="derm-img-caption">
              En la extremidad inferior, la complejidad del plexo lumbosacro hace que el mapa de osteotomas sea especialmente relevante para cirugías de cadera, fémur, rodilla y tobillo.
            </div>
          </div>
        </div>

        <!-- ── PLEXO CERVICAL ────────────────────────────────────── -->
        <div class="derm-section mb-4" id="sec-cervical">
          <div class="derm-img-card">
            <div class="derm-img-header">
              <div class="derm-img-title">Plexo cervical — Territorios sensitivos</div>
              <div class="derm-img-subtitle">Ramas del plexo cervical superficial (C1–C4)</div>
            </div>
            <div class="derm-img-wrap">
              <img src="img_apuntes/plexo_cervical.jpeg"
                   alt="Plexo cervical — territorios sensitivos"
                   onclick="abrirLightbox(this)"
                   loading="lazy">
            </div>
            <div class="derm-img-caption">
              Toca la imagen para ampliar. Distribución de las ramas sensitivas del plexo cervical superficial con relevancia en anestesia de cuello, hombro y cirugía carotídea.
            </div>
          </div>
        </div>

        <!-- ── TABLA NIVELES DE REFERENCIA ──────────────────────── -->
        <div class="derm-section mb-4" id="sec-niveles">
          <div class="note-card">
            <div class="note-card-body">
              <div class="note-card-title">Niveles de referencia clínica</div>
              <p class="note-section-label mb-3">Hitos anatómicos de superficie y niveles objetivo según cirugía</p>
              <div class="table-responsive">
                <table class="derm-table">
                  <thead>
                    <tr>
                      <th>Nivel</th>
                      <th>Hito anatómico / cirugía objetivo</th>
                      <th>Relevancia anestésica</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><span class="derm-level-badge">C3–C4</span></td>
                      <td>Región supraclavicular, cuello inferior</td>
                      <td>Límite superior del bloqueo braquial; cubierto por plexo cervical superficial</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">T2</span></td>
                      <td>Vértice axilar / cara interna del brazo</td>
                      <td>Nivel mínimo para bloqueo de extremidad superior completa; nervio intercostobraquial</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">T4</span></td>
                      <td>Pezón / línea mamaria</td>
                      <td>Cesárea o cirugía abierta abdominal alta; evaluar siempre con frío o pinprick</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">T6</span></td>
                      <td>Apéndice xifoides</td>
                      <td>Cirugía abdominal baja o apéndice abierto; analgesia postoperatoria de abdomen superior</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">T10</span></td>
                      <td>Ombligo</td>
                      <td>Cirugía de cadera, RTU de próstata, parto vaginal, histerectomía</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">T12</span></td>
                      <td>Región inguinal / pliegue inguinal</td>
                      <td>Límite inferior de la inervación torácica; inicio de territorio lumbar</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">L1</span></td>
                      <td>Ingle / escroto superior / labio mayor</td>
                      <td>Hernioplastías inguinales; bloqueo ilioinguinal / iliohipogástrico; cirugía de extremidad inferior</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">L3–L4</span></td>
                      <td>Cara anterior del muslo / rodilla medial</td>
                      <td>Cirugía de pie (L2–L3); plexo lumbar; nervio femoral; bloqueo para rodilla y muslo anterior</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">S1</span></td>
                      <td>Borde lateral del pie / planta</td>
                      <td>Última raíz en bloquearse en espinal; relevante en evaluación de bloqueo sacro</td>
                    </tr>
                    <tr>
                      <td><span class="derm-level-badge">S2–S4</span></td>
                      <td>Periné / región sacra</td>
                      <td>Hemorroidectomía (S2–S5); anestesia en silla de montar; bloqueo caudal; cirugía ano-rectal y perineal</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Nota advertencia final -->
        <div class="note-warning mb-4">
          <strong>Variabilidad anatómica:</strong>
          <div class="mt-2">Los mapas de dermatomas y osteotomas representan distribuciones medias poblacionales. Existe solapamiento significativo entre raíces adyacentes y variabilidad interindividual. La evaluación clínica intraoperatoria (frío, pinprick, presión) sigue siendo el gold standard para confirmar el nivel de bloqueo.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- JavaScript: lightbox + scrollspy manual -->
<script>
(function () {
  // ── Lightbox ──────────────────────────────────────────────────────
  var lb    = document.getElementById('derm-lightbox');
  var lbImg = document.getElementById('derm-lightbox-img');
  var lbClose = document.getElementById('derm-lightbox-close');

  window.abrirLightbox = function (img) {
    lbImg.src = img.src;
    lbImg.alt = img.alt;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  function cerrarLightbox() {
    lb.classList.remove('open');
    document.body.style.overflow = '';
    lbImg.src = '';
  }

  lb.addEventListener('click', function (e) {
    if (e.target === lb) cerrarLightbox();
  });
  lbImg.addEventListener('click', cerrarLightbox);
  lbClose.addEventListener('click', cerrarLightbox);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') cerrarLightbox();
  });

  // ── Ajustar top del scrollspy según altura real del navbar ───────
  var scrollNav = document.getElementById('derm-scrollnav');

  function ajustarTopScrollnav() {
    var navbar = document.querySelector('.app-shell-left');
    var navH = navbar ? navbar.getBoundingClientRect().height : 0;
    // En desktop (≥576px) el navbar es lateral, top=0; en móvil usa altura real
    if (window.innerWidth < 576 && navH > 0) {
      scrollNav.style.top = navH + 'px';
    } else {
      scrollNav.style.top = '0px';
    }
  }

  ajustarTopScrollnav();
  window.addEventListener('resize', ajustarTopScrollnav);

  function getNavOffset() {
    var navbar = document.querySelector('.app-shell-left');
    var navH = (window.innerWidth < 576 && navbar) ? navbar.getBoundingClientRect().height : 0;
    var scrollNavH = scrollNav ? scrollNav.getBoundingClientRect().height : 44;
    return navH + scrollNavH + 8;
  }

  // ── ScrollSpy manual ─────────────────────────────────────────────
  var navLinks = Array.from(document.querySelectorAll('#derm-nav-links .nav-link'));
  var sections = navLinks.map(function (a) {
    var id = a.getAttribute('href').replace('#', '');
    return document.getElementById(id);
  });

  function onScroll() {
    var offset = getNavOffset();
    var scrollY = window.scrollY || window.pageYOffset;
    var activeIdx = 0;

    sections.forEach(function (sec, i) {
      if (sec && sec.getBoundingClientRect().top + scrollY - offset <= scrollY) {
        activeIdx = i;
      }
    });

    navLinks.forEach(function (a, i) {
      a.classList.toggle('active', i === activeIdx);
    });

    // Scroll el nav activo a la vista
    var activeLink = navLinks[activeIdx];
    if (activeLink) {
      var nav = document.getElementById('derm-scrollnav');
      var linkLeft = activeLink.offsetLeft;
      var linkWidth = activeLink.offsetWidth;
      var navWidth = nav.offsetWidth;
      nav.scrollLeft = linkLeft - navWidth / 2 + linkWidth / 2;
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Smooth scroll al hacer clic en nav
  navLinks.forEach(function (a, idx) {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      var id = a.getAttribute('href').replace('#', '');
      var target = document.getElementById(id);
      if (target) {
        // Activar link inmediatamente sin esperar el evento scroll
        navLinks.forEach(function (l) { l.classList.remove('active'); });
        a.classList.add('active');
        var nav = document.getElementById('derm-scrollnav');
        nav.scrollLeft = a.offsetLeft - nav.offsetWidth / 2 + a.offsetWidth / 2;

        var top = target.getBoundingClientRect().top + window.scrollY - getNavOffset();
        window.scrollTo({ top: top, behavior: 'smooth' });
      }
    });
  });
})();

function toggleInfo() {
  var box = document.getElementById('infoContent');
  box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
}
</script>

<?php require("../footer.php"); ?>
