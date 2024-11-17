<?php
require '../partials/head.php';
require '../partials/nav.php';
require_once '../../db/Database.php';
require_once '../../db/Inventario.php';

// Inicializar la clase Inventario
$inventario = new Inventario();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];

    // Manejo de la imagen
    $imagen = 'logo.png'; // Imagen por defecto para pruebas
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaDestino = '../../assets/' . $nombreImagen; // Cambia a tu carpeta assets/
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nombreImagen; // Usar la imagen cargada si se sube con éxito
        }
    }

    // Registrar el nuevo utensilio
    $resultado = $inventario->registrarUtensilio($imagen, $nombre, $descripcion, $costo);

    if ($resultado) {
        $mensaje = "<div class='alert alert-success'>¡Utensilio registrado con éxito!</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al registrar el utensilio.</div>";
    }
}
?>

<div class="container my-5">
    <h2 class="text-center">Registrar Nuevo Utensilio</h2>
    
    <?php if ($mensaje) echo $mensaje; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="mt-4">

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input type="number" step="0.01" class="form-control" id="costo" name="costo" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
