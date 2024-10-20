<?php
require '../partials/head.php';
require '../partials/nav.php';
include '../../db/Database.php';
include '../../db/Servicios.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$servicio = new Servicios($db);

// Obtener el ID del servicio desde la URL
$servicio_id = $_GET['id'] ?? null;

if (!$servicio_id) {
    // Redirigir si no hay ID válido
    header('Location: servicios.view.php?msg=ID de servicio inválido.');
    exit();
}

// Buscar los detalles del servicio usando el método buscarRegistros
$detalles_servicio = $servicio->buscarRegistros('id', $servicio_id);

if (!$detalles_servicio || count($detalles_servicio) == 0) {
    // Redirigir si no se encuentra el servicio
    header('Location: servicios.view.php?msg=Servicio no encontrado.');
    exit();
}

// Extraer el primer (y único) resultado
$detalles_servicio = $detalles_servicio[0];
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Modificar Servicio</h2>
    <form action="../../controllers/Admin/modificar_servicio.php" method="post" id="modificarServicioForm">
        <input type="hidden" name="id" value="<?= $servicio_id; ?>">
        <input type="hidden" name="action" value="modificar">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre_s">Nombre del Servicio:</label>
                <input type="text" class="form-control" id="nombre_s" name="nombre_s" value="<?= htmlspecialchars($detalles_servicio['nombre_s']); ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
            <div class="form-group col-md-6">
                <label for="descripcion_s">Descripción:</label>
                <textarea class="form-control" id="descripcion_s" name="descripcion_s" required><?= htmlspecialchars($detalles_servicio['descripcion_s']); ?></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="equipamiento_s">Equipamiento:</label>
                <input type="text" class="form-control" id="equipamiento_s" name="equipamiento_s" value="<?= htmlspecialchars($detalles_servicio['equipamiento_s']); ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="costo_s">Costo:</label>
                <input type="number" class="form-control" id="costo_s" name="costo_s" value="<?= htmlspecialchars($detalles_servicio['costo_s']); ?>" required step="0.01" min="0">
            </div>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Guardar Cambios">
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
