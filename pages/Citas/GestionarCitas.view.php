<?php
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Asegura que el body ocupe toda la altura */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      flex: 1;
    }

    /* Estilo de la tarjeta */
    .card {
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Footer al final de la página */
    footer {
      margin-top: auto;
      padding: 20px 0;
      background-color: #f8f9fa;
      text-align: center;
    }
  </style>
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
                                <a href="../../pages/Citas/ModificarCitas.view.php?id=<?php echo $cita['id']; ?>" class="btn btn-warning">Modificar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require '../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['message'])): ?>
            const messageType = "<?php echo $_SESSION['message_type']; ?>";
            const message = "<?php echo $_SESSION['message']; ?>";
            Swal.fire({
                icon: messageType,
                title: messageType === 'success' ? 'Éxito' : 'Error',
                text: message,
                confirmButtonText: 'Aceptar'
            });
            <?php 
            // Destruir la sesión del mensaje después de mostrarlo
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
    });
</script>