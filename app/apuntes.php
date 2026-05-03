<?php

// Validador login temporal por cookie

if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])) {

    header('Location: login.php');

    exit;

}

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";

$titulo_navbar = "<div class='text-white'>Cálculos y Apuntes</div>";

$boton_navbar = "<a></a><a></a>";

require("head.php");

?>
<?php

/*

  Resolver usuario actual desde cookie de email

*/

$usuario_id = 0;

if (isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) && $_COOKIE['hkjh41lu4l1k23jhlkj13'] !== '') {

    $email_usuario_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

    $sql_usuario = "SELECT ID

                    FROM anestes1_hoja_dolor.usuarios_dolor

                    WHERE email_usuario = ?

                      AND verified = 1

                    LIMIT 1";

    $stmt_usuario = $conexion->prepare($sql_usuario);

    if ($stmt_usuario) {

        $stmt_usuario->bind_param("s", $email_usuario_cookie);

        $stmt_usuario->execute();

        $res_usuario = $stmt_usuario->get_result();

        if ($fila_usuario = $res_usuario->fetch_assoc()) {

            $usuario_id = (int)$fila_usuario['ID'];

        }

        $stmt_usuario->close();

    }

}

/*

  Query principal:

  - categorías

  - notas

  - favorito por usuario

  - badge New por usuario

*/

$sql_apuntes = "

SELECT 

    c.id AS categoria_id,

    c.nombre AS categoria_nombre,

    c.slug AS categoria_slug,

    c.icono AS categoria_icono,

    c.es_emergencia,

    n.id AS nota_id,

    n.ruta,

    n.slug AS nota_slug,

    COALESCE(nc.titulo_en_categoria, n.titulo) AS titulo,

    nc.icono_fa,

    COALESCE(un.es_favorita, 0) AS es_favorita,

    CASE 

        WHEN un.vista_at IS NULL THEN 1

        WHEN n.updated_at > un.vista_at THEN 1

        ELSE 0

    END AS es_nueva

FROM anestes1_hoja_dolor.categorias_notas c

LEFT JOIN anestes1_hoja_dolor.nota_categorias nc

    ON nc.categoria_id = c.id

LEFT JOIN anestes1_hoja_dolor.notas n

    ON n.id = nc.nota_id

    AND n.estado = 'publicada'

LEFT JOIN anestes1_hoja_dolor.usuario_notas un

    ON un.nota_id = n.id

    AND un.usuario_id = ?

ORDER BY 

    c.orden ASC,

    nc.orden ASC,

    titulo ASC

";

$stmt_apuntes = $conexion->prepare($sql_apuntes);

$stmt_apuntes->bind_param("i", $usuario_id);

$stmt_apuntes->execute();

$res_apuntes = $stmt_apuntes->get_result();

$categorias = [];

$favoritos = [];

while ($row = $res_apuntes->fetch_assoc()) {

    $catId = (int)$row['categoria_id'];

    if (!isset($categorias[$catId])) {

        $categorias[$catId] = [

            'id' => $catId,

            'nombre' => $row['categoria_nombre'],

            'slug' => $row['categoria_slug'],

            'icono' => $row['categoria_icono'],

            'es_emergencia' => (int)$row['es_emergencia'],

            'notas' => []

        ];

    }

    if (!empty($row['nota_id'])) {

        $nota = [

            'nota_id' => (int)$row['nota_id'],

            'titulo' => $row['titulo'],

            'ruta' => $row['ruta'],

            'icono_fa' => $row['icono_fa'] ?: 'fa-solid fa-file-lines',

            'es_favorita' => (int)$row['es_favorita'],

            'es_nueva' => (int)$row['es_nueva']

        ];

        $categorias[$catId]['notas'][] = $nota;

        if ($nota['es_favorita'] === 1 && !isset($favoritos[$nota['nota_id']])) {

            $favoritos[$nota['nota_id']] = $nota;

        }

    }

}

$stmt_apuntes->close();

?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="apuntes-shell">
        <section class="app-hero app-hero-blue">
          <div class="app-hero-row">
            <div class="app-hero-body">
              <div class="app-hero-kicker">APP clínica • recursos y cálculos</div>
              <h2>Sección de Apuntes y Cálculos</h2>
              <p>Acceso rápido a escalas, scores, buscadores, checklists y utilidades clínicas.</p>
            </div>
          </div>
        </section>
        <div class="accordion apuntes-accordion" id="accordionApuntes">
          <div class="accordion-item apuntes-standard" id="favoritosAccordionItem" <?= empty($favoritos) ? 'style="display:none;"' : '' ?>>

<h2 class="accordion-header" id="headingFavoritos">
  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFavoritos" aria-expanded="true" aria-controls="#collapseFavoritos">
    <span class="apuntes-icon d-inline-flex align-items-center justify-content-center">
      <i class="fa-solid fa-star text-warning" style="font-size: 30px;"></i>
    </span>
    Favoritos
  </button>
