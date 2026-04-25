<?php
  //No requiere validador de página

  //Variables sin conexion
  $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar="<div class='text-white'>Acerca de</div>";
  $boton_navbar="<span class='navbar-brand mr-auto ms-5' role='button'></span>";

  //Carga Head de la página
  require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">

    <style>

.about-topbar{
  background:linear-gradient(135deg, #27458f 0%, #3a57c4 55%, #4f7de8 100%);
  color:#fff;
  border-radius:28px;
  box-shadow:0 14px 32px rgba(33,55,98,.16);
  padding:22px 20px;
}

.about-topbar h1{
  color:#fff;
  font-size:1.55rem;
  font-weight:800;
  line-height:1.15;
}

.subtle{
  font-size:1rem;
  line-height:1.45;
}

.pill{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:8px 14px;
  border-radius:999px;
  font-size:.9rem;
  font-weight:800;
  white-space:nowrap;
}

@media (max-width:549px){
  .about-topbar{
    padding:20px 18px;
    border-radius:24px;
  }

  .about-topbar h1{
    font-size:1.38rem;
  }

  .subtle{
    font-size:.98rem;
  }
}

.about-shell{
  max-width:980px;
  margin:0 auto;
}

.about-card{
  border:0;
  border-radius:24px;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  background:#fff;
}

.about-section-title{
  font-size:.82rem;
  text-transform:uppercase;
  letter-spacing:.12em;
  color:#667085;
  margin-bottom:16px;
}

/* Hero bienvenida */

.about-welcome-card{
  overflow:hidden;
  border-radius:28px;
}

.about-hero-img{
  width:100%;
  display:block;
  border-radius:28px 28px 0 0;
}

.about-welcome-body{
  padding:24px 18px 26px;
  text-align:center;
}

.about-welcome-title{
  font-size:1.55rem;
  font-weight:800;
  color:#10265f;
  line-height:1.15;
  margin:0;
}

.about-title-line{
  width:54px;
  height:4px;
  border-radius:999px;
  background:#2f63d8;
  margin:14px auto 16px;
}

.about-welcome-text{
  font-size:1.02rem;
  color:#4b5563;
  line-height:1.55;
  margin:0 auto 22px;
  max-width:620px;
}

.about-feature-grid{
  display:grid;
  grid-template-columns:1fr;
  gap:12px;
}

.about-feature-card{
  display:flex;
  align-items:center;
  gap:16px;
  text-align:left;
  border:1px solid #e3eaf5;
  background:#fff;
  border-radius:18px;
  padding:16px;
  box-shadow:0 8px 20px rgba(33,55,98,.06);
}

.about-feature-card i{
  font-size:2rem;
  color:#2f63d8;
  width:42px;
  text-align:center;
  flex:0 0 42px;
}

.about-feature-card strong{
  display:block;
  font-size:1.05rem;
  color:#10265f;
  line-height:1.2;
}

.about-feature-card span{
  display:block;
  margin-top:4px;
  font-size:.95rem;
  color:#5f6b7a;
  line-height:1.35;
}

.about-closing{
  margin-top:22px;
  padding-top:18px;
  border-top:1px solid #dfe7f2;
}

.about-closing strong{
  display:block;
  font-size:1.1rem;
  color:#1d5fd3;
}

.about-closing span{
  display:block;
  margin-top:4px;
  font-size:.95rem;
  color:#5f6b7a;
}

/* Equipo */

.about-team-card{
  padding:20px 14px;
}

.team-list{
  display:flex;
  flex-direction:column;
  gap:12px;
}

.team-member{
  display:grid;
  grid-template-columns:88px 1fr;
  grid-template-areas:
    "role role"
    "avatar info";
  gap:8px 14px;
  align-items:center;
  padding:14px 16px;
  border:1px solid #dfe7f2;
  border-radius:18px;
  background:#f8fafc;
}

.team-role{
  font-size:.74rem;
  font-weight:800;
  text-transform:uppercase;
  letter-spacing:.08em;
  margin-bottom:0;
  color:#2f63d8;
}

.team-avatar{
  grid-area:avatar;
  width:88px;
  height:108px;
  max-width:88px;
  min-width:88px;
  border-radius:22px;
  object-fit:cover;
  display:block;
  background:#eef4ff;
  overflow:hidden;
}


.team-info{
  grid-area:info;
  text-align:left;
}

.team-avatar-placeholder{
  display:flex;
  align-items:center;
  justify-content:center;
  color:#2f63d8;
  font-size:2.1rem;
}

.team-name{
  font-size:1.05rem;
  font-weight:800;
  color:#1f2937;
  line-height:1.12;
  margin-bottom:2px;
}

.team-desc{
  font-size:.92rem;
  color:#6b7280;
  line-height:1.15;
}

.team-email{
  display:inline-block;
  margin-top:3px;
  font-size:.9rem;
  font-weight:700;
  color:#2f63d8;
  text-decoration:none;
  overflow-wrap:anywhere;
  line-height:1.15;
}

/* Compartir */

.about-share-card{
  padding:22px 16px;
  overflow:hidden;
}

.share-content{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:18px;
  text-align:center;
  width:100%;
}

.share-info{
  max-width:360px;
  margin-left:0;
}

.share-qr{
  width:min(340px, 86vw);
  max-width:100%;
  height:auto;
  display:block;
  border-radius:22px;
  box-shadow:0 12px 28px rgba(33,55,98,.12);
  background:#fff;
  padding:10px;
}

.share-btn{
  min-height:46px;
  border-radius:16px;
  padding:10px 18px;
  font-weight:700;
}

.share-info h3{
  font-size:1.35rem;
  font-weight:800;
  color:#10265f;
  margin-bottom:8px;
}

.share-info p{
  font-size:1rem;
  color:#6b7280;
  line-height:1.4;
  margin-bottom:18px;
}

.share-btn{
  min-height:48px;
  border-radius:18px;
  padding:10px 20px;
  font-weight:700;
}

/* Responsive */

@media (min-width:768px){
  .about-welcome-body{
    padding:30px 34px 34px;
  }

  .about-feature-grid{
    grid-template-columns:repeat(2, 1fr);
  }

  .team-member{
    grid-template-columns:100px 88px 1fr;
    grid-template-areas:"role avatar info";
  }

  .share-content{
    flex-direction:row;
    justify-content:center;
    align-items:center;
    gap:48px;
    text-align:left;
  }

  .share-info{
    margin-left:0;
  }
}

@media (max-width:549px){
  .about-card{
    border-radius:22px;
  }

  .about-welcome-title{
    font-size:1.38rem;
  }

  .about-welcome-text{
    font-size:1rem;
  }

  .team-member{

    padding:12px 14px;

  }

  .team-avatar{

    width:68px;

    height:85px;

    min-width:68px;

  }

}
</style>

        <div class="about-shell">

          <div class="about-topbar mb-3">
            <div class="d-flex justify-content-between align-items-start gap-3">
              <div>
                <div class="small opacity-75 mb-1">APP Clínica • Información General</div>
                <h1 class="h4 mb-2">Acerca de App Anestesia UACh</h1>
                <div class="subtle text-white-50">Recursos, cálculo clínico y apoyo docente para residentes e internos de Anestesiología.</div>
              </div>
              <span class="pill bg-light text-dark">App</span>
            </div>
          </div>



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

      <button id="button-compartir" class="btn btn-primary share-btn not-overlay">
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
