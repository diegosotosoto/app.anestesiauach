<?php
//Validador login


//  require("valida_pag.php");   ****   PERMITE QUE LA PÁGINA SEA PÚBLICA   *****

//Variables sin conexion
$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<div class='text-white'>Links Útiles</div>";
$boton_navbar="<a></a><a></a>";

//Carga Head de la página
require("head.php");
?>
<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="apuntes-shell">


      <div class="apuntes-hero">
        <div class="small opacity-75 mb-1">APP clínica • links de interés</div>
        <div class="apuntes-hero-title">Links de interés en Anestesiología</div>
        <div class="apuntes-hero-subtitle"> Recursos clínicos y académicos útiles para la práctica diaria, docencia y toma de decisiones en anestesiología.</div>
      </div>




      <div class="links-grid">


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

        <!-- Pharmacopilot -->
        <a href="https://pharmacopilot.glide.page/" target="_blank" class="link-tile">
          <i class="fa-solid fa-pills fa-2x mb-2"></i>
          <div class="link-title">Pharmacopilot</div>
          <div class="link-desc">Herramienta práctica para cálculo y uso de fármacos.</div>
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


<style>
  .apuntes-hero{
    background: linear-gradient(135deg, var(--app-navy), #3559b7);
    color: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
    padding: 1.15rem 1.25rem;
    margin-bottom: 1rem;
  }

  .apuntes-hero-title{
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.2;
  }

  .apuntes-hero-subtitle{
    color: rgba(255,255,255,.75);
    margin-top: .35rem;
  }

.links-grid{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:16px;
}

/* BOTÓN ESTILO CLÍNICO */
.link-tile{
  display:flex;
  flex-direction:column;
  align-items:center;
  text-align:center;
  padding:18px 14px;
  border-radius:18px;
  text-decoration:none;
  color:#1f2a37;
  background:#ffffff;
  border:1px solid #e5e9f2;
  box-shadow:0 8px 20px rgba(0,0,0,.05);
  transition:.15s;
}

.link-tile:hover{
  transform:translateY(-2px);
  box-shadow:0 12px 26px rgba(0,0,0,.08);
  background:#f8fbff;
  color:#1f2a37;
}

/* ÍCONO */
.link-icon{
  font-size:1.6rem;
  color:#27458f;
  margin-bottom:8px;
}

/* TÍTULO */
.link-title{
  font-weight:600;
  font-size:.98rem;
}

/* DESCRIPCIÓN */
.link-desc{
  font-size:.82rem;
  color:#667085;
  margin-top:4px;
  line-height:1.3;
}

/* RESPONSIVE */
@media (min-width:768px){
  .links-grid{
    grid-template-columns:repeat(3,1fr);
  }
}

@media (min-width:1200px){
  .links-grid{
    grid-template-columns:repeat(4,1fr);
  }
}
</style>

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