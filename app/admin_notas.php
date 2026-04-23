<?php
if (!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])) {
    header('Location: login.php');
    exit;
}

require("conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8mb4");

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
$resCat = $conexion->query("SELECT id, nombre, slug FROM anestes1_hoja_dolor.categorias_notas ORDER BY orden, nombre");
while ($row = $resCat->fetch_assoc()) {
    $categorias[] = $row;
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
            $sqlNota = "INSERT INTO anestes1_hoja_dolor.notas (titulo, slug, ruta, resumen, estado, published_at)
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

            $stmtGet = $conexion->prepare("SELECT id FROM anestes1_hoja_dolor.notas WHERE ruta = ? LIMIT 1");
            $stmtGet->bind_param("s", $ruta);
            $stmtGet->execute();
            $resGet = $stmtGet->get_result();
            $nota = $resGet->fetch_assoc();
            $nota_id = (int)$nota['id'];
            $stmtGet->close();

            $stmtDelete = $conexion->prepare("DELETE FROM anestes1_hoja_dolor.nota_categorias WHERE nota_id = ?");
            $stmtDelete->bind_param("i", $nota_id);
            $stmtDelete->execute();
            $stmtDelete->close();

            if (!empty($categorias_seleccionadas)) {
                $sqlRel = "INSERT INTO anestes1_hoja_dolor.nota_categorias
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
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Administrador de Notas</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:Arial,sans-serif;background:#f5f7fb;margin:0;padding:24px;color:#1f2937}
.wrap{max-width:980px;margin:0 auto;background:#fff;border-radius:16px;padding:24px;box-shadow:0 8px 24px rgba(0,0,0,.08)}
h1{margin-top:0}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.full{grid-column:1/-1}
label{display:block;font-weight:600;margin-bottom:6px}
input[type=text], textarea, select{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:10px;box-sizing:border-box}
textarea{min-height:100px}
.catbox{border:1px solid #e5e7eb;border-radius:12px;padding:12px;margin-bottom:12px;background:#f9fafb}
.row{display:grid;grid-template-columns:120px 1fr 180px 120px;gap:10px;align-items:center}
.actions{margin-top:18px}
button{background:#1d4ed8;color:#fff;border:none;padding:12px 18px;border-radius:10px;cursor:pointer}
.ok{background:#ecfdf5;color:#065f46;padding:12px;border-radius:10px;margin-bottom:14px}
.err{background:#fef2f2;color:#991b1b;padding:12px;border-radius:10px;margin-bottom:14px}
small{color:#6b7280}
</style>
</head>
<body>
<div class="wrap">
    <h1>Administrador de Notas</h1>

    <?php if ($mensaje): ?><div class="ok"><?= htmlspecialchars($mensaje) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="post">
        <div class="grid">
            <div>
                <label>Título de la nota</label>
                <input type="text" name="titulo" required>
            </div>

            <div>
                <label>Archivo PHP</label>
                <input type="text" name="archivo" placeholder="ej: hipoglicemia.php" required>
            </div>

            <div>
                <label>Estado</label>
                <select name="estado">
                    <option value="publicada">Publicada</option>
                    <option value="borrador">Borrador</option>
                    <option value="archivada">Archivada</option>
                </select>
            </div>

            <div>
                <label>Resumen</label>
                <input type="text" name="resumen">
            </div>

            <div class="full">
                <label>Categorías</label>
                <small>Marca las categorías y define título visible, icono Font Awesome y orden dentro de cada una.</small>
            </div>

            <div class="full">
                <?php foreach ($categorias as $cat): ?>
                    <div class="catbox">
                        <div class="row">
                            <div>
                                <label>
                                    <input type="checkbox" name="categorias[]" value="<?= (int)$cat['id'] ?>">
                                    <?= htmlspecialchars($cat['nombre']) ?>
                                </label>
                            </div>
                            <div>
                                <label>Título en categoría</label>
                                <input type="text" name="titulo_categoria[<?= (int)$cat['id'] ?>]" placeholder="Opcional">
                            </div>
                            <div>
                                <label>Icono FA</label>
                                <input type="text" name="icono_fa[<?= (int)$cat['id'] ?>]" placeholder="fa-solid fa-file-lines">
                            </div>
                            <div>
                                <label>Orden</label>
                                <input type="text" name="orden_categoria[<?= (int)$cat['id'] ?>]" value="0">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="actions">
            <button type="submit">Guardar nota</button>
        </div>
    </form>
</div>
</body>
</html>