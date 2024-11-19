<?php
require '../partials/head.php';
require '../partials/nav.php';
include '../../db/Database.php';
include '../../db/Sintomas.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$sintoma = new Sintomas($db);

// Obtener el ID del síntoma desde la URL
$sintoma_id = $_GET['id'] ?? null;

if (!$sintoma_id) {
    // Redirigir si no hay ID válido
    header('Location: sintomas.view.php?msg=ID de síntoma inválido.');
    exit();
}

// Buscar los detalles del síntoma usando el método buscarRegistros
$detalles_sintoma = $sintoma->buscarRegistros('id', $sintoma_id);

if (!$detalles_sintoma || count($detalles_sintoma) == 0) {
    // Redirigir si no se encuentra el síntoma
    header('Location: sintomas.view.php?msg=Síntoma no encontrado.');
    exit();
}

// Extraer el primer (y único) resultado
$detalles_sintoma = $detalles_sintoma[0];
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Modificar Síntoma</h2>
    <form action="../../controllers/Admin/modificar_sintoma.php" method="post" id="modificarSintomaForm">
        <input type="hidden" name="id" value="<?= $sintoma_id; ?>">
        <input type="hidden" name="action" value="modificar">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre del Síntoma:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($detalles_sintoma['nombre']); ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
            <div class="form-group col-md-6">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?= htmlspecialchars($detalles_sintoma['descripcion']); ?></textarea>
            </div>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Guardar Cambios">
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
