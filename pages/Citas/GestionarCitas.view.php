<?php
session_start();
include '../../db/Database.php';
include '../../db/Citas.php';

$database = new Database();
$db = $database->getConnection();
$citasModel = new Citas($db);

// Obtener la lista de citas
$citas = $citasModel->obtenerCitas();
?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gestionar Citas</h2>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?php echo $cita['id']; ?></td>
                            <td><?php echo $cita['paciente']; ?></td>
                            <td><?php echo $cita['medico']; ?></td>
                            <td><?php echo $cita['fecha']; ?></td>
                            <td><?php echo $cita['hora']; ?></td>
                            <td>
                                <a href="modificar_cita.php?id=<?php echo $cita['id']; ?>" class="btn btn-warning">Modificar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require '../partials/footer.php'; ?>
