<?php
    if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
        header('Location: login.php');
        exit;
    }

    // Conexión
    require("conectar.php");
    $conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
    $conexion->set_charset("utf8mb4");

    // Chequea privilegios de administrador
    $check_usuario = $_COOKIE['hkjh41lu4l1k23jhlkj13'];
    $con_users_b = "SELECT `admin` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' LIMIT 1";
    $users_b = $conexion->query($con_users_b);
    $usuario = $users_b ? $users_b->fetch_assoc() : null;

    if(!$usuario || $usuario['admin'] != 1){
        header('Location: login.php');
        exit;
    }

    // Variables navbar
    $boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
    $titulo_navbar = "<span class='text-white d-sm-block d-sm-none'>Gestión de Notas</span>";
    $boton_navbar = "<a></a><a></a>";

    // Carga Head de la página
    require("head.php");

    function slugify($texto) {
        $texto = trim($texto);
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
        $texto = strtolower($texto);
        $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
        $texto = trim($texto, '-');
        return $texto ?: 'nota';
    }

    $mensaje = '';
    $error = '';

    $categorias = [];
    $resCat = $conexion->query("SELECT id, nombre, slug FROM categorias_notas ORDER BY orden, nombre");
    if($resCat){
        while ($row = $resCat->fetch_assoc()) {
            $categorias[] = $row;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = trim($_POST['titulo'] ?? '');
        $archivo = trim($_POST['archivo'] ?? '');
        $resumen = trim($_POST['resumen'] ?? '');
        $estado = trim($_POST['estado'] ?? 'publicada');
        $categorias_seleccionadas = $_POST['categorias'] ?? [];
        $titulos_categoria = $_POST['titulo_categoria'] ?? [];
        $iconos_categoria = $_POST['icono_fa'] ?? [];
        $ordenes_categoria = $_POST['orden_categoria'] ?? [];

        if ($titulo === '' || $archivo === '') {
            $error = 'Título y archivo son obligatorios.';
        } else {
            $slug = slugify(pathinfo($archivo, PATHINFO_FILENAME));
            $ruta = 'apuntes/' . basename($archivo);

            $conexion->begin_transaction();

            try {
                $sqlNota = "INSERT INTO notas (titulo, slug, ruta, resumen, estado, published_at)
                            VALUES (?, ?, ?, ?, ?, NOW())
                            ON DUPLICATE KEY UPDATE
                                titulo = VALUES(titulo),
                                slug = VALUES(slug),
                                resumen = VALUES(resumen),
                                estado = VALUES(estado),
                                updated_at = NOW()";

                $stmtNota = $conexion->prepare($sqlNota);
                $stmtNota->bind_param("sssss", $titulo, $slug, $ruta, $resumen, $estado);
                $stmtNota->execute();
                $stmtNota->close();

                $stmtGet = $conexion->prepare("SELECT id FROM notas WHERE ruta = ? LIMIT 1");
                $stmtGet->bind_param("s", $ruta);
                $stmtGet->execute();
                $resGet = $stmtGet->get_result();
                $nota = $resGet->fetch_assoc();
                $nota_id = (int)$nota['id'];
                $stmtGet->close();

                $stmtDelete = $conexion->prepare("DELETE FROM nota_categorias WHERE nota_id = ?");
                $stmtDelete->bind_param("i", $nota_id);
                $stmtDelete->execute();
                $stmtDelete->close();

                if (!empty($categorias_seleccionadas)) {
                    $sqlRel = "INSERT INTO nota_categorias
                              (nota_id, categoria_id, orden, titulo_en_categoria, icono_fa)
                              VALUES (?, ?, ?, ?, ?)";
                    $stmtRel = $conexion->prepare($sqlRel);

                    foreach ($categorias_seleccionadas as $catId) {
                        $catId = (int)$catId;
                        $orden = isset($ordenes_categoria[$catId]) ? (int)$ordenes_categoria[$catId] : 0;
                        $tituloCat = trim($titulos_categoria[$catId] ?? '');
                        $iconoFa = trim($iconos_categoria[$catId] ?? '');

                        if ($tituloCat === '') {
                            $tituloCat = $titulo;
                        }

                        $stmtRel->bind_param("iiiss", $nota_id, $catId, $orden, $tituloCat, $iconoFa);
                        $stmtRel->execute();
                    }

                    $stmtRel->close();
                }

                $conexion->commit();
                $mensaje = "Nota guardada correctamente. Ruta registrada: {$ruta}";
            } catch (Throwable $e) {
                $conexion->rollback();
                $error = "Error guardando nota: " . $e->getMessage();
            }
        }
    }
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
    <main class="admin-page">

        <?php if($mensaje != ""){ ?>
            <div class='alert alert-success alert-dismissible fade show'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Info!</strong> <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php } ?>

        <?php if($error != ""){ ?>
            <div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Error:</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php } ?>

        <section class="app-hero app-hero-admin admin-header-card mb-3">
            <div class="app-hero-kicker">Administración</div>
            <h2>Administrador de Notas</h2>
            <p>Registra apuntes y notas en el catálogo visible de la app.</p>
            <span class="app-hero-pill">Solo administradores</span>
        </section>

        <div class="admin-card">
            <h3 class="mb-3">Nueva nota</h3>

            <form method="post">
                <div class="admin-grid">
                    <div>
                        <label class="admin-label">Título de la nota</label>
                        <input class="admin-input" type="text" name="titulo" required>
                    </div>

                    <div>
                        <label class="admin-label">Archivo PHP</label>
                        <input class="admin-input" type="text" name="archivo" placeholder="ej: hipoglicemia.php" required>
                    </div>

                    <div>
                        <label class="admin-label">Estado</label>
                        <select class="admin-select" name="estado">
                            <option value="publicada">Publicada</option>
                            <option value="borrador">Borrador</option>
                            <option value="archivada">Archivada</option>
                        </select>
                    </div>

                    <div>
                        <label class="admin-label">Resumen</label>
                        <input class="admin-input" type="text" name="resumen">
                    </div>

                    <div class="admin-full">
                        <label class="admin-label">Categorías</label>
                        <div class="admin-help">Marca las categorías y define título visible, icono Font Awesome y orden dentro de cada una.</div>
                    </div>

                    <div class="admin-full">
                        <?php foreach ($categorias as $cat): ?>
                            <div class="admin-catbox">
                                <div class="admin-catrow">
                                    <div>
                                        <label class="admin-label mb-0">
                                            <input type="checkbox" name="categorias[]" value="<?= (int)$cat['id'] ?>">
                                            <?= htmlspecialchars($cat['nombre']) ?>
                                        </label>
                                    </div>

                                    <div>
                                        <label class="admin-label">Título en categoría</label>
                                        <input class="admin-input" type="text" name="titulo_categoria[<?= (int)$cat['id'] ?>]" placeholder="Opcional">
                                    </div>

                                    <div>
                                        <label class="admin-label">Icono FA</label>
                                        <input class="admin-input" type="text" name="icono_fa[<?= (int)$cat['id'] ?>]" placeholder="fa-solid fa-file-lines">
                                    </div>

                                    <div>
                                        <label class="admin-label">Orden</label>
                                        <input class="admin-input" type="text" name="orden_categoria[<?= (int)$cat['id'] ?>]" value="0">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="admin-actions">
                    <button class="btn btn-app-primary" type="submit">Guardar nota</button>
                </div>
            </form>
        </div>

    </main>
</div>

<?php
    require("footer.php");
?>
