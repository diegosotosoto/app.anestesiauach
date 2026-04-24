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
    $boton_toggler = "<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='--bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
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

<style>
.admin-card{
    background:#ffffff;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:20px;
    box-shadow:0 8px 24px rgba(0,0,0,.05);
}

.admin-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.admin-full{
    grid-column:1 / -1;
}

.admin-label{
    display:block;
    font-weight:600;
    margin-bottom:6px;
    color:#1f2937;
}

.admin-input,
.admin-select,
.admin-textarea{
    width:100%;
    padding:10px 12px;
    border:1px solid #d1d5db;
    border-radius:10px;
    box-sizing:border-box;
    background:#fff;
}

.admin-textarea{
    min-height:100px;
    resize:vertical;
}

.admin-catbox{
    border:1px solid #e5e7eb;
    border-radius:12px;
    padding:12px;
    margin-bottom:12px;
    background:#f8fafc;
}

.admin-catrow{
    display:grid;
    grid-template-columns:140px 1fr 200px 120px;
    gap:10px;
    align-items:center;
}

.admin-actions{
    margin-top:18px;
}

.admin-actions .btn{
    border-radius:10px;
}

.admin-help{
    color:#6b7280;
    font-size:.92rem;
}

@media (max-width: 900px){
    .admin-grid{
        grid-template-columns:1fr;
    }
    .admin-catrow{
        grid-template-columns:1fr;
    }
}
</style>

<div class="col col-sm-9 col-xl-9">
    <div class="container-fluid pt-3 pb-4">

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

        <div class="admin-card">
            <h3 class="mb-3">Administrador de Notas</h3>

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
                    <button class="btn btn-primary" type="submit">Guardar nota</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php
    require("footer.php");
?>