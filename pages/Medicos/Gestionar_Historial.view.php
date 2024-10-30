<?php

include '../../db/Database.php';
include '../../db/Pacientes.php'; // Asegúrate de tener este archivo para manejar historias médicas

$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Obtener la lista de pacientes (asumiendo que hay un modelo para pacientes)
$pacientes = $pacientesModel->obtenerPacientes(); // Este método debe devolver todos los pacientes

?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gestionar Historial Médico</h2>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Paciente</th>
                        <th>Nombre Completo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $paciente): ?>
                        <tr>
                            <td><?php echo $paciente['id']; ?></td>
                            <td><?php echo $paciente['nombre']; ?></td>
                            <td>
                                <?php if ($pacientesModel->tieneHistorialMedico($paciente['id'])): ?>
                                    <a href="VerHistorial.view.php?id=<?php echo $paciente['id']; ?>" class="btn btn-info">Ver</a>
                                <?php else: ?>
                                    <a href="RegistrarHistorial.view.php?id=<?php echo $paciente['id']; ?>" class="btn btn-success">Registrar</a>
                                <?php endif; ?>
                                <a href="ModificarHistorial.view.php?id=<?php echo $paciente['id']; ?>" class="btn btn-warning">Modificar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require '../partials/footer.php'; ?>
