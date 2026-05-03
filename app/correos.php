<?php

  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
    header('Location: login.php');
  }

  $boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
  $titulo_navbar="<div class='text-white'>Correos</div>";
  $boton_navbar="<a></a><a></a>";

  require("head.php");

  $consulta_corr="SELECT * FROM `usuarios_dolor` WHERE `verified` = '1' ORDER BY `nombre_usuario` ASC";
  $busqueda_corr=$conexion->query($consulta_corr);

?>
<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="content-shell">

        <div class="correos-shell">

          <section class="app-hero app-hero-blue">
            <div class="app-hero-row">
              <div class="app-hero-body">
                <div class="app-hero-kicker">APP clínica • directorio interno</div>
                <h2>Directorio de correos</h2>
                <p>Búsqueda rápida y ordenada por categoría de usuario para encontrar contactos de forma más clara.</p>
              </div>
            </div>
          </section>

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
                    return function_exists('app_h_text') ? app_h_text($v) : htmlspecialchars(html_entity_decode((string)$v, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8');
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
                    $icono_usuario = app_render_user_inline_icon($fila);
                    $email = htmlspecialchars($fila['email_usuario'], ENT_QUOTES, 'UTF-8');
                    $calidad_safe = htmlspecialchars($calidad, ENT_QUOTES, 'UTF-8');
                    $calidad_chip = $calidad === 'Administrador' ? 'Admin' : $calidad;
                    $calidad_chip_safe = htmlspecialchars($calidad_chip, ENT_QUOTES, 'UTF-8');

                    $nombre_busqueda = htmlspecialchars(
                      mb_strtolower(function_exists('app_decode_text') ? app_decode_text($fila['nombre_usuario']) : html_entity_decode((string)$fila['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8'), 'UTF-8'),
                      ENT_QUOTES,
                      'UTF-8'
                    );

                    $grupos[$grupo]['items'][] = "<a class='correo-item correo-entry' data-role='".$calidad_safe."' data-name='".$nombre_busqueda."' href='mailto:".$email."'>

                        <div class='correo-head'>
                          <div class='correo-name'>".$icono_usuario.$nombre."</div>
                          <span class='correo-role-pill'>".$calidad_chip_safe."</span>
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

<style>
.correo-entry {
  text-align: left !important;
}

.correo-entry .correo-head {
  display: flex !important;
  flex-direction: row !important;
  align-items: center !important;
  justify-content: flex-start !important;
  gap: .65rem;
  width: 100%;
  text-align: left !important;
}

.correo-entry .correo-name {
  display: inline-flex !important;
  align-items: center !important;
  min-width: 0;
  font-size: 1.22rem;
  font-weight: 800;
  line-height: 1.15;
  text-align: left !important;
}

.correo-entry .correo-name .app-inline-user-icon {
  width: 40px !important;
  height: 40px !important;
  min-width: 40px !important;
  font-size: 1.05rem !important;
  margin-right: 12px !important;
}

.correo-entry .correo-role-pill {
  margin-left: 0;
  flex: 0 0 auto;
  white-space: nowrap;
}
</style>

<?php
  $conexion->close();
  require("footer.php");
?>
