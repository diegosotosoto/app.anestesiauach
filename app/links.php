<?php
//Validador login


//  require("valida_pag.php");   ****   PERMITE QUE LA PÁGINA SEA PÚBLICA   *****

//Variables sin conexion
$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<div class='text-white'>Links Útiles</div>";
$boton_navbar="<a></a><a></a>";

//Carga Head de la página
require("head.php");
?>
<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="content-shell">


      <section class="app-hero app-hero-blue">
        <div class="app-hero-row">
          <div class="app-hero-body">
            <div class="app-hero-kicker">APP clínica • links de interés</div>
            <h2>Links de interés en Anestesiología</h2>
            <p>Recursos clínicos y académicos útiles para la práctica diaria, docencia y toma de decisiones en anestesiología.</p>
          </div>
        </div>
      </section>


      <div class="links-grid">

        <!-- Pharmacopilot -->
        <a href="https://pharmacopilot.glide.page/" target="_blank" class="link-tile">
          <i class="fa-solid fa-pills fa-2x mb-2"></i>
          <div class="link-title">Pharmacopilot</div>
          <div class="link-desc">Herramienta práctica para cálculo y uso de fármacos.</div>
        </a>

        <!-- Pharmacopilot -->
        <a href="https://www.baby-blocks.com/en-espanol" target="_blank" class="link-tile">
          <i class="fa-solid fa-baby fa-2x mb-2"></i>
          <div class="link-title">Baby Blocks</div>
          <div class="link-desc">Plataforma educativa especializada en anestesia regional pediátrica y POCUS</div>
        </a>

        <!-- PODCAST ANESTESIA UC -->
        <a href="https://podcasts.apple.com/cl/podcast/podcast-de-la-divisi%C3%B3n-de-anestesiolog%C3%ADa-uc/id1278733546" target="_blank" class="link-tile">
          <i class="fa-solid fa-podcast fa-2x mb-2"></i> 
          <div class="link-title">Podcast Anestesiología UC</div>
          <div class="link-desc">Capítulos docentes que tratan temas de la especialidad</div>
        </a>

        <!-- NSQIP -->
        <a href="https://riskcalculator.facs.org/RiskCalculator/" target="_blank" class="link-tile">
          <i class="fa-solid fa-calculator fa-2x mb-2"></i>
          <div class="link-title">NSQIP</div>
          <div class="link-desc">Calculadora de riesgo quirúrgico del ACS basada en datos reales.</div>
        </a>

        <!-- OrphanAnesthesia -->
        <a href="https://www.orphananesthesia.eu/" target="_blank" class="link-tile">
          <i class="fa-solid fa-dna fa-2x mb-2"></i>
          <div class="link-title">OrphanAnesthesia</div>
          <div class="link-desc">Guías anestésicas para enfermedades raras.</div>
        </a>

        <!-- SACHILE -->
        <a href="https://www.sachile.cl/" target="_blank" class="link-tile">
          <i class="fa-solid fa-stethoscope fa-2x mb-2"></i>
          <div class="link-title">SACH</div>
          <div class="link-desc">Sociedad de Anestesiología de Chile.</div>
        </a>

        <!-- Medicina UACh -->
        <a href="https://linktr.ee/FAMEUACh/" target="_blank" class="link-tile">
          <i class="fa-solid fa-building-columns fa-2x mb-2"></i>
          <div class="link-title">Medicina UACh</div>
          <div class="link-desc">Facultad de Medicina Universidad Austral de Chile.</div>
        </a>

        <!-- WFSA -->
        <a href="https://www.wfsahq.org/" target="_blank" class="link-tile">
          <i class="fa-solid fa-globe fa-2x mb-2"></i>
          <div class="link-title">WFSA</div>
          <div class="link-desc">Federación mundial de anestesiología. Educación y estándares globales.</div>
        </a>

        <!-- CLASA -->
        <a href="https://www.anestesiaclasa.org/" target="_blank" class="link-tile">
          <i class="fa-solid fa-earth-americas fa-2x mb-2"></i>
          <div class="link-title">CLASA</div>
          <div class="link-desc">Confederación latinoamericana de anestesiología.</div>
        </a>

        <!-- OpenAnesthesia -->
        <a href="https://www.openanesthesia.org/" target="_blank" class="link-tile">
          <i class="fa-solid fa-book-open fa-2x mb-2"></i>
          <div class="link-title">OpenAnesthesia</div>
          <div class="link-desc">Recurso docente internacional con preguntas y revisiones.</div>
        </a>

        <!-- Nysora -->
        <a href="https://www.openanesthesia.org/" target="_blank" class="link-tile">
          <i class="fa-solid fa-syringe fa-2x mb-2"></i>
          <div class="link-title">NYSORA</div>
          <div class="link-desc">Biblioteca de temas sobre anestesia regional.</div>
        </a>

        <!-- E-Lactancia -->
        <a href="https://www.e-lactancia.org/" target="_blank" class="link-tile">
          <i class="fa-solid fa-person-breastfeeding fa-2x mb-2"></i>
          <div class="link-title">E-Lactancia</div>
          <div class="link-desc">Consulta la compatibilidad de la lactancia materna con fármacos.</div>
        </a>


      </div>

    </div>
  </div>
</div>


      </div>
    </div>
  </div>
</div>


<script>
const openExternal = (url) => {
  // Al no pasar un nombre de ventana o usar uno nuevo, 
  // el sistema suele delegar la apertura al navegador externo.
  window.open(url, '_blank', 'noopener,noreferrer');
};
</script>

<?php
  $conexion->close();
  require("footer.php");
?>
