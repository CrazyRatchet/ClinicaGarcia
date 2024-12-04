<?php
include '../../db/Database.php';
include '../../db/Pacientes.php';
include '../../db/Doctores.php';
include '../../db/Horarios.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);
$usuariosModel = new Doctores($db);
$horariosModel = new Horarios($db);

// Obtener la lista de pacientes
$pacientes = $pacientesModel->busquedaPacientesSeleccionados(); 

// Obtener la lista de médicos
$medicos = $usuariosModel->obtenerDoctoresSeleccionados(); 
?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-5">
    <h2 class="text-center mb-4">Agendar Cita</h2>

    <form id="agendarCitaForm" action="../../controllers/Citas/agendar_cita.php" method="post">
        <div class="form-group">
            <label for="paciente">Paciente:</label>
            <select class="form-control" id="paciente" name="paciente_id" required>
                <option value="" disabled selected>Selecciona un paciente</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?php echo $paciente['id']; ?>" data-email="<?php echo $paciente['correo']; ?>">
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
                    <option value="<?php echo $medico['id']; ?>">
                        <?php echo $medico['nombre'] . ' (' . $medico['especialidad'] . ')'; ?>
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

        <!-- Campo oculto para almacenar el correo del paciente -->
        <input type="hidden" id="paciente_email" name="paciente_email" value="">

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Agendar Cita</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cargar los horarios de trabajo de los médicos
    document.getElementById('medico').addEventListener('change', function() {
        const doctorId = this.value;
        const fecha = document.getElementById('fecha').value;

        if (doctorId && fecha) {
            fetch(`../../controllers/Citas/agendar_cita.php?doctor_id=${doctorId}&fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    const horaInput = document.getElementById('hora');
                    const availableHours = data.horarios;  // Esto es lo que recibimos de la respuesta JSON
                    let options = "<option value='' disabled selected>Selecciona una hora</option>";
                    
                    if (availableHours && availableHours.length > 0) {
                        // Si hay horarios disponibles, generamos las opciones
                        availableHours.forEach(hour => {
                            options += `<option value="${hour}">${hour}</option>`;
                        });
                    } else {
                        // Si no hay horarios disponibles
                        options = "<option value='' disabled>No hay horarios disponibles</option>";
                    }

                    horaInput.innerHTML = options;
                })
                .catch(error => {
                    console.error('Error al obtener horarios:', error);
                    const horaInput = document.getElementById('hora');
                    horaInput.innerHTML = "<option value='' disabled>Error al cargar horarios</option>";
                });
        } else {
            // Si no se ha seleccionado un médico o fecha, limpiamos las opciones de hora
            document.getElementById('hora').innerHTML = "<option value='' disabled>Selecciona un médico y una fecha</option>";
        }
    });

    // Obtener el correo electrónico del paciente cuando se selecciona
    document.getElementById('paciente').addEventListener('change', function() {
        const pacienteEmail = this.options[this.selectedIndex].getAttribute('data-email');
        document.getElementById('paciente_email').value = pacienteEmail;
    });

    // Mostrar mensajes de éxito o error
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
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    <?php endif; ?>
});
</script>
