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
    <h2 class="text-center mb-4">Detalles del Historial Médico</h2>

    <div class="card">
        <div class="card-body">
            <h5>ID Paciente: <?php echo $historial['paciente_id']; ?></h5>
            <h5>Nombre Completo: <?php echo $historial['nombre_completo']; ?></h5>
            <h5>Fecha de Nacimiento: <?php echo $historial['fecha_nacimiento']; ?></h5>
            <h5>Número de Identificación: <?php echo $historial['numero_identificacion']; ?></h5>
            <h5>Dirección: <?php echo $historial['direccion']; ?></h5>
            <h5>Número de Teléfono: <?php echo $historial['numero_telefono']; ?></h5>
            <h5>Antecedentes Familiares: <?php echo $historial['antecedentes_familiares']; ?></h5>
            <h5>Medicamentos Actuales: <?php echo $historial['medicamentos_actuales']; ?></h5>
            <h5>Alergias: <?php echo $historial['alergias']; ?></h5>
            <h5>Historia de Síntomas: <?php echo $historial['historia_sintomas']; ?></h5>
            <h5>Fecha de Registro: <?php echo $historial['fecha']; ?></h5>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="ModificarHistorial.view.php?id=<?php echo $historial['id']; ?>" class="btn btn-warning">Modificar</a>
        <a href="GestionarHistorialMedico.view.php" class="btn btn-secondary">Volver</a>
    </div>
</div>

<?php require '../partials/footer.php'; ?>
