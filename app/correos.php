<?php

  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
  }

  $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar="<div class='text-white'>Correos</div>";
  $boton_navbar="<a></a><a></a>";

  require("head.php");

  $consulta_corr="SELECT * FROM `usuarios_dolor` WHERE `verified` = '1' ORDER BY `nombre_usuario` ASC";
  $busqueda_corr=$conexion->query($consulta_corr);
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">

        <style>
          .correos-shell{
            max-width:980px;
            margin:0 auto;
          }

          .correos-topbar{
            background:linear-gradient(135deg, #27458f, #3559b7);
            color:#fff;
            border-radius:1.25rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            padding:1.15rem 1.25rem;
          }

          .correos-topbar h1{
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

          .correo-search-card,
          .correo-disclaimer-card{
            border:0;
            border-radius:1rem;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            background:#fff;
          }

          .correo-search-input{
            min-height:56px;
            border-radius:1rem;
            border:1px solid #dfe7f2;
            font-size:1rem;
          }

          .correo-list{
            display:grid;
            gap:.75rem;
          }

          .correo-item{
            display:block;
            text-decoration:none;
            color:#1f2a37;
            background:#f8fafc;
            border:1px solid #dfe7f2;
            border-radius:1rem;
            padding:1rem 1rem;
            box-shadow:0 6px 18px rgba(33,55,98,.06);
            transition:transform .15s ease, box-shadow .15s ease, background-color .15s ease;
          }

          .correo-item:hover{
            transform:translateY(-1px);
            box-shadow:0 10px 22px rgba(33,55,98,.10);
            background:#ffffff;
            color:#1f2a37;
          }

          .correo-name{
            font-weight:700;
            margin-bottom:.2rem;
          }

          .correo-role{
            color:#5f6b76;
            margin-bottom:.2rem;
          }

          .correo-mail{
            color:#2453c6;
            word-break:break-word;
          }

          .correo-empty{
            color:#6c757d;
            text-align:center;
            padding:1rem;
          }

          .disclaimer-label{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#667085;
            margin-bottom:.55rem;
          }

          .disclaimer-box{
            border:1px solid #dfe7f2;
            border-radius:1rem;
            background:#f8fafc;
            padding:1rem;
            color:#5f6b76;
            line-height:1.55;
          }
        </style>

        <div class="correos-shell">

          <div class="correos-topbar mb-3">
            <div class="d-flex justify-content-between align-items-start gap-3">
              <div>
                <div class="small opacity-75 mb-1">APP clínica • directorio interno</div>
                <h1 class="h4 mb-2">Directorio de Correos</h1>
                <div class="subtle text-white-50">Busca por nombre, rol o correo electrónico.</div>
              </div>
              <span class="pill bg-light text-dark">UACh</span>
            </div>
          </div>

          <div class="correo-search-card mb-3">
            <div class="p-3 p-md-4">
              <div class="section-title mb-2">Buscar</div>
              <input type="text" class="form-control correo-search-input" id="search" placeholder="Buscar un nombre o correo...">
            </div>
          </div>

          <div class="correo-search-card mb-3">
            <div class="p-3 p-md-4">
              <div class="section-title mb-3">Resultados</div>
              <div class="correo-list" id="mytable">
                <?php
                while($fila=$busqueda_corr->fetch_assoc()){

                  if($fila['admin']=='1'){
                    $calidad='Administrador';
                  } elseif($fila['staff_']=='1'){
                    $calidad='Anestesiólog@';
                  } elseif($fila['becad_']=='1'){
                    $calidad='Becad@ Anestesia';
                  } elseif($fila['intern_']=='1'){
                    $calidad='Intern@';
                  } elseif($fila['becad_otro']=='1'){
                    $calidad='Becad@ Pasante';
                  } else {
                    $calidad='Usuario';
                  }

                  echo "<a class='correo-item correo-entry' href='mailto:".$fila['email_usuario']."'>
                          <div class='correo-name'>".$fila['nombre_usuario']."</div>
                          <div class='correo-role'>".$calidad."</div>
                          <div class='correo-mail'>".$fila['email_usuario']."</div>
                        </a>";
                }
                ?>
              </div>
              <div id="noResults" class="correo-empty d-none">No se encontraron coincidencias.</div>
            </div>
          </div>

          <div class="correo-disclaimer-card">
            <div class="p-3 p-md-4">
              <div class="disclaimer-label">Disclaimer</div>
              <div class="disclaimer-box">
                La información contenida en esta sección del directorio de correos y usuarios es confidencial y está destinada únicamente para uso interno del programa de formación de Anestesiología de la Universidad Austral de Chile. No se permite la divulgación o distribución de esta información a terceros sin el consentimiento expreso de los responsables del programa. Al acceder a esta sección, aceptas cumplir con estas condiciones y proteger la privacidad de los usuarios del programa.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $("#search").keyup(function(){
    const query = $(this).val().toLowerCase().trim();
    let visibleCount = 0;

    $.each($("#mytable .correo-entry"), function() {
      if($(this).text().toLowerCase().indexOf(query) === -1){
        $(this).hide();
      } else {
        $(this).show();
        visibleCount++;
      }
    });

    if (visibleCount === 0) {
      $("#noResults").removeClass("d-none");
    } else {
      $("#noResults").addClass("d-none");
    }
  });
});
</script>

<?php
  require("footer.php");
?>
