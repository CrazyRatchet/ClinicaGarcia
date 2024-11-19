<?php
require_once '../../db/Database.php';
require_once '../../db/Inventario.php';

$inventario = new Inventario();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];

    // Manejo de la imagen
    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaDestino = '../../assets/' . $nombreImagen; // Asegúrate de que esta carpeta exista
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nombreImagen;
        }
    }

    // Actualizar utensilio existente
    if ($id) {
        $inventario->actualizarUtensilio($id, $nombre, $descripcion, $costo, $imagen);
    }

    // Redirigir a la lista de utensilios
    header('Location: listarUtensilio.view.php');
    exit;
}

require '../partials/head.php';
require '../partials/nav.php';

$utensilio = null;

// Verificar si se recibió un ID por la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del utensilio por su ID
    $utensilio = $inventario->obtenerUtensilioPorId($id);
    
    // Verificar si se encontró el utensilio
    if (!$utensilio) {
        echo "<div class='alert alert-danger text-center'>El utensilio no existe.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger text-center'>ID inválido.</div>";
    exit;
}
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Editar Utensilio</h2>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $utensilio['id']; ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" 
                   value="<?php echo htmlspecialchars($utensilio['nombre']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo htmlspecialchars($utensilio['descripcion']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input type="number" step="0.01" class="form-control" id="costo" name="costo" 
                   value="<?php echo htmlspecialchars($utensilio['costo']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen (opcional)</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
            <?php if (!empty($utensilio['imagen'])): ?>
                <img src="../../assets/<?php echo htmlspecialchars($utensilio['imagen']); ?>" 
                     alt="Imagen de <?php echo htmlspecialchars($utensilio['nombre']); ?>" 
                     class="img-fluid mt-3" style="max-height: 150px;">
            <?php endif; ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Confirmar Edición</button>
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
