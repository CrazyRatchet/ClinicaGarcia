<?php
include '../../db/Database.php';
include '../../db/Pacientes.php';
include '../../db/Usuarios.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);
$usuariosModel = new Usuarios($db);

// Obtener la lista de pacientes
$pacientes = $pacientesModel->busquedaPacientesSeleccionados(); // Método para obtener pacientes

// Obtener la lista de usuarios (médicos)
$medicos = $usuariosModel->busquedaUsuariosSeleccionados(); // Método para obtener médicos
?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Agendar Cita</h2>

    <form id="agendarCitaForm" action="../../controllers/Citas/agendar_cita.php" method="post">
        <div class="form-group">
            <label for="paciente">Paciente:</label>
            <select class="form-control" id="paciente" name="paciente_id" required>
                <option value="" disabled selected>Selecciona un paciente</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?php echo $paciente['id']; ?>">
                        <?php echo $paciente['nombre'] . ' - ' . $paciente['cedula']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="medico">Médico:</label>
            <select class="form-control" id="medico" name="doctor_id" required>
                <option value="" disabled selected>Selecciona un médico</option>
                <?php foreach ($medicos as $medico): ?>
                    <option value="<?php echo $medico['id_u']; ?>">
                        <?php echo $medico['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <div class="form-group">
            <label for="hora">Hora:</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Agendar Cita</button>
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
