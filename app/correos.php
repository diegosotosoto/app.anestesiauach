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
            max-width:1100px;
            margin:0 auto;
          }

          .correos-hero{
            background:linear-gradient(135deg, #22439a 0%, #305fc7 100%);
            color:#fff;
            border-radius:1.35rem;
            box-shadow:0 12px 28px rgba(20,37,73,.10);
            padding:1.2rem 1.25rem;
          }

          .correos-hero h1{
            color:#fff;
            margin-bottom:.35rem;
          }

          .hero-kicker{
            font-size:.8rem;
            text-transform:uppercase;
            letter-spacing:.08em;
            opacity:.8;
            margin-bottom:.35rem;
          }

          .hero-subtitle{
            color:rgba(255,255,255,.82);
            font-size:.96rem;
          }

          .hero-badge{
            display:inline-flex;
            align-items:center;
            gap:.45rem;
            padding:.45rem .8rem;
            border-radius:999px;
            background:rgba(255,255,255,.14);
            color:#fff;
            font-size:.83rem;
            font-weight:700;
            border:1px solid rgba(255,255,255,.18);
            white-space:nowrap;
          }

          .correos-card,
          .correos-disclaimer-card{
            border:0;
            border-radius:1.15rem;
            box-shadow:0 10px 24px rgba(0,0,0,.06);
            background:#fff;
          }

          .search-toolbar{
            display:flex;
            flex-wrap:wrap;
            align-items:center;
            justify-content:space-between;
            gap:.75rem;
            margin-bottom:1rem;
          }

          .search-wrapper{
            position:relative;
            flex:1 1 460px;
          }

          .search-wrapper .search-icon{
            position:absolute;
            left:1rem;
            top:50%;
            transform:translateY(-50%);
            color:#6b7280;
            pointer-events:none;
          }

          .correo-search-input{
            min-height:58px;
            border-radius:1rem;
            border:1px solid #dfe7f2;
            font-size:1rem;
            padding-left:2.9rem;
            background:#fbfcfe;
          }

          .correo-search-input:focus{
            border-color:#4d75d5;
            box-shadow:0 0 0 .2rem rgba(77,117,213,.12);
            background:#fff;
          }

          .results-badge{
            display:inline-flex;
            align-items:center;
            gap:.45rem;
            padding:.55rem .85rem;
            border-radius:999px;
            background:#eef4ff;
            color:#284a9b;
            font-weight:700;
            font-size:.9rem;
          }

          .role-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));
            gap:1rem;
          }

          .role-section{
            border:1px solid #e5eaf3;
            border-radius:1rem;
            background:#fbfcfe;
            overflow:hidden;
          }

          .role-header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:.75rem;
            padding:.95rem 1rem;
            border-bottom:1px solid #e7edf7;
            background:#f6f9ff;
          }

          .role-title-wrap{
            display:flex;
            align-items:center;
            gap:.75rem;
            min-width:0;
          }

          .role-icon{
            width:42px;
            height:42px;
            border-radius:.9rem;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#e8f0ff;
            color:#2d58b8;
            font-size:1rem;
            flex:0 0 auto;
          }

          .role-title{
            font-weight:800;
            color:#1f2937;
            line-height:1.1;
          }

          .role-subtitle{
            font-size:.83rem;
            color:#6b7280;
            margin-top:.15rem;
          }

          .role-count{
            font-size:.82rem;
            font-weight:800;
            color:#3859a7;
            background:#e8f0ff;
            border-radius:999px;
            padding:.35rem .6rem;
            white-space:nowrap;
          }

          .correo-list{
            display:grid;
            gap:.8rem;
            padding:1rem;
          }

          .correo-item{
            display:block;
            text-decoration:none;
            color:#1f2a37;
            background:#fff;
            border:1px solid #dfe7f2;
            border-radius:1rem;
            padding:.95rem 1rem;
            box-shadow:0 6px 16px rgba(33,55,98,.05);
            transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
          }

          .correo-item:hover{
            transform:translateY(-1px);
            box-shadow:0 10px 22px rgba(33,55,98,.10);
            border-color:#cdd9ef;
            color:#1f2a37;
          }

          .correo-head{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:.75rem;
            margin-bottom:.25rem;
          }

          .correo-name{
            font-weight:800;
            color:#1f2937;
            line-height:1.2;
          }

          .correo-role-pill{
            display:inline-flex;
            align-items:center;
            padding:.3rem .55rem;
            border-radius:999px;
            background:#f2f5fb;
            color:#667085;
            font-size:.75rem;
            font-weight:700;
            white-space:nowrap;
          }

          .correo-mail{
            color:#2453c6;
            word-break:break-word;
            font-weight:600;
            margin-bottom:.18rem;
          }

          .correo-hint{
            color:#7b8794;
            font-size:.82rem;
          }

          .section-title{
            font-weight:800;
            color:#1f2937;
          }

          .section-subtitle{
            color:#6b7280;
            font-size:.92rem;
          }

          .correos-empty-global{
            text-align:center;
            padding:1.2rem;
            border:1px dashed #d8e0ed;
            border-radius:1rem;
            color:#6b7280;
            background:#fbfcfe;
          }

          .disclaimer-label{
            font-size:.82rem;
            text-transform:uppercase;
            letter-spacing:.05em;
            color:#667085;
            margin-bottom:.55rem;
            font-weight:800;
          }

          .disclaimer-box{
            border:1px solid #dfe7f2;
            border-radius:1rem;
            background:#f8fafc;
            padding:1rem;
            color:#5f6b76;
            line-height:1.6;
          }

          @media (max-width: 767.98px){
            .correos-hero{
              padding:1rem;
            }

            .correo-head,
            .role-header{
              flex-direction:column;
              align-items:flex-start;
            }

            .results-badge{
              width:100%;
              justify-content:center;
            }
          }
        </style>

        <div class="correos-shell">

          <div class="correos-hero mb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
              <div>
                <div class="hero-kicker">App clínica • directorio interno</div>
                <h1 class="h4">Directorio de correos</h1>
                <div class="hero-subtitle">Búsqueda rápida y ordenada por categoría de usuario para encontrar contactos de forma más clara.</div>
              </div>
              <div class="hero-badge"><i class="fa fa-envelope"></i> Universidad Austral de Chile</div>
            </div>
          </div>

          <div class="correos-card mb-3">
            <div class="p-3 p-md-4">
              <div class="search-toolbar">
                <div>
                  <div class="section-title">Buscar contacto</div>
                  <div class="section-subtitle">Puedes buscar por nombre, correo o categoría.</div>
                </div>
                <div class="results-badge"><i class="fa fa-users"></i> <span id="visibleResultsCount">0</span> resultados visibles</div>
              </div>

              <div class="search-wrapper">
                <i class="fa fa-search search-icon"></i>
                <input type="text" class="form-control correo-search-input" id="correoSearchInput" placeholder="Escribe un nombre, correo o rol...">
              </div>
            </div>
          </div>

          <div class="correos-card mb-3">
            <div class="p-3 p-md-4">
              <div class="search-toolbar mb-3">
                <div>
                  <div class="section-title">Resultados</div>
                  <div class="section-subtitle">Directorio agrupado para una navegación más limpia.</div>
                </div>
              </div>

              <div class="role-grid" id="correoDirectoryGrid">
                <?php

                  function h_nombre($v){
                    return htmlspecialchars(
                      html_entity_decode((string)$v, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                      ENT_QUOTES,
                      'UTF-8'
                    );
                  }

                  $grupos = array(
                    'Administrador' => array(
                      'icon' => 'fa fa-user-shield',
                      'subtitle' => 'Gestión y coordinación del sistema',
                      'items' => array()
                    ),
                    'Staff' => array(
                      'icon' => 'fa fa-user-doctor',
                      'subtitle' => 'Anestesiólogos y equipo docente',
                      'items' => array()
                    ),
                    'Becado' => array(
                      'icon' => 'fa fa-user-graduate',
                      'subtitle' => 'Residentes del programa de anestesiología',
                      'items' => array()
                    ),
                    'Interno' => array(
                      'icon' => 'fa fa-stethoscope',
                      'subtitle' => 'Internado y formación de pregrado',
                      'items' => array()
                    ),
                    'Becado Pasante' => array(
                      'icon' => 'fa fa-user-clock',
                      'subtitle' => 'Rotantes o pasantías externas',
                      'items' => array()
                    ),
                    'Otros' => array(
                      'icon' => 'fa fa-user',
                      'subtitle' => 'Otros usuarios verificados',
                      'items' => array()
                    )
                  );

                  while($fila=$busqueda_corr->fetch_assoc()){
                    if($fila['admin']=='1'){
                      $grupo='Administrador';
                      $calidad='Administrador';
                    } elseif($fila['staff_']=='1'){
                      $grupo='Staff';
                      $calidad='Staff';
                    } elseif($fila['becad_']=='1'){
                      $grupo='Becado';
                      $calidad='Becado';
                    } elseif($fila['intern_']=='1'){
                      $grupo='Interno';
                      $calidad='Interno';
                    } elseif($fila['becad_otro']=='1'){
                      $grupo='Becado Pasante';
                      $calidad='Becado Pasante';
                    } else {
                      $grupo='Otros';
                      $calidad='Usuario';
                    }

                    $nombre = h_nombre($fila['nombre_usuario']);
                    $email = htmlspecialchars($fila['email_usuario'], ENT_QUOTES, 'UTF-8');
                    $calidad_safe = htmlspecialchars($calidad, ENT_QUOTES, 'UTF-8');

                    $nombre_busqueda = htmlspecialchars(
                      mb_strtolower(html_entity_decode((string)$fila['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8'), 'UTF-8'),
                      ENT_QUOTES,
                      'UTF-8'
                    );

                    $grupos[$grupo]['items'][] = "<a class='correo-item correo-entry' data-role='".$calidad_safe."' data-name='".$nombre_busqueda."' href='mailto:".$email."'>

                        <div class='correo-head'>
                          <div class='correo-name'>".$nombre."</div>
                          <span class='correo-role-pill'>".$calidad_safe."</span>
                        </div>
                        <div class='correo-mail'>".$email."</div>
                        <div class='correo-hint'>Tocar para escribir correo</div>
                      </a>";
                  }

                  foreach($grupos as $nombreGrupo => $grupoData){
                    if(count($grupoData['items']) > 0){
                      $nombreGrupoSafe = htmlspecialchars($nombreGrupo, ENT_QUOTES, 'UTF-8');
                      $subtitleSafe = htmlspecialchars($grupoData['subtitle'], ENT_QUOTES, 'UTF-8');
                      echo "<section class='role-section correo-group' data-group='".$nombreGrupoSafe."'>
                              <div class='role-header'>
                                <div class='role-title-wrap'>
                                  <div class='role-icon'><i class='".$grupoData['icon']."'></i></div>
                                  <div>
                                    <div class='role-title'>".$nombreGrupoSafe."</div>
                                    <div class='role-subtitle'>".$subtitleSafe."</div>
                                  </div>
                                </div>
                                <div class='role-count'><span class='group-count'>".count($grupoData['items'])."</span> visibles</div>
                              </div>
                              <div class='correo-list'>".implode('', $grupoData['items'])."</div>
                            </section>";
                    }
                  }
                ?>
              </div>

              <div id="noResultsGlobal" class="correos-empty-global d-none">
                No se encontraron coincidencias con esa búsqueda.
              </div>
            </div>
          </div>

          <div class="correos-disclaimer-card">
            <div class="p-3 p-md-4">
              <div class="disclaimer-label">Uso interno</div>
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
  const $searchInput = $("#correoSearchInput");
  const $entries = $(".correo-entry");
  const $groups = $(".correo-group");
  const $globalNoResults = $("#noResultsGlobal");
  const $visibleResultsCount = $("#visibleResultsCount");

  function updateCorreoSearch(){
    const query = ($searchInput.val() || "").toLowerCase().trim();
    let totalVisible = 0;

    $groups.each(function(){
      const $group = $(this);
      let visibleInGroup = 0;

      $group.find('.correo-entry').each(function(){
        const text = (($(this).data('name') || '') + ' ' + $(this).text()).toLowerCase();
        const matches = query === '' || text.indexOf(query) !== -1;
        $(this).toggle(matches);
        if(matches){
          visibleInGroup++;
          totalVisible++;
        }
      });

      $group.toggle(visibleInGroup > 0);
      $group.find('.group-count').text(visibleInGroup);
    });

    $visibleResultsCount.text(totalVisible);
    $globalNoResults.toggleClass('d-none', totalVisible !== 0);
  }

  $searchInput.on('input keyup paste search', updateCorreoSearch);
  updateCorreoSearch();
});
</script>

<?php
  require("footer.php");
?>