</h2>

<div id="collapseFavoritos" class="accordion-collapse collapse show" aria-labelledby="headingFavoritos">
              <div class="accordion-body">
                <div class="apuntes-list" id="favoritosContainer">
                  <?php foreach ($favoritos as $nota): ?>
                    <div class="apuntes-link favorito-item" data-nota-id="<?= (int)$nota['nota_id'] ?>">
<a href="<?= htmlspecialchars($nota['ruta']) ?>" class="apuntes-link-main" data-nota-id="<?= (int)$nota['nota_id'] ?>">
                        <span class="apunte-icon-circle"><i class="<?= htmlspecialchars($nota['icono_fa']) ?>"></i></span>
                        <span class="apunte-title"><?= htmlspecialchars($nota['titulo']) ?></span>
                      </a>
                      <span class="apunte-meta">

<?php if ($nota['es_nueva']): ?>
  <span class="apunte-badge-new" data-nota-id="<?= (int)$nota['nota_id'] ?>">New</span>
<?php endif; ?>

                        <button
                          type="button"
                          class="apunte-fav-btn is-active"
                          data-nota-id="<?= (int)$nota['nota_id'] ?>"
                          data-titulo="<?= htmlspecialchars($nota['titulo'], ENT_QUOTES) ?>"
                          data-ruta="<?= htmlspecialchars($nota['ruta'], ENT_QUOTES) ?>"
                          data-icono="<?= htmlspecialchars($nota['icono_fa'], ENT_QUOTES) ?>"
                          data-new="<?= (int)$nota['es_nueva'] ?>"
                          aria-label="Toggle favorito"
                          title="Favorito"
                        >

                          <i class="fa-solid fa-star"></i>
                        </button>
                      </span>
                    </div>

                  <?php endforeach; ?>

                </div>

              </div>

            </div>

          </div>

          <?php

          $i = 0;

          foreach ($categorias as $categoria):

            $headingId = "heading".$i;

            $collapseId = "collapse".$i;

            $itemClass = $categoria['es_emergencia'] ? 'apuntes-emergency' : 'apuntes-standard';

            $tituloCategoria = $categoria['es_emergencia'] ? strtoupper($categoria['nombre']) : $categoria['nombre'];

          ?>

            <div class="accordion-item <?= $itemClass ?>">

              <h2 class="accordion-header" id="<?= $headingId ?>">

                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">

                  <img

                    src="<?= htmlspecialchars($categoria['icono']) ?>"

                    class="apuntes-icon"

                    <?= $categoria['es_emergencia'] ? "style='filter: drop-shadow(0 0 0 black) drop-shadow(1px 0 0 black) drop-shadow(-1px 0 0 black) drop-shadow(0 1px 0 black) drop-shadow(0 -1px 0 black);'" : "" ?>

                  />

                  <?= htmlspecialchars($tituloCategoria) ?>

                </button>

              </h2>

              <div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="<?= $headingId ?>">

                <div class="accordion-body">

                  <?php if (!empty($categoria['notas'])): ?>

                    <div class="apuntes-list">

                      <?php foreach ($categoria['notas'] as $nota): ?>

                        <div class="apuntes-link">

<a href="<?= htmlspecialchars($nota['ruta']) ?>" class="apuntes-link-main" data-nota-id="<?= (int)$nota['nota_id'] ?>">

                            <span class="apunte-icon-circle"><i class="<?= htmlspecialchars($nota['icono_fa']) ?>"></i></span>

                            <span class="apunte-title"><?= htmlspecialchars($nota['titulo']) ?></span>

                          </a>

                          <span class="apunte-meta">

<?php if ($nota['es_nueva']): ?>

  <span class="apunte-badge-new" data-nota-id="<?= (int)$nota['nota_id'] ?>">New</span>

<?php endif; ?>

                            <button

                              type="button"

                              class="apunte-fav-btn <?= $nota['es_favorita'] ? 'is-active' : '' ?>"

                              data-nota-id="<?= (int)$nota['nota_id'] ?>"

                              data-titulo="<?= htmlspecialchars($nota['titulo'], ENT_QUOTES) ?>"

                              data-ruta="<?= htmlspecialchars($nota['ruta'], ENT_QUOTES) ?>"

                              data-icono="<?= htmlspecialchars($nota['icono_fa'], ENT_QUOTES) ?>"

                              data-new="<?= (int)$nota['es_nueva'] ?>"

                              aria-label="Toggle favorito"

                              title="Favorito"

                            >

                              <i class="<?= $nota['es_favorita'] ? 'fa-solid' : 'fa-regular' ?> fa-star"></i>

                            </button>

                          </span>

                        </div>

                      <?php endforeach; ?>

                    </div>

                  <?php else: ?>

                    <div class="apuntes-empty">No hay recursos disponibles aún en esta sección.</div>

                  <?php endif; ?>

                </div>

              </div>

            </div>

          <?php

            $i++;

          endforeach;

          ?>

        </div>

      </div>

    </div>

  </div>

