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
          .about-shell{
            max-width:980px;
            margin:0 auto;
          }

          .about-topbar{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
          }

          .about-topbar h1{
            color:#fff;
          }

          .subtle{
            font-size:.92rem;
          }

          .pill{
            display:inline-block;
            padding:.25rem .6rem;
            border-radius:999px;
            font-size:.8rem;
            font-weight:600;
          }

          .about-card{
            border:0;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;
          }

          .about-logo{
            width:256px;
            height:256px;
            object-fit:contain;
          }

          .about-title{
            font-size:1.5rem;
            font-weight:700;
            color:#1f2a37;
          }

          .about-link{
            color:#2453c6;
            text-decoration:none;
            font-weight:600;
            word-break:break-word;
          }

          .about-link:hover{
            text-decoration:underline;
          }

          .about-share{
            border-radius:.9rem;
            font-weight:600;
          }

          .about-image{
            width:100%;
            max-width:320px;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.08);
          }

          .about-section-title{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#667085;
            margin-bottom:.7rem;
          }

          .about-text-box{
            border:1px solid #dfe7f2;
            border-radius:1rem;
            background:#f8fafc;
            padding:1rem 1.1rem;
            color:#4b5563;
            line-height:1.65;
            text-align:left;
          }

          .about-meta{
            display:grid;
            gap:.75rem;
          }

          .about-meta-row{
            display:flex;
            align-items:flex-start;
            gap:1rem;
            border:1px solid #dfe7f2;
            border-radius:1rem;
            background:#f8fafc;
            padding:1rem 1.1rem;
          }

          .about-meta-label{
            font-weight:700;
            color:#1f2a37;
            min-width:72px;
            flex:0 0 72px;
          }

          .about-meta-value{
            text-align:left;
            color:#4b5563;
            word-break:break-word;
            line-height:1.2;
            flex:1 1 auto;
          }

        @media (max-width:549px){
          .about-topbar{
            padding:1rem;
          }

          .about-title{
            font-size:1.25rem;
          }

          .about-meta-row{
            flex-direction:column;
            align-items:flex-start;
            gap:.75rem;
          }

          .about-meta-label{
            min-width:auto;
            flex:none;
          }

          .about-meta-value{
            text-align:left;
            width:100%;
          }

          .about-author-card{
            align-items:flex-start;
          }

          .about-author-photo{
            width:56px;
            height:56px;
            min-width:56px;
            border-radius:14px;
          }
        }

        .about-meta-value{
          text-align:right;
          color:#4b5563;
          word-break:break-word;
          line-height:1.2;
        }

        .about-meta-link{
          display:block;
          margin-top:.18rem;
          line-height:1.2;
        }

        .about-author-row{
          align-items:flex-start;
        }

        .about-author-card{
          display:flex;
          align-items:center;
          gap:14px;
          width:100%;
          text-align:left;
        }

        .about-author-photo{
          width:64px;
          height:64px;
          min-width:64px;
          border-radius:16px;
          overflow:hidden;
          background:#eef4ff;
          display:flex;
          align-items:center;
          justify-content:center;
        }

        .about-author-photo img{
          width:100%;
          height:100%;
          object-fit:cover;
          display:block;
        }

        .about-author-info{
          text-align:left;
          line-height:1.25;
          min-width:0;
        }

        .about-author-name{
          font-weight:700;
          color:#1f2a37;
        }

        .about-author-role{
          margin-top:.2rem;
          font-size:.92rem;
          color:#6b7280;
        }

        .about-meta-link{
          display:block;
          margin-top:.25rem;
          line-height:1.2;
        }
        
        img { width: 80px; }
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

          <div class="about-card mb-3">
            <div class="p-4">
              <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                  <div class="about-section-title">Bienvenidos</div>
                  <div class="about-text-box">
                    ¡Bienvenido a la Aplicación Web de los Residentes de Anestesiología de la UACh!<br><br>
                    Nuestra aplicación es el lugar perfecto para que los Residentes e Internos de Anestesiología encuentren recursos valiosos para mejorar conocimientos y habilidades. Aquí encontrarás contenido exclusivo, herramientas de cálculo, estudio y casos clínicos.<br><br>
                    Además, nuestra aplicación te permitirá conectar con Residentes de Anestesiología y Especialistas de la UACh, lo que te brindará una valiosa oportunidad para aprender y compartir experiencia.<br><br>
                    Estamos emocionados de tenerte a bordo y esperamos que disfrutes al máximo tu experiencia en nuestra app. ¡Comienza a explorar ahora mismo!
                  </div>
                </div>
               
              </div>
            </div>
          </div>

          <div class="about-card">
            <div class="p-4">
              <div class="about-section-title">Equipo de Desarrollo</div>
              <div class="about-meta">
              <div class="about-meta-row about-author-row">
                <div class="about-meta-label">Autor</div>
                <div class="about-author-card">
                  <div class="about-author-photo">
                    <img src="images/autor-diego.jpg" alt="Diego Soto Soto">
                  </div>
                  <div class="about-author-info">
                    <div class="about-author-name">Diego Soto Soto</div>
                    <div class="about-author-role">Médico Anestesiólogo</div>
                    <div class="about-author-role">Docente de Anestesiología UACh</div>      
                    <a class="about-link about-meta-link" href="mailto:diegosotosoto@gmail.com">diegosotosoto@gmail.com</a>
                  </div>
                </div>
              </div>

              <div class="about-meta-row about-author-row">
                <div class="about-meta-label">Revisora</div>
                <div class="about-author-card">
                  <div class="about-author-photo">
                    <img src="images/revisora-martina.jpg" alt="Martina Saavedra Rendic">
                  </div>
                  <div class="about-author-info">
                    <div class="about-author-name">Martina Saavedra Rendic</div>
                    <div class="about-author-role">Médico Anestesiólogo</div>
                    <div class="about-author-role">Docente de Anestesiología UACh</div>      
                    <a class="about-link about-meta-link" href="martina.saavedra.rendic@gmail.com">martina.saavedra.rendic@gmail.com</a>
                  </div>
                </div>
              </div>

              <div class="about-meta-row about-author-row">
                <div class="about-meta-label">Revisor</div>
                <div class="about-author-card">
                  <div class="about-author-photo">
                    <img src="images/revisor-sebastian.jpg" alt="Sebastian Estrada Eguiguiren">
                  </div>
                  <div class="about-author-info">
                    <div class="about-author-name">Sebastián Estrada Eguiguiren</div>
                    <div class="about-author-role">Residente de Anestesiología UACh</div>      
                    <a class="about-link about-meta-link" href="seba.igee@gmail.com">seba.igee@gmail.com</a>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>


          <div class="about-card mb-3">
            <div class="p-4 text-center">
                <div class="col-12 col-lg-4 text-center">
                  <img src="images/IMG0001.jpeg" class="about-image" alt="Imagen App Anestesia UACh">
                </div> 
              <div class="mb-3 pt-2">
                <a class="about-link" href="https://app.anestesiauach.cl/">app.anestesiauach.cl</a>
              </div>

              <button id="button-compartir" class="btn btn-primary about-share not-overlay">Compartir  <i class="fa-solid fa-arrow-up-from-bracket"></i></button>

              <script>
                let shareData = {
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
  </div>
</div>

<?php
  require("footer.php");
?>
