<?php
require '../partials/head.php';
require '../partials/nav.php';
include '../../db/Database.php';
include '../../db/Medicina.php';
include '../../db/Sintomas.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$medicina = new Medicina($db);
$sintomasObj = new Sintomas($db);

// Obtener el ID de la medicina desde la URL
$medicina_id = $_GET['id'] ?? null;

if (!$medicina_id) {
    // Redirigir si no hay ID válido
    header('Location: medicina.view.php?msg=ID de medicina inválido.');
    exit();
}

// Buscar los detalles de la medicina usando el método buscarRegistros
$detalles_medicina = $medicina->obtenerMedicinas('id', $medicina_id);

if (!$detalles_medicina || count($detalles_medicina) == 0) {
    // Redirigir si no se encuentra la medicina
    header('Location: medicina.view.php?msg=Medicina no encontrada.');
    exit();
}

// Extraer el primer (y único) resultado
$detalles_medicina = $detalles_medicina[0];

// Obtener todos los síntomas disponibles
$sintomas = $sintomasObj->obtenerSintomas();

// Obtener los síntomas relacionados con la medicina actual
$sintomasRelacionados = $medicina->obtenerSintomasPorMedicina($medicina_id);
$sintomasRelacionadosIds = array_column($sintomasRelacionados, 'id');
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Modificar Medicina</h2>
    <form action="../../controllers/Admin/gestion_medicina.php" method="post" id="modificarMedicinaForm">
        <input type="hidden" name="id" value="<?= $medicina_id; ?>">
        <input type="hidden" name="action" value="modificar">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre de la Medicina:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($detalles_medicina['nombre']); ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
            <div class="form-group col-md-6">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?= htmlspecialchars($detalles_medicina['descripcion']); ?></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="costo">Costo:</label>
                <input type="number" class="form-control" id="costo" name="costo" value="<?= htmlspecialchars($detalles_medicina['costo']); ?>" required step="0.01" min="0">
            </div>
            <div class="form-group col-md-6">
                <label for="imagen">Imagen (URL):</label>
                <input type="text" class="form-control" id="imagen" name="imagen" value="<?= htmlspecialchars($detalles_medicina['imagen']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cantidad">Cantidad en Inventario:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?= htmlspecialchars($detalles_medicina['cantidad']); ?>" required min="0">
            </div>
        </div>

        <!-- Campo de selección para los síntomas (checkboxes) -->
       
        <div class="form-group">
            <label for="sintomas">Síntomas relacionados:</label>
         <div>
            <?php if (!empty($sintomas) && is_array($sintomas)): ?>
              <?php foreach ($sintomas as $sintoma): ?>
                  <label>
                       <input type="checkbox" name="sintomas[]" value="<?= htmlspecialchars($sintoma['id']); ?>" 
                           <?= in_array($sintoma['id'], $sintomasRelacionadosIds) ? 'checked' : ''; ?>>
                      <?= htmlspecialchars($sintoma['nombre']); ?>
                   </label><br>
              <?php endforeach; ?>
          <?php else: ?>
              <p>No hay síntomas registrados.</p>
         <?php endif; ?>
            <label>
            <a href="sintomas.view.php" class="btn btn-link">Registrar nuevo síntoma</a>
            </label><br>
         </div>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Guardar Cambios">
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
