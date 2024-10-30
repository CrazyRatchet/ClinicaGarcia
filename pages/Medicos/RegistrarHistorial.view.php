<?php
include '../../db/Database.php';
include '../../db/Pacientes.php';

$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Obtener el ID del paciente de la URL
$pacienteId = $_GET['id'];

// Obtener los datos del paciente
$paciente = $pacientesModel->obtenerPacientePorId($pacienteId);

if (!$paciente) {
    $_SESSION['message'] = "Paciente no encontrado.";
    $_SESSION['message_type'] = "error";
    header("Location: GestionarHistorialMedico.view.php");
    exit();
}
?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Registrar Historial Médico para <?php echo $paciente['nombre']; ?></h2>

    <form action="registrar_historial.php" method="POST">
        <input type="hidden" name="paciente_id" value="<?php echo $pacienteId; ?>">
        
        <div class="form-group">
            <label for="nombre_completo">Nombre Completo:</label>
            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $paciente['nombre']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $paciente['fecha_nacimiento']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="numero_identificacion">Número de Identificación:</label>
            <input type="text" class="form-control" id="numero_identificacion" name="numero_identificacion" value="<?php echo $paciente['numero_identificacion']; ?>" required >
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $paciente['direccion']; ?>" required >
        </div>

        <div class="form-group">
            <label for="numero_telefono">Número de Teléfono:</label>
            <input type="text" class="form-control" id="numero_telefono" name="numero_telefono" value="<?php echo $paciente['telefono']; ?>" required >
        </div>

        <div class="form-group">
            <label for="antecedentes_familiares">Antecedentes Familiares:</label>
            <input type="text" class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" required>
        </div>

        <div class="form-group">
            <label for="medicamentos_actuales">Medicamentos Actuales:</label>
            <input type="text" class="form-control" id="medicamentos_actuales" name="medicamentos_actuales" required>
        </div>

        <div class="form-group">
            <label for="alergias">Alergias:</label>
            <input type="text" class="form-control" id="alergias" name="alergias" required>
        </div>

        <div class="form-group">
            <label for="historia_sintomas">Historia de Síntomas:</label>
            <textarea class="form-control" id="historia_sintomas" name="historia_sintomas" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha de Registro:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Registrar</button>
            <a href="GestionarHistorialMedico.view.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