</div>

<script>

document.addEventListener('click', async function(e) {

  const btn = e.target.closest('.apunte-fav-btn');

  if (!btn) return;

  e.preventDefault();

  e.stopPropagation();

  const notaId = btn.dataset.notaId;

  const titulo = btn.dataset.titulo;

  const ruta = btn.dataset.ruta;

  const icono = btn.dataset.icono || 'fa-solid fa-file-lines';

  const isNew = btn.dataset.new === '1';

  if (!notaId) return;

  btn.disabled = true;

  try {

    const body = new URLSearchParams();

    body.append('nota_id', notaId);

    const response = await fetch('toggle_favorito.php', {

      method: 'POST',

      headers: {

        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'

      },

      body: body.toString()

    });

    const data = await response.json();

    if (!data.ok) {

      alert(data.message || 'No se pudo actualizar favorito');

      btn.disabled = false;

      return;

    }

    const activa = Number(data.es_favorita) === 1;

    document.querySelectorAll('.apunte-fav-btn[data-nota-id="' + notaId + '"]').forEach(function(b) {

      b.classList.toggle('is-active', activa);

      const icon = b.querySelector('i');

      if (icon) {

        icon.classList.remove('fa-solid', 'fa-regular');

        icon.classList.add(activa ? 'fa-solid' : 'fa-regular', 'fa-star');

      }

    });

    const favoritosAccordionItem = document.getElementById('favoritosAccordionItem');

    const favoritosContainer = document.getElementById('favoritosContainer');

    const favoritoExistente = favoritosContainer.querySelector('.favorito-item[data-nota-id="' + notaId + '"]');

    if (activa) {

      if (!favoritoExistente) {

        const item = document.createElement('div');

        item.className = 'apuntes-link favorito-item';

        item.dataset.notaId = notaId;

        let badgeNew = '';

        if (isNew) {

badgeNew = '<span class="apunte-badge-new" data-nota-id="' + escapeAttr(notaId) + '">New</span>';

        }

        item.innerHTML = `

<a href="${escapeAttr(ruta)}" class="apuntes-link-main" data-nota-id="${escapeAttr(notaId)}">

            <span class="apunte-icon-circle"><i class="${escapeAttr(icono)}"></i></span>

            <span class="apunte-title">${escapeHtml(titulo)}</span>

          </a>

          <span class="apunte-meta">

            ${badgeNew}

            <button

              type="button"

              class="apunte-fav-btn is-active"

              data-nota-id="${escapeAttr(notaId)}"

              data-titulo="${escapeAttr(titulo)}"

              data-ruta="${escapeAttr(ruta)}"

              data-icono="${escapeAttr(icono)}"

              data-new="${isNew ? '1' : '0'}"

              aria-label="Toggle favorito"

              title="Favorito"

            >

              <i class="fa-solid fa-star"></i>

            </button>

          </span>

        `;

        favoritosContainer.appendChild(item);

      }

      favoritosAccordionItem.style.display = '';

    } else {

      if (favoritoExistente) {

        favoritoExistente.remove();

      }

      if (!favoritosContainer.querySelector('.favorito-item')) {

        favoritosAccordionItem.style.display = 'none';

      }

    }

  } catch (error) {

    alert('Error de red al actualizar favorito');

  } finally {

    btn.disabled = false;

  }

});

function escapeHtml(str) {

  return String(str)

    .replaceAll('&', '&amp;')

    .replaceAll('<', '&lt;')

    .replaceAll('>', '&gt;')

    .replaceAll('"', '&quot;')

    .replaceAll("'", '&#039;');

}

function escapeAttr(str) {

  return escapeHtml(str);

}

</script>
<script>
document.addEventListener('click', function(e) {
  const link = e.target.closest('.apuntes-link-main[data-nota-id]');
  if (!link) return;

  const notaId = link.dataset.notaId;
  if (!notaId) return;

  const body = new URLSearchParams();
  body.append('nota_id', notaId);

  if (navigator.sendBeacon) {
    const blob = new Blob([body.toString()], {
      type: 'application/x-www-form-urlencoded; charset=UTF-8'
    });
    navigator.sendBeacon('marcar_vista_ajax.php', blob);
  } else {
    fetch('marcar_vista_ajax.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
      },
      body: body.toString(),
      keepalive: true
    }).catch(() => {});
  }

  // quitar badge New inmediatamente en todas las apariciones visibles
  document.querySelectorAll('.apunte-badge-new[data-nota-id="' + notaId + '"]').forEach(function(badge) {
    badge.remove();
  });

  // actualizar dataset para favoritos futuros
  document.querySelectorAll('.apunte-fav-btn[data-nota-id="' + notaId + '"]').forEach(function(btn) {
    btn.dataset.new = '0';
  });
});
</script>

<?php

$conexion->close();

require("footer.php");

?>
