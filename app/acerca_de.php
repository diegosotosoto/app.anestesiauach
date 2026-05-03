<?php
  //No requiere validador de página

  //Variables sin conexion
  $boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar="<div class='text-white'>Acerca de</div>";
  $boton_navbar="<span class='navbar-brand mr-auto ms-5' role='button'></span>";

  //Carga Head de la página
  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="content-shell">

        <div class="about-shell">

          <section class="app-hero app-hero-blue">
            <div class="app-hero-row">
              <div class="app-hero-body">
                <div class="app-hero-kicker">APP Clínica • Información general</div>
                <h2>Acerca de App Anestesia UACh</h2>
                <p>Recursos, cálculo clínico y apoyo docente para becados e internos de Anestesiología.</p>
              </div>
            </div>
          </section>



<section class="about-card about-team-card mb-3">
  <div class="about-section-title text-center">Equipo de Desarrollo</div>

  <div class="team-list">

    <div class="team-member">
      <div class="team-role">Autor</div>
      <img src="images/autor_diego.jpg" class="team-avatar" alt="Diego Soto Soto">
      <div class="team-info">
        <div class="team-name">Dr. Diego Soto Soto</div>
        <div class="team-desc">Anestesiólogo CAV - HBV</div>
        <div class="team-desc">Docente de Anestesiología UACh</div>
        <a href="mailto:diegosotosoto@gmail.com" class="team-email">diegosotosoto@gmail.com</a>
      </div>
    </div>

    <div class="team-member">
      <div class="team-role">Revisora</div>
      <img src="images/revisor_martina.jpg" class="team-avatar" alt="Martina Saavedra Rendic">
      <div class="team-info">
        <div class="team-name">Dra. Martina Saavedra Rendic</div>
        <div class="team-desc">Anestesióloga HBV</div>
        <div class="team-desc">Docente de Anestesiología UACh</div>
        <a href="mailto:martina.saavedra.rendic@gmail.com" class="team-email">martina.saavedra.rendic@gmail.com</a>
      </div>
    </div>

    <div class="team-member">
      <div class="team-role">Revisor</div>
      <img src="images/revisor_sebastian.jpg" class="team-avatar" alt="Sebastian Estrada Eguiguren">
      <div class="team-info">
        <div class="team-name">Dr. Sebastián Estrada Eguiguren</div>
        <div class="team-desc">Residente de Anestesiología UACh</div>
        <a href="mailto:seba.igee@gmail.com" class="team-email">seba.igee@gmail.com</a>
      </div>
    </div>

  </div>
</section>


<section class="about-card about-share-card mb-3">
  <div class="about-section-title text-center">Compartir App</div>

  <div class="share-content">
    <img src="images/IMG0001.jpeg" class="share-qr" alt="QR App Anestesia UACh">

    <div class="share-info">
      <h3>Escanea o Comparte</h3>
      <p>Comparte App Anestesia UACh con residentes, internos y docentes.</p>

      <a class="about-link d-block mb-3" href="https://app.anestesiauach.cl/">
        app.anestesiauach.cl
      </a>

      <button id="button-compartir" class="btn btn-app-primary share-btn not-overlay">
        Compartir <i class="fa-solid fa-arrow-up-from-bracket ms-2"></i>
      </button>
    </div>
  </div>
</section>

<script>
  const shareData = {
    title: 'Anest UACh',
    text: 'App Anestesia UACh',
    url: 'https://app.anestesiauach.cl/',
  };

  const btn = document.querySelector('#button-compartir');

  if (btn) {
    btn.addEventListener('click', async () => {
      try {
        if (navigator.share) {
          await navigator.share(shareData);
        }
      } catch (e) {
        console.log(e);
      }
    });
  }
</script>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
  require("footer.php");
?>
