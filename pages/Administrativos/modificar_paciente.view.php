<?php
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Cargar el paciente a modificar
$pacienteId = $_GET['id'] ?? null;
if (!$pacienteId) {
    echo "Error: No se especificó el ID del paciente.";
    exit();
}

// Cargar los datos del paciente
$query = "SELECT * FROM pacientes WHERE id = :id"; // Corregido nombre de tabla de pacientes
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $pacienteId);
$stmt->execute();
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    echo "Error: Paciente no encontrado.";
    exit();
}
?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Modificar Paciente</h2>
    <form action="../../controllers/Admin/modificar_paciente.php" method="post" id="modificarPacienteForm">
        <input type="hidden" name="id" value="<?php echo $pacienteId; ?>">

        <!-- Datos del paciente -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $paciente['nombre']; ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>

            <div class="form-group col-md-6">
                <label for="cedula">Cédula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $paciente['cedula']; ?>" required pattern="^\d{1,2}-\d{4}-\d{4}$" title="Formato: X-XXXX-XXXX, donde X es un dígito.">
            </div>
        </div>

        <!-- Botón para modificar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Modificar Paciente</button>
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
