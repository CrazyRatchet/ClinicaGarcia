<?php
require '../partials/head.php';
require '../partials/nav.php';
include '../../db/Database.php';
include '../../db/Especialidades.php'; // Asegúrate de que esta clase esté definida y funcione adecuadamente

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$especialidad = new Especialidades($db); // Instancia de la clase Especialidades

// Obtener el ID de la especialidad desde la URL
$especialidad_id = $_GET['id'] ?? null;

if (!$especialidad_id) {
    // Redirigir si no hay ID válido
    header('Location: especialidades.view.php?msg=ID de especialidad inválido.');
    exit();
}

// Buscar los detalles de la especialidad usando el método buscarRegistros
$detalles_especialidad = $especialidad->buscarRegistros('id', $especialidad_id);

if (!$detalles_especialidad || count($detalles_especialidad) == 0) {
    // Redirigir si no se encuentra la especialidad
    header('Location: especialidades.view.php?msg=Especialidad no encontrada.');
    exit();
}

// Extraer el primer (y único) resultado
$detalles_especialidad = $detalles_especialidad[0];
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Modificar Especialidad</h2>
    <form action="../../controllers/Admin/modificar_especialidad.php" method="post" id="modificarEspecialidadForm">
        <input type="hidden" name="id" value="<?= $especialidad_id; ?>">
        <input type="hidden" name="action" value="modificar">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre_e">Nombre de la Especialidad:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($detalles_especialidad['nombre']); ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
            <div class="form-group col-md-6">
                <label for="descripcion_e">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?= htmlspecialchars($detalles_especialidad['descripcion']); ?></textarea>
            </div>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Guardar Cambios">
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
