<?php
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Obtener la lista de pacientes
$pacientes = $pacientesModel->busquedaPacientesSeleccionados(); // Suponiendo que tienes un método que obtiene todos los pacientes

?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gestionar Pacientes</h2>

    <div class="row">
        <div class="col-md-6">
            <h4>Lista de Pacientes</h4>
            <div id="pacientesList" class="list-group">
                <?php foreach ($pacientes as $paciente): ?>
                    <a href="#" class="list-group-item list-group-item-action" data-id="<?php echo $paciente['id']; ?>" onclick="cargarDatosMedicos(<?php echo $paciente['id']; ?>)">
                        <?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['cedula']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6">
            <h4>Registrar/Modificar Datos Médicos</h4>
            <div id="datosMedicosContainer" style="display:none;">
                <form id="datosMedicosForm" action="../../controllers/Medicos/registrar_datos_medicos.php" method="post">
                    <input type="hidden" name="id" id="pacienteId">

                    <div class="form-group">
                        <label for="edad">Edad:</label>
                        <input type="number" class="form-control" id="edad" name="edad" required>
                    </div>

                    <div class="form-group">
                        <label for="peso">Peso:</label>
                        <input type="number" class="form-control" id="peso" name="peso" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo_sangre">Tipo de Sangre:</label>
                        <input type="text" class="form-control" id="tipo_sangre" name="tipo_sangre" required>
                    </div>

                    <div class="form-group">
                        <label for="altura">Altura:</label>
                        <input type="number" class="form-control" id="altura" name="altura" required>
                    </div>

                    <div class="form-group">
                        <label for="alergias">Alergias:</label>
                        <textarea class="form-control" id="alergias" name="alergias"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Registrar Datos Médicos</button>
                    </div>
                </form>

                <div id="modificarContainer" style="display:none;">
                    <h5>Datos Médicos Existentes</h5>
                    <p>Edad: <span id="edadExistente"></span></p>
                    <p>Peso: <span id="pesoExistente"></span></p>
                    <p>Tipo de Sangre: <span id="tipoSangreExistente"></span></p>
                    <p>Altura: <span id="alturaExistente"></span></p>
                    <p>Alergias: <span id="alergiasExistente"></span></p>
                    <p>Fecha de Nacimiento: <span id="fechaNacimientoExistente"></span></p>
                    <button class="btn btn-warning" id="btnModificar" onclick="activarModificar()">Modificar Datos Médicos</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cargarDatosMedicos(pacienteId) {
        // Mostrar el formulario de datos médicos
        document.getElementById('pacienteId').value = pacienteId;

        // Realizar una solicitud AJAX para cargar los datos médicos del paciente
        fetch(`../../controllers/Medicos/obtener_datos_medicos.php?id=${pacienteId}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    // Llenar los campos con datos existentes
                    document.getElementById('edadExistente').innerText = data.edad || 'No registrado';
                    document.getElementById('pesoExistente').innerText = data.peso || 'No registrado';
                    document.getElementById('tipoSangreExistente').innerText = data.tipo_sangre || 'No registrado';
                    document.getElementById('alturaExistente').innerText = data.altura || 'No registrado';
                    document.getElementById('alergiasExistente').innerText = data.alergias || 'No registrado';
                    document.getElementById('fechaNacimientoExistente').innerText = data.fecha_nacimiento || 'No registrado';

                    // Mostrar el contenedor de datos médicos
                    document.getElementById('datosMedicosContainer').style.display = 'block';

                    // Mostrar modificar si hay datos existentes
                    if (data.edad || data.peso || data.tipo_sangre || data.altura || data.alergias || data.fecha_nacimiento) {
                        // Llenar los campos del formulario para modificar
                        document.getElementById('edad').value = data.edad || '';
                        document.getElementById('peso').value = data.peso || '';
                        document.getElementById('tipo_sangre').value = data.tipo_sangre || '';
                        document.getElementById('altura').value = data.altura || '';
                        document.getElementById('alergias').value = data.alergias || '';
                        document.getElementById('fecha_nacimiento').value = data.fecha_nacimiento || '';

                        // Mostrar contenedor de modificación y ocultar el formulario de registro
                        document.getElementById('modificarContainer').style.display = 'block';
                        document.getElementById('datosMedicosForm').style.display = 'none';

                        // Cambiar el texto del botón a "Modificar Datos Médicos"
                        document.getElementById('submitBtn').innerText = 'Modificar Datos Médicos';
                    } else {
                        // Si no hay datos, mostrar el formulario para registrar
                        document.getElementById('modificarContainer').style.display = 'none';
                        document.getElementById('datosMedicosForm').style.display = 'block';

                        // Cambiar el texto del botón a "Registrar Datos Médicos"
                        document.getElementById('submitBtn').innerText = 'Registrar Datos Médicos';
                    }
                } else {
                    alert('No se encontraron datos médicos para este paciente.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error al cargar los datos médicos.");
            });
    }

    function activarModificar() {
        // Hacer visibles los campos del formulario para modificar datos
        document.getElementById('modificarContainer').style.display = 'none';
        document.getElementById('datosMedicosForm').style.display = 'block';
    }
</script>

<?php require '../partials/footer.php'; ?>
