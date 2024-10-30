<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php';

$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Obtener el ID del historial médico de la URL
$historialId = $_GET['id'];

// Obtener el historial médico
$historial = $pacientesModel->obtenerHistorialPorId($historialId);

if (!$historial) {
    $_SESSION['message'] = "Historial no encontrado.";
    $_SESSION['message_type'] = "error";
    header("Location: GestionarHistorialMedico.view.php");
    exit();
}
?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Modificar Historial Médico</h2>

    <form action="procesar_historial.php" method="POST">
        <input type="hidden" name="historial_id" value="<?php echo $historial['id']; ?>">
        
        <div class="form-group">
            <label for="paciente_id">ID Paciente:</label>
            <input type="text" class="form-control" id="paciente_id" name="paciente_id" value="<?php echo $historial['paciente_id']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="nombre_completo">Nombre Completo:</label>
            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $historial['nombre_completo']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $historial['fecha_nacimiento']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="numero_identificacion">Número de Identificación:</label>
            <input type="text" class="form-control" id="numero_identificacion" name="numero_identificacion" value="<?php echo $historial['numero_identificacion']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $historial['direccion']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="numero_telefono">Número de Teléfono:</label>
            <input type="text" class="form-control" id="numero_telefono" name="numero_telefono" value="<?php echo $historial['numero_telefono']; ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="antecedentes_familiares">Antecedentes Familiares:</label>
            <input type="text" class="form-control" id="antecedentes_familiares" name="antecedentes_familiares" value="<?php echo $historial['antecedentes_familiares']; ?>" required>
        </div>

        <div class="form-group">
            <label for="medicamentos_actuales">Medicamentos Actuales:</label>
            <input type="text" class="form-control" id="medicamentos_actuales" name="medicamentos_actuales" value="<?php echo $historial['medicamentos_actuales']; ?>" required>
        </div>

        <div class="form-group">
            <label for="alergias">Alergias:</label>
            <input type="text" class="form-control" id="alergias" name="alergias" value="<?php echo $historial['alergias']; ?>" required>
        </div>

        <div class="form-group">
            <label for="historia_sintomas">Historia de Síntomas:</label>
            <textarea class="form-control" id="historia_sintomas" name="historia_sintomas" rows="3" required><?php echo $historial['historia_sintomas']; ?></textarea>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha de Registro:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $historial['fecha']; ?>" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-warning">Modificar</button>
            <a href="GestionarHistorialMedico.view.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
